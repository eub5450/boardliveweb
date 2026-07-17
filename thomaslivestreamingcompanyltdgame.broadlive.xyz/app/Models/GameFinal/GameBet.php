<?php

namespace App\Models\GameFinal;

use Illuminate\Database\Eloquent\Model;

class GameBet extends Model
{
    protected $table = 'bd_game_final_bets';

    protected $fillable = [
        'game_id',
        'game_round_id',
        'round_no',
        'user_id',
        'amount',
        'frontend_board_key',
        'canonical_board_key',
        'payout_multiplier',
        'potential_win',
        'win_balance',
        'now_user_balance',
        'request_uid',
        'settlement_item_id',
        'status',
        'meta_json',
        'settled_at',
    ];

    protected $casts = [
        'meta_json' => 'array',
        'settled_at' => 'datetime',
    ];
}
