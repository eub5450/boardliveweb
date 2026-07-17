<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Follower;
use App\Models\Comment;
use App\Models\User;
use Pusher;
use DB;
use Kreait\Firebase\Contract\Database;
class FollowerController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
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
                

           $follow=Follower::where('user_id',$user_id)->where('follower_id',$follower_id)->first();
                if($follow){
                    //Yes Following
                    $friend=Follower::where('user_id',$follower_id)->where('follower_id',$user_id)->first();
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
             $follow=Follower::where('user_id',$user_id)->where('follower_id',$follower_id)->first();
                if($follow){
                    //Yes Following
                    $friend=Follower::where('user_id',$follower_id)->where('follower_id',$user_id)->first();
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

            $follow=Follower::where('user_id',$user_id)->where('follower_id',$follower_id)->first();
                if($follow){
                    //Yes Following
                    $friend=Follower::where('user_id',$follower_id)->where('follower_id',$user_id)->first();
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
          $following=DB::table('followers')->join('users','users.id','followers.user_id')->select('users.*')->where('followers.follower_id',$user_id)->orderby('followers.id','desc')->get();
           
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
            $follower=DB::table('followers')->join('users','users.id','followers.follower_id')->select('users.*')->where('followers.user_id',$user_id)->orderby('followers.id','desc')->get();
           
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
        $friendDetails = array();
         $token = $request->access_token;
         $user_id = $request->user_id;
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
           // Get all follows for the user
            $follows = Follower::where('user_id', $user_id)->orderby('id', 'desc')->get();
            $friendDetails = [];
            
            // Loop through each follow to find mutual follows (friends)
            foreach ($follows as $follow) {
                $following = Follower::where('follower_id', $user_id)
                                     ->where('user_id', $follow->follower_id)
                                     ->orderby('id', 'desc')
                                     ->first();
                if ($following) {
                    $user = User::where('id', $following->user_id)
                                ->select('name', 'id', 'level', 'is_vip', 'frame', 'profile')
                                ->first();
                    array_push($friendDetails, $user);
                }
            }
            
            // Get followers and following lists, excluding friends
            $friendIds = array_column($friendDetails, 'id');
            
            // Fetch followers, excluding friends
            $follower = DB::table('followers')
                          ->join('users', 'users.id', '=', 'followers.follower_id')
                          ->select('users.name', 'users.id', 'users.level', 'users.is_vip', 'users.frame', 'users.profile')
                          ->where('followers.user_id', $user_id)
                          ->whereNotIn('users.id', $friendIds)
                          ->orderby('followers.id', 'desc')
                          ->get();
            
            // Fetch following, excluding friends
            $following = DB::table('followers')
                           ->join('users', 'users.id', '=', 'followers.user_id')
                           ->select('users.name', 'users.id', 'users.level', 'users.is_vip', 'users.frame', 'users.profile')
                           ->where('followers.follower_id', $user_id)
                           ->whereNotIn('users.id', $friendIds)
                           ->orderby('followers.id', 'desc')
                           ->get();

             
             array_push($response,array('message'=>'Follower List Showing Successfully','friends'=>$friendDetails,'follower'=>$follower,'following'=>$following,'code'=>'200'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{
             array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
}
