@extends('backend.layouts.main')

@section('content')
<div class="body-content">

    <div class="row">
        <div class="col-xl-12 col-sm-12 py-2">
            <div class="card mb-4">

                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Ranking History</h6>
                        </div>

                        <div>
                            <small class="text-muted">
                                Showing Top {{ request('limit', 200) }}
                            </small>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <ul class="nav nav-pills mb-3" id="rank-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show"
                               id="running-sender-tab"
                               data-toggle="pill"
                               href="#running-sender"
                               role="tab">
                                Running Sending
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                               id="running-receiver-tab"
                               data-toggle="pill"
                               href="#running-receiver"
                               role="tab">
                                Running Receiver
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                               id="running-family-tab"
                               data-toggle="pill"
                               href="#running-family"
                               role="tab">
                                Running Family
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                               id="previous-sender-tab"
                               data-toggle="pill"
                               href="#previous-sender"
                               role="tab">
                                Previous Sending
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                               id="previous-receiver-tab"
                               data-toggle="pill"
                               href="#previous-receiver"
                               role="tab">
                                Previous Receiver
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                               id="previous-family-tab"
                               data-toggle="pill"
                               href="#previous-family"
                               role="tab">
                                Previous Family
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" id="rank-tabContent">

                        {{-- Running Sender --}}
                        <div class="tab-pane fade active show"
                             id="running-sender"
                             role="tabpanel">

                            @php
                                $runningSenderTotal = $totalSands->sum('total_sand');
                            @endphp

                            <div class="table-responsive">
                                <table id="table-running-sender"
                                       class="table table-bordered table-striped table-hover rank-table"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @forelse($totalSands as $index => $totalSand)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $totalSand->id }}</td>
                                            <td>{{ $totalSand->name }}</td>
                                            <td>{{ number_format($totalSand->total_sand) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No data found</td>
                                        </tr>
                                    @endforelse
                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-right">Total</th>
                                        <th>{{ number_format($runningSenderTotal) }}</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        {{-- Running Receiver --}}
                        <div class="tab-pane fade"
                             id="running-receiver"
                             role="tabpanel">

                            @php
                                $runningReceiverTotal = $totalReciveds->sum('total_sand');
                            @endphp

                            <div class="table-responsive">
                                <table id="table-running-receiver"
                                       class="table table-bordered table-striped table-hover rank-table"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @forelse($totalReciveds as $index => $totalRecived)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $totalRecived->id }}</td>
                                            <td>{{ $totalRecived->name }}</td>
                                            <td>{{ number_format($totalRecived->total_sand) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No data found</td>
                                        </tr>
                                    @endforelse
                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-right">Total</th>
                                        <th>{{ number_format($runningReceiverTotal) }}</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        {{-- Running Family --}}
                        <div class="tab-pane fade"
                             id="running-family"
                             role="tabpanel">

                            @php
                                $runningFamilyTotal = $totalfamillyReciveds->sum('total_sand');
                            @endphp

                            <div class="table-responsive">
                                <table id="table-running-family"
                                       class="table table-bordered table-striped table-hover rank-table"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @forelse($totalfamillyReciveds as $index => $totalfamillyRecived)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $totalfamillyRecived->code }}</td>
                                            <td>{{ $totalfamillyRecived->name }}</td>
                                            <td>{{ number_format($totalfamillyRecived->total_sand) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No data found</td>
                                        </tr>
                                    @endforelse
                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-right">Total</th>
                                        <th>{{ number_format($runningFamilyTotal) }}</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        {{-- Previous Sender --}}
                        <div class="tab-pane fade"
                             id="previous-sender"
                             role="tabpanel">

                            @php
                                $previousSenderTotal = $previous_totalSands->sum('total_sand');
                            @endphp

                            <div class="table-responsive">
                                <table id="table-previous-sender"
                                       class="table table-bordered table-striped table-hover rank-table"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @forelse($previous_totalSands as $index => $totalSand)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $totalSand->id }}</td>
                                            <td>{{ $totalSand->name }}</td>
                                            <td>{{ number_format($totalSand->total_sand) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No data found</td>
                                        </tr>
                                    @endforelse
                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-right">Total</th>
                                        <th>{{ number_format($previousSenderTotal) }}</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        {{-- Previous Receiver --}}
                        <div class="tab-pane fade"
                             id="previous-receiver"
                             role="tabpanel">

                            @php
                                $previousReceiverTotal = $previous_totalReciveds->sum('total_sand');
                            @endphp

                            <div class="table-responsive">
                                <table id="table-previous-receiver"
                                       class="table table-bordered table-striped table-hover rank-table"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @forelse($previous_totalReciveds as $index => $totalRecived)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $totalRecived->id }}</td>
                                            <td>{{ $totalRecived->name }}</td>
                                            <td>{{ number_format($totalRecived->total_sand) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No data found</td>
                                        </tr>
                                    @endforelse
                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-right">Total</th>
                                        <th>{{ number_format($previousReceiverTotal) }}</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        {{-- Previous Family --}}
                        <div class="tab-pane fade"
                             id="previous-family"
                             role="tabpanel">

                            @php
                                $previousFamilyTotal = $previous_totalfamillyReciveds->sum('total_sand');
                            @endphp

                            <div class="table-responsive">
                                <table id="table-previous-family"
                                       class="table table-bordered table-striped table-hover rank-table"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @forelse($previous_totalfamillyReciveds as $index => $totalfamillyRecived)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $totalfamillyRecived->code }}</td>
                                            <td>{{ $totalfamillyRecived->name }}</td>
                                            <td>{{ number_format($totalfamillyRecived->total_sand) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No data found</td>
                                        </tr>
                                    @endforelse
                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-right">Total</th>
                                        <th>{{ number_format($previousFamilyTotal) }}</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        var initializedTables = {};

        function initRankTable(tableId) {
            if (initializedTables[tableId]) {
                return;
            }

            var table = $('#' + tableId);

            if (!table.length) {
                return;
            }

            if (!$.fn.DataTable) {
                return;
            }

            var hasRealRows = table.find('tbody tr td[colspan]').length === 0;

            if (!hasRealRows) {
                return;
            }

            table.DataTable({
                pageLength: 25,
                lengthMenu: [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, 'All']
                ],
                deferRender: true,
                processing: true,
                ordering: true,
                searching: true,
                responsive: false,
                scrollX: true,
                autoWidth: false,
                destroy: false
            });

            initializedTables[tableId] = true;
        }

        $(document).ready(function () {
            initRankTable('table-running-sender');

            $('a[data-toggle="pill"]').on('shown.bs.tab', function (event) {
                var target = $(event.target).attr('href');

                if (target === '#running-sender') {
                    initRankTable('table-running-sender');
                }

                if (target === '#running-receiver') {
                    initRankTable('table-running-receiver');
                }

                if (target === '#running-family') {
                    initRankTable('table-running-family');
                }

                if (target === '#previous-sender') {
                    initRankTable('table-previous-sender');
                }

                if (target === '#previous-receiver') {
                    initRankTable('table-previous-receiver');
                }

                if (target === '#previous-family') {
                    initRankTable('table-previous-family');
                }
            });
        });
    })();
</script>
@endsection