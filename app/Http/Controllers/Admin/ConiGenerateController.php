<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CoinGenerate;
use Auth;
class ConiGenerateController extends Controller
{
    public function Index()
    {
    	$data=CoinGenerate::all();
    	return view('backend.protal.coin_generate',compact('data'));
    }
    public function Store(Request $request)
    {
    	if ($request->confirm_amount==$request->amount) {
        $data=new CoinGenerate;
    	$data->user_id=Auth::id();
    	$data->date=date('Y-m-d');
    	$data->amount=$request->amount;
    	$data->save();
    	$notification=array(
                'messege'=>'Coin Generate Successfully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    	}else{
    		 $notification=array(
                'messege'=>'Confirm Your Amount',
                'alert-type'=>'warning'
            );
            return Redirect()->back()->with($notification);
    	}
    	
    }
    public function Delete($id)
    {
    	$data=CoinGenerate::find($id);
    	$data->delete();
    	$notification=array(
                'messege'=>'Coin Generate Removed Successfully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }

}
