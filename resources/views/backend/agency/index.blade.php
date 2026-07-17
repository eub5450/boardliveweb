@extends('backend.layouts.main')

@section('title')
Agency Directory
@endsection

@section('content')
<style>
    .agency-page {
        background: #f4f6f8;
        min-height: calc(100vh - 90px);
        padding: 18px;
        color: #111827;
    }
    .agency-panel {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }
    .agency-panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 18px 20px;
        border-bottom: 1px solid #e5e7eb;
        background: linear-gradient(180deg, #ffffff, #f8fafc);
    }
    .agency-panel-header h4 {
        margin: 0;
        color: #111827;
        font-size: 18px;
        font-weight: 800;
    }
    .agency-panel-header span {
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
    }
    .agency-table-wrap {
        padding: 16px;
    }
    .agency-table {
        color: #111827;
        margin-bottom: 0;
        width: 100%;
    }
    .agency-table thead th,
    .agency-table tfoot th {
        background: #f8fafc;
        color: #475569;
        border-color: #e5e7eb;
        font-size: 11px;
        font-weight: 900;
        letter-spacing: 0;
        text-transform: uppercase;
        white-space: nowrap;
    }
    .agency-table td {
        border-color: #e5e7eb;
        font-size: 13px;
        font-weight: 700;
        vertical-align: middle;
        white-space: nowrap;
    }
    .agency-avatar,
    .agency-flag {
        width: 42px;
        height: 42px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        background: #f8fafc;
        object-fit: cover;
    }
    .agency-flag {
        width: 48px;
        height: 32px;
    }
    .agency-badge {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 900;
        padding: 5px 9px;
    }
    .agency-badge-success {
        background: #dcfce7;
        color: #166534;
    }
    .agency-badge-warning {
        background: #fef3c7;
        color: #92400e;
    }
    .agency-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        min-width: 220px;
    }
    .agency-actions .btn,
    .agency-table .btn {
        border-radius: 8px;
        font-size: 11px;
        font-weight: 900;
        padding: 7px 10px;
    }
    .agency-modal .modal-content {
        border: 0;
        border-radius: 8px;
        overflow: hidden;
    }
    .agency-modal .modal-header {
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
    }
    .agency-modal .modal-title {
        color: #111827;
        font-weight: 900;
    }
    @media (max-width: 768px) {
        .agency-page {
            padding: 10px;
        }
        .agency-panel-header {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>

<div class="body-content agency-page">
    <div class="agency-panel">
        <div class="agency-panel-header">
            <div>
                <h4>Agency Directory</h4>
                <span>{{ count($agencys) }} records</span>
            </div>
            <a href="{{ URL::to('agency_create') }}" class="btn btn-primary btn-sm">Create Agency</a>
        </div>
        <div class="agency-table-wrap">
            <div class="table-responsive">
                <table class="table display table-hover basic agency-table">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>ID</th>
                            <th>Level</th>
                            <th>Email</th>
                            <th>Agency Name</th>
                            <th>Agency Code</th>
                            <th>Status</th>
                            <th>Country</th>
                            <th>Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $i = 0; @endphp
                    @foreach($agencys as $item)
                        @php
                            $user = App\Models\User::find($item->user_id);
                            $country = App\Models\Country::find($item->country_id);
                        @endphp
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>
                                @if($user)
                                    <img class="agency-avatar" src="{{ URL::to($item->logo) }}" alt="Agency" onerror="this.style.display='none';">
                                @endif
                            </td>
                            <td>{{ $user->name ?? 'N/A' }}</td>
                            <td>{{ $user->id ?? 'N/A' }}</td>
                            <td>{{ $user->level ?? 'N/A' }}</td>
                            <td>{{ $user->email ?? 'N/A' }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->code }}</td>
                            <td>
                                @if((int) $item->status === 1)
                                    <span class="agency-badge agency-badge-success">Approved</span>
                                @else
                                    <span class="agency-badge agency-badge-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                @if($country)
                                    <img class="agency-flag" src="{{ URL::to($country->flag) }}" alt="{{ $country->name }}" onerror="this.style.display='none';">
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if($user)
                                    @if((int) $user->is_agency === 1)
                                        <a href="{{ URL::to('admin-agency-off/'.$user->id) }}" class="btn btn-sm btn-danger">Inactive</a>
                                    @else
                                        <a href="{{ URL::to('admin-agency-on/'.$user->id) }}" class="btn btn-sm btn-success">Active</a>
                                    @endif
                                @endif
                            </td>
                            <td>
                                <div class="agency-actions">
                                    @if((int) $item->status === 0)
                                        <a href="{{ URL::to('admin-agency-active', $item->id) }}" class="btn btn-sm btn-success">Approve</a>
                                    @else
                                        <a href="{{ URL::to('admin-agency-reject', $item->id) }}" class="btn btn-sm btn-warning">Reject</a>
                                    @endif
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agencyEditModal{{ $item->id }}">Edit</button>
                                </div>

                                <div class="modal fade agency-modal" id="agencyEditModal{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form class="modal-content" action="{{ URL::to('agency_update', $item->id) }}" enctype="multipart/form-data" method="post">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Agency</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Agency Name</label>
                                                    <input type="text" name="name" value="{{ $item->name }}" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Logo</label>
                                                    <input type="file" name="logo" class="form-control" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                                                    <input type="hidden" value="{{ $item->logo }}" name="old_logo">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Sl</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>ID</th>
                            <th>Level</th>
                            <th>Email</th>
                            <th>Agency Name</th>
                            <th>Agency Code</th>
                            <th>Status</th>
                            <th>Country</th>
                            <th>Active</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
