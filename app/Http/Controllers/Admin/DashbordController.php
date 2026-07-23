<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GameBalanceWithdraw;
use App\Models\Game\Fivestar\FivestarSetting;
use App\Models\Game\Grady\GradySetting;
use App\Models\Gift;
use App\Models\PortalRecharge;
use App\Models\PortalTransfer;
use App\Models\Battle\Fortune\FortuneSetting;
use App\Models\Setting;
use App\Models\Agency;
use App\Models\Comment;
use App\Models\Withdraw;
use App\Models\WithdrawConvartAgency;
use App\Models\PortalRecall;
use App\Models\LuckyGiftSetting;
use App\Models\EntryFrameProfit;
use App\Models\Battle\TeenPattiSetting;
use App\Models\Chat;
use Kreait\Firebase\Contract\Database;
use App\Models\BanDevice;
use App\Models\AdminParmisiton;
use Auth;
use Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use App\Models\UserLive;
use App\Models\Kick;
use Pusher;
class DashbordController extends Controller
{
     public function __construct(Database $database)
    {
        $this->database = $database;
    }
    public function index()
    {
       $coin_generate= PortalRecharge::sum('amount');
	$data['users_balance']=User::sum('balance');
	$data['today_user']=User::whereDate('created_at',date('Y-m-d'))->count();
    $data['total_gift']=Gift::sum('value');
    $data['today_sanding']=Gift::whereDate('created_at',date('Y-m-d'))->sum('value');
    $data['today_reciving']=Gift::whereDate('created_at',date('Y-m-d'))->sum('value');
    $data['total_portal_recharge']=PortalRecharge::sum('amount');
    $data['total_withdraw_generate']=PortalRecharge::where('is_withdraw',1)->sum('amount');
    $data['total_recall']=PortalRecharge::where('is_recall',1)->sum('amount'); 
     $data['total_portal_transfer']=PortalTransfer::sum('amount');
     $data['today_portal_transfer']=PortalTransfer::whereDate('created_at',date('Y-m-d'))->sum('amount');
     $data['today_withdraw']=Withdraw::whereDate('created_at',date('Y-m-d'))->sum('total');
       $data['total_portal_recall']=PortalRecall::sum('amount');
      $data['total_agency']=Agency::count();
      $data['active_host']=User::where('is_host_id',1)->count();
      $data['total_users']=User::count();
      $data['fruts_game_balance']=FortuneSetting::find(1);
      $data['setting']=Setting::find(1);
      $data['five_game_balance']=FivestarSetting::find(1);
      $data['greedy_game_balance']=GradySetting::find(1);
      $data['teenpatti_game_balance']=TeenPattiSetting::find(1);
      $data['lucky_gift']=LuckyGiftSetting::find(1);
      $data['game_balance_withdraw']=GameBalanceWithdraw::where('type','withdraw')->sum('amount');
      $data['game_balance_deposit']=GameBalanceWithdraw::where('type','deposit')->sum('amount');
      $data['game_pro_balance']=$this->gameProBalanceSummary();
      $coinGenerateTotal = Schema::hasTable('coin_generates') ? (int) DB::table('coin_generates')->sum('amount') : 0;
      $coinRechargeTotal = (int) PortalRecharge::where('is_recall', 0)->sum('amount');
      $data['available_coin_balance'] = $coinGenerateTotal - $coinRechargeTotal;
      $data['realtime_comment_count'] = Comment::where('created_at', '>=', now()->subHour())->count();
      $data['realtime_chat_count'] = Schema::hasTable('chats') ? Chat::where('created_at', '>=', now()->subHour())->count() : 0;
      $data['EntryFrameProfit']=EntryFrameProfit::sum('amount');
       $data['approved_balance']=Withdraw::where('status',1)->sum('agency_profit');
        		$data['agency_convart_balance']=WithdrawConvartAgency::sum('amount');
    	return view('backend.home')->with($data);
    }

