<?php

namespace App\Services\GameFinal;

use App\Events\GameFinal\GameStateChanged;
use Pusher\Pusher;

class GameRealtimeService
{
    protected $runtime;

    public function __construct(GameRuntimeService $runtime)
    {
        $this->runtime = $runtime;
        $runtime->applyToConfig();
    }

    public function broadcastState($gameCode, array $payload)
    {
        $payload['game_key'] = $payload['game_key'] ?? $gameCode;
        $payload['room_key'] = $payload['room_key'] ?? $gameCode;
        $payload['config_version'] = $payload['config_version'] ?? (int) config('bd_game_final.realtime.config_version', 1);
        $payload['config_updated_at'] = $payload['config_updated_at'] ?? config('bd_game_final.realtime.config_updated_at');

        if ((string) config('bd_game_final.realtime.mode', 'polling') === 'polling' || !config('bd_game_final.realtime.enabled', true)) {
            return false;
        }
        return (string) config('bd_game_final.realtime.mode', 'polling') === 'pusher'
            ? $this->broadcastWithPusherRotation($gameCode, $payload)
            : $this->broadcastWithLaravel($gameCode, $payload);
    }

    protected function broadcastWithLaravel($gameCode, array $payload): bool
    {
        try {
            event(new GameStateChanged($gameCode, $payload));

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    protected function broadcastWithPusherRotation($gameCode, array $payload): bool
    {
        $settings = $this->runtime->settings();
        $accounts = $this->runtime->pusherAccounts($settings);
        if (!$accounts) {
            $this->runtime->markPusherCredentialFailed(0, 'No configured Pusher credentials.');

            return false;
        }

        $failed = is_array($settings['pusher_failed_indexes'] ?? null) ? array_map('intval', $settings['pusher_failed_indexes']) : [];
        $activeIndex = (int) ($settings['pusher_active_index'] ?? 0);
        $orderedIndexes = array_values(array_unique(array_merge([$activeIndex], array_keys($accounts))));
        $lastError = null;

        foreach ($orderedIndexes as $index) {
            if (!isset($accounts[$index]) || in_array((int) $index, $failed, true)) {
                continue;
            }

            try {
                $this->pusherClient($accounts[$index])->trigger(
                    (string) config('bd_game_final.realtime.channel_prefix', 'bdgamefinal.') . $gameCode,
                    (string) config('bd_game_final.realtime.broadcast_event', 'bd.game.state'),
                    $payload
                );

                if ($index !== $activeIndex) {
                    $this->runtime->update(['pusher_active_index' => (int) $index]);
                }

                return true;
            } catch (\Throwable $e) {
                $lastError = $e->getMessage();
                $this->runtime->markPusherCredentialFailed((int) $index, $lastError);
                $settings = $this->runtime->settings();
                $failed = is_array($settings['pusher_failed_indexes'] ?? null) ? array_map('intval', $settings['pusher_failed_indexes']) : [];
            }
        }

        $this->runtime->markPusherCredentialFailed($activeIndex, $lastError ?: 'Pusher publish failed.');

        return false;
    }

    protected function pusherClient(array $account): Pusher
    {
        $scheme = (string) ($account['scheme'] ?? 'https');
        $options = array_filter([
            'cluster' => (string) ($account['cluster'] ?? 'mt1'),
            'useTLS' => $scheme === 'https',
            'encrypted' => $scheme === 'https',
            'host' => (string) ($account['host'] ?? ''),
            'port' => (int) ($account['port'] ?? ($scheme === 'https' ? 443 : 80)),
            'scheme' => $scheme,
            'timeout' => 10,
        ], static function ($value) {
            return $value !== null && $value !== '';
        });

        return new Pusher(
            (string) $account['key'],
            (string) $account['secret'],
            (string) $account['app_id'],
            $options
        );
    }
}
