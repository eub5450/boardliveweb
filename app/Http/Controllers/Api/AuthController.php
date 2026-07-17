<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BanDevice;
use App\Services\AuthService;
use App\Services\PasswordService;
use App\Services\GoogleAuthService;
use App\Services\VersionService;
class AuthController extends Controller
{
    public function login(Request $request)
    {
        
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
    
        if (
            BanDevice::isBanned($request->device_id) ||
            BanDevice::isBanned($request->imei_number)
        ) {
            return response()->json(['message' => 'Device Banned'], 403);
        }
    
        $result = AuthService::login($request);
    
        return response()->json($result, $result['code']);
    }
    
   public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    
        return response()->json([
            'message' => 'Successfully Logout',
            'code' => 200
        ]);
    }

   
    public function changePassword(Request $request)
    {
        
        $request->validate([
            'user_id' => 'required|integer',
            'new_password' => 'required'
        ]);
    
        $result = PasswordService::change($request->user_id, $request->new_password);
    
        return response()->json($result, $result['code']);
    }

     public function GoogleLogin(Request $request)
    {
       
     
    
        $result = GoogleAuthService::login($request);
    
        return response()->json($result, $result['code']);
    } 
    
   public function VarsionInfo(Request $request)
    {
        $data = VersionService::getInfo();
    
        return response()->json($data, $data['code']);
    }
}
