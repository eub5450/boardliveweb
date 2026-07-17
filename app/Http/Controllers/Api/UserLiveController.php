<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserLive;
use Carbon;
use DB;
use App\Models\LiveCall;
use App\Models\Comment;
use App\Models\User;
use App\Models\Gift;
use App\Models\AudienceJoin;
use App\Models\DayTime;
use App\Models\BanDevice;
use App\Models\DeviceLockInvite;
use App\Models\Slider;
use App\Models\Setting;
use App\Models\BedWord;
use Auth;
use Kreait\Firebase\Contract\Database;
class UserLiveController extends Controller
{
    
     public function Index(Request $request)
    {
         $token = $request->access_token;
         $day_times = $request->day_times;
        $response = array();
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
             $remove_old_call=LiveCall::where('co_host_id',$request->user_id)->first();
           if($remove_old_call){
            $remove_old_call->delete();
            }
            if($request->user_id){
            $user_id=$request->user_id;
            }else{
                $user_id=1;
            }
             $user=User::find($user_id);
            $imie_ban_device=BanDevice::where('device_id',$user->imei_number)->first();
            $ban_device=BanDevice::where('device_id',$user->device_id)->first();
           $banned=User::where('ban_type','!=',Null)->where('id',$user_id)->first();
           $just_error=User::where('id',$user_id)->where('country_id',7)->first();

                if(!$banned){
            $live_data=UserLive::where('user_id',$user_id)->get();
         
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
               // $live->delete();
                
            }
             $is_host=DB::table('host_data')->join('users','users.id','host_data.user_id')->where('users.is_host_id',1)->where('users.id',$user->id)->select('host_data.hosting_type')->first();
                  $host_type='0';
                  if($is_host){
                  	$host_type=$is_host->hosting_type;
                  }
             $lives=DB::table('user_lives')->join('users','users.id','user_lives.user_id')->select('users.name','users.id','users.level','users.balance','users.profile','user_lives.token','user_lives.channelName','user_lives.type','user_lives.backgorund','user_lives.notice','user_lives.bullet_notice','user_lives.pin','user_lives.audio_brd_design','users.host_badge')->orderBy('user_lives.type','desc')->orderby('user_lives.top_value','desc')->get();
             $top_live=DB::table('user_lives')->join('users','users.id','user_lives.user_id')->select('users.name','users.id','users.level','users.balance','users.profile','user_lives.token','user_lives.channelName','user_lives.type','user_lives.backgorund','user_lives.notice','user_lives.bullet_notice','user_lives.pin','user_lives.audio_brd_design','users.host_badge')->orderby('user_lives.top_value','desc')->limit(2)->get();
           
            $slider=Slider::orderby('id','desc')->get();
            $DeviceLockInvite=DeviceLockInvite::where('device_id',$user->imei_number)->first();
            if($DeviceLockInvite){
            if(Auth::user()->invite_done==0 && empty($DeviceLockInvite)){
               $invite_popup=1; 
            }else{
            $invite_popup=0;
            }
            }else{
               $invite_popup=0; 
            }
            $comment_skips=BedWord::select('word')->get();
            $setting=Setting::find(1);
             $follower_live = DB::table('followers')
            ->join('users', 'users.id', '=', 'followers.follower_id')
            ->Join('user_lives', 'user_lives.user_id', '=', 'followers.follower_id')
            ->select('users.name','users.id','users.level','users.balance','users.profile','user_lives.token','user_lives.channelName','user_lives.type','user_lives.backgorund','user_lives.notice','user_lives.bullet_notice','user_lives.pin','user_lives.audio_brd_design','users.host_badge')
            ->where('followers.user_id', $user_id)
            ->orderby('followers.id', 'desc')
            ->get();
            
            
            self::CheckIDBadge($user_id);
            array_push($response,array('message'=>'Home Page Data Show ','lives_now'=>$lives,'password'=>$user->password,'profile'=>$user->profile,'id'=>$user->id,'name'=>$user->name,
                        'balance'=>$user->balance,'email'=>$user->email,'phone'=>$user->phone,'level'=>$user->level,'is_host_id'=>$user->is_host_id,'is_agency'=>$user->is_agency,'status'=>$user->status,'role'=>$user->role,'image'=>$user->profile,'device_id'=>$user->device_id,'brd_off_power'=>$user->brd_off_power,'can_invisible'=>$user->is_invisible,'host_type'=>$host_type,'sceen_short_power'=>$user->sceen_short_power,'comment_mute_power'=>$user->comment_mute_power,'kick_power'=>$user->kick_power,'top_live'=>$top_live,'slider'=>$slider,'invite_popup'=>$invite_popup,'comment_skips'=>$comment_skips,'pusher_key'=>$setting->key,'pusher_secret'=>$setting->secret,'pusher_app_id'=>$setting->app_id,'pusher_cluster'=>$setting->cluster,'follower_live'=>$follower_live,'code'=>'200'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
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

            
        }else{
            array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
    public function CheckIDBadge($id){
        $check_user=User::find($id);
        if($check_user->is_official_id==1){
            $check_user->comment_badge='Official';
            $check_user->save();
        }elseif($check_user->is_agency==1){
            $check_user->comment_badge='Marchent';
            $check_user->save();
        }else{
            $check_user->comment_badge='0';
            $check_user->save();
        }
        
           $users = UserLive::all()->groupBy('user_id');

        // Iterate over the groups and remove duplicates
          foreach ($users as $userGroup) {
              // Keep the first user, delete the rest
              $userGroup->shift(); // This removes the first user from the group
              // Now delete the rest of the group
              foreach ($userGroup as $user) {
                 $user->delete();
              }
            }
        
    }
   
}
