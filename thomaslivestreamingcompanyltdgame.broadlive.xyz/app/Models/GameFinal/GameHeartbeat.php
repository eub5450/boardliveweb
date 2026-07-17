<?php

namespace App\Models\GameFinal;

use Illuminate\Database\Eloquent\Model;

class GameHeartbeat extends Model
{
    protected $table = 'bd_game_final_heartbeats';

    protected $fillable = [
        'game_id',
        'user_id',
        'game_round_id',
        'network_ms',
        'client_meta_json',
        'last_seen_at',
    ];

    protected $casts = [
        'client_meta_json' => 'array',
        'last_seen_at' => 'datetime',
    ];
}
