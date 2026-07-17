<?php

namespace App\Services;

use App\Models\User;

class PasswordService
{
    public static function change($userId, $newPassword)
    {
        $user = User::find($userId);

        if (!$user) {
            return ['code' => 404, 'message' => 'User Not Found'];
        }

        $user->changePassword($newPassword);

        return [
            'code' => 200,
            'message' => 'Password Change Successfully'
        ];
    }
}
