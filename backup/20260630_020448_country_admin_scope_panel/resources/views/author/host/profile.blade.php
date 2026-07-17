@extends('author.layouts.main')
@section('content')
<style type="text/css">
	.resume {
    background-color: #D5F5E3;
}
.card-header {
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    background-image: url(../img/profile-bg.jpg);
    background-size: cover;
    background-position: center center;
    padding: 30px 15px;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
}
</style>

<div class="body-content container-fluid flex-grow-1 container-p-y">
	 <div class="card mb-4">
        <div class="card-body">
	<div class="row">
   <div class="col-sm-12 col-md-4 employee-cv">
      <div class="card-header resume">
         <div><img src="{{URL::to($user->profile)}}" style=" border-radius: 50%; " width="100px;" height="100px;" class="img-circle"></div>
      </div>
      <div class="card-content">
         <div class="card-content-member">
            <h4 class="m-t-0">Name : {{ $user->name }}</h4>
            <h5> ID :{{$user->id}}</h5>
            <p class="m-0"><i class="fa fa-mobile" aria-hidden="true"></i>
               {{number_format($user->balance)}}
            </p>
         </div>
         <div class="card-content-languages">
            <div class="card-content-languages-group"></div>
            <div class="card-content-languages-group">
               <table class="table table-hover" width="100%">
                  <caption class="resumecaption">Agency Information</caption>
                  <tbody>
                     <tr>
                        <th>Lavel</th>
                        <td>{{$user->level}}</td>
                     </tr>
                     <tr>
                        <th>Email</th>
                        <td> {{$user->email}}</td>
                     </tr>
                     @if($info)
                      <tr>
                        <th>Nid</th>
                        <td> {{$info->nid}}</td>
                     </tr>
                     <tr>
                        <th>Phone</th>
                        <td> {{$info->phone}}</td>
                     </tr>
                     @endif
                     <tr>
                        <th>Vip Lavel</th>
                        <td>{{$user->is_vip}}</td>
                     </tr>
                     <tr>
                        <th>Entry </th>
                        <td>{{$user->entry_level}}</td>
                     </tr> 
                      @php
                     $contry=App\Models\Country::find($user->country_id);
                     @endphp
                     <tr>
                        <th>Country</th>
                        <td>@if($contry) {{$contry->name}} @endif</td>
                     </tr>
                    
                  </tbody>
               </table>
            </div>
						
            	 @if($agency_info)
            <div class="card-content-languages-group">
               <table class="table table-hover" width="100%">
                 
                  <tbody>
                     <tr>
                        <th>Join Agency Name</th>
                        <td> {{$agency_info->name}}</td>
                     </tr>
                     <tr>
                        <th>Code</th>
                        <td>{{$agency_info->code}}</td>
                     </tr>
                     <tr>
                        <th>Agency Phone</th>
                        <td>{{$agency_info->phone}}</td>
                     </tr>

                  </tbody>
               </table>
            </div>
               @endif
@php
 

    $userId = $user->id;

        $startDate = "2023-06-16";
        $endDate = "2023-06-31";
  
    
    $type = DB::table('users')
        ->join('host_data', 'host_data.user_id', 'users.id')
        ->where('users.id', $userId)
        ->select('host_data.hosting_type')
        ->first();
    
    if ($type) {
        $durationss = DB::table('day_times')
            ->where('user_id', $userId)
            ->where('live_time', '>=', $startDate)
            ->where('live_time', '<=', $endDate)
            ->where('brd_type', $type->hosting_type)
            ->where('day_times', '>', '00:19:59')
            ->select('day_times')
            ->get();
    
        $totalDurationlst = Carbon\Carbon::createFromTime(0, 0, 0);
    
        foreach ($durationss as $duration) {
            $parts = explode(':', $duration->day_times);
    
            $hours = intval($parts[0]);
            $minutes = intval($parts[1]);
            $seconds = intval($parts[2]);
    
            $interval = new DateInterval("PT{$hours}H{$minutes}M{$seconds}S");
            $totalDurationlst->add($interval);
        }
    
        $totalDuratiodnFormatted = $totalDurationlst->format('H:i:s');
    
        $dayCount = DB::table('day_times')
            ->where('user_id', $userId)
            ->where('live_time', '>=', $startDate)
            ->where('live_time', '<=', $endDate)
            ->where('day_times', '>', '00:19:59')
            ->where('brd_type', $type->hosting_type)
            ->select('live_time', 'user_id')
            ->groupBy('live_time', 'user_id')
            ->get()
            ->count();
    
        $totalCoin = DB::table('gifts')
            ->join('users', 'users.id', 'gifts.sander_id')
            ->where('gifts.reciever_id', $userId)
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->select('users.profile', 'users.name', 'gifts.value')
            ->sum('value');
    
        $dayTimeHistory = DB::table('day_times')
            ->where('user_id', $userId)
            ->where('live_time', '>=', $startDate)
            ->where('live_time', '<=', $endDate)
            ->get();
    }