    /**
     * Global kill-switch for the whole app. Restricted to this one admin id
     * (same super-admin bypass id used elsewhere in this codebase, e.g.
     * JamboAiTaskController::ALLOWED_ADMIN_ID) - nobody else can flip it, and
     * the button that calls this route is itself hidden from every other
     * admin in the dashboard view.
     *
     * When ON: every Flutter app API request is blocked with a 503
     * (CheckAppMaintenanceMode middleware, registered globally on the 'api'
     * middleware group) and admin-panel login is blocked for everyone except
     * this same admin id (LoginController::login).
     */
    public function ToggleMaintenanceMode(Request $request)
    {
        if ((int) Auth::id() !== 11133) {
            abort(403);
        }

        $setting = Setting::find(1);
        if (!$setting) {
            return redirect()->route('admin.dashboard')->with('error', 'Settings row not found.');
        }

        $newState = !$setting->maintenance_mode;
        $setting->maintenance_mode = $newState;
        $setting->maintenance_mode_by = Auth::id();
        $setting->maintenance_mode_at = now();
        $setting->save();

        Cache::forget('app_maintenance_mode');

        Log::warning('Global app maintenance mode toggled', [
            'admin_id' => Auth::id(),
            'new_state' => $newState ? 'ON' : 'OFF',
            'ip' => $request->ip(),
        ]);

        return redirect()->route('admin.dashboard')->with(
            'success',
            $newState
                ? 'Maintenance mode ENABLED - all app routes are blocked and only this admin can log in.'
                : 'Maintenance mode DISABLED - app routes and admin login are back to normal.'
        );
    }

  public function GameProBalanceUpdate(Request $request)
  {
      if (!AdminParmisiton::allowed(Auth::id(), 'dashboard_game_pro_balance_manage')) {
          abort(403, 'Game Pro balance permission required.');
      }

      $request->validate([
          'type' => 'required|in:deposit,withdraw',
          'amount' => 'required|integer|min:1|max:999999999999',
      ]);

      if (!$this->gameProLedgerReady()) {
          return Redirect()->back()->with([
              'messege' => 'Game Pro ledger table is not ready',
              'alert-type' => 'error',
          ]);
      }

      $type = $request->input('type');
      $amount = (int) $request->input('amount');
      $gameName = 'thomas_pro_game';

      try {
          DB::transaction(function () use ($type, $amount, $gameName) {
              $depositRow = $this->lockedGameProLedgerRow($gameName, 'deposit');
              $withdrawRow = $this->lockedGameProLedgerRow($gameName, 'withdraw');

              $balance = max(((float) $depositRow->amount) - ((float) $withdrawRow->amount), 0);
              if ($type === 'withdraw' && $amount > $balance) {
                  throw ValidationException::withMessages([
                      'amount' => 'Withdraw amount cannot exceed current Game Pro Balance.',
                  ]);
              }

              $targetRow = $type === 'deposit' ? $depositRow : $withdrawRow;
              $targetRow->amount = ((int) $targetRow->amount) + $amount;
              $targetRow->date = date('Y-m-d');
              $targetRow->save();
          });
      } catch (ValidationException $exception) {
          throw $exception;
      }

      return Redirect()->back()->with([
          'messege' => 'Game Pro '.ucfirst($type).' saved successfully',
          'alert-type' => 'success',
      ]);
  }

  private function gameProBalanceSummary()
  {
      $empty = [
          'game_name' => 'thomas_pro_game',
          'deposit_total' => 0,
          'withdraw_total' => 0,
          'balance' => 0,
          'available' => false,
      ];

      if (!$this->gameProLedgerReady()) {
          return $empty;
      }

      $gameName = 'thomas_pro_game';
      $deposit = (int) GameBalanceWithdraw::where('game_name', $gameName)->where('type', 'deposit')->sum('amount');
      $withdraw = (int) GameBalanceWithdraw::where('game_name', $gameName)->where('type', 'withdraw')->sum('amount');

      return [
          'game_name' => $gameName,
          'deposit_total' => $deposit,
          'withdraw_total' => $withdraw,
          'balance' => max($deposit - $withdraw, 0),
          'available' => true,
      ];
  }

  private function gameProLedgerReady(): bool
  {
      return Schema::hasTable('game_balance_withdraws')
          && Schema::hasColumn('game_balance_withdraws', 'game_name')
          && Schema::hasColumn('game_balance_withdraws', 'type')
          && Schema::hasColumn('game_balance_withdraws', 'amount');
  }

  private function lockedGameProLedgerRow(string $gameName, string $type)
  {
      $row = GameBalanceWithdraw::where('game_name', $gameName)
          ->where('type', $type)
          ->lockForUpdate()
          ->first();

      if ($row) {
          return $row;
      }

      $row = new GameBalanceWithdraw();
      $row->game_name = $gameName;
      $row->type = $type;
      $row->amount = 0;
      $row->date = date('Y-m-d');
      $row->save();

      return $row;
  }

