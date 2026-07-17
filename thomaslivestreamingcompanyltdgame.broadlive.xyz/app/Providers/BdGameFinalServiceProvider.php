<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Console\Commands\BdGameFinalInstallCommand;
use App\Console\Commands\BdGameFinalIssueEntryTokenCommand;
use App\Console\Commands\BdGameFinalSyncCatalogCommand;
use App\Console\Commands\BdGameFinalTickCommand;
use App\Console\Commands\BdGameFinalValidateRegistryCommand;
use App\Console\Commands\BdGameFinalVerifyProductionCommand;
use App\Console\Commands\BdGameFinalWatchCommand;
use Illuminate\Support\Facades\Route;

class BdGameFinalServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(config_path('bd_game_final.php'), 'bd_game_final');
    }

    public function boot()
    {
        if (file_exists(base_path('routes/bd_game_final.php'))) {
            Route::middleware('web')->group(base_path('routes/bd_game_final.php'));
        }

        if ($this->app->runningInConsole()) {
            $this->commands([
                BdGameFinalInstallCommand::class,
                BdGameFinalIssueEntryTokenCommand::class,
                BdGameFinalSyncCatalogCommand::class,
                BdGameFinalTickCommand::class,
                BdGameFinalValidateRegistryCommand::class,
                BdGameFinalVerifyProductionCommand::class,
                BdGameFinalWatchCommand::class,
            ]);
        }
    }
}
