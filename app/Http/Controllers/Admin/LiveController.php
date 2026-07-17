<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserLive;
use Kreait\Firebase\Contract\Database;
class LiveController extends Controller
{
   public function __construct(Database $database)
    {
        $this->database = $database;
    }
    public function Index()
    {
    	$lives=UserLive::orderby('id','desc')->get();
    	return view('backend.live.index',compact('lives'));
    }
    public function Off($id)
    {
    	$live=UserLive::find($id);
    	
      	$row = array();
		
    		$row['channelName'] = $live->channelName;
    		$row['status'] = strval(0);
    		$row['host_id'] = strval($live->user_id);
    		$push_count_ref = $this->database->getReference('official_brd_off/' . $live->channelName .'/'. $live->user_id);
    		$push_count_ref->set($row);
      		$live->delete();
    	 $notification=array(
                'messege'=>'Live Remove SuccessFully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    
    }
}
