<?php

namespace App\Http\Controllers\Api\V3;
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
         $date = Carbon\Carbon::now();
        $response = array();
      $global_banner = array();
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
        
            // self::CheckIDBadge($user_id,$channelName,$reciever_id);
        
            $audience=User::find($user_id);
            $host=User::find($reciever_id);
            $list_view=DB::table('comments')->join('users','users.id','comments.user_id')->select('users.name','users.id','users.profile','comments.message','comments.type','comments.channelName','users.balance','users.level','users.is_vip','users.is_official_id','users.is_agency','users.is_host_id','users.frame','users.comment_badge')->where('comments.channelName',$channelName)->get();

            $count_inlive=AudienceJoin::where('channelName',$channelName)->count();
            $audience_list=DB::table('audience_joins')->join('users','users.id','audience_joins.user_id')->where('audience_joins.channelName',$channelName)->select('users.profile','users.is_vip','users.frame')->orderby('users.is_vip','desc')->limit(2)->get();
             
          
          $use=$count_inlive+rand(1, 15);
          $count=[
           'count'=>strval($use),
            'host_name'=>$host->name,
           ];
        $push_count_ref = $this->database->getReference('audience_counter/' . $channelName);
        $push_count_ref->set($count);
          
          $push_audience_profile=$this->database->getReference('audience_profile/' . $channelName);
          $push_audience_profile->set($audience_list);
        
           

           
            array_push($response,array('message'=>'Comment Successfully ','data'=>$list_view,'audience_balance'=>$audience->balance,'comment_websoket'=>$comment_websoket,'code'=>'200'));
            
           return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{
            array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
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
             $user=User::find($user_id);
             $audience=AudienceJoin::where('channelName',$channelName)->where('user_id',$user_id)->first();
             if($audience){
               if($user->entry!=null && $audience->entry_show==0){
                           
                        $visitor=User::find($user_id);
                        $message = "$user->name Arrived";
                      
                         array_push($global_txt,array('message'=>$message,'image'=>$visitor->profile,'vip_lavel'=>$visitor->is_vip,'channelName'=>$channelName,'entry_effect'=>$visitor->entry));
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
         try {
         $token = $request->access_token;
         $user_id = $request->user_id;
         $channelName = $request->channelName;
         $type = $request->type;
         $message = $request->message;
         $reciever_id = $request->reciever_id;
         $date = Carbon\Carbon::now();
        $response = array();
        $global_txt = array();
        $comment_list = array();
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){

           $audience_data=AudienceJoin::where('user_id',$user_id)->first();
          if($audience_data){
            $audience_data->delete();
          }
          $check=Kick::where('user_id',$user_id)->where('channelName',$channelName)->first();
          if (!$check) {
            $user=User::find($user_id);
            if($user){
                $check_admin=BrdAdmin::where('admin_id',$user_id)->where('user_id',$reciever_id)->first();
                $audience=new AudienceJoin;
                $audience->user_id=$user_id;
                $audience->host_id=$reciever_id;
                $audience->channelName=$channelName;
                $audience->profile=$user->profile;
                if($check_admin){
                    $audience->admin_power=$check_admin->type;
                }else{
                    $audience->admin_power=0;
                }
                if($user->entry==null)
                {
                    $audience->entry_show=1;
                }
                $audience->save();
            }
           

        $follow=Follower::where('user_id',$user_id)->where('follower_id',$reciever_id)->first();
        if($follow){
            //Yes Following
            $friend=Follower::where('user_id',$reciever_id)->where('follower_id',$user_id)->first();
            if( $friend){
               $is_i_follow=2;
            }else{
              // NOt Friend
              $is_i_follow=1;
            }
          }
          else{
            // Not Following
            $is_i_follow=0;
          }
             
     
      $list_view=DB::table('comments')->join('users','users.id','comments.user_id')->select('users.name','users.profile','comments.message','comments.type','comments.channelName','users.is_vip','users.level','users.frame')->where('comments.channelName',$channelName)->first();
            $count_inlive=AudienceJoin::where('channelName',$channelName)->count();
            $audience_list=DB::table('audience_joins')->join('users','users.id','audience_joins.user_id')->where('audience_joins.channelName',$channelName)->select('users.profile','users.is_vip','users.frame')->orderby('users.is_vip','desc')->limit(2)->get();
          $host=User::find($reciever_id);
          $use=$count_inlive+rand(1, 15);
          $count=[
           'count'=>strval($use),
            'host_name'=>$host->name,
           ];
          $push_count_ref = $this->database->getReference('audience_counter/' . $channelName);
            $push_count_ref->set($count);
          
            $push_audience_profile=$this->database->getReference('audience_profile/' . $channelName);
            $push_audience_profile->set($audience_list);
             $admin_list=DB::table('audience_joins')->join('users','users.id','audience_joins.user_id')->where('audience_joins.channelName',$channelName)->where('audience_joins.admin_power','!=',0)->select('users.profile','users.frame','users.id','audience_joins.admin_power')->orderby('audience_joins.admin_power','desc')->limit(3)->get();
          
            $next_comment_ref = $this->database->getReference('room_admin_list/'.$channelName);
            $next_comment_ref->set($admin_list);
          $host_name=User::find($reciever_id);
           $live_is_running=UserLive::where('user_id',$reciever_id)->where('channelName',$channelName)->first();
          $day_time_last_update=1;
          $now = Carbon\Carbon::now(); // Current timestamp
          $sevenMinutesAgo = Carbon\Carbon::now()->subMinutes(6);
           $admin_list=DB::table('audience_joins')->join('users','users.id','audience_joins.user_id')->where('audience_joins.channelName',$channelName)->where('audience_joins.admin_power','!=',0)->select('users.profile','users.frame','users.id','audience_joins.admin_power')->orderby('audience_joins.admin_power','desc')->limit(3)->get();
          
          array_push($response,array('message'=>'Comment Successfully ','data'=>$list_view,'count_inlive'=>$count_inlive,'audience_list'=>$audience_list,'host_name'=>$host_name->name,'is_i_follow'=>$is_i_follow,'code'=>'200','day_time_last_update'=>$day_time_last_update,''));
            
            array_push($comment_list,array('message'=>'rk_comment ','data'=>$list_view,'code'=>'200'));
            
           // self::Websoket($comment_list);
           
          
            return json_encode($response,JSON_UNESCAPED_UNICODE);
          }else{
            array_push($response,array('message'=>'Your Are Kick From This Room','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
          }


        }else{
            array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
         } catch (\Exception $e) {
        array_push($response, array('message' => 'Internal Server Error', 'code' => '500', 'error' => $e->getMessage()));
        return json_encode($response,JSON_UNESCAPED_UNICODE);
    }
        
    }
    
    public function AudienceLeave(Request $request)
    {
        $token = $request->access_token;
         $user_id = $request->user_id;
         $channelName = $request->channelName;
       
        $response = array();
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){


            $data=AudienceJoin::where('user_id',$user_id)->where('channelName',$channelName)->first();
          if($data){
             $incall=LiveCall::where('co_host_id',$user_id)->where('channelName',$channelName)->first();
            if($incall)
            {
              $incall->delete();
            }
            $data->delete();            
          }
         $callAcceptRef = $this->database->getReference('call_accept/' . $channelName .'/'. $user_id);
        $callAcceptRef->remove();
         $admin_list=DB::table('audience_joins')->join('users','users.id','audience_joins.user_id')->where('audience_joins.channelName',$channelName)->where('audience_joins.admin_power','!=',0)->select('users.profile','users.frame','users.id','audience_joins.admin_power')->orderby('audience_joins.admin_power','desc')->limit(3)->get();
          
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


           $data=DB::table('audience_joins')->join('users','users.id','audience_joins.user_id')->where('users.is_vip',0)->where('audience_joins.admin_power',0)->select('users.name','users.level','users.id','users.profile','users.is_vip','users.frame','audience_joins.admin_power')->where('audience_joins.channelName',$channelName)->orderby('audience_joins.id','desc')->get();
           $vip_data=DB::table('audience_joins')->join('users','users.id','audience_joins.user_id')->where('users.is_vip','!=',0)->where('audience_joins.admin_power',0)->select('users.name','users.level','users.id','users.profile','users.is_vip','users.frame','audience_joins.admin_power')->where('audience_joins.channelName',$channelName)->orderby('audience_joins.id','desc')->get();
           $admin_data=DB::table('audience_joins')->join('users','users.id','audience_joins.user_id')->where('audience_joins.admin_power','!=',0)->select('users.name','users.level','users.id','users.profile','users.is_vip','users.frame','audience_joins.admin_power')->where('audience_joins.channelName',$channelName)->orderby('audience_joins.id','desc')->get();
          
        
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
            $data=CommentMute::where('channelName',$channelName)->get();
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
         array_push($response,array('message'=>'rk_commentmute','data'=>$data,'channelName'=>$channelName,'code'=>'200','channel_type' => '12'));
        
        // Send the WebSocket message
        self::Websoket($response);
          return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{
           array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE); 
        }
    }
     private function RealTime($global_txt,$roomName,$channelName)
    {
      $setting = Setting::find(1);
      $options = array(
              'cluster' => $setting->cluster,
              'useTLS' => true
          );
          $pusher = new Pusher\Pusher(
              $setting->key,
              $setting->secret,
              $setting->app_id,
              $options
          );
        $pusher->trigger($roomName,$channelName,$global_txt);
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
