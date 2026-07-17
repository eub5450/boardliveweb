@extends('game_final.admin.layout')

@section('eyebrow', 'Payout History')
@section('title', 'Audit payout results and wallet movement.')
@section('intro', 'Review settled user outcomes, net result, and wallet updates.')

@section('content')
    <section class="panel">
        <div class="panel-head">
            <div>
                <h2>Payout audit</h2>
                <p>Inspect final user outcomes and open related rounds or profiles.</p>
            </div>
            <div class="panel-actions">
                <a class="button-secondary" href="{{ route('admin.game-final.bets') }}">Open Bets</a>
            </div>
        </div>

        <form class="filter-bar compact" method="get" action="{{ route('admin.game-final.payouts') }}">
            <div class="filter-field">
                <label for="payout-game">Game</label>
                <select id="payout-game" name="game">
                    <option value="">All games</option>
                    @foreach ($gameOptions as $option)
                        <option value="{{ $option['game_code'] }}" {{ $selectedGame === $option['game_code'] ? 'selected' : '' }}>{{ $option['name'] }} ({{ $option['game_code'] }})</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-field">
                <label for="payout-status">Result Status</label>
                <select id="payout-status" name="status">
                    <option value="">All result statuses</option>
                    @foreach ($statusOptions as $status)
                        <option value="{{ $status }}" {{ $selectedStatus === $status ? 'selected' : '' }}>{{ strtoupper($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="fast-find">
                <label for="payouts-fast-find">Fast Find</label>
                <input id="payouts-fast-find" type="text" data-fast-find-input="#payouts-table" placeholder="Filter visible rows">
                <small>Searches the current page only.</small>
            </div>
            <div class="filter-actions">
                <button class="button-primary" type="submit">Apply Filters</button>
                <a class="button-secondary" href="{{ route('admin.game-final.payouts') }}">Reset</a>
            </div>
        </form>

        @include('game_final.admin.partials.filter-summary', [
            'filters' => [
                ['label' => 'Game', 'value' => data_get(collect($gameOptions)->firstWhere('game_code', $selectedGame), 'name', '')],
                ['label' => 'Result', 'value' => $selectedStatus ?? ''],
            ],
            'clearUrl' => route('admin.game-final.payouts'),
        ])

        <div class="table-shell">
            <div class="table-wrap">
                <table class="scan-table scan-table-wide" id="payouts-table">
                    <caption class="table-caption">Payout rows with board result and wallet movement</caption>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Game / Round</th>
                            <th>User</th>
                            <th>Board</th>
                            <th>Bet</th>
                            <th>Multiplier</th>
                            <th>Win</th>
                            <th>Net Result</th>
                            <th>Wallet</th>
                            <th>Status</th>
                            <th>Settled</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $row)
                            @php
                                $resultClass = $row->result_status === 'won' ? 'won' : ($row->result_status === 'lost' ? 'lost' : 'pending');
                                $settlementClass = $row->settlement_status === 'settled' ? 'settled' : ($row->settlement_status === 'failed' ? 'failed' : 'processing');
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
                                <td data-label="Board">@include('game_final.admin.partials.board-token', ['key' => $row->canonical_board_key])</td>
                                <td data-label="Bet"><span class="money-badge">{{ number_format((float) $row->bet_amount, 2) }}</span></td>
                                <td data-label="Multiplier"><span class="money-badge">{{ number_format((float) $row->payout_multiplier, 2) }}x</span></td>
                                <td data-label="Win"><span class="money-badge {{ (float) $row->win_amount > 0 ? 'positive' : '' }}">{{ number_format((float) $row->win_amount, 2) }}</span></td>
                                <td data-label="Net Result"><span class="money-badge {{ (float) $row->net_result >= 0 ? 'positive' : 'negative' }}">{{ number_format((float) $row->net_result, 2) }}</span></td>
                                <td data-label="Wallet">
                                    <div class="wallet-note">
                                        {{ number_format((float) $row->wallet_before, 2) }} -> {{ number_format((float) $row->wallet_after, 2) }}
                                    </div>
                                </td>
                                <td data-label="Status">
                                    <div class="stacked-lines">
                                        <span class="status-badge {{ $resultClass }}">{{ strtoupper($row->result_status) }}</span>
                                        <span class="status-badge {{ $settlementClass }}">{{ strtoupper($row->settlement_status) }}</span>
                                    </div>
                                </td>
                                <td data-label="Settled">
                                    <div class="stacked-lines">
                                        <strong>{{ $row->settled_at ? \Illuminate\Support\Carbon::parse($row->settled_at)->format('d M Y H:i') : 'Pending' }}</strong>
                                        <span>Row created: {{ \Illuminate\Support\Carbon::parse($row->created_at)->format('d M Y H:i') }}</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-row" data-empty-row>
                                <td colspan="11"><div class="empty-state">No payout rows matched the current filters. <a class="table-link" href="{{ route('admin.game-final.payouts') }}">Reset filters</a></div></td>
                            </tr>
                        @endforelse
                        @if ($rows->count() > 0)
                            <tr class="empty-row" data-empty-row style="display:none;">
                                <td colspan="11"><div class="empty-state">No visible rows matched the fast find filter.</div></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        @include('game_final.admin.partials.pagination', ['paginator' => $rows])
    </section>
@endsection
