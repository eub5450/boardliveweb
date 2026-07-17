<?php

namespace App\Models\GameFinal;

use Illuminate\Database\Eloquent\Model;

class GameSecurityBlock extends Model
{
    protected $table = 'bd_game_final_security_blocks';

    protected $fillable = [
        'game_id',
        'user_id',
        'reason',
        'trigger',
        'ip_address',
        'user_agent',
        'status',
        'blocked_at',
        'lifted_at',
        'meta_json',
    ];

    protected $casts = [
        'blocked_at' => 'datetime',
        'lifted_at' => 'datetime',
        'meta_json' => 'array',
    ];
}
