@extends('game_final.admin.layout')

@section('eyebrow', 'Wallet And Lock Control')
@section('title', 'Manage user balances and entry locks.')
@section('intro', 'Search users, review balance, and apply secure admin actions.')

@section('content')
    <section class="panel" style="margin-bottom:18px;">
        <div class="panel-head">
            <div>
                <h2>Current Shared Game Bank</h2>
                <p>All games now use one shared bank. Bets add into the shared pool, payouts leave from the same pool, and the selected game is used only as audit context.</p>
            </div>
        </div>

        <div class="panel-toolbar">
            <div class="toolbar-pills">
                <span class="toolbar-pill">Shared Balance: {{ number_format((float) ($sharedGameBalance ?? 0), 2) }}</span>
            </div>
        </div>
    </section>

    <section class="panel" style="margin-bottom:18px;">
        <div class="panel-head">
            <div>
                <h2>User Wallet Transfer</h2>
                <p>These transfers move value between one user wallet and the shared game bank. The selected game remains as audit context so you can see where the action came from.</p>
            </div>
        </div>

        <form class="filter-bar" method="post" action="{{ route('admin.game-final.wallet-transfer') }}" data-confirm="Confirm wallet transfer?" data-confirm-warning="This changes the user wallet and shared game balance immediately." data-confirm-label="Apply transfer">
            @csrf
            <div class="filter-field">
                <label>User ID</label>
                <input type="number" name="user_id" min="1" value="{{ old('user_id') }}" required>
            </div>
            <div class="filter-field">
                <label>Game</label>
                <select name="game_code" required>
                    <option value="">Select Game Context</option>
                    @foreach ($gameOptions as $game)
                        <option value="{{ $game['game_code'] }}" {{ old('game_code') === $game['game_code'] ? 'selected' : '' }}>{{ $game['name'] }} | Shared bank {{ number_format((float) ($sharedGameBalance ?? 0), 2) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-field">
                <label>Direction</label>
                <select name="direction" required>
                    <option value="deposit" {{ old('direction') === 'deposit' ? 'selected' : '' }}>Credit User From Game Bank</option>
                    <option value="withdraw" {{ old('direction') === 'withdraw' ? 'selected' : '' }}>Return User Funds To Game Bank</option>
                </select>
            </div>
            <div class="filter-field">
                <label>Amount</label>
                <input type="number" name="amount" min="0.01" step="0.01" value="{{ old('amount') }}" required>
            </div>
            <div class="filter-field">
                <label>Admin Note</label>
                <input type="text" name="note" maxlength="255" value="{{ old('note') }}" placeholder="Reason or ticket number">
            </div>
            <div class="filter-actions">
                <button class="button-primary" type="submit">Apply Transfer</button>
            </div>
        </form>
    </section>

    <section class="panel" style="margin-bottom:18px;">
        <div class="panel-head">
            <div>
                <h2>User Lock</h2>
                <p>Locks block game entry and revoke active game sessions. Use this for security, abuse, or support holds with a clear reason.</p>
            </div>
        </div>

        <form class="filter-bar" method="post" action="{{ route('admin.game-final.user-lock') }}" data-confirm="Confirm user lock?" data-confirm-warning="The user will lose game access immediately." data-confirm-label="Lock user">
            @csrf
            <div class="filter-field">
                <label>User ID</label>
                <input type="number" name="user_id" min="1" value="{{ old('lock_user_id') }}" required>
            </div>
            <div class="filter-field">
                <label>Scope</label>
                <select name="game_code">
                    <option value="">All Games</option>
                    @foreach ($gameOptions as $game)
                        <option value="{{ $game['game_code'] }}">{{ $game['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-field">
                <label>Reason</label>
                <input type="text" name="reason" maxlength="255" value="{{ old('reason') }}" required placeholder="Security hold, support review, abuse report">
            </div>
            <div class="filter-actions">
                <button class="button-secondary" type="submit">Lock User</button>
            </div>
        </form>
    </section>

    <section class="panel" style="margin-bottom:18px;">
        <div class="panel-head">
            <div>
                <h2>User Search</h2>
                <p>Find players by user ID, name, or email. The balance column reads <strong>{{ $walletColumn }}</strong>.</p>
            </div>
        </div>

        <form class="filter-bar compact" method="get" action="{{ route('admin.game-final.users') }}">
            <div class="filter-field">
                <label>Search</label>
                <input type="text" name="search" value="{{ $search }}" placeholder="ID, name, or email">
            </div>
            <div class="filter-field">
                <label>Game Lock Scope</label>
                <select name="game">
                    <option value="">All Games</option>
                    @foreach ($gameOptions as $game)
                        <option value="{{ $game['game_code'] }}" {{ $selectedGame === $game['game_code'] ? 'selected' : '' }}>{{ $game['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="fast-find">
                <label for="users-fast-find">Fast Find</label>
                <input id="users-fast-find" type="text" data-fast-find-input="#users-table" placeholder="Filter visible rows">
                <small>Searches the current page only.</small>
            </div>
            <div class="filter-actions">
                <button class="button-primary" type="submit">Search Users</button>
                <a class="button-secondary" href="{{ route('admin.game-final.users') }}">Clear</a>
            </div>
        </form>

        @include('game_final.admin.partials.filter-summary', [
            'filters' => [
                ['label' => 'Search', 'value' => $search ?? ''],
                ['label' => 'Game', 'value' => data_get(collect($gameOptions)->firstWhere('game_code', $selectedGame), 'name', '')],
            ],
            'clearUrl' => route('admin.game-final.users'),
        ])

        <div class="table-shell">
            <div class="table-wrap">
                <table class="scan-table scan-table-compact" id="users-table">
                    <caption class="table-caption">Users with wallet balance, lock count, and API access status</caption>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Balance</th>
                            <th>Active Locks</th>
                            <th>API Access</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $user)
                            <tr data-row-link="{{ route('admin.game-final.users.profile', $user->id) }}">
                                <td data-label="ID"><span class="row-index"><a class="table-link" href="{{ route('admin.game-final.users.profile', $user->id) }}">{{ $user->id }}</a></span></td>
                                <td data-label="User">
                                    <div class="user-meta">
                                        <strong><a class="table-link" href="{{ route('admin.game-final.users.profile', $user->id) }}">{{ $user->name ?: 'Unnamed User' }}</a></strong>
                                        <span>{{ $user->email ?: 'no email' }}</span>
                                    </div>
                                </td>
                                <td data-label="Balance"><span class="money-badge positive">{{ number_format((float) ($user->{$walletColumn} ?? 0), 2) }}</span></td>
                                <td data-label="Active Locks"><span class="status-badge {{ $user->active_game_locks_count ? 'off' : 'on' }}">{{ $user->active_game_locks_count ? $user->active_game_locks_count . ' Locked' : 'Clear' }}</span></td>
                                <td data-label="API Access"><span class="status-badge {{ !empty($user->is_app_access) ? 'on' : 'info' }}">{{ !empty($user->is_app_access) ? 'Enabled' : 'Standard' }}</span></td>
                                <td data-label="Action"><a class="button-secondary button-small" href="{{ route('admin.game-final.users.profile', $user->id) }}">View Profile</a></td>
                            </tr>
                        @empty
                            <tr class="empty-row" data-empty-row><td colspan="6"><div class="empty-state">No users matched this search. <a class="table-link" href="{{ route('admin.game-final.users') }}">Reset filters</a></div></td></tr>
                        @endforelse
                        @if ($rows->count() > 0)
                            <tr class="empty-row" data-empty-row style="display:none;"><td colspan="6"><div class="empty-state">No visible rows matched the fast find filter.</div></td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        @include('game_final.admin.partials.pagination', ['paginator' => $rows])
    </section>

    <section class="panel" style="margin-bottom:18px;">
        <div class="panel-head">
            <div>
                <h2>Active Locks</h2>
                <p>Recent active user locks. Lift a lock only when the support or security review is complete.</p>
            </div>
        </div>

        <div class="table-shell">
            <div class="table-wrap">
                <table class="scan-table scan-table-compact">
                    <caption class="table-caption">Active user locks and unlock actions</caption>
                    <thead>
                        <tr>
                            <th>Lock ID</th>
                            <th>User</th>
                            <th>Game</th>
                            <th>Reason</th>
                            <th>Blocked At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($activeBlocks as $block)
                            <tr>
                                <td><span class="row-index">{{ $block->id }}</span></td>
                                <td>
                                    <div class="user-meta">
                                        <strong>#{{ $block->user_id }} {{ $block->user_name ?: '' }}</strong>
                                        <span>{{ $block->user_email ?: 'no email' }}</span>
                                    </div>
                                </td>
                                <td><span class="board-badge">{{ $block->game_name ?: 'All Games' }}</span></td>
                                <td>{{ $block->reason }}</td>
                                <td>{{ $block->blocked_at ? $block->blocked_at->format('Y-m-d H:i:s') : '-' }}</td>
                                <td>
                                    <form method="post" action="{{ route('admin.game-final.user-lock.lift', $block->id) }}" data-confirm="Lift this user lock?" data-confirm-label="Unlock user">
                                        @csrf
                                        <button class="button-secondary" type="submit">Unlock</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6"><div class="empty-state">No active user locks.</div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="panel">
        <div class="panel-head">
            <div>
                <h2>Recent Admin Transfers</h2>
                <p>Last wallet rows created from this admin panel.</p>
            </div>
        </div>

        <div class="table-shell">
            <div class="table-wrap">
                <table class="scan-table scan-table-wide">
                    <caption class="table-caption">Recent admin wallet transfer rows</caption>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Game</th>
                            <th>Direction</th>
                            <th>Amount</th>
                            <th>Before</th>
                            <th>After</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($walletRows as $row)
                            <tr>
                                <td><span class="row-index">{{ $row->id }}</span></td>
                                <td>#{{ $row->user_id }} {{ $row->user_name ?: $row->user_email }}</td>
                                <td><span class="board-badge">{{ $row->game_name ?: 'All Games' }}</span></td>
                                <td><span class="status-badge {{ $row->direction === 'credit' ? 'on' : 'off' }}">{{ strtoupper($row->direction) }}</span></td>
                                <td><span class="money-badge {{ $row->direction === 'credit' ? 'positive' : 'negative' }}">{{ number_format((float) $row->amount, 2) }}</span></td>
                                <td>{{ number_format((float) $row->balance_before, 2) }}</td>
                                <td>{{ number_format((float) $row->balance_after, 2) }}</td>
                                <td>{{ $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="8"><div class="empty-state">No admin wallet transfers yet.</div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
