<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is maintenance / demo mode via the "down" command we
| will require this file so that any prerendered template can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists(__DIR__.'/../storage/framework/maintenance.php')) {
    require __DIR__.'/../storage/framework/maintenance.php';
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$request = Request::capture();
$response = $kernel->handle($request);

$isProtectedRequest = $request->is('play_bd_game')
    || $request->is('play_bd_game/*')
    || $request->is('game')
    || $request->is('game/*')
    || $request->is('admin')
    || $request->is('admin/*')
    || $request->is('thomas-admin')
    || $request->is('login');

if ($isProtectedRequest && method_exists($response, 'headers')) {
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
    $response->headers->set('Content-Security-Policy', implode('; ', [
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
    ]));

    $clientCookieName = (string) config('bd_game_final.security.client_cookie_name', 'bdgf_client');
    if (!$request->cookies->has($clientCookieName)) {
        $response->headers->setCookie(new \Symfony\Component\HttpFoundation\Cookie(
            $clientCookieName,
            bin2hex(random_bytes(32)),
            now()->addMinutes((int) config('bd_game_final.security.client_cookie_ttl_minutes', 43200)),
            '/',
            null,
            $request->isSecure(),
            true,
            false,
            'Lax'
        ));
    }
}

$response->send();

$kernel->terminate($request, $response);
