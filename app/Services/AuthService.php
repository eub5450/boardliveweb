<?php

namespace App\Services;

use App\Models\User;
use App\Models\BanDevice;
use App\Models\ImieHistory;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public static function login($request)
    {
        $user = User::where('email', $request->email)
            ->notBanned()
            ->with('hostData')
            ->first();

        if (!$user) {
            return ['code' => 404, 'message' => 'User Not Found'];
        }

        if ($user->status == 2) {
            return ['code' => 401, 'message' => 'Account Suspended'];
        }

        if ($user->status != 1) {
            return ['code' => 403, 'message' => 'Account Not Verified'];
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return ['code' => 401, 'message' => 'Unauthorized Password'];
        }

        // ✅ Token
        $token = $user->createToken('apptoken')->plainTextToken;

        // ✅ Update Device & IMEI
        $user->device_id = $request->device_id;

       $user->imei_number = $user->id == 1111 ? 'd4e9aeb782727b07ef' : $request->imei_number;


        $user->save();

        // ✅ Save IMEI History
        if ($request->imei_number) {
            ImieHistory::firstOrCreate([
                'imie' => $request->imei_number,
                'user_id' => $user->id
            ]);
        }

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
                'kick_power' => $user->kick_power,
            
            ]
        ];
    }
}
