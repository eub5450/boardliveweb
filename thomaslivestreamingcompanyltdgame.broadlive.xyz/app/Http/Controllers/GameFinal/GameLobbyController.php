<?php

namespace App\Http\Controllers\GameFinal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\GameFinal\Game;
use App\Services\GameFinal\GameTokenService;
use App\Services\GameFinal\GameUserService;
use App\Services\GameFinal\GameBankService;
use App\Services\GameFinal\WalletService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Crypt;

class GameLobbyController extends Controller
{
    protected $tokens;
    protected $users;
    protected $wallets;
    protected $gameBank;

    public function __construct(GameTokenService $tokens, GameUserService $users, WalletService $wallets, GameBankService $gameBank)
    {
        $this->tokens = $tokens;
        $this->users = $users;
        $this->wallets = $wallets;
        $this->gameBank = $gameBank;
    }

    protected function deviceFingerprint(Request $request)
    {
        return $this->tokens->fingerprintFromRequest($request);
    }

    protected function gameFamily($gameCode)
    {
        if (str_starts_with($gameCode, 'teen_patti')) {
            return 'teen_patti';
        }

        if ($gameCode === 'lucky7_pro' || $gameCode === 'lucky88_master' || str_starts_with($gameCode, 'lucky77')) {
            return 'lucky77';
        }

        if ($gameCode === 'greedy') {
            return 'greedy';
        }

        if (str_starts_with($gameCode, 'fruit_slot') || str_starts_with($gameCode, 'fruits_loop')) {
            return 'fruit_slot';
        }

        return 'unknown';
    }

    protected function gameIcon($gameCode)
    {
        return match ($this->gameFamily($gameCode)) {
            'teen_patti' => '♠',
            'lucky77' => '⑦',
            'greedy' => '🍽',
            'fruit_slot' => '🍒',
            default => '🎮',
        };
    }

    protected function gameTagline($gameCode)
    {
        $cfg = (array) config('bd_game_final.games.' . $gameCode, []);
        $boardCount = count((array) ($cfg['boards'] ?? []));
        $betDuration = (int) ($cfg['bet_duration_sec'] ?? 0);

        if ($boardCount > 0 && $betDuration > 0) {
            return $boardCount . ' board · ' . $betDuration . 's bid';
        }

        return 'Play now';
    }

