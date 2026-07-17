<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\PortalRecharge;
use App\Models\PortalTransfer;
use App\Models\User;

class ProtalController extends Controller
{
    public function profile()
    {
    	$id=Auth::id();
    	$country_id=Auth::user()->country_id;
    	$data['protal_recharge']=PortalRecharge::where('user_id',$id)->where('master_protal_id',$id)->where('is_recall',0)->sum('amount');
    	$data['protal_transfer']=PortalRecharge::where('recharge_by',$id)->sum('amount');
    	$data['protal_recharge_details']=PortalRecharge::where('user_id',$id)->where('master_protal_id',$id)->where('is_recall',0)->orderby('id','desc')->get();      
		$data['protal_transfer_details']=PortalRecharge::where('recharge_by',$id)->orderby('id','desc')->get();
		$data['protal_users']=User::where('status',1)->where('is_coin_protal_active',1)->where('country_id',$country_id)->where('id','!=',$id)->get();
    	return view('author.protal.index')->with($data);
    }
    public function TransferStore(Request $request)
    {
    	$validated = $request->validate([
        'protal_id' => 'required',
        'deposit' => 'required',
    	]);
    	$id=Auth::id();
    	$country_id=Auth::user()->country_id;
    	$protal_recharge=PortalRecharge::where('user_id',$id)->where('master_protal_id',$id)->where('is_recall',0)->sum('amount');
    	$protal_transfer=PortalRecharge::where('recharge_by',$id)->sum('amount');
    	$balance=$protal_recharge-$protal_transfer;
    	if ($balance>$request->deposit) {
    	$deposit=new PortalRecharge;
        $deposit->user_id=$request->protal_id;
        $deposit->trxid='mp-'.rand(2586,589898);
        $deposit->amount=$request->deposit;
        $deposit->date=date('Y-m-d');
        $deposit->recharge_by=Auth::id();
        $deposit->status='Approved';
        $deposit->save();
        $notification=array(
            'messege'=>'Protal Deposit SuccessFully!',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);
    	}else{
    		$notification=array(
            'messege'=>'Please Check Your Balance',
            'alert-type'=>'error'
        );
        return Redirect()->back()->with($notification);
    	}
    	
    }
    public function Index()
    {
    	$id=Auth::id();
    	$country_id=Auth::user()->country_id;
    	$data=User::where('status',1)->where('is_coin_protal_active',1)->where('country_id',$country_id)->where('id','!=',$id)->get();
    	return view('author.protal.manage',compact('data'));
    }
}