  public function Version()
  {
  	$data=Setting::find(1);
    $data->flutter_version=86;
    $data->save();
    $notification=array(
                'messege'=>'App Version Update SuccessFully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
  }
  public function PusherOne()
  {
  	$data=Setting::find(1);
    $data->key='ef453cf439ba5f0f032c';
    $data->app_id='1833499';
    $data->secret='547aca35a9cfdea6492e';
    $data->save();
    $notification=array(
                'messege'=>'App Pusher Update SuccessFully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
  }public function Pushertwo()
  {
  	$data=Setting::find(1);
    // $data->key='68cbd39d4c134430f221';
    // $data->app_id='1876528';
    // $data->secret='804bf082019b137d3a45'; 
    
    $data->key='9ce9d96701d6600b426e';
    $data->app_id='1618585';
    $data->secret='71aedfa829b4eb09c453';
    $data->save();
    $notification=array(
                'messege'=>'App Pusher Update SuccessFully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
  }
   public function FortuneIDBlock(Request $request)
  {
  	$data = FortuneSetting::find(1);

    $data->block_id = $request->block_id;
    $data->winner_id = $request->winner_id;
    $data->lock_parcent = $request->lock_parcent;
    
    // Logic to determine presser_lock value
    if ($request->block_id == 0 && $request->winner_id == 0) {
        $data->presser_lock = 0;
    } else {
        $data->presser_lock = 1;
    }
    
    $data->save();

    $notification=array(
                'messege'=>'ID Block  SuccessFully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
  }
  public function VIPoffer(Request $request)
  {
  	$data=Setting::find(1);

    
    if($data->vip_discount==0){
    $data->vip_discount=1;
    }else{
      $data->vip_discount=0;
    }
    $data->save();
    $notification=array(
                'messege'=>'Vip Operation SuccessFully Done',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
  }
  public function CommentUpdate()
  {
      $comments=Comment::query()
          ->leftJoin('users as senders', 'senders.id', '=', 'comments.user_id')
          ->leftJoin('users as hosts', 'hosts.id', '=', 'comments.reciever_id')
          ->whereNotIn('comments.message', ['Has Joined', 'Has Leaved'])
          ->orderBy('comments.id', 'desc')
          ->limit(30)
          ->get([
              'comments.id',
              'comments.user_id',
              'comments.reciever_id',
              'comments.channelName',
              'comments.message',
              'comments.type',
              'comments.created_at',
              'senders.name as sender_name',
              'senders.profile as sender_profile',
              'hosts.name as host_name',
          ]);
      return view('backend.comment',compact('comments'));
  }
  public function chat()
  {
      $chat_data_all = Chat::query()
          ->leftJoin('users as senders', 'senders.id', '=', 'chats.sander_id')
          ->leftJoin('users as receivers', 'receivers.id', '=', 'chats.receiver_id')
          ->orderBy('chats.id', 'desc')
          ->limit(30)
          ->get([
              'chats.id',
              'chats.sander_id',
              'chats.receiver_id',
              'chats.text',
              'chats.created_at',
              'senders.name as sender_name',
              'receivers.name as receiver_name',
          ]);

      return view('backend.chat',compact('chat_data_all'));
       
  }
  public function EmargencyIDBanned($id,$host){
      $user=User::find($id);
      $device=new BanDevice;
      $device->device_id=$user->device_id;
      $device->save(); 
      $user->is_invisible=0;
      $user->status=0;
      $user->ban_type="A";
      $user->ban_by=Auth::id();
      $user->save();
      $check_live=UserLive::where('user_id',$host)->first();
      if($check_live){
          $response = array();
            $kick=new Kick;
            $kick->user_id=$id;
            $kick->channelName=$check_live->channelName;
            $kick->host_id=$host;
            $kick->save();
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
                array_push($response,array('message'=>'Kick Successfully ','channelName'=>$check_live->channelName,'user_id'=>$id,'code'=>'200'));
                  $pusher->trigger('audio_kick', $check_live->channelName, $response);
      }
      $notification=array(
                'messege'=>'ID Banned SuccessFully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
      
  }
}
