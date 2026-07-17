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
                          <h4> User Balance List</h4>
                      </div>
                      <div class="table-responsive">
                  <table class="table display table-bordered table-striped table-hover">
                <thead>
                  <tr>
                   <th>Sl</th>
                    <th>Profile</th>
                    <th>Name</th>
                    <th>ID</th>
                    <th>Level</th>
                    <th>Email</th>
                    <th>Balance</th>
                   
                  </tr>
                </thead>
                <tbody>
                  @php
                  $i=0;
                  $total_balance=0;
                  @endphp
                  @foreach($users as $user)
                
                  <tr>
                    <td>{{ ++$i }}</td>
                    <td>@if($user) <img style="width: 73px;" src="{{URL::to($user->profile)}}"> @endif</td>
                    <td> @if($user) {{$user->name}} @else @endif </td>
                    <td> @if($user) {{$user->id}} @else @endif </td>
                    <td> @if($user) {{$user->level}} @else @endif </td>
                    <td> @if($user) {{$user->email}} @else @endif </td>
                    <td> @if($user) {{$user->balance}} @else @endif </td>


                    
                  </tr>
                  @php
                  $total_balance+=$user->balance;
                  @endphp
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>Sl</th>
                    <th>Profile</th>
                    <th>Name</th>
                    <th>ID</th>
                    <th>Level</th>
                    <th>Email</th>
                    <th>{{$total_balance}}</th>
                  
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