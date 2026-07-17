<?php

namespace App\Services\GameFinal;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Models\GameFinal\Game;
use App\Models\GameFinal\GameRound;
use App\Models\GameFinal\GameBoard;
use App\Models\GameFinal\GameBetSummary;
use App\Helpers\GameFinal\WinnerDecisionHelper;
use App\Helpers\GameFinal\TeenPattiResultHelper;
use App\Helpers\GameFinal\Lucky77ResultHelper;
use App\Helpers\GameFinal\FruitsSlotResultHelper;
use App\Helpers\GameFinal\FruitsLoopResultHelper;

class RoundService
{
    protected $configService;
    protected $gameBank;
    protected $winnerHelper;
    protected $gameConfigCache = [];

    public function __construct(GameConfigService $configService, GameBankService $gameBank, WinnerDecisionHelper $winnerHelper)
    {
        $this->configService = $configService;
        $this->gameBank = $gameBank;
        $this->winnerHelper = $winnerHelper;
    }

    protected function isTeenPattiFamily(string $gameCode): bool
    {
        return str_starts_with($gameCode, 'teen_patti');
    }

    protected function isLucky77Family(string $gameCode): bool
    {
        return $gameCode === 'lucky7_pro'
            || $gameCode === 'lucky88_master'
            || str_starts_with($gameCode, 'lucky77');
    }

    protected function isFruitsLoopFamily(string $gameCode): bool
    {
        return str_starts_with($gameCode, 'fruits_loop');
    }

    protected function configForGameId(int $gameId): array
    {
        if (isset($this->gameConfigCache[$gameId])) {
            return $this->gameConfigCache[$gameId];
        }

        $game = Game::find($gameId);
        if (!$game) {
            return $this->gameConfigCache[$gameId] = [];
        }

        return $this->gameConfigCache[$gameId] = $this->configService->get($game->game_code);
    }

    public function nextRoundAt(GameRound $round): ?Carbon
    {
        if (!$round->settle_at) {
            return null;
        }

        $cfg = $this->configForGameId((int) $round->game_id);
        $durations = $this->phaseDurations($cfg);

        return $this->addDuration($round->settle_at->copy(), $durations['settled']);
    }

    public function phaseDurations(array $cfg): array
    {
        $startPopup = max(0, (float) ($cfg['start_bet_popup_sec'] ?? 0));
        $startWait = max(0, (float) ($cfg['start_bet_wait_sec'] ?? 0));
        $betting = max(0, (float) ($cfg['bet_duration_sec'] ?? 0));
        $stopPopup = max(0, (float) ($cfg['stop_bet_popup_sec'] ?? 0));
        $stopWait = max(0, (float) ($cfg['stop_bet_wait_sec'] ?? 0));
        $revealMain = max(0, (float) ($cfg['reveal_duration_sec'] ?? 0));
        $revealWait = max(0, (float) ($cfg['reveal_wait_sec'] ?? 0));
        $winnerPopup = max(0, (float) ($cfg['winner_popup_sec'] ?? 0));
        $winnerWait = max(0, (float) ($cfg['winner_wait_sec'] ?? 0));
        $payout = max(0, (float) ($cfg['settle_duration_sec'] ?? 0));
        $settleWait = max(0, (float) ($cfg['settle_wait_sec'] ?? 0));

        return [
            'start_popup' => $startPopup,
            'start_wait' => $startWait,
            'betting' => $betting,
            'stop_popup' => $stopPopup,
            'stop_wait' => $stopWait,
            'locked' => $stopPopup + $stopWait,
            'reveal_main' => $revealMain,
            'reveal_wait' => $revealWait,
            'winner_popup' => $winnerPopup,
            'winner_wait' => $winnerWait,
            'revealed' => $revealMain + $revealWait + $winnerPopup + $winnerWait,
            'payout' => $payout,
            'settle_wait' => $settleWait,
            'settled' => $payout + $settleWait,
        ];
    }

