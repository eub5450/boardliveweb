@php
  $currentGameCode = $gameCode ?? 'lucky77';
  $gameTheme = is_array($gameTheme ?? null) ? $gameTheme : [];
  $isBaseLucky77Variant = $currentGameCode === 'lucky77';
  $isLucky7ProVariant = $currentGameCode === 'lucky7_pro';
  $isLucky88MasterVariant = $currentGameCode === 'lucky88_master';
  $lucky77Variants = [
    'lucky77' => [
      'class' => '',
      'slot_display_mark' => '77',
      'slot_jackpot_title' => '77 Jackpot',
      'rules_label' => 'How to Pay',
      'help_title' => 'How to Play',
      'help_subtitle' => 'Fast guide for the Fruit 77 round flow.',
      'help_bet_line' => 'Tap Melon, 77, or Berry during betting time.',
      'help_stop_line' => 'Once Stop Bet appears, cards lock until result.',
      'help_payout_line' => 'Melon/Berry pays x2, 77 pays x8.',
      'brand_sub' => 'Live Wheel Room',
      'recent_label' => 'Recent',
      'chip_theme' => 'classic',
      'icon_theme' => 'classic',
      'seat_icon' => '✦',
      'marks' => ['melon' => '🍉', 'slot' => '77', 'plum' => '🫐'],
    ],
    'lucky7_pro' => [
      'class' => 'lucky7-pro',
      'slot_display_mark' => '77',
      'slot_jackpot_title' => 'Crown 77',
      'rules_label' => 'Crown Rules',
      'help_title' => 'Lucky 7 Pro Guide',
      'help_subtitle' => 'Premium live wheel flow with faster visual callouts and pro payout cues.',
      'help_bet_line' => 'Tap Crown, 77, or Laurel while the pro entry popup is active.',
      'help_stop_line' => 'Once the lock popup lands, the wheel moves into the result spotlight.',
      'help_payout_line' => 'Crown and Laurel pay x2, center 77 pays x8, then the pro payout burst flies back to balance.',
      'brand_sub' => 'Crown Wheel Lounge',
      'recent_label' => 'Royal',
      'chip_theme' => 'pro',
      'icon_theme' => 'pro',
      'seat_icon' => '♛',
      'marks' => ['melon' => '👑', 'slot' => '77', 'plum' => '🍃'],
    ],
    'lucky88_master' => [
      'class' => 'lucky88-master',
      'slot_display_mark' => '88',
      'slot_jackpot_title' => 'Master 88',
      'rules_label' => 'Master Rules',
      'help_title' => 'Lucky 88 Master Guide',
      'help_subtitle' => 'Golden master wheel with Dragon and Ember side lanes around the Lucky 88 center.',
      'help_bet_line' => 'Tap Dragon, 88, or Ember during betting time on the master wheel.',
      'help_stop_line' => 'Once Stop Bet lands, the master wheel locks and rolls into the Lucky 88 result.',
      'help_payout_line' => 'Dragon and Ember pay x2, 88 pays x8, then winnings fly back to your balance.',
      'brand_sub' => 'Golden Master Pavilion',
      'recent_label' => 'Master',
      'chip_theme' => 'master',
      'icon_theme' => 'master',
      'seat_icon' => '◆',
      'marks' => ['melon' => '🐉', 'slot' => '88', 'plum' => '🔥'],
    ],
    'lucky77_mirage' => [
      'class' => 'lucky77-mirage',
      'slot_display_mark' => '77',
      'slot_jackpot_title' => 'Mirage 77',
      'rules_label' => 'Mirage Rules',
      'help_title' => 'Lucky 77 Mirage Guide',
      'help_subtitle' => 'Desert palace wheel with brass trims, crescent callouts, and warm sand glow.',
      'help_bet_line' => 'Tap Crescent, 77, or Dune Star while betting stays open.',
      'help_stop_line' => 'When the sandglass wheel locks, the result sweeps across the palace rim.',
      'help_payout_line' => 'Side seats pay x2, center 77 pays x8 with a brass payout trail.',
      'brand_sub' => 'Desert Fortune Hall',
      'recent_label' => 'Scroll',
      'chip_theme' => 'mirage',
      'icon_theme' => 'mirage',
      'seat_icon' => '☾',
      'marks' => ['melon' => '🌙', 'slot' => '77', 'plum' => '⭐'],
    ],
    'lucky77_ironfront' => [
      'class' => 'lucky77-ironfront',
      'slot_display_mark' => '77',
      'slot_jackpot_title' => 'Iron 77',
      'rules_label' => 'Frontline Rules',
      'help_title' => 'Lucky 77 Ironfront Guide',
      'help_subtitle' => 'Forged steel wheel with tactical lights, armored seats, and industrial win effects.',
      'help_bet_line' => 'Tap Axe, 77, or Shield while the command wheel is open.',
      'help_stop_line' => 'Once lock sirens fire, the iron wheel settles into its result lane.',
      'help_payout_line' => 'Side seats pay x2, center 77 pays x8 with a steel burst payout.',
      'brand_sub' => 'Command Vault',
      'recent_label' => 'Intel',
      'chip_theme' => 'ironfront',
      'icon_theme' => 'ironfront',
      'seat_icon' => '⚙',
      'marks' => ['melon' => '🪓', 'slot' => '77', 'plum' => '🛡️'],
    ],
    'lucky77_lotus' => [
      'class' => 'lucky77-lotus',
      'slot_display_mark' => '77',
      'slot_jackpot_title' => 'Lotus 77',
      'rules_label' => 'Lotus Rules',
      'help_title' => 'Lucky 77 Lotus Guide',
      'help_subtitle' => 'Silk hall wheel with lacquered petals, ink-black panels, and calm payout pulses.',
      'help_bet_line' => 'Tap Lotus, 77, or Koi while betting stays open.',
      'help_stop_line' => 'When the gong lands, the lotus wheel reveals the round result.',
      'help_payout_line' => 'Side seats pay x2, center 77 pays x8 with a silk ribbon payout.',
      'brand_sub' => 'Silk Room',
      'recent_label' => 'Petals',
      'chip_theme' => 'lotus',
      'icon_theme' => 'lotus',
      'seat_icon' => '✿',
      'marks' => ['melon' => '🌸', 'slot' => '77', 'plum' => '🐠'],
    ],
    'lucky77_nebula' => [
      'class' => 'lucky77-nebula',
      'slot_display_mark' => '77',
      'slot_jackpot_title' => 'Nebula 77',
      'rules_label' => 'Nebula Rules',
      'help_title' => 'Lucky 77 Nebula Guide',
      'help_subtitle' => 'Deep-space wheel with starfield rims, plasma chips, and comet lane callouts.',
      'help_bet_line' => 'Tap Nova, 77, or Star while the galaxy board is live.',
      'help_stop_line' => 'Once the orbit lock hits, the nebula wheel resolves the landing seat.',
      'help_payout_line' => 'Side seats pay x2, center 77 pays x8 with a cosmic payout streak.',
      'brand_sub' => 'Orbit Deck',
      'recent_label' => 'Orbit',
      'chip_theme' => 'nebula',
      'icon_theme' => 'nebula',
      'seat_icon' => '☄',
      'marks' => ['melon' => '🪐', 'slot' => '77', 'plum' => '🌟'],
    ],
    'lucky77_carnival' => [
      'class' => 'lucky77-carnival',
      'slot_display_mark' => '77',
      'slot_jackpot_title' => 'Carnival 77',
      'rules_label' => 'Carnival Rules',
      'help_title' => 'Lucky 77 Carnival Guide',
      'help_subtitle' => 'Festival wheel with striped booths, mask icons, and bright streetlight payouts.',
      'help_bet_line' => 'Tap Mask, 77, or Drum while the carnival wheel is open.',
      'help_stop_line' => 'When the parade horn sounds, the wheel locks and calls the winner.',
      'help_payout_line' => 'Side seats pay x2, center 77 pays x8 with a confetti payout spin.',
      'brand_sub' => 'Festival Arcade',
      'recent_label' => 'Parade',
      'chip_theme' => 'carnival',
      'icon_theme' => 'carnival',
      'seat_icon' => '✹',
      'marks' => ['melon' => '🎭', 'slot' => '77', 'plum' => '🥁'],
    ],
  ];
  $luckyVariant = $lucky77Variants[$currentGameCode] ?? $lucky77Variants['lucky77'];
  if (!empty($gameTheme)) {
    $luckyVariant['chip_theme'] = $gameTheme['chip_theme'] ?? $luckyVariant['chip_theme'];
    $luckyVariant['icon_theme'] = $gameTheme['item_theme'] ?? $luckyVariant['icon_theme'];
  }
  $appVariantClass = $luckyVariant['class'];
  $slotDisplayMark = $luckyVariant['slot_display_mark'];
  $slotJackpotTitle = $luckyVariant['slot_jackpot_title'];
  $rulesLabel = $luckyVariant['rules_label'];
  $helpTitle = $luckyVariant['help_title'];
  $helpSubtitle = $luckyVariant['help_subtitle'];
  $helpBetLine = $luckyVariant['help_bet_line'];
  $helpStopLine = $luckyVariant['help_stop_line'];
  $helpPayoutLine = $luckyVariant['help_payout_line'];
  $brandSub = $luckyVariant['brand_sub'];
  $recentLabel = $luckyVariant['recent_label'];
  $betKeyMarks = $luckyVariant['marks'];
  $slotSeatIcon = $luckyVariant['seat_icon'];
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
  $payoutSummary = collect(['melon', 'slot', 'plum'])
    ->map(function ($key) use ($boardPayoutMultipliers, $formatLuckyMultiplier) {
      return 'x' . $formatLuckyMultiplier($boardPayoutMultipliers[$key] ?? 1);
    })
    ->unique()
    ->implode(' / ');
  $helpPayoutLine = 'Current board payout: Melon x' . $formatLuckyMultiplier($boardPayoutMultipliers['melon'] ?? 1)
    . ', ' . $slotDisplayMark . ' x' . $formatLuckyMultiplier($boardPayoutMultipliers['slot'] ?? 1)
    . ', Berry x' . $formatLuckyMultiplier($boardPayoutMultipliers['plum'] ?? 1) . '.';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover" />
  <title>{{ config('bd_game_final.games.' . $currentGameCode . '.name', 'Lucky 77') }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=El+Messiri:wght@600;700&family=Orbitron:wght@600;700;800&family=Rajdhani:wght@600;700&family=Teko:wght@600;700&display=swap" rel="stylesheet" />
  <style>
    :root {
      --bg-0:#060712;
      --bg-1:#0d1024;
      --bg-2:#17183a;
      --violet:#6e3dff;
      --violet-2:#a452ff;
      --blue:#31a8ff;
      --pink:#ff4db8;
      --gold:#ffd35c;
      --gold-2:#ffefad;
      --danger:#ff5b6b;
      --ok:#39d98a;
      --warn:#ffb02e;
      --glass:rgba(16,22,44,.64);
      --glass-2:rgba(31,38,77,.58);
      --stroke:rgba(255,255,255,.12);
      --text:#f6f8ff;
      --muted:#b8c0e1;
      --shadow:0 10px 40px rgba(0,0,0,.34);
      --top-h:64px;
      --chip-h:82px;
      --chip-dock-h:calc(var(--chip-h) + 18px);
      --bet-h:122px;
      --recent-h:42px;
      --safe-top:max(env(safe-area-inset-top),8px);
      --safe-bottom:max(env(safe-area-inset-bottom),8px);
      --app-w:min(100vw,450px);
      --wheel-size:min(72vw,330px);
      --dur-fast:.18s;
      --dur-med:.35s;
      --dur-slow:.65s;
      --ease:cubic-bezier(.22,.9,.2,1);
    }

    *{box-sizing:border-box;-webkit-tap-highlight-color:transparent;user-select:none;-webkit-user-select:none}
    html,body{margin:0;height:100%;background:#02040c;color:var(--text);overflow:hidden;font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif}
    body{display:grid;place-items:center;touch-action:manipulation}
    button{font:inherit;touch-action:manipulation}

    .app{
      position:relative;
      width:var(--app-w);
      height:100dvh;
      max-height:940px;
      overflow:hidden;
      isolation:isolate;
      background:
        radial-gradient(55% 28% at 50% 8%, rgba(255,211,92,.16), transparent 60%),
        radial-gradient(40% 26% at 50% 34%, rgba(49,168,255,.17), transparent 62%),
        radial-gradient(50% 32% at 15% 16%, rgba(255,77,184,.12), transparent 64%),
        linear-gradient(180deg, #1a0e36 0%, #0e1227 46%, #070b16 100%);
      box-shadow:0 24px 80px rgba(0,0,0,.6);
    }

    .app.lucky7-pro{
      background:
        radial-gradient(58% 32% at 50% 6%, rgba(255,226,120,.20), transparent 62%),
        radial-gradient(42% 30% at 14% 18%, rgba(66,247,203,.14), transparent 64%),
        radial-gradient(46% 28% at 86% 20%, rgba(72,148,255,.18), transparent 60%),
        linear-gradient(180deg, #11262d 0%, #091522 38%, #070b16 100%);
    }
    .app.lucky7-pro .bg-stage{
      background:
        linear-gradient(90deg, rgba(255,255,255,.03), transparent 12%, transparent 88%, rgba(255,255,255,.03)),
        radial-gradient(82% 46% at 50% 100%, rgba(66,247,203,.16), transparent 62%);
    }
    .app.lucky7-pro .bg-lights::before{background:rgba(66,247,203,.26)}
    .app.lucky7-pro .bg-lights::after{background:rgba(74,146,255,.28)}
    .app.lucky7-pro .balance-card,
    .app.lucky7-pro .top-actions,
    .app.lucky7-pro .bet-card,
    .app.lucky7-pro .chip-rail,
    .app.lucky7-pro .recent-strip,
    .app.lucky7-pro .card-panel,
    .app.lucky7-pro .banner,
    .app.lucky7-pro .popup,
    .app.lucky7-pro .hero-panel,
    .app.lucky7-pro .network-pill,
    .app.lucky7-pro .payout-chip,
    .app.lucky7-pro .round-chip{
      border-color:rgba(255,226,120,.18);
      box-shadow:0 16px 36px rgba(0,0,0,.34), inset 0 1px 0 rgba(255,255,255,.08), 0 0 0 1px rgba(66,247,203,.05);
    }
    .app.lucky7-pro .balance-card{background:linear-gradient(180deg, rgba(12,36,42,.96), rgba(8,16,24,.92))}
    .app.lucky7-pro .top-actions{background:linear-gradient(180deg, rgba(15,33,40,.94), rgba(9,16,25,.88))}
    .app.lucky7-pro .topbar::before{
      content:"";
      position:absolute;
      inset:-4px 0 auto;
      height:84px;
      border-radius:28px;
      background:linear-gradient(135deg, rgba(66,247,203,.08), rgba(255,226,120,.12), rgba(74,146,255,.08));
      filter:blur(18px);
      pointer-events:none;
      z-index:0;
    }
    .app.lucky7-pro .balance-value{color:#f4fdfb;text-shadow:0 0 18px rgba(66,247,203,.14)}
    .app.lucky7-pro .balance-value .coin{background:radial-gradient(circle at 32% 28%, #effff9, #b8ffef 32%, #2cd4ab 58%, #0f7465 100%); box-shadow:0 0 14px rgba(66,247,203,.34), 0 0 28px rgba(255,226,120,.12)}
    .app.lucky7-pro .player-flip-label{color:rgba(196,255,246,.72)}
    .app.lucky7-pro .player-flip-value{color:#ebfffb}
    .app.lucky7-pro .round-chip,
    .app.lucky7-pro .network-pill,
    .app.lucky7-pro .payout-chip{background:linear-gradient(180deg, rgba(11,31,36,.96), rgba(8,18,26,.84))}
    .app.lucky7-pro .round-chip b,
    .app.lucky7-pro .payout-chip b{color:#ffe278}
    .app.lucky7-pro .payout-chip{color:#e8fffb}
    .app.lucky7-pro .hero-panel{
      background:
        radial-gradient(72% 56% at 50% 18%, rgba(255,226,120,.11), transparent 64%),
        linear-gradient(180deg, rgba(11,31,36,.96), rgba(8,16,26,.86));
    }
    .app.lucky7-pro .hero-panel::before{background:radial-gradient(circle, rgba(66,247,203,.22), rgba(74,146,255,.14) 42%, transparent 74%)}
    .app.lucky7-pro .wheel-aura{background:radial-gradient(circle, rgba(66,247,203,.20), transparent 42%), radial-gradient(circle at 50% 46%, rgba(255,226,120,.16), transparent 58%)}
    .app.lucky7-pro .wheel-frame{background:linear-gradient(145deg, #fff5bd 0%, #ffe278 18%, #22c4a3 52%, #0f6b64 78%, #0a3234 100%)}
    .app.lucky7-pro .wheel-inner{background:radial-gradient(circle at 50% 27%, #39f1c5 0%, #0ebd9a 22%, #1478b7 52%, #08234f 78%, #041128 100%)}
    .app.lucky7-pro .seg.slot .seg-core{background:linear-gradient(180deg, #fff0a6 0%, #ffd557 38%, #22c4a3 74%, #0c665f 100%)}
    .app.lucky7-pro .seg.slot .seg-core::before{background:radial-gradient(circle at 50% 14%, #fff9d2 0%, #fff0a5 22%, #ffd557 42%, #22c4a3 70%, #0c665f 100%)}
    .app.lucky7-pro .seg.melon .seg-core{background:linear-gradient(180deg, #bfffe7 0%, #39f1c5 42%, #0fb793 72%, #0a5150 100%)}
    .app.lucky7-pro .seg.melon .seg-core::before{background:radial-gradient(circle at 50% 18%, #e7fff5 0%, #80ffd9 28%, #39f1c5 54%, #0fb793 76%, #0a5150 100%)}
    .app.lucky7-pro .seg.plum .seg-core{background:linear-gradient(180deg, #d8efff 0%, #60bfff 42%, #2679d7 72%, #0b3f79 100%)}
    .app.lucky7-pro .seg.plum .seg-core::before{background:radial-gradient(circle at 50% 18%, #f0f8ff 0%, #a9d7ff 26%, #60bfff 54%, #2679d7 76%, #0b3f79 100%)}
    .app.lucky7-pro .bet-card{background:linear-gradient(180deg, rgba(12,35,42,.95), rgba(8,15,24,.9)); border-color:rgba(196,255,246,.12)}
    .app.lucky7-pro .bet-card[data-bet="slot"]{box-shadow:0 0 0 1px rgba(255,226,120,.12), 0 0 24px rgba(255,226,120,.10), inset 0 0 22px rgba(255,226,120,.05)}
    .app.lucky7-pro .bet-card.win{box-shadow:0 0 0 1px rgba(255,226,120,.34), 0 0 30px rgba(66,247,203,.22), 0 0 46px rgba(255,226,120,.18), inset 0 0 28px rgba(66,247,203,.12)}
    .app.lucky7-pro .bet-card.win .bet-icon-wrap{box-shadow:0 0 0 1px rgba(255,255,255,.18), 0 0 24px rgba(66,247,203,.26), 0 0 34px rgba(255,226,120,.22), inset 0 1px 0 rgba(255,255,255,.18)}
    .app.lucky7-pro .recent-label{background:linear-gradient(180deg, rgba(66,247,203,.98), rgba(12,165,139,.92));color:#082524;box-shadow:0 0 18px rgba(66,247,203,.18)}
    .app.lucky7-pro .banner.start{background:linear-gradient(180deg, rgba(15,81,65,.97), rgba(8,27,22,.94))}
    .app.lucky7-pro .banner.stop{background:linear-gradient(180deg, rgba(92,70,17,.98), rgba(35,21,7,.95))}
    .app.lucky7-pro .banner.win{background:linear-gradient(180deg, rgba(9,76,72,.98), rgba(8,18,26,.95))}
    .app.lucky7-pro .banner.net{background:linear-gradient(180deg, rgba(82,36,12,.98), rgba(26,11,8,.95))}
    .app.lucky7-pro .splash{background:radial-gradient(circle at 50% 30%, rgba(255,226,120,.14), transparent 36%), linear-gradient(180deg,#103239 0%,#07121d 100%)}
    .app.lucky7-pro .splash-box{background:linear-gradient(180deg, rgba(13,33,40,.96), rgba(7,14,23,.96)); border-color:rgba(255,226,120,.18)}
    .app.lucky7-pro .brand{letter-spacing:.08em; text-shadow:0 0 24px rgba(66,247,203,.2), 0 0 34px rgba(255,226,120,.16)}
    .app.lucky7-pro .brand-sub{color:#d7fff6}
    .app.lucky7-pro .splash-fill{background:linear-gradient(90deg,#25d5b0,#4ca8ff,#ffe278)}

    .app.lucky88-master{
      background:
        radial-gradient(circle at 50% 20%, rgba(108,31,205,.45), transparent 35%),
        radial-gradient(circle at 50% 0%, rgba(255,215,0,.08), transparent 25%),
        linear-gradient(180deg, #2b004d 0%, #120021 45%, #090012 100%);
    }
    .app.lucky88-master .bg-stage{
      opacity:.92;
      background:
        repeating-linear-gradient(90deg, transparent 0 14px, rgba(255,255,255,.03) 14px 18px, transparent 18px 34px),
        radial-gradient(ellipse at 50% 0%, rgba(105,35,180,.5), transparent 55%);
    }
    .app.lucky88-master .bg-floor{background:radial-gradient(75% 90% at 50% 100%, rgba(255,174,0,.15), transparent 55%), linear-gradient(180deg, transparent, rgba(0,0,0,.2) 42%, rgba(0,0,0,.5))}
    .app.lucky88-master .bg-lights::before{background:rgba(87,173,255,.2)}
    .app.lucky88-master .bg-lights::after{background:rgba(255,42,170,.24)}
    .app.lucky88-master .balance-card,
    .app.lucky88-master .top-actions,
    .app.lucky88-master .bet-card,
    .app.lucky88-master .chip-rail,
    .app.lucky88-master .recent-strip,
    .app.lucky88-master .card-panel,
    .app.lucky88-master .banner,
    .app.lucky88-master .popup,
    .app.lucky88-master .hero-panel,
    .app.lucky88-master .network-pill,
    .app.lucky88-master .payout-chip,
    .app.lucky88-master .round-chip,
    .app.lucky88-master .action-box{
      border-color:rgba(255,215,0,.28);
      box-shadow:0 12px 28px rgba(0,0,0,.36), inset 0 1px 0 rgba(255,255,255,.1), 0 0 0 1px rgba(255,215,0,.05);
    }
    .app.lucky88-master .topbar::before{
      content:"";
      position:absolute;
      inset:-6px 0 auto;
      height:92px;
      border-radius:28px;
      background:radial-gradient(circle at 24% 40%, rgba(87,173,255,.2), transparent 32%), radial-gradient(circle at 78% 34%, rgba(255,42,170,.16), transparent 30%), linear-gradient(135deg, rgba(255,215,0,.08), rgba(255,255,255,0));
      filter:blur(20px);
      pointer-events:none;
      z-index:0;
    }
    .app.lucky88-master .balance-card{background:linear-gradient(180deg, rgba(68,10,122,.88), rgba(21,2,44,.84))}
    .app.lucky88-master .top-actions{background:linear-gradient(180deg, rgba(62,10,112,.86), rgba(18,2,40,.84))}
    .app.lucky88-master .balance-value{color:#fff7d6;text-shadow:0 0 14px rgba(255,215,0,.2)}
    .app.lucky88-master .balance-value .coin{background:radial-gradient(circle at 30% 30%, #fff8c0, #ffcf58 58%, #9f6a08); box-shadow:0 0 14px rgba(255,215,0,.26)}
    .app.lucky88-master .round-chip,
    .app.lucky88-master .network-pill,
    .app.lucky88-master .payout-chip{background:linear-gradient(180deg, rgba(68,10,122,.78), rgba(21,2,44,.72))}
    .app.lucky88-master .round-chip b,
    .app.lucky88-master .payout-chip b{color:#ffd700}
    .app.lucky88-master .hero-panel{
      background:
        radial-gradient(circle at 50% 10%, rgba(255,215,0,.1), transparent 24%),
        linear-gradient(180deg, rgba(58,0,101,.92), rgba(10,0,19,.88));
    }
    .app.lucky88-master .hero-panel::before{background:radial-gradient(circle, rgba(255,174,0,.16), rgba(255,0,170,.08) 38%, transparent 70%)}
    .app.lucky88-master .wheel-aura{background:radial-gradient(circle, rgba(255,215,0,.18) 0%, rgba(255,0,170,.10) 32%, rgba(104,0,255,.08) 52%, transparent 72%)}
    .app.lucky88-master .wheel{background:radial-gradient(circle at 28% 22%, rgba(255,255,255,.65), transparent 14%), linear-gradient(145deg, #fff0a8, #ffd700 26%, #f0b000 40%, #b8860b 70%, #7a5900)}
    .app.lucky88-master .wheel::before{border-color:#301600}
    .app.lucky88-master .wheel-inner{background:radial-gradient(circle at 50% 50%, #1399ff 0%, #0c73e9 50%, #0859cf 76%, #083ea4 100%)}
    .app.lucky88-master .pointer-cap{box-shadow:0 0 0 3px rgba(94,28,0,.6), 0 0 18px rgba(255,62,186,.42)}
    .app.lucky88-master .bet-card{background:radial-gradient(circle at 50% 8%, rgba(255,255,255,.12), transparent 24%), linear-gradient(180deg, rgba(82,0,150,.98), rgba(26,0,51,.98))}
    .app.lucky88-master .bet-card[data-bet="slot"]{box-shadow:0 0 0 1px rgba(255,215,0,.18), 0 0 18px rgba(255,215,0,.14), inset 0 0 18px rgba(255,215,0,.08)}
    .app.lucky88-master .bet-card.win{box-shadow:0 0 0 1px rgba(255,215,0,.34), 0 0 24px rgba(255,215,0,.2), 0 0 30px rgba(255,0,170,.16), inset 0 0 24px rgba(255,190,80,.14)}
    .app.lucky88-master .bet-card.win .bet-icon-wrap{box-shadow:0 0 0 1px rgba(255,255,255,.18), 0 0 22px rgba(255,215,0,.2), 0 0 28px rgba(255,0,170,.16), inset 0 1px 0 rgba(255,255,255,.18)}
    .app.lucky88-master .recent-label{background:linear-gradient(180deg, #ff1493, #7d003f); box-shadow:0 0 14px rgba(255,20,147,.28)}
    .app.lucky88-master .banner.start{background:linear-gradient(180deg, rgba(255,239,167,.96), rgba(255,181,54,.94) 52%, rgba(166,84,0,.94)); color:#2a1300}
    .app.lucky88-master .banner.stop{background:linear-gradient(180deg, rgba(255,102,173,.95), rgba(185,23,113,.95) 58%, rgba(82,5,48,.95))}
    .app.lucky88-master .banner.win{background:linear-gradient(180deg, rgba(126,30,255,.96), rgba(255,42,170,.96) 44%, rgba(255,187,43,.94))}
    .app.lucky88-master .banner.net{background:linear-gradient(180deg, rgba(84,181,255,.95), rgba(38,107,255,.95) 50%, rgba(14,28,103,.96))}
    .app.lucky88-master .splash{background:radial-gradient(circle at 50% 15%, rgba(255,215,0,.16), transparent 28%), radial-gradient(circle at 50% 0%, rgba(80,150,255,.16), transparent 34%), linear-gradient(180deg, #130022 0%, #090012 100%)}
    .app.lucky88-master .splash-box{background:linear-gradient(180deg, rgba(255,255,255,.12), rgba(255,255,255,.05)); border-color:rgba(255,255,255,.14)}
    .app.lucky88-master .brand{text-shadow:0 0 16px rgba(255,90,210,.28), 0 0 24px rgba(255,220,120,.22)}
    .app.lucky88-master .brand-sub{color:rgba(255,255,255,.78); letter-spacing:.14em; text-transform:uppercase}
    .app.lucky88-master .splash-fill{background:linear-gradient(90deg, #ff41b6, #ffd86a 55%, #7ab7ff)}
    .app.lucky88-master .slot77{-webkit-text-stroke:1.3px #fff07b; text-shadow:0 0 10px rgba(255,20,147,.58), 0 0 4px rgba(255,255,255,.22), 2px 2px 0 rgba(0,0,0,.36); letter-spacing:-1.45px}
    .app.lucky88-master .wheel-icon-seat{background:linear-gradient(180deg, rgba(69,21,151,.96), rgba(26,0,53,.9)); border-color:rgba(255,215,0,.35)}
    .app.lucky88-master .wheel-wrap{filter:drop-shadow(0 18px 30px rgba(0,0,0,.28)) drop-shadow(0 0 14px rgba(255,201,78,.10))}
    .app.lucky88-master .wheel-wrap::before{opacity:.28;filter:blur(14px)}
    .app.lucky88-master .wheel-wrap::after{opacity:.32}
    .app.lucky88-master .wheel-aura{opacity:.38;filter:blur(16px);animation-duration:4.8s}
    .app.lucky88-master .wheel::after{opacity:.24;animation-duration:12s}
    .app.lucky88-master .wheel-inner{
      background:
        radial-gradient(circle at 50% 50%, transparent 0 18%, rgba(255,241,184,.72) 18.2% 18.9%, transparent 19.1%),
        radial-gradient(circle at 50% 44%, #2b45d8 0%, #1730a5 43%, #10176a 70%, #09072b 100%);
      box-shadow:inset 0 0 0 1px rgba(255,232,148,.22), inset 0 -12px 20px rgba(0,0,0,.22), 0 0 14px rgba(255,255,255,.03);
      backdrop-filter:none;-webkit-backdrop-filter:none;
    }
    .app.lucky88-master .wheel-inner::before{opacity:.26;animation:none;background:linear-gradient(150deg, rgba(255,255,255,.24), rgba(255,255,255,.06) 22%, rgba(255,255,255,0) 42%)}
    .app.lucky88-master .wheel-inner::after{inset:7px;opacity:.54;background:transparent;box-shadow:inset 0 0 0 1px rgba(255,255,255,.08), inset 0 -20px 28px rgba(0,0,0,.18)}
    .app.lucky88-master .wheel-ticks{opacity:.48}
    .app.lucky88-master .wheel-spark{display:none}
    .app.lucky88-master .seg::before{opacity:.58;box-shadow:none}
    .app.lucky88-master .seg::after{opacity:.55}
    .app.lucky88-master .seg.slot .seg-core{background:linear-gradient(180deg, #fff0a0 0%, #e1a51d 58%, #814100 100%)}
    .app.lucky88-master .seg.slot .seg-core::before{background:radial-gradient(circle at 50% 18%, #fff8d2 0%, #ffdf62 38%, #d98b11 72%, #7b3e00 100%)}
    .app.lucky88-master .seg.melon .seg-core{background:linear-gradient(180deg, #9a80ff 0%, #5b35d6 58%, #21105f 100%)}
    .app.lucky88-master .seg.melon .seg-core::before{background:radial-gradient(circle at 50% 20%, #b49fff 0%, #6f4df0 42%, #3f249d 78%, #1d0d57 100%)}
    .app.lucky88-master .seg.plum .seg-core{background:linear-gradient(180deg, #ffb16e 0%, #e56524 58%, #6b180a 100%)}
    .app.lucky88-master .seg.plum .seg-core::before{background:radial-gradient(circle at 50% 20%, #ffd08a 0%, #ff8842 40%, #bd3f16 76%, #5c1308 100%)}
    .app.lucky88-master .wheel-icon-seat{
      background:transparent;
      border:0;
      box-shadow:none;
      backdrop-filter:none;-webkit-backdrop-filter:none;
    }
    .app.lucky88-master .wheel-icon-seat::before{display:none}
    .app.lucky88-master .wheel-icon-seat.slot{width:54px !important;height:54px !important}
    .app.lucky88-master .wheel-icon-seat.melon{width:54px !important;height:54px !important}
    .app.lucky88-master .wheel-icon-seat.plum{width:52px !important;height:52px !important}
    .app.lucky88-master .wheel-icon-seat .wheel-fruit-icon{filter:drop-shadow(0 3px 4px rgba(0,0,0,.52)) drop-shadow(0 0 5px rgba(255,238,180,.18))}
    .app.lucky88-master .wheel-icon-seat .slot-seat-stack{transform:translateY(1px) scale(.76);filter:drop-shadow(0 3px 4px rgba(0,0,0,.5))}
    .app.lucky88-master .wheel-icon-seat.winner-seat{box-shadow:0 0 0 1px rgba(255,235,158,.36), 0 0 16px rgba(255,215,0,.32), inset 0 1px 0 rgba(255,255,255,.22)}

    .app.lucky77-mirage{
      font-family:'Cormorant Garamond', Georgia, serif;
      background:
        radial-gradient(circle at 50% 10%, rgba(255,221,140,.18), transparent 28%),
        radial-gradient(circle at 20% 18%, rgba(72,180,214,.12), transparent 34%),
        linear-gradient(180deg, #523214 0%, #1c1108 44%, #090603 100%);
    }
    .app.lucky77-mirage .balance-card,
    .app.lucky77-mirage .top-actions,
    .app.lucky77-mirage .bet-card,
    .app.lucky77-mirage .chip-rail,
    .app.lucky77-mirage .recent-strip,
    .app.lucky77-mirage .popup,
    .app.lucky77-mirage .hero-panel,
    .app.lucky77-mirage .network-pill,
    .app.lucky77-mirage .payout-chip,
    .app.lucky77-mirage .round-chip,
    .app.lucky77-mirage .action-box{border-color:rgba(255,207,132,.22);border-radius:26px;box-shadow:0 14px 32px rgba(0,0,0,.38), inset 0 1px 0 rgba(255,246,216,.08), 0 0 0 1px rgba(61,168,188,.05)}
    .app.lucky77-mirage .topbar::before{content:"";position:absolute;inset:-4px 0 auto;height:88px;border-radius:30px;background:linear-gradient(135deg, rgba(255,217,146,.1), rgba(61,168,188,.08), rgba(255,235,190,0));filter:blur(22px);pointer-events:none;z-index:0}
    .app.lucky77-mirage .balance-card,.app.lucky77-mirage .top-actions,.app.lucky77-mirage .hero-panel,.app.lucky77-mirage .bet-card{background:linear-gradient(180deg, rgba(49,30,14,.96), rgba(16,10,5,.92))}
    .app.lucky77-mirage .wheel-aura{background:radial-gradient(circle, rgba(255,209,138,.18), transparent 40%), radial-gradient(circle at 50% 55%, rgba(59,174,204,.16), transparent 62%)}
    .app.lucky77-mirage .wheel-frame{background:linear-gradient(145deg, #fff1ca 0%, #e7ba66 18%, #9a6330 54%, #533112 100%)}
    .app.lucky77-mirage .wheel-inner{background:radial-gradient(circle at 50% 24%, #f7d38a 0%, #b9763d 28%, #5c3515 58%, #1c1108 100%)}
    .app.lucky77-mirage .wheel-center,.app.lucky77-mirage .pointer-cap{background:linear-gradient(180deg, #f8e3ae, #b87931 56%, #4f2d10)}
    .app.lucky77-mirage .bet-card.win{box-shadow:0 0 0 1px rgba(255,216,144,.36), 0 0 28px rgba(255,216,144,.16), inset 0 0 24px rgba(61,168,188,.12)}
    .app.lucky77-mirage .recent-label{background:linear-gradient(180deg, #e7ba66, #7e4c18);color:#231405}
    .app.lucky77-mirage .brand-sub{letter-spacing:.18em;color:#f5dab5}
    .app.lucky77-mirage .chip.purple{--c1:#ffe4ac;--c2:#d39c46;--c3:#704113}
    .app.lucky77-mirage .chip.orange{--c1:#ffd5a3;--c2:#df7b2f;--c3:#772f0c}
    .app.lucky77-mirage .chip.green{--c1:#b9f6ef;--c2:#29b5a1;--c3:#0e5953}
    .app.lucky77-mirage .chip.blue{--c1:#bae8ff;--c2:#4db4de;--c3:#0d4c65}
    .app.lucky77-mirage .chip.gold{--c1:#fff4cf;--c2:#f0c46f;--c3:#916222}

    .app.lucky77-ironfront{
      font-family:'Rajdhani', Inter, sans-serif;
      background:
        radial-gradient(circle at 50% 12%, rgba(255,120,82,.12), transparent 28%),
        linear-gradient(180deg, #2a2f37 0%, #111418 44%, #08090b 100%);
    }
    .app.lucky77-ironfront .balance-card,
    .app.lucky77-ironfront .top-actions,
    .app.lucky77-ironfront .bet-card,
    .app.lucky77-ironfront .chip-rail,
    .app.lucky77-ironfront .recent-strip,
    .app.lucky77-ironfront .popup,
    .app.lucky77-ironfront .hero-panel,
    .app.lucky77-ironfront .network-pill,
    .app.lucky77-ironfront .payout-chip,
    .app.lucky77-ironfront .round-chip,
    .app.lucky77-ironfront .action-box{border-color:rgba(203,113,84,.26);border-radius:12px;box-shadow:0 16px 32px rgba(0,0,0,.42), inset 0 1px 0 rgba(255,255,255,.05), 0 0 0 1px rgba(203,113,84,.05)}
    .app.lucky77-ironfront .balance-card,.app.lucky77-ironfront .top-actions,.app.lucky77-ironfront .hero-panel,.app.lucky77-ironfront .bet-card{background:linear-gradient(180deg, rgba(49,53,61,.96), rgba(14,16,19,.94))}
    .app.lucky77-ironfront .wheel-frame,.app.lucky77-ironfront .bet-card,.app.lucky77-ironfront .chip-rail,.app.lucky77-ironfront .action-box{clip-path:polygon(10px 0, calc(100% - 10px) 0, 100% 10px, 100% calc(100% - 10px), calc(100% - 10px) 100%, 10px 100%, 0 calc(100% - 10px), 0 10px)}
    .app.lucky77-ironfront .wheel-aura{background:radial-gradient(circle, rgba(255,126,77,.18), transparent 42%), radial-gradient(circle at 50% 55%, rgba(125,138,150,.14), transparent 62%)}
    .app.lucky77-ironfront .wheel-frame{background:linear-gradient(145deg, #f0f0f0 0%, #8a8f97 24%, #4f555d 58%, #1d2127 100%)}
    .app.lucky77-ironfront .wheel-inner{background:radial-gradient(circle at 50% 24%, #6d747d 0%, #3c434a 28%, #1f2429 58%, #0a0c0f 100%)}
    .app.lucky77-ironfront .pointer-cap,.app.lucky77-ironfront .wheel-center{background:linear-gradient(180deg, #ece8e0, #8f5b47 52%, #381d12)}
    .app.lucky77-ironfront .banner.stop{background:linear-gradient(180deg, rgba(180,84,46,.98), rgba(69,29,15,.95))}
    .app.lucky77-ironfront .recent-label{background:linear-gradient(180deg, #ff9a63, #652c14);color:#140902}
    .app.lucky77-ironfront .brand-sub{letter-spacing:.2em;color:#d7dde6}
    .app.lucky77-ironfront .chip.purple{--c1:#d9dde6;--c2:#828995;--c3:#353940}
    .app.lucky77-ironfront .chip.orange{--c1:#ffd0b0;--c2:#d77236;--c3:#5f2208}
    .app.lucky77-ironfront .chip.green{--c1:#e0ebef;--c2:#7da6a8;--c3:#2a4143}
    .app.lucky77-ironfront .chip.blue{--c1:#d0d9e2;--c2:#7286a0;--c3:#273444}
    .app.lucky77-ironfront .chip.gold{--c1:#f8ead6;--c2:#c99a64;--c3:#5d381a}

    .app.lucky77-lotus{
      font-family:'El Messiri', Inter, sans-serif;
      background:
        radial-gradient(circle at 50% 10%, rgba(255,204,224,.16), transparent 28%),
        radial-gradient(circle at 18% 24%, rgba(129,206,182,.14), transparent 34%),
        linear-gradient(180deg, #18342a 0%, #091410 44%, #050807 100%);
    }
    .app.lucky77-lotus .balance-card,
    .app.lucky77-lotus .top-actions,
    .app.lucky77-lotus .bet-card,
    .app.lucky77-lotus .chip-rail,
    .app.lucky77-lotus .recent-strip,
    .app.lucky77-lotus .popup,
    .app.lucky77-lotus .hero-panel,
    .app.lucky77-lotus .network-pill,
    .app.lucky77-lotus .payout-chip,
    .app.lucky77-lotus .round-chip,
    .app.lucky77-lotus .action-box{border-color:rgba(181,232,211,.2);border-radius:28px;box-shadow:0 14px 32px rgba(0,0,0,.34), inset 0 1px 0 rgba(255,255,255,.06), 0 0 0 1px rgba(243,169,193,.04)}
    .app.lucky77-lotus .balance-card,.app.lucky77-lotus .top-actions,.app.lucky77-lotus .hero-panel,.app.lucky77-lotus .bet-card{background:linear-gradient(180deg, rgba(22,51,40,.96), rgba(7,16,13,.92))}
    .app.lucky77-lotus .wheel-aura{background:radial-gradient(circle, rgba(248,194,214,.16), transparent 38%), radial-gradient(circle at 50% 50%, rgba(137,208,183,.18), transparent 62%)}
    .app.lucky77-lotus .wheel-frame{background:linear-gradient(145deg, #fbf6e8 0%, #f3b7cf 20%, #7cbca5 52%, #1e5b48 78%, #0a1b16 100%)}
    .app.lucky77-lotus .wheel-inner{background:radial-gradient(circle at 50% 24%, #fbe5ef 0%, #d78ca8 24%, #458c72 56%, #133a2e 82%, #081411 100%)}
    .app.lucky77-lotus .wheel-icon-seat{border-radius:42% 58% 46% 54% / 54% 44% 56% 46%}
    .app.lucky77-lotus .bet-card{border-radius:32px 32px 22px 22px}
    .app.lucky77-lotus .recent-label{background:linear-gradient(180deg, #f2b9d2, #8f4167);color:#200a14}
    .app.lucky77-lotus .slot77{font-family:'El Messiri', Inter, sans-serif;letter-spacing:-1px}
    .app.lucky77-lotus .chip.purple{--c1:#ffe1f0;--c2:#d06b95;--c3:#6e2953}
    .app.lucky77-lotus .chip.orange{--c1:#ffe2c1;--c2:#d59a58;--c3:#71411a}
    .app.lucky77-lotus .chip.green{--c1:#dff9ee;--c2:#53c497;--c3:#156346}
    .app.lucky77-lotus .chip.blue{--c1:#ddefff;--c2:#6ab2d6;--c3:#1a5675}
    .app.lucky77-lotus .chip.gold{--c1:#fff1db;--c2:#e3bc79;--c3:#876125}

    .app.lucky77-nebula{
      font-family:'Orbitron', Inter, sans-serif;
      background:
        radial-gradient(circle at 50% 10%, rgba(88,210,255,.18), transparent 28%),
        radial-gradient(circle at 18% 20%, rgba(216,97,255,.14), transparent 30%),
        linear-gradient(180deg, #130530 0%, #070a18 42%, #03050c 100%);
    }
    .app.lucky77-nebula .balance-card,
    .app.lucky77-nebula .top-actions,
    .app.lucky77-nebula .bet-card,
    .app.lucky77-nebula .chip-rail,
    .app.lucky77-nebula .recent-strip,
    .app.lucky77-nebula .popup,
    .app.lucky77-nebula .hero-panel,
    .app.lucky77-nebula .network-pill,
    .app.lucky77-nebula .payout-chip,
    .app.lucky77-nebula .round-chip,
    .app.lucky77-nebula .action-box{border-color:rgba(121,218,255,.22);border-radius:18px;box-shadow:0 14px 34px rgba(0,0,0,.4), inset 0 1px 0 rgba(255,255,255,.07), 0 0 0 1px rgba(214,90,255,.06)}
    .app.lucky77-nebula .balance-card,.app.lucky77-nebula .top-actions,.app.lucky77-nebula .hero-panel,.app.lucky77-nebula .bet-card{background:linear-gradient(180deg, rgba(16,14,50,.96), rgba(5,8,18,.92))}
    .app.lucky77-nebula .wheel-aura{background:radial-gradient(circle, rgba(88,210,255,.22), transparent 36%), radial-gradient(circle at 50% 48%, rgba(216,97,255,.16), transparent 62%)}
    .app.lucky77-nebula .wheel-frame{background:linear-gradient(145deg, #eef6ff 0%, #7dd8ff 22%, #7d67ff 52%, #29156c 76%, #0a0718 100%)}
    .app.lucky77-nebula .wheel-inner{background:radial-gradient(circle at 50% 22%, #d2f6ff 0%, #57d1ff 24%, #4b47ff 56%, #1c1462 82%, #050815 100%)}
    .app.lucky77-nebula .wheel,.app.lucky77-nebula .wheel-center{box-shadow:0 0 22px rgba(88,210,255,.18), 0 0 42px rgba(216,97,255,.12)}
    .app.lucky77-nebula .recent-label{background:linear-gradient(180deg, #5dd6ff, #123c8d);color:#031221}
    .app.lucky77-nebula .brand{letter-spacing:.08em}
    .app.lucky77-nebula .brand-sub{letter-spacing:.28em;color:#bdeeff}
    .app.lucky77-nebula .chip.purple{--c1:#f1d9ff;--c2:#9b55ff;--c3:#2c0f74}
    .app.lucky77-nebula .chip.orange{--c1:#ffd7ff;--c2:#ff71da;--c3:#701155}
    .app.lucky77-nebula .chip.green{--c1:#d7ffff;--c2:#3ce1dc;--c3:#0d5a66}
    .app.lucky77-nebula .chip.blue{--c1:#def6ff;--c2:#5ab6ff;--c3:#144a9d}
    .app.lucky77-nebula .chip.gold{--c1:#fff1ff;--c2:#c6a7ff;--c3:#5f2ebc}

    .app.lucky77-carnival{
      font-family:'Teko', Inter, sans-serif;
      background:
        radial-gradient(circle at 50% 10%, rgba(255,234,132,.18), transparent 28%),
        radial-gradient(circle at 22% 18%, rgba(255,87,150,.14), transparent 32%),
        linear-gradient(180deg, #4b122d 0%, #170916 42%, #080406 100%);
    }
    .app.lucky77-carnival .balance-card,
    .app.lucky77-carnival .top-actions,
    .app.lucky77-carnival .bet-card,
    .app.lucky77-carnival .chip-rail,
    .app.lucky77-carnival .recent-strip,
    .app.lucky77-carnival .popup,
    .app.lucky77-carnival .hero-panel,
    .app.lucky77-carnival .network-pill,
    .app.lucky77-carnival .payout-chip,
    .app.lucky77-carnival .round-chip,
    .app.lucky77-carnival .action-box{border-color:rgba(255,188,89,.22);border-radius:24px;box-shadow:0 16px 36px rgba(0,0,0,.4), inset 0 1px 0 rgba(255,255,255,.08), 0 0 0 1px rgba(255,79,125,.06)}
    .app.lucky77-carnival .balance-card,.app.lucky77-carnival .top-actions,.app.lucky77-carnival .hero-panel,.app.lucky77-carnival .bet-card{background:linear-gradient(180deg, rgba(88,18,48,.96), rgba(25,7,18,.92))}
    .app.lucky77-carnival .wheel-aura{background:radial-gradient(circle, rgba(255,220,94,.18), transparent 36%), radial-gradient(circle at 50% 50%, rgba(255,83,142,.18), transparent 62%)}
    .app.lucky77-carnival .wheel-frame{background:repeating-linear-gradient(135deg, #ffe07a 0 12px, #ff6589 12px 24px, #6dc8ff 24px 36px, #ffd159 36px 48px)}
    .app.lucky77-carnival .wheel-inner{background:radial-gradient(circle at 50% 22%, #ffeeb5 0%, #ffb74b 20%, #ff5b84 46%, #7420a4 74%, #23052e 100%)}
    .app.lucky77-carnival .bet-card{border-radius:30px 30px 16px 16px}
    .app.lucky77-carnival .banner.start{background:linear-gradient(180deg, rgba(255,222,113,.96), rgba(255,144,61,.94) 52%, rgba(179,58,38,.96));color:#361003}
    .app.lucky77-carnival .recent-label{background:repeating-linear-gradient(135deg, #ffe07a 0 8px, #ff6c8d 8px 16px);color:#3b0f1c}
    .app.lucky77-carnival .brand-sub{letter-spacing:.22em;color:#ffe5b6}
    .app.lucky77-carnival .chip.purple{--c1:#ffe2f3;--c2:#ff6b9d;--c3:#7a1837}
    .app.lucky77-carnival .chip.orange{--c1:#fff1b1;--c2:#ffaf39;--c3:#8c3a00}
    .app.lucky77-carnival .chip.green{--c1:#dffff3;--c2:#35db93;--c3:#116145}
    .app.lucky77-carnival .chip.blue{--c1:#d9f3ff;--c2:#57bcff;--c3:#1751aa}
    .app.lucky77-carnival .chip.gold{--c1:#fff6cf;--c2:#ffd862;--c3:#a45d04}

    .app.lucky77-plain-wheel .seg.slot .seg-core{
      background:linear-gradient(180deg, #fff1a8 0%, #f0c84d 48%, #9a6712 100%);
      box-shadow:inset 0 0 0 1px rgba(255,246,191,.4), inset 0 0 12px rgba(255,255,255,.12);
    }
    .app.lucky77-plain-wheel .seg.slot .seg-core::before{
      background:radial-gradient(circle at 50% 18%, #fff8db 0%, #ffe37a 38%, #e5b72d 72%, #8a5d10 100%);
    }
    .app.lucky77-plain-wheel .seg.melon .seg-core{
      background:linear-gradient(180deg, #ffd7e7 0%, #ff78a8 48%, #98244f 100%);
      box-shadow:inset 0 0 0 1px rgba(255,228,238,.34), inset 0 0 12px rgba(255,255,255,.08);
    }
    .app.lucky77-plain-wheel .seg.melon .seg-core::before{
      background:radial-gradient(circle at 50% 18%, #fff2f7 0%, #ffb3cc 36%, #ff6f9e 70%, #8c214a 100%);
    }
    .app.lucky77-plain-wheel .seg.plum .seg-core{
      background:linear-gradient(180deg, #e2dcff 0%, #8f7cff 48%, #33208e 100%);
      box-shadow:inset 0 0 0 1px rgba(236,232,255,.32), inset 0 0 12px rgba(255,255,255,.08);
    }
    .app.lucky77-plain-wheel .seg.plum .seg-core::before{
      background:radial-gradient(circle at 50% 18%, #f4f1ff 0%, #c5bbff 36%, #8f7cff 70%, #312087 100%);
    }
    .app.lucky77-plain-wheel .wheel-icon-seat::before{
      display:none;
    }
    .app.lucky77-plain-wheel .wheel-icon-seat.slot{
      background:radial-gradient(circle at 50% 26%, #fff8d8 0%, #ffe27b 34%, #f0c44d 62%, #976610 100%);
      box-shadow:inset 0 1px 0 rgba(255,255,255,.22), 0 0 0 1.8px rgba(255,237,170,.75), 0 8px 14px rgba(77,52,0,.2);
    }
    .app.lucky77-plain-wheel .wheel-icon-seat.melon{
      background:radial-gradient(circle at 50% 26%, #fff2f7 0%, #ffb0ca 34%, #ff74a0 62%, #932248 100%);
      box-shadow:inset 0 1px 0 rgba(255,255,255,.2), 0 0 0 1.8px rgba(255,214,229,.68), 0 8px 14px rgba(88,14,42,.18);
    }
    .app.lucky77-plain-wheel .wheel-icon-seat.plum{
      background:radial-gradient(circle at 50% 26%, #f5f2ff 0%, #c6bfff 34%, #8f7cff 62%, #34218f 100%);
      box-shadow:inset 0 1px 0 rgba(255,255,255,.18), 0 0 0 1.8px rgba(224,218,255,.64), 0 8px 14px rgba(29,18,83,.2);
    }
    .app.lucky77-plain-wheel .wheel-mark-plain{
      display:grid;
      place-items:center;
      width:100%;
      height:100%;
      line-height:1;
      text-shadow:0 2px 6px rgba(0,0,0,.28);
      filter:none !important;
    }
    .app.lucky77-plain-wheel .wheel-mark-plain.slot{
      color:#582f00;
      font-family:'Orbitron', Inter, sans-serif;
      font-weight:900;
      letter-spacing:-1.4px;
      font-size:24px;
    }
    .app.lucky77-plain-wheel .wheel-mark-plain.melon,
    .app.lucky77-plain-wheel .wheel-mark-plain.plum{
      font-size:30px;
      transform:translateY(-1px);
      font-family:'Teko', 'Rajdhani', Inter, sans-serif;
      font-weight:700;
    }

    .bg-stage,.bg-lights,.bg-floor,.bg-particles,.bg-vignette{position:absolute;inset:0;pointer-events:none}
    .bg-stage{
      background:
        linear-gradient(90deg, rgba(255,255,255,.03), transparent 12%, transparent 88%, rgba(255,255,255,.03)),
        radial-gradient(90% 45% at 50% 100%, rgba(49,168,255,.14), transparent 65%);
      opacity:.9;
    }
    .bg-lights::before,.bg-lights::after{
      content:"";position:absolute;border-radius:999px;filter:blur(22px);opacity:.42;animation:drift 7s ease-in-out infinite alternate;
    }
    .bg-lights::before{width:46%;height:18%;left:4%;top:10%;background:rgba(164,82,255,.34)}
    .bg-lights::after{width:56%;height:20%;right:-4%;top:12%;background:rgba(49,168,255,.26);animation-duration:8.5s}
    .bg-floor{top:auto;height:34%;background:radial-gradient(75% 90% at 50% 100%, rgba(255,211,92,.13), transparent 58%),linear-gradient(180deg, transparent, rgba(0,0,0,.15) 40%, rgba(0,0,0,.42));}
    .bg-particles::before,.bg-particles::after{content:"";position:absolute;inset:-20%;background-image:radial-gradient(circle, rgba(255,255,255,.16) 0 1px, transparent 1.2px);background-size:26px 26px;opacity:.17;animation:particleFloat 22s linear infinite}
    .bg-particles::after{background-size:32px 32px;opacity:.1;animation-duration:28s;animation-direction:reverse}
    .bg-vignette{background:radial-gradient(circle at 50% 35%, transparent 28%, rgba(0,0,0,.16) 58%, rgba(0,0,0,.52) 100%)}

    .shell{
      position:relative;z-index:2;height:100%;padding:calc(var(--safe-top) + 8px) 12px calc(var(--safe-bottom) + 10px);
      display:grid;grid-template-rows:auto 1fr auto auto auto;gap:8px;
    }

    .topbar{
      position:relative;
      min-height:var(--top-h);
      display:grid;grid-template-columns:minmax(0,1fr) auto;grid-template-rows:auto auto;gap:4px 6px;align-items:stretch;
    }
    .balance-card,.top-actions,.bet-card,.chip-rail,.recent-strip,.card-panel,.banner,.popup,.hero-panel,.network-pill{
      backdrop-filter:blur(16px);
      -webkit-backdrop-filter:blur(16px);
      background:linear-gradient(180deg, rgba(255,255,255,.11), rgba(255,255,255,.045));
      border:1px solid var(--stroke);
      box-shadow:var(--shadow), inset 0 1px 0 rgba(255,255,255,.08);
    }
    .balance-card,.top-actions,.bet-card,.chip-rail,.recent-strip,.card-panel,.banner,.popup,.hero-panel,.network-pill{position:relative;overflow:hidden;backdrop-filter:blur(20px) saturate(128%);-webkit-backdrop-filter:blur(20px) saturate(128%);border-color:rgba(255,255,255,.18)}
    .balance-card::before,.top-actions::before,.bet-card::before,.chip-rail::before,.recent-strip::before,.card-panel::before,.hero-panel::before{content:"";position:absolute;inset:0;background:linear-gradient(120deg, rgba(255,255,255,.18), rgba(255,255,255,.05) 32%, transparent 58%);opacity:.44;pointer-events:none}
    .bet-card{box-shadow:0 16px 30px rgba(0,0,0,.34), inset 0 1px 0 rgba(255,255,255,.16), inset 0 -14px 26px rgba(32,10,70,.08)}
    .balance-card{
      border-radius:22px;padding:10px 14px;display:flex;align-items:center;justify-content:space-between;gap:12px;min-width:0;
      background:linear-gradient(180deg, rgba(19,24,52,.92), rgba(10,13,31,.82));
    }
    .balance-left{display:flex;flex-direction:column;min-width:0}
    .balance-label{font-size:11px;letter-spacing:.18em;text-transform:uppercase;color:#d6dcff;opacity:.8}
    .balance-value{font-weight:900;font-size:24px;letter-spacing:.02em;white-space:nowrap;display:flex;align-items:center;gap:8px}
    .balance-value .coin{width:24px;height:24px;border-radius:50%;display:grid;place-items:center;background:radial-gradient(circle at 30% 30%, #fff8c0, #ffcf58 58%, #9f6a08);color:#3b2702;font-size:13px;box-shadow:0 0 18px rgba(255,211,92,.28)}
    .balance-sub{font-size:11px;color:var(--muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .top-actions{border-radius:22px;padding:8px;display:flex;align-items:center;gap:8px;background:linear-gradient(180deg, rgba(20,25,58,.92), rgba(12,14,31,.84))}

    .balance-card{position:relative;overflow:hidden}
    .balance-card::after{content:"";position:absolute;inset:-40% auto auto -10%;width:56%;height:180%;background:linear-gradient(115deg, rgba(49,168,255,.08), rgba(255,77,184,.06), transparent 72%);transform:rotate(12deg);pointer-events:none}
    .balance-left{display:flex;align-items:center;min-width:0;gap:10px}
    .balance-label,.balance-sub{display:none}
    .balance-value{font-weight:1000;font-size:24px;letter-spacing:.02em;white-space:nowrap;display:flex;align-items:center;gap:10px}
    .balance-value .coin{width:28px;height:28px;border-radius:50%;display:grid;place-items:center;background:radial-gradient(circle at 32% 28%, #eff7ff, #8ee6ff 30%, #57a3ff 56%, #5c30ff 78%, #2b114d);box-shadow:0 0 10px rgba(64,185,255,.35), 0 0 24px rgba(124,82,255,.22)}
    .balance-value .coin svg{width:16px;height:16px;fill:#d9fbff;filter:drop-shadow(0 0 8px rgba(151,245,255,.85))}
    .balance-card.up{box-shadow:0 0 0 1px rgba(57,217,138,.22), 0 0 28px rgba(57,217,138,.18), var(--shadow), inset 0 0 26px rgba(57,217,138,.06)}
    .balance-card.down{box-shadow:0 0 0 1px rgba(255,91,107,.18), 0 0 28px rgba(255,91,107,.14), var(--shadow), inset 0 0 24px rgba(255,91,107,.05)}
    .balance-value.up{color:#86ffbf;text-shadow:0 0 14px rgba(57,217,138,.26)}
    .balance-value.down{color:#ff97a6;text-shadow:0 0 14px rgba(255,91,107,.22)}
    .balance-delta{position:absolute;right:12px;top:10px;font-size:12px;font-weight:900;opacity:0;transform:translateY(0);pointer-events:none}
    .balance-delta.show{animation:balanceDrop .9s var(--ease) both}
    .balance-delta.up{color:#7cffb5;text-shadow:0 0 12px rgba(57,217,138,.38)}
    .balance-delta.down{color:#ff93aa;text-shadow:0 0 12px rgba(255,91,107,.34)}
    .network-pill{min-width:88px;justify-content:center;align-self:center}
    .player-flip-card{display:flex;align-items:center;gap:8px;min-height:18px;min-width:0}
    .player-flip-label{font-size:10px;font-weight:900;letter-spacing:.14em;text-transform:uppercase;color:rgba(219,231,255,.62)}
    .player-flip-value{display:inline-block;min-width:110px;max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:12px;font-weight:900;color:#f4f7ff;transform-origin:50% 0%;font-variant-numeric:tabular-nums}
    .player-flip-value.flip-out{animation:luckyPlayerFlipOut .26s ease forwards}
    .player-flip-value.flip-in{animation:luckyPlayerFlipIn .34s ease forwards}
    @keyframes luckyPlayerFlipOut{0%{opacity:1;transform:translateY(0) rotateX(0deg)}100%{opacity:0;transform:translateY(10px) rotateX(-90deg)}}
    @keyframes luckyPlayerFlipIn{0%{opacity:0;transform:translateY(-10px) rotateX(90deg)}100%{opacity:1;transform:translateY(0) rotateX(0deg)}}
    .network-pill{min-width:112px}
    .network-text{display:inline-block;width:52px;text-align:right;font-variant-numeric:tabular-nums}
    .round-chip b{display:inline-block;min-width:42px;text-align:right;font-variant-numeric:tabular-nums}
    .top-actions{padding:8px 10px;justify-content:flex-end;flex-wrap:nowrap}
    .app.lucky88-master .top-actions{padding:5px;gap:4px;border-radius:16px}
    .app.lucky88-master .icon-btn{width:33px;height:33px;border-radius:12px}
    .app.lucky88-master .icon-btn svg{width:16px;height:16px}
    .app.lucky88-master .balance-card{min-width:118px;padding:8px 9px;gap:7px}
    .app.lucky88-master .balance-value{font-size:15px;gap:6px}
    .app.lucky88-master .balance-value .coin{width:20px;height:20px;flex:0 0 20px}
    .app.lucky88-master .balance-value #balanceText{overflow:visible;text-overflow:clip;min-width:max-content}
    .app:not(.lucky7-pro) .top-actions{padding:5px;gap:4px;border-radius:16px}
    .app:not(.lucky7-pro) .icon-btn{width:33px;height:33px;border-radius:12px}
    .app:not(.lucky7-pro) .icon-btn svg{width:16px;height:16px}
    .app:not(.lucky7-pro) .balance-card{min-width:118px;padding:8px 9px;gap:7px}
    .app:not(.lucky7-pro) .balance-value{font-size:15px;gap:6px}
    .app:not(.lucky7-pro) .balance-value .coin{width:20px;height:20px;flex:0 0 20px}
    .app:not(.lucky7-pro) .balance-value #balanceText{overflow:visible;text-overflow:clip;min-width:max-content}
    .hero-head{display:flex;align-items:center;justify-content:space-between;gap:10px}
    .payout-chip{display:flex;align-items:center;gap:8px;padding:8px 12px;border-radius:999px;border:1px solid rgba(255,255,255,.12);background:linear-gradient(180deg, rgba(19,26,58,.84), rgba(10,14,30,.76));box-shadow:inset 0 1px 0 rgba(255,255,255,.08);font-size:11px;font-weight:900;letter-spacing:.04em;text-transform:uppercase;cursor:pointer;color:#eef3ff}
    .payout-chip b{color:var(--gold);font-size:12px}
    .payout-chip svg{width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:1.8}
    .bet-card,.chip,.action-box,.icon-btn{-webkit-user-select:none;user-select:none}
    .bet-card *,.chip *,.action-box *{pointer-events:none}
    .bet-card .bet-amount{pointer-events:none}
    .chip-bar{grid-template-columns:minmax(0,1fr) auto;gap:6px;align-items:center;min-width:0}
    .chip-rail{padding:8px 6px;overflow:visible;min-width:0}
    .chip-scroll{display:flex;align-items:center;justify-content:space-between;gap:clamp(4px,1.2vw,7px);width:100%;min-width:0;overflow:hidden}
    .chip.active{transform:translateY(-3px) scale(1.01)}
    .chip.active::after{inset:-3px;border-width:2px;box-shadow:0 0 0 1px rgba(255,211,92,.18), 0 0 20px rgba(255,211,92,.28)}
    .action-box{position:relative;overflow:hidden;min-width:68px;background:linear-gradient(180deg, rgba(40,26,89,.96), rgba(17,11,42,.9));transition:transform var(--dur-fast) var(--ease), box-shadow var(--dur-fast) var(--ease), border-color var(--dur-fast) var(--ease)}
    .action-box::before{content:"";position:absolute;inset:-20% -18%;background:linear-gradient(120deg, transparent 22%, rgba(255,255,255,.22) 46%, transparent 62%);transform:translateX(-140%)}
    .action-box b,.action-box span{position:relative;z-index:1;white-space:nowrap}
    .action-box:hover::before,.action-box.on::before{animation:actionSweep 2.2s linear infinite}
    .action-box#repeatBtn{border-color:rgba(49,168,255,.26);box-shadow:0 0 0 1px rgba(49,168,255,.09), 0 12px 26px rgba(31,92,255,.16), inset 0 0 20px rgba(49,168,255,.08)}
    .action-box#autoBetBtn{border-color:rgba(255,77,184,.24);box-shadow:0 0 0 1px rgba(255,77,184,.09), 0 12px 26px rgba(255,77,184,.16), inset 0 0 20px rgba(255,77,184,.08)}
    .action-box.toggle.on{box-shadow:0 0 0 1px rgba(255,211,92,.18), 0 0 26px rgba(255,77,184,.15), var(--shadow), inset 0 0 28px rgba(255,211,92,.08)}
    .banner-stack{left:10px;right:10px;top:calc(var(--safe-top) + 88px);z-index:14}
    .banner{width:100%;min-height:70px;border-radius:24px;padding:16px 18px;border:1px solid rgba(255,255,255,.12);box-shadow:0 16px 34px rgba(0,0,0,.32), inset 0 1px 0 rgba(255,255,255,.08)}
    .banner.start{background:linear-gradient(180deg, rgba(16,52,39,.96), rgba(8,20,18,.94))}
    .banner.stop{background:linear-gradient(180deg, rgba(70,46,14,.97), rgba(30,18,7,.94))}
    .banner.win{background:linear-gradient(180deg, rgba(54,26,89,.97), rgba(18,12,35,.95))}
    .banner.net{background:linear-gradient(180deg, rgba(72,18,28,.97), rgba(26,8,11,.95))}
    .banner-title{font-size:26px}
    .banner-sub{font-size:13px;color:#dbe2ff}
    @keyframes balanceDrop{0%{opacity:0;transform:translateY(8px) scale(.92)}20%{opacity:1}100%{opacity:0;transform:translateY(-16px) scale(1)}}
    @keyframes actionSweep{0%{transform:translateX(-140%)}100%{transform:translateX(140%)}}

    .icon-btn{
      flex:0 0 auto;width:42px;height:42px;border-radius:16px;border:1px solid rgba(255,255,255,.08);background:linear-gradient(180deg, rgba(255,255,255,.08), rgba(255,255,255,.03));color:#fff;display:grid;place-items:center;position:relative;cursor:pointer;transition:transform var(--dur-fast) var(--ease), box-shadow var(--dur-fast) var(--ease), border-color var(--dur-fast);
      box-shadow:inset 0 1px 0 rgba(255,255,255,.08), 0 8px 20px rgba(0,0,0,.2);
    }
    .icon-btn:active{transform:scale(.95)}
    .icon-btn svg{width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
    .icon-btn.active,.icon-btn:hover{border-color:rgba(255,211,92,.4);box-shadow:0 0 0 1px rgba(255,211,92,.18), 0 10px 26px rgba(255,211,92,.12), inset 0 1px 0 rgba(255,255,255,.12)}
    .network-pill{display:flex;align-items:center;gap:8px;padding:0 12px;border-radius:18px;min-width:86px;background:linear-gradient(180deg, rgba(18,23,50,.95), rgba(10,12,30,.82))}

    .topbar-meta{
      grid-column:1 / -1;
      display:grid;grid-template-columns:auto auto minmax(0,1fr);gap:4px;align-items:center;
      margin-top:0;min-width:0;position:relative;z-index:3;
    }
    .topbar-meta .round-chip,.topbar-meta .network-pill,.topbar-meta .payout-chip{min-width:0}
    .topbar-meta .payout-chip{justify-content:center;padding:7px 9px;font-size:10px;min-height:34px}

    .net-dot{width:10px;height:10px;border-radius:50%;background:var(--ok);box-shadow:0 0 12px currentColor;animation:pulseDot 1.7s ease-in-out infinite}
    .network-pill.bad .net-dot{background:var(--danger)}
    .network-pill.warn .net-dot{background:var(--warn)}
    .network-text{font-size:12px;font-weight:700;color:#edf1ff;white-space:nowrap}

    .hero-zone{position:relative;display:grid;grid-template-rows:1fr auto;gap:6px;min-height:0}
    .hero-panel{
      position:relative;border-radius:30px;padding:4px 4px 4px;
      background:
        radial-gradient(65% 55% at 50% 20%, rgba(255,211,92,.1), transparent 65%),
        linear-gradient(180deg, rgba(20,25,58,.84), rgba(9,12,26,.78));
      overflow:visible;
      min-height:0;
      isolation:isolate;
    }
    .hero-panel::before{
      content:"";position:absolute;left:50%;top:18%;width:78%;height:56%;transform:translateX(-50%);border-radius:999px;filter:blur(24px);background:radial-gradient(circle, rgba(49,168,255,.22), rgba(164,82,255,.15) 42%, transparent 72%);pointer-events:none;
    }
    .hero-meta{display:none !important}
    .hero-inner{position:relative;height:100%;display:flex;align-items:center;justify-content:center;min-height:0;padding:0;overflow:visible}

    .hero-head{display:none}
    .status-chip,.round-chip{
      display:inline-flex;align-items:center;gap:8px;border-radius:999px;padding:8px 12px;font-size:12px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1)
    }
    .status-chip b,.round-chip b{font-size:13px;color:var(--gold)}

    .wheel-wrap{position:relative;width:var(--wheel-actual,min(calc(var(--wheel-size) + 12px),100%));height:var(--wheel-actual,min(calc(var(--wheel-size) + 12px),100%));max-width:448px;max-height:448px;aspect-ratio:1 / 1;flex:0 0 auto;display:grid;place-items:center;filter:drop-shadow(0 16px 28px rgba(0,0,0,.28));margin-inline:auto}
    .wheel-aura,.wheel-shadow,.pointer-wrap,.wheel-frame,.wheel-inner,.wheel-center,.wheel-lights,.wheel-lock{
      position:absolute;inset:0;border-radius:50%;
    }
    .wheel-shadow{inset:auto 8% -6%;height:12%;border-radius:50%;filter:blur(10px);background:radial-gradient(circle, rgba(0,0,0,.55), transparent 68%)}
    .wheel-aura{inset:-10%;background:radial-gradient(circle, rgba(49,168,255,.18), transparent 44%),radial-gradient(circle at 50% 46%, rgba(255,77,184,.1), transparent 56%);filter:blur(22px);animation:aura 3.8s ease-in-out infinite}
    .wheel-frame{
      background:linear-gradient(145deg, #fff6bf 0%, #ffd972 22%, #e7a61b 48%, #8d5b09 82%, #4c2e00 100%);
      box-shadow:inset 0 3px 0 rgba(255,255,255,.6), inset 0 -10px 16px rgba(0,0,0,.45), 0 12px 30px rgba(0,0,0,.35);
      padding:14px;
    }
    .wheel-frame::before,.wheel-frame::after{content:"";position:absolute;border-radius:50%}
    .wheel-frame::before{inset:10px;border:2px solid rgba(86,46,0,.55)}
    .wheel-frame::after{inset:18px;border:2px solid rgba(255,241,185,.5);opacity:.5}
    .wheel-lock{inset:12px;border:1px dashed rgba(255,255,255,.08)}
    .wheel-lights{inset:8px;background:conic-gradient(from 0deg, rgba(255,255,255,.26), transparent 10%, transparent 22%, rgba(255,255,255,.11) 28%, transparent 40%, rgba(255,255,255,.16) 48%, transparent 66%, rgba(255,255,255,.1) 74%, transparent 100%);mix-blend-mode:screen;opacity:.28;animation:sweep 7s linear infinite}
    .wheel-inner{
      inset:20px;overflow:hidden;background:radial-gradient(circle at 50% 27%, #3191ff 0%, #135ddf 36%, #0837a3 64%, #03143a 100%);transform:rotate(-18deg);transition:transform 6s cubic-bezier(.16,.88,.14,1);box-shadow:inset 0 1px 0 rgba(255,255,255,.24), inset 0 -10px 16px rgba(0,0,0,.22)
    }
    .wheel-inner::before{content:"";position:absolute;inset:0;background:radial-gradient(circle at 50% 18%, rgba(255,255,255,.26), transparent 34%), linear-gradient(180deg, rgba(255,255,255,.08), transparent 30%, transparent 76%, rgba(0,0,0,.16));pointer-events:none}
    .wheel-inner::after{content:"";position:absolute;inset:9px;border-radius:50%;border:1px solid rgba(255,255,255,.18);box-shadow:inset 0 0 0 1px rgba(255,255,255,.05)}
    .seg{position:absolute;inset:0;transform-origin:50% 50%;clip-path:polygon(50% 50%, 50% 0%, 80.9017% 4.8943%, 100% 30.9017%, 100% 50%)}
    .seg::before{content:"";position:absolute;left:49.55%;top:0;width:2px;height:52%;transform:translateX(-50%);background:linear-gradient(180deg, rgba(255,255,255,.9), rgba(255,255,255,.14));opacity:.9}
    .seg:nth-child(odd){background:linear-gradient(180deg, #2d78ff 0%, #0a4ec9 58%, #063a96 100%)}
    .seg:nth-child(even){background:linear-gradient(180deg, #2495ff 0%, #0a69d0 58%, #0a4896 100%)}
    .seg.golden{background:linear-gradient(180deg, #ffe48a 0%, #ffc846 38%, #ce8a08 76%, #815101 100%)}
    .seg.golden::before{background:linear-gradient(180deg, rgba(255,255,255,.95), rgba(255,249,220,.18))}
    .seat{position:absolute;left:50%;top:50%;width:34%;height:18.5%;transform:translate(-50%,-50%);border-radius:999px 999px 15px 15px;background:linear-gradient(180deg, rgba(255,255,255,.23), rgba(255,255,255,.05));box-shadow:inset 0 1px 0 rgba(255,255,255,.24), inset 0 -6px 12px rgba(0,0,0,.18), 0 2px 10px rgba(0,0,0,.12)}
    .seat::before{content:"";position:absolute;inset:8% 12% auto;height:30%;border-radius:999px;background:linear-gradient(180deg, rgba(255,255,255,.34), rgba(255,255,255,.04));opacity:.95}
    .seat.slot-seat{width:39%;height:21%;border-radius:24px 24px 15px 15px;background:linear-gradient(180deg, rgba(255,245,194,.34), rgba(255,255,255,.08))}
    .seg.golden .seat{background:linear-gradient(180deg, rgba(255,255,255,.24), rgba(255,255,255,.07))}
    .seg .label{position:absolute;left:50%;top:50%;width:54px;height:54px;transform:translate(-50%,-50%);display:grid;place-items:center;filter:drop-shadow(0 6px 8px rgba(0,0,0,.3))}
    .seg .label.slot-label{width:62px;height:62px}
    .seg .label .label-core{display:grid;place-items:center;width:100%;height:100%;transform-origin:center}
    .fruit-icon{width:44px;height:44px;display:block;overflow:visible}
    .recent-board-icon,.history-board-icon{display:grid;place-items:center;line-height:1}
    .recent-board-icon{width:18px;height:18px}
    .history-board-icon{width:22px;height:22px}
    .recent-board-icon .fruit-icon,.history-board-icon .fruit-icon{width:100%;height:100%}
    .slot77{font-size:34px;font-weight:1000;font-style:italic;letter-spacing:-1.4px;line-height:1;color:#ff38c6;-webkit-text-stroke:1.6px #fff7a6;text-shadow:0 0 18px rgba(255,56,198,.7), 0 3px 0 rgba(77,17,54,.8)}
    .seg.winner{filter:brightness(1.24) saturate(1.18);animation:segWinnerPulse 1s ease-in-out infinite}
    .seg.winner::after{background:radial-gradient(circle at 50% 18%, rgba(255,255,255,.24), transparent 28%), linear-gradient(180deg, rgba(255,255,255,.18), rgba(255,255,255,0) 18%, rgba(49,168,255,.16) 56%, rgba(255,77,184,.14) 78%, rgba(0,0,0,.12) 100%);animation:segWinnerWave 1.12s ease-in-out infinite}
    .seg.winner .seat{box-shadow:0 0 0 1px rgba(255,255,255,.14), 0 0 26px rgba(255,211,92,.35), inset 0 1px 0 rgba(255,255,255,.28)}
    .seg.winner .label{filter:drop-shadow(0 0 16px rgba(255,255,255,.22)) drop-shadow(0 0 20px rgba(255,211,92,.42))}

    .pointer-wrap{inset:-8px auto auto 50%;width:46px;height:54px;transform:translateX(-50%);z-index:6}
    .pointer{position:absolute;inset:0;clip-path:polygon(50% 100%, 0 0, 100% 0);background:linear-gradient(180deg, #fff8d0, #ffd669 42%, #ba7b0d 100%);filter:drop-shadow(0 8px 10px rgba(0,0,0,.42))}
    .pointer-gem{position:absolute;left:50%;top:-6px;transform:translateX(-50%);width:26px;height:26px;border-radius:50%;background:radial-gradient(circle at 35% 30%, #fff, #ffcb4e 48%, #865101 100%);box-shadow:0 0 18px rgba(255,211,92,.45), inset 0 1px 0 rgba(255,255,255,.75)}
    .pointer-wrap.tick{animation:tick .18s ease-out}
    .pointer-wrap.hit{animation:hit .38s ease-out}

    .wheel-center{inset:37%;display:grid;place-items:center;background:radial-gradient(circle at 50% 35%, #2330a9, #081755 74%, #050b2b 100%);border:4px solid rgba(255,231,157,.96);box-shadow:inset 0 0 14px rgba(255,255,255,.1), inset 0 -10px 14px rgba(0,0,0,.42), 0 0 0 6px rgba(94,61,0,.5)}
    .wheel-center::before{content:"";position:absolute;inset:7px;border-radius:50%;border:1px solid rgba(255,255,255,.18)}
    .counter{font-size:34px;font-weight:1000;color:#fff8d0;text-shadow:0 0 18px rgba(255,211,92,.42), 0 4px 12px rgba(0,0,0,.5)}
    .counter.small{font-size:16px;letter-spacing:.14em;text-transform:uppercase}
    .counter.timer-hidden{opacity:0;visibility:hidden}

    .recent-strip{min-height:var(--recent-h);border-radius:18px;padding:8px 12px;display:flex;align-items:center;gap:10px;background:linear-gradient(180deg, rgba(16,20,44,.86), rgba(8,11,26,.7));overflow:hidden}
    .recent-label{font-size:11px;text-transform:uppercase;letter-spacing:.16em;font-weight:900;color:#fff;background:linear-gradient(180deg, rgba(255,77,184,.95), rgba(161,45,127,.84));border-radius:999px;padding:6px 9px;box-shadow:0 0 16px rgba(255,77,184,.22);white-space:nowrap}
    .recent-track{display:flex;gap:8px;min-width:0;overflow:hidden}
    .recent-pill{min-width:34px;height:24px;border-radius:999px;display:grid;place-items:center;padding:0 8px;font-size:13px;font-weight:900;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.08)}
    .recent-pill.slot{color:#ff79d2}

    .bets{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:10px;min-height:var(--bet-h)}
    .bet-card{
      position:relative;border-radius:24px;padding:10px 10px 12px;background:linear-gradient(180deg, rgba(28,36,81,.9), rgba(13,18,38,.84));display:grid;grid-template-rows:auto 1fr auto;align-items:center;justify-items:center;gap:6px;cursor:pointer;transition:transform var(--dur-fast) var(--ease), box-shadow var(--dur-fast) var(--ease), border-color var(--dur-fast);
      overflow:hidden;
    }
    .bet-card::before{content:"";position:absolute;inset:0;background:linear-gradient(145deg, rgba(255,255,255,.1), transparent 35%, transparent 60%, rgba(255,255,255,.03));pointer-events:none}
    .bet-card::after{content:"";position:absolute;inset:-30% -20%;background:linear-gradient(115deg, transparent 20%, rgba(255,255,255,.12) 46%, transparent 60%);transform:translateX(-140%);transition:transform .8s ease;pointer-events:none}
    .bet-card.win::after,.popup.shine::before,.banner.shine::before{transform:translateX(140%)}
    .bet-card:active{transform:scale(.97)}
    .bet-card.active{border-color:rgba(255,211,92,.36);box-shadow:0 0 0 1px rgba(255,211,92,.18), 0 18px 32px rgba(0,0,0,.26), inset 0 1px 0 rgba(255,255,255,.12)}
    .bet-card.disabled{opacity:.55;filter:saturate(.72);pointer-events:none}
    .bet-amount{font-size:15px;font-weight:900;color:#e9efff;background:rgba(255,255,255,.06);padding:6px 10px;border-radius:999px;min-width:56px;text-align:center}
    .bet-icon-wrap{position:relative;width:56px;height:56px;border-radius:50%;display:grid;place-items:center;background:radial-gradient(circle at 30% 30%, rgba(255,255,255,.16), rgba(255,255,255,.04));box-shadow:inset 0 1px 0 rgba(255,255,255,.18), inset 0 -10px 14px rgba(0,0,0,.18)}
    .bet-slot{font-size:36px}
    .bet-multi{font-weight:1000;font-size:19px;color:var(--gold);text-shadow:0 0 12px rgba(255,211,92,.28)}

    .chip-bar{
      min-height:var(--chip-h);display:grid;grid-template-columns:minmax(0,1fr) auto;gap:8px;align-items:stretch;min-width:0;
    }
    .chip-rail{border-radius:24px;padding:9px 8px 10px;display:flex;align-items:center;gap:6px;background:linear-gradient(180deg, rgba(18,25,58,.94), rgba(8,12,28,.88));overflow:visible;min-width:0;box-shadow:0 0 0 1px rgba(255,255,255,.06), 0 14px 28px rgba(0,0,0,.28), inset 0 1px 0 rgba(255,255,255,.08)}
    .chip-scroll{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));align-items:center;justify-items:center;gap:6px;overflow:visible;scrollbar-width:none;min-width:0;max-width:100%;padding:0 2px;scroll-snap-type:none;width:100%}
    .chip-scroll::-webkit-scrollbar{display:none}
    .chip{
      position:relative;flex:0 0 auto;width:clamp(38px,9.5vw,54px);height:clamp(38px,9.5vw,54px);border-radius:50%;display:grid;place-items:center;cursor:pointer;transition:transform var(--dur-fast) var(--ease), filter var(--dur-fast) var(--ease), box-shadow var(--dur-fast) var(--ease);background:none;border:none;padding:0;min-width:0;scroll-snap-align:none;z-index:1;isolation:isolate;
    }
    .chip svg{width:100%;height:100%;display:block;filter:drop-shadow(0 8px 14px rgba(0,0,0,.22))}
    .chip-label{position:absolute;inset:0;display:grid;place-items:center;font-size:clamp(9px,2.5vw,12px);font-weight:1000;color:#fff;text-shadow:0 1px 3px rgba(0,0,0,.55)}
    .chip.active{transform:translateY(-2px) scale(1.015);z-index:4;filter:drop-shadow(0 6px 16px rgba(255,211,92,.24))}
    .chip.active::after{content:"";position:absolute;inset:-4px;border-radius:50%;border:2px solid rgba(255,211,92,.96);box-shadow:0 0 0 1px rgba(255,211,92,.22), 0 0 18px rgba(255,211,92,.36);animation:chipBlink 1s ease-in-out infinite;pointer-events:none;z-index:3}
    .chip.active::before{content:"";position:absolute;inset:-8px;border-radius:50%;background:radial-gradient(circle, rgba(255,211,92,.18), rgba(255,211,92,0) 68%);pointer-events:none;z-index:0}
    .chip.purple{--c1:#b872ff;--c2:#6123d9;--c3:#25006b}
    .chip.orange{--c1:#ffcb73;--c2:#ff8c1f;--c3:#8c3900}
    .chip.green{--c1:#7effb0;--c2:#10c761;--c3:#046939}
    .chip.blue{--c1:#7dd8ff;--c2:#2796ff;--c3:#005db8}
    .chip.gold{--c1:#fff0ad;--c2:#f5c33a;--c3:#976000}

    .action-stack{display:flex;gap:6px;flex-shrink:0;align-items:stretch}
    .action-box{min-width:66px;border-radius:20px;padding:9px 8px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:5px;background:linear-gradient(180deg, rgba(24,31,70,.96), rgba(10,12,28,.9));border:1px solid rgba(255,255,255,.08);box-shadow:0 0 0 1px rgba(255,255,255,.05), 0 14px 28px rgba(0,0,0,.28), inset 0 1px 0 rgba(255,255,255,.08);cursor:pointer;position:relative;overflow:hidden}
    .action-box b{font-size:11px;letter-spacing:.08em;text-transform:uppercase}
    .action-box span{font-size:10px;color:var(--muted)}
    .action-box.toggle.on{box-shadow:0 0 0 1px rgba(255,211,92,.18), 0 0 22px rgba(255,211,92,.16), 0 14px 28px rgba(0,0,0,.28), inset 0 0 24px rgba(255,211,92,.08)}
    .action-box::before{content:"";position:absolute;inset:-30% -20%;background:linear-gradient(120deg, transparent 22%, rgba(255,255,255,.22) 46%, transparent 62%);transform:translateX(-145%)}
    .action-box::after{content:"";position:absolute;inset:auto -10% -35% -10%;height:65%;background:radial-gradient(circle at 50% 0%, rgba(255,255,255,.16), transparent 65%);pointer-events:none}
    .action-box:hover::before,.action-box.on::before{animation:actionSweep 2.2s linear infinite}
    .action-box#repeatBtn{background:linear-gradient(180deg, rgba(32,66,146,.96), rgba(12,28,74,.92));border-color:rgba(97,188,255,.28);box-shadow:0 0 0 1px rgba(97,188,255,.12), 0 14px 28px rgba(32,103,255,.2), inset 0 1px 0 rgba(255,255,255,.12), inset 0 0 28px rgba(97,188,255,.08)}
    .action-box#autoBetBtn{background:linear-gradient(180deg, rgba(132,33,108,.96), rgba(63,14,65,.92));border-color:rgba(255,113,214,.28);box-shadow:0 0 0 1px rgba(255,113,214,.12), 0 14px 28px rgba(255,77,184,.2), inset 0 1px 0 rgba(255,255,255,.12), inset 0 0 28px rgba(255,113,214,.08)}

    .banner-stack{position:absolute;left:16px;right:16px;top:calc(var(--safe-top) + 80px);display:flex;flex-direction:column;gap:10px;pointer-events:none;z-index:11}
    .banner{
      position:relative;border-radius:20px;padding:16px 18px;display:none;align-items:center;justify-content:center;text-align:center;overflow:hidden;background:linear-gradient(180deg, rgba(24,31,68,.96), rgba(12,16,34,.94));
    }
    .banner::before,.popup.shine::before,.banner.shine::before{content:"";position:absolute;inset:-10% -30%;background:linear-gradient(115deg, transparent 25%, rgba(255,255,255,.16) 45%, transparent 60%);transform:translateX(-140%)}
    .banner.show{display:flex;animation:bannerIn .32s var(--ease) both}
    .banner-title{font-size:24px;font-weight:1000;letter-spacing:.06em;text-transform:uppercase}
    .banner-sub{font-size:12px;color:var(--muted);margin-top:4px}
    .banner.start{border-color:rgba(57,217,138,.34)}
    .banner.stop{border-color:rgba(255,176,46,.36)}
    .banner.win{border-color:rgba(255,211,92,.42)}
    .banner.net{border-color:rgba(255,91,107,.34)}

    .utility-toast{position:absolute;left:50%;bottom:calc(var(--safe-bottom) + 100px);transform:translateX(-50%) translateY(12px);padding:10px 16px;border-radius:999px;background:rgba(7,10,20,.94);border:1px solid rgba(255,255,255,.12);font-size:13px;font-weight:800;opacity:0;pointer-events:none;z-index:12;transition:opacity .18s ease, transform .18s ease}
    .utility-toast.show{opacity:1;transform:translateX(-50%) translateY(0)}

    .chip-fly-layer,.spark-layer,.confetti-layer{position:absolute;inset:0;pointer-events:none;z-index:9;overflow:hidden}
    .fly-chip{position:absolute;width:22px;height:22px;border-radius:50%;background:radial-gradient(circle at 35% 30%, #fff6ca, #ffca4d 58%, #996100);box-shadow:0 0 18px rgba(255,211,92,.35);animation:flyChip .85s cubic-bezier(.18,.82,.16,1) forwards}
    .spark{position:absolute;width:8px;height:8px;border-radius:50%;background:radial-gradient(circle,#fff, rgba(255,211,92,.7) 55%, rgba(255,211,92,0));animation:spark .52s ease-out forwards}
    .confetti{position:absolute;width:8px;height:14px;border-radius:3px;background:linear-gradient(180deg,#fff,#ffd35c);animation:confetti 1.2s ease-in forwards}
    .lucky-payout-amount{position:fixed;pointer-events:none;z-index:24;font-size:15px;font-weight:1000;letter-spacing:.14em;text-transform:uppercase;white-space:nowrap}
    .lucky-payout-amount.slot{color:#fff5bf;text-shadow:0 0 14px rgba(255,211,92,.58), 0 0 26px rgba(49,168,255,.22)}
    .lucky-payout-amount.melon{color:#ffe7ef;text-shadow:0 0 14px rgba(255,111,151,.48), 0 0 22px rgba(255,211,92,.14)}
    .lucky-payout-amount.plum{color:#efe5ff;text-shadow:0 0 14px rgba(145,120,255,.48), 0 0 22px rgba(49,168,255,.16)}
    .lucky-payout-gem{position:fixed;width:24px;height:24px;pointer-events:none;z-index:23;transform-origin:50% 50%;filter:drop-shadow(0 0 12px rgba(255,255,255,.16))}
    .lucky-payout-gem::before,.lucky-payout-gem::after{content:"";position:absolute;inset:0}
    .lucky-payout-gem::before{clip-path:polygon(50% 0, 100% 50%, 50% 100%, 0 50%);border-radius:6px}
    .lucky-payout-gem::after{inset:6px;clip-path:polygon(50% 0, 100% 50%, 50% 100%, 0 50%);background:rgba(255,255,255,.34);mix-blend-mode:screen}
    .lucky-payout-gem.slot::before{background:linear-gradient(180deg, #fff4bc 0%, #ffd35c 34%, #ff9f1a 68%, #6a3600 100%);box-shadow:0 0 16px rgba(255,211,92,.42), 0 0 24px rgba(49,168,255,.18)}
    .lucky-payout-gem.melon::before{background:linear-gradient(180deg, #ffdce8 0%, #ff8fb1 34%, #ff4d7c 68%, #671126 100%);box-shadow:0 0 16px rgba(255,107,147,.36), 0 0 22px rgba(255,211,92,.12)}
    .lucky-payout-gem.plum::before{background:linear-gradient(180deg, #f2e8ff 0%, #b994ff 34%, #7b5bff 68%, #241056 100%);box-shadow:0 0 16px rgba(143,116,255,.38), 0 0 22px rgba(49,168,255,.14)}

    .overlay{position:absolute;inset:0;display:none;align-items:center;justify-content:center;padding:18px;background:rgba(3,6,14,.68);backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px);z-index:20}
    .overlay.show{display:flex;animation:fadeIn .22s ease both}

    .app.splashing .shell{pointer-events:none}
    .app.splashing .splash{pointer-events:auto}
    .bet-card.win{animation:betWinBlink 1.15s ease-in-out infinite;box-shadow:0 0 0 1px rgba(255,211,92,.3), 0 0 26px rgba(49,168,255,.22), 0 0 38px rgba(255,77,184,.2), inset 0 0 26px rgba(49,168,255,.1);overflow:visible}
    .bet-card.win::before{
      background:
        radial-gradient(circle at 18% 22%, rgba(255,255,255,.24), transparent 24%),
        radial-gradient(circle at 50% 50%, rgba(49,168,255,.28), transparent 56%),
        radial-gradient(circle at 80% 78%, rgba(255,77,184,.24), transparent 30%),
        linear-gradient(145deg, rgba(255,255,255,.16), transparent 35%, transparent 60%, rgba(255,255,255,.04));
      animation:betWinWave 1.2s ease-out infinite;
    }
    .bet-card.win .bet-icon-wrap{animation:winHop .68s var(--ease) infinite; box-shadow:0 0 0 1px rgba(255,255,255,.18), 0 0 20px rgba(49,168,255,.26), 0 0 30px rgba(255,77,184,.24), inset 0 1px 0 rgba(255,255,255,.18)}
    @keyframes winHop{0%,100%{transform:translateY(0) scale(1)}42%{transform:translateY(-7px) scale(1.06)}}
    @keyframes betWinBlink{0%,100%{filter:saturate(1) brightness(1)}50%{filter:saturate(1.28) brightness(1.16)}}
    @keyframes betWinWave{0%{transform:scale(.9);opacity:.2}45%{transform:scale(1.05);opacity:.78}100%{transform:scale(1.18);opacity:0}}
    @keyframes segWinnerPulse{0%,100%{filter:brightness(1.24) saturate(1.18)}50%{filter:brightness(1.36) saturate(1.34)}}
    @keyframes segWinnerWave{0%,100%{opacity:.62}50%{opacity:.98}}
    @keyframes winnerSeatWave{0%{transform:scale(.72);opacity:0}18%{opacity:.82}100%{transform:scale(1.4);opacity:0}}
    @keyframes winnerSeatFloat{0%,100%{transform:translate(-50%,-50%) scale(1)}50%{transform:translate(-50%,-54%) scale(1.08)}}
    .popup{
      position:relative;width:min(100%,360px);max-height:min(78dvh,560px);overflow:auto;border-radius:28px;padding:20px 18px;background:linear-gradient(180deg, rgba(20,26,56,.96), rgba(8,12,24,.96));
    }
    .popup::-webkit-scrollbar{width:8px}
    .popup::-webkit-scrollbar-thumb{background:rgba(255,255,255,.12);border-radius:999px}
    .popup-head{display:flex;align-items:center;justify-content:space-between;gap:10px;margin-bottom:12px}
    .popup-title{font-size:22px;font-weight:1000}
    .popup-sub{font-size:13px;color:var(--muted);line-height:1.5}
    .popup-close{width:38px;height:38px;border-radius:14px;border:1px solid rgba(255,255,255,.1);background:rgba(255,255,255,.05);display:grid;place-items:center;color:#fff;cursor:pointer}
    .tile-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px;margin-top:14px}
    .tile{border-radius:20px;padding:14px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.08)}
    .tile b{display:block;font-size:13px;margin-bottom:6px}
    .tile span{font-size:12px;color:var(--muted);line-height:1.4}
    .active-user-grid{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:6px;margin-top:0}
    .active-user-card{display:grid;gap:5px;justify-items:center;align-content:start;min-width:0;padding:8px 4px;border-radius:12px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.08);text-align:center}
    .active-user-avatar{width:38px;height:38px;border-radius:13px;overflow:hidden;display:grid;place-items:center;background:radial-gradient(circle at 35% 25%,#fff7d1,#ffbd3d 56%,#8f4700 100%);box-shadow:0 8px 14px rgba(0,0,0,.28);color:#401700;font-weight:1000;font-size:15px}
    .active-user-avatar img{width:100%;height:100%;display:block;object-fit:cover}
    .active-user-card b{max-width:100%;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:9px;line-height:1.15;color:#fff7d5}
    .active-user-card span{font-size:8px;line-height:1.15;color:var(--muted);white-space:nowrap}
    .history-list{display:grid;gap:10px;margin-top:14px}
    .history-item{display:grid;grid-template-columns:auto 1fr auto;gap:10px;align-items:center;border-radius:18px;padding:12px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.08)}
    .history-item .mark{width:34px;height:34px;border-radius:50%;display:grid;place-items:center;background:rgba(255,255,255,.08);font-weight:900}
    .history-item .name{font-size:13px;font-weight:800}
    .history-item .meta{font-size:11px;color:var(--muted)}
    .history-stack{display:grid;gap:14px;margin-top:14px}
    .history-panel{padding:14px;border-radius:22px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.08)}
    .history-panel-head{display:flex;align-items:center;justify-content:space-between;gap:10px;margin-bottom:10px}
    .history-panel-title{font-size:14px;font-weight:900;letter-spacing:.08em;text-transform:uppercase}
    .history-panel-sub{font-size:11px;color:var(--muted)}
    .history-table-wrap{border-radius:18px;overflow:auto;border:1px solid rgba(255,255,255,.08)}
    .history-table{width:100%;border-collapse:collapse;font-size:12px}
    .history-table th,.history-table td{padding:10px 12px;text-align:left;vertical-align:top}
    .history-table th{position:sticky;top:0;background:rgba(15,19,34,.96);font-size:10px;letter-spacing:.16em;text-transform:uppercase;color:rgba(255,255,255,.74);z-index:1}
    .history-table tbody tr:nth-child(odd){background:rgba(255,255,255,.03)}
    .history-table tbody tr:nth-child(even){background:rgba(255,255,255,.06)}
    .history-table-empty{padding:14px;border-radius:16px;background:rgba(255,255,255,.04);color:var(--muted);text-align:center}
    .history-board-cell{display:flex;align-items:center;gap:8px;min-width:0}
    .history-board-cell .mark{width:30px;height:30px;border-radius:50%;display:grid;place-items:center;background:rgba(255,255,255,.08);flex:0 0 30px}
    .history-board-matrix{table-layout:fixed}
    .history-board-matrix th,.history-board-matrix td{text-align:center}
    .history-board-matrix th:first-child,.history-board-matrix td:first-child{width:46px}
    .history-board-matrix th:last-child,.history-board-matrix td:last-child{width:58px}
    .history-board-matrix .history-trace{text-align:left}
    .history-board-matrix th{font-size:9px;letter-spacing:.08em;padding-inline:5px}
    .history-board-matrix td{height:38px;padding:6px 5px}
    .history-board-matrix .history-status{padding:3px 5px;font-size:8px;letter-spacing:.06em;white-space:normal}
    .history-board-label{color:#ffe7a4}
    .history-board-token-cell{background:rgba(255,255,255,.025)}
    .history-board-token-cell.is-winner{background:radial-gradient(circle at 50% 45%,rgba(255,228,121,.18),transparent 64%),rgba(255,255,255,.07)}
    .history-board-token{width:30px;height:30px;margin:0 auto;border-radius:50%;display:grid;place-items:center;background:rgba(255,255,255,.09);border:1px solid rgba(255,231,154,.32);font-size:13px;font-weight:1000;line-height:1;box-shadow:0 7px 12px rgba(0,0,0,.24);overflow:hidden}
    .history-board-token.slot{color:#ff79d2}
    .history-board-token .history-board-icon,.history-board-token .fruit-icon{width:22px;height:22px}
    .history-trace{font-size:11px;line-height:1.35;word-break:break-word;color:rgba(255,255,255,.88)}
    .history-status{display:inline-flex;align-items:center;justify-content:center;padding:4px 8px;border-radius:999px;font-size:10px;font-weight:900;letter-spacing:.12em;text-transform:uppercase;white-space:nowrap}
    .history-status.win{background:rgba(71,232,150,.14);color:#7df0b4;border:1px solid rgba(71,232,150,.22)}
    .history-status.loss{background:rgba(255,106,142,.14);color:#ff9fb9;border:1px solid rgba(255,106,142,.22)}
    .history-status.pending{background:rgba(255,214,111,.14);color:#ffd86a;border:1px solid rgba(255,214,111,.22)}
    .history-status.punishment{background:rgba(255,173,92,.14);color:#ffc98f;border:1px solid rgba(255,173,92,.22)}
    .switch-row,.range-row{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:12px 0;border-bottom:1px solid rgba(255,255,255,.06)}
    .switch-row:last-child,.range-row:last-child{border-bottom:none}
    .switch-label{font-size:14px;font-weight:800}
    .switch-sub{font-size:12px;color:var(--muted);margin-top:3px}
    .switch{position:relative;width:54px;height:32px;border-radius:999px;background:rgba(255,255,255,.1);cursor:pointer;border:1px solid rgba(255,255,255,.1);transition:background .2s}
    .switch::after{content:"";position:absolute;top:3px;left:3px;width:24px;height:24px;border-radius:50%;background:#fff;transition:left .22s ease}
    .switch.on{background:rgba(255,211,92,.35)}
    .switch.on::after{left:25px}
    input[type="range"]{width:120px}
    .popup-cta{margin-top:16px;width:100%;height:48px;border-radius:16px;border:none;background:linear-gradient(180deg, #ffe18a, #f1b92f 68%, #a96b00);color:#352400;font-weight:1000;box-shadow:0 14px 28px rgba(255,211,92,.18);cursor:pointer}

    .splash{position:absolute;inset:0;z-index:30;display:flex;align-items:center;justify-content:center;background:radial-gradient(circle at 50% 30%, rgba(255,211,92,.12), transparent 36%), linear-gradient(180deg,#180d34 0%,#080b16 100%);transition:opacity .42s ease, visibility .42s ease}
    .splash.hide{opacity:0;visibility:hidden;pointer-events:none;display:none}
    .splash-box{width:min(86%,340px);border-radius:30px;padding:24px 22px;background:linear-gradient(180deg, rgba(21,28,58,.94), rgba(10,12,26,.94));border:1px solid rgba(255,255,255,.1);box-shadow:0 24px 70px rgba(0,0,0,.45);text-align:center}
    .brand{font-size:38px;font-weight:1000;letter-spacing:.04em;background:linear-gradient(180deg,#fff7c7,#ffd35c 66%,#c98a0d);-webkit-background-clip:text;background-clip:text;color:transparent;text-shadow:0 8px 22px rgba(255,211,92,.16)}
    .brand-sub{margin-top:4px;font-size:12px;letter-spacing:.24em;text-transform:uppercase;color:#d6dcff;opacity:.84}
    .splash-loader{height:12px;border-radius:999px;margin-top:20px;background:rgba(255,255,255,.08);overflow:hidden}
    .splash-fill{height:100%;width:0;border-radius:999px;background:linear-gradient(90deg,#4b6fff,#ff4db8,#ffd35c);transition:width .22s ease}
    .splash-log{margin-top:14px;font-size:12px;color:#cfd7f8;min-height:18px}


    .wheel-icon-seat{position:absolute;transform:translate(-50%,-50%);display:grid;place-items:center;border-radius:50%;z-index:3;pointer-events:none;overflow:visible;
      background:radial-gradient(circle at 50% 32%, rgba(255,255,255,.42), rgba(255,255,255,.14) 34%, rgba(255,255,255,.08) 52%, rgba(0,0,0,.12) 100%);
      border:1px solid rgba(255,255,255,.14);
      box-shadow:inset 0 1px 0 rgba(255,255,255,.30), inset 0 -8px 12px rgba(12,16,28,.18), 0 0 0 1px rgba(255,255,255,.08), 0 8px 18px rgba(0,0,0,.18), 0 0 20px rgba(255,255,255,.06);
      backdrop-filter:blur(6px) saturate(1.18);-webkit-backdrop-filter:blur(6px) saturate(1.18);
    }
    .wheel-icon-seat::before{content:"";position:absolute;inset:9% 16% 44% 16%;border-radius:999px;background:linear-gradient(180deg, rgba(255,255,255,.95), rgba(255,255,255,0));opacity:.52;pointer-events:none}
    .wheel-icon-seat::after{content:"";position:absolute;inset:-10px;border-radius:50%;opacity:0;transform:scale(.72);pointer-events:none;
      background:radial-gradient(circle, rgba(255,255,255,.6) 0 12%, rgba(255,211,92,.42) 18%, rgba(49,168,255,.28) 40%, rgba(255,77,184,.22) 62%, transparent 76%);
    }
    .wheel-icon-seat.slot{width:50px;height:50px;background:radial-gradient(circle at 50% 28%, rgba(255,250,231,.98), rgba(255,224,118,.96) 34%, rgba(255,174,43,.94) 62%, rgba(134,67,0,.92) 100%);box-shadow:inset 0 1px 0 rgba(255,255,255,.28), 0 0 0 1.8px rgba(255,233,158,.86), 0 8px 16px rgba(72,39,0,.24), 0 0 22px rgba(255,195,75,.22)}
    .wheel-icon-seat.melon{width:50px;height:50px;background:radial-gradient(circle at 50% 28%, rgba(255,245,248,.98), rgba(255,176,196,.96) 34%, rgba(255,96,131,.94) 62%, rgba(142,17,49,.92) 100%);box-shadow:inset 0 1px 0 rgba(255,255,255,.24), 0 0 0 1.8px rgba(255,194,207,.84), 0 8px 16px rgba(83,10,31,.24), 0 0 22px rgba(255,106,146,.2)}
    .wheel-icon-seat.plum{width:48px;height:48px;background:radial-gradient(circle at 50% 28%, rgba(247,242,255,.98), rgba(189,163,255,.96) 34%, rgba(113,86,255,.94) 62%, rgba(41,18,124,.92) 100%);box-shadow:inset 0 1px 0 rgba(255,255,255,.22), 0 0 0 1.8px rgba(212,198,255,.8), 0 8px 16px rgba(24,12,72,.24), 0 0 22px rgba(123,102,255,.2)}
    .wheel-icon-seat.winner-seat{box-shadow:0 0 0 1px rgba(255,255,255,.16), 0 0 18px rgba(255,211,92,.36), 0 0 28px rgba(49,168,255,.22), 0 0 34px rgba(255,77,184,.18), inset 0 1px 0 rgba(255,255,255,.24);animation:winnerSeatFloat 1.2s ease-in-out infinite}
    .wheel-icon-seat.winner-seat::after{opacity:1;animation:winnerSeatWave 1.2s ease-out infinite}
    .wheel-icon-seat .slot77{font-family:Arial Black, Inter, system-ui, sans-serif;font-style:italic;font-weight:900;letter-spacing:-1.6px;
      color:#ff2996;-webkit-text-stroke:1.6px #ffe86f;text-shadow:0 2px 4px rgba(0,0,0,.45),0 0 10px rgba(255,58,182,.45);line-height:1;display:block;transform:translateY(-1px)}
    .slot-seat-stack{display:grid;place-items:center;gap:0;line-height:1;width:100%;height:100%;transform:translateY(1px) scale(.78);transform-origin:center}
    .bet-slot .slot-seat-stack{transform:translateY(0) scale(.94)}
    .slot-seat-icon{font-size:9px;color:#fff5ae;text-shadow:0 0 10px rgba(255,227,111,.4)}
    .wheel-icon-seat .wheel-fruit-icon{display:grid;place-items:center;width:100%;height:100%;transform:translateY(-1px);filter:drop-shadow(0 3px 4px rgba(0,0,0,.35))}
    .wheel-icon-seat .wheel-fruit-icon svg{width:100%;height:100%;display:block;overflow:visible}
    .wheel-icon-seat .wheel-fruit-icon.bet-wheel-icon{width:52px;height:52px;transform:none}
    .wheel-mark-icon{width:100%;height:100%;display:grid;place-items:center;padding:0 5px;border-radius:50%;font-size:18px;font-weight:1000;letter-spacing:0;line-height:1;color:#fff8dd;background:radial-gradient(circle at 34% 30%, rgba(255,255,255,.92), rgba(255,255,255,.2) 30%, rgba(255,255,255,.06) 100%);border:1px solid rgba(255,255,255,.18);box-shadow:inset 0 1px 0 rgba(255,255,255,.16), 0 6px 14px rgba(0,0,0,.22);text-shadow:0 1px 3px rgba(0,0,0,.48)}
    .app.lucky77-mirage .wheel-mark-icon{background:radial-gradient(circle at 34% 30%, #fff7e0, rgba(255,223,156,.88) 32%, rgba(132,84,36,.96) 100%);border-color:rgba(255,230,182,.42);color:#3b2209}
    .app.lucky77-ironfront .wheel-mark-icon{background:radial-gradient(circle at 34% 30%, #f2f5f7, rgba(150,158,168,.88) 32%, rgba(52,58,66,.98) 100%);border-color:rgba(255,214,196,.26);color:#20110b}
    .app.lucky77-lotus .wheel-mark-icon{background:radial-gradient(circle at 34% 30%, #fff6fa, rgba(243,181,207,.88) 32%, rgba(57,115,92,.96) 100%);border-color:rgba(255,229,238,.34);color:#2b1320}
    .app.lucky77-nebula .wheel-mark-icon{background:radial-gradient(circle at 34% 30%, #f6fdff, rgba(102,211,255,.88) 32%, rgba(74,68,255,.96) 100%);border-color:rgba(209,235,255,.34);color:#071220}
    .app.lucky77-carnival .wheel-mark-icon{background:repeating-linear-gradient(135deg, #ffe173 0 8px, #ff6a92 8px 16px, #6dc8ff 16px 24px);border-color:rgba(255,236,184,.34);color:#2b1024}
    .wheel-icon-seat .fruit-emoji{line-height:1;display:block;filter:drop-shadow(0 3px 4px rgba(0,0,0,.35));transform:translateY(-1px)}
    .wheel-icon-seat.winner-seat .slot77,.wheel-icon-seat.winner-seat .wheel-fruit-icon{filter:drop-shadow(0 0 10px rgba(255,255,255,.24)) drop-shadow(0 0 18px rgba(255,211,92,.34))}
    .winner-pop-token{position:fixed;z-index:28;pointer-events:none;display:grid;place-items:center;width:52px;height:52px;border-radius:50%;background:radial-gradient(circle at 36% 28%, rgba(255,255,255,.92), rgba(255,211,92,.38) 42%, rgba(49,168,255,.18) 100%);box-shadow:0 0 0 1px rgba(255,255,255,.26),0 16px 30px rgba(0,0,0,.34),0 0 28px rgba(255,211,92,.32);filter:drop-shadow(0 0 12px rgba(255,255,255,.2))}
    .winner-pop-token .wheel-fruit-icon{width:42px;height:42px}
    .winner-pop-token .slot-seat-stack{transform:translateY(1px) scale(.9)}
    .winner-pop-token .slot77{font-size:28px}
    .hidden{display:none !important}

    @keyframes drift{from{transform:translate3d(0,0,0)}to{transform:translate3d(6%,4%,0)}}
    @keyframes particleFloat{from{transform:translateY(0)}to{transform:translateY(-36px)}}
    @keyframes pulseDot{0%,100%{transform:scale(1);opacity:1}50%{transform:scale(.7);opacity:.7}}
    @keyframes aura{0%,100%{transform:scale(1);opacity:.8}50%{transform:scale(1.05);opacity:1}}
    @keyframes sweep{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}
    @keyframes chipBlink{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.55;transform:scale(1.05)}}
    @keyframes bannerIn{from{opacity:0;transform:translateY(-8px) scale(.97)}to{opacity:1;transform:translateY(0) scale(1)}}
    @keyframes tick{0%{transform:translateX(-50%) rotate(0)}50%{transform:translateX(-50%) rotate(8deg)}100%{transform:translateX(-50%) rotate(0)}}
    @keyframes hit{0%{transform:translateX(-50%) translateY(0)}35%{transform:translateX(-50%) translateY(4px) rotate(6deg)}100%{transform:translateX(-50%) translateY(0)}}
    @keyframes flyChip{0%{transform:translate(var(--sx),var(--sy)) scale(.5);opacity:0}15%{opacity:1}100%{transform:translate(var(--tx),var(--ty)) scale(1);opacity:0}}
    @keyframes spark{0%{transform:translate(0,0) scale(1);opacity:1}100%{transform:translate(var(--dx),var(--dy)) scale(.2);opacity:0}}
    @keyframes confetti{0%{transform:translateY(0) rotate(0);opacity:1}100%{transform:translateY(120px) rotate(200deg);opacity:0}}
    @keyframes fadeIn{from{opacity:0}to{opacity:1}}


    .hero-panel::after{
      content:"";position:absolute;inset:0;border-radius:inherit;pointer-events:none;
      background:linear-gradient(135deg, rgba(255,255,255,.07), transparent 26%, transparent 68%, rgba(255,255,255,.04));
      box-shadow:inset 0 1px 0 rgba(255,255,255,.08), inset 0 -18px 32px rgba(23,34,98,.14);
      z-index:0;
    }
    .chip-rail{position:relative;isolation:isolate}
    .chip-rail::before{
      content:"";position:absolute;inset:0;border-radius:22px;pointer-events:none;
      background:linear-gradient(120deg, rgba(255,255,255,.06), transparent 28%, transparent 68%, rgba(255,255,255,.03));
      z-index:0;
    }
    .chip-scroll,.action-box{position:relative;z-index:1}
    .topbar-meta > *{min-width:0}
    .network-pill,.payout-chip,.round-chip{max-width:100%}
    .payout-chip span{white-space:nowrap;overflow:hidden;text-overflow:ellipsis}

    @media (max-width:390px){
      .app{width:100vw;max-width:none}
      .shell{padding:8px 8px calc(var(--safe-bottom) + 8px)}
      .topbar{gap:4px 5px}
      .topbar-meta{grid-template-columns:minmax(0,1fr) auto;grid-template-areas:"round net" "pay pay";gap:4px}
      .topbar-meta .round-chip{grid-area:round}
      .topbar-meta .network-pill{grid-area:net;justify-self:end}
      .topbar-meta .payout-chip{grid-area:pay;width:100%}
      .balance-card{padding:9px 11px;border-radius:18px}
      .balance-value{font-size:20px;gap:8px}
      .balance-value .coin{width:24px;height:24px}
      .hero-zone{gap:5px}
      .hero-panel{border-radius:24px;padding:3px}
      .bets{gap:6px}
      .bet-card{padding:8px 8px 10px;border-radius:20px}
      .chip-bar{grid-template-columns:minmax(0,1fr) 64px;gap:5px}
      .chip-rail{padding:6px 5px;border-radius:18px}
      .chip-scroll{gap:4px}
      .chip{width:clamp(34px,9vw,42px);height:clamp(34px,9vw,42px)}
      .action-box{min-width:60px;font-size:10px;padding:7px 5px}
    }
    @media (max-height:450px){
      .topbar{min-height:auto}
      .topbar-meta{gap:4px}
      .hero-zone{gap:4px}
      .hero-panel{padding:2px;border-radius:22px}
      .recent-strip{min-height:32px;padding:5px 8px}
      .chip-bar{grid-template-columns:minmax(0,1fr) 60px;gap:4px}
      .chip-rail{padding:5px 4px}
      .chip{width:32px;height:32px}
      .action-box{min-width:58px;padding:6px 4px;font-size:10px}
      .bets{gap:5px}
      .bet-card{min-height:96px}
    }

    @media (max-height:560px){
      .wheel-wrap{max-width:300px}
      .wheel-inner{inset:19px}
      .seg .label{width:46px;height:46px}
      .seg .label.slot-label{width:54px;height:54px}
      .fruit-icon{width:38px;height:38px}
      .slot77{font-size:30px}
    }
    @media (max-height:460px){
      .wheel-wrap{max-width:222px}
      .wheel-inner{inset:15px}
      .seg .label{width:36px;height:36px}
      .seg .label.slot-label{width:42px;height:42px}
      .fruit-icon{width:28px;height:28px}
      .slot77{font-size:22px;-webkit-text-stroke:1.1px #fff7a6}
    }

    @media (max-height:760px){
      :root{--wheel-size:min(58vw,270px);--bet-h:104px;--chip-h:74px;--top-h:58px}
      .balance-value{font-size:20px}.hero-panel{border-radius:28px}.bets{gap:8px}.bet-icon-wrap{width:50px;height:50px}.bet-slot{font-size:31px}.counter{font-size:30px}.chip,.chip svg{width:54px;height:54px}.action-box{min-width:68px}
    }
    @media (max-height:620px){
      :root{--wheel-size:min(46vw,210px);--bet-h:72px;--chip-h:58px;--recent-h:30px}
      .shell{gap:6px;padding-inline:10px}.topbar{gap:8px}.balance-card{padding:8px 12px;border-radius:18px}.balance-value{font-size:17px}.top-actions{padding:6px;border-radius:18px}.icon-btn{width:36px;height:36px;border-radius:13px}.network-pill{min-width:70px;padding:0 8px}.hero-panel{padding-top:10px;border-radius:24px}.hero-head{padding-inline:0;gap:8px}.status-chip,.round-chip,.payout-chip{padding:6px 9px;font-size:10px}.wheel-center{inset:36.8%}.counter{font-size:24px}.recent-strip{padding:5px 8px;border-radius:14px}.recent-pill{min-width:30px;height:22px}.bets{gap:6px}.bet-card{border-radius:18px;padding:6px 7px 7px}.bet-amount{font-size:12px;padding:5px 8px}.bet-icon-wrap{width:42px;height:42px}.fruit-icon{width:34px;height:34px}.bet-slot{font-size:26px}.bet-multi{font-size:15px}.chip-bar{gap:6px}.chip-rail{padding:6px;border-radius:18px}.chip,.chip svg{width:40px;height:40px}.chip-label{font-size:10px}.action-box{min-width:56px;border-radius:18px;padding:8px 6px}.action-box b{font-size:10px}.banner-stack{top:calc(var(--safe-top) + 70px)}.banner-title{font-size:19px}.utility-toast{bottom:calc(var(--safe-bottom) + 82px)}
    }
    @media (max-height:500px){
      :root{--wheel-size:min(39vw,168px);--bet-h:70px;--chip-h:58px}
      .shell{gap:6px;padding-inline:8px}.balance-sub,.round-chip{display:none}.hero-head{justify-content:flex-end}.status-chip{font-size:9px}.recent-label{font-size:9px;padding:4px 7px}.recent-pill{min-width:26px;height:20px;font-size:11px}.bets{gap:6px}.bet-card{border-radius:16px;padding:6px 6px}.bet-icon-wrap{width:34px;height:34px}.fruit-icon{width:28px;height:28px}.bet-slot{font-size:22px}.bet-multi{font-size:12px}.chip,.chip svg{width:40px;height:40px}.chip-rail{padding:7px}.action-box{min-width:54px;padding:7px}.banner{padding:12px 14px}.banner-title{font-size:16px}.popup{border-radius:22px;padding:16px 14px}
    }
  
    @media (max-height:450px){
      :root{--wheel-size:min(35vw,150px);--bet-h:64px;--chip-h:52px;--recent-h:30px}
      .shell{gap:5px;padding:calc(var(--safe-top) + 5px) 7px calc(var(--safe-bottom) + 5px)}
      .topbar{gap:6px}
      .top-actions{padding:5px;gap:5px}.chip-bar{grid-template-columns:minmax(0,1fr) 58px}.banner-stack{top:calc(var(--safe-top) + 60px)}.banner{min-height:56px;padding:10px 12px}
      .icon-btn{width:34px;height:34px;border-radius:12px}
      .network-pill{min-width:68px;padding:0 8px}
      .balance-card{padding:7px 9px;border-radius:16px}
      .balance-label{font-size:10px}
      .balance-value{font-size:16px}
      .hero-panel{border-radius:20px;padding:7px 5px 3px}
      .hero-head{justify-content:flex-end}
      .status-chip{padding:5px 8px;font-size:9px}
      .wheel-center{inset:36.5%}
      .recent-strip{padding:5px 8px;gap:6px}
      .recent-pill{min-width:24px;height:18px;font-size:10px}
      .bets{gap:5px}
      .bet-card{border-radius:14px;padding:5px 5px 6px;gap:3px}
      .bet-amount{font-size:10px;padding:3px 6px;min-width:40px}
      .bet-icon-wrap{width:30px;height:30px}
      .fruit-icon{width:24px;height:24px}
      .bet-slot{font-size:18px}
      .bet-multi{font-size:11px}
      .chip-bar{gap:6px}
      .chip-rail{padding:6px;border-radius:16px}
      .chip-scroll{gap:4px}
      .chip{width:34px;height:34px}
      .chip svg{width:36px;height:36px}
      .chip-label{font-size:8px}
      .action-box{min-width:50px;border-radius:16px;padding:6px 6px}
      .action-box b{font-size:9px}
      .action-box span{font-size:9px}
      .banner-stack{top:calc(var(--safe-top) + 60px)}
      .banner{padding:10px 12px;border-radius:16px}
      .banner-title{font-size:14px}
      .banner-sub{font-size:10px}
      .counter{font-size:20px}
      .counter.small{font-size:12px}
      .popup{border-radius:20px;padding:14px 12px}
    }


    /* hard responsive pass */
    .chip-rail,.recent-strip,.top-actions,.balance-card,.hero-panel,.bets,.chip-bar{min-width:0}
    .top-actions{overflow:hidden}
    .chip-scroll{overscroll-behavior-x:contain}
    .recent-track{overflow:hidden;min-width:0}
    .bet-card,.chip,.icon-btn,.action-box,.payout-chip{-webkit-touch-callout:none}

    .app.mode-tight .hero-inner{gap:8px}
    .app.mode-tight .recent-track{gap:6px}

    .app.mode-vh450{
      width:100vw !important;
      max-width:100vw !important;
      height:100dvh;
      max-height:none;
      border-radius:0;
      box-shadow:none;
    }
    .app.mode-vh450 .shell{
      padding:calc(var(--safe-top) + 4px) 6px calc(var(--safe-bottom) + 4px);
      gap:4px;
      grid-template-rows:auto minmax(0,1fr) auto auto auto;
    }
    .app.mode-vh450 .topbar{gap:5px;min-height:54px}
    .app.mode-vh450 .balance-card{padding:6px 8px;border-radius:14px;gap:8px}
    .app.mode-vh450 .balance-value{font-size:15px;gap:6px}
    .app.mode-vh450 .balance-value .coin{width:22px;height:22px}
    .app.mode-vh450 .network-pill{min-width:60px;padding:0 6px;font-size:11px}
    .app.mode-vh450 .network-text{font-size:11px}
    .app.mode-vh450 .top-actions{padding:5px;gap:5px;border-radius:14px}
    .app.mode-vh450 .icon-btn{width:32px;height:32px;border-radius:11px}
    .app.mode-vh450 .hero-zone{gap:5px}
    .app.mode-vh450 .hero-panel{padding:6px 5px 4px;border-radius:18px}
    .app.mode-vh450 .hero-head{padding:0 2px;gap:6px;justify-content:space-between}
    .app.mode-vh450 .status-chip{display:none}
    .app.mode-vh450 .payout-chip{padding:5px 8px;font-size:9px;gap:6px}
    .app.mode-vh450 .payout-chip b{font-size:10px}
    .app.mode-vh450 .wheel-wrap{filter:drop-shadow(0 12px 24px rgba(0,0,0,.28))}
    .app.mode-vh450 .wheel-aura{filter:blur(16px)}
    .app.mode-vh450 .wheel-inner{inset:22px}
    .app.mode-vh450 .wheel-center{inset:36.8%}
    .app.mode-vh450 .counter{font-size:18px}
    .app.mode-vh450 .counter.small{font-size:11px}
    .app.mode-vh450 .recent-strip{min-height:28px;padding:4px 7px;gap:6px;border-radius:14px}
    .app.mode-vh450 .recent-label{padding:4px 6px;font-size:8px}
    .app.mode-vh450 .recent-track{gap:5px}
    .app.mode-vh450 .recent-pill{min-width:22px;height:18px;padding:0 5px;font-size:10px}
    .app.mode-vh450 .bets{gap:5px;min-height:auto}
    .app.mode-vh450 .bet-card{padding:5px 4px 6px;border-radius:14px;gap:3px}
    .app.mode-vh450 .bet-amount{min-width:36px;padding:3px 5px;font-size:10px}
    .app.mode-vh450 .bet-icon-wrap{width:30px;height:30px}
    .app.mode-vh450 .fruit-icon{width:24px;height:24px}
    .app.mode-vh450 .bet-slot{font-size:18px}
    .app.mode-vh450 .bet-multi{font-size:11px}
    .app.mode-vh450 .chip-bar{grid-template-columns:minmax(0,1fr) 50px;gap:4px;min-height:auto}
    .app.mode-vh450 .chip-rail{padding:5px 6px;border-radius:14px;gap:4px;overflow:visible}
    .app.mode-vh450 .chip-scroll{gap:4px;padding-bottom:0;grid-template-columns:repeat(5,minmax(0,1fr))}
    .app.mode-vh450 .chip,.app.mode-vh450 .chip svg{width:32px;height:32px}
    .app.mode-vh450 .chip-label{font-size:8px}
    .app.mode-vh450 .action-box{width:50px;min-width:50px;padding:5px 3px;border-radius:14px}
    .app.mode-vh450 .action-box b,.app.mode-vh450 .action-box span{font-size:8px;line-height:1.05}
    .app.mode-vh450 .banner-stack{top:calc(var(--safe-top) + 54px);left:6px;right:6px}
    .app.mode-vh450 .banner{min-height:54px;padding:10px 12px;border-radius:15px}
    .app.mode-vh450 .banner-title{font-size:14px}
    .app.mode-vh450 .banner-sub{font-size:10px}
    .app.mode-vh450 .utility-toast{bottom:calc(var(--safe-bottom) + 64px)}
    .app.mode-vh450 .popup{width:min(100%,320px);max-height:min(72dvh,420px);padding:14px 12px;border-radius:18px}
    .app.mode-vh450 .popup-title{font-size:18px}
    .app.mode-vh450 .popup-sub,.app.mode-vh450 .tile span{font-size:11px}
    .app.mode-vh450 .popup-cta{height:42px;border-radius:14px}

  

    /* hero-inner + balance-card responsive hard pass */
    .topbar{
      display:grid;
      grid-template-columns:minmax(0,1fr) auto;
      align-items:stretch;
    }
    .balance-card{
      min-width:0;
      display:grid;
      grid-template-columns:minmax(0,1fr) auto;
      align-items:center;
      gap:10px;
      padding-right:10px;
    }
    .balance-left{min-width:0;overflow:hidden}
    .balance-value{
      min-width:0;
      max-width:100%;
      line-height:1;
    }
    .balance-value #balanceText{
      min-width:0;
      overflow:hidden;
      text-overflow:ellipsis;
      display:block;
    }
    .network-pill{
      justify-self:end;
      max-width:100%;
      min-width:0;
      flex-shrink:0;
    }
    .hero-panel{display:flex;min-height:0}
    .hero-inner{
      width:100%;
      min-width:0;
      grid-template-rows:auto 1fr;
      justify-items:center;
      align-content:stretch;
      gap:10px;
    }
    .hero-head{
      min-width:0;
      display:grid;
      grid-template-columns:minmax(0,auto) minmax(0,1fr);
      align-items:center;
    }
    .status-chip{min-width:0;white-space:nowrap}
    .payout-chip{
      min-width:0;
      width:100%;
      justify-content:flex-end;
      text-align:right;
      overflow:hidden;
    }
    .payout-chip span{
      min-width:0;
      overflow:hidden;
      text-overflow:ellipsis;
      white-space:nowrap;
    }
    .wheel-wrap{max-width:100%;max-height:100%;min-width:0;min-height:0;}

    @media (max-width: 390px){
      .topbar{grid-template-columns:minmax(0,1fr) auto;gap:6px}
      .balance-card{gap:8px;padding-right:8px}
      .balance-value{font-size:16px}
      .balance-value .coin{width:22px;height:22px}
      .network-pill{padding:0 7px;min-width:64px;height:34px;border-radius:14px}
      .network-text{font-size:10px}
      .hero-inner{gap:8px}
      .hero-head{grid-template-columns:1fr;gap:6px;justify-items:stretch}
      .status-chip,.payout-chip{width:100%;justify-content:center;text-align:center}
      .payout-chip span{white-space:nowrap}
    }

    @media (max-height: 620px){
      .hero-inner{gap:7px}
      .hero-head{gap:7px}
      .balance-card{padding-top:8px;padding-bottom:8px}
      .balance-value{font-size:17px}
    }

    @media (max-height: 500px){
      .topbar{grid-template-columns:minmax(0,1fr) auto;gap:5px}
      .balance-card{padding:6px 8px;gap:6px;border-radius:16px}
      .balance-value{font-size:15px;gap:6px}
      .balance-value .coin{width:20px;height:20px}
      .network-pill{padding:0 6px;min-width:58px;height:30px;border-radius:12px}
      .network-text{font-size:9px}
      .hero-panel{padding:7px 5px 4px}
      .hero-inner{gap:6px}
      .hero-head{grid-template-columns:1fr;gap:5px}
      .status-chip,.payout-chip{padding:6px 8px;font-size:9px;justify-content:center;text-align:center}
      .payout-chip b{font-size:10px}
    }

    .app.mode-vh450 .topbar{
      grid-template-columns:minmax(0,1fr) auto;
      align-items:start;
    }
    .app.mode-vh450 .balance-card{
      grid-template-columns:minmax(0,1fr) auto;
      gap:6px;
      padding-right:7px;
      min-height:44px;
    }
    .app.mode-vh450 .balance-left{overflow:hidden}
    .app.mode-vh450 .balance-value{font-size:14px;gap:5px}
    .app.mode-vh450 .balance-value .coin{width:20px;height:20px}
    .app.mode-vh450 .network-pill{padding:0 6px;min-width:54px;height:28px;border-radius:11px}
    .app.mode-vh450 .network-text{font-size:9px}
    .app.mode-vh450 .hero-inner{gap:5px;grid-template-rows:auto 1fr}
    .app.mode-vh450 .hero-head{grid-template-columns:1fr;gap:4px;padding:0}
    .app.mode-vh450 .status-chip,.app.mode-vh450 .payout-chip{
      width:100%;
      justify-content:center;
      text-align:center;
      padding:5px 7px;
      font-size:9px;
      min-height:26px;
    }
    .app.mode-vh450 .payout-chip b{font-size:9px}

  
    @media (max-width: 430px){
      .topbar-meta .round-chip,.topbar-meta .network-pill,.topbar-meta .payout-chip{min-width:0;justify-content:center}
      .topbar-meta .payout-chip span{white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:100%}
      .seg .label{width:46px;height:46px;transform:translate(-50%,-50%) translateY(-90px)}
      .seat{transform:translate(-50%,-50%) translateY(-104px)}
    }
    @media (max-height: 620px){
      .topbar-meta{gap:8px}
      .hero-zone{grid-template-rows:minmax(0,1fr) auto;gap:4px}
      .hero-panel{padding-top:8px}
      .seg .label{width:44px;height:44px;transform:translate(-50%,-50%) translateY(-84px)}
      .seat{width:34%;height:18%;transform:translate(-50%,-50%) translateY(-95px)}
      .slot77{font-size:28px}
      .fruit-icon{width:38px;height:38px}
    }
    @media (max-height: 500px){
      .topbar-meta{grid-template-columns:1fr 1fr 1fr;gap:5px}
      .topbar-meta .round-chip,.topbar-meta .network-pill,.topbar-meta .payout-chip{padding:6px 8px;font-size:10px}
      .topbar-meta .network-text{font-size:10px}
      .hero-zone{gap:6px}
      .hero-panel{padding-top:6px}
      .seg .label{width:38px;height:38px;transform:translate(-50%,-50%) translateY(-70px)}
      .seat{width:31%;height:16%;transform:translate(-50%,-50%) translateY(-80px)}
      .slot77{font-size:24px}
      .fruit-icon{width:32px;height:32px}
    }
    .app.mode-vh450 .topbar-meta{grid-template-columns:1fr 1fr 1fr;gap:5px}
    .app.mode-vh450 .topbar-meta .round-chip,.app.mode-vh450 .topbar-meta .network-pill,.app.mode-vh450 .topbar-meta .payout-chip{padding:5px 7px;font-size:9px;border-radius:12px}
    .app.mode-vh450 .topbar-meta .network-text{font-size:9px}
    .app.mode-vh450 .hero-panel{padding-top:4px}
    .app.mode-vh450 .seg .label{width:34px;height:34px;transform:translate(-50%,-50%) translateY(-62px)}
    .app.mode-vh450 .seat{width:30%;height:15%;transform:translate(-50%,-50%) translateY(-70px)}
    .app.mode-vh450 .slot77{font-size:22px}
    .app.mode-vh450 .fruit-icon{width:28px;height:28px}

  
    @media (max-width: 390px){
      .shell{padding-left:10px;padding-right:10px;gap:6px}
      .topbar{gap:4px}
      .topbar-meta{grid-template-columns:auto auto minmax(0,1fr);gap:3px}
      .round-chip,.network-pill,.payout-chip{padding:7px 8px;border-radius:16px}
      .network-text{font-size:11px}
      .chip-bar{gap:5px}
      .chip-rail{padding:7px 5px;overflow:visible}
      .chip{width:38px;height:38px}
      .action-box{min-width:58px;padding:8px 6px;border-radius:18px}
      .action-box b{font-size:10px}
      .action-box span{font-size:9px}
      .bet-card{min-height:108px}
    }
    @media (max-height: 560px){
      .shell{gap:6px;padding-top:calc(var(--safe-top) + 6px)}
      .topbar{gap:3px 6px}
      .topbar-meta .payout-chip{padding:6px 8px}
      .hero-zone{gap:5px}
      .hero-panel{padding:3px}
      .recent-strip{padding:7px 9px}
      .chip-bar{gap:5px}
      .chip-rail{padding:7px 5px;overflow:visible}
      .chip{width:38px;height:38px}
      .action-box{min-width:58px;padding:7px 6px}
    }
    @media (max-height: 450px){
      .shell{padding:calc(var(--safe-top) + 4px) 8px calc(var(--safe-bottom) + 6px);gap:5px}
      .topbar{gap:3px 5px}
      .topbar-meta{gap:3px}
      .round-chip,.network-pill,.payout-chip{padding:6px 8px;min-height:30px}
      .hero-zone{gap:4px}
      .hero-panel{border-radius:22px;padding:2px}
      .recent-strip{padding:6px 8px;min-height:30px}
      .chip-bar{gap:4px}
      .chip-rail{padding:6px 5px;overflow:visible}
      .chip{width:34px;height:34px}
      .action-box{min-width:54px;padding:6px 5px;border-radius:16px}
      .action-box b{font-size:9px}
      .action-box span{font-size:8px}
    }

  
    .shell{padding-bottom:calc(var(--chip-dock-h) + var(--safe-bottom) + 10px)}
    .chip-bar{
      position:absolute;
      left:clamp(6px, 2vw, 12px);
      right:clamp(6px, 2vw, 12px);
      bottom:calc(var(--safe-bottom) + 8px);
      z-index:13;
    }
    .utility-toast{bottom:calc(var(--chip-dock-h) + var(--safe-bottom) + 18px)}

    /* Mobile fit layer: bottom chips, no scroll, full screen width at 450/325 heights */
    html,body,.app{width:100vw;max-width:100vw;overflow:hidden}
    .app{height:100dvh;max-height:100dvh}
    .shell{overflow:hidden}
    .chip-bar{
      position:fixed !important;
      left:0 !important;
      right:0 !important;
      bottom:0 !important;
      width:100vw !important;
      max-width:100vw !important;
      min-height:calc(var(--chip-dock-h) + var(--safe-bottom)) !important;
      padding:6px max(6px,env(safe-area-inset-right)) max(6px,env(safe-area-inset-bottom)) max(6px,env(safe-area-inset-left));
      z-index:50 !important;
      border-radius:0;
    }
    .chip-scroll{overflow:hidden;grid-template-columns:repeat(5,minmax(0,1fr))}
    .chip{max-width:44px;max-height:44px}
    .hero-zone,.hero-panel,.hero-inner{min-height:0;overflow:hidden}
    @media (max-height:450px){
      :root{--top-h:42px;--chip-h:34px;--chip-dock-h:44px;--bet-h:62px;--recent-h:24px;--wheel-size:min(44vw,150px)}
      .shell{padding:calc(var(--safe-top) + 3px) 6px calc(var(--chip-dock-h) + var(--safe-bottom));gap:3px;grid-template-rows:auto minmax(0,1fr) auto auto auto}
      .topbar{min-height:38px;gap:4px}.balance-card{padding:4px 6px;border-radius:12px}.balance-value{font-size:12px}.balance-value .coin{width:16px;height:16px}
      .top-actions{padding:3px;gap:3px}.icon-btn{width:25px;height:25px;border-radius:8px}.topbar-meta{gap:3px}
      .round-chip,.network-pill,.payout-chip{min-height:22px;padding:3px 5px;font-size:8px;border-radius:9px}.network-text{font-size:8px}
      .hero-zone{gap:3px}.hero-panel{padding:2px;border-radius:14px}.wheel-wrap{max-width:150px;max-height:150px}.pointer-wrap{width:26px;height:34px}
      .counter{font-size:14px}.counter.small{font-size:8px}
      .recent-strip{min-height:24px;padding:3px 6px;border-radius:10px}.recent-label{font-size:7px;padding:3px 5px}.recent-pill{min-width:18px;height:15px;font-size:8px}
      .bets{gap:3px;min-height:62px}.bet-card{padding:3px 2px;border-radius:10px;gap:1px}.bet-amount{font-size:8px;padding:2px 4px}.bet-icon-wrap{width:22px;height:22px}.fruit-icon{width:18px;height:18px}.bet-slot{font-size:14px}.bet-multi{font-size:8px}
      .chip-bar{grid-template-columns:minmax(0,1fr) 40px;gap:3px}.chip-rail{padding:3px;border-radius:10px}.chip-scroll{gap:3px}.chip,.chip svg{width:25px;height:25px}.chip-label{display:none}.action-box{min-width:40px;width:40px;padding:4px 2px;border-radius:10px}.action-box span{display:none}.action-box b{font-size:8px}
    }
    @media (max-height:325px){
      :root{--top-h:34px;--chip-h:28px;--chip-dock-h:36px;--bet-h:42px;--recent-h:0px;--wheel-size:min(35vw,104px)}
      .shell{padding:calc(var(--safe-top) + 2px) 4px calc(var(--chip-dock-h) + var(--safe-bottom));gap:2px}
      .topbar{min-height:30px}.balance-card{min-height:28px;padding:3px 5px}.balance-value{font-size:10px}.top-actions{display:none}
      .topbar-meta,.recent-strip{display:none}.hero-panel{border-radius:10px}.wheel-wrap{max-width:104px;max-height:104px}.wheel-inner{inset:12px}.pointer-wrap{width:20px;height:28px}
      .bets{gap:2px;min-height:42px}.bet-card{padding:2px;border-radius:8px}.bet-icon-wrap{width:16px;height:16px}.fruit-icon{width:14px;height:14px}.bet-slot{font-size:10px}.bet-multi,.bet-amount{font-size:7px}
      .chip-bar{grid-template-columns:minmax(0,1fr) 32px;gap:2px}.chip-rail{padding:2px}.chip,.chip svg{width:20px;height:20px}.action-box{min-width:32px;width:32px;padding:2px}.action-box b{font-size:7px}
    }

    /* bd:77 wheel transplant overrides */
    .wheel-wrap{position:relative;width:var(--wheel-actual,min(var(--wheel-size),100%));height:var(--wheel-actual,min(var(--wheel-size),100%));aspect-ratio:1/1;display:grid;place-items:center;filter:drop-shadow(0 18px 30px rgba(0,0,0,.24)) drop-shadow(0 0 26px rgba(255,215,110,.14));margin-inline:auto;max-width:448px;max-height:448px;overflow:visible;isolation:isolate;transform:translateZ(0)}
    .wheel-wrap::before{content:"";position:absolute;inset:4%;border-radius:50%;background:conic-gradient(from 0deg, transparent 0deg 26deg, rgba(255,255,255,.16) 42deg, transparent 66deg 110deg, rgba(120,232,255,.16) 132deg, transparent 156deg 214deg, rgba(255,214,120,.18) 236deg, transparent 260deg 312deg, rgba(255,96,196,.16) 334deg, transparent 360deg);filter:blur(11px);mix-blend-mode:screen;opacity:.62;z-index:0;pointer-events:none;animation:wheelOrbitGlow 16s linear infinite}
    .wheel-wrap::after{content:"";position:absolute;inset:8%;border-radius:50%;border:1px solid rgba(255,255,255,.12);box-shadow:0 0 26px rgba(86,180,255,.10), inset 0 0 0 1px rgba(255,255,255,.06), inset 0 14px 26px rgba(255,255,255,.06);opacity:.52;z-index:0;pointer-events:none}
    .wheel-aura,.wheel-spark,.wheel-ticks,.pointer-cap,.center-ring{pointer-events:none}
    .wheel-aura{position:absolute;inset:-8%;border-radius:50%;background:radial-gradient(circle, rgba(255,215,0,.22) 0%, rgba(255,0,170,.12) 28%, rgba(104,0,255,.10) 52%, transparent 72%),conic-gradient(from 180deg, rgba(255,255,255,.12), transparent 18%, rgba(255,255,255,.08) 36%, transparent 52%, rgba(255,255,255,.12) 72%, transparent 88%);filter:blur(18px);mix-blend-mode:screen;opacity:.92;z-index:0;animation:wheelAuraPulse 2.8s ease-in-out infinite}
    .wheel-wing{position:absolute;top:50%;transform:translateY(-50%);width:clamp(22px,5.3vw,34px);height:44%;background:linear-gradient(180deg, var(--gold-light), var(--gold-base) 40%, var(--gold-shadow));z-index:0;box-shadow:inset 0 0 8px rgba(0,0,0,.34),0 6px 14px rgba(0,0,0,.45)}
    .wheel-wing.left{left:-4%;clip-path:polygon(100% 0,100% 100%,0 84%,0 68%,20% 68%,20% 53%,0 53%,0 40%,20% 40%,20% 25%,0 25%,0 14%)}
    .wheel-wing.right{right:-4%;clip-path:polygon(0 0,0 100%,100% 84%,100% 68%,80% 68%,80% 53%,100% 53%,100% 40%,80% 40%,80% 25%,100% 25%,100% 14%)}
    .pointer-wrap{position:absolute;left:50%;top:-8px;transform:translateX(-50%);width:clamp(36px,8vw,46px);height:clamp(52px,11vw,62px);z-index:12;pointer-events:none;overflow:visible}
    .pointer-wrap::after{content:"";position:absolute;left:50%;top:18px;transform:translateX(-50%);width:4px;height:16px;border-radius:999px;background:linear-gradient(180deg, rgba(255,246,194,.98), rgba(255,193,68,.94) 58%, rgba(120,69,0,.96));box-shadow:0 0 8px rgba(255,215,110,.38)}
    .pointer{position:absolute;left:50%;top:8px;transform:translateX(-50%);width:clamp(24px,5.8vw,30px);height:clamp(28px,7vw,36px);clip-path:polygon(50% 100%,0 0,100% 0);background:linear-gradient(180deg,#fffbe6 0%,#ffe692 38%,#f0b11f 68%,#9f5e00 100%);border-radius:0 0 8px 8px;filter:drop-shadow(0 6px 10px rgba(0,0,0,.62));z-index:13}
    .pointer::before{content:"";position:absolute;left:50%;top:10%;width:56%;height:46%;transform:translateX(-50%);border-radius:999px 999px 40% 40%;background:linear-gradient(180deg, rgba(255,255,255,.88), rgba(255,255,255,.12));opacity:.72}
    .pointer-cap{position:absolute;left:50%;top:0;transform:translateX(-50%);width:clamp(18px,4.8vw,24px);aspect-ratio:1;border-radius:50%;z-index:14;background:radial-gradient(circle at 35% 30%, rgba(255,255,255,.98), rgba(255,255,255,.18) 30%, transparent 31%),radial-gradient(circle,#ff59d5 0%,#c3008f 52%,#52003b 100%);border:2px solid rgba(255,235,170,.95);box-shadow:0 0 0 3px rgba(94,28,0,.68),0 0 18px rgba(255,62,186,.48)}
    .pointer-cap::after{content:"";position:absolute;inset:14%;border-radius:50%;border:1px solid rgba(255,255,255,.42);opacity:.84}
    .wheel{position:absolute;inset:0;aspect-ratio:1/1;border-radius:50%;padding:clamp(10px,2.6vw,16px);background:radial-gradient(circle at 28% 22%, rgba(255,255,255,.65), transparent 14%),linear-gradient(145deg,var(--gold-light),var(--gold-base) 26%,#f0b000 40%,var(--gold-dark) 70%,var(--gold-shadow));box-shadow:0 0 0 4px rgba(255,215,0,.16),0 18px 36px rgba(0,0,0,.45),0 0 28px rgba(255,196,0,.16),inset 0 4px 10px rgba(255,255,255,.52),inset 0 -8px 14px rgba(0,0,0,.42);overflow:hidden;z-index:1;isolation:isolate;backdrop-filter:blur(10px) saturate(1.14);-webkit-backdrop-filter:blur(10px) saturate(1.14);transition:transform .28s ease, filter .28s ease}
    .wheel::before{content:"";position:absolute;inset:10px;border-radius:50%;border:5px solid rgba(73,35,0,.85);box-shadow:inset 0 0 14px rgba(0,0,0,.45),0 0 0 1.5px rgba(255,234,170,.20);z-index:1}
    .wheel::after{content:"";position:absolute;inset:6px;border-radius:50%;background:linear-gradient(148deg, rgba(255,255,255,.46) 0%, rgba(255,255,255,.14) 18%, rgba(255,255,255,0) 30%, rgba(255,255,255,.16) 46%, rgba(255,255,255,0) 56%),conic-gradient(from 120deg, rgba(255,255,255,0) 0deg 36deg, rgba(255,255,255,.16) 54deg 78deg, rgba(255,255,255,0) 96deg 218deg, rgba(255,216,120,.16) 238deg 258deg, rgba(255,255,255,0) 280deg 360deg);mix-blend-mode:screen;opacity:.64;z-index:3;pointer-events:none;animation:wheelGlassSweep 8.4s linear infinite}
    .wheel-inner{position:absolute;inset:16px;width:auto;height:auto;aspect-ratio:1/1;border-radius:50%;overflow:hidden;background:radial-gradient(circle at 50% 50%, transparent 0 17.6%, rgba(255,255,255,.98) 17.7% 18.5%, transparent 18.6%),radial-gradient(circle at 30% 18%, rgba(255,255,255,.16), transparent 13%),conic-gradient(from -70deg, rgba(255,255,255,.10), rgba(255,255,255,0) 14%, rgba(255,255,255,.14) 26%, rgba(255,255,255,0) 40%, rgba(255,255,255,.08) 54%, rgba(255,255,255,0) 70%, rgba(255,255,255,.12) 84%, rgba(255,255,255,.04) 100%),radial-gradient(circle at 50% 50%, #1399ff 0%, #0c73e9 50%, #0859cf 76%, #083ea4 100%);transition:transform 5.6s cubic-bezier(.2,.82,.17,1),filter .28s ease,box-shadow .28s ease;will-change:transform,filter;transform-origin:50% 50%;box-shadow:inset 0 0 0 1.1px rgba(255,255,255,.22),inset 0 2px 6px rgba(255,255,255,.18),inset 0 -12px 18px rgba(0,0,0,.18),0 0 18px rgba(255,255,255,.04);z-index:2;--icon-radius:33.8%;backdrop-filter:blur(8px) saturate(1.15);-webkit-backdrop-filter:blur(8px) saturate(1.15)}
    .wheel-inner::before{content:"";position:absolute;inset:0;border-radius:50%;background:linear-gradient(152deg, rgba(255,255,255,.34) 0%, rgba(255,255,255,.10) 18%, rgba(255,255,255,0) 34%),radial-gradient(circle at 28% 18%, rgba(255,255,255,.24), transparent 14%),conic-gradient(from -90deg, rgba(255,255,255,.08), rgba(255,255,255,0) 16%, rgba(255,255,255,.16) 26%, rgba(255,255,255,0) 42%, rgba(255,255,255,.10) 56%, rgba(255,255,255,0) 70%, rgba(255,255,255,.14) 82%, rgba(255,255,255,.04) 100%);mix-blend-mode:screen;opacity:.76;pointer-events:none;animation:wheelInnerSheen 9s linear infinite}
    .wheel-inner::after{content:"";position:absolute;inset:5px;border-radius:50%;border:1px solid rgba(255,255,255,.18);box-shadow:inset 0 0 0 1px rgba(255,255,255,.08),inset 0 22px 28px rgba(255,255,255,.08),inset 0 -24px 30px rgba(0,0,0,.18);background:radial-gradient(circle at 50% 14%, rgba(255,255,255,.22), transparent 24%),radial-gradient(circle at 50% 84%, rgba(0,0,0,.18), transparent 24%);pointer-events:none}
    .wheel-ticks{position:absolute;inset:7px;border-radius:50%;z-index:2;opacity:.92;background:repeating-conic-gradient(from -18deg, rgba(255,230,155,.95) 0deg 1.6deg, rgba(95,44,0,.75) 1.6deg 3.4deg, transparent 3.4deg 36deg);-webkit-mask:radial-gradient(circle, transparent 0 78%, #000 80% 84%, transparent 86%);mask:radial-gradient(circle, transparent 0 78%, #000 80% 84%, transparent 86%);transform-origin:50% 50%;transition:opacity .28s ease}
    .wheel-spark{position:absolute;inset:12%;border-radius:50%;z-index:3;opacity:.68;background:radial-gradient(circle at 22% 22%, rgba(255,255,255,.42), transparent 12%),radial-gradient(circle at 78% 34%, rgba(255,255,255,.22), transparent 11%),radial-gradient(circle at 34% 84%, rgba(255,255,255,.14), transparent 11%);mix-blend-mode:screen;animation:wheelSparkDrift 5.6s ease-in-out infinite}
    .center-ring{position:absolute;left:50%;top:50%;width:29%;aspect-ratio:1/1;transform:translate(-50%,-50%);border-radius:50%;z-index:4;background:radial-gradient(circle, rgba(255,255,255,.18), rgba(255,255,255,0) 62%);box-shadow:0 0 0 3px rgba(255,255,255,.14),0 0 18px rgba(255,216,120,.14);animation:wheelCorePulse 3.4s ease-in-out infinite}
    .wheel-center{position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);width:26%;aspect-ratio:1/1;border-radius:50%;display:grid;place-items:center;background:radial-gradient(circle at 35% 28%, rgba(255,255,255,.26), rgba(255,255,255,0) 24%),radial-gradient(circle,#2033b8 0%,#09195a 58%,#04081e 100%);border:4px solid var(--gold-base);box-shadow:inset 0 0 10px rgba(0,0,0,.8),0 0 15px rgba(0,0,0,.35),0 0 0 3px #552200,0 0 24px rgba(255,215,110,.12);z-index:5;overflow:hidden}
    .wheel-center::after{content:"";position:absolute;inset:11%;border-radius:50%;background:linear-gradient(160deg, rgba(255,255,255,.36), rgba(255,255,255,0) 52%),radial-gradient(circle at 50% 72%, rgba(255,226,120,.18), transparent 58%);mix-blend-mode:screen;opacity:.92;animation:wheelCoreGlassPulse 3.2s ease-in-out infinite}
    .wheel-stand{position:absolute;bottom:-14px;left:50%;transform:translateX(-50%);width:32%;height:8%;border-radius:12px 12px 55% 55%;background:linear-gradient(90deg,var(--gold-dark),var(--gold-base) 50%,var(--gold-dark));border-bottom:4px solid #4a3500;z-index:0;box-shadow:0 10px 10px rgba(0,0,0,.35)}
    .symbol-77{text-shadow:0 0 10px rgba(255,20,147,.95),0 0 20px rgba(255,224,72,.55),2px 2px 0 rgba(0,0,0,.42);transform:translateY(-2%) scale(1.04)}
    .seg{position:absolute;inset:0;clip-path:polygon(50% 50%, 50% 0%, 55.23% 0.27%, 60.40% 1.09%, 65.45% 2.45%, 70.34% 4.32%, 75% 6.70%, 79.39% 9.55%);transform-origin:50% 50%;display:block;isolation:isolate;background:transparent}
    .seg::before{content:"";position:absolute;left:50%;top:-0.15%;width:1.8px;height:56.8%;transform:translateX(-50%);background:linear-gradient(180deg, rgba(255,255,255,.98), rgba(255,242,190,.96) 30%, rgba(255,255,255,.42) 68%, rgba(255,255,255,0) 100%);box-shadow:0 0 8px rgba(255,236,182,.24);z-index:1;pointer-events:none}
    .seg::after{content:"";position:absolute;inset:0;clip-path:inherit;background:linear-gradient(180deg, rgba(255,255,255,.12), rgba(255,255,255,0) 18%, rgba(0,0,0,.08) 72%, rgba(0,0,0,.16) 100%);mix-blend-mode:soft-light;z-index:0;pointer-events:none}
    .seg-core{position:absolute;inset:0;clip-path:inherit;background:transparent}
    .seg-core::before{content:"";position:absolute;inset:2px 2px 1px 2px;clip-path:inherit;background:var(--seg-fill, transparent)}
    .seg.slot .seg-core{background:linear-gradient(180deg, #fff0a0 0%, #e2a51d 58%, #8a4300 100%);box-shadow:inset 0 0 0 1px rgba(255,247,196,.5), inset 0 0 18px rgba(255,227,118,.24)}
    .seg.slot .seg-core::before{background:radial-gradient(circle at 50% 14%, #fff9d2 0%, #ffef8f 18%, #ffd54a 42%, #f3a11b 66%, #8f4b00 100%)}
    .seg.melon .seg-core{background:linear-gradient(180deg, #ffd6df 0%, #ff7a95 58%, #7a1430 100%);box-shadow:inset 0 0 0 1px rgba(255,240,244,.34), inset 0 0 16px rgba(255,143,170,.14)}
    .seg.melon .seg-core::before{background:radial-gradient(circle at 50% 18%, #ffb0c0 0%, #ff6e82 28%, #ff425d 54%, #cc2643 76%, #7a1430 100%)}
    .seg.plum .seg-core{background:linear-gradient(180deg, #d8c8ff 0%, #7b57ff 56%, #1b0c66 100%);box-shadow:inset 0 0 0 1px rgba(245,239,255,.3), inset 0 0 16px rgba(144,115,255,.14)}
    .seg.plum .seg-core::before{background:radial-gradient(circle at 50% 18%, #a985ff 0%, #7b57ff 30%, #4d2bdc 62%, #2f179e 82%, #1b0c66 100%)}
    .seg-label{position:absolute;left:50%;top:50%;display:grid;place-items:center;z-index:2;transform-origin:50% 50%;line-height:1;pointer-events:none}
    .seg-label>span{display:grid;place-items:center;transform-origin:50% 50%}
    .seg-label.emoji{font-size:clamp(22px,5.6vw,34px);filter:drop-shadow(0 3px 4px rgba(0,0,0,.42))}
    .seg-label.seven{font-family:Arial Black, Inter, system-ui, sans-serif;font-style:italic;font-weight:900;letter-spacing:-1.5px;font-size:clamp(22px,5.7vw,35px);color:#ff2996;-webkit-text-stroke:1.4px #ffe86f;filter:drop-shadow(0 2px 4px rgba(0,0,0,.5)) drop-shadow(0 0 8px rgba(255,58,182,.36))}
    .wheel-wrap.is-spinning::before{animation-duration:4.8s;opacity:.82}
    .wheel-wrap.is-spinning .wheel-aura{animation-duration:1.2s;filter:blur(24px);opacity:1}
    .wheel-wrap.is-spinning .wheel{transform:scale(1.01)}
    .wheel-wrap.is-spinning .wheel::after{animation-duration:2.9s;opacity:.88}
    .wheel-wrap.is-spinning .wheel-inner{filter:saturate(1.12) brightness(1.04);box-shadow:inset 0 0 0 1.2px rgba(255,255,255,.26),inset 0 2px 6px rgba(255,255,255,.20),inset 0 -12px 18px rgba(0,0,0,.18),0 0 24px rgba(255,255,255,.06)}
    .wheel-wrap.is-spinning .wheel-inner::before{animation-duration:3.2s;opacity:.92}
    .wheel-wrap.is-spinning .wheel-ticks{animation:wheelTickOrbit 1.2s linear infinite;opacity:1}
    .wheel-wrap.is-spinning .wheel-spark{animation-duration:1.5s;opacity:.94}
    .wheel-wrap.is-spinning .center-ring{animation-duration:1.15s}
    .wheel-wrap.is-spinning .wheel-center::after{animation-duration:1.15s}
    .app.fx-reduced .wheel-wrap::before,
    .app.fx-reduced .wheel-aura,
    .app.fx-reduced .wheel::after,
    .app.fx-reduced .wheel-inner::before,
    .app.fx-reduced .wheel-spark,
    .app.fx-reduced .wheel-ticks,
    .app.fx-reduced .center-ring,
    .app.fx-reduced .wheel-center::after,
    .app.fx-reduced .wheel-icon-seat.winner-seat,
    .app.fx-reduced .wheel-icon-seat.winner-seat::after{animation:none !important}
    .pointer-wrap.tick .pointer{transform:translateX(-50%) translateY(2px)}
    .pointer-wrap.hit .pointer,.pointer-wrap.hit .pointer-cap{animation:pointerHit .34s ease}
    @keyframes pointerHit{0%{transform:translateX(-50%) scale(1)}50%{transform:translateX(-50%) scale(1.08)}100%{transform:translateX(-50%) scale(1)}}
    @keyframes wheelAuraPulse{0%,100%{opacity:.72;transform:scale(1)}50%{opacity:1;transform:scale(1.05)}}
    @keyframes wheelOrbitGlow{0%{transform:rotate(0deg) scale(1)}100%{transform:rotate(360deg) scale(1.04)}}
    @keyframes wheelGlassSweep{0%{transform:rotate(0deg) scale(1);opacity:.5}50%{transform:rotate(180deg) scale(1.02);opacity:.88}100%{transform:rotate(360deg) scale(1);opacity:.5}}
    @keyframes wheelInnerSheen{0%{transform:rotate(0deg) scale(1)}50%{transform:rotate(180deg) scale(1.02)}100%{transform:rotate(360deg) scale(1)}}
    @keyframes wheelSparkDrift{0%,100%{transform:rotate(0deg) scale(1);opacity:.6}50%{transform:rotate(10deg) scale(1.04);opacity:.96}}
    @keyframes wheelCorePulse{0%,100%{transform:translate(-50%,-50%) scale(1);opacity:.78}50%{transform:translate(-50%,-50%) scale(1.06);opacity:1}}
    @keyframes wheelCoreGlassPulse{0%,100%{transform:scale(1);opacity:.78}50%{transform:scale(1.08);opacity:1}}
    @keyframes wheelTickOrbit{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}

    .pro-phase-overlay{position:absolute;inset:0;display:grid;place-items:center;pointer-events:none;opacity:0;visibility:hidden;z-index:18;transition:opacity .22s ease, visibility .22s ease}
    .pro-phase-overlay.show{opacity:1;visibility:visible}
    .pro-phase-overlay::before{content:"";position:absolute;inset:0;background:radial-gradient(circle at 50% 42%, rgba(255,226,120,.08), transparent 36%), linear-gradient(180deg, rgba(4,8,18,.04), rgba(4,8,18,.36));backdrop-filter:blur(3px);-webkit-backdrop-filter:blur(3px)}
    .pro-phase-popup{position:relative;width:min(78%,320px);padding:22px 20px 20px;border-radius:28px;overflow:hidden;text-align:center;border:1px solid rgba(255,255,255,.14);background:linear-gradient(180deg, rgba(13,33,40,.96), rgba(7,14,23,.95));box-shadow:0 24px 60px rgba(0,0,0,.42), inset 0 1px 0 rgba(255,255,255,.08);transform:translateY(18px) scale(.9);opacity:0}
    .pro-phase-overlay.show .pro-phase-popup{animation:proPhasePopupIn .34s cubic-bezier(.2,.86,.18,1) forwards, proPhasePopupFloat 2.2s ease-in-out .4s infinite}
    .pro-phase-popup::before{content:"";position:absolute;inset:-22% -35%;background:linear-gradient(120deg, transparent 24%, rgba(255,255,255,.18) 46%, transparent 64%);transform:translateX(-140%)}
    .pro-phase-overlay.show .pro-phase-popup::before{animation:proPhaseSweep 1.8s linear forwards}
    .pro-phase-popup.start{border-color:rgba(66,247,203,.28);box-shadow:0 24px 60px rgba(0,0,0,.42), 0 0 34px rgba(66,247,203,.18), inset 0 1px 0 rgba(255,255,255,.08)}
    .pro-phase-popup.stop{border-color:rgba(255,226,120,.3);box-shadow:0 24px 60px rgba(0,0,0,.42), 0 0 34px rgba(255,226,120,.16), inset 0 1px 0 rgba(255,255,255,.08)}
    .pro-phase-popup.win{border-color:rgba(66,247,203,.34);box-shadow:0 24px 60px rgba(0,0,0,.42), 0 0 40px rgba(66,247,203,.22), 0 0 52px rgba(255,226,120,.14), inset 0 1px 0 rgba(255,255,255,.08)}
    .pro-phase-popup.net{border-color:rgba(255,91,107,.28);box-shadow:0 24px 60px rgba(0,0,0,.42), 0 0 30px rgba(255,91,107,.18), inset 0 1px 0 rgba(255,255,255,.08)}
    .pro-phase-pill{position:relative;z-index:1;display:inline-flex;align-items:center;justify-content:center;min-width:118px;padding:7px 12px;border-radius:999px;background:linear-gradient(180deg, rgba(255,255,255,.16), rgba(255,255,255,.05));border:1px solid rgba(255,255,255,.12);font-size:10px;font-weight:1000;letter-spacing:.22em;text-transform:uppercase;color:#e8fffb}
    .pro-phase-title{position:relative;z-index:1;margin-top:14px;font-size:32px;font-weight:1000;letter-spacing:.02em;line-height:1.02;color:#fafffb;text-shadow:0 0 22px rgba(66,247,203,.14), 0 0 34px rgba(255,226,120,.12)}
    .pro-phase-sub{position:relative;z-index:1;margin-top:8px;font-size:13px;line-height:1.45;color:#d8f7f2}
    .pro-phase-rings{position:absolute;inset:0;pointer-events:none}
    .pro-phase-rings span{position:absolute;left:50%;top:50%;width:150px;height:150px;border-radius:50%;border:1px solid rgba(255,255,255,.10);transform:translate(-50%, -50%) scale(.72);opacity:0}
    .pro-phase-overlay.show .pro-phase-rings span:nth-child(1){animation:proRingPulse 1.8s ease-out .02s forwards}
    .pro-phase-overlay.show .pro-phase-rings span:nth-child(2){animation:proRingPulse 1.8s ease-out .18s forwards}
    .pro-phase-overlay.show .pro-phase-rings span:nth-child(3){animation:proRingPulse 1.8s ease-out .34s forwards}
    .app:not(.lucky7-pro) .pro-phase-overlay{display:none}
    @keyframes proPhasePopupIn{0%{opacity:0;transform:translateY(18px) scale(.9)}100%{opacity:1;transform:translateY(0) scale(1)}}
    @keyframes proPhasePopupFloat{0%,100%{transform:translateY(0) scale(1)}50%{transform:translateY(-4px) scale(1.01)}}
    @keyframes proPhaseSweep{0%{transform:translateX(-140%)}100%{transform:translateX(140%)}}
    @keyframes proRingPulse{0%{opacity:0;transform:translate(-50%, -50%) scale(.62)}20%{opacity:.5}100%{opacity:0;transform:translate(-50%, -50%) scale(1.32)}}

    /* Final mobile fit guard after all variant overrides */
    .chip-bar{position:fixed !important;left:0 !important;right:0 !important;bottom:0 !important;width:100vw !important;max-width:100vw !important;border-radius:0 !important;z-index:50 !important}
    .chip-scroll{overflow:hidden !important;grid-template-columns:repeat(5,minmax(0,1fr))}
    .shell,.hero-zone,.hero-panel,.hero-inner{overflow:hidden}
    @media (max-height:450px){
      .app{width:100vw !important;max-width:100vw !important;height:100dvh !important;max-height:100dvh !important}
      .chip,.chip svg{width:25px !important;height:25px !important}.chip-label{display:none !important}
      .action-box{min-width:40px !important;width:40px !important}.recent-strip{min-height:24px !important}.bets{min-height:62px !important}
    }
    @media (max-height:325px){
      .top-actions,.topbar-meta,.recent-strip{display:none !important}
      .chip,.chip svg{width:20px !important;height:20px !important}.action-box{min-width:32px !important;width:32px !important}.bets{min-height:42px !important}
    }
    .bet-amount,
    .bet-payout,
    .bet-multi,
    .payout-chip b,
    .round-chip b {
      font-family: Inter, "Segoe UI", Arial, sans-serif !important;
      font-variant-numeric: tabular-nums;
      letter-spacing: 0 !important;
      text-transform: none;
    }
    .bet-multi {
      font-weight: 900;
      font-size: clamp(13px, 3.8vw, 20px) !important;
      line-height: 1;
    }
    .bet-payout{position:absolute;top:6px;right:7px;padding:2px 6px;border-radius:999px;background:rgba(255,211,92,.16);border:1px solid rgba(255,211,92,.34);color:var(--gold);font-size:11px;font-weight:1000;line-height:1}
    body[class*="gf-popup-popup_"] .popup,
    body[class*="gf-popup-popup_"] .banner{border-color:var(--admin-accent);box-shadow:0 24px 80px rgba(0,0,0,.48),0 0 28px color-mix(in srgb,var(--admin-accent),transparent 64%)}
    body.gf-popup-popup_02 .popup,body.gf-popup-popup_02 .banner{border-radius:28px}
    body.gf-popup-popup_03 .popup,body.gf-popup-popup_03 .banner{background:linear-gradient(145deg,var(--admin-primary),rgba(5,8,18,.96))}
    body.gf-popup-popup_04 .popup,body.gf-popup-popup_04 .banner{filter:saturate(1.22)}
    body.gf-popup-popup_05 .popup,body.gf-popup-popup_05 .banner{outline:2px solid color-mix(in srgb,var(--admin-accent),transparent 45%)}
  </style>
  @include('game_final.partials.admin_visual_theme_styles')
  @include('game_final.partials.mobile_fit_styles')
</head>
<body class="gf-popup-{{ $gameTheme['popup_theme'] ?? 'popup_01' }} gf-item-{{ $gameTheme['item_theme'] ?? 'default' }}" style="--admin-primary:{{ $gameTheme['primary_color'] ?? '#060712' }};--admin-accent:{{ $gameTheme['accent_color'] ?? '#ffd35c' }}">
<div class="app {{ trim($appVariantClass . ($isBaseLucky77Variant ? ' lucky77-plain-wheel' : '')) }}" id="app">
    <div class="bg-stage"></div>
    <div class="bg-lights"></div>
    <div class="bg-floor"></div>
    <div class="bg-particles"></div>
    <div class="bg-vignette"></div>

    <div class="shell">
      <div class="topbar">
        <div class="balance-card" id="balanceCard">
          <div class="balance-left">
            <div class="balance-value" id="balanceValue"><span class="coin"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2 19 9l-7 13L5 9 12 2Z"></path></svg></span><span id="balanceText">--</span></div>
            <div class="player-flip-card" id="playerFlipCard"><span class="player-flip-label">Player</span><span class="player-flip-value" id="playerFlipValue">{{ $displayUserName ?? 'Player' }}</span></div>
          </div>
          <div class="balance-delta" id="balanceDelta">+0</div>
        </div>
        <div class="top-actions">
          <button class="icon-btn" id="soundBtn" title="Sound">
            <svg viewBox="0 0 24 24"><path d="M11 5 6 9H3v6h3l5 4z"></path><path d="M16 9a4 4 0 0 1 0 6"></path><path d="M18.5 6.5a7.5 7.5 0 0 1 0 11"></path></svg>
          </button>
          <button class="icon-btn" id="historyBtn" title="History">
            <svg viewBox="0 0 24 24"><path d="M3 12a9 9 0 1 0 3-6.7"></path><path d="M3 4v5h5"></path><path d="M12 7v5l3 2"></path></svg>
          </button>
          <button class="icon-btn" id="usersBtn" title="Active Users">
            <svg viewBox="0 0 24 24"><path d="M8 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm8.5.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7ZM8 13c-3.3 0-6 1.8-6 4v2h12v-2c0-2.2-2.7-4-6-4Zm8.5.5c-.9 0-1.8.2-2.6.5 1.3.9 2.1 2 2.1 3.4V19h6v-1.7c0-2.1-2.5-3.8-5.5-3.8Z"></path></svg>
          </button>
          <button class="icon-btn" id="settingsBtn" title="Settings">
            <svg viewBox="0 0 24 24"><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"></path><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.8-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.2a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.8.3l-.1.1A2 2 0 0 1 4.3 17l.1-.1a1.7 1.7 0 0 0 .3-1.8 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.2a1.7 1.7 0 0 0 1.5-1 1.7 1.7 0 0 0-.3-1.8L4.3 7A2 2 0 0 1 7 4.3l.1.1a1.7 1.7 0 0 0 1.8.3h.1a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.2a1.7 1.7 0 0 0 1 1.5h.1a1.7 1.7 0 0 0 1.8-.3l.1-.1A2 2 0 1 1 19.7 7l-.1.1a1.7 1.7 0 0 0-.3 1.8v.1a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.2a1.7 1.7 0 0 0-1.4 1Z"></path></svg>
          </button>
        </div>
        <div class="topbar-meta">
          <div class="round-chip">Round <b id="roundText">-</b><span id="modeText" style="display:none">Betting</span></div>
          <div class="network-pill" id="networkPill">
            <span class="net-dot"></span>
            <span class="network-text" id="networkText">sync</span>
          </div>
          <button class="payout-chip" id="payoutBtn" type="button" title="How to Play / Payout">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3v18M5 9h14M7 15h10"></path></svg>
            <span>{{ $rulesLabel }} <b>{{ $payoutSummary }}</b></span>
          </button>
        </div>
      </div>

      <div class="hero-zone">
        <div class="hero-panel">
          <div class="hero-inner" id="heroInner">
            <div class="wheel-wrap" id="wheelWrap">
              <div class="wheel-aura"></div>
              <div class="wheel-wing left"></div>
              <div class="wheel-wing right"></div>
              <div class="pointer-wrap" id="pointerWrap">
                <div class="pointer"></div>
                <div class="pointer-cap"></div>
              </div>
              <div class="wheel">
                <div class="wheel-ticks"></div>
                <div class="wheel-spark"></div>
                <div class="wheel-inner" id="wheelInner"></div>
                <div class="center-ring"></div>
                <div class="wheel-center"><div class="counter" id="counter">--</div></div>
              </div>
              <div class="wheel-stand"></div>
            </div>
          </div>
        </div>

        <div class="recent-strip">
          <div class="recent-label">{{ $recentLabel }}</div>
          <div class="recent-track" id="recentTrack"></div>
        </div>
      </div>

      <div class="bets" id="betsZone">
        <div class="bet-card" data-bet="melon">
          <div class="bet-payout">x{{ $formatLuckyMultiplier($boardPayoutMultipliers['melon'] ?? 1) }}</div>
          <div class="bet-amount" id="amt-melon">0</div>
          <div class="bet-icon-wrap">
            <svg class="fruit-icon" viewBox="0 0 64 64" aria-hidden="true">
              <defs><linearGradient id="gMelon1" x1="0" y1="0" x2="1" y2="1"><stop stop-color="#ff8ea4"/><stop offset="1" stop-color="#ff3e63"/></linearGradient></defs>
              <path d="M11 35c4-13 16-22 31-22 5 0 9 1 13 3-2 18-16 32-34 34-5 1-9 0-13-2 0-4 1-8 3-13Z" fill="#0f7d43"/>
              <path d="M14 35c3-10 13-18 25-18 4 0 8 1 11 2-2 14-13 25-28 28-4 1-7 0-10-1 0-3 1-6 2-11Z" fill="url(#gMelon1)"/>
              <circle cx="24" cy="29" r="1.8" fill="#241014"/><circle cx="31" cy="34" r="1.8" fill="#241014"/><circle cx="39" cy="28" r="1.8" fill="#241014"/>
            </svg>
          </div>
          <div class="bet-multi" id="own-melon">0</div>
        </div>
        <div class="bet-card" data-bet="slot">
          <div class="bet-payout">x{{ $formatLuckyMultiplier($boardPayoutMultipliers['slot'] ?? 1) }}</div>
          <div class="bet-amount" id="amt-slot">0</div>
          <div class="bet-icon-wrap bet-slot"><span class="slot77">{{ $slotDisplayMark }}</span></div>
          <div class="bet-multi" id="own-slot">0</div>
        </div>
        <div class="bet-card" data-bet="plum">
          <div class="bet-payout">x{{ $formatLuckyMultiplier($boardPayoutMultipliers['plum'] ?? 1) }}</div>
          <div class="bet-amount" id="amt-plum">0</div>
          <div class="bet-icon-wrap">
            <svg class="fruit-icon" viewBox="0 0 64 64" aria-hidden="true">
              <defs><linearGradient id="gBerry1" x1="0" y1="0" x2="1" y2="1"><stop stop-color="#c79dff"/><stop offset="1" stop-color="#6a38ff"/></linearGradient></defs>
              <circle cx="27" cy="35" r="14" fill="url(#gBerry1)"/><circle cx="40" cy="28" r="12" fill="#7b48ff"/><path d="M31 18c4-7 10-10 18-9-3 4-7 7-14 8" fill="#38c97a"/>
              <circle cx="22" cy="31" r="2" fill="#fff" opacity=".35"/><circle cx="37" cy="23" r="2" fill="#fff" opacity=".28"/>
            </svg>
          </div>
          <div class="bet-multi" id="own-plum">0</div>
        </div>
      </div>

      <div class="chip-bar">
        <div class="chip-rail">
          <div class="chip-scroll" id="chipScroll">
            <button class="chip purple active" data-value="1000" aria-label="1K chip"><span class="chip-label">1K</span></button>
            <button class="chip orange" data-value="5000" aria-label="5K chip"><span class="chip-label">5K</span></button>
            <button class="chip green" data-value="10000" aria-label="10K chip"><span class="chip-label">10K</span></button>
            <button class="chip blue" data-value="50000" aria-label="50K chip"><span class="chip-label">50K</span></button>
            <button class="chip gold" data-value="100000" aria-label="100K chip"><span class="chip-label">100K</span></button>
          </div>
        </div>
        <button class="action-box toggle" id="autoBetBtn"><b>Auto</b><span>Off</span></button>
      </div>
    </div>

    <div class="banner-stack" id="bannerStack">
      <div class="banner start" id="bannerStart"><div><div class="banner-title">Start Bet</div><div class="banner-sub">Place your chips now</div></div></div>
      <div class="banner stop" id="bannerStop"><div><div class="banner-title">Stop Bet</div><div class="banner-sub">Bets locked · spinning</div></div></div>
      <div class="banner win" id="bannerWin"><div><div class="banner-title" id="bannerWinTitle">Winner</div><div class="banner-sub" id="bannerWinSub">Round settled</div></div></div>
      <div class="banner net" id="bannerNet"><div><div class="banner-title">Network Issue</div><div class="banner-sub">Trying to reconnect…</div></div></div>
    </div>

    <div class="pro-phase-overlay" id="proPhaseOverlay" aria-hidden="true">
      <div class="pro-phase-popup start" id="proPhasePopup">
        <div class="pro-phase-pill" id="proPhasePill">PRO ROOM</div>
        <div class="pro-phase-title" id="proPhaseTitle">Lucky 7 Pro</div>
        <div class="pro-phase-sub" id="proPhaseSub">Royal wheel room is live.</div>
        <div class="pro-phase-rings"><span></span><span></span><span></span></div>
      </div>
    </div>

    <div class="utility-toast" id="utilityToast">Saved</div>
    <div class="chip-fly-layer" id="chipFlyLayer"></div>
    <div class="spark-layer" id="sparkLayer"></div>
    <div class="confetti-layer" id="confettiLayer"></div>

    <div class="overlay" id="settingsOverlay">
      <div class="popup shine">
        <div class="popup-head"><div><div class="popup-title">Settings</div><div class="popup-sub">Tune your game controls, music and visual style.</div></div><button class="popup-close" data-close="settingsOverlay">✕</button></div>
        <div class="switch-row"><div><div class="switch-label">Game Sound</div><div class="switch-sub">Button taps and win cues</div></div><div class="switch on" id="toggleSound"></div></div>
        <div class="switch-row"><div><div class="switch-label">Music</div><div class="switch-sub">Ambient background theme</div></div><div class="switch on" id="toggleMusic"></div></div>
        <div class="switch-row"><div><div class="switch-label">Reduced Effects</div><div class="switch-sub">Safer for lower-end devices</div></div><div class="switch" id="toggleFx"></div></div>
        <div class="range-row"><div><div class="switch-label">Volume</div><div class="switch-sub">0 to 100%</div></div><input type="range" min="0" max="100" value="75" id="volumeRange"></div>
        <button class="popup-cta" data-close="settingsOverlay">Done</button>
      </div>
    </div>

    <div class="overlay" id="historyOverlay">
      <div class="popup">
        <div class="popup-head"><div><div class="popup-title">History</div><div class="popup-sub">Last 15 winning boards and your last 15 bets.</div></div><button class="popup-close" data-close="historyOverlay">✕</button></div>
        <div class="history-list" id="historyList"></div>
      </div>
    </div>

    <div class="overlay" id="usersOverlay">
      <div class="popup">
        <div class="popup-head"><div><div class="popup-title">Active Users</div><div class="popup-sub">Live players and their game win totals for this room.</div></div><button class="popup-close" data-close="usersOverlay">✕</button></div>
        <div class="history-list" id="usersList"></div>
      </div>
    </div>

    <div class="overlay" id="helpOverlay">
      <div class="popup">
        <div class="popup-head"><div><div class="popup-title">{{ $helpTitle }}</div><div class="popup-sub">{{ $helpSubtitle }}</div></div><button class="popup-close" data-close="helpOverlay">✕</button></div>
        <div class="tile-grid">
          <div class="tile"><b>1. Choose a chip</b><span>Select one chip value from the bar below.</span></div>
          <div class="tile"><b>2. Place your bet</b><span>{{ $helpBetLine }}</span></div>
          <div class="tile"><b>3. Wait for stop</b><span>{{ $helpStopLine }}</span></div>
          <div class="tile"><b>4. Collect winnings</b><span>{{ $helpPayoutLine }}</span></div>
        </div>
        <button class="popup-cta" data-close="helpOverlay">Got it</button>
      </div>
    </div>

    <div class="overlay" id="networkOverlay">
      <div class="popup shine">
        <div class="popup-head"><div><div class="popup-title">Connection Lost</div><div class="popup-sub">Game is temporarily paused while we restore the room.</div></div></div>
        <div class="tile-grid">
          <div class="tile"><b>Status</b><span id="networkStatusText">Reconnecting to the game room…</span></div>
          <div class="tile"><b>Action</b><span>Bets are locked until connection returns.</span></div>
        </div>
        <button class="popup-cta" id="reconnectBtn">Try Refresh</button>
      </div>
    </div>

    <div class="overlay" id="balanceOverlay">
      <div class="popup shine">
        <div class="popup-head"><div><div class="popup-title">Insufficient Balance</div><div class="popup-sub">Your selected chip is higher than your current balance.</div></div><button class="popup-close" data-close="balanceOverlay">✕</button></div>
        <div class="tile-grid">
          <div class="tile"><b>Tip</b><span>Select a lower chip to keep betting smoothly.</span></div>
          <div class="tile"><b>Current Balance</b><span id="balancePopupText">0</span></div>
        </div>
        <button class="popup-cta" data-close="balanceOverlay">Choose Smaller Chip</button>
      </div>
    </div>
<style id="lucky77-popup-stability">
  .overlay{
    position:fixed !important;
    inset:0 !important;
    padding:clamp(10px,3vw,18px) !important;
    align-items:center !important;
    justify-content:center !important;
    background:rgba(3,6,14,.74) !important;
  }
  .popup{
    width:min(96vw,420px) !important;
    max-height:min(84dvh,720px) !important;
    padding:18px 16px !important;
    border-radius:24px !important;
    overflow:hidden !important;
    display:flex !important;
    flex-direction:column !important;
    gap:12px !important;
  }
  .popup-head{
    align-items:flex-start !important;
    gap:12px !important;
    margin-bottom:0 !important;
  }
  .popup-head > div{
    min-width:0 !important;
    flex:1 1 auto !important;
  }
  .popup-title{
    font-size:20px !important;
    line-height:1.1 !important;
  }
  .popup-sub{
    font-size:12px !important;
  }
  .popup-close{
    flex:0 0 38px !important;
    width:38px !important;
    height:38px !important;
  }
  .history-list,
  .history-stack{
    margin-top:0 !important;
    min-width:0 !important;
  }
  #historyOverlay .history-list,
  #usersOverlay .history-list{
    flex:1 1 auto !important;
    min-height:0 !important;
    overflow-x:hidden !important;
    overflow-y:auto !important;
    overscroll-behavior:contain !important;
    -webkit-overflow-scrolling:touch !important;
    padding-right:4px !important;
  }
  #historyOverlay .history-stack{
    gap:10px !important;
  }
  .history-panel{
    padding:12px !important;
    border-radius:18px !important;
  }
  .history-panel-head{
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
  .history-table{
    width:100% !important;
    min-width:100% !important;
    max-width:100% !important;
    table-layout:fixed !important;
    font-size:12px !important;
  }
  .history-table th,
  .history-table td{
    padding:9px 8px !important;
    white-space:normal !important;
    overflow-wrap:anywhere !important;
    word-break:break-word !important;
  }
  .history-board-cell{
    align-items:flex-start !important;
  }
  #usersOverlay .tile-grid,
  #helpOverlay .tile-grid,
  #balanceOverlay .tile-grid,
  #networkOverlay .tile-grid{
    grid-template-columns:1fr !important;
    margin-top:10px !important;
  }
    #usersOverlay .tile-grid{
      margin-top:0 !important;
    }
  #usersOverlay .active-user-grid{
    grid-template-columns:repeat(6,minmax(0,1fr)) !important;
    gap:5px !important;
  }
  #settingsOverlay .switch-row,
  #settingsOverlay .range-row{
    align-items:flex-start !important;
    flex-wrap:wrap !important;
  }
  #settingsOverlay input[type="range"]{
    width:100% !important;
  }
  @media (max-width: 430px){
    .overlay{
      padding:10px !important;
    }
    .popup{
      width:min(96vw,380px) !important;
      padding:16px 14px !important;
      border-radius:20px !important;
    }
    .popup-title{
      font-size:18px !important;
    }
    .history-table th,
    .history-table td{
      padding:8px 7px !important;
      font-size:11px !important;
    }
    #usersOverlay .active-user-grid{
      grid-template-columns:repeat(6,minmax(0,1fr)) !important;
    }
  }
  @media (max-height: 700px){
    .popup{
      max-height:88dvh !important;
    }
  }
  #autoBetBtn{
    display:none !important;
  }
  .chip-bar{
    grid-template-columns:minmax(0,1fr) !important;
  }
  @media (max-height: 450px){
    .app.mode-vh450{
      contain:none !important;
    }
    .app.mode-vh450 .shell{
      position:absolute !important;
      inset:0 !important;
      height:auto !important;
      min-height:0 !important;
      padding:calc(var(--safe-top) + 2px) 6px calc(var(--safe-bottom) + 48px) !important;
      gap:3px !important;
      grid-template-rows:auto minmax(0,1fr) auto auto auto !important;
    }
    .app.mode-vh450 .topbar{
      grid-template-columns:minmax(0,1fr) auto !important;
      align-items:center !important;
      gap:4px !important;
      min-height:38px !important;
    }
    .app.mode-vh450 .balance-card{
      min-height:30px !important;
      padding:4px 6px !important;
      border-radius:12px !important;
      gap:5px !important;
    }
    .app.mode-vh450 .balance-value{
      font-size:11px !important;
      gap:4px !important;
    }
    .app.mode-vh450 .balance-value .coin{
      width:16px !important;
      height:16px !important;
    }
    .app.mode-vh450 .player-flip-card{
      gap:4px !important;
      min-height:12px !important;
    }
    .app.mode-vh450 .player-flip-label{
      font-size:7px !important;
      letter-spacing:.12em !important;
    }
    .app.mode-vh450 .player-flip-value{
      min-width:0 !important;
      max-width:92px !important;
      font-size:9px !important;
    }
    .app.mode-vh450 .top-actions{
      display:flex !important;
      align-items:center !important;
      padding:2px !important;
      gap:2px !important;
      border-radius:10px !important;
      overflow:visible !important;
    }
    .app.mode-vh450 .icon-btn{
      width:24px !important;
      height:24px !important;
      border-radius:8px !important;
    }
    .app.mode-vh450 .icon-btn svg{
      width:13px !important;
      height:13px !important;
    }
    .app.mode-vh450 .topbar-meta{
      display:flex !important;
      grid-column:1 / -1 !important;
      align-items:center !important;
      justify-content:center !important;
      gap:0 !important;
      margin-top:0 !important;
    }
    .app.mode-vh450 .topbar-meta .round-chip,
    .app.mode-vh450 .topbar-meta .network-pill{
      display:none !important;
    }
    .app.mode-vh450 .topbar-meta .payout-chip{
      width:100% !important;
      min-height:20px !important;
      padding:3px 8px !important;
      border-radius:11px !important;
      font-size:8px !important;
      justify-content:center !important;
      gap:5px !important;
    }
    .app.mode-vh450 .topbar-meta .payout-chip b{
      font-size:9px !important;
    }
    .app.mode-vh450 .hero-zone{
      gap:3px !important;
    }
    .app.mode-vh450 .hero-panel{
      padding:3px 4px 4px !important;
      border-radius:16px !important;
    }
    .app.mode-vh450 .hero-inner{
      padding:0 !important;
      gap:3px !important;
    }
    .app.mode-vh450 .wheel-wrap{
      width:154px !important;
      height:154px !important;
      max-width:154px !important;
      max-height:154px !important;
      filter:drop-shadow(0 8px 14px rgba(0,0,0,.18)) !important;
    }
    .app.mode-vh450 .wheel-wrap::before{
      opacity:.26 !important;
      filter:blur(6px) !important;
      animation-duration:20s !important;
    }
    .app.mode-vh450 .wheel-wrap::after{
      opacity:.3 !important;
      box-shadow:0 0 12px rgba(86,180,255,.06), inset 0 0 0 1px rgba(255,255,255,.05), inset 0 8px 14px rgba(255,255,255,.04) !important;
    }
    .app.mode-vh450 .wheel-aura{
      inset:-4% !important;
      filter:blur(9px) !important;
      opacity:.52 !important;
      animation-duration:5.2s !important;
    }
    .app.mode-vh450 .wheel,
    .app.mode-vh450 .wheel-inner{
      backdrop-filter:none !important;
      -webkit-backdrop-filter:none !important;
    }
    .app.mode-vh450 .wheel-inner{
      inset:14px !important;
    }
    .app.mode-vh450 .wheel-center{
      left:50% !important;
      top:50% !important;
      right:auto !important;
      bottom:auto !important;
      width:21.5% !important;
      transform:translate(-50%,-50%) !important;
    }
    .app.mode-vh450 .wheel-icon-seat.slot{
      width:50px !important;
      height:50px !important;
    }
    .app.mode-vh450 .wheel-icon-seat.melon{
      width:48px !important;
      height:48px !important;
    }
    .app.mode-vh450 .wheel-icon-seat.plum{
      width:46px !important;
      height:46px !important;
    }
    .app.mode-vh450 .wheel-icon-seat .wheel-fruit-icon{
      width:100% !important;
      height:100% !important;
      transform:translateY(-1px) scale(.98) !important;
    }
    .app.mode-vh450 .wheel-icon-seat .slot-seat-stack{
      transform:translateY(1px) scale(.78) !important;
    }
    .app.mode-vh450 .wheel-icon-seat .slot-seat-icon{
      font-size:9px !important;
    }
    .app.mode-vh450 .wheel-mark-icon{
      font-size:19px !important;
      padding:0 4px !important;
    }
    .app.lucky77-plain-wheel.mode-vh450 .wheel-mark-plain.slot{
      font-size:22px !important;
    }
    .app.lucky77-plain-wheel.mode-vh450 .wheel-mark-plain.melon,
    .app.lucky77-plain-wheel.mode-vh450 .wheel-mark-plain.plum{
      font-size:34px !important;
    }
    .app.mode-vh450 .wheel-wrap.is-spinning .wheel-aura{
      filter:blur(11px) !important;
      opacity:.66 !important;
      animation-duration:2.4s !important;
    }
    .app.mode-vh450 .wheel-wrap.is-spinning .wheel-ticks{
      animation-duration:1.8s !important;
    }
    .app.mode-vh450 .wheel-wrap.is-spinning .wheel-spark{
      animation-duration:2.2s !important;
      opacity:.58 !important;
    }
    .app.mode-vh450 .pointer-wrap{
      width:24px !important;
      height:32px !important;
    }
    .app.mode-vh450 .counter{
      font-size:16px !important;
    }
    .app.mode-vh450 .counter.small{
      font-size:10px !important;
    }
    .app.mode-vh450 .bets{
      min-height:62px !important;
      gap:5px !important;
    }
    .app.mode-vh450 .bet-card{
      min-height:62px !important;
      padding:5px 5px 6px !important;
      border-radius:12px !important;
      gap:3px !important;
    }
    .app.mode-vh450 .bet-amount{
      min-width:32px !important;
      padding:2px 5px !important;
      font-size:9px !important;
    }
    .app.mode-vh450 .bet-icon-wrap{
      width:28px !important;
      height:28px !important;
    }
    .app.mode-vh450 .fruit-icon{
      width:22px !important;
      height:22px !important;
    }
    .app.mode-vh450 .bet-slot{
      font-size:17px !important;
    }
    .app.mode-vh450 .bet-multi{
      font-size:10px !important;
    }
    .app.mode-vh450 .chip-bar{
      position:absolute !important;
      left:0 !important;
      right:0 !important;
      bottom:0 !important;
      width:100% !important;
      height:42px !important;
      min-height:42px !important;
      padding:3px 6px !important;
      grid-template-columns:minmax(0,1fr) !important;
      gap:0 !important;
      align-items:center !important;
      z-index:24 !important;
    }
    .app.mode-vh450 .chip-rail{
      width:100% !important;
      height:34px !important;
      min-height:34px !important;
      padding:2px 8px !important;
      border-radius:12px !important;
      overflow:visible !important;
    }
    .app.mode-vh450 .chip-scroll{
      display:grid !important;
      grid-template-columns:repeat(5,minmax(0,1fr)) !important;
      height:100% !important;
      align-items:center !important;
      justify-items:center !important;
      gap:4px !important;
      padding:0 !important;
      overflow:visible !important;
    }
    .app.mode-vh450 .chip,
    .app.mode-vh450 .chip svg{
      width:32px !important;
      height:32px !important;
    }
    .app.mode-vh450 .chip-label{
      display:grid !important;
      font-size:8px !important;
      letter-spacing:-.03em !important;
      text-shadow:0 1px 2px rgba(0,0,0,.78), 0 0 4px rgba(0,0,0,.42) !important;
    }
    .app.mode-vh450 .action-box{
      display:none !important;
    }
    .popup{
      width:min(96vw,320px) !important;
      max-height:min(82dvh,360px) !important;
      padding:14px 12px !important;
      border-radius:18px !important;
      gap:10px !important;
    }
    .popup-title{
      font-size:18px !important;
    }
    .popup-sub{
      font-size:11px !important;
      line-height:1.4 !important;
    }
    .popup-close{
      flex:0 0 32px !important;
      width:32px !important;
      height:32px !important;
      border-radius:12px !important;
    }
    .tile-grid{
      gap:8px !important;
      margin-top:8px !important;
    }
    .tile{
      padding:10px !important;
      border-radius:16px !important;
    }
    .tile b{
      font-size:12px !important;
      margin-bottom:4px !important;
    }
    .tile span{
      font-size:10px !important;
      line-height:1.35 !important;
    }
    .popup-cta{
      margin-top:10px !important;
      height:40px !important;
      border-radius:12px !important;
    }
    .history-panel{
      padding:10px !important;
      border-radius:16px !important;
    }
    .history-panel-title{
      font-size:12px !important;
    }
    .history-panel-sub{
      font-size:10px !important;
    }
    .history-table th,
    .history-table td{
      padding:7px 6px !important;
      font-size:10px !important;
    }
    #settingsOverlay .switch-row,
    #settingsOverlay .range-row{
      gap:8px !important;
    }
    #settingsOverlay .switch-label{
      font-size:12px !important;
    }
    #settingsOverlay .switch-sub{
      font-size:10px !important;
    }
    #settingsOverlay .switch-row,
    #settingsOverlay .range-row{
      padding:8px 0 !important;
    }
    #settingsOverlay .switch-sub{
      margin-top:1px !important;
    }
    #settingsOverlay .switch{
      width:46px !important;
      height:28px !important;
    }
    #settingsOverlay .switch::after{
      top:2px !important;
      left:2px !important;
      width:22px !important;
      height:22px !important;
    }
    #settingsOverlay .switch.on::after{
      left:22px !important;
    }
    #settingsOverlay input[type="range"]{
      width:108px !important;
    }
    #settingsOverlay .popup-cta{
      margin-top:6px !important;
      height:36px !important;
    }
    #helpOverlay .tile-grid{
      grid-template-columns:repeat(2,minmax(0,1fr)) !important;
      gap:6px !important;
    }
  }
</style>

    <div class="splash" id="splash">
      <div class="splash-box">
        <div class="brand">{{ config('bd_game_final.games.' . $currentGameCode . '.name', 'Lucky 77') }}</div>
        <div class="brand-sub">{{ $brandSub }}</div>
        <div class="splash-loader"><div class="splash-fill" id="splashFill"></div></div>
        <div class="splash-log" id="splashLog">Preparing stage lights…</div>
      </div>
    </div>
  </div>

  <script>

    const segments = [
      { key:'slot', type:'slot' },
      { key:'melon', type:'melon' },
      { key:'plum', type:'plum' },
      { key:'melon', type:'melon' },
      { key:'plum', type:'plum' }
    ];
    const currentGameCode = @json($currentGameCode);
    const useSharedFruitWheelItems = @json(!$isLucky88MasterVariant);
    const basePointerRotation = -((360 / segments.length) / 2);
    const isLucky7Pro = currentGameCode === 'lucky7_pro';
    const isLucky88Master = currentGameCode === 'lucky88_master';
    const slotDisplayMark = @json($slotDisplayMark);
    const slotJackpotTitle = @json($slotJackpotTitle);
    const slotSeatIcon = @json($slotSeatIcon);
    const boardPayoutMultipliers = @json($boardPayoutMultipliers);
    const luckyChipTheme = @json($luckyVariant['chip_theme']);
    const luckyIconTheme = @json($luckyVariant['icon_theme']);
    const betKeyMarks = @json($betKeyMarks);
    const storageSuffix = currentGameCode.replace(/[^a-z0-9_]+/gi, '_').toLowerCase();
    const STORAGE_KEYS = { round:`${storageSuffix}_round`, helpSeen:`${storageSuffix}_help_seen` };
    const hasLiveSession = @json((bool) ($sessionToken ?? null));
    const allowStandalonePreview = false;
    const useStandalonePreview = false;

    function loadRound(){
      try {
        const raw = Number(localStorage.getItem(STORAGE_KEYS.round) || '1');
        return Number.isFinite(raw) && raw > 0 ? Math.floor(raw) : 1;
      } catch (e) {
        return 1;
      }
    }

    const state = {
      balance: 0,
      currentChip: 1000,
      bets: { melon: 0, slot: 0, plum: 0 },
      boardTotals: { melon: 0, slot: 0, plum: 0 },
      previousBets: null,
      results: [],
      history: [],
      round: 0,
      phase: 'idle',
      counter: '--',
      spinning: false,
      autoBet: false,
      rotation: basePointerRotation,
      fxReduced: false,
      soundOn: true,
      musicOn: true,
      network: 'good',
      toastToken: 0,
      bannerToken: 0,
      proPopupToken: 0,
      timers: new Set(),
      networkTimer: null,
      countdownTimer: null,
      paused: false,
      cleanupDone: false,
      splashDone: false,
      splashInterval: null,
      splashForceTimer: null,
      reconnecting: false,
      betLockUntil: 0,
      prevBalance: 0,
    };
    let boardHistoryRows = [];
    let userHistoryRows = [];
    let activePlayerRows = [];
    const historyBoardKeys = ['melon', 'slot', 'plum'];
    let historySyncInFlight = false;
    let lastHistorySyncRound = '';
    let activeWheelAnimationFrame = 0;
    let activeWheelAnimationToken = 0;
    const trackedRoomMedia = new Set();
    const trackedRoomAudioContexts = new Set();
    let audioTrackingInstalled = false;

    const el = {
      app: document.getElementById('app'),
      wheelInner: document.getElementById('wheelInner'),
      pointerWrap: document.getElementById('pointerWrap'),
      counter: document.getElementById('counter'),
      modeText: document.getElementById('modeText'),
      roundText: document.getElementById('roundText'),
      balanceText: document.getElementById('balanceText'),
      balanceValue: document.getElementById('balanceValue'),
      balanceCard: document.getElementById('balanceCard'),
      balanceDelta: document.getElementById('balanceDelta'),
      playerFlipValue: document.getElementById('playerFlipValue'),
      balancePopupText: document.getElementById('balancePopupText'),
      recentTrack: document.getElementById('recentTrack'),
      historyList: document.getElementById('historyList'),
      usersList: document.getElementById('usersList'),
      utilityToast: document.getElementById('utilityToast'),
      bannerStart: document.getElementById('bannerStart'),
      bannerStop: document.getElementById('bannerStop'),
      bannerWin: document.getElementById('bannerWin'),
      bannerWinTitle: document.getElementById('bannerWinTitle'),
      bannerWinSub: document.getElementById('bannerWinSub'),
      bannerNet: document.getElementById('bannerNet'),
      proPhaseOverlay: document.getElementById('proPhaseOverlay'),
      proPhasePopup: document.getElementById('proPhasePopup'),
      proPhasePill: document.getElementById('proPhasePill'),
      proPhaseTitle: document.getElementById('proPhaseTitle'),
      proPhaseSub: document.getElementById('proPhaseSub'),
      networkPill: document.getElementById('networkPill'),
      networkText: document.getElementById('networkText'),
      networkOverlay: document.getElementById('networkOverlay'),
      networkStatusText: document.getElementById('networkStatusText'),
      chipFlyLayer: document.getElementById('chipFlyLayer'),
      sparkLayer: document.getElementById('sparkLayer'),
      confettiLayer: document.getElementById('confettiLayer'),
      autoBetBtn: document.getElementById('autoBetBtn'),
      splash: document.getElementById('splash'),
      splashFill: document.getElementById('splashFill'),
      splashLog: document.getElementById('splashLog'),
      payoutBtn: document.getElementById('payoutBtn'),
      wheelWrap: document.getElementById('wheelWrap'),
      heroInner: document.getElementById('heroInner') || document.querySelector('.hero-inner'),
    };

    const betCards = Array.from(document.querySelectorAll('.bet-card'));
    const chips = Array.from(document.querySelectorAll('.chip'));
    const playerIdentityFrames = [@json($displayUserName ?? 'Player'), @json(isset($displayUserId) && $displayUserId ? ('ID ' . $displayUserId) : null)].filter(Boolean);
    let playerIdentityIndex = 0;
    let playerIdentityTimer = null;

    function rememberMediaNode(node){
      if(node && (node.tagName === 'AUDIO' || node.tagName === 'VIDEO')){
        trackedRoomMedia.add(node);
      }
      return node;
    }

    function rememberExistingMedia(){
      document.querySelectorAll('audio,video').forEach(rememberMediaNode);
    }

    function wrapAudioContextCtor(key){
      const OriginalCtor = window[key];
      if(typeof OriginalCtor !== 'function' || OriginalCtor.__lucky77AudioWrapped) return;
      const WrappedCtor = new Proxy(OriginalCtor, {
        construct(target, args, newTarget){
          const ctx = Reflect.construct(target, args, newTarget);
          trackedRoomAudioContexts.add(ctx);
          return ctx;
        }
      });
      Object.defineProperty(WrappedCtor, '__lucky77AudioWrapped', { value: true, configurable: true });
      window[key] = WrappedCtor;
    }

    function installAudioTracking(){
      if(audioTrackingInstalled) return;
      audioTrackingInstalled = true;
      rememberExistingMedia();
      if(window.HTMLMediaElement && HTMLMediaElement.prototype && !HTMLMediaElement.prototype.__lucky77PlayWrapped){
        const nativePlay = HTMLMediaElement.prototype.play;
        Object.defineProperty(HTMLMediaElement.prototype, '__lucky77PlayWrapped', { value: true, configurable: true });
        HTMLMediaElement.prototype.play = function(...args){
          rememberMediaNode(this);
          return nativePlay.apply(this, args);
        };
      }
      if(window.Document && Document.prototype && !Document.prototype.__lucky77CreateElementWrapped){
        const nativeCreateElement = Document.prototype.createElement;
        Object.defineProperty(Document.prototype, '__lucky77CreateElementWrapped', { value: true, configurable: true });
        Document.prototype.createElement = function(tagName, options){
          const node = nativeCreateElement.call(this, tagName, options);
          if(typeof tagName === 'string' && /^(audio|video)$/i.test(tagName)){
            rememberMediaNode(node);
          }
          return node;
        };
      }
      if(typeof window.Audio === 'function' && !window.Audio.__lucky77AudioWrapped){
        const NativeAudio = window.Audio;
        const WrappedAudio = new Proxy(NativeAudio, {
          apply(target, thisArg, args){
            return rememberMediaNode(Reflect.apply(target, thisArg, args));
          },
          construct(target, args, newTarget){
            return rememberMediaNode(Reflect.construct(target, args, newTarget));
          }
        });
        Object.defineProperty(WrappedAudio, '__lucky77AudioWrapped', { value: true, configurable: true });
        window.Audio = WrappedAudio;
      }
      wrapAudioContextCtor('AudioContext');
      wrapAudioContextCtor('webkitAudioContext');
    }

    function stopAudioHandle(target, permanent, seen){
      if(!target) return;
      const valueType = typeof target;
      if(valueType !== 'object' && valueType !== 'function') return;
      if(seen.has(target)) return;
      seen.add(target);

      if(target instanceof HTMLMediaElement){
        rememberMediaNode(target);
        try { target.pause(); } catch (e) {}
        if(permanent){
          try { target.currentTime = 0; } catch (e) {}
          try { target.srcObject = null; } catch (e) {}
        }
        return;
      }

      if(Array.isArray(target)){
        target.forEach(item => stopAudioHandle(item, permanent, seen));
        return;
      }

      if(target instanceof Set){
        target.forEach(item => stopAudioHandle(item, permanent, seen));
        return;
      }

      if(target instanceof Map){
        target.forEach(item => stopAudioHandle(item, permanent, seen));
        return;
      }

      if(typeof target.pause === 'function'){
        try { target.pause(); } catch (e) {}
      }
      if(typeof target.stop === 'function'){
        try { target.stop(); } catch (e) {}
      }
      if(typeof target.suspend === 'function'){
        try { target.suspend(); } catch (e) {}
      }
      if(typeof target.disconnect === 'function'){
        try { target.disconnect(); } catch (e) {}
      }
      if(permanent && typeof target.close === 'function'){
        try { target.close(); } catch (e) {}
      }
    }

    function syncRoomMediaPreference(){
      rememberExistingMedia();
      const muteRoomMedia = !state.musicOn;
      trackedRoomMedia.forEach(media => {
        if(!media || !media.isConnected && !media.currentSrc && !media.src) return;
        try { media.muted = muteRoomMedia; } catch (e) {}
        if(muteRoomMedia){
          try { media.pause(); } catch (e) {}
        }
      });
      if(window.Howler && typeof window.Howler.mute === 'function'){
        try { window.Howler.mute(muteRoomMedia); } catch (e) {}
      }
      if(muteRoomMedia){
        silenceRoomAudio(false);
      }
    }

    function silenceRoomAudio(permanent){
      const seen = new WeakSet();
      rememberExistingMedia();
      trackedRoomMedia.forEach(media => stopAudioHandle(media, permanent, seen));
      trackedRoomAudioContexts.forEach(ctx => stopAudioHandle(ctx, permanent, seen));
      [
        'Howler',
        'howler',
        'musicEngine',
        'audioCtx',
        'musicCtx',
        'backgroundMusic',
        'ambientAudio',
        'roomMusic',
        'roomAudio',
        'soundtrack',
        'bgm'
      ].forEach(key => {
        try { stopAudioHandle(window[key], permanent, seen); } catch (e) {}
      });
      Object.keys(window).forEach(key => {
        if(!/(audio|music|sound|bgm|ambient)/i.test(key)) return;
        try { stopAudioHandle(window[key], permanent, seen); } catch (e) {}
      });
      if(window.Howler && typeof window.Howler.stop === 'function'){
        try { window.Howler.stop(); } catch (e) {}
      }
      if(permanent){
        trackedRoomAudioContexts.clear();
      }
    }

    function updatePlayerIdentity(nextIndex, immediate){
      if(!el.playerFlipValue || !playerIdentityFrames.length) return;
      const normalizedIndex = nextIndex % playerIdentityFrames.length;
      const nextValue = playerIdentityFrames[normalizedIndex];
      if(immediate || playerIdentityFrames.length === 1){
        el.playerFlipValue.textContent = nextValue;
        playerIdentityIndex = normalizedIndex;
        return;
      }
      el.playerFlipValue.classList.remove('flip-in');
      el.playerFlipValue.classList.add('flip-out');
      window.setTimeout(function(){
        el.playerFlipValue.textContent = nextValue;
        el.playerFlipValue.classList.remove('flip-out');
        el.playerFlipValue.classList.add('flip-in');
        window.setTimeout(function(){
          if (el.playerFlipValue) el.playerFlipValue.classList.remove('flip-in');
        }, 340);
      }, 160);
      playerIdentityIndex = normalizedIndex;
    }

    function startPlayerIdentityFlip(){
      if (playerIdentityTimer) window.clearInterval(playerIdentityTimer);
      updatePlayerIdentity(0, true);
      if (playerIdentityFrames.length < 2) return;
      playerIdentityTimer = window.setInterval(function(){
        updatePlayerIdentity(playerIdentityIndex + 1, false);
      }, 2400);
    }

    function saveRound(){
      try{ localStorage.setItem(STORAGE_KEYS.round, String(state.round)); }catch(e){}
    }


    function applyViewportMode(){
      const h = window.innerHeight || document.documentElement.clientHeight;
      const w = window.innerWidth || document.documentElement.clientWidth;
      const tight = h <= 620;
      const mode450 = h <= 450;
      el.app.classList.toggle('mode-tight', tight);
      el.app.classList.toggle('mode-vh450', mode450);
      el.app.style.width = mode450 ? `${w}px` : '';
      el.app.style.maxWidth = mode450 ? `${w}px` : '';
      el.app.style.maxHeight = mode450 ? 'none' : '';
      requestAnimationFrame(() => {
        ensureWheelCircle();
        buildWheel();
      });
    }


    function ensureWheelCircle(){
      const wrap = el.wheelWrap;
      const hero = el.heroInner;
      if(!wrap || !hero) return;
      const shortH = window.innerHeight <= 450;
      const compactH = window.innerHeight <= 560;
      const pad = shortH ? 2 : compactH ? 4 : 6;

      // Measure the wheel using the responsive CSS rules first. The CSS variable can
      // be an expression like min(46vw,210px), so parseFloat() collapses it to 46.
      wrap.style.removeProperty('--wheel-actual');
      wrap.style.width = '';
      wrap.style.height = '';

      const naturalRect = wrap.getBoundingClientRect();
      const heroW = hero.clientWidth || naturalRect.width || 0;
      const heroH = hero.clientHeight || naturalRect.height || 0;
      const naturalSize = Math.max(0, Math.floor(Math.min(naturalRect.width || 0, naturalRect.height || 0, 448)));
      const maxFit = Math.max(0, Math.floor(Math.min(heroW - pad, heroH - pad, 448)));
      const minimumSize = shortH ? 150 : compactH ? 162 : 170;
      const size = maxFit > 0
        ? Math.min(maxFit, Math.max(naturalSize, Math.min(minimumSize, maxFit)))
        : Math.max(naturalSize, minimumSize);

      if(!size) return;
      wrap.style.setProperty('--wheel-actual', `${size}px`);
      wrap.style.width = `${size}px`;
      wrap.style.height = `${size}px`;
    }

    function money(n){ return String(Math.max(0, Math.floor(Number(n || 0)))); }
    function balanceNumber(n){ return String(Math.max(0, Math.floor(Number(n || 0)))); }
    function payoutFor(key, payload){
      const liveBoard = (payload && payload.boards || []).find(item => item && String(item.frontend_key || item.canonical_key) === String(key));
      const fromPayload = Number(liveBoard && liveBoard.multiplier || 0);
      return fromPayload > 0 ? fromPayload : Number(boardPayoutMultipliers[key] || 1);
    }
    function winnerBannerTitle(winner, winAmount){
      if(Number(winAmount || 0) <= 0) return 'Round Lost';
      return winner === 'slot' ? slotJackpotTitle : 'You Win';
    }
    function payoutThemeForWinner(winner){
      if(winner === 'slot') return { className:'slot', glow:'rgba(255,211,92,.36)', ring:'rgba(255,211,92,.24)' };
      if(winner === 'melon') return { className:'melon', glow:'rgba(255,111,151,.32)', ring:'rgba(255,140,178,.24)' };
      return { className:'plum', glow:'rgba(145,120,255,.34)', ring:'rgba(145,120,255,.24)' };
    }

    function normalizeBoardKey(value){
      if(value === 'melon' || value === 'slot' || value === 'plum') return value;
      if(value === slotDisplayMark) return 'slot';
      if(value === betKeyMarks.melon) return 'melon';
      if(value === betKeyMarks.plum) return 'plum';
      return null;
    }

    function displayMarkForBoard(boardKey, fallback = '-'){
      if(boardKey === 'slot') return slotDisplayMark;
      if(boardKey === 'melon' || boardKey === 'plum') return betKeyMarks[boardKey] || String(boardKey).toUpperCase();
      return fallback;
    }

    function boardTitleForKey(boardKey){
      if(isLucky88Master){
        if(boardKey === 'melon') return 'Dragon';
        if(boardKey === 'slot') return '88';
        if(boardKey === 'plum') return 'Ember';
      }
      return displayMarkForBoard(boardKey, String(boardKey || '-'));
    }

    function iconSvg(type){
      if(useSharedFruitWheelItems && (type === 'melon' || type === 'plum')){
        if(type === 'melon') return `
          <svg class="fruit-icon fruit-icon-melon" viewBox="0 0 64 64" aria-hidden="true">
            <g transform="translate(1.6 1.4) scale(0.955)">
              <path d="M11 35c4-13 16-22 31-22 5 0 9 1 13 3-2 18-16 32-34 34-5 1-9 0-13-2 0-4 1-8 3-13Z" fill="#0f7d43"/>
              <path d="M14 35c3-10 13-18 25-18 4 0 8 1 11 2-2 14-13 25-28 28-4 1-7 0-10-1 0-3 1-6 2-11Z" fill="#ff536f"/>
              <circle cx="24" cy="29" r="1.8" fill="#241014"/><circle cx="31" cy="34" r="1.8" fill="#241014"/><circle cx="39" cy="28" r="1.8" fill="#241014"/>
            </g>
          </svg>`;
        return `
          <svg class="fruit-icon fruit-icon-plum" viewBox="0 0 64 64" aria-hidden="true">
            <g transform="translate(-1.1 1.3) scale(0.955)">
              <circle cx="27" cy="35" r="14" fill="#8952ff"/><circle cx="40" cy="28" r="12" fill="#6b3eff"/><path d="M31 18c4-7 10-10 18-9-3 4-7 7-14 8" fill="#38c97a"/>
              <circle cx="22" cy="31" r="2" fill="#fff" opacity=".35"/><circle cx="37" cy="23" r="2" fill="#fff" opacity=".28"/>
            </g>
          </svg>`;
      }
      if(isLucky88Master && type === 'melon') return `
        <svg class="fruit-icon fruit-icon-master dragon-token" viewBox="0 0 64 64" aria-hidden="true">
          <circle cx="32" cy="32" r="28" fill="#250941"/>
          <circle cx="32" cy="32" r="25.5" fill="#43117a" stroke="#ffd86c" stroke-width="2.6"/>
          <path d="M46 15c-4.6 1-8.5 4-11.6 8.5 3.5-.8 6.9-.2 9.2 1.8-5.7.2-10.1 2.5-13.2 7 2.9 0 5.5.8 7.6 2.4-4.5 1.4-8.4 4.8-11.6 10 4.6-1.6 8.7-1.9 12.4-.9-1.4 3.2-3.8 5.7-7.2 7.7 7.4-.4 12.9-3.9 16.7-10.5 2.4-4.1 3-8.6 1.7-13.5-.8-3.1-2.7-6.3-5.6-9.5Z" fill="#ffd65a"/>
          <path d="M34.5 17.5c2.2-3.1 5.4-5.3 9.7-6.5-1 2.7-2.7 4.8-5.1 6.1 2.8.2 5.2.9 7.2 2.3-2.7 1.4-5.5 2.1-8.6 1.9" fill="#fff4b1"/>
          <circle cx="42.4" cy="24.4" r="1.6" fill="#fffdf4"/>
          <path d="M26.5 42.4c4.2-.8 8.2-.5 11.7 1-2.5 3.4-6.6 5.7-12.2 6.8 1.5-2.2 1.7-4.8.5-7.8Z" fill="#ff4db8"/>
          <path d="M30.6 31.6c3.6-.6 7.1-.1 10.5 1.7-3.1 2.1-6 4.8-8.8 8.2-1.2-2.6-3-4.8-5.5-6.5 1-1.5 2.2-2.7 3.8-3.4Z" fill="#69beff" opacity=".72"/>
        </svg>`;
      if(isLucky88Master && type === 'plum') return `
        <svg class="fruit-icon fruit-icon-master ember-token" viewBox="0 0 64 64" aria-hidden="true">
          <circle cx="32" cy="32" r="28" fill="#2d0823"/>
          <circle cx="32" cy="32" r="25.5" fill="#57103f" stroke="#ffcf6b" stroke-width="2.6"/>
          <path d="M32 8c7.6 7.8 12.6 14.5 14.9 20.2 3.1 7.7 1.8 15.1-3.9 22.1-3.3 4.1-7 6.8-11 8.1-4.2-1.3-8-4-11.3-8.2-5.6-7.1-6.8-14.4-3.6-22 2.4-5.6 7.3-12.4 14.9-20.2Z" fill="#ff7044"/>
          <path d="M34.8 18.6c4.6 5 7.1 9.5 7.6 13.5.7 5.9-1.9 11.2-7.8 15.9-5.1-2.1-8.6-5.5-10.4-10.2-1.9-5 .3-10.8 6.7-17.3.1 4.2 1.4 7 3.9 8.1Z" fill="#ffc642"/>
          <path d="M33.4 27.8c3.2 3.4 4.5 6.5 3.8 9.4-.7 2.8-2.6 5.3-5.6 7.4-3-1.3-5-3.2-6-5.8-1.1-3 .2-6.3 4-10 0 2.2 1.2 3.9 3.8 5.1Z" fill="#fff3ba"/>
          <path d="M46.5 16.6 50.4 20 47 23.7 43.4 20Z" fill="#ffe8a3"/>
          <circle cx="48.2" cy="20.2" r="1.2" fill="#fffaf0"/>
        </svg>`;
      if(luckyIconTheme !== 'classic'){
        const mark = betKeyMarks[type] || String(type || '').slice(0, 2).toUpperCase();
        return `<span class="wheel-mark-icon">${mark}</span>`;
      }
      if(type === 'melon') return `
        <svg class="fruit-icon fruit-icon-melon" viewBox="0 0 64 64" aria-hidden="true">
          <g transform="translate(1.6 1.4) scale(0.955)">
            <path d="M11 35c4-13 16-22 31-22 5 0 9 1 13 3-2 18-16 32-34 34-5 1-9 0-13-2 0-4 1-8 3-13Z" fill="#0f7d43"/>
            <path d="M14 35c3-10 13-18 25-18 4 0 8 1 11 2-2 14-13 25-28 28-4 1-7 0-10-1 0-3 1-6 2-11Z" fill="#ff536f"/>
            <circle cx="24" cy="29" r="1.8" fill="#241014"/><circle cx="31" cy="34" r="1.8" fill="#241014"/><circle cx="39" cy="28" r="1.8" fill="#241014"/>
          </g>
        </svg>`;
      return `
        <svg class="fruit-icon fruit-icon-plum" viewBox="0 0 64 64" aria-hidden="true">
          <g transform="translate(-1.1 1.3) scale(0.955)">
            <circle cx="27" cy="35" r="14" fill="#8952ff"/><circle cx="40" cy="28" r="12" fill="#6b3eff"/><path d="M31 18c4-7 10-10 18-9-3 4-7 7-14 8" fill="#38c97a"/>
            <circle cx="22" cy="31" r="2" fill="#fff" opacity=".35"/><circle cx="37" cy="23" r="2" fill="#fff" opacity=".28"/>
          </g>
        </svg>`;
    }

    function boardBadgeMarkup(value, context = 'history'){
      const boardKey = normalizeBoardKey(value);
      if(!boardKey){
        return { boardKey: null, isHtml: false, content: String(value ?? '-') };
      }
      if(isLucky88Master && boardKey !== 'slot'){
        const badgeClass = context === 'recent' ? 'recent-board-icon' : 'history-board-icon';
        return {
          boardKey,
          isHtml: true,
          content: `<span class="${badgeClass} ${boardKey}" aria-hidden="true">${iconSvg(boardKey)}</span>`
        };
      }
      return {
        boardKey,
        isHtml: false,
        content: displayMarkForBoard(boardKey, String(value ?? '-'))
      };
    }

    function chipSvg(c1,c2,c3){
      const chipKey = `${luckyChipTheme}-${String(c2 || '').replace(/[^a-z0-9]/gi, '')}`;
      if(luckyChipTheme === 'mirage') return `
      <svg viewBox="0 0 64 64" aria-hidden="true">
        <defs>
          <linearGradient id="core-${chipKey}" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0%" stop-color="#fff6de"/>
            <stop offset="22%" stop-color="${c1}"/>
            <stop offset="68%" stop-color="${c2}"/>
            <stop offset="100%" stop-color="${c3}"/>
          </linearGradient>
        </defs>
        <path d="M32 4 49 11 58 28 51 47 32 60 13 47 6 28 15 11Z" fill="url(#core-${chipKey})"/>
        <path d="M32 12 44 17 50 28 44 40 32 52 20 40 14 28 20 17Z" fill="rgba(255,255,255,.12)" stroke="rgba(255,244,214,.55)" stroke-width="1.6"/>
        <circle cx="32" cy="31" r="10.5" fill="rgba(88,46,14,.26)" stroke="rgba(255,240,210,.34)" stroke-width="1.4"/>
      </svg>`;
      if(luckyChipTheme === 'ironfront') return `
      <svg viewBox="0 0 64 64" aria-hidden="true">
        <defs>
          <linearGradient id="core-${chipKey}" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0%" stop-color="#f4f6f8"/>
            <stop offset="26%" stop-color="${c1}"/>
            <stop offset="70%" stop-color="${c2}"/>
            <stop offset="100%" stop-color="${c3}"/>
          </linearGradient>
        </defs>
        <path d="M17 6h30l11 11v30L47 58H17L6 47V17Z" fill="url(#core-${chipKey})"/>
        <path d="M22 14h20l8 8v20l-8 8H22l-8-8V22Z" fill="rgba(255,255,255,.08)" stroke="rgba(255,228,214,.34)" stroke-width="1.4"/>
        <path d="M19 32h26" stroke="rgba(255,255,255,.42)" stroke-width="2" stroke-dasharray="4 4"/>
      </svg>`;
      if(luckyChipTheme === 'lotus') return `
      <svg viewBox="0 0 64 64" aria-hidden="true">
        <defs>
          <radialGradient id="core-${chipKey}" cx="35%" cy="28%">
            <stop offset="0%" stop-color="#ffffff" stop-opacity=".92"/>
            <stop offset="24%" stop-color="${c1}"/>
            <stop offset="70%" stop-color="${c2}"/>
            <stop offset="100%" stop-color="${c3}"/>
          </radialGradient>
        </defs>
        <circle cx="32" cy="32" r="24" fill="url(#core-${chipKey})"/>
        <g fill="rgba(255,255,255,.18)">
          <ellipse cx="32" cy="14" rx="8" ry="12"/>
          <ellipse cx="32" cy="50" rx="8" ry="12"/>
          <ellipse cx="14" cy="32" rx="12" ry="8"/>
          <ellipse cx="50" cy="32" rx="12" ry="8"/>
          <ellipse cx="20" cy="20" rx="7" ry="11" transform="rotate(-45 20 20)"/>
          <ellipse cx="44" cy="20" rx="7" ry="11" transform="rotate(45 44 20)"/>
        </g>
        <circle cx="32" cy="32" r="10" fill="rgba(16,34,28,.28)" stroke="rgba(255,255,255,.32)" stroke-width="1.4"/>
      </svg>`;
      if(luckyChipTheme === 'nebula') return `
      <svg viewBox="0 0 64 64" aria-hidden="true">
        <defs>
          <radialGradient id="core-${chipKey}" cx="38%" cy="28%">
            <stop offset="0%" stop-color="#ffffff" stop-opacity=".94"/>
            <stop offset="22%" stop-color="${c1}"/>
            <stop offset="70%" stop-color="${c2}"/>
            <stop offset="100%" stop-color="${c3}"/>
          </radialGradient>
        </defs>
        <circle cx="32" cy="32" r="27" fill="url(#core-${chipKey})"/>
        <circle cx="32" cy="32" r="18" fill="none" stroke="rgba(255,255,255,.42)" stroke-width="1.8" stroke-dasharray="2.4 5.2"/>
        <ellipse cx="32" cy="32" rx="24" ry="10" fill="none" stroke="rgba(164,222,255,.34)" stroke-width="1.6" transform="rotate(-24 32 32)"/>
        <circle cx="32" cy="32" r="8.4" fill="rgba(8,18,54,.36)" stroke="rgba(255,255,255,.3)" stroke-width="1.3"/>
      </svg>`;
      if(luckyChipTheme === 'carnival') return `
      <svg viewBox="0 0 64 64" aria-hidden="true">
        <defs>
          <linearGradient id="core-${chipKey}" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0%" stop-color="#fff7d8"/>
            <stop offset="18%" stop-color="${c1}"/>
            <stop offset="62%" stop-color="${c2}"/>
            <stop offset="100%" stop-color="${c3}"/>
          </linearGradient>
        </defs>
        <circle cx="32" cy="32" r="28" fill="url(#core-${chipKey})"/>
        <circle cx="32" cy="32" r="22" fill="none" stroke="rgba(255,255,255,.42)" stroke-width="7" stroke-dasharray="3 7"/>
        <path d="M32 16 40 24 32 32 24 24Z" fill="rgba(255,255,255,.22)"/>
        <path d="M32 32 40 40 32 48 24 40Z" fill="rgba(0,0,0,.16)"/>
      </svg>`;
      return `
      <svg viewBox="0 0 64 64" aria-hidden="true">
        <defs>
          <radialGradient id="core-${chipKey}" cx="35%" cy="30%">
            <stop offset="0%" stop-color="#fff" stop-opacity=".85"/>
            <stop offset="18%" stop-color="${c1}"/>
            <stop offset="68%" stop-color="${c2}"/>
            <stop offset="100%" stop-color="${c3}"/>
          </radialGradient>
        </defs>
        <circle cx="32" cy="32" r="30" fill="url(#core-${chipKey})"/>
        <circle cx="32" cy="32" r="24" fill="none" stroke="rgba(255,255,255,.55)" stroke-width="2" stroke-dasharray="4 6"/>
        <circle cx="32" cy="32" r="17" fill="rgba(255,255,255,.12)" stroke="rgba(255,255,255,.28)" stroke-width="1.5"/>
      </svg>`;
    }

    function setupChips(){
      chips.forEach(chip => {
        const styles = getComputedStyle(chip);
        chip.innerHTML = chipSvg(styles.getPropertyValue('--c1').trim(), styles.getPropertyValue('--c2').trim(), styles.getPropertyValue('--c3').trim()) + `<span class="chip-label">${labelForChip(chip.dataset.value)}</span>`;
      });
    }

    function setupBetIcons(){
      const melonWrap = document.querySelector('.bet-card[data-bet="melon"] .bet-icon-wrap');
      const plumWrap = document.querySelector('.bet-card[data-bet="plum"] .bet-icon-wrap');
      const slotWrap = document.querySelector('.bet-card[data-bet="slot"] .bet-icon-wrap');
      if(melonWrap) melonWrap.innerHTML = `<span class="wheel-fruit-icon bet-wheel-icon">${iconSvg('melon')}</span>`;
      if(plumWrap) plumWrap.innerHTML = `<span class="wheel-fruit-icon bet-wheel-icon">${iconSvg('plum')}</span>`;
      if(slotWrap) slotWrap.innerHTML = `<span class="slot-seat-stack"><span class="slot-seat-icon">${slotSeatIcon}</span><span class="slot77">${slotDisplayMark}</span></span>`;
    }

    function labelForChip(v){
      const n = Number(v);
      if(n >= 1000) return `${n/1000}K`;
      return String(n);
    }

    function buildWheel(){
      el.wheelInner.innerHTML = '';
      ensureWheelCircle();
      const step = 360 / segments.length;
      const wheelSize = el.wheelInner.clientWidth || el.wheelWrap.clientWidth || 300;
      const center = wheelSize / 2;
      const compactWheel = !!(el.app && el.app.classList.contains('mode-vh450'));
      const cfg = compactWheel
        ? (isLucky88Master ? {
            slot:  { radius: 0.332, seat: 52, font: 32, dx: 0, dy: -1 },
            melon: { radius: 0.328, seat: 50, font: 34, dx: 0, dy: 0 },
            plum:  { radius: 0.328, seat: 48, font: 32, dx: 0, dy: 0 }
          } : {
            slot:  { radius: 0.332, seat: 50, font: 32, dx: 0, dy: -1 },
            melon: { radius: 0.324, seat: 48, font: 30, dx: 0, dy: -1 },
            plum:  { radius: 0.322, seat: 46, font: 29, dx: 0, dy: -1 }
          })
        : (isLucky88Master ? {
            slot:  { radius: 0.33, seat: 54, font: 38, dx: 0, dy: -1 },
            melon: { radius: 0.328, seat: 54, font: 42, dx: 0, dy: 0 },
            plum:  { radius: 0.328, seat: 52, font: 40, dx: 0, dy: 0 }
          } : {
            slot:  { radius: 0.365, seat: 50, font: 37, dx: 0, dy: -2 },
            melon: { radius: 0.354, seat: 50, font: 43, dx: 0, dy: -1 },
            plum:  { radius: 0.352, seat: 48, font: 41, dx: 0, dy: -1 }
          });

      segments.forEach((seg, i) => {
        const wedge = document.createElement('div');
        wedge.className = `seg ${seg.type === 'slot' ? 'slot' : seg.key}`;
        wedge.dataset.index = i;
        wedge.dataset.key = seg.key;
        wedge.style.transform = `rotate(${i * step}deg)`;
        wedge.innerHTML = `<div class="seg-core"></div>`;
        el.wheelInner.appendChild(wedge);
      });

      segments.forEach((seg, i) => {
        const c = cfg[seg.type] || cfg.melon;
        const angleDeg = i * step + (step / 2) - 90;
        const angle = angleDeg * Math.PI / 180;
        const x = center + Math.cos(angle) * (wheelSize * c.radius) + c.dx;
        const y = center + Math.sin(angle) * (wheelSize * c.radius) + c.dy;

        const seat = document.createElement('div');
        seat.className = `wheel-icon-seat ${seg.type === 'slot' ? 'slot' : seg.key}`;
        seat.dataset.index = i;
        seat.dataset.key = seg.key;
        seat.style.left = `${x}px`;
        seat.style.top = `${y}px`;
        const font = Math.max(
          compactWheel
            ? (isLucky88Master ? (seg.type === 'slot' ? 30 : 32) : (seg.type === 'slot' ? 30 : 28))
            : (isLucky88Master ? (seg.type === 'slot' ? 36 : 42) : (seg.type === 'slot' ? 28 : 26)),
          Math.round(wheelSize * (c.font / 342))
        );
        if(seg.type === 'slot') {
          seat.innerHTML = `<span class="slot-seat-stack"><span class="slot-seat-icon">${slotSeatIcon}</span><span class="slot77" style="font-size:${font}px">${slotDisplayMark}</span></span>`;
        } else {
          seat.innerHTML = `<span class="wheel-fruit-icon" style="width:${font}px;height:${font}px">${iconSvg(seg.type)}</span>`;
        }
        el.wheelInner.appendChild(seat);
      });
      el.wheelInner.style.transition = 'none';
      el.wheelInner.style.transform = `rotate(${state.rotation}deg)`;
    }

    function stopWheelAnimation(){
      activeWheelAnimationToken += 1;
      if(activeWheelAnimationFrame){
        cancelAnimationFrame(activeWheelAnimationFrame);
        activeWheelAnimationFrame = 0;
      }
      if(el.wheelWrap) el.wheelWrap.classList.remove('is-spinning');
      el.wheelInner.style.transition = 'none';
    }

    function setWheelRotation(angle){
      state.rotation = Number(angle || 0);
      el.wheelInner.style.transition = 'none';
      el.wheelInner.style.transform = `rotate(${state.rotation}deg)`;
    }

    function animateWheelRotation(targetRotation, durationMs){
      const endRotation = Number(targetRotation || 0);
      if(!Number.isFinite(endRotation)) return;

      stopWheelAnimation();
      const startRotation = Number(state.rotation || 0);
      if(!durationMs || durationMs <= 0 || startRotation === endRotation){
        setWheelRotation(endRotation);
        return;
      }

      const token = activeWheelAnimationToken;
      const startedAt = performance.now();
      const totalMs = Math.max(180, Number(durationMs || 0));
      if(el.wheelWrap && !state.fxReduced) el.wheelWrap.classList.add('is-spinning');

      const tick = (now) => {
        if(token !== activeWheelAnimationToken) return;
        const progress = Math.min(1, (now - startedAt) / totalMs);
        const eased = 1 - Math.pow(1 - progress, 4.6);
        state.rotation = startRotation + ((endRotation - startRotation) * eased);
        el.wheelInner.style.transform = `rotate(${state.rotation}deg)`;
        if(progress < 1){
          activeWheelAnimationFrame = requestAnimationFrame(tick);
          return;
        }
        activeWheelAnimationFrame = 0;
        state.rotation = endRotation;
        el.wheelInner.style.transform = `rotate(${state.rotation}deg)`;
        if(el.wheelWrap) el.wheelWrap.classList.remove('is-spinning');
      };

      activeWheelAnimationFrame = requestAnimationFrame(tick);
    }

    function renderRecent(){
      el.recentTrack.innerHTML = '';
      state.results.slice(-10).reverse().forEach(item => {
        const badge = boardBadgeMarkup(item, 'recent');
        const pill = document.createElement('div');
        pill.className = `recent-pill ${badge.boardKey === 'slot' ? 'slot' : ''}`;
        if(badge.boardKey){
          const title = boardTitleForKey(badge.boardKey);
          pill.title = title;
          pill.setAttribute('aria-label', title);
        }
        if(badge.isHtml) pill.innerHTML = badge.content;
        else pill.textContent = badge.content;
        el.recentTrack.appendChild(pill);
      });
    }

    function renderHistory(){
      boardHistoryRows = state.history.slice().reverse().map((item) => ({
        round_no: item && item.round ? String(item.round) : '-',
        winner_board_key: item && (item.resultKey || item.result) ? String(item.resultKey || item.result) : '',
        decision_mode: 'live',
      }));
      renderHistoryOverlay();
    }

    function escapeHistoryHtml(value){
      return String(value == null ? '' : value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
    }

    function historyBoardMarkup(boardKey){
      const badge = boardBadgeMarkup(boardKey, 'history');
      const title = badge.boardKey ? boardTitleForKey(badge.boardKey) : 'Result';
      return `
        <div class="history-board-cell">
          ${historyBoardToken(boardKey)}
          <span>${escapeHistoryHtml(title)}</span>
        </div>
      `;
    }

    function historyBoardToken(boardKey){
      const badge = boardBadgeMarkup(boardKey, 'history');
      const title = badge.boardKey ? boardTitleForKey(badge.boardKey) : 'Result';
      const content = badge.isHtml ? badge.content : escapeHistoryHtml(badge.content);
      const boardClass = badge.boardKey ? ` ${escapeHistoryHtml(badge.boardKey)}${badge.boardKey === 'slot' ? ' slot' : ''}` : '';
      return `<span class="history-board-token${boardClass}" title="${escapeHistoryHtml(title)}" aria-label="${escapeHistoryHtml(title)}">${content}</span>`;
    }

    function historyBoardHeaderCells(){
      return historyBoardKeys.map((boardKey) => `<th class="history-board-label">${escapeHistoryHtml(boardTitleForKey(boardKey))}</th>`).join('');
    }

    function historyWinnerKeyFromItem(item){
      return normalizeBoardKey(item && (item.winner_board_key || item.winner_board || item.board_key || item.resultKey || item.result) || item || '');
    }

    function historyWinnerBoardCells(item){
      const winnerKey = historyWinnerKeyFromItem(item);
      return historyBoardKeys.map((boardKey) => {
        const isWinner = boardKey === winnerKey;
        const title = `${boardTitleForKey(boardKey)}${isWinner ? ' winner' : ''}`;
        return `<td class="history-board-token-cell${isWinner ? ' is-winner' : ''}" title="${escapeHistoryHtml(title)}">${isWinner ? historyBoardToken(boardKey) : ''}</td>`;
      }).join('');
    }

    function historyRoundLabel(value){
      if(value && typeof value === 'object') value = value.round_short || value.trace_short || value.round_no || value.round_id || value.trace_id || '-';
      const raw = String(value || '-');
      const tail = raw.split('_').pop() || raw;
      if(/^\d{7,}$/.test(tail)) return tail.slice(-6);
      return raw.length > 10 ? raw.slice(-10) : raw;
    }

    function historyOutcomeBadge(item){
      const outcome = String(item && (item.user_outcome || item.status) || 'no_bid').toLowerCase();
      const statusClass = outcome === 'won' ? 'win' : (outcome === 'lost' ? 'loss' : 'pending');
      const label = outcome === 'won'
        ? `WIN +${money(item && (item.user_win_amount || item.win_amount) || 0)}`
        : (outcome === 'lost' ? 'LOSS' : 'NO BID');
      return `<span class="history-status ${statusClass}">${escapeHistoryHtml(label)}</span>`;
    }

    function renderBoardHistoryTable(rows){
      if(!rows.length){
        return '<div class="history-table-empty">Waiting for live rounds</div>';
      }
      return `
        <div class="history-panel">
          <div class="history-panel-head">
            <div class="history-panel-title">Win Board History</div>
            <div class="history-panel-sub">Last 15 settled rounds</div>
          </div>
          <div class="history-table-wrap">
            <table class="history-table history-board-matrix">
              <thead>
                <tr>
                  <th>Round</th>
                  ${historyBoardHeaderCells()}
                  <th>You</th>
                </tr>
              </thead>
              <tbody>
                ${rows.map((item) => `
                  <tr>
                    <td class="history-trace">${escapeHistoryHtml(historyRoundLabel(item))}</td>
                    ${historyWinnerBoardCells(item)}
                    <td>${historyOutcomeBadge(item)}</td>
                  </tr>
                `).join('')}
              </tbody>
            </table>
          </div>
        </div>
      `;
    }

    function renderUserHistoryTable(rows){
      if(!rows.length){
        return '<div class="history-table-empty">Place a bet to build your history</div>';
      }
      return `
        <div class="history-panel">
          <div class="history-panel-head">
            <div class="history-panel-title">My Bet History</div>
            <div class="history-panel-sub">Last 15 bet tickets</div>
          </div>
          <div class="history-table-wrap">
            <table class="history-table">
              <thead>
                <tr>
                  <th>Trace</th>
                  <th>Round</th>
                  <th>Board</th>
                  <th>Bid</th>
                  <th>Result</th>
                </tr>
              </thead>
              <tbody>
                ${rows.map((item) => {
                  const status = String(item && item.status || 'pending').toLowerCase();
                  const statusClass = status === 'won' ? 'win' : (status === 'lost' ? 'loss' : (status === 'punishment' ? 'punishment' : 'pending'));
                  const resultText = status === 'won'
                    ? `WIN +${money(item && item.win_amount || 0)}`
                    : (status === 'lost' ? `LOSS -${money(item && item.amount || 0)}` : (status === 'punishment' ? `PUNISH -${money(Math.abs(Number(item && (item.result_amount || item.amount) || 0)))}` : 'PENDING'));
                  return `
                    <tr>
                      <td class="history-trace">${escapeHistoryHtml(historyRoundLabel(item && (item.trace_short || item.trace_id) || '-'))}</td>
                      <td class="history-trace">${escapeHistoryHtml(historyRoundLabel(item))}</td>
                      <td>${historyBoardMarkup(item && (item.board_key || item.frontend_board_key) || '')}</td>
                      <td>${escapeHistoryHtml(money(item && item.amount || 0))}</td>
                      <td><span class="history-status ${statusClass}">${escapeHistoryHtml(resultText)}</span></td>
                    </tr>
                  `;
                }).join('')}
              </tbody>
            </table>
          </div>
        </div>
      `;
    }

    function renderHistoryOverlay(){
      el.historyList.innerHTML = `
        <div class="history-stack">
          ${renderBoardHistoryTable(boardHistoryRows)}
          ${renderUserHistoryTable(userHistoryRows)}
        </div>
      `;
    }

    function renderUsersOverlay(){
      if(!el.usersList){
        return;
      }
      const rows = Array.isArray(activePlayerRows) ? activePlayerRows : [];
      if(!rows.length){
        el.usersList.innerHTML = '<div class="history-table-empty">No active players yet</div>';
        return;
      }
      el.usersList.innerHTML = `
        <div class="active-user-grid">
          ${rows.map((item, index) => {
            const name = escapeHistoryHtml(String(item && (item.name || item.username || item.display_name || item.user_name || item.email) || `Player ${index + 1}`));
            const initial = escapeHistoryHtml(String(item && item.initial || name.charAt(0) || 'P').slice(0, 2).toUpperCase());
            const image = String(item && (item.image || item.avatar || item.profile_image || item.photo || item.user_image) || '');
            const winAmount = escapeHistoryHtml(money(item && (item.game_win_amount || item.win_amount || 0)));
            const avatar = image ? `<img src="${escapeHistoryHtml(image)}" alt="${name}">` : initial;
            return `<div class="active-user-card"><div class="active-user-avatar">${avatar}</div><b>${name}</b><span>Win ${winAmount}</span></div>`;
          }).join('')}
        </div>
      `;
    }

    function renderBalance(){
      const prev = Number(state.prevBalance ?? state.balance);
      const curr = Number(state.balance);
      const diff = curr - prev;
      el.balanceText.textContent = balanceNumber(curr);
      el.balancePopupText.textContent = balanceNumber(curr);
      el.balanceCard.classList.remove('up','down');
      el.balanceValue.classList.remove('up','down');
      if(diff !== 0){
        const mode = diff > 0 ? 'up' : 'down';
        el.balanceCard.classList.add(mode);
        el.balanceValue.classList.add(mode);
        el.balanceDelta.textContent = `${diff > 0 ? '+' : '-'}${money(Math.abs(diff))}`;
        el.balanceDelta.className = `balance-delta ${mode} show`;
        const t = setTimeout(() => {
          el.balanceDelta.className = 'balance-delta';
          el.balanceCard.classList.remove('up','down');
          el.balanceValue.classList.remove('up','down');
          state.timers.delete(t);
        }, 920);
        state.timers.add(t);
      }
      state.prevBalance = curr;
    }

    function renderBets(){
      document.getElementById('amt-melon').textContent = money(Number(state.boardTotals.melon || 0));
      document.getElementById('amt-slot').textContent = money(Number(state.boardTotals.slot || 0));
      document.getElementById('amt-plum').textContent = money(Number(state.boardTotals.plum || 0));
      const roomState = window.BDLucky77RoomState || {};
      const isLiveBettingOpen = function(payload){
        if(!payload) return state.phase === 'betting';
        if(payload.phase !== 'betting') return false;
        const opensAt = Number(payload.bet_countdown_start_at || 0);
        const closesAt = Number(payload.bet_close_at || 0);
        const offset = Number(roomState.serverClockOffsetSec || 0);
        const nowSec = (Date.now() / 1000) + (Number.isFinite(offset) ? offset : 0);
        if(opensAt > 0 && nowSec < opensAt) return false;
        if(closesAt > 0 && nowSec >= closesAt) return false;
        return true;
      };
      const payload = roomState.lastStatePayload || null;
      const winner = payload && (payload.winner_board || (payload.result && payload.result.winner_board));
      const resultPhase = !!(payload && (payload.phase === 'revealed' || payload.phase === 'settled'));
      ['melon', 'slot', 'plum'].forEach((key) => {
        const ownNode = document.getElementById(`own-${key}`);
        if(!ownNode) return;
        const myTotal = Number(state.bets && state.bets[key] || 0);
        if(resultPhase && winner === key && myTotal > 0){
          const actualWin = Number(payload && payload.my_total_win_amount || 0);
          const payout = payoutFor(key);
          const winAmount = actualWin > 0 ? actualWin : Math.round(myTotal * payout);
          ownNode.textContent = `${money(myTotal)} x${money(payout)} = ${money(winAmount)}`;
          return;
        }
        ownNode.textContent = money(myTotal);
      });
      const canUseBoardFn = typeof roomState.canUseBoard === 'function' ? roomState.canUseBoard : null;
      betCards.forEach((card) => {
        const boardKey = card.dataset.bet;
        const liveBettingOpen = isLiveBettingOpen(payload);
        const blockedByLimit = !!payload && liveBettingOpen && !!canUseBoardFn && !canUseBoardFn(payload, boardKey);
        card.classList.toggle('disabled', !liveBettingOpen || blockedByLimit);
      });
    }

    function setMode(text){
      if(el.modeText) el.modeText.textContent = text;
    }

    function setCounter(v, labelMode=false, hidden=false){
      el.counter.classList.toggle('small', labelMode);
      el.counter.classList.toggle('timer-hidden', !!hidden);
      el.counter.textContent = v;
    }

    function highlightWinningSelection(winner, segmentIndex){
      const resolvedIndex = Number.isInteger(segmentIndex) ? segmentIndex : null;
      const winningCard = winner ? document.querySelector(`.bet-card[data-bet="${winner}"]`) : null;
      if(winningCard) winningCard.classList.add('win','active');

      let segNode = null;
      let seatNode = null;
      if(resolvedIndex !== null){
        segNode = el.wheelInner.querySelector(`.seg[data-index="${resolvedIndex}"]`);
        seatNode = el.wheelInner.querySelector(`.wheel-icon-seat[data-index="${resolvedIndex}"]`);
      }
      if(!segNode && winner){
        segNode = el.wheelInner.querySelector(`.seg[data-key="${winner}"]`);
      }
      if(segNode) segNode.classList.add('winner');
      if(seatNode) seatNode.classList.add('winner-seat');
      return { winningCard, segNode, seatNode };
    }

    function clearRoundVisuals(){
      el.wheelInner.querySelectorAll('.seg.winner').forEach(n => n.classList.remove('winner'));
      el.wheelInner.querySelectorAll('.wheel-icon-seat.winner-seat').forEach(n => n.classList.remove('winner-seat'));
      document.querySelectorAll('.bet-card.win, .bet-card.active').forEach(n => n.classList.remove('win','active'));
      el.pointerWrap.classList.remove('hit','tick');
    }

    function clearManagedTimeouts(){
      state.timers.forEach(t => clearTimeout(t));
      state.timers.clear();
      hideProPhasePopup(true);
    }

    function showToast(text, ms = 1600){
      state.toastToken += 1;
      const token = state.toastToken;
      el.utilityToast.textContent = text;
      el.utilityToast.classList.add('show');
      const t = setTimeout(() => {
        if(token === state.toastToken) el.utilityToast.classList.remove('show');
        state.timers.delete(t);
      }, ms);
      state.timers.add(t);
    }

    function hideProPhasePopup(forceToken = false){
      if(!isLucky7Pro || !el.proPhaseOverlay || !el.proPhasePopup) return;
      if(forceToken) state.proPopupToken += 1;
      el.proPhaseOverlay.classList.remove('show');
      el.proPhaseOverlay.setAttribute('aria-hidden', 'true');
      el.proPhasePopup.classList.remove('start', 'stop', 'win', 'net');
    }

    function showProPhasePopup(type, title, sub, ms = 2200){
      if(!isLucky7Pro || !el.proPhaseOverlay || !el.proPhasePopup || !el.proPhaseTitle || !el.proPhaseSub || !el.proPhasePill) return;
      state.proPopupToken += 1;
      const token = state.proPopupToken;
      const pillLabel = type === 'start'
        ? 'PRO ENTRY'
        : (type === 'stop'
          ? 'LOCKED'
          : (type === 'win' ? 'RESULT' : 'ROOM ALERT'));
      el.proPhasePill.textContent = pillLabel;
      el.proPhaseTitle.textContent = title;
      el.proPhaseSub.textContent = sub;
      el.proPhasePopup.classList.remove('start', 'stop', 'win', 'net');
      void el.proPhasePopup.offsetWidth;
      el.proPhasePopup.classList.add(type);
      el.proPhaseOverlay.classList.add('show');
      el.proPhaseOverlay.setAttribute('aria-hidden', 'false');
      const t = setTimeout(() => {
        if(token === state.proPopupToken){
          hideProPhasePopup(false);
        }
        state.timers.delete(t);
      }, Math.max(1200, Math.min(3200, ms)));
      state.timers.add(t);
    }

    function hideAllBanners(){
      [el.bannerStart, el.bannerStop, el.bannerWin, el.bannerNet].forEach(b => b.classList.remove('show', 'shine'));
    }

    function showBanner(type, title, sub, ms = 3000){
      state.bannerToken += 1;
      const token = state.bannerToken;
      hideAllBanners();
      let node = el.bannerStart;
      if(type === 'stop') node = el.bannerStop;
      if(type === 'win') node = el.bannerWin;
      if(type === 'net') node = el.bannerNet;
      if(type === 'win'){
        el.bannerWinTitle.textContent = title;
        el.bannerWinSub.textContent = sub;
      }
      if(type !== 'win'){
        node.querySelector('.banner-title').textContent = title;
        node.querySelector('.banner-sub').textContent = sub;
      }
      node.classList.add('show', 'shine');
      showProPhasePopup(type, title, sub, type === 'win' ? Math.max(1800, ms) : Math.min(2200, ms));
      const t = setTimeout(() => {
        if(token === state.bannerToken) node.classList.remove('show', 'shine');
        state.timers.delete(t);
      }, ms);
      state.timers.add(t);
    }

    function openOverlay(id){ document.getElementById(id).classList.add('show'); }
    function closeOverlay(id){ document.getElementById(id).classList.remove('show'); }

    function updateNetwork(status, text){
      state.network = status;
      el.networkPill.classList.remove('bad','warn');
      if(status === 'bad') el.networkPill.classList.add('bad');
      if(status === 'warn') el.networkPill.classList.add('warn');
      el.networkText.textContent = text;
      if(status === 'bad'){
        state.reconnecting = true;
        el.networkStatusText.textContent = navigator.onLine ? 'Internet found. Tap Try Refresh to restore the room.' : 'No internet connection. Restore internet, then tap Try Refresh.';
        openOverlay('networkOverlay');
        if(state.splashDone) showBanner('net', 'Internet Lost', 'Restore connection and refresh the room', 3000);
      } else {
        state.reconnecting = false;
        closeOverlay('networkOverlay');
      }
    }

    function placeBet(kind, sourceEl){
      if(Date.now() < state.betLockUntil) return;
      if(!state.splashDone){
        showToast('Loading game…');
        return;
      }
      if(state.phase !== 'betting' || state.spinning || state.network === 'bad' || state.reconnecting) {
        showToast(state.network === 'bad' || state.reconnecting ? 'Reconnect first' : 'Wait for next round');
        return;
      }
      if(state.balance < state.currentChip){
        openOverlay('balanceOverlay');
        return;
      }
      state.betLockUntil = Date.now() + 120;
      state.bets[kind] += state.currentChip;
      state.balance -= state.currentChip;
      renderBalance();
      renderBets();
      pulseBalance();
      state.previousBets = { ...state.bets };
      chipFlyFromSelected(sourceEl);
      sparkBurst(sourceEl);
    }

    function pulseBalance(){
      el.balanceCard.animate([
        { transform:'scale(1)' },
        { transform:'scale(1.03)' },
        { transform:'scale(1)' }
      ], { duration: 320, easing: 'cubic-bezier(.2,.9,.2,1)' });
    }

    function setLuckyDisplayedBalance(value, commitState = true){
      const numericValue = Number(value || 0);
      window.__lucky77DisplayedBalanceValue = numericValue;
      el.balanceText.textContent = balanceNumber(numericValue);
      el.balancePopupText.textContent = balanceNumber(numericValue);
      if(commitState){
        state.balance = numericValue;
        state.prevBalance = numericValue;
      }
      return numericValue;
    }

    function animateLuckyDisplayedBalance(startValue, endValue, durationMs){
      const from = Number(startValue || 0);
      const to = Number(endValue || 0);
      if(from === to){
        setLuckyDisplayedBalance(to);
        return Promise.resolve();
      }
      const startedAt = performance.now();
      return new Promise((resolve) => {
        function tick(now){
          const progress = Math.min(1, (now - startedAt) / durationMs);
          const current = Math.round(from + ((to - from) * progress));
          setLuckyDisplayedBalance(current, false);
          if(progress < 1){
            window.requestAnimationFrame(tick);
            return;
          }
          setLuckyDisplayedBalance(to);
          resolve();
        }
        window.requestAnimationFrame(tick);
      });
    }

    function resolvePayoutOrigin(preferredEl){
      return preferredEl
        || document.querySelector('.wheel-icon-seat.winner-seat')
        || document.querySelector('.bet-card.win')
        || el.wheelWrap
        || el.balanceCard;
    }

    function createLuckyPayoutAmount(startX, startY, winner, winAmount){
      const amount = document.createElement('div');
      amount.className = `lucky-payout-amount ${payoutThemeForWinner(winner).className}`;
      amount.textContent = `+${money(winAmount)}`;
      amount.style.left = `${startX - 18}px`;
      amount.style.top = `${startY - 14}px`;
      document.body.appendChild(amount);
      return amount;
    }

    function createLuckyPayoutGem(startX, startY, winner){
      const gem = document.createElement('div');
      gem.className = `lucky-payout-gem ${payoutThemeForWinner(winner).className}`;
      gem.style.left = `${startX - 12}px`;
      gem.style.top = `${startY - 12}px`;
      document.body.appendChild(gem);
      return gem;
    }

    function triggerLuckyBalanceImpact(winner){
      const theme = payoutThemeForWinner(winner);
      el.balanceCard.animate([
        { transform:'translateY(0) scale(1)', boxShadow:'var(--shadow)' },
        { transform:'translateY(-2px) scale(1.03)', boxShadow:`0 0 0 1px ${theme.ring}, 0 0 32px ${theme.glow}, var(--shadow)` },
        { transform:'translateY(1px) scale(.995)', boxShadow:`0 0 0 1px ${theme.ring}, 0 0 18px ${theme.glow}, var(--shadow)` },
        { transform:'translateY(0) scale(1)', boxShadow:'var(--shadow)' }
      ], { duration: 560, easing:'cubic-bezier(.2,.86,.18,1)' });
      el.balanceValue.animate([
        { transform:'translateY(0) scale(1)', filter:'brightness(1)' },
        { transform:'translateY(-1px) scale(1.06)', filter:'brightness(1.16)' },
        { transform:'translateY(0) scale(1)', filter:'brightness(1)' }
      ], { duration: 560, easing:'cubic-bezier(.2,.86,.18,1)' });
      if(isLucky7Pro && el.heroInner){
        el.heroInner.animate([
          { transform:'translateY(0) scale(1)' },
          { transform:'translateY(-3px) scale(1.015)' },
          { transform:'translateY(0) scale(1)' }
        ], { duration: 620, easing:'cubic-bezier(.2,.86,.18,1)' });
      }
    }

    function chipFlyFromSelected(targetEl){
      const active = document.querySelector('.chip.active');
      if(!active || state.fxReduced) return;
      const a = active.getBoundingClientRect();
      const b = targetEl.getBoundingClientRect();
      const fly = document.createElement('div');
      fly.className = 'fly-chip';
      const appRect = el.app.getBoundingClientRect();
      fly.style.left = (a.left - appRect.left + a.width/2 - 11) + 'px';
      fly.style.top = (a.top - appRect.top + a.height/2 - 11) + 'px';
      fly.style.setProperty('--sx', '0px');
      fly.style.setProperty('--sy', '0px');
      fly.style.setProperty('--tx', (b.left - a.left + b.width/2 - a.width/2) + 'px');
      fly.style.setProperty('--ty', (b.top - a.top + b.height/2 - a.height/2) + 'px');
      el.chipFlyLayer.appendChild(fly);
      fly.addEventListener('animationend', () => fly.remove(), { once:true });
    }

    function animateLuckyPayoutToBalance({ winner, winAmount, startBalance, finalBalance, durationMs = 2000, originEl = null, count = 6 }){
      const fromBalance = Number(startBalance || 0);
      const toBalance = Number(finalBalance != null ? finalBalance : (fromBalance + Number(winAmount || 0)));
      const totalDurationMs = Math.max(0, Number(durationMs || 0));
      const setBalance = typeof window.setDisplayedBalance === 'function' ? window.setDisplayedBalance : setLuckyDisplayedBalance;
      const animateBalance = typeof window.animateDisplayedBalance === 'function' ? window.animateDisplayedBalance : animateLuckyDisplayedBalance;
      const sourceEl = resolvePayoutOrigin(originEl);
      const sourceRect = sourceEl && sourceEl.getBoundingClientRect ? sourceEl.getBoundingClientRect() : null;
      const targetRect = el.balanceCard && el.balanceCard.getBoundingClientRect ? el.balanceCard.getBoundingClientRect() : null;
      const canAnimateFlights = !state.fxReduced
        && totalDurationMs >= 1400
        && sourceRect
        && targetRect
        && targetRect.width
        && targetRect.height
        && typeof document.body.appendChild === 'function'
        && typeof Element !== 'undefined'
        && typeof Element.prototype.animate === 'function';

      if(!canAnimateFlights){
        return animateBalance(fromBalance, toBalance, Math.max(420, totalDurationMs || 620)).then(() => {
          triggerLuckyBalanceImpact(winner);
        });
      }

      const balanceDurationMs = Math.min(620, Math.max(420, Math.round(totalDurationMs * 0.31)));
      const flightDurationMs = Math.max(760, totalDurationMs - balanceDurationMs);
      const startX = sourceRect.left + (sourceRect.width / 2);
      const startY = sourceRect.top + (sourceRect.height / 2);
      const endX = targetRect.left + (targetRect.width / 2);
      const endY = targetRect.top + (targetRect.height / 2);

      setBalance(fromBalance);

      const amountGhost = createLuckyPayoutAmount(startX, startY, winner, winAmount);
      const amountAnimation = amountGhost.animate([
        { transform:'translate(0px, 0px) scale(.88)', opacity:0 },
        { transform:'translate(0px, -24px) scale(1.04)', opacity:1, offset:.28 },
        { transform:`translate(${endX - startX}px, ${endY - startY - 8}px) scale(.7)`, opacity:0 }
      ], { duration: flightDurationMs, easing:'cubic-bezier(.22,.88,.18,1)', fill:'forwards' });
      const amountPromise = amountAnimation.finished.catch(() => {});
      amountPromise.finally(() => amountGhost.remove());

      const totalGems = Math.max(4, Number(count || 0)) + (isLucky7Pro ? 2 : 0);
      const gemPromises = Array.from({ length: totalGems }, (_, index) => {
        const gem = createLuckyPayoutGem(startX, startY, winner);
        const spread = (index - ((totalGems - 1) / 2)) * 18;
        const arcLift = 44 + Math.random() * 28 + (winner === 'slot' ? 10 : 0);
        const driftX = (Math.random() * 16) - 8;
        const driftY = Math.random() * 12;
        const animation = gem.animate([
          { transform:'translate(0px, 0px) rotate(0deg) scale(.52)', opacity:0 },
          { transform:`translate(${spread * .36}px, -${arcLift}px) rotate(${48 + (index * 14)}deg) scale(1.06)`, opacity:1, offset:.38 },
          { transform:`translate(${(endX - startX) + driftX + spread}px, ${(endY - startY) + driftY}px) rotate(${160 + (index * 38)}deg) scale(.48)`, opacity:.08 }
        ], { duration: Math.max(680, flightDurationMs - 120 + (index * 34)), easing:'cubic-bezier(.18,.82,.16,1)', fill:'forwards' });
        return animation.finished.catch(() => {}).finally(() => gem.remove());
      });

      return Promise.allSettled([amountPromise, ...gemPromises]).then(() => {
        return animateBalance(fromBalance, toBalance, balanceDurationMs).then(() => {
          triggerLuckyBalanceImpact(winner);
        });
      });
    }

    function luckyFxBudget(key, fallback){
      const api = window.BDGameFinal;
      const budget = api && typeof api.fxBudget === 'function' ? api.fxBudget() : null;
      if(budget && Number(budget[key]) > 0) return Number(budget[key]);
      const compact = state.fxReduced || window.innerHeight <= 520 || window.innerWidth <= 430 || (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);
      if(!compact) return fallback;
      const localBudget = { betCoins:2, betSparks:2, winCoins:4, winParticles:6 };
      return localBudget[key] || Math.min(fallback, 6);
    }

    function chipsToBalance(count=6, durationMs=850){
      if(state.fxReduced) return;
      count = Math.max(1, Math.min(count, luckyFxBudget('winCoins', count)));
      const appRect = el.app.getBoundingClientRect();
      const target = el.balanceCard.getBoundingClientRect();
      const winCard = document.querySelector('.bet-card.win') || document.getElementById('wheelWrap');
      const origin = winCard.getBoundingClientRect();
      for(let i=0;i<count;i++){
        const fly = document.createElement('div');
        fly.className = 'fly-chip';
        fly.style.left = (origin.left - appRect.left + origin.width/2 - 11 + (Math.random()*28-14)) + 'px';
        fly.style.top = (origin.top - appRect.top + origin.height/2 - 11 + (Math.random()*28-14)) + 'px';
        fly.style.setProperty('--sx','0px');
        fly.style.setProperty('--sy','0px');
        fly.style.setProperty('--tx', (target.left - origin.left + target.width/2 - origin.width/2 + (Math.random()*26-13)) + 'px');
        fly.style.setProperty('--ty', (target.top - origin.top + target.height/2 - origin.height/2 + (Math.random()*16-8)) + 'px');
        fly.style.animationDuration = `${durationMs}ms`;
        fly.style.animationDelay = `${i*45}ms`;
        el.chipFlyLayer.appendChild(fly);
        fly.addEventListener('animationend', () => fly.remove(), { once:true });
      }
    }

    function sparkBurst(targetEl, jackpot=false){
      if(state.fxReduced) return;
      const rect = targetEl.getBoundingClientRect();
      const appRect = el.app.getBoundingClientRect();
      const x = rect.left - appRect.left + rect.width/2;
      const y = rect.top - appRect.top + rect.height/2;
      const n = Math.max(1, Math.min(jackpot ? 18 : 9, luckyFxBudget('winParticles', jackpot ? 18 : 9)));
      for(let i=0;i<n;i++){
        const s = document.createElement('div');
        s.className = 'spark';
        s.style.left = `${x}px`;
        s.style.top = `${y}px`;
        s.style.setProperty('--dx', `${Math.cos((Math.PI*2*i)/n) * (26 + Math.random()*30)}px`);
        s.style.setProperty('--dy', `${Math.sin((Math.PI*2*i)/n) * (26 + Math.random()*30)}px`);
        el.sparkLayer.appendChild(s);
        s.addEventListener('animationend', ()=>s.remove(), { once:true });
      }
    }

    function confettiDrop(){
      if(state.fxReduced) return;
      const count = Math.max(1, Math.min(isLucky7Pro ? 26 : 18, luckyFxBudget('winParticles', isLucky7Pro ? 26 : 18)));
      for(let i=0;i<count;i++){
        const c = document.createElement('div');
        c.className = 'confetti';
        c.style.left = `${10 + Math.random()*80}%`;
        c.style.top = `${10 + Math.random()*18}%`;
        c.style.background = i % 3 === 0 ? 'linear-gradient(180deg,#fff,#ffd35c)' : (i % 3 === 1 ? 'linear-gradient(180deg,#8fdcff,#31a8ff)' : 'linear-gradient(180deg,#ff92d6,#ff4db8)');
        c.style.animationDelay = `${Math.random()*180}ms`;
        el.confettiLayer.appendChild(c);
        c.addEventListener('animationend', () => c.remove(), { once:true });
      }
    }

    function winnerTokenMarkup(winner){
      if(winner === 'slot'){
        return `<span class="slot-seat-stack"><span class="slot-seat-icon">${slotSeatIcon}</span><span class="slot77">${slotDisplayMark}</span></span>`;
      }
      return `<span class="wheel-fruit-icon">${iconSvg(winner)}</span>`;
    }

    function animateWinnerToPopup(winner, sourceEl){
      if(state.fxReduced || !winner || !sourceEl || !sourceEl.getBoundingClientRect || !el.bannerWin) return;
      const from = sourceEl.getBoundingClientRect();
      const to = el.bannerWin.getBoundingClientRect();
      if(!from.width || !from.height || !to.width || !to.height) return;
      const token = document.createElement('div');
      token.className = `winner-pop-token ${winner}`;
      token.innerHTML = winnerTokenMarkup(winner);
      const startX = from.left + (from.width / 2);
      const startY = from.top + (from.height / 2);
      const endX = to.left + Math.min(to.width - 42, Math.max(42, to.width * .22));
      const endY = to.top + (to.height / 2);
      token.style.left = `${startX - 26}px`;
      token.style.top = `${startY - 26}px`;
      document.body.appendChild(token);
      const animation = token.animate([
        { transform:'translate(0px, 0px) scale(.72) rotate(-10deg)', opacity:0 },
        { transform:'translate(0px, -34px) scale(1.16) rotate(5deg)', opacity:1, offset:.34 },
        { transform:`translate(${endX - startX}px, ${endY - startY}px) scale(.86) rotate(0deg)`, opacity:1, offset:.82 },
        { transform:`translate(${endX - startX}px, ${endY - startY}px) scale(.78) rotate(0deg)`, opacity:0 }
      ], { duration: 1050, easing:'cubic-bezier(.2,.82,.16,1)', fill:'forwards' });
      animation.finished.catch(() => {}).finally(() => token.remove());
    }

    function clearWinStates(){
      clearRoundVisuals();
    }

    function startBettingPhase(){
      stopWheelAnimation();
      clearWinStates();
      state.phase = 'betting';
      state.counter = 20;
      state.spinning = false;
      setMode('Betting');
      setCounter(state.counter);
      betCards.forEach(card => card.classList.remove('disabled'));
      showBanner('start','Start Bet','Place your chips now',LUCKY_SEQUENCE.startPopupMs);
      clearInterval(state.countdownTimer);
      state.countdownTimer = null;
      if(state.phase !== 'betting' || state.network === 'bad' || state.reconnecting) return;
      if(state.autoBet && state.previousBets){
        autoPlacePreviousBets();
      }
      startCountdown();
    }

    function stopBettingPhase(){
      if(state.phase !== 'betting' || state.spinning) return;
      state.phase = 'stop';
      setMode('Locked');
      setCounter('STOP', true);
      betCards.forEach(card => card.classList.add('disabled'));
      showBanner('stop','Stop Bet','Bets locked · wheel preparing',LUCKY_SEQUENCE.stopPopupMs);
      const t = setTimeout(() => {
        spinWheel();
        state.timers.delete(t);
      }, LUCKY_SEQUENCE.stopPopupMs + LUCKY_SEQUENCE.stopHoldMs);
      state.timers.add(t);
    }

    function autoPlacePreviousBets(){
      const preview = { ...state.previousBets };
      const total = Object.values(preview).reduce((a,b)=>a+b,0);
      if(!total || state.balance < total){
        if(total) openOverlay('balanceOverlay');
        return;
      }
      for(const key of Object.keys(preview)){
        if(preview[key] > 0){
          state.bets[key] += preview[key];
          state.balance -= preview[key];
        }
      }
      renderBets();
      renderBalance();
      showToast('Auto bet applied', 1200);
    }

    function spinWheel(){
      if(state.spinning) return;
      state.spinning = true;
      const idx = Math.floor(Math.random() * segments.length);
      const step = 360 / segments.length;
      const currentMod = ((state.rotation % 360) + 360) % 360;
      const currentSigned = currentMod > 180 ? currentMod - 360 : currentMod;
      const finalRotation = currentSigned - 360*5 - (idx * step);
      animateWheelRotation(finalRotation, LUCKY_SEQUENCE.revealSpinMs);
      pointerTickLoop();
      const timeout = setTimeout(() => {
        settleRound(idx);
        state.timers.delete(timeout);
      }, LUCKY_SEQUENCE.revealSpinMs + LUCKY_SEQUENCE.revealHoldMs);
      state.timers.add(timeout);
    }

    function pointerTickLoop(){
      let c = 0;
      const max = state.fxReduced ? 6 : 10;
      const loop = () => {
        if(c >= max || !state.spinning) return;
        el.pointerWrap.classList.remove('tick');
        void el.pointerWrap.offsetWidth;
        el.pointerWrap.classList.add('tick');
        c += 1;
        const t = setTimeout(loop, c < 6 ? 360 : 520);
        state.timers.add(t);
      };
      loop();
    }

    function settleRound(index){
      state.spinning = false;
      state.phase = 'result';
      setMode('Result');
      const winner = segments[index].key;
      const resultMark = displayMarkForBoard(winner, winner.toUpperCase());
      const startBalance = Number(state.balance || 0);
      let totalBet = 0;
      let win = 0;
      Object.keys(state.bets).forEach(k => {
        totalBet += state.bets[k];
        if(k === winner) win += state.bets[k] * payoutFor(k);
      });
      const finalBalance = startBalance + win;
      state.results.push(winner);
      renderRecent();
      const { winningCard: betNode, segNode, seatNode } = highlightWinningSelection(winner, index);
      const payoutOrigin = betNode || seatNode || segNode || document.getElementById('wheelWrap');
      el.pointerWrap.classList.add('hit');
      const cleanPointer = setTimeout(()=>el.pointerWrap.classList.remove('hit'), 380); state.timers.add(cleanPointer);
      if(betNode) sparkBurst(betNode, false);
      sparkBurst(seatNode || segNode || payoutOrigin, winner === 'slot');
      if(win > 0){
        if(winner === 'slot') confettiDrop();
        const payoutTimer = setTimeout(() => {
          animateLuckyPayoutToBalance({
            winner,
            winAmount: win,
            startBalance,
            finalBalance,
            durationMs: LUCKY_SEQUENCE.payoutMs,
            originEl: payoutOrigin,
            count: winner === 'slot' ? 9 : 6,
          });
          state.timers.delete(payoutTimer);
        }, LUCKY_SEQUENCE.resultPopupMs + LUCKY_SEQUENCE.payoutLeadMs);
        state.timers.add(payoutTimer);
      }
      showBanner('win', winnerBannerTitle(winner, win), win > 0 ? `Won ${money(win)}` : `${resultMark} landed · try next round`, LUCKY_SEQUENCE.resultPopupMs);
      animateWinnerToPopup(winner, seatNode || segNode || payoutOrigin);
      state.history.push({ round: state.round, resultKey: winner, result: resultMark, totalBet, win });
      renderHistory();
      state.previousBets = totalBet > 0 ? { ...state.bets } : state.previousBets;
      state.bets = { melon:0, slot:0, plum:0 };
      renderBets();
      setCounter(win > 0 ? 'WIN' : 'END', true);
      const next = setTimeout(() => {
        state.round += 1;
        saveRound();
        el.roundText.textContent = String(state.round);
        saveRound();
        startBettingPhase();
        state.timers.delete(next);
      }, LUCKY_SEQUENCE.resultPopupMs + LUCKY_SEQUENCE.payoutLeadMs + LUCKY_SEQUENCE.payoutMs + LUCKY_SEQUENCE.roundGapMs);
      state.timers.add(next);
    }

    function startCountdown(){
      clearInterval(state.countdownTimer);
      state.countdownTimer = setInterval(() => {
        if(state.paused || state.network === 'bad') return;
        if(state.phase !== 'betting') return;
        state.counter -= 1;
        if(state.counter <= 0){
          stopBettingPhase();
          return;
        }
        setCounter(state.counter);
      }, 1000);
    }

    function setSelectedChip(chip){
      chips.forEach(c => c.classList.remove('active'));
      chip.classList.add('active');
      state.currentChip = Number(chip.dataset.value);
    }

    function repeatPreviousBets(){
      if(!state.previousBets){
        showToast('No previous bet');
        return;
      }
      if(state.phase !== 'betting'){
        showToast('Wait for betting phase');
        return;
      }
      const total = Object.values(state.previousBets).reduce((a,b)=>a+b,0);
      if(total > state.balance){
        openOverlay('balanceOverlay');
        return;
      }
      Object.keys(state.previousBets).forEach(key => {
        state.bets[key] += state.previousBets[key];
      });
      state.balance -= total;
      renderBets();
      renderBalance();
      showToast('Repeat bet applied', 1200);
      pulseBalance();
    }

    function syncWheelFxMode(){
      if(!el.app) return;
      el.app.classList.toggle('fx-reduced', !!state.fxReduced);
      if(state.fxReduced && el.wheelWrap){
        el.wheelWrap.classList.remove('is-spinning');
      }
    }

    function toggleSwitch(node, key){
      node.classList.toggle('on');
      state[key] = node.classList.contains('on');
      if(key === 'fxReduced'){
        document.getElementById('toggleFx').classList.toggle('on', state.fxReduced);
        syncWheelFxMode();
      }
    }

    function refreshNetworkFromBrowser(){
      clearInterval(state.networkTimer);
      state.networkTimer = setInterval(() => {
        if(document.hidden) return;
        if(!navigator.onLine){
          updateNetwork('bad','Offline');
          return;
        }
        updateNetwork('warn', 'sync');
      }, 9000);
    }

    function manualReconnect(){
      if(!navigator.onLine){
        state.reconnecting = true;
        updateNetwork('bad','Offline');
        return;
      }
      if(state.reconnecting){
        el.networkStatusText.textContent = 'Checking room and restoring connection…';
      }
      state.reconnecting = true;
      updateNetwork('warn','Checking…');
      const t = setTimeout(() => {
        state.reconnecting = false;
        updateNetwork('good', `${24 + Math.floor(Math.random()*16)}ms`);
        if(state.phase === 'betting' && !state.countdownTimer){
          startCountdown();
        }
        state.timers.delete(t);
      }, 1100);
      state.timers.add(t);
    }

    function finishSplash(force = false){
      if(state.splashDone && !force) return;
      state.splashDone = true;
      state.phase = 'idle';
      if(state.splashInterval){ clearInterval(state.splashInterval); state.splashInterval = null; }
      if(state.splashForceTimer){ clearTimeout(state.splashForceTimer); state.splashForceTimer = null; }
      if(el.splash){
        el.splash.classList.add('hide');
        el.splash.setAttribute('aria-hidden', 'true');
        el.splash.style.pointerEvents = 'none';
      }
      if(el.app) el.app.classList.remove('splashing');
      try{ localStorage.setItem(STORAGE_KEYS.helpSeen, '1'); }catch(e){}
      if (useStandalonePreview && !(window.BDGameFinal && window.BD_GAME_BOOTSTRAP && window.BD_GAME_BOOTSTRAP.gameCode === currentGameCode)) {
        startBettingPhase();
      }
    }

    function runSplash(){
      if(state.splashDone) return;
      if(!el.splash || !el.splashFill || !el.splashLog){
        finishSplash(true);
        return;
      }
      state.phase = 'splash';
      if(el.app) el.app.classList.add('splashing');
      el.splash.classList.remove('hide');
      el.splash.removeAttribute('aria-hidden');
      el.splash.style.display = 'flex';
      el.splash.style.pointerEvents = 'auto';
      el.splashFill.style.width = '0%';
      const logs = isLucky7Pro
        ? ['Unlocking pro lounge…','Forging royal wheel…','Syncing premium room state…','Charging winner spotlight…','Lucky 7 Pro ready']
        : (isLucky88Master
          ? ['Preparing royal stage…','Syncing wheel data…','Loading premium effects…','Starting secure session…','Lucky 88 Master ready']
          : ['Preparing stage lights…','Loading luxury wheel…','Syncing room state…','Applying premium effects…','Ready to spin']);
      let i = 0;
      el.splashLog.textContent = logs[0];

      state.splashInterval = setInterval(() => {
        if(state.splashDone) return;
        i += 1;
        const pct = Math.min(100, i * 20);
        el.splashFill.style.width = pct + '%';
        el.splashLog.textContent = logs[Math.min(i, logs.length - 1)];
        if(i >= logs.length){
          finishSplash();
        }
      }, 320);

      state.splashForceTimer = setTimeout(() => {
        finishSplash(true);
      }, 2200);

      el.splash.addEventListener('click', () => finishSplash(true), { once: true });
    }

    function attachEvents(){
      chips.forEach(chip => chip.addEventListener('click', () => setSelectedChip(chip)));
      betCards.forEach(card => card.addEventListener('click', () => placeBet(card.dataset.bet, card)));
      const repeatBtn = document.getElementById('repeatBtn');
      if(repeatBtn) repeatBtn.addEventListener('click', repeatPreviousBets);
      el.autoBetBtn.addEventListener('click', () => {
        state.autoBet = !state.autoBet;
        el.autoBetBtn.classList.toggle('on', state.autoBet);
        el.autoBetBtn.querySelector('span').textContent = state.autoBet ? 'Running' : 'Off';
        showToast(state.autoBet ? 'Auto Bet enabled' : 'Auto Bet disabled');
      });
      document.getElementById('settingsBtn').addEventListener('click', ()=>openOverlay('settingsOverlay'));
      document.getElementById('historyBtn').addEventListener('click', ()=>{ if(typeof window.refreshHistoryTables === 'function'){ window.refreshHistoryTables(true); } openOverlay('historyOverlay'); });
      document.getElementById('usersBtn').addEventListener('click', ()=>{ renderUsersOverlay(); if(typeof window.refreshHistoryTables === 'function'){ window.refreshHistoryTables(true); } openOverlay('usersOverlay'); });
      el.payoutBtn.addEventListener('click', ()=>openOverlay('helpOverlay'));
      document.getElementById('soundBtn').addEventListener('click', () => {
        state.soundOn = !state.soundOn;
        document.getElementById('soundBtn').classList.toggle('active', state.soundOn);
        showToast(state.soundOn ? 'Sound On' : 'Sound Off');
      });
      document.getElementById('reconnectBtn').addEventListener('click', manualReconnect);
      window.addEventListener('offline', () => updateNetwork('bad','Offline'));
      window.addEventListener('online', () => {
        if(state.network === 'bad'){
          el.networkStatusText.textContent = 'Internet detected. Tap Try Refresh to continue.';
        } else {
          updateNetwork('good', `${22 + Math.floor(Math.random()*18)}ms`);
        }
      });
      document.querySelectorAll('[data-close]').forEach(btn => btn.addEventListener('click', () => closeOverlay(btn.dataset.close)));
      document.querySelectorAll('.overlay').forEach(o => o.addEventListener('click', e => { if(e.target === o) o.classList.remove('show'); }));
      document.getElementById('toggleSound').addEventListener('click', () => { state.soundOn = !state.soundOn; document.getElementById('toggleSound').classList.toggle('on', state.soundOn); });
      document.getElementById('toggleMusic').addEventListener('click', () => {
        state.musicOn = !state.musicOn;
        document.getElementById('toggleMusic').classList.toggle('on', state.musicOn);
        syncRoomMediaPreference();
      });
      document.getElementById('toggleFx').addEventListener('click', () => {
        state.fxReduced = !state.fxReduced;
        document.getElementById('toggleFx').classList.toggle('on', state.fxReduced);
        syncWheelFxMode();
        showToast(state.fxReduced ? 'Reduced effects on' : 'Reduced effects off');
      });
      document.addEventListener('visibilitychange', () => {
        state.paused = document.hidden;
        if(document.hidden){
          silenceRoomAudio(false);
        }
      });
      window.addEventListener('pagehide', cleanup, { once: true });
      window.addEventListener('beforeunload', cleanup, { once: true });
    }

    function cleanup(){
      if(state.cleanupDone) return;
      state.cleanupDone = true;
      silenceRoomAudio(true);
      if(window.BDGameFinal && typeof window.BDGameFinal.stopHeartbeat === 'function') window.BDGameFinal.stopHeartbeat();
      clearInterval(state.countdownTimer);
      clearInterval(state.networkTimer);
      state.timers.forEach(t => clearTimeout(t));
      state.timers.clear();
    }

    function init(){
      installAudioTracking();
      setupChips();
      setupBetIcons();
      ensureWheelCircle();
      buildWheel();
      renderBets();
      if(hasLiveSession){
        renderRecent();
        renderHistory();
        el.balanceText.textContent = '--';
        el.balancePopupText.textContent = '--';
        el.roundText.textContent = '-';
        setCounter('--', true);
        updateNetwork('warn', 'sync');
      } else if (useStandalonePreview) {
        renderRecent();
        renderBalance();
        renderHistory();
        el.roundText.textContent = String(state.round);
      } else {
        renderRecent();
        renderHistory();
        el.balanceText.textContent = '--';
        el.balancePopupText.textContent = '--';
        el.roundText.textContent = '-';
        setCounter('--', true);
        updateNetwork('warn', 'sync');
      }
      document.getElementById('toggleSound').classList.add('on');
      document.getElementById('toggleMusic').classList.add('on');
      document.getElementById('soundBtn').classList.add('active');
      syncRoomMediaPreference();
      syncWheelFxMode();
      attachEvents();
      startPlayerIdentityFlip();
      if(useStandalonePreview){
        refreshNetworkFromBrowser();
      }
      runSplash();
    }

    init();
  
    applyViewportMode();
    window.addEventListener('resize', applyViewportMode, { passive: true });
    window.addEventListener('orientationchange', applyViewportMode);
  </script>

<script>
window.BD_GAME_BOOTSTRAP = {
  gameCode: @json($gameCode ?? 'lucky77'),
  gameKey: @json($gameCode ?? 'lucky77'),
  roomKey: @json($gameCode ?? 'lucky77'),
  configVersion: @json((int) config('bd_game_final.realtime.config_version', 1)),
  configUpdatedAt: @json(config('bd_game_final.realtime.config_updated_at')),
  gameToken: @json($gameToken ?? null),
  sessionToken: @json($sessionToken ?? null),
  lobbyUrl: @json($lobbyUrl ?? route('game-final.lobby')),
  userId: @json($displayUserId ?? auth()->id() ?? request()->get('user_id')),
  userName: @json($displayUserName ?? 'Player'),
  rules: {
    maxDistinctBoards: @json((int) ($gameRules['max_distinct_boards_per_user'] ?? 3)),
    boardCount: @json((int) ($gameRules['board_count'] ?? 3))
  },
  endpoints: {
    startToPlay: "{{ route('game-final.api.start-to-play', ['gameCode' => $gameCode ?? 'lucky77']) }}",
    state: "{{ route('game-final.api.state', ['gameCode' => $gameCode ?? 'lucky77']) }}",
    bet: "{{ route('game-final.api.bet', ['gameCode' => $gameCode ?? 'lucky77']) }}",
    history: "{{ route('game-final.api.history', ['gameCode' => $gameCode ?? 'lucky77']) }}",
    myBets: "{{ route('game-final.api.my-bets', ['gameCode' => $gameCode ?? 'lucky77']) }}",
    heartbeat: "{{ route('game-final.api.heartbeat', ['gameCode' => $gameCode ?? 'lucky77']) }}"
  },
  realtime: {
    mode: @json(config('bd_game_final.realtime.mode', 'polling')),
    enabled: @json(config('bd_game_final.realtime.enabled', true)),
    channel: @json(config('bd_game_final.realtime.channel_prefix', 'bdgamefinal.') . ($gameCode ?? 'lucky77')),
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
  if (!window.BDGameFinal || !window.BD_GAME_BOOTSTRAP || window.BD_GAME_BOOTSTRAP.gameCode !== currentGameCode) {
        return;
    }

    const api = window.BDGameFinal;
    const betKeyToMark = { melon: betKeyMarks.melon, slot: slotDisplayMark, plum: betKeyMarks.plum };
    const sharedRoomState = window.BDLucky77RoomState || (window.BDLucky77RoomState = { lastStatePayload: null, canUseBoard: null });
    let serverClockOffsetSec = 0;
    let serverClockKey = '';
    let authoritativeRoundNo = null;
    let lastPhaseKey = '';
    let lastResultKey = '';
    let lastNetworkMs = 0;
    let heartbeatTimer = null;
    let statePollTimer = null;
    let mirrorTimer = null;
    let refreshInFlight = false;
    let requestCounter = 0;
    const pendingBets = new Map();
    function markPendingBet(kind, delta) {
      const nextCount = Math.max(0, (pendingBets.get(kind) || 0) + delta);
      if (nextCount > 0) pendingBets.set(kind, nextCount);
      else pendingBets.delete(kind);
    }
    const LUCKY_SEQUENCE = Object.freeze({
      startPopupMs: 3000,
      stopPopupMs: 3000,
      stopHoldMs: 0,
      revealSpinMs: 4200,
      revealHoldMs: 0,
      resultPopupMs: 1000,
      payoutLeadMs: 0,
      payoutMs: 2000,
      roundGapMs: 1000,
    });
    window.LUCKY_SEQUENCE = LUCKY_SEQUENCE;
    let displayedBalanceValue = null;
    let lastAnimatedPayoutKey = '';
    let activePayoutAnimationKey = '';
    let lastSpinKey = '';
    let lastRevealStageKey = '';
    let lastSettlementStageKey = '';
    let revealStageTimer = null;
    let settlementStageTimer = null;
    const roomBoardCount = Math.max(1, Number(window.BD_GAME_BOOTSTRAP.rules && window.BD_GAME_BOOTSTRAP.rules.boardCount || 3));

    startBettingPhase = function(){};
    stopBettingPhase = function(){};
    startCountdown = function(){};
    spinWheel = function(){};
    settleRound = function(){};
    refreshNetworkFromBrowser = function(){
      if (state.networkTimer) {
        clearInterval(state.networkTimer);
        state.networkTimer = null;
      }
    };
    manualReconnect = function(){
      refreshState();
    };
    clearManagedTimeouts();
    clearInterval(state.networkTimer);
    clearInterval(state.countdownTimer);
    state.networkTimer = null;
    state.countdownTimer = null;
    state.spinning = false;
    state.phase = 'idle';

    function serverNow() {
      return (Date.now() / 1000) + serverClockOffsetSec;
    }

    function luckyTimings(payload) {
      const durations = payload && payload.phase_durations ? payload.phase_durations : {};
      return {
        startPopupMs: Math.max(0, Math.round(Number(durations.start_popup || (LUCKY_SEQUENCE.startPopupMs / 1000)) * 1000)),
        stopPopupMs: Math.max(0, Math.round(Number(durations.stop_popup || (LUCKY_SEQUENCE.stopPopupMs / 1000)) * 1000)),
        revealMainMs: Math.max(0, Math.round(Number(durations.reveal_main || (LUCKY_SEQUENCE.revealSpinMs / 1000)) * 1000)),
        revealWaitMs: Math.max(0, Math.round(Number(durations.reveal_wait || 0) * 1000)),
        winnerPopupMs: Math.max(0, Math.round(Number(durations.winner_popup || (LUCKY_SEQUENCE.resultPopupMs / 1000)) * 1000)),
        winnerWaitMs: Math.max(0, Math.round(Number(durations.winner_wait || 0) * 1000)),
        payoutMs: Math.max(0, Math.round(Number(durations.payout || (LUCKY_SEQUENCE.payoutMs / 1000)) * 1000)),
        settleWaitMs: Math.max(0, Math.round(Number(durations.settle_wait || (LUCKY_SEQUENCE.roundGapMs / 1000)) * 1000)),
      };
    }

    function phaseMarkerAt(payload, key) {
      const value = Number(payload && payload[key] || 0);
      return Number.isFinite(value) && value > 0 ? value : null;
    }

    function revealDoneAt(payload) {
      const direct = phaseMarkerAt(payload, 'reveal_done_at');
      if (direct) return direct;
      const revealAt = phaseMarkerAt(payload, 'reveal_at');
      return revealAt ? revealAt + (luckyTimings(payload).revealMainMs / 1000) : null;
    }

    function winnerPopupAt(payload) {
      const direct = phaseMarkerAt(payload, 'winner_popup_at');
      if (direct) return direct;
      const revealDone = revealDoneAt(payload);
      return revealDone ? revealDone + (luckyTimings(payload).revealWaitMs / 1000) : null;
    }

    function bettingOpensAt(payload) {
      return phaseMarkerAt(payload, 'bet_countdown_start_at');
    }

    function isBettingOpen(payload) {
      if (!payload || payload.phase !== 'betting') return false;
      const opensAt = bettingOpensAt(payload);
      const closesAt = phaseMarkerAt(payload, 'bet_close_at');
      const now = serverNow();
      if (opensAt && now < opensAt) return false;
      if (closesAt && now >= closesAt) return false;
      return true;
    }

    function maxDistinctBoards(payload) {
      const fromPayload = Number(payload && payload.rules && payload.rules.max_distinct_boards_per_user || 0);
      const fromBootstrap = Number(window.BD_GAME_BOOTSTRAP.rules && window.BD_GAME_BOOTSTRAP.rules.maxDistinctBoards || 0);
      return Math.max(1, Math.min(roomBoardCount, fromPayload || fromBootstrap || roomBoardCount));
    }

    function currentDistinctBoardCount(payload) {
      const totals = payload && payload.my_bet_totals ? payload.my_bet_totals : state.bets;
      return ['melon', 'slot', 'plum'].filter((key) => Number(totals && totals[key] || 0) > 0).length;
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

    sharedRoomState.canUseBoard = canUseBoard;

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
      if (phase === 'betting') return payload.bet_countdown_start_at || payload.start_at || null;
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

    function clearRevealStageTimer() {
      if (revealStageTimer) {
        clearTimeout(revealStageTimer);
        revealStageTimer = null;
      }
    }

    function clearSettlementStageTimer() {
      if (settlementStageTimer) {
        clearTimeout(settlementStageTimer);
        settlementStageTimer = null;
      }
    }

    function setDisplayedBalance(value, commitState = true) {
      displayedBalanceValue = Number(value || 0);
      el.balanceText.textContent = balanceNumber(displayedBalanceValue);
      el.balancePopupText.textContent = balanceNumber(displayedBalanceValue);
      if (commitState) {
        state.balance = displayedBalanceValue;
        state.prevBalance = displayedBalanceValue;
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

    window.setDisplayedBalance = setDisplayedBalance;
    window.animateDisplayedBalance = animateDisplayedBalance;

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

    function winningSegmentIndex(payload, winner) {
      const matchIndices = segments.reduce((acc, segment, index) => {
        if (segment.key === winner) acc.push(index);
        return acc;
      }, []);
      if (!matchIndices.length) return 0;
      const seed = Math.abs(Number(payload && payload.result && payload.result.spin_seed || 0));
      return matchIndices[seed % matchIndices.length];
    }

    function spinWheelToWinner(payload, immediate = false, minimumTurns = 5, durationMs = LUCKY_SEQUENCE.revealSpinMs) {
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
        stopWheelAnimation();
        state.spinning = false;
        setWheelRotation(finalRotation);
        if (el.wheelInner) void el.wheelInner.offsetWidth;
        return targetIndex;
      }

      state.spinning = true;
      if (typeof pointerTickLoop === 'function') pointerTickLoop();
      animateWheelRotation(finalRotation, Math.max(180, Number(durationMs || LUCKY_SEQUENCE.revealSpinMs)));
      return targetIndex;
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
      const startBalance = displayedBalanceValue != null ? Number(displayedBalanceValue) : Math.max(0, finalBalance - winAmount);
      const timings = luckyTimings(payload);
      animateLuckyPayoutToBalance({
        winner,
        winAmount,
        startBalance,
        finalBalance,
        durationMs: timings.payoutMs,
        originEl: resolvePayoutOrigin(document.querySelector('.wheel-icon-seat.winner-seat') || document.querySelector('.bet-card.win')),
        count: winner === 'slot' ? 9 : 6,
      }).then(() => {
        lastAnimatedPayoutKey = payoutKey;
        activePayoutAnimationKey = '';
      });
    }

    function scheduleRevealStage(payload) {
      const winner = resolveWinnerKey(payload);
      if (!winner) return;
      const stageKey = `${payload.round_no || 'na'}:${winner}`;
      const timings = luckyTimings(payload);
      const revealDoneAtSec = revealDoneAt(payload);
      const winnerPopupAtSec = winnerPopupAt(payload);
      const remainingRevealMs = revealDoneAtSec
        ? Math.max(0, Math.round((revealDoneAtSec - serverNow()) * 1000))
        : Math.max(0, timings.revealMainMs - phaseElapsedMs(payload, 'revealed'));
      const minimumVisibleSpinMs = state.fxReduced ? 260 : 420;

      if (remainingRevealMs <= 0) {
        spinWheelToWinner(payload, true);
      } else {
        const turns = phaseElapsedMs(payload, 'revealed') > 0 ? 1 : 5;
        spinWheelToWinner(payload, false, turns, Math.max(220, remainingRevealMs));
      }

      if (!winnerPopupAtSec || serverNow() >= winnerPopupAtSec) {
        renderServerResult(payload);
        return;
      }

      if (stageKey === lastRevealStageKey) return;
      lastRevealStageKey = stageKey;
      clearRevealStageTimer();
      revealStageTimer = setTimeout(() => {
        renderServerResult(payload);
        revealStageTimer = null;
      }, Math.max(0, Math.round((winnerPopupAtSec - serverNow()) * 1000)));
    }

    function scheduleSettlementStage(payload) {
      const winner = resolveWinnerKey(payload);
      const winAmount = resolveDisplayedWinAmount(payload, winner);
      const payoutKey = payoutAnimationKey(payload, winner, winAmount);
      if (!winner || winAmount <= 0) return;
      if (payoutKey === lastSettlementStageKey) return;
      lastSettlementStageKey = payoutKey;
      runAuthoritativePayoutAnimation(payload);
    }

    function formatRound(roundNo) {
      if (!roundNo) return '-';
      const parts = String(roundNo).split('_');
      const value = parts[parts.length - 1];
      if (/^\d{7,}$/.test(value)) {
        return value.slice(-3).replace(/^0+/, '') || '0';
      }
      return value;
    }

    function renderServerHistory(recent) {
      if (Array.isArray(recent) && recent.length && !boardHistoryRows.length) {
        boardHistoryRows = recent;
      }
      renderHistoryOverlay();
    }

    async function refreshHistoryTables(force = false) {
      if (!(window.BDGameFinal && window.BD_GAME_BOOTSTRAP && window.BD_GAME_BOOTSTRAP.gameCode === currentGameCode)) {
        renderHistoryOverlay();
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
        renderHistoryOverlay();
        renderUsersOverlay();
      }
    }

    window.refreshHistoryTables = refreshHistoryTables;

    function setNetwork(status, text) {
      updateNetwork(status, text);
    }

    function setPhaseFromState(payload) {
      const phaseKey = `${payload.round_no || 'na'}:${payload.phase || 'na'}`;
      const changed = phaseKey !== lastPhaseKey;
      lastPhaseKey = phaseKey;

      if (payload.phase === 'betting') {
        const liveBetting = isBettingOpen(payload);
        state.phase = liveBetting ? 'betting' : 'waiting';
        state.spinning = false;
        setMode(liveBetting ? `Betting ${currentDistinctBoardCount(payload)}/${maxDistinctBoards(payload)}` : 'Start Wait');
        renderBets();
        if (changed) {
          stopWheelAnimation();
          clearRevealStageTimer();
          clearSettlementStageTimer();
          lastResultKey = '';
          lastSpinKey = '';
          lastRevealStageKey = '';
          lastSettlementStageKey = '';
          clearRoundVisuals();
          showBanner('start', 'Start Bet', 'Place your chips now', luckyTimings(payload).startPopupMs);
        }
        return;
      }

      betCards.forEach(card => card.classList.add('disabled'));
      if (payload.phase === 'locked') {
        state.phase = 'stop';
        state.spinning = false;
        setMode('Locked');
        if (changed) showBanner('stop', 'Stop Bet', 'Bets locked', luckyTimings(payload).stopPopupMs);
        return;
      }

      if (payload.phase === 'revealed' || payload.phase === 'settled') {
        state.phase = 'result';
        state.spinning = payload.phase === 'revealed';
        setMode('Result');
        return;
      }

      state.phase = 'idle';
      state.spinning = false;
      setMode('Waiting');
    }

    function setCounterFromState(payload) {
      const clockKey = `${payload.round_no || 'na'}:${payload.phase || 'na'}`;
      if (typeof payload.server_time === 'number' && (clockKey !== serverClockKey || !serverClockKey)) {
        serverClockOffsetSec = payload.server_time - (Date.now() / 1000);
        serverClockKey = clockKey;
      }
      if (isBettingOpen(payload) && payload.bet_close_at) {
        const seconds = Math.max(0, Math.ceil(payload.bet_close_at - serverNow()));
        state.counter = seconds;
        setCounter(seconds > 0 ? seconds : '', false, seconds <= 0);
        return;
      }
      if (payload.phase === 'locked') {
        setCounter('', true, true);
        return;
      }
      if (payload.phase === 'revealed' || payload.phase === 'settled') {
        setCounter('', true, true);
        return;
      }
      setCounter('', true, true);
    }

    function renderServerResult(payload) {
      const winner = resolveWinnerKey(payload);
      if (!winner) {
        return;
      }
      const targetIndex = spinWheelToWinner(payload, true);
      const resultKey = `${payload.round_no}:${winner}`;
      if (resultKey === lastResultKey) {
        return;
      }
      lastResultKey = resultKey;
      if (el.wheelInner) void el.wheelInner.offsetWidth;

      clearRoundVisuals();
      const { winningCard, segNode, seatNode } = highlightWinningSelection(winner, targetIndex);
      const winAmount = resolveDisplayedWinAmount(payload, winner);
      if (winningCard) {
        sparkBurst(winningCard, false);
      }
      sparkBurst(seatNode || segNode || document.getElementById('wheelWrap'), winner === 'slot');
      if (winner === 'slot' && winAmount > 0) {
        confettiDrop();
      }
      showBanner('win', winnerBannerTitle(winner, winAmount), winAmount > 0 ? `Won ${money(winAmount)}` : `${betKeyToMark[winner] || winner} landed`, luckyTimings(payload).winnerPopupMs);
      animateWinnerToPopup(winner, seatNode || segNode || winningCard || document.getElementById('wheelWrap'));
    }

    function applyState(payload) {
      sharedRoomState.lastStatePayload = payload;
      authoritativeRoundNo = payload.round_no || authoritativeRoundNo;
      activePlayerRows = Array.isArray(payload.active_players) ? payload.active_players : activePlayerRows;
      syncBalanceDisplay(payload);
      state.boardTotals = {
        melon: Number(payload.board_totals?.melon || 0),
        slot: Number(payload.board_totals?.slot || 0),
        plum: Number(payload.board_totals?.plum || 0),
      };
      state.bets = {
        melon: Number(payload.my_bet_totals?.melon || 0),
        slot: Number(payload.my_bet_totals?.slot || 0),
        plum: Number(payload.my_bet_totals?.plum || 0),
      };
      renderBets();
      state.results = (payload.recent || []).map(item => item.winner_board_key).filter(Boolean);
      renderRecent();
      renderServerHistory(payload.recent || []);
      if (payload.phase === 'settled') {
        const historyRound = String(payload.round_no || '');
        if (historyRound && historyRound !== lastHistorySyncRound) {
          lastHistorySyncRound = historyRound;
          refreshHistoryTables();
        }
      } else if (payload.phase === 'betting') {
        lastHistorySyncRound = '';
      }
      el.roundText.textContent = formatRound(authoritativeRoundNo);
      setCounterFromState(payload);
      setPhaseFromState(payload);
      if (payload.phase === 'revealed') {
        scheduleRevealStage(payload);
      } else if (payload.phase === 'settled') {
        renderServerResult(payload);
        scheduleSettlementStage(payload);
      }
    }

    function mapBetError(message) {
      const map = {
        invalid_session: 'Session expired. Rejoin the room.',
        bet_closed: 'Bet closed. Wait for next round.',
        insufficient_balance: 'Insufficient balance',
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

    async function submitBet(kind, sourceEl) {
      if (!isBettingOpen(sharedRoomState.lastStatePayload) || state.spinning) {
        showToast('Wait for next round');
        return;
      }
      if (state.balance < state.currentChip) {
        openOverlay('balanceOverlay');
        return;
      }
      if (!canUseBoard(sharedRoomState.lastStatePayload, kind)) {
        showToast(boardLimitMessage(sharedRoomState.lastStatePayload));
        return;
      }

      const amount = state.currentChip;
      markPendingBet(kind, 1);
      chipFlyFromSelected(sourceEl);
      sparkBurst(sourceEl);
      const optimisticPayload = optimisticBetPayload(sharedRoomState.lastStatePayload, kind, amount);
      if (optimisticPayload) applyState(optimisticPayload);
      try {
        const response = await api.post(window.BD_GAME_BOOTSTRAP.endpoints.bet, {
          round_no: authoritativeRoundNo,
          board_key: kind,
          amount: amount,
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

    let lastBetPressKey = '';
    let lastBetPressAt = 0;
    function isSyntheticBetClick(kind, eventType) {
      const now = Date.now();
      if (eventType === 'click' && lastBetPressKey === kind && now - lastBetPressAt < 350) return true;
      lastBetPressKey = kind;
      lastBetPressAt = now;
      return false;
    }

    function handleBetCardPress(event) {
      const card = event.target.closest('.bet-card[data-bet]');
      if (!card) return;
      if (event.type === 'pointerup' && event.pointerType === 'mouse' && event.button !== 0) return;
      if (isSyntheticBetClick(card.dataset.bet, event.type)) {
        event.preventDefault();
        return;
      }
      event.preventDefault();
      event.stopPropagation();
      if (typeof event.stopImmediatePropagation === 'function') {
        event.stopImmediatePropagation();
      }
      submitBet(card.dataset.bet, card);
    }

    document.addEventListener('pointerup', handleBetCardPress, true);
    document.addEventListener('click', handleBetCardPress, true);

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
      if (heartbeatTimer) clearInterval(heartbeatTimer);
      heartbeatTimer = setInterval(function() {
        if (typeof api.heartbeat === 'function') {
          api.heartbeat(lastNetworkMs || 0);
        } else {
          api.post(window.BD_GAME_BOOTSTRAP.endpoints.heartbeat, { network_ms: lastNetworkMs || 0 });
        }
      }, 15000);
    }

    if (statePollTimer) clearInterval(statePollTimer);
    statePollTimer = null;
    if (mirrorTimer) clearInterval(mirrorTimer);
    mirrorTimer = setInterval(function() {
      if (sharedRoomState.lastStatePayload) {
        setCounterFromState(sharedRoomState.lastStatePayload);
      }
    }, 250);
    renderHistoryOverlay();
    refreshHistoryTables(true);
    refreshState();
    function cleanupLiveLucky77(){
      if (typeof api.stopHeartbeat === 'function') api.stopHeartbeat();
      if (heartbeatTimer) clearInterval(heartbeatTimer);
      if (statePollTimer) clearInterval(statePollTimer);
      if (mirrorTimer) clearInterval(mirrorTimer);
      heartbeatTimer = null;
      statePollTimer = null;
      mirrorTimer = null;
    }
    window.addEventListener('pagehide', cleanupLiveLucky77, { once: true });
    window.addEventListener('beforeunload', cleanupLiveLucky77, { once: true });
})();
</script>

</body>
</html>
