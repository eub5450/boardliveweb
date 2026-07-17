<?php

namespace App\Console\Commands;

use App\Models\GameFinal\Game;
use App\Models\GameFinal\GameSetting;
use App\Support\GameFinal\BoardMapper;
use App\Support\GameFinal\GameRegistry;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class BdGameFinalVerifyProductionCommand extends Command
{
    protected $signature = 'bdgamefinal:verify-production';
    protected $description = 'Run production safety verification checks for Game Final games';

    protected $requiredGameCodes = [
        'teen_patti',
        'teen_patti_king',
        'teen_patti_sultan',
        'teen_patti_warfront',
        'teen_patti_neon',
        'teen_patti_shogun',
        'teen_patti_glacier',
        'lucky77',
        'lucky77_max',
        'lucky7_pro',
        'lucky77_mirage',
        'lucky77_ironfront',
        'lucky77_lotus',
        'lucky77_nebula',
        'lucky77_carnival',
        'lucky88_master',
        'fruit_slot',
        'fruit_slot_oasis',
        'fruit_slot_arsenal',
        'fruit_slot_arcade',
        'fruit_slot_lotus',
        'fruit_slot_glacier',
        'greedy',
        'fruits_loop',
        'fruits_loop_ruby',
        'fruits_loop_emerald',
    ];

    public function handle()
    {
        $errors = [];

        $games = (array) config('bd_game_final.games', []);
        $gameCodes = array_keys($games);
        $registry = GameRegistry::views();

        $missingConfig = array_values(array_diff($this->requiredGameCodes, $gameCodes));
        $missingRegistry = array_values(array_diff($this->requiredGameCodes, array_keys($registry)));

        if ($missingConfig) {
            $errors[] = 'Missing required config games: ' . implode(', ', $missingConfig);
        }

        if ($missingRegistry) {
            $errors[] = 'Missing required registry games: ' . implode(', ', $missingRegistry);
        }

        foreach ($this->requiredGameCodes as $gameCode) {
            $cfg = (array) ($games[$gameCode] ?? []);
            $boards = (array) ($cfg['boards'] ?? []);

            if (empty($boards)) {
                $errors[] = $gameCode . ': board definition missing';
                continue;
            }

            foreach ([
                'bet_duration_sec',
                'stop_duration_sec',
                'reveal_duration_sec',
                'reveal_wait_sec',
                'winner_popup_sec',
                'winner_wait_sec',
                'settle_duration_sec',
                'settle_wait_sec',
            ] as $field) {
                $v = (float) ($cfg[$field] ?? 0);
                if ($v <= 0) {
                    $errors[] = $gameCode . ': invalid timing ' . $field . '=' . $v;
                }
            }

            $allCanonical = BoardMapper::allCanonical($gameCode);
            if (count($allCanonical) !== count($boards)) {
                $errors[] = $gameCode . ': canonical board mapping mismatch';
            }

            foreach ($boards as $board) {
                $canonical = (string) ($board['canonical_key'] ?? '');
                $multiplier = $board['multiplier'] ?? null;
                if ($canonical === '') {
                    $errors[] = $gameCode . ': canonical board key missing';
                    continue;
                }
                if (!is_numeric($multiplier) || (float) $multiplier <= 0) {
                    $errors[] = $gameCode . ': invalid multiplier for board ' . $canonical;
                }
            }
        }

        $routeNames = [
            'game-final.api.state',
            'game-final.api.bet',
            'game-final.api.heartbeat',
            'game-final.api.history',
            'game-final.api.my-bets',
            'game-final.entry',
            'game-final.start',
            'thomas.admin.login',
            'thomas.admin.login.submit',
            'admin.dashboard',
            'admin.game-final.dashboard',
            'admin.game-final.games',
            'admin.game-final.rounds',
            'admin.game-final.rounds.detail',
            'admin.game-final.bets',
            'admin.game-final.users',
            'admin.game-final.users.profile',
            'admin.game-final.wallet-transfer',
            'admin.game-final.user-lock',
            'admin.game-final.user-lock.lift',
            'admin.game-final.payouts',
        ];

        foreach ($routeNames as $routeName) {
            if (!Route::has($routeName)) {
                $errors[] = 'Missing route: ' . $routeName;
            }
        }

        $this->verifyBoardFamilyMappings($errors);
        $this->verifyRuntimeSafetyConfig($errors);
        $this->verifyDatabaseCatalog($games, $errors);
        $this->verifyReleaseArtifacts($errors);

        if ($errors) {
            $this->error('Game Final production verification FAILED');
            foreach ($errors as $error) {
                $this->line(' - ' . $error);
            }
            return self::FAILURE;
        }

        $this->info('Game Final production verification PASSED for required ' . count($this->requiredGameCodes) . ' games.');
        return self::SUCCESS;
    }

    protected function verifyBoardFamilyMappings(array &$errors): void
    {
        $teenPattiExpected = ['A', 'B', 'C'];
        foreach ($this->requiredGameCodes as $gameCode) {
            if (strpos($gameCode, 'teen_patti') === 0) {
                $actual = BoardMapper::allCanonical($gameCode);
                sort($actual);
                $expected = $teenPattiExpected;
                sort($expected);
                if ($actual !== $expected) {
                    $errors[] = $gameCode . ': Teen Patti board map mismatch';
                }
            }

            if ($gameCode === 'lucky7_pro' || $gameCode === 'lucky88_master' || strpos($gameCode, 'lucky77') === 0) {
                $actual = BoardMapper::allCanonical($gameCode);
                $expected = ['melon', 'slot', 'plum'];
                sort($actual);
                sort($expected);
                if ($actual !== $expected) {
                    $errors[] = $gameCode . ': Lucky board map mismatch';
                }
            }

            if (strpos($gameCode, 'fruit_slot') === 0 || $gameCode === 'greedy') {
                $actual = BoardMapper::allCanonical($gameCode);
                if (count($actual) !== 8) {
                    $errors[] = $gameCode . ': eight-board room count must be 8';
                }
            }

            if (str_starts_with($gameCode, 'fruits_loop')) {
                $actual = BoardMapper::allCanonical($gameCode);
                if (count($actual) !== 3) {
                    $errors[] = $gameCode . ': Fruits Loop board count must be 3';
                }
            }
        }
    }

    protected function verifyRuntimeSafetyConfig(array &$errors): void
    {
        $adminSecret = trim((string) config('bd_game_final.admin_security.secret', ''));
        $adminHash = trim((string) config('bd_game_final.admin_security.secret_hash', ''));
        if ($adminHash === '' && strlen($adminSecret) < 24) {
            $errors[] = 'Admin security secret must be configured with at least 24 characters or a SHA-256 hash.';
        }
        if ($adminHash !== '' && !preg_match('/^[a-f0-9]{64}$/i', $adminHash)) {
            $errors[] = 'Admin security secret hash must be a SHA-256 hex string.';
        }

        $developerSecret = trim((string) env('BD_GAME_FINAL_DEVELOPER_PASSWORD', ''));
        $developerHash = trim((string) env('BD_GAME_FINAL_DEVELOPER_PASSWORD_HASH', ''));
        if ($developerSecret !== '' && strlen($developerSecret) < 24) {
            $errors[] = 'Developer app password is too weak; use 24+ characters, a SHA-256 hash, or leave app access disabled.';
        }
        if ($developerHash !== '' && !preg_match('/^[a-f0-9]{64}$/i', $developerHash)) {
            $errors[] = 'Developer app password hash must be a SHA-256 hex string.';
        }

        $packages = array_filter(array_map('trim', explode(',', (string) env('BD_GAME_FINAL_ALLOWED_APP_PACKAGES', ''))));
        foreach ($packages as $package) {
            if (preg_match('/(^|\\.)example(\\.|$)|demo|test/i', $package)) {
                $errors[] = 'Demo/test package name is not allowed in production app package config: ' . $package;
            }
        }
    }

    protected function verifyDatabaseCatalog(array $games, array &$errors): void
    {
        try {
            $dbGames = Game::query()
                ->whereIn('game_code', $this->requiredGameCodes)
                ->get()
                ->keyBy('game_code');

            foreach ($this->requiredGameCodes as $gameCode) {
                $game = $dbGames->get($gameCode);
                if (!$game) {
                    $errors[] = $gameCode . ': missing DB catalog game row';
                    continue;
                }

                $setting = GameSetting::query()->where('game_id', $game->id)->first();
                if (!$setting) {
                    $errors[] = $gameCode . ': missing DB settings row';
                    continue;
                }

                $cfg = (array) ($games[$gameCode] ?? []);
                foreach ([
                    'bet_duration_sec',
                    'stop_duration_sec',
                    'reveal_duration_sec',
                    'reveal_wait_sec',
                    'winner_popup_sec',
                    'winner_wait_sec',
                    'settle_duration_sec',
                    'settle_wait_sec',
                ] as $field) {
                    $expected = (float) ($cfg[$field] ?? 0);
                    $actual = (float) ($setting->{$field} ?? 0);
                    if ($expected > 0 && abs($actual - $expected) > 0.001) {
                        $errors[] = $gameCode . ': DB timing drift ' . $field . ' expected ' . $expected . ' actual ' . $actual;
                    }
                }
            }
        } catch (\Throwable $e) {
            $errors[] = 'Database catalog verification unavailable: ' . $e->getMessage();
        }
    }

    protected function verifyReleaseArtifacts(array &$errors): void
    {
        $paths = array_merge(
            File::glob(base_path('database/*.sql')) ?: [],
            File::glob(base_path('builds/*.sql')) ?: [],
            File::glob(base_path('builds/*.zip')) ?: [],
            File::glob(base_path('builds/**/*.sql')) ?: [],
            File::glob(base_path('builds/**/*.zip')) ?: []
        );

        foreach ($paths as $path) {
            $normalized = str_replace('\\', '/', $path);
            $errors[] = 'Unsafe release artifact present: ' . str_replace(str_replace('\\', '/', base_path()) . '/', '', $normalized);
        }
    }
}
