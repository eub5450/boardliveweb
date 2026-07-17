@extends('backend.layouts.main')


@section('title')
Supplier  
@endsection
@section('content')
@php
$use=App\Models\User::find(Auth::id());
@endphp
@if(Auth::id() == 11133 || Auth::id() == 1)

<div class="body-content">

	<div class="row ">
		<div class="col-sm-6 col-xs-12 contact">
			<div class="card">

				<div class="box-body">
					<center><h3 class="widget-user-username">Fruits : locked id :{{$balance->block_id}}--{{$balance->lock_parcent}}% <br>Winner id :{{$balance->winner_id}}</h3></center>
					<address class="mb-0 text-center">
					Game Balance: <h1><b id="gready_balance">{{round($balance->game_balance)}}</b></h1><br>
						Game 2nd Balance: <h1><b id="sec_gready_balance">{{round($balance->second_balance)}}</b></h1><br>
						Game 3rd Balance: <h1><b id="third_balance">{{round($balance->third_balance)}}</b></h1>
					</address>
				{{-- 	<a href="{{URL::to('reject_host/'.$user->user_id)}}" class="btn btn-sm btn-danger" ><span class="fa fa-cross"></span>Host Reject</a> --}}
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-xs-12 balance">
			<div class="card">
				<div class="box box-info">
					<div class="box-header with-border text-center">
						<h3 class="box-title">Game On / Off Controll</h3>
						<!--<iframe src="https://bplive.site/betel/fruits?token={{$use->password}}&id=7&user={{$use->email}}" height="325px" width="400px"></iframe>-->
					</div>
					<div class="box-body">
						@if($balance->game_status==1)
							<a href="{{URL::to('admin/fruits_game_off')}}" class="btn btn-sm btn-danger" ><span class="fa fa-close"></span>Game Off</a>
							@else 
							<a href="{{URL::to('admin/fruits_game_on')}}" class="btn btn-sm btn-success" ><span class="fa fa-check"></span>Game On</a>
							@endif
                      @if($balance->robot_on==1)
							<a href="{{URL::to('admin/fruits_game_robot_off')}}" class="btn btn-sm btn-danger" ><span class="fa fa-close"></span>Robot Off</a>
							@else 
							<a href="{{URL::to('admin/fruits_game_robot_on')}}" class="btn btn-sm btn-success" ><span class="fa fa-check"></span>Robot On</a>
							@endif
							<a href="{{URL::to('admin/fruits_game_clear')}}" class="btn btn-sm btn-warning" ><span class="fa fa-refresh"></span>Game Clear</a>
							@if($balance->auto_lock==1)
							<a href="{{URL::to('admin/fruits_game_auto_lock_off')}}" class="btn btn-sm btn-danger" ><span class="fa fa-close"></span>Auto Lock Off</a>
							@else 
							<a href="{{URL::to('admin/fruits_game_auto_lock_on')}}" class="btn btn-sm btn-success" ><span class="fa fa-check"></span>Auto Lock On</a>
							
							@endif
							<a href="{{URL::to('admin/game_pattern_reverse')}}" class="btn btn-sm btn-warning" ><span class="fa fa-check"></span>Pattern Reverse</a>
                       <button type="button" class="btn btn-info" data-toggle="modal" data-target="#idlocked">
                  ID Locked
                </button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#third_balance_setting">
                  Third Balance Setting
                </button>
                
					</div>
				</div>
			</div>
		
		</div>
		<br>
	<div class="modal fade" id="third_balance_setting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Third Balance Setting</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form action="{{URL::to('fruits_third_setting')}}" method="post">
             @csrf

          <div class="form-group">
            <label for="third-take-margin" class="col-form-label">Third Take Margin:</label>
            <input type="number" name="third_take_margin" value="{{$balance->third_take_margin}}" class="form-control" id="third-take-margin">
        </div>
        
        <div class="form-group">
            <label for="third-helf-give-margin" class="col-form-label">Third 2nd Give Margin:</label>
            <input type="number" name="third_helf_give_margin" value="{{$balance->third_helf_give_margin}}" class="form-control" id="third-helf-give-margin">
        </div>
        
        <div class="form-group">
            <label for="third-full-give-margin" class="col-form-label">Third 3rd Give Margin:</label>
            <input type="number" name="third_full_give_margin" value="{{$balance->third_full_give_margin}}" class="form-control" id="third-full-give-margin">
        </div>
        
        <div class="form-group">
            <label for="third-take-percentage" class="col-form-label">Third Take Percentage:</label>
            <input type="number" name="third_take_parcentage" value="{{$balance->third_take_parcentage}}" class="form-control" id="third-take-percentage">
        </div>
        
        <div class="form-group">
            <label for="third-helf-given-percentage" class="col-form-label">Third 2nd Given Percentage:</label>
            <input type="number" name="third_helf_given_parcentage" value="{{$balance->third_helf_given_parcentage}}" class="form-control" id="third-helf-given-percentage">
        </div>
        
        <div class="form-group">
            <label for="third-full-given-percentage" class="col-form-label">Third 3rd Given Percentage:</label>
            <input type="number" name="third_full_given_parcentage" value="{{$balance->third_full_given_parcentage}}" class="form-control" id="third-full-given-percentage">
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>
	<div class="modal fade" id="idlocked" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Lock Id For Fruits Game</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form action="{{URL::to('fruits_id_lock')}}" method="post">
             @csrf

          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Lock ID Number:</label>
            <input type="number" value="{{$balance->block_id}}"  name="block_id" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">%:</label>
            <input type="number"  name="lock_parcent" class="form-control" value="{{$balance->lock_parcent}}" id="recipient-name">
          </div>
        <div class="form-group">
            <label for="recipient-name" class="col-form-label">Winner ID Number:</label>
            <input type="number" value="{{$balance->winner_id}}"  name="winner_id" class="form-control" id="recipient-name">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

		<div class="body-content" style="width: 100%;">


		<div class="col-xl-12 col-sm-12 py-2">
			<div class="card mb-4">
				<div class="card-header">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="fs-17 font-weight-600 mb-0">Bet Details</h6>
						</div>
						
					</div>
				</div>
				<div class="card-body">
					
					 <table class="table display table-bordered table-striped table-hover basic">
			                    <thead>
			                      <tr>
			                       <th>Sl</th>
			                       <th>Tray ID</th>
			                       <th>Winner</th>
			                        <th><img  style=" width: 30px; "src="{{asset('public/game/new/image')}}/apple.png" alt="Saven Winner"> Serve</th>
			                       <th><img src="{{asset('public/game/new/image')}}/lemon.png" style=" width: 30px; " alt="Saven Winner"> Serve</th>
			                       <th><img  style=" width: 30px; "src="{{asset('public/game/new/image')}}/watermelon.png" alt="Saven Winner"> Serve</th>
			                      
			                       <th>Start Time</th>
			                       <th>Pattern</th>
			                   </tr>
			               </thead>
			                 <tbody>
			                    @php
			                    $i=0;
			                    @endphp
			                    @foreach($game_serve_details as $game_serve_detail)
			                    <tr>
			                      <td>{{ ++$i }}</td>
			                      <td>{{$game_serve_detail->tray_id}}  </td>
			                       <td>@if($game_serve_detail->winner=='saven_win') <img src="{{asset('public/game/new/image')}}/lemon.png" style=" width: 48px; " alt="Saven Winner"> @elseif($game_serve_detail->winner=='watermelon')  <img  style=" width: 48px; "src="{{asset('public/game/new/image')}}/watermelon.png" alt="Saven Winner"> @else <img  style=" width: 48px; "src="{{asset('public/game/new/image')}}/apple.png" alt="Saven Winner"> @endif  </td>
			                      <td>{{$game_serve_detail->apple_serve}}  </td>
			                      <td>{{$game_serve_detail->lemon_serve}}  </td>
			                      <td>{{$game_serve_detail->watermalon_serve}}  </td>
			                      <td>{{$game_serve_detail->created_at}}  </td>
			                      <td>{{$game_serve_detail->randomPercentage}}  </td>
			                      
			                  </tr>
			                  @endforeach
			              </tbody>
			              <tfoot>
			                <tr>
			                 <th>Sl</th>
			                 <th>Tray ID</th>
			                 <th>Winner</th>
			                 <th>Apple Serve</th>
			                 <th>Lemon Serve</th>
			                 <th>Watermalon Serve</th>
			                
			                 <th>Time</th>
			                 <th>Pattern</th>
			               </tr>
			           </tfoot>
			       </table>
					
				</div>
			</div>
		</div>
