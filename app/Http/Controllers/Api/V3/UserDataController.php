<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Carbon\Carbon;
use App\Models\Kick;
use App\Models\Gift;
use App\Models\Follower;
use App\Models\Slider;
use App\Models\Withdraw;

class UserDataController extends Controller
{
   public function Index(Request $request)
{
    $response = [];

    $token = $request->access_token;
    $user_id = $request->user_id;
    $host_id = $request->host_id;

    if ($token !== "0411f0028cfb768b3a3d96ac3aa37dw3e5") {
        return response()->json([
            'message' => 'Unauthorized',
            'code'    => '401'
        ]);
    }

    $user   = User::find($user_id);
    $host   = User::find($host_id);

    if (!$user || !$host) {
        return response()->json([
            'message' => 'Invalid User',
            'code'    => '404'
        ]);
    }

    // ----------------------------
    // FAST DATE RANGE
    // ----------------------------
    $date = now();
    $start_date = $date->format('Y-m') . '-01';
    $end_date = $date->endOfMonth()->format('Y-m-d');

    // ----------------------------
    // IS HOST?
    // ----------------------------
    $host_info = DB::table('host_data')
        ->join('agencies', 'agencies.code', '=', 'host_data.agency_code')
        ->where('host_data.user_id', $user_id)
        ->select('agencies.name')
        ->first();

    $host_type  = 1;
    $agency_name = $host_info->name ?? '';

    // ----------------------------
    // GIFTS (1 QUERY ONLY)
    // ----------------------------
    $giftQuery = DB::table('gifts')
        ->where('reciever_id', $host_id)
        ->whereBetween('date', [$start_date, $end_date]);

    $total_gift_coin = $giftQuery->sum('value');

    // ----------------------------
    // WITHDRAWALS (1 QUERY)
    // ----------------------------
    $total_withdraw = Withdraw::where('host_id', $host_id)
        ->whereBetween('date', [$start_date, $end_date])
        ->sum('total');

    // BALANCE
    $balance = ($user->previous_coin + $total_gift_coin) - $total_withdraw;

    // ----------------------------
    // FOLLOW STATUS (extremely fast)
    // ----------------------------
    $isFollowing  = Follower::where('user_id', $user_id)->where('follower_id', $host_id)->exists();
    $isFollowBack = Follower::where('user_id', $host_id)->where('follower_id', $user_id)->exists();

    $follow_status = ($isFollowing && $isFollowBack) ? 2 : ($isFollowing ? 1 : 0);
    $is_i_follow   = $follow_status;
    $total_followers = Follower::where('user_id', $host_id)->count();
    $latest_followers = Follower::where('user_id', $host_id)
        ->join('users', 'users.id', '=', 'followers.follower_id')
        ->select('users.profile')
        ->orderBy('followers.id', 'desc')
        ->limit(5)
        ->get();

    // ----------------------------
    // SENDING / RECEIVING TOTAL (2 queries)
    // ----------------------------
    $total_sanding   = Gift::where('sander_id', $user_id)->sum('value');
    $total_receiving = Gift::where('reciever_id', $user_id)->sum('value');

    // ----------------------------
    // SLIDER
    // ----------------------------
    $slider = Slider::orderBy('id', 'desc')->get();

    // ----------------------------
    // KICK DATA
    // ----------------------------
    $kick_data = Kick::where('user_id', $user_id)->get();

    // ----------------------------
    // RESPONSE
    // ----------------------------
    $response[] = [
        'message'               => 'User Data Loaded Successfully',
        'code'                  => '200',
        'data'                  => $user,
        'follow_status'         => $follow_status,
        'balance'               => $balance,
        'total_sanding'         => strval($total_sanding),
        'total_receiving'       => strval($total_receiving),
        'agency_name'           => $agency_name,
        'host_type'             => $host_type,
        'marchent'              => $user->is_agency,
        'is_coin_protal_active' => $user->is_coin_protal_active,
        'kick_data'             => $kick_data,
        'is_i_follow'           => $is_i_follow,
        'slider'                => $slider,
        'is_vip'                => $user->is_vip,
        'frame'                 => $user->frame,
        'entry_effect'          => $user->entry,

        // NEW DATA ADDED:
        'total_followers'       => $total_followers,
        'latest_followers'      => $latest_followers
    ];

    return response()->json($response, JSON_UNESCAPED_UNICODE);
}

    public function HostType(Request $request)
{
    $response = array();
    $token = $request->access_token;
    $user_id = $request->user_id;

    if($token == "0411f0028cfb768b3a3d96ac3aa37dw3e5") {
        // value() method returns value directly, not object
        $host_type = DB::table('host_data')
            ->join('users', 'users.id', '=', 'host_data.user_id')
            ->where('users.is_host_id', 1)
            ->where('users.id', $user_id)
            ->value('host_data.hosting_type');

        // Keep original effective behavior
        $host_type = '1';

        info('$hostType: ' . $host_type . ' -- user_id: ' . $user_id);

        array_push($response, array(
            'message' => 'Host Type Show Successfully',
            'code' => '200',
            'host_type' => $host_type,
            'sdk_type' => "1"
        ));

        return json_encode($response, JSON_UNESCAPED_UNICODE);
    } else {
        array_push($response, array(
            'message' => 'Unauthorized',
            'code' => '401'
        ));
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}
}
