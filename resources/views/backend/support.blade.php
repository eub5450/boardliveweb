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
                          <h4>Support</h4>
                      </div>
                      <div class="table-responsive">
                  <table class="table display table-bordered table-striped table-hover basic">
                <thead>
                  <tr>
                   <th>Sl</th>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Message</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                  $i=0;
                  @endphp
                  @foreach($data as $item)
                 @php
                 $user=App\Models\User::find($item->user_id);
                 @endphp
                  <tr>
                    <td>{{ ++$i }}</td>
                    
                    <td>{{$item->user_id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$item->problem}}</td>
                    <td>
                        @if($item->status==0)
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModals{{$item->id}}">Replay</button>
                        @else
                        {{$item->replay}}
                        @endif
                    </td>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModals{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">Support Replay</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form action="{{URL::to('support_replay',$item->id)}}" enctype="multipart/form-data" method="post"> 
                            @csrf 
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">User ID:</label>
                                <input type="text" name="user_id" value="{{$item->user_id}}" class="form-control" id="recipient-name" readonly required="">
                              </div>
                              <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Comment*:</label>
                                <input type="text" name="replay" class="form-control" id="recipient-name" required>
                               
                              </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                          </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                     <th>Sl</th>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Message</th>
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