<?php

namespace App\Http\Controllers\GameFinal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Support\GameFinal\GameRegistry;
use App\Services\GameFinal\GameConfigService;
use App\Services\GameFinal\GameRuntimeService;
use App\Services\GameFinal\GameTokenService;
use App\Services\GameFinal\GameUserService;
use App\Models\User;

class GamePageController extends Controller
{
    protected $tokens;
    protected $users;
    protected $configs;
    protected $runtime;

    public function __construct(GameTokenService $tokens, GameUserService $users, GameConfigService $configs, GameRuntimeService $runtime)
    {
        $this->tokens = $tokens;
        $this->users = $users;
        $this->configs = $configs;
        $this->runtime = $runtime;
    }

    protected function deviceFingerprint(Request $request)
    {
        return $this->tokens->fingerprintFromRequest($request);
    }

    protected function resolveLobbyUrl(Request $request, ?User $user = null): string
    {
        $sessionLobby = trim((string) $request->session()->get('game_final.lobby_url', ''));
        if ($sessionLobby !== '') {
            return $sessionLobby;
        }

        $sessionKey = trim((string) $request->session()->get('game_final.access_key', ''));
        if ($sessionKey !== '') {
            return route('game-final.lobby.keyed.secure', ['key' => $sessionKey]);
        }

        $queryLobby = trim((string) $request->query('lobby', ''));
        if ($queryLobby !== '' && $this->isSafeLobbyUrl($request, $queryLobby)) {
            return $queryLobby;
        }

        return route('game-final.lobby');
    }

    protected function isSafeLobbyUrl(Request $request, string $candidate): bool
    {
        if ($candidate === '') {
            return false;
        }

        if (strpos($candidate, '//') === 0) {
            return false;
        }

        $parts = parse_url($candidate);
        if ($parts === false) {
            return false;
        }

        if (!isset($parts['scheme']) && !isset($parts['host'])) {
            return str_starts_with($candidate, '/');
        }

        $root = parse_url($request->root());
        if (!is_array($root)) {
            return false;
        }

        $candidateHost = strtolower((string) ($parts['host'] ?? ''));
        $rootHost = strtolower((string) ($root['host'] ?? ''));
        if ($candidateHost === '' || $rootHost === '' || $candidateHost !== $rootHost) {
            return false;
        }

        $candidateScheme = strtolower((string) ($parts['scheme'] ?? ''));
        $rootScheme = strtolower((string) ($root['scheme'] ?? ''));

        return $candidateScheme !== '' && $candidateScheme === $rootScheme;
    }

    protected function blockedResponse(Request $request, string $message, ?string $reason = null)
    {
        $lobbyUrl = $this->resolveLobbyUrl($request);
        $payload = [
            'st' => false,
            'code' => 'blocked_by_jamboai',
            'message' => $message,
            'reason' => $reason,
            'lobby_url' => $lobbyUrl,
        ];

        if ($request->expectsJson() || $request->wantsJson() || $request->ajax()) {
            return response()->json($payload, 423);
        }

        $reasonText = $reason ? e($reason) : e($message);
        $lobby = e($lobbyUrl);

        return response(
            '<!doctype html><html><head><meta name="viewport" content="width=device-width,initial-scale=1"><title>JAMBOai Blocked</title><style>body{margin:0;min-height:100vh;display:grid;place-items:center;background:#09070f;color:#fff;font-family:Arial,sans-serif}.card{width:min(92vw,520px);padding:28px;border:1px solid rgba(255,215,115,.45);border-radius:18px;background:linear-gradient(145deg,rgba(32,10,22,.94),rgba(4,18,31,.94));box-shadow:0 30px 90px rgba(0,0,0,.45);text-align:center}.title{font-size:24px;font-weight:900;color:#ffd36b}.msg{margin-top:14px;font-size:16px;line-height:1.5}.btn{display:inline-block;margin-top:22px;padding:12px 18px;border-radius:999px;background:#ffd36b;color:#120b05;text-decoration:none;font-weight:900}</style></head><body><div class="card"><div class="title">JAMBOai Security</div><div class="msg">You have been blocked by JAMBOai for reason "' . $reasonText . '".</div><a class="btn" href="' . $lobby . '">Lobby</a></div></body></html>',
            423
        );
    }

    protected function lobbyRetryResponse(Request $request, string $message = 'Session expired. Please try again from lobby.')
    {
        $lobby = $this->resolveLobbyUrl($request);

        if ($request->expectsJson() || $request->wantsJson() || $request->ajax()) {
            return response()->json([
                'st' => false,
                'code' => 'session_retry_required',
                'message' => $message,
                'lobby_url' => $lobby,
                'refresh_url' => $lobby,
            ], 409);
        }

        return redirect()->to($lobby);
    }

