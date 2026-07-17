<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PortalRecharge;
use App\Models\Setting;
use Auth;
use App\Models\Gift;
use Illuminate\Support\Facades\DB;
class ReCallController extends Controller
{
    private function recallSettings(): array
    {
        $setting = Setting::find(1);
        $portalPercentage = (int) data_get($setting, 'recall_portal_percentage', 70);
        $companyPercentage = (int) data_get($setting, 'recall_company_percentage', 30);
        $companyUserId = (int) data_get($setting, 'recall_company_user_id', 11111);

        if ($portalPercentage < 0) {
            $portalPercentage = 70;
        }

        if ($companyPercentage < 0) {
            $companyPercentage = 30;
        }

        if (($portalPercentage + $companyPercentage) !== 100) {
            $portalPercentage = 70;
            $companyPercentage = 30;
        }

        return [
            'portal_percentage' => $portalPercentage,
            'company_percentage' => $companyPercentage,
            'company_user_id' => $companyUserId > 0 ? $companyUserId : 11111,
        ];
    }

    public function Create()
    {
    	$data['users']=User::all();
    	$data['protals']=User::where('is_coin_protal_active',1)->get();
    	return view('backend.protal.recall_create')->with($data);
    }
    public function GetData($id)
    {
    	$data=User::find($id);
    	return response()->json(['success' => 'User Find','data'=>$data]);
    }
    public function RecallStore(Request $request)
    {
        $request->validate([
            'user_id' => 'required|numeric',
            'protal_id' => 'required|numeric',
            'amount' => 'required|numeric|min:1',
        ]);

        $settings = $this->recallSettings();
        $amount = (float) $request->amount;

        try {
            DB::transaction(function () use ($request, $settings, $amount) {
                $user = User::where('id', $request->user_id)->lockForUpdate()->first();
                $portal = User::where('id', $request->protal_id)->where('is_coin_protal_active', 1)->lockForUpdate()->first();
                $companyUser = User::where('id', $settings['company_user_id'])->lockForUpdate()->first();

                if (!$user || !$portal || !$companyUser) {
                    throw new \RuntimeException('User, portal, or company user not found');
                }

                if ($user->balance < $amount) {
                    throw new \RuntimeException('User Balance Not Avaliabel');
                }

                $portalAmount = round(($amount * $settings['portal_percentage']) / 100, 2);
                $companyAmount = round($amount - $portalAmount, 2);

                $user->balance -= $amount;
                $user->save();

                if ($portalAmount > 0) {
                    $deposit = new PortalRecharge;
                    $deposit->user_id = $portal->id;
                    $deposit->trxid = 'recall-'.rand(2586,589898);
                    $deposit->amount = $portalAmount;
                    $deposit->date = date('Y-m-d');
                    $deposit->recharge_by = Auth::id();
                    $deposit->status = 'Approved';
                    $deposit->is_recall = 1;
                    $deposit->save();
                }

                if ($companyAmount > 0) {
                    $companyUser->balance += $companyAmount;
                    $companyUser->save();
                }
            });

            return Redirect()->back()->with([
                'messege' => 'Protal Recall SuccessFully With dynamic split!',
                'alert-type' => 'success'
            ]);
        } catch (\RuntimeException $error) {
            $message = $error->getMessage() === 'User Balance Not Avaliabel'
                ? 'User Balance Not Avaliabel'
                : 'User, portal, or company user not found';

            return Redirect()->back()->with([
                'messege' => $message,
                'alert-type' => $message === 'User Balance Not Avaliabel' ? 'warning' : 'error'
            ]);
        } catch (\Throwable $error) {
            return Redirect()->back()->with([
                'messege' => 'Somnthing Wrong!!',
                'alert-type' => 'error'
            ]);
        }
    }
    public function Index()
    {
    	$data=PortalRecharge::where('is_recall',1)->orderby('id','desc')->get();
    	return view('backend.protal.recall_index',compact('data'));
    }
    public function GiftRecall($id)
    {
         $gift=Gift::find($id);
         if ($gift) {
             $user=User::find(555555);
             $user->balance+=$gift->value;
             if ($user->save()) {
                $gift->delete();
             }
             $notification=array(
                'messege'=>'Gift Recall SuccessFully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
         }else{
             $notification=array(
                'messege'=>'Somnthing Wrong!!',
                'alert-type'=>'warning'
            );
            return Redirect()->back()->with($notification);
         }


    }
}
