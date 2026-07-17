<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
     protected $namespace = 'App\\Http\\Controllers';

    protected function gameClientKey(Request $request): string
    {
        return implode('|', [
            optional($request->user())->id ?: 'guest',
            (string) $request->ip(),
            substr((string) $request->cookie(config('bd_game_final.security.client_cookie_name', 'bdgf_client'), 'no-client-cookie'), 0, 80),
        ]);
    }

    protected function gameSessionKey(Request $request): string
    {
        return implode('|', [
            optional($request->user())->id ?: 'guest',
            trim((string) ($request->header('X-Game-Session') ?: $request->post('session_token') ?: 'no-session-token')),
            (string) $request->ip(),
        ]);
    }

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
             return Limit::perMinute(240)->by(optional($request->user())->id ?: $request->ip());
        });
        RateLimiter::for('home_data_limit', function (Request $request) {
             return Limit::perMinute(240)->by(optional($request->user())->id ?: $request->ip());
        });
        RateLimiter::for('game_hit', function (Request $request) {
             return Limit::perMinute(120)->by(optional($request->user())->id ?: $request->ip());
        });
        RateLimiter::for('admin-auth', function (Request $request) {
            return Limit::perMinute((int) config('bd_game_final.security.rate_limits.admin_auth_per_minute', 12))
                ->by(strtolower(trim((string) $request->input('email', 'unknown'))) . '|' . (string) $request->ip());
        });
        RateLimiter::for('game-lobby', function (Request $request) {
            return Limit::perMinute((int) config('bd_game_final.security.rate_limits.lobby_per_minute', 90))
                ->by($this->gameClientKey($request));
        });
        RateLimiter::for('game-entry-view', function (Request $request) {
            return Limit::perMinute((int) config('bd_game_final.security.rate_limits.entry_view_per_minute', 120))
                ->by($this->gameClientKey($request));
        });
        RateLimiter::for('game-start', function (Request $request) {
            return Limit::perMinute((int) config('bd_game_final.security.rate_limits.start_per_minute', 60))
                ->by($this->gameClientKey($request));
        });
        RateLimiter::for('game-auth', function (Request $request) {
            return Limit::perMinute((int) config('bd_game_final.security.rate_limits.auth_per_minute', 30))
                ->by($this->gameClientKey($request));
        });
        RateLimiter::for('game-state', function (Request $request) {
            return Limit::perMinute((int) config('bd_game_final.security.rate_limits.state_per_minute', 240))
                ->by($this->gameSessionKey($request));
        });
        RateLimiter::for('game-bet', function (Request $request) {
            return Limit::perMinute((int) config('bd_game_final.security.rate_limits.bet_per_minute', 120))
                ->by($this->gameSessionKey($request));
        });
        RateLimiter::for('game-heartbeat', function (Request $request) {
            return Limit::perMinute((int) config('bd_game_final.security.rate_limits.heartbeat_per_minute', 240))
                ->by($this->gameSessionKey($request));
        });
        RateLimiter::for('game-history', function (Request $request) {
            return Limit::perMinute((int) config('bd_game_final.security.rate_limits.history_per_minute', 120))
                ->by($this->gameSessionKey($request));
        });
        RateLimiter::for('game-security-report', function (Request $request) {
            return Limit::perMinute((int) config('bd_game_final.security.rate_limits.security_report_per_minute', 30))
                ->by($this->gameSessionKey($request));
        });
    }
}
