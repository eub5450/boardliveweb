<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveCall extends Model
{
    use HasFactory;
    public function coHost()
    {
        return $this->belongsTo(User::class, 'co_host_id');
    }

    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }
}
