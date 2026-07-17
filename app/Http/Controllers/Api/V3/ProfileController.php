<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\ProfilePending;
use App\Models\Withdraw;
use App\Models\Agency;
use DB;
use Carbon;
use Image;
use Illuminate\Support\Str;
use DateInterval;
use DateTime; 
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
class ProfileController extends Controller
{
    public function ProfileLiveData(Request $request)
    {
        $response = array();
         $token = $request->access_token;
         $user_id = $request->user_id;
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            if (Auth::id()==$user_id) {
               $user=User::find(Auth::id());
              
               
        
        //$user_id = 8;
        
          $date = Carbon\Carbon::now(); // Replace this with your desired date
            $running_day_count=0;
            $totalDuration='00:00:00';
                     $start_date = $date->copy()->startOfMonth()->format('Y-m-d');

          
               
                    $end_date = $date->endOfMonth()->format('Y-m-d');
                     $type = DB::table('users')
                            ->join('host_data', 'host_data.user_id', 'users.id')
                            ->where('users.id', $user_id)
                            ->select('host_data.hosting_type','host_data.id')
                            ->first();

                                if ($type) {
                                  $dayTimeHistory = DB::table('day_times')
                                ->where('user_id', $user_id)
                              
                                ->get();
                                	$running_durations = DB::table('day_times')
                    				->where('user_id', $user_id)
                    				->where('live_time', '>=', $start_date)
                                ->where('live_time', '<=', $end_date)
                    				->where('brd_type',$type->hosting_type)
                    				
                    				->select('day_times')
                    				->get();
                    
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
                           
                    
                    	   // $running_totalDurationFormatted = $running_totalDuration->format('H:i:s');
                    
                    	          
                                    
                    				$total_coin= DB::table('gifts')->join('users','users.id','gifts.sander_id')->where('gifts.reciever_id',$user_id)->whereDate('date', '>=', $start_date)
                                    ->whereDate('date', '<=', $end_date)->select('gifts.date','gifts.value')->sum('gifts.value');
                                    
                                    $day_time_hostory = DB::table('day_times')
                    				->where('user_id', $user_id)
                    		        ->where('live_time', '>=', $start_date)
                                    ->where('live_time', '<=', $end_date)
                                    ->orderby('id','desc')
                    				->get();
                    				
                    				
                                 $day_time_data = DB::table('day_times')
                    				->where('user_id', $user_id)
                    				->where('live_time', '>=', $start_date)
                                    ->where('live_time', '<=', $end_date)
                                    ->orderby('id','desc')
                    				->get();

                                  $day_time_duration = DB::table('day_times')
                                        ->where('user_id', $user_id)
                                         ->where('live_time', '>=', $start_date)
                                         ->where('live_time', '<=', $end_date)
                                        ->where('brd_type', $type->hosting_type)
                                        
                                        ->select('live_time', 'day_times')
                                        ->get();
                                    
                                    $running_day_count = 0;
                                    $current_date = null;
                                    $total_duration = 0;
                                    
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
                    				$day_time = "00:00:00";
                            list($hours, $minutes, $seconds) = explode(':', $day_time);
                            
                            $total_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;
                //return $day_count;
             $first_ten= DB::table('gifts')->join('users','users.id','gifts.sander_id')->where('gifts.reciever_id',$user_id)->whereDate('date', '>=', $start_date)
                    ->whereDate('date', '<=', $end_date)->select('users.profile','users.name','gifts.value')->get();
               $second_ten= DB::table('gifts')->join('users','users.id','gifts.sander_id')->where('gifts.reciever_id',$user_id)->whereDate('date', '>=', $start_date)
                    ->whereDate('date', '<=', $end_date)->select('users.profile','users.name','gifts.value')->get();
               $three_ten= DB::table('gifts')->join('users','users.id','gifts.sander_id')->where('gifts.reciever_id',$user_id)->whereDate('date', '>=', $start_date)
                    ->whereDate('date', '<=', $end_date)->select('users.profile','users.name','gifts.value')->get();
               $total_gift_coin=DB::table('gifts')->join('users','users.id','gifts.sander_id')->where('gifts.reciever_id',$user_id)->whereDate('date', '>=', $start_date)
                    ->whereDate('date', '<=', $end_date)->select('users.profile','users.name','gifts.value')->sum('value');
               $total_withdraw=Withdraw::where('host_id',$user_id)->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->sum('total');
               $total_coin= ($user->previous_coin+$total_gift_coin)-$total_withdraw;
              
               $total_day_count=$running_day_count;
               $total_hours_count=$totalDuration;
               $lest_update_profile=Carbon\Carbon::parse($user->updated_at);
                
               array_push($response,array('message'=>'Live Data Store  Successfully ','first_ten_days'=>$first_ten,'second_ten_days'=>$second_ten,'third_ten_days'=>$three_ten,'total_coin'=>$total_coin,'total_day_count'=>$total_day_count,'total_hours_count'=>$total_hours_count,'lest_update_profile'=>$lest_update_profile,'profile'=>$user->profile,'name'=>$user->name,'join'=>$user->created_at,'code'=>'200'));
               return json_encode($response,JSON_UNESCAPED_UNICODE);
               
            }else{
                //$request->user()->currentAccessToken()->delete();
                array_push($response,array('message'=>'Something Wrong!','code'=>'401'));
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            }

        }else{
            array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
 public function ProfileUpdate(Request $request)
    {
        $response = array();

        try {
            $token = $request->access_token;
            $user_id = $request->user_id;
            $name = $request->name;
            $bio = $request->bio;
            $profile = $request->profile;

            if ($token != "0411f0028cfb768b3a3d96ac3aa37dw3e5") {
                array_push($response, array('message' => 'Unauthorized', 'code' => '401'));
                return json_encode($response, JSON_UNESCAPED_UNICODE);
            }

            if (Auth::id() != $user_id) {
                array_push($response, array('message' => 'Something Wrong!', 'code' => '401'));
                return json_encode($response, JSON_UNESCAPED_UNICODE);
            }

            $user = User::find(Auth::id());
            if (! $user) {
                array_push($response, array('message' => 'User Not Found', 'code' => '404'));
                return response()->json($response, 404, [], JSON_UNESCAPED_UNICODE);
            }

            $image_url = $user->profile;

            $uploadedProfile = $this->profileUpload($request);
            if ($uploadedProfile || ($request->has('profile') && $profile != null)) {
                if ($uploadedProfile) {
                    if (! $uploadedProfile->isValid()) {
                        array_push($response, array('message' => 'Invalid image data', 'code' => '400'));
                        return response()->json($response, 400, [], JSON_UNESCAPED_UNICODE);
                    }

                    $file = File::get($uploadedProfile->getRealPath());
                } else {
                    $profileData = trim((string) $request->input('profile'));

                    if (strpos($profileData, ',') !== false) {
                        $profileData = substr($profileData, strpos($profileData, ',') + 1);
                    }

                    $profileData = str_replace(' ', '+', $profileData);
                    $file = base64_decode($profileData, true);
                }

                if ($file === false || $file === '') {
                    array_push($response, array('message' => 'Invalid image data', 'code' => '400'));
                    return response()->json($response, 400, [], JSON_UNESCAPED_UNICODE);
                }

                $profileDir = base_path('store/profile');
                if (! File::isDirectory($profileDir)) {
                    File::makeDirectory($profileDir, 0755, true, true);
                }

                try {
                    $image = Image::make($file)->orientate()->fit(700, 700);
                } catch (\Throwable $e) {
                    array_push($response, array('message' => 'Invalid image data', 'code' => '400'));
                    return response()->json($response, 400, [], JSON_UNESCAPED_UNICODE);
                }

                $fileName = Str::random(40) . '.webp';
                $image_url = 'store/profile/' . $fileName;
                $this->saveOptimizedWebp($image, $profileDir . DIRECTORY_SEPARATOR . $fileName);

                $oldProfile = trim((string) $user->profile);
                $protectedProfiles = array(
                    'store/profile/default.png',
                    'store/profile/default.webp',
                    'store/profile/default.jpg',
                    '',
                );

                if (! in_array($oldProfile, $protectedProfiles, true) && Str::startsWith($oldProfile, 'store/profile/')) {
                    $oldPath = base_path($oldProfile);
                    $profileRoot = realpath($profileDir);
                    $oldRealPath = realpath($oldPath);

                    if ($profileRoot && $oldRealPath && Str::startsWith($oldRealPath, $profileRoot) && File::exists($oldRealPath)) {
                        File::delete($oldRealPath);
                    }
                }
            }

            if ($request->has('bio')) {
                $user->bio = (string) ($bio ?? '');
            }
            if ($image_url) {
                $user->profile = $image_url;
            }
            if ($request->has('name') && trim((string) $name) !== '') {
                $user->name = $name;
            }

            $user->save();

            $check_agency = Agency::where('user_id', $user->id)->first();
            if ($check_agency && $image_url) {
                $check_agency->logo = $image_url;
                $check_agency->save();
            }

            array_push($response, array('message' => 'Profile Update Successfully', 'code' => '200'));
            return response()->json($response, 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $e) {
            array_push($response, array('message' => 'Internal Server Error', 'code' => '500'));
            return response()->json($response, 500, [], JSON_UNESCAPED_UNICODE);
        }
    }

    protected function profileUpload(Request $request)
    {
        foreach (array('profile', 'image', 'photo', 'avatar', 'profile_image') as $field) {
            if ($request->hasFile($field)) {
                return $request->file($field);
            }
        }

        return null;
    }

    private function saveOptimizedWebp($image, string $absolutePath): void
    {
        foreach (array(88, 82, 76, 70, 64, 58, 52) as $quality) {
            $image->encode('webp', $quality)->save($absolutePath);
            if (File::exists($absolutePath) && File::size($absolutePath) <= 102400) {
                return;
            }
        }

        while (File::exists($absolutePath) && File::size($absolutePath) > 102400 && $image->width() > 500) {
            $next = max(500, (int) floor($image->width() * 0.9));
            $image->resize($next, $next, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $image->encode('webp', 58)->save($absolutePath);
        }
    }

}