</div>

<div class="body-content" style="width: 100%;">


		
			<div class="card mb-4">
				<div class="card-header">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="fs-17 font-weight-600 mb-0">User Bets Details With Tray</h6>
						</div>
						
					</div>
				</div>
				<div class="card-body">
					
					 <table class="table display table-bordered table-striped table-hover basic">
			                    <thead>
			                      <tr>
			                       <th>Sl</th>
			                       <th>User </th>
			                       <th>User ID</th>
			                       <th>Tray ID</th>
			                        <th><img  style=" width: 30px; "src="{{asset('public/game/new/image')}}/apple.png" alt="Saven Winner"> Amount</th>
			                       <th><img src="{{asset('public/game/new/image')}}/lemon.png" style=" width: 30px; " alt="Saven Winner"> Amount</th>
			                       <th><img  style=" width: 30px; "src="{{asset('public/game/new/image')}}/watermelon.png" alt="Saven Winner"> Amount</th>
			                       <th>Status</th>
			                       <th>Add Balance</th>
			                   </tr>
			               </thead>
			                <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @foreach($game_serve_users_details as $game_serve_users_detail)
                                @php
                                    $user = App\Models\User::find($game_serve_users_detail->user_id);
                                    $check_recharge = App\Models\PortalTransfer::where('user_id', $game_serve_users_detail->user_id)->sum('amount');
                                    $check_balance = $user ? $user->balance : 0; // Assuming balance is a field in User model
                                    $check_gift = App\Models\Gift::where('sander_id', $game_serve_users_detail->user_id)->sum('value');
                                    $total_value = $check_balance + $check_gift;
                                    $user_profit = $check_recharge * rand(2, 3);
                                     $check_id_have_already=App\Models\FortuneLock::where('user_id',$game_serve_users_detail->user_id)->first();
                                @endphp
                                <tr @if($user_profit < $total_value) style="background: #ffe0e0;" @else style="background: #e0ffe9;" @endif>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $user ? $user->name : '' }}  @if($check_id_have_already) <span class="badge badge-danger">Locked</span> @endif</td>
                                    <td>{{ $game_serve_users_detail->user_id }}</td>
                                    <td>{{ $game_serve_users_detail->tray_id }}</td>
                                    <td>{{ $game_serve_users_detail->pot_no == 'apple' ? $game_serve_users_detail->amount : 0 }}</td>
                                    <td>{{ $game_serve_users_detail->pot_no == 'saven_win' ? $game_serve_users_detail->amount : 0 }}</td>
                                    <td>{{ $game_serve_users_detail->pot_no == 'watermelon' ? $game_serve_users_detail->amount : 0 }}</td>
                                    <td>
                                        @if($game_serve_users_detail->status == 0)
                                            Hold
                                        @elseif($game_serve_users_detail->status == 1)
                                            Win
                                        @else
                                            Loss
                                        @endif
                                    </td>
                                    <td>{{ $game_serve_users_detail->serve_balance }}</td>
                                </tr>
                            @endforeach
                        </tbody>

			              <tfoot>
			                <tr>
			                 <th>Sl</th>
			                 <th>User </th>
			                 <th>User ID</th>
			                 <th>Tray ID</th>
			                 <th>Apple Amount</th>
			                 <th>Lemon Amount</th>
			                 <th>Watermalon Amount</th>
			                 <th>Status</th>
			                 <th>Add Balance</th>
			               </tr>
			           </tfoot>
			       </table>
					
				</div>
			</div>

