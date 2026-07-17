<?php

namespace App\Services\GameFinal;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\GameFinal\Game;
use App\Models\GameFinal\GameBet;
use App\Models\GameFinal\GameRound;
use App\Models\GameFinal\GameAuditLog;
use App\Models\GameFinal\GameSettlement;
use App\Models\GameFinal\GameSettlementItem;

class SettlementService
{
    protected $roundService;
    protected $wallets;
    protected $gameBank;

    public function __construct(RoundService $roundService, WalletService $wallets, GameBankService $gameBank)
    {
        $this->roundService = $roundService;
        $this->wallets = $wallets;
        $this->gameBank = $gameBank;
    }

    public function settleRound(GameRound $round)
    {
        try {
            return DB::transaction(function () use ($round) {
                $lockedRound = GameRound::where('id', $round->id)->lockForUpdate()->first();
                if (!$lockedRound) {
                    return null;
                }

                $phaseBeforeSync = $this->roundService->determinePhase($lockedRound);
                $lockedRound = $this->roundService->syncRoundPhase($lockedRound);

                if (
                    !in_array($phaseBeforeSync, ['revealed', 'settled', 'finished'], true)
                    && !in_array($lockedRound->status, ['revealed', 'settled', 'finished'], true)
                ) {
                    return GameSettlement::where('game_round_id', $lockedRound->id)->lockForUpdate()->first();
                }

                if (!$lockedRound->winner_board_key) {
                    $gameCode = optional(Game::find($lockedRound->game_id))->game_code;
                    if (!$gameCode) {
                        throw new \RuntimeException('missing_game_for_round');
                    }

                    $statusOverride = $phaseBeforeSync === 'finished' ? 'settled' : $phaseBeforeSync;
                    $lockedRound = $this->roundService->ensureResult($gameCode, $lockedRound, $statusOverride);
                }

                $existing = GameSettlement::where('game_round_id', $lockedRound->id)->lockForUpdate()->first();
                if ($existing && in_array($existing->settlement_status, ['settled', 'completed'], true)) {
                    return $existing;
                }

                $settlement = $existing ?: GameSettlement::create([
                    'game_id' => $lockedRound->game_id,
                    'game_round_id' => $lockedRound->id,
                    'winner_board_key' => $lockedRound->winner_board_key,
                    'settlement_run_uid' => (string) Str::uuid(),
                    'settlement_status' => 'processing',
                    'total_bet_amount' => 0,
                    'total_payout_amount' => 0,
                    'total_winning_bets' => 0,
                    'total_losing_bets' => 0,
                    'net_house_result' => 0,
                    'meta_json' => ['winner_board' => $lockedRound->winner_board_key],
                ]);

                $bets = GameBet::where('game_round_id', $lockedRound->id)
                    ->orderBy('user_id')
                    ->orderBy('id')
                    ->lockForUpdate()
                    ->get();

                $userIds = $bets->pluck('user_id')->filter()->unique()->values()->all();
                $users = User::whereIn('id', $userIds)->lockForUpdate()->get()->keyBy('id');
                $totalPayoutRequired = (float) $bets
                    ->where('canonical_board_key', $lockedRound->winner_board_key)
                    ->sum('potential_win');
                $gameBankBefore = $this->gameBank->currentBalanceForGameId((int) $lockedRound->game_id, true);
                $gameBankAfter = $gameBankBefore;

                if ($totalPayoutRequired > 0) {
                    $bank = $this->gameBank->debit($lockedRound->game_id, $totalPayoutRequired);
                    if (empty($bank['ok'])) {
                        throw new \RuntimeException('game_bank_insufficient_for_payout');
                    }

                    $gameBankBefore = (float) $bank['before'];
                    $gameBankAfter = (float) $bank['after'];
                }

                $totalBet = 0.0;
                $totalPayout = 0.0;
                $totalWinningBets = 0;
                $totalLosingBets = 0;

                foreach ($bets as $bet) {
                    if (in_array((string) $bet->status, ['won', 'lost'], true) && $bet->settlement_item_id) {
                        continue;
                    }

                    $walletUser = $users->get($bet->user_id);
                    if (!$walletUser) {
                        throw new \RuntimeException('missing_user_for_bet');
                    }

                    $walletBefore = $this->wallets->currentBalance($walletUser);
                    $winAmount = 0.0;
                    $netResult = -(float) $bet->amount;
                    $resultStatus = 'lost';
                    $walletAfter = $walletBefore;

                    if ($bet->canonical_board_key === $lockedRound->winner_board_key) {
                        $winAmount = (float) $bet->potential_win;
                        $creditRef = 'settlement-credit:' . $settlement->id . ':' . $bet->id;
                        $credit = $this->wallets->credit($walletUser, $winAmount, [
                            'game_id' => $lockedRound->game_id,
                            'game_round_id' => $lockedRound->id,
                            'game_bet_id' => $bet->id,
                            'game_settlement_id' => $settlement->id,
                            'reason' => 'settlement_credit',
                            'reference_uid' => $creditRef,
                            'meta_json' => [
                                'winner_board' => $lockedRound->winner_board_key,
                                'settlement_run_uid' => $settlement->settlement_run_uid,
                            ],
                        ]);
                        if (empty($credit['ok'])) {
                            throw new \RuntimeException('credit_failed');
                        }
                        $walletAfter = $credit['after'];
                        $netResult = $winAmount - (float) $bet->amount;
                        $resultStatus = 'won';
                        $totalWinningBets++;
                    } else {
                        $totalLosingBets++;
                    }

                    $item = GameSettlementItem::updateOrCreate(
                        ['game_bet_id' => $bet->id],
                        [
                            'game_settlement_id' => $settlement->id,
                            'game_round_id' => $lockedRound->id,
                            'user_id' => $bet->user_id,
                            'canonical_board_key' => $bet->canonical_board_key,
                            'bet_amount' => (float) $bet->amount,
                            'payout_multiplier' => (float) $bet->payout_multiplier,
                            'win_amount' => $winAmount,
                            'net_result' => $netResult,
                            'result_status' => $resultStatus,
                            'wallet_before' => $walletBefore,
                            'wallet_after' => $walletAfter,
                            'meta_json' => [
                                'winner_board' => $lockedRound->winner_board_key,
                                'settlement_run_uid' => $settlement->settlement_run_uid,
                            ],
                        ]
                    );

                    $bet->status = $resultStatus;
                    $bet->win_balance = $winAmount;
                    $bet->settlement_item_id = $item->id;
                    $bet->settled_at = now();
                    $bet->save();
                }

                $totalBet = (float) GameBet::where('game_round_id', $lockedRound->id)->sum('amount');
                $totalPayout = (float) GameSettlementItem::where('game_settlement_id', $settlement->id)->sum('win_amount');
                $totalWinningBets = (int) GameSettlementItem::where('game_settlement_id', $settlement->id)->where('result_status', 'won')->count();
                $totalLosingBets = (int) GameSettlementItem::where('game_settlement_id', $settlement->id)->where('result_status', 'lost')->count();

                $settlement->winner_board_key = $lockedRound->winner_board_key;
                $settlement->settlement_status = 'settled';
                $settlement->total_bet_amount = $totalBet;
                $settlement->total_payout_amount = $totalPayout;
                $settlement->total_winning_bets = $totalWinningBets;
                $settlement->total_losing_bets = $totalLosingBets;
                $settlement->net_house_result = $totalBet - $totalPayout;
                $settlement->settled_at = now();
                $settlement->meta_json = array_merge((array) ($settlement->meta_json ?? []), [
                    'winner_board' => $lockedRound->winner_board_key,
                    'settlement_run_uid' => $settlement->settlement_run_uid,
                    'game_bank_before' => $gameBankBefore,
                    'game_bank_after' => $gameBankAfter,
                ]);
                $settlement->save();

                $lockedRound->status = 'settled';
                $lockedRound->save();

                GameAuditLog::create([
                    'game_id' => $lockedRound->game_id,
                    'game_round_id' => $lockedRound->id,
                    'event_type' => 'round_settled',
                    'message' => 'round settlement completed',
                    'payload_json' => [
                        'winner_board' => $lockedRound->winner_board_key,
                        'total_bet_amount' => $totalBet,
                        'total_payout_amount' => $totalPayout,
                        'game_bank_before' => $gameBankBefore,
                        'game_bank_after' => $gameBankAfter,
                        'settlement_id' => $settlement->id,
                        'settlement_run_uid' => $settlement->settlement_run_uid,
                    ],
                ]);

                return $settlement->fresh();
            }, 3);
        } catch (\Throwable $e) {
            try {
                $failed = GameSettlement::where('game_round_id', $round->id)->first();
                if (!$failed) {
                    $failed = new GameSettlement();
                    $failed->game_id = $round->game_id;
                    $failed->game_round_id = $round->id;
                    $failed->winner_board_key = $round->winner_board_key;
                    $failed->settlement_run_uid = (string) Str::uuid();
                }

                if (!in_array((string) $failed->settlement_status, ['settled', 'completed'], true)) {
                    $failed->settlement_status = 'failed';
                    $failed->meta_json = array_merge((array) ($failed->meta_json ?? []), [
                        'error' => $e->getMessage(),
                        'failed_at' => now()->toDateTimeString(),
                    ]);
                    $failed->save();
                }

                GameAuditLog::create([
                    'game_id' => $round->game_id,
                    'game_round_id' => $round->id,
                    'event_type' => 'round_settlement_failed',
                    'message' => 'round settlement failed',
                    'payload_json' => [
                        'error' => $e->getMessage(),
                    ],
                ]);
            } catch (\Throwable $ignored) {
            }

            throw $e;
        }
    }

