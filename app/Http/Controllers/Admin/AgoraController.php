<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AgoraKeys;
use App\Models\Setting;
class AgoraController extends Controller
{
    public function Index()
    {
        $data=AgoraKeys::all();
        return view('backend.setting.agora_key',compact('data'));
    }
    public function Store(Request $request)
    {
        //return $request->all();
        // ✅ Step 1: Validate input
        $request->validate([
            'appId'              => 'required|string|max:255',
            'appCertificate'     => 'required|string|max:255',
            'AgoraEmail'         => 'required|email|max:255',
            'AgoraEmailPassword' => 'required|string|max:255',
        ]);

        // ✅ Step 2: Save to database
        AgoraKeys::create([
            'appId'              => $request->appId,
            'appCertificate'     => $request->appCertificate,
            'AgoraEmail'         => $request->AgoraEmail,
            'AgoraEmailPassword' => $request->AgoraEmailPassword,
        ]);

        // ✅ Step 3: Redirect with success message
        return redirect()->back()->with('success', 'Agora Account saved successfully!');
    }
    
    public function AgoraAccountActive($id)
    {
        $keys=AgoraKeys::where('Status',1)->get();
        foreach($keys as $item){
            $item->Status=2;
            $item->save();
        }
        $data=AgoraKeys::find($id);
        $data->Status=1;
        if($data->save()){
            $setting=Setting::find(1);
            $setting->appId=$data->appId;
            $setting->appCertificate=$data->appCertificate;
            $setting->save();
        }
        $notification=array(
                'messege'=>'Agorea Key Change Successfully !',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }
}
