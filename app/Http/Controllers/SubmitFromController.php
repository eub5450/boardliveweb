<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

use Illuminate\Http\Request;
use App\Models\HostData;
use App\Models\User;
use App\Models\Agency;
use App\Models\Follower;
use App\Models\Gift;
use App\Models\VipList;
use App\Models\ChildAgency;
use App\Models\DayTime;
use App\Models\AudienceJoin;
use App\Models\AgoraKeys;
use Carbon;
use DB;
use Pusher;
use App\Models\UserLive;
use App\Models\Country;
use App\Models\DeviceLockInvite;
use App\Models\Setting;
use App\Models\Comment;
use DateTime;
use App\Models\luckyStar;
use App\Models\MyBeg;
use Kreait\Firebase\Contract\Database;
use Illuminate\Support\Facades\File;
use Image;
use Session;
class SubmitFromController extends Controller
{
     public function __construct(Database $database)
    {
        $this->database = $database;
    }
    public function Index()
    {
        $hosts=User::where('is_host_id',1)->where('is_agency',0)->where('is_official_frame',0)->where('is_admin_frame',0)->where('is_reseller_frame',0)->get();
        foreach($hosts as $host){
            $host->frame='frame_4.svga';
           // $host->save();
        }
        $contry=Country::all();
        $duplicates = DB::table('host_data')
        ->select('user_id', DB::raw('MIN(id) as keep_id'))
        ->groupBy('user_id')
        ->havingRaw('COUNT(user_id) > 1')
        ->get();

        foreach ($duplicates as $duplicate) {
            HostData::where('user_id', $duplicate->user_id)
             ->where('id', '!=', $duplicate->keep_id) 
         ->delete();
        }
 $updatedCount = 0;
    $chunkSize = 100;
    
    // Process in chunks to avoid memory issues
    Gift::whereNull('agency_code')
        ->chunk($chunkSize, function($gifts) use (&$updatedCount) {
            
            $receiverIds = $gifts->pluck('reciever_id')->unique()->toArray();
            
            $hostData = DB::table('host_data')
                ->whereIn('user_id', $receiverIds)
                ->whereNotNull('agency_code')
                ->get()
                ->keyBy('user_id');
            
            $updates = [];
            
            foreach ($gifts as $gift) {
                if (isset($hostData[$gift->reciever_id])) {
                    $updates[] = [
                        'id' => $gift->id,
                        'agency_code' => $hostData[$gift->reciever_id]->agency_code
                    ];
                    $updatedCount++;
                }
            }
            
            if (!empty($updates)) {
                $this->bulkUpdateGifts($updates);
            }
        });
    	return view('from.add_host',compact('contry'));
    }
    private function bulkUpdateGifts($updates)
    {
        if (empty($updates)) {
            return 0;
        }
    
        $updated = 0;
        
        foreach ($updates as $update) {
            $result = DB::table('gifts')
                ->where('id', $update['id'])
                ->update(['agency_code' => $update['agency_code']]);
            
            if ($result) {
                $updated++;
            }
        }
        
        return $updated;
    }
    public function Store(Request $request)
    {
        $request->validate([
            'agency_code' => 'required',
            'host_id' => 'required',
            'phone_number' => 'required',
        ]);
    	$agency=Agency::where('code',$request->agency_code)->first();
    	if ($agency) {
    	
    	$check_host_data=HostData::where('user_id',$request->host_id)->first();
        if ($check_host_data) {
             $notification=array(
                'messege'=>'Allready Have Host Data!',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }else{
            $user=User::find($request->host_id);
           
            
                $image_url = 'store/profile/default.png';
           
             
                $photo_id_url = 'store/profile/default.png';
            
           
                $selfie_url = 'store/profile/default.png';
            
            $data=new HostData;
           $data->user_id=$request->host_id;
           $data->agency_code=$request->agency_code;
           $data->name=$user->name;
           $data->phone=$request->phone_number;
           $data->photo_id=$photo_id_url;
           $data->selfie=$selfie_url;
           $data->image=$image_url;
           $data->nid=$request->host_id;
           $data->bank_details=$request->phone_number;
           $data->country_id=1;
           $data->hosting_type=2;
           $data->age=18;
           $data->save();
           $user->is_host_id=2;
           $user->country_id=$agency->country_id;
           $user->save();
            $notification=array(
                'messege'=>'Wait For Host Approved SuccessFully!',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
            
           
        }
        	# code...
    	}else{
    		$notification=array(
                'messege'=>'Agency Not Found!',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
    	}
    }
      public function AgoraIndex(){
       $data=AgoraKeys::where('status','!=',2)->get();
        return view('from.agora',compact('data'));
    }
    public function FontAgoraStore(Request $request)
    {
        //return $request->all();
        // ✅ Step 1: Validate input
        $request->validate([
            'appId'              => 'required|string|max:255',
            'appCertificate'     => 'required|string|max:255',
            'AgoraEmail'         => 'required|email|max:255',
            'AgoraEmailPassword' => 'required|string|max:255',
        ]);

        // ✅ Step 2: Save to database
        AgoraKeys::create([
            'appId'              => $request->appId,
            'appCertificate'     => $request->appCertificate,
            'AgoraEmail'         => $request->AgoraEmail,
            'AgoraEmailPassword' => $request->AgoraEmailPassword,
        ]);

        // ✅ Step 3: Redirect with success message
        return redirect()->back()->with('success', 'Agora Account saved successfully!');
    }
    
    public function FontAgoraAccountActive($id)
    {
        $keys=AgoraKeys::where('Status',1)->get();
        foreach($keys as $item){
            $item->Status=2;
            $item->save();
        }
        $data=AgoraKeys::find($id);
        $data->Status=1;
        if($data->save()){
            $setting=Setting::find(1);
            $setting->appId=$data->appId;
            $setting->appCertificate=$data->appCertificate;
            $setting->save();
        }
        $notification=array(
                'messege'=>'Agorea Key Change Successfully !',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }
    public function agencyIndex()
    {
      $data=Country::all();
      return view('from.add_agency',compact('data'));
    }
    public function agencyStore(Request $request)
    {
      $request->validate([
        'user_id' => 'required',
        'agency_name' => 'required|string|max:255',
        'phone' => 'required',
        'country_id' => 'required',
        'photo_id' => 'required|file|mimes:jpg,jpeg,png,webp|max:2048',
        'selfie' => 'required|file|mimes:jpg,jpeg,png,webp|max:2048',
        'nid' => 'required|file|mimes:jpg,jpeg,png,webp|max:2048',
      ]);

      $check_user=User::find($request->user_id);
      if ($check_user) {
        
      $agency=Agency::where('user_id',$request->user_id)->first();
      if ($agency) {
            $notification=array(
                'messege'=>'Allready Have Agency This ID!',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
      }else{
        $agency_code=Agency::orderby('id','desc')->first();
            $photo_id_url = $this->storeAgencyImageAsWebp($request->file('photo_id'));
            $selfie_url = $this->storeAgencyImageAsWebp($request->file('selfie'));
            $nid_url = $this->storeAgencyImageAsWebp($request->file('nid'));
            $agency=new Agency;
           $agency->user_id=$check_user->id;
           $agency->name=$request->agency_name;
           $agency->code=$agency_code ? $agency_code->code+1 : 1000;
           $agency->logo='store/profile/default.png';
           $agency->selfie=$selfie_url;
           $agency->photo_id=$photo_id_url;
           $agency->nid=$nid_url;
           $agency->bank_details=$request->bank_details;
           $agency->phone=$request->phone;
           $agency->country_id=$request->country_id;
           $agency->status=0;
           $agency->save();
           $check_user->country_id=$request->country_id;
           $check_user->save();
           $notification=array(
                'messege'=>'Agency Data Sand SuccessFully please Wait For Approval' ,
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
      }
      # code...
      }else{
          $notification=array(
                'messege'=>'User Not Found!',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
      }
      
    }
    private function storeAgencyImageAsWebp($file)
    {
      $directory = public_path('store/agency');
      if (!File::exists($directory)) {
        File::makeDirectory($directory, 0755, true);
      }

      $file_name = gmdate('YmdHis').'-'.uniqid().'.webp';
      $relative_path = 'store/agency/'.$file_name;
      $absolute_path = public_path($relative_path);

      $image = Image::make($file->getRealPath())->orientate()->resize(1400, null, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
      });

      $image->encode('webp', 60)->save($absolute_path);

      return $relative_path;
    }
  public function ActiveBanned()
  {
    $users=User::where('ban_type','!=',null)->where('ban_type','!=','A')->get();
    foreach($users as $user)
    {
      $time=Carbon\Carbon::now()->format('Y-m-d H:i:s');
    	if($user->open_time<$time){
          $user->ban_type=null;
          $user->open_time=null;
          $user->save();
        }
      
    }
    return Carbon\Carbon::now()->format('Y-m-d H:i:s');
    echo "Done";
  }
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

    private function businessNow()
    {
        return Carbon\Carbon::now(config('app.timezone', 'Europe/London'));
    }

    private function previousSalaryMonthRange()
    {
        $month = $this->businessNow()->subMonth();
        $startDate = $month->copy()->startOfMonth()->format('Y-m-d');
        $endDate = $month->copy()->endOfMonth()->format('Y-m-d');

        return array($startDate, $endDate, $startDate . ' 00:00:00', $endDate . ' 23:59:59');
    }

    private function currentBusinessMonthRange()
    {
        $month = $this->businessNow();
        $startDate = $month->copy()->startOfMonth()->format('Y-m-d');
        $endDate = $month->copy()->endOfMonth()->format('Y-m-d');

        return array($startDate, $endDate, $startDate . ' 00:00:00', $endDate . ' 23:59:59');
    }

  public function Salary($id)
    {
        $agency = Agency::where('code', $id)->first();

        if (! $agency) {
            $notification = array(
                'messege' => 'Agency Not Found',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }

        list($start_date, $end_date, $start_at, $end_at) = $this->previousSalaryMonthRange();
        $cacheKey = 'broadlive:salary_sheet:v5-tz:' . $id . ':' . $start_date . ':' . $end_date;
        $cachedHtml = Cache::get($cacheKey);

        if (is_string($cachedHtml) && $cachedHtml !== '') {
            return response($cachedHtml);
        }

        $hosts = HostData::join('users', 'users.id', '=', 'host_data.user_id')
            ->where('host_data.agency_code', $id)
            ->select('users.id', 'users.name', 'host_data.hosting_type')
            ->orderBy('users.id')
            ->get();

        $data = array();
        $summary = array(
            'totalGift' => 0,
            'totalBasicPoint' => 0,
            'totalExtraPoint' => 0,
            'totalBasicSalary' => 0,
            'totalExtraBonus' => 0,
            'totalFinalSalary' => 0,
            'totalHosts' => 0,
            'hasExtraBonus' => false,
            'hasBasicSalary' => false,
        );

        if ($hosts->isNotEmpty()) {
            $hostIds = $hosts->pluck('id')->all();

            $giftTotals = Gift::query()
                ->select('reciever_id', DB::raw('SUM(value) as total_gift'))
                ->whereIn('reciever_id', $hostIds)
                ->where('date', '>=', $start_at)
                ->where('date', '<=', $end_at)
                ->groupBy('reciever_id')
                ->pluck('total_gift', 'reciever_id');

            $durationRows = DB::table('day_times')
                ->select(
                    'user_id',
                    'brd_type',
                    DB::raw('DATE(live_time) as live_date'),
                    DB::raw('SUM(TIME_TO_SEC(day_times)) as total_seconds')
                )
                ->whereIn('user_id', $hostIds)
                ->where('live_time', '>=', $start_at)
                ->where('live_time', '<=', $end_at)
                ->groupBy('user_id', 'brd_type', DB::raw('DATE(live_time)'))
                ->get();

            $durationIndex = array();
            foreach ($durationRows as $row) {
                $userId = (int) $row->user_id;
                $broadcastType = (string) $row->brd_type;
                $seconds = (int) $row->total_seconds;

                if (! isset($durationIndex[$userId][$broadcastType])) {
                    $durationIndex[$userId][$broadcastType] = array(
                        'total_seconds' => 0,
                        'running_day_count' => 0,
                    );
                }

                $durationIndex[$userId][$broadcastType]['total_seconds'] += $seconds;

                if ($seconds >= 3600) {
                    $durationIndex[$userId][$broadcastType]['running_day_count']++;
                }
            }

            $extraPointsArray = array(300000, 500000, 700000, 1000000, 1500000, 2000000, 3000000, 4000000, 6000000, 8000000, 10000000, 20000000, 30000000, 50000000, 100000000);
            $videoBasicSalaryMap = array(
                300000 => 2700,
                500000 => 4500,
                700000 => 6300,
                1000000 => 9000,
                1500000 => 13500,
                2000000 => 18000,
                3000000 => 27000,
                4000000 => 36000,
                6000000 => 54000,
                8000000 => 72000,
                10000000 => 90000,
                20000000 => 180000,
                30000000 => 270000,
                50000000 => 450000,
                100000000 => 900000,
            );
            $extraBonusPerBlock = 600;

            foreach ($hosts as $host) {
                $gift = (int) ($giftTotals[$host->id] ?? 0);

                if ($gift <= 0) {
                    continue;
                }

                $durationMeta = $durationIndex[$host->id][(string) $host->hosting_type] ?? array(
                    'total_seconds' => 0,
                    'running_day_count' => 0,
                );
                $basicPoint = 0;

                foreach ($extraPointsArray as $value) {
                    if ($gift >= $value) {
                        $basicPoint = $value;
                    } else {
                        break;
                    }
                }

                $extraPoint = $gift - $basicPoint;
                $basicSalary = ((int) $host->hosting_type === 2) ? (int) ($videoBasicSalaryMap[$basicPoint] ?? 0) : 0;
                $extraBonus = ($basicSalary > 0 && $extraPoint >= 100000) ? (int) (floor($extraPoint / 100000) * $extraBonusPerBlock) : 0;
                $finalSalary = $basicSalary + $extraBonus;
                $hasBasicSalary = $basicSalary > 0;
                $totalSeconds = (int) $durationMeta['total_seconds'];
                $formattedDuration = sprintf('%02d:%02d:%02d', intdiv($totalSeconds, 3600), intdiv($totalSeconds % 3600, 60), $totalSeconds % 60);

                $summary['totalGift'] += $gift;
                $summary['totalBasicPoint'] += $basicPoint;
                $summary['totalExtraPoint'] += $extraPoint;
                $summary['totalBasicSalary'] += $basicSalary;
                $summary['totalExtraBonus'] += $extraBonus;
                $summary['totalFinalSalary'] += $finalSalary;
                $summary['hasBasicSalary'] = $summary['hasBasicSalary'] || $hasBasicSalary;
                $summary['hasExtraBonus'] = $summary['hasExtraBonus'] || ($extraBonus > 0);

                $data[] = array(
                    'name' => $host->name,
                    'id' => $host->id,
                    'hosting_type' => ((int) $host->hosting_type === 1) ? 'Audio' : 'Video',
                    'day' => (int) $durationMeta['running_day_count'],
                    'time' => $formattedDuration,
                    'gift' => $gift,
                    'extra_point' => $extraPoint,
                    'basic_point' => $basicPoint,
                    'basic_salary' => $basicSalary,
                    'day_bonus_salary' => 0,
                    'extra_bonus' => $extraBonus,
                    'final_salary' => $finalSalary,
                );
            }

            if (! empty($data)) {
                usort($data, function ($left, $right) {
                    return $right['gift'] <=> $left['gift'];
                });
            }
        }

        $summary['totalHosts'] = count($data);
        $html = view('salary_sheet', compact('agency', 'data', 'start_date', 'end_date', 'summary'))->render();
        Cache::put($cacheKey, $html, $this->businessNow()->addHours(6));

        return response($html);
    }

    public function Pusher()
    {
        $game_winner_text=array();
         $options = array(
                    'cluster' => 'ap1',
                    'useTLS' => true
                );
                  $pusher = new Pusher\Pusher(
                    '9ce9d96701d6600b426e',
                    '71aedfa829b4eb09c453',
                    '1618585',
                    $options
                );
                $message = "The Daily Prothom Alo is a daily newspaper in Bangladesh, published from Dhaka in the Bengali language.";
                      
                         array_push($game_winner_text,array('message'=>$message));
                          $pusher->trigger('game_winner_pusher', 'game_winner_pusher',$game_winner_text);
    }
     
    public function LuckStar()
  {
    return view('from.lucky_star');
  }
  public function LuckyStarStore(Request $request)
  {
    $validated = $request->validate([
        'host_id' => 'required|unique:lucky_stars',
        'agency_code' => 'required',
    ]);
    $data=new luckyStar;
    $data->host_id=$request->host_id;
    $data->agency_code=$request->agency_code;
    $data->status=0;
    $data->save();
    Session::flash('message', 'Data Submit SuccessFully!'); 
    Session::flash('alert-class', 'alert-danger'); 
    return Redirect()->back();

  }
  public function CommentRemoved(){
        $currentDate = Carbon\Carbon::now();
        
        $my_begs=MyBeg::where('expaire_time', '<', $currentDate)->get();
        foreach($my_begs as $my_beg){
            $user=User::find($my_beg->user_id);
            if($my_beg->type==1){
            if($user->entry==$my_beg->effect){
                $user->entry=null;
            }
            }else{
               if($user->frame==$my_beg->effect){
                $user->frame=null;
                } 
            }
            $user->save();
            $my_beg->delete();
        }
        $my_vips=VipList::where('end_date', '<', $currentDate)->get();
        foreach($my_vips as $my_vip){
            $user=User::find($my_vip->user_id);
           if($user->is_vip==$my_vip->vip_no){
               $user->is_vip=0;
               $user->entry=null;
               $user->frame=null;
               if($user->is_vip==7){
                   $user->is_invisible=0;
                   $user->is_invisible_active=0;
               }
               $user->save();
              
           }
            $my_vip->delete();
        }
        Comment::truncate();
   
      
  }
  public function SupperAgency($id)
  {
      $master_agency = Agency::where('code',$id)->first();
    	$data = ChildAgency::where('master_agency_id',$master_agency->id)->get();
    	$lists = [];
    	 list($start_date, $end_date, $start_at, $end_at) = $this->currentBusinessMonthRange();
		foreach ($data as $value) {

		    $agency = Agency::find($value->child_agency_id);
		    if($agency){
		     $host_gift_sum = DB::table('host_data')->join('gifts','gifts.reciever_id','host_data.user_id')->where('gifts.date', '>=', $start_at)->where('gifts.date', '<=', $end_at) ->where('host_data.agency_code',$agency->code)->sum('value');
		    $row = [
		        'agency' => $agency->name,
		        'agency_code' => $agency->code,
		        'id' => $value->child_agency_id,
		        'total_target' => $host_gift_sum,
		    ];
		    array_push($lists, $row);
		    }
		}
		 return view('supper_agency',compact('master_agency','lists','start_date','end_date'));
  }
}