    public function settleDueRounds(string $gameCode, int $limit = 50): int
    {
        $game = Game::where('game_code', $gameCode)->first();
        if (!$game) {
            return 0;
        }

        $settlementTable = config('bd_game_final.tables.settlements', 'bd_game_final_settlements');
        $rounds = GameRound::query()
            ->where('game_id', $game->id)
            ->whereNotNull('settle_at')
            ->where('settle_at', '<=', now())
            ->whereNotExists(function ($query) use ($settlementTable) {
                $query->select(DB::raw(1))
                    ->from($settlementTable)
                    ->whereColumn($settlementTable . '.game_round_id', 'bd_game_final_rounds.id')
                    ->whereIn($settlementTable . '.settlement_status', ['settled', 'completed']);
            })
            ->orderBy('id')
            ->limit(max(1, $limit))
            ->get();

        $count = 0;
        foreach ($rounds as $round) {
            try {
                $settlement = $this->settleRound($round);
                if ($settlement && in_array((string) $settlement->settlement_status, ['settled', 'completed'], true)) {
                    $count++;
                }
            } catch (\Throwable $e) {
                try {
                    GameAuditLog::create([
                        'game_id' => $round->game_id,
                        'game_round_id' => $round->id,
                        'event_type' => 'due_round_settlement_skipped',
                        'message' => 'Due round settlement failed; continuing with later due rounds',
                        'payload_json' => [
                            'error' => $e->getMessage(),
                        ],
                    ]);
                } catch (\Throwable $ignored) {
                }
            }
        }

        return $count;
    }

    public function settleUserPending($gameCode, User $user)
    {
        return User::find($user->id);
    }
}

