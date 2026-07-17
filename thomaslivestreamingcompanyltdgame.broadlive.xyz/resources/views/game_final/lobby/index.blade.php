<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="theme-color" content="#070814">
    <title>Play BD Game</title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0;-webkit-tap-highlight-color:transparent}
        html,body{width:100%;min-height:100%;background:#070814;color:#fff;font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif}
        html{overflow-y:auto}
        body{overflow-x:hidden;overflow-y:auto;background:
            radial-gradient(circle at 18% 0%,rgba(93,54,255,.22),transparent 32%),
            radial-gradient(circle at 86% 12%,rgba(255,198,76,.16),transparent 28%),
            linear-gradient(180deg,#101329 0%,#080914 48%,#05060e 100%)}
        .app-lobby{min-height:100dvh;width:min(100%,760px);margin:0 auto;padding:max(12px,env(safe-area-inset-top)) 10px max(18px,env(safe-area-inset-bottom))}
        .banner-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:8px}
        .game-banner-form{display:block}
        .game-banner-btn{appearance:none;-webkit-appearance:none;width:100%;padding:0;border:0;background:none;cursor:pointer;text-align:left}
        .game-banner{position:relative;display:block;overflow:hidden;border-radius:13px;aspect-ratio:16/9;background:var(--banner-start,#111827);text-decoration:none;box-shadow:0 10px 20px rgba(0,0,0,.32),0 0 0 1px rgba(255,255,255,.12),0 0 18px var(--banner-glow,rgba(255,255,255,.10)),inset 0 1px 0 rgba(255,255,255,.12);transform:translateZ(0)}
        .game-banner:before{content:"";position:absolute;inset:0;z-index:2;border-radius:inherit;background:linear-gradient(120deg,rgba(255,255,255,.18),transparent 26%,transparent 70%,rgba(255,255,255,.08));mix-blend-mode:screen;pointer-events:none}
        .game-banner:after{content:"";position:absolute;inset:1px;z-index:3;border-radius:12px;border:1px solid rgba(255,255,255,.18);box-shadow:inset 0 0 18px rgba(255,255,255,.08),inset 0 -18px 24px rgba(0,0,0,.18);pointer-events:none}
        .game-banner img{width:100%;height:100%;object-fit:cover;display:block;filter:saturate(1.08) contrast(1.04) brightness(1.02);transition:transform .24s ease,filter .24s ease}
        .game-banner:active img{transform:scale(1.025);filter:saturate(1.16) contrast(1.08) brightness(1.06)}
        .empty{min-height:100dvh;display:grid;place-items:center;color:rgba(255,255,255,.72);font-size:14px;text-align:center;padding:20px}
        @media (min-width:760px){
            .app-lobby{padding-left:16px;padding-right:16px}
            .banner-grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:16px}
            .game-banner{border-radius:20px;aspect-ratio:16/8}
            .game-banner:after{border-radius:19px}
        }
        @media (max-width:380px){
            .app-lobby{padding-left:8px;padding-right:8px}
            .banner-grid{gap:6px}
            .game-banner{border-radius:11px}
            .game-banner:after{border-radius:10px}
        }
    </style>
</head>
<body>
    <main class="app-lobby" aria-label="Game lobby">
        @if(!empty($games) && count($games))
            <section class="banner-grid">
                @foreach($games as $game)
                    <a class="game-banner" href="{{ $game['entry_url'] }}" aria-label="Open {{ $game['name'] }}" style="--banner-glow:{{ $game['palette']['glow'] ?? 'rgba(255,255,255,.22)' }};--banner-start:{{ $game['palette']['start'] ?? '#111827' }}">
                        <img src="{{ $game['banner'] }}" alt="{{ $game['name'] }}" loading="{{ $loop->index < 3 ? 'eager' : 'lazy' }}">
                    </a>
                @endforeach
            </section>
        @else
            <div class="empty">No active games available.</div>
        @endif
    </main>
</body>
</html>