@endphp


               @if($type)
            <div class="card-content-languages-group">
               <table class="table table-hover" width="100%">
                 <caption class="resumecaption">Live Data Last Round</caption>
                  <tbody>
                     <tr>
                        <th>Day</th>
                        <td> {{$dayCount}}</td>
                     </tr>
                     <tr>
                        <th>Time</th>
                        <td>{{$totalDuratiodnFormatted}}</td>
                     </tr>
                     <tr>
                        <th>Point</th>
                        <td>{{number_format($totalCoin)}}</td>
                     </tr>

                  </tbody>
               </table>
            </div>
               @endif
         </div>
       
      </div>
   </div>
   <div class="col-sm-12 col-md-8 employee-cv-info">
      <div class="row">
      	@if($user->is_coin_protal_active==1)
         <div class="col-sm-12 col-md-12 rating-block">
            <table class="table table-hover" width="100%">
               <caption class="resumecaption">Protal Active</caption>
               <tbody>
                  <tr>
                     <th>Recharge</th>
                     <td>{{number_format($protal_recharge)}}</td>
                  </tr>
                  <tr>
                     <th>Transfer</th>
                     <td> {{number_format($protal_transfer)}}</td>
                  </tr>
                  <tr>
                     <th>Recall</th>
                     <td>{{number_format($recall_protal_recharge)}}</td>
                  </tr>
                  <tr>
                     <th>Balance</th>
                     <td>{{number_format($protal_recharge-($protal_transfer-$recall_protal_recharge))}}</td>
                  </tr>
                  
               </tbody>
            </table>
         </div>	
         @endif		
         <div class="col-sm-12 col-md-12 rating-block">
         	 @if($agency)
            <table class="table table-hover" width="100%">
               <caption class="resumecaption">Agency Woner</caption>
               <tbody>
                  <tr>
                     <th><b>Name: </b> </th>
                     <td>{{$agency->name}}</td>
                  </tr>
                  <tr>
                     <th>Code</th>
                     <td>{{$agency->code}}</td>
                  </tr>
                  <tr>
                     <th>Phone</th>
                     <td> {{$agency->phone}}</td>
                  </tr>
               </tbody>
            </table>
            @endif
         </div>
         @php
                          $date= Carbon\Carbon::now('Europe/London'); // Replace this with your desired date
                            $user_id=$user->id;
     
                    if ($date->day <= 15) {
                             $start_date = date('Y-m') . '-01';
                             $end_date = date('Y-m') . '-15';
                             }else{
                             $start_date = date('Y-m') . '-16';
                             $end_date = date('Y-m') . '-31';
                             }
                             $type = DB::table('users')
                            ->join('host_data', 'host_data.user_id', 'users.id')
                            ->where('users.id', $user_id)
                            ->select('host_data.hosting_type','host_data.id')
                            ->first();

                                if ($type) {
                                	$durations = DB::table('day_times')
                    				->where('user_id', $user_id)
                    				->where('live_time', '>=', $start_date)
                                    ->where('live_time', '<=', $end_date)
                    				->where('brd_type',$type->hosting_type)
                    				->where('day_times', '>', '00:19:59')
                    				->select('day_times')
                    				->get();
                    
                    
                    
                    	        $totalDuration = Carbon\Carbon::createFromTime(0, 0, 0);
                    
                    	        foreach ($durations as $duration) {
                    				$parts = explode(':', $duration->day_times);
                    
                    				$hours = intval($parts[0]);
                    				$minutes = intval($parts[1]);
                    				$seconds = intval($parts[2]);
                    
                    				$interval = new DateInterval("PT{$hours}H{$minutes}M{$seconds}S");
                    				$totalDuration->add($interval);
                    	        }
                    
                    	    $totalDurationFormatted = $totalDuration->format('H:i:s');
                    
                    	          
                                    
                    				$total_coin= DB::table('gifts')->join('users','users.id','gifts.sander_id')->where('gifts.reciever_id',$user_id)->whereDate('date', '>=', $start_date)
                                    ->whereDate('date', '<=', $end_date)->select('gifts.date','gifts.value')->sum('gifts.value');
                                    
                                    $day_time_hostory = DB::table('day_times')
                    				->where('user_id', $user_id)
                    				->where('live_time', '>=', $start_date)
                                    ->where('live_time', '<=', $end_date)
                                    ->orderby('id','desc')
                    				->get();
                    				
                    				
               

                                  $day_time_duration = DB::table('day_times')
                                        ->where('user_id', $user_id)
                                        ->where('live_time', '>=', $start_date)
                                        ->where('live_time', '<=', $end_date)
                                        ->where('brd_type', $type->hosting_type)
                                        ->where('day_times', '>', '00:19:59')
                                        ->select('live_time', 'day_times')
                                        ->get();
                                    
                                    $day_count = 0;
                                    $current_date = null;
                                    $total_duration = 0;
                                    
                                    foreach ($day_time_duration as $day_time_duration) {
                                        $date = Carbon\Carbon::parse($day_time_duration->live_time)->toDateString();
                                        $time = $day_time_duration->day_times;
                                    
                                        if ($current_date === null || $current_date !== $date) {
                                            // Check if the previous day's total duration exceeds 01:01:00
                                            if ($current_date !== null && $total_duration >= 3660) { // 3660 seconds = 1 hour 1 minute
                                                $day_count++;
                                            }
                                    
                                            $current_date = $date;
                                            $total_duration = 0;
                                        }
                                    
                                        $duration_parts = explode(':', $time);
                                        $hours = intval($duration_parts[0]);
                                        $minutes = intval($duration_parts[1]);
                                        $seconds = intval($duration_parts[2]);
                                        $total_duration += ($hours * 3600) + ($minutes * 60) + $seconds;
                                    }
                                    
                                    // Check the total duration of the last date
                                    if ($total_duration >= 3660) { // 3660 seconds = 1 hour 1 minute
                                        $day_count++;
                                    }
                    				}
			              
         @endphp

		
         	 @if($type)
         <div class="col-sm-12 col-md-12 rating-block">
            <table class="table table-hover" width="100%">
               <caption class="resumecaption">Live Data</caption>
               <tbody>
                  <tr>
                     <th><b>Hosting Type </b> </th>
                     <td> @if($type->hosting_type==2) Video @else Audio @endif @if($type->hosting_type==2) Make Audio @else Make Video @endif</a></td>
                  </tr>
                  <tr>
                     <th>Day</th>
                     <td>{{$day_count}}</td>
                  </tr>
                  <tr>
                     <th>Time</th>
                     <td> {{$totalDurationFormatted}}</td>
                  </tr>
                  <tr>
                     <th>Point Collect</th>
                     <td> {{number_format($total_coin)}}</td>
                  </tr>
               </tbody>
            </table>
         </div>
            @endif


         <div class="col-sm-12 col-md-12 rating-block">
            <table class="table table-hover" width="100%">
               <caption class="resumecaption">Power Button</caption>
               <tbody>
                  
                  <tr>
                     <th>Hosting ID</th>
                     <td> 
                    @if($user->is_host_id!=1)
					<a href="{{route('author.host.active', ['id' => $user->id])}}" class="btn btn-sm btn-success" ><span class="fa fa-check"></span>Host Active</a>
					@else
					<a href="{{route('author.host.active', ['id' => $user->id])}}" class="btn btn-sm btn-danger" ><span class="fa fa-close"></span>Host Reject</a>
					@endif
                     </td>
                  </tr>
                  
               </tbody>
            </table>
         </div>
          
      </div>
   </div>
