<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon;
use App\Models\Agency;
use App\Models\HostData;
use App\Models\User;
use App\Models\PortalRecharge;
use App\Models\PortalTransfer;
use App\Models\Game\Fivestar\FivestarPots;
use App\Models\Battle\Fortune\FortunePots;
use App\Models\Gift;
class HostController extends Controller
{
    public function Create()
    {
    	 $agencys=DB::table('users')->join('agencies','agencies.user_id','users.id')->where('users.is_agency',1)->where('agencies.country_id',Auth::user()->country_id)->select('agencies.name','agencies.code')->get();
        $host=User::where('is_host_id',0)->where('id','!=',Auth::id())->get();
    	return view('author.host.create',compact('agencys','host'));
    }
    public function Store(Request $request)
    {
    	  $check_host_data=HostData::where('user_id',$request->host_id)->first();
        if ($check_host_data) {
             $notification=array(
                'messege'=>'Allready Have Host Data!',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }else{
            $user=User::find($request->host_id);
            $nid_check=HostData::where('nid',$request->nid)->first();
            if ($nid_check) {
               $notification=array(
                'messege'=>'Allready Nid Used Have Host Data!',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
            }else{
            if($request->hasFile('image')){
                $image = $request->file('image');
                $image_name = uniqid().'.'.strtolower($image->getClientOriginalExtension());
                $image_path = 'store/agency/';
                $image_url = $image_path.$image_name;
                $image->move($image_path, $image_name);
            }else{
                $image_url = 'store/profile/default.png';
            }
             if($request->hasFile('nid')){
                $photo_id = $request->file('nid');
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
            $data=new HostData;
           $data->user_id=$request->host_id;
           $data->agency_code=$request->agency_id;
           $data->name=$user->name;
           $data->phone=$request->phone_number;
           $data->photo_id=$photo_id_url;
           $data->selfie=$selfie_url;
           $data->image=$image_url;
           $data->nid=$request->nid;
           $data->hosting_type=$request->hosting_type;
           $data->age=18;
           $data->country_id=Auth::user()->country_id;
           $data->save();
           $user->is_host_id=1;
           $user->country_id=Auth::user()->country_id;
           $user->save();
            $notification=array(
                'messege'=>'host Approved SuccessFully!',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
            }
           
        }
    }
    public function Index()
    {
        $users=User::where('is_host_id',1)->where('status',1)->where('id','!=',Auth::id())->where('country_id',Auth::user()->country_id)->orderby('id','desc')->get();
        return view('author.host.index',compact('users'));
    }
    public function Pending()
    {
        $users=DB::table('users')->join('host_data','host_data.user_id','users.id')->select('users.*','host_data.country_id')->where('host_data.country_id',Auth::user()->country_id)->where('users.is_host_id',2)->where('users.status',1)->orderby('host_data.id','desc')->get();
        return view('author.host.pending_host',compact('users'));
    }
    public function Profle(Request $request)
    {
        $id=$request->id;
         // return $id;
        if ($id) {
            $user=User::where('id',$id)->where('country_id',Auth::user()->country_id)->first();

            if ($user) {
                $data['user']=User::find($id);
                $data['agency']=Agency::where('user_id',$id)->first();
                $data['agency_info']=DB::table('host_data')->join('agencies','agencies.code','host_data.agency_code')->select('agencies.*')->where('host_data.user_id',$id)->first();
                $data['protal_recharge']=PortalRecharge::where('user_id',$id)->where('is_recall',0)->sum('amount');
                $data['recall_protal_recharge']=PortalRecharge::where('user_id',$id)->where('is_recall',1)->sum('amount');
                $data['protal_transfer']=PortalTransfer::where('portal_user_id',$id)->sum('amount');
                $data['protal_recharge_details']=PortalRecharge::where('user_id',$id)->where('is_recall',0)->orderby('id','desc')->get();
                
                $data['protal_transfer_details']=PortalTransfer::where('portal_user_id',$id)->orderby('id','desc')->get();
                $data['recharge_historys']=PortalTransfer::where('user_id',$id)->orderby('id','desc')->get();
                $data['sanding_historys']=Gift::where('sander_id',$id)->orderby('id','desc')->get();
                $data['info']=DB::table('host_data')->where('user_id',$id)->first();
                $data['reciving_historys']=Gift::where('reciever_id',$id)->orderby('id','desc')->get();
                $currentDate = Carbon\Carbon::now()->format('Y-m-d');
              $twoDaysAgo = Carbon\Carbon::now()->subDays(2)->format('Y-m-d');
                $firust_game=FortunePots::orderby('id','desc')->where('user_id',$id)->whereDate('created_at', '>=', $twoDaysAgo)
                    ->whereDate('created_at', '<=', $currentDate) ->get();
                $five_game=FivestarPots::orderby('id','desc')->where('user_id',$id)->whereDate('created_at', '>=', $twoDaysAgo)
                    ->whereDate('created_at', '<=', $currentDate) ->get();
                $mergedArray = collect();

                foreach ($firust_game as $game) {
                    $game->game_type = 'firust';
                    $mergedArray->push($game);
                }
                
                foreach ($five_game as $game) {
                    $game->game_type = 'five_game';
                    $mergedArray->push($game);
                }
                
                $data['game_history'] = $mergedArray->sortByDesc('created_at');

                

                return view('author.host.profile')->with($data);
            }else{
                 $notification=array(
                'messege'=>'User Not Found!!',
                'alert-type'=>'warning'
            );
            return Redirect()->back()->with($notification);
            }
        
        }else{
             $notification=array(
                'messege'=>'Please Enter ID Number',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }
        
    }
    public function PendingProfle($id)
    {
 
        if ($id) {
            $user=User::where('id',$id)->where('country_id',Auth::user()->country_id)->first();

            if ($user) {
                $data['user']=User::find($id);
                $data['agency']=Agency::where('user_id',$id)->first();
                $data['agency_info']=DB::table('host_data')->join('agencies','agencies.code','host_data.agency_code')->select('agencies.*')->where('host_data.user_id',$id)->first();
                $data['protal_recharge']=PortalRecharge::where('user_id',$id)->where('is_recall',0)->sum('amount');
                $data['recall_protal_recharge']=PortalRecharge::where('user_id',$id)->where('is_recall',1)->sum('amount');
                $data['protal_transfer']=PortalTransfer::where('portal_user_id',$id)->sum('amount');
                $data['protal_recharge_details']=PortalRecharge::where('user_id',$id)->where('is_recall',0)->orderby('id','desc')->get();
                
                $data['protal_transfer_details']=PortalTransfer::where('portal_user_id',$id)->orderby('id','desc')->get();
                $data['recharge_historys']=PortalTransfer::where('user_id',$id)->orderby('id','desc')->get();
                $data['sanding_historys']=Gift::where('sander_id',$id)->orderby('id','desc')->get();
                $data['info']=DB::table('host_data')->where('user_id',$id)->first();
                $data['reciving_historys']=Gift::where('reciever_id',$id)->orderby('id','desc')->get();
                $currentDate = Carbon\Carbon::now()->format('Y-m-d');
              $twoDaysAgo = Carbon\Carbon::now()->subDays(2)->format('Y-m-d');
                $firust_game=FortunePots::orderby('id','desc')->where('user_id',$id)->whereDate('created_at', '>=', $twoDaysAgo)
                    ->whereDate('created_at', '<=', $currentDate) ->get();
                $five_game=FivestarPots::orderby('id','desc')->where('user_id',$id)->whereDate('created_at', '>=', $twoDaysAgo)
                    ->whereDate('created_at', '<=', $currentDate) ->get();
                $mergedArray = collect();

                foreach ($firust_game as $game) {
                    $game->game_type = 'firust';
                    $mergedArray->push($game);
                }
                
                foreach ($five_game as $game) {
                    $game->game_type = 'five_game';
                    $mergedArray->push($game);
                }
                
                $data['game_history'] = $mergedArray->sortByDesc('created_at');

                

                return view('author.host.profile')->with($data);
            }else{
                 $notification=array(
                'messege'=>'User Not Found!!',
                'alert-type'=>'warning'
            );
            return Redirect()->back()->with($notification);
            }
        
        }else{
             $notification=array(
                'messege'=>'Please Enter ID Number',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }
        
    }
    public function Active($id)
    {
        $user=User::find($id);
        $user->is_host_id=1;
        $user->country_id=Auth::id();
        $user->save();
        $notification=array(
                'messege'=>'Host Active SuccessFully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }
    public function InActive($id)
    {
        $user=User::find($id);
        $user->is_host_id=0;
        $user->country_id=Auth::id();
        $user->save();
        $data=HostData::where('user_id',$id)->first();
        if ($data) {
            $data->delete();
            // code...
        }

        $notification=array(
                'messege'=>'Host Reject SuccessFully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }
}
