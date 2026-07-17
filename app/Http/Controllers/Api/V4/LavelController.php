<?php

namespace App\Http\Controllers\Api\V4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lavel;
use App\Models\Gift;
use App\Models\User;
class LavelController extends Controller
{
    public function Index(Request $request)
    {
    	$response = array();
         $token = $request->access_token;
         $user_id = $request->user_id;
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
    	 $data=Lavel::select('amount','update_lavel')->get();
    	 $total_sand_gift=Gift::where('sander_id',$user_id)->sum('value');
    	 $my_running_level=User::find($user_id);
    	 $next_level=$my_running_level->level+1;
    	  $next_level_amount=Lavel::where('update_lavel',$next_level)->first();
    	 $need_amount=$next_level_amount->amount-$total_sand_gift;
    	 $need_parcent=intval($total_sand_gift / $next_level_amount->amount * 100);

    	array_push($response,array('message'=>'Data Found Successfully!','list'=>$data,'my_running_lavel'=>$my_running_level->level,'next_level'=>$next_level,'complete_parcentage'=>$need_parcent,'code'=>'200'));
        return json_encode($response,JSON_UNESCAPED_UNICODE);
    	}
    	else{
    		array_push($response,array('message'=>'Unauthorizeddd','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
    	}


    }
}
