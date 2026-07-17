<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>More Game Banner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --bg: #05030c;
            --panel-1: rgba(255, 255, 255, 0.13);
            --panel-2: rgba(255, 255, 255, 0.04);
            --gold: #ffd86b;
            --pink: #ff4ed8;
            --cyan: #44f7ff;
            --violet: #8c5cff;
            --green: #73ff9e;
            --text: #fff8fe;
            --soft: rgba(255,255,255,.72);
        }
        html, body { min-height: 100%; }
        body {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 14% 8%, rgba(255, 78, 216, .28), transparent 28%),
                radial-gradient(circle at 86% 18%, rgba(68, 247, 255, .24), transparent 30%),
                radial-gradient(circle at 50% 92%, rgba(255, 216, 107, .17), transparent 36%),
                linear-gradient(135deg, #05030c 0%, #10051d 44%, #05030c 100%);
            overflow-x: hidden;
            padding: 14px 8px 18px;
            -webkit-font-smoothing: antialiased;
        }
        body::before,
        body::after {
            content: "";
            position: fixed;
            inset: -20%;
            pointer-events: none;
            z-index: -1;
        }
        body::before {
            background:
                linear-gradient(115deg, transparent 0%, rgba(255,255,255,.08) 18%, transparent 32%),
                radial-gradient(circle, rgba(255,255,255,.08) 1px, transparent 1.8px);
            background-size: 260px 260px, 34px 34px;
            animation: bgSweep 9s linear infinite;
            opacity: .55;
        }
        body::after {
            background: conic-gradient(from 120deg at 50% 50%, rgba(255,78,216,.14), rgba(68,247,255,.12), rgba(255,216,107,.12), rgba(140,92,255,.13), rgba(255,78,216,.14));
            filter: blur(54px);
            animation: auraMove 10s ease-in-out infinite alternate;
            opacity: .62;
        }
        @keyframes bgSweep { to { transform: translate3d(-90px, 70px, 0); } }
        @keyframes auraMove { 0% { transform: rotate(0deg) scale(1); } 100% { transform: rotate(8deg) scale(1.08); } }
        input[hidden] { display: none; }
        .banner-shell {
            width: min(1180px, 100%);
            margin: 0 auto;
            padding: clamp(10px, 2.2vw, 22px);
            border-radius: 34px;
            background: linear-gradient(145deg, rgba(255,255,255,.14), rgba(255,255,255,.03));
            border: 1px solid rgba(255,255,255,.14);
            box-shadow:
                0 24px 70px rgba(0,0,0,.52),
                inset 0 1px 0 rgba(255,255,255,.22),
                0 0 34px rgba(255,78,216,.11);
            backdrop-filter: blur(18px) saturate(1.28);
            position: relative;
            overflow: hidden;
            animation: shellPop .6s ease both;
        }
        .banner-shell::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(110deg, transparent 0%, rgba(255,255,255,.17) 36%, transparent 58%);
            transform: translateX(-130%);
            animation: shellShine 4.2s ease-in-out infinite;
            pointer-events: none;
        }
        @keyframes shellPop { from { opacity: 0; transform: translateY(12px) scale(.985); } to { opacity: 1; transform: translateY(0) scale(1); } }
        @keyframes shellShine { 0%, 42% { transform: translateX(-130%); } 72%, 100% { transform: translateX(130%); } }
        .game-grid { --bs-gutter-x: 12px; --bs-gutter-y: 12px; }
        .game-card {
            height: 100%;
            border-radius: 28px;
            overflow: hidden;
            position: relative;
            isolation: isolate;
            background:
                linear-gradient(155deg, rgba(255,255,255,.18), rgba(255,255,255,.05)),
                radial-gradient(circle at 25% 15%, rgba(255,216,107,.22), transparent 40%),
                linear-gradient(145deg, rgba(14, 10, 30, .86), rgba(4, 2, 10, .96));
            border: 1px solid rgba(255,255,255,.16);
            box-shadow:
                0 18px 36px rgba(0,0,0,.48),
                inset 0 1px 0 rgba(255,255,255,.26),
                inset 0 -16px 34px rgba(0,0,0,.30);
            transform: translateZ(0);
            animation: cardFloatIn .68s cubic-bezier(.2,.9,.2,1) both, softFloat 5.8s ease-in-out infinite;
            animation-delay: calc(var(--i, 1) * .08s), calc(var(--i, 1) * .2s);
        }
        .game-card::before {
            content: "";
            position: absolute;
            inset: -2px;
            z-index: -1;
            border-radius: inherit;
            background: conic-gradient(from var(--angle), var(--pink), var(--cyan), var(--gold), var(--green), var(--violet), var(--pink));
            opacity: .52;
            animation: borderSpin 4.8s linear infinite;
        }
        .game-card::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(112deg, transparent 8%, rgba(255,255,255,.22) 22%, transparent 42%);
            transform: translateX(-120%);
            animation: cardShine 3.2s ease-in-out infinite;
            animation-delay: calc(var(--i, 1) * .35s);
            mix-blend-mode: screen;
            pointer-events: none;
        }
        @property --angle { syntax: '<angle>'; inherits: false; initial-value: 0deg; }
        @keyframes borderSpin { to { --angle: 360deg; } }
        @keyframes cardFloatIn { from { opacity: 0; transform: translateY(20px) scale(.94); } to { opacity: 1; transform: translateY(0) scale(1); } }
        @keyframes softFloat { 0%, 100% { translate: 0 0; } 50% { translate: 0 -5px; } }
        @keyframes cardShine { 0%, 45% { transform: translateX(-120%); } 76%, 100% { transform: translateX(120%); } }
        .game-card:hover { transform: translateY(-7px) scale(1.018); box-shadow: 0 26px 50px rgba(0,0,0,.56), 0 0 30px rgba(255,78,216,.20), inset 0 1px 0 rgba(255,255,255,.30); }
        .image-wrapper {
            aspect-ratio: 16 / 10;
            min-height: 110px;
            overflow: hidden;
            position: relative;
            border-radius: 26px 26px 18px 18px;
            background: rgba(0,0,0,.28);
            margin: 6px 6px 0;
            box-shadow: inset 0 0 0 1px rgba(255,255,255,.10);
        }
        .image-wrapper::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 22% 18%, rgba(255,255,255,.35), transparent 18%),
                linear-gradient(to bottom, rgba(255,255,255,.08), transparent 40%, rgba(0,0,0,.24));
            z-index: 2;
            pointer-events: none;
        }
        .game-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transform: scale(1.015);
            filter: saturate(1.24) contrast(1.08) brightness(1.06);
            transition: transform .55s ease, filter .45s ease;
        }
        .game-card:hover .game-image { transform: scale(1.09) rotate(.4deg); filter: saturate(1.42) contrast(1.13) brightness(1.12); }
        .game-title {
            min-height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 8px 14px;
            text-align: center;
            font-weight: 800;
            font-size: clamp(.86rem, 2.8vw, 1.06rem);
            letter-spacing: .02em;
            color: #fff;
            text-shadow: 0 2px 8px rgba(0,0,0,.56), 0 0 16px rgba(255,255,255,.16);
            background: linear-gradient(180deg, rgba(255,255,255,.09), rgba(0,0,0,.20));
        }
        .game-title i { color: var(--gold); filter: drop-shadow(0 0 7px rgba(255,216,107,.7)); animation: iconPulse 1.8s ease-in-out infinite; }
        @keyframes iconPulse { 0%, 100% { transform: scale(1); opacity: .9; } 50% { transform: scale(1.12); opacity: 1; } }
        .text-decoration-none { color: inherit; display: block; height: 100%; -webkit-tap-highlight-color: transparent; }
        .col-6:nth-child(1) .game-card { --i: 1; }
        .col-6:nth-child(2) .game-card { --i: 2; }
        .col-6:nth-child(3) .game-card { --i: 3; }
        .col-6:nth-child(4) .game-card { --i: 4; }
        @media (max-width: 575px) {
            body { padding: 10px 6px 14px; }
            .banner-shell { border-radius: 26px; padding: 8px; }
            .game-grid { --bs-gutter-x: 8px; --bs-gutter-y: 8px; }
            .image-wrapper { min-height: 96px; margin: 5px 5px 0; border-radius: 22px 22px 16px 16px; }
            .game-card { border-radius: 24px; }
            .game-title { min-height: 48px; padding: 10px 5px 12px; }
        }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .001ms !important; animation-iteration-count: 1 !important; transition-duration: .001ms !important; }
        }
    </style>