</div>
	
	
</div>
	@if($info)
            <div class="body-content">
			 <div class="row">
		<div class="col-xl-4 col-sm-4 py-2">
               	<div class="card ">
			 		<div class="card-body">
			 		
                    <img style=" width: 80%; " src="{{URL::to($info->image)}}">
                </div>
            </div>
		</div>
		<div class="col-xl-4 col-sm-4 py-2">
               	<div class="card ">
			 		<div class="card-body">
                    <img style=" width: 80%; " src="{{URL::to($info->photo_id)}}">
                </div>
            </div>
		</div>
		<div class="col-xl-4 col-sm-4 py-2">
               	<div class="card ">
			 		<div class="card-body">
                    <img style=" width: 80%; " src="{{URL::to($info->selfie)}}">
                </div>
            </div>
		</div>
	</div>
</div>
@endif
@if($user->is_coin_protal_active==1)
<div class="body-content">
	
	<div class="row">

		<div class="col-xl-12 col-sm-12 py-2">
			<div class="card mb-4">
				<div class="card-header">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="fs-17 font-weight-600 mb-0">Protal History</h6>
						</div>
						
					</div>
				</div>
				<div class="card-body">
					
					<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
						
						<li class="nav-item">
							<a class="nav-link active show" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="true">Recharge </a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Transfer</a>
						</li>
						
					</ul>
					<div class="tab-content" id="pills-tabContent">
						
						<div class="tab-pane fade active show" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
						<table class="table display table-bordered table-striped table-hover basic">
			                    <thead>
			                      <tr>
			                       <th>Sl</th>
			                       <th>ID</th>
			                       <th>Date</th>
			                       <th>Approved By</th>
			                       <th>Amount</th>
			                     
			                   </tr>
			               </thead>
			                 <tbody>
			                    @php
			                    $i=0;
			                    $total_potal_history=0;
			                    @endphp
			                    @foreach($protal_recharge_details as $protal_recharge_detail)
			                    @php
			                    $approved_by=App\Models\User::find($protal_recharge_detail->recharge_by);
			                    @endphp
			                    <tr>
			                      <td>{{ ++$i }}</td>
			                      <td>{{$protal_recharge_detail->trxid}}  </td>
			              
			                      <td>{{$protal_recharge_detail->date}}  </td>
			                      <td>@if($approved_by){{$approved_by->name}} @else  @endif </td>
			                      <td>{{$protal_recharge_detail->amount}}  </td>
			                      
			                      
			                  </tr>
			                  @php
			                  $total_potal_history+=$protal_recharge_detail->amount;
			                  @endphp
			                  @endforeach
			              </tbody>
			              <tfoot>
			                <tr>
			                  <th>Sl</th>
			                  <th>ID</th>
			                  <th>Date</th>
			                  <th>Approved By</th>
			                  <th>{{$total_potal_history}}</th>
			                
			               </tr>
			           </tfoot>
			       </table>
						</div>
						<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
							<table class="table display table-bordered table-striped table-hover basic">
			                    <thead>
			                      <tr>
			                       <th>Sl</th>
			                       <th>ID</th>
			                       <th>Date</th>
			                       <th>Recived By</th>
			                       <th>Amount</th>
			                     
			                   </tr>
			               </thead>
			                 <tbody>
			                    @php
			                    $i=0;
			                    $transer=0;
			                    @endphp
			                    @foreach($protal_transfer_details as $protal_transfer_detail)
			                    
			                    <tr>
			                      <td>{{ ++$i }}</td>
			                      <td>{{$protal_transfer_detail->trxid}}  </td>
			              
			                      <td>{{$protal_transfer_detail->date}}  </td>
			                      <td>{{$protal_transfer_detail->user_id}}  </td>
			                      
			                      <td>{{$protal_transfer_detail->amount}}  </td>
			                      
			                      
			                  </tr>
			                  @php
			                  $transer+=$protal_transfer_detail->amount;
			                  @endphp
			                  @endforeach
			              </tbody>
			              <tfoot>
			                <tr>
			                  <th>Sl</th>
			                  <th>ID</th>
			                  <th>Date</th>
			                  <th>Recived By</th>
			                  <th>{{$transer}}</th>
			                 
			               </tr>
			           </tfoot>
			       </table>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>
