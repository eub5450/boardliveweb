<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
     protected $commands = [
        \App\Console\Commands\RunTaskEvery4Seconds::class, //ist only file name . but every min 
        \App\Console\Commands\FixGameIssues::class,    
        ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         // task:run-4sec - ছোট কমান্ড
            $schedule->command('task:run-every-4-seconds')
                ->everyMinute()
                ->withoutOverlapping()
                ->runInBackground()  // ✅ background-এ চালান
                ->appendOutputTo(storage_path('logs/app_corn_job.log'));
            
            // game:fix-all-issues - বড় কমান্ড
            $schedule->command('game:fix-all-issues')
                ->everyMinute()
                ->withoutOverlapping()
                ->runInBackground()  // ✅ background-এ চালান
                ->appendOutputTo(storage_path('logs/game-fix.log'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
