<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [];

    protected function schedule(Schedule $schedule)
    {
        // Production automation: ensure one scheduler instance runs per minute via server cron.
        // Cron example: * * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
        $schedule->command('bdgamefinal:watch --sleep=1 --cycles=55')
            ->everyMinute()
            ->withoutOverlapping(2)
            ->runInBackground();

        $schedule->command('bdgamefinal:compact-db --hours=1 --keep-per-game=10 --history-hours=6 --target-mb=5 --token-hours=2 --heartbeat-hours=2 --audit-hours=6 --force')
            ->everyTenMinutes()
            ->withoutOverlapping(20);
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