    public function startToPlay(Request $request, $gameCode)
    {
        abort_unless(config('bd_game_final.auto_start_to_play_enabled', true), 404);

        [$user, $reason] = $this->users->resolvePlayableUser($request, $gameCode);
        if (!$user && $reason === 'blocked_by_jamboai') {
            return $this->blockedResponse($request, 'You have been blocked by JAMBOai.', 'Account access was locked by JAMBOai security.');
        }
        if (!$user) {
            return $this->lobbyRetryResponse($request, $reason ?: 'User required. Please try again from lobby.');
        }

        $device = $this->deviceFingerprint($request);
        $entryToken = $this->tokens->issueEntryToken($gameCode, $user->id, $device, [
            'issued_from' => auth()->check() ? 'page_start_to_play_auth' : 'page_start_to_play_api_token',
        ]);
        $plainEntryToken = $entryToken['plain_token'] ?? null;
        abort_unless($plainEntryToken, 404, 'invalid_game_code');

        $request->session()->put('game_final.entry_tokens.' . $gameCode, $plainEntryToken);
        $url = route('game-final.entry', ['gameCode' => $gameCode]);
        if ($request->expectsJson() || $request->wantsJson() || $request->ajax()) {
            return response()->json([
                'st' => true,
                'game_code' => $gameCode,
                'game_token' => $plainEntryToken,
                'entry_url' => $url,
            ]);
        }

        $request->session()->put('game_final.lobby_url', $this->resolveLobbyUrl($request, $user));

        $request->session()->save();

        return redirect()->to($url);
    }

    public function entryByUser(Request $request, string $gameCode, int $userId)
    {
        if (!config('bd_game_final.allow_user_id_issue_token', false)) {
            return $this->lobbyRetryResponse($request, 'Direct user access is disabled. Start from the lobby with email or API token.');
        }

        $gameCode = trim($gameCode);
        abort_unless($gameCode !== '', 404);

        $user = User::query()->find((int) $userId);
        if (!$user) {
            return redirect()->route('game-final.lobby');
        }

        $play = $this->users->canPlay($user, $gameCode);
        if (empty($play['ok'])) {
            if (($play['reason'] ?? null) === 'blocked_by_jamboai') {
                return $this->blockedResponse($request, 'You have been blocked by JAMBOai.', $play['block_reason'] ?? null);
            }

            return redirect()->route('game-final.lobby');
        }

        $device = $this->deviceFingerprint($request);
        try {
            $session = $this->tokens->issueSessionToken($gameCode, $user->id, null, $device, [
                'issued_from' => 'direct_user_id_entry',
                'entry_source' => 'user_id_path',
                'requested_user_id' => (int) $user->id,
            ]);
        } catch (\RuntimeException $e) {
            return $this->lobbyRetryResponse($request, $e->getMessage());
        }

        $sessionToken = $session['plain_token'] ?? null;
        abort_unless($sessionToken, 404, 'invalid_game_code');

        $request->session()->put('game_final.session_tokens.' . $gameCode, $sessionToken);

        return redirect()->route('game-final.entry', ['gameCode' => $gameCode]);
    }

