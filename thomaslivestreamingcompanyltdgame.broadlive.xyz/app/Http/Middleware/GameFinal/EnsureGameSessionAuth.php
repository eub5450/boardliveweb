<?php

namespace App\Http\Middleware\GameFinal;

use Closure;
use Illuminate\Http\Request;
use App\Services\GameFinal\GameTokenService;

/**
 * Middleware to ensure game session authentication
 * All game API endpoints require valid session token or logged-in user
 */
class EnsureGameSessionAuth
{
    protected function lobbyUrl(Request $request): string
    {
        $sessionLobby = trim((string) $request->session()->get('game_final.lobby_url', ''));
        if ($sessionLobby !== '') {
            return $sessionLobby;
        }

        return route('game-final.lobby');
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $lobbyUrl = $this->lobbyUrl($request);

        // Get session token from header or query param
        $sessionToken = $request->header('X-Game-Session')
            ?: $request->post('session_token');

        // Check if we have a valid session
        if (!$sessionToken && !auth()->check()) {
            // No session token and not authenticated
            if ($request->expectsJson() || $request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'st' => false,
                    'code' => 'session_retry_required',
                    'error' => 'session_retry_required',
                    'message' => 'Please start again from lobby for a new game token.',
                    'lobby_url' => $lobbyUrl,
                    'refresh_url' => $lobbyUrl,
                ], 409);
            }

            // Redirect to app access page if it's a game entry
            $gameCode = $request->route('gameCode');
            if ($gameCode) {
                return redirect()->route('game-final.app-access', ['gameCode' => $gameCode])
                    ->withInput();
            }

            return redirect()->to($lobbyUrl)
                ->with('error', 'Authentication required');
        }

        if ($sessionToken) {
            $gameCode = $request->route('gameCode');
            /** @var GameTokenService $tokens */
            $tokens = app(GameTokenService::class);
            $status = $tokens->sessionTokenStatus(
                (string) $sessionToken,
                $gameCode ? (string) $gameCode : null,
                $request->ip(),
                $request->userAgent(),
                $tokens->clientKeyFromRequest($request),
                $tokens->fingerprintFromRequest($request)
            );

            if (empty($status['ok'])) {
                if ($request->expectsJson() || $request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'st' => false,
                        'code' => $status['code'] ?? 'session_retry_required',
                        'error' => $status['code'] ?? 'session_retry_required',
                        'message' => $status['message'] ?? 'Please start again from lobby for a new game token.',
                        'reason' => $status['reason'] ?? null,
                        'lobby_url' => $lobbyUrl,
                        'refresh_url' => $lobbyUrl,
                    ], in_array(($status['code'] ?? ''), ['duplicate_device', 'blocked_by_jamboai'], true) ? 423 : 409);
                }

                return redirect()->to($lobbyUrl)
                    ->with('error', 'Session expired. Please enter again.');
            }
        }

        return $next($request);
    }
}