@endif
@if($agency)
@php
$host_lists=DB::table('host_data')->join('users','users.id','host_data.user_id')->where('agency_code',$agency->code)->get();
@endphp
<div class="body-content">
	
	<div class="row">

		<div class="col-xl-12 col-sm-12 py-2">
			<div class="card mb-4">
				<div class="card-header">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="fs-17 font-weight-600 mb-0">Host Data</h6>
						</div>
						
					</div>
				</div>
				<div class="card-body">
					
					 <table class="table display table-bordered table-striped table-hover basic">
			                    <thead>
			                      <tr>
			                       <th>Sl</th>
			                       <th>ID</th>
			                       <th>Name</th>
			                       <th>Balance</th>
			                       <th>Day Time</th>
			                       <th>Phone Number</th>
			                     
			                   </tr>
			               </thead>
			                 <tbody>
			                    @php
			                    $i=0;
			                    @endphp
			                    @foreach($host_lists as $host_list)
			                     @php
		                         $date = Carbon\Carbon::now(); // Replace this with your desired date
                            $user_id=$host_list->id;
               
                     $host_start_date = 2023-06-16;
                             $host_end_date = 2023-06-31;
                             $host_type = DB::table('users')
                            ->join('host_data', 'host_data.user_id', 'users.id')
                            ->where('users.id', $user_id)
                            ->select('host_data.hosting_type','host_data.id')
                            ->first();

                                if ($host_type) {
                                	$durations = DB::table('day_times')
                    				->where('user_id', $user_id)
                    				->where('live_time', '>=', $host_start_date)
                                    ->where('live_time', '<=', $host_end_date)
                    				->where('brd_type',$host_type->hosting_type)
                    				->where('day_times', '>', '00:19:59')
                    				->select('day_times')
                    				->get();
                    
                    
        
                    	        $totalDuration = Carbon\Carbon::createFromTime(0, 0, 0);
                    
                    	        foreach ($durations as $duration) {
                    				$parts = explode(':', $duration->day_times);
                    
                    				$hours = intval($parts[0]);
                    				$minutes = intval($parts[1]);
                    				$seconds = intval($parts[2]);
                    
                    				$interval = new DateInterval("PT{$hours}H{$minutes}M{$seconds}S");
                    				$totalDuration->add($interval);
                    	        }
                    
                    	    $totalDurationFormatted = $totalDuration->format('H:i:s');
                    
                    	          
                                    
                    				$total_coin= DB::table('gifts')->join('users','users.id','gifts.sander_id')->where('gifts.reciever_id',$user_id)->where('date', '>=', $host_start_date)
                                    ->where('date', '<=', $host_end_date)->select('users.profile','users.name','gifts.value')->sum('value');
                                    
                                    $day_time_hostory = DB::table('day_times')
                    				->where('user_id', $user_id)
                    				->where('live_time', '>=', $host_start_date)
                                    ->where('live_time', '<=', $host_end_date)
                                    ->orderby('id','desc')
                    				->get();
                    				
                    				
               

                                  $day_time_duration = DB::table('day_times')
                                        ->where('user_id', $user_id)
                                        ->where('live_time', '>=', $host_start_date)
                                        ->where('live_time', '<=', $host_end_date)
                                        ->where('brd_type', $host_type->hosting_type)
                                        ->where('day_times', '>', '00:19:59')
                                        ->select('live_time', 'day_times')
                                        ->get();
                                    
                                    $day_count = 0;
                                    $current_date = null;
                                    $total_duration = 0;
                                    
                                    foreach ($day_time_duration as $day_time_duration) {
                                        $date = Carbon\Carbon::parse($day_time_duration->live_time)->toDateString();
                                        $time = $day_time_duration->day_times;
                                    
                                        if ($current_date === null || $current_date !== $date) {
                                            // Check if the previous day's total duration exceeds 01:01:00
                                            if ($current_date !== null && $total_duration >= 3660) { // 3660 seconds = 1 hour 1 minute
                                                $day_count++;
                                            }
                                    
                                            $current_date = $date;
                                            $total_duration = 0;
                                        }
                                    
                                        $duration_parts = explode(':', $time);
                                        $hours = intval($duration_parts[0]);
                                        $minutes = intval($duration_parts[1]);
                                        $seconds = intval($duration_parts[2]);
                                        $total_duration += ($hours * 3600) + ($minutes * 60) + $seconds;
                                    }
                                    
                                    // Check the total duration of the last date
                                    if ($total_duration >= 3660) { // 3660 seconds = 1 hour 1 minute
                                        $day_count++;
                                    }
                    				}
			                    @endphp
			                  //  {{$day_time_hostory}}
			                    <tr>
			                      <td>{{ ++$i }}</td>
			                      <td>{{$host_list->id}}  </td>
			              
			                      <td>{{$host_list->name}}  </td>
			                      <td>{{$host_list->balance}}  </td>
			                      <td>Day : {{$day_count}} <br>Time : {{$totalDurationFormatted}} </td>
			                      <td>{{$host_list->phone}}  </td>
			                      <td>
			                          <a href="#" class="btn btn-sm btn-success" ><span class="fa fa-eye"></span> View</a>
			                          <a href="#" class="btn btn-sm btn-danger" ><span class="fa fa-times"></span> Inactive</a>
			                      </td>
			                      
			                  </tr>
			                  @endforeach
			              </tbody>
			              <tfoot>
			                <tr>
			                 <th>Sl</th>
			                       <th>ID</th>
			                       <th>Name</th>
			                       <th>Balance</th>
			                       <th>Phone Number</th>
			                     
			               </tr>
			           </tfoot>
			       </table>
					
				</div>
			</div>
		</div>
		
	</div>