    public function entry(Request $request, $gameCode)
    {
        $this->runtime->applyToConfig();
        $view = GameRegistry::view($gameCode);
        abort_unless($view, 404);
        $config = $this->configs->get($gameCode);

        $device = $this->deviceFingerprint($request);
        $sessionToken = null;
        $displayUser = null;
        $entryStoreKey = 'game_final.entry_tokens.' . $gameCode;
        $entryToken = $request->session()->get($entryStoreKey)
            ?: $request->header('X-Game-Entry')
            ?: $request->post('game_token');
        if (!$entryToken && config('bd_game_final.allow_url_entry_tokens', false)) {
            $entryToken = $request->query('game_token');
        }
        $sessionStoreKey = 'game_final.session_tokens.' . $gameCode;
        $providedSessionToken = $request->header('X-Game-Session') ?: $request->session()->get($sessionStoreKey);

        if ($entryToken) {
            try {
                $exchanged = $this->tokens->exchangeEntryToSession(
                    $gameCode,
                    $entryToken,
                    $device,
                    $request->ip(),
                    $request->userAgent(),
                    [],
                    $this->tokens->clientKeyFromRequest($request)
                );
            } catch (\RuntimeException $e) {
                if (strpos($e->getMessage(), 'blocked by JAMBOai') !== false) {
                    return $this->blockedResponse($request, $e->getMessage(), $e->getMessage());
                }

                return $this->lobbyRetryResponse($request, $e->getMessage());
            }
            abort_unless($exchanged, 401, 'invalid_game_token');
            $sessionToken = $exchanged['session_token'];
            $request->session()->forget($entryStoreKey);
            $request->session()->put($sessionStoreKey, $sessionToken);
            $request->session()->put('game_final.lobby_url', $this->resolveLobbyUrl($request));

            /**
             * Important: Avoid an extra redirect hop after exchanging entry->session.
             *
             * Some embedded/in-app browser environments may not reliably persist the newly
             * written session state between two immediate redirects, which can cause users
             * to bounce back to the lobby with "token required". Rendering the page in the
             * same request keeps the flow production-safe and stable.
             */
            $status = $this->tokens->sessionTokenStatus(
                $sessionToken,
                $gameCode,
                $request->ip(),
                $request->userAgent(),
                $this->tokens->clientKeyFromRequest($request),
                $device
            );
            if (empty($status['ok'])) {
                $code = (string) ($status['code'] ?? 'invalid_session');
                if ($code === 'duplicate_device') {
                    return redirect()->route('game-final.lobby');
                }
                if ($code === 'blocked_by_jamboai') {
                    return $this->blockedResponse($request, (string) ($status['message'] ?? 'You have been blocked by JAMBOai.'), $status['reason'] ?? null);
                }
                return $this->lobbyRetryResponse($request);
            }

            $displayUser = $status['user'];
            $request->session()->put('game_final.lobby_url', $this->resolveLobbyUrl($request, $displayUser));
            $request->session()->put($sessionStoreKey, $sessionToken);
            $request->session()->save();
        } elseif ($providedSessionToken) {
            $status = $this->tokens->sessionTokenStatus(
                $providedSessionToken,
                $gameCode,
                $request->ip(),
                $request->userAgent(),
                $this->tokens->clientKeyFromRequest($request),
                $device
            );
            if (empty($status['ok'])) {
                $code = (string) ($status['code'] ?? 'invalid_session');
                if ($code === 'duplicate_device') {
                    return redirect()->route('game-final.lobby');
                }
                if ($code === 'blocked_by_jamboai') {
                    return $this->blockedResponse($request, (string) ($status['message'] ?? 'You have been blocked by JAMBOai.'), $status['reason'] ?? null);
                }
                return $this->lobbyRetryResponse($request);
            }
            $sessionUser = $status['user'];
            $sessionToken = $providedSessionToken;
            $displayUser = $sessionUser;
            $request->session()->put('game_final.lobby_url', $this->resolveLobbyUrl($request, $sessionUser));
            $request->session()->put($sessionStoreKey, $sessionToken);
        } else {
            $reason = null;
            if (auth()->check() || config('bd_game_final.allow_direct_api_token_entry', false)) {
                [$user, $reason] = $this->users->resolvePlayableUser($request, $gameCode);
            } else {
                $user = null;
                $reason = 'game_session_required';
            }

            if ($user && config('bd_game_final.allow_auth_fallback_entry', false)) {
                try {
                    $session = $this->tokens->issueSessionToken($gameCode, $user->id, null, $device, [
                        'issued_from' => auth()->check() ? 'auth_fallback_entry' : 'api_token_direct_entry',
                    ]);
                } catch (\RuntimeException $e) {
                    return $this->lobbyRetryResponse($request, $e->getMessage());
                }
                $sessionToken = $session['plain_token'] ?? null;
                $displayUser = $user;
                $request->session()->put('game_final.lobby_url', $this->resolveLobbyUrl($request, $user));
                if ($sessionToken) {
                    $request->session()->put($sessionStoreKey, $sessionToken);
                }
            } elseif (config('bd_game_final.require_entry_token', true)) {
                if ($reason === 'blocked_by_jamboai') {
                    return $this->blockedResponse($request, 'You have been blocked by JAMBOai.', 'Account access was locked by JAMBOai security.');
                }
                return $this->lobbyRetryResponse($request, $reason ?: 'Game token required. Please try again from lobby.');
            }
        }

        $displayName = null;
        $displayUserId = null;
        if ($displayUser) {
            $displayUserId = $displayUser->id;
            $displayName = trim((string) ($displayUser->name ?? '')) ?: ('Player ' . $displayUserId);
        }

        $maintenance = $this->runtime->maintenanceState($gameCode, $displayUser);
        if (!empty($maintenance['active']) && empty($maintenance['allowed'])) {
            return response()->view('game_final.maintenance', [
                'gameCode' => $gameCode,
                'gameName' => (string) ($config['name'] ?? $gameCode),
                'message' => (string) ($maintenance['message'] ?? 'This game is in maintenance. Please wait.'),
                'sessionToken' => $sessionToken,
                'stateUrl' => route('game-final.api.state', ['gameCode' => $gameCode]),
            ], 503);
        }

        return view($view, [
            'gameCode' => $gameCode,
            'gameToken' => $entryToken,
            'sessionToken' => $sessionToken,
            'displayUserName' => $displayName,
            'displayUserId' => $displayUserId,
            'gameRules' => $config['rules'] ?? [],
            'gameTheme' => $config['ui_theme'] ?? [],
            'lobbyUrl' => $this->resolveLobbyUrl($request, $displayUser),
        ]);
    }
}
