<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

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
        'frame',
        'is_agency',
        'is_coin_protal_active',
        'host_badge',
        'comment_badge',
        'balance',
        'api_token',
        'api_token_refresh',
        'game_api_key',
        'is_app_access',
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
        'api_token',
        'api_token_refresh',
        'game_api_key',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_app_access' => 'boolean',
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

    protected static function booted()
    {
        static::creating(function (User $user) {
            if (!$user->api_token) {
                $user->api_token = Str::random(80);
            }
            if (!$user->api_token_refresh) {
                $user->api_token_refresh = Str::random(80);
            }
            if (!$user->game_api_key) {
                $user->game_api_key = Str::random(48);
            }
        });
    }

    /**
     * Get the users who are following the user.
     */
    public function following()
    {
        return $this->hasMany(Follower::class, 'follower_id');
    }

    public function gameSecurityBlocks()
    {
        return $this->hasMany(\App\Models\GameFinal\GameSecurityBlock::class, 'user_id');
    }
}