</div>
@endif

@if($game_history)

<div class="body-content">
	
	<div class="row">

		<div class="col-xl-12 col-sm-12 py-2">
			<div class="card mb-4">
				<div class="card-header">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="fs-17 font-weight-600 mb-0">Game History</h6>
						</div>
						
					</div>
				</div>
				<div class="card-body">
					
					 <table class="table display table-bordered table-striped table-hover basic">
			                    <thead>
			                      <tr>
			                       <th>Sl</th>
			                       <th>Time</th>
			                       <th>Tray ID</th>
			                       <th>Game Name</th>
			                       <th>Pots</th>
			                       <th>Amount</th>
			                       <th>Status</th>
			                   </tr>
			               </thead>
			                 <tbody>
			                    @php
			                    $i=0;
			                    @endphp
			                    @foreach($game_history as $game)
			                   
			                    <tr>
			                      <td>{{ ++$i }}</td>
			                      <td>{{$game->created_at}}  </td>
			                      <td>{{$game->tray_id}}  </td>
			                        @if($game->game_type=='firust')
			                      <td>fruits  </td>
			                      <td>@if($game->pot_no=='saven_win') <img src="{{asset('public/game/new/image')}}/lemon.png" style=" width: 48px; " alt="Saven Winner"> @elseif($game->pot_no=='watermelon')  <img  style=" width: 48px; "src="{{asset('public/game/new/image')}}/watermelon.png" alt="Saven Winner"> @else <img  style=" width: 48px; "src="{{asset('public/game/new/image')}}/apple.png" alt="Saven Winner"> @endif  </td>
			                      @else
			                       <td>Five Star </td>
			                      <td>@if($game->pot_no=='saven_win') <img src="{{asset('public/game/fivestar/image')}}/lemon.png" style=" width: 48px; " alt="Saven Winner"> @elseif($game->pot_no=='watermelon')  <img  style=" width: 48px; "src="{{asset('public/game/fivestar/image')}}/watermelon.png" alt="Saven Winner"> @else <img  style=" width: 48px; "src="{{asset('public/game/fivestar/image')}}/apple.png" alt="Saven Winner"> @endif  </td>
			                    
			                      @endif
			                      <td>{{$game->amount}}  </td>
			                      <td>@if($game->status==0) Hold @elseif($game->status==1) Win @else Loss @endif </td>
			                  </tr>
			                  @endforeach
			              </tbody>
			              <tfoot>
			                <tr>
			                       <th>Sl</th>
			                       <th>Tray ID</th>
			                       <th>Game Name</th>
			                       <th>Pots</th>
			                       <th>Amount</th>
			                       <th>Status</th>
			               </tr>
			           </tfoot>
			       </table>
					
				</div>
			</div>
		</div>
		
	</div>
