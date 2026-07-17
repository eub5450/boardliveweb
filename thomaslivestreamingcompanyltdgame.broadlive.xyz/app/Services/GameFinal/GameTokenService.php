<?php

namespace App\Services\GameFinal;

use App\Models\GameFinal\Game;
use App\Models\GameFinal\GameAccessToken;
use App\Models\GameFinal\GameSecurityBlock;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GameTokenService
{
    protected function activeGame(string $gameCode): Game
    {
        return Game::query()
            ->where('game_code', $gameCode)
            ->where('is_active', 1)
            ->firstOrFail();
    }

    protected function findActiveGame(string $gameCode): ?Game
    {
        return Game::query()
            ->where('game_code', $gameCode)
            ->where('is_active', 1)
            ->first();
    }

    protected function plainToken(?array $issued): ?string
    {
        if (empty($issued['plain_token']) || !is_string($issued['plain_token'])) {
            return null;
        }

        return $issued['plain_token'];
    }

    public function clientCookieName(): string
    {
        return (string) config('bd_game_final.security.client_cookie_name', 'bdgf_client');
    }

    public function clientKeyFromRequest(Request $request): ?string
    {
        $cookie = trim((string) $request->cookie($this->clientCookieName(), ''));
        return $cookie !== '' ? substr($cookie, 0, 120) : null;
    }

    public function fingerprintFromRequest(Request $request): string
    {
        return (string) $this->requestFingerprint(
            $request->ip(),
            $request->userAgent(),
            $this->clientKeyFromRequest($request)
        );
    }

    protected function requestFingerprint(?string $ipAddress, ?string $userAgent, ?string $clientKey = null): ?string
    {
        if ($ipAddress === null && $userAgent === null && $clientKey === null) {
            return null;
        }

        return substr(sha1((string) $userAgent . '|' . (string) $ipAddress . '|' . (string) $clientKey), 0, 40);
    }

    protected function fingerprintMatches(
        ?string $storedFingerprint,
        ?string $ipAddress,
        ?string $userAgent,
        ?string $clientKey = null,
        ?string $explicitFingerprint = null
    ): bool
    {
        $stored = trim((string) $storedFingerprint);
        if ($stored === '') {
            return true;
        }

        $current = trim((string) $explicitFingerprint);
        if ($current === '') {
            $current = (string) $this->requestFingerprint($ipAddress, $userAgent, $clientKey);
        }
        if (!$current) {
            return true;
        }

        return hash_equals($stored, $current);
    }

    protected function conflictingActiveSession(string $gameCode, int $userId, ?string $deviceFingerprint = null): ?GameAccessToken
    {
        $game = $this->findActiveGame($gameCode);
        if (!$game) {
            return null;
        }

        $activeSessions = GameAccessToken::query()
            ->where('game_id', $game->id)
            ->where('user_id', $userId)
            ->where('token_type', 'session')
            ->whereNull('revoked_at')
            ->where('expires_at', '>', now())
            ->orderByDesc('id')
            ->get();

        if ($activeSessions->isEmpty()) {
            return null;
        }

        $incomingFingerprint = trim((string) $deviceFingerprint);
        foreach ($activeSessions as $session) {
            $storedFingerprint = trim((string) $session->device_fingerprint);
            if ($incomingFingerprint !== '' && $storedFingerprint !== '' && hash_equals($storedFingerprint, $incomingFingerprint)) {
                continue;
            }

            return $session;
        }

        return null;
    }

    public function issueEntryToken(
        string $gameCode,
        int $userId,
        ?string $deviceFingerprint = null,
        array $meta = []
    ): array {
        return $this->issueToken(
            $gameCode,
            $userId,
            'entry',
            (int) config('bd_game_final.entry_token_ttl_seconds', 90),
            null,
            $deviceFingerprint,
            $meta
        );
    }

    public function issueSessionToken(
        string $gameCode,
        int $userId,
        ?int $parentTokenId = null,
        ?string $deviceFingerprint = null,
        array $meta = []
    ): array {
        return $this->issueToken(
            $gameCode,
            $userId,
            'session',
            (int) config('bd_game_final.session_ttl_seconds', 18000),
            $parentTokenId,
            $deviceFingerprint,
            $meta
        );
    }

    public function issueToken(
        string $gameCode,
        int $userId,
        string $tokenType = 'entry',
        int $ttlSeconds = 90,
        ?int $parentTokenId = null,
        ?string $deviceFingerprint = null,
        array $meta = []
    ): array {
        $this->cleanupExpiredTokens();

        $game = $this->activeGame($gameCode);

        $plainToken = Str::random(64);
        $now = Carbon::now();

        $safeMeta = is_array($meta) ? $meta : [];
        $safeFingerprint = (is_string($deviceFingerprint) && $deviceFingerprint !== '')
            ? substr($deviceFingerprint, 0, 64)
            : null;

        if ($tokenType === 'entry' && !empty(config('bd_game_final.security.single_active_entry_token_per_user', true))) {
            GameAccessToken::query()
                ->where('game_id', $game->id)
                ->where('user_id', $userId)
                ->where('token_type', 'entry')
                ->whereNull('revoked_at')
                ->where('expires_at', '>', $now)
                ->update(['revoked_at' => $now]);
        }

        if ($tokenType === 'session' && !empty(config('bd_game_final.security.single_active_session_per_user', true))) {
            $conflict = $this->conflictingActiveSession($gameCode, $userId, $safeFingerprint);
            if ($conflict) {
                throw new \RuntimeException('This account is already active on another device or browser.');
            }

            GameAccessToken::query()
                ->where('user_id', $userId)
                ->where('token_type', 'session')
                ->whereNull('revoked_at')
                ->where('expires_at', '>', $now)
                ->update(['revoked_at' => $now]);
        }

        $row = GameAccessToken::create([
            'game_id'            => $game->id,
            'user_id'            => $userId,
            'token_hash'         => sha1($plainToken),
            'token_type'         => $tokenType,
            'parent_token_id'    => $parentTokenId,
            'device_fingerprint' => $safeFingerprint,
            'meta_json'          => $safeMeta,
            'issued_at'          => $now,
            'last_seen_at'       => $now,
            'expires_at'         => $now->copy()->addSeconds($ttlSeconds),
        ]);

        return [
            'id'          => $row->id,
            'plain_token' => $plainToken,
            'hash'        => $row->token_hash,
            'type'        => $row->token_type,
            'game_id'     => $row->game_id,
            'user_id'     => $row->user_id,
            'expires_at'  => optional($row->expires_at)->toDateTimeString(),
        ];
    }

    public function findValidToken(string $plainToken, string $type = 'entry'): ?GameAccessToken
    {
        $this->cleanupExpiredTokens();
        $hash = sha1($plainToken);

        return GameAccessToken::where('token_hash', $hash)
            ->where('token_type', $type)
            ->whereNull('revoked_at')
            ->where('expires_at', '>', now())
            ->first();
    }

    public function findValidEntryToken(string $plainToken): ?GameAccessToken
    {
        return $this->findValidToken($plainToken, 'entry');
    }

    public function findValidSessionToken(string $plainToken): ?GameAccessToken
    {
        return $this->findValidToken($plainToken, 'session');
    }

    public function resolveSessionUser(
        string $sessionPlainToken,
        ?string $gameCode = null,
        ?string $ipAddress = null,
        ?string $userAgent = null,
        ?string $clientKey = null,
        ?string $deviceFingerprint = null
    ): ?User {
        $status = $this->sessionTokenStatus($sessionPlainToken, $gameCode, $ipAddress, $userAgent, $clientKey, $deviceFingerprint);
        return !empty($status['ok']) ? $status['user'] : null;
    }

    public function exchangeEntryToSession(
        string $gameCode,
        string $entryPlainToken,
        ?string $deviceFingerprint = null,
        ?string $ipAddress = null,
        ?string $userAgent = null,
        array $meta = [],
        ?string $clientKey = null
    ): array {
        return DB::transaction(function () use ($gameCode, $entryPlainToken, $deviceFingerprint, $ipAddress, $userAgent, $meta, $clientKey) {
            $entry = GameAccessToken::where('token_hash', sha1($entryPlainToken))
                ->where('token_type', 'entry')
                ->whereNull('revoked_at')
                ->where('expires_at', '>', now())
                ->lockForUpdate()
                ->first();

            if (!$entry) {
                throw new \RuntimeException('Invalid or expired entry token.');
            }

            $game = $this->activeGame($gameCode);

            if ((int) $entry->game_id !== (int) $game->id) {
                throw new \RuntimeException('Entry token does not belong to this game.');
            }

            if (!$this->fingerprintMatches($entry->device_fingerprint, $ipAddress, $userAgent, $clientKey, $deviceFingerprint)) {
                throw new \RuntimeException('Entry token device mismatch.');
            }

            if ($entry->revoked_at || ($entry->expires_at && $entry->expires_at->lte(now()))) {
                throw new \RuntimeException('Invalid or expired entry token.');
            }

            $user = User::find($entry->user_id);

            if (!$user) {
                throw new \RuntimeException('User not found.');
            }

            if (method_exists($user, 'isBanned') && $user->isBanned()) {
                throw new \RuntimeException('User is banned.');
            }

            if (method_exists($user, 'isDeviceBanned') && $user->isDeviceBanned()) {
                throw new \RuntimeException('User device is banned.');
            }

            if (isset($user->lock_brd_entry) && (int) $user->lock_brd_entry === 1) {
                throw new \RuntimeException('Board entry locked for this user.');
            }

            $entryMeta = [];
            if (!empty($entry->meta_json)) {
                if (is_array($entry->meta_json)) {
                    $entryMeta = $entry->meta_json;
                } elseif (is_string($entry->meta_json)) {
                    $decoded = json_decode($entry->meta_json, true);
                    $entryMeta = is_array($decoded) ? $decoded : [];
                }
            }

            $sessionMeta = array_merge(
                $entryMeta,
                array_filter([
                    'issued_ip' => $ipAddress,
                    'issued_user_agent' => $userAgent ? substr($userAgent, 0, 255) : null,
                ]),
                is_array($meta) ? $meta : [],
                ['entry_token_id' => $entry->id]
            );

            $session = $this->issueSessionToken(
                $gameCode,
                (int) $entry->user_id,
                (int) $entry->id,
                $deviceFingerprint,
                $sessionMeta
            );

            $entry->revoked_at = now();
            $entry->save();

            return [
                'entry_token_id' => (int) $entry->id,
                'session'        => $session,
                'session_token'  => $this->plainToken($session),
                'user_id'        => (int) $entry->user_id,
                'game_id'        => (int) $entry->game_id,
            ];
        }, 3);
    }

    public function validateSessionToken(string $gameCode, string $sessionPlainToken): ?GameAccessToken
    {
        $session = $this->findValidSessionToken($sessionPlainToken);

        if (!$session) {
            return null;
        }

        $game = $this->findActiveGame($gameCode);

        if (!$game) {
            return null;
        }

        if ((int) $session->game_id !== (int) $game->id) {
            return null;
        }

        return $session;
    }

    public function sessionTokenStatus(
        string $sessionPlainToken,
        ?string $gameCode = null,
        ?string $ipAddress = null,
        ?string $userAgent = null,
        ?string $clientKey = null,
        ?string $deviceFingerprint = null
    ): array {
        $session = $gameCode
            ? $this->validateSessionToken($gameCode, $sessionPlainToken)
            : $this->findValidSessionToken($sessionPlainToken);

        if (!$session) {
            return $this->tokenFailure('invalid_session', 'Invalid game session.');
        }

        $user = User::find($session->user_id);
        if (!$user) {
            return $this->tokenFailure('invalid_session', 'Game user was not found.');
        }

        if (method_exists($user, 'isBanned') && $user->isBanned()) {
            return $this->tokenFailure('user_banned', 'User is banned.');
        }

        if (method_exists($user, 'isDeviceBanned') && $user->isDeviceBanned()) {
            return $this->tokenFailure('device_banned', 'User device is banned.');
        }

        $block = $this->activeSecurityBlockForUser((int) $user->id, $gameCode);
        if ($block) {
            return $this->tokenFailure(
                'blocked_by_jamboai',
                'You have been blocked by JAMBOai.',
                trim((string) $block->reason) ?: 'Account access was locked by JAMBOai security.'
            );
        }

        if (isset($user->lock_brd_entry) && (int) $user->lock_brd_entry === 1) {
            return $this->tokenFailure('game_locked_for_user', 'Board entry locked for this user.');
        }

        if (!$this->fingerprintMatches($session->device_fingerprint, $ipAddress, $userAgent, $clientKey, $deviceFingerprint)) {
            return $this->tokenFailure('duplicate_device', 'This account is already active on another device or browser.');
        }

        $meta = $this->tokenMeta($session);
        if ($ipAddress) {
            $meta['last_ip'] = $ipAddress;
        }
        if ($userAgent) {
            $meta['last_user_agent'] = substr($userAgent, 0, 255);
        }

        $session->last_seen_at = now();
        $session->meta_json = $meta;
        $session->save();

        return [
            'ok' => true,
            'code' => 'ok',
            'message' => 'Session is valid.',
            'user' => $user,
            'session' => $session,
        ];
    }

    public function touchToken(int $tokenId): void
    {
        GameAccessToken::where('id', $tokenId)->update([
            'last_seen_at' => now(),
        ]);
    }

    public function revokeTokenById(int $tokenId): void
    {
        GameAccessToken::where('id', $tokenId)->update([
            'revoked_at' => now(),
        ]);
    }

    public function revokeByParentTokenId(int $parentTokenId): void
    {
        GameAccessToken::where('parent_token_id', $parentTokenId)
            ->whereNull('revoked_at')
            ->update([
                'revoked_at' => now(),
            ]);
    }

    public function revokeUserSessionsForSecurityBlock(int $userId, string $reason, ?string $gameCode = null): int
    {
        $gameId = null;
        if ($gameCode) {
            $gameId = optional($this->findActiveGame($gameCode))->id;
        }

        $sessions = GameAccessToken::query()
            ->where('user_id', $userId)
            ->where('token_type', 'session')
            ->whereNull('revoked_at')
            ->when($gameId, function ($query) use ($gameId) {
                $query->where('game_id', $gameId);
            })
            ->get();

        foreach ($sessions as $session) {
            $meta = $this->tokenMeta($session);
            $meta['revoked_reason'] = 'jambo_security_block';
            $meta['revoked_detail'] = $reason;
            $meta['revoked_at'] = now()->toDateTimeString();

            $session->revoked_at = now();
            $session->meta_json = $meta;
            $session->save();
        }

        return $sessions->count();
    }

    public function blockUserForSecurity(
        int $userId,
        ?string $gameCode,
        string $reason,
        ?string $trigger = null,
        ?string $ipAddress = null,
        ?string $userAgent = null,
        array $meta = []
    ): GameSecurityBlock {
        $gameId = null;
        if ($gameCode) {
            $game = $this->findActiveGame($gameCode);
            if (!$game) {
                throw new \InvalidArgumentException('invalid_game_code');
            }
            $gameId = $game->id;
        }

        return GameSecurityBlock::updateOrCreate(
            [
                'user_id' => $userId,
                'game_id' => $gameId,
                'status' => 'active',
                'lifted_at' => null,
            ],
            [
                'reason' => substr($reason, 0, 255),
                'trigger' => $trigger ? substr($trigger, 0, 80) : null,
                'ip_address' => $ipAddress ? substr($ipAddress, 0, 64) : null,
                'user_agent' => $userAgent ? substr($userAgent, 0, 255) : null,
                'blocked_at' => now(),
                'meta_json' => $meta,
            ]
        );
    }

    public function activeSecurityBlockForUser(int $userId, ?string $gameCode = null): ?GameSecurityBlock
    {
        try {
            $gameId = null;
            if ($gameCode) {
                $gameId = optional($this->findActiveGame($gameCode))->id;
            }

            return GameSecurityBlock::query()
                ->where('user_id', $userId)
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
            return null;
        }
    }

    protected function tokenMeta(GameAccessToken $token): array
    {
        if (empty($token->meta_json)) {
            return [];
        }

        if (is_array($token->meta_json)) {
            return $token->meta_json;
        }

        $decoded = json_decode((string) $token->meta_json, true);

        return is_array($decoded) ? $decoded : [];
    }

    protected function tokenFailure(string $code, string $message, ?string $reason = null): array
    {
        return [
            'ok' => false,
            'code' => $code,
            'message' => $message,
            'reason' => $reason,
        ];
    }

    protected function cleanupExpiredTokens(): void
    {
        static $ran = false;
        if ($ran) {
            return;
        }

        $ran = true;

        try {
            GameAccessToken::query()
                ->whereNull('revoked_at')
                ->whereNotNull('expires_at')
                ->where('expires_at', '<=', now()->subMinutes(5))
                ->limit(500)
                ->update([
                    'revoked_at' => now(),
                ]);
        } catch (\Throwable $e) {
            // Silent fallback; token validation still enforces expires_at checks.
        }
    }
}
