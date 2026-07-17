<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VipSetupConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VipSetupController extends Controller
{
    public function Index(Request $request)
    {
        $config = Cache::remember('vip_setup_config', 300, function () {
            $row = VipSetupConfig::where('config_key', 'vip_setup')->first();
            if (!$row) {
                return [];
            }
            $decoded = json_decode($row->config_json, true);
            return is_array($decoded) ? $decoded : [];
        });

        return response()->json([
            'code' => 200,
            'data' => $config,
        ]);
    }
}
