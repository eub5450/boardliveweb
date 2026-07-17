<?php

namespace App\Services\V4;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class V4CacheService
{
    private const ROOM_TTL = 3;
    private const SOCIAL_TTL = 30;
    private const RANKING_TTL = 30;
    private const MONTHLY_RANKING_TTL = 60;
    private const ROOM_KEY_REGISTRY_TTL = 3600;

    private static function roomKey(string $name, $channelName): string
    {
        return 'v4:room:' . $name . ':' . md5((string) $channelName);
    }

    private static function roomRegistryKey($channelName): string
    {
        return self::roomKey('registry', $channelName);
    }

    private static function trackRoomKey($channelName, string $key): void
    {
        $registryKey = self::roomRegistryKey($channelName);
        $keys = Cache::get($registryKey, []);

        if (!is_array($keys)) {
            $keys = [];
        }

        if (!in_array($key, $keys, true)) {
            $keys[] = $key;
            Cache::put($registryKey, $keys, self::ROOM_KEY_REGISTRY_TTL);
        }
    }

    private static function rememberRoomKey(string $key, $channelName, int $ttl, callable $resolver)
    {
        self::trackRoomKey($channelName, $key);

        return Cache::remember($key, $ttl, $resolver);
    }

    public static function forgetRoom($channelName): void
    {
        $registryKey = self::roomRegistryKey($channelName);
        $keys = Cache::get($registryKey, []);

        if (is_array($keys)) {
            foreach ($keys as $key) {
                Cache::forget($key);
            }
        }

        Cache::forget($registryKey);
        Cache::forget(self::roomKey('audience_count', $channelName));
        Cache::forget(self::roomKey('audience_profile', $channelName));
        Cache::forget(self::roomKey('audience_list', $channelName));
        Cache::forget(self::roomKey('admin_profile', $channelName));
        Cache::forget(self::roomKey('last_comment', $channelName));
        Cache::forget(self::roomKey('comment_mute', $channelName));
    }

    public static function forgetLiveLists(?int $userId = null): void
    {
        Cache::forget('live_list_fast_0');
        Cache::forget('live_list_fast_1');
        Cache::forget('top_live');
        Cache::forget('v4:global:lives:all');

        if ($userId) {
            Cache::forget("home_data_{$userId}");
            Cache::forget("host_type_{$userId}");
        }
    }

    public static function forgetSocial(?int $userId = null, ?int $targetUserId = null): void
    {
        foreach (array_filter([$userId, $targetUserId]) as $id) {
            Cache::forget("v4:social:followers:{$id}");
            Cache::forget("v4:social:following:{$id}");
            Cache::forget("v4:social:friends:{$id}");
            Cache::forget("v4:home:follower_live:{$id}");
            Cache::forget("home_data_{$id}");
        }
    }

    public static function socialList(string $type, $userId, callable $resolver)
    {
        return Cache::remember(
            "v4:social:{$type}:" . (int) $userId,
            self::SOCIAL_TTL,
            $resolver
        );
    }

    public static function forgetRanking(): void
    {
        Cache::forget('v4:ranking:monthly');
        Cache::forget('v4:ranking:top_list');
    }

    public static function rankingMonthly(callable $resolver)
    {
        return Cache::remember('v4:ranking:monthly', self::MONTHLY_RANKING_TTL, $resolver);
    }

    public static function topList(callable $resolver)
    {
        return Cache::remember('v4:ranking:top_list', self::RANKING_TTL, $resolver);
    }

    public static function boardUserData($type, $channelName, $userId, $hostId, callable $resolver)
    {
        $key = self::roomKey(
            'board_user_data:' . $type . ':' . (int) $userId . ':' . (int) $hostId,
            $channelName
        );

        return self::rememberRoomKey($key, $channelName, self::ROOM_TTL, $resolver);
    }

    public static function forgetBoardUserData($type, $channelName, $userId, $hostId): void
    {
        Cache::forget(self::roomKey(
            'board_user_data:' . $type . ':' . (int) $userId . ':' . (int) $hostId,
            $channelName
        ));
    }

