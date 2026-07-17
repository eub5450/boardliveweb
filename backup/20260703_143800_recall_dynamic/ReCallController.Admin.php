<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PortalRecharge;
use Auth;
use App\Models\Gift;
class ReCallController extends Controller
{
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
    	$user=User::find($request->user_id);
    	if ($user->balance>=$request->amount) {
    		$user->balance-=$request->amount;
    		if ($user->save()) {
    			$deposit=new PortalRecharge;
                $deposit->user_id=$request->protal_id;
                $deposit->trxid='recall-'.rand(2586,589898);
                $deposit->amount=$request->amount;
                $deposit->date=date('Y-m-d');
                $deposit->recharge_by=Auth::id();
                $deposit->status='Approved';
                $deposit->is_recall=1;
                $deposit->save();
                $notification=array(
                    'messege'=>'Protal Recall SuccessFully With deposit!',
                    'alert-type'=>'success'
                );
                   return Redirect()->back()->with($notification);
    		}else{
    			$notification=array(
                'messege'=>'Somnthing Wrong!!',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
    		}
    	}else{
    		 $notification=array(
                'messege'=>'User Balance Not Avaliabel',
                'alert-type'=>'warning'
            );
            return Redirect()->back()->with($notification);
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
