<?php

namespace App\Services\GameFinal;

use Illuminate\Http\Request;
use App\Models\User;

class AppPackageVerificationService
{
    /**
     * Get allowed app packages from config
     */
    public function getAllowedPackages(): array
    {
        $packagesEnv = (string) env('BD_GAME_FINAL_ALLOWED_APP_PACKAGES', '');
        if ($packagesEnv === '') {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', $packagesEnv))));
    }

    /**
     * Get developer secret from env.
     * No fallback default is allowed.
     */
    public function getDeveloperPassword(): string
    {
        return trim((string) env('BD_GAME_FINAL_DEVELOPER_PASSWORD', ''));
    }

    /**
     * Optional SHA-256 hash variant for secret-only storage.
     */
    public function getDeveloperPasswordHash(): string
    {
        return strtolower(trim((string) env('BD_GAME_FINAL_DEVELOPER_PASSWORD_HASH', '')));
    }

    public function hasStrongPasswordConfig(): bool
    {
        $secret = $this->getDeveloperPassword();
        $hash = $this->getDeveloperPasswordHash();

        if ($hash !== '') {
            return (bool) preg_match('/^[a-f0-9]{64}$/', $hash);
        }

        // Fail closed if missing or weak.
        return $secret !== '' && strlen($secret) >= 24;
    }

    /**
     * Extract app package name from request
     */
    public function getPackageFromRequest(Request $request): ?string
    {
        $package = $request->header('X-App-Package');
        if ($package) {
            return $this->sanitizePackage($package);
        }

        $package = $request->get('app_package');
        if ($package) {
            return $this->sanitizePackage($package);
        }

        $userAgent = (string) $request->header('User-Agent', '');
        if (preg_match('/\(([a-z0-9.]+)\)/i', $userAgent, $matches)) {
            return $this->sanitizePackage($matches[1]);
        }

        return null;
    }

    protected function sanitizePackage(string $package): ?string
    {
        $sanitized = preg_replace('/[^a-z0-9._-]/i', '', trim($package));
        return $sanitized ?: null;
    }

    public function isPackageAllowed(string $package): bool
    {
        return in_array($package, $this->getAllowedPackages(), true);
    }

    public function verifyPassword(string $password): bool
    {
        $candidate = trim($password);
        if ($candidate === '' || !$this->hasStrongPasswordConfig()) {
            return false;
        }

        $hash = $this->getDeveloperPasswordHash();
        if ($hash !== '') {
            return hash_equals($hash, hash('sha256', $candidate));
        }

        return hash_equals($this->getDeveloperPassword(), $candidate);
    }

    public function passwordAuthAvailable(): bool
    {
        return $this->hasStrongPasswordConfig();
    }

    public function resolveAppAccessUser(Request $request): ?User
    {
        if (auth()->check()) {
            return auth()->user();
        }

        $apiToken = $request->header('X-Api-Token')
            ?: $request->get('api_token')
            ?: $request->post('api_token');

        if ($apiToken && config('bd_game_final.allow_api_token_issue_entry', true)) {
            $column = (string) config('bd_game_final.api_token_column', 'api_token');
            $user = User::where($column, $apiToken)->first();
            if ($user) {
                return $user;
            }
        }

        $configuredUserId = (int) env('BD_GAME_FINAL_APP_ACCESS_USER_ID', 0);
        if ($configuredUserId > 0) {
            return User::find($configuredUserId);
        }

        return null;
    }

    /**
     * Backwards-compatible name. This no longer creates a funded shared user.
     */
    public function getOrCreateAppUser(): ?User
    {
        $configuredUserId = (int) env('BD_GAME_FINAL_APP_ACCESS_USER_ID', 0);
        return $configuredUserId > 0 ? User::find($configuredUserId) : null;
    }

    protected function appAccessUserConfigured(Request $request): bool
    {
        return (bool) $this->resolveAppAccessUser($request);
    }

    /**
     * Verify app access - returns user if valid, null otherwise
     */
    public function verifyAppAccess(Request $request): ?array
    {
        $package = $this->getPackageFromRequest($request);
        $password = (string) ($request->post('password') ?: $request->header('X-Developer-Password'));

        if ($password !== '' && $this->verifyPassword($password)) {
            $user = $this->resolveAppAccessUser($request);
            if (!$user) {
                return null;
            }

            return [
                'verified' => true,
                'reason' => 'password_match',
                'package' => $package,
                'package_allowed' => $package ? $this->isPackageAllowed($package) : null,
                'user' => $user,
            ];
        }

        return null;
    }

    public function getUnverifiedResponse(Request $request): array
    {
        $package = $this->getPackageFromRequest($request);
        $packageAllowed = $package ? $this->isPackageAllowed($package) : false;
        $passwordAvailable = $this->passwordAuthAvailable();
        $userConfigured = $this->appAccessUserConfigured($request);

        $message = $packageAllowed
            ? 'Package recognized. Developer authentication is required.'
            : 'Package not recognized. Developer authentication is required.';

        if (!$packageAllowed && !$passwordAvailable) {
            $message = 'Access configuration unavailable. Contact administrator.';
        }
        if ($passwordAvailable && !$userConfigured) {
            $message = 'Access user is not configured.';
        }

        return [
            'verified' => false,
            'package_detected' => $package,
            'package_allowed' => $packageAllowed,
            'requires_password' => $passwordAvailable,
            'user_configured' => $userConfigured,
            'message' => $message,
        ];
    }
}
