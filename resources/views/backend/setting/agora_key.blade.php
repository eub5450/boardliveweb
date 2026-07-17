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
<div class="body-content">
    <div class="card mb-4">
        <div class="card-body">
            <div class="form-group">
                <div class="col-sm-12">
                    <h4 class="text-center font-weight-bold font-italic mt-3">New Agora Account</h4>
                </div>
            </div>
            <form action="{{URL::to('admin-agora_account_store')}}" method="post" enctype="multipart/form-data" class="form-inline">
                @csrf

               
            <div class="form-group col-md-6 mb-3">
                <label for="id_number" class="col-sm-4 col-form-label text-right">Agora AppId *</label>
                <input type="text"  name="appId" class="form-control col-sm-8" placeholder="Enter AppId" value="" id="deposit" required>
                <span class="text-danger"></span>
            </div> 
            <div class="form-group col-md-6 mb-3">
                <label for="name" class="col-sm-4 col-form-label text-right">Agora AppCertificate *</label>
                <input type="text"  name="appCertificate" class="form-control col-sm-8" placeholder="Enter Agora AppCertificate" value="" id="deposit" required>
                <span class="text-danger"></span>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="name" class="col-sm-4 col-form-label text-right">Agora Account Email *</label>
                <input type="email"  name="AgoraEmail" class="form-control col-sm-8" placeholder="Enter Agora Account Email" value="" id="deposit" required>
                <span class="text-danger"></span>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="name" class="col-sm-4 col-form-label text-right">Agora Account Email Password *</label>
                <input type="text"  name="AgoraEmailPassword" class="form-control col-sm-8" placeholder="Enter Agora Account Email Password" value="" id="deposit" required>
                <span class="text-danger"></span>
            </div>
           
            <div class="form-group col-md-12 mb-3">
                <button type="submit" class="btn btn-success">Submit</button>
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
                    <h4> Agora Account  List</h4>
                </div>
              <div class="table-responsive">
                  <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                      <tr>
                       <th>Sl</th>
                       <th>AppId</th>
                       <th>AppCertificate</th>
                       <th>Email</th>
                       <th>Password</th>
                       <th>Note</th>
                       <th>Status</th>
                       <th>Actions</th>
                   </tr>
               </thead>
                 <tbody>
                    @php
                    $i=0;
                    @endphp
                    @foreach($data as $row)
                    <tr>
                      <td>{{ ++$i }}</td>
                      <td>{{$row->appId}}  </td>
                      <td>{{$row->appCertificate}}  </td>
                      <td>{{$row->AgoraEmail}}  </td>
                      <td>{{$row->AgoraEmailPassword}}  </td>
                      <td>{{$row->note}}  </td>
                      <td>@if($row->Status == 1)
                        <span class="badge bg-success" style=" color: white; ">Running</span>
                        @elseif($row->Status == 0)
                            <span class="badge bg-primary" style=" color: white; ">New</span>
                        @else
                            <span class="badge bg-danger" style=" color: white; ">Expired</span>
                        @endif
                        </td>
                      <td>@if($row->Status==1) Running @elseif($row->Status==0) <a href="{{URL::to('admin-agora_account_active/'.$row->id)}}" class="btn btn-sm btn-success" ><span class="fa fa-close"></span> Active</a>  @else Expired @endif </td>
                  </tr>
                 
                  @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th>Sl</th>
                       <th>AppId</th>
                       <th>AppCertificate</th>
                       <th>Email</th>
                       <th>Password</th>
                       <th>Note</th>
                       <th>Status</th>
                       <th>Actions</th>
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