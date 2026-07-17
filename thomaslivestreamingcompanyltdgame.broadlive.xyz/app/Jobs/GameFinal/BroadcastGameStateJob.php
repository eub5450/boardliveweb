<?php

namespace App\Jobs\GameFinal;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Models\GameFinal\Game;
use App\Services\GameFinal\RoundService;
use App\Services\GameFinal\SettlementService;
use App\Services\GameFinal\GameConfigService;
use App\Services\GameFinal\GameStateCacheService;
use App\Services\GameFinal\GameRealtimeService;

class BroadcastGameStateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $gameCode;

    public function __construct($gameCode)
    {
        $this->gameCode = $gameCode;
        $this->onQueue((string) config('bd_game_final.jobs.queue', 'default'));
    }

    protected function emptyBoardMap(array $boards): array
    {
        $map = [];
        foreach ($boards as $board) {
            $key = (string) ($board['canonical_key'] ?? '');
            if ($key !== '') {
                $map[$key] = 0.0;
            }
        }
        return $map;
    }

    protected function roundBoardStats($round, array $boards): array
    {
        $totals = $this->emptyBoardMap($boards);
        $players = $this->emptyBoardMap($boards);
        if (!$round) {
            return [$totals, $players];
        }

        $rows = DB::table(config('bd_game_final.tables.bets'))
            ->selectRaw('canonical_board_key, SUM(amount) as total_amount, COUNT(DISTINCT user_id) as total_players')
            ->where('game_round_id', $round->id)
            ->groupBy('canonical_board_key')
            ->get();

        foreach ($rows as $row) {
            $key = (string) $row->canonical_board_key;
            $totals[$key] = (float) $row->total_amount;
            $players[$key] = (int) $row->total_players;
        }

        return [$totals, $players];
    }

    public function handle(RoundService $rounds, SettlementService $settlements, GameConfigService $configs, GameStateCacheService $cache, GameRealtimeService $realtime)
    {
        $settlements->settleDueRounds($this->gameCode);
        $round = $rounds->getState($this->gameCode);
        $cfg = $configs->get($this->gameCode);
        $phase = $round ? (string) $round->status : null;
        $revealAllowed = in_array($phase, ['revealed', 'settled'], true);
        $durations = $rounds->phaseDurations($cfg);
        $timeline = $rounds->timelineMarkers($round, $cfg);
        [$boardTotals, $boardPlayers] = $this->roundBoardStats($round, (array) ($cfg['boards'] ?? []));

        $gameId = Game::where('game_code', $this->gameCode)->value('id');
        $settlement = null;
        if ($round) {
            $settlement = DB::table(config('bd_game_final.tables.settlements'))
                ->where('game_round_id', $round->id)
                ->latest('id')
                ->first();
        }

        $payload = [
            'st' => true,
            'game_code' => $this->gameCode,
            'game_key' => $this->gameCode,
            'room_key' => $this->gameCode,
            'config_version' => (int) config('bd_game_final.realtime.config_version', 1),
            'config_updated_at' => config('bd_game_final.realtime.config_updated_at'),
            'game_id' => $gameId ? (int) $gameId : null,
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
            'board_totals' => $boardTotals,
            'board_players' => $boardPlayers,
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
            'rules' => $cfg['rules'] ?? [
                'board_count' => max(1, count((array) ($cfg['boards'] ?? []))),
                'max_distinct_boards_per_user' => (int) ($cfg['max_distinct_boards_per_user'] ?? 1),
            ],
            'settlement' => $settlement ? [
                'id' => (int) ($settlement->id ?? 0),
                'status' => (string) ($settlement->settlement_status ?? ''),
                'winner_board' => (string) ($settlement->winner_board_key ?? ''),
                'total_bet_amount' => (float) ($settlement->total_bet_amount ?? 0),
                'total_payout_amount' => (float) ($settlement->total_payout_amount ?? 0),
            ] : null,
            'source' => 'job_broadcast',
        ];
        $cache->putPublicState($this->gameCode, $payload);
        $realtime->broadcastState($this->gameCode, $payload);
    }
}
