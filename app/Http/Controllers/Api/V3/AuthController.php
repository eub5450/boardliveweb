<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use DB;
use App\Models\User;
use App\Models\Setting;
use App\Models\BanDevice;
use App\Models\ImieHistory;
use Pusher;
class AuthController extends Controller
{
    function login(Request $request){
        $token = $request->access_token;
      $device_id = $request->device_id;
      $imei_number = $request->imei_number;
      
        $response = array();
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            $request->validate([
                "email"=>'required',
                "password"=>'required'
            ]);
            $check_verify=User::where('email',$request->email)->first();
            $ban_device=BanDevice::where('device_id',$device_id)->first();
            $imie_ban_device=BanDevice::where('device_id',$imei_number)->first();
            $banned=User::where('ban_type','!=',Null)->where('email',$request->email)->first();
            if(!$imie_ban_device){
            if(!$ban_device){
            if(!$banned){
            if($check_verify){
                if ($check_verify->status==1) {
                    $credentials = request(['email','password']);

                    if(!Auth::attempt($credentials)){
                        array_push($response,array('message'=>'Unauthorized password','code'=>'401'));
                        return json_encode($response,JSON_UNESCAPED_UNICODE);
                    // return response()->json(['message'=>"Unauthorized"],401);
                    }
                  
                    // Do not use $request->user() here: mobile clients can send an
                    // old bearer token, which would resolve a different user ID.
                    $user = $check_verify;
                    //return $user;
                  $to=$user->createToken('apptoken')->plainTextToken;
                  $check_main_id=User::where('imei_number',$imei_number)->where('id','!=',$user->id)->first();
                  $log_user=User::find($user->id);
                  $log_user->device_id=$device_id;
                  if($user->id==1111){
                  $log_user->imei_number='d4e9aeb782727b07ef';
                 
                  }else{
                     $log_user->imei_number=$imei_number;  
                  }
                  if($check_main_id){
                  if($user->id==1111){
                    $log_user->main_id_number='1111';
                }else{
                    $log_user->main_id_number=$check_main_id->id;
                }
                  }
                
                  if($imei_number){
                  $check_old_imie=ImieHistory::where('imie',$imei_number)->where('user_id','!=',$log_user->id)->first();
                  if(!$check_old_imie){
                      $new_imie=new ImieHistory;
                      $new_imie->imie=$imei_number;
                      $new_imie->user_id=$log_user->id;
                      $new_imie->save();
                  }
                  }
                  
                    
                  	  $log_user->save();
               		  $is_host=DB::table('host_data')->join('users','users.id','host_data.user_id')->where('users.is_host_id',1)->where('users.id',$user->id)->select('host_data.hosting_type')->first();
                  $host_type=0;
                  if($is_host){
                  	$host_type=$is_host->hosting_type;
                  }
            //Balance
                    array_push($response,array('message'=>'Login Successfully ','password'=>$user->password,'profile'=>$user->profile,'id'=>$user->id,'name'=>$user->name,
                        'balance'=>$user->balance,'email'=>$user->email,'phone'=>$user->phone,'level'=>$user->level,'is_host_id'=>$user->is_host_id,'is_agency'=>$user->is_agency,'status'=>$user->status,'role'=>$user->role,'image'=>$user->profile,'device_id'=>$log_user->device_id,'token'=>$to,'brd_off_power'=>$user->brd_off_power,'can_invisible'=>$user->is_invisible,'host_type'=>$host_type,'sceen_short_power'=>$user->sceen_short_power,'comment_mute_power'=>$user->comment_mute_power,'kick_power'=>$user->kick_power,'code'=>'200'));
                  
         
                 //   $data['message'] = $log_user->device_id;
                //  $pusher->trigger('login_device', $user->id, $response);
                    return json_encode($response,JSON_UNESCAPED_UNICODE);
                  
                  
                }elseif($check_verify->status==2){
                    array_push($response,array('message'=>'Your Account suspended for violation Trams & Conditions. Thank You','code'=>'401'));
                    return json_encode($response,JSON_UNESCAPED_UNICODE);
            // return response()->json(['message'=>"Please Verify Your Account . Redirect verification Page"],400);
                }else{
                    array_push($response,array('message'=>'Please Verify Your Account .','code'=>'403'));
                    return json_encode($response,JSON_UNESCAPED_UNICODE);
            // return response()->json(['message'=>"Please Verify Your Account . Redirect verification Page"],400);
                }
            }else{
                array_push($response,array('message'=>'User Not Found','code'=>'404'));
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            // return response()->json(['message'=>"User Not Found"],404);
            } 
        }else{
              if($banned->ban_type=="B"){
                array_push($response, array('message' => 'Opps !! Your ID Banned For One Month . violation Rules B', 'code' => '404'));
              }elseif($banned->ban_type=="C"){
                array_push($response, array('message' => 'Opps !! Your ID Banned For 24 Hours . violation Rules C', 'code' => '404'));
              }
              elseif($banned->ban_type=="D"){
                array_push($response, array('message' => 'Opps !! Your ID Banned For 1 Hours . violation Rules D', 'code' => '404'));
              }else{
               array_push($response, array('message' => 'Opps !!  You Are Permanent Benned . violation Rules A', 'code' => '404'));
              }
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            // return response()->json(['message'=>"User Not Found"],404);
            }
        }else{
                array_push($response,array('message'=>'Opps !! You Are Permanent Ben','code'=>'404'));
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            // return response()->json(['message'=>"User Not Found"],404);
            }}else{
                array_push($response,array('message'=>'Opps !! You Are Permanent Ben','code'=>'404'));
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            // return response()->json(['message'=>"User Not Found"],404);
            }


            
        }else{
            array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
            // return response()->json(['message'=>"Unauthorized"],401);
        }
    }
    public function Logout(Request $request)
    {
        $token = $request->access_token;
        $response = array();
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            $request->user()->currentAccessToken()->delete();

            array_push($response,array('message'=>'Successfully Logout','code'=>'200'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{
            array_push($response,array('message'=>'Unauthorized Token Miss match','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
            // return response()->json(['message'=>"Unauthorized Token Miss match"],401);
        }

    } 
    public function UserRegister(Request $request)
    {
       $response = array();
        $token = $request->access_token;
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){

            $phone=$request->phone;
            $email=$request->email;
            
            $user_check=User::where('phone',$phone)->first();
            $user_check_email=User::where('email',$email)->first();
            if ($user_check_email) {
                array_push($response,array('message'=>'User Already Exits This Email','code'=>'401'));
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            }else{
                
                   $user=new User;
                   $user->name=$request->name;
                   $user->phone=$request->phone;
                   $user->email=$request->email;
                   $user->device_id=$request->device_id;
                   $user->level=1;
                   $user->is_vip=0;
                   $user->profile='store/profile/default.png';
                   $user->balance=0;
                   $user->entry_level=0;
                   $user->role=2;
                   $user->status=1;
                   $user->password=Hash::make($request->password);
                // $user->save();
               
           }


       }
       else{
        array_push($response,array('message'=>'Unauthorized Token Missmatch','code'=>'401'));
        return json_encode($response,JSON_UNESCAPED_UNICODE);
    }
}
     public function ChangePassword(Request $request)
    {
        $token = $request->access_token;
        $new_password = $request->new_password;
       $user_id = $request->user_id;
        $response = array();
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            $user=User::find($user_id);
            $user->password=Hash::make($new_password);
            $user->save();

            array_push($response,array('message'=>'Password Change Successfully','code'=>'200'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{
            array_push($response,array('message'=>'Unauthorized Token Miss match','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
            // return response()->json(['message'=>"Unauthorized Token Miss match"],401);
        }

    } 
     public function GoogleLogin(Request $request)
    {
        $token = $request->access_token;
        $email = $request->email;
        $name = $request->name;
        $device_id=$request->device_id;
        $imei_number=$request->imei_number;
        $response = array();
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            $check_data=User::where('email',$email)->orderby('id','desc')->first();
           $ban_device=BanDevice::where('device_id',$device_id)->first();
            $banned=User::where('ban_type','!=',Null)->where('email',$request->email)->first();
            if ($check_data) {
              if(!$ban_device){
              if(!$banned){
                  $check_main_id=User::where('imei_number',$imei_number)->first();
              Auth::login($check_data);
              // Use the Gmail-matched row, not any stale bearer-token user.
              $user = $check_data;
                    //return $user;
                $to=$user->createToken('apptoken')->plainTextToken;
                $loginuser=User::find($user->id);
                $loginuser->device_id=$device_id;
                if($check_main_id){
                if($user->id==1111){
                    $loginuser->main_id_number='1111';
                }else{
                    $loginuser->main_id_number=$check_main_id->id;
                }
                }
                if($user->id==1111){
                  $loginuser->imei_number='d4e9aeb782727b07ef';
                 
                  }else{
                     $loginuser->imei_number=$imei_number;  
                  }
                $loginuser->save();
                if($imei_number){
                  $check_old_imie=ImieHistory::where('imie',$imei_number)->where('user_id','!=',$loginuser->id)->first();
                  if(!$check_old_imie){
                      $new_imie=new ImieHistory;
                      $new_imie->imie=$imei_number;
                      $new_imie->user_id=$loginuser->id;
                      $new_imie->save();
                  }
                  }
                $is_host=DB::table('host_data')->join('users','users.id','host_data.user_id')->where('users.is_host_id',1)->where('users.id',$user->id)->select('host_data.hosting_type')->first();
                  $host_type=0;
                  if($is_host){
                  	$host_type=$is_host->hosting_type;
                  }
        array_push($response,array('message'=>'Login Successfully ','password'=>$user->password,'id'=>$user->id,'name'=>$user->name,'profile'=>$user->profile,
            'balance'=>$user->balance,'email'=>$user->email,'phone'=>$user->phone,'level'=>$user->level,'is_host_id'=>$user->is_host_id,'is_agency'=>$user->is_agency,'status'=>$user->status,'brd_off_power'=>$user->brd_off_power,'can_invisible'=>$user->is_invisible,'host_type'=>$host_type,'role'=>$user->role,'image'=>$user->profile,'token'=>$to,'host_type'=>$host_type,'sceen_short_power'=>$user->sceen_short_power,'comment_mute_power'=>$user->comment_mute_power,'kick_power'=>$user->kick_power,'code'=>'200'));

            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{
             if($banned->ban_type=="B"){
                array_push($response, array('message' => 'Opps !! Your ID Banned For One Month . violation Rules B', 'code' => '404'));
              }elseif($banned->ban_type=="C"){
                array_push($response, array('message' => 'Opps !! Your ID Banned For 24 Hours . violation Rules C', 'code' => '404'));
              }
              elseif($banned->ban_type=="D"){
                array_push($response, array('message' => 'Opps !! Your ID Banned For 1 Hours . violation Rules D', 'code' => '404'));
              }else{
               array_push($response, array('message' => 'Opps !!  You Are Permanent Benned . violation Rules A', 'code' => '404'));
              }
                return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
            }else{
                array_push($response,array('message'=>'Device Banned','code'=>'401'));
                return json_encode($response,JSON_UNESCAPED_UNICODE);
              }
          }else{
            $old_phone=User::orderby('id','desc')->first();
            $pass= rand(100000,500000);
            $new_user=new User;
            $new_user->name=$name;
            $new_user->device_id=$request->device_id;
            $new_user->imei_number=$request->imei_number;
            $new_user->phone=$old_phone->id+1;
            $new_user->email=$request->email;
            $new_user->level=1;
            $new_user->is_vip=0;
            $new_user->profile='store/profile/default.png';
            $new_user->balance=0;
            $new_user->entry_level=0;
            $new_user->role=2;
            $new_user->status=1;
            $new_user->password=Hash::make($pass);
            $new_user->save();
            Auth::login($new_user);
            $user = $new_user;
            
                    //return $user;
        $to=$user->createToken('apptoken')->plainTextToken;
        if($request->imei_number){
                  $check_old_imie=ImieHistory::where('imie',$request->imei_number)->where('user_id','!=',$user->id)->first();
                  if(!$check_old_imie){
                      $new_imie=new ImieHistory;
                      $new_imie->imie=$request->imei_number;
                      $new_imie->user_id=$user->id;
                      $new_imie->save();
                  }
                  }
        array_push($response,array('message'=>'Login Successfully ','password'=>$user->password,'id'=>$user->id,'name'=>$user->name,
            'balance'=>$user->balance,'email'=>$user->email,'phone'=>$user->phone,'level'=>$user->level,'is_host_id'=>$user->is_host_id,'is_agency'=>$user->is_agency,'status'=>$user->status,'role'=>$user->role,'image'=>$user->profile,'token'=>$to,'code'=>'200'));

        return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
        

    }else{
        array_push($response,array('message'=>'Unauthorized Token Miss match','code'=>'401'));
        return json_encode($response,JSON_UNESCAPED_UNICODE);
            // return response()->json(['message'=>"Unauthorized Token Miss match"],401);
    }

}  
   public function VarsionInfo(Request $request)
    {
         $token = $request->access_token;
        $response = array();
        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            $setting=Setting::findOrFail(1);
            array_push($response,array('message'=>'Verision Info Find','version'=>$setting->app_version,'pusher_app_id'=>$setting->app_id,'pusher_key'=>$setting->key,'agora_appId'=>$setting->appId,'agora_appCertificate'=>$setting->appCertificate,'pusher_cluster'=>$setting->cluster,'pusher_secret'=>$setting->secret,'old_app_package'=>$setting->old_app_package,'code'=>'200'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{
            array_push($response,array('message'=>'Unauthorized Token Miss match','code'=>'401'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
}
