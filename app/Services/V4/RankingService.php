<?php

namespace App\Services\V4;

use App\Models\Gift;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RankingService
{
    public function monthlyPayload(): array
    {
        return V4CacheService::rankingMonthly(function () {
            $date = Carbon::now(config('app.timezone', 'Europe/London'));
            $startDate = $date->copy()->startOfMonth()->toDateString();
            $endDate = $date->copy()->endOfMonth()->toDateString();
            $previousDate = $date->copy()->subMonth();
            $previousStartDate = $previousDate->copy()->startOfMonth()->toDateString();
            $previousEndDate = $previousDate->copy()->endOfMonth()->toDateString();

            DB::statement("
                UPDATE gifts g
                LEFT JOIN host_data h ON h.user_id = g.reciever_id
                SET g.agency_code = COALESCE(h.agency_code, 0)
                WHERE g.agency_code IS NULL
            ");

            return [
                'message' => 'Host Data Show',
                'code' => '200',
                'top_three_sander' => Gift::topSanders($startDate, $endDate, 3),
                'sander_list' => Gift::topSanders($startDate, $endDate, 100, 3),
                'top_three_reciver' => Gift::topReceivers($startDate, $endDate, 3),
                'reciver_list' => Gift::topReceivers($startDate, $endDate, 100, 3),
                'top_three_family' => Gift::topFamilies($startDate, $endDate, 3),
                'family_list' => Gift::topFamilies($startDate, $endDate, 100, 3),
                'topThreefamillyRecived_prvious' => Gift::topFamilies($previousStartDate, $previousEndDate, 3),
                'totalfamillyRecived_prvious' => Gift::topFamilies($previousStartDate, $previousEndDate, 100, 3),
            ];
        });
    }

    public function topListPayload(): array
    {
        return V4CacheService::topList(function () {
            $todayDate = Carbon::now(config('app.timezone', 'Europe/London'));
            $today = $todayDate->toDateString();
            $endDate = $todayDate->copy()->subDays(7)->toDateString();

            return [
                'message' => 'Host Data Show',
                'code' => '200',
                'topthreeweeklyfamily' => Gift::topFamilies($endDate, $today, 3, 0),
                'topthreeweeklyreciver' => Gift::topReceivers($endDate, $today, 3, 0),
                'topthreeweeklySander' => Gift::topSanders($endDate, $today, 3, 0),
                'topthreetodayfamily' => Gift::topFamilies($today, $today, 3, 0),
                'topthreetodayreciver' => Gift::topReceivers($today, $today, 3, 0),
                'topthreetodaySander' => Gift::topSanders($today, $today, 3, 0),
                'toptodaySander' => Gift::topSanders($today, $today, 27, 3),
                'toptodayreciver' => Gift::topReceivers($today, $today, 27, 3),
                'toptodayfamily' => Gift::topFamilies($today, $today, 27, 3),
                'topweeklySander' => Gift::topSanders($endDate, $today, 27, 3),
                'topweeklyreciver' => Gift::topReceivers($endDate, $today, 27, 3),
                'topweeklyfamily' => Gift::topFamilies($endDate, $today, 27, 3),
            ];
        });
    }

    /**
     * Authenticated user's real rank + total value across each period/category
     * combo. Every number comes straight from the gifts table — no seed data,
     * no placeholders. A null leaf means the user has no qualifying activity
     * (e.g. not in a family) rather than a fabricated 0/rank.
     */
    public function myRankPayload(int $userId): array
    {
        return V4CacheService::myRank($userId, function () use ($userId) {
            $timezone = config('app.timezone', 'Europe/London');
            $date = Carbon::now($timezone);

            $today = $date->toDateString();
            $weekStart = $date->copy()->subDays(7)->toDateString();
            $monthStart = $date->copy()->startOfMonth()->toDateString();
            $monthEnd = $date->copy()->endOfMonth()->toDateString();

            return [
                'message' => 'My Rank',
                'code' => '200',
                'daily' => $this->myRankForPeriod($userId, $today, $today),
                'weekly' => $this->myRankForPeriod($userId, $weekStart, $today),
                'monthly' => $this->myRankForPeriod($userId, $monthStart, $monthEnd),
            ];
        });
    }

    private function myRankForPeriod(int $userId, string $start, string $end): array
    {
        return [
            'sender' => $this->myRankAsSender($userId, $start, $end),
            'receiver' => $this->myRankAsReceiver($userId, $start, $end),
            'family' => $this->myRankAsFamily($userId, $start, $end),
        ];
    }

    private function periodBounds(string $start, string $end): array
    {
        $timezone = config('app.timezone', 'Europe/London');
        $startAt = Carbon::parse($start, $timezone)->startOfDay()->toDateTimeString();
        $endAt = Carbon::parse($end, $timezone)->endOfDay()->toDateTimeString();
        return [$startAt, $endAt];
    }

    private function myRankAsSender(int $userId, string $start, string $end): ?array
    {
        [$startAt, $endAt] = $this->periodBounds($start, $end);

        $myTotal = (int) DB::table('gifts')
            ->where('sander_id', $userId)
            ->whereBetween('date', [$startAt, $endAt])
            ->sum('value');

        if ($myTotal <= 0) {
            return null;
        }

        $ahead = DB::table('gifts')
            ->whereBetween('date', [$startAt, $endAt])
            ->groupBy('sander_id')
            ->selectRaw('sander_id, SUM(value) as total_sand')
            ->havingRaw('SUM(value) > ?', [$myTotal])
            ->get()
            ->count();

        return ['rank' => $ahead + 1, 'total' => $myTotal];
    }

    private function myRankAsReceiver(int $userId, string $start, string $end): ?array
    {
        [$startAt, $endAt] = $this->periodBounds($start, $end);

        $myTotal = (int) DB::table('gifts')
            ->where('reciever_id', $userId)
            ->whereBetween('date', [$startAt, $endAt])
            ->sum('value');

        if ($myTotal <= 0) {
            return null;
        }

        $ahead = DB::table('gifts')
            ->whereBetween('date', [$startAt, $endAt])
            ->groupBy('reciever_id')
            ->selectRaw('reciever_id, SUM(value) as total_sand')
            ->havingRaw('SUM(value) > ?', [$myTotal])
            ->get()
            ->count();

        return ['rank' => $ahead + 1, 'total' => $myTotal];
    }

    private function myRankAsFamily(int $userId, string $start, string $end): ?array
    {
        $agencyCode = DB::table('host_data')->where('user_id', $userId)->value('agency_code');
        if (!$agencyCode) {
            return null;
        }

        [$startAt, $endAt] = $this->periodBounds($start, $end);

        $myTotal = (int) DB::table('gifts')
            ->where('agency_code', $agencyCode)
            ->whereBetween('date', [$startAt, $endAt])
            ->sum('value');

        if ($myTotal <= 0) {
            return ['rank' => null, 'total' => 0];
        }

        $ahead = DB::table('gifts')
            ->whereBetween('date', [$startAt, $endAt])
            ->whereNotNull('agency_code')
            ->groupBy('agency_code')
            ->selectRaw('agency_code, SUM(value) as total_sand')
            ->havingRaw('SUM(value) > ?', [$myTotal])
            ->get()
            ->count();

        return ['rank' => $ahead + 1, 'total' => $myTotal];
    }
}
