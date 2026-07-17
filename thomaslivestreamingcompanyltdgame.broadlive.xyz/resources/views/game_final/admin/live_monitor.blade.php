@extends('game_final.admin.layout')

@section('title', 'Watch active rounds with real data only.')
@section('intro', 'This monitor reads live round rows, board totals, and recent bets directly from the database. No synthetic winners or fabricated traffic are shown here.')

@section('content')
    <style>
        .monitor-shell{display:grid;gap:18px}
        .monitor-hero{display:grid;grid-template-columns:minmax(0,1.2fr) minmax(300px,.8fr);gap:16px}
        .monitor-card{position:relative;overflow:hidden;padding:20px;border:1px solid var(--line);border-radius:26px;background:linear-gradient(160deg,rgba(18,26,54,.92),rgba(8,14,29,.9));box-shadow:0 16px 42px rgba(0,0,0,.24)}
        .monitor-card::before{content:"";position:absolute;inset:-20% auto auto -15%;width:220px;height:220px;border-radius:50%;background:radial-gradient(circle,rgba(77,231,255,.18),transparent 68%);pointer-events:none}
        .monitor-card h2,.monitor-card h3{margin:0;font-family:'Space Grotesk',Inter,sans-serif;letter-spacing:-.03em}
        .monitor-copy{display:grid;gap:10px}
        .monitor-copy p{margin:0;color:var(--muted);line-height:1.7}
        .monitor-chip-row{display:flex;gap:8px;flex-wrap:wrap}
        .monitor-chip{display:inline-flex;align-items:center;gap:8px;padding:8px 12px;border-radius:999px;border:1px solid rgba(255,255,255,.12);background:rgba(255,255,255,.05);font-size:11px;font-weight:900;letter-spacing:.08em;text-transform:uppercase}
        .monitor-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:16px}
        .room-head{display:flex;justify-content:space-between;gap:12px;align-items:flex-start;margin-bottom:16px}
        .room-head strong{display:block;font-size:22px;font-family:'Space Grotesk',Inter,sans-serif}
        .room-head span{display:block;color:var(--muted);margin-top:5px}
        .phase-pill{display:inline-flex;align-items:center;gap:8px;padding:8px 12px;border-radius:999px;border:1px solid rgba(77,231,255,.28);background:rgba(77,231,255,.10);font-size:11px;font-weight:900;letter-spacing:.08em;text-transform:uppercase;color:#c6f8ff}
        .phase-pill.idle{border-color:rgba(255,255,255,.12);background:rgba(255,255,255,.05);color:#d8e5ff}
        .phase-pill.locked{border-color:rgba(255,216,107,.28);background:rgba(255,216,107,.12);color:#ffe7a5}
        .phase-pill.revealed,.phase-pill.settled{border-color:rgba(57,230,164,.28);background:rgba(57,230,164,.12);color:#cffff0}
        .monitor-stats{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px;margin-bottom:16px}
        .monitor-stat{padding:12px;border-radius:18px;border:1px solid rgba(255,255,255,.08);background:rgba(255,255,255,.04)}
        .monitor-stat b{display:block;font-size:11px;letter-spacing:.10em;text-transform:uppercase;color:#b8c7ea}
        .monitor-stat strong{display:block;margin-top:7px;font-size:22px}
        .progress-shell{margin-bottom:16px}
        .progress-meta{display:flex;justify-content:space-between;gap:8px;align-items:center;margin-bottom:8px;font-size:12px;color:#dbe7ff}
        .progress-track{height:12px;border-radius:999px;background:rgba(255,255,255,.06);overflow:hidden;border:1px solid rgba(255,255,255,.08)}
        .progress-bar{height:100%;border-radius:999px;background:linear-gradient(90deg,#4de7ff,#78ffc8,#ffd86b);box-shadow:0 0 18px rgba(77,231,255,.35)}
        .board-stack{display:grid;gap:10px;margin-bottom:18px}
        .board-row{padding:12px 14px;border-radius:18px;border:1px solid rgba(255,255,255,.08);background:rgba(7,12,24,.62)}
        .board-row-top{display:flex;justify-content:space-between;gap:10px;align-items:center;margin-bottom:8px}
        .board-row-top strong{display:inline-flex;align-items:center;gap:8px}
        .board-bar{height:10px;border-radius:999px;background:rgba(255,255,255,.05);overflow:hidden}
        .board-bar span{display:block;height:100%;border-radius:999px;background:linear-gradient(90deg,rgba(77,231,255,.18),rgba(255,216,107,.92));box-shadow:0 0 14px rgba(77,231,255,.22)}
        .board-meta{display:flex;justify-content:space-between;gap:8px;flex-wrap:wrap;margin-top:8px;font-size:12px;color:#c1d0ef}
        .fiber-stream{display:grid;gap:10px}
        .fiber-item{position:relative;overflow:hidden;padding:12px 14px 12px 18px;border-radius:18px;border:1px solid rgba(255,255,255,.08);background:linear-gradient(135deg,rgba(8,14,28,.94),rgba(14,26,48,.9))}
        .fiber-item::before{content:"";position:absolute;left:-22%;top:0;bottom:0;width:40%;background:linear-gradient(90deg,rgba(77,231,255,0),rgba(77,231,255,.42),rgba(255,216,107,0));transform:skewX(-24deg);animation:fiberRun 2.8s linear infinite}
        .fiber-item::after{content:"";position:absolute;left:10px;top:18px;width:9px;height:9px;border-radius:50%;background:#4de7ff;box-shadow:0 0 12px #4de7ff,0 0 24px rgba(77,231,255,.46)}
        .fiber-user{display:flex;justify-content:space-between;gap:10px;align-items:center;position:relative;z-index:1}
        .fiber-user strong{font-size:14px}
        .fiber-meta{display:flex;justify-content:space-between;gap:8px;flex-wrap:wrap;position:relative;z-index:1;margin-top:6px;color:#c8d7f5;font-size:12px}
        .monitor-note{color:var(--muted);font-size:12px;line-height:1.6}
        @keyframes fiberRun{0%{transform:translateX(-120%) skewX(-24deg)}100%{transform:translateX(320%) skewX(-24deg)}}
        @media(max-width:960px){.monitor-hero{grid-template-columns:1fr}}
        @media(max-width:640px){.monitor-stats{grid-template-columns:1fr}}
    </style>

    <div class="monitor-shell" data-live-monitor-page data-tour-title="Live Monitor" data-tour-body="Shows active rounds and recent bets using database-only data. Use this page for operational visibility and audit.">
        <section class="monitor-hero">
            <article class="monitor-card">
                <div class="monitor-copy">
                    <h2 data-tour-title="Monitor Summary" data-tour-body="Shows global room counts and the shared bank snapshot for quick triage.">Active round monitor.</h2>
                    <p>Review current round rows, board totals, and recent bets from real data only.</p>
                    <div class="monitor-chip-row">
                        <span class="monitor-chip">Live rooms {{ $liveRoomCount }}</span>
                        <span class="monitor-chip">Shared bank {{ number_format((float) $sharedGameBalance, 2) }}</span>
                        <span class="monitor-chip">Auto refresh 5s</span>
                    </div>
                </div>
            </article>
            <article class="monitor-card">
                <h3>Integrity note</h3>
                <p class="monitor-note">This page shows stored round and bet activity only. Empty rooms stay empty here.</p>
            </article>
        </section>

        <section class="monitor-grid" data-live-monitor-shell data-tour-title="Room Cards" data-tour-body="Each card represents one game room. Status, countdown, board totals, and recent bets refresh automatically.">
            @forelse ($liveRooms as $room)
                @php $totalBid = max(0.01, (float) ($room['summary']['total_bid_amount'] ?? 0.01)); @endphp
                <article class="monitor-card">
                    <div class="room-head">
                        <div>
                            <strong>{{ $room['game_name'] }}</strong>
                            <span>{{ $room['game_code'] }} | {{ $room['family'] }} | {{ $room['round_no'] ?: 'No active round' }}</span>
                        </div>
                        <span class="phase-pill {{ $room['status'] }}">{{ strtoupper($room['status']) }}</span>
                    </div>

                    <div class="monitor-stats">
                        <div class="monitor-stat">
                            <b>Total Bid</b>
                            <strong>{{ number_format((float) ($room['summary']['total_bid_amount'] ?? 0), 2) }}</strong>
                        </div>
                        <div class="monitor-stat">
                            <b>Players</b>
                            <strong>{{ number_format((int) ($room['summary']['user_count'] ?? 0)) }}</strong>
                        </div>
                        <div class="monitor-stat">
                            <b>Bets</b>
                            <strong>{{ number_format((int) ($room['summary']['bet_count'] ?? 0)) }}</strong>
                        </div>
                        <div class="monitor-stat">
                            <b>Winner</b>
                            <strong>{{ $room['winner_icon'] ? $room['winner_icon'] . ' ' . $room['winner_board_key'] : 'Pending' }}</strong>
                        </div>
                    </div>

                    <div class="progress-shell">
                        <div class="progress-meta">
                            <span>{{ $room['next_label'] }}</span>
                            <strong>{{ number_format((int) $room['next_seconds']) }}s</strong>
                        </div>
                        <div class="progress-track">
                            <div class="progress-bar" style="width: {{ $room['progress_percent'] }}%;"></div>
                        </div>
                    </div>

                    <div class="board-stack">
                        @forelse ($room['board_totals'] as $board)
                            <div class="board-row">
                                <div class="board-row-top">
                                    <strong>{{ $board['icon'] }} {{ $board['label'] }}</strong>
                                    <span>{{ number_format((float) $board['total_bid_amount'], 2) }}</span>
                                </div>
                                <div class="board-bar">
                                    <span style="width: {{ min(100, (($board['total_bid_amount'] / $totalBid) * 100)) }}%;"></span>
                                </div>
                                <div class="board-meta">
                                    <span>{{ $board['bet_count'] }} bets</span>
                                    <span>{{ $board['user_count'] }} users</span>
                                    <span>Potential {{ number_format((float) $board['total_potential_win'], 2) }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">No board totals yet for this round.</div>
                        @endforelse
                    </div>

                    <div class="fiber-stream">
                        @forelse ($room['recent_bets'] as $bet)
                            <div class="fiber-item">
                                <div class="fiber-user">
                                    <strong>{{ $bet['user_label'] }}</strong>
                                    <span>{{ number_format((float) $bet['amount'], 2) }}</span>
                                </div>
                                <div class="fiber-meta">
                                    <span>{{ $bet['board_icon'] }} {{ strtoupper($bet['board_key']) }}</span>
                                    <span>User #{{ $bet['user_id'] }}</span>
                                    <span>{{ $bet['created_at_label'] }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">No live bet stream in this room yet.</div>
                        @endforelse
                    </div>

                    <p class="monitor-note" style="margin-top:14px;">Last round update: {{ $room['updated_at_label'] }}</p>
                </article>
            @empty
                <section class="panel">
                    <div class="empty-state">No active games are available for monitoring right now.</div>
                </section>
            @endforelse
        </section>
    </div>
@endsection

@section('page_scripts')
@endsection

