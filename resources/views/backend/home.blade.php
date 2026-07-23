@extends('backend.layouts.main')
@section('content')

@php
    $adminCan=function($key,$default=false){ return \App\Models\AdminParmisiton::allowed(Auth::id(),$key,$default); };
    $dashboardAccess=$adminCan('dashboard_access');
    $dashboardCan=function($key,$fallbackKey=null) use ($adminCan,$dashboardAccess){
        $default=$dashboardAccess;
        if($fallbackKey){
            $default=$adminCan($fallbackKey,$dashboardAccess);
        }
        return $adminCan($key,$default);
    };
@endphp
@if($adminCan('dashboard_access'))
    @php
        $protal_sand = $total_portal_transfer - $total_recall;
        $total_serve = round((
            $users_balance + 
            $total_gift + 
            $fruts_game_balance->game_balance + 
            $five_game_balance->game_balance + 
            $greedy_game_balance->game_balance + 
            $teenpatti_game_balance->game_balance + 
            $teenpatti_game_balance->second_balance + 
            $teenpatti_game_balance->third_balance + 
            $greedy_game_balance->second_balance + 
            $greedy_game_balance->third_balance + 
            $fruts_game_balance->third_balance + 
            $fruts_game_balance->second_balance + 
            $lucky_gift->balance
        ));
        $base_loss_profit = $protal_sand - $total_serve;
        $game_pro_value = (int) ($game_pro_balance['balance'] ?? 0);
        $loss_profit = $base_loss_profit + $game_pro_value;
        $profit_formula = 'Base: '.((int) round($base_loss_profit)).' + Game Pro: '.$game_pro_value;
        $money = function ($value) {
            return (string) ((int) round((float) ($value ?? 0)));
        };
    @endphp

    <style>
        /* Modern Dashboard CSS */
        :root {
            --primary: #2563eb;
            --primary-light: #3b82f6;
            --primary-dark: #1d4ed8;
            --secondary: #0ea5e9;
            --success: #16a34a;
            --danger: #dc2626;
            --warning: #f59e0b;
            --info: #0891b2;
            --dark: #f4f6f8;
            --dark-light: #ffffff;
            --dark-lighter: #f1f5f9;
            --light: #111827;
            --light-gray: #e5e7eb;
            --text-dark: #111827;
            --text-light: #111827;
            --text-muted: #64748b;
            --border-color: #e5e7eb;
            --card-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
            --card-shadow-hover: 0 14px 30px rgba(15, 23, 42, 0.12);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--dark);
            color: var(--text-light);
            font-family: 'Inter', 'Open Sans', sans-serif;
            font-size: 13px;
        }

        /* Dashboard Container */
        .dashboard-container {
            padding: 1rem;
            max-width: 1600px;
            margin: 0 auto;
        }

        /* Action Bar */
        .action-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 2rem;
            padding: 0.5rem 0;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.3px;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-decoration: none;
        }

        .action-btn i {
            font-size: 1rem;
        }

        .action-btn-warning {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: white;
        }

        .action-btn-info {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
        }

        .action-btn-success {
            background: linear-gradient(135deg, #00b09b, #96c93d);
            color: white;
        }

        .action-btn-danger {
            background: linear-gradient(135deg, var(--danger), #b91c1c);
            color: white;
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .version-badge {
            background: var(--dark-lighter);
            padding: 0.6rem 1.2rem;
            border-radius: 12px;
            font-weight: 600;
            color: var(--light);
            border-left: 4px solid var(--primary);
        }

        .ops-strip {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .ops-pill {
            background: linear-gradient(145deg, rgba(43,43,59,.96), rgba(30,30,47,.96));
            border: 1px solid var(--border-color);
            border-radius: 18px;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 86px;
            box-shadow: var(--card-shadow);
        }

        .ops-pill small,
        .formula-line {
            color: var(--text-muted);
            font-weight: 700;
            letter-spacing: .2px;
        }

        .ops-pill strong {
            color: var(--light);
            font-size: 1.35rem;
            font-weight: 900;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 230px), 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
            align-items: stretch;
        }

        /* Stat Card */
        .stat-card {
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.045), rgba(255, 255, 255, 0.018)),
                var(--dark-light);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 10px 26px rgba(0, 0, 0, 0.18);
            transition: var(--transition);
            border: 1px solid var(--border-color);
            position: relative;
            min-height: 156px;
            height: 100%;
            display: flex;
            flex-direction: column;
            isolation: isolate;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 4px;
            background: var(--primary);
            opacity: 0.95;
            transition: var(--transition);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right, rgba(76, 201, 240, 0.12), transparent 34%);
            pointer-events: none;
            z-index: -1;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 34px rgba(0, 0, 0, 0.24);
            border-color: rgba(76, 201, 240, 0.35);
        }

        .stat-card:hover::before {
            width: 6px;
        }

        .stat-card-header {
            padding: 1rem 1rem 0;
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.22);
            flex: 0 0 auto;
        }

        .stat-icon-warning {
            background: linear-gradient(145deg, #f39c12, #d97706);
        }

        .stat-icon-danger {
            background: linear-gradient(145deg, var(--danger), #b91c1c);
        }

        .stat-icon-success {
            background: linear-gradient(145deg, var(--success), #047857);
        }

        .stat-icon-info {
            background: linear-gradient(145deg, var(--info), #0f766e);
        }

        .stat-icon-primary {
            background: linear-gradient(145deg, var(--primary), #1d4ed8);
        }

        .stat-category {
            font-size: 0.76rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0;
            color: #64748b;
            margin: 0;
            overflow-wrap: anywhere;
        }

        .stat-value {
            font-size: clamp(1.12rem, 0.95rem + 0.8vw, 1.55rem);
            font-weight: 900;
            margin: 0.35rem 0 0;
            line-height: 1.08;
            background: linear-gradient(135deg, #111827, #334155);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            overflow-wrap: anywhere;
            word-break: break-word;
            max-width: 100%;
        }

        .stat-value.profit {
            background: linear-gradient(135deg, #15803d, #16a34a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-value.loss {
            background: linear-gradient(135deg, var(--danger), #991b1b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-card-body {
            padding: 0 1rem 1rem;
            flex: 1 1 auto;
            min-width: 0;
        }

        .stat-card-footer {
            padding: 0.85rem 1rem 1rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
            min-width: 0;
        }

        .stat-card-footer:empty {
            display: none;
        }

        .stat-card:nth-of-type(5n + 1)::before {
            background: var(--success);
        }

        .stat-card:nth-of-type(5n + 2)::before {
            background: var(--danger);
        }

        .stat-card:nth-of-type(5n + 3)::before {
            background: var(--warning);
        }

        .stat-card:nth-of-type(5n + 4)::before {
            background: var(--info);
        }

        .stat-card:nth-of-type(5n + 5)::before {
            background: var(--primary-light);
        }

        /* Game Card */
        .game-card {
            background: var(--dark-light);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            border: 1px solid var(--border-color);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .game-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--card-shadow-hover);
            border-color: rgba(76, 201, 240, 0.3);
        }

        .game-card-header {
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .game-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
            color: white;
            background: linear-gradient(145deg, var(--primary), var(--secondary));
        }

        .game-title {
            font-size: 0.95rem;
            font-weight: 700;
            margin: 0;
            color: var(--light);
        }

        .game-balance {
            font-size: clamp(1.08rem, 0.92rem + 0.8vw, 1.45rem);
            font-weight: 800;
            margin: 0.25rem 0 0;
            background: linear-gradient(135deg, #111827, #334155);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            overflow-wrap: anywhere;
            word-break: break-word;
            max-width: 100%;
        }

        .game-card-body {
            padding: 1rem;
            flex: 1;
        }

        .game-card-footer {
            padding: 0.85rem 1rem 1rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            text-decoration: none;
            line-height: 1;
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.75rem;
            border-radius: 8px;
        }

        .btn-primary {
            background: linear-gradient(145deg, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }

        .btn-success {
            background: linear-gradient(145deg, var(--success), #05b386);
            color: white;
            box-shadow: 0 4px 12px rgba(6, 214, 160, 0.3);
        }

        .btn-danger {
            background: linear-gradient(145deg, var(--danger), #d64161);
            color: white;
            box-shadow: 0 4px 12px rgba(239, 71, 111, 0.3);
        }

        .btn-warning {
            background: linear-gradient(145deg, #f39c12, #e67e22);
            color: white;
            box-shadow: 0 4px 12px rgba(243, 156, 18, 0.3);
        }

        .btn-info {
            background: linear-gradient(145deg, var(--info), #0a6e8a);
            color: white;
            box-shadow: 0 4px 12px rgba(17, 138, 178, 0.3);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--border-color);
            color: var(--light);
        }

        .btn-outline:hover {
            background: var(--dark-lighter);
            border-color: var(--primary);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        /* Chat Container */
        .chat-wrapper {
            background: var(--dark-light);
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid var(--border-color);
            height: 100%;
            min-height: 400px;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            background: linear-gradient(145deg, var(--primary), var(--primary-dark));
            padding: 1rem 1.5rem;
        }

        .chat-header h4 {
            color: white;
            margin: 0;
            font-size: 1.1rem;
            font-weight: 700;
        }

        .chat-search {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .chat-search input {
            width: 100%;
            padding: 0.8rem 1.2rem;
            border-radius: 12px;
            border: 2px solid var(--border-color);
            background: var(--dark-lighter);
            color: var(--light);
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .chat-search input:focus {
            outline: none;
            border-color: var(--primary);
            background: var(--dark-light);
        }

        .chat-list {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
            max-height: 350px;
        }

        .dashboard-feed-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 1.5rem;
            grid-column: 1 / -1;
        }

        .feed-empty {
            padding: 1rem;
            color: var(--text-muted);
            font-weight: 700;
        }

        .feed-meta {
            color: var(--text-muted);
            font-size: .75rem;
            margin-top: .35rem;
        }

        .chat-list::-webkit-scrollbar {
            width: 6px;
        }

        .chat-list::-webkit-scrollbar-track {
            background: var(--dark-lighter);
        }

        .chat-list::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }

        .chat-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem 1rem;
            border-radius: 16px;
            cursor: pointer;
            transition: var(--transition);
            margin-bottom: 0.5rem;
        }

        .chat-item:hover {
            background: var(--dark-lighter);
            transform: translateX(5px);
        }

        .chat-item.active {
            background: rgba(67, 97, 238, 0.15);
            border-left: 4px solid var(--primary);
        }

        .chat-avatar {
            position: relative;
            width: 48px;
            height: 48px;
        }

        .chat-avatar img {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
        }

        .online-badge {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid var(--dark-light);
        }

        .online-badge.online {
            background: var(--success);
        }

        .online-badge.offline {
            background: var(--danger);
        }

        .chat-info h5 {
            margin: 0 0 0.25rem;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--light);
        }

        .chat-info p {
            margin: 0;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* Modal Styles */
        .modern-modal .modal-content {
            background: var(--dark-light);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            box-shadow: var(--card-shadow-hover);
        }

        .modern-modal .modal-header {
            background: linear-gradient(145deg, var(--primary), var(--primary-dark));
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem;
            border-radius: 24px 24px 0 0;
        }

        .modern-modal .modal-title {
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .modern-modal .close {
            color: white;
            opacity: 0.8;
            transition: var(--transition);
        }

        .modern-modal .close:hover {
            opacity: 1;
            transform: rotate(90deg);
        }

        .modern-modal .modal-body {
            padding: 2rem;
            background: var(--dark-light);
        }

        .modern-modal .form-group {
            margin-bottom: 1.5rem;
        }

        .modern-modal .form-group label {
            color: var(--light);
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        .modern-modal .form-control {
            background: var(--dark-lighter);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            color: var(--light);
            padding: 0.75rem 1rem;
            width: 100%;
            transition: var(--transition);
        }

        .modern-modal .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .modern-modal .modal-footer {
            border-top: 1px solid var(--border-color);
            padding: 1.5rem;
            background: var(--dark-light);
            border-radius: 0 0 24px 24px;
        }

        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Inter', 'Open Sans', sans-serif;
            font-weight: 700;
            color: var(--light);
        }

        /* Responsive */
        @media (max-width: 1199px) {
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(min(100%, 210px), 1fr));
            }
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 1rem;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 0.75rem;
            }

            .stat-card {
                min-height: 132px;
            }

            .stat-card-header {
                padding: 0.75rem 0.75rem 0;
            }

            .stat-card-body {
                padding: 0 0.75rem 0.75rem;
            }

            .stat-card-footer {
                padding: 0.75rem;
            }

            .stat-icon {
                width: 36px;
                height: 36px;
                font-size: 20px;
            }

            .stat-category {
                font-size: 0.68rem;
            }
            
            .stat-value {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 420px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .stat-value {
                font-size: 1.65rem;
            }
        }

        /* Smart light dashboard skin */
        body {
            background: #f3f4f6 !important;
            color: #111827;
            font-size: 12px;
        }

        .dashboard-container {
            max-width: 100%;
            padding: 1rem 1.25rem 1.5rem;
            background: #f3f4f6;
        }

        .dashboard-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
            padding: 1rem;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.05);
        }

        .dashboard-title {
            margin: 0;
            color: #111827;
            font-size: 1.05rem;
            font-weight: 800;
            letter-spacing: 0;
        }

        .dashboard-subtitle {
            margin: .2rem 0 0;
            color: #6b7280;
            font-size: .78rem;
            font-weight: 600;
        }

        .dashboard-status {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            min-height: 30px;
            padding: .35rem .65rem;
            border: 1px solid #bbf7d0;
            border-radius: 999px;
            background: #f0fdf4;
            color: #166534;
            font-size: .72rem;
            font-weight: 800;
            white-space: nowrap;
        }

        .dashboard-status::before {
            content: '';
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #16a34a;
        }

        .action-bar {
            gap: .55rem;
            margin-bottom: 1rem;
            padding: 0;
        }

        .action-btn,
        .version-badge,
        .btn {
            min-height: 32px;
            border-radius: 6px;
            box-shadow: none;
            letter-spacing: 0;
            font-size: .76rem;
            font-weight: 800;
        }

        .action-btn {
            padding: .48rem .72rem;
            border: 1px solid transparent;
        }

        .action-btn-warning,
        .action-btn-info,
        .action-btn-success,
        .btn-primary,
        .btn-success,
        .btn-danger,
        .btn-warning,
        .btn-info {
            background-image: none;
        }

        .action-btn-warning,
        .btn-warning {
            background: #f59e0b;
            color: #ffffff;
        }

        .action-btn-info,
        .btn-info,
        .btn-primary {
            background: #2563eb;
            color: #ffffff;
        }

        .action-btn-success,
        .btn-success {
            background: #16a34a;
            color: #ffffff;
        }

        .btn-danger {
            background: #dc2626;
            color: #ffffff;
        }

        .btn-outline {
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #374151;
        }

        .action-btn:hover,
        .btn:hover {
            transform: none;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.14);
            filter: brightness(.97);
        }

        .version-badge {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            padding: .46rem .72rem;
            border: 1px solid #dbeafe;
            border-left: 3px solid #2563eb;
            background: #eff6ff;
            color: #1e40af;
        }

        .ops-strip {
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: .75rem;
            margin-bottom: .85rem;
        }

        .ops-pill,
        .stat-card,
        .game-card,
        .chat-wrapper {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.05);
        }

        .ops-pill {
            min-height: 74px;
            padding: .85rem;
        }

        .ops-pill small,
        .formula-line,
        .stat-category {
            color: #6b7280;
            font-size: .68rem;
            line-height: 1.25;
            font-weight: 800;
            text-transform: uppercase;
        }

        .ops-pill strong,
        .stat-value,
        .game-balance {
            color: #111827;
            background: none;
            -webkit-text-fill-color: currentColor;
            font-variant-numeric: tabular-nums;
            font-feature-settings: "tnum" 1, "lnum" 1;
            letter-spacing: 0;
        }

        .ops-pill strong {
            display: block;
            margin-top: .2rem;
            font-size: 1.15rem;
            line-height: 1.05;
            overflow-wrap: anywhere;
        }

        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 198px), 1fr));
            gap: .75rem;
            margin-bottom: 1rem;
            align-items: start;
        }

        .stat-card,
        .game-card {
            min-height: 112px;
            height: auto;
            align-self: start;
            overflow: hidden;
            isolation: auto;
        }

        .stat-card::before,
        .stat-card::after {
            display: none;
        }

        .stat-card:hover,
        .game-card:hover {
            transform: none;
            border-color: #cbd5e1;
            box-shadow: 0 3px 10px rgba(15, 23, 42, 0.08);
        }

        .stat-card-header {
            justify-content: flex-start;
            padding: .75rem .8rem 0;
        }

        .stat-icon,
        .game-icon {
            width: 32px;
            height: 32px;
            border-radius: 7px;
            font-size: 17px;
            box-shadow: none;
            background-image: none;
        }

        .stat-icon-warning,
        .game-icon {
            background: #fef3c7;
            color: #b45309;
        }

        .stat-icon-danger {
            background: #fee2e2;
            color: #b91c1c;
        }

        .stat-icon-success {
            background: #dcfce7;
            color: #15803d;
        }

        .stat-icon-info {
            background: #cffafe;
            color: #0e7490;
        }

        .stat-icon-primary {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .stat-card-body,
        .game-card-body {
            padding: .55rem .8rem .75rem;
        }

        .stat-value {
            margin-top: .28rem;
            font-size: clamp(1.05rem, .9rem + .55vw, 1.36rem);
            line-height: 1.12;
            font-weight: 900;
        }

        .stat-value.profit {
            color: #15803d;
        }

        .stat-value.loss {
            color: #dc2626;
        }

        .stat-card-footer,
        .game-card-footer {
            padding: .55rem .8rem .65rem;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
        }

        .stat-card-footer:empty,
        .game-card-footer:empty {
            display: none;
        }

        .game-card-header {
            padding: .85rem;
            gap: .65rem;
            background: #ffffff;
        }

        .game-title {
            color: #111827;
            font-size: .8rem;
            font-weight: 800;
        }

        .game-balance {
            margin-top: .18rem;
            font-size: clamp(1.02rem, .88rem + .55vw, 1.3rem);
            line-height: 1.12;
            font-weight: 900;
        }

        .game-pro-card {
            grid-column: span 1;
            min-height: 0;
            max-width: 100%;
        }

        .game-pro-card .game-card-header {
            align-items: flex-start;
            padding: .75rem .8rem .6rem;
            border-bottom: 1px solid #eef2f7;
        }

        .game-pro-main {
            min-width: 0;
            flex: 1 1 auto;
        }

        .game-pro-title-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .55rem;
            margin-bottom: .12rem;
        }

        .game-pro-kicker {
            margin: 0;
            color: #6b7280;
            font-size: .64rem;
            font-weight: 900;
            letter-spacing: .02em;
            text-transform: uppercase;
        }

        .game-pro-balance {
            margin: .02rem 0 .2rem;
            color: #111827;
            font-size: clamp(1.12rem, 1rem + .38vw, 1.38rem);
            font-weight: 900;
            line-height: 1;
            font-variant-numeric: tabular-nums;
            overflow-wrap: anywhere;
        }

        .game-pro-summary {
            display: flex;
            flex-wrap: wrap;
            gap: .3rem .6rem;
            color: #6b7280;
            font-size: .66rem;
            font-weight: 800;
            line-height: 1.15;
            text-transform: uppercase;
        }

        .game-pro-body {
            padding: .6rem .8rem .65rem;
        }

        .game-pro-ledger {
            display: flex;
            flex-direction: column;
            gap: .35rem;
            margin-bottom: .55rem;
        }

        .game-pro-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .55rem;
            padding: .43rem .55rem;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            background: #f9fafb;
        }

        .game-pro-label {
            margin: 0;
            color: #6b7280;
            font-size: .65rem;
            font-weight: 900;
            line-height: 1.15;
            text-transform: uppercase;
        }

        .game-pro-amount {
            margin: 0;
            color: #111827;
            font-size: clamp(.9rem, .82rem + .25vw, 1.06rem);
            font-weight: 900;
            line-height: 1;
            text-align: right;
            font-variant-numeric: tabular-nums;
            overflow-wrap: anywhere;
        }

        .game-pro-actions {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: .4rem;
        }

        .game-pro-actions .btn {
            width: 100%;
        }

        .game-pro-card .game-card-footer {
            padding: .42rem .8rem .52rem;
            color: #6b7280;
            font-size: .62rem;
        }

        .game-pro-metric-card .stat-card-footer {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            min-height: 44px;
        }

        .game-pro-metric-card .stat-card-footer:empty {
            display: none;
        }

        .game-pro-metric-card .btn {
            width: 100%;
        }

        .dashboard-row-break {
            grid-column: 1 / -1;
            width: 100%;
            height: 0;
            min-height: 0;
            padding: 0;
            margin: 0;
            border: 0;
            overflow: hidden;
        }

        .btn {
            padding: .46rem .68rem;
            border-radius: 6px;
        }

        .btn-sm {
            min-height: 28px;
            padding: .35rem .55rem;
            font-size: .7rem;
            border-radius: 6px;
        }

        .dashboard-feed-grid {
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 310px), 1fr));
            gap: .75rem;
        }

        .chat-wrapper {
            min-height: 340px;
        }

        .chat-header {
            padding: .8rem 1rem;
            background: #111827;
            border-bottom: 1px solid #e5e7eb;
        }

        .chat-header h4 {
            font-size: .88rem;
            font-weight: 800;
        }

        .chat-search {
            padding: .75rem 1rem;
        }

        .chat-search input,
        .modern-modal .form-control {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background: #ffffff;
            color: #111827;
            font-size: .78rem;
        }

        .modern-modal .modal-content {
            border-radius: 8px;
            background: #ffffff;
        }

        .modern-modal .modal-header {
            border-radius: 8px 8px 0 0;
            background: #111827;
            padding: 1rem;
        }

        .modern-modal .modal-body,
        .modern-modal .modal-footer {
            background: #ffffff;
            padding: 1rem;
        }

        .modern-modal .modal-footer {
            border-radius: 0 0 8px 8px;
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: .75rem;
            }

            .dashboard-head {
                align-items: flex-start;
                flex-direction: column;
                padding: .85rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: .6rem;
            }

            .stat-value,
            .game-balance {
                font-size: 1.08rem;
            }

            .game-pro-metric-card .stat-card-footer {
                min-height: 40px;
            }

            .dashboard-row-break {
                display: none;
            }
        }

        @media (max-width: 460px) {
            .stats-grid,
            .ops-strip {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="dashboard-container">
        <div class="dashboard-head">
            <div>
                <h2 class="dashboard-title">Operations Dashboard</h2>
                <p class="dashboard-subtitle">Live balances, game controls, comments, and chat</p>
            </div>
            <div class="dashboard-status" @if($setting->maintenance_mode ?? false) style="background:#dc2626;" @endif>
                {{ ($setting->maintenance_mode ?? false) ? 'Maintenance' : 'Live' }}
            </div>
        </div>

        <!-- Action Bar -->
        <div class="action-bar">
            @if($adminCan('dashboard_vip_offer'))
                @if($setting->vip_discount == 0)
                    <a href="{{ URL::to('/vip_offer') }}" class="action-btn action-btn-warning">
                        <i class="typcn typcn-gift"></i>
                        <span>VIP Offer Inactive</span>
                    </a>
                @else
                    <a href="{{ URL::to('/vip_offer') }}" class="action-btn action-btn-info">
                        <i class="typcn typcn-star"></i>
                        <span>VIP 50% Offer Active</span>
                    </a>
                @endif
            @endif

            @if($adminCan('dashboard_version_update'))
                @if($setting->flutter_version == 85)
                    <a href="{{ URL::to('/version_update') }}" class="action-btn action-btn-success">
                        <i class="typcn typcn-arrow-up"></i>
                        <span>Release New Android Update</span>
                    </a>
                @else
                    <span class="version-badge">
                        <i class="typcn typcn-phone mr-2"></i>
                        App Version: {{ $setting->flutter_version }} Running
                    </span>
                @endif
               
            @endif

            @if(auth()->id() == 11133)
                <form action="{{ route('admin.maintenance.toggle') }}" method="POST" style="display:inline;"
                      onsubmit="return confirm('{{ $setting->maintenance_mode ?? false ? 'Turn maintenance mode OFF? The app and admin logins will work normally again.' : 'Turn maintenance mode ON? This blocks EVERY app route immediately and blocks every other admin from logging in.' }}');">
                    @csrf
                    @if($setting->maintenance_mode ?? false)
                        <button type="submit" class="action-btn action-btn-danger">
                            <i class="typcn typcn-warning"></i>
                            <span>Maintenance Mode: ON - Click to Restore</span>
                        </button>
                    @else
                        <button type="submit" class="action-btn action-btn-warning">
                            <i class="typcn typcn-power-outline"></i>
                            <span>Enable Maintenance Mode</span>
                        </button>
                    @endif
                </form>
            @endif
        </div>

        <div class="ops-strip">
            @if($adminCan('sidebar_coin_balance'))
            <div class="ops-pill">
                <div>
                    <small>Available Coins</small>
                    <strong>{{ $money($available_coin_balance ?? 0) }}</strong>
                </div>
                <i class="typcn typcn-flash" style="font-size:34px;color:#06d6a0;"></i>
            </div>
            @endif
            <div class="ops-pill">
                <div>
                    <small>Game Pro Calculation</small>
                    <strong>{{ $money($game_pro_value) }}</strong>
                    <div class="formula-line">Deposit - Withdraw</div>
                </div>
                <i class="typcn typcn-chart-line" style="font-size:34px;color:#ffd166;"></i>
            </div>
            <div class="ops-pill">
                <div>
                    <small>Comments Last Hour</small>
                    <strong>{{ $money($realtime_comment_count ?? 0) }}</strong>
                </div>
                <i class="typcn typcn-message" style="font-size:34px;color:#4cc9f0;"></i>
            </div>
            <div class="ops-pill">
                <div>
                    <small>Chats Last Hour</small>
                    <strong>{{ $money($realtime_chat_count ?? 0) }}</strong>
                </div>
                <i class="typcn typcn-message" style="font-size:34px;color:#ef476f;"></i>
            </div>
        </div>

        <!-- Statistics Grid -->
        <div class="stats-grid">
            <!-- Active Host -->
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon stat-icon-warning">
                        <i class="typcn typcn-download"></i>
                    </div>
                </div>
                <div class="stat-card-body">
                    <p class="stat-category">Active Host</p>
                    <h3 class="stat-value">{{ $money($active_host) }}</h3>
                </div>
                <div class="stat-card-footer"></div>
            </div>

            <!-- Today User -->
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon stat-icon-danger">
                        <i class="typcn typcn-user"></i>
                    </div>
                </div>
                <div class="stat-card-body">
                    <p class="stat-category">Today User</p>
                    <h3 class="stat-value">{{ $money($today_user) }}</h3>
                </div>
                <div class="stat-card-footer"></div>
            </div>

            <!-- Today Recharge -->
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon stat-icon-danger">
                        <i class="typcn typcn-credit-card"></i>
                    </div>
                </div>
                <div class="stat-card-body">
                    <p class="stat-category">Today Recharge</p>
                    <h3 class="stat-value">{{ $money($today_portal_transfer) }}</h3>
                </div>
                <div class="stat-card-footer"></div>
            </div>

            <!-- Total User -->
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon stat-icon-danger">
                        <i class="typcn typcn-group"></i>
                    </div>
                </div>
                <div class="stat-card-body">
                    <p class="stat-category">Total User</p>
                    <h3 class="stat-value">{{ $money($total_users) }}</h3>
                </div>
                <div class="stat-card-footer"></div>
            </div>

            <!-- Today Sending -->
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon stat-icon-danger">
                        <i class="typcn typcn-arrow-up"></i>
                    </div>
                </div>
                <div class="stat-card-body">
                    <p class="stat-category">Today Sending</p>
                    <h3 class="stat-value">{{ $money($today_sanding) }}</h3>
                </div>
                <div class="stat-card-footer"></div>
            </div>

            <!-- Today Receiving -->
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon stat-icon-danger">
                        <i class="typcn typcn-arrow-down"></i>
                    </div>
                </div>
                <div class="stat-card-body">
                    <p class="stat-category">Today Receiving</p>
                    <h3 class="stat-value">{{ $money($today_reciving) }}</h3>
                </div>
                <div class="stat-card-footer"></div>
            </div>

            <!-- Total Agency -->
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon stat-icon-danger">
                        <i class="typcn typcn-briefcase"></i>
                    </div>
                </div>
                <div class="stat-card-body">
                    <p class="stat-category">Total Agency</p>
                    <h3 class="stat-value">{{ $money($total_agency) }}</h3>
                </div>
                <div class="stat-card-footer"></div>
            </div>

            @if(Auth::id() != 1)
                @if($adminCan('dashboard_country_game_balance_cards'))
                    <!-- Fruits Balance -->
                    <div class="stat-card">
                        <div class="stat-card-header">
                            <div class="stat-icon stat-icon-warning">
                                <i class="typcn typcn-leaf"></i>
                            </div>
                        </div>
                        <div class="stat-card-body">
                            <p class="stat-category">Fruits Balance</p>
                            <h3 class="stat-value">{{ $money($fruts_game_balance->game_balance + $fruts_game_balance->second_balance + $fruts_game_balance->third_balance) }}</h3>
                        </div>
                        <div class="stat-card-footer">
                            @if($fruts_game_balance->game_status == 1)
                                <a href="{{ URL::to('admin/fruits_game_off') }}" class="btn btn-sm btn-danger">
                                    <i class="typcn typcn-power"></i> Game Off
                                </a>
                            @else
                                <a href="{{ URL::to('admin/fruits_game_on') }}" class="btn btn-sm btn-success">
                                    <i class="typcn typcn-power"></i> Game On
                                </a>
                            @endif
                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#fruitsexampleModal3commision">
                                <i class="typcn typcn-chart"></i> Commission %
                            </button>
                        </div>
                    </div>

                    <!-- Greedy Balance -->
                    <div class="stat-card">
                        <div class="stat-card-header">
                            <div class="stat-icon stat-icon-warning">
                                <i class="typcn typcn-cog"></i>
                            </div>
                        </div>
                        <div class="stat-card-body">
                            <p class="stat-category">Greedy Balance</p>
                            <h3 class="stat-value">{{ $money($greedy_game_balance->game_balance + $greedy_game_balance->second_balance) }}</h3>
                        </div>
                        <div class="stat-card-footer">
                            @if($greedy_game_balance->game_status == 1)
                                <a href="{{ URL::to('admin/grady_game_off') }}" class="btn btn-sm btn-danger">
                                    <i class="typcn typcn-power"></i> Game Off
                                </a>
                            @else
                                <a href="{{ URL::to('admin/grady_game_on') }}" class="btn btn-sm btn-success">
                                    <i class="typcn typcn-power"></i> Game On
                                </a>
                            @endif
                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#greddyexampleModal3commision">
                                <i class="typcn typcn-chart"></i> Commission %
                            </button>
                        </div>
                    </div>

                    <!-- Teen Patti Balance -->
                    <div class="stat-card">
                        <div class="stat-card-header">
                            <div class="stat-icon stat-icon-warning">
                                <i class="typcn typcn-spade"></i>
                            </div>
                        </div>
                        <div class="stat-card-body">
                            <p class="stat-category">Teen Patti Balance</p>
                            <h3 class="stat-value">{{ $money($teenpatti_game_balance->game_balance + $teenpatti_game_balance->second_balance + $teenpatti_game_balance->third_balance) }}</h3>
                        </div>
                        <div class="stat-card-footer">
                            @if($teenpatti_game_balance->game_status == 1)
                                <a href="{{ URL::to('admin/teen-patti_game_off') }}" class="btn btn-sm btn-danger">
                                    <i class="typcn typcn-power"></i> Game Off
                                </a>
                            @else
                                <a href="{{ URL::to('admin/teen-patti_game_on') }}" class="btn btn-sm btn-success">
                                    <i class="typcn typcn-power"></i> Game On
                                </a>
                            @endif
                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#teenpattiexampleModal3commision">
                                <i class="typcn typcn-chart"></i> Commission %
                            </button>
                        </div>
                    </div>

                    <!-- Profit/Loss -->
                    <div class="stat-card">
                        <div class="stat-card-header">
                            <div class="stat-icon stat-icon-danger">
                                <i class="typcn typcn-chart-line"></i>
                            </div>
                        </div>
                        <div class="stat-card-body">
                            <p class="stat-category">{{ $loss_profit > 0 ? 'Profit' : 'Loss' }}</p>
                            <h3 class="stat-value {{ $loss_profit > 0 ? 'profit' : 'loss' }}">{{ $money($loss_profit) }}</h3>
                            <div class="formula-line">{{ $profit_formula }}</div>
                        </div>
                        <div class="stat-card-footer"></div>
                    </div>

                    <!-- Entry Frame Profit -->
                    <div class="stat-card">
                        <div class="stat-card-header">
                            <div class="stat-icon stat-icon-warning">
                                <i class="typcn typcn-chart-bar"></i>
                            </div>
                        </div>
                        <div class="stat-card-body">
                            <p class="stat-category">Entry Frame Profit</p>
                            <h3 class="stat-value">{{ $money($EntryFrameProfit) }}</h3>
                        </div>
                        <div class="stat-card-footer"></div>
                    </div>
                @endif

                @if($adminCan('dashboard_profit_loss'))
                  <div class="stat-card">
                        <div class="stat-card-header">
                            <div class="stat-icon stat-icon-danger">
                                <i class="typcn typcn-chart-line"></i>
                            </div>
                        </div>
                        <div class="stat-card-body">
                            <p class="stat-category">{{ $loss_profit > 0 ? 'Profit' : 'Loss' }}</p>
                            <h3 class="stat-value {{ $loss_profit > 0 ? 'profit' : 'loss' }}">{{ $money($loss_profit) }}</h3>
                            <div class="formula-line">{{ $profit_formula }}</div>
                        </div>
                        <div class="stat-card-footer"></div>
                    </div>
                @endif

                <!-- Total Wallet -->
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon stat-icon-danger">
                            <i class="typcn typcn-wallet"></i>
                        </div>
                    </div>
                    <div class="stat-card-body">
                        <p class="stat-category">Total Wallet</p>
                        <h3 class="stat-value">{{ $money($users_balance) }}</h3>
                    </div>
                    <div class="stat-card-footer"></div>
                </div>

                <!-- Total Portal Balance -->
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon stat-icon-danger">
                            <i class="typcn typcn-briefcase"></i>
                        </div>
                    </div>
                    <div class="stat-card-body">
                        <p class="stat-category">Total Portal Balance</p>
                        <h3 class="stat-value">{{ $money($total_portal_recharge - ($total_portal_transfer + $total_portal_recall)) }}</h3>
                    </div>
                    <div class="stat-card-footer"></div>
                </div>

                <!-- Portal Sand -->
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon stat-icon-danger">
                            <i class="typcn typcn-cloud-storage"></i>
                        </div>
                    </div>
                    <div class="stat-card-body">
                        <p class="stat-category">Portal Sand</p>
                        <h3 class="stat-value">{{ $money($protal_sand) }}</h3>
                    </div>
                    <div class="stat-card-footer"></div>
                </div>

                @if($adminCan('dashboard_total_serve_coin'))
                    <!-- Total Serve Coin -->
                    <div class="stat-card">
                        <div class="stat-card-header">
                            <div class="stat-icon stat-icon-primary">
                                <i class="typcn typcn-credit-card"></i>
                            </div>
                        </div>
                        <div class="stat-card-body">
                            <p class="stat-category">Total Serve Coin</p>
                            <h3 class="stat-value">{{ $money($total_serve) }}</h3>
                        </div>
                        <div class="stat-card-footer"></div>
                    </div>
                @endif

                <!-- Total Receiving -->
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon stat-icon-success">
                            <i class="typcn typcn-gift"></i>
                        </div>
                    </div>
                    <div class="stat-card-body">
                        <p class="stat-category">Total Receiving</p>
                        <h3 class="stat-value">{{ $money($total_gift) }}</h3>
                    </div>
                    <div class="stat-card-footer"></div>
                </div>

                @if($adminCan('dashboard_game_pro_balance'))
                    <div class="stat-card game-pro-metric-card">
                        <div class="stat-card-header">
                            <div class="stat-icon stat-icon-warning">
                                <i class="typcn typcn-flash"></i>
                            </div>
                        </div>
                        <div class="stat-card-body">
                            <p class="stat-category">Game Pro Balance</p>
                            <h3 class="stat-value">{{ $money($game_pro_balance['balance'] ?? 0) }}</h3>
                        </div>
                        <div class="stat-card-footer"></div>
                    </div>

                    @if($adminCan('dashboard_game_pro_balance_manage'))
                    <div class="stat-card game-pro-metric-card">
                        <div class="stat-card-header">
                            <div class="stat-icon stat-icon-success">
                                <i class="typcn typcn-plus"></i>
                            </div>
                        </div>
                        <div class="stat-card-body">
                            <p class="stat-category">Game Pro Deposit</p>
                            <h3 class="stat-value">{{ $money($game_pro_balance['deposit_total'] ?? 0) }}</h3>
                        </div>
                        <div class="stat-card-footer">
                            @if(!empty($game_pro_balance['available']))
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#gameProDepositModal">
                                    <i class="typcn typcn-plus"></i> Deposit
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="stat-card game-pro-metric-card">
                        <div class="stat-card-header">
                            <div class="stat-icon stat-icon-danger">
                                <i class="typcn typcn-minus"></i>
                            </div>
                        </div>
                        <div class="stat-card-body">
                            <p class="stat-category">Game Pro Withdraw</p>
                            <h3 class="stat-value">{{ $money($game_pro_balance['withdraw_total'] ?? 0) }}</h3>
                        </div>
                        <div class="stat-card-footer">
                            @if(!empty($game_pro_balance['available']))
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#gameProWithdrawModal">
                                    <i class="typcn typcn-minus"></i> Withdraw
                                </button>
                            @endif
                        </div>
                    </div>
                    @endif
                @endif

                @if($adminCan('dashboard_coin_generate_game'))
                    <!-- Coin Generate -->
                    <div class="dashboard-row-break" aria-hidden="true"></div>
                    <div class="stat-card">
                        <div class="stat-card-header">
                            <div class="stat-icon stat-icon-info">
                                <i class="typcn typcn-chart-line"></i>
                            </div>
                        </div>
                        <div class="stat-card-body">
                            <p class="stat-category">Coin Generate</p>
                        <h3 class="stat-value">{{ $money(($total_portal_recharge - ($total_portal_transfer + $total_portal_recall)) + $protal_sand) }}</h3>
                        </div>
                        <div class="stat-card-footer"></div>
                    </div>
                @endif

                @if($dashboardCan('dashboard_game_data'))
                    <!-- Game Management Cards -->
                    <div class="game-card">
                        <div class="game-card-header">
                            <div class="game-icon">
                                <i class="typcn typcn-leaf"></i>
                            </div>
                            <div>
                                <h5 class="game-title">Fruits Balance</h5>
                                <h3 class="game-balance">{{ $money($fruts_game_balance->game_balance + $fruts_game_balance->second_balance + $fruts_game_balance->third_balance) }}</h3>
                            </div>
                        </div>
                        <div class="game-card-body">
                            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal">
                                    <i class="typcn typcn-cog"></i> Adjust
                                </button>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#exampleModal2">
                                    <i class="typcn typcn-chart"></i> 2nd
                                </button>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal3">
                                    <i class="typcn typcn-chart"></i> 3rd
                                </button>
                            </div>
                        </div>
                        <div class="game-card-footer">
                            <button type="button" class="btn btn-outline btn-sm" data-toggle="modal" data-target="#fruitsexampleModal3commision">
                                <i class="typcn typcn-chart"></i> Commission %
                            </button>
                        </div>
                    </div>

                    <div class="game-card">
                        <div class="game-card-header">
                            <div class="game-icon">
                                <i class="typcn typcn-cog"></i>
                            </div>
                            <div>
                                <h5 class="game-title">Greedy Balance</h5>
                                <h3 class="game-balance">{{ $money($greedy_game_balance->game_balance + $greedy_game_balance->second_balance) }}</h3>
                            </div>
                        </div>
                        <div class="game-card-body">
                            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#greedymodel">
                                    <i class="typcn typcn-cog"></i> Adjust
                                </button>
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#greedy2ndmodel">
                                    <i class="typcn typcn-chart"></i> 2nd
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#greedy3ndmodel">
                                    <i class="typcn typcn-chart"></i> 3rd
                                </button>
                            </div>
                        </div>
                        <div class="game-card-footer">
                            <button type="button" class="btn btn-outline btn-sm" data-toggle="modal" data-target="#greddyexampleModal3commision">
                                <i class="typcn typcn-chart"></i> Commission %
                            </button>
                        </div>
                    </div>

                    <div class="game-card">
                        <div class="game-card-header">
                            <div class="game-icon">
                                <i class="typcn typcn-spade"></i>
                            </div>
                            <div>
                                <h5 class="game-title">Teen Patti Balance</h5>
                                <h3 class="game-balance">{{ $money($teenpatti_game_balance->game_balance + $teenpatti_game_balance->second_balance + $teenpatti_game_balance->third_balance) }}</h3>
                            </div>
                        </div>
                        <div class="game-card-body">
                            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#teenpatti">
                                    <i class="typcn typcn-cog"></i> Adjust
                                </button>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#teenpatti2ndmodel">
                                    <i class="typcn typcn-chart"></i> 2nd
                                </button>
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#teenpatti3ndmodel">
                                    <i class="typcn typcn-chart"></i> 3rd
                                </button>
                            </div>
                        </div>
                        <div class="game-card-footer">
                            <button type="button" class="btn btn-outline btn-sm" data-toggle="modal" data-target="#teenpattiexampleModal3commision">
                                <i class="typcn typcn-chart"></i> Commission %
                            </button>
                        </div>
                    </div>

                    <div class="game-card">
                        <div class="game-card-header">
                            <div class="game-icon">
                                <i class="typcn typcn-star"></i>
                            </div>
                            <div>
                                <h5 class="game-title">Five Star Balance</h5>
                                <h3 class="game-balance">{{ $money($five_game_balance->game_balance) }}</h3>
                            </div>
                        </div>
                        <div class="game-card-body">
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#fivestar">
                                <i class="typcn typcn-cog"></i> Adjust Game
                            </button>
                        </div>
                        <div class="game-card-footer"></div>
                    </div>
                @endif

                @if($dashboardCan('dashboard_realtime_feeds'))
                    <div class="dashboard-feed-grid">
                        <div class="chat-wrapper">
                            <div class="chat-header">
                                <h4><i class="typcn typcn-message mr-2"></i> Live Comments</h4>
                            </div>
                            <div class="chat-search">
                                <input type="text" placeholder="Search comments..." id="searchComment">
                            </div>
                            <div class="chat-list" id="comment_list"><div class="feed-empty">Loading comments...</div></div>
                        </div>

                        <div class="chat-wrapper">
                            <div class="chat-header">
                                <h4><i class="typcn typcn-chat mr-2"></i> Private Chat</h4>
                            </div>
                            <div class="chat-search">
                                <input type="text" placeholder="Search chats..." id="searchChat">
                            </div>
                            <div class="chat-list" id="chat_list"><div class="feed-empty">Loading chats...</div></div>
                        </div>
                    </div>
                @endif
            @endif
        </div>

        @if($adminCan('dashboard_game_pro_balance_manage'))
            <div class="modal fade modern-modal" id="gameProDepositModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form class="modal-content" action="{{URL::to('game-pro-balance-update')}}" method="post">
                        @csrf
                        <input type="hidden" name="type" value="deposit">
                        <div class="modal-header">
                            <h5 class="modal-title">Game Pro Deposit</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="number" name="amount" class="form-control" min="1" step="1" inputmode="numeric" pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                            </div>
                            <small>Powered by JAMBOai</small>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save Deposit</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal fade modern-modal" id="gameProWithdrawModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form class="modal-content" action="{{URL::to('game-pro-balance-update')}}" method="post">
                        @csrf
                        <input type="hidden" name="type" value="withdraw">
                        <div class="modal-header">
                            <h5 class="modal-title">Game Pro Withdraw</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="number" name="amount" class="form-control" min="1" step="1" inputmode="numeric" pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'')" max="{{ (int) ($game_pro_balance['balance'] ?? 0) }}" required>
                            </div>
                            <small>Powered by JAMBOai</small>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Save Withdraw</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- Modals - Keeping all original modals with updated styling -->
        @include('backend.partials.dashboard.modals', [
            'teenpattifortunesetting' => $teenpattifortunesetting ?? null,
            'fruitsfortunesetting' => $fruitsfortunesetting ?? null,
            'fortunesetting' => $fortunesetting ?? null
        ])
    </div>
@endif
@endsection

@section('script')
<script>
$(function () {
    function filterFeed(input, list) {
        var value = ($(input).val() || '').toLowerCase();
        $(list).find('[data-feed-item]').each(function () {
            var text = ($(this).data('search') || $(this).text()).toString().toLowerCase();
            $(this).toggle(text.indexOf(value) !== -1);
        });
    }

    function loadFeed(url, target, emptyText) {
        if (!$(target).length) {
            return;
        }
        $.get(url)
            .done(function (html) {
                $(target).html($.trim(html) ? html : '<div class="feed-empty">' + emptyText + '</div>');
            })
            .fail(function () {
                $(target).html('<div class="feed-empty">Feed unavailable</div>');
            });
    }

    function refreshDashboardFeeds() {
        if ($('#comment_list').length) {
            loadFeed("{{ route('comment.data') }}", '#comment_list', 'No recent comments');
        }
        if ($('#chat_list').length) {
            loadFeed("{{ route('chat.data') }}", '#chat_list', 'No recent chats');
        }
    }

    $('#searchComment').on('input', function () { filterFeed(this, '#comment_list'); });
    $('#searchChat').on('input', function () { filterFeed(this, '#chat_list'); });
    refreshDashboardFeeds();
    setInterval(refreshDashboardFeeds, 5000);
});
</script>
@endsection
