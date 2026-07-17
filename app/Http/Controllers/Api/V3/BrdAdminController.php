<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BrdAdmin;
use App\Models\User;
use App\Models\Comment;
use Auth;
use DB;
use App\Models\AudienceJoin;
use Kreait\Firebase\Contract\Database;
class BrdAdminController extends Controller
{
     public function __construct(Database $database)
    {
        $this->database = $database;
    }
    public function Store(Request $request)
    {
  
    	 $access_token = $request->access_token;
         $user_id = $request->user_id;
         $admin_id = $request->admin_id;
         $channelName = $request->channelName;
         $type = $request->type;
        $response = array();
        if($access_token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
        	//here type ex: 1,2,3
        	$check_old_type_exit=BrdAdmin::where('user_id',$user_id)->where('type',$type)->first();
        	if ($check_old_type_exit) {
        		$check_old_type_exit->delete();
        	}
        	$same_check_old_type_exit=BrdAdmin::where('user_id',$user_id)->where('admin_id',$admin_id)->first();
        	if ($same_check_old_type_exit) {
        		$same_check_old_type_exit->delete();
        		
        	}
        	$new_brd_admin=new BrdAdmin;
        	$new_brd_admin->user_id=$user_id;
        	$new_brd_admin->admin_id=$admin_id;
        	$new_brd_admin->type=$type;
        	if($new_brd_admin->save())
        	{
        	    $check_audience_old_amdin=AudienceJoin::where('host_id',$user_id)->where('admin_power',$type)->first();
        	    if($check_audience_old_amdin){
        	        $check_audience_old_amdin->admin_power=0;
        	        $check_audience_old_amdin->save();
        	    }
        	    $check_audience=AudienceJoin::where('user_id',$admin_id)->where('host_id',$user_id)->first();
        	    if($check_audience){
        	        $check_audience->admin_power=$type;
        	        $check_audience->save();
        	        $admin_list=DB::table('audience_joins')->join('users','users.id','audience_joins.user_id')->where('audience_joins.channelName',$channelName)->where('audience_joins.admin_power','!=',0)->select('users.profile','users.frame','users.id','audience_joins.admin_power')->orderby('audience_joins.admin_power','desc')->limit(3)->get();
        	        
                    $next_comment_ref_admin = $this->database->getReference('room_admin_list/'.$channelName);
                    $next_comment_ref_admin->set($admin_list);
        	    }
        	    $host=User::find($user_id);
        	    $admin=User::find($admin_id);
        	    $commnet_message='@'.$admin->name.' Your Are Now My Room Admin ' .$type;
        	    $make_admin = [
                    'balance' => strval($host->balance),
                    'channelName' => strval($channelName),
                    'id' => $host->id,
                    'message' => strval($commnet_message),
                    'level' => strval($host->level),
                    'name' => strval($host->name),
                    'profile' => strval($host->profile),
                    'is_vip' => strval($host->is_vip),
                    'frame' => strval($host->frame),
                    'is_official_id' => strval($host->is_official_id),
                    'is_agency' => strval($host->is_agency),
                    'is_host_id' => strval($host->is_host_id),
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
                    $next_comment_ref->set($make_admin);
        	    
        	}
        	array_push($response,array('message'=>'Room Admin '.$type.' Added Successfully ','code'=>'200'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{
        	 array_push($response,array('message'=>'Unauthorized access_token','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
    public function Remove(Request $request)
    {
    	$access_token = $request->access_token;
         $user_id = $request->user_id;
         $admin_id = $request->admin_id;
         $channelName = $request->channelName;
        $response = array();
        if($access_token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
        	$check_old_type_exit=BrdAdmin::where('user_id',$user_id)->where('admin_id',$admin_id)->first();
        	if ($check_old_type_exit) {
        		$check_old_type_exit->delete();
        		$push_room_admin_profile_remove = $this->database->getReference('room_admin_list/' . $channelName);
                $push_room_admin_profile_remove->remove();
        		$check_audience=AudienceJoin::where('user_id',$admin_id)->where('host_id',$user_id)->first();
        		 if($check_audience){
        	        $check_audience->admin_power=0;
        	        $check_audience->save();
        	    }
        	        $admin_list=DB::table('audience_joins')->join('users','users.id','audience_joins.user_id')->where('audience_joins.channelName',$channelName)->where('audience_joins.admin_power','!=',0)->select('users.profile','users.frame','users.id','audience_joins.admin_power')->orderby('audience_joins.admin_power','desc')->limit(3)->get();
          
                    // Push the new comment at the next index
                    $next_comment_ref = $this->database->getReference('room_admin_list/'.$channelName);
                    $next_comment_ref->set($admin_list);
        	}
        	
        	array_push($response,array('message'=>'Room Admin Removed Successfully ','code'=>'200'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{
        	 array_push($response,array('message'=>'Unauthorized access_token','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
    
}