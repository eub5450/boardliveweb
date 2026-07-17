<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImieHistory extends Model
{
    use HasFactory;
     protected $fillable = [
        'imie',
        'user_id',
    ];
    public static function storeOnce($imei, $userId)
    {
        if (!$imei) return;
    
        self::firstOrCreate([
            'imie' => $imei,
            'user_id' => $userId
        ]);
    }

}
