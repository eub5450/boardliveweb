<?php

namespace App\Models\GameFinal;

use Illuminate\Database\Eloquent\Model;

class GameSetting extends Model
{
    protected $table = 'bd_game_final_settings';

    protected $fillable = [
        'game_id',
        'bet_duration_sec',
        'start_bet_popup_sec',
        'start_bet_wait_sec',
        'stop_bet_popup_sec',
        'stop_bet_wait_sec',
        'stop_duration_sec',
        'reveal_duration_sec',
        'reveal_wait_sec',
        'winner_popup_sec',
        'winner_wait_sec',
        'settle_duration_sec',
        'settle_wait_sec',
        'max_distinct_boards_per_user',
        'min_bet',
        'max_bet',
        'risk_mode',
        'reserve_buffer',
        'repeat_limit',
        'manual_winner_board',
        'manual_lock_enabled',
        'game_status',
        'maintenance_enabled',
        'maintenance_allowed_user_id',
        'maintenance_message',
        'ui_meta_json',
        'decision_balance_amount',
        'healthy_balance_threshold',
        'weighted_random_enabled',
        'weighted_random_spread',
        'avoid_last_n_winners',
    ];

    protected $casts = [
        'ui_meta_json' => 'array',
        'decision_balance_amount' => 'float',
        'healthy_balance_threshold' => 'float',
        'weighted_random_enabled' => 'boolean',
        'start_bet_popup_sec' => 'float',
        'start_bet_wait_sec' => 'float',
        'stop_bet_popup_sec' => 'float',
        'stop_bet_wait_sec' => 'float',
        'stop_duration_sec' => 'float',
        'reveal_duration_sec' => 'float',
        'reveal_wait_sec' => 'float',
        'winner_popup_sec' => 'float',
        'winner_wait_sec' => 'float',
        'settle_duration_sec' => 'float',
        'settle_wait_sec' => 'float',
    ];
}
