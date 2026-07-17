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
                <div class="card-header d-flex align-items-center justify-content-between">
                  <h4> Agency List</h4>
                  <a href="{{URL::to('master-protal-recall')}}" class="btn btn-sm btn-info">Protal Recall History</a>
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
                       <th>Total Recived</th>
                       <th>Total Sand</th>
                       <th>Total Recall</th>
                       <th>Balance</th>
                       <th>Action</th>
                     </tr>
                   </thead>
                   <tbody>
                    @php
                    $i=0;
                    $receiver_users = isset($all_users) ? $all_users : App\Models\User::where('status',1)->orderBy('id','asc')->get();
                    @endphp
                    @foreach($users as $user)
                    @php
                    $total_recived=App\Models\PortalRecharge::where('user_id',$user->id)->where('status','Approved')->sum('amount');
                    $total_sand=App\Models\PortalTransfer::where('portal_user_id',$user->id)->sum('amount');
                    $old_recall=App\Models\PortalRecall::where('protal_id',$user->id)->sum('amount');
                    $master_recall=App\Models\MasterProtalRecall::where('protal_id',$user->id)->sum('amount');
                    $total_recall=$old_recall+$master_recall;
                    $ProtalToPTransfer=App\Models\ProtalToPTransfer::where('user_id',$user->id)->sum('amount');
                    $ProtalToPTransferRecived=App\Models\ProtalToPTransfer::where('portal_user_id',$user->id)->sum('amount');
                    $available_balance=($total_recived+$ProtalToPTransferRecived)-($total_sand+$total_recall+$ProtalToPTransfer);
                    @endphp
                    <tr>
                      <td>{{ ++$i }}</td>
                      <td>  {{$user->id}}  </td>
                      <td> <img style="width: 73px;" src="{{URL::to($user->profile)}}"></td>
                      <td>  {{$user->name}}  </td>
                      <td>  {{$user->level}}  </td>
                      <td>  {{$total_recived}}  </td>
                      <td>  {{$total_sand}}  </td>
                      <td>  @if($total_recall>0)-{{$total_recall}}@else 0 @endif  </td>
                      <td>  {{$available_balance}}  </td>

                      <td>
                          @if(Auth::id()==555511)
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#masterProtalRecallModal-{{$user->id}}" @if($available_balance<=0) disabled @endif>
                          Recall
                        </button>
                        @endif
                      </td>

                    </tr>
                       <!-- Modal -->
                      <div class="modal fade" id="masterProtalRecallModal-{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="masterProtalRecallModalLabel-{{$user->id}}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="masterProtalRecallModalLabel-{{$user->id}}">{{$user->name}} Protal Recall</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form action="{{URL::to('master_protal_recall_store')}}" method="post">
                              @csrf
                              <div class="modal-body">
                                <div class="form-group">
                                  <label class="col-form-label">Protal Balance:</label>
                                  <input type="number" value="{{$available_balance}}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                  <label class="col-form-label">Receiver User ID:</label>
                                  <select name="user_id" class="form-control" required>
                                    <option value="">Select User</option>
                                    @foreach($receiver_users as $receiver)
                                      <option value="{{$receiver->id}}">{{$receiver->id}} -- {{$receiver->name}}</option>
                                    @endforeach
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label class="col-form-label">Amount:</label>
                                  <input type="number" name="amount" value="{{$available_balance}}" min="1" max="{{$available_balance}}" class="form-control" required>
                                  <input type="hidden" name="protal_id" value="{{$user->id}}">
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" @if($available_balance<=0) disabled @endif>Submit Recall</button>
                              </div>
                              <div style="font-size:10px;text-align:center;color:#999;padding-bottom:8px;">Powerd by JAMBOai</div>
                            </form>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                     <th>Sl</th>
                     <th>ID</th>
                     <th>Profile</th>
                     <th>Name</th>
                     <th>Level</th>
                     <th>Total Recived</th>
                     <th>Total Sand</th>
                     <th>Total Recall</th>
                     <th>Balance</th>
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
