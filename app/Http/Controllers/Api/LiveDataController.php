<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LiveDataController extends Controller
{
    /**
     * Live Data monthly summary for the currently authenticated host.
     *
     * Returns strictly {code:200, data:{...}} — never throws, never 500s;
     * on any DB failure returns zeroed data so the Flutter UI can render placeholders.
     */
    public function monthlyEarnSummary(Request $request)
    {
        $emptyPayload = [
            'earn'                 => 0,
            'live_hours'           => 0.0,
            'viewers'              => 0,
            'new_followers'        => 0,
            'engagement'           => 0.0,
            'prev_earn'            => 0,
            'prev_viewers'         => 0,
            'prev_followers'       => 0,
            'prev_engagement'      => 0.0,
            'sessions'             => [],
        ];

        try {
            $user = $request->user();
            if (!$user) {
                return response()->json([
                    'code' => 200,
                    'data' => $emptyPayload,
                ], 200, [], JSON_UNESCAPED_UNICODE);
            }

            $userId = (int) $user->id;
            $now = Carbon::now();
            $startOfMonth = $now->copy()->startOfMonth()->format('Y-m-d');
            $endOfMonth   = $now->copy()->endOfMonth()->format('Y-m-d');

            // --- 1) Earn: sum of gifts.value received this month ---
            $earn = 0;
            try {
                $earn = (int) DB::table('gifts')
                    ->where('reciever_id', $userId)
                    ->whereDate('date', '>=', $startOfMonth)
                    ->whereDate('date', '<=', $endOfMonth)
                    ->sum('value');
            } catch (\Throwable $e) {
                $earn = 0;
            }

            // --- 2) Live hours: sum of day_times.day_times durations for this month ---
            $liveHours = 0.0;
            try {
                $rows = DB::table('day_times')
                    ->where('user_id', $userId)
                    ->where('live_time', '>=', $startOfMonth)
                    ->where('live_time', '<=', $endOfMonth . ' 23:59:59')
                    ->select('day_times')
                    ->get();
                $totalSeconds = 0;
                foreach ($rows as $r) {
                    $t = $r->day_times;
                    if (!$t) continue;
                    $parts = explode(':', (string) $t);
                    if (count($parts) === 3) {
                        $totalSeconds += ((int) $parts[0]) * 3600
                                       + ((int) $parts[1]) * 60
                                       + ((int) $parts[2]);
                    }
                }
                $liveHours = round($totalSeconds / 3600.0, 2);
            } catch (\Throwable $e) {
                $liveHours = 0.0;
            }

            // --- 3) Viewers this month: distinct audience joins on this host's rooms ---
            $viewers = 0;
            try {
                if (\Schema::hasTable('audience_joins')) {
                    $viewers = (int) DB::table('audience_joins')
                        ->where('host_id', $userId)
                        ->whereBetween('created_at', [$startOfMonth . ' 00:00:00', $endOfMonth . ' 23:59:59'])
                        ->distinct('user_id')
                        ->count('user_id');
                }
            } catch (\Throwable $e) {
                $viewers = 0;
            }

            // --- 4) New followers this month ---
            $newFollowers = 0;
            try {
                if (\Schema::hasTable('followers')) {
                    $newFollowers = (int) DB::table('followers')
                        ->where('user_id', $userId)
                        ->whereBetween('created_at', [$startOfMonth . ' 00:00:00', $endOfMonth . ' 23:59:59'])
                        ->count();
                }
            } catch (\Throwable $e) {
                $newFollowers = 0;
            }

            // --- 5) Engagement (stub) ---
            $engagement = 0.0;

            $payload = [
                'earn'            => $earn,
                'live_hours'      => (float) $liveHours,
                'viewers'         => $viewers,
                'new_followers'   => $newFollowers,
                'engagement'      => $engagement,
                'prev_earn'       => 0,
                'prev_viewers'    => 0,
                'prev_followers'  => 0,
                'prev_engagement' => 0.0,
                'sessions'        => [],
            ];

            return response()->json([
                'code' => 200,
                'data' => $payload,
            ], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $e) {
            \Log::warning('LiveDataController@monthlyEarnSummary failed', [
                'err' => $e->getMessage(),
            ]);
            return response()->json([
                'code' => 200,
                'data' => $emptyPayload,
            ], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }
}
