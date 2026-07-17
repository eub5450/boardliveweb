<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;
   public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the user who is following.
     */
    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }
   
    public function userLive()
    {
        return $this->belongsTo(UserLive::class,'follower_id','user_id');
    }
}
