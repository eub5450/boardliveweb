<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $existingApiControllers = ['AuthController', 'AgoraController', 'UserLiveController'];

        foreach (glob(app_path('Http/Controllers/Api/V3/*Controller.php')) ?: [] as $controllerPath) {
            $controllerName = pathinfo($controllerPath, PATHINFO_FILENAME);
            $target = "App\\Http\\Controllers\\Api\\V3\\{$controllerName}";
            if (!class_exists($target)) {
                continue;
            }

            if (!in_array($controllerName, $existingApiControllers, true)) {
                $apiAlias = "App\\Http\\Controllers\\Api\\{$controllerName}";
                if (!class_exists($apiAlias, false)) {
                    class_alias($target, $apiAlias);
                }
            }

            $v2Alias = "App\\Http\\Controllers\\Api\\V2\\{$controllerName}";
            if (!class_exists($v2Alias, false)) {
                class_alias($target, $v2Alias);
            }
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
