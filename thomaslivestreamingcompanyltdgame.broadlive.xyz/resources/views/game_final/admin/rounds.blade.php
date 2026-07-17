@extends('game_final.admin.layout')

@section('eyebrow', 'Round History')
@section('title', 'Inspect round board totals and user outcomes.')
@section('intro', 'Review round status, winner, timing, and open full round detail.')

@section('content')
    <section class="panel">
        <div class="panel-head">
            <div>
                <h2>Round history</h2>
                <p>Filter round records and open full detail for settlement review.</p>
            </div>
            <div class="panel-actions">
                <a class="button-secondary" href="{{ route('admin.game-final.live-monitor') }}">Live Monitor</a>
                <a class="button-secondary" href="{{ route('admin.game-final.games') }}">Game Details</a>
            </div>
        </div>

        <form class="filter-bar compact" method="get" action="{{ route('admin.game-final.rounds') }}">
            <div class="filter-field">
                <label for="round-game">Game</label>
                <select id="round-game" name="game">
                    <option value="">All games</option>
                    @foreach ($gameOptions as $option)
                        <option value="{{ $option['game_code'] }}" {{ $selectedGame === $option['game_code'] ? 'selected' : '' }}>{{ $option['name'] }} ({{ $option['game_code'] }})</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-field">
                <label for="round-status">Status</label>
                <select id="round-status" name="status">
                    <option value="">All statuses</option>
                    @foreach ($statusOptions as $status)
                        <option value="{{ $status }}" {{ $selectedStatus === $status ? 'selected' : '' }}>{{ strtoupper($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="fast-find">
                <label for="rounds-fast-find">Fast Find</label>
                <input id="rounds-fast-find" type="text" data-fast-find-input="#rounds-table" placeholder="Filter visible rows">
                <small>Searches the current page only.</small>
            </div>
            <div class="filter-actions">
                <button class="button-primary" type="submit">Apply Filters</button>
                <a class="button-secondary" href="{{ route('admin.game-final.rounds') }}">Reset</a>
            </div>
        </form>

        @include('game_final.admin.partials.filter-summary', [
            'filters' => [
                ['label' => 'Game', 'value' => data_get(collect($gameOptions)->firstWhere('game_code', $selectedGame), 'name', '')],
                ['label' => 'Status', 'value' => $selectedStatus ?? ''],
            ],
            'clearUrl' => route('admin.game-final.rounds'),
        ])

        <div class="table-shell">
            <div class="table-wrap">
                <table class="scan-table scan-table-compact" id="rounds-table">
                    <caption class="table-caption">Round history with winner board and settlement timeline</caption>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Game</th>
                            <th>Round</th>
                            <th>Status</th>
                            <th>Winner</th>
                            <th>Decision</th>
                            <th>Timeline</th>
                            <th>Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $row)
                            @php
                                $statusClass = in_array($row->status, ['settled', 'won'], true) ? 'settled' : (in_array($row->status, ['failed', 'inactive', 'lost'], true) ? 'failed' : (in_array($row->status, ['betting', 'processing'], true) ? 'betting' : 'info'));
                            @endphp
                            <tr data-row-link="{{ route('admin.game-final.rounds.detail', $row->id) }}">
                                <td data-label="ID"><span class="row-index"><a class="table-link" href="{{ route('admin.game-final.rounds.detail', $row->id) }}">{{ $row->id }}</a></span></td>
                                <td data-label="Game">
                                    <div class="game-meta">
                                        <strong><a class="table-link" href="{{ route('admin.game-final.rounds', ['game' => $row->game_code]) }}">{{ $row->game_name }}</a></strong>
                                        <span>{{ $row->game_code }}</span>
                                    </div>
                                </td>
                                <td data-label="Round">
                                    <div class="stacked-lines">
                                        <strong><a href="{{ route('admin.game-final.rounds.detail', $row->id) }}">{{ $row->round_no }}</a></strong>
                                        <span>Round record #{{ $row->id }}</span>
                                    </div>
                                </td>
                                <td data-label="Status"><span class="status-badge {{ $statusClass }}">{{ strtoupper($row->status) }}</span></td>
                                <td data-label="Winner">
                                    <div class="stacked-lines">
                                        @include('game_final.admin.partials.board-token', ['key' => $row->winner_board_key ?: '', 'label' => $row->winner_board_key ?: 'Pending'])
                                        <span>Winner board key</span>
                                    </div>
                                </td>
                                <td data-label="Decision">
                                    <div class="stacked-lines">
                                        <strong>{{ $row->decision_mode ?: 'Auto' }}</strong>
                                        <span>Decision strategy</span>
                                    </div>
                                </td>
                                <td data-label="Timeline">
                                    <div class="stacked-lines">
                                        <span>Start: {{ $row->start_at ? \Illuminate\Support\Carbon::parse($row->start_at)->format('d M Y H:i') : 'Pending' }}</span>
                                        <span>Close: {{ $row->bet_close_at ? \Illuminate\Support\Carbon::parse($row->bet_close_at)->format('d M Y H:i') : 'Pending' }}</span>
                                        <span>Settle: {{ $row->settle_at ? \Illuminate\Support\Carbon::parse($row->settle_at)->format('d M Y H:i') : 'Pending' }}</span>
                                    </div>
                                </td>
                                <td data-label="Updated">
                                    <div class="stacked-lines">
                                        <strong>{{ \Illuminate\Support\Carbon::parse($row->updated_at)->format('d M Y H:i') }}</strong>
                                        <span>Latest round update</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-row" data-empty-row>
                                <td colspan="8"><div class="empty-state">No round rows matched the current filters. <a class="table-link" href="{{ route('admin.game-final.rounds') }}">Reset filters</a></div></td>
                            </tr>
                        @endforelse
                        @if ($rows->count() > 0)
                            <tr class="empty-row" data-empty-row style="display:none;">
                                <td colspan="8"><div class="empty-state">No visible rows matched the fast find filter.</div></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        @include('game_final.admin.partials.pagination', ['paginator' => $rows])
    </section>
@endsection
