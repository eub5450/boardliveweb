<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Setting;

class CheckAppMaintenanceMode
{
    /**
     * Global kill-switch for the Flutter app's API traffic. Toggled from the
     * admin dashboard (Auth::id() == 11133 only) via
     * Admin\DashbordController::ToggleMaintenanceMode. Cached briefly so a
     * live-traffic app doesn't hit the DB on every single request.
     */
    public function handle(Request $request, Closure $next)
    {
        $isMaintenance = Cache::remember('app_maintenance_mode', 5, function () {
            $setting = Setting::find(1);
            return $setting ? (bool) $setting->maintenance_mode : false;
        });

        if ($isMaintenance) {
            return response()->json([
                'code' => '503',
                'message' => 'The app is temporarily under maintenance. Please try again shortly.',
            ], 503);
        }

        return $next($request);
    }
}
