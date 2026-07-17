<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use App\Models\User;
use App\Models\UserLive;
use App\Models\Kick;
use App\Models\LiveCall;
use Auth;
class SettingController extends Controller
{
     public function __construct(Database $database)
    {
        $this->database = $database;
    }
    public function ActiveInvisible(Request $request)
    {
        $response = array();
        $token = $request->access_token;
        $user_id = $request->user_id;


        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            $data=User::find($user_id);
            if($data->is_invisible_active==1)
            {
                $data->is_invisible_active=0;
                $data->save();
                array_push($response,array('message'=>'Profile Invisible Deactive Successfully ','code'=>'200','data'=>$data));
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            }else{
                $data->is_invisible_active=1;
                $data->save();
                array_push($response,array('message'=>'Profile Invisible Active Successfully ','code'=>'200','data'=>$data));
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            }
           

       }else{
        array_push($response,array('message'=>'Unauthorized','code'=>'401'));
        return json_encode($response,JSON_UNESCAPED_UNICODE);
    }
    }
     public function LiveOff(Request $request)
    {
        $response = array();
        $websocket = array();
        $list = array();
        $token = $request->access_token;
        $host = $request->host_id;
        $channelName = $request->channelName;


        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            if(Auth::user()->brd_off_power==1){
        	$row = array();
		
    		$row['channelName'] = $channelName;
    		$row['status'] = strval(0);
    		$row['host_id'] = strval($host);
    		$push_count_ref = $this->database->getReference('official_brd_off/' . $channelName .'/'. $host);
            	$push_count_ref->set($row);
    		$live=UserLive::where('channelName',$channelName)->where('user_id',$host)->first();
    		if($live){
    		    $live->delete();
    		}
    	
            return json_encode($websocket,JSON_UNESCAPED_UNICODE);
			
            }else{
               
           array_push($response,array('message'=>'Your Device Banned ','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
            }

       }else{
        array_push($response,array('message'=>'Unauthorized','code'=>'401'));
        return json_encode($response,JSON_UNESCAPED_UNICODE);
    }
    }
    private function Websoket($data) {
    $response_json = json_encode($data);

    try {
        // Initialize cURL
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.104.191.163/api/recieve-two',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $response_json,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json'
            ),
        ));
        
        // Execute the request
        $response = curl_exec($curl);

        // Check for cURL errors
        if (curl_errno($curl)) {
            // Log cURL error details
            info('cURL error: ' . curl_error($curl));
        } else {
            // Optionally, log response code for debugging
            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            info('HTTP response code For Setting Brd recieve-one: ' . $http_code);
        }
        
        // Close the cURL session
        curl_close($curl);

    } catch (\Throwable $th) {
        // Log any other errors
        info('Exception: ' . $th->getMessage());
    }
}
}
