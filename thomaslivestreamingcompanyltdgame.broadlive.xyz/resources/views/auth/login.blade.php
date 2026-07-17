<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Thomas Admin</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('public/author/assets/img/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg: #070b12;
            --panel: rgba(14, 22, 34, .82);
            --panel-strong: rgba(20, 31, 47, .95);
            --line: rgba(150, 180, 220, .2);
            --text: #eef5ff;
            --muted: #90a3bd;
            --accent: #23d3a6;
            --accent-2: #f4c542;
            --danger: #ff5570;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 20% 18%, rgba(35, 211, 166, .22), transparent 34%),
                radial-gradient(circle at 78% 80%, rgba(244, 197, 66, .16), transparent 30%),
                linear-gradient(135deg, #070b12 0%, #111827 55%, #07131f 100%);
            display: grid;
            place-items: center;
            padding: 24px;
        }

        .admin-login {
            width: min(1020px, 100%);
            min-height: 600px;
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(320px, .95fr);
            border: 1px solid var(--line);
            background: linear-gradient(145deg, rgba(12, 18, 29, .92), rgba(10, 14, 22, .88));
            box-shadow: 0 32px 90px rgba(0, 0, 0, .55);
            overflow: hidden;
            border-radius: 20px;
        }

        .stage {
            position: relative;
            padding: 44px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background:
                linear-gradient(120deg, rgba(35, 211, 166, .1), transparent 42%),
                linear-gradient(0deg, rgba(0, 0, 0, .22), rgba(0, 0, 0, .05));
        }

        .stage-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.045) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.045) 1px, transparent 1px);
            background-size: 44px 44px;
            mask-image: linear-gradient(90deg, black, transparent 82%);
            pointer-events: none;
        }

        .brand, .status-line, .stage-copy { position: relative; z-index: 1; }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .brand-mark {
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            border: 1px solid rgba(35, 211, 166, .45);
            background: rgba(35, 211, 166, .12);
            border-radius: 8px;
            color: var(--accent);
        }

        .stage-copy h1 {
            margin: 0 0 18px;
            font-size: clamp(2.3rem, 5vw, 4.5rem);
            line-height: .92;
            letter-spacing: 0;
            max-width: 10ch;
        }

        .stage-copy p {
            width: min(520px, 100%);
            margin: 0;
            color: var(--muted);
            font-size: 1rem;
            line-height: 1.65;
        }

        .status-line {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .status-pill {
            border: 1px solid var(--line);
            background: rgba(255,255,255,.05);
            color: #c9d7ea;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: .78rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .panel {
            position: relative;
            padding: 40px;
            background: var(--panel);
            border-left: 1px solid var(--line);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .panel h2 {
            margin: 0 0 8px;
            font-size: 1.45rem;
            letter-spacing: 0;
        }

        .panel-subtitle {
            margin: 0 0 28px;
            color: var(--muted);
            line-height: 1.5;
            font-size: .92rem;
        }

        .field {
            margin-bottom: 16px;
        }

        .field label {
            display: block;
            margin-bottom: 8px;
            color: #c8d6e8;
            font-size: .78rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        .input-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            height: 52px;
            border: 1px solid rgba(144, 163, 189, .25);
            background: rgba(4, 8, 14, .72);
            border-radius: 8px;
            padding: 0 14px;
            transition: border-color .2s, box-shadow .2s;
            min-width: 0;
        }

        .input-wrap:focus-within {
            border-color: rgba(35, 211, 166, .72);
            box-shadow: 0 0 0 3px rgba(35, 211, 166, .14);
        }

        .input-wrap i { color: var(--accent); width: 18px; text-align: center; }

        input {
            width: 100%;
            border: 0;
            outline: 0;
            background: transparent;
            color: var(--text);
            font: 600 .98rem Inter, sans-serif;
        }

        input::placeholder { color: #5f7189; }

        .submit-btn {
            width: 100%;
            height: 54px;
            margin-top: 8px;
            border: 0;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--accent), #1aa6e8);
            color: #041014;
            font: 900 .92rem Inter, sans-serif;
            text-transform: uppercase;
            cursor: pointer;
            box-shadow: 0 16px 32px rgba(35, 211, 166, .22);
        }

        .alert {
            border-radius: 8px;
            padding: 13px 14px;
            margin-bottom: 18px;
            font-weight: 700;
            line-height: 1.45;
            font-size: .9rem;
        }

        .alert-danger {
            border: 1px solid rgba(255, 85, 112, .45);
            background: rgba(255, 85, 112, .13);
            color: #ffd5dc;
        }

        .alert-warning {
            border: 1px solid rgba(244, 197, 66, .42);
            background: rgba(244, 197, 66, .12);
            color: #ffe9a8;
        }

        .locked-box {
            border: 1px solid rgba(255, 85, 112, .38);
            background: linear-gradient(145deg, rgba(255, 85, 112, .16), rgba(20, 31, 47, .72));
            padding: 22px;
            border-radius: 8px;
        }

        .locked-box h3 {
            margin: 0 0 10px;
            color: #ffd5dc;
        }

        .locked-box p {
            margin: 0;
            color: #c9d7ea;
            line-height: 1.6;
        }

        .footnote {
            margin-top: 18px;
            color: #6f829e;
            font-size: .78rem;
            line-height: 1.5;
        }

        @media (max-width: 920px) {
            body { padding: 0; align-items: stretch; }
            .admin-login {
                min-height: 100vh;
                grid-template-columns: 1fr;
                border-radius: 0;
            }
            .stage { min-height: 280px; padding: 26px 22px 24px; }
            .panel { border-left: 0; border-top: 1px solid var(--line); padding: 26px 22px 28px; }
            .stage-copy h1 { max-width: 100%; font-size: clamp(2.1rem, 12vw, 3.5rem); }
            .stage-copy p { width: 100%; }
            .status-line { gap: 8px; }
            .status-pill { width: 100%; text-align: center; }
            .panel-subtitle { margin-bottom: 22px; }
            .submit-btn, .input-wrap { border-radius: 14px; }
        }
    </style>
</head>
<body>
    @php
        $locked = (bool) ($adminLoginLocked ?? false);
        $remaining = (int) ($adminLoginRemainingMinutes ?? 0);
    @endphp

    <main class="admin-login">
        <section class="stage" aria-label="Thomas admin access">
            <div class="stage-grid"></div>
            <div class="brand">
                <div class="brand-mark"><i class="fas fa-shield-halved"></i></div>
                <span>Thomas Admin</span>
            </div>
            <div class="stage-copy">
                <h1>Control Room</h1>
                <p>Private operator access for game balance, rounds, payouts, users, locks, maintenance, and realtime controls.</p>
            </div>
            <div class="status-line">
                <span class="status-pill">{{ $locked ? 'Locked for ' . max(1, $remaining) . ' min' : 'Admin email sign-in' }}</span>
                <span class="status-pill">Two attempt lock</span>
                <span class="status-pill">Auto unlock after 30 min</span>
            </div>
        </section>

        <section class="panel">
            <h2>Admin Sign In</h2>
            <p class="panel-subtitle">Use your admin email and password. Wrong login has one warning, then the panel locks for 30 minutes.</p>

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if (session('warning'))
                <div class="alert alert-warning">{{ session('warning') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            @if ($locked)
                <div class="locked-box">
                    <h3><i class="fas fa-lock"></i> Admin login locked</h3>
                    <p>Login is locked for {{ max(1, $remaining) }} minutes for this email and IP combination. After the lock window ends, the form opens again automatically.</p>
                </div>
            @else
                <form method="post" action="{{ route('thomas.admin.login.submit') }}" autocomplete="off" spellcheck="false">
                    @csrf
                    <div class="field">
                        <label for="email">Email</label>
                        <div class="input-wrap">
                            <i class="fas fa-envelope"></i>
                            <input id="email" name="email" type="email" inputmode="email" autocomplete="off" autocapitalize="none" value="{{ old('email', $adminLoginEmail ?? '') }}" placeholder="Admin email" required>
                        </div>
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <div class="input-wrap">
                            <i class="fas fa-key"></i>
                            <input id="password" name="password" type="password" autocomplete="new-password" value="" placeholder="Enter password" required>
                        </div>
                    </div>

                    <button class="submit-btn" type="submit">Open Admin Panel</button>
                </form>
            @endif

            <div class="footnote">Direct URL: /thomas-admin. This page uses email plus IP based lock protection and does not expose game access controls before admin verification.</div>
        </section>
    </main>
</body>
</html>
