<?php

namespace App\Http\Controllers\Api\V4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon;
use App\Models\ChildAgency;
use App\Models\Agency;
use App\Models\Withdraw;
use App\Models\User;
use App\Models\DayTime;
use App\Models\WithdrawConvartAgency;
use App\Models\PortalRecharge;
use DateInterval;
use DateTime; 
class WithdrawController extends Controller
{
	public function Index(Request $request){
     $response = array();
        $token = $request->access_token;
        $user_id = $request->user_id;
        $data = array();

        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            if($user_id==Auth::id()){
            	 $date = Carbon\Carbon::now(); // Replace this with your desired date
                 $start_date = date('Y-m') . '-01';
                $end_date = date('Y-m') . '-31';
            $user=User::find($user_id);
             $total_coin= DB::table('gifts')->join('users','users.id','gifts.sander_id')->where('gifts.reciever_id',$user_id)->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->select('users.profile','users.name','gifts.value')->sum('value');
             $total_withraw_coin=Withdraw::where('host_id',$user_id)->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->sum('total');
             $available_balance=($user->previous_coin+$total_coin)-$total_withraw_coin;
             $super_agency_list= ChildAgency::select('master_agency_id', DB::raw('COUNT(*) as count'))
		    ->groupBy('master_agency_id')
		    ->get();

		    $lists = [];
			foreach ($super_agency_list as $value) {
			    $master_agency = Agency::find($value->master_agency_id);
			    if ($master_agency) {
			   
			    $row = [
			        'master_agency' => $master_agency->name,
			        'master_agency_code' => $master_agency->code,
			        'id' => $master_agency->id,
			    ];
			    array_push($lists, $row);
			    }
			}
			$my_agency=DB::table('host_data')->join('users','users.id','host_data.user_id')->where('users.is_host_id',1)->where('users.id',$user_id)->select('host_data.hosting_type')->first();
			if($my_agency){
			if($my_agency->hosting_type==2){
			  $hosting='Video';
			  $type=2;
			}else{
			  $hosting='Audio';   
			  $type=1;
			}
			    
			}else{
			  $hosting='Audio';   
			  $type=1;
			}
			$time='00:00:00';
			 $running_day_count = 0;
			 $day_time_duration = DB::table('day_times')
                                        ->where('user_id', $user_id)
                                        
                                        ->where('brd_type', $type)
                                        ->where('day_times', '>', '00:10:10')
                                        ->select('live_time', 'day_times')
                                        ->get();
                                    
                                   
                                    $current_date = null;
                                    $total_duration = 0;
                                    if(count($day_time_duration)>0){
                                    foreach ($day_time_duration as $day_time_duration) {
                                        $date = Carbon\Carbon::parse($day_time_duration->live_time)->toDateString();
                                        $time = $day_time_duration->day_times;
                                    
                                        if ($current_date === null || $current_date !== $date) {
                                            // Check if the previous day's total duration exceeds 01:01:00
                                            if ($current_date !== null && $total_duration >= 3600) { // 3660 seconds = 1 hour 1 minute
                                                $running_day_count++;
                                            }
                                    
                                            $current_date = $date;
                                            $total_duration = 0;
                                        }
                                    
                                        $duration_parts = explode(':', $time);
                                        $hours = intval($duration_parts[0]);
                                        $minutes = intval($duration_parts[1]);
                                        $seconds = intval($duration_parts[2]);
                                        $total_duration += ($hours * 3600) + ($minutes * 60) + $seconds;
                                    }
                                    
                                    // Check the total duration of the last date
                                    if ($total_duration >= 3600) { // 3660 seconds = 1 hour 1 minute
                                        $running_day_count++;
                                    }
                            }
                            	$running_durations = DB::table('day_times')
                    				->where('user_id', $user_id)
                    				
                    				->where('brd_type',$type)
                    				->where('day_times', '>', '00:19:59')
                    				->select('day_times')
                    				->get();
                                 if(count($running_durations)>0){
                                    function addDurations($duration1, $duration2) {
                                    $time1 = explode(':', $duration1);
                                    $time2 = explode(':', $duration2);
                            
                                    $hours = intval($time1[0]) + intval($time2[0]);
                                    $minutes = intval($time1[1]) + intval($time2[1]);
                                    $seconds = intval($time1[2]) + intval($time2[2]);
                            
                                    if ($seconds >= 60) {
                                        $minutes += 1;
                                        $seconds -= 60;
                                    }
                            
                                    if ($minutes >= 60) {
                                        $hours += 1;
                                        $minutes -= 60;
                                    }
                            
                                    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                                }
                                
                                $totalDuration = '00:00:00';
                                foreach ($running_durations as $duration){
                        
                                // Parse the duration as a DateTime object
                                $durationTime = new DateTime($duration->day_times);
                        
                                // Add the current duration to the total
                                $totalDuration = addDurations($totalDuration, $durationTime->format('H:i:s'));
                                }
                                $time=$totalDuration;
                            }
			
			$day=$running_day_count;
			
			array_push($response,array('message'=>'Host Withraw Data','code'=>'200','super_agency_list'=>$lists,'available_balance'=>$available_balance,'time'=>$time,'hosting_type'=>$hosting,'day'=>$day));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
            }else{
 				array_push($response,array('message'=>'Login User And Sand User ID Not Same','code'=>'401'));
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            }
        }else{
        	 array_push($response,array('message'=>'Unauthorized','code'=>'401'));
           return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
     public function SuperAgencyWithdraw(Request $request)
    {
    	$response = array();
        $token = $request->access_token;
        $user_id = $request->user_id;
        $amount = $request->amount;
        $super_agency_code = $request->super_agency_code;
        $super_agency_id = $request->super_agency_id;
       

        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            
			$pre_apps_percentage = 5;
			$agency_percentage = 9;
			$profit_percentage = 6;
			$withdraw_percentage = 85;
			$audio_withdraw_percentage = 75;
		    $pre_percentage_amount = ($pre_apps_percentage / 100) * $amount;
		    $need_amount=$amount+$pre_percentage_amount;
		     $start_date = date('Y-m') . '-01';
              $end_date = date('Y-m') . '-31';
              $is_agency=User::find($user_id);
             $total_coin= DB::table('gifts')->join('users','users.id','gifts.sander_id')->where('gifts.reciever_id',$user_id)->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->select('users.profile','users.name','gifts.value')->sum('value');
             $total_withraw_coin=Withdraw::where('host_id',$user_id)->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->sum('total');;
             $available_balance=($is_agency->previous_coin+$total_coin)-$total_withraw_coin;
             $target=[200000,400000,700000,1000000,1500000,2000000,3000000,4000000,5000000,6500000,8000000,10000000];
           	$my_agency=DB::table('host_data')->join('users','users.id','host_data.user_id')->where('users.is_host_id',1)->where('users.id',$user_id)->select('host_data.hosting_type')->first();
			if($my_agency->hosting_type==2){
			  $type=2;
			}else{
			  $type=1;
			 }
			   
			   $day = 0;
			   $running_day_count = 0;
                $day_time_duration = DB::table('day_times')
                        ->where('user_id', $user_id)
                        
                        ->where('brd_type', $type)
                        ->where('day_times', '>', '00:10:10')
                        ->select('live_time', 'day_times')
                        ->get();
                        
                       
                        $current_date = null;
                        $total_duration = 0;
                        if(count($day_time_duration)>0){
                        foreach ($day_time_duration as $day_time_duration) {
                            $date = Carbon\Carbon::parse($day_time_duration->live_time)->toDateString();
                            $time = $day_time_duration->day_times;
                        
                            if ($current_date === null || $current_date !== $date) {
                                // Check if the previous day's total duration exceeds 01:01:00
                                if ($current_date !== null && $total_duration >= 3600) { // 3660 seconds = 1 hour 1 minute
                                    $running_day_count++;
                                }
                        
                                $current_date = $date;
                                $total_duration = 0;
                            }
                        
                            $duration_parts = explode(':', $time);
                            $hours = intval($duration_parts[0]);
                            $minutes = intval($duration_parts[1]);
                            $seconds = intval($duration_parts[2]);
                            $total_duration += ($hours * 3600) + ($minutes * 60) + $seconds;
                        }
                        
                        // Check the total duration of the last date
                        if ($total_duration >= 3600) { // 3660 seconds = 1 hour 1 minute
                            $running_day_count++;
                        }
                    $day=$running_day_count;
                }
            
           if($is_agency->is_agency==1||$day>6 ){
             if($available_balance>=$need_amount){
                 if($amount>=200000){
                if (in_array($amount, $target)) {
                 $my_agency=DB::table('host_data')->join('users','users.id','host_data.user_id')->join('agencies','agencies.code','host_data.agency_code')->where('users.is_host_id',1)->where('users.id',$user_id)->select('host_data.hosting_type','agencies.name','agencies.user_id')->first();
             	if($my_agency){
             	$data=new Withdraw;
             	$data->txid=uniqid('withdraw_'.$user_id.'_'.date('Y_m_d').'_');
             	$data->host_id=$user_id;
             	$data->host_name=$is_agency->name;
             	$data->agency_id=$my_agency->user_id;
             	if ($super_agency_id!=0) {
             	 $data->is_super_agency_withdraw=1;
             	 $master_agency=Agency::find($super_agency_id);
             	 $data->super_agency_id=$master_agency->user_id;
             	}else{
             	 $data->withdraw_agency_id=$my_agency->user_id;
             	}
             	if($my_agency->hosting_type==2){
             	$data->basic_coin=($withdraw_percentage / 100) * $amount;
             	$data->agency_profit=($agency_percentage / 100) * $amount;
             	$data->apps_profit=(11/ 100) * $amount;
             	$data->total=$amount+(($pre_apps_percentage / 100) * $amount);
             	}else{
             	$data->basic_coin=($audio_withdraw_percentage / 100) * $amount;
             	$data->agency_profit=($agency_percentage / 100) * $amount;
             	$data->apps_profit=(21/ 100) * $amount;
             	$data->total=$amount+(($pre_apps_percentage / 100) * $amount);
             	}
             	$data->status=0;
             	$data->date=date('Y-m-d');
             	  if($available_balance>=$need_amount){
             	if ($data->save()) {
             	    DayTime::where('user_id', $user_id)->delete();
             	    if ($super_agency_id!=0) {
             		array_push($response,array('message'=>'Host Withraw From Super Agency','code'=>'200','amount'=>$amount,'user_id'=>$user_id,'super_agency_id'=>$super_agency_id,'super_agency_code'=>$super_agency_code));
             	    }else{
             	        array_push($response,array('message'=>'Host Withraw From  Agency','code'=>'200','amount'=>$amount,'user_id'=>$user_id,'super_agency_id'=>$super_agency_id,'super_agency_code'=>$super_agency_code));
             	    }
                return json_encode($response,JSON_UNESCAPED_UNICODE);
             	}
             	}else{
             	array_push($response,array('message'=>'Something Wrong . Please Contact with Support','code'=>'401'));
                return json_encode($response,JSON_UNESCAPED_UNICODE);	
             	}
             	}else{
             	    array_push($response,array('message'=>'Agency Not Found .Contact with Admin','code'=>'401'));
               return json_encode($response,JSON_UNESCAPED_UNICODE);
             	}
                 }else{
               array_push($response,array('message'=>'Amount Must Be In Lakh','code'=>'401'));
               return json_encode($response,JSON_UNESCAPED_UNICODE);
                 } 
                 
             }else{
               array_push($response,array('message'=>'Minimum Withdraw Amount 200000','code'=>'401'));
               return json_encode($response,JSON_UNESCAPED_UNICODE);
                 }
             	
             	
             }else{
             	array_push($response,array('message'=>'Insufficient Balance.','code'=>'401'));
               return json_encode($response,JSON_UNESCAPED_UNICODE);
             }
               
           }else{
             	array_push($response,array('message'=>'Please Complete Your Day Time.','code'=>'401'));
               return json_encode($response,JSON_UNESCAPED_UNICODE);
             }
           
			
        }else{
        	array_push($response,array('message'=>'Unauthorized','code'=>'401'));
           return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
     public function AgencyWallet(Request $request)
    {
    	$response = array();
        $token = $request->access_token;
        $user_id = $request->user_id;       

        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
        		if($user_id==Auth::id()){
                        $pending_list = Withdraw::where(function ($query) use ($user_id) {
                            $query->where('withdraw_agency_id', $user_id)
                                ->where('super_agency_id', null)
                                ->where('is_super_agency_withdraw', 0)
                                ->where('status', 0);
                        })
                        ->orWhere(function ($query) use ($user_id) {
                            $query->where('super_agency_id', $user_id)
                                ->where('is_super_agency_withdraw', 1)
                                ->where('status', 0);
                        }) ->orderBy('created_at', 'desc')
                        ->get();

                        //
                        $approved_list = Withdraw::where(function ($query) use ($user_id) {
                            $query->where('withdraw_agency_id', $user_id)
                                ->where('super_agency_id', null)
                                ->where('is_super_agency_withdraw', 0)
                                ->where('status', 1);
                        })
                        ->orWhere(function ($query) use ($user_id) {
                            $query->where('super_agency_id', $user_id)
                                ->whereNotNull('super_agency_id')
                                ->where('is_super_agency_withdraw', 1)
                                ->where('status', 1);
                        })
                        ->orderBy('created_at', 'desc')
                        ->get();

        	         	$convart_list=WithdrawConvartAgency::where('agency_id',$user_id)->orderby('id','desc')->get();
        	         	
        		$approved_balance=Withdraw::where('agency_id',$user_id)->where('status',1)->sum('agency_profit');
        		$agency_convart_balance=WithdrawConvartAgency::where('agency_id',$user_id)->sum('amount');
        		$available_balance=round($approved_balance-$agency_convart_balance);
			    array_push($response,array('message'=>'Agency Withdraw wallet','code'=>'200','approved_list'=>$approved_list,'pending_list'=>$pending_list,'convart_list'=>$convart_list,'available_balance'=>$available_balance));
		 	    return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{
        	array_push($response,array('message'=>'Login User And Sand User ID Not Same','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
        }else{
        	array_push($response,array('message'=>'Unauthorized','code'=>'401'));
           return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
    public function Convart(Request $request)
    {
    	$response = array();
        $token = $request->access_token;
        $user_id = $request->user_id;       
        $amount = $request->amount;       

        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            if($user_id==Auth::id()){
            	$approved_balance=Withdraw::where('agency_id',$user_id)->where('status',1)->sum('agency_profit');
        		$agency_convart_balance=WithdrawConvartAgency::where('agency_id',$user_id)->sum('amount');
        		$available_balance=$approved_balance-$agency_convart_balance;
        		if ($available_balance>=$amount) {
        			$WithdrawConvartAgency=new WithdrawConvartAgency;
        			$WithdrawConvartAgency->trxid=uniqid('convart_');
        			$WithdrawConvartAgency->agency_id=$user_id;
        			$WithdrawConvartAgency->date=date('Y-m-d');
        			$WithdrawConvartAgency->amount=$amount;
        			if($WithdrawConvartAgency->save()){
        			    $users=User::where('status',1)->where('is_coin_protal_active',1)->where('id',$user_id)->first();
        			    if($users){
        			        
        			    $deposit=new PortalRecharge;
                        $deposit->user_id=$users->id;
                        $deposit->trxid=uniqid('convart_recharge_'.$user_id.'_'.date('Y_m_d').'_');
                        $deposit->amount=$amount;
                        $deposit->date=date('Y-m-d');
                        $deposit->recharge_by=Auth::id();
                        $deposit->status='Approved';
                        $deposit->is_withdraw=1;
                        $deposit->save();
                        
        		        array_push($response,array('message'=>'Convart Successfully Done!','code'=>'200'));
                        return json_encode($response,JSON_UNESCAPED_UNICODE);
        			    }else{
        			        $WithdrawConvartAgency->delete();
        			    array_push($response,array('message'=>'Protal Not Actived','code'=>'200'));
                        return json_encode($response,JSON_UNESCAPED_UNICODE);
        			    }
        			}else{
        			 array_push($response,array('message'=>'Somthing Wrong','code'=>'401'));
                     return json_encode($response,JSON_UNESCAPED_UNICODE); 
        			}
        	
        		
        		}else{
        		array_push($response,array('message'=>'insufficient Balance','code'=>'401'));
                return json_encode($response,JSON_UNESCAPED_UNICODE);
        		}
            }else{
             array_push($response,array('message'=>'Login User And Sand User ID Not Same','code'=>'401'));
             return json_encode($response,JSON_UNESCAPED_UNICODE);
            }
        }else{
        	array_push($response,array('message'=>'Unauthorized','code'=>'401'));
           return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }

    public function Approved(Request $request)
    {
    	$response = array();
        $token = $request->access_token;
        $user_id = $request->user_id;       
        $amount = $request->amount;       
        $id = $request->id;       

        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            if($user_id==Auth::id()){
            	$data=Withdraw::where('id',$id)->where('status',0)->first();
            	if ($data) {
            		$data->status=1;
            		if($data->save()){
            		    //
            		    $users=User::where('status',1)->where('is_coin_protal_active',1)->where('id',$user_id)->first();
        			    if($users){
        			        
        			    $deposit=new PortalRecharge;
                        $deposit->user_id=$users->id;
                        $deposit->trxid=uniqid('withdraw_recharge_'.$user_id.'_'.date('Y_m_d').'_');
                        $deposit->amount=$data->basic_coin;
                        $deposit->date=date('Y-m-d');
                        $deposit->recharge_by=Auth::id();
                        $deposit->status='Approved';
                        $deposit->is_withdraw=1;
                        $deposit->save();
        		        array_push($response,array('message'=>'Withdraw Approved Successfully!','code'=>'200'));
                        return json_encode($response,JSON_UNESCAPED_UNICODE);
        			    }else{
        			       $data->status=0;
        			       $data->save();
        			    array_push($response,array('message'=>'Protal Not Actived','code'=>'200'));
                        return json_encode($response,JSON_UNESCAPED_UNICODE);
        			    }
            		    //
            		 
            		}else{
            		  array_push($response,array('message'=>'Something Wrong','code'=>'200'));
                      return json_encode($response,JSON_UNESCAPED_UNICODE); 
            		}
            		
            	}else{
                array_push($response,array('message'=>'All Ready Approved','code'=>'401'));
               return json_encode($response,JSON_UNESCAPED_UNICODE);
            	}
            }else{
             array_push($response,array('message'=>'Login User And Sand User ID Not Same','code'=>'401'));
             return json_encode($response,JSON_UNESCAPED_UNICODE);
            }
        }else{
        	array_push($response,array('message'=>'Unauthorized','code'=>'401'));
           return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
}
