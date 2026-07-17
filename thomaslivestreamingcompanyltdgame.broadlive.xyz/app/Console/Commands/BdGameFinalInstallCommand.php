<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BdGameFinalInstallCommand extends Command
{
    protected $signature = 'bdgamefinal:install {--migrate : Run database migrations} {--sync-catalog : Sync configured game catalog after migrate}';
    protected $description = 'Install helper command for BD Game Final';

    public function handle()
    {
        if ($this->option('migrate')) {
            $this->call('migrate', ['--force' => true]);
        } else {
            $this->info('Run php artisan migrate, or use --migrate.');
        }

        if ($this->option('sync-catalog')) {
            $this->call('bdgamefinal:sync-catalog');
        }

        $this->info('Provider must be registered: App\\Providers\\BdGameFinalServiceProvider::class');

        return 0;
    }
}
