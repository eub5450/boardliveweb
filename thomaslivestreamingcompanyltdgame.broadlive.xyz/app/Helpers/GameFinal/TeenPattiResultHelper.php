<?php

namespace App\Helpers\GameFinal;

class TeenPattiResultHelper
{
    public function build($winnerBoard, $rngMeta = null): array
    {
        $nonce = bin2hex(random_bytes(16));
        $hands = $this->handsForWinner((string) $winnerBoard);

        return [
            'winner_board' => $winnerBoard,
            'cards' => [
                'A' => $hands['A'],
                'B' => $hands['B'],
                'C' => $hands['C'],
            ],
            'rng' => [
                'mode' => 'csprng',
                'nonce' => $nonce,
                'nonce_hash' => hash('sha256', $nonce),
                'meta_commit' => isset($rngMeta['audit_commitment']) ? (string) $rngMeta['audit_commitment'] : null,
            ],
        ];
    }

    protected function handsForWinner(string $winnerBoard): array
    {
        $presets = [
            'A' => [
                'A' => ['cards' => ['AS', 'AH', 'AD'], 'label' => 'Trail'],
                'B' => ['cards' => ['KS', 'KH', 'QC'], 'label' => 'Pair'],
                'C' => ['cards' => ['JS', '10D', '8C'], 'label' => 'High Card'],
            ],
            'B' => [
                'A' => ['cards' => ['QS', 'QH', 'JC'], 'label' => 'Pair'],
                'B' => ['cards' => ['KS', 'KH', 'KD'], 'label' => 'Trail'],
                'C' => ['cards' => ['10S', '9D', '7C'], 'label' => 'High Card'],
            ],
            'C' => [
                'A' => ['cards' => ['JS', 'JH', '9C'], 'label' => 'Pair'],
                'B' => ['cards' => ['10S', '8D', '6C'], 'label' => 'High Card'],
                'C' => ['cards' => ['QS', 'QH', 'QD'], 'label' => 'Trail'],
            ],
        ];

        if (!isset($presets[$winnerBoard])) {
            throw new \InvalidArgumentException('invalid_teen_patti_winner_board');
        }

        return $presets[$winnerBoard];
    }
}
