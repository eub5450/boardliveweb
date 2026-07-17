<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Secure Game Entry</title>
    <style>
        :root{
            color-scheme:dark;
            --bg:#070914;
            --panel:#11182a;
            --panel-border:rgba(255,255,255,.12);
            --accent:#f5c35b;
            --text:#eef2ff;
            --muted:#9ea8c7;
        }
        *{box-sizing:border-box}
        body{
            margin:0;
            min-height:100vh;
            display:grid;
            place-items:center;
            padding:24px;
            background:
                radial-gradient(circle at top, rgba(245,195,91,.16), transparent 32%),
                linear-gradient(180deg, #09101d 0%, var(--bg) 100%);
            font-family:Arial, sans-serif;
            color:var(--text);
        }
        .card{
            width:min(100%, 420px);
            border:1px solid var(--panel-border);
            border-radius:24px;
            padding:28px 24px;
            background:linear-gradient(180deg, rgba(17,24,42,.96), rgba(9,13,24,.98));
            box-shadow:0 24px 80px rgba(0,0,0,.38);
            text-align:center;
        }
        .badge{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            min-width:44px;
            height:44px;
            border-radius:999px;
            background:rgba(245,195,91,.14);
            color:var(--accent);
            font-weight:700;
            letter-spacing:.08em;
        }
        h1{
            margin:16px 0 10px;
            font-size:22px;
            line-height:1.2;
        }
        p{
            margin:0;
            color:var(--muted);
            font-size:14px;
            line-height:1.6;
        }
        .actions{
            display:flex;
            gap:12px;
            justify-content:center;
            margin-top:22px;
            flex-wrap:wrap;
        }
        .btn{
            border:0;
            border-radius:999px;
            padding:12px 18px;
            font-size:14px;
            font-weight:700;
            cursor:pointer;
            text-decoration:none;
        }
        .btn-primary{
            background:var(--accent);
            color:#181103;
        }
        .btn-secondary{
            background:rgba(255,255,255,.08);
            color:var(--text);
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="badge">GO</div>
        <h1>Entering {{ $gameName ?: $gameCode }}</h1>
        <p>Secure player access is being verified. Direct game URLs stay blocked unless the request starts from the lobby.</p>

        <form id="secure-entry-form" method="POST" action="{{ $entryUrl }}" novalidate>
            @csrf
            <input type="hidden" name="game_token" value="{{ $gameToken }}">
            <input type="hidden" name="lobby" value="{{ $lobbyUrl }}">
            <noscript>
                <div class="actions">
                    <button type="submit" class="btn btn-primary">Enter Game</button>
                    <a class="btn btn-secondary" href="{{ $lobbyUrl }}">Back To Lobby</a>
                </div>
            </noscript>
        </form>
    </div>

    <script>
        (function () {
            var form = document.getElementById('secure-entry-form');
            if (!form) {
                return;
            }
            window.setTimeout(function () {
                form.submit();
            }, 40);
        }());
    </script>
</body>
</html>
