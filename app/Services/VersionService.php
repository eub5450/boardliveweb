<?php

namespace App\Services;

use App\Models\Setting;

class VersionService
{
    public static function getInfo()
    {
        $setting = Setting::findOrFail(1);

        return [
            'code' => 200,
            'message' => 'Version Info Found',
            'version' => $setting->app_version,
            'flutter_version' => $setting->flutter_version,
            'pusher_app_id' => $setting->app_id,
            'pusher_key' => $setting->key,
            'pusher_cluster' => $setting->cluster,
            'pusher_secret' => $setting->secret,
            'agora_appId' => $setting->appId,
            'agora_appCertificate' => $setting->appCertificate,
            'old_app_package' => $setting->old_app_package,
            'web_socket' => $setting->web_socket,
            'pro_game'=>$setting->pro_game
        ];
    }
}
