@extends('backend.layouts.main')


@section('title')
Supplier  
@endsection
@section('content')


<div class="body-content">
	<form action="{{URL::to('/host-store')}}" method="post" enctype="multipart/form-data">
		@csrf
	
	<div class="row">

		<div class="col-xl-12 py-2">
			<div class="card ">
				<div class="card-body">
					<div class="form-group">
						<label for="member" class="col-sm-4 col-form-label text-right">Host ID</label>
						<select name="host_id" class="form-control host_id  select_host_id" id="host_id" required="">
							@foreach($host as $user)
							<option value="{{$user->id}}">{{$user->id}} - {{$user->name}}</option>
							@endforeach
							
						</select>
						<span class="text-danger"></span>
					</div>
					<div class="form-group">
						<label for="member" class="col-sm-4 col-form-label text-right">Joining Agency</label>
						<select name="agency_id" class="form-control agency_id  select_host_id" id="agency_id" required="">
							@foreach($agencys as $agency)
							<option value="{{$agency->code}}">{{$agency->code}} - {{$agency->name}}</option>
							@endforeach
							
						</select>
						<span class="text-danger"></span>
					</div>
					<div class="form-group">
						<label for="member" class="col-sm-4 col-form-label text-right">Hosting Type</label>
						<select name="hosting_type" class="form-control hosting_type  select_host_id" id="hosting_type" required="">
							
							<option value="2">Video</option>
							<option value="1">Audio</option>
							
						</select>
						<span class="text-danger"></span>
					</div>
					
					<div class="form-group">
						<label for="agency_name" class="col-sm-4 col-form-label text-right">Selfie</label>
						<input type="file" name="selfie"   class="form-control " placeholder="Agency Name" value="" id="selfie" onchange="readURL1(this);" required>
						 <img src="http://it-solutionsbd.com/logo.png" id="one" class="col-sm-4 col-form-label text-left"  >
						<span class="text-danger"></span>
					</div>
					<div class="form-group">
						<label for="agency_name" class="col-sm-4 col-form-label text-right">Nid</label>
						<input type="file" name="nid"   class="form-control " placeholder="Agency Name" value="" onchange="readURL2(this);" id="nid" required>
						 <img src="http://it-solutionsbd.com/logo.png" id="two" class="col-sm-4 col-form-label text-left"  >
						<span class="text-danger"></span>
					</div>

					<div class="form-group">
						<label for="agencycode" class="col-sm-4 col-form-label text-right">Image</label>
						<input type="file" name="image"  class="form-control image"  placeholder="Agency Code" onchange="readURL3(this);" id="agency_code" required="">
						<img src="http://it-solutionsbd.com/logo.png" id="three" class="col-sm-4 col-form-label text-left"  >
						<span class="text-danger"></span>
					</div>
					<div class="form-group">
						<label for="agencycode" class="col-sm-4 col-form-label text-right">Nid Number</label>
						<input type="number" name="nid"  class="form-control image"  placeholder="Enter NID Number"  id="agency_code" required="">
						<span class="text-danger"></span>
					</div>
					<div class="form-group">
						<label for="agencycode" class="col-sm-4 col-form-label text-right">Phone Number</label>
						<input type="text" name="phone_number"  class="form-control image"  placeholder="Enter Phone Number"  id="agency_code" required="">
						<span class="text-danger"></span>
					</div>
					 <div class="form-group col-md-12 mb-3">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
				</div>
			</div>
		</div>
		
	</div>
	</form>
</div>
@endsection
@section('script')
<script type="text/javascript">
    function readURL1(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              $('#one')
                  .attr('src', e.target.result)
                  .width(80)
                  .height(80);
          };
          reader.readAsDataURL(input.files[0]);
      }
   }
   function readURL2(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              $('#two')
                  .attr('src', e.target.result)
                  .width(80)
                  .height(80);
          };
          reader.readAsDataURL(input.files[0]);
      }
   }function readURL3(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              $('#three')
                  .attr('src', e.target.result)
                  .width(80)
                  .height(80);
          };
          reader.readAsDataURL(input.files[0]);
      }
   }
</script>
<script>
  $(document).ready(function() {
    $(document).on('keyup change','#host_id', function() {
      var id= $(this).val();
      
        $.ajax({
          url: "{{ URL::to('get/host_agency_info') }}/" + id,
          type: "GET",
          dataType:"json",
          success: function(data) {
            $('#agency_code').val(data.data.code);
            $('#agency_name').val(data.data.name);


            if ($.isEmptyObject(data.error)) {
              Toast.fire({
                type: 'success',
                title: data.success
              })
            } else {
              Toast.fire({
                type: 'error',
                title: data.error
              })
            }
          },

        });

      

    });

  });



</script>
@endsection