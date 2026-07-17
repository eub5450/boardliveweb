<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use App\Models\PortalRecharge;
use Auth;
use App\Models\PortalRecall;
use App\Models\MasterProtalRecall;
use App\Models\CoinGenerate;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
class ProtalController extends Controller
{
    private function portalSettingRow(): Setting
    {
        return Setting::firstOrCreate(['id' => 1]);
    }

    private function portalSettingValue(Setting $setting, string $key, int $default): int
    {
        $value = (int) data_get($setting, $key, $default);

        return $value > 0 ? $value : $default;
    }

    private function portalSettingNonNegativeValue(Setting $setting, string $key, int $default): int
    {
        $value = data_get($setting, $key, $default);

        if (!is_numeric($value)) {
            return $default;
        }

        $value = (int) $value;

        return $value >= 0 ? $value : $default;
    }

    private function portalSettingStringValue(Setting $setting, string $key, string $default): string
    {
        $value = trim((string) data_get($setting, $key, $default));

        return $value !== '' ? $value : $default;
    }

    private function portalSettingBoolValue(Setting $setting, string $key, bool $default): int
    {
        return (int) ((int) data_get($setting, $key, $default ? 1 : 0) === 1);
    }

    private function normalizeTimeValue(?string $value, string $default): string
    {
        $value = trim((string) $value);

        if (preg_match('/^\d{2}:\d{2}$/', $value)) {
            return $value . ':00';
        }

        if (preg_match('/^\d{2}:\d{2}:\d{2}$/', $value)) {
            return $value;
        }

        return $default;
    }

    public function Create()
    {
        $users=User::where('status',1)->where('is_coin_protal_active',0)->get();
        return view('backend.protal.create',compact('users'));
    }

    public function PortalSetting()
    {
        $setting = $this->portalSettingRow();
        $portalMinTransferAmount = $this->portalSettingValue($setting, 'portal_min_transfer_amount', 50000);
        $portalToPortalMinAmount = $this->portalSettingValue($setting, 'portal_to_portal_min_amount', 500000);
        $portalToPortalMaxAmount = $this->portalSettingValue($setting, 'portal_to_portal_max_amount', 10000000);
        $portalToPortalStepAmount = $this->portalSettingValue($setting, 'portal_to_portal_step_amount', 100000);
        $videoRewardV4Enabled = $this->portalSettingBoolValue($setting, 'video_reward_v4_enabled', true);
        $videoRewardV4ThresholdMinutes = $this->portalSettingValue($setting, 'video_reward_v4_threshold_minutes', 60);
        $videoRewardV4Amount = $this->portalSettingValue($setting, 'video_reward_v4_amount', 4000);
        $videoRewardV4SenderId = $this->portalSettingValue($setting, 'video_reward_v4_sender_id', 11162);
        $videoRewardV4GiftName = $this->portalSettingStringValue($setting, 'video_reward_v4_gift_name', 'reward.svga');
        $videoRewardLegacyEnabled = $this->portalSettingBoolValue($setting, 'video_reward_legacy_enabled', true);
        $videoRewardLegacyThresholdMinutes = $this->portalSettingValue($setting, 'video_reward_legacy_threshold_minutes', 50);
        $videoRewardLegacyAmount = $this->portalSettingValue($setting, 'video_reward_legacy_amount', 5000);
        $videoRewardLegacySenderId = $this->portalSettingValue($setting, 'video_reward_legacy_sender_id', 11162);
        $videoRewardLegacyGiftName = $this->portalSettingStringValue($setting, 'video_reward_legacy_gift_name', 'reward.svga');
        $videoRewardLegacyBlockEnabled = $this->portalSettingBoolValue($setting, 'video_reward_legacy_block_enabled', true);
        $videoRewardLegacyBlockStart = $this->portalSettingStringValue($setting, 'video_reward_legacy_block_start', '05:00:00');
        $videoRewardLegacyBlockEnd = $this->portalSettingStringValue($setting, 'video_reward_legacy_block_end', '11:00:00');
        $recallPortalPercentage = $this->portalSettingNonNegativeValue($setting, 'recall_portal_percentage', 70);
        $recallCompanyPercentage = $this->portalSettingNonNegativeValue($setting, 'recall_company_percentage', 30);
        $recallCompanyUserId = $this->portalSettingValue($setting, 'recall_company_user_id', 11111);

        if ($portalToPortalMaxAmount < $portalToPortalMinAmount) {
            $portalToPortalMaxAmount = $portalToPortalMinAmount;
        }

        return view('backend.protal.system_setting', compact(
            'setting',
            'portalMinTransferAmount',
            'portalToPortalMinAmount',
            'portalToPortalMaxAmount',
            'portalToPortalStepAmount',
            'videoRewardV4Enabled',
            'videoRewardV4ThresholdMinutes',
            'videoRewardV4Amount',
            'videoRewardV4SenderId',
            'videoRewardV4GiftName',
            'videoRewardLegacyEnabled',
            'videoRewardLegacyThresholdMinutes',
            'videoRewardLegacyAmount',
            'videoRewardLegacySenderId',
            'videoRewardLegacyGiftName',
            'videoRewardLegacyBlockEnabled',
            'videoRewardLegacyBlockStart',
            'videoRewardLegacyBlockEnd',
            'recallPortalPercentage',
            'recallCompanyPercentage',
            'recallCompanyUserId'
        ));
    }

