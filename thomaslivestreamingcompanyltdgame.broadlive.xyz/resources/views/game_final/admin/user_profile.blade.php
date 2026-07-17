@extends('game_final.admin.layout')

@section('eyebrow', 'User Game Profile')
@section('title', 'User #' . $profileUser->id . ' activity profile.')
@section('intro', 'Review balance, lock state, game totals, and recent bets for one user.')

@section('content')
    <section class="panel" style="margin-bottom:18px;" data-tour-title="User Overview" data-tour-body="Confirm the user identity and wallet column used for reporting. Use Back To Search to return to the user list.">
        <div class="panel-head">
            <div>
                <h2>{{ $profileUser->name ?: 'Unnamed User' }}</h2>
                <p>{{ $profileUser->email ?: 'No email stored' }} / Balance column: <strong>{{ $walletColumn }}</strong></p>
            </div>
            <div class="panel-actions">
                <a class="button-secondary" href="{{ route('admin.game-final.users') }}">Back To Search</a>
            </div>
        </div>

        <div class="panel-toolbar" data-tour-title="Wallet Snapshot" data-tour-body="This section shows the current wallet balance and headline activity totals across the selected scope.">
            <div class="toolbar-copy">Wallet balance: <strong>{{ number_format((float) ($profileUser->{$walletColumn} ?? 0), 2) }}</strong></div>
            <div class="toolbar-pills">
                <span class="toolbar-pill">Games: {{ number_format((int) ($globalStats->game_count ?? 0)) }}</span>
                <span class="toolbar-pill">Rounds: {{ number_format((int) ($globalStats->round_count ?? 0)) }}</span>
                <span class="toolbar-pill">Bets: {{ number_format((int) ($globalStats->bet_count ?? 0)) }}</span>
            </div>
        </div>
    </section>

    <div class="stats" data-tour-title="Activity Summary" data-tour-body="Totals for bid volume, loss, win, and net outcome. Use these numbers to validate support cases and audit settlement accuracy.">
        <div class="stat">
            <b>Total Bid</b>
            <strong>{{ number_format((float) ($globalStats->total_bid_amount ?? 0), 2) }}</strong>
            <span>All selected game activity.</span>
        </div>
        <div class="stat">
            <b>Loss Amount</b>
            <strong>{{ number_format((float) ($globalStats->total_loss_amount ?? 0), 2) }}</strong>
            <span>Total losing bet amount.</span>
        </div>
        <div class="stat">
            <b>Win Amount</b>
            <strong>{{ number_format((float) ($globalStats->total_win_amount ?? 0), 2) }}</strong>
            <span>Total credited win balance.</span>
        </div>
        <div class="stat">
            <b>Profit / Loss</b>
            <strong>{{ number_format((float) ($globalStats->net_profit_loss ?? 0), 2) }}</strong>
            <span>Win amount minus bid amount.</span>
        </div>
    </div>

    <section class="panel" style="margin-bottom:18px;" data-tour-title="User Controls" data-tour-body="Lock the user for security/support holds. Outcomes remain controlled by audited round settlement; admin tools do not force winners.">
        <div class="panel-head">
            <div>
                <h2>Controls</h2>
                <p>Use lock for security or support holds. Win targeting is not available; outcomes remain governed by game rules and audited settlement data.</p>
            </div>
        </div>

        <form class="filter-bar" method="post" action="{{ route('admin.game-final.user-lock') }}" data-confirm="Confirm user lock?" data-confirm-warning="This user will lose game access immediately." data-confirm-label="Lock user" data-tour-title="Lock Workflow" data-tour-body="Choose a scope (optional), enter a reason, then submit. The lock is enforced immediately for game entry.">
            @csrf
            <input type="hidden" name="user_id" value="{{ $profileUser->id }}">
            <div class="filter-field">
                <label>Scope</label>
                <select name="game_code">
                    <option value="">All Games</option>
                    @foreach ($gameOptions as $game)
                        <option value="{{ $game['game_code'] }}" {{ $selectedGame === $game['game_code'] ? 'selected' : '' }}>{{ $game['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-field">
                <label>Reason</label>
                <input type="text" name="reason" maxlength="255" required placeholder="Security hold, support review, abuse report">
            </div>
            <div class="filter-actions">
                <button class="button-secondary" type="submit">Lock User</button>
            </div>
        </form>
    </section>

    <section class="panel" style="margin-bottom:18px;" data-tour-title="Game Totals" data-tour-body="Totals grouped per game. Use these rows to compare volume and profitability between games for this user.">
        <div class="panel-head">
            <div>
                <h2>Game Wise Totals</h2>
                <p>Total bid, loss, win, and net profit/loss per game.</p>
            </div>
        </div>

        <div class="table-shell">
            <div class="table-wrap">
                <table class="scan-table scan-table-compact">
                    <caption class="table-caption">User totals grouped by game</caption>
                    <thead>
                        <tr>
                            <th>Game</th>
                            <th>Rounds</th>
                            <th>Bets</th>
                            <th>Total Bid</th>
                            <th>Loss</th>
                            <th>Win</th>
                            <th>Profit / Loss</th>
                            <th>Last Played</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($gameStats as $row)
                            @php $net = (float) $row->net_profit_loss; @endphp
                            <tr>
                                <td data-label="Game">
                                    <div class="game-meta">
                                        <strong><a class="table-link" href="{{ route('admin.game-final.rounds', ['game' => $row->game_code]) }}">{{ $row->game_name }}</a></strong>
                                        <span>{{ $row->game_code }}</span>
                                    </div>
                                </td>
                                <td data-label="Rounds">{{ number_format((int) $row->round_count) }}</td>
                                <td data-label="Bets">{{ number_format((int) $row->bet_count) }}</td>
                                <td data-label="Total Bid"><span class="money-badge">{{ number_format((float) $row->total_bid_amount, 2) }}</span></td>
                                <td data-label="Loss"><span class="money-badge negative">{{ number_format((float) $row->total_loss_amount, 2) }}</span></td>
                                <td data-label="Win"><span class="money-badge positive">{{ number_format((float) $row->total_win_amount, 2) }}</span></td>
                                <td data-label="Profit / Loss"><span class="money-badge {{ $net >= 0 ? 'positive' : 'negative' }}">{{ number_format($net, 2) }}</span></td>
                                <td data-label="Last Played">{{ $row->last_played_at ? \Illuminate\Support\Carbon::parse($row->last_played_at)->format('Y-m-d H:i:s') : '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="8"><div class="empty-state">No game activity found for this user.</div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="panel" style="margin-bottom:18px;">
        <div class="panel-head" data-tour-title="Active Locks" data-tour-body="Locks currently affecting this user. Unlocking removes the entry block immediately for the selected scope.">
            <div>
                <h2>Active Locks</h2>
                <p>Locks currently affecting this user.</p>
            </div>
        </div>
        <div class="table-shell">
            <div class="table-wrap">
                <table class="scan-table scan-table-compact">
                    <caption class="table-caption">Active locks for this user</caption>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Game</th>
                            <th>Reason</th>
                            <th>Blocked</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($activeBlocks as $block)
                            <tr>
                                <td data-label="ID"><span class="row-index">{{ $block->id }}</span></td>
                                <td data-label="Game">{{ $block->game_name ?: 'All Games' }}</td>
                                <td data-label="Reason">{{ $block->reason }}</td>
                                <td data-label="Blocked">{{ $block->blocked_at ? $block->blocked_at->format('Y-m-d H:i:s') : '-' }}</td>
                                <td data-label="Action">
                                    <form method="post" action="{{ route('admin.game-final.user-lock.lift', $block->id) }}" data-confirm="Lift this user lock?" data-confirm-label="Unlock user">
                                        @csrf
                                        <button class="button-secondary" type="submit">Unlock</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5"><div class="empty-state">No active locks for this user.</div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

        <section class="panel" data-tour-title="Bid History" data-tour-body="Recent bet rows for this user. Use the filter to narrow by game and click any row to open round detail.">
            <div class="panel-head">
                <div>
                    <h2>Bid List</h2>
                    <p>Recent bid rows for this user, paginated and filterable by game.</p>
                </div>
            </div>

        <form class="filter-bar compact" method="get" action="{{ route('admin.game-final.users.profile', $profileUser->id) }}">
            <div class="filter-field">
                <label>Game</label>
                <select name="game">
                    <option value="">All Games</option>
                    @foreach ($gameOptions as $game)
                        <option value="{{ $game['game_code'] }}" {{ $selectedGame === $game['game_code'] ? 'selected' : '' }}>{{ $game['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="fast-find">
                <label for="profile-fast-find">Fast Find</label>
                <input id="profile-fast-find" type="text" data-fast-find-input="#user-bets-table" placeholder="Filter visible rows">
                <small>Searches the current page only.</small>
            </div>
            <div class="filter-actions">
                <button class="button-primary" type="submit">Apply</button>
                <a class="button-secondary" href="{{ route('admin.game-final.users.profile', $profileUser->id) }}">Clear</a>
            </div>
        </form>

        @include('game_final.admin.partials.filter-summary', [
            'filters' => [
                ['label' => 'Game', 'value' => data_get(collect($gameOptions)->firstWhere('game_code', $selectedGame), 'name', '')],
            ],
            'clearUrl' => route('admin.game-final.users.profile', $profileUser->id),
        ])

        <div class="table-shell">
            <div class="table-wrap">
                <table class="scan-table scan-table-wide" id="user-bets-table">
                    <caption class="table-caption">User bid history rows</caption>
                    <thead>
                        <tr>
                            <th>Bet</th>
                            <th>Game / Round</th>
                            <th>Board</th>
                            <th>Winner</th>
                            <th>Bid</th>
                            <th>Potential</th>
                            <th>Win</th>
                            <th>Profit / Loss</th>
                            <th>Status</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($betRows as $row)
                            @php $net = (float) $row->win_balance - (float) $row->amount; @endphp
                            <tr data-row-link="{{ route('admin.game-final.rounds.detail', $row->game_round_id) }}">
                                <td data-label="Bet"><span class="row-index">{{ $row->id }}</span></td>
                                <td data-label="Game / Round">
                                    <div class="game-meta">
                                        <strong><a class="table-link" href="{{ route('admin.game-final.rounds', ['game' => $row->game_code]) }}">{{ $row->game_name }}</a></strong>
                                        <span><a class="table-link" href="{{ route('admin.game-final.rounds.detail', $row->game_round_id) }}">{{ $row->round_no ?: 'round #' . $row->game_round_id }}</a></span>
                                    </div>
                                </td>
                                <td data-label="Board">@include('game_final.admin.partials.board-token', ['key' => $row->canonical_board_key, 'label' => $row->canonical_board_key])</td>
                                <td data-label="Winner">@include('game_final.admin.partials.board-token', ['key' => $row->winner_board_key ?: '', 'label' => $row->winner_board_key ?: 'Pending'])</td>
                                <td data-label="Bid"><span class="money-badge">{{ number_format((float) $row->amount, 2) }}</span></td>
                                <td data-label="Potential"><span class="money-badge">{{ number_format((float) $row->potential_win, 2) }}</span></td>
                                <td data-label="Win"><span class="money-badge positive">{{ number_format((float) $row->win_balance, 2) }}</span></td>
                                <td data-label="Profit / Loss"><span class="money-badge {{ $net >= 0 ? 'positive' : 'negative' }}">{{ number_format($net, 2) }}</span></td>
                                <td data-label="Status"><span class="status-badge {{ $row->status === 'won' ? 'won' : ($row->status === 'lost' ? 'lost' : 'pending') }}">{{ strtoupper($row->status) }}</span></td>
                                <td data-label="Created">{{ $row->created_at ? \Illuminate\Support\Carbon::parse($row->created_at)->format('Y-m-d H:i:s') : '-' }}</td>
                            </tr>
                        @empty
                            <tr class="empty-row" data-empty-row><td colspan="10"><div class="empty-state">No bid rows found for this user.</div></td></tr>
                        @endforelse
                        @if ($betRows->count() > 0)
                            <tr class="empty-row" data-empty-row style="display:none;"><td colspan="10"><div class="empty-state">No visible rows matched the fast find filter.</div></td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        @include('game_final.admin.partials.pagination', ['paginator' => $betRows])
    </section>
@endsection
