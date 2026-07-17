@php
	$currentGameCode = $gameCode ?? 'fruit_slot';
	$isGreedyRoom = false; // Greedy uses the standard Fruit Slot skin.
	$gameTheme = is_array($gameTheme ?? null) ? $gameTheme : [];
	$currentGameName = config('bd_game_final.games.' . $currentGameCode . '.name', 'Fruit Slot');
	$roomProfiles = [
		'fruit_slot' => ['title' => 'Fruit Slot', 'subtitle' => 'Classic Orchard', 'badge' => 'Standard Reels', 'start' => '#59202b', 'end' => '#12070c', 'panel' => 'rgba(90,31,42,.92)', 'line' => 'rgba(255,150,171,.26)'],
		'fruit_slot_oasis' => ['title' => 'Fruit Slot Oasis', 'subtitle' => 'Desert Orchard', 'badge' => 'Oasis Room', 'start' => '#6b3c0f', 'end' => '#160803', 'panel' => 'rgba(88,48,14,.92)', 'line' => 'rgba(255,200,122,.24)'],
		'fruit_slot_arsenal' => ['title' => 'Fruit Slot Arsenal', 'subtitle' => 'Steel Reel Bay', 'badge' => 'Arsenal Room', 'start' => '#38424c', 'end' => '#0b0f14', 'panel' => 'rgba(49,58,68,.92)', 'line' => 'rgba(178,188,202,.22)'],
		'fruit_slot_arcade' => ['title' => 'Fruit Slot Arcade', 'subtitle' => 'Pixel Vault', 'badge' => 'Arcade Room', 'start' => '#112b72', 'end' => '#050918', 'panel' => 'rgba(18,43,101,.92)', 'line' => 'rgba(94,255,214,.22)'],
		'fruit_slot_lotus' => ['title' => 'Fruit Slot Lotus', 'subtitle' => 'Jade Garden', 'badge' => 'Lotus Room', 'start' => '#4d1d35', 'end' => '#12040d', 'panel' => 'rgba(69,26,48,.92)', 'line' => 'rgba(255,171,214,.22)'],
		'fruit_slot_glacier' => ['title' => 'Fruit Slot Glacier', 'subtitle' => 'Crystal Reel Bay', 'badge' => 'Glacier Room', 'start' => '#0f3744', 'end' => '#041018', 'panel' => 'rgba(12,40,49,.92)', 'line' => 'rgba(128,225,255,.22)'],
		'greedy' => ['title' => 'Greedy', 'subtitle' => 'Classic Orchard', 'badge' => 'Standard Reels', 'hero' => 'Animated glass board with fast payout orbit.', 'start' => '#59202b', 'end' => '#12070c', 'panel' => 'rgba(90,31,42,.92)', 'line' => 'rgba(255,150,171,.26)'],
		'fruits_loop' => ['title' => 'Fruits Loop', 'subtitle' => 'Vertical Loop Wheel', 'badge' => 'Loop Room', 'start' => '#18225f', 'end' => '#07101f', 'panel' => 'rgba(22,34,95,.92)', 'line' => 'rgba(255,218,118,.30)'],
	];
	$roomProfile = $roomProfiles[$currentGameCode] ?? $roomProfiles['fruit_slot'];
	$tokenMap = ['apple' => '🍎', 'watermelon' => '🍉', 'cherry' => '🍒', 'banana' => '🍌', 'grapes' => '🍇', 'orange' => '🍊', 'mango' => '🥭', 'pineapple' => '🍍'];
	$boardPalette = [
		'apple' => ['accent' => '#ff6b7a', 'glow' => 'rgba(255,107,122,.44)', 'soft' => 'rgba(255,107,122,.18)', 'caption' => 'Ruby'],
		'watermelon' => ['accent' => '#ff4f8b', 'glow' => 'rgba(255,79,139,.46)', 'soft' => 'rgba(255,79,139,.18)', 'caption' => 'Melon'],
		'cherry' => ['accent' => '#ff5470', 'glow' => 'rgba(255,84,112,.44)', 'soft' => 'rgba(255,84,112,.18)', 'caption' => 'Cherry'],
		'banana' => ['accent' => '#ffd85e', 'glow' => 'rgba(255,216,94,.42)', 'soft' => 'rgba(255,216,94,.18)', 'caption' => 'Sun'],
		'grapes' => ['accent' => '#9b6bff', 'glow' => 'rgba(155,107,255,.46)', 'soft' => 'rgba(155,107,255,.18)', 'caption' => 'Violet'],
		'orange' => ['accent' => '#ff9c47', 'glow' => 'rgba(255,156,71,.44)', 'soft' => 'rgba(255,156,71,.18)', 'caption' => 'Citrus'],
		'mango' => ['accent' => '#ffb347', 'glow' => 'rgba(255,179,71,.44)', 'soft' => 'rgba(255,179,71,.18)', 'caption' => 'Mango'],
		'pineapple' => ['accent' => '#76f2ff', 'glow' => 'rgba(118,242,255,.46)', 'soft' => 'rgba(118,242,255,.18)', 'caption' => 'Tropic'],
	];
	$boardProfiles = [];
	$boardRules = (array) ($gameRules['boards'] ?? config('bd_game_final.games.' . $currentGameCode . '.boards', []));
	foreach ($boardRules as $board) {
		$key = (string) ($board['frontend_key'] ?? $board['canonical_key'] ?? 'slot');
		$multiplier = rtrim(rtrim(number_format((float) ($board['multiplier'] ?? 0), 2, '.', ''), '0'), '.');
		$palette = $boardPalette[$key] ?? ['accent' => '#ffd76e', 'glow' => 'rgba(255,215,110,.42)', 'soft' => 'rgba(255,215,110,.18)', 'caption' => 'Lane'];
		$boardProfiles[$key] = [
			'name' => strtoupper((string) ($board['display_name'] ?? $key)),
			'token' => $tokenMap[$key] ?? strtoupper(substr($key, 0, 2)),
			'multiplier' => 'x' . $multiplier,
			'class' => preg_replace('/[^a-z0-9_-]/i', '-', $key),
			'accent' => $palette['accent'],
			'glow' => $palette['glow'],
			'soft' => $palette['soft'],
			'caption' => strtoupper($palette['caption']),
		];
	}
	$chipValues = [100, 500, 1000, 5000, 10000];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover" />
