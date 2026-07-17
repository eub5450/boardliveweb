<?php

namespace App\Helpers\GameFinal;

use App\Support\GameFinal\BoardMapper;

class FruitsSlotResultHelper
{
    public function build($winnerBoard, $rngMeta = null): array
    {
        $nonce = bin2hex(random_bytes(16));

        return [
            'winner_board' => $winnerBoard,
            'multiplier' => BoardMapper::multiplier('fruit_slot', $winnerBoard),
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
