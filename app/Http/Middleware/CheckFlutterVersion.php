<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Log;
class CheckFlutterVersion
{
    public function handle(Request $request, Closure $next)
    {
        $requiredVersion = Setting::find(1)->flutter_version;
        $flutterVersion = $request->get('flutter_version');; 
        // better to send via header instead of body
         Log::info('Flutter version received in middleware', [
        'user_id' => $request->get('user_id'),
        'flutter_version' => $flutterVersion
        ]);

        if (!$flutterVersion) {
              Log::warning('Blocked request due to No flutter version', [
            'user_id' => $request->get('user_id'),
            'need_version' =>$requiredVersion,
            'flutter_version' => $flutterVersion
        ]);
            return response()->json([
                'status' => false,
                'message' => 'App version is required.'
            ], 400);
        }

        // Force update if version is lower
        if (version_compare($flutterVersion, $requiredVersion, '<')) {
              Log::warning('Blocked request due to old flutter version', [
            'user_id' => $request->query('user_id'),
            'need_version' =>$requiredVersion,
            'flutter_version' => $flutterVersion
        ]);
            return response()->json([
                'status' => false,
                'force_update' => true,
                'message' => 'Please update your app to continue.'
            ], 426); // 426 = Upgrade Required
        }

        return $next($request);
    }
}