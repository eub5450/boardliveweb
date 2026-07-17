@php
  $currentGameCode = $gameCode ?? 'fruit_slot_arcade';
  $gameTheme = is_array($gameTheme ?? null) ? $gameTheme : [];
  $currentGameName = config('bd_game_final.games.' . $currentGameCode . '.name', 'Fruit Slot Neon Arcade');
  $assetBase = asset('game_final_assets/fruit_slot_arcade/png_assets');
  $wheelAsset = $assetBase . '/03_lucky_wheel_full_transparent.webp';
  $wheelPointerAsset = $assetBase . '/05_wheel_top_pointer_gem.webp';
  $wheelCenterAsset = $assetBase . '/04_wheel_center_badge_lucky_77.webp';
  $symbolImageMap = [
    'apple' => $assetBase . '/35_symbol_yellow_lemon.webp',
    'watermelon' => $assetBase . '/30_symbol_red_7.webp',
    'cherry' => $assetBase . '/36_symbol_red_cherries.webp',
    'banana' => $assetBase . '/31_symbol_gold_bell.webp',
    'grapes' => $assetBase . '/34_symbol_purple_grapes.webp',
    'orange' => $assetBase . '/37_symbol_gold_star.webp',
    'mango' => $assetBase . '/33_symbol_gold_crown.webp',
    'pineapple' => $assetBase . '/32_symbol_green_clover.webp',
  ];
  $chipImageMap = [
    100 => $assetBase . '/60_chip_1m_blue.webp',
    500 => $assetBase . '/61_chip_2_5m_purple.webp',
    1000 => $assetBase . '/62_chip_5m_red_selected.webp',
    5000 => $assetBase . '/63_chip_10m_gold.webp',
    10000 => $assetBase . '/64_chip_50m_green.webp',
  ];
  $tokenMap = ['apple' => '🍎', 'watermelon' => '🍉', 'cherry' => '🍒', 'banana' => '🍌', 'grapes' => '🍇', 'orange' => '🍊', 'mango' => '🥭', 'pineapple' => '🍍'];
  $boardProfiles = [];
  $boardRules = (array) ($gameRules['boards'] ?? config('bd_game_final.games.' . $currentGameCode . '.boards', []));
  foreach ($boardRules as $board) {
    $key = (string) ($board['frontend_key'] ?? $board['canonical_key'] ?? 'slot');
    $multiplier = rtrim(rtrim(number_format((float) ($board['multiplier'] ?? 0), 2, '.', ''), '0'), '.');
    $boardProfiles[$key] = [
      'name' => strtoupper((string) ($board['display_name'] ?? $key)),
      'token' => $tokenMap[$key] ?? strtoupper(substr($key, 0, 2)),
      'multiplier' => 'x' . $multiplier,
      'image' => $symbolImageMap[$key] ?? ($assetBase . '/37_symbol_gold_star.webp'),
    ];
  }
  $chipValues = [100, 500, 1000, 5000, 10000];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover" />
