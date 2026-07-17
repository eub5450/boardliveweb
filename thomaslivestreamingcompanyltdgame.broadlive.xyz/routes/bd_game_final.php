<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameFinal\GameApiController;
use App\Http\Controllers\GameFinal\GamePageController;
use App\Http\Controllers\GameFinal\GameLobbyController;
use App\Http\Controllers\GameFinal\AppAccessController;

Route::get('/play_bd_game', [GameLobbyController::class, 'index'])->middleware('throttle:game-lobby')->name('game-final.lobby');
Route::match(['GET','POST'], '/play_bd_game/start/{gameCode}', [GameLobbyController::class, 'start'])->middleware('throttle:game-start')->name('game-final.lobby.start');
Route::get('/play_bd_game/s/{key}', [GameLobbyController::class, 'keyedLobby'])
    ->middleware('throttle:game-lobby')
    ->where('key', '[^/]+')
    ->name('game-final.lobby.keyed.secure');
Route::get('/play_bd_game/{key}', [GameLobbyController::class, 'keyedLobby'])
    ->middleware('throttle:game-lobby')
    ->where('key', '[^/]+')
    ->name('game-final.lobby.keyed');

if (app()->environment(['local', 'development', 'testing'])) {
    Route::get('/play_bd_game/handoff/{gameCode}', function (\Illuminate\Http\Request $request, string $gameCode) {
        $gameToken = trim((string) $request->query('game_token', ''));
        abort_unless($gameToken !== '', 404, 'game_token_required');

        return response()->view('game_final.access_handoff', [
            'gameCode' => $gameCode,
            'gameName' => (string) (config('bd_game_final.games.' . $gameCode . '.name') ?? $gameCode),
            'gameToken' => $gameToken,
            'entryUrl' => route('game-final.entry', ['gameCode' => $gameCode]),
            'lobbyUrl' => url('/play_bd_game'),
        ]);
    })->middleware('throttle:game-start')->name('game-final.local-handoff');

    Route::get('/play_bd_game/open/{gameCode}', function (
        \Illuminate\Http\Request $request,
        string $gameCode,
        \App\Services\GameFinal\GameTokenService $tokens,
        \App\Services\GameFinal\GameConfigService $configs,
        \App\Services\GameFinal\GameRuntimeService $runtime
    ) {
        if ($request->boolean('debug')) {
            return response()->json([
                'route' => 'game-final.local-open',
                'gameCode' => $gameCode,
                'userAgent' => (string) $request->userAgent(),
                'ip' => (string) $request->ip(),
                'clientKey' => $tokens->clientKeyFromRequest($request),
                'fingerprint' => $tokens->fingerprintFromRequest($request),
                'sessionId' => optional($request->session())->getId(),
                'cookieNames' => array_keys($request->cookies->all()),
            ]);
        }

        $userId = max(1, (int) $request->query('user_id', 1));
        $user = \App\Models\User::query()->findOrFail($userId);
        \App\Models\GameFinal\GameAccessToken::query()
            ->where('user_id', $user->id)
            ->where('token_type', 'session')
            ->whereNull('revoked_at')
            ->update(['revoked_at' => now()]);
        $issued = $tokens->issueSessionToken($gameCode, $user->id, null, $tokens->fingerprintFromRequest($request), [
            'issued_from' => 'local_browser_open',
            'from' => 'play_bd_game/open',
        ]);
        $sessionToken = trim((string) ($issued['plain_token'] ?? ''));
        abort_unless($sessionToken !== '', 500, 'session_token_issue_failed');

        $status = $tokens->sessionTokenStatus(
            $sessionToken,
            $gameCode,
            $request->ip(),
            $request->userAgent(),
            $tokens->clientKeyFromRequest($request),
            $tokens->fingerprintFromRequest($request)
        );
        abort_unless(!empty($status['ok']), 409, (string) ($status['message'] ?? 'invalid_session'));

        if ($request->boolean('diagnose')) {
            return response()->json([
                'route' => 'game-final.local-open-diagnose',
                'gameCode' => $gameCode,
                'sessionTokenPrefix' => substr($sessionToken, 0, 12),
                'status' => $status,
            ]);
        }

        $runtime->applyToConfig();
        $view = \App\Support\GameFinal\GameRegistry::view($gameCode);
        abort_unless($view, 404);
        $config = $configs->get($gameCode);
        $displayUser = $status['user'] ?? $user;

        return response()->view($view, [
            'gameCode' => $gameCode,
            'gameToken' => null,
            'sessionToken' => $sessionToken,
            'displayUserName' => trim((string) ($displayUser->name ?? '')) ?: ('Player ' . $displayUser->id),
            'displayUserId' => $displayUser->id ?? $user->id,
            'gameRules' => $config['rules'] ?? [],
            'gameTheme' => $config['ui_theme'] ?? [],
            'lobbyUrl' => url('/play_bd_game'),
        ]);
    })->middleware('throttle:game-entry-view')->name('game-final.local-open');
}

