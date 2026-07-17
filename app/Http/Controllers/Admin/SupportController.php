<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Help;
use App\Models\User;
use App\Models\Notification;
class SupportController extends Controller
{
    public function Index()
    {
    	$data=Help::orderby('status','desc')->get();
    	return view('backend.support',compact('data'));
    }
    public function Replay($id,Request $request)
    {
    	$comment=$request->replay.'-- Best Regards - Support Team -Broad Live';
    	$replay=Help::find($id);
    	$replay->replay=$comment;
    	$replay->status=1;
    	$replay->save();
    	$notification=new Notification;
        $notification->user_id=$replay->user_id;
        $notification->date=date('Y-m-d');
        $notification->message=$comment;
        $notification->save();
        $user=User::find($replay->user_id);
        $to = $user->device_id;
                    $data = array(
                        "to" => $to,
                        "data" => array(
                            "link" => "https://lindaapp.in/new_live/share/v2/22441/760b23bf21f945daadedcf29b790e52e/1"
                        ),
                        "notification" => array(
                            "body" => $comment,
                            "title" => "BPLive Support Response",
                            "click_action" => "deviceNoti"
                        )
                    );
                    $payload = json_encode($data);
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => $payload,
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json',
                            'Authorization: key=AAAAd7PU44s:APA91bEjM26iXg_0tksuEmwQ5N6UBAWCdsm01Ym66dI3IYeHo92JBMOjB4VWyGsnZbWRqIvFkJqxxCOYI7FOhnWWzYBT9hSd3eic2S3RNJ5C8jqphRDpjp2EYEUKNLiDQtnfKhKD_edK'
                        ),
                    ));

                    $notification_api = curl_exec($curl);
                    curl_close($curl);
         		$notification=array(
                'messege'=>'Replay Successfully Submit',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }
}
