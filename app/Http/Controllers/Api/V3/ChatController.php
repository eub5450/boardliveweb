<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gift;
use DB;
use Carbon;
use Pusher;
use App\Models\User;
use App\Models\Chat;
use Kreait\Firebase\Contract\Database;
class ChatController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
    }
     public function Gift(Request $request)
    {
        $token = $request->access_token;
        $user_id = $request->user_id;
        $value = $request->value;
        $gift_name = $request->giftName;
        $gift_type = $request->gift_type;
        $host_id = $request->host_id;
        $response = array();

        if ($token == "0411f0028cfb768b3a3d96ac3aa37dw3e5") {
        
             $sander = User::find($user_id);
                    if ($sander->balance >=$value) {
                        $sander->balance -= $value;
                        $sander->save();
                        
                        $gift = new Gift;
                        $gift->sander_id = $user_id;
                        $gift->reciever_id = $host_id;
                        $gift->name = $gift_name;
                        $gift->value = $value;
                        $gift->channelName='chat_gifiting';
                        $gift->date = Carbon\Carbon::now();
                        $gift->save();
                       
                        $user=User::find($user_id);
                        $total = Gift::where('sander_id', $user_id)->sum('value');
                         if ($total > 0) {
                        $level = 1; // Starting level is 2
                         if($total >= 10000 && $total < 50000){
                            $level = 2;
                        }
                        elseif ($total >= 50001 && $total < 100000) {
                            $level = 3;
                        } elseif ($total >= 100001 && $total < 150000) {
                            $level = 4;
                        } elseif ($total >= 150001 && $total < 200000) {
                            $level = 5;
                        } elseif ($total >= 200001 && $total < 400000) {
                            $level = 6;
                        } elseif ($total >= 400001 && $total < 600000) {
                            $level = 7;
                        } elseif ($total >= 600001 && $total < 800000) {
                            $level = 8;
                        } elseif ($total >= 800001 && $total < 1000000) {
                            $level = 9;
                        } elseif ($total >= 1000001 && $total < 1200000) {
                            $level = 10;
                        } elseif ($total >= 1200001 && $total < 2200000) {
                            $level = 11;
                        } elseif ($total >= 2200001 && $total < 3200000) {
                            $level = 12;
                        } elseif ($total >= 3200001 && $total < 4200000) {
                            $level = 13;
                        } elseif ($total >= 4200001 && $total < 5200000) {
                            $level = 14;
                        } elseif ($total >= 5200001 && $total < 6200000) {
                            $level = 15;
                        } elseif ($total >= 6200001 && $total < 8200000) {
                            $level = 16;
                        } elseif ($total >= 8200001 && $total < 10200000) {
                            $level = 17;
                        } elseif ($total >= 10200001 && $total < 12200000) {
                            $level = 18;
                        } elseif ($total >= 12200001 && $total < 14200000) {
                            $level = 19;
                        } elseif ($total >= 14200001 && $total < 16200000) {
                            $level = 20;
                        } elseif ($total >= 16200001 && $total < 19200000) {
                            $level = 21;
                        } elseif ($total >= 19200001 && $total < 22200000) {
                            $level = 22;
                        } elseif ($total >= 22200001 && $total < 25200000) {
                            $level = 23;
                        } elseif ($total >= 25200001 && $total < 28200000) {
                            $level = 24;
                        } elseif ($total >= 28200001 && $total < 31200000) {
                            $level = 25;
                        } elseif ($total >= 31200001 && $total < 40000000) {
                            $level = 26;
                        } elseif ($total >= 40000001 && $total < 50000000) {
                            $level = 27;
                        } elseif ($total >= 50000001 && $total < 60000000) {
                            $level = 28;
                        } elseif ($total >= 60000001 && $total < 70000000) {
                            $level = 29;
                        } elseif ($total >= 70000001 && $total < 80000000) {
                            $level = 30;
                        } elseif ($total >= 80000001 && $total < 100000000) {
                            $level = 31;
                        } elseif ($total >= 100000001 && $total < 120000000) {
                            $level = 32;
                        } elseif ($total >= 120000001 && $total < 140000000) {
                            $level = 33;
                        } elseif ($total >= 140000001 && $total < 160000000) {
                            $level = 34;
                        } elseif ($total >= 160000001 && $total < 180000000) {
                            $level = 35;
                        } elseif ($total >= 180000001 && $total < 200000000) {
                            $level = 36;
                        } elseif ($total >= 200000001 && $total < 220000000) {
                            $level = 37;
                        } elseif ($total >= 220000001 && $total < 240000000) {
                            $level = 38;
                        } elseif ($total >= 240000001 && $total < 260000000) {
                            $level = 39;
                        } elseif ($total >= 260000001 && $total < 280000000) {
                            $level = 40;
                        } elseif ($total >= 280000001 && $total < 330000000) {
                            $level = 41;
                        } elseif ($total >= 330000001 && $total < 380000000) {
                            $level = 42;
                        } elseif ($total >= 380000001 && $total < 430000000) {
                            $level = 43;
                        } elseif ($total >= 430000001 && $total < 480000000) {
                            $level = 44;
                        } elseif ($total >= 480000001 && $total < 530000000) {
                            $level = 45;
                        } elseif ($total >= 530000001 && $total < 580000000) {
                            $level = 46;
                        } elseif ($total >= 580000001 && $total < 630000000) {
                            $level = 47;
                        } elseif ($total >= 630000001 && $total < 680000000) {
                            $level = 48;
                        } elseif ($total >= 680000001 && $total < 730000000) {
                            $level = 49;
                        } else {
                              // For values greater than or equal to 780000000
                              $level = 1;
                          }
                            $user->level=$level;
                        
                          $user->save();
                        }
                         array_push($response, array('message' => 'User Sand A gift Value :- '.$value, 'code' => '200'));
                         return json_encode($response, JSON_UNESCAPED_UNICODE);
                    } else {
                        array_push($response, array('message' => 'Balance Insufficient for Gift', 'code' => '401'));
                        return json_encode($response, JSON_UNESCAPED_UNICODE);
                    }
        } else {
            array_push($response, array('message' => 'Unauthorized', 'code' => '401'));
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }
    }
        public function Store(Request $request)
    {
         $token = $request->access_token;
        $sander_id = $request->sander_id;
        $message = $request->message;
        $receiver_id = $request->receiver_id;
        $response = array();

        if ($token == "0411f0028cfb768b3a3d96ac3aa37dw3e5") {
            $data=new Chat;
            $data->sander_id=$sander_id;
            $data->receiver_id=$receiver_id;
            $data->text=$message;
            $data->save();
            $user=User::find($receiver_id);
             $notificationBody = $message;
             $title = $user->name." Sand A Message.";
                 $to = $user->device_id;
                    $data = array(
                        "to" => $user->device_id,
                        "data" => array(
                            "link" => "https://bplive.site/new_live/share/v2/22441/760b23bf21f945daadedcf29b790e52e/1",
                            "profile" => "https://bplive.site/store/profile/default.png"
                        ),
                        "notification" => array(
                            "body" => $notificationBody,
                            "title" => $title,
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
            array_push($response, array('message' => 'Successfully Store', 'code' => '200'));
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }else{
            array_push($response, array('message' => 'Unauthorized', 'code' => '401'));
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }
    }
}
