<?php

namespace App\Models\GameFinal;

use Illuminate\Database\Eloquent\Model;

class GameAccessToken extends Model
{
    protected $table = 'bd_game_final_tokens';

    protected $fillable = [
        'game_id',
        'user_id',
        'token_hash',
        'token_type',
        'parent_token_id',
        'device_fingerprint',
        'meta_json',
        'issued_at',
        'last_seen_at',
        'expires_at',
        'revoked_at',
    ];

    protected $casts = [
        'meta_json'    => 'array',
        'issued_at'    => 'datetime',
        'last_seen_at' => 'datetime',
        'expires_at'   => 'datetime',
        'revoked_at'   => 'datetime',
    ];
}