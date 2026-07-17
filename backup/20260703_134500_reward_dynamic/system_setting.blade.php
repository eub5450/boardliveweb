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
                        Direct Transfer Minimum
                    </label>
                    <input
                        type="number"
                        name="portal_min_transfer_amount"
                        id="portal_min_transfer_amount"
                        class="form-control col-sm-8"
                        min="1"
                        required
                        title="Minimum amount for portal to user transfer in API V3 and V4."
                        value="{{ old('portal_min_transfer_amount', $portalMinTransferAmount) }}"
                    >
                </div>

                <div class="form-group col-md-12 mb-3">
                    <small class="text-muted">
                        Minimum amount used by portal to user transfer in API V3 and V4.
                    </small>
                </div>

                <div class="form-group col-md-8 mb-3">
                    <label for="portal_to_portal_min_amount" class="col-sm-4 col-form-label text-right">
                        Portal To Portal Min
                    </label>
                    <input
                        type="number"
                        name="portal_to_portal_min_amount"
                        id="portal_to_portal_min_amount"
                        class="form-control col-sm-8"
                        min="1"
                        required
                        title="First allowed amount for portal to portal transfer."
                        value="{{ old('portal_to_portal_min_amount', $portalToPortalMinAmount) }}"
                    >
                </div>

                <div class="form-group col-md-12 mb-3">
                    <small class="text-muted">
                        Smallest allowed amount for portal to portal transfer.
                    </small>
                </div>

                <div class="form-group col-md-8 mb-3">
                    <label for="portal_to_portal_max_amount" class="col-sm-4 col-form-label text-right">
                        Portal To Portal Max
                    </label>
                    <input
                        type="number"
                        name="portal_to_portal_max_amount"
                        id="portal_to_portal_max_amount"
                        class="form-control col-sm-8"
                        min="1"
                        required
                        title="Last allowed amount for portal to portal transfer."
                        value="{{ old('portal_to_portal_max_amount', $portalToPortalMaxAmount) }}"
                    >
                </div>

                <div class="form-group col-md-12 mb-3">
                    <small class="text-muted">
                        Largest allowed amount for portal to portal transfer.
                    </small>
                </div>

                <div class="form-group col-md-8 mb-3">
                    <label for="portal_to_portal_step_amount" class="col-sm-4 col-form-label text-right">
                        Portal To Portal Step
                    </label>
                    <input
                        type="number"
                        name="portal_to_portal_step_amount"
                        id="portal_to_portal_step_amount"
                        class="form-control col-sm-8"
                        min="1"
                        required
                        title="Only min plus multiples of this step are allowed."
                        value="{{ old('portal_to_portal_step_amount', $portalToPortalStepAmount) }}"
                    >
                </div>

                <div class="form-group col-md-12 mb-3">
                    <small class="text-muted">
                        Valid portal to portal amount rule is: minimum + step, up to maximum.
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
