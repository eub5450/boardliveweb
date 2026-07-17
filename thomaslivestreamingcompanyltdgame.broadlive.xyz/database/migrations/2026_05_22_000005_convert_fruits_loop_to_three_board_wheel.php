<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ConvertFruitsLoopToThreeBoardWheel extends Migration
{
    public function up()
    {
        $gameCode = 'fruits_loop';
        $cfg = (array) config('bd_game_final.games.' . $gameCode, []);
        $game = DB::table('bd_game_final_games')->where('game_code', $gameCode)->first();

        if (!$game || !$cfg) {
            return;
        }

        $now = now();
        $boards = array_values((array) ($cfg['boards'] ?? []));
        $canonicalKeys = array_values(array_filter(array_map(function ($board) {
            return (string) ($board['canonical_key'] ?? $board['frontend_key'] ?? '');
        }, $boards)));

        DB::table('bd_game_final_games')->where('id', $game->id)->update([
            'name' => 'Fruits Loop',
            'frontend_slug' => 'fruits_loop',
            'is_active' => 1,
            'updated_at' => $now,
        ]);

        DB::table('bd_game_final_settings')->updateOrInsert(
            ['game_id' => $game->id],
            [
                'bet_duration_sec' => (int) ($cfg['bet_duration_sec'] ?? 20),
                'stop_duration_sec' => (int) ($cfg['stop_duration_sec'] ?? 5),
                'reveal_duration_sec' => (int) ($cfg['reveal_duration_sec'] ?? 6),
                'settle_duration_sec' => (int) ($cfg['settle_duration_sec'] ?? 4),
                'max_distinct_boards_per_user' => 3,
                'min_bet' => 1,
                'max_bet' => 9999999,
                'risk_mode' => 'safe_low_liability',
                'reserve_buffer' => 0,
                'repeat_limit' => 3,
                'manual_winner_board' => null,
                'manual_lock_enabled' => 0,
                'game_status' => 'active',
                'decision_balance_amount' => 0,
                'healthy_balance_threshold' => 0,
                'weighted_random_enabled' => 0,
                'weighted_random_spread' => 3,
                'avoid_last_n_winners' => 3,
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );

        DB::table('bd_game_final_boards')
            ->where('game_id', $game->id)
            ->whereNotIn('canonical_key', $canonicalKeys)
            ->delete();

        foreach ($boards as $index => $board) {
            $canonical = (string) ($board['canonical_key'] ?? $board['frontend_key'] ?? '');
            if ($canonical === '') {
                continue;
            }

            DB::table('bd_game_final_boards')->updateOrInsert(
                ['game_id' => $game->id, 'canonical_key' => $canonical],
                [
                    'frontend_key' => (string) ($board['frontend_key'] ?? $canonical),
                    'display_name' => (string) ($board['display_name'] ?? $canonical),
                    'payout_multiplier' => (float) ($board['multiplier'] ?? 1),
                    'display_order' => $index + 1,
                    'is_active' => 1,
                    'ui_meta_json' => null,
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }
    }

    public function down()
    {
        // Keep the room installed. Earlier migrations can rebuild the broader fruit board set if needed.
    }
}
