<?php

namespace App\Http\Controllers\GameFinal;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Controller;
use App\Jobs\GameFinal\BroadcastGameStateJob;
use App\Models\GameFinal\Game;
use App\Models\GameFinal\GameAuditLog;
use App\Models\GameFinal\GameBet;
use App\Models\GameFinal\GameWalletJournal;
use App\Services\GameFinal\BetService;
use App\Services\GameFinal\RoundService;
use App\Services\GameFinal\HeartbeatService;
use App\Services\GameFinal\SettlementService;
use App\Services\GameFinal\GameTokenService;
use App\Services\GameFinal\GameConfigService;
use App\Services\GameFinal\GameUserService;
use App\Services\GameFinal\GameStateCacheService;
use App\Services\GameFinal\GameRuntimeService;
use App\Services\GameFinal\WalletService;

class GameApiController extends Controller
{
    protected $bets;
    protected $rounds;
    protected $heartbeats;
    protected $settlements;
    protected $tokens;
    protected $configs;
    protected $users;
    protected $cache;
    protected $wallets;
    protected $runtime;

    public function __construct(BetService $bets, RoundService $rounds, HeartbeatService $heartbeats, SettlementService $settlements, GameTokenService $tokens, GameConfigService $configs, GameUserService $users, GameStateCacheService $cache, WalletService $wallets, GameRuntimeService $runtime)
    {
        $this->bets = $bets;
        $this->rounds = $rounds;
        $this->heartbeats = $heartbeats;
        $this->settlements = $settlements;
        $this->tokens = $tokens;
        $this->configs = $configs;
        $this->users = $users;
        $this->cache = $cache;
        $this->wallets = $wallets;
        $this->runtime = $runtime;
    }

    protected function runtimeGateResponse(string $gameCode, $user)
    {
        $mode = $this->runtime->maintenanceState($gameCode, $user);
        if (empty($mode['active']) || !empty($mode['allowed'])) {
            return null;
        }

        return response()->json([
            'st' => false,
            'maintenance' => true,
            'code' => 'game_maintenance',
            'status' => (string) ($mode['status'] ?? 'maintenance'),
            'message' => (string) ($mode['message'] ?? 'This game is in maintenance. Please wait.'),
            'allowed_user_ids' => (array) ($mode['allowed_user_ids'] ?? []),
        ], 423);
    }

    protected function resolveSessionUser(Request $request, $gameCode = null)
    {
        $sessionToken = $request->header('X-Game-Session') ?: $request->post('session_token');
        if ($sessionToken) {
            return $this->tokens->resolveSessionUser(
                $sessionToken,
                $gameCode,
                $request->ip(),
                $request->userAgent(),
                $this->tokens->clientKeyFromRequest($request),
                $this->tokens->fingerprintFromRequest($request)
            );
        }

        if (!config('bd_game_final.allow_direct_api_token_entry', false)) {
            return null;
        }

        [$user, ] = $this->users->resolvePlayableUser($request, $gameCode);
        return $user;
    }

    protected function emptyBoardMap($gameCode)
    {
        $map = [];
        foreach (($this->configs->get($gameCode)['boards'] ?? []) as $board) {
            $map[$board['canonical_key']] = 0.0;
        }
        return $map;
    }

