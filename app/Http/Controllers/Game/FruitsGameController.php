<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Game\GameFruitsActiveUser;
use App\Models\Game\Fruits\FruitsLastWinningPot;
use App\Models\Game\Fruits\FruitsTransaction;
use App\Models\Game\Fruits\FruitsCoinServe;
use Kreait\Firebase\Contract\Database;
use Pusher;
use DB;
use Auth;
use Hash;
use App\Models\PortalTransfer;
use App\Models\FortuneLock;
use App\Models\Gift;
use Illuminate\Support\Facades\Cache;
class FruitsGameController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
    }
    public function Game(Request $request)
    {
        //Cache::flush();
        $email=$request->user;
        $pass=$request->token;
        $authtoken=$email;
        $authkey= $pass;
        if (Auth::check()) {
            // code...
            Auth::logout();
        }

        $user = User::where('email', $email)->first(); 

        if(!$user) {
            return false;
        }
        if ($pass==$user->password) {
            Auth::login($user);
            session(['user' => $user]);
        }
         $id = Auth::id();
        $login_user = User::find($id);

if ($login_user) {
            
            $check_recharge = PortalTransfer::where('user_id', $id)->sum('amount');
            $check_balance = $login_user->balance; // Assuming balance is a field in User model
            $check_gift = Gift::where('sander_id', $id)->sum('value');
            $total_value = $check_balance + $check_gift;
            if($check_recharge<2000000){
            $rendom=4;
            }elseif($check_recharge>5000000){
            $rendom=2;
            }else{
               $rendom=3; 
            }
            $user_profit = $check_recharge * $rendom;

            if ($user_profit < $total_value) {
                $is_another_id_lock = FortuneLock::where('imei_number', $login_user->imei_number)->first();
                 $check_id_have_already=FortuneLock::where('user_id',$login_user->id)->where('type',0)->first();
                if(!$check_id_have_already){
                $data = new FortuneLock();
                $data->user_id = $login_user->id;
                $data->type = 0;
                $data->imei_number = $login_user->imei_number;
                $data->auto_lock_active = 'Auto Lock Bcz Value Geter Then X 3';
                $data->parcentage = $is_another_id_lock ? $is_another_id_lock->parcentage : 15;
                $data->save();
            }else{
                $check_id_have_already=FortuneLock::where('user_id',$login_user->id)->where('auto_lock_active','!=',null)->first();
                if($check_id_have_already){
                    $check_id_have_already->delete();
                }
            }
            }else{
                $check_id_have_already=FortuneLock::where('user_id',$login_user->id)->where('auto_lock_active','!=',null)->first();
                if($check_id_have_already){
                    $check_id_have_already->delete();
                }
            }
        }
     
        return view('game.index',compact('authtoken','authkey'));
     
       // return view('game.index');
    }
   
   
   
    public function Index(Request $request)
    {
      $key = 'linda';
        $post_data=[
            'fname'=>'name',
        ];
      $ref = $this->database->getReference('my_data/' . $key)->getChild('Jahir');
//$ref->set($post_data);
        //$postRef=$this->database->getReference('audience_counterrs')->getChild('Jahir')->push($post_data);
      //return $request->all();
      $email=$request->user;
    
      $pass=$request->token;
      $authtoken=$email;
        $authkey= $pass;
        
        if (Auth::check()) {
            // code...
            Auth::logout();
        }

        $user = User::where('email', $email)->first(); 

        if(!$user) {
            return false;
        }
        if($pass==$user->password) {
            Auth::login($user);
            $active = new GameFruitsActiveUser;
            $active->user_id = $user->id;
            $active->name = $user->name;
            $active->profile_image = $user->profile;
            //$active->save();
        }

        return view('game.new_game.index',compact('authtoken','authkey'));
    }
    public function pushercronjob()
    {
        
      $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher\Pusher(
            '3bbc9641cfa31bef1c81',
            '1230806ad0ca71375539',
            '1572867',
            $options
        );
        $random = floor(rand(50000, 10500)/10*200);
        $zoneSize = 60; 
       $winner= ceil(($random + 180) / $zoneSize) % 6 ?: 6;
       if ($winner==4) {
          $winner=1;
       }if ($winner==5) {
          $winner=2;
       }if ($winner==6) {
          $winner=3;
       }
        $next_winer=new FruitsLastWinningPot;
        $next_winer->pots=$winner;
        $next_winer->showing=0;
        $next_winer->save();
        FruitsCoinServe::truncate();
        
        $activeuser = GameFruitsActiveUser::join('users', 'game_fruits_active_users.user_id', '=', 'users.id')
        ->select('users.name', 'users.profile', 'users.balance','users.id')
        ->distinct('users.id')
        ->orderByDesc('balance')
        ->take(4)
        ->get();        
       

        $pusher->trigger('CHANNEL_NAME', 'my-event', ['number' => $random,'winner' => $winner,'activeuser'=>$activeuser]); 
    }
    public function winnning(Request $request)
    {
        if(Auth::id()==1){
        $last_winer=FruitsLastWinningPot::where('showing',0)->orderby('id','desc')->first();

        $serve_coins=FruitsCoinServe::where('pots',$last_winer->pots)->select(DB::raw('user_id,pots, sum(coin) as amount'))->groupBy('user_id')->groupBy('pots')->orderBy('amount', 'desc')->get();
        foreach ($serve_coins as $key => $serve_coin) {
            $user=User::find($serve_coin->user_id);
            if($user){
                $cal=$serve_coin->amount*3;
                $user->balance+=$cal;
                $user->save();
            }
        }
        $last_winer->showing=1;
        $last_winer->save();
        FruitsCoinServe::truncate();
        GameFruitsActiveUser::truncate();
         
        
        return response()->json(['success' => 'Coin Serve Done']);
    }else{
        return response()->json(['success' => 'User Done']);
    }
       

    
    }
    public function userdata(Request $request)
    {
        $user=User::find(Auth::id());
        //GameFruitsActiveUser::truncate();
        $findactive = GameFruitsActiveUser::where('user_id', $user->id)->exists();
        if(!$findactive){
            $active = new GameFruitsActiveUser;
            $active->user_id = $user->id;
            $active->name = $user->name;
            $active->profile_image = $user->profile;
            $active->save();
        }
        
        return response()->json(['success' => 'User Data Sand','user_balance' => $user->balance]);
    }
    public function HitPots(Request $request)
    {
        $user=User::find(Auth::id());
        $data=new FruitsCoinServe;
        $data->user_id=$user->id;
        $data->pots=$request->pots;
        $data->coin=$request->amount;
        $data->save();
        $user->balance-=$data->coin;
        $user->save();
        $coin_server=$data->where('pots',$request->pots)->where('user_id',Auth::id())->sum('coin');
        $pots_one=$data->where('pots',1)->sum('coin');
        $pots_two=$data->where('pots',2)->sum('coin');
        $pots_three=$data->where('pots',3)->sum('coin');
      
      	

        return response()->json(['success' => 'User Data Sand','user_balance' => $user->balance,'coin_server' => $coin_server,'pots_one' => $pots_one,'pots_two' => $pots_two,'pots_three' => $pots_three]);

    }
    public function ActiveUser()
    {

        $data=GameFruitsActiveUser::all();
        return view('game.fruits.active_user',compact('data'));
        
    }public function LastRank()
    {

         $data=FruitsLastWinningPot::orderby('id','desc')->where('showing',1)->limit(8)->get();

        return view('game.fruits.last_result',compact('data'));
        
    }
  public function OK()
  {
  return $data=0;
  }
}