</div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">
    function fetchData() {
    $.ajax({
        url: '{{ URL::route('friuts_fetch.data') }}',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            // Fade out the elements
            $('#gready_balance, #sec_gready_balance,#third_balance').fadeOut(500, function() {
                // Update the text with the new data
                $('#gready_balance').text(Math.round(parseFloat(data.game_balance)));
               $('#sec_gready_balance').text(Math.round(parseFloat(data.second_balance)));
               $('#third_balance').text(Math.round(parseFloat(data.third_balance)));


                // Check if the amount is negative and apply red color if true
                if (parseFloat(data.game_balance) < 0) {
                    $('#gready_balance').css('color', 'red');
                } else {
                    $('#gready_balance').css('color', 'green'); // Reset to default color
                }

                if (parseFloat(data.second_balance) < 0) {
                    $('#sec_gready_balance').css('color', 'red');
                } else {
                    $('#sec_gready_balance').css('color', 'green'); // Reset to default color
                }if (parseFloat(data.third_balance) < 0) {
                    $('#third_balance').css('color', 'red');
                } else {
                    $('#third_balance').css('color', 'green'); // Reset to default color
                }

                // Fade in the elements with the new text
                $('#gready_balance, #sec_gready_balance,#third_balance').fadeIn(500);
            });

            // Set up the next AJAX request after 5 seconds
            setTimeout(fetchData, 5000);
        },
        error: function(xhr, status, error) {
            console.error(error);

            // Set up the next AJAX request after 4 seconds
            setTimeout(fetchData, 4000);
        }
    });
}

// Start the initial AJAX request
fetchData();


</script>
@endif
@endsection