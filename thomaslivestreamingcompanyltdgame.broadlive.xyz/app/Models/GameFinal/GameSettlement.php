<?php

namespace App\Models\GameFinal;

use Illuminate\Database\Eloquent\Model;

class GameSettlement extends Model
{
    protected $table = 'bd_game_final_settlements';

    protected $fillable = [
        'game_id',
        'game_round_id',
        'winner_board_key',
        'settlement_run_uid',
        'settlement_status',
        'total_bet_amount',
        'total_payout_amount',
        'total_winning_bets',
        'total_losing_bets',
        'net_house_result',
        'meta_json',
        'settled_at',
    ];

    protected $casts = [
        'meta_json' => 'array',
        'settled_at' => 'datetime',
    ];
}

