<?php

namespace App\Services\GameFinal;

use App\Models\GameFinal\Game;
use App\Models\GameFinal\GameSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GameRuntimeService
{
    protected const CACHE_KEY = 'bdgf:admin_runtime_settings';
    protected const MAX_ALERTS = 20;

    public function settings(): array
    {
        return Cache::remember(self::CACHE_KEY, 30, function () {
            $defaults = $this->defaults();

            if (!Schema::hasTable('bd_game_final_runtime_settings')) {
                return $defaults;
            }

            $rows = DB::table('bd_game_final_runtime_settings')->pluck('value', 'key')->all();

            return array_merge($defaults, array_map(function ($value) {
                $decoded = json_decode((string) $value, true);

                return json_last_error() === JSON_ERROR_NONE ? $decoded : $value;
            }, $rows));
        });
    }

    public function update(array $settings): void
    {
        if (!Schema::hasTable('bd_game_final_runtime_settings')) {
            return;
        }

        DB::transaction(function () use ($settings) {
            foreach ($settings as $key => $value) {
                DB::table('bd_game_final_runtime_settings')->updateOrInsert(
                    ['key' => $key],
                    [
                        'value' => is_scalar($value) || $value === null ? (string) $value : json_encode($value),
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        });

        Cache::forget(self::CACHE_KEY);
    }

    public function configVersion(?array $settings = null): int
    {
        $version = (int) (($settings ?: $this->settings())['config_version'] ?? 1);

        return max(1, $version);
    }

    public function configUpdatedAt(?array $settings = null): ?string
    {
        $value = trim((string) (($settings ?: $this->settings())['config_updated_at'] ?? ''));

        return $value !== '' ? $value : null;
    }

    public function bumpConfigVersion(array $settings = []): int
    {
        $current = $this->settings();
        $next = $this->configVersion($current) + 1;
        $settings['config_version'] = $next;
        $settings['config_updated_at'] = now()->toIso8601String();
        $this->update($settings);

        return $next;
    }

    public function applyToConfig(): array
    {
        $settings = $this->settings();
        $mode = $this->realtimeMode($settings);

        Config::set('bd_game_final.realtime.mode', $mode);
        Config::set('bd_game_final.realtime.enabled', $mode !== 'polling');
        Config::set('bd_game_final.realtime.poll_fallback_ms', (int) ($settings['poll_interval_ms'] ?? 1500));
        Config::set('bd_game_final.realtime.config_version', $this->configVersion($settings));
        Config::set('bd_game_final.realtime.config_updated_at', $this->configUpdatedAt($settings));
        Config::set('bd_game_final.realtime.websocket.enabled', $mode === 'websocket');
        Config::set('bd_game_final.realtime.websocket.url', (string) ($settings['websocket_url'] ?? ''));
        Config::set('bd_game_final.realtime.websocket.protocols', $this->csvArray((string) ($settings['websocket_protocols'] ?? '')));
        $pusherAccounts = $this->pusherAccounts($settings);
        $activePusher = $pusherAccounts[(int) ($settings['pusher_active_index'] ?? 0)] ?? ($pusherAccounts[0] ?? []);
        Config::set('bd_game_final.realtime.pusher.accounts', $pusherAccounts);
        Config::set('bd_game_final.realtime.pusher.public_accounts', collect($pusherAccounts)->map(function (array $account) {
            unset($account['secret']);

            return $account;
        })->values()->all());
        Config::set('bd_game_final.realtime.pusher.active_index', (int) ($settings['pusher_active_index'] ?? 0));
        Config::set('bd_game_final.realtime.pusher.key', (string) ($activePusher['key'] ?? ''));
        Config::set('bd_game_final.realtime.pusher.app_id', (string) ($activePusher['app_id'] ?? ''));
        Config::set('bd_game_final.realtime.pusher.secret', (string) ($activePusher['secret'] ?? ''));
        Config::set('bd_game_final.realtime.pusher.cluster', (string) ($activePusher['cluster'] ?? 'mt1'));
        Config::set('bd_game_final.realtime.pusher.host', (string) ($activePusher['host'] ?? ''));
        Config::set('bd_game_final.realtime.pusher.port', (int) ($activePusher['port'] ?? 443));
        Config::set('bd_game_final.realtime.pusher.scheme', (string) ($activePusher['scheme'] ?? 'https'));
        Config::set('bd_game_final.runtime.redis_enabled', (bool) ($settings['redis_enabled'] ?? false));
        Config::set('bd_game_final.runtime.jobs_enabled', (bool) ($settings['jobs_enabled'] ?? false));
        Config::set('bd_game_final.runtime.cron_enabled', (bool) ($settings['cron_enabled'] ?? false));
        Config::set('broadcasting.default', $mode === 'pusher' ? 'pusher' : 'log');
        Config::set('broadcasting.connections.pusher.key', (string) ($activePusher['key'] ?? ''));
        Config::set('broadcasting.connections.pusher.secret', (string) ($activePusher['secret'] ?? ''));
        Config::set('broadcasting.connections.pusher.app_id', (string) ($activePusher['app_id'] ?? ''));
        Config::set('broadcasting.connections.pusher.options.cluster', (string) ($activePusher['cluster'] ?? 'mt1'));
        Config::set('broadcasting.connections.pusher.options.host', (string) ($activePusher['host'] ?? ''));
        Config::set('broadcasting.connections.pusher.options.port', (int) ($activePusher['port'] ?? 443));
        Config::set('broadcasting.connections.pusher.options.scheme', (string) ($activePusher['scheme'] ?? 'https'));
        Config::set('broadcasting.connections.pusher.options.useTLS', (string) ($activePusher['scheme'] ?? 'https') === 'https');
        Config::set('broadcasting.connections.pusher.options.encrypted', (string) ($activePusher['scheme'] ?? 'https') === 'https');

        return $settings;
    }

    public function realtimeMode(?array $settings = null): string
    {
        $mode = (string) (($settings ?: $this->settings())['realtime_mode'] ?? 'polling');

        return in_array($mode, ['polling', 'websocket', 'pusher'], true) ? $mode : 'polling';
    }

    public function runtimeStatus(): array
    {
        return [
            'redis_available' => extension_loaded('redis') || class_exists(\Predis\Client::class),
            'queue_driver' => (string) config('queue.default'),
            'jobs_available' => config('queue.default') !== 'sync',
            'cron_available' => true,
            'pusher_configured' => $this->pusherConfigured(),
            'websocket_configured' => $this->websocketConfigured(),
        ];
    }

    public function pusherConfigured(): bool
    {
        return count($this->pusherAccounts()) > 0;
    }

    public function pusherAccounts(?array $settings = null): array
    {
        $settings = $settings ?: $this->settings();
        $accounts = is_array($settings['pusher_accounts'] ?? null) ? $settings['pusher_accounts'] : [];

        if (!$accounts) {
            $accounts = [[
                'app_id' => $settings['pusher_app_id'] ?? '',
                'key' => $settings['pusher_key'] ?? '',
                'secret' => $settings['pusher_secret'] ?? '',
                'cluster' => $settings['pusher_cluster'] ?? 'mt1',
                'host' => $settings['pusher_host'] ?? '',
                'port' => $settings['pusher_port'] ?? 443,
                'scheme' => $settings['pusher_scheme'] ?? 'https',
            ]];
        }

        return collect($accounts)
            ->map(function ($account, $index) {
                $account = (array) $account;

                return [
                    'slot' => (int) $index,
                    'app_id' => trim((string) ($account['app_id'] ?? '')),
                    'key' => trim((string) ($account['key'] ?? '')),
                    'secret' => trim((string) ($account['secret'] ?? '')),
                    'cluster' => trim((string) ($account['cluster'] ?? 'mt1')) ?: 'mt1',
                    'host' => trim((string) ($account['host'] ?? '')),
                    'port' => (int) ($account['port'] ?? 443),
                    'scheme' => trim((string) ($account['scheme'] ?? 'https')) ?: 'https',
                ];
            })
            ->filter(function (array $account) {
                return $account['app_id'] !== '' && $account['key'] !== '' && $account['secret'] !== '';
            })
            ->values()
            ->all();
    }

    public function publicPusherAccounts(): array
    {
        return collect($this->pusherAccounts())
            ->map(function (array $account) {
                unset($account['secret']);

                return $account;
            })
            ->values()
            ->all();
    }

    public function markPusherCredentialFailed(int $index, string $reason): void
    {
        $settings = $this->settings();
        $failed = is_array($settings['pusher_failed_indexes'] ?? null) ? $settings['pusher_failed_indexes'] : [];
        $failed[] = $index;
        $failed = array_values(array_unique(array_map('intval', $failed)));
        $accounts = $this->pusherAccounts($settings);
        $next = null;

        foreach (array_keys($accounts) as $candidate) {
            if (!in_array((int) $candidate, $failed, true)) {
                $next = (int) $candidate;
                break;
            }
        }

        if ($next !== null) {
            $this->update([
                'pusher_failed_indexes' => $failed,
                'pusher_active_index' => $next,
            ]);
            $this->pushAdminAlert('warning', 'Pusher account ' . ($index + 1) . ' failed. Switching to account ' . ($next + 1) . '.', [
                'reason' => $reason,
            ]);
            return;
        }

        $this->update([
            'pusher_failed_indexes' => $failed,
            'pusher_active_index' => 0,
            'realtime_mode' => 'polling',
        ]);
        $this->pushAdminAlert('danger', 'All Pusher accounts failed or reached their limit. Realtime changed to polling. Add or refresh Pusher credentials.', [
            'reason' => $reason,
        ]);
    }

    public function clearPusherFailures(): void
    {
        $this->update([
            'pusher_failed_indexes' => [],
            'pusher_active_index' => 0,
        ]);
    }

    public function pushAdminAlert(string $level, string $message, array $meta = []): void
    {
        $settings = $this->settings();
        $alerts = is_array($settings['admin_alerts'] ?? null) ? $settings['admin_alerts'] : [];
        array_unshift($alerts, [
            'level' => $level,
            'message' => $message,
            'meta' => $meta,
            'created_at' => now()->toDateTimeString(),
        ]);

        $this->update([
            'admin_alerts' => array_slice($alerts, 0, self::MAX_ALERTS),
        ]);
    }

    public function adminAlerts(): array
    {
        $alerts = $this->settings()['admin_alerts'] ?? [];

        return is_array($alerts) ? array_slice($alerts, 0, self::MAX_ALERTS) : [];
    }

    public function websocketConfigured(): bool
    {
        return trim((string) ($this->settings()['websocket_url'] ?? '')) !== '';
    }

    public function maintenanceState(string $gameCode, $user = null): array
    {
        $game = Game::query()->where('game_code', $gameCode)->first();
        if (!$game) {
            return ['active' => false, 'allowed' => true, 'message' => '', 'status' => 'live'];
        }

        $setting = GameSetting::query()->where('game_id', $game->id)->first();
        $allowedUserIds = $this->maintenanceAllowedUserIds($gameCode);
        $legacyAllowedUserId = $setting ? (int) ($setting->maintenance_allowed_user_id ?? 0) : 0;
        if ($legacyAllowedUserId > 0 && !in_array($legacyAllowedUserId, $allowedUserIds, true)) {
            $allowedUserIds[] = $legacyAllowedUserId;
        }
        $status = $this->normalizeStoredGameStatus(
            $setting ? (string) ($setting->game_status ?? '') : '',
            $setting ? (bool) ($setting->maintenance_enabled ?? false) : false,
            $allowedUserIds,
            (bool) $game->is_active
        );
        $active = in_array($status, ['developer', 'maintenance'], true);
        $userId = $user ? (int) $user->id : 0;
        $allowed = !$active
            || ($status === 'developer' && $userId !== 0 && in_array($userId, $allowedUserIds, true));
        $message = $setting && trim((string) ($setting->maintenance_message ?? '')) !== ''
            ? (string) $setting->maintenance_message
            : ($status === 'developer'
                ? 'This game is in developer mode. Only approved developer IDs can enter.'
                : 'This game is in maintenance. Please wait.');

        return [
            'active' => $active,
            'allowed' => $allowed,
            'status' => $status,
            'allowed_user_ids' => $allowedUserIds,
            'allowed_user_id' => $allowedUserIds ? (int) $allowedUserIds[0] : null,
            'message' => $message,
        ];
    }

    public function maintenanceAllowedUserIds(string $gameCode): array
    {
        $runtime = $this->settings();
        $raw = is_array($runtime['maintenance_allowed_user_ids'] ?? null)
            ? ($runtime['maintenance_allowed_user_ids'][$gameCode] ?? [])
            : null;

        return $this->normalizeMaintenanceAllowedUserIds($raw);
    }

    protected function defaults(): array
    {
        return [
            'realtime_mode' => (string) env('BD_GAME_FINAL_REALTIME_MODE', 'polling'),
            'poll_interval_ms' => (int) env('BD_GAME_FINAL_POLL_FALLBACK_MS', 1500),
            'websocket_url' => (string) env('BD_GAME_FINAL_WEBSOCKET_URL', ''),
            'websocket_protocols' => (string) env('BD_GAME_FINAL_WEBSOCKET_PROTOCOLS', ''),
            'pusher_app_id' => (string) env('PUSHER_APP_ID', ''),
            'pusher_key' => (string) env('PUSHER_APP_KEY', ''),
            'pusher_secret' => (string) env('PUSHER_APP_SECRET', ''),
            'pusher_cluster' => (string) env('PUSHER_APP_CLUSTER', 'mt1'),
            'pusher_host' => (string) env('PUSHER_HOST', ''),
            'pusher_port' => (int) env('PUSHER_PORT', 443),
            'pusher_scheme' => (string) env('PUSHER_SCHEME', 'https'),
            'pusher_accounts' => [],
            'pusher_active_index' => 0,
            'pusher_failed_indexes' => [],
            'admin_alerts' => [],
            'config_version' => 1,
            'config_updated_at' => null,
            'redis_enabled' => false,
            'jobs_enabled' => false,
            'cron_enabled' => false,
            'maintenance_allowed_user_ids' => [],
        ];
    }

    protected function normalizeStoredGameStatus(string $rawStatus, bool $maintenanceEnabled, array $allowedUserIds, bool $enabled): string
    {
        $rawStatus = trim($rawStatus);

        return match ($rawStatus) {
            'active' => 'live',
            'inactive' => 'maintenance',
            'live', 'developer', 'maintenance' => $rawStatus,
            default => $maintenanceEnabled
                ? (!empty($allowedUserIds) ? 'developer' : 'maintenance')
                : ($enabled ? 'live' : 'maintenance'),
        };
    }

    protected function normalizeMaintenanceAllowedUserIds($input): array
    {
        if (is_array($input)) {
            $normalized = [];
            foreach ($input as $item) {
                $item = trim((string) $item);
                if ($item === '' || !ctype_digit($item)) {
                    continue;
                }
                $id = (int) $item;
                if ($id > 0 && !in_array($id, $normalized, true)) {
                    $normalized[] = $id;
                }
            }
            return $normalized;
        }

        $raw = trim((string) $input);
        if ($raw === '') {
            return [];
        }

        $parts = preg_split('/[\\s,;]+/', $raw);
        if (!$parts) {
            return [];
        }

        $normalized = [];
        foreach ($parts as $part) {
            $part = trim((string) $part);
            if ($part === '') {
                continue;
            }

            if (filter_var($part, FILTER_VALIDATE_INT) === false) {
                continue;
            }

            $id = (int) $part;
            if ($id <= 0 || in_array($id, $normalized, true)) {
                continue;
            }

            $normalized[] = $id;
        }

        return $normalized;
    }

    protected function csvArray(string $value): array
    {
        return array_values(array_filter(array_map('trim', explode(',', $value))));
    }
}
