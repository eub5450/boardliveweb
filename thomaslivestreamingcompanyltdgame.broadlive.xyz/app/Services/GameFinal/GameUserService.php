<?php

namespace App\Services\GameFinal;

use App\Models\GameFinal\Game;
use App\Models\GameFinal\GameSecurityBlock;
use App\Models\User;
use Illuminate\Http\Request;

class GameUserService
{
    public function resolveAuthOrApiTokenUser(Request $request)
    {
        if (auth()->check()) {
            return auth()->user();
        }

        $apiToken = $request->header('X-Api-Token')
            ?: $request->get('api_token')
            ?: $request->post('api_token');

        if (!$apiToken || !config('bd_game_final.allow_api_token_issue_entry', true)) {
            return null;
        }

        $column = (string) config('bd_game_final.api_token_column', 'api_token');
        return User::where($column, $apiToken)->first();
    }

    public function canPlay(User $user, ?string $gameCode = null)
    {
        $rules = config('bd_game_final.user_rules', []);
        $gameId = $this->gameIdForCode($gameCode);

        try {
            $securityBlock = GameSecurityBlock::query()
                ->where('user_id', $user->id)
                ->where('status', 'active')
                ->where(function ($query) {
                    $query->whereNull('lifted_at')
                        ->orWhere('lifted_at', '>', now());
                })
                ->where(function ($query) use ($gameId) {
                    $query->whereNull('game_id');
                    if ($gameId) {
                        $query->orWhere('game_id', $gameId);
                    }
                })
                ->orderByDesc('id')
                ->first();
        } catch (\Throwable $e) {
            $securityBlock = null;
        }

        if ($securityBlock) {
            $blockReason = trim((string) $securityBlock->reason) ?: 'Account access was locked by JAMBOai security.';

            return [
                'ok' => false,
                'reason' => 'blocked_by_jamboai',
                'block_reason' => $blockReason,
                'message' => 'You have been blocked by JAMBOai for reason "' . $blockReason . '".',
            ];
        }

        if (!empty($rules['block_if_lock_brd_entry']) && (int) ($user->lock_brd_entry ?? 0) === 1) {
            $blockReason = 'Board entry locked for this user.';

            return [
                'ok' => false,
                'reason' => 'game_locked_for_user',
                'block_reason' => $blockReason,
                'message' => $blockReason,
            ];
        }
        if (!empty($rules['block_if_banned']) && method_exists($user, 'isBanned') && $user->isBanned()) {
            return ['ok' => false, 'reason' => 'user_banned'];
        }
        if (!empty($rules['block_if_device_banned']) && method_exists($user, 'isDeviceBanned') && $user->isDeviceBanned()) {
            return ['ok' => false, 'reason' => 'device_banned'];
        }
        if (!empty($rules['require_active_status'])) {
            $allowed = (array) ($rules['active_status_values'] ?? [1, '1', 'active']);
            if (!in_array($user->status ?? null, $allowed, true)) {
                return ['ok' => false, 'reason' => 'inactive_user'];
            }
        }
        return ['ok' => true, 'reason' => null];
    }

    public function resolvePlayableUser(Request $request, ?string $gameCode = null)
    {
        $user = $this->resolveAuthOrApiTokenUser($request);
        if (!$user) {
            return [null, 'user_required'];
        }
        $check = $this->canPlay($user, $gameCode);
        if (!$check['ok']) {
            return [null, $check['reason']];
        }
        return [$user, null];
    }

    protected function gameIdForCode(?string $gameCode): ?int
    {
        $gameCode = trim((string) $gameCode);
        if ($gameCode === '') {
            return null;
        }

        try {
            $id = Game::query()->where('game_code', $gameCode)->value('id');
            return $id ? (int) $id : null;
        } catch (\Throwable $e) {
            return null;
        }
    }

}