    protected function gameCardProfile($gameCode)
    {
        $cfg = (array) config('bd_game_final.games.' . $gameCode, []);
        $boardCount = count((array) ($cfg['boards'] ?? []));
        $betDuration = (int) ($cfg['bet_duration_sec'] ?? 0);
        $bannerBase = 'game_final_assets/lobby_banners/';
        $bannerMap = [
            'teen_patti' => 'teen_patti_mega_win.webp',
            'teen_patti_king' => 'teen_patti_lucky_cards.webp',
            'teen_patti_sultan' => 'teen_patti_chips_rush.webp',
            'teen_patti_warfront' => 'teen_patti_money_blast.webp',
            'teen_patti_neon' => 'teen_patti_happy_jackpot.webp',
            'teen_patti_shogun' => 'teen_patti_lucky_cards.webp',
            'teen_patti_glacier' => 'teen_patti_chips_rush.webp',
            'lucky77' => 'lucky77_purple.webp',
            'lucky77_max' => 'lucky77_green.webp',
            'lucky7_pro' => 'lucky77_purple.webp',
            'lucky88_master' => 'lucky77_red_money.webp',
            'lucky77_mirage' => 'lucky77_green.webp',
            'lucky77_ironfront' => 'lucky77_red_money.webp',
            'lucky77_lotus' => 'lucky77_green.webp',
            'lucky77_nebula' => 'lucky77_purple.webp',
            'lucky77_carnival' => 'lucky77_red_money.webp',
            'fruit_slot' => 'fruit_slot_tropical_jackpot.webp',
            'fruit_slot_oasis' => 'fruit_slot_oasis.webp',
            'fruit_slot_arsenal' => 'fruit_slot_citrus.webp',
            'fruit_slot_arcade' => 'fruit_slot_arcade.webp',
            'fruit_slot_lotus' => 'fruit_slot_oasis.webp',
            'fruit_slot_glacier' => 'fruit_slot_glacier.webp',
            'greedy' => 'fruit_slot_tropical_jackpot.webp',
            'fruits_loop' => 'fruits_loop_big_win.webp',
            'fruits_loop_ruby' => 'fruits_loop_big_win.webp',
            'fruits_loop_emerald' => 'fruits_loop_big_win.webp',
        ];

        $profiles = [
            'teen_patti' => [
                'icon' => '♠',
                'badge' => 'Classic Table',
                'tagline' => 'Original three-seat Teen Patti room with the base live flow.',
                'preview' => ['A', 'B', 'C'],
                'motif' => 'CARD',
                'palette' => ['start' => '#2c1647', 'end' => '#090d18', 'border' => 'rgba(217,162,255,.28)', 'glow' => 'rgba(162,92,255,.34)'],
            ],
            'teen_patti_king' => [
                'icon' => '👑',
                'badge' => 'Royal Room',
                'tagline' => 'Gold-trimmed high table with King, Queen, and Ace seat identity.',
                'preview' => ['KING', 'QUEEN', 'ACE'],
                'motif' => 'ROYAL',
                'palette' => ['start' => '#4a2b0b', 'end' => '#120a04', 'border' => 'rgba(255,214,112,.30)', 'glow' => 'rgba(255,199,83,.34)'],
            ],
            'teen_patti_sultan' => [
                'icon' => '☾',
                'badge' => 'Lantern Palace',
                'tagline' => 'Desert palace table with Ruby, Dune, and Crown seats.',
                'preview' => ['RUBY', 'DUNE', 'CROWN'],
                'motif' => 'PALACE',
                'palette' => ['start' => '#5b2b0f', 'end' => '#160b05', 'border' => 'rgba(255,198,114,.28)', 'glow' => 'rgba(255,157,74,.30)'],
            ],
            'teen_patti_warfront' => [
                'icon' => '🛡',
                'badge' => 'War Command',
                'tagline' => 'Armored command deck with Alpha, Fort, and Raven battle seats.',
                'preview' => ['ALPHA', 'FORT', 'RAVEN'],
                'motif' => 'STEEL',
                'palette' => ['start' => '#2d313a', 'end' => '#0b0d11', 'border' => 'rgba(154,170,189,.28)', 'glow' => 'rgba(124,141,161,.26)'],
            ],
            'teen_patti_neon' => [
                'icon' => '🩸',
                'badge' => 'Crimson Blood',
                'tagline' => 'Blood glam table with Rose, Vixen, and Noir seats in a dedicated room view.',
                'preview' => ['ROSE', 'VIXEN', 'NOIR'],
                'motif' => 'CRIMSON',
                'palette' => ['start' => '#4a0015', 'end' => '#090004', 'border' => 'rgba(255,112,146,.30)', 'glow' => 'rgba(255,34,92,.34)'],
            ],
            'teen_patti_shogun' => [
                'icon' => '⛩',
                'badge' => 'Shogun Court',
                'tagline' => 'Lacquered court table with Ronin, Katana, and Shiro seats.',
                'preview' => ['RONIN', 'KATANA', 'SHIRO'],
                'motif' => 'DOJO',
                'palette' => ['start' => '#4a1314', 'end' => '#120405', 'border' => 'rgba(255,173,128,.26)', 'glow' => 'rgba(214,58,53,.28)'],
            ],
            'teen_patti_glacier' => [
                'icon' => '❄',
                'badge' => 'Ice Vault',
                'tagline' => 'Crystal table with Frost, Aurora, and Cryo seat lanes.',
                'preview' => ['FROST', 'AURORA', 'CRYO'],
                'motif' => 'ICE',
                'palette' => ['start' => '#0b3342', 'end' => '#041018', 'border' => 'rgba(131,224,255,.28)', 'glow' => 'rgba(120,208,255,.30)'],
            ],
            'lucky77' => [
                'icon' => '⑦',
                'badge' => 'Classic Wheel',
                'tagline' => 'Original melon, 77, and berry wheel room.',
                'preview' => ['MELON', '77', 'BERRY'],
                'motif' => 'WHEEL',
                'palette' => ['start' => '#30256f', 'end' => '#0b0f22', 'border' => 'rgba(135,116,255,.28)', 'glow' => 'rgba(80,145,255,.30)'],
            ],
            'lucky7_pro' => [
                'icon' => '♛',
                'badge' => 'Crown Lounge',
                'tagline' => 'Dedicated pro lounge with Crown, 77, and Laurel lanes around the live jackpot core.',
                'preview' => ['CROWN', '77', 'LAUREL'],
                'motif' => 'CROWN',
                'palette' => ['start' => '#0f4e43', 'end' => '#051210', 'border' => 'rgba(132,244,211,.30)', 'glow' => 'rgba(255,214,122,.22)'],
            ],
            'lucky88_master' => [
                'icon' => '🐉',
                'badge' => 'Dragon Wheel',
                'tagline' => 'Dedicated gold-and-crimson master hall with Dragon, 88, and Ember gates.',
                'preview' => ['DRAGON', '88', 'EMBER'],
                'motif' => 'DRAGON',
                'palette' => ['start' => '#5a2706', 'end' => '#120603', 'border' => 'rgba(255,219,135,.30)', 'glow' => 'rgba(255,77,37,.28)'],
            ],
            'lucky77_mirage' => [
                'icon' => '☀',
                'badge' => 'Mirage Hall',
                'tagline' => 'Desert brass wheel with Crescent, 77, and Dune Star lanes.',
                'preview' => ['CM', '77', 'DS'],
                'motif' => 'DUNE',
                'palette' => ['start' => '#6a3516', 'end' => '#140804', 'border' => 'rgba(255,194,126,.28)', 'glow' => 'rgba(255,159,89,.30)'],
            ],
            'lucky77_ironfront' => [
                'icon' => '⚙',
                'badge' => 'Iron Vault',
                'tagline' => 'Forged tactical wheel with Axe, 77, and Shield lanes.',
                'preview' => ['AX', '77', 'SH'],
                'motif' => 'FORGE',
                'palette' => ['start' => '#353c47', 'end' => '#0c1016', 'border' => 'rgba(170,182,196,.28)', 'glow' => 'rgba(113,126,145,.28)'],
            ],
            'lucky77_lotus' => [
                'icon' => '✿',
                'badge' => 'Silk Wheel',
                'tagline' => 'Lacquered lotus hall with Lotus, 77, and Koi lanes.',
                'preview' => ['LT', '77', 'KO'],
                'motif' => 'LOTUS',
                'palette' => ['start' => '#4b1432', 'end' => '#13040d', 'border' => 'rgba(255,174,212,.28)', 'glow' => 'rgba(255,121,186,.28)'],
            ],
            'lucky77_nebula' => [
                'icon' => '☄',
                'badge' => 'Orbit Deck',
                'tagline' => 'Starfield wheel with Nova, 77, and Star lanes.',
                'preview' => ['NV', '77', 'ST'],
                'motif' => 'COSMOS',
                'palette' => ['start' => '#172552', 'end' => '#040915', 'border' => 'rgba(120,193,255,.28)', 'glow' => 'rgba(149,111,255,.28)'],
            ],
            'lucky77_carnival' => [
                'icon' => '✹',
                'badge' => 'Festival Wheel',
                'tagline' => 'Street carnival wheel with Mask, 77, and Drum lanes.',
                'preview' => ['MK', '77', 'DR'],
                'motif' => 'PARADE',
                'palette' => ['start' => '#74201f', 'end' => '#190705', 'border' => 'rgba(255,171,118,.28)', 'glow' => 'rgba(255,92,92,.28)'],
            ],
            'fruit_slot' => [
                'icon' => '🍒',
                'badge' => 'Classic Reels',
                'tagline' => 'Standard fruit room with clean reel boards and fast chips.',
                'preview' => ['CHERRY', 'LEMON', 'BONUS'],
                'motif' => 'REELS',
                'palette' => ['start' => '#5a1f2a', 'end' => '#12080d', 'border' => 'rgba(255,150,171,.28)', 'glow' => 'rgba(255,92,124,.28)'],
            ],
            'fruit_slot_oasis' => [
                'icon' => '🏺',
                'badge' => 'Oasis Reels',
                'tagline' => 'Desert fruit room with oasis tiles and warm palace glow.',
                'preview' => ['PALM', 'DATE', 'GOLD'],
                'motif' => 'OASIS',
                'palette' => ['start' => '#6d3d10', 'end' => '#160803', 'border' => 'rgba(255,200,122,.28)', 'glow' => 'rgba(255,149,62,.30)'],
            ],
            'fruit_slot_arsenal' => [
                'icon' => '🧨',
                'badge' => 'Arsenal Reels',
                'tagline' => 'Hard-edge reel room with steel cabinet energy and combat accents.',
                'preview' => ['STEEL', 'BOLT', 'RUSH'],
                'motif' => 'ARMOR',
                'palette' => ['start' => '#3d424c', 'end' => '#0b0e13', 'border' => 'rgba(178,188,202,.28)', 'glow' => 'rgba(108,118,133,.28)'],
            ],
            'fruit_slot_arcade' => [
                'icon' => '🕹',
                'badge' => 'Pixel Vault',
                'tagline' => 'Dedicated arcade cabinet with eight pixel reels, CRT timer glass, and live chip taps.',
                'preview' => ['APPLE', 'CHERRY', 'PINE'],
                'motif' => 'PIXEL',
                'palette' => ['start' => '#153b8b', 'end' => '#030712', 'border' => 'rgba(144,185,255,.30)', 'glow' => 'rgba(78,255,211,.26)'],
            ],
            'fruit_slot_lotus' => [
                'icon' => '✿',
                'badge' => 'Lotus Reels',
                'tagline' => 'Silk garden reel room with jade chips and ink-black tiles.',
                'preview' => ['LOTUS', 'KOI', 'JADE'],
                'motif' => 'GARDEN',
                'palette' => ['start' => '#4d1c35', 'end' => '#12040e', 'border' => 'rgba(255,171,214,.28)', 'glow' => 'rgba(111,223,179,.22)'],
            ],
            'fruit_slot_glacier' => [
                'icon' => '❄',
                'badge' => 'Glacier Reels',
                'tagline' => 'Icy reel room with crystal tiles and frosted payout accents.',
                'preview' => ['FROST', 'ICE', 'SHINE'],
                'motif' => 'GLACIER',
                'palette' => ['start' => '#0d3744', 'end' => '#041018', 'border' => 'rgba(128,225,255,.28)', 'glow' => 'rgba(91,190,255,.28)'],
            ],
            'greedy' => [
                'icon' => '🍽',
                'badge' => 'Glass Feast',
                'tagline' => 'Greedy is the dedicated eight-board feast room with glass cards, orbit light, and fast payout taps.',
                'preview' => ['APPLE', 'MANGO', 'PINE'],
                'motif' => 'GREEDY',
                'palette' => ['start' => '#421a38', 'end' => '#070b17', 'border' => 'rgba(255,164,195,.28)', 'glow' => 'rgba(118,242,255,.22)'],
            ],
        ];

        $profiles['fruits_loop'] = [
            'icon' => 'FL',
            'badge' => 'Loop Room',
            'tagline' => 'Portrait fruit loop room with three wheel boards, real wallet bets, and audited result payouts.',
            'preview' => ['LOOP', 'FRUIT', 'WIN'],
            'motif' => 'LOOP',
            'palette' => ['start' => '#18225f', 'end' => '#07101f', 'border' => 'rgba(255,218,118,.30)', 'glow' => 'rgba(35,211,166,.28)'],
        ];
        $profiles['fruits_loop_ruby'] = [
            'icon' => 'FL',
            'badge' => 'Ruby Loop',
            'tagline' => 'Cherry, pineapple, and grapes loop room with ruby-and-gold wheel art.',
            'preview' => ['CHERRY', 'PINE', 'GRAPE'],
            'motif' => 'RUBY',
            'palette' => ['start' => '#5d1218', 'end' => '#1a0508', 'border' => 'rgba(255,194,106,.34)', 'glow' => 'rgba(255,84,120,.30)'],
        ];
        $profiles['fruits_loop_emerald'] = [
            'icon' => 'FL',
            'badge' => 'Emerald Loop',
            'tagline' => 'Silver-and-emerald loop room with cherry, pineapple, and grapes wheel lanes.',
            'preview' => ['CHERRY', 'PINE', 'GRAPE'],
            'motif' => 'EMERALD',
            'palette' => ['start' => '#0f3940', 'end' => '#071217', 'border' => 'rgba(142,232,255,.30)', 'glow' => 'rgba(56,224,184,.26)'],
        ];

        $profile = $profiles[$gameCode] ?? [
            'icon' => $this->gameIcon($gameCode),
            'badge' => 'Live Room',
            'tagline' => $this->gameTagline($gameCode),
            'preview' => ['LIVE', 'PLAY', 'NOW'],
            'motif' => 'LIVE',
            'palette' => ['start' => '#25386d', 'end' => '#0a0f20', 'border' => 'rgba(136,161,255,.24)', 'glow' => 'rgba(86,124,255,.24)'],
        ];

        $profile['family'] = match ($this->gameFamily($gameCode)) {
            'teen_patti' => 'Teen Patti',
            'lucky77' => 'Lucky Wheel',
            'greedy' => 'Greedy',
            'fruit_slot' => 'Fruit Slot',
            default => 'Live Game',
        };
        $profile['meta_line'] = $boardCount > 0 && $betDuration > 0
            ? $boardCount . ' board · ' . $betDuration . 's live bet'
            : 'Instant live entry';

        $profile['banner'] = asset($bannerBase . ($bannerMap[$gameCode] ?? 'lucky77_purple.webp'));

        return $profile;
    }

