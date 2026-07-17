<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agency;
use App\Models\User;
use Auth;
class AgencyController extends Controller
{
     public function Create()
    {
        return view('author.agency.create');
    }
    public function Store(Request $request)
    {
        $check_user=User::find($request->user_id);
        if($check_user){
           
             if($request->hasFile('photo_id')){
                $photo_id = $request->file('photo_id');
                $photo_id_name = uniqid().'.'.strtolower($photo_id->getClientOriginalExtension());
                $image_path = 'store/agency/';
                $photo_id_url = $image_path.$photo_id_name;
                $photo_id->move($image_path, $photo_id_name);
            }else{
                $photo_id_url = 'store/profile/default.png';
            }
            if($request->hasFile('selfie')){
                $selfie = $request->file('selfie');
                $selfie_name = uniqid().'.'.strtolower($selfie->getClientOriginalExtension());
                $image_path = 'store/agency/';
                $selfie_url = $image_path.$selfie_name;
                $selfie->move($image_path, $selfie_name);
            }else{
                $selfie_url = 'store/profile/default.png';
            }
           $agency=new Agency;
           $agency->user_id=$check_user->id;
           $agency->name=$request->agency_name;
           $agency->code=$request->agency_code;
           $agency->logo='store/profile/default.png';
           $agency->selfie=$selfie_url;
           $agency->photo_id=$photo_id_url;
           $agency->phone=$request->phone;
           $agency->country_id=Auth::user()->country_id;
           $agency->save();
           $check_user->is_agency=1;
           $check_user->country_id=Auth::user()->country_id;
           $check_user->save();
           $notification=array(
                'messege'=>'Agency Active SuccessFully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
        }else{
            $notification=array(
                'messege'=>'User Not Found This ID',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }
       

    }
    public function Index()
    {
        $agencys=Agency::orderby('id','desc')->where('country_id',Auth::user()->country_id)->get();
        return view('author.agency.index',compact('agencys'));
    }
    public function Info(Request $request)
    {
    	$id=$request->id;
    	 $user=User::find($id);
        $agency=Agency::orderby('id','desc')->first();
        $next_agency_code=$agency->code+1;
        return response()->json(['success' => 'User Find','user'=>$user,'next_agency_code'=>$next_agency_code]);
    }
    public function Active(Request $request)
    {
       $id=$request->id;
      $agency=Agency::find($id);
      if ($agency) {
        $check_user=User::find($agency->user_id);
        if ($check_user) {
          $agency->status=1;
          $agency->save();
          $check_user->is_agency=1;
          $check_user->save();
          $notification=array(
                'messege'=>'Agency Active SuccessFully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
        }else{
          $notification=array(
                'messege'=>'User Not Found',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }
      }else{
         $notification=array(
                'messege'=>'Somthing Wrong',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
      }
    }
    public function Reject(Request $request)
    {
       $id=$request->id;
    
      $agency=Agency::find($id);
      if ($agency) {
       $agency->delete();
        $notification=array(
                'messege'=>'Agency Reject SuccessFully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
      }else{
         $notification=array(
                'messege'=>'Somthing Wrong',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
      }
    }
}