</div>
@endif

@if($type)

<div class="body-content">
	
	<div class="row">

		<div class="col-xl-12 col-sm-12 py-2">
			<div class="card mb-4">
				<div class="card-header">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="fs-17 font-weight-600 mb-0">Day Time History</h6>
						</div>
						
					</div>
				</div>
				<div class="card-body">
					
					 <table class="table display table-bordered table-striped table-hover basic">
			                    <thead>
			                      <tr>
			                       <th>Sl</th>
			                       <th>Channel Name</th>
			                       <th>Time</th>
			                       <th>Live Date</th>
			                       <th>Type</th>
			                   </tr>
			               </thead>
			                 <tbody>
			                    @php
			                    $i=0;
			                    @endphp
			                    @foreach($day_time_hostory as $day_time_h)
			                   
			                    <tr>
			                      <td>{{ ++$i }}</td>
			                      <td>{{$day_time_h->channelName}}  </td>
			              
			                      <td>{{$day_time_h->day_times}}  </td>
			                      <td>{{$day_time_h->live_time}}  </td>
			                      <td>@if($day_time_h->brd_type==2) Video @else Audio @endif  </td>
			                  </tr>
			                  @endforeach
			              </tbody>
			              <tfoot>
			                <tr>
			                 <th>Sl</th>
			                       <th>Channel Name</th>
			                       <th>Time</th>
			                       <th>Live Date</th>
			                       <th>Type</th>
			               </tr>
			           </tfoot>
			       </table>
					
				</div>
			</div>
		</div>
		
	</div>