    protected function lobbyGames($accessKey = null, string $apiToken = '', ?User $lobbyUser = null, ?Request $request = null)
    {
        $apiToken = trim($apiToken);

        return Game::query()
            ->with('setting')
            ->where('is_active', 1)
            ->whereNotIn('game_code', $this->hiddenLobbyGameCodes())
            ->orderBy('sort_order')
            ->get()
            ->map(function ($game) use ($accessKey, $apiToken, $lobbyUser) {
                $gameCode = $game->game_code;
                $entryUrl = $accessKey
                    ? route('game-final.keyed-lobby.start', ['key' => $accessKey, 'gameCode' => $gameCode])
                    : route('game-final.lobby.start', ['gameCode' => $gameCode]);

                $profile = array_merge([
                    'game_code' => $gameCode,
                    'name' => $game->name,
                    'entry_url' => $entryUrl,
                    'game_token' => null,
                ], $this->gameCardProfile($gameCode));

                $theme = is_array(optional($game->setting)->ui_meta_json) ? $game->setting->ui_meta_json : [];
                if (!empty($theme['lobby_banner_url'])) {
                    $profile['banner'] = (string) $theme['lobby_banner_url'];
                }
                if (!empty($theme['primary_color']) || !empty($theme['accent_color'])) {
                    $profile['palette']['start'] = (string) ($theme['primary_color'] ?? $profile['palette']['start']);
                    $profile['palette']['glow'] = (string) ($theme['accent_color'] ?? $profile['palette']['glow']);
                }

                return $profile;
            })
            ->values();
    }

