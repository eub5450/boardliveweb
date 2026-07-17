<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Withdraw;
class WithdrawController extends Controller
{
   public function Index()
   {
        $start_date = date('Y-m') . '-01';
        $end_date = date('Y-m') . '-31';
       $data=Withdraw::orderby('id','desc')->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->get();
       return view('backend.withdraw.index',compact('data'));
   }
}