<meta name="theme-color" content="{{ $roomProfile['end'] }}" />
<title>{{ $currentGameName }} · {{ $roomProfile['subtitle'] }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800;900&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
<style>
:root{--start:{{ $roomProfile['start'] }};--end:{{ $roomProfile['end'] }};--panel:{{ $roomProfile['panel'] }};--line:{{ $roomProfile['line'] }};--text:#fffaf3;--muted:rgba(255,239,228,.6);--gold-light:#ffe600;--gold-base:#f7b733;--gold-dark:#b87a00;--gold-gradient:linear-gradient(135deg,#fff275 0%,#ffc107 40%,#b36b00 80%,#ffdf00 100%);--tile-top:#c86bfa;--tile-bottom:#6610a8;--safe-top:max(env(safe-area-inset-top),8px);--safe-right:max(env(safe-area-inset-right),8px);--safe-bottom:max(env(safe-area-inset-bottom),8px);--safe-left:max(env(safe-area-inset-left),8px);--topbar-h:72px;--chip-dock-h:76px}
*{box-sizing:border-box;margin:0;padding:0;-webkit-tap-highlight-color:transparent}
html,body{width:100%;max-width:100%;height:100%;overflow:hidden;background:var(--end);color:var(--text);font-family:Inter,system-ui,sans-serif}
body{display:flex;justify-content:center;background-color:var(--start);background-image:radial-gradient(circle at 50% 0%,rgba(255,255,255,.12) 0%,transparent 60%),radial-gradient(circle at 20% 20%,rgba(255,255,255,.05) 0%,transparent 35%),radial-gradient(circle at 80% 10%,rgba(255,230,0,.06) 0%,transparent 25%);overflow:hidden}
body::before{content:"";position:fixed;inset:0;background:radial-gradient(circle at 15% 25%,rgba(255,255,255,.08) 0 2px,transparent 3px),radial-gradient(circle at 82% 18%,rgba(255,230,0,.12) 0 2px,transparent 3px),radial-gradient(circle at 30% 78%,rgba(255,255,255,.06) 0 2px,transparent 3px),radial-gradient(circle at 75% 70%,rgba(255,130,200,.08) 0 2px,transparent 3px);animation:ambientFloat 8s linear infinite alternate;pointer-events:none}
.app{position:fixed;top:0;bottom:0;left:50%;width:100%;max-width:430px;transform:translateX(-50%);overflow:hidden;background:linear-gradient(180deg,var(--start) 0%,var(--end) 100%);box-shadow:0 0 40px rgba(0,0,0,.8);isolation:isolate}
.app::before{content:"";position:absolute;inset:0;background:radial-gradient(circle at 50% -5%,rgba(255,255,255,.16),transparent 40%),linear-gradient(180deg,rgba(255,255,255,.03),transparent 20%,transparent 80%,rgba(255,255,255,.02));pointer-events:none;z-index:0}
.topbar{position:absolute;top:0;left:0;right:0;height:calc(var(--topbar-h) + var(--safe-top));padding:max(12px,var(--safe-top)) max(15px,var(--safe-right)) 12px max(15px,var(--safe-left));display:grid;grid-template-columns:minmax(0,1fr) auto auto;align-items:center;gap:10px;background:transparent;border:0;box-shadow:none;z-index:10}
.pill{height:42px;padding:5px 15px;border-radius:30px;display:flex;align-items:center;gap:8px;background:rgba(0,0,0,.4);border:2px solid var(--gold-dark);box-shadow:inset 0 2px 5px rgba(0,0,0,.8),0 2px 4px rgba(0,0,0,.3),0 0 14px rgba(255,215,0,.16);position:relative;overflow:hidden;min-width:116px}
.pill::after{content:"";position:absolute;top:0;left:-35%;width:28%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.35),transparent);transform:skewX(-22deg);animation:sheen 3.6s linear infinite}
.pill strong{font-size:16px;font-weight:1000;color:var(--gold-light);min-width:54px;text-align:right;position:relative;z-index:1}
.pill.balance-hit{animation:balanceHit .72s ease}
.brand{text-align:center;position:relative;z-index:1}
.brand b{display:block;font-size:13px;letter-spacing:.16em;text-transform:uppercase}.brand span{font-size:9px;letter-spacing:.22em;text-transform:uppercase;color:var(--muted)}
.brand.system-take{animation:systemTake .78s ease}
.stage{position:absolute;inset:calc(var(--topbar-h) + var(--safe-top)) 0 calc(var(--chip-dock-h) + var(--safe-bottom)) 0;padding:14px 12px;display:flex;flex-direction:column;gap:12px;overflow-y:auto;overscroll-behavior:contain;scrollbar-width:none}
.stage::-webkit-scrollbar{display:none}
.hero{padding:0 10px;margin-top:-4px;border-radius:0;background:transparent;border:0;box-shadow:none;display:flex;flex-direction:column;align-items:center;z-index:10}
.hero,.result-stage,.tile,.chip,.history-card{position:relative;overflow:hidden;backdrop-filter:blur(18px) saturate(126%);-webkit-backdrop-filter:blur(18px) saturate(126%)}
.hero:before,.result-stage:before,.tile:before,.history-card:before{content:"";position:absolute;inset:0;background:linear-gradient(118deg, rgba(255,255,255,.17), rgba(255,255,255,.05) 34%, transparent 61%);opacity:.38;pointer-events:none}
.hero:before{display:none}
.hero-head{width:100%;display:flex;gap:8px;align-items:center;margin-bottom:8px;flex-wrap:wrap;justify-content:center}
body[class*="gf-popup-popup_"] .popup,
body[class*="gf-popup-popup_"] .toast-notification{border-color:var(--admin-accent);box-shadow:0 24px 80px rgba(0,0,0,.48),0 0 28px color-mix(in srgb,var(--admin-accent),transparent 64%)}
body.gf-popup-popup_02 .popup{border-radius:28px}
body.gf-popup-popup_03 .popup{background:linear-gradient(145deg,var(--admin-primary),rgba(7,6,14,.96))}
body.gf-popup-popup_04 .popup{filter:saturate(1.22)}
body.gf-popup-popup_05 .popup{outline:2px solid color-mix(in srgb,var(--admin-accent),transparent 45%)}
.tag,.icon-tool{padding:8px 12px;border-radius:999px;font-size:11px;font-weight:900;letter-spacing:.16em;text-transform:uppercase;background:rgba(255,255,255,.06);border:1px solid var(--line);color:var(--text)}
.net-tag{width:68px;text-align:center;flex:0 0 68px;font-variant-numeric:tabular-nums;display:inline-flex;align-items:center;justify-content:center;gap:5px;padding-inline:8px}
.net-tag svg{width:13px;height:13px;fill:currentColor;flex:0 0 13px}
.net-tag span{display:inline-block;width:34px;text-align:right;font-variant-numeric:tabular-nums;letter-spacing:0}
.icon-tool{width:34px;height:34px;padding:0;display:grid;place-items:center;cursor:pointer;background:linear-gradient(145deg,rgba(255,255,255,.13),rgba(255,255,255,.04));box-shadow:inset 0 1px 0 rgba(255,255,255,.16),0 8px 18px rgba(0,0,0,.25)}
.icon-tool svg{width:17px;height:17px;fill:currentColor;filter:drop-shadow(0 2px 3px rgba(0,0,0,.4))}
.icon-tool svg,.icon-tool svg *{pointer-events:none}
.room-tools{display:flex;justify-content:flex-end;gap:6px}
.recent-strip{flex:1 1 160px;min-width:120px;display:flex;align-items:center;gap:6px;padding:5px 7px;border-radius:999px;background:rgba(0,0,0,.22);border:1px solid rgba(255,255,255,.08);overflow:hidden}
.recent-label{font-size:9px;font-weight:1000;letter-spacing:.14em;color:rgba(255,245,220,.62)}
.recent-track{display:flex;gap:4px;overflow:hidden;min-width:0}
.recent-pill{width:24px;height:24px;border-radius:9px;display:grid;place-items:center;background:linear-gradient(145deg,rgba(255,255,255,.16),rgba(255,255,255,.05));border:1px solid rgba(255,255,255,.12);font-size:16px;flex:0 0 auto}
.active-profile{display:flex;align-items:center;gap:6px;padding:5px 8px;border-radius:999px;background:rgba(0,0,0,.24);border:1px solid rgba(255,255,255,.09);min-width:0}
.avatar-dot{width:24px;height:24px;border-radius:50%;display:grid;place-items:center;background:radial-gradient(circle at 35% 25%,#fff7d1,#ffbd3d 56%,#8f4700 100%);color:#401700;font-size:11px;font-weight:1000;box-shadow:0 4px 10px rgba(0,0,0,.35)}
.active-copy{display:flex;flex-direction:column;line-height:1.05;min-width:0}.active-copy b{font-size:10px;max-width:84px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.active-copy span{font-size:8px;color:var(--muted);letter-spacing:.12em;text-transform:uppercase}
.game-title{display:inline-flex;align-items:center;justify-content:center;max-width:100%;margin:0 auto;padding:6px 28px;border-radius:30px;border:3px solid var(--gold-light);background:linear-gradient(180deg,#ff0055,#800020);box-shadow:0 8px 15px rgba(0,0,0,.6),0 0 18px rgba(255,0,85,.28);color:#fff;font-size:22px;font-weight:1000;text-transform:uppercase;text-align:center;text-shadow:2px 2px 0 #000;position:relative}
.game-title::after{content:"";position:absolute;inset:2px;border-radius:26px;border-top:1px solid rgba(255,255,255,.45);pointer-events:none}
.result-stage{margin-top:14px;padding:14px 16px;border-radius:24px;background:linear-gradient(160deg,rgba(255,255,255,.06),rgba(0,0,0,.18));border:1px solid var(--line);display:grid;grid-template-columns:210px minmax(0,1fr);gap:14px;align-items:center}
.hero .result-stage{display:none}
.result-stage.active{box-shadow:0 0 0 1px rgba(255,255,255,.12),0 0 28px rgba(255,255,255,.08)}
.result-window{padding:10px;border-radius:18px;background:rgba(0,0,0,.18);border:1px solid var(--line);box-shadow:inset 0 0 0 1px rgba(255,255,255,.04)}
.result-track{display:grid;grid-template-columns:repeat(3,1fr);gap:8px}
.reel-cell{min-height:92px;border-radius:18px;background:linear-gradient(180deg,rgba(255,255,255,.08),rgba(0,0,0,.12));border:1px solid rgba(255,255,255,.10);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;transition:transform .22s ease,box-shadow .22s ease,background .22s ease}
.reel-cell.center{background:linear-gradient(180deg,rgba(255,255,255,.14),rgba(0,0,0,.16))}
.reel-cell.hit{box-shadow:0 0 0 1px rgba(255,255,255,.18),0 0 24px rgba(255,255,255,.10);background:linear-gradient(180deg,rgba(255,255,255,.18),rgba(0,0,0,.12))}
.reel-chip{width:50px;height:50px;border-radius:16px;display:grid;place-items:center;background:radial-gradient(circle at 50% 28%, rgba(255,255,255,.28), rgba(255,255,255,.08) 42%, rgba(0,0,0,.18));border:1px solid rgba(255,255,255,.16);font-weight:1000;font-size:32px;filter:drop-shadow(0 5px 6px rgba(0,0,0,.38))}
.reel-label{font-size:11px;font-weight:1000;letter-spacing:.1em;text-transform:uppercase;text-align:center;padding-inline:4px}
.result-track.reveal .reel-cell{animation:reelPulse .72s ease both}
.result-track.reveal .reel-cell:nth-child(2){animation-delay:.08s}
.result-copy{display:flex;flex-direction:column;gap:6px;min-width:0}
.result-kicker{font-size:10px;font-weight:900;letter-spacing:.24em;text-transform:uppercase;color:var(--muted)}
.result-title{font-size:20px;font-weight:1000;letter-spacing:.08em}
.result-text{font-size:13px;line-height:1.45;color:rgba(255,244,236,.72)}
.result-meta{font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:var(--muted)}
@keyframes reelPulse{0%{transform:translateY(18px) scale(.94);opacity:.08}55%{transform:translateY(-4px) scale(1.04);opacity:1}100%{transform:translateY(0) scale(1);opacity:1}}
.board-wrapper{flex:1 1 auto;min-height:0;display:flex;justify-content:center;align-items:center;padding:0 14px;position:relative;z-index:3}
.board-outer{background:var(--gold-gradient);padding:18px;border-radius:28px;width:100%;max-width:430px;position:relative;box-shadow:0 25px 50px rgba(0,0,0,.72),inset 0 10px 15px rgba(255,255,255,.48),inset 0 -10px 20px rgba(138,76,0,.78),0 0 0 3px #4a2700,0 0 25px rgba(255,215,0,.18)}
.board-outer::before,.board-outer::after{content:"";position:absolute;inset:-4px;border-radius:32px;border:8px solid transparent;pointer-events:none}
.board-outer::before{border-top-color:rgba(255,255,255,.38);border-left-color:rgba(255,255,255,.34)}
.board-outer::after{border-bottom-color:rgba(0,0,0,.5);border-right-color:rgba(0,0,0,.5)}
.board-lights-track{position:absolute;inset:10px;border-radius:20px;background:rgba(0,0,0,.3);box-shadow:inset 0 2px 5px rgba(0,0,0,.8);border:2px dashed rgba(255,230,0,.38);animation:lightChase 1.1s linear infinite}
.board-inner{background:#1e0230;border-radius:16px;padding:12px;position:relative;border:4px solid #331500;box-shadow:inset 0 15px 30px rgba(0,0,0,.9),inset 0 -5px 15px rgba(100,20,150,.5),0 5px 10px rgba(255,255,255,.28);overflow:hidden}
.board-inner::before{content:"";position:absolute;inset:0;background:radial-gradient(circle at 50% 40%,rgba(255,255,255,.04),transparent 52%);pointer-events:none}
.board-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;position:relative}
.tile{border:0;border-radius:14px;padding:8px 5px 10px;aspect-ratio:1/1.15;background:linear-gradient(180deg,var(--tile-top),var(--tile-bottom));border:2px solid #f0b3ff;box-shadow:inset 0 -5px 8px rgba(0,0,0,.4),inset 0 5px 8px rgba(255,255,255,.3),0 5px 8px rgba(0,0,0,.7),0 0 12px rgba(255,255,255,.05);text-align:center;color:var(--text);cursor:pointer;transition:transform .14s ease,box-shadow .14s ease,border-color .14s ease,filter .14s ease;z-index:1;isolation:isolate;min-width:0;display:flex;flex-direction:column;align-items:center;justify-content:center}
.tile::before{content:"";position:absolute;top:0;left:-32%;width:30%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.24),transparent);transform:skewX(-20deg);opacity:.7;pointer-events:none}
.tile::after{content:"";position:absolute;inset:auto 10% 7px;height:10px;background:radial-gradient(circle,rgba(255,255,255,.18),transparent 70%);filter:blur(6px);pointer-events:none}
.tile:active{transform:scale(.94) translateY(3px)}
.tile.spin-active{background:linear-gradient(180deg,#fff200,#ff8c00);border-color:#fff;transform:scale(1.08);z-index:10;box-shadow:0 0 28px #ffea00,inset 0 0 18px rgba(255,255,255,.92),0 0 60px rgba(255,234,0,.42);animation:fruitPathBlink .2s ease-in-out infinite alternate}
.tile.spin-active::before{animation:tileShine .7s linear infinite}
.tile.spin-active .multi{color:#5a1d00;-webkit-text-stroke:0;text-shadow:none}
.tile.win{border-color:#fff;background:linear-gradient(180deg,#fff200,#ff8c00);box-shadow:0 0 25px #ffea00,inset 0 0 15px rgba(255,255,255,.85),0 0 55px rgba(255,234,0,.35);animation:fruitWinPulse .9s ease-in-out infinite alternate;z-index:15}
.tile.pending,.tile.bet-placed{animation:betPulse .42s ease}
.tile.selected-flash{box-shadow:0 0 0 2px rgba(255,255,255,.52),0 0 22px rgba(255,232,90,.42),inset 0 0 16px rgba(255,255,255,.35),0 5px 8px rgba(0,0,0,.7)}
.tile.disabled{opacity:.82}
.token{display:grid;place-items:center;font-size:38px;line-height:1;filter:drop-shadow(0 5px 5px rgba(0,0,0,.6));margin-bottom:1px;transition:transform .18s ease}
.tile.pending .token{transform:scale(1.1) rotate(-4deg)}
.name{display:none}
.multi{font-family:Inter,Arial,sans-serif;font-size:clamp(18px,4.7vw,27px);font-weight:1000;color:#fff7cf;-webkit-text-stroke:0;text-shadow:0 2px 0 rgba(44,10,73,.86),0 0 13px rgba(255,215,90,.38);line-height:.95;letter-spacing:-.02em;font-variant-numeric:tabular-nums}
.pool{position:absolute;right:-6px;bottom:-6px;z-index:4;min-width:32px;padding:3px 6px;border-radius:10px;border:2px solid #fff;background:linear-gradient(180deg,#fff275,#b36b00);box-shadow:0 3px 6px rgba(0,0,0,.7);color:#4a1d00;font-family:Inter,"Segoe UI",Arial,sans-serif;font-size:11px;font-weight:1000;text-align:center;font-variant-numeric:tabular-nums;letter-spacing:0;transition:transform .18s ease,filter .18s ease}.tile.bet-placed .pool{transform:translateY(-4px) scale(1.08);filter:brightness(1.14)}.mine{display:none;font-family:Inter,"Segoe UI",Arial,sans-serif;font-variant-numeric:tabular-nums;letter-spacing:0;text-transform:none}
.timer-box{height:100%;min-height:0;border-radius:18px;background:radial-gradient(circle at 50% 38%,#2a0008,#100006 62%,#050001);border:4px solid #ffc107;box-shadow:inset 0 0 25px rgba(255,0,0,.45),0 5px 10px rgba(0,0,0,.8),0 0 12px rgba(255,210,60,.15);display:grid;place-items:center;position:relative;overflow:hidden;z-index:1;transition:opacity .18s ease,visibility .18s ease}
.timer-box::before{content:"";position:absolute;inset:4px;border-radius:12px;border:1px solid rgba(255,255,255,.12);pointer-events:none}
.timer-box.state-warn{box-shadow:inset 0 0 28px rgba(255,180,0,.55),0 5px 10px rgba(0,0,0,.8),0 0 16px rgba(255,213,79,.28)}
.timer-box.state-danger{box-shadow:inset 0 0 32px rgba(255,0,0,.68),0 5px 10px rgba(0,0,0,.8),0 0 18px rgba(255,77,109,.35);animation:dangerBlink .6s ease infinite}
.timer-text{font-family:"Courier New",monospace;font-size:44px;font-weight:1000;color:#ff3333;text-shadow:0 0 10px #f00,2px 2px 0 #000;letter-spacing:-2px;position:relative;z-index:1}
.timer-text.phase-word{font-family:Inter,"Segoe UI",Arial,sans-serif;font-size:clamp(16px,4vw,22px);letter-spacing:.02em;color:#ffd76e;text-shadow:0 0 10px rgba(255,215,110,.72),2px 2px 0 #000}
.chips{position:absolute;left:0;right:0;bottom:0;height:calc(var(--chip-dock-h) + var(--safe-bottom));padding:9px max(14px,var(--safe-right)) max(12px,var(--safe-bottom)) max(14px,var(--safe-left));display:flex;align-items:center;justify-content:space-between;gap:8px;background:linear-gradient(180deg,rgba(0,0,0,.12),rgba(0,0,0,.52));border-top:1px solid rgba(255,255,255,.08);z-index:5}
.chip{flex:1;height:50px;border-radius:20px;border:2px solid #99ccff;cursor:pointer;font-size:13px;font-weight:1000;color:#fff;background:linear-gradient(180deg,#3399ff 0%,#0068c9 48%,#003d82 100%);box-shadow:0 6px 0 #00224d,0 10px 15px rgba(0,0,0,.6),inset 0 1px 0 rgba(255,255,255,.28),inset 0 -8px 12px rgba(0,20,70,.32);transition:transform .12s ease,box-shadow .12s ease,filter .12s ease;position:relative;overflow:hidden;display:flex;align-items:center;justify-content:center;gap:5px;text-shadow:0 2px 2px rgba(0,0,0,.55)}
.chip::before{content:"";position:absolute;top:0;left:-38%;width:28%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.35),transparent);transform:skewX(-18deg);opacity:.8}
.chip::after{display:none}
.chip-coin{position:relative;z-index:1;width:15px;height:15px;border-radius:50%;font-size:0;color:transparent;background:radial-gradient(circle at 35% 28%,#fffbe4 0 18%,#ffd34f 19% 58%,#b36b00 59% 100%);border:1px solid rgba(255,250,210,.95);box-shadow:inset 0 1px 1px rgba(255,255,255,.75),inset 0 -2px 2px rgba(105,55,0,.38),0 2px 3px rgba(0,0,0,.42);filter:drop-shadow(0 2px 2px rgba(0,0,0,.35))}
.chip-coin::after{content:"";position:absolute;inset:4px;border-radius:50%;border:1px solid rgba(126,68,0,.34)}
.chip span:last-child{position:relative;z-index:1}
.chip.selected{background:linear-gradient(180deg,#fff9a6 0%,#fff176 22%,#ff9826 58%,#e65100 100%);border-color:#fff9c4;color:#5e1a00;box-shadow:0 6px 0 #8c2800,0 10px 20px rgba(230,81,0,.6),0 0 18px rgba(255,193,7,.28),inset 0 1px 0 rgba(255,255,255,.55),inset 0 -8px 12px rgba(140,40,0,.28);transform:translateY(-4px);animation:chipActivePulse 1.1s ease infinite;text-shadow:none}
.chip:active{transform:scale(.95)}
.toast{position:absolute;left:12px;right:12px;bottom:calc(var(--chip-dock-h) + var(--safe-bottom) + 10px);transform:translateY(10px) scale(.96);width:fit-content;min-width:0;max-width:min(84vw,330px);margin:auto;padding:11px 16px;border-radius:16px;background:linear-gradient(180deg,rgba(36,10,58,.92),rgba(10,3,18,.96));border:1px solid rgba(255,236,156,.32);box-shadow:0 16px 30px rgba(0,0,0,.45),inset 0 1px 0 rgba(255,255,255,.12),0 0 22px rgba(247,183,51,.12);text-align:center;opacity:0;pointer-events:none;transition:.22s;z-index:18;backdrop-filter:blur(10px)}
.toast.show{opacity:1;transform:translateY(0) scale(1)}
.toast b{display:block;font-size:15px;margin-bottom:3px;color:var(--gold-light);text-transform:uppercase;text-shadow:0 2px 0 #000}.toast span{font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,248,226,.72)}
.history-btn{color:var(--text);cursor:pointer}
.history-modal{position:absolute;inset:0;display:none;align-items:center;justify-content:center;padding:16px;background:rgba(2,2,4,.62);backdrop-filter:blur(12px);z-index:9}
.history-modal.is-open{display:flex}
.history-card{width:min(92vw,460px);max-height:min(82vh,620px);overflow:hidden;padding:18px;border-radius:26px;background:linear-gradient(160deg,var(--panel),rgba(0,0,0,.88));border:1px solid var(--line);box-shadow:0 26px 44px rgba(0,0,0,.42)}
.history-head{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:14px}
.history-head h3{font-size:18px;letter-spacing:.12em;text-transform:uppercase}
.history-head p{font-size:12px;line-height:1.45;color:var(--muted)}
.history-close{padding:9px 14px;border-radius:999px;border:1px solid var(--line);background:rgba(255,255,255,.08);color:var(--text);cursor:pointer}
.history-tabs{display:flex;gap:8px;margin:0 0 14px;overflow:auto;padding-bottom:2px}
.history-tab{border:1px solid var(--line);border-radius:999px;padding:8px 11px;background:rgba(255,255,255,.06);color:var(--text);font-size:10px;font-weight:1000;letter-spacing:.12em;text-transform:uppercase;cursor:pointer;white-space:nowrap}
.history-tab.active{background:linear-gradient(135deg,rgba(255,230,120,.28),rgba(255,255,255,.08));border-color:rgba(255,230,120,.55);color:#fff6c8}
.history-stack{display:grid;gap:14px;min-height:0;overflow:auto;overscroll-behavior:contain}
.history-section{padding:14px;border-radius:20px;background:rgba(255,255,255,.05);border:1px solid var(--line)}
.history-section-head{display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:10px}.history-section-title{font-size:12px;font-weight:1000;letter-spacing:.16em;text-transform:uppercase}.history-section-sub{font-size:11px;color:var(--muted)}
.history-table-wrap{border-radius:16px;overflow:auto;overscroll-behavior:contain;border:1px solid rgba(255,255,255,.08)}
.history-table{width:100%;border-collapse:collapse;font-size:12px;color:var(--text)}
.history-table th,.history-table td{padding:9px 10px;text-align:left;vertical-align:top}.history-table th{position:sticky;top:0;background:rgba(8,8,10,.96);font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:var(--muted);z-index:1}
.history-table tbody tr:nth-child(odd){background:rgba(255,255,255,.03)}.history-table tbody tr:nth-child(even){background:rgba(255,255,255,.06)}
.history-empty{padding:12px;border-radius:14px;background:rgba(255,255,255,.04);color:var(--muted);text-align:center}
.history-board{display:flex;align-items:center;gap:8px;min-width:0}.history-token{width:32px;height:32px;border-radius:10px;display:grid;place-items:center;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);font-size:22px;font-weight:1000;flex:0 0 32px}
.phase-banner-wrap{position:absolute;left:12px;right:12px;top:122px;display:flex;justify-content:center;pointer-events:none;z-index:17}
.phase-banner{min-width:210px;padding:12px 18px;border-radius:18px;background:rgba(17,7,32,.92);border:1px solid rgba(255,255,255,.12);box-shadow:0 18px 34px rgba(0,0,0,.48),inset 0 1px 0 rgba(255,255,255,.08);text-align:center;text-transform:uppercase;font-weight:1000;letter-spacing:.08em;color:#fff;opacity:0;transform:translateY(10px) scale(.96);pointer-events:none}
.phase-banner.show{animation:bannerInOut 1.9s ease both}
.phase-banner.start{border-color:rgba(114,255,143,.45);box-shadow:0 18px 34px rgba(0,0,0,.48),inset 0 1px 0 rgba(255,255,255,.08),0 0 22px rgba(114,255,143,.18)}
.phase-banner.stop{border-color:rgba(255,213,79,.45);box-shadow:0 18px 34px rgba(0,0,0,.48),inset 0 1px 0 rgba(255,255,255,.08),0 0 22px rgba(255,213,79,.18)}
.phase-banner.win{border-color:rgba(255,230,0,.52);box-shadow:0 18px 34px rgba(0,0,0,.48),inset 0 1px 0 rgba(255,255,255,.08),0 0 22px rgba(255,230,0,.22)}
.phase-banner small{display:block;margin-top:4px;font-size:10px;letter-spacing:.18em;color:rgba(255,250,230,.68)}
.modal{position:fixed;inset:0;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,.5);backdrop-filter:blur(5px);z-index:40;opacity:0;visibility:hidden;pointer-events:none;transition:.24s}
.modal.show{opacity:1;visibility:visible;pointer-events:auto}
.modal-card{width:min(86vw,340px);max-height:min(78dvh,360px);padding:22px 20px 18px;border-radius:28px;text-align:center;border:1px solid rgba(255,215,110,.5);box-shadow:0 22px 50px rgba(0,0,0,.55),0 0 34px rgba(255,215,110,.18);transform:translateY(30px) scale(.84);transition:.28s cubic-bezier(.2,.85,.25,1.15);position:relative;overflow:hidden;color:#f8efd8;overscroll-behavior:contain}
.modal.show .modal-card{transform:translateY(0) scale(1)}
.modal-card::before{content:"";position:absolute;inset:0;border-radius:inherit;background:linear-gradient(180deg,rgba(255,255,255,.12),transparent 34%,transparent 70%,rgba(255,215,110,.08));pointer-events:none}
.modal-card::after{content:"";position:absolute;left:14%;right:14%;top:-14px;height:28px;border-radius:999px;background:linear-gradient(90deg,rgba(255,255,255,0),rgba(255,255,255,.32),rgba(255,255,255,0));pointer-events:none;opacity:.88}
.modal-card>*{position:relative;z-index:1}
.popup-kicker{font-size:10px;letter-spacing:.28em;text-transform:uppercase;color:rgba(255,235,185,.72);margin-bottom:10px}
.popup-accent{width:68px;height:6px;border-radius:999px;margin:0 auto 14px;background:linear-gradient(90deg,#8759ff,#ffd76e,#ffb653);box-shadow:0 0 16px rgba(255,215,110,.24)}
.popup-icon{width:54px;height:54px;margin:0 auto 14px;border-radius:16px;display:grid;place-items:center;font-size:24px;background:linear-gradient(145deg,rgba(255,255,255,.15),rgba(255,255,255,.04));border:1px solid rgba(255,255,255,.14);box-shadow:inset 0 1px 0 rgba(255,255,255,.18),0 10px 22px rgba(0,0,0,.22)}
.modal-card h2{margin:0 0 10px;font-size:28px;font-weight:1000;letter-spacing:.04em;background:linear-gradient(135deg,#fffdf6,#ffd76e 58%,#ffb34b);-webkit-background-clip:text;background-clip:text;color:transparent;text-shadow:0 0 18px rgba(255,215,110,.12)}
.modal-card p{margin:0;font-size:14px;color:#f1e8d2;line-height:1.45}
.popup-note{margin-top:12px;padding:10px 12px;border-radius:18px;background:linear-gradient(145deg,rgba(255,255,255,.06),rgba(255,255,255,.03));border:1px solid rgba(255,255,255,.08);font-size:11px;letter-spacing:.08em;text-transform:uppercase;color:rgba(255,241,207,.78)}
.popup-powered{font-size:7px;opacity:.05}
.start-pop .modal-card{background:linear-gradient(160deg,rgba(14,66,42,.98),rgba(9,18,18,.98));border-color:rgba(82,232,138,.64)}
.stop-pop .modal-card{background:linear-gradient(160deg,rgba(76,42,12,.98),rgba(20,12,8,.98));border-color:rgba(255,176,78,.72)}
.winner-pop .modal-card{background:linear-gradient(160deg,rgba(58,34,12,.98),rgba(27,13,32,.98));border-color:rgba(255,215,110,.92);box-shadow:0 24px 56px rgba(0,0,0,.46),0 0 34px rgba(255,215,110,.2)}
.winner-pop .modal-card{min-height:285px}
.winner-pop .modal-card::before{background:radial-gradient(circle at 50% 18%,rgba(255,231,120,.22),transparent 34%),linear-gradient(180deg,rgba(255,255,255,.14),transparent 32%,transparent 70%,rgba(255,185,72,.12))}
.winner-pop .popup-icon{background:radial-gradient(circle at 50% 28%,rgba(255,247,186,.36),rgba(255,185,72,.1) 54%,rgba(0,0,0,.18));box-shadow:0 0 34px rgba(255,215,110,.32),inset 0 1px 0 rgba(255,255,255,.2)}
.fruit-cinema{height:84px;margin:-2px auto 8px;position:relative;display:grid;place-items:center;overflow:visible}
.fruit-cinema-main{font-size:58px;line-height:1;filter:drop-shadow(0 8px 12px rgba(0,0,0,.5));animation:cinemaFruitPop 1.25s ease-in-out infinite alternate}
.cinema-fruit{position:absolute;left:50%;top:50%;font-size:26px;line-height:1;filter:drop-shadow(0 5px 7px rgba(0,0,0,.42));animation:cinemaFruitBurst 1.25s ease-out forwards}
.loss-pop .modal-card{background:linear-gradient(160deg,rgba(54,18,28,.98),rgba(19,9,15,.98));border-color:rgba(255,110,146,.54)}
.nobid-pop .modal-card{background:linear-gradient(160deg,rgba(44,28,58,.98),rgba(12,10,21,.98));border-color:rgba(157,117,255,.52)}
.hit-fx-layer,.win-burst-layer{position:absolute;inset:0;pointer-events:none;z-index:14;overflow:hidden}
.win-burst-layer{z-index:16}
.tap-ring{position:absolute;width:18px;height:18px;margin:-9px 0 0 -9px;border-radius:50%;border:3px solid rgba(255,255,255,.86);box-shadow:0 0 16px rgba(255,255,255,.36),0 0 24px rgba(255,215,0,.24);animation:ringBlast .48s ease-out forwards}
.spark{position:absolute;width:7px;height:7px;margin:-3.5px 0 0 -3.5px;border-radius:50%;background:radial-gradient(circle,#fff,#ffd54f 65%,transparent 70%);box-shadow:0 0 10px rgba(255,255,255,.7);animation:sparkBurst .62s ease-out forwards}
.coin-fly{position:absolute;width:22px;height:22px;margin:-11px 0 0 -11px;border-radius:50%;border:2px solid #fff7c4;background:radial-gradient(circle at 35% 28%,#fffbe6,#ffc107 46%,#a65c00 100%);box-shadow:0 5px 10px rgba(0,0,0,.45),0 0 12px rgba(255,210,60,.34);animation:coinServe .74s ease-out forwards}
.winner-burst{position:absolute;width:190px;height:190px;margin:-95px 0 0 -95px;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,.92) 0%,rgba(255,236,120,.68) 25%,rgba(255,180,0,.2) 52%,transparent 72%);filter:blur(1px);animation:winnerBurst 1s ease-out forwards}
.fruit-rain{position:absolute;margin:-14px 0 0 -14px;font-size:28px;line-height:1;filter:drop-shadow(0 7px 9px rgba(0,0,0,.45));animation:fruitRainBlast 1.15s ease-out forwards}
@keyframes lightChase{from{filter:hue-rotate(0deg)}to{filter:hue-rotate(34deg)}}
@keyframes ambientFloat{from{transform:translateY(0)}to{transform:translateY(-12px)}}
@keyframes sheen{0%{left:-35%}100%{left:125%}}
@keyframes tileShine{0%{left:-30%}100%{left:120%}}
@keyframes fruitWinPulse{0%{transform:scale(1.02)}100%{transform:scale(1.08)}}
@keyframes fruitPathBlink{0%{filter:brightness(1.05) saturate(1.1)}100%{filter:brightness(1.42) saturate(1.45)}}
@keyframes betPulse{0%{transform:scale(.96)}55%{transform:scale(1.035)}100%{transform:scale(1)}}
@keyframes dangerBlink{0%,100%{transform:scale(1)}50%{transform:scale(1.03)}}
@keyframes ringBlast{0%{opacity:1;transform:scale(.25)}100%{opacity:0;transform:scale(4.2)}}
@keyframes sparkBurst{0%{opacity:1;transform:translate(0,0) scale(.7)}100%{opacity:0;transform:translate(var(--dx),var(--dy)) scale(1.2)}}
@keyframes coinServe{0%{opacity:0;transform:translateY(24px) scale(.5) rotate(-120deg)}22%{opacity:1}100%{opacity:0;transform:translateY(-42px) scale(1.05) rotate(280deg)}}
@keyframes winnerBurst{0%{opacity:0;transform:scale(.35)}30%{opacity:1}100%{opacity:0;transform:scale(1.28)}}
@keyframes fruitRainBlast{0%{opacity:0;transform:translate(0,0) scale(.45) rotate(-24deg)}18%{opacity:1}100%{opacity:0;transform:translate(var(--dx),var(--dy)) scale(1.22) rotate(var(--rot))}}
@keyframes cinemaFruitPop{0%{transform:translateY(0) scale(1)}100%{transform:translateY(-5px) scale(1.08)}}
@keyframes cinemaFruitBurst{0%{opacity:0;transform:translate(-50%,-50%) scale(.4) rotate(0)}18%{opacity:1}100%{opacity:0;transform:translate(calc(-50% + var(--dx)),calc(-50% + var(--dy))) scale(1.06) rotate(var(--rot))}}
@keyframes chipActivePulse{0%,100%{filter:brightness(1);box-shadow:inset 0 4px 8px rgba(255,255,255,.44),inset 0 -8px 10px rgba(91,26,0,.48),0 8px 0 #8c2800,0 14px 24px rgba(230,81,0,.48),0 0 16px rgba(255,193,7,.22)}50%{filter:brightness(1.08);box-shadow:inset 0 4px 8px rgba(255,255,255,.5),inset 0 -8px 10px rgba(91,26,0,.46),0 8px 0 #8c2800,0 16px 26px rgba(230,81,0,.58),0 0 28px rgba(255,193,7,.36)}}
@keyframes bannerInOut{0%{opacity:0;transform:translateY(10px) scale(.96)}16%{opacity:1;transform:translateY(0) scale(1)}82%{opacity:1;transform:translateY(0) scale(1)}100%{opacity:0;transform:translateY(-8px) scale(.98)}}
.history-trace{font-size:11px;line-height:1.35;word-break:break-word;color:rgba(255,250,243,.9)}
.history-status{display:inline-flex;align-items:center;justify-content:center;padding:4px 8px;border-radius:999px;font-size:10px;font-weight:1000;letter-spacing:.12em;text-transform:uppercase;white-space:nowrap}.history-status.win{background:rgba(71,232,150,.14);color:#8effc1;border:1px solid rgba(71,232,150,.2)}.history-status.loss{background:rgba(255,106,142,.14);color:#ffb1c1;border:1px solid rgba(255,106,142,.2)}.history-status.pending{background:rgba(255,214,111,.14);color:#ffe29b;border:1px solid rgba(255,214,111,.2)}.history-status.punishment{background:rgba(255,173,92,.14);color:#ffc98f;border:1px solid rgba(255,173,92,.22)}
.profile-grid{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:6px}
.profile-panel{display:grid;grid-template-columns:1fr;gap:5px;align-items:center;justify-items:center;text-align:center;padding:8px 4px;border-radius:12px;background:rgba(255,255,255,.05);border:1px solid var(--line);min-width:0}
.profile-avatar{width:38px;height:38px;border-radius:13px;display:grid;place-items:center;overflow:hidden;background:radial-gradient(circle at 35% 25%,#fff7d1,#ffbd3d 56%,#8f4700 100%);box-shadow:0 8px 14px rgba(0,0,0,.28);color:#401700;font-weight:1000;font-size:15px}
.profile-avatar img{width:100%;height:100%;object-fit:cover;display:block}
.profile-panel b{font-size:9px;line-height:1.15;max-width:100%;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.profile-panel span{display:block;margin-top:2px;font-size:8px;color:var(--muted);letter-spacing:0;text-transform:uppercase;white-space:nowrap}
.settings-row{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:12px;border-radius:16px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.08)}
.settings-row label{font-size:11px;font-weight:1000;letter-spacing:.14em;text-transform:uppercase}.sound-toggle{border:1px solid rgba(255,230,120,.44);border-radius:999px;padding:8px 14px;background:rgba(255,230,120,.13);color:#fff6c8;font-weight:1000;cursor:pointer}.volume-range{width:150px;accent-color:#ffd76e}
.route-coin{position:fixed;left:0;top:0;width:22px;height:22px;margin:-11px 0 0 -11px;border-radius:50%;border:2px solid #fff7c4;background:radial-gradient(circle at 35% 28%,#fffbe6,#ffc107 46%,#a65c00 100%);box-shadow:0 8px 14px rgba(0,0,0,.45),0 0 14px rgba(255,210,60,.36);z-index:80;pointer-events:none;animation:routeCoin var(--dur,.72s) cubic-bezier(.2,.7,.25,1) forwards;animation-delay:var(--delay,0ms)}
@keyframes routeCoin{0%{opacity:0;transform:translate(var(--x0),var(--y0)) scale(.55) rotate(-140deg)}18%{opacity:1}62%{opacity:1;filter:brightness(1.28)}100%{opacity:0;transform:translate(var(--x1),var(--y1)) scale(.72) rotate(380deg)}}
@keyframes balanceHit{0%{filter:brightness(1);transform:scale(1)}45%{filter:brightness(1.35);transform:scale(1.06)}100%{filter:brightness(1);transform:scale(1)}}
@keyframes systemTake{0%{filter:brightness(1);transform:scale(1)}45%{filter:brightness(1.45);transform:scale(1.08)}100%{filter:brightness(1);transform:scale(1)}}
@media(max-width:430px){
	:root{--topbar-h:64px;--chip-dock-h:70px}
	.topbar{gap:8px;padding-left:max(8px,var(--safe-left));padding-right:max(8px,var(--safe-right))}
	.pill{min-width:82px;height:38px;padding:0 10px;gap:6px}
	.pill strong{font-size:16px}
	.brand{max-width:112px}
	.brand b{font-size:13px;letter-spacing:.1em}
	.brand span{font-size:9px;letter-spacing:.18em}
	.stage{padding:10px 8px 12px}
	.hero{padding:8px 8px 10px;border-radius:22px}
	.hero-head{gap:6px;margin-bottom:7px}
	.tag{padding:6px 9px;font-size:10px}
	.net-tag{width:60px;flex-basis:60px}.net-tag span{width:29px}
	.icon-tool{width:31px;height:31px;font-size:12px}.active-copy b{max-width:56px}.recent-pill{width:21px;height:21px;font-size:14px}
	.game-title{padding:5px 22px;font-size:19px}
	.result-stage{margin-top:10px;padding:10px 12px;border-radius:20px;grid-template-columns:1fr;gap:10px}
	.result-window{padding:8px}
	.reel-cell{min-height:74px;border-radius:14px}
	.reel-chip{width:36px;height:36px;border-radius:12px;font-size:14px}
	.reel-label{font-size:10px}
	.result-title{font-size:18px}
	.result-text{font-size:12px}
	.board-grid{gap:6px}
	.tile{border-radius:18px;padding:9px 4px 10px}
	.token{font-size:34px}
	.name{font-size:clamp(8px,2.15vw,10px);letter-spacing:0}
	.multi{font-size:clamp(15px,4.2vw,22px)}.mine{font-size:9px}
	.pool{font-size:16px}
	.chips{padding:8px max(10px,var(--safe-right)) max(10px,var(--safe-bottom)) max(10px,var(--safe-left));gap:6px}
	.chip{min-width:0;height:44px;border-radius:18px;font-size:12px}
}
@media(max-width:380px){
	.pill{min-width:72px;padding:0 8px}
	.pill strong{font-size:14px}
	.brand{max-width:98px}
	.brand b{font-size:12px}
	.brand span{font-size:8px;letter-spacing:.14em}
	.board-grid{gap:5px}
	.token{font-size:30px}
	.name{font-size:8px}
	.pool{font-size:14px}
	.chip{min-width:0;height:40px;border-radius:16px;font-size:10px}
	.toast{min-width:0;width:min(88vw,300px);padding:14px 16px}
}
@media(max-width:340px){
	.brand{max-width:86px}
	.tile{padding:8px 3px 9px}
	.chip{min-width:0;padding:0 4px}
}
@media(max-height:620px){:root{--topbar-h:60px;--chip-dock-h:68px}.stage{padding:10px}.result-stage{grid-template-columns:180px minmax(0,1fr);padding:10px 12px}.reel-cell{min-height:78px;border-radius:14px}.reel-chip{width:36px;height:36px;border-radius:11px}.reel-label{font-size:10px}.result-title{font-size:17px}.result-text{font-size:12px}.board-grid{gap:7px}.tile{border-radius:14px;padding:8px 5px 10px}.token{font-size:33px}.chip{height:44px;border-radius:18px}}
/* Mobile fit layer: fixed bottom chips, no play-surface scroll, 450/325 high screens */
.stage{overflow:hidden}
.chips{position:fixed;left:50%;right:auto;bottom:0;width:100%;max-width:430px;transform:translateX(-50%);flex-wrap:nowrap;overflow:hidden;border-radius:0}
.chip{flex:1 1 0;min-width:0;max-width:64px}
@media(max-height:450px){
	:root{--topbar-h:46px;--chip-dock-h:50px}
	.topbar{padding:max(5px,var(--safe-top)) max(8px,var(--safe-right)) 5px max(8px,var(--safe-left));gap:6px}
	.pill{min-width:66px;height:30px;padding:0 7px}.pill strong{font-size:13px}
	.brand b{font-size:11px}.brand span{display:none}
	.stage{padding:6px;gap:6px;overflow:hidden !important}
	.hero{padding:7px;border-radius:16px}.hero-head{margin-bottom:5px}.tag{padding:4px 6px;font-size:8px}
	.net-tag{width:52px;flex-basis:52px}.net-tag span{width:25px}
	.game-title{padding:4px 16px;font-size:14px;border-width:2px}
	.room-tools{gap:4px}.icon-tool{width:27px;height:27px}.active-profile{display:none}.recent-strip{padding:3px 5px}.recent-pill{width:18px;height:18px;border-radius:7px;font-size:12px}
	.result-stage{display:grid;grid-template-columns:120px minmax(0,1fr);margin-top:5px;padding:6px;border-radius:14px;gap:6px}
	.result-window{padding:5px}.reel-cell{min-height:44px;gap:3px}.reel-chip{width:28px;height:28px;font-size:20px}.reel-label{font-size:7px}
	.result-title{font-size:12px}.result-text,.result-meta,.result-kicker{display:none}
	.board-wrapper{padding:0 6px}.board-outer{padding:9px;border-radius:18px}.board-lights-track{inset:6px}.board-inner{padding:6px;border-radius:11px}.board-grid{gap:6px}.tile{padding:5px 2px;border-radius:10px}.token{font-size:21px}
	.timer-box{border-width:3px;border-radius:12px}.timer-text{font-size:24px;letter-spacing:-1px}
	.name{font-size:8px}.multi{font-size:12px}.mine{display:none}.pool{font-size:10px}
	.chips{height:calc(var(--chip-dock-h) + var(--safe-bottom));padding:5px max(5px,var(--safe-right)) max(5px,var(--safe-bottom)) max(5px,var(--safe-left));gap:4px}
	.chip{height:34px;min-width:0;font-size:9px;border-radius:14px;box-shadow:0 4px 0 #00224d,0 8px 10px rgba(0,0,0,.5)}
	.chip.selected{box-shadow:0 4px 0 #8c2800,0 8px 14px rgba(230,81,0,.5),0 0 12px rgba(255,193,7,.22);transform:translateY(-2px)}
}
@media(max-height:325px){
	:root{--topbar-h:34px;--chip-dock-h:38px}
	.topbar{padding:max(3px,var(--safe-top)) 6px 3px;gap:4px}.pill{min-width:54px;height:24px}.pill strong{font-size:10px}.brand b{font-size:9px}
	.stage{padding:4px;gap:4px}.hero{padding:5px;border-radius:12px}.hero-head{display:flex;position:absolute;top:5px;right:6px;z-index:8;width:auto;height:auto;margin:0;padding:0;gap:0;background:none;border:0;box-shadow:none}.hero-head > :not(.room-tools){display:none!important}.hero-head .room-tools{display:flex!important;gap:4px}.hero-head .icon-tool{width:27px;height:27px}.game-title{font-size:11px;padding:3px 10px}
	.result-stage{display:none}.board-grid{gap:3px}.recent-strip{display:none}
	.tile{padding:4px 2px;border-radius:9px}.token{font-size:16px}.timer-text{font-size:18px}.name{font-size:7px}.pool{font-size:8px}
	.chips{height:calc(var(--chip-dock-h) + var(--safe-bottom));padding:4px 4px max(4px,var(--safe-bottom));gap:3px}.chip{height:27px;font-size:8px;border-radius:11px}.chip-coin{display:none}
}
	.clock.timer-hidden,.timer-box.timer-hidden{opacity:0;visibility:hidden;pointer-events:none}
</style>
@include('game_final.partials.admin_visual_theme_styles')
@include('game_final.partials.mobile_fit_styles')
</head>
<body class="{{ $isGreedyRoom ? 'greaddy-view ' : '' }}gf-popup-{{ $gameTheme['popup_theme'] ?? 'popup_01' }} gf-item-{{ $gameTheme['item_theme'] ?? 'default' }}" style="--admin-primary:{{ $gameTheme['primary_color'] ?? $roomProfile['start'] }};--admin-accent:{{ $gameTheme['accent_color'] ?? '#ffe600' }}">
<div class="app{{ $isGreedyRoom ? ' greaddy-shell' : '' }}">
	<div class="topbar">
		<div class="pill">◈ <strong id="balance">--</strong></div>
		<div class="brand"><b>{{ $currentGameName }}</b><span>{{ $roomProfile['badge'] }}</span></div>
		<div class="pill">R <strong id="round">---</strong></div>
	</div>
	<div class="stage">
		<section class="hero">
			<div class="hero-head">
				<div class="tag" id="phase">SYNCING</div>
				<div class="tag net-tag" aria-label="Network"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 18.5a2.2 2.2 0 1 0 0 .1Zm-5.9-4.4 1.8 1.8a5.8 5.8 0 0 1 8.2 0l1.8-1.8a8.4 8.4 0 0 0-11.8 0Zm-3.6-3.6 1.8 1.8a10.9 10.9 0 0 1 15.4 0l1.8-1.8a13.4 13.4 0 0 0-19 0Z"/></svg><span id="networkMs">sync</span></div>
				<button class="tag history-btn" id="historyBtn" type="button">History</button>
				<div class="active-profile" id="activeProfile">
					<span class="avatar-dot" id="profileInitial">P</span>
					<span class="active-copy"><b id="profileName">Player</b><span>Win <span id="activeUsersCount">0</span></span></span>
				</div>
				<div class="recent-strip"><span class="recent-label">LAST</span><div class="recent-track" id="recentTrack" data-recent-track></div></div>
				<div class="room-tools">
					<button class="icon-tool" id="usersBtn" type="button" aria-label="Active users"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm8.5.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7ZM8 13c-3.3 0-6 1.8-6 4v2h12v-2c0-2.2-2.7-4-6-4Zm8.5.5c-.9 0-1.8.2-2.6.5 1.3.9 2.1 2 2.1 3.4V19h6v-1.7c0-2.1-2.5-3.8-5.5-3.8Z"/></svg></button>
					<button class="icon-tool" id="settingsBtn" type="button" aria-label="Sound settings"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 9v6h4l5 4V5L8 9H4Zm13.7-2.7-1.4 1.4A6 6 0 0 1 18 12a6 6 0 0 1-1.7 4.3l1.4 1.4A8 8 0 0 0 20 12a8 8 0 0 0-2.3-5.7Zm-2.8 2.8-1.4 1.4c.4.4.6.9.6 1.5s-.2 1.1-.6 1.5l1.4 1.4A4 4 0 0 0 16 12a4 4 0 0 0-1.1-2.9Z"/></svg></button>
				</div>
			</div>
			<div class="game-title">{{ $isGreedyRoom ? $currentGameName : $roomProfile['badge'] }}</div>
			@if ($isGreedyRoom)
			<p class="hero-copy">{{ $roomProfile['hero'] }}</p>
			<div class="hero-badges">
				<span>{{ count($boardProfiles) }} Boards</span>
				<span>{{ $roomProfile['badge'] }}</span>
				<span>Glassy Live FX</span>
			</div>
			@endif
			<div class="result-stage" id="resultStage">
				<div class="result-window">
					<div class="result-track" id="resultTrack">
						@for ($slotIndex = 0; $slotIndex < 3; $slotIndex++)
						<div class="reel-cell{{ $slotIndex === 1 ? ' center' : '' }}" data-result-slot="{{ $slotIndex }}">
							<div class="reel-chip" data-result-chip>--</div>
							<div class="reel-label" data-result-label>WAIT</div>
						</div>
						@endfor
					</div>
				</div>
				<div class="result-copy">
					<div class="result-kicker">Result Reel</div>
					<div class="result-title" id="resultTitle">Reels armed</div>
					<div class="result-text" id="resultText">The slot window stops on the winning fruit when the round reveals.</div>
					<div class="result-meta" id="resultMeta">Awaiting result</div>
				</div>
			</div>
		</section>
		<section class="board-wrapper">
			<div class="board-outer">
				@if ($isGreedyRoom)
				<div class="board-crown"><span>Greedy Table</span><b>{{ count($boardProfiles) }} Board Orbit</b></div>
				<div class="greedy-main-trend" aria-label="Greedy trending winners">
					<span class="recent-label">TRENDING</span>
					<div class="recent-track" id="greedyTrendTrack" data-recent-track></div>
				</div>
				@endif
				<div class="board-lights-track"></div>
				<div class="board-inner">
					<div class="board-grid">
						@foreach ($boardProfiles as $boardKey => $profile)
						<button class="tile{{ $isGreedyRoom ? ' tile-' . $profile['class'] : '' }}" data-board="{{ $boardKey }}" title="{{ $profile['name'] }}" type="button"@if($isGreedyRoom) style="--tile-accent:{{ $profile['accent'] }};--tile-glow:{{ $profile['glow'] }};--tile-accent-soft:{{ $profile['soft'] }};"@endif>
							<div class="token">{{ $profile['token'] }}</div>
							@if ($isGreedyRoom)
							<div class="tile-caption">{{ $profile['caption'] }}</div>
							@endif
							<div class="name">{{ $profile['name'] }}</div>
							<div class="multi">{{ strtoupper($profile['multiplier']) }}</div>
							<div class="pool" id="pool-{{ $boardKey }}">0</div>
							<div class="mine" id="mine-{{ $boardKey }}">Tap to stake</div>
						</button>
						@if ($loop->iteration === 4)
						@if ($isGreedyRoom)
						<div class="timer-box state-normal timer-hidden"><div class="timer-core"><div class="timer-label">Round Clock</div><div class="timer-text" id="time">--</div><div class="timer-foot">Greedy Live</div></div></div>
						@else
						<div class="timer-box state-normal timer-hidden"><div class="timer-text" id="time">--</div></div>
						@endif
						@endif
						@endforeach
					</div>
				</div>
			</div>
		</section>
	</div>
	<div class="chips">
		@foreach ($chipValues as $chipValue)
		<button class="chip{{ $chipValue === 500 ? ' selected' : '' }}" type="button" data-value="{{ $chipValue }}"><span class="chip-coin">🪙</span><span>{{ $chipValue >= 1000 ? rtrim(rtrim(number_format($chipValue / 1000, 1), '0'), '.') . 'K' : $chipValue }}</span></button>
		@endforeach
	</div>
	<div class="hit-fx-layer" id="hitFxLayer"></div>
	<div class="win-burst-layer" id="winBurstLayer"></div>
	<div class="phase-banner-wrap"><div class="phase-banner" id="phaseBanner"></div></div>
	<div class="toast" id="toast"><b id="toastTitle">{{ $roomProfile['badge'] }}</b><span id="toastText">Live room booting</span></div>
	<div class="modal start-pop" id="modalStart"><div class="modal-card"><div class="popup-kicker">Phase Start</div><div class="popup-accent"></div><div class="popup-icon">⚡</div><h2>START BET</h2><p>Place your coins now</p><div class="popup-note">Tap any fruit to lock your bid</div><div class="popup-powered">Powerd by JAMBOai</div></div></div>
	<div class="modal stop-pop" id="modalStop"><div class="modal-card"><div class="popup-kicker">Bet Lock</div><div class="popup-accent"></div><div class="popup-icon">⏰</div><h2>STOP BET</h2><p>No more bets</p><div class="popup-note">Board is locked · result light is starting</div><div class="popup-powered">Powerd by JAMBOai</div></div></div>
	<div class="modal winner-pop" id="modalWin"><div class="modal-card"><div class="popup-kicker">Winner Result</div><div class="popup-accent"></div><div class="popup-icon">🏆</div><div class="fruit-cinema" id="winFruitCinema"><div class="fruit-cinema-main" id="winFruitMain">🍎</div></div><h2>YOU WIN</h2><p id="winText">Payout ready</p><div class="popup-note">Win chips are transferring to balance</div><div class="popup-powered">Powerd by JAMBOai</div></div></div>
	<div class="modal loss-pop" id="modalLoss"><div class="modal-card"><div class="popup-kicker">Round Result</div><div class="popup-accent"></div><div class="popup-icon">♦</div><h2>YOU LOSE</h2><p>Try again next round</p><div class="popup-note">Next fruit can turn the table</div><div class="popup-powered">Powerd by JAMBOai</div></div></div>
	<div class="modal nobid-pop" id="modalNoBid"><div class="modal-card"><div class="popup-kicker">No Action</div><div class="popup-accent"></div><div class="popup-icon">🪙</div><h2>NO BID</h2><p>Select a chip and tap a fruit</p><div class="popup-note">Next round starts soon</div><div class="popup-powered">Powerd by JAMBOai</div></div></div>
	<div class="history-modal" id="historyModal">
		<div class="history-card">
			<div class="history-head">
				<div>
					<h3 id="historyTitle">Room History</h3>
					<p id="historySubtitle">Last 15 winning boards and your last 15 bet tickets.</p>
				</div>
				<button class="history-close" id="historyClose" type="button">Close</button>
			</div>
			<div class="history-tabs">
				<button class="history-tab active" type="button" data-panel="history">History</button>
				<button class="history-tab" type="button" data-panel="winners">Last 10</button>
				<button class="history-tab" type="button" data-panel="users">Users</button>
				<button class="history-tab" type="button" data-panel="settings">Sound</button>
			</div>
			<div class="history-stack" id="historyContent"></div>
		</div>
	</div>
<style id="fruit-slot-history-popup-stability">
  .modal .modal-card{
    overflow:hidden !important;
    overscroll-behavior:contain !important;
  }
  .history-modal{
    position:fixed !important;
    inset:0 !important;
    padding:clamp(10px,3vw,18px) !important;
    background:rgba(2,2,4,.74) !important;
  }
  .history-card{
    width:min(96vw,460px) !important;
    max-height:min(84dvh,720px) !important;
    padding:18px 16px 16px !important;
    border-radius:24px !important;
    overflow:hidden !important;
    display:flex !important;
    flex-direction:column !important;
    gap:12px !important;
  }
  .history-head{
    align-items:flex-start !important;
    gap:12px !important;
    margin-bottom:0 !important;
  }
  .history-head > div{
    min-width:0 !important;
    flex:1 1 auto !important;
  }
  .history-close{
    flex:0 0 auto !important;
    white-space:nowrap !important;
  }
  .history-tabs{
    margin:0 !important;
    padding-bottom:4px !important;
  }
  .history-stack{
    flex:1 1 auto !important;
    min-height:0 !important;
    overflow-x:hidden !important;
    overflow-y:auto !important;
    overscroll-behavior:contain !important;
    -webkit-overflow-scrolling:touch !important;
    padding-right:4px !important;
  }
  .history-section-head{
    align-items:flex-start !important;
    flex-direction:column !important;
    gap:4px !important;
  }
  .history-table-wrap{
    max-height:none !important;
    overflow-x:hidden !important;
    overflow-y:auto !important;
    overscroll-behavior:contain !important;
    -webkit-overflow-scrolling:touch !important;
  }
  .history-card *,
  .modal-card *{
    min-width:0 !important;
    max-width:100% !important;
    box-sizing:border-box !important;
  }
  .history-table{
    width:100% !important;
    min-width:0 !important;
    max-width:100% !important;
    table-layout:fixed !important;
  }
  .history-table th,
  .history-table td{
    white-space:normal !important;
    overflow-wrap:anywhere !important;
    word-break:break-word !important;
  }
  .profile-grid{
    grid-template-columns:repeat(6,minmax(0,1fr)) !important;
  }
  .settings-row{
    align-items:flex-start !important;
    flex-wrap:wrap !important;
  }
  .volume-range{
    width:100% !important;
  }
  @media (max-width: 430px){
    .history-card{
      width:min(96vw,390px) !important;
      padding:16px 14px 14px !important;
      border-radius:20px !important;
    }
    .history-head h3{
      font-size:16px !important;
    }
    .history-table th,
    .history-table td{
      padding:8px 7px !important;
      font-size:11px !important;
    }
    .profile-grid{
      grid-template-columns:repeat(6,minmax(0,1fr)) !important;
      gap:5px !important;
    }
  }
  @media (max-height: 700px){
    .history-card{
      max-height:88dvh !important;
    }
  }
  @media (max-height: 450px){
    .topbar{
      padding:max(4px,var(--safe-top)) max(8px,var(--safe-right)) 4px max(8px,var(--safe-left)) !important;
      gap:6px !important;
    }
    .pill{
      min-width:76px !important;
      height:28px !important;
      padding:0 8px !important;
      border-radius:18px !important;
    }
    .pill strong{
      min-width:40px !important;
      font-size:12px !important;
    }
    .brand{
      max-width:112px !important;
    }
    .brand b{
      font-size:12px !important;
      letter-spacing:.08em !important;
      line-height:1.05 !important;
      color:#fff4c2 !important;
      text-shadow:0 1px 0 rgba(0,0,0,.72) !important;
    }
    .hero{
      padding:3px 4px 4px !important;
    }
    .hero-head{
      display:flex !important;
      position:absolute !important;
      top:5px !important;
      right:6px !important;
      z-index:8 !important;
      width:auto !important;
      height:auto !important;
      min-height:0 !important;
      margin:0 !important;
      gap:0 !important;
      align-items:center !important;
      justify-content:flex-end !important;
      flex-wrap:nowrap !important;
      overflow:visible !important;
    }
    .hero-head > .active-profile,
    .hero-head > .recent-strip,
    .hero-head > .tag,
    .hero-head > .history-btn{
      display:none !important;
    }
    .hero-head > .room-tools{
      display:flex !important;
      gap:4px !important;
      align-items:center !important;
      justify-content:flex-end !important;
      flex:0 0 auto !important;
    }
    .net-tag{
      min-width:48px !important;
      flex-basis:48px !important;
    }
    .history-btn{
      min-width:58px !important;
    }
    .game-title{
      padding:3px 12px !important;
      min-height:24px !important;
      border-width:2px !important;
      border-radius:16px !important;
      font-size:12px !important;
      letter-spacing:.08em !important;
      box-shadow:0 5px 10px rgba(0,0,0,.5),0 0 12px rgba(255,0,85,.22) !important;
    }
    .game-title::after{
      inset:1px !important;
      border-radius:13px !important;
    }
    .board-wrapper{
      padding:0 2px !important;
      align-items:flex-start !important;
    }
    .board-outer{
      width:min(100%,318px) !important;
      max-width:318px !important;
      padding:6px !important;
      border-radius:16px !important;
    }
    .board-lights-track{
      inset:4px !important;
      border-width:1px !important;
      border-radius:14px !important;
    }
    .board-inner{
      padding:5px !important;
      border-width:3px !important;
      border-radius:9px !important;
    }
    .board-grid{
      gap:3px !important;
    }
    .tile{
      padding:3px 2px !important;
      border-radius:8px !important;
      aspect-ratio:1 / .82 !important;
    }
    .token{
      font-size:16px !important;
    }
    .name{
      font-size:7px !important;
    }
    .multi{
      font-size:10px !important;
    }
    .pool{
      right:-4px !important;
      bottom:-4px !important;
      font-size:7px !important;
      min-width:20px !important;
      padding:1px 4px !important;
      border-width:1px !important;
      border-radius:8px !important;
    }
    .timer-box{
      border-width:2px !important;
      border-radius:10px !important;
    }
    .timer-box::before{
      inset:3px !important;
      border-radius:7px !important;
    }
    .timer-text{
      font-size:21px !important;
      letter-spacing:-1px !important;
    }
    .modal .modal-card{
      width:min(86vw,320px) !important;
      max-height:min(76dvh,300px) !important;
      padding:16px 14px 12px !important;
      border-radius:22px !important;
    }
    .history-modal{
      padding:10px !important;
    }
    .history-card{
      width:min(96vw,360px) !important;
      max-height:min(82dvh,370px) !important;
      padding:14px 12px 12px !important;
      border-radius:18px !important;
      gap:10px !important;
    }
    .history-tabs{
      gap:6px !important;
      padding-bottom:2px !important;
    }
    .history-stack{
      gap:10px !important;
    }
    .history-table th,
    .history-table td{
      padding:7px 6px !important;
      font-size:10px !important;
    }
  }
</style>
<style id="greaddy-glass-override">
  body.greaddy-view{
    font-family:"Outfit","Segoe UI",sans-serif;
    background:
      radial-gradient(circle at 18% 16%, rgba(255,118,118,.15), transparent 26%),
      radial-gradient(circle at 84% 12%, rgba(118,242,255,.16), transparent 24%),
      radial-gradient(circle at 52% 72%, rgba(255,214,107,.12), transparent 28%),
      linear-gradient(180deg, #0d1120 0%, {{ $roomProfile['start'] }} 30%, {{ $roomProfile['end'] }} 100%);
  }
  body.greaddy-view::after{
    content:"";
    position:fixed;
    inset:0;
    pointer-events:none;
    background:
      radial-gradient(circle at 20% 30%, rgba(255,255,255,.14) 0 2px, transparent 3px),
      radial-gradient(circle at 78% 20%, rgba(118,242,255,.16) 0 2px, transparent 3px),
      radial-gradient(circle at 26% 82%, rgba(255,214,107,.13) 0 2px, transparent 3px),
      radial-gradient(circle at 76% 70%, rgba(255,139,186,.13) 0 2px, transparent 3px);
    animation:greaddyDust 14s linear infinite alternate;
  }
  .greaddy-shell{
    background:
      radial-gradient(circle at top, rgba(255,255,255,.16), transparent 32%),
      radial-gradient(circle at 50% 42%, rgba(255,255,255,.05), transparent 45%),
      linear-gradient(180deg, rgba(255,255,255,.04), transparent 24%),
      linear-gradient(180deg, {{ $roomProfile['start'] }} 0%, #11162b 46%, {{ $roomProfile['end'] }} 100%);
  }
  .greaddy-shell::after{
    content:"";
    position:absolute;
    inset:12px;
    border-radius:34px;
    border:1px solid rgba(255,255,255,.08);
    pointer-events:none;
    opacity:.7;
  }
  .greaddy-shell .topbar{
    grid-template-columns:minmax(0,1fr) minmax(0,1.4fr) minmax(0,1fr);
    gap:12px;
    padding:max(12px,var(--safe-top)) max(14px,var(--safe-right)) 10px max(14px,var(--safe-left));
  }
  .greaddy-shell .pill,
  .greaddy-shell .brand,
  .greaddy-shell .hero-head,
  .greaddy-shell .result-stage,
  .greaddy-shell .board-outer,
  .greaddy-shell .history-card,
  .greaddy-shell .modal-card,
  .greaddy-shell .toast{
    background:linear-gradient(180deg, rgba(255,255,255,.12), rgba(255,255,255,.05));
    border:1px solid rgba(255,255,255,.14);
    box-shadow:0 18px 42px rgba(3,6,18,.44), inset 0 1px 0 rgba(255,255,255,.16);
    backdrop-filter:blur(22px) saturate(135%);
    -webkit-backdrop-filter:blur(22px) saturate(135%);
  }
  .greaddy-shell .pill{
    min-width:98px;
    height:46px;
    border-radius:20px;
    gap:10px;
    background:linear-gradient(180deg, rgba(255,255,255,.16), rgba(12,15,27,.48));
    border-color:rgba(255,255,255,.18);
  }
  .greaddy-shell .pill strong{
    font-family:"Space Grotesk","Outfit",sans-serif;
    color:#fff7e6;
    text-shadow:0 0 14px rgba(255,215,110,.22);
  }
  .greaddy-shell .brand{
    padding:10px 12px;
    border-radius:24px;
    text-align:center;
  }
  .greaddy-shell .brand b{
    font-family:"Space Grotesk","Outfit",sans-serif;
    font-size:16px;
    letter-spacing:.12em;
  }
  .greaddy-shell .brand span{
    font-size:9px;
    letter-spacing:.22em;
    color:rgba(255,244,223,.74);
  }
  .greaddy-shell .stage{
    padding:16px 12px 14px;
    gap:16px;
    overflow-y:auto;
    scroll-padding-bottom:calc(var(--chip-dock-h) + var(--safe-bottom) + 18px);
  }
  .greaddy-shell .stage::-webkit-scrollbar{
    display:none;
  }
  .greaddy-shell .hero{
    width:100%;
    gap:12px;
    padding:0;
  }
  .greaddy-shell .hero-head{
    width:100%;
    padding:12px;
    border-radius:28px;
    justify-content:center;
    gap:8px;
  }
  .greaddy-shell .tag,
  .greaddy-shell .icon-tool,
  .greaddy-shell .recent-strip,
  .greaddy-shell .active-profile{
    background:rgba(8,12,28,.42);
    border-color:rgba(255,255,255,.10);
  }
  .greaddy-shell .hero-head > .recent-strip{
    display:none;
  }
  .greaddy-shell .greedy-main-trend{
    position:relative;
    z-index:2;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    width:100%;
    margin:-2px 0 12px;
    padding:7px 10px;
    border-radius:999px;
    background:linear-gradient(180deg, rgba(255,255,255,.12), rgba(8,12,28,.42));
    border:1px solid rgba(255,255,255,.14);
    box-shadow:inset 0 1px 0 rgba(255,255,255,.14), 0 12px 24px rgba(3,6,18,.24);
    overflow:hidden;
  }
  .greaddy-shell .greedy-main-trend .recent-label{
    color:#fff3be;
    flex:0 0 auto;
  }
  .greaddy-shell .greedy-main-trend .recent-track{
    flex:1 1 auto;
    justify-content:center;
    gap:6px;
  }
  .greaddy-shell .greedy-main-trend .recent-pill{
    width:26px;
    height:26px;
    border-radius:10px;
    background:linear-gradient(145deg, rgba(255,255,255,.20), rgba(255,255,255,.06));
    box-shadow:0 6px 12px rgba(3,6,18,.28), inset 0 1px 0 rgba(255,255,255,.12);
  }
  .greaddy-shell .game-title{
    padding:12px 28px;
    border-radius:999px;
    border:1px solid rgba(255,255,255,.18);
    background:
      radial-gradient(circle at 30% 25%, rgba(255,255,255,.32), transparent 30%),
      linear-gradient(135deg, rgba(255,255,255,.14), rgba(255,255,255,.05)),
      linear-gradient(135deg, rgba(255,118,118,.38), rgba(118,242,255,.26));
    box-shadow:0 18px 34px rgba(7,12,27,.40), 0 0 28px rgba(255,118,118,.14);
    color:#fff7ed;
    font-family:"Space Grotesk","Outfit",sans-serif;
    font-size:28px;
    letter-spacing:.08em;
    text-shadow:none;
  }
  .greaddy-shell .hero-copy{
    max-width:320px;
    margin:0 auto;
    text-align:center;
    font-size:13px;
    line-height:1.5;
    color:rgba(255,244,231,.78);
  }
  .greaddy-shell .hero-badges{
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:8px;
  }
  .greaddy-shell .hero-badges span{
    padding:7px 12px;
    border-radius:999px;
    border:1px solid rgba(255,255,255,.12);
    background:rgba(8,12,28,.38);
    font-size:10px;
    font-weight:800;
    letter-spacing:.18em;
    text-transform:uppercase;
    color:#fff4e2;
  }
  .greaddy-shell .result-stage{
    width:100%;
    margin-top:0;
    padding:14px;
    border-radius:30px;
    grid-template-columns:1fr;
    gap:12px;
  }
  .greaddy-shell .result-window{
    background:rgba(8,12,28,.34);
    border:1px solid rgba(255,255,255,.10);
  }
  .greaddy-shell .reel-cell{
    min-height:82px;
    border-radius:20px;
    background:linear-gradient(180deg, rgba(255,255,255,.12), rgba(10,14,30,.40));
    border:1px solid rgba(255,255,255,.12);
  }
  .greaddy-shell .reel-chip{
    width:46px;
    height:46px;
    border-radius:15px;
    background:radial-gradient(circle at 30% 24%, rgba(255,255,255,.42), rgba(255,255,255,.08) 42%, rgba(8,12,24,.36));
  }
  .greaddy-shell .result-kicker,
  .greaddy-shell .result-meta{
    color:rgba(255,241,218,.68);
  }
  .greaddy-shell .result-title{
    font-family:"Space Grotesk","Outfit",sans-serif;
    font-size:22px;
  }
  .greaddy-shell .board-wrapper{
    padding:0 2px 8px;
  }
  .greaddy-shell .board-outer{
    padding:20px 16px 16px;
    border-radius:34px;
    overflow:visible;
  }
  .greaddy-shell .board-crown{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:10px;
    margin-bottom:12px;
    padding:0 4px;
  }
  .greaddy-shell .board-crown span,
  .greaddy-shell .board-crown b{
    font-size:10px;
    letter-spacing:.20em;
    text-transform:uppercase;
    color:rgba(255,243,224,.74);
  }
  .greaddy-shell .board-crown b{
    color:#fff8ed;
  }
  .greaddy-shell .board-lights-track{
    inset:44px 14px 14px;
    border-radius:28px;
    border:1px solid rgba(255,255,255,.08);
    background:
      radial-gradient(circle at center, rgba(255,255,255,.05), transparent 54%),
      linear-gradient(180deg, rgba(255,255,255,.04), rgba(5,9,22,.28));
    box-shadow:inset 0 0 42px rgba(6,12,28,.56);
  }
  .greaddy-shell .board-inner{
    background:linear-gradient(180deg, rgba(255,255,255,.06), rgba(6,10,25,.30));
    border-radius:28px;
    border:1px solid rgba(255,255,255,.08);
    padding:12px;
    box-shadow:none;
  }
  .greaddy-shell .board-grid{
    gap:12px;
  }
  .greaddy-shell .board-grid > .timer-box{
    aspect-ratio:1/1.15;
    height:auto;
    min-height:0;
    align-self:stretch;
  }
  .greaddy-shell .tile{
    border-radius:24px;
    padding:11px 8px 14px;
    background:
      radial-gradient(circle at 26% 22%, rgba(255,255,255,.34), transparent 26%),
      linear-gradient(180deg, rgba(255,255,255,.18), rgba(255,255,255,.04)),
      linear-gradient(160deg, rgba(11,15,31,.90), rgba(22,10,28,.96));
    border:1px solid rgba(255,255,255,.14);
    box-shadow:0 18px 30px rgba(3,6,18,.46), inset 0 1px 0 rgba(255,255,255,.12), inset 0 0 0 1px rgba(255,255,255,.03), 0 0 0 1px var(--tile-accent-soft);
  }
  .greaddy-shell .tile::after{
    content:"";
    position:absolute;
    inset:10px;
    height:auto;
    border-radius:18px;
    border:1px solid var(--tile-accent-soft);
    background:radial-gradient(circle at 50% 100%, var(--tile-accent-soft), transparent 58%);
    filter:none;
    pointer-events:none;
  }
  .greaddy-shell .tile:hover{
    transform:translateY(-4px);
  }
  .greaddy-shell .tile-caption{
    margin-bottom:5px;
    font-size:9px;
    font-weight:800;
    letter-spacing:.24em;
    text-transform:uppercase;
    color:var(--tile-accent);
  }
  .greaddy-shell .token{
    font-size:36px;
    margin-bottom:4px;
  }
  .greaddy-shell .name{
    display:block;
    margin-bottom:6px;
    font-size:10px;
    font-weight:800;
    letter-spacing:.18em;
    text-transform:uppercase;
    color:rgba(255,244,227,.72);
  }
  .greaddy-shell .multi{
    font-family:"Space Grotesk","Outfit",sans-serif;
    color:#fff7eb;
    text-shadow:0 0 14px var(--tile-glow);
  }
  .greaddy-shell .mine{
    display:block;
    margin-top:8px;
    font-size:9px;
    font-weight:700;
    letter-spacing:.12em;
    text-transform:uppercase;
    color:rgba(255,241,223,.66);
  }
  .greaddy-shell .pool{
    right:50%;
    bottom:-11px;
    transform:translateX(50%);
    min-width:52px;
    padding:5px 9px;
    border-radius:999px;
    border:1px solid rgba(255,255,255,.22);
    background:linear-gradient(180deg, rgba(255,255,255,.96), rgba(255,232,197,.88));
    box-shadow:0 8px 18px rgba(3,6,18,.42);
    color:#31180b;
  }
  .greaddy-shell .tile.spin-active,
  .greaddy-shell .tile.win{
    border-color:rgba(255,255,255,.82);
    transform:translateY(-8px) scale(1.05);
    box-shadow:0 0 0 1px rgba(255,255,255,.22), 0 0 34px var(--tile-glow), 0 18px 34px rgba(3,6,18,.56);
  }
  .greaddy-shell .tile.win{
    animation:greaddyWinnerPulse 1s ease-in-out infinite alternate;
  }
  .greaddy-shell .timer-box{
    border-radius:30px;
    background:
      radial-gradient(circle at 50% 28%, rgba(118,242,255,.20), transparent 35%),
      radial-gradient(circle at 50% 72%, rgba(255,118,118,.18), transparent 42%),
      linear-gradient(180deg, rgba(255,255,255,.14), rgba(7,11,23,.52));
    border:1px solid rgba(255,255,255,.16);
    box-shadow:0 20px 36px rgba(3,6,18,.48), inset 0 0 0 1px rgba(255,255,255,.06);
  }
  .greaddy-shell .timer-box::after{
    content:"";
    position:absolute;
    inset:10px;
    border-radius:24px;
    border:1px dashed rgba(255,255,255,.12);
    pointer-events:none;
  }
  .greaddy-shell .timer-core{
    position:relative;
    z-index:1;
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:5px;
  }
  .greaddy-shell .timer-label,
  .greaddy-shell .timer-foot{
    font-size:10px;
    font-weight:800;
    letter-spacing:.22em;
    text-transform:uppercase;
    color:rgba(255,242,224,.72);
  }
  .greaddy-shell .timer-text{
    font-family:"Space Grotesk","Outfit",sans-serif;
    font-size:40px;
    color:#fff8ef;
    letter-spacing:-.06em;
    text-shadow:0 0 22px rgba(118,242,255,.26);
  }
  .greaddy-shell .chips{
    background:linear-gradient(180deg, rgba(255,255,255,.08), rgba(6,9,18,.66));
    border-top:1px solid rgba(255,255,255,.08);
    backdrop-filter:blur(20px);
    -webkit-backdrop-filter:blur(20px);
    display:grid;
    grid-template-columns:repeat(5, minmax(0, 1fr));
    justify-content:stretch;
  }
  .greaddy-shell .chip{
    min-width:0;
    height:54px;
    border-radius:22px;
    border:1px solid rgba(255,255,255,.16);
    background:linear-gradient(180deg, rgba(255,255,255,.18), rgba(10,15,31,.52));
    box-shadow:0 14px 24px rgba(3,6,18,.44), inset 0 1px 0 rgba(255,255,255,.16);
    font-family:"Space Grotesk","Outfit",sans-serif;
    font-size:13px;
  }
  .greaddy-shell .chip.selected{
    color:#2b120b;
    background:linear-gradient(180deg, #fff4c4 0%, #ffd56f 36%, #ff9f5b 100%);
    box-shadow:0 14px 28px rgba(255,159,91,.34), 0 0 24px rgba(255,213,111,.26);
  }
  .greaddy-shell .chip span:last-child{
    white-space:nowrap;
  }
  .greaddy-shell .toast{
    border-radius:22px;
    background:linear-gradient(180deg, rgba(24,19,39,.94), rgba(9,11,21,.96));
  }
  .greaddy-shell .phase-banner{
    border-radius:20px;
    background:linear-gradient(180deg, rgba(20,15,35,.95), rgba(7,9,18,.96));
  }
  .greaddy-shell .history-card{
    border-radius:30px !important;
    background:linear-gradient(180deg, rgba(19,17,35,.96), rgba(7,10,19,.98)) !important;
  }
  .greaddy-shell .history-section,
  .greaddy-shell .settings-row,
  .greaddy-shell .history-tab,
  .greaddy-shell .history-close{
    background:rgba(255,255,255,.05);
    border-color:rgba(255,255,255,.08);
  }
  .greaddy-shell .modal-card{
    border-radius:30px;
  }
  .greaddy-shell .modal-card h2{
    font-family:"Space Grotesk","Outfit",sans-serif;
    font-size:30px;
  }
  .greaddy-shell .popup-powered{
    margin-top:14px;
    font-size:7px;
    opacity:.05;
    font-weight:800;
    letter-spacing:.20em;
    text-transform:uppercase;
    color:rgba(255,241,219,.72);
  }
  @keyframes greaddyDust{
    from{transform:translateY(0)}
    to{transform:translateY(-16px)}
  }
  @keyframes greaddyWinnerPulse{
    from{transform:translateY(-6px) scale(1.02)}
    to{transform:translateY(-10px) scale(1.06)}
  }
  @media (max-width: 430px){
    .greaddy-shell .topbar{
      grid-template-columns:minmax(0,1fr) minmax(0,1.2fr) minmax(0,1fr);
      gap:8px;
    }
    .greaddy-shell .pill{
      min-width:78px;
      height:40px;
      padding:0 10px;
    }
    .greaddy-shell .brand{
      padding:9px 8px;
    }
    .greaddy-shell .brand b{
      font-size:13px;
    }
    .greaddy-shell .hero-head{
      display:grid;
      grid-template-columns:repeat(2, minmax(0, 1fr));
      align-items:center;
      gap:8px;
    }
    .greaddy-shell #phase,
    .greaddy-shell .net-tag,
    .greaddy-shell #historyBtn,
    .greaddy-shell #activeProfile{
      width:100%;
      justify-content:center;
    }
    .greaddy-shell .recent-strip,
    .greaddy-shell .room-tools{
      grid-column:1 / -1;
    }
    .greaddy-shell .room-tools{
      justify-content:center;
    }
    .greaddy-shell .game-title{
      font-size:22px;
      padding:10px 20px;
    }
    .greaddy-shell .hero-copy{
      font-size:12px;
      max-width:280px;
    }
    .greaddy-shell .hero-badges span{
      font-size:9px;
      letter-spacing:.14em;
    }
    .greaddy-shell .board-crown{
      flex-direction:column;
      align-items:flex-start;
    }
    .greaddy-shell .board-wrapper{
      padding:0 1px 6px;
    }
    .greaddy-shell .board-outer{
      padding:18px 12px 14px;
    }
    .greaddy-shell .board-lights-track{
      inset:42px 10px 10px;
    }
    .greaddy-shell .board-inner{
      padding:10px;
    }
    .greaddy-shell .board-grid{
      gap:9px;
    }
    .greaddy-shell .tile{
      padding:10px 6px 13px;
      border-radius:20px;
      aspect-ratio:1/1.08;
    }
    .greaddy-shell .tile-caption{
      font-size:8px;
    }
    .greaddy-shell .name{
      font-size:9px;
      letter-spacing:.12em;
    }
    .greaddy-shell .pool{
      min-width:44px;
      font-size:10px;
    }
    .greaddy-shell .chip{
      height:48px;
      font-size:12px;
    }
  }
  @media (max-width: 390px){
    .greaddy-shell .topbar{
      grid-template-columns:minmax(0,.92fr) minmax(0,1.16fr) minmax(0,.92fr);
      gap:6px;
      padding:max(10px,var(--safe-top)) max(10px,var(--safe-right)) 8px max(10px,var(--safe-left));
    }
    .greaddy-shell .pill{
      min-width:0;
      height:38px;
      padding:0 8px;
    }
    .greaddy-shell .pill strong{
      min-width:0;
      font-size:14px;
    }
    .greaddy-shell .brand{
      padding:8px 7px;
    }
    .greaddy-shell .brand b{
      font-size:12px;
      letter-spacing:.10em;
    }
    .greaddy-shell .brand span{
      font-size:8px;
      letter-spacing:.16em;
    }
    .greaddy-shell .stage{
      padding:14px 10px 12px;
      gap:13px;
    }
    .greaddy-shell .hero-head{
      padding:10px;
      gap:6px;
    }
    .greaddy-shell .tag,
    .greaddy-shell .history-btn{
      padding:7px 9px;
      font-size:10px;
      letter-spacing:.12em;
    }
    .greaddy-shell .recent-strip{
      padding:4px 5px;
    }
    .greaddy-shell .recent-pill{
      width:22px;
      height:22px;
      font-size:14px;
    }
    .greaddy-shell .greedy-main-trend{
      margin:-1px 0 9px;
      padding:5px 7px;
      gap:6px;
    }
    .greaddy-shell .greedy-main-trend .recent-track{
      gap:4px;
    }
    .greaddy-shell .greedy-main-trend .recent-pill{
      width:21px;
      height:21px;
      font-size:13px;
    }
    .greaddy-shell .active-copy b{
      max-width:none;
      font-size:9px;
    }
    .greaddy-shell .game-title{
      font-size:20px;
      padding:10px 16px;
    }
    .greaddy-shell .hero-copy{
      max-width:260px;
      font-size:11px;
    }
    .greaddy-shell .hero-badges{
      gap:6px;
    }
    .greaddy-shell .hero-badges span{
      padding:6px 9px;
      font-size:8px;
      letter-spacing:.12em;
    }
    .greaddy-shell .result-stage{
      padding:12px;
      gap:10px;
    }
    .greaddy-shell .reel-cell{
      min-height:74px;
    }
    .greaddy-shell .board-crown{
      margin-bottom:10px;
    }
    .greaddy-shell .board-crown span,
    .greaddy-shell .board-crown b{
      font-size:9px;
      letter-spacing:.16em;
    }
    .greaddy-shell .board-grid{
      gap:8px;
    }
    .greaddy-shell .tile{
      padding:9px 5px 12px;
      border-radius:18px;
    }
    .greaddy-shell .tile-caption{
      font-size:7px;
      letter-spacing:.18em;
    }
    .greaddy-shell .token{
      font-size:32px;
    }
    .greaddy-shell .name{
      font-size:8px;
    }
    .greaddy-shell .multi{
      font-size:clamp(14px,4.5vw,18px);
    }
    .greaddy-shell .mine{
      margin-top:6px;
      font-size:8px;
    }
    .greaddy-shell .pool{
      min-width:40px;
      padding:4px 7px;
      font-size:9px;
      bottom:-9px;
    }
    .greaddy-shell .timer-label,
    .greaddy-shell .timer-foot{
      font-size:8px;
    }
    .greaddy-shell .timer-text{
      font-size:34px;
    }
    .greaddy-shell .chips{
      gap:5px;
      padding:8px max(8px,var(--safe-right)) max(9px,var(--safe-bottom)) max(8px,var(--safe-left));
    }
    .greaddy-shell .chip{
      height:44px;
      border-radius:18px;
      font-size:11px;
    }
  }
  @media (max-width: 360px){
    .greaddy-shell .result-stage{
      padding:10px;
    }
    .greaddy-shell .reel-cell{
      min-height:68px;
      border-radius:16px;
    }
    .greaddy-shell .reel-chip{
      width:40px;
      height:40px;
      font-size:26px;
    }
    .greaddy-shell .board-outer{
      padding:16px 10px 12px;
      border-radius:28px;
    }
    .greaddy-shell .board-lights-track{
      inset:38px 8px 8px;
    }
    .greaddy-shell .board-inner{
      padding:8px;
    }
    .greaddy-shell .board-grid{
      gap:7px;
    }
    .greaddy-shell .tile{
      padding:8px 4px 11px;
      border-radius:16px;
    }
    .greaddy-shell .token{
      font-size:28px;
    }
    .greaddy-shell .multi{
      font-size:13px;
    }
    .greaddy-shell .mine{
      display:none;
    }
    .greaddy-shell .pool{
      min-width:36px;
      font-size:8px;
      padding:4px 6px;
    }
    .greaddy-shell .board-grid > .timer-box{
      border-radius:18px;
    }
    .greaddy-shell .timer-text{
      font-size:28px;
    }
    .greaddy-shell .chip{
      height:40px;
      font-size:10px;
    }
    .greaddy-shell .chip-coin{
      display:none;
    }
  }
  @media (max-height: 700px){
    .greaddy-shell .stage{
      gap:12px;
      padding-bottom:12px;
    }
    .greaddy-shell .hero{
      gap:10px;
    }
    .greaddy-shell .hero-copy{
      display:none;
    }
    .greaddy-shell .hero-badges span{
      padding:6px 10px;
    }
    .greaddy-shell .result-stage{
      padding:12px;
    }
    .greaddy-shell .reel-cell{
      min-height:72px;
    }
    .greaddy-shell .chip{
      height:46px;
    }
  }
  @media (max-height: 560px){
    .greaddy-shell .topbar{
      gap:6px;
      padding:max(8px,var(--safe-top)) max(9px,var(--safe-right)) 7px max(9px,var(--safe-left));
    }
    .greaddy-shell .pill{
      height:36px;
    }
    .greaddy-shell .hero-head{
      padding:8px;
    }
    .greaddy-shell .hero-badges{
      display:none;
    }
    .greaddy-shell .result-stage{
      display:none;
    }
    .greaddy-shell .board-outer{
      padding:14px 10px 10px;
    }
    .greaddy-shell .board-crown{
      margin-bottom:8px;
    }
    .greaddy-shell .greedy-main-trend{
      margin:-2px 0 7px;
      min-height:24px;
      padding:4px 7px;
      gap:5px;
    }
    .greaddy-shell .greedy-main-trend .recent-label{
      font-size:7px;
    }
    .greaddy-shell .greedy-main-trend .recent-track{
      gap:4px;
    }
    .greaddy-shell .greedy-main-trend .recent-pill{
      width:19px;
      height:19px;
      border-radius:7px;
      font-size:12px;
    }
    .greaddy-shell .board-crown span,
    .greaddy-shell .board-crown b{
      font-size:8px;
    }
    .greaddy-shell .board-lights-track{
      inset:34px 8px 8px;
    }
    .greaddy-shell .tile{
      padding:6px 3px 9px;
      border-radius:14px;
    }
    .greaddy-shell .tile-caption{
      font-size:6px;
    }
    .greaddy-shell .token{
      font-size:24px;
    }
    .greaddy-shell .name{
      margin-bottom:4px;
      font-size:7px;
    }
    .greaddy-shell .multi{
      font-size:12px;
    }
    .greaddy-shell .board-grid > .timer-box{
      border-radius:16px;
    }
    .greaddy-shell .timer-label,
    .greaddy-shell .timer-foot{
      font-size:7px;
    }
    .greaddy-shell .timer-text{
      font-size:26px;
    }
    .greaddy-shell .chips{
      gap:4px;
      padding:5px max(5px,var(--safe-right)) max(6px,var(--safe-bottom)) max(5px,var(--safe-left));
    }
    .greaddy-shell .chip{
      height:36px;
      font-size:9px;
    }
  }
  @media (prefers-reduced-motion: reduce){
    body.greaddy-view::after,
    .greaddy-shell .tile.win{
      animation:none !important;
    }
  }
</style>
</div>
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
	const refs = { balance: document.getElementById('balance'), balancePill: document.getElementById('balance') ? document.getElementById('balance').closest('.pill') : null, systemBank: document.querySelector('.brand'), round: document.getElementById('round'), phase: document.getElementById('phase'), networkMs: document.getElementById('networkMs'), time: document.getElementById('time'), resultStage: document.getElementById('resultStage'), resultTrack: document.getElementById('resultTrack'), resultTitle: document.getElementById('resultTitle'), resultText: document.getElementById('resultText'), resultMeta: document.getElementById('resultMeta'), resultSlots: Array.from(document.querySelectorAll('[data-result-slot]')), toast: document.getElementById('toast'), toastTitle: document.getElementById('toastTitle'), toastText: document.getElementById('toastText'), phaseBanner: document.getElementById('phaseBanner'), modals: { start: document.getElementById('modalStart'), stop: document.getElementById('modalStop'), win: document.getElementById('modalWin'), loss: document.getElementById('modalLoss'), nobid: document.getElementById('modalNoBid') }, winText: document.getElementById('winText'), winFruitCinema: document.getElementById('winFruitCinema'), winFruitMain: document.getElementById('winFruitMain'), historyBtn: document.getElementById('historyBtn'), usersBtn: document.getElementById('usersBtn'), settingsBtn: document.getElementById('settingsBtn'), historyModal: document.getElementById('historyModal'), historyTitle: document.getElementById('historyTitle'), historySubtitle: document.getElementById('historySubtitle'), historyTabs: Array.from(document.querySelectorAll('.history-tab')), historyContent: document.getElementById('historyContent'), historyClose: document.getElementById('historyClose'), recentTrack: document.getElementById('recentTrack'), recentTracks: Array.from(document.querySelectorAll('[data-recent-track]')), activeUsersCount: document.getElementById('activeUsersCount'), profileName: document.getElementById('profileName'), profileInitial: document.getElementById('profileInitial'), hitFxLayer: document.getElementById('hitFxLayer'), winBurstLayer: document.getElementById('winBurstLayer'), chips: Array.from(document.querySelectorAll('.chip')), boards: {}, pools: {}, mines: {} };
	Object.keys(boardProfiles).forEach((key) => { refs.boards[key] = document.querySelector(`.tile[data-board="${key}"]`); refs.pools[key] = document.getElementById(`pool-${key}`); refs.mines[key] = document.getElementById(`mine-${key}`); });
	const boardPathDom = Array.from(document.querySelectorAll('.board-grid .tile[data-board]')).map((node) => node.dataset.board).filter(Boolean);
	const circleOrder = [0, 1, 2, 4, 7, 6, 5, 3];
	const boardPath = boardPathDom.length === 8
		? circleOrder.map((index) => boardPathDom[index]).filter(Boolean)
		: boardPathDom;
	let selectedChip = 500, authoritativeRoundNo = null, lastStatePayload = null, lastResultVisualKey = '', lastWinnerToastKey = '', lastWinFxKey = '', lastStartPopupKey = '', lastStopPopupKey = '', lastResultPopupKey = '', lastSettlementFxKey = '', lastSpinKey = '', lastCoinFxKey = '', spinTimer = null, resultPopupTimer = null, spinRunning = false, refreshInFlight = false, requestCounter = 0, lastNetworkMs = 0, serverClockOffsetSec = 0, serverClockKey = '', refreshTimer = null, heartbeatTimer = null, timerTick = null, toastTimer = null, disposed = false, boardHistoryRows = [], userHistoryRows = [], activePlayers = [], historySyncInFlight = false, lastHistorySyncRound = '', roomPanel = 'history', activeUsers = 0, audioCtx = null, soundEnabled = localStorage.getItem('fruitSlotSound') !== 'off', soundVolume = Math.min(1, Math.max(0, Number(localStorage.getItem('fruitSlotVolume') || .68)));
	const pendingBoards = new Map();
	function markPendingBoard(boardKey, delta){ const nextCount = Math.max(0, (pendingBoards.get(boardKey) || 0) + delta); if(nextCount > 0) pendingBoards.set(boardKey, nextCount); else pendingBoards.delete(boardKey); }
	const roomBoardCount = Math.max(1, Number(window.BD_GAME_BOOTSTRAP.rules && window.BD_GAME_BOOTSTRAP.rules.boardCount || Object.keys(boardProfiles).length || 1));
	function number(value){ return Number(value || 0).toLocaleString('en-US'); }
	function shortRound(value){ const explicit = value && typeof value === 'object' ? (value.round_short || value.trace_short || '') : ''; const raw = explicit || String((value && typeof value === 'object' ? (value.round_no || value.round_id || value.trace_id) : value) || '-'); const parts = raw.split('_'); const tail = parts.length ? parts[parts.length - 1] : raw; return /^\d{7,}$/.test(tail) ? tail.slice(-6) : (raw.length > 10 ? raw.slice(-10) : raw); }
	function balanceNumber(value){ return String(Math.max(0, Math.floor(Number(value || 0)))); }
	function escapeHtml(value){ return String(value == null ? '' : value).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;'); }
	function userName(){ return String(window.BD_GAME_BOOTSTRAP.userName || 'Player'); }
	function setProfile(){ const name = userName(); if(refs.profileName) refs.profileName.textContent = name; if(refs.profileInitial) refs.profileInitial.textContent = (name.trim().charAt(0) || 'P').toUpperCase(); if(refs.activeUsersCount) refs.activeUsersCount.textContent = number(userTotalWin()); }
	function ensureAudio(){ if(!soundEnabled) return null; const AudioContext = window.AudioContext || window.webkitAudioContext; if(!AudioContext) return null; if(!audioCtx) audioCtx = new AudioContext(); if(audioCtx.state === 'suspended') audioCtx.resume(); return audioCtx; }
	function silenceRoomAudio(permanent = false){
		document.querySelectorAll('audio,video').forEach((media) => {
			try { media.pause(); } catch (error) {}
			if(permanent){
				try { media.currentTime = 0; } catch (error) {}
				try { media.srcObject = null; } catch (error) {}
			}
		});
		if('speechSynthesis' in window){
			try { window.speechSynthesis.cancel(); } catch (error) {}
		}
		if(window.Howler){
			try { window.Howler.mute(true); } catch (error) {}
			if(permanent && typeof window.Howler.stop === 'function'){
				try { window.Howler.stop(); } catch (error) {}
			}
		}
		if(audioCtx){
			try {
				if(permanent && typeof audioCtx.close === 'function') audioCtx.close();
				else if(typeof audioCtx.suspend === 'function') audioCtx.suspend();
			} catch (error) {}
			if(permanent) audioCtx = null;
		}
	}
	function playSound(type){ const ctx = ensureAudio(); if(!ctx) return; const now = ctx.currentTime; const gain = ctx.createGain(); gain.gain.setValueAtTime(0.0001, now); gain.gain.exponentialRampToValueAtTime(Math.max(0.0001, soundVolume * .18), now + .015); gain.gain.exponentialRampToValueAtTime(0.0001, now + (type === 'payout' ? .42 : .18)); gain.connect(ctx.destination); const makeTone = (freq, start, length, wave = 'triangle') => { const osc = ctx.createOscillator(); osc.type = wave; osc.frequency.setValueAtTime(freq, now + start); osc.frequency.exponentialRampToValueAtTime(freq * .74, now + start + length); osc.connect(gain); osc.start(now + start); osc.stop(now + start + length + .04); }; if(type === 'blink'){ makeTone(840, 0, .06, 'square'); } else if(type === 'coin'){ makeTone(520, 0, .12, 'triangle'); makeTone(880, .045, .12, 'sine'); } else if(type === 'payout'){ makeTone(460, 0, .22, 'triangle'); makeTone(690, .09, .24, 'triangle'); makeTone(920, .18, .22, 'sine'); } else { makeTone(210, 0, .2, 'sawtooth'); } }
	function centerPoint(node){ if(!node) return null; const rect = node.getBoundingClientRect(); return { x: rect.left + rect.width / 2, y: rect.top + rect.height / 2 }; }
	function chipForValue(value){ return refs.chips.find((chip) => Number(chip.dataset.value || 0) === Number(value)) || document.querySelector('.chip.selected') || refs.balancePill; }
	function pulseNode(node, className){ if(!node) return; node.classList.remove(className); void node.offsetWidth; node.classList.add(className); window.setTimeout(() => node.classList.remove(className), 820); }
	function compactFxMode(){ return document.body.classList.contains('low-end-mode') || window.innerHeight <= 520 || window.innerWidth <= 430 || (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches); }
	function fxBudgetValue(key,fallback){ const api = window.BDGameFinal; const budget = api && typeof api.fxBudget === 'function' ? api.fxBudget() : null; if(budget && Number(budget[key]) > 0) return Number(budget[key]); if(!compactFxMode()) return fallback; const compact = { betCoins:2, betSparks:2, winCoins:4, winParticles:6 }; return compact[key] || Math.min(fallback, 6); }
	function fxAllowed(cost){ const api = window.BDGameFinal; if(document.hidden) return false; if(api && typeof api.canPlayFx === 'function') return api.canPlayFx(cost); return true; }
	function registerFx(node,ttl){ const api = window.BDGameFinal; if(api && typeof api.registerFxNode === 'function') api.registerFxNode(node, ttl); return node; }
	function flyCoins(fromNode,toNode,count = 8,type = 'coin'){ const from = centerPoint(fromNode); const to = centerPoint(toNode); if(!from || !to) return; count = Math.max(1, Math.min(count, fxBudgetValue(type === 'win' ? 'winCoins' : 'betCoins', count))); if(!fxAllowed(count)){ playSound(type === 'win' ? 'payout' : type === 'loss' ? 'loss' : 'coin'); return; } playSound(type === 'win' ? 'payout' : type === 'loss' ? 'loss' : 'coin'); for(let i = 0; i < count; i++){ const coin = registerFx(document.createElement('div'), 1400); coin.className = 'route-coin'; const drift = (i - (count - 1) / 2) * 5; coin.style.setProperty('--x0', `${from.x + drift}px`); coin.style.setProperty('--y0', `${from.y + (i % 3) * 3}px`); coin.style.setProperty('--x1', `${to.x - drift * .4}px`); coin.style.setProperty('--y1', `${to.y - 8 - (i % 4) * 3}px`); coin.style.setProperty('--delay', `${i * 38}ms`); coin.style.setProperty('--dur', `${680 + (i % 4) * 55}ms`); document.body.appendChild(coin); window.setTimeout(() => coin.remove(), 1250 + i * 38); } }
	function renderRecentTrack(){ const tracks = refs.recentTracks.length ? refs.recentTracks : [refs.recentTrack].filter(Boolean); if(!tracks.length) return; const rows = (boardHistoryRows || []).slice(0, 10); const html = rows.length ? rows.map((item) => { const key = item && item.winner_board_key || ''; const profile = boardProfiles[key] || null; return `<span class="recent-pill" title="${escapeHtml(profile ? profile.name : key)}">${escapeHtml(profile ? profile.token : '?')}</span>`; }).join('') : '<span class="recent-pill">?</span><span class="recent-pill">?</span><span class="recent-pill">?</span>'; tracks.forEach((track) => { track.innerHTML = html; }); }
	function outcomeBadge(item){ const outcome = String(item && (item.user_outcome || item.status) || 'no_bid').toLowerCase(); const cls = outcome === 'won' ? 'win' : (outcome === 'lost' ? 'loss' : (outcome === 'punishment' ? 'punishment' : 'pending')); const label = outcome === 'won' ? `WIN +${number(item && (item.user_win_amount || item.win_amount) || 0)}` : (outcome === 'lost' ? 'LOSS' : (outcome === 'punishment' ? `PUNISH -${number(Math.abs(Number(item && (item.result_amount || item.amount) || 0)))}` : 'NO BID')); return `<span class="history-status ${cls}">${escapeHtml(label)}</span>`; }
	function winnerGrid(){ const rows = (boardHistoryRows || []).slice(0, 10); return rows.length ? `<div class="history-section"><div class="history-section-head"><div class="history-section-title">Last 10 Winner Board</div><div class="history-section-sub">Short round and your result</div></div><div class="history-table-wrap"><table class="history-table"><tbody>${rows.map((item,index) => `<tr><td>${index + 1}</td><td class="history-trace">${escapeHtml(shortRound(item))}</td><td>${historyBoardCell(item && item.winner_board_key || '')}</td><td>${outcomeBadge(item)}</td></tr>`).join('')}</tbody></table></div></div>` : '<div class="history-empty">Waiting for winner history</div>'; }
	function userTotalWin(){ return userHistoryRows.reduce((sum,item) => sum + Number(item && item.win_amount || 0), Number(lastStatePayload && lastStatePayload.my_total_win_amount || 0)); }
	function activePlayersGrid(){ const fallbackName = refs.profileName ? refs.profileName.textContent : 'Player'; const rows = activePlayers.length ? activePlayers : [{ name: fallbackName || 'Player', initial: (refs.profileInitial && refs.profileInitial.textContent) || String(fallbackName || 'P').charAt(0) || 'P', game_win_amount: 0, is_me: true }]; return `<div class="profile-grid">${rows.map((row) => { const name = row.name || 'Player'; const image = row.image || row.avatar || row.profile_image || row.photo || ''; const avatar = image ? `<img src="${escapeHtml(image)}" alt="${escapeHtml(name)}">` : escapeHtml(row.initial || String(name).charAt(0) || 'P'); return `<div class="profile-panel"><div class="profile-avatar">${avatar}</div><b>${escapeHtml(name)}</b><span>${row.is_me ? 'YOU' : `Win ${escapeHtml(number(row.game_win_amount || 0))}`}</span></div>`; }).join('')}</div>`; }
	function renderRoomPanel(){ if(!refs.historyContent) return; refs.historyTabs.forEach((tab) => tab.classList.toggle('active', tab.dataset.panel === roomPanel)); if(refs.historyTitle) refs.historyTitle.textContent = roomPanel === 'settings' ? 'Sound Settings' : roomPanel === 'users' ? 'Active Users' : roomPanel === 'winners' ? 'Last 10 Winners' : 'Room History'; if(refs.historySubtitle) refs.historySubtitle.textContent = roomPanel === 'settings' ? 'Control fruit blink and coin transfer sounds.' : roomPanel === 'users' ? 'Game-only win amount. Wallet balances stay private.' : roomPanel === 'winners' ? 'Recent winning boards from this game only.' : 'Short round IDs with your own win or loss.'; if(roomPanel === 'settings'){ refs.historyContent.innerHTML = `<div class="history-section"><div class="settings-row"><label>Sound</label><button class="sound-toggle" id="soundToggle" type="button">${soundEnabled ? 'ON' : 'OFF'}</button></div><div class="settings-row"><label>Volume</label><input class="volume-range" id="volumeRange" type="range" min="0" max="100" value="${Math.round(soundVolume * 100)}"></div></div>`; return; } if(roomPanel === 'users'){ refs.historyContent.innerHTML = activePlayersGrid(); return; } if(roomPanel === 'winners'){ refs.historyContent.innerHTML = winnerGrid(); return; } const boardTable = boardHistoryRows.length ? `<div class="history-section"><div class="history-section-head"><div class="history-section-title">Win Board History</div><div class="history-section-sub">Last 15 settled rounds</div></div><div class="history-table-wrap"><table class="history-table"><thead><tr><th>Round</th><th>Winner</th><th>You</th></tr></thead><tbody>${boardHistoryRows.map((item) => `<tr><td class="history-trace">${escapeHtml(shortRound(item))}</td><td>${historyBoardCell(item && item.winner_board_key || '')}</td><td>${outcomeBadge(item)}</td></tr>`).join('')}</tbody></table></div></div>` : '<div class="history-empty">Waiting for live rounds</div>'; const userTable = userHistoryRows.length ? `<div class="history-section"><div class="history-section-head"><div class="history-section-title">My Bet History</div><div class="history-section-sub">Last 15 bet tickets</div></div><div class="history-table-wrap"><table class="history-table"><thead><tr><th>Trace</th><th>Round</th><th>Board</th><th>Bid</th><th>Result</th></tr></thead><tbody>${userHistoryRows.map((item) => { const status = String(item && item.status || 'pending').toLowerCase(); const statusClass = status === 'won' ? 'win' : (status === 'lost' ? 'loss' : (status === 'punishment' ? 'punishment' : 'pending')); const resultText = status === 'won' ? `WIN +${number(item && item.win_amount || 0)}` : (status === 'lost' ? `LOSS -${number(item && item.amount || 0)}` : (status === 'punishment' ? `PUNISH -${number(Math.abs(Number(item && (item.result_amount || item.amount) || 0)))}` : 'PENDING')); return `<tr><td class="history-trace">${escapeHtml(shortRound(item.trace_short || item.trace_id || '-'))}</td><td class="history-trace">${escapeHtml(shortRound(item))}</td><td>${historyBoardCell(item && (item.board_key || item.frontend_board_key) || '')}</td><td>${escapeHtml(number(item && item.amount || 0))}</td><td><span class="history-status ${statusClass}">${escapeHtml(resultText)}</span></td></tr>`; }).join('')}</tbody></table></div></div>` : '<div class="history-empty">Place a bet to build your history</div>'; refs.historyContent.innerHTML = `${boardTable}${userTable}`; }
	function historyBoardCell(boardKey){ const profile = boardProfiles[boardKey] || null; const name = profile ? profile.name : (boardKey || '-'); const token = profile ? profile.token : '?'; return `<div class="history-board"><span class="history-token">${escapeHtml(token)}</span><span>${escapeHtml(name)}</span></div>`; }
	function renderHistoryPopup(){ renderRecentTrack(); renderRoomPanel(); }
	function openHistoryModal(panel = 'history'){ roomPanel = panel; renderHistoryPopup(); if(refs.historyModal) refs.historyModal.classList.add('is-open'); refreshHistoryTables(true); }
	function closeHistoryModal(){ if(refs.historyModal) refs.historyModal.classList.remove('is-open'); }
	async function refreshHistoryTables(force = false){ if(!(window.BDGameFinal && window.BD_GAME_BOOTSTRAP && window.BD_GAME_BOOTSTRAP.gameCode === currentGameCode)){ renderHistoryPopup(); return; } if(historySyncInFlight) return; if(!force && !window.BD_GAME_BOOTSTRAP.endpoints) return; historySyncInFlight = true; try { const [historyPayload, myBetsPayload] = await Promise.all([window.BDGameFinal.get(window.BD_GAME_BOOTSTRAP.endpoints.history, {}), window.BDGameFinal.get(window.BD_GAME_BOOTSTRAP.endpoints.myBets, {})]); boardHistoryRows = Array.isArray(historyPayload && (historyPayload.board_history || historyPayload.recent)) ? (historyPayload.board_history || historyPayload.recent) : []; userHistoryRows = Array.isArray(myBetsPayload && (myBetsPayload.bet_history || myBetsPayload.history)) ? (myBetsPayload.bet_history || myBetsPayload.history) : []; activePlayers = Array.isArray(historyPayload && historyPayload.active_players) ? historyPayload.active_players : (Array.isArray(myBetsPayload && myBetsPayload.active_players) ? myBetsPayload.active_players : activePlayers); } catch (error) { if(!boardHistoryRows.length && !userHistoryRows.length){ boardHistoryRows = []; userHistoryRows = []; } } finally { historySyncInFlight = false; renderHistoryPopup(); } }
	function formatRoundLabel(roundNo){ if(!roundNo) return '---'; const parts = String(roundNo).split('_'); const value = parts.length ? parts[parts.length - 1] : '---'; if(/^\d{7,}$/.test(value)) return value.slice(-3).replace(/^0+/, '') || '0'; return value || '---'; }
	function phaseLabel(phase){ if(phase === 'betting') return 'BET OPEN'; if(phase === 'locked') return 'LOCKED'; if(phase === 'revealed') return 'SPIN'; if(phase === 'settled') return 'PAYOUT'; return hasLiveSession ? 'SYNCING' : 'LIVE ONLY'; }
	function serverNow(){ return (Date.now() / 1000) + serverClockOffsetSec; }
	function phaseEndAt(payload){ if(!payload) return null; if(payload.phase === 'betting') return payload.bet_close_at || null; if(payload.phase === 'locked') return payload.reveal_at || null; if(payload.phase === 'revealed') return payload.settle_at || null; if(payload.phase === 'settled') return payload.next_round_at || null; return null; }
	function fruitSlotTimings(payload){ const d = payload && payload.phase_durations ? payload.phase_durations : {}; return { startPopupMs: Math.max(0, Math.round(Number(d.start_popup || 3) * 1000)), stopPopupMs: Math.max(0, Math.round(Number(d.stop_popup || 3) * 1000)), revealMainMs: Math.max(0, Math.round(Number(d.reveal_main || 6) * 1000)), revealWaitMs: Math.max(0, Math.round(Number(d.reveal_wait || 2) * 1000)), winnerPopupMs: Math.max(0, Math.round(Number(d.winner_popup || 1) * 1000)), winnerWaitMs: Math.max(0, Math.round(Number(d.winner_wait || .5) * 1000)), payoutMs: Math.max(0, Math.round(Number(d.payout || 2.5) * 1000)), settleWaitMs: Math.max(0, Math.round(Number(d.settle_wait || 1) * 1000)) }; }
	function markerAt(payload,key){ const value = Number(payload && payload[key] || 0); return Number.isFinite(value) && value > 0 ? value : null; }
	function bettingOpensAt(payload){ return markerAt(payload,'bet_countdown_start_at'); }
	function isBettingOpen(payload){ if(!payload || payload.phase !== 'betting') return false; const opensAt = bettingOpensAt(payload); const closesAt = markerAt(payload,'bet_close_at'); const now = serverNow(); if(opensAt && now < opensAt) return false; if(closesAt && now >= closesAt) return false; return true; }
	function revealDoneAt(payload){ const direct = markerAt(payload,'reveal_done_at'); if(direct) return direct; const start = markerAt(payload,'reveal_at'); return start ? start + (fruitSlotTimings(payload).revealMainMs / 1000) : null; }
	function winnerPopupAt(payload){ const direct = markerAt(payload,'winner_popup_at'); if(direct) return direct; const revealDone = revealDoneAt(payload); return revealDone ? revealDone + (fruitSlotTimings(payload).revealWaitMs / 1000) : null; }
	function currentWinner(payload){ return payload && (payload.winner_board || (payload.result && payload.result.winner_board)) || ''; }
	function payloadActiveUsers(payload){ const explicit = Number(payload && (payload.active_users || payload.active_user_count || payload.players_count) || 0); if(explicit > 0) return explicit; const boardPlayers = payload && payload.board_players && typeof payload.board_players === 'object' ? Object.values(payload.board_players).reduce((sum,value) => sum + Number(value || 0), 0) : 0; return Math.max(0, boardPlayers || activeUsers || 0); }
	function maxDistinctBoards(payload){ const fromPayload = Number(payload && payload.rules && payload.rules.max_distinct_boards_per_user || 0); const fromBootstrap = Number(window.BD_GAME_BOOTSTRAP.rules && window.BD_GAME_BOOTSTRAP.rules.maxDistinctBoards || 0); return Math.max(1, Math.min(roomBoardCount, fromPayload || fromBootstrap || roomBoardCount)); }
	function currentDistinctBoardCount(payload){ return Object.keys(boardProfiles).filter((key) => Number(payload && payload.my_bet_totals && payload.my_bet_totals[key] || 0) > 0).length; }
	function canUseBoard(payload, boardKey){ const currentTotal = Number(payload && payload.my_bet_totals && payload.my_bet_totals[boardKey] || 0); return currentTotal > 0 || currentDistinctBoardCount(payload) < maxDistinctBoards(payload); }
	function boardLimitMessage(payload){ const limit = maxDistinctBoards(payload); return `This room allows ${limit} distinct ${limit === 1 ? 'board' : 'boards'} per round.`; }
	function setResultCopy(title,text,meta){ refs.resultTitle.textContent = title; refs.resultText.textContent = text; refs.resultMeta.textContent = meta; }
	function paintResultCell(node,key,active){ const chip = node.querySelector('[data-result-chip]'); const label = node.querySelector('[data-result-label]'); chip.textContent = key && boardProfiles[key] ? boardProfiles[key].token : '--'; label.textContent = key && boardProfiles[key] ? boardProfiles[key].name : 'WAIT'; node.classList.toggle('hit', !!active && !!key); }
	function buildResultStrip(winner){ const keys = Object.keys(boardProfiles); if(!keys.length) return ['','','']; if(!winner || !boardProfiles[winner]) return [keys[0] || '', keys[1] || keys[0] || '', keys[2] || keys[1] || keys[0] || '']; const index = keys.indexOf(winner); return [keys[(index - 1 + keys.length) % keys.length], winner, keys[(index + 1) % keys.length]]; }
	function closeAllPhaseModals(){ Object.values(refs.modals).forEach((modal) => modal && modal.classList.remove('show')); }
	function showPhaseModal(type, ms = 1600){ const modal = refs.modals[type]; if(!modal) return; closeAllPhaseModals(); modal.classList.add('show'); if(ms > 0) window.setTimeout(() => modal.classList.remove('show'), ms); }
	function showPhaseBanner(title, sub = '', type = 'start'){ if(!refs.phaseBanner) return; refs.phaseBanner.className = `phase-banner ${type}`; refs.phaseBanner.innerHTML = `${escapeHtml(title)}${sub ? `<small>${escapeHtml(sub)}</small>` : ''}`; void refs.phaseBanner.offsetWidth; refs.phaseBanner.classList.add('show'); }
	function clearSpin(){ if(spinTimer) window.clearTimeout(spinTimer); spinTimer = null; spinRunning = false; Object.values(refs.boards).forEach((node) => node && node.classList.remove('spin-active')); }
	function showFruitCinema(winner){ const profile = boardProfiles[winner]; if(!profile) return; if(refs.winFruitMain) refs.winFruitMain.textContent = profile.token; if(!refs.winFruitCinema) return; refs.winFruitCinema.querySelectorAll('.cinema-fruit').forEach((node) => node.remove()); const count = Math.min(14, fxBudgetValue('winParticles', 14)); if(!fxAllowed(count)) return; for(let i = 0; i < count; i++){ const node = registerFx(document.createElement('div'), 1600); node.className = 'cinema-fruit'; node.textContent = profile.token; const angle = (Math.PI * 2 * i) / count; const dist = 38 + (i % 3) * 14; node.style.setProperty('--dx', `${Math.cos(angle) * dist}px`); node.style.setProperty('--dy', `${Math.sin(angle) * dist}px`); node.style.setProperty('--rot', `${(i % 2 ? 1 : -1) * (120 + i * 18)}deg`); node.style.animationDelay = `${i * 28}ms`; refs.winFruitCinema.appendChild(node); window.setTimeout(() => node.remove(), 1500); } }
	function showResultModal(payload,winner){ const key = `${payload.round_no || 'na'}:${winner}`; if(key === lastResultPopupKey) return; lastResultPopupKey = key; const myTotals = payload.my_bet_totals || {}; const totalBet = Object.values(myTotals).reduce((sum,value) => sum + Number(value || 0), 0); const winnerBet = Number(myTotals[winner] || 0); const myWin = Number(payload.my_total_win_amount || 0); const durationMs = fruitSlotTimings(payload).winnerPopupMs; if(totalBet <= 0){ showFruitCinema(winner); showPhaseModal('nobid', durationMs); return; } if(winnerBet > 0 || myWin > 0){ showFruitCinema(winner); if(refs.winText) refs.winText.textContent = myWin > 0 ? `+${number(myWin)} credited` : `${boardProfiles[winner].name} paid`; showPhaseModal('win', durationMs); } else { showPhaseModal('loss', durationMs); } }
	function runResultSettlement(payload,winner){ const settleKey = `${payload.round_no || 'na'}:${winner}`; if(settleKey === lastSettlementFxKey) return; lastSettlementFxKey = settleKey; const myTotals = payload.my_bet_totals || {}; const totalBet = Object.values(myTotals).reduce((sum,value) => sum + Number(value || 0), 0); const winnerBet = Number(myTotals[winner] || 0); const myWin = Number(payload.my_total_win_amount || 0); if(totalBet <= 0) return; if(winnerBet > 0 || myWin > 0){ flyCoins(refs.boards[winner], refs.balancePill, Math.min(18, 8 + Math.ceil(myWin / 1000)), 'win'); pulseNode(refs.balancePill, 'balance-hit'); return; } const losingBoard = Object.keys(myTotals).find((boardKey) => Number(myTotals[boardKey] || 0) > 0) || winner; flyCoins(refs.boards[losingBoard] || refs.balancePill, refs.systemBank, 12, 'loss'); pulseNode(refs.systemBank, 'system-take'); }
	function scheduleResultModal(payload,winner){ const popupAt = winnerPopupAt(payload); const delayMs = popupAt ? Math.max(0, Math.round((popupAt - serverNow()) * 1000)) : 0; if(resultPopupTimer) window.clearTimeout(resultPopupTimer); resultPopupTimer = window.setTimeout(() => { resultPopupTimer = null; showResultModal(payload,winner); }, delayMs); }
	function spinToWinner(winner,payload){ if(!winner || !refs.boards[winner]) return; const spinKey = `${payload && payload.round_no || 'na'}:${winner}`; if(spinKey === lastSpinKey || spinRunning) return; lastSpinKey = spinKey; spinRunning = true; Object.values(refs.boards).forEach((node) => node && node.classList.remove('win','spin-active')); const keys = boardPath.length ? boardPath : Object.keys(boardProfiles); const targetIndex = keys.indexOf(winner); if(targetIndex < 0){ spinRunning = false; return; } let pos = 0, steps = 0; const loops = 3; const minSteps = loops * keys.length + targetIndex + 1; function delayForStep(stepNo){ const progress = Math.min(1, stepNo / Math.max(1, minSteps)); return Math.round(42 + (progress * progress * progress * 238)); } function step(){ Object.values(refs.boards).forEach((node) => node && node.classList.remove('spin-active')); const activeKey = keys[pos % keys.length]; const tile = refs.boards[activeKey]; if(tile){ tile.classList.add('spin-active'); if(steps % 2 === 0) playSound('blink'); } steps++; pos++; if(steps >= minSteps && activeKey === winner){ spinTimer = window.setTimeout(() => { Object.values(refs.boards).forEach((node) => node && node.classList.remove('spin-active')); if(refs.boards[winner]) refs.boards[winner].classList.add('win'); createWinnerBurst(winner); showFruitCinema(winner); playSound('payout'); showPhaseBanner(`WINNER ${boardProfiles[winner].name}`, boardProfiles[winner].multiplier, 'win'); spinRunning = false; scheduleResultModal(payload, winner); }, 360); return; } spinTimer = window.setTimeout(step, delayForStep(steps)); } step(); }
	function updateResultVisual(payload){ const winner = currentWinner(payload); const resultPhase = !!(payload && (payload.phase === 'revealed' || payload.phase === 'settled')); if(refs.resultStage) refs.resultStage.classList.toggle('active', resultPhase); if(!payload){ buildResultStrip('').forEach((key,index) => paintResultCell(refs.resultSlots[index], key, false)); setResultCopy('Reels armed', 'The slot window stops on the winning fruit when the round reveals.', 'Awaiting result'); return; } if(!resultPhase || !winner){ lastResultVisualKey = ''; buildResultStrip('').forEach((key,index) => paintResultCell(refs.resultSlots[index], key, false)); if(payload.phase === 'betting'){ clearSpin(); } const title = payload.phase === 'betting' ? 'Reels armed' : payload.phase === 'locked' ? 'Reels locking' : 'Slot syncing'; const text = payload.phase === 'betting' ? 'Choose a fruit before the reel window locks its result.' : payload.phase === 'locked' ? 'Bets are closed and the reel window is lining up its stop.' : 'Waiting for live result payload.'; const meta = payload.phase === 'betting' ? 'Guess the winning fruit' : 'Awaiting result'; setResultCopy(title, text, meta); refs.resultTrack.classList.remove('reveal'); return; } const strip = buildResultStrip(winner); strip.forEach((key,index) => paintResultCell(refs.resultSlots[index], key, key === winner)); const resultKey = `${payload.round_no || 'na'}:${winner}`; if(resultKey !== lastResultVisualKey){ lastResultVisualKey = resultKey; refs.resultTrack.classList.remove('reveal'); void refs.resultTrack.offsetWidth; refs.resultTrack.classList.add('reveal'); spinToWinner(winner,payload); } const myWin = Number(payload.my_total_win_amount || 0); const multiplier = payload && payload.result && payload.result.multiplier ? `x${payload.result.multiplier}` : (boardProfiles[winner] ? boardProfiles[winner].multiplier : ''); setResultCopy(`${boardProfiles[winner].name} RESULT`, `Reel window stopped on ${boardProfiles[winner].name}.`, myWin > 0 ? `+${number(myWin)} credited` : `${multiplier} payout lane`); }
	function show(title,text){ refs.toastTitle.textContent = title; refs.toastText.textContent = text; refs.toast.classList.add('show'); if(toastTimer) window.clearTimeout(toastTimer); toastTimer = window.setTimeout(() => refs.toast.classList.remove('show'), 1300); }
	function layerPoint(layer,target){ if(!layer || !target) return null; const layerBox = layer.getBoundingClientRect(); const rect = target.getBoundingClientRect(); return { x: rect.left - layerBox.left + rect.width / 2, y: rect.top - layerBox.top + rect.height / 2 }; }
	function popTile(boardKey){ const board = refs.boards[boardKey]; if(!board) return; board.classList.remove('bet-placed','selected-flash'); void board.offsetWidth; board.classList.add('bet-placed','selected-flash'); window.setTimeout(() => board.classList.remove('bet-placed','selected-flash'), 650); }
	function createBetFx(boardKey){ const board = refs.boards[boardKey]; const point = layerPoint(refs.hitFxLayer, board); if(!point) return; flyCoins(chipForValue(selectedChip), board, 5, 'coin'); const sparkCount = Math.min(8, fxBudgetValue('betSparks', 8)); if(!fxAllowed(1 + sparkCount)) return; const ring = registerFx(document.createElement('div'), 620); ring.className = 'tap-ring'; ring.style.left = `${point.x}px`; ring.style.top = `${point.y}px`; refs.hitFxLayer.appendChild(ring); window.setTimeout(() => ring.remove(), 540); for(let i = 0; i < sparkCount; i++){ const spark = registerFx(document.createElement('div'), 760); spark.className = 'spark'; spark.style.left = `${point.x}px`; spark.style.top = `${point.y}px`; const angle = (Math.PI * 2 * i) / sparkCount; const dist = 24 + Math.random() * 22; spark.style.setProperty('--dx', `${Math.cos(angle) * dist}px`); spark.style.setProperty('--dy', `${Math.sin(angle) * dist}px`); refs.hitFxLayer.appendChild(spark); window.setTimeout(() => spark.remove(), 680); } const coinCount = Math.min(3, fxBudgetValue('betCoins', 3)); for(let i = 0; i < coinCount; i++){ const coin = registerFx(document.createElement('div'), 980); coin.className = 'coin-fly'; coin.style.left = `${point.x + (i - 1) * 10}px`; coin.style.top = `${point.y + 12}px`; coin.style.animationDelay = `${i * 45}ms`; refs.hitFxLayer.appendChild(coin); window.setTimeout(() => coin.remove(), 900); } }
	function createWinnerBurst(boardKey){ const board = refs.boards[boardKey]; const profile = boardProfiles[boardKey]; const point = layerPoint(refs.winBurstLayer, board); if(!point) return; const coinCount = Math.min(10, fxBudgetValue('winCoins', 10)); const fruitCount = profile ? Math.min(18, fxBudgetValue('winParticles', 18)) : 0; if(!fxAllowed(1 + coinCount + fruitCount)) return; const burst = registerFx(document.createElement('div'), 1200); burst.className = 'winner-burst'; burst.style.left = `${point.x}px`; burst.style.top = `${point.y}px`; refs.winBurstLayer.appendChild(burst); window.setTimeout(() => burst.remove(), 1100); for(let i = 0; i < coinCount; i++){ const coin = registerFx(document.createElement('div'), 1100); coin.className = 'coin-fly'; coin.style.left = `${point.x + Math.cos(i) * 18}px`; coin.style.top = `${point.y + Math.sin(i) * 12}px`; coin.style.animationDelay = `${i * 35}ms`; refs.winBurstLayer.appendChild(coin); window.setTimeout(() => coin.remove(), 1000); } if(profile){ for(let i = 0; i < fruitCount; i++){ const fruit = registerFx(document.createElement('div'), 1500); fruit.className = 'fruit-rain'; fruit.textContent = profile.token; fruit.style.left = `${point.x}px`; fruit.style.top = `${point.y}px`; const angle = (Math.PI * 2 * i) / fruitCount; const dist = 58 + Math.random() * 82; fruit.style.setProperty('--dx', `${Math.cos(angle) * dist}px`); fruit.style.setProperty('--dy', `${Math.sin(angle) * dist}px`); fruit.style.setProperty('--rot', `${(i % 2 ? 1 : -1) * (160 + i * 20)}deg`); fruit.style.animationDelay = `${i * 24}ms`; refs.winBurstLayer.appendChild(fruit); window.setTimeout(() => fruit.remove(), 1400); } } }
	function setNetwork(status,label){ refs.networkMs.textContent = label; refs.networkMs.style.color = status === 'good' ? '#f7fff8' : status === 'warn' ? '#ffe4b6' : '#ffbfb4'; }
	function updateTimer(payload){ const clock = refs.time ? (refs.time.closest('.timer-box') || refs.time.closest('.clock')) : null; if(!payload){ if(clock) clock.classList.remove('timer-hidden','state-warn','state-danger','state-normal'); refs.time.classList.add('phase-word'); refs.time.textContent = 'START'; return; } const clockKey = `${payload.round_no || 'na'}:${payload.phase || 'na'}`; if(typeof payload.server_time === 'number' && (clockKey !== serverClockKey || !serverClockKey)){ serverClockOffsetSec = payload.server_time - (Date.now() / 1000); serverClockKey = clockKey; } const endAt = phaseEndAt(payload); const left = endAt ? Math.max(0, Math.ceil(endAt - serverNow())) : 0; const showClock = isBettingOpen(payload) && left > 0; const phaseText = payload.phase === 'locked' ? 'STOP' : payload.phase === 'revealed' ? 'RESULT' : payload.phase === 'settled' ? 'WINNER' : 'START'; if(clock){ clock.classList.remove('timer-hidden'); clock.classList.toggle('state-warn', showClock && left <= 10 && left > 5); clock.classList.toggle('state-danger', showClock && left <= 5); clock.classList.toggle('state-normal', showClock && left > 10); } refs.time.classList.toggle('phase-word', !showClock); refs.time.textContent = showClock ? (left < 10 ? `0${left}` : String(left)) : phaseText; }
	function boardMultiplier(payload,key){ const raw = payload && payload.result && Number(payload.result.multiplier || 0) > 0 && currentWinner(payload) === key ? payload.result.multiplier : (boardProfiles[key] && boardProfiles[key].multiplier ? boardProfiles[key].multiplier : 'x1'); const parsed = Number(String(raw).replace(/[^\d.]/g, '')); return parsed > 0 ? parsed : 1; }
	function boardText(payload,key,myTotal,isWinner){ if(isWinner && myTotal > 0){ const multiplier = boardMultiplier(payload, key); const actualWinAmount = Number(payload && payload.my_total_win_amount || 0); const winAmount = actualWinAmount > 0 ? actualWinAmount : Math.round(myTotal * multiplier); return `${number(myTotal)} x${number(multiplier)} = ${number(winAmount)}`; } return number(Math.max(0, myTotal)); }
	function updateBoards(payload){ const winner = currentWinner(payload); const resultPhase = !!(payload && (payload.phase === 'revealed' || payload.phase === 'settled')); if(!resultPhase) lastWinFxKey = ''; Object.keys(boardProfiles).forEach((key) => { const board = refs.boards[key]; const pool = refs.pools[key]; const mine = refs.mines[key]; const boardTotal = Number(payload && payload.board_totals && payload.board_totals[key] || 0); const myTotal = Number(payload && payload.my_bet_totals && payload.my_bet_totals[key] || 0); const blockedByLimit = !!payload && isBettingOpen(payload) && !canUseBoard(payload, key); pool.textContent = number(boardTotal); mine.textContent = boardText(payload, key, myTotal, resultPhase && winner === key); if(!spinRunning) board.classList.toggle('win', !!resultPhase && winner === key); board.classList.toggle('disabled', !payload || !isBettingOpen(payload) || blockedByLimit); board.classList.toggle('pending', pendingBoards.has(key)); }); }
	function maybeShowWinnerToast(payload){ const winner = currentWinner(payload); if(!winner || !(payload.phase === 'revealed' || payload.phase === 'settled')) return; const winnerKey = `${payload.round_no || 'na'}:${payload.phase}:${winner}`; if(winnerKey === lastWinnerToastKey) return; lastWinnerToastKey = winnerKey; const myWin = Number(payload.my_total_win_amount || 0); const multiplier = payload && payload.result && payload.result.multiplier ? ` x${payload.result.multiplier}` : ''; show(`Winner ${boardProfiles[winner] ? boardProfiles[winner].name : winner}`, myWin > 0 ? `+${number(myWin)} credited` : `Reel synced${multiplier}`); }
	function applyPayload(payload){ lastStatePayload = payload; authoritativeRoundNo = payload.round_no || authoritativeRoundNo; activeUsers = payloadActiveUsers(payload); activePlayers = Array.isArray(payload.active_players) ? payload.active_players : activePlayers; setProfile(); if(Array.isArray(payload.recent) && payload.recent.length){ boardHistoryRows = payload.recent; renderHistoryPopup(); } if(payload.phase === 'settled'){ const historyRound = String(payload.round_no || ''); if(historyRound && historyRound !== lastHistorySyncRound){ lastHistorySyncRound = historyRound; refreshHistoryTables(); } } else if(payload.phase === 'betting'){ lastHistorySyncRound = ''; if(resultPopupTimer){ window.clearTimeout(resultPopupTimer); resultPopupTimer = null; } } refs.balance.textContent = balanceNumber(payload.balance || 0); refs.round.textContent = formatRoundLabel(authoritativeRoundNo); refs.phase.textContent = phaseLabel(payload.phase); const roundKey = payload.round_no || 'na'; if(payload.phase === 'betting'){ const popupKey = `${roundKey}:betting`; if(popupKey !== lastStartPopupKey){ lastStartPopupKey = popupKey; lastResultPopupKey = ''; lastSettlementFxKey = ''; lastSpinKey = ''; lastCoinFxKey = ''; showPhaseBanner('START BET','Place your coins now','start'); showPhaseModal('start', fruitSlotTimings(payload).startPopupMs); } } if(payload.phase === 'locked'){ const popupKey = `${roundKey}:locked`; if(popupKey !== lastStopPopupKey){ lastStopPopupKey = popupKey; showPhaseBanner('STOP BET','Last second to place bet','stop'); showPhaseModal('stop', fruitSlotTimings(payload).stopPopupMs); } } updateTimer(payload); updateBoards(payload); updateResultVisual(payload); if(payload.phase === 'settled'){ const win = currentWinner(payload); if(win){ runResultSettlement(payload, win); } } maybeShowWinnerToast(payload); }
	function optimisticBetPayload(payload, boardKey, amount, balanceValue = null){ if(!payload || !boardKey || !Number.isFinite(Number(amount))) return null; const betAmount = Number(amount || 0); const next = Object.assign({}, payload); next.board_totals = Object.assign({}, payload.board_totals || {}); next.my_bet_totals = Object.assign({}, payload.my_bet_totals || {}); next.board_totals[boardKey] = Number(next.board_totals[boardKey] || 0) + betAmount; next.my_bet_totals[boardKey] = Number(next.my_bet_totals[boardKey] || 0) + betAmount; next.my_total_bet_amount = Number(payload.my_total_bet_amount || 0) + betAmount; next.balance = balanceValue === null ? Math.max(0, Number(payload.balance || 0) - betAmount) : Number(balanceValue || 0); return next; }
	function mapBetError(message){ const map = { invalid_session:'Session expired. Rejoin room.', bet_closed:'Bet closed. Wait for next round.', insufficient_balance:'Select smaller chip', duplicate_request:'Duplicate bet ignored', max_distinct_board_limit:'All reels already used', max_pot_reached:'Max pot reached', bet_amount_out_of_range:'Bet amount out of range', invalid_board:'Invalid reel' }; return map[message] || 'Bet failed. Try again.'; }
	async function refreshState(){ if(disposed || !window.BDGameFinal || refreshInFlight) return; refreshInFlight = true; const startedAt = performance.now(); try { const payload = await window.BDGameFinal.get(window.BD_GAME_BOOTSTRAP.endpoints.state, {}); lastNetworkMs = Math.max(1, Math.round(performance.now() - startedAt)); if(payload && payload.st){ setNetwork(lastNetworkMs < 400 ? 'good' : 'warn', `${lastNetworkMs}ms`); applyPayload(payload); } else { setNetwork('bad','retry'); } } catch (error) { setNetwork('bad','retry'); } finally { refreshInFlight = false; } }
	async function submitBet(boardKey){ if(disposed) return; if(!window.BDGameFinal || !authoritativeRoundNo || !lastStatePayload){ show('Syncing','Waiting for live round'); return; } if(!isBettingOpen(lastStatePayload)){ show('Wait','Next betting window soon'); return; } if(Number(lastStatePayload.balance || 0) < selectedChip){ show('Low Balance','Select smaller chip'); return; } if(!canUseBoard(lastStatePayload, boardKey)){ show('Board Limit', boardLimitMessage(lastStatePayload)); return; } const amount = selectedChip; createBetFx(boardKey); popTile(boardKey); markPendingBoard(boardKey, 1); const optimisticPayload = optimisticBetPayload(lastStatePayload, boardKey, amount); if(optimisticPayload) applyPayload(optimisticPayload); else updateBoards(lastStatePayload); try { const response = await window.BDGameFinal.post(window.BD_GAME_BOOTSTRAP.endpoints.bet,{ round_no: authoritativeRoundNo, board_key: boardKey, amount: amount, request_uid: `${currentGameCode}-${Date.now()}-${++requestCounter}-${boardKey}` }); if(response && response.st){ show('Bid Added', `${boardProfiles[boardKey].name} +${number(amount)}`); if(response.balance !== undefined && lastStatePayload) applyPayload(Object.assign({}, lastStatePayload, { balance: Number(response.balance || 0) })); window.setTimeout(() => { refreshState(); refreshHistoryTables(true); }, 60); } else { refreshState(); show('Bet Failed', mapBetError(response && (response.msg || response.error))); } } catch (error) { refreshState(); show('Bet Failed','Retry in the next round'); } finally { markPendingBoard(boardKey, -1); if(lastStatePayload) updateBoards(lastStatePayload); } }
	refs.chips.forEach((chip) => chip.addEventListener('click', () => { refs.chips.forEach((node) => node.classList.remove('selected')); chip.classList.add('selected'); selectedChip = Number(chip.dataset.value || 0); show('Chip Selected', `${number(selectedChip)} active`); }));
	function handleBoardPress(event,key){ if(event){ event.preventDefault(); event.stopPropagation(); } submitBet(key); }
	function bindReliableBoardPress(node,key){ if(!node) return; node.style.touchAction = 'manipulation'; if(window.PointerEvent){ node.addEventListener('pointerup', (event) => { if(event.pointerType === 'mouse' && event.button !== 0) return; handleBoardPress(event,key); }, { passive:false }); } else { node.addEventListener('touchend', (event) => handleBoardPress(event,key), { passive:false }); node.addEventListener('click', (event) => handleBoardPress(event,key), { passive:false }); } node.addEventListener('keydown', (event) => { if(event.key === 'Enter' || event.key === ' ') handleBoardPress(event,key); }); }
	Object.keys(boardProfiles).forEach((key) => bindReliableBoardPress(refs.boards[key], key));
	refs.historyBtn.addEventListener('click', () => openHistoryModal('history'));
	if(refs.usersBtn) refs.usersBtn.addEventListener('click', () => openHistoryModal('users'));
	if(refs.settingsBtn) refs.settingsBtn.addEventListener('click', () => openHistoryModal('settings'));
	document.addEventListener('click', (event) => { const trigger = event.target && event.target.closest ? event.target.closest('#historyBtn,#usersBtn,#settingsBtn') : null; if(!trigger) return; event.preventDefault(); event.stopPropagation(); if(trigger.id === 'usersBtn') openHistoryModal('users'); else if(trigger.id === 'settingsBtn') openHistoryModal('settings'); else openHistoryModal('history'); }, true);
	refs.historyTabs.forEach((tab) => tab.addEventListener('click', () => { roomPanel = tab.dataset.panel || 'history'; renderHistoryPopup(); }));
	if(refs.historyContent) refs.historyContent.addEventListener('input', (event) => { if(event.target && event.target.id === 'volumeRange'){ soundVolume = Math.min(1, Math.max(0, Number(event.target.value || 0) / 100)); localStorage.setItem('fruitSlotVolume', String(soundVolume)); playSound('coin'); } });
	if(refs.historyContent) refs.historyContent.addEventListener('click', (event) => { if(event.target && event.target.id === 'soundToggle'){ soundEnabled = !soundEnabled; localStorage.setItem('fruitSlotSound', soundEnabled ? 'on' : 'off'); renderHistoryPopup(); if(soundEnabled) playSound('payout'); } });
	refs.historyClose.addEventListener('click', closeHistoryModal);
	refs.historyModal.addEventListener('click', (event) => { if(event.target === refs.historyModal) closeHistoryModal(); });
	Object.values(refs.modals).forEach((modal) => { if(modal) modal.addEventListener('click', () => modal.classList.remove('show')); });
	if(window.BDGameFinal && window.BD_GAME_BOOTSTRAP && window.BD_GAME_BOOTSTRAP.gameCode === currentGameCode){ const api = window.BDGameFinal; api.onState((payload) => { if(!disposed && payload && payload.st) applyPayload(payload); }); if(typeof api.onConnection === 'function'){ api.onConnection((detail) => { if(!detail || disposed) return; if(detail.status === 'pending') setNetwork('warn','sync'); if(detail.status === 'error') setNetwork('bad','retry'); if(detail.status === 'expired'){ setNetwork('bad','expired'); show('Session Expired','Rejoin room'); } }); } refreshState(); if(typeof api.startHeartbeat === 'function') api.startHeartbeat(15000, () => lastNetworkMs || 0); else heartbeatTimer = window.setInterval(() => { if(disposed) return; if(typeof api.heartbeat === 'function') api.heartbeat(lastNetworkMs || 0); else api.post(window.BD_GAME_BOOTSTRAP.endpoints.heartbeat,{ network_ms: lastNetworkMs || 0 }); }, 15000); } else { setNetwork('bad','offline'); show('Live Session Required','Rejoin room'); }
	timerTick = window.setInterval(() => { if(lastStatePayload) updateTimer(lastStatePayload); }, 250);
	setProfile();
	renderHistoryPopup();
	refreshHistoryTables(true);
	function cleanupFruitSlotRoom(){ disposed = true; silenceRoomAudio(true); if(window.BDGameFinal && typeof window.BDGameFinal.stopHeartbeat === 'function') window.BDGameFinal.stopHeartbeat(); if(refreshTimer) window.clearInterval(refreshTimer); if(heartbeatTimer) window.clearInterval(heartbeatTimer); if(timerTick) window.clearInterval(timerTick); if(spinTimer) window.clearTimeout(spinTimer); if(resultPopupTimer) window.clearTimeout(resultPopupTimer); }
	document.addEventListener('visibilitychange', () => { if(document.hidden) silenceRoomAudio(false); });
	window.addEventListener('pagehide', cleanupFruitSlotRoom, { once:true });
	window.addEventListener('beforeunload', cleanupFruitSlotRoom, { once:true });
})();
</script>
@if($isGreedyRoom)
<style id="codex-greedy-450-postfix">
  @media (max-height:450px){
    .greaddy-shell .stage{
      gap:8px !important;
      padding:8px 8px 8px !important;
    }

    .greaddy-shell .hero{
      padding:0 4px !important;
    }

    .greaddy-shell .hero-head{
      padding:6px !important;
      gap:4px !important;
      justify-content:flex-start !important;
      flex-wrap:nowrap !important;
      overflow:hidden !important;
    }

    .greaddy-shell .hero-head > .tag,
    .greaddy-shell .hero-head > .history-btn{
      width:auto !important;
      min-width:0 !important;
      max-width:none !important;
      flex:0 0 auto !important;
    }

    .greaddy-shell #phase{
      flex:1 1 auto !important;
      min-width:0 !important;
      justify-content:center !important;
    }

    .greaddy-shell .net-tag{
      width:auto !important;
      min-width:48px !important;
      flex:0 0 48px !important;
    }

    .greaddy-shell .tag,
    .greaddy-shell .history-btn{
      padding:4px 6px !important;
      font-size:8px !important;
      letter-spacing:.08em !important;
    }

    .greaddy-shell #historyBtn{
      min-width:60px !important;
      max-width:60px !important;
      flex:0 0 60px !important;
      margin:0 !important;
    }

    .greaddy-shell .board-wrapper{
      padding:0 4px !important;
      align-items:flex-start !important;
      height:264px !important;
      min-height:264px !important;
      max-height:264px !important;
      overflow:hidden !important;
    }

    .greaddy-shell .board-outer{
      max-width:312px !important;
      padding:8px 6px 6px !important;
      border-radius:20px !important;
      transform:scale(.79) !important;
      transform-origin:top center !important;
    }

    .greaddy-shell .board-crown{
      margin-bottom:4px !important;
    }

    .greaddy-shell .greedy-main-trend{
      min-height:19px !important;
      margin:0 0 5px !important;
      padding:3px 5px !important;
      border-radius:12px !important;
      gap:4px !important;
      box-shadow:inset 0 1px 0 rgba(255,255,255,.10) !important;
    }

    .greaddy-shell .greedy-main-trend .recent-label{
      font-size:6px !important;
      letter-spacing:.08em !important;
    }

    .greaddy-shell .greedy-main-trend .recent-track{
      gap:3px !important;
      justify-content:center !important;
    }

    .greaddy-shell .greedy-main-trend .recent-pill{
      width:16px !important;
      height:16px !important;
      border-radius:6px !important;
      font-size:10px !important;
    }

    .greaddy-shell .board-lights-track{
      inset:24px 5px 5px !important;
    }

    .greaddy-shell .board-inner{
      padding:5px !important;
    }

    .greaddy-shell .board-grid{
      gap:5px !important;
    }

    .greaddy-shell .tile{
      min-height:60px !important;
      padding:4px 2px 6px !important;
      border-radius:11px !important;
    }

    .greaddy-shell .board-grid > .timer-box{
      min-height:60px !important;
    }

    .greaddy-shell .token{
      font-size:18px !important;
    }

    .greaddy-shell .name{
      margin-bottom:2px !important;
      line-height:1.05 !important;
      font-size:7px !important;
    }

    .greaddy-shell .multi{
      font-size:10px !important;
    }

    .greaddy-shell .tile-caption{
      font-size:6px !important;
      letter-spacing:.08em !important;
    }

    .greaddy-shell .pool{
      bottom:-7px !important;
      min-width:30px !important;
      padding:2px 4px !important;
      font-size:7px !important;
    }

    .greaddy-shell .board-grid > .timer-box{
      border-radius:14px !important;
    }

    .greaddy-shell .timer-label,
    .greaddy-shell .timer-foot{
      font-size:6px !important;
    }

    .greaddy-shell .timer-text{
      font-size:22px !important;
    }

    .greaddy-shell .chips{
      padding:4px max(5px,var(--safe-right)) max(5px,var(--safe-bottom)) max(5px,var(--safe-left)) !important;
      gap:4px !important;
    }

    .greaddy-shell .chip{
      height:34px !important;
      border-radius:14px !important;
      font-size:9px !important;
    }
  }
</style>
@endif
</body>
</html>