    protected function hiddenLobbyGameCodes(): array
    {
        return [];
    }

    protected function isHiddenFromLobby($gameCode): bool
    {
        return in_array((string) $gameCode, $this->hiddenLobbyGameCodes(), true);
    }

    protected function isLobbyActiveGame($gameCode): bool
    {
        return Game::query()
            ->where('game_code', (string) $gameCode)
            ->where('is_active', 1)
            ->exists();
    }

    protected function normalizeKeyedIdentifier($key): string
    {
        $key = trim((string) $key);
        if ($key === '') {
            return '';
        }

        $decoded = rawurldecode($key);
        return is_string($decoded) ? trim($decoded) : $key;
    }

    protected function clientCookieName(): string
    {
        return (string) config('bd_game_final.security.client_cookie_name', 'bdgf_client');
    }

    protected function lobbySessionBinding(Request $request): string
    {
        return hash_hmac('sha256', (string) $request->session()->getId(), (string) config('app.key'));
    }

    protected function lobbyClientBinding(Request $request): string
    {
        $cookieValue = trim((string) $request->cookies->get($this->clientCookieName(), ''));

        if ($cookieValue === '') {
            return '';
        }

        return hash_hmac('sha256', $cookieValue, (string) config('app.key'));
    }

    protected function encodeOpaqueKey(Request $request, string $plainKey): string
    {
        $payload = json_encode([
            'v' => 2,
            'k' => $plainKey,
            's' => $this->lobbySessionBinding($request),
            'c' => $this->lobbyClientBinding($request),
            't' => now()->timestamp,
        ]);
        $encrypted = Crypt::encryptString((string) $payload);
        return rtrim(strtr(base64_encode($encrypted), '+/', '-_'), '=');
    }

