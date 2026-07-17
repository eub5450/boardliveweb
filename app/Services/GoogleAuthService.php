<?php

namespace App\Services;

use App\Models\User;
use App\Models\ImieHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class GoogleAuthService
{
    public static function login($request)
    {
        // ??? GET USER OR CREATE
        $user = self::firstOrCreateGoogleUser($request);

        // ✅ BAN CHECK
        if ($user->ban_type) return self::banMessage($user->ban_type);

        // ✅ LOGIN + TOKEN
        Auth::login($user);
        $token = $user->createToken('apptoken')->plainTextToken;

        // ✅ UPDATE DEVICE & IMEI
        $user->update([
            'device_id' => $request->device_id,
            'imei_number' => $user->id == 1111 ? 'd4e9aeb782727b07ef' : (string) ($request->imei_number ?? '')
        ]);

        // ✅ SAVE IMEI HISTORY
        ImieHistory::firstOrCreate(['imie' => (string) ($request->imei_number ?? ''), 'user_id' => $user->id]);

        // ✅ RETURN RESPONSE
        return [
            'code' => 200,
            'message' => 'Login Successfully',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'profile' => $user->profile,
                'balance' => $user->balance,
                'password' => $user->password,
                'email' => $user->email,
                'phone' => $user->phone,
                'level' => $user->level,
                'is_host_id' => $user->is_host_id,
                'is_agency' => $user->is_agency,
                'status' => $user->status,
                'host_type' => optional($user->hostData)->hosting_type ?? 0,
                'brd_off_power' => $user->brd_off_power,
                'can_invisible' => $user->is_invisible,
                'role' => $user->role,
                'token' => $token,
                'sceen_short_power' => $user->sceen_short_power,
                'comment_mute_power' => $user->comment_mute_power,
                'kick_power' => $user->kick_power
            ]
        ];
    }

    private static function firstOrCreateGoogleUser($request)
    {
        $attributes = ['email' => $request->email];
        $values = [
            'name' => "New User",
            'device_id' => $request->device_id,
            'imei_number' => (string) ($request->imei_number ?? ''),
            'phone' => self::nextUniquePhone(),
            'level' => 1,
            'is_vip' => 0,
            'is_agency' => 0,
            'comment_mute_power' => 0,
            'sceen_short_power' => 0,
            'is_coin_protal_active' => 0,
            'kick_power' => 0,
            'is_host_id' => 0,
            'profile' => 'store/profile/default.png',
            'balance' => 0,
            'entry_level' => 0,
            'role' => 2,
            'status' => 1,
            'password' => Hash::make(123456)
        ];

        for ($attempt = 0; $attempt < 5; $attempt++) {
            try {
                $values['phone'] = self::nextUniquePhone($attempt);
                return User::firstOrCreate($attributes, $values);
            } catch (QueryException $e) {
                $message = $e->getMessage();
                if (strpos($message, 'users_phone_unique') === false && strpos($message, 'Duplicate entry') === false) {
                    throw $e;
                }
            }
        }

        throw $e ?? new \RuntimeException('Unable to allocate unique Google login phone');
    }

    private static function nextUniquePhone($offset = 0)
    {
        $candidate = (int) User::max('id') + 1 + (int) $offset;

        while (User::where('phone', (string) $candidate)->exists()) {
            $candidate++;
        }

        return (string) $candidate;
    }

    private static function banMessage($type)
    {
        switch ($type) {
            case 'B':
                $message = 'Banned for One Month (Rule B)';
                break;
    
            case 'C':
                $message = 'Banned for 24 Hours (Rule C)';
                break;
    
            case 'D':
                $message = 'Banned for 1 Hour (Rule D)';
                break;
    
            default:
                $message = 'Permanent Ban (Rule A)';
                break;
        }
    
        return [
            'code' => 404,
            'message' => $message,
        ];
    }

}
