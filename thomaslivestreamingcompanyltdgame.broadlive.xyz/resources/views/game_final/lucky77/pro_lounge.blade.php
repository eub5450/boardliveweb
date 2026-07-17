@php
  $currentGameCode = $gameCode ?? 'lucky7_pro';
  $gameTheme = is_array($gameTheme ?? null) ? $gameTheme : [];
  $displayTitle = 'Lucky 777 Pro';
  $displaySubtitle = 'Jackpot Wheel';
  $assetBase = asset('game_final_assets/lucky7_pro/png_assets');
  $assets = [
    'title' => asset('game_final_assets/lucky7_pro/custom/logo_lucky7_pro.webp'),
    'wheel_board' => asset('game_final_assets/lucky7_pro/custom/wheel_board.webp'),
    'pointer' => asset('game_final_assets/lucky7_pro/custom/pointer_gem.webp'),
    'winner_mark' => asset('game_final_assets/lucky7_pro/custom/winner_mark_reference_cropped.webp'),
    'ranking_button' => $assetBase . '/20_ranking_button.webp',
    'daily_bonus_button' => $assetBase . '/21_daily_bonus_button.webp',
    'mega_chest_button' => $assetBase . '/22_mega_chest_button.webp',
    'lucky_spin_button' => $assetBase . '/23_lucky_spin_button.webp',
    'symbol_red7' => asset('game_final_assets/lucky7_pro/custom/symbol_red7.webp'),
    'symbol_bell' => $assetBase . '/31_symbol_gold_bell.webp',
    'symbol_clover' => asset('game_final_assets/lucky7_pro/custom/symbol_clover.webp'),
    'symbol_crown' => asset('game_final_assets/lucky7_pro/custom/symbol_crown.webp'),
    'symbol_grapes' => $assetBase . '/34_symbol_purple_grapes.webp',
    'symbol_lemon' => $assetBase . '/35_symbol_yellow_lemon.webp',
    'symbol_cherries' => $assetBase . '/36_symbol_red_cherries.webp',
    'symbol_star' => $assetBase . '/37_symbol_gold_star.webp',
    'payout_table' => $assetBase . '/40_payout_table_full.webp',
    'payout_red7' => $assetBase . '/41_payout_red7_x100.webp',
    'payout_cherries' => $assetBase . '/42_payout_cherries_x50.webp',
    'payout_bell' => $assetBase . '/43_payout_bell_x30.webp',
    'payout_clover' => $assetBase . '/44_payout_clover_x20.webp',
    'payout_lemon' => $assetBase . '/45_payout_lemon_x15.webp',
    'payout_grapes' => $assetBase . '/46_payout_grapes_x15.webp',
    'payout_crown' => $assetBase . '/47_payout_crown_x10.webp',
    'payout_star' => $assetBase . '/48_payout_star_x5.webp',
    'bet_panel' => $assetBase . '/50_bet_control_panel.webp',
    'info_button' => $assetBase . '/51_info_button.webp',
    'minus_button' => $assetBase . '/52_minus_button.webp',
    'total_bet_panel' => $assetBase . '/53_total_bet_display.webp',
    'plus_button' => $assetBase . '/54_plus_button.webp',
    'max_bet_button' => $assetBase . '/55_max_bet_button.webp',
    'chip_1k' => asset('game_final_assets/lucky7_pro/custom/chip_1k.webp'),
    'chip_10k' => asset('game_final_assets/lucky7_pro/custom/chip_10k.webp'),
    'chip_50k' => asset('game_final_assets/lucky7_pro/custom/chip_50k.webp'),
    'chip_100k' => asset('game_final_assets/lucky7_pro/custom/chip_100k.webp'),
    'spin_button' => $assetBase . '/65_spin_button_green.webp',
    'help_button' => $assetBase . '/66_help_button.webp',
    'stats_button' => $assetBase . '/67_stats_button.webp',
    'boost_button' => $assetBase . '/68_boost_lightning_button.webp',
    'refresh_button' => $assetBase . '/69_refresh_button.webp',
    'clean_red7' => asset('game_final_assets/lucky7_pro/custom/symbol_red7.webp'),
    'clean_cherries' => $assetBase . '/81_clean_icon_cherries.webp',
    'clean_bell' => $assetBase . '/82_clean_icon_bell.webp',
    'clean_clover' => asset('game_final_assets/lucky7_pro/custom/symbol_clover.webp'),
    'clean_lemon' => $assetBase . '/84_clean_icon_lemon.webp',
    'clean_grapes' => $assetBase . '/85_clean_icon_grapes.webp',
    'clean_crown' => asset('game_final_assets/lucky7_pro/custom/symbol_crown.webp'),
    'clean_star' => $assetBase . '/87_clean_icon_star.webp',
  ];
  $interactiveBoards = [
    'slot' => [
      'name' => 'Red 7',
      'multiplier' => 'x7',
      'selector_icon' => $assets['clean_red7'],
      'result_icon' => $assets['symbol_red7'],
      'hotspot_class' => 'hotspot-slot',
    ],
    'melon' => [
      'name' => 'Crown',
      'multiplier' => 'x2',
      'selector_icon' => $assets['clean_crown'],
      'result_icon' => $assets['symbol_crown'],
      'hotspot_class' => 'hotspot-melon',
    ],
    'plum' => [
      'name' => 'Clover',
      'multiplier' => 'x2',
      'selector_icon' => $assets['clean_clover'],
      'result_icon' => $assets['symbol_clover'],
      'hotspot_class' => 'hotspot-plum',
    ],
  ];
  foreach ((array) ($gameRules['boards'] ?? config('bd_game_final.games.' . $currentGameCode . '.boards', [])) as $boardRule) {
    $boardKey = (string) ($boardRule['canonical_key'] ?? $boardRule['frontend_key'] ?? '');
    if ($boardKey !== '' && isset($interactiveBoards[$boardKey])) {
      $multiplier = rtrim(rtrim(number_format((float) ($boardRule['multiplier'] ?? 1), 2, '.', ''), '0'), '.');
      $interactiveBoards[$boardKey]['multiplier'] = 'x' . $multiplier;
    }
  }
  $legendSymbols = [
    ['name' => 'Red 7', 'gloss' => $assets['symbol_red7'], 'clean' => $assets['clean_red7']],
    ['name' => 'Cherries', 'gloss' => $assets['symbol_cherries'], 'clean' => $assets['clean_cherries']],
    ['name' => 'Bell', 'gloss' => $assets['symbol_bell'], 'clean' => $assets['clean_bell']],
    ['name' => 'Clover', 'gloss' => $assets['symbol_clover'], 'clean' => $assets['clean_clover']],
    ['name' => 'Lemon', 'gloss' => $assets['symbol_lemon'], 'clean' => $assets['clean_lemon']],
    ['name' => 'Grapes', 'gloss' => $assets['symbol_grapes'], 'clean' => $assets['clean_grapes']],
    ['name' => 'Crown', 'gloss' => $assets['symbol_crown'], 'clean' => $assets['clean_crown']],
    ['name' => 'Star', 'gloss' => $assets['symbol_star'], 'clean' => $assets['clean_star']],
  ];
  $payoutTiles = [
    ['name' => 'Red 7 payout', 'asset' => $assets['payout_red7']],
    ['name' => 'Cherries payout', 'asset' => $assets['payout_cherries']],
    ['name' => 'Bell payout', 'asset' => $assets['payout_bell']],
    ['name' => 'Clover payout', 'asset' => $assets['payout_clover']],
    ['name' => 'Lemon payout', 'asset' => $assets['payout_lemon']],
    ['name' => 'Grapes payout', 'asset' => $assets['payout_grapes']],
    ['name' => 'Crown payout', 'asset' => $assets['payout_crown']],
    ['name' => 'Star payout', 'asset' => $assets['payout_star']],
  ];
  $chipButtons = [
    ['value' => 1000, 'display_label' => '1K', 'tone' => 'violet', 'asset' => $assets['chip_1k']],
    ['value' => 10000, 'display_label' => '10K', 'tone' => 'emerald', 'asset' => $assets['chip_10k']],
    ['value' => 50000, 'display_label' => '50K', 'tone' => 'sapphire', 'asset' => $assets['chip_50k']],
    ['value' => 100000, 'display_label' => '100K', 'tone' => 'ruby', 'asset' => $assets['chip_100k']],
  ];
  $chipClientProfiles = [];
  foreach ($chipButtons as $chipButton) {
    $chipClientProfiles[] = [
      'value' => $chipButton['value'],
      'display_label' => $chipButton['display_label'],
      'asset' => $chipButton['asset'],
    ];
  }
  $boardClientProfiles = [];
  foreach ($interactiveBoards as $boardKey => $boardProfile) {
    $boardClientProfiles[$boardKey] = [
      'name' => $boardProfile['name'],
      'multiplier' => $boardProfile['multiplier'],
      'result_icon' => $boardProfile['result_icon'],
      'selector_icon' => $boardProfile['selector_icon'],
    ];
  }
  $defaultBoardKey = 'slot';
  $defaultChipValue = 1000;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover" />
