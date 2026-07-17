@php
  $currentGameCode = $gameCode ?? 'lucky77_max';
  $gameTheme = is_array($gameTheme ?? null) ? $gameTheme : [];
  $displayName = $displayUserName ?? 'Player';
  $avatarLetter = strtoupper(substr($displayName, 0, 1));
  $boardPayoutMultipliers = ['melon' => 2, 'slot' => 8, 'plum' => 2];
  foreach ((array) ($gameRules['boards'] ?? config('bd_game_final.games.' . $currentGameCode . '.boards', [])) as $boardRule) {
    $boardKey = (string) ($boardRule['canonical_key'] ?? $boardRule['frontend_key'] ?? '');
    if ($boardKey !== '') {
      $boardPayoutMultipliers[$boardKey] = (float) ($boardRule['multiplier'] ?? $boardPayoutMultipliers[$boardKey] ?? 1);
    }
  }
  $formatLuckyMultiplier = function ($value) {
    return rtrim(rtrim(number_format((float) $value, 2, '.', ''), '0'), '.');
  };
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover" />
  <title>{{ config('bd_game_final.games.' . $currentGameCode . '.name', 'BD Lucky 77 Max') }}</title>
  <style>
    :root {
      --gold-light: #fff0a8;
      --gold-base: #ffd700;
      --gold-dark: #b8860b;
      --gold-shadow: #7a5900;
      --purple-bg: #140025;
      --purple-panel: #2a0148;
      --purple-card: #360061;
      --blue-seg: #0044cc;
      --purple-seg: #5600ae;
      --neon-pink: #ff1493;
      --neon-yellow: #ffff00;
      --safe-top: max(env(safe-area-inset-top), 8px);
      --safe-bottom: max(env(safe-area-inset-bottom), 8px);
      --app-max: 450px;
      --wheel-size: min(66vw, 330px);
      --topbar-h: 56px;
      --bottom-h: 62px;
      --recent-h: 38px;
      --bets-h: 118px;
    }

    * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }

    html, body {
      margin: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
      background: #080012;
      font-family: Inter, "Segoe UI", Arial, sans-serif;
      color: #fff;
    }

    body {
      display: grid;
      place-items: center;
    }

    .app {
      position: relative;
      width: min(100vw, var(--app-max));
      height: 100dvh;
      max-height: 930px;
      overflow: hidden;
      background:
        radial-gradient(circle at 50% 20%, rgba(108, 31, 205, 0.45), transparent 35%),
        radial-gradient(circle at 50% 0%, rgba(255, 215, 0, 0.08), transparent 25%),
        linear-gradient(180deg, #2b004d 0%, #120021 45%, #090012 100%);
      box-shadow: 0 0 40px rgba(0,0,0,0.7);
      isolation: isolate;
    }

    .curtains,
    .pillar,
    .pillar::after,
    .stage-glow,
    .floor-glow { pointer-events: none; }

    .curtains {
      position: absolute;
      inset: 0;
      z-index: 0;
      background:
        repeating-linear-gradient(90deg, transparent 0 14px, rgba(255,255,255,0.03) 14px 18px, transparent 18px 34px),
        radial-gradient(ellipse at 50% 0%, rgba(105, 35, 180, 0.5), transparent 55%);
      opacity: .8;
    }

    .pillar {
      position: absolute;
      top: 0;
      bottom: 0;
      width: clamp(18px, 5.2vw, 36px);
      background: linear-gradient(90deg, #120012 0%, #3f0087 48%, #170017 100%);
      z-index: 0;
      box-shadow: inset 0 0 10px rgba(255,255,255,.06);
    }
    .pillar.left { left: 0; }
    .pillar.right { right: 0; }
    .pillar::after {
      content: "";
      position: absolute;
      inset: 15% 0;
      background: repeating-linear-gradient(180deg, transparent 0 24px, rgba(0,0,0,.35) 24px 32px);
      opacity: .8;
    }

    .stage-glow {
      position: absolute;
      left: 50%;
      top: 18%;
      transform: translateX(-50%);
      width: 82%;
      height: 38%;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(255, 174, 0, .16), rgba(255, 0, 170, .08) 38%, transparent 70%);
      filter: blur(18px);
      z-index: 0;
    }

    .floor-glow {
      position: absolute;
      left: 50%;
      bottom: calc(var(--bottom-h) + var(--bets-h) + var(--recent-h) + 8px);
      transform: translateX(-50%);
      width: 72%;
      height: 18px;
      border-radius: 50%;
      background: radial-gradient(ellipse, rgba(0,0,0,.75), transparent 70%);
      filter: blur(6px);
      z-index: 1;
    }

    .bg-spotlight {
      position: absolute;
      inset: 0;
      z-index: 0;
      pointer-events: none;
      opacity: .7;
      background:
        radial-gradient(ellipse at 20% 14%, rgba(87,173,255,.18), transparent 24%),
        radial-gradient(ellipse at 80% 18%, rgba(255,42,170,.14), transparent 24%),
        radial-gradient(ellipse at 50% 26%, rgba(255,214,74,.12), transparent 28%);
      animation: spotlightDrift 9s ease-in-out infinite alternate;
      mix-blend-mode: screen;
    }

    .topbar {
      position: absolute;
      top: calc(var(--safe-top) + 6px);
      left: 12px;
      right: 12px;
      min-height: var(--topbar-h);
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 10px;
      z-index: 6;
    }

    .ranks-btn,
    .mini-pill,
    .repeat-btn,
    .close-btn,
    .bet-card,
    .chip { touch-action: manipulation; }

    .ranks-btn {
      border: 0;
      background: none;
      display: inline-flex;
      flex-direction: column;
      align-items: center;
      gap: 3px;
      color: #fff;
      padding: 0;
      cursor: pointer;
    }
    .ranks-btn .cup {
      font-size: clamp(26px, 7vw, 38px);
      filter: drop-shadow(0 4px 8px rgba(0,0,0,.6));
    }
    .ranks-btn .tag {
      font-size: 10px;
      font-weight: 900;
      text-transform: uppercase;
      letter-spacing: .6px;
      padding: 3px 8px;
      border-radius: 999px;
      border: 1px solid rgba(255,255,255,.45);
      background: linear-gradient(180deg, #ff2faa, #8d00b0);
      box-shadow: 0 4px 10px rgba(0,0,0,.3);
    }

    .top-right {
      display: flex;
      gap: 6px;
      flex-wrap: wrap;
      justify-content: flex-end;
      max-width: 70%;
    }

    .mini-pill {
      min-width: 72px;
      padding: 8px 10px;
      border-radius: 14px;
      background: linear-gradient(180deg, rgba(68,10,122,.78), rgba(21,2,44,.72));
      border: 1px solid rgba(255,215,0,.35);
      box-shadow: 0 6px 14px rgba(0,0,0,.35), inset 0 1px 0 rgba(255,255,255,.08);
      text-align: center;
    }
    .mini-label {
      font-size: 9px;
      line-height: 1;
      opacity: .75;
      text-transform: uppercase;
      letter-spacing: .6px;
    }
    .mini-value {
      margin-top: 4px;
      font-size: 13px;
      font-weight: 900;
      color: var(--gold-base);
      text-shadow: 0 0 10px rgba(255,215,0,.28);
      white-space: nowrap;
    }

    .stage {
      position: absolute;
      left: 0;
      right: 0;
      top: calc(var(--safe-top) + var(--topbar-h) + 12px);
      bottom: calc(var(--bottom-h) + var(--bets-h) + var(--recent-h) + var(--safe-bottom) + 20px);
      display: grid;
      place-items: center;
      z-index: 3;
      padding-inline: 20px;
    }

    .wheel-wrap {
      position: relative;
      width: var(--wheel-size);
      height: var(--wheel-size);
      aspect-ratio: 1 / 1;
      display: grid;
      place-items: center;
      filter: drop-shadow(0 16px 24px rgba(0,0,0,.22));
    }

    .wheel-aura,
    .wheel-spark,
    .wheel-ticks,
    .pointer-cap,
    .center-ring {
      pointer-events: none;
    }

    .wheel-aura {
      position: absolute;
      inset: -8%;
      border-radius: 50%;
      background:
        radial-gradient(circle, rgba(255,215,0,.18) 0%, rgba(255,0,170,.10) 32%, rgba(104,0,255,.08) 52%, transparent 72%);
      filter: blur(16px);
      opacity: .95;
      z-index: 0;
      animation: wheelAuraPulse 2.4s ease-in-out infinite;
    }

    .wheel-ticks {
      position: absolute;
      inset: 7px;
      border-radius: 50%;
      z-index: 2;
      opacity: .9;
      background:
        repeating-conic-gradient(from -18deg,
          rgba(255,230,155,.95) 0deg 1.6deg,
          rgba(95,44,0,.75) 1.6deg 3.4deg,
          transparent 3.4deg 36deg);
      -webkit-mask: radial-gradient(circle, transparent 0 78%, #000 80% 84%, transparent 86%);
              mask: radial-gradient(circle, transparent 0 78%, #000 80% 84%, transparent 86%);
    }

    .wheel-spark {
      position: absolute;
      inset: 12%;
      border-radius: 50%;
      z-index: 3;
      opacity: .65;
      background:
        radial-gradient(circle at 22% 22%, rgba(255,255,255,.95) 0 1.8px, transparent 3px),
        radial-gradient(circle at 76% 28%, rgba(255,255,255,.85) 0 1.6px, transparent 3px),
        radial-gradient(circle at 32% 80%, rgba(255,215,0,.9) 0 1.7px, transparent 3px),
        radial-gradient(circle at 70% 74%, rgba(255,255,255,.8) 0 1.4px, transparent 3px),
        radial-gradient(circle at 50% 12%, rgba(255,255,255,.8) 0 1.2px, transparent 2.8px);
      animation: sparkleRotate 7s linear infinite;
    }

    .wheel-wing {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      width: clamp(20px, 6vw, 36px);
      height: clamp(92px, 22vw, 152px);
      background: linear-gradient(180deg, var(--gold-light), var(--gold-base) 40%, var(--gold-shadow));
      box-shadow: inset 0 0 10px rgba(0,0,0,.45), 0 5px 14px rgba(0,0,0,.45);
      z-index: 0;
    }
    .wheel-wing.left {
      left: -8px;
      clip-path: polygon(100% 0, 100% 100%, 0 85%, 0 68%, 23% 68%, 23% 53%, 0 53%, 0 38%, 23% 38%, 23% 20%, 0 20%);
    }
    .wheel-wing.right {
      right: -8px;
      clip-path: polygon(0 0, 0 100%, 100% 85%, 100% 68%, 77% 68%, 77% 53%, 100% 53%, 100% 38%, 77% 38%, 77% 20%, 100% 20%);
    }

    .pointer {
      position: absolute;
      left: 50%;
      top: -8px;
      transform: translateX(-50%);
      width: clamp(24px, 6vw, 32px);
      height: clamp(28px, 7vw, 38px);
      clip-path: polygon(50% 100%, 0 0, 100% 0);
      background: linear-gradient(180deg, #fff7c9, var(--gold-base) 42%, var(--gold-dark));
      border-radius: 0 0 8px 8px;
      filter: drop-shadow(0 4px 7px rgba(0,0,0,.55));
      z-index: 6;
    }

    .pointer-cap {
      position: absolute;
      left: 50%;
      top: -16px;
      transform: translateX(-50%);
      width: clamp(18px, 4.8vw, 24px);
      aspect-ratio: 1;
      border-radius: 50%;
      z-index: 7;
      background:
        radial-gradient(circle at 35% 30%, rgba(255,255,255,.95), rgba(255,255,255,.15) 30%, transparent 31%),
        radial-gradient(circle, #ff4fd0 0%, #a3007d 52%, #50003a 100%);
      border: 2px solid rgba(255,235,170,.9);
      box-shadow: 0 0 0 3px rgba(94,28,0,.6), 0 0 16px rgba(255,62,186,.45);
    }

    .wheel {
      position: absolute;
      inset: 0;
      aspect-ratio: 1 / 1;
      border-radius: 50%;
      padding: clamp(10px, 2.6vw, 16px);
      background:
        radial-gradient(circle at 28% 22%, rgba(255,255,255,.65), transparent 14%),
        linear-gradient(145deg, var(--gold-light), var(--gold-base) 26%, #f0b000 40%, var(--gold-dark) 70%, var(--gold-shadow));
      box-shadow:
        0 0 0 4px rgba(255,215,0,.16),
        0 18px 36px rgba(0,0,0,.45),
        0 0 28px rgba(255,196,0,.16),
        inset 0 4px 10px rgba(255,255,255,.52),
        inset 0 -8px 14px rgba(0,0,0,.42);
      overflow: hidden;
      z-index: 1;
    }
    .wheel::before {
      content: "";
      position: absolute;
      inset: 10px;
      border-radius: 50%;
      border: 5px solid #301600;
      box-shadow: inset 0 0 14px rgba(0,0,0,.72);
      pointer-events: none;
      z-index: 2;
    }

    .wheel::after {
      content: "";
      position: absolute;
      inset: 10px;
      border-radius: 50%;
      background:
        radial-gradient(circle at 32% 20%, rgba(255,255,255,.24), transparent 18%),
        radial-gradient(circle at 50% 50%, transparent 58%, rgba(255,255,255,.14) 61%, transparent 64%);
      mix-blend-mode: screen;
      opacity: .75;
      pointer-events: none;
      z-index: 2;
    }

    .wheel-inner {
      position: absolute;
      inset: 16px;
      width: auto;
      height: auto;
      aspect-ratio: 1 / 1;
      border-radius: 50%;
      overflow: hidden;
      background:
        radial-gradient(circle at 50% 50%, transparent 0 17.6%, rgba(255,255,255,.98) 17.7% 18.5%, transparent 18.6%),
        radial-gradient(circle at 30% 18%, rgba(255,255,255,.10), transparent 13%),
        radial-gradient(circle at 50% 50%, #1399ff 0%, #0c73e9 50%, #0859cf 76%, #083ea4 100%);
      transition: transform 5.6s cubic-bezier(.2,.82,.17,1);
      will-change: transform;
      transform-origin: 50% 50%;
      box-shadow:
        inset 0 0 0 1.1px rgba(255,255,255,.18),
        inset 0 -8px 16px rgba(0,0,0,.12),
        inset 0 8px 10px rgba(255,255,255,.025),
        0 0 14px rgba(0,115,255,.12);
    }

    .wheel-inner::before {
      content: "";
      position: absolute;
      inset: 0;
      border-radius: 50%;
      background:
        radial-gradient(circle at 50% 14%, rgba(255,255,255,.18), transparent 16%),
        radial-gradient(circle at 50% 50%, transparent 83.5%, rgba(255,255,255,.12) 86%, transparent 88%);
      mix-blend-mode: screen;
      z-index: 1;
      pointer-events: none;
    }

    .wheel-inner::after {
      content: "";
      position: absolute;
      inset: 4.6%;
      border-radius: 50%;
      border: 1px solid rgba(255,255,255,.14);
      box-shadow: inset 0 0 8px rgba(255,255,255,.03);
      z-index: 2;
      pointer-events: none;
    }

    .wheel-wrap.spinning .wheel-aura {
      animation-duration: .65s;
      opacity: 1;
    }

    .wheel-wrap.spinning .pointer-cap {
      box-shadow: 0 0 0 3px rgba(94,28,0,.6), 0 0 22px rgba(255,62,186,.65);
    }

    .wheel-wrap.spinning .wheel-inner::before {
      opacity: .95;
    }

    .wheel-wrap.spinning .pointer {
      animation: pointerTick .18s linear infinite;
      transform-origin: 50% 0%;
      filter: drop-shadow(0 0 10px rgba(255,214,94,.36)) drop-shadow(0 4px 4px rgba(0,0,0,.58));
    }

    .wheel-wrap.spinning .pointer-cap {
      animation: pointerCapPulse .5s ease-in-out infinite;
    }

    .wheel-wrap.hit-stop .pointer {
      animation: none;
      transform: translateX(-50%) rotate(-11deg);
      transition: transform .14s ease-out;
    }

    .wheel-wrap.hit-stop .pointer-cap {
      animation: none;
      transform: translateX(-50%) scale(1.1);
      box-shadow: 0 0 0 3px rgba(94,28,0,.6), 0 0 24px rgba(255,209,74,.75);
      transition: transform .14s ease-out, box-shadow .14s ease-out;
    }

    .seg.is-win::before {
      width: 1.7px;
      background: linear-gradient(180deg, rgba(255,255,255,1), rgba(255,242,168,.95) 40%, rgba(255,197,58,.52) 78%, rgba(255,255,255,0) 100%);
    }

    .seg.is-win::after {
      box-shadow:
        inset 0 1px 0 rgba(255,255,255,.28),
        inset 0 -2px 7px rgba(0,0,0,.08),
        0 0 14px rgba(255,220,93,.35);
      background:
        radial-gradient(circle at 50% 12%, rgba(255,255,255,.2), transparent 44%),
        linear-gradient(180deg, rgba(255,243,180,.22), rgba(247,184,24,.16));
    }

    .seg.is-win .seg-core {
      background: radial-gradient(circle at 50% 50%, rgba(255,251,212,.38), rgba(255,206,76,.18));
      box-shadow: 0 0 10px rgba(255,215,0,.22);
    }

    .seg.is-win .seg-label {
      filter: drop-shadow(0 0 12px rgba(255,214,78,.6)) drop-shadow(0 3px 6px rgba(0,0,0,.38));
      animation: winnerFloat .9s ease-in-out 2;
    }

    .seg.is-win.slot .symbol-77 {
      text-shadow: 0 0 10px rgba(255,20,147,.95), 0 0 20px rgba(255,224,72,.55), 2px 2px 0 rgba(0,0,0,.42);
      transform: translateY(-2%) scale(1.04);
    }

    .seg {
      position: absolute;
      inset: 0;
      clip-path: polygon(50% 50%, 50% 0%, 67.9% 3.3%, 83.3% 14.1%, 94.3% 31%, 100% 50%);
      transform-origin: 50% 50%;
      display: block;
      isolation: isolate;
      background: transparent;
    }

    .seg::before {
      content: "";
      position: absolute;
      left: 50%;
      top: -0.15%;
      width: 1.15px;
      height: 56.4%;
      transform: translateX(-50%);
      background: linear-gradient(180deg, rgba(255,255,255,.96), rgba(255,255,255,.78) 33%, rgba(255,255,255,.22) 71%, rgba(255,255,255,0) 100%);
      z-index: 1;
      pointer-events: none;
    }

    .seg::after {
      content: "";
      position: absolute;
      left: 50%;
      top: 8.2%;
      width: 34%;
      height: 14.4%;
      transform: translateX(-50%);
      border-radius: 999px;
      background:
        radial-gradient(circle at 50% 12%, rgba(255,255,255,.12), transparent 44%),
        linear-gradient(180deg, rgba(5,57,154,.05), rgba(2,23,85,.14));
      box-shadow: inset 0 .8px 0 rgba(255,255,255,.12), inset 0 -1px 4px rgba(0,0,0,.05);
      z-index: 1;
      pointer-events: none;
    }

    .seg-core {
      position: absolute;
      left: 50%;
      top: 8.35%;
      width: 28%;
      height: 10.6%;
      transform: translateX(-50%);
      border-radius: 999px;
      background: rgba(255,255,255,.028);
      z-index: 1;
      pointer-events: none;
    }

    .seg.slot::after {
      top: 6.2%;
      width: 39%;
      height: 17.2%;
      background:
        radial-gradient(circle at 50% 0%, rgba(255,255,255,.16), transparent 44%),
        linear-gradient(180deg, rgba(8,38,118,.13), rgba(2,16,68,.2));
    }

    .seg-label {
      position: absolute;
      left: 50%;
      top: 50%;
      width: 18%;
      height: 18%;
      transform-origin: 50% 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      filter: drop-shadow(0 3px 5px rgba(0,0,0,.38));
      z-index: 2;
      line-height: 1;
      pointer-events: none;
    }

    .seg-label > span {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 100%;
      height: 100%;
      transform-origin: 50% 50%;
    }

    .seg-label.emoji {
      --icon-radius: calc(var(--wheel-size) * 0.322);
      font-size: clamp(31px, 6.7vw, 43px);
      width: 18.5%;
      height: 18.5%;
    }

    .seg-label.emoji > span {
      transform: translateY(-1.5%) scale(1.04);
    }

    .seg-label.seven {
      --icon-radius: calc(var(--wheel-size) * 0.312);
      width: 23%;
      height: 16%;
      font-size: clamp(39px, 8vw, 55px);
    }

    .seg-label.seven > span {
      transform: translateY(-4%) scale(1.03);
    }

    .symbol-77 {
      display: inline-block;
      font-weight: 900;
      font-style: italic;
      color: var(--neon-pink);
      font-family: Arial Black, Impact, sans-serif;
      -webkit-text-stroke: 1.25px var(--neon-yellow);
      text-shadow: 0 0 8px var(--neon-pink), 2px 2px 0 rgba(0,0,0,.42);
      letter-spacing: -1.6px;
      line-height: .84;
      transform: translateY(-2%) scale(.99);
    }

    .wheel-center {
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      width: 28%;
      aspect-ratio: 1;
      border-radius: 50%;
      display: grid;
      place-items: center;
      background:
        radial-gradient(circle at 35% 30%, rgba(255,255,255,.2), transparent 22%),
        radial-gradient(circle, #072466, #000016 72%);
      border: 4px solid var(--gold-base);
      box-shadow: inset 0 0 10px rgba(0,0,0,.8), 0 0 0 3px #552200, 0 8px 12px rgba(0,0,0,.3), 0 0 16px rgba(255,215,0,.2);
      z-index: 4;
    }

    .center-ring {
      position: absolute;
      left: 50%;
      top: 50%;
      width: 38%;
      aspect-ratio: 1;
      transform: translate(-50%, -50%);
      border-radius: 50%;
      border: 1px solid rgba(255,215,0,.45);
      box-shadow: 0 0 0 1px rgba(255,255,255,.08) inset;
      z-index: 3;
    }
    .counter {
      font-size: clamp(22px, 6vw, 34px);
      font-weight: 900;
      color: var(--gold-base);
      text-shadow: 0 0 10px rgba(255,215,0,.45), 0 2px 4px #000;
      line-height: 1;
    }
    .counter.timer-hidden{opacity:0;visibility:hidden}
    .winner-pop-token{position:fixed;z-index:28;pointer-events:none;display:grid;place-items:center;width:56px;height:56px;border-radius:50%;background:radial-gradient(circle at 36% 28%, rgba(255,255,255,.96), rgba(255,215,0,.42) 42%, rgba(255,20,147,.22) 100%);box-shadow:0 0 0 1px rgba(255,255,255,.3),0 16px 30px rgba(0,0,0,.38),0 0 30px rgba(255,215,0,.34);filter:drop-shadow(0 0 12px rgba(255,255,255,.22))}
    .winner-pop-token .result-chip{font-size:34px}
    .winner-pop-token .result-chip.chip-77{font-size:24px}

    .wheel-stand {
      position: absolute;
      left: 50%;
      bottom: 0;
      transform: translate(-50%, 50%);
      width: min(36%, 118px);
      height: 28px;
      border-radius: 12px 12px 50% 50%;
      background: linear-gradient(90deg, var(--gold-dark), var(--gold-base) 50%, var(--gold-dark));
      box-shadow: 0 10px 12px rgba(0,0,0,.35);
      z-index: 1;
    }

    .repeat-btn {
      position: absolute;
      right: -4px;
      bottom: 14px;
      transform: translate(18%, 100%);
      padding: 8px 14px;
      border-radius: 999px;
      border: 2px solid #ffb8ea;
      background: linear-gradient(180deg, #ff00a5, #7b004a);
      color: #fff;
      font-size: 12px;
      font-weight: 900;
      text-transform: uppercase;
      box-shadow: 0 4px 12px rgba(0,0,0,.42), inset 0 1px 3px rgba(255,255,255,.32);
      cursor: pointer;
      z-index: 6;
    }
    .repeat-btn:active { transform: translate(18%, 100%) scale(.96); }
    .repeat-btn{display:none !important}

    .recent-strip {
      position: absolute;
      left: 10px;
      right: 10px;
      bottom: calc(var(--bottom-h) + var(--bets-h) + var(--safe-bottom) + 12px);
      height: var(--recent-h);
      padding: 4px 10px;
      display: flex;
      align-items: center;
      gap: 8px;
      border-radius: 999px;
      background: linear-gradient(90deg, rgba(75,0,128,.88), rgba(24,0,42,.92));
      border: 1px solid rgba(255,215,0,.22);
      box-shadow: inset 0 2px 5px rgba(0,0,0,.45), 0 4px 10px rgba(0,0,0,.25);
      overflow: hidden;
      z-index: 5;
    }
    .recent-badge {
      flex: 0 0 auto;
      font-size: 10px;
      font-weight: 900;
      color: #fff;
      padding: 4px 8px;
      border-radius: 999px;
      background: linear-gradient(180deg, #ff1493, #7d003f);
      border: 1px solid rgba(255,215,0,.65);
      box-shadow: 0 0 8px rgba(255,20,147,.4);
    }
    .recent-track {
      flex: 1;
      min-width: 0;
      display: flex;
      align-items: center;
      gap: 7px;
      overflow: hidden;
      white-space: nowrap;
    }
    .result-chip {
      flex: 0 0 auto;
      font-size: 16px;
      line-height: 1;
      filter: drop-shadow(0 2px 2px rgba(0,0,0,.7));
    }
    .result-chip.result-fruit {
      width: 1.1em;
      height: 1.1em;
      display: inline-grid;
      place-items: center;
    }
    .result-chip.result-fruit svg {
      width: 100%;
      height: 100%;
      display: block;
      overflow: visible;
    }
    .result-chip.chip-77 {
      font-size: 12px;
      font-weight: 900;
      font-style: italic;
      color: var(--neon-pink);
      -webkit-text-stroke: .6px var(--neon-yellow);
    }

    .bets {
      position: absolute;
      left: 10px;
      right: 10px;
      bottom: calc(var(--bottom-h) + var(--safe-bottom) + 8px);
      height: var(--bets-h);
      display: grid;
      grid-template-columns: repeat(3, minmax(0,1fr));
      gap: 8px;
      z-index: 5;
    }

    .bet-card {
      position: relative;
      min-width: 0;
      border-radius: 14px;
      padding: 8px 4px 10px;
      background: linear-gradient(180deg, #48008d 0%, #170027 100%);
      border: 2px solid #8a2dff;
      box-shadow: 0 8px 16px rgba(0,0,0,.42), inset 0 0 15px rgba(160,85,255,.16);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: space-between;
      overflow: hidden;
      cursor: pointer;
      transition: transform .12s ease, box-shadow .12s ease;
    }
    .bet-card::before {
      content: "";
      position: absolute;
      inset: -2px;
      border-radius: 16px;
      padding: 1px;
      background: linear-gradient(180deg, rgba(255,255,255,.28), rgba(255,215,0,.18), rgba(0,0,0,.12));
      -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
      -webkit-mask-composite: xor;
      mask-composite: exclude;
      pointer-events: none;
    }
    .bet-card:active { transform: scale(.98); }
    .bet-card.blocked { opacity: .72; }

    .bet-amount,
    .bet-payout,
    .name,
    .coins,
    .winner-name,
    .winner-stats {
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .bet-amount {
      width: 100%;
      text-align: center;
      padding-bottom: 4px;
      border-bottom: 1px solid rgba(255,255,255,.09);
      font-size: 15px;
      font-weight: 900;
      text-shadow: 0 2px 4px #000;
    }
    .bet-icon {
      font-size: clamp(28px, 7vw, 38px);
      margin-top: 2px;
      filter: drop-shadow(0 4px 5px rgba(0,0,0,.58));
      line-height: 1;
    }
    .bet-icon.fruit-bet-icon {
      width: 1em;
      height: 1em;
      display: grid;
      place-items: center;
    }
    .bet-icon.fruit-bet-icon svg,
    .seg-label.emoji svg {
      width: 100%;
      height: 100%;
      display: block;
      overflow: visible;
    }
    .bet-payout {
      font-size: 20px;
      font-weight: 900;
      color: var(--gold-base);
      text-shadow: 0 0 8px rgba(255,215,0,.52), 0 2px 3px #000;
    }

    .bottom-bar {
      position: absolute;
      left: 10px;
      right: 10px;
      bottom: calc(var(--safe-bottom) + 4px);
      height: var(--bottom-h);
      display: flex;
      align-items: center;
      gap: 8px;
      z-index: 6;
    }

    .player-pill {
      min-width: 0;
      flex: 1 1 auto;
      height: 100%;
      padding: 0 8px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      gap: 8px;
      background: linear-gradient(180deg, rgba(33,0,58,.92), rgba(12,0,22,.95));
      border: 1px solid rgba(144,72,255,.55);
      box-shadow: 0 5px 12px rgba(0,0,0,.34);
      overflow: hidden;
    }
    .avatar {
      flex: 0 0 auto;
      width: 32px;
      height: 32px;
      border-radius: 10px;
      display: grid;
      place-items: center;
      background: linear-gradient(180deg, #d71fff, #7200af);
      color: #fff;
      font-weight: 900;
      border: 1px solid rgba(255,255,255,.8);
      box-shadow: 0 3px 6px rgba(0,0,0,.3);
    }
    .player-meta {
      min-width: 0;
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 3px;
    }
    .name {
      font-size: 12px;
      font-weight: 700;
    }
    .coins {
      font-size: 13px;
      color: var(--gold-base);
      font-weight: 900;
    }
    .balance-pop {
      animation: balancePop .4s ease;
    }
    @keyframes balancePop {
      0% { transform: scale(1); }
      35% { transform: scale(1.06); }
      100% { transform: scale(1); }
    }

    .chip-row {
      flex: 0 0 auto;
      display: flex;
      gap: 5px;
      justify-content: flex-end;
      min-width: 0;
    }
    .chip {
      flex: 0 0 auto;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: grid;
      place-items: center;
      border: 2px dashed rgba(255,255,255,.62);
      box-shadow: 0 4px 8px rgba(0,0,0,.36), inset 0 2px 5px rgba(255,255,255,.28);
      color: #fff;
      text-shadow: 0 1px 2px #000;
      font-size: 12px;
      font-weight: 900;
      cursor: pointer;
      user-select: none;
      transition: transform .15s ease, box-shadow .15s ease, border-style .15s ease;
    }
    .chip.active {
      border-style: solid;
      transform: translateY(-3px);
      box-shadow: 0 0 0 3px rgba(255,215,0,.95), 0 0 15px rgba(255,215,0,.5);
    }
    .chip.purple { background: radial-gradient(circle, #b000ff, #4a0080); }
    .chip.orange { background: radial-gradient(circle, #ff8800, #803300); }
    .chip.green { background: radial-gradient(circle, #00cc44, #004d1a); }
    .chip.blue { background: radial-gradient(circle, #00aaff, #003380); }

    .toast-layer {
      position: absolute;
      inset: 0;
      pointer-events: none;
      z-index: 30;
      overflow: hidden;
    }
    .toast {
      position: absolute;
      left: 50%;
      top: 18%;
      transform: translate(-50%, -50%) scale(.88);
      max-width: min(86%, 330px);
      padding: 12px 20px;
      border-radius: 18px;
      background: linear-gradient(180deg, #ffeb99, #d4af37, #9a6c10);
      border: 2px solid rgba(255,255,255,.9);
      box-shadow: 0 12px 24px rgba(0,0,0,.55);
      font-size: 15px;
      font-weight: 900;
      color: #320000;
      text-align: center;
      opacity: 0;
      transition: all .28s cubic-bezier(.175,.885,.32,1.25);
      text-shadow: 0 1px 1px rgba(255,255,255,.6);
    }
    .toast.show {
      opacity: 1;
      transform: translate(-50%, -50%) scale(1);
    }

    .flash {
      position: absolute;
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: #fff;
      opacity: 0;
      z-index: 20;
    }
    .flash.go { animation: boom .58s ease-out forwards; }
    @keyframes boom {
      0% { opacity: 1; box-shadow: 0 0 0 0 rgba(255,255,255,.78); }
      100% { opacity: 0; box-shadow: 0 0 0 76px rgba(255,215,0,0); }
    }

    .popup-backdrop {
      position: absolute;
      inset: 0;
      display: none;
      align-items: center;
      justify-content: center;
      padding: 16px;
      background: rgba(0,0,0,.8);
      backdrop-filter: blur(5px);
      z-index: 40;
    }
    .popup {
      position: relative;
      width: min(100%, 340px);
      max-height: min(78dvh, 560px);
      overflow-x: hidden;
      overflow-y: auto;
      border-radius: 18px;
      padding: 22px 18px 18px;
      background: radial-gradient(circle at 50% 0%, #5a00b8, #18002d 72%);
      border: 2px solid rgba(255,215,0,.72);
      box-shadow: 0 20px 40px rgba(0,0,0,.75);
      text-align: center;
    }
    .popup::before {
      content: "\1F451";
      position: absolute;
      left: 50%;
      top: -20px;
      transform: translateX(-50%);
      font-size: 30px;
      filter: drop-shadow(0 2px 4px rgba(0,0,0,.55));
    }
    .popup h3 {
      margin: 8px 0 10px;
      font-size: 24px;
      color: var(--gold-base);
      text-transform: uppercase;
      text-shadow: 0 2px 4px #000;
    }
    .popup p {
      margin: 0 0 12px;
      font-size: 14px;
      color: #e1d7f2;
      line-height: 1.45;
    }
    .winner-list {
      display: grid;
      grid-template-columns: repeat(6, minmax(0, 1fr));
      gap: 6px;
      margin: 14px 0 10px;
      text-align: center;
    }
    .winner-card {
      display: grid;
      justify-items: center;
      align-content: start;
      gap: 5px;
      min-width: 0;
      padding: 8px 4px;
      border-radius: 12px;
      background: rgba(0,0,0,.35);
      border: 1px solid rgba(255,215,0,.25);
    }
    .ava {
      width: 38px;
      height: 38px;
      display: grid;
      place-items: center;
      overflow: hidden;
      border-radius: 13px;
      font-size: 15px;
      font-weight: 1000;
      background: radial-gradient(circle at 35% 25%, #fff7d1, #ffbd3d 56%, #8f4700 100%);
      color: #401700;
      flex: 0 0 auto;
    }
    .ava img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .winner-details {
      min-width: 0;
      width: 100%;
    }
    .winner-name {
      font-size: 9px;
      font-weight: 800;
      color: #fff;
      line-height: 1.15;
      max-width: 100%;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
    .winner-stats {
      display: block;
      font-size: 8px;
      line-height: 1.15;
      white-space: nowrap;
      color: #b6aecd;
    }
    .winner-list .history-empty { grid-column: 1 / -1; }
    .winner-stats span { color: var(--gold-base); font-weight: 800; }
    .close-btn {
      margin-top: 10px;
      padding: 10px 28px;
      border: 0;
      border-radius: 999px;
      background: linear-gradient(180deg, #ff1493, #7e0040);
      color: #fff;
      font-size: 15px;
      font-weight: 800;
      border: 1px solid rgba(255,255,255,.32);
      box-shadow: 0 4px 8px rgba(0,0,0,.38);
      cursor: pointer;
    }

    .bet-card.win-hit {
      animation: winCard .95s ease;
      border-color: var(--gold-base);
      box-shadow: 0 0 0 2px rgba(255,215,0,.45), 0 0 18px rgba(255,215,0,.32), inset 0 0 16px rgba(255,215,0,.1);
    }
    @keyframes winCard {
      0%, 100% { transform: translateY(0) scale(1); }
      30% { transform: translateY(-4px) scale(1.03); }
      60% { transform: translateY(0) scale(1.01); }
    }

    @media (max-width: 360px) {
      :root {
        --bets-h: 108px;
        --bottom-h: 58px;
      }
      .mini-pill { min-width: 66px; padding: 7px 8px; }
      .mini-value { font-size: 12px; }
      .chip { width: 36px; height: 36px; font-size: 11px; }
      .bet-payout { font-size: 18px; }
      .bet-amount { font-size: 14px; }
      .name { max-width: 88px; }
    }


    @keyframes wheelAuraPulse {
      0%, 100% { transform: scale(.985); opacity: .82; }
      50% { transform: scale(1.025); opacity: 1; }
    }

    @keyframes sparkleRotate {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    @keyframes pointerTick {
      0%, 100% { transform: translateX(-50%) rotate(0deg); }
      50% { transform: translateX(-50%) rotate(8deg); }
    }

    @keyframes pointerCapPulse {
      0%, 100% { transform: translateX(-50%) scale(1); }
      50% { transform: translateX(-50%) scale(1.06); }
    }

    @keyframes winnerFloat {
      0%, 100% { transform: translateY(0) scale(1); }
      50% { transform: translateY(-4%) scale(1.06); }
    }

    @media (max-height: 760px) {
      :root {
        --wheel-size: min(56vw, 276px);
        --topbar-h: 50px;
        --recent-h: 34px;
        --bets-h: 94px;
        --bottom-h: 52px;
      }
      .stage {
        top: calc(var(--safe-top) + var(--topbar-h) + 8px);
        bottom: calc(var(--bottom-h) + var(--bets-h) + var(--recent-h) + var(--safe-bottom) + 18px);
      }
      .bet-card { border-radius: 12px; padding: 6px 4px 8px; }
      .bet-icon { font-size: 28px; }
      .bet-payout { font-size: 17px; }
      .bet-amount { font-size: 13px; padding-bottom: 3px; }
      .chip { width: 34px; height: 34px; font-size: 10px; }
      .avatar { width: 28px; height: 28px; font-size: 12px; }
      .coins { font-size: 12px; }
      .name { font-size: 11px; }
      .repeat-btn { padding: 6px 12px; font-size: 11px; }
      .result-chip { font-size: 14px; }
    }

    @media (max-height: 560px) {
      :root {
        --wheel-size: min(44vw, 200px);
        --topbar-h: 42px;
        --recent-h: 28px;
        --bets-h: 72px;
        --bottom-h: 42px;
      }
      .topbar {
        top: calc(var(--safe-top) + 4px);
        left: 8px;
        right: 8px;
      }
      .ranks-btn .cup { font-size: 22px; }
      .ranks-btn .tag { font-size: 8px; padding: 2px 6px; }
      .mini-pill { min-width: 56px; padding: 5px 7px; border-radius: 11px; }
      .mini-label { font-size: 7px; }
      .mini-value { font-size: 11px; margin-top: 3px; }
      .stage {
        padding-inline: 10px;
        top: calc(var(--safe-top) + var(--topbar-h) + 4px);
        bottom: calc(var(--bottom-h) + var(--bets-h) + var(--recent-h) + var(--safe-bottom) + 10px);
      }
      .wheel-wrap { height: var(--wheel-size); }
      .wheel-wing { width: 18px; height: 76px; }
      .pointer { top: -3px; }
      .center-status {
        min-width: 80px;
        padding: 5px 10px;
        font-size: 9px;
        bottom: -4px;
      }
      .repeat-btn {
        right: 50%;
        bottom: -4px;
        transform: translate(50%, 100%);
        padding: 4px 9px;
        font-size: 9px;
      }
      .repeat-btn:active { transform: translate(50%, 100%) scale(.96); }
      .recent-strip {
        left: 8px;
        right: 8px;
        padding: 2px 7px;
        gap: 6px;
      }
      .recent-badge { font-size: 8px; padding: 3px 6px; }
      .result-chip { font-size: 12px; }
      .result-chip.chip-77 { font-size: 9px; }
      .bets {
        left: 8px;
        right: 8px;
        gap: 5px;
      }
      .bet-card {
        border-width: 1px;
        border-radius: 10px;
        padding: 3px 2px 5px;
      }
      .bet-amount {
        font-size: 10px;
        padding-bottom: 2px;
      }
      .bet-icon { font-size: 18px; margin-top: 0; }
      .bet-payout { font-size: 12px; }
      .history-summary {
        margin-top: 14px;
        display: grid;
        gap: 14px;
        text-align: left;
      }
      .history-section {
        padding: 12px;
        border-radius: 14px;
        background: rgba(0,0,0,.28);
        border: 1px solid rgba(255,215,0,.16);
      }
      .history-section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 10px;
      }
      .history-section-title {
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: #fff3c8;
      }
      .history-section-sub {
        font-size: 11px;
        color: #b6aecd;
      }
      .history-table-wrap {
        border-radius: 12px;
        overflow: auto;
        border: 1px solid rgba(255,255,255,.08);
      }
      .history-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
        color: #fff;
      }
      .history-table th,
      .history-table td {
        padding: 9px 10px;
        text-align: left;
        vertical-align: top;
      }
      .history-table th {
        position: sticky;
        top: 0;
        background: rgba(18,12,30,.96);
        font-size: 10px;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: #dccde6;
        z-index: 1;
      }
      .history-table tbody tr:nth-child(odd) {
        background: rgba(255,255,255,.03);
      }
      .history-table tbody tr:nth-child(even) {
        background: rgba(255,255,255,.06);
      }
      .history-empty {
        padding: 12px;
        border-radius: 12px;
        background: rgba(255,255,255,.04);
        color: #b6aecd;
        text-align: center;
      }
      .history-board {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 0;
      }
      .history-board-matrix {
        table-layout: fixed;
      }
      .history-board-matrix th,
      .history-board-matrix td {
        text-align: center;
      }
      .history-board-matrix th:first-child,
      .history-board-matrix td:first-child {
        width: 46px;
      }
      .history-board-matrix th:last-child,
      .history-board-matrix td:last-child {
        width: 58px;
      }
      .history-board-matrix .history-trace {
        text-align: left;
      }
      .history-board-matrix th {
        font-size: 9px;
        letter-spacing: .08em;
        padding-inline: 5px;
      }
      .history-board-matrix td {
        height: 38px;
        padding: 6px 5px;
      }
      .history-board-matrix .history-status {
        padding: 3px 5px;
        font-size: 8px;
        letter-spacing: .06em;
        white-space: normal;
      }
      .history-board-token-cell {
        background: rgba(255,255,255,.025);
      }
      .history-board-token-cell.is-winner {
        background: radial-gradient(circle at 50% 45%,rgba(255,228,121,.18),transparent 64%),rgba(255,255,255,.07);
      }
      .history-board-token {
        width: 30px;
        height: 30px;
        margin: 0 auto;
        border-radius: 50%;
        display: grid;
        place-items: center;
        background: rgba(255,255,255,.09);
        border: 1px solid rgba(255,231,154,.32);
        box-shadow: 0 7px 12px rgba(0,0,0,.24);
        overflow: hidden;
      }
      .history-board-token.slot {
        color: var(--neon-pink);
      }
      .history-board .result-chip {
        width: 30px;
        height: 30px;
        flex: 0 0 30px;
      }
      .history-trace {
        font-size: 11px;
        line-height: 1.35;
        word-break: break-word;
        color: #efe6ff;
      }
      .history-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 4px 8px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 900;
        letter-spacing: .12em;
        text-transform: uppercase;
        white-space: nowrap;
      }
      .history-status.win {
        background: rgba(71,232,150,.14);
        color: #7df0b4;
        border: 1px solid rgba(71,232,150,.22);
      }
      .history-status.loss {
        background: rgba(255,106,142,.14);
        color: #ff9fb9;
        border: 1px solid rgba(255,106,142,.22);
      }
      .history-status.pending {
        background: rgba(255,214,111,.14);
        color: #ffd86a;
        border: 1px solid rgba(255,214,111,.22);
      }
      .history-status.punishment {
        background: rgba(255,173,92,.14);
        color: #ffc98f;
        border: 1px solid rgba(255,173,92,.22);
      }
      .bottom-bar {
        left: 8px;
        right: 8px;
        gap: 5px;
      }
      .player-pill {
        padding: 0 6px;
        border-radius: 10px;
      }
      .avatar { width: 20px; height: 20px; border-radius: 6px; font-size: 10px; }
      .name { font-size: 9px; }
      .coins { font-size: 10px; }
      .chip-row { gap: 3px; }
      .chip { width: 25px; height: 25px; font-size: 8px; border-width: 1px; }
      .toast {
        top: 16%;
        font-size: 12px;
        padding: 8px 14px;
      }
    }
  

    /* Final premium polish */
    .app::before,
    .app::after {
      content: "";
      position: absolute;
      inset: 0;
      pointer-events: none;
      z-index: 0;
    }
    .app::before {
      background:
        radial-gradient(circle at 50% -4%, rgba(255,236,166,.20), transparent 20%),
        radial-gradient(circle at 16% 24%, rgba(0,198,255,.12), transparent 24%),
        radial-gradient(circle at 84% 20%, rgba(255,0,170,.14), transparent 22%),
        radial-gradient(circle at 50% 72%, rgba(0,0,0,.16), transparent 35%);
      mix-blend-mode: screen;
      opacity: .95;
    }
    .app::after {
      background:
        linear-gradient(180deg, rgba(255,255,255,.03), transparent 16%),
        repeating-linear-gradient(90deg, transparent 0 26px, rgba(255,255,255,.012) 26px 28px, transparent 28px 56px);
      opacity: .6;
    }
    .wheel-wrap {
      animation: wheelFloat 4.6s ease-in-out infinite;
    }
    .wheel-wrap.spinning {
      animation-play-state: paused;
    }
    .wheel-inner {
      background:
        radial-gradient(circle at 50% 50%, transparent 0 17.6%, rgba(255,255,255,.98) 17.7% 18.4%, transparent 18.5%),
        radial-gradient(circle at 50% 14%, rgba(255,255,255,.18), transparent 10%),
        radial-gradient(circle at 30% 18%, rgba(255,255,255,.14), transparent 13%),
        radial-gradient(circle at 50% 52%, #17a4ff 0%, #0f7df3 42%, #0a61d4 68%, #084ab4 84%, #07338a 100%);
      box-shadow:
        inset 0 0 0 1.2px rgba(255,255,255,.24),
        inset 0 -10px 20px rgba(0,0,0,.14),
        inset 0 9px 12px rgba(255,255,255,.045),
        0 0 18px rgba(0,115,255,.16);
    }
    .seg::after {
      background:
        radial-gradient(circle at 50% 10%, rgba(255,255,255,.18), transparent 40%),
        linear-gradient(180deg, rgba(255,255,255,.06), rgba(0,26,89,.20));
      box-shadow:
        inset 0 1px 0 rgba(255,255,255,.14),
        inset 0 -2px 4px rgba(0,0,0,.08),
        0 0 0 1px rgba(255,255,255,.04);
    }
    .seg-core {
      background: radial-gradient(circle at 50% 20%, rgba(255,255,255,.14), rgba(255,255,255,.03) 55%, rgba(255,255,255,.02));
      box-shadow: inset 0 1px 0 rgba(255,255,255,.18), inset 0 -1px 3px rgba(0,0,0,.10);
    }
    .seg-label {
      filter: drop-shadow(0 5px 8px rgba(0,0,0,.34));
    }
    .seg-label::before {
      content: "";
      position: absolute;
      inset: 6%;
      border-radius: 999px;
      background: radial-gradient(circle at 50% 18%, rgba(255,255,255,.24), rgba(255,255,255,.04) 55%, rgba(0,0,0,.06));
      box-shadow: inset 0 1px 0 rgba(255,255,255,.22), inset 0 -2px 5px rgba(0,0,0,.12);
      z-index: -1;
      opacity: .82;
    }
    .seg-label.emoji {
      font-size: clamp(31px, 6.7vw, 43px);
      width: 18.5%;
      height: 18.5%;
    }
    .seg-label.emoji > span {
      filter: saturate(1.12) contrast(1.1);
      transform: translateY(-1.5%) scale(1.04);
    }
    .seg-label.seven {
      width: 23%;
      height: 16%;
      font-size: clamp(39px, 8vw, 55px);
    }
    .seg-label.seven::before {
      inset: 4% 2%;
      border-radius: 999px;
      background:
        radial-gradient(circle at 50% 12%, rgba(255,255,255,.22), transparent 46%),
        linear-gradient(180deg, rgba(12,56,148,.24), rgba(2,16,68,.30));
      opacity: .95;
    }
    .symbol-77 {
      -webkit-text-stroke: 1.3px #fff07b;
      text-shadow: 0 0 10px rgba(255,20,147,.58), 0 0 4px rgba(255,255,255,.22), 2px 2px 0 rgba(0,0,0,.36);
      letter-spacing: -1.45px;
      transform: translateY(-1%) scale(1);
    }
    .bet-card {
      background:
        radial-gradient(circle at 50% 8%, rgba(255,255,255,.12), transparent 24%),
        linear-gradient(180deg, rgba(82,0,150,.98), rgba(26,0,51,.98));
      box-shadow: 0 10px 18px rgba(0,0,0,.42), inset 0 0 16px rgba(136,0,255,.24), inset 0 1px 0 rgba(255,255,255,.10);
    }
    .bet-icon {
      filter: drop-shadow(0 6px 8px rgba(0,0,0,.28));
    }
    .chip {
      box-shadow: 0 6px 10px rgba(0,0,0,.28), inset 0 2px 4px rgba(255,255,255,.24), inset 0 -2px 5px rgba(0,0,0,.14);
    }
    .player-pill,
    .recent-strip,
    .mini-pill,
    .popup {
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
    }
    .toast {
      background: linear-gradient(180deg, #fff3ad, #deb443, #a96815);
      box-shadow: 0 14px 30px rgba(0,0,0,.40), inset 0 1px 0 rgba(255,255,255,.55);
    }
    @keyframes wheelFloat {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-4px); }
    }
    @media (max-height: 640px) {
      :root {
        --wheel-size: min(56vw, 270px);
        --topbar-h: 48px;
        --bottom-h: 54px;
        --recent-h: 34px;
        --bets-h: 92px;
      }
      .stage { padding-inline: 12px; }
      .center-status { min-width: 92px; padding: 5px 10px; font-size: 10px; }
      .mini-pill { min-width: 62px; padding: 6px 8px; }
      .bet-card { min-height: 74px; }
    }
    @media (max-height: 500px) {
      :root {
        --wheel-size: min(42vw, 190px);
        --topbar-h: 38px;
        --bottom-h: 42px;
        --recent-h: 26px;
        --bets-h: 58px;
      }
      .topbar { top: calc(var(--safe-top) + 2px); }
      .stage {
        top: calc(var(--safe-top) + var(--topbar-h) + 6px);
        bottom: calc(var(--bottom-h) + var(--bets-h) + var(--recent-h) + var(--safe-bottom) + 6px);
        padding-inline: 8px;
      }
      .wheel-wrap { filter: drop-shadow(0 10px 14px rgba(0,0,0,.18)); }
      .center-status { bottom: -3px; min-width: 80px; padding: 4px 8px; font-size: 9px; }
      .recent-strip { left: 8px; right: 8px; }
      .bets { left: 8px; right: 8px; gap: 4px; }
      .bet-card { border-radius: 10px; padding: 4px 2px 5px; min-height: 50px; }
      .bet-amount { font-size: 10px; }
      .bet-icon { font-size: 15px !important; }
      .bet-payout { font-size: 12px; }
      .bottom-bar { left: 8px; right: 8px; gap: 4px; }
      .player-pill { padding: 0 6px; }
      .name { max-width: 70px; }
      .chip-row { gap: 3px; }
      .chip { width: 24px; height: 24px; font-size: 8px; }
      .mini-pill { min-width: 52px; padding: 4px 6px; border-radius: 10px; }
      .mini-value { font-size: 10px; }
      .mini-label { font-size: 7px; }
    }

  

    /* Step 1 foundation patch: responsive/overflow/QC */
    :root {
      --app-max: min(100vw, 450px);
    }
    html, body {
      overscroll-behavior: none;
    }
    .app {
      width: min(100vw, 450px);
      max-width: 450px;
      min-height: 100dvh;
    }
    .topbar, .stage, .recent-strip, .bets, .bottom-bar {
      min-width: 0;
    }
    .top-right, .player-pill, .player-meta, .chip-row, .recent-track {
      min-width: 0;
    }
    .stage {
      align-content: center;
    }
    .wheel-wrap {
      width: min(var(--wheel-size), calc(100vw - 64px));
      height: min(var(--wheel-size), calc(100vw - 64px));
      max-width: 100%;
      max-height: 100%;
    }
    .recent-strip {
      overflow: hidden;
    }
    .recent-track {
      display: flex;
      align-items: center;
      gap: 6px;
      min-width: 0;
      overflow: hidden;
      flex: 1 1 auto;
    }
    .result-chip {
      flex: 0 0 auto;
    }
    .bets {
      grid-template-columns: repeat(3, minmax(0, 1fr));
      align-items: stretch;
    }
    .bet-card {
      min-width: 0;
      overflow: hidden;
      justify-content: space-between;
    }
    .bet-amount, .bet-payout, .name, .coins {
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
    .bottom-bar {
      align-items: stretch;
    }
    .player-pill {
      min-width: 0;
      flex: 1 1 44%;
    }
    .chip-row {
      flex: 1 1 56%;
      min-width: 0;
      flex-wrap: nowrap;
    }
    .chip {
      flex: 0 1 auto;
    }
    .popup-backdrop {
      padding-top: calc(var(--safe-top) + 12px);
      padding-bottom: calc(var(--safe-bottom) + 12px);
    }
    .popup {
      max-height: min(78dvh, 620px);
      overflow-x: hidden;
      overflow-y: auto;
      overscroll-behavior: contain;
    }
    .popup *,
    .winner-list,
    .history-summary,
    .history-section,
    .history-table-wrap {
      min-width: 0;
      max-width: 100%;
      box-sizing: border-box;
    }
    .history-table-wrap {
      overflow-x: hidden;
      overflow-y: auto;
    }
    .history-table,
    .popup table {
      width: 100%;
      max-width: 100%;
      min-width: 0;
      table-layout: fixed;
    }
    .history-table th,
    .history-table td,
    .popup th,
    .popup td {
      white-space: normal;
      overflow-wrap: anywhere;
      word-break: break-word;
    }
    @media (max-width: 390px) {
      :root {
        --wheel-size: min(64vw, 300px);
      }
      .top-right { max-width: 72%; }
      .mini-pill { min-width: 64px; padding: 7px 8px; }
      .recent-strip { left: 10px; right: 10px; }
      .bets { left: 10px; right: 10px; gap: 6px; }
      .bottom-bar { left: 10px; right: 10px; gap: 6px; }
    }
    @media (max-height: 720px) {
      :root {
        --wheel-size: min(54vw, 264px);
        --recent-h: 34px;
        --bets-h: 90px;
        --bottom-h: 52px;
      }
      .stage {
        top: calc(var(--safe-top) + var(--topbar-h) + 8px);
        bottom: calc(var(--bottom-h) + var(--bets-h) + var(--recent-h) + var(--safe-bottom) + 14px);
      }
    }
    @media (max-height: 600px) {
      :root {
        --wheel-size: min(45vw, 210px);
        --topbar-h: 42px;
        --recent-h: 28px;
        --bets-h: 70px;
        --bottom-h: 42px;
      }
      .wheel-wrap { filter: drop-shadow(0 10px 18px rgba(0,0,0,.2)); }
      .recent-strip { left: 8px; right: 8px; }
      .bets { left: 8px; right: 8px; gap: 4px; }
      .bottom-bar { left: 8px; right: 8px; gap: 4px; }
      .bet-card { padding: 4px 2px 5px; }
      .bet-icon { font-size: 18px; }
      .bet-payout { font-size: 12px; }
      .chip { width: 26px; height: 26px; font-size: 8px; }
      .player-pill { padding: 0 6px; }
    }
    @media (max-height: 500px) {
      :root {
        --wheel-size: min(41vw, 182px);
        --topbar-h: 36px;
        --recent-h: 24px;
        --bets-h: 56px;
        --bottom-h: 38px;
      }
      .topbar { gap: 6px; }
      .top-right { gap: 4px; }
      .mini-pill { min-width: 52px; padding: 4px 6px; border-radius: 10px; }
      .mini-label { font-size: 7px; }
      .mini-value { font-size: 10px; }
      .wheel-wing { width: 16px; height: 70px; }
      .center-status { bottom: -2px; min-width: 72px; padding: 4px 8px; font-size: 8px; }
      .repeat-btn {
        right: 50%;
        bottom: -2px;
        transform: translate(50%, 100%);
        padding: 4px 8px;
        font-size: 8px;
      }
      .repeat-btn:active { transform: translate(50%, 100%) scale(.96); }
      .recent-strip { padding: 2px 6px; }
      .recent-badge { font-size: 7px; padding: 2px 5px; }
      .result-chip { font-size: 11px; }
      .bet-amount { font-size: 9px; }
      .bet-icon { font-size: 14px; }
      .bet-payout { font-size: 10px; }
      .avatar { width: 18px; height: 18px; font-size: 9px; }
      .name, .coins { font-size: 8px; }
      .chip { width: 22px; height: 22px; font-size: 7px; }
      .toast { top: 15%; padding: 7px 12px; font-size: 11px; }
    }


    .announce-layer {
      position: absolute;
      inset: 0;
      pointer-events: none;
      z-index: 18;
      overflow: hidden;
    }
    .announce-banner {
      position: absolute;
      left: 50%;
      top: 18%;
      transform: translate(-50%, -50%) scale(.78);
      min-width: min(82vw, 340px);
      max-width: calc(100% - 28px);
      padding: 14px 18px;
      border-radius: 24px;
      text-align: center;
      font-weight: 1000;
      letter-spacing: 1px;
      text-transform: uppercase;
      opacity: 0;
      filter: blur(8px);
      box-shadow: 0 14px 26px rgba(0,0,0,.36), inset 0 1px 0 rgba(255,255,255,.18);
      transition: opacity .22s ease, transform .22s ease, filter .22s ease;
    }
    .announce-banner .sub {
      display:block;
      margin-top:4px;
      font-size:11px;
      letter-spacing:.9px;
      opacity:.88;
    }
    .announce-banner.show {
      opacity: 1;
      transform: translate(-50%, -50%) scale(1);
      filter: blur(0);
      animation: bannerPulse 1.25s ease both;
    }
    .announce-banner.start {
      color: #2a1300;
      border: 1px solid rgba(255,255,255,.66);
      background: linear-gradient(180deg, rgba(255,239,167,.96), rgba(255,181,54,.94) 52%, rgba(166,84,0,.94));
      text-shadow: 0 1px 0 rgba(255,255,255,.55);
    }
    .announce-banner.stop {
      color: #fff5f5;
      border: 1px solid rgba(255,194,214,.7);
      background: linear-gradient(180deg, rgba(255,102,173,.95), rgba(185,23,113,.95) 58%, rgba(82,5,48,.95));
      text-shadow: 0 2px 8px rgba(0,0,0,.35);
    }
    .announce-banner.win {
      color: #fffaf0;
      border: 1px solid rgba(255,245,188,.72);
      background: linear-gradient(180deg, rgba(126,30,255,.96), rgba(255,42,170,.96) 44%, rgba(255,187,43,.94));
      text-shadow: 0 2px 8px rgba(0,0,0,.35);
    }
    .announce-banner.network {
      color: #eef8ff;
      border: 1px solid rgba(181,231,255,.72);
      background: linear-gradient(180deg, rgba(84,181,255,.95), rgba(38,107,255,.95) 50%, rgba(14,28,103,.96));
      text-shadow: 0 2px 8px rgba(0,0,0,.35);
    }
        .announce-banner::after {
      content: "";
      position: absolute;
      inset: 0;
      border-radius: inherit;
      background: linear-gradient(115deg, transparent 16%, rgba(255,255,255,.06) 30%, rgba(255,255,255,.45) 48%, rgba(255,255,255,.08) 62%, transparent 78%);
      transform: translateX(-130%);
      opacity: .78;
      pointer-events: none;
    }
    .announce-banner.show::after {
      animation: bannerShine 1.45s ease forwards;
    }
    .popup {
      overflow: hidden;
    }
    .popup::after {
      content: "";
      position: absolute;
      inset: -18% -40%;
      background: linear-gradient(115deg, transparent 24%, rgba(255,255,255,.04) 36%, rgba(255,255,255,.28) 50%, rgba(255,255,255,.05) 60%, transparent 74%);
      transform: translateX(-120%) rotate(7deg);
      pointer-events: none;
    }
    .popup-backdrop[style*="display: flex"] .popup::after {
      animation: popupGlassShine 1.5s ease 1;
    }
    .wheel-wrap.hit-stop .pointer,
    .wheel-wrap.hit-stop .pointer-cap {
      animation: pointerImpact .42s ease;
    }
    .wheel-wrap.hit-stop .wheel-spark {
      opacity: 1;
      animation: pointerSpark .45s ease;
    }
    .seg.win-seg,
    .seg.win-seg .seg-core {
      animation: winningLockGlow 1.2s ease-in-out 3;
    }
    .bet-card.win-hit {
      animation: winCardHop .9s ease 2;
    }
    .winner-list .winner-card {
      position: relative;
      overflow: hidden;
    }
    .winner-list .winner-card::after {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(120deg, transparent 24%, rgba(255,255,255,.05) 38%, rgba(255,255,255,.28) 50%, rgba(255,255,255,.04) 62%, transparent 76%);
      transform: translateX(-120%);
      pointer-events: none;
    }
    .popup-backdrop[style*="display: flex"] .winner-list .winner-card::after {
      animation: popupGlassShine 1.6s ease both;
    }
.app.phase-betting .wheel-aura { animation: auraFloat 3s ease-in-out infinite; }
    .app.phase-stop .wheel-aura { animation: dangerAura 1.15s ease-in-out infinite; }
    .app.phase-win .wheel-aura { animation: winAura 1.3s ease-in-out 2; }
    .app.phase-stop .center-status,
    .app.phase-stop .counter {
      animation: urgentPulse .95s ease-in-out infinite;
    }
    .app.phase-win .center-ring::after {
      content:'';
      position:absolute;
      inset:-8px;
      border-radius:50%;
      border:2px solid rgba(255,225,106,.55);
      animation: winnerRing 1.1s ease-out 2;
    }
    .wheel-wrap.win-celebrate .wheel-spark {
      opacity: 1;
      animation: sparkBurst .9s ease-out 2;
    }
    .toast.win-toast {
      background: linear-gradient(180deg, #fff0a2, #ffbf2f 42%, #a65c00);
      color:#2d1200;
      box-shadow: 0 14px 30px rgba(0,0,0,.46), 0 0 22px rgba(255,199,43,.35);
    }
    @keyframes bannerPulse {
      0% { transform: translate(-50%, -50%) scale(.8); }
      35% { transform: translate(-50%, -50%) scale(1.05); }
      100% { transform: translate(-50%, -50%) scale(1); }
    }
    @keyframes auraFloat {
      0%,100% { transform: scale(1); opacity: .92; }
      50% { transform: scale(1.04); opacity: 1; }
    }
    @keyframes dangerAura {
      0%,100% { transform: scale(1); opacity:.78; filter: blur(16px); }
      50% { transform: scale(1.07); opacity:1; filter: blur(19px); }
    }
    @keyframes winAura {
      0% { transform: scale(1); opacity:.95; }
      50% { transform: scale(1.1); opacity:1; }
      100% { transform: scale(1.04); opacity:.92; }
    }
    @keyframes urgentPulse {
      0%,100% { transform: translateZ(0) scale(1); }
      50% { transform: translateZ(0) scale(1.06); }
    }
    @keyframes winnerRing {
      0% { transform: scale(.82); opacity: .95; }
      100% { transform: scale(1.3); opacity: 0; }
    }
    @keyframes sparkBurst {
      0% { transform: scale(.8); opacity: .2; }
      35% { transform: scale(1.06); opacity: 1; }
      100% { transform: scale(1.18); opacity: 0; }
    }

  


    .fx-layer {
      position: absolute;
      inset: 0;
      pointer-events: none;
      overflow: hidden;
      z-index: 28;
    }
    .screen-flare {
      position: absolute;
      inset: 0;
      pointer-events: none;
      z-index: 29;
      opacity: 0;
      background:
        radial-gradient(circle at 50% 40%, rgba(255,255,255,.14), transparent 28%),
        radial-gradient(circle at 50% 50%, rgba(255, 0, 140, .16), transparent 42%),
        radial-gradient(circle at 50% 50%, rgba(255, 215, 0, .18), transparent 56%);
      transition: opacity .28s ease;
    }
    .screen-flare.go {
      animation: screenFlareBurst .85s ease-out forwards;
    }
    @keyframes screenFlareBurst {
      0% { opacity: 0; }
      12% { opacity: 1; }
      100% { opacity: 0; }
    }

    .app::before {
      content: "";
      position: absolute;
      inset: 0;
      pointer-events: none;
      z-index: 0;
      background:
        radial-gradient(circle at 50% 12%, rgba(255,220,120,.24), transparent 22%),
        radial-gradient(circle at 18% 22%, rgba(0,190,255,.13), transparent 20%),
        radial-gradient(circle at 82% 26%, rgba(255,0,170,.12), transparent 20%),
        radial-gradient(circle at 50% 100%, rgba(255,120,0,.14), transparent 30%);
      mix-blend-mode: screen;
    }
    .app::after {
      content: "";
      position: absolute;
      inset: 0;
      pointer-events: none;
      z-index: 0;
      background:
        linear-gradient(180deg, rgba(255,255,255,.05), transparent 15%, transparent 80%, rgba(255,190,60,.05)),
        repeating-linear-gradient(90deg, transparent 0 62px, rgba(255,255,255,.02) 62px 63px);
      opacity: .75;
    }

    .curtains {
      background:
        radial-gradient(ellipse at 50% 0%, rgba(120, 24, 255, .42) 0%, transparent 58%),
        linear-gradient(180deg, rgba(255,255,255,.06), transparent 18%),
        repeating-linear-gradient(90deg, transparent 0%, rgba(0,0,0,.18) 4.8%, transparent 9.5%);
    }

    .chip {
      position: relative;
      overflow: visible;
      border: none;
      background: transparent !important;
      box-shadow: none;
      transition: transform .14s ease, filter .14s ease;
    }
    .chip::before { display:none; }
    .chip .chip-svg {
      width: 100%;
      height: 100%;
      display: block;
    .bet-card,.toast,.history-card,.chips-wrap{backdrop-filter:blur(18px) saturate(126%);-webkit-backdrop-filter:blur(18px) saturate(126%)}
    .bet-card::after,.toast::before,.history-card::before,.chips-wrap::before{content:"";position:absolute;inset:0;background:linear-gradient(120deg, rgba(255,255,255,.16), rgba(255,255,255,.05) 34%, transparent 62%);opacity:.34;pointer-events:none}
      filter: drop-shadow(0 5px 8px rgba(0,0,0,.34));
      transition: transform .14s ease, filter .18s ease;
    }
    .chip .chip-label {
      position: absolute;
      inset: 0;
      display: grid;
      place-items: center;
      font-size: 11px;
      font-weight: 1000;
      letter-spacing: .2px;
      color: #fffef4;
      text-shadow: 0 1px 1px rgba(0,0,0,.55);
      pointer-events: none;
      transform: translateY(.5px);
    }
    .chip.active .chip-svg {
      transform: translateY(-2px) scale(1.04);
      filter: drop-shadow(0 0 0 rgba(0,0,0,0)) drop-shadow(0 0 14px rgba(255,220,90,.44));
    }
    .chip.active {
      transform: translateY(-3px);
    }
    .chip:active { transform: scale(.95); }

    .chip-touch-ring, .bet-touch-ring {
      position: absolute;
      width: 10px;
      height: 10px;
      border-radius: 999px;
      pointer-events: none;
      z-index: 31;
      opacity: 0;
      transform: translate(-50%, -50%) scale(.35);
      background: radial-gradient(circle, rgba(255,255,255,.45), rgba(255,215,0,.12) 45%, rgba(255,0,170,0) 72%);
      border: 1px solid rgba(255,230,150,.65);
      box-shadow: 0 0 26px rgba(255,215,0,.28);
      animation: touchPulse .52s ease-out forwards;
    }
    @keyframes touchPulse {
      0% { opacity: .92; transform: translate(-50%, -50%) scale(.35); }
      100% { opacity: 0; transform: translate(-50%, -50%) scale(7.8); }
    }

    .chip-fly {
      position: absolute;
      width: 34px;
      height: 34px;
      pointer-events: none;
      z-index: 32;
      will-change: transform, opacity;
      filter: drop-shadow(0 7px 10px rgba(0,0,0,.34));
      animation: chipFly 700ms cubic-bezier(.2,.88,.25,1) forwards;
    }
    .chip-fly.big { width: 40px; height: 40px; }
    @keyframes chipFly {
      0% { opacity: 1; transform: translate(var(--from-x), var(--from-y)) scale(.84) rotate(0deg); }
      65% { opacity: 1; }
      100% { opacity: 0; transform: translate(var(--to-x), var(--to-y)) scale(.58) rotate(380deg); }
    }

    .bet-card.touching {
      animation: betTouchPulse .36s ease-out;
    }
    @keyframes betTouchPulse {
      0% { transform: scale(1); }
      50% { transform: scale(.965); }
      100% { transform: scale(1); }
    }

    .bet-card.win-hit {
      box-shadow: 0 0 0 1px rgba(255,255,255,.22), 0 10px 18px rgba(0,0,0,.4), 0 0 20px rgba(255,215,0,.22), inset 0 0 18px rgba(255,190,80,.18);
    }
    .bet-card.win-hit .bet-icon {
      animation: winIconHop .9s ease-in-out 2;
    }
    @keyframes winIconHop {
      0%,100% { transform: translateY(0) scale(1); }
      30% { transform: translateY(-7px) scale(1.08); }
      55% { transform: translateY(0) scale(.98); }
    }

    .wheel-wrap.jackpot77 {
      animation: jackpotWheel 1.5s ease-in-out 2;
    }
    @keyframes jackpotWheel {
      0%,100% { filter: drop-shadow(0 0 0 rgba(0,0,0,0)); }
      20% { filter: drop-shadow(0 0 14px rgba(255, 215, 0, .42)) drop-shadow(0 0 24px rgba(255,0,170,.28)); }
      50% { filter: drop-shadow(0 0 18px rgba(80, 190, 255, .36)) drop-shadow(0 0 32px rgba(255,215,0,.4)); }
    }

    .fx-burst, .fx-star, .fx-confetti {
      position: absolute;
      pointer-events: none;
      z-index: 32;
      will-change: transform, opacity;
    }
    .fx-burst {
      width: 10px; height: 10px; border-radius: 999px;
      background: radial-gradient(circle, rgba(255,255,255,.95), rgba(255,210,60,.8) 34%, rgba(255,0,170,.1) 66%, transparent 75%);
      animation: burstOut .95s ease-out forwards;
    }
    @keyframes burstOut {
      0% { opacity: 1; transform: translate(var(--x), var(--y)) scale(.4); }
      100% { opacity: 0; transform: translate(calc(var(--x) + var(--dx)), calc(var(--y) + var(--dy))) scale(2.4); }
    }
    .fx-star {
      width: 18px; height: 18px;
      background: radial-gradient(circle, rgba(255,255,255,.95), rgba(255,215,0,.85) 35%, transparent 68%);
      clip-path: polygon(50% 0%, 61% 37%, 100% 50%, 61% 63%, 50% 100%, 39% 63%, 0% 50%, 39% 37%);
      animation: starRise 1.15s ease-out forwards;
    }
    @keyframes starRise {
      0% { opacity: 0; transform: translate(var(--x), var(--y)) scale(.35) rotate(0deg); }
      12% { opacity: 1; }
      100% { opacity: 0; transform: translate(calc(var(--x) + var(--dx)), calc(var(--y) + var(--dy))) scale(1.1) rotate(220deg); }
    }
    .fx-confetti {
      width: 9px; height: 15px; border-radius: 3px;
      background: linear-gradient(180deg, rgba(255,255,255,.95), rgba(255,215,0,.78));
      animation: confettiFall 1.7s ease-in forwards;
    }
    @keyframes confettiFall {
      0% { opacity: 0; transform: translate(var(--x), -16px) rotate(0deg); }
      8% { opacity: 1; }
      100% { opacity: 0; transform: translate(calc(var(--x) + var(--dx)), calc(100dvh - 120px)) rotate(560deg); }
    }

    .player-pill.win-catch {
      animation: balanceCatch .86s ease-out;
    }
    @keyframes balanceCatch {
      0%,100% { transform: translateY(0) scale(1); }
      20% { transform: translateY(-2px) scale(1.02); }
      40% { transform: translateY(0) scale(.99); }
      65% { transform: translateY(-1px) scale(1.015); }
    }

    .splash-screen {
      position: absolute; inset: 0; z-index: 60;
      display: flex; align-items: center; justify-content: center;
      background:
        radial-gradient(circle at 50% 15%, rgba(255, 215, 0, .16), transparent 28%),
        radial-gradient(circle at 50% 0%, rgba(80, 150, 255, .16), transparent 34%),
        linear-gradient(180deg, #130022 0%, #090012 100%);
      transition: opacity .42s ease, visibility .42s ease;
      overflow: hidden;
    }
    .splash-screen.hide { opacity: 0; visibility: hidden; pointer-events: none; }
    .splash-card {
      width: min(86vw, 340px);
      padding: 22px 18px 16px;
      border-radius: 24px;
      background: linear-gradient(180deg, rgba(255,255,255,.12), rgba(255,255,255,.05));
      border: 1px solid rgba(255,255,255,.14);
      box-shadow: 0 20px 48px rgba(0,0,0,.45), inset 0 1px 0 rgba(255,255,255,.18);
      backdrop-filter: blur(10px);
      text-align: center;
    }
    .splash-logo {
      font-size: 34px; font-weight: 900; letter-spacing: .8px;
      color: #fff;
      text-shadow: 0 0 16px rgba(255, 90, 210, .28), 0 0 24px rgba(255, 220, 120, .22);
    }
    .splash-sub {
      margin-top: 6px; font-size: 12px; color: rgba(255,255,255,.78); font-weight: 700;
      letter-spacing: .14em; text-transform: uppercase;
    }
    .splash-wheel-mini {
      margin: 18px auto 14px; width: 88px; height: 88px; border-radius: 50%;
      background:
        conic-gradient(from -18deg, #2b78ff 0 36deg, #4452ff 36deg 72deg, #2b78ff 72deg 108deg, #4452ff 108deg 144deg, #2b78ff 144deg 180deg, #4452ff 180deg 216deg, #2b78ff 216deg 252deg, #4452ff 252deg 288deg, #2b78ff 288deg 324deg, #4452ff 324deg 360deg);
      border: 6px solid #f2cb58;
      box-shadow: 0 0 0 3px rgba(255,255,255,.06), 0 14px 32px rgba(0,0,0,.35);
      position: relative;
      animation: splashSpin 2.2s linear infinite;
    }
    .splash-wheel-mini::before {
      content: ""; position: absolute; inset: 22px; border-radius: 50%;
      background: radial-gradient(circle at 50% 45%, #0f1d5e, #050a20 70%);
      border: 3px solid #f6d467;
    }
    .splash-wheel-mini::after {
      content: "77"; position: absolute; left: 50%; top: 18%;
      transform: translateX(-50%);
      font-weight: 900; font-style: italic; font-size: 18px;
      color: #ff34ad; -webkit-text-stroke: .7px #fff18f;
      text-shadow: 0 0 8px rgba(255, 43, 166, .45);
      animation: splashPulse 1.25s ease-in-out infinite;
    }
    .splash-progress {
      height: 10px; border-radius: 999px; overflow: hidden;
      background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.08);
      box-shadow: inset 0 2px 6px rgba(0,0,0,.35);
    }
    .splash-progress > span {
      display: block; height: 100%; width: 0%;
      background: linear-gradient(90deg, #ff41b6, #ffd86a 55%, #7ab7ff);
      box-shadow: 0 0 20px rgba(255, 84, 182, .35);
      transition: width .24s ease;
    }
    .splash-status {
      display: flex; justify-content: space-between; align-items: center;
      margin-top: 10px; font-size: 12px; font-weight: 800; color: rgba(255,255,255,.92);
    }
    .splash-log {
      margin-top: 12px; min-height: 15px; font-size: 11px; color: rgba(255,255,255,.7);
      letter-spacing: .02em;
    }
    @keyframes splashSpin { to { transform: rotate(360deg); } }
    @keyframes splashPulse {
      0%,100% { transform: translateX(-50%) scale(1); }
      50% { transform: translateX(-50%) scale(1.08); }
    }

    /* Mobile fit layer: chip row docked at bottom, no page scroll, compact 450/325 heights */
    html,body,.app{width:100vw;height:100dvh;max-width:100vw;max-height:100dvh;overflow:hidden}
    .app{width:100vw;max-width:100vw}
    .stage,.recent-strip,.bets,.bottom-bar{max-width:100vw}
    .bottom-bar{
      position:fixed !important;
      left:0 !important;
      right:0 !important;
      bottom:0 !important;
      height:calc(var(--bottom-h) + var(--safe-bottom)) !important;
      padding:6px max(6px,env(safe-area-inset-right)) max(6px,env(safe-area-inset-bottom)) max(6px,env(safe-area-inset-left));
      border-radius:0 !important;
      z-index:50 !important;
    }
    .chip-row{overflow:hidden;flex-wrap:nowrap}
    .chip{flex:1 1 0;min-width:0}
    @media(max-height:450px){
      :root{--topbar-h:38px;--bottom-h:40px;--recent-h:24px;--bets-h:52px;--wheel-size:min(38vw,118px)}
      .topbar{min-height:38px;padding:4px 7px}.top-right{display:none}
      .stage{top:calc(var(--safe-top) + var(--topbar-h) + 4px);bottom:calc(var(--bottom-h) + var(--bets-h) + var(--recent-h) + var(--safe-bottom) + 8px)}
      .wheel-wrap{width:var(--wheel-size);height:var(--wheel-size)}.center-status{display:none}
      .recent-strip{height:var(--recent-h);padding:3px 6px}.recent-badge{font-size:7px;padding:2px 5px}.result-chip{font-size:10px}
      .bets{height:var(--bets-h);gap:3px;bottom:calc(var(--bottom-h) + var(--safe-bottom) + 4px)}
      .bet-card{padding:3px 2px;border-radius:8px}.bet-amount,.bet-payout{font-size:8px}.bet-icon{font-size:13px !important}
      .player-pill{display:none}.bottom-bar{gap:4px}.chip-row{flex:1 1 auto;gap:3px}.chip{height:28px;font-size:8px;border-width:1px}
    }
    @media(max-height:325px){
      :root{--topbar-h:28px;--bottom-h:32px;--recent-h:0px;--bets-h:36px;--wheel-size:min(30vw,82px)}
      .topbar{min-height:28px;padding:2px 5px}.stage{top:calc(var(--safe-top) + 30px);bottom:calc(var(--bottom-h) + var(--bets-h) + var(--safe-bottom) + 5px)}
      .recent-strip{display:none}.bets{height:var(--bets-h);gap:2px}.bet-card{padding:2px;border-radius:6px}.bet-amount{display:none}.bet-icon{font-size:10px !important}.bet-payout{font-size:7px}
      .bottom-bar{height:calc(var(--bottom-h) + var(--safe-bottom)) !important;padding:3px 4px max(3px,var(--safe-bottom))}
      .chip{height:22px;font-size:7px}
    }
    .bet-amount,
    .bet-payout,
    .coins,
    .round-no,
    .network-text {
      font-family: Inter, "Segoe UI", Arial, sans-serif !important;
      font-variant-numeric: tabular-nums;
      letter-spacing: 0 !important;
      text-transform: none;
    }
    .bet-payout {
      font-weight: 900;
      line-height: 1;
    }
    .bet-payout-static{position:absolute;top:6px;right:7px;padding:2px 6px;border-radius:999px;background:rgba(255,215,0,.16);border:1px solid rgba(255,215,0,.36);color:var(--gold-base);font-size:11px;font-weight:1000;line-height:1}
    body[class*="gf-popup-popup_"] .popup,
    body[class*="gf-popup-popup_"] .toast{border-color:var(--admin-accent);box-shadow:0 24px 80px rgba(0,0,0,.48),0 0 28px color-mix(in srgb,var(--admin-accent),transparent 64%)}
    body.gf-popup-popup_02 .popup{border-radius:28px}
    body.gf-popup-popup_03 .popup{background:linear-gradient(145deg,var(--admin-primary),rgba(8,3,18,.96))}
    body.gf-popup-popup_04 .popup{filter:saturate(1.22)}
    body.gf-popup-popup_05 .popup{outline:2px solid color-mix(in srgb,var(--admin-accent),transparent 45%)}
  </style>
  @include('game_final.partials.admin_visual_theme_styles')
  @include('game_final.partials.mobile_fit_styles')
  <style id="codex-lucky77-max-450-postfix">
    @media (max-height:450px){
      .bottom-bar{
        height:calc(44px + var(--safe-bottom)) !important;
        padding:4px max(6px,env(safe-area-inset-right)) max(4px,env(safe-area-inset-bottom)) max(6px,env(safe-area-inset-left)) !important;
      }

      .chip-row{
        gap:2px !important;
      }

      .chip{
        height:30px !important;
      }

      .chip .chip-label{
        display:grid !important;
        place-items:center !important;
        font-size:8px !important;
        line-height:1 !important;
        letter-spacing:-.02em !important;
      }
    }
  </style>
</head>
<body class="gf-popup-{{ $gameTheme['popup_theme'] ?? 'popup_01' }} gf-item-{{ $gameTheme['item_theme'] ?? 'default' }}" style="--admin-primary:{{ $gameTheme['primary_color'] ?? '#140025' }};--admin-accent:{{ $gameTheme['accent_color'] ?? '#ffd700' }}">
  <div class="app" id="app">
    <div class="splash-screen" id="splashScreen">
      <div class="splash-card">
        <div class="splash-logo">{{ config('bd_game_final.games.' . $currentGameCode . '.name', 'BD Lucky 77 Max') }}</div>
        <div class="splash-sub">Premium Casino</div>
        <div class="splash-wheel-mini"></div>
        <div class="splash-progress"><span id="splashBar"></span></div>
        <div class="splash-status">
          <span>Loading</span>
          <span id="splashPercent">0%</span>
        </div>
        <div class="splash-log" id="splashLog">Preparing game assets...</div>
      </div>
    </div>

    <div class="curtains"></div>
    <div class="pillar left"></div>
    <div class="pillar right"></div>
    <div class="stage-glow"></div>
    <div class="bg-spotlight"></div>
    <div class="floor-glow"></div>

    <div class="topbar">
      <button class="ranks-btn" id="playersBtn" aria-label="Show winners">
        <div class="cup">&#127942;</div>
        <div class="tag">Ranks</div>
      </button>

      <div class="top-right">
        <div class="mini-pill">
          <div class="mini-label">Network</div>
          <div class="mini-value" id="networkStat">sync</div>
        </div>
        <div class="mini-pill">
          <div class="mini-label">Round</div>
          <div class="mini-value" id="roundNo">-</div>
        </div>
      </div>
    </div>

    <div class="stage">
      <div class="wheel-wrap" id="wheelWrap">
        <div class="wheel-aura"></div>
        <div class="wheel-wing left"></div>
        <div class="wheel-wing right"></div>
        <div class="pointer"></div>
        <div class="pointer-cap"></div>

        <div class="wheel">
          <div class="wheel-ticks"></div>
          <div class="wheel-spark"></div>
          <div class="wheel-inner" id="wheelInner"></div>
          <div class="center-ring"></div>
          <div class="wheel-center"><div class="counter" id="counter">20</div></div>
        </div>

        <div class="wheel-stand"></div>
      </div>
    </div>

    <div class="recent-strip" id="recentStrip">
      <div class="recent-badge">NEW</div>
      <div class="recent-track" id="recentTrack"></div>
    </div>

    <div class="bets" id="betsWrap">
      <div class="bet-card" data-bet="melon">
        <div class="bet-payout-static">x{{ $formatLuckyMultiplier($boardPayoutMultipliers['melon'] ?? 1) }}</div>
        <div class="bet-amount" id="amt-melon">0</div>
        <div class="bet-icon fruit-bet-icon"> <svg viewBox="0 0 64 64" aria-hidden="true"><g transform="translate(1.6 1.4) scale(0.955)"><path d="M11 35c4-13 16-22 31-22 5 0 9 1 13 3-2 18-16 32-34 34-5 1-9 0-13-2 0-4 1-8 3-13Z" fill="#0f7d43"/><path d="M14 35c3-10 13-18 25-18 4 0 8 1 11 2-2 14-13 25-28 28-4 1-7 0-10-1 0-3 1-6 2-11Z" fill="#ff536f"/><circle cx="24" cy="29" r="1.8" fill="#241014"/><circle cx="31" cy="34" r="1.8" fill="#241014"/><circle cx="39" cy="28" r="1.8" fill="#241014"/></g></svg></div>
        <div class="bet-payout" id="own-melon">0</div>
      </div>
      <div class="bet-card" data-bet="slot">
        <div class="bet-payout-static">x{{ $formatLuckyMultiplier($boardPayoutMultipliers['slot'] ?? 1) }}</div>
        <div class="bet-amount" id="amt-slot">0</div>
        <div class="bet-icon symbol-77">77</div>
        <div class="bet-payout" id="own-slot">0</div>
      </div>
      <div class="bet-card" data-bet="plum">
        <div class="bet-payout-static">x{{ $formatLuckyMultiplier($boardPayoutMultipliers['plum'] ?? 1) }}</div>
        <div class="bet-amount" id="amt-plum">0</div>
        <div class="bet-icon fruit-bet-icon"><svg viewBox="0 0 64 64" aria-hidden="true"><g transform="translate(-1.1 1.3) scale(0.955)"><circle cx="27" cy="35" r="14" fill="#8952ff"/><circle cx="40" cy="28" r="12" fill="#6b3eff"/><path d="M31 18c4-7 10-10 18-9-3 4-7 7-14 8" fill="#38c97a"/><circle cx="22" cy="31" r="2" fill="#fff" opacity=".35"/><circle cx="37" cy="23" r="2" fill="#fff" opacity=".28"/></g></svg></div>
        <div class="bet-payout" id="own-plum">0</div>
      </div>
    </div>

    <div class="bottom-bar">
      <div class="player-pill" id="playerPill">
        <div class="avatar">{{ $avatarLetter !== '' ? $avatarLetter : 'P' }}</div>
        <div class="player-meta">
          <div class="name">{{ $displayName }}</div>
          <div class="coins">CR <span id="balance">0</span></div>
        </div>
      </div>
      <div class="chip-row">
        <div class="chip purple active" data-value="1000">1K</div>
        <div class="chip orange" data-value="5000">5K</div>
        <div class="chip green" data-value="10000">10K</div>
        <div class="chip blue" data-value="50000">50K</div>
        <div class="chip red" data-value="100000">100K</div>
      </div>
    </div>

    <div class="toast-layer">
      <div class="toast" id="toast">Notice</div>
      <div class="flash" id="flash"></div>
    </div>

    <div class="fx-layer" id="fxLayer"></div>
    <div class="screen-flare" id="screenFlare"></div>

    <div class="announce-layer">
      <div class="announce-banner start" id="startBanner">Start Bet<span class="sub">Place your chips now</span></div>
      <div class="announce-banner stop" id="stopBanner">Stop Bet<span class="sub">Wait for result</span></div>
      <div class="announce-banner win" id="winBanner">Winner<span class="sub" id="winBannerSub">Payout ready</span></div>
      <div class="announce-banner network" id="networkBanner">Network Alert<span class="sub" id="networkBannerSub">Connection unstable</span></div>
    </div>

    <div class="popup-backdrop" id="playersPopup">
      <div class="popup">
        <h3>Active Users</h3>
        <p>Live players in this game</p>
        <div class="winner-list" id="activePlayersList">
          <div class="winner-card">
            <div class="ava">{{ $avatarLetter !== '' ? $avatarLetter : 'P' }}</div>
            <div class="winner-details">
              <div class="winner-name">{{ $displayName }}</div>
              <div class="winner-stats">YOU</div>
            </div>
          </div>
        </div>
        <div class="history-summary">
          <div class="history-section">
            <div class="history-section-head">
              <div class="history-section-title">Win Board History</div>
              <div class="history-section-sub">Last 15 settled rounds</div>
            </div>
            <div class="history-table-wrap" id="historyBoardsTable"></div>
          </div>
          <div class="history-section">
            <div class="history-section-head">
              <div class="history-section-title">My Bet History</div>
              <div class="history-section-sub">Last 15 bet tickets</div>
            </div>
            <div class="history-table-wrap" id="historyUserTable"></div>
          </div>
        </div>
        <button class="close-btn" data-close="playersPopup">Close</button>
      </div>
    </div>
  </div>

  <script>
    const wheelInner = document.getElementById('wheelInner');
    const wheelWrap = document.getElementById('wheelWrap');
    const recentTrack = document.getElementById('recentTrack');
    const toast = document.getElementById('toast');
    const flash = document.getElementById('flash');
    const counter = document.getElementById('counter');
    const balanceEl = document.getElementById('balance');
    const playerPill = document.getElementById('playerPill');
    const networkStat = document.getElementById('networkStat');
    const roundNo = document.getElementById('roundNo');
    const appEl = document.getElementById('app');
    const startBanner = document.getElementById('startBanner');
    const stopBanner = document.getElementById('stopBanner');
    const winBanner = document.getElementById('winBanner');
    const winBannerSub = document.getElementById('winBannerSub');
    const networkBanner = document.getElementById('networkBanner');
    const networkBannerSub = document.getElementById('networkBannerSub');
    const playersPopup = document.getElementById('playersPopup');
    const activePlayersList = document.getElementById('activePlayersList');
    const historyBoardsTable = document.getElementById('historyBoardsTable');
    const historyUserTable = document.getElementById('historyUserTable');
    const splashScreen = document.getElementById('splashScreen');
    const splashBar = document.getElementById('splashBar');
    const splashPercent = document.getElementById('splashPercent');
    const splashLog = document.getElementById('splashLog');
    const fxLayer = document.getElementById('fxLayer');
    const screenFlare = document.getElementById('screenFlare');
    const currentGameCode = @json($currentGameCode);
    const boardPayoutMultipliers = @json($boardPayoutMultipliers);
    const hasLiveSession = @json((bool) ($sessionToken ?? null));
    const allowStandalonePreview = false;
    const useStandalonePreview = false;

    function iconSvg(type) {
      if (type === 'melon') {
        return `
        <svg viewBox="0 0 64 64" aria-hidden="true">
          <g transform="translate(1.6 1.4) scale(0.955)">
            <path d="M11 35c4-13 16-22 31-22 5 0 9 1 13 3-2 18-16 32-34 34-5 1-9 0-13-2 0-4 1-8 3-13Z" fill="#0f7d43"/>
            <path d="M14 35c3-10 13-18 25-18 4 0 8 1 11 2-2 14-13 25-28 28-4 1-7 0-10-1 0-3 1-6 2-11Z" fill="#ff536f"/>
            <circle cx="24" cy="29" r="1.8" fill="#241014"/><circle cx="31" cy="34" r="1.8" fill="#241014"/><circle cx="39" cy="28" r="1.8" fill="#241014"/>
          </g>
        </svg>`;
      }
      if (type === 'plum') {
        return `
        <svg viewBox="0 0 64 64" aria-hidden="true">
          <g transform="translate(-1.1 1.3) scale(0.955)">
            <circle cx="27" cy="35" r="14" fill="#8952ff"/><circle cx="40" cy="28" r="12" fill="#6b3eff"/><path d="M31 18c4-7 10-10 18-9-3 4-7 7-14 8" fill="#38c97a"/>
            <circle cx="22" cy="31" r="2" fill="#fff" opacity=".35"/><circle cx="37" cy="23" r="2" fill="#fff" opacity=".28"/>
          </g>
        </svg>`;
      }
      return '<span class="symbol-77">77</span>';
    }

    function recentItemView(key) {
      if (key === 'slot') return { className: 'result-chip chip-77', html: '77', label: '77' };
      if (key === 'melon') return { className: 'result-chip result-fruit', html: iconSvg('melon'), label: 'Melon' };
      if (key === 'plum') return { className: 'result-chip result-fruit', html: iconSvg('plum'), label: 'Plum' };
      const label = String(key || '?');
      return { className: 'result-chip', html: label, label };
    }

    const segments = [
      { key:'slot', label:'<span class="symbol-77">77</span>', is77:true },
      { key:'melon', label:iconSvg('melon') },
      { key:'plum', label:iconSvg('plum') },
      { key:'melon', label:iconSvg('melon') },
      { key:'plum', label:iconSvg('plum') },
      { key:'melon', label:iconSvg('melon') },
      { key:'plum', label:iconSvg('plum') },
      { key:'melon', label:iconSvg('melon') },
      { key:'plum', label:iconSvg('plum') },
      { key:'melon', label:iconSvg('melon') }
    ];

    const state = {
      currentChip: 1000,
      bets: { melon:0, slot:0, plum:0 },
      boardTotals: { melon:0, slot:0, plum:0 },
      lastBets: { melon:0, slot:0, plum:0 },
      previousSettledBets: { melon:0, slot:0, plum:0 },
      results: [],
      balance: 0,
      spinning: false,
      phase: 'idle',
      rotation: -18,
      round: 0,
      betLockUntil: 0,
      bannerLockUntil: 0,
      settleTimer: null,
      pointerTimer: null,
      highlightTimer: null,
      visibilityPaused: false
    };
    const sharedRoomState = window.BDLucky77MaxRoomState || (window.BDLucky77MaxRoomState = { lastStatePayload: null });
    let countdownTimer = null;

    const GAME_CONFIG = {
      bettingSeconds: 20,
      notificationMs: 3000,
      splashSteps: [
        'Preparing game assets...',
        'Syncing wheel data...',
        'Loading premium effects...',
        'Starting secure session...',
        'Entering game room...'
      ]
    };

    function buildWheel() {
      wheelInner.innerHTML = '';
      const step = 360 / segments.length;
      segments.forEach((seg, i) => {
        const el = document.createElement('div');
        el.className = `seg ${seg.is77 ? 'slot' : seg.key}`;
        const rot = i * step;
        el.style.transform = `rotate(${rot}deg)`;

        const labelClass = seg.is77 ? 'seg-label seven' : 'seg-label emoji';
        const innerRot = rot + (step / 2);
        const wrapTransform = seg.is77
          ? `translate(-50%, -50%) rotate(${step / 2}deg) translateY(calc(var(--icon-radius) * -1))`
          : `translate(-50%, -50%) rotate(${step / 2}deg) translateY(calc(var(--icon-radius) * -1))`;
        const innerTransform = seg.is77
          ? `rotate(-${innerRot}deg) translateY(-4%) scale(.96)`
          : `rotate(-${innerRot}deg) translateY(-2%) scale(.92)`;
        el.innerHTML = `
          <div class="seg-core"></div>
          <span class="${labelClass}" style="transform:${wrapTransform}">
            <span style="transform:${innerTransform}">${seg.label}</span>
          </span>
        `;
        wheelInner.appendChild(el);
      });
      wheelInner.style.transform = `rotate(${state.rotation}deg)`;
    }

    function renderRecent() {
      recentTrack.innerHTML = '';
      state.results.slice(-12).reverse().forEach(item => {
        const view = recentItemView(item && item.key ? item.key : item);
        const el = document.createElement('div');
        el.className = view.className;
        el.innerHTML = view.html;
        el.setAttribute('aria-label', view.label);
        recentTrack.appendChild(el);
      });
    }

    function renderBets() {
      document.getElementById('amt-melon').textContent = formatCompact(state.boardTotals.melon);
      document.getElementById('amt-slot').textContent = formatCompact(state.boardTotals.slot);
      document.getElementById('amt-plum').textContent = formatCompact(state.boardTotals.plum);
      const payload = sharedRoomState.lastStatePayload || null;
      const winner = payload && (payload.winner_board || (payload.result && payload.result.winner_board));
      const resultPhase = !!(payload && (payload.phase === 'revealed' || payload.phase === 'settled'));
      ['melon', 'slot', 'plum'].forEach((key) => {
        const ownNode = document.getElementById(`own-${key}`);
        if (!ownNode) return;
        const myTotal = Number(state.bets && state.bets[key] || 0);
        if (resultPhase && winner === key && myTotal > 0) {
          const actualWin = Number(payload && payload.my_total_win_amount || 0);
          const payout = payoutFor(key);
          const winAmount = actualWin > 0 ? actualWin : Math.round(myTotal * payout);
          ownNode.textContent = `${formatCompact(myTotal)} x${formatCompact(payout)} = ${formatCompact(winAmount)}`;
          return;
        }
        ownNode.textContent = formatCompact(myTotal);
      });
      balanceEl.textContent = balanceNumber(state.balance);
    }

    function formatCompact(val) {
      if (val >= 1000000) return (val / 1000000).toFixed(val % 1000000 ? 1 : 0) + 'M';
      if (val >= 1000) return (val / 1000).toFixed(val % 1000 ? 1 : 0) + 'K';
      return String(val);
    }

    function balanceNumber(val) {
      return String(Math.max(0, Math.floor(Number(val || 0))));
    }

    function updatePhase(phase, text) {
      state.phase = phase;
      appEl.classList.remove('phase-betting', 'phase-stop', 'phase-win');
      appEl.classList.add(`phase-${phase}`);

      document.querySelectorAll('.bet-card').forEach(card => {
        card.classList.toggle('blocked', phase !== 'betting');
      });
    }

    function showBanner(el, ms = GAME_CONFIG.notificationMs) {
      document.querySelectorAll('.announce-banner').forEach(b => {
        if (b !== el) {
          clearTimeout(b._t);
          b.classList.remove('show');
        }
      });
      clearTimeout(el._t);
      void el.offsetWidth;
      el.classList.add('show');
      el._t = setTimeout(() => el.classList.remove('show'), ms);
    }

    function showToast(text, ms = GAME_CONFIG.notificationMs, variant = '') {
      if (!toast) return;
      toast.dataset.token = String((Number(toast.dataset.token || '0') + 1));
      const token = toast.dataset.token;
      clearTimeout(showToast._t);
      toast.classList.remove('show', 'win-toast');
      void toast.offsetWidth;
      toast.textContent = text;
      if (variant === 'win') toast.classList.add('win-toast');
      toast.classList.add('show');
      showToast._t = setTimeout(() => {
        if (toast.dataset.token !== token) return;
        toast.classList.remove('show', 'win-toast');
      }, ms);
    }

    function burst(x, y) {
      const appRect = document.getElementById('app').getBoundingClientRect();
      flash.style.left = `${x - appRect.left}px`;
      flash.style.top = `${y - appRect.top}px`;
      flash.classList.remove('go');
      void flash.offsetWidth;
      flash.classList.add('go');
    }

    function popBalance() {
      playerPill.classList.remove('balance-pop');
      void playerPill.offsetWidth;
      playerPill.classList.add('balance-pop');
    }

    function makeTouchRing(x, y, cls = 'bet-touch-ring') {
      const el = document.createElement('div');
      el.className = cls;
      el.style.left = x + 'px';
      el.style.top = y + 'px';
      fxLayer.appendChild(el);
      setTimeout(() => el.remove(), 560);
    }

    function chipSvgMarkup(value, tone = 'violet') {
      const palettes = {
        violet: ['#ffe9ff', '#ef7bff', '#7e15cf', '#3e036d'],
        orange: ['#fff3d7', '#ffbd57', '#d26a00', '#6c2600'],
        green: ['#ecffe8', '#4fe985', '#139c44', '#0b4a26'],
        blue: ['#edf6ff', '#59c3ff', '#0b6ed9', '#062b78'],
        red: ['#fff0f0', '#ff8484', '#d7234b', '#68001b']
      };
      const p = palettes[tone] || palettes.violet;
      return `<svg class="chip-svg" viewBox="0 0 100 100" aria-hidden="true">
        <defs>
          <radialGradient id="g-${tone}-${value}" cx="35%" cy="30%" r="70%">
            <stop offset="0%" stop-color="${p[0]}"/>
            <stop offset="34%" stop-color="${p[1]}"/>
            <stop offset="72%" stop-color="${p[2]}"/>
            <stop offset="100%" stop-color="${p[3]}"/>
          </radialGradient>
        </defs>
        <circle cx="50" cy="50" r="47" fill="url(#g-${tone}-${value})"/>
        <circle cx="50" cy="50" r="39" fill="none" stroke="rgba(255,255,255,.88)" stroke-width="3.6" stroke-dasharray="7 7" stroke-linecap="round"/>
        <circle cx="50" cy="50" r="29" fill="rgba(255,255,255,.08)" stroke="rgba(255,255,255,.16)" stroke-width="1.5"/>
        <ellipse cx="40" cy="28" rx="18" ry="10" fill="rgba(255,255,255,.26)"/>
      </svg>`;
    }

    function beautifyChips() {
      document.querySelectorAll('.chip').forEach(chip => {
        const value = Number(chip.dataset.value || 0);
        const tone = [...chip.classList].find(c => ['purple','orange','green','blue','red'].includes(c)) || 'purple';
        const label = chip.textContent.trim();
        chip.innerHTML = chipSvgMarkup(value, tone) + `<span class="chip-label">${label}</span>`;
      });
    }

    function cloneChipNode(value) {
      const src = document.querySelector(`.chip[data-value="${value}"]`) || document.querySelector('.chip.active');
      const chip = document.createElement('div');
      chip.className = 'chip-fly' + (value >= 100000 ? ' big' : '');
      chip.innerHTML = src ? src.innerHTML : (chipSvgMarkup(value, 'violet') + `<span class="chip-label">${formatCompact(value)}</span>`);
      return chip;
    }

    function chipFly(fromRect, toRect, value, delay = 0) {
      const appRect = appEl.getBoundingClientRect();
      const node = cloneChipNode(value);
      node.style.setProperty('--from-x', (fromRect.left + fromRect.width / 2 - appRect.left - 17) + 'px');
      node.style.setProperty('--from-y', (fromRect.top + fromRect.height / 2 - appRect.top - 17) + 'px');
      node.style.setProperty('--to-x', (toRect.left + toRect.width / 2 - appRect.left - 17) + 'px');
      node.style.setProperty('--to-y', (toRect.top + toRect.height / 2 - appRect.top - 17) + 'px');
      node.style.animationDelay = delay + 'ms';
      fxLayer.appendChild(node);
      setTimeout(() => node.remove(), 900 + delay);
    }

    function chipsToBalance(total, crazy = false) {
      const targetRect = playerPill.getBoundingClientRect();
      const sourceEl = document.querySelector('.bet-card.win-hit') || wheelWrap;
      const sourceRect = sourceEl.getBoundingClientRect();
      const loops = Math.max(1, Math.min(crazy ? 12 : Math.min(7, Math.max(3, Math.round(total / 50000))), luckyMaxFxBudget('winCoins', crazy ? 12 : 7)));
      for (let i = 0; i < loops; i += 1) {
        const fromRect = {
          left: sourceRect.left + (Math.random() * Math.max(18, sourceRect.width - 18)),
          top: sourceRect.top + (Math.random() * Math.max(18, sourceRect.height - 18)),
          width: 10,
          height: 10
        };
        chipFly(fromRect, targetRect, crazy ? 100000 : state.currentChip, i * 70);
      }
      playerPill.classList.remove('win-catch');
      void playerPill.offsetWidth;
      playerPill.classList.add('win-catch');
    }

    function luckyMaxFxBudget(key, fallback) {
      const api = window.BDGameFinal;
      const budget = api && typeof api.fxBudget === 'function' ? api.fxBudget() : null;
      if (budget && Number(budget[key]) > 0) return Number(budget[key]);
      const compact = window.innerHeight <= 520 || window.innerWidth <= 430 || (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);
      if (!compact) return fallback;
      const localBudget = { betCoins: 2, betSparks: 2, winCoins: 4, winParticles: 6 };
      return localBudget[key] || Math.min(fallback, 6);
    }

    function particleBurst(x, y, crazy = false) {
      const count = Math.max(1, Math.min(crazy ? 28 : 14, luckyMaxFxBudget('winParticles', crazy ? 28 : 14)));
      for (let i = 0; i < count; i += 1) {
        const p = document.createElement('div');
        p.className = i % 4 === 0 ? 'fx-star' : 'fx-burst';
        p.style.setProperty('--x', x + 'px');
        p.style.setProperty('--y', y + 'px');
        p.style.setProperty('--dx', ((Math.random() - .5) * (crazy ? 240 : 140)) + 'px');
        p.style.setProperty('--dy', ((Math.random() - .5) * (crazy ? 190 : 110)) + 'px');
        fxLayer.appendChild(p);
        setTimeout(() => p.remove(), crazy ? 1450 : 1100);
      }
    }

    function confettiRain(crazy = false) {
      const count = Math.max(1, Math.min(crazy ? 34 : 16, luckyMaxFxBudget('winParticles', crazy ? 34 : 16)));
      for (let i = 0; i < count; i += 1) {
        const c = document.createElement('div');
        c.className = 'fx-confetti';
        c.style.left = Math.random() * appEl.clientWidth + 'px';
        c.style.background = [
          'linear-gradient(180deg,#fff0aa,#ffc400)',
          'linear-gradient(180deg,#fff,#5ec8ff)',
          'linear-gradient(180deg,#ffd4f4,#ff2bb3)'
        ][i % 3];
        c.style.setProperty('--x', (Math.random() * appEl.clientWidth) + 'px');
        c.style.setProperty('--dx', ((Math.random() - .5) * (crazy ? 180 : 90)) + 'px');
        c.style.animationDelay = (Math.random() * .24) + 's';
        fxLayer.appendChild(c);
        setTimeout(() => c.remove(), 1900);
      }
    }

    function winnerTokenMarkup(resultKey) {
      return recentItemView(resultKey).html;
    }

    function animateWinnerToPopup(resultKey, sourceEl) {
      if (!resultKey || !sourceEl || !sourceEl.getBoundingClientRect || !winBanner) return;
      const from = sourceEl.getBoundingClientRect();
      const to = winBanner.getBoundingClientRect();
      if (!from.width || !from.height || !to.width || !to.height) return;
      const token = document.createElement('div');
      token.className = `winner-pop-token ${resultKey}`;
      token.innerHTML = winnerTokenMarkup(resultKey);
      const startX = from.left + (from.width / 2);
      const startY = from.top + (from.height / 2);
      const endX = to.left + Math.min(to.width - 44, Math.max(44, to.width * .22));
      const endY = to.top + (to.height / 2);
      token.style.left = `${startX - 28}px`;
      token.style.top = `${startY - 28}px`;
      document.body.appendChild(token);
      const animation = token.animate([
        { transform: 'translate(0px, 0px) scale(.74) rotate(-10deg)', opacity: 0 },
        { transform: 'translate(0px, -36px) scale(1.16) rotate(5deg)', opacity: 1, offset: .34 },
        { transform: `translate(${endX - startX}px, ${endY - startY}px) scale(.86) rotate(0deg)`, opacity: 1, offset: .82 },
        { transform: `translate(${endX - startX}px, ${endY - startY}px) scale(.78) rotate(0deg)`, opacity: 0 }
      ], { duration: 1050, easing: 'cubic-bezier(.2,.82,.16,1)', fill: 'forwards' });
      animation.finished.catch(() => {}).finally(() => token.remove());
    }

    function runWinCelebration(resultKey, won) {
      const winSeg = document.querySelector(`.seg.${resultKey}`);
      if (winSeg) {
        winSeg.classList.add('win-seg');
        setTimeout(() => winSeg.classList.remove('win-seg'), resultKey === 'slot' && won > 0 ? 2600 : 1450);
        const appRect = appEl.getBoundingClientRect();
        const rect = winSeg.getBoundingClientRect();
        const x = rect.left + rect.width / 2 - appRect.left;
        const y = rect.top + rect.height / 2 - appRect.top;
        const crazy = resultKey === 'slot' && won > 0;
        particleBurst(x, y, crazy);
        confettiRain(crazy);
        if (crazy) {
          wheelWrap.classList.add('jackpot77');
          setTimeout(() => wheelWrap.classList.remove('jackpot77'), 3100);
        }
      }
      screenFlare.classList.remove('go');
      void screenFlare.offsetWidth;
      screenFlare.classList.add('go');
    }

    function payoutFor(key, payload) {
      const liveBoard = (payload && payload.boards || []).find(item => item && String(item.frontend_key || item.canonical_key) === String(key));
      const fromPayload = Number(liveBoard && liveBoard.multiplier || 0);
      return fromPayload > 0 ? fromPayload : Number(boardPayoutMultipliers[key] || 1);
    }

    function cloneBets(obj) {
      return { melon: obj.melon, slot: obj.slot, plum: obj.plum };
    }

    function totalBet(obj) {
      return obj.melon + obj.slot + obj.plum;
    }

    function resetRoundBets() {
      state.bets = { melon: 0, slot: 0, plum: 0 };
    }

    function clearRoundTimers() {
      if (state.settleTimer) {
        clearTimeout(state.settleTimer);
        state.settleTimer = null;
      }
      if (state.pointerTimer) {
        clearTimeout(state.pointerTimer);
        state.pointerTimer = null;
      }
      if (state.highlightTimer) {
        clearTimeout(state.highlightTimer);
        state.highlightTimer = null;
      }
    }

    function safeBanner(el, ms = GAME_CONFIG.notificationMs) {
      const now = Date.now();
      if (now < state.bannerLockUntil) return;
      state.bannerLockUntil = now + Math.max(800, Math.min(ms, GAME_CONFIG.notificationMs + 200));
      showBanner(el, ms);
    }

    function setNetworkMock() {
      const ms = 18 + Math.floor(Math.random() * 72);
      const badNow = ms >= 75;
      networkStat.textContent = `${ms}ms`;
      networkStat.style.color = ms < 45 ? '#7CFF8C' : (ms < 75 ? '#FFD55E' : '#FF8B8B');
      if (badNow && !state.networkBad) {
        networkBannerSub.textContent = `Latency ${ms}ms - connection unstable`;
        safeBanner(networkBanner, GAME_CONFIG.notificationMs);
      }
      state.networkBad = badNow;
    }

    document.querySelectorAll('.chip').forEach(chip => {
      chip.addEventListener('click', () => {
        document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
        chip.classList.add('active');
        state.currentChip = Number(chip.dataset.value);
        const rect = chip.getBoundingClientRect();
        const appRect = appEl.getBoundingClientRect();
        makeTouchRing(rect.left + rect.width / 2 - appRect.left, rect.top + rect.height / 2 - appRect.top, 'chip-touch-ring');
      });
    });

    if (useStandalonePreview) {
      document.querySelectorAll('.bet-card').forEach(card => {
        card.addEventListener('click', (e) => {
          const now = Date.now();
          if (now < state.betLockUntil) return;
          state.betLockUntil = now + 110;

          if (state.phase !== 'betting' || state.spinning || state.visibilityPaused) {
            showToast('Wait for next round', GAME_CONFIG.notificationMs);
            return;
          }

          if (state.balance < state.currentChip) {
            showToast('Not enough coins', GAME_CONFIG.notificationMs);
            return;
          }

          const key = card.dataset.bet;
          state.bets[key] += state.currentChip;
          state.balance -= state.currentChip;
          renderBets();
          popBalance();

          const rect = card.getBoundingClientRect();
          const activeChip = document.querySelector('.chip.active');
          if (activeChip) chipFly(activeChip.getBoundingClientRect(), rect, state.currentChip);
          card.classList.remove('touching');
          void card.offsetWidth;
          card.classList.add('touching');
          setTimeout(() => card.classList.remove('touching'), 380);
          const appRect = appEl.getBoundingClientRect();
          makeTouchRing(rect.left + rect.width / 2 - appRect.left, rect.top + rect.height / 2 - appRect.top, 'bet-touch-ring');
          burst(rect.left + rect.width / 2, rect.top + rect.height / 2);
        });
      });

      const repeatBtn = document.getElementById('repeatBtn');
      if (repeatBtn) repeatBtn.addEventListener('click', () => {
        if (state.phase !== 'betting' || state.spinning || state.visibilityPaused) {
          showToast('Repeat on betting only', GAME_CONFIG.notificationMs);
          return;
        }

        const repeatSum = totalBet(state.previousSettledBets);
        if (!repeatSum) {
          showToast('No previous bet', GAME_CONFIG.notificationMs);
          return;
        }
        if (state.balance < repeatSum) {
          showToast('Balance too low', GAME_CONFIG.notificationMs);
          return;
        }

        state.balance -= repeatSum;
        state.bets.melon += state.previousSettledBets.melon;
        state.bets.slot += state.previousSettledBets.slot;
        state.bets.plum += state.previousSettledBets.plum;
        renderBets();
        popBalance();
        showToast('Repeated', GAME_CONFIG.notificationMs);
        const firstCard = document.querySelector('.bet-card');
        const activeChip = document.querySelector('.chip.active');
        if (firstCard && activeChip) chipFly(activeChip.getBoundingClientRect(), firstCard.getBoundingClientRect(), state.currentChip);
      });
    }

    function clearWinHighlights() {
      document.querySelectorAll('.bet-card').forEach(el => el.classList.remove('win-hit'));
      document.querySelectorAll('.seg').forEach(el => el.classList.remove('is-win'));
    }

    function highlightWin(key) {
      clearWinHighlights();
      const target = document.querySelector(`.bet-card[data-bet="${key}"]`);
      if (target) target.classList.add('win-hit');
      const winSeg = document.querySelectorAll(`.seg.${key}`);
      winSeg.forEach(el => el.classList.add('is-win'));
      if (state.highlightTimer) clearTimeout(state.highlightTimer);
      state.highlightTimer = setTimeout(() => {
        clearWinHighlights();
        state.highlightTimer = null;
      }, 1350);
    }

    function finishRound(index) {
      const result = segments[index].key;

      let won = 0;
      Object.keys(state.bets).forEach(key => {
        if (key === result) won += state.bets[key] * payoutFor(key);
      });

      state.balance += won;
      popBalance();
      state.previousSettledBets = cloneBets(state.bets);
      state.lastBets = cloneBets(state.previousSettledBets);
      state.results.push({ key: result });
      highlightWin(result);
      resetRoundBets();
      renderBets();
      renderRecent();
      state.round += 1;
      roundNo.textContent = `#${state.round}`;
      updatePhase('win', won > 0 ? 'Winner' : 'Result');
      const crazy77 = result === 'slot' && won > 0;
      winBanner.firstChild.textContent = crazy77 ? '77 Jackpot' : (won > 0 ? 'Winner' : 'Result');
      winBannerSub.textContent = crazy77 ? `Mega payout ${formatCompact(won)}` : (won > 0 ? `Payout ${formatCompact(won)}` : 'Better luck next round');
      safeBanner(winBanner, GAME_CONFIG.notificationMs);
      animateWinnerToPopup(result, document.querySelector(`.seg.${result}`) || document.querySelector(`.bet-card[data-bet="${result}"]`) || wheelWrap);
      wheelWrap.classList.add('win-celebrate');
      setTimeout(() => wheelWrap.classList.remove('win-celebrate'), result === 'slot' && won > 0 ? 2600 : 1200);
      if (won > 0) {
        runWinCelebration(result, won);
        chipsToBalance(won, result === 'slot');
      }
      state.spinning = false;
      wheelWrap.classList.remove('spinning');
      wheelWrap.classList.remove('hit-stop');
      state.settleTimer = null;
      countdown = GAME_CONFIG.bettingSeconds;
    }

    function spinWheel() {
      if (state.spinning || state.visibilityPaused) return;
      clearRoundTimers();
      clearWinHighlights();
      state.spinning = true;
      updatePhase('stop', 'Stop Bet');
      safeBanner(stopBanner, GAME_CONFIG.notificationMs);

      const index = Math.floor(Math.random() * segments.length);
      const step = 360 / segments.length;
      const targetRotation = -(index * step) - 18;
      const extraSpins = 360 * 5;
      const currentMod = ((state.rotation % 360) + 360) % 360;
      const normalized = currentMod > 180 ? currentMod - 360 : currentMod;
      state.rotation = state.rotation - extraSpins - (normalized - targetRotation);
      wheelWrap.classList.add('spinning');
      wheelInner.style.transform = `rotate(${state.rotation}deg)`;
      counter.textContent = 'GO';

      state.pointerTimer = setTimeout(() => {
        wheelWrap.classList.remove('spinning');
        wheelWrap.classList.add('hit-stop');
        setTimeout(() => wheelWrap.classList.remove('hit-stop'), 420);
        state.pointerTimer = null;
      }, 5220);

      state.settleTimer = setTimeout(() => finishRound(index), 5600);
    }

    document.getElementById('playersBtn').addEventListener('click', () => {
      if (typeof window.refreshHistoryTables === 'function') {
        window.refreshHistoryTables(true);
      }
      playersPopup.style.display = 'flex';
    });

    document.querySelectorAll('[data-close]').forEach(btn => {
      btn.addEventListener('click', () => {
        document.getElementById(btn.dataset.close).style.display = 'none';
      });
    });

    document.querySelectorAll('.popup-backdrop').forEach(pop => {
      pop.addEventListener('click', e => {
        if (e.target === pop) pop.style.display = 'none';
      });
    });


    let networkInterval = null;

    function bootSplash() {
      const steps = GAME_CONFIG.splashSteps.slice();
      let i = 0;
      splashBar.style.width = '0%';
      splashPercent.textContent = '0%';
      splashLog.textContent = steps[0];
      const splashTimer = setInterval(() => {
        i += 1;
        const percent = Math.min(100, Math.round((i / steps.length) * 100));
        splashBar.style.width = percent + '%';
        splashPercent.textContent = percent + '%';
        splashLog.textContent = steps[Math.min(i, steps.length - 1)];
        if (i >= steps.length) {
          clearInterval(splashTimer);
          setTimeout(() => {
            splashScreen.classList.add('hide');
            if (useStandalonePreview) {
              winBanner.firstChild.textContent = 'Welcome';
              winBannerSub.textContent = 'Room ready - place your chips';
              safeBanner(winBanner, GAME_CONFIG.notificationMs);
            }
          }, 260);
        }
      }, 360);
    }

    buildWheel();
    beautifyChips();
    renderRecent();
    renderBets();
    if (useStandalonePreview) {
      setNetworkMock();
      networkInterval = setInterval(setNetworkMock, 3000);
    }

    let countdown = GAME_CONFIG.bettingSeconds;

    function startCountdownLoop() {
      clearInterval(countdownTimer);
      let stopBannerShown = false;
      countdownTimer = setInterval(() => {
        if (state.spinning || state.visibilityPaused) return;

        counter.textContent = countdown <= 0 ? 'GO' : countdown;

        if (countdown > 3) {
          updatePhase('betting', 'Betting');
          stopBannerShown = false;
        } else if (countdown > 0) {
          updatePhase('stop', 'Stop Bet');
          if (!stopBannerShown) {
            showBanner(stopBanner, GAME_CONFIG.notificationMs);
            stopBannerShown = true;
          }
        }

        countdown -= 1;

        if (countdown < 0) {
          stopBannerShown = false;
          spinWheel();
        }
      }, 1000);
    }

    if (useStandalonePreview) {
      updatePhase('betting', 'Betting');
      appEl.classList.add('phase-betting');
      counter.textContent = countdown;
      showBanner(startBanner, GAME_CONFIG.notificationMs);
      startCountdownLoop();
    } else {
      updatePhase('betting', 'Sync');
      counter.textContent = '--';
    }

    document.addEventListener('visibilitychange', () => {
      state.visibilityPaused = document.hidden;
      if (!document.hidden && state.phase === 'betting' && !state.spinning) {
        counter.textContent = countdown <= 0 ? 'GO' : countdown;
      }
    });

    function stopMaxRoomAudioHandle(target, permanent = false, seen = null) {
      if (!target) return;
      if (seen && ((typeof target === 'object' && target !== null) || typeof target === 'function')) {
        if (seen.has(target)) return;
        seen.add(target);
      }
      if (target instanceof HTMLMediaElement) {
        try { target.pause(); } catch (error) {}
        try { target.currentTime = 0; } catch (error) {}
        try { target.muted = true; } catch (error) {}
        return;
      }
      if (typeof target.pause === 'function') {
        try { target.pause(); } catch (error) {}
      }
      if (typeof target.stop === 'function') {
        try { target.stop(); } catch (error) {}
      }
      if (typeof target.mute === 'function') {
        try { target.mute(true); } catch (error) {}
      }
      if (typeof target.suspend === 'function') {
        try { target.suspend(); } catch (error) {}
      }
      if (permanent && typeof target.close === 'function') {
        try { target.close(); } catch (error) {}
      }
    }

    function silenceMaxRoomAudio(permanent = false) {
      const seen = new WeakSet();
      document.querySelectorAll('audio,video').forEach((media) => stopMaxRoomAudioHandle(media, permanent, seen));
      if ('speechSynthesis' in window) {
        try { window.speechSynthesis.cancel(); } catch (error) {}
      }
      [window.Howler, window.audioCtx, window.musicCtx, window.backgroundMusic, window.roomMusic, window.roomAudio].forEach((target) => stopMaxRoomAudioHandle(target, permanent, seen));
      if (window.Howler && typeof window.Howler.stop === 'function') {
        try { window.Howler.stop(); } catch (error) {}
      }
    }

    function cleanupMaxRoom() {
      silenceMaxRoomAudio(true);
      if(window.BDGameFinal && typeof window.BDGameFinal.stopHeartbeat === 'function') window.BDGameFinal.stopHeartbeat();
      clearInterval(countdownTimer);
      if (networkInterval) clearInterval(networkInterval);
      clearRoundTimers();
      clearTimeout(showToast._t);
      document.querySelectorAll('.announce-banner').forEach(b => clearTimeout(b._t));
    }

    document.addEventListener('visibilitychange', () => {
      if (document.hidden) silenceMaxRoomAudio(false);
    });

    window.addEventListener('beforeunload', cleanupMaxRoom);
    window.addEventListener('pagehide', cleanupMaxRoom, { once: true });

    window.addEventListener('resize', () => {
      document.body.offsetHeight;
    }, { passive: true });

    bootSplash();
  </script>
  <script>
window.BD_GAME_BOOTSTRAP = {
  gameCode: @json($currentGameCode),
  gameKey: @json($currentGameCode),
  roomKey: @json($currentGameCode),
  configVersion: @json((int) config('bd_game_final.realtime.config_version', 1)),
  configUpdatedAt: @json(config('bd_game_final.realtime.config_updated_at')),
  gameToken: @json($gameToken ?? null),
  sessionToken: @json($sessionToken ?? null),
  lobbyUrl: @json($lobbyUrl ?? route('game-final.lobby')),
  userId: @json($displayUserId ?? auth()->id() ?? request()->get('user_id')),
  userName: @json($displayName),
  rules: {
    maxDistinctBoards: @json((int) ($gameRules['max_distinct_boards_per_user'] ?? 3)),
    boardCount: @json((int) ($gameRules['board_count'] ?? 3))
  },
  endpoints: {
    startToPlay: "{{ route('game-final.api.start-to-play', ['gameCode' => $currentGameCode]) }}",
    state: "{{ route('game-final.api.state', ['gameCode' => $currentGameCode]) }}",
    bet: "{{ route('game-final.api.bet', ['gameCode' => $currentGameCode]) }}",
    history: "{{ route('game-final.api.history', ['gameCode' => $currentGameCode]) }}",
    myBets: "{{ route('game-final.api.my-bets', ['gameCode' => $currentGameCode]) }}",
    heartbeat: "{{ route('game-final.api.heartbeat', ['gameCode' => $currentGameCode]) }}"
  },
  realtime: {
    mode: @json(config('bd_game_final.realtime.mode', 'polling')),
    enabled: @json(config('bd_game_final.realtime.enabled', true)),
    channel: @json(config('bd_game_final.realtime.channel_prefix', 'bdgamefinal.') . $currentGameCode),
    event: @json(config('bd_game_final.realtime.broadcast_event', 'bd.game.state')),
    pollFallbackMs: @json((int) config('bd_game_final.realtime.poll_fallback_ms', 1500)),
    websocket: {
      enabled: @json((bool) config('bd_game_final.realtime.websocket.enabled', true)),
      url: @json(config('bd_game_final.realtime.websocket.url') ?: ((request()->isSecure() ? 'wss' : 'ws') . '://' . request()->getHttpHost())),
      event: @json(config('bd_game_final.realtime.websocket.event', 'bd.game.state')),
      protocols: @json(config('bd_game_final.realtime.websocket.protocols', [])),
      reconnectMs: 1500
    },
    pusher: {
      key: @json(config('bd_game_final.realtime.pusher.key') ?: env(config('bd_game_final.realtime.pusher.key_env', 'PUSHER_APP_KEY'))),
      activeIndex: @json((int) config('bd_game_final.realtime.pusher.active_index', 0)),
      accounts: @json(config('bd_game_final.realtime.pusher.public_accounts', [])),
      options: {
        cluster: @json(config('bd_game_final.realtime.pusher.cluster') ?: env(config('bd_game_final.realtime.pusher.cluster_env', 'PUSHER_APP_CLUSTER'), 'mt1')),
        wsHost: @json(config('bd_game_final.realtime.pusher.host') ?: env(config('bd_game_final.realtime.pusher.wsHost_env', 'MIX_PUSHER_APP_HOST'), request()->getHost())),
        wsPort: @json((int) (config('bd_game_final.realtime.pusher.port') ?: env(config('bd_game_final.realtime.pusher.wsPort_env', 'MIX_PUSHER_APP_PORT'), 80))),
        wssPort: @json((int) (config('bd_game_final.realtime.pusher.port') ?: env(config('bd_game_final.realtime.pusher.wssPort_env', 'MIX_PUSHER_APP_PORT'), 443))),
        forceTLS: @json((bool) config('bd_game_final.realtime.pusher.forceTLS', true)),
        encrypted: @json((bool) config('bd_game_final.realtime.pusher.encrypted', true)),
        enabledTransports: @json(config('bd_game_final.realtime.pusher.enabledTransports', ['ws','wss']))
      }
    }
  }
};
  </script>
  <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
  <script src="{{ asset('game_final_assets/game_final_bridge.js') }}"></script>
  <script>
  (function(){
    if (useStandalonePreview) {
      return;
    }
    if (!window.BDGameFinal || !window.BD_GAME_BOOTSTRAP || window.BD_GAME_BOOTSTRAP.gameCode !== currentGameCode) {
      return;
    }

    const api = window.BDGameFinal;
    const boardKeys = ['melon', 'slot', 'plum'];
    const LIVE_SEQUENCE = {
      startPopupMs: 3000,
      stopPopupMs: 3000,
      revealSpinMs: 4200,
      revealHoldMs: 300,
      resultPopupMs: 3000,
      payoutLeadMs: 1000,
      payoutMs: 2000
    };
    let authoritativeRoundNo = null;
    let serverClockOffsetSec = 0;
    let serverClockKey = '';
    let lastPhaseKey = '';
    let lastResultKey = '';
    let lastSpinKey = '';
    let lastAnimatedPayoutKey = '';
    let activePayoutAnimationKey = '';
    let refreshInFlight = false;
    let requestCounter = 0;
    let heartbeatTimer = null;
    let statePollTimer = null;
    let mirrorTimer = null;
    let lastNetworkMs = 0;
    let displayedBalanceValue = null;
    let boardHistoryRows = [];
    let userHistoryRows = [];
    let activePlayerRows = [];
    const historyBoardKeys = ['melon', 'slot', 'plum'];
    let historySyncInFlight = false;
    let lastHistorySyncRound = '';
    const pendingBets = new Map();
    function markPendingBet(kind, delta) {
      const nextCount = Math.max(0, (pendingBets.get(kind) || 0) + delta);
      if (nextCount > 0) pendingBets.set(kind, nextCount);
      else pendingBets.delete(kind);
    }

    clearInterval(countdownTimer);
    countdownTimer = null;
    if (networkInterval) {
      clearInterval(networkInterval);
      networkInterval = null;
    }
    clearRoundTimers();
    clearWinHighlights();
    state.results = [];
    state.spinning = false;
    state.phase = 'idle';
    roundNo.textContent = '-';
    networkStat.textContent = 'sync';
    networkStat.style.color = '#FFD55E';
    counter.textContent = '--';

    function serverNow() {
      return (Date.now() / 1000) + serverClockOffsetSec;
    }

    function formatRound(roundNoValue) {
      if (!roundNoValue) return '-';
      const parts = String(roundNoValue).split('_');
      const value = parts[parts.length - 1];
      if (/^\d{7,}$/.test(value)) {
        return value.slice(-3).replace(/^0+/, '') || '0';
      }
      return value;
    }

    function mapRecentItem(key) {
      return recentItemView(key);
    }

    function escapeHtml(value) {
      return String(value == null ? '' : value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
    }

    function historyBoardMarkup(boardKey) {
      const view = mapRecentItem(boardKey);
      return `
        <div class="history-board">
          ${historyBoardToken(boardKey)}
          <span>${escapeHtml(view.label)}</span>
        </div>
      `;
    }

    function historyBoardToken(boardKey) {
      const view = mapRecentItem(boardKey);
      const keyClass = String(boardKey || '') === 'slot' ? ' slot' : '';
      return `<span class="history-board-token${keyClass}" title="${escapeHtml(view.label)}" aria-label="${escapeHtml(view.label)}"><span class="${view.className}">${view.html}</span></span>`;
    }

    function historyBoardHeaderCells() {
      return historyBoardKeys.map((boardKey) => `<th class="history-board-label">${escapeHtml(mapRecentItem(boardKey).label)}</th>`).join('');
    }

    function historyWinnerKeyFromItem(item) {
      return String(item && (item.winner_board_key || item.winner_board || item.board_key || item.resultKey || item.result) || item || '');
    }

    function historyWinnerBoardCells(item) {
      const winnerKey = historyWinnerKeyFromItem(item);
      return historyBoardKeys.map((boardKey) => {
        const isWinner = boardKey === winnerKey;
        const title = `${mapRecentItem(boardKey).label}${isWinner ? ' winner' : ''}`;
        return `<td class="history-board-token-cell${isWinner ? ' is-winner' : ''}" title="${escapeHtml(title)}">${isWinner ? historyBoardToken(boardKey) : ''}</td>`;
      }).join('');
    }

    function historyRoundLabel(value) {
      if (value && typeof value === 'object') {
        value = value.round_short || value.trace_short || value.round_no || value.round_id || value.trace_id || '-';
      }
      const raw = String(value || '-');
      const tail = raw.split('_').pop() || raw;
      if (/^\d{7,}$/.test(tail)) return tail.slice(-6);
      return raw.length > 10 ? raw.slice(-10) : raw;
    }

    function historyOutcomeBadge(item) {
      const outcome = String(item && (item.user_outcome || item.status) || 'no_bid').toLowerCase();
      const statusClass = outcome === 'won' ? 'win' : (outcome === 'lost' ? 'loss' : (outcome === 'punishment' ? 'punishment' : 'pending'));
      const label = outcome === 'won'
        ? `WIN +${formatCompact(item && (item.user_win_amount || item.win_amount) || 0)}`
        : (outcome === 'lost' ? 'LOSS' : (outcome === 'punishment' ? `PUNISH -${formatCompact(Math.abs(Number(item && (item.result_amount || item.amount) || 0)))}` : 'NO BID'));
      return `<span class="history-status ${statusClass}">${escapeHtml(label)}</span>`;
    }

    function renderActivePlayers() {
      if (!activePlayersList) return;
      const rows = Array.isArray(activePlayerRows) ? activePlayerRows : [];
      activePlayersList.innerHTML = rows.length ? rows.map((player, index) => {
        const name = String(player && (player.name || player.username || player.display_name || player.user_name) || `Player ${index + 1}`);
        const image = String(player && (player.image || player.avatar || player.profile_image || player.photo || player.user_image) || '');
        const initial = String(player && player.initial || name.charAt(0) || 'P').slice(0, 2).toUpperCase();
        const avatar = image ? `<img src="${escapeHtml(image)}" alt="${escapeHtml(name)}">` : escapeHtml(initial);
        const label = player && player.is_me ? 'YOU' : `Win ${formatCompact(player && player.game_win_amount || 0)}`;
        return `<div class="winner-card"><div class="ava">${avatar}</div><div class="winner-details"><div class="winner-name">${escapeHtml(name)}</div><div class="winner-stats">${escapeHtml(label)}</div></div></div>`;
      }).join('') : '<div class="history-empty">No active players yet</div>';
    }

    function renderHistoryTables() {
      renderActivePlayers();
      if (historyBoardsTable) {
        historyBoardsTable.innerHTML = boardHistoryRows.length ? `
          <table class="history-table history-board-matrix">
            <thead><tr><th>Round</th>${historyBoardHeaderCells()}<th>You</th></tr></thead>
            <tbody>${boardHistoryRows.map((item) => `
              <tr>
                <td class="history-trace">${escapeHtml(historyRoundLabel(item))}</td>
                ${historyWinnerBoardCells(item)}
                <td>${historyOutcomeBadge(item)}</td>
              </tr>
            `).join('')}</tbody>
          </table>
        ` : '<div class="history-empty">Waiting for live rounds</div>';
      }
      if (historyUserTable) {
        historyUserTable.innerHTML = userHistoryRows.length ? `
          <table class="history-table">
            <thead><tr><th>Trace</th><th>Round</th><th>Board</th><th>Bid</th><th>Result</th></tr></thead>
            <tbody>${userHistoryRows.map((item) => {
              const status = String(item && item.status || 'pending').toLowerCase();
              const statusClass = status === 'won' ? 'win' : (status === 'lost' ? 'loss' : (status === 'punishment' ? 'punishment' : 'pending'));
              const resultText = status === 'won'
                ? `WIN +${formatCompact(item && item.win_amount || 0)}`
                : (status === 'lost' ? `LOSS -${formatCompact(item && item.amount || 0)}` : (status === 'punishment' ? `PUNISH -${formatCompact(Math.abs(Number(item && (item.result_amount || item.amount) || 0)))}` : 'PENDING'));
              return `
                <tr>
                  <td class="history-trace">${escapeHtml(historyRoundLabel(item && (item.trace_short || item.trace_id) || '-'))}</td>
                  <td class="history-trace">${escapeHtml(historyRoundLabel(item))}</td>
                  <td>${historyBoardMarkup(item && (item.board_key || item.frontend_board_key) || '')}</td>
                  <td>${escapeHtml(formatCompact(item && item.amount || 0))}</td>
                  <td><span class="history-status ${statusClass}">${escapeHtml(resultText)}</span></td>
                </tr>
              `;
            }).join('')}</tbody>
          </table>
        ` : '<div class="history-empty">Place a bet to build your history</div>';
      }
    }

    async function refreshHistoryTables(force = false) {
      if (!(window.BDGameFinal && window.BD_GAME_BOOTSTRAP && window.BD_GAME_BOOTSTRAP.gameCode === currentGameCode)) {
        renderHistoryTables();
        return;
      }
      if (historySyncInFlight) {
        return;
      }
      if (!force && !window.BD_GAME_BOOTSTRAP.endpoints) {
        return;
      }
      historySyncInFlight = true;
      try {
        const [historyPayload, myBetsPayload] = await Promise.all([
          window.BDGameFinal.get(window.BD_GAME_BOOTSTRAP.endpoints.history, {}),
          window.BDGameFinal.get(window.BD_GAME_BOOTSTRAP.endpoints.myBets, {}),
        ]);
        boardHistoryRows = Array.isArray(historyPayload && (historyPayload.board_history || historyPayload.recent))
          ? (historyPayload.board_history || historyPayload.recent)
          : [];
        userHistoryRows = Array.isArray(myBetsPayload && (myBetsPayload.bet_history || myBetsPayload.history))
          ? (myBetsPayload.bet_history || myBetsPayload.history)
          : [];
        activePlayerRows = Array.isArray(historyPayload && historyPayload.active_players)
          ? historyPayload.active_players
          : (Array.isArray(myBetsPayload && myBetsPayload.active_players) ? myBetsPayload.active_players : activePlayerRows);
      } catch (error) {
        if (!boardHistoryRows.length && !userHistoryRows.length) {
          boardHistoryRows = [];
          userHistoryRows = [];
        }
      } finally {
        historySyncInFlight = false;
        renderHistoryTables();
      }
    }

    window.refreshHistoryTables = refreshHistoryTables;

    function maxDistinctBoards(payload) {
      const fromPayload = Number(payload && payload.rules && payload.rules.max_distinct_boards_per_user || 0);
      const fromBootstrap = Number(window.BD_GAME_BOOTSTRAP.rules && window.BD_GAME_BOOTSTRAP.rules.maxDistinctBoards || 0);
      return Math.max(1, Math.min(3, fromPayload || fromBootstrap || 3));
    }

    function currentDistinctBoardCount(payload) {
      const totals = payload && payload.my_bet_totals ? payload.my_bet_totals : state.bets;
      return boardKeys.filter((key) => Number(totals && totals[key] || 0) > 0).length;
    }

    function canUseBoard(payload, boardKey) {
      const currentTotal = Number(payload && payload.my_bet_totals && payload.my_bet_totals[boardKey] || state.bets && state.bets[boardKey] || 0);
      return currentTotal > 0 || currentDistinctBoardCount(payload) < maxDistinctBoards(payload);
    }

    function optimisticBetPayload(payload, boardKey, amount, balanceValue = null) {
      if (!payload || !boardKey || !Number.isFinite(Number(amount))) return null;
      const betAmount = Number(amount || 0);
      const next = Object.assign({}, payload);
      next.board_totals = Object.assign({}, payload.board_totals || {});
      next.my_bet_totals = Object.assign({}, payload.my_bet_totals || {});
      next.board_totals[boardKey] = Number(next.board_totals[boardKey] || 0) + betAmount;
      next.my_bet_totals[boardKey] = Number(next.my_bet_totals[boardKey] || 0) + betAmount;
      next.my_total_bet_amount = Number(payload.my_total_bet_amount || 0) + betAmount;
      next.balance = balanceValue === null ? Math.max(0, Number(payload.balance || 0) - betAmount) : Number(balanceValue || 0);
      return next;
    }

    function boardLimitMessage(payload) {
      const limit = maxDistinctBoards(payload);
      return `This room allows ${limit} distinct ${limit === 1 ? 'lane' : 'lanes'} per round.`;
    }

    function resolveWinnerKey(payload) {
      return payload && (payload.winner_board || (payload.result && payload.result.winner_board) || (payload.result && payload.result.landing_key));
    }

    function resolveDisplayedWinAmount(payload, winner) {
      const winnerKey = winner || resolveWinnerKey(payload);
      const actualWinAmount = Number(payload && payload.my_total_win_amount || 0);
      if (actualWinAmount > 0) return actualWinAmount;
      const winnerBet = Number(payload && payload.my_bet_totals && payload.my_bet_totals[winnerKey] || 0);
      return winnerBet > 0 ? winnerBet * payoutFor(winnerKey, payload) : 0;
    }

    function payoutAnimationKey(payload, winner, winAmount) {
      return `${payload && payload.round_no ? payload.round_no : 'na'}:${winner || 'na'}:${Number(winAmount || 0)}`;
    }

    function phaseStartedAt(payload, phase) {
      if (!payload) return null;
      if (phase === 'betting') return payload.start_at || payload.bet_countdown_start_at || null;
      if (phase === 'locked') return payload.bet_close_at || null;
      if (phase === 'revealed') return payload.reveal_at || null;
      if (phase === 'settled') return payload.settle_at || null;
      return null;
    }

    function phaseElapsedMs(payload, phase) {
      const startedAt = phaseStartedAt(payload, phase);
      if (!startedAt) return 0;
      return Math.max(0, Math.round((serverNow() - startedAt) * 1000));
    }

    function setNetwork(status, text) {
      networkStat.textContent = text;
      networkStat.style.color = status === 'good' ? '#7CFF8C' : (status === 'warn' ? '#FFD55E' : '#FF8B8B');
      if (status === 'bad') {
        networkBannerSub.textContent = text === 'expired' ? 'Session expired' : `Connection ${text}`;
        safeBanner(networkBanner, GAME_CONFIG.notificationMs);
      }
    }

    function setDisplayedBalance(value, commitState = true) {
      displayedBalanceValue = Math.max(0, Number(value || 0));
      balanceEl.textContent = balanceNumber(displayedBalanceValue);
      if (commitState) {
        state.balance = displayedBalanceValue;
      }
    }

    function animateDisplayedBalance(startValue, endValue, durationMs) {
      const from = Number(startValue || 0);
      const to = Number(endValue || 0);
      if (from === to) {
        setDisplayedBalance(to);
        return Promise.resolve();
      }
      const startedAt = performance.now();
      return new Promise((resolve) => {
        function tick(now) {
          const progress = Math.min(1, (now - startedAt) / durationMs);
          const current = Math.round(from + ((to - from) * progress));
          setDisplayedBalance(current, false);
          if (progress < 1) {
            window.requestAnimationFrame(tick);
            return;
          }
          setDisplayedBalance(to);
          resolve();
        }
        window.requestAnimationFrame(tick);
      });
    }

    function syncBalanceDisplay(payload) {
      const finalBalance = Number(payload && payload.balance || 0);
      const winner = resolveWinnerKey(payload);
      const winAmount = resolveDisplayedWinAmount(payload, winner);
      const payoutKey = payoutAnimationKey(payload, winner, winAmount);
      if (activePayoutAnimationKey && payoutKey === activePayoutAnimationKey) {
        return;
      }
      if (payload && payload.phase === 'settled' && winAmount > 0 && payoutKey !== lastAnimatedPayoutKey) {
        setDisplayedBalance(Math.max(0, finalBalance - winAmount));
        return;
      }
      setDisplayedBalance(finalBalance);
    }

    function setWheelRotation(value) {
      state.rotation = value;
      wheelInner.style.transition = 'none';
      wheelInner.style.transform = `rotate(${value}deg)`;
      void wheelInner.offsetWidth;
    }

    function animateWheelRotation(value, durationMs) {
      state.rotation = value;
      wheelInner.style.transition = `transform ${Math.max(180, durationMs)}ms cubic-bezier(.08,.88,.12,1)`;
      wheelWrap.classList.add('spinning');
      wheelInner.style.transform = `rotate(${value}deg)`;
      if (state.pointerTimer) {
        clearTimeout(state.pointerTimer);
      }
      state.pointerTimer = setTimeout(() => {
        wheelWrap.classList.remove('spinning');
        wheelWrap.classList.add('hit-stop');
        setTimeout(() => wheelWrap.classList.remove('hit-stop'), 420);
        state.pointerTimer = null;
      }, Math.max(180, durationMs - 220));
    }

    function setCounterFromState(payload) {
      const clockKey = `${payload.round_no || 'na'}:${payload.phase || 'na'}`;
      if (typeof payload.server_time === 'number' && (clockKey !== serverClockKey || !serverClockKey)) {
        serverClockOffsetSec = payload.server_time - (Date.now() / 1000);
        serverClockKey = clockKey;
      }
      if (payload.phase === 'betting' && payload.bet_close_at) {
        const seconds = Math.max(0, Math.ceil(payload.bet_close_at - serverNow()));
        countdown = seconds;
        counter.classList.toggle('timer-hidden', seconds <= 0);
        counter.textContent = seconds > 0 ? String(seconds) : '';
        return;
      }
      if (payload.phase === 'locked') {
        counter.classList.add('timer-hidden');
        counter.textContent = '';
        return;
      }
      if (payload.phase === 'revealed' || payload.phase === 'settled') {
        counter.classList.add('timer-hidden');
        counter.textContent = '';
        return;
      }
      counter.classList.add('timer-hidden');
      counter.textContent = '';
    }

    function winningSegmentIndex(payload, winner) {
      const matchIndices = segments.reduce((acc, segment, index) => {
        if (segment.key === winner) acc.push(index);
        return acc;
      }, []);
      if (!matchIndices.length) return 0;
      const seed = Math.abs(Number(payload && payload.result && payload.result.spin_seed || 0));
      return matchIndices[seed % matchIndices.length];
    }

    function spinWheelToWinner(payload, immediate = false, minimumTurns = 5, durationMs = LIVE_SEQUENCE.revealSpinMs) {
      const winner = resolveWinnerKey(payload);
      if (!winner) return;
      const spinKey = `${payload.round_no || 'na'}:${winner}`;
      const targetIndex = winningSegmentIndex(payload, winner);
      const step = 360 / segments.length;
      const currentMod = ((state.rotation % 360) + 360) % 360;
      const currentSigned = currentMod > 180 ? currentMod - 360 : currentMod;
      const fullTurns = immediate ? 0 : Math.max(1, Number(minimumTurns || 1));
      const finalRotation = currentSigned - 360 * fullTurns - (targetIndex * step);

      if (!immediate && spinKey === lastSpinKey) return targetIndex;
      lastSpinKey = spinKey;

      if (immediate) {
        wheelWrap.classList.remove('spinning');
        setWheelRotation(finalRotation);
        return targetIndex;
      }

      state.spinning = true;
      animateWheelRotation(finalRotation, durationMs);
      return targetIndex;
    }

    function renderServerResult(payload) {
      const winner = resolveWinnerKey(payload);
      if (!winner) return;
      const resultKey = `${payload.round_no || 'na'}:${winner}`;
      if (resultKey === lastResultKey) return;
      lastResultKey = resultKey;

      highlightWin(winner);
      const winAmount = resolveDisplayedWinAmount(payload, winner);
      runWinCelebration(winner, winAmount);
      winBanner.firstChild.textContent = winner === 'slot' && winAmount > 0 ? '77 Jackpot' : (winAmount > 0 ? 'Winner' : 'Result');
      winBannerSub.textContent = winAmount > 0 ? `Payout ${formatCompact(winAmount)}` : `${mapRecentItem(winner).label} landed`;
      safeBanner(winBanner, LIVE_SEQUENCE.resultPopupMs);
      animateWinnerToPopup(winner, document.querySelector(`.seg.${winner}`) || document.querySelector(`.bet-card[data-bet="${winner}"]`) || wheelWrap);
    }

    function runAuthoritativePayoutAnimation(payload) {
      const winner = resolveWinnerKey(payload);
      const winAmount = resolveDisplayedWinAmount(payload, winner);
      const finalBalance = Number(payload && payload.balance || 0);
      const payoutKey = payoutAnimationKey(payload, winner, winAmount);
      if (!winner || winAmount <= 0 || payoutKey === lastAnimatedPayoutKey) {
        setDisplayedBalance(finalBalance);
        return;
      }
      activePayoutAnimationKey = payoutKey;
      chipsToBalance(winAmount, winner === 'slot');
      animateDisplayedBalance(displayedBalanceValue != null ? displayedBalanceValue : Math.max(0, finalBalance - winAmount), finalBalance, LIVE_SEQUENCE.payoutMs).then(() => {
        popBalance();
        lastAnimatedPayoutKey = payoutKey;
        activePayoutAnimationKey = '';
      });
    }

    function setPhaseFromState(payload) {
      const phaseKey = `${payload.round_no || 'na'}:${payload.phase || 'na'}`;
      const changed = phaseKey !== lastPhaseKey;
      lastPhaseKey = phaseKey;

      if (payload.phase === 'betting') {
        state.phase = 'betting';
        state.spinning = false;
        if (changed) {
          clearWinHighlights();
          wheelWrap.classList.remove('spinning', 'hit-stop', 'win-celebrate', 'jackpot77');
          safeBanner(startBanner, LIVE_SEQUENCE.startPopupMs);
        }
        updatePhase('betting', 'Betting');
        return;
      }

      if (payload.phase === 'locked') {
        state.phase = 'stop';
        state.spinning = false;
        updatePhase('stop', 'Stop Bet');
        if (changed) {
          safeBanner(stopBanner, LIVE_SEQUENCE.stopPopupMs);
        }
        return;
      }

      if (payload.phase === 'revealed' || payload.phase === 'settled') {
        state.phase = 'win';
        updatePhase('win', 'Result');
        return;
      }

      state.phase = 'idle';
      state.spinning = false;
    }

    function applyState(payload) {
      sharedRoomState.lastStatePayload = payload;
      authoritativeRoundNo = payload.round_no || authoritativeRoundNo;
      activePlayerRows = Array.isArray(payload.active_players) ? payload.active_players : activePlayerRows;
      renderActivePlayers();
      if (Array.isArray(payload.recent) && payload.recent.length && !boardHistoryRows.length) {
        boardHistoryRows = payload.recent;
        renderHistoryTables();
      }
      if (payload.phase === 'settled') {
        const historyRound = String(payload.round_no || '');
        if (historyRound && historyRound !== lastHistorySyncRound) {
          lastHistorySyncRound = historyRound;
          refreshHistoryTables();
        }
      } else if (payload.phase === 'betting') {
        lastHistorySyncRound = '';
      }
      syncBalanceDisplay(payload);
      state.bets = {
        melon: Number(payload.my_bet_totals && payload.my_bet_totals.melon || 0),
        slot: Number(payload.my_bet_totals && payload.my_bet_totals.slot || 0),
        plum: Number(payload.my_bet_totals && payload.my_bet_totals.plum || 0),
      };
      state.boardTotals = {
        melon: Number(payload.board_totals && payload.board_totals.melon || 0),
        slot: Number(payload.board_totals && payload.board_totals.slot || 0),
        plum: Number(payload.board_totals && payload.board_totals.plum || 0),
      };
      if (payload.phase === 'settled') {
        state.previousSettledBets = cloneBets(state.bets);
        state.lastBets = cloneBets(state.bets);
      }
      state.results = (payload.recent || []).map((item) => ({ key: item && item.winner_board_key ? item.winner_board_key : item }));
      renderBets();
      renderRecent();
      roundNo.textContent = payload.round_no ? `#${formatRound(payload.round_no)}` : '-';
      setCounterFromState(payload);
      setPhaseFromState(payload);

      const winner = resolveWinnerKey(payload);
      if ((payload.phase === 'revealed' || payload.phase === 'settled') && winner) {
        const immediate = payload.phase === 'settled' && phaseElapsedMs(payload, 'settled') > LIVE_SEQUENCE.revealSpinMs;
        spinWheelToWinner(payload, immediate, immediate ? 0 : 5, immediate ? 240 : LIVE_SEQUENCE.revealSpinMs);
        renderServerResult(payload);
        if (payload.phase === 'settled') {
          const elapsed = phaseElapsedMs(payload, 'settled');
          if (elapsed >= LIVE_SEQUENCE.payoutLeadMs) {
            runAuthoritativePayoutAnimation(payload);
          } else {
            setTimeout(() => runAuthoritativePayoutAnimation(payload), Math.max(0, LIVE_SEQUENCE.payoutLeadMs - elapsed));
          }
        }
      }
    }

    function mapBetError(message) {
      const map = {
        invalid_session: 'Session expired. Rejoin the room.',
        bet_closed: 'Bet closed. Wait for next round.',
        insufficient_balance: 'Not enough coins',
        duplicate_request: 'Duplicate bet ignored',
        max_distinct_board_limit: 'All betting spots already used',
        bet_amount_out_of_range: 'Bet amount out of range',
        invalid_board: 'Invalid board'
      };
      return map[message] || 'Bet failed. Try again.';
    }

    async function refreshState() {
      if (refreshInFlight) return;
      refreshInFlight = true;
      const startedAt = performance.now();
      try {
        const payload = await api.get(window.BD_GAME_BOOTSTRAP.endpoints.state, {});
        lastNetworkMs = Math.max(1, Math.round(performance.now() - startedAt));
        setNetwork(lastNetworkMs < 400 ? 'good' : 'warn', `${lastNetworkMs}ms`);
        if (payload && payload.st) {
          applyState(payload);
        } else {
          setNetwork('bad', 'retry');
        }
      } catch (error) {
        setNetwork('bad', 'retry');
      } finally {
        refreshInFlight = false;
      }
    }

    async function submitLiveBet(kind, card, event) {
        if (event) {
          event.preventDefault();
          event.stopPropagation();
        }
        if (!kind) return;
        if (state.phase !== 'betting' || state.spinning || state.visibilityPaused) {
          showToast('Wait for next round');
          return;
        }
        if (state.balance < state.currentChip) {
          showToast('Not enough coins');
          return;
        }
        if (!canUseBoard(sharedRoomState.lastStatePayload, kind)) {
          showToast(boardLimitMessage(sharedRoomState.lastStatePayload));
          return;
        }

        const amount = state.currentChip;
        const rect = card.getBoundingClientRect();
        const activeChip = document.querySelector('.chip.active');
        if (activeChip) chipFly(activeChip.getBoundingClientRect(), rect, amount);
        card.classList.remove('touching');
        void card.offsetWidth;
        card.classList.add('touching');
        setTimeout(() => card.classList.remove('touching'), 380);
        const appRect = appEl.getBoundingClientRect();
        makeTouchRing(rect.left + rect.width / 2 - appRect.left, rect.top + rect.height / 2 - appRect.top, 'bet-touch-ring');
        burst(rect.left + rect.width / 2, rect.top + rect.height / 2);

        markPendingBet(kind, 1);
        const optimisticPayload = optimisticBetPayload(sharedRoomState.lastStatePayload, kind, amount);
        if (optimisticPayload) applyState(optimisticPayload);
        try {
          const response = await api.post(window.BD_GAME_BOOTSTRAP.endpoints.bet, {
            round_no: authoritativeRoundNo,
            board_key: kind,
            amount,
            request_uid: `${window.BD_GAME_BOOTSTRAP.gameCode}-${Date.now()}-${++requestCounter}-${kind}`,
          });
          if (response && response.st) {
            if (response.balance !== undefined && sharedRoomState.lastStatePayload) {
              applyState(Object.assign({}, sharedRoomState.lastStatePayload, { balance: Number(response.balance || 0) }));
            }
            window.setTimeout(() => {
              refreshState();
              refreshHistoryTables(true);
            }, 60);
            return;
          }
          refreshState();
          showToast(mapBetError(response && (response.msg || response.error)));
        } catch (error) {
          refreshState();
          showToast('Bet failed. Try again.');
        } finally {
          markPendingBet(kind, -1);
          renderBets();
        }
    }
    function bindReliableBetCard(card) {
      if (!card) return;
      card.style.touchAction = 'manipulation';
      const run = (event) => submitLiveBet(card.dataset.bet, card, event);
      if (window.PointerEvent) {
        card.addEventListener('pointerup', (event) => {
          if (event.pointerType === 'mouse' && event.button !== 0) return;
          run(event);
        }, { passive: false });
      } else {
        card.addEventListener('touchend', run, { passive: false });
        card.addEventListener('click', run, { passive: false });
      }
      card.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' || event.key === ' ') run(event);
      });
    }
    document.querySelectorAll('.bet-card[data-bet]').forEach((card) => {
      bindReliableBetCard(card);
    });

    const liveRepeatBtn = document.getElementById('repeatBtn');
    if (liveRepeatBtn) liveRepeatBtn.addEventListener('click', async () => {
      if (state.phase !== 'betting' || state.spinning || state.visibilityPaused) {
        showToast('Repeat on betting only');
        return;
      }
      const entries = boardKeys.filter((key) => Number(state.previousSettledBets[key] || 0) > 0).map((key) => [key, Number(state.previousSettledBets[key])]);
      if (!entries.length) {
        showToast('No previous bet');
        return;
      }
      const repeatSum = entries.reduce((sum, entry) => sum + entry[1], 0);
      if (state.balance < repeatSum) {
        showToast('Balance too low');
        return;
      }
      try {
        for (const [kind, amount] of entries) {
          const response = await api.post(window.BD_GAME_BOOTSTRAP.endpoints.bet, {
            round_no: authoritativeRoundNo,
            board_key: kind,
            amount,
            request_uid: `${window.BD_GAME_BOOTSTRAP.gameCode}-${Date.now()}-${++requestCounter}-${kind}-repeat`,
          });
          if (!(response && response.st)) {
            showToast(mapBetError(response && (response.msg || response.error)));
            return;
          }
        }
        showToast('Repeated');
        await refreshState();
        refreshHistoryTables(true);
      } catch (error) {
        showToast('Repeat failed. Try again.');
      }
    });

    api.onState(function(payload) {
      if (payload && payload.st) {
        applyState(payload);
      }
    });

    if (typeof api.onConnection === 'function') {
      api.onConnection(function(detail) {
        if (!detail) return;
        if (detail.status === 'pending') setNetwork('warn', 'sync');
        if (detail.status === 'error') setNetwork('bad', 'retry');
        if (detail.status === 'expired') {
          setNetwork('bad', 'expired');
          showToast('Session expired. Rejoin room.', 2200);
        }
      });
    }

    if (typeof api.startHeartbeat === 'function') {
      api.startHeartbeat(15000, function(){ return lastNetworkMs || 0; });
    } else {
      heartbeatTimer = setInterval(function() {
        if (typeof api.heartbeat === 'function') {
          api.heartbeat(lastNetworkMs || 0);
        } else {
          api.post(window.BD_GAME_BOOTSTRAP.endpoints.heartbeat, { network_ms: lastNetworkMs || 0 });
        }
      }, 15000);
    }
    statePollTimer = null;
    mirrorTimer = setInterval(function() {
      if (sharedRoomState.lastStatePayload) {
        setCounterFromState(sharedRoomState.lastStatePayload);
      }
    }, 250);
    renderHistoryTables();
    refreshHistoryTables(true);
    refreshState();
    function cleanupMaxLiveBridge(){
      if (typeof api.stopHeartbeat === 'function') api.stopHeartbeat();
      if (heartbeatTimer) clearInterval(heartbeatTimer);
      if (statePollTimer) clearInterval(statePollTimer);
      if (mirrorTimer) clearInterval(mirrorTimer);
      heartbeatTimer = null;
      statePollTimer = null;
      mirrorTimer = null;
    }
    window.addEventListener('pagehide', cleanupMaxLiveBridge, { once: true });
    window.addEventListener('beforeunload', cleanupMaxLiveBridge, { once: true });
  })();
  </script>
</body>
</html>