    public function PortalSettingUpdate(Request $request)
    {
        $request->validate([
            'portal_min_transfer_amount' => 'required|integer|min:1',
            'portal_to_portal_min_amount' => 'required|integer|min:1',
            'portal_to_portal_max_amount' => 'required|integer|gte:portal_to_portal_min_amount',
            'portal_to_portal_step_amount' => 'required|integer|min:1',
            'video_reward_v4_enabled' => 'nullable|boolean',
            'video_reward_v4_threshold_minutes' => 'required|integer|min:1|max:1440',
            'video_reward_v4_amount' => 'required|integer|min:1',
            'video_reward_v4_sender_id' => 'required|integer|min:1',
            'video_reward_v4_gift_name' => 'required|string|max:255',
            'video_reward_legacy_enabled' => 'nullable|boolean',
            'video_reward_legacy_threshold_minutes' => 'required|integer|min:1|max:1440',
            'video_reward_legacy_amount' => 'required|integer|min:1',
            'video_reward_legacy_sender_id' => 'required|integer|min:1',
            'video_reward_legacy_gift_name' => 'required|string|max:255',
            'video_reward_legacy_block_enabled' => 'nullable|boolean',
            'video_reward_legacy_block_start' => ['required', 'regex:/^\d{2}:\d{2}(:\d{2})?$/'],
            'video_reward_legacy_block_end' => ['required', 'regex:/^\d{2}:\d{2}(:\d{2})?$/'],
            'recall_portal_percentage' => 'required|integer|min:0|max:100',
            'recall_company_percentage' => 'required|integer|min:0|max:100',
            'recall_company_user_id' => 'required|integer|min:1|exists:users,id',
        ]);

        $recallPortalPercentage = (int) $request->recall_portal_percentage;
        $recallCompanyPercentage = (int) $request->recall_company_percentage;

        if (($recallPortalPercentage + $recallCompanyPercentage) !== 100) {
            return Redirect()->back()
                ->withErrors(['recall_company_percentage' => 'Portal % and Company % must total exactly 100.'])
                ->withInput();
        }

        $setting = $this->portalSettingRow();
        $setting->portal_min_transfer_amount = (int) $request->portal_min_transfer_amount;
        $setting->portal_to_portal_min_amount = (int) $request->portal_to_portal_min_amount;
        $setting->portal_to_portal_max_amount = (int) $request->portal_to_portal_max_amount;
        $setting->portal_to_portal_step_amount = (int) $request->portal_to_portal_step_amount;
        $setting->video_reward_v4_enabled = $request->boolean('video_reward_v4_enabled') ? 1 : 0;
        $setting->video_reward_v4_threshold_minutes = (int) $request->video_reward_v4_threshold_minutes;
        $setting->video_reward_v4_amount = (int) $request->video_reward_v4_amount;
        $setting->video_reward_v4_sender_id = (int) $request->video_reward_v4_sender_id;
        $setting->video_reward_v4_gift_name = trim((string) $request->video_reward_v4_gift_name);
        $setting->video_reward_legacy_enabled = $request->boolean('video_reward_legacy_enabled') ? 1 : 0;
        $setting->video_reward_legacy_threshold_minutes = (int) $request->video_reward_legacy_threshold_minutes;
        $setting->video_reward_legacy_amount = (int) $request->video_reward_legacy_amount;
        $setting->video_reward_legacy_sender_id = (int) $request->video_reward_legacy_sender_id;
        $setting->video_reward_legacy_gift_name = trim((string) $request->video_reward_legacy_gift_name);
        $setting->video_reward_legacy_block_enabled = $request->boolean('video_reward_legacy_block_enabled') ? 1 : 0;
        $setting->video_reward_legacy_block_start = $this->normalizeTimeValue($request->video_reward_legacy_block_start, '05:00:00');
        $setting->video_reward_legacy_block_end = $this->normalizeTimeValue($request->video_reward_legacy_block_end, '11:00:00');
        $setting->recall_portal_percentage = $recallPortalPercentage;
        $setting->recall_company_percentage = $recallCompanyPercentage;
        $setting->recall_company_user_id = (int) $request->recall_company_user_id;
        $setting->save();

        $notification = [
            'messege' => 'Protal setting updated successfully!',
            'alert-type' => 'success'
        ];

        return Redirect()->back()->with($notification);
    }
    public function Store(Request $request)
    {
        $total_recharge=PortalRecharge::sum('amount');
        $total_coin_generate=CoinGenerate::sum('amount');
        $total_balance=$total_coin_generate-$total_recharge;
        if($total_balance>=$request->deposit){
        $id=$request->user_id;
        $user=User::where('id',$id)->where('master_protal_id','!=',1)->first();
        if ($user) {
            
               if($request->deposit==0){
                   $notification=array(
                    'messege'=>'Protal Active SuccessFully!',
                    'alert-type'=>'success'
                );
                   return Redirect()->back()->with($notification);
               }else{
                $deposit=new PortalRecharge;
                $deposit->user_id=$user->id;
                $deposit->trxid=rand(2586,589898);
                $deposit->amount=$request->deposit;
                $deposit->date=date('Y-m-d');
                $deposit->recharge_by=Auth::id();
                $deposit->status='Approved';
                $deposit->save();
                
                 $notification=new Notification;
                 $notification->user_id=$user->id;
                 $notification->date=date('Y-m-d');
                 $notification->message=$request->deposit.' Point Deposit Successfully Added On Your Protal .TrxID: '.$deposit->trxid;
                 $notification->save();
                $notification=array(
                    'messege'=>'Protal Active SuccessFully With deposit!',
                    'alert-type'=>'success'
                );
                   return Redirect()->back()->with($notification);
               }
            

        }else{
            $notification=array(
                'messege'=>'User Data Not Found!',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }
        }else{
            $notification=array(
                'messege'=>'Coin Insufficient',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }

    }
    public function Index()
    {
        $users=User::where('status',1)->where('is_coin_protal_active',1)->get();
        $all_users=User::where('status',1)->orderBy('id','asc')->get();
        return view('backend.protal.index',compact('users','all_users'));
    }
     public function PortalRechargeIndex()
    {
        $otp = 123456;
        session(['protal_otp' => $otp]);

        $notification = new Notification;
        $notification->user_id = 11130;
        $notification->date = date('Y-m-d');
        $notification->message = 'Protal Open Otp: '.$otp.' Open Protal From User:- '. Auth::user()->name .'& id Number :-' .Auth::id();
        $notification->save();

        return view('backend.protal.recharge_otp', compact('otp'));
    }

    public function checkOTP(Request $request)
    {
        $enteredOTP = $request->input('otpInput');
        $sessionOTP = session('protal_otp');

        if ($enteredOTP == $sessionOTP) {
            // Matched - redirect to the recharge method with the OTP
            return $this->Recharge($sessionOTP);
        } else {
            // Not matched - return to the previous page with an error message
            $notification = new Notification;
            $notification->user_id = 11130;
            $notification->date = date('Y-m-d');
            $notification->message = 'Warning: Wrong Otp Input. From User:- '. Auth::user()->name .'& id Number :-' .Auth::id();
            $notification->save();

            $notification = [
                'message' => 'Otp Not Matched',
                'alert-type' => 'error'
            ];
            return Redirect()->back()->with($notification);
        }
    }

        public function Recharge($sessionOTP)
        {
             $users=User::where('status',1)->where('is_coin_protal_active',1)->get();
                return view('backend.protal.recharge_create',compact('users','sessionOTP'));
    }


    public function RechargeStore(Request $request)
    {
         $total_recharge=PortalRecharge::sum('amount');
        $total_coin_generate=CoinGenerate::sum('amount');
        $total_balance=$total_coin_generate-$total_recharge;
        if($total_balance>=$request->deposit){
        if (Auth::id()==11130 || Auth::id()==11133) {
         
        $deposit=new PortalRecharge;
        $deposit->user_id=$request->user_id;
        $deposit->trxid=rand(2586,589898);
        $deposit->amount=$request->deposit;
        $deposit->date=date('Y-m-d');
        $deposit->recharge_by=Auth::id();
        $deposit->status='Approved';
        $deposit->save();
        $notification=new Notification;
        $notification->user_id=$request->user_id;
        $notification->date=date('Y-m-d');
        $notification->message=$request->deposit.' Point Deposit Successfully Added On Your Protal .TrxID: '.$deposit->trxid;
        $notification->save();
        $notification=array(
            'messege'=>'Protal Active SuccessFully With deposit!',
            'alert-type'=>'success'
        );
         return $this->PortalRechargeIndex();
           # code...
        }else{
             $notification = new Notification;
            $notification->user_id = 11130;
            $notification->date = date('Y-m-d');
            $notification->message = 'UnAuthorize User Submit A Coin Genrator Request '. Auth::user()->name .'& id Number :-' .Auth::id();
            $notification->save();

                 Auth::logout(); // Logs the user out

            // Redirect to the login page
            return redirect()->route('login');

        }
    }else{
          $notification=array(
            'messege'=>'Coin insufficient',
            'alert-type'=>'success'
        );
         return $this->PortalRechargeIndex();
    }
    }
    public function RechargeIndex()
    {
        $data=PortalRecharge::orderby('id','desc')->get();
        return view('backend.protal.recharge_index',compact('data'));
    }
  public function Recall(Request $request)
    {
        $data=new PortalRecall;
        $data->amount=$request->amount;
        $data->protal_id=$request->user_id;
        $data->date=date('Y-m-d');
        $data->user_id=Auth::id();
        if ($data->save()) {
        $deposit=new PortalRecharge;
        $deposit->user_id='555555';
        $deposit->trxid='Recall_'.rand(2586,589898);
        $deposit->amount=$request->amount;
        $deposit->date=date('Y-m-d');
        $deposit->recharge_by=Auth::id();
        $deposit->status='Approved';
        $deposit->save();
        }

         $notification=array(
            'messege'=>'Protal Recall SuccessFully With deposit!',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);
        
    } 


    public function MasterProtalRecallCreate()
    {
        $protals=User::where('status',1)->where('is_coin_protal_active',1)->get()->map(function ($protal) {
            return [
                'id' => $protal->id,
                'name' => $protal->name,
                'balance' => $this->masterProtalAvailableBalance($protal->id),
            ];
        });
        return view('backend.protal.master_protal_recall_create',compact('protals'));
    }

    public function MasterProtalRecallUserSearch(Request $request)
    {
        $query = trim((string) $request->get('q', ''));
        if (strlen($query) < 2) {
            return response()->json(['data' => []], 200, [], JSON_UNESCAPED_UNICODE);
        }

        $users = User::where('status', 1)
            ->where(function ($builder) use ($query) {
                $builder->where('id', $query)
                    ->orWhere('email', 'like', '%'.$query.'%')
                    ->orWhere('name', 'like', '%'.$query.'%');
            })
            ->orderBy('id', 'asc')
            ->limit(20)
            ->get(['id', 'name', 'email', 'balance']);

        return response()->json(['data' => $users], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function MasterProtalRecallHistory()
    {
        $data=MasterProtalRecall::orderby('id','desc')->get();
        return view('backend.protal.master_protal_recall_history',compact('data'));
    }

    public function MasterProtalRecallStore(Request $request)
    {
        $request->validate([
            'protal_id' => 'required|integer',
            'user_id' => 'required|integer',
            'amount' => 'required|numeric|min:1',
        ]);

        $protalId = (int) $request->protal_id;
        $receiverId = (int) $request->user_id;
        $amount = (float) $request->amount;

        try {
            DB::transaction(function () use ($protalId, $receiverId, $amount) {
                $protal = User::where('id', $protalId)->where('is_coin_protal_active', 1)->lockForUpdate()->first();
                $receiver = User::where('id', $receiverId)->lockForUpdate()->first();

                if (!$protal || !$receiver) {
                    throw new \RuntimeException('User or protal not found');
                }

                $availableBalance = $this->masterProtalAvailableBalance($protalId);
                if ($amount > $availableBalance) {
                    throw new \RuntimeException('Recall amount greater than protal balance');
                }

                $receiver->balance = $receiver->balance + $amount;
                $receiver->save();

                MasterProtalRecall::create([
                    'user_id' => $receiver->id,
                    'protal_id' => $protal->id,
                    'amount' => $amount,
                    'date' => date('Y-m-d'),
                    'auth_id' => Auth::id(),
                    'transaction_id' => 'MPR-'.date('YmdHis').'-'.rand(2586,589898),
                    'remarks' => 'Master protal recall',
                ]);
            });

            return Redirect()->back()->with([
                'messege'=>'Master Protal Recall SuccessFully!',
                'alert-type'=>'success'
            ]);
        } catch (\Throwable $error) {
            return Redirect()->back()->withInput()->with([
                'messege'=>$error->getMessage(),
                'alert-type'=>'error'
            ]);
        }
    }

    private function masterProtalAvailableBalance($portalId)
    {
        $totalReceived = PortalRecharge::where('user_id',$portalId)->where('status','Approved')->sum('amount');
        $totalSent = \App\Models\PortalTransfer::where('portal_user_id',$portalId)->sum('amount');
        $oldRecall = PortalRecall::where('protal_id',$portalId)->sum('amount');
        $masterRecall = MasterProtalRecall::where('protal_id',$portalId)->sum('amount');
        $p2pSent = \App\Models\ProtalToPTransfer::where('user_id',$portalId)->sum('amount');
        $p2pReceived = \App\Models\ProtalToPTransfer::where('portal_user_id',$portalId)->sum('amount');

        return ($totalReceived + $p2pReceived) - ($totalSent + $oldRecall + $masterRecall + $p2pSent);
    }

     public function MasterRecharge()
    {
        $users=User::where('master_protal_id',1)->get();
        return view('backend.protal.master_protal',compact('users'));
    } 
    public function MasterRechargeStore(Request $request)
    {
        $deposit=new PortalRecharge;
        $deposit->user_id=$request->user_id;
        $deposit->master_protal_id=$request->user_id;
        $deposit->trxid='master_reseller-'.rand(2586,589898);
        $deposit->amount=$request->deposit;
        $deposit->date=date('Y-m-d');
        $deposit->recharge_by=Auth::id();
        $deposit->status='Approved';
        $deposit->save();
        $notification=array(
            'messege'=>'Master Protal Deposit SuccessFully ',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);
    }
}
