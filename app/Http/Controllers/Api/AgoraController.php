<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Willywes\AgoraSDK\RtcTokenBuilder;
use App\Models\User;
use App\Models\Setting;
use App\Models\BanDevice;
class AgoraController extends Controller
{
   
    public static function GetToken($user_id, $appID, $appCertificate, $channelName)
    {
         $response = array();
         //$ban_device=BanDevice::where('device_id',$device_id)->first();
            $banned=User::where('ban_type','!=',Null)->where('id',$user_id)->first();
           // if(!$ban_device){
            if(!$banned){
        $appID = trim((string) $appID);
        $appCertificate = trim((string) $appCertificate);
        $channelName = trim((string) $channelName);
        $uid = $user_id;
        $uidStr = ($user_id) . '';
        $user=User::find($user_id);
        $role = RtcTokenBuilder::RoleAttendee;
        if($user_id==29219 && $user_id==25697 ){
             $expireTimeInSeconds = 60;
        }else{
            $expireTimeInSeconds = 10800;
        }
        if (!$appID || !$appCertificate || !$channelName || !$uid) {
            array_push($response, array('message' => 'Missing token configuration', 'code' => '422'));
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }
        if(!$user){
            array_push($response, array('message' => 'Device not authorized', 'code' => '404'));
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }
        if($user->imei_number!='680ae8ebcc9abdf8'){
        
        $currentTimestamp = (new \DateTime("now", new \DateTimeZone('UTC')))->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

        try {
            return RtcTokenBuilder::buildTokenWithUid($appID, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);
        } catch (\Throwable $e) {
            \Log::warning('Broadlive Agora token generation failed', [
                'user_id' => $user_id,
                'channel_hash' => hash('sha256', $channelName),
                'error' => $e->getMessage(),
            ]);
            array_push($response, array('message' => 'Token generation failed', 'code' => '500'));
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }
        }
            }else{
              if($banned->ban_type=="B"){
                array_push($response, array('message' => 'Opps !! Your ID Banned For One Month . violation Rules B', 'code' => '404'));
              }elseif($banned->ban_type=="C"){
                array_push($response, array('message' => 'Opps !! Your ID Banned For 24 Hours . violation Rules C', 'code' => '404'));
              }
              elseif($banned->ban_type=="D"){
                array_push($response, array('message' => 'Opps !! Your ID Banned For 1 Hours . violation Rules D', 'code' => '404'));
              }else{
               array_push($response, array('message' => 'Opps !!  You Are Permanent Benned . violation Rules A', 'code' => '404'));
              }
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            // return response()->json(['message'=>"User Not Found"],404);
            }
        // }else{
        //         array_push($response,array('message'=>'Opps !! You Are Permanent Ben','code'=>'404'));
        //         return json_encode($response,JSON_UNESCAPED_UNICODE);
        //     // return response()->json(['message'=>"User Not Found"],404);
        //     }
    }


    public function generateToken(Request $request)
    {
       //  $ban_device=BanDevice::where('device_id',$device_id)->first();
            $response = array();
            $banned=User::where('ban_type','!=',Null)->where('id',$request->user_id)->first();
         //   if(!$ban_device){
            if(!$banned){
                $appID = $request->appID;
                $appCertificate = $request->appCertificate;
                $channelName =  $request->channelName;
        
                $uid = $request->user_id;

                if (!trim((string) $appID) || !trim((string) $appCertificate) || !trim((string) $channelName) || !trim((string) $uid)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Missing token configuration',
                        'code' => 422,
                    ], 422);
                }
                
                $agora_token = AgoraController::GetToken($uid,  $appID, $appCertificate, $channelName);
        
                return response()->json([
                    'success' => true,
                    'data' => $agora_token
                ]);
            }else{
              if($banned->ban_type=="B"){
                array_push($response, array('message' => 'Opps !! Your ID Banned For One Month . violation Rules B', 'code' => '404'));
              }elseif($banned->ban_type=="C"){
                array_push($response, array('message' => 'Opps !! Your ID Banned For 24 Hours . violation Rules C', 'code' => '404'));
              }
              elseif($banned->ban_type=="D"){
                array_push($response, array('message' => 'Opps !! Your ID Banned For 1 Hours . violation Rules D', 'code' => '404'));
              }else{
               array_push($response, array('message' => 'Opps !!  You Are Permanent Benned . violation Rules A', 'code' => '404'));
              }
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            // return response()->json(['message'=>"User Not Found"],404);
            }
        // }else{
        //         array_push($response,array('message'=>'Opps !! You Are Permanent Ben','code'=>'404'));
        //         return json_encode($response,JSON_UNESCAPED_UNICODE);
        //     // return response()->json(['message'=>"User Not Found"],404);
        //     }
    }

    /**
     * Broadlive-owned Agora RTC token endpoint, replacing the previous external
     * dependency on rtctoken.bdlive.cloud/api/startStream. Response shape matches
     * NewTokenModel in the Flutter client: {token, room, identity}.
     *
     * Accepts JSON body (GET or POST): {room_name, identity, app_id, app_certificate}.
     */
    public function startStream(Request $request)
    {
        $roomName = trim((string) $request->input('room_name'));
        $identity = trim((string) $request->input('identity'));
        $appId = trim((string) $request->input('app_id'));
        $appCertificate = trim((string) $request->input('app_certificate'));

        if ($roomName === '' || $identity === '' || $appId === '' || $appCertificate === '') {
            return response()->json([
                'success' => false,
                'message' => 'Missing token configuration',
                'code' => 422,
            ], 422);
        }

        $token = AgoraController::GetToken($identity, $appId, $appCertificate, $roomName);

        // GetToken returns a JSON-encoded error array when the caller is banned
        // or when the SDK throws. Surface that as a 403 instead of leaking the
        // placeholder into the token field.
        if (is_string($token) && strlen($token) > 0 && $token[0] === '[') {
            $decoded = json_decode($token, true);
            if (is_array($decoded) && isset($decoded[0]['code']) && (string) $decoded[0]['code'] !== '200') {
                return response()->json([
                    'success' => false,
                    'message' => $decoded[0]['message'] ?? 'Token generation failed',
                    'code' => (int) $decoded[0]['code'],
                ], 403);
            }
        }

        return response()->json([
            'token' => (string) $token,
            'room' => $roomName,
            'identity' => (string) $identity,
        ]);
    }
}
