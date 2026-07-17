<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class BroadliveRedisFirstCache
{
    public function handle(Request $request, Closure $next, string $group = 'generic', string $minTtl = '5', string $maxTtl = '30')
    {
        $namespace = $this->cacheNamespace($request);
        if (!$namespace) {
            return $this->withHeaders($next($request), 'BYPASS', 'host', $group, null);
        }

        if (!($request->isMethod('GET') || $request->isMethod('HEAD'))) {
            return $this->withHeaders($next($request), 'BYPASS', 'method', $group, null);
        }

        try {
            $redis = Redis::connection();
            if ((string) $redis->get("{$namespace}:cache:emergency_bypass") === '1') {
                return $this->withHeaders($next($request), 'BYPASS', 'emergency', $group, null);
            }
            if ((string) $redis->get("{$namespace}:cache:disable:{$group}") === '1') {
                return $this->withHeaders($next($request), 'BYPASS', 'group-disabled', $group, null);
            }

            $versionKey = "{$namespace}:cache:version:{$group}";
            $version = $redis->get($versionKey);
            if (!$version) {
                return $this->withHeaders($next($request), 'BYPASS', 'version-missing', $group, null);
            }

            $authUser = $request->user();
            $authId = $authUser ? (string) $authUser->getAuthIdentifier() : 'guest';
            $query = (string) ($request->getQueryString() ?? '');
            $cacheKey = "{$namespace}:cache:data:" . hash('sha256', implode('|', [
                $namespace,
                $group,
                (string) $version,
                $request->getMethod(),
                trim($request->path(), '/'),
                $query,
                $authId,
            ]));

            $cached = $redis->get($cacheKey);
            if (is_string($cached) && $cached !== '') {
                $payload = json_decode($cached, true);
                if (is_array($payload) && isset($payload['status'], $payload['body'])) {
                    return response($payload['body'], (int) $payload['status'])
                        ->header('Content-Type', $payload['content_type'] ?? 'application/json')
                        ->header('X-Redis-First-Cache', 'HIT')
                        ->header('X-Cache-Namespace', $namespace)
                        ->header('X-Cache-Group', $group)
                        ->header('X-Cache-Version', (string) $version);
                }
            }

            $response = $next($request);
            if (!$this->cacheableResponse($response)) {
                return $this->withHeaders($response, 'BYPASS', 'response', $group, (string) $version);
            }

            $content = $response->getContent();
            if (!is_string($content) || $content === '') {
                return $this->withHeaders($response, 'BYPASS', 'empty', $group, (string) $version);
            }

            $ttl = max((int) $minTtl, (int) $maxTtl);
            $redis->setex($cacheKey, $ttl, json_encode([
                'status' => $response->getStatusCode(),
                'body' => $content,
                'content_type' => $response->headers->get('Content-Type', 'application/json'),
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

            return $this->withHeaders($response, 'MISS', null, $group, (string) $version, $namespace);
        } catch (Throwable $e) {
            return $this->withHeaders($next($request), 'BYPASS', 'redis-error', $group, null, $namespace ?? null);
        }
    }

    private function cacheNamespace(Request $request): ?string
    {
        $host = strtolower((string) $request->getHost());
        if (in_array($host, ['broadlive.xyz', 'www.broadlive.xyz'], true)) {
            return 'broadlive.xyz';
        }

        return $host === 'thomaslivestreamingcompanyltdgame.broadlive.xyz' ? $host : null;
    }

    private function cacheableResponse($response): bool
    {
        if (!$response instanceof Response) {
            return false;
        }

        if ($response->getStatusCode() !== 200) {
            return false;
        }

        $content = $response->getContent();
        if (!is_string($content) || trim($content) === '') {
            return false;
        }

        $contentType = strtolower((string) $response->headers->get('Content-Type', ''));
        if (str_contains($contentType, 'application/json')) {
            return true;
        }

        json_decode($content, true);
        return json_last_error() === JSON_ERROR_NONE;
    }

    private function withHeaders($response, string $state, ?string $reason, string $group, ?string $version, ?string $namespace = null)
    {
        if (!$response instanceof Response) {
            return $response;
        }

        $response->headers->set('X-Redis-First-Cache', $state);
        if ($namespace) {
            $response->headers->set('X-Cache-Namespace', $namespace);
        }
        $response->headers->set('X-Cache-Group', $group);
        if ($version) {
            $response->headers->set('X-Cache-Version', $version);
        }
        if ($reason) {
            $response->headers->set('X-Redis-First-Reason', $reason);
        }

        return $response;
    }
}
