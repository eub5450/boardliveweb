@extends('backend.layouts.main')


@section('title')
Agency List
@endsection
@section('content')
<!--Content Start-->
<div class="body-content">
  <div class="card mb-4">
    <div class="card-body">
      <section class="forms">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h4> Withdraw List</h4>
                </div>
                <div class="table-responsive">
                  <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                      <tr>
                       <th>Sl</th>
                       <th>ID</th>
                       <th>Profile</th>
                       <th>Name</th>
                       <th>Basic Points</th>
                       <th>Agency Profit</th>
                       <th>Apps Profit</th>
                       <th>Total Points</th>
                       <th>Agency</th>
                       <th>Super Admin</th>
                       <th>Withdraw Type</th>
                       <th>Date</th>
                       <th>Status</th>
                     </tr>
                   </thead>
                   <tbody>
                    @php
                    $i=0;
                    $total_basic=0;
                    $total_agency_profit=0;
                    $total_apps_profit=0;
                    $total_points=0;
                    @endphp
                    @foreach($data as $row)
                    @php
                    $user=App\Models\User::where('id',$row->host_id)->first();
                    $agency=App\Models\Agency::where('user_id',$row->agency_id)->first();
                    $super_agency=App\Models\Agency::where('user_id',$row->super_agency_id)->first();
                    
                    @endphp
                    <tr>
                      <td>{{ ++$i }}</td>
                      <td>  {{$user->id}}</td>
                      <td> <img style="width: 73px;" src="{{URL::to($user->profile)}}"></td>
                      <td>  {{$user->name}}</td>
                      <td>  {{$row->basic_coin}}</td>
                      <td>  {{$row->agency_profit}}</td>
                      <td>  {{$row->apps_profit}}</td>
                      <td>  {{$row->total}}</td>
                      
                      <td>@if($agency) {{$agency->name}}-{{$agency->code}}@endif</td>
                      <td>@if($super_agency) {{$super_agency->name}}-{{$super_agency->code}}@endif</td>
                      <td>@if($row->is_super_agency_withdraw==1) Super Admin @else Agency @endif</td>
                      <td>@if($row->status==1) Approved @else Pending @endif</td>
                      <td>  {{$row->date}}</td>
                    </tr>
                    @php
                    $total_basic+=$row->basic_coin;
                    $total_agency_profit+=$row->agency_profit;
                    $total_apps_profit+=$row->apps_profit;
                    $total_points+=$row->total;
                    @endphp
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Sl</th>
                       <th>ID</th>
                       <th>Profile</th>
                       <th>Name</th>
                       <th>{{$total_basic}}</th>
                       <th>{{$total_agency_profit}}</th>
                       <th>{{$total_apps_profit}}</th>
                       <th>{{$total_points}}</th>
                       <th>Agency</th>
                       <th>Super Admin</th>
                       <th>Withdraw Type</th>
                       <th>Date</th>
                       <th>Status</th>
                   </tr>
                 </tfoot>
               </table>
             </div>
           </div>
         </div>
       </div>
     </div>
   </section>
 </div>
</div>
</div>
  @endsection