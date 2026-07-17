<?php

namespace App\Services\GameFinal;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\GameFinal\Game;
use App\Models\GameFinal\GameBet;
use App\Models\GameFinal\GameBoard;
use App\Models\GameFinal\GameRound;
use App\Models\GameFinal\GameAuditLog;
use App\Support\GameFinal\BoardMapper;
use App\Services\GameFinal\GameUserService;

class BetService
{
    protected $configService;
    protected $roundService;
    protected $wallets;
    protected $gameBank;
    protected $users;
    protected $heartbeats;

    public function __construct(GameConfigService $configService, RoundService $roundService, WalletService $wallets, GameBankService $gameBank, GameUserService $users, HeartbeatService $heartbeats)
    {
        $this->configService = $configService;
        $this->roundService = $roundService;
        $this->wallets = $wallets;
        $this->gameBank = $gameBank;
        $this->users = $users;
        $this->heartbeats = $heartbeats;
    }

    public function placeBet($gameCode, User $user, $roundNo, $inputBoardKey, $amount, $requestUid = null)
    {
        if (!is_numeric($amount)) {
            return ['st' => false, 'msg' => 'invalid_amount'];
        }

        $amount = round((float) $amount, 2);
        if (!is_finite($amount) || $amount <= 0) {
            return ['st' => false, 'msg' => 'invalid_amount'];
        }

        $requestUid = $this->normalizeRequestUid($requestUid);

        $canonical = BoardMapper::normalize($gameCode, $inputBoardKey);
        if (!in_array($canonical, BoardMapper::allCanonical($gameCode), true)) {
            return ['st' => false, 'msg' => 'invalid_board'];
        }

        $cfg = $this->configService->get($gameCode);

        $gameStatus = (string) ($cfg['game_status'] ?? 'live');
        if (!$cfg || empty($cfg['boards']) || empty($cfg['is_active']) || !in_array($gameStatus, ['live', 'developer', 'active'], true)) {
            return ['st' => false, 'msg' => 'game_inactive'];
        }

        if ($amount < (float) ($cfg['min_bet'] ?? 1) || $amount > (float) ($cfg['max_bet'] ?? 999999999)) {
            return ['st' => false, 'msg' => 'bet_amount_out_of_range'];
        }

        return DB::transaction(function () use ($gameCode, $user, $amount, $canonical, $cfg, $roundNo, $requestUid, $inputBoardKey) {
            $game = Game::where('game_code', $gameCode)->lockForUpdate()->firstOrFail();
            $lockedUser = User::where('id', $user->id)->lockForUpdate()->first();
            if (!$lockedUser) {
                return ['st' => false, 'msg' => 'invalid_user'];
            }

            $playCheck = $this->users->canPlay($lockedUser, $gameCode);
            if (empty($playCheck['ok'])) {
                return ['st' => false, 'msg' => (string) ($playCheck['reason'] ?? 'user_not_allowed')];
            }

            $board = GameBoard::where('game_id', $game->id)
                ->where('canonical_key', $canonical)
                ->lockForUpdate()
                ->first();

            if (!$board || (int) ($board->is_active ?? 0) !== 1) {
                return ['st' => false, 'msg' => 'invalid_board'];
            }

            $currentRound = GameRound::where('game_id', $game->id)
                ->whereIn('status', ['betting', 'locked', 'revealed', 'settled'])
                ->orderByDesc('id')
                ->lockForUpdate()
                ->first();

            if (!$currentRound) {
                $currentRound = $this->roundService->createNextRound($gameCode, $game);
            }

            $currentRound = $this->roundService->syncRoundPhase($currentRound);
            if ($this->roundService->determinePhase($currentRound) === 'finished') {
                $currentRound = $this->roundService->createNextRound($gameCode, $game);
            }

            if ($roundNo && (string) $roundNo !== (string) $currentRound->round_no) {
                $penalty = $this->applyInactivityPenaltyIfNeeded($gameCode, $game, $lockedUser, $currentRound, $roundNo, $amount, $canonical, $inputBoardKey, $requestUid);
                if ($penalty !== null) {
                    return $penalty;
                }
                return ['st' => false, 'msg' => 'invalid_round'];
            }

            $round = $currentRound;
            if ($round->status !== 'betting') {
                $penalty = $this->applyInactivityPenaltyIfNeeded($gameCode, $game, $lockedUser, $round, $roundNo, $amount, $canonical, $inputBoardKey, $requestUid);
                if ($penalty !== null) {
                    return $penalty;
                }
                return ['st' => false, 'msg' => 'bet_closed'];
            }

            if ($requestUid) {
                $dup = GameBet::where('game_id', $game->id)
                    ->where('user_id', $lockedUser->id)
                    ->where('request_uid', $requestUid)
                    ->lockForUpdate()
                    ->first();
                if ($dup) {
                    $samePayload = (string) $dup->round_no === (string) $round->round_no
                        && (string) $dup->canonical_board_key === (string) $canonical
                        && (float) $dup->amount === (float) $amount;

                    if (!$samePayload) {
                        return ['st' => false, 'msg' => 'duplicate_request'];
                    }

                    return [
                        'st' => true,
                        'bet' => $dup,
                        'balance' => (float) $this->wallets->currentBalance($lockedUser),
                    ];
                }
            } else {
                $implicitWindowMs = max(0, (int) ($cfg['implicit_idempotency_window_ms'] ?? 700));
                if ($implicitWindowMs > 0) {
                    $cutoff = now()->subMilliseconds($implicitWindowMs);
                    $dupNoUid = GameBet::where('game_id', $game->id)
                        ->where('game_round_id', $round->id)
                        ->where('user_id', $lockedUser->id)
                        ->whereNull('request_uid')
                        ->where('canonical_board_key', $canonical)
                        ->where('amount', $amount)
                        ->where('created_at', '>=', $cutoff)
                        ->lockForUpdate()
                        ->first();

                    if ($dupNoUid) {
                        return [
                            'st' => true,
                            'bet' => $dupNoUid,
                            'balance' => (float) $this->wallets->currentBalance($lockedUser),
                        ];
                    }
                }
            }

            $distinctCount = GameBet::where('game_round_id', $round->id)
                ->where('user_id', $lockedUser->id)
                ->distinct('canonical_board_key')
                ->count('canonical_board_key');

            $existsSame = GameBet::where('game_round_id', $round->id)
                ->where('user_id', $lockedUser->id)
                ->where('canonical_board_key', $canonical)
                ->exists();

            if (!$existsSame && $distinctCount >= (int) $cfg['max_distinct_boards_per_user']) {
                return ['st' => false, 'msg' => 'max_distinct_board_limit'];
            }

            $maxBoardPot = (float) ($cfg['max_total_bet_per_board'] ?? $cfg['board_max_total_bet'] ?? 0);
            if ($maxBoardPot > 0) {
                $boardTotal = (float) GameBet::where('game_round_id', $round->id)
                    ->where('canonical_board_key', $canonical)
                    ->lockForUpdate()
                    ->sum('amount');

                if (($boardTotal + $amount) > $maxBoardPot) {
                    return ['st' => false, 'msg' => 'max_pot_reached'];
                }
            }

            $multiplier = BoardMapper::multiplier($gameCode, $canonical);
            $walletRef = $requestUid
                ? ('bet-debit:' . $game->id . ':' . $round->id . ':' . $lockedUser->id . ':' . $requestUid)
                : ('bet-debit:' . $game->id . ':' . $round->id . ':' . $lockedUser->id . ':' . substr(hash('sha256', $canonical . '|' . $amount . '|' . microtime(true)), 0, 16));
            $wallet = $this->wallets->debit($lockedUser, $amount, [
                'game_id' => $game->id,
                'game_round_id' => $round->id,
                'reason' => 'bet_debit',
                'reference_uid' => $walletRef,
                'meta_json' => [
                    'game_code' => $gameCode,
                    'board' => $canonical,
                    'round_no' => $round->round_no,
                ],
            ]);

            if (!$wallet['ok']) {
                return ['st' => false, 'msg' => 'insufficient_balance'];
            }

            $bank = $this->gameBank->credit($game->id, $amount);
            if (empty($bank['ok'])) {
                throw new \RuntimeException('game_bank_credit_failed');
            }

            $bet = GameBet::create([
                'game_id' => $game->id,
                'game_round_id' => $round->id,
                'round_no' => $round->round_no,
                'user_id' => $lockedUser->id,
                'amount' => $amount,
                'frontend_board_key' => BoardMapper::frontendKey($gameCode, $canonical),
                'canonical_board_key' => $canonical,
                'payout_multiplier' => $multiplier,
                'potential_win' => $amount * $multiplier,
                'request_uid' => $requestUid,
                'status' => 'pending',
                'now_user_balance' => $wallet['after'],
                'meta_json' => [
                    'source' => 'game_final_api',
                    'input_board_key' => $inputBoardKey,
                ],
            ]);

            GameAuditLog::create([
                'game_id' => $game->id,
                'game_round_id' => $round->id,
                'user_id' => $lockedUser->id,
                'event_type' => 'bet_placed',
                'message' => 'bet accepted',
                'payload_json' => [
                    'board' => $canonical,
                    'amount' => $amount,
                    'request_uid' => $requestUid,
                    'game_balance_after' => (float) $bank['after'],
                ],
            ]);

            return [
                'st' => true,
                'bet' => $bet,
                'balance' => (float) $wallet['after'],
                'game_balance' => (float) $bank['after'],
            ];
        });
    }

    protected function normalizeRequestUid($requestUid): ?string
    {
        if (!is_string($requestUid)) {
            return null;
        }

        $trimmed = trim($requestUid);
        if ($trimmed === '') {
            return null;
        }

        return substr($trimmed, 0, 120);
    }

    protected function applyInactivityPenaltyIfNeeded($gameCode, Game $game, User $user, ?GameRound $round, $requestedRoundNo, float $amount, string $canonicalBoardKey, $frontendBoardKey, ?string $requestUid): ?array
    {
        if (empty(config('bd_game_final.security.inactive_penalty_enabled', true))) {
            return null;
        }

        $heartbeat = $this->heartbeats->latest($gameCode, (int) $user->id);
        if (!$heartbeat || !$heartbeat->last_seen_at) {
            return null;
        }

        $threshold = max(5, (int) config('bd_game_final.security.inactive_penalty_threshold_seconds', 25));
        $staleSeconds = (int) $heartbeat->last_seen_at->diffInSeconds(now());
        if ($staleSeconds < $threshold) {
            return null;
        }

        $currentRoundNo = $round ? (string) $round->round_no : '';
        $requested = trim((string) ($requestedRoundNo ?? ''));
        $roundMismatch = $requested !== '' && $currentRoundNo !== '' && $requested !== $currentRoundNo;
        $closedRound = !$round || $round->status !== 'betting';

        if (!$roundMismatch && !$closedRound) {
            return null;
        }

        $reason = $roundMismatch ? 'inactive_round_mismatch' : 'inactive_bet_closed';
        $referenceUid = $requestUid
            ? ('inactive-penalty:' . $game->id . ':' . $user->id . ':' . $requestUid)
            : ('inactive-penalty:' . $game->id . ':' . $user->id . ':' . substr(hash('sha256', $canonicalBoardKey . '|' . $amount . '|' . microtime(true)), 0, 20));

        $meta = [
            'game_code' => $gameCode,
            'attempted_round_no' => $requested,
            'current_round_no' => $currentRoundNo,
            'attempted_board_key' => $canonicalBoardKey,
            'frontend_board_key' => (string) $frontendBoardKey,
            'penalty_reason' => $reason,
            'heartbeat_gap_seconds' => $staleSeconds,
            'heartbeat_visibility' => data_get($heartbeat->client_meta_json, 'visibility'),
            'heartbeat_inactive_ms' => (int) data_get($heartbeat->client_meta_json, 'inactive_ms', 0),
        ];

        $wallet = $this->wallets->debit($user, $amount, [
            'game_id' => $game->id,
            'game_round_id' => $round ? $round->id : null,
            'reason' => 'inactivity_penalty',
            'reference_uid' => $referenceUid,
            'meta_json' => $meta,
        ]);

        if (!$wallet['ok']) {
            return null;
        }

        GameAuditLog::create([
            'game_id' => $game->id,
            'game_round_id' => $round ? $round->id : null,
            'user_id' => $user->id,
            'event_type' => 'bet_penalized',
            'message' => 'Inactive late bet was penalized by JAMBOai.',
            'payload_json' => array_merge($meta, [
                'wallet_before' => (float) $wallet['before'],
                'wallet_after' => (float) $wallet['after'],
                'penalty_amount' => $amount,
            ]),
        ]);

        return [
            'st' => false,
            'code' => 'bet_punished',
            'msg' => 'Late inactive bet punished by JAMBOai.',
            'message' => 'Late inactive bet punished by JAMBOai.',
            'punished' => true,
            'balance' => (float) $wallet['after'],
            'punishment' => [
                'amount' => $amount,
                'status' => 'punishment',
                'status_label' => 'Punishment',
                'reason' => $reason,
            ],
        ];
    }
}