<meta name="theme-color" content="#050918" />
<title>Fruit Slot Arcade · Pixel Vault</title>
<style>
:root{--safe-top:max(env(safe-area-inset-top),8px);--safe-right:max(env(safe-area-inset-right),8px);--safe-bottom:max(env(safe-area-inset-bottom),8px);--safe-left:max(env(safe-area-inset-left),8px);--topbar-h:68px;--chip-dock-h:78px}
*{box-sizing:border-box;margin:0;padding:0;-webkit-tap-highlight-color:transparent}
html,body{width:100%;height:100%;overflow:hidden;background:#020613;color:#def7ff;font-family:"Courier New",monospace}
body{background:radial-gradient(circle at 50% 0, rgba(94,255,214,.16), transparent 22%),linear-gradient(180deg,#112b72 0%,#050918 62%,#01020a 100%)}
.app{position:fixed;inset:0;overflow:hidden}
.app:before{content:"";position:absolute;inset:0;background:repeating-linear-gradient(180deg,rgba(255,255,255,.03) 0 1px,transparent 1px 4px);mix-blend-mode:screen;pointer-events:none;opacity:.28}
.topbar{position:absolute;top:0;left:0;right:0;height:calc(var(--topbar-h) + var(--safe-top));padding:max(10px,var(--safe-top)) max(12px,var(--safe-right)) 10px max(12px,var(--safe-left));display:flex;align-items:center;justify-content:space-between;background:linear-gradient(180deg,rgba(1,5,18,.96),rgba(3,9,28,.84));border-bottom:2px solid rgba(94,255,214,.28);box-shadow:0 14px 36px rgba(0,0,0,.34);z-index:5;gap:10px}
.panel{min-width:112px;height:46px;padding:0 12px;border-radius:10px;display:flex;align-items:center;gap:8px;background:linear-gradient(180deg,rgba(18,43,101,.92),rgba(5,13,36,.96));border:2px solid rgba(94,255,214,.22);box-shadow:inset 0 0 0 2px rgba(255,255,255,.03),0 10px 24px rgba(0,0,0,.28)}
.panel,.marquee,.result-stage,.cab,.chip,.history-card{position:relative;overflow:hidden;backdrop-filter:blur(18px) saturate(126%);-webkit-backdrop-filter:blur(18px) saturate(126%)}
.panel:before,.marquee:before,.result-stage:before,.cab:before,.history-card:before{content:"";position:absolute;inset:0;background:linear-gradient(118deg, rgba(255,255,255,.16), rgba(255,255,255,.05) 34%, transparent 62%);opacity:.34;pointer-events:none}
.panel strong{font-size:18px;font-weight:1000;color:#f7ff8a}
.brand{text-align:center}
.brand b{display:block;font-size:16px;letter-spacing:.18em;text-transform:uppercase;color:#86ffe6}.brand span{font-size:10px;letter-spacing:.24em;text-transform:uppercase;color:rgba(223,255,249,.62)}
.stage{position:absolute;inset:calc(var(--topbar-h) + var(--safe-top)) 0 calc(var(--chip-dock-h) + var(--safe-bottom)) 0;padding:12px;display:flex;flex-direction:column;gap:10px;overflow-y:auto;overscroll-behavior:contain;scrollbar-width:none}
.stage::-webkit-scrollbar{display:none}
.marquee{padding:14px;border-radius:16px;background:linear-gradient(180deg,rgba(20,54,126,.92),rgba(6,14,38,.96));border:2px solid rgba(94,255,214,.22);box-shadow:0 14px 30px rgba(0,0,0,.3)}
.marquee-head{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:10px}
.tag{padding:7px 10px;border-radius:10px;font-size:11px;font-weight:1000;letter-spacing:.16em;text-transform:uppercase;background:rgba(0,0,0,.22);border:1px solid rgba(94,255,214,.22)}
.clock{text-align:center}.clock b{display:block;font-size:42px;font-weight:1000;color:#f7ff8a;text-shadow:0 0 18px rgba(247,255,138,.22)}.clock span{font-size:10px;letter-spacing:.24em;text-transform:uppercase;color:rgba(223,255,249,.62)}
.result-stage{margin-top:14px;padding:14px 16px;border-radius:16px;background:linear-gradient(180deg,rgba(18,43,101,.92),rgba(5,13,36,.96));border:2px solid rgba(94,255,214,.18);display:grid;grid-template-columns:210px minmax(0,1fr);gap:14px;align-items:center;box-shadow:inset 0 0 0 2px rgba(255,255,255,.03)}
.result-stage.active{box-shadow:inset 0 0 0 2px rgba(255,255,255,.03),0 0 28px rgba(94,255,214,.12)}
.result-window{padding:10px;border-radius:14px;background:rgba(1,7,20,.56);border:2px solid rgba(94,255,214,.16)}
.wheel-stage{position:relative;aspect-ratio:1/1;max-width:250px;margin:0 auto}
.wheel-base{position:absolute;inset:0;width:100%;height:100%;object-fit:contain;filter:drop-shadow(0 16px 28px rgba(0,0,0,.3))}
.wheel-segments{position:absolute;inset:12%;border-radius:50%;transition:transform 1.8s cubic-bezier(.18,.72,.2,1);transform:rotate(0deg)}
.wheel-stage.spinning .wheel-segments{filter:drop-shadow(0 0 12px rgba(134,255,230,.28))}
.wheel-segment{position:absolute;left:50%;top:50%;width:44px;height:44px;margin:-22px;display:grid;place-items:center;transform-origin:center}
.wheel-segment img{width:100%;height:100%;object-fit:contain;filter:drop-shadow(0 4px 8px rgba(0,0,0,.32))}
.wheel-segment.is-winner img{filter:drop-shadow(0 0 12px rgba(247,255,138,.55));transform:scale(1.08)}
.wheel-pointer{position:absolute;left:50%;top:-6px;transform:translateX(-50%);width:38px;z-index:4;filter:drop-shadow(0 8px 14px rgba(0,0,0,.34))}
.wheel-core{position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);width:32%;z-index:3}
.result-copy{display:flex;flex-direction:column;gap:6px;min-width:0}
.result-kicker{font-size:10px;font-weight:1000;letter-spacing:.24em;text-transform:uppercase;color:rgba(223,255,249,.62)}
.result-title{font-size:20px;font-weight:1000;letter-spacing:.08em;color:#86ffe6}
.result-text{font-size:13px;line-height:1.45;color:rgba(223,255,249,.72)}
.result-meta{font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:rgba(247,255,138,.72)}
@keyframes pixelReelPulse{0%{transform:translateY(20px) scale(.94);opacity:.08}55%{transform:translateY(-4px) scale(1.04);opacity:1}100%{transform:translateY(0) scale(1);opacity:1}}
.grid{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;flex:1 1 auto}
.cab{border:0;border-radius:14px;padding:10px 6px 12px;background:linear-gradient(180deg,rgba(26,60,144,.92),rgba(5,12,31,.98));border:2px solid rgba(94,255,214,.18);box-shadow:inset 0 0 0 2px rgba(255,255,255,.02),0 12px 20px rgba(0,0,0,.28);color:#def7ff;text-align:center;cursor:pointer;transition:transform .14s ease,box-shadow .14s ease}
.cab{box-shadow:0 18px 30px rgba(0,0,0,.3),inset 0 1px 0 rgba(255,255,255,.16),inset 0 -12px 20px rgba(0,0,0,.18)}
.cab:active{transform:scale(.97)}
.cab.win{box-shadow:0 0 0 2px rgba(247,255,138,.32),0 0 28px rgba(94,255,214,.16),0 12px 20px rgba(0,0,0,.28)}
.cab.pending{transform:translateY(-4px)}
.cab.disabled{opacity:.82}
.sprite{width:44px;height:44px;margin:0 auto 8px;border-radius:10px;display:grid;place-items:center;background:rgba(1,7,20,.64);border:2px solid rgba(94,255,214,.18);padding:4px}
.sprite img{width:100%;height:100%;object-fit:contain;filter:drop-shadow(0 4px 8px rgba(0,0,0,.3))}
.name{font-size:13px;font-weight:1000;letter-spacing:.1em;margin-bottom:4px}.multi{font-family:Inter,"Segoe UI",Arial,sans-serif;font-size:clamp(18px,4.7vw,27px);font-weight:1000;letter-spacing:0;text-transform:none;color:#f7ff8a;margin-bottom:8px;font-variant-numeric:tabular-nums}.pool{font-family:Inter,"Segoe UI",Arial,sans-serif;font-size:17px;font-weight:1000;font-variant-numeric:tabular-nums;letter-spacing:0}.mine{margin-top:6px;font-family:Inter,"Segoe UI",Arial,sans-serif;font-size:10px;letter-spacing:0;text-transform:none;color:rgba(223,255,249,.62);font-variant-numeric:tabular-nums}
.chips{position:absolute;left:0;right:0;bottom:0;height:calc(var(--chip-dock-h) + var(--safe-bottom));padding:10px max(12px,var(--safe-right)) max(10px,var(--safe-bottom)) max(12px,var(--safe-left));display:flex;align-items:center;justify-content:center;gap:8px;background:linear-gradient(180deg,rgba(3,9,28,.50),rgba(1,4,14,.98));border-top:2px solid rgba(94,255,214,.18);z-index:5}
.chip{min-width:56px;height:52px;padding:0 8px;border-radius:12px;border:2px solid rgba(94,255,214,.18);cursor:pointer;font-size:11px;font-weight:1000;color:#def7ff;background:linear-gradient(180deg,rgba(18,43,101,.92),rgba(5,13,36,.96));box-shadow:0 12px 20px rgba(0,0,0,.26);transition:transform .14s ease,box-shadow .14s ease;display:flex;align-items:center;justify-content:center;gap:4px}
.chip img{width:24px;height:24px;object-fit:contain;filter:drop-shadow(0 4px 6px rgba(0,0,0,.28))}
.chip span{display:block;line-height:1}
.chip.selected{transform:translateY(-8px);box-shadow:0 0 0 2px rgba(247,255,138,.28),0 0 24px rgba(94,255,214,.14),0 12px 20px rgba(0,0,0,.26);color:#f7ff8a}
.toast{position:absolute;left:50%;top:48%;transform:translate(-50%,-50%) scale(.9);min-width:250px;max-width:86vw;padding:16px 20px;border-radius:18px;background:linear-gradient(180deg,rgba(17,40,95,.98),rgba(3,8,24,.98));border:2px solid rgba(94,255,214,.2);box-shadow:0 24px 50px rgba(0,0,0,.42);text-align:center;opacity:0;pointer-events:none;transition:.22s;z-index:8}
.toast.show{opacity:1;transform:translate(-50%,-50%) scale(1)}
.toast b{display:block;font-size:18px;margin-bottom:4px;color:#86ffe6}.toast span{font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:rgba(223,255,249,.62)}
.history-btn{color:#def7ff;cursor:pointer}
.history-modal{position:absolute;inset:0;display:none;align-items:center;justify-content:center;padding:16px;background:rgba(1,4,14,.72);backdrop-filter:blur(12px);z-index:9}.history-modal.is-open{display:flex}
.history-card{width:min(92vw,460px);max-height:min(82vh,620px);overflow:auto;padding:18px;border-radius:22px;background:linear-gradient(180deg,rgba(18,43,101,.98),rgba(3,8,24,.98));border:2px solid rgba(94,255,214,.2);box-shadow:0 24px 44px rgba(0,0,0,.42)}
.history-head{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:14px}.history-head h3{font-size:17px;letter-spacing:.14em;text-transform:uppercase;color:#86ffe6}.history-head p{font-size:11px;line-height:1.45;color:rgba(223,255,249,.62)}
.history-close{padding:9px 14px;border-radius:999px;border:2px solid rgba(94,255,214,.18);background:linear-gradient(180deg,rgba(18,43,101,.92),rgba(5,13,36,.96));color:#def7ff;cursor:pointer}
.history-stack{display:grid;gap:14px}.history-section{padding:14px;border-radius:16px;background:rgba(1,7,20,.56);border:2px solid rgba(94,255,214,.16)}.history-section-head{display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:10px}.history-section-title{font-size:12px;font-weight:1000;letter-spacing:.16em;text-transform:uppercase;color:#86ffe6}.history-section-sub{font-size:11px;color:rgba(223,255,249,.62)}
.history-table-wrap{border-radius:14px;overflow:auto;border:1px solid rgba(94,255,214,.18)}.history-table{width:100%;border-collapse:collapse;font-size:11px;color:#def7ff}.history-table th,.history-table td{padding:9px 10px;text-align:left;vertical-align:top}.history-table th{position:sticky;top:0;background:rgba(3,8,24,.96);font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:rgba(223,255,249,.62);z-index:1}.history-table tbody tr:nth-child(odd){background:rgba(255,255,255,.03)}.history-table tbody tr:nth-child(even){background:rgba(255,255,255,.06)}
.history-empty{padding:12px;border-radius:12px;background:rgba(255,255,255,.04);text-align:center;color:rgba(223,255,249,.62)}.history-board{display:flex;align-items:center;gap:8px;min-width:0}.history-board-icon{width:24px;height:24px;object-fit:contain;filter:drop-shadow(0 4px 8px rgba(0,0,0,.3))}.history-trace{font-size:11px;line-height:1.35;word-break:break-word;color:#def7ff}.history-status{display:inline-flex;align-items:center;justify-content:center;padding:4px 8px;border-radius:999px;font-size:10px;font-weight:1000;letter-spacing:.12em;text-transform:uppercase;white-space:nowrap}.history-status.win{background:rgba(71,232,150,.14);color:#86ffe6;border:1px solid rgba(71,232,150,.22)}.history-status.loss{background:rgba(255,106,142,.14);color:#ffb4bf;border:1px solid rgba(255,106,142,.22)}.history-status.pending{background:rgba(247,255,138,.14);color:#f7ff8a;border:1px solid rgba(247,255,138,.22)}.history-status.punishment{background:rgba(255,173,92,.14);color:#ffc98f;border:1px solid rgba(255,173,92,.22)}
@media(max-width:430px){
  :root{--topbar-h:62px;--chip-dock-h:70px}
  .topbar{gap:8px;padding-left:max(8px,var(--safe-left));padding-right:max(8px,var(--safe-right))}
  .panel{min-width:82px;height:38px;padding:0 8px;gap:6px}
  .panel strong{font-size:16px}
  .brand{max-width:112px}
  .brand b{font-size:12px;letter-spacing:.12em}
  .brand span{font-size:8px;letter-spacing:.18em}
  .stage{padding:10px 8px 12px}
  .marquee{padding:12px;border-radius:14px}
  .marquee-head{gap:8px;flex-wrap:wrap;margin-bottom:8px}
  .tag{padding:6px 8px;font-size:10px}
  .clock b{font-size:34px}
  .result-stage{margin-top:10px;padding:10px 12px;grid-template-columns:1fr;gap:10px}
  .result-window{padding:8px}
  .wheel-stage{max-width:220px}
  .wheel-segment{width:38px;height:38px;margin:-19px}
  .wheel-pointer{width:34px;top:-4px}
  .result-title{font-size:18px}
  .result-text{font-size:12px}
  .grid{gap:6px}
  .cab{padding:9px 4px 10px}
  .sprite{width:36px;height:36px;margin-bottom:6px;font-size:15px}
  .name{font-size:10px;letter-spacing:.06em}
  .multi,.mine{font-size:9px}
  .pool{font-size:15px}
  .chips{padding:8px max(8px,var(--safe-right)) max(8px,var(--safe-bottom)) max(8px,var(--safe-left));gap:6px}
  .chip{min-width:48px;height:44px;padding:0 6px;font-size:10px}
  .chip img{width:20px;height:20px}
}
@media(max-width:380px){
  .panel{min-width:72px;padding:0 6px}
  .panel strong{font-size:14px}
  .brand{max-width:96px}
  .brand b{font-size:11px}
  .brand span{font-size:7px;letter-spacing:.14em}
  .grid{gap:5px}
  .cab{padding:8px 3px 9px}
  .sprite{width:32px;height:32px;font-size:13px}
  .pool{font-size:13px}
  .chip{min-width:42px;height:40px;font-size:9px}
  .chip img{width:18px;height:18px}
  .toast{min-width:0;width:min(88vw,300px);padding:14px 16px}
}
@media(max-width:340px){
  .brand{max-width:84px}
  .chip{min-width:38px;padding:0 5px}
}
@media(max-height:620px){:root{--topbar-h:58px;--chip-dock-h:70px}.stage{padding:8px}.result-stage{grid-template-columns:180px minmax(0,1fr);padding:10px 12px}.wheel-stage{max-width:190px}.wheel-segment{width:34px;height:34px;margin:-17px}.wheel-pointer{width:30px}.result-title{font-size:17px}.result-text{font-size:12px}.grid{gap:6px}.cab{padding:8px 4px 10px}.sprite{width:38px;height:38px}.chip{min-width:48px;height:46px;padding:0 8px}}
/* Mobile fit layer: fixed bottom chips, no play-surface scroll, 450/325 high screens */
.stage{overflow:hidden}
.chips{position:fixed;left:0;right:0;bottom:0;width:100vw;max-width:100vw;flex-wrap:nowrap;overflow:hidden;border-radius:0}
.chip{flex:1 1 0;min-width:0;max-width:64px}
@media(max-height:450px){
  :root{--topbar-h:44px;--chip-dock-h:50px}
  .topbar{padding:max(5px,var(--safe-top)) max(8px,var(--safe-right)) 5px max(8px,var(--safe-left));gap:6px}
  .panel{min-width:66px;height:30px;padding:0 6px}.panel strong{font-size:13px}
  .brand b{font-size:10px}.brand span{display:none}
  .stage{padding:6px;gap:6px}.marquee{padding:7px;border-radius:12px}.marquee-head{margin-bottom:5px}.tag{padding:4px 6px;font-size:8px}
  .clock b{font-size:24px}.clock span{display:none}
  .result-stage{grid-template-columns:116px minmax(0,1fr);margin-top:5px;padding:6px;border-radius:12px;gap:6px}
  .result-window{padding:5px}.wheel-stage{max-width:105px}.wheel-segment{width:22px;height:22px;margin:-11px}.wheel-pointer{width:22px}
  .result-title{font-size:12px}.result-text,.result-meta,.result-kicker{display:none}
  .grid{gap:4px}.cab{padding:5px 2px;border-radius:10px}.sprite{width:24px;height:24px;margin-bottom:3px}.name{font-size:8px}.multi,.mine{display:none}.pool{font-size:10px}
  .chips{height:calc(var(--chip-dock-h) + var(--safe-bottom));padding:5px max(5px,var(--safe-right)) max(5px,var(--safe-bottom)) max(5px,var(--safe-left));gap:4px}
  .chip{height:34px;min-width:0;font-size:8px;border-radius:9px}.chip img{width:15px;height:15px}
}
@media(max-height:325px){
  :root{--topbar-h:32px;--chip-dock-h:38px}
  .topbar{padding:max(3px,var(--safe-top)) 6px 3px;gap:4px}.panel{min-width:52px;height:23px}.panel strong{font-size:10px}.brand b{font-size:8px}
  .stage{padding:4px;gap:4px}.marquee{padding:5px;border-radius:10px}.marquee-head{display:none}.clock b{font-size:18px}
  .result-stage{display:none}.grid{gap:3px}.cab{padding:4px 2px;border-radius:8px}.sprite{width:19px;height:19px;margin-bottom:2px}.name{font-size:7px}.pool{font-size:8px}
  .chips{height:calc(var(--chip-dock-h) + var(--safe-bottom));padding:4px 4px max(4px,var(--safe-bottom));gap:3px}.chip{height:27px;font-size:7px}.chip img{display:none}
}
  .clock.timer-hidden{opacity:0;visibility:hidden;pointer-events:none}
</style>
@include('game_final.partials.admin_visual_theme_styles')
</head>
<body class="gf-popup-{{ $gameTheme['popup_theme'] ?? 'popup_01' }} gf-item-{{ $gameTheme['item_theme'] ?? 'default' }}" style="--admin-primary:{{ $gameTheme['primary_color'] ?? '#112b72' }};--admin-accent:{{ $gameTheme['accent_color'] ?? '#86ffe6' }}">
<div class="app">
  <div class="topbar">
    <div class="panel">CR <strong id="balance">--</strong></div>
    <div class="brand"><b>Fruit Slot Arcade</b><span>Pixel Vault</span></div>
    <div class="panel">R <strong id="round">---</strong></div>
  </div>
  <div class="stage">
    <section class="marquee">
      <div class="marquee-head">
        <div class="tag" id="phase">SYNCING</div>
        <div class="tag">NET <span id="networkMs">sync</span></div>
        <button class="tag history-btn" id="historyBtn" type="button">History</button>
      </div>
      <div class="clock"><b id="time">--</b><span>crt countdown</span></div>
      <div class="result-stage" id="resultStage">
        <div class="result-window">
          <div class="wheel-stage" id="resultWheelStage">
            <img class="wheel-base" src="{{ $wheelAsset }}" alt="Wheel" />
            <div class="wheel-segments" id="resultWheelSegments"></div>
            <img class="wheel-pointer" src="{{ $wheelPointerAsset }}" alt="Pointer" />
            <img class="wheel-core" src="{{ $wheelCenterAsset }}" alt="Core" />
          </div>
        </div>
        <div class="result-copy">
          <div class="result-kicker">Result Wheel</div>
          <div class="result-title" id="resultTitle">Wheel armed</div>
          <div class="result-text" id="resultText">The pixel vault wheel lands on the winning symbol when the round reveals.</div>
          <div class="result-meta" id="resultMeta">Awaiting result</div>
        </div>
      </div>
    </section>
    <section class="grid">
      @foreach ($boardProfiles as $boardKey => $profile)
      <button class="cab" data-board="{{ $boardKey }}" type="button">
        <div class="sprite"><img src="{{ $profile['image'] }}" alt="{{ $profile['name'] }}" /></div>
        <div class="name">{{ $profile['name'] }}</div>
        <div class="multi">{{ $profile['multiplier'] }}</div>
        <div class="pool" id="pool-{{ $boardKey }}">0</div>
        <div class="mine" id="mine-{{ $boardKey }}">Tap to stake</div>
      </button>
      @endforeach
    </section>
  </div>
  <div class="chips">
    @foreach ($chipValues as $chipValue)
    <button class="chip{{ $chipValue === 500 ? ' selected' : '' }}" type="button" data-value="{{ $chipValue }}">
      <img src="{{ $chipImageMap[$chipValue] ?? $chipImageMap[500] }}" alt="Chip {{ $chipValue }}" />
      <span>{{ $chipValue >= 1000 ? rtrim(rtrim(number_format($chipValue / 1000, 1), '0'), '.') . 'K' : $chipValue }}</span>
    </button>
    @endforeach
  </div>
  <div class="toast" id="toast"><b id="toastTitle">Pixel Vault</b><span id="toastText">Live room booting</span></div>
  <div class="history-modal" id="historyModal">
    <div class="history-card">
      <div class="history-head">
        <div>
          <h3>Room History</h3>
          <p>Last 15 winning boards and your last 15 bet tickets.</p>
        </div>
        <button class="history-close" id="historyClose" type="button">Close</button>
      </div>
      <div class="history-stack" id="historyContent"></div>
    </div>
  </div>
</div>
<script>
window.BD_GAME_BOOTSTRAP = {
  gameCode: @json($currentGameCode),
  gameToken: @json($gameToken ?? null),
  sessionToken: @json($sessionToken ?? null),
  lobbyUrl: @json($lobbyUrl ?? route('game-final.lobby')),
  userId: @json($displayUserId ?? auth()->id() ?? request()->get('user_id')),
  userName: @json($displayUserName ?? 'Player'),
  rules: {
    maxDistinctBoards: @json((int) ($gameRules['max_distinct_boards_per_user'] ?? count((array) $boardProfiles))),
    boardCount: @json((int) ($gameRules['board_count'] ?? count((array) $boardProfiles)))
  },
  requestTimeoutMs: 10000,
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
        enabledTransports: @json(config('bd_game_final.realtime.pusher.enabledTransports', ['ws', 'wss']))
      }
    }
  }
};
</script>
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script src="{{ asset('game_final_assets/game_final_bridge.js') }}"></script>
<script>
(() => {
  const currentGameCode = @json($currentGameCode);
  const boardProfiles = @json($boardProfiles);
  const hasLiveSession = @json((bool) ($sessionToken ?? null));
  const refs = { balance: document.getElementById('balance'), round: document.getElementById('round'), phase: document.getElementById('phase'), networkMs: document.getElementById('networkMs'), time: document.getElementById('time'), resultStage: document.getElementById('resultStage'), resultWheelStage: document.getElementById('resultWheelStage'), resultWheelSegments: document.getElementById('resultWheelSegments'), resultTitle: document.getElementById('resultTitle'), resultText: document.getElementById('resultText'), resultMeta: document.getElementById('resultMeta'), toast: document.getElementById('toast'), toastTitle: document.getElementById('toastTitle'), toastText: document.getElementById('toastText'), historyBtn: document.getElementById('historyBtn'), historyModal: document.getElementById('historyModal'), historyContent: document.getElementById('historyContent'), historyClose: document.getElementById('historyClose'), chips: Array.from(document.querySelectorAll('.chip')), boards: {}, pools: {}, mines: {} };
  Object.keys(boardProfiles).forEach((key) => { refs.boards[key] = document.querySelector(`.cab[data-board="${key}"]`); refs.pools[key] = document.getElementById(`pool-${key}`); refs.mines[key] = document.getElementById(`mine-${key}`); });
  let selectedChip = 500, authoritativeRoundNo = null, lastStatePayload = null, lastResultVisualKey = '', lastWinnerToastKey = '', refreshInFlight = false, requestCounter = 0, lastNetworkMs = 0, serverClockOffsetSec = 0, serverClockKey = '', refreshTimer = null, heartbeatTimer = null, timerTick = null, toastTimer = null, disposed = false, wheelRotation = 0, boardHistoryRows = [], userHistoryRows = [], historySyncInFlight = false, lastHistorySyncRound = '';
  const pendingBoards = new Set();
  const wheelKeys = Object.keys(boardProfiles);
  const roomBoardCount = Math.max(1, Number(window.BD_GAME_BOOTSTRAP.rules && window.BD_GAME_BOOTSTRAP.rules.boardCount || Object.keys(boardProfiles).length || 1));
  function number(value){ return Number(value || 0).toLocaleString('en-US'); }
  function balanceNumber(value){ return String(Math.max(0, Math.floor(Number(value || 0)))); }
  function escapeHtml(value){ return String(value == null ? '' : value).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;'); }
  function historyBoardCell(boardKey){ const profile = boardProfiles[boardKey] || null; const name = profile ? profile.name : (boardKey || '-'); const icon = profile ? `<img class="history-board-icon" src="${profile.image}" alt="${escapeHtml(name)}" />` : ''; return `<div class="history-board">${icon}<span>${escapeHtml(name)}</span></div>`; }
  function renderHistoryPopup(){ if(!refs.historyContent) return; const boardTable = boardHistoryRows.length ? `<div class="history-section"><div class="history-section-head"><div class="history-section-title">Win Board History</div><div class="history-section-sub">Last 15 settled rounds</div></div><div class="history-table-wrap"><table class="history-table"><thead><tr><th>Round ID</th><th>Winner</th><th>Mode</th></tr></thead><tbody>${boardHistoryRows.map((item) => `<tr><td class="history-trace">${escapeHtml(item && item.round_no || '-')}</td><td>${historyBoardCell(item && item.winner_board_key || '')}</td><td>${escapeHtml(String(item && item.decision_mode || 'auto').replace(/_/g, ' ').toUpperCase())}</td></tr>`).join('')}</tbody></table></div></div>` : '<div class="history-empty">Waiting for live rounds</div>'; const userTable = userHistoryRows.length ? `<div class="history-section"><div class="history-section-head"><div class="history-section-title">My Bet History</div><div class="history-section-sub">Last 15 bet tickets</div></div><div class="history-table-wrap"><table class="history-table"><thead><tr><th>Trace ID</th><th>Round ID</th><th>Board</th><th>Bid</th><th>Result</th></tr></thead><tbody>${userHistoryRows.map((item) => { const status = String(item && item.status || 'pending').toLowerCase(); const statusClass = status === 'won' ? 'win' : (status === 'lost' ? 'loss' : (status === 'punishment' ? 'punishment' : 'pending')); const resultText = status === 'won' ? `WIN +${number(item && item.win_amount || 0)}` : (status === 'lost' ? `LOSS -${number(item && item.amount || 0)}` : (status === 'punishment' ? `PUNISH -${number(Math.abs(Number(item && (item.result_amount || item.amount) || 0)))}` : 'PENDING')); return `<tr><td class="history-trace">${escapeHtml(item && item.trace_id || '-')}</td><td class="history-trace">${escapeHtml(item && (item.round_id || item.round_no) || '-')}</td><td>${historyBoardCell(item && (item.board_key || item.frontend_board_key) || '')}</td><td>${escapeHtml(number(item && item.amount || 0))}</td><td><span class="history-status ${statusClass}">${escapeHtml(resultText)}</span></td></tr>`; }).join('')}</tbody></table></div></div>` : '<div class="history-empty">Place a bet to build your history</div>'; refs.historyContent.innerHTML = `${boardTable}${userTable}`; }
  function openHistoryModal(){ renderHistoryPopup(); if(refs.historyModal) refs.historyModal.classList.add('is-open'); refreshHistoryTables(true); }
  function closeHistoryModal(){ if(refs.historyModal) refs.historyModal.classList.remove('is-open'); }
  async function refreshHistoryTables(force = false){ if(!(window.BDGameFinal && window.BD_GAME_BOOTSTRAP && window.BD_GAME_BOOTSTRAP.gameCode === currentGameCode)){ renderHistoryPopup(); return; } if(historySyncInFlight) return; if(!force && !window.BD_GAME_BOOTSTRAP.endpoints) return; historySyncInFlight = true; try { const [historyPayload, myBetsPayload] = await Promise.all([window.BDGameFinal.get(window.BD_GAME_BOOTSTRAP.endpoints.history, {}), window.BDGameFinal.get(window.BD_GAME_BOOTSTRAP.endpoints.myBets, {})]); boardHistoryRows = Array.isArray(historyPayload && (historyPayload.board_history || historyPayload.recent)) ? (historyPayload.board_history || historyPayload.recent) : []; userHistoryRows = Array.isArray(myBetsPayload && (myBetsPayload.bet_history || myBetsPayload.history)) ? (myBetsPayload.bet_history || myBetsPayload.history) : []; } catch (error) { if(!boardHistoryRows.length && !userHistoryRows.length){ boardHistoryRows = []; userHistoryRows = []; } } finally { historySyncInFlight = false; renderHistoryPopup(); } }
  function formatRoundLabel(roundNo){ if(!roundNo) return '---'; const parts = String(roundNo).split('_'); const value = parts.length ? parts[parts.length - 1] : '---'; if(/^\d{7,}$/.test(value)) return value.slice(-3).replace(/^0+/, '') || '0'; return value || '---'; }
  function phaseLabel(phase){ if(phase === 'betting') return 'BET OPEN'; if(phase === 'locked') return 'LOCKED'; if(phase === 'revealed') return 'SPIN'; if(phase === 'settled') return 'PAYOUT'; return hasLiveSession ? 'SYNCING' : 'LIVE ONLY'; }
  function serverNow(){ return (Date.now() / 1000) + serverClockOffsetSec; }
  function phaseEndAt(payload){ if(!payload) return null; if(payload.phase === 'betting') return payload.bet_close_at || null; if(payload.phase === 'locked') return payload.reveal_at || null; if(payload.phase === 'revealed') return payload.settle_at || null; if(payload.phase === 'settled') return payload.next_round_at || null; return null; }
  function currentWinner(payload){ return payload && (payload.winner_board || (payload.result && payload.result.winner_board)) || ''; }
  function maxDistinctBoards(payload){ const fromPayload = Number(payload && payload.rules && payload.rules.max_distinct_boards_per_user || 0); const fromBootstrap = Number(window.BD_GAME_BOOTSTRAP.rules && window.BD_GAME_BOOTSTRAP.rules.maxDistinctBoards || 0); return Math.max(1, Math.min(roomBoardCount, fromPayload || fromBootstrap || roomBoardCount)); }
  function currentDistinctBoardCount(payload){ return Object.keys(boardProfiles).filter((key) => Number(payload && payload.my_bet_totals && payload.my_bet_totals[key] || 0) > 0).length; }
  function canUseBoard(payload, boardKey){ const currentTotal = Number(payload && payload.my_bet_totals && payload.my_bet_totals[boardKey] || 0); return currentTotal > 0 || currentDistinctBoardCount(payload) < maxDistinctBoards(payload); }
  function boardLimitMessage(payload){ const limit = maxDistinctBoards(payload); return `This room allows ${limit} distinct ${limit === 1 ? 'board' : 'boards'} per round.`; }
  function setResultCopy(title,text,meta){ refs.resultTitle.textContent = title; refs.resultText.textContent = text; refs.resultMeta.textContent = meta; }
  function normalizeRotation(value){ return ((value % 360) + 360) % 360; }
  function buildWheel(){
    if(!refs.resultWheelSegments) return;
    refs.resultWheelSegments.innerHTML = '';
    const step = 360 / Math.max(wheelKeys.length, 1);
    wheelKeys.forEach((key, index) => {
      const angle = (index * step) - 90;
      const node = document.createElement('div');
      node.className = 'wheel-segment';
      node.dataset.key = key;
      node.style.transform = `rotate(${angle}deg) translate(0, -88px) rotate(${-angle}deg)`;
      node.innerHTML = `<img src="${boardProfiles[key].image}" alt="${boardProfiles[key].name}" />`;
      refs.resultWheelSegments.appendChild(node);
    });
  }
  function updateWheelWinner(winner){
    if(!refs.resultWheelSegments) return;
    refs.resultWheelSegments.querySelectorAll('.wheel-segment').forEach((node) => {
      node.classList.toggle('is-winner', !!winner && node.dataset.key === winner);
    });
  }
  function spinWheelToWinner(winner){
    if(!refs.resultWheelSegments || !winner) return;
    const index = wheelKeys.indexOf(winner);
    if(index === -1) return;
    const step = 360 / Math.max(wheelKeys.length, 1);
    const target = 360 - (index * step + (step / 2));
    const current = normalizeRotation(wheelRotation);
    const delta = normalizeRotation(target - current);
    wheelRotation += 1440 + delta;
    refs.resultWheelSegments.style.transform = `rotate(${wheelRotation}deg)`;
    refs.resultWheelStage.classList.add('spinning');
    window.setTimeout(() => refs.resultWheelStage && refs.resultWheelStage.classList.remove('spinning'), 1900);
  }
  function updateResultVisual(payload){ const winner = currentWinner(payload); const resultPhase = !!(payload && (payload.phase === 'revealed' || payload.phase === 'settled')); if(refs.resultStage) refs.resultStage.classList.toggle('active', resultPhase); if(!payload){ updateWheelWinner(''); setResultCopy('Wheel armed', 'The pixel vault wheel lands on the winning symbol when the round reveals.', 'Awaiting result'); return; } if(!resultPhase || !winner){ lastResultVisualKey = ''; updateWheelWinner(''); const title = payload.phase === 'betting' ? 'Wheel armed' : payload.phase === 'locked' ? 'Wheel locking' : 'Vault syncing'; const text = payload.phase === 'betting' ? 'Choose a symbol before the wheel locks its result.' : payload.phase === 'locked' ? 'Bets are closed and the wheel is lining up its stop.' : 'Waiting for live result payload.'; const meta = payload.phase === 'betting' ? 'Guess the winning symbol' : 'Awaiting result'; setResultCopy(title, text, meta); return; } const resultKey = `${payload.round_no || 'na'}:${winner}`; if(resultKey !== lastResultVisualKey){ lastResultVisualKey = resultKey; spinWheelToWinner(winner); } updateWheelWinner(winner); const myWin = Number(payload.my_total_win_amount || 0); const multiplier = payload && payload.result && payload.result.multiplier ? `x${payload.result.multiplier}` : (boardProfiles[winner] ? boardProfiles[winner].multiplier : ''); setResultCopy(`${boardProfiles[winner].name} RESULT`, `Wheel stopped on ${boardProfiles[winner].name}.`, myWin > 0 ? `+${number(myWin)} credited` : `${multiplier} payout lane`); }
  function show(title,text){ refs.toastTitle.textContent = title; refs.toastText.textContent = text; refs.toast.classList.add('show'); if(toastTimer) window.clearTimeout(toastTimer); toastTimer = window.setTimeout(() => refs.toast.classList.remove('show'), 1300); }
  function setNetwork(status,label){ refs.networkMs.textContent = label; refs.networkMs.style.color = status === 'good' ? '#86ffe6' : status === 'warn' ? '#f7ff8a' : '#ffb4bf'; }
  function updateTimer(payload){ const clock = refs.time ? refs.time.closest('.clock') : null; if(!payload){ if(clock) clock.classList.add('timer-hidden'); refs.time.textContent = '--'; return; } const clockKey = `${payload.round_no || 'na'}:${payload.phase || 'na'}`; if(typeof payload.server_time === 'number' && (clockKey !== serverClockKey || !serverClockKey)){ serverClockOffsetSec = payload.server_time - (Date.now() / 1000); serverClockKey = clockKey; } const endAt = phaseEndAt(payload); const left = endAt ? Math.max(0, Math.ceil(endAt - serverNow())) : 0; const showClock = payload.phase === 'betting' && left > 0; if(clock) clock.classList.toggle('timer-hidden', !showClock); refs.time.textContent = showClock ? String(left) : ''; }
  function boardMultiplier(payload,key){ const raw = payload && payload.result && Number(payload.result.multiplier || 0) > 0 && currentWinner(payload) === key ? payload.result.multiplier : (boardProfiles[key] && boardProfiles[key].multiplier ? boardProfiles[key].multiplier : 'x1'); const parsed = Number(String(raw).replace(/[^\d.]/g, '')); return parsed > 0 ? parsed : 1; }
  function boardText(payload,key,myTotal,isWinner){ if(isWinner && myTotal > 0){ const multiplier = boardMultiplier(payload, key); const actualWinAmount = Number(payload && payload.my_total_win_amount || 0); const winAmount = actualWinAmount > 0 ? actualWinAmount : Math.round(myTotal * multiplier); return `${number(myTotal)} x${number(multiplier)} = ${number(winAmount)}`; } return number(Math.max(0, myTotal)); }
  function updateBoards(payload){ const winner = currentWinner(payload); const resultPhase = !!(payload && (payload.phase === 'revealed' || payload.phase === 'settled')); Object.keys(boardProfiles).forEach((key) => { const board = refs.boards[key]; const pool = refs.pools[key]; const mine = refs.mines[key]; const boardTotal = Number(payload && payload.board_totals && payload.board_totals[key] || 0); const myTotal = Number(payload && payload.my_bet_totals && payload.my_bet_totals[key] || 0); const blockedByLimit = !!payload && payload.phase === 'betting' && !canUseBoard(payload, key); pool.textContent = number(boardTotal); mine.textContent = boardText(payload, key, myTotal, resultPhase && winner === key); board.classList.toggle('win', !!resultPhase && winner === key); board.classList.toggle('disabled', !payload || payload.phase !== 'betting' || blockedByLimit); board.classList.toggle('pending', pendingBoards.has(key)); }); }
  function maybeShowWinnerToast(payload){ const winner = currentWinner(payload); if(!winner || !(payload.phase === 'revealed' || payload.phase === 'settled')) return; const winnerKey = `${payload.round_no || 'na'}:${payload.phase}:${winner}`; if(winnerKey === lastWinnerToastKey) return; lastWinnerToastKey = winnerKey; const myWin = Number(payload.my_total_win_amount || 0); const multiplier = payload && payload.result && payload.result.multiplier ? ` x${payload.result.multiplier}` : ''; show(`Winner ${boardProfiles[winner] ? boardProfiles[winner].name : winner}`, myWin > 0 ? `+${number(myWin)} credited` : `Cabinet synced${multiplier}`); }
  function applyPayload(payload){ lastStatePayload = payload; authoritativeRoundNo = payload.round_no || authoritativeRoundNo; if(Array.isArray(payload.recent) && payload.recent.length && !boardHistoryRows.length){ boardHistoryRows = payload.recent; renderHistoryPopup(); } if(payload.phase === 'settled'){ const historyRound = String(payload.round_no || ''); if(historyRound && historyRound !== lastHistorySyncRound){ lastHistorySyncRound = historyRound; refreshHistoryTables(); } } else if(payload.phase === 'betting'){ lastHistorySyncRound = ''; } refs.balance.textContent = balanceNumber(payload.balance || 0); refs.round.textContent = formatRoundLabel(authoritativeRoundNo); refs.phase.textContent = phaseLabel(payload.phase); updateTimer(payload); updateBoards(payload); updateResultVisual(payload); maybeShowWinnerToast(payload); }
  function mapBetError(message){ const map = { invalid_session:'Session expired. Rejoin room.', bet_closed:'Bet closed. Wait for next round.', insufficient_balance:'Select smaller chip', duplicate_request:'Duplicate bet ignored', max_distinct_board_limit:'All reels already used', max_pot_reached:'Max pot reached', bet_amount_out_of_range:'Bet amount out of range', invalid_board:'Invalid reel' }; return map[message] || 'Bet failed. Try again.'; }
  async function refreshState(){ if(disposed || !window.BDGameFinal || refreshInFlight) return; refreshInFlight = true; const startedAt = performance.now(); try { const payload = await window.BDGameFinal.get(window.BD_GAME_BOOTSTRAP.endpoints.state, {}); lastNetworkMs = Math.max(1, Math.round(performance.now() - startedAt)); if(payload && payload.st){ setNetwork(lastNetworkMs < 400 ? 'good' : 'warn', `${lastNetworkMs}ms`); applyPayload(payload); } else { setNetwork('bad','retry'); } } catch (error) { setNetwork('bad','retry'); } finally { refreshInFlight = false; } }
  async function submitBet(boardKey){ if(disposed || pendingBoards.has(boardKey)) return; if(!window.BDGameFinal || !authoritativeRoundNo || !lastStatePayload){ show('Syncing','Waiting for live round'); return; } if(lastStatePayload.phase !== 'betting'){ show('Wait','Next betting window soon'); return; } if(Number(lastStatePayload.balance || 0) < selectedChip){ show('Low Balance','Select smaller chip'); return; } if(!canUseBoard(lastStatePayload, boardKey)){ show('Board Limit', boardLimitMessage(lastStatePayload)); return; } pendingBoards.add(boardKey); updateBoards(lastStatePayload); try { const response = await window.BDGameFinal.post(window.BD_GAME_BOOTSTRAP.endpoints.bet,{ round_no: authoritativeRoundNo, board_key: boardKey, amount: selectedChip, request_uid: `${currentGameCode}-${Date.now()}-${++requestCounter}-${boardKey}` }); if(response && response.st){ show('Bid Added', `${boardProfiles[boardKey].name} +${number(selectedChip)}`); await refreshState(); refreshHistoryTables(true); } else { show('Bet Failed', mapBetError(response && (response.msg || response.error))); } } catch (error) { show('Bet Failed','Retry in the next round'); } finally { pendingBoards.delete(boardKey); if(lastStatePayload) updateBoards(lastStatePayload); } }
  refs.chips.forEach((chip) => chip.addEventListener('click', () => { refs.chips.forEach((node) => node.classList.remove('selected')); chip.classList.add('selected'); selectedChip = Number(chip.dataset.value || 0); show('Chip Selected', `${number(selectedChip)} active`); }));
  Object.keys(boardProfiles).forEach((key) => refs.boards[key].addEventListener('click', (event) => { event.preventDefault(); submitBet(key); }));
  refs.historyBtn.addEventListener('click', openHistoryModal);
  refs.historyClose.addEventListener('click', closeHistoryModal);
  refs.historyModal.addEventListener('click', (event) => { if(event.target === refs.historyModal) closeHistoryModal(); });
  buildWheel();
  function stopArcadeAudioHandle(target, permanent = false, seen = null){
    if(!target) return;
    if(seen && ((typeof target === 'object' && target !== null) || typeof target === 'function')){
      if(seen.has(target)) return;
      seen.add(target);
    }
    if(target instanceof HTMLMediaElement){
      try { target.pause(); } catch (error) {}
      try { target.currentTime = 0; } catch (error) {}
      try { target.muted = true; } catch (error) {}
      return;
    }
    if(typeof target.pause === 'function'){
      try { target.pause(); } catch (error) {}
    }
    if(typeof target.stop === 'function'){
      try { target.stop(); } catch (error) {}
    }
    if(typeof target.mute === 'function'){
      try { target.mute(true); } catch (error) {}
    }
    if(typeof target.suspend === 'function'){
      try { target.suspend(); } catch (error) {}
    }
    if(permanent && typeof target.close === 'function'){
      try { target.close(); } catch (error) {}
    }
  }
  function silenceArcadeRoomAudio(permanent = false){
    const seen = new WeakSet();
    document.querySelectorAll('audio,video').forEach((media) => stopArcadeAudioHandle(media, permanent, seen));
    if('speechSynthesis' in window){
      try { window.speechSynthesis.cancel(); } catch (error) {}
    }
    [window.Howler, window.audioCtx, window.musicCtx, window.backgroundMusic, window.roomMusic, window.roomAudio].forEach((target) => stopArcadeAudioHandle(target, permanent, seen));
    if(window.Howler && typeof window.Howler.stop === 'function'){
      try { window.Howler.stop(); } catch (error) {}
    }
  }
  function cleanupArcadeRoom(){
    disposed = true;
    silenceArcadeRoomAudio(true);
    if(window.BDGameFinal && typeof window.BDGameFinal.stopHeartbeat === 'function') window.BDGameFinal.stopHeartbeat();
    if(refreshTimer) window.clearInterval(refreshTimer);
    if(heartbeatTimer) window.clearInterval(heartbeatTimer);
    if(timerTick) window.clearInterval(timerTick);
    if(toastTimer) window.clearTimeout(toastTimer);
  }
  if(window.BDGameFinal && window.BD_GAME_BOOTSTRAP && window.BD_GAME_BOOTSTRAP.gameCode === currentGameCode){ const api = window.BDGameFinal; api.onState((payload) => { if(!disposed && payload && payload.st) applyPayload(payload); }); if(typeof api.onConnection === 'function'){ api.onConnection((detail) => { if(!detail || disposed) return; if(detail.status === 'pending') setNetwork('warn','sync'); if(detail.status === 'error') setNetwork('bad','retry'); if(detail.status === 'expired'){ setNetwork('bad','expired'); show('Session Expired','Rejoin room'); } }); } refreshState(); if(typeof api.startHeartbeat === 'function') api.startHeartbeat(15000, () => lastNetworkMs || 0); else heartbeatTimer = window.setInterval(() => { if(disposed) return; if(typeof api.heartbeat === 'function') api.heartbeat(lastNetworkMs || 0); else api.post(window.BD_GAME_BOOTSTRAP.endpoints.heartbeat,{ network_ms: lastNetworkMs || 0 }); }, 15000); } else { setNetwork('bad','offline'); show('Live Session Required','Rejoin room'); }
  timerTick = window.setInterval(() => { if(lastStatePayload) updateTimer(lastStatePayload); }, 250);
  renderHistoryPopup();
  refreshHistoryTables(true);
  document.addEventListener('visibilitychange', () => { if(document.hidden) silenceArcadeRoomAudio(false); });
  window.addEventListener('pagehide', cleanupArcadeRoom, { once:true });
  window.addEventListener('beforeunload', cleanupArcadeRoom, { once:true });
})();
</script>
</body>
</html>
