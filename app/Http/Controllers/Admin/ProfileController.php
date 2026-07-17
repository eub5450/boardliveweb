<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Agency;
use App\Models\HostData;
use App\Models\FuritsPotsBackup;
use App\Models\DayTime;
use App\Models\PortalRecharge;
use App\Models\PortalTransfer;
use App\Models\Game\Fivestar\FivestarPots;
use App\Models\Battle\Fortune\FortunePots;
use App\Models\Gift;
use App\Models\PortalRecall;
use App\Models\VipList;
use App\Models\ProfilePending;
use App\Models\BanDevice;
use App\Models\Withdraw;
use App\Models\WithdrawConvartAgency;
use App\Models\Game\Grady\GradyPots;
use App\Models\ProtalToPTransfer;
use App\Models\Battle\TeenPattiPots;
use App\Models\EntryFrame;
use App\Models\MyBeg;
use DB;
use Carbon;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Image;

class ProfileController extends Controller
{
    public function Index(Request $request)
    {
    	$id=$request->id;
    	if ($id) {
    		$user=User::find($id);
    		if ($user) {

		    	$data['user']=$user;
                $profileFast=Cache::remember('admin_profile_fast_'.$id, 30, function() use ($user,$id) {
                    $otherDevices=collect();
                    if (!empty($user->imei_number) || !empty($user->device_id)) {
                        $otherDevices=User::select('id','name','device_id','imei_number')
                            ->where('id','!=',$id)
                            ->where(function($q) use ($user) {
                                if (!empty($user->imei_number)) {
                                    $q->orWhere('imei_number',$user->imei_number);
                                }
                                if (!empty($user->device_id)) {
                                    $q->orWhere('device_id',$user->device_id);
                                }
                            })
                            ->orderBy('id','asc')
                            ->limit(50)
                            ->get();
                    }

                    return [
                        'contry'=>DB::table('countries')->select('id','name')->where('id',$user->country_id)->first(),
                        'other_devices'=>$otherDevices,
                    ];
                });
                $data=array_merge($data,$profileFast);

		        $data['agency']=Agency::where('user_id',$id)->first();
		        $data['agency_info']=DB::table('host_data')->join('agencies','agencies.code','host_data.agency_code')->select('agencies.*')->where('host_data.user_id',$id)->first();
		        $data['protal_recharge']=Cache::remember('admin_profile_protal_recharge_'.$id, 30, function() use ($id) { return PortalRecharge::where('user_id',$id)->where('status','Approved')->sum('amount'); });
		        $data['recall_protal_recharge']=Cache::remember('admin_profile_recall_protal_recharge_'.$id, 30, function() use ($id) { return PortalRecall::where('protal_id',$id)->sum('amount'); });
		        $data['protal_transfer']=Cache::remember('admin_profile_protal_transfer_'.$id, 30, function() use ($id) { return PortalTransfer::where('portal_user_id',$id)->sum('amount'); });
		        $data['protal_recharge_details']=PortalRecharge::where('user_id',$id)->orderby('id','desc')->limit(80)->get();
		        
		        $data['protal_transfer_details']=PortalTransfer::where('portal_user_id',$id)->orderby('id','desc')->limit(80)->get();
		        $data['recharge_historys']=PortalTransfer::where('user_id',$id)->orderby('id','desc')->limit(80)->get();
		        $data['recharge_history_total']=PortalTransfer::where('user_id',$id)->sum('amount');
		        $data['sanding_historys']=Gift::where('sander_id',$id)->orderby('id','desc')->limit(120)->get();
		        $data['sanding_history_total']=Gift::where('sander_id',$id)->sum('value');
		        $data['info']=DB::table('host_data')->where('user_id',$id)->first();
		        $data['convart_history']=DB::table('withdraw_convart_agencies')->where('agency_id',$id)->orderBy('id','desc')->limit(80)->get();
		        $data['agency_commisiion']=$data['convart_history'];
		        $data['reciving_historys']=Gift::where('reciever_id',$id)->orderby('id','desc')->limit(120)->get();
		        $data['reciving_history_total']=Gift::where('reciever_id',$id)->sum('value');
		        $data['approved_balance']=Cache::remember('admin_profile_approved_balance_'.$id, 30, function() use ($id) { return Withdraw::where('agency_id',$id)->where('status',1)->sum('agency_profit'); });
        		$data['agency_convart_balance']=Cache::remember('admin_profile_agency_convart_balance_'.$id, 30, function() use ($id) { return WithdrawConvartAgency::where('agency_id',$id)->sum('amount'); });
        		$data['protal_to_protal_transfer']=ProtalToPTransfer::where('user_id',$id)->orderBy('id','desc')->limit(80)->get();
        		$data['entry_frame_list']=EntryFrame::all();
        		$data['my_begs']=MyBeg::where('user_id',$id)->get();
        		$data['my_vips']=VipList::where('user_id',$id)->get();
        		$data['protal_to_protal_transfer_recived']=ProtalToPTransfer::where('portal_user_id',$id)->orderBy('id','desc')->limit(80)->get();
					$data['portal_transfer_send_total']=ProtalToPTransfer::where('user_id',$id)->sum('amount');
					$data['portal_transfer_received_total']=ProtalToPTransfer::where('portal_user_id',$id)->sum('amount');
        	        $start_date = date('Y-m') . '-01';
                    $end_date = date('Y-m') . '-31';
                    $data['check_host_balance'] = Withdraw::where('agency_id', $id)
                                        ->whereDate('date', '>=', $start_date)
                                        ->whereDate('date', '<=', $end_date)
                                        ->distinct('host_id')
                                        ->count('host_id');
				$currentDate = Carbon\Carbon::now()->format('Y-m-d');
               $twoDaysAgo = Carbon\Carbon::now()->subDays(2)->format('Y-m-d');
                $firust_game=FortunePots::orderby('id','desc')->where('user_id',$id)->whereDate('created_at', '>=', $twoDaysAgo)
                    ->whereDate('created_at', '<=', $currentDate)->limit(80)->get();
                $firust_game_backup=FuritsPotsBackup::orderby('id','desc')->where('user_id',$id)->limit(80)->get();
                $five_game=FivestarPots::orderby('id','desc')->where('user_id',$id)->whereDate('created_at', '>=', $twoDaysAgo)
                    ->whereDate('created_at', '<=', $currentDate)->limit(80)->get();
                $greedy_game=GradyPots::orderby('id','desc')->where('user_id',$id)->whereDate('created_at', '>=', $twoDaysAgo)
                    ->whereDate('created_at', '<=', $currentDate)->limit(80)->get();
                    $teen_patti=TeenPattiPots::orderby('id','desc')->where('user_id',$id)->whereDate('created_at', '>=', $twoDaysAgo)
                    ->whereDate('created_at', '<=', $currentDate)->limit(80)->get();
                    
                $mergedArray = collect();

                foreach ($firust_game as $game) {
                    $game->game_type = 'firust';
                    $mergedArray->push($game);
                }
                foreach ($firust_game_backup as $firust_game) {
                    $firust_game->game_type = 'firust';
                    $mergedArray->push($firust_game);
                }
                
                foreach ($five_game as $game) {
                    $game->game_type = 'five_game';
                    $mergedArray->push($game);
                } 
                foreach ($greedy_game as $game) {
                    $game->game_type = 'greedy';
                    $mergedArray->push($game);
                }
                foreach ($teen_patti as $game) {
                    $game->game_type = 'Teen_patti';
                    $mergedArray->push($game);
                }
                
                $data['game_history'] = $mergedArray->sortByDesc('created_at')->take(240);

               

		        return view('backend.profile.index')->with($data);
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
    public function ClearDeviceIds($id)
    {
        if ((int) Auth::id() !== 11133) {
            $notification=array(
                'messege'=>'Unauthorized device clear request',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }

        $user=User::find($id);
        if (!$user) {
            $notification=array(
                'messege'=>'User Not Found!!',
                'alert-type'=>'warning'
            );
            return Redirect()->back()->with($notification);
        }

        $deviceId=$user->device_id;
        $imeiNumber=$user->imei_number;
        if (empty($deviceId) && empty($imeiNumber)) {
            $notification=array(
                'messege'=>'No device id found for this user',
                'alert-type'=>'warning'
            );
            return Redirect()->to('id_search?id='.$user->id)->with($notification);
        }

        $query=User::where('id','!=',$user->id)->where(function($q) use ($deviceId,$imeiNumber) {
            if (!empty($imeiNumber)) {
                $q->orWhere('imei_number',$imeiNumber);
            }
            if (!empty($deviceId)) {
                $q->orWhere('device_id',$deviceId);
            }
        });

        $matchedIds=$query->pluck('id')->toArray();
        $updated=0;
        if (!empty($matchedIds)) {
            $updated=User::whereIn('id',$matchedIds)->update([
                'device_id'=>null,
                'imei_number'=>null
            ]);
        }

        $notification=array(
            'messege'=>'Cleared device id from '.$updated.' other user(s)',
            'alert-type'=>'success'
        );
        return Redirect()->to('id_search?id='.$user->id)->with($notification);
    }

    public function BrdPowerOn($id)
    {
      $user=User::find($id);
      $user->brd_off_power=1;
      $user->save();
       $notification=array(
                'messege'=>'Brd Power On Successfully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }
    public function PasswordChange($id){
        $user=User::find($id);
        $user->password=Hash::make(123456);
        $user->save();
        $notification=array(
                'messege'=>'Password Changed',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }
    public function VipActived($id,$vip)
    {
      $vip=(int) $vip;
      $user=User::find($id);

      if(!$user){
          return Redirect()->back()->with([
                'messege'=>'User not found',
                'alert-type'=>'error'
            ]);
      }

      if($vip < 1 || $vip > 7){
          return Redirect()->back()->with([
                'messege'=>'Invalid VIP number',
                'alert-type'=>'error'
            ]);
      }

      $check_old_vip=VipList::where('user_id',$user->id)->where('vip_no',$vip)->first();
      $isAlreadyActive=$check_old_vip && (int) $check_old_vip->is_active === 1 && (int) $user->is_vip === $vip;

      if($isAlreadyActive){
          $check_old_vip->is_active=0;
          $check_old_vip->save();

          if((int) $user->is_vip === $vip){
              $user->is_vip=0;
              if($user->frame === 'vip'.$vip.'.svga'){
                  $user->frame='';
              }
              if($user->entry === 'vip'.$vip.'entry.svga'){
                  $user->entry='';
              }
              $user->save();
          }

          return Redirect()->back()->with([
                'messege'=>'VIP '.$vip.' Inactive Successfully',
                'alert-type'=>'success'
            ]);
      }

      VipList::where('user_id',$user->id)->update(['is_active'=>0]);

      if(!$check_old_vip){
          $check_old_vip=new VipList;
          $check_old_vip->vip_no=$vip;
          $check_old_vip->user_id=$user->id;
          $check_old_vip->image='store/vip/'.$vip.'.png';
      }

      $check_old_vip->active_date=Carbon\Carbon::now();
      $check_old_vip->is_active=1;
      $check_old_vip->end_date=Carbon\Carbon::now()->addDays(15);
      $check_old_vip->save();

      $user->is_vip=$vip;
      $user->frame='vip'.$vip.'.svga';
      $user->entry='vip'.$vip.'entry.svga';
      $user->save();

      return Redirect()->back()->with([
                'messege'=>'VIP '.$vip.' Active Successfully',
                'alert-type'=>'success'
            ]);
    }

     public function officalFrameAtive($id)
    {
      return $this->profileActivateSpecialFrame($id,'is_official_frame','official.svga','Official Frame');
    }

    public function AdminFrameAtive($id)
    {
      return $this->profileActivateSpecialFrame($id,'is_admin_frame','frame_10.svga','BD Admin Frame');
    }

    public function CountryAdminFrameAtive($id)
    {
      return $this->profileActivateSpecialFrame($id,'is_country_admin_frame','frame_9.svga','Country Admin Frame');
    }

    public function ResellerFrameAtive($id)
    {
      return $this->profileActivateSpecialFrame($id,'is_reseller_frame','reseller.svga','Reseller Frame');
    }

    public function OfficialFrameInactive($id)
    {
      return $this->profileDeactivateSpecialFrame($id,'is_official_frame','official.svga','Official Frame');
    }

    public function AdminFrameInactive($id)
    {
      return $this->profileDeactivateSpecialFrame($id,'is_admin_frame','frame_10.svga','BD Admin Frame');
    }

    public function CountryAdminFrameInactive($id)
    {
      return $this->profileDeactivateSpecialFrame($id,'is_country_admin_frame','frame_9.svga','Country Admin Frame');
    }

    public function ResellerFrameInactive($id)
    {
      return $this->profileDeactivateSpecialFrame($id,'is_reseller_frame','reseller.svga','Reseller Frame');
    }

    private function profileActivateSpecialFrame($id,$flagColumn,$frame,$label)
    {
      $user=User::find($id);
      if(!$user){
          return Redirect()->back()->with([
                'messege'=>'User not found',
                'alert-type'=>'error'
            ]);
      }

      $user->is_admin_frame=0;
      $user->is_official_frame=0;
      $user->is_reseller_frame=0;
      $user->is_country_admin_frame=0;
      $user->{$flagColumn}=1;
      $user->frame=$frame;
      $user->save();

      return Redirect()->back()->with([
                'messege'=>$label.' Actived',
                'alert-type'=>'success'
            ]);
    }

    private function profileDeactivateSpecialFrame($id,$flagColumn,$frame,$label)
    {
      $user=User::find($id);
      if(!$user){
          return Redirect()->back()->with([
                'messege'=>'User not found',
                'alert-type'=>'error'
            ]);
      }

      $user->{$flagColumn}=0;
      if($user->frame === $frame){
          $user->frame='';
      }
      $user->save();

      return Redirect()->back()->with([
                'messege'=>$label.' Inactive',
                'alert-type'=>'success'
            ]);
    }

    public function EffectActive($user_id,$id){
        $user=User::find($user_id);
        $check_effect=EntryFrame::find($id);

        if(!$user || !$check_effect){
             return Redirect()->back()->with([
                'messege'=>'User or effect not found',
                'alert-type'=>'error'
            ]);
        }

        $check_old_effect=MyBeg::where('user_id',$user_id)->where('store_id',$id)->first();
        $type=(int) $check_effect->type;

        if($check_old_effect && (int) $check_old_effect->status === 1){
            $check_old_effect->status=0;
            $check_old_effect->save();

            if($type === 1 && $user->entry === $check_old_effect->effect){
                $user->entry='';
            }elseif($type === 0 && $user->frame === $check_old_effect->effect){
                $user->frame='';
            }
            $user->save();

            return Redirect()->back()->with([
                'messege'=>'Effect Inactive Successfully',
                'alert-type'=>'success'
            ]);
        }

        MyBeg::where('user_id',$user_id)->where('type',$type)->update(['status'=>0]);

        if(!$check_old_effect){
            $check_old_effect=new MyBeg;
            $check_old_effect->store_id=$id;
            $check_old_effect->user_id=$user_id;
        }

        $check_old_effect->status=1;
        $check_old_effect->active_time=Carbon\Carbon::now();
        $check_old_effect->expaire_time=Carbon\Carbon::now()->addDays(15);
        $check_old_effect->name=$check_effect->name;
        $check_old_effect->image=$check_effect->image;
        $check_old_effect->effect=$check_effect->effect;
        $check_old_effect->type=$check_effect->type;
        $check_old_effect->save();

        if($type === 1){
            $user->entry=$check_effect->effect;
        }else{
            $user->frame=$check_effect->effect;
        }
        $user->save();

        return Redirect()->back()->with([
                'messege'=>'Effect Active Successfully',
                'alert-type'=>'success'
            ]);
    }

    public function BrdPowerOff($id)
    {
      $user=User::find($id);
      $user->brd_off_power=0;
      $user->save();
       $notification=array(
                'messege'=>'Brd Power Off Successfully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }
    public function sceenshortOn($id)
    {
      $user=User::find($id);
      $user->sceen_short_power=1;
      $user->save();
       $notification=array(
                'messege'=>'Sceen Short On Successfully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    } 
    public function sceenshortOff($id)
    {
      $user=User::find($id);
      $user->sceen_short_power=0;
      $user->save();
       $notification=array(
                'messege'=>'Sceen Short Off Successfully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }
    public function OfficialIDOn($id)
    {
      $user=User::find($id);
      $user->is_official_id=1;
      $user->save();
       $notification=array(
                'messege'=>'Official ID Active  Successfully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    } 
    public function OfficialIDOff($id)
    {
      $user=User::find($id);
      $user->is_official_id=0;
      $user->save();
       $notification=array(
                'messege'=>'Official ID InActive Successfully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    } 
    public function KickPowerOn($id)
    {
      $user=User::find($id);
      $user->kick_power=1;
      $user->save();
       $notification=array(
                'messege'=>'Kick On Successfully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    } 
    public function KickPowerOff($id)
    {
      $user=User::find($id);
      $user->kick_power=0;
      $user->save();
       $notification=array(
                'messege'=>'Kick Off Successfully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }
    public function CommentMuteOn($id)
    {
      $user=User::find($id);
      $user->comment_mute_power=1;
      $user->save();
       $notification=array(
                'messege'=>'Comment Mute On Successfully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    } 
    public function CommentMuteOff($id)
    {
      $user=User::find($id);
      $user->comment_mute_power=0;
      $user->save();
       $notification=array(
                'messege'=>'Comment Mute Off Successfully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }
    public function invisibalOn($id)
    {
      $user=User::find($id);
      $user->is_invisible=1;
      $user->save();
       $notification=array(
                'messege'=>'Invisibal On Successfully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    } public function invisibalOff($id)
    {
      $user=User::find($id);
      $user->is_invisible=0;
      $user->save();
       $notification=array(
                'messege'=>'Invisibal Off Successfully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }
    public function User()
    {
        $users=User::where('balance','!=',0)->whereNotIn('id', [23825, 23826, 23827])->orderby('balance','desc')->get();
        return view('backend.profile.user_balance_list',compact('users'));
    }
    public function Rank()
    {
        $now = Carbon\Carbon::now();
    
        $limit = (int) request()->get('limit', 300);
        $limit = max(50, min($limit, 1000));
    
        $currentStart  = $now->copy()->startOfMonth()->startOfDay()->toDateTimeString();
        $currentEnd    = $now->copy()->endOfMonth()->endOfDay()->toDateTimeString();
    
        $previousStart = $now->copy()->subMonth()->startOfMonth()->startOfDay()->toDateTimeString();
        $previousEnd   = $now->copy()->subMonth()->endOfMonth()->endOfDay()->toDateTimeString();
    
        $cacheKey = 'admin_rank_v4_' . $now->format('Ym') . '_' . $limit;
    
        $data = Cache::remember($cacheKey, now()->addMinutes(3), function () use (
            $currentStart,
            $currentEnd,
            $previousStart,
            $previousEnd,
            $limit
        ) {
            return [
                'totalSands' => $this->rankByUser('sander_id', $currentStart, $currentEnd, $limit),
                'totalReciveds' => $this->rankByUser('reciever_id', $currentStart, $currentEnd, $limit),
                'totalfamillyReciveds' => $this->rankByFamily($currentStart, $currentEnd, $limit),
    
                'previous_totalSands' => $this->rankByUser('sander_id', $previousStart, $previousEnd, $limit),
                'previous_totalReciveds' => $this->rankByUser('reciever_id', $previousStart, $previousEnd, $limit),
                'previous_totalfamillyReciveds' => $this->rankByFamily($previousStart, $previousEnd, $limit),
            ];
        });
    
        return view('backend.profile.rankingList')->with($data);
    }
    
    private function rankByUser($column, $startDate, $endDate, $limit = 5000)
    {
        $giftTable = (new Gift)->getTable();
    
        return Gift::query()
            ->join('users', $giftTable . '.' . $column, '=', 'users.id')
            ->whereBetween($giftTable . '.date', [$startDate, $endDate])
            ->groupBy($giftTable . '.' . $column, 'users.id', 'users.name', 'users.profile')
            ->selectRaw(
                $giftTable . '.' . $column . ', 
                SUM(' . $giftTable . '.value) as total_sand, 
                users.name, 
                users.id, 
                users.profile'
            )
            ->orderByDesc('total_sand')
            ->limit($limit)
            ->get();
    }
    
    private function rankByFamily($startDate, $endDate, $limit = 500)
    {
        $giftTable = (new Gift)->getTable();
        $hostDataTable = (new HostData)->getTable();
    
        return Gift::query()
            ->leftJoin($hostDataTable, $giftTable . '.reciever_id', '=', $hostDataTable . '.user_id')
            ->join('agencies', function ($join) use ($giftTable, $hostDataTable) {
                $join->on(
                    'agencies.code',
                    '=',
                    DB::raw('COALESCE(' . $hostDataTable . '.agency_code, ' . $giftTable . '.agency_code)')
                );
            })
            ->whereBetween($giftTable . '.date', [$startDate, $endDate])
            ->groupBy('agencies.code', 'agencies.name', 'agencies.logo')
            ->selectRaw(
                'SUM(' . $giftTable . '.value) as total_sand, 
                agencies.code, 
                agencies.name, 
                agencies.logo'
            )
            ->orderByDesc('total_sand')
            ->limit($limit)
            ->get();
    }
    public function Update(Request $request,$id)
    {
      if($request->hasFile('profile')){
                $image_url = $this->storeProfileImage($request->file('profile'));
            }else{
                $image_url = $request->old_profile;
            }
            $user=User::find($id);
            $user->name=$request->name;
            if($request->teg){
            $user->host_badge=$request->teg;
            }else{
              $user->host_badge=0;  
            }
            if($request->top_value){
            $user->top_value=$request->top_value;
            }
            $user->profile=$image_url;
            $user->save();
            $notification=array(
                'messege'=>'Profile Update Successfully',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }

    private function storeProfileImage($file): string
    {
        if (!$file || !$file->isValid()) {
            throw new \RuntimeException('Invalid profile image upload.');
        }

        $directory = base_path('store/profile');
        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true, true);
        }

        $fileName = Str::random(40).'.webp';
        $image = Image::make($file->getRealPath())->orientate()->fit(700, 700);
        $this->saveOptimizedWebp($image, $directory.DIRECTORY_SEPARATOR.$fileName);

        return 'store/profile/'.$fileName;
    }

    private function saveOptimizedWebp($image, string $absolutePath): void
    {
        foreach ([88, 82, 76, 70, 64, 58, 52] as $quality) {
            $image->encode('webp', $quality)->save($absolutePath);
            if (File::exists($absolutePath) && File::size($absolutePath) <= 102400) {
                return;
            }
        }

        while (File::exists($absolutePath) && File::size($absolutePath) > 102400 && $image->width() > 500) {
            $next = max(500, (int) floor($image->width() * 0.9));
            $image->resize($next, $next, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $image->encode('webp', 58)->save($absolutePath);
        }
    }
    public function ChangeHostingType($id)
    {
        $data=HostData::find($id);
        if($data){
            if($data->hosting_type==2){
                $data->hosting_type=1;
            }else{
                $data->hosting_type=2;
            }
            $data->save();
             $notification=array(
                'messege'=>'Hosting Type Change Successfully',
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
     public function DeviceBan($id)
    {
        $data=User::find($id);
        if($data){
            $ban_device=new BanDevice;
            $ban_device->device_id=$data->device_id;
            $ban_device->save();
             $notification=array(
                'messege'=>'Device Banned Successfully',
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
    public function Pending()
    {
      $data=ProfilePending::all();
      return view('backend.profile.pending',compact('data'));
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
      public function ChangePass(Request $request)
    {
        $data=User::find(Auth::id());
        $data->password=Hash::make($request->password);
        $data->save();
        $notification=array(
            'messege'=>'Password change successfull!',
           'alert-type'=>'success'
       );
        return redirect()->back()->with($notification);
    }
     public function TopPosition($id)
    {
        $data=User::find($id);
        if($data->prosss_top==1){
          $data->prosss_top=0; 
          $data->top_value=0; 
        }else{
         $data->prosss_top=1;
         $data->top_value=1500000;
        }
        
       
        $data->save();
        $notification=array(
            'messege'=>'Top Position Changed!',
           'alert-type'=>'success'
       );
        return redirect()->back()->with($notification);
    }
    public function ProtalActive($id)
    {
        $data=User::find($id);
        $data->is_coin_protal_active=1;
        $data->save();
        $notification=array(
            'messege'=>'Protal Active Successfully',
           'alert-type'=>'success'
       );
        return redirect()->back()->with($notification);
    }public function ProtalReject($id)
    {
        $data=User::find($id);
        $data->is_coin_protal_active=0;
        $data->save();
        $notification=array(
            'messege'=>'Protal Active Successfully',
           'alert-type'=>'success'
       );
        return redirect()->back()->with($notification);
    }
    
    public function AddDayTime(Request $request,$id)
    {
        $data=new DayTime;
        $data->user_id=$id;
        $data->channelName=$request->_token;
        $data->live_time=$request->date;
        $data->day_times=$request->time;
        $data->brd_type=$request->brd_type;
        $data->save();
        $notification=array(
            'messege'=>'Day Added  Successfully',
           'alert-type'=>'success'
       );
        return redirect()->back()->with($notification);
    }
}
