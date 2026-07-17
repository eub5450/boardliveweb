<?php

namespace App\Http\Controllers\Api\V4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VipList;
use App\Models\EntryFrameProfit;
use App\Models\EntryFrame;
use App\Models\MyBeg;
use App\Models\Notification;
use Auth;
use DB;
use Carbon\Carbon;
class VipController extends Controller
{
    public function Index(Request $request)
    {
        $response = array();
        $token = $request->access_token;
        $user_id = $request->user_id;
        $data = array();

        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            if($user_id==Auth::id()){
                 $vip_lists=VipList::where('user_id',$user_id)->orderby('vip_no','desc')->get();
                 foreach($vip_lists as $vip_list){
                    $list = array();
                    $list['id'] = $vip_list->id;
                    $list['user_id'] = $vip_list->user_id;
                    $list['vip_no'] = $vip_list->vip_no;
                    $list['is_active'] = $vip_list->is_active;
                    $list['active_date'] = $vip_list->active_date;
                    $list['expaire_date'] = $vip_list->end_date;
                    $list['image'] = $vip_list->image;
                    array_push($data, $list);
                 }
                 
                array_push($response,array('message'=>'Data Found! ','vip_list'=>$data,'code'=>'200'));
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            }else{
                array_push($response,array('message'=>'Login User And Sand User ID Not Same','code'=>'401'));
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            }

        }else{
           array_push($response,array('message'=>'Unauthorized','code'=>'401'));
           return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
    public function Active(Request $request)
    {
        $response = array();
        $token = $request->access_token;
        $user_id = $request->user_id;
        $vip_no = $request->vip_no;


        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            if($user_id==Auth::id()){
                $user=User::find($user_id);
                $check_exit_vip=VipList::where('user_id',$user->id)->where('vip_no',$vip_no)->first();
                if($check_exit_vip && $vip_no!=0){
                    $check_exit_vip->is_active=1;
                    $check_exit_vip->save();
                    if($vip_no==7){
                      $user->is_invisible=1;  
                    }
                    $user->is_vip=$vip_no;
                    $user->save();
                }else{
                     $vip_lists=VipList::where('user_id',$user->id)->get();
                     foreach($vip_lists as $vip_list){
                         $vip_list->is_active=0;
                         $vip_list->save();
                     }
                   // $user->is_vip=$vip_no;
                    $user->is_invisible=0;
                    $user->save();
                }
                 
                array_push($response,array('message'=>'Vip Active Successfull!','code'=>'200'));
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            }else{
                array_push($response,array('message'=>'Login User And Sand User ID Not Same','code'=>'401'));
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            }

        }else{
           array_push($response,array('message'=>'Unauthorized','code'=>'401'));
           return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
   
    public function Notification(Request $request)
    {
        
        $response = array();
        $token = $request->access_token;
        $user_id = $request->user_id;


        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            if($user_id==Auth::id()){
                $data=Notification::where('user_id',$user_id)->orderby('id','desc')->get();
                array_push($response,array('message'=>'Data Found! ','data'=>$data,'code'=>'200'));
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            }else{
                array_push($response,array('message'=>'Login User And Sand User ID Not Same','code'=>'401'));
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            }

        }else{
           array_push($response,array('message'=>'Unauthorized','code'=>'401'));
           return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
    public function BuyEntry(Request $request)
    {
        
        $response = array();
        $token = $request->access_token;
        $user_id = $request->user_id;
        $id = $request->id;


        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            if($user_id==Auth::id()){
                $check_old_purchase=MyBeg::where('user_id',$user_id)->where('store_id',$id)->first();
                if(!$check_old_purchase){
                    $user=User::find($user_id);
                    
                    $data=EntryFrame::find($id);
                    if($user->balance>=$data->price){
                    $my_beg=new MyBeg;
                    $my_beg->user_id=$user_id;
                    $my_beg->store_id=$id;
                    $my_beg->name=$data->name;
                    $my_beg->image=$data->image;
                    $my_beg->active_time=Carbon::now();
                    $my_beg->expaire_time=Carbon::now()->addDays($data->time);
                    $my_beg->effect=$data->effect;
                    $my_beg->type=$data->type;
                    $my_beg->save();
                    $profite=new EntryFrameProfit;
                    $profite->user_id=$user_id;
                    $profite->store_id=$id;
                    $profite->amount=$data->price;
                    $profite->date=Carbon::now();
                    $profite->save();
                  if($data->type==1){
                     $user->entry=$data->effect;  
                  }else{
                      $user->frame=$data->effect;   
                  }
                   $user->balance-=$data->price;
                    $user->save();
                    
                array_push($response,array('message'=>'Entry Purchase Successfully ','code'=>'200'));
                  return json_encode($response,JSON_UNESCAPED_UNICODE);
                    }else{
                        array_push($response,array('message'=>'Insufficient Balance ','code'=>'401'));
                        return json_encode($response,JSON_UNESCAPED_UNICODE);
                    }
                }else{
                    array_push($response,array('message'=>'This Entry Already Have In Your My VIP List','code'=>'401'));
                return json_encode($response,JSON_UNESCAPED_UNICODE);
                }
               
            }else{
                array_push($response,array('message'=>'Login User And Sand User ID Not Same','code'=>'401'));
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            }

        }else{
           array_push($response,array('message'=>'Unauthorized','code'=>'401'));
           return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    } 
    public function EntryFrame(Request $request)
    {
        
        $response = array();
        $token = $request->access_token;
        $user_id = $request->user_id;


        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            if($user_id==Auth::id()){
                $entry_effects=EntryFrame::where('type',1)->where('is_show',1)->get();
                $frame_effects=EntryFrame::where('type',0)->where('is_show',1)->get();
                $my_effects=MyBeg::where('user_id',$user_id)->get();
                array_push($response,array('message'=>'Stor Date','entry_effects'=>$entry_effects,'frame_effects'=>$frame_effects,'my_effects'=>$my_effects,'code'=>'200'));
            return json_encode($response,JSON_UNESCAPED_UNICODE);
            }else{
                array_push($response,array('message'=>'Login User And Sand User ID Not Same','code'=>'401'));
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            }

        }else{
           array_push($response,array('message'=>'Unauthorized','code'=>'401'));
           return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
    public function EntryFrameActiveInactive(Request $request)
    {
        
        $response = array();
        $token = $request->access_token;
        $user_id = $request->user_id;
        $id = $request->id;
        $status = $request->status;


        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            if($user_id==Auth::id()){
                $my_effects=MyBeg::where('user_id',$user_id)->where('id',$id)->first();
                
                if($my_effects){
                    $all_effects=MyBeg::where('user_id',$user_id)->where('type',$my_effects->type)->get();
                    foreach($all_effects as $all_effect){
                        $all_effect->status=0;
                        $all_effect->save();
                    }
                    $vip_lists=VipList::where('user_id',$user_id)->get();
                     foreach($vip_lists as $vip_list){
                         $vip_list->is_active=0;
                         $vip_list->save();
                         
                     }
                    $my_effects->status=$status;
                    $my_effects->save();
                    $user=User::find($user_id);

                    if($my_effects->type==1){
                        $effect_type='Entry';
                        if($my_effects->type==1 && $status==1){
                      $user->entry=$my_effects->effect;
                        }elseif($my_effects->type==1 && $status==0){
                            DB::table('users')
                        ->where('id', $user_id)
                        ->update(['entry' => null, 'is_invisible' => 0]);
                        }else{
                              DB::table('users')
                        ->where('id', $user_id)
                        ->update(['entry' => null, 'is_invisible' => 0]);
                        }
                    }else{
                        if($my_effects->type==0 && $status==1){
                            $user->frame=$my_effects->effect; 
                        }elseif($my_effects->type==0 && $status==0){
                             DB::table('users')
                    ->where('id', $user_id)
                    ->update(['frame' => null, 'is_invisible' => 0]);
                        }else{
                           DB::table('users')
                    ->where('id', $user_id)
                    ->update(['frame' => null, 'is_invisible' => 0]);
                        }
                     
                      $effect_type='Frame';
                    }
                    $user->save();
                    if($status==1){
                        $do='Active';
                    }else{
                       $do='Inactive'; 
                    }
                    
                  $message = "$effect_type Effect $do Successfully";
                    array_push($response,array('message'=>$message,'code'=>'200'));
                    return json_encode($response,JSON_UNESCAPED_UNICODE);
                }else{
                    array_push($response,array('message'=>'Effect Not Found In Your Store','code'=>'401'));
                    return json_encode($response,JSON_UNESCAPED_UNICODE);
                }
                
            }else{
                array_push($response,array('message'=>'Login User And Sand User ID Not Same','code'=>'401'));
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            }

        }else{
           array_push($response,array('message'=>'Unauthorized','code'=>'401'));
           return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
    public function MyDecorations(Request $request)
    {
        $response = array();
        $token = $request->access_token;
        $user_id = $request->user_id;

        if ($token != "0411f0028cfb768b3a3d96ac3aa37dw3e5") {
            array_push($response, array('message' => 'Unauthorized', 'code' => '401'));
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }

        if ($user_id != Auth::id()) {
            array_push($response, array('message' => 'Login User And Sand User ID Not Same', 'code' => '401'));
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }

        $garage = MyBeg::where('user_id', $user_id)
            ->where('type', 0)
            ->select('id', 'name', 'image', 'status')
            ->orderBy('id', 'desc')
            ->get();

        $pendant = MyBeg::where('user_id', $user_id)
            ->where('type', 1)
            ->select('id', 'name', 'image', 'status')
            ->orderBy('id', 'desc')
            ->get();

        array_push($response, array(
            'message' => 'Decoration Data Found',
            'garage' => $garage,
            'pendant' => $pendant,
            'code' => '200',
        ));

        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    public function ActivateDecoration(Request $request)
    {
        return $this->EntryFrameActiveInactive($request);
    }

     public function VIPActive(Request $request)
    {
        $response = array();
        $token = $request->access_token;
        $user_id = $request->user_id;
        $id = $request->id;
        $status = $request->status;
        $vip_no = $request->vip_no;


        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            if($user_id==Auth::id()){
                $user=User::find($user_id);
                $check_exit_vip=VipList::where('user_id',$user->id)->where('id',$id)->first();
                 if($check_exit_vip){
                     $all_effects=MyBeg::where('user_id',$user_id)->get();
                    foreach($all_effects as $all_effect){
                        $all_effect->status=0;
                        $all_effect->save();
                    }

                    DB::table('users')
                    ->where('id', $user_id)
                    ->update(['entry' => null, 'frame' => null, 'is_invisible' => 0]);
                     $all_vips=VipList::where('user_id',$user_id)->get();
                    foreach($all_vips as $all_vip){
                        $all_vip->is_active=0;
                        $all_vip->save();
                    }
                    $check_exit_vip->is_active=$status;
                   $check_exit_vip->save();
                    $user->is_vip=$status;
                    if($vip_no==7 && $status==1 ){
                      $user->is_vip=7;  
                      $user->is_invisible=1;  
                      $user->frame='vip7.svga';  
                      $user->entry='vip7entry.svga';  
                    }elseif($vip_no==6 && $status==1){
                        $user->is_vip=6; 
                       $user->frame='vip6.svga';  
                      $user->entry='vip6entry.svga'; 
                    }elseif($vip_no==5 && $status==1){
                        $user->is_vip=5; 
                        $user->frame='vip5.svga';  
                      $user->entry='vip5entry.svga';
                    }elseif($vip_no==4 && $status==1){
                        $user->is_vip=4; 
                        $user->frame='vip4.svga';  
                      $user->entry='vip4entry.svga';
                    }elseif($vip_no==3 && $status==1){
                        $user->is_vip=3; 
                        $user->frame='vip3.svga';  
                      $user->entry='vip3entry.svga';
                    }elseif($vip_no==2 && $status==1){
                        $user->is_vip=2; 
                      $user->frame='vip2.svga';  
                      $user->entry='vip2entry.svga';  
                    }elseif($vip_no==1 && $status==1){
                        $user->is_vip=1; 
                        $user->frame='vip1.svga';  
                      $user->entry='vip1entry.svga';
                    }
                    $user->save();
                    
                     array_push($response,array('message'=>'Vip Active Successfull!','code'=>'200'));
                    return json_encode($response,JSON_UNESCAPED_UNICODE);
                 }else{
                     array_push($response,array('message'=>'Vip Not Found In Your VIP Store','code'=>'401'));
                     return json_encode($response,JSON_UNESCAPED_UNICODE);
                 }
                 
                
            }else{
                array_push($response,array('message'=>'Login User And Sand User ID Not Same','code'=>'401'));
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            }

        }else{
           array_push($response,array('message'=>'Unauthorized','code'=>'401'));
           return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
}
