<?php

namespace App\Services\GameFinal;

use App\Models\GameFinal\Game;
use App\Models\GameFinal\GameSetting;
use App\Models\GameFinal\GameBoard;

class GameConfigService
{
    protected function normalizeStoredGameStatus(string $rawStatus, bool $maintenanceEnabled, array $allowedUserIds, bool $enabled): string
    {
        $rawStatus = trim($rawStatus);

        return match ($rawStatus) {
            'active' => 'live',
            'inactive' => 'maintenance',
            'live', 'developer', 'maintenance' => $rawStatus,
            default => $maintenanceEnabled
                ? (!empty($allowedUserIds) ? 'developer' : 'maintenance')
                : ($enabled ? 'live' : 'maintenance'),
        };
    }

    public function get($gameCode)
    {
        $cfg = config('bd_game_final.games.' . $gameCode, []);

        $game = Game::where('game_code', $gameCode)->first();
        $setting = $game ? GameSetting::where('game_id', $game->id)->first() : null;
        $gameEnabled = $game ? (bool) $game->is_active : true;

        if ($setting) {
            $cfg['bet_duration_sec'] = (float) $setting->bet_duration_sec;
            $cfg['start_bet_popup_sec'] = (float) ($setting->start_bet_popup_sec ?? ($cfg['start_bet_popup_sec'] ?? 3));
            $cfg['start_bet_wait_sec'] = (float) ($setting->start_bet_wait_sec ?? ($cfg['start_bet_wait_sec'] ?? 1.5));
            $cfg['stop_bet_popup_sec'] = (float) ($setting->stop_bet_popup_sec ?? ($cfg['stop_bet_popup_sec'] ?? $setting->stop_duration_sec ?? 3));
            $cfg['stop_bet_wait_sec'] = (float) ($setting->stop_bet_wait_sec ?? ($cfg['stop_bet_wait_sec'] ?? 1.5));
            $cfg['stop_duration_sec'] = (float) ($setting->stop_duration_sec ?? (($cfg['stop_bet_popup_sec'] ?? 3) + ($cfg['stop_bet_wait_sec'] ?? 1.5)));
            $cfg['reveal_duration_sec'] = (float) $setting->reveal_duration_sec;
            $cfg['reveal_wait_sec'] = (float) ($setting->reveal_wait_sec ?? ($cfg['reveal_wait_sec'] ?? 2));
            $cfg['winner_popup_sec'] = (float) ($setting->winner_popup_sec ?? ($cfg['winner_popup_sec'] ?? 1));
            $cfg['winner_wait_sec'] = (float) ($setting->winner_wait_sec ?? ($cfg['winner_wait_sec'] ?? 0.5));
            $cfg['settle_duration_sec'] = (float) $setting->settle_duration_sec;
            $cfg['settle_wait_sec'] = (float) ($setting->settle_wait_sec ?? ($cfg['settle_wait_sec'] ?? 1));
            $cfg['max_distinct_boards_per_user'] = (int) $setting->max_distinct_boards_per_user;
            $cfg['manual_winner_board'] = $setting->manual_winner_board;
            $cfg['min_bet'] = (float) $setting->min_bet;
            $cfg['max_bet'] = (float) $setting->max_bet;
            $cfg['risk_mode'] = (string) $setting->risk_mode;
            $cfg['reserve_buffer'] = (float) $setting->reserve_buffer;
            $cfg['repeat_limit'] = (int) $setting->repeat_limit;
            $cfg['manual_lock_enabled'] = (bool) $setting->manual_lock_enabled;
            $cfg['game_status'] = $this->normalizeStoredGameStatus(
                (string) ($setting->game_status ?? ''),
                (bool) ($setting->maintenance_enabled ?? false),
                !empty($setting->maintenance_allowed_user_id) ? [(int) $setting->maintenance_allowed_user_id] : [],
                $gameEnabled
            );
            $cfg['decision_balance_amount'] = (float) ($setting->decision_balance_amount ?? 0);
            $cfg['healthy_balance_threshold'] = (float) ($setting->healthy_balance_threshold ?? 0);
            $cfg['weighted_random_enabled'] = (bool) ($setting->weighted_random_enabled ?? 0);
            $cfg['weighted_random_spread'] = (int) ($setting->weighted_random_spread ?? 3);
            $cfg['avoid_last_n_winners'] = (int) ($setting->avoid_last_n_winners ?? 3);
        }

        if ($game) {
            $cfg['is_active'] = $gameEnabled;
            $boards = GameBoard::where('game_id', $game->id)->where('is_active', 1)->orderBy('display_order')->get();
            if ($boards->count()) {
                $cfg['boards'] = $boards->map(function ($row) {
                    return [
                        'frontend_key' => $row->frontend_key,
                        'canonical_key' => $row->canonical_key,
                        'multiplier' => (float) $row->payout_multiplier,
                        'display_name' => $row->display_name,
                    ];
                })->toArray();
            }
        }

        $boardCount = max(1, count((array) ($cfg['boards'] ?? [])));
        $defaultBetDuration = $boardCount >= 8 ? 30 : 20;
        $defaultRevealDuration = 6;
        $defaultSettleDuration = 2.5;
        $cfg['bet_duration_sec'] = max(1, (float) ($cfg['bet_duration_sec'] ?? $defaultBetDuration));
        $cfg['start_bet_popup_sec'] = max(0, (float) ($cfg['start_bet_popup_sec'] ?? 3));
        $cfg['start_bet_wait_sec'] = max(0, (float) ($cfg['start_bet_wait_sec'] ?? 1.5));
        $cfg['stop_bet_popup_sec'] = max(0, (float) ($cfg['stop_bet_popup_sec'] ?? 3));
        $cfg['stop_bet_wait_sec'] = max(0, (float) ($cfg['stop_bet_wait_sec'] ?? 1.5));
        $cfg['stop_duration_sec'] = max(0.1, (float) ($cfg['stop_duration_sec'] ?? ($cfg['stop_bet_popup_sec'] + $cfg['stop_bet_wait_sec'])));
        $cfg['reveal_duration_sec'] = max(1, (float) ($cfg['reveal_duration_sec'] ?? $defaultRevealDuration));
        $cfg['reveal_wait_sec'] = max(0, (float) ($cfg['reveal_wait_sec'] ?? 2));
        $cfg['winner_popup_sec'] = max(0, (float) ($cfg['winner_popup_sec'] ?? 1));
        $cfg['winner_wait_sec'] = max(0, (float) ($cfg['winner_wait_sec'] ?? 0.5));
        $cfg['settle_duration_sec'] = max(0.1, (float) ($cfg['settle_duration_sec'] ?? $defaultSettleDuration));
        $cfg['settle_wait_sec'] = max(0, (float) ($cfg['settle_wait_sec'] ?? 1));
        $cfg['min_bet'] = max(0.01, (float) ($cfg['min_bet'] ?? 1));
        $cfg['max_bet'] = max($cfg['min_bet'], (float) ($cfg['max_bet'] ?? 9999999));
        $cfg['game_status'] = $this->normalizeStoredGameStatus(
            (string) ($cfg['game_status'] ?? ''),
            $setting ? (bool) ($setting->maintenance_enabled ?? false) : false,
            ($setting && !empty($setting->maintenance_allowed_user_id)) ? [(int) $setting->maintenance_allowed_user_id] : [],
            (bool) ($cfg['is_active'] ?? $gameEnabled)
        );
        $cfg['max_distinct_boards_per_user'] = max(1, min((int) ($cfg['max_distinct_boards_per_user'] ?? $boardCount), $boardCount));
        $cfg['rules'] = [
            'board_count' => $boardCount,
            'max_distinct_boards_per_user' => (int) $cfg['max_distinct_boards_per_user'],
        ];

        return $cfg;
    }
}
