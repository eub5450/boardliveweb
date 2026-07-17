<?php

namespace App\Services\V4;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HomeService
{
    public function fastBanMessage(string $banType): string
    {
        $messages = [
            'B' => 'Opps !! Your ID is banned for One Month. Violation Rules B',
            'C' => 'Opps !! Your ID is banned for 24 Hours. Violation Rules C',
            'D' => 'Opps !! Your ID is banned for 1 Hour. Violation Rules D',
            'default' => 'Opps !! You Are Permanently Banned. Violation Rules A',
        ];

        return $messages[$banType] ?? $messages['default'];
    }

    public function clearUserLivesFast(int $userId): void
    {
        DB::table('user_lives')->where('user_id', $userId)->delete();
        $this->forgetLiveCaches($userId);
    }

    public function getLivesFast(int $typeFilter = 0)
    {
        return Cache::remember("live_list_fast_{$typeFilter}", 3, function () use ($typeFilter) {
            return DB::table('user_lives')
                ->join('users', 'users.id', '=', 'user_lives.user_id')
                ->select(
                    'users.id',
                    'users.name',
                    'users.level',
                    'users.balance',
                    'users.profile',
                    'users.host_badge',
                    'user_lives.token',
                    'user_lives.channelName',
                    'user_lives.type',
                    'user_lives.backgorund',
                    'user_lives.notice',
                    'user_lives.bullet_notice',
                    'user_lives.pin',
                    'user_lives.audio_brd_design',
                    'user_lives.sdk',
                    'user_lives.appCertificate',
                    'user_lives.appId',
                    'siteNumber',
                    'user_lives.top_value'
                )
                ->when($typeFilter === 1, function ($query) {
                    $query->where('user_lives.type', 1);
                })
                ->orderByRaw("
                    CASE
                        WHEN user_lives.type = 2 THEN 0
                        WHEN user_lives.type = 1 THEN 1
                        ELSE 2
                    END
                ")
                ->orderByDesc('user_lives.top_value')
                ->limit(200)
                ->get();
        });
    }

    public function getFollowerLivesFast(int $userId)
    {
        return Cache::remember("v4:home:follower_live:{$userId}", 10, function () use ($userId) {
            return DB::table('followers')
                ->join('users as follower', 'follower.id', '=', 'followers.follower_id')
                ->join('user_lives', 'user_lives.user_id', '=', 'followers.follower_id')
                ->where('followers.user_id', $userId)
                ->select(
                    'follower.id',
                    'follower.name',
                    'follower.level',
                    'follower.balance',
                    'follower.profile',
                    'follower.host_badge',
                    'user_lives.token',
                    'user_lives.channelName',
                    'user_lives.type',
                    'user_lives.backgorund',
                    'user_lives.notice',
                    'user_lives.bullet_notice',
                    'user_lives.pin',
                    'user_lives.audio_brd_design',
                    'user_lives.sdk',
                    'user_lives.appCertificate',
                    'user_lives.appId',
                    'siteNumber',
                    'user_lives.top_value'
                )
                ->orderByDesc('user_lives.top_value')
                ->limit(50)
                ->get();
        });
    }

    public function forgetLiveCaches(?int $userId = null): void
    {
        V4CacheService::forgetLiveLists($userId);
    }

    public function getHomePageData(object $user): array
    {
        $slider = Cache::remember('sliders_cache', 10, function () {
            return DB::table('sliders')->select('id', 'image')->orderByDesc('id')->get();
        });

        $deviceLock = DB::table('device_lock_invites')
            ->where('device_id', $user->device_id)
            ->first();

        $invitePopup = ($deviceLock && !$user->invite_done) ? 1 : 0;

        $commentSkips = Cache::remember('comment_skips', 432000, function () {
            return DB::table('bed_words')->pluck('word');
        });

        $livesNow = $this->getLivesFast();

        $topLive = Cache::remember('top_live', 10, function () {
            return DB::table('user_lives')
                ->join('users', 'users.id', '=', 'user_lives.user_id')
                ->orderByDesc('user_lives.top_value')
                ->limit(2)
                ->select(
                    'users.id',
                    'users.name',
                    'users.level',
                    'users.balance',
                    'users.profile',
                    'users.host_badge',
                    'user_lives.token',
                    'user_lives.channelName',
                    'user_lives.type',
                    'user_lives.backgorund',
                    'user_lives.notice',
                    'user_lives.bullet_notice',
                    'user_lives.pin',
                    'user_lives.audio_brd_design',
                    'user_lives.sdk',
                    'user_lives.appCertificate',
                    'user_lives.appId',
                    'siteNumber'
                )
                ->get();
        });

        $followerLive = $this->getFollowerLivesFast((int) $user->id);

        $setting = Cache::remember('pusher_settings', 300, function () {
            return DB::table('settings')->select('key', 'secret', 'app_id', 'cluster')->first();
        });

        $hostType = Cache::remember("host_type_{$user->id}", 60, function () use ($user) {
            return User::with('hostData')->find($user->id)->hostData->hosting_type ?? 0;
        });

        $userArray = (array) $user;
        $userArray['host_type'] = $hostType;

        return [
            'user' => $userArray,
            'lives_now' => $livesNow,
            'top_live' => $topLive,
            'slider' => $slider,
            'invite_popup' => $invitePopup,
            'comment_skips' => $commentSkips,
            'follower_live' => $followerLive,
            'pusher' => $setting ? (array) $setting : [],
        ];
    }
}
