<?php

namespace App\Events\GameFinal;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameStateChanged implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $gameCode;
    public $payload;

    public function __construct($gameCode, array $payload)
    {
        $this->gameCode = $gameCode;
        $this->payload = $payload;
    }

    public function broadcastOn()
    {
        return new Channel((string) config('bd_game_final.realtime.channel_prefix', 'bdgamefinal.') . $this->gameCode);
    }

    public function broadcastAs()
    {
        return (string) config('bd_game_final.realtime.broadcast_event', 'bd.game.state');
    }

    public function broadcastWith()
    {
        return $this->payload;
    }
}
