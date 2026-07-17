@extends('game_final.admin.layout')

@section('eyebrow', 'Round Detail')
@section('title', 'Round #' . $round->id . ' detail.')
@section('intro', 'Inspect board totals, winner details, and user outcomes for one round.')

@section('content')
    <section class="panel" style="margin-bottom:18px;" data-tour-title="Round Overview" data-tour-body="Review the current round status, decision mode, and winner board. Use this section to confirm the round you are auditing.">
        <div class="panel-head">
            <div>
                <h2>{{ $game->name }} / {{ $round->round_no }}</h2>
                <p>Status: <strong>{{ strtoupper($round->status) }}</strong>. Decision: <strong>{{ $round->decision_mode ?: 'Auto' }}</strong>.</p>
            </div>
            <div class="panel-actions">
                <a class="button-secondary" href="{{ route('admin.game-final.rounds') }}">Back To Rounds</a>
            </div>
        </div>

        <div class="panel-toolbar" data-tour-title="Winner Snapshot" data-tour-body="Shows the current winner (if revealed), plus card metadata where applicable. Pending indicates the winner has not been revealed or persisted yet.">
            <div class="toolbar-copy">
                Winner:
                @include('game_final.admin.partials.board-token', ['key' => $round->winner_board_key ?: '', 'label' => $round->winner_board_key ?: 'Pending', 'icon' => $winnerIcon])
            </div>
            @if (!empty($winnerCards['cards']))
                <div class="toolbar-pills">
                    @foreach ($winnerCards['cards'] as $card)
                        <span class="toolbar-pill">{{ $card }}</span>
                    @endforeach
                    @if (!empty($winnerCards['label']))
                        <span class="toolbar-pill">{{ $winnerCards['label'] }}</span>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <section class="panel" style="margin-bottom:18px;" data-tour-title="Board Totals" data-tour-body="These totals summarize bids and potential exposure by board for this round. Use them to audit risk and verify settlement inputs.">
        <div class="panel-head">
            <div>
                <h2>Board Amounts</h2>
                <p>Board-wise amount, users, potential payout, actual win amount, and win/loss/hold counts.</p>
            </div>
        </div>

        <div class="table-shell">
            <div class="table-wrap">
                <table class="scan-table scan-table-compact">
                    <caption class="table-caption">Round board totals</caption>
                    <thead>
                        <tr>
                            <th>Board</th>
                            <th>Users</th>
                            <th>Bids</th>
                            <th>Total Amount</th>
                            <th>Potential</th>
                            <th>Win Amount</th>
                            <th>Win / Loss / Hold</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($boardRows as $board)
                            <tr class="{{ $board['is_winner'] ? 'is-winner-row' : '' }}">
                                <td data-label="Board">
                                    @include('game_final.admin.partials.board-token', ['key' => $board['key'], 'label' => $board['label'], 'icon' => $board['icon']])
                                    @if ($board['is_winner'])
                                        <span class="status-badge won">Winner</span>
                                    @endif
                                </td>
                                <td data-label="Users">{{ number_format($board['user_count']) }}</td>
                                <td data-label="Bids">{{ number_format($board['bet_count']) }}</td>
                                <td data-label="Total Amount"><span class="money-badge">{{ number_format($board['total_bid_amount'], 2) }}</span></td>
                                <td data-label="Potential"><span class="money-badge">{{ number_format($board['total_potential_win'], 2) }}</span></td>
                                <td data-label="Win Amount"><span class="money-badge {{ $board['total_win_amount'] > 0 ? 'positive' : '' }}">{{ number_format($board['total_win_amount'], 2) }}</span></td>
                                <td data-label="Win / Loss / Hold">
                                    <span class="status-badge won">{{ $board['win_count'] }}</span>
                                    <span class="status-badge lost">{{ $board['loss_count'] }}</span>
                                    <span class="status-badge pending">{{ $board['hold_count'] }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7"><div class="empty-state">No board totals recorded for this round.</div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="panel" data-tour-title="User Outcomes" data-tour-body="One row per user for this round. Click View Profile for wallet and lock tools, or use the round list to inspect adjacent rounds.">
        <div class="panel-head">
            <div>
                <h2>User Outcomes</h2>
                <p>One row per user in this round, paginated for large rounds.</p>
            </div>
        </div>

        <div class="table-shell">
            <div class="table-wrap">
                <table class="scan-table scan-table-wide">
                    <caption class="table-caption">Round user totals</caption>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Boards</th>
                            <th>Bets</th>
                            <th>Total Bid</th>
                            <th>Total Win</th>
                            <th>Profit / Loss</th>
                            <th>Status</th>
                            <th>Profile</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($userRows as $row)
                            @php $net = (float) $row->net_result; @endphp
                            <tr>
                                <td data-label="User">
                                    <div class="user-meta">
                                        <strong>#{{ $row->user_id }} {{ $row->user_name ?: 'User' }}</strong>
                                        <span>{{ $row->user_email ?: 'no email' }}</span>
                                    </div>
                                </td>
                                <td data-label="Boards">{{ number_format((int) $row->board_count) }}</td>
                                <td data-label="Bets">{{ number_format((int) $row->bet_count) }}</td>
                                <td data-label="Total Bid"><span class="money-badge">{{ number_format((float) $row->total_bid_amount, 2) }}</span></td>
                                <td data-label="Total Win"><span class="money-badge positive">{{ number_format((float) $row->total_win_amount, 2) }}</span></td>
                                <td data-label="Profit / Loss"><span class="money-badge {{ $net >= 0 ? 'positive' : 'negative' }}">{{ number_format($net, 2) }}</span></td>
                                <td data-label="Status"><span class="status-badge {{ $net > 0 ? 'won' : ($net < 0 ? 'lost' : 'pending') }}">{{ $net > 0 ? 'WIN' : ($net < 0 ? 'LOSS' : 'HOLD') }}</span></td>
                                <td data-label="Profile"><a class="button-secondary button-small" href="{{ route('admin.game-final.users.profile', $row->user_id) }}">View Profile</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="8"><div class="empty-state">No user rows recorded for this round.</div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @include('game_final.admin.partials.pagination', ['paginator' => $userRows])
    </section>
@endsection