    protected function normalizeEmailIdentifier(?string $email): string
    {
        return strtolower(trim((string) $email));
    }

    protected function hostedLobbyUrl(string $authToken = ''): string
    {
        $appUrl = rtrim((string) config('app.url', ''), '/');
        $baseUrl = app()->environment(['local', 'development', 'testing']) && $appUrl !== ''
            ? $appUrl . '/play_bd_game'
            : 'https://thomaslivestreamingcompanyltdgame.fairylive.online/play_bd_game';
        $authToken = trim($authToken);

        if ($authToken === '') {
            return $baseUrl;
        }

        return $baseUrl . '?email=' . urlencode($authToken);
    }

    protected function extractLobbyIdentity(Request $request): array
    {
        $email = $this->normalizeEmailIdentifier($request->query('email'));
        $apiToken = trim((string) $request->get('api_token', ''));

        if ($email !== '') {
            $opaqueKey = $this->encodeOpaqueKey($request, $email);

            return [
                'email' => $email,
                'api_token' => $apiToken,
                'plain_key' => $email,
                'opaque_key' => $opaqueKey,
                'lobby_url' => $this->hostedLobbyUrl($email),
            ];
        }

        if ($apiToken !== '') {
            $opaqueKey = $this->encodeOpaqueKey($request, $apiToken);

            return [
                'email' => '',
                'api_token' => $apiToken,
                'plain_key' => $apiToken,
                'opaque_key' => $opaqueKey,
                'lobby_url' => $this->hostedLobbyUrl($apiToken),
            ];
        }

        $sessionKey = trim((string) $request->session()->get('game_final.access_key', ''));
        if ($sessionKey !== '') {
            $decodedSessionKey = $this->tryDecodeOpaqueKey($request, $sessionKey);
            $sessionPlainKey = is_array($decodedSessionKey) ? trim((string) ($decodedSessionKey['plain_key'] ?? '')) : '';

            return [
                'email' => '',
                'api_token' => '',
                'plain_key' => $sessionPlainKey,
                'opaque_key' => $sessionKey,
                'lobby_url' => $this->hostedLobbyUrl($sessionPlainKey),
            ];
        }

        return [
            'email' => '',
            'api_token' => '',
            'plain_key' => '',
            'opaque_key' => '',
            'lobby_url' => $this->hostedLobbyUrl(),
        ];
    }

    protected function storeLobbyAccess(Request $request, string $opaqueKey, string $lobbyUrl): void
    {
        $request->session()->put('game_final.access_key', $opaqueKey);
        $request->session()->put('game_final.lobby_url', $lobbyUrl);
    }

    protected function accessRequiredResponse(Request $request, string $message = 'Email or API token is required before entering the lobby.')
    {
        if ($request->expectsJson() || $request->wantsJson() || $request->ajax()) {
            return response()->json([
                'st' => false,
                'code' => 'identity_required',
                'message' => $message,
            ], 403);
        }

        return response(
            '<!doctype html><html><head><meta name="viewport" content="width=device-width,initial-scale=1"><title>Access Required</title><style>*,*:before,*:after{box-sizing:border-box}html,body{width:100%;overflow-x:hidden}body{margin:0;min-height:100vh;display:grid;place-items:center;background:#09070f;color:#fff;font-family:Arial,sans-serif;padding:12px}.card{width:min(92vw,520px);max-width:100%;padding:28px;border:1px solid rgba(255,215,115,.45);border-radius:18px;background:linear-gradient(145deg,rgba(32,10,22,.94),rgba(4,18,31,.94));box-shadow:0 30px 90px rgba(0,0,0,.45);text-align:center}.title{font-size:24px;font-weight:900;color:#ffd36b}.msg{margin-top:14px;font-size:16px;line-height:1.5;overflow-wrap:anywhere}</style></head><body><div class="card"><div class="title">Access Required</div><div class="msg">' . e($message) . '</div></div></body></html>',
            403
        );
    }

