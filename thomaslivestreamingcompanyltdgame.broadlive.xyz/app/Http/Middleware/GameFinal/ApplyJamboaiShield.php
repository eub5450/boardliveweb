<?php

namespace App\Http\Middleware\GameFinal;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApplyJamboaiShield
{
    protected function clientCookieName(): string
    {
        return (string) config('bd_game_final.security.client_cookie_name', 'bdgf_client');
    }

    protected function isProtectedRequest(Request $request): bool
    {
        return $request->is('play_bd_game')
            || $request->is('play_bd_game/*')
            || $request->is('game')
            || $request->is('game/*')
            || $request->is('admin')
            || $request->is('admin/*')
            || $request->is('thomas-admin')
            || $request->is('login');
    }

    protected function contentSecurityPolicy(): string
    {
        return implode('; ', [
            "default-src 'self' https://fonts.googleapis.com https://fonts.gstatic.com https://cdnjs.cloudflare.com https://js.pusher.com",
            "script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://js.pusher.com",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com",
            "img-src 'self' data: blob: http: https:",
            "font-src 'self' data: https://fonts.gstatic.com https://cdnjs.cloudflare.com",
            "connect-src 'self' ws: wss: http: https:",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'self'",
        ]);
    }

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!$this->isProtectedRequest($request) || !method_exists($response, 'headers')) {
            return $response;
        }

        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0, private');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'no-referrer');
        $response->headers->set('Permissions-Policy', 'accelerometer=(), camera=(), geolocation=(), gyroscope=(), magnetometer=(), microphone=(), payment=(), usb=()');
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');
        $response->headers->set('Cross-Origin-Resource-Policy', 'same-origin');
        $response->headers->set('X-Robots-Tag', 'noindex, nofollow, noarchive');
        $response->headers->set('Content-Security-Policy', $this->contentSecurityPolicy());

        $cookieName = $this->clientCookieName();
        if (!$request->cookies->has($cookieName)) {
            $response->headers->setCookie(cookie(
                $cookieName,
                Str::random(64),
                (int) config('bd_game_final.security.client_cookie_ttl_minutes', 43200),
                '/',
                null,
                $request->isSecure(),
                true,
                false,
                'Lax'
            ));
        }

        return $response;
    }
}