    public function timelineMarkers(?GameRound $round, array $cfg): array
    {
        $durations = $this->phaseDurations($cfg);
        if (!$round) {
            return [
                'start_at' => null,
                'bet_countdown_start_at' => null,
                'bet_close_at' => null,
                'reveal_at' => null,
                'reveal_done_at' => null,
                'winner_popup_at' => null,
                'winner_popup_end_at' => null,
                'settle_at' => null,
                'payout_end_at' => null,
                'next_round_at' => null,
            ];
        }

        $betCountdownStartAt = $round->start_at
            ? $this->addDuration($round->start_at->copy(), $durations['start_popup'] + $durations['start_wait'])
            : null;
        $revealDoneAt = $round->reveal_at
            ? $this->addDuration($round->reveal_at->copy(), $durations['reveal_main'])
            : null;
        $winnerPopupAt = $revealDoneAt
            ? $this->addDuration($revealDoneAt->copy(), $durations['reveal_wait'])
            : null;
        $winnerPopupEndAt = $winnerPopupAt
            ? $this->addDuration($winnerPopupAt->copy(), $durations['winner_popup'])
            : null;
        $payoutEndAt = $round->settle_at
            ? $this->addDuration($round->settle_at->copy(), $durations['payout'])
            : null;
        $nextRoundAt = $payoutEndAt
            ? $this->addDuration($payoutEndAt->copy(), $durations['settle_wait'])
            : null;

        return [
            'start_at' => $round->start_at ? $round->start_at->timestamp : null,
            'bet_countdown_start_at' => $betCountdownStartAt ? $betCountdownStartAt->timestamp : null,
            'bet_close_at' => $round->bet_close_at ? $round->bet_close_at->timestamp : null,
            'reveal_at' => $round->reveal_at ? $round->reveal_at->timestamp : null,
            'reveal_done_at' => $revealDoneAt ? $revealDoneAt->timestamp : null,
            'winner_popup_at' => $winnerPopupAt ? $winnerPopupAt->timestamp : null,
            'winner_popup_end_at' => $winnerPopupEndAt ? $winnerPopupEndAt->timestamp : null,
            'settle_at' => $round->settle_at ? $round->settle_at->timestamp : null,
            'payout_end_at' => $payoutEndAt ? $payoutEndAt->timestamp : null,
            'next_round_at' => $nextRoundAt ? $nextRoundAt->timestamp : null,
        ];
    }

    public function getOrCreateOpenRound($gameCode)
    {
        return DB::transaction(function () use ($gameCode) {
            $game = Game::where('game_code', $gameCode)->lockForUpdate()->firstOrFail();
            $round = GameRound::where('game_id', $game->id)
                ->orderByDesc('id')
                ->lockForUpdate()
                ->first();

            if ($round) {
                $phase = $this->determinePhase($round);
                if ($phase !== 'finished') {
                    if ($round->status !== $phase) {
                        $round->status = $phase;
                        $round->save();
                    }

                    return $round->fresh();
                }

                if ($round->status !== 'finished') {
                    $round->status = 'finished';
                    $round->save();
                }
            }

            return $this->createNextRound($gameCode, $game);
        }, 3);
    }

    public function createNextRound($gameCode, $game = null)
    {
        $game = $game ?: Game::where('game_code', $gameCode)->firstOrFail();
        $cfg = $this->configService->get($gameCode);
        $now = Carbon::now();
        $durations = $this->phaseDurations($cfg);
        $betClose = $this->addDuration($now->copy(), $durations['start_popup'] + $durations['start_wait'] + $durations['betting']);
        $reveal = $this->addDuration($betClose->copy(), $durations['locked']);
        $settle = $this->addDuration($reveal->copy(), $durations['revealed']);

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $roundNo = $this->buildRoundNo($gameCode, $now, $attempt);
            $fairAudit = $this->newFairAuditSeed($gameCode, $roundNo, $now);
            try {
                return GameRound::create([
                    'game_id' => $game->id,
                    'round_no' => $roundNo,
                    'start_at' => $now,
                    'bet_close_at' => $betClose,
                    'reveal_at' => $reveal,
                    'settle_at' => $settle,
                    'status' => 'betting',
                    'decision_snapshot_json' => [
                        'audit' => $fairAudit,
                    ],
                ]);
            } catch (QueryException $e) {
                if ($this->isDuplicateKeyException($e)) {
                    usleep(10000);
                    continue;
                }
                throw $e;
            }
        }

