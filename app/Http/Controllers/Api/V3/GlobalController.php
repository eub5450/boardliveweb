<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon;
use DB;
use App\Models\UserLive;
use App\Models\BanDevice;
use App\Models\User;
use App\Models\AudienceJoin;
use App\Models\LiveCall;
use App\Models\Comment;
use App\Models\Country;
class GlobalController extends Controller
{
    public function Index(Request $request)
    {
         $token = $request->access_token;
         $user_id=$request->user_id;
         $response = array();
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            $user=User::find($user_id);
            $ban_device=BanDevice::where('device_id',$user->device_id)->first();
          
            $live_data=UserLive::where('user_id',$user_id)->get();
            $live_data_single=UserLive::where('user_id',$user_id)->orderby('id','desc')->first();
            foreach($live_data as $live){
                
                $audiances=AudienceJoin::where('host_id',$user_id)->where('channelName',$live->channelName)->get();
                foreach($audiances as $audiance)
                {
                    $audiance->delete();
                }
                $calles=LiveCall::where('host_id',$user_id)->where('channelName',$live->channelName)->get();
                 foreach($calles as $calle)
                {
                    $calle->delete();
                }
                $comments=Comment::where('reciever_id',$user_id)->where('channelName',$live->channelName)->get();
                 foreach($comments as $comment)
                {
                    $comment->delete();
                }
                $live->delete();
                
            }
            $ban_device=BanDevice::where('device_id',$user->device_id)->first();
           $banned=User::where('ban_type','!=',Null)->where('id',$user_id)->first();
           
            

            $countrys_db=Country::all();
             $countrys = array();
             $all = array();
	            $all['id'] = '0';
	            $all['name'] = 'All';
	            $all['flag'] = 'store/country/all.png';
	            array_push($countrys,$all);
            	foreach ($countrys_db as $key => $country_db) {
            	$row = array();	
            	$row['id'] = $country_db->id;
            	$row['name'] = $country_db->name;
                $row['flag'] = $country_db->flag;
            	 array_push($countrys,$row);
            	}
	            

             $lives=DB::table('user_lives')->join('users','users.id','user_lives.user_id')->select('users.name','users.id','users.level','users.balance','users.profile','user_lives.token','user_lives.channelName','user_lives.type','user_lives.backgorund','user_lives.notice','user_lives.bullet_notice','user_lives.pin','user_lives.audio_brd_design','users.host_badge')->orderBy('user_lives.type','desc')->orderby('user_lives.top_value','desc')->get();
             
            array_push($response,array('message'=>'Global Data  Successfully ','lives_now'=>$lives,'countrys'=>$countrys,'code'=>'200'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
             

          
             
        }else{
            array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
    public function CountryWiseData(Request $request)
    {
    	$token = $request->access_token;
         $user_id=$request->user_id;
         $country_id=$request->country_id;
         $response = array();
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            $user=User::find($user_id);
            $ban_device=BanDevice::where('device_id',$user->device_id)->first();
             if(!$ban_device){
             	if ($country_id==0) {
             	    $lives=DB::table('user_lives')->join('users','users.id','user_lives.user_id')->select('users.name','users.id','users.level','users.balance','users.profile','user_lives.token','user_lives.channelName','user_lives.type','user_lives.backgorund','user_lives.notice','user_lives.bullet_notice','user_lives.pin','user_lives.audio_brd_design','users.host_badge')->orderBy('user_lives.type','desc')->orderby('user_lives.top_value','desc')->get();
             	}else{
             		 $lives=DB::table('user_lives')->join('users','users.id','user_lives.user_id')->where('users.country_id',$country_id)->select('users.name','users.id','users.level','users.balance','users.profile','user_lives.token','user_lives.channelName','user_lives.type','user_lives.backgorund','user_lives.notice','user_lives.bullet_notice','user_lives.pin','user_lives.audio_brd_design','users.host_badge')->orderBy('user_lives.type','desc')->orderby('user_lives.top_value','desc')->get();
             	}
             	array_push($response,array('message'=>'Global Data  Successfully ','lives_now'=>$lives,'code'=>'200'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);

             	}else{
                array_push($response,array('message'=>'Opps !! Your Device Banned','code'=>'404'));
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            }
        }else{
            array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
}
