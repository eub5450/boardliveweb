<?php

namespace App\Helpers\GameFinal;

class Lucky77ResultHelper
{
    public function build($winnerBoard, $rngMeta = null, string $gameCode = ''): array
    {
        $nonce = bin2hex(random_bytes(16));
        $slotMark = $gameCode === 'lucky88_master' ? '88' : '77';

        return [
            'winner_board' => $winnerBoard,
            'landing_key' => $winnerBoard,
            'recent_mark' => $winnerBoard === 'slot' ? $slotMark : ($winnerBoard === 'melon' ? 'MELON' : 'PLUM'),
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
