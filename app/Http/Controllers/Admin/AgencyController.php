<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agency;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Image;
class AgencyController extends Controller
{
    public function Create()
    {
        return view('backend.agency.create');
    }
    public function Store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'agency_name' => 'required|string|max:255',
            'agency_code' => 'nullable|string|max:255',
            'phone' => 'required',
            'photo_id' => 'required|file|mimes:jpg,jpeg,png,webp|max:2048',
            'selfie' => 'required|file|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {
        $check_user=User::find(trim((string) $request->user_id));
        if($check_user){
           
            $photo_id_url = $this->storeAgencyImageAsWebp($request->file('photo_id'));
            $selfie_url = $this->storeAgencyImageAsWebp($request->file('selfie'));

           DB::transaction(function () use ($request, $check_user, $photo_id_url, $selfie_url) {
               $agency=new Agency;
               $agency->user_id=$check_user->id;
               $agency->name=$request->agency_name;
               $agency->code=$this->resolveAgencyCode($request->agency_code);
               $agency->logo=trim((string) $check_user->profile) !== '' ? $check_user->profile : 'store/profile/default.png';
               $agency->selfie=$selfie_url;
               $agency->photo_id=$photo_id_url;
               $agency->phone=$request->phone;
               $agency->save();
               $check_user->is_agency=1;
               $check_user->save();
           });
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
        } catch (\Exception $e) {
            return Redirect()->back()->with([
                'messege' => 'Agency create failed: '.$e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
       

    }
    public function Index()
    {
        $agencys=Agency::orderby('id','desc')->get();
        return view('backend.agency.index',compact('agencys'));
    }
    public function AgencyOff($id)
    {
      $user=User::find($id);
      $user->is_agency=0;
      $user->save();
      $notification=array(
                'messege'=>'Agency Inactive SuccessFully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }public function AgencyOn($id)
    {
      $user=User::find($id);
      $user->is_agency=1;
      $user->save();
      $notification=array(
                'messege'=>'Agency Active SuccessFully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }
    public function Active($id)
    {
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
    public function Reject($id)
    {
     $agency = Agency::find($id);

        if ($agency) {
            $check_user = User::find($agency->user_id);
        
            if ($check_user) {
                $check_user->update([
                    'is_agency' => 0,
                    'is_agency' => 0,
                    'is_coin_protal_active' => 0,
                    'host_badge' => 0,
                    'comment_badge' => 0,
                    'frame' => null,
                ]);
            }
        
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
    public function Update($id,Request $request)
    {
        if($request->hasFile('logo')){
                $image = $request->file('logo');
                $image_name = uniqid().'.'.strtolower($image->getClientOriginalExtension());
                $image_path = 'store/agency/';
                $image_url = $image_path.$image_name;
                $image->move($image_path, $image_name);
            }else{
                $image_url = $request->old_logo;
            }
            $user=Agency::find($id);
            $user->name=$request->name;
            $user->logo=$image_url;
            $user->save();
            $notification=array(
                'messege'=>'Profile Update Successfully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }
    private function resolveAgencyCode($requestedCode = null)
    {
        $code = trim((string) $requestedCode);
        if ($code !== '' && ctype_digit($code) && !Agency::where('code', $code)->exists()) {
            return $code;
        }

        return $this->nextAgencyCode();
    }

    private function nextAgencyCode()
    {
        $latest = Agency::query()
            ->whereNotNull('code')
            ->orderByRaw('CAST(code AS UNSIGNED) DESC')
            ->lockForUpdate()
            ->first();

        $next = $latest ? ((int) $latest->code) + 1 : 1000;
        while (Agency::where('code', (string) $next)->exists()) {
            $next++;
        }

        return (string) $next;
    }

    private function storeAgencyImageAsWebp($file)
    {
        $directory = base_path('store/agency');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $fileName = gmdate('YmdHis').'-'.uniqid().'.webp';
        $relativePath = 'store/agency/'.$fileName;
        $absolutePath = base_path($relativePath);

        Image::make($file->getRealPath())
            ->orientate()
            ->resize(1400, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('webp', 60)
            ->save($absolutePath);

        return $relativePath;
    }
}
