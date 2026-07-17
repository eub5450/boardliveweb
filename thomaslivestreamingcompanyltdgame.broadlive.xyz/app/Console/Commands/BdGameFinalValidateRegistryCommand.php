<?php

namespace App\Console\Commands;

use App\Models\GameFinal\Game;
use App\Models\GameFinal\GameBoard;
use App\Models\GameFinal\GameSetting;
use App\Support\GameFinal\GameRegistry;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\View;

class BdGameFinalValidateRegistryCommand extends Command
{
    protected $signature = 'bdgamefinal:validate-registry';
    protected $description = 'Validate configured game codes against GameRegistry mappings and Blade views';

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

    protected function expectedBoardRows(array $configBoards): array
    {
        return array_map(function (array $board, int $index) {
            return [
                'frontend_key' => (string) ($board['frontend_key'] ?? $board['canonical_key'] ?? ''),
                'canonical_key' => (string) ($board['canonical_key'] ?? ''),
                'display_name' => (string) ($board['display_name'] ?? ($board['canonical_key'] ?? '')),
                'payout_multiplier' => number_format((float) ($board['multiplier'] ?? 1), 2, '.', ''),
                'display_order' => $index + 1,
            ];
        }, array_values($configBoards), array_keys(array_values($configBoards)));
    }

    protected function actualBoardRows(int $gameId): array
    {
        return GameBoard::query()
            ->where('game_id', $gameId)
            ->where('is_active', 1)
            ->orderBy('display_order')
            ->get(['frontend_key', 'canonical_key', 'display_name', 'payout_multiplier', 'display_order'])
            ->map(function (GameBoard $board) {
                return [
                    'frontend_key' => (string) $board->frontend_key,
                    'canonical_key' => (string) $board->canonical_key,
                    'display_name' => (string) $board->display_name,
                    'payout_multiplier' => number_format((float) $board->payout_multiplier, 2, '.', ''),
                    'display_order' => (int) $board->display_order,
                ];
            })
            ->values()
            ->all();
    }

