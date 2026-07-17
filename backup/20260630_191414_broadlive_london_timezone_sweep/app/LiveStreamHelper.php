<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Gift;
use App\Models\LiveCall;
use App\Models\UserLive;
use App\Models\Withdraw;
use Illuminate\Support\Facades\DB;

class LiveStreamHelper
{
    /**
     * Calculate host balance for current half-month period
     */
    public static function calculateHostBalance($host_id)
    {
        $date = Carbon::now(config('app.timezone', 'Asia/Dhaka'));
        $host_data = User::find($host_id);
        
        if (!$host_data) {
            return 0;
        }
        
        // Get date range for current half-month
        list($start_date, $end_date) = self::getHalfMonthDateRange();
        
        // Calculate total gifts for the period
        $total_gift_coin = Gift::where('reciever_id', $host_id)
            ->whereDate('date', '>=', $start_date)
            ->whereDate('date', '<=', $end_date)
            ->sum('value');
        
        // Calculate total withdrawals for the period
        $total_withdraw = Withdraw::where('host_id', $host_id)
            ->whereDate('date', '>=', $start_date)
            ->whereDate('date', '<=', $end_date)
            ->sum('total');
        
        // Return final balance
        return ($host_data->previous_coin + $total_gift_coin) - $total_withdraw;
    }
    
    /**
     * Get date range for current half-month
     */
    public static function getHalfMonthDateRange()
    {
        $date = Carbon::now(config('app.timezone', 'Asia/Dhaka'));

        return [
            $date->copy()->startOfMonth()->toDateString(),
            $date->copy()->endOfMonth()->toDateString(),
        ];
    }
    
    /**
     * Calculate star level based on today's gifts
     */
    public static function calculateStarLevel($host_id)
    {
        $today_gift = Gift::where('reciever_id', $host_id)
            ->whereDate('date', Carbon::now(config('app.timezone', 'Asia/Dhaka'))->toDateString())
            ->sum('value');
        
        $starRanges = [
            ['min' => 0, 'max' => 49999, 'star' => 1, 'next_level' => 50000],
            ['min' => 50000, 'max' => 199999, 'star' => 2, 'next_level' => 200000],
            ['min' => 200000, 'max' => 499999, 'star' => 3, 'next_level' => 500000],
            ['min' => 500000, 'max' => 999999, 'star' => 4, 'next_level' => 1000000],
            ['min' => 1000000, 'max' => 1999999, 'star' => 5, 'next_level' => 2000000],
            ['min' => 2000000, 'max' => 19999999, 'star' => 5, 'next_level' => 20000000],
        ];
        
        foreach ($starRanges as $range) {
            if ($today_gift >= $range['min'] && $today_gift <= $range['max']) {
                $star = $range['star'];
                $next_level_amount = $range['next_level'];
                $need_percent = $next_level_amount > 0 ? intval(($today_gift / $next_level_amount) * 100) : 100;
                
                return [
                    'star' => $star,
                    'star_complete_percent' => $need_percent,
                    'today_gift' => $today_gift,
                    'next_level_amount' => $next_level_amount
                ];
            }
        }
        
        // Default for very high amounts
        return [
            'star' => 5,
            'star_complete_percent' => 100,
            'today_gift' => $today_gift,
            'next_level_amount' => 20000000
        ];
    }
    
    /**
     * Generate host and co-host list for a channel
     */
    public static function generateHostList($channelName, $host_id)
    {
        $live = UserLive::where('channelName', $channelName)
            ->where('user_id', $host_id)
            ->first();
        
        $accept_list = LiveCall::where('channelName', $channelName)
            ->where('host_id', $host_id)
            ->where('status', 'Accept')
            ->get();
        
        $host_data = User::find($host_id);
        
        if (!$host_data) {
            return ['host_list' => [], 'co_host_list' => []];
        }
        
        $list = [];
        $co_host_list = [];
        
        // Add host
        $host = [
            'channelName' => $channelName,
            'profile' => $host_data->profile,
            'is_vip' => $host_data->is_vip,
            'balance' => Gift::where('reciever_id', $host_data->id)
                ->where('channelName', $channelName)
                ->sum('value'),
            'co_host_name' => $host_data->name,
            'set_no' => "0",
            'mute' => $live ? strval($live->mute) : strval(0),
            'frame' => strval($host_data->frame),
            'co_host_id' => strval($host_data->id),
            'co_host_status' => strval('Accept')
        ];
        $list[] = $host;
        
        // Add co-hosts
        foreach ($accept_list as $call) {
            $co_host = User::find($call->co_host_id);
            
            if (!$co_host) {
                continue;
            }
            
            $row = [
                'channelName' => $channelName,
                'profile' => $co_host->profile,
                'is_vip' => $co_host->is_vip,
                'balance' => Gift::where('reciever_id', $co_host->id)
                    ->where('channelName', $channelName)
                    ->sum('value'),
                'co_host_name' => $co_host->name,
                'set_no' => "0",
                'mute' => strval($call->mute),
                'frame' => strval($co_host->frame),
                'co_host_id' => strval($call->co_host_id),
                'co_host_status' => strval($call->is_co_host_active)
            ];
            $list[] = $row;
            $co_host_list[] = $row;
        }
        
        return [
            'host_list' => $list,
            'co_host_list' => $co_host_list
        ];
    }
    
