<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use App\Jobs\GameFinal\AdvanceGameRoundJob;

class BdGameFinalTickCommand extends Command
{
    protected $signature = 'bdgamefinal:tick {gameCode?} {--dispatch}';
    protected $description = 'Advance phases and settle due rounds';

    public function handle()
    {
        $codes = $this->argument('gameCode') ? [$this->argument('gameCode')] : array_keys((array) config('bd_game_final.games', []));
        $dispatch = (bool) $this->option('dispatch');

        foreach ($codes as $code) {
            $lockKey = 'bdgf:tick-command:' . (string) $code;
            if (!Cache::add($lockKey, 1, 8)) {
                $this->line($code . ' skipped (tick lock active)');
                continue;
            }

            try {
                $job = new AdvanceGameRoundJob($code);

                if ($dispatch) {
                    dispatch($job);
                    $this->info($code . ' dispatched tick job');
                    continue;
                }

                app()->call([$job, 'handle']);
                $this->info($code . ' ran tick job');
            } finally {
                Cache::forget($lockKey);
            }
        }

        return 0;
    }
}