    protected function tryDecodeOpaqueKey(Request $request, string $value): ?array
    {
        $normalized = trim($value);
        if ($normalized === '' || str_contains($normalized, '@')) {
            return null;
        }

        $padded = strtr($normalized, '-_', '+/');
        $padLength = strlen($padded) % 4;
        if ($padLength > 0) {
            $padded .= str_repeat('=', 4 - $padLength);
        }

        $decoded = base64_decode($padded, true);
        if ($decoded === false || $decoded === '') {
            return null;
        }

        try {
            $plain = Crypt::decryptString($decoded);
            $plain = trim((string) $plain);
            if ($plain === '') {
                return null;
            }

            $payload = json_decode($plain, true);
            if (!is_array($payload) || !isset($payload['k'])) {
                return [
                    'plain_key' => $plain,
                    'valid' => false,
                    'reason' => 'legacy',
                ];
            }

            $sessionBinding = (string) ($payload['s'] ?? '');
            $clientBinding = (string) ($payload['c'] ?? '');
            $sessionValid = $sessionBinding !== '' && hash_equals($sessionBinding, $this->lobbySessionBinding($request));
            $clientValid = $clientBinding === '' || hash_equals($clientBinding, $this->lobbyClientBinding($request));

            return [
                'plain_key' => trim((string) $payload['k']),
                'valid' => $sessionValid && $clientValid,
                'reason' => !$sessionValid ? 'session' : ($clientValid ? null : 'client'),
            ];
        } catch (\Throwable $e) {
            return null;
        }
    }

    protected function userMatchesKeyColumn(string $key, string $column): ?User
    {
        try {
            if (!Schema::hasColumn('users', $column)) {
                return null;
            }
        } catch (\Throwable $e) {
            return null;
        }

        try {
            return User::query()->where($column, $key)->first();
        } catch (\Throwable $e) {
            return null;
        }
    }

    protected function resolveKeyedUser(Request $request, $key)
    {
        $key = $this->normalizeKeyedIdentifier($key);
        abort_if($key === '', 404, 'invalid_game_key');

        $user = null;
        $matchedBy = null;

        $user = $this->userMatchesKeyColumn($key, 'game_api_key');
        if ($user) {
            $matchedBy = 'game_api_key';
        }

        if (!$user) {
            $user = $this->userMatchesKeyColumn($key, 'api_token');
            if ($user) {
                $matchedBy = 'api_token';
            }
        }

        if (!$user && str_contains($key, '@')) {
            try {
                if (Schema::hasColumn('users', 'email')) {
                    $user = User::query()->whereRaw('LOWER(email) = ?', [strtolower($key)])->first();
                }
            } catch (\Throwable $e) {
                $user = null;
            }

            if ($user) {
                $matchedBy = 'email';
            }
        }

        abort_unless($user, 404, 'user_not_found');

        $play = $this->users->canPlay($user);
        if (empty($play['ok'])) {
            if (($play['reason'] ?? null) === 'blocked_by_jamboai') {
                return $this->blockedResponse($request, (string) ($play['block_reason'] ?? 'Account access was locked by JAMBOai security.'));
            }

            return redirect()->route('game-final.lobby');
        }

        return [$user, $matchedBy ?: 'unknown', $key];
    }

    protected function blockedResponse(Request $request, string $reason)
    {
        $message = 'You have been blocked by JAMBOai for reason "' . $reason . '".';

        if ($request->expectsJson() || $request->wantsJson() || $request->ajax()) {
            return response()->json([
                'st' => false,
                'code' => 'blocked_by_jamboai',
                'message' => $message,
                'reason' => $reason,
            ], 423);
        }

        return response(
            '<!doctype html><html><head><meta name="viewport" content="width=device-width,initial-scale=1"><title>JAMBOai Blocked</title><style>*,*:before,*:after{box-sizing:border-box}html,body{width:100%;overflow-x:hidden}body{margin:0;min-height:100vh;display:grid;place-items:center;background:#09070f;color:#fff;font-family:Arial,sans-serif;padding:12px}.card{width:min(92vw,520px);max-width:100%;padding:28px;border:1px solid rgba(255,215,115,.45);border-radius:18px;background:linear-gradient(145deg,rgba(32,10,22,.94),rgba(4,18,31,.94));box-shadow:0 30px 90px rgba(0,0,0,.45);text-align:center}.title{font-size:24px;font-weight:900;color:#ffd36b}.msg{margin-top:14px;font-size:16px;line-height:1.5;overflow-wrap:anywhere}</style></head><body><div class="card"><div class="title">JAMBOai Security</div><div class="msg">' . e($message) . '</div></div></body></html>',
            423
        );
    }

    public function index(Request $request)
    {
        $identity = $this->extractLobbyIdentity($request);

        if ($identity['plain_key'] !== '') {
            $this->storeLobbyAccess($request, $identity['opaque_key'], $identity['lobby_url']);
            return redirect()->route('game-final.lobby.keyed.secure', ['key' => $identity['opaque_key']]);
        }

        if ($identity['opaque_key'] !== '') {
            return redirect()->route('game-final.lobby.keyed.secure', ['key' => $identity['opaque_key']]);
        }

        $authUser = auth()->user();
        if (!$authUser) {
            return $this->accessRequiredResponse($request);
        }

        $games = $this->lobbyGames(null, '', $authUser, $request);

        return view('game_final.lobby.index', [
            'games' => $games,
            'apiToken' => '',
            'authUser' => $authUser,
            'lobbyUrl' => $identity['lobby_url'],
        ]);
    }

