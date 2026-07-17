<?php

namespace App\Models\GameFinal;

use Illuminate\Database\Eloquent\Model;

class GameRound extends Model
{
    protected $table = 'bd_game_final_rounds';

    protected $fillable = [
        'game_id',
        'round_no',
        'start_at',
        'bet_close_at',
        'reveal_at',
        'settle_at',
        'status',
        'winner_board_key',
        'decision_mode',
        'decision_snapshot_json',
        'result_payload_json',
    ];

    protected $casts = [
        'decision_snapshot_json' => 'array',
        'result_payload_json' => 'array',
        'start_at' => 'datetime',
        'bet_close_at' => 'datetime',
        'reveal_at' => 'datetime',
        'settle_at' => 'datetime',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
}
