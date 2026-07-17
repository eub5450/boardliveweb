<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Final Security</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#070a18;--card:#111936;--line:rgba(255,255,255,.12);--text:#f4f7ff;--muted:#9eadd7;--gold:#ffd86b;--pink:#ff4f9a;--cyan:#4de7ff;--green:#39e6a4;--red:#ff5c7a;--shadow:0 22px 60px rgba(0,0,0,.38);--font-title:'Space Grotesk',Inter,system-ui,sans-serif;--font-body:'Inter',system-ui,sans-serif}
        *{box-sizing:border-box}
        body{margin:0;min-height:100vh;font-family:var(--font-body);color:var(--text);background:radial-gradient(circle at 15% -5%,rgba(255,216,107,.18),transparent 34%),radial-gradient(circle at 85% 5%,rgba(77,231,255,.14),transparent 32%),radial-gradient(circle at 50% 95%,rgba(255,79,154,.11),transparent 35%),linear-gradient(180deg,#070a18,#0a1024 48%,#070a18)}
        body::before{content:"";position:fixed;inset:0;background-image:linear-gradient(rgba(255,255,255,.03) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.03) 1px,transparent 1px);background-size:42px 42px;mask-image:linear-gradient(to bottom,rgba(0,0,0,.82),transparent);pointer-events:none}
        .shell{width:min(1200px,100%);margin:0 auto;padding:24px 16px}
        .card{display:grid;grid-template-columns:minmax(0,1.05fr) minmax(320px,.95fr);gap:18px}
        .hero,.panel{position:relative;overflow:hidden;border:1px solid var(--line);border-radius:30px;background:linear-gradient(160deg,rgba(20,31,67,.92),rgba(12,17,38,.88));box-shadow:var(--shadow)}
        .hero{display:grid;grid-template-columns:minmax(0,1fr) 168px;gap:16px;align-items:start;padding:22px}
        .hero::after{content:'';position:absolute;inset:auto -70px -70px auto;width:180px;height:180px;border-radius:50%;background:radial-gradient(circle,rgba(255,216,107,.20),transparent 65%)}
        .hero-copy{position:relative;z-index:1}
        .eyebrow{display:inline-flex;align-items:center;gap:10px;padding:10px 14px;border-radius:999px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.08);font-size:12px;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:#ffd7bf}
        h1{margin:18px 0 10px;font-family:var(--font-title);font-size:clamp(2.3rem,4vw,3.4rem);line-height:1.02;letter-spacing:-.04em}
        p{margin:0;color:var(--muted);line-height:1.7}
        .hero-art{position:relative;z-index:1;width:100%;height:168px;object-fit:cover;border-radius:24px;border:1px solid var(--line);background:rgba(255,255,255,.06)}
        .stack{display:grid;gap:12px;margin-top:18px}
        .meta{padding:14px 16px;border-radius:18px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.08)}
        .meta b{display:block;margin-bottom:6px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:#ffd7bf}
        .panel{padding:24px}
        .panel h2{margin:0 0 8px;font-family:var(--font-title);font-size:28px;letter-spacing:-.03em}
        .panel p{margin-bottom:18px}
        .alert{margin-bottom:16px;padding:14px 16px;border-radius:16px;font-size:14px;line-height:1.6}
        .alert.error{background:rgba(255,92,122,.12);border:1px solid rgba(255,92,122,.24);color:#ffd5de}
        .alert.status{background:rgba(57,230,164,.12);border:1px solid rgba(57,230,164,.24);color:#d9fff2}
        label{display:block;margin-bottom:8px;font-size:12px;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:#c7d6ff}
        input{width:100%;min-height:52px;padding:0 16px;border-radius:16px;border:1px solid var(--line);background:rgba(4,8,22,.62);color:var(--text);font-size:16px;outline:none}
        input:focus{border-color:rgba(77,231,255,.7);box-shadow:0 0 0 4px rgba(77,231,255,.1)}
        .help{margin-top:10px;font-size:13px;color:var(--muted)}
        .error-text{margin-top:10px;color:#ffd5de;font-size:13px}
        .actions{display:flex;gap:12px;align-items:center;margin-top:24px;flex-wrap:wrap}
        .btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:46px;padding:0 18px;border:0;border-radius:15px;font-size:12px;font-weight:900;letter-spacing:.08em;text-transform:uppercase;cursor:pointer;text-decoration:none}
        .btn-primary{background:linear-gradient(135deg,var(--gold),#ffb44d);color:#271300;box-shadow:0 10px 24px rgba(255,174,76,.18)}
        .btn-secondary{background:rgba(255,255,255,.07);border:1px solid var(--line);color:var(--text)}
        @media (max-width:980px){
            .shell{padding:16px 12px}
            .card{grid-template-columns:1fr}
            .hero{grid-template-columns:1fr}
            .hero-art{display:none}
        }
        @media (max-width:720px){
            .hero,.panel{border-radius:24px}
            .hero{padding:18px}
            .panel{padding:20px}
            .actions .btn{width:100%}
        }
    </style>
</head>
<body data-admin-shell="1" data-admin-page="security">
    @php
        $adminThemeAsset = static fn (string $file): string => asset('game_final_admin_theme/assets/' . $file);
    @endphp
    <div class="shell">
        <div class="card">
            <section class="hero" data-tour-title="Security Overview" data-tour-body="Review the current admin session, lockout state, and unlock workflow before opening the control panel.">
                <div class="hero-copy">
                    <div class="eyebrow">Security Verification</div>
                    <h1>Unlock admin controls.</h1>
                    <p>Verify the security pass before changing lobby access, maintenance state, or realtime delivery settings.</p>
                    <div class="stack">
                        <div class="meta">
                            <b>Logged Admin</b>
                            <span>{{ $adminUser?->email ?? 'Authenticated admin session' }}</span>
                        </div>
                        <div class="meta">
                            <b>Security Mode</b>
                            <span>Session-based verification with expiry and lockout protection.</span>
                        </div>
                        <div class="meta">
                            <b>Lockout Window</b>
                            <span>{{ (int) $lockoutSeconds > 0 ? $lockoutSeconds . ' seconds remaining' : 'No active lockout' }}</span>
                        </div>
                    </div>
                </div>
                <img class="hero-art" src="{{ $adminThemeAsset('security-shield.png') }}" alt="Security shield">
            </section>

            <section class="panel" data-tour-title="Unlock Panel" data-tour-body="Use this form to unlock the admin panel for the current session without leaving the page.">
                <h2>Unlock Settings</h2>
                <p>Enter the current security pass to open the full control panel.</p>

                @if (session('error'))
                    <div class="alert error">{{ session('error') }}</div>
                @endif

                @if (session('status'))
                    <div class="alert status">{{ session('status') }}</div>
                @endif

                <form method="post" action="{{ route('admin.game-final.security.verify') }}">
                    @csrf
                    <label for="security_pass">Security Pass</label>
                    <input id="security_pass" name="security_pass" type="password" placeholder="Enter configured admin security secret" autocomplete="off" required data-tour-title="Security Pass Field" data-tour-body="Enter the configured passphrase here. Failed attempts can trigger a temporary lockout for this browser session.">
                    <div class="help">Failed attempts trigger a temporary lockout for this session.</div>
                    @error('security_pass')
                        <div class="error-text">{{ $message }}</div>
                    @enderror

                    <div class="actions">
                        <button class="btn btn-primary" type="submit" data-tour-title="Unlock Action" data-tour-body="Submit the current security pass to continue into the full admin controls.">Unlock Game Final</button>
                        <button class="btn btn-secondary" type="button" data-tour-start>Open Tour</button>
                        <a class="btn btn-secondary" href="{{ url('/play_bd_game') }}">Return To Lobby</a>
                    </div>
                </form>
            </section>
        </div>
    </div>
    <div class="toast-stack" data-toast-stack></div>
    <script src="{{ asset('game_final_admin_theme/admin-app.js') }}"></script>
    <script src="{{ asset('game_final_admin_theme/admin-panel.js') }}"></script>
</body>
</html>
