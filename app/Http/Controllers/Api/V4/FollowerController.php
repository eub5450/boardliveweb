<?php

namespace App\Http\Controllers\Api\V4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Follower;
use App\Models\Comment;
use App\Models\User;
use App\Services\V4\FollowerService;
use Kreait\Firebase\Contract\Database;
class FollowerController extends Controller
{
    protected $database;
    protected $followers;

    public function __construct(Database $database, FollowerService $followers)
    {
        $this->database = $database;
        $this->followers = $followers;
    }
    public function Store(Request $request)
    {
         $response = array();
         $token = $request->access_token;
         $user_id = $request->user_id;
         $follower_id = $request->follower_id;
         if($request->channelName){
             $channelName = $request->channelName;
         }else{
             $channelName = "offline";
         }
         
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
          $check_old_follow=Follower::where('user_id',$user_id)->where('follower_id',$follower_id)->first();
          if($check_old_follow)
          {
             array_push($response,array('message'=>'All Ready Followed','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
          }else{
             $follower=new Follower;
            $follower->user_id=$user_id;
            $follower->follower_id=$follower_id;
            $follower->date=date('Y-m-d');
            $follower->save();
            $this->followers->forgetSocial($user_id, $follower_id);
         $sender_name=User::find($user_id);
            $user_main=User::find($follower_id);
             $commnet_message = "$sender_name->name. follow $user_main->name 💛";
           
            $comment=new Comment;
            $comment->user_id=$user_id;
            $comment->channelName=$channelName;
            $comment->message=$commnet_message;
            $comment->reciever_id=$follower_id;
            $comment->type='message';
            $comment->save();
            $sender_name=User::find($user_id);
            $user_main=User::find($follower_id);
            
            $gift_comment = [
                    'balance' => strval($sender_name->balance),
                    'channelName' => strval($channelName),
                    'id' => $sender_name->id,
                    'message' => strval('@'.$commnet_message),
                    'level' => strval($sender_name->level),
                    'name' => strval($sender_name->name),
                    'profile' => strval($sender_name->profile),
                    'is_vip' => strval($sender_name->is_vip),
                    'frame' => strval($sender_name->frame),
                    'is_official_id' => strval($sender_name->is_official_id),
                    'is_agency' => strval($sender_name->is_agency),
                    'is_host_id' => strval($sender_name->is_host_id),
                    'comment_badge' => strval($sender_name->comment_badge),
                    'type' => "message",
                ];
                
              
                 // Reference to the channel comments
                    $comments_ref = $this->database->getReference('Comments/'.$channelName);
                    
                    // Get the existing comments
                    $existing_comments = $comments_ref->getValue();
                    
                    // Determine the next index
                    $next_index = 0;
                    if (is_array($existing_comments)) {
                        $next_index = count($existing_comments);
                    }
                    
                    // Push the new comment at the next index
                    $next_comment_ref = $this->database->getReference('Comments/'.$channelName.'/'.$next_index);
                    $next_comment_ref->set($gift_comment);
                

           $is_i_follow = $this->followers->followStatus($user_id, $follower_id);
            
             array_push($response,array('message'=>'An Audience Followed Successfully','code'=>'200','is_follow'=>$is_i_follow));

      
            return json_encode($response,JSON_UNESCAPED_UNICODE);
          }
           
        }else{
             array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
    public function UnFollow(Request $request)
    {
         $response = array();
         $token = $request->access_token;
         $user_id = $request->user_id;
         $follower_id = $request->follower_id;
         if($request->channelName){
           $channelName = $request->channelName;  
         }else{
             
             $channelName ="offline";
         }
         
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
          $check_old_follow=Follower::where('user_id',$user_id)->where('follower_id',$follower_id)->first();
          if($check_old_follow)
          {
	             $check_old_follow->delete();
	             $this->followers->forgetSocial($user_id, $follower_id);
	             $is_i_follow = $this->followers->followStatus($user_id, $follower_id);
             array_push($response,array('message'=>'An Audience UnFollowed Successfully','code'=>'200','is_follow'=>$is_i_follow));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
          }
           
        }else{
             array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
   public function Follow(Request $request)
    {
         $response = array();
         $token = $request->access_token;
         $user_id = $request->user_id;
         $follower_id = $request->follower_id;
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
          $check_old_follow=Follower::where('user_id',$user_id)->where('follower_id',$follower_id)->first();
          if($check_old_follow)
          {
             array_push($response,array('message'=>'All Ready Followed','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
          }else{
             $follower=new Follower;
            $follower->user_id=$user_id;
            $follower->follower_id=$follower_id;
            $follower->date=date('Y-m-d');
            $follower->save();
            $this->followers->forgetSocial($user_id, $follower_id);

            $is_i_follow = $this->followers->followStatus($user_id, $follower_id);
             array_push($response,array('message'=>'An Audience Followed Successfully','code'=>'200','is_follow'=>$is_i_follow));

      
            return json_encode($response,JSON_UNESCAPED_UNICODE);
          }
           
        }else{
             array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
	public function FollowingIndex(Request $request)
    {
         $response = array();
         $token = $request->access_token;
         $user_id = $request->user_id;
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
	          $following = $this->followers->followingList($user_id);
           
             array_push($response,array('message'=>'Following List Showing','data'=>$following,'code'=>'200'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{
             array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
    public function FollowerIndex(Request $request)
    {
         $response = array();
         $token = $request->access_token;
         $user_id = $request->user_id;
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
	            $follower = $this->followers->followerList($user_id);
           
             array_push($response,array('message'=>'Follower List Showing Successfully','data'=>$follower,'code'=>'200'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{
             array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
  public function FriendIndex(Request $request)
    {
         $response = array();
         $token = $request->access_token;
         $user_id = $request->user_id;
	        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
	            $payload = $this->followers->friendPayload($user_id);

	             array_push($response,array('message'=>'Follower List Showing Successfully','friends'=>$payload['friends'],'follower'=>$payload['follower'],'following'=>$payload['following'],'code'=>'200'));
	            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{
             array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
}
