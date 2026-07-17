<?php

namespace App\Services\GameFinal;

use Closure;
use Illuminate\Support\Facades\Cache;

class GameStateCacheService
{
    protected function fallbackStore()
    {
        return Cache::store(config('cache.default'));
    }

    protected function store()
    {
        $store = (string) config('bd_game_final.cache.store', 'redis');
        try {
            return Cache::store($store);
        } catch (\Throwable $e) {
            return $this->fallbackStore();
        }
    }

    protected function ttl()
    {
        return (int) config('bd_game_final.cache.public_state_ttl_seconds', 2);
    }

    public function key($gameCode)
    {
        return (string) config('bd_game_final.cache.prefix', 'bdgf:v7:') . 'state:' . $gameCode;
    }

    public function getPublicState($gameCode)
    {
        if (!config('bd_game_final.cache.enabled', true)) {
            return null;
        }

        try {
            return $this->store()->get($this->key($gameCode));
        } catch (\Throwable $e) {
            return $this->fallbackStore()->get($this->key($gameCode));
        }
    }

    public function putPublicState($gameCode, array $payload, $ttl = null)
    {
        if (!config('bd_game_final.cache.enabled', true)) {
            return $payload;
        }

        try {
            $this->store()->put($this->key($gameCode), $payload, $ttl ?: $this->ttl());
        } catch (\Throwable $e) {
            $this->fallbackStore()->put($this->key($gameCode), $payload, $ttl ?: $this->ttl());
        }

        return $payload;
    }

    public function rememberPublicState($gameCode, Closure $callback, $ttl = null)
    {
        if (!config('bd_game_final.cache.enabled', true)) {
            return $callback();
        }

        try {
            return $this->store()->remember($this->key($gameCode), $ttl ?: $this->ttl(), $callback);
        } catch (\Throwable $e) {
            return $this->fallbackStore()->remember($this->key($gameCode), $ttl ?: $this->ttl(), $callback);
        }
    }

    public function forgetPublicState($gameCode)
    {
        if (!config('bd_game_final.cache.enabled', true)) {
            return false;
        }

        try {
            return $this->store()->forget($this->key($gameCode));
        } catch (\Throwable $e) {
            return $this->fallbackStore()->forget($this->key($gameCode));
        }
    }
}
