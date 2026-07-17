<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

/**
 * Broadlive room/gift/home cache invalidation helpers.
 *
 * All keys are cleared through Laravel's Cache facade so the CACHE_PREFIX
 * (broadlive_main_cache) applied at write time (Cache::put / Cache::remember)
 * matches the delete-time namespace. The previous implementation prepended a
 * manual "broadlive_main_" on top of Laravel's automatic REDIS_PREFIX
 * (broadlive_main_) via Redis::del(...), which double-prefixed every key and
 * therefore silently deleted nothing.
 */
trait CacheClearTrait
{
    protected function clearJustVideoCall($host_id, $channelName)
    {
        $today = now()->format('Y-m-d');
        $start_date = now()->startOfMonth()->toDateString();
        $end_date = now()->endOfMonth()->toDateString();

        Cache::forget("gift_range:{$host_id}:{$start_date}:{$end_date}");
        Cache::forget("today_gift:{$host_id}:{$today}");
        Cache::forget("sander_total:{$host_id}");
        Cache::forget("channel_gift:{$host_id}:{$channelName}");
        Cache::forget("withdraw_range:{$host_id}:{$start_date}:{$end_date}");
        Cache::forget("Video_Brd_Call_Details_{$host_id}_{$channelName}");
    }

    protected function clearVideoCallAndLists($host_id, $channelName)
    {
        $this->clearJustVideoCall($host_id, $channelName);
    }

    protected function clearVideoCallAndHome($host_id, $channelName)
    {
        $this->clearJustVideoCall($host_id, $channelName);
        Cache::forget('live_users_type_1');
        Cache::forget('live_frined_home');
        Cache::forget('live_top_list');
        for ($i = 1; $i <= 5; $i++) {
            Cache::forget("live_list_page_{$i}");
        }
    }

    protected function clearVideoCallAndStatus($host_id, $channelName, $co_host_id)
    {
        $this->clearJustVideoCall($host_id, $channelName);
        Cache::forget("live_call_accept_count_{$host_id}_{$channelName}");
    }

    protected function clearAllVideoCachesWithGift($host_id, $channelName, $user_id)
    {
        $this->clearVideoCallAndLists($host_id, $channelName);
    }

    protected function clearJustHomeLists()
    {
        Cache::forget('live_users_type_1');
        Cache::forget('live_frined_home');
        Cache::forget('live_top_list');
        for ($i = 1; $i <= 5; $i++) {
            Cache::forget("live_list_page_{$i}");
        }
        return true;
    }
}
