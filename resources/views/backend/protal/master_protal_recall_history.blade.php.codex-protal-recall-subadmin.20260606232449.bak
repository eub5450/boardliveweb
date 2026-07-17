@extends('backend.layouts.main')

@section('title')
Master Protal Recall History
@endsection
@section('content')
<div class="body-content">
  <div class="card mb-4">
    <div class="card-body">
      <section class="forms">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                  <h4>Master Protal Recall History</h4>
                  <a href="{{URL::to('protal_list')}}" class="btn btn-sm btn-primary">Back To Protal List</a>
                </div>
                <div class="table-responsive">
                  <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                      <tr>
                        <th>Sl</th>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>Protal ID</th>
                        <th>Protal Name</th>
                        <th>Amount</th>
                        <th>Transaction ID</th>
                        <th>Date</th>
                        <th>Auth ID</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php $i=0; @endphp
                      @foreach($data as $item)
                      @php
                      $receiver=App\Models\User::find($item->user_id);
                      $protal=App\Models\User::find($item->protal_id);
                      @endphp
                      <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{$item->user_id}}</td>
                        <td>@if($receiver) {{$receiver->name}} @endif</td>
                        <td>{{$item->protal_id}}</td>
                        <td>@if($protal) {{$protal->name}} @endif</td>
                        <td><span class="text-danger">-{{$item->amount}}</span></td>
                        <td>{{$item->transaction_id}}</td>
                        <td>{{$item->date}}</td>
                        <td>{{$item->auth_id}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Sl</th>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>Protal ID</th>
                        <th>Protal Name</th>
                        <th>Amount</th>
                        <th>Transaction ID</th>
                        <th>Date</th>
                        <th>Auth ID</th>
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
