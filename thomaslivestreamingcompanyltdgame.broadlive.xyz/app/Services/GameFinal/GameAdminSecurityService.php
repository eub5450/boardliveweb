<?php

namespace App\Services\GameFinal;

use Carbon\CarbonInterface;
use Illuminate\Session\Store;

class GameAdminSecurityService
{
    public const SESSION_VERIFIED_UNTIL_KEY = 'game_final_admin_security_verified_until';
    public const SESSION_ATTEMPTS_KEY = 'game_final_admin_security_attempts';
    public const SESSION_LOCKED_UNTIL_KEY = 'game_final_admin_security_locked_until';

    public function hasConfiguredSecret(): bool
    {
        $hash = $this->configuredSecretHash();
        if ($hash !== '') {
            return (bool) preg_match('/^[a-f0-9]{64}$/', $hash);
        }

        $secret = $this->configuredSecret();
        return $secret !== '' && strlen($secret) >= 24;
    }

    public function helperPattern(): string
    {
        return 'configured_env_secret';
    }

    public function examplePassphrases(?CarbonInterface $now = null): array
    {
        return ['No static pattern. Use configured security secret.'];
    }

    public function isValid(string $candidate, ?CarbonInterface $now = null): bool
    {
        $candidate = trim($candidate);
        if ($candidate === '' || !$this->hasConfiguredSecret()) {
            return false;
        }

        $hash = $this->configuredSecretHash();
        if ($hash !== '') {
            return hash_equals($hash, hash('sha256', $candidate));
        }

        return hash_equals($this->configuredSecret(), $candidate);
    }

    public function isVerified(Store $session, ?CarbonInterface $now = null): bool
    {
        $timestamp = (int) $session->get(self::SESSION_VERIFIED_UNTIL_KEY, 0);
        if ($timestamp <= 0) {
            return false;
        }

        return $timestamp > ($now ? $now->getTimestamp() : now()->getTimestamp());
    }

    public function canAttempt(Store $session, ?CarbonInterface $now = null): bool
    {
        $lockedUntil = (int) $session->get(self::SESSION_LOCKED_UNTIL_KEY, 0);
        if ($lockedUntil <= 0) {
            return true;
        }

        return ($now ? $now->getTimestamp() : now()->getTimestamp()) >= $lockedUntil;
    }

    public function lockoutRemainingSeconds(Store $session, ?CarbonInterface $now = null): int
    {
        $lockedUntil = (int) $session->get(self::SESSION_LOCKED_UNTIL_KEY, 0);
        $nowTs = $now ? $now->getTimestamp() : now()->getTimestamp();

        if ($lockedUntil <= $nowTs) {
            return 0;
        }

        return $lockedUntil - $nowTs;
    }

    public function verifyAndMark(Store $session, string $candidate, ?CarbonInterface $now = null): array
    {
        $nowTs = $now ? $now->getTimestamp() : now()->getTimestamp();

        if (!$this->hasConfiguredSecret()) {
            return ['ok' => false, 'reason' => 'secret_not_configured', 'retry_after' => 0];
        }

        if (!$this->canAttempt($session, $now)) {
            return ['ok' => false, 'reason' => 'locked', 'retry_after' => $this->lockoutRemainingSeconds($session, $now)];
        }

        if (!$this->isValid($candidate, $now)) {
            $attempts = ((int) $session->get(self::SESSION_ATTEMPTS_KEY, 0)) + 1;
            $session->put(self::SESSION_ATTEMPTS_KEY, $attempts);

            $maxAttempts = max(1, (int) config('bd_game_final.admin_security.max_attempts', 5));
            if ($attempts >= $maxAttempts) {
                $lockSeconds = max(60, (int) config('bd_game_final.admin_security.lockout_seconds', 900));
                $session->put(self::SESSION_LOCKED_UNTIL_KEY, $nowTs + $lockSeconds);
                $session->put(self::SESSION_ATTEMPTS_KEY, 0);

                return ['ok' => false, 'reason' => 'locked', 'retry_after' => $lockSeconds];
            }

            return ['ok' => false, 'reason' => 'invalid_passphrase', 'retry_after' => 0];
        }

        $this->markVerified($session, $now);

        return ['ok' => true, 'reason' => 'verified', 'retry_after' => 0];
    }

    public function markVerified(Store $session, ?CarbonInterface $now = null): void
    {
        $nowTs = $now ? $now->getTimestamp() : now()->getTimestamp();
        $ttlSeconds = max(300, (int) config('bd_game_final.admin_security.session_ttl_seconds', 1800));

        $session->put(self::SESSION_VERIFIED_UNTIL_KEY, $nowTs + $ttlSeconds);
        $session->put(self::SESSION_ATTEMPTS_KEY, 0);
        $session->forget(self::SESSION_LOCKED_UNTIL_KEY);
    }

    public function forget(Store $session): void
    {
        $session->forget(self::SESSION_VERIFIED_UNTIL_KEY);
        $session->forget(self::SESSION_ATTEMPTS_KEY);
        $session->forget(self::SESSION_LOCKED_UNTIL_KEY);
    }

    protected function configuredSecret(): string
    {
        return trim((string) config('bd_game_final.admin_security.secret', ''));
    }

    protected function configuredSecretHash(): string
    {
        return strtolower(trim((string) config('bd_game_final.admin_security.secret_hash', '')));
    }
}
