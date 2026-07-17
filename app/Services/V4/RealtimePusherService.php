<?php

namespace App\Services\V4;

use App\Models\PusherKey;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;

class RealtimePusherService
{
    public const ACCOUNT_CHANGED_EVENT = 'pusher_account_changed';

    private const ACCOUNT_SWITCH_LOCK = 'pusher-switch-global-lock';
    private const SETTING_CACHE_KEY = 'realtime_pusher_setting';
    private const SETTING_CACHE_SECONDS = 10;

    private const CONTROL_CHANNELS = [
        'video_call_host_list',
        'audio_call_host_list',
        'video_host_call_remove',
        'audio_host_call_remove',
        'Kick',
        'audio_kick',
        'fly_comment',
        'golbal_gift_banner',
        'coin_beg',
        'chat',
    ];

    public function trigger($response, $roomName, $channelName)
    {
        if (empty($roomName) || empty($channelName) || !is_string($channelName)) {
            return false;
        }

        $setting = $this->getSetting();
        if (!$setting) {
            Log::error('Pusher setting row missing');
            return false;
        }

        try {
            return $this->triggerWithSetting($setting, $roomName, $channelName, $response);
        } catch (\Throwable $exception) {
            Log::warning('Pusher trigger failed, attempting account switch', [
                'roomName' => $roomName,
                'channelName' => $channelName,
                'error' => $exception->getMessage(),
            ]);

            $switched = $this->switchPusherAccount($setting, $roomName, $channelName);
            if (!$switched) {
                return false;
            }

            $this->forgetSettingCaches();
            $newSetting = $this->getSetting();
            if (!$newSetting) {
                return false;
            }

            try {
                return $this->triggerWithSetting($newSetting, $roomName, $channelName, $response);
            } catch (\Throwable $retryException) {
                Log::error('Pusher trigger failed after account switch', [
                    'roomName' => $roomName,
                    'channelName' => $channelName,
                    'error' => $retryException->getMessage(),
                ]);

                return false;
            }
        }
    }

    private function triggerWithSetting(Setting $setting, $roomName, $channelName, $response)
    {
        return $this->makePusher($setting)->trigger($roomName, $channelName, $response);
    }

    private function makePusher(Setting $setting)
    {
        return new Pusher(
            $setting->key,
            $setting->secret,
            $setting->app_id,
            [
                'cluster' => $setting->cluster,
                'useTLS' => true,
                'curl_options' => [
                    CURLOPT_CONNECTTIMEOUT => 2,
                    CURLOPT_TIMEOUT => 4,
                ],
            ]
        );
    }

    private function getSetting()
    {
        return Cache::remember(self::SETTING_CACHE_KEY, self::SETTING_CACHE_SECONDS, function () {
            return Setting::select(
                'id',
                'pusher_id',
                'key',
                'secret',
                'app_id',
                'cluster',
                'web_socket'
            )->find(1);
        });
    }

    private function forgetSettingCaches()
    {
        Cache::forget(self::SETTING_CACHE_KEY);
        Cache::forget('pusher_settings');
    }

    private function switchPusherAccount(Setting $oldSetting, $roomName, $channelName)
    {
        return Cache::lock(self::ACCOUNT_SWITCH_LOCK, 8)->block(2, function () use ($oldSetting, $roomName, $channelName) {
            $current = $oldSetting->pusher_id ? PusherKey::find($oldSetting->pusher_id) : null;

            if ($current && $current->pusher_active_time) {
                $activeDuration = now()->diffInSeconds($current->pusher_active_time);
                if ($activeDuration < 60) {
                    return false;
                }
            }

            try {
                DB::transaction(function () use ($current) {
                    if ($current) {
                        $current->update([
                            'pusher_status' => 2,
                            'pusher_deactive_time' => now(),
                        ]);
                    }

                    $nextPusher = PusherKey::where('pusher_status', 0)
                        ->where('used_for', 1)
                        ->when($current, function ($query) use ($current) {
                            return $query->where('id', '>', $current->id);
                        })
                        ->orderBy('id', 'asc')
                        ->first();

                    if (!$nextPusher) {
                        $nextPusher = PusherKey::where('pusher_status', 0)
                            ->where('used_for', 1)
                            ->orderBy('id', 'asc')
                            ->first();
                    }

                    if (!$nextPusher) {
                        throw new \RuntimeException('No available Pusher accounts found');
                    }

                    $nextKey = $nextPusher->pusher_key;
                    $nextCluster = $nextPusher->pusher_cluster;
                    $nextWebSocket = $nextPusher->web_socket
                        ?: $this->buildWebSocketUrl($nextKey, $nextCluster);

                    Setting::where('id', 1)->update([
                        'pusher_id' => $nextPusher->id,
                        'key' => $nextKey,
                        'secret' => $nextPusher->pusher_secret,
                        'app_id' => $nextPusher->puser_app_id ?: $nextPusher->pusher_app_id,
                        'cluster' => $nextCluster,
                        'web_socket' => $nextWebSocket,
                    ]);

                    $nextPusher->update([
                        'pusher_active_time' => now(),
                        'pusher_status' => 1,
                    ]);
                });

                $this->forgetSettingCaches();
                $newSetting = $this->getSetting();
                if ($newSetting) {
                    $this->notifyClientsToReconnect($oldSetting, $newSetting, $roomName, $channelName);
                }

                return true;
            } catch (\Throwable $exception) {
                Log::error('Failed to switch Pusher account', [
                    'error' => $exception->getMessage(),
                ]);

                return false;
            }
        });
    }

    private function buildWebSocketUrl($key, $cluster)
    {
        if (!$key || !$cluster) {
            return null;
        }

        return "wss://ws-{$cluster}.pusher.com/app/{$key}?protocol=7&client=js&version=8.4.0&flash=false";
    }

    private function notifyClientsToReconnect(Setting $oldSetting, Setting $newSetting, $roomName, $channelName)
    {
        $payload = [[
            'message' => self::ACCOUNT_CHANGED_EVENT,
            'code' => '200',
            'pusher_key' => $newSetting->key,
            'pusher_cluster' => $newSetting->cluster,
            'pusher_app_id' => $newSetting->app_id,
            'web_socket' => $newSetting->web_socket,
            'channelName' => $channelName,
        ]];

        try {
            $oldPusher = $this->makePusher($oldSetting);

            foreach (self::CONTROL_CHANNELS as $channel) {
                $oldPusher->trigger($channel, self::ACCOUNT_CHANGED_EVENT, $payload);
            }

            $oldPusher->trigger($roomName, $channelName, $payload);
        } catch (\Throwable $exception) {
            Log::warning('Failed to notify old Pusher clients about account switch', [
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
