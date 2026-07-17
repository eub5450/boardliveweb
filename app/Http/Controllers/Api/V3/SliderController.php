<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Auth;
use App\Models\DeviceLockInvite;
use App\Models\User;
class SliderController extends Controller
{
    public function Index(Request $request)
    {
        $response = array();
        $token = $request->access_token;
        $user_id = $request->user_id;


        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            $slider=Slider::orderby('id','desc')->get();
            $user=User::find($user_id);
            $DeviceLockInvite=DeviceLockInvite::where('device_id',$user->imei_number)->first();
            if(Auth::user()->invite_done==0 && empty($DeviceLockInvite)){
               $invite_popup=1; 
            }else{
            $invite_popup=0;
            }
            array_push($response,array('message'=>'Slider Found','code'=>'200','data'=>$slider,'invite_popup'=>$invite_popup));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{
            array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
}
