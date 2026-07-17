@extends('backend.layouts.main')
@section('title')
Gift Data
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
                    <h4 class="text-center font-weight-bold font-italic mt-3">New Gift</h4>
                </div>
            </div>
            <form action="{{URL::to('admin-gift-data-store')}}" method="post" enctype="multipart/form-data" class="form-inline">
                @csrf
                <div class="form-group col-md-6 mb-3">
                    <label class="col-sm-4 col-form-label text-right">Name *</label>
                    <input type="text" name="name" class="form-control col-sm-8" placeholder="Enter Gift Name" value="{{ old('name') }}" required>
                </div>
                <div class="form-group col-md-6 mb-3">
                    <label class="col-sm-4 col-form-label text-right">Amount *</label>
                    <input type="number" name="value" class="form-control col-sm-8" placeholder="Enter Gift Value" value="{{ old('value') }}" min="0" required>
                </div>
                <div class="form-group col-md-6 mb-3">
                    <label class="col-sm-4 col-form-label text-right">Image Name</label>
                    <input type="text" name="image_name" class="form-control col-sm-8" placeholder="Auto from upload if empty" value="{{ old('image_name') }}">
                </div>
                <div class="form-group col-md-6 mb-3">
                    <label class="col-sm-4 col-form-label text-right">Image *</label>
                    <input type="file" name="image" class="form-control col-sm-8" accept=".jpg,.jpeg,.png,.gif,.webp,image/*" required>
                </div>
                <div class="form-group col-md-6 mb-3">
                    <label class="col-sm-4 col-form-label text-right">SVGA Name</label>
                    <input type="text" name="svga_name" class="form-control col-sm-8" placeholder="Auto from upload if empty" value="{{ old('svga_name') }}">
                </div>
                <div class="form-group col-md-6 mb-3">
                    <label class="col-sm-4 col-form-label text-right">SVGA *</label>
                    <input type="file" name="svga" class="form-control col-sm-8" accept=".svga" required>
                </div>
                <div class="form-group col-md-6 mb-3">
                    <label class="col-sm-4 col-form-label text-right">Category *</label>
                    <select name="category" class="form-control select_agency_id" required>
                        @foreach($categories as $value => $label)
                            <option value="{{ $value }}" {{ old('category', 1) == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-12 mb-3">
                    <button type="submit" class="btn btn-success">Add Gift</button>
                </div>
                <div style="font-size:10px;color:#777;margin-top:6px;">Powerd by JAMBOai</div>
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
                    <h4>Gift List</h4>
                </div>
                <div class="table-responsive">
                  <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                      <tr>
                       <th>Sl</th>
                       <th>ID</th>
                       <th>Name</th>
                       <th>SVGA Name</th>
                       <th>Image Name</th>
                       <th>Image</th>
                       <th>Value</th>
                       <th>Type</th>
                       <th>Action</th>
                   </tr>
               </thead>
                 <tbody>
                    @php $i=0; @endphp
                    @foreach($gifts as $gift)
                    <tr>
                      <td>{{ ++$i }}</td>
                      <td>{{$gift->id}}</td>
                      <td>{{$gift->name}}</td>
                      <td>{{$gift->svga_name}}</td>
                      <td>{{$gift->image_name}}</td>
                      <td><img style="width:73px;max-height:73px;object-fit:contain;" src="{{URL::to($gift->image)}}"></td>
                      <td>{{$gift->value}}</td>
                      <td>{{ $categories[(int) $gift->category] ?? 'Frame' }}</td>
                      <td>
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#giftEditModal{{$gift->id}}">
                              Edit
                          </button>
                          <a href="{{URL::to('gift_data_delete/'.$gift->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Delete gift {{$gift->id}}?');"><span class="fa fa-cross"></span> Delete</a>
                      </td>
                    </tr>
                    <div class="modal fade" id="giftEditModal{{$gift->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <form action="{{URL::to('update_gift_data',$gift->id)}}" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="modal-header">
                              <h5 class="modal-title">Update Gift Data</h5>
                              <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                              <div class="row">
                                <div class="col-md-6"><div class="form-group"><label>Name *</label><input type="text" name="name" value="{{ $gift->name }}" class="form-control" required></div></div>
                                <div class="col-md-3"><div class="form-group"><label>Price *</label><input type="number" name="value" value="{{ $gift->value }}" class="form-control" min="0" required></div></div>
                                <div class="col-md-3"><div class="form-group"><label>Category *</label><select name="category" class="form-control" required>@foreach($categories as $value => $label)<option value="{{ $value }}" {{ (int) $gift->category === (int) $value ? 'selected' : '' }}>{{ $label }}</option>@endforeach</select></div></div>
                              </div>
                              <div class="row">
                                <div class="col-md-6"><div class="form-group"><label>Image Name</label><input type="text" name="image_name" value="{{ $gift->image_name }}" class="form-control"><small>Optional. New upload replaces current file/path.</small><input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.gif,.webp,image/*"></div></div>
                                <div class="col-md-6"><div class="form-group"><label>SVGA Name</label><input type="text" name="svga_name" value="{{ $gift->svga_name }}" class="form-control"><small>Optional. New upload replaces current file/path.</small><input type="file" name="svga" class="form-control" accept=".svga"></div></div>
                              </div>
                              <div style="font-size:10px;color:#777;margin-top:6px;">Powerd by JAMBOai</div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Save</button>
                            </div>
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
                       <th>Name</th>
                       <th>SVGA Name</th>
                       <th>Image Name</th>
                       <th>Image</th>
                       <th>Value</th>
                       <th>Type</th>
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
