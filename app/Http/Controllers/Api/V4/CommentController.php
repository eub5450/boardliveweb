<?php

namespace App\Http\Controllers\Api\V4;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Gift;
use App\Models\User;
use App\Models\AudienceJoin;
use App\Models\UserLive;
use App\Models\LiveCall;
use App\Models\DayTime;
use App\Models\CommentMute;
use App\Models\Setting;
use App\Models\Kick;
use App\Models\Follower;
use App\Models\BrdAdmin;
use App\Helpers\AudioLiveStreamHelper;
use App\Helpers\LiveStreamHelper;
use App\Services\V4\V4CacheService;
use Kreait\Firebase\Contract\Database;
use DB;
use Carbon;
use Pusher;
class CommentController extends Controller
{
    
    public function __construct(Database $database)
    {
        $this->database = $database;
    }
    public function Store(Request $request)
    {
     
         $token = $request->access_token;
         $user_id = $request->user_id;
         $reciever_id = $request->reciever_id;
         $channelName = $request->channelName;
         $type = $request->type;
         $message = $request->message;
         $gift_name = $request->gift_name;
         $gift_value = $request->gift_value;
        $response = array();
      $comment_websoket = array();
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
          
            $data=new Comment;
            $data->user_id=$user_id;
            $data->channelName=$channelName;
            $data->message=$message;
            $data->reciever_id=$reciever_id;
            $data->type=$type;
            if($request->brd_type==2){
            $data->gift_name=$gift_name;
            $data->gift_value=$gift_value;
            }
          if ($request->type!='gift') {
            $data->save();
          }
          V4CacheService::forgetRoom($channelName);
        
            // self::CheckIDBadge($user_id,$channelName,$reciever_id);
        
            $audience=User::select('id','balance')->find($user_id);
            $host=User::select('id','name')->find($reciever_id);
            $list_view=DB::table('comments')->join('users','users.id','comments.user_id')->select('users.name','users.id','users.profile','comments.message','comments.type','comments.channelName','users.balance','users.level','users.is_vip','users.is_official_id','users.is_agency','users.is_host_id','users.frame','users.comment_badge')->where('comments.channelName',$channelName)->get();

            $count_inlive=V4CacheService::audienceCount($channelName);
            $audience_list=V4CacheService::audienceProfiles($channelName);
             
          
          $use=$count_inlive+rand(1, 15);
          $count=[
           'count'=>strval($use),
            'host_name'=>$host ? $host->name : null,
           ];
        $push_count_ref = $this->database->getReference('audience_counter/' . $channelName);
        $push_count_ref->set($count);
          
          $push_audience_profile=$this->database->getReference('audience_profile/' . $channelName);
          $push_audience_profile->set($audience_list);
        
           

           
            array_push($response,array('message'=>'Comment Successfully ','data'=>$list_view,'audience_balance'=>$audience ? $audience->balance : null,'comment_websoket'=>$comment_websoket,'code'=>'200'));
            
           return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{
            array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }

    public function GiftPush(Request $request)
    {
        return app(VideoBrdController::class)->VideoGiftPush($request);
    }

    public function AudioGiftPush(Request $request)
    {
        return app(AudioBrdController::class)->AudioGiftPush($request);
    }

    public function FlyComment(Request $request){
        $token = $request->access_token;
         $user_id = $request->user_id;
         $channelName = $request->channelName;
         $message = $request->message;
         $response = array();
        $global_txt = array();
        $websoket_entry = array();
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
             $user=User::find($user_id);
               if($user){
                    array_push($global_txt,array('message'=>$message,'image'=>$user->profile,'name'=>$user->name,'channelName'=>$channelName));
                      // array_push($websoket_entry,array('message'=>'rk_fly','channelName'=>$channelName,'data'=>$global_txt,'code'=>'200','channel_type' => '16'));
                       // self::Websoket($websoket_entry);
                       $roomName='fly_comment';
                        self::RealTime($global_txt,$roomName,$channelName);
                          array_push($response,array('message'=>'Successfully Fly Comment Show','code'=>'200'));
                         return json_encode($response,JSON_UNESCAPED_UNICODE);
                }
        }else{
             array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
    public function CheckEntry(Request $request){
        $token = $request->access_token;
         $user_id = $request->user_id;
         $host_id = $request->host_id;
         $channelName = $request->channelName;
         $response = array();
        $global_txt = array();
        $websoket_entry = array();
        $leaved_socket = array();
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
             $user=User::select('id','name','profile','is_vip','entry')->find($user_id);
             $audience=AudienceJoin::where('channelName',$channelName)->where('user_id',$user_id)->first();
             if($audience){
               if($user && $user->entry!=null && $audience->entry_show==0){
                        $message = "$user->name Arrived";
                      
                         array_push($global_txt,array('message'=>$message,'image'=>$user->profile,'vip_lavel'=>$user->is_vip,'channelName'=>$channelName,'entry_effect'=>$user->entry));
                          $roomName='entry_effect_realtime';
                          
                            //array_push($websoket_entry,array('message'=>'rk_entry','channelName'=>$channelName,'data'=>$global_txt,'code'=>'200','channel_type' => '15'));
                       // self::Websoket($websoket_entry);
                           self::RealTime($global_txt,$roomName,$channelName);
                            $audience->entry_show=1;
                            $audience->save();
                            
                     
                }
             }
                
             
            return json_encode($websoket_entry,JSON_UNESCAPED_UNICODE);
                
        }else{
             array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
    public function JoinStore(Request $request)
    {
        return $this->roomJoinResponse($request, false);
	    }

    public function RoomBootstrap(Request $request)
    {
        return $this->roomJoinResponse($request, true);
    }
    
    public function AudienceLeave(Request $request)
    {
        $token = $request->access_token;
         $user_id = $request->user_id;
         $channelName = $request->channelName;
       
        $response = array();
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){


            LiveCall::where('co_host_id',$user_id)->where('channelName',$channelName)->delete();
            AudienceJoin::where('user_id',$user_id)->where('channelName',$channelName)->delete();
            V4CacheService::forgetRoom($channelName);
         $callAcceptRef = $this->database->getReference('call_accept/' . $channelName .'/'. $user_id);
        $callAcceptRef->remove();
         $admin_list=V4CacheService::adminProfiles($channelName);
          
            $next_comment_ref = $this->database->getReference('room_admin_list/'.$channelName);
            $next_comment_ref->set($admin_list);
          
          array_push($response,array('message'=>'Audience Leave Successfully ','code'=>'200'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{
            array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
  public function AudienceList(Request $request)
    {
        $token = $request->access_token;
         $channelName = $request->channelName;
         
        $response = array();
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){


           $audienceList=V4CacheService::audienceList($channelName);
           $data=$audienceList['data'];
           $vip_data=$audienceList['vip_data'];
           $admin_data=$audienceList['admin_data'];
          
        
          array_push($response,array('message'=>'Audience List Showing Successfully ','data'=>$data,'vip_data'=>$vip_data,'admin_data'=>$admin_data,'code'=>'200'));
          return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{
            array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
    public function CommentMute(Request $request)
    { 
        $token = $request->access_token;
         $channelName = $request->channelName;
         $user_id=$request->user_id;
        $response = array();
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            $new=new CommentMute;
            $new->user_id=$user_id;
            $new->channelName=$channelName;
            $new->save();
            V4CacheService::forgetRoom($channelName);
            $data=V4CacheService::commentMuteList($channelName);
             array_push($response,array('message'=>'rk_commentmute','channelName'=>$channelName,'data'=>$data,'code'=>'200','channel_type' => '12'));
             self::Websoket($response);
          return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{
             array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
        
    }
    public function CommentMuteRemove(Request $request){
        $token = $request->access_token;
         $channelName = $request->channelName;
         $user_id=$request->user_id;
        $response = array();
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
         $data=CommentMute::where('channelName',$channelName)->where('user_id',$user_id)->first();
         if($data){
             $data->delete();
         }
         V4CacheService::forgetRoom($channelName);
         array_push($response,array('message'=>'rk_commentmute','data'=>$data,'channelName'=>$channelName,'code'=>'200','channel_type' => '12'));
        
        // Send the WebSocket message
        self::Websoket($response);
          return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{
           array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE); 
	    }
    }

    public function ClearRoomCache(Request $request)
    {
        $response = array();
        if($request->access_token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            if($request->channelName){
                V4CacheService::forgetRoom($request->channelName);
                if($request->host_id){
                    AudioLiveStreamHelper::clearRoomCache($request->channelName, $request->host_id);
                    LiveStreamHelper::clearHostListCache($request->channelName, $request->host_id);
                }
            }
            V4CacheService::clearStatic();
            V4CacheService::forgetLiveLists($request->user_id ? (int) $request->user_id : null);
            V4CacheService::forgetSocial(
                $request->user_id ? (int) $request->user_id : null,
                $request->follower_id ? (int) $request->follower_id : null
            );
            array_push($response,array('message'=>'V4 cache cleared successfully','code'=>'200'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
        array_push($response,array('message'=>'Unauthorized','code'=>'401'));
        return json_encode($response,JSON_UNESCAPED_UNICODE);
    }

    private function roomJoinResponse(Request $request, bool $includeBootstrap)
    {
         $response = array();
         try {
         $token = $request->access_token;
         $user_id = $request->user_id;
         $channelName = $request->channelName;
         $reciever_id = $request->reciever_id ?: $request->host_id;

        if($token!="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }

        V4CacheService::forgetRoom($channelName);
        AudienceJoin::where('user_id',$user_id)->delete();
        $check=Kick::where('user_id',$user_id)->where('channelName',$channelName)->exists();
        if ($check) {
            array_push($response,array('message'=>'Your Are Kick From This Room','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }

        $user=User::select('id','profile','entry','balance')->find($user_id);
        if($user){
            $adminPower=BrdAdmin::where('admin_id',$user_id)->where('user_id',$reciever_id)->value('type');
            $audience=new AudienceJoin;
            $audience->user_id=$user_id;
            $audience->host_id=$reciever_id;
            $audience->channelName=$channelName;
            $audience->profile=$user->profile;
            $audience->admin_power=$adminPower ?: 0;
            if($user->entry==null)
            {
                $audience->entry_show=1;
            }
            $audience->save();
            V4CacheService::forgetRoom($channelName);
        }

        $follow=Follower::where('user_id',$user_id)->where('follower_id',$reciever_id)->exists();
        if($follow){
            $friend=Follower::where('user_id',$reciever_id)->where('follower_id',$user_id)->exists();
            $is_i_follow = $friend ? 2 : 1;
        }else{
            $is_i_follow=0;
        }

        $list_view=V4CacheService::lastComment($channelName);
        $count_inlive=V4CacheService::audienceCount($channelName);
        $audience_list=V4CacheService::audienceProfiles($channelName);
        $admin_list=V4CacheService::adminProfiles($channelName);
        $host=User::select('id','name')->find($reciever_id);
        $day_time_last_update=1;
        $count=[
            'count'=>strval($count_inlive+rand(1, 15)),
            'host_name'=>$host ? $host->name : null,
        ];

        $this->database->getReference('audience_counter/' . $channelName)->set($count);
        $this->database->getReference('audience_profile/' . $channelName)->set($audience_list);
        $this->database->getReference('room_admin_list/'.$channelName)->set($admin_list);

        $payload=array('message'=>'Comment Successfully ','data'=>$list_view,'count_inlive'=>$count_inlive,'audience_list'=>$audience_list,'host_name'=>$host ? $host->name : null,'is_i_follow'=>$is_i_follow,'code'=>'200','day_time_last_update'=>$day_time_last_update,'');
        if($includeBootstrap){
            $audienceFull = V4CacheService::audienceList($channelName);
            $payload['audience_full'] = $audienceFull;
            $payload['admin_list'] = $admin_list;
            $payload['user_balance'] = $user ? $user->balance : null;
            $payload['room_cache_ttl'] = 3;
        }
        array_push($response,$payload);
        return json_encode($response,JSON_UNESCAPED_UNICODE);
         } catch (\Exception $e) {
        array_push($response, array('message' => 'Internal Server Error', 'code' => '500', 'error' => $e->getMessage()));
        return json_encode($response,JSON_UNESCAPED_UNICODE);
    }
    }
     private function RealTime($global_txt,$roomName,$channelName)
    {
        return app(\App\Services\V4\RealtimePusherService::class)
            ->trigger($global_txt, $roomName, $channelName);
    }
    
   
    
private function Websoket($data) {
    $response_json = json_encode($data);

    try {
        // Initialize cURL
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.104.191.163/api/recieve-one',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15, // Increase the timeout (in seconds)
            CURLOPT_CONNECTTIMEOUT => 10, // Separate connection timeout
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $response_json,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json'
            ),
        ));
        
        // Execute the request
        $response = curl_exec($curl);

        // Check for cURL errors
        if (curl_errno($curl)) {
            // Log cURL error details
            $error_message = 'cURL error: ' . curl_error($curl);
            info($error_message);
            // Optionally return or handle the error in a way that your application expects
            return ['error' => $error_message];
        } else {
            // Optionally, log response code and response data for debugging
            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            info('HTTP response code for Comment recieve-one: ' . $http_code);
           
        }
        
        // Close the cURL session
        curl_close($curl);

    } catch (\Throwable $th) {
        // Log any other errors
        $exception_message = 'Exception: ' . $th->getMessage();
        info($exception_message);
        // Optionally return or handle the exception message
        return ['error' => $exception_message];
    }
}


}
