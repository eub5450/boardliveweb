@extends('backend.layouts.main')


@section('title')
Supplier  
@endsection
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

<div class="body-content">
	<div class="row">
   <div class="col-sm-12 col-md-4 employee-cv">
      <div class="card-header resume">
         <div><img src="{{URL::to($master_agency->logo)}}" style=" border-radius: 50%; " width="100px;" height="100px;" class="img-circle"></div>
      </div>
      <div class="card-content">
         <div class="card-content-member">
            <h4 class="m-t-0">Name : {{ $master_agency->name }}</h4>
            <h5> ID :{{$master_agency->code}}</h5>

         </div>
         
       
      </div>
   </div>
   
</div>
	

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
			                       <th>Agency Name</th>
                             <th>Agency Code</th>
			                       <th>Gift Amount</th>
			                       <th>Action</th>
			                   </tr>
			               </thead>
			                 <tbody>
			                    @php
			                    $i=0;
			                    $reciving_history_total=0;
			                    @endphp
			                    @foreach($lists as $item)
                          <tr>
                              <td>{{ ++$i }}</td>
                              <td>{{ $item['agency'] }}</td>
                              <td>{{ $item['agency_code'] }}</td>
                              <td>{{ $item['total_target'] }}</td>
                              <td><a  type="button" class="btn btn-danger" href="{{URL::to('/remove_as_child_agency',$item['id'])}}">Removed</a></td>
                          </tr>
                          @php
                          $reciving_history_total+=$item['total_target'];
                          @endphp
                      @endforeach
			              </tbody>
			              <tfoot>
			                <tr>
			                 <th></th>
                             <th></th>
                             <th></th>
                             <th>{{$reciving_history_total}}</th>
                             <th></th>
			               </tr>
			           </tfoot>
			       </table>
					
				</div>
			</div>
		</div>
		
	</div>
</div>
</div>

@endsection