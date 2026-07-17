<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agency;
use App\Models\HostData;
use App\Models\Withdraw;
use App\Models\User;
use DB;
use Carbon;
use DateTime;
use DatePeriod;
use DateInterval;
use Image;
use Auth;
use Illuminate\Support\Str;
class AgencyController extends Controller
{
    public function MyHost(Request $request)
    {
        $response = array();
         $token = $request->access_token;
         $user_id = $request->user_id;
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            $login_user=Auth::id();
           $agency=Agency::where('user_id',$login_user)->select('name','code','logo')->first();
           $host_list=DB::table('host_data')->join('users','users.id','host_data.user_id')->where('agency_code',$agency->code)->select('users.id','users.name','users.status','users.profile','users.level')->orderby('users.id','desc')->get();
             array_push($response,array('message'=>'Host Data Show','code'=>'200','host_list'=>$host_list,'agency'=>$agency));
            return json_encode($response,JSON_UNESCAPED_UNICODE); 
        }else{
             array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
    public function MyHostData(Request $request)
    {
        $response = array();
         $token = $request->access_token;
         $user_id = $request->user_id;
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            $login_user=Auth::id();
           $agency=Agency::where('user_id',$login_user)->select('name','code','logo')->first();
           $data=DB::table('host_data')->join('users','users.id','host_data.user_id')->where('agency_code',$agency->code)->select('users.id','users.name','users.status','users.profile','users.level')->orderby('users.id','desc')->get();
           $host_list = array();
           foreach ($data as $list) {
               //
               $host_id=$list->id;
                  $date = Carbon\Carbon::now(); // Replace this with your desired date

                $start_date = $date->format('Y-m') . '-01';
                    $end_date = $date->endOfMonth()->format('Y-m-d');
                $type=DB::table('users')->join('host_data','host_data.user_id','users.id')->where('users.id',$host_id)->select('host_data.hosting_type')->first();
                if($type)
                {
                   $hosting_type= $type->hosting_type;
                }else{
                    $hosting_type=1;
                }
            	$durations = DB::table('day_times')
				->where('user_id', $host_id)
				->where('live_time', '>=', $start_date)
                ->where('live_time', '<=', $end_date)
				->where('brd_type',$hosting_type)
		
				->select('day_times')
				->get();

	        $totalDuration = Carbon\Carbon::createFromTime(0, 0, 0);

	        foreach ($durations as $duration) {
				$parts = explode(':', $duration->day_times);

				$hours = intval($parts[0]);
				$minutes = intval($parts[1]);
				$seconds = intval($parts[2]);

				$interval = new DateInterval("PT{$hours}H{$minutes}M{$seconds}S");
				$totalDuration->add($interval);
	        }

	        $totalDurationFormatted = $totalDuration->format('H:i:s');

	          $day_time_duration = DB::table('day_times')
                                        ->where('user_id', $host_id)
                                        ->where('live_time', '>=', $start_date)
                                        ->where('live_time', '<=', $end_date)
                                        ->where('brd_type', $type->hosting_type)
                                        ->select('live_time', 'day_times')
                                        ->get();
                                    
                                    $day_count = 0;
                                    $current_date = null;
                                    $total_duration = 0;
                                    
                                    foreach ($day_time_duration as $day_time_duration) {
                                        $date = Carbon\Carbon::parse($day_time_duration->live_time)->toDateString();
                                        $time = $day_time_duration->day_times;
                                    
                                        if ($current_date === null || $current_date !== $date) {
                                            // Check if the previous day's total duration exceeds 01:01:00
                                            if ($current_date !== null && $total_duration >= 3660) { // 3660 seconds = 1 hour 1 minute
                                                $day_count++;
                                            }
                                    
                                            $current_date = $date;
                                            $total_duration = 0;
                                        }
                                    
                                        $duration_parts = explode(':', $time);
                                        $hours = intval($duration_parts[0]);
                                        $minutes = intval($duration_parts[1]);
                                        $seconds = intval($duration_parts[2]);
                                        $total_duration += ($hours * 3660) + ($minutes * 60) + $seconds;
                                    }
                                    
                                    // Check the total duration of the last date
                                    if ($total_duration >= 3660) { // 3660 seconds = 1 hour 1 minute
                                        $day_count++;
                                    }

               $total_coin= DB::table('gifts')->join('users','users.id','gifts.sander_id')->where('gifts.reciever_id',$host_id)->whereDate('date', '>=', $start_date)
                    ->whereDate('date', '<=', $end_date)->select('users.profile','users.name','gifts.value')->sum('value');
                    
                   
               $total_withdraw=Withdraw::where('host_id',$host_id)->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->sum('total');
               $total_gift_sum= $total_coin-$total_withdraw;
               $total_day_count=$day_count;
               $total_hours_count=$totalDurationFormatted;
               //
               $row = array();
                $row['id'] = $list->id;
                $row['name'] = $list->name;
                $row['status'] = $list->status;
                $row['profile'] = $list->profile;
                $row['level'] = $list->level;
                $row['day'] = $total_day_count;
                $row['coin_have'] = $total_gift_sum;
                array_push($host_list, $row);
           }
             array_push($response,array('message'=>'Host Data Show','code'=>'200','host_list'=>$host_list,'agency'=>$agency));
            return json_encode($response,JSON_UNESCAPED_UNICODE); 
        }else{
             array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
    public function AddHost(Request $request)
    {
        try {
        $response = array();
         $token = $request->access_token;
         $code = $request->code;
         $host_id = $request->host_id;
          $nid = $request->nid;
          $phone_number = $request->phone_number;
          $hosting_type = $request->hosting_type;
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
           $agency=Agency::where('code',$code)->select('name','code','logo','country_id')->first();
           if($agency){
            $user=User::find($host_id);
           if($user){
           if($user->is_host_id==0){
               $check_nid=HostData::where('nid',$nid)->orderby('id','desc')->first();
               $check_phone_number=HostData::where('phone',$phone_number)->orderby('id','desc')->first();
               if($check_nid){
               array_push($response,array('message'=>'NID Number All Ready Used !!!!','code'=>'401'));
               return json_encode($response,JSON_UNESCAPED_UNICODE);
               }else{
                 if($check_phone_number){
                array_push($response,array('message'=>'Phone Number All Ready Used !!!!','code'=>'401'));
               return json_encode($response,JSON_UNESCAPED_UNICODE);
                 }else{
            
                    
                if ($request->has('image')) {
                    
                    $file = base64_decode($request->input('image'));
                    $image = Image::make($file)->resize(700, 700);
                    $image->encode('jpg', 80);
    
                    // Create a watermark image
                    $watermark = Image::make('https://rklive.site/public/imagelogo.png');
    
                    // Calculate the position for the watermark
                    $x = ($image->width() - $watermark->width()) / 2; // Center horizontally
                    $y = ($image->height() - $watermark->height()) / 2; // Center vertically
    
                    // Insert the watermark onto the image
                    $image->insert($watermark, 'center', $x, $y);
                    
    
                    // Save the image with the watermark
                       $image_url = 'store/host/' . Str::random(40) . '.jpg';
                          $image->save($image_url);
                } else {
                    $image_url = 'public/profile.jpg';
                }
                    
                    
             if ($request->has('photo_id')) {
                    
                    $file = base64_decode($request->input('photo_id'));
                    $photo_id = Image::make($file)->resize(700, 700);
                    $photo_id->encode('jpg', 80);
    
                    // Create a watermark image
                    $watermark = Image::make('https://rklive.site/public/imagelogo.png');
    
                    // Calculate the position for the watermark
                    $x = ($photo_id->width() - $watermark->width()) / 2; // Center horizontally
                    $y = ($photo_id->height() - $watermark->height()) / 2; // Center vertically
    
                    // Insert the watermark onto the image
                    $photo_id->insert($watermark, 'center', $x, $y);
                    
    
                    // Save the image with the watermark
                       $photo_id_url = 'store/host/' . Str::random(40) . '.jpg';
                          $photo_id->save($photo_id_url);
                } else {
                    $photo_id_url = 'public/profile.jpg';
                } 
                
                if ($request->has('selfie')) {
                    
                    $file = base64_decode($request->input('selfie'));
                    $selfie = Image::make($file)->resize(700, 700);
                    $selfie->encode('jpg', 80);
    
                    // Create a watermark image
                    $watermark = Image::make('https://rklive.site/public/imagelogo.png');
    
                    // Calculate the position for the watermark
                    $x = ($selfie->width() - $watermark->width()) / 2; // Center horizontally
                    $y = ($selfie->height() - $watermark->height()) / 2; // Center vertically
    
                    // Insert the watermark onto the image
                    $selfie->insert($watermark, 'center', $x, $y);
                    
    
                    // Save the image with the watermark
                       $selfie_url = 'store/host/' . Str::random(40) . '.jpg';
                          $selfie->save($selfie_url);
                } else {
                    $selfie_url = 'public/profile.jpg';
                }        
               
               $data=new HostData;
               $data->user_id=$host_id;
               $data->agency_code=$agency->code;
               $data->name=$user->name;
               $data->phone=$phone_number;
               $data->nid=$nid;
               $data->hosting_type=$hosting_type;
               $data->selfie=$selfie_url;
               $data->photo_id=$photo_id_url;
               $data->image=$image_url;
               $data->country_id=1;
               $data->save();
               $user->is_host_id=2;
               $user->country_id=1;
               $user->save();
               array_push($response,array('message'=>'Hosting Apply Successfully Submit ','code'=>'200'));
               return json_encode($response,JSON_UNESCAPED_UNICODE);
                 }
                
               }
                
           }else{
            array_push($response,array('message'=>'Something Worng','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
           }
       }else{
            array_push($response,array('message'=>'User Not Found','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
           }
       }else{
        array_push($response,array('message'=>'Agency Not Found','code'=>'401'));
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
   public function HostVerify(Request $request)
    {
        $response = array();
         $token = $request->access_token;
         $user_id = $request->user_id;
         $nid = $request->nid;
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            $check_nid=HostData::where('nid',$nid)->first();
            $check_agency=Agency::where('code',$request->agency_code)->first();
            if($check_agency){
            if ($check_nid) {
                array_push($response,array('message'=>'This Nid Allready Used','code'=>'401'));
               return json_encode($response,JSON_UNESCAPED_UNICODE);
            }else
            {
                 
            
           $user=User::find($user_id);
           if($user->is_host_id==0){
              if($request['photo_id']){
                $file = base64_decode($request['photo_id']);
                $image_one=$file;
                $image_one_name=Str::random(40).'.'.'png';
                $image_url='store/user/'.$image_one_name;
                Image::make($image_one)->resize(700, 700)->save($image_url);
            }else{
                $image_url = 'store/profile/default.png';
            }
              if($request['image']){
                $file = base64_decode($request['image']);
                $images_one=$file;
                $images_one_name=Str::random(40).'.'.'png';
                $image_p_url='store/user/'.$images_one_name;
                Image::make($images_one)->resize(700, 700)->save($image_p_url);
            }else{
                $image_p_url = 'store/profile/default.png';
            }
             if($request['selfie']){
                $file = base64_decode($request['selfie']);
                $selfie=$file;
                $selfie_name=Str::random(40).'.'.'png';
                $selfie_url='store/profile/'.$selfie_name;
                Image::make($selfie)->resize(700, 700)->save($selfie_url);
                 }else{
                $selfie_url = 'public/profile.jpg';
                    }
            $host_data=New HostData;
            $host_data->image=$image_p_url;
            $host_data->user_id=$request->user_id;
            $host_data->photo_id=$image_url;
            $host_data->selfie=$selfie_url;
            $host_data->name=$user->name;
            $host_data->nid=$request->nid;
            $host_data->hosting_type=$request->hosting_type;
            $host_data->agency_code=$request->agency_code;
            $host_data->phone=$request->phone_number;
            $host_data->country_id=$check_agency->country_id;
            $host_data->save();
            $user->is_host_id=2;
            $user->country_id=$check_agency->country_id;
            $user->save();
            array_push($response,array('message'=>'Host  Data Submit Succssfully ','code'=>'200'));
            return json_encode($response,JSON_UNESCAPED_UNICODE); 
          
           }else{
            array_push($response,array('message'=>'Your Status is Waiting For Approved','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
           }
            
            }
            }else{
                 array_push($response,array('message'=>'Agency Code Invelid','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
            }
          
        }else{
             array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
    public function MyHostProfile(Request $request)
    {
         $response = array();
         $token = $request->access_token;
         $user_id = $request->user_id;
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
               $user=User::find($user_id);
              
               
        
        //$user_id = 8;
        
          $date = Carbon\Carbon::now(); // Replace this with your desired date

                 $start_date = $date->format('Y-m') . '-01';
                    $end_date = $date->endOfMonth()->format('Y-m-d');
                $type=DB::table('users')->join('host_data','host_data.user_id','users.id')->where('users.id',$user_id)->select('host_data.hosting_type')->first();
                if($type)
                {
                   $hosting_type= $type->hosting_type;
                }else{
                    $hosting_type=1;
                }
            	$durations = DB::table('day_times')
				->where('user_id', $user_id)
				->where('live_time', '>=', $start_date)
                ->where('live_time', '<=', $end_date)
				->where('brd_type',$hosting_type)
				->select('day_times')
				->get();

	        $totalDuration = Carbon\Carbon::createFromTime(0, 0, 0);

	        foreach ($durations as $duration) {
				$parts = explode(':', $duration->day_times);

				$hours = intval($parts[0]);
				$minutes = intval($parts[1]);
				$seconds = intval($parts[2]);

				$interval = new DateInterval("PT{$hours}H{$minutes}M{$seconds}S");
				$totalDuration->add($interval);
	        }

	        $totalDurationFormatted = $totalDuration->format('H:i:s');

	          $day_time_duration = DB::table('day_times')
                                        ->where('user_id', $user_id)
                                        ->where('live_time', '>=', $start_date)
                                        ->where('live_time', '<=', $end_date)
                                        ->where('brd_type', $type->hosting_type)
                                     
                                        ->select('live_time', 'day_times')
                                        ->get();
                                    
                                    $day_count = 0;
                                    $current_date = null;
                                    $total_duration = 0;
                                    
                                    foreach ($day_time_duration as $day_time_duration) {
                                        $date = Carbon\Carbon::parse($day_time_duration->live_time)->toDateString();
                                        $time = $day_time_duration->day_times;
                                    
                                        if ($current_date === null || $current_date !== $date) {
                                            // Check if the previous day's total duration exceeds 01:01:00
                                            if ($current_date !== null && $total_duration >= 3660) { // 3660 seconds = 1 hour 1 minute
                                                $day_count++;
                                            }
                                    
                                            $current_date = $date;
                                            $total_duration = 0;
                                        }
                                    
                                        $duration_parts = explode(':', $time);
                                        $hours = intval($duration_parts[0]);
                                        $minutes = intval($duration_parts[1]);
                                        $seconds = intval($duration_parts[2]);
                                        $total_duration += ($hours * 3660) + ($minutes * 60) + $seconds;
                                    }
                                    
                                    // Check the total duration of the last date
                                    if ($total_duration >= 3660) { // 3660 seconds = 1 hour 1 minute
                                        $day_count++;
                                    }

               $total_coin= DB::table('gifts')->join('users','users.id','gifts.sander_id')->where('gifts.reciever_id',$user_id)->whereDate('date', '>=', $start_date)
                    ->whereDate('date', '<=', $end_date)->select('users.profile','users.name','gifts.value')->sum('value');
                    
                    $gift_list= DB::table('gifts')->join('users','users.id','gifts.sander_id')->where('gifts.reciever_id',$user_id)->whereDate('date', '>=', $start_date)
                    ->whereDate('date', '<=', $end_date)->select('users.profile','users.name','gifts.value')->get();
              
               $total_day_count=$day_count;
               $total_hours_count=$totalDurationFormatted;
               $lest_update_profile=Carbon\Carbon::parse($user->updated_at);

               array_push($response,array('message'=>'Live Data Store  Successfully ','gift_list'=>$gift_list,'total_coin'=>$total_coin,'total_day_count'=>$total_day_count,'total_hours_count'=>$total_hours_count,'lest_update_profile'=>$lest_update_profile,'profile'=>$user->profile,'name'=>$user->name,'join'=>$user->created_at,'code'=>'200'));
               return json_encode($response,JSON_UNESCAPED_UNICODE);
                
            
        }else{
            array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
        
    }
}
