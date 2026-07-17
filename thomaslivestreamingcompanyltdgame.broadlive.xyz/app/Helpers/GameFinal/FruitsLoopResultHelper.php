<?php

namespace App\Helpers\GameFinal;

use App\Support\GameFinal\BoardMapper;

class FruitsLoopResultHelper
{
    public function build($winnerBoard, $rngMeta = null, string $gameCode = 'fruits_loop'): array
    {
        $winnerBoard = BoardMapper::normalize($gameCode, $winnerBoard);
        $nonce = bin2hex(random_bytes(16));
        $wheelSequence = array_values(array_filter(array_map(
            static fn ($value) => BoardMapper::normalize($gameCode, $value),
            (array) config('bd_game_final.games.' . $gameCode . '.wheel_order', [])
        )));
        if (!$wheelSequence) {
            $canonicalBoards = array_values(array_filter(BoardMapper::allCanonical($gameCode)));
            foreach (range(1, 2) as $unusedLoop) {
                foreach ($canonicalBoards as $canonicalBoard) {
                    $wheelSequence[] = $canonicalBoard;
                }
            }
        }

        $uniqueCycle = [];
        foreach ($wheelSequence as $wheelKey) {
            if (!array_key_exists($wheelKey, $uniqueCycle)) {
                $uniqueCycle[$wheelKey] = count($uniqueCycle);
            }
        }

        return [
            'winner_board' => $winnerBoard,
            'wheel_sequence' => $wheelSequence,
            'board_cycle' => $uniqueCycle,
            'multiplier' => BoardMapper::multiplier($gameCode, $winnerBoard),
            'spin_seed' => random_int(100000, 999999999),
            'rng' => [
                'mode' => 'csprng',
                'nonce' => $nonce,
                'nonce_hash' => hash('sha256', $nonce),
                'meta_commit' => isset($rngMeta['audit_commitment']) ? (string) $rngMeta['audit_commitment'] : null,
            ],
        ];
    }
}
