<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VipSetupConfig extends Model
{
    protected $table = 'vip_setup_configs';

    protected $fillable = [
        'config_key',
        'config_json',
    ];

    /**
     * Convenience accessor: decodes the config_json blob into an array.
     * Usage: $row->config_array
     */
    public function getConfigArrayAttribute()
    {
        $raw = $this->attributes['config_json'] ?? null;
        if (empty($raw)) {
            return [];
        }
        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }
}
