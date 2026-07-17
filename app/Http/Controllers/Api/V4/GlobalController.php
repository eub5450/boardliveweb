<?php

namespace App\Http\Controllers\Api\V4;

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
use App\Services\V4\V4CacheService;
use Illuminate\Support\Facades\Cache;
class GlobalController extends Controller
{
    public function Index(Request $request)
    {
         $token = $request->access_token;
         $user_id=$request->user_id;
         $response = array();
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            $user=User::find($user_id);
            if(!$user){
                array_push($response,array('message'=>'User Not Found','code'=>'404'));
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            }
            $liveChannels=UserLive::where('user_id',$user_id)->pluck('channelName')->filter()->values();
            if($liveChannels->isNotEmpty()){
                AudienceJoin::where('host_id',$user_id)->whereIn('channelName',$liveChannels)->delete();
                LiveCall::where('host_id',$user_id)->whereIn('channelName',$liveChannels)->delete();
                Comment::where('reciever_id',$user_id)->whereIn('channelName',$liveChannels)->delete();
                UserLive::where('user_id',$user_id)->delete();
                foreach($liveChannels as $channelName){
                    V4CacheService::forgetRoom($channelName);
                }
                V4CacheService::forgetLiveLists((int) $user_id);
            }
            $ban_device=BanDevice::where('device_id',$user->device_id)->first();
           $banned=User::where('ban_type','!=',Null)->where('id',$user_id)->first();
           
            

            $countrys_db=Cache::remember('v4:global:countries', 3600, function () {
                return Country::all();
            });
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
	            

	             $lives=Cache::remember('v4:global:lives:all', 3, function () {
	                 return DB::table('user_lives')->join('users','users.id','user_lives.user_id')->select('users.name','users.id','users.level','users.balance','users.profile','user_lives.token','user_lives.channelName','user_lives.type','user_lives.backgorund','user_lives.notice','user_lives.bullet_notice','user_lives.pin','user_lives.audio_brd_design','users.host_badge','user_lives.sdk','user_lives.appCertificate','user_lives.appId','siteNumber')->orderBy('user_lives.type','desc')->orderby('user_lives.top_value','desc')->limit(200)->get();
	             });
             
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
	            if(!$user){
	                array_push($response,array('message'=>'User Not Found','code'=>'404'));
	                return json_encode($response,JSON_UNESCAPED_UNICODE);
	            }
	            $ban_device=BanDevice::where('device_id',$user->device_id)->first();
             if(!$ban_device){
             	if ($country_id==0) {
             	    $lives=Cache::remember('v4:global:lives:all', 3, function () {
             	        return DB::table('user_lives')->join('users','users.id','user_lives.user_id')->select('users.name','users.id','users.level','users.balance','users.profile','user_lives.token','user_lives.channelName','user_lives.type','user_lives.backgorund','user_lives.notice','user_lives.bullet_notice','user_lives.pin','user_lives.audio_brd_design','users.host_badge','user_lives.sdk','user_lives.appCertificate','user_lives.appId','siteNumber')->orderBy('user_lives.type','desc')->orderby('user_lives.top_value','desc')->limit(200)->get();
             	    });
             	}else{
             		 $lives=Cache::remember('v4:global:lives:country:' . (int) $country_id, 3, function () use ($country_id) {
             		     return DB::table('user_lives')->join('users','users.id','user_lives.user_id')->where('users.country_id',$country_id)->select('users.name','users.id','users.level','users.balance','users.profile','user_lives.token','user_lives.channelName','user_lives.type','user_lives.backgorund','user_lives.notice','user_lives.bullet_notice','user_lives.pin','user_lives.audio_brd_design','users.host_badge','user_lives.sdk','user_lives.appCertificate','user_lives.appId','siteNumber')->orderBy('user_lives.type','desc')->orderby('user_lives.top_value','desc')->limit(200)->get();
             		 });
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
