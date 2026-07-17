<?php

namespace App\Console\Commands;

use App\Models\GameFinal\Game;
use App\Models\GameFinal\GameBoard;
use App\Models\GameFinal\GameSetting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BdGameFinalSyncCatalogCommand extends Command
{
    protected $signature = 'bdgamefinal:sync-catalog';
    protected $description = 'Sync configured BD Game Final games, settings, and boards into the play catalog';

    public function handle()
    {
        $configuredGames = (array) config('bd_game_final.games', []);
        if (!$configuredGames) {
            $this->error('No games configured in config/bd_game_final.php');
            return self::FAILURE;
        }

        $stats = [
            'games_created' => 0,
            'games_updated' => 0,
            'settings_created' => 0,
            'settings_updated' => 0,
            'boards_created' => 0,
            'boards_updated' => 0,
            'boards_deactivated' => 0,
        ];

        DB::transaction(function () use ($configuredGames, &$stats) {
            $sortOrder = 1;

            foreach ($configuredGames as $gameCode => $cfg) {
                $game = Game::firstOrNew(['game_code' => $gameCode]);
                $isNewGame = !$game->exists;

                $game->name = (string) ($cfg['name'] ?? $gameCode);
                $game->is_active = 1;
                $game->frontend_slug = $game->frontend_slug ?: str_replace('_', '-', $gameCode);
                $game->sort_order = $sortOrder++;

                if ($isNewGame || $game->isDirty()) {
                    $game->save();
                    $stats[$isNewGame ? 'games_created' : 'games_updated'] += 1;
                }

                $setting = GameSetting::firstOrNew(['game_id' => $game->id]);
                $isNewSetting = !$setting->exists;
                $boardCount = count((array) ($cfg['boards'] ?? []));
                $setting->bet_duration_sec = (int) ($cfg['bet_duration_sec'] ?? 20);
                $setting->start_bet_popup_sec = (float) ($cfg['start_bet_popup_sec'] ?? 3);
                $setting->start_bet_wait_sec = (float) ($cfg['start_bet_wait_sec'] ?? 1.5);
                $setting->stop_bet_popup_sec = (float) ($cfg['stop_bet_popup_sec'] ?? 3);
                $setting->stop_bet_wait_sec = (float) ($cfg['stop_bet_wait_sec'] ?? 1.5);
                $setting->stop_duration_sec = (float) ($cfg['stop_duration_sec'] ?? ((float) $setting->stop_bet_popup_sec + (float) $setting->stop_bet_wait_sec));
                $setting->reveal_duration_sec = (float) ($cfg['reveal_duration_sec'] ?? 6);
                $setting->reveal_wait_sec = (float) ($cfg['reveal_wait_sec'] ?? 2);
                $setting->winner_popup_sec = (float) ($cfg['winner_popup_sec'] ?? 1);
                $setting->winner_wait_sec = (float) ($cfg['winner_wait_sec'] ?? 0.5);
                $setting->settle_duration_sec = (float) ($cfg['settle_duration_sec'] ?? 2.5);
                $setting->settle_wait_sec = (float) ($cfg['settle_wait_sec'] ?? 1);
                $setting->max_distinct_boards_per_user = (int) ($cfg['max_distinct_boards_per_user'] ?? max(1, count((array) ($cfg['boards'] ?? []))));
                $setting->game_status = 'active';

                if ($isNewSetting || $setting->isDirty()) {
                    $setting->save();
                    $stats[$isNewSetting ? 'settings_created' : 'settings_updated'] += 1;
                }

                $expectedCanonicals = [];
                foreach (array_values((array) ($cfg['boards'] ?? [])) as $index => $boardCfg) {
                    $canonicalKey = (string) ($boardCfg['canonical_key'] ?? '');
                    if ($canonicalKey === '') {
                        continue;
                    }

                    $expectedCanonicals[] = $canonicalKey;

                    $board = GameBoard::firstOrNew([
                        'game_id' => $game->id,
                        'canonical_key' => $canonicalKey,
                    ]);
                    $isNewBoard = !$board->exists;

                    $board->frontend_key = (string) ($boardCfg['frontend_key'] ?? $canonicalKey);
                    $board->display_name = (string) ($boardCfg['display_name'] ?? $canonicalKey);
                    $board->payout_multiplier = (float) ($boardCfg['multiplier'] ?? 1);
                    $board->display_order = $index + 1;
                    $board->is_active = 1;

                    if ($isNewBoard || $board->isDirty()) {
                        $board->save();
                        $stats[$isNewBoard ? 'boards_created' : 'boards_updated'] += 1;
                    }
                }

                if ($expectedCanonicals) {
                    $stats['boards_deactivated'] += GameBoard::query()
                        ->where('game_id', $game->id)
                        ->whereNotIn('canonical_key', $expectedCanonicals)
                        ->where('is_active', 1)
                        ->update(['is_active' => 0]);
                }
            }
        });

        $this->info(sprintf(
            'Catalog sync complete: %d games created, %d games updated, %d settings created, %d settings updated, %d boards created, %d boards updated, %d boards deactivated.',
            $stats['games_created'],
            $stats['games_updated'],
            $stats['settings_created'],
            $stats['settings_updated'],
            $stats['boards_created'],
            $stats['boards_updated'],
            $stats['boards_deactivated']
        ));

        return self::SUCCESS;
    }
}
