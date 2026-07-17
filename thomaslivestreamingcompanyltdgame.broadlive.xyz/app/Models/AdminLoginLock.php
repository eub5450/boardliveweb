<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLoginLock extends Model
{
    protected $fillable = [
        'scope',
        'email',
        'attempts',
        'locked_until',
        'last_ip',
        'last_user_agent',
    ];

    protected $casts = [
        'attempts' => 'integer',
        'locked_until' => 'datetime',
    ];
}