<meta name="theme-color" content="#0f050d" />
<title>{{ $displayTitle }} · {{ $displaySubtitle }}</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Rajdhani:wght@500;600;700&display=swap');
*{box-sizing:border-box;margin:0;padding:0;-webkit-tap-highlight-color:transparent}
html,body{width:100%;height:100%;overflow:hidden;background:#0a020e;color:#fff4cd;font-family:'Rajdhani',system-ui,sans-serif}
body{background:
  radial-gradient(circle at 18% 20%, rgba(255,192,85,.24), transparent 22%),
  radial-gradient(circle at 84% 16%, rgba(77,116,255,.16), transparent 20%),
  linear-gradient(180deg,#190511 0%,#0d0310 42%,#050108 100%)}
button{font:inherit;background:none;border:0;cursor:pointer}
img{display:block;max-width:100%}
.app{position:fixed;inset:0;overflow:hidden;--safe-top:max(env(safe-area-inset-top), 8px);--safe-right:max(env(safe-area-inset-right), 8px);--safe-bottom:max(env(safe-area-inset-bottom), 10px);--safe-left:max(env(safe-area-inset-left), 8px);--chip-dock-h:102px}
.scene-reference{display:none}
.machine{position:relative;z-index:1;width:min(100vw,470px);height:100%;margin:0 auto;padding:max(8px,var(--safe-top)) max(10px,var(--safe-right)) calc(var(--chip-dock-h) + var(--safe-bottom) + 12px) max(10px,var(--safe-left));overflow-y:auto;overscroll-behavior:contain;scrollbar-width:none}
.machine::-webkit-scrollbar{display:none}
.decor-coin{display:none;position:absolute;pointer-events:none;z-index:0;filter:drop-shadow(0 18px 24px rgba(0,0,0,.28));opacity:.28}
.coin-stack-left{left:-8px;bottom:228px;width:98px}
.coin-stack-right{right:-6px;bottom:274px;width:96px}
.coin-float-left{left:-4px;top:360px;width:82px;animation:coinDriftLeft 6.8s ease-in-out infinite}
.coin-float-right{right:4px;top:430px;width:86px;animation:coinDriftRight 7.4s ease-in-out infinite}
.topbar,.title-wrap,.live-strip,.wheel-section,.selector-row,.paytable-shell,.legend-strip,.control-area,.bottom-tools,.side-buttons,.toast{position:relative;z-index:2}
.topbar{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:10px;align-items:center;padding:8px 2px 0}
.real-balance{min-width:0;padding:9px 12px;border-radius:18px;background:linear-gradient(180deg,rgba(31,11,43,.92),rgba(8,4,16,.96));border:1px solid rgba(255,210,118,.34);box-shadow:inset 0 1px 0 rgba(255,255,255,.08),0 12px 20px rgba(0,0,0,.24)}
.real-balance span,.real-title small{display:block;font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,232,178,.72)}
.real-balance strong{display:block;margin-top:3px;font-size:22px;line-height:1;color:#fff5ce;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.real-title{text-align:right;font-family:'Cinzel',serif;font-size:18px;font-weight:900;color:#fff1b8;text-shadow:0 0 18px rgba(255,214,111,.22)}
.real-title small{font-family:'Rajdhani',sans-serif;margin-top:2px}
.profile-cluster{display:flex;align-items:flex-start;gap:6px;padding-top:10px}
.avatar{width:58px;filter:drop-shadow(0 10px 18px rgba(0,0,0,.3))}
.vip-badge{width:72px;margin-top:8px;filter:drop-shadow(0 8px 16px rgba(0,0,0,.24))}
.topbar-main{display:grid;grid-template-columns:1fr 1fr;gap:8px;align-items:start;padding-top:8px}
.utility-cluster{display:flex;flex-direction:column;align-items:flex-end;gap:8px;padding-top:2px}
.network-icon{width:76px;margin-right:3px}
.menu-button{width:54px}
.menu-button img{width:100%}
.panel{position:relative}
.panel img{width:100%}
.panel-mask{position:absolute;background:linear-gradient(180deg,rgba(6,3,10,.97),rgba(4,2,8,.92));pointer-events:none}
.balance-panel .panel-mask{top:15%;bottom:15%;left:31%;right:21%;border-radius:18px}
.jackpot-panel .panel-mask{top:36%;bottom:15%;left:14%;right:14%;border-radius:18px}
.panel-copy{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;pointer-events:none}
.balance-panel .panel-copy{padding-left:46px;padding-right:48px}
.jackpot-panel .panel-copy{align-items:flex-end;padding-bottom:11px}
.panel-copy strong{font-family:'Rajdhani',sans-serif;font-weight:700;line-height:1;color:#fff2bd;text-shadow:0 0 14px rgba(255,214,111,.18)}
.balance-panel .panel-copy strong{font-size:clamp(16px,4.6vw,28px)}
.jackpot-panel .panel-copy strong{font-size:clamp(18px,4.9vw,31px)}
.title-wrap{display:none;margin:8px auto 4px;width:min(100%,354px)}
.title-wrap img{width:100%;margin:0 auto;filter:drop-shadow(0 14px 20px rgba(0,0,0,.34))}
.side-buttons{display:none}
.side-column{position:absolute;display:flex;flex-direction:column;gap:10px;pointer-events:auto}
.side-column.left{left:-2px}
.side-column.right{right:-2px}
.side-button{width:60px;filter:drop-shadow(0 12px 18px rgba(0,0,0,.28))}
.live-strip{display:grid;grid-template-columns:.9fr 1.1fr;gap:8px;margin:6px 12px 8px}
.live-card{position:relative;overflow:hidden;padding:10px 12px;border-radius:18px;background:linear-gradient(180deg,rgba(35,12,46,.86),rgba(12,4,18,.92));border:1px solid rgba(255,211,118,.36);box-shadow:inset 0 1px 0 rgba(255,255,255,.08),0 12px 20px rgba(0,0,0,.24);text-align:center}
.live-card:before{content:"";position:absolute;inset:1px;border-radius:17px;background:linear-gradient(120deg,rgba(255,255,255,.13),transparent 46%,rgba(255,209,92,.08));pointer-events:none}
.live-card span{display:block;font-size:11px;letter-spacing:.15em;text-transform:uppercase;color:rgba(255,232,178,.72)}
.live-card strong{display:block;margin-top:3px;font-size:25px;line-height:1;font-weight:700;color:#fff5ce}
.live-card.wide{display:flex;flex-direction:column;justify-content:center;gap:4px}
.live-card.wide strong{font-size:18px}
.live-card small{font-size:11px;letter-spacing:.12em;text-transform:uppercase;color:rgba(224,240,255,.8)}
.live-card small b{font-weight:700;color:#eff8ff}
.live-card.timer-hidden{opacity:0;visibility:hidden;pointer-events:none}
.clock-card:after{content:"";position:absolute;inset:5px;border-radius:999px;border:1px solid rgba(255,214,111,.16);background:conic-gradient(from -90deg,rgba(255,214,111,.8) var(--clock-deg,0deg),rgba(255,214,111,.12) 0);mask:linear-gradient(#000 0 0) content-box,linear-gradient(#000 0 0);-webkit-mask:linear-gradient(#000 0 0) content-box,linear-gradient(#000 0 0);padding:3px;pointer-events:none}
.wheel-section{margin:0 12px 10px;display:flex;flex-direction:column;align-items:center}
.wheel-countdown{position:relative;z-index:9;width:86px;height:86px;margin:0 auto 13px;border-radius:50%;display:grid;place-items:center;background:radial-gradient(circle at 50% 35%,rgba(255,246,190,.2),rgba(44,13,32,.96) 58%,rgba(10,3,15,.98));border:1px solid rgba(255,218,121,.58);box-shadow:inset 0 1px 0 rgba(255,255,255,.14),0 12px 22px rgba(0,0,0,.34),0 0 24px rgba(255,193,70,.2);text-align:center;transition:opacity .18s ease,transform .18s ease,visibility .18s ease}
.wheel-countdown span{display:block;margin-bottom:1px;font-size:10px;line-height:1;letter-spacing:.16em;text-transform:uppercase;color:rgba(255,235,176,.74)}
.wheel-countdown strong{display:block;font-family:'Cinzel',serif;font-size:38px;line-height:.92;font-weight:900;color:#fff3bf;text-shadow:0 0 18px rgba(255,214,111,.58),0 3px 0 rgba(79,27,0,.5)}
.wheel-countdown.timer-hidden{display:none;pointer-events:none}
.wheel-shell{position:relative;width:min(100%,364px);aspect-ratio:1;margin:0 auto;overflow:visible;filter:drop-shadow(0 28px 36px rgba(0,0,0,.42)) drop-shadow(0 0 22px rgba(255,194,76,.12))}
.wheel-shell.burst{animation:wheelBurst .9s ease}
.wheel-art{position:absolute;inset:0;width:100%;height:100%;border-radius:50%;transform-origin:center center;transition:transform 4.4s cubic-bezier(.08,.78,.08,1);will-change:transform}
.live-three-wheel{overflow:visible;background:transparent;border:0;box-shadow:none}
.live-three-wheel:before{display:none}
.live-three-wheel:after{display:none}
.wheel-board-art{position:absolute;inset:0;width:100%;height:100%;object-fit:contain;z-index:0}
.wheel-segment{display:none}
.wheel-pointer{display:block;position:absolute;left:50%;top:-1px;width:clamp(44px,13vw,74px);height:auto;z-index:8;pointer-events:none;opacity:1;transform:translate(-50%,-23%);filter:drop-shadow(0 0 14px rgba(255,225,127,.86)) drop-shadow(0 10px 13px rgba(0,0,0,.44))}
.wheel-shell.show-winner .wheel-pointer{animation:pointerWinnerPulse 1.12s ease-in-out 0s 2}
.wheel-center{display:none}
.wheel-winner-mark{display:block;position:absolute;width:clamp(42px,12vw,68px);height:auto;z-index:9;pointer-events:none;opacity:0;transform:translate(-50%,-50%) scale(.76);filter:drop-shadow(0 0 18px rgba(255,214,111,.72)) drop-shadow(0 9px 14px rgba(0,0,0,.38));transition:opacity .18s ease,transform .18s ease}
.wheel-shell.show-winner .wheel-winner-mark{opacity:1;animation:winnerMarkDance 1.15s ease-in-out 0s 2}
.wheel-shell[data-winner="slot"] .wheel-winner-mark{left:30%;top:38%}
.wheel-shell[data-winner="melon"] .wheel-winner-mark{left:70%;top:39%}
.wheel-shell[data-winner="plum"] .wheel-winner-mark{left:50%;top:72%}
.wheel-hotspot{position:absolute;border:0;background:transparent;box-shadow:none;outline:0;cursor:pointer}
.wheel-hotspot:hover,.wheel-hotspot.selected,.wheel-hotspot.pending,.wheel-hotspot.win,.wheel-hotspot.disabled{border:0;background:transparent;box-shadow:none;transform:none;opacity:1}
.hotspot-slot{top:16%;left:12%;width:35%;height:42%;border-radius:42%}
.hotspot-melon{top:18%;left:53%;width:35%;height:42%;border-radius:42%}
.hotspot-plum{top:57%;left:32%;width:36%;height:32%;border-radius:42%}
.result-banner{margin-top:10px;padding:10px 12px;border-radius:22px;background:linear-gradient(180deg,rgba(34,12,46,.92),rgba(9,3,15,.96));border:1px solid rgba(255,210,118,.38);box-shadow:inset 0 1px 0 rgba(255,255,255,.06),0 16px 24px rgba(0,0,0,.28);display:grid;grid-template-columns:60px minmax(0,1fr);gap:12px;align-items:center}
.result-icon-wrap{width:60px;height:60px;border-radius:18px;background:linear-gradient(180deg,rgba(255,255,255,.12),rgba(255,255,255,.04));display:grid;place-items:center;box-shadow:inset 0 1px 0 rgba(255,255,255,.08)}
.result-icon-wrap img{width:48px;height:48px;object-fit:contain;filter:drop-shadow(0 8px 10px rgba(0,0,0,.24))}
.result-copy-title{font-family:'Cinzel',serif;font-size:22px;font-weight:800;color:#fff1b8}
.result-copy-text{margin-top:4px;font-size:14px;line-height:1.35;color:rgba(231,241,255,.82)}
.result-copy-meta{margin-top:6px;font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,219,126,.76)}
.selector-row{display:grid;grid-template-columns:repeat(3,1fr);gap:9px;margin-top:10px}
.selector-card{position:relative;overflow:hidden;padding:10px 9px;border-radius:22px;background:radial-gradient(circle at 50% 0,rgba(255,221,126,.12),transparent 36%),linear-gradient(180deg,rgba(27,12,38,.94),rgba(8,4,15,.98));border:1px solid rgba(255,212,121,.34);box-shadow:inset 0 1px 0 rgba(255,255,255,.08),0 12px 18px rgba(0,0,0,.24);text-align:center;transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease}
.selector-card:before{content:"";position:absolute;inset:0;background:linear-gradient(120deg,rgba(255,255,255,.12),transparent 40%,rgba(255,194,70,.08));pointer-events:none}
.selector-card:hover,.selector-card.selected{transform:translateY(-4px);border-color:rgba(255,238,176,.86);box-shadow:0 0 0 2px rgba(255,221,126,.18),0 0 22px rgba(255,204,88,.2),0 12px 18px rgba(0,0,0,.24)}
.selector-card.pending{border-color:rgba(158,225,255,.84);box-shadow:0 0 0 2px rgba(158,225,255,.14),0 0 20px rgba(106,202,255,.2),0 12px 18px rgba(0,0,0,.24)}
.selector-card.win{border-color:rgba(255,244,188,.96);box-shadow:0 0 0 2px rgba(255,220,114,.24),0 0 24px rgba(255,204,88,.22),0 12px 18px rgba(0,0,0,.24)}
.selector-card.winner-dance{z-index:4;animation:winnerBoardDance 1.12s cubic-bezier(.2,.85,.22,1) 0s 2}
.selector-card.winner-dance:after{content:"";position:absolute;inset:0;border-radius:inherit;pointer-events:none;background:radial-gradient(circle at 50% 24%,rgba(255,248,192,.55),transparent 32%),linear-gradient(120deg,transparent,rgba(255,217,100,.32),transparent);animation:winnerBoardPulse 1.12s ease 0s 2}
.selector-card.disabled{opacity:.82}
.selector-icon{width:42px;height:42px;margin:0 auto 6px;object-fit:contain;filter:drop-shadow(0 7px 8px rgba(0,0,0,.32))}
.selector-name{font-size:14px;font-weight:700;color:#fff1b8}
.selector-multi{font-size:12px;font-weight:700;color:#ffda75}
.selector-stats{display:grid;grid-template-columns:1fr 1fr;gap:5px;margin-top:8px}
.selector-stats span{padding:5px 4px;border-radius:10px;background:rgba(255,255,255,.055);border:1px solid rgba(255,220,138,.14);font-size:9px;letter-spacing:.08em;text-transform:uppercase;color:rgba(255,232,178,.66)}
.selector-stats b{display:block;margin-top:2px;font-size:clamp(11px,2.7vw,15px);line-height:1;color:#fff;font-weight:900;letter-spacing:0;text-transform:none;white-space:nowrap}
.selector-pool,.selector-mine{font:inherit;color:inherit}
.paytable-shell{display:none;position:relative;margin-top:12px;padding:10px;border-radius:28px;background:linear-gradient(180deg,rgba(34,12,46,.28),rgba(9,3,15,.3))}
.paytable-base{position:absolute;inset:0;width:100%;height:100%;object-fit:fill;opacity:.26;pointer-events:none}
.paytable-grid{position:relative;display:grid;grid-template-columns:repeat(4,1fr);gap:0;overflow:hidden;border-radius:22px;box-shadow:0 18px 30px rgba(0,0,0,.28)}
.paytable-grid img{width:100%;height:auto}
.legend-strip{display:none;grid-template-columns:repeat(4,1fr);gap:8px;margin-top:12px}
.legend-item{padding:8px 6px;border-radius:18px;background:linear-gradient(180deg,rgba(30,11,42,.9),rgba(10,4,17,.94));border:1px solid rgba(255,210,118,.24);box-shadow:inset 0 1px 0 rgba(255,255,255,.06),0 10px 16px rgba(0,0,0,.22);text-align:center}
.legend-clean{width:20px;height:20px;margin:0 auto 4px;object-fit:contain;opacity:.92}
.legend-gloss{width:38px;height:38px;margin:0 auto 4px;object-fit:contain;filter:drop-shadow(0 6px 10px rgba(0,0,0,.22))}
.legend-item span{display:block;font-size:10px;letter-spacing:.06em;color:rgba(255,240,198,.82)}
.control-area{margin-top:14px}
.control-deck{position:relative;padding:4px 0}
.control-base{position:absolute;left:0;right:0;top:10px;width:100%;opacity:.3;pointer-events:none}
.control-row{position:relative;display:grid;grid-template-columns:52px 52px minmax(0,1fr) 52px 88px;gap:8px;align-items:center}
.control-button img,.control-display img,.spin-button img,.bottom-tools img{width:100%}
.control-display{position:relative}
.total-mask{position:absolute;top:28%;bottom:10%;left:12%;right:12%;border-radius:18px;background:linear-gradient(180deg,rgba(5,2,10,.97),rgba(3,1,8,.92));pointer-events:none}
.control-copy{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;pointer-events:none}
.control-copy span{font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,232,178,.74)}
.control-copy strong{font-size:30px;line-height:1;color:#fff6d2;font-weight:700}
.control-copy small{margin-top:2px;font-size:10px;color:rgba(224,239,255,.78)}
.chips{position:fixed;left:50%;bottom:calc(var(--safe-bottom) + 10px);transform:translateX(-50%);width:min(calc(100vw - 20px), 430px);display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:10px;padding:12px 12px 10px;border-radius:28px;background:linear-gradient(180deg,rgba(28,10,38,.96),rgba(7,3,14,.96));border:1px solid rgba(255,210,118,.30);box-shadow:0 18px 30px rgba(0,0,0,.34),inset 0 1px 0 rgba(255,255,255,.08);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);z-index:6;overflow:visible}
.stake-pill,.history-card{position:relative;overflow:hidden;backdrop-filter:blur(20px) saturate(128%);-webkit-backdrop-filter:blur(20px) saturate(128%)}
.chips:before,.stake-pill:before,.history-card:before{content:"";position:absolute;inset:0;background:linear-gradient(118deg, rgba(255,255,255,.17), rgba(255,255,255,.05) 34%, transparent 62%);opacity:.34;pointer-events:none}
.chip{position:relative;display:grid;place-items:center;min-width:0;min-height:76px;border-radius:22px;transition:transform .18s ease,filter .18s ease;background:radial-gradient(circle at 50% 35%,rgba(255,255,255,.09),rgba(255,255,255,.025) 48%,rgba(0,0,0,.12) 100%);border:1px solid rgba(255,222,142,.14)}
.chip.selected{transform:translateY(-8px) scale(1.04);filter:drop-shadow(0 0 18px rgba(255,210,118,.34))}
.chip-asset{width:72px;height:72px;object-fit:contain;filter:drop-shadow(0 9px 14px rgba(0,0,0,.34))}
.casino-chip-face{position:relative;width:62px;aspect-ratio:1;border-radius:50%;display:grid;place-items:center;background:radial-gradient(circle at 36% 28%, #fff7cf 0 8%, var(--chip-light) 9% 28%, var(--chip-mid) 29% 62%, var(--chip-dark) 63% 100%);box-shadow:inset 0 2px 3px rgba(255,255,255,.42),inset 0 -5px 9px rgba(0,0,0,.32),0 9px 16px rgba(0,0,0,.34),0 0 0 2px rgba(255,239,170,.28)}
.casino-chip-face:before{content:"";position:absolute;inset:6px;border-radius:50%;border:4px dashed rgba(255,250,220,.78);filter:drop-shadow(0 1px 1px rgba(0,0,0,.25))}
.casino-chip-face:after{content:"";position:absolute;inset:18px;border-radius:50%;background:linear-gradient(180deg,rgba(8,4,13,.88),rgba(19,8,27,.92));border:1px solid rgba(255,230,150,.36)}
.casino-chip-label{position:relative;z-index:1;font-family:'Cinzel',serif;font-weight:900;font-size:13px;line-height:1;color:#fff3bd;text-shadow:0 1px 2px rgba(0,0,0,.7)}
.chip.tone-violet{--chip-light:#d8a4ff;--chip-mid:#7e31d8;--chip-dark:#2a0b58}
.chip.tone-emerald{--chip-light:#a8ffcb;--chip-mid:#18a86d;--chip-dark:#06452c}
.chip.tone-sapphire{--chip-light:#b2e5ff;--chip-mid:#1d77d6;--chip-dark:#062f6f}
.chip.tone-ruby{--chip-light:#ffb4bd;--chip-mid:#d72846;--chip-dark:#650915}
.control-deck,.stake-meta,.spin-button{display:none}
.stake-meta{grid-template-columns:1fr 1.15fr;gap:8px;margin-top:10px}
.stake-pill{padding:10px 12px;border-radius:18px;background:linear-gradient(180deg,rgba(30,11,42,.9),rgba(10,4,17,.94));border:1px solid rgba(255,210,118,.24);box-shadow:inset 0 1px 0 rgba(255,255,255,.06),0 10px 16px rgba(0,0,0,.22)}
.stake-pill span{display:block;font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,232,178,.72)}
.stake-pill strong{display:block;margin-top:4px;font-size:18px;color:#fff4cd;font-weight:700;line-height:1.1}
.stake-pill small{display:block;margin-top:3px;font-size:11px;color:rgba(224,239,255,.78)}
.spin-button{display:none;width:min(100%,360px);margin:14px auto 0;transition:transform .18s ease,filter .18s ease}
.spin-button:active{transform:scale(.99)}
.spin-button.disabled{opacity:.68;filter:saturate(.7);cursor:not-allowed}
.spin-button img{width:100%}
.room-actions{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:6px;margin:10px 2px 0}
.tool-button{position:relative;overflow:hidden;min-height:46px;border-radius:16px;background:linear-gradient(180deg,rgba(35,12,46,.92),rgba(9,4,16,.98));border:1px solid rgba(255,210,118,.28);box-shadow:inset 0 1px 0 rgba(255,255,255,.08),0 10px 16px rgba(0,0,0,.2);color:#fff0bd;transition:transform .16s ease,box-shadow .16s ease,border-color .16s ease}
.tool-button:before{content:"";position:absolute;inset:0;background:linear-gradient(120deg,rgba(255,255,255,.12),transparent 44%,rgba(255,212,97,.08));pointer-events:none}
.tool-button:active{transform:scale(.98)}
.tool-button b{display:block;position:relative;font-size:12px;line-height:1;font-weight:900;letter-spacing:.02em}
.tool-button span{display:block;position:relative;margin-top:4px;font-size:9px;letter-spacing:.12em;text-transform:uppercase;color:rgba(231,242,255,.72)}
.tool-button.active,.tool-button:hover{border-color:rgba(255,239,180,.78);box-shadow:0 0 0 2px rgba(255,221,126,.13),0 0 20px rgba(255,204,88,.16),0 10px 16px rgba(0,0,0,.2)}
.recent-strip{display:grid;grid-template-columns:auto minmax(0,1fr) auto;gap:8px;align-items:center;margin:10px 2px 0;padding:8px 10px;border-radius:18px;background:linear-gradient(180deg,rgba(35,12,46,.8),rgba(9,4,16,.92));border:1px solid rgba(255,210,118,.24);box-shadow:inset 0 1px 0 rgba(255,255,255,.06),0 10px 16px rgba(0,0,0,.2)}
.recent-label{font-size:10px;letter-spacing:.12em;text-transform:uppercase;color:rgba(255,232,178,.72);font-weight:900;white-space:nowrap}
.recent-track{display:flex;gap:6px;overflow:hidden;min-width:0}
.recent-pill{width:30px;height:30px;flex:0 0 30px;border-radius:50%;display:grid;place-items:center;background:rgba(255,255,255,.06);border:1px solid rgba(255,225,146,.2)}
.recent-pill img{width:24px;height:24px;object-fit:contain;filter:drop-shadow(0 4px 6px rgba(0,0,0,.28))}
.active-users-pill{display:flex;align-items:center;gap:5px;padding:6px 8px;border-radius:999px;background:rgba(255,255,255,.055);border:1px solid rgba(255,225,146,.18);font-size:10px;text-transform:uppercase;letter-spacing:.1em;color:#fff0bd;white-space:nowrap}
.active-users-pill b{font-size:13px;color:#fff}
.toast{position:fixed;left:50%;top:50%;transform:translate(-50%,-50%) scale(.92);min-width:240px;max-width:min(88vw,360px);padding:16px 20px;border-radius:26px;background:linear-gradient(180deg,rgba(34,12,46,.98),rgba(8,4,16,.98));border:1px solid rgba(255,210,118,.4);box-shadow:0 28px 42px rgba(0,0,0,.42),0 0 36px rgba(255,204,108,.16);text-align:center;opacity:0;pointer-events:none;transition:.2s;z-index:8}
.toast.show{opacity:1;transform:translate(-50%,-50%) scale(1)}
.toast b{display:block;font-family:'Cinzel',serif;font-size:22px;color:#fff3c0}
.toast span{display:block;margin-top:4px;font-size:13px;letter-spacing:.12em;text-transform:uppercase;color:rgba(231,242,255,.82)}
.history-modal{position:fixed;inset:0;display:none;align-items:center;justify-content:center;padding:18px;background:rgba(4,2,8,.72);backdrop-filter:blur(12px);z-index:10}
.history-modal.is-open{display:flex}
.history-card{width:min(92vw,460px);max-height:min(82vh,640px);overflow-x:hidden;overflow-y:auto;padding:18px;border-radius:28px;background:linear-gradient(180deg,rgba(31,11,43,.98),rgba(8,4,16,.98));border:1px solid rgba(255,210,118,.32);box-shadow:0 26px 42px rgba(0,0,0,.44)}
.history-head{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:12px}
.history-head h3{font-family:'Cinzel',serif;font-size:20px;color:#fff3c0}
.history-head p{margin-top:4px;font-size:12px;color:rgba(231,242,255,.76)}
.history-close{padding:10px 14px;border-radius:16px;border:1px solid rgba(255,210,118,.24);background:rgba(255,255,255,.06);color:#fff3c0}
.history-tabs{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:6px;margin-bottom:14px}
.history-tab{padding:8px 4px;border-radius:13px;border:1px solid rgba(255,210,118,.18);background:rgba(255,255,255,.045);color:rgba(255,240,189,.72);font-size:10px;font-weight:900;letter-spacing:.08em;text-transform:uppercase}
.history-tab.active{border-color:rgba(255,239,180,.72);background:rgba(255,218,118,.12);color:#fff3c0}
.history-stack{display:grid;gap:14px}
.history-section{padding:14px;border-radius:22px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.08)}
.history-section-head{display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:10px}
.history-section-title{font-size:13px;font-weight:800;letter-spacing:.1em;text-transform:uppercase;color:#fff0bd}
.history-section-sub{font-size:11px;color:rgba(231,242,255,.68)}
.history-table-wrap{border-radius:18px;overflow-x:hidden;overflow-y:auto;border:1px solid rgba(255,255,255,.08)}
.history-table{width:100%;max-width:100%;min-width:0;table-layout:fixed;border-collapse:collapse;font-size:12px;color:#fff}
.history-table th,.history-table td{padding:10px 12px;text-align:left;vertical-align:top;white-space:normal;overflow-wrap:anywhere;word-break:break-word}
.history-table th{position:sticky;top:0;background:rgba(14,8,24,.96);font-size:10px;letter-spacing:.16em;text-transform:uppercase;color:rgba(255,240,189,.74);z-index:1}
.history-table tbody tr:nth-child(odd){background:rgba(255,255,255,.03)}
.history-table tbody tr:nth-child(even){background:rgba(255,255,255,.06)}
.history-empty{padding:14px;border-radius:16px;background:rgba(255,255,255,.04);text-align:center;color:rgba(231,242,255,.72)}
.history-board{display:flex;align-items:center;gap:8px;min-width:0}
.history-board-icon{width:24px;height:24px;object-fit:contain;filter:drop-shadow(0 4px 8px rgba(0,0,0,.26))}
.history-board-matrix{table-layout:fixed}
.history-board-matrix th,.history-board-matrix td{text-align:center}
.history-board-matrix th:first-child,.history-board-matrix td:first-child{width:46px}
.history-board-matrix th:last-child,.history-board-matrix td:last-child{width:58px}
.history-board-matrix .history-trace{text-align:left}
.history-board-matrix th{font-size:9px;letter-spacing:.08em;padding-inline:5px}
.history-board-matrix td{height:38px;padding:6px 5px}
.history-board-matrix .history-status{padding:3px 5px;font-size:8px;letter-spacing:.06em;white-space:normal}
.history-board-token-cell{background:rgba(255,255,255,.025)}
.history-board-token-cell.is-winner{background:radial-gradient(circle at 50% 45%,rgba(255,228,121,.18),transparent 64%),rgba(255,255,255,.07)}
.history-board-token{width:30px;height:30px;margin:0 auto;border-radius:50%;display:grid;place-items:center;background:rgba(255,255,255,.09);border:1px solid rgba(255,231,154,.32);font-size:12px;font-weight:1000;line-height:1;box-shadow:0 7px 12px rgba(0,0,0,.24);overflow:hidden}
.history-board-token img{width:24px;height:24px;object-fit:contain;filter:drop-shadow(0 4px 8px rgba(0,0,0,.26))}
.history-trace{font-size:11px;line-height:1.35;word-break:break-word;color:rgba(255,255,255,.86)}
.history-status{display:inline-flex;align-items:center;justify-content:center;padding:4px 8px;border-radius:999px;font-size:10px;font-weight:900;letter-spacing:.12em;text-transform:uppercase;white-space:nowrap}
.history-status.win{background:rgba(71,232,150,.14);color:#7df0b4;border:1px solid rgba(71,232,150,.22)}
.history-status.loss{background:rgba(255,106,142,.14);color:#ff9fb9;border:1px solid rgba(255,106,142,.22)}
.history-status.pending{background:rgba(255,214,111,.14);color:#ffd86a;border:1px solid rgba(255,214,111,.22)}.history-status.punishment{background:rgba(255,173,92,.14);color:#ffc98f;border:1px solid rgba(255,173,92,.22)}
.winner-grid,.active-grid,.settings-grid,.info-grid{display:grid;gap:10px}
.winner-card,.active-card,.settings-card,.info-card{display:grid;grid-template-columns:auto minmax(0,1fr) auto;gap:10px;align-items:center;padding:12px;border-radius:18px;background:rgba(255,255,255,.045);border:1px solid rgba(255,255,255,.08)}
.winner-card img,.active-card img{width:34px;height:34px;object-fit:contain;filter:drop-shadow(0 6px 8px rgba(0,0,0,.28))}
.profile-avatar{width:34px;height:34px;border-radius:50%;display:grid;place-items:center;background:radial-gradient(circle at 35% 24%,#fff7cf,#ffd05d 50%,#8b4a09 100%);border:1px solid rgba(255,240,180,.72);box-shadow:inset 0 1px 0 rgba(255,255,255,.55),0 5px 12px rgba(0,0,0,.28);color:#3b1800;font-size:13px;font-weight:1000}
.winner-card b,.active-card b,.settings-card b,.info-card b{display:block;color:#fff3c0;font-size:13px}
.winner-card span,.active-card span,.settings-card span,.info-card span{display:block;margin-top:2px;color:rgba(231,242,255,.72);font-size:11px}
.active-grid.users-card-grid{grid-template-columns:repeat(6,minmax(0,1fr));gap:6px}
.active-card.user-profile-card{grid-template-columns:1fr;justify-items:center;align-content:start;gap:5px;min-width:0;padding:8px 4px;border-radius:12px;text-align:center}
.active-card.user-profile-card .profile-avatar{width:38px;height:38px;border-radius:13px;overflow:hidden;font-size:15px}
.active-card.user-profile-card .profile-avatar img{width:100%;height:100%;display:block;object-fit:cover}
.active-card.user-profile-card b{max-width:100%;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:9px;line-height:1.15}
.active-card.user-profile-card span{font-size:8px;line-height:1.15;white-space:nowrap}
.settings-card{grid-template-columns:minmax(0,1fr) auto}
.settings-toggle{width:52px;height:30px;border-radius:999px;background:rgba(255,255,255,.08);border:1px solid rgba(255,210,118,.25);position:relative}
.settings-toggle:after{content:"";position:absolute;top:4px;left:4px;width:20px;height:20px;border-radius:50%;background:#fff0bd;transition:left .18s ease,background .18s ease}
.settings-toggle.on{background:rgba(255,214,111,.24)}
.settings-toggle.on:after{left:26px;background:#ffd76c}
.coin-layer{position:fixed;inset:0;pointer-events:none;z-index:40;overflow:hidden}
.flying-coin{position:absolute;left:var(--x0);top:var(--y0);width:18px;height:18px;border-radius:50%;background:radial-gradient(circle at 32% 28%,#fff8c8 0 14%,#ffd669 15% 45%,#b87513 46% 100%);border:1px solid rgba(255,241,176,.78);box-shadow:0 0 10px rgba(255,212,92,.35),0 5px 10px rgba(0,0,0,.28);animation:coinFlight var(--dur,900ms) cubic-bezier(.2,.72,.16,1) forwards;animation-delay:var(--delay,0ms)}
.flying-coin:after{content:"";position:absolute;inset:5px;border-radius:50%;border:1px solid rgba(104,58,8,.5)}
.winner-spark{position:absolute;left:var(--x0);top:var(--y0);width:9px;height:9px;border-radius:50%;background:#fff4b6;box-shadow:0 0 12px #ffd76c;animation:sparkPop var(--dur,760ms) ease-out forwards;animation-delay:var(--delay,0ms)}
@keyframes coinFlight{0%{opacity:0;transform:translate(-50%,-50%) scale(.55) rotate(0)}12%{opacity:1}72%{opacity:1}100%{opacity:0;transform:translate(calc(var(--x1) - var(--x0)),calc(var(--y1) - var(--y0))) scale(1.08) rotate(520deg)}}
@keyframes sparkPop{0%{opacity:0;transform:translate(-50%,-50%) scale(.4)}20%{opacity:1}100%{opacity:0;transform:translate(calc(var(--dx) * 1px),calc(var(--dy) * 1px)) scale(1.8)}}
@keyframes winnerBoardDance{0%,100%{transform:translateY(0) rotate(0) scale(1)}14%{transform:translateY(-10px) rotate(-2deg) scale(1.04)}32%{transform:translateY(3px) rotate(2deg) scale(.99)}52%{transform:translateY(-7px) rotate(1deg) scale(1.03)}74%{transform:translateY(0) rotate(-1deg) scale(1.01)}}
@keyframes winnerBoardPulse{0%,100%{opacity:0}25%,68%{opacity:.58}}
@keyframes winnerMarkDance{0%,100%{filter:drop-shadow(0 0 18px rgba(255,214,111,.72)) drop-shadow(0 9px 14px rgba(0,0,0,.38));transform:translate(-50%,-50%) scale(1) rotate(0)}35%{filter:drop-shadow(0 0 28px rgba(255,245,188,.95)) drop-shadow(0 12px 18px rgba(0,0,0,.42));transform:translate(-50%,-58%) scale(1.13) rotate(-7deg)}68%{transform:translate(-50%,-48%) scale(.98) rotate(6deg)}}
@keyframes pointerWinnerPulse{0%,100%{transform:translate(-50%,-23%) scale(1);filter:drop-shadow(0 0 14px rgba(255,225,127,.86)) drop-shadow(0 10px 13px rgba(0,0,0,.44))}38%{transform:translate(-50%,-29%) scale(1.13);filter:drop-shadow(0 0 26px rgba(255,246,185,.98)) drop-shadow(0 12px 18px rgba(0,0,0,.5))}68%{transform:translate(-50%,-20%) scale(.98)}}
.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}
@keyframes wheelBurst{0%{transform:scale(1)}30%{transform:scale(1.03)}55%{transform:scale(.992)}100%{transform:scale(1)}}
@keyframes coinDriftLeft{0%,100%{transform:translateY(0) rotate(-8deg)}50%{transform:translateY(-8px) rotate(8deg)}}
@keyframes coinDriftRight{0%,100%{transform:translateY(0) rotate(10deg)}50%{transform:translateY(-10px) rotate(-8deg)}}
@media (max-width:520px){
  .machine{padding-left:max(8px,var(--safe-left));padding-right:max(8px,var(--safe-right))}
  .topbar,.topbar-main{gap:6px}
  .side-buttons{top:128px}
  .side-column.left{left:2px}
  .side-column.right{right:2px}
  .side-button{width:52px}
  .live-strip{grid-template-columns:.9fr 1.1fr;margin:6px 34px 8px;gap:6px}
  .live-card{padding:8px 10px}
  .wheel-countdown{width:78px;height:78px;margin-bottom:12px}
  .wheel-countdown strong{font-size:35px}
  .wheel-section{margin:0 26px 8px}
  .result-banner{grid-template-columns:52px minmax(0,1fr);gap:10px}
  .result-icon-wrap{width:52px;height:52px}
  .result-icon-wrap img{width:44px;height:44px}
  .selector-row{gap:7px}
  .paytable-shell{padding:8px;border-radius:24px}
  .legend-strip{gap:6px}
  .control-row{grid-template-columns:44px 44px minmax(0,1fr) 44px 70px;gap:6px}
  .control-copy strong{font-size:24px}
  .stake-meta{grid-template-columns:1fr;gap:6px}
  .stake-pill{padding:9px 10px}
  .spin-button{width:min(100%,320px)}
  .bottom-tools{padding:0 10px;gap:8px}
}
@media (max-width:430px){
  .machine{padding-left:max(8px,var(--safe-left));padding-right:max(8px,var(--safe-right))}
  .topbar{gap:6px}
  .topbar-main{gap:6px}
  .avatar{width:52px}
  .vip-badge{width:66px}
  .menu-button{width:48px}
  .side-buttons{top:132px}
  .side-button{width:56px}
  .live-strip{margin-left:42px;margin-right:42px}
  .wheel-section{margin-left:36px;margin-right:36px}
  .control-row{grid-template-columns:46px 46px minmax(0,1fr) 46px 78px;gap:6px}
  .control-copy strong{font-size:24px}
  .bottom-tools{padding:0 14px;gap:10px}
  .chips{width:min(calc(100vw - 16px), 410px);padding:10px 10px 9px;gap:8px}
}
@media (max-width:380px){
  .app{--chip-dock-h:96px}
  .avatar{width:46px}
  .vip-badge{width:58px}
  .network-icon{width:64px}
  .menu-button{width:44px}
  .side-buttons{top:120px}
  .side-button{width:46px}
  .title-wrap{width:min(100%,300px)}
  .live-strip{margin-left:26px;margin-right:26px;gap:5px}
  .live-card{padding:7px 8px;border-radius:16px}
  .live-card span,.live-card small{font-size:10px}
  .live-card strong{font-size:19px}
  .wheel-section{margin:0 18px 8px}
  .wheel-shell{width:min(100%,272px)}
  .result-banner{padding:9px 10px;border-radius:18px;grid-template-columns:48px minmax(0,1fr);gap:8px}
  .result-icon-wrap{width:48px;height:48px;border-radius:14px}
  .result-icon-wrap img{width:40px;height:40px}
  .result-copy-title{font-size:18px}
  .result-copy-text{font-size:12px}
  .result-copy-meta{font-size:10px}
  .selector-card{padding:8px 6px;border-radius:18px}
  .selector-icon{width:28px;height:28px}
  .selector-name{font-size:12px}
  .selector-multi,.selector-mine{font-size:10px}
  .selector-pool{font-size:15px}
  .legend-item{padding:6px 4px;border-radius:14px}
  .legend-clean{width:16px;height:16px}
  .legend-gloss{width:30px;height:30px}
  .legend-item span{font-size:9px}
  .control-row{grid-template-columns:40px 40px minmax(0,1fr) 40px 62px;gap:5px}
  .control-copy span,.control-copy small{font-size:9px}
  .control-copy strong{font-size:20px}
  .chips{width:min(calc(100vw - 12px), 360px);bottom:calc(var(--safe-bottom) + 8px);padding:8px 8px 7px;gap:6px;border-radius:22px}
  .chip.selected{transform:translateY(-5px) scale(1.02)}
  .stake-meta{margin-top:8px}
  .stake-pill{padding:8px 10px;border-radius:14px}
  .stake-pill span,.stake-pill small{font-size:10px}
  .stake-pill strong{font-size:16px}
  .spin-button{width:min(100%,292px);margin-top:10px}
  .room-actions{gap:5px}
  .tool-button{min-height:40px;border-radius:13px}
  .tool-button b{font-size:10px}
  .tool-button span{font-size:8px}
  .recent-strip{padding:7px 8px;gap:6px}
  .recent-pill{width:26px;height:26px;flex-basis:26px}
  .recent-pill img{width:21px;height:21px}
  .toast{min-width:0;width:min(88vw,320px);padding:14px 16px}
}
@media (max-width:340px){
  .live-strip{margin-left:22px;margin-right:22px}
  .wheel-section{margin:0 12px 8px}
  .wheel-countdown{width:70px;height:70px;margin-bottom:10px}
  .wheel-countdown strong{font-size:31px}
  .selector-row{grid-template-columns:repeat(3,minmax(0,1fr));gap:5px}
  .selector-card{padding:7px 4px;border-radius:16px}
  .selector-icon{width:26px;height:26px}
  .selector-name{font-size:11px}
  .selector-multi,.selector-mine{font-size:9px}
  .selector-pool{font-size:14px}
  .paytable-grid{grid-template-columns:repeat(2,minmax(0,1fr))}
}
@media (max-height:880px){
  .app{--chip-dock-h:102px}
  .coin-stack-left{bottom:200px;width:84px}
  .coin-stack-right{bottom:248px;width:82px}
  .coin-float-left{top:334px;width:72px}
  .coin-float-right{top:398px;width:76px}
  .title-wrap{width:min(100%,330px)}
  .live-strip{margin-bottom:8px}
  .wheel-shell{width:min(100%,304px)}
  .result-banner{grid-template-columns:54px minmax(0,1fr)}
  .result-icon-wrap{width:54px;height:54px}
  .result-copy-title{font-size:20px}
  .selector-name{font-size:13px}
  .selector-pool{font-size:17px}
  .legend-item span{font-size:9px}
  .chips{gap:8px}
}
@media (max-height:760px){
  .app{--chip-dock-h:94px}
  .title-wrap{margin-top:6px}
  .live-card{padding:8px 10px}
  .live-card strong{font-size:22px}
  .wheel-section{margin-bottom:8px}
  .selector-row{gap:7px}
  .paytable-shell{margin-top:10px;padding:8px}
  .legend-strip{gap:6px;margin-top:10px}
  .legend-item{padding:6px 4px}
  .control-area{margin-top:12px}
  .stake-meta{margin-top:8px}
  .bottom-tools{margin-top:12px}
}
/* Mobile fit layer: chips fixed at bottom, no internal scroll, compact 450/325 heights */
html,body,.app{width:100vw;height:100dvh;max-width:100vw;max-height:100dvh;overflow:hidden}
.machine{width:100vw;max-width:470px;height:100dvh;overflow:hidden;padding-bottom:calc(var(--chip-dock-h) + var(--safe-bottom) + 8px)}
.chips{
  position:fixed !important;
  left:50% !important;
  right:auto !important;
  bottom:calc(var(--safe-bottom) + 8px) !important;
  transform:translateX(-50%) !important;
  width:min(calc(100vw - 18px), 450px) !important;
  max-width:450px !important;
  display:grid;
  grid-template-columns:repeat(4,minmax(0,1fr));
  border-radius:26px;
  overflow:visible;
  z-index:30;
}
.chip{min-width:0}
.selector-stats b.selector-pool,.selector-stats b.selector-mine{font-size:clamp(11px,2.7vw,15px);line-height:1;color:#fff;font-weight:900;letter-spacing:0;text-transform:none;white-space:nowrap}
@media(max-height:450px){
  .app{--chip-dock-h:48px}
  .machine{padding:max(4px,var(--safe-top)) max(6px,var(--safe-right)) calc(var(--chip-dock-h) + var(--safe-bottom)) max(6px,var(--safe-left));gap:5px}
  .top-strip,.stake-meta,.room-actions,.recent-strip{display:none}
  .wheel-section{padding:6px;border-radius:14px;gap:5px}
  .result-copy-text,.result-kicker,.result-meta{display:none}
  .chips{padding:5px 5px max(5px,var(--safe-bottom));gap:4px}
  .chip-asset,.casino-chip-face{width:42px;height:42px}.chip.selected{transform:translateY(-3px) scale(1.02)}
  .spin-button{width:44px;height:44px}
}
@media(max-height:325px){
  .app{--chip-dock-h:38px}
  .machine{padding:3px 4px calc(var(--chip-dock-h) + var(--safe-bottom));gap:3px}
  .result-copy,.stake-panel{display:none}
  .wheel-section{padding:4px;border-radius:10px}
  .chips{padding:4px 4px max(4px,var(--safe-bottom));gap:3px}
  .chip-asset,.casino-chip-face{width:32px;height:32px}.spin-button{width:34px;height:34px}
}

/* Publish fit layer: one-screen mobile playfield, icon menu, no scroll */
:root{--lp-top:48px;--lp-status:27px;--lp-actions:40px;--lp-recent:30px;--lp-chip:84px;--lp-gap:6px}
html,body,.app{width:100vw;height:100dvh;max-width:100vw;max-height:100dvh;overflow:hidden;touch-action:manipulation}
body{position:fixed;inset:0}
.machine{
  width:100vw;
  max-width:470px;
  height:100dvh;
  overflow:hidden !important;
  padding:6px max(8px,var(--safe-right)) calc(var(--lp-chip) + var(--safe-bottom) + 4px) max(8px,var(--safe-left));
  display:grid;
  grid-template-rows:var(--lp-top) var(--lp-status) var(--lp-actions) var(--lp-recent) minmax(0,1fr);
  gap:var(--lp-gap);
}
.topbar{height:var(--lp-top);padding:0;grid-row:1;align-self:stretch;display:grid;grid-template-columns:minmax(0,1fr) auto;align-items:center}
.real-balance{height:42px;padding:6px 10px;border-radius:14px}
.real-balance span,.real-title small{font-size:8px;letter-spacing:.11em}
.real-balance strong{font-size:19px}
.real-title{font-size:15px;line-height:1.05}
.live-strip{grid-row:2;margin:0;display:flex;align-items:center;justify-content:center;gap:10px;height:var(--lp-status)}
.live-card{height:100%;padding:0;border:0;background:transparent;box-shadow:none;border-radius:0;display:flex;align-items:center;gap:4px;min-width:0}
.live-card:before{display:none}
.live-card span{font-size:9px;letter-spacing:.1em;line-height:1;color:rgba(255,232,178,.68)}
.live-card strong{font-size:17px;margin:0;line-height:1;color:#fff4cd}
.live-card.wide{display:flex;flex-direction:row;gap:6px}
.live-card.wide strong{font-size:12px}
.live-card small{font-size:9px;line-height:1;display:inline-flex;align-items:center;justify-content:center;gap:4px}
.live-card small svg{width:11px;height:11px;fill:currentColor;flex:0 0 11px}
.live-card.timer-hidden{display:none}
.room-actions{grid-row:3;margin:0;display:grid;grid-template-columns:repeat(6,1fr);gap:5px;height:var(--lp-actions)}
.tool-button{min-height:0;height:100%;border-radius:13px;display:grid;place-items:center;padding:0}
.tool-button b:not(.tool-count),.tool-button span:not(.tool-icon):not(.sr-only){display:none}
.tool-icon{position:relative;display:block;width:22px;height:22px;color:#fff0bd}
.icon-history:before{content:"";position:absolute;left:4px;top:3px;width:14px;height:16px;border:2px solid currentColor;border-radius:3px;box-shadow:inset 0 4px 0 rgba(255,240,189,.22)}
.icon-history:after{content:"";position:absolute;left:8px;top:8px;width:8px;height:2px;background:currentColor;box-shadow:0 5px 0 currentColor}
.icon-winners:before{content:"";position:absolute;left:3px;top:5px;width:16px;height:11px;border:2px solid currentColor;border-top:0;border-radius:0 0 8px 8px}
.icon-winners:after{content:"";position:absolute;left:7px;top:2px;width:8px;height:8px;border-radius:50%;background:currentColor;box-shadow:0 15px 0 -2px currentColor}
.icon-users:before{content:"";position:absolute;left:7px;top:3px;width:8px;height:8px;border-radius:50%;background:currentColor;box-shadow:-7px 4px 0 -2px currentColor,7px 4px 0 -2px currentColor}
.icon-users:after{content:"";position:absolute;left:4px;top:13px;width:14px;height:7px;border-radius:9px 9px 3px 3px;background:currentColor}
.icon-info:before{content:"i";position:absolute;inset:1px;border:2px solid currentColor;border-radius:50%;display:grid;place-items:center;font-family:Georgia,serif;font-weight:900;font-size:15px;line-height:1}
.icon-music:before{content:"";position:absolute;left:6px;top:4px;width:10px;height:13px;border-left:3px solid currentColor;border-top:3px solid currentColor;transform:skewY(-10deg)}
.icon-music:after{content:"";position:absolute;left:2px;top:14px;width:7px;height:7px;border-radius:50%;background:currentColor;box-shadow:11px -2px 0 -1px currentColor}
.icon-settings:before{content:"";position:absolute;left:4px;top:4px;width:14px;height:14px;border:3px dotted currentColor;border-radius:50%}
.icon-settings:after{content:"";position:absolute;left:9px;top:9px;width:4px;height:4px;border-radius:50%;background:currentColor}
.tool-count{position:absolute;right:4px;top:3px;min-width:15px;height:15px;padding:0 3px;border-radius:999px;background:#ffd86a;color:#190511;font-size:10px;line-height:15px;font-weight:900}
.recent-strip{grid-row:4;margin:0;height:var(--lp-recent);padding:4px 7px;border-radius:13px;gap:6px}
.recent-label,.active-users-pill{font-size:8px;letter-spacing:.08em}
.active-users-pill{padding:4px 6px}
.recent-track{gap:4px}
.recent-pill{width:22px;height:22px;flex-basis:22px}
.recent-pill img{width:18px;height:18px}
.wheel-section{grid-row:5;min-height:0;margin:0;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px}
.result-banner{display:none !important}
.wheel-countdown{width:58px;height:58px;margin:-1px auto 5px}
.wheel-countdown span{font-size:8px}
.wheel-countdown strong{font-size:25px}
.wheel-shell{width:min(73vw, calc(100dvh - 442px), 315px);min-width:190px;align-self:center}
.selector-row{margin:0;gap:6px;align-self:end}
.selector-card{min-height:100px;padding:7px 5px;border-radius:16px}
.selector-card:hover,.selector-card.selected{transform:none}
.selector-icon{width:32px;height:32px;margin-bottom:4px}
.selector-name{font-size:12px;line-height:1.05}
.selector-multi{font-size:10px;line-height:1.1}
.selector-stats{gap:4px;margin-top:6px}
.selector-stats span{padding:4px 2px;border-radius:8px;font-size:7px;letter-spacing:.05em}
.selector-stats b.selector-pool,.selector-stats b.selector-mine,.selector-stats b{font-size:clamp(10px,3vw,13px);letter-spacing:0}
.chips{height:var(--lp-chip) !important;width:min(calc(100vw - 14px),450px) !important;bottom:calc(var(--safe-bottom) + 4px) !important;padding:7px !important;gap:6px !important;border-radius:20px !important}
.chip{min-height:64px;border-radius:16px}
.chip-asset{width:60px;height:60px}
.history-modal{padding:10px}
.history-card{width:min(94vw,460px);max-height:86dvh;padding:14px;border-radius:22px}
.history-tabs{grid-template-columns:repeat(3,1fr);gap:6px}
.history-tab{padding:8px 4px;font-size:9px;border-radius:11px}
@media (max-width:380px),(max-height:760px){
  :root{--lp-top:43px;--lp-status:24px;--lp-actions:36px;--lp-recent:28px;--lp-chip:72px;--lp-gap:5px}
  .real-balance{height:38px}
  .real-balance strong{font-size:17px}
  .real-title{font-size:13px}
  .wheel-countdown{width:52px;height:52px;margin-bottom:4px}
  .wheel-countdown strong{font-size:23px}
  .wheel-shell{width:min(70vw, calc(100dvh - 390px), 272px);min-width:170px}
  .selector-card{min-height:88px;padding:6px 4px}
  .selector-icon{width:26px;height:26px}
  .selector-name{font-size:10px}
  .selector-stats span{font-size:6.5px}
  .chip{min-height:55px}
  .chip-asset{width:52px;height:52px}
}
  .selector-multi,
  .selector-pool,
  .selector-mine,
  .total-value,
  .total-meta strong,
  .panel-copy strong,
  .casino-chip-label {
    font-family: Inter, "Segoe UI", Arial, sans-serif !important;
    font-variant-numeric: tabular-nums;
    letter-spacing: 0 !important;
    text-transform: none;
  }
  .selector-multi {
    font-size: clamp(18px, 4.8vw, 28px) !important;
    font-weight: 900;
    line-height: 1;
  }
  </style>
  @include('game_final.partials.admin_visual_theme_styles')
  @include('game_final.partials.mobile_fit_styles')
  <style id="codex-lucky7-pro-450-postfix">
    @media (max-height:450px){
      :root{
        --lp-chip:50px;
        --lp-gap:4px;
      }

      .machine{
        grid-template-rows:var(--lp-top) var(--lp-status) var(--lp-actions) minmax(0,1fr) !important;
        gap:var(--lp-gap) !important;
        padding-bottom:calc(var(--lp-chip) + var(--safe-bottom) + 2px) !important;
      }

      .recent-strip{
        display:none !important;
      }

      .wheel-section{
        grid-row:4 !important;
        padding:2px 4px !important;
        gap:4px !important;
        justify-content:start !important;
      }

      .wheel-countdown{
        width:46px !important;
        height:46px !important;
        margin:-2px auto 2px !important;
      }

      .wheel-countdown span{
        font-size:7px !important;
      }

      .wheel-countdown strong{
        font-size:20px !important;
      }

      .wheel-shell{
        width:132px !important;
        min-width:132px !important;
      }

      .selector-row{
        width:100% !important;
        grid-template-columns:repeat(3,minmax(0,1fr)) !important;
        gap:4px !important;
        align-self:stretch !important;
        margin-top:0 !important;
      }

      .selector-card{
        min-height:64px !important;
        height:64px !important;
        padding:3px 2px !important;
        border-radius:12px !important;
      }

      .selector-icon{
        width:18px !important;
        height:18px !important;
        margin-bottom:2px !important;
      }

      .selector-name{
        font-size:8px !important;
      }

      .selector-multi{
        font-size:13px !important;
      }

      .selector-stats{
        gap:2px !important;
        margin-top:2px !important;
      }

      .selector-stats span{
        padding:2px 1px !important;
        border-radius:6px !important;
        font-size:5.5px !important;
      }

      .selector-stats b.selector-pool,
      .selector-stats b.selector-mine,
      .selector-stats b{
        font-size:8px !important;
      }

      .chips{
        height:calc(var(--lp-chip) + var(--safe-bottom)) !important;
        padding:4px 8px max(4px,var(--safe-bottom)) !important;
        gap:2px !important;
        align-items:end !important;
      }

      .chip{
        width:100% !important;
        min-height:44px !important;
        display:flex !important;
        align-items:flex-end !important;
        justify-content:center !important;
        overflow:visible !important;
      }

      .chip-asset,
      .casino-chip-face{
        width:44px !important;
        height:44px !important;
      }
    }
  </style>
  <style id="codex-lucky7-pro-mobile-width-postfix">
    @media (max-width:520px) and (min-height:451px){
      .wheel-section{
        align-items:stretch !important;
      }

      .wheel-shell{
        align-self:center !important;
      }

      .selector-row{
        width:100% !important;
        max-width:100% !important;
        min-width:0 !important;
        grid-template-columns:repeat(3,minmax(0,1fr)) !important;
        align-self:stretch !important;
        justify-self:stretch !important;
        margin:0 !important;
        gap:6px !important;
      }

      .selector-card{
        width:100% !important;
        min-width:0 !important;
      }
    }

    #bdgf-protected-badge{
      transform:translateX(-50%) !important;
    }
  </style>
</head>
<body class="gf-popup-{{ $gameTheme['popup_theme'] ?? 'popup_01' }} gf-item-{{ $gameTheme['item_theme'] ?? 'default' }}" style="--admin-primary:{{ $gameTheme['primary_color'] ?? '#0f050d' }};--admin-accent:{{ $gameTheme['accent_color'] ?? '#ffd35c' }}">
<div class="app">
  <div class="machine">
    <header class="topbar">
      <div class="real-balance">
        <span>Balance</span>
        <strong id="balance">--</strong>
      </div>
      <div class="real-title">
        Lucky 7 Pro
        <small>Live 3 Board Wheel</small>
      </div>
      <span id="jackpotValue" style="display:none">0</span>
    </header>

    <div class="title-wrap">
      <img src="{{ $assets['title'] }}" alt="Lucky 777 Pro" />
    </div>

    <div class="side-buttons" aria-hidden="true">
      <div class="side-column left">
        <button class="side-button" type="button"><img src="{{ $assets['ranking_button'] }}" alt="Ranking" /></button>
        <button class="side-button" type="button"><img src="{{ $assets['daily_bonus_button'] }}" alt="Daily Bonus" /></button>
      </div>
      <div class="side-column right">
        <button class="side-button" type="button"><img src="{{ $assets['mega_chest_button'] }}" alt="Mega Chest" /></button>
        <button class="side-button" type="button"><img src="{{ $assets['lucky_spin_button'] }}" alt="Lucky Spin" /></button>
      </div>
    </div>

    <div class="live-strip">
      <div class="live-card">
        <span>Round</span>
        <strong id="round">---</strong>
      </div>
      <div class="live-card wide">
        <span id="phase">SYNCING</span>
        <small aria-label="Network"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 18.5a2.2 2.2 0 1 0 0 .1Zm-5.9-4.4 1.8 1.8a5.8 5.8 0 0 1 8.2 0l1.8-1.8a8.4 8.4 0 0 0-11.8 0Zm-3.6-3.6 1.8 1.8a10.9 10.9 0 0 1 15.4 0l1.8-1.8a13.4 13.4 0 0 0-19 0Z"/></svg><b id="networkMs">sync</b></small>
      </div>
    </div>

    <div class="room-actions" aria-label="Room tools">
      <button class="tool-button" id="historyAction" type="button" data-panel="history" aria-label="History"><span class="tool-icon icon-history" aria-hidden="true"></span><span class="sr-only">History</span></button>
      <button class="tool-button" id="winnersAction" type="button" data-panel="winners" aria-label="Last 10 winners"><span class="tool-icon icon-winners" aria-hidden="true"></span><span class="sr-only">Last 10 winners</span></button>
      <button class="tool-button" id="usersAction" type="button" data-panel="users" aria-label="Active users"><span class="tool-icon icon-users" aria-hidden="true"></span><b id="activeUsersTop" class="tool-count">0</b><span class="sr-only">Active users</span></button>
      <button class="tool-button" id="infoAction" type="button" data-panel="info" aria-label="Game info"><span class="tool-icon icon-info" aria-hidden="true"></span><span class="sr-only">Game info</span></button>
      <button class="tool-button" id="musicAction" type="button" data-panel="music" aria-label="Music"><span class="tool-icon icon-music" aria-hidden="true"></span><b id="musicState" class="sr-only">Music</b><span class="sr-only">Music</span></button>
      <button class="tool-button" id="settingsAction" type="button" data-panel="settings" aria-label="Settings"><span class="tool-icon icon-settings" aria-hidden="true"></span><span class="sr-only">Settings</span></button>
    </div>

    <div class="recent-strip" aria-label="Last 10 winner boards">
      <div class="recent-label">Last 10</div>
      <div class="recent-track" id="recentTrack"></div>
      <div class="active-users-pill">Active <b id="activeUsersCount">0</b></div>
    </div>

    <section class="wheel-section" id="resultStage">
      <div class="wheel-countdown clock-card timer-hidden">
        <span>Time</span>
        <strong id="time">--</strong>
      </div>
      <div class="wheel-shell" id="wheelShell">
        <div class="wheel-art live-three-wheel" id="resultWheel" role="img" aria-label="Lucky 7 Pro three board wheel">
          <img class="wheel-board-art" src="{{ $assets['wheel_board'] }}" alt="" aria-hidden="true" />
        </div>
        <img class="wheel-winner-mark" src="{{ $assets['winner_mark'] }}" alt="" aria-hidden="true" />
        <img class="wheel-pointer" src="{{ $assets['pointer'] }}" alt="" aria-hidden="true" />
      </div>

      <div class="result-banner">
        <div class="result-icon-wrap">
          <img id="resultIcon" src="{{ $interactiveBoards[$defaultBoardKey]['result_icon'] }}" alt="Result icon" />
        </div>
        <div>
          <div class="result-copy-title" id="resultTitle">Wheel armed</div>
          <div class="result-copy-text" id="resultText">Choose your chip, then tap Red 7, Crown, or Clover before betting closes.</div>
          <div class="result-copy-meta" id="resultMeta">Awaiting reveal</div>
        </div>
      </div>

      <div class="selector-row">
        @foreach ($interactiveBoards as $boardKey => $boardProfile)
        <button class="selector-card" type="button" data-board="{{ $boardKey }}">
          <img class="selector-icon" src="{{ $boardProfile['selector_icon'] }}" alt="" aria-hidden="true" />
          <div class="selector-name">{{ $boardProfile['name'] }}</div>
          <div class="selector-multi">{{ $boardProfile['multiplier'] }}</div>
          <div class="selector-stats">
            <span>Total <b class="selector-pool" id="pool-{{ $boardKey }}">0</b></span>
            <span>You <b class="selector-mine" id="mine-{{ $boardKey }}">0</b></span>
          </div>
        </button>
        @endforeach
      </div>
    </section>

    <section class="paytable-shell">
      <img class="paytable-base" src="{{ $assets['payout_table'] }}" alt="" aria-hidden="true" />
      <div class="paytable-grid">
        @foreach ($payoutTiles as $payoutTile)
        <img src="{{ $payoutTile['asset'] }}" alt="{{ $payoutTile['name'] }}" />
        @endforeach
      </div>
    </section>

    <div class="legend-strip" aria-label="Lucky 777 Pro symbols">
      @foreach ($legendSymbols as $legendSymbol)
      <div class="legend-item">
        <img class="legend-clean" src="{{ $legendSymbol['clean'] }}" alt="" aria-hidden="true" />
        <img class="legend-gloss" src="{{ $legendSymbol['gloss'] }}" alt="" aria-hidden="true" />
        <span>{{ $legendSymbol['name'] }}</span>
      </div>
      @endforeach
    </div>

    <section class="control-area">
      <div class="control-deck">
        <img class="control-base" src="{{ $assets['bet_panel'] }}" alt="" aria-hidden="true" />
        <div class="control-row">
          <button class="control-button" id="infoButton" type="button" aria-label="Game info">
            <img src="{{ $assets['info_button'] }}" alt="" aria-hidden="true" />
          </button>
          <button class="control-button" id="chipStepDown" type="button" aria-label="Lower chip">
            <img src="{{ $assets['minus_button'] }}" alt="" aria-hidden="true" />
          </button>
          <div class="control-display">
            <img src="{{ $assets['total_bet_panel'] }}" alt="Total bet display" />
            <div class="total-mask"></div>
            <div class="control-copy">
              <span>Live stake</span>
              <strong id="betDisplay">{{ number_format($defaultChipValue) }}</strong>
              <small id="activeBoardName">Red 7 lane armed</small>
            </div>
          </div>
          <button class="control-button" id="chipStepUp" type="button" aria-label="Raise chip">
            <img src="{{ $assets['plus_button'] }}" alt="" aria-hidden="true" />
          </button>
          <button class="control-button" id="chipMax" type="button" aria-label="Max bet">
            <img src="{{ $assets['max_bet_button'] }}" alt="" aria-hidden="true" />
          </button>
        </div>
      </div>

      <div class="chips">
        @foreach ($chipButtons as $chipButton)
        <button class="chip tone-{{ $chipButton['tone'] }}{{ $chipButton['value'] === $defaultChipValue ? ' selected' : '' }}" type="button" data-value="{{ $chipButton['value'] }}" data-label="{{ $chipButton['display_label'] }}" aria-label="{{ $chipButton['display_label'] }} chip">
          <img class="chip-asset" src="{{ $chipButton['asset'] }}" alt="" aria-hidden="true" />
        </button>
        @endforeach
      </div>

      <div class="stake-meta">
        <div class="stake-pill">
          <span>Chip value</span>
          <strong id="selectedChipLabel">1K chip</strong>
          <small>Casino chip value selected</small>
        </div>
        <div class="stake-pill">
          <span>Status</span>
          <strong id="spinHint">Tap a lane to place on Red 7</strong>
          <small>Live room state is synced below</small>
        </div>
      </div>

      <button class="spin-button" id="spinButton" type="button" aria-label="Spin">
        <img src="{{ $assets['spin_button'] }}" alt="Spin" />
      </button>
    </section>

    <div class="history-modal" id="historyModal">
      <div class="history-card">
        <div class="history-head">
          <div>
            <h3 id="modalTitle">Room History</h3>
            <p id="modalSub">Last 15 winning boards and your last 15 bet tickets.</p>
          </div>
          <button class="history-close" id="historyClose" type="button">Close</button>
        </div>
        <div class="history-tabs" aria-label="Room panel tabs">
          <button class="history-tab active" type="button" data-panel="history">History</button>
          <button class="history-tab" type="button" data-panel="winners">Last 10</button>
          <button class="history-tab" type="button" data-panel="users">Users</button>
          <button class="history-tab" type="button" data-panel="info">Info</button>
          <button class="history-tab" type="button" data-panel="music">Music</button>
          <button class="history-tab" type="button" data-panel="settings">Setting</button>
        </div>
        <div class="history-stack" id="historyContent"></div>
      </div>
    </div>

    <div class="toast" id="toast"><b id="toastTitle">{{ $displayTitle }}</b><span id="toastText">Live room booting</span></div>
  </div>
  <div class="coin-layer" id="coinLayer" aria-hidden="true"></div>
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
    maxDistinctBoards: @json((int) ($gameRules['max_distinct_boards_per_user'] ?? 3)),
    boardCount: @json((int) ($gameRules['board_count'] ?? count((array) $boardClientProfiles)))
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
  const boardProfiles = @json($boardClientProfiles);
  const historyBoardKeys = Object.keys(boardProfiles);
  const chipProfiles = @json($chipClientProfiles);
  const defaultBoardKey = @json($defaultBoardKey);
  const defaultChipValue = @json($defaultChipValue);
  const hasLiveSession = @json((bool) ($sessionToken ?? null));
  const refs = {
    balance: document.getElementById('balance'),
    jackpotValue: document.getElementById('jackpotValue'),
    round: document.getElementById('round'),
    phase: document.getElementById('phase'),
    networkMs: document.getElementById('networkMs'),
    time: document.getElementById('time'),
    wheelShell: document.getElementById('wheelShell'),
    resultStage: document.getElementById('resultStage'),
    resultWheel: document.getElementById('resultWheel'),
    resultIcon: document.getElementById('resultIcon'),
    resultTitle: document.getElementById('resultTitle'),
    resultText: document.getElementById('resultText'),
    resultMeta: document.getElementById('resultMeta'),
    betDisplay: document.getElementById('betDisplay'),
    activeBoardName: document.getElementById('activeBoardName'),
    selectedChipLabel: document.getElementById('selectedChipLabel'),
    activeUsersTop: document.getElementById('activeUsersTop'),
    activeUsersCount: document.getElementById('activeUsersCount'),
    musicState: document.getElementById('musicState'),
    recentTrack: document.getElementById('recentTrack'),
    coinLayer: document.getElementById('coinLayer'),
    spinButton: document.getElementById('spinButton'),
    spinHint: document.getElementById('spinHint'),
    chipStepDown: document.getElementById('chipStepDown'),
    chipStepUp: document.getElementById('chipStepUp'),
    chipMax: document.getElementById('chipMax'),
    infoButton: document.getElementById('infoButton'),
    panelActions: Array.from(document.querySelectorAll('[data-panel].tool-button')),
    panelTabs: Array.from(document.querySelectorAll('.history-tab')),
    modalTitle: document.getElementById('modalTitle'),
    modalSub: document.getElementById('modalSub'),
    historyModal: document.getElementById('historyModal'),
    historyContent: document.getElementById('historyContent'),
    historyClose: document.getElementById('historyClose'),
    chips: Array.from(document.querySelectorAll('.chip')),
    toast: document.getElementById('toast'),
    toastTitle: document.getElementById('toastTitle'),
    toastText: document.getElementById('toastText'),
    boardNodes: {},
    pools: {},
    mines: {},
  };
  Object.keys(boardProfiles).forEach((key) => {
    refs.boardNodes[key] = Array.from(document.querySelectorAll(`[data-board="${key}"]`));
    refs.pools[key] = document.getElementById(`pool-${key}`);
    refs.mines[key] = document.getElementById(`mine-${key}`);
  });

  const chipLabelMap = chipProfiles.reduce((carry, chipProfile) => {
    carry[Number(chipProfile.value)] = chipProfile.display_label;
    return carry;
  }, {});
  let selectedChip = defaultChipValue;
  let activeBoardKey = boardProfiles[defaultBoardKey] ? defaultBoardKey : Object.keys(boardProfiles)[0];
  let authoritativeRoundNo = null;
  let lastStatePayload = null;
  let lastWinnerToastKey = '';
  let lastPhasePopupKey = '';
  let lastResultVisualKey = '';
  let resultEffectTimer = null;
  let winnerDanceTimer = null;
  let refreshInFlight = false;
  let requestCounter = 0;
  let lastNetworkMs = 0;
  let serverClockOffsetSec = 0;
  let serverClockKey = '';
  let wheelSpinRotation = 0;
  let refreshTimer = null;
  let heartbeatTimer = null;
  let timerTick = null;
  let toastTimer = null;
  let disposed = false;
  let boardHistoryRows = [];
  let userHistoryRows = [];
  let activePlayers = [];
  let activeUsers = 0;
  let roomPanel = 'history';
  let animationEnabled = localStorage.getItem('lucky7ProAnimation') !== 'off';
  let soundEnabled = localStorage.getItem('lucky7ProSound') === 'on';
  let historySyncInFlight = false;
  let lastHistorySyncRound = '';
  const pendingBoards = new Map();
  function markPendingBoard(boardKey, delta) {
    const nextCount = Math.max(0, (pendingBoards.get(boardKey) || 0) + delta);
    if (nextCount > 0) pendingBoards.set(boardKey, nextCount);
    else pendingBoards.delete(boardKey);
  }
  const roomBoardCount = Math.max(1, Number(window.BD_GAME_BOOTSTRAP.rules && window.BD_GAME_BOOTSTRAP.rules.boardCount || Object.keys(boardProfiles).length || 1));

  function number(value) {
    return Number(value || 0).toLocaleString('en-US');
  }

  function boardAmount(value) {
    const amount = Number(value || 0);
    if (amount >= 1000000) return `${(amount / 1000000).toFixed(amount % 1000000 === 0 ? 0 : 1)}M`;
    if (amount >= 100000) return `${Math.round(amount / 1000)}K`;
    return number(amount);
  }

  function balanceNumber(value) {
    return String(Math.max(0, Math.floor(Number(value || 0))));
  }

  function chipLabel(value) {
    return chipLabelMap[Number(value)] || number(value);
  }

  function boardName(key) {
    return boardProfiles[key] ? boardProfiles[key].name : key;
  }

  function escapeHtml(value) {
    return String(value == null ? '' : value)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#39;');
  }

  function historyBoardCell(boardKey) {
    const profile = boardProfiles[boardKey] || null;
    const title = boardName(boardKey || '-');
    return `<div class="history-board">${historyBoardToken(boardKey)}<span>${escapeHtml(title)}</span></div>`;
  }

  function historyBoardToken(boardKey) {
    const profile = boardProfiles[boardKey] || null;
    const title = boardName(boardKey || '-');
    const icon = profile ? `<img src="${escapeHtml(profile.result_icon)}" alt="${escapeHtml(title)}" />` : escapeHtml(String(title || '?').slice(0, 2).toUpperCase());
    return `<span class="history-board-token" title="${escapeHtml(title)}" aria-label="${escapeHtml(title)}">${icon}</span>`;
  }

  function historyBoardHeaderCells() {
    return historyBoardKeys.map((boardKey) => `<th class="history-board-label">${escapeHtml(boardName(boardKey))}</th>`).join('');
  }

  function historyWinnerKeyFromItem(item) {
    return String(item && (item.winner_board_key || item.winner_board || item.board_key || item.resultKey || item.result) || item || '');
  }

  function historyWinnerBoardCells(item) {
    const winnerKey = historyWinnerKeyFromItem(item);
    return historyBoardKeys.map((boardKey) => {
      const isWinner = boardKey === winnerKey;
      const title = `${boardName(boardKey)}${isWinner ? ' winner' : ''}`;
      return `<td class="history-board-token-cell${isWinner ? ' is-winner' : ''}" title="${escapeHtml(title)}">${isWinner ? historyBoardToken(boardKey) : ''}</td>`;
    }).join('');
  }

  function historyRoundLabel(value) {
    if (value && typeof value === 'object') value = value.round_short || value.trace_short || value.round_no || value.round_id || value.trace_id || '-';
    const raw = String(value || '-');
    const tail = raw.split('_').pop() || raw;
    if (/^\d{7,}$/.test(tail)) return tail.slice(-6);
    return raw.length > 10 ? raw.slice(-10) : raw;
  }

  function outcomeBadge(item) {
    const outcome = String(item && (item.user_outcome || item.status) || 'no_bid').toLowerCase();
    const cls = outcome === 'won' ? 'win' : (outcome === 'lost' ? 'loss' : (outcome === 'punishment' ? 'punishment' : 'pending'));
    const label = outcome === 'won' ? `WIN +${number(item && (item.user_win_amount || item.win_amount) || 0)}` : (outcome === 'lost' ? 'LOSS' : (outcome === 'punishment' ? `PUNISH -${number(Math.abs(Number(item && (item.result_amount || item.amount) || 0)))}` : 'NO BID'));
    return `<span class="history-status ${cls}">${escapeHtml(label)}</span>`;
  }

  function winnerCard(item, index) {
    const boardKey = item && item.winner_board_key || '';
    const profile = boardProfiles[boardKey] || null;
    const title = boardName(boardKey || '-');
    const icon = profile ? `<img src="${profile.result_icon}" alt="${escapeHtml(title)}" />` : '';
    return `
      <div class="winner-card">
        ${icon}
        <div><b>${escapeHtml(title)}</b><span>Round ${escapeHtml(historyRoundLabel(item))}</span></div>
        <span class="history-status win">#${index + 1}</span>
      </div>
    `;
  }

  function renderRecentTrack() {
    if (!refs.recentTrack) return;
    const rows = boardHistoryRows.slice(0, 10);
    refs.recentTrack.innerHTML = rows.length
      ? rows.map((item) => {
        const key = item && item.winner_board_key || '';
        const profile = boardProfiles[key] || null;
        const title = boardName(key || '-');
        return `<span class="recent-pill" title="${escapeHtml(title)}">${profile ? `<img src="${profile.result_icon}" alt="${escapeHtml(title)}" />` : escapeHtml(title.slice(0, 1))}</span>`;
      }).join('')
      : '<span class="history-section-sub">Waiting</span>';
  }

  function updateActiveUsers(payload) {
    const players = payload && payload.board_players && typeof payload.board_players === 'object'
      ? Object.values(payload.board_players).reduce((sum, value) => sum + Number(value || 0), 0)
      : 0;
    activePlayers = Array.isArray(payload && payload.active_players) ? payload.active_players : activePlayers;
    activeUsers = Math.max(players, Number(payload && payload.active_users || 0), activePlayers.length, 0);
    if (refs.activeUsersTop) refs.activeUsersTop.textContent = String(activeUsers);
    if (refs.activeUsersCount) refs.activeUsersCount.textContent = String(activeUsers);
  }

  function settingsToggle(label, text, enabled, key) {
    return `
      <button class="settings-card" type="button" data-setting="${key}">
        <div><b>${escapeHtml(label)}</b><span>${escapeHtml(text)}</span></div>
        <span class="settings-toggle ${enabled ? 'on' : ''}" aria-hidden="true"></span>
      </button>
    `;
  }

  function infoMarkup() {
    const limit = maxDistinctBoards(lastStatePayload);
    return `
      <div class="info-grid">
        <div class="info-card"><div><b>How To Play</b><span>Choose chip, then tap Red 7, Crown, or Clover while BET OPEN is active.</span></div></div>
        <div class="info-card"><div><b>Board Limit</b><span>You can use ${limit} distinct ${limit === 1 ? 'board' : 'boards'} in one round.</span></div></div>
        <div class="info-card"><div><b>Payout</b><span>Red 7 pays {{ $interactiveBoards['slot']['multiplier'] }}. Crown pays {{ $interactiveBoards['melon']['multiplier'] }}. Clover pays {{ $interactiveBoards['plum']['multiplier'] }}.</span></div></div>
        <div class="info-card"><div><b>Timing</b><span>After betting closes, the wheel locks, reveals the result, then payout syncs automatically.</span></div></div>
      </div>
    `;
  }

  function usersMarkup() {
    if (!activePlayers.length) {
      refs.roomContent.innerHTML = '<div class="history-empty">No active players yet</div>';
      return;
    }

    const rows = activePlayers.map((player) => {
      const name = player.name || player.username || player.display_name || 'Player';
      const image = player.image || player.avatar || player.profile_image || player.photo || '';
      const avatar = image
        ? `<img src="${escapeHtml(image)}" alt="${escapeHtml(name)}">`
        : escapeHtml(player.initial || String(name).charAt(0) || 'P');
      return `
        <div class="active-card user-profile-card">
          <div class="profile-avatar">${avatar}</div>
          <b>${escapeHtml(name)}</b>
          <span>${player.is_me ? 'YOU' : `Win ${number(player.game_win_amount || 0)}`}</span>
        </div>
      `;
    }).join('');
    return `
      <div class="active-grid users-card-grid">
        ${rows}
      </div>
    `;
  }

  function settingsMarkup() {
    return `
      <div class="settings-grid">
        ${settingsToggle('Animation', 'Wheel spin and winner glow effects.', animationEnabled, 'animation')}
        ${settingsToggle('Music', 'Premium room music control.', soundEnabled, 'sound')}
        <div class="info-card"><div><b>Session</b><span>${hasLiveSession ? 'Connected with live session token.' : 'No live session token found.'}</span></div></div>
      </div>
    `;
  }

  function musicMarkup() {
    return `
      <div class="settings-grid">
        ${settingsToggle('Room Music', soundEnabled ? 'Music is enabled for this room.' : 'Music is muted for this room.', soundEnabled, 'sound')}
        <div class="info-card"><div><b>Game Sound</b><span>Winner and coin animations respect this music setting.</span></div></div>
      </div>
    `;
  }

  function updateMusicUi() {
    if (!refs.musicState) return;
    refs.musicState.textContent = soundEnabled ? 'Music On' : 'Music';
    const musicButton = document.getElementById('musicAction');
    if (musicButton) {
      musicButton.classList.toggle('active', soundEnabled);
      musicButton.setAttribute('aria-label', soundEnabled ? 'Music on' : 'Music off');
    }
  }

  function setRoomPanel(panel) {
    roomPanel = panel || 'history';
    refs.panelActions.forEach((button) => button.classList.toggle('active', button.dataset.panel === roomPanel));
    refs.panelTabs.forEach((button) => button.classList.toggle('active', button.dataset.panel === roomPanel));
    const titles = {
      history: ['Room History', 'Winning board history and your recent bet tickets.'],
      winners: ['Last 10 Winners', 'Recent winning boards from settled rounds.'],
      users: ['Active Users', 'Live room participation by board.'],
      info: ['Game Info', 'Rules, payout, and timing for Lucky 7 Pro.'],
      music: ['Music', 'Room sound and coin-effect controls.'],
      settings: ['Settings', 'Local room display settings.']
    };
    if (refs.modalTitle) refs.modalTitle.textContent = (titles[roomPanel] || titles.history)[0];
    if (refs.modalSub) refs.modalSub.textContent = (titles[roomPanel] || titles.history)[1];
    renderHistoryPopup();
  }

  function renderHistoryPopup() {
    if (!refs.historyContent) return;
    if (roomPanel === 'winners') {
      refs.historyContent.innerHTML = boardHistoryRows.length
        ? `<div class="winner-grid">${boardHistoryRows.slice(0, 10).map(winnerCard).join('')}</div>`
        : '<div class="history-empty">Waiting for live winners</div>';
      return;
    }
    if (roomPanel === 'users') {
      refs.historyContent.innerHTML = usersMarkup();
      return;
    }
    if (roomPanel === 'info') {
      refs.historyContent.innerHTML = infoMarkup();
      return;
    }
    if (roomPanel === 'music') {
      refs.historyContent.innerHTML = musicMarkup();
      return;
    }
    if (roomPanel === 'settings') {
      refs.historyContent.innerHTML = settingsMarkup();
      return;
    }
    const boardTable = boardHistoryRows.length ? `
      <div class="history-section">
        <div class="history-section-head">
          <div class="history-section-title">Win Board History</div>
          <div class="history-section-sub">Last 15 settled rounds</div>
        </div>
        <div class="history-table-wrap">
          <table class="history-table history-board-matrix">
            <thead><tr><th>Round</th>${historyBoardHeaderCells()}<th>You</th></tr></thead>
            <tbody>${boardHistoryRows.map((item) => `
              <tr>
                <td class="history-trace">${escapeHtml(historyRoundLabel(item))}</td>
                ${historyWinnerBoardCells(item)}
                <td>${outcomeBadge(item)}</td>
              </tr>
            `).join('')}</tbody>
          </table>
        </div>
      </div>
    ` : '<div class="history-empty">Waiting for live rounds</div>';
    const userTable = userHistoryRows.length ? `
      <div class="history-section">
        <div class="history-section-head">
          <div class="history-section-title">My Bet History</div>
          <div class="history-section-sub">Last 15 bet tickets</div>
        </div>
        <div class="history-table-wrap">
          <table class="history-table">
            <thead><tr><th>Trace</th><th>Round</th><th>Board</th><th>Bid</th><th>Result</th></tr></thead>
            <tbody>${userHistoryRows.map((item) => {
              const status = String(item && item.status || 'pending').toLowerCase();
              const statusClass = status === 'won' ? 'win' : (status === 'lost' ? 'loss' : (status === 'punishment' ? 'punishment' : 'pending'));
              const resultText = status === 'won'
                ? `WIN +${number(item && item.win_amount || 0)}`
                : (status === 'lost' ? `LOSS -${number(item && item.amount || 0)}` : (status === 'punishment' ? `PUNISH -${number(Math.abs(Number(item && (item.result_amount || item.amount) || 0)))}` : 'PENDING'));
              return `
                <tr>
                  <td class="history-trace">${escapeHtml(historyRoundLabel(item && (item.trace_short || item.trace_id) || '-'))}</td>
                  <td class="history-trace">${escapeHtml(historyRoundLabel(item))}</td>
                  <td>${historyBoardCell(item && (item.board_key || item.frontend_board_key) || '')}</td>
                  <td>${escapeHtml(number(item && item.amount || 0))}</td>
                  <td><span class="history-status ${statusClass}">${escapeHtml(resultText)}</span></td>
                </tr>
              `;
            }).join('')}</tbody>
          </table>
        </div>
      </div>
    ` : '<div class="history-empty">Place a bet to build your history</div>';
    refs.historyContent.innerHTML = `${boardTable}${userTable}`;
  }

  function openHistoryModal(panel = 'history') {
    setRoomPanel(panel);
    renderHistoryPopup();
    if (refs.historyModal) refs.historyModal.classList.add('is-open');
    refreshHistoryTables(true);
  }

  function closeHistoryModal() {
    if (refs.historyModal) refs.historyModal.classList.remove('is-open');
  }

  async function refreshHistoryTables(force = false) {
    if (!(window.BDGameFinal && window.BD_GAME_BOOTSTRAP && window.BD_GAME_BOOTSTRAP.gameCode === currentGameCode)) {
      renderHistoryPopup();
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
    } catch (error) {
      if (!boardHistoryRows.length && !userHistoryRows.length) {
        boardHistoryRows = [];
        userHistoryRows = [];
      }
    } finally {
      historySyncInFlight = false;
      renderRecentTrack();
      renderHistoryPopup();
    }
  }

  function maxDistinctBoards(payload) {
    const fromPayload = Number(payload && payload.rules && payload.rules.max_distinct_boards_per_user || 0);
    const fromBootstrap = Number(window.BD_GAME_BOOTSTRAP.rules && window.BD_GAME_BOOTSTRAP.rules.maxDistinctBoards || 0);
    return Math.max(1, Math.min(roomBoardCount, fromPayload || fromBootstrap || roomBoardCount));
  }

  function currentDistinctBoardCount(payload) {
    return Object.keys(boardProfiles).filter((key) => Number(payload && payload.my_bet_totals && payload.my_bet_totals[key] || 0) > 0).length;
  }

  function canUseBoard(payload, boardKey) {
    const currentTotal = Number(payload && payload.my_bet_totals && payload.my_bet_totals[boardKey] || 0);
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

  function phaseLabel(phase) {
    if (phase === 'betting') return 'BET OPEN';
    if (phase === 'locked') return 'LOCKED';
    if (phase === 'revealed') return 'RESULT';
    if (phase === 'settled') return 'PAYOUT';
    return hasLiveSession ? 'SYNCING' : 'LIVE ONLY';
  }

  function formatRoundLabel(roundNo) {
    if (!roundNo) return '---';
    const parts = String(roundNo).split('_');
    const value = parts.length ? parts[parts.length - 1] : '---';
    if (/^\d{7,}$/.test(value)) {
      return value.slice(-3).replace(/^0+/, '') || '0';
    }
    return value || '---';
  }

  function serverNow() {
    return (Date.now() / 1000) + serverClockOffsetSec;
  }

  function phaseEndAt(payload) {
    if (!payload) return null;
    if (payload.phase === 'betting') return payload.bet_close_at || null;
    if (payload.phase === 'locked') return payload.reveal_at || null;
    if (payload.phase === 'revealed') return payload.settle_at || null;
    if (payload.phase === 'settled') return payload.next_round_at || null;
    return null;
  }

  function currentWinner(payload) {
    return payload && (payload.winner_board || (payload.result && payload.result.winner_board)) || '';
  }

  function normalizeDeg(value) {
    return ((Number(value) % 360) + 360) % 360;
  }

  function setResultCopy(title, text, meta, iconKey) {
    refs.resultTitle.textContent = title;
    refs.resultText.textContent = text;
    refs.resultMeta.textContent = meta;
    if (boardProfiles[iconKey] && refs.resultIcon) {
      refs.resultIcon.src = boardProfiles[iconKey].result_icon;
      refs.resultIcon.alt = boardProfiles[iconKey].name;
    }
  }

  function winnerWheelRotation(winner) {
    const targets = { slot: 60, melon: 300, plum: 180 };
    const target = normalizeDeg(targets[winner] ?? 0);
    const current = normalizeDeg(wheelSpinRotation);
    const delta = normalizeDeg(target - current);
    return wheelSpinRotation + 1080 + delta;
  }

  function elementCenter(element) {
    if (!element) return { x: window.innerWidth / 2, y: window.innerHeight / 2 };
    const rect = element.getBoundingClientRect();
    return { x: rect.left + rect.width / 2, y: rect.top + rect.height / 2 };
  }

  function luckyFxBudget(key, fallback) {
    const api = window.BDGameFinal;
    const budget = api && typeof api.fxBudget === 'function' ? api.fxBudget() : null;
    if (budget && Number(budget[key]) > 0) return Number(budget[key]);
    const compact = window.innerHeight <= 520 || window.innerWidth <= 430 || (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);
    if (!compact) return fallback;
    const localBudget = { betCoins: 2, betSparks: 2, winCoins: 4, winParticles: 6 };
    return localBudget[key] || Math.min(fallback, 6);
  }

  function spawnCoinFlight(from, to, count = 10, burst = false) {
    if (!refs.coinLayer) return;
    count = Math.max(1, Math.min(count, luckyFxBudget(burst ? 'winParticles' : 'betCoins', count)));
    const start = elementCenter(from);
    const end = elementCenter(to);
    for (let i = 0; i < count; i += 1) {
      const coin = document.createElement('span');
      coin.className = burst ? 'winner-spark' : 'flying-coin';
      const jitter = burst ? 70 : 26;
      const x0 = start.x + ((Math.random() - .5) * jitter);
      const y0 = start.y + ((Math.random() - .5) * jitter);
      coin.style.setProperty('--x0', `${x0}px`);
      coin.style.setProperty('--y0', `${y0}px`);
      if (burst) {
        coin.style.setProperty('--dx', `${Math.round((Math.random() - .5) * 150)}`);
        coin.style.setProperty('--dy', `${Math.round((Math.random() - .5) * 120)}`);
      } else {
        coin.style.setProperty('--x1', `${end.x + ((Math.random() - .5) * 38)}px`);
        coin.style.setProperty('--y1', `${end.y + ((Math.random() - .5) * 30)}px`);
      }
      coin.style.setProperty('--delay', `${i * 38}ms`);
      coin.style.setProperty('--dur', `${burst ? 640 + (i * 18) : 760 + (i * 32)}ms`);
      refs.coinLayer.appendChild(coin);
      window.setTimeout(() => coin.remove(), 1500 + (i * 45));
    }
  }

  function chipNodeForValue(value) {
    return refs.chips.find((node) => Number(node.dataset.value || 0) === Number(value)) || refs.chips[0];
  }

  function boardTargetNode(boardKey) {
    return document.querySelector(`.selector-card[data-board="${boardKey}"]`) || document.querySelector(`.wheel-hotspot[data-board="${boardKey}"]`);
  }

  function danceWinnerBoard(winner) {
    document.querySelectorAll('.selector-card.winner-dance').forEach((node) => node.classList.remove('winner-dance'));
    const board = document.querySelector(`.selector-card[data-board="${winner}"]`);
    if (!board || !animationEnabled) return;
    void board.offsetWidth;
    board.classList.add('winner-dance');
    if (winnerDanceTimer) window.clearTimeout(winnerDanceTimer);
    winnerDanceTimer = window.setTimeout(() => board.classList.remove('winner-dance'), 2600);
  }

  function triggerWheelFx(winner) {
    if (!refs.wheelShell || !refs.resultWheel) return;
    wheelSpinRotation = winnerWheelRotation(winner);
    refs.wheelShell.classList.remove('show-winner');
    refs.wheelShell.dataset.winner = winner;
    if (animationEnabled) refs.resultWheel.style.transform = `rotate(${wheelSpinRotation}deg)`;
    refs.wheelShell.classList.remove('burst');
    if (resultEffectTimer) window.clearTimeout(resultEffectTimer);
    resultEffectTimer = window.setTimeout(() => {
      refs.wheelShell.classList.remove('burst');
      void refs.wheelShell.offsetWidth;
      if (animationEnabled) refs.wheelShell.classList.add('burst');
      refs.wheelShell.classList.add('show-winner');
      danceWinnerBoard(winner);
    }, animationEnabled ? 4450 : 0);
  }

  function setNetwork(status, label) {
    refs.networkMs.textContent = label;
    refs.networkMs.style.color = status === 'good' ? '#eff8ff' : status === 'warn' ? '#ffe7b0' : '#ffb7a5';
  }

  function updateBalance(value) {
    refs.balance.textContent = balanceNumber(value);
  }

  function updateJackpot(payload) {
    const totals = payload && payload.board_totals ? Object.values(payload.board_totals) : [];
    const poolTotal = totals.reduce((sum, value) => sum + Number(value || 0), 0);
    refs.jackpotValue.textContent = number(Math.max(777777000, poolTotal * 1000));
  }

  function updateRound(roundNo) {
    refs.round.textContent = formatRoundLabel(roundNo);
  }

  function updatePhase(phase) {
    refs.phase.textContent = phaseLabel(phase);
  }

  function updateTimer(payload) {
    const timeCard = refs.time ? refs.time.closest('.clock-card') : null;
    if (!payload) {
      if (timeCard) timeCard.classList.add('timer-hidden');
      refs.time.textContent = '--';
      return;
    }
    const clockKey = `${payload.round_no || 'na'}:${payload.phase || 'na'}`;
    if (typeof payload.server_time === 'number' && (clockKey !== serverClockKey || !serverClockKey)) {
      serverClockOffsetSec = payload.server_time - (Date.now() / 1000);
      serverClockKey = clockKey;
    }
    const endAt = phaseEndAt(payload);
    const left = endAt ? Math.max(0, Math.ceil(endAt - serverNow())) : 0;
    const showClock = payload.phase === 'betting' && left > 0;
    const totalBetSeconds = Number(payload.phase_durations && payload.phase_durations.betting || (roomBoardCount >= 8 ? 30 : 20));
    if (timeCard) timeCard.classList.toggle('timer-hidden', !showClock);
    refs.time.textContent = showClock ? String(left) : '';
    if (timeCard) timeCard.style.setProperty('--clock-deg', showClock ? `${Math.round(Math.max(0, Math.min(1, left / totalBetSeconds)) * 360)}deg` : '0deg');
  }

  function updateSpinUi() {
    const limit = maxDistinctBoards(lastStatePayload);
    const used = currentDistinctBoardCount(lastStatePayload);
    refs.betDisplay.textContent = number(selectedChip);
    refs.activeBoardName.textContent = `${boardName(activeBoardKey)} ${boardProfiles[activeBoardKey].multiplier} lane · ${used}/${limit} used`;
    refs.selectedChipLabel.textContent = `${chipLabel(selectedChip)} chip`;
    const bettingOpen = !!(lastStatePayload && lastStatePayload.phase === 'betting');
    const pending = pendingBoards.has(activeBoardKey);
    const canArmActiveBoard = !lastStatePayload || canUseBoard(lastStatePayload, activeBoardKey);
    refs.spinButton.disabled = !bettingOpen || pending || !canArmActiveBoard;
    refs.spinButton.classList.toggle('disabled', !bettingOpen || pending || !canArmActiveBoard);
    if (!lastStatePayload) {
      refs.spinHint.textContent = 'Waiting for live round';
      return;
    }
    if (pending) {
      refs.spinHint.textContent = `Placing ${number(selectedChip)} on ${boardName(activeBoardKey)}`;
      return;
    }
    if (lastStatePayload.phase === 'betting') {
      refs.spinHint.textContent = canArmActiveBoard ? `Tap ${boardName(activeBoardKey)} to place ${chipLabel(selectedChip)}` : boardLimitMessage(lastStatePayload);
      return;
    }
    if (lastStatePayload.phase === 'locked') {
      refs.spinHint.textContent = 'Spin locked until the next betting window';
      return;
    }
    if (lastStatePayload.phase === 'revealed') {
      refs.spinHint.textContent = 'Reveal in progress';
      return;
    }
    refs.spinHint.textContent = 'Payout sent. Next round soon';
  }

  function boardText(payload, key, myTotal, isWinner) {
    if (isWinner && myTotal > 0) {
      const raw = payload && payload.result && Number(payload.result.multiplier || 0) > 0
        ? payload.result.multiplier
        : (boardProfiles[key] && boardProfiles[key].multiplier ? boardProfiles[key].multiplier : 'x1');
      const multiplier = Number(String(raw).replace(/[^\d.]/g, '')) || 1;
      const actualWinAmount = Number(payload && payload.my_total_win_amount || 0);
      const winAmount = actualWinAmount > 0 ? actualWinAmount : Math.round(myTotal * multiplier);
      return `${number(myTotal)} x${number(multiplier)} = ${number(winAmount)}`;
    }
    return number(Math.max(0, myTotal));
  }

  function updateBoards(payload) {
    const winner = currentWinner(payload);
    const resultPhase = !!(payload && (payload.phase === 'revealed' || payload.phase === 'settled'));
    Object.keys(boardProfiles).forEach((key) => {
      const boardTotal = Number(payload && payload.board_totals && payload.board_totals[key] || 0);
      const myTotal = Number(payload && payload.my_bet_totals && payload.my_bet_totals[key] || 0);
      refs.pools[key].textContent = boardAmount(boardTotal);
      refs.pools[key].title = number(boardTotal);
      refs.mines[key].textContent = resultPhase && winner === key && myTotal > 0
        ? boardText(payload, key, myTotal, true)
        : boardAmount(myTotal);
      refs.mines[key].title = number(myTotal);
      refs.boardNodes[key].forEach((node) => {
        const blockedByLimit = !!payload && payload.phase === 'betting' && !canUseBoard(payload, key);
        node.classList.toggle('selected', key === activeBoardKey);
        node.classList.toggle('pending', pendingBoards.has(key));
        node.classList.toggle('win', !!resultPhase && winner === key);
        node.classList.toggle('disabled', (!!payload && payload.phase !== 'betting') || blockedByLimit);
      });
    });
    updateSpinUi();
  }

  function updateResultVisual(payload) {
    const winner = currentWinner(payload);
    const resultPhase = !!(payload && (payload.phase === 'revealed' || payload.phase === 'settled'));
    if (!payload) {
      setResultCopy('Wheel armed', 'Choose your chip, then tap Red 7, Crown, or Clover before betting closes.', 'Awaiting reveal', activeBoardKey);
      return;
    }
    if (!resultPhase || !winner) {
      lastResultVisualKey = '';
      if (refs.wheelShell) {
        refs.wheelShell.classList.remove('show-winner');
        refs.wheelShell.removeAttribute('data-winner');
      }
      const title = payload.phase === 'betting' ? 'Choose your lane' : payload.phase === 'locked' ? 'Wheel locking' : 'Syncing room';
      const text = payload.phase === 'betting'
        ? 'Choose a chip below, then tap Red 7, Crown, or Clover before betting closes.'
        : payload.phase === 'locked'
          ? 'Bets are closed and the wheel is lining up its landing symbol.'
          : 'Waiting for the next live room payload from the server.';
      const meta = payload.phase === 'betting' ? 'Live room open' : 'Awaiting result';
      setResultCopy(title, text, meta, activeBoardKey);
      return;
    }
    const resultKey = `${payload.round_no || 'na'}:${winner}`;
    if (resultKey !== lastResultVisualKey) {
      lastResultVisualKey = resultKey;
      triggerWheelFx(winner);
    }
    const myWin = Number(payload.my_total_win_amount || 0);
    setResultCopy(
      `${boardName(winner)} WIN`,
      `The wheel settled on ${boardName(winner)} ${boardProfiles[winner].multiplier}.`,
      myWin > 0 ? `+${number(myWin)} credited` : 'No payout on this reveal',
      winner
    );
  }

  function show(title, text) {
    refs.toastTitle.textContent = title;
    refs.toastText.textContent = text;
    refs.toast.classList.add('show');
    if (toastTimer) window.clearTimeout(toastTimer);
    toastTimer = window.setTimeout(() => refs.toast.classList.remove('show'), 1400);
  }

  function maybeShowWinnerToast(payload) {
    const winner = currentWinner(payload);
    if (!winner || !(payload.phase === 'revealed' || payload.phase === 'settled')) return;
    const winnerKey = `${payload.round_no || 'na'}:${payload.phase}:${winner}`;
    if (winnerKey === lastWinnerToastKey) return;
    lastWinnerToastKey = winnerKey;
    const myWin = Number(payload.my_total_win_amount || 0);
    window.setTimeout(() => {
      spawnCoinFlight(boardTargetNode(winner), refs.balance, myWin > 0 ? 16 : 8, myWin <= 0);
      if (myWin > 0) spawnCoinFlight(boardTargetNode(winner), refs.balance, 12, false);
      show(`Winner ${boardName(winner)}`, myWin > 0 ? `+${number(myWin)} credited` : 'Round synced');
    }, animationEnabled ? 4450 : 0);
  }

  function maybeShowPhasePopup(payload) {
    if (!payload || !payload.phase || !payload.round_no) return;
    const key = `${payload.round_no}:${payload.phase}`;
    if (key === lastPhasePopupKey) return;
    lastPhasePopupKey = key;
    if (payload.phase === 'locked') show('Stop Bet', 'Bets are closed');
    if (payload.phase === 'revealed') show('Result Time', 'Wheel is revealing');
    if (payload.phase === 'settled') show('Payout', 'Coins are being settled');
    if (payload.phase === 'betting') show('Start Bet', 'Choose chip and board');
  }

  function applyPayload(payload) {
    lastStatePayload = payload;
    authoritativeRoundNo = payload.round_no || authoritativeRoundNo;
    if (Array.isArray(payload.recent) && payload.recent.length && !boardHistoryRows.length) {
      boardHistoryRows = payload.recent;
      renderRecentTrack();
      renderHistoryPopup();
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
    updateBalance(Number(payload.balance || 0));
    updateJackpot(payload);
    updateActiveUsers(payload);
    updateRound(authoritativeRoundNo);
    updatePhase(payload.phase);
    updateTimer(payload);
    updateBoards(payload);
    updateResultVisual(payload);
    maybeShowPhasePopup(payload);
    maybeShowWinnerToast(payload);
  }

  function mapBetError(message) {
    const map = {
      invalid_session: 'Session expired. Rejoin room.',
      bet_closed: 'Bet closed. Wait for next round.',
      insufficient_balance: 'Select smaller chip',
      duplicate_request: 'Duplicate bet ignored',
      max_distinct_board_limit: 'All lanes already used',
      max_pot_reached: 'Max pot reached',
      bet_amount_out_of_range: 'Bet amount out of range',
      invalid_board: 'Invalid lane'
    };
    return map[message] || 'Bet failed. Try again.';
  }

  async function refreshState() {
    if (disposed || !window.BDGameFinal || refreshInFlight) return;
    refreshInFlight = true;
    const startedAt = performance.now();
    try {
      const payload = await window.BDGameFinal.get(window.BD_GAME_BOOTSTRAP.endpoints.state, {});
      lastNetworkMs = Math.max(1, Math.round(performance.now() - startedAt));
      if (payload && payload.st) {
        setNetwork(lastNetworkMs < 400 ? 'good' : 'warn', `${lastNetworkMs}ms`);
        applyPayload(payload);
      } else {
        setNetwork('bad', 'retry');
        updateSpinUi();
      }
    } catch (error) {
      setNetwork('bad', 'retry');
      updateSpinUi();
    } finally {
      refreshInFlight = false;
    }
  }

  async function submitBet(boardKey) {
    if (disposed) return;
    if (!window.BDGameFinal || !authoritativeRoundNo || !lastStatePayload) {
      show('Syncing', 'Waiting for live round');
      return;
    }
    if (lastStatePayload.phase !== 'betting') {
      show('Wait', 'Next betting window soon');
      return;
    }
    if (Number(lastStatePayload.balance || 0) < selectedChip) {
      show('Low Balance', 'Select smaller chip');
      return;
    }
    if (!canUseBoard(lastStatePayload, boardKey)) {
      show('Board Limit', boardLimitMessage(lastStatePayload));
      return;
    }
    const amount = selectedChip;
    markPendingBoard(boardKey, 1);
    spawnCoinFlight(chipNodeForValue(amount), boardTargetNode(boardKey), 9, false);
    const optimisticPayload = optimisticBetPayload(lastStatePayload, boardKey, amount);
    if (optimisticPayload) applyPayload(optimisticPayload);
    else updateBoards(lastStatePayload);
    try {
      const response = await window.BDGameFinal.post(window.BD_GAME_BOOTSTRAP.endpoints.bet, {
        round_no: authoritativeRoundNo,
        board_key: boardKey,
        amount: amount,
        request_uid: `${currentGameCode}-${Date.now()}-${++requestCounter}-${boardKey}`,
      });
      if (response && response.st) {
        show('Bet Placed', `${boardName(boardKey)} +${number(amount)}`);
        if (response.balance !== undefined && lastStatePayload) {
          applyPayload(Object.assign({}, lastStatePayload, { balance: Number(response.balance || 0) }));
        }
        window.setTimeout(() => {
          refreshState();
          refreshHistoryTables(true);
        }, 60);
      } else {
        refreshState();
        show('Bet Failed', mapBetError(response && (response.msg || response.error)));
      }
    } catch (error) {
      refreshState();
      show('Bet Failed', 'Retry in the next round');
    } finally {
      markPendingBoard(boardKey, -1);
      if (lastStatePayload) updateBoards(lastStatePayload);
    }
  }

  function selectBoard(boardKey, announce) {
    if (!boardProfiles[boardKey]) return;
    if (lastStatePayload && lastStatePayload.phase === 'betting' && !canUseBoard(lastStatePayload, boardKey)) {
      show('Board Limit', boardLimitMessage(lastStatePayload));
      return;
    }
    activeBoardKey = boardKey;
    if (lastStatePayload) updateBoards(lastStatePayload);
    else updateSpinUi();
    if (announce) show('Lane Armed', `${boardName(boardKey)} ${boardProfiles[boardKey].multiplier}`);
  }

  function selectChip(value, announce) {
    if (!chipLabelMap[Number(value)]) return;
    selectedChip = Number(value);
    refs.chips.forEach((node) => node.classList.toggle('selected', Number(node.dataset.value || 0) === selectedChip));
    updateSpinUi();
    if (announce) show('Chip Selected', `${chipLabel(selectedChip)} look · ${number(selectedChip)} live`);
  }

  function shiftChip(delta) {
    const values = chipProfiles.map((chipProfile) => Number(chipProfile.value));
    const index = Math.max(0, values.indexOf(selectedChip));
    const nextIndex = Math.min(values.length - 1, Math.max(0, index + delta));
    selectChip(values[nextIndex], true);
  }

  refs.chips.forEach((chipNode) => {
    chipNode.addEventListener('click', () => {
      selectChip(chipNode.dataset.value, true);
    });
  });

  function handleBoardPress(event, key) {
    if (event) {
      event.preventDefault();
      event.stopPropagation();
    }
    selectBoard(key, true);
    if (lastStatePayload && lastStatePayload.phase === 'betting') {
      submitBet(key);
    }
  }

  function bindReliableBoardPress(node, key) {
    if (!node) return;
    node.style.touchAction = 'manipulation';
    if (window.PointerEvent) {
      node.addEventListener('pointerup', (event) => {
        if (event.pointerType === 'mouse' && event.button !== 0) return;
        handleBoardPress(event, key);
      }, { passive: false });
    } else {
      node.addEventListener('touchend', (event) => handleBoardPress(event, key), { passive: false });
      node.addEventListener('click', (event) => handleBoardPress(event, key), { passive: false });
    }
    node.addEventListener('keydown', (event) => {
      if (event.key === 'Enter' || event.key === ' ') handleBoardPress(event, key);
    });
  }

  Object.keys(boardProfiles).forEach((key) => {
    refs.boardNodes[key].forEach((node) => {
      bindReliableBoardPress(node, key);
    });
  });

  refs.chipStepDown.addEventListener('click', () => shiftChip(-1));
  refs.chipStepUp.addEventListener('click', () => shiftChip(1));
  refs.chipMax.addEventListener('click', () => {
    const values = chipProfiles.map((chipProfile) => Number(chipProfile.value));
    selectChip(values[values.length - 1], true);
  });
  refs.spinButton.addEventListener('click', () => submitBet(activeBoardKey));
  if (refs.infoButton) refs.infoButton.addEventListener('click', () => openHistoryModal('info'));
  refs.panelActions.forEach((button) => {
    button.addEventListener('click', () => openHistoryModal(button.dataset.panel || 'history'));
  });
  refs.panelTabs.forEach((button) => {
    button.addEventListener('click', () => setRoomPanel(button.dataset.panel || 'history'));
  });
  if (refs.historyContent) {
    refs.historyContent.addEventListener('click', (event) => {
      const setting = event.target.closest('[data-setting]');
      if (!setting) return;
      const key = setting.dataset.setting;
      if (key === 'animation') {
        animationEnabled = !animationEnabled;
        localStorage.setItem('lucky7ProAnimation', animationEnabled ? 'on' : 'off');
      }
      if (key === 'sound') {
        soundEnabled = !soundEnabled;
        localStorage.setItem('lucky7ProSound', soundEnabled ? 'on' : 'off');
        updateMusicUi();
      }
      renderHistoryPopup();
    });
  }
  refs.historyClose.addEventListener('click', closeHistoryModal);
  refs.historyModal.addEventListener('click', (event) => {
    if (event.target === refs.historyModal) {
      closeHistoryModal();
    }
  });

  if (window.BDGameFinal && window.BD_GAME_BOOTSTRAP && window.BD_GAME_BOOTSTRAP.gameCode === currentGameCode) {
    const api = window.BDGameFinal;
    api.onState((payload) => {
      if (!disposed && payload && payload.st) {
        applyPayload(payload);
      }
    });
    if (typeof api.onConnection === 'function') {
      api.onConnection((detail) => {
        if (!detail || disposed) return;
        if (detail.status === 'pending') setNetwork('warn', 'sync');
        if (detail.status === 'error') setNetwork('bad', 'retry');
        if (detail.status === 'expired') {
          setNetwork('bad', 'expired');
          show('Session Expired', 'Rejoin room');
        }
      });
    }
    refreshState();
    if (typeof api.startHeartbeat === 'function') api.startHeartbeat(15000, () => lastNetworkMs || 0);
    else heartbeatTimer = window.setInterval(() => {
      if (disposed) return;
      if (typeof api.heartbeat === 'function') api.heartbeat(lastNetworkMs || 0);
      else api.post(window.BD_GAME_BOOTSTRAP.endpoints.heartbeat, { network_ms: lastNetworkMs || 0 });
    }, 15000);
  } else {
    setNetwork('bad', 'offline');
    show('Live Session Required', 'Rejoin room');
  }

  timerTick = window.setInterval(() => {
    if (lastStatePayload) updateTimer(lastStatePayload);
  }, 250);

  selectBoard(activeBoardKey, false);
  selectChip(selectedChip, false);
  updateMusicUi();
  setRoomPanel('history');
  renderRecentTrack();
  renderHistoryPopup();
  refreshHistoryTables(true);

  function stopProRoomAudioHandle(target, permanent = false, seen = null){
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

  function silenceProRoomAudio(permanent = false){
    const seen = new WeakSet();
    document.querySelectorAll('audio,video').forEach((media) => stopProRoomAudioHandle(media, permanent, seen));
    if('speechSynthesis' in window){
      try { window.speechSynthesis.cancel(); } catch (error) {}
    }
    [window.Howler, window.audioCtx, window.musicCtx, window.backgroundMusic, window.roomMusic, window.roomAudio].forEach((target) => stopProRoomAudioHandle(target, permanent, seen));
    if(window.Howler && typeof window.Howler.stop === 'function'){
      try { window.Howler.stop(); } catch (error) {}
    }
  }

  function cleanupProRoom(){
    disposed = true;
    silenceProRoomAudio(true);
    if (window.BDGameFinal && typeof window.BDGameFinal.stopHeartbeat === 'function') window.BDGameFinal.stopHeartbeat();
    if (refreshTimer) window.clearInterval(refreshTimer);
    if (heartbeatTimer) window.clearInterval(heartbeatTimer);
    if (timerTick) window.clearInterval(timerTick);
    if (resultEffectTimer) window.clearTimeout(resultEffectTimer);
    if (winnerDanceTimer) window.clearTimeout(winnerDanceTimer);
  }

  document.addEventListener('visibilitychange', () => {
    if(document.hidden) silenceProRoomAudio(false);
  });

  window.addEventListener('pagehide', cleanupProRoom, { once: true });
  window.addEventListener('beforeunload', cleanupProRoom, { once: true });
})();
</script>
</body>
</html>
