<?php

namespace App\Models\GameFinal;

use Illuminate\Database\Eloquent\Model;

class GameWalletJournal extends Model
{
    protected $table = 'bd_game_final_wallet_journals';

    protected $fillable = [
        'game_id',
        'game_round_id',
        'game_bet_id',
        'game_settlement_id',
        'game_settlement_item_id',
        'reference_uid',
        'user_id',
        'direction',
        'amount',
        'balance_before',
        'balance_after',
        'reason',
        'meta_json',
    ];

    protected $casts = [
        'meta_json' => 'array',
    ];
}