    /**
     * Update call request count in Firebase
     */
    public static function updateCallRequestCount($channelName, $database)
    {
        $call_count = DB::table('live_calls')
            ->where('status', 'pending')
            ->where('channelName', $channelName)
            ->count();
        
        $count = ['call_count' => strval($call_count)];
        $push_count_ref = $database->getReference('call_request/' . $channelName);
        $push_count_ref->set($count);
        
        return $call_count;
    }
    
    /**
     * Get formatted response for video call operations
     */
    public static function getVideoCallResponse($channelName, $host_id, $message, $code = '200')
    {
        $host_list_data = self::generateHostList($channelName, $host_id);
        $host_balance = self::calculateHostBalance($host_id);
        $star_data = self::calculateStarLevel($host_id);
        
        return [
            'message' => $message,
            'host_list' => $host_list_data['host_list'],
            'co_host_list' => $host_list_data['co_host_list'],
            'host_balance' => $host_balance,
            'star' => $star_data['star'],
            'star_complete_percent' => $star_data['star_complete_percent'],
            'channelName' => $channelName,
            'code' => $code
        ];
    }
    
    /**
     * Check if user is banned
     */
    public static function checkUserBan($user_id)
    {
        $banned = User::where('ban_type', '!=', null)
            ->where('id', $user_id)
            ->first();
        
        if (!$banned) {
            return null;
        }
        
        $messages = [
            'B' => 'Opps !! Your ID Banned For One Month . violation Rules B',
            'C' => 'Opps !! Your ID Banned For 24 Hours . violation Rules C',
            'D' => 'Opps !! Your ID Banned For 1 Hours . violation Rules D',
            'A' => 'Opps !! You Are Permanent Banned . violation Rules A'
        ];
        
        $ban_type = $banned->ban_type ?? 'A';
        $message = $messages[$ban_type] ?? $messages['A'];
        
        return [
            'message' => $message,
            'code' => '404'
        ];
    }
    
    /**
     * Validate access token
     */
    public static function validateAccessToken($access_token)
    {
        return $access_token === "0411f0028cfb768b3a3d96ac3aa37dw3e5";
    }
    
    /**
     * Get user data with follow status
     */
    public static function getUserData($user_id, $host_id)
    {
        $data = User::find($user_id);
        
        if (!$data) {
            return null;
        }
        
        if ($host_id == $user_id) {
            $follow_status = 0;
        } else {
            $follower = User::find($host_id);
            
            if (!$follower) {
                $follow_status = 0;
            } else {
                $isFollowing = $data->following()->where('follower_id', $follower->id)->exists();
                $isFollowedBy = $data->followers()->where('user_id', $follower->id)->exists();
                $areFriends = $isFollowing && $isFollowedBy;
                
                $follow_status = $areFriends ? 2 : ($isFollowing ? 1 : 1);
            }
        }
        
        // Get host info
        $is_host = DB::table('host_data')
            ->join('users', 'users.id', 'host_data.user_id')
            ->join('agencies', 'agencies.code', 'host_data.agency_code')
            ->where('users.is_host_id', 1)
            ->where('users.id', $user_id)
            ->select('host_data.hosting_type', 'agencies.name')
            ->first();
        
        $host_type = $is_host ? $is_host->hosting_type : 0;
        $agency_name = $is_host ? $is_host->name : 'bp';
        $balance = $host_id == $user_id ? self::calculateHostBalance($user_id) : 0;
        
        return [
            'data' => $data,
            'follow_status' => $follow_status,
            'balance' => $balance,
            'agency_name' => $agency_name,
            'host_type' => $host_type,
            'marchent' => $data->is_agency,
            'is_coin_portal_active' => $data->is_coin_protal_active,
            'frame' => $data->frame,
            'entry_effect' => $data->entry
        ];
    }
}