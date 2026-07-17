<?php

namespace App\Jobs\GameFinal;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use App\Services\GameFinal\RoundService;
use App\Services\GameFinal\SettlementService;
use App\Services\GameFinal\GameConfigService;
use App\Services\GameFinal\GameStateCacheService;
use App\Services\GameFinal\GameRealtimeService;

class AdvanceGameRoundJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $gameCode;

    public function __construct($gameCode)
    {
        $this->gameCode = $gameCode;
        $this->onQueue((string) config('bd_game_final.jobs.queue', 'default'));
    }

    public function handle(RoundService $rounds, SettlementService $settlements, GameConfigService $configs, GameStateCacheService $cache, GameRealtimeService $realtime)
    {
        $lockKey = 'bdgf:advance-lock:' . $this->gameCode;
        $lockSeconds = max(3, (int) config('bd_game_final.jobs.advance_lock_seconds', 5));
        if (!Cache::add($lockKey, 1, $lockSeconds)) {
            return;
        }

        try {
        $settlements->settleDueRounds($this->gameCode);
        $round = $rounds->getState($this->gameCode);
        $cfg = $configs->get($this->gameCode);
        if ($round && $round->status === 'settled') {
            $settlements->settleRound($round);
            $settlements->settleDueRounds($this->gameCode);
            $round = $rounds->getState($this->gameCode);
        }

        $phase = $round ? (string) $round->status : null;
        $revealAllowed = in_array($phase, ['revealed', 'settled'], true);
        $durations = $rounds->phaseDurations($cfg);
        $timeline = $rounds->timelineMarkers($round, $cfg);

        $payload = [
            'st' => true,
            'game_code' => $this->gameCode,
            'game_key' => $this->gameCode,
            'room_key' => $this->gameCode,
            'config_version' => (int) config('bd_game_final.realtime.config_version', 1),
            'config_updated_at' => config('bd_game_final.realtime.config_updated_at'),
            'round_no' => $round ? $round->round_no : null,
            'phase' => $round ? $round->status : null,
            'server_time' => now()->timestamp,
            'start_at' => $timeline['start_at'],
            'bet_countdown_start_at' => $timeline['bet_countdown_start_at'],
            'bet_close_at' => $timeline['bet_close_at'],
            'reveal_at' => $timeline['reveal_at'],
            'reveal_done_at' => $timeline['reveal_done_at'],
            'winner_popup_at' => $timeline['winner_popup_at'],
            'winner_popup_end_at' => $timeline['winner_popup_end_at'],
            'settle_at' => $timeline['settle_at'],
            'payout_end_at' => $timeline['payout_end_at'],
            'next_round_at' => $timeline['next_round_at'],
            'winner_board' => ($round && $revealAllowed) ? $round->winner_board_key : null,
            'result' => ($round && $revealAllowed) ? $round->result_payload_json : null,
            'boards' => $cfg['boards'] ?? [],
            'phase_durations' => [
                'betting' => $durations['betting'],
                'start_popup' => $durations['start_popup'],
                'start_wait' => $durations['start_wait'],
                'stop_popup' => $durations['stop_popup'],
                'stop_wait' => $durations['stop_wait'],
                'locked' => $durations['locked'],
                'reveal_main' => $durations['reveal_main'],
                'reveal_wait' => $durations['reveal_wait'],
                'winner_popup' => $durations['winner_popup'],
                'winner_wait' => $durations['winner_wait'],
                'revealed' => $durations['revealed'],
                'payout' => $durations['payout'],
                'settle_wait' => $durations['settle_wait'],
                'settled' => $durations['settled'],
            ],
            'recent' => $rounds->recentWinners($this->gameCode, 10),
            'source' => 'job_tick',
        ];

        $cache->putPublicState($this->gameCode, $payload);
        $realtime->broadcastState($this->gameCode, $payload);
        } finally {
            Cache::forget($lockKey);
        }
    }
}



