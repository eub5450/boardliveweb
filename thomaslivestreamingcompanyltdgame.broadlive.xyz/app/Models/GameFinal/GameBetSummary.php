<?php

namespace App\Models\GameFinal;

use Illuminate\Database\Eloquent\Model;

class GameBetSummary extends Model
{
    protected $table = 'bd_game_final_bet_summaries';

    protected $fillable = [
        'game_id',
        'game_round_id',
        'canonical_board_key',
        'total_amount',
        'total_players',
        'potential_payout',
    ];
}
