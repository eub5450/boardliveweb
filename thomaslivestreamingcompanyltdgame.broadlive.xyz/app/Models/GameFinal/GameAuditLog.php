<?php

namespace App\Models\GameFinal;

use Illuminate\Database\Eloquent\Model;

class GameAuditLog extends Model
{
    protected $table = 'bd_game_final_audit_logs';

    protected $fillable = [
        'game_id',
        'game_round_id',
        'user_id',
        'event_type',
        'message',
        'payload_json',
    ];

    protected $casts = [
        'payload_json' => 'array',
    ];
}
