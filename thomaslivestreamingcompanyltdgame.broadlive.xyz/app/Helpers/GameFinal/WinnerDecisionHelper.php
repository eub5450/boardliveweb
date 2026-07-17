<?php

namespace App\Helpers\GameFinal;

class WinnerDecisionHelper
{
    public function decide(array $payload): array
    {
        $boards = array_values(array_filter((array) ($payload['board_keys'] ?? [])));
        $blocked = array_values(array_unique((array) ($payload['blocked_boards'] ?? [])));
        $policyMode = 'fair_publish';

        $candidates = array_values(array_filter($boards, function ($board) use ($blocked) {
            return !in_array($board, $blocked, true);
        }));

        if (empty($candidates)) {
            $candidates = $boards;
        }

        if (empty($candidates)) {
            throw new \RuntimeException('no_board_candidates');
        }

        $betMap = (array) ($payload['board_total_bet_map'] ?? []);
        $payoutMap = (array) ($payload['board_potential_payout_map'] ?? []);
        $playersMap = (array) ($payload['board_total_players_map'] ?? []);
        $liabilityMap = [];
        $houseNetMap = [];
        $totalBetAll = 0.0;

        foreach ($boards as $board) {
            $totalBetAll += (float) ($betMap[$board] ?? 0);
        }

        foreach ($boards as $board) {
            $payout = (float) ($payoutMap[$board] ?? 0);
            $liabilityMap[$board] = $payout;
            $houseNetMap[$board] = $totalBetAll - $payout;
            $playersMap[$board] = (int) ($playersMap[$board] ?? 0);
        }

        $gameBalance = max(0, (float) ($payload['game_balance'] ?? 0));
        $healthyBalanceThreshold = max(0, (float) ($payload['healthy_balance_threshold'] ?? 0));
        $reserveSafeCandidates = array_values(array_filter($candidates, function ($board) use ($liabilityMap, $gameBalance, $healthyBalanceThreshold) {
            return ($gameBalance - (float) ($liabilityMap[$board] ?? 0)) >= $healthyBalanceThreshold;
        }));
        $affordableCandidates = array_values(array_filter($candidates, function ($board) use ($liabilityMap, $gameBalance) {
            return (float) ($liabilityMap[$board] ?? 0) <= $gameBalance;
        }));

        $candidatePool = $reserveSafeCandidates ?: $affordableCandidates;
        $decisionReason = 'committed_csprng_uniform_selection';

        if ($candidatePool) {
            $decisionReason = 'committed_csprng_uniform_selection_with_game_balance_guard';
            [$winner, $rngProof] = $this->pickUniformRandom($candidatePool, [
                'game_code' => (string) ($payload['game_code'] ?? ''),
                'round_no' => (string) ($payload['round_no'] ?? ''),
                'audit_seed' => (string) ($payload['audit_seed'] ?? ''),
            ]);
        } else {
            $fallbackBoards = $candidates ?: $boards;
            usort($fallbackBoards, function ($left, $right) use ($liabilityMap, $playersMap, $betMap) {
                $liabilityCompare = ((float) ($liabilityMap[$left] ?? 0)) <=> ((float) ($liabilityMap[$right] ?? 0));
                if ($liabilityCompare !== 0) {
                    return $liabilityCompare;
                }

                $playerCompare = ((int) ($playersMap[$left] ?? 0)) <=> ((int) ($playersMap[$right] ?? 0));
                if ($playerCompare !== 0) {
                    return $playerCompare;
                }

                $betCompare = ((float) ($betMap[$left] ?? 0)) <=> ((float) ($betMap[$right] ?? 0));
                if ($betCompare !== 0) {
                    return $betCompare;
                }

                return strcmp((string) $left, (string) $right);
            });

            $winner = $fallbackBoards[0];
            $rngProof = [
                'algorithm' => 'smallest_liability_fallback',
                'candidate_count' => count($fallbackBoards),
                'candidate_order' => $fallbackBoards,
                'counter' => 0,
                'pick_hash' => null,
                'pick_index' => 0,
            ];
            $decisionReason = 'forced_smallest_liability_due_to_game_balance';
        }

        return [
            'winner_board_key' => $winner,
            'decision_mode' => 'fair_publish_random',
            'decision_reason' => $decisionReason,
            'candidate_boards' => $candidatePool ?: ($candidates ?: $boards),
            'rng_proof' => $rngProof,
            'bet_total_map' => $betMap,
            'liability_map' => $liabilityMap,
            'house_net_map' => $houseNetMap,
            'player_count_map' => $playersMap,
            'selected_board_payout' => array_key_exists($winner, $liabilityMap) ? (float) $liabilityMap[$winner] : null,
            'selected_board_house_net' => array_key_exists($winner, $houseNetMap) ? (float) $houseNetMap[$winner] : null,
            'total_bet_amount' => $totalBetAll,
            'debug_snapshot' => [
                'game_policy_mode' => $policyMode,
                'candidate_count' => count($candidatePool ?: ($candidates ?: $boards)),
                'blocked_boards' => $blocked,
                'audit_commitment' => (string) ($payload['audit_commitment'] ?? ''),
                'game_balance' => $gameBalance,
                'healthy_balance_threshold' => $healthyBalanceThreshold,
                'reserve_safe_candidates' => $reserveSafeCandidates,
                'affordable_candidates' => $affordableCandidates,
            ],
        ];
    }

    protected function pickUniformRandom(array $candidates, array $audit): array
    {
        if (count($candidates) === 1) {
            return [$candidates[0], [
                'algorithm' => 'single_candidate',
                'candidate_count' => 1,
                'counter' => 0,
                'pick_hash' => null,
                'pick_index' => 0,
            ]];
        }

        $seed = (string) ($audit['audit_seed'] ?? '');
        if ($seed === '') {
            $seed = bin2hex(random_bytes(32));
        }

        $candidateOrder = implode(',', $candidates);
        $candidateCount = count($candidates);
        $bucketSize = intdiv(0x1000000000000, $candidateCount);
        $usableMax = $bucketSize * $candidateCount;
        $counter = 0;

        do {
            $input = implode('|', [
                'bdgf-fair-v2',
                (string) ($audit['game_code'] ?? ''),
                (string) ($audit['round_no'] ?? ''),
                (string) $counter,
                $candidateOrder,
                $seed,
            ]);
            $hash = hash('sha256', $input);
            $value = hexdec(substr($hash, 0, 12));
            $counter++;
        } while ($value >= $usableMax && $counter < 100);

        if ($value >= $usableMax) {
            $value = $value % $usableMax;
        }

        $index = intdiv($value, $bucketSize);

        return [$candidates[$index], [
            'algorithm' => 'sha256_rejection_48bit',
            'candidate_count' => $candidateCount,
            'candidate_order' => $candidates,
            'counter' => $counter - 1,
            'pick_hash' => $hash,
            'pick_index' => $index,
        ]];
    }
}
