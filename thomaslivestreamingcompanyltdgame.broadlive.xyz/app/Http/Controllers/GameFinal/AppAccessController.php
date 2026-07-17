<?php

namespace App\Http\Controllers\GameFinal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GameFinal\AppPackageVerificationService;
use App\Services\GameFinal\GameTokenService;
use App\Services\GameFinal\GameUserService;
use App\Models\GameFinal\Game;

class AppAccessController extends Controller
{
    protected $verification;
    protected $tokens;
    protected $users;

    public function __construct(AppPackageVerificationService $verification, GameTokenService $tokens, GameUserService $users)
    {
        $this->verification = $verification;
        $this->tokens = $tokens;
        $this->users = $users;
    }

    protected function appAccessDisabledResponse(Request $request)
    {
        $message = 'Direct app access is disabled. Use email or API token entry from the lobby.';

        if ($request->expectsJson() || $request->wantsJson() || $request->ajax()) {
            return response()->json([
                'st' => false,
                'code' => 'app_access_disabled',
                'message' => $message,
            ], 403);
        }

        return response($message, 403);
    }

    public function verify(Request $request, $gameCode)
    {
        if (!config('bd_game_final.allow_app_access_entry', false)) {
            return $this->appAccessDisabledResponse($request);
        }

        $game = Game::where('game_code', $gameCode)->where('is_active', 1)->first();
        abort_unless($game, 404, 'Game not found');

        $verification = $this->verification->verifyAppAccess($request);
        if ($verification && !empty($verification['verified'])) {
            return $this->grantAccess($request, $gameCode, $verification);
        }

        return $this->showAuthUI($request, $gameCode);
    }

    public function authenticate(Request $request, $gameCode)
    {
        if (!config('bd_game_final.allow_app_access_entry', false)) {
            return $this->appAccessDisabledResponse($request);
        }

        $game = Game::where('game_code', $gameCode)->where('is_active', 1)->first();
        abort_unless($game, 404, 'Game not found');

        $request->validate([
            'password' => 'required|string|max:200',
        ]);

        if (!$this->verification->passwordAuthAvailable()) {
            return redirect()->back()
                ->withErrors(['password' => 'Developer authentication is not configured.'])
                ->withInput();
        }

        $verification = $this->verification->verifyAppAccess($request);
        if (!$verification || empty($verification['verified'])) {
            return redirect()->back()
                ->withErrors(['password' => 'Invalid authentication or app access user is not configured.'])
                ->withInput();
        }

        return $this->grantAccess($request, $gameCode, $verification);
    }

    protected function grantAccess(Request $request, $gameCode, array $verification)
    {
        $user = $verification['user'];
        if (!$user) {
            return response()->json([
                'st' => false,
                'code' => 'app_access_user_not_configured',
                'message' => 'App access user is not configured.',
            ], 403);
        }

        $play = $this->users->canPlay($user, $gameCode);
        if (empty($play['ok'])) {
            return response()->json([
                'st' => false,
                'code' => (string) ($play['reason'] ?? 'user_not_allowed'),
                'message' => (string) ($play['message'] ?? $play['block_reason'] ?? 'User cannot play this game.'),
                'reason' => $play['block_reason'] ?? null,
            ], 423);
        }

        $device = $this->tokens->fingerprintFromRequest($request);

        $entryToken = $this->tokens->issueEntryToken($gameCode, $user->id, $device, [
            'issued_from' => 'app_access',
            'verification_reason' => $verification['reason'] ?? 'unknown',
            'package' => $this->verification->getPackageFromRequest($request),
        ]);

        $plainToken = $entryToken['plain_token'] ?? null;
        abort_unless($plainToken, 500, 'Failed to issue entry token');

        $request->session()->put('game_final.entry_tokens.' . $gameCode, $plainToken);
        $url = route('game-final.entry', ['gameCode' => $gameCode]);

        return redirect()->to($url);
    }

    protected function showAuthUI(Request $request, $gameCode)
    {
        $game = Game::where('game_code', $gameCode)->where('is_active', 1)->first();

        $unverifiedResponse = $this->verification->getUnverifiedResponse($request);
        $package = $this->verification->getPackageFromRequest($request);

        return view('game_final.app_auth.verify', [
            'gameCode' => $gameCode,
            'gameName' => $game->name ?? 'Game',
            'packageDetected' => $package,
            'packageAllowed' => $package ? $this->verification->isPackageAllowed($package) : false,
            'message' => $unverifiedResponse['message'],
            'requiresPassword' => $unverifiedResponse['requires_password'],
        ]);
    }

    public function verifyApi(Request $request, $gameCode)
    {
        if (!config('bd_game_final.allow_app_access_entry', false)) {
            return $this->appAccessDisabledResponse($request);
        }

        $game = Game::where('game_code', $gameCode)->where('is_active', 1)->first();
        if (!$game) {
            return response()->json(['st' => false, 'error' => 'game_not_found'], 404);
        }

        $verification = $this->verification->verifyAppAccess($request);

        if ($verification && !empty($verification['verified'])) {
            $user = $verification['user'];
            $device = $this->tokens->fingerprintFromRequest($request);

            $entryToken = $this->tokens->issueEntryToken($gameCode, $user->id, $device, [
                'issued_from' => 'app_access_api',
                'verification_reason' => $verification['reason'] ?? 'unknown',
            ]);

            $plainToken = $entryToken['plain_token'] ?? null;

            if ($plainToken) {
                return response()->json([
                    'st' => true,
                    'game_code' => $gameCode,
                    'game_token' => $plainToken,
                    'entry_url' => route('game-final.entry', ['gameCode' => $gameCode]),
                ]);
            }

            return response()->json(['st' => false, 'error' => 'token_issue_failed'], 500);
        }

        return response()->json($this->verification->getUnverifiedResponse($request), 401);
    }
}