    public static function audienceCount($channelName): int
    {
        return (int) self::rememberRoomKey(
            self::roomKey('audience_count', $channelName),
            $channelName,
            self::ROOM_TTL,
            function () use ($channelName) {
                return DB::table('audience_joins')
                    ->where('channelName', $channelName)
                    ->count();
            }
        );
    }

    public static function audienceProfiles($channelName)
    {
        return self::rememberRoomKey(
            self::roomKey('audience_profile', $channelName),
            $channelName,
            self::ROOM_TTL,
            function () use ($channelName) {
                return DB::table('audience_joins')
                    ->join('users', 'users.id', 'audience_joins.user_id')
                    ->where('audience_joins.channelName', $channelName)
                    ->select('users.profile', 'users.is_vip', 'users.frame')
                    ->orderBy('users.is_vip', 'desc')
                    ->limit(2)
                    ->get();
            }
        );
    }

    public static function adminProfiles($channelName)
    {
        return self::rememberRoomKey(
            self::roomKey('admin_profile', $channelName),
            $channelName,
            self::ROOM_TTL,
            function () use ($channelName) {
                return DB::table('audience_joins')
                    ->join('users', 'users.id', 'audience_joins.user_id')
                    ->where('audience_joins.channelName', $channelName)
                    ->where('audience_joins.admin_power', '!=', 0)
                    ->select(
                        'users.profile',
                        'users.frame',
                        'users.id',
                        'audience_joins.admin_power'
                    )
                    ->orderBy('audience_joins.admin_power', 'desc')
                    ->limit(3)
                    ->get();
            }
        );
    }

    public static function audienceList($channelName): array
    {
        return self::rememberRoomKey(
            self::roomKey('audience_list', $channelName),
            $channelName,
            self::ROOM_TTL,
            function () use ($channelName) {
                $base = DB::table('audience_joins')
                    ->join('users', 'users.id', 'audience_joins.user_id')
                    ->where('audience_joins.channelName', $channelName)
                    ->select(
                        'users.name',
                        'users.level',
                        'users.id',
                        'users.profile',
                        'users.is_vip',
                        'users.frame',
                        'audience_joins.admin_power'
                    )
                    ->orderBy('audience_joins.id', 'desc');

                return [
                    'data' => (clone $base)
                        ->where('users.is_vip', 0)
                        ->where('audience_joins.admin_power', 0)
                        ->get(),
                    'vip_data' => (clone $base)
                        ->where('users.is_vip', '!=', 0)
                        ->where('audience_joins.admin_power', 0)
                        ->get(),
                    'admin_data' => (clone $base)
                        ->where('audience_joins.admin_power', '!=', 0)
                        ->get(),
                ];
            }
        );
    }

    public static function lastComment($channelName)
    {
        return self::rememberRoomKey(
            self::roomKey('last_comment', $channelName),
            $channelName,
            self::ROOM_TTL,
            function () use ($channelName) {
                return DB::table('comments')
                    ->join('users', 'users.id', 'comments.user_id')
                    ->select(
                        'users.name',
                        'users.profile',
                        'comments.message',
                        'comments.type',
                        'comments.channelName',
                        'users.is_vip',
                        'users.level',
                        'users.frame'
                    )
                    ->where('comments.channelName', $channelName)
                    ->orderBy('comments.id', 'desc')
                    ->first();
            }
        );
    }

    public static function commentMuteList($channelName)
    {
        return self::rememberRoomKey(
            self::roomKey('comment_mute', $channelName),
            $channelName,
            self::ROOM_TTL,
            function () use ($channelName) {
                return DB::table('comment_mutes')
                    ->where('channelName', $channelName)
                    ->get();
            }
        );
    }

    public static function clearStatic(): void
    {
        Cache::forget('gift_data');
        Cache::forget('sliders_cache');
        Cache::forget('comment_skips');
        Cache::forget('pusher_settings');
        Cache::forget('realtime_pusher_setting');
        self::forgetRanking();
    }
}
