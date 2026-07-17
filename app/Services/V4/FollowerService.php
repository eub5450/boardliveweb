<?php

namespace App\Services\V4;

use App\Models\Follower;
use Illuminate\Support\Facades\DB;

class FollowerService
{
    public function forgetSocial($userId, $targetUserId = null): void
    {
        V4CacheService::forgetSocial($userId ? (int) $userId : null, $targetUserId ? (int) $targetUserId : null);
    }

    public function followStatus($userId, $targetUserId): int
    {
        $follow = Follower::where('user_id', $userId)
            ->where('follower_id', $targetUserId)
            ->exists();

        if (!$follow) {
            return 0;
        }

        $friend = Follower::where('user_id', $targetUserId)
            ->where('follower_id', $userId)
            ->exists();

        return $friend ? 2 : 1;
    }

    public function followingList($userId)
    {
        return V4CacheService::socialList('following', $userId, function () use ($userId) {
            return DB::table('followers')
                ->join('users', 'users.id', 'followers.user_id')
                ->select('users.*')
                ->where('followers.follower_id', $userId)
                ->orderBy('followers.id', 'desc')
                ->limit(200)
                ->get();
        });
    }

    public function followerList($userId)
    {
        return V4CacheService::socialList('followers', $userId, function () use ($userId) {
            return DB::table('followers')
                ->join('users', 'users.id', 'followers.follower_id')
                ->select('users.*')
                ->where('followers.user_id', $userId)
                ->orderBy('followers.id', 'desc')
                ->limit(200)
                ->get();
        });
    }

    public function friendPayload($userId): array
    {
        return V4CacheService::socialList('friends', $userId, function () use ($userId) {
            $select = ['users.name', 'users.id', 'users.level', 'users.is_vip', 'users.frame', 'users.profile'];

            $friends = DB::table('followers as mine')
                ->join('followers as theirs', function ($join) use ($userId) {
                    $join->on('theirs.user_id', '=', 'mine.follower_id')
                        ->where('theirs.follower_id', '=', $userId);
                })
                ->join('users', 'users.id', '=', 'mine.follower_id')
                ->where('mine.user_id', $userId)
                ->select($select)
                ->orderByDesc('mine.id')
                ->limit(100)
                ->get();

            $friendIds = $friends->pluck('id')->all();

            $followers = DB::table('followers')
                ->join('users', 'users.id', '=', 'followers.follower_id')
                ->select($select)
                ->where('followers.user_id', $userId)
                ->when(!empty($friendIds), function ($query) use ($friendIds) {
                    $query->whereNotIn('users.id', $friendIds);
                })
                ->orderBy('followers.id', 'desc')
                ->limit(200)
                ->get();

            $following = DB::table('followers')
                ->join('users', 'users.id', '=', 'followers.user_id')
                ->select($select)
                ->where('followers.follower_id', $userId)
                ->when(!empty($friendIds), function ($query) use ($friendIds) {
                    $query->whereNotIn('users.id', $friendIds);
                })
                ->orderBy('followers.id', 'desc')
                ->limit(200)
                ->get();

            return [
                'friends' => $friends,
                'follower' => $followers,
                'following' => $following,
            ];
        });
    }
}
