<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $gameName ?? 'Game' }} Maintenance</title>
    <style>
        html,body{margin:0;min-height:100%;font-family:Arial,sans-serif;background:#070b12;color:#fff}
        body{display:grid;place-items:center;padding:20px}
        .box{width:min(92vw,460px);text-align:center;border:1px solid rgba(255,204,92,.42);border-radius:20px;padding:30px 24px;background:linear-gradient(145deg,rgba(25,32,50,.96),rgba(8,11,18,.98));box-shadow:0 26px 90px rgba(0,0,0,.48)}
        .lamp{width:64px;height:64px;margin:0 auto 18px;border-radius:50%;background:#ffb703;box-shadow:0 0 0 0 rgba(255,183,3,.55);animation:pulse 1.4s infinite}
        h1{font-size:26px;margin:0 0 10px;font-weight:900}
        p{margin:0;color:#d9e3f5;line-height:1.5;font-size:15px}
        .status{margin-top:18px;display:inline-flex;align-items:center;gap:8px;border-radius:999px;padding:9px 13px;background:rgba(255,255,255,.08);font-weight:800;color:#ffd166}
        .dot{width:8px;height:8px;border-radius:50%;background:#ffd166}
        @keyframes pulse{0%{box-shadow:0 0 0 0 rgba(255,183,3,.55);filter:hue-rotate(0)}70%{box-shadow:0 0 0 18px rgba(255,183,3,0);filter:hue-rotate(55deg)}100%{box-shadow:0 0 0 0 rgba(255,183,3,0);filter:hue-rotate(0)}}
    </style>
</head>
<body>
    <main class="box">
        <div class="lamp"></div>
        <h1>{{ $gameName ?? 'Game' }} Maintenance</h1>
        <p>{{ $message ?? 'This game is in maintenance. Please wait.' }}</p>
        <div class="status"><span class="dot"></span><span>Waiting for room to open</span></div>
    </main>
    <script>
        const stateUrl = @json($stateUrl ?? '');
        const sessionToken = @json($sessionToken ?? '');
        async function checkMaintenance(){
            if(!stateUrl){ return; }
            try{
                const url = new URL(stateUrl, location.href);
                const res = await fetch(url.toString(), { cache:'no-store', headers: sessionToken ? { 'X-Game-Session': sessionToken } : {} });
                const payload = await res.json();
                if(payload && payload.st && !payload.maintenance){ location.reload(); }
            }catch(e){}
        }
        setInterval(checkMaintenance, 2200);
    </script>
</body>
</html>
