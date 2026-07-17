<?php

namespace App\Models\GameFinal;

use Illuminate\Database\Eloquent\Model;

class GameBoard extends Model
{
    protected $table = 'bd_game_final_boards';

    protected $fillable = [
        'game_id',
        'frontend_key',
        'canonical_key',
        'display_name',
        'payout_multiplier',
        'display_order',
        'is_active',
        'ui_meta_json',
    ];

    protected $casts = [
        'ui_meta_json' => 'array',
    ];
}
