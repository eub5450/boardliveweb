<?php

namespace App\Http\Controllers\Api\V4;

use Illuminate\Http\Request;

class AuthController extends \App\Http\Controllers\Api\AuthController
{
    public function Logout(Request $request)
    {
        return parent::logout($request);
    }

    public function ChangePassword(Request $request)
    {
        return parent::changePassword($request);
    }

    public function UserData(Request $request)
    {
        return response()->json([
            'message' => 'Login User Data',
            'code' => 200,
            'data' => $request->user(),
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
