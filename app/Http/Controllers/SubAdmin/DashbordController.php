<?php

namespace App\Http\Controllers\SubAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfilePending;
use App\Models\HostData;
use App\Models\User;
use App\Models\Agency;
use App\Models\Gift;
use App\Models\BanDevice;
use App\Models\Battle\Fortune\FortuneSetting;
use App\Models\Game\Fivestar\FivestarSetting;
use App\Models\Game\Grady\GradySetting;
use App\Models\Battle\TeenPattiSetting;
use App\Models\Comment;
use App\Models\Chat;
use Auth;
use DB;
use Carbon;
use App\Models\UserLive;
use Kreait\Firebase\Contract\Database;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Image;

class DashbordController extends Controller
{
  public function __construct(Database $database)
    {
        $this->database = $database;
    }
    public function Home()
    {
      $emptyGame = (object) ['game_balance' => 0, 'second_balance' => 0, 'third_balance' => 0];
      $total_agency=Agency::count();
      $active_host=User::where('is_host_id',1)->count();
      $total_users=User::count();
      $fruts_game_balance=FortuneSetting::find(1) ?: $emptyGame;
      $five_game_balance=FivestarSetting::find(1) ?: $emptyGame;
      $greedy_game_balance=GradySetting::find(1) ?: $emptyGame;
      $teenpatti_game_balance=TeenPattiSetting::find(1) ?: $emptyGame;
      $realtime_comment_count=Comment::where('created_at', '>=', now()->subHour())->count();
      $realtime_chat_count=Schema::hasTable('chats') ? Chat::where('created_at', '>=', now()->subHour())->count() : 0;
    	$data=ProfilePending::all();
    	return view('subadmin.home',compact('data','total_agency','active_host','total_users','fruts_game_balance','five_game_balance','greedy_game_balance','teenpatti_game_balance','realtime_comment_count','realtime_chat_count'));
    }
    public function CommentUpdate()
    {
      $comments=Comment::query()
          ->leftJoin('users as senders', 'senders.id', '=', 'comments.user_id')
          ->leftJoin('users as hosts', 'hosts.id', '=', 'comments.reciever_id')
          ->whereNotIn('comments.message', ['Has Joined', 'Has Leaved'])
          ->orderBy('comments.id', 'desc')
          ->limit(30)
          ->get([
              'comments.id',
              'comments.user_id',
              'comments.reciever_id',
              'comments.channelName',
              'comments.message',
              'comments.type',
              'comments.created_at',
              'senders.name as sender_name',
              'senders.profile as sender_profile',
              'hosts.name as host_name',
          ]);
      return view('backend.comment',compact('comments'));
    }
    public function chat()
    {
      $chat_data_all = Chat::query()
          ->leftJoin('users as senders', 'senders.id', '=', 'chats.sander_id')
          ->leftJoin('users as receivers', 'receivers.id', '=', 'chats.receiver_id')
          ->orderBy('chats.id', 'desc')
          ->limit(30)
          ->get([
              'chats.id',
              'chats.sander_id',
              'chats.receiver_id',
              'chats.text',
              'chats.created_at',
              'senders.name as sender_name',
              'receivers.name as receiver_name',
          ]);

      return view('backend.chat',compact('chat_data_all'));
    }
    public function PendingProfile()
    {
      $data=ProfilePending::all();
      return view('subadmin.profile_pending',compact('data'));
    }
    public function ApprovedImage($id)
    {
      $data=ProfilePending::find($id);
      if($data){
        $user=User::find($data->user_id);
        if($data->image){
        $user->profile=$data->image;
        }
        if($data->name){
        $user->name=$data->name;
        }
        $user->save();
        $data->delete();
        $notification=array(
                'messege'=>'Image Approved Successfully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
      }else{
         $notification=array(
                'messege'=>'Something Wrong Data not Found!!!!',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
      }

    } 
    public function RejectImage($id)
    {
      $data=ProfilePending::find($id);
      if($data){
        $data->delete();
        $notification=array(
                'messege'=>'Image Reject Successfully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
      }else{
         $notification=array(
                'messege'=>'Something Wrong Data not Found!!!!',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
      }

    }
    public function PendingHost()
    {
        $users=DB::table('users')->join('host_data','host_data.user_id','users.id')->select('users.*','host_data.country_id')->where('users.is_host_id',2)->where('users.status',1)->orderby('host_data.id','desc')->get();
        return view('subadmin.pending_host',compact('users'));
    }
    public function Ranking()
    {           $date = Carbon\Carbon::now(config('app.timezone', 'Europe/London'));
           $start_date = $date->copy()->startOfMonth()->toDateString();
           $end_date = $date->copy()->endOfMonth()->toDateString();
$data['totalSands'] = Gift::join('users', 'gifts.sander_id', '=', 'users.id')
                    ->whereDate('gifts.date', '>=', $start_date)
                    ->whereDate('gifts.date', '<=', $end_date) 
                      ->groupBy('sander_id', 'users.name', 'users.profile','users.id') 
                      ->selectRaw('sander_id, sum(value) as total_sand, users.name, users.id, users.profile') 
                      ->orderByDesc('total_sand')
           
                      ->get(); 
         
         $data['totalReciveds'] = Gift::join('users', 'gifts.reciever_id', '=', 'users.id')->whereDate('gifts.date', '>=', $start_date)
                        ->whereDate('gifts.date', '<=', $end_date) 
                        ->groupBy('reciever_id', 'users.name', 'users.profile','users.id') 
                        ->selectRaw('reciever_id, sum(value) as total_sand, users.name, users.id, users.profile') 
                        ->orderByDesc('total_sand') 
                        ->get();                                                     
           
         $data['totalfamillyReciveds'] = Gift::join('host_data', 'gifts.reciever_id', '=', 'host_data.user_id')->join('agencies', 'host_data.agency_code', '=', 'agencies.code')->whereDate('gifts.date', '>=', $start_date)
                        ->whereDate('gifts.date', '<=', $end_date) 
                       ->groupBy('host_data.agency_code', 'agencies.name', 'agencies.logo','agencies.code') 
                       ->selectRaw('sum(value) as total_sand, agencies.name, agencies.code, agencies.logo') 
                       ->orderByDesc('total_sand')                         
                       ->get();
                
             
         
        
        return view('subadmin.rankingList')->with($data);
    }
    public function BannedIndex()
    {
        $users=User::all();
        $ban_ids=User::where('status',0)->where('ban_type','!=',null)->get();
        return view('subadmin.id_banned',compact('users','ban_ids'));
    }
    public function BannedActive(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'id_number' => 'required|integer',
            'ban_type' => 'required|in:A,B,C,D',
            'proved' => 'required|file|max:10240',
        ]);

        if ((int) $validated['user_id'] !== (int) $validated['id_number']){
            return Redirect()->back()->withInput()->with([
                'messege'=>'ID confirmation does not match.',
                'alert-type'=>'warning'
            ]);
        }

        $data=User::find($validated['user_id']);
        if (!$data) {
            return Redirect()->back()->withInput()->with([
                'messege'=>'User not found.',
                'alert-type'=>'error'
            ]);
        }

        try {
            $proved_url = $this->storeProofUpload($request->file('proved'));

            DB::transaction(function () use ($data, $validated, $proved_url) {
                $data->is_invisible=0;
                $data->status=0;
                $data->ban_type=$validated['ban_type'];
                $data->ban_proved=$proved_url;
                $data->ban_by=Auth::id();
                $data->api_token=null;
                $data->game_api_key=null;
                $data->remember_token=null;
                $data->is_device_ban=$validated['ban_type'] === 'A' ? 1 : 0;

                if($validated['ban_type']=='A'){
                    $data->open_time=null;
                    if (!empty($data->device_id) && !BanDevice::where('device_id', $data->device_id)->exists()) {
                        DB::table('ban_devices')->insert([
                            'device_id' => $data->device_id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }elseif($validated['ban_type']=='B'){
                    $data->open_time=\Carbon\Carbon::now()->addDays(30)->format('Y-m-d H:i:s');
                    $this->removeDeviceBan($data);
                }elseif($validated['ban_type']=='C'){
                    $data->open_time=\Carbon\Carbon::now()->addDay()->format('Y-m-d H:i:s');
                    $this->removeDeviceBan($data);
                }else{
                    $data->open_time=\Carbon\Carbon::now()->addHour()->format('Y-m-d H:i:s');
                    $this->removeDeviceBan($data);
                }

                $data->save();
            });

            return Redirect()->back()->with([
                'messege'=>'ID Banned Successfully',
                'alert-type'=>'success'
            ]);
        } catch (\Throwable $error) {
            return Redirect()->back()->withInput()->with([
                'messege'=>'Ban failed: '.$error->getMessage(),
                'alert-type'=>'error'
            ]);
        }
    }
     public function BannedReject($id)
    {
            $data=User::find($id);

            if (!$data) {
                return Redirect()->back()->with([
                    'messege'=>'User not found.',
                    'alert-type'=>'error'
                ]);
            }

            try {
                DB::transaction(function () use ($data) {
                    $this->removeDeviceBan($data);
                    $data->status=1;
                    $data->ban_proved=null;
                    $data->ban_type=null;
                    $data->ban_by=null;
                    $data->open_time=null;
                    $data->is_device_ban=0;
                    $data->save();
                });

                return Redirect()->back()->with([
                    'messege'=>'ID Unbanned Successfully',
                    'alert-type'=>'success'
                ]);
            } catch (\Throwable $error) {
                return Redirect()->back()->with([
                    'messege'=>'Unban failed: '.$error->getMessage(),
                    'alert-type'=>'error'
                ]);
            }
    }

    private function removeDeviceBan(User $user): void
    {
        if (!empty($user->device_id)) {
            BanDevice::where('device_id', $user->device_id)->delete();
        }
    }

    private function storeProofUpload($file): string
    {
        if (!$file || !$file->isValid()) {
            throw ValidationException::withMessages(['proved' => 'Proof upload failed.']);
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf'];
        if (!in_array($extension, $allowed, true)) {
            throw ValidationException::withMessages(['proved' => 'Invalid proof file type: '.$extension]);
        }

        $targetDir = base_path('store/bannedproved');
        if (!File::isDirectory($targetDir)) {
            File::makeDirectory($targetDir, 0755, true, true);
        }

        $safeName = preg_replace('/[^a-zA-Z0-9_-]+/', '-', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $safeName = trim($safeName, '-') ?: 'proof';

        if ($extension === 'pdf') {
            $fileName = gmdate('YmdHis').'-'.uniqid().'-'.$safeName.'.pdf';
            $file->move($targetDir, $fileName);

            return 'store/bannedproved/'.$fileName;
        }

        $fileName = gmdate('YmdHis').'-'.uniqid().'-'.$safeName.'.webp';
        $image = Image::make($file->getRealPath())->orientate()->resize(1400, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $this->saveOptimizedWebp($image, $targetDir.DIRECTORY_SEPARATOR.$fileName);

        return 'store/bannedproved/'.$fileName;
    }

    private function saveOptimizedWebp($image, string $absolutePath): void
    {
        foreach ([88, 82, 76, 70, 64, 58, 52, 46] as $quality) {
            $image->encode('webp', $quality)->save($absolutePath);
            if (File::exists($absolutePath) && File::size($absolutePath) <= 102400) {
                return;
            }
        }

        while (File::exists($absolutePath) && File::size($absolutePath) > 102400 && $image->width() > 800) {
            $image->resize(max(800, (int) floor($image->width() * 0.9)), null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $image->encode('webp', 52)->save($absolutePath);
        }
    }

    public function LiveList()
    {
       $lives=UserLive::orderby('id','desc')->get();
      return view('subadmin.live_index',compact('lives'));
    }
    
    public function LiveOff($id)
    {
      $live=UserLive::find($id);
      
        $row = array();
    
        $row['channelName'] = $live->channelName;
        $row['status'] = strval(0);
        $row['host_id'] = strval($live->user_id);
        $push_count_ref = $this->database->getReference('official_brd_off/' . $live->channelName .'/'. $live->user_id);
        $push_count_ref->set($row);
          $live->delete();
       $notification=array(
                'messege'=>'Live Remove SuccessFully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    
    }

    public function ProfileView($id)
    {
      if ($id) {
        $user=User::find($id);
        if ($user) {

          $data['user']=User::find($id);
            $data['agency']=Agency::where('user_id',$id)->first();
            $data['agency_info']=DB::table('host_data')->join('agencies','agencies.code','host_data.agency_code')->select('agencies.*')->where('host_data.user_id',$id)->first();
            $data['info']=DB::table('host_data')->where('user_id',$id)->first();
          
            return view('subadmin.profile')->with($data);
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
     public function SearchProfileView(Request $request)
    {
      $id=$request->id;
      if ($id) {
        $user=User::find($id);
        if ($user) {

          $data['user']=User::find($id);
            $data['agency']=Agency::where('user_id',$id)->first();
            $data['agency_info']=DB::table('host_data')->join('agencies','agencies.code','host_data.agency_code')->select('agencies.*')->where('host_data.user_id',$id)->first();
            $data['info']=DB::table('host_data')->where('user_id',$id)->first();

            return view('subadmin.profile')->with($data);
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
    public function RejectHost($id)
    {
        $user=User::find($id);
        $user->is_host_id=0;
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
    public function ActiveHost($id)
    {
        $user=User::find($id);
        $user->is_host_id=1;
        $user->save();
        $notification=array(
                'messege'=>'Host Active SuccessFully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }
}
