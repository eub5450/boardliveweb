<?php

namespace App\Http\Controllers\Api\V4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon;
use Pusher;
use App\Models\LiveCall;
use App\Models\AudienceJoin;
use App\Models\Setting;
use App\Models\Gift;
use App\Models\User;
use App\Models\Kick;
use App\Models\UserLive;
use App\Models\Comment;
use Illuminate\Support\Facades\Cache;
use App\Models\PusherKey;
use App\Models\Withdraw;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Contract\Database;
use App\Helpers\AudioLiveStreamHelper;
use App\Services\V4\V4CacheService;

class AudioBrdController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
    }
   public function HostList(Request $request)
    {
    $token       = $request->access_token;
    $host_id     = $request->host_id;
    $channelName = $request->channelName;

    // Validate Token
    if (!AudioLiveStreamHelper::validateAccessToken($token)) {
        return response()->json([
            ['message' => 'Unauthorized access_token', 'code' => '401']
        ], JSON_UNESCAPED_UNICODE);
    }

    // Fetch co-host list (FAST â€“ single query)
    $list = DB::table('live_calls')
        ->join('users', 'users.id', '=', 'live_calls.co_host_id')
        ->select(
            'users.name',
            'users.profile',
            'live_calls.channelName',
            'live_calls.co_host_id',
            'live_calls.status',
            'live_calls.set_no'
        )
        ->where('live_calls.host_id', $host_id)
        ->where('live_calls.channelName', $channelName)
        ->where('live_calls.status', 'Accept')
        ->get();

    return response()->json([
        ['message' => 'Host List Loaded', 'data' => $list, 'code' => '200']
    ], JSON_UNESCAPED_UNICODE);
}

   public function PendingCallRemoved(Request $request)
{
    $token       = $request->access_token;
    $host_id     = $request->host_id;
    $co_host_id  = $request->co_host_id;
    $channelName = $request->channelName;

    // Validate token
    if (!AudioLiveStreamHelper::validateAccessToken($token)) {
        return response()->json([
            ['message' => 'Unauthorized access_token', 'code' => '401']
        ], JSON_UNESCAPED_UNICODE);
    }

    // Find pending request entry
    $call = LiveCall::where('host_id', $host_id)
        ->where('channelName', $channelName)
        ->where('co_host_id', $co_host_id)
        ->where('status', 'pending')
        ->first();

    if ($call) {
        $call->delete();
        $message = 'Call Request Removed Successfully';
        $code    = '200';
    } else {
        $message = 'Call Not Request Removed Successfully';
        $code    = '401';
    }

    // Build updated pending call list (1 query)
    $list = DB::table('live_calls')
        ->join('users', 'users.id', '=', 'live_calls.co_host_id')
        ->select('users.name', 'users.profile', 'live_calls.channelName', 'live_calls.set_no')
        ->where('live_calls.channelName', $channelName)
        ->where('live_calls.status', 'pending')
        ->get();

    // Count pending calls
    $call_count = LiveCall::where('status', 'pending')
        ->where('channelName', $channelName)
        ->count();

    // Prepare final output
    $response = response()->json([
        [
            'message' => $message,
            'data'    => $list,
            'code'    => $code
        ]
    ], JSON_UNESCAPED_UNICODE);

    // ASYNC FIREBASE UPDATE - using fastcgi_finish_request
    if (function_exists('fastcgi_finish_request')) {
        // Send response immediately
        $response->send();
        fastcgi_finish_request();
        
        // Firebase update in background
        try {
            $this->database
                ->getReference("call_request/{$channelName}")
                ->set([
                    'call_count' => strval($call_count)
                ]);
        } catch (\Exception $e) {
            // Silent fail - already sent response
        }
        
        exit;
    } else {
        // If fastcgi_finish_request not available, do Firebase sync
        $this->database
            ->getReference("call_request/{$channelName}")
            ->set([
                'call_count' => strval($call_count)
            ]);
        
        return $response;
    }
}

    public function Kick(Request $request)
    {
         $access_token = $request->access_token;
         $host_id = $request->host_id;
         $channelName = $request->channelName;
         $user_id = $request->user_id;
        $response = array();
        $websoket_kick = array();
        if($access_token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            $remove_old_call=LiveCall::where('co_host_id',$user_id)->first();
            if($remove_old_call){
            $remove_old_call->delete();
            }
            $kick=new Kick;
            $kick->user_id=$user_id;
            $kick->channelName=$channelName;
            $kick->host_id=$host_id;
            $kick->save();
            array_push($response,array('message'=>'Kick Successfully ','channelName'=>$channelName,'user_id'=>$user_id,'code'=>'200'));
                
            $roomName='audio_kick';
            self::RealTime($response,$roomName,$channelName);
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{
            array_push($response,array('message'=>'Unauthorized access_token','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
        }
   
     /* -------------------------------------------------------------
     * AUDIO CALL ACCEPT  (uses cache)
     * ------------------------------------------------------------- */
    public function AudioCallAccept(Request $request)
    {
        $access_token = $request->access_token;
        $host_id      = $request->host_id;
        $co_host_id   = $request->co_host_id;
        $channelName  = $request->channelName;

        if (!AudioLiveStreamHelper::validateAccessToken($access_token)) {
            return response()->json([
                ['message' => 'Unauthorized access_token', 'code' => '401']
            ], 200, [], JSON_UNESCAPED_UNICODE);
        }

        $pending = LiveCall::where('host_id', $host_id)
            ->where('co_host_id', $co_host_id)
            ->where('channelName', $channelName)
            ->where('status', 'pending')
            ->first();

        if ($pending) {
            $pending->status = 'Accept';
            $pending->save();

            // room changed
            AudioLiveStreamHelper::clearRoomCache($channelName, $host_id);
        }

        $state = AudioLiveStreamHelper::getRoomStateCached($channelName, $host_id);

        $payload = [
            'message'                => 'Audio Call Accept List Data Show Successful',
            'host_list'              => $state['host_list'],
            'co_host_list'           => $state['co_host_list'],
            'set_remove'             => 11,
            'host_balance'           => $state['host_balance'],
            'star'                   => $state['star'],
            'star_complete_parcent'  => $state['star_complete_percent'],
            'channelName'            => $channelName,
            'code'                   => '200'
        ];

        if (method_exists($this, 'RealTime')) {
            $this->RealTime([$payload], 'audio_call_host_list', $channelName);
        }

        AudioLiveStreamHelper::updateCallRequestCount($channelName, $this->database);

        return response()->json([$payload], 200, [], JSON_UNESCAPED_UNICODE);
    }
   /* -------------------------------------------------------------
     * CALL REQUEST  (uses cache only in locked=1 branch)
     * ------------------------------------------------------------- */
    public function CallRequest(Request $request)
    {
        $co_host_id  = $request->co_host_id;
        $host_id     = $request->host_id;
        $channelName = $request->channelName;
        $set_no      = $request->set_no;
        $token       = $request->access_token;

        // 1. BAN CHECK
        $banned = User::whereNotNull('ban_type')->where('id', $co_host_id)->first();
        if ($banned) {
            $msg = [
                'B' => 'Opps !! Your ID Banned For One Month . violation Rules B',
                'C' => 'Opps !! Your ID Banned For 24 Hours . violation Rules C',
                'D' => 'Opps !! Your ID Banned For 1 Hours . violation Rules D',
                'A' => 'Opps !! You Are Permanent Banned . violation Rules A',
            ];

            return response()->json([
                [
                    'message' => $msg[$banned->ban_type] ?? $msg['A'],
                    'code'    => '404'
                ]
            ], 200);
        }

        // 2. ACCESS TOKEN CHECK
        if (!AudioLiveStreamHelper::validateAccessToken($token)) {
            return response()->json([
                ['message' => 'Unauthorized access_token', 'code' => '401']
            ], 200);
        }

        // 3. REMOVE OLD CALL REQUESTS
        $remove_old = LiveCall::where('co_host_id', $co_host_id)
            ->where('channelName', '!=', $channelName)
            ->where('host_id', '!=', $host_id)
            ->first();

        if ($remove_old) {
            $remove_old->delete();
        }

        // 4. CHECK IF ALREADY REQUESTED THIS HOST
        $already = LiveCall::where('co_host_id', $co_host_id)
            ->where('channelName', $channelName)
            ->where('host_id', $host_id)
            ->first();

        if ($already) {
            return response()->json([
                ['message' => 'Call Already Sent', 'code' => '401']
            ], 200);
        }

        // 5. CHECK HOST IS LIVE OR NOT
        $live = UserLive::where('channelName', $channelName)
            ->where('user_id', $host_id)
            ->first();

        if (!$live) {
            return response()->json([
                ['message' => 'Live Off Already', 'code' => '401']
            ], 200);
        }

        // 6. WHEN LIVE UNLOCKED → PENDING REQUEST
        if ($live->locked == 0) {
            $seatTaken = LiveCall::where('channelName', $channelName)
                ->where('host_id', $host_id)
                ->where('set_no', $set_no)
                ->where('type', 1)
                ->first();

            if ($seatTaken) {
                return response()->json([
                    ['message' => 'Set Already Booked', 'code' => '401']
                ], 200);
            }

            $call              = new LiveCall();
            $call->co_host_id  = $co_host_id;
            $call->channelName = $channelName;
            $call->host_id     = $host_id;
            $call->set_no      = $set_no;
            $call->type        = $live->type;
            $call->status      = 'pending';
            $call->save();

            $list = DB::table('live_calls')
                ->join('users', 'users.id', 'live_calls.co_host_id')
                ->select('users.name', 'users.profile', 'live_calls.channelName', 'live_calls.set_no')
                ->where('live_calls.channelName', $channelName)
                ->get();

            AudioLiveStreamHelper::updateCallRequestCount($channelName, $this->database);

            return response()->json([
                [
                    'message' => 'Call Request Sent Successfully',
                    'data'    => $list,
                    'code'    => '200'
                ]
            ], 200);
        }

        // 8. HOST LOCKED → INSTANT ACCEPT
        $call                     = new LiveCall();
        $call->co_host_id         = $co_host_id;
        $call->channelName        = $channelName;
        $call->host_id            = $host_id;
        $call->set_no             = $set_no;
        $call->type               = $live->type;
        $call->mute               = 1;
        $call->status             = 'Accept';
        $call->is_co_host_active  = 'pending';
        $call->save();

        // room changed
        AudioLiveStreamHelper::clearRoomCache($channelName, $host_id);

        $state = AudioLiveStreamHelper::getRoomStateCached($channelName, $host_id);

        $payload = [
            'message'                => 'Audio Call Accept List Data Show Successfully come from Call Request UnlockBrd',
            'host_list'              => $state['host_list'],
            'set_remove'             => 11,
            'host_balance'           => $state['host_balance'],
            'star'                   => $state['star'],
            'star_complete_parcent'  => $state['star_complete_percent'],
            'channelName'            => $channelName,
            'code'                   => '200'
        ];

        if (method_exists($this, 'RealTime')) {
            $this->RealTime([$payload], 'audio_call_host_list', $channelName);
        }

        return response()->json([$payload], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function CallList(Request $request)
    {
         $access_token = $request->access_token;
         $host_id = $request->host_id;
         $channelName = $request->channelName;
        $response = array();
        if($access_token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            $data=LiveCall::where('host_id',$host_id)->where('channelName',$channelName)->where('status','pending')->get();

            $list=DB::table('live_calls')->join('users','users.id','live_calls.co_host_id')->select('users.name','users.profile','live_calls.channelName','live_calls.co_host_id','live_calls.status','live_calls.set_no')->where('live_calls.host_id',$host_id)->where('live_calls.channelName',$channelName)->where('live_calls.status','pending')->get();

            array_push($response,array('message'=>'Call Request Sand Successfully ','data'=>$list,'code'=>'200'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{
            array_push($response,array('message'=>'Unauthorized access_token','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
   /* -------------------------------------------------------------
     * LIVE START (STORE) – host starts audio live (clear & rebuild cache)
     * ------------------------------------------------------------- */
    public function Store(Request $request)
    {
        $token       = $request->access_token;
        $user_id     = $request->user_id;
        $channelName = $request->channelName;
        $brdToken    = $request->token;
        $image       = $request->image;
        $type        = $request->type;
        $notice      = $request->notice;
        $pin         = $request->pin;
        $siteNumber  = $request->siteNumber;

        if (!AudioLiveStreamHelper::validateAccessToken($token)) {
            return response()->json([
                ['message' => 'Unauthorized22', 'code' => '401']
            ], JSON_UNESCAPED_UNICODE);
        }

        LiveCall::where('co_host_id', $user_id)->delete();

        $user = User::find($user_id);
        if (!$user) {
            return response()->json([
                ['message' => 'User not found', 'code' => '404']
            ]);
        }

        $todayGifts = Gift::where('reciever_id', $user_id)
            ->whereDate('date', today())
            ->sum('value');

        $top_value = $user->top_value + $todayGifts;

        $live              = new UserLive();
        $live->user_id     = $user_id;
        $live->channelName = $channelName;
        $live->name        = $user->name;
        $live->top_value   = $top_value;
        $live->type        = $type;
        $live->token       = $brdToken;
        $live->siteNumber  = $siteNumber;
        $live->sdk         = 2;
        $live->date        = now();

        if ($image) $live->backgorund = $image;
        if ($request->audio_brd_design) $live->audio_brd_design = $request->audio_brd_design;
        if ($notice) $live->notice = $notice;
        if ($pin) $live->pin = $pin;

        $live->save();

        app(\App\Services\V4\HomeService::class)->forgetLiveCaches((int) $user_id);
        AudioLiveStreamHelper::clearRoomCache($channelName, $user_id);

        $state = AudioLiveStreamHelper::getRoomStateCached($channelName, $user_id);

        $payload = [
            'message'               => 'Host List come from brd start',
            'host_list'             => $state['host_list'],
            'set_remove'            => 11,
            'host_balance'          => $state['host_balance'],
            'star'                  => $state['star'],
            'star_complete_parcent' => $state['star_complete_percent'],
            'channelName'           => $channelName,
            'code'                  => '200'
        ];

        $this->RealTime([$payload], 'audio_call_host_list', $channelName);

        return response()->json([$payload], 200, [], JSON_UNESCAPED_UNICODE);
    }

   /* -------------------------------------------------------------
     * CALL MUTE (cohost mute/unmute)
     * ------------------------------------------------------------- */
    public function CallMute(Request $request)
    {
        $token       = $request->access_token;
        $co_host_id  = $request->co_host_id;
        $host_id     = $request->host_id;
        $channelName = $request->channelName;
        $mute_status = $request->mute_satus;

        if (!AudioLiveStreamHelper::validateAccessToken($token)) {
            return response()->json([
                ['message' => 'Unauthorized access_token', 'code' => '401']
            ]);
        }

        $call = LiveCall::where('channelName', $channelName)
            ->where('co_host_id', $co_host_id)
            ->where('host_id', $host_id)
            ->where('status', 'Accept')
            ->first();

        if ($call) {
            $call->mute = $mute_status;
            $call->save();

            AudioLiveStreamHelper::clearRoomCache($channelName, $host_id);
        }

        $state = AudioLiveStreamHelper::getRoomStateCached($channelName, $host_id);

        $payload = [
            'message'                => 'Audio Call Accept List Data Show Successfully come from call mute',
            'host_list'              => $state['host_list'],
            'set_remove'             => 11,
            'host_balance'           => $state['host_balance'],
            'star'                   => $state['star'],
            'star_complete_parcent'  => $state['star_complete_percent'],
            'channelName'            => $channelName,
            'code'                   => '200'
        ];

        if (method_exists($this, 'RealTime')) {
            $this->RealTime([$payload], 'audio_call_host_list', $channelName);
        }

        return response()->json([$payload], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /* -------------------------------------------------------------
     * CALL REMOVED (remove cohost from seat)
     * ------------------------------------------------------------- */
    public function CallRemoved(Request $request)
    {
        $token       = $request->access_token;
        $host_id     = $request->host_id;
        $co_host_id  = $request->co_host_id;
        $channelName = $request->channelName;
        $set_no      = $request->set_no;

        if (!AudioLiveStreamHelper::validateAccessToken($token)) {
            return response()->json([
                ['message' => 'Unauthorized access_token', 'code' => '401']
            ]);
        }

        if ($channelName) {
            $call = LiveCall::where('host_id', $host_id)
                ->where('channelName', $channelName)
                ->where('co_host_id', $co_host_id)
                ->where('status', 'Accept')
                ->first();
        } else {
            $call = LiveCall::where('host_id', $host_id)
                ->where('co_host_id', $co_host_id)
                ->where('status', 'Accept')
                ->first();
        }

        if ($call) {
            $call->delete();
            AudioLiveStreamHelper::clearRoomCache($channelName, $host_id);
        }

        $state = AudioLiveStreamHelper::getRoomStateCached($channelName, $host_id);

        $payload = [
            'message'                => 'Audio Call Accept List Data Show Successfully come from remove call',
            'host_list'              => $state['host_list'],
            'set_remove'             => $set_no,
            'host_balance'           => $state['host_balance'],
            'star'                   => $state['star'],
            'star_complete_parcent'  => $state['star_complete_percent'],
            'channelName'            => $channelName,
            'code'                   => '200'
        ];

        if (method_exists($this, 'RealTime')) {
            $this->RealTime([$payload], 'audio_call_host_list', $channelName);
        }

        return response()->json([$payload], 200, [], JSON_UNESCAPED_UNICODE);
    }


    public function HostCallRemove(Request $request)
    {
        $token       = $request->access_token;
        $host_id     = $request->host_id;
        $co_host_id  = $request->co_host_id;
        $channelName = $request->channelName;
        $set_no      = $request->set_no;
    
        // Validate Token
        if (!AudioLiveStreamHelper::validateAccessToken($token)) {
            return response()->json([
                ['message' => 'Unauthorized access_token', 'code' => '401']
            ], JSON_UNESCAPED_UNICODE);
        }
    
        // Prepare response payload
        $payload = [
            'message'     => 'Audio Call Removed By Host',
            'co_host_id'  => $co_host_id,
            'set_remove'  => $set_no,
            'host_id'     => $host_id,
            'channelName' => $channelName,
            'code'        => '200'
        ];
    
        // Broadcast realtime update
        $this->RealTime([$payload], 'audio_host_call_remove', $channelName);
    
        // Return API response
        return response()->json([$payload], JSON_UNESCAPED_UNICODE);
    }

    
    
    
     /* -------------------------------------------------------------
     * USER DATA (partial cache use)
     * ------------------------------------------------------------- */
    public function UserData(Request $request)
    {
        $token       = $request->access_token;
        $user_id     = $request->user_id;
        $host_id     = $request->host_id;
        $channelName = $request->channelName;

        $response = [];

        if (!AudioLiveStreamHelper::validateAccessToken($token)) {
            return response()->json([
                ['message' => 'Unauthorized', 'code' => '401']
            ], 200);
        }

        $payload = V4CacheService::boardUserData(
            'audio',
            $channelName,
            $user_id,
            $host_id,
            function () use ($user_id, $host_id, $channelName) {
                $user = User::find($user_id);
                if (!$user) {
                    return null;
                }

                $hostExtra = DB::table('host_data')
                    ->join('users', 'users.id', 'host_data.user_id')
                    ->join('agencies', 'agencies.code', 'host_data.agency_code')
                    ->where('users.is_host_id', 1)
                    ->where('users.id', $user_id)
                    ->select('host_data.hosting_type', 'agencies.name')
                    ->first();

                $host_type   = $hostExtra->hosting_type ?? 0;
                $agency_name = $hostExtra->name ?? 'bp';
                $balance = AudioLiveStreamHelper::calculateHostBalance($user_id);

                if ($user_id == $host_id) {
                    $follow_status = 0;
                } else {
                    $viewer = User::find($host_id);
                    if ($viewer) {
                        $isFollowing  = $user->following()->where('follower_id', $viewer->id)->exists();
                        $isFollowedBy = $user->followers()->where('user_id', $viewer->id)->exists();
                        $follow_status = ($isFollowing && $isFollowedBy) ? 2 : 1;
                    } else {
                        $follow_status = 0;
                    }
                }

                return [
                    'message'              => 'User Data Show Successfully',
                    'code'                 => '200',
                    'data'                 => $user,
                    'follow_status'        => $follow_status,
                    'balance'              => $balance,
                    'agency_name'          => $agency_name,
                    'host_type'            => $host_type,
                    'marchent'             => $user->is_agency,
                    'is_coin_protal_active'=> $user->is_coin_protal_active,
                    'is_vip'               => $user->is_vip,
                    'frame'                => $user->frame,
                    'entry_effect'         => $user->entry
                ];
            }
        );

        if (!$payload) {
            return response()->json([
                ['message' => 'User Not Found', 'code' => '404']
            ], 200);
        }

        $state = AudioLiveStreamHelper::getRoomStateCached($channelName, $host_id);

        $broadcastPayload = [
            'message'                => 'Audio Call Accept List Data Show Successfully From User Data',
            'host_list'              => $state['host_list'],
            'set_remove'             => 11,
            'host_balance'           => $state['host_balance'],
            'star'                   => $state['star'],
            'star_complete_parcent'  => $state['star_complete_percent'],
            'channelName'            => $channelName,
            'code'                   => '200'
        ];

        if (method_exists($this, 'RealTime')) {
            $this->RealTime([$broadcastPayload], 'audio_call_host_list', $channelName);
        }

        $response[] = $payload;

        return response()->json($response, 200, [], JSON_UNESCAPED_UNICODE);
    }

    /* -------------------------------------------------------------
     * HOST MUTE / UNMUTE
     * ------------------------------------------------------------- */
    public function HostMue(Request $request)
    {
        $token       = $request->access_token;
        $host_id     = $request->host_id;
        $mute_status = $request->mute_satus;
        $channelName = $request->channelName;

        if (!AudioLiveStreamHelper::validateAccessToken($token)) {
            return response()->json([
                ['message' => 'Unauthorized', 'code' => '401']
            ]);
        }

        $live = UserLive::where('channelName', $channelName)
            ->where('user_id', $host_id)
            ->first();

        if ($live) {
            $live->mute = $mute_status;
            $live->save();

            AudioLiveStreamHelper::clearRoomCache($channelName, $host_id);
        }

        $state = AudioLiveStreamHelper::getRoomStateCached($channelName, $host_id);

        $payload = [
            'message'                => 'Audio Call Accept List Data Show Successfully come from Host Mute Unmute',
            'host_list'              => $state['host_list'],
            'set_remove'             => 11,
            'host_balance'           => $state['host_balance'],
            'star'                   => $state['star'],
            'star_complete_parcent'  => $state['star_complete_percent'],
            'channelName'            => $channelName,
            'code'                   => '200'
        ];

        if (method_exists($this, 'RealTime')) {
            $this->RealTime([$payload], 'audio_call_host_list', $channelName);
        }

        return response()->json([$payload], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /* -------------------------------------------------------------
     * AUDIO GIFT PUSH (clear cache then rebuild)
     * ------------------------------------------------------------- */
    public function AudioGiftPush(Request $request)
    {
        $token       = $request->access_token;
        $user_id     = $request->user_id;
        $value       = $request->value;
        $gift_name   = $request->giftName;
        $channelName = $request->channelName;
        $music       = $request->music;
        $gift_type   = $request->gift_type;
        $host_id     = $request->host_id;

        if (!AudioLiveStreamHelper::validateAccessToken($token)) {
            return response()->json([['message' => 'Unauthorized', 'code' => 401]]);
        }

        $data = json_decode($request->getContent(), true);

        if (!isset($data['items']) || !is_array($data['items']) || count($data['items']) === 0) {
            return response()->json([['message' => 'Must Send at Least One Gift', 'code' => '401']]);
        }

        $sender = User::find($user_id);
        if (!$sender) {
            return response()->json([['message' => 'Sender Not Found', 'code' => '404']]);
        }
        $total_gift_value = $value * count($data['items']);
        if ($sender->balance < $total_gift_value) {
            return response()->json([['message' => 'Insufficient balance', 'code' => '401']]);
        }

        $sender->balance -= $total_gift_value;
        $sender->total_sent_gifts += $total_gift_value;
        $sender->level = AudioLiveStreamHelper::calculateSenderLevel($sender);
        $sender->save();

        $forcomment    = [];
        $global_txt    = [];
        $firstReceiver = null;

        foreach ($data['items'] as $row) {
            if (!isset($row['receiverId'])) continue;

            $receiverId = $row['receiverId'];

            $gift = Gift::create([
                'sander_id'   => $user_id,
                'reciever_id' => $receiverId,
                'name'        => $gift_name,
                'value'       => $value,
                'channelName' => $channelName,
                'date'        => Carbon\Carbon::now(),
            ]);

            $receiver = User::find($receiverId);
            if ($receiver) {
                $receiver->total_recived_gifts += $value;
                $receiver->save();

                $forcomment[] = $receiver->name;
            }

            $receiverLive = UserLive::where('user_id', $receiverId)->first();
            if ($receiverLive && $receiver) {
                $todayTotal = Gift::where('reciever_id', $receiverId)
                    ->whereDate('date', today())
                    ->sum('value');

                $receiverLive->top_value = $receiver->top_value + $todayTotal;
                $receiverLive->save();
            }

            if ($value > 19999 || $user_id == 555561) {
                $global_txt[] = [
                    'message' => "{$sender->name} sent {$value} to {$receiver->name}",
                    'image'   => $sender->profile,
                    'name'    => $sender->name
                ];

                $this->RealTime($global_txt, 'golbal_gift_banner', $channelName);
            }

            if (!$firstReceiver) {
                $firstReceiver = $receiverId;
            }
        }

        // SVGA gift push
        if ($firstReceiver) {
            $recBalance = Gift::where('reciever_id', $firstReceiver)
                ->where('channelName', $channelName)
                ->sum('value');

            $payload = [
                'channelName'      => $channelName,
                'name'             => $gift_name,
                'gift_time'        => '7',
                'host_balance'     => strval($recBalance),
                'music'            => strval($music),
                'audience_balance' => strval($sender->balance),
                'reciever_id'      => strval($firstReceiver),
                'status'           => 'active',
                'gift_type'        => strval($gift_type),
            ];

            $ref = $this->database
                ->getReference("svga_audiogifts/{$channelName}/linda/{$firstReceiver}");
            $ref->set($payload);
        }

        // Comments push
        $commentMessage = "{$sender->name} sent {$value} to " . implode(', ', $forcomment);

        $gift_comment = [
            'balance'        => strval($sender->balance),
            'channelName'    => strval($channelName),
            'id'             => $sender->id,
            'message'        => '@' . $commentMessage,
            'level'          => strval($sender->level),
            'name'           => strval($sender->name),
            'profile'        => strval($sender->profile),
            'is_vip'         => strval($sender->is_vip),
            'frame'          => strval($sender->frame),
            'is_official_id' => strval($sender->is_official_id),
            'is_agency'      => strval($sender->is_agency),
            'is_host_id'     => strval($sender->is_host_id),
            'comment_badge'  => strval($sender->comment_badge),
            'type'           => 'message',
        ];

        $comments = $this->database->getReference("Comments/{$channelName}")->getValue();
        $index    = is_array($comments) ? count($comments) : 0;

        $this->database
            ->getReference("Comments/{$channelName}/{$index}")
            ->set($gift_comment);

        // room changed: clear cache then rebuild host list
        V4CacheService::forgetRoom($channelName);
        V4CacheService::forgetRanking();
        AudioLiveStreamHelper::clearRoomCache($channelName, $host_id);
        $state = AudioLiveStreamHelper::getRoomStateCached($channelName, $host_id);

        $pushPayload = [
            'message'                => 'Audio Call Accept List Data Show Successfull come from call Accept',
            'host_list'              => $state['host_list'],
            'set_remove'             => 11,
            'host_balance'           => $state['host_balance'],
            'star'                   => $state['star'],
            'star_complete_parcent'  => $state['star_complete_percent'],
            'channelName'            => $channelName,
            'code'                   => '200'
        ];

        $this->RealTime([$pushPayload], 'audio_call_host_list', $channelName);

        return response()->json([
            [
                'message' => 'Gifts Sent Successfully',
                'user_id' => $sender->id,
                'balance' => $sender->balance,
                'code'    => '200'
            ]
        ], JSON_UNESCAPED_UNICODE);
    }

    public function LockUnlock(Request $request)
    {
    $token       = $request->access_token;
    $channelName = $request->channelName;
    $host_id     = $request->host_id;

    // Validate token
    if (!AudioLiveStreamHelper::validateAccessToken($token)) {
        return response()->json([
            ['message' => 'Unauthorized', 'code' => '401']
        ], JSON_UNESCAPED_UNICODE);
    }

    // Load live session
    $live = UserLive::where('channelName', $channelName)
        ->where('user_id', $host_id)
        ->first();

    if (!$live) {
        return response()->json([
            ['message' => 'Live Removed Already', 'code' => '401']
        ], JSON_UNESCAPED_UNICODE);
    }

    // Toggle lock status
    $live->locked = $live->locked == 1 ? 0 : 1;
    $live->save();

    // Response message
    $message = $live->locked == 1 
        ? 'Audio Brd lock Successfully' 
        : 'Audio Brd Unlock Successfully';

    return response()->json([
        ['message' => $message, 'code' => '200']
    ], JSON_UNESCAPED_UNICODE);
}

            
  /* -------------------------------------------------------------
     * COHOST ACTIVE / INACTIVE
     * ------------------------------------------------------------- */
    public function CohostisActive(Request $request)
    {
        $token             = $request->access_token;
        $co_host_id        = $request->co_host_id;
        $host_id           = $request->host_id;
        $channelName       = $request->channelName;
        $is_co_host_active = $request->is_co_host_active;

        if (!AudioLiveStreamHelper::validateAccessToken($token)) {
            return response()->json([
                ['message' => 'Unauthorized access_token', 'code' => '401']
            ], 200);
        }

        $call = LiveCall::where('channelName', $channelName)
            ->where('co_host_id', $co_host_id)
            ->where('host_id', $host_id)
            ->where('status', 'Accept')
            ->first();

        if ($call) {
            $call->is_co_host_active = $is_co_host_active;
            $call->save();

            AudioLiveStreamHelper::clearRoomCache($channelName, $host_id);
        }

        $state = AudioLiveStreamHelper::getRoomStateCached($channelName, $host_id);

        $payload = [
            'message'                => 'Audio Call Accept List Data Show Successfully come from cohost active toggle',
            'host_list'              => $state['host_list'],
            'set_remove'             => 11,
            'host_balance'           => $state['host_balance'],
            'star'                   => $state['star'],
            'star_complete_parcent'  => $state['star_complete_percent'],
            'channelName'            => $channelName,
            'code'                   => '200'
        ];

        $this->RealTime([$payload], 'audio_call_host_list', $channelName);

        return response()->json([$payload], 200, [], JSON_UNESCAPED_UNICODE);
    }
public function SandEmoji(Request $request)
{
    $token       = $request->access_token;
    $co_host_id  = $request->co_host_id;
    $host_id     = $request->host_id;
    $channelName = $request->channelName;
    $emoji       = $request->emoji;

    if (!AudioLiveStreamHelper::validateAccessToken($token)) {
        return response()->json([
            ['message' => 'Unauthorized access_token', 'code' => '401']
        ], 200);
    }
    AudioLiveStreamHelper::clearRoomCache($channelName, $host_id);
    // Generate base host list
    $hostListData = AudioLiveStreamHelper::getRoomStateCached($channelName, $host_id);

    // Apply emoji: only sender seat gets emoji
    foreach ($hostListData['host_list'] as &$seat) {
        if ($seat['co_host_id'] == strval($co_host_id)) {
            $seat['emoji'] = strval($emoji);
        } else {
            $seat['emoji'] = "0";
        }
    }

    // Host balance + star data
    $hostBalance  = AudioLiveStreamHelper::calculateHostBalance($host_id);
    $starData     = AudioLiveStreamHelper::calculateStarLevel($host_id);

    // Response payload
    $payload = [
        'message'                => 'Audio Call Accept List Data Show Successfully come from emoji send',
        'host_list'              => $hostListData['host_list'],
        'set_remove'             => 11,
        'host_balance'           => $hostBalance,
        'star'                   => $starData['star'],
        'star_complete_parcent'  => $starData['star_complete_percent'],
        'channelName'            => $channelName,
        'code'                   => '200'
    ];

    // RealTime Websocket Broadcast
    $this->RealTime([$payload], 'audio_call_host_list', $channelName);

    return response()->json([$payload], 200, [], JSON_UNESCAPED_UNICODE);
}

public function send_push_notification($host_data, $channelName, $brd_type)
{
    $followerQuery = Follower::where('follower_id', $host_data->id);

    // Process followers in chunks (prevents memory explosion)
    $followerQuery->chunk(500, function ($chunk) use ($host_data, $channelName, $brd_type) {

        // Get all device IDs in ONE query instead of inside loop
        $device_ids = User::whereIn('id', $chunk->pluck('user_id'))
            ->whereNotNull('device_id')
            ->pluck('device_id')
            ->toArray();

        if (empty($device_ids)) {
            return;
        }

        // FCM URL
        $url = "https://fcm.googleapis.com/fcm/send";

        // Your FCM Server Key
        $serverKey = 'AAAAFqwSmh4:APA91bHpHEO9D0TsDbZDuRq3SiHiyFeUjZIngmv8e2xvwK7NersEky4RlBKo25_gsg-Re_FBHUR6Q8nvqf8NzR5nj7gjWIePETKRFn4VZOXm6poVoOBZ8_SFoOO15TyxdzofcwE1NZ4i';

        // Notification payload (reused for all)
        $notificationData = [
            'data' => [
                'link'    => "https://bplive.site/new_live/share/v2/{$host_data->id}/{$channelName}/{$brd_type}",
                'profile' => "https://bplive.site/{$host_data->profile}",
            ],
            'notification' => [
                'body'         => "I am waiting for you , Please Join & Make More Friends",
                'title'        => $host_data->name,
                'click_action' => 'deviceNoti',
            ]
        ];

        $headers = [
            'Content-Type: application/json',
            'Authorization: key=' . $serverKey,
        ];

        // Reuse CURL handle (faster)
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        foreach ($device_ids as $device_id) {

            $notificationData['to'] = $device_id;

            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notificationData));

            $response = curl_exec($ch);

            if ($response === false) {
                // Optional: log error
                \Log::error("FCM Error: " . curl_error($ch));
            }
        }

        curl_close($ch);
    });
}




       private function RealTime($response, $roomName, $channelName)
{
    return app(\App\Services\V4\RealtimePusherService::class)
        ->trigger($response, $roomName, $channelName);
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
                    'app_id'    => $nextPusher->pusher_app_id, 
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

  
    
}
