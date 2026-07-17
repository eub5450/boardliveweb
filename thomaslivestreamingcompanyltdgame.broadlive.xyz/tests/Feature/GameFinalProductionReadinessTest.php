<?php

namespace Tests\Feature;

use App\Models\GameFinal\Game;
use App\Events\GameFinal\GameStateChanged;
use App\Models\GameFinal\GameBet;
use App\Models\GameFinal\GameBoard;
use App\Models\GameFinal\GameRound;
use App\Models\GameFinal\GameSecurityBlock;
use App\Models\GameFinal\GameSetting;
use App\Models\GameFinal\GameSettlementItem;
use App\Models\GameFinal\GameWalletJournal;
use App\Models\User;
use App\Services\GameFinal\BetService;
use App\Services\GameFinal\GameBankService;
use App\Services\GameFinal\GameConfigService;
use App\Services\GameFinal\GameRealtimeService;
use App\Services\GameFinal\GameRuntimeService;
use App\Services\GameFinal\GameTokenService;
use App\Services\GameFinal\GameUserService;
use App\Services\GameFinal\RoundService;
use App\Services\GameFinal\SettlementService;
use App\Services\GameFinal\WalletService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Tests\TestCase;

class GameFinalProductionReadinessTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();
        Config::set('queue.default', 'sync');
        Config::set('bd_game_final.shared_game_balance', true);
        Config::set('bd_game_final.security.inactive_penalty_enabled', false);
    }

    public static function gameCodes(): array
    {
        return [
            'Teen Patti' => ['teen_patti'],
            'Fruits Loop' => ['fruits_loop'],
            'Fruits Slot' => ['fruit_slot'],
            'Lucky77' => ['lucky77'],
        ];
    }

    /**
     * @dataProvider gameCodes
     */
    public function test_game_flow_is_idempotent_and_restores_settled_state(string $gameCode): void
    {
        $game = $this->ensureRoom($gameCode);
        $round = $this->createBettingRound($game);
        $boards = $this->boardKeys($gameCode);
        $winner = $boards[0];
        $userA = $this->createUser(['balance' => 10000]);
        $userB = $this->createUser(['balance' => 10000]);

        $stateA = app(RoundService::class)->getState($gameCode);
        $stateB = app(RoundService::class)->getState($gameCode);
        $this->assertSame($stateA->round_no, $stateB->round_no);
        $this->assertSame($stateA->status, $stateB->status);
        $this->assertSame($round->round_no, $stateA->round_no);
        $this->assertSame('betting', $stateA->status);

        $betA = app(BetService::class)->placeBet($gameCode, $userA, $round->round_no, $winner, 25, 'uid-' . $gameCode . '-a');
        $betB = app(BetService::class)->placeBet($gameCode, $userB, $round->round_no, $winner, 30, 'uid-' . $gameCode . '-b');
        $this->assertTrue((bool) $betA['st']);
        $this->assertTrue((bool) $betB['st']);
        $this->assertSame(9975.0, (float) $userA->fresh()->balance);
        $this->assertSame(9970.0, (float) $userB->fresh()->balance);
        $this->assertSame(55.0, (float) GameBet::query()->where('game_round_id', $round->id)->where('canonical_board_key', $winner)->sum('amount'));

        $duplicate = app(BetService::class)->placeBet($gameCode, $userA, $round->round_no, $winner, 25, 'uid-' . $gameCode . '-a');
        $this->assertTrue((bool) $duplicate['st']);
        $this->assertSame(1, GameBet::query()->where('user_id', $userA->id)->where('request_uid', 'uid-' . $gameCode . '-a')->count());
        $this->assertSame(9975.0, (float) $userA->fresh()->balance);
        $this->assertSame(1, GameWalletJournal::query()->where('user_id', $userA->id)->where('direction', 'debit')->where('reason', 'bet_debit')->count());

        $this->assertSame('bet_amount_out_of_range', app(BetService::class)->placeBet($gameCode, $userA, $round->round_no, $winner, 0.01, 'uid-' . $gameCode . '-low')['msg']);
        $this->assertSame('bet_amount_out_of_range', app(BetService::class)->placeBet($gameCode, $userA, $round->round_no, $winner, 5000, 'uid-' . $gameCode . '-high')['msg']);
        $this->assertSame('invalid_round', app(BetService::class)->placeBet($gameCode, $userA, 'stale-' . $round->round_no, $winner, 25, 'uid-' . $gameCode . '-stale')['msg']);
        $this->assertSame(9975.0, (float) $userA->fresh()->balance);

        $round->forceFill(['status' => 'locked'])->save();
        $this->assertSame('bet_closed', app(BetService::class)->placeBet($gameCode, $userA, $round->round_no, $winner, 25, 'uid-' . $gameCode . '-late')['msg']);

        $this->settleReadyRound($round, $winner);
        $resultA = app(RoundService::class)->getState($gameCode);
        $resultB = app(RoundService::class)->getState($gameCode);
        $this->assertSame($resultA->winner_board_key, $resultB->winner_board_key);
        $this->assertSame($winner, $resultA->winner_board_key);

        $settlementA = app(SettlementService::class)->settleRound($round->fresh());
        $balanceAfterFirst = (float) $userA->fresh()->balance;
        $itemCountAfterFirst = GameSettlementItem::query()->where('game_round_id', $round->id)->count();
        $settlementB = app(SettlementService::class)->settleRound($round->fresh());
        $this->assertSame($settlementA->id, $settlementB->id);
        $this->assertSame($itemCountAfterFirst, GameSettlementItem::query()->where('game_round_id', $round->id)->count());
        $this->assertSame($balanceAfterFirst, (float) $userA->fresh()->balance);

        $token = $this->sessionToken($gameCode, $userA);
        $response = $this->withHeader('X-Game-Session', $token)->getJson(route('game-final.api.state', ['gameCode' => $gameCode]));
        $response->assertOk();
        $response->assertJsonPath('round_no', $round->round_no);
        $response->assertJsonPath('phase', 'settled');
        $response->assertJsonPath('winner_board', $winner);
        $this->assertSame(55, (int) data_get($response->json('board_totals'), $winner));
    }

    public function test_security_gates_reject_invalid_frontend_paths(): void
    {
        $game = $this->ensureRoom('teen_patti');
        $round = $this->createBettingRound($game);
        $board = $this->boardKeys('teen_patti')[0];
        $user = $this->createUser(['balance' => 500]);
        $developer = $this->createUser(['balance' => 500]);

        $this->getJson(route('game-final.api.state', ['gameCode' => 'teen_patti']))->assertStatus(401);

        $game->forceFill(['is_active' => 0])->save();
        $this->assertSame('game_inactive', app(BetService::class)->placeBet('teen_patti', $user, $round->round_no, $board, 25, 'sec-hidden')['msg']);
        $game->forceFill(['is_active' => 1])->save();

        $setting = GameSetting::query()->where('game_id', $game->id)->firstOrFail();
        $setting->forceFill(['game_status' => 'inactive'])->save();
        $maintenance = app(GameRuntimeService::class)->maintenanceState('teen_patti', $user);
        $this->assertTrue((bool) $maintenance['active']);
        $this->assertFalse((bool) $maintenance['allowed']);

        $setting->forceFill(['game_status' => 'developer'])->save();
        app(GameRuntimeService::class)->update(['maintenance_allowed_user_ids' => ['teen_patti' => [$developer->id]]]);
        $this->assertFalse((bool) app(GameRuntimeService::class)->maintenanceState('teen_patti', $user)['allowed']);
        $this->assertTrue((bool) app(GameRuntimeService::class)->maintenanceState('teen_patti', $developer)['allowed']);
        $setting->forceFill(['game_status' => 'live'])->save();

        $before = (float) $user->fresh()->balance;
        $this->assertSame('invalid_amount', app(BetService::class)->placeBet('teen_patti', $user, $round->round_no, $board, -100, 'sec-negative')['msg']);
        $this->assertSame('bet_amount_out_of_range', app(BetService::class)->placeBet('teen_patti', $user, $round->round_no, $board, 5000, 'sec-high')['msg']);
        $this->assertSame($before, (float) $user->fresh()->balance);

        $accepted = app(BetService::class)->placeBet('teen_patti', $user, $round->round_no, $board, 25, 'sec-dup');
        $this->assertTrue((bool) $accepted['st']);
        $duplicateMismatch = app(BetService::class)->placeBet('teen_patti', $user, $round->round_no, $board, 30, 'sec-dup');
        $this->assertSame('duplicate_request', $duplicateMismatch['msg']);
        $this->assertSame(1, GameBet::query()->where('user_id', $user->id)->where('request_uid', 'sec-dup')->count());

        $this->settleReadyRound($round->fresh(), $board);
        $settlementA = app(SettlementService::class)->settleRound($round->fresh());
        $settlementB = app(SettlementService::class)->settleRound($round->fresh());
        $this->assertSame($settlementA->id, $settlementB->id);
        $this->assertSame(1, GameSettlementItem::query()->where('game_bet_id', $accepted['bet']->id)->count());
    }

    public function test_admin_controls_persist_and_routes_resolve(): void
    {
        $game = $this->ensureRoom('fruits_loop');
        $user = $this->createUser(['balance' => 700]);
        $admin = $this->createAdmin();
        $board = GameBoard::query()->where('game_id', $game->id)->orderBy('id')->firstOrFail();

        $game->forceFill(['is_active' => 0])->save();
        $this->assertSame(0, (int) $game->fresh()->is_active);
        $game->forceFill(['is_active' => 1])->save();
        $this->assertSame(1, (int) $game->fresh()->is_active);

        GameSetting::query()->where('game_id', $game->id)->update(['game_status' => 'developer']);
        app(GameRuntimeService::class)->update(['maintenance_allowed_user_ids' => ['fruits_loop' => [$admin->id]]]);
        $this->assertTrue((bool) app(GameRuntimeService::class)->maintenanceState('fruits_loop', $admin)['allowed']);

        $board->forceFill(['payout_multiplier' => 9])->save();
        $this->assertSame(9.0, (float) app(GameConfigService::class)->get('fruits_loop')['boards'][0]['multiplier']);

        $bankCredit = app(GameBankService::class)->credit($game->id, 100);
        $bankDebit = app(GameBankService::class)->debit($game->id, 40);
        $this->assertTrue((bool) $bankCredit['ok']);
        $this->assertTrue((bool) $bankDebit['ok']);
        $this->assertSame((float) $bankCredit['after'] - 40.0, (float) $bankDebit['after']);

        $wallet = app(WalletService::class);
        $credit = $wallet->credit($user, 50, ['reason' => 'admin_wallet_transfer', 'reference_uid' => 'admin-credit-' . $user->id]);
        $debit = $wallet->debit($user->fresh(), 20, ['reason' => 'admin_wallet_transfer', 'reference_uid' => 'admin-debit-' . $user->id]);
        $this->assertTrue((bool) $credit['ok']);
        $this->assertTrue((bool) $debit['ok']);
        $this->assertSame(730.0, (float) $user->fresh()->balance);

        $block = app(GameTokenService::class)->blockUserForSecurity($user->id, 'fruits_loop', 'test lock', 'admin_check');
        $this->assertSame('blocked_by_jamboai', app(GameUserService::class)->canPlay($user->fresh(), 'fruits_loop')['reason']);
        $block->forceFill(['status' => 'lifted', 'lifted_at' => now()])->save();
        $this->assertTrue((bool) app(GameUserService::class)->canPlay($user->fresh(), 'fruits_loop')['ok']);

        $round = $this->createBettingRound($game);
        $this->assertStringContainsString('/admin/game-final/rounds/' . $round->id, route('admin.game-final.rounds.detail', ['round' => $round->id]));
        $this->assertStringContainsString('/admin/game-final/users/' . $user->id, route('admin.game-final.users.profile', ['user' => $user->id]));
    }

    public function test_authenticated_admin_http_validation_harness(): void
    {
        Config::set('bd_game_final.admin_security.secret', 'JAMBO-production-secret-0001');
        Config::set('bd_game_final.admin_security.secret_hash', '');
        $admin = $this->createAdmin();
        $profileUser = $this->createUser(['balance' => 300]);
        $game = $this->ensureRoom('lucky77');
        $round = $this->createBettingRound($game);

        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $this->actingAs($admin);

        $this->get(route('admin.game-final.security'))->assertOk()->assertSee('data-toast-stack', false);
        $this->post(route('admin.game-final.security.verify'), ['security_pass' => 'JAMBO-production-secret-0001'])
            ->assertRedirect(route('admin.dashboard'));

        $session = [\App\Services\GameFinal\GameAdminSecurityService::SESSION_VERIFIED_UNTIL_KEY => now()->addMinutes(15)->timestamp];
        $pages = [
            route('admin.game-final.dashboard'),
            route('admin.game-final.games', ['search' => 'Lucky', 'status' => 'live']),
            route('admin.game-final.live-monitor'),
            route('admin.game-final.rounds', ['game' => 'lucky77', 'status' => 'betting']),
            route('admin.game-final.bets', ['game' => 'lucky77', 'status' => 'pending']),
            route('admin.game-final.payouts', ['game' => 'lucky77', 'status' => 'paid']),
            route('admin.game-final.users', ['search' => $profileUser->id]),
            route('admin.game-final.users.profile', ['user' => $profileUser->id]),
            route('admin.game-final.rounds.detail', ['round' => $round->id]),
        ];

        foreach ($pages as $page) {
            $this->withSession($session)->get($page)->assertOk();
        }

        $dashboard = $this->withSession($session)->get(route('admin.game-final.dashboard'));
        $dashboard->assertSee('id="dashboard-fast-find"', false);
        $dashboard->assertSee('data-fast-find-input="#dashboard-games-table"', false);
        $dashboard->assertSee('data-toast-stack', false);
        $dashboard->assertSee('data-confirm-modal', false);
        $dashboard->assertSee('data-confirm="Save lobby and runtime changes?"', false);
        $dashboard->assertSee('name="viewport"', false);
        $dashboard->assertSee('@media(max-width:720px)', false);
        $dashboard->assertSee('data-config-version-status', false);

        $games = $this->withSession($session)->get(route('admin.game-final.games', ['search' => 'Lucky', 'status' => 'live']));
        $games->assertSee('value="Lucky"', false);
        $games->assertSee('value="live" selected', false);
        $games->assertSee('data-fast-find-input="#games-table"', false);

        $panelScript = file_get_contents(public_path('game_final_admin_theme/admin-panel.js'));
        $this->assertStringContainsString('data-fast-find-input', $panelScript);
        $this->assertStringContainsString('hidden-by-search', $panelScript);
        $this->assertStringContainsString('data-confirm-modal', $panelScript);
    }

    public function test_realtime_contract_fallback_and_config_version_adoption(): void
    {
        $game = $this->ensureRoom('teen_patti');
        $round = $this->createBettingRound($game);
        $user = $this->createUser(['balance' => 300]);
        $runtime = app(GameRuntimeService::class);

        $beforeVersion = $runtime->configVersion();
        $runtime->bumpConfigVersion(['realtime_mode' => 'polling', 'poll_interval_ms' => 1200]);
        $this->assertGreaterThan($beforeVersion, $runtime->configVersion());

        $eventPayload = ['st' => true, 'game_key' => 'teen_patti', 'room_key' => 'teen_patti', 'config_version' => $runtime->configVersion()];
        $event = new GameStateChanged('teen_patti', $eventPayload);
        $this->assertSame('bdgamefinal.teen_patti', $event->broadcastOn()->name);
        $this->assertSame('bd.game.state', $event->broadcastAs());
        $this->assertSame($eventPayload, $event->broadcastWith());

        $token = $this->sessionToken('teen_patti', $user);
        $state = $this->withHeader('X-Game-Session', $token)->getJson(route('game-final.api.state', ['gameCode' => 'teen_patti']));
        $state->assertOk();
        $state->assertJsonPath('game_key', 'teen_patti');
        $state->assertJsonPath('room_key', 'teen_patti');
        $this->assertGreaterThanOrEqual($runtime->configVersion(), (int) $state->json('config_version'));
        $this->assertSame($round->round_no, $state->json('round_no'));

        $heartbeat = $this->withHeader('X-Game-Session', $token)->postJson(route('game-final.api.heartbeat', ['gameCode' => 'teen_patti']), ['network_ms' => 12]);
        $heartbeat->assertOk();
        $heartbeat->assertJsonPath('game_key', 'teen_patti');
        $heartbeat->assertJsonPath('room_key', 'teen_patti');
        $this->assertGreaterThan(0, (int) $heartbeat->json('config_version'));

        $runtime->update(['realtime_mode' => 'polling']);
        $runtime->applyToConfig();
        $this->assertFalse(app(GameRealtimeService::class)->broadcastState('teen_patti', ['st' => true, 'game_key' => 'teen_patti', 'room_key' => 'teen_patti', 'config_version' => $runtime->configVersion()]));

        $runtime->update(['realtime_mode' => 'websocket', 'websocket_url' => 'ws://127.0.0.1:6001/game', 'websocket_protocols' => 'bdgf, v1']);
        $runtime->applyToConfig();
        $this->assertSame('websocket', config('bd_game_final.realtime.mode'));
        $this->assertSame('ws://127.0.0.1:6001/game', config('bd_game_final.realtime.websocket.url'));
        $this->assertSame(['bdgf', 'v1'], config('bd_game_final.realtime.websocket.protocols'));

        $runtime->update([
            'realtime_mode' => 'pusher',
            'pusher_accounts' => [[
                'app_id' => '100',
                'key' => 'public-key',
                'secret' => 'private-secret',
                'cluster' => 'mt1',
                'host' => '',
                'port' => 443,
                'scheme' => 'https',
            ]],
            'pusher_active_index' => 0,
            'pusher_failed_indexes' => [],
        ]);
        $runtime->applyToConfig();
        $publicAccounts = (array) config('bd_game_final.realtime.pusher.public_accounts', []);
        $this->assertSame('public-key', $publicAccounts[0]['key']);
        $this->assertArrayNotHasKey('secret', $publicAccounts[0]);
        $runtime->markPusherCredentialFailed(0, 'contract failure');
        $this->assertSame('polling', $runtime->settings()['realtime_mode']);

        $bridge = file_get_contents(public_path('game_final_assets/game_final_bridge.js'));
        $this->assertStringContainsString('bdgf:config-adopted', $bridge);
        $this->assertStringContainsString('_adoptedConfigVersion', $bridge);
        $this->assertStringContainsString("requestRefresh('config_version_changed')", $bridge);
        $this->assertStringContainsString('if (api._poller) clearInterval(api._poller)', $bridge);

        foreach ([
            resource_path('views/game_final/teen_patti/index.blade.php'),
            resource_path('views/game_final/fruits_loop/index.blade.php'),
            resource_path('views/game_final/fruit_slot/index.blade.php'),
            resource_path('views/game_final/lucky77/index.blade.php'),
            resource_path('views/game_final/lucky77/max_lounge.blade.php'),
            resource_path('views/game_final/lucky77/pro_lounge.blade.php'),
        ] as $template) {
            $contents = file_get_contents($template);
            $this->assertStringContainsString('configVersion:', $contents);
            $this->assertStringContainsString('gameKey:', $contents);
            $this->assertStringContainsString('roomKey:', $contents);
        }
    }

    protected function ensureRoom(string $gameCode): Game
    {
        $cfg = config('bd_game_final.games.' . $gameCode);
        $this->assertIsArray($cfg, 'Game config missing for ' . $gameCode);
        $boards = (array) ($cfg['boards'] ?? []);
        $this->assertNotEmpty($boards, 'Board config missing for ' . $gameCode);

        $game = Game::query()->updateOrCreate(
            ['game_code' => $gameCode],
            [
                'name' => (string) ($cfg['name'] ?? $gameCode),
                'is_active' => 1,
                'frontend_slug' => $gameCode,
                'sort_order' => 1,
            ]
        );

        GameSetting::query()->updateOrCreate(
            ['game_id' => $game->id],
            [
                'bet_duration_sec' => 20,
                'start_bet_popup_sec' => 0,
                'start_bet_wait_sec' => 0,
                'stop_bet_popup_sec' => 0,
                'stop_bet_wait_sec' => 0,
                'stop_duration_sec' => 1.5,
                'reveal_duration_sec' => 1,
                'settle_duration_sec' => 30,
                'max_distinct_boards_per_user' => max(1, count($boards)),
                'min_bet' => 10,
                'max_bet' => 1000,
                'risk_mode' => 'manual',
                'reserve_buffer' => 0,
                'repeat_limit' => 0,
                'manual_winner_board' => null,
                'manual_lock_enabled' => 0,
                'game_status' => 'live',
                'maintenance_enabled' => 0,
                'maintenance_allowed_user_id' => null,
                'maintenance_message' => null,
                'decision_balance_amount' => 100000,
                'healthy_balance_threshold' => 0,
                'weighted_random_enabled' => 0,
                'weighted_random_spread' => 3,
                'avoid_last_n_winners' => 0,
            ]
        );

        foreach (array_values($boards) as $index => $board) {
            GameBoard::query()->updateOrCreate(
                [
                    'game_id' => $game->id,
                    'canonical_key' => (string) ($board['canonical_key'] ?? $board['frontend_key']),
                ],
                [
                    'frontend_key' => (string) ($board['frontend_key'] ?? $board['canonical_key']),
                    'display_name' => (string) ($board['display_name'] ?? $board['canonical_key']),
                    'payout_multiplier' => (float) ($board['multiplier'] ?? 2),
                    'display_order' => $index + 1,
                    'is_active' => 1,
                    'ui_meta_json' => [],
                ]
            );
        }

        return $game->fresh();
    }

    protected function boardKeys(string $gameCode): array
    {
        return array_values(array_map(static function (array $board): string {
            return (string) ($board['canonical_key'] ?? $board['frontend_key']);
        }, (array) config('bd_game_final.games.' . $gameCode . '.boards', [])));
    }

    protected function createBettingRound(Game $game): GameRound
    {
        $now = now();

        return GameRound::query()->create([
            'game_id' => $game->id,
            'round_no' => 'test_' . $game->game_code . '_' . Str::lower(Str::random(12)),
            'start_at' => $now->copy()->subSecond(),
            'bet_close_at' => $now->copy()->addSeconds(30),
            'reveal_at' => $now->copy()->addSeconds(40),
            'settle_at' => $now->copy()->addSeconds(50),
            'status' => 'betting',
            'winner_board_key' => null,
            'decision_mode' => null,
            'decision_snapshot_json' => [],
            'result_payload_json' => [],
        ]);
    }

    protected function settleReadyRound(GameRound $round, string $winner): void
    {
        $now = now();
        $round->forceFill([
            'start_at' => $now->copy()->subSeconds(6),
            'bet_close_at' => $now->copy()->subSeconds(5),
            'reveal_at' => $now->copy()->subSeconds(3),
            'settle_at' => $now->copy()->subMilliseconds(200),
            'status' => 'settled',
            'winner_board_key' => $winner,
            'decision_mode' => 'test_contract',
            'decision_snapshot_json' => ['winner_board' => $winner],
            'result_payload_json' => ['winner_board' => $winner],
        ])->save();
    }

    protected function createAdmin(): User
    {
        return $this->createUser(['balance' => 1000, 'is_admin' => 1, 'status' => '1']);
    }

    protected function createUser(array $attributes = []): User
    {
        $columns = Schema::getColumnListing('users');
        $data = array_merge([
            'name' => 'Test User ' . Str::random(8),
            'email' => 'test-' . Str::lower(Str::random(16)) . '@example.test',
            'password' => Hash::make('password'),
            'phone' => '8801' . random_int(100000000, 999999999),
            'balance' => 1000,
            'status' => '1',
            'is_admin' => 0,
            'lock_brd_entry' => 0,
            'is_app_access' => 1,
            'api_token' => Str::random(40),
            'game_api_key' => Str::random(40),
            'email_verified_at' => now(),
        ], $attributes);
        $data = array_intersect_key($data, array_flip($columns));

        $user = new User();
        $user->forceFill($data);
        $user->save();

        return $user->fresh();
    }

    protected function sessionToken(string $gameCode, User $user): string
    {
        $issued = app(GameTokenService::class)->issueSessionToken($gameCode, (int) $user->id, null, null, ['issued_from' => 'production_readiness_test']);

        return (string) $issued['plain_token'];
    }
}
