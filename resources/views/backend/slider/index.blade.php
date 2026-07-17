@extends('backend.layouts.main')


@section('title')
Banner Management
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
                          <h4>Banner Management <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add Banner</button></h4>
                      </div>
                      	<div class="row">
		    <!-- Modal -->
        			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        			  <div class="modal-dialog" role="document">
        			    <div class="modal-content">
        			      <div class="modal-header">
        			        <h5 class="modal-title" id="exampleModalLabel">Add New Banner</h5>
        			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        			          <span aria-hidden="true">&times;</span>
        			        </button>
        			      </div>
        			      <div class="modal-body">
        			         <form action="{{URL::to('admin/slider-store')}}" enctype="multipart/form-data" method="post">
        			             @csrf
        			       
        			          
        			        
        			          <div class="form-group">
        			            <label for="recipient-name" class="col-form-label">Banner Image</label>
        			            <input type="file" name="image" class="form-control" id="recipient-name" required accept=".jpg,.jpeg,.png,.gif,.webp,image/jpeg,image/png,image/gif,image/webp">
        			            
        			          </div>
        			          
        			        
        			      </div>
        			      <div class="modal-footer">
        			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        			        <button type="submit" class="btn btn-primary">Save Banner</button>
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
                    <th>Banner</th>
                    <th>Public URL</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                  $i=0;
                  @endphp
                  @foreach($sliders as $item)
                  <tr>
                    <td>{{ ++$i }}</td>
                    <td>
                      @if(!empty($item->image_url))
                        <img style="width: 361px;max-width:100%;border-radius:8px;border:1px solid #444;" src="{{ $item->image_url }}" alt="Banner {{ $item->id }}">
                      @else
                        <span class="badge badge-danger">Missing image path</span>
                      @endif
                    </td>
                    <td>
                      @if(!empty($item->image_url))
                        <a href="{{ $item->image_url }}" target="_blank">{{ $item->image_url }}</a>
                      @endif
                    </td>
                   
                    <td>
                      <a  type="button" class="btn btn-danger" href="{{URL::to('admin-slider-removed',$item->id)}}">Remove</a>

                    </td>
                    
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                     <th>Sl</th>
                    <th>Banner</th>
                    <th>Public URL</th>
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
