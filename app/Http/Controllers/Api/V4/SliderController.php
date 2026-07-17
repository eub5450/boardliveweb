<?php

namespace App\Http\Controllers\Api\V4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Auth;
use App\Models\DeviceLockInvite;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
class SliderController extends Controller
{
    public function Index(Request $request)
    {
        $response = array();
        $token = $request->access_token;
        $user_id = $request->user_id;


        if($token=="0411f0028cfb768b3a3d96ac3aa37dw3e5"){
            $slider=Cache::remember('v4:broadlive:slider_list_v1', 300, function () {
                return Slider::orderby('id','desc')->get();
            })->map(function ($item) {
                $copy = clone $item;
                $copy->image = $this->publicSliderUrl($copy->image);
                return $copy;
            })->values();
            $user=User::find($user_id);
            $DeviceLockInvite=null;
            if($user && !empty($user->imei_number)){
                $DeviceLockInvite=DeviceLockInvite::where('device_id',$user->imei_number)->first();
            }
            $authUser=Auth::user();
            if($authUser && $authUser->invite_done==0 && empty($DeviceLockInvite)){
               $invite_popup=1; 
            }else{
            $invite_popup=0;
            }
            array_push($response,array('message'=>'Slider Found','code'=>'200','data'=>$slider,'invite_popup'=>$invite_popup));
            return response()->json($response, 200, [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }else{
            array_push($response,array('message'=>'Unauthorized','code'=>'401'));
            return response()->json($response, 401, [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
    }

    private function publicSliderUrl($image): string
    {
        $path = trim((string) $image);
        if ($path === '') {
            return '';
        }

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        $path = preg_replace('#^public/#', '', ltrim($path, '/'));
        return rtrim(request()->getSchemeAndHttpHost(), '/').'/'.ltrim($path, '/');
    }
}