    public function keyedLobby(Request $request, $key)
    {
        $incomingKey = $this->normalizeKeyedIdentifier($key);
        $decodedKey = $this->tryDecodeOpaqueKey($request, $incomingKey);
        if (is_array($decodedKey) && empty($decodedKey['valid'])) {
            return $this->accessRequiredResponse($request, 'This lobby link is protected for one browser session. Re-enter with your email or API token.');
        }

        $resolvedKey = is_array($decodedKey) ? (string) $decodedKey['plain_key'] : $incomingKey;
        $opaqueKey = is_array($decodedKey) ? $incomingKey : $this->encodeOpaqueKey($request, $resolvedKey);

        if (!is_array($decodedKey)) {
            return redirect()->route('game-final.lobby.keyed.secure', ['key' => $opaqueKey]);
        }

        $resolved = $this->resolveKeyedUser($request, $resolvedKey);
        if ($resolved instanceof \Illuminate\Http\Response || $resolved instanceof \Illuminate\Http\JsonResponse) {
            return $resolved;
        }
        [$user, $accessSource] = $resolved;
        $hostedLobbyUrl = $this->hostedLobbyUrl($resolvedKey);
        $this->storeLobbyAccess($request, $opaqueKey, $hostedLobbyUrl);

        return view('game_final.lobby.index', [
            'games' => $this->lobbyGames($opaqueKey, '', $user, $request),
            'apiToken' => '',
            'authUser' => $user,
            'gameAccessKey' => $opaqueKey,
            'resolvedUserSource' => $accessSource,
            'lobbyUrl' => $hostedLobbyUrl,
        ]);
    }

    public function start(Request $request, $gameCode)
    {
        if ($this->isHiddenFromLobby($gameCode)) {
            return redirect()->to((string) $request->session()->get('game_final.lobby_url', route('game-final.lobby')));
        }

        if (!$this->isLobbyActiveGame($gameCode)) {
            return redirect()->to((string) $request->session()->get('game_final.lobby_url', route('game-final.lobby')));
        }

        $sessionKey = trim((string) $request->session()->get('game_final.access_key', ''));
        if ($sessionKey !== '') {
            $decodedKey = $this->tryDecodeOpaqueKey($request, $sessionKey);
            if (is_array($decodedKey) && empty($decodedKey['valid'])) {
                return $this->accessRequiredResponse($request, 'This lobby link is protected for one browser session. Re-enter with your email or API token.');
            }

            $resolvedKey = is_array($decodedKey) ? (string) $decodedKey['plain_key'] : $sessionKey;
            $resolved = $this->resolveKeyedUser($request, $resolvedKey);
            if ($resolved instanceof \Illuminate\Http\Response || $resolved instanceof \Illuminate\Http\JsonResponse) {
                return $resolved;
            }

            [$user, $accessSource] = $resolved;
            $request->merge([
                'game_final_key_access_source' => $accessSource,
                'game_final_access_key' => $sessionKey,
            ]);
            $this->storeLobbyAccess($request, $sessionKey, route('game-final.lobby.keyed.secure', ['key' => $sessionKey]));

            return $this->startForUser($request, $gameCode, $user, 'keyed_lobby_start', 'thomas-live-streeaming-game');
        }

        [$user, $reason] = $this->users->resolvePlayableUser($request, $gameCode);
        if (!$user) {
            return $this->accessRequiredResponse($request, 'Email or API token is required before starting a game.');
        }

        return $this->startForUser($request, $gameCode, $user, auth()->check() ? 'lobby_auth_start' : 'lobby_api_token_start', 'play_bd_game');
    }

    public function keyedStart(Request $request, $key, $gameCode)
    {
        if ($this->isHiddenFromLobby($gameCode)) {
            return redirect()->route('game-final.lobby.keyed.secure', ['key' => $key]);
        }

        if (!$this->isLobbyActiveGame($gameCode)) {
            return redirect()->route('game-final.lobby.keyed.secure', ['key' => $key]);
        }

        $incomingKey = $this->normalizeKeyedIdentifier($key);
        $decodedKey = $this->tryDecodeOpaqueKey($request, $incomingKey);
        if (is_array($decodedKey) && empty($decodedKey['valid'])) {
            return $this->accessRequiredResponse($request, 'This lobby link is protected for one browser session. Re-enter with your email or API token.');
        }

        $resolvedKey = is_array($decodedKey) ? (string) $decodedKey['plain_key'] : $incomingKey;
        $opaqueKey = is_array($decodedKey) ? $incomingKey : $this->encodeOpaqueKey($request, $resolvedKey);

        $resolved = $this->resolveKeyedUser($request, $resolvedKey);
        if ($resolved instanceof \Illuminate\Http\Response || $resolved instanceof \Illuminate\Http\JsonResponse) {
            return $resolved;
        }
        [$user, $accessSource] = $resolved;
        $request->merge([
            'game_final_key_access_source' => $accessSource,
            'game_final_access_key' => $opaqueKey,
        ]);
        $this->storeLobbyAccess($request, $opaqueKey, route('game-final.lobby.keyed.secure', ['key' => $opaqueKey]));

        return $this->startForUser($request, $gameCode, $user, 'keyed_lobby_start', 'thomas-live-streeaming-game');
    }