    protected function roundBoardStats($gameCode, $round)
    {
        $totals = $this->emptyBoardMap($gameCode);
        $players = $this->emptyBoardMap($gameCode);

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

    protected function userBetSummary($gameCode, $round, $user)
    {
        $totals = $this->emptyBoardMap($gameCode);
        $bets = collect();
        $totalAmount = 0.0;
        $totalWinAmount = 0.0;

        if ($round) {
            $bets = GameBet::where('game_round_id', $round->id)
                ->where('user_id', $user->id)
                ->orderBy('id')
                ->get(['frontend_board_key', 'canonical_board_key', 'amount', 'potential_win', 'status', 'win_balance', 'settled_at']);

            foreach ($bets as $bet) {
                $key = (string) $bet->canonical_board_key;
                $amount = (float) $bet->amount;
                $totals[$key] = ($totals[$key] ?? 0.0) + $amount;
                $totalAmount += $amount;
                $totalWinAmount += (float) ($bet->win_balance ?? 0);
            }
        }

        return [
            'bets' => $bets,
            'totals' => $totals,
            'total_amount' => $totalAmount,
            'total_win_amount' => $totalWinAmount,
        ];
    }

    protected function boardHistory($gameCode, $limit = 15)
    {
        return collect($this->rounds->recentWinners($gameCode, $limit))
            ->map(function (array $item) {
                return [
                    'round_no' => (string) ($item['round_no'] ?? ''),
                    'winner_board_key' => (string) ($item['winner_board_key'] ?? ''),
                    'decision_mode' => (string) ($item['decision_mode'] ?? ''),
                ];
            })
            ->values()
            ->all();
    }

    protected function userBetHistory($gameCode, $user, $limit = 15)
    {
        $gameId = Game::where('game_code', $gameCode)->value('id');
        if (!$gameId) {
            return [];
        }

        $betHistory = GameBet::query()
            ->where('game_id', $gameId)
            ->where('user_id', $user->id)
            ->orderByDesc('id')
            ->limit($limit)
            ->get([
                'id',
                'request_uid',
                'round_no',
                'frontend_board_key',
                'canonical_board_key',
                'amount',
                'win_balance',
                'status',
                'settled_at',
                'created_at',
            ])
            ->map(function (GameBet $bet) {
                $status = (string) ($bet->status ?: 'pending');
                $statusLabel = $status === 'won' ? 'Win' : ($status === 'lost' ? 'Loss' : ($status === 'punishment' ? 'Punishment' : 'Pending'));
                $resultAmount = $status === 'won'
                    ? (float) ($bet->win_balance ?? 0)
                    : ($status === 'lost' ? (float) $bet->amount : ($status === 'punishment' ? -1 * (float) $bet->amount : 0.0));

                return [
                    'bet_id' => (int) $bet->id,
                    'trace_id' => (string) ($bet->request_uid ?: ('bet-' . $bet->id)),
                    'round_id' => (string) $bet->round_no,
                    'round_no' => (string) $bet->round_no,
                    'board_key' => (string) $bet->canonical_board_key,
                    'frontend_board_key' => (string) $bet->frontend_board_key,
                    'amount' => (float) $bet->amount,
                    'win_amount' => (float) ($bet->win_balance ?? 0),
                    'result_amount' => $resultAmount,
                    'status' => $status,
                    'status_label' => $statusLabel,
                    'settled_at' => $bet->settled_at ? $bet->settled_at->timestamp : null,
                    'created_at' => $bet->created_at ? $bet->created_at->timestamp : null,
                ];
            })
            ->values();

        $penaltyHistory = GameWalletJournal::query()
            ->where('game_id', $gameId)
            ->where('user_id', $user->id)
            ->where('direction', 'debit')
            ->where('reason', 'inactivity_penalty')
            ->orderByDesc('id')
            ->limit($limit)
            ->get([
                'id',
                'reference_uid',
                'amount',
                'balance_after',
                'reason',
                'meta_json',
                'created_at',
                'game_round_id',
            ])
            ->map(function (GameWalletJournal $journal) {
                $meta = is_array($journal->meta_json) ? $journal->meta_json : [];
                $roundNo = (string) ($meta['attempted_round_no'] ?? $meta['current_round_no'] ?? $journal->game_round_id ?? '');
                $boardKey = (string) ($meta['attempted_board_key'] ?? $meta['canonical_board_key'] ?? '');
                $amount = (float) $journal->amount;

                return [
                    'bet_id' => null,
                    'trace_id' => (string) ($journal->reference_uid ?: ('punishment-' . $journal->id)),
                    'round_id' => $roundNo,
                    'round_no' => $roundNo,
                    'board_key' => $boardKey,
                    'frontend_board_key' => (string) ($meta['frontend_board_key'] ?? $boardKey),
                    'amount' => $amount,
                    'win_amount' => 0.0,
                    'result_amount' => -1 * $amount,
                    'status' => 'punishment',
                    'status_label' => 'Punishment',
                    'punishment_reason' => (string) ($meta['penalty_reason'] ?? $journal->reason),
                    'settled_at' => $journal->created_at ? $journal->created_at->timestamp : null,
                    'created_at' => $journal->created_at ? $journal->created_at->timestamp : null,
                ];
            })
            ->values();

        return $betHistory
            ->concat($penaltyHistory)
            ->sortByDesc(function (array $row) {
                return (int) ($row['created_at'] ?? 0);
            })
            ->take($limit)
            ->values()
            ->all();
    }

    protected function activePlayers($gameCode, $viewer = null, $limit = 120)
    {
        $game = Game::where('game_code', $gameCode)->first(['id']);
        if (!$game) {
            return [];
        }

        $heartbeatsTable = config('bd_game_final.tables.heartbeats', 'bd_game_final_heartbeats');
        $betsTable = config('bd_game_final.tables.bets', 'bd_game_final_bets');
        $activeWindowSeconds = max(60, (int) config('bd_game_final.security.inactive_penalty_threshold_seconds', 25) * 2);
        $imageColumns = [];
        foreach (['image', 'avatar', 'profile_image', 'photo', 'image_url', 'avatar_url', 'user_image'] as $column) {
            if (Schema::hasColumn('users', $column)) {
                $imageColumns[] = $column;
            }
        }

        $winTotals = DB::table($betsTable)
            ->select('user_id', DB::raw('COALESCE(SUM(win_balance), 0) as game_win_amount'))
            ->where('game_id', $game->id)
            ->where('status', 'won')
            ->groupBy('user_id');

        $selects = [
            'hb.user_id',
            'hb.last_seen_at',
            'users.name',
            DB::raw('COALESCE(wins.game_win_amount, 0) as game_win_amount'),
        ];
        foreach ($imageColumns as $column) {
            $selects[] = 'users.' . $column . ' as ' . $column;
        }

        $rows = DB::table($heartbeatsTable . ' as hb')
            ->join('users', 'users.id', '=', 'hb.user_id')
            ->leftJoinSub($winTotals, 'wins', function ($join) {
                $join->on('wins.user_id', '=', 'hb.user_id');
            })
            ->where('hb.game_id', $game->id)
            ->where('hb.last_seen_at', '>=', now()->subSeconds($activeWindowSeconds))
            ->orderByDesc('hb.last_seen_at')
            ->limit(max(1, min(200, (int) $limit)))
            ->get($selects);

        $players = $rows->map(function ($row) use ($viewer, $imageColumns) {
            $name = trim((string) ($row->name ?: ('Player ' . $row->user_id)));
            $image = '';
            foreach ($imageColumns as $column) {
                if (!empty($row->{$column})) {
                    $image = (string) $row->{$column};
                    break;
                }
            }

            return [
                'id' => (int) $row->user_id,
                'name' => $name,
                'initial' => mb_strtoupper(mb_substr($name, 0, 1, 'UTF-8'), 'UTF-8') ?: 'P',
                'image' => $image,
                'avatar' => $image,
                'game_win_amount' => (float) ($row->game_win_amount ?? 0),
                'is_me' => $viewer && (int) $viewer->id === (int) $row->user_id,
                'last_seen_at' => $row->last_seen_at ? strtotime((string) $row->last_seen_at) : null,
            ];
        })->values();

        if ($viewer && !$players->contains('id', (int) $viewer->id)) {
            $name = trim((string) ($viewer->name ?: ('Player ' . $viewer->id)));
            $players->prepend([
                'id' => (int) $viewer->id,
                'name' => $name,
                'initial' => mb_strtoupper(mb_substr($name, 0, 1, 'UTF-8'), 'UTF-8') ?: 'P',
                'image' => '',
                'avatar' => '',
                'game_win_amount' => 0.0,
                'is_me' => true,
                'last_seen_at' => now()->timestamp,
            ]);
        }

        return $players->values()->all();
    }

    protected function timingPayload($gameCode, $round)
    {
        $cfg = $this->configs->get($gameCode);
        $durations = $this->rounds->phaseDurations($cfg);
        $markers = $this->rounds->timelineMarkers($round, $cfg);

        return [
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
            'next_round_at' => $markers['next_round_at'],
        ];
    }

    protected function buildPublicState($gameCode)
    {
        $cfg = $this->configs->get($gameCode);
        $this->settlements->settleDueRounds($gameCode);
        $round = $this->rounds->getState($gameCode);
        $settlement = null;
        if ($round && $round->status === 'settled') {
            $settlement = $this->settlements->settleRound($round);
            $round = $this->rounds->getState($gameCode);
        }
        [$boardTotals, $boardPlayers] = $this->roundBoardStats($gameCode, $round);

        $phase = $round ? (string) $round->status : null;
        $revealAllowed = $this->shouldRevealResult($phase);
        $runtimeSettings = $this->runtime->settings();
        $timeline = $this->rounds->timelineMarkers($round, $cfg);

        return array_merge([
            'st' => true,
            'game_code' => $gameCode,
            'game_key' => $gameCode,
            'room_key' => $gameCode,
            'config_version' => $this->runtime->configVersion($runtimeSettings),
            'config_updated_at' => $this->runtime->configUpdatedAt($runtimeSettings),
            'round_no' => $round ? $round->round_no : null,
            'phase' => $phase,
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
            'winner_board' => ($round && $revealAllowed) ? $round->winner_board_key : null,
            'result' => ($round && $revealAllowed) ? $round->result_payload_json : null,
            'boards' => $cfg['boards'] ?? [],
            'rules' => $cfg['rules'] ?? [
                'board_count' => max(1, count((array) ($cfg['boards'] ?? []))),
                'max_distinct_boards_per_user' => (int) ($cfg['max_distinct_boards_per_user'] ?? 1),
            ],
            'board_totals' => $boardTotals,
            'board_players' => $boardPlayers,
            'recent' => $this->rounds->recentWinners($gameCode, 10),
            'settlement' => $settlement ? [
                'id' => $settlement->id,
                'status' => $settlement->settlement_status,
                'winner_board' => $settlement->winner_board_key,
                'total_bet_amount' => (float) $settlement->total_bet_amount,
                'total_payout_amount' => (float) $settlement->total_payout_amount,
            ] : null,
        ], $this->timingPayload($gameCode, $round));
    }

    public function startToPlay(Request $request, $gameCode)
    {
        [$user, $reason] = $this->users->resolvePlayableUser($request, $gameCode);
        abort_unless($user, 401, $reason ?: 'user_required');

        $device = $this->tokens->fingerprintFromRequest($request);
        $issued = $this->tokens->issueEntryToken($gameCode, $user->id, $device, ['issued_from' => auth()->check() ? 'api_start_to_play_auth' : 'api_start_to_play_api_token']);
        $plain = $issued['plain_token'] ?? null;
        abort_unless($plain, 404, 'invalid_game_code');

        return response()->json([
            'st' => true,
            'game_code' => $gameCode,
            'game_token' => $plain,
            'entry_url' => route('game-final.entry', ['gameCode' => $gameCode]),
            'start_url' => route('game-final.start', ['gameCode' => $gameCode]),
        ]);
    }

    public function issueEntryToken(Request $request, $gameCode)
    {
        [$user, $reason] = $this->users->resolvePlayableUser($request, $gameCode);
        abort_unless($user, 401, $reason ?: 'user_required');

        $device = $this->tokens->fingerprintFromRequest($request);
        $issued = $this->tokens->issueEntryToken($gameCode, $user->id, $device, ['issued_from' => auth()->check() ? 'auth_session_issue_entry' : 'api_token_issue_entry']);
        $plain = $issued['plain_token'] ?? null;
        abort_unless($plain, 404, 'invalid_game_code');

        return response()->json([
            'st' => true,
            'game_code' => $gameCode,
            'game_token' => $plain,
            'entry_url' => route('game-final.entry', ['gameCode' => $gameCode]),
        ]);
    }

    public function state(Request $request, $gameCode)
    {
        $user = $this->resolveSessionUser($request, $gameCode);
        abort_unless($user, 401, 'invalid_session');
        if ($gate = $this->runtimeGateResponse($gameCode, $user)) {
            return $gate;
        }

        $public = $this->cache->rememberPublicState($gameCode, function () use ($gameCode) {
            return $this->buildPublicState($gameCode);
        });

        $liveRound = $this->rounds->getState($gameCode);
        $roundMismatch = ($public['round_no'] ?? null) !== ($liveRound ? $liveRound->round_no : null)
            || ($public['phase'] ?? null) !== ($liveRound ? $liveRound->status : null)
            || ($public['winner_board'] ?? null) !== ($liveRound ? $liveRound->winner_board_key : null);
        if ($roundMismatch) {
            $this->cache->forgetPublicState($gameCode);
            $public = $this->buildPublicState($gameCode);
            $liveRound = $this->rounds->getState($gameCode);
        }

        $public['server_time'] = now()->timestamp;
        $public['round_no'] = $liveRound ? $liveRound->round_no : null;
        $public['phase'] = $liveRound ? $liveRound->status : null;
        $latestCfg = $this->configs->get($gameCode);
        $timeline = $this->rounds->timelineMarkers($liveRound, $latestCfg);
        $public['start_at'] = $timeline['start_at'];
        $public['bet_countdown_start_at'] = $timeline['bet_countdown_start_at'];
        $public['bet_close_at'] = $timeline['bet_close_at'];
        $public['reveal_at'] = $timeline['reveal_at'];
        $public['reveal_done_at'] = $timeline['reveal_done_at'];
        $public['winner_popup_at'] = $timeline['winner_popup_at'];
        $public['winner_popup_end_at'] = $timeline['winner_popup_end_at'];
        $public['settle_at'] = $timeline['settle_at'];
        $public['payout_end_at'] = $timeline['payout_end_at'];
        $revealAllowed = $this->shouldRevealResult($public['phase'] ?? null);
        $public['winner_board'] = ($liveRound && $revealAllowed) ? $liveRound->winner_board_key : null;
        $public['result'] = ($liveRound && $revealAllowed) ? $liveRound->result_payload_json : null;
        $runtimeSettings = $this->runtime->settings();
        $public['game_key'] = $gameCode;
        $public['room_key'] = $gameCode;
        $public['config_version'] = $this->runtime->configVersion($runtimeSettings);
        $public['config_updated_at'] = $this->runtime->configUpdatedAt($runtimeSettings);
        $public['phase_durations'] = $this->timingPayload($gameCode, $liveRound)['phase_durations'];
        $public['next_round_at'] = $this->timingPayload($gameCode, $liveRound)['next_round_at'];

        $round = !empty($public['round_no']) ? $this->rounds->getByRoundNo($gameCode, $public['round_no']) : null;
        if (!$round) {
            $round = $this->rounds->getOrCreateOpenRound($gameCode);
        }
        $summary = $this->userBetSummary($gameCode, $round, $user);
        $activePlayers = $this->activePlayers($gameCode, $user);

        return response()->json(array_merge($public, [
            'balance' => (float) $this->wallets->currentBalance($user->fresh()),
            'my_bets' => $summary['bets'],
            'my_bet_totals' => $summary['totals'],
            'my_total_bet_amount' => $summary['total_amount'],
            'my_total_win_amount' => $summary['total_win_amount'],
            'active_users' => count($activePlayers),
            'active_players' => $activePlayers,
        ]));
    }

    public function bet(Request $request, $gameCode)
    {
        $user = $this->resolveSessionUser($request, $gameCode);
        abort_unless($user, 401, 'invalid_session');
        if ($gate = $this->runtimeGateResponse($gameCode, $user)) {
            return $gate;
        }

        $play = $this->users->canPlay($user);
        if (empty($play['ok'])) {
            return response()->json(['st' => false, 'msg' => (string) ($play['reason'] ?? 'user_not_allowed')]);
        }

        $requestUid = $request->get('request_uid')
            ?: $request->header('X-Request-Id')
            ?: $request->header('Idempotency-Key');

        $result = $this->bets->placeBet($gameCode, $user, $request->get('round_no'), $request->get('board_key'), $request->get('amount'), $requestUid);
        if (!empty($result['st'])) {
            $this->cache->forgetPublicState($gameCode);
            if (config('bd_game_final.jobs.dispatch_via_queue', false)) {
                BroadcastGameStateJob::dispatch($gameCode);
            } else {
                BroadcastGameStateJob::dispatchAfterResponse($gameCode);
            }
        }
        return response()->json($result);
    }

    public function heartbeat(Request $request, $gameCode)
    {
        $user = $this->resolveSessionUser($request, $gameCode);
        abort_unless($user, 401, 'invalid_session');
        if ($gate = $this->runtimeGateResponse($gameCode, $user)) {
            return $gate;
        }
        $round = $this->rounds->latestRoundSnapshot($gameCode);
        $this->heartbeats->touch($gameCode, $user->id, $round ? $round->id : null, $request->get('network_ms'), [
            'ua' => substr((string) $request->userAgent(), 0, 255),
            'visibility' => in_array((string) $request->get('client_visibility', 'visible'), ['visible', 'hidden'], true) ? (string) $request->get('client_visibility', 'visible') : 'visible',
            'hidden_ms' => max(0, min((int) $request->get('client_hidden_ms', 0), 86400000)),
            'offline_ms' => max(0, min((int) $request->get('client_offline_ms', 0), 86400000)),
            'inactive_ms' => max(0, min((int) $request->get('client_inactive_ms', 0), 86400000)),
            'client_round_no' => substr((string) $request->get('client_round_no', ''), 0, 60),
            'client_phase' => substr((string) $request->get('client_phase', ''), 0, 60),
        ]);
        $runtimeSettings = $this->runtime->settings();

        return response()->json([
            'st' => true,
            'game_key' => $gameCode,
            'room_key' => $gameCode,
            'config_version' => $this->runtime->configVersion($runtimeSettings),
            'config_updated_at' => $this->runtime->configUpdatedAt($runtimeSettings),
            'phase' => $round ? $round->status : null,
            'round_no' => $round ? $round->round_no : null,
        ]);
    }

    public function history(Request $request, $gameCode)
    {
        $user = $this->resolveSessionUser($request, $gameCode);
        abort_unless($user, 401, 'invalid_session');
        if ($gate = $this->runtimeGateResponse($gameCode, $user)) {
            return $gate;
        }

        $boardHistory = $this->boardHistory($gameCode, 15);
        $activePlayers = $this->activePlayers($gameCode, $user);

        return response()->json([
            'st' => true,
            'game_code' => $gameCode,
            'recent' => $boardHistory,
            'board_history' => $boardHistory,
            'active_users' => count($activePlayers),
            'active_players' => $activePlayers,
        ]);
    }

    public function myBets(Request $request, $gameCode)
    {
        $user = $this->resolveSessionUser($request, $gameCode);
        abort_unless($user, 401, 'invalid_session');
        if ($gate = $this->runtimeGateResponse($gameCode, $user)) {
            return $gate;
        }
        $round = $this->rounds->getState($gameCode);
        if (!$round) {
            $round = $this->rounds->getOrCreateOpenRound($gameCode);
        }
        $summary = $this->userBetSummary($gameCode, $round, $user);
        $history = $this->userBetHistory($gameCode, $user, 15);
        $activePlayers = $this->activePlayers($gameCode, $user);

        return response()->json([
            'st' => true,
            'round_no' => $round ? $round->round_no : null,
            'data' => $summary['bets'],
            'totals' => $summary['totals'],
            'total_amount' => $summary['total_amount'],
            'total_win_amount' => $summary['total_win_amount'],
            'history' => $history,
            'bet_history' => $history,
            'active_users' => count($activePlayers),
            'active_players' => $activePlayers,
        ]);
    }

    public function securityReport(Request $request, $gameCode)
    {
        $user = $this->resolveSessionUser($request, $gameCode);
        abort_unless($user, 401, 'invalid_session');

        $reason = trim((string) $request->get('reason', 'browser security report'));
        $reason = preg_replace('/\s+/', ' ', $reason) ?: 'browser security report';
        $reason = substr('Browser security report: ' . $reason, 0, 255);
        $gameId = Game::where('game_code', $gameCode)->value('id');

        GameAuditLog::create([
            'game_id' => $gameId ? (int) $gameId : null,
            'user_id' => $user->id,
            'event_type' => 'client_security_report',
            'message' => 'Client security report recorded',
            'payload_json' => [
                'reason' => $reason,
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 255),
                'session_token_present' => (bool) ($request->header('X-Game-Session') ?: $request->post('session_token')),
            ],
        ]);

        return response()->json([
            'st' => true,
            'blocked' => false,
            'code' => 'security_report_recorded',
            'msg' => 'Security report recorded.',
            'message' => 'Security report recorded.',
            'reason' => $reason,
        ]);
    }

    protected function shouldRevealResult($phase): bool
    {
        return in_array((string) $phase, ['revealed', 'settled'], true);
    }
}
