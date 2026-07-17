<?php

namespace App\Models\GameFinal;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'bd_game_final_games';

    protected $fillable = [
        'game_code',
        'name',
        'is_active',
        'frontend_slug',
        'sort_order',
    ];

    public function setting()
    {
        return $this->hasOne(GameSetting::class, 'game_id');
    }

    public function boards()
    {
        return $this->hasMany(GameBoard::class, 'game_id');
    }
}
