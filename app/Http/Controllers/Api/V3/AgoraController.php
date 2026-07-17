<?php

namespace App\Http\Controllers\Api\V3;

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
         //$ban_device=BanDevice::where('device_id',$device_id)->first();
            $banned=User::where('ban_type','!=',Null)->where('id',$user_id)->first();
           // if(!$ban_device){
            if(!$banned){
        $appID = $appID;
        $appCertificate = $appCertificate;
        $channelName = $channelName;
        $uid = $user_id;
        $uidStr = ($user_id) . '';
        $user=User::find($user_id);
        $role = RtcTokenBuilder::RoleAttendee;
        if($user_id==29219 && $user_id==25697 ){
             $expireTimeInSeconds = 60;
        }else{
            $expireTimeInSeconds = 10800;
        }
        if($user->imei_number!='680ae8ebcc9abdf8'){
        
        $currentTimestamp = (new \DateTime("now", new \DateTimeZone('UTC')))->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

        return RtcTokenBuilder::buildTokenWithUid($appID, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);
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
            $banned=User::where('ban_type','!=',Null)->where('id',$request->user_id)->first();
         //   if(!$ban_device){
            if(!$banned){
                $appID = $request->appID;
                $appCertificate = $request->appCertificate;
                $channelName =  $request->channelName;
        
                $uid = $request->user_id;
                
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
}
