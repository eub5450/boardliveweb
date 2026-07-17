<?php

namespace App\Services\GameFinal;

use App\Models\GameFinal\Game;
use App\Models\GameFinal\GameSetting;
use Illuminate\Support\Facades\DB;

class GameBankService
{
    public function currentBalanceForGameId(int $gameId, bool $lockForUpdate = false): float
    {
        if ($this->usesSharedBank()) {
            return $this->sharedBalance($lockForUpdate, $gameId);
        }

        $query = GameSetting::query()->where('game_id', $gameId);

        if ($lockForUpdate) {
            $query->lockForUpdate();
        }

        return (float) ($query->value('decision_balance_amount') ?? 0);
    }

    public function credit($game, $amount): array
    {
        return $this->mutate($this->resolveGameId($game), 'credit', $amount);
    }

    public function debit($game, $amount): array
    {
        return $this->mutate($this->resolveGameId($game), 'debit', $amount);
    }

    protected function mutate(?int $gameId, string $direction, $amount): array
    {
        $amount = round((float) $amount, 2);
        if (!$gameId || !is_finite($amount) || $amount <= 0) {
            return ['ok' => false, 'before' => 0.0, 'after' => 0.0];
        }

        if ($this->usesSharedBank()) {
            return DB::transaction(function () use ($gameId, $direction, $amount) {
                $setting = $this->sharedAnchorSetting(true, $gameId);
                $before = (float) ($setting->decision_balance_amount ?? 0);

                if ($direction === 'debit' && $before < $amount) {
                    return ['ok' => false, 'before' => $before, 'after' => $before];
                }

                $after = $direction === 'credit'
                    ? ($before + $amount)
                    : ($before - $amount);

                if (!is_finite($after) || $after < 0) {
                    return ['ok' => false, 'before' => $before, 'after' => $before];
                }

                $this->syncSharedBalance($after);

                return ['ok' => true, 'before' => $before, 'after' => $after];
            }, 3);
        }

        return DB::transaction(function () use ($gameId, $direction, $amount) {
            $setting = $this->lockOrCreateSetting($gameId);
            $before = (float) ($setting->decision_balance_amount ?? 0);

            if ($direction === 'debit' && $before < $amount) {
                return ['ok' => false, 'before' => $before, 'after' => $before];
            }

            $after = $direction === 'credit'
                ? ($before + $amount)
                : ($before - $amount);

            if (!is_finite($after) || $after < 0) {
                return ['ok' => false, 'before' => $before, 'after' => $before];
            }

            $setting->decision_balance_amount = $after;
            $setting->save();

            return ['ok' => true, 'before' => $before, 'after' => $after];
        }, 3);
    }

    protected function lockOrCreateSetting(int $gameId): GameSetting
    {
        $setting = GameSetting::query()
            ->where('game_id', $gameId)
            ->lockForUpdate()
            ->first();

        if ($setting) {
            return $setting;
        }

        $game = Game::query()->findOrFail($gameId);

        GameSetting::query()->create([
            'game_id' => $gameId,
            'max_distinct_boards_per_user' => 1,
            'game_status' => $game->is_active ? 'active' : 'inactive',
            'decision_balance_amount' => 0,
        ]);

        return GameSetting::query()
            ->where('game_id', $gameId)
            ->lockForUpdate()
            ->firstOrFail();
    }

    protected function resolveGameId($game): ?int
    {
        if ($game instanceof Game) {
            return (int) $game->id;
        }

        if (is_numeric($game)) {
            return (int) $game;
        }

        return null;
    }

    protected function usesSharedBank(): bool
    {
        return (bool) config('bd_game_final.shared_game_balance', true);
    }

    protected function sharedBalance(bool $lockForUpdate = false, ?int $preferredGameId = null): float
    {
        $setting = $this->sharedAnchorSetting($lockForUpdate, $preferredGameId);

        return (float) ($setting->decision_balance_amount ?? 0);
    }

    protected function sharedAnchorSetting(bool $lockForUpdate = false, ?int $preferredGameId = null): GameSetting
    {
        if ($preferredGameId) {
            $this->lockOrCreateSetting($preferredGameId);
        }

        $query = GameSetting::query()->orderBy('game_id');

        if ($lockForUpdate) {
            $query->lockForUpdate();
        }

        $setting = $query->first();
        if ($setting) {
            return $setting;
        }

        $seedGameId = $preferredGameId ?: (int) (Game::query()->orderBy('id')->value('id') ?? 0);
        if ($seedGameId <= 0) {
            throw new \RuntimeException('shared_game_bank_seed_missing');
        }

        $this->lockOrCreateSetting($seedGameId);

        $query = GameSetting::query()->orderBy('game_id');
        if ($lockForUpdate) {
            $query->lockForUpdate();
        }

        return $query->firstOrFail();
    }

    protected function syncSharedBalance(float $balance): void
    {
        GameSetting::query()->update([
            'decision_balance_amount' => $balance,
            'updated_at' => now(),
        ]);
    }
}
