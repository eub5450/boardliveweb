<?php

namespace App\Services\GameFinal;

use Carbon\Carbon;
use App\Models\GameFinal\Game;
use App\Models\GameFinal\GameHeartbeat;

class HeartbeatService
{
    public function latest(string $gameCode, int $userId): ?GameHeartbeat
    {
        $game = Game::where('game_code', $gameCode)->first();
        if (!$game) {
            return null;
        }

        return GameHeartbeat::query()
            ->where('game_id', $game->id)
            ->where('user_id', $userId)
            ->latest('id')
            ->first();
    }

    public function touch($gameCode, $userId, $roundId = null, $networkMs = null, array $clientMeta = [])
    {
        $game = Game::where('game_code', $gameCode)->first();
        if (!$game) {
            return null;
        }

        $row = GameHeartbeat::firstOrNew([
            'game_id' => $game->id,
            'user_id' => $userId,
        ]);

        $row->game_round_id = $roundId;
        $row->last_seen_at = Carbon::now();
        $row->network_ms = $networkMs;
        $row->client_meta_json = is_array($clientMeta) ? $clientMeta : [];
        $row->save();

        return $row;
    }
}
