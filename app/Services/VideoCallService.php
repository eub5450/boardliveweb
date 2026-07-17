<?php

namespace App\Services;

use App\Models\User;
use App\Models\LiveCall;
use App\Models\Gift;
use App\Models\Withdraw;
use App\Models\UserLive;
use App\Helpers\StarHelper;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class VideoCallService
{
    /*
    |--------------------------------------------------------------------------
    | ACCEPT CALL (AUTO CACHE CLEAR)
    |--------------------------------------------------------------------------
    */
    public function acceptCall($host_id, $co_host_id, $channelName)
    {
        $check = LiveCall::where('host_id', $host_id)
            ->where('channelName', $channelName)
            ->where('status', 'Accept')
            ->count();

        if ($check >= 3) {
            return ['error' => 'limit'];
        }

        LiveCall::where([
            'host_id' => $host_id,
            'co_host_id' => $co_host_id,
            'channelName' => $channelName,
            'status' => 'pending'
        ])->update(['status' => 'Accept']);

        $this->clearCache($host_id, $channelName);

        return ['success' => true];
    }

    /*
    |--------------------------------------------------------------------------
    | MUTE / UNMUTE CALL (AUTO CACHE CLEAR)
    |--------------------------------------------------------------------------
    */
    public function muteCall($host_id, $co_host_id, $channelName, $mute_status)
    {
        LiveCall::where([
            'channelName' => $channelName,
            'co_host_id' => $co_host_id,
            'host_id' => $host_id,
            'status' => 'Accept'
        ])->update(['mute' => $mute_status]);

        $this->clearCache($host_id, $channelName);
    }

    /*
    |--------------------------------------------------------------------------
    | HOST + CO-HOST LIST (CACHED)
    |--------------------------------------------------------------------------
    */
    public function getHostAndCoHostList($host_id, $channelName)
    {
        return Cache::remember(
            "video_call_list_{$host_id}_{$channelName}",
            now()->addSeconds(10),
            function () use ($host_id, $channelName) {

                $host = User::with('hostLive')->find($host_id);

                $accept_list = LiveCall::with('coHost')
                    ->where('host_id', $host_id)
                    ->where('channelName', $channelName)
                    ->where('status', 'Accept')
                    ->get();

                $list = [];
                $co_host_list = [];

                // Host data
                $list[] = [
                    'channelName' => $channelName,
                    'profile' => $host->profile,
                    'is_vip' => $host->is_vip,
                    'balance' => $host->giftsReceived()
                        ->where('channelName', $channelName)
                        ->sum('value'),
                    'co_host_name' => $host->name,
                    'set_no' => "0",
                    'mute' => optional($host->hostLive)->mute ?? 0,
                    'frame' => strval($host->frame),
                    'co_host_id' => strval($host->id),
                    'co_host_status' => 'Accept'
                ];

                // Co-host data
                foreach ($accept_list as $call) {
                    $co = $call->coHost;

                    $row = [
                        'channelName' => $channelName,
                        'profile' => $co->profile,
                        'is_vip' => $co->is_vip,
                        'balance' => $co->giftsReceived()
                            ->where('channelName', $channelName)
                            ->sum('value'),
                        'co_host_name' => $co->name,
                        'set_no' => "0",
                        'mute' => $call->mute,
                        'frame' => strval($co->frame),
                        'co_host_id' => strval($co->id),
                        'co_host_status' => strval($call->is_co_host_active),
                    ];

                    $list[] = $row;
                    $co_host_list[] = $row;
                }

                return [$list, $co_host_list];
            }
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HOST BALANCE (CACHED)
    |--------------------------------------------------------------------------
    */
    public function getHostBalance($host)
    {
        return Cache::remember(
            "video_call_balance_{$host->id}",
            now()->addSeconds(10),
            function () use ($host) {

                $date = now();

                if ($date->day <= 15) {
                    $start = now()->startOfMonth();
                    $end   = now()->startOfMonth()->addDays(14);
                } else {
                    $start = now()->startOfMonth()->addDays(15);
                    $end   = now()->endOfMonth();
                }

                $gift = $host->giftsReceived()
                    ->whereBetween('date', [$start, $end])
                    ->sum('value');

                $withdraw = $host->withdraws()
                    ->whereBetween('date', [$start, $end])
                    ->sum('total');

                return ($host->previous_coin + $gift) - $withdraw;
            }
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE SENDER LEVEL
    |--------------------------------------------------------------------------
    */
    public function updateSenderLevel($user_id)
    {
        $user = User::find($user_id);
        if (!$user) return;

        $total = Gift::where('sander_id', $user_id)->sum('value');

        $levelBoundaries = [
            2 => [10000, 50000],
            3 => [50001, 100000],
            4 => [100001, 150000],
            5 => [150001, 200000],
            6 => [200001, 400000],
            7 => [400001, 600000],
            8 => [600001, 800000],
            9 => [800001, 1000000],
            10 => [1000001, 1200000],
            11 => [1200001, 2200000],
            12 => [2200001, 3200000],
            13 => [3200001, 4200000],
            14 => [4200001, 5200000],
            15 => [5200001, 6200000],
            16 => [6200001, 8200000],
            17 => [8200001, 10200000],
            18 => [10200001, 12200000],
            19 => [12200001, 14200000],
            20 => [14200001, 16200000],
            21 => [16200001, 19200000],
            22 => [19200001, 22200000],
            23 => [22200001, 25200000],
            24 => [25200001, 28200000],
            25 => [28200001, 31200000],
            26 => [31200001, 40000000],
            27 => [40000001, 50000000],
            28 => [50000001, 60000000],
            29 => [60000001, 70000000],
            30 => [70000001, 80000000],
            31 => [80000001, 100000000],
            32 => [100000001, 120000000],
            33 => [120000001, 140000000],
            34 => [140000001, 160000000],
            35 => [160000001, 180000000],
            36 => [180000001, 200000000],
            37 => [200000001, 220000000],
            38 => [220000001, 240000000],
            39 => [240000001, 260000000],
            40 => [260000001, 280000000],
            41 => [280000001, 330000000],
            42 => [330000001, 380000000],
            43 => [380000001, 430000000],
            44 => [430000001, 480000000],
            45 => [480000001, 530000000],
            46 => [530000001, 580000000],
            47 => [580000001, 630000000],
            48 => [630000001, 680000000],
            49 => [680000001, 730000000],
        ];

        $level = 1;
        foreach ($levelBoundaries as $lvl => $boundary) {
            if ($total >= $boundary[0] && $total < $boundary[1]) {
                $level = $lvl;
                break;
            }
        }

        $user->level = $level;
        $user->save();
    }

    /*
    |--------------------------------------------------------------------------
    | PUSH GLOBAL GIFT BANNER
    |--------------------------------------------------------------------------
    */
    public function pushGlobalGiftBanner($channelName, $sender, $value, $receiver_name)
    {
        $roomName = 'golbal_gift_banner';
        $message = [
            'message' => "{$sender->name} sent {$value} to {$receiver_name}",
            'image' => $sender->profile,
            'name' => $sender->name
        ];

        $this::RealTime([$message], $roomName, $channelName);
    }

    /*
    |--------------------------------------------------------------------------
    | PUSH GIFT COMMENT TO FIREBASE
    |--------------------------------------------------------------------------
    */
    public function pushGiftCommentToFirebase($channelName, $sender, $message)
    {
        $gift_comment = [
            'balance' => strval($sender->balance),
            'channelName' => strval($channelName),
            'id' => $sender->id,
            'message' => strval('@'.$message),
            'level' => strval($sender->level),
            'name' => strval($sender->name),
            'profile' => strval($sender->profile),
            'is_vip' => strval($sender->is_vip),
            'frame' => strval($sender->frame),
            'is_official_id' => strval($sender->is_official_id),
            'is_agency' => strval($sender->is_agency),
            'is_host_id' => strval($sender->is_host_id),
            'comment_badge' => strval($sender->comment_badge),
            'type' => "message",
        ];

        $comments_ref = app('firebase.database')->getReference('Comments/'.$channelName);
        $existing_comments = $comments_ref->getValue();
        $next_index = is_array($existing_comments) ? count($existing_comments) : 0;

        $comments_ref->getChild($next_index)->set($gift_comment);
    }

    /*
    |--------------------------------------------------------------------------
    | REAL TIME PUSH HELPER
    |--------------------------------------------------------------------------
    */
    public static function RealTime($data, $roomName, $channelName)
    {
        // Example: your existing WebSocket / Pusher call
        // You can implement this according to your WebSocket setup
    }

    /*
    |--------------------------------------------------------------------------
    | CLEAR CACHE
    |--------------------------------------------------------------------------
    */
    protected function clearCache($host_id, $channelName)
    {
        Cache::forget("video_call_list_{$host_id}_{$channelName}");
        Cache::forget("video_call_balance_{$host_id}");
    }
}
