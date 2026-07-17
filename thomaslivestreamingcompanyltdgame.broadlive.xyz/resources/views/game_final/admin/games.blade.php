@extends('game_final.admin.layout')

@section('eyebrow', 'Game Details')
@section('title', 'Review game configuration and risk limits.')
@section('intro', 'Inspect room status, board rules, bet limits, and timing settings.')

@section('content')
    <section class="panel">
        <div class="panel-head">
            <div>
                <h2>Game configuration</h2>
                <p>Inspect stored room settings and open the matching lobby control quickly.</p>
            </div>
            <div class="panel-actions">
                <a class="button-secondary" href="{{ route('admin.dashboard') }}">Open Lobby Control</a>
            </div>
        </div>

        <form class="filter-bar compact" method="get" action="{{ route('admin.game-final.games') }}">
            <div class="filter-field">
                <label for="games-search">Search</label>
                <input id="games-search" type="text" name="search" value="{{ $search ?? '' }}" placeholder="Game name, code, family">
            </div>
            <div class="filter-field">
                <label for="games-status">Status</label>
                <select id="games-status" name="status">
                    <option value="">All statuses</option>
                    @foreach (['live' => 'Live', 'developer' => 'Developer', 'maintenance' => 'Maintenance'] as $statusValue => $statusLabel)
                        <option value="{{ $statusValue }}" {{ ($selectedStatus ?? '') === $statusValue ? 'selected' : '' }}>{{ $statusLabel }}</option>
                    @endforeach
                </select>
            </div>
            <div class="fast-find">
                <label for="games-fast-find">Fast Find</label>
                <input id="games-fast-find" type="text" data-fast-find-input="#games-table" placeholder="Filter visible rows">
                <small>Filters the current page instantly.</small>
            </div>
            <div class="filter-actions">
                <button class="button-primary" type="submit">Apply</button>
                <a class="button-secondary" href="{{ route('admin.game-final.games') }}">Reset</a>
            </div>
        </form>

        @include('game_final.admin.partials.filter-summary', [
            'filters' => [
                ['label' => 'Search', 'value' => $search ?? ''],
                ['label' => 'Status', 'value' => $selectedStatus ?? ''],
            ],
            'clearUrl' => route('admin.game-final.games'),
        ])

        <div class="panel-toolbar">
            <div class="toolbar-copy">Game details include room family, visibility, board rules, limits, timers, and risk mode.</div>
            <div class="toolbar-pills">
                <span class="toolbar-pill">Rows: {{ $rowCount }}</span>
                <span class="toolbar-pill">Visible: {{ $adminCounts['visible_games'] }}</span>
                <span class="toolbar-pill">Hidden: {{ $adminCounts['hidden_games'] }}</span>
            </div>
        </div>

        <div class="table-shell">
            <div class="table-wrap">
                <table class="scan-table scan-table-wide" id="games-table">
                    <caption class="table-caption">Configured game details and risk settings</caption>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Game</th>
                            <th>Family</th>
                            <th>Preview</th>
                            <th>Lobby</th>
                            <th>Board Rules</th>
                            <th>Bet Range</th>
                            <th>Round Timers</th>
                            <th>Risk</th>
                            <th>Updated</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gameRows as $game)
                            @php
                                $familyClass = $game['family'] === 'Teen Patti' ? 'teen' : ($game['family'] === 'Lucky Wheel' ? 'lucky' : 'fruit');
                            @endphp
                            <tr class="{{ $game['enabled'] ? '' : 'is-disabled' }}" data-row-link="{{ route('admin.dashboard') }}#game-{{ $game['game_code'] }}">
                                <td data-label="#"><span class="row-index">{{ $loop->iteration }}</span></td>
                                <td data-label="Game">
                                    <div class="game-meta">
                                        <strong><a class="table-link" href="{{ route('admin.dashboard') }}#game-{{ $game['game_code'] }}">{{ $game['name'] }}</a></strong>
                                        <span>{{ $game['game_code'] }}</span>
                                    </div>
                                </td>
                                <td data-label="Family"><span class="family-badge {{ $familyClass }}">{{ $game['family'] }}</span></td>
                                <td data-label="Preview">
                                    <div class="preview-list">
                                        @foreach ($game['preview'] as $preview)
                                            @include('game_final.admin.partials.board-token', ['key' => $preview, 'label' => $preview])
                                        @endforeach
                                    </div>
                                </td>
                                <td data-label="Lobby">
                                    <div class="stacked-lines">
                                        <span class="status-badge {{ $game['enabled'] ? 'on' : 'off' }}">{{ $game['enabled'] ? 'Visible' : 'Hidden' }}</span>
                                        <span class="meta-note">Stored status: {{ strtoupper($game['game_status']) }}</span>
                                    </div>
                                </td>
                                <td data-label="Board Rules">
                                    <div class="stacked-lines">
                                        <strong>{{ $game['board_count'] }} boards total</strong>
                                        <span>Per user limit: {{ $game['max_distinct_boards_per_user'] }}</span>
                                    </div>
                                </td>
                                <td data-label="Bet Range">
                                    <div class="stacked-lines">
                                        <strong>Min: {{ number_format($game['min_bet'], 2) }}</strong>
                                        <span>Max: {{ number_format($game['max_bet'], 2) }}</span>
                                    </div>
                                </td>
                                <td data-label="Round Timers">
                                    <div class="stacked-lines">
                                        <strong>Bet: {{ $game['bet_duration_sec'] }}s</strong>
                                        <span>Reveal: {{ $game['reveal_duration_sec'] }}s</span>
                                        <span>Settle: {{ $game['settle_duration_sec'] }}s</span>
                                    </div>
                                </td>
                                <td data-label="Risk">
                                    <div class="stacked-lines">
                                        <strong>{{ str_replace('_', ' ', strtoupper($game['risk_mode'])) }}</strong>
                                        <span>Weighted random: {{ $game['weighted_random_enabled'] ? 'On' : 'Off' }}</span>
                                    </div>
                                </td>
                                <td data-label="Updated">
                                    <div class="stacked-lines">
                                        <strong>{{ $game['updated_at_label'] }}</strong>
                                        <span>Latest saved game/settings sync</span>
                                    </div>
                                </td>
                                <td data-label="Action">
                                    <div class="table-actions">
                                        <a class="button-secondary button-small" href="{{ route('admin.dashboard') }}#game-{{ $game['game_code'] }}">Open in Lobby</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if ($gameRows->isEmpty())
                            <tr class="empty-row" data-empty-row>
                                <td colspan="11"><div class="empty-state">No game rows matched the current filters. <a class="table-link" href="{{ route('admin.game-final.games') }}">Reset filters</a></div></td>
                            </tr>
                        @else
                            <tr class="empty-row" data-empty-row style="display:none;">
                                <td colspan="11"><div class="empty-state">No visible rows matched the fast find filter.</div></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
