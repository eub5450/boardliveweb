<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class BdGameFinalWatchCommand extends Command
{
    protected $signature = 'bdgamefinal:watch {gameCode?} {--sleep=1} {--once} {--cycles=0} {--dispatch}';
    protected $description = 'Watch loop for GameFinal round automation';

    public function handle()
    {
        $codes = $this->argument('gameCode') ? [$this->argument('gameCode')] : array_keys((array) config('bd_game_final.games', []));
        $sleep = max(1, (int) $this->option('sleep'));
        $dispatch = (bool) $this->option('dispatch');
        $maxCycles = max(0, (int) $this->option('cycles'));

        $lockTtl = max(30, ($maxCycles > 0 ? ($maxCycles * $sleep) : 65) + 10);
        $scope = $this->argument('gameCode') ? (string) $this->argument('gameCode') : 'all';
        $lockKey = 'bdgf:watch-command:' . $scope;

        if (!Cache::add($lockKey, 1, $lockTtl)) {
            $this->warn('watch command skipped (lock active)');
            return 0;
        }

        try {
            $cycles = 0;

            do {
                $cycles++;
                foreach ($codes as $code) {
                    $exitCode = $this->call('bdgamefinal:tick', [
                        'gameCode' => $code,
                        '--dispatch' => $dispatch,
                    ]);

                    if ($exitCode !== 0) {
                        $this->error(date('H:i:s') . ' tick failed for ' . $code);
                    }
                }

                if ($this->option('once')) {
                    break;
                }

                if ($maxCycles > 0 && $cycles >= $maxCycles) {
                    break;
                }

                sleep($sleep);
            } while (true);
        } finally {
            Cache::forget($lockKey);
        }

        return 0;
    }
}
