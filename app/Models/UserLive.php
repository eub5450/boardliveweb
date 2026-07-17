<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLive extends Model
{
    use HasFactory;
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function audiences(): HasMany
    {
        return $this->hasMany(AudienceJoin::class, 'host_id', 'user_id');
    }

    public function calls(): HasMany
    {
        return $this->hasMany(LiveCall::class, 'host_id', 'user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'reciever_id', 'user_id');
    }
   
}
