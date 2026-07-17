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
  @if(Auth::id()!=555513)

<!--Content Start-->
<div class="body-content">
    <div class="card mb-4">
        <div class="card-body">
            <div class="form-group">
                <div class="col-sm-12">
                    <h4 class="text-center font-weight-bold font-italic mt-3">Coin Generate</h4>
                </div>
            </div>
            <form action="{{URL::to('admin/coin-generate-store')}}" method="post" enctype="multipart/form-data" class="form-inline">
                @csrf

            <div class="form-group col-md-6 mb-3">
                <label for="name" class="col-sm-4 col-form-label text-right">Amount*</label>
                <input type="number"  name="amount" class="form-control col-sm-8" placeholder="Amount" value="" id="deposit" required>
                <span class="text-danger"></span>
            </div> 
            <div class="form-group col-md-6 mb-3">
                <label for="name" class="col-sm-4 col-form-label text-right">Confirm Amount*</label>
                <input type="number"  name="confirm_amount" class="form-control col-sm-8" placeholder="Amount" value="" id="deposit" required>
                <span class="text-danger"></span>
            </div>
       
          

            <div class="form-group col-md-12 mb-3">
                <button type="submit" class="btn btn-success">Generate</button>
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
                    <h4> Generate List</h4>
                </div>
              <div class="table-responsive">
                  <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                      <tr>
                       <th>Sl</th>
                       <th>ID</th>
                       <th>Amount</th>
                       <th>Date</th>
                       
                       <th>Action</th>
                   </tr>
               </thead>
                 <tbody>
                    @php
                    $i=0;
                    @endphp
                    @foreach($data as $row)
                    <tr>
                      <td>{{ ++$i }}</td>
                      <td>{{$row->user_id}}  </td>
                    
                      <td>{{$row->amount}}  </td>
                      <td>{{$row->date}}  </td>                      
                      <td>
                          <a href="{{URL::to('generate_remove/'.$row->id)}}" class="btn btn-sm btn-danger" ><span class="fa fa-cross"></span> Remove</a>
                      </td>
                      
                  </tr>
                  @endforeach
              </tbody>
              <tfoot>
                <tr>
                     <th>Sl</th>
                       <th>ID</th>
                       <th>Amount</th>
                       <th>Date</th>
                       
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
 @endif
@endsection