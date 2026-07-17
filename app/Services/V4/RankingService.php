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
}
