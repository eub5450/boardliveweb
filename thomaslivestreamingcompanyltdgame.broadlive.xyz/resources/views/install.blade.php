<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Play BD Game Installer</title>
    <style>
        :root {
            --bg: #101719;
            --panel: #f6f0e4;
            --ink: #17201f;
            --muted: #65706d;
            --accent: #d54b2a;
            --accent-dark: #9e3018;
            --line: #d9cfbd;
            --ok: #0f7a4f;
            --bad: #b3261e;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: Georgia, "Times New Roman", serif;
            color: var(--ink);
            background:
                linear-gradient(135deg, rgba(16,23,25,.86), rgba(16,23,25,.74)),
                repeating-linear-gradient(45deg, #162427 0 12px, #1d3031 12px 24px);
            display: grid;
            place-items: center;
            padding: 28px 14px;
        }
        main {
            width: min(760px, 100%);
            background: var(--panel);
            border: 1px solid rgba(255,255,255,.18);
            border-radius: 8px;
            box-shadow: 0 28px 80px rgba(0,0,0,.34);
            overflow: hidden;
        }
        header {
            padding: 28px;
            color: #fff9ec;
            background: linear-gradient(120deg, #183437, #832f20 58%, #d55b2e);
        }
        h1 {
            margin: 0;
            font-size: clamp(30px, 6vw, 54px);
            line-height: .95;
            letter-spacing: 0;
        }
        header p {
            max-width: 620px;
            margin: 14px 0 0;
            color: rgba(255,249,236,.82);
            font-size: 16px;
            line-height: 1.55;
        }
        form, .done {
            padding: 26px 28px 30px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }
        label {
            display: grid;
            gap: 7px;
            font-size: 14px;
            font-weight: 700;
        }
        input {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 6px;
            padding: 12px 13px;
            color: var(--ink);
            background: #fffaf0;
            font: 16px system-ui, sans-serif;
            outline: none;
        }
        input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(213,75,42,.18);
        }
        .full { grid-column: 1 / -1; }
        .error {
            margin-bottom: 16px;
            padding: 13px 14px;
            border-radius: 6px;
            color: #fff;
            background: var(--bad);
            font: 14px system-ui, sans-serif;
        }
        .hint {
            margin: 18px 0 0;
            color: var(--muted);
            font: 14px/1.5 system-ui, sans-serif;
        }
        button {
            margin-top: 22px;
            width: 100%;
            border: 0;
            border-radius: 6px;
            padding: 14px 18px;
            background: var(--accent);
            color: white;
            font: 800 16px system-ui, sans-serif;
            cursor: pointer;
        }
        button:hover { background: var(--accent-dark); }
        .done {
            font: 16px/1.6 system-ui, sans-serif;
        }
        .done strong { color: var(--ok); }
        @media (max-width: 640px) {
            header, form, .done { padding: 22px; }
            .grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<main>
    <header>
        <h1>Install Play BD Game</h1>
        <p>Set database credentials and the game admin security secret. Import the SQL file into your database manually before opening the app.</p>
    </header>

    @if (!empty($completed))
        <section class="done">
            <p><strong>Setup complete.</strong> The installer is locked now and Laravel cache was cleared.</p>
            @if (!empty($deletedZips))
                <p>Deleted deployment zip: {{ implode(', ', $deletedZips) }}</p>
            @endif
            <p>Open the game or admin panel from your domain.</p>
        </section>
    @else
        <form method="post" action="{{ url('/install') }}">
            @csrf

            @if ($errors->any())
                <div class="error">{{ $errors->first() }}</div>
            @endif

            <div class="grid">
                <label class="full">
                    App URL
                    <input name="app_url" value="{{ old('app_url', $defaults['app_url'] ?? request()->getSchemeAndHttpHost()) }}" placeholder="https://your-domain.com">
                </label>
                <label>
                    DB Host
                    <input name="db_host" required value="{{ old('db_host', $defaults['db_host'] ?? '127.0.0.1') }}">
                </label>
                <label>
                    DB Port
                    <input name="db_port" required inputmode="numeric" value="{{ old('db_port', $defaults['db_port'] ?? '3306') }}">
                </label>
                <label>
                    Database Name
                    <input name="db_database" required value="{{ old('db_database', $defaults['db_database'] ?? '') }}">
                </label>
                <label>
                    Database User
                    <input name="db_username" required value="{{ old('db_username', $defaults['db_username'] ?? '') }}">
                </label>
                <label>
                    Database Password
                    <input name="db_password" type="password" autocomplete="new-password">
                </label>
                <label>
                    Game Admin Secret
                    <input name="admin_secret" required type="password" autocomplete="new-password">
                </label>
            </div>

            <p class="hint">After setup, the installer creates a lock file and removes zip files from the app/public root when possible.</p>
            <button type="submit">Complete Setup</button>
        </form>
    @endif
</main>
</body>
</html>
