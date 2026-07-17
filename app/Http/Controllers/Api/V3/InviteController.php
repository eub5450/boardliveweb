<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\InviteReward;
use App\Models\InviteReward_withdraw;
use App\Models\DeviceLockInvite;
use App\Models\Notification;
use App\Models\PortalTransfer;
use Carbon;
class InviteController extends Controller
{
    public function Index(Request $request)
    {
    	  $token = $request->access_token;
         $user_id=$request->user_id;
         $response = array();
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            $total_recharge_reward=InviteReward::where('refer_id',$user_id)->sum('amount');
    		$total_invited_user=User::where('invited_by',$user_id)->count();
    		$total_invite_reward=InviteReward::where('refer_id',$user_id)->sum('amount');
    		$total_withdaw_amount=InviteReward_withdraw::where('user_id',$user_id)->sum('amount');
    		$total_available_balance=($total_invite_reward-$total_withdaw_amount);
    		array_push($response,array('message'=>'Data Found!','total_invited_user'=>$total_invited_user,'total_invite_reward'=>$total_invite_reward,'total_recharge_reward'=>$total_recharge_reward,'total_withdaw_amount'=>$total_withdaw_amount,'total_available_balance'=>$total_available_balance,'code'=>'200'));
	        return json_encode($response,JSON_UNESCAPED_UNICODE);
	    }else{
	    	array_push($response,array('message'=>'Unauthorized','code'=>'401'));
	        return json_encode($response,JSON_UNESCAPED_UNICODE);
	    }

    }
    public function Withdaw(Request $request)
    {
    	$token = $request->access_token;
         $amount=$request->amount;
         $user_id=$request->user_id;
         $response = array();
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            
    
    		$total_invite_reward=InviteReward::where('refer_id',$user_id)->sum('amount');
    		$total_withdaw_amount=InviteReward_withdraw::where('user_id',$user_id)->sum('amount');
    		$total_available_balance=($total_invite_reward-$total_withdaw_amount);
    		if($total_available_balance>=$amount){
        	$data=new InviteReward_withdraw;
        	$data->user_id=$user_id;
        	$data->amount=$amount;
        	$data->date=date('Y-m-d');
        	$data->save();
        	$user=User::find($user_id);
        	$reward_transfer=new PortalTransfer;
            $reward_transfer->portal_user_id=22286;
            $reward_transfer->user_id=$user_id;
            $reward_transfer->amount=$amount;
            $reward_transfer->trxid=uniqid('invite_withdraw_'.$user->id.'_');
            $reward_transfer->date=date('Y-m-d');
            $reward_transfer->save();
            $user->balance+=$amount;
            $user->save();
           
            $notification=new Notification;
            $notification->user_id=$user->id;
            $notification->date=date('Y-m-d');
            $notification->message=$amount . ' Withdraw From Invite Reward';
            $notification->save();
        	
        	array_push($response,array('message'=>'Withdaw Reward Successfully','code'=>'200'));
	        return json_encode($response,JSON_UNESCAPED_UNICODE);
    		}else{
    		    array_push($response,array('message'=>'Insufficient Balance','code'=>'401'));
	        return json_encode($response,JSON_UNESCAPED_UNICODE);
    		}
        }else{
        	array_push($response,array('message'=>'Unauthorized','code'=>'401'));
	        return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
     public function Invite(Request $request)
    {
    	$token = $request->access_token;
         $user_id=$request->user_id;
         $invite_code=$request->invite_code;
         $imie=$request->imie;
         $response = array();
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
        	$invite_code_user=User::find($invite_code);
        	if ($invite_code_user) {
        		$user=User::find($user_id);
        		if($user->invite_done==0){
        		$user->invite_done=1;
        		$user->recharge_reward_provide=0;
        		$user->invited_by=$invite_code;
        		if($user->save()){
        		    $check_already_done=InviteReward::where('new_user_id',$user_id)->first();
        		    if(!$check_already_done){
        		$invite_reward=new InviteReward;
        		$invite_reward->refer_id=$invite_code;
        		$invite_reward->new_user_id=$user_id;
        		$invite_reward->amount=5000;
        		$invite_reward->date=date('Y-m-d');
        		$invite_reward->device_id=$imie;
        		$invite_reward->save();
        		 }
        		}
        		}
        		if ($user->imei_number!=null) {
                      $check_device=DeviceLockInvite::where('device_id',$user->imei_number)->first();
                      if (empty($check_device)) {
                        $insart=new DeviceLockInvite;
                        $insart->device_id=$user->imei_number;
                       $insart->save();
                      }
                    }
        		array_push($response,array('message'=>'Thank You . You Are Wellcome','code'=>'200'));
	           return json_encode($response,JSON_UNESCAPED_UNICODE);
        	}else{
        		array_push($response,array('message'=>'Wrong Invite Code','code'=>'401'));
	           return json_encode($response,JSON_UNESCAPED_UNICODE);
        	}
        }else{
        	array_push($response,array('message'=>'Unauthorized','code'=>'401'));
	        return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
    public function InviteCancel(Request $request)
    {
    	$token = $request->access_token;
         $user_id=$request->user_id;
         $response = array();
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
        $user=User::find($user_id);
        $user->invite_done=1;
        $user->recharge_reward_provide=1;
        $user->save();
        if ($user->imei_number!=null) {
          $check_device=DeviceLockInvite::where('device_id',$user->imei_number)->first();
          if (empty($check_device)) {
            $insart=new DeviceLockInvite;
            $insart->device_id=$user->imei_number;
           $insart->save();
          }
        }
        array_push($response,array('message'=>'Thank You . You Are Wellcome','code'=>'200'));
	    return json_encode($response,JSON_UNESCAPED_UNICODE);

        }else{
        	array_push($response,array('message'=>'Unauthorized','code'=>'401'));
	        return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
}
