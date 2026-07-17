<?php

namespace App\Http\Controllers\GameFinal;

use App\Http\Controllers\Controller;
use App\Models\GameFinal\Game;
use App\Models\GameFinal\GameAuditLog;
use App\Models\GameFinal\GameBet;
use App\Models\GameFinal\GameBetSummary;
use App\Models\GameFinal\GameBoard;
use App\Models\GameFinal\GameRound;
use App\Models\GameFinal\GameSecurityBlock;
use App\Models\GameFinal\GameSetting;
use App\Models\GameFinal\GameSettlementItem;
use App\Models\GameFinal\GameWalletJournal;
use App\Models\User;
use App\Services\GameFinal\GameAdminSecurityService;
use App\Services\GameFinal\GameBankService;
use App\Services\GameFinal\GameRuntimeService;
use App\Services\GameFinal\GameTokenService;
use App\Services\GameFinal\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class GameAdminController extends Controller
{
    protected $security;
    protected $wallets;
    protected $gameBank;
    protected $tokens;
    protected $runtime;

    public function __construct(GameAdminSecurityService $security, WalletService $wallets, GameBankService $gameBank, GameTokenService $tokens, GameRuntimeService $runtime)
    {
        $this->security = $security;
        $this->wallets = $wallets;
        $this->gameBank = $gameBank;
        $this->tokens = $tokens;
        $this->runtime = $runtime;
    }

    public function security(Request $request)
    {
        if ($this->security->isVerified($request->session())) {
            return redirect()->route('admin.dashboard');
        }

        GameAuditLog::create([
            'event_type' => 'admin_security_screen_opened',
            'user_id' => optional($request->user())->id,
            'message' => 'Admin security screen opened',
            'payload_json' => [
                'admin_user_id' => optional($request->user())->id,
                'ip' => $request->ip(),
            ],
        ]);

        return view('game_final.admin.security', [
            'helperPattern' => $this->security->helperPattern(),
            'examplePassphrases' => $this->security->examplePassphrases(),
            'adminUser' => $request->user(),
            'lockoutSeconds' => $this->security->lockoutRemainingSeconds($request->session()),
        ]);
    }

    public function verifySecurity(Request $request)
    {
        $validated = $request->validate([
            'security_pass' => ['required', 'string', 'max:200'],
        ]);

        $attempt = $this->security->verifyAndMark($request->session(), (string) $validated['security_pass']);

        if (empty($attempt['ok'])) {
            GameAuditLog::create([
                'event_type' => 'admin_security_verify_failed',
                'user_id' => optional($request->user())->id,
                'message' => 'Admin security verification failed',
                'payload_json' => [
                    'admin_user_id' => optional($request->user())->id,
                    'ip' => $request->ip(),
                    'reason' => (string) ($attempt['reason'] ?? 'unknown'),
                    'retry_after' => (int) ($attempt['retry_after'] ?? 0),
                ],
            ]);

            $reason = (string) ($attempt['reason'] ?? 'invalid_passphrase');
            if ($reason === 'locked') {
                throw ValidationException::withMessages([
                    'security_pass' => 'Too many attempts. Try again after ' . (int) ($attempt['retry_after'] ?? 0) . ' seconds.',
                ]);
            }

            if ($reason === 'secret_not_configured') {
                throw ValidationException::withMessages([
                    'security_pass' => 'Security secret is not configured. Contact administrator.',
                ]);
            }

            throw ValidationException::withMessages([
                'security_pass' => 'Security pass is incorrect.',
            ]);
        }

        GameAuditLog::create([
            'event_type' => 'admin_security_verified',
            'user_id' => optional($request->user())->id,
            'message' => 'Admin security pass verified',
            'payload_json' => [
                'admin_user_id' => optional($request->user())->id,
                'ip' => $request->ip(),
            ],
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'Security pass accepted. Game Final controls are unlocked for this session.');
    }

    public function lockSecurity(Request $request)
    {
        $this->security->forget($request->session());

        GameAuditLog::create([
            'event_type' => 'admin_security_locked',
            'user_id' => optional($request->user())->id,
            'message' => 'Admin security lock re-enabled',
            'payload_json' => [
                'admin_user_id' => optional($request->user())->id,
                'ip' => $request->ip(),
            ],
        ]);

        return redirect()
            ->route('admin.game-final.security')
            ->with('status', 'Security lock enabled again. Enter the configured security secret to continue.');
    }
    public function dashboard(Request $request)
    {
        $allGames = $this->gameRows();
        $search = trim((string) $request->query('search', ''));
        $selectedStatus = trim((string) $request->query('status', ''));
        $games = $allGames->filter(function (array $game) use ($search, $selectedStatus) {
            $matchesSearch = $search === ''
                || str_contains(strtolower($game['name']), strtolower($search))
                || str_contains(strtolower($game['game_code']), strtolower($search));
            $matchesStatus = $selectedStatus === '' || (string) $game['game_status'] === $selectedStatus;

            return $matchesSearch && $matchesStatus;
        })->values();

        return view('game_final.admin.dashboard', array_merge($this->adminViewData('dashboard', $allGames), [
            'games' => $games,
            'liveCount' => $games->where('enabled', true)->where('game_status', 'live')->count(),
            'developerCount' => $games->where('enabled', true)->where('game_status', 'developer')->count(),
            'maintenanceCount' => $games->where('enabled', true)->where('game_status', 'maintenance')->count(),
            'inactiveCount' => $games->where('enabled', false)->count(),
            'totalCount' => $games->count(),
            'runtimeControls' => $this->runtimeControlRows(),
            'search' => $search,
            'selectedStatus' => $selectedStatus,
        ]));
    }

    public function gameTime(Request $request)
    {
        $allGames = $this->gameRows();
        $search = trim((string) $request->query('search', ''));
        $selectedStatus = trim((string) $request->query('status', ''));
        $games = $allGames->filter(function (array $game) use ($search, $selectedStatus) {
            $matchesSearch = $search === ''
                || str_contains(strtolower($game['name']), strtolower($search))
                || str_contains(strtolower($game['game_code']), strtolower($search));
            $matchesStatus = $selectedStatus === '' || (string) $game['game_status'] === $selectedStatus;

            return $matchesSearch && $matchesStatus;
        })->values();

        return view('game_final.admin.dashboard', array_merge($this->adminViewData('game-time', $allGames), [
            'games' => $games,
            'liveCount' => $games->where('enabled', true)->where('game_status', 'live')->count(),
            'developerCount' => $games->where('enabled', true)->where('game_status', 'developer')->count(),
            'maintenanceCount' => $games->where('enabled', true)->where('game_status', 'maintenance')->count(),
            'inactiveCount' => $games->where('enabled', false)->count(),
            'totalCount' => $games->count(),
            'runtimeControls' => $this->runtimeControlRows(),
            'search' => $search,
            'selectedStatus' => $selectedStatus,
        ]));
    }

    public function games(Request $request)
    {
        $allRows = $this->gameDetailRows();
        $search = trim((string) $request->query('search', ''));
        $selectedStatus = trim((string) $request->query('status', ''));
        $gameRows = $allRows->filter(function (array $game) use ($search, $selectedStatus) {
            $matchesSearch = $search === ''
                || str_contains(strtolower($game['name']), strtolower($search))
                || str_contains(strtolower($game['game_code']), strtolower($search))
                || str_contains(strtolower($game['family']), strtolower($search));
            $matchesStatus = $selectedStatus === '' || (string) $game['game_status'] === $selectedStatus;

            return $matchesSearch && $matchesStatus;
        })->values();

        return view('game_final.admin.games', array_merge($this->adminViewData('games', $allRows), [
            'gameRows' => $gameRows,
            'rowCount' => $gameRows->count(),
            'search' => $search,
            'selectedStatus' => $selectedStatus,
        ]));
    }

    public function liveMonitor()
    {
        $now = now();
        $games = Game::query()
            ->where('is_active', 1)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $liveRooms = $games->map(function (Game $game) use ($now) {
            $round = GameRound::query()
                ->where('game_id', $game->id)
                ->whereIn('status', ['betting', 'locked', 'revealed', 'settled'])
                ->orderByDesc('id')
                ->first();

            if (!$round) {
                return [
                    'game_id' => $game->id,
                    'game_code' => $game->game_code,
                    'game_name' => $game->name,
                    'family' => $this->gameFamilyLabel($game->game_code),
                    'status' => 'idle',
                    'round_no' => null,
                    'winner_board_key' => null,
                    'winner_icon' => null,
                    'summary' => [
                        'bet_count' => 0,
                        'user_count' => 0,
                        'total_bid_amount' => 0,
                        'total_potential_win' => 0,
                    ],
                    'board_totals' => collect(),
                    'recent_bets' => collect(),
                    'progress_percent' => 0,
                    'next_label' => 'Waiting for round',
                    'next_seconds' => 0,
                    'updated_at_label' => 'No round yet',
                ];
            }

            $summary = DB::table('bd_game_final_bets')
                ->where('game_round_id', $round->id)
                ->selectRaw('COUNT(*) as bet_count')
                ->selectRaw('COUNT(DISTINCT user_id) as user_count')
                ->selectRaw('COALESCE(SUM(amount), 0) as total_bid_amount')
                ->selectRaw('COALESCE(SUM(potential_win), 0) as total_potential_win')
                ->first();

            $boardTotals = DB::table('bd_game_final_bets as bets')
                ->leftJoin('bd_game_final_boards as boards', function ($join) {
                    $join->on('boards.game_id', '=', 'bets.game_id')
                        ->on('boards.canonical_key', '=', 'bets.canonical_board_key');
                })
                ->where('bets.game_round_id', $round->id)
                ->select([
                    'bets.canonical_board_key',
                    'boards.display_name',
                    DB::raw('COUNT(*) as bet_count'),
                    DB::raw('COUNT(DISTINCT bets.user_id) as user_count'),
                    DB::raw('COALESCE(SUM(bets.amount), 0) as total_bid_amount'),
                    DB::raw('COALESCE(SUM(bets.potential_win), 0) as total_potential_win'),
                ])
                ->groupBy('bets.canonical_board_key', 'boards.display_name')
                ->orderByDesc(DB::raw('COALESCE(SUM(bets.amount), 0)'))
                ->get()
                ->map(function ($row) use ($game) {
                    return [
                        'key' => (string) $row->canonical_board_key,
                        'label' => (string) ($row->display_name ?: strtoupper((string) $row->canonical_board_key)),
                        'icon' => $this->boardIcon($game->game_code, (string) $row->canonical_board_key),
                        'bet_count' => (int) $row->bet_count,
                        'user_count' => (int) $row->user_count,
                        'total_bid_amount' => (float) $row->total_bid_amount,
                        'total_potential_win' => (float) $row->total_potential_win,
                    ];
                });

            $recentBets = DB::table('bd_game_final_bets as bets')
                ->leftJoin('users', 'users.id', '=', 'bets.user_id')
                ->where('bets.game_round_id', $round->id)
                ->orderByDesc('bets.id')
                ->limit(12)
                ->get([
                    'bets.id',
                    'bets.user_id',
                    'users.name as user_name',
                    'users.email as user_email',
                    'bets.canonical_board_key',
                    'bets.amount',
                    'bets.created_at',
                ])
                ->map(function ($row) use ($game) {
                    return [
                        'id' => (int) $row->id,
                        'user_id' => (int) $row->user_id,
                        'user_label' => (string) ($row->user_name ?: $row->user_email ?: ('User #' . $row->user_id)),
                        'board_key' => (string) $row->canonical_board_key,
                        'board_icon' => $this->boardIcon($game->game_code, (string) $row->canonical_board_key),
                        'amount' => (float) $row->amount,
                        'created_at_label' => $row->created_at ? \Illuminate\Support\Carbon::parse($row->created_at)->format('H:i:s') : '--:--:--',
                    ];
                });

            $targetAt = $round->bet_close_at;
            $nextLabel = 'Bets close in';

            if ($round->status === 'locked') {
                $targetAt = $round->reveal_at;
                $nextLabel = 'Reveal in';
            } elseif (in_array($round->status, ['revealed', 'settled'], true)) {
                $targetAt = $round->settle_at;
                $nextLabel = 'Settlement in';
            }

            $nextSeconds = $targetAt ? max(0, $targetAt->getTimestamp() - $now->getTimestamp()) : 0;
            $startTimestamp = $round->start_at ? $round->start_at->getTimestamp() : 0;
            $endTimestamp = $round->settle_at ? $round->settle_at->getTimestamp() : 0;
            $progressPercent = 0;
            if ($startTimestamp > 0 && $endTimestamp > $startTimestamp) {
                $progressPercent = max(0, min(100, (($now->getTimestamp() - $startTimestamp) / ($endTimestamp - $startTimestamp)) * 100));
            }

            return [
                'game_id' => $game->id,
                'game_code' => $game->game_code,
                'game_name' => $game->name,
                'family' => $this->gameFamilyLabel($game->game_code),
                'status' => (string) $round->status,
                'round_no' => (string) $round->round_no,
                'winner_board_key' => $round->winner_board_key ?: null,
                'winner_icon' => $round->winner_board_key ? $this->boardIcon($game->game_code, (string) $round->winner_board_key) : null,
                'summary' => [
                    'bet_count' => (int) ($summary->bet_count ?? 0),
                    'user_count' => (int) ($summary->user_count ?? 0),
                    'total_bid_amount' => (float) ($summary->total_bid_amount ?? 0),
                    'total_potential_win' => (float) ($summary->total_potential_win ?? 0),
                ],
                'board_totals' => $boardTotals,
                'recent_bets' => $recentBets,
                'progress_percent' => round($progressPercent, 1),
                'next_label' => $nextLabel,
                'next_seconds' => $nextSeconds,
                'updated_at_label' => $round->updated_at ? $round->updated_at->format('Y-m-d H:i:s') : 'Not updated',
            ];
        })->values();

        return view('game_final.admin.live_monitor', array_merge($this->adminViewData('monitor'), [
            'liveRooms' => $liveRooms,
            'sharedGameBalance' => $this->sharedGameBalance(),
            'liveRoomCount' => $liveRooms->where('status', '!=', 'idle')->count(),
        ]));
    }

    public function rounds(Request $request)
    {
        $selectedGame = trim((string) $request->query('game', ''));
        $selectedStatus = trim((string) $request->query('status', ''));

        $roundRows = DB::table('bd_game_final_rounds as rounds')
            ->join('bd_game_final_games as games', 'games.id', '=', 'rounds.game_id')
            ->select([
                'rounds.id',
                'games.name as game_name',
                'games.game_code',
                'rounds.round_no',
                'rounds.status',
                'rounds.winner_board_key',
                'rounds.decision_mode',
                'rounds.start_at',
                'rounds.bet_close_at',
                'rounds.reveal_at',
                'rounds.settle_at',
                'rounds.updated_at',
            ])
            ->when($selectedGame !== '', function ($query) use ($selectedGame) {
                $query->where('games.game_code', $selectedGame);
            })
            ->when($selectedStatus !== '', function ($query) use ($selectedStatus) {
                $query->where('rounds.status', $selectedStatus);
            })
            ->orderByDesc('rounds.id')
            ->paginate(25)
            ->withQueryString();

        return view('game_final.admin.rounds', array_merge($this->adminViewData('rounds'), [
            'rows' => $roundRows,
            'selectedGame' => $selectedGame,
            'selectedStatus' => $selectedStatus,
            'statusOptions' => GameRound::query()->select('status')->distinct()->orderBy('status')->pluck('status'),
        ]));
    }

    public function bets(Request $request)
    {
        $selectedGame = trim((string) $request->query('game', ''));
        $selectedStatus = trim((string) $request->query('status', ''));

        $betRows = DB::table('bd_game_final_bets as bets')
            ->join('bd_game_final_games as games', 'games.id', '=', 'bets.game_id')
            ->leftJoin('users', 'users.id', '=', 'bets.user_id')
            ->select([
                'bets.id',
                'bets.game_round_id',
                'games.name as game_name',
                'games.game_code',
                'bets.round_no',
                'bets.user_id',
                'users.name as user_name',
                'users.email as user_email',
                'bets.frontend_board_key',
                'bets.canonical_board_key',
                'bets.amount',
                'bets.payout_multiplier',
                'bets.potential_win',
                'bets.win_balance',
                'bets.now_user_balance',
                'bets.status',
                'bets.settled_at',
                'bets.created_at',
            ])
            ->when($selectedGame !== '', function ($query) use ($selectedGame) {
                $query->where('games.game_code', $selectedGame);
            })
            ->when($selectedStatus !== '', function ($query) use ($selectedStatus) {
                $query->where('bets.status', $selectedStatus);
            })
            ->orderByDesc('bets.id')
            ->paginate(25)
            ->withQueryString();

        return view('game_final.admin.bets', array_merge($this->adminViewData('bets'), [
            'rows' => $betRows,
            'selectedGame' => $selectedGame,
            'selectedStatus' => $selectedStatus,
            'statusOptions' => GameBet::query()->select('status')->distinct()->orderBy('status')->pluck('status'),
        ]));
    }

    public function payouts(Request $request)
    {
        $selectedGame = trim((string) $request->query('game', ''));
        $selectedStatus = trim((string) $request->query('status', ''));

        $payoutRows = DB::table('bd_game_final_settlement_items as items')
            ->join('bd_game_final_settlements as settlements', 'settlements.id', '=', 'items.game_settlement_id')
            ->join('bd_game_final_rounds as rounds', 'rounds.id', '=', 'items.game_round_id')
            ->join('bd_game_final_games as games', 'games.id', '=', 'rounds.game_id')
            ->leftJoin('users', 'users.id', '=', 'items.user_id')
            ->select([
                'items.id',
                'games.name as game_name',
                'games.game_code',
                'rounds.round_no',
                'items.user_id',
                'users.name as user_name',
                'users.email as user_email',
                'items.canonical_board_key',
                'items.bet_amount',
                'items.payout_multiplier',
                'items.win_amount',
                'items.net_result',
                'items.result_status',
                'items.wallet_before',
                'items.wallet_after',
                'settlements.settlement_status',
                'settlements.settled_at',
                'items.created_at',
            ])
            ->when($selectedGame !== '', function ($query) use ($selectedGame) {
                $query->where('games.game_code', $selectedGame);
            })
            ->when($selectedStatus !== '', function ($query) use ($selectedStatus) {
                $query->where('items.result_status', $selectedStatus);
            })
            ->orderByDesc('items.id')
            ->paginate(25)
            ->withQueryString();

        return view('game_final.admin.payouts', array_merge($this->adminViewData('payouts'), [
            'rows' => $payoutRows,
            'selectedGame' => $selectedGame,
            'selectedStatus' => $selectedStatus,
            'statusOptions' => GameSettlementItem::query()->select('result_status')->distinct()->orderBy('result_status')->pluck('result_status'),
        ]));
    }

    public function roundDetail(GameRound $round, Request $request)
    {
        $round->loadMissing('game');
        $game = $round->game;

        abort_unless($game, 404, 'Round game not found.');

        $boards = GameBoard::query()
            ->where('game_id', $game->id)
            ->orderBy('display_order')
            ->get()
            ->keyBy('canonical_key');

        $summaryRows = GameBetSummary::query()
            ->where('game_round_id', $round->id)
            ->get()
            ->keyBy('canonical_board_key');

        $liveRows = GameBet::query()
            ->where('game_round_id', $round->id)
            ->select([
                'canonical_board_key',
                DB::raw('COUNT(*) as bet_count'),
                DB::raw('COUNT(DISTINCT user_id) as user_count'),
                DB::raw('SUM(amount) as total_bid_amount'),
                DB::raw('SUM(potential_win) as total_potential_win'),
                DB::raw('SUM(win_balance) as total_win_amount'),
                DB::raw("SUM(CASE WHEN status = 'won' THEN 1 ELSE 0 END) as win_count"),
                DB::raw("SUM(CASE WHEN status = 'lost' THEN 1 ELSE 0 END) as loss_count"),
                DB::raw("SUM(CASE WHEN status IN ('pending', 'hold') THEN 1 ELSE 0 END) as hold_count"),
            ])
            ->groupBy('canonical_board_key')
            ->get()
            ->keyBy('canonical_board_key');

        $boardRows = $liveRows
            ->map(function ($row) use ($boards, $round, $game) {
                $board = $boards->get((string) $row->canonical_board_key);

                return [
                    'key' => (string) $row->canonical_board_key,
                    'label' => $board ? (string) $board->display_name : strtoupper((string) $row->canonical_board_key),
                    'icon' => $this->boardIcon($game->game_code, (string) $row->canonical_board_key),
                    'is_winner' => (string) $round->winner_board_key === (string) $row->canonical_board_key,
                    'bet_count' => (int) $row->bet_count,
                    'user_count' => (int) $row->user_count,
                    'total_bid_amount' => (float) $row->total_bid_amount,
                    'total_potential_win' => (float) $row->total_potential_win,
                    'total_win_amount' => (float) $row->total_win_amount,
                    'win_count' => (int) $row->win_count,
                    'loss_count' => (int) $row->loss_count,
                    'hold_count' => (int) $row->hold_count,
                ];
            })
            ->sortByDesc('total_bid_amount')
            ->values();

        if ($boardRows->isEmpty() && $summaryRows->isNotEmpty()) {
            $boardRows = $summaryRows->map(function ($row) use ($boards, $round, $game) {
                $board = $boards->get((string) $row->canonical_board_key);

                return [
                    'key' => (string) $row->canonical_board_key,
                    'label' => $board ? (string) $board->display_name : strtoupper((string) $row->canonical_board_key),
                    'icon' => $this->boardIcon($game->game_code, (string) $row->canonical_board_key),
                    'is_winner' => (string) $round->winner_board_key === (string) $row->canonical_board_key,
                    'bet_count' => 0,
                    'user_count' => (int) $row->total_players,
                    'total_bid_amount' => (float) $row->total_amount,
                    'total_potential_win' => (float) $row->potential_payout,
                    'total_win_amount' => (string) $round->winner_board_key === (string) $row->canonical_board_key ? (float) $row->potential_payout : 0.0,
                    'win_count' => 0,
                    'loss_count' => 0,
                    'hold_count' => 0,
                ];
            })->sortByDesc('total_bid_amount')->values();
        }

        $userRows = DB::table('bd_game_final_bets as bets')
            ->leftJoin('users', 'users.id', '=', 'bets.user_id')
            ->where('bets.game_round_id', $round->id)
            ->select([
                'bets.user_id',
                'users.name as user_name',
                'users.email as user_email',
                DB::raw('COUNT(*) as bet_count'),
                DB::raw('COUNT(DISTINCT bets.canonical_board_key) as board_count'),
                DB::raw('SUM(bets.amount) as total_bid_amount'),
                DB::raw('SUM(bets.win_balance) as total_win_amount'),
                DB::raw('SUM(bets.win_balance - bets.amount) as net_result'),
                DB::raw('MAX(bets.status) as latest_status'),
            ])
            ->groupBy('bets.user_id', 'users.name', 'users.email')
            ->orderByDesc(DB::raw('SUM(bets.amount)'))
            ->paginate(50)
            ->withQueryString();

        $winnerCards = $this->winnerCardsForRound($round);

        return view('game_final.admin.round_detail', array_merge($this->adminViewData('rounds'), [
            'round' => $round,
            'game' => $game,
            'boardRows' => $boardRows,
            'userRows' => $userRows,
            'winnerCards' => $winnerCards,
            'winnerIcon' => $this->boardIcon($game->game_code, (string) $round->winner_board_key),
        ]));
    }

    public function users(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $selectedGame = trim((string) $request->query('game', ''));
        $walletColumn = (string) config('bd_game_final.wallet_column', 'balance');

        $gameId = $selectedGame !== ''
            ? Game::query()->where('game_code', $selectedGame)->value('id')
            : null;

        $userRows = User::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    if (ctype_digit($search)) {
                        $inner->where('id', (int) $search);
                        return;
                    }

                    if (filter_var($search, FILTER_VALIDATE_EMAIL)) {
                        $inner->where('email', $search);
                        return;
                    }

                    $inner->where('name', 'like', $search . '%')
                        ->orWhere('email', 'like', $search . '%');
                });
            })
            ->withCount([
                'gameSecurityBlocks as active_game_locks_count' => function ($query) use ($gameId) {
                    $query->where('status', 'active')
                        ->where(function ($inner) {
                            $inner->whereNull('lifted_at')
                                ->orWhere('lifted_at', '>', now());
                        })
                        ->when($gameId, function ($inner) use ($gameId) {
                            $inner->where(function ($scope) use ($gameId) {
                                $scope->whereNull('game_id')
                                    ->orWhere('game_id', $gameId);
                            });
                        });
                },
            ])
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        $activeBlocks = GameSecurityBlock::query()
            ->leftJoin('bd_game_final_games as games', 'games.id', '=', 'bd_game_final_security_blocks.game_id')
            ->leftJoin('users', 'users.id', '=', 'bd_game_final_security_blocks.user_id')
            ->where('bd_game_final_security_blocks.status', 'active')
            ->where(function ($query) {
                $query->whereNull('bd_game_final_security_blocks.lifted_at')
                    ->orWhere('bd_game_final_security_blocks.lifted_at', '>', now());
            })
            ->when($selectedGame !== '', function ($query) use ($selectedGame) {
                $query->where('games.game_code', $selectedGame);
            })
            ->select([
                'bd_game_final_security_blocks.*',
                'games.name as game_name',
                'games.game_code',
                'users.name as user_name',
                'users.email as user_email',
            ])
            ->orderByDesc('bd_game_final_security_blocks.id')
            ->limit(12)
            ->get();

        $walletRows = GameWalletJournal::query()
            ->leftJoin('bd_game_final_games as games', 'games.id', '=', 'bd_game_final_wallet_journals.game_id')
            ->leftJoin('users', 'users.id', '=', 'bd_game_final_wallet_journals.user_id')
            ->select([
                'bd_game_final_wallet_journals.*',
                'games.name as game_name',
                'games.game_code',
                'users.name as user_name',
                'users.email as user_email',
            ])
            ->whereIn('bd_game_final_wallet_journals.reason', ['admin_deposit', 'admin_withdraw'])
            ->orderByDesc('bd_game_final_wallet_journals.id')
            ->limit(12)
            ->get();

        return view('game_final.admin.users', array_merge($this->adminViewData('users'), [
            'rows' => $userRows,
            'activeBlocks' => $activeBlocks,
            'walletRows' => $walletRows,
            'search' => $search,
            'selectedGame' => $selectedGame,
            'walletColumn' => $walletColumn,
        ]));
    }

    public function userProfile(User $user, Request $request)
    {
        $selectedGame = trim((string) $request->query('game', ''));
        $gameId = $selectedGame !== ''
            ? Game::query()->where('game_code', $selectedGame)->value('id')
            : null;
        $walletColumn = (string) config('bd_game_final.wallet_column', 'balance');

        $globalStats = GameBet::query()
            ->where('user_id', $user->id)
            ->when($gameId, function ($query) use ($gameId) {
                $query->where('game_id', $gameId);
            })
            ->selectRaw('COUNT(*) as bet_count')
            ->selectRaw('COUNT(DISTINCT game_id) as game_count')
            ->selectRaw('COUNT(DISTINCT game_round_id) as round_count')
            ->selectRaw('COALESCE(SUM(amount), 0) as total_bid_amount')
            ->selectRaw('COALESCE(SUM(win_balance), 0) as total_win_amount')
            ->selectRaw("COALESCE(SUM(CASE WHEN status = 'lost' THEN amount ELSE 0 END), 0) as total_loss_amount")
            ->selectRaw('COALESCE(SUM(win_balance - amount), 0) as net_profit_loss')
            ->first();

        $gameStats = DB::table('bd_game_final_bets as bets')
            ->join('bd_game_final_games as games', 'games.id', '=', 'bets.game_id')
            ->where('bets.user_id', $user->id)
            ->when($gameId, function ($query) use ($gameId) {
                $query->where('bets.game_id', $gameId);
            })
            ->select([
                'games.id as game_id',
                'games.name as game_name',
                'games.game_code',
                DB::raw('COUNT(*) as bet_count'),
                DB::raw('COUNT(DISTINCT bets.game_round_id) as round_count'),
                DB::raw('SUM(bets.amount) as total_bid_amount'),
                DB::raw('SUM(bets.win_balance) as total_win_amount'),
                DB::raw("SUM(CASE WHEN bets.status = 'lost' THEN bets.amount ELSE 0 END) as total_loss_amount"),
                DB::raw('SUM(bets.win_balance - bets.amount) as net_profit_loss'),
                DB::raw('MAX(bets.created_at) as last_played_at'),
            ])
            ->groupBy('games.id', 'games.name', 'games.game_code')
            ->orderByDesc(DB::raw('MAX(bets.created_at)'))
            ->limit(100)
            ->get();

        $betRows = DB::table('bd_game_final_bets as bets')
            ->join('bd_game_final_games as games', 'games.id', '=', 'bets.game_id')
            ->leftJoin('bd_game_final_rounds as rounds', 'rounds.id', '=', 'bets.game_round_id')
            ->where('bets.user_id', $user->id)
            ->when($gameId, function ($query) use ($gameId) {
                $query->where('bets.game_id', $gameId);
            })
            ->select([
                'bets.id',
                'bets.game_round_id',
                'games.name as game_name',
                'games.game_code',
                'rounds.round_no',
                'rounds.winner_board_key',
                'bets.canonical_board_key',
                'bets.frontend_board_key',
                'bets.amount',
                'bets.potential_win',
                'bets.win_balance',
                'bets.now_user_balance',
                'bets.status',
                'bets.created_at',
                'bets.settled_at',
            ])
            ->orderByDesc('bets.id')
            ->paginate(50)
            ->withQueryString();

        $activeBlocks = GameSecurityBlock::query()
            ->leftJoin('bd_game_final_games as games', 'games.id', '=', 'bd_game_final_security_blocks.game_id')
            ->where('bd_game_final_security_blocks.user_id', $user->id)
            ->where('bd_game_final_security_blocks.status', 'active')
            ->where(function ($query) {
                $query->whereNull('bd_game_final_security_blocks.lifted_at')
                    ->orWhere('bd_game_final_security_blocks.lifted_at', '>', now());
            })
            ->select(['bd_game_final_security_blocks.*', 'games.name as game_name', 'games.game_code'])
            ->orderByDesc('bd_game_final_security_blocks.id')
            ->get();

        return view('game_final.admin.user_profile', array_merge($this->adminViewData('users'), [
            'profileUser' => $user,
            'walletColumn' => $walletColumn,
            'selectedGame' => $selectedGame,
            'globalStats' => $globalStats,
            'gameStats' => $gameStats,
            'betRows' => $betRows,
            'activeBlocks' => $activeBlocks,
        ]));
    }

    public function updateGameStatus(Request $request)
    {
        $validated = $request->validate([
            'game_code' => ['required', 'string', 'max:80'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $game = Game::query()->where('game_code', $validated['game_code'])->firstOrFail();
        $isActive = $validated['status'] === 'active';

        DB::transaction(function () use ($game, $isActive, $request) {
            $game->is_active = $isActive;
            $game->save();

            $setting = GameSetting::query()->firstOrNew(['game_id' => $game->id]);
            if (!$setting->exists) {
                $setting->max_distinct_boards_per_user = 1;
            }
            $setting->game_status = $isActive ? 'active' : 'inactive';
            $setting->save();

            GameAuditLog::create([
                'game_id' => $game->id,
                'user_id' => optional($request->user())->id,
                'event_type' => $isActive ? 'admin_game_started' : 'admin_game_stopped',
                'message' => $isActive ? 'Admin turned game on' : 'Admin stopped game',
                'payload_json' => [
                    'game_code' => $game->game_code,
                    'status' => $isActive ? 'active' : 'inactive',
                    'admin_user_id' => optional($request->user())->id,
                ],
            ]);
        });

        return back()->with('status', $game->name . ' is now ' . ($isActive ? 'ON' : 'STOPPED') . '.');
    }

    public function gameBalanceTransfer(Request $request)
    {
        $validated = $request->validate([
            'game_code' => ['required', 'string', 'max:80'],
            'direction' => ['required', 'in:deposit,withdraw'],
            'amount' => ['required', 'numeric', 'min:0.01', 'max:999999999'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        $game = Game::query()->where('game_code', $validated['game_code'])->firstOrFail();
        $amount = round((float) $validated['amount'], 2);

        $result = $validated['direction'] === 'deposit'
            ? $this->gameBank->credit($game->id, $amount)
            : $this->gameBank->debit($game->id, $amount);

        if (empty($result['ok'])) {
            throw ValidationException::withMessages([
                'amount' => 'Shared game balance transfer failed. Check that the shared bank has enough balance.',
            ]);
        }

        GameAuditLog::create([
            'game_id' => $game->id,
            'user_id' => optional($request->user())->id,
            'event_type' => 'admin_game_balance_' . $validated['direction'],
            'message' => 'Admin adjusted shared game bank balance',
            'payload_json' => [
                'game_code' => $game->game_code,
                'direction' => $validated['direction'],
                'amount' => $amount,
                'before' => (float) $result['before'],
                'after' => (float) $result['after'],
                'admin_note' => trim((string) ($validated['note'] ?? '')),
                'admin_user_id' => optional($request->user())->id,
            ],
        ]);

        return back()->with('status', 'Shared game balance updated from ' . $game->name . ' context. New balance: ' . number_format((float) $result['after'], 2) . '.');
    }

    public function walletTransfer(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'game_code' => ['required', 'string', 'max:80'],
            'direction' => ['required', 'in:deposit,withdraw'],
            'amount' => ['required', 'numeric', 'min:0.01', 'max:999999999'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::query()->findOrFail((int) $validated['user_id']);
        $game = Game::query()->where('game_code', $validated['game_code'])->firstOrFail();

        $context = [
            'game_id' => $game->id,
            'reason' => $validated['direction'] === 'deposit' ? 'admin_deposit' : 'admin_withdraw',
            'meta_json' => [
                'admin_user_id' => optional($request->user())->id,
                'admin_note' => trim((string) ($validated['note'] ?? '')),
                'source' => 'admin_panel',
            ],
            'reference_uid' => 'admin-' . optional($request->user())->id . '-' . now()->format('YmdHis') . '-' . Str::random(8),
        ];

        [$result, $gameBalanceAfter] = DB::transaction(function () use ($validated, $user, $game, $context, $request) {
            $result = $validated['direction'] === 'deposit'
                ? $this->wallets->credit($user, (float) $validated['amount'], $context)
                : $this->wallets->debit($user, (float) $validated['amount'], $context);

            if (empty($result['ok'])) {
                throw ValidationException::withMessages([
                    'amount' => 'Wallet transfer failed. Check the user wallet balance and shared game bank balance.',
                ]);
            }

            $bank = $validated['direction'] === 'deposit'
                ? $this->gameBank->debit($game->id, (float) $validated['amount'])
                : $this->gameBank->credit($game->id, (float) $validated['amount']);

            if (empty($bank['ok'])) {
                throw ValidationException::withMessages([
                    'amount' => 'Shared game balance is not enough for this transfer.',
                ]);
            }

            $gameBalanceAfter = (float) $bank['after'];

            GameAuditLog::create([
                'game_id' => $game->id,
                'user_id' => $user->id,
                'event_type' => 'admin_wallet_' . $validated['direction'],
                'message' => 'Admin adjusted shared-bank wallet balance',
                'payload_json' => [
                    'game_code' => $game->game_code,
                    'direction' => $validated['direction'],
                    'amount' => (float) $validated['amount'],
                    'before' => (float) $result['before'],
                    'after' => (float) $result['after'],
                    'game_balance_before' => (float) $bank['before'],
                    'game_balance_after' => $gameBalanceAfter,
                    'admin_user_id' => optional($request->user())->id,
                ],
            ]);

            return [$result, $gameBalanceAfter];
        }, 3);

        $message = 'Wallet ' . $validated['direction'] . ' completed. New user balance: ' . number_format((float) $result['after'], 2) . '.';
        if ($gameBalanceAfter !== null) {
            $message .= ' New shared game balance: ' . number_format((float) $gameBalanceAfter, 2) . '.';
        }

        return back()->with('status', $message);
    }

    public function blockUser(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'game_code' => ['nullable', 'string', 'max:80'],
            'reason' => ['required', 'string', 'max:255'],
        ]);

        $user = User::query()->findOrFail((int) $validated['user_id']);
        $reason = trim((string) $validated['reason']);
        $gameCode = trim((string) ($validated['game_code'] ?? ''));
        if ($gameCode !== '' && !Game::query()->where('game_code', $gameCode)->where('is_active', 1)->exists()) {
            throw ValidationException::withMessages([
                'game_code' => 'Invalid active game code.',
            ]);
        }

        $block = $this->tokens->blockUserForSecurity(
            (int) $user->id,
            $gameCode !== '' ? $gameCode : null,
            $reason,
            'admin_lock',
            $request->ip(),
            $request->userAgent(),
            [
                'admin_user_id' => optional($request->user())->id,
                'source' => 'admin_panel',
            ]
        );

        $revoked = $this->tokens->revokeUserSessionsForSecurityBlock(
            (int) $user->id,
            $reason,
            $gameCode !== '' ? $gameCode : null
        );

        GameAuditLog::create([
            'game_id' => $block->game_id,
            'user_id' => $user->id,
            'event_type' => 'admin_user_locked',
            'message' => 'Admin locked user game access',
            'payload_json' => [
                'reason' => $reason,
                'revoked_sessions' => $revoked,
                'admin_user_id' => optional($request->user())->id,
            ],
        ]);

        return back()->with('status', 'User #' . $user->id . ' locked and ' . $revoked . ' active game session(s) revoked.');
    }

    public function liftBlock(GameSecurityBlock $block, Request $request)
    {
        $block->status = 'lifted';
        $block->lifted_at = now();
        $block->save();

        GameAuditLog::create([
            'game_id' => $block->game_id,
            'user_id' => $block->user_id,
            'event_type' => 'admin_user_unlocked',
            'message' => 'Admin lifted user game lock',
            'payload_json' => [
                'block_id' => $block->id,
                'admin_user_id' => optional($request->user())->id,
            ],
        ]);

        return back()->with('status', 'User lock #' . $block->id . ' lifted.');
    }

    public function update(Request $request)
    {
        $submittedGames = (array) $request->input('games', []);
        $configuredGames = (array) config('bd_game_final.games', []);
        $runtimeControls = $this->runtimeControlRows();
        $normalized = [];
        $messages = [];
        $sortOrder = 0;
        $realtimeMode = (string) $request->input('realtime_mode', 'polling');
        $allowedRealtimeModes = ['polling', 'websocket', 'pusher'];
        $pusher = (array) $request->input('pusher', []);
        $pusherAccountsInput = (array) $request->input('pusher_accounts', []);
        $runtimeSettings = $this->runtime->settings();
        $pusherAccounts = $this->normalizePusherAccounts($pusherAccountsInput, $pusher, $this->runtime->pusherAccounts($runtimeSettings));
        $websocket = (array) $request->input('websocket', []);
        $maintenanceAllowedUsers = [];
        $existingGames = Game::query()->get()->keyBy('game_code');
        $existingBoards = GameBoard::query()
            ->when($existingGames->pluck('id')->filter()->isNotEmpty(), function ($query) use ($existingGames) {
                $query->whereIn('game_id', $existingGames->pluck('id')->filter()->values());
            }, function ($query) {
                $query->whereRaw('1 = 0');
            })
            ->get()
            ->groupBy('game_id');

        if (!in_array($realtimeMode, $allowedRealtimeModes, true)) {
            $messages['realtime_mode'] = 'Choose exactly one realtime mode.';
        }

        if ($realtimeMode === 'pusher') {
            if (empty($pusherAccounts)) {
                $messages['pusher_accounts'] = 'At least one complete Pusher account is required when Pusher mode is selected.';
            }
        }

        if ($realtimeMode === 'websocket' && trim((string) ($websocket['url'] ?? '')) === '') {
            $messages['websocket.url'] = 'WebSocket URL is required when WebSocket mode is selected.';
        }

        foreach ($configuredGames as $gameCode => $cfg) {
            $boardCount = $this->boardCountFor($cfg);
            $rawLimit = data_get($submittedGames, $gameCode . '.max_distinct_boards_per_user');

            if ($rawLimit === null || $rawLimit === '') {
                $messages['games.' . $gameCode . '.max_distinct_boards_per_user'] = 'Board limit is required for ' . ($cfg['name'] ?? $gameCode) . '.';
                $sortOrder++;
                continue;
            }

            if (filter_var($rawLimit, FILTER_VALIDATE_INT) === false) {
                $messages['games.' . $gameCode . '.max_distinct_boards_per_user'] = 'Board limit must be a whole number for ' . ($cfg['name'] ?? $gameCode) . '.';
                $sortOrder++;
                continue;
            }

            $limit = (int) $rawLimit;
            if ($limit < 1 || $limit > $boardCount) {
                $messages['games.' . $gameCode . '.max_distinct_boards_per_user'] = ($cfg['name'] ?? $gameCode) . ' allows between 1 and ' . $boardCount . ' boards.';
            }

            $timing = [
                'bet_duration_sec' => $this->normalizeTimingInput($gameCode, $cfg, $submittedGames, 'bet_duration_sec', 20, $messages),
                'start_bet_popup_sec' => $this->normalizeTimingInput($gameCode, $cfg, $submittedGames, 'start_bet_popup_sec', 3, $messages),
                'start_bet_wait_sec' => $this->normalizeTimingInput($gameCode, $cfg, $submittedGames, 'start_bet_wait_sec', 1.5, $messages),
                'stop_bet_popup_sec' => $this->normalizeTimingInput($gameCode, $cfg, $submittedGames, 'stop_bet_popup_sec', 3, $messages),
                'stop_bet_wait_sec' => $this->normalizeTimingInput($gameCode, $cfg, $submittedGames, 'stop_bet_wait_sec', 1.5, $messages),
                'reveal_duration_sec' => $this->normalizeTimingInput($gameCode, $cfg, $submittedGames, 'reveal_duration_sec', 6, $messages),
                'reveal_wait_sec' => $this->normalizeTimingInput($gameCode, $cfg, $submittedGames, 'reveal_wait_sec', 2, $messages),
                'winner_popup_sec' => $this->normalizeTimingInput($gameCode, $cfg, $submittedGames, 'winner_popup_sec', 1, $messages),
                'winner_wait_sec' => $this->normalizeTimingInput($gameCode, $cfg, $submittedGames, 'winner_wait_sec', 0.5, $messages),
                'settle_duration_sec' => $this->normalizeTimingInput($gameCode, $cfg, $submittedGames, 'settle_duration_sec', 2.5, $messages),
                'settle_wait_sec' => $this->normalizeTimingInput($gameCode, $cfg, $submittedGames, 'settle_wait_sec', 1, $messages),
            ];
            $timing['stop_duration_sec'] = round($timing['stop_bet_popup_sec'] + $timing['stop_bet_wait_sec'], 2);

            $lobbyVisibility = (string) data_get($submittedGames, $gameCode . '.lobby_visibility', 'active');
            if (!in_array($lobbyVisibility, ['active', 'inactive'], true)) {
                $messages['games.' . $gameCode . '.lobby_visibility'] = 'Choose Active or Inactive for ' . ($cfg['name'] ?? $gameCode) . '.';
            }

            $status = (string) data_get($submittedGames, $gameCode . '.game_status', 'live');
            if (!in_array($status, ['live', 'developer', 'maintenance'], true)) {
                $messages['games.' . $gameCode . '.game_status'] = 'Choose a valid mode for ' . ($cfg['name'] ?? $gameCode) . '.';
            }

            $rawAllowedUsers = trim((string) data_get($submittedGames, $gameCode . '.maintenance_allowed_user_ids', ''));
            if ($rawAllowedUsers === '') {
                $legacyAllowedUser = trim((string) data_get($submittedGames, $gameCode . '.maintenance_allowed_user_id', ''));
                if ($legacyAllowedUser !== '') {
                    $rawAllowedUsers = $legacyAllowedUser;
                }
            }
            $allowedUserIds = $this->normalizeMaintenanceAllowedUserIds($rawAllowedUsers);
            if ($rawAllowedUsers !== '' && $allowedUserIds === null) {
                $messages['games.' . $gameCode . '.maintenance_allowed_user_ids'] = 'Allowed user IDs must be positive integers, comma/space/newline separated.';
            }

            if ($status === 'developer' && $lobbyVisibility === 'active' && empty($allowedUserIds)) {
                $messages['games.' . $gameCode . '.maintenance_allowed_user_ids'] = 'At least one developer ID is required when ' . ($cfg['name'] ?? $gameCode) . ' is in developer mode.';
            }

            if (!empty($allowedUserIds)) {
                $maintenanceAllowedUsers[$gameCode] = $allowedUserIds;
            }

            $boardPayouts = $this->normalizeSubmittedBoardPayouts(
                $gameCode,
                $cfg,
                (array) data_get($submittedGames, $gameCode . '.boards', []),
                $status,
                $existingGames->get($gameCode),
                $existingBoards,
                $messages
            );

            $normalized[$gameCode] = [
                'enabled' => $lobbyVisibility === 'active',
                'lobby_visibility' => $lobbyVisibility,
                'game_status' => $status,
                'maintenance_enabled' => in_array($status, ['developer', 'maintenance'], true),
                'maintenance_allowed_user_id' => !empty($allowedUserIds) ? (int) $allowedUserIds[0] : null,
                'maintenance_allowed_user_ids' => $allowedUserIds,
                'maintenance_message' => $status === 'developer'
                    ? 'This game is in developer mode. Only approved developer IDs can enter.'
                    : 'This game is in maintenance. Please wait.',
                'ui_meta_json' => $this->normalizeSubmittedUiTheme((array) data_get($submittedGames, $gameCode . '.ui_theme', [])),
                'max_distinct_boards_per_user' => $limit,
                'timing' => $timing,
                'boards' => $boardPayouts,
                'sort_order' => $sortOrder,
                'name' => (string) ($cfg['name'] ?? Str::title(str_replace('_', ' ', $gameCode))),
            ];

            $sortOrder++;
        }

        if (!empty($messages)) {
            throw ValidationException::withMessages($messages);
        }

        DB::transaction(function () use ($configuredGames, $normalized, $request) {
            foreach ($configuredGames as $gameCode => $cfg) {
                $payload = $normalized[$gameCode];

                $game = Game::query()->updateOrCreate(
                    ['game_code' => $gameCode],
                    [
                        'name' => $payload['name'],
                        'is_active' => $payload['enabled'],
                        'frontend_slug' => $gameCode,
                        'sort_order' => $payload['sort_order'],
                    ]
                );

                $settingPayload = [
                    'bet_duration_sec' => (int) ($payload['timing']['bet_duration_sec'] ?? 20),
                    'stop_duration_sec' => (float) ($payload['timing']['stop_duration_sec'] ?? 4.5),
                    'reveal_duration_sec' => (float) ($payload['timing']['reveal_duration_sec'] ?? 6),
                    'settle_duration_sec' => (float) ($payload['timing']['settle_duration_sec'] ?? 2.5),
                    'max_distinct_boards_per_user' => $payload['max_distinct_boards_per_user'],
                    'game_status' => $payload['game_status'],
                    'maintenance_enabled' => $payload['maintenance_enabled'],
                    'maintenance_allowed_user_id' => $payload['maintenance_allowed_user_id'],
                    'maintenance_message' => $payload['maintenance_message'],
                    'ui_meta_json' => $payload['ui_meta_json'],
                ];

                foreach ([
                    'start_bet_popup_sec',
                    'start_bet_wait_sec',
                    'stop_bet_popup_sec',
                    'stop_bet_wait_sec',
                    'reveal_wait_sec',
                    'winner_popup_sec',
                    'winner_wait_sec',
                    'settle_wait_sec',
                ] as $timingColumn) {
                    if (Schema::hasColumn('bd_game_final_settings', $timingColumn)) {
                        $settingPayload[$timingColumn] = (float) ($payload['timing'][$timingColumn] ?? 0);
                    }
                }

                GameSetting::query()->updateOrCreate(['game_id' => $game->id], $settingPayload);

                foreach ((array) ($payload['boards'] ?? []) as $boardPayload) {
                    $board = GameBoard::query()->updateOrCreate(
                        [
                            'game_id' => $game->id,
                            'canonical_key' => $boardPayload['canonical_key'],
                        ],
                        [
                            'frontend_key' => $boardPayload['frontend_key'],
                            'display_name' => $boardPayload['display_name'],
                            'display_order' => $boardPayload['display_order'],
                            'is_active' => true,
                            'payout_multiplier' => $boardPayload['payout_multiplier'],
                        ]
                    );

                    if (!empty($boardPayload['changed'])) {
                        GameAuditLog::create([
                            'game_id' => $game->id,
                            'user_id' => optional($request->user())->id,
                            'event_type' => 'admin_board_payout_update',
                            'message' => 'Admin updated board payout multiplier',
                            'payload_json' => [
                                'game_code' => $gameCode,
                                'board_id' => $board->id,
                                'canonical_key' => $boardPayload['canonical_key'],
                                'previous_multiplier' => $boardPayload['previous_multiplier'],
                                'payout_multiplier' => $boardPayload['payout_multiplier'],
                                'admin_user_id' => optional($request->user())->id,
                            ],
                        ]);
                    }
                }

                GameAuditLog::create([
                    'game_id' => $game->id,
                    'user_id' => optional($request->user())->id,
                    'event_type' => 'admin_game_update',
                    'message' => 'Admin updated game visibility/settings',
                    'payload_json' => [
                        'game_code' => $gameCode,
                        'enabled' => (bool) $payload['enabled'],
                        'lobby_visibility' => (string) ($payload['lobby_visibility'] ?? 'active'),
                        'game_status' => $payload['game_status'],
                        'maintenance_enabled' => (bool) $payload['maintenance_enabled'],
                        'maintenance_allowed_user_ids' => (array) $payload['maintenance_allowed_user_ids'],
                        'maintenance_allowed_user_id' => $payload['maintenance_allowed_user_id'],
                        'ui_theme' => $payload['ui_meta_json'],
                        'timing' => $payload['timing'],
                        'max_distinct_boards_per_user' => (int) $payload['max_distinct_boards_per_user'],
                        'admin_user_id' => optional($request->user())->id,
                    ],
                ]);
            }
        });

        $this->persistRuntimeEnvironment($request, $runtimeControls, $realtimeMode, $maintenanceAllowedUsers);

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'Game controls and realtime settings updated. The lobby and live rooms will use these values dynamically.');
    }

    protected function gameRows()
    {
        $configuredGames = collect((array) config('bd_game_final.games', []));
        $existingGames = Game::query()->get()->keyBy('game_code');
        $gameIds = $existingGames->pluck('id')->filter()->values();
        $settings = GameSetting::query()
            ->when($gameIds->isNotEmpty(), function ($query) use ($gameIds) {
                $query->whereIn('game_id', $gameIds);
            }, function ($query) {
                $query->whereRaw('1 = 0');
            })
            ->get()
            ->keyBy('game_id');
        $sharedBalance = $this->sharedGameBalance();

        $rows = collect();
        $sortOrder = 0;

        foreach ($configuredGames as $gameCode => $cfg) {
            $game = $existingGames->get($gameCode);
            $setting = $game ? $settings->get($game->id) : null;
            $runtimeAllowedUserIds = $this->runtime->maintenanceAllowedUserIds($gameCode);
            if (empty($runtimeAllowedUserIds) && $setting && !empty($setting->maintenance_allowed_user_id)) {
                $runtimeAllowedUserIds = [(int) $setting->maintenance_allowed_user_id];
            }
            $isEnabled = $game ? (bool) $game->is_active : true;
            $boardCount = $this->boardCountFor($cfg);
            $maxBoards = $setting
                ? (int) $setting->max_distinct_boards_per_user
                : (int) ($cfg['max_distinct_boards_per_user'] ?? $boardCount);

            $maxBoards = max(1, min($maxBoards, $boardCount));
            $maintenanceEnabled = $setting && (bool) ($setting->maintenance_enabled ?? false);
            $gameStatus = $this->normalizeStoredGameStatus(
                $setting ? (string) ($setting->game_status ?? '') : '',
                $maintenanceEnabled,
                $runtimeAllowedUserIds,
                $isEnabled
            );

            $rows->push([
                'game_code' => $gameCode,
                'name' => (string) ($cfg['name'] ?? ($game->name ?? Str::title(str_replace('_', ' ', $gameCode)))),
                'family' => $this->gameFamilyLabel($gameCode),
                'enabled' => $isEnabled,
                'lobby_visibility' => $isEnabled ? 'active' : 'inactive',
                'game_status' => $gameStatus,
                'game_balance' => $sharedBalance,
                'maintenance_allowed_user_id' => $setting && $setting->maintenance_allowed_user_id ? (string) $setting->maintenance_allowed_user_id : '',
                'maintenance_allowed_user_ids' => implode(',', $runtimeAllowedUserIds),
                'ui_theme' => $this->normalizeSubmittedUiTheme(is_array(optional($setting)->ui_meta_json) ? $setting->ui_meta_json : []),
                'timing' => $this->timingRowForGame($setting, $cfg, $boardCount),
                'board_count' => $boardCount,
                'max_distinct_boards_per_user' => $maxBoards,
                'boards' => $this->boardRowsForGame($game, $cfg),
                'preview' => collect((array) ($cfg['boards'] ?? []))
                    ->take(3)
                    ->map(function ($board) {
                        return (string) ($board['display_name'] ?? $board['canonical_key'] ?? $board['frontend_key'] ?? 'Board');
                    })
                    ->values()
                    ->all(),
                'sort_order' => $game ? (int) $game->sort_order : $sortOrder,
            ]);

            $sortOrder++;
        }

        return $rows
            ->sortBy([
                ['sort_order', 'asc'],
                ['name', 'asc'],
            ])
            ->values();
    }

    protected function boardRowsForGame($game, array $cfg): array
    {
        $dbBoards = $game
            ? GameBoard::query()->where('game_id', $game->id)->get()->keyBy('canonical_key')
            : collect();

        return collect((array) ($cfg['boards'] ?? []))
            ->values()
            ->map(function (array $boardCfg, int $index) use ($dbBoards) {
                $canonical = (string) ($boardCfg['canonical_key'] ?? $boardCfg['frontend_key'] ?? ('board_' . ($index + 1)));
                $dbBoard = $dbBoards->get($canonical);
                $multiplier = $dbBoard
                    ? (float) $dbBoard->payout_multiplier
                    : (float) ($boardCfg['multiplier'] ?? 1);

                return [
                    'frontend_key' => (string) ($boardCfg['frontend_key'] ?? $canonical),
                    'canonical_key' => $canonical,
                    'display_name' => (string) ($dbBoard->display_name ?? $boardCfg['display_name'] ?? $canonical),
                    'payout_multiplier' => max(0.01, $multiplier),
                    'payout_input' => $this->formatPayoutInput(max(0.01, $multiplier)),
                    'display_order' => (int) ($dbBoard->display_order ?? $index),
                ];
            })
            ->all();
    }

    protected function normalizeSubmittedBoardPayouts(string $gameCode, array $cfg, array $submittedBoards, string $status, $game, $existingBoards, array &$messages): array
    {
        $dbBoards = $game ? $existingBoards->get($game->id, collect())->keyBy('canonical_key') : collect();
        $rows = [];

        foreach (array_values((array) ($cfg['boards'] ?? [])) as $index => $boardCfg) {
            $canonical = (string) ($boardCfg['canonical_key'] ?? $boardCfg['frontend_key'] ?? ('board_' . ($index + 1)));
            $frontend = (string) ($boardCfg['frontend_key'] ?? $canonical);
            $displayName = (string) ($boardCfg['display_name'] ?? $canonical);
            $dbBoard = $dbBoards->get($canonical);
            $current = $dbBoard ? (float) $dbBoard->payout_multiplier : (float) ($boardCfg['multiplier'] ?? 1);
            $field = 'games.' . $gameCode . '.boards.' . $canonical . '.payout_multiplier';
            $raw = data_get($submittedBoards, $canonical . '.payout_multiplier', $current);

            if ($raw === null || $raw === '') {
                $messages[$field] = 'Payout is required for ' . $displayName . '.';
                continue;
            }

            if (!is_numeric($raw)) {
                $messages[$field] = 'Payout must be a number for ' . $displayName . '.';
                continue;
            }

            $multiplier = (float) $raw;
            if (!is_finite($multiplier) || $multiplier <= 0) {
                $messages[$field] = 'Payout must be greater than 0 for ' . $displayName . '.';
                continue;
            }

            $changed = abs($multiplier - $current) > 0.0001;
            if ($changed && $status !== 'maintenance') {
                $messages[$field] = 'Payout changes require Maintenance mode for ' . ($cfg['name'] ?? $gameCode) . '.';
            }

            $rows[] = [
                'frontend_key' => $frontend,
                'canonical_key' => $canonical,
                'display_name' => $displayName,
                'display_order' => $index,
                'previous_multiplier' => $current,
                'payout_multiplier' => round($multiplier, 2),
                'changed' => $changed,
            ];
        }

        return $rows;
    }

    protected function normalizeTimingInput(string $gameCode, array $cfg, array $submittedGames, string $field, float $fallback, array &$messages): float
    {
        $raw = data_get($submittedGames, $gameCode . '.timing.' . $field, $cfg[$field] ?? $fallback);
        $label = (string) ($cfg['name'] ?? $gameCode);

        if ($raw === null || $raw === '') {
            $messages['games.' . $gameCode . '.timing.' . $field] = 'Timing is required for ' . $label . '.';
            return $fallback;
        }

        if (!is_numeric($raw)) {
            $messages['games.' . $gameCode . '.timing.' . $field] = 'Timing must be numeric for ' . $label . '.';
            return $fallback;
        }

        $value = round((float) $raw, 2);
        if ($value < 0 || $value > 300) {
            $messages['games.' . $gameCode . '.timing.' . $field] = 'Timing must be between 0 and 300 seconds for ' . $label . '.';
        }

        if ($field === 'bet_duration_sec' && $value < 1) {
            $messages['games.' . $gameCode . '.timing.' . $field] = 'Bet time must be at least 1 second for ' . $label . '.';
        }

        return $value;
    }

    protected function timingRowForGame($setting, array $cfg, int $boardCount): array
    {
        $bet = (float) ($setting->bet_duration_sec ?? $cfg['bet_duration_sec'] ?? 20);
        $startPopup = (float) ($setting->start_bet_popup_sec ?? $cfg['start_bet_popup_sec'] ?? 3);
        $startWait = (float) ($setting->start_bet_wait_sec ?? $cfg['start_bet_wait_sec'] ?? 1.5);
        $stopPopup = (float) ($setting->stop_bet_popup_sec ?? $cfg['stop_bet_popup_sec'] ?? 3);
        $stopWait = (float) ($setting->stop_bet_wait_sec ?? $cfg['stop_bet_wait_sec'] ?? 1.5);
        $reveal = (float) ($setting->reveal_duration_sec ?? $cfg['reveal_duration_sec'] ?? 6);
        $revealWait = (float) ($setting->reveal_wait_sec ?? $cfg['reveal_wait_sec'] ?? 2);
        $winnerPopup = (float) ($setting->winner_popup_sec ?? $cfg['winner_popup_sec'] ?? 1);
        $winnerWait = (float) ($setting->winner_wait_sec ?? $cfg['winner_wait_sec'] ?? 0.5);
        $settle = (float) ($setting->settle_duration_sec ?? $cfg['settle_duration_sec'] ?? 2.5);
        $settleWait = (float) ($setting->settle_wait_sec ?? $cfg['settle_wait_sec'] ?? 1);

        return [
            'bet_duration_sec' => $this->formatDurationInput($bet),
            'start_bet_popup_sec' => $this->formatDurationInput($startPopup),
            'start_bet_wait_sec' => $this->formatDurationInput($startWait),
            'stop_bet_popup_sec' => $this->formatDurationInput($stopPopup),
            'stop_bet_wait_sec' => $this->formatDurationInput($stopWait),
            'stop_duration_sec' => $this->formatDurationInput($stopPopup + $stopWait),
            'reveal_duration_sec' => $this->formatDurationInput($reveal),
            'reveal_wait_sec' => $this->formatDurationInput($revealWait),
            'winner_popup_sec' => $this->formatDurationInput($winnerPopup),
            'winner_wait_sec' => $this->formatDurationInput($winnerWait),
            'settle_duration_sec' => $this->formatDurationInput($settle),
            'settle_wait_sec' => $this->formatDurationInput($settleWait),
        ];
    }

    protected function formatDurationInput(float $value): string
    {
        return rtrim(rtrim(number_format($value, 2, '.', ''), '0'), '.');
    }

    protected function formatPayoutInput(float $value): string
    {
        return rtrim(rtrim(number_format($value, 2, '.', ''), '0'), '.');
    }

    protected function normalizeSubmittedUiTheme(array $theme): array
    {
        $clockThemes = array_keys($this->clockThemeOptions());
        $chipThemes = array_keys($this->chipThemeOptions());
        $chairThemes = array_keys($this->chairThemeOptions());
        $itemThemes = array_keys($this->itemThemeOptions());
        $popupThemes = array_keys($this->popupThemeOptions());

        return [
            'lobby_banner_url' => $this->normalizeBannerUrl((string) ($theme['lobby_banner_url'] ?? '')),
            'primary_color' => $this->normalizeHexColor((string) ($theme['primary_color'] ?? ''), '#0b0715'),
            'accent_color' => $this->normalizeHexColor((string) ($theme['accent_color'] ?? ''), '#ffd76e'),
            'clock_theme' => $this->normalizeChoice((string) ($theme['clock_theme'] ?? 'casino'), $clockThemes, 'casino'),
            'chip_theme' => $this->normalizeChoice((string) ($theme['chip_theme'] ?? 'classic'), $chipThemes, 'classic'),
            'chair_theme' => $this->normalizeChoice((string) ($theme['chair_theme'] ?? 'classic'), $chairThemes, 'classic'),
            'item_theme' => $this->normalizeChoice((string) ($theme['item_theme'] ?? 'default'), $itemThemes, 'default'),
            'popup_theme' => $this->normalizeChoice((string) ($theme['popup_theme'] ?? 'popup_01'), $popupThemes, 'popup_01'),
        ];
    }

    protected function normalizeHexColor(string $value, string $fallback): string
    {
        $value = trim($value);
        return preg_match('/^#[0-9a-fA-F]{6}$/', $value) ? strtolower($value) : $fallback;
    }

    protected function normalizeBannerUrl(string $value): string
    {
        $value = trim($value);
        if ($value === '') {
            return '';
        }

        if (filter_var($value, FILTER_VALIDATE_URL) || str_starts_with($value, '/')) {
            return $value;
        }

        return '';
    }

    protected function normalizeChoice(string $value, array $allowed, string $fallback): string
    {
        return in_array($value, $allowed, true) ? $value : $fallback;
    }

    protected function gameDetailRows()
    {
        $baseRows = $this->gameRows();
        $existingGames = Game::query()->get()->keyBy('game_code');
        $settings = GameSetting::query()->get()->keyBy('game_id');

        return $baseRows->map(function (array $row) use ($existingGames, $settings) {
            $game = $existingGames->get($row['game_code']);
            $setting = $game ? $settings->get($game->id) : null;
            $updatedAt = null;

            if ($setting && $setting->updated_at) {
                $updatedAt = $setting->updated_at;
            } elseif ($game && $game->updated_at) {
                $updatedAt = $game->updated_at;
            }

            $boardCount = max(1, (int) ($row['board_count'] ?? 1));
            $defaultBetDuration = $boardCount >= 8 ? 30 : 20;

            return array_merge($row, [
                'bet_duration_sec' => (float) ($setting->bet_duration_sec ?? $defaultBetDuration),
                'start_bet_popup_sec' => (float) ($setting->start_bet_popup_sec ?? 3),
                'start_bet_wait_sec' => (float) ($setting->start_bet_wait_sec ?? 1.5),
                'stop_bet_popup_sec' => (float) ($setting->stop_bet_popup_sec ?? 3),
                'stop_bet_wait_sec' => (float) ($setting->stop_bet_wait_sec ?? 1.5),
                'reveal_duration_sec' => (float) ($setting->reveal_duration_sec ?? 6),
                'reveal_wait_sec' => (float) ($setting->reveal_wait_sec ?? 2),
                'winner_popup_sec' => (float) ($setting->winner_popup_sec ?? 1),
                'winner_wait_sec' => (float) ($setting->winner_wait_sec ?? 0.5),
                'settle_duration_sec' => (float) ($setting->settle_duration_sec ?? 2.5),
                'settle_wait_sec' => (float) ($setting->settle_wait_sec ?? 1),
                'min_bet' => (float) ($setting->min_bet ?? 1),
                'max_bet' => (float) ($setting->max_bet ?? 9999999),
                'risk_mode' => (string) ($setting->risk_mode ?? 'safe_low_liability'),
                'game_status' => $this->normalizeStoredGameStatus(
                    $setting ? (string) ($setting->game_status ?? '') : '',
                    $setting ? (bool) ($setting->maintenance_enabled ?? false) : false,
                    $this->runtime->maintenanceAllowedUserIds($row['game_code']),
                    (bool) ($row['enabled'] ?? true)
                ),
                'weighted_random_enabled' => (bool) ($setting->weighted_random_enabled ?? false),
                'updated_at_label' => $updatedAt ? $updatedAt->format('d M Y H:i') : 'Not synced yet',
            ]);
        })->values();
    }

    protected function normalizeStoredGameStatus(string $rawStatus, bool $maintenanceEnabled, array $allowedUserIds, bool $enabled): string
    {
        $rawStatus = trim($rawStatus);

        return match ($rawStatus) {
            'active' => 'live',
            'inactive' => 'maintenance',
            'live', 'developer', 'maintenance' => $rawStatus,
            default => $maintenanceEnabled
                ? (!empty($allowedUserIds) ? 'developer' : 'maintenance')
                : ($enabled ? 'live' : 'maintenance'),
        };
    }

    protected function adminViewData(string $activeMenu, $gameRows = null): array
    {
        $gameRows = $gameRows ?: $this->gameRows();
        $counts = $this->adminCounts($gameRows);

        return [
            'activeMenu' => $activeMenu,
            'adminMenu' => $this->adminMenu($counts),
            'adminCounts' => $counts,
            'pageStats' => $this->pageStats($counts),
            'adminAlerts' => $this->adminAlerts(),
            'visualOptions' => $this->visualOptions(),
            'sharedGameBalance' => $this->sharedGameBalance(),
            'gameOptions' => $gameRows->map(function (array $game) {
                return [
                    'game_code' => $game['game_code'],
                    'name' => $game['name'],
                    'game_balance' => (float) ($game['game_balance'] ?? 0),
                ];
            })->values(),
        ];
    }

    protected function adminCounts($gameRows): array
    {
        $configuredGames = $gameRows->count();
        $visibleGames = $gameRows->where('enabled', true)->count();

        $tableCounts = Cache::remember('game_final_admin_table_counts', 60, function () {
            return [
                'rounds' => $this->estimatedTableRows('bd_game_final_rounds'),
                'bets' => $this->estimatedTableRows('bd_game_final_bets'),
                'payouts' => $this->estimatedTableRows('bd_game_final_settlement_items'),
            ];
        });

        return [
            'configured_games' => $configuredGames,
            'visible_games' => $visibleGames,
            'hidden_games' => max($configuredGames - $visibleGames, 0),
            'rounds' => (int) ($tableCounts['rounds'] ?? 0),
            'bets' => (int) ($tableCounts['bets'] ?? 0),
            'payouts' => (int) ($tableCounts['payouts'] ?? 0),
            'game_balance_total' => $this->sharedGameBalance(),
            'locks' => GameSecurityBlock::query()
                ->where('status', 'active')
                ->where(function ($query) {
                    $query->whereNull('lifted_at')
                        ->orWhere('lifted_at', '>', now());
                })
                ->count(),
        ];
    }

    protected function visualOptions(): array
    {
        return [
            'clock' => $this->clockThemeOptions(),
            'chip' => $this->chipThemeOptions(),
            'chair' => $this->chairThemeOptions(),
            'item' => $this->itemThemeOptions(),
            'popup' => $this->popupThemeOptions(),
        ];
    }

    protected function clockThemeOptions(): array
    {
        return [
            'casino' => 'Casino Ring',
            'royal' => 'Royal Crown',
            'neon' => 'Neon Pulse',
            'minimal' => 'Minimal Gold',
            'samurai' => 'Samurai Cut',
            'steampunk' => 'Steam Gear',
            'fire' => 'Fire Core',
            'liquid' => 'Liquid Blue',
            'flip' => 'Flip Board',
            'cyber' => 'Cyber Grid',
            'frost' => 'Frost Crystal',
        ];
    }

    protected function chipThemeOptions(): array
    {
        return [
            'classic' => 'Classic',
            'king' => 'King Gold',
            'sultan' => 'Sultan',
            'warfront' => 'Warfront',
            'neon' => 'Neon',
            'shogun' => 'Shogun',
            'glacier' => 'Glacier',
            'pro' => 'Pro',
            'master' => 'Master',
            'arcade' => 'Arcade',
            'lotus' => 'Lotus',
        ];
    }

    protected function chairThemeOptions(): array
    {
        return [
            'classic' => 'Classic Chairs',
            'royal' => 'Royal Chairs',
            'warfront' => 'Warfront Seats',
            'neon' => 'Neon Seats',
            'sultan' => 'Sultan Seats',
            'shogun' => 'Shogun Seats',
            'glacier' => 'Glacier Seats',
            'minimal' => 'Minimal Seats',
        ];
    }

    protected function itemThemeOptions(): array
    {
        return [
            'default' => 'Default Items',
            'cards' => 'Card Items',
            'fruit' => 'Fruit Items',
            'wheel' => 'Wheel Items',
            'royal' => 'Royal Items',
            'battle' => 'Battle Items',
            'neon' => 'Neon Items',
            'ice' => 'Ice Items',
            'festival' => 'Festival Items',
            'minimal' => 'Minimal Items',
            'gold' => 'Gold Items',
        ];
    }

    protected function popupThemeOptions(): array
    {
        $options = [];
        for ($i = 1; $i <= 30; $i++) {
            $key = 'popup_' . str_pad((string) $i, 2, '0', STR_PAD_LEFT);
            $options[$key] = 'Popup ' . $i;
        }

        return $options;
    }

    protected function adminMenu(array $counts): array
    {
        return [
            [
                'key' => 'dashboard',
                'label' => 'Lobby Control',
                'route' => route('admin.dashboard'),
                'meta' => $counts['visible_games'] . ' live',
            ],
            [
                'key' => 'game-time',
                'label' => 'Game Time',
                'route' => route('admin.game-final.game-time'),
                'meta' => '20s bets',
            ],
            [
                'key' => 'games',
                'label' => 'Game Details',
                'route' => route('admin.game-final.games'),
                'meta' => $counts['configured_games'] . ' games',
            ],
            [
                'key' => 'monitor',
                'label' => 'Live Monitor',
                'route' => route('admin.game-final.live-monitor'),
                'meta' => $counts['visible_games'] . ' tracked',
            ],
            [
                'key' => 'rounds',
                'label' => 'Rounds',
                'route' => route('admin.game-final.rounds'),
                'meta' => $counts['rounds'] . ' rows',
            ],
            [
                'key' => 'bets',
                'label' => 'User Bets',
                'route' => route('admin.game-final.bets'),
                'meta' => $counts['bets'] . ' rows',
            ],
            [
                'key' => 'users',
                'label' => 'Wallet & Locks',
                'route' => route('admin.game-final.users'),
                'meta' => $counts['locks'] . ' locks',
            ],
            [
                'key' => 'payouts',
                'label' => 'Payouts',
                'route' => route('admin.game-final.payouts'),
                'meta' => $counts['payouts'] . ' rows',
            ],
        ];
    }

    protected function pageStats(array $counts): array
    {
        return [
            [
                'label' => 'Visible Games',
                'value' => $counts['visible_games'],
                'description' => 'Rooms currently shown in the user lobby.',
            ],
            [
                'label' => 'Rounds',
                'value' => $counts['rounds'],
                'description' => 'All recorded rounds across every game.',
            ],
            [
                'label' => 'User Bets',
                'value' => $counts['bets'],
                'description' => 'Bet rows stored for players and rooms.',
            ],
            [
                'label' => 'Payout Rows',
                'value' => $counts['payouts'],
                'description' => 'Per-user payout rows created from settlements.',
            ],
            [
                'label' => 'Shared Game Bank',
                'value' => number_format((float) ($counts['game_balance_total'] ?? 0), 2),
                'description' => 'One shared bank used by all games for risk checks, payouts, and admin transfers.',
            ],
            [
                'label' => 'Active Locks',
                'value' => $counts['locks'],
                'description' => 'Users currently blocked from game entry.',
            ],
        ];
    }

    protected function runtimeControlRows(): array
    {
        $settings = $this->runtime->settings();
        $status = $this->runtime->runtimeStatus();
        $pusherAccounts = $this->runtime->pusherAccounts($settings);
        if (empty($pusherAccounts)) {
            $pusherAccounts[] = [
                'app_id' => '',
                'key' => '',
                'secret' => '',
                'cluster' => 'mt1',
                'host' => '',
                'port' => '443',
                'scheme' => 'https',
            ];
        }
        $pusherAccounts = collect($pusherAccounts)->take(8)->values()->map(function (array $account) {
            $secretConfigured = trim((string) ($account['secret'] ?? '')) !== '';
            $account['secret'] = '';
            $account['secret_configured'] = $secretConfigured;
            return $account;
        })->all();

        return [
            'realtime_mode' => old('realtime_mode', (string) ($settings['realtime_mode'] ?? 'polling')),
            'poll_interval_ms' => old('poll_interval_ms', (string) ($settings['poll_interval_ms'] ?? 1500)),
            'config_version' => $this->runtime->configVersion($settings),
            'config_updated_at' => $this->runtime->configUpdatedAt($settings),
            'websocket' => [
                'url' => old('websocket.url', (string) ($settings['websocket_url'] ?? '')),
                'protocols' => old('websocket.protocols', (string) ($settings['websocket_protocols'] ?? '')),
            ],
            'pusher' => [
                'app_id' => old('pusher.app_id', (string) ($settings['pusher_app_id'] ?? '')),
                'key' => old('pusher.key', (string) ($settings['pusher_key'] ?? '')),
                'secret' => '',
                'secret_configured' => trim((string) ($settings['pusher_secret'] ?? '')) !== '',
                'cluster' => old('pusher.cluster', (string) ($settings['pusher_cluster'] ?? 'mt1')),
                'host' => old('pusher.host', (string) ($settings['pusher_host'] ?? '')),
                'port' => old('pusher.port', (string) ($settings['pusher_port'] ?? '443')),
                'scheme' => old('pusher.scheme', (string) ($settings['pusher_scheme'] ?? 'https')),
            ],
            'pusher_accounts' => $pusherAccounts,
            'pusher_active_index' => (int) old('pusher_active_index', (int) ($settings['pusher_active_index'] ?? 0)),
            'pusher_failed_indexes' => is_array($settings['pusher_failed_indexes'] ?? null) ? $settings['pusher_failed_indexes'] : [],
            'redis_available' => (bool) ($status['redis_available'] ?? false),
            'redis_enabled' => old('redis_enabled', (bool) ($settings['redis_enabled'] ?? false)),
            'jobs_available' => (bool) ($status['jobs_available'] ?? false),
            'jobs_enabled' => old('jobs_enabled', (bool) ($settings['jobs_enabled'] ?? false)),
            'cron_available' => (bool) ($status['cron_available'] ?? false),
            'cron_enabled' => old('cron_enabled', (bool) ($settings['cron_enabled'] ?? false)),
        ];
    }

    protected function persistRuntimeEnvironment(Request $request, array $runtimeControls, string $realtimeMode, array $maintenanceAllowedUsers): void
    {
        $pusher = (array) $request->input('pusher', []);
        $currentSettings = $this->runtime->settings();
        $existingAccounts = $this->runtime->pusherAccounts($currentSettings);
        $pusherAccountsInput = (array) $request->input('pusher_accounts', []);
        $websocket = (array) $request->input('websocket', []);
        $pusherAccounts = $this->normalizePusherAccounts($pusherAccountsInput, $pusher, $existingAccounts);
        $requestedActiveIndex = max(0, (int) $request->input('pusher_active_index', (int) ($currentSettings['pusher_active_index'] ?? 0)));
        $activeIndex = $requestedActiveIndex;
        $failedIndexes = array_values(array_filter(array_map('intval', (array) ($currentSettings['pusher_failed_indexes'] ?? [])), function (int $index) use ($pusherAccounts) {
            return isset($pusherAccounts[$index]);
        }));

        if (!isset($pusherAccounts[$activeIndex])) {
            $activeIndex = 0;
        }

        $comparable = static function (array $accounts): array {
            return array_values(array_map(function (array $account) {
                return [
                    'app_id' => (string) ($account['app_id'] ?? ''),
                    'key' => (string) ($account['key'] ?? ''),
                    'secret' => (string) ($account['secret'] ?? ''),
                    'cluster' => (string) ($account['cluster'] ?? 'mt1'),
                    'host' => (string) ($account['host'] ?? ''),
                    'port' => (string) ($account['port'] ?? '443'),
                    'scheme' => (string) ($account['scheme'] ?? 'https'),
                ];
            }, $accounts));
        };

        $accountsChanged = json_encode($comparable($existingAccounts)) !== json_encode($comparable($pusherAccounts));
        if ($accountsChanged || $activeIndex !== (int) ($currentSettings['pusher_active_index'] ?? 0)) {
            $failedIndexes = [];
        }

        $settings = [
            'realtime_mode' => $realtimeMode,
            'poll_interval_ms' => max(500, min(10000, (int) $request->input('poll_interval_ms', 1500))),
            'websocket_url' => trim((string) ($websocket['url'] ?? '')),
            'websocket_protocols' => trim((string) ($websocket['protocols'] ?? '')),
            'pusher_accounts' => $pusherAccounts,
            'pusher_app_id' => (string) data_get($pusherAccounts, '0.app_id', ''),
            'pusher_key' => (string) data_get($pusherAccounts, '0.key', ''),
            'pusher_secret' => (string) data_get($pusherAccounts, '0.secret', ''),
            'pusher_cluster' => (string) data_get($pusherAccounts, '0.cluster', 'mt1'),
            'pusher_host' => (string) data_get($pusherAccounts, '0.host', ''),
            'pusher_port' => (string) data_get($pusherAccounts, '0.port', '443'),
            'pusher_scheme' => (string) data_get($pusherAccounts, '0.scheme', 'https'),
            'pusher_active_index' => $activeIndex,
            'pusher_failed_indexes' => $failedIndexes,
            'maintenance_allowed_user_ids' => $maintenanceAllowedUsers,
            'redis_enabled' => !empty($runtimeControls['redis_available']) && $request->boolean('redis_enabled'),
            'jobs_enabled' => !empty($runtimeControls['jobs_available']) && $request->boolean('jobs_enabled'),
            'cron_enabled' => !empty($runtimeControls['cron_available']) && $request->boolean('cron_enabled'),
        ];

        $this->runtime->bumpConfigVersion($settings);
    }

    protected function normalizePusherAccounts(array $accounts, array $legacyPusher = [], array $existingAccounts = []): array
    {
        if (!$accounts && $legacyPusher) {
            $accounts = [$legacyPusher];
        }

        return collect(array_slice($accounts, 0, 8))
            ->map(function ($account, $index) use ($existingAccounts) {
                $account = (array) $account;
                $existingSecret = (string) data_get($existingAccounts, $index . '.secret', '');
                $secret = trim((string) ($account['secret'] ?? ''));
                if ($secret === '' && $existingSecret !== '') {
                    $secret = $existingSecret;
                }

                return [
                    'app_id' => trim((string) ($account['app_id'] ?? '')),
                    'key' => trim((string) ($account['key'] ?? '')),
                    'secret' => $secret,
                    'cluster' => trim((string) ($account['cluster'] ?? 'mt1')) ?: 'mt1',
                    'host' => trim((string) ($account['host'] ?? '')),
                    'port' => trim((string) ($account['port'] ?? '443')) ?: '443',
                    'scheme' => trim((string) ($account['scheme'] ?? 'https')) ?: 'https',
                ];
            })
            ->filter(function (array $account) {
                return $account['app_id'] !== '' && $account['key'] !== '' && $account['secret'] !== '';
            })
            ->values()
            ->all();
    }

    protected function normalizeMaintenanceAllowedUserIds($input): ?array
    {
        if (is_array($input)) {
            $input = implode(',', $input);
        }

        $raw = trim((string) $input);
        if ($raw === '') {
            return [];
        }

        $parts = preg_split('/[\\s,;]+/', $raw);
        if ($parts === false) {
            return null;
        }

        $ids = [];
        foreach ($parts as $part) {
            $part = trim((string) $part);
            if ($part === '') {
                continue;
            }

            if (filter_var($part, FILTER_VALIDATE_INT) === false) {
                return null;
            }

            $id = (int) $part;
            if ($id <= 0 || in_array($id, $ids, true)) {
                if ($id <= 0) {
                    return null;
                }
                continue;
            }
            $ids[] = $id;
        }

        return $ids;
    }

    protected function adminAlerts(): array
    {
        $alerts = $this->runtime->adminAlerts();

        $activeBlocks = GameSecurityBlock::query()
            ->leftJoin('users', 'users.id', '=', 'bd_game_final_security_blocks.user_id')
            ->leftJoin('bd_game_final_games as games', 'games.id', '=', 'bd_game_final_security_blocks.game_id')
            ->where('bd_game_final_security_blocks.status', 'active')
            ->where(function ($query) {
                $query->whereNull('bd_game_final_security_blocks.lifted_at')
                    ->orWhere('bd_game_final_security_blocks.lifted_at', '>', now());
            })
            ->orderByDesc('bd_game_final_security_blocks.id')
            ->limit(5)
            ->get([
                'bd_game_final_security_blocks.id',
                'bd_game_final_security_blocks.user_id',
                'bd_game_final_security_blocks.reason',
                'bd_game_final_security_blocks.trigger',
                'bd_game_final_security_blocks.blocked_at',
                'users.name as user_name',
                'games.game_code',
            ]);

        foreach ($activeBlocks as $block) {
            $alerts[] = [
                'level' => 'danger',
                'message' => 'JAMBOai blocked user #' . $block->user_id . ' from ' . ($block->game_code ?: 'all games') . '.',
                'meta' => [
                    'reason' => (string) $block->reason,
                    'trigger' => (string) $block->trigger,
                    'user_name' => (string) $block->user_name,
                ],
                'created_at' => optional($block->blocked_at)->toDateTimeString(),
            ];
        }

        $liftedBlocks = GameSecurityBlock::query()
            ->leftJoin('users', 'users.id', '=', 'bd_game_final_security_blocks.user_id')
            ->where(function ($query) {
                $query->where('bd_game_final_security_blocks.status', 'lifted')
                    ->orWhere('bd_game_final_security_blocks.lifted_at', '<=', now());
            })
            ->orderByDesc('bd_game_final_security_blocks.lifted_at')
            ->limit(5)
            ->get([
                'bd_game_final_security_blocks.user_id',
                'bd_game_final_security_blocks.reason',
                'bd_game_final_security_blocks.lifted_at',
                'users.name as user_name',
            ]);

        foreach ($liftedBlocks as $block) {
            $alerts[] = [
                'level' => 'warning',
                'message' => 'User #' . $block->user_id . ' was removed from JAMBOai lock.',
                'meta' => [
                    'reason' => (string) $block->reason,
                    'user_name' => (string) $block->user_name,
                ],
                'created_at' => optional($block->lifted_at)->toDateTimeString(),
            ];
        }

        return array_slice($alerts, 0, 12);
    }

    protected function redisAvailable(): bool
    {
        return extension_loaded('redis') || class_exists(\Predis\Client::class);
    }

    protected function jobsAvailable(): bool
    {
        $connection = (string) config('queue.default', 'sync');
        return $connection !== 'sync' && $connection !== 'null';
    }

    protected function boardCountFor(array $cfg): int
    {
        return max(1, count((array) ($cfg['boards'] ?? [])));
    }

    protected function gameFamilyLabel(string $gameCode): string
    {
        if (str_starts_with($gameCode, 'teen_patti')) {
            return 'Teen Patti';
        }

        if ($gameCode === 'lucky7_pro' || $gameCode === 'lucky88_master' || str_starts_with($gameCode, 'lucky77')) {
            return 'Lucky Wheel';
        }

        if (str_starts_with($gameCode, 'fruits_loop')) {
            return 'Fruits Loop';
        }

        if ($gameCode === 'greedy') {
            return 'Greedy';
        }

        if (str_starts_with($gameCode, 'fruit_slot')) {
            return 'Fruit Slot';
        }

        return 'Live Room';
    }

    protected function estimatedTableRows(string $table): int
    {
        try {
            $database = config('database.connections.mysql.database');
            $row = DB::table('information_schema.tables')
                ->where('table_schema', $database)
                ->where('table_name', $table)
                ->first(['table_rows']);

            if ($row && $row->table_rows !== null) {
                return max(0, (int) $row->table_rows);
            }
        } catch (\Throwable $e) {
            // Fall back below.
        }

        try {
            return (int) DB::table($table)->count();
        } catch (\Throwable $e) {
            return 0;
        }
    }

    protected function sharedGameBalance(): float
    {
        $seedGameId = (int) (Game::query()->orderBy('id')->value('id') ?? 0);
        if ($seedGameId <= 0) {
            return 0.0;
        }

        try {
            return (float) $this->gameBank->currentBalanceForGameId($seedGameId, false);
        } catch (\Throwable $e) {
            return 0.0;
        }
    }

    protected function boardIcon(string $gameCode, string $boardKey): string
    {
        $key = strtolower(trim($boardKey));

        if (str_starts_with($gameCode, 'teen_patti')) {
            return ['a' => 'A', 'b' => 'K', 'c' => 'Q'][$key] ?? 'T';
        }

        $fruitIcons = [
            'apple' => '🍎',
            'watermelon' => '🍉',
            'cherry' => '🍒',
            'banana' => '🍌',
            'grapes' => '🍇',
            'orange' => '🍊',
            'mango' => '🥭',
            'pineapple' => '🍍',
        ];

        if (isset($fruitIcons[$key])) {
            return $fruitIcons[$key];
        }

        return ['slot' => '7', 'melon' => 'M', 'plum' => 'P'][$key] ?? strtoupper(substr($key ?: 'B', 0, 1));
    }

    protected function winnerCardsForRound(GameRound $round): array
    {
        $payload = is_array($round->result_payload_json) ? $round->result_payload_json : [];
        $winner = (string) ($payload['winner_board'] ?? $round->winner_board_key ?? '');
        $cards = data_get($payload, 'cards.' . $winner . '.cards', []);
        $label = (string) data_get($payload, 'cards.' . $winner . '.label', '');

        if (!is_array($cards)) {
            $cards = [];
        }

        return [
            'label' => $label,
            'cards' => array_values($cards),
        ];
    }

}

