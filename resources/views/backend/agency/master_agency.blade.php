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
                          <h4>Master Agency List <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add New Agency</button></h4>
                      </div>
                      <div class="row">
                <!-- Modal -->
                      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Add New Agency</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                               <form action="{{URL::to('admin/child_agency_store')}}" enctype="multipart/form-data" method="post">
                                   @csrf
                             
                                
                              
                                <div class="form-group">
                                  <label for="recipient-name" class="col-form-label">Master Agency:</label>
                                  <select name="master_agency_id" required="" class="form-control">
                                    @foreach($agencys as $agency)
                                    <option value="{{$agency->id}}">{{$agency->name}}</option>
                                    @endforeach
                                  </select>
                                  
                                </div>
                                <div class="form-group">
                                  <label for="recipient-name" class="col-form-label">Child Agency:</label>
                                  <select name="child_agency_id" required="" class="form-control">
                                    @foreach($agencys as $agency)
                                    <option value="{{$agency->id}}">{{$agency->name}}</option>
                                    @endforeach
                                  </select>
                                </div>

                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                            </form>
                          </div>
                        </div>
                      </div>
                  
                    
                      
                    
                  </div>
                      <div class="table-responsive">
                  <table class="table display table-bordered table-striped table-hover basic">
                <thead>
                  <tr>
                   <th>Sl</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Agency Have</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                  $i=0;
                  @endphp
                 @foreach($lists as $item)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{$item['master_agency_code']}}</td>
                        <td>{{$item['master_agency']}}</td>
                        <td>{{$item['count']}}</td>
                        <td>
                            <a href="{{URL::to('admin-master-agency-view', $item['id'])}}" class="btn btn-sm btn-info">
                                <span class="fa fa-eye"></span> View
                            </a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
                <tfoot>
                  <tr>
                    <th>Sl</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Agency Have</th>
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