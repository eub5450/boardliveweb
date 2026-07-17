<?php

namespace App\Models\GameFinal;

use Illuminate\Database\Eloquent\Model;

class GameSettlementItem extends Model
{
    protected $table = 'bd_game_final_settlement_items';

    protected $fillable = [
        'game_settlement_id',
        'game_round_id',
        'game_bet_id',
        'user_id',
        'canonical_board_key',
        'bet_amount',
        'payout_multiplier',
        'win_amount',
        'net_result',
        'result_status',
        'wallet_before',
        'wallet_after',
        'meta_json',
    ];

    protected $casts = [
        'meta_json' => 'array',
    ];
}
