<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;
     public function gifts()
    {
        return $this->hasMany(Gift::class, 'agency_code', 'code');
    }
}