Route::prefix(config('bd_game_final.route_prefix', 'game'))->group(function () {
    Route::match(['GET','POST'], 'thomas-live-streeaming-game-{key}/start/{gameCode}', [GameLobbyController::class, 'keyedStart'])
        ->middleware('throttle:game-start')
        ->where('key', '[^/]+')
        ->name('game-final.keyed-lobby.start');
    Route::get('thomas-live-streeaming-game-{key}', [GameLobbyController::class, 'keyedLobby'])
        ->middleware('throttle:game-lobby')
        ->where('key', '[^/]+')
        ->name('game-final.keyed-lobby');

    // App-based access (for mobile apps)
    Route::get('{gameCode}/app-access', [AppAccessController::class, 'verify'])->middleware('throttle:game-auth')->name('game-final.app-access');
    Route::post('{gameCode}/app-authenticate', [AppAccessController::class, 'authenticate'])->middleware('throttle:game-auth')->name('game-final.app-authenticate');
    
    // Standard entry
    Route::get('{gameCode}/{userId}', [GamePageController::class, 'entryByUser'])
        ->middleware('throttle:game-entry-view')
        ->where('userId', '[0-9]+')
        ->where('gameCode', '[^/]+');
    Route::match(['GET','POST'], '{gameCode}/e', [GamePageController::class, 'entry'])->middleware('throttle:game-entry-view')->name('game-final.entry');
    Route::match(['GET','POST'], '{gameCode}/start', [GamePageController::class, 'startToPlay'])->middleware('throttle:game-start')->name('game-final.start');
});

Route::prefix(config('bd_game_final.api_prefix', 'game/api'))->group(function () {
    Route::post('{gameCode}/auth/app-access', [AppAccessController::class, 'verifyApi'])->middleware('throttle:game-auth')->name('game-final.api.app-access');
    Route::post('{gameCode}/auth/issue-entry-token', [GameApiController::class, 'issueEntryToken'])->middleware('throttle:game-auth')->name('game-final.api.issue-entry-token');
    Route::match(['GET','POST'], '{gameCode}/start-to-play', [GameApiController::class, 'startToPlay'])->middleware('throttle:game-start')->name('game-final.api.start-to-play');
    Route::get('{gameCode}/state', [GameApiController::class, 'state'])->middleware('throttle:game-state')->name('game-final.api.state');
    Route::post('{gameCode}/bet', [GameApiController::class, 'bet'])->middleware('throttle:game-bet')->name('game-final.api.bet');
    Route::post('{gameCode}/heartbeat', [GameApiController::class, 'heartbeat'])->middleware('throttle:game-heartbeat')->name('game-final.api.heartbeat');
    Route::get('{gameCode}/history', [GameApiController::class, 'history'])->middleware('throttle:game-history')->name('game-final.api.history');
    Route::get('{gameCode}/my-bets', [GameApiController::class, 'myBets'])->middleware('throttle:game-history')->name('game-final.api.my-bets');
    Route::post('{gameCode}/security-report', [GameApiController::class, 'securityReport'])->middleware('throttle:game-security-report')->name('game-final.api.security-report');
});