</div>
@endif
@if($type)

<div class="body-content">
	
	<div class="row">

		<div class="col-xl-12 col-sm-12 py-2">
			<div class="card mb-4">
				<div class="card-header">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="fs-17 font-weight-600 mb-0">Day Time Last RoundHistory</h6>
						</div>
						
					</div>
				</div>
				<div class="card-body">
					
					 <table class="table display table-bordered table-striped table-hover basic">
			                    <thead>
			                      <tr>
			                       <th>Sl</th>
			                       <th>Channel Name</th>
			                       <th>Time</th>
			                       <th>Live Date</th>
			                       <th>Type</th>
			                   </tr>
			               </thead>
			                 <tbody>
			                    @php
			                    $i=0;
			                    @endphp
			                    @foreach($dayTimeHistory as $dayTimeHistory)
			                   
			                    <tr>
			                      <td>{{ ++$i }}</td>
			                      <td>{{$dayTimeHistory->channelName}}  </td>
			              
			                      <td>{{$dayTimeHistory->day_times}}  </td>
			                      <td>{{$dayTimeHistory->live_time}}  </td>
			                      <td>@if($dayTimeHistory->brd_type==2) Video @else Audio @endif  </td>
			                  </tr>
			                  @endforeach
			              </tbody>
			              <tfoot>
			                <tr>
			                 <th>Sl</th>
			                       <th>Channel Name</th>
			                       <th>Time</th>
			                       <th>Live Date</th>
			                       <th>Type</th>
			               </tr>
			           </tfoot>
			       </table>
					
				</div>
			</div>
		</div>
		
	</div>
</div>
@endif
@if($recharge_historys)

<div class="body-content">
	
	<div class="row">

		<div class="col-xl-12 col-sm-12 py-2">
			<div class="card mb-4">
				<div class="card-header">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="fs-17 font-weight-600 mb-0">Recharge History</h6>
						</div>
						
					</div>
				</div>
				<div class="card-body">
					
					<table class="table display table-bordered table-striped table-hover basic">
			                    <thead>
			                      <tr>
			                       <th>Sl</th>
			                       <th>Protal ID</th>
			                       <th>TxID</th>
			                       <th>Amount</th>
			                       <th>Date</th>
			                   </tr>
			               </thead>
			                 <tbody>
			                    @php
			                    $i=0;
			                    $recharge_history_total=0;
			                    @endphp
			                    @foreach($recharge_historys as $recharge_history)
			                    <tr>
			                      <td>{{ ++$i }}</td>
			                      <td>{{$recharge_history->portal_user_id}}  </td>
			                      <td>{{$recharge_history->trxid}}  </td>
			                      <td>{{$recharge_history->amount}}  </td>
			                      <td>{{$recharge_history->date}}  </td>
			                      
			                  </tr>
			                  @php
			                  $recharge_history_total+=$recharge_history->amount;
			                  @endphp
			                  @endforeach
			              </tbody>
			              <tfoot>
			                <tr>
			                 <th>Sl</th>
			                 <th>Reciver ID</th>
			                 <th>Gift Name</th>
			                 <th>{{$recharge_history_total}}</th>
			                 <th>Time</th> 
			               </tr>
			           </tfoot>
			       </table>
					
				</div>
			</div>
		</div>
		
	</div>
