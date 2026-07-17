<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanDevice extends Model
{
    use HasFactory;
    public static function isBanned($value)
    {
        return self::where('device_id', $value)->exists();
    }
}
