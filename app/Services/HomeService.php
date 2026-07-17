<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
class HomeService
{
   
    // -----------------------------------------------------
    // FAST BAN MESSAGE
    // -----------------------------------------------------
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


    // -----------------------------------------------------
    // DELETE USER LIVES FAST (AUTO REMOVE CHILD DATA)
    // -----------------------------------------------------
    public function clearUserLivesFast(int $userId): void
    {
        // If your DB has ON DELETE CASCADE, this removes everything in one query
        DB::table('user_lives')->where('user_id', $userId)->delete();
    }


    // -----------------------------------------------------
    // GET LIVE DATA (HIGH SPEED)
    // -----------------------------------------------------
  public function getLivesFast(int $typeFilter = 0)
{
    return DB::table('user_lives')
        ->join('users', 'users.id', '=', 'user_lives.user_id')
        ->select(
            'users.id', 'users.name', 'users.level', 'users.balance', 'users.profile',
            'users.host_badge', 'user_lives.token', 'user_lives.channelName',
            'user_lives.type', 'user_lives.backgorund', 'user_lives.notice',
            'user_lives.bullet_notice', 'user_lives.pin', 'user_lives.audio_brd_design',
            'user_lives.sdk','user_lives.appCertificate','user_lives.appId','siteNumber',
            'user_lives.top_value'
        )
        ->when($typeFilter === 1, function ($q) {
            $q->where('user_lives.type', 1);
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
}



    // -----------------------------------------------------
    // GET HOME PAGE DATA
    // -----------------------------------------------------
    public function getHomePageData(object $user)
    {
        // ---- SLIDER (CACHE 1 MINUTE)
        $slider = Cache::remember("sliders_cache", 10, function () {
            return DB::table('sliders')->select('id', 'image')->orderByDesc('id')->get();
        });

        // ---- INVITE POPUP
        $deviceLock = DB::table('device_lock_invites')
            ->where('device_id', $user->device_id)
            ->first();

        $invitePopup = ($deviceLock && !$user->invite_done) ? 1 : 0;

        // ---- COMMENT SKIPS (CACHE 2 MINUTES)
$commentSkips = Cache::remember('comment_skips', 432000, function () {
    return DB::table('bed_words')->pluck('word');
});

        // ---- LIVES NOW
        $livesNow = $this->getLivesFast();

        // ---- TOP 2 LIVES (CACHE 10 sec)
        $topLive = Cache::remember("top_live", 10, function () {
            return DB::table('user_lives')
                ->join('users', 'users.id', '=', 'user_lives.user_id')
                ->orderByDesc('user_lives.top_value')
                ->limit(2)
                ->select(
                    'users.id', 'users.name', 'users.level', 'users.balance', 'users.profile',
                    'users.host_badge', 'user_lives.token', 'user_lives.channelName',
                    'user_lives.type', 'user_lives.backgorund', 'user_lives.notice',
                    'user_lives.bullet_notice', 'user_lives.pin', 'user_lives.audio_brd_design',
                    'user_lives.sdk','user_lives.appCertificate','user_lives.appId','siteNumber'
                )
                ->get();
        });

        // ---- FOLLOWER LIVES
        $followerLive = DB::table('followers')
            ->join('users as follower', 'follower.id', '=', 'followers.follower_id')
            ->leftJoin('user_lives', 'user_lives.user_id', '=', 'followers.follower_id')
            ->where('followers.user_id', $user->id)
            ->select(
                'follower.id', 'follower.name', 'follower.level', 'follower.balance', 'follower.profile',
                'user_lives.token', 'user_lives.channelName', 'user_lives.type',
                'user_lives.backgorund', 'user_lives.notice', 'user_lives.bullet_notice',
                'user_lives.pin', 'user_lives.audio_brd_design','user_lives.sdk','user_lives.appCertificate','user_lives.appId','siteNumber'
            )
            ->get();

        // ---- PUSHER SETTINGS (CACHE 5 MIN)
        $setting = Cache::remember("pusher_settings", 300, fn() =>
            DB::table('settings')->select('key', 'secret', 'app_id', 'cluster')->first()
        );

        // ---- HOST TYPE
       $hostType = Cache::remember("host_type_{$user->id}", 60, function () use ($user) {
        return User::with('hostData')->find($user->id)->hostData->hosting_type ?? 0;
        });


        // ---- FINAL RESPONSE
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
