@extends('backend.layouts.main')
@section('title')
Protal setting
@endsection
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
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
                    <h4 class="text-center font-weight-bold font-italic mt-3">Protal setting</h4>
                </div>
            </div>

            <form action="{{ URL::to('setting/system-setting-update') }}" method="post" class="form-inline">
                @csrf

                <div class="form-group col-md-8 mb-3">
                    <label for="portal_min_transfer_amount" class="col-sm-4 col-form-label text-right">
                        Minimum Amount
                    </label>
                    <input
                        type="number"
                        name="portal_min_transfer_amount"
                        id="portal_min_transfer_amount"
                        class="form-control col-sm-8"
                        min="1"
                        required
                        value="{{ old('portal_min_transfer_amount', $portalMinTransferAmount) }}"
                    >
                </div>

                <div class="form-group col-md-12 mb-3">
                    <small class="text-muted">
                        This value is used by API V3 and V4 portal transfer endpoints.
                    </small>
                </div>

                <div class="form-group col-md-12 mb-3">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
