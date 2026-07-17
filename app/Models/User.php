<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   protected $fillable = [
    'name',
    'email',
    'password',
    'phone',
    'profile',
    'balance',
    'level',
    'role',
    'status',

    // device / login
    'device_id',
    'imei_number',

    // permissions / flags
    'is_agency',
    'is_coin_protal_active',
    'is_host_id',
    'comment_mute_power',
    'sceen_short_power',
    'kick_power',

    // UI
    'frame',
    'host_badge',
    'comment_badge'
];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    public function followers()
    {
        return $this->hasMany(Follower::class, 'user_id');
    }

    /**
     * Get the users who are following the user.
     */
    public function following()
    {
        return $this->hasMany(Follower::class, 'follower_id');
    }
     /* =========================================
        RELATIONSHIPS
    ========================================= */

    // Gifts Sent by User
    public function sentGifts()
    {
        return $this->hasMany(Gift::class, 'sander_id');
    }

    // Gifts Received by User
    public function receivedGifts()
    {
        return $this->hasMany(Gift::class, 'reciever_id');
    }
    public function hostData()
    {
        return $this->hasOne(HostData::class);
    }
    
    public function imeiHistory()
    {
        return $this->hasMany(ImieHistory::class);
    }
    public function scopeNotBanned($query)
    {
        return $query->whereNull('ban_type');
    }
    public function changePassword($newPassword)
    {
        $this->password = Hash::make($newPassword);
        return $this->save();
    }
    public function hostLive()
    {
        return $this->hasOne(UserLive::class, 'user_id');
    }

    public function withdraws()
    {
        return $this->hasMany(Withdraw::class, 'host_id');
    }
}
