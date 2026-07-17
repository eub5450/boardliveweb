@extends('backend.layouts.main')
@section('title')
Create New Agency
@endsection
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<!--Content Start-->
<div class="body-content">
    <div class="card mb-4">
        <div class="card-body">
            <div class="form-group">
                <div class="col-sm-12">
                    <h4 class="text-center font-weight-bold font-italic mt-3">New Invisibal Power</h4>
                </div>
            </div>
            <form action="{{URL::to('invisibal_active')}}" method="post" enctype="multipart/form-data" class="form-inline">
                @csrf

                <div class="form-group col-md-6 mb-3">
                    <label for="member" class="col-sm-4 col-form-label text-right">User Id</label>
                    <select name="user_id" class="form-control select_agency_id" required="" id="user_id">
                       @foreach($users as $user)
                       <option value="{{$user->id}}">{{$user->id}} -- {{$user->name}}</option>
                       @endforeach
                   </select>
                   <span class="text-danger"></span>
                </div>

            <div class="form-group col-md-6 mb-3">
                <label for="name" class="col-sm-4 col-form-label text-right"> Id Number</label>
                <input type="number"  name="id_number" class="form-control col-sm-8" placeholder="Enter The Id Number For Confirm" value="" id="deposit" required>
                <span class="text-danger"></span>
            </div>


            <div class="form-group col-md-12 mb-3">
                <button type="submit" class="btn btn-success">Active</button>
            </div>
        </form>
    </div>
</div>
</div>
<div class="body-content">
  <div class="card mb-4">
    <div class="card-body">
      <section class="forms">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4> Invisibal ID List</h4>
                </div>
              <div class="table-responsive">
                  <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                      <tr>
                       <th>Sl</th>
                       <th>ID</th>
                       <th>Profile</th>
                       <th>Name</th>
                       <th>Level</th>
                       <th>Action</th>
                   </tr>
               </thead>
                 <tbody>
                    @php
                    $i=0;
                    @endphp
                    @foreach($invisible_users as $invisible_user)
                    <tr>
                      <td>{{ ++$i }}</td>
                      <td>{{$invisible_user->id}}  </td>
                      <td> <img style="width: 73px;" src="{{URL::to($invisible_user->profile)}}"></td>
                      <td>{{$invisible_user->name}}  </td>
                      <td>{{$invisible_user->level}}  </td>                      
                      <td>
                          <a href="{{URL::to('invisible_id_reject/'.$invisible_user->user_id)}}" class="btn btn-sm btn-danger" ><span class="fa fa-cross"></span> Reject</a>
                      </td>
                      
                  </tr>
                  @endforeach
              </tbody>
              <tfoot>
                <tr>
                   <th>Sl</th>
                   <th>ID</th>
                   <th>Profile</th>
                   <th>Name</th>
                   <th>Level</th>
                   <th>Action</th>
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