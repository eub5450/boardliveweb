<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Help;
class HelpController extends Controller
{
     public function Store(Request $request)
    {
        $response = array();
        $token = $request->access_token;
        $user_id = $request->user_id;
        $message = $request->message;


        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            $data=new Help;
            $data->user_id=$user_id;
            $data->problem=$message;
            $data->status=0;
            $data->save();
            array_push($response,array('message'=>'Support Request Sand Successfully ','code'=>'200'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);

        }else{
            array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
}