        throw new \RuntimeException('round_create_collision');
    }

    public function getByRoundNo($gameCode, $roundNo)
    {
        $game = Game::where('game_code', $gameCode)->first();
        if (!$game) {
            return null;
        }
        return GameRound::where('game_id', $game->id)->where('round_no', $roundNo)->orderByDesc('id')->first();
    }

    public function latestRoundSnapshot($gameCode): ?GameRound
    {
        $game = Game::where('game_code', $gameCode)->first();
        if (!$game) {
            return null;
        }

        return GameRound::where('game_id', $game->id)->orderByDesc('id')->first();
    }

    public function determinePhase(GameRound $round, ?Carbon $now = null): string
    {
        $now = $now ?: Carbon::now();

        if ($now->lt($round->bet_close_at)) {
            return 'betting';
        }

        if ($now->lt($round->reveal_at)) {
            return 'locked';
        }

        if ($now->lt($round->settle_at)) {
            return 'revealed';
        }

        $nextRoundAt = $this->nextRoundAt($round);
        if (!$nextRoundAt || $now->lt($nextRoundAt)) {
            return 'settled';
        }

        return 'finished';
    }

    public function syncRoundPhase(GameRound $round, ?Carbon $now = null): GameRound
    {
        $phase = $this->determinePhase($round, $now);
        if ($phase === 'finished') {
            if ($round->status !== 'finished') {
                $round->status = 'finished';
                $round->save();
            }

            return $round;
        }

        $currentStatus = (string) ($round->status ?? 'betting');
        if ($this->phaseRank($currentStatus) > $this->phaseRank($phase)) {
            $phase = $currentStatus;
        }

        if ($round->status !== $phase) {
            $round->status = $phase;
            $round->save();
        }

        return $round;
    }

    public function getState($gameCode)
    {
        $round = $this->getOrCreateOpenRound($gameCode);
        $now = Carbon::now();
        $phase = $this->determinePhase($round, $now);
        if ($phase === 'finished') {
            $round = $this->getOrCreateOpenRound($gameCode);
            $now = Carbon::now();
            $phase = $this->determinePhase($round, $now);
        }
        $round = $this->syncRoundPhase($round, $now);

        if (in_array($phase, ['revealed', 'settled'], true) && !$round->winner_board_key) {
            $round = $this->ensureResult($gameCode, $round, $phase === 'settled' ? 'settled' : 'revealed');
            if ($phase === 'settled') {
                $round->status = 'settled';
                $round->save();
            }
        }
        return $round->fresh();
    }

    public function ensureResult($gameCode, GameRound $round, ?string $statusOverride = null)
    {
        return DB::transaction(function () use ($gameCode, $round, $statusOverride) {
            $lockedRound = GameRound::where('id', $round->id)->lockForUpdate()->first();
            if (!$lockedRound) {
                throw new \RuntimeException('round_not_found');
            }

            if ($lockedRound->winner_board_key) {
                return $lockedRound;
            }

            $betsTable = config('bd_game_final.tables.bets');
            $boardRows = GameBoard::where('game_id', $lockedRound->game_id)->where('is_active', 1)->orderBy('display_order')->get();
            $cfg = $this->configService->get($gameCode);
            $boardKeys = [];
            $betMap = [];
            $payoutMap = [];
            $multiplierMap = [];
            $playersMap = [];

            foreach ($boardRows as $row) {
                $boardKeys[] = $row->canonical_key;
                $betAmount = (float) DB::table($betsTable)->where('game_round_id', $lockedRound->id)->where('canonical_board_key', $row->canonical_key)->sum('amount');
                $players = (int) DB::table($betsTable)->where('game_round_id', $lockedRound->id)->where('canonical_board_key', $row->canonical_key)->distinct('user_id')->count('user_id');
                $multiplierMap[$row->canonical_key] = (float) $row->payout_multiplier;
                $betMap[$row->canonical_key] = $betAmount;
                $playersMap[$row->canonical_key] = $players;
                $payoutMap[$row->canonical_key] = $betAmount * $multiplierMap[$row->canonical_key];
                GameBetSummary::updateOrCreate(
                    ['game_id' => $lockedRound->game_id, 'game_round_id' => $lockedRound->id, 'canonical_board_key' => $row->canonical_key],
                    ['total_amount' => $betAmount, 'total_players' => $players, 'potential_payout' => $payoutMap[$row->canonical_key]]
                );
            }

            $recentWinners = GameRound::where('game_id', $lockedRound->game_id)->whereNotNull('winner_board_key')->orderByDesc('id')->limit(max(3, (int) ($cfg['avoid_last_n_winners'] ?? 3)))->pluck('winner_board_key')->toArray();
            $policyMode = $this->currentPolicyMode($cfg);
            [$auditSeed, $auditSnapshot] = $this->fairAuditSeedForRound($gameCode, $lockedRound);
            $auditCommitment = (string) ($auditSnapshot['server_seed_commitment'] ?? '');
            $gameBalance = $this->gameBank->currentBalanceForGameId((int) $lockedRound->game_id, true);

            $decision = $this->winnerHelper->decide([
                'game_code' => $gameCode,
                'round_id' => $lockedRound->id,
                'round_no' => $lockedRound->round_no,
                'board_keys' => $boardKeys,
                'board_total_bet_map' => $betMap,
                'board_total_players_map' => $playersMap,
                'board_potential_payout_map' => $payoutMap,
                'audit_seed' => $auditSeed,
                'manual_winner_board' => null,
                'blocked_boards' => [],
                'repeat_limit' => (int) ($cfg['repeat_limit'] ?? 3),
                'last_n_winners' => $recentWinners,
                'reserve_buffer' => (float) ($cfg['reserve_buffer'] ?? 0),
                'game_balance' => $gameBalance,
                'healthy_balance_threshold' => (float) ($cfg['healthy_balance_threshold'] ?? 0),
                'weighted_random_enabled' => false,
                'weighted_random_spread' => (int) ($cfg['weighted_random_spread'] ?? 3),
                'avoid_last_n_winners' => (int) ($cfg['avoid_last_n_winners'] ?? 3),
                'force_safe_mode' => false,
                'game_policy_mode' => $policyMode,
                'audit_commitment' => $auditCommitment,
            ]);

            $rngMeta = [
                'game_policy_mode' => $policyMode,
                'audit_commitment' => $auditCommitment,
                'server_seed_commitment' => $auditCommitment,
                'server_seed' => $auditSeed,
                'pick_hash' => (string) data_get($decision, 'rng_proof.pick_hash', ''),
                'generated_at' => now()->toIso8601String(),
            ];

            if ($this->isTeenPattiFamily($gameCode)) {
                $payload = (new TeenPattiResultHelper())->build($decision['winner_board_key'], $rngMeta);
            } elseif ($this->isLucky77Family($gameCode)) {
                $payload = (new Lucky77ResultHelper())->build($decision['winner_board_key'], $rngMeta, $gameCode);
            } elseif ($this->isFruitsLoopFamily($gameCode)) {
                $payload = (new FruitsLoopResultHelper())->build($decision['winner_board_key'], $rngMeta, $gameCode);
            } else {
                $payload = (new FruitsSlotResultHelper())->build($decision['winner_board_key'], $rngMeta);
            }
            $payload['multiplier'] = (float) ($multiplierMap[$decision['winner_board_key']] ?? 1);
            $payload['rng'] = array_merge((array) ($payload['rng'] ?? []), [
                'server_seed' => $auditSeed,
                'server_seed_commitment' => $auditCommitment,
                'pick_hash' => (string) data_get($decision, 'rng_proof.pick_hash', ''),
                'pick_counter' => (int) data_get($decision, 'rng_proof.counter', 0),
                'candidate_order' => $decision['candidate_boards'] ?? [],
                'verify' => 'sha256("bdgf-fair-v2|{game_code}|{round_no}|{counter}|{candidate_order_csv}|{server_seed}")',
            ]);

            $lockedRound->winner_board_key = $decision['winner_board_key'];
            $lockedRound->decision_mode = $decision['decision_mode'];
            $existingSnapshot = is_array($lockedRound->decision_snapshot_json) ? $lockedRound->decision_snapshot_json : [];
            $lockedRound->decision_snapshot_json = array_merge($decision, [
                'audit' => [
                    'version' => 'fair_publish_v2',
                    'game_policy_mode' => $policyMode,
                    'server_seed' => $auditSeed,
                    'server_seed_commitment' => $auditCommitment,
                    'commitment_created_at' => (string) ($auditSnapshot['created_at'] ?? ''),
                    'legacy_seed' => (bool) ($auditSnapshot['legacy_seed'] ?? false),
                    'candidate_order' => $decision['candidate_boards'] ?? [],
                    'pick_hash' => (string) data_get($decision, 'rng_proof.pick_hash', ''),
                    'pick_counter' => (int) data_get($decision, 'rng_proof.counter', 0),
                    'game_balance' => $gameBalance,
                    'generated_at' => now()->toIso8601String(),
                    'audit_commitment' => $auditCommitment,
                    'rng_mode' => 'csprng',
                ],
                'precommit' => $existingSnapshot['audit'] ?? null,
            ]);
            $lockedRound->result_payload_json = $payload;
            $lockedRound->status = $statusOverride ?: 'revealed';
            $lockedRound->save();

            return $lockedRound;
        }, 3);
    }

    public function recentWinners($gameCode, $limit = 10)
    {
        $game = Game::where('game_code', $gameCode)->first();
        if (!$game) {
            return [];
        }
        return GameRound::where('game_id', $game->id)->whereNotNull('winner_board_key')->orderByDesc('id')->limit($limit)->get(['round_no', 'winner_board_key', 'decision_mode'])->toArray();
    }

    protected function buildRoundNo(string $gameCode, Carbon $now, int $attempt): string
    {
        $base = $gameCode . '_' . $now->format('YmdHisu');
        if ($attempt === 0) {
            return $base;
        }

        return $base . '_' . $attempt;
    }

    protected function isDuplicateKeyException(QueryException $e): bool
    {
        $message = strtolower((string) $e->getMessage());
        return strpos($message, 'duplicate') !== false || strpos($message, '1062') !== false;
    }

    protected function currentPolicyMode(array $cfg): string
    {
        return 'fair_publish';
    }

    protected function newFairAuditSeed(string $gameCode, string $roundNo, Carbon $createdAt): array
    {
        $seed = bin2hex(random_bytes(32));

        return [
            'version' => 'fair_publish_v2',
            'server_seed_commitment' => $this->fairSeedCommitment($gameCode, $roundNo, $seed),
            'encrypted_server_seed' => Crypt::encryptString($seed),
            'commitment_input' => 'sha256("bdgf-fair-v2|{game_code}|{round_no}|{server_seed}")',
            'created_at' => $createdAt->toIso8601String(),
            'revealed' => false,
        ];
    }

    protected function fairAuditSeedForRound(string $gameCode, GameRound $round): array
    {
        $snapshot = is_array($round->decision_snapshot_json) ? $round->decision_snapshot_json : [];
        $audit = (array) ($snapshot['audit'] ?? []);

        if (!empty($audit['encrypted_server_seed'])) {
            try {
                $seed = Crypt::decryptString((string) $audit['encrypted_server_seed']);
                $expected = $this->fairSeedCommitment($gameCode, (string) $round->round_no, $seed);
                if (hash_equals((string) ($audit['server_seed_commitment'] ?? ''), $expected)) {
                    return [$seed, $audit];
                }
            } catch (\Throwable $e) {
                // Fall through to a legacy seed so old/corrupt rounds can still finish.
            }
        }

        $seed = bin2hex(random_bytes(32));
        return [$seed, [
            'version' => 'fair_publish_v2',
            'server_seed_commitment' => $this->fairSeedCommitment($gameCode, (string) $round->round_no, $seed),
            'created_at' => now()->toIso8601String(),
            'legacy_seed' => true,
        ]];
    }

    protected function fairSeedCommitment(string $gameCode, string $roundNo, string $seed): string
    {
        return hash('sha256', implode('|', ['bdgf-fair-v2', $gameCode, $roundNo, $seed]));
    }

    protected function resultSeed(string $roundNo): int
    {
        $base = hash('sha256', $roundNo . '|' . (string) config('app.key', 'bdgf'));
        return (int) hexdec(substr($base, 0, 8));
    }

    protected function phaseRank(string $phase): int
    {
        $map = [
            'betting' => 1,
            'locked' => 2,
            'revealed' => 3,
            'settled' => 4,
            'finished' => 5,
        ];

        return $map[$phase] ?? 0;
    }

    protected function addDuration(Carbon $time, float $seconds): Carbon
    {
        return $time->addMilliseconds((int) round(max(0, $seconds) * 1000));
    }
}