    public function handle()
    {
        $configuredMap = (array) config('bd_game_final.games', []);
        $configuredGames = array_keys($configuredMap);
        $registryViews = GameRegistry::views();
        $registryGames = array_keys($registryViews);

        $missingMappings = array_values(array_diff($configuredGames, $registryGames));
        $extraMappings = array_values(array_diff($registryGames, $configuredGames));
        $missingViews = [];
        $missingGames = [];
        $inactiveGames = [];
        $missingSettings = [];
        $boardDrift = [];
        $timingDrift = [];
        $invalidTiming = [];
        $invalidBoards = [];

        $missingRequiredConfig = array_values(array_diff($this->requiredGameCodes, $configuredGames));
        $missingRequiredRegistry = array_values(array_diff($this->requiredGameCodes, $registryGames));
        $unexpectedConfigured = array_values(array_diff($configuredGames, $this->requiredGameCodes));

        $dbGames = Game::query()
            ->whereIn('game_code', $configuredGames)
            ->get()
            ->keyBy('game_code');

        foreach ($registryViews as $gameCode => $viewName) {
            if (!View::exists($viewName)) {
                $missingViews[] = [
                    'game_code' => $gameCode,
                    'view' => $viewName,
                ];
            }
        }

        foreach ($configuredMap as $gameCode => $cfg) {
            $timings = [
                'bet_duration_sec' => (float) ($cfg['bet_duration_sec'] ?? 0),
                'stop_duration_sec' => (float) ($cfg['stop_duration_sec'] ?? 0),
                'reveal_duration_sec' => (float) ($cfg['reveal_duration_sec'] ?? 0),
                'reveal_wait_sec' => (float) ($cfg['reveal_wait_sec'] ?? 0),
                'winner_popup_sec' => (float) ($cfg['winner_popup_sec'] ?? 0),
                'winner_wait_sec' => (float) ($cfg['winner_wait_sec'] ?? 0),
                'settle_duration_sec' => (float) ($cfg['settle_duration_sec'] ?? 0),
                'settle_wait_sec' => (float) ($cfg['settle_wait_sec'] ?? 0),
            ];
            foreach ($timings as $field => $value) {
                if ($value <= 0) {
                    $invalidTiming[] = [
                        'game_code' => $gameCode,
                        'field' => $field,
                        'value' => (string) $value,
                    ];
                }
            }

            $boards = (array) ($cfg['boards'] ?? []);
            if (empty($boards)) {
                $invalidBoards[] = [
                    'game_code' => $gameCode,
                    'reason' => 'boards_missing',
                ];
            } else {
                foreach ($boards as $board) {
                    $canonical = (string) ($board['canonical_key'] ?? '');
                    $multiplier = $board['multiplier'] ?? null;
                    if ($canonical === '') {
                        $invalidBoards[] = [
                            'game_code' => $gameCode,
                            'reason' => 'canonical_key_missing',
                        ];
                        continue;
                    }
                    if (!is_numeric($multiplier) || (float) $multiplier <= 0) {
                        $invalidBoards[] = [
                            'game_code' => $gameCode,
                            'reason' => 'invalid_multiplier:' . $canonical,
                        ];
                    }
                }
            }

            /** @var Game|null $game */
            $game = $dbGames->get($gameCode);
            if (!$game) {
                $missingGames[] = $gameCode;
                continue;
            }

            if ((int) $game->is_active !== 1) {
                $inactiveGames[] = $gameCode;
            }

            $setting = GameSetting::query()->where('game_id', $game->id)->first();
            if (!$setting) {
                $missingSettings[] = $gameCode;
            } else {
                foreach ($timings as $field => $expectedValue) {
                    $actualValue = (float) ($setting->{$field} ?? 0);
                    if (abs($actualValue - (float) $expectedValue) > 0.001) {
                        $timingDrift[] = [
                            'game_code' => $gameCode,
                            'field' => $field,
                            'expected' => (string) $expectedValue,
                            'actual' => (string) $actualValue,
                        ];
                    }
                }
            }

            $expectedBoards = $this->expectedBoardRows((array) ($cfg['boards'] ?? []));
            $actualBoards = $this->actualBoardRows((int) $game->id);
            if ($expectedBoards !== $actualBoards) {
                $boardDrift[] = [
                    'game_code' => $gameCode,
                    'expected' => json_encode($expectedBoards, JSON_UNESCAPED_UNICODE),
                    'actual' => json_encode($actualBoards, JSON_UNESCAPED_UNICODE),
                ];
            }
        }

        if (!$missingMappings && !$extraMappings && !$missingViews && !$missingGames && !$inactiveGames && !$missingSettings && !$boardDrift && !$timingDrift && !$invalidTiming && !$invalidBoards && !$missingRequiredConfig && !$missingRequiredRegistry) {
            $this->info(sprintf(
                'Game registry OK: %d configured codes, %d mapped views, DB catalog aligned.',
                count($configuredGames),
                count($registryViews)
            ));

            return self::SUCCESS;
        }

        if ($missingRequiredConfig) {
            $this->error('Required game codes missing from config/bd_game_final.php:');
            foreach ($missingRequiredConfig as $gameCode) {
                $this->line(' - ' . $gameCode);
            }
        }

        if ($missingRequiredRegistry) {
            $this->error('Required game codes missing from GameRegistry::views():');
            foreach ($missingRequiredRegistry as $gameCode) {
                $this->line(' - ' . $gameCode);
            }
        }

        if ($unexpectedConfigured) {
            $this->error('Unexpected configured game codes outside required 23:');
            foreach ($unexpectedConfigured as $gameCode) {
                $this->line(' - ' . $gameCode);
            }
        }

        if ($missingMappings) {
            $this->error('Configured game codes missing from GameRegistry:');
            foreach ($missingMappings as $gameCode) {
                $this->line(' - ' . $gameCode);
            }
        }

        if ($extraMappings) {
            $this->error('GameRegistry entries missing from config/bd_game_final.php:');
            foreach ($extraMappings as $gameCode) {
                $this->line(' - ' . $gameCode);
            }
        }

        if ($missingViews) {
            $this->error('GameRegistry entries pointing at missing Blade views:');
            $this->table(['Game code', 'View'], $missingViews);
        }

        if ($missingGames) {
            $this->error('Configured game codes missing from bd_game_final_games:');
            foreach ($missingGames as $gameCode) {
                $this->line(' - ' . $gameCode);
            }
        }

        if ($inactiveGames) {
            $this->error('Configured game codes present but inactive in bd_game_final_games:');
            foreach ($inactiveGames as $gameCode) {
                $this->line(' - ' . $gameCode);
            }
        }

        if ($missingSettings) {
            $this->error('Configured game codes missing bd_game_final_settings rows:');
            foreach ($missingSettings as $gameCode) {
                $this->line(' - ' . $gameCode);
            }
        }

        if ($boardDrift) {
            $this->error('Configured game codes with active board rows drifting from config/bd_game_final.php:');
            $this->table(['Game code', 'Expected', 'Actual'], $boardDrift);
        }

        if ($timingDrift) {
            $this->error('Configured game codes with DB timing drifting from config/bd_game_final.php:');
            $this->table(['Game code', 'Field', 'Expected', 'Actual'], $timingDrift);
        }

        if ($invalidTiming) {
            $this->error('Invalid game timing values in config/bd_game_final.php:');
            $this->table(['Game code', 'Field', 'Value'], $invalidTiming);
        }

        if ($invalidBoards) {
            $this->error('Invalid board definitions in config/bd_game_final.php:');
            $this->table(['Game code', 'Reason'], $invalidBoards);
        }

        return self::FAILURE;
    }
}
