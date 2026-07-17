@extends('game_final.admin.layout')

@section('eyebrow', ($activeMenu ?? '') === 'game-time' ? 'Game Final Time Control' : 'Game Final Lobby Control')
@section('title', ($activeMenu ?? '') === 'game-time' ? 'Manage game timing and round phases.' : 'Manage lobby visibility and realtime settings.')
@section('intro', ($activeMenu ?? '') === 'game-time' ? 'Tune bet, popup, result, and settle timing without the rest of the lobby controls getting in the way.' : 'Control room access, board limits, runtime delivery, and shared balance actions.')

@section('content')
    @php
        $adminThemeAsset = static fn (string $file): string => asset('game_final_admin_theme/assets/' . $file);
        $pusherDefaults = [
            'app_id' => '',
            'key' => '',
            'secret' => '',
            'cluster' => 'mt1',
            'host' => '',
            'port' => '443',
            'scheme' => 'https',
        ];
        $pusherMaxAccounts = 8;
        $storedPusher = array_merge($pusherDefaults, (array) ($runtimeControls['pusher'] ?? []));
        $storedPusherAccounts = array_values((array) ($runtimeControls['pusher_accounts'] ?? []));
        if (empty($storedPusherAccounts)) {
            $storedPusherAccounts[] = $storedPusher;
        }
        $oldPusherAccounts = old('pusher_accounts');
        $seedAccountCount = is_array($oldPusherAccounts) && count($oldPusherAccounts) > 0 ? count($oldPusherAccounts) : count($storedPusherAccounts);
        $seedAccountCount = max(1, min($seedAccountCount, $pusherMaxAccounts));
        $pusherAccounts = [];
        $masterBankGameCode = (string) ($games->first()['game_code'] ?? '');
        $masterBankBalance = number_format((float) ($adminCounts['game_balance_total'] ?? 0), 2, '.', '');
        $isGameTimePage = ($activeMenu ?? '') === 'game-time';
        $pageRoute = $isGameTimePage ? route('admin.game-final.game-time') : route('admin.dashboard');

        for ($accountIndex = 0; $accountIndex < $seedAccountCount; $accountIndex++) {
            $accountValues = array_merge($pusherDefaults, (array) ($storedPusherAccounts[$accountIndex] ?? []));

            if (is_array($oldPusherAccounts) && is_array($oldPusherAccounts[$accountIndex] ?? null)) {
                $accountValues = array_merge($accountValues, (array) $oldPusherAccounts[$accountIndex]);
            } elseif ($accountIndex === 0) {
                foreach (array_keys($pusherDefaults) as $fieldName) {
                    $accountValues[$fieldName] = old('pusher.' . $fieldName, $accountValues[$fieldName] ?? '');
                }
            }

            $accountValues['secret'] = '';
            $accountValues['secret_configured'] = trim((string) (($storedPusherAccounts[$accountIndex]['secret'] ?? ''))) !== '';
            $pusherAccounts[] = $accountValues;
        }

        $activePusherIndex = (int) ($runtimeControls['pusher_active_index'] ?? 0);
        $failedPusherIndexes = array_values(array_map('intval', (array) ($runtimeControls['pusher_failed_indexes'] ?? [])));
        $completePusherCount = collect($pusherAccounts)->filter(function (array $account) {
            return trim((string) ($account['app_id'] ?? '')) !== ''
                && trim((string) ($account['key'] ?? '')) !== ''
                && (!empty($account['secret_configured']) || trim((string) ($account['secret'] ?? '')) !== '');
        })->count();
    @endphp

    <style>
        .mode-hidden{display:none !important}
        .dashboard-ops-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:12px;margin-top:16px}
        .dashboard-ops-card{padding:16px;border:1px solid rgba(255,255,255,.10);border-radius:22px;background:rgba(6,12,24,.42)}
        .dashboard-ops-card strong{display:block;font-size:11px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);margin-bottom:8px}
        .dashboard-ops-card span{display:block;font-family:var(--font-title);font-size:28px;font-weight:800;letter-spacing:-.04em}
        .timing-entry-panel{display:grid;gap:16px;margin-bottom:18px;padding:20px 22px}
        .timing-entry-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px}
        .timing-entry-card{padding:16px;border:1px solid rgba(255,255,255,.10);border-radius:20px;background:rgba(6,12,24,.42)}
        .timing-entry-card strong{display:block;margin-bottom:8px;font-size:11px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted)}
        .timing-entry-card span{display:block;font-family:var(--font-title);font-size:26px;font-weight:800;letter-spacing:-.04em}
        .ops-chip{display:inline-flex;align-items:center;gap:8px;padding:8px 10px;border-radius:999px;border:1px solid var(--line);background:rgba(255,255,255,.05);font-size:11px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:#d8e4ff}
        .runtime-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:14px;padding:20px 24px;border-bottom:1px solid var(--line)}
        .runtime-card{padding:18px;border:1px solid rgba(255,255,255,.10);border-radius:22px;background:rgba(5,10,19,.28)}
        .runtime-card h3{margin:0 0 10px;font-family:var(--font-title);font-size:20px;letter-spacing:-.03em}
        .runtime-card p{margin:0;color:var(--muted);line-height:1.65}
        .runtime-card .toolbar-pills{margin-top:14px}
        .pusher-zone{padding:20px 24px;border-bottom:1px solid var(--line);display:grid;gap:16px}
        .pusher-zone-head{display:flex;justify-content:space-between;align-items:flex-start;gap:14px;flex-wrap:wrap}
        .pusher-zone-copy h3{margin:0 0 8px;font-family:var(--font-title);font-size:24px;letter-spacing:-.03em}
        .pusher-zone-copy p{margin:0;color:var(--muted);line-height:1.65;max-width:840px}
        .pusher-zone-actions{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
        .pusher-account-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:16px}
        .pusher-account-card{display:grid;gap:14px;align-content:start;padding:18px;border:1px solid rgba(255,255,255,.10);border-radius:24px;background:linear-gradient(160deg,rgba(17,25,55,.95),rgba(8,13,30,.92))}
        .pusher-account-card.is-active{border-color:rgba(77,231,255,.34);box-shadow:0 0 0 1px rgba(77,231,255,.12),0 18px 40px rgba(0,0,0,.20)}
        .pusher-account-card.is-failed{border-color:rgba(255,92,122,.28);background:linear-gradient(160deg,rgba(40,17,34,.92),rgba(12,12,25,.92))}
        .pusher-account-head{display:flex;align-items:flex-start;justify-content:space-between;gap:12px}
        .pusher-account-title{display:grid;gap:6px}
        .pusher-account-title h4{margin:0;font-family:var(--font-title);font-size:20px;letter-spacing:-.03em}
        .pusher-account-title p{margin:0;color:var(--muted);font-size:13px;line-height:1.55}
        .pusher-account-fields{display:grid;grid-template-columns:1fr 1fr;gap:12px}
        .pusher-account-fields .filter-field:nth-child(1),
        .pusher-account-fields .filter-field:nth-child(2),
        .pusher-account-fields .filter-field:nth-child(3){grid-column:1/-1}
        .pusher-card-actions{display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap}
        .pusher-live-picker{display:inline-flex;align-items:center;gap:8px;padding:8px 12px;border-radius:14px;border:1px solid var(--line);background:rgba(255,255,255,.04);font-size:12px;font-weight:800;letter-spacing:.05em;text-transform:uppercase;color:var(--text);cursor:pointer}
        .pusher-live-picker input{margin:0}
        .pusher-muted{color:var(--muted-soft);font-size:12px;line-height:1.55}
        .button-ghost{display:inline-flex;align-items:center;justify-content:center;min-height:40px;padding:0 14px;border-radius:14px;border:1px solid var(--line);background:rgba(255,255,255,.04);color:var(--text);font-size:12px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;cursor:pointer}
        .button-ghost[disabled]{opacity:.45;cursor:not-allowed}
        .dashboard-table .limit-wrap{max-width:none}
        .dashboard-table .limit-wrap input{min-width:110px}
        .board-payout-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(128px,1fr));gap:8px;min-width:0}
        .board-payout-item{display:grid;grid-template-columns:1fr;align-items:start;gap:8px;padding:10px;border:1px solid rgba(255,255,255,.10);border-radius:16px;background:rgba(5,10,19,.22)}
        .board-payout-item label{display:flex;align-items:center;gap:6px;min-width:0;font-size:12px;font-weight:800;color:var(--text)}
        .board-payout-item input{height:36px;min-width:0;text-align:center;font-size:14px}
        .board-payout-note{grid-column:1/-1;margin-top:2px;font-size:11px;color:var(--muted)}
        .visual-panel-row{display:none}
        .visual-panel-row.is-open{display:table-row}
        .visual-panel{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:12px;padding:16px 18px;background:rgba(8,14,24,.58);border-top:1px solid rgba(255,255,255,.08)}
        .visual-panel .filter-field{min-width:0}
        .visual-panel input[type=color]{height:40px;padding:4px}
        .visual-banner-field{grid-column:1/-1}
        .visual-toggle-btn{white-space:nowrap}
        .dashboard-table tbody td{vertical-align:top}
        .dashboard-table .game-meta strong,.dashboard-table .game-meta span{word-break:break-word}
        .dashboard-table .preview-list{max-width:100%}
        .dashboard-table .visual-toggle-btn,.dashboard-table .limit-wrap input,.dashboard-table .filter-field select{min-width:0}
        .dashboard-table .toggle-note{display:block;margin-top:8px}
        .dashboard-table .filter-field[data-maintenance-user-wrap] input{max-width:240px}
        .dashboard-table .visual-panel .filter-field{display:grid;gap:8px}
        .bulk-lobby-actions{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
        .bulk-select-box{display:inline-flex;align-items:center;justify-content:center;width:34px;height:34px;border-radius:12px;border:1px solid var(--line);background:rgba(255,255,255,.05)}
        .bulk-select-box input{width:16px;height:16px;margin:0;accent-color:#ffd86b}
        .bulk-selected-pill{display:inline-flex;align-items:center;min-height:34px;padding:0 10px;border-radius:999px;border:1px solid var(--line);background:rgba(255,255,255,.05);font-size:11px;font-weight:900;letter-spacing:.06em;text-transform:uppercase;color:#dbe6ff}
        .button-secondary[data-bulk-mode]{min-height:34px;padding:0 12px;border-radius:12px}
        .master-bank-toolbar{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
        .master-bank-actions{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
        .dashboard-table{border-collapse:separate;border-spacing:0 14px}
        .dashboard-table thead{display:none}
        .dashboard-table tbody tr[data-game-row]{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px 18px;margin:0 0 14px;padding:18px;border:1px solid rgba(255,255,255,.10);border-radius:22px;background:linear-gradient(180deg,rgba(10,16,28,.94),rgba(5,10,19,.78));box-shadow:0 20px 45px rgba(3,8,16,.18)}
        .dashboard-table tbody tr[data-game-row].is-disabled{border-color:rgba(255,107,107,.28);background:linear-gradient(180deg,rgba(34,10,16,.96),rgba(17,7,10,.82))}
        .dashboard-table tbody tr[data-game-row].is-maintenance{border-color:rgba(255,216,107,.24);background:linear-gradient(180deg,rgba(33,23,9,.95),rgba(17,11,6,.82))}
        .dashboard-table tbody tr[data-game-row] td{display:grid;grid-template-columns:minmax(96px,124px) minmax(0,1fr);gap:12px;align-items:start;padding:0;border:0;min-width:0;vertical-align:top}
        .dashboard-table tbody tr[data-game-row] td::before{content:attr(data-label);font-size:11px;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);padding-top:4px}
        .dashboard-table tbody tr[data-game-row] td[data-label="Select"]{grid-column:1/-1;grid-template-columns:auto minmax(0,1fr);align-items:center}
        .dashboard-table tbody tr[data-game-row] td[data-label="Select"]::before{padding-top:0}
        .dashboard-table tbody tr[data-game-row] td[data-label="Board Payout"],
        .dashboard-table tbody tr[data-game-row] td[data-label="Visuals"],
        .dashboard-table tbody tr[data-game-row] td[data-label="Game Mode"],
        .dashboard-table tbody tr[data-game-row] td[data-label="Developer IDs"]{grid-column:1/-1;grid-template-columns:1fr}
        .dashboard-table tbody tr[data-game-row] td[data-label="Board Payout"]::before,
        .dashboard-table tbody tr[data-game-row] td[data-label="Visuals"]::before,
        .dashboard-table tbody tr[data-game-row] td[data-label="Game Mode"]::before,
        .dashboard-table tbody tr[data-game-row] td[data-label="Developer IDs"]::before{padding-top:0}
        .dashboard-table tbody tr[data-game-row] .row-index{display:inline-flex;align-items:center;justify-content:center;min-width:34px;height:34px;padding:0 10px;border-radius:999px;border:1px solid rgba(255,255,255,.12);background:rgba(255,255,255,.04)}
        .dashboard-table tbody tr[data-game-row] .board-limit-card{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
        .dashboard-table tbody tr[data-game-row] .board-limit-card .limit-wrap{flex:1 1 220px}
        .dashboard-table tbody tr[data-game-row] .board-limit-flag{display:inline-flex;align-items:center;min-height:34px;padding:0 12px;border-radius:999px;border:1px solid rgba(255,216,107,.22);background:rgba(255,216,107,.08);font-size:11px;font-weight:900;letter-spacing:.08em;text-transform:uppercase;color:#ffe08f}
        .dashboard-table tbody tr[data-game-row] .mode-card{display:grid;gap:10px;max-width:380px}
        .dashboard-table tbody tr.visual-panel-row{display:none}
        .dashboard-table tbody tr.visual-panel-row.is-open{display:block;margin:-6px 0 18px}
        .dashboard-table tbody tr.visual-panel-row td{display:block;padding:0;border:0}
        .bank-dialog{width:min(100%,520px);padding:0;border:0;border-radius:24px;background:#09111f;color:var(--text);box-shadow:0 30px 90px rgba(0,0,0,.45)}
        .bank-dialog::backdrop{background:rgba(2,6,12,.72)}
        .bank-dialog-head{display:flex;justify-content:space-between;align-items:flex-start;gap:12px;padding:18px 20px;border-bottom:1px solid var(--line)}
        .bank-dialog-head h3{margin:0 0 8px;font-family:var(--font-title);font-size:24px;letter-spacing:-.03em}
        .bank-dialog-head p{margin:0;color:var(--muted);line-height:1.6}
        .bank-dialog-body{display:grid;gap:14px;padding:18px 20px 20px}
        .bank-dialog-actions{display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap}
        .pusher-template{display:none!important}
        #lobby-control .panel-head{display:flex;justify-content:space-between;align-items:flex-start;gap:16px;flex-wrap:wrap}
        #lobby-control .panel-head .panel-actions{display:flex;gap:10px;flex-wrap:wrap}
        #lobby-control .panel-toolbar{display:flex;justify-content:space-between;align-items:flex-start;gap:12px;flex-wrap:wrap}
        #lobby-control .toolbar-copy{flex:1 1 260px}
        #lobby-control .toolbar-pills{display:flex;gap:8px;flex-wrap:wrap}
        .dashboard-table .visual-panel .visual-banner-field{grid-column:1/-1}
        .dashboard-table .visual-panel .visual-banner-field input{width:100%;min-width:0}
        @media (max-width:1240px){
            .pusher-account-fields{grid-template-columns:1fr}
        }
        @media (max-width:980px){
            .dashboard-table tbody tr[data-game-row]{grid-template-columns:1fr}
            .dashboard-table .board-payout-grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:7px}
            .dashboard-table .visual-panel{grid-template-columns:repeat(2,minmax(0,1fr))}
        }
        @media (max-width:720px){
            .runtime-grid,.pusher-zone{padding-left:16px;padding-right:16px}
            .pusher-account-grid{grid-template-columns:1fr}
            .board-payout-grid{grid-template-columns:1fr;min-width:0}
            .visual-panel{grid-template-columns:1fr}
            .visual-banner-field{grid-column:1/-1}
            .dashboard-table .filter-field[data-maintenance-user-wrap] input{max-width:none}
            .dashboard-table tbody tr[data-game-row]{padding:14px}
            .dashboard-table tbody tr[data-game-row] td{grid-template-columns:minmax(88px,110px) minmax(0,1fr)}
            .dashboard-table tbody tr[data-game-row] td[data-label="Visuals"] .visual-toggle-btn,.dashboard-table tbody tr[data-game-row] td[data-label="Visuals"] .toggle-note{width:100%}
            .developer-id-builder{display:grid;gap:10px}
            .developer-id-list{display:grid;gap:8px}
            .developer-id-row{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:8px;align-items:center}
            .developer-id-row input{min-width:0}
            .developer-id-actions{display:flex;gap:8px;flex-wrap:wrap}
            #lobby-control .panel-head .panel-actions{display:grid;grid-template-columns:1fr;gap:10px;width:100%}
            #lobby-control .panel-head .panel-actions .button-secondary,#lobby-control .panel-head .panel-actions .button-primary,.panel-footer .button-primary{width:100%}
            #lobby-control .panel-toolbar{align-items:stretch}
            .bulk-lobby-actions{flex-wrap:nowrap;overflow:auto;padding-bottom:4px;width:100%}
            .master-bank-toolbar,.master-bank-actions{width:100%}
            .master-bank-actions .button-secondary{flex:1 1 0}
        }
    </style>

    <section class="panel {{ $isGameTimePage ? 'mode-hidden' : '' }}" style="margin-bottom:18px;">
        <div class="panel-head">
            <div>
                <h2>Room operations</h2>
                <p>Manage room mode, runtime delivery, shared bank, and visual settings from one screen.</p>
            </div>
            <div class="toolbar-pills">
                <span class="toolbar-pill">Realtime {{ strtoupper($runtimeControls['realtime_mode']) }}</span>
                <span class="toolbar-pill" data-config-version-status>Config v{{ (int) ($runtimeControls['config_version'] ?? 1) }}</span>
                <span class="toolbar-pill">Pusher accounts <span data-pusher-account-count>{{ count($pusherAccounts) }}</span></span>
                <span class="toolbar-pill">Active slot {{ $activePusherIndex + 1 }}</span>
            </div>
        </div>
        <div class="dashboard-ops-grid">
            <div class="dashboard-ops-card">
                <strong>Live rooms</strong>
                <span>{{ $liveCount }}</span>
            </div>
            <div class="dashboard-ops-card">
                <strong>Developer rooms</strong>
                <span>{{ $developerCount }}</span>
            </div>
            <div class="dashboard-ops-card">
                <strong>Maintenance rooms</strong>
                <span>{{ $maintenanceCount }}</span>
            </div>
            <div class="dashboard-ops-card">
                <strong>Inactive rooms</strong>
                <span>{{ $inactiveCount ?? 0 }}</span>
            </div>
            <div class="dashboard-ops-card">
                <strong>Shared bank</strong>
                <span>{{ number_format((float) ($adminCounts['game_balance_total'] ?? 0), 2) }}</span>
            </div>
        </div>
    </section>

    <div class="filter-bar compact" style="margin-bottom:18px;">
        <div class="filter-field">
            <label for="dashboard-search">Search</label>
            <input id="dashboard-search" type="text" name="search" form="dashboard-filter-form" value="{{ $search ?? '' }}" placeholder="Game name or code" data-tour-title="সার্চ" data-tour-body="১. গেম নাম বা কোড দিয়ে দ্রুত ফিল্টার করুন। ২. Apply চাপলে সার্ভার-ফিল্টার হবে।">
        </div>
        <div class="filter-field">
            <label for="dashboard-status">Status</label>
            <select id="dashboard-status" name="status" form="dashboard-filter-form" data-help-title="স্ট্যাটাস ফিল্টার" data-help-body="Live মানে সবার জন্য খোলা। Developer মানে শুধু অনুমোদিত আইডি। Maintenance মানে সম্পূর্ণ বন্ধ।">
                <option value="">All statuses</option>
                <option value="live" {{ ($selectedStatus ?? '') === 'live' ? 'selected' : '' }}>Live</option>
                <option value="developer" {{ ($selectedStatus ?? '') === 'developer' ? 'selected' : '' }}>Developer</option>
                <option value="maintenance" {{ ($selectedStatus ?? '') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
            </select>
        </div>
        <div class="fast-find">
            <label for="dashboard-fast-find">Fast Find</label>
            <input id="dashboard-fast-find" type="text" data-fast-find-input="#dashboard-games-table" placeholder="Filter visible rows">
            <small>Searches the current page only.</small>
        </div>
        <div class="filter-actions">
            <form id="dashboard-filter-form" method="get" action="{{ $pageRoute }}">
                <button class="button-primary" type="submit">Apply</button>
            </form>
            <a class="button-secondary" href="{{ $pageRoute }}">Reset</a>
        </div>
    </div>

    @include('game_final.admin.partials.filter-summary', [
        'filters' => [
            ['label' => 'Search', 'value' => $search ?? ''],
            ['label' => 'Status', 'value' => $selectedStatus ?? ''],
        ],
        'clearUrl' => $pageRoute,
    ])

    @if (!$isGameTimePage)
        <section class="panel timing-entry-panel">
            <div class="panel-head" style="padding:0;border-bottom:0;">
                <div>
                    <h2>Game Time</h2>
                    <p>Timing controls now live on their own page so the main dashboard stays focused on room visibility, shared bank, and realtime setup.</p>
                </div>
                <div class="panel-actions">
                    <a class="button-primary" href="{{ route('admin.game-final.game-time') }}#game-time-settings">Open Game Time</a>
                </div>
            </div>
            <div class="timing-entry-grid">
                <div class="timing-entry-card">
                    <strong>Visible Games</strong>
                    <span>{{ $totalCount }}</span>
                </div>
                <div class="timing-entry-card">
                    <strong>Default Bet Phase</strong>
                    <span>20s</span>
                </div>
                <div class="timing-entry-card">
                    <strong>Editor Scope</strong>
                    <span>Per Game</span>
                </div>
            </div>
        </section>
    @endif

    <form class="panel" id="lobby-control" method="post" action="{{ route('admin.game-final.update') }}" data-confirm="{{ $isGameTimePage ? 'Save game timing changes?' : 'Save lobby and runtime changes?' }}" data-confirm-warning="{{ $isGameTimePage ? 'These timing values change live round phases for the selected games.' : 'These settings affect live room visibility and runtime delivery.' }}" data-confirm-label="{{ $isGameTimePage ? 'Save timing' : 'Save changes' }}">
        @csrf
        @if ($isGameTimePage)
            <div class="panel-head">
                <div>
                    <h2 id="game-time-editor-heading">Game time editor</h2>
                    <p>Adjust bet, popup, result, and settle durations here. The rest of the lobby configuration stays preserved while you save timing updates.</p>
                </div>
                <div class="panel-actions">
                    <a class="button-secondary" href="{{ route('admin.dashboard') }}">Back To Dashboard</a>
                    <button class="button-primary" type="submit">Save Game Time</button>
                </div>
            </div>
        @endif
        <div class="panel-head {{ $isGameTimePage ? 'mode-hidden' : '' }}">
            <div>
                <h2>Lobby control</h2>
                <p>Manage lobby visibility, developer access, board payouts, and realtime settings.</p>
            </div>
            <div class="panel-actions">
                <a class="button-secondary" href="{{ route('game-final.lobby') }}">Preview Lobby</a>
                <button class="button-primary" type="submit" data-tour-title="সেভ কন্ট্রোল" data-tour-body="১. সব পরিবর্তন একসাথে সংরক্ষণ হবে। ২. Live, Developer, Maintenance মোড এখান থেকেই কার্যকর হবে।">Save Lobby Settings</button>
            </div>
        </div>

        <div class="panel-toolbar {{ $isGameTimePage ? 'mode-hidden' : '' }}">
            <div class="toolbar-copy">Choose one realtime mode, configure failover if needed, and control whether each room is live, developer-only, or maintenance-locked.</div>
            <div class="master-bank-toolbar">
                <div class="toolbar-pills">
                    <span class="toolbar-pill">Live: <span data-live-count>{{ $liveCount }}</span></span>
                    <span class="toolbar-pill">Developer: <span data-developer-count>{{ $developerCount }}</span></span>
                    <span class="toolbar-pill">Maintenance: <span data-maintenance-count>{{ $maintenanceCount }}</span></span>
                    <span class="toolbar-pill">Inactive: <span data-inactive-count>{{ $inactiveCount ?? 0 }}</span></span>
                    <span class="toolbar-pill">Mode: {{ strtoupper($runtimeControls['realtime_mode']) }}</span>
                    <span class="toolbar-pill">Saved Config: v{{ (int) ($runtimeControls['config_version'] ?? 1) }}</span>
                    <span class="toolbar-pill">Shared Bank: {{ number_format((float) ($adminCounts['game_balance_total'] ?? 0), 2) }}</span>
                </div>
                @if ($masterBankGameCode !== '')
                    <div class="master-bank-actions">
                        <button type="button" class="button-secondary" data-game-bank-open data-direction="deposit" data-game-code="{{ $masterBankGameCode }}" data-game-name="Master Shared Bank" data-game-balance="{{ $masterBankBalance }}">Deposit</button>
                        <button type="button" class="button-secondary" data-game-bank-open data-direction="withdraw" data-game-code="{{ $masterBankGameCode }}" data-game-name="Master Shared Bank" data-game-balance="{{ $masterBankBalance }}">Withdraw</button>
                    </div>
                @endif
            </div>
        </div>

        <div class="panel-toolbar {{ $isGameTimePage ? 'mode-hidden' : '' }}">
            <div class="bulk-lobby-actions" aria-label="Bulk lobby controls">
                <label class="bulk-select-box" title="Select all games">
                    <input type="checkbox" data-bulk-select-all aria-label="Select all games">
                </label>
                <span class="bulk-selected-pill"><span data-bulk-selected-count>0</span>&nbsp;selected</span>
                <button type="button" class="button-secondary" data-bulk-lobby-visibility="active">Set Active</button>
                <button type="button" class="button-secondary" data-bulk-lobby-visibility="inactive">Set Inactive</button>
                <button type="button" class="button-secondary" data-bulk-mode="live">Set Live</button>
                <button type="button" class="button-secondary" data-bulk-mode="developer">Set Developer</button>
                <button type="button" class="button-secondary" data-bulk-mode="maintenance">Set Maintenance</button>
            </div>
            <div class="toolbar-copy">Select multiple rooms, choose a mode, then save once.</div>
        </div>

        <div class="runtime-grid {{ $isGameTimePage ? 'mode-hidden' : '' }}">
            <section class="runtime-card">
                <h3>Realtime delivery</h3>
                <p>Polling is safest, WebSocket is custom transport, and Pusher uses managed credentials with runtime failover.</p>
                <div class="toolbar-pills">
                    <span class="toolbar-pill">Current {{ strtoupper($runtimeControls['realtime_mode']) }}</span>
                    <span class="toolbar-pill">Polling {{ old('poll_interval_ms', $runtimeControls['poll_interval_ms'] ?? 1500) }} ms</span>
                </div>
            </section>

            <section class="runtime-card">
                <h3>Infrastructure status</h3>
                <p>These toggles reflect what is available in the current environment and what the runtime will use after save.</p>
                <div class="toolbar-pills">
                    <span class="toolbar-pill">{{ !empty($runtimeControls['redis_available']) ? 'Redis Ready' : 'Redis Missing' }}</span>
                    <span class="toolbar-pill">{{ !empty($runtimeControls['jobs_available']) ? 'Queue Ready' : 'Sync Queue' }}</span>
                    <span class="toolbar-pill">{{ !empty($runtimeControls['cron_available']) ? 'Cron Ready' : 'Cron Off' }}</span>
                </div>
            </section>
        </div>

        <div class="filter-bar {{ $isGameTimePage ? 'mode-hidden' : '' }}" data-runtime-controls>
            <div class="filter-field">
                <label>Realtime Mode</label>
                <select name="realtime_mode" data-realtime-mode required data-tour-title="রিয়েলটাইম মোড" data-tour-body="১. Polling সবচেয়ে নিরাপদ। ২. WebSocket কাস্টম ট্রান্সপোর্ট। ৩. Pusher ব্যবহার করলে অন্তত একটি সম্পূর্ণ অ্যাকাউন্ট লাগবে।">
                    @foreach (['polling' => 'Polling', 'websocket' => 'WebSocket', 'pusher' => 'Pusher'] as $mode => $label)
                        <option value="{{ $mode }}" {{ old('realtime_mode', $runtimeControls['realtime_mode']) === $mode ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-field">
                <label>Polling Interval</label>
                <input type="number" name="poll_interval_ms" value="{{ old('poll_interval_ms', $runtimeControls['poll_interval_ms'] ?? 1500) }}" min="500" max="10000" step="100">
            </div>

            @if ($runtimeControls['redis_available'])
                <div class="filter-field">
                    <label>Redis Cache</label>
                    <div class="toggle-row">
                        <input type="hidden" name="redis_enabled" value="0">
                        <label class="toggle">
                            <input type="checkbox" name="redis_enabled" value="1" {{ old('redis_enabled', $runtimeControls['redis_enabled']) ? 'checked' : '' }}>
                            <span class="switch-track"></span>
                        </label>
                        <span class="status-badge info">Available</span>
                    </div>
                </div>
            @endif

            @if ($runtimeControls['jobs_available'])
                <div class="filter-field">
                    <label>Queued Jobs</label>
                    <div class="toggle-row">
                        <input type="hidden" name="jobs_enabled" value="0">
                        <label class="toggle">
                            <input type="checkbox" name="jobs_enabled" value="1" {{ old('jobs_enabled', $runtimeControls['jobs_enabled']) ? 'checked' : '' }}>
                            <span class="switch-track"></span>
                        </label>
                        <span class="status-badge info">Available</span>
                    </div>
                </div>
            @endif

            @if ($runtimeControls['cron_available'])
                <div class="filter-field">
                    <label>Cron Scheduler</label>
                    <div class="toggle-row">
                        <input type="hidden" name="cron_enabled" value="0">
                        <label class="toggle">
                            <input type="checkbox" name="cron_enabled" value="1" {{ old('cron_enabled', $runtimeControls['cron_enabled']) ? 'checked' : '' }}>
                            <span class="switch-track"></span>
                        </label>
                        <span class="status-badge info">Available</span>
                    </div>
                </div>
            @endif
        </div>

        <div class="filter-bar {{ $isGameTimePage ? 'mode-hidden' : '' }}" data-websocket-fields>
            <div class="filter-field">
                <label>WebSocket URL</label>
                <input type="text" name="websocket[url]" value="{{ old('websocket.url', $runtimeControls['websocket']['url'] ?? '') }}" placeholder="wss://example.com/ws">
            </div>
            <div class="filter-field">
                <label>Protocols</label>
                <input type="text" name="websocket[protocols]" value="{{ old('websocket.protocols', $runtimeControls['websocket']['protocols'] ?? '') }}" placeholder="Optional comma list">
            </div>
        </div>

        <div class="pusher-zone {{ $isGameTimePage ? 'mode-hidden' : '' }}" id="pusher-settings" data-pusher-fields>
            <div class="pusher-zone-head">
                <div class="pusher-zone-copy">
                    <h3>Pusher accounts</h3>
                    <p>Add as many credential blocks as you need, then save once. The runtime will keep the first successful account active and can rotate away from failed ones automatically.</p>
                </div>
                <div class="pusher-zone-actions">
                    <span class="toolbar-pill">Accounts <span data-pusher-account-count>{{ count($pusherAccounts) }}</span></span>
                    <span class="toolbar-pill">Complete <span data-pusher-complete-count>{{ $completePusherCount }}</span></span>
                    <span class="toolbar-pill">Live Account {{ $activePusherIndex + 1 }}</span>
                    <button type="button" class="button-primary" data-add-pusher-account>Add Account</button>
                </div>
            </div>

            <div class="pusher-account-grid" data-pusher-account-grid>
                @foreach ($pusherAccounts as $accountIndex => $pusherAccount)
                    @php
                        $isActiveAccount = $accountIndex === $activePusherIndex;
                        $isFailedAccount = in_array($accountIndex, $failedPusherIndexes, true);
                    @endphp
                    <section
                        class="pusher-account-card {{ $isActiveAccount ? 'is-active' : '' }} {{ $isFailedAccount ? 'is-failed' : '' }}"
                        data-pusher-account-card
                        data-runtime-active="{{ $isActiveAccount ? '1' : '0' }}"
                        data-runtime-failed="{{ $isFailedAccount ? '1' : '0' }}"
                    >
                        <div class="pusher-account-head">
                            <div class="pusher-account-title">
                                <h4 data-account-title>Account {{ $accountIndex + 1 }}</h4>
                                <p data-account-subtitle>
                                    @if ($isFailedAccount)
                                        Runtime marked this account as failed and switched away from it.
                                    @elseif ($isActiveAccount)
                                        This account is the current active Pusher credential block.
                                    @else
                                        Standby credential block ready for manual save or runtime failover.
                                    @endif
                                </p>
                            </div>
                            <div class="toolbar-pills">
                                @if ($isActiveAccount)
                                    <span class="status-badge info">Active</span>
                                @endif
                                @if ($isFailedAccount)
                                    <span class="status-badge off">Failed</span>
                                @endif
                                @if (!$isActiveAccount && !$isFailedAccount)
                                    <span class="status-badge open">Standby</span>
                                @endif
                            </div>
                        </div>

                        <div class="pusher-account-fields">
                            <div class="filter-field">
                                <label>App ID</label>
                                <input type="text" name="pusher_accounts[{{ $accountIndex }}][app_id]" value="{{ $pusherAccount['app_id'] }}" autocomplete="off" data-pusher-field data-field-name="app_id">
                            </div>
                            <div class="filter-field">
                                <label>Key</label>
                                <input type="text" name="pusher_accounts[{{ $accountIndex }}][key]" value="{{ $pusherAccount['key'] }}" autocomplete="off" data-pusher-field data-field-name="key">
                            </div>
                            <div class="filter-field">
                                <label>Secret</label>
                                <input type="password" name="pusher_accounts[{{ $accountIndex }}][secret]" value="" autocomplete="new-password" placeholder="{{ !empty($pusherAccount['secret_configured']) ? 'Stored; leave blank to keep' : 'Enter secret' }}" data-pusher-field data-field-name="secret" data-secret-configured="{{ !empty($pusherAccount['secret_configured']) ? '1' : '0' }}">
                            </div>
                            <div class="filter-field">
                                <label>Cluster</label>
                                <input type="text" name="pusher_accounts[{{ $accountIndex }}][cluster]" value="{{ $pusherAccount['cluster'] }}" placeholder="mt1" data-pusher-field data-field-name="cluster">
                            </div>
                            <div class="filter-field">
                                <label>Host</label>
                                <input type="text" name="pusher_accounts[{{ $accountIndex }}][host]" value="{{ $pusherAccount['host'] }}" placeholder="Optional" data-pusher-field data-field-name="host">
                            </div>
                            <div class="filter-field">
                                <label>Port</label>
                                <input type="number" name="pusher_accounts[{{ $accountIndex }}][port]" value="{{ $pusherAccount['port'] }}" min="1" max="65535" placeholder="443" data-pusher-field data-field-name="port">
                            </div>
                            <div class="filter-field">
                                <label>Scheme</label>
                                <select name="pusher_accounts[{{ $accountIndex }}][scheme]" data-pusher-field data-field-name="scheme">
                                    @foreach (['https' => 'HTTPS', 'http' => 'HTTP'] as $scheme => $label)
                                        <option value="{{ $scheme }}" {{ ($pusherAccount['scheme'] ?: 'https') === $scheme ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="pusher-card-actions">
                            <label class="pusher-live-picker">
                                <input type="radio" name="pusher_active_index" value="{{ $accountIndex }}" data-pusher-active-radio {{ (int) old('pusher_active_index', $activePusherIndex) === $accountIndex ? 'checked' : '' }}>
                                <span>Use Live</span>
                            </label>
                            <span class="pusher-muted">Leave secret blank to keep the stored value for this account.</span>
                            <button type="button" class="button-ghost" data-remove-pusher-account>Remove</button>
                        </div>
                    </section>
                @endforeach
            </div>

            <div hidden data-pusher-legacy-mirrors>
                @foreach (array_keys($pusherDefaults) as $fieldName)
                    <input type="hidden" name="pusher[{{ $fieldName }}]" value="" data-pusher-legacy-field="{{ $fieldName }}">
                @endforeach
            </div>

            <template data-pusher-account-template>
                <section class="pusher-account-card" data-pusher-account-card data-runtime-active="0" data-runtime-failed="0">
                    <div class="pusher-account-head">
                        <div class="pusher-account-title">
                            <h4 data-account-title>Account __NUMBER__</h4>
                            <p data-account-subtitle>Draft credential block. Save to make this account available for failover.</p>
                        </div>
                        <div class="toolbar-pills">
                            <span class="status-badge open">Draft</span>
                        </div>
                    </div>

                    <div class="pusher-account-fields">
                        <div class="filter-field">
                            <label>App ID</label>
                            <input type="text" value="" autocomplete="off" data-pusher-field data-field-name="app_id">
                        </div>
                        <div class="filter-field">
                            <label>Key</label>
                            <input type="text" value="" autocomplete="off" data-pusher-field data-field-name="key">
                        </div>
                        <div class="filter-field">
                            <label>Secret</label>
                            <input type="password" value="" autocomplete="new-password" placeholder="Enter secret" data-pusher-field data-field-name="secret" data-secret-configured="0">
                        </div>
                        <div class="filter-field">
                            <label>Cluster</label>
                            <input type="text" value="mt1" placeholder="mt1" data-pusher-field data-field-name="cluster">
                        </div>
                        <div class="filter-field">
                            <label>Host</label>
                            <input type="text" value="" placeholder="Optional" data-pusher-field data-field-name="host">
                        </div>
                        <div class="filter-field">
                            <label>Port</label>
                            <input type="number" value="443" min="1" max="65535" placeholder="443" data-pusher-field data-field-name="port">
                        </div>
                        <div class="filter-field">
                            <label>Scheme</label>
                            <select data-pusher-field data-field-name="scheme">
                                <option value="https" selected>HTTPS</option>
                                <option value="http">HTTP</option>
                            </select>
                        </div>
                    </div>

                        <div class="pusher-card-actions">
                            <label class="pusher-live-picker">
                                <input type="radio" name="pusher_active_index" value="0" data-pusher-active-radio>
                                <span>Use Live</span>
                            </label>
                            <span class="pusher-muted">Draft accounts are ignored until App ID, key, and secret are all provided.</span>
                            <button type="button" class="button-ghost" data-remove-pusher-account>Remove</button>
                        </div>
                </section>
            </template>
        </div>

        <div class="table-shell {{ $isGameTimePage ? '' : 'mode-hidden' }}" id="game-time-settings">
            <div class="table-wrap">
                <table class="scan-table scan-table-wide dashboard-table">
                    <caption class="table-caption">Game time settings</caption>
                    <thead>
                        <tr>
                            <th>Game</th>
                            <th>Bet Time</th>
                            <th>Start Bet Popup</th>
                            <th>After Start Wait</th>
                            <th>Stop Bet Popup</th>
                            <th>After Stop Wait</th>
                            <th>Result Time</th>
                            <th>Next Round Wait</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($games as $game)
                            @php
                                $timing = $game['timing'];
                                $timingOld = 'games.' . $game['game_code'] . '.timing.';
                            @endphp
                            <tr>
                                <td data-label="Game">
                                    <div class="game-meta">
                                        <strong>{{ $game['name'] }}</strong>
                                        <span>{{ $game['game_code'] }} / {{ $game['board_count'] }} boards</span>
                                    </div>
                                </td>
                                <td data-label="Bet Time">
                                    <input type="number" name="games[{{ $game['game_code'] }}][timing][bet_duration_sec]" min="1" max="300" step="0.1" value="{{ old($timingOld . 'bet_duration_sec', $timing['bet_duration_sec']) }}" required>
                                    <small>Default: 20s. Betting stays open through count 0, then closes on Stop Bet.</small>
                                </td>
                                <td data-label="Start Bet Popup">
                                    <input type="number" name="games[{{ $game['game_code'] }}][timing][start_bet_popup_sec]" min="0" max="300" step="0.1" value="{{ old($timingOld . 'start_bet_popup_sec', $timing['start_bet_popup_sec']) }}" required>
                                    <small>Default: 3s</small>
                                </td>
                                <td data-label="After Start Wait">
                                    <input type="number" name="games[{{ $game['game_code'] }}][timing][start_bet_wait_sec]" min="0" max="300" step="0.1" value="{{ old($timingOld . 'start_bet_wait_sec', $timing['start_bet_wait_sec']) }}" required>
                                    <small>Default: 1.5s. Extra backend lead carried inside the open-bet window.</small>
                                </td>
                                <td data-label="Stop Bet Popup">
                                    <input type="number" name="games[{{ $game['game_code'] }}][timing][stop_bet_popup_sec]" min="0" max="300" step="0.1" value="{{ old($timingOld . 'stop_bet_popup_sec', $timing['stop_bet_popup_sec']) }}" required>
                                    <small>Default: 3s</small>
                                </td>
                                <td data-label="After Stop Wait">
                                    <input type="number" name="games[{{ $game['game_code'] }}][timing][stop_bet_wait_sec]" min="0" max="300" step="0.1" value="{{ old($timingOld . 'stop_bet_wait_sec', $timing['stop_bet_wait_sec']) }}" required>
                                    <small>Locked total: {{ $timing['stop_duration_sec'] }}s</small>
                                </td>
                                <td data-label="Result Time">
                                    <input type="number" name="games[{{ $game['game_code'] }}][timing][reveal_duration_sec]" min="1" max="300" step="0.1" value="{{ old($timingOld . 'reveal_duration_sec', $timing['reveal_duration_sec']) }}" required>
                                    <small>Reveal animation time</small>
                                </td>
                                <td data-label="Reveal Wait">
                                    <input type="number" name="games[{{ $game['game_code'] }}][timing][reveal_wait_sec]" min="0" max="300" step="0.1" value="{{ old($timingOld . 'reveal_wait_sec', $timing['reveal_wait_sec']) }}" required>
                                    <small>Hold after reveal before winner popup</small>
                                </td>
                                <td data-label="Winner Popup">
                                    <input type="number" name="games[{{ $game['game_code'] }}][timing][winner_popup_sec]" min="0" max="300" step="0.1" value="{{ old($timingOld . 'winner_popup_sec', $timing['winner_popup_sec']) }}" required>
                                    <small>Winner modal/banner live time</small>
                                </td>
                                <td data-label="Winner Wait">
                                    <input type="number" name="games[{{ $game['game_code'] }}][timing][winner_wait_sec]" min="0" max="300" step="0.1" value="{{ old($timingOld . 'winner_wait_sec', $timing['winner_wait_sec']) }}" required>
                                    <small>Gap before payout starts</small>
                                </td>
                                <td data-label="Payout Time">
                                    <input type="number" name="games[{{ $game['game_code'] }}][timing][settle_duration_sec]" min="0" max="300" step="0.1" value="{{ old($timingOld . 'settle_duration_sec', $timing['settle_duration_sec']) }}" required>
                                    <small>Wallet/payout window</small>
                                </td>
                                <td data-label="Next Round Wait">
                                    <input type="number" name="games[{{ $game['game_code'] }}][timing][settle_wait_sec]" min="0" max="300" step="0.1" value="{{ old($timingOld . 'settle_wait_sec', $timing['settle_wait_sec']) }}" required>
                                    <small>Idle gap before next round opens</small>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="table-shell {{ $isGameTimePage ? 'mode-hidden' : '' }}">
            <div class="table-wrap">
                <table class="scan-table scan-table-wide dashboard-table" id="dashboard-games-table">
                    <caption class="table-caption">Lobby visibility, board limits, and game controls</caption>
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Game</th>
                            <th>Family</th>
                            <th>Preview</th>
                            <th>Lobby</th>
                            <th>Total Boards</th>
                            <th>Board Limit</th>
                            <th id="board-settings">Board Payout</th>
                            <th id="visual-settings">Visuals</th>
                            <th>Game Mode</th>
                            <th>Developer IDs</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($games as $game)
                            @php
                                $familyClass = $game['family'] === 'Teen Patti' ? 'teen' : ($game['family'] === 'Lucky Wheel' ? 'lucky' : 'fruit');
                            @endphp
                            <tr data-game-row id="game-{{ $game['game_code'] }}" class="{{ !$game['enabled'] || $game['game_status'] === 'maintenance' ? 'is-disabled' : ($game['game_status'] === 'developer' ? 'is-maintenance' : '') }}">
                                <td data-label="Select">
                                    <label class="bulk-select-box">
                                        <input type="checkbox" data-game-select value="{{ $game['game_code'] }}" aria-label="Select {{ $game['name'] }}">
                                    </label>
                                    <span class="row-index">#{{ $loop->iteration }}</span>
                                </td>
                                <td data-label="Game">
                                    <div class="game-meta">
                                        <strong><a class="table-link" href="#game-{{ $game['game_code'] }}">{{ $game['name'] }}</a></strong>
                                        <span>{{ $game['game_code'] }}</span>
                                    </div>
                                </td>
                                <td data-label="Family">
                                    <span class="family-badge {{ $familyClass }}">{{ $game['family'] }}</span>
                                </td>
                                <td data-label="Preview">
                                    <div class="preview-list">
                                        @foreach ($game['preview'] as $preview)
                                            @include('game_final.admin.partials.board-token', ['key' => $preview, 'label' => $preview])
                                        @endforeach
                                    </div>
                                </td>
                                <td data-label="Lobby">
                                    @php
                                        $currentLobbyVisibility = old('games.' . $game['game_code'] . '.lobby_visibility', $game['lobby_visibility'] ?? ($game['enabled'] ? 'active' : 'inactive'));
                                    @endphp
                                    <div class="mode-card">
                                        <select data-lobby-visibility name="games[{{ $game['game_code'] }}][lobby_visibility]">
                                            <option value="active" {{ $currentLobbyVisibility === 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ $currentLobbyVisibility === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        <small class="toggle-note" data-lobby-status-note>{{ $currentLobbyVisibility === 'active' ? 'Shown in the lobby and allowed to start from lobby links' : 'Hidden from the lobby and blocked from normal lobby starts' }}</small>
                                    </div>
                                </td>
                                <td data-label="Total Boards">
                                    <span class="board-badge">{{ $game['board_count'] }} Boards</span>
                                </td>
                                <td data-label="Board Limit">
                                    <div class="board-limit-card">
                                        <span class="board-limit-flag">Board limit set</span>
                                        <div class="limit-wrap">
                                            <input id="limit-{{ $game['game_code'] }}" type="number" name="games[{{ $game['game_code'] }}][max_distinct_boards_per_user]" min="1" max="{{ $game['board_count'] }}" value="{{ old('games.' . $game['game_code'] . '.max_distinct_boards_per_user', $game['max_distinct_boards_per_user']) }}" required>
                                            <small>Allowed: 1 to {{ $game['board_count'] }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Board Payout">
                                    <div class="board-payout-grid">
                                        @foreach ($game['boards'] as $board)
                                            @php
                                                $payoutOldKey = 'games.' . $game['game_code'] . '.boards.' . $board['canonical_key'] . '.payout_multiplier';
                                            @endphp
                                            <div class="board-payout-item">
                                                <label>
                                                    @include('game_final.admin.partials.board-token', ['key' => $board['canonical_key'], 'label' => $board['display_name']])
                                                </label>
                                                <input type="number" name="games[{{ $game['game_code'] }}][boards][{{ $board['canonical_key'] }}][payout_multiplier]" value="{{ old($payoutOldKey, $board['payout_input']) }}" min="0.01" step="0.01" required aria-label="{{ $game['name'] }} {{ $board['display_name'] }} payout multiplier" data-reset-scope="{{ $game['game_code'] }}" data-reset-value="{{ $board['payout_input'] }}">
                                            </div>
                                        @endforeach
                                        <small class="board-payout-note">Change payout only while this room is out of live mode.</small>
                                    </div>
                                </td>
                                <td data-label="Visuals">
                                    <button type="button" class="button-secondary visual-toggle-btn" data-visual-toggle="{{ $game['game_code'] }}">Lobby Banner / Theme</button>
                                    <button type="button" class="button-secondary visual-toggle-btn" data-reset-game="{{ $game['game_code'] }}">Reset</button>
                                    <small class="toggle-note">Clock: {{ $visualOptions['clock'][$game['ui_theme']['clock_theme']] ?? $game['ui_theme']['clock_theme'] }}</small>
                                </td>
                                <td data-label="Game Mode">
                                    <div class="mode-card" data-game-mode-wrap>
                                        @php
                                            $currentStatus = old('games.' . $game['game_code'] . '.game_status', $game['game_status']);
                                        @endphp
                                        <select data-game-mode name="games[{{ $game['game_code'] }}][game_status]">
                                            <option value="live" {{ $currentStatus === 'live' ? 'selected' : '' }}>Live</option>
                                            <option value="developer" {{ $currentStatus === 'developer' ? 'selected' : '' }}>Developer</option>
                                            <option value="maintenance" {{ $currentStatus === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                        </select>
                                        <small class="toggle-note" data-mode-status>
                                            {{ $currentStatus === 'developer'
                                                ? 'Only approved developer IDs can enter when the room is active'
                                                : ($currentStatus === 'maintenance'
                                                    ? 'No user can enter while maintenance mode is active'
                                                    : 'All approved lobby users can enter when the room is active') }}
                                        </small>
                                    </div>
                                </td>
                                <td data-label="Developer IDs">
                                    <div class="limit-wrap" data-maintenance-user-wrap>
                                        @php
                                            $developerIdValue = old('games.' . $game['game_code'] . '.maintenance_allowed_user_ids', $game['maintenance_allowed_user_ids'] ?? $game['maintenance_allowed_user_id']);
                                        @endphp
                                        <input type="hidden" name="games[{{ $game['game_code'] }}][maintenance_allowed_user_ids]" value="{{ $developerIdValue }}" data-developer-id-output>
                                        <div class="developer-id-builder" data-developer-id-builder data-developer-id-seed="{{ $developerIdValue }}" data-tour-title="ডেভেলপার আইডি" data-tour-body="১. Developer মোডে শুধু এই ইউজার আইডিগুলো খেলতে পারবে। ২. Live মোডে এই তালিকা উপেক্ষা করা হবে। ৩. Maintenance মোডে কেউ খেলতে পারবে না।">
                                            <div class="developer-id-list" data-developer-id-list></div>
                                            <div class="developer-id-actions">
                                                <button type="button" class="button-secondary" data-developer-id-add>+ Add ID</button>
                                            </div>
                                        </div>
                                        <small>Developer mode accepts only these user IDs. Live mode ignores this list.</small>
                                    </div>
                                </td>
                            </tr>
                            <tr class="visual-panel-row" data-visual-panel="{{ $game['game_code'] }}">
                                <td colspan="11">
                                    <div class="visual-panel">
                                        @php
                                            $ui = $game['ui_theme'];
                                            $uiOld = 'games.' . $game['game_code'] . '.ui_theme.';
                                        @endphp
                                        <div class="filter-field visual-banner-field">
                                            <label>Lobby Banner URL</label>
                                            <input type="url" name="games[{{ $game['game_code'] }}][ui_theme][lobby_banner_url]" value="{{ old($uiOld . 'lobby_banner_url', $ui['lobby_banner_url']) }}" placeholder="https://example.com/banner.png" data-reset-scope="{{ $game['game_code'] }}" data-reset-value="{{ $ui['lobby_banner_url'] }}">
                                        </div>
                                        <div class="filter-field">
                                            <label>Game Color</label>
                                            <input type="color" name="games[{{ $game['game_code'] }}][ui_theme][primary_color]" value="{{ old($uiOld . 'primary_color', $ui['primary_color']) }}" data-reset-scope="{{ $game['game_code'] }}" data-reset-value="{{ $ui['primary_color'] }}">
                                        </div>
                                        <div class="filter-field">
                                            <label>Accent Color</label>
                                            <input type="color" name="games[{{ $game['game_code'] }}][ui_theme][accent_color]" value="{{ old($uiOld . 'accent_color', $ui['accent_color']) }}" data-reset-scope="{{ $game['game_code'] }}" data-reset-value="{{ $ui['accent_color'] }}">
                                        </div>
                                        <div class="filter-field">
                                            <label id="clock-settings">Clock / Countdown</label>
                                            <select name="games[{{ $game['game_code'] }}][ui_theme][clock_theme]" data-reset-scope="{{ $game['game_code'] }}" data-reset-value="{{ $ui['clock_theme'] }}">
                                                @foreach ($visualOptions['clock'] as $key => $label)
                                                    <option value="{{ $key }}" {{ old($uiOld . 'clock_theme', $ui['clock_theme']) === $key ? 'selected' : '' }}>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="filter-field">
                                            <label id="chip-settings">Chip Set</label>
                                            <select name="games[{{ $game['game_code'] }}][ui_theme][chip_theme]" data-reset-scope="{{ $game['game_code'] }}" data-reset-value="{{ $ui['chip_theme'] }}">
                                                @foreach ($visualOptions['chip'] as $key => $label)
                                                    <option value="{{ $key }}" {{ old($uiOld . 'chip_theme', $ui['chip_theme']) === $key ? 'selected' : '' }}>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="filter-field">
                                            <label>Chair / Seat</label>
                                            <select name="games[{{ $game['game_code'] }}][ui_theme][chair_theme]" data-reset-scope="{{ $game['game_code'] }}" data-reset-value="{{ $ui['chair_theme'] }}">
                                                @foreach ($visualOptions['chair'] as $key => $label)
                                                    <option value="{{ $key }}" {{ old($uiOld . 'chair_theme', $ui['chair_theme']) === $key ? 'selected' : '' }}>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="filter-field">
                                            <label>Items</label>
                                            <select name="games[{{ $game['game_code'] }}][ui_theme][item_theme]" data-reset-scope="{{ $game['game_code'] }}" data-reset-value="{{ $ui['item_theme'] }}">
                                                @foreach ($visualOptions['item'] as $key => $label)
                                                    <option value="{{ $key }}" {{ old($uiOld . 'item_theme', $ui['item_theme']) === $key ? 'selected' : '' }}>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="filter-field">
                                            <label id="popup-settings">Popup Design</label>
                                            <select name="games[{{ $game['game_code'] }}][ui_theme][popup_theme]" data-reset-scope="{{ $game['game_code'] }}" data-reset-value="{{ $ui['popup_theme'] }}">
                                                @foreach ($visualOptions['popup'] as $key => $label)
                                                    <option value="{{ $key }}" {{ old($uiOld . 'popup_theme', $ui['popup_theme']) === $key ? 'selected' : '' }}>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if (count($games) === 0)
                            <tr class="empty-row" data-empty-row>
                                <td colspan="10"><div class="empty-state">No game rows matched the current filters. <a class="table-link" href="{{ route('admin.dashboard') }}">Reset filters</a></div></td>
                            </tr>
                        @else
                            <tr class="empty-row" data-empty-row style="display:none;">
                                <td colspan="10"><div class="empty-state">No visible rows matched the fast find filter.</div></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="panel-footer">
            <p>{{ $isGameTimePage ? 'Timing changes apply after save and update each room phase without requiring the full dashboard editor.' : 'Changes apply immediately after saving. Existing live entry requests and the main user lobby both follow the same visibility, maintenance, and board-limit settings.' }}</p>
            <button class="button-primary" type="submit">{{ $isGameTimePage ? 'Save Game Time' : 'Save Lobby Settings' }}</button>
        </div>
    </form>

    <dialog class="bank-dialog" data-game-bank-dialog>
        <div class="bank-dialog-head">
            <div>
                <h3 data-game-bank-title>Shared bank transfer</h3>
                <p data-game-bank-copy>Adjust the one shared game bank directly from the admin panel.</p>
            </div>
            <button type="button" class="button-secondary" data-game-bank-close>Close</button>
        </div>
        <form method="post" action="{{ route('admin.game-final.game-balance-transfer') }}" class="bank-dialog-body" data-confirm="Confirm shared bank transfer?" data-confirm-warning="This changes the shared game balance immediately." data-confirm-label="Apply transfer">
            @csrf
            <input type="hidden" name="game_code" value="" data-game-bank-code>
            <input type="hidden" name="direction" value="deposit" data-game-bank-direction>
            <div class="filter-field">
                <label>Selected Context</label>
                <input type="text" value="" data-game-bank-name readonly>
            </div>
            <div class="filter-field">
                <label>Current Shared Balance</label>
                <input type="text" value="" data-game-bank-balance readonly>
            </div>
            <div class="filter-field">
                <label>Amount</label>
                <input type="number" name="amount" min="0.01" step="0.01" required>
            </div>
            <div class="filter-field">
                <label>Admin Note</label>
                <input type="text" name="note" maxlength="255" placeholder="Reason or ticket number">
            </div>
            <div class="bank-dialog-actions">
                <button type="button" class="button-secondary" data-game-bank-close>Cancel</button>
                <button type="submit" class="button-primary" data-game-bank-submit>Save Transfer</button>
            </div>
            <div class="dialog-credit">Powerd by JAMBOai</div>
        </form>
    </dialog>
@endsection

@section('page_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modeInputs = Array.from(document.querySelectorAll('[data-game-mode]'));
            const lobbyVisibilityInputs = Array.from(document.querySelectorAll('[data-lobby-visibility]'));
            const liveCountNodes = Array.from(document.querySelectorAll('[data-live-count]'));
            const developerCountNodes = Array.from(document.querySelectorAll('[data-developer-count]'));
            const maintenanceCountNodes = Array.from(document.querySelectorAll('[data-maintenance-count]'));
            const inactiveCountNodes = Array.from(document.querySelectorAll('[data-inactive-count]'));
            const realtimeMode = document.querySelector('[data-realtime-mode]');
            const pusherFields = document.querySelector('[data-pusher-fields]');
            const websocketFields = document.querySelector('[data-websocket-fields]');
            const visualButtons = Array.from(document.querySelectorAll('[data-visual-toggle]'));
            const resetButtons = Array.from(document.querySelectorAll('[data-reset-game]'));
            const pusherGrid = document.querySelector('[data-pusher-account-grid]');
            const pusherTemplate = document.querySelector('[data-pusher-account-template]');
            const addPusherButton = document.querySelector('[data-add-pusher-account]');
            const pusherLegacyFields = Array.from(document.querySelectorAll('[data-pusher-legacy-field]'));
            const pusherCountNodes = Array.from(document.querySelectorAll('[data-pusher-account-count]'));
            const pusherCompleteNodes = Array.from(document.querySelectorAll('[data-pusher-complete-count]'));
            const pusherMaxAccounts = {{ $pusherMaxAccounts }};
            const gameBankDialog = document.querySelector('[data-game-bank-dialog]');
            const gameBankButtons = Array.from(document.querySelectorAll('[data-game-bank-open]'));
            const gameBankCloseButtons = Array.from(document.querySelectorAll('[data-game-bank-close]'));
            const gameBankCode = gameBankDialog ? gameBankDialog.querySelector('[data-game-bank-code]') : null;
            const gameBankDirection = gameBankDialog ? gameBankDialog.querySelector('[data-game-bank-direction]') : null;
            const gameBankName = gameBankDialog ? gameBankDialog.querySelector('[data-game-bank-name]') : null;
            const gameBankBalance = gameBankDialog ? gameBankDialog.querySelector('[data-game-bank-balance]') : null;
            const gameBankTitle = gameBankDialog ? gameBankDialog.querySelector('[data-game-bank-title]') : null;
            const gameBankCopy = gameBankDialog ? gameBankDialog.querySelector('[data-game-bank-copy]') : null;
            const gameBankSubmit = gameBankDialog ? gameBankDialog.querySelector('[data-game-bank-submit]') : null;
            const bulkSelectAll = document.querySelector('[data-bulk-select-all]');
            const gameSelectInputs = Array.from(document.querySelectorAll('[data-game-select]'));
            const bulkSelectedCount = document.querySelector('[data-bulk-selected-count]');
            const bulkModeButtons = Array.from(document.querySelectorAll('[data-bulk-mode]'));
            const bulkLobbyVisibilityButtons = Array.from(document.querySelectorAll('[data-bulk-lobby-visibility]'));
            const developerBuilders = Array.from(document.querySelectorAll('[data-developer-id-builder]'));

            const syncBulkUi = function () {
                const selected = gameSelectInputs.filter(function (input) {
                    return input.checked;
                }).length;

                if (bulkSelectedCount) {
                    bulkSelectedCount.textContent = String(selected);
                }

                if (bulkSelectAll) {
                    bulkSelectAll.checked = selected > 0 && selected === gameSelectInputs.length;
                    bulkSelectAll.indeterminate = selected > 0 && selected < gameSelectInputs.length;
                }
            };

            const applyBulkMode = function (mode) {
                gameSelectInputs.forEach(function (checkbox) {
                    if (!checkbox.checked) {
                        return;
                    }

                    const row = checkbox.closest('[data-game-row]');
                    const modeInput = row ? row.querySelector('[data-game-mode]') : null;
                    if (modeInput) {
                        modeInput.value = mode;
                        modeInput.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                });

                syncBulkUi();
            };

            const applyBulkLobbyVisibility = function (visibility) {
                gameSelectInputs.forEach(function (checkbox) {
                    if (!checkbox.checked) {
                        return;
                    }

                    const row = checkbox.closest('[data-game-row]');
                    const lobbyVisibilityInput = row ? row.querySelector('[data-lobby-visibility]') : null;
                    if (lobbyVisibilityInput) {
                        lobbyVisibilityInput.value = visibility;
                        lobbyVisibilityInput.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                });

                syncBulkUi();
            };

            const syncDeveloperBuilder = function (builder) {
                if (!builder) {
                    return;
                }

                const output = builder.parentElement ? builder.parentElement.querySelector('[data-developer-id-output]') : null;
                const inputs = Array.from(builder.querySelectorAll('[data-developer-id-input]'));
                const values = inputs
                    .map(function (input) {
                        return String(input.value || '').replace(/[^\d]/g, '').trim();
                    })
                    .filter(function (value) {
                        return value !== '';
                    });

                inputs.forEach(function (input) {
                    input.value = String(input.value || '').replace(/[^\d]/g, '');
                });

                if (output) {
                    output.value = values.join(', ');
                }
            };

            const addDeveloperIdRow = function (builder, value) {
                const list = builder ? builder.querySelector('[data-developer-id-list]') : null;
                if (!list) {
                    return;
                }

                const row = document.createElement('div');
                row.className = 'developer-id-row';
                row.innerHTML = '<input type="number" min="1" step="1" inputmode="numeric" data-developer-id-input placeholder="User ID" aria-label="Developer user ID"><button type="button" class="button-secondary" data-developer-id-remove>Remove</button>';
                const input = row.querySelector('[data-developer-id-input]');
                if (input && value) {
                    input.value = String(value).replace(/[^\d]/g, '');
                }
                list.appendChild(row);
                syncDeveloperBuilder(builder);
            };

            const syncGameModeUi = function () {
                let liveCount = 0;
                let developerCount = 0;
                let maintenanceCount = 0;
                let inactiveCount = 0;

                modeInputs.forEach(function (input) {
                    const row = input.closest('[data-game-row]');
                    const status = row ? row.querySelector('[data-mode-status]') : null;
                    const lobbyStatus = row ? row.querySelector('[data-lobby-status-note]') : null;
                    const lobbyVisibilityInput = row ? row.querySelector('[data-lobby-visibility]') : null;
                    const maintenanceWrap = row ? row.querySelector('[data-maintenance-user-wrap]') : null;
                    const mode = input.value;
                    const lobbyVisibility = lobbyVisibilityInput ? lobbyVisibilityInput.value : 'active';
                    const isInactive = lobbyVisibility === 'inactive';

                    if (isInactive) {
                        inactiveCount += 1;
                    } else if (mode === 'live') {
                        liveCount += 1;
                    } else if (mode === 'developer') {
                        developerCount += 1;
                    } else {
                        maintenanceCount += 1;
                    }

                    if (row) {
                        row.classList.toggle('is-disabled', isInactive || mode === 'maintenance');
                        row.classList.toggle('is-maintenance', mode === 'maintenance');
                    }

                    if (lobbyStatus) {
                        lobbyStatus.textContent = isInactive
                            ? 'Hidden from the lobby and blocked from normal lobby starts'
                            : 'Shown in the lobby and allowed to start from lobby links';
                    }

                    if (status) {
                        status.textContent = mode === 'developer'
                            ? 'Only approved developer IDs can enter when the room is active'
                            : (mode === 'maintenance' ? 'No user can enter while maintenance mode is active' : 'All approved lobby users can enter when the room is active');
                    }

                    if (maintenanceWrap) {
                        maintenanceWrap.style.opacity = mode === 'developer' ? '1' : '.48';
                    }
                });

                liveCountNodes.forEach(function (node) {
                    node.textContent = String(liveCount);
                });

                developerCountNodes.forEach(function (node) {
                    node.textContent = String(developerCount);
                });

                maintenanceCountNodes.forEach(function (node) {
                    node.textContent = String(maintenanceCount);
                });

                inactiveCountNodes.forEach(function (node) {
                    node.textContent = String(inactiveCount);
                });
            };

            const syncRealtimeUi = function () {
                if (!realtimeMode || !pusherFields) {
                    return;
                }

                pusherFields.style.display = realtimeMode.value === 'pusher' ? 'grid' : 'none';
                if (websocketFields) {
                    websocketFields.style.display = realtimeMode.value === 'websocket' ? 'grid' : 'none';
                }
            };

            const applyHashSectionBehavior = function () {
                const hash = (window.location.hash || '').replace('#', '');
                if (!hash) {
                    return;
                }

                if (hash === 'pusher-settings' && realtimeMode) {
                    realtimeMode.value = 'pusher';
                    syncRealtimeUi();
                }

                if (['visual-settings', 'popup-settings', 'chip-settings', 'clock-settings'].includes(hash)) {
                    const firstVisualPanel = document.querySelector('[data-visual-panel]');
                    if (firstVisualPanel) {
                        firstVisualPanel.classList.add('is-open');
                    }
                }

                const target = document.getElementById(hash);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            };

            const cardSecretConfigured = function (card) {
                const secretField = card.querySelector('[data-field-name="secret"]');
                if (!secretField) {
                    return false;
                }

                return secretField.value.trim() !== '' || secretField.getAttribute('data-secret-configured') === '1';
            };

            const syncPusherLegacyMirrors = function () {
                if (!pusherGrid) {
                    return;
                }

                const firstCard = pusherGrid.querySelector('[data-pusher-account-card]');
                pusherLegacyFields.forEach(function (mirror) {
                    const fieldName = mirror.getAttribute('data-pusher-legacy-field');
                    const source = firstCard ? firstCard.querySelector('[data-field-name="' + fieldName + '"]') : null;
                    mirror.value = source ? source.value : '';
                });
            };

            const syncPusherSummary = function () {
                if (!pusherGrid) {
                    return;
                }

                const cards = Array.from(pusherGrid.querySelectorAll('[data-pusher-account-card]'));
                const complete = cards.filter(function (card) {
                    const appId = card.querySelector('[data-field-name="app_id"]');
                    const key = card.querySelector('[data-field-name="key"]');
                    return appId && key && appId.value.trim() !== '' && key.value.trim() !== '' && cardSecretConfigured(card);
                }).length;

                pusherCountNodes.forEach(function (node) {
                    node.textContent = String(cards.length);
                });

                pusherCompleteNodes.forEach(function (node) {
                    node.textContent = String(complete);
                });

                if (addPusherButton) {
                    addPusherButton.disabled = cards.length >= pusherMaxAccounts;
                }
            };

            const reindexPusherCards = function () {
                if (!pusherGrid) {
                    return;
                }

                const cards = Array.from(pusherGrid.querySelectorAll('[data-pusher-account-card]'));
                cards.forEach(function (card, index) {
                    const title = card.querySelector('[data-account-title]');
                    const removeButton = card.querySelector('[data-remove-pusher-account]');
                    const activeRadio = card.querySelector('[data-pusher-active-radio]');

                    if (title) {
                        title.textContent = 'Account ' + String(index + 1);
                    }

                    card.querySelectorAll('[data-pusher-field]').forEach(function (field) {
                        const fieldName = field.getAttribute('data-field-name');
                        field.name = 'pusher_accounts[' + index + '][' + fieldName + ']';
                        field.setAttribute('data-pusher-account-field', index + ':' + fieldName);
                    });

                    if (removeButton) {
                        removeButton.disabled = cards.length <= 1;
                    }

                    if (activeRadio) {
                        activeRadio.value = String(index);
                    }
                });

                const checkedRadio = pusherGrid.querySelector('[data-pusher-active-radio]:checked');
                if (!checkedRadio) {
                    const firstRadio = pusherGrid.querySelector('[data-pusher-active-radio]');
                    if (firstRadio) {
                        firstRadio.checked = true;
                    }
                }

                syncPusherLegacyMirrors();
                syncPusherSummary();
            };

            const addPusherAccountCard = function () {
                if (!pusherGrid || !pusherTemplate) {
                    return;
                }

                const currentCount = pusherGrid.querySelectorAll('[data-pusher-account-card]').length;
                if (currentCount >= pusherMaxAccounts) {
                    return;
                }

                const wrapper = document.createElement('div');
                wrapper.innerHTML = pusherTemplate.innerHTML.trim().replace('__NUMBER__', String(currentCount + 1));
                const card = wrapper.firstElementChild;
                if (!card) {
                    return;
                }

                pusherGrid.appendChild(card);
                reindexPusherCards();
            };

            if (pusherGrid) {
                pusherGrid.addEventListener('click', function (event) {
                    const removeButton = event.target.closest('[data-remove-pusher-account]');
                    if (!removeButton) {
                        return;
                    }

                    const cards = pusherGrid.querySelectorAll('[data-pusher-account-card]');
                    if (cards.length <= 1) {
                        return;
                    }

                    const card = removeButton.closest('[data-pusher-account-card]');
                    if (card) {
                        card.remove();
                        reindexPusherCards();
                    }
                });

                pusherGrid.addEventListener('input', function (event) {
                    if (event.target.matches('[data-pusher-field]')) {
                        syncPusherLegacyMirrors();
                        syncPusherSummary();
                    }
                });

                pusherGrid.addEventListener('change', function (event) {
                    if (event.target.matches('[data-pusher-field]')) {
                        syncPusherLegacyMirrors();
                        syncPusherSummary();
                    }
                });
            }

            if (addPusherButton) {
                addPusherButton.addEventListener('click', addPusherAccountCard);
            }

            gameBankButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    if (!gameBankDialog || !gameBankCode || !gameBankDirection || !gameBankName || !gameBankBalance || !gameBankTitle || !gameBankCopy || !gameBankSubmit) {
                        return;
                    }

                    const direction = button.getAttribute('data-direction') || 'deposit';
                    const gameName = button.getAttribute('data-game-name') || 'Game';
                    const gameCode = button.getAttribute('data-game-code') || '';
                    const balance = button.getAttribute('data-game-balance') || '0.00';

                    gameBankCode.value = gameCode;
                    gameBankDirection.value = direction;
                    gameBankName.value = gameName + ' (' + gameCode + ')';
                    gameBankBalance.value = balance;
                    gameBankTitle.textContent = (direction === 'deposit' ? 'Deposit shared bank from ' : 'Withdraw shared bank from ') + gameName;
                    gameBankCopy.textContent = direction === 'deposit'
                        ? 'This adds money into the one shared game bank. All games start using the updated balance immediately.'
                        : 'This removes money from the one shared game bank. Winner selection keeps using this same shared balance.';
                    gameBankSubmit.textContent = direction === 'deposit' ? 'Deposit Balance' : 'Withdraw Balance';
                    gameBankDialog.showModal();
                });
            });

            gameBankCloseButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    if (gameBankDialog) {
                        gameBankDialog.close();
                    }
                });
            });

            visualButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    const key = button.getAttribute('data-visual-toggle');
                    const panel = document.querySelector('[data-visual-panel="' + key + '"]');
                    if (panel) {
                        panel.classList.toggle('is-open');
                    }
                });
            });

            resetButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    const key = button.getAttribute('data-reset-game');
                    const fields = Array.from(document.querySelectorAll('[data-reset-scope="' + key + '"]'));

                    fields.forEach(function (field) {
                        field.value = field.getAttribute('data-reset-value') || '';
                        field.dispatchEvent(new Event('input', { bubbles: true }));
                        field.dispatchEvent(new Event('change', { bubbles: true }));
                    });
                });
            });

            modeInputs.forEach(function (input) {
                input.addEventListener('change', syncGameModeUi);
            });

            lobbyVisibilityInputs.forEach(function (input) {
                input.addEventListener('change', syncGameModeUi);
            });

            gameSelectInputs.forEach(function (input) {
                input.addEventListener('change', syncBulkUi);
            });

            if (bulkSelectAll) {
                bulkSelectAll.addEventListener('change', function () {
                    gameSelectInputs.forEach(function (input) {
                        input.checked = bulkSelectAll.checked;
                    });
                    syncBulkUi();
                });
            }

            bulkModeButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    applyBulkMode(button.getAttribute('data-bulk-mode') || 'live');
                });
            });

            bulkLobbyVisibilityButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    applyBulkLobbyVisibility(button.getAttribute('data-bulk-lobby-visibility') || 'active');
                });
            });

            if (realtimeMode) {
                realtimeMode.addEventListener('change', syncRealtimeUi);
            }

            developerBuilders.forEach(function (builder) {
                const seed = String(builder.getAttribute('data-developer-id-seed') || '').split(/[\s,]+/).filter(function (value) {
                    return value.trim() !== '';
                });
                if (!seed.length) {
                    addDeveloperIdRow(builder, '');
                } else {
                    seed.forEach(function (value) {
                        addDeveloperIdRow(builder, value);
                    });
                }

                builder.addEventListener('click', function (event) {
                    const addButton = event.target.closest('[data-developer-id-add]');
                    const removeButton = event.target.closest('[data-developer-id-remove]');
                    if (addButton) {
                        addDeveloperIdRow(builder, '');
                        return;
                    }
                    if (removeButton) {
                        const row = removeButton.closest('.developer-id-row');
                        if (row) {
                            row.remove();
                            if (!builder.querySelector('[data-developer-id-input]')) {
                                addDeveloperIdRow(builder, '');
                            } else {
                                syncDeveloperBuilder(builder);
                            }
                        }
                    }
                });

                builder.addEventListener('input', function () {
                    syncDeveloperBuilder(builder);
                });
            });

            syncGameModeUi();
            syncBulkUi();
            syncRealtimeUi();
            reindexPusherCards();
            applyHashSectionBehavior();
            window.addEventListener('hashchange', applyHashSectionBehavior);
        });
    </script>
@endsection
