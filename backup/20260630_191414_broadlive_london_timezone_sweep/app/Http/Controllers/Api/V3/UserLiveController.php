<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Services\HomeService;
use App\Models\UserLive;
use App\Models\DayTime;
use App\Models\Setting;
use App\Models\LiveCall;
use App\Models\AudienceJoin;
use Kreait\Firebase\Database;
use Log;
class UserLiveController extends Controller
{
   protected $service;



public function __construct(HomeService $service)
{
    $this->service = $service;
}




    // ---------------------------------------------
    // BASIC HOME REQUEST
    // ---------------------------------------------
    public function index(Request $request)
    {
        // $requiredVersion = Setting::find(1)->flutter_version;
        // $flutterVersion = $request->get('flutter_version');
        // if (!$flutterVersion) {
        //       Log::warning('Blocked request due to No flutter version', [
        //     'user_id' => $request->get('user_id'),
        //     'need_version' =>$requiredVersion,
        //     'flutter_version' => $flutterVersion
        // ]);
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'App version is required.'
        //     ], 400);
        // }

        // // Force update if version is lower
        // if (version_compare($flutterVersion, $requiredVersion, '<')) {
        //       Log::warning('Blocked request due to old flutter version', [
        //     'user_id' => $request->query('user_id'),
        //     'need_version' =>$requiredVersion,
        //     'flutter_version' => $flutterVersion
        // ]);
        //     return response()->json([
        //         'status' => false,
        //         'force_update' => true,
        //         'message' => 'Please update your app to continue.'
        //     ], 426); // 426 = Upgrade Required
        // }
        
        
        // Log::info('All data: ' . print_r($request->flutter_version, true));
        return $this->handleHomeRequest($request, 'home');
    }

    public function PartyIndex(Request $request)
    {
        return $this->handleHomeRequest($request, 'party');
    }

    public function FriendsLive(Request $request)
    {
        return $this->handleHomeRequest($request, 'friends');
    }


    // ---------------------------------------------
    // SHARED HANDLER FOR ALL HOME ENDPOINTS
    // ---------------------------------------------
    private function handleHomeRequest(Request $request, string $type)
    {
        // Fast user fetch
        $user = DB::table('users')
            ->where('id', $request->user_id)
            ->select('id', 'name', 'ban_type', 'is_host_id', 'device_id', 'invite_done')
            ->first();

        if (!$user) {
            return response()->json([
                'message' => 'User Not Found',
                'code'    => 404
            ], 404);
        }

        // FAST BAN CHECK
        if ($user->ban_type) {
            $banMessage = $this->service->fastBanMessage($user->ban_type);
            return response()->json([
                'message' => $banMessage,
                'code'    => 403
            ], 403);
        }

        // CLEAR LIVES FOR PARTY MODE
        if ($type === 'party') {
            $this->service->clearUserLivesFast($user->id);
        }

        // HOME PAGE (CACHE)
        if ($type === 'home') {

            $data = Cache::remember("home_data_{$user->id}", 30, function () use ($user) {
                return $this->service->getHomePageData($user);
            });

        } else {

            // Party = type 1 live only
            $typeFilter = $type === 'party' ? 1 : 0;

            $data = [
                'lives_now' => $this->service->getLivesFast($typeFilter),
            ];
        }

        return response()->json(array_merge([
            'message' => 'Live Data Loaded Successfully',
            'code'    => 200
        ], $data), 200);
    }
    public function Delete(Request $request)
    {
         $token = $request->access_token;
         $id = $request->id;
         $day_times = $request->day_times;
         $channelName = $request->channelName;
        $response = array();
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
             $data=UserLive::where('user_id',$id)->first();
          
          if($data){
            
      
        $check_day_time=DayTime::where('user_id',$id)->where('channelName',$channelName)->first();
        if($check_day_time){
           
            $check_day_time->day_times=$day_times;
             $check_day_time->save();
            
           
        }else{
          $daytime=new DayTime;
          $daytime->user_id=$id;
          $daytime->channelName=$channelName;
          $daytime->day_times=$day_times;
          $daytime->brd_type=$data->type;
          $daytime->live_time=\Carbon\Carbon::now(config('app.timezone', 'Asia/Dhaka'))->toDateString();
          $daytime->save(); 
        }

       
        
            $call_list=LiveCall::where('host_id',$id)->get();
            $audience=AudienceJoin::where('host_id',$id)->get();

          if(count($call_list)>0){
            //return $call_list;
            foreach($call_list as $call){
              $call->delete();
            }
          }
          if(count($audience)>0){
            foreach($audience as $audienc){
              $audienc->delete();
            }
          }

         
          
          $data->delete();
          
        // $references = [
        //     'audience_counter',
        //     'Comments',
        //     'call_request',
        //     'audience_profile',
        //     'svga_audiogifts',
        //     'room_admin_list'
        // ];
        
        // foreach ($references as $ref) {
        //     $this->database->getReference("$ref/$channelName")->remove();
        // }

            array_push($response,array('message'=>'A Live Data Removed  Successfully ','code'=>'200'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
          }else{
             array_push($response,array('message'=>'User Not In Live ','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
          }
        }else{
            array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
}
