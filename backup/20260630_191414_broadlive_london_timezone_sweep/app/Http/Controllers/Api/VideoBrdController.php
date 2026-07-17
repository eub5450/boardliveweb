<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LiveCall;
use App\Models\Setting;
use App\Models\User;
use App\Models\Gift;
use App\Models\Kick;
use App\Models\Comment;
use App\Models\AudienceJoin;
use App\Models\UserLive;
use App\Models\BrdAdmin;
use App\Models\DayTime;
use Pusher;
use Carbon;
use App\Models\Follower;
use App\Models\PusherKey;
use DB;
use Auth;
use App\Models\Withdraw;
use Kreait\Firebase\Contract\Database;
use App\Helpers\LiveStreamHelper;
use Illuminate\Support\Facades\Cache;
class VideoBrdController extends Controller
{
  
   public function __construct(Database $database)
    {
        $this->database = $database;
    }
     public function AgoraSetting(Request $request)
    {
        
        $response = array();
        $websocket_call = array();
        $token = $request->access_token;
        $host_id = $request->host_id;
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            $setting=Setting::find(1);
            array_push($response,array('message'=>'Agora Setting Data','appId'=>$setting->appId,'appCertificate'=>$setting->appCertificate,'code'=>'200'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{
            array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
        
    }
    public function CallRequest(Request $request)
    {
        $response = [];
        
        // Check if user is banned
        $banCheck = LiveStreamHelper::checkUserBan($request->co_host_id);
        if ($banCheck) {
            $response[] = $banCheck;
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }
        
        // Validate access token
        if (!LiveStreamHelper::validateAccessToken($request->access_token)) {
            $response[] = ['message' => 'Unauthorized access_token', 'code' => '401'];
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }
        
        $host_id = $request->host_id;
        $channelName = $request->channelName;
        $co_host_id = $request->co_host_id;
        
        // Remove old call
        LiveCall::where('co_host_id', $co_host_id)->delete();
        
        // Check for existing call
        $check_call = LiveCall::where('co_host_id', $co_host_id)
            ->where('channelName', $channelName)
            ->where('host_id', $host_id)
            ->first();
            
        if ($check_call) {
            $response[] = ['message' => 'Call Already Sent', 'code' => '401'];
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }
        
        $live = UserLive::where('channelName', $channelName)
            ->where('user_id', $host_id)
            ->first();
            
        if (!$live) {
            $response[] = ['message' => 'Live Off Already', 'code' => '401'];
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }
        
        // Create new call
        $data = new LiveCall;
        $data->co_host_id = $co_host_id;
        $data->channelName = $channelName;
        $data->type = $live->type;
        $data->host_id = $host_id;
        $data->set_no = "0";
        $data->status = 'pending';
        $data->is_co_host_active = 'pending';
        $data->save();
        
        // Get call list
        $list = DB::table('live_calls')
            ->join('users', 'users.id', 'live_calls.co_host_id')
            ->select('users.name', 'users.profile', 'live_calls.channelName', 'live_calls.set_no')
            ->where('live_calls.channelName', $channelName)
            ->get();
        
        // Update call count
        LiveStreamHelper::updateCallRequestCount($channelName, $this->database);
        
        $response[] = [
            'message' => 'Call Request Sent Successfully',
            'data' => $list,
            'code' => '200'
        ];
        
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }
    
    public function Kick(Request $request)
    {
        $response = [];
        
        if (!LiveStreamHelper::validateAccessToken($request->access_token)) {
            $response[] = ['message' => 'Unauthorized access_token', 'code' => '401'];
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }
        
        $user_id = $request->user_id;
        $channelName = $request->channelName;
        $host_id = $request->host_id;
        
        // Remove old call
        LiveCall::where('co_host_id', $user_id)->delete();
        
        $user = Auth::user();
        $check_admin = BrdAdmin::where('user_id', $host_id)
            ->where('admin_id', $user->id)
            ->where('type', 1)
            ->first();
            
        $check_offical_user = User::find($user->id);
        
        // Create kick record
        $kick = new Kick;
        $kick->user_id = $user_id;
        $kick->channelName = $channelName;
        $kick->host_id = $host_id;
        $kick->save();
        
        $response[] = [
            'message' => 'Kick Successfully',
            'channelName' => $channelName,
            'user_id' => $user_id,
            'code' => '200'
        ];
        
        $websoket_kick[] = [
            'message' => 'rk_kick',
            'data' => $response,
            'channelName' => $channelName,
            'code' => '200',
            'channel_type' => '20'
        ];
        
        $roomName = 'Kick';
        self::RealTime($response, $roomName, $channelName);
        
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }
    
    public function PendingCallRemoved(Request $request)
    {
        $response = [];
        
        if (!LiveStreamHelper::validateAccessToken($request->access_token)) {
            $response[] = ['message' => 'Unauthorized access_token', 'code' => '401'];
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }
        
        $host_id = $request->host_id;
        $co_host_id = $request->co_host_id;
        $channelName = $request->channelName;
        
        // Remove pending call
        LiveCall::where('host_id', $host_id)
            ->where('channelName', $channelName)
            ->where('co_host_id', $co_host_id)
            ->where('status', 'pending')
            ->delete();
        
        // Get call list
        $list = DB::table('live_calls')
            ->join('users', 'users.id', 'live_calls.co_host_id')
            ->select('users.name', 'users.profile', 'live_calls.channelName', 'live_calls.set_no')
            ->where('live_calls.channelName', $channelName)
            ->get();
        
        // Update call count
        LiveStreamHelper::updateCallRequestCount($channelName, $this->database);
        
        $response[] = [
            'message' => 'Call Request Removed Successfully',
            'data' => $list,
            'code' => '200'
        ];
        
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }
    
    public function VideoCallAccept(Request $request)
    {
        $response = [];
        
        if (!LiveStreamHelper::validateAccessToken($request->access_token)) {
            $response[] = ['message' => 'Unauthorized access_token', 'code' => '401'];
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }
        
        $host_id = $request->host_id;
        $co_host_id = $request->co_host_id;
        $channelName = $request->channelName;
        
        // Check accept count
        $check_accept_count = LiveCall::where('host_id', $host_id)
            ->where('channelName', $channelName)
            ->where('status', 'Accept')
            ->count();
            
        if ($check_accept_count >= 3) {
            $response[] = ['message' => 'Already Three Co-Host Accepted', 'code' => '401'];
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }
        
        // Update call status
        $data = LiveCall::where('host_id', $host_id)
            ->where('channelName', $channelName)
            ->where('co_host_id', $co_host_id)
            ->where('status', 'pending')
            ->first();
            
        if ($data) {
            $data->status = 'Accept';
            $data->save();
        }
        
        // Get response using helper
        $response_data = LiveStreamHelper::getVideoCallResponse(
            $channelName,
            $host_id,
            'Video Call Accept List Data Show Successfully come from call Accept'
        );
        
        // Update call count
        LiveStreamHelper::updateCallRequestCount($channelName, $this->database);
        
        // Send real-time update
        $roomName = 'video_call_host_list';
        self::RealTime($response_data, $roomName, $channelName);
        
        return json_encode($response_data, JSON_UNESCAPED_UNICODE);
    }
    
    public function CallMute(Request $request)
    {
        $response = [];
        
        if (!LiveStreamHelper::validateAccessToken($request->access_token)) {
            $response[] = ['message' => 'Unauthorized access_token', 'code' => '401'];
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }
        
        $co_host_id = $request->co_host_id;
        $host_id = $request->host_id;
        $channelName = $request->channelName;
        $mute_status = $request->mute_satus;
        
        // Update mute status
        $data = LiveCall::where('channelName', $channelName)
            ->where('co_host_id', $co_host_id)
            ->where('host_id', $host_id)
            ->where('status', 'Accept')
            ->first();
            
        if ($data) {
            $data->mute = $mute_status;
            $data->save();
        }
        
        // Get response using helper
        $response_data = LiveStreamHelper::getVideoCallResponse(
            $channelName,
            $host_id,
            'Video Call Accept List Data Show Successfully come from call mute'
        );
        $response_data['set_remove'] = 11;
        
        // Send real-time update
        $roomName = 'video_call_host_list';
        self::RealTime($response_data, $roomName, $channelName);
        
        return json_encode($response_data, JSON_UNESCAPED_UNICODE);
    }
    
    public function Store(Request $request)
    {
        $response = [];
        
        if (!LiveStreamHelper::validateAccessToken($request->access_token)) {
            $response[] = ['message' => 'Unauthorized', 'code' => '401'];
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }
        
        $user_id = $request->user_id;
        $channelName = $request->channelName;
        $token = $request->token;
        $app_certificate = $request->app_certificate;
        $app_id = $request->app_id;
        $type = $request->type;
        $notice = $request->notice;
        $bullet_notice = $request->bullet_notice;
        $sdk = $request->sdk;
        
        // Remove old call
        LiveCall::where('co_host_id', $user_id)->delete();
        
        $user = User::find($user_id);
        $sdk = $request->sdk;
        
        // Calculate top value
        $user_total_gift_recived_today = Gift::where('reciever_id', $user->id)
            ->whereDate('date', \Carbon\Carbon::now(config('app.timezone', 'Asia/Dhaka'))->toDateString())
            ->sum('value');
        $top_value = $user->top_value + $user_total_gift_recived_today;
        
        // Create live session
        $data = new UserLive;
        $data->user_id = $user_id;
        $data->channelName = $channelName;
        $data->name = $user->name;
        $data->top_value = $top_value;
        $data->type = $type;
        $data->notice = $notice ?? 0;
        $data->bullet_notice = $bullet_notice ?? 0;
        $data->token = $token;
        $data->sdk = $sdk;
        $data->appId = $app_id;
        $data->appCertificate = $app_certificate;
        $data->date = Carbon\Carbon::now();
        $data->save();
        
     
        // Send push notification
        self::send_push_notification($user, $channelName, $type);
        
        // Get response using helper
        $response_data = LiveStreamHelper::getVideoCallResponse(
            $channelName,
            $user_id,
            'Host List come from brd start'
        );
        
        // Send real-time update
        $roomName = 'video_call_host_list';
        self::RealTime($response_data, $roomName, $channelName);
        
        return json_encode($response_data, JSON_UNESCAPED_UNICODE);
    }
    
    public function CallRemoved(Request $request)
    {
        $response = [];
        
        if (!LiveStreamHelper::validateAccessToken($request->access_token)) {
            $response[] = ['message' => 'Unauthorized access_token', 'code' => '401'];
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }
        
        $host_id = $request->host_id;
        $co_host_id = $request->co_host_id;
        $channelName = $request->channelName;
        
        // Remove accepted call
        LiveCall::where('host_id', $host_id)
            ->where('channelName', $channelName)
            ->where('co_host_id', $co_host_id)
            ->where('status', 'Accept')
            ->delete();
        
        // Get response using helper
        $response_data = LiveStreamHelper::getVideoCallResponse(
            $channelName,
            $host_id,
            'Video Call Accept List Data Show Successfully come from remove call'
        );
        
        // Send real-time update
        $roomName = 'video_call_host_list';
        self::RealTime($response_data, $roomName, $channelName);
        
        return json_encode($response_data, JSON_UNESCAPED_UNICODE);
    }
    
    public function HostCallRemove(Request $request)
    {
        $response = [];
        
        if (!LiveStreamHelper::validateAccessToken($request->access_token)) {
            $response[] = ['message' => 'Unauthorized access_token', 'code' => '401'];
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }
        
        $co_host_id = $request->co_host_id;
        $host_id = $request->host_id;
        $channelName = $request->channelName;
        
        $response[] = [
            'message' => 'Video Call Removed By Host',
            'co_host_id' => $co_host_id,
            'host_id' => $host_id,
            'channelName' => $channelName,
            'code' => '200'
        ];
        
        $roomName = 'video_host_call_remove';
        self::RealTime($response, $roomName, $channelName);
        
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }
    
    public function VideoGiftPush(Request $request)
    {
        $response = [];
        
        if (!LiveStreamHelper::validateAccessToken($request->access_token)) {
            $response[] = ['message' => 'Unauthorized', 'code' => '401'];
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }
        
        $user_id = $request->user_id;
        $value = $request->value;
        $gift_name = $request->giftName;
        $music = $request->music;
        $channelName = $request->channelName;
        $host_id = $request->host_id;
        $gift_type = $request->gift_type;
        
        $data = json_decode($request->getContent(), true);
        
        if (!isset($data['items']) || !is_array($data['items']) || empty($data['items'])) {
            $response[] = ['message' => 'Must Send at Least One Gift', 'code' => '401'];
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }
        
        $sander = User::find($user_id);
        $total_gift_value = $value * count($data['items']);
        
        if ($sander->balance < $total_gift_value) {
            $response[] = ['message' => 'Insufficient balance', 'code' => '401'];
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }
        
        $forcomment = [];
        $global_txt = [];
        $first_gift = true;
        
        foreach ($data['items'] as $row) {
            $receiver_id = $row['receiverId'];
            
            // Create gift record
            $gift = new Gift;
            $gift->sander_id = $user_id;
            $gift->reciever_id = $receiver_id;
            $gift->name = $gift_name;
            $gift->value = $value;
            $gift->channelName = $channelName;
            $gift->date = Carbon\Carbon::now();
            
            if ($gift->save()) {
                // Deduct from sender
                $sander->balance -= $value;
                $sander->total_sent_gifts += $value;
                $sander->save();
                
                // Update receiver's top value
                $top_value_update_user = User::find($receiver_id);
                $top_value_update_user->total_recived_gifts+=$value;
                $check_user_live = UserLive::where('user_id', $top_value_update_user->id)->first();
                
                if ($check_user_live) {
                    $user_total_gift_recived_today = Gift::where('reciever_id', $top_value_update_user->id)
                        ->whereDate('date', \Carbon\Carbon::now(config('app.timezone', 'Asia/Dhaka'))->toDateString())
                        ->sum('value');
                    $top_value = $top_value_update_user->top_value + $user_total_gift_recived_today;
                    $check_user_live->top_value = $top_value;
                    $check_user_live->save();
                }
                
                // Global gift notification for large gifts
                if ($value > 49999) {
                    $sender_name = User::find($user_id);
                    $receiver_name = User::find($receiver_id);
                    $message = "$sender_name->name sent $value to $receiver_name->name";
                    
                    $global_txt[] = [
                        'message' => $message,
                        'image' => $sender_name->profile,
                        'name' => $sender_name->name
                    ];
                }
                
                $receiver_name = User::find($receiver_id);
                $forcomment[] = $receiver_name->name;
                
                // Update user level
                self::updateUserLevel($user_id);
                
                // Send gift notification to Firebase (only for first gift)
                if ($first_gift) {
                    $balance = Gift::where('reciever_id', $receiver_id)
                        ->where('channelName', $channelName)
                        ->sum('value');
                    
                    $audience = User::find($user_id);
                    
                    $count = [
                        'channelName' => $channelName,
                        'name' => $gift->name,
                        'gift_time' => strval(7),
                        'host_balance' => strval($balance),
                        'music' => strval(''),
                        'audience_balance' => strval($audience->balance),
                        'reciever_id' => strval($gift->reciever_id),
                        'status' => 'active',
                        'gift_type' => strval($gift_type),
                    ];
                    
                    $new_gift_push = $this->database->getReference('svga_audiogifts/' . $channelName . '/linda/' . $gift->reciever_id);
                    $new_gift_push->set($count);
                    
                    $first_gift = false;
                }
            }
        }
        
        // Send global gift notification
        if (!empty($global_txt)) {
            $roomName = 'golbal_gift_banner';
            self::RealTime($global_txt, $roomName, $channelName);
        }
        
        // Update video call list
        $pusher_response = LiveStreamHelper::getVideoCallResponse(
            $channelName,
            $host_id,
            'Pusher Data Come From Video Brd Gift'
        );
        
        $roomName = 'video_call_host_list';
        self::RealTime($pusher_response, $roomName, $channelName);
        
        // Add gift comment
        $sender_name = User::find($user_id);
        $all_receiver_names = implode(', ', $forcomment);
        $comment_message = "$sender_name->name sent $value to $all_receiver_names";
        
        $gift_comment = [
            'balance' => strval($sender_name->balance),
            'channelName' => strval($channelName),
            'id' => $sender_name->id,
            'message' => strval('@' . $comment_message),
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
        
        $comments_ref = $this->database->getReference('Comments/' . $channelName);
        $existing_comments = $comments_ref->getValue();
        $next_index = is_array($existing_comments) ? count($existing_comments) : 0;
        
        $next_comment_ref = $this->database->getReference('Comments/' . $channelName . '/' . $next_index);
        $next_comment_ref->set($gift_comment);
        
        $response[] = [
            'message' => 'Gifts Sent Successfully',
            'user_id' => $sander->id,
            'balance' => $sander->balance,
            'code' => '200'
        ];
        
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }
    
    public function HostMue(Request $request)
    {
        $response = [];
        
        if (!LiveStreamHelper::validateAccessToken($request->access_token)) {
            $response[] = ['message' => 'Unauthorized', 'code' => '401'];
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }
        
        $host_id = $request->host_id;
        $mute_status = $request->mute_satus;
        $channelName = $request->channelName;
        
        // Update host mute status
        $live = UserLive::where('channelName', $channelName)
            ->where('user_id', $host_id)
            ->first();
            
        if ($live) {
            $live->mute = $mute_status;
            $live->save();
        }
        
        // Get response using helper
        $response_data = LiveStreamHelper::getVideoCallResponse(
            $channelName,
            $host_id,
            'Video Call Accept List Data Show Successfully come from Host Mute Unmute'
        );
        
        // Send real-time update
        $roomName = 'video_call_host_list';
        self::RealTime($response_data, $roomName, $channelName);
        
        return json_encode($response_data, JSON_UNESCAPED_UNICODE);
    }
  public function UserData(Request $request)
{
    $response = [];

    // ✅ Validate access token
    if (!LiveStreamHelper::validateAccessToken($request->access_token)) {
        return response()->json([
            [
                'message' => 'Unauthorized',
                'code' => '401'
            ]
        ], 401);
    }

    // ✅ Get request params safely
    $user_id     = $request->user_id ?? null;
    $host_id     = $request->host_id ?? null;
    $channelName = $request->channelName ?? null;

    // ✅ Basic validation
    if (!$user_id || !$host_id || !$channelName) {
        return response()->json([
            [
                'message' => 'Invalid parameters',
                'code' => '422'
            ]
        ], 422);
    }

    // ✅ Get user data
    $user_data = LiveStreamHelper::getUserData($user_id, $host_id);

    // ✅ Ensure user data is always an array
    if (!is_array($user_data)) {
        $user_data = [];
    }

    // ✅ If it's not the host, send realtime video call update
    if ($host_id != $user_id) {

        $video_response = LiveStreamHelper::getVideoCallResponse(
            $channelName,
            $host_id,
            'Video Call Accept List Data Show Successfully From Video User Data'
        );

        // ✅ Ensure array safety
        if (!is_array($video_response)) {
            $video_response = [];
        }

        $video_response['set_remove'] = 11;

        $roomName = 'video_call_host_list';
        self::RealTime($video_response, $roomName, $channelName);
    }

    // ✅ Final response merge (SAFE)
    $response[] = array_merge(
        [
            'message' => 'User Data Show Successfully',
            'code'    => '200'
        ],
        $user_data
    );

    return response()->json($response, 200, [], JSON_UNESCAPED_UNICODE);
}

    /**
     * Update user level based on total gift value sent
     */
    private function updateUserLevel($user_id)
    {
        $user = User::find($user_id);
        $total = $user->total_sent_gifts;
        
        if ($total <= 0) {
            return;
        }
        
        $levelBoundaries = [
            2 => [10000, 50000],
            3 => [50001, 100000],
            4 => [100001, 150000],
            5 => [150001, 200000],
            6 => [200001, 400000],
            7 => [400001, 600000],
            8 => [600001, 800000],
            9 => [800001, 1000000],
            10 => [1000001, 1200000],
            11 => [1200001, 2200000],
            12 => [2200001, 3200000],
            13 => [3200001, 4200000],
            14 => [4200001, 5200000],
            15 => [5200001, 6200000],
            16 => [6200001, 8200000],
            17 => [8200001, 10200000],
            18 => [10200001, 12200000],
            19 => [12200001, 14200000],
            20 => [14200001, 16200000],
            21 => [16200001, 19200000],
            22 => [19200001, 22200000],
            23 => [22200001, 25200000],
            24 => [25200001, 28200000],
            25 => [28200001, 31200000],
            26 => [31200001, 40000000],
            27 => [40000001, 50000000],
            28 => [50000001, 60000000],
            29 => [60000001, 70000000],
            30 => [70000001, 80000000],
            31 => [80000001, 100000000],
            32 => [100000001, 120000000],
            33 => [120000001, 140000000],
            34 => [140000001, 160000000],
            35 => [160000001, 180000000],
            36 => [180000001, 200000000],
            37 => [200000001, 220000000],
            38 => [220000001, 240000000],
            39 => [240000001, 260000000],
            40 => [260000001, 280000000],
            41 => [280000001, 330000000],
            42 => [330000001, 380000000],
            43 => [380000001, 430000000],
            44 => [430000001, 480000000],
            45 => [480000001, 530000000],
            46 => [530000001, 580000000],
            47 => [580000001, 630000000],
            48 => [630000001, 680000000],
            49 => [680000001, 730000000]
        ];
        
        $level = 1;
        foreach ($levelBoundaries as $lvl => $boundary) {
            if ($total >= $boundary[0] && $total < $boundary[1]) {
                $level = $lvl;
                break;
            }
        }
        
        $user->level = $level;
        $user->save();
    }
    
   public function VideoBrdDayTimeRequest(Request $request)
    {
        $response = array();
         $global_websoket = array();
         $global_txt = array();
        $token = $request->access_token;
        $id = $request->host_id;
        $channelName = $request->channelName;
        $brd_type = $request->brd_type;
        $day_times = $request->day_times;
         $reward_amount=0;
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
        
       $sum_date_time = DayTime::where('user_id', $id)
            ->whereDate('live_time', now()->toDateString())
            ->where('brd_type', 2)
            ->selectRaw('COALESCE(SUM(TIME_TO_SEC(day_times)), 0) AS total_seconds')
            ->first();
        
        $totalDurationInSeconds = (int) ($sum_date_time->total_seconds ?? 0); // cast it
        $threshold = 50 * 60; // 3420
        
       
       $currentTime = Carbon\Carbon::now();
    
     if (!$currentTime->between(Carbon\Carbon::today()->setTime(5, 0, 0), Carbon\Carbon::today()->setTime(11, 0, 0))) {
         if ($totalDurationInSeconds >= $threshold) {
               $existingReward = Gift::where('reciever_id', $id)
                                 ->whereDate('date', Carbon\Carbon::today())->where('sander_id',11162)
                                 ->first();

                 if (!$existingReward) { 
                         $value=5000;
                         $sander_user=User::find(11162);
                         $gift = new Gift;
                         $gift->sander_id = $sander_user->id;
                         $gift->reciever_id = $id;
                         $gift->name = 'reward.svga';
                         $gift->value = $value;
                         $gift->channelName=$channelName;
                         $gift->date = Carbon\Carbon::now();
                         if($gift->save()){
                             $sander_user->balance-=$value;
                             $sander_user->save();
                             $reciever=User::find($id);
                             $commnet_message = "{$reciever->name} Got 5000 Coin Reward From Broad Live ";
                            
                                     $data=new Comment;
                                     $data->user_id=11162;
                                     $data->channelName=$channelName;
                                     $data->message=$commnet_message;
                                     $data->reciever_id=$id;
                                     $data->type='message';
                                     $data->save();
                                    
                                    
                                     $gift_comment = [
                             'balance' => strval($sander_user->balance),
                             'channelName' => strval($channelName),
                             'id' => $sander_user->id,
                             'message' => strval('@'.$commnet_message),
                             'level' => strval($sander_user->level),
                             'name' => strval($sander_user->name),
                             'profile' => strval($sander_user->profile),
                             'is_vip' => strval($sander_user->is_vip),
                             'frame' => strval($sander_user->frame),
                             'is_official_id' => strval($sander_user->is_official_id),
                             'is_agency' => strval($sander_user->is_agency),
                             'is_host_id' => strval($sander_user->is_host_id),
                             'comment_badge' => strval($sander_user->comment_badge),
                             'type' => "message",
                         ];
                        
                         // Reference to the channel comments
                         $comments_ref = $this->database->getReference('Comments/'.$channelName);
                        
                         // Get the existing comments
                         $existing_comments = $comments_ref->getValue();
                        
                        //  Determine the next index
                         $next_index = 0;
                         if (is_array($existing_comments)) {
                             $next_index = count($existing_comments);
                         }
                        
                        //  Push the new comment at the next index
                         $next_comment_ref = $this->database->getReference('Comments/'.$channelName.'/'.$next_index);
                         $next_comment_ref->set($gift_comment);
                        
                        // info('reward_firebase: ' . $next_comment_ref. 'user_ID ' .$id);
                             
                          array_push($global_txt,array('message'=>$commnet_message,'image'=>$sander_user->profile,'name'=>$sander_user->name));
                          $roomName='golbal_gift_banner';
                         self::RealTime($global_txt,$roomName,$channelName);
                         $reward_amount = $value;
                     }
                 }
                // info('give_time_reward_amount: ' . $reward_amount. ' user_ID ' .$id. ' day_time ' .$totalDurationInSeconds. ' date ' .\Carbon\Carbon::now(config('app.timezone', 'Asia/Dhaka'))->toDateString());
             }
            // info('atteped_reward_amount: ' . $reward_amount. ' user_ID ' .$id. ' day_time ' .$totalDurationInSeconds. ' date ' .\Carbon\Carbon::now(config('app.timezone', 'Asia/Dhaka'))->toDateString());
                
         }
         //end
       
        $check_day_time=DayTime::where('user_id',$id)->where('channelName',$channelName)->first();
        if($check_day_time){
           
            $check_day_time->day_times=$day_times;
             $check_day_time->save();
            
           
        }else{
          $daytime=new DayTime;
          $daytime->user_id=$id;
          $daytime->channelName=$channelName;
          $daytime->day_times=$day_times;
          $daytime->brd_type=$request->brd_type;
          $daytime->live_time=\Carbon\Carbon::now(config('app.timezone', 'Asia/Dhaka'))->toDateString();
          $daytime->save(); 
        }
           
        array_push($response,array('message'=>'Data Store','reward_amount'=>$reward_amount,'code'=>'200'));
        return json_encode($response,JSON_UNESCAPED_UNICODE);
        
        }else{
            array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
        
    }
       public function send_push_notification($host_data, $channelName, $brd_type)
            {
                 //$notificationBody = "test";
                  //$title =" Open A new live come and enjoy.";
                // Fetch all followers with related user data in one go to minimize database queries
                $followers = Follower::where('follower_id', $host_data->id)->get();
            
                $device_ids = []; // Initialize an empty array to store device IDs

                foreach ($followers as $follower) {
                    // Check if user data is loaded
                    $user = User::find($follower->user_id);
                
                    // Ensure the user and device ID exist before adding to the array
                    if ($user && $user->device_id) {
                        $device_ids[] = $user->device_id; // Add device ID to the array
                    }
                }
                 
                   foreach ($device_ids as $device_id) {
                     
                        $url = 'https://fcm.googleapis.com/fcm/send';
                        $serverKey = 'AAAAFqwSmh4:APA91bHpHEO9D0TsDbZDuRq3SiHiyFeUjZIngmv8e2xvwK7NersEky4RlBKo25_gsg-Re_FBHUR6Q8nvqf8NzR5nj7gjWIePETKRFn4VZOXm6poVoOBZ8_SFoOO15TyxdzofcwE1NZ4i';
                      
                        $data = [
                            'to' => $device_id,
                             'data' => [
                            'link' => "https://bplive.site/new_live/share/v2/{$host_data->id}/{$channelName}/{$brd_type}",
                            'profile' => "https://bplive.site/{$host_data->profile}",
                            ],
                            'notification' => [
                                 'body' => "I am waiting for you,Please Join my Live",
                                'title' => $host_data->name,
                                'click_action' => 'deviceNoti',
                            ],
                        ];
                        
                        $headers = [
                            'Content-Type: application/json',
                            'Authorization: key=' . $serverKey,
                        ];
                        
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        
                        $response = curl_exec($ch);
                        
                        if ($response === false) {
                            $error = curl_error($ch);
                            // Handle the error
                            echo 'cURL error: ' . $error;
                        } else {
                            // Process the response
                            echo 'FCM API response: ' . $response;
                        }
                        
                        curl_close($ch);
                    }
  
            }
            
    public function CohostisActive(Request $request)
    {
         $access_token = $request->access_token;
         $co_host_id = $request->co_host_id;
         $host_id = $request->host_id;
         $channelName = $request->channelName;
         $is_co_host_active = $request->is_co_host_active;
        $response = array();
        $websocket_call = array();
        if($access_token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
         $data=LiveCall::where('channelName',$channelName)->where('co_host_id',$co_host_id)->where('host_id',$host_id)->where('status','Accept')->first();
          if($data){
          $data->is_co_host_active=$is_co_host_active;
           $data->save();
          }
            $live=UserLive::where('channelName','=',$channelName)->where('user_id',$host_id)->first();
            $accept_list=LiveCall::where('channelName',$channelName)->where('host_id',$host_id)->where('status','Accept')->get();
            $host_data=User::find($host_id);
      $list = array();
            $co_host_list = array();
            $host = array();
            $host['channelName'] = $channelName;
            $host['profile'] = $host_data->profile;
            $host['is_vip'] = $host_data->is_vip;
            $host['balance'] = Gift::where('reciever_id', $host_data->id)->where('channelName',$channelName)->sum('value');
            $host['co_host_name'] = $host_data->name;
            $host['set_no'] = "0";
            $host['mute'] = $live ? $live->mute : 0;
            $host['frame'] = strval($host_data->frame);
            $host['co_host_id'] = strval($host_data->id);
            $host['co_host_status'] = strval('Accept');
            
            array_push($list, $host);
            
            foreach ($accept_list as $call) {
                $co_host = User::find($call->co_host_id);
                $row = array();
                $row['channelName'] = $channelName;
                $row['profile'] = $co_host->profile;
                $row['is_vip'] = $co_host->is_vip;
                $row['balance'] =Gift::where('reciever_id', $co_host->id)->where('channelName',$channelName)->sum('value');
                $row['co_host_name'] = $co_host->name;
                $row['set_no'] = "0";
                $row['mute'] = $call->mute;
                $row['frame'] = strval($co_host->frame);
                $row['co_host_id'] = strval($call->co_host_id);
                $row['co_host_status'] = strval($call->is_co_host_active);
                array_push($list, $row);
                array_push($co_host_list, $row);
            }
             $date = Carbon\Carbon::now(); // Replace this with your desired date

                if ($date->day <= 15) {
                 $start_date = date('Y-m') . '-01';
                $end_date = date('Y-m') . '-15';
            }else{
                $start_date = date('Y-m') . '-16';
                $end_date = date('Y-m') . '-31';
            }
                
                $query = DB::table('gifts')
                    ->join('users', 'users.id', '=', 'gifts.sander_id')
                   ->whereDate('gifts.date', '>=', $start_date)
                   ->whereDate('gifts.date', '<=', $end_date) 
                   ->where('gifts.reciever_id',$host_id)
                ->select('users.profile', 'users.name', 'users.id', 'users.level', 'gifts.value');
                $total_gift_coin=$query->sum('value');
               $total_withdraw=Withdraw::where('host_id',$host_id)->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->sum('total');
               $total_gift_sum= ($host_data->previous_coin+$total_gift_coin)-$total_withdraw;
            
             $today_gift = Gift::where('reciever_id',$host_id)
                  ->whereDate('date', \Carbon\Carbon::now(config('app.timezone', 'Asia/Dhaka'))->toDateString())
                  ->sum('value');

                   $next_level_amount=50000;
                $star = 1;

                if ($today_gift < 50000) {
                    $star = 1;
                    $next_level_amount=50000;
                } elseif ($today_gift >= 50000 && $today_gift < 200000) {
                    $star = 2;
                    $next_level_amount=200000;
                } elseif ($today_gift >= 200000 && $today_gift < 500000) {
                    $star = 3;
                    $next_level_amount=500000;
                } elseif ($today_gift >= 500000 && $today_gift < 1000000) {
                    $star = 4;
                    $next_level_amount=1000000;
                } elseif ($today_gift >= 1000000 && $today_gift < 2000000) {
                    $star = 5;
                    $next_level_amount=2000000;
                } elseif ($today_gift >= 2000000) {
                    $next_level_amount=20000000;
                    $star = 5; // Adjusted for values equal to or greater than 2000000
                }
                 $need_parcent=intval($today_gift/$next_level_amount*100);
            
               array_push($response,array('message'=>'Video Call Accept List Data Show Successfully come from  call mute ','host_list'=>$list,'co_host_list'=>$co_host_list,'set_remove'=>11,'host_balance'=>$total_gift_sum,'star'=>$star,'star_complete_parcent'=>$need_parcent,'channelName'=>$channelName,'code'=>'200'));
               // array_push($websocket_call,array('message'=>'rk_video_call','data'=>$response,'channelName'=>$channelName,'code'=>'200','channel_type' => '19'));;
             //  self::Websoket($websocket_call);
               $roomName='video_call_host_list';
               self::RealTime($response,$roomName,$channelName);
             return json_encode($response,JSON_UNESCAPED_UNICODE);
         
        }else{
            array_push($response,array('message'=>'Unauthorized access_token','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
private function RealTime($response, $roomName, $channelName)
{
    if (empty($channelName) || !is_string($channelName)) {
        return false;
    }

    $setting = Setting::find(1);

    $options = [
        'cluster' => $setting->cluster,
        'useTLS'  => true,
    ];

    $pusher = new Pusher\Pusher(
        $setting->key,
        $setting->secret,
        $setting->app_id,
        $options
    );

    try {
        return $pusher->trigger($roomName, $channelName, $response);
    } catch (\Pusher\ApiErrorException $e) {
       
            // Switch to a new Pusher account
            $switched = $this->switchPusherAccount($setting->pusher_id);
            
            if ($switched) {
                // Get the updated settings with the new Pusher credentials
                $newSetting = Setting::find(1);
                
                // Create new Pusher instance with updated credentials
                $newOptions = [
                    'cluster' => $newSetting->cluster,
                    'useTLS'  => true,
                ];
                
                $newPusher = new Pusher\Pusher(
                    $newSetting->key,
                    $newSetting->secret,
                    $newSetting->app_id,
                    $newOptions
                );
                
                // Retry the trigger with the new account
                try {
                    return $newPusher->trigger($roomName, $channelName, $response);
                } catch (\Exception $retryException) {
                    // Log the retry failure
                    \Log::error('Failed to send after switching Pusher account', [
                        'userId' => 1,
                        'error' => $retryException->getMessage()
                    ]);
                    return false;
                }
            }
        
        
        
        
        return false;
    }
}

private function switchPusherAccount($pusher_id)
{
    return Cache::lock('pusher-switch-global-lock', 5)->block(3, function () use ($pusher_id) {
        $current = PusherKey::find($pusher_id);

        if ($current && $current->pusher_active_time) {
            $activeDuration = now()->diffInMinutes($current->pusher_active_time);
            if ($activeDuration < 5) {
                return false;
            }
        }

        try {
            DB::transaction(function () use ($current) {
                if ($current) {
                    $current->update([
                        'pusher_status'        => 2,
                        'pusher_deactive_time' => now(),
                    ]);
                }

                $nextPusher = PusherKey::where('pusher_status', 0)->where('used_for',1)
                    ->when($current, function ($query) use ($current) {
                        return $query->where('id', '>', $current->id);
                    })
                    ->orderBy('id', 'asc')
                    ->first();

                if (!$nextPusher) {
                    $nextPusher = PusherKey::where('pusher_status', 0)->where('used_for',1)
                        ->orderBy('id', 'asc')
                        ->first();
                }

                if (!$nextPusher) {
                    throw new \Exception('No available Pusher accounts found');
                }

                Setting::where('id', 1)->update([
                    'pusher_id' => $nextPusher->id,
                    'key'       => $nextPusher->pusher_key,
                    'secret'    => $nextPusher->pusher_secret,
                    'app_id'    => $nextPusher->puser_app_id, 
                    'cluster'   => $nextPusher->pusher_cluster,
                ]);

                $nextPusher->update([
                    'pusher_active_time' => now(),
                    'pusher_status'      => 1,
                ]);
            });
            
            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to switch Pusher account', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    });
}


    
  
    
    private function Websoket($data) {
    $response_json = json_encode($data);

    try {
        // Initialize cURL
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.104.191.163/api/recieve-three',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
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
            info('cURL error: ' . curl_error($curl));
        } else {
            // Optionally, log response code for debugging
            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            //info('HTTP response code For Video Brd recieve-three: ' . $http_code);
        }
        
        // Close the cURL session
        curl_close($curl);

    } catch (\Throwable $th) {
        // Log any other errors
        info('Exception: ' . $th->getMessage());
    }
    }
}