    protected function startForUser(Request $request, $gameCode, User $user, $issuedFrom, $from)
    {
        $play = $this->users->canPlay($user, $gameCode);
        if (empty($play['ok'])) {
            if (($play['reason'] ?? null) === 'blocked_by_jamboai') {
                return $this->blockedResponse($request, (string) ($play['block_reason'] ?? 'Account access was locked by JAMBOai security.'));
            }

            return redirect()->route('game-final.lobby');
        }

        $this->ensureLocalPlayableBalance($request, $user, $gameCode);

        $device = $this->deviceFingerprint($request);
        $entryToken = $this->tokens->issueEntryToken($gameCode, $user->id, $device, [
            'issued_from' => $issuedFrom,
            'from' => $from,
        ]);
        $plainEntryToken = $entryToken['plain_token'] ?? null;

        abort_unless($plainEntryToken, 404, 'invalid_game_code');

        $request->session()->put('game_final.entry_tokens.' . $gameCode, $plainEntryToken);
        $url = route('game-final.entry', ['gameCode' => $gameCode]);
        $keyedAccessSource = (string) $request->input('game_final_key_access_source', 'anonymous');
        $keyedAccessKey = (string) $request->input('game_final_access_key', '');
        $lobbyIdentity = $this->extractLobbyIdentity($request);
        $lobbyUrl = $lobbyIdentity['lobby_url'];
        if ($keyedAccessKey !== '') {
            $decodedLobbyKey = $this->tryDecodeOpaqueKey($request, $keyedAccessKey);
            $decodedLobbyPlainKey = is_array($decodedLobbyKey) ? trim((string) ($decodedLobbyKey['plain_key'] ?? '')) : '';
            $lobbyUrl = $this->hostedLobbyUrl($decodedLobbyPlainKey);
            $this->storeLobbyAccess($request, $keyedAccessKey, $lobbyUrl);
        }
        $userImage = null;
        foreach (['image', 'avatar', 'profile_image', 'photo', 'image_url', 'avatar_url', 'user_image'] as $column) {
            if (Schema::hasColumn('users', $column) && !empty($user->{$column})) {
                $userImage = $user->{$column};
                break;
            }
        }

        if ($request->expectsJson() || $request->wantsJson() || $request->ajax()) {
            return response()->json([
                'st' => true,
                'game_code' => $gameCode,
                'game_token' => $plainEntryToken,
                'entry_url' => $url,
                'lobby_url' => $lobbyUrl,
                'identity' => [
                    'image' => $userImage,
                    'access_key' => $keyedAccessKey !== '' ? $keyedAccessKey : null,
                    'access_source' => $keyedAccessSource ?: null,
                ],
            ]);
        }

        $request->session()->put('game_final.lobby_url', $lobbyUrl);
        $request->session()->save();

        return redirect()->to($url);
    }

    private function firstExistingColumn($model, array $columns)
    {
        $table = $model->getTable();

        foreach ($columns as $column) {
            if (Schema::hasColumn($table, $column)) {
                return $column;
            }
        }

        return null;
    }

    private function ensureLocalPlayableBalance(Request $request, User $user, $gameCode)
    {
        $host = strtolower((string) $request->getHost());
        $isLocalHost = in_array($host, ['127.0.0.1', 'localhost', '::1'], true);

        if (!$isLocalHost && !app()->environment(['local', 'development', 'testing'])) {
            return;
        }

        $gameModel = new Game();
        $gameCodeColumn = $this->firstExistingColumn($gameModel, ['code', 'game_code', 'slug', 'key']);

        if (!$gameCodeColumn) {
            return;
        }

        $game = Game::query()->where($gameCodeColumn, $gameCode)->first();

        if (!$game) {
            return;
        }

        $freshUser = $user->fresh();

        if (!$freshUser || $this->wallets->currentBalance($freshUser) > 0) {
            return;
        }

        $amount = min(10000.0, (float) $this->gameBank->currentBalanceForGameId((int) $game->id));

        if ($amount <= 0) {
            return;
        }

        $bankDebit = $this->gameBank->debit($game->id, $amount);

        if (empty($bankDebit['ok'])) {
            return;
        }

        $credit = $this->wallets->credit($freshUser, $amount, [
            'game_id' => $game->id,
            'reason' => 'local_playable_balance',
            'meta_json' => [
                'source' => 'local_lobby_entry',
                'game_code' => $gameCode,
                'host' => $host,
            ],
        ]);

        if (empty($credit['ok'])) {
            $this->gameBank->credit($game->id, $amount);
        }
    }
}
