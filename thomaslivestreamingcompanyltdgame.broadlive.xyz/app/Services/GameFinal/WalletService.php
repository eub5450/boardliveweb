<?php

namespace App\Services\GameFinal;

use App\Models\User;
use App\Models\GameFinal\GameWalletJournal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class WalletService
{
    protected $walletColumn;

    public function __construct()
    {
        $this->walletColumn = (string) config('bd_game_final.wallet_column', 'balance');
    }

    public function currentBalance(User $user)
    {
        $this->assertWalletColumn($user);

        return (float) $user->{$this->walletColumn};
    }

    public function debit(User $user, $amount, array $context = [])
    {
        return $this->mutateBalance($user, 'debit', $amount, $context);
    }

    public function credit(User $user, $amount, array $context = [])
    {
        return $this->mutateBalance($user, 'credit', $amount, $context);
    }

    protected function mutateBalance(User $user, string $direction, $amount, array $context = []): array
    {
        $amount = (float) $amount;
        if (!is_finite($amount) || $amount <= 0) {
            $balance = $this->currentBalance($user);
            return ['ok' => false, 'before' => $balance, 'after' => $balance];
        }

        return DB::transaction(function () use ($user, $direction, $amount, $context) {
            $lockedUser = User::where('id', $user->id)->lockForUpdate()->first();
            if (!$lockedUser) {
                return ['ok' => false, 'before' => 0.0, 'after' => 0.0];
            }

            $this->assertWalletColumn($lockedUser);
            $referenceUid = $this->normalizeReferenceUid($context['reference_uid'] ?? null);

            if ($referenceUid && $this->hasReferenceUidColumn()) {
                $existing = GameWalletJournal::query()
                    ->where('reference_uid', $referenceUid)
                    ->where('user_id', $lockedUser->id)
                    ->where('direction', $direction)
                    ->lockForUpdate()
                    ->first();

                if ($existing) {
                    return [
                        'ok' => true,
                        'before' => (float) $existing->balance_before,
                        'after' => (float) $existing->balance_after,
                        'idempotent' => true,
                    ];
                }
            }

            $before = (float) $lockedUser->{$this->walletColumn};
            if ($direction === 'debit' && $before < $amount) {
                return ['ok' => false, 'before' => $before, 'after' => $before];
            }

            $after = $direction === 'debit'
                ? ($before - $amount)
                : ($before + $amount);

            if (!is_finite($after) || $after < 0) {
                return ['ok' => false, 'before' => $before, 'after' => $before];
            }

            $lockedUser->{$this->walletColumn} = $after;
            $lockedUser->save();

            $this->journal($lockedUser, $direction, $amount, $before, $after, $context, $referenceUid);

            return ['ok' => true, 'before' => $before, 'after' => $after];
        }, 3);
    }

    protected function journal(User $user, $direction, $amount, $before, $after, array $context = [], ?string $referenceUid = null)
    {
        $payload = [
            'game_id' => $context['game_id'] ?? null,
            'game_round_id' => $context['game_round_id'] ?? null,
            'game_bet_id' => $context['game_bet_id'] ?? null,
            'game_settlement_id' => $context['game_settlement_id'] ?? null,
            'game_settlement_item_id' => $context['game_settlement_item_id'] ?? null,
            'user_id' => $user->id,
            'direction' => $direction,
            'amount' => (float) $amount,
            'balance_before' => (float) $before,
            'balance_after' => (float) $after,
            'reason' => $context['reason'] ?? null,
            'meta_json' => $context['meta_json'] ?? null,
        ];

        if ($referenceUid && $this->hasReferenceUidColumn()) {
            $payload['reference_uid'] = $referenceUid;
        }

        GameWalletJournal::create($payload);
    }

    protected function normalizeReferenceUid($value): ?string
    {
        if (!is_string($value)) {
            return null;
        }

        $trimmed = trim($value);
        if ($trimmed === '') {
            return null;
        }

        return substr($trimmed, 0, 120);
    }

    protected function hasReferenceUidColumn(): bool
    {
        static $hasColumn = null;
        if ($hasColumn !== null) {
            return $hasColumn;
        }

        try {
            $hasColumn = Schema::hasColumn('bd_game_final_wallet_journals', 'reference_uid');
        } catch (\Throwable $e) {
            $hasColumn = false;
        }

        return $hasColumn;
    }

    protected function assertWalletColumn(User $user): void
    {
        if (!array_key_exists($this->walletColumn, $user->getAttributes()) && !$user->offsetExists($this->walletColumn)) {
            throw new \RuntimeException('wallet_column_missing');
        }
    }
}
