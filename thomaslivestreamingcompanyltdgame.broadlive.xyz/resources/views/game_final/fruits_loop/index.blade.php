@php
    $currentGameCode = $gameCode ?? 'fruits_loop';
    $gameTheme = is_array($gameTheme ?? null) ? $gameTheme : [];
    $boardRules = (array) ($gameRules['boards'] ?? config('bd_game_final.games.' . $currentGameCode . '.boards', []));
    $loopVariantMeta = [
        'fruits_loop' => [
            'asset_folder' => 'custom',
            'chip_filter' => 'none',
            'title' => 'Fruits Loop',
            'info_copy' => 'Apple, orange, and grapes spin on the Fruits Loop wheel.',
            'wheel_order' => ['apple', 'orange', 'grapes', 'apple', 'orange', 'grapes'],
            'aliases' => ['red' => 'apple', 'orange' => 'orange', 'gold' => 'orange', 'yellow' => 'orange', 'grape' => 'grapes', 'green' => 'grapes', 'watermelon' => 'grapes', 'purple' => 'grapes'],
        ],
        'fruits_loop_ruby' => [
            'asset_folder' => 'ruby',
            'chip_filter' => 'hue-rotate(306deg) saturate(1.22) brightness(1.04)',
            'title' => 'Fruits Loop Ruby',
            'info_copy' => 'Watermelon, lemon, and cherry spin on the Ruby Fruits Loop wheel.',
            'wheel_order' => ['pineapple', 'cherry', 'grapes', 'pineapple', 'cherry', 'grapes'],
            'aliases' => ['watermelon' => 'cherry', 'melon' => 'cherry', 'green' => 'cherry', 'lemon' => 'pineapple', 'yellow' => 'pineapple', 'gold' => 'pineapple', 'cherry' => 'grapes', 'red' => 'grapes'],
        ],
        'fruits_loop_emerald' => [
            'asset_folder' => 'emerald',
            'chip_filter' => 'hue-rotate(162deg) saturate(1.18) brightness(1.06)',
            'title' => 'Fruits Loop Emerald',
            'info_copy' => 'Watermelon, lemon, and cherry spin on the Emerald Fruits Loop wheel.',
            'wheel_order' => ['cherry', 'pineapple', 'grapes', 'cherry', 'pineapple', 'grapes'],
            'aliases' => ['watermelon' => 'cherry', 'melon' => 'cherry', 'green' => 'cherry', 'lemon' => 'pineapple', 'yellow' => 'pineapple', 'gold' => 'pineapple', 'cherry' => 'grapes', 'red' => 'grapes'],
        ],
    ];
    $loopVariant = $loopVariantMeta[$currentGameCode] ?? $loopVariantMeta['fruits_loop'];
    $fruitCatalog = [
        'apple' => ['name' => 'Apple', 'icon' => '&#127822;', 'emoji' => '??', 'color' => '#ef4e58', 'class' => 'red'],
        'orange' => ['name' => 'Orange', 'icon' => '&#127818;', 'emoji' => '??', 'color' => '#ffd24c', 'class' => 'orange'],
        'grapes' => ['name' => 'Grapes', 'icon' => '&#127815;', 'emoji' => '??', 'color' => '#7b5cff', 'class' => 'green'],
        'cherry' => ['name' => 'Cherry', 'icon' => '&#127826;', 'emoji' => '??', 'color' => '#ff5a66', 'class' => 'red'],
        'pineapple' => ['name' => 'Pineapple', 'icon' => '&#127821;', 'emoji' => '??', 'color' => '#ffc84b', 'class' => 'orange'],
        'lemon' => ['name' => 'Lemon', 'icon' => '&#127819;', 'emoji' => '??', 'color' => '#ffd84c', 'class' => 'orange'],
        'watermelon' => ['name' => 'Watermelon', 'icon' => '&#127817;', 'emoji' => '??', 'color' => '#59c85f', 'class' => 'green'],
    ];
    $boards = [];
    $boardAliasMap = [];
    foreach ($boardRules as $board) {
        $key = (string) ($board['frontend_key'] ?? $board['canonical_key'] ?? '');
        if ($key === '') {
            continue;
        }
        $multiplier = rtrim(rtrim(number_format((float) ($board['multiplier'] ?? 1), 2, '.', ''), '0'), '.');
        $meta = $fruitCatalog[$key] ?? ['name' => (string) ($board['display_name'] ?? strtoupper($key)), 'icon' => strtoupper(substr($key, 0, 2)), 'emoji' => '?', 'color' => '#23d3a6', 'class' => 'green'];
        $boards[$key] = [
            'key' => $key,
            'name' => (string) ($meta['name'] ?? ($board['display_name'] ?? strtoupper($key))),
            'icon' => $meta['icon'] ?? strtoupper(substr($key, 0, 2)),
            'emoji' => $meta['emoji'] ?? '?',
            'color' => $meta['color'] ?? '#23d3a6',
            'class' => $meta['class'] ?? 'green',
            'multiplier' => $multiplier,
        ];
        $canonical = (string) ($board['canonical_key'] ?? $key);
        foreach (array_merge([$key, $canonical], (array) ($board['aliases'] ?? [])) as $aliasValue) {
            $aliasValue = strtolower(trim((string) $aliasValue));
            if ($aliasValue !== '') {
                $boardAliasMap[$aliasValue] = $canonical;
            }
        }
    }
    if (in_array($currentGameCode, ['fruits_loop_ruby', 'fruits_loop_emerald'], true)) {
        $variantVisualKeys = [
            'apple' => 'watermelon',
            'orange' => 'lemon',
            'grapes' => 'cherry',
            'cherry' => 'watermelon',
            'pineapple' => 'lemon',
        ];
        foreach ($variantVisualKeys as $boardKey => $visualKey) {
            if (!isset($boards[$boardKey], $fruitCatalog[$visualKey])) {
                continue;
            }
            $visualMeta = $fruitCatalog[$visualKey];
            $boards[$boardKey]['name'] = $visualMeta['name'];
            $boards[$boardKey]['icon'] = $visualMeta['icon'];
            $boards[$boardKey]['emoji'] = $visualMeta['emoji'];
            $boards[$boardKey]['color'] = $visualMeta['color'];
            $boards[$boardKey]['class'] = $visualMeta['class'];
        }
    }
    foreach (($loopVariant['aliases'] ?? []) as $aliasValue => $canonical) {
        $boardAliasMap[strtolower((string) $aliasValue)] = strtolower((string) $canonical);
    }
    $boardKeys = array_keys($boards);
    $wheelOrder = array_values(array_filter(array_map(static function ($value) use ($boardAliasMap) {
        $normalized = strtolower(trim((string) $value));
        return $boardAliasMap[$normalized] ?? $normalized;
    }, (array) config('bd_game_final.games.' . $currentGameCode . '.wheel_order', $loopVariant['wheel_order'] ?? []))));
    $wheelPots = [];
    foreach ($wheelOrder as $wheelKey) {
        if (isset($boards[$wheelKey])) {
            $wheelPots[] = $boards[$wheelKey];
        }
    }
    if (count($wheelPots) !== 6) {
        for ($loopIndex = 0; $loopIndex < 2; $loopIndex++) {
            foreach ($boards as $board) {
                $wheelPots[] = $board;
            }
        }
    }
    $chipValues = [1000, 10000, 50000, 100000];
    $chipClasses = [1000 => 'chip1k', 10000 => 'chip10k', 50000 => 'chip50k', 100000 => 'chip100k'];
    $chipArtIndex = [1000 => 0, 10000 => 1, 50000 => 2, 100000 => 3];
    $primary = $gameTheme['primary_color'] ?? '#131a33';
    $accent = $gameTheme['accent_color'] ?? '#ffd76e';
    $assetFolder = $loopVariant['asset_folder'] ?? 'custom';
    $assetBasePath = 'game_final_assets/fruits_loop/' . $assetFolder;
    $assetFallbackBasePath = 'game_final_assets/fruits_loop/custom';
    $loopAsset = static function (string $file) use ($assetBasePath, $assetFallbackBasePath) {
        $candidate = $assetBasePath . '/' . $file;
        if (file_exists(public_path($candidate))) {
            return asset($candidate);
        }
        return asset($assetFallbackBasePath . '/' . $file);
    };
    $assetBase = asset($assetBasePath);
    $logoGemAsset = $loopAsset('original_wheel_top.webp');
$chipsStripAsset = $loopAsset('chips_strip.webp');
$wheelBackdropAsset = $loopAsset('original_wheel_frame.webp');
$wheelFaceAsset = $loopAsset('original_wheel_face.webp');
$wheelCoverAsset = $loopAsset('original_wheel_top.webp') . '?v=' . time();
$wheelReferenceAsset = $loopAsset('wheel_look_reference_final.webp');
$wheelCenterLogoAsset = $logoGemAsset;
$panelPlayerAsset = $loopAsset('wheel_look_reference_final.webp');
$panelSettingsAsset = $loopAsset('wheel_look_reference_final.webp');
$panelTrendAsset = $loopAsset('wheel_look_reference_final.webp');
$timerStopwatchAsset = $loopAsset('timer_clock_final.webp');
    $wheelPointerAsset = asset('game_final_assets/lucky7_pro/custom/pointer_gem.webp');
    $chipFilterCss = $loopVariant['chip_filter'] ?? 'none';
    $loopInfoCopy = $loopVariant['info_copy'] ?? 'Fruit loop room';
    $visualFruitMeta = array_map(static function ($board) {
        $decodedIcon = html_entity_decode($board['icon'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        return [
            'label' => $board['name'],
            'icon' => $decodedIcon,
            'emoji' => $board['emoji'] ?? $decodedIcon,
        ];
    }, $boards);
@endphp
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no,viewport-fit=cover">
<meta name="theme-color" content="{{ $primary }}">
<title>{{ $loopVariant['title'] ?? 'Fruits Loop' }}</title>
<style>
:root{--stage-w:960;--stage-h:540;--gold-a:#fff6c7;--gold-b:#f9d167;--gold-c:#d38918;--gold-d:#7b4506;--violet-a:#c35cff;--violet-b:#8426e2;--violet-c:#43107d;--aqua-a:#d8fbff;--aqua-b:#9ae7f6;--aqua-c:#62bed8;--bg1:{{ $primary }};--bg2:#0b1123;--accent:{{ $accent }};--shadow-1:0 14px 34px rgba(0,0,0,.34),inset 0 1px 0 rgba(255,255,255,.3);--shadow-2:0 8px 18px rgba(0,0,0,.28),inset 0 1px 0 rgba(255,255,255,.2)}
*{box-sizing:border-box;-webkit-tap-highlight-color:transparent;user-select:none}
html,body{width:100%;height:100%;margin:0;overflow:hidden;font-family:Arial,Helvetica,sans-serif;background:#05040a;color:#fff}
body{background:linear-gradient(180deg,#120c20 0%,#08070f 58%,#05050a 100%)}
button{font:inherit;border:0}
#viewport{position:fixed;inset:0;display:flex;align-items:center;justify-content:center;overflow:hidden;padding:max(env(safe-area-inset-top),4px) max(env(safe-area-inset-right),4px) max(env(safe-area-inset-bottom),4px) max(env(safe-area-inset-left),4px)}
#stageWrap{position:relative;width:100vw;height:100dvh;display:flex;align-items:center;justify-content:center;transform-origin:center center;overflow:visible}
#stage{position:relative;width:960px;height:540px;flex:0 0 960px;transform-origin:center center;overflow:hidden;border-radius:26px;background:linear-gradient(180deg,#11121a 0%,#070810 60%,#05050a 100%);box-shadow:0 28px 70px rgba(0,0,0,.48),0 0 0 1px rgba(255,255,255,.04)}
#stage:before,#stage:after{content:none}
.goldRing{border:2px solid rgba(102,52,0,.86);background:linear-gradient(180deg,var(--gold-a) 0%,var(--gold-b) 24%,var(--gold-c) 66%,var(--gold-d) 100%);box-shadow:var(--shadow-2)}
.purplePill{border:2px solid rgba(255,230,136,.92);border-radius:999px;color:#ffefb5;font-weight:900;text-shadow:0 2px 0 rgba(90,35,0,.45);background:linear-gradient(180deg,var(--violet-a),var(--violet-b) 54%,var(--violet-c));box-shadow:var(--shadow-2)}
.orb,.spark{display:none}
.topRow{position:absolute;left:0;right:0;top:10px;height:58px;z-index:15}.dockRight{position:absolute;display:flex;gap:12px;top:0;right:14px}.circleBtn{width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:900;color:#fff}.midTop{position:absolute;right:118px;top:2px;display:flex;align-items:center;gap:8px}.latencyPill,.roundPill{height:34px;border-radius:999px;padding:0 13px;display:flex;align-items:center;gap:7px;background:rgba(42,21,80,.56);border:1px solid rgba(255,255,255,.16);box-shadow:inset 0 1px 0 rgba(255,255,255,.16),0 10px 20px rgba(0,0,0,.18);font-size:13px;font-weight:900;color:#fff4c9}.latencyDot{width:9px;height:9px;border-radius:50%;background:#65ff6e;box-shadow:0 0 12px #65ff6e}.roundPill b{color:#ffe58f}
#wheelZone{--wheel-zone-w:420px;--wheel-shell-w:404px;--wheel-shell-h:230px;--wheel-window-w:308px;--wheel-window-h:156px;--wheel-face-size:278px;position:absolute;left:50%;top:-2px;transform:translateX(-50%);width:var(--wheel-zone-w);height:246px;display:flex;justify-content:center;align-items:flex-start;z-index:10;filter:drop-shadow(0 16px 24px rgba(0,0,0,.18)) drop-shadow(0 24px 34px rgba(52,11,78,.14))}
#wheelBackdrop{position:absolute;left:50%;top:0;transform:translateX(-50%);width:var(--wheel-shell-w);height:var(--wheel-shell-h);opacity:.22;filter:saturate(1.05);pointer-events:none;z-index:0}
#wheelShell{position:absolute;left:50%;top:0;transform:translateX(-50%);width:var(--wheel-shell-w);height:var(--wheel-shell-h);border-radius:0;background:none;box-shadow:none;overflow:visible;z-index:1}
#wheelShell:before,#wheelShell:after{display:none}
#wheelTitle{position:absolute;left:50%;top:8px;transform:translateX(-50%);width:210px;height:44px;display:flex;align-items:center;justify-content:center;font-size:24px;z-index:12}#wheelTitle:before,#wheelTitle:after{content:"";position:absolute;top:11px;width:28px;height:20px;background:linear-gradient(180deg,#ffe89b,#c6760c);border:2px solid rgba(111,54,0,.9);border-radius:10px 14px 14px 10px;box-shadow:0 5px 10px rgba(0,0,0,.18)}#wheelTitle:before{left:-18px;transform:skewX(-18deg)}#wheelTitle:after{right:-18px;transform:scaleX(-1) skewX(-18deg)}
#brandBadge{width:34px;height:34px;display:block;object-fit:contain;filter:drop-shadow(0 4px 8px rgba(0,0,0,.26))}
#wheelAura{position:absolute;left:50%;top:22px;transform:translateX(-50%);width:324px;height:148px;border-radius:50%;pointer-events:none;z-index:0;background:radial-gradient(circle at 50% 50%,rgba(255,255,255,.45) 0 8%,rgba(255,224,120,.22) 18%,rgba(147,83,255,.18) 34%,rgba(84,239,255,.14) 52%,rgba(0,0,0,0) 72%);filter:blur(12px) saturate(135%);animation:wheelAuraPulse 3.2s ease-in-out infinite}
#wheelRays{position:absolute;left:50%;top:24px;transform:translateX(-50%);width:300px;height:140px;border-radius:50%;pointer-events:none;z-index:1;opacity:.54;background:repeating-conic-gradient(from 0deg,rgba(255,255,255,.20) 0deg 9deg,rgba(255,255,255,0) 9deg 20deg);-webkit-mask:radial-gradient(circle at 50% 50%,transparent 0 36%,#000 56%,transparent 72%);mask:radial-gradient(circle at 50% 50%,transparent 0 36%,#000 56%,transparent 72%);mix-blend-mode:screen;animation:wheelRaysSpin 18s linear infinite}
#wheelGlow{position:absolute;left:50%;top:44px;transform:translateX(-50%);width:324px;height:138px;border-radius:50%;pointer-events:none;z-index:1;background:radial-gradient(circle at 50% 46%,rgba(255,255,255,.58),rgba(255,225,116,.16) 28%,rgba(116,242,255,.18) 48%,rgba(166,83,255,.12) 62%,rgba(0,0,0,0) 76%);filter:blur(8px) saturate(140%);opacity:.68}
#wheelWindow{position:absolute;left:50%;top:46px;transform:translateX(-50%);width:var(--wheel-window-w);height:var(--wheel-window-h);overflow:hidden;isolation:isolate;border-radius:170px 170px 34px 34px / 126px 126px 24px 24px;background:none;box-shadow:none}
#wheelScan{position:absolute;left:50%;top:12px;transform:translateX(-50%);width:292px;height:132px;border-radius:50%;pointer-events:none;z-index:3;opacity:.62;background:linear-gradient(115deg,rgba(255,255,255,0) 22%,rgba(255,255,255,.18) 36%,rgba(255,255,255,.62) 44%,rgba(255,255,255,.10) 56%,rgba(255,255,255,0) 68%);mix-blend-mode:screen;animation:wheelScan 3.4s ease-in-out infinite}
#wheelHaloRing{position:absolute;left:50%;top:15px;transform:translateX(-50%);width:286px;height:128px;border-radius:50%;pointer-events:none;z-index:2;border:2px solid rgba(255,248,196,.36);box-shadow:0 0 0 2px rgba(255,255,255,.06),inset 0 0 22px rgba(255,255,255,.15),0 0 28px rgba(255,224,126,.16);opacity:.68}
#wheelRotator{position:absolute;left:50%;top:8px;width:var(--wheel-face-size);height:var(--wheel-face-size);transform:translateX(-50%) rotate(0deg);transform-origin:50% 50%;will-change:transform}
#wheelFace{position:absolute;inset:0;border-radius:50%;overflow:hidden;background:url('{{ $wheelFaceAsset }}') center/cover no-repeat;box-shadow:none}
#wheelFace:before{content:"";position:absolute;inset:16px;border-radius:50%;box-shadow:inset 0 0 0 2px rgba(255,255,255,.18);background:radial-gradient(circle at 36% 26%,rgba(255,255,255,.14),transparent 18%),radial-gradient(circle at 50% 50%,transparent 0 66px,rgba(255,244,196,.10) 66px 74px,transparent 74px),radial-gradient(circle at 50% 90%,rgba(0,0,0,.08),transparent 34%)}
#wheelFace:after{content:"";position:absolute;inset:6px;border-radius:50%;background:radial-gradient(circle at 50% 14%,rgba(255,255,255,.14),transparent 26%),radial-gradient(circle at 50% 108%,rgba(0,0,0,.14),transparent 34%);pointer-events:none}.sectorLine{position:absolute;left:50%;top:10px;width:4px;height:132px;margin-left:-2px;border-radius:999px;background:linear-gradient(180deg,rgba(255,247,210,.95),rgba(118,61,0,.92));transform-origin:50% 132px;box-shadow:0 0 10px rgba(255,255,255,.14);opacity:.9}.sectorLine.l0{transform:rotate(30deg)}.sectorLine.l1{transform:rotate(90deg)}.sectorLine.l2{transform:rotate(150deg)}.sectorLine.l3{transform:rotate(210deg)}.sectorLine.l4{transform:rotate(270deg)}.sectorLine.l5{transform:rotate(330deg)}
.wheelFruit{position:absolute;left:50%;top:50%;width:54px;height:54px;margin-left:-27px;margin-top:-27px;display:flex;align-items:center;justify-content:center;border-radius:50%;font-size:31px;text-shadow:0 2px 0 rgba(255,255,255,.18),0 4px 10px rgba(0,0,0,.34);filter:drop-shadow(0 6px 6px rgba(0,0,0,.25));z-index:2}.wheelFruit:before{content:"";position:absolute;inset:4px;border-radius:50%;background:radial-gradient(circle at 35% 28%,rgba(255,255,255,.52),rgba(255,255,255,.12) 28%,rgba(255,255,255,.02) 56%,rgba(0,0,0,.12) 100%);box-shadow:inset 0 0 0 2px rgba(255,241,190,.54),inset 0 -8px 10px rgba(0,0,0,.12);z-index:-1}.wheelFruit.wf0{transform:rotate(0deg) translateY(-98px) rotate(0deg)}.wheelFruit.wf1{transform:rotate(60deg) translateY(-98px) rotate(-60deg)}.wheelFruit.wf2{transform:rotate(120deg) translateY(-98px) rotate(-120deg)}.wheelFruit.wf3{transform:rotate(180deg) translateY(-98px) rotate(-180deg)}.wheelFruit.wf4{transform:rotate(240deg) translateY(-98px) rotate(-240deg)}.wheelFruit.wf5{transform:rotate(300deg) translateY(-98px) rotate(-300deg)}
#wheelCenter{position:absolute;left:50%;top:50%;width:86px;height:86px;margin-left:-43px;margin-top:-43px;border-radius:50%;background:radial-gradient(circle at 35% 30%,#fff8cf,#ffd25c 45%,#ca7b09 70%,#7f3f04 100%);box-shadow:0 0 0 5px rgba(255,241,184,.86),0 0 0 12px rgba(140,68,0,.96),0 10px 18px rgba(0,0,0,.24);z-index:3}#wheelCenter:before{content:"";position:absolute;inset:11px;border-radius:50%;background:radial-gradient(circle at 35% 30%,rgba(255,255,255,.85),rgba(255,255,255,.12) 32%,transparent 34%),radial-gradient(circle at 50% 46%,#7c3cf6,#4618a7 70%,#2f0c74 100%);box-shadow:inset 0 1px 0 rgba(255,255,255,.42)}#wheelCenter:after{content:"*";position:absolute;left:50%;top:50%;transform:translate(-50%,-52%);font-size:28px;color:#ffeaa0;text-shadow:0 2px 0 rgba(88,39,0,.34)}
#pointer{position:absolute;left:50%;top:48px;transform:translateX(-50%);width:48px;height:48px;z-index:14;pointer-events:none;filter:drop-shadow(0 10px 14px rgba(0,0,0,.24))}#pointerGem{position:absolute;left:50%;top:-1px;transform:translateX(-50%);width:28px;height:28px;border-radius:50%;background:radial-gradient(circle at 34% 30%,#ffd7f8,#ff56d2 56%,#b1007a 100%);border:3px solid rgba(255,226,170,.94);box-shadow:0 0 0 3px rgba(255,255,255,.10),inset 0 2px 0 rgba(255,255,255,.7),0 0 22px rgba(255,112,238,.34),0 0 38px rgba(255,208,108,.22),0 10px 16px rgba(0,0,0,.22)}#pointerArrow{position:absolute;left:50%;top:18px;transform:translateX(-50%);width:0;height:0;border-left:16px solid transparent;border-right:16px solid transparent;border-top:30px solid #ff49cd;filter:drop-shadow(0 2px 0 rgba(255,255,255,.3)) drop-shadow(0 8px 12px rgba(0,0,0,.22))}#pointer.spinning #pointerArrow{animation:pointerTick .16s linear infinite}#pointerFlash{position:absolute;left:50%;top:14px;transform:translateX(-50%);width:92px;height:92px;border-radius:50%;pointer-events:none;opacity:0;background:radial-gradient(circle,rgba(255,255,255,.82) 0%,rgba(255,226,140,.34) 18%,rgba(255,91,244,.16) 38%,rgba(0,0,0,0) 70%);filter:blur(9px)}
#timer{position:absolute;left:50%;top:92px;transform:translateX(-50%);width:66px;height:66px;border-radius:50%;display:flex;align-items:center;justify-content:center;z-index:14;border:3px solid rgba(255,246,193,.96);background:radial-gradient(circle at 34% 30%,#fffacf,#ffd96f 56%,#da7f05);color:#7a3800;font-size:31px;font-weight:900;box-shadow:0 12px 26px rgba(0,0,0,.28),inset 0 2px 0 rgba(255,255,255,.4)}#timerPulse{position:absolute;inset:-8px;border-radius:50%;border:3px solid rgba(255,255,255,.32);animation:pulseRing 1.12s infinite}#countNum{position:relative}
#statusBar{position:absolute;left:50%;top:176px;transform:translateX(-50%);min-width:196px;padding:10px 26px;border-radius:18px;background:linear-gradient(180deg,#3c315f,#171824);border:2px solid rgba(255,255,255,.15);font-size:25px;font-weight:900;letter-spacing:.3px;box-shadow:0 12px 24px rgba(0,0,0,.34);z-index:18;opacity:0;pointer-events:none;transition:.22s ease;text-align:center}#statusBar.show{opacity:1}#winnerBanner{position:absolute;left:50%;top:150px;transform:translateX(-50%);font-size:40px;font-weight:900;color:#fff8cc;text-shadow:0 4px 0 rgba(106,47,0,.42),0 0 18px rgba(255,232,142,.36);z-index:19;opacity:0;pointer-events:none}#winnerBanner.show{animation:winBurst 1.9s ease forwards}
#board{position:absolute;left:50%;top:212px;transform:translateX(-50%);width:706px;min-height:174px;border-radius:26px;z-index:8;padding:10px 14px 14px;display:grid;grid-template-columns:repeat(3,minmax(0,1fr));grid-template-rows:40px minmax(0,1fr);column-gap:14px;row-gap:8px;align-items:start;background:linear-gradient(180deg,rgba(255,255,255,.26),rgba(255,255,255,.09)),linear-gradient(180deg,rgba(156,238,252,.52),rgba(119,210,232,.44));box-shadow:inset 0 1px 0 rgba(255,255,255,.46),inset 0 -1px 0 rgba(0,0,0,.06),0 16px 26px rgba(0,0,0,.18)}#board:before{content:"";position:absolute;inset:8px;border-radius:20px;border:1px solid rgba(255,255,255,.24);pointer-events:none}#board:after{content:"";position:absolute;left:0;right:0;top:0;height:36px;border-radius:26px 26px 0 0;background:linear-gradient(180deg,rgba(255,255,255,.20),rgba(255,255,255,0));pointer-events:none}
.betFruit{position:relative;width:38px;height:38px;border-radius:50%;display:flex;align-items:center;justify-content:center;justify-self:center;background:radial-gradient(circle at 35% 30%,rgba(255,255,255,.96),rgba(255,255,255,.20) 32%,transparent 40%),radial-gradient(circle at 30% 28%,#fff8d9,#f2d27d 62%,#bb770d);border:2px solid rgba(255,255,255,.38);box-shadow:0 4px 12px rgba(0,0,0,.18);font-size:22px;z-index:2}.betFruit:nth-of-type(1){grid-column:1;grid-row:1}.betFruit:nth-of-type(2){grid-column:2;grid-row:1}.betFruit:nth-of-type(3){grid-column:3;grid-row:1}
.betBox{position:relative;width:100%;height:132px;border-radius:22px;cursor:pointer;box-shadow:0 16px 24px rgba(0,0,0,.22),inset 0 1px 0 rgba(255,255,255,.28);transition:transform .16s ease,filter .16s ease,box-shadow .16s ease;overflow:hidden;grid-row:2;color:#fff}.betBox:hover{transform:translateY(-2px)}.betBox:before{content:"";position:absolute;inset:0;border-radius:22px;border:2px solid rgba(255,242,190,.48);pointer-events:none}.betBox:after{content:"";position:absolute;top:-28px;left:-84px;width:112px;height:208px;background:linear-gradient(180deg,rgba(255,255,255,.18),rgba(255,255,255,0));transform:rotate(15deg);pointer-events:none}.betBox.pending,.betBox.selected{animation:blinkGlow .9s infinite}.betBox.win{animation:winnerBoardBlink .74s ease-in-out infinite;box-shadow:0 0 0 5px rgba(255,249,190,.42),0 0 34px rgba(255,247,182,.76),0 0 60px rgba(96,245,255,.22),0 20px 28px rgba(0,0,0,.30);z-index:4}.betBox.dim{filter:brightness(.62) saturate(.62)}.betBox.disabled{cursor:not-allowed;filter:brightness(.8) saturate(.76)}.betBox.orange{background:linear-gradient(180deg,#ffca4a 0%,#f6aa32 48%,#de7d12 100%)}.betBox.green{background:linear-gradient(180deg,#8be84e 0%,#54c33a 48%,#29921d 100%)}.betBox.red{background:linear-gradient(180deg,#ff6a6a 0%,#ef414b 48%,#be1720 100%)}
.boxInnerFrame{position:absolute;inset:8px;border-radius:16px;border:1px solid rgba(255,255,255,.34);background:linear-gradient(180deg,rgba(255,255,255,.10),rgba(255,255,255,.02));pointer-events:none}.potText{position:absolute;left:15px;top:12px;font-size:16px;font-weight:900;color:#ffeec4;text-shadow:0 2px 0 rgba(0,0,0,.26)}.potText span{font-size:19px}.combo{position:absolute;left:0;right:0;top:38px;display:flex;justify-content:center;gap:10px}.fruitBadge{width:56px;height:56px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:30px;background:radial-gradient(circle at 35% 30%,rgba(255,255,255,.96),rgba(255,255,255,.18) 40%,transparent 55%),radial-gradient(circle at 30% 28%,#fff8d9,#f2d27d 62%,#bb770d);border:2px solid rgba(255,255,255,.38);box-shadow:0 4px 12px rgba(0,0,0,.18)}.youText{position:absolute;left:15px;bottom:11px;font-size:21px;font-weight:900;text-shadow:0 3px 0 rgba(0,0,0,.22)}.youText small{font-size:13px;opacity:.88;margin-right:4px}.multText{position:absolute;right:15px;bottom:12px;font-size:18px;font-weight:1000;color:#fff4c7;text-shadow:0 2px 0 rgba(0,0,0,.25)}.chipField{position:absolute;inset:0 0 18px 0;pointer-events:none}
.boxChip,.flyingChip{position:absolute;width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:transparent;font-size:0;font-weight:900;border:0;box-shadow:0 10px 16px rgba(0,0,0,.28);z-index:40;pointer-events:none;background-position:center!important;background-size:contain!important;background-repeat:no-repeat!important;text-indent:-999px;overflow:hidden}.boxChip:before,.flyingChip:before{content:none}.boxChip.justLanded{animation:chipLand .34s cubic-bezier(.18,.88,.24,1.2)}.boxChip.chip1k,.flyingChip.chip1k{background-image:url('{{ asset('game_final_assets/lucky7_pro/custom/chip_1k.webp') }}')!important}.boxChip.chip10k,.flyingChip.chip10k{background-image:url('{{ asset('game_final_assets/lucky7_pro/custom/chip_10k.webp') }}')!important}.boxChip.chip50k,.flyingChip.chip50k{background-image:url('{{ asset('game_final_assets/lucky7_pro/custom/chip_50k.webp') }}')!important}.boxChip.chip100k,.flyingChip.chip100k{background-image:url('{{ asset('game_final_assets/lucky7_pro/custom/chip_100k.webp') }}')!important}.boxChip.chip500,.flyingChip.chip500{background-image:url('{{ asset('game_final_assets/lucky7_pro/custom/chip_1k.webp') }}')!important}
#bottomBar{position:absolute;left:50%;transform:translateX(-50%);bottom:12px;width:710px;z-index:14;display:grid;grid-template-columns:176px minmax(0,1fr);align-items:end;column-gap:16px}#balancePill{position:relative;bottom:18px;width:176px;height:52px;border-radius:18px;display:flex;align-items:center;padding:0 18px;gap:12px;background:linear-gradient(180deg,#7852c2,#502b94);border:2px solid rgba(249,215,116,.95);box-shadow:0 18px 28px rgba(0,0,0,.3),inset 0 1px 0 rgba(255,255,255,.2)}#balanceIcon{font-size:28px}#balanceValue{font-size:24px;font-weight:900;color:#ffeeb2;white-space:nowrap;min-width:0;overflow:hidden;text-overflow:ellipsis}#chipDock{position:relative;height:88px;display:flex;align-items:flex-end;justify-content:center;gap:14px;padding:8px 12px 6px;border-radius:22px;background:linear-gradient(180deg,rgba(16,124,52,.60),rgba(9,86,36,.60));border:1px solid rgba(170,255,195,.34);box-shadow:inset 0 1px 0 rgba(255,255,255,.18),0 12px 20px rgba(0,0,0,.24)}.chipBtn{position:relative;width:72px;height:72px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:transparent;font-size:0;cursor:pointer;background:url('{{ $chipsStripAsset }}') center/500% 100% no-repeat;box-shadow:0 18px 26px rgba(0,0,0,.32),inset 0 3px 5px rgba(255,255,255,.18),inset 0 -6px 8px rgba(0,0,0,.18);transition:transform .14s ease,box-shadow .14s ease;overflow:hidden}.chipBtn:before{content:"";position:absolute;inset:5px;border-radius:50%;border:2px solid rgba(255,255,255,.18)}.chipBtn:after{content:"";position:absolute;inset:0;border-radius:50%;background:radial-gradient(circle at 34% 28%,rgba(255,255,255,.34),rgba(255,255,255,.06) 34%,rgba(255,255,255,0) 46%);mix-blend-mode:screen}.chipBtn.active{transform:translateY(-9px) scale(1.08);box-shadow:0 0 0 4px rgba(255,255,255,.08),0 18px 28px rgba(0,0,0,.36),0 0 18px rgba(255,236,166,.28),inset 0 3px 5px rgba(255,255,255,.24),inset 0 -6px 8px rgba(0,0,0,.18)}
#toast{position:absolute;left:50%;bottom:110px;transform:translateX(-50%);min-width:260px;max-width:70%;padding:13px 18px;border-radius:999px;background:linear-gradient(180deg,#41286a,#231239);border:2px solid rgba(255,215,122,.44);color:#fff;font-size:18px;font-weight:900;text-align:center;z-index:60;opacity:0;pointer-events:none;transition:.22s ease}#toast.show{opacity:1;animation:toastUp .18s ease forwards}.chipTrailSpark{position:absolute;width:12px;height:12px;border-radius:50%;pointer-events:none;z-index:58;background:radial-gradient(circle,rgba(255,255,255,.95),rgba(255,212,120,.78) 40%,rgba(250,87,255,.22) 66%,rgba(0,0,0,0) 72%);box-shadow:0 0 14px rgba(255,220,132,.5),0 0 24px rgba(255,117,243,.18);opacity:.9}.betImpact{position:absolute;width:24px;height:24px;border-radius:50%;margin-left:-12px;margin-top:-12px;pointer-events:none;z-index:57;border:2px solid rgba(255,236,166,.84);background:radial-gradient(circle,rgba(255,255,255,.85),rgba(255,238,179,.22) 36%,rgba(255,255,255,0) 72%);box-shadow:0 0 20px rgba(255,216,93,.26),0 0 40px rgba(215,91,255,.14);animation:impactBoom .58s ease-out forwards}.betImpact:before,.betImpact:after{content:"";position:absolute;left:50%;top:50%;width:10px;height:10px;margin-left:-5px;margin-top:-5px;border-radius:50%;border:2px solid rgba(255,255,255,.52)}.betImpact:before{animation:impactRing .58s ease-out forwards}.betImpact:after{animation:impactRing2 .58s ease-out forwards}
#wheelZone.ai-spin #wheelAura{animation-duration:1.15s;opacity:1;filter:blur(14px) saturate(150%)}#wheelZone.ai-spin #wheelRays{animation-duration:2.2s;opacity:.92}#wheelZone.ai-spin #wheelScan{animation-duration:.85s;opacity:1}#wheelZone.ai-hit #pointerFlash{animation:pointerFlash .42s ease-out 1}#wheelZone.ai-win #wheelGlow{animation:wheelGlowBlast .8s ease-out 1}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-13px)}}@keyframes toastUp{0%{opacity:0;transform:translateX(-50%) translateY(14px)}100%{opacity:1;transform:translateX(-50%) translateY(0)}}@keyframes pulseRing{0%{transform:scale(.92);opacity:.54}72%{transform:scale(1.18);opacity:0}100%{opacity:0}}@keyframes winBurst{0%{opacity:0;transform:translateX(-50%) translateY(16px) scale(.84)}12%{opacity:1}78%{opacity:1}100%{opacity:0;transform:translateX(-50%) translateY(-18px) scale(1.08)}}@keyframes blinkGlow{0%,100%{box-shadow:0 0 0 0 rgba(255,255,255,.08),0 0 0 0 rgba(255,240,155,0)}50%{box-shadow:0 0 0 6px rgba(255,255,255,.06),0 0 24px 8px rgba(255,240,155,.24)}}@keyframes winnerBoardBlink{0%,100%{transform:translateY(-2px) scale(1.015);filter:brightness(1.2) saturate(1.2)}50%{transform:translateY(-6px) scale(1.045);filter:brightness(1.55) saturate(1.38)}}@keyframes pointerTick{0%,100%{transform:translateX(-50%) rotate(0deg)}50%{transform:translateX(-50%) rotate(-8deg)}}@keyframes wheelAuraPulse{0%,100%{transform:translateX(-50%) scale(.96);opacity:.72}50%{transform:translateX(-50%) scale(1.06);opacity:1}}@keyframes wheelRaysSpin{from{transform:translateX(-50%) rotate(0deg)}to{transform:translateX(-50%) rotate(360deg)}}@keyframes wheelScan{0%,100%{transform:translateX(-50%) translateX(-48px) skewX(-14deg);opacity:.18}50%{transform:translateX(-50%) translateX(52px) skewX(-14deg);opacity:.95}}@keyframes pointerFlash{0%{opacity:0;transform:translateX(-50%) scale(.5)}22%{opacity:1}100%{opacity:0;transform:translateX(-50%) scale(1.45)}}@keyframes wheelGlowBlast{0%{transform:translateX(-50%) scale(1);opacity:.88}40%{transform:translateX(-50%) scale(1.18);opacity:1}100%{transform:translateX(-50%) scale(.98);opacity:.86}}@keyframes chipLand{0%{transform:scale(.62) rotate(-18deg);opacity:.24}55%{transform:scale(1.16) rotate(8deg);opacity:1}100%{transform:scale(1) rotate(0deg);opacity:1}}@keyframes impactBoom{0%{transform:scale(.25);opacity:1}80%{opacity:.85}100%{transform:scale(1.95);opacity:0}}@keyframes impactRing{0%{transform:translate(-50%,-50%) scale(.1);opacity:1}100%{transform:translate(-50%,-50%) scale(3.6);opacity:0}}@keyframes impactRing2{0%{transform:translate(-50%,-50%) scale(.1);opacity:.88}100%{transform:translate(-50%,-50%) scale(5.1);opacity:0}}
@media(max-height:620px){#wheelZone{--wheel-zone-w:398px;--wheel-shell-w:382px;--wheel-shell-h:220px;--wheel-window-w:292px;--wheel-window-h:148px;--wheel-face-size:262px;height:236px;top:-2px}#board{top:204px}#statusBar{top:170px}.chipBtn{width:66px;height:66px;font-size:15px}#chipDock{height:84px}}@media(max-height:560px){#wheelZone{--wheel-zone-w:388px;--wheel-shell-w:372px;--wheel-shell-h:212px;--wheel-window-w:286px;--wheel-window-h:142px;--wheel-face-size:254px;height:228px;top:-4px}.wheelFruit{font-size:28px;width:50px;height:50px;margin-left:-25px;margin-top:-25px}.wheelFruit.wf0{transform:rotate(0deg) translateY(-90px) rotate(0deg)}.wheelFruit.wf1{transform:rotate(60deg) translateY(-90px) rotate(-60deg)}.wheelFruit.wf2{transform:rotate(120deg) translateY(-90px) rotate(-120deg)}.wheelFruit.wf3{transform:rotate(180deg) translateY(-90px) rotate(-180deg)}.wheelFruit.wf4{transform:rotate(240deg) translateY(-90px) rotate(-240deg)}.wheelFruit.wf5{transform:rotate(300deg) translateY(-90px) rotate(-300deg)}#wheelCenter{width:80px;height:80px;margin-left:-40px;margin-top:-40px}#board{top:196px}#statusBar{top:164px}#winnerBanner{top:140px}}

/* Portrait production layout */
#viewport{padding:0;background:radial-gradient(circle at 50% 18%,rgba(255,220,120,.13),transparent 30%),linear-gradient(180deg,#10081d,#050817)}
#stageWrap{width:100vw;height:100dvh;align-items:stretch}
#stage{width:100%;max-width:430px;height:100dvh;min-height:620px;flex:0 0 auto;border-radius:0;transform:none!important;margin:0 auto;background:radial-gradient(circle at 50% 6%,rgba(255,255,255,.22),transparent 22%),radial-gradient(circle at 18% 34%,rgba(255,90,185,.20),transparent 20%),radial-gradient(circle at 88% 62%,rgba(80,255,220,.13),transparent 22%),linear-gradient(180deg,#18225f 0%,#0b1029 46%,#060712 100%)}
#stage:before{filter:blur(18px);opacity:.85}
.topRow{top:max(env(safe-area-inset-top),10px);height:104px;padding:0 12px;display:grid;grid-template-columns:1fr;gap:8px}
.midTop{position:relative;right:auto;top:auto;justify-content:center;gap:8px;order:2}.latencyPill,.roundPill{height:30px;font-size:11px;padding:0 10px}
.dockRight{position:relative;right:auto;top:auto;display:grid;grid-template-columns:repeat(4,1fr);gap:7px;order:1}
.circleBtn,.menuBtn{height:42px;width:100%;min-width:0;border-radius:14px;font-size:18px;letter-spacing:0;text-transform:none}
.menuBtn{display:flex;align-items:center;justify-content:center;border:1px solid rgba(255,231,154,.42);background:linear-gradient(180deg,rgba(255,255,255,.16),rgba(0,0,0,.18));color:#fff4cb;box-shadow:0 8px 18px rgba(0,0,0,.24),inset 0 1px 0 rgba(255,255,255,.22);font-weight:1000}
.userMenuBtn{position:relative}.userMenuBtn .activeCount{position:absolute;right:5px;top:4px;min-width:16px;height:16px;border-radius:999px;padding:0 4px;display:flex;align-items:center;justify-content:center;background:linear-gradient(180deg,#62ff8a,#139437);border:1px solid rgba(255,255,255,.72);color:#03140a;font-size:9px;font-weight:1000;line-height:1;box-shadow:0 0 10px rgba(80,255,126,.45)}
#wheelZone{--wheel-zone-w:min(96vw,404px);--wheel-shell-w:min(92vw,388px);--wheel-shell-h:222px;--wheel-window-w:min(72vw,300px);--wheel-window-h:150px;--wheel-face-size:min(66vw,270px);top:112px;height:236px}
#timer{left:50%;top:236px;transform:translateX(-50%);width:58px;height:58px;font-size:27px}
#statusBar{top:294px;font-size:16px;padding:10px 22px;min-width:154px;border-radius:999px;background:linear-gradient(180deg,rgba(255,246,188,.96),rgba(245,151,24,.96));border:3px solid rgba(104,53,0,.82);color:#421600;text-shadow:0 1px 0 rgba(255,255,255,.42);box-shadow:0 16px 26px rgba(0,0,0,.35),0 0 28px rgba(255,214,93,.28),inset 0 2px 0 rgba(255,255,255,.65)}
#statusBar:before,#statusBar:after{content:"";position:absolute;top:50%;width:20px;height:18px;border-radius:999px;background:linear-gradient(180deg,#fff0ad,#b96c08);border:2px solid rgba(101,51,0,.72);transform:translateY(-50%)}#statusBar:before{left:-13px}#statusBar:after{right:-13px}
#winnerBanner{top:268px;left:50%;width:auto;min-width:218px;max-width:calc(100% - 52px);padding:12px 20px;border-radius:20px;background:linear-gradient(180deg,rgba(89,42,160,.98),rgba(24,14,58,.98));border:2px solid rgba(255,231,154,.62);font-size:22px;text-align:center;box-shadow:0 22px 40px rgba(0,0,0,.42),0 0 24px rgba(255,214,93,.22)}
#board{top:auto;bottom:96px;width:calc(100% - 22px);min-height:232px;padding:11px;border-radius:22px;grid-template-columns:repeat(3,minmax(0,1fr));grid-template-rows:34px 1fr;column-gap:8px;row-gap:8px}
.betFruit{width:34px;height:34px;font-size:20px}
.betBox{height:170px;border-radius:18px}.betBox:before{border-radius:18px}.boxInnerFrame{inset:7px;border-radius:14px}.potText{left:9px;top:10px;font-size:12px}.potText span{font-size:14px}.combo{top:48px}.fruitBadge{width:54px;height:54px;font-size:30px}.youText{left:9px;bottom:12px;font-size:16px}.youText small{display:block;font-size:10px;margin:0}.multText{right:9px;bottom:13px;font-size:16px}.chipField{inset:0 0 24px 0}
#bottomBar{width:calc(100% - 18px);left:9px;right:9px;bottom:max(env(safe-area-inset-bottom),9px);transform:none;display:grid;grid-template-columns:84px minmax(0,1fr);align-items:center;gap:6px;padding:8px;border-radius:22px;background:linear-gradient(180deg,rgba(255,255,255,.24),rgba(255,255,255,.08)),linear-gradient(180deg,rgba(126,222,239,.36),rgba(39,89,130,.22));border:1px solid rgba(255,255,255,.24);box-shadow:0 18px 34px rgba(0,0,0,.34),inset 0 1px 0 rgba(255,255,255,.38);backdrop-filter:blur(14px) saturate(128%)}
#balancePill{bottom:0;width:84px;height:46px;justify-content:center;border-radius:16px;padding:0 6px;gap:3px}#balanceIcon{font-size:15px}#balanceValue{font-size:13px}
#chipDock{height:46px;gap:4px;min-width:0}.chipBtn{width:100%;height:44px;font-size:9px;min-width:0}
#toast{bottom:calc(max(env(safe-area-inset-bottom),9px) + 92px);font-size:14px;max-width:calc(100% - 24px);border-radius:18px;background:linear-gradient(180deg,rgba(255,246,188,.96),rgba(245,151,24,.96));color:#421600;text-shadow:0 1px 0 rgba(255,255,255,.38)}
#winnerHistory{position:absolute;left:50%;bottom:338px;transform:translateX(-50%);width:calc(100% - 24px);max-width:408px;height:38px;z-index:13;display:grid;grid-template-columns:auto minmax(0,1fr);align-items:center;gap:8px;padding:5px 8px;border-radius:16px;background:linear-gradient(180deg,rgba(255,255,255,.18),rgba(255,255,255,.07)),rgba(14,18,42,.62);border:1px solid rgba(255,231,154,.32);box-shadow:0 12px 24px rgba(0,0,0,.26),inset 0 1px 0 rgba(255,255,255,.20);backdrop-filter:blur(10px) saturate(130%)}#winnerHistory .historyTitle{font-size:9px;font-weight:1000;letter-spacing:.08em;text-transform:uppercase;color:#ffe7a4;white-space:nowrap;text-shadow:0 1px 0 rgba(0,0,0,.28)}#winnerHistoryList{min-width:0;display:flex;align-items:center;gap:5px;overflow:hidden}.winnerDot{width:24px;height:24px;flex:0 0 24px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:16px;background:radial-gradient(circle at 34% 26%,rgba(255,255,255,.96),rgba(255,255,255,.18) 42%,rgba(0,0,0,.08));border:1px solid rgba(255,239,183,.62);box-shadow:0 5px 9px rgba(0,0,0,.22)}.winnerDot.apple{background-color:rgba(239,78,88,.68)}.winnerDot.orange{background-color:rgba(255,210,76,.68)}.winnerDot.grapes{background-color:rgba(60,202,90,.68)}.winnerDot.empty{opacity:.45;color:#ffe7a4;font-size:12px}
.appModal{position:absolute;inset:0;z-index:90;display:none;align-items:flex-end;justify-content:center;background:rgba(3,5,14,.62);backdrop-filter:blur(12px);padding:16px}
.appModal.is-open{display:flex}
.modalCard{width:100%;max-width:404px;max-height:78dvh;overflow:auto;border-radius:22px;background:linear-gradient(180deg,rgba(31,25,79,.98),rgba(8,10,24,.98));border:1px solid rgba(255,231,154,.30);box-shadow:0 28px 60px rgba(0,0,0,.5),inset 0 1px 0 rgba(255,255,255,.16)}
.modalHead{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:14px 16px;border-bottom:1px solid rgba(255,255,255,.10)}
.modalHead h3{margin:0;font-size:16px;letter-spacing:.12em;text-transform:uppercase;color:#fff4cb}.modalClose{width:34px;height:34px;border-radius:12px;background:rgba(255,255,255,.10);color:#fff;border:1px solid rgba(255,255,255,.14);font-weight:1000}
.modalBody{padding:14px 16px 18px;display:grid;gap:10px;font-size:13px;color:rgba(255,255,255,.82)}.modalRow{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:10px 12px;border-radius:14px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.08)}.modalRow b{color:#fff4cb}.modalTable{width:100%;border-collapse:collapse;font-size:12px}.modalTable th,.modalTable td{padding:8px;border-bottom:1px solid rgba(255,255,255,.08);text-align:left}.modalTable th{color:#fff4cb;font-size:10px;text-transform:uppercase;letter-spacing:.1em}.activeList{display:flex;flex-wrap:wrap;gap:6px;padding:4px 0 2px}.activeTag{display:inline-flex;align-items:center;max-width:100%;padding:6px 9px;border-radius:999px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);color:#fff6cf;font-size:11px;font-weight:800;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.emptyMsg{text-align:center;color:rgba(255,255,255,.58);padding:18px 8px}
/* premium full-wheel skin */
#wheelZone{--wheel-zone-w:min(96vw,398px);--wheel-shell-w:min(92vw,366px);--wheel-shell-h:min(92vw,366px);--wheel-window-w:min(82vw,310px);--wheel-window-h:min(82vw,310px);--wheel-face-size:min(78vw,292px);top:82px;height:360px;filter:drop-shadow(0 28px 38px rgba(0,0,0,.34)) drop-shadow(0 0 24px rgba(255,211,94,.14))}
#wheelBackdrop{display:none}
#wheelShell{height:var(--wheel-shell-h);border-radius:50%;background:radial-gradient(circle at 50% 50%,rgba(255,248,204,.24),transparent 35%),conic-gradient(from -12deg,#ffeaa0,#b66a13,#fff4bd,#7d38df,#40cde0,#ffeaa0);box-shadow:inset 0 0 0 3px rgba(255,246,203,.60),inset 0 0 0 12px rgba(75,31,102,.92),0 22px 38px rgba(0,0,0,.36),0 0 28px rgba(255,213,104,.20);padding:17px}
#wheelShell:before{content:"";position:absolute;inset:18px;border-radius:50%;border:1px solid rgba(255,255,255,.20);box-shadow:inset 0 0 24px rgba(0,0,0,.28),0 0 20px rgba(255,225,125,.16);pointer-events:none;z-index:2}
#wheelTitle{top:-16px;height:42px;width:178px;font-size:20px;border-radius:999px;box-shadow:0 13px 20px rgba(0,0,0,.34),inset 0 1px 0 rgba(255,255,255,.26)}
#wheelTitle:before,#wheelTitle:after{display:none}
#wheelAura{top:22px;width:322px;height:322px;border-radius:50%;opacity:.72}
#wheelRays{top:28px;width:304px;height:304px;border-radius:50%;opacity:.62;-webkit-mask:radial-gradient(circle,transparent 0 40%,#000 58%,transparent 73%);mask:radial-gradient(circle,transparent 0 40%,#000 58%,transparent 73%)}
#wheelGlow{top:38px;width:286px;height:286px;border-radius:50%;opacity:.78}
#wheelWindow{top:36px;width:var(--wheel-window-w);height:var(--wheel-window-h);border-radius:50%;background:radial-gradient(circle at 50% 50%,rgba(11,13,28,.35),rgba(8,7,22,.80));box-shadow:inset 0 0 0 2px rgba(255,245,198,.42),inset 0 0 42px rgba(0,0,0,.42)}
#wheelScan{top:0;width:100%;height:100%;border-radius:50%}
#wheelHaloRing{top:9px;width:calc(100% - 18px);height:calc(100% - 18px);border-radius:50%}
#wheelRotator{top:9px}
#wheelFace{background:radial-gradient(circle at 50% 50%,rgba(255,246,199,.88) 0 13%,rgba(95,35,142,.94) 14% 22%,transparent 23%),conic-gradient(from -30deg,#c73344 0 60deg,#f2b33f 60deg 120deg,#3cb965 120deg 180deg,#c73344 180deg 240deg,#f2b33f 240deg 300deg,#3cb965 300deg 360deg);box-shadow:inset 0 0 0 5px rgba(255,238,174,.74),inset 0 0 0 12px rgba(83,39,113,.82),0 10px 24px rgba(0,0,0,.30)}
#wheelFace:before{inset:0;background:repeating-conic-gradient(from 0deg,rgba(255,255,255,.24) 0deg 2deg,transparent 2deg 60deg),radial-gradient(circle at 36% 24%,rgba(255,255,255,.20),transparent 19%),radial-gradient(circle at 50% 50%,transparent 0 52px,rgba(255,244,196,.20) 53px 61px,transparent 62px);box-shadow:none}
.sectorLine{display:none}
.wheelFruit{width:64px;height:64px;margin-left:-32px;margin-top:-32px;font-size:36px;background:radial-gradient(circle at 35% 26%,rgba(255,255,255,.86),rgba(255,255,255,.20) 38%,rgba(0,0,0,.10) 100%);box-shadow:inset 0 0 0 2px rgba(255,245,196,.62),0 8px 14px rgba(0,0,0,.28)}
.wheelFruit.wf0{transform:rotate(0deg) translateY(-100px) rotate(0deg)}.wheelFruit.wf1{transform:rotate(60deg) translateY(-100px) rotate(-60deg)}.wheelFruit.wf2{transform:rotate(120deg) translateY(-100px) rotate(-120deg)}.wheelFruit.wf3{transform:rotate(180deg) translateY(-100px) rotate(-180deg)}.wheelFruit.wf4{transform:rotate(240deg) translateY(-100px) rotate(-240deg)}.wheelFruit.wf5{transform:rotate(300deg) translateY(-100px) rotate(-300deg)}
#wheelCenter{width:90px;height:90px;margin-left:-45px;margin-top:-45px;background:conic-gradient(from 20deg,#fff5bf,#c6760b,#fff4b2,#7b39dc,#fff5bf);box-shadow:0 0 0 5px rgba(255,244,190,.88),0 0 0 13px rgba(62,25,100,.90),0 14px 20px rgba(0,0,0,.34)}
#wheelCenter:after{content:"◆";font-size:30px;color:#fff2a8}
#pointerFlash{top:25px;width:52px;height:72px;clip-path:polygon(50% 100%,6% 28%,32% 28%,50% 0,68% 28%,94% 28%);background:linear-gradient(180deg,#fff9c8,#ffd15c 48%,#a85008);box-shadow:0 8px 16px rgba(0,0,0,.35),0 0 16px rgba(255,225,116,.45);opacity:1;z-index:18}
  #timer{top:466px}
  #statusBar{top:544px}
  #winnerBanner{top:522px}
  #board{top:470px}
@media(max-height:720px){#wheelZone{top:98px;transform:translateX(-50%) scale(.88);transform-origin:top center}#timer{top:220px}#statusBar{top:270px}#winnerBanner{top:248px}#board{bottom:86px;top:auto}.betBox{height:142px}.combo{top:38px}.fruitBadge{width:46px;height:46px;font-size:26px}#bottomBar{bottom:max(env(safe-area-inset-bottom),8px);grid-template-columns:82px minmax(0,1fr);padding:7px}#balancePill{width:82px;height:44px}#balanceValue{font-size:12px}#chipDock{height:44px}.chipBtn{height:42px;font-size:9px}}
@media(max-width:360px){.menuBtn{font-size:16px}.latencyPill,.roundPill{font-size:10px}#board{column-gap:6px}.potText{font-size:11px}.youText{font-size:14px}.multText{font-size:14px}.chipBtn{font-size:10px}#bottomBar{grid-template-columns:78px minmax(0,1fr);gap:5px;padding:8px}#balancePill{width:78px;padding:0 5px}#balanceValue{font-size:12px}}
/* 77-style full wheel final override */
#wheelZone{--fl-wheel-size:min(72vw,318px);--fl-orbit:calc(var(--fl-wheel-size) * -.34);top:86px;width:100%;height:calc(var(--fl-wheel-size) + 58px);transform:translateX(-50%);align-items:flex-start;filter:drop-shadow(0 28px 36px rgba(0,0,0,.42)) drop-shadow(0 0 22px rgba(255,194,76,.14))}
#wheelBackdrop{display:none}
#wheelShell{position:relative;top:0;width:var(--fl-wheel-size);height:var(--fl-wheel-size);padding:0;border-radius:50%;background:none;box-shadow:none;overflow:visible}
#wheelShell:before,#wheelShell:after{display:none}
#wheelTitle{top:-17px;width:166px;height:34px;font-size:16px;border-radius:999px;z-index:22;background:linear-gradient(180deg,#fff7c8,#e49d22 58%,#7d3206);box-shadow:0 12px 16px rgba(0,0,0,.36),inset 0 1px 0 rgba(255,255,255,.48)}
#wheelAura{top:2px;width:var(--fl-wheel-size);height:var(--fl-wheel-size);border-radius:50%;opacity:.72}
#wheelRays{top:8px;width:calc(var(--fl-wheel-size) - 16px);height:calc(var(--fl-wheel-size) - 16px);border-radius:50%;opacity:.54}
#wheelGlow{top:20px;width:calc(var(--fl-wheel-size) - 40px);height:calc(var(--fl-wheel-size) - 40px);border-radius:50%}
#wheelWindow{left:50%;top:0;width:100%;height:100%;border-radius:50%;overflow:visible;background:transparent;box-shadow:none}
#wheelScan,#wheelHaloRing{display:none}
#wheelRotator{left:50%;top:0;width:100%;height:100%;transform:translateX(-50%) rotate(0deg);transform-origin:50% 50%;will-change:transform}
#wheelFace{inset:0;border-radius:50%;overflow:hidden;background:radial-gradient(circle at 50% 50%,#fff7c7 0 12%,#55248d 13% 20%,transparent 21%),conic-gradient(from -30deg,#be2638 0 60deg,#ffc549 60deg 120deg,#22a75f 120deg 180deg,#be2638 180deg 240deg,#ffc549 240deg 300deg,#22a75f 300deg 360deg);box-shadow:inset 0 0 0 5px rgba(255,238,174,.92),inset 0 0 0 14px rgba(74,35,103,.88),inset 0 0 0 23px rgba(255,212,87,.82),0 18px 30px rgba(0,0,0,.36)}
#wheelFace:before{content:"";position:absolute;inset:0;border-radius:50%;background:repeating-conic-gradient(from 0deg,rgba(255,255,255,.30) 0deg 2deg,transparent 2deg 60deg),radial-gradient(circle at 34% 22%,rgba(255,255,255,.28),transparent 18%),radial-gradient(circle at 50% 118%,rgba(0,0,0,.26),transparent 38%);box-shadow:none;pointer-events:none}
#wheelFace:after{content:"";position:absolute;inset:18px;border-radius:50%;border:1px solid rgba(255,255,255,.18);box-shadow:inset 0 0 24px rgba(0,0,0,.28);background:transparent;pointer-events:none}
.sectorLine{display:none}
.wheelFruit{width:clamp(44px,13vw,58px);height:clamp(44px,13vw,58px);margin-left:calc(clamp(44px,13vw,58px) / -2);margin-top:calc(clamp(44px,13vw,58px) / -2);font-size:clamp(26px,8vw,36px);background:radial-gradient(circle at 35% 24%,rgba(255,255,255,.9),rgba(255,255,255,.22) 38%,rgba(0,0,0,.10));box-shadow:inset 0 0 0 2px rgba(255,245,196,.68),0 8px 14px rgba(0,0,0,.30);z-index:5}
.wheelFruit.wf0{transform:rotate(0deg) translateY(var(--fl-orbit)) rotate(0deg)}.wheelFruit.wf1{transform:rotate(60deg) translateY(var(--fl-orbit)) rotate(-60deg)}.wheelFruit.wf2{transform:rotate(120deg) translateY(var(--fl-orbit)) rotate(-120deg)}.wheelFruit.wf3{transform:rotate(180deg) translateY(var(--fl-orbit)) rotate(-180deg)}.wheelFruit.wf4{transform:rotate(240deg) translateY(var(--fl-orbit)) rotate(-240deg)}.wheelFruit.wf5{transform:rotate(300deg) translateY(var(--fl-orbit)) rotate(-300deg)}
#wheelCenter{width:calc(var(--fl-wheel-size) * .27);height:calc(var(--fl-wheel-size) * .27);margin-left:calc(var(--fl-wheel-size) * -.135);margin-top:calc(var(--fl-wheel-size) * -.135);background:conic-gradient(from 20deg,#fff6bf,#c6760b,#fff4b2,#7b39dc,#fff5bf);box-shadow:0 0 0 5px rgba(255,244,190,.88),0 0 0 13px rgba(62,25,100,.90),0 14px 20px rgba(0,0,0,.34);z-index:8}
#wheelCenter:after{content:"FL";font-size:clamp(17px,5vw,24px);color:#fff2a8;text-shadow:0 2px 6px rgba(0,0,0,.34)}
#pointer{left:50%;top:-8px;width:clamp(50px,14vw,72px);height:clamp(62px,17vw,88px);transform:translateX(-50%);z-index:28;pointer-events:none}
#pointerGem{left:50%;top:0;width:52%;height:52%;transform:translateX(-50%) rotate(45deg);border-radius:10px;background:linear-gradient(135deg,#fff8c6,#f5ae28 52%,#8a2d07);box-shadow:0 0 0 3px rgba(255,244,176,.72),0 0 16px rgba(255,222,96,.66)}
#pointerArrow{left:50%;top:30%;width:48%;height:64%;transform:translateX(-50%);clip-path:polygon(50% 100%,8% 8%,32% 8%,50% 0,68% 8%,92% 8%);background:linear-gradient(180deg,#fff6c1,#ffc854 46%,#a84f07);box-shadow:0 9px 15px rgba(0,0,0,.38)}
#pointerFlash{left:50%;top:30%;width:48%;height:64%;transform:translateX(-50%);clip-path:polygon(50% 100%,8% 8%,32% 8%,50% 0,68% 8%,92% 8%);background:linear-gradient(180deg,rgba(255,255,255,.95),rgba(255,219,91,.28));opacity:0;box-shadow:0 0 18px rgba(255,234,139,.78)}
#pointer.spinning{animation:pointerTick .38s ease-in-out infinite}
#timer{top:calc(86px + min(72vw,318px) + 8px)}
#statusBar{top:calc(86px + min(72vw,318px) + 60px)}
#winnerBanner{top:calc(86px + min(72vw,318px) + 42px)}
#board{top:auto;bottom:96px}
@media(max-height:720px){#wheelZone{--fl-wheel-size:min(66vw,276px);top:80px;height:calc(var(--fl-wheel-size) + 52px);transform:translateX(-50%)}#timer{top:calc(80px + min(66vw,276px) + 6px)}#statusBar{top:calc(80px + min(66vw,276px) + 52px)}#winnerBanner{top:calc(80px + min(66vw,276px) + 36px)}#board{top:auto;bottom:86px}.betBox{height:142px}.combo{top:38px}.fruitBadge{width:46px;height:46px;font-size:26px}}
@media(min-height:820px){#wheelZone{--fl-wheel-size:min(78vw,342px);top:92px}#timer{top:calc(92px + min(78vw,342px) + 10px)}#statusBar{top:calc(92px + min(78vw,342px) + 64px)}#winnerBanner{top:calc(92px + min(78vw,342px) + 46px)}}
/* Fruits Loop polish pass: cleaner wheel and real value chips */
#wheelZone{--fl-wheel-size:min(70vw,304px);--fl-orbit:calc(var(--fl-wheel-size) * -.33);top:122px;height:calc(var(--fl-wheel-size) + 50px);filter:drop-shadow(0 20px 28px rgba(0,0,0,.36)) drop-shadow(0 0 14px rgba(255,203,88,.10))}
#wheelTitle{display:none}
#wheelAura{top:8px;opacity:.34;filter:blur(16px) saturate(115%)}
#wheelRays,#wheelScan,#wheelHaloRing{display:none}
#wheelGlow{top:22px;opacity:.34;filter:blur(9px) saturate(115%)}
#wheelFace{background:radial-gradient(circle at 50% 50%,#fff7ce 0 11%,#6e3eb5 12% 18%,transparent 19%),conic-gradient(from -30deg,#d93f4a 0 60deg,#ffc957 60deg 120deg,#3fc66f 120deg 180deg,#d93f4a 180deg 240deg,#ffc957 240deg 300deg,#3fc66f 300deg 360deg);box-shadow:inset 0 0 0 4px rgba(255,242,183,.90),inset 0 0 0 12px rgba(78,43,113,.82),inset 0 0 0 18px rgba(255,211,86,.82),0 14px 24px rgba(0,0,0,.32)}
#wheelFace:before{background:repeating-conic-gradient(from 0deg,rgba(255,255,255,.22) 0deg 1deg,transparent 1deg 60deg),radial-gradient(circle at 34% 22%,rgba(255,255,255,.22),transparent 17%),radial-gradient(circle at 50% 116%,rgba(0,0,0,.18),transparent 36%)}
#wheelFace:after{inset:15px;box-shadow:inset 0 0 18px rgba(0,0,0,.22)}
.wheelFruit{width:clamp(40px,11vw,52px);height:clamp(40px,11vw,52px);margin-left:calc(clamp(40px,11vw,52px) / -2);margin-top:calc(clamp(40px,11vw,52px) / -2);font-size:clamp(24px,7vw,32px);box-shadow:inset 0 0 0 2px rgba(255,244,196,.60),0 7px 11px rgba(0,0,0,.22)}
#wheelCenter{width:calc(var(--fl-wheel-size) * .24);height:calc(var(--fl-wheel-size) * .24);margin-left:calc(var(--fl-wheel-size) * -.12);margin-top:calc(var(--fl-wheel-size) * -.12);box-shadow:0 0 0 4px rgba(255,244,190,.82),0 0 0 10px rgba(67,31,104,.86),0 10px 16px rgba(0,0,0,.30)}
#pointer{top:-6px;width:clamp(44px,12vw,62px);height:clamp(56px,15vw,76px)}
#pointerGem{box-shadow:0 0 0 2px rgba(255,244,176,.70),0 0 13px rgba(255,222,96,.52)}
#pointerArrow{top:31%;width:44%;height:62%;box-shadow:0 7px 12px rgba(0,0,0,.32)}
#timer{top:calc(122px + min(70vw,304px) + 8px)}
#statusBar{top:calc(122px + min(70vw,304px) + 56px)}
#winnerBanner{top:calc(122px + min(70vw,304px) + 38px)}
#board{bottom:92px}
#chipDock{gap:10px}
.chipBtn{background-position:center!important;background-size:cover!important;background-repeat:no-repeat!important;color:transparent!important;font-size:0!important}
.chipBtn.chip1k{background-image:url('{{ asset('game_final_assets/lucky7_pro/custom/chip_1k.webp') }}')!important}
.chipBtn.chip10k{background-image:url('{{ asset('game_final_assets/lucky7_pro/custom/chip_10k.webp') }}')!important}
.chipBtn.chip50k{background-image:url('{{ asset('game_final_assets/lucky7_pro/custom/chip_50k.webp') }}')!important}
.chipBtn.chip100k{background-image:url('{{ asset('game_final_assets/lucky7_pro/custom/chip_100k.webp') }}')!important}
@media(max-height:720px){#wheelZone{--fl-wheel-size:min(62vw,250px);top:112px;height:calc(var(--fl-wheel-size) + 44px)}#timer{top:calc(112px + min(62vw,250px) + 5px)}#statusBar{top:calc(112px + min(62vw,250px) + 48px)}#winnerBanner{top:calc(112px + min(62vw,250px) + 32px)}#board{bottom:84px}}
@media(min-height:820px){#wheelZone{--fl-wheel-size:min(72vw,314px);top:122px}#timer{top:calc(122px + min(72vw,314px) + 8px)}#statusBar{top:calc(122px + min(72vw,314px) + 58px)}#winnerBanner{top:calc(122px + min(72vw,314px) + 40px)}}
/* Final mobile polish after theme includes: keep chips circular and result text off the timer. */
#winnerBanner{top:calc(122px + min(70vw,304px) + 76px)}
#statusBar{top:calc(122px + min(70vw,304px) + 76px)}
#chipDock{height:60px;align-items:center;gap:8px}
.chipBtn{width:56px!important;height:56px!important;flex:0 0 56px!important;border-radius:50%!important;line-height:0!important;text-indent:-999px!important;overflow:hidden!important;text-shadow:none!important;-webkit-text-fill-color:transparent!important}
.chipBtn:before{inset:4px}
#pointer{width:54px;height:72px}
#pointerGem{left:50%;top:0;width:36px;height:36px;border-radius:50%;transform:translateX(-50%);background:radial-gradient(circle at 34% 28%,#fff8c7,#ffc64f 52%,#a64d07 100%);box-shadow:0 0 0 3px rgba(255,238,169,.80),0 7px 13px rgba(0,0,0,.34),0 0 14px rgba(255,219,101,.48)}
#pointerArrow{left:50%;top:27px;width:28px;height:36px;transform:translateX(-50%);clip-path:polygon(50% 100%,0 0,100% 0);background:linear-gradient(180deg,#ffcf57,#ff4cc8 62%,#b80082);box-shadow:0 7px 11px rgba(0,0,0,.32)}
#pointerFlash{left:50%;top:26px;width:32px;height:38px;transform:translateX(-50%);clip-path:polygon(50% 100%,0 0,100% 0)}
#wheelShell{left:auto!important;transform:none!important;margin:0 auto!important}
@media(max-width:380px){.chipBtn{width:50px!important;height:50px!important;flex-basis:50px!important}#chipDock{gap:6px}}
@media(max-height:720px){#winnerBanner{top:calc(112px + min(62vw,250px) + 64px)}#statusBar{top:calc(112px + min(62vw,250px) + 64px)}#chipDock{height:52px}.chipBtn{width:48px!important;height:48px!important;flex-basis:48px!important}}
@media(min-height:820px){#winnerBanner{top:calc(122px + min(72vw,314px) + 76px)}#statusBar{top:calc(122px + min(72vw,314px) + 76px)}}
@media(max-height:720px){#winnerHistory{bottom:322px;height:34px;padding:4px 7px}.winnerDot{width:21px;height:21px;flex-basis:21px;font-size:14px}#winnerHistory .historyTitle{font-size:8px}}
.potValue,.youValue,#balanceValue{display:inline-block;max-width:none;overflow:visible;text-overflow:clip;white-space:nowrap;transform-origin:left center;font-variant-numeric:tabular-nums}
#balanceValue{overflow:visible!important;text-overflow:clip!important}
.potText,.youText{white-space:nowrap;overflow:visible;text-overflow:clip}
.activeTag{overflow:visible;text-overflow:clip}
.payoutFlyAmount{position:absolute;z-index:75;pointer-events:none;padding:5px 11px;border-radius:999px;background:linear-gradient(180deg,#fff8c8,#ffcd57 54%,#b96409);border:2px solid rgba(99,47,0,.75);color:#401600;font-size:17px;font-weight:1000;text-shadow:0 1px 0 rgba(255,255,255,.48);box-shadow:0 12px 20px rgba(0,0,0,.34),0 0 18px rgba(255,216,101,.32);white-space:nowrap;transform:translate(-50%,-50%)}
.payoutFlyAmount.totalFly{background:linear-gradient(180deg,#dffeff,#78e7ff 52%,#207ba0);border-color:rgba(187,249,255,.72);color:#04232d}
.payoutChipGhost{position:absolute;width:34px;height:34px;border-radius:50%;z-index:74;pointer-events:none;background-position:center!important;background-size:contain!important;background-repeat:no-repeat!important;filter:drop-shadow(0 10px 12px rgba(0,0,0,.32))}
.payoutChipGhost.chip1k{background-image:url('{{ asset('game_final_assets/lucky7_pro/custom/chip_1k.webp') }}')!important}.payoutChipGhost.chip10k{background-image:url('{{ asset('game_final_assets/lucky7_pro/custom/chip_10k.webp') }}')!important}.payoutChipGhost.chip50k{background-image:url('{{ asset('game_final_assets/lucky7_pro/custom/chip_50k.webp') }}')!important}.payoutChipGhost.chip100k{background-image:url('{{ asset('game_final_assets/lucky7_pro/custom/chip_100k.webp') }}')!important}
#balancePill.balanceImpact{animation:balanceImpact .54s cubic-bezier(.2,.9,.2,1)}
@keyframes balanceImpact{0%,100%{transform:translateX(0);box-shadow:0 18px 28px rgba(0,0,0,.3),inset 0 1px 0 rgba(255,255,255,.2)}25%{transform:translateX(3px);box-shadow:0 18px 28px rgba(0,0,0,.3),0 0 24px rgba(91,255,152,.44),inset 0 1px 0 rgba(255,255,255,.2)}52%{transform:translateX(-2px);box-shadow:0 18px 28px rgba(0,0,0,.3),0 0 15px rgba(91,255,152,.26),inset 0 1px 0 rgba(255,255,255,.2)}}
#wheelTitle{display:flex!important;left:50%!important;top:auto!important;bottom:-14px!important;transform:translateX(-50%)!important;width:min(72%,242px)!important;height:58px!important;border-radius:999px!important;border:3px solid rgba(255,196,73,.95)!important;background:linear-gradient(180deg,#c938f4,#8f20c7 56%,#5c118d)!important;color:#ffe27d!important;font-size:27px!important;font-weight:1000!important;letter-spacing:.02em!important;box-shadow:0 12px 22px rgba(0,0,0,.38),0 0 22px rgba(255,205,99,.22),inset 0 2px 0 rgba(255,255,255,.26)!important;text-shadow:0 3px 0 rgba(93,40,0,.42)!important;z-index:24!important}
#wheelTitle:before,#wheelTitle:after{top:18px!important}
#timer{top:calc(122px + min(70vw,304px) + 72px)!important;width:124px!important;height:124px!important;border:none!important;border-radius:0!important;background:url('{{ $timerStopwatchAsset }}') center/contain no-repeat!important;box-shadow:none!important;color:#ffefbe!important;z-index:26!important}
#timerPulse{display:none!important}
#countNum{position:absolute!important;left:50%!important;top:56%!important;transform:translate(-50%,-50%)!important;display:flex!important;align-items:center!important;justify-content:center!important;min-width:58px!important;height:58px!important;font-size:38px!important;font-weight:1000!important;color:#ffe69c!important;text-shadow:0 2px 0 rgba(98,28,0,.70),0 0 18px rgba(255,229,153,.22)!important;font-variant-numeric:tabular-nums!important}
#statusBar{top:calc(122px + min(70vw,304px) + 98px)!important;z-index:18!important}
#winnerBanner{top:calc(122px + min(70vw,304px) + 68px)!important}
#chipDock{height:64px!important;align-items:center!important;gap:8px!important;overflow:visible!important;justify-content:flex-start!important}
#winnerHistory{position:relative!important;left:auto!important;bottom:auto!important;transform:none!important;width:auto!important;max-width:none!important;height:auto!important;flex:1 1 0!important;min-width:0!important;display:flex!important;align-items:center!important;gap:6px!important;padding:5px 8px!important;margin:0 2px 0 4px!important;background:linear-gradient(180deg,rgba(255,255,255,.14),rgba(255,255,255,.06)),rgba(14,18,42,.58)!important;border:1px solid rgba(255,231,154,.24)!important;box-shadow:0 8px 18px rgba(0,0,0,.22),inset 0 1px 0 rgba(255,255,255,.16)!important;backdrop-filter:blur(8px) saturate(125%)!important}
#winnerHistory .historyTitle{font-size:8px!important;letter-spacing:.08em!important;white-space:nowrap!important}
#winnerHistoryList{flex:1 1 auto!important;min-width:0!important;gap:4px!important}
#winnerHistory .winnerDot{width:22px!important;height:22px!important;flex:0 0 22px!important;font-size:14px!important}
#winnerHistory .winnerDot.empty{font-size:11px!important}
.controlChipBtn{position:relative;flex:0 0 58px;width:58px;height:58px;border-radius:18px;display:grid;place-items:center;background:linear-gradient(180deg,rgba(255,255,255,.24),rgba(255,255,255,.05)),linear-gradient(180deg,#7427c7,#3a145f)!important;border:2px solid rgba(255,210,94,.82);box-shadow:0 14px 24px rgba(0,0,0,.30),inset 0 1px 0 rgba(255,255,255,.24);cursor:pointer;transition:transform .16s ease,box-shadow .16s ease}
.controlChipBtn:hover,.controlChipBtn:focus-visible{transform:translateY(-4px);box-shadow:0 18px 28px rgba(0,0,0,.34),0 0 16px rgba(255,220,120,.20),inset 0 1px 0 rgba(255,255,255,.28);outline:none}
.controlChipBtn:before{content:"";position:absolute;inset:5px;border-radius:14px;border:1px solid rgba(255,255,255,.12)}
.trendBars{display:flex;align-items:flex-end;gap:4px;height:24px}
.trendBars i{display:block;width:8px;border-radius:999px 999px 3px 3px;background:linear-gradient(180deg,#ffe680,#ffa021 62%,#ff4acc);box-shadow:0 0 10px rgba(255,208,112,.20)}
.trendBars i:nth-child(1){height:11px}
@media(max-width:430px){#winnerHistory{padding:4px 6px!important;gap:4px!important}#winnerHistory .historyTitle{display:none!important}#winnerHistory .winnerDot{width:20px!important;height:20px!important;flex-basis:20px!important;font-size:12px!important}}
.trendBars i:nth-child(2){height:18px}
.trendBars i:nth-child(3){height:24px}
.appModal{align-items:center!important}
.modalCard[data-panel="players"],.modalCard[data-panel="settings"],.modalCard[data-panel="trend"]{width:min(92vw,456px)!important;max-width:456px!important;min-height:654px!important;max-height:none!important;border:none!important;border-radius:0!important;box-shadow:0 22px 48px rgba(0,0,0,.50)!important;overflow:visible!important;background-color:transparent!important;background-position:center!important;background-size:100% 100%!important;background-repeat:no-repeat!important}
.modalCard[data-panel="players"]{background-image:url('{{ $panelPlayerAsset }}')!important}
.modalCard[data-panel="settings"]{background-image:url('{{ $panelSettingsAsset }}')!important}
.modalCard[data-panel="trend"]{background-image:url('{{ $panelTrendAsset }}')!important}
.modalCard[data-panel="players"] .modalHead,.modalCard[data-panel="settings"] .modalHead,.modalCard[data-panel="trend"] .modalHead{position:static!important;padding:0!important;border:none!important;background:none!important;height:0!important;min-height:0!important;overflow:visible!important}
.modalCard[data-panel="players"] #modalTitle,.modalCard[data-panel="settings"] #modalTitle,.modalCard[data-panel="trend"] #modalTitle{opacity:0!important;pointer-events:none!important}
.modalCard[data-panel="players"] .modalBody,.modalCard[data-panel="settings"] .modalBody,.modalCard[data-panel="trend"] .modalBody{position:absolute!important;left:18px!important;right:18px!important;top:110px!important;bottom:66px!important;padding:0!important;max-height:none!important;overflow:hidden!important;background:none!important}
.modalCard[data-panel="players"] .modalClose,.modalCard[data-panel="settings"] .modalClose,.modalCard[data-panel="trend"] .modalClose{position:absolute!important;left:50%!important;bottom:18px!important;transform:translateX(-50%)!important;width:72px!important;height:72px!important;border:none!important;border-radius:50%!important;background:transparent!important;color:transparent!important;box-shadow:none!important;z-index:5!important}
.panelCanvas{position:relative;width:100%;height:100%;min-height:0;padding:16px;border-radius:24px;background:linear-gradient(180deg,rgba(18,10,48,.96),rgba(7,5,22,.985));border:1px solid rgba(255,255,255,.08);box-shadow:inset 0 1px 0 rgba(255,255,255,.10),0 18px 28px rgba(0,0,0,.20);backdrop-filter:blur(6px);overflow:hidden}
.panelCanvas.settings{background:linear-gradient(180deg,rgba(19,11,50,.88),rgba(8,5,24,.94))}
.playerGrid{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:6px;height:100%;align-content:start;overflow:auto;padding-right:2px}
.playerCard{display:grid;grid-template-columns:1fr;justify-items:center;align-content:start;gap:5px;min-width:0;padding:8px 4px;border-radius:12px;background:linear-gradient(180deg,rgba(151,55,233,.28),rgba(103,26,169,.18));border:1px solid rgba(224,110,255,.28);box-shadow:inset 0 1px 0 rgba(255,255,255,.10);text-align:center}
.playerAvatarShell{width:38px;height:38px;border-radius:13px;padding:2px;background:linear-gradient(180deg,#f6cc5a,#b95a0d);box-shadow:0 8px 14px rgba(0,0,0,.22)}
.playerAvatar{width:100%;height:100%;border-radius:10px;object-fit:cover;display:block;background:radial-gradient(circle at 34% 28%,#7e32ef,#3d1270)}
.playerAvatar.fallback{display:grid;place-items:center;color:#fff2b2;font-size:24px;font-weight:1000;text-shadow:0 2px 0 rgba(0,0,0,.28)}
.playerMeta{min-width:0}
.playerName{font-size:9px;font-weight:900;color:#f7e6ff;line-height:1.15;text-shadow:0 2px 0 rgba(0,0,0,.32);max-width:100%;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.playerSub{margin-top:5px;font-size:11px;letter-spacing:.08em;text-transform:uppercase;color:#dba4ff}
.playerEmpty,.trendEmpty{display:grid;place-items:center;min-height:220px;font-size:18px;font-weight:800;color:#f8eac0;text-align:center}
.settingsPanel{display:grid;gap:34px;padding:20px 8px 12px;align-content:start}
.settingsGhostTitle{display:none}
.settingRow{display:grid;grid-template-columns:92px minmax(0,1fr) 48px;align-items:center;gap:12px}
.settingLabel{font-size:21px;font-weight:900;color:#f9efb1;line-height:1.05;text-shadow:0 2px 0 rgba(0,0,0,.28)}
.settingValue{font-size:16px;font-weight:900;color:#ffd771;text-align:right}
.themeRange{appearance:none;-webkit-appearance:none;width:100%;height:14px;border-radius:999px;background:linear-gradient(90deg,#d42fff 0%,#ff5176 45%,#ff8e26 78%,#ffd650 100%);box-shadow:0 0 0 2px rgba(96,17,148,.52),inset 0 2px 4px rgba(255,255,255,.14)}
.themeRange::-webkit-slider-thumb{-webkit-appearance:none;appearance:none;width:28px;height:28px;border-radius:50%;background:radial-gradient(circle at 34% 28%,#fff8b9,#ffd04d 48%,#b35b07 100%);border:2px solid rgba(120,44,0,.75);box-shadow:0 6px 14px rgba(0,0,0,.30)}
.themeRange::-moz-range-thumb{width:28px;height:28px;border:none;border-radius:50%;background:radial-gradient(circle at 34% 28%,#fff8b9,#ffd04d 48%,#b35b07 100%);box-shadow:0 6px 14px rgba(0,0,0,.30)}
.settingToggleRow{display:flex;align-items:center;justify-content:space-between;padding:2px 8px 0}
.soundStateBtn{min-width:88px;height:38px;border-radius:999px;border:2px solid rgba(255,211,94,.82);background:linear-gradient(180deg,#bb30e4,#68179b);color:#ffea9a;font-weight:1000;box-shadow:0 10px 18px rgba(0,0,0,.22)}
.soundStateBtn.off{filter:saturate(.55);opacity:.72}
.trendPanel{position:relative;display:grid;gap:10px;padding:6px 2px 0;height:100%;align-content:start;overflow:auto}
.trendNew{position:absolute;right:4px;top:-12px;font-size:14px;font-weight:1000;color:#ffe04d;letter-spacing:.06em}
.trendRow{display:grid;grid-template-columns:58px minmax(0,1fr) 34px;align-items:center;gap:8px;min-height:34px;padding:4px 8px;border-radius:10px;background:linear-gradient(180deg,rgba(117,51,185,.42),rgba(84,34,146,.28));border:1px solid rgba(193,123,255,.18)}
.trendLead{font-size:15px;font-weight:1000;color:#ffef88;text-shadow:0 0 8px rgba(255,120,120,.42),0 2px 0 rgba(69,0,0,.28)}
.trendSlots{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:10px}
.trendMark,.trendDash{font-size:13px;font-weight:900;text-align:center}
.trendMark{color:#ffe67f;text-shadow:0 0 10px rgba(255,91,91,.36),0 2px 0 rgba(93,18,0,.26)}
.trendDash{color:rgba(255,245,208,.72)}
.trendIcon{width:30px;height:30px;border-radius:50%;display:grid;place-items:center;font-size:18px;background:radial-gradient(circle at 34% 28%,rgba(255,255,255,.96),rgba(255,255,255,.20) 40%,transparent 60%),radial-gradient(circle at 30% 28%,#fff8d9,#f2d27d 62%,#bb770d);border:1px solid rgba(255,240,179,.62);box-shadow:0 5px 10px rgba(0,0,0,.20)}
.trendBoardTable{grid-template-columns:1fr;gap:8px;padding-top:18px}
.trendBoardHead,.trendBoardRow{display:grid;grid-template-columns:repeat(var(--trend-board-count,3),minmax(0,1fr));gap:6px}
.trendBoardHead{position:sticky;top:0;z-index:2;padding:0 1px 2px;background:linear-gradient(180deg,rgba(18,10,48,.96),rgba(18,10,48,.72))}
.trendBoardLabel{min-height:26px;display:grid;place-items:center;padding:3px 4px;border-radius:9px;background:linear-gradient(180deg,rgba(255,224,114,.18),rgba(255,255,255,.05));border:1px solid rgba(255,224,114,.24);color:#ffedac;font-size:10px;font-weight:1000;line-height:1.05;text-align:center;overflow:hidden;overflow-wrap:anywhere}
.trendBoardCell{min-height:36px;display:grid;place-items:center;border-radius:10px;background:linear-gradient(180deg,rgba(117,51,185,.28),rgba(84,34,146,.16));border:1px solid rgba(193,123,255,.16);box-shadow:inset 0 1px 0 rgba(255,255,255,.07)}
.trendBoardCell.has-token{background:radial-gradient(circle at 50% 42%,rgba(255,224,108,.24),transparent 62%),linear-gradient(180deg,rgba(117,51,185,.48),rgba(84,34,146,.28));border-color:rgba(255,227,126,.52)}
.trendToken{width:30px;height:30px;border-radius:50%;display:grid;place-items:center;font-size:18px;background:radial-gradient(circle at 34% 28%,rgba(255,255,255,.96),rgba(255,255,255,.20) 40%,transparent 60%),radial-gradient(circle at 30% 28%,#fff8d9,#f2d27d 62%,#bb770d);border:1px solid rgba(255,240,179,.62);box-shadow:0 5px 10px rgba(0,0,0,.20)}
@media(max-height:720px){#timer{top:calc(112px + min(62vw,250px) + 54px)!important;width:102px!important;height:102px!important}#countNum{min-width:50px!important;height:50px!important;font-size:31px!important}#statusBar{top:calc(112px + min(62vw,250px) + 82px)!important}#winnerBanner{top:calc(112px + min(62vw,250px) + 58px)!important}#wheelTitle{bottom:-10px!important;width:min(76%,214px)!important;height:52px!important;font-size:23px!important}.controlChipBtn{flex-basis:50px;width:50px;height:50px}.modalCard[data-panel="players"],.modalCard[data-panel="settings"],.modalCard[data-panel="trend"]{width:min(92vw,420px)!important;min-height:602px!important}.modalCard[data-panel="players"] .modalBody,.modalCard[data-panel="settings"] .modalBody,.modalCard[data-panel="trend"] .modalBody{left:16px!important;right:16px!important;top:102px!important;bottom:60px!important}.playerAvatarShell{width:58px;height:58px}.playerCard{grid-template-columns:58px minmax(0,1fr)}.playerName{font-size:18px}.settingLabel{font-size:18px}.trendRow{grid-template-columns:50px minmax(0,1fr) 30px}}</style>
<style id="fruits-loop-trend-matrix-fit">@media(max-height:720px){.trendBoardTable{gap:6px}.trendBoardLabel{min-height:22px;font-size:9px}.trendBoardCell{min-height:32px}.trendToken{width:26px;height:26px;font-size:16px}}</style>
@include('game_final.partials.admin_visual_theme_styles')
<style id="fruits-loop-final-wheel-fix">
#wheelZone{display:grid!important;place-items:start center!important}
#wheelShell{left:auto!important;transform:none!important;margin:0 auto!important;position:relative!important;display:grid!important;place-items:center!important;width:var(--fl-wheel-size)!important;height:var(--fl-wheel-size)!important;padding:0!important;border-radius:50%!important;background:none!important;box-shadow:none!important;overflow:visible!important;contain:none!important;isolation:isolate!important}
#wheelWindow{left:0!important;top:0!important;transform:none!important;width:100%!important;height:100%!important;border-radius:50%!important;overflow:clip!important;background:transparent!important;box-shadow:none!important;clip-path:circle(49.9% at 50% 50%)!important;-webkit-clip-path:circle(49.9% at 50% 50%)!important;-webkit-mask-image:radial-gradient(circle,#000 98.8%,transparent 100%);mask-image:radial-gradient(circle,#000 98.8%,transparent 100%);isolation:isolate!important}
#wheelRotator{inset:0!important;left:0!important;top:0!important;width:100%!important;height:100%!important;transform:translate3d(0,0,0) rotate(0deg);transform-origin:50% 50%!important;transform-style:flat!important;backface-visibility:hidden!important;will-change:transform!important;animation:none!important;pointer-events:none!important}
#wheelFace{inset:0!important;border-radius:50%!important;overflow:hidden!important;background:url('{{ $wheelFaceAsset }}') center/100% 100% no-repeat!important;box-shadow:none!important;transform:translateZ(0)!important;backface-visibility:hidden!important;animation:none!important}
#wheelFace:before,.sectorLine,.wheelFruit,#wheelCenter{display:none!important}
#wheelFace:after{content:none!important;display:none!important}
#wheelAura,#wheelRays,#wheelGlow,#wheelScan,#wheelHaloRing{display:none!important}
#wheelCover{display:none!important}
#wheelCenterLogo{display:block!important;position:absolute!important;left:50%!important;top:50%!important;width:31%!important;height:31%!important;transform:translate(-50%,-50%)!important;object-fit:contain!important;z-index:17!important;pointer-events:none!important;filter:drop-shadow(0 8px 10px rgba(0,0,0,.28))!important}
#pointer{top:-12px!important;width:52px!important;height:86px!important;background:url('{{ $wheelPointerAsset }}') center top/contain no-repeat!important;z-index:30!important;filter:drop-shadow(0 12px 14px rgba(0,0,0,.34)) drop-shadow(0 0 10px rgba(255,214,93,.24))!important}
#pointerGem,#pointerArrow,#pointerFlash{display:none!important}
#pointer.spinning{animation:none!important}
.topRow{height:112px!important;padding:0 10px!important;gap:8px!important;z-index:35!important}
.dockRight{display:grid!important;grid-template-columns:repeat(6,1fr)!important;gap:6px!important;padding:7px!important;border-radius:22px;background:linear-gradient(180deg,rgba(255,255,255,.22),rgba(255,255,255,.07)),rgba(8,12,32,.50);border:1px solid rgba(255,232,156,.34);box-shadow:0 15px 30px rgba(0,0,0,.30),inset 0 1px 0 rgba(255,255,255,.24);backdrop-filter:blur(14px) saturate(138%)}
.menuBtn{position:relative;display:grid!important;grid-template-rows:20px 12px;place-items:center;height:44px!important;border-radius:15px!important;font-size:17px!important;line-height:1!important;overflow:hidden;background:linear-gradient(180deg,rgba(255,255,255,.23),rgba(255,255,255,.06)),linear-gradient(180deg,rgba(58,28,106,.92),rgba(17,16,44,.92))!important;border:1px solid rgba(255,232,156,.46)!important;color:#fff6ce!important;box-shadow:0 9px 17px rgba(0,0,0,.27),inset 0 1px 0 rgba(255,255,255,.28)!important;text-shadow:0 2px 0 rgba(0,0,0,.25);transition:transform .16s ease,box-shadow .16s ease,filter .16s ease}
.menuBtn:before{content:"";position:absolute;inset:0;background:linear-gradient(120deg,transparent 0 26%,rgba(255,255,255,.25) 42%,transparent 58%);transform:translateX(-115%);transition:transform .38s ease;pointer-events:none}
.menuBtn:hover,.menuBtn:focus-visible{transform:translateY(-2px);filter:saturate(1.12);box-shadow:0 12px 20px rgba(0,0,0,.31),0 0 18px rgba(255,218,105,.16),inset 0 1px 0 rgba(255,255,255,.32)!important;outline:0}
.menuBtn:hover:before,.menuBtn:focus-visible:before{transform:translateX(115%)}
.menuBtn .menuIcon{display:grid;place-items:center;width:22px;height:20px;font-size:17px}
.menuBtn .menuText{display:block;font-size:8px;font-weight:1000;letter-spacing:.05em;text-transform:uppercase;color:rgba(255,244,202,.86);white-space:nowrap}
.userMenuBtn .activeCount{right:3px!important;top:3px!important}
.midTop{z-index:2}.latencyPill,.roundPill{background:linear-gradient(180deg,rgba(255,255,255,.18),rgba(255,255,255,.06)),rgba(19,18,46,.60)!important;border-color:rgba(255,232,156,.32)!important;backdrop-filter:blur(10px) saturate(130%)}
.appModal{align-items:center!important;background:radial-gradient(circle at 50% 32%,rgba(255,209,93,.16),transparent 28%),rgba(3,5,14,.72)!important}
.appModal.is-open .modalCard{animation:modalCardPop .26s cubic-bezier(.2,.85,.2,1.08)}
.modalCard{position:relative;max-width:410px!important;border-radius:28px!important;background:linear-gradient(180deg,rgba(255,255,255,.16),rgba(255,255,255,.05)),linear-gradient(180deg,rgba(36,22,80,.98),rgba(7,10,25,.98))!important;border:1px solid rgba(255,231,154,.48)!important;box-shadow:0 30px 70px rgba(0,0,0,.56),0 0 38px rgba(255,198,77,.12),inset 0 1px 0 rgba(255,255,255,.20)!important;overflow:hidden!important}
.modalCard:before{content:"";position:absolute;left:-20%;right:-20%;top:-58px;height:126px;background:radial-gradient(ellipse at 50% 0,rgba(255,244,190,.38),rgba(255,96,197,.12) 42%,transparent 70%);pointer-events:none}
.modalCard:after{content:"";position:absolute;inset:10px;border-radius:22px;border:1px solid rgba(255,255,255,.08);pointer-events:none}
.modalHead{position:relative;padding:17px 18px 13px!important;border-bottom:1px solid rgba(255,255,255,.12)!important}
.modalHead h3{font-size:15px!important;letter-spacing:.10em!important;color:#fff5c8!important}
.modalClose{border-radius:50%!important;background:linear-gradient(180deg,#fff7c3,#eaa22c 58%,#8c3c08)!important;color:#431700!important;border:1px solid rgba(255,246,190,.72)!important;box-shadow:0 8px 15px rgba(0,0,0,.28);font-size:0!important}
.modalClose:after{content:"X";font-size:13px;font-weight:1000}
.modalBody{position:relative;padding:15px 16px 18px!important;gap:10px!important;max-height:calc(78dvh - 64px);overflow:auto}
.modalHero{position:relative;display:grid;grid-template-columns:56px minmax(0,1fr);gap:12px;align-items:center;padding:12px;border-radius:20px;background:linear-gradient(180deg,rgba(255,255,255,.14),rgba(255,255,255,.055));border:1px solid rgba(255,231,154,.22);box-shadow:inset 0 1px 0 rgba(255,255,255,.14)}
.modalHeroIcon{width:56px;height:56px;border-radius:18px;display:grid;place-items:center;font-size:31px;background:radial-gradient(circle at 34% 26%,#fffad4,#ffca58 46%,#9e4e08);box-shadow:0 12px 18px rgba(0,0,0,.28),0 0 16px rgba(255,213,95,.22)}
.modalHero b{display:block;color:#fff5c8;font-size:17px}.modalHero span{display:block;margin-top:3px;color:rgba(232,242,255,.74);font-size:12px;line-height:1.35}
.modalGrid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px}
.modalTile,.modalRow{border-radius:17px!important;background:linear-gradient(180deg,rgba(255,255,255,.11),rgba(255,255,255,.045))!important;border:1px solid rgba(255,255,255,.10)!important;box-shadow:inset 0 1px 0 rgba(255,255,255,.10)}
.modalTile{padding:10px}.modalTile span{display:block;font-size:10px;letter-spacing:.09em;text-transform:uppercase;color:rgba(255,234,168,.72)}.modalTile b{display:block;margin-top:5px;font-size:15px;color:#fff6cb;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.modalTableWrap{max-height:210px;overflow:auto;border-radius:18px;border:1px solid rgba(255,255,255,.08);background:rgba(0,0,0,.12)}
.modalTable th{background:rgba(12,10,28,.88);position:sticky;top:0}.modalTable td{color:rgba(255,255,255,.82)}
.winPopup{position:absolute;left:50%;top:50%;width:min(362px,calc(100% - 34px));z-index:86;pointer-events:none;opacity:0;transform:translate(-50%,-50%) scale(.86)}
.winPopup.show{animation:winPopupPop 2.25s cubic-bezier(.19,.86,.22,1) forwards}
.winPopupCard{position:relative;display:grid;grid-template-columns:78px minmax(0,1fr);gap:13px;align-items:center;padding:15px;border-radius:28px;background:linear-gradient(180deg,rgba(255,255,255,.20),rgba(255,255,255,.07)),linear-gradient(180deg,rgba(84,38,160,.98),rgba(13,10,33,.98));border:2px solid rgba(255,230,142,.72);box-shadow:0 26px 52px rgba(0,0,0,.52),0 0 34px rgba(255,207,83,.28),inset 0 1px 0 rgba(255,255,255,.28);overflow:hidden}
.winPopupCard:before{content:"";position:absolute;inset:-60px -20px auto;height:120px;background:radial-gradient(ellipse at 50% 0,rgba(255,249,193,.54),rgba(255,85,202,.12) 48%,transparent 72%)}
.winPopupIcon{position:relative;width:78px;height:78px;border-radius:24px;display:grid;place-items:center;font-size:42px;background:radial-gradient(circle at 34% 26%,#fffbe1,#ffd35d 46%,#a55208);box-shadow:0 14px 22px rgba(0,0,0,.34),0 0 22px rgba(255,217,93,.34);animation:winnerIconBlast .9s ease-in-out infinite}
.winPopupCopy{position:relative;min-width:0}.winPopupKicker{font-size:10px;letter-spacing:.16em;text-transform:uppercase;color:#ffe7a5;font-weight:1000}.winPopupTitle{margin-top:3px;font-size:24px;font-weight:1000;color:#fff8ca;text-shadow:0 2px 0 rgba(0,0,0,.32);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.winPopupMeta{margin-top:5px;font-size:13px;color:rgba(234,244,255,.82)}
.fruitConfetti,.winnerCoin{position:absolute;z-index:82;pointer-events:none;will-change:transform,opacity}.fruitConfetti{font-size:22px;text-shadow:0 4px 8px rgba(0,0,0,.32);animation:fruitBlast var(--dur,900ms) cubic-bezier(.13,.86,.22,1) forwards}.winnerCoin{width:16px;height:16px;border-radius:50%;background:radial-gradient(circle at 34% 27%,#fff9cc 0 16%,#ffd05a 17% 54%,#9b5309 55% 100%);box-shadow:0 0 12px rgba(255,214,90,.44),0 7px 10px rgba(0,0,0,.26);animation:coinBlast var(--dur,820ms) cubic-bezier(.15,.8,.22,1) forwards}
.winnerPathBeam{position:absolute;z-index:83;pointer-events:none;height:14px;border-radius:999px;transform-origin:0 50%;background:linear-gradient(90deg,rgba(255,251,216,0) 0%,rgba(255,248,196,.86) 10%,rgba(255,224,94,1) 30%,rgba(255,142,49,.95) 56%,rgba(255,82,216,.96) 78%,rgba(255,255,255,0) 100%);box-shadow:0 0 18px rgba(255,236,150,.86),0 0 34px rgba(255,110,222,.46);opacity:0;animation:winnerPathBeam 760ms cubic-bezier(.18,.88,.24,1) forwards}
.winnerPathOrb{position:absolute;z-index:84;pointer-events:none;width:34px;height:34px;margin:-17px 0 0 -17px;border-radius:50%;background:radial-gradient(circle at 34% 28%,#fffef6 0,#fff0a8 22%,#ffc64a 56%,#ff53cf 100%);box-shadow:0 0 22px rgba(255,239,165,.96),0 0 40px rgba(255,110,220,.56),0 0 0 6px rgba(255,240,170,.16);animation:winnerPathOrb var(--dur,760ms) cubic-bezier(.18,.88,.24,1) forwards}
.winnerBoardFlash{position:absolute;z-index:85;pointer-events:none;left:50%;top:50%;width:36px;height:36px;border-radius:50%;transform:translate(-50%,-50%) scale(.25);background:radial-gradient(circle,rgba(255,255,255,.99) 0,rgba(255,248,198,.98) 16%,rgba(255,213,88,.72) 40%,rgba(255,92,222,.22) 64%,rgba(255,255,255,0) 78%);box-shadow:0 0 28px rgba(255,236,146,.96),0 0 54px rgba(255,111,222,.42);opacity:0;animation:winnerBoardFlash 1080ms ease-out forwards}
.betBox.winner-travel-hit{box-shadow:0 0 0 6px rgba(255,244,184,.52),0 0 36px rgba(255,238,164,.85),0 0 62px rgba(255,114,224,.28),0 20px 28px rgba(0,0,0,.30)!important;animation:winnerTravelPulse .78s ease-in-out 2}
.betBox.win:after{animation:winnerSheen .72s ease-in-out infinite;background:linear-gradient(105deg,transparent,rgba(255,248,190,.52),transparent)}
@keyframes modalCardPop{0%{opacity:0;transform:translateY(28px) scale(.94)}100%{opacity:1;transform:translateY(0) scale(1)}}
@keyframes winPopupPop{0%{opacity:0;transform:translate(-50%,-44%) scale(.78)}9%,78%{opacity:1;transform:translate(-50%,-50%) scale(1)}100%{opacity:0;transform:translate(-50%,-56%) scale(1.05)}}
@keyframes winnerIconBlast{0%,100%{transform:scale(1) rotate(0)}50%{transform:scale(1.08) rotate(-4deg);filter:brightness(1.18)}}
@keyframes winnerPathBeam{0%{opacity:0;transform:scaleX(.05)}14%{opacity:1}74%{opacity:1}100%{opacity:0;transform:scaleX(1)}}
@keyframes winnerPathOrb{0%{opacity:0;transform:translate(-50%,-50%) scale(.36)}14%{opacity:1}100%{opacity:0;transform:translate(calc(-50% + var(--dx,0px)),calc(-50% + var(--dy,0px))) scale(1.22)}}
@keyframes winnerBoardFlash{0%{opacity:0;transform:translate(-50%,-50%) scale(.25)}16%{opacity:1;transform:translate(-50%,-50%) scale(.78)}58%{opacity:.92;transform:translate(-50%,-50%) scale(2.15)}100%{opacity:0;transform:translate(-50%,-50%) scale(3.7)}}
@keyframes winnerTravelPulse{0%,100%{transform:translateY(-2px) scale(1.01);filter:brightness(1.12) saturate(1.15)}50%{transform:translateY(-5px) scale(1.045);filter:brightness(1.48) saturate(1.36)}}
@keyframes fruitBlast{0%{opacity:0;transform:translate(-50%,-50%) scale(.5) rotate(0)}16%{opacity:1}100%{opacity:0;transform:translate(calc(-50% + var(--dx)),calc(-50% + var(--dy))) scale(var(--scale,1)) rotate(var(--rot,180deg))}}
@keyframes coinBlast{0%{opacity:0;transform:translate(-50%,-50%) scale(.45)}18%{opacity:1}100%{opacity:0;transform:translate(calc(-50% + var(--dx)),calc(-50% + var(--dy))) scale(.72) rotate(var(--rot,180deg))}}
@keyframes winnerSheen{0%{transform:translateX(-120%) rotate(15deg)}100%{transform:translateX(220%) rotate(15deg)}}
@media(max-width:380px){.dockRight{gap:5px!important;padding:6px!important}.menuBtn{height:40px!important;border-radius:13px!important}.menuBtn .menuText{font-size:7px}.menuBtn .menuIcon{font-size:15px}.modalGrid{grid-template-columns:1fr}.winPopupCard{grid-template-columns:64px minmax(0,1fr);padding:12px}.winPopupIcon{width:64px;height:64px;font-size:35px}.winPopupTitle{font-size:20px}}</style>
@include('game_final.partials.mobile_fit_styles')
<style id="fruits-loop-user-theme-pass">
#wheelZone{
  --wheel-zone-w: 432px;
  --wheel-shell-w: 404px;
  --wheel-shell-h: 234px;
  --wheel-window-w: 314px;
  --wheel-window-h: 164px;
  --wheel-face-size: 290px;
  top: -4px;
  height: 248px;
  filter: drop-shadow(0 18px 32px rgba(0,0,0,.28)) drop-shadow(0 20px 38px rgba(80,8,18,.18));
}
#wheelBackdrop,
#wheelAura,
#wheelRays,
#wheelGlow,
#wheelScan,
#wheelHaloRing,
#wheelTitle{
  display: none !important;
}
#wheelWindow{
  top: 30px !important;
  width: var(--wheel-window-w) !important;
  height: var(--wheel-window-h) !important;
  border-radius: 999px 999px 34px 34px / 144px 144px 24px 24px;
}
#wheelRotator{
  top: 6px !important;
  width: var(--wheel-face-size) !important;
  height: var(--wheel-face-size) !important;
}
#wheelFace{
  background: url('{{ $wheelFaceAsset }}') center/cover no-repeat !important;
  filter: saturate(1.04) brightness(1.02);
}
#wheelFace:before,
#wheelFace:after,
.sectorLine,
.wheelFruit,
#wheelCover,
#wheelCenterLogo{
  display: none !important;
}
#wheelCenter{
  display: block !important;
  left: 50% !important;
  top: 109px !important;
  width: 108px !important;
  height: 108px !important;
  margin-left: -54px;
  margin-top: -54px;
  border-radius: 50%;
  background: url('{{ $wheelCenterLogoAsset }}') center/cover no-repeat;
  box-shadow: 0 14px 28px rgba(0,0,0,.28);
  z-index: 16;
}
#wheelCenter:before,
#wheelCenter:after{
  display: none !important;
}
#pointer{
  top: 10px !important;
  width: 48px !important;
  height: 56px !important;
  filter: drop-shadow(0 10px 16px rgba(0,0,0,.28));
}
#pointerGem{
  background: radial-gradient(circle at 34% 30%, #ffe5d5, #ff8f78 58%, #a70a18 100%);
  border-color: rgba(255,228,170,.96);
  box-shadow: 0 0 0 3px rgba(255,255,255,.10), inset 0 2px 0 rgba(255,255,255,.68), 0 0 18px rgba(255,123,108,.28), 0 10px 16px rgba(0,0,0,.22);
}
#pointerArrow{
  border-left: 14px solid transparent;
  border-right: 14px solid transparent;
  border-top: 28px solid #ffd35c;
  filter: drop-shadow(0 2px 0 rgba(255,255,255,.28)) drop-shadow(0 8px 10px rgba(0,0,0,.18));
}
#timer{
  top: 84px !important;
  width: 92px !important;
  height: 92px !important;
  border: 0;
  border-radius: 0;
  background: url('{{ $timerStopwatchAsset }}') center/contain no-repeat;
  box-shadow: none;
  color: #fff4cf;
  font-size: 32px;
  text-shadow: 0 3px 0 rgba(95,22,8,.58), 0 0 12px rgba(255,228,154,.26);
}
#timerPulse{
  inset: 12px;
  border: 0;
  background: radial-gradient(circle, rgba(255,255,255,.14) 0%, rgba(255,255,255,0) 70%);
  animation: premiumClockGlow 1.6s ease-in-out infinite;
}
#countNum{
  transform: translateY(4px);
}
#statusBar{
  top: 182px;
}
.modalCard[data-panel="players"],
.modalCard[data-panel="settings"],
.modalCard[data-panel="trend"]{
  width: min(446px, 94vw);
  min-height: min(680px, 92vh);
  padding-bottom: 94px;
  overflow: visible;
  filter: drop-shadow(0 24px 36px rgba(0,0,0,.44));
}
.modalCard[data-panel="players"] .modalBody,
.modalCard[data-panel="settings"] .modalBody,
.modalCard[data-panel="trend"] .modalBody{
  top: 108px !important;
  right: 22px !important;
  bottom: 94px !important;
  left: 22px !important;
}
.modalCard[data-panel="players"] .modalClose,
.modalCard[data-panel="settings"] .modalClose,
.modalCard[data-panel="trend"] .modalClose{
  left: 50% !important;
  bottom: 12px !important;
  width: 72px !important;
  height: 72px !important;
  display: flex !important;
  align-items: center;
  justify-content: center;
  padding: 0;
  transform: translateX(-50%) !important;
  border: 4px solid #f7bf38;
  border-radius: 50%;
  background: linear-gradient(180deg, #a739ff 0%, #6112b8 100%);
  color: transparent;
  box-shadow: 0 14px 26px rgba(0,0,0,.34), inset 0 2px 0 rgba(255,255,255,.18);
}
.modalCard[data-panel="players"] .modalClose::before,
.modalCard[data-panel="settings"] .modalClose::before,
.modalCard[data-panel="trend"] .modalClose::before{
  content: "×";
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
  color: #ffe786;
  font-size: 40px;
  line-height: 1;
  font-weight: 900;
  text-shadow: 0 2px 0 rgba(102,38,0,.55);
}
.modalCard[data-panel="players"] .panelCanvas,
.modalCard[data-panel="settings"] .panelCanvas,
.modalCard[data-panel="trend"] .panelCanvas{
  background: linear-gradient(180deg, rgba(17,9,44,.82), rgba(18,9,56,.68));
  border: 1px solid rgba(255,255,255,.08);
  box-shadow: inset 0 0 0 1px rgba(255,255,255,.05);
}
@keyframes premiumClockGlow{
  0%,100%{opacity:.42;transform:scale(.92)}
  50%{opacity:.86;transform:scale(1.04)}
}
@media (max-width: 860px){
  #wheelZone{
    --wheel-zone-w: 414px;
    --wheel-shell-w: 388px;
    --wheel-shell-h: 226px;
    --wheel-window-w: 298px;
    --wheel-window-h: 158px;
    --wheel-face-size: 278px;
  }
  #wheelCenter{
    top: 106px;
    width: 100px;
    height: 100px;
    margin-left: -50px;
    margin-top: -50px;
  }
  #timer{
    width: 86px;
    height: 86px;
    font-size: 30px;
  }
}</style>
<style id="fruits-loop-popup-polish-pass">
.modalCard[data-panel="players"] .panelCanvas,
.modalCard[data-panel="settings"] .panelCanvas,
.modalCard[data-panel="trend"] .panelCanvas{
  position: relative;
  isolation: isolate;
  overflow: hidden;
  background: linear-gradient(180deg, rgba(20,12,56,.96), rgba(12,8,34,.92)) !important;
  border: 1px solid rgba(255,255,255,.08);
  box-shadow: inset 0 1px 0 rgba(255,255,255,.07), inset 0 0 24px rgba(255,255,255,.02);
}
.modalCard[data-panel="players"] .panelCanvas::before,
.modalCard[data-panel="settings"] .panelCanvas::before,
.modalCard[data-panel="trend"] .panelCanvas::before{
  content: none !important;
  display: none !important;
}
.modalCard[data-panel="settings"] .panelCanvas::before{
  content: none !important;
  display: none !important;
}
.modalCard[data-panel="players"] .panelCanvas::after,
.modalCard[data-panel="settings"] .panelCanvas::after,
.modalCard[data-panel="trend"] .panelCanvas::after{
  content: none !important;
  display: none !important;
}
.modalCard[data-panel="players"] .panelCanvas > *,
.modalCard[data-panel="settings"] .panelCanvas > *,
.modalCard[data-panel="trend"] .panelCanvas > *{
  position: relative;
  z-index: 1;
}
.panelCanvas.settings{
  padding: 18px 16px 14px;
}
.settingsGhostTitle{
  margin: 2px 0 16px;
  font-size: 26px;
  font-weight: 900;
  letter-spacing: .4px;
  text-align: center;
  color: #fff0b4;
  text-shadow: 0 2px 0 rgba(104,34,0,.42), 0 0 16px rgba(255,213,104,.16);
}
.settingToggleRow{
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 14px;
  padding: 14px 16px;
  border-radius: 20px;
  background: linear-gradient(180deg, rgba(255,255,255,.11), rgba(255,255,255,.04));
  border: 1px solid rgba(255,255,255,.10);
  box-shadow: inset 0 1px 0 rgba(255,255,255,.08), 0 10px 20px rgba(0,0,0,.14);
}
.settingsPanel{
  margin-top: 14px;
  padding: 14px 14px 8px;
  border-radius: 22px;
  background: linear-gradient(180deg, rgba(255,255,255,.10), rgba(255,255,255,.03));
  border: 1px solid rgba(255,255,255,.08);
  box-shadow: inset 0 1px 0 rgba(255,255,255,.07), 0 14px 24px rgba(0,0,0,.16);
}
.settingRow{
  display: grid;
  grid-template-columns: 82px minmax(0,1fr) 62px;
  align-items: center;
  gap: 12px;
  padding: 12px 2px;
}
.settingLabel{
  font-size: 17px;
  font-weight: 800;
  line-height: 1.05;
  color: #fff0b7;
  text-shadow: 0 1px 0 rgba(79,22,0,.48);
}
.settingValue{
  text-align: right;
  font-size: 15px;
  font-weight: 800;
  color: #ffe08f;
}
.soundStateBtn{
  min-width: 86px;
  height: 42px;
  padding: 0 16px;
  border-radius: 999px;
  border: 2px solid rgba(255,228,154,.92);
  background: linear-gradient(180deg, #ff50cb 0%, #972dff 54%, #5316b1 100%);
  color: #fff8d4;
  font-weight: 900;
  letter-spacing: .6px;
  box-shadow: 0 10px 18px rgba(0,0,0,.22), inset 0 1px 0 rgba(255,255,255,.24);
}
.themeRange{
  -webkit-appearance: none;
  appearance: none;
  width: 100%;
  height: 12px;
  border-radius: 999px;
  outline: none;
  background: linear-gradient(90deg, #f52ec7 0%, #ff6d4a 100%);
  box-shadow: inset 0 2px 6px rgba(0,0,0,.26), 0 1px 0 rgba(255,255,255,.10);
}
.themeRange::-webkit-slider-thumb{
  -webkit-appearance: none;
  appearance: none;
  width: 24px;
  height: 24px;
  border-radius: 50%;
  border: 2px solid rgba(255,222,138,.96);
  background: radial-gradient(circle at 34% 30%, #fff4bb, #ffc94f 60%, #d28309 100%);
  box-shadow: 0 8px 14px rgba(0,0,0,.22), inset 0 1px 0 rgba(255,255,255,.28);
}
.themeRange::-moz-range-thumb{
  width: 24px;
  height: 24px;
  border-radius: 50%;
  border: 2px solid rgba(255,222,138,.96);
  background: radial-gradient(circle at 34% 30%, #fff4bb, #ffc94f 60%, #d28309 100%);
  box-shadow: 0 8px 14px rgba(0,0,0,.22), inset 0 1px 0 rgba(255,255,255,.28);
}
.panelCanvas.playersPanel{
  padding: 14px;
}
.playerRosterGrid{
  display: grid;
  grid-template-columns: repeat(6, minmax(0, 1fr));
  gap: 6px;
  width: 100%;
  max-height: 100%;
  overflow: auto;
  padding-right: 2px;
}
.playerRosterCard{
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-start;
  gap: 5px;
  padding: 8px 4px;
  border-radius: 12px;
  min-height: 82px;
  background: linear-gradient(180deg, rgba(124,42,255,.26), rgba(88,16,166,.20));
  border: 1px solid rgba(255,255,255,.10);
  box-shadow: inset 0 1px 0 rgba(255,255,255,.08), 0 12px 20px rgba(0,0,0,.16);
}
.playerAvatar{
  flex: 0 0 38px;
  width: 38px;
  height: 38px;
  border-radius: 13px;
  overflow: hidden;
  border: 2px solid rgba(255,227,153,.54);
  background: linear-gradient(135deg, #6f18ff 0%, #b038ff 48%, #ff6c54 100%);
  box-shadow: 0 10px 18px rgba(0,0,0,.18);
}
.playerAvatar img{
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}
.playerAvatarFallback{
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff8dc;
  font-size: 15px;
  font-weight: 900;
  text-shadow: 0 2px 0 rgba(82,20,0,.42);
}
.playerMeta{
  width: 100%;
  min-width: 0;
}
.playerName{
  font-size: 9px;
  font-weight: 900;
  color: #fff4c0;
  line-height: 1.25;
  white-space: nowrap;
  text-overflow: ellipsis;
  overflow: hidden;
  text-align: center;
}
.playerEmptyState{
  width: 100%;
  padding: 18px 14px;
  border-radius: 18px;
  text-align: center;
  background: linear-gradient(180deg, rgba(255,255,255,.09), rgba(255,255,255,.03));
  border: 1px solid rgba(255,255,255,.08);
  box-shadow: inset 0 1px 0 rgba(255,255,255,.07), 0 14px 24px rgba(0,0,0,.14);
}
.playerEmptyText{
  font-size: 13px;
  line-height: 1.45;
  color: rgba(255,255,255,.74);
}</style>
<style id="fruits-loop-glassy-wheel-final">
#wheelZone{
  --wheel-zone-w:min(96vw,452px);
  --wheel-shell-w:min(94vw,432px);
  --wheel-shell-h:min(94vw,322px);
  --wheel-window-w:min(72vw,278px);
  --wheel-window-h:min(72vw,278px);
  --wheel-face-size:min(72vw,278px);
  top:72px;
  height:328px;
  filter:drop-shadow(0 24px 34px rgba(0,0,0,.38)) drop-shadow(0 0 30px rgba(255,209,92,.14));
}
#wheelBackdrop,
#wheelTitle,
#wheelCenter,
#wheelCenterLogo,
#wheelCover,
#wheelAura,
#wheelRays,
#wheelGlow,
#wheelScan,
#wheelHaloRing{
  display:none!important;
}
#wheelShell{
  left:50%;
  top:0;
  transform:translateX(-50%);
  width:var(--wheel-shell-w)!important;
  height:var(--wheel-shell-h)!important;
  border-radius:0!important;
  background:url('{{ $wheelCoverAsset }}') center/contain no-repeat!important;
  box-shadow:none!important;
  overflow:visible!important;
  padding:0!important;
}
#wheelShell:before,
#wheelShell:after{
  display:none!important;
}
#wheelWindow{
  top:14px!important;
  width:var(--wheel-window-w)!important;
  height:var(--wheel-window-h)!important;
  border-radius:50%!important;
  overflow:hidden!important;
  background:radial-gradient(circle at 30% 16%,rgba(255,255,255,.14),transparent 26%),radial-gradient(circle at 50% 84%,rgba(0,0,0,.10),transparent 34%);
  box-shadow:0 16px 24px rgba(0,0,0,.22),inset 0 0 0 1px rgba(255,255,255,.16);
}
#wheelRotator{
  top:0!important;
  width:var(--wheel-face-size)!important;
  height:var(--wheel-face-size)!important;
}
#wheelFace{
  background:url('{{ $wheelFaceAsset }}') center/cover no-repeat!important;
  filter:saturate(1.08) brightness(1.03);
  box-shadow:none!important;
}
#wheelFace:before{
  content:"";
  position:absolute;
  inset:0;
  border-radius:50%;
  background:
    radial-gradient(circle at 30% 18%, rgba(255,255,255,.34), transparent 20%),
    radial-gradient(circle at 78% 28%, rgba(255,255,255,.12), transparent 18%),
    linear-gradient(180deg, rgba(255,255,255,.10), rgba(255,255,255,0) 34%);
  mix-blend-mode:screen;
  pointer-events:none;
}
#wheelFace:after{
  content:"";
  position:absolute;
  inset:10px;
  border-radius:50%;
  box-shadow:inset 0 0 0 1px rgba(255,255,255,.18),inset 0 18px 24px rgba(255,255,255,.04),inset 0 -18px 24px rgba(0,0,0,.08);
  background:linear-gradient(135deg, rgba(255,255,255,.18) 0 14%, rgba(255,255,255,0) 28%);
  pointer-events:none;
}
.sectorLine,
.wheelFruit{
  display:none!important;
}
#pointer{
  top:18px!important;
  width:44px!important;
  height:56px!important;
  filter:drop-shadow(0 10px 14px rgba(0,0,0,.24));
}
#pointerGem{
  width:24px;
  height:24px;
  border:2px solid rgba(255,228,170,.96);
  background:radial-gradient(circle at 34% 30%,#ffd7ff,#b44cff 58%,#6216b7 100%);
  box-shadow:0 0 0 2px rgba(255,255,255,.10), inset 0 1px 0 rgba(255,255,255,.62), 0 0 18px rgba(183,90,255,.26);
}
#pointerArrow{
  top:15px;
  border-left:12px solid transparent;
  border-right:12px solid transparent;
  border-top:22px solid #ffd86d;
  filter:drop-shadow(0 2px 0 rgba(255,255,255,.28)) drop-shadow(0 8px 10px rgba(0,0,0,.18));
}
#timer{
  top:88px!important;
  width:84px!important;
  height:84px!important;
  border:0!important;
  box-shadow:none!important;
}
.modalCard[data-panel="players"] .panelCanvas,
.modalCard[data-panel="settings"] .panelCanvas,
.modalCard[data-panel="trend"] .panelCanvas{
  background:linear-gradient(180deg, rgba(26,18,70,.78), rgba(11,9,30,.74))!important;
  backdrop-filter:blur(16px) saturate(140%);
  -webkit-backdrop-filter:blur(16px) saturate(140%);
  border:1px solid rgba(255,255,255,.14)!important;
  box-shadow:inset 0 1px 0 rgba(255,255,255,.18), inset 0 -32px 64px rgba(0,0,0,.18), 0 18px 34px rgba(0,0,0,.24)!important;
}
.modalCard[data-panel="players"] .panelCanvas::after,
.modalCard[data-panel="settings"] .panelCanvas::after,
.modalCard[data-panel="trend"] .panelCanvas::after{
  content:""!important;
  display:block!important;
  position:absolute;
  inset:0;
  pointer-events:none;
  background:linear-gradient(135deg, rgba(255,255,255,.18) 0%, rgba(255,255,255,.05) 18%, rgba(255,255,255,0) 36%), radial-gradient(circle at 88% 10%, rgba(255,225,124,.12), transparent 18%);
}
.modalCard[data-panel="players"] .modalClose,
.modalCard[data-panel="settings"] .modalClose,
.modalCard[data-panel="trend"] .modalClose{
  box-shadow:0 16px 28px rgba(0,0,0,.30), inset 0 2px 0 rgba(255,255,255,.22), 0 0 20px rgba(255,208,118,.18)!important;
}
@media (max-width: 860px){
  #wheelZone{
    --wheel-shell-w:min(94vw,410px);
    --wheel-shell-h:min(94vw,306px);
    --wheel-window-w:min(72vw,264px);
    --wheel-window-h:min(72vw,264px);
    --wheel-face-size:min(72vw,264px);
  }
  #timer{
    top:86px!important;
    width:78px!important;
    height:78px!important;
  }
}</style>
<style id="fruits-loop-ui-audit-fix">
#wheelZone{
  top: 96px !important;
  height: 332px !important;
}
#wheelShell{
  width: min(94vw, 408px) !important;
  height: min(94vw, 304px) !important;
}
#wheelWindow{
  left: 50% !important;
  top: 18px !important;
  width: min(60vw, 228px) !important;
  height: min(60vw, 228px) !important;
  transform: translateX(-50%) !important;
}
#wheelRotator{
  left: 50% !important;
  top: 18px !important;
  width: min(60vw, 228px) !important;
  height: min(60vw, 228px) !important;
  transform: translate3d(-50%,0,0) rotate(0deg) !important;
  transform-origin: 50% 50% !important;
}
#pointer{
  top: 22px !important;
}
#timer{
  left: calc(50% + 118px) !important;
  right: auto !important;
  top: 118px !important;
  width: 64px !important;
  height: 64px !important;
  transform: translateX(-50%) !important;
  border-radius: 50% !important;
  border: 3px solid rgba(255,229,154,.94) !important;
  background:
    radial-gradient(circle at 34% 28%, rgba(255,255,255,.28), transparent 22%),
    radial-gradient(circle at 50% 46%, #cb1624 0%, #8a0b14 62%, #53050b 100%) !important;
  color: #fff3ca !important;
  box-shadow: 0 14px 24px rgba(0,0,0,.30), inset 0 2px 0 rgba(255,255,255,.18), 0 0 18px rgba(255,206,106,.14) !important;
  text-shadow: 0 2px 0 rgba(71,8,0,.48), 0 0 10px rgba(255,243,185,.16) !important;
  font-size: 26px !important;
  font-weight: 1000 !important;
}
#countNum{
  display: flex !important;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
  position: relative;
  z-index: 1;
}
#timer::before{
  content: "";
  position: absolute;
  inset: 6px;
  border-radius: 50%;
  border: 1px solid rgba(255,255,255,.14);
  box-shadow: inset 0 0 0 1px rgba(0,0,0,.12);
}
#timerPulse{
  inset: 8px !important;
  background: radial-gradient(circle, rgba(255,255,255,.10) 0%, rgba(255,255,255,0) 72%) !important;
}
#countNum{
  transform: translateY(0) !important;
}
.midTop{
  top: -4px !important;
  right: 104px !important;
}
.topRow{
  top: 8px !important;
}
#statusBar{
  top: 426px !important;
}
#board{
  top: 612px !important;
}
.modalCard[data-panel="players"] .panelCanvas,
.modalCard[data-panel="settings"] .panelCanvas,
.modalCard[data-panel="trend"] .panelCanvas{
  border-radius: 26px !important;
}
@media (max-width: 520px){
  #wheelZone{
    top: 102px !important;
    height: 318px !important;
  }
  #wheelShell{
    width: min(94vw, 392px) !important;
    height: min(94vw, 292px) !important;
  }
  #wheelWindow{
    width: min(60vw, 214px) !important;
    height: min(60vw, 214px) !important;
    top: 18px !important;
  }
  #wheelRotator{
    width: min(60vw, 214px) !important;
    height: min(60vw, 214px) !important;
    top: 18px !important;
    transform: translate3d(-50%,0,0) rotate(0deg) !important;
  }
  #timer{
    left: calc(50% + 104px) !important;
    top: 116px !important;
    width: 58px !important;
    height: 58px !important;
    font-size: 24px !important;
  }
  #statusBar{
    top: 414px !important;
  }
  #board{
    top: 598px !important;
  }
}</style>
<style id="fruits-loop-ready-play-pass">
#soundBtn,
#winnersBtn{
  display:none!important;
}
#wheelShell{
  background:none!important;
  z-index:2!important;
}
#wheelShell::after{
  content:"";
  position:absolute;
  inset:0;
  background:url('{{ $wheelCoverAsset }}') center/contain no-repeat;
  pointer-events:none;
  z-index:6;
}
#wheelWindow{
  z-index:1!important;
}
#wheelRotator{
  top:0!important;
  left:50%!important;
  width:100%!important;
  height:100%!important;
  transform:translate3d(-50%,0,0) rotate(0deg)!important;
  transform-origin:50% 50%!important;
}
#wheelFace{
  border-radius:50%!important;
}
.modalCard[data-panel="players"],
.modalCard[data-panel="settings"],
.modalCard[data-panel="trend"]{
  background-image:none!important;
  background:linear-gradient(180deg, rgba(28,19,72,.98), rgba(10,8,28,.98))!important;
}
.modalCard[data-panel="players"]::before,
.modalCard[data-panel="settings"]::before,
.modalCard[data-panel="trend"]::before,
.modalCard[data-panel="players"]::after,
.modalCard[data-panel="settings"]::after,
.modalCard[data-panel="trend"]::after{
  content:none!important;
  display:none!important;
}
.modalCard[data-panel="players"] .modalHead,
.modalCard[data-panel="settings"] .modalHead,
.modalCard[data-panel="trend"] .modalHead{
  position:absolute!important;
  top:16px!important;
  left:18px!important;
  right:18px!important;
  height:48px!important;
  display:flex!important;
  align-items:center!important;
  justify-content:space-between!important;
  opacity:1!important;
  visibility:visible!important;
  z-index:4!important;
  padding:0!important;
  background:none!important;
}
.modalCard[data-panel="players"] .modalHead h3,
.modalCard[data-panel="settings"] .modalHead h3,
.modalCard[data-panel="trend"] .modalHead h3{
  font-size:20px!important;
  letter-spacing:.04em!important;
  color:#fff2bf!important;
}
.modalCard[data-panel="players"] .modalBody,
.modalCard[data-panel="settings"] .modalBody,
.modalCard[data-panel="trend"] .modalBody{
  top:74px!important;
  left:18px!important;
  right:18px!important;
  bottom:94px!important;
}
.historyTableWrap{
  width:100%;
  max-height:100%;
  overflow:auto;
  border-radius:18px;
  border:1px solid rgba(255,255,255,.08);
  background:linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.02));
}
.historyTable{
  width:100%;
  border-collapse:collapse;
  font-size:12px;
}
.historyTable th,
.historyTable td{
  padding:10px 10px;
  text-align:left;
  border-bottom:1px solid rgba(255,255,255,.08);
}
.historyTable th{
  position:sticky;
  top:0;
  background:rgba(18,10,48,.96);
  color:#fff0b4;
  font-size:10px;
  letter-spacing:.08em;
  text-transform:uppercase;
}
.historyResult.win{
  color:#92ff9c;
  font-weight:900;
}
.historyResult.loss{
  color:#ff9da2;
  font-weight:900;
}</style>
<style id="fruits-loop-production-pass">
  :root {
    --fl-wheel-shell-w: min(84vw, 340px);
    --fl-wheel-shell-h: calc(var(--fl-wheel-shell-w) * 0.78);
    --fl-wheel-open: min(44vw, 178px);
    --fl-timer-size: min(18vw, 74px);
  }
  #wheelZone {
    top: 92px !important;
    left: 50% !important;
    transform: translateX(-50%) !important;
    width: min(94vw, 390px) !important;
    height: 330px !important;
  }
  #wheelShell {
    position: relative !important;
    top: 26px !important;
    left: 50% !important;
    transform: translateX(-50%) !important;
    width: var(--fl-wheel-shell-w) !important;
    height: var(--fl-wheel-shell-h) !important;
    overflow: visible !important;
    background: none !important;
    z-index: 42 !important;
  }
  #wheelShell::before {
    content: 'Fruits Loop' !important;
    position: absolute !important;
    left: 50% !important;
    bottom: 12px !important;
    transform: translateX(-50%) !important;
    min-width: 168px !important;
    height: 44px !important;
    padding: 0 24px !important;
    border-radius: 999px !important;
    border: 3px solid #f0bd3c !important;
    background: linear-gradient(180deg, #9e37ee 0%, #6a23cb 100%) !important;
    box-shadow: inset 0 2px 0 rgba(255,255,255,.32), 0 10px 18px rgba(0,0,0,.34) !important;
    color: #ffe98a !important;
    font-size: 24px !important;
    font-weight: 900 !important;
    line-height: 38px !important;
    letter-spacing: .4px !important;
    text-align: center !important;
    text-shadow: 0 1px 0 #7f3b00, 0 3px 8px rgba(0,0,0,.28) !important;
    z-index: 8 !important;`r`n    pointer-events: none !important;`r`n    font-family: Georgia, 'Times New Roman', serif !important;
  }
  #wheelShell::after {
    content: '' !important;
    position: absolute !important;
    inset: 0 !important;
    background: url('{{ $wheelCoverAsset }}') center/contain no-repeat !important;
    mix-blend-mode: screen !important;
    opacity: .98 !important;
    z-index: 4 !important;
    pointer-events: none !important;
  }
  #wheelWindow {
    position: absolute !important;
    top: 11px !important;
    left: 50% !important;
    width: var(--fl-wheel-open) !important;
    height: var(--fl-wheel-open) !important;
    transform: translateX(-50%) !important;
    overflow: hidden !important;
    border-radius: 50% !important;
    z-index: 2 !important;
  }
  #wheelRotator {
    top: 0 !important;
    left: 50% !important;
    width: 100% !important;
    height: 100% !important;
    transform: translate3d(-50%, 0, 0) rotate(0deg) !important;
    transform-origin: 50% 50% !important;
    z-index: 2 !important;
    will-change: transform !important;
  }
  #wheelFace {
    width: 100% !important;
    height: 100% !important;
    display: block !important;
    object-fit: cover !important;
    border-radius: 50% !important;
    filter: drop-shadow(0 8px 18px rgba(0,0,0,.28)) saturate(1.08) !important;
  }
  #timer {
    position: absolute !important;
    top: 124px !important;
    left: calc(50% + 104px) !important;
    width: var(--fl-timer-size) !important;
    height: var(--fl-timer-size) !important;
    border: 0 !important;
    border-radius: 0 !important;
    background: url('{{ $timerStopwatchAsset }}') center/contain no-repeat !important;
    box-shadow: none !important;
    z-index: 9 !important;
  }
  #timerPulse {
    display: none !important;
  }
  #countNum {
    position: absolute !important;
    top: 49% !important;
    left: 50% !important;
    transform: translate(-50%, -50%) !important;
    margin: 0 !important;
    width: auto !important;
    height: auto !important;
    font-size: 18px !important;
    font-weight: 900 !important;
    line-height: 1 !important;
    color: #fff4c7 !important;
    letter-spacing: .2px !important;
    text-shadow: 0 1px 0 #7d1919, 0 2px 8px rgba(87, 0, 0, .5) !important;
  }
  #statusBar {
    top: 376px !important;
    left: 50% !important;
    transform: translateX(-50%) !important;
    width: min(90vw, 390px) !important;
    z-index: 28 !important;
  }
  #soundBtn,
  #winnersBtn {
    display: none !important;
  }
  #appModal .modalBody,
  #appModal .panelCanvas,
  #appModal .trendPanel,
  #appModal .playersPanel,
  #appModal .settingsPanel {
    background-image: none !important;
  }
  #appModal .modalBody {
    background: linear-gradient(180deg, rgba(17, 22, 76, 0.96), rgba(12, 18, 61, 0.96)) !important;
    border: 1px solid rgba(255, 221, 137, 0.18) !important;
    box-shadow: inset 0 1px 0 rgba(255,255,255,.08), 0 22px 46px rgba(0,0,0,.42) !important;
  }
  #appModal .modalClose {
    bottom: 10px !important;
    width: 72px !important;
    height: 72px !important;
  }
  .historyTableWrap {
    overflow: hidden;
    border-radius: 18px;
    border: 1px solid rgba(255, 208, 120, 0.18);
    background: linear-gradient(180deg, rgba(104, 30, 143, 0.22), rgba(18, 16, 72, 0.68));
  }
  .historyTable {
    width: 100%;
    border-collapse: collapse;
    color: #fff7d0;
    font-size: 13px;
  }
  .historyTable th,
  .historyTable td {
    padding: 11px 10px;
    text-align: left;
    border-bottom: 1px solid rgba(255,255,255,.08);
  }
  .historyTable th {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .8px;
    color: #ffd986;
  }
  .historyResult {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 64px;
    padding: 5px 10px;
    border-radius: 999px;
    font-weight: 800;
  }
  .historyResult.win {
    color: #0e411e;
    background: linear-gradient(180deg, #90f78d, #53d35f);
  }
  .historyResult.loss {
    color: #521212;
    background: linear-gradient(180deg, #ffb0b0, #ff7474);
  }
  .playerListGrid {
    display: grid;
    grid-template-columns: repeat(6, minmax(0, 1fr));
    gap: 6px;
  }
  .playerListItem {
    min-height: 82px;
    padding: 8px 4px;
    border-radius: 12px;
    border: 1px solid rgba(255, 215, 145, .18);
    background: linear-gradient(180deg, rgba(109, 36, 157, .32), rgba(42, 16, 104, .42));
    box-shadow: inset 0 1px 0 rgba(255,255,255,.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 5px;
    text-align: center;
  }
  .playerAvatar {
    width: 38px;
    height: 38px;
    border-radius: 13px;
    object-fit: cover;
    border: 2px solid rgba(255, 225, 155, .84);
    box-shadow: 0 8px 16px rgba(0,0,0,.28);
    background: radial-gradient(circle at 30% 30%, rgba(255,255,255,.55), rgba(120, 68, 183, 1));
  }
  .playerAvatar.placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff8d9;
    font-weight: 900;
    font-size: 15px;
  }
  .playerName {
    width: 100%;
    color: #fff8dd;
    font-size: 9px;
    font-weight: 700;
    line-height: 1.2;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
  .playerEmptyState {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 180px;
    color: #fff2c1;
    font-weight: 700;
    text-align: center;
  }
  .settingsGrid {
    display: grid;
    gap: 14px;
  }
  .settingRow {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    padding: 12px 14px;
    border-radius: 16px;
    background: linear-gradient(180deg, rgba(97, 28, 143, .28), rgba(28, 17, 83, .38));
    border: 1px solid rgba(255, 223, 139, .12);
  }
  .settingLabel {
    color: #fff4ce;
    font-size: 14px;
    font-weight: 800;
  }
  .settingSlider {
    width: 56%;
    accent-color: #ffbf39;
  }
  @media (max-width: 520px) {
    :root {
      --fl-wheel-shell-w: min(84vw, 320px);
      --fl-wheel-shell-h: calc(var(--fl-wheel-shell-w) * 0.78);
      --fl-wheel-open: min(46vw, 168px);
      --fl-timer-size: min(20vw, 68px);
    }
    #wheelZone {
      top: 88px !important;
      height: 312px !important;
    }
    #wheelShell {
      top: 22px !important;
    }
    #timer {
      top: 118px !important;
      left: calc(50% + 92px) !important;
    }
    #countNum {
      font-size: 16px !important;
    }
    #statusBar {
      top: 354px !important;
    }
    .playerListGrid {
      grid-template-columns: repeat(6, minmax(0, 1fr));
    }
  }</style>
<style id="fruits-loop-shell-cleanup">
  #wheelShell::before {
    content: none !important;
    display: none !important;
  }
  #wheelShell .flWheelBadge {
    display: none !important;
  }</style>
<style id="fruits-loop-popup-stability">
  #appModal{
    position:fixed !important;
    inset:0 !important;
    padding:clamp(10px,3vw,18px) !important;
    align-items:center !important;
    justify-content:center !important;
    background:rgba(5,8,22,.76) !important;
    backdrop-filter:blur(10px) saturate(120%) !important;
    -webkit-backdrop-filter:blur(10px) saturate(120%) !important;
  }
  #appModal .modalCard,
  #appModal .modalCard[data-panel="players"],
  #appModal .modalCard[data-panel="settings"],
  #appModal .modalCard[data-panel="trend"]{
    width:min(96vw,440px) !important;
    max-width:440px !important;
    min-height:auto !important;
    max-height:min(84dvh,720px) !important;
    border-radius:24px !important;
    border:1px solid rgba(255,223,148,.24) !important;
    background:linear-gradient(180deg,rgba(31,24,84,.98),rgba(10,12,32,.98)) !important;
    box-shadow:0 28px 70px rgba(0,0,0,.56),0 0 24px rgba(255,205,92,.14) !important;
    overflow:hidden !important;
  }
  #appModal .modalCard::before,
  #appModal .modalCard::after{
    display:none !important;
  }
  #appModal .modalHead,
  #appModal .modalCard[data-panel="players"] .modalHead,
  #appModal .modalCard[data-panel="settings"] .modalHead,
  #appModal .modalCard[data-panel="trend"] .modalHead{
    display:flex !important;
    align-items:center !important;
    justify-content:space-between !important;
    gap:12px !important;
    height:auto !important;
    min-height:0 !important;
    padding:16px 16px 10px !important;
    border-bottom:1px solid rgba(255,255,255,.08) !important;
    background:none !important;
    position:static !important;
    overflow:visible !important;
  }
  #appModal #modalTitle,
  #appModal .modalCard[data-panel="players"] #modalTitle,
  #appModal .modalCard[data-panel="settings"] #modalTitle,
  #appModal .modalCard[data-panel="trend"] #modalTitle{
    opacity:1 !important;
    pointer-events:auto !important;
    color:#fff2c6 !important;
    font-size:15px !important;
    font-weight:900 !important;
    letter-spacing:.12em !important;
    text-transform:uppercase !important;
  }
  #appModal .modalClose,
  #appModal .modalCard[data-panel="players"] .modalClose,
  #appModal .modalCard[data-panel="settings"] .modalClose,
  #appModal .modalCard[data-panel="trend"] .modalClose{
    position:static !important;
    transform:none !important;
    width:38px !important;
    height:38px !important;
    min-width:38px !important;
    border-radius:12px !important;
    border:1px solid rgba(255,255,255,.14) !important;
    background:rgba(255,255,255,.08) !important;
    color:#fff6d1 !important;
    box-shadow:none !important;
  }
  #appModal .modalClose::before,
  #appModal .modalClose::after{
    display:none !important;
  }
  #appModal .modalBody,
  #appModal .modalCard[data-panel="players"] .modalBody,
  #appModal .modalCard[data-panel="settings"] .modalBody,
  #appModal .modalCard[data-panel="trend"] .modalBody{
    position:static !important;
    inset:auto !important;
    left:auto !important;
    right:auto !important;
    top:auto !important;
    bottom:auto !important;
    padding:14px 16px 16px !important;
    max-height:none !important;
    overflow:auto !important;
    background:none !important;
    border:none !important;
    box-shadow:none !important;
  }
  #appModal .panelCanvas,
  #appModal .modalCard[data-panel="players"] .panelCanvas,
  #appModal .modalCard[data-panel="settings"] .panelCanvas,
  #appModal .modalCard[data-panel="trend"] .panelCanvas{
    min-height:0 !important;
    height:auto !important;
    padding:14px !important;
    border-radius:18px !important;
    overflow:auto !important;
    background:linear-gradient(180deg,rgba(19,15,54,.96),rgba(10,12,33,.96)) !important;
    border:1px solid rgba(255,255,255,.08) !important;
  }
  #appModal .playerListGrid,
  #appModal .playerGrid{
    display:grid !important;
    grid-template-columns:repeat(6,minmax(0,1fr)) !important;
    gap:6px !important;
  }
  #appModal .playerCard,
  #appModal .playerListItem{
    min-width:0 !important;
  }
  #appModal .historyTableWrap{
    max-height:none !important;
    overflow:hidden !important;
  }
  #appModal .historyTable th,
  #appModal .historyTable td{
    padding:9px 8px !important;
    font-size:12px !important;
  }
  #appModal .trendPanel{
    gap:8px !important;
  }
  #appModal .trendRow{
    grid-template-columns:42px minmax(0,1fr) 28px !important;
    gap:8px !important;
  }
  #appModal .settingsGrid{
    gap:12px !important;
  }
  #appModal .settingRow{
    align-items:flex-start !important;
    flex-wrap:wrap !important;
  }
  #appModal .settingSlider,
  #appModal .themeRange{
    width:100% !important;
  }
  @media (max-width: 520px){
    #appModal{
      padding:10px !important;
    }
    #appModal .modalHead{
      padding:14px 14px 8px !important;
    }
    #appModal .modalBody{
      padding:12px 14px 14px !important;
    }
    #appModal .panelCanvas{
      padding:12px !important;
    }
    #appModal .playerListGrid,
    #appModal .playerGrid{
      grid-template-columns:repeat(6,minmax(0,1fr)) !important;
    }
  }
  @media (max-height: 700px){
    #appModal .modalCard,
    #appModal .modalCard[data-panel="players"],
    #appModal .modalCard[data-panel="settings"],
    #appModal .modalCard[data-panel="trend"]{
      max-height:88dvh !important;
    }
  }</style>
<style id="fruits-loop-layout-final-pass">
  .topRow {
    top: 8px !important;
    left: 9px !important;
    right: 9px !important;
    height: 98px !important;
    z-index: 44 !important;
  }
  .dockRight {
    left: 0 !important;
    right: 0 !important;
    top: 0 !important;
    width: auto !important;
    display: grid !important;
    grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
    gap: 8px !important;
    padding: 8px !important;
    border-radius: 20px !important;
  }
  #winnersBtn,
  #soundBtn {
    display: none !important;
  }
  .menuBtn {
    height: 43px !important;
    border-radius: 15px !important;
  }
  .menuBtn .menuIcon {
    font-size: 17px !important;
  }
  .menuBtn .menuText {
    font-size: 8px !important;
    letter-spacing: 0 !important;
  }
  .midTop {
    position: absolute !important;
    top: 68px !important;
    left: 9px !important;
    right: auto !important;
    gap: 8px !important;
  }
  .latencyPill,
  .roundPill {
    height: 32px !important;
    padding: 0 12px !important;
    font-size: 12px !important;
  }
  #timer {
    top: 222px !important;
    left: calc(50% + 112px) !important;
    width: 66px !important;
    height: 66px !important;
    z-index: 35 !important;
  }
  #countNum {
    top: 52% !important;
    font-size: 17px !important;
    min-width: 34px !important;
    height: 34px !important;
  }
  #board {
    bottom: 148px !important;
    min-height: 218px !important;
  }
  #bottomBar {
    bottom: max(env(safe-area-inset-bottom), 0px) !important;
    grid-template-columns: 96px minmax(0, 1fr) !important;
    gap: 10px !important;
    padding: 8px !important;
    z-index: 46 !important;
    background:
      linear-gradient(180deg, rgba(255,255,255,.18), rgba(255,255,255,.04)),
      linear-gradient(180deg, #178a3a 0%, #08612a 54%, #06451f 100%) !important;
    border: 1px solid rgba(146, 255, 178, .48) !important;
    box-shadow:
      0 16px 28px rgba(0,0,0,.34),
      inset 0 1px 0 rgba(255,255,255,.24),
      inset 0 -5px 12px rgba(0,0,0,.22) !important;
  }
  #balancePill {
    width: 96px !important;
    height: 50px !important;
    border-radius: 18px !important;
    gap: 7px !important;
    padding: 0 9px !important;
  }
  #balanceIcon {
    width: 28px !important;
    height: 28px !important;
    flex: 0 0 28px !important;
    border-radius: 50% !important;
    font-size: 0 !important;
    color: transparent !important;
    background:
      radial-gradient(circle at 34% 30%, #fff8bf 0 15%, #ffd45d 16% 52%, #b76d0d 53% 100%) !important;
    border: 2px solid rgba(255, 246, 196, .78) !important;
    box-shadow: inset 0 1px 0 rgba(255,255,255,.55), 0 6px 10px rgba(0,0,0,.28) !important;
    position: relative !important;
  }
  #balanceIcon::after {
    content: '' !important;
    position: absolute !important;
    inset: 7px !important;
    border-radius: 50% !important;
    border: 2px solid rgba(143, 81, 5, .48) !important;
  }
  #balanceValue {
    font-size: 14px !important;
    text-align: left !important;
  }
  #chipDock {
    height: 54px !important;
    gap: 7px !important;
    padding: 6px 8px !important;
    border-radius: 18px !important;
    background: transparent !important;
    border: 0 !important;
    box-shadow: none !important;
  }
  .chipBtn,
  .controlChipBtn {
    width: 48px !important;
    height: 48px !important;
    flex: 0 0 48px !important;
  }
  @media (max-height: 820px) {
    #timer {
      top: 204px !important;
      left: calc(50% + 100px) !important;
      width: 60px !important;
      height: 60px !important;
    }
    #board {
      bottom: 138px !important;
      min-height: 202px !important;
    }
    #bottomBar {
      grid-template-columns: 90px minmax(0, 1fr) !important;
      bottom: max(env(safe-area-inset-bottom), 0px) !important;
    }
    #chipDock {
      height: 50px !important;
    }
    .chipBtn,
    .controlChipBtn {
      width: 44px !important;
      height: 44px !important;
      flex-basis: 44px !important;
    }
  }
  @media (max-width: 380px) {
    .dockRight {
      gap: 6px !important;
      padding: 7px !important;
    }
    #bottomBar {
      grid-template-columns: 84px minmax(0, 1fr) !important;
      gap: 7px !important;
    }
    #balancePill {
      width: 84px !important;
      gap: 5px !important;
    }
    #balanceIcon {
      width: 24px !important;
      height: 24px !important;
      flex-basis: 24px !important;
    }
    #balanceValue {
      font-size: 12px !important;
    }
  }</style>
<style id="fruits-loop-result-sync-pass">
  .visualPotName {
    margin-top: 6px;
    color: #fff7cf;
    font-size: 11px;
    font-weight: 900;
    letter-spacing: .5px;
    text-transform: uppercase;
    text-shadow: 0 1px 0 rgba(53, 11, 0, .8), 0 2px 8px rgba(0, 0, 0, .22);
    pointer-events: none;
  }
  #wheelShell .flWheelCover {
    display: block !important;
    z-index: 5 !important;
  }
  #wheelShell .flWheelBadge {
    display: none !important;
  }</style>
<style id="fruits-loop-compact-ui-pass">
  .topRow {
    top: 8px !important;
    left: 9px !important;
    right: 9px !important;
    height: 44px !important;
    z-index: 48 !important;
  }
  .midTop {
    position: absolute !important;
    left: 0 !important;
    top: 0 !important;
    right: auto !important;
    width: 112px !important;
    height: 42px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: flex-start !important;
    gap: 5px !important;
  }
  .dockRight {
    position: absolute !important;
    left: 120px !important;
    right: 0 !important;
    top: 0 !important;
    width: auto !important;
    height: 42px !important;
    display: grid !important;
    grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
    gap: 7px !important;
    padding: 0 !important;
    border: 0 !important;
    border-radius: 0 !important;
    background: transparent !important;
    box-shadow: none !important;
    backdrop-filter: none !important;
  }
  .menuBtn {
    height: 42px !important;
    min-width: 0 !important;
    display: grid !important;
    grid-template-rows: 1fr !important;
    place-items: center !important;
    padding: 0 !important;
  }
  .menuBtn .menuText {
    display: none !important;
  }
  .menuBtn .menuIcon {
    width: 24px !important;
    height: 24px !important;
    font-size: 18px !important;
  }
  .userMenuBtn .activeCount {
    right: 5px !important;
    top: 3px !important;
    transform: none !important;
  }
  .latencyPill,
  .roundPill {
    height: 32px !important;
    min-width: 0 !important;
    padding: 0 8px !important;
    gap: 4px !important;
    border-radius: 999px !important;
    white-space: nowrap !important;
  }
  .latencyPill {
    width: 62px !important;
  }
  .latencyPill > span:not(.latencyDot) {
    font-size: 0 !important;
  }
  #latencyText {
    font-size: 11px !important;
    font-weight: 900 !important;
  }
  #latencyText::after {
    content: 'ms';
  }
  .roundPill {
    width: 45px !important;
    justify-content: center !important;
    font-size: 0 !important;
  }
  .roundPill::before {
    content: '#';
    font-size: 12px !important;
    font-weight: 900 !important;
    color: #ffe58f !important;
  }
  .roundPill b {
    font-size: 11px !important;
    line-height: 1 !important;
  }
  .visualPotName {
    display: none !important;
  }
  #balancePill {
    width: 82px !important;
    gap: 4px !important;
    padding: 0 6px !important;
  }
  #balanceIcon {
    width: 22px !important;
    height: 22px !important;
    flex-basis: 22px !important;
  }
  #balanceIcon::after {
    inset: 5px !important;
  }
  #balanceValue {
    font-size: 12px !important;
    max-width: 46px !important;
    overflow: hidden !important;
    text-overflow: clip !important;
  }
  .potText {
    left: 8px !important;
    right: 8px !important;
    top: 10px !important;
    font-size: 11px !important;
    overflow: hidden !important;
  }
  .potText span,
  .youText span {
    font-size: inherit !important;
    max-width: 56px !important;
    overflow: hidden !important;
    text-overflow: clip !important;
    vertical-align: baseline !important;
  }
  .youText {
    left: 8px !important;
    bottom: 11px !important;
    font-size: 14px !important;
    max-width: 72px !important;
    overflow: hidden !important;
  }
  .youText small {
    font-size: 9px !important;
  }
  @media (max-width: 380px) {
    .midTop {
      width: 104px !important;
      gap: 4px !important;
    }
    .dockRight {
      left: 110px !important;
      gap: 5px !important;
    }
    .latencyPill {
      width: 58px !important;
      padding: 0 6px !important;
    }
    .roundPill {
      width: 42px !important;
      padding: 0 5px !important;
    }
  }</style>
<style id="fruits-loop-final-polish-pass">
  .latencyPill,
  .roundPill {
    overflow: hidden !important;
    white-space: nowrap !important;
  }

  #balancePill {
    width: 92px !important;
    min-width: 92px !important;
    padding: 0 5px !important;
    gap: 2px !important;
  }

  #balanceIcon {
    flex: 0 0 18px !important;
    width: 18px !important;
    height: 18px !important;
    font-size: 0 !important;
  }

  #balanceValue {
    flex: 1 1 auto !important;
    min-width: 0 !important;
    max-width: none !important;
    width: auto !important;
    font-size: 11px !important;
    line-height: 1 !important;
    text-align: left !important;
    overflow: hidden !important;
    text-overflow: clip !important;
  }

  #bottomBar {
    grid-template-columns: 92px minmax(0, 1fr) !important;
  }

  .potValue,
  .youValue {
    max-width: 100% !important;
    overflow: hidden !important;
    text-overflow: clip !important;
    font-size: 11px !important;
  }

  .youText {
    min-width: 0 !important;
    overflow: hidden !important;
  }

  @media (max-width: 380px) {
    #balancePill {
      width: 88px !important;
      min-width: 88px !important;
    }

    #bottomBar {
      grid-template-columns: 88px minmax(0, 1fr) !important;
    }

    #balanceValue {
      font-size: 10px !important;
    }
  }</style>
<style id="fruits-loop-wheel-pro-placement-pass">
  #wheelZone {
    --fl-wheel-size: min(74vw, 334px) !important;
    top: 102px !important;
    width: min(96vw, 430px) !important;
    height: calc(var(--fl-wheel-size) + 116px) !important;
    display: grid !important;
    place-items: start center !important;
    transform: translateX(-50%) !important;
    filter: drop-shadow(0 28px 38px rgba(0,0,0,.42)) drop-shadow(0 0 24px rgba(255,207,91,.16)) !important;
  }

  #wheelBackdrop,
  #wheelTitle,
  #wheelAura,
  #wheelRays,
  #wheelGlow,
  #wheelScan,
  #wheelHaloRing,
  #wheelCenter,
  #wheelCenterLogo,
  #wheelCover,
  #pointer {
    display: none !important;
  }

  #wheelShell {
    position: relative !important;
    left: auto !important;
    top: 0 !important;
    width: var(--fl-wheel-size) !important;
    height: var(--fl-wheel-size) !important;
    margin: 0 auto !important;
    padding: 0 !important;
    border-radius: 50% !important;
    display: block !important;
    overflow: visible !important;
    background: none !important;
    box-shadow: none !important;
    transform: none !important;
    isolation: isolate !important;
  }

  #wheelWindow {
    position: absolute !important;
    left: 50% !important;
    top: 0 !important;
    width: 100% !important;
    height: 100% !important;
    transform: translateX(-50%) !important;
    border-radius: 50% !important;
    overflow: hidden !important;
    clip-path: inset(49% 0 0 0 round 0 0 999px 999px) !important;
    -webkit-clip-path: inset(49% 0 0 0 round 0 0 999px 999px) !important;
    background: transparent !important;
    isolation: isolate !important;
    z-index: 2 !important;
  }

  #wheelRotator {
    position: absolute !important;
    inset: 0 !important;
    left: 0 !important;
    top: 0 !important;
    width: 100% !important;
    height: 100% !important;
    transform: translate3d(0,0,0) rotate(30deg) !important;
    transform-origin: 50% 50% !important;
    backface-visibility: hidden !important;
    will-change: transform !important;
    pointer-events: none !important;
  }

  #wheelFace {
    position: absolute !important;
    inset: 0 !important;
    width: 100% !important;
    height: 100% !important;
    border-radius: 50% !important;
    background-size: 100% 100% !important;
    background-position: center !important;
    background-repeat: no-repeat !important;
    box-shadow: none !important;
    filter: saturate(1.03) brightness(1.02) !important;
  }

  #wheelFace::before,
  #wheelFace::after {
    display: none !important;
  }

  #wheelShell .flWheelCover {
    position: absolute !important;
    left: 50% !important;
    top: -10% !important;
    width: 103.6% !important;
    height: auto !important;
    aspect-ratio: 1190 / 957 !important;
    transform: translateX(-50%) !important;
    background-position: center top !important;
    background-size: 100% 100% !important;
    background-repeat: no-repeat !important;
    mix-blend-mode: normal !important;
    opacity: 1 !important;
    z-index: 24 !important;
    pointer-events: none !important;
  }

  #wheelShell .flWheelBadge {
    display: none !important;
  }

  #timer {
    left: 50% !important;
    top: calc(102px + min(74vw, 334px) - 6px) !important;
    width: 150px !important;
    height: 150px !important;
    transform: translateX(-50%) !important;
    border: 0 !important;
    border-radius: 0 !important;
    background: url('{{ $timerStopwatchAsset }}') center / contain no-repeat !important;
    box-shadow: none !important;
    color: #fff0c3 !important;
    z-index: 32 !important;
    text-shadow: 0 3px 0 rgba(89,28,0,.45), 0 0 12px rgba(255,204,74,.35) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
  }

  #countNum {
    position: absolute !important;
    left: 50% !important;
    top: 53% !important;
    min-width: 58px !important;
    height: 58px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 36px !important;
    line-height: 1 !important;
    transform: translate(-50%, -50%) !important;
    color: #fff2c9 !important;
    text-align: center !important;
    text-shadow: 0 3px 0 rgba(93,21,0,.55), 0 0 10px rgba(255,211,89,.42) !important;
    z-index: 2 !important;
  }

  #statusBar {
    top: calc(102px + min(74vw, 334px) + 144px) !important;
    min-width: 190px !important;
    max-width: 240px !important;
    padding: 5px 18px !important;
    font-size: 16px !important;
    border-radius: 999px !important;
    z-index: 31 !important;
  }

  #board {
    z-index: 16 !important;
  }

  @media (max-height: 720px) {
    #wheelZone {
      --fl-wheel-size: min(66vw, 278px) !important;
      top: 100px !important;
      height: calc(var(--fl-wheel-size) + 88px) !important;
    }

    #timer {
      top: calc(100px + min(66vw, 278px) - 4px) !important;
      width: 122px !important;
      height: 122px !important;
    }

    #statusBar {
      top: calc(100px + min(66vw, 278px) + 120px) !important;
    }

    #countNum {
      font-size: 32px !important;
      min-width: 52px !important;
      height: 52px !important;
    }
  }

  @media (max-width: 380px) {
    #wheelZone {
      --fl-wheel-size: min(74vw, 286px) !important;
      top: 96px !important;
    }

    #timer {
      top: calc(96px + min(74vw, 286px) - 3px) !important;
      width: 118px !important;
      height: 118px !important;
    }

    #statusBar {
      top: calc(96px + min(74vw, 286px) + 114px) !important;
    }
  }</style>
<style id="fruits-loop-polish-pass">
  .topRow{
    top:8px!important;
    height:40px!important;
    display:flex!important;
    align-items:center!important;
    justify-content:space-between!important;
    padding:0 10px!important;
    gap:8px!important;
    z-index:25!important;
  }
  .midTop{
    position:relative!important;
    right:auto!important;
    top:auto!important;
    display:flex!important;
    align-items:center!important;
    gap:6px!important;
    flex:0 0 auto!important;
  }
  .dockRight{
    position:relative!important;
    right:auto!important;
    top:auto!important;
    display:flex!important;
    gap:6px!important;
    flex:0 0 auto!important;
  }
  .latencyPill,.roundPill{
    height:34px!important;
    padding:0 10px!important;
    font-size:11px!important;
    border-radius:999px!important;
  }
  .menuBtn{
    width:34px!important;
    min-width:34px!important;
    height:34px!important;
    border-radius:11px!important;
    padding:0!important;
    box-shadow:0 8px 15px rgba(0,0,0,.18),inset 0 1px 0 rgba(255,255,255,.18)!important;
  }
  .menuIcon{font-size:15px!important;line-height:1!important}
  .menuText{display:none!important}
  .latencyDot{
    width:8px!important;
    height:8px!important;
    box-shadow:0 0 10px currentColor!important;
  }
  .userMenuBtn .activeCount{
    right:-2px!important;
    top:-2px!important;
    min-width:15px!important;
    height:15px!important;
    font-size:8px!important;
  }
  #wheelFace::before{
    content:""!important;
    display:block!important;
    position:absolute!important;
    inset:0!important;
    border-radius:50%!important;
    background:
      radial-gradient(circle at 32% 20%,rgba(255,255,255,.28),transparent 22%),
      radial-gradient(circle at 68% 74%,rgba(255,255,255,.12),transparent 22%),
      linear-gradient(135deg,rgba(255,255,255,.26) 0 15%,rgba(255,255,255,0) 30% 100%)!important;
    mix-blend-mode:screen!important;
    pointer-events:none!important;
    opacity:.48!important;
  }
  #wheelFace::after{
    content:""!important;
    display:block!important;
    position:absolute!important;
    inset:5px!important;
    border-radius:50%!important;
    box-shadow:inset 0 0 0 1px rgba(255,248,204,.38),inset 0 10px 16px rgba(255,255,255,.04),inset 0 -10px 16px rgba(0,0,0,.08)!important;
    pointer-events:none!important;
  }
  #wheelFace{
    image-rendering:auto!important;
    filter:saturate(1.18) contrast(1.08) brightness(1.01)!important;
  }
  #wheelShell .flWheelCover{
    image-rendering:auto!important;
    filter:saturate(1.08) contrast(1.06) drop-shadow(0 10px 16px rgba(0,0,0,.26)) drop-shadow(0 0 12px rgba(255,222,113,.18))!important;
  }
  #wheelZone.ai-spin #wheelRotator{
    filter:saturate(1.12) brightness(1.04)!important;
  }
  #wheelZone.ai-spin #wheelFace::before{
    animation:wheelGlossSweep .9s linear infinite!important;
  }
  #timer{
    width:136px!important;
    height:136px!important;
    background:url('{{ $timerStopwatchAsset }}') center/contain no-repeat!important;
    box-shadow:none!important;
  }
  #timerPulse{display:none!important}
  #countNum{
    top:49%!important;
    min-width:72px!important;
    height:72px!important;
    font-size:40px!important;
    color:#fff7da!important;
    text-shadow:0 3px 0 rgba(83,28,0,.60),0 0 12px rgba(255,244,194,.22)!important;
  }
  #statusBar{
    font-size:15px!important;
    min-width:182px!important;
  }
  #chipDock{
    background:linear-gradient(180deg,rgba(16,110,46,.52),rgba(7,73,30,.52))!important;
    border-color:rgba(149,245,178,.28)!important;
  }
  #balanceValue{
    letter-spacing:0!important;
    font-variant-numeric:tabular-nums!important;
  }
  .betBox{
    overflow:hidden!important;
  }
  .potText,.youText{
    left:50%!important;
    transform:translateX(-50%)!important;
    width:82%!important;
    display:flex!important;
    align-items:center!important;
    justify-content:center!important;
    gap:6px!important;
    text-align:center!important;
    z-index:3!important;
  }
  .potText{top:12px!important}
  .youText{bottom:13px!important}
  .boardStatLabel{
    font-size:11px!important;
    font-weight:900!important;
    letter-spacing:.02em!important;
    color:rgba(255,247,213,.92)!important;
  }
  .potValue,.youValue{
    font-size:16px!important;
    line-height:1!important;
    white-space:nowrap!important;
    overflow:visible!important;
    flex:0 0 auto!important;
  }
  .combo{
    z-index:3!important;
  }
  .multText{
    left:50%!important;
    right:auto!important;
    top:50%!important;
    bottom:auto!important;
    transform:translate(88px,-50%)!important;
    width:auto!important;
    text-align:center!important;
    font-size:18px!important;
    line-height:1!important;
    opacity:.50!important;
    color:#fff7d9!important;
    text-shadow:0 2px 0 rgba(96,33,0,.30)!important;
    z-index:5!important;
    pointer-events:none!important;
  }
  .wheelWinSpark{
    position:absolute!important;
    width:88px!important;
    height:88px!important;
    border-radius:50%!important;
    pointer-events:none!important;
    z-index:26!important;
    transform:translate(-50%,-50%) scale(.2)!important;
    opacity:0!important;
    background:radial-gradient(circle,rgba(255,255,255,.96) 0 12%,rgba(255,229,131,.78) 13% 32%,rgba(255,115,0,.22) 33% 54%,rgba(255,255,255,0) 55% 100%);
    box-shadow:0 0 18px rgba(255,223,110,.52),0 0 34px rgba(255,156,80,.32)!important;
  }
  .wheelWinSpark::before,
  .wheelWinSpark::after{
    content:""!important;
    position:absolute!important;
    inset:-12px!important;
    border-radius:50%!important;
    border:2px solid rgba(255,239,173,.66)!important;
    opacity:0!important;
  }
  .wheelWinSpark.blast{
    animation:wheelWinnerBlast .72s cubic-bezier(.12,.82,.23,1) forwards!important;
  }
  .wheelWinSpark.blast::before{
    animation:wheelWinnerRing .72s ease-out forwards!important;
  }
  .wheelWinSpark.blast::after{
    animation:wheelWinnerRing2 .72s ease-out forwards!important;
  }
  .chipField{z-index:2!important}
  #appModal .modalClose{
    width:44px!important;
    height:44px!important;
    border-radius:50%!important;
    background:linear-gradient(180deg,#fff7cf,#eda62b 58%,#8f4109)!important;
    border:1px solid rgba(255,244,188,.84)!important;
    color:transparent!important;
    font-size:0!important;
    box-shadow:0 10px 18px rgba(0,0,0,.28)!important;
  }
  #appModal .modalClose::after{
    content:"�"!important;
    display:block!important;
    font-size:24px!important;
    line-height:42px!important;
    font-weight:1000!important;
    color:#4a1800!important;
    text-align:center!important;
  }
  .playerSub{display:none!important}
  .playerCard{
    grid-template-columns:1fr!important;
    padding:8px 4px!important;
  }
  .playerAvatarShell{
    width:38px!important;
    height:38px!important;
  }
  .playerName{
    font-size:9px!important;
    color:#fff4cb!important;
  }
  @keyframes wheelGlossSweep{
    0%{transform:translateX(-8px);opacity:.45}
    50%{transform:translateX(10px);opacity:1}
    100%{transform:translateX(-8px);opacity:.45}
  }
  @keyframes wheelWinnerBlast{
    0%{transform:translate(-50%,-50%) scale(.22);opacity:0}
    18%{opacity:1}
    58%{transform:translate(-50%,-50%) scale(1.06);opacity:1}
    100%{transform:translate(-50%,-50%) scale(1.42);opacity:0}
  }
  @keyframes wheelWinnerRing{
    0%{transform:scale(.18);opacity:1}
    100%{transform:scale(1.38);opacity:0}
  }
  @keyframes wheelWinnerRing2{
    0%{transform:scale(.12);opacity:.92}
    100%{transform:scale(1.74);opacity:0}
  }</style>
</head>
<body class="gf-popup-{{ $gameTheme['popup_theme'] ?? 'popup_01' }} gf-item-{{ $gameTheme['item_theme'] ?? 'default' }}">
<div id="viewport">
  <div id="stageWrap">
    <div id="stage">
      <div class="orb a"></div><div class="orb b"></div><div class="orb c"></div>
      <div class="spark" style="left:62px;top:54px;width:30px;height:30px;animation-delay:.4s"></div>
      <div class="spark" style="left:104px;top:308px;width:18px;height:18px;animation-delay:1.2s"></div>
      <div class="spark" style="right:98px;top:92px;width:26px;height:26px;animation-delay:1.7s"></div>
      <div class="spark" style="right:76px;top:244px;width:18px;height:18px;animation-delay:.7s"></div>
      <div class="topRow">
        <div class="midTop">
          <div class="latencyPill" aria-label="Live latency">
            <span class="latencyDot" id="latencyDot"></span>
            <span class="pillValue" id="latencyText">--</span>
            <span class="pillUnit">ms</span>
          </div>
          <div class="roundPill" aria-label="Current round">
            <span class="pillLabel">R</span>
            <b id="roundNo" class="pillValue">--</b>
          </div>
        </div>
        <div class="dockRight">
          <button class="menuBtn" id="historyBtn" type="button" aria-label="Trend" title="Trend">
            <span class="menuIcon" aria-hidden="true">
              <svg class="menuSvg menuSvgTrend" viewBox="0 0 24 24" focusable="false" aria-hidden="true">
                <defs>
                  <linearGradient id="trendStroke" x1="3" y1="21" x2="21" y2="3" gradientUnits="userSpaceOnUse">
                    <stop offset="0" stop-color="#4dd6ff"/>
                    <stop offset=".55" stop-color="#8f66ff"/>
                    <stop offset="1" stop-color="#ffd76f"/>
                  </linearGradient>
                </defs>
                <path d="M5 16.5 9.4 12l3 2.7 6.6-7.2" fill="none" stroke="url(#trendStroke)" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.35"/>
                <circle cx="5" cy="16.5" r="1.55" fill="#54deff"/>
                <circle cx="9.4" cy="12" r="1.55" fill="#7f7cff"/>
                <circle cx="12.4" cy="14.7" r="1.55" fill="#c86cff"/>
                <circle cx="19" cy="7.5" r="1.55" fill="#ffd66a"/>
              </svg>
            </span>
            <span class="menuText">Trend</span>
          </button>
          <button class="menuBtn" id="winnersBtn" type="button" aria-label="Winners" title="Winners"><span class="menuIcon">&#9733;</span><span class="menuText">Winner</span></button>
          <button class="menuBtn userMenuBtn" id="userBtn" type="button" aria-label="Active users" title="Active users">
            <span class="menuIcon" aria-hidden="true">
              <svg class="menuSvg menuSvgUser" viewBox="0 0 24 24" focusable="false" aria-hidden="true">
                <defs>
                  <linearGradient id="userFill" x1="4" y1="20" x2="20" y2="4" gradientUnits="userSpaceOnUse">
                    <stop offset="0" stop-color="#68ffe7"/>
                    <stop offset=".55" stop-color="#63b4ff"/>
                    <stop offset="1" stop-color="#8d67ff"/>
                  </linearGradient>
                </defs>
                <circle cx="12" cy="8.1" r="3.15" fill="url(#userFill)"/>
                <path d="M6.2 18.1c.95-2.55 3.2-4.05 5.8-4.05s4.85 1.5 5.8 4.05" fill="none" stroke="url(#userFill)" stroke-linecap="round" stroke-width="2.4"/>
              </svg>
            </span>
            <span class="menuText">Users</span>
            <span class="activeCount" id="activeUserCount">0</span>
          </button>
          <button class="menuBtn" id="infoBtn" type="button" aria-label="Info" title="Info">
            <span class="menuIcon" aria-hidden="true">
              <svg class="menuSvg menuSvgInfo" viewBox="0 0 24 24" focusable="false" aria-hidden="true">
                <defs>
                  <linearGradient id="infoStroke" x1="4" y1="20" x2="20" y2="4" gradientUnits="userSpaceOnUse">
                    <stop offset="0" stop-color="#68f3ff"/>
                    <stop offset=".52" stop-color="#4f8dff"/>
                    <stop offset="1" stop-color="#6a5bff"/>
                  </linearGradient>
                </defs>
                <circle cx="12" cy="12" r="7.15" fill="none" stroke="url(#infoStroke)" stroke-width="2.2"/>
                <circle cx="12" cy="8" r="1.25" fill="#aef7ff"/>
                <path d="M12 10.9v5" fill="none" stroke="#d7f8ff" stroke-linecap="round" stroke-width="2.2"/>
              </svg>
            </span>
            <span class="menuText">Info</span>
          </button>
          <button class="menuBtn" id="soundBtn" type="button" aria-label="Sound" title="Sound"><span class="menuIcon" id="soundIcon">&#9835;</span><span class="menuText">Sound</span></button>
          <button class="menuBtn" id="settingsBtn" type="button" aria-label="Setting" title="Setting" onclick="if(window.__codexFruitLoopOpenSettingsInline){ window.__codexFruitLoopOpenSettingsInline(event); } return false;">
            <span class="menuIcon" aria-hidden="true">
              <svg class="menuSvg menuSvgSettings" viewBox="0 0 24 24" focusable="false" aria-hidden="true">
                <defs>
                  <linearGradient id="settingsStroke" x1="4" y1="20" x2="20" y2="4" gradientUnits="userSpaceOnUse">
                    <stop offset="0" stop-color="#ffd15e"/>
                    <stop offset=".55" stop-color="#ff8e4d"/>
                    <stop offset="1" stop-color="#ff5f8f"/>
                  </linearGradient>
                </defs>
                <path d="m12 5.2 1.25.32.72 1.55 1.7.38 1.3-.98 1.1.96-.36 1.58 1.02 1.42 1.56.44v1.36l-1.56.44-1.02 1.42.36 1.58-1.1.96-1.3-.98-1.7.38-.72 1.55-1.25.32-1.25-.32-.72-1.55-1.7-.38-1.3.98-1.1-.96.36-1.58-1.02-1.42-1.56-.44v-1.36l1.56-.44 1.02-1.42-.36-1.58 1.1-.96 1.3.98 1.7-.38.72-1.55L12 5.2Z" fill="none" stroke="url(#settingsStroke)" stroke-linejoin="round" stroke-width="1.6"/>
                <circle cx="12" cy="12" r="2.45" fill="none" stroke="#fff0c2" stroke-width="1.8"/>
              </svg>
            </span>
            <span class="menuText">Setting</span>
          </button>
        </div>
      </div>
      <style id="fruits-loop-wheel-final-fix">
        #stage{--fl-wheel-fix-size:min(70vw,304px)}
        #stage #wheelZone{
          position:absolute!important;
          left:50%!important;
          top:96px!important;
          transform:translateX(-50%)!important;
          width:var(--fl-wheel-fix-size)!important;
          height:calc(var(--fl-wheel-fix-size) + 58px)!important;
          display:grid!important;
          place-items:start center!important;
          overflow:visible!important;
          z-index:12!important;
          filter:drop-shadow(0 22px 34px rgba(0,0,0,.42)) drop-shadow(0 0 18px rgba(255,210,90,.14))!important;
        }
        #stage #wheelBackdrop,
        #stage #wheelTitle,
        #stage #wheelAura,
        #stage #wheelRays,
        #stage #wheelGlow,
        #stage #wheelScan,
        #stage #wheelHaloRing{
          display:none!important;
        }
        #stage #wheelShell{
          position:relative!important;
          left:auto!important;
          top:0!important;
          transform:none!important;
          width:var(--fl-wheel-fix-size)!important;
          height:var(--fl-wheel-fix-size)!important;
          padding:0!important;
          margin:0 auto!important;
          border-radius:50%!important;
          background:none!important;
          box-shadow:none!important;
          overflow:visible!important;
          isolation:isolate!important;
        }
        #stage #wheelShell::before,
        #stage #wheelShell::after{
          display:none!important;
          content:none!important;
        }
        #stage #wheelWindow{
          display:block!important;
          position:absolute!important;
          left:0!important;
          top:0!important;
          transform:none!important;
          width:100%!important;
          height:100%!important;
          border-radius:50%!important;
          overflow:hidden!important;
          background:none!important;
          box-shadow:none!important;
          clip-path:circle(49.9% at 50% 50%)!important;
          -webkit-clip-path:circle(49.9% at 50% 50%)!important;
        }
        #stage #wheelRotator{
          display:block!important;
          position:absolute!important;
          inset:0!important;
          width:100%!important;
          height:100%!important;
          left:0!important;
          top:0!important;
          transform-origin:50% 50%!important;
          will-change:transform!important;
        }
        #stage #wheelFace{
          display:block!important;
          position:absolute!important;
          inset:0!important;
          border-radius:50%!important;
          overflow:hidden!important;
          background:url('{{ $wheelFaceAsset }}') center/cover no-repeat!important;
          box-shadow:inset 0 0 0 4px rgba(255,241,186,.92),inset 0 0 0 12px rgba(78,43,113,.82),0 14px 24px rgba(0,0,0,.32)!important;
        }
        #stage #wheelFace::before{
          content:""!important;
          display:block!important;
          position:absolute!important;
          inset:0!important;
          border-radius:50%!important;
          background:repeating-conic-gradient(from 0deg,rgba(255,255,255,.18) 0deg 1deg,transparent 1deg 60deg),radial-gradient(circle at 34% 22%,rgba(255,255,255,.20),transparent 18%),radial-gradient(circle at 50% 116%,rgba(0,0,0,.18),transparent 36%)!important;
        }
        #stage #wheelFace::after{
          content:""!important;
          display:block!important;
          position:absolute!important;
          inset:14px!important;
          border-radius:50%!important;
          border:1px solid rgba(255,255,255,.18)!important;
          box-shadow:inset 0 0 18px rgba(0,0,0,.22)!important;
          background:transparent!important;
        }
        #stage .sectorLine{display:block!important}
        #stage .wheelFruit{display:flex!important}
        #stage #wheelCenter{
          display:block!important;
          width:calc(var(--fl-wheel-fix-size) * .24)!important;
          height:calc(var(--fl-wheel-fix-size) * .24)!important;
          margin-left:calc(var(--fl-wheel-fix-size) * -.12)!important;
          margin-top:calc(var(--fl-wheel-fix-size) * -.12)!important;
          z-index:8!important;
        }
        #stage #wheelCenterLogo{
          display:block!important;
          position:absolute!important;
          left:50%!important;
          top:50%!important;
          width:32%!important;
          height:32%!important;
          transform:translate(-50%,-50%)!important;
          object-fit:contain!important;
          z-index:18!important;
          pointer-events:none!important;
          filter:drop-shadow(0 8px 10px rgba(0,0,0,.28))!important;
        }
        #stage #pointer{
          display:block!important;
          position:absolute!important;
          left:50%!important;
          top:-10px!important;
          transform:translateX(-50%)!important;
          width:58px!important;
          height:92px!important;
          background:url('{{ $wheelPointerAsset }}') center top/contain no-repeat!important;
          z-index:30!important;
          pointer-events:none!important;
          filter:drop-shadow(0 10px 14px rgba(0,0,0,.32)) drop-shadow(0 0 10px rgba(255,214,93,.24))!important;
        }
        #stage #pointerGem,
        #stage #pointerArrow,
        #stage #pointerFlash,
        #stage #wheelShell .flWheelCover,
        #stage #wheelRotator .flWheelCover,
        #stage #wheelShell .flWheelBadge{
          display:none!important;
        }
        @media (max-height: 720px){
          #stage{--fl-wheel-fix-size:min(62vw,250px)}
          #stage #wheelZone{
            top:110px!important;
            height:calc(var(--fl-wheel-fix-size) + 46px)!important;
          }
        }
        @media (min-height: 820px){
          #stage{--fl-wheel-fix-size:min(72vw,314px)}
          #stage #wheelZone{
            top:92px!important;
            height:calc(var(--fl-wheel-fix-size) + 60px)!important;
          }
        }
      </style>
      <div id="wheelZone">
        <img id="wheelBackdrop" src="{{ $wheelBackdropAsset }}" alt="" aria-hidden="true">
        <div id="wheelShell">
          <div id="wheelTitle" class="purplePill">Fruits Loop</div>
          <div id="wheelAura"></div>
          <div id="wheelRays"></div>
          <div id="wheelGlow"></div>
          <div id="wheelWindow">
            <div id="wheelScan"></div>
            <div id="wheelHaloRing"></div>
            <div id="wheelRotator">
              <div id="wheelFace">
                <div class="sectorLine l0"></div><div class="sectorLine l1"></div><div class="sectorLine l2"></div><div class="sectorLine l3"></div><div class="sectorLine l4"></div><div class="sectorLine l5"></div>
                @foreach($wheelPots as $pot)
                  <div class="wheelFruit wf{{ $loop->index }}" data-pot-board="{{ $pot['key'] }}">{!! $pot['icon'] !!}</div>
                @endforeach
                <div id="wheelCenter"></div>
              </div>
              <img id="wheelCover" src="{{ $wheelCoverAsset }}" alt="" aria-hidden="true">
            </div>
          </div>
          <img id="wheelCenterLogo" src="{{ $wheelCenterLogoAsset }}" alt="" aria-hidden="true">
        </div>
        <div id="pointer"><div id="pointerGem"></div><div id="pointerArrow"></div><div id="pointerFlash"></div></div>
      </div>
      <div id="timer"><div id="timerPulse"></div><span id="countNum">--</span></div>
      <div id="statusBar">Connecting</div>
      <div id="winnerBanner">Winner</div>
      <div id="board">
        @foreach($boards as $board)
          <div class="betFruit">{!! $board['icon'] !!}</div>
        @endforeach
        @foreach($boards as $board)
          <button class="betBox {{ $board['class'] }}" id="box-{{ $board['key'] }}" type="button" data-board="{{ $board['key'] }}">
            <div class="boxInnerFrame"></div>
            <div class="potText"><span class="boardStatLabel">Total</span><span class="potValue" id="pool-{{ $board['key'] }}">0</span></div>
            <div class="combo"><div class="fruitBadge">{!! $board['icon'] !!}</div></div>
            <div class="chipField"></div>
            <div class="youText"><span class="boardStatLabel">You</span><span class="youValue" id="mine-{{ $board['key'] }}">0</span></div>
            <div class="multText">X{{ $board['multiplier'] }}</div>
          </button>
        @endforeach
      </div>
      <div id="bottomBar">
        <div id="balancePill">
          <div id="balanceIcon">$</div>
          <div id="balanceValue">0</div>
        </div>
        <div id="chipDock">
          @foreach($chipValues as $chipValue)
            <button class="chipBtn {{ $chipClasses[$chipValue] ?? 'chip1k' }}{{ $chipValue === 1000 ? ' active' : '' }}" type="button" data-value="{{ $chipValue }}" aria-label="{{ number_format($chipValue) }}" style="--chip-art-index: {{ $chipArtIndex[$chipValue] ?? 0 }}">{{ number_format($chipValue) }}</button>
          @endforeach
          <div id="winnerHistory" aria-label="Last 15 round winners" style="display:none">
            <div class="historyTitle">Last 15</div>
            <div id="winnerHistoryList"></div>
          </div>
          <button class="controlChipBtn" id="trendBtn" type="button" aria-label="Trend" title="Trend"><span class="trendBars" aria-hidden="true"><i></i><i></i><i></i></span></button>
        </div>
      </div>
      <div id="toast">Connecting live room</div>
      <div class="winPopup" id="winPopup" aria-hidden="true">
        <div class="winPopupCard">
          <div class="winPopupIcon" id="winPopupIcon">&#127822;</div>
          <div class="winPopupCopy">
            <div class="winPopupKicker" id="winPopupKicker">Winner</div>
            <div class="winPopupTitle" id="winPopupTitle">Fruits Loop</div>
            <div class="winPopupMeta" id="winPopupMeta">Result ready</div>
          </div>
        </div>
      </div>
      <div class="appModal" id="appModal">
        <div class="modalCard">
          <div class="modalHead">
            <h3 id="modalTitle">Fruits Loop</h3>
            <button class="modalClose" id="modalClose" type="button">X</button>
          </div>
          <div class="modalBody" id="modalBody"></div>
          <div class="modalFooter">Powerd by JAMBOai</div>
        </div>
      </div>
    </div>
  </div>
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
  userId: @json($displayUserId ?? auth()->id() ?? request()->get('user_id')),
  userName: @json($displayUserName ?? 'Player'),
  rules: {
    maxDistinctBoards: @json((int) ($gameRules['max_distinct_boards_per_user'] ?? count($boards))),
    boardCount: @json((int) ($gameRules['board_count'] ?? count($boards))),
    betDurationSec: @json((int) ($gameRules['bet_duration_sec'] ?? 20))
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
  const boards = @json($boards);
  const boardAliasMap = @json($boardAliasMap);
  const loopInfoCopy = @json($loopInfoCopy);
  const visualFruitMeta = @json($visualFruitMeta);
  const keys = @json($boardKeys);
  const wheelPots = @json(array_map(function ($pot) { return $pot['key']; }, $wheelPots));
  const refs = {
    stage: document.getElementById('stage'),
    balance: document.getElementById('balanceValue'),
    balancePill: document.getElementById('balancePill'),
    round: document.getElementById('roundNo'),
    phase: document.getElementById('statusBar'),
    timerShell: document.getElementById('timer'),
    timer: document.getElementById('countNum'),
    network: document.getElementById('latencyText'),
    latencyDot: document.getElementById('latencyDot'),
    wheel: document.getElementById('wheelRotator'),
    wheelShell: document.getElementById('wheelShell'),
    wheelZone: document.getElementById('wheelZone'),
    pointer: document.getElementById('pointer'),
    winnerBanner: document.getElementById('winnerBanner'),
    winnerHistoryList: document.getElementById('winnerHistoryList'),
    toast: document.getElementById('toast'),
    modal: document.getElementById('appModal'),
    modalCard: document.querySelector('#appModal .modalCard'),
    modalTitle: document.getElementById('modalTitle'),
    modalBody: document.getElementById('modalBody'),
    modalClose: document.getElementById('modalClose'),
    winPopup: document.getElementById('winPopup'),
    winPopupIcon: document.getElementById('winPopupIcon'),
    winPopupKicker: document.getElementById('winPopupKicker'),
    winPopupTitle: document.getElementById('winPopupTitle'),
    winPopupMeta: document.getElementById('winPopupMeta'),
    settingsBtn: document.getElementById('settingsBtn'),
    historyBtn: document.getElementById('historyBtn'),
    winnersBtn: document.getElementById('winnersBtn'),
    infoBtn: document.getElementById('infoBtn'),
    soundBtn: document.getElementById('soundBtn'),
    soundIcon: document.getElementById('soundIcon'),
    userBtn: document.getElementById('userBtn'),
    trendBtn: document.getElementById('trendBtn'),
    activeUserCount: document.getElementById('activeUserCount'),
    boardEls: {},
    pools: {},
    mines: {},
    chips: Array.from(document.querySelectorAll('.chipBtn'))
  };
  keys.forEach((key) => {
    refs.boardEls[key] = document.querySelector(`[data-board="${key}"]`);
    refs.pools[key] = document.getElementById(`pool-${key}`);
    refs.mines[key] = document.getElementById(`mine-${key}`);
  });
  let selectedChip = 1000;
  let lastPayload = null;
  let roundNo = '';
  let refreshInFlight = false;
  let requestCounter = 0;
  let wheelTurns = 0;
  let toastTimer = null;
  let statusTimer = null;
  let disposed = false;
  let refreshTimer = null;
  let heartbeatTimer = null;
  let uiTimer = null;
  let activeUserTimer = null;
  let serverClockOffset = 0;
  let lastWinnerKey = '';
  let displayedWinnerKey = '';
  let revealWinnerTimer = null;
  let wheelRevealPending = false;
  let wheelStateHydrated = false;
  let stateRefreshQueued = false;
  let stateRefreshPromise = null;
  let chipSeededRound = '';
  let boardHistoryRows = [];
  let userHistoryRows = [];
  let activePlayerRows = [];
  let historySyncInFlight = false;
  let lastHistorySyncRound = '';
  let displayedBalanceValue = null;
  let lastAnimatedPayoutKey = '';
  let activePayoutAnimationKey = '';
  let lastWinnerPopupKey = '';
  let lastTotalFlyKey = '';
  let lastPhaseBannerKey = '';
  let phaseBannerHideTimer = null;
  let soundEnabled = true;
  let lastBetCountdownSecond = null;
  let audioCtx = null;
  let audioBootstrapped = false;
  let musicLevel = clampPercent((() => { try { return window.localStorage.getItem('fruitsLoopMusicLevel'); } catch (error) { return 74; } })(), 74);
  let soundEffectLevel = clampPercent((() => { try { return window.localStorage.getItem('fruitsLoopSoundEffectLevel'); } catch (error) { return 82; } })(), 82);
  if(musicLevel < 1) musicLevel = 74;
  if(soundEffectLevel < 1) soundEffectLevel = 82;
  let wheelAnimationFrame = null;
  let wheelAnimationToken = 0;
  let wheelSpinTimer = null;
  let wheelCruiseActive = false;

  function clampPercent(value, fallback = 80){
    const numberValue = Number(value);
    return Number.isFinite(numberValue) ? Math.max(0, Math.min(100, Math.round(numberValue))) : fallback;
  }
  function number(value){
    const numberValue = Number(value || 0);
    return Number.isFinite(numberValue) ? String(Math.round(numberValue)) : '0';
  }
  function escapeHtml(value){ return String(value == null ? '' : value).replace(/[&<>"']/g, (char) => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[char])); }
  function savePreference(key, value){ try { window.localStorage.setItem(key, String(value)); } catch (error) {} }
  function fitAmountLabel(el){
    if(!el) return;
    el.style.transform = '';
    el.style.fontSize = '';
    const parent = el.parentElement;
    const available = parent ? Math.max(20, parent.clientWidth - (el.offsetLeft || 0) - 4) : 0;
    if(!available || el.scrollWidth <= available) return;
    const computed = window.getComputedStyle(el);
    const size = Number.parseFloat(computed.fontSize || '14') || 14;
    const nextSize = Math.max(9, Math.floor(size * (available / Math.max(1, el.scrollWidth))));
    el.style.fontSize = `${nextSize}px`;
  }
  function setMoneyText(el, value){
    if(!el) return;
    const text = number(value);
    el.textContent = text;
    el.title = text;
    if (window.requestAnimationFrame) {
      requestAnimationFrame(() => fitAmountLabel(el));
    } else {
      fitAmountLabel(el);
    }
  }
  function chipText(value){ return number(value); }
  function chipClass(value){ value = Number(value || 0); return value >= 100000 ? 'chip100k' : value >= 50000 ? 'chip50k' : value >= 10000 ? 'chip10k' : value >= 1000 ? 'chip1k' : 'chip500'; }
  function show(message, hold = 3200){ refs.toast.textContent = message; refs.toast.classList.add('show'); if(toastTimer) clearTimeout(toastTimer); toastTimer = setTimeout(() => refs.toast.classList.remove('show'), hold); }
  function showStatus(message, hold = 1600){ refs.phase.textContent = message; refs.phase.classList.add('show'); if(statusTimer) clearTimeout(statusTimer); statusTimer = setTimeout(() => refs.phase.classList.remove('show'), hold); }
  function modalRow(label, value){ return `<div class="modalRow"><span>${escapeHtml(label)}</span><b>${escapeHtml(value)}</b></div>`; }
  function modalRowHtml(label, valueHtml){ return `<div class="modalRow"><span>${escapeHtml(label)}</span><b>${valueHtml}</b></div>`; }
  function modalHero(icon, title, text){ return `<div class="modalHero"><div class="modalHeroIcon">${icon}</div><div><b>${escapeHtml(title)}</b><span>${escapeHtml(text)}</span></div></div>`; }
  function modalTile(label, value){ return `<div class="modalTile"><span>${escapeHtml(label)}</span><b>${escapeHtml(value)}</b></div>`; }
  function normalizeBoardKey(key){
    const raw = String(key || '').trim().toLowerCase();
    if(boardAliasMap[raw]) return boardAliasMap[raw];
    return raw;
  }
  function normalizeHistoryBoardKey(key){
    const raw = String(key || '').trim().toLowerCase();
    if(boards[raw]) return raw;
    return normalizeBoardKey(raw);
  }
  function boardName(key){
    const normalized = normalizeBoardKey(key);
    return boards[normalized] ? boards[normalized].name : (normalized || '-');
  }
  function boardDisplayName(key){
    return boards[key] ? boards[key].name : boardName(key);
  }
  function boardIcon(key){
    const normalized = normalizeBoardKey(key);
    return boards[normalized] ? boards[normalized].icon : '?';
  }
  function boardDisplayIcon(key){
    return boards[key] ? boards[key].icon : boardIcon(key);
  }
  function playerDisplayName(item){ return String(item && (item.name || item.user_name || item.username || item.id || 'Player') || 'Player'); }
  function playerImageUrl(item){ return String(item && (item.image || item.avatar || item.profile_photo_url || item.user_image || item.photo || item.photo_url) || ''); }
  function playerInitials(name){ return String(name || 'P').split(/\s+/).filter(Boolean).slice(0,2).map((part) => part.charAt(0).toUpperCase()).join('') || 'P'; }
  function silenceLoopRoomAudio(permanent = false){
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
      if(permanent){
        audioCtx = null;
        audioBootstrapped = false;
      }
    }
  }
  function winnerKeyFromHistoryItem(item){ return normalizeHistoryBoardKey(item && (item.winner_board_key || item.winner_board || item.board_key)); }
  function setBoardHistoryRows(rows){
    const validKeys = new Set(keys);
    boardHistoryRows = (Array.isArray(rows) ? rows : []).filter((item) => validKeys.has(winnerKeyFromHistoryItem(item))).slice(0, 15);
    renderWinnerHistoryStrip();
  }
  function renderWinnerHistoryStrip(){
    if(!refs.winnerHistoryList) return;
    const dots = boardHistoryRows.slice(0, 15).map((item) => {
      const key = winnerKeyFromHistoryItem(item);
      const board = boards[key] || {};
      const round = item && (item.round_short || item.round_no || item.round_id) || '';
      const title = `${board.name || key}${round ? ` - ${round}` : ''}`;
      return `<span class="winnerDot ${escapeHtml(key)}" title="${escapeHtml(title)}">${board.icon || '?'}</span>`;
    });
    while(dots.length < 15){
      dots.push('<span class="winnerDot empty" aria-hidden="true">.</span>');
    }
    refs.winnerHistoryList.innerHTML = dots.join('');
    const historyWrap = document.getElementById('winnerHistory');
    if(historyWrap){
      historyWrap.style.display = dots.length ? 'flex' : 'none';
    }
  }
  function closeModal(){
    refs.modal.classList.remove('is-open');
    refs.modal.hidden = true;
    refs.modal.setAttribute('aria-hidden', 'true');
    refs.modal.style.setProperty('display', 'none', 'important');
  }
  function openModal(title, html, panel = 'generic'){
    refs.modalTitle.textContent = title;
    refs.modalBody.innerHTML = html;
    refs.modal.dataset.panel = panel;
    refs.modalBody.dataset.panel = panel;
    if(refs.modalCard) refs.modalCard.dataset.panel = panel;
    refs.modal.hidden = false;
    refs.modal.setAttribute('aria-hidden', 'false');
    refs.modal.style.setProperty('display', 'flex', 'important');
    refs.modal.classList.remove('is-open');
    void refs.modal.offsetWidth;
    refs.modal.classList.add('is-open');
      const stageRect = refs.stage.getBoundingClientRect();
      for(let i = 0; i < 8; i++) createTrailSpark(stageRect.width / 2 + (Math.random() * 90 - 45), stageRect.height / 2 + (Math.random() * 90 - 45), .7 + Math.random() * .6);
  }
  function renderHistoryHtml(){
    const sourceRows = boardHistoryRows.length ? boardHistoryRows : (lastPayload && Array.isArray(lastPayload.recent) ? lastPayload.recent : []);
    const rows = sourceRows.slice(0, 10);
    const trendBoardCount = Math.max(1, keys.length);
    const trendHeader = keys.map((key) => `<div class="trendBoardLabel">${escapeHtml(boardDisplayName(key))}</div>`).join('');
    const trendRows = rows.length ? rows.map((item, index) => {
      const key = winnerKeyFromHistoryItem(item);
      const title = `${boardDisplayName(key)} won${index === 0 ? ' latest round' : ''}`;
      const cells = keys.map((boardKey) => {
        const isWinner = boardKey === key;
        const boardTitle = boardDisplayName(boardKey);
        return `<div class="trendBoardCell${isWinner ? ' has-token' : ''}" title="${escapeHtml(isWinner ? title : boardTitle)}">${isWinner ? `<span class="trendToken ${escapeHtml(boardKey)}" aria-label="${escapeHtml(title)}">${boardDisplayIcon(boardKey)}</span>` : ''}</div>`;
      }).join('');
      return `<div class="trendBoardRow${index === 0 ? ' is-new' : ''}" aria-label="${escapeHtml(title)}">${cells}</div>`;
    }).join('') : '<div class="playerEmpty trendEmpty">Trend will appear after the next few rounds.</div>';
    return `<div class="panelCanvas"><div class="trendPanel trendBoardTable" style="--trend-board-count:${trendBoardCount}"><div class="trendNew">NEW</div><div class="trendBoardHead">${trendHeader}</div>${trendRows}</div></div>`;
  }
  async function refreshHistoryTables(force = false){
    if(historySyncInFlight || !(window.BDGameFinal && window.BD_GAME_BOOTSTRAP)) return;
    if(!force && boardHistoryRows.length && userHistoryRows.length) return;
    historySyncInFlight = true;
    try {
      const [historyPayload, myBetsPayload] = await Promise.all([
        window.BDGameFinal.get(window.BD_GAME_BOOTSTRAP.endpoints.history, {}),
        window.BDGameFinal.get(window.BD_GAME_BOOTSTRAP.endpoints.myBets, {})
      ]);
      const historyGameCode = String((historyPayload && historyPayload.game_code) || (myBetsPayload && myBetsPayload.game_code) || '');
      if(historyGameCode && historyGameCode !== String(window.BD_GAME_BOOTSTRAP.gameCode || '')){
        setBoardHistoryRows([]);
        userHistoryRows = [];
        activePlayerRows = [];
        return;
      }
      setBoardHistoryRows(historyPayload && (historyPayload.board_history || historyPayload.recent));
      userHistoryRows = Array.isArray(myBetsPayload && (myBetsPayload.bet_history || myBetsPayload.history)) ? (myBetsPayload.bet_history || myBetsPayload.history) : [];
      activePlayerRows = Array.isArray((myBetsPayload && myBetsPayload.active_players) || (historyPayload && historyPayload.active_players)) ? ((myBetsPayload && myBetsPayload.active_players) || (historyPayload && historyPayload.active_players)) : [];
      window.activePlayers = activePlayerRows;
      const validKeys = new Set(keys);
      userHistoryRows = userHistoryRows.filter((item) => validKeys.has(normalizeBoardKey(item && (item.board_key || item.frontend_board_key || item.canonical_board_key) || '')));
    } catch (error) {
      boardHistoryRows = boardHistoryRows || [];
      userHistoryRows = userHistoryRows || [];
      activePlayerRows = activePlayerRows || [];
    } finally {
      historySyncInFlight = false;
    }
  }
  async function openHistory(){
    openModal('Trend', '<div class="panelCanvas"><div class="playerEmptyState"><div class="playerEmptyText">Loading trend...</div></div></div>', 'trend');
    await refreshHistoryTables(true);
    refs.modalBody.innerHTML = renderHistoryHtml();
  }
  window.openFruitTrendPopup = openHistory;
  function openWinners(){
    const rows = boardHistoryRows.length ? boardHistoryRows : (lastPayload && Array.isArray(lastPayload.recent) ? lastPayload.recent : []);
    const winners = rows.length ? `<div class="modalTableWrap"><table class="modalTable"><thead><tr><th>Round</th><th>Winner Item</th><th>Payout</th></tr></thead><tbody>${rows.slice(0, 15).map((item) => {
      const key = winnerKeyFromHistoryItem(item);
      return `<tr><td>${escapeHtml(item && (item.round_no || item.round_id) || '-')}</td><td>${boardIcon(key)} ${escapeHtml(boardName(key))}</td><td>X${escapeHtml(boards[key] && boards[key].multiplier || '-')}</td></tr>`;
    }).join('')}</tbody></table></div>` : '<div class="emptyMsg">Winners will appear after the next result</div>';
    openModal('Winner Room', `${modalHero('&#9733;', 'Last Winning Items', 'Fruit items glow here after every reveal.')}${winners}`);
  }
  function openSettings(){
    openModal('Settings', [
      '<div class="panelCanvas settings">',
      '<div class="settingsGhostTitle">Fruits Loop</div>',
      '<div class="settingToggleRow"><span class="settingLabel">Sound</span><button class="soundStateBtn' + (!soundEnabled ? ' off' : '') + '" id="settingsSoundToggle" type="button">' + (soundEnabled ? 'ON' : 'OFF') + '</button></div>',
      '<div class="settingsPanel">',
      '<div class="settingRow"><span class="settingLabel">Music</span><input class="themeRange" id="musicRange" type="range" min="0" max="100" value="' + musicLevel + '"><span class="settingValue" id="musicRangeValue">' + musicLevel + '%</span></div>',
      '<div class="settingRow"><span class="settingLabel">Sound<br>Effect</span><input class="themeRange" id="soundRange" type="range" min="0" max="100" value="' + soundEffectLevel + '"><span class="settingValue" id="soundRangeValue">' + soundEffectLevel + '%</span></div>',
      '</div>',
      '</div>'
    ].join(''), 'settings');
    const musicRange = refs.modalBody.querySelector('#musicRange');
    const soundRange = refs.modalBody.querySelector('#soundRange');
    const musicRangeValue = refs.modalBody.querySelector('#musicRangeValue');
    const soundRangeValue = refs.modalBody.querySelector('#soundRangeValue');
    const soundToggle = refs.modalBody.querySelector('#settingsSoundToggle');
    if(musicRange) musicRange.addEventListener('input', () => {
      musicLevel = clampPercent(musicRange.value, musicLevel);
      savePreference('fruitsLoopMusicLevel', musicLevel);
      if(musicRangeValue) musicRangeValue.textContent = `${musicLevel}%`;
      tone(420 + musicLevel * 3, 80, .03 + (musicLevel / 2500));
    });
    if(soundRange) soundRange.addEventListener('input', () => {
      soundEffectLevel = clampPercent(soundRange.value, soundEffectLevel);
      savePreference('fruitsLoopSoundEffectLevel', soundEffectLevel);
      if(soundRangeValue) soundRangeValue.textContent = `${soundEffectLevel}%`;
      tone(620, 90, .04 + (soundEffectLevel / 1400));
    });
    if(soundToggle) soundToggle.addEventListener('click', () => {
      toggleSound();
      soundToggle.textContent = soundEnabled ? 'ON' : 'OFF';
      soundToggle.classList.toggle('off', !soundEnabled);
    });
  }
  function openInfo(){
    openModal('Info', [
      modalHero('i', 'Fruits Loop Room', loopInfoCopy),
      '<div class="modalGrid">',
      modalTile('Round', roundNo || '--'),
      modalTile('Phase', lastPayload && lastPayload.phase || 'sync'),
      modalTile('Wheel Pots', wheelPots.length),
      modalTile('Boards', keys.length),
      '</div>',
      modalRowHtml('Items', keys.map((key) => `${boardIcon(key)} ${escapeHtml(boardName(key))}`).join(' / '))
    ].join(''));
  }
  async function openUser(){
    openModal('Player List', '<div class="playerEmpty">Loading players...</div>', 'players');
    await refreshHistoryTables(true);
    const players = Array.isArray(activePlayerRows) ? activePlayerRows : [];
    const cards = players.length ? players.map((item) => {
      const name = playerDisplayName(item);
      const image = playerImageUrl(item);
      const avatar = image ? `<img class="playerAvatar" src="${escapeHtml(image)}" alt="${escapeHtml(name)}">` : `<div class="playerAvatar fallback">${escapeHtml(playerInitials(name))}</div>`;
      return `<article class="playerCard"><div class="playerAvatarShell">${avatar}</div><div class="playerMeta"><div class="playerName">${escapeHtml(name)}</div></div></article>`;
    }).join('') : '<div class="playerEmpty">Players will appear here as soon as the room syncs active users.</div>';
    refs.modalBody.innerHTML = `<div class="panelCanvas"><div class="playerGrid">${cards}</div></div>`;
  }
  window.codexFruitLoopOpenWinners = openWinners;
  window.codexFruitLoopOpenInfo = openInfo;
  window.codexFruitLoopOpenSettings = openSettings;
  window.codexFruitLoopOpenUsers = openUser;
  function toggleSound(){
    soundEnabled = !soundEnabled;
    if(refs.soundIcon) refs.soundIcon.innerHTML = soundEnabled ? '&#9835;' : '&#9834;';
    if(soundEnabled && !audioBootstrapped){
      bootstrapAudio();
    }
    show(soundEnabled ? 'Sound on' : 'Sound muted');
  }
  function bootstrapAudio(){
    if(audioBootstrapped) return;
    const AudioContext = window.AudioContext || window.webkitAudioContext;
    if(!AudioContext) return;
    try {
      audioCtx = new AudioContext();
      if(audioCtx.state === 'suspended'){
        audioCtx.resume();
      }
      audioBootstrapped = true;
    } catch (error) {
      audioCtx = null;
    }
  }
  function tone(freq = 760, duration = 120, gain = .11){
    if(!soundEnabled || !audioCtx) return;
    try {
      const now = audioCtx.currentTime;
      const scaledGain = Math.max(0.0001, gain * Math.max(.08, soundEffectLevel / 100));
      if(audioCtx.state === 'suspended'){
        audioCtx.resume();
      }
      const osc = audioCtx.createOscillator();
      const g = audioCtx.createGain();
      osc.type = 'sine';
      osc.frequency.value = freq;
      g.gain.setValueAtTime(0.0001, now);
      g.gain.exponentialRampToValueAtTime(scaledGain, now + .015);
      g.gain.exponentialRampToValueAtTime(0.0001, now + (duration / 1000));
      osc.connect(g).connect(audioCtx.destination);
      osc.start(now);
      osc.stop(now + (duration / 1000));
      osc.onended = () => {
        g.disconnect();
        osc.disconnect();
      };
    } catch (error) {
      // keep UI running if audio cannot be created on this browser
    }
  }
  function playBetTone(remaining){
    if(!soundEnabled || !audioCtx) return;
    if(remaining <= 3 && remaining > 0){
      tone(640 + (4 - remaining) * 130, 150, .13);
      return;
    }
    if(remaining > 0 && remaining % 5 === 0){
      tone(560, 90, .06);
    }
  }
  function handleBetCountdownSound(remaining){
    if(!soundEnabled || !lastPayload || !isBettingOpen(lastPayload)){
      lastBetCountdownSecond = null;
      return;
    }
    if(!Number.isFinite(remaining) || remaining <= 0){
      lastBetCountdownSecond = null;
      return;
    }
    const currentSecond = Math.floor(remaining);
    if(currentSecond === lastBetCountdownSecond) return;
    lastBetCountdownSecond = currentSecond;
    if(!audioBootstrapped){
      bootstrapAudio();
    }
    playBetTone(currentSecond);
  }
  function winner(payload){ return normalizeBoardKey(payload && (payload.winner_board || (payload.result && payload.result.winner_board)) || ''); }
  function phaseEndAt(payload){ if(!payload) return null; if(payload.phase === 'betting') return payload.bet_close_at; if(payload.phase === 'locked') return payload.reveal_at; if(payload.phase === 'revealed') return payload.settle_at; if(payload.phase === 'settled') return payload.next_round_at; return null; }
  function serverNow(){ return Date.now() / 1000 + serverClockOffset; }
  function fruitsLoopTimings(payload){ const d = payload && payload.phase_durations ? payload.phase_durations : {}; return { startPopupMs: Math.max(0, Math.round(Number(d.start_popup || 3) * 1000)), stopPopupMs: Math.max(0, Math.round(Number(d.stop_popup || 4) * 1000)), revealMainMs: Math.max(0, Math.round(Number(d.reveal_main || 6) * 1000)), revealWaitMs: Math.max(0, Math.round(Number(d.reveal_wait || 2) * 1000)), winnerPopupMs: Math.max(0, Math.round(Number(d.winner_popup || 1) * 1000)), winnerWaitMs: Math.max(0, Math.round(Number(d.winner_wait || .5) * 1000)), payoutMs: Math.max(0, Math.round(Number(d.payout || 2.5) * 1000)), settleWaitMs: Math.max(0, Math.round(Number(d.settle_wait || 1) * 1000)) }; }
  function markerAt(payload,key){ const value = Number(payload && payload[key] || 0); return Number.isFinite(value) && value > 0 ? value : null; }
  function bettingOpensAt(payload){ return markerAt(payload,'bet_countdown_start_at'); }
  function isBettingOpen(payload){ if(!payload || payload.phase !== 'betting') return false; const opensAt = bettingOpensAt(payload); const closesAt = markerAt(payload,'bet_close_at'); const now = serverNow(); if(opensAt && now < opensAt) return false; if(closesAt && now >= closesAt) return false; return true; }
  function revealDoneAt(payload){ const direct = markerAt(payload,'reveal_done_at'); if(direct) return direct; const start = markerAt(payload,'reveal_at'); return start ? start + (fruitsLoopTimings(payload).revealMainMs / 1000) : null; }
  function winnerPopupAt(payload){ const direct = markerAt(payload,'winner_popup_at'); if(direct) return direct; const revealDone = revealDoneAt(payload); return revealDone ? revealDone + (fruitsLoopTimings(payload).revealWaitMs / 1000) : null; }
  function maxDistinct(payload){ return Math.max(1, Math.min(keys.length, Number(payload && payload.rules && payload.rules.max_distinct_boards_per_user || window.BD_GAME_BOOTSTRAP.rules.maxDistinctBoards || keys.length))); }
  function canUseBoard(payload, key){ const mine = payload && payload.my_bet_totals || {}; if(Number(mine[key] || 0) > 0) return true; return Object.values(mine).filter((value) => Number(value || 0) > 0).length < maxDistinct(payload); }
  function optimisticBetPayload(payload, key, amount, balanceValue = null){ if(!payload || !key || !Number.isFinite(Number(amount))) return null; const betAmount = Number(amount || 0); const next = Object.assign({}, payload); next.board_totals = Object.assign({}, payload.board_totals || {}); next.my_bet_totals = Object.assign({}, payload.my_bet_totals || {}); next.board_totals[key] = Number(next.board_totals[key] || 0) + betAmount; next.my_bet_totals[key] = Number(next.my_bet_totals[key] || 0) + betAmount; next.my_total_bet_amount = Number(payload.my_total_bet_amount || 0) + betAmount; next.balance = balanceValue === null ? Math.max(0, Number(payload.balance || 0) - betAmount) : Number(balanceValue || 0); return next; }
  function scaleStage(){
    const viewport = window.visualViewport || { width: window.innerWidth, height: window.innerHeight };
    refs.stage.style.transform = 'none';
    refs.stage.parentElement.style.width = `${Math.max(1, viewport.width)}px`;
    refs.stage.parentElement.style.height = `${Math.max(1, viewport.height)}px`;
  }
  function pointFor(el){
    if(!el || !refs.stage) return null;
    const stageRect = refs.stage.getBoundingClientRect();
    const rect = el.getBoundingClientRect();
    return {
      x: rect.left - stageRect.left + rect.width / 2,
      y: rect.top - stageRect.top + rect.height / 2
    };
  }
  function animateArcNode(node, options){
    const startX = Number(options.startX || 0);
    const startY = Number(options.startY || 0);
    const endX = Number(options.endX || 0);
    const endY = Number(options.endY || 0);
    const arcHeight = Number(options.arcHeight || 130);
    const duration = Math.max(1, Number(options.durationMs || 820));
    const scaleTo = Number(options.scaleTo || .72);
    const rotateTo = Number(options.rotateTo || 0);
    const startedAt = performance.now();
    function tick(now){
      const p = Math.min(1, (now - startedAt) / duration);
      const ease = 1 - Math.pow(1 - p, 3);
      const inv = 1 - ease;
      const x = inv * inv * startX + 2 * inv * ease * ((startX + endX) / 2) + ease * ease * endX;
      const y = inv * inv * startY + 2 * inv * ease * (Math.min(startY, endY) - arcHeight) + ease * ease * endY;
      const scale = 1 + ((scaleTo - 1) * ease);
      node.style.left = `${x}px`;
      node.style.top = `${y}px`;
      node.style.transform = `translate(-50%,-50%) scale(${scale}) rotate(${rotateTo * ease}deg)`;
      node.style.opacity = String(1 - Math.max(0, ease - .82) / .18);
      if(p < 1){
        requestAnimationFrame(tick);
        return;
      }
      node.remove();
      if(typeof options.onComplete === 'function') options.onComplete();
    }
    requestAnimationFrame(tick);
  }
  function setDisplayedBalance(value){
    displayedBalanceValue = Number(value || 0);
    setMoneyText(refs.balance, displayedBalanceValue);
  }
  function animateDisplayedBalance(startValue, endValue, duration = 620){
    const from = Number(startValue || 0);
    const to = Number(endValue || 0);
    if(from === to){
      setDisplayedBalance(to);
      return Promise.resolve();
    }
    const startedAt = performance.now();
    return new Promise((resolve) => {
      function tick(now){
        const p = Math.min(1, (now - startedAt) / duration);
        const current = Math.round(from + ((to - from) * p));
        setDisplayedBalance(current);
        if(p < 1){
          requestAnimationFrame(tick);
          return;
        }
        setDisplayedBalance(to);
        resolve();
      }
      requestAnimationFrame(tick);
    });
  }
  function triggerBalanceImpact(){
    if(!refs.balancePill) return;
    refs.balancePill.classList.remove('balanceImpact');
    void refs.balancePill.offsetWidth;
    refs.balancePill.classList.add('balanceImpact');
    const target = pointFor(refs.balancePill);
    if(target) createBetImpact(target.x, target.y);
  }
  function bridgeFxBudget(key, fallback){
    const api = window.BDGameFinal;
    const budget = api && typeof api.fxBudget === 'function' ? api.fxBudget() : null;
    if(budget && Number(budget[key]) > 0) return Number(budget[key]);
    const compact = document.body.classList.contains('low-end-mode') || window.innerHeight <= 520 || window.innerWidth <= 430 || (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);
    if(!compact) return fallback;
    const localBudget = { betCoins:2, betSparks:2, winCoins:4, winParticles:6 };
    return localBudget[key] || Math.min(fallback, 6);
  }
  function bridgeFxAllowed(cost){
    const api = window.BDGameFinal;
    if(document.hidden) return false;
    return !api || typeof api.canPlayFx !== 'function' || api.canPlayFx(cost);
  }
  function bridgeFxNode(node, ttl){
    const api = window.BDGameFinal;
    if(api && typeof api.registerFxNode === 'function') api.registerFxNode(node, ttl);
    return node;
  }
  function payoutKey(payload, win, amount){
    return `${payload && payload.round_no ? payload.round_no : 'na'}:${win || 'na'}:${Math.round(Number(amount || 0))}`;
  }
  function resolveWinAmount(payload, win){
    const actual = Number(payload && payload.my_total_win_amount || 0);
    if(actual > 0) return actual;
    const bet = Number(payload && payload.my_bet_totals && payload.my_bet_totals[win] || 0);
    const multiplier = Number(payload && payload.result && payload.result.multiplier || boards[win] && boards[win].multiplier || 1);
    return bet > 0 ? Math.round(bet * Math.max(1, multiplier)) : 0;
  }
  function syncBalanceDisplay(payload){
    const finalBalance = Number(payload && payload.balance || 0);
    const win = winner(payload);
    const winAmount = resolveWinAmount(payload, win);
    const resultPhase = payload && (payload.phase === 'revealed' || payload.phase === 'settled');
    const key = payoutKey(payload, win, winAmount);
    if(activePayoutAnimationKey && key === activePayoutAnimationKey) return;
    if(resultPhase && winAmount > 0 && key !== lastAnimatedPayoutKey){
      setDisplayedBalance(Math.max(0, finalBalance - winAmount));
      return;
    }
    setDisplayedBalance(finalBalance);
  }
  function runPayoutAnimation(payload, win){
    const winAmount = resolveWinAmount(payload, win);
    const finalBalance = Number(payload && payload.balance || 0);
    const key = payoutKey(payload, win, winAmount);
    if(!win || winAmount <= 0 || key === lastAnimatedPayoutKey || key === activePayoutAnimationKey){
      setDisplayedBalance(finalBalance);
      return;
    }
    const fromEl = refs.mines[win] || refs.pools[win] || refs.boardEls[win];
    const toEl = refs.balancePill || refs.balance;
    const from = pointFor(fromEl);
    const to = pointFor(toEl);
    if(!from || !to){
      animateDisplayedBalance(displayedBalanceValue == null ? Math.max(0, finalBalance - winAmount) : displayedBalanceValue, finalBalance, 620).then(triggerBalanceImpact);
      lastAnimatedPayoutKey = key;
      return;
    }
    activePayoutAnimationKey = key;
    const startBalance = displayedBalanceValue == null ? Math.max(0, finalBalance - winAmount) : displayedBalanceValue;
    if(!bridgeFxAllowed(4)) {
      animateDisplayedBalance(startBalance, finalBalance, 620).then(() => {
        triggerBalanceImpact();
        activePayoutAnimationKey = '';
        lastAnimatedPayoutKey = key;
      });
      return;
    }
    const amountGhost = bridgeFxNode(document.createElement('div'), 1100);
    amountGhost.className = 'payoutFlyAmount';
    amountGhost.textContent = `+${number(winAmount)}`;
    amountGhost.style.left = `${from.x}px`;
    amountGhost.style.top = `${from.y}px`;
    refs.stage.appendChild(amountGhost);
    const chipCount = Math.max(2, Math.min(bridgeFxBudget('winCoins', 6), Math.ceil(winAmount / 50000)));
    for(let i = 0; i < chipCount; i++){
      const chip = bridgeFxNode(document.createElement('div'), 1100);
      chip.className = `payoutChipGhost ${chipClass(winAmount)}`;
      chip.style.left = `${from.x}px`;
      chip.style.top = `${from.y}px`;
      refs.stage.appendChild(chip);
      animateArcNode(chip, {
        startX: from.x,
        startY: from.y,
        endX: to.x + ((i - (chipCount - 1) / 2) * 12),
        endY: to.y - 4 + (i * 2),
        arcHeight: 124 + (i * 9),
        durationMs: 760 + (i * 70),
        scaleTo: .5,
        rotateTo: 160 + (i * 70)
      });
    }
    let completed = false;
    const complete = () => {
      if(completed) return;
      completed = true;
      animateDisplayedBalance(startBalance, finalBalance, 620).then(() => {
        triggerBalanceImpact();
        activePayoutAnimationKey = '';
        lastAnimatedPayoutKey = key;
      });
    };
    animateArcNode(amountGhost, {
      startX: from.x,
      startY: from.y,
      endX: to.x,
      endY: to.y,
      arcHeight: 148,
      durationMs: 920,
      scaleTo: .74,
      rotateTo: 6,
      onComplete: complete
    });
  }
  function flyTotalToActiveUsers(payload, win){
    const key = `${payload && payload.round_no ? payload.round_no : 'na'}:${win || 'na'}`;
    if(key === lastTotalFlyKey) return;
    const total = Number(payload && payload.board_totals && payload.board_totals[win] || 0);
    const from = pointFor(refs.pools[win] || refs.boardEls[win]);
    const to = pointFor(refs.userBtn);
    if(!from || !to || total <= 0) return;
    lastTotalFlyKey = key;
    if(!bridgeFxAllowed(1)) return;
    const node = bridgeFxNode(document.createElement('div'), 1000);
    node.className = 'payoutFlyAmount totalFly';
    node.textContent = number(total);
    node.style.left = `${from.x}px`;
    node.style.top = `${from.y}px`;
    refs.stage.appendChild(node);
    animateArcNode(node, {
      startX: from.x,
      startY: from.y,
      endX: to.x,
      endY: to.y,
      arcHeight: 118,
      durationMs: 860,
      scaleTo: .62,
      rotateTo: -5
    });
  }
  function pulseWheelState(cls, hold = 520){
    refs.wheelZone.classList.add(cls);
    clearTimeout(pulseWheelState[cls]);
    pulseWheelState[cls] = setTimeout(() => refs.wheelZone.classList.remove(cls), hold);
  }
  function createTrailSpark(x, y, scale = 1){
    if(!bridgeFxAllowed(1)) return;
    const spark = bridgeFxNode(document.createElement('div'), 420);
    spark.className = 'chipTrailSpark';
    spark.style.left = `${x - 5}px`;
    spark.style.top = `${y - 5}px`;
    spark.style.transform = `scale(${scale})`;
    refs.stage.appendChild(spark);
    requestAnimationFrame(() => {
      spark.style.transition = 'transform .26s ease, opacity .26s ease';
      spark.style.transform = `scale(${Math.max(.22, scale * .35)})`;
      spark.style.opacity = '0';
    });
    setTimeout(() => spark.remove(), 280);
  }
  function createBetImpact(x, y){
    const sparkCount = Math.min(6, bridgeFxBudget('betSparks', 6));
    if(!bridgeFxAllowed(1 + sparkCount)) return;
    const impact = bridgeFxNode(document.createElement('div'), 700);
    impact.className = 'betImpact';
    impact.style.left = `${x}px`;
    impact.style.top = `${y}px`;
    refs.stage.appendChild(impact);
    for(let i = 0; i < sparkCount; i++){
      const spark = bridgeFxNode(document.createElement('div'), 520);
      spark.className = 'chipTrailSpark';
      spark.style.left = `${x - 6}px`;
      spark.style.top = `${y - 6}px`;
      refs.stage.appendChild(spark);
      const a = (Math.PI * 2 * i) / sparkCount + Math.random() * .3;
      const dist = 20 + Math.random() * 18;
      requestAnimationFrame(() => {
        spark.style.transition = 'left .38s ease, top .38s ease, transform .38s ease, opacity .38s ease';
        spark.style.left = `${x + Math.cos(a) * dist}px`;
        spark.style.top = `${y + Math.sin(a) * dist * .7}px`;
        spark.style.transform = 'scale(.16)';
        spark.style.opacity = '0';
      });
      setTimeout(() => spark.remove(), 420);
    }
    setTimeout(() => impact.remove(), 620);
  }
  function spawnBoxChip(key, amount, instant = false){
    const box = refs.boardEls[key];
    if(!box) return;
    const field = box.querySelector('.chipField');
    const el = document.createElement('div');
    el.className = `boxChip ${chipClass(amount)}`;
    el.textContent = chipText(amount);
    const fw = Math.max(120, field.clientWidth || 160);
    const fh = Math.max(92, field.clientHeight || 110);
    el.style.left = `${10 + Math.random() * Math.max(14, fw - 44)}px`;
    el.style.top = `${Math.max(54, fh * .46) + Math.random() * Math.max(12, fh * .20)}px`;
    if(!instant) el.classList.add('justLanded');
    field.appendChild(el);
    if(field.children.length > 28) field.removeChild(field.children[0]);
  }
  function clearBoxChips(){ keys.forEach((key) => { const field = refs.boardEls[key] && refs.boardEls[key].querySelector('.chipField'); if(field) field.innerHTML = ''; }); }
  function seedChipsForPayload(payload){
    if(!payload || chipSeededRound === payload.round_no) return;
    chipSeededRound = payload.round_no || '';
    clearBoxChips();
    keys.forEach((key) => {
      const totalAmount = Number(payload.board_totals && payload.board_totals[key] || 0);
      const total = Math.min(10, Math.ceil(totalAmount / 10000));
      for(let i = 0; i < total; i++) spawnBoxChip(key, chipValueForAmount(totalAmount), true);
      const mine = Number(payload.my_bet_totals && payload.my_bet_totals[key] || 0);
      if(mine > 0) spawnBoxChip(key, chipValueForAmount(mine), true);
    });
  }
  function chipValueForAmount(amount){
    amount = Number(amount || 0);
    if(amount >= 100000) return 100000;
    if(amount >= 50000) return 50000;
    if(amount >= 10000) return 10000;
    return 1000;
  }
  function flyChipToBox(key, amount){
    const source = refs.chips.find((chip) => Number(chip.dataset.value || 0) === amount) || refs.chips[0];
    const target = refs.boardEls[key];
    const from = pointFor(source);
    const to = pointFor(target);
    if(!from || !to) return;
    if(!bridgeFxAllowed(2)){
      spawnBoxChip(key, amount);
      return;
    }
    const fly = bridgeFxNode(document.createElement('div'), 800);
    fly.className = `flyingChip ${chipClass(amount)}`;
    fly.textContent = chipText(amount);
    const size = 34;
    const startX = from.x - size / 2;
    const startY = from.y - size / 2;
    const endX = to.x - size / 2 + (Math.random() * 70 - 35);
    const endY = to.y - size / 2 + (Math.random() * 26 - 8);
    const drift = Math.max(22, Math.min(64, Math.abs(endX - startX) * .12));
    const midX = (startX + endX) / 2 + (Math.random() > .5 ? drift : -drift);
    const midY = Math.min(startY, endY) - Math.min(156, 88 + Math.abs(endX - startX) * .16);
    const duration = 560;
    const startAt = performance.now();
    fly.style.left = `${startX}px`;
    fly.style.top = `${startY}px`;
    refs.stage.appendChild(fly);
    function tick(now){
      const p = Math.min(1, (now - startAt) / duration);
      const ease = 1 - Math.pow(1 - p, 3);
      const inv = 1 - ease;
      const x = inv * inv * startX + 2 * inv * ease * midX + ease * ease * endX;
      const y = inv * inv * startY + 2 * inv * ease * midY + ease * ease * endY;
      const tilt = -26 + ease * 44;
      const squash = p > .82 ? 1 + (p - .82) * .65 : 1;
      const scale = 1.06 - ease * .28;
      fly.style.left = `${x}px`;
      fly.style.top = `${y}px`;
      fly.style.transform = `translateZ(0) scale(${scale * squash}, ${Math.max(.76, scale - (squash - 1) * .22)}) rotate(${tilt}deg)`;
      fly.style.opacity = String(.98 - ease * .06);
      if(p < 1){
        if(p > .06) createTrailSpark(x + size * .52, y + size * .52, 1.08 - ease * .52);
        requestAnimationFrame(tick);
      } else {
        fly.remove();
        createBetImpact(endX + size * .5, endY + size * .5);
        spawnBoxChip(key, amount);
      }
    }
    requestAnimationFrame(tick);
  }
  function rewardBurst(key){
    const target = pointFor(refs.boardEls[key]);
    if(!target) return;
    const count = Math.min(18, bridgeFxBudget('winParticles', 18));
    if(!bridgeFxAllowed(count)) return;
    for(let i = 0; i < count; i++){
      const star = bridgeFxNode(document.createElement('div'), 900);
      star.className = 'chipTrailSpark';
      star.style.left = `${target.x - 6}px`;
      star.style.top = `${target.y - 6}px`;
      refs.stage.appendChild(star);
      const dx = Math.random() * 220 - 110;
      const dy = -(42 + Math.random() * 116);
      requestAnimationFrame(() => {
        star.style.transition = 'transform .78s cubic-bezier(.15,.82,.22,1), opacity .78s ease';
        star.style.transform = `translate(${dx}px, ${dy}px) scale(${0.8 + Math.random() * .7}) rotate(${Math.random() * 240 - 120}deg)`;
        star.style.opacity = '0';
      });
      setTimeout(() => star.remove(), 800);
    }
  }
  function wheelWinnerBlast(key){
    const shell = document.getElementById('wheelShell');
    if(!shell) return;
    const burstCount = Math.min(10, bridgeFxBudget('winParticles', 10));
    if(!bridgeFxAllowed(1 + burstCount)) return;
    const spark = bridgeFxNode(document.createElement('div'), 900);
    spark.className = 'wheelWinSpark';
    spark.style.left = '50%';
    spark.style.top = '52%';
    spark.setAttribute('aria-hidden', 'true');
    shell.appendChild(spark);
    requestAnimationFrame(() => spark.classList.add('blast'));
    const icon = boardIcon(key);
    for(let i = 0; i < burstCount; i++){
      const fruit = bridgeFxNode(document.createElement('div'), 1000);
      fruit.className = 'fruitConfetti';
      fruit.innerHTML = icon;
      fruit.style.left = '50%';
      fruit.style.top = '52%';
      fruit.style.setProperty('--dx', `${Math.round(Math.random() * 120 - 60)}px`);
      fruit.style.setProperty('--dy', `${Math.round(Math.random() * -92 - 12)}px`);
      fruit.style.setProperty('--rot', `${Math.round(Math.random() * 360 - 180)}deg`);
      fruit.style.setProperty('--scale', String(.44 + Math.random() * .34));
      fruit.style.setProperty('--dur', `${560 + Math.round(Math.random() * 260)}ms`);
      shell.appendChild(fruit);
      setTimeout(() => fruit.remove(), 900);
    }
    setTimeout(() => spark.remove(), 820);
  }
  function winnerTravelPathFx(key){
    const targetEl = refs.boardEls[key];
    const target = pointFor(targetEl) || { x: refs.stage.clientWidth / 2, y: refs.stage.clientHeight / 2 };
    const pointerNode = document.getElementById('flWinnerPointer') || document.getElementById('pointer') || document.getElementById('wheelShell');
    const source = pointFor(pointerNode) || { x: refs.stage.clientWidth / 2, y: Math.max(0, refs.stage.clientHeight * .18) };
    if(!refs.stage || !targetEl) return;

    const dx = target.x - source.x;
    const dy = target.y - source.y;
    const length = Math.max(36, Math.sqrt((dx * dx) + (dy * dy)));
    const angle = Math.atan2(dy, dx) * (180 / Math.PI);

    if(!bridgeFxAllowed(3)) return;
    const beam = bridgeFxNode(document.createElement('div'), 1000);
    beam.className = 'winnerPathBeam';
    beam.style.left = `${source.x}px`;
    beam.style.top = `${source.y - 5}px`;
    beam.style.width = `${length}px`;
    beam.style.transform = `rotate(${angle}deg) scaleX(.08)`;
    refs.stage.appendChild(beam);

    const orb = bridgeFxNode(document.createElement('div'), 1000);
    orb.className = 'winnerPathOrb';
    orb.style.left = `${source.x}px`;
    orb.style.top = `${source.y}px`;
    orb.style.setProperty('--dx', `${Math.round(dx)}px`);
    orb.style.setProperty('--dy', `${Math.round(dy)}px`);
    orb.style.setProperty('--dur', '700ms');
    refs.stage.appendChild(orb);

    targetEl.classList.remove('winner-travel-hit');
    void targetEl.offsetWidth;
    window.setTimeout(() => {
      targetEl.classList.add('winner-travel-hit');
      const flash = bridgeFxNode(document.createElement('div'), 1250);
      flash.className = 'winnerBoardFlash';
      flash.setAttribute('aria-hidden', 'true');
      targetEl.appendChild(flash);
      window.setTimeout(() => {
        targetEl.classList.remove('winner-travel-hit');
        if(flash.parentNode){ flash.parentNode.removeChild(flash); }
      }, 1220);
    }, 420);

    window.setTimeout(() => {
      if(beam.parentNode){ beam.parentNode.removeChild(beam); }
      if(orb.parentNode){ orb.parentNode.removeChild(orb); }
    }, 980);
  }
  function winnerItemBlast(key, amount){
    const target = pointFor(refs.boardEls[key]) || { x: refs.stage.clientWidth / 2, y: refs.stage.clientHeight / 2 };
    const icon = boardIcon(key);
    const fruitTotal = Math.min(24, bridgeFxBudget('winParticles', 24));
    const coinTotal = Math.min(amount > 0 ? 22 : 12, bridgeFxBudget('winCoins', amount > 0 ? 22 : 12));
    if(!bridgeFxAllowed(fruitTotal + coinTotal)) return;
    for(let i = 0; i < fruitTotal; i++){
      const fruit = bridgeFxNode(document.createElement('div'), 1350);
      fruit.className = 'fruitConfetti';
      fruit.innerHTML = icon;
      fruit.style.left = `${target.x}px`;
      fruit.style.top = `${target.y}px`;
      fruit.style.setProperty('--dx', `${Math.round(Math.random() * 260 - 130)}px`);
      fruit.style.setProperty('--dy', `${Math.round(Math.random() * -190 - 32)}px`);
      fruit.style.setProperty('--rot', `${Math.round(Math.random() * 520 - 260)}deg`);
      fruit.style.setProperty('--scale', String(.65 + Math.random() * .82));
      fruit.style.setProperty('--dur', `${780 + Math.round(Math.random() * 420)}ms`);
      refs.stage.appendChild(fruit);
      setTimeout(() => fruit.remove(), 1250);
    }
    for(let i = 0; i < coinTotal; i++){
      const coin = bridgeFxNode(document.createElement('div'), 1400);
      coin.className = 'winnerCoin';
      coin.style.left = `${target.x}px`;
      coin.style.top = `${target.y}px`;
      coin.style.setProperty('--dx', `${Math.round(Math.random() * 280 - 140)}px`);
      coin.style.setProperty('--dy', `${Math.round(Math.random() * -210 - 28)}px`);
      coin.style.setProperty('--rot', `${Math.round(Math.random() * 720)}deg`);
      coin.style.setProperty('--dur', `${720 + Math.round(Math.random() * 520)}ms`);
      refs.stage.appendChild(coin);
      setTimeout(() => coin.remove(), 1300);
    }
    createBetImpact(target.x, target.y);
  }
  function showWinnerPopup(payload, win, amount){
    const popupKey = `${payload && payload.round_no ? payload.round_no : roundNo || 'na'}:${win}`;
    if(!refs.winPopup || !boards[win] || popupKey === lastWinnerPopupKey) return;
    lastWinnerPopupKey = popupKey;
    refs.winPopupIcon.innerHTML = boardIcon(win);
    refs.winPopupKicker.textContent = amount > 0 ? 'You Win' : 'Winner Item';
    refs.winPopupTitle.textContent = `${boards[win].name} X${boards[win].multiplier}`;
    refs.winPopupMeta.textContent = amount > 0 ? `Payout +${number(amount)}` : `Round ${payload && payload.round_no ? payload.round_no : roundNo || '--'}`;
    refs.winPopup.classList.remove('show');
    void refs.winPopup.offsetWidth;
    refs.winPopup.classList.add('show');
    setTimeout(() => refs.winPopup && refs.winPopup.classList.remove('show'), fruitsLoopTimings(payload).winnerPopupMs);
  }
  function normalizeDegrees(value){
    const degree = Number(value || 0) % 360;
    return degree < 0 ? degree + 360 : degree;
  }
  function angleFromTransformValue(transformValue){
    if(!transformValue || transformValue === 'none') return null;
    let match = transformValue.match(/matrix3d\(([^)]+)\)/);
    if(match){
      const parts = match[1].split(',').map((value) => Number(value.trim()));
      if(parts.length >= 16 && Number.isFinite(parts[0]) && Number.isFinite(parts[1])){
        return normalizeDegrees(Math.atan2(parts[1], parts[0]) * (180 / Math.PI));
      }
    }
    match = transformValue.match(/matrix\(([^)]+)\)/);
    if(match){
      const parts = match[1].split(',').map((value) => Number(value.trim()));
      if(parts.length >= 2 && Number.isFinite(parts[0]) && Number.isFinite(parts[1])){
        return normalizeDegrees(Math.atan2(parts[1], parts[0]) * (180 / Math.PI));
      }
    }
    match = transformValue.match(/rotate\(([-0-9.]+)deg\)/);
    if(match){
      return normalizeDegrees(Number(match[1]));
    }
    return null;
  }
  function resolveWheelNode(){
    if(!refs.wheel) return null;
    return refs.wheel;
  }
  function currentWheelAngle(){
    const wheel = resolveWheelNode();
    if(!wheel) return 0;
    const computedAngle = angleFromTransformValue(getComputedStyle(wheel).transform);
    if(computedAngle != null) return computedAngle;
    const inlineAngle = angleFromTransformValue(wheel.style.transform || '');
    if(inlineAngle != null) return inlineAngle;
    return normalizeDegrees(Number(wheel.dataset.rotation || 0));
  }
  function wheelRenderTransform(angle){
    return `translate3d(-50%,-50%,0) rotate(${angle}deg)`;
  }
  function setWheelRotation(angle, preserveTurns = false){
    const wheelNode = resolveWheelNode();
    const normalizedAngle = normalizeDegrees(angle);
    const renderAngle = preserveTurns ? Number(angle || 0) : normalizedAngle;
    if(!wheelNode) {
      if(refs.wheelShell){
        refs.wheelShell.style.setProperty('transform', 'none', 'important');
      }
      return;
    }
    wheelNode.style.setProperty('transition', 'none', 'important');
    wheelNode.style.setProperty('transform', wheelRenderTransform(renderAngle), 'important');
    if(refs.wheelShell){
      refs.wheelShell.style.setProperty('transform', 'none', 'important');
    }
    if(refs.wheel){ refs.wheel.dataset.rotation = String(normalizedAngle); }
    if(refs.wheelShell){ refs.wheelShell.dataset.rotation = '0'; }
  }
  function stopWheelAnimation(lockCurrent = false){
    const lockedAngle = lockCurrent ? currentWheelAngle() : null;
    wheelAnimationToken += 1;
    if(wheelAnimationFrame){
      cancelAnimationFrame(wheelAnimationFrame);
      wheelAnimationFrame = null;
    }
    if(wheelSpinTimer){
      clearTimeout(wheelSpinTimer);
      wheelSpinTimer = null;
    }
    wheelCruiseActive = false;
    if(refs.stage){
      refs.stage.classList.remove('fl-wheel-spinning', 'fl-wheel-settling');
    }
    if(lockCurrent && lockedAngle != null){
      setWheelRotation(lockedAngle);
    }
    if(refs.wheel){ refs.wheel.style.setProperty('transition', 'none', 'important'); }
    if(refs.wheelShell){ refs.wheelShell.style.setProperty('transition', 'none', 'important'); }
  }
  function wheelEase(progress){
    if(progress <= 0) return 0;
    if(progress >= 1) return 1;
    const accelSpan = .18;
    if(progress < accelSpan){
      const accel = progress / accelSpan;
      return 0.08 * accel * accel * accel;
    }
    const settle = (progress - accelSpan) / (1 - accelSpan);
    return 0.08 + (0.92 * (1 - Math.pow(1 - settle, 4)));
  }
  function wheelSlotFor(key){
    const target = String(key || '').toLowerCase();
    const index = wheelPots.findIndex((potKey) => String(potKey).toLowerCase() === target);
    return index >= 0 ? index : 0;
  }
  function startWheelCruise(){
    const wheelNode = resolveWheelNode();
    if(!wheelNode || wheelCruiseActive || wheelRevealPending) return;
    stopWheelAnimation(true);
    const startAngle = currentWheelAngle();
    wheelCruiseActive = true;
    refs.pointer.classList.add('spinning');
    pulseWheelState('ai-spin', 1600);
    if(refs.stage){
      refs.stage.classList.add('fl-wheel-spinning');
      refs.stage.classList.remove('fl-wheel-settling');
    }
    setWheelRotation(startAngle, true);
    void wheelNode.offsetWidth;
    wheelNode.style.setProperty('transition', 'transform 18000ms linear', 'important');
    wheelNode.style.setProperty('transform', wheelRenderTransform(startAngle + 6480), 'important');
  }
  function wheelStopAngleFor(key){
    const target = normalizeBoardKey(key);
    if (currentGameCode === 'fruits_loop_ruby' || currentGameCode === 'fruits_loop_emerald') {
      const variantStopAngles = {
        cherry: 330,
        pineapple: 210,
        grapes: 90,
      };
      if (Object.prototype.hasOwnProperty.call(variantStopAngles, target)) {
        return normalizeDegrees(variantStopAngles[target]);
      }
    }
    const orderedKeys = [];
    wheelPots.forEach((potKey) => {
      const normalized = normalizeBoardKey(potKey);
      if (normalized && !orderedKeys.includes(normalized)) {
        orderedKeys.push(normalized);
      }
    });
    const uniqueIndex = orderedKeys.indexOf(target);
    return normalizeDegrees(210 + ((uniqueIndex >= 0 ? uniqueIndex : 2) * 120));
  }
  function revealWinner(payload, win, options = {}){
    if(!payload || !win || !boards[win]) return;
    const revealPopup = options.popup !== false;
    const revealPayout = options.payout !== false;
    displayedWinnerKey = `${payload.round_no || roundNo}:${win}`;
    keys.forEach((key) => {
      const box = refs.boardEls[key];
      if(!box) return;
      box.classList.toggle('win', win === key);
      box.classList.toggle('dim', win !== key);
    });
    refs.winnerBanner.textContent = `${boards[win].name.toUpperCase()} X${boards[win].multiplier}`;
    refs.winnerBanner.classList.remove('show');
    void refs.winnerBanner.offsetWidth;
    refs.winnerBanner.classList.add('show');
    pulseWheelState('ai-win', 900);
    wheelWinnerBlast(win);
    winnerTravelPathFx(win);
    rewardBurst(win);
    const myWin = Number(payload.my_total_win_amount || 0);
    winnerItemBlast(win, myWin);
    if(revealPopup) showWinnerPopup(payload, win, myWin);
    if(revealPayout){
      flyTotalToActiveUsers(payload, win);
      runPayoutAnimation(payload, win);
    }
    if(myWin > 0) show(`Win +${number(myWin)}`, 1500);
    else show(`Result ${boards[win].name}`, 1200);
  }
  function spinTo(key, onDone){
    const targetIndex = wheelSlotFor(key);
    stopWheelAnimation(true);
    wheelCruiseActive = false;
    const currentRotation = currentWheelAngle();
    const targetStopAngle = normalizeDegrees(wheelStopAngleFor(key));
    let delta = (targetStopAngle - currentRotation + 360) % 360;
    if(delta < 120) delta += 360;
    const duration = currentGameCode === 'fruits_loop' ? 980 : 860;
    const settleRotation = currentRotation + delta;
    wheelTurns += 1;
    refs.pointer.classList.add('spinning');
    wheelRevealPending = true;
    pulseWheelState('ai-spin', duration + 120);
    if(refs.stage){
      refs.stage.classList.remove('fl-wheel-spinning');
      refs.stage.classList.add('fl-wheel-settling');
    }
    refs.wheel.dataset.winnerSlot = String(targetIndex);
    refs.wheel.dataset.winnerKey = String(key || '');
    const animationToken = ++wheelAnimationToken;
    const wheelNode = resolveWheelNode();
    if(!wheelNode){
      setWheelRotation(targetStopAngle);
      refs.pointer.classList.remove('spinning');
      wheelRevealPending = false;
      revealWinnerTimer = null;
      pulseWheelState('ai-hit', 520);
      if(typeof onDone === 'function') onDone();
      return;
    }
    setWheelRotation(currentRotation, true);
    void wheelNode.offsetWidth;
    wheelNode.style.setProperty(
      'transition',
      `transform ${duration}ms ${currentGameCode === 'fruits_loop' ? 'cubic-bezier(.16,.86,.22,1)' : 'cubic-bezier(.18,.84,.24,1)'}`,
      'important'
    );
    wheelNode.style.setProperty('transform', wheelRenderTransform(settleRotation), 'important');
    wheelSpinTimer = setTimeout(() => {
      if(animationToken !== wheelAnimationToken) return;
      wheelSpinTimer = null;
      if(refs.stage){
        refs.stage.classList.remove('fl-wheel-settling');
      }
      setWheelRotation(targetStopAngle);
      refs.pointer.classList.remove('spinning');
      wheelRevealPending = false;
      revealWinnerTimer = null;
      pulseWheelState('ai-hit', 520);
      if(typeof onDone === 'function') onDone();
    }, duration + 60);
  }
  function setTimer(payload){
    if(!payload){
      if(refs.timerShell) refs.timerShell.classList.add('isHidden');
      refs.timer.textContent = '--';
      return;
    }
    if(typeof payload.server_time === 'number') serverClockOffset = payload.server_time - Date.now() / 1000;
    const now = serverNow();
    const showBetTimer = isBettingOpen(payload);
    if(refs.timerShell){
      refs.timerShell.classList.toggle('isHidden', !showBetTimer);
      refs.timerShell.setAttribute('aria-hidden', showBetTimer ? 'false' : 'true');
    }
    if(!showBetTimer){
      if(lastBetCountdownSecond !== null){
        lastBetCountdownSecond = null;
      }
      refs.timer.textContent = '--';
      return;
    }
    const end = payload.bet_close_at ? Number(payload.bet_close_at) : phaseEndAt(payload);
    let left = end ? Math.max(0, Math.ceil(end - now)) : 0;
    const limit = Number(payload.phase_durations && payload.phase_durations.betting || window.BD_GAME_BOOTSTRAP.rules.betDurationSec || 20);
    left = Math.min(limit, left);
    handleBetCountdownSound(left);
    refs.timer.textContent = left > 0 ? String(left) : 'GO';
  }
  function clearPhaseBannerHideTimer(){
    if(phaseBannerHideTimer){
      clearTimeout(phaseBannerHideTimer);
      phaseBannerHideTimer = null;
    }
  }
  function updatePhaseBanner(phaseLabel, phaseMode, eventKey = '', autoHideMs = 0){
    if(!refs.phase) return;
    refs.phase.textContent = phaseLabel;
    refs.phase.dataset.phase = String(phaseMode || 'sync');
    if(!eventKey){
      clearPhaseBannerHideTimer();
      refs.phase.classList.remove('show');
      lastPhaseBannerKey = '';
      return;
    }
    if(lastPhaseBannerKey !== eventKey){
      clearPhaseBannerHideTimer();
      refs.phase.classList.remove('show');
      void refs.phase.offsetWidth;
      refs.phase.classList.add('show');
      lastPhaseBannerKey = eventKey;
      if(autoHideMs > 0){
        phaseBannerHideTimer = setTimeout(() => {
          if(lastPhaseBannerKey !== eventKey || !refs.phase) return;
          refs.phase.classList.remove('show');
          phaseBannerHideTimer = null;
        }, autoHideMs);
      }
      return;
    }
    if(autoHideMs <= 0){
      refs.phase.classList.add('show');
    }
  }
  function applyPayload(payload){
    const previousRoundNo = roundNo;
    lastPayload = payload;
    activePlayerRows = Array.isArray(payload.active_players) ? payload.active_players : activePlayerRows;
    window.activePlayers = activePlayerRows;
    roundNo = payload.round_no || roundNo;
    syncBalanceDisplay(payload);
    refs.round.textContent = String(roundNo || '--').split('_').pop().slice(-6) || '--';
    const win = winner(payload);
    const resultPhase = payload.phase === 'revealed' || payload.phase === 'settled';
    if(previousRoundNo && roundNo && previousRoundNo !== roundNo && !resultPhase){
      refs.winnerBanner.classList.remove('show');
      refs.winnerBanner.textContent = 'Winner';
      keys.forEach((key) => {
        const box = refs.boardEls[key];
        if(!box) return;
        box.classList.remove('win', 'dim');
      });
    }
    const resultVisible = resultPhase && displayedWinnerKey === `${roundNo}:${win}`;
    const phaseLabel = payload.phase === 'betting' ? 'Start Bet' : payload.phase === 'locked' ? 'Stop Bet' : payload.phase === 'revealed' ? 'Result' : payload.phase === 'settled' ? 'Paid' : 'Sync';
    const phaseMode = payload.phase;
    let phaseBannerKey = '';
    let phaseBannerAutoHideMs = 0;
    if(payload.phase === 'betting'){
      phaseBannerKey = `${roundNo}:betting`;
      phaseBannerAutoHideMs = fruitsLoopTimings(payload).startPopupMs;
    } else if(payload.phase === 'locked'){
      phaseBannerKey = `${roundNo}:locked`;
      phaseBannerAutoHideMs = fruitsLoopTimings(payload).stopPopupMs;
    } else if(payload.phase === 'revealed'){
      phaseBannerKey = `${roundNo}:revealed:${win || ''}`;
    } else if(payload.phase === 'settled'){
      phaseBannerKey = `${roundNo}:settled:${win || ''}`;
    }
    updatePhaseBanner(phaseLabel, phaseMode, phaseBannerKey, phaseBannerAutoHideMs);
    const activeCount = Array.isArray(payload.active_players) ? payload.active_players.length : Number(payload.active_users || activePlayerRows.length || 0);
    if(refs.activeUserCount) refs.activeUserCount.textContent = String(Math.max(1, activeCount));
    setTimer(payload);
    seedChipsForPayload(payload);
    keys.forEach((key) => {
      const box = refs.boardEls[key];
      const mine = Number(payload.my_bet_totals && payload.my_bet_totals[key] || 0);
      const total = Number(payload.board_totals && payload.board_totals[key] || 0);
      setMoneyText(refs.pools[key], total);
      setMoneyText(refs.mines[key], mine);
      const resultDisplayed = resultPhase && displayedWinnerKey === `${roundNo}:${win}`;
      box.classList.toggle('win', resultDisplayed && win === key);
      box.classList.toggle('dim', resultDisplayed && win && win !== key);
      box.classList.toggle('disabled', !isBettingOpen(payload) || !canUseBoard(payload, key));
    });
    if(resultPhase && win && boards[win]){
      const resultRoundKey = `${roundNo}:${win}`;
      const winnerPopupReady = !winnerPopupAt(payload) || serverNow() >= winnerPopupAt(payload);
      if(!wheelStateHydrated){
        wheelStateHydrated = true;
        lastWinnerKey = resultRoundKey;
        stopWheelAnimation(true);
        setWheelRotation(wheelStopAngleFor(win));
        refs.pointer.classList.remove('spinning');
        wheelRevealPending = false;
        revealWinner(payload, win, { popup: payload.phase === 'settled' || winnerPopupReady, payout: payload.phase === 'settled' });
      } else if(lastWinnerKey !== resultRoundKey){
        lastWinnerKey = resultRoundKey;
        refs.winnerBanner.classList.remove('show');
        spinTo(win, () => revealWinner(payload, win, { popup: payload.phase === 'settled' || winnerPopupReady, payout: payload.phase === 'settled' }));
      } else if(payload.phase === 'revealed') {
        if(!wheelRevealPending && displayedWinnerKey === resultRoundKey && winnerPopupReady) {
          showWinnerPopup(payload, win, Number(payload.my_total_win_amount || 0));
        }
      } else if(payload.phase === 'settled') {
        if(!wheelRevealPending && displayedWinnerKey !== resultRoundKey) {
          revealWinner(payload, win, { popup: true, payout: true });
        } else if(!wheelRevealPending) {
          showWinnerPopup(payload, win, Number(payload.my_total_win_amount || 0));
          flyTotalToActiveUsers(payload, win);
          runPayoutAnimation(payload, win);
        }
      }
    } else if(payload.phase === 'locked') {
      if(!wheelRevealPending){
        startWheelCruise();
      }
    } else if(payload.phase === 'betting') {
      lastWinnerPopupKey = '';
      lastTotalFlyKey = '';
      revealWinnerTimer = null;
      stopWheelAnimation(true);
      wheelRevealPending = false;
      refs.pointer.classList.remove('spinning');
      refs.winnerBanner.classList.remove('show');
      refs.winnerBanner.textContent = 'Winner';
    }
    if(Array.isArray(payload.recent) && payload.recent.length){
      setBoardHistoryRows(payload.recent);
    }
    wheelStateHydrated = true;
    if(payload.phase === 'settled'){
      const historyRound = String(payload.round_no || '');
      if(historyRound && historyRound !== lastHistorySyncRound){
        lastHistorySyncRound = historyRound;
        refreshHistoryTables();
      }
    } else if(payload.phase === 'betting') {
      lastHistorySyncRound = '';
    }
  }
  async function refreshState(forceFresh = false){
    if(disposed || !window.BDGameFinal) return null;
    if(refreshInFlight){
      if(forceFresh) stateRefreshQueued = true;
      return stateRefreshPromise;
    }
    refreshInFlight = true;
    stateRefreshQueued = false;
    const started = performance.now();
    stateRefreshPromise = (async () => {
    try {
      const payload = await window.BDGameFinal.get(window.BD_GAME_BOOTSTRAP.endpoints.state, forceFresh ? { _fresh: Date.now() } : {});
      const ms = Math.max(1, Math.round(performance.now() - started));
      refs.network.textContent = String(ms);
      refs.latencyDot.style.background = ms <= 250 ? '#65ff6e' : ms <= 700 ? '#ffd95a' : '#ff6f6f';
      refs.latencyDot.style.boxShadow = `0 0 12px ${refs.latencyDot.style.background}`;
      if(payload && payload.st) applyPayload(payload);
      else if(payload && (payload.status === 401 || payload.status === 419 || payload.error === 'invalid_session' || payload.code === 'invalid_session')){
        show('Refreshing game session', 1200);
        window.setTimeout(() => { window.location.href = @json(route('game-final.start', ['gameCode' => $currentGameCode])); }, 450);
      }
      else if(payload && payload.error){
        refs.phase.textContent = 'Reconnecting';
      }
      return payload;
    } catch (error) {
      refs.network.textContent = 'retry';
      refs.latencyDot.style.background = '#ff6f6f';
      return null;
    } finally {
      refreshInFlight = false;
      stateRefreshPromise = null;
      if(stateRefreshQueued && !disposed){
        stateRefreshQueued = false;
        setTimeout(() => refreshState(true), 0);
      }
    }
    })();
    return stateRefreshPromise;
  }
  function localNumber(value){
    return Number(String(value === undefined || value === null ? '' : value).replace(/[^\d.-]/g, '')) || 0;
  }
  function currentWalletBalance(payload){
    if(payload){
      const value = payload.balance ?? payload.wallet_balance ?? payload.user_balance ?? payload.wallet;
      if(value !== undefined && value !== null && value !== '') return localNumber(value);
    }
    return localNumber(refs.balance ? refs.balance.textContent : '');
  }
  function syncChipButtons(){
    refs.chips.forEach((node) => node.classList.toggle('active', Number(node.dataset.value || 0) === Number(selectedChip)));
  }
  function affordableChip(balance){
    const values = Array.from(refs.chips)
      .map((node) => Number(node.dataset.value || 0))
      .filter((value) => value > 0 && value <= balance)
      .sort((a, b) => a - b);

    return values.length ? values[values.length - 1] : 0;
  }
  function betErrorText(code){
    const errors = {
      insufficient_balance: 'Balance too low. Re-enter from lobby to refresh wallet.',
      bet_closed: 'Bet closed. Wait for the next round.',
      bet_amount_out_of_range: 'Bet amount is outside the allowed limit.',
      max_distinct_board_limit: `Max ${maxDistinct(lastPayload)} boards this round.`,
      max_pot_reached: 'Board limit reached.',
      invalid_session: 'Session expired. Rejoin from lobby.'
    };

    return errors[code] || code || 'Bet failed';
  }
  async function submitBet(key){
    if(!isBettingOpen(lastPayload)){ show('Next betting window soon'); return; }
    if(!canUseBoard(lastPayload, key)){ show(`Max ${maxDistinct(lastPayload)} boards this round`); return; }
    const balance = currentWalletBalance(lastPayload);
    if(balance < selectedChip){
      const nextChip = affordableChip(balance);
      if(nextChip > 0){
        selectedChip = nextChip;
        syncChipButtons();
        show(`Chip ${number(selectedChip)} selected`);
      } else {
        show('Balance refreshing. Re-enter from lobby if needed.');
        await refreshState(true);
        return;
      }
    }
    const amount = selectedChip;
    refs.boardEls[key].classList.add('pending');
    flyChipToBox(key, amount);
    const optimisticPayload = optimisticBetPayload(lastPayload, key, amount);
    if(optimisticPayload) applyPayload(optimisticPayload);
    try {
      const response = await window.BDGameFinal.post(window.BD_GAME_BOOTSTRAP.endpoints.bet, {
        round_no: roundNo,
        board_key: key,
        amount: amount,
        request_uid: `fruits-loop-${Date.now()}-${++requestCounter}-${key}`
      });
      if(response && response.st){
        show(`${boards[key].name} +${number(amount)}`);
        if(response.balance !== undefined && lastPayload) applyPayload(Object.assign({}, lastPayload, { balance: Number(response.balance || 0) }));
        window.setTimeout(() => refreshState(true), 60);
      }
      else {
        const code = response && (response.msg || response.error);
        if(code === 'insufficient_balance') await refreshState(true);
        else refreshState(true);
        show(betErrorText(code));
      }
    } catch (error) {
      refreshState(true);
      show('Network retry needed');
    } finally {
      refs.boardEls[key].classList.remove('pending');
    }
  }
  scaleStage();
  window.addEventListener('resize', scaleStage);
  if(window.visualViewport) window.visualViewport.addEventListener('resize', scaleStage);
  refs.chips.forEach((chip) => chip.addEventListener('click', () => {
    refs.chips.forEach((node) => node.classList.remove('active'));
    chip.classList.add('active');
    selectedChip = Number(chip.dataset.value || 0);
    show(`Chip ${number(selectedChip)}`);
  }));
  function handleBoardPress(event, key){
    if(event){
      event.preventDefault();
      event.stopPropagation();
    }
    submitBet(key);
  }
  function bindReliableBoardPress(node, key){
    if(!node) return;
    node.style.touchAction = 'manipulation';
    if(window.PointerEvent){
      node.addEventListener('pointerup', (event) => {
        if(event.pointerType === 'mouse' && event.button !== 0) return;
        handleBoardPress(event, key);
      }, { passive: false });
    } else {
      node.addEventListener('touchend', (event) => handleBoardPress(event, key), { passive: false });
      node.addEventListener('click', (event) => handleBoardPress(event, key), { passive: false });
    }
    node.addEventListener('keydown', (event) => {
      if(event.key === 'Enter' || event.key === ' ') handleBoardPress(event, key);
    });
  }
  keys.forEach((key) => bindReliableBoardPress(refs.boardEls[key], key));
  refs.settingsBtn.addEventListener('click', openSettings);
  refs.historyBtn.addEventListener('click', openHistory);
  refs.winnersBtn.addEventListener('click', openWinners);
  refs.infoBtn.addEventListener('click', openInfo);
  refs.soundBtn.addEventListener('click', toggleSound);
  refs.userBtn.addEventListener('click', openUser);
  if(refs.trendBtn) refs.trendBtn.addEventListener('click', openHistory);
  refs.modalClose.addEventListener('click', closeModal);
  refs.modal.addEventListener('click', (event) => { if(event.target === refs.modal) closeModal(); });
  renderWinnerHistoryStrip();
  if(window.BDGameFinal && window.BD_GAME_BOOTSTRAP && window.BD_GAME_BOOTSTRAP.gameCode === currentGameCode){
    const api = window.BDGameFinal;
    api.onState((payload) => { if(payload && payload.st) applyPayload(payload); });
    refreshState();
    refreshHistoryTables(true);
    if(typeof api.startHeartbeat === 'function') api.startHeartbeat(15000, 0);
    else heartbeatTimer = setInterval(() => { if(window.BDGameFinal && !disposed) window.BDGameFinal.heartbeat ? window.BDGameFinal.heartbeat(0) : window.BDGameFinal.post(window.BD_GAME_BOOTSTRAP.endpoints.heartbeat, { network_ms: 0 }); }, 15000);
  } else {
    show('Open from lobby');
    showStatus('Live Session Required', 1800);
  }
  function popupEscape(value){
    return String(value == null ? '' : value)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#39;');
  }
  function popupInitials(name){
    const clean = String(name || '').trim();
    if(!clean) return 'PL';
    return clean.split(/\s+/).slice(0, 2).map((part) => part.charAt(0).toUpperCase()).join('') || clean.slice(0, 2).toUpperCase();
  }
  function historyValue(item, keys, fallback = ''){
    for(const key of keys){
      if(item && item[key] != null && item[key] !== '') return item[key];
    }
    return fallback;
  }
  function historyBoardLabel(item){
    const raw = historyValue(item, ['my_board', 'my_boards', 'board_key', 'bet_board', 'bet_boards', 'user_board', 'winner', 'win_board'], '');
    if(Array.isArray(raw)){
      return raw.map((value) => boardName(value)).join(', ');
    }
    const text = String(raw || '').trim();
    if(!text) return '-';
    if(text.includes(',')){
      return text.split(',').map((value) => boardName(value.trim())).join(', ');
    }
    return boardName(text);
  }
  function historyBidTotal(item){
    return Number(historyValue(item, ['my_bet_total', 'my_total_bet', 'my_bet_amount', 'bet_total', 'total_bet', 'bet_amount'], 0) || 0);
  }
  function historyWinTotal(item){
    return Number(historyValue(item, ['my_total_win_amount', 'my_win_amount', 'win_amount', 'payout', 'profit'], 0) || 0);
  }
  function renderPlayHistoryHtml(){
    return renderHistoryHtml();
  }
  window.renderFruitsLoopTrendHtml = renderHistoryHtml;
  window.renderPlayHistoryHtml = renderPlayHistoryHtml;
  async function openRealHistoryPopup(){
    openModal('History', '<div class="panelCanvas"><div class="playerEmptyState"><div class="playerEmptyText">Loading history...</div></div></div>', 'trend');
    await refreshHistoryTables(true);
    refs.modalBody.innerHTML = renderPlayHistoryHtml();
  }
  function normalizedPopupPlayers(){
    const live = Array.isArray(activePlayerRows) && activePlayerRows.length
      ? activePlayerRows
      : (Array.isArray(lastPayload && lastPayload.active_players) ? lastPayload.active_players : []);
    if(!live.length){
      return [{ name: 'You', image: '' }];
    }
    return live.map((player, index) => ({
      name: String(player && (player.name || player.display_name || player.username || player.email || player.user_name) || `Player ${index + 1}`),
      image: String(player && (player.image || player.avatar || player.photo || player.profile_photo_url || player.user_image || player.profile_image) || ''),
    }));
  }
  function renderProfessionalUsersPanel(){
    const players = normalizedPopupPlayers();
    return `
      <div class="panelCanvas playersPanel">
        ${players.length ? `
          <div class="playerRosterGrid">
            ${players.map((player) => `
              <div class="playerRosterCard">
                <div class="playerAvatar">
                  ${player.image ? `<img src="${popupEscape(player.image)}" alt="${popupEscape(player.name)}">` : `<div class="playerAvatarFallback">${popupEscape(popupInitials(player.name))}</div>`}
                </div>
                <div class="playerMeta">
                  <div class="playerName">${popupEscape(player.name)}</div>
                </div>
              </div>
            `).join('')}
          </div>
        ` : '<div class="playerEmptyState"><div class="playerEmptyText">No active users right now.</div></div>'}
      </div>
    `;
  }
  function openProfessionalUsersPopup(){
    const activeCountNode = document.getElementById('activeUserCount');
    if(activeCountNode && Number(activeCountNode.textContent || 0) < 1){
      activeCountNode.textContent = '1';
    }
    openModal('Player List', renderProfessionalUsersPanel(), 'players');
  }
  function keepCurrentUserActive(){
    document.querySelectorAll('#activeUserCount').forEach((activeCountNode) => {
      if(Number(activeCountNode.textContent || 0) < 1){
        activeCountNode.textContent = '1';
      }
    });
  }
  if(refs.historyBtn){
    refs.historyBtn.addEventListener('click', (event) => {
      event.preventDefault();
      event.stopImmediatePropagation();
      openRealHistoryPopup();
    }, true);
  }
  if(refs.trendBtn){
    refs.trendBtn.addEventListener('click', (event) => {
      event.preventDefault();
      event.stopImmediatePropagation();
      openRealHistoryPopup();
    }, true);
  }
  if(refs.userBtn){
    refs.userBtn.addEventListener('click', (event) => {
      event.preventDefault();
      event.stopImmediatePropagation();
      openProfessionalUsersPopup();
    }, true);
  }
  uiTimer = setInterval(() => setTimer(lastPayload), 500);
  keepCurrentUserActive();
  activeUserTimer = setInterval(keepCurrentUserActive, 1500);
  function cleanupFruitsLoopRoom(){
    disposed = true;
    clearPhaseBannerHideTimer();
    silenceLoopRoomAudio(true);
    if(window.BDGameFinal && typeof window.BDGameFinal.stopHeartbeat === 'function') window.BDGameFinal.stopHeartbeat();
    if(refreshTimer) clearInterval(refreshTimer);
    if(heartbeatTimer) clearInterval(heartbeatTimer);
    if(uiTimer) clearInterval(uiTimer);
    if(activeUserTimer) clearInterval(activeUserTimer);
  }
  document.addEventListener('visibilitychange', () => {
    if(document.hidden) silenceLoopRoomAudio(false);
  });
  window.addEventListener('pagehide', cleanupFruitsLoopRoom, { once: true });
  window.addEventListener('beforeunload', cleanupFruitsLoopRoom, { once: true });
})();
</script>
<script id="fruits-loop-production-script">
(function(){
  const onReady = (fn) => {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', fn, { once: true });
    } else {
      fn();
    }
  };

  const currentUserName = () => {
    const meta = [
      window.currentUser?.name,
      window.authUser?.name,
      window.user?.name,
      window.player?.name,
      document.body?.dataset?.userName,
      'You'
    ].find(Boolean);
    return String(meta || 'You');
  };

  const currentUserImage = () => {
    return [
      window.currentUser?.image,
      window.currentUser?.avatar,
      window.authUser?.image,
      window.user?.image,
      window.player?.image,
      document.body?.dataset?.userImage,
      ''
    ].find((value) => typeof value === 'string');
  };

  const escapeMarkup = (value) => String(value == null ? '' : value).replace(/[&<>"']/g, (char) => ({
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  })[char]);

  const normalizePlayer = (entry) => {
    if (!entry) return null;
    if (typeof entry === 'string') {
      return { name: entry, image: '' };
    }
    const name = entry.name || entry.username || entry.full_name || entry.fullName || entry.display_name || entry.player_name || entry.user_name || entry.email || currentUserName();
    const image = entry.image || entry.avatar || entry.photo || entry.profile_image || entry.user_image || entry.picture || '';
    return { name: String(name || currentUserName()), image: typeof image === 'string' ? image : '' };
  };

  const collectPlayers = () => {
    const pools = [
      window.activePlayers,
      window.livePlayers,
      window.players,
      window.roomPlayers,
      window.gamePlayers,
      window.__activePlayers,
      window.roomState?.players,
      window.roomState?.active_players,
      window.appState?.players,
      window.gameState?.players,
      window.gameState?.active_players,
      window.state?.players,
      window.state?.active_players
    ];
    const out = [];
    const seen = new Set();
    const pushPlayer = (raw) => {
      const player = normalizePlayer(raw);
      if (!player) return;
      const key = `${player.name}|${player.image}`;
      if (seen.has(key)) return;
      seen.add(key);
      out.push(player);
    };
    pools.forEach((pool) => {
      if (Array.isArray(pool)) {
        pool.forEach(pushPlayer);
      } else if (pool && typeof pool === 'object') {
        Object.values(pool).forEach(pushPlayer);
      }
    });
    pushPlayer({ name: currentUserName(), image: currentUserImage() });
    return out;
  };

  const syncActiveUserCount = () => {
    const players = collectPlayers();
    const nextCount = Math.max(1, players.length);
    document.querySelectorAll('#activeUserCount').forEach((node) => {
      node.textContent = String(nextCount);
    });
    return players;
  };

  const renderPlayerGrid = () => {
    const players = syncActiveUserCount();
    if (!players.length) {
      return '<div class="playerEmptyState">No active users right now.</div>';
    }
    return `<div class="playerListGrid">${players.map((player) => {
      const name = String(player.name || 'User');
      const image = player.image ? `<img class="playerAvatar" src="${escapeMarkup(player.image)}" alt="${escapeMarkup(name)}">` : `<div class="playerAvatar placeholder">${escapeMarkup(String(name).trim().charAt(0).toUpperCase() || 'U')}</div>`;
      return `<div class="playerListItem">${image}<div class="playerName">${escapeMarkup(name)}</div></div>`;
    }).join('')}</div>`;
  };

  const renderHistoryMarkup = () => {
    const trendRenderer = window.renderFruitsLoopTrendHtml || window.renderPlayHistoryHtml;
    if (typeof trendRenderer === 'function') {
      const built = trendRenderer();
      if (built && String(built).trim()) {
        return built;
      }
    }
    return `
      <div class="historyTableWrap">
        <table class="historyTable">
          <thead>
            <tr>
              <th>Round ID</th>
              <th>Bid Total</th>
              <th>Board</th>
              <th>Result</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="4"><div class="playerEmptyState">No play history available yet.</div></td>
            </tr>
          </tbody>
        </table>
      </div>`;
  };

  const renderSettingsMarkup = () => {
    const soundEnabled = (window.localStorage?.getItem('fruits_loop_sound_enabled') ?? '1') !== '0';
    const soundVolume = Number(window.localStorage?.getItem('fruits_loop_sound_volume') ?? '70');
    return `
      <div class="settingsGrid">
        <div class="settingRow">
          <div class="settingLabel">Sound Effect</div>
          <input class="settingSlider" id="fruitsLoopSoundRange" type="range" min="0" max="100" value="${Math.max(0, Math.min(100, soundVolume))}">
        </div>
        <div class="settingRow">
          <div class="settingLabel">Sound Status</div>
          <button type="button" id="fruitsLoopSoundToggle" class="menuBtn" style="min-width:110px;">${soundEnabled ? 'Enabled' : 'Muted'}</button>
        </div>
      </div>`;
  };

  const setModalState = (visible) => {
    const modal = document.getElementById('appModal');
    if (!modal) return;
    modal.style.display = visible ? 'flex' : 'none';
    modal.hidden = !visible;
    modal.setAttribute('aria-hidden', visible ? 'false' : 'true');
    modal.classList.toggle('is-open', visible);
    modal.classList.toggle('open', visible);
    modal.classList.toggle('show', visible);
    modal.classList.toggle('visible', visible);
  };

  const openCustomModal = (title, html, panel) => {
    if (typeof openModal === 'function') {
      openModal(title, html, panel);
      const titleNode = document.querySelector('#appModal .modalTitle, #appModal .modalHead h3, #appModal .modalHead h2');
      if (titleNode) titleNode.textContent = title;
      const bodyNode = document.querySelector('#appModal .modalBody');
      if (bodyNode) bodyNode.innerHTML = html;
      const modal = document.getElementById('appModal');
      if (modal) modal.dataset.panel = panel;
      const cardNode = document.querySelector('#appModal .modalCard');
      if (cardNode) cardNode.dataset.panel = panel;
      setModalState(true);
      return;
    }
    const modal = document.getElementById('appModal');
    if (!modal) return;
    const titleNode = modal.querySelector('.modalTitle, .modalHead h3, .modalHead h2');
    if (titleNode) titleNode.textContent = title;
    const bodyNode = modal.querySelector('.modalBody');
    if (bodyNode) bodyNode.innerHTML = html;
    modal.dataset.panel = panel;
    const cardNode = modal.querySelector('.modalCard');
    if (cardNode) cardNode.dataset.panel = panel;
    setModalState(true);
  };

  const closeCustomModal = () => {
    if (typeof closeModal === 'function') {
      closeModal();
    }
    setModalState(false);
  };

  const rebindButton = (id, handler) => {
    const node = document.getElementById(id);
    if (!node) return null;
    const clone = node.cloneNode(true);
    node.replaceWith(clone);
    clone.addEventListener('click', (event) => {
      event.preventDefault();
      event.stopPropagation();
      event.stopImmediatePropagation();
      handler();
    }, true);
    return clone;
  };

  const openUsersPopup = () => openCustomModal('Player List', renderPlayerGrid(), 'players');
  const openSettingsPopup = () => openCustomModal('Settings', renderSettingsMarkup(), 'settings');
  const openHistoryPopup = async () => {
    openCustomModal('Trend', renderHistoryMarkup(), 'trend');
    if (typeof refreshHistoryTables === 'function') {
      try {
        await refreshHistoryTables(true);
      } catch (error) {}
      const bodyNode = document.querySelector('#appModal .modalBody');
      if (bodyNode) bodyNode.innerHTML = renderHistoryMarkup();
    }
  };

  onReady(() => {
    syncActiveUserCount();
    setInterval(syncActiveUserCount, 300);

    window.openProfessionalUsersPopup = openUsersPopup;
    window.openRealHistoryPopup = openHistoryPopup;
    window.openFruitTrendPopup = openHistoryPopup;

    rebindButton('userBtn', () => {
      if (typeof window.codexFruitLoopOpenUsers === 'function') {
        window.codexFruitLoopOpenUsers();
        return;
      }
      openUsersPopup();
    });
    rebindButton('historyBtn', openHistoryPopup);
    rebindButton('trendBtn', openHistoryPopup);
    rebindButton('winnersBtn', () => {
      if (typeof window.codexFruitLoopOpenWinners === 'function') {
        window.codexFruitLoopOpenWinners();
      }
    });
    rebindButton('infoBtn', () => {
      if (typeof window.codexFruitLoopOpenInfo === 'function') {
        window.codexFruitLoopOpenInfo();
      }
    });
    rebindButton('settingsBtn', () => {
      if (typeof window.codexFruitLoopOpenSettings === 'function') {
        window.codexFruitLoopOpenSettings();
        return;
      }
      openSettingsPopup();
    });

    const trendBtn = document.getElementById('trendBtn');
    if (trendBtn) {
      trendBtn.setAttribute('aria-label', 'Trend');
      trendBtn.setAttribute('title', 'Trend');
    }

    document.querySelectorAll('#appModal .modalClose').forEach((closeBtn) => {
      closeBtn.addEventListener('click', (event) => {
        event.preventDefault();
        event.stopPropagation();
        closeCustomModal();
      }, true);
    });

    document.addEventListener('input', (event) => {
      if (event.target && event.target.id === 'fruitsLoopSoundRange') {
        window.localStorage?.setItem('fruits_loop_sound_volume', String(event.target.value));
      }
    });

    document.addEventListener('click', (event) => {
      const target = event.target;
      if (target && target.id === 'fruitsLoopSoundToggle') {
        const nextEnabled = target.textContent !== 'Enabled';
        target.textContent = nextEnabled ? 'Enabled' : 'Muted';
        window.localStorage?.setItem('fruits_loop_sound_enabled', nextEnabled ? '1' : '0');
      }
    });
  });
})();
</script>
<script id="fruits-loop-shell-dom-fix">
(function(){
  const applyShellLayers = () => {
    const shell = document.getElementById('wheelShell');
    if (!shell) return;
    shell.style.position = 'relative';
    shell.style.background = 'none';
    shell.style.borderRadius = '50%';
    shell.style.boxShadow = 'none';
  };
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', applyShellLayers, { once: true });
  } else {
    applyShellLayers();
  }
  setInterval(applyShellLayers, 800);
})();
</script>
<script id="fruits-loop-result-sync-script">
(function(){
  const aliasMap = @json($visualFruitMeta);
  const visualOrder = @json($boardKeys);

  function syncBoardVisuals(){
    const board = document.getElementById('board');
    if(!board) return;

    const topIcons = board.querySelectorAll('.betFruit');
    topIcons.forEach((node, index) => {
      const key = visualOrder[index];
      const meta = aliasMap[key];
      if (!meta) return;
      node.textContent = meta.icon;
      node.setAttribute('title', meta.label);
      node.setAttribute('aria-label', meta.label);
    });

    visualOrder.forEach((key) => {
      const box = document.getElementById(`box-${key}`);
      if(!box) return;
      const meta = aliasMap[key];
      const badge = box.querySelector('.fruitBadge');
      if (badge) {
        badge.textContent = meta.icon;
        badge.setAttribute('title', meta.label);
        badge.setAttribute('aria-label', meta.label);
      }
      box.dataset.visualName = meta.label;
      box.setAttribute('title', meta.label);
      let label = box.querySelector('.visualPotName');
      if(!label){
        label = document.createElement('div');
        label.className = 'visualPotName';
        const combo = box.querySelector('.combo');
        if(combo){
          combo.insertAdjacentElement('afterend', label);
        } else {
          box.appendChild(label);
        }
      }
      label.textContent = meta.label;
    });
  }

  function syncHistoryVisuals(){
    const modal = document.getElementById('appModal');
    if(!modal) return;
    modal.querySelectorAll('table tr').forEach((row) => {
      const cells = row.querySelectorAll('td');
      if(cells.length < 3) return;
      const boardCell = cells[2];
      const raw = (boardCell.textContent || '').trim().toLowerCase();
      if(aliasMap[raw]) {
        boardCell.textContent = aliasMap[raw].label;
      }
    });
  }

  function syncWheelShell(){
    const shell = document.getElementById('wheelShell');
    if(!shell) return;
    const cover = shell.querySelector('.flWheelCover');
    if(cover){
      cover.style.display = 'block';
      cover.style.zIndex = '5';
    }
    shell.querySelectorAll('.flWheelBadge').forEach((node) => {
      node.style.display = 'none';
    });
  }

  function runSync(){
    syncWheelShell();
    syncBoardVisuals();
    syncHistoryVisuals();
  }

  if(document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', runSync, { once:true });
  } else {
    runSync();
  }
  setInterval(runSync, 600);
})();
</script>
<script id="fruits-loop-layout-final-script">
(function(){
  function syncBalanceCoin(){
    const balanceIcon = document.getElementById('balanceIcon');
    if (balanceIcon) {
      balanceIcon.textContent = '';
      balanceIcon.setAttribute('aria-label', 'Coins');
      balanceIcon.setAttribute('title', 'Coins');
    }
  }

  function stripNumberCommas(){
    document.querySelectorAll('#balanceValue,.potValue,.youValue').forEach((node) => {
      const value = node.textContent || '';
      const compact = value.replace(/,/g, '');
      if (value !== compact) node.textContent = compact;
    });
  }

  function syncBidNowAlert(){
    const status = document.getElementById('statusBar');
    if (!status) return;
    status.dataset.bidAlertRound = '';
    status.dataset.bidAlertUntil = '';
    status.dataset.bidAlertLabel = '';
  }

  function syncTopLabels(){
    const latency = document.querySelector('.latencyPill');
    if (latency) {
      latency.childNodes.forEach((node) => {
        if (node.nodeType === Node.TEXT_NODE) node.nodeValue = '';
      });
      const latencyText = document.getElementById('latencyText');
      if (latencyText && latencyText.parentElement) {
        latencyText.parentElement.childNodes.forEach((node) => {
          if (node.nodeType === Node.TEXT_NODE) node.nodeValue = '';
        });
      }
    }
    const round = document.querySelector('.roundPill');
    if (round) {
      round.childNodes.forEach((node) => {
        if (node.nodeType === Node.TEXT_NODE) node.nodeValue = '';
      });
    }
  }

  function syncLatencyDot(){
    const latencyText = document.getElementById('latencyText');
    const dot = document.getElementById('latencyDot');
    if (!latencyText || !dot) return;
    const ms = Number(String(latencyText.textContent || '').replace(/[^\d.]/g, ''));
    if (!Number.isFinite(ms)) {
      dot.style.color = '#66ff7a';
      dot.style.background = '#66ff7a';
      return;
    }
    const color = ms >= 300 ? '#ff5d5d' : ms >= 180 ? '#ffd25b' : '#66ff7a';
    dot.style.color = color;
    dot.style.background = color;
  }

  function syncCompactGameUi(){
    syncBalanceCoin();
    stripNumberCommas();
    syncTopLabels();
    syncLatencyDot();
    syncBidNowAlert();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', syncCompactGameUi, { once: true });
  } else {
    syncCompactGameUi();
  }
  setInterval(syncCompactGameUi, 250);
})();
</script>
<style>
@media (max-width: 767px) {
  #timer{
    left:50% !important;
    top:calc(122px + min(70vw,304px) + 50px) !important;
    transform:translateX(-50%) !important;
    width:128px !important;
    height:128px !important;
    filter:drop-shadow(0 14px 18px rgba(0,0,0,.24)) !important;
    z-index:30 !important;
  }
  #statusBar{
    left:50% !important;
    top:calc(122px + min(70vw,304px) + 210px) !important;
    transform:translateX(-50%) !important;
    min-width:184px !important;
    max-width:calc(100% - 96px) !important;
    padding:10px 18px !important;
    border-radius:999px !important;
    font-size:15px !important;
    z-index:29 !important;
  }
  #countNum{
    min-width:66px !important;
    height:66px !important;
    font-size:38px !important;
  }
  #board{
    z-index:8 !important;
  }
  .potText,.youText{
    width:calc(100% - 18px) !important;
    justify-content:flex-start !important;
  }
  .potValue,.youValue{
    margin-left:auto !important;
    max-width:none !important;
    overflow:visible !important;
    text-overflow:clip !important;
  }
  .multText{
    left:50% !important;
    right:auto !important;
    top:50% !important;
    transform:translate(88px,-50%) !important;
    z-index:9 !important;
    opacity:.52 !important;
    padding:1px 6px !important;
    border-radius:999px !important;
    background:linear-gradient(180deg,rgba(255,255,255,.12),rgba(255,255,255,.02)) !important;
    backdrop-filter:blur(2px) !important;
  }
  #winnerHistory .historyTitle{
    display:none !important;
  }
}/* CODEX-FRUITS-ASSET-SKIN-START */
#stage{--fl-wheel-size:min(112vw,430px)!important}
#wheelZone{top:72px!important;height:calc(var(--fl-wheel-size) + 72px)!important;overflow:visible!important;transform:translateX(-50%)!important;align-items:flex-start!important;filter:drop-shadow(0 30px 42px rgba(0,0,0,.46)) drop-shadow(0 0 24px rgba(255,194,76,.16))!important}
#wheelShell{position:relative!important;top:0!important;width:var(--fl-wheel-size)!important;height:var(--fl-wheel-size)!important;padding:0!important;border-radius:50%!important;overflow:visible!important;background:url('{{ $wheelFaceAsset }}') center/contain no-repeat!important;box-shadow:none!important}
#wheelShell:before{content:""!important;display:block!important;position:absolute!important;inset:-2%!important;border-radius:50%!important;background:radial-gradient(circle at 50% 48%,rgba(255,232,137,.18),rgba(0,0,0,0) 58%)!important;filter:blur(4px)!important;pointer-events:none!important;z-index:0!important}
#wheelShell:after{content:""!important;display:block!important;position:absolute!important;left:50%!important;top:-8%!important;width:150%!important;height:86%!important;transform:translateX(-50%)!important;background:url('{{ $wheelCoverAsset }}') center top/contain no-repeat!important;filter:drop-shadow(0 14px 18px rgba(0,0,0,.40)) drop-shadow(0 0 16px rgba(255,211,92,.16))!important;pointer-events:none!important;z-index:36!important}
#wheelWindow,#wheelRotator,#wheelFace,#wheelCover,#wheelTitle,#wheelAura,#wheelRays,#wheelGlow,#wheelScan,#wheelHaloRing,#wheelBackdrop,.sectorLine,.wheelFruit,#wheelCenter,#pointer,#wheelShell .flWheelCover,#wheelRotator .flWheelCover,#wheelShell .flWheelBadge{display:none!important}
#flWinnerPointer{position:absolute;left:50%;top:calc(var(--fl-wheel-size) * .435);width:64px;height:82px;transform:translateX(-50%);z-index:42;pointer-events:none;filter:drop-shadow(0 11px 15px rgba(0,0,0,.44)) drop-shadow(0 0 14px rgba(255,221,116,.22))}
#flWinnerPointer:before{content:"";position:absolute;left:50%;top:0;width:32px;height:32px;transform:translateX(-50%);border-radius:50%;background:radial-gradient(circle at 34% 28%,#fff7d8 0,#ffd565 34%,#b45b00 72%,#5d2100 100%);border:3px solid rgba(255,245,190,.96);box-shadow:inset 0 2px 0 rgba(255,255,255,.78),0 0 0 3px rgba(139,62,0,.50),0 0 20px rgba(255,214,93,.42)}
#flWinnerPointer:after{content:"";position:absolute;left:50%;top:28px;transform:translateX(-50%);width:0;height:0;border-left:19px solid transparent;border-right:19px solid transparent;border-top:39px solid #ffd45b;filter:drop-shadow(0 2px 0 rgba(255,255,255,.52)) drop-shadow(0 9px 12px rgba(0,0,0,.42))}
#pointerBlast{position:absolute!important;left:50%!important;top:calc(var(--fl-wheel-size) * .47)!important;width:138px!important;height:138px!important;transform:translate(-50%,-50%) scale(.2)!important;border-radius:50%!important;background:radial-gradient(circle,rgba(255,255,255,.98) 0,rgba(255,229,116,.78) 16%,rgba(255,116,37,.42) 34%,rgba(255,72,218,.18) 52%,rgba(255,255,255,0) 72%)!important;filter:blur(5px) saturate(145%)!important;opacity:0!important;z-index:41!important;pointer-events:none!important}
#pointerBlast.fire{animation:flPointerBlast .82s ease-out 1!important}
#timer{position:absolute!important;left:50%!important;top:calc(72px + var(--fl-wheel-size) * .83)!important;transform:translateX(-50%)!important;width:92px!important;height:92px!important;background:url('{{ $timerStopwatchAsset }}') center/contain no-repeat!important;border:0!important;box-shadow:none!important;color:#5a2100!important;text-shadow:0 1px 0 rgba(255,255,255,.70),0 0 9px rgba(255,218,102,.32)!important;font-family:Georgia,'Times New Roman',serif!important;font-size:25px!important;font-weight:900!important;line-height:92px!important;z-index:34!important}
#statusBar{top:calc(72px + var(--fl-wheel-size) * .83 + 80px)!important}
#winnerBanner{top:calc(72px + var(--fl-wheel-size) * .83 + 56px)!important}
#board{bottom:96px!important;top:auto!important}
.wheelWinnerPot{position:absolute;width:58px;height:58px;margin:-29px 0 0 -29px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:31px;line-height:1;background:radial-gradient(circle at 35% 26%,#fff9d8 0,#ffd365 40%,#b76308 76%,#572100 100%);border:2px solid rgba(255,250,208,.94);box-shadow:0 0 0 5px rgba(255,218,94,.18),0 0 28px rgba(255,226,112,.80),0 0 54px rgba(255,77,210,.30),0 12px 20px rgba(0,0,0,.38);transform:scale(.32);opacity:0;z-index:40;pointer-events:none}.wheelWinnerPot.show{animation:flWinnerPotPop 1.9s ease-out forwards}.pointerBlastRay{position:absolute;width:8px;border-radius:999px;background:linear-gradient(180deg,rgba(255,255,255,.96),rgba(255,219,83,.88),rgba(255,80,214,.04));box-shadow:0 0 18px rgba(255,230,126,.78),0 0 32px rgba(255,92,221,.28);transform-origin:50% 0;opacity:0;z-index:39;pointer-events:none;animation:flBlastRay .72s ease-out forwards}
@keyframes flPointerBlast{0%{opacity:0;transform:translate(-50%,-50%) scale(.2)}22%{opacity:1;transform:translate(-50%,-50%) scale(.86)}100%{opacity:0;transform:translate(-50%,-50%) scale(1.75)}}@keyframes flWinnerPotPop{0%{opacity:0;transform:scale(.28) rotate(-18deg)}16%{opacity:1;transform:scale(1.18) rotate(7deg)}36%{transform:scale(.96) rotate(0deg)}76%{opacity:1;transform:scale(1.05)}100%{opacity:0;transform:scale(.72)}}@keyframes flBlastRay{0%{opacity:0;transform:rotate(var(--ray-angle,0deg)) scaleY(.04)}18%{opacity:1}100%{opacity:0;transform:rotate(var(--ray-angle,0deg)) scaleY(1)}}
@media(max-height:720px){#stage{--fl-wheel-size:min(112vw,430px)!important}#wheelZone{top:74px!important;transform:translateX(-50%) scale(.96)!important;transform-origin:top center!important}#timer{top:calc(74px + var(--fl-wheel-size) * .79)!important;width:76px!important;height:76px!important;line-height:76px!important;font-size:21px!important}#board{bottom:86px!important}}
@media(max-width:370px){#stage{--fl-wheel-size:min(108%,400px)!important}#flWinnerPointer{transform:translateX(-50%) scale(.9)!important}}
/* CODEX-FRUITS-ASSET-SKIN-END */
</style>
<script>
// CODEX-FRUITS-WINNER-FX-START
(function(){
    'use strict';
    var BOARD_ALIASES=@json($boardAliasMap);
    var VISUAL_META=@json($visualFruitMeta);
    var BOARD_ORDER=@json($boardKeys);
    var POSITIONS=(function(){
        var fallbackX=[28,50,72];
        var positions={};
        BOARD_ORDER.forEach(function(key,index){
            var meta=VISUAL_META[key]||{};
            positions[key]={x:fallbackX[index]||50,y:index===1?74:66,icon:meta.icon||'?'};
        });
        Object.keys(BOARD_ALIASES).forEach(function(alias){
            var canonical=BOARD_ALIASES[alias];
            if(positions[canonical]){
                positions[alias]=positions[canonical];
            }
        });
        return positions;
    })();
    var lastKey='',lastAt=0;
    function ready(fn){if(document.readyState==='loading'){document.addEventListener('DOMContentLoaded',fn,{once:true});}else{fn();}}
    function normalize(v){return String(v||'').toLowerCase().replace(/[^a-z0-9_ -]+/g,' ');}
    function detectKey(el){if(!el){return '';}var d=el.dataset||{};var raw=normalize([d.board,d.boardKey,d.key,d.slug,d.name,d.value,el.className,el.textContent].join(' '));var parts=raw.split(/\s+/).filter(Boolean);for(var i=0;i<parts.length;i+=1){if(BOARD_ALIASES[parts[i]]){return BOARD_ALIASES[parts[i]];}}return '';}
    function ensureFxNodes(shell){var pointer=document.getElementById('flWinnerPointer');if(!pointer){pointer=document.createElement('div');pointer.id='flWinnerPointer';pointer.setAttribute('aria-hidden','true');shell.appendChild(pointer);}var blast=document.getElementById('pointerBlast');if(!blast){blast=document.createElement('div');blast.id='pointerBlast';blast.setAttribute('aria-hidden','true');shell.appendChild(blast);}var pot=shell.querySelector('.wheelWinnerPot');if(!pot){pot=document.createElement('div');pot.className='wheelWinnerPot';pot.setAttribute('aria-hidden','true');shell.appendChild(pot);}return{blast:blast,pot:pot};}
    function fireWinnerFx(key){var shell=document.getElementById('wheelShell');if(!shell||!POSITIONS[key]){return;}var now=Date.now();if(key===lastKey&&now-lastAt<1800){return;}lastKey=key;lastAt=now;var nodes=ensureFxNodes(shell),pos=POSITIONS[key],x=shell.clientWidth*pos.x/100,y=shell.clientHeight*pos.y/100;nodes.pot.textContent=pos.icon;nodes.pot.style.left=x+'px';nodes.pot.style.top=y+'px';nodes.pot.classList.remove('show');nodes.blast.classList.remove('fire');nodes.blast.style.left=x+'px';nodes.blast.style.top=y+'px';void nodes.pot.offsetWidth;nodes.pot.classList.add('show');nodes.blast.classList.add('fire');var startX=shell.clientWidth/2,startY=Math.max(0,shell.clientHeight*.04),dx=x-startX,dy=y-startY,len=Math.max(40,Math.sqrt(dx*dx+dy*dy)),angle=Math.atan2(dy,dx)*180/Math.PI-90,ray=document.createElement('i');ray.className='pointerBlastRay';ray.style.left=(startX-4)+'px';ray.style.top=startY+'px';ray.style.height=len+'px';ray.style.setProperty('--ray-angle',angle+'deg');shell.appendChild(ray);window.setTimeout(function(){if(ray.parentNode){ray.parentNode.removeChild(ray);}},900);window.setTimeout(function(){nodes.blast.classList.remove('fire');},900);}
    function syncFromWinningBoard(){var win=document.querySelector('.betBox.win,.betBox.winner,.board-token.win,[data-winner="1"]');var key=detectKey(win);if(key){fireWinnerFx(key);}}
    ready(function(){var shell=document.getElementById('wheelShell');if(shell){ensureFxNodes(shell);}var board=document.getElementById('board')||document.body;if(window.MutationObserver&&board){new MutationObserver(syncFromWinningBoard).observe(board,{subtree:true,childList:true,attributes:true,attributeFilter:['class','data-winner']});}window.setInterval(syncFromWinningBoard,700);});
})();
// CODEX-FRUITS-WINNER-FX-END
</script>
<style id="codex-fruits-final-wheel-override">
#stage{--fl-final-wheel:min(112vw,430px)!important}
#stage #wheelZone{top:72px!important;height:calc(var(--fl-final-wheel) + 72px)!important;overflow:visible!important;transform:translateX(-50%)!important}
#stage #wheelZone #wheelShell{width:var(--fl-final-wheel)!important;height:var(--fl-final-wheel)!important;max-width:none!important;max-height:none!important;background:none!important;overflow:visible!important}
#stage #wheelZone #wheelShell:before,#stage #wheelZone #wheelShell:after{display:none!important;content:none!important}
#stage #wheelTitle,#stage #wheelAura,#stage #wheelRays,#stage #wheelGlow,#stage #wheelScan,#stage #wheelHaloRing,#stage .sectorLine,#stage .wheelFruit,#stage #wheelCenter,#stage #wheelCenterLogo,#stage #pointer,#stage #wheelShell .flWheelCover,#stage #wheelRotator .flWheelCover,#stage #wheelShell .flWheelBadge{display:none!important}
#stage #wheelZone #flWinnerPointer{position:absolute!important;left:50%!important;top:calc(var(--fl-final-wheel) * .46)!important;width:64px!important;height:82px!important;transform:translateX(-50%)!important;z-index:42!important;pointer-events:none!important;filter:drop-shadow(0 11px 15px rgba(0,0,0,.44)) drop-shadow(0 0 14px rgba(255,221,116,.22))!important}
#stage #wheelZone #flWinnerPointer:before{content:""!important;position:absolute!important;left:50%!important;top:0!important;width:32px!important;height:32px!important;transform:translateX(-50%)!important;border-radius:50%!important;background:radial-gradient(circle at 34% 28%,#fff7d8 0,#ffd565 34%,#b45b00 72%,#5d2100 100%)!important;border:3px solid rgba(255,245,190,.96)!important;box-shadow:inset 0 2px 0 rgba(255,255,255,.78),0 0 0 3px rgba(139,62,0,.50),0 0 20px rgba(255,214,93,.42)!important}
#stage #wheelZone #flWinnerPointer:after{content:""!important;position:absolute!important;left:50%!important;top:28px!important;transform:translateX(-50%)!important;width:0!important;height:0!important;border-left:19px solid transparent!important;border-right:19px solid transparent!important;border-top:39px solid #ffd45b!important;filter:drop-shadow(0 2px 0 rgba(255,255,255,.52)) drop-shadow(0 9px 12px rgba(0,0,0,.42))!important}
#stage #pointerBlast{top:calc(var(--fl-final-wheel) * .49)!important}
#stage #timer{top:calc(72px + var(--fl-final-wheel) * .83)!important}
#stage #statusBar{top:calc(72px + var(--fl-final-wheel) * .83 + 80px)!important}
#stage #winnerBanner{top:calc(72px + var(--fl-final-wheel) * .83 + 56px)!important}
@media(max-height:720px){#stage{--fl-final-wheel:min(112vw,430px)!important}#stage #wheelZone{top:74px!important;transform:translateX(-50%) scale(.96)!important}#stage #timer{top:calc(74px + var(--fl-final-wheel) * .79)!important}}
@media(max-width:370px){#stage{--fl-final-wheel:min(118vw,420px)!important}}
</style>
<style id="codex-fruits-visual-correction">
  #stage {
    --fl-wheel-real-size: min(108vw, 412px) !important;
  }

  #stage #wheelZone {
    top: 70px !important;
    width: var(--fl-wheel-real-size) !important;
    height: calc(var(--fl-wheel-real-size) + 82px) !important;
    overflow: visible !important;
    filter: drop-shadow(0 20px 30px rgba(0, 0, 0, .4)) drop-shadow(0 0 18px rgba(255, 206, 104, .2)) !important;
  }

  #stage #wheelShell {
    width: var(--fl-wheel-real-size) !important;
    height: var(--fl-wheel-real-size) !important;
    background: transparent !important;
    overflow: visible !important;
    position: relative !important;
    isolation: isolate !important;
    z-index: 3 !important;
    border-radius: 0 !important;
  }
  #stage #wheelShell::before,
  #stage #wheelShell::after {
    display: none !important;
    content: none !important;
    background: none !important;
    box-shadow: none !important;
  }

  #stage #wheelBackdrop,
  #stage #wheelCenterLogo,
  #stage .flWheelCover,
  #stage .flWheelBadge,
  #stage #wheelTitle,
  #stage #wheelAura,
  #stage #wheelRays,
  #stage #wheelGlow,
  #stage #wheelScan,
  #stage #wheelHaloRing,
  #stage .sectorLine,
  #stage .wheelFruit,
  #stage #wheelCenter,
  #stage #pointer,
  #stage #flWinnerPointer {
    display: none !important;
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
  }

  #stage #wheelWindow {
    position: absolute !important;
    left: 7% !important;
    right: auto !important;
    top: 15% !important;
    bottom: auto !important;
    width: 86% !important;
    height: 86% !important;
    display: none !important;
    border-radius: 50% !important;
    overflow: hidden !important;
    transform-origin: 50% 50% !important;
    clip-path: circle(50% at 50% 50%) !important;
    -webkit-clip-path: circle(50% at 50% 50%) !important;
    z-index: 2 !important;
    background: transparent !important;
  }

  #stage #wheelRotator {
    display: block !important;
    position: absolute !important;
    inset: 0 !important;
    width: 100% !important;
    height: 100% !important;
    left: 0 !important;
    top: 0 !important;
    opacity: 1 !important;
    transform-origin: 50% 50% !important;
    will-change: transform !important;
    transition: none !important;
    z-index: 2 !important;
  }

  #stage #wheelFace {
    display: block !important;
    position: absolute !important;
    inset: 0 !important;
    border-radius: 50% !important;
    overflow: hidden !important;
    background: url('{{ $wheelFaceAsset }}') center center / cover no-repeat !important;
    box-shadow: inset 0 0 0 4px rgba(255, 244, 190, .88), inset 0 0 0 12px rgba(84, 34, 124, .72), 0 14px 24px rgba(0, 0, 0, .34) !important;
    z-index: 2 !important;
  }

  #stage #wheelCover {
    display: block !important;
    position: absolute !important;
    left: 50% !important;
    top: -12% !important;
    width: 100% !important;
    height: auto !important;
    transform: translateX(-50%) !important;
    object-fit: contain !important;
    clip-path: inset(0 0 44% 0) !important;
    -webkit-clip-path: inset(0 0 44% 0) !important;
    z-index: 6 !important;
    pointer-events: none !important;
    opacity: 1 !important;
    visibility: visible !important;
  }

  #stage.fl-wheel-spinning #wheelRotator {
    animation: none !important;
  }

  #stage.fl-wheel-settling #wheelRotator {
    animation: none !important;
  }

  @keyframes flWheelRealSpin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
  }

  @keyframes flWheelSettle {
    0% { transform: rotate(0deg) scale(1); }
    72% { transform: rotate(690deg) scale(1.012); }
    100% { transform: rotate(720deg) scale(1); }
  }

  #stage #flWinnerPointer,
  #stage #pointer {
    left: 50% !important;
    top: 47.5% !important;
    transform: translate(-50%, -50%) !important;
    z-index: 8 !important;
  }

  #stage #pointerBlast {
    z-index: 45 !important;
  }

  #stage.fl-wheel-settling #pointerBlast {
    animation: flPointerBlast .82s ease-out 1 !important;
  }

  @keyframes flPointerBlast {
    0% { opacity: 0; transform: translate(-50%, -50%) scale(.4); filter: blur(0); }
    25% { opacity: .95; transform: translate(-50%, -50%) scale(1.1); }
    100% { opacity: 0; transform: translate(-50%, -50%) scale(2.2); filter: blur(6px); }
  }

  #stage .wheelWinnerPot {
    z-index: 44 !important;
  }

  #stage #timer {
    left: 50% !important;
    right: auto !important;
    top: calc(70px + var(--fl-wheel-real-size) * .79) !important;
    bottom: auto !important;
    transform: translateX(-50%) !important;
    width: 76px !important;
    height: 76px !important;
    z-index: 26 !important;
    color: #fff !important;
    background: radial-gradient(circle at 50% 38%, #31486f 0 34%, #13223c 35% 62%, #050913 63% 100%) !important;
    border: 3px solid rgba(255, 211, 99, .95) !important;
    box-shadow: 0 10px 22px rgba(0, 0, 0, .52), inset 0 0 18px rgba(255, 255, 255, .12) !important;
  }

  #stage #countNum {
    font-size: 24px !important;
    line-height: 1 !important;
    color: #fff !important;
    text-shadow: 0 2px 5px rgba(0, 0, 0, .85), 0 0 10px rgba(61, 170, 255, .65) !important;
  }

  #stage #statusBar {
    top: calc(70px + var(--fl-wheel-real-size) * .79 + 84px) !important;
    z-index: 20 !important;
  }

  #stage #board {
    margin-top: 38px !important;
  }

  #stage .betBox {
    overflow: hidden !important;
  }

  #stage .betBox .combo {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 7px !important;
    min-height: 34px !important;
    position: relative !important;
    z-index: 2 !important;
  }

  #stage .betBox .fruitBadge {
    flex: 0 0 auto !important;
    margin: 0 !important;
  }

  #stage .betBox .visualPotName {
    margin: 0 !important;
    font-size: 12px !important;
    font-weight: 800 !important;
    letter-spacing: .02em !important;
    color: #fff5c8 !important;
    text-shadow: 0 2px 8px rgba(0, 0, 0, .58) !important;
    white-space: nowrap !important;
  }

  #stage .betBox .visualPotName::after {
    content: attr(data-multiplier-label);
    margin-left: 2px;
    color: #ffe682;
  }

  #stage .betBox .multText {
    position: absolute !important;
    inset: auto -8px -10px auto !important;
    z-index: 1 !important;
    font-size: 58px !important;
    font-weight: 900 !important;
    line-height: 1 !important;
    opacity: .12 !important;
    color: #ffffff !important;
    text-shadow: none !important;
    transform: rotate(-10deg) !important;
    pointer-events: none !important;
  }

  @media (max-width: 540px) {
    #stage #wheelZone {
      top: 82px !important;
    }

    #stage #timer {
      top: calc(82px + var(--fl-wheel-real-size) * .79) !important;
      bottom: auto !important;
      width: 66px !important;
      height: 66px !important;
    }

    #stage #board {
      margin-top: 34px !important;
    }

    #stage .betBox .multText {
      font-size: 48px !important;
    }
  }
</style>
<script id="codex-fruits-visual-correction-script">
(function(){
  function syncBoardMultipliers(){
    document.querySelectorAll('#board .betBox').forEach(function(box){
      var name = box.querySelector('.visualPotName');
      var mult = box.querySelector('.multText');
      if(!name || !mult) return;
      var multiplier = (mult.textContent || '').trim();
      name.dataset.multiplierLabel = multiplier ? ' ' + multiplier : '';
      mult.setAttribute('aria-hidden', 'true');
    });
  }

  function boot(){
    syncBoardMultipliers();
    var stage = document.getElementById('stage');
    if(stage){
      stage.classList.remove('fl-wheel-spinning', 'fl-wheel-settling');
      window.clearTimeout(stage._flSettleTimer);
      delete stage._flSettleTimer;
      delete stage._flWheelAngle;
      delete stage._flWheelTs;
    }
    window.setInterval(syncBoardMultipliers, 700);
  }

  if(document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();
</script>
<style id="codex-fruits-board-modal-fix">
  #stage #board .betBox .combo{
    position:absolute !important;
    left:50% !important;
    top:50% !important;
    right:auto !important;
    width:auto !important;
    min-height:0 !important;
    display:flex !important;
    flex-direction:column !important;
    align-items:center !important;
    justify-content:center !important;
    gap:8px !important;
    transform:translate(-50%,-50%) !important;
    z-index:3 !important;
  }

  #stage #board .betBox .fruitBadge{
    margin:0 !important;
    align-self:center !important;
  }

  #stage #board .betBox .visualPotName{
    margin:0 !important;
    text-align:center !important;
    white-space:nowrap !important;
  }

  #stage #board .betBox .multText{
    left:auto !important;
    right:10px !important;
    top:auto !important;
    bottom:10px !important;
    width:auto !important;
    transform:rotate(-10deg) !important;
    opacity:.14 !important;
    background:none !important;
    padding:0 !important;
  }

  #appModal{
    position:fixed !important;
    inset:0 !important;
    width:100vw !important;
    height:100dvh !important;
    padding:0 !important;
    z-index:120 !important;
    background:rgba(4,7,18,.88) !important;
    backdrop-filter:blur(16px) saturate(128%) !important;
  }

  #appModal.is-open{
    display:flex !important;
    align-items:stretch !important;
    justify-content:stretch !important;
  }

  #appModal .modalCard{
    width:100vw !important;
    max-width:none !important;
    height:100dvh !important;
    max-height:none !important;
    margin:0 !important;
    border-radius:0 !important;
    border:0 !important;
    box-shadow:none !important;
    display:flex !important;
    flex-direction:column !important;
  }

  #appModal .modalHead{
    position:sticky !important;
    top:0 !important;
    z-index:2 !important;
    padding:max(18px, env(safe-area-inset-top)) 18px 16px 18px !important;
    background:linear-gradient(180deg,rgba(34,41,90,.98),rgba(18,22,48,.94)) !important;
  }

  #appModal .modalBody{
    flex:1 1 auto !important;
    min-height:0 !important;
    overflow:auto !important;
    padding:18px 18px calc(18px + env(safe-area-inset-bottom)) 18px !important;
  }

  #winPopup{
    position:fixed !important;
    inset:0 !important;
    width:100vw !important;
    height:100dvh !important;
    display:none !important;
    align-items:center !important;
    justify-content:center !important;
    padding:24px !important;
    z-index:121 !important;
    background:rgba(5,9,22,.72) !important;
    backdrop-filter:blur(14px) saturate(128%) !important;
  }

  #winPopup.show{
    display:flex !important;
  }

  #winPopup .winPopupCard{
    width:min(100%,520px) !important;
  }

  @media (max-width: 540px){
    #appModal .modalHead,
    #appModal .modalBody{
      padding-left:14px !important;
      padding-right:14px !important;
    }
  }
</style>
<style id="codex-fruits-original-wheel-art">
  #stage{
    --fl-wheel-real-size:min(112vw,420px) !important;
    --fl-timer-size:124px !important;
  }

  #stage #wheelBackdrop,
  #stage #wheelAura,
  #stage #wheelRays,
  #stage #wheelGlow,
  #stage #wheelScan,
  #stage #wheelHaloRing,
  #stage #wheelTitle,
  #stage #wheelCover,
  #stage #wheelCenter,
  #stage #wheelCenterLogo,
  #stage #pointer,
  #stage .sectorLine,
  #stage .wheelFruit,
  #stage #flWinnerPointer,
  #stage #pointerBlast,
  #stage .pointerBlastRay,
  #stage .wheelWinnerPot,
  #stage #wheelShell .flWheelCover,
  #stage #wheelRotator .flWheelCover,
  #stage #wheelShell .flWheelBadge{
    display:none !important;
  }

  #stage #wheelZone{
    top:66px !important;
    width:var(--fl-wheel-real-size) !important;
    height:calc(var(--fl-wheel-real-size) + 126px) !important;
    overflow:visible !important;
    transform:translateX(-50%) !important;
    filter:drop-shadow(0 22px 34px rgba(0,0,0,.38)) !important;
  }

  #stage #wheelShell{
    position:relative !important;
    left:auto !important;
    top:0 !important;
    width:var(--fl-wheel-real-size) !important;
    height:var(--fl-wheel-real-size) !important;
    margin:0 auto !important;
    background:none !important;
    box-shadow:none !important;
    overflow:visible !important;
    isolation:isolate !important;
    border-radius:50% !important;
  }

  #stage #wheelShell::before{
    content:none !important;
    display:none !important;
  }

  #stage #wheelShell::after,
  #stage #wheelFace::before,
  #stage #wheelFace::after{
    content:none !important;
    display:none !important;
  }

  #stage #wheelWindow{
    position:absolute !important;
    inset:0 !important;
    width:100% !important;
    height:100% !important;
    left:0 !important;
    top:0 !important;
    transform:none !important;
    border-radius:50% !important;
    overflow:hidden !important;
    background:transparent !important;
    box-shadow:none !important;
    clip-path:circle(50% at 50% 50%) !important;
    -webkit-clip-path:circle(50% at 50% 50%) !important;
    z-index:2 !important;
  }

  #stage #wheelRotator{
    position:absolute !important;
    inset:0 !important;
    width:100% !important;
    height:100% !important;
    left:0 !important;
    top:0 !important;
    transform-origin:50% 50% !important;
    will-change:transform !important;
    backface-visibility:hidden !important;
    z-index:2 !important;
  }

  #stage #wheelFace{
    position:absolute !important;
    inset:0 !important;
    width:100% !important;
    height:100% !important;
    border-radius:50% !important;
    background:url('{{ $wheelFaceAsset }}') center center / 100% 100% no-repeat !important;
    box-shadow:none !important;
    image-rendering:auto !important;
    filter:none !important;
    backface-visibility:hidden !important;
  }

  #stage #timer{
    display:flex !important;
    left:50% !important;
    top:calc(66px + var(--fl-wheel-real-size) - 4px) !important;
    width:var(--fl-timer-size) !important;
    height:var(--fl-timer-size) !important;
    transform:translateX(-50%) !important;
    border:0 !important;
    border-radius:0 !important;
    background:url('{{ $timerStopwatchAsset }}') center / contain no-repeat !important;
    box-shadow:none !important;
    color:#fff3c9 !important;
    z-index:8 !important;
  }

  #stage #timerPulse{
    display:none !important;
  }

  #stage #countNum{
    position:absolute !important;
    left:50% !important;
    top:53% !important;
    transform:translate(-50%,-50%) !important;
    min-width:56px !important;
    height:56px !important;
    display:flex !important;
    align-items:center !important;
    justify-content:center !important;
    font-size:34px !important;
    line-height:1 !important;
    color:#a45a0f !important;
    text-shadow:0 1px 0 rgba(255,248,225,.86),0 2px 8px rgba(255,203,120,.28) !important;
  }

  #stage #statusBar{
    top:calc(66px + var(--fl-wheel-real-size) - 42px) !important;
    min-width:188px !important;
    max-width:calc(100% - 92px) !important;
    padding:9px 18px !important;
    border-radius:16px !important;
    background:linear-gradient(180deg,rgba(92,44,168,.98),rgba(34,18,72,.98)) !important;
    border:2px solid rgba(255,215,122,.68) !important;
    color:#fff5cf !important;
    text-shadow:0 2px 0 rgba(46,18,0,.36),0 0 10px rgba(255,225,140,.18) !important;
    box-shadow:0 16px 28px rgba(0,0,0,.34),0 0 18px rgba(255,214,90,.12),inset 0 1px 0 rgba(255,255,255,.22) !important;
    font-size:14px !important;
    letter-spacing:.03em !important;
    z-index:32 !important;
  }

  #stage #statusBar::before,
  #stage #statusBar::after{
    display:none !important;
  }

  #stage #toast{
    left:50% !important;
    bottom:calc(max(env(safe-area-inset-bottom), 8px) + 86px) !important;
    transform:translateX(-50%) !important;
    width:min(320px, calc(100% - 32px)) !important;
    min-width:0 !important;
    max-width:calc(100% - 32px) !important;
    padding:12px 16px !important;
    border-radius:18px !important;
    background:linear-gradient(180deg,rgba(94,45,170,.98),rgba(30,16,62,.98)) !important;
    border:2px solid rgba(255,215,122,.62) !important;
    color:#fff5cf !important;
    text-shadow:0 2px 0 rgba(46,18,0,.34) !important;
    box-shadow:0 18px 28px rgba(0,0,0,.34),0 0 18px rgba(255,214,90,.10),inset 0 1px 0 rgba(255,255,255,.18) !important;
    font-size:15px !important;
    font-weight:1000 !important;
    z-index:34 !important;
  }

  @media (max-width:540px){
    #stage{
      --fl-wheel-real-size:min(116vw,404px) !important;
      --fl-timer-size:116px !important;
    }

    #stage #wheelZone{
      top:72px !important;
      height:calc(var(--fl-wheel-real-size) + 118px) !important;
    }

    #stage #timer{
      top:calc(72px + var(--fl-wheel-real-size) - 20px) !important;
      width:112px !important;
      height:112px !important;
    }

    #stage #statusBar{
      top:calc(72px + var(--fl-wheel-real-size) - 36px) !important;
    }

    #stage #countNum{
      min-width:52px !important;
      height:52px !important;
      font-size:31px !important;
    }

    #stage #toast{
      bottom:calc(max(env(safe-area-inset-bottom), 8px) + 82px) !important;
      width:min(304px, calc(100% - 28px)) !important;
      font-size:14px !important;
    }
  }

  @media (max-height:720px){
    #stage{
      --fl-wheel-real-size:min(100vw,356px) !important;
      --fl-timer-size:108px !important;
    }

    #stage #wheelZone{
      top:74px !important;
      height:calc(var(--fl-wheel-real-size) + 104px) !important;
    }

    #stage #timer{
      top:calc(74px + var(--fl-wheel-real-size) - 16px) !important;
      width:104px !important;
      height:104px !important;
    }

    #stage #statusBar{
      top:calc(74px + var(--fl-wheel-real-size) - 32px) !important;
    }

    #stage #countNum{
      min-width:48px !important;
      height:48px !important;
      font-size:28px !important;
    }

    #stage #toast{
      bottom:calc(max(env(safe-area-inset-bottom), 8px) + 74px) !important;
      font-size:13px !important;
    }
  }
</style>
<style id="codex-fruits-compact-ui-pass">
  #stage{
    --fl-wheel-real-size:min(78vw, 302px) !important;
    --fl-timer-size:84px !important;
  }

  #stage .topRow{
    top:max(env(safe-area-inset-top), 8px) !important;
    height:88px !important;
    padding:0 12px !important;
    gap:6px !important;
  }

  #stage .dockRight{
    top:0 !important;
    right:12px !important;
    gap:10px !important;
  }

  #stage .circleBtn,
  #stage .menuBtn{
    width:40px !important;
    height:40px !important;
    font-size:17px !important;
  }

  #stage .midTop{
    right:118px !important;
    top:2px !important;
    gap:5px !important;
  }

  #stage .latencyPill,
  #stage .roundPill{
    height:30px !important;
    padding:0 10px !important;
    font-size:10px !important;
    justify-content:center !important;
    white-space:nowrap !important;
  }

  #stage .roundPill{
    min-width:74px !important;
  }

  #stage .latencyPill{
    min-width:54px !important;
  }

  #stage #wheelZone{
    top:88px !important;
    width:var(--fl-wheel-real-size) !important;
    height:calc(var(--fl-wheel-real-size) + 154px) !important;
    filter:drop-shadow(0 16px 24px rgba(0,0,0,.32)) !important;
  }

  #stage #wheelShell{
    width:var(--fl-wheel-real-size) !important;
    height:var(--fl-wheel-real-size) !important;
  }

  #stage #timer{
    top:calc(88px + var(--fl-wheel-real-size) + 16px) !important;
    width:var(--fl-timer-size) !important;
    height:var(--fl-timer-size) !important;
    z-index:42 !important;
  }

  #stage #countNum{
    min-width:42px !important;
    height:42px !important;
    font-size:26px !important;
  }

  #stage #statusBar{
    top:calc(88px + var(--fl-wheel-real-size) + 106px) !important;
    min-width:164px !important;
    padding:8px 14px !important;
    font-size:12px !important;
    z-index:43 !important;
  }

  #stage #winnerBanner{
    top:calc(88px + var(--fl-wheel-real-size) + 48px) !important;
    font-size:24px !important;
    z-index:44 !important;
  }

  #stage #board{
    width:calc(100% - 26px) !important;
    min-height:212px !important;
    bottom:86px !important;
    padding:10px 10px 12px !important;
    border-radius:22px !important;
    column-gap:8px !important;
    row-gap:8px !important;
  }

  #stage .betBox{
    height:128px !important;
    border-radius:18px !important;
  }

  #stage .betBox .combo{
    top:34px !important;
  }

  #stage .betBox .fruitBadge{
    width:44px !important;
    height:44px !important;
    font-size:25px !important;
  }

  #stage .betBox .visualPotName{
    display:none !important;
  }

  #stage .betBox .multText{
    font-size:18px !important;
  }

  #stage #toast{
    bottom:calc(max(env(safe-area-inset-bottom), 8px) + 80px) !important;
    width:min(292px, calc(100% - 28px)) !important;
    padding:11px 14px !important;
    font-size:14px !important;
  }

  @media (max-width:390px){
    #stage{
      --fl-wheel-real-size:min(76vw, 286px) !important;
      --fl-timer-size:78px !important;
    }

    #stage .topRow{
      height:82px !important;
      padding:0 10px !important;
    }

    #stage .midTop{
      right:98px !important;
    }

    #stage #wheelZone{
      top:84px !important;
      height:calc(var(--fl-wheel-real-size) + 138px) !important;
    }

    #stage #timer{
      top:calc(84px + var(--fl-wheel-real-size) + 14px) !important;
    }

    #stage #statusBar{
      top:calc(84px + var(--fl-wheel-real-size) + 96px) !important;
      min-width:160px !important;
      font-size:12px !important;
    }

    #stage #countNum{
      min-width:40px !important;
      height:40px !important;
      font-size:24px !important;
    }

    #stage #board{
      width:calc(100% - 22px) !important;
      min-height:202px !important;
      bottom:84px !important;
      column-gap:7px !important;
      row-gap:7px !important;
    }

    #stage .betBox{
      height:120px !important;
    }

    #stage .betBox .multText{
      font-size:16px !important;
    }
  }

  @media (max-height:760px){
    #stage{
      --fl-wheel-real-size:min(74vw, 276px) !important;
      --fl-timer-size:74px !important;
    }

    #stage #wheelZone{
      top:82px !important;
      height:calc(var(--fl-wheel-real-size) + 126px) !important;
    }

    #stage #timer{
      top:calc(82px + var(--fl-wheel-real-size) + 10px) !important;
    }

    #stage #statusBar{
      top:calc(82px + var(--fl-wheel-real-size) + 88px) !important;
    }

    #stage #board{
      min-height:194px !important;
      bottom:76px !important;
    }

    #stage .betBox{
      height:114px !important;
    }
  }
</style>
<style id="codex-fruits-modal-final-pass">
  #stage #winnersBtn,
  #stage #soundBtn{
    display:grid !important;
  }

  #stage .topRow .dockRight{
    z-index:8 !important;
  }

  #stage .topRow .midTop{
    z-index:4 !important;
  }

  #winPopup{
    position:absolute !important;
    left:50% !important;
    top:50% !important;
    inset:auto !important;
    width:min(362px, calc(100% - 34px)) !important;
    height:auto !important;
    display:block !important;
    padding:0 !important;
    background:none !important;
    backdrop-filter:none !important;
    -webkit-backdrop-filter:none !important;
    pointer-events:none !important;
    opacity:0 !important;
    transform:translate(-50%, -50%) scale(.86) !important;
    z-index:86 !important;
  }

  #winPopup.show{
    animation:winPopupPop 2.25s cubic-bezier(.19,.86,.22,1) forwards !important;
  }

  #winPopup .winPopupCard{
    width:100% !important;
    max-width:362px !important;
  }

  #appModal{
    position:absolute !important;
    inset:0 !important;
    width:100% !important;
    height:100% !important;
    display:none !important;
    align-items:center !important;
    justify-content:center !important;
    padding:16px !important;
    background:rgba(6, 8, 18, .72) !important;
    backdrop-filter:blur(8px) saturate(120%) !important;
    -webkit-backdrop-filter:blur(8px) saturate(120%) !important;
    z-index:160 !important;
  }

  #appModal.is-open,
  #appModal.open,
  #appModal.show,
  #appModal.visible{
    display:flex !important;
  }

  #appModal .modalCard,
  #appModal .modalCard[data-panel="players"],
  #appModal .modalCard[data-panel="settings"],
  #appModal .modalCard[data-panel="trend"]{
    width:min(404px, calc(100% - 8px)) !important;
    max-width:min(404px, calc(100% - 8px)) !important;
    height:auto !important;
    min-height:0 !important;
    max-height:min(680px, calc(100% - 112px)) !important;
    margin:0 auto !important;
    display:flex !important;
    flex-direction:column !important;
    overflow:auto !important;
  }

  #appModal .modalHead{
    position:sticky !important;
    top:0 !important;
    z-index:2 !important;
  }

  #appModal .modalClose{
    flex:0 0 auto !important;
    position:relative !important;
    z-index:3 !important;
  }

  #appModal .modalBody,
  #appModal .panelCanvas,
  #appModal .playerGrid,
  #appModal .playerRosterGrid,
  #appModal .settingsGrid{
    min-width:0 !important;
  }

  #appModal .modalBody{
    flex:1 1 auto !important;
    overflow-y:auto !important;
    overflow-x:hidden !important;
    -webkit-overflow-scrolling:touch !important;
  }

  #appModal .modalFooter{
    flex:0 0 auto !important;
    padding:0 16px 12px !important;
    text-align:center !important;
    font-size:7px !important;
    opacity:.05 !important;
    line-height:1.2 !important;
    letter-spacing:.08em !important;
    text-transform:uppercase !important;
    color:rgba(255, 236, 188, .72) !important;
  }

  #appModal .modalTableWrap,
  #appModal .historyTableWrap{
    width:100% !important;
    overflow-x:hidden !important;
    overflow-y:auto !important;
    -webkit-overflow-scrolling:touch !important;
  }

  #appModal .modalTable,
  #appModal .historyTable{
    width:100% !important;
    min-width:0 !important;
    table-layout:fixed !important;
    word-break:break-word !important;
  }

  #appModal .modalGrid,
  #appModal .settingsGrid,
  #appModal .playerGrid,
  #appModal .playerRosterGrid{
    width:100% !important;
  }

  #appModal .modalRow,
  #appModal .settingRow{
    width:100% !important;
  }

  #appModal .playerGrid,
  #appModal .playerRosterGrid{
    grid-template-columns:repeat(6,minmax(0,1fr)) !important;
    gap:6px !important;
  }

  @media (max-width: 420px){
    #appModal{
      padding:12px !important;
    }

    #appModal .modalCard,
    #appModal .modalCard[data-panel="players"],
    #appModal .modalCard[data-panel="settings"],
    #appModal .modalCard[data-panel="trend"]{
      width:100% !important;
      max-width:100% !important;
      max-height:min(640px, calc(100% - 84px)) !important;
      border-radius:20px !important;
    }

    #appModal .modalHead{
      padding:14px 14px 12px !important;
    }

    #appModal .modalBody{
      padding:12px 14px 14px !important;
    }

    #appModal .playerGrid,
    #appModal .playerRosterGrid{
      grid-template-columns:repeat(6,minmax(0,1fr)) !important;
    }

    #appModal .modalGrid,
    #appModal .settingsGrid{
      grid-template-columns:1fr !important;
    }

    #appModal .modalRow,
    #appModal .settingRow{
      grid-template-columns:1fr !important;
      align-items:flex-start !important;
    }
  }
</style>
<script id="codex-fruits-real-wheel-runtime-final">
(function(){
  const applyRealWheel = () => {
    const shell = document.getElementById('wheelShell');
    const wheelWindow = document.getElementById('wheelWindow');
    const wheelRotator = document.getElementById('wheelRotator');
    const wheelFace = document.getElementById('wheelFace');
    const wheelCover = document.getElementById('wheelCover');
    if(!shell || !wheelWindow || !wheelRotator || !wheelFace || !wheelCover) return;

    if (wheelCover.parentElement !== shell) {
      shell.appendChild(wheelCover);
    }

    shell.style.setProperty('background', 'none', 'important');
    shell.style.setProperty('border-radius', '50%', 'important');
    shell.style.setProperty('overflow', 'visible', 'important');
    shell.style.setProperty('position', 'relative', 'important');
    shell.style.setProperty('transform', 'none', 'important');

    const useVariantWheelFaceZoom = @json($currentGameCode !== 'fruits_loop');
    const wheelWindowClip = useVariantWheelFaceZoom ? 'circle(49% at 50% 50%)' : 'circle(47.8% at 50% 53%)';
    const wheelSpan = useVariantWheelFaceZoom ? '95.6%' : '93.2%';

    wheelWindow.style.setProperty('display', 'block', 'important');
    wheelWindow.style.setProperty('position', 'absolute', 'important');
    wheelWindow.style.setProperty('inset', '0', 'important');
    wheelWindow.style.setProperty('width', '100%', 'important');
    wheelWindow.style.setProperty('height', '100%', 'important');
    wheelWindow.style.setProperty('border-radius', '50%', 'important');
    wheelWindow.style.setProperty('overflow', 'hidden', 'important');
    wheelWindow.style.setProperty('background', 'transparent', 'important');
    wheelWindow.style.setProperty('clip-path', wheelWindowClip, 'important');
    wheelWindow.style.setProperty('-webkit-clip-path', wheelWindowClip, 'important');

    wheelRotator.style.setProperty('display', 'block', 'important');
    wheelRotator.style.setProperty('position', 'absolute', 'important');
    wheelRotator.style.setProperty('inset', 'auto', 'important');
    wheelRotator.style.setProperty('left', '50%', 'important');
    wheelRotator.style.setProperty('top', '50%', 'important');
    wheelRotator.style.setProperty('width', wheelSpan, 'important');
    wheelRotator.style.setProperty('height', wheelSpan, 'important');
    wheelRotator.style.setProperty('transform-origin', '50% 50%', 'important');
    wheelFace.style.setProperty('display', 'block', 'important');
    wheelFace.style.setProperty('position', 'absolute', 'important');
    wheelFace.style.setProperty('inset', '0', 'important');
    wheelFace.style.setProperty('width', '100%', 'important');
    wheelFace.style.setProperty('height', '100%', 'important');
    wheelFace.style.setProperty('border-radius', '50%', 'important');
    wheelFace.style.setProperty('background', "url('{{ $wheelFaceAsset }}') center center / 100% 100% no-repeat", 'important');

    if (useVariantWheelFaceZoom) {
      wheelFace.style.setProperty('display', 'none', 'important');
      wheelFace.style.setProperty('background', 'none', 'important');

      let variantWheelImage = wheelRotator.querySelector('.flVariantWheelImage');
      if (!variantWheelImage) {
        variantWheelImage = document.createElement('img');
        variantWheelImage.className = 'flVariantWheelImage';
        variantWheelImage.alt = '';
        variantWheelImage.setAttribute('aria-hidden', 'true');
        wheelRotator.appendChild(variantWheelImage);
      }
      variantWheelImage.src = '{{ $wheelFaceAsset }}?v={{ time() }}';
      variantWheelImage.style.setProperty('display', 'block', 'important');
      variantWheelImage.style.setProperty('position', 'absolute', 'important');
      variantWheelImage.style.setProperty('inset', '0', 'important');
      variantWheelImage.style.setProperty('width', '100%', 'important');
      variantWheelImage.style.setProperty('height', '100%', 'important');
      variantWheelImage.style.setProperty('object-fit', 'contain', 'important');
      variantWheelImage.style.setProperty('object-position', 'center center', 'important');
      variantWheelImage.style.setProperty('pointer-events', 'none', 'important');

      document.querySelectorAll('.sectorLine').forEach((node) => {
        node.style.setProperty('display', 'none', 'important');
      });
      document.querySelectorAll('.wheelFruit').forEach((node) => {
        node.style.setProperty('display', 'none', 'important');
      });
      const wheelCenter = document.getElementById('wheelCenter');
      if (wheelCenter) {
        wheelCenter.style.setProperty('display', 'none', 'important');
      }
    }

    wheelCover.style.setProperty('display', 'block', 'important');
    wheelCover.style.setProperty('position', 'absolute', 'important');
    wheelCover.style.setProperty('left', '1%', 'important');
    wheelCover.style.setProperty('top', '-13%', 'important');
    wheelCover.style.setProperty('width', '98%', 'important');
    wheelCover.style.setProperty('height', '98%', 'important');
    wheelCover.style.setProperty('transform', 'none', 'important');
    wheelCover.style.setProperty('object-fit', 'contain', 'important');
    wheelCover.style.setProperty('clip-path', 'none', 'important');
    wheelCover.style.setProperty('-webkit-clip-path', 'none', 'important');
    wheelCover.style.setProperty('z-index', '8', 'important');
    wheelCover.style.setProperty('opacity', '1', 'important');
    wheelCover.style.setProperty('visibility', 'visible', 'important');
    wheelCover.style.setProperty('pointer-events', 'none', 'important');
    const timer = document.getElementById('timer');
    const timerPulse = document.getElementById('timerPulse');
    const countNum = document.getElementById('countNum');
    if (timer) {
      timer.style.setProperty('background', "url('{{ $timerStopwatchAsset }}') center / contain no-repeat", 'important');
      timer.style.setProperty('border', '0', 'important');
      timer.style.setProperty('box-shadow', 'none', 'important');
      timer.style.setProperty('backdrop-filter', 'none', 'important');
      timer.style.setProperty('border-radius', '0', 'important');
    }
    if (timerPulse) {
      timerPulse.style.setProperty('display', 'none', 'important');
      timerPulse.style.setProperty('animation', 'none', 'important');
      timerPulse.style.setProperty('opacity', '0', 'important');
    }
    if (countNum) {
      countNum.style.setProperty('text-shadow', '0 2px 10px rgba(86,24,0,.65), 0 0 18px rgba(255,233,150,.22)', 'important');
      countNum.style.setProperty('color', '#a45a0f', 'important');
    }
  };
  if(document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', applyRealWheel, { once: true });
  } else {
    applyRealWheel();
  }
  window.addEventListener('resize', applyRealWheel, { passive: true });
  window.addEventListener('orientationchange', applyRealWheel);
})();
</script>
<script id="codex-fruits-top-button-guard">
(function(){
  const openStageModal = (title, html, panel = 'generic') => {
    const modal = document.getElementById('appModal');
    const titleNode = document.getElementById('modalTitle');
    const bodyNode = document.getElementById('modalBody');
    const card = modal ? modal.querySelector('.modalCard') : null;
    if(!modal || !titleNode || !bodyNode) return;
    titleNode.textContent = title;
    bodyNode.innerHTML = html;
    modal.dataset.panel = panel;
    bodyNode.dataset.panel = panel;
    if(card) card.dataset.panel = panel;
    modal.hidden = false;
    modal.setAttribute('aria-hidden', 'false');
    modal.style.setProperty('display', 'flex', 'important');
    modal.classList.add('is-open', 'open', 'show', 'visible');
  };

  const openSettingsFallback = () => {
    const musicValue = Number(window.localStorage?.getItem('fruitsLoopMusicLevel') ?? '74');
    const soundValue = Number(window.localStorage?.getItem('fruitsLoopSoundEffectLevel') ?? '82');
    const soundEnabled = (window.localStorage?.getItem('fruits_loop_sound_enabled') ?? '1') !== '0';
    openStageModal('Settings', [
      '<div class="panelCanvas settings">',
      '<div class="settingsGrid">',
      '<div class="settingRow"><span class="settingLabel">Music</span><input class="themeRange" id="codexMusicRange" type="range" min="0" max="100" value="' + Math.max(0, Math.min(100, musicValue)) + '"><span class="settingValue" id="codexMusicValue">' + Math.max(0, Math.min(100, musicValue)) + '%</span></div>',
      '<div class="settingRow"><span class="settingLabel">Sound Effect</span><input class="themeRange" id="codexSoundRange" type="range" min="0" max="100" value="' + Math.max(0, Math.min(100, soundValue)) + '"><span class="settingValue" id="codexSoundValue">' + Math.max(0, Math.min(100, soundValue)) + '%</span></div>',
      '<div class="settingRow"><span class="settingLabel">Sound Status</span><button type="button" class="soundStateBtn' + (!soundEnabled ? ' off' : '') + '" id="codexSoundToggle">' + (soundEnabled ? 'ON' : 'OFF') + '</button></div>',
      '</div>',
      '</div>'
    ].join(''), 'settings');

    const musicRange = document.getElementById('codexMusicRange');
    const soundRange = document.getElementById('codexSoundRange');
    const musicLabel = document.getElementById('codexMusicValue');
    const soundLabel = document.getElementById('codexSoundValue');
    const soundToggle = document.getElementById('codexSoundToggle');

    if(musicRange){
      musicRange.addEventListener('input', () => {
        const value = Math.max(0, Math.min(100, Number(musicRange.value || 0)));
        window.localStorage?.setItem('fruitsLoopMusicLevel', String(value));
        if(musicLabel) musicLabel.textContent = value + '%';
      });
    }
    if(soundRange){
      soundRange.addEventListener('input', () => {
        const value = Math.max(0, Math.min(100, Number(soundRange.value || 0)));
        window.localStorage?.setItem('fruitsLoopSoundEffectLevel', String(value));
        if(soundLabel) soundLabel.textContent = value + '%';
      });
    }
    if(soundToggle){
      soundToggle.addEventListener('click', () => {
        const nextEnabled = soundToggle.textContent !== 'ON';
        soundToggle.textContent = nextEnabled ? 'ON' : 'OFF';
        soundToggle.classList.toggle('off', !nextEnabled);
        window.localStorage?.setItem('fruits_loop_sound_enabled', nextEnabled ? '1' : '0');
      });
    }
  };
  window.__codexOpenFruitLoopSettings = openSettingsFallback;

  const actionMap = {
    historyBtn: () => typeof window.openRealHistoryPopup === 'function' && window.openRealHistoryPopup(),
    trendBtn: () => typeof window.openRealHistoryPopup === 'function' && window.openRealHistoryPopup(),
    winnersBtn: () => typeof window.codexFruitLoopOpenWinners === 'function' && window.codexFruitLoopOpenWinners(),
    userBtn: () => {
      if (typeof window.codexFruitLoopOpenUsers === 'function') {
        window.codexFruitLoopOpenUsers();
        return;
      }
      if (typeof window.openProfessionalUsersPopup === 'function') {
        window.openProfessionalUsersPopup();
      }
    },
    infoBtn: () => typeof window.codexFruitLoopOpenInfo === 'function' && window.codexFruitLoopOpenInfo(),
    settingsBtn: () => {
      if (typeof window.codexFruitLoopOpenSettings === 'function') {
        window.codexFruitLoopOpenSettings();
        return;
      }
      openSettingsFallback();
    }
  };

  const attachGuard = () => {
    Object.entries(actionMap).forEach(([id, action]) => {
      const button = document.getElementById(id);
      if(!button) return;
      const guardedButton = button.dataset.codexTopGuardReady ? button : button.cloneNode(true);
      if(!button.dataset.codexTopGuardReady){
        guardedButton.dataset.codexTopGuardReady = '1';
        button.replaceWith(guardedButton);
      }
      if(guardedButton.dataset.codexTopGuardBound) return;
      guardedButton.dataset.codexTopGuardBound = '1';
      if(id === 'settingsBtn'){
        guardedButton.setAttribute('onclick', 'if(window.__codexFruitLoopOpenSettingsInline){ window.__codexFruitLoopOpenSettingsInline(event); } return false;');
        guardedButton.onclick = (event) => {
          if(event){
            event.preventDefault();
            event.stopPropagation();
          }
          if(typeof window.__codexOpenFruitLoopSettings === 'function'){
            window.__codexOpenFruitLoopSettings();
          }
          return false;
        };
      }
      guardedButton.addEventListener('click', (event) => {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();
        action();
      }, true);
    });
  };

  if(document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', attachGuard, { once: true });
  } else {
    attachGuard();
  }
  setInterval(attachGuard, 500);
})();
</script>
<script>
window.__codexFruitLoopOpenSettingsInline = function(event){
  if(event){
    event.preventDefault();
    if(event.stopPropagation) event.stopPropagation();
    if(event.stopImmediatePropagation) event.stopImmediatePropagation();
  }
  var modal = document.getElementById('appModal');
  var titleNode = document.getElementById('modalTitle');
  var bodyNode = document.getElementById('modalBody');
  var card = modal ? modal.querySelector('.modalCard') : null;
  if(!modal || !titleNode || !bodyNode) return false;
  var musicValue = Math.max(0, Math.min(100, Number((window.localStorage && window.localStorage.getItem('fruitsLoopMusicLevel')) || 74)));
  var soundValue = Math.max(0, Math.min(100, Number((window.localStorage && window.localStorage.getItem('fruitsLoopSoundEffectLevel')) || 82)));
  var soundEnabled = ((window.localStorage && window.localStorage.getItem('fruits_loop_sound_enabled')) || '1') !== '0';
  titleNode.textContent = 'Settings';
  bodyNode.innerHTML = ''
    + '<div class="panelCanvas settings">'
    +   '<div class="settingsGrid">'
    +     '<div class="settingRow"><span class="settingLabel">Music</span><input class="themeRange" id="codexInlineMusicRange" type="range" min="0" max="100" value="' + musicValue + '"><span class="settingValue" id="codexInlineMusicValue">' + musicValue + '%</span></div>'
    +     '<div class="settingRow"><span class="settingLabel">Sound Effect</span><input class="themeRange" id="codexInlineSoundRange" type="range" min="0" max="100" value="' + soundValue + '"><span class="settingValue" id="codexInlineSoundValue">' + soundValue + '%</span></div>'
    +     '<div class="settingRow"><span class="settingLabel">Sound Status</span><button type="button" class="soundStateBtn' + (!soundEnabled ? ' off' : '') + '" id="codexInlineSoundToggle">' + (soundEnabled ? 'ON' : 'OFF') + '</button></div>'
    +   '</div>'
    + '</div>';
  modal.dataset.panel = 'settings';
  bodyNode.dataset.panel = 'settings';
  if(card) card.dataset.panel = 'settings';
  modal.hidden = false;
  modal.setAttribute('aria-hidden', 'false');
  modal.style.setProperty('display', 'flex', 'important');
  modal.classList.add('is-open', 'open', 'show', 'visible');

  var musicRange = document.getElementById('codexInlineMusicRange');
  var soundRange = document.getElementById('codexInlineSoundRange');
  var musicLabel = document.getElementById('codexInlineMusicValue');
  var soundLabel = document.getElementById('codexInlineSoundValue');
  var soundToggle = document.getElementById('codexInlineSoundToggle');
  if(musicRange){
    musicRange.oninput = function(){
      var value = Math.max(0, Math.min(100, Number(musicRange.value || 0)));
      if(window.localStorage) window.localStorage.setItem('fruitsLoopMusicLevel', String(value));
      if(musicLabel) musicLabel.textContent = value + '%';
    };
  }
  if(soundRange){
    soundRange.oninput = function(){
      var value = Math.max(0, Math.min(100, Number(soundRange.value || 0)));
      if(window.localStorage) window.localStorage.setItem('fruitsLoopSoundEffectLevel', String(value));
      if(soundLabel) soundLabel.textContent = value + '%';
    };
  }
  if(soundToggle){
    soundToggle.onclick = function(toggleEvent){
      if(toggleEvent){
        toggleEvent.preventDefault();
        toggleEvent.stopPropagation();
      }
      var nextEnabled = soundToggle.textContent !== 'ON';
      soundToggle.textContent = nextEnabled ? 'ON' : 'OFF';
      soundToggle.classList.toggle('off', !nextEnabled);
      if(window.localStorage) window.localStorage.setItem('fruits_loop_sound_enabled', nextEnabled ? '1' : '0');
      return false;
    };
  }
  return false;
};
</script>
<script id="codex-fruits-modal-close-guard">
(function(){
  const forceCloseModal = () => {
    const modal = document.getElementById('appModal');
    if(!modal) return;
    modal.classList.remove('is-open', 'open', 'show', 'visible');
    modal.style.setProperty('display', 'none', 'important');
    modal.hidden = true;
    modal.setAttribute('aria-hidden', 'true');
  };

  const bindModalGuard = () => {
    const modal = document.getElementById('appModal');
    const close = document.getElementById('modalClose');
    if(close && !close.dataset.codexCloseBound){
      close.dataset.codexCloseBound = '1';
      close.addEventListener('click', forceCloseModal, true);
    }
    if(modal && !modal.dataset.codexBackdropBound){
      modal.dataset.codexBackdropBound = '1';
      modal.addEventListener('click', (event) => {
        if(event.target === modal){
          forceCloseModal();
        }
      }, true);
    }
  };

  if(document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', bindModalGuard, { once: true });
  } else {
    bindModalGuard();
  }
  setInterval(bindModalGuard, 500);
})();
</script>
<script id="codex-fruits-settings-last-pass">
(function(){
  const buildSettingsMarkup = () => {
    const musicValue = Math.max(0, Math.min(100, Number((window.localStorage && window.localStorage.getItem('fruitsLoopMusicLevel')) || 74)));
    const soundValue = Math.max(0, Math.min(100, Number((window.localStorage && window.localStorage.getItem('fruitsLoopSoundEffectLevel')) || 82)));
    const soundEnabled = ((window.localStorage && window.localStorage.getItem('fruits_loop_sound_enabled')) || '1') !== '0';
    return ''
      + '<div class="panelCanvas settings">'
      +   '<div class="settingsGrid">'
      +     '<div class="settingRow"><span class="settingLabel">Music</span><input class="themeRange" id="codexLastMusicRange" type="range" min="0" max="100" value="' + musicValue + '"><span class="settingValue" id="codexLastMusicValue">' + musicValue + '%</span></div>'
      +     '<div class="settingRow"><span class="settingLabel">Sound Effect</span><input class="themeRange" id="codexLastSoundRange" type="range" min="0" max="100" value="' + soundValue + '"><span class="settingValue" id="codexLastSoundValue">' + soundValue + '%</span></div>'
      +     '<div class="settingRow"><span class="settingLabel">Sound Status</span><button type="button" class="soundStateBtn' + (!soundEnabled ? ' off' : '') + '" id="codexLastSoundToggle">' + (soundEnabled ? 'ON' : 'OFF') + '</button></div>'
      +   '</div>'
      + '</div>';
  };

  const bindSettingsControls = () => {
    const musicRange = document.getElementById('codexLastMusicRange');
    const soundRange = document.getElementById('codexLastSoundRange');
    const musicValue = document.getElementById('codexLastMusicValue');
    const soundValue = document.getElementById('codexLastSoundValue');
    const soundToggle = document.getElementById('codexLastSoundToggle');

    if(musicRange){
      musicRange.oninput = function(){
        const value = Math.max(0, Math.min(100, Number(musicRange.value || 0)));
        if(window.localStorage) window.localStorage.setItem('fruitsLoopMusicLevel', String(value));
        if(musicValue) musicValue.textContent = value + '%';
      };
    }
    if(soundRange){
      soundRange.oninput = function(){
        const value = Math.max(0, Math.min(100, Number(soundRange.value || 0)));
        if(window.localStorage) window.localStorage.setItem('fruitsLoopSoundEffectLevel', String(value));
        if(soundValue) soundValue.textContent = value + '%';
      };
    }
    if(soundToggle){
      soundToggle.onclick = function(event){
        if(event){
          event.preventDefault();
          event.stopPropagation();
        }
        const nextEnabled = soundToggle.textContent !== 'ON';
        soundToggle.textContent = nextEnabled ? 'ON' : 'OFF';
        soundToggle.classList.toggle('off', !nextEnabled);
        if(window.localStorage) window.localStorage.setItem('fruits_loop_sound_enabled', nextEnabled ? '1' : '0');
        return false;
      };
    }
  };

  const openSettingsLastPass = (event) => {
    if(event){
      event.preventDefault();
      event.stopPropagation();
      if(event.stopImmediatePropagation) event.stopImmediatePropagation();
    }
    const modal = document.getElementById('appModal');
    const titleNode = document.getElementById('modalTitle');
    const bodyNode = document.getElementById('modalBody');
    const card = modal ? modal.querySelector('.modalCard') : null;
    if(!modal || !titleNode || !bodyNode) return false;
    titleNode.textContent = 'Settings';
    bodyNode.innerHTML = buildSettingsMarkup();
    modal.dataset.panel = 'settings';
    bodyNode.dataset.panel = 'settings';
    if(card) card.dataset.panel = 'settings';
    modal.hidden = false;
    modal.setAttribute('aria-hidden', 'false');
    modal.style.setProperty('display', 'flex', 'important');
    modal.classList.add('is-open', 'open', 'show', 'visible');
    bindSettingsControls();
    return false;
  };

  window.__codexFruitLoopOpenSettingsInline = openSettingsLastPass;
  window.__codexOpenFruitLoopSettings = openSettingsLastPass;
  window.codexFruitLoopOpenSettings = openSettingsLastPass;

  const bindSettingsButton = () => {
    const btn = document.getElementById('settingsBtn');
    if(!btn || btn.dataset.codexSettingsLastPassBound) return;
    btn.dataset.codexSettingsLastPassBound = '1';
    btn.onclick = openSettingsLastPass;
    btn.addEventListener('click', openSettingsLastPass, true);
    btn.setAttribute('onclick', 'return window.__codexFruitLoopOpenSettingsInline ? window.__codexFruitLoopOpenSettingsInline(event) : false;');
  };

  if(document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', bindSettingsButton, { once: true });
  } else {
    bindSettingsButton();
  }
  setInterval(bindSettingsButton, 700);
})();
</script>
<style id="codex-fruits-last-lock">
  #stage{
    --fl-wheel-real-size:min(74vw, 288px) !important;
    --fl-timer-size:94px !important;
  }

  #stage #wheelZone{
    width:var(--fl-wheel-real-size) !important;
    top:62px !important;
    height:calc(var(--fl-wheel-real-size) + 118px) !important;
  }

  #stage #wheelZone #wheelShell{
    width:100% !important;
    max-width:var(--fl-wheel-real-size) !important;
    min-width:var(--fl-wheel-real-size) !important;
    height:var(--fl-wheel-real-size) !important;
    max-height:var(--fl-wheel-real-size) !important;
    min-height:var(--fl-wheel-real-size) !important;
    margin:0 auto !important;
  }

  #stage #wheelZone #wheelShell::after{
    top:-7% !important;
    width:138% !important;
    height:80% !important;
    background-position:center top !important;
  }

  #stage #wheelZone #wheelWindow,
  #stage #wheelZone #wheelRotator,
  #stage #wheelZone #wheelFace{
    width:100% !important;
    height:100% !important;
  }

  #stage #timer{
    top:calc(62px + var(--fl-wheel-real-size) + 2px) !important;
    width:var(--fl-timer-size) !important;
    height:var(--fl-timer-size) !important;
  }

  #stage #statusBar{
    top:calc(62px + var(--fl-wheel-real-size) + 96px) !important;
  }

  #stage #winnerBanner{
    top:calc(62px + var(--fl-wheel-real-size) + 30px) !important;
  }

  #stage #board{
    bottom:78px !important;
    min-height:198px !important;
    margin-top:0 !important;
  }

  #appModal .modalCard,
  #appModal .modalCard[data-panel="players"],
  #appModal .modalCard[data-panel="settings"],
  #appModal .modalCard[data-panel="trend"]{
    overflow:hidden !important;
    overflow-x:hidden !important;
  }

  #appModal .modalBody,
  #appModal .modalTableWrap,
  #appModal .historyTableWrap{
    max-width:100% !important;
    overflow-x:hidden !important;
  }

  #appModal .modalCard *,
  #appModal .modalBody *,
  #appModal .panelCanvas *{
    min-width:0 !important;
    max-width:100% !important;
    box-sizing:border-box !important;
  }

  #appModal .modalTable,
  #appModal .historyTable{
    width:100% !important;
    min-width:0 !important;
    max-width:100% !important;
    table-layout:fixed !important;
  }

  #appModal .modalTable th,
  #appModal .modalTable td,
  #appModal .historyTable th,
  #appModal .historyTable td{
    white-space:normal !important;
    overflow-wrap:anywhere !important;
    word-break:break-word !important;
  }

  @media(max-width:390px){
    #stage{
      --fl-wheel-real-size:min(72vw, 272px) !important;
      --fl-timer-size:86px !important;
    }

    #stage #wheelZone{
      top:60px !important;
      height:calc(var(--fl-wheel-real-size) + 110px) !important;
    }

    #stage #timer{
      top:calc(60px + var(--fl-wheel-real-size) + 2px) !important;
    }

    #stage #statusBar{
      top:calc(60px + var(--fl-wheel-real-size) + 88px) !important;
    }

    #stage #winnerBanner{
      top:calc(60px + var(--fl-wheel-real-size) + 26px) !important;
    }

    #stage #board{
      bottom:74px !important;
      min-height:190px !important;
    }
  }
</style>
<style id="codex-fruits-top-display-fix">
  #stage .topRow{
    left:9px !important;
    right:9px !important;
    width:auto !important;
    max-width:calc(100% - 18px) !important;
    top:12px !important;
    height:46px !important;
    z-index:72 !important;
    display:flex !important;
    align-items:center !important;
    justify-content:space-between !important;
    gap:7px !important;
    padding:0 12px !important;
    overflow:hidden !important;
  }

  #stage .midTop{
    position:relative !important;
    left:auto !important;
    right:auto !important;
    top:auto !important;
    display:flex !important;
    flex-direction:row !important;
    align-items:center !important;
    gap:8px !important;
    z-index:73 !important;
    flex:1 1 auto !important;
    min-width:0 !important;
    overflow:hidden !important;
  }

  #stage .dockRight{
    position:relative !important;
    right:auto !important;
    top:auto !important;
    display:flex !important;
    align-items:center !important;
    justify-content:flex-end !important;
    gap:8px !important;
    grid-template-columns:none !important;
    padding:0 !important;
    border:0 !important;
    background:none !important;
    box-shadow:none !important;
    backdrop-filter:none !important;
    flex:0 0 auto !important;
    max-width:188px !important;
    overflow:visible !important;
  }

  #stage #historyBtn,
  #stage #winnersBtn,
  #stage #soundBtn{
    display:none !important;
  }

  #stage .latencyPill,
  #stage .roundPill{
    height:34px !important;
    width:auto !important;
    min-width:auto !important;
    padding:0 12px !important;
    gap:7px !important;
    border-radius:999px !important;
    display:flex !important;
    align-items:center !important;
    justify-content:center !important;
    white-space:nowrap !important;
    background:
      linear-gradient(180deg, rgba(255,255,255,.18), rgba(255,255,255,.05)),
      linear-gradient(180deg, rgba(69,38,122,.92), rgba(29,18,58,.96)) !important;
    border:1px solid rgba(255,225,145,.42) !important;
    box-shadow:
      inset 0 1px 0 rgba(255,255,255,.18),
      0 10px 22px rgba(0,0,0,.24) !important;
    color:#f8edc4 !important;
  }

  #stage .latencyPill{
    min-width:74px !important;
  }

  #stage .roundPill{
    min-width:78px !important;
    padding:0 10px !important;
    gap:6px !important;
  }

  #stage .latencyPill > span:not(.latencyDot),
  #stage .roundPill > span,
  #stage .roundPill > b{
    font-size:inherit !important;
  }

  #stage .roundPill::before,
  #stage #latencyText::after{
    content:none !important;
  }

  #stage .latencyPill > .pillLabel,
  #stage .roundPill > .pillLabel{
    font-size:9px !important;
    font-weight:900 !important;
    letter-spacing:.8px !important;
    text-transform:uppercase !important;
    color:rgba(255,241,203,.82) !important;
  }

  #stage .latencyPill > .pillValue,
  #stage .roundPill > .pillValue{
    font-size:16px !important;
    line-height:1 !important;
    font-weight:1000 !important;
    letter-spacing:.3px !important;
    font-variant-numeric:tabular-nums !important;
  }

  #stage .roundPill > .pillValue{
    font-size:14px !important;
    color:#ffd875 !important;
    text-shadow:0 1px 0 rgba(92,42,0,.78), 0 0 12px rgba(255,214,108,.18) !important;
    margin-left:1px !important;
  }

  #stage .roundPill > .pillLabel{
    font-size:8px !important;
    letter-spacing:.8px !important;
  }

  #stage .latencyPill > .pillValue{
    min-width:26px !important;
    text-align:right !important;
    color:#fff8dc !important;
    margin-right:1px !important;
  }

  #stage .latencyPill > .pillUnit{
    font-size:10px !important;
    font-weight:900 !important;
    letter-spacing:.6px !important;
    text-transform:lowercase !important;
    color:rgba(255,241,203,.78) !important;
  }

  #stage .latencyDot{
    width:10px !important;
    height:10px !important;
    flex:0 0 10px !important;
    box-shadow:0 0 12px currentColor !important;
  }

  #stage .menuBtn{
    position:relative !important;
    width:44px !important;
    min-width:44px !important;
    height:44px !important;
    border-radius:15px !important;
    display:grid !important;
    place-items:center !important;
    padding:0 !important;
    border:1px solid rgba(255,255,255,.10) !important;
    background:
      linear-gradient(180deg, rgba(255,255,255,.18), rgba(255,255,255,.04)),
      linear-gradient(180deg, rgba(53,39,92,.96), rgba(17,15,40,.98)) !important;
    box-shadow:
      inset 0 1px 0 rgba(255,255,255,.18),
      0 12px 22px rgba(0,0,0,.28),
      0 0 0 1px rgba(255,240,176,.08) !important;
    overflow:hidden !important;
    transition:transform .18s ease, box-shadow .18s ease, filter .18s ease !important;
  }

  #stage .menuBtn::before{
    content:"" !important;
    position:absolute !important;
    inset:1px !important;
    border-radius:14px !important;
    border:1px solid rgba(255,255,255,.08) !important;
    pointer-events:none !important;
  }

  #stage .menuBtn:hover,
  #stage .menuBtn:focus-visible{
    transform:translateY(-2px) scale(1.02) !important;
    box-shadow:
      inset 0 1px 0 rgba(255,255,255,.22),
      0 16px 28px rgba(0,0,0,.32),
      0 0 18px rgba(255,228,146,.16) !important;
    outline:none !important;
  }

  #stage .menuBtn .menuText{
    display:none !important;
  }

  #stage .menuBtn .menuIcon{
    position:relative !important;
    width:24px !important;
    height:24px !important;
    display:grid !important;
    place-items:center !important;
    z-index:1 !important;
  }

  #stage .menuBtn .menuSvg{
    width:22px !important;
    height:22px !important;
    display:block !important;
    filter:drop-shadow(0 4px 8px rgba(0,0,0,.22)) !important;
  }

  #stage #historyBtn{
    background:
      linear-gradient(180deg, rgba(255,255,255,.18), rgba(255,255,255,.04)),
      linear-gradient(180deg, rgba(36,76,130,.96), rgba(17,22,59,.98)) !important;
    border-color:rgba(102,226,255,.24) !important;
  }

  #stage #userBtn{
    background:
      linear-gradient(180deg, rgba(255,255,255,.18), rgba(255,255,255,.04)),
      linear-gradient(180deg, rgba(24,111,116,.96), rgba(18,34,64,.98)) !important;
    border-color:rgba(104,255,229,.24) !important;
  }

  #stage #infoBtn{
    background:
      linear-gradient(180deg, rgba(255,255,255,.18), rgba(255,255,255,.04)),
      linear-gradient(180deg, rgba(42,90,164,.96), rgba(19,26,68,.98)) !important;
    border-color:rgba(116,195,255,.24) !important;
  }

  #stage #settingsBtn{
    background:
      linear-gradient(180deg, rgba(255,255,255,.18), rgba(255,255,255,.04)),
      linear-gradient(180deg, rgba(136,56,84,.96), rgba(48,19,49,.98)) !important;
    border-color:rgba(255,176,120,.24) !important;
  }

  #stage .userMenuBtn .activeCount{
    right:-4px !important;
    top:-4px !important;
    min-width:18px !important;
    height:18px !important;
    padding:0 4px !important;
    border-radius:999px !important;
    display:grid !important;
    place-items:center !important;
    font-size:10px !important;
    font-weight:1000 !important;
    color:#2e1200 !important;
    background:linear-gradient(180deg, #fff7b8, #ffb443) !important;
    border:1px solid rgba(110,40,0,.55) !important;
    box-shadow:0 8px 16px rgba(0,0,0,.24) !important;
  }

  #stage #timer{
    z-index:42 !important;
    opacity:1 !important;
    visibility:visible !important;
    transition:opacity .18s ease !important;
    filter:drop-shadow(0 16px 28px rgba(0,0,0,.28)) !important;
  }

  #stage #timer.isHidden{
    opacity:0 !important;
    visibility:hidden !important;
    pointer-events:none !important;
  }

  #stage #countNum{
    top:52.5% !important;
    min-width:66px !important;
    height:66px !important;
    font-family:'Trebuchet MS', 'Arial Black', Arial, sans-serif !important;
    font-size:41px !important;
    font-weight:1000 !important;
    letter-spacing:.2px !important;
    color:#7d3308 !important;
    text-shadow:0 1px 0 rgba(255,255,255,.82), 0 3px 14px rgba(120,54,10,.22) !important;
    font-variant-numeric:tabular-nums !important;
    z-index:2 !important;
  }

  #stage #timer::before{
    content:"" !important;
    position:absolute !important;
    inset:17% 18% 19% 18% !important;
    border-radius:50% !important;
    background:radial-gradient(circle at 34% 28%, rgba(255,255,255,.88), rgba(255,241,194,.66) 38%, rgba(255,194,82,.14) 70%, rgba(255,172,50,0) 100%) !important;
    box-shadow:
      inset 0 0 0 2px rgba(163,82,18,.18),
      inset 0 9px 18px rgba(255,255,255,.20),
      0 0 0 1px rgba(255,246,210,.34) !important;
    pointer-events:none !important;
    z-index:0 !important;
  }

  #stage #timer::after{
    content:"" !important;
    position:absolute !important;
    left:50% !important;
    top:15% !important;
    width:10px !important;
    height:10px !important;
    border-radius:50% !important;
    transform:translateX(-50%) !important;
    background:radial-gradient(circle at 34% 28%, #fff9d8, #ffbe56 58%, #8f4303 100%) !important;
    box-shadow:0 2px 6px rgba(0,0,0,.22) !important;
    pointer-events:none !important;
    z-index:1 !important;
  }

  #stage #statusBar{
    opacity:0 !important;
    visibility:hidden !important;
    pointer-events:none !important;
  }

  #stage #statusBar.show{
    opacity:1 !important;
    visibility:visible !important;
  }

  #stage #statusBar[data-phase="betting"]{
    background:linear-gradient(180deg, rgba(198,255,158,.98), rgba(44,153,58,.98)) !important;
    border-color:rgba(20,88,31,.86) !important;
    color:#123d11 !important;
    text-shadow:0 1px 0 rgba(255,255,255,.48) !important;
    box-shadow:0 18px 28px rgba(0,0,0,.32), 0 0 22px rgba(112,255,134,.22), inset 0 2px 0 rgba(255,255,255,.58) !important;
  }

  #stage #statusBar[data-phase="betting"]::before,
  #stage #statusBar[data-phase="betting"]::after{
    background:linear-gradient(180deg, #efffd2, #4cad4f) !important;
    border-color:rgba(28,95,36,.84) !important;
  }

  #stage #statusBar[data-phase="locked"]{
    background:linear-gradient(180deg, rgba(255,223,142,.98), rgba(223,70,36,.98)) !important;
    border-color:rgba(125,33,0,.88) !important;
    color:#4a1200 !important;
    text-shadow:0 1px 0 rgba(255,255,255,.42) !important;
    box-shadow:0 18px 28px rgba(0,0,0,.34), 0 0 24px rgba(255,132,76,.24), inset 0 2px 0 rgba(255,255,255,.52) !important;
  }

  #stage #statusBar[data-phase="locked"]::before,
  #stage #statusBar[data-phase="locked"]::after{
    background:linear-gradient(180deg, #fff1ba, #d45a22) !important;
    border-color:rgba(124,37,5,.82) !important;
  }

  #stage #statusBar[data-phase="revealed"]{
    background:linear-gradient(180deg, rgba(127,83,235,.98), rgba(43,24,104,.98)) !important;
    border-color:rgba(255,232,154,.58) !important;
    color:#fff2cc !important;
    text-shadow:0 2px 10px rgba(0,0,0,.26) !important;
    box-shadow:0 18px 32px rgba(0,0,0,.42), 0 0 24px rgba(161,122,255,.24), inset 0 2px 0 rgba(255,255,255,.14) !important;
  }

  #stage #statusBar[data-phase="revealed"]::before,
  #stage #statusBar[data-phase="revealed"]::after{
    background:linear-gradient(180deg, #eadcff, #6e47d7) !important;
    border-color:rgba(255,226,148,.50) !important;
  }

  #stage #statusBar[data-phase="settled"]{
    background:linear-gradient(180deg, rgba(135,228,255,.98), rgba(24,109,212,.98)) !important;
    border-color:rgba(7,58,132,.88) !important;
    color:#052555 !important;
    text-shadow:0 1px 0 rgba(255,255,255,.42) !important;
    box-shadow:0 18px 28px rgba(0,0,0,.34), 0 0 24px rgba(104,188,255,.24), inset 0 2px 0 rgba(255,255,255,.46) !important;
  }

  #stage #statusBar[data-phase="settled"]::before,
  #stage #statusBar[data-phase="settled"]::after{
    background:linear-gradient(180deg, #d8f5ff, #3188e0) !important;
    border-color:rgba(8,58,131,.82) !important;
  }

  #stage #toast{
    bottom:calc(max(env(safe-area-inset-bottom),9px) + 70px) !important;
    z-index:64 !important;
  }

  @media(max-width:640px){
    #stage .midTop{
      gap:6px !important;
    }

    #stage .latencyPill,
    #stage .roundPill{
      height:30px !important;
      padding:0 10px !important;
      gap:6px !important;
    }

    #stage .latencyPill{
      min-width:68px !important;
    }

    #stage .roundPill{
      min-width:70px !important;
    }

    #stage .latencyPill > .pillLabel,
    #stage .roundPill > .pillLabel,
    #stage .latencyPill > .pillUnit{
      font-size:9px !important;
    }

    #stage .latencyPill > .pillValue,
    #stage .roundPill > .pillValue{
      font-size:13px !important;
    }

    #stage .roundPill > .pillValue{
      font-size:12px !important;
    }

    #stage .dockRight{
      gap:5px !important;
      max-width:178px !important;
    }

    #stage .menuBtn{
      width:40px !important;
      min-width:40px !important;
      height:40px !important;
    }

    #stage #countNum{
      min-width:60px !important;
      height:60px !important;
      font-size:36px !important;
    }
  }
  #chipDock .chipBtn,
  #stage .payoutChipGhost,
  #stage .boxChip,
  #stage .flyingChip{
    filter: {{ $chipFilterCss }} !important;
  }

  .winnerDot.cherry{background-color:rgba(255,90,112,.68)}
  .winnerDot.pineapple{background-color:rgba(255,204,86,.72)}
</style>
@if($currentGameCode !== 'fruits_loop')
<style id="codex-fruits-variant-bottom-layout-fix">
  #stage #bottomBar{
    grid-template-columns:88px minmax(0, 1fr) !important;
    gap:8px !important;
    align-items:end !important;
  }

  #stage #chipDock{
    display:grid !important;
    grid-template-columns:repeat(5, minmax(0, 1fr)) !important;
    grid-template-rows:auto auto !important;
    align-items:center !important;
    justify-items:center !important;
    row-gap:5px !important;
    column-gap:4px !important;
    height:auto !important;
    min-height:74px !important;
    padding:6px 8px !important;
  }

  #stage #chipDock .chipBtn{
    width:38px !important;
    height:38px !important;
    min-width:38px !important;
    flex-basis:38px !important;
  }

  #stage #trendBtn{
    display:none !important;
  }

  #stage #winnerHistory{
    grid-column:1 / -1 !important;
    grid-row:1 !important;
    width:100% !important;
    max-width:none !important;
    min-width:0 !important;
    margin:0 !important;
    padding:4px 5px !important;
    gap:4px !important;
    display:flex !important;
    align-items:center !important;
    justify-content:flex-start !important;
  }

  #stage #winnerHistory .historyTitle{
    display:none !important;
  }

  #stage #winnerHistoryList{
    width:100% !important;
    display:grid !important;
    grid-template-columns:repeat(15, minmax(0, 1fr)) !important;
    gap:2px !important;
    align-items:center !important;
  }

  #stage #winnerHistory .winnerDot{
    width:14px !important;
    height:14px !important;
    min-width:14px !important;
    flex-basis:14px !important;
    font-size:9px !important;
  }

  #stage #winnerHistory .winnerDot.empty{
    font-size:10px !important;
    line-height:1 !important;
  }

  @media(max-width:390px){
    #stage #chipDock .chipBtn{
      width:36px !important;
      height:36px !important;
      min-width:36px !important;
      flex-basis:36px !important;
    }

    #stage #winnerHistory .winnerDot{
      width:13px !important;
      height:13px !important;
      min-width:13px !important;
      flex-basis:13px !important;
      font-size:8px !important;
    }
  }
</style>
@endif

@if($currentGameCode === 'fruits_loop')
<style id="codex-fruits-base-layout-fix">
  #stage .topRow{
    left:9px !important;
    right:9px !important;
    top:10px !important;
    height:42px !important;
    display:grid !important;
    grid-template-columns:auto minmax(0, 1fr) !important;
    align-items:center !important;
    gap:6px !important;
    padding:0 !important;
    z-index:40 !important;
  }

  #stage .dockRight{
    position:relative !important;
    inset:auto !important;
    left:0 !important;
    top:0 !important;
    right:auto !important;
    margin:0 !important;
    order:1 !important;
    flex:0 0 auto !important;
    display:grid !important;
    grid-template-columns:repeat(3, minmax(0, 1fr)) !important;
    gap:5px !important;
    width:auto !important;
    max-width:146px !important;
    padding:4px !important;
    border-radius:16px !important;
    justify-self:start !important;
    align-self:center !important;
    background:linear-gradient(180deg,rgba(255,255,255,.22),rgba(255,255,255,.07)),rgba(8,12,32,.50) !important;
    border:1px solid rgba(255,232,156,.34) !important;
    box-shadow:0 15px 30px rgba(0,0,0,.30),inset 0 1px 0 rgba(255,255,255,.24) !important;
    backdrop-filter:blur(14px) saturate(138%) !important;
  }

  #stage #winnersBtn,
  #stage #soundBtn,
  #stage #trendBtn{
    display:none !important;
  }

  #stage .dockRight .menuBtn{
    min-width:0 !important;
    width:42px !important;
    height:34px !important;
    padding:0 !important;
    border-radius:11px !important;
    display:flex !important;
    align-items:center !important;
    justify-content:center !important;
    gap:0 !important;
  }

  #stage .dockRight .menuIcon{
    font-size:15px !important;
    line-height:1 !important;
    margin:0 !important;
  }

  #stage .dockRight .menuText{
    display:none !important;
  }

  #stage .dockRight .activeCount{
    top:2px !important;
    right:2px !important;
    min-width:14px !important;
    height:14px !important;
    padding:0 3px !important;
    font-size:8px !important;
    line-height:14px !important;
  }

  #stage .midTop{
    position:relative !important;
    inset:auto !important;
    left:auto !important;
    top:0 !important;
    right:0 !important;
    margin:0 !important;
    order:2 !important;
    flex:1 1 auto !important;
    justify-self:end !important;
    align-self:center !important;
    width:auto !important;
    min-width:0 !important;
    display:flex !important;
    align-items:center !important;
    justify-content:flex-end !important;
    gap:5px !important;
    z-index:2 !important;
  }

  #stage .midTop .latencyPill,
  #stage .midTop .roundPill{
    height:28px !important;
    padding:0 9px !important;
    font-size:10px !important;
    border-radius:999px !important;
  }

  #stage #trendBtn{
    display:flex !important;
    align-items:center !important;
    justify-content:center !important;
    width:34px !important;
    height:34px !important;
    flex:0 0 34px !important;
  }

  #stage #bottomBar{
    bottom:10px !important;
    align-items:end !important;
    column-gap:10px !important;
  }

  #stage #balancePill{
    bottom:10px !important;
    height:44px !important;
    border-radius:15px !important;
    padding:0 12px !important;
    gap:8px !important;
  }

  #stage #balanceIcon{
    font-size:22px !important;
  }

  #stage #balanceValue{
    font-size:15px !important;
  }

  #stage #chipDock{
    height:58px !important;
    min-height:58px !important;
    align-items:center !important;
    gap:6px !important;
    padding:5px 8px 4px !important;
    border-radius:18px !important;
    overflow-x:auto !important;
    scrollbar-width:none !important;
  }

  #stage #chipDock .chipBtn{
    width:36px !important;
    height:36px !important;
    flex:0 0 36px !important;
  }

  #stage #chipDock .chipBtn.active{
    transform:translateY(-3px) scale(1.04) !important;
  }

  #stage #chipDock::-webkit-scrollbar{
    display:none !important;
  }

  #stage #winnerHistory{
    display:none !important;
  }

  @media(max-width:390px){
    #stage .topRow{
      gap:5px !important;
    }

    #stage .dockRight{
      gap:4px !important;
      padding:3px !important;
      max-width:150px !important;
    }

    #stage .dockRight .menuBtn{
      width:40px !important;
      height:32px !important;
      border-radius:10px !important;
    }

    #stage .dockRight .menuIcon{
      font-size:14px !important;
    }

    #stage .midTop{
      gap:4px !important;
    }

    #stage .midTop .latencyPill,
    #stage .midTop .roundPill{
      height:26px !important;
      padding:0 8px !important;
      font-size:9px !important;
    }

    #stage #trendBtn{
      width:32px !important;
      height:32px !important;
      flex-basis:32px !important;
    }

    #stage #balancePill{
      height:40px !important;
      padding:0 10px !important;
    }

    #stage #balanceValue{
      font-size:13px !important;
    }

    #stage #chipDock{
      height:52px !important;
      min-height:52px !important;
      padding:4px 7px 3px !important;
      gap:5px !important;
    }

    #stage #chipDock .chipBtn{
      width:32px !important;
      height:32px !important;
      flex-basis:32px !important;
    }
  }
</style>
@endif

@if($currentGameCode !== 'fruits_loop')
<style id="codex-fruits-variant-match-base-style">
  #stage .topRow{
    left:9px !important;
    right:9px !important;
    top:10px !important;
    height:42px !important;
    display:grid !important;
    grid-template-columns:auto minmax(0, 1fr) !important;
    align-items:center !important;
    gap:6px !important;
    padding:0 !important;
    z-index:40 !important;
  }

  #stage .dockRight{
    position:relative !important;
    inset:auto !important;
    left:0 !important;
    top:0 !important;
    right:auto !important;
    margin:0 !important;
    order:1 !important;
    flex:0 0 auto !important;
    display:grid !important;
    grid-template-columns:repeat(3, minmax(0, 1fr)) !important;
    gap:5px !important;
    width:auto !important;
    max-width:146px !important;
    padding:4px !important;
    border-radius:16px !important;
    justify-self:start !important;
    align-self:center !important;
    background:linear-gradient(180deg,rgba(255,255,255,.22),rgba(255,255,255,.07)),rgba(8,12,32,.50) !important;
    border:1px solid rgba(255,232,156,.34) !important;
    box-shadow:0 15px 30px rgba(0,0,0,.30),inset 0 1px 0 rgba(255,255,255,.24) !important;
    backdrop-filter:blur(14px) saturate(138%) !important;
  }

  #stage #historyBtn,
  #stage #winnersBtn,
  #stage #soundBtn{
    display:none !important;
  }

  #stage .dockRight .menuBtn{
    min-width:0 !important;
    width:42px !important;
    height:34px !important;
    padding:0 !important;
    border-radius:11px !important;
    display:flex !important;
    align-items:center !important;
    justify-content:center !important;
    gap:0 !important;
  }

  #stage .dockRight .menuIcon{
    font-size:15px !important;
    line-height:1 !important;
    margin:0 !important;
  }

  #stage .dockRight .menuText{
    display:none !important;
  }

  #stage .dockRight .activeCount{
    top:2px !important;
    right:2px !important;
    min-width:14px !important;
    height:14px !important;
    padding:0 3px !important;
    font-size:8px !important;
    line-height:14px !important;
  }

  #stage .midTop{
    position:relative !important;
    inset:auto !important;
    left:auto !important;
    top:0 !important;
    right:0 !important;
    margin:0 !important;
    order:2 !important;
    flex:1 1 auto !important;
    justify-self:end !important;
    align-self:center !important;
    width:auto !important;
    min-width:0 !important;
    display:flex !important;
    align-items:center !important;
    justify-content:flex-end !important;
    gap:5px !important;
    z-index:2 !important;
  }

  #stage .midTop .latencyPill,
  #stage .midTop .roundPill{
    height:28px !important;
    padding:0 9px !important;
    font-size:10px !important;
    border-radius:999px !important;
  }

  #stage #winnerHistory{
    display:none !important;
  }

  #stage #trendBtn{
    display:flex !important;
    align-items:center !important;
    justify-content:center !important;
    width:34px !important;
    height:34px !important;
    flex:0 0 34px !important;
  }

  #stage #bottomBar{
    bottom:10px !important;
    align-items:end !important;
    column-gap:10px !important;
  }

  #stage #balancePill{
    bottom:10px !important;
    height:44px !important;
    border-radius:15px !important;
    padding:0 12px !important;
    gap:8px !important;
  }

  #stage #balanceIcon{
    font-size:22px !important;
  }

  #stage #balanceValue{
    font-size:15px !important;
  }

  #stage #chipDock{
    height:58px !important;
    min-height:58px !important;
    align-items:center !important;
    gap:6px !important;
    padding:5px 8px 4px !important;
    border-radius:18px !important;
    overflow-x:auto !important;
    scrollbar-width:none !important;
  }

  #stage #chipDock .chipBtn{
    width:36px !important;
    height:36px !important;
    flex:0 0 36px !important;
  }

  #stage #chipDock .chipBtn.active{
    transform:translateY(-3px) scale(1.04) !important;
  }

  #stage #chipDock::-webkit-scrollbar{
    display:none !important;
  }

  @media(max-width:390px){
    #stage .dockRight{
      gap:4px !important;
      padding:3px !important;
      max-width:138px !important;
    }

    #stage .dockRight .menuBtn{
      width:40px !important;
      height:32px !important;
      border-radius:10px !important;
    }

    #stage .dockRight .menuIcon{
      font-size:14px !important;
    }

    #stage .midTop{
      gap:4px !important;
    }

    #stage .midTop .latencyPill,
    #stage .midTop .roundPill{
      height:26px !important;
      padding:0 8px !important;
      font-size:9px !important;
    }

    #stage #trendBtn{
      width:32px !important;
      height:32px !important;
      flex-basis:32px !important;
    }

    #stage #balancePill{
      height:40px !important;
      padding:0 10px !important;
    }

    #stage #balanceValue{
      font-size:13px !important;
    }

    #stage #chipDock{
      height:52px !important;
      min-height:52px !important;
      padding:4px 7px 3px !important;
      gap:5px !important;
    }

    #stage #chipDock .chipBtn{
      width:32px !important;
      height:32px !important;
      flex-basis:32px !important;
    }
  }
</style>
@endif
<style id="codex-fruits-icon-clock-final">
  #stage{
    --fl-timer-size:94px !important;
  }

  #stage .dockRight{
    gap:7px !important;
    max-width:188px !important;
    overflow:visible !important;
  }

  #stage #winnersBtn,
  #stage #soundBtn,
  #stage #trendBtn{
    display:none !important;
  }

  #stage #historyBtn,
  #stage #userBtn,
  #stage #infoBtn,
  #stage #settingsBtn{
    display:grid !important;
  }

  #stage .dockRight .menuBtn{
    position:relative !important;
    width:44px !important;
    min-width:44px !important;
    height:44px !important;
    padding:0 !important;
    border-radius:15px !important;
    place-items:center !important;
    border:1px solid rgba(255,255,255,.10) !important;
    background:
      linear-gradient(180deg, rgba(255,255,255,.18), rgba(255,255,255,.04)),
      linear-gradient(180deg, rgba(53,39,92,.96), rgba(17,15,40,.98)) !important;
    box-shadow:
      inset 0 1px 0 rgba(255,255,255,.18),
      0 12px 22px rgba(0,0,0,.28),
      0 0 0 1px rgba(255,240,176,.08) !important;
    overflow:hidden !important;
    transition:transform .18s ease, box-shadow .18s ease, filter .18s ease !important;
  }

  #stage .dockRight .menuBtn::before{
    content:"" !important;
    position:absolute !important;
    inset:1px !important;
    border-radius:14px !important;
    border:1px solid rgba(255,255,255,.08) !important;
    pointer-events:none !important;
  }

  #stage .dockRight .menuBtn:hover,
  #stage .dockRight .menuBtn:focus-visible{
    transform:translateY(-2px) scale(1.02) !important;
    box-shadow:
      inset 0 1px 0 rgba(255,255,255,.22),
      0 16px 28px rgba(0,0,0,.32),
      0 0 18px rgba(255,228,146,.16) !important;
    outline:none !important;
  }

  #stage .dockRight .menuText{
    display:none !important;
  }

  #stage .dockRight .menuIcon{
    position:relative !important;
    width:24px !important;
    height:24px !important;
    display:grid !important;
    place-items:center !important;
    z-index:1 !important;
  }

  #stage .dockRight .menuSvg{
    width:22px !important;
    height:22px !important;
    display:block !important;
    filter:drop-shadow(0 4px 8px rgba(0,0,0,.22)) !important;
  }

  #stage #historyBtn{
    background:
      linear-gradient(180deg, rgba(255,255,255,.18), rgba(255,255,255,.04)),
      linear-gradient(180deg, rgba(36,76,130,.96), rgba(17,22,59,.98)) !important;
    border-color:rgba(102,226,255,.24) !important;
  }

  #stage #userBtn{
    background:
      linear-gradient(180deg, rgba(255,255,255,.18), rgba(255,255,255,.04)),
      linear-gradient(180deg, rgba(24,111,116,.96), rgba(18,34,64,.98)) !important;
    border-color:rgba(104,255,229,.24) !important;
  }

  #stage #infoBtn{
    background:
      linear-gradient(180deg, rgba(255,255,255,.18), rgba(255,255,255,.04)),
      linear-gradient(180deg, rgba(42,90,164,.96), rgba(19,26,68,.98)) !important;
    border-color:rgba(116,195,255,.24) !important;
  }

  #stage #settingsBtn{
    background:
      linear-gradient(180deg, rgba(255,255,255,.18), rgba(255,255,255,.04)),
      linear-gradient(180deg, rgba(136,56,84,.96), rgba(48,19,49,.98)) !important;
    border-color:rgba(255,176,120,.24) !important;
  }

  #stage .userMenuBtn .activeCount{
    right:-4px !important;
    top:-4px !important;
    min-width:18px !important;
    height:18px !important;
    padding:0 4px !important;
    border-radius:999px !important;
    display:grid !important;
    place-items:center !important;
    font-size:10px !important;
    font-weight:1000 !important;
    color:#2e1200 !important;
    background:linear-gradient(180deg, #fff7b8, #ffb443) !important;
    border:1px solid rgba(110,40,0,.55) !important;
    box-shadow:0 8px 16px rgba(0,0,0,.24) !important;
  }

  #stage #timer{
    top:calc(62px + var(--fl-wheel-real-size) + 2px) !important;
    width:var(--fl-timer-size) !important;
    height:var(--fl-timer-size) !important;
    filter:drop-shadow(0 16px 28px rgba(0,0,0,.28)) !important;
    isolation:isolate !important;
  }

  #stage #statusBar{
    top:calc(62px + var(--fl-wheel-real-size) + 96px) !important;
  }

  #stage #winnerBanner{
    top:calc(62px + var(--fl-wheel-real-size) + 30px) !important;
  }

  #stage #countNum{
    top:52.5% !important;
    min-width:66px !important;
    height:66px !important;
    font-size:41px !important;
    letter-spacing:.2px !important;
    text-shadow:0 1px 0 rgba(255,255,255,.82), 0 3px 14px rgba(120,54,10,.22) !important;
    font-variant-numeric:tabular-nums !important;
    z-index:2 !important;
  }

  #stage #timer::before{
    content:"" !important;
    position:absolute !important;
    inset:17% 18% 19% 18% !important;
    border-radius:50% !important;
    background:radial-gradient(circle at 34% 28%, rgba(255,255,255,.88), rgba(255,241,194,.66) 38%, rgba(255,194,82,.14) 70%, rgba(255,172,50,0) 100%) !important;
    box-shadow:
      inset 0 0 0 2px rgba(163,82,18,.18),
      inset 0 9px 18px rgba(255,255,255,.20),
      0 0 0 1px rgba(255,246,210,.34) !important;
    pointer-events:none !important;
    z-index:0 !important;
  }

  #stage #timer::after{
    content:"" !important;
    position:absolute !important;
    left:50% !important;
    top:15% !important;
    width:10px !important;
    height:10px !important;
    border-radius:50% !important;
    transform:translateX(-50%) !important;
    background:radial-gradient(circle at 34% 28%, #fff9d8, #ffbe56 58%, #8f4303 100%) !important;
    box-shadow:0 2px 6px rgba(0,0,0,.22) !important;
    pointer-events:none !important;
    z-index:1 !important;
  }

  @media(max-width:640px){
    #stage{
      --fl-timer-size:86px !important;
    }

    #stage .dockRight{
      gap:5px !important;
      max-width:178px !important;
    }

    #stage .dockRight .menuBtn{
      width:40px !important;
      min-width:40px !important;
      height:40px !important;
    }

    #stage #statusBar{
      top:calc(62px + var(--fl-wheel-real-size) + 88px) !important;
    }

    #stage #countNum{
      min-width:60px !important;
      height:60px !important;
      font-size:36px !important;
    }
  }
</style>
<style id="codex-fruits-publish-450-postfix">
  @media (max-height:450px){
    #stage{
      --fl-wheel-real-size:min(52vw, 188px) !important;
      --fl-timer-size:56px !important;
    }

    #stage #wheelZone{
      top:48px !important;
      width:var(--fl-wheel-real-size) !important;
      height:calc(var(--fl-wheel-real-size) + 48px) !important;
    }

    #stage #wheelZone #wheelShell{
      width:var(--fl-wheel-real-size) !important;
      min-width:var(--fl-wheel-real-size) !important;
      max-width:var(--fl-wheel-real-size) !important;
      height:var(--fl-wheel-real-size) !important;
      min-height:var(--fl-wheel-real-size) !important;
      max-height:var(--fl-wheel-real-size) !important;
    }

    #stage #wheelZone #wheelWindow,
    #stage #wheelZone #wheelRotator,
    #stage #wheelZone #wheelFace{
      width:100% !important;
      height:100% !important;
    }

    #stage #timer{
      top:calc(48px + var(--fl-wheel-real-size) - 62px) !important;
      width:var(--fl-timer-size) !important;
      height:var(--fl-timer-size) !important;
    }

    #stage #countNum{
      min-width:40px !important;
      height:40px !important;
      font-size:24px !important;
    }

    #stage #statusBar{
      top:calc(48px + var(--fl-wheel-real-size) + 8px) !important;
    }

    #stage #winnerBanner{
      top:calc(48px + var(--fl-wheel-real-size) - 20px) !important;
    }

    #stage #board{
      bottom:72px !important;
      min-height:142px !important;
      padding:7px 7px 9px !important;
      column-gap:5px !important;
      row-gap:5px !important;
    }

    #stage #board .betBox{
      height:102px !important;
    }

    #stage #board .combo{
      top:20px !important;
    }

    #stage #board .fruitBadge{
      width:34px !important;
      height:34px !important;
      font-size:20px !important;
    }

    #stage #board .visualPotName{
      font-size:8px !important;
    }

    #stage #board .multText,
    #stage #board .youText{
      font-size:12px !important;
    }

    #stage #bottomBar{
      left:8px !important;
      right:8px !important;
      width:auto !important;
      bottom:8px !important;
      grid-template-columns:80px minmax(0, 1fr) !important;
      column-gap:6px !important;
      padding:6px !important;
    }

    #stage #balancePill{
      bottom:0 !important;
      width:80px !important;
      height:40px !important;
      padding:0 8px !important;
      gap:6px !important;
    }

    #stage #balanceIcon{
      font-size:20px !important;
    }

    #stage #balanceValue{
      font-size:12px !important;
    }

    #stage #chipDock{
      height:44px !important;
      min-height:44px !important;
      padding:4px 6px 3px !important;
      gap:4px !important;
      overflow:hidden !important;
      justify-content:center !important;
    }

    #stage #chipDock .chipBtn{
      width:28px !important;
      height:28px !important;
      flex:0 0 28px !important;
    }

    #stage #chipDock .chipBtn.active{
      transform:translateY(-2px) scale(1.03) !important;
    }

    #stage #trendBtn{
      display:grid !important;
      width:28px !important;
      min-width:28px !important;
      height:28px !important;
      flex:0 0 28px !important;
      border-radius:10px !important;
      place-items:center !important;
    }

    #stage #trendBtn .trendBars{
      height:16px !important;
      gap:2px !important;
    }

    #stage #trendBtn .trendBars i{
      width:4px !important;
    }

    #stage #trendBtn .trendBars i:nth-child(1){
      height:7px !important;
    }

    #stage #trendBtn .trendBars i:nth-child(2){
      height:11px !important;
    }

    #stage #trendBtn .trendBars i:nth-child(3){
      height:16px !important;
    }
  }
</style>
<style id="codex-fruits-timer-corner-position">
  @media (max-height:450px){
    #stage #timer{
      left:calc(50% + (var(--fl-wheel-real-size) * .5) - (var(--fl-timer-size) * .80)) !important;
      top:calc(48px + (var(--fl-wheel-real-size) * .65)) !important;
      transform:none !important;
      z-index:45 !important;
    }

    #stage #countNum{
      left:50% !important;
      top:52.5% !important;
      transform:translate(-50%, -50%) !important;
    }
  }
</style>
<style id="codex-fruits-top-menu-lite">
  @media (max-height:450px){
    #stage .topRow{
      height:34px !important;
    }

    #stage .dockRight{
      width:auto !important;
      max-width:none !important;
      height:34px !important;
      min-height:34px !important;
      grid-template-columns:repeat(3, 28px) !important;
      grid-auto-rows:28px !important;
      align-items:center !important;
      justify-items:center !important;
      gap:5px !important;
      padding:3px 2px !important;
      background:none !important;
      border:0 !important;
      box-shadow:none !important;
      backdrop-filter:none !important;
      overflow:visible !important;
    }

    #stage #settingsBtn{
      display:none !important;
    }

    #stage #historyBtn,
    #stage #userBtn,
    #stage #infoBtn{
      width:28px !important;
      min-width:28px !important;
      height:28px !important;
      border:1px solid rgba(255,244,190,.86) !important;
      border-radius:10px !important;
      background:none !important;
      box-shadow:
        inset 0 0 0 1px rgba(255,255,255,.18),
        0 5px 10px rgba(0,0,0,.24) !important;
      backdrop-filter:none !important;
      overflow:visible !important;
      isolation:isolate !important;
    }

    #stage #historyBtn::before,
    #stage #userBtn::before,
    #stage #infoBtn::before{
      content:none !important;
      display:none !important;
    }

    #stage #historyBtn::after,
    #stage #userBtn::after,
    #stage #infoBtn::after{
      content:"" !important;
      position:absolute !important;
      inset:0 !important;
      border:1px solid rgba(255,244,190,.96) !important;
      border-radius:10px !important;
      box-shadow:inset 0 0 0 1px rgba(69,25,0,.20) !important;
      pointer-events:none !important;
      z-index:4 !important;
    }

    #stage #historyBtn .menuIcon,
    #stage #userBtn .menuIcon,
    #stage #infoBtn .menuIcon{
      width:22px !important;
      height:22px !important;
      filter:drop-shadow(0 1px 0 rgba(0,0,0,.40)) drop-shadow(0 0 5px rgba(255,241,177,.18)) !important;
      z-index:3 !important;
    }

    #stage #historyBtn .menuSvg,
    #stage #userBtn .menuSvg,
    #stage #infoBtn .menuSvg{
      width:22px !important;
      height:22px !important;
      filter:brightness(1.2) saturate(1.25) contrast(1.12) !important;
    }

    #stage #historyBtn .menuSvg path,
    #stage #historyBtn .menuSvg circle,
    #stage #userBtn .menuSvg path,
    #stage #userBtn .menuSvg circle,
    #stage #infoBtn .menuSvg path,
    #stage #infoBtn .menuSvg circle{
      vector-effect:non-scaling-stroke !important;
    }

    #stage .userMenuBtn .activeCount{
      right:-4px !important;
      top:-4px !important;
      min-width:14px !important;
      height:14px !important;
      padding:0 3px !important;
      font-size:8px !important;
    }
  }
</style>
<style id="codex-fruits-trend-beside-chips">
  #stage #historyBtn{
    display:none !important;
  }

  #stage #userBtn,
  #stage #infoBtn,
  #stage #settingsBtn{
    display:grid !important;
  }

  #stage .dockRight{
    grid-template-columns:repeat(3, minmax(0, 1fr)) !important;
    justify-content:end !important;
  }

  #stage #chipDock{
    display:flex !important;
    align-items:center !important;
    justify-content:center !important;
    overflow:visible !important;
  }

  #stage #trendBtn{
    display:grid !important;
    place-items:center !important;
    color:#fff7c7 !important;
    background:
      linear-gradient(180deg,rgba(255,255,255,.22),rgba(255,255,255,.05)),
      linear-gradient(180deg,rgba(50,196,164,.95),rgba(48,31,104,.98)) !important;
    border:1px solid rgba(255,231,154,.72) !important;
    box-shadow:
      inset 0 1px 0 rgba(255,255,255,.24),
      0 10px 18px rgba(0,0,0,.28),
      0 0 14px rgba(72,236,190,.18) !important;
  }

  @media (max-height:450px){
    #stage .dockRight{
      grid-template-columns:repeat(3, 28px) !important;
    }

    #stage #userBtn,
    #stage #infoBtn,
    #stage #settingsBtn{
      width:28px !important;
      min-width:28px !important;
      height:28px !important;
      border:1px solid rgba(255,244,190,.86) !important;
      border-radius:10px !important;
      background:none !important;
      box-shadow:
        inset 0 0 0 1px rgba(255,255,255,.18),
        0 5px 10px rgba(0,0,0,.24) !important;
      overflow:visible !important;
    }

    #stage #chipDock{
      gap:4px !important;
      padding:4px 6px 3px !important;
    }

    #stage #trendBtn{
      width:30px !important;
      min-width:30px !important;
      height:30px !important;
      flex:0 0 30px !important;
      border-radius:11px !important;
    }

    #stage #trendBtn .trendBars{
      height:17px !important;
      gap:2px !important;
    }

    #stage #trendBtn .trendBars i{
      width:4px !important;
    }
  }
</style>
<style id="codex-fruits-full-display-menu-fix">
  @media (min-height:451px){
    #stage .topRow{
      left:10px !important;
      right:10px !important;
      top:10px !important;
      width:auto !important;
      max-width:none !important;
      height:54px !important;
      display:flex !important;
      align-items:flex-start !important;
      justify-content:space-between !important;
      gap:10px !important;
      padding:0 !important;
      overflow:visible !important;
      z-index:76 !important;
    }

    #stage .midTop{
      position:relative !important;
      inset:auto !important;
      flex:1 1 auto !important;
      min-width:0 !important;
      display:flex !important;
      align-items:center !important;
      justify-content:flex-start !important;
      gap:8px !important;
      order:1 !important;
    }

    #stage .dockRight{
      position:relative !important;
      inset:auto !important;
      width:auto !important;
      max-width:none !important;
      height:50px !important;
      min-height:50px !important;
      margin-left:auto !important;
      display:flex !important;
      align-items:center !important;
      justify-content:flex-end !important;
      gap:8px !important;
      padding:0 !important;
      grid-template-columns:none !important;
      order:2 !important;
      background:none !important;
      border:0 !important;
      box-shadow:none !important;
      backdrop-filter:none !important;
      overflow:visible !important;
    }

    #stage #historyBtn,
    #stage #winnersBtn,
    #stage #soundBtn{
      display:none !important;
    }

    #stage #userBtn,
    #stage #infoBtn,
    #stage #settingsBtn{
      display:grid !important;
      width:48px !important;
      min-width:48px !important;
      height:48px !important;
      border-radius:15px !important;
      place-items:center !important;
    }

    #stage #chipDock{
      height:66px !important;
      min-height:66px !important;
      gap:7px !important;
      padding:6px 10px 5px !important;
      overflow:visible !important;
    }

    #stage #chipDock .chipBtn{
      width:44px !important;
      height:44px !important;
      flex:0 0 44px !important;
    }

    #stage #trendBtn{
      display:grid !important;
      place-items:center !important;
      width:46px !important;
      min-width:46px !important;
      height:46px !important;
      flex:0 0 46px !important;
      border-radius:16px !important;
      margin-left:2px !important;
    }

    #stage #trendBtn .trendBars{
      height:25px !important;
      gap:3px !important;
    }

    #stage #trendBtn .trendBars i{
      width:6px !important;
    }

    #stage #trendBtn .trendBars i:nth-child(1){height:11px !important}
    #stage #trendBtn .trendBars i:nth-child(2){height:17px !important}
    #stage #trendBtn .trendBars i:nth-child(3){height:25px !important}
  }
</style>
<style id="codex-fruits-trend-glass-3d">
  #appModal .modalCard[data-panel="trend"]{
    background:
      linear-gradient(145deg,rgba(255,255,255,.22),rgba(255,255,255,.055) 38%,rgba(37,255,205,.055) 70%,rgba(255,214,93,.12)),
      linear-gradient(180deg,rgba(14,22,48,.84),rgba(8,9,28,.92)) !important;
    border:1px solid rgba(210,255,238,.34) !important;
    box-shadow:
      0 28px 70px rgba(0,0,0,.58),
      0 0 0 1px rgba(255,255,255,.08),
      0 0 36px rgba(70,242,198,.16),
      inset 0 1px 0 rgba(255,255,255,.28),
      inset 0 -18px 42px rgba(18,7,47,.28) !important;
    backdrop-filter:blur(18px) saturate(145%) !important;
    -webkit-backdrop-filter:blur(18px) saturate(145%) !important;
    perspective:720px !important;
    padding-bottom:0 !important;
    height:min(390px, calc(100dvh - 24px)) !important;
    max-height:calc(100dvh - 24px) !important;
    display:flex !important;
    flex-direction:column !important;
    overflow:hidden !important;
  }

  #appModal .modalCard[data-panel="trend"] .modalHead{
    background:linear-gradient(180deg,rgba(255,255,255,.12),rgba(255,255,255,.035)) !important;
    border-bottom:1px solid rgba(198,255,233,.18) !important;
  }

  #appModal .modalCard[data-panel="trend"] #modalTitle{
    color:#eaffd9 !important;
    text-shadow:0 0 14px rgba(64,238,188,.38),0 2px 0 rgba(0,0,0,.36) !important;
  }

  #appModal .modalCard[data-panel="trend"] .modalBody{
    flex:1 1 auto !important;
    min-height:0 !important;
    display:flex !important;
    padding:10px 14px !important;
    overflow:hidden !important;
  }

  #appModal .modalCard[data-panel="trend"] .modalFooter{
    flex:0 0 auto !important;
    padding:0 16px 8px !important;
  }

  #appModal .modalCard[data-panel="trend"] .panelCanvas{
    flex:1 1 auto !important;
    min-height:0 !important;
    height:100% !important;
    display:flex !important;
    padding:13px !important;
    border-radius:22px !important;
    background:
      linear-gradient(140deg,rgba(255,255,255,.16),rgba(255,255,255,.05) 38%,rgba(255,214,93,.07) 72%),
      linear-gradient(180deg,rgba(12,39,45,.76),rgba(18,11,48,.88)) !important;
    border:1px solid rgba(205,255,231,.22) !important;
    box-shadow:
      inset 0 1px 0 rgba(255,255,255,.22),
      inset 0 -16px 36px rgba(0,0,0,.18),
      0 18px 32px rgba(0,0,0,.24) !important;
    overflow:hidden !important;
    transform-style:preserve-3d !important;
  }

  #appModal .modalCard[data-panel="trend"] .panelCanvas::before{
    content:"" !important;
    position:absolute !important;
    inset:1px !important;
    border-radius:21px !important;
    pointer-events:none !important;
    background:
      linear-gradient(115deg,rgba(255,255,255,.30),transparent 28%),
      linear-gradient(250deg,rgba(90,255,204,.14),transparent 34%) !important;
    opacity:.82 !important;
    display:block !important;
  }

  #appModal .modalCard[data-panel="trend"] .panelCanvas::after{
    content:"" !important;
    position:absolute !important;
    inset:8px !important;
    border-radius:17px !important;
    border:1px solid rgba(255,255,255,.08) !important;
    pointer-events:none !important;
    display:block !important;
  }

  #appModal .trendBoardTable{
    position:relative !important;
    z-index:1 !important;
    flex:1 1 auto !important;
    width:100% !important;
    height:100% !important;
    min-height:0 !important;
    gap:7px !important;
    padding:18px 1px 1px !important;
    overflow:hidden !important;
    perspective:820px !important;
    transform-style:preserve-3d !important;
  }

  #appModal .trendNew{
    top:-5px !important;
    right:7px !important;
    padding:2px 7px !important;
    border-radius:999px !important;
    background:rgba(255,226,120,.14) !important;
    border:1px solid rgba(255,226,120,.34) !important;
    color:#fff1a7 !important;
    font-size:10px !important;
    text-shadow:0 0 9px rgba(255,212,92,.35) !important;
    box-shadow:inset 0 1px 0 rgba(255,255,255,.18),0 6px 12px rgba(0,0,0,.18) !important;
  }

  #appModal .trendBoardHead{
    gap:7px !important;
    padding:1px 1px 5px !important;
    background:linear-gradient(180deg,rgba(14,23,47,.88),rgba(14,23,47,.30)) !important;
    backdrop-filter:blur(8px) saturate(140%) !important;
    -webkit-backdrop-filter:blur(8px) saturate(140%) !important;
  }

  #appModal .trendBoardLabel{
    min-height:28px !important;
    border-radius:12px !important;
    border:1px solid rgba(212,255,235,.22) !important;
    background:
      linear-gradient(180deg,rgba(255,255,255,.20),rgba(255,255,255,.055)),
      linear-gradient(135deg,rgba(49,231,185,.18),rgba(255,217,98,.12)) !important;
    color:#ecffcf !important;
    font-size:10px !important;
    text-shadow:0 0 10px rgba(81,238,190,.26),0 1px 0 rgba(0,0,0,.42) !important;
    box-shadow:inset 0 1px 0 rgba(255,255,255,.22),0 9px 16px rgba(0,0,0,.17) !important;
  }

  #appModal .trendBoardRow{
    gap:7px !important;
    transform:rotateX(4deg) translateZ(0) !important;
    transform-origin:center top !important;
    transform-style:preserve-3d !important;
  }

  #appModal .trendBoardCell{
    min-height:35px !important;
    border-radius:13px !important;
    border:1px solid rgba(210,255,236,.14) !important;
    background:
      linear-gradient(180deg,rgba(255,255,255,.12),rgba(255,255,255,.035)),
      linear-gradient(145deg,rgba(40,206,168,.08),rgba(120,58,202,.10)) !important;
    box-shadow:
      inset 0 1px 0 rgba(255,255,255,.16),
      inset 0 -10px 20px rgba(0,0,0,.08),
      0 8px 14px rgba(0,0,0,.14) !important;
    transform:translateZ(1px) !important;
    transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease !important;
  }

  #appModal .trendBoardCell.has-token{
    border-color:rgba(255,232,128,.54) !important;
    background:
      linear-gradient(180deg,rgba(255,255,255,.22),rgba(255,255,255,.065)),
      linear-gradient(145deg,rgba(64,238,190,.24),rgba(255,213,92,.20) 58%,rgba(157,78,255,.14)) !important;
    box-shadow:
      inset 0 1px 0 rgba(255,255,255,.35),
      0 12px 20px rgba(0,0,0,.20),
      0 0 18px rgba(74,242,195,.18) !important;
    transform:translateY(-1px) translateZ(18px) scale(1.02) !important;
  }

  #appModal .trendToken{
    width:29px !important;
    height:29px !important;
    font-size:17px !important;
    border:1px solid rgba(255,245,185,.82) !important;
    background:
      radial-gradient(circle at 32% 24%,rgba(255,255,255,.96),rgba(255,255,255,.22) 36%,transparent 58%),
      linear-gradient(145deg,#fff2a9,#47eec4 42%,#8c5dff 100%) !important;
    box-shadow:
      inset 0 1px 0 rgba(255,255,255,.36),
      0 8px 13px rgba(0,0,0,.25),
      0 0 14px rgba(255,226,115,.20) !important;
    transform:translateZ(20px) !important;
  }

  #appModal .trendBoardRow.is-new .trendBoardCell.has-token{
    border-color:rgba(255,239,148,.76) !important;
    box-shadow:
      inset 0 1px 0 rgba(255,255,255,.38),
      0 14px 23px rgba(0,0,0,.22),
      0 0 22px rgba(255,225,115,.28),
      0 0 16px rgba(67,239,191,.20) !important;
  }

  @media(max-height:450px){
    #appModal .modalCard[data-panel="trend"]{
      height:calc(100dvh - 24px) !important;
    }
    #appModal .modalCard[data-panel="trend"] .modalBody{
      padding:8px 12px 9px !important;
    }
    #appModal .modalCard[data-panel="trend"] .panelCanvas{
      padding:8px !important;
      border-radius:18px !important;
    }
    #appModal .trendBoardTable{
      gap:3px !important;
      padding:11px 1px 1px !important;
    }
    #appModal .trendBoardHead,
    #appModal .trendBoardRow{
      gap:4px !important;
    }
    #appModal .trendBoardLabel{
      min-height:19px !important;
      padding:2px 3px !important;
      font-size:8px !important;
      border-radius:8px !important;
    }
    #appModal .trendBoardCell{
      min-height:20px !important;
      border-radius:8px !important;
    }
    #appModal .trendToken{
      width:19px !important;
      height:19px !important;
      font-size:12px !important;
    }
    #appModal .trendNew{
      top:-3px !important;
      right:5px !important;
      padding:1px 5px !important;
      font-size:8px !important;
    }
  }
</style>
</body>
</html>




















