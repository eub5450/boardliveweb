<?php

use App\Models\GameFinal\Game;
use App\Models\GameFinal\GameAccessToken;
use App\Models\GameFinal\GameBet;
use App\Models\User;
use App\Services\GameFinal\GameTokenService;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$gameCode = $argv[1] ?? 'teen_patti_king';
$gameId = Game::where('game_code', $gameCode)->value('id');
if (!$gameId) {
    fwrite(STDERR, "game_not_found\n");
    exit(2);
}

$activeUserId = DB::table(config('bd_game_final.tables.heartbeats', 'bd_game_final_heartbeats'))
    ->where('game_id', $gameId)
    ->orderByDesc('last_seen_at')
    ->value('user_id');

$candidateUserIds = collect();
if ($activeUserId) {
    $candidateUserIds->push((int) $activeUserId);
}
$candidateUserIds = $candidateUserIds
    ->merge(
        GameBet::query()
            ->where('game_id', $gameId)
            ->orderByDesc('id')
            ->limit(50)
            ->pluck('user_id')
            ->map(fn ($id) => (int) $id)
    )
    ->merge(
        User::query()
            ->orderByDesc('id')
            ->limit(50)
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
    )
    ->unique()
    ->values();

if ($candidateUserIds->isEmpty()) {
    fwrite(STDERR, "no_candidate_user\n");
    exit(3);
}

$tokenService = $app->make(GameTokenService::class);

$plainToken = null;
$selectedUserId = null;
foreach ($candidateUserIds as $candidateUserId) {
    $hasActiveSession = GameAccessToken::query()
        ->where('game_id', $gameId)
        ->where('user_id', (int) $candidateUserId)
        ->where('token_type', 'session')
        ->whereNull('revoked_at')
        ->where('expires_at', '>', now())
        ->exists();

    if ($hasActiveSession) {
        continue;
    }

    try {
        $issued = $tokenService->issueSessionToken(
            $gameCode,
            (int) $candidateUserId,
            null,
            null,
            ['issued_from' => 'codex_state_check']
        );
        $plainToken = $issued['plain_token'] ?? null;
        $selectedUserId = (int) $candidateUserId;
        if ($plainToken) {
            break;
        }
    } catch (\Throwable $e) {
        continue;
    }
}

if (!$plainToken || !$selectedUserId) {
    fwrite(STDERR, "token_issue_failed\n");
    exit(4);
}

fwrite(STDERR, "selected_user_id={$selectedUserId}\n");
echo $plainToken, PHP_EOL;