</head>
<body>
    <input value="{{ $authkey }}" name="email" id="authkey" hidden>
    <input value="{{ $authtoken }}" name="authtoken" id="authtoken" hidden>

    <main class="banner-shell" aria-label="More Game Banner">
        <div class="row game-grid">
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{URL::to('/')}}/betel/fruits?token={{ $authkey }}&id=1&user={{$authtoken}}" class="text-decoration-none" tabindex="0">
                    <div class="game-card">
                        <div class="image-wrapper">
                            <img src="{{URL::to('/')}}/public/game/fruits_loop.png" class="game-image" alt="Fruits Loops" loading="lazy">
                        </div>
                        <div class="game-title"><i class="fas fa-gem"></i> Fruits Loops</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{URL::to('/')}}/teenpatti/fruits?token={{ $authkey }}&id=1&user={{$authtoken}}" class="text-decoration-none" tabindex="0">
                    <div class="game-card">
                        <div class="image-wrapper">
                            <img src="{{URL::to('/')}}/public/game/teen_patti.png" class="game-image" alt="Teen Patti" loading="lazy">
                        </div>
                        <div class="game-title"><i class="fas fa-club"></i> Teen Patti</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{URL::to('/')}}/grady/play?token={{ $authkey }}&id=1&user={{$authtoken}}" class="text-decoration-none" tabindex="0">
                    <div class="game-card">
                        <div class="image-wrapper">
                            <img src="{{URL::to('/')}}/public/game/geedy.png" class="game-image" alt="Greedy" loading="lazy">
                        </div>
                        <div class="game-title"><i class="fas fa-ghost"></i> Greedy</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-3">
                <a href="https://thomaslivestreamingcompanyltdgame.broadlive.xyz/play_bd_game?email={{ urlencode($authtoken) }}" class="text-decoration-none" tabindex="0">
                    <div class="game-card">
                        <div class="image-wrapper">
                            <img src="{{URL::to('/')}}/public/game/more.webp" class="game-image" alt="More Game" loading="lazy">
                        </div>
                        <div class="game-title"><i class="fas fa-plus-circle"></i> More Game</div>
                    </div>
                </a>
            </div>
        </div>
    </main>

    <script>
        (function () {
            document.querySelectorAll('a[href="#"]').forEach(function (link) {
                link.addEventListener('click', function (event) { event.preventDefault(); });
            });
        })();
    </script>
</body>
</html>