</div>
@endif
@if($sanding_historys)

<div class="body-content">
	
	<div class="row">

		<div class="col-xl-12 col-sm-12 py-2">
			<div class="card mb-4">
				<div class="card-header">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="fs-17 font-weight-600 mb-0">Gift Sanding History</h6>
						</div>
						
					</div>
				</div>
				<div class="card-body">
					
					<table class="table display table-bordered table-striped table-hover basic">
			                    <thead>
			                      <tr>
			                       <th>Sl</th>
			                       <th>Reciver ID</th>
			                       <th>Gift Name</th>
			                       <th>Gift Amount</th>
			                       <th>Time</th>
			                      
			                   </tr>
			               </thead>
			                 <tbody>
			                    @php
			                    $i=0;
			                    $sanding_history_total=0;
			                    @endphp
			                    @foreach($sanding_historys as $sanding_history)
			                    <tr>
			                      <td>{{ ++$i }}</td>
			                      <td>{{$sanding_history->reciever_id}}  </td>
			                      <td>{{$sanding_history->name}}  </td>
			                      <td>{{$sanding_history->value}}  </td>
			                      <td>{{$sanding_history->date}}  </td>
			                      
			                      
			                  </tr>
			                  @php
			                  $sanding_history_total+=$sanding_history->value;
			                  @endphp
			                  @endforeach
			              </tbody>
			              <tfoot>
			                <tr>
			                 <th>Sl</th>
			                 <th>Reciver ID</th>
			                 <th>Gift Name</th>
			                 <th>{{$sanding_history_total}}</th>
			                 <th>Time</th> 
			                 
			               </tr>
			           </tfoot>
			       </table>
					
				</div>
			</div>
		</div>
		
	</div>
</div>
@endif
@if($reciving_historys)

<div class="body-content">
	
	<div class="row">

		<div class="col-xl-12 col-sm-12 py-2">
			<div class="card mb-4">
				<div class="card-header">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="fs-17 font-weight-600 mb-0">Gift Recived History</h6>
						</div>
						
					</div>
				</div>
				<div class="card-body">
					
					 <table class="table display table-bordered table-striped table-hover basic">
			                    <thead>
			                      <tr>
			                       <th>Sl</th>
			                       <th>Reciver ID</th>
			                       <th>Gift Name</th>
			                       <th>Gift Amount</th>
			                       <th>Time</th>
			                       
			                   </tr>
			               </thead>
			                 <tbody>
			                    @php
			                    $i=0;
			                    $reciving_history_total=0;
			                    @endphp
			                    @foreach($reciving_historys as $reciving_history)
			                    <tr>
			                      <td>{{ ++$i }}</td>
			                      <td>{{$reciving_history->sander_id}}  </td>
			                      <td>{{$reciving_history->name}}  </td>
			                      <td>{{$reciving_history->value}}  </td>
			                      <td>{{$reciving_history->date}}  </td>
			                   
			                      
			                  </tr>
			                   @php
			                  $reciving_history_total+=$reciving_history->value;
			                  @endphp
			                  @endforeach
			              </tbody>
			              <tfoot>
			                <tr>
			                 <th>Sl</th>
			                 <th>Reciver ID</th>
			                 <th>Gift Name</th>
			                 <th>{{$reciving_history_total}}</th>
			                 <th>Time</th> 
			             
			               </tr>
			           </tfoot>
			       </table>
					
				</div>
			</div>
		</div>
		
	</div>
</div>
@endif
</div>
</div>
@endsection