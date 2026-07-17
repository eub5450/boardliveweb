<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>@yield('title', 'Game Final Admin Panel')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700;800&family=Inter:wght@400;500;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('game_final_admin_theme/admin-style.css') }}">
    <style>
        :root{--surface-soft:rgba(255,255,255,.04);--surface-mid:rgba(255,255,255,.06);--surface-strong:rgba(255,255,255,.09);--line-strong:rgba(255,255,255,.14);--shadow-soft:0 14px 34px rgba(0,0,0,.18)}
        .table-shell{width:100%}
        .scan-table{width:100%;min-width:960px;border-collapse:collapse}
        .scan-table-wide{min-width:1100px}
        .scan-table-compact{min-width:880px}
        .scan-table th,.scan-table td{padding:13px 14px;text-align:left;border-bottom:1px solid var(--line);font-size:13px;vertical-align:top}
        .scan-table thead th{background:rgba(255,255,255,.06);color:#eaf1ff;text-transform:uppercase;letter-spacing:.05em;font-size:11px;position:sticky;top:0}
        .scan-table tbody tr{transition:background .16s ease,transform .16s ease}
        .scan-table tbody tr:hover{background:rgba(255,255,255,.035)}
        .table-caption{height:1px;width:1px;overflow:hidden;position:absolute;white-space:nowrap;clip:rect(1px,1px,1px,1px)}
        .panel{overflow:hidden}
        .panel-head{display:flex;justify-content:space-between;align-items:flex-start;gap:14px;flex-wrap:wrap;padding:16px;border-bottom:1px solid var(--line)}
        .panel-head h2{margin:0}
        .panel-head p{margin:8px 0 0}
        .panel-actions{display:flex;gap:8px;flex-wrap:wrap}
        .panel-toolbar{display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;padding:14px 16px;border-bottom:1px solid var(--line)}
        .toolbar-copy{color:var(--muted)}
        .toolbar-pills{display:flex;gap:8px;flex-wrap:wrap}
        .toolbar-pill,.status-badge,.money-badge,.family-badge,.board-badge{display:inline-flex;align-items:center;gap:6px;padding:6px 10px;border-radius:999px;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.06em;border:1px solid var(--line);white-space:nowrap;background:rgba(255,255,255,.06)}
        .toolbar-pill a{color:inherit;text-decoration:none;font-weight:900}
        .status-badge.on,.status-badge.success,.status-badge.settled,.status-badge.won,.money-badge.positive{background:rgba(57,230,164,.14);color:#a6ffdf;border-color:rgba(57,230,164,.35)}
        .status-badge.off,.status-badge.error,.status-badge.failed,.status-badge.lost,.status-badge.inactive,.money-badge.negative{background:rgba(255,92,122,.14);color:#ffc2cf;border-color:rgba(255,92,122,.35)}
        .status-badge.pending,.status-badge.processing,.status-badge.betting,.status-badge.open{background:rgba(255,216,107,.14);color:#ffe7a5;border-color:rgba(255,216,107,.35)}
        .status-badge.info,.status-badge.active,.status-badge.locked,.status-badge.revealed{background:rgba(77,231,255,.14);color:#c6f8ff;border-color:rgba(77,231,255,.35)}
        .table-wrap{width:100%;overflow:auto;border-radius:18px;border:1px solid var(--line)}
        .row-index{display:inline-grid;place-items:center;width:34px;height:34px;border-radius:12px;background:rgba(255,255,255,.06);border:1px solid var(--line);font-weight:800;color:#d5e0ff}
        .game-meta strong,.user-meta strong{display:block}
        .game-meta span,.user-meta span,.meta-note{display:block;color:var(--muted);font-size:12px}
        .stacked-lines{display:grid;gap:5px}
        .preview-list{display:flex;gap:8px;flex-wrap:wrap;max-width:260px}
        .family-badge.teen{background:rgba(222,168,255,.12);border-color:rgba(222,168,255,.20);color:#f0d6ff}
        .family-badge.lucky{background:rgba(108,207,255,.12);border-color:rgba(108,207,255,.20);color:#d9f5ff}
        .family-badge.fruit{background:rgba(255,176,117,.12);border-color:rgba(255,176,117,.20);color:#ffe1c7}
        .button-primary,.button-secondary{position:relative;display:inline-flex;align-items:center;justify-content:center;gap:9px;min-height:42px;padding:0 16px;border:0;border-radius:15px;font-size:12px;font-weight:900;cursor:pointer;text-decoration:none;white-space:nowrap;text-transform:uppercase;letter-spacing:.05em}
        .button-primary{background:linear-gradient(135deg,var(--gold),#ffb44d);color:#271300;box-shadow:0 10px 24px rgba(255,174,76,.18)}
        .button-secondary{background:rgba(255,255,255,.07);border:1px solid var(--line);color:var(--text)}
        .button-small{min-height:34px;padding:0 12px;border-radius:12px;font-size:11px}
        .filter-bar{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px;padding:14px 16px;border-bottom:1px solid var(--line)}
        .filter-bar.compact{grid-template-columns:repeat(4,minmax(0,1fr))}
        .filter-field label{display:block;margin-bottom:6px;font-size:12px;color:#cad7fb;font-weight:800;text-transform:uppercase;letter-spacing:.05em}
        .filter-field input,.filter-field select,.filter-field textarea{width:100%;min-height:42px;padding:0 12px;border-radius:14px;border:1px solid var(--line-strong);background:rgba(7,12,24,.82);color:var(--text);outline:none}
        .filter-field textarea{padding-top:10px;padding-bottom:10px;min-height:84px}
        .filter-field input:focus,.filter-field select:focus,.filter-field textarea:focus{border-color:rgba(77,231,255,.55);box-shadow:0 0 0 3px rgba(77,231,255,.10)}
        .filter-actions{display:flex;align-items:flex-end;gap:9px;flex-wrap:wrap}
        .filter-summary{display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;padding:12px 16px;border-bottom:1px solid var(--line)}
        .filter-summary-pills{display:flex;gap:8px;flex-wrap:wrap}
        .pagination{display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;padding:14px 16px;border-top:1px solid var(--line)}
        .pagination-meta{color:var(--muted);font-size:13px}
        .pagination-links{display:flex;gap:8px;flex-wrap:wrap}
        .page-link{display:inline-flex;align-items:center;justify-content:center;min-width:40px;height:40px;padding:0 12px;border-radius:14px;border:1px solid var(--line);background:rgba(255,255,255,.04);color:var(--text);text-decoration:none;font-size:13px;font-weight:800}
        .page-link.active{background:linear-gradient(135deg,rgba(255,216,107,.20),rgba(77,231,255,.12));border-color:rgba(255,216,107,.28)}
        .page-link.disabled{opacity:.45;pointer-events:none}
        .board-token{display:inline-flex;align-items:center;gap:8px;max-width:100%;padding:6px 10px 6px 7px;border-radius:999px;border:1px solid rgba(255,255,255,.10);background:rgba(255,255,255,.055);color:#eef4ff;white-space:nowrap}
        .board-token-icon{display:inline-grid;place-items:center;min-width:28px;height:28px;padding:0 6px;border-radius:10px;background:rgba(255,255,255,.10);font-family:'Space Grotesk',Inter,sans-serif;font-size:11px;font-weight:800;color:#fff}
        .board-token-label{overflow:hidden;text-overflow:ellipsis;font-size:11px;font-weight:800;letter-spacing:.08em;text-transform:uppercase}
        .board-token-card{background:rgba(222,168,255,.12);border-color:rgba(222,168,255,.22);color:#f0d6ff}
        .board-token-number{background:rgba(108,207,255,.12);border-color:rgba(108,207,255,.22);color:#d9f5ff}
        .board-token-fruit{background:rgba(255,176,117,.12);border-color:rgba(255,176,117,.22);color:#ffe1c7}
        .notice{padding:14px 16px;border-radius:18px;font-size:14px;line-height:1.6;border:1px solid transparent}
        .notice.status{background:rgba(57,230,164,.12);border-color:rgba(57,230,164,.24);color:#d9fff2}
        .notice.error{background:rgba(255,92,122,.12);border-color:rgba(255,92,122,.24);color:#ffe0e7}
        .notice.warning{background:rgba(255,216,107,.12);border-color:rgba(255,216,107,.28);color:#ffe7a5}
        .notice.info{background:rgba(77,231,255,.12);border-color:rgba(77,231,255,.24);color:#d7fbff}
        .admin-alerts{padding:16px 18px;border-radius:20px;border:1px solid rgba(255,92,122,.28);background:rgba(255,92,122,.12);color:#ffe4ea}
        .admin-alerts ul{margin:0;padding-left:18px}
        .empty-state{padding:30px 16px;text-align:center;color:var(--muted)}
        .page-context{display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap}
        .page-context h1{font-family:'Space Grotesk',Inter,sans-serif;font-size:clamp(25px,3.2vw,42px);line-height:1;margin:0 0 8px;letter-spacing:-.04em}
        .page-context p{margin:0;color:var(--muted);line-height:1.55}
        .fast-find{display:grid;gap:6px}
        .fast-find input{width:100%;min-height:40px;padding:0 12px;border-radius:14px;border:1px solid var(--line-strong);background:rgba(7,12,24,.82);color:var(--text)}
        .fast-find small{color:var(--muted);font-size:12px}
        .empty-row.hidden-by-search{display:none}
        [data-row-link]{cursor:pointer}
        .table-link{color:#eef4ff;text-decoration:none}
        .table-link:hover{text-decoration:underline}
        .table-actions{display:flex;gap:8px;flex-wrap:wrap}
        .wallet-note{display:inline-flex;align-items:center;gap:8px;padding:8px 10px;border-radius:12px;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);font-size:12px}
        .toast-stack{position:fixed;right:18px;top:18px;z-index:2000;display:grid;gap:10px;width:min(360px,calc(100vw - 24px))}
        .toast{display:grid;grid-template-columns:1fr auto;gap:10px;align-items:start;padding:14px 14px 14px 16px;border-radius:18px;border:1px solid var(--line-strong);background:rgba(10,14,26,.96);box-shadow:0 20px 40px rgba(0,0,0,.28)}
        .toast strong{display:block;margin-bottom:4px}
        .toast p{margin:0;color:#eaf2ff;font-size:13px;line-height:1.5}
        .toast button{appearance:none;border:0;background:transparent;color:inherit;font-size:18px;line-height:1;cursor:pointer}
        .toast.success{border-color:rgba(57,230,164,.35)}
        .toast.warning{border-color:rgba(255,216,107,.35)}
        .toast.error{border-color:rgba(255,92,122,.35)}
        .toast.info{border-color:rgba(77,231,255,.35)}
        .confirm-modal{width:min(100%,480px);padding:0;border:0;border-radius:24px;background:#09111f;color:var(--text);box-shadow:0 30px 90px rgba(0,0,0,.45)}
        .confirm-modal::backdrop{background:rgba(2,6,12,.72)}
        .confirm-head{padding:18px 20px;border-bottom:1px solid var(--line)}
        .confirm-head h3{margin:0 0 8px;font-family:'Space Grotesk',Inter,sans-serif;font-size:24px}
        .confirm-head p{margin:0;color:var(--muted);line-height:1.6}
        .confirm-body{padding:18px 20px;display:grid;gap:12px}
        .confirm-actions{display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap;padding:0 20px 20px}
        .dialog-credit{padding:0 20px 16px;color:var(--muted);font-size:7px;opacity:.05;line-height:1.4;text-align:right;letter-spacing:.04em}
        @media(max-width:1180px){.filter-bar{grid-template-columns:1fr 1fr}}
        @media(max-width:720px){.filter-bar,.filter-bar.compact{grid-template-columns:1fr}.scan-table{min-width:780px}.toast-stack{left:12px;right:12px;top:auto;bottom:12px;width:auto}}
    </style>
</head>
<body data-admin-shell="1" data-admin-page="{{ $activeMenu }}">
    @php
        $adminThemeAsset = static fn (string $file): string => asset('game_final_admin_theme/assets/' . $file);
        $menuByKey = collect($adminMenu)->keyBy('key');
    @endphp

    <div class="appbar">
        <a class="brand-mini" href="{{ route('admin.dashboard') }}">
            <img src="{{ $adminThemeAsset('app-icon.svg') }}" alt="GF">
            <span>Game Final</span>
        </a>
        <a class="btn icon-only secondary" href="{{ route('admin.game-final.users') }}" data-tip="Open users">U</a>
    </div>

    <div class="page">
        <aside class="sidebar">
            <div class="brand">
                <img src="{{ $adminThemeAsset('app-icon.svg') }}" alt="Game Final">
                <div>
                    <div class="title">Game Final</div>
                    <small>Admin Control</small>
                </div>
            </div>

            <div class="menu">
                <a class="{{ $activeMenu === 'dashboard' ? 'active' : '' }}" href="{{ route('admin.dashboard') }}" data-tour-title="Dashboard" data-tour-body="Use the dashboard to review live room status, realtime mode, and the main admin controls before making changes."><span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M3 10.5 12 3l9 7.5"></path><path d="M5 9.5V21h14V9.5"></path><path d="M9 21v-6h6v6"></path></svg></span><span>Dashboard</span></a>
                <a class="{{ $activeMenu === 'dashboard' ? 'active' : '' }}" href="{{ route('admin.dashboard') }}#lobby-control" data-tour-title="Lobby Control" data-tour-body="Use this section to switch rooms between Live, Developer, and Maintenance, then save the full lobby configuration once."><span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M4 21v-7"></path><path d="M12 21v-11"></path><path d="M20 21V3"></path><path d="M2 7h4"></path><path d="M10 11h4"></path><path d="M18 7h4"></path></svg></span><span>Lobby Control</span></a>
                <a class="{{ $activeMenu === 'game-time' ? 'active' : '' }}" href="{{ route('admin.game-final.game-time') }}#game-time-settings"><span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="8"></circle><path d="M12 7v5l3 2"></path><path d="M4 4l3 3"></path><path d="M20 4l-3 3"></path></svg></span><span>Game Time</span></a>
                <a class="{{ $activeMenu === 'games' ? 'active' : '' }}" href="{{ route('admin.game-final.games') }}" data-tour-title="Games" data-tour-body="Open the games page for per-room summaries, current timing, board setup, and the latest sync details."><span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="3"></rect><path d="M8 12h.01"></path><path d="M16 12h.01"></path><path d="M12 9v6"></path><path d="M9 12h6"></path></svg></span><span>Games</span></a>
                <a class="{{ $activeMenu === 'monitor' ? 'active' : '' }}" href="{{ route('admin.game-final.live-monitor') }}" data-tour-title="Live Monitor" data-tour-body="Use Live Monitor to watch active rounds, board totals, and recent bet flow without editing room settings."><span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M4 19h16"></path><path d="M7 15l3-3 3 2 4-5"></path><path d="M18 9h-3V6"></path></svg></span><span>Live Monitor</span></a>
                <a class="{{ $activeMenu === 'rounds' ? 'active' : '' }}" href="{{ route('admin.game-final.rounds') }}" data-tour-title="Rounds" data-tour-body="Review round history, settlement outcomes, and winner boards when you need to audit a finished or active room."><span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="3"></rect><path d="M8 8h8"></path><path d="M8 12h8"></path><path d="M8 16h5"></path></svg></span><span>Rounds</span></a>
                <a class="{{ $activeMenu === 'bets' ? 'active' : '' }}" href="{{ route('admin.game-final.bets') }}" data-tour-title="Bets" data-tour-body="Use the bets page to inspect user stakes, board choices, and round references in one searchable list."><span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M6 8h12"></path><path d="M7 12h10"></path><path d="M8 16h8"></path><path d="M6 5h12l2 4-2 10H6L4 9l2-4Z"></path></svg></span><span>Bets</span></a>
                <a class="{{ $activeMenu === 'users' ? 'active' : '' }}" href="{{ route('admin.game-final.users') }}" data-tour-title="Users" data-tour-body="Open users to review balances, lock access, and trace account activity from one admin surface."><span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="10" cy="7" r="3"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 4.13a4 4 0 0 1 0 5.74"></path></svg></span><span>Users</span></a>
                <a class="{{ $activeMenu === 'payouts' ? 'active' : '' }}" href="{{ route('admin.game-final.payouts') }}" data-tour-title="Payouts" data-tour-body="Review win and loss settlement rows here to confirm the money impact of completed rounds."><span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M3 7h18v10H3z"></path><path d="M3 10h18"></path><path d="M7 15h4"></path></svg></span><span>Payouts</span></a>
                <a href="{{ route('admin.dashboard') }}#visual-settings"><span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="m12 3 1.9 3.9L18 9l-4.1 2.1L12 15l-1.9-3.9L6 9l4.1-2.1Z"></path><path d="M19 14l.9 1.8L22 16.7l-2.1.9L19 19.5l-.9-1.9-2.1-.9 2.1-.9Z"></path></svg></span><span>Popup Setup</span></a>
                <a href="{{ route('admin.dashboard') }}#visual-settings"><span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="8" cy="12" r="4"></circle><circle cx="16" cy="12" r="4"></circle><path d="M8 8V6"></path><path d="M16 18v-2"></path></svg></span><span>Chips Setup</span></a>
                <a href="{{ route('admin.dashboard') }}#board-settings"><span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="2"></rect><path d="M4 10h16"></path><path d="M10 4v16"></path></svg></span><span>Board Setup</span></a>
                <a href="{{ route('admin.dashboard') }}#visual-settings"><span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="8"></circle><path d="M12 8v5l3 2"></path></svg></span><span>Clock Setup</span></a>
                <a href="{{ route('admin.dashboard') }}#pusher-settings"><span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M4 18a8 8 0 0 1 16 0"></path><path d="M7 15a5 5 0 0 1 10 0"></path><path d="M10 12a2 2 0 0 1 4 0"></path><path d="M12 19h.01"></path></svg></span><span>Pusher</span></a>
                <a href="{{ route('admin.game-final.security') }}" data-no-ajax="1"><span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M12 3 5 6v6c0 5 3.4 7.8 7 9 3.6-1.2 7-4 7-9V6l-7-3Z"></path><path d="m9 12 2 2 4-4"></path></svg></span><span>Security</span></a>
            </div>

            <div class="sidebar-actions">
                <a class="btn secondary" href="{{ route('game-final.lobby') }}" data-no-ajax="1">Lobby</a>
                <form method="post" action="{{ route('logout') }}" data-no-ajax="1">
                    @csrf
                    <button class="btn danger" type="submit">Logout</button>
                </form>
            </div>
        </aside>

        <main class="content" data-admin-main>
            <section class="topbar">
                <div class="page-context">
                    <div>
                        <h1>@yield('title', 'Game Final Admin')</h1>
                        <p>@yield('intro', 'Manage games, rounds, bets, payouts, and security from one control surface.')</p>
                    </div>
                    <div class="toolbar">
                        <button class="btn secondary" type="button" data-tour-start>Open Tour</button>
                        <a class="btn secondary" href="{{ route('admin.game-final.security') }}">Security</a>
                        <form method="post" action="{{ route('admin.game-final.security.lock') }}">
                            @csrf
                            <button class="btn secondary" type="submit">Lock Pass</button>
                        </form>
                    </div>
                </div>
            </section>

            <section class="grid-4">
                @foreach ($pageStats as $stat)
                    <div class="card">
                        <div class="title">{{ $stat['label'] }}</div>
                        <div class="value">{{ $stat['value'] }}</div>
                        <p class="muted">{{ $stat['description'] }}</p>
                    </div>
                @endforeach
            </section>

            @if (!empty($adminAlerts))
                <div class="admin-alerts" role="alert" aria-live="polite">
                    <strong>Admin Alerts</strong>
                    <ul>
                        @foreach ($adminAlerts as $adminAlert)
                            @php
                                $alertMessage = is_array($adminAlert) ? (string) ($adminAlert['message'] ?? '') : (string) $adminAlert;
                                $alertMeta = is_array($adminAlert) ? (array) ($adminAlert['meta'] ?? []) : [];
                            @endphp
                            @if ($alertMessage !== '')
                                <li>
                                    {{ $alertMessage }}
                                    @if (!empty($alertMeta['reason']))
                                        <small>{{ $alertMeta['reason'] }}</small>
                                    @endif
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="notice status" role="status">{{ session('status') }}</div>
            @endif

            @if (session('warning'))
                <div class="notice warning" role="status">{{ session('warning') }}</div>
            @endif

            @if (session('error'))
                <div class="notice error" role="alert">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="notice error" role="alert">
                    <strong>Validation error</strong>
                    <div>{{ $errors->first() }}</div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <nav class="bottom-nav">
        <a class="{{ $activeMenu === 'dashboard' ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M3 10.5 12 3l9 7.5"></path><path d="M5 9.5V21h14V9.5"></path><path d="M9 21v-6h6v6"></path></svg></span><span>Home</span></a>
        <a class="{{ $activeMenu === 'games' ? 'active' : '' }}" href="{{ route('admin.game-final.games') }}"><span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="3"></rect><path d="M8 12h.01"></path><path d="M16 12h.01"></path><path d="M12 9v6"></path><path d="M9 12h6"></path></svg></span><span>Games</span></a>
        <a class="{{ $activeMenu === 'monitor' ? 'active' : '' }}" href="{{ route('admin.game-final.live-monitor') }}"><span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M4 19h16"></path><path d="M7 15l3-3 3 2 4-5"></path><path d="M18 9h-3V6"></path></svg></span><span>Live</span></a>
        <a class="{{ $activeMenu === 'game-time' ? 'active' : '' }}" href="{{ route('admin.game-final.game-time') }}#game-time-settings"><span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="8"></circle><path d="M12 7v5l3 2"></path></svg></span><span>Time</span></a>
        <a class="{{ $activeMenu === 'rounds' ? 'active' : '' }}" href="{{ route('admin.game-final.rounds') }}"><span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="3"></rect><path d="M8 8h8"></path><path d="M8 12h8"></path><path d="M8 16h5"></path></svg></span><span>Rounds</span></a>
        <a class="{{ $activeMenu === 'users' ? 'active' : '' }}" href="{{ route('admin.game-final.users') }}"><span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="10" cy="7" r="3"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 4.13a4 4 0 0 1 0 5.74"></path></svg></span><span>Users</span></a>
        <a class="{{ $activeMenu === 'dashboard' ? 'active' : '' }}" href="{{ route('admin.dashboard') }}#pusher-settings"><span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M4 21v-7"></path><path d="M12 21v-4"></path><path d="M20 21V9"></path><path d="M2 14h4"></path><path d="M10 17h4"></path><path d="M18 9h4"></path></svg></span><span>Setup</span></a>
    </nav>

    <script src="{{ asset('game_final_admin_theme/admin-app.js') }}"></script>
    <div class="toast-stack" data-toast-stack></div>
    <dialog class="confirm-modal" data-confirm-modal aria-labelledby="confirm-modal-title">
        <div class="confirm-head">
            <h3 id="confirm-modal-title">Confirm action</h3>
            <p data-confirm-message>Please confirm this action.</p>
        </div>
        <div class="confirm-body">
            <div class="notice warning" data-confirm-warning hidden></div>
        </div>
        <div class="confirm-actions">
            <button class="button-secondary" type="button" data-confirm-cancel>Cancel</button>
            <button class="button-primary" type="button" data-confirm-accept>Continue</button>
        </div>
        <div class="dialog-credit">Powerd by JAMBOai</div>
    </dialog>
    <script src="{{ asset('game_final_admin_theme/admin-panel.js') }}"></script>
    @yield('page_scripts')
</body>
</html>

