@extends('backend.layouts.main')

@section('title')
Employee | 
@endsection

@section('content')
@if(Auth::id() == 11133 || Auth::id() == 1)
<!--Content Start-->
<div class="body-content">
    <div class="card mb-4">
        <div class="card-body">
            <div class="col-12 pl-0 pr-0">
                <div class="form-group">
                    <div class="col-sm-12">
                        <h4 class="text-center font-weight-bold font-italic mt-3">Fruits Lock List  <button type="button" class="btn btn-success my-btn-submit" data-toggle="modal" data-target="#brandadd">Add Lock</button></h4>
                        <!-- Button trigger modal -->
                        <!-- Modal -->
                        <div class="modal fade" id="brandadd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">New Lock</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <section class="container-fluid">
                                            <div class="row content">
                                                <div class="col-12 pl-0 pr-0">
                                                    <form action="{{ URL::to('admin/fruts-game-lock_id_list-store') }}" method="post" enctype="multipart/form-data" class="form-inline">
                                                        @csrf
                                                        <div class="form-group col-md-12 mb-3">
                                                            <label for="amount" class="col-sm-4 col-form-label text-right">ID</label>
                                                            <input type="number" value="" name="block_id" class="form-control" required id="recipient-name">
                                                            <span class="text-danger"></span>
                                                        </div>
                                                        <div class="form-group col-md-12 mb-3">
                                                            <label for="amount" class="col-sm-4 col-form-label text-right">Percentage</label>
                                                            <input type="number" value="" name="parcentage" class="form-control" required id="recipient-name">
                                                            <span class="text-danger"></span>
                                                        </div> 
                                                        <div class="form-group col-md-12 mb-3">
                                                            <label for="amount" class="col-sm-4 col-form-label text-right">Type</label>
                                                            <select name="type" class="form-control" required id="type">
                                                                <option value="0">Lock</option>
                                                                <option value="1">Win</option>
                                                            </select>
                                                            <span class="text-danger"></span>
                                                        </div>
                                                        <div class="form-group col-md-12 mb-3">
                                                            <button type="submit" class="btn btn-success my-btn-submit">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </section>
                                        <!--Content End-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row g-3">
        <div class="col-6">
            <div class="table-responsive">
                <table class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Other ID</th>
                            <th>Auto Lock?</th>
                            <th>Balance</th>
                            <th style="width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=0; @endphp
                        @foreach($fruits_lock_lists as $row)
                            @php
                                $user = App\Models\User::find($row->user_id);
                                $old_ids = App\Models\User::where('imei_number', $user->imei_number)
                                    ->where('id', '!=', $row->user_id)
                                    ->get();
                            @endphp
                            <tr @if($row->auto_lock_active) style="background: #ffe0e0;" @endif>
                                <td>{{ ++$i }}</td>
                                <td>{{ $row->user_id }}</td>
                                <td>@if($user){{ $user->name }} - {{ $row->parcentage }}% @endif</td>
                                <td>
                                    @if($user && $user->imei_number)
                                        @foreach($old_ids as $old_id)
                                            {{ $old_id->name }} - {{ $old_id->id }},
                                        @endforeach
                                    @endif
                                </td>
                                <td>@if($row->auto_lock_active) Auto lock @endif</td>
                                <td>@if($user){{ $user->balance }}@endif</td>
                                <td>
                                    <a href="{{ URL::to('admin/fruts-game-lock_id-list-delete/'.$row->id) }}" class="btn btn-sm btn-danger" id="delete" onclick="return confirm('Are you sure?')">
                                        <span class="fa fa-trash"></span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="col-6">
            <div class="table-responsive">
                <table class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Other ID</th>
                            <th>Auto Win?</th>
                            <th>Balance</th>
                            <th style="width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=0; @endphp
                        @foreach($fruits_win_lists as $row)
                            @php
                                $user = App\Models\User::find($row->user_id);
                                $old_ids = App\Models\User::where('imei_number', $user->imei_number)
                                    ->where('id', '!=', $row->user_id)
                                    ->get();
                            @endphp
                            <tr @if($row->auto_lock_active) style="background: #aeeaaf;" @endif>
                                <td>{{ ++$i }}</td>
                                <td>{{ $row->user_id }}</td>
                                <td>@if($user){{ $user->name }} - {{ $row->parcentage }}% @endif</td>
                                <td>
                                    @if($user && $user->imei_number)
                                        @foreach($old_ids as $old_id)
                                            {{ $old_id->name }} - {{ $old_id->id }},
                                        @endforeach
                                    @endif
                                </td>
                                <td>@if($row->auto_lock_active) Auto lock @endif</td>
                                <td>@if($user){{ $user->balance }}@endif</td>
                                <td>
                                    <a href="{{ URL::to('admin/fruts-game-lock_id-list-delete/'.$row->id) }}" class="btn btn-sm btn-danger" id="delete" onclick="return confirm('Are you sure?')">
                                        <span class="fa fa-trash"></span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--Content End-->
@endif
@endsection