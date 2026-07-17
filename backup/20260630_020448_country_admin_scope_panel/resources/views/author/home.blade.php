@extends('author.layouts.main')
@section('content')
@php
    $fmt = function ($value) {
        return number_format((float) $value, 0);
    };
    $money = function ($value) {
        return number_format((float) $value, 2);
    };
@endphp

<div class="layout-content">
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="font-weight-bold mb-1">Country Admin Dashboard</h4>
                <div class="text-muted small">
                    {{ $dashboard['country_name'] }} access only · Admin: {{ $dashboard['admin_name'] }} · ID {{ Auth::id() }}
                </div>
            </div>
            <div class="mt-3 mt-sm-0">
                <span class="badge badge-primary p-2">Country ID: {{ $dashboard['country_id'] }}</span>
                <span class="badge badge-success p-2">Live rooms: {{ $fmt($dashboard['live_rooms']) }}</span>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-xl-3">
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted small">Total Users</div>
                                <h3 class="mb-0">{{ $fmt($dashboard['total_users']) }}</h3>
                            </div>
                            <i class="lnr lnr-users display-4 text-primary"></i>
                        </div>
                        <div class="mt-3 small"><span class="badge badge-success">{{ $fmt($dashboard['active_users']) }}</span> active · <span class="badge badge-danger">{{ $fmt($dashboard['blocked_users']) }}</span> blocked</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted small">Hosts</div>
                                <h3 class="mb-0">{{ $fmt($dashboard['active_hosts']) }}</h3>
                            </div>
                            <i class="lnr lnr-mic display-4 text-danger"></i>
                        </div>
                        <div class="mt-3 small"><span class="badge badge-warning">{{ $fmt($dashboard['pending_hosts']) }}</span> pending host approvals</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted small">Agencies</div>
                                <h3 class="mb-0">{{ $fmt($dashboard['agencies']) }}</h3>
                            </div>
                            <i class="lnr lnr-apartment display-4 text-info"></i>
                        </div>
                        <div class="mt-3 small"><span class="badge badge-success">{{ $fmt($dashboard['active_agencies']) }}</span> active · <span class="badge badge-secondary">{{ $fmt($dashboard['pending_agencies']) }}</span> pending</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted small">User Balance</div>
                                <h3 class="mb-0">{{ $money($dashboard['total_balance']) }}</h3>
                            </div>
                            <i class="lnr lnr-diamond display-4 text-success"></i>
                        </div>
                        <div class="mt-3 small"><span class="badge badge-warning">{{ $money($dashboard['hold_balance']) }}</span> hold balance</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4 border-0 shadow-sm bg-primary text-white">
                    <div class="card-body">
                        <div class="small text-white-50">Portal Recharge</div>
                        <h3 class="mb-3">{{ $money($dashboard['portal_recharge']) }}</h3>
                        <div class="d-flex justify-content-between small">
                            <span>Recall: {{ $money($dashboard['portal_recall']) }}</span>
                            <span>Transfer: {{ $money($dashboard['portal_transfer']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mb-4 border-0 shadow-sm bg-success text-white">
                    <div class="card-body">
                        <div class="small text-white-50">Gift Received Value</div>
                        <h3 class="mb-3">{{ $money($dashboard['gift_received_value']) }}</h3>
                        <div class="small">Country scoped by receiver account</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mb-4 border-0 shadow-sm bg-dark text-white">
                    <div class="card-body">
                        <div class="small text-white-50">Gift Sent Value</div>
                        <h3 class="mb-3">{{ $money($dashboard['gift_sent_value']) }}</h3>
                        <div class="small">Country scoped by sender account</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-7">
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Recent Country Users</h6>
                        <a href="{{ route('country.author.host-list') }}" class="btn btn-sm btn-outline-primary">Host list</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Balance</th>
                                    <th>Status</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentUsers as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $money($user->balance) }}</td>
                                        <td>{!! (int) $user->status === 1 ? '<span class="badge badge-success">active</span>' : '<span class="badge badge-danger">blocked</span>' !!}</td>
                                        <td>
                                            @if((int) $user->is_host_id === 1)
                                                <span class="badge badge-danger">host</span>
                                            @elseif((int) $user->is_agency === 1)
                                                <span class="badge badge-info">agency</span>
                                            @else
                                                <span class="badge badge-secondary">user</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center text-muted py-4">No users found for this country.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Top Hosts</h6>
                        <a href="{{ route('country.author.host-pending') }}" class="btn btn-sm btn-outline-warning">Pending hosts</a>
                    </div>
                    <div class="list-group list-group-flush">
                        @forelse($topHosts as $host)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $host->name }}</strong>
                                    <div class="small text-muted">ID {{ $host->id }} · {{ $host->phone }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-weight-bold">{{ $money($host->total_recived_gifts) }}</div>
                                    <div class="small text-muted">gift value</div>
                                </div>
                            </div>
                        @empty
                            <div class="list-group-item text-center text-muted py-4">No active hosts found for this country.</div>
                        @endforelse
                    </div>
                </div>

                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="mb-3">Quick Actions</h6>
                        <div class="d-flex flex-wrap">
                            <a class="btn btn-sm btn-primary mr-2 mb-2" href="{{ route('country.author.agency-list') }}">Agency List</a>
                            <a class="btn btn-sm btn-success mr-2 mb-2" href="{{ route('country.author.agency-add') }}">Add Agency</a>
                            <a class="btn btn-sm btn-danger mr-2 mb-2" href="{{ route('country.author.host-add') }}">Add Host</a>
                            <a class="btn btn-sm btn-dark mr-2 mb-2" href="{{ route('country.author.protal-list') }}">Portal List</a>
                        </div>
                        <div class="small text-muted mt-2">All links and numbers use this admin country scope only.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection