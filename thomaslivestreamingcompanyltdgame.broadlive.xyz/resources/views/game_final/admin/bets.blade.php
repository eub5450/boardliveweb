@extends('game_final.admin.layout')

@section('eyebrow', 'User Bets')
@section('title', 'Audit user bets and settlement status.')
@section('intro', 'Review bet rows, related rounds, users, and recorded balances.')

@section('content')
    <section class="panel">
        <div class="panel-head">
            <div>
                <h2>Bet audit</h2>
                <p>Inspect recorded bet rows and navigate to the related round or user profile.</p>
            </div>
            <div class="panel-actions">
                <a class="button-secondary" href="{{ route('admin.game-final.rounds') }}">Open Rounds</a>
            </div>
        </div>

        <form class="filter-bar compact" method="get" action="{{ route('admin.game-final.bets') }}">
            <div class="filter-field">
                <label for="bet-game">Game</label>
                <select id="bet-game" name="game">
                    <option value="">All games</option>
                    @foreach ($gameOptions as $option)
                        <option value="{{ $option['game_code'] }}" {{ $selectedGame === $option['game_code'] ? 'selected' : '' }}>{{ $option['name'] }} ({{ $option['game_code'] }})</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-field">
                <label for="bet-status">Status</label>
                <select id="bet-status" name="status">
                    <option value="">All statuses</option>
                    @foreach ($statusOptions as $status)
                        <option value="{{ $status }}" {{ $selectedStatus === $status ? 'selected' : '' }}>{{ strtoupper($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="fast-find">
                <label for="bets-fast-find">Fast Find</label>
                <input id="bets-fast-find" type="text" data-fast-find-input="#bets-table" placeholder="Filter visible rows">
                <small>Searches the current page only.</small>
            </div>
            <div class="filter-actions">
                <button class="button-primary" type="submit">Apply Filters</button>
                <a class="button-secondary" href="{{ route('admin.game-final.bets') }}">Reset</a>
            </div>
        </form>

        @include('game_final.admin.partials.filter-summary', [
            'filters' => [
                ['label' => 'Game', 'value' => data_get(collect($gameOptions)->firstWhere('game_code', $selectedGame), 'name', '')],
                ['label' => 'Status', 'value' => $selectedStatus ?? ''],
            ],
            'clearUrl' => route('admin.game-final.bets'),
        ])

        <div class="table-shell">
            <div class="table-wrap">
                <table class="scan-table scan-table-wide" id="bets-table">
                    <caption class="table-caption">User bets with board, stake, payout, and settlement status</caption>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Game / Round</th>
                            <th>User</th>
                            <th>Board</th>
                            <th>Bet Amount</th>
                            <th>Potential Win</th>
                            <th>Actual Win</th>
                            <th>Balance After</th>
                            <th>Status</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $row)
                            @php
                                $statusClass = in_array($row->status, ['won', 'settled'], true) ? 'won' : (in_array($row->status, ['lost', 'failed'], true) ? 'lost' : 'pending');
                            @endphp
                            <tr data-row-link="{{ route('admin.game-final.rounds.detail', $row->game_round_id) }}">
                                <td data-label="ID"><span class="row-index">{{ $row->id }}</span></td>
                                <td data-label="Game / Round">
                                    <div class="game-meta">
                                        <strong><a class="table-link" href="{{ route('admin.game-final.rounds', ['game' => $row->game_code]) }}">{{ $row->game_name }}</a></strong>
                                        <span><a class="table-link" href="{{ route('admin.game-final.rounds.detail', $row->game_round_id) }}">{{ $row->game_code }} / {{ $row->round_no }}</a></span>
                                    </div>
                                </td>
                                <td data-label="User">
                                    <div class="user-meta">
                                        <strong><a class="table-link" href="{{ route('admin.game-final.users.profile', $row->user_id) }}">{{ $row->user_name ?: 'User #' . $row->user_id }}</a></strong>
                                        <span>{{ $row->user_email ?: 'No email stored' }}</span>
                                    </div>
                                </td>
                                <td data-label="Board">
                                    <div class="stacked-lines">
                                        @include('game_final.admin.partials.board-token', ['key' => $row->frontend_board_key])
                                        <span>Canonical: {{ strtoupper($row->canonical_board_key) }}</span>
                                    </div>
                                </td>
                                <td data-label="Bet Amount"><span class="money-badge">{{ number_format((float) $row->amount, 2) }}</span></td>
                                <td data-label="Potential Win"><span class="money-badge">{{ number_format((float) $row->potential_win, 2) }}</span></td>
                                <td data-label="Actual Win"><span class="money-badge {{ (float) $row->win_balance > 0 ? 'positive' : '' }}">{{ number_format((float) $row->win_balance, 2) }}</span></td>
                                <td data-label="Balance After">
                                    <div class="stacked-lines">
                                        <strong>{{ number_format((float) $row->now_user_balance, 2) }}</strong>
                                        <span>Multiplier: {{ number_format((float) $row->payout_multiplier, 2) }}x</span>
                                    </div>
                                </td>
                                <td data-label="Status">
                                    <div class="stacked-lines">
                                        <span class="status-badge {{ $statusClass }}">{{ strtoupper($row->status) }}</span>
                                        <span class="meta-note">{{ $row->settled_at ? 'Settled at ' . \Illuminate\Support\Carbon::parse($row->settled_at)->format('d M Y H:i') : 'Waiting for settlement' }}</span>
                                    </div>
                                </td>
                                <td data-label="Created">
                                    <div class="stacked-lines">
                                        <strong>{{ \Illuminate\Support\Carbon::parse($row->created_at)->format('d M Y H:i') }}</strong>
                                        <span>Bet created</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-row" data-empty-row>
                                <td colspan="10"><div class="empty-state">No bet rows matched the current filters. <a class="table-link" href="{{ route('admin.game-final.bets') }}">Reset filters</a></div></td>
                            </tr>
                        @endforelse
                        @if ($rows->count() > 0)
                            <tr class="empty-row" data-empty-row style="display:none;">
                                <td colspan="10"><div class="empty-state">No visible rows matched the fast find filter.</div></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        @include('game_final.admin.partials.pagination', ['paginator' => $rows])
    </section>
@endsection
