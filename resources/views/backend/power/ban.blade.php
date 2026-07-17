@extends('backend.layouts.main')
@section('title')
Ban User Manager
@endsection
@section('content')
@if ($errors->any())
    <div class="alert alert-danger"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<div class="body-content">
  <div class="card mb-4"><div class="card-body">
    <h4 class="text-center font-weight-bold font-italic mt-3">Search User For Ban</h4>
    <form action="{{URL::to('ban_id')}}" method="get" class="form-inline mb-3">
      <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control col-md-5" placeholder="Search by ID, phone, email, or name">
      <button type="submit" class="btn btn-primary ml-2">Search</button>
    </form>
    @if(isset($users) && count($users))
      <div class="table-responsive mb-3">
        <table class="table table-bordered table-striped"><thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Status</th><th>Device</th></tr></thead><tbody>
        @foreach($users as $user)
          <tr><td>{{ $user->id }}</td><td>{{ $user->name }}</td><td>{{ $user->email }}</td><td>{{ $user->phone ?: $user->id }}</td><td>{{ $user->status == 1 ? 'Active' : 'Banned' }}</td><td>{{ $user->device_id }}</td></tr>
        @endforeach
        </tbody></table>
      </div>
    @endif

    <h4 class="text-center font-weight-bold font-italic mt-3">New ID Ban</h4>
    <form action="{{URL::to('banned_store')}}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="form-group col-md-6"><label>User ID *</label><input type="number" name="user_id" class="form-control" placeholder="Enter user ID" value="{{ old('user_id') }}" required></div>
        <div class="form-group col-md-6"><label>Confirm ID Number *</label><input type="number" name="id_number" class="form-control" placeholder="Repeat same user ID" value="{{ old('id_number') }}" required></div>
        <div class="form-group col-md-6"><label>Ban Type *</label><select name="ban_type" class="form-control" required><option value="D">D - 1 hour account ban</option><option value="C">C - 1 day account ban</option><option value="B">B - 30 day account ban</option><option value="A">A - account + device ban</option></select></div>
        <div class="form-group col-md-6"><label>Proof *</label><input type="file" name="proved" class="form-control" accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,image/*,application/pdf" required><small style="color:red;">Proof is required before banning.</small></div>
      </div>
      <button type="submit" class="btn btn-danger">Ban User</button>
      <div style="font-size:10px;color:#777;margin-top:6px;">Powerd by JAMBOai</div>
    </form>
  </div></div>
</div>

<div class="body-content">
  <div class="card mb-4"><div class="card-body">
    <section class="forms"><div class="container-fluid"><div class="row"><div class="col-md-12"><div class="card">
      <div class="card-header d-flex align-items-center"><h4>Banned ID List</h4></div>
      <div class="table-responsive">
        <table class="table display table-bordered table-striped table-hover basic">
          <thead><tr><th>Sl</th><th>ID</th><th>Profile</th><th>Name</th><th>Level</th><th>Type</th><th>Open Time</th><th>Device Ban</th><th>Proof</th><th>Action</th></tr></thead>
          <tbody>
          @php $i=0; @endphp
          @foreach($ban_ids as $ban_id)
          <tr>
            <td>{{ ++$i }}</td><td>{{$ban_id->id}}</td><td><img style="width:73px;" src="{{URL::to($ban_id->profile)}}"></td><td>{{$ban_id->name}}</td><td>{{$ban_id->level}}</td>
            <td>{{$ban_id->ban_type}}</td><td>{{$ban_id->open_time ?? 'Permanent/Manual'}}</td><td>{{ $ban_id->is_device_ban ? 'YES' : 'NO' }}</td>
            <td>@if($ban_id->ban_proved)<a href="{{URL::to($ban_id->ban_proved)}}" target="_blank"><img style="width:73px;max-height:73px;object-fit:contain;" src="{{URL::to($ban_id->ban_proved)}}"></a>@else N/A @endif</td>
            <td>
              <form action="{{URL::to('ban_id_reject/'.$ban_id->id)}}" method="post" onsubmit="return confirm('Unban user {{$ban_id->id}}?');">
                @csrf
                <button type="submit" class="btn btn-sm btn-success">Unban</button>
              </form>
            </td>
          </tr>
          @endforeach
          </tbody>
          <tfoot><tr><th>Sl</th><th>ID</th><th>Profile</th><th>Name</th><th>Level</th><th>Type</th><th>Open Time</th><th>Device Ban</th><th>Proof</th><th>Action</th></tr></tfoot>
        </table>
      </div>
    </div></div></div></div></section>
  </div></div>
</div>
@endsection
