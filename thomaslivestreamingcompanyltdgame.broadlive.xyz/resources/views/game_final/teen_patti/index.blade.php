@php
  $currentGameCode = $gameCode ?? 'teen_patti';
  $gameTheme = is_array($gameTheme ?? null) ? $gameTheme : [];
  $teenPattiCustomAssets = [
    'teen_patti' => [
      'logo' => 'game_final_assets/teen_patti/custom/classic_logo.webp',
      'winner_banner' => 'game_final_assets/teen_patti/custom/classic_winner_banner.webp',
      'card_back' => 'game_final_assets/teen_patti/custom/classic_card_back.webp',
    ],
    'teen_patti_king' => [
      'logo' => 'game_final_assets/teen_patti/custom/teen_patti_king_logo.webp',
      'winner_banner' => 'game_final_assets/teen_patti/custom/teen_patti_king_winner_banner.webp',
      'card_back' => 'game_final_assets/teen_patti/custom/teen_patti_king_card_back.webp',
    ],
    'teen_patti_sultan' => [
      'logo' => 'game_final_assets/teen_patti/custom/teen_patti_sultan_logo.webp',
      'winner_banner' => 'game_final_assets/teen_patti/custom/teen_patti_sultan_winner_banner.webp',
      'card_back' => 'game_final_assets/teen_patti/custom/teen_patti_sultan_card_back.webp',
    ],
    'teen_patti_warfront' => [
      'logo' => 'game_final_assets/teen_patti/custom/teen_patti_warfront_logo.webp',
      'winner_banner' => 'game_final_assets/teen_patti/custom/teen_patti_warfront_winner_banner.webp',
      'card_back' => 'game_final_assets/teen_patti/custom/teen_patti_warfront_card_back.webp',
    ],
    'teen_patti_neon' => [
      'logo' => 'game_final_assets/teen_patti/custom/teen_patti_neon_logo.webp',
      'winner_banner' => 'game_final_assets/teen_patti/custom/teen_patti_neon_winner_banner.webp',
      'card_back' => 'game_final_assets/teen_patti/custom/teen_patti_neon_card_back.webp',
    ],
    'teen_patti_shogun' => [
      'logo' => 'game_final_assets/teen_patti/custom/teen_patti_shogun_logo.webp',
      'winner_banner' => 'game_final_assets/teen_patti/custom/teen_patti_shogun_winner_banner.webp',
      'card_back' => 'game_final_assets/teen_patti/custom/teen_patti_shogun_card_back.webp',
    ],
    'teen_patti_glacier' => [
      'logo' => 'game_final_assets/teen_patti/custom/teen_patti_glacier_logo.webp',
      'winner_banner' => 'game_final_assets/teen_patti/custom/teen_patti_glacier_winner_banner.webp',
      'card_back' => 'game_final_assets/teen_patti/custom/teen_patti_glacier_card_back.webp',
    ],
  ];
  $currentTeenPattiAssets = $teenPattiCustomAssets[$currentGameCode] ?? null;
  $teenPattiPopupArtByGame = [
    'teen_patti' => [
      'surface' => 'linear-gradient(180deg, rgba(14,34,26,.98) 0%, rgba(20,77,56,.94) 44%, rgba(6,18,14,.99) 100%)',
      'title' => '#fff2cc',
      'copy' => '#fff7ea',
      'copy_soft' => 'rgba(250,244,227,.86)',
      'note_bg' => 'rgba(9,40,32,.72)',
      'note_border' => 'rgba(255,225,151,.34)',
      'note_text' => '#fff1c5',
      'accent' => 'linear-gradient(90deg, #f6d06f, #4bc68d, #fff3b9)',
      'icon_bg' => 'radial-gradient(circle at 30% 24%, rgba(255,252,232,.24), rgba(255,255,255,0) 58%), linear-gradient(145deg, rgba(12,61,46,.95), rgba(6,24,18,.99))',
      'icon_border' => 'rgba(255,229,162,.56)',
      'icon_color' => '#ffe6a0',
      'shell_shadow' => '0 34px 94px rgba(0,0,0,.60), 0 0 42px rgba(68,172,120,.22), inset 0 0 0 1px rgba(255,226,154,.14)',
      'toggle_off' => 'rgba(10,52,38,.88)',
      'toggle_on' => 'linear-gradient(135deg, #2ed18c, #0b8356)',
      'toggle_border' => 'rgba(255,229,162,.42)',
      'title_font' => "'Cormorant Garamond','Cinzel','Times New Roman',serif",
      'copy_font' => "'Inter','Segoe UI',sans-serif",
      'kicker_font' => "'Cinzel','Cormorant Garamond',serif",
      'overlay' => 'radial-gradient(circle at 50% 36%, rgba(80,208,138,.22), transparent 38%), linear-gradient(180deg, rgba(4,9,8,.26), rgba(2,5,9,.82))',
      'close_bg' => 'linear-gradient(145deg, rgba(255,232,168,.18), rgba(14,54,39,.92))',
      'close_border' => 'rgba(255,229,162,.42)',
      'close_text' => '#fff4cf',
      'modal_width' => '394px',
      'modal_min_height' => '318px',
      'modal_pad_top' => '110px',
      'modal_pad_bottom' => '78px',
      'audio_width' => '410px',
      'audio_min_height' => '336px',
      'audio_pad_top' => '112px',
      'audio_pad_bottom' => '78px',
      'utility_width' => '500px',
      'utility_min_height' => '422px',
      'utility_pad_top' => '116px',
      'utility_pad_bottom' => '84px',
    ],
    'teen_patti_king' => [
      'surface' => 'linear-gradient(180deg, rgba(9,20,53,.98) 0%, rgba(19,43,112,.94) 42%, rgba(8,12,28,.99) 100%)',
      'title' => '#fff0c3',
      'copy' => '#f7f7ff',
      'copy_soft' => 'rgba(234,240,255,.86)',
      'note_bg' => 'rgba(11,23,69,.72)',
      'note_border' => 'rgba(255,223,145,.34)',
      'note_text' => '#fff0bf',
      'accent' => 'linear-gradient(90deg, #6fd9ff, #ffd672, #9bb6ff)',
      'icon_bg' => 'radial-gradient(circle at 30% 24%, rgba(255,251,232,.24), rgba(255,255,255,0) 58%), linear-gradient(145deg, rgba(20,45,121,.95), rgba(8,12,37,.99))',
      'icon_border' => 'rgba(214,234,255,.56)',
      'icon_color' => '#fff0b1',
      'shell_shadow' => '0 36px 96px rgba(0,0,0,.62), 0 0 42px rgba(92,153,255,.22), inset 0 0 0 1px rgba(255,224,142,.14)',
      'toggle_off' => 'rgba(11,24,71,.88)',
      'toggle_on' => 'linear-gradient(135deg, #4d90ff, #2449c9)',
      'toggle_border' => 'rgba(214,234,255,.40)',
      'title_font' => "'Cinzel','Cormorant Garamond','Times New Roman',serif",
      'copy_font' => "'Poppins','Segoe UI',sans-serif",
      'kicker_font' => "'Cinzel','Cormorant Garamond',serif",
      'overlay' => 'radial-gradient(circle at 50% 34%, rgba(116,171,255,.22), transparent 40%), linear-gradient(180deg, rgba(3,7,18,.24), rgba(3,5,10,.84))',
      'close_bg' => 'linear-gradient(145deg, rgba(255,233,174,.18), rgba(13,27,77,.92))',
      'close_border' => 'rgba(221,236,255,.42)',
      'close_text' => '#fff3ca',
      'modal_width' => '398px',
      'modal_min_height' => '324px',
      'modal_pad_top' => '118px',
      'modal_pad_bottom' => '80px',
      'audio_width' => '414px',
      'audio_min_height' => '342px',
      'audio_pad_top' => '118px',
      'audio_pad_bottom' => '78px',
      'utility_width' => '512px',
      'utility_min_height' => '430px',
      'utility_pad_top' => '122px',
      'utility_pad_bottom' => '86px',
    ],
    'teen_patti_sultan' => [
      'surface' => 'linear-gradient(180deg, rgba(58,19,13,.98) 0%, rgba(126,34,28,.94) 42%, rgba(27,10,10,.99) 100%)',
      'title' => '#ffeaba',
      'copy' => '#fff1de',
      'copy_soft' => 'rgba(255,234,210,.86)',
      'note_bg' => 'rgba(79,18,17,.72)',
      'note_border' => 'rgba(255,211,132,.34)',
      'note_text' => '#ffe9bf',
      'accent' => 'linear-gradient(90deg, #ffd16a, #d7444b, #fff0b9)',
      'icon_bg' => 'radial-gradient(circle at 30% 24%, rgba(255,245,225,.24), rgba(255,255,255,0) 58%), linear-gradient(145deg, rgba(104,24,20,.95), rgba(46,10,11,.99))',
      'icon_border' => 'rgba(255,213,134,.56)',
      'icon_color' => '#ffe2a0',
      'shell_shadow' => '0 36px 98px rgba(0,0,0,.64), 0 0 42px rgba(204,73,78,.22), inset 0 0 0 1px rgba(255,219,146,.14)',
      'toggle_off' => 'rgba(72,15,16,.88)',
      'toggle_on' => 'linear-gradient(135deg, #df545d, #9c1e2a)',
      'toggle_border' => 'rgba(255,213,134,.42)',
      'title_font' => "'Cinzel','Cormorant Garamond','Times New Roman',serif",
      'copy_font' => "'El Messiri','Segoe UI',sans-serif",
      'kicker_font' => "'El Messiri','Cinzel',serif",
      'overlay' => 'radial-gradient(circle at 50% 34%, rgba(218,92,92,.22), transparent 40%), linear-gradient(180deg, rgba(10,4,4,.26), rgba(6,4,8,.84))',
      'close_bg' => 'linear-gradient(145deg, rgba(255,228,168,.18), rgba(96,23,24,.92))',
      'close_border' => 'rgba(255,213,134,.42)',
      'close_text' => '#fff1c8',
      'modal_width' => '396px',
      'modal_min_height' => '322px',
      'modal_pad_top' => '114px',
      'modal_pad_bottom' => '80px',
      'audio_width' => '412px',
      'audio_min_height' => '340px',
      'audio_pad_top' => '114px',
      'audio_pad_bottom' => '78px',
      'utility_width' => '506px',
      'utility_min_height' => '430px',
      'utility_pad_top' => '120px',
      'utility_pad_bottom' => '84px',
    ],
    'teen_patti_warfront' => [
      'surface' => 'linear-gradient(180deg, rgba(62,15,16,.98) 0%, rgba(18,33,86,.94) 44%, rgba(8,11,20,.99) 100%)',
      'title' => '#ffe6b4',
      'copy' => '#f4f3f4',
      'copy_soft' => 'rgba(233,238,245,.84)',
      'note_bg' => 'rgba(21,28,73,.74)',
      'note_border' => 'rgba(255,208,130,.32)',
      'note_text' => '#ffe8c4',
      'accent' => 'linear-gradient(90deg, #ff715e, #ffd36e, #5fc8ff)',
      'icon_bg' => 'radial-gradient(circle at 30% 24%, rgba(255,246,228,.22), rgba(255,255,255,0) 58%), linear-gradient(145deg, rgba(31,43,103,.95), rgba(49,12,16,.99))',
      'icon_border' => 'rgba(255,204,125,.54)',
      'icon_color' => '#ffe1a1',
      'shell_shadow' => '0 34px 94px rgba(0,0,0,.64), 0 0 40px rgba(91,151,255,.18), inset 0 0 0 1px rgba(255,212,132,.12)',
      'toggle_off' => 'rgba(30,38,89,.88)',
      'toggle_on' => 'linear-gradient(135deg, #ff7a61, #a91c25)',
      'toggle_border' => 'rgba(255,204,125,.40)',
      'title_font' => "'Cinzel','Cormorant Garamond','Times New Roman',serif",
      'copy_font' => "'Rajdhani','Segoe UI',sans-serif",
      'kicker_font' => "'Rajdhani','Cinzel',sans-serif",
      'overlay' => 'radial-gradient(circle at 50% 34%, rgba(108,154,255,.18), transparent 40%), linear-gradient(180deg, rgba(7,8,12,.30), rgba(2,4,9,.86))',
      'close_bg' => 'linear-gradient(145deg, rgba(255,218,148,.16), rgba(25,34,84,.94))',
      'close_border' => 'rgba(255,204,125,.42)',
      'close_text' => '#ffeec7',
      'modal_width' => '392px',
      'modal_min_height' => '316px',
      'modal_pad_top' => '108px',
      'modal_pad_bottom' => '76px',
      'audio_width' => '406px',
      'audio_min_height' => '334px',
      'audio_pad_top' => '108px',
      'audio_pad_bottom' => '76px',
      'utility_width' => '500px',
      'utility_min_height' => '420px',
      'utility_pad_top' => '114px',
      'utility_pad_bottom' => '82px',
    ],
    'teen_patti_neon' => [
      'surface' => 'linear-gradient(180deg, rgba(37,14,70,.98) 0%, rgba(85,24,128,.94) 40%, rgba(10,8,30,.99) 100%)',
      'title' => '#ffe8bb',
      'copy' => '#faf3ff',
      'copy_soft' => 'rgba(241,226,255,.84)',
      'note_bg' => 'rgba(55,18,88,.74)',
      'note_border' => 'rgba(255,214,144,.34)',
      'note_text' => '#ffe9c6',
      'accent' => 'linear-gradient(90deg, #ff74d0, #74e4ff, #ffde7f)',
      'icon_bg' => 'radial-gradient(circle at 30% 24%, rgba(255,245,232,.22), rgba(255,255,255,0) 58%), linear-gradient(145deg, rgba(82,22,125,.95), rgba(19,12,46,.99))',
      'icon_border' => 'rgba(241,208,255,.50)',
      'icon_color' => '#ffe5a5',
      'shell_shadow' => '0 36px 96px rgba(0,0,0,.64), 0 0 42px rgba(154,82,255,.22), inset 0 0 0 1px rgba(255,220,153,.12)',
      'toggle_off' => 'rgba(53,16,85,.88)',
      'toggle_on' => 'linear-gradient(135deg, #b155ff, #5527e0)',
      'toggle_border' => 'rgba(241,208,255,.38)',
      'title_font' => "'Cinzel','Cormorant Garamond','Times New Roman',serif",
      'copy_font' => "'Poppins','Segoe UI',sans-serif",
      'kicker_font' => "'Orbitron','Cinzel',sans-serif",
      'overlay' => 'radial-gradient(circle at 50% 34%, rgba(175,96,255,.22), transparent 40%), linear-gradient(180deg, rgba(6,5,14,.28), rgba(3,4,10,.86))',
      'close_bg' => 'linear-gradient(145deg, rgba(255,223,156,.16), rgba(65,21,100,.94))',
      'close_border' => 'rgba(241,208,255,.40)',
      'close_text' => '#fff1d2',
      'modal_width' => '394px',
      'modal_min_height' => '318px',
      'modal_pad_top' => '110px',
      'modal_pad_bottom' => '78px',
      'audio_width' => '410px',
      'audio_min_height' => '336px',
      'audio_pad_top' => '112px',
      'audio_pad_bottom' => '78px',
      'utility_width' => '504px',
      'utility_min_height' => '424px',
      'utility_pad_top' => '118px',
      'utility_pad_bottom' => '84px',
    ],
    'teen_patti_shogun' => [
      'surface' => 'linear-gradient(180deg, rgba(66,16,14,.98) 0%, rgba(107,24,20,.94) 42%, rgba(16,6,8,.99) 100%)',
      'title' => '#ffe6bb',
      'copy' => '#fff0e2',
      'copy_soft' => 'rgba(246,226,214,.84)',
      'note_bg' => 'rgba(71,16,16,.74)',
      'note_border' => 'rgba(255,207,130,.34)',
      'note_text' => '#ffe4c2',
      'accent' => 'linear-gradient(90deg, #ffcb69, #cf4440, #fff0b6)',
      'icon_bg' => 'radial-gradient(circle at 30% 24%, rgba(255,243,230,.22), rgba(255,255,255,0) 58%), linear-gradient(145deg, rgba(91,18,16,.95), rgba(24,8,9,.99))',
      'icon_border' => 'rgba(255,206,128,.54)',
      'icon_color' => '#ffe2a2',
      'shell_shadow' => '0 36px 98px rgba(0,0,0,.64), 0 0 40px rgba(193,67,61,.20), inset 0 0 0 1px rgba(255,214,136,.12)',
      'toggle_off' => 'rgba(63,13,14,.88)',
      'toggle_on' => 'linear-gradient(135deg, #d44d46, #81111b)',
      'toggle_border' => 'rgba(255,206,128,.40)',
      'title_font' => "'Cinzel','Cormorant Garamond','Times New Roman',serif",
      'copy_font' => "'Poppins','Segoe UI',sans-serif",
      'kicker_font' => "'Teko','Cinzel',sans-serif",
      'overlay' => 'radial-gradient(circle at 50% 34%, rgba(212,92,82,.20), transparent 40%), linear-gradient(180deg, rgba(8,4,4,.28), rgba(3,4,8,.86))',
      'close_bg' => 'linear-gradient(145deg, rgba(255,223,156,.16), rgba(82,16,18,.94))',
      'close_border' => 'rgba(255,206,128,.40)',
      'close_text' => '#fff0c7',
      'modal_width' => '396px',
      'modal_min_height' => '320px',
      'modal_pad_top' => '112px',
      'modal_pad_bottom' => '78px',
      'audio_width' => '410px',
      'audio_min_height' => '338px',
      'audio_pad_top' => '114px',
      'audio_pad_bottom' => '78px',
      'utility_width' => '504px',
      'utility_min_height' => '426px',
      'utility_pad_top' => '120px',
      'utility_pad_bottom' => '84px',
    ],
    'teen_patti_glacier' => [
      'surface' => 'linear-gradient(180deg, rgba(9,30,38,.98) 0%, rgba(19,88,101,.94) 42%, rgba(6,15,22,.99) 100%)',
      'title' => '#f5efce',
      'copy' => '#f2fbff',
      'copy_soft' => 'rgba(229,245,252,.86)',
      'note_bg' => 'rgba(10,39,52,.72)',
      'note_border' => 'rgba(203,242,255,.34)',
      'note_text' => '#e9f9ff',
      'accent' => 'linear-gradient(90deg, #7ae5ff, #ffd98a, #b6f3ff)',
      'icon_bg' => 'radial-gradient(circle at 30% 24%, rgba(245,255,255,.24), rgba(255,255,255,0) 58%), linear-gradient(145deg, rgba(12,68,78,.95), rgba(5,23,28,.99))',
      'icon_border' => 'rgba(200,241,255,.54)',
      'icon_color' => '#fff0bc',
      'shell_shadow' => '0 34px 94px rgba(0,0,0,.60), 0 0 42px rgba(121,210,225,.20), inset 0 0 0 1px rgba(229,245,252,.12)',
      'toggle_off' => 'rgba(11,44,57,.88)',
      'toggle_on' => 'linear-gradient(135deg, #6fd4e5, #1c7c8f)',
      'toggle_border' => 'rgba(200,241,255,.40)',
      'title_font' => "'Marcellus','Cinzel','Cormorant Garamond',serif",
      'copy_font' => "'Inter','Segoe UI',sans-serif",
      'kicker_font' => "'Marcellus','Cinzel',serif",
      'overlay' => 'radial-gradient(circle at 50% 34%, rgba(113,206,218,.20), transparent 40%), linear-gradient(180deg, rgba(5,8,12,.26), rgba(3,5,10,.84))',
      'close_bg' => 'linear-gradient(145deg, rgba(234,247,252,.18), rgba(11,49,57,.94))',
      'close_border' => 'rgba(200,241,255,.40)',
      'close_text' => '#eefcff',
      'modal_width' => '394px',
      'modal_min_height' => '318px',
      'modal_pad_top' => '108px',
      'modal_pad_bottom' => '78px',
      'audio_width' => '410px',
      'audio_min_height' => '336px',
      'audio_pad_top' => '110px',
      'audio_pad_bottom' => '78px',
      'utility_width' => '504px',
      'utility_min_height' => '424px',
      'utility_pad_top' => '116px',
      'utility_pad_bottom' => '84px',
    ],
  ];
  $teenPattiVariants = [
    'teen_patti' => [
      'blade_id' => 'classic_table',
      'system_name' => 'classic_glass',
      'class' => '',
      'timer_theme' => 'casino',
      'chair_set' => 'custom_teen_patti',
      'meta_description' => 'Teen Patti - Premium Casino Game',
      'splash_subtitle' => 'Premium Magical Table',
      'splash_loading' => 'Preparing table...',
      'theme_color' => '#0b0715',
      'chip_theme' => 'classic',
      'seat_prefix' => 'SEAT',
      'seat_titles' => ['A' => 'A', 'B' => 'B', 'C' => 'C'],
      'glass_fill' => 'linear-gradient(145deg, rgba(20,18,48,.72), rgba(7,9,22,.88))',
      'glass_border' => 'rgba(255,223,148,.28)',
      'glass_highlight' => 'rgba(255,255,255,.18)',
      'glass_glow' => 'rgba(130,104,255,.18)',
      'board_glow' => 'rgba(255,215,110,.18)',
      'coin_sand_color' => '#ffd76e',
      'coin_sand_soft' => 'rgba(255,215,110,.24)',
      'timer_ring' => '#46e88a',
      'timer_glow' => 'rgba(70,232,138,.26)',
      'countdown_hand' => '#fff5c8',
      'payout_glow' => 'rgba(255,215,110,.34)',
      'table_haze' => 'radial-gradient(circle at 50% 14%, rgba(255,255,255,.12), transparent 30%), radial-gradient(circle at 52% 100%, rgba(126,94,255,.18), transparent 34%)',
      'chip_arc_height' => 116,
      'payout_arc_height' => 156,
      'flip_lift' => 16,
      'flip_tilt' => 12,
      'flip_in_duration' => 0.22,
      'flip_out_duration' => 0.40,
      'payout_chip_count' => 5,
    ],
    'teen_patti_king' => [
      'blade_id' => 'royal_court',
      'system_name' => 'royal_glass',
      'class' => 'teenpatti-king',
      'timer_theme' => 'royal',
      'chair_set' => 'royal',
      'meta_description' => 'TeenPatti King - Royal live Teen Patti table with premium timing and effects.',
      'splash_subtitle' => 'Royal High Stakes Table',
      'splash_loading' => 'Syncing royal table...',
      'theme_color' => '#14081f',
      'chip_theme' => 'king',
      'seat_prefix' => 'ROYAL',
      'seat_titles' => ['A' => 'KING', 'B' => 'QUEEN', 'C' => 'ACE'],
      'glass_fill' => 'linear-gradient(145deg, rgba(62,40,8,.70), rgba(18,10,4,.92))',
      'glass_border' => 'rgba(255,224,146,.36)',
      'glass_highlight' => 'rgba(255,248,224,.24)',
      'glass_glow' => 'rgba(255,201,94,.18)',
      'board_glow' => 'rgba(255,214,112,.26)',
      'coin_sand_color' => '#ffe08f',
      'coin_sand_soft' => 'rgba(255,208,118,.28)',
      'timer_ring' => '#ffd76e',
      'timer_glow' => 'rgba(255,214,112,.28)',
      'countdown_hand' => '#fff8db',
      'payout_glow' => 'rgba(255,214,112,.38)',
      'table_haze' => 'radial-gradient(circle at 50% 16%, rgba(255,247,218,.16), transparent 28%), radial-gradient(circle at 50% 100%, rgba(255,199,83,.18), transparent 36%)',
      'chip_arc_height' => 128,
      'payout_arc_height' => 170,
      'flip_lift' => 18,
      'flip_tilt' => 14,
      'flip_in_duration' => 0.24,
      'flip_out_duration' => 0.42,
      'payout_chip_count' => 6,
    ],
    'teen_patti_sultan' => [
      'blade_id' => 'lantern_palace',
      'system_name' => 'palace_glass',
      'class' => 'teenpatti-sultan',
      'timer_theme' => 'deco',
      'chair_set' => 'custom_teen_patti_sultan',
      'meta_description' => 'TeenPatti Sultan - Palace-themed live Teen Patti table with ornate gold UI and lantern glow.',
      'splash_subtitle' => 'Lantern Palace Table',
      'splash_loading' => 'Lighting palace lanterns...',
      'theme_color' => '#261308',
      'chip_theme' => 'sultan',
      'seat_prefix' => 'MAJLIS',
      'seat_titles' => ['A' => 'RUBY', 'B' => 'DUNE', 'C' => 'CROWN'],
      'glass_fill' => 'linear-gradient(145deg, rgba(66,34,11,.74), rgba(18,10,4,.94))',
      'glass_border' => 'rgba(255,221,158,.34)',
      'glass_highlight' => 'rgba(255,244,220,.22)',
      'glass_glow' => 'rgba(255,190,104,.16)',
      'board_glow' => 'rgba(255,198,112,.24)',
      'coin_sand_color' => '#ffd88e',
      'coin_sand_soft' => 'rgba(255,202,120,.26)',
      'timer_ring' => '#ffd58f',
      'timer_glow' => 'rgba(255,221,158,.26)',
      'countdown_hand' => '#fff0cf',
      'payout_glow' => 'rgba(255,206,128,.36)',
      'table_haze' => 'radial-gradient(circle at 50% 14%, rgba(255,230,183,.14), transparent 28%), radial-gradient(circle at 18% 84%, rgba(78,192,214,.16), transparent 32%)',
      'chip_arc_height' => 122,
      'payout_arc_height' => 166,
      'flip_lift' => 17,
      'flip_tilt' => 13,
      'flip_in_duration' => 0.23,
      'flip_out_duration' => 0.40,
      'payout_chip_count' => 5,
    ],
    'teen_patti_warfront' => [
      'blade_id' => 'battle_command',
      'system_name' => 'warfront_glass',
      'class' => 'teenpatti-warfront',
      'timer_theme' => 'cyber',
      'chair_set' => 'custom_teen_patti_warfront',
      'meta_description' => 'TeenPatti Warfront - Tactical live Teen Patti table with armored UI and command-room effects.',
      'splash_subtitle' => 'Battle Command Table',
      'splash_loading' => 'Priming frontline table...',
      'theme_color' => '#1a1b1f',
      'chip_theme' => 'warfront',
      'seat_prefix' => 'UNIT',
      'seat_titles' => ['A' => 'ALPHA', 'B' => 'FORT', 'C' => 'RAVEN'],
      'glass_fill' => 'linear-gradient(145deg, rgba(36,42,52,.74), rgba(11,14,20,.94))',
      'glass_border' => 'rgba(170,181,192,.28)',
      'glass_highlight' => 'rgba(244,247,252,.14)',
      'glass_glow' => 'rgba(255,120,80,.12)',
      'board_glow' => 'rgba(255,137,94,.22)',
      'coin_sand_color' => '#ffb794',
      'coin_sand_soft' => 'rgba(255,137,94,.24)',
      'timer_ring' => '#ff8b5e',
      'timer_glow' => 'rgba(255,137,94,.24)',
      'countdown_hand' => '#ffe4d5',
      'payout_glow' => 'rgba(255,146,92,.30)',
      'table_haze' => 'radial-gradient(circle at 50% 16%, rgba(255,146,92,.12), transparent 28%), radial-gradient(circle at 84% 84%, rgba(170,181,192,.14), transparent 34%)',
      'chip_arc_height' => 110,
      'payout_arc_height' => 148,
      'flip_lift' => 15,
      'flip_tilt' => 10,
      'flip_in_duration' => 0.20,
      'flip_out_duration' => 0.36,
      'payout_chip_count' => 4,
    ],
    'teen_patti_neon' => [
      'blade_id' => 'neon_blood_glam',
      'system_name' => 'neon_blood_glass',
      'class' => 'teenpatti-neon',
      'timer_theme' => 'neon',
      'chair_set' => 'custom_teen_patti_neon',
      'meta_description' => 'TeenPatti Neon - Cyber live Teen Patti table with synthwave cards, chairs, and timer shell.',
      'splash_subtitle' => 'Neon Skyline Table',
      'splash_loading' => 'Charging neon arena...',
      'theme_color' => '#05081a',
      'chip_theme' => 'neon',
      'seat_prefix' => 'POD',
      'seat_titles' => ['A' => 'PULSE', 'B' => 'VOLT', 'C' => 'FLUX'],
      'glass_fill' => 'linear-gradient(145deg, rgba(18,14,46,.76), rgba(7,7,20,.94))',
      'glass_border' => 'rgba(72,225,255,.30)',
      'glass_highlight' => 'rgba(255,255,255,.18)',
      'glass_glow' => 'rgba(255,84,180,.18)',
      'board_glow' => 'rgba(72,225,255,.28)',
      'coin_sand_color' => '#ff79d0',
      'coin_sand_soft' => 'rgba(72,225,255,.24)',
      'timer_ring' => '#48e1ff',
      'timer_glow' => 'rgba(72,225,255,.26)',
      'countdown_hand' => '#fff1ff',
      'payout_glow' => 'rgba(255,84,180,.34)',
      'table_haze' => 'radial-gradient(circle at 50% 14%, rgba(255,84,180,.16), transparent 28%), radial-gradient(circle at 86% 80%, rgba(72,225,255,.18), transparent 34%)',
      'chip_arc_height' => 132,
      'payout_arc_height' => 178,
      'flip_lift' => 19,
      'flip_tilt' => 15,
      'flip_in_duration' => 0.22,
      'flip_out_duration' => 0.40,
      'payout_chip_count' => 6,
    ],
    'teen_patti_shogun' => [
      'blade_id' => 'shogun_court',
      'system_name' => 'shogun_glass',
      'class' => 'teenpatti-shogun',
      'timer_theme' => 'samurai',
      'chair_set' => 'custom_teen_patti_shogun',
      'meta_description' => 'TeenPatti Shogun - Lacquered court Teen Patti table with disciplined red-gold styling.',
      'splash_subtitle' => 'Shogun Court Table',
      'splash_loading' => 'Preparing lacquered court...',
      'theme_color' => '#170a0a',
      'chip_theme' => 'shogun',
      'seat_prefix' => 'DOJO',
      'seat_titles' => ['A' => 'RONIN', 'B' => 'KATANA', 'C' => 'SHIRO'],
      'glass_fill' => 'linear-gradient(145deg, rgba(46,12,12,.76), rgba(14,5,6,.95))',
      'glass_border' => 'rgba(255,208,118,.30)',
      'glass_highlight' => 'rgba(255,235,190,.18)',
      'glass_glow' => 'rgba(214,58,53,.16)',
      'board_glow' => 'rgba(255,208,118,.22)',
      'coin_sand_color' => '#ffd28a',
      'coin_sand_soft' => 'rgba(255,208,118,.24)',
      'timer_ring' => '#ffcc74',
      'timer_glow' => 'rgba(255,208,118,.24)',
      'countdown_hand' => '#fff0d3',
      'payout_glow' => 'rgba(214,58,53,.30)',
      'table_haze' => 'radial-gradient(circle at 50% 14%, rgba(255,208,118,.12), transparent 28%), radial-gradient(circle at 18% 84%, rgba(180,42,42,.18), transparent 34%)',
      'chip_arc_height' => 120,
      'payout_arc_height' => 164,
      'flip_lift' => 17,
      'flip_tilt' => 13,
      'flip_in_duration' => 0.22,
      'flip_out_duration' => 0.38,
      'payout_chip_count' => 5,
    ],
    'teen_patti_glacier' => [
      'blade_id' => 'glacier_crystal',
      'system_name' => 'glacier_glass',
      'class' => 'teenpatti-glacier',
      'timer_theme' => 'frost',
      'chair_set' => 'custom_teen_patti_glacier',
      'meta_description' => 'TeenPatti Glacier - Frosted crystal Teen Patti table with icy boards and cool light effects.',
      'splash_subtitle' => 'Glacier Crystal Table',
      'splash_loading' => 'Cooling crystal table...',
      'theme_color' => '#06111a',
      'chip_theme' => 'glacier',
      'seat_prefix' => 'NEXUS',
      'seat_titles' => ['A' => 'FROST', 'B' => 'AURORA', 'C' => 'CRYO'],
      'glass_fill' => 'linear-gradient(145deg, rgba(14,38,56,.76), rgba(6,14,24,.96))',
      'glass_border' => 'rgba(186,236,255,.30)',
      'glass_highlight' => 'rgba(240,250,255,.20)',
      'glass_glow' => 'rgba(120,208,255,.18)',
      'board_glow' => 'rgba(186,236,255,.26)',
      'coin_sand_color' => '#c6f6ff',
      'coin_sand_soft' => 'rgba(186,236,255,.24)',
      'timer_ring' => '#b4edff',
      'timer_glow' => 'rgba(186,236,255,.28)',
      'countdown_hand' => '#f4fdff',
      'payout_glow' => 'rgba(120,208,255,.30)',
      'table_haze' => 'radial-gradient(circle at 50% 14%, rgba(210,242,255,.16), transparent 28%), radial-gradient(circle at 84% 82%, rgba(117,185,255,.16), transparent 34%)',
      'chip_arc_height' => 126,
      'payout_arc_height' => 168,
      'flip_lift' => 18,
      'flip_tilt' => 12,
      'flip_in_duration' => 0.24,
      'flip_out_duration' => 0.42,
      'payout_chip_count' => 6,
    ],
  ];
  $teenPattiVariant = $teenPattiVariants[$currentGameCode] ?? $teenPattiVariants['teen_patti'];
  if (isset($teenPattiVariantConfig) && is_array($teenPattiVariantConfig)) {
    $teenPattiVariant = array_replace($teenPattiVariant, $teenPattiVariantConfig);
  }
  if (!empty($gameTheme)) {
    $teenPattiVariant['timer_theme'] = $gameTheme['clock_theme'] ?? $teenPattiVariant['timer_theme'];
    $teenPattiVariant['theme_color'] = $gameTheme['primary_color'] ?? $teenPattiVariant['theme_color'];
    $teenPattiVariant['chip_theme'] = $gameTheme['chip_theme'] ?? $teenPattiVariant['chip_theme'];
    $chairTheme = (string) ($gameTheme['chair_theme'] ?? '');
    if (in_array($chairTheme, ['classic', 'royal'], true)) {
      $teenPattiVariant['chair_set'] = $chairTheme;
    }
    if (!empty($gameTheme['accent_color'])) {
      $teenPattiVariant['coin_sand_color'] = $gameTheme['accent_color'];
      $teenPattiVariant['timer_ring'] = $gameTheme['accent_color'];
    }
  }
  $customTeenPattiChairSetByGame = [
    'teen_patti' => 'custom_teen_patti',
    'teen_patti_sultan' => 'custom_teen_patti_sultan',
    'teen_patti_warfront' => 'custom_teen_patti_warfront',
    'teen_patti_neon' => 'custom_teen_patti_neon',
    'teen_patti_shogun' => 'custom_teen_patti_shogun',
    'teen_patti_glacier' => 'custom_teen_patti_glacier',
  ];
  if (isset($customTeenPattiChairSetByGame[$currentGameCode])) {
    $teenPattiVariant['chair_set'] = $customTeenPattiChairSetByGame[$currentGameCode];
  }
  $teenPattiPopupTheme = $teenPattiPopupArtByGame[$currentGameCode] ?? $teenPattiPopupArtByGame['teen_patti'];
  $appVariantClass = $teenPattiVariant['class'];
  $currentGameName = config('bd_game_final.games.' . $currentGameCode . '.name', 'Teen Patti');
  $metaDescription = $teenPattiVariant['meta_description'];
  $splashSubtitle = $teenPattiVariant['splash_subtitle'];
  $splashLoadingText = $teenPattiVariant['splash_loading'];
  $seatPrefix = $teenPattiVariant['seat_prefix'];
  $seatTitles = $teenPattiVariant['seat_titles'];
  $seatSummary = implode(' / ', array_values($seatTitles));
  $boardPayoutMultipliers = ['A' => 3, 'B' => 3, 'C' => 3];
  foreach ((array) ($gameRules['boards'] ?? []) as $boardRule) {
    $boardKey = (string) ($boardRule['canonical_key'] ?? $boardRule['frontend_key'] ?? '');
    if ($boardKey !== '') {
      $boardPayoutMultipliers[$boardKey] = (float) ($boardRule['multiplier'] ?? $boardPayoutMultipliers[$boardKey] ?? 3);
    }
  }
  $formatTeenPattiMultiplier = function ($value) {
    return rtrim(rtrim(number_format((float) $value, 2, '.', ''), '0'), '.');
  };
  $teenPattiChairSets = [
    'classic' => [
      'A' => ['asset' => 'game_final_assets/teen_patti/custom_chairs/teen_patti_chair_a.webp', 'class' => 'chair-custom-art chair-custom-a'],
      'B' => ['asset' => 'game_final_assets/teen_patti/custom_chairs/teen_patti_chair_b.webp', 'class' => 'chair-custom-art chair-custom-b'],
      'C' => ['asset' => 'game_final_assets/teen_patti/custom_chairs/teen_patti_chair_c.webp', 'class' => 'chair-custom-art chair-custom-c'],
    ],
    'royal' => [
      'A' => ['asset' => 'game_final_assets/teen_patti/custom_chairs/teen_patti_chair_a.webp', 'class' => 'chair-royal chair-custom-art chair-custom-a chair-royal-ruby'],
      'B' => ['asset' => 'game_final_assets/teen_patti/custom_chairs/teen_patti_chair_b.webp', 'class' => 'chair-royal chair-custom-art chair-custom-b chair-royal-sapphire'],
      'C' => ['asset' => 'game_final_assets/teen_patti/custom_chairs/teen_patti_chair_c.webp', 'class' => 'chair-royal chair-custom-art chair-custom-c chair-royal-amethyst'],
    ],
    'custom_teen_patti' => [
      'A' => ['asset' => 'game_final_assets/teen_patti/custom_chairs/teen_patti_chair_a.webp', 'class' => 'chair-custom-art chair-custom-a'],
      'B' => ['asset' => 'game_final_assets/teen_patti/custom_chairs/teen_patti_chair_b.webp', 'class' => 'chair-custom-art chair-custom-b'],
      'C' => ['asset' => 'game_final_assets/teen_patti/custom_chairs/teen_patti_chair_c.webp', 'class' => 'chair-custom-art chair-custom-c'],
    ],
    'custom_teen_patti_sultan' => [
      'A' => ['asset' => 'game_final_assets/teen_patti/custom_chairs/teen_patti_sultan_chair_a.webp', 'class' => 'chair-custom-art chair-custom-a'],
      'B' => ['asset' => 'game_final_assets/teen_patti/custom_chairs/teen_patti_sultan_chair_b.webp', 'class' => 'chair-custom-art chair-custom-b'],
      'C' => ['asset' => 'game_final_assets/teen_patti/custom_chairs/teen_patti_sultan_chair_c.webp', 'class' => 'chair-custom-art chair-custom-c'],
    ],
    'custom_teen_patti_warfront' => [
      'A' => ['asset' => 'game_final_assets/teen_patti/custom_chairs/teen_patti_warfront_chair_a.webp', 'class' => 'chair-custom-art chair-custom-a'],
      'B' => ['asset' => 'game_final_assets/teen_patti/custom_chairs/teen_patti_warfront_chair_b.webp', 'class' => 'chair-custom-art chair-custom-b'],
      'C' => ['asset' => 'game_final_assets/teen_patti/custom_chairs/teen_patti_warfront_chair_c.webp', 'class' => 'chair-custom-art chair-custom-c'],
    ],
    'custom_teen_patti_neon' => [
      'A' => ['asset' => 'game_final_assets/teen_patti/custom_chairs/teen_patti_neon_chair_a.webp', 'class' => 'chair-custom-art chair-custom-a'],
      'B' => ['asset' => 'game_final_assets/teen_patti/custom_chairs/teen_patti_neon_chair_b.webp', 'class' => 'chair-custom-art chair-custom-b'],
      'C' => ['asset' => 'game_final_assets/teen_patti/custom_chairs/teen_patti_neon_chair_c.webp', 'class' => 'chair-custom-art chair-custom-c'],
    ],
    'custom_teen_patti_shogun' => [
      'A' => ['asset' => 'game_final_assets/teen_patti/custom_chairs/teen_patti_shogun_chair_a.webp', 'class' => 'chair-custom-art chair-custom-a'],
      'B' => ['asset' => 'game_final_assets/teen_patti/custom_chairs/teen_patti_shogun_chair_b.webp', 'class' => 'chair-custom-art chair-custom-b'],
      'C' => ['asset' => 'game_final_assets/teen_patti/custom_chairs/teen_patti_shogun_chair_c.webp', 'class' => 'chair-custom-art chair-custom-c'],
    ],
    'custom_teen_patti_glacier' => [
      'A' => ['asset' => 'game_final_assets/teen_patti/custom_chairs/teen_patti_glacier_chair_a.webp', 'class' => 'chair-custom-art chair-custom-a'],
      'B' => ['asset' => 'game_final_assets/teen_patti/custom_chairs/teen_patti_glacier_chair_b.webp', 'class' => 'chair-custom-art chair-custom-b'],
      'C' => ['asset' => 'game_final_assets/teen_patti/custom_chairs/teen_patti_glacier_chair_c.webp', 'class' => 'chair-custom-art chair-custom-c'],
    ],
  ];
  $seatChairs = $teenPattiChairSets[(string) ($teenPattiVariant['chair_set'] ?? 'classic')] ?? $teenPattiChairSets['classic'];
  $seatChairAssetUrls = [];
  foreach (['A', 'B', 'C'] as $seatChairKey) {
    $seatChairAssetUrls[$seatChairKey] = asset($seatChairs[$seatChairKey]['asset'] ?? $teenPattiChairSets['classic'][$seatChairKey]['asset']);
  }
  $variantFx = [
    'blade_id' => $teenPattiVariant['blade_id'] ?? 'shared_index',
    'system_name' => $teenPattiVariant['system_name'] ?? 'classic_glass',
    'chip_arc_height' => (int) ($teenPattiVariant['chip_arc_height'] ?? 116),
    'payout_arc_height' => (int) ($teenPattiVariant['payout_arc_height'] ?? 156),
    'flip_lift' => (int) ($teenPattiVariant['flip_lift'] ?? 16),
    'flip_tilt' => (int) ($teenPattiVariant['flip_tilt'] ?? 12),
    'flip_in_duration' => (float) ($teenPattiVariant['flip_in_duration'] ?? 0.22),
    'flip_out_duration' => (float) ($teenPattiVariant['flip_out_duration'] ?? 0.40),
    'payout_chip_count' => (int) ($teenPattiVariant['payout_chip_count'] ?? 5),
  ];
  $teenPattiPopupLayoutBase = $teenPattiPopupArtByGame['teen_patti'] ?? $teenPattiPopupTheme;
  $variantStyleVars = [
    '--teen-glass-fill' => $teenPattiVariant['glass_fill'] ?? 'linear-gradient(145deg, rgba(20,18,48,.72), rgba(7,9,22,.88))',
    '--teen-glass-border' => $teenPattiVariant['glass_border'] ?? 'rgba(255,223,148,.28)',
    '--teen-glass-highlight' => $teenPattiVariant['glass_highlight'] ?? 'rgba(255,255,255,.18)',
    '--teen-glass-glow' => $teenPattiVariant['glass_glow'] ?? 'rgba(130,104,255,.18)',
    '--teen-board-glow' => $teenPattiVariant['board_glow'] ?? 'rgba(255,215,110,.18)',
    '--teen-coin-sand-color' => $teenPattiVariant['coin_sand_color'] ?? '#ffd76e',
    '--teen-coin-sand-soft' => $teenPattiVariant['coin_sand_soft'] ?? 'rgba(255,215,110,.24)',
    '--teen-timer-ring' => $teenPattiVariant['timer_ring'] ?? '#46e88a',
    '--teen-timer-glow' => $teenPattiVariant['timer_glow'] ?? 'rgba(70,232,138,.26)',
    '--teen-countdown-hand' => $teenPattiVariant['countdown_hand'] ?? '#fff5c8',
    '--teen-payout-glow' => $teenPattiVariant['payout_glow'] ?? 'rgba(255,215,110,.34)',
    '--teen-table-haze' => $teenPattiVariant['table_haze'] ?? 'radial-gradient(circle at 50% 14%, rgba(255,255,255,.12), transparent 30%), radial-gradient(circle at 52% 100%, rgba(126,94,255,.18), transparent 34%)',
    '--teen-popup-frame' => 'none',
    '--teen-popup-surface' => $teenPattiPopupTheme['surface'],
    '--teen-popup-title' => $teenPattiPopupTheme['title'],
    '--teen-popup-copy' => $teenPattiPopupTheme['copy'],
    '--teen-popup-copy-soft' => $teenPattiPopupTheme['copy_soft'],
    '--teen-popup-note-bg' => $teenPattiPopupTheme['note_bg'],
    '--teen-popup-note-border' => $teenPattiPopupTheme['note_border'],
    '--teen-popup-note-text' => $teenPattiPopupTheme['note_text'],
    '--teen-popup-accent' => $teenPattiPopupTheme['accent'],
    '--teen-popup-icon-bg' => $teenPattiPopupTheme['icon_bg'],
    '--teen-popup-icon-border' => $teenPattiPopupTheme['icon_border'],
    '--teen-popup-icon-color' => $teenPattiPopupTheme['icon_color'],
    '--teen-popup-shell-shadow' => $teenPattiPopupTheme['shell_shadow'],
    '--teen-popup-toggle-off' => $teenPattiPopupTheme['toggle_off'],
    '--teen-popup-toggle-on' => $teenPattiPopupTheme['toggle_on'],
    '--teen-popup-toggle-border' => $teenPattiPopupTheme['toggle_border'],
    '--teen-popup-title-font' => $teenPattiPopupTheme['title_font'],
    '--teen-popup-copy-font' => $teenPattiPopupTheme['copy_font'],
    '--teen-popup-kicker-font' => $teenPattiPopupTheme['kicker_font'],
    '--teen-popup-overlay' => $teenPattiPopupTheme['overlay'],
    '--teen-popup-close-bg' => $teenPattiPopupTheme['close_bg'],
    '--teen-popup-close-border' => $teenPattiPopupTheme['close_border'],
    '--teen-popup-close-text' => $teenPattiPopupTheme['close_text'],
    '--teen-popup-modal-width' => $teenPattiPopupLayoutBase['modal_width'],
    '--teen-popup-modal-min-height' => $teenPattiPopupLayoutBase['modal_min_height'],
    '--teen-popup-modal-pad-top' => $teenPattiPopupLayoutBase['modal_pad_top'],
    '--teen-popup-modal-pad-bottom' => $teenPattiPopupLayoutBase['modal_pad_bottom'],
    '--teen-popup-audio-width' => $teenPattiPopupLayoutBase['audio_width'],
    '--teen-popup-audio-min-height' => $teenPattiPopupLayoutBase['audio_min_height'],
    '--teen-popup-audio-pad-top' => $teenPattiPopupLayoutBase['audio_pad_top'],
    '--teen-popup-audio-pad-bottom' => $teenPattiPopupLayoutBase['audio_pad_bottom'],
    '--teen-popup-utility-width' => $teenPattiPopupLayoutBase['utility_width'],
    '--teen-popup-utility-min-height' => $teenPattiPopupLayoutBase['utility_min_height'],
    '--teen-popup-utility-pad-top' => $teenPattiPopupLayoutBase['utility_pad_top'],
    '--teen-popup-utility-pad-bottom' => $teenPattiPopupLayoutBase['utility_pad_bottom'],
  ];
  $variantInlineStyle = '';
  foreach ($variantStyleVars as $cssVar => $cssValue) {
    $variantInlineStyle .= $cssVar . ':' . $cssValue . ';';
  }
  $variantSystemClass = 'teen-system-' . preg_replace('/[^a-z0-9_-]+/i', '-', (string) ($teenPattiVariant['system_name'] ?? 'classic_glass'));
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover" />
  <meta name="theme-color" content="{{ $teenPattiVariant['theme_color'] }}" />
  <meta name="description" content="{{ $metaDescription }}" />
  <title>{{ $currentGameName }} · Premium Edition</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700;800;900&family=Cormorant+Garamond:wght@500;600;700&family=El+Messiri:wght@600;700&family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800;14..32,900&family=Marcellus&family=Orbitron:wght@600;700;800&family=Poppins:wght@400;500;600;700;800;900&family=Rajdhani:wght@600;700&family=Teko:wght@600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  @include('game_final.partials.premium_clock_styles')
  @include('game_final.partials.admin_visual_theme_styles')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <script>
    if (!window.gsap) {
      window.gsap = (function () {
        function toArray(target) {
          if (Array.isArray(target)) return target.filter(Boolean);
          if (target && typeof target.length === 'number' && !target.nodeType && typeof target !== 'string') {
            return Array.from(target).filter(Boolean);
          }
          return target ? [target] : [];
        }

        function applyVars(target, vars) {
          if (!target || !vars) return;

          if (vars.clearProps && target.style) {
            String(vars.clearProps).split(',').forEach(function (prop) {
              target.style[prop.trim()] = '';
            });
          }

          if (!target.style) return;

          if (vars.opacity !== undefined) target.style.opacity = vars.opacity;
          if (vars.boxShadow !== undefined) target.style.boxShadow = vars.boxShadow;
          if (vars.borderColor !== undefined) target.style.borderColor = vars.borderColor;
          if (vars.transformOrigin !== undefined) target.style.transformOrigin = vars.transformOrigin;

          var transforms = [];
          if (vars.x !== undefined) transforms.push('translateX(' + vars.x + (typeof vars.x === 'number' ? 'px' : '') + ')');
          if (vars.y !== undefined) transforms.push('translateY(' + vars.y + (typeof vars.y === 'number' ? 'px' : '') + ')');
          if (vars.scale !== undefined) transforms.push('scale(' + vars.scale + ')');
          if (vars.rotate !== undefined) transforms.push('rotate(' + vars.rotate + 'deg)');
          if (vars.rotateY !== undefined) transforms.push('rotateY(' + vars.rotateY + 'deg)');
          if (vars.rotateZ !== undefined) transforms.push('rotateZ(' + vars.rotateZ + 'deg)');
          if (transforms.length) target.style.transform = transforms.join(' ');
        }

        function finish(vars) {
          var totalMs = Math.max(0, (((vars && vars.delay) || 0) + ((vars && vars.duration) || 0)) * 1000);
          window.setTimeout(function () {
            if (vars && typeof vars.onComplete === 'function') vars.onComplete();
          }, totalMs);
        }

        function run(target, vars) {
          toArray(target).forEach(function (node) { applyVars(node, vars); });
          finish(vars || {});
          return { kill: function () {} };
        }

        return {
          to: function (target, vars) { return run(target, vars); },
          fromTo: function (target, fromVars, toVars) {
            toArray(target).forEach(function (node) { applyVars(node, fromVars); });
            return run(target, toVars);
          },
          set: function (target, vars) { return run(target, vars); },
          killTweensOf: function () {}
        };
      })();
    }
  </script>
  <style>
    :root{
      --bg:#0b0715;
      --gold:#ffd76e;
      --gold-dark:#b98a2f;
      --red-glow:#ff3366;
      --blue-glow:#33aaff;
      --green-glow:#46e88a;
      --border:rgba(255,255,255,.14);
      --card-shadow:0 20px 35px -10px rgba(0,0,0,.5);
      --glow-effect:0 0 20px rgba(255,215,110,.4);
      --top-bar-h:60px;
      --timer-band-h:94px;
      --chips-bar-h:60px;
      --board-band-h:178px;
      --card-w:58px;
      --card-h:92px;
    }
    *{box-sizing:border-box;-webkit-tap-highlight-color:transparent;margin:0;padding:0}
    html,body{margin:0;padding:0;width:100%;height:100%;overflow:hidden;background:#0a0518;touch-action:manipulation;-webkit-user-select:none;user-select:none;-webkit-touch-callout:none;overscroll-behavior:none}
    body{max-width:100vw;margin:0 auto;font-family:'Inter',system-ui,sans-serif;min-height:100dvh}
    .game-container{min-height:100dvh}
    @media (min-width: 768px){ body{background:#0a0518} .game-container{left:0;right:0;width:100vw;max-width:none;border-radius:0;box-shadow:none} }
    .game-container,.game-container *{ -webkit-user-select:none; user-select:none; -webkit-touch-callout:none;}\n    input,textarea,[contenteditable="true"]{-webkit-user-select:text;user-select:text;-webkit-touch-callout:default}\n    .board,.board *, .pot,.pot *, .chips-bar,.chips-bar *, .top-bar,.top-bar *{touch-action:manipulation}
    
    /* Loading Skeleton */
    .loading-skeleton{
      position:fixed;
      inset:0;
      background:radial-gradient(circle at 30% 20%, #201032 0%, #0a0518 48%, #05020c 100%);
      z-index:1000;
      display:flex;
      align-items:center;
      justify-content:center;
      flex-direction:column;
      gap:16px;
      transition:opacity .55s ease, visibility .55s ease;
      overflow:visible;
      padding-top:10px;
    }
    .loading-skeleton::before{content:'';position:absolute;inset:-20%;background:radial-gradient(circle at 50% 35%, rgba(255,215,110,.13), transparent 24%),radial-gradient(circle at 50% 65%, rgba(135,89,255,.14), transparent 28%);animation:splashBreath 3s ease-in-out infinite;pointer-events:none}
    .splash-logo{position:relative;z-index:2;padding:14px 22px;border-radius:999px;border:1px solid rgba(255,215,110,.4);background:linear-gradient(145deg, rgba(35,16,58,.72), rgba(9,5,18,.9));box-shadow:0 16px 32px rgba(0,0,0,.35),0 0 30px rgba(255,215,110,.12)}
    .splash-title{font:900 clamp(1.5rem,5vw,2.15rem)/1 'Poppins',sans-serif;letter-spacing:.08em;text-transform:uppercase;background:linear-gradient(135deg,#fff7d6,#ffd76e,#ffb653);-webkit-background-clip:text;background-clip:text;color:transparent;text-align:center}
    .splash-sub{font-size:.72rem;letter-spacing:.28em;text-transform:uppercase;color:rgba(255,238,191,.72);text-align:center;margin-top:6px}
    .skeleton-spinner{width:64px;height:64px;border:3px solid rgba(255,215,110,.15);border-top-color:#ffd76e;border-right-color:#9b74ff;border-radius:50%;animation:spin 1s linear infinite;box-shadow:0 0 22px rgba(255,215,110,.12)}
    .splash-progress-wrap{width:min(86vw,320px);position:relative;z-index:2}
    .splash-progress{height:10px;border-radius:999px;background:rgba(255,255,255,.08);overflow:hidden;border:1px solid rgba(255,215,110,.2)}
    .splash-progress-bar{height:100%;width:0%;background:linear-gradient(90deg,#8759ff,#ffd76e,#ffb653);box-shadow:0 0 18px rgba(255,215,110,.4);border-radius:inherit;transition:width .22s ease}
    .splash-percent{margin-top:10px;text-align:center;font-weight:800;color:#fff1bd;letter-spacing:.12em;font-size:.84rem}
    .splash-log{min-height:18px;text-align:center;color:rgba(255,255,255,.72);font-size:.72rem;letter-spacing:.08em;position:relative;z-index:2;padding:0 16px}
    .skeleton-text{width:200px;height:8px;background:linear-gradient(90deg, rgba(255,215,110,.1), rgba(255,215,110,.3), rgba(255,215,110,.1));background-size:200% 100%;animation:shimmer 1.5s infinite;border-radius:4px}
    @keyframes splashBreath{0%,100%{transform:scale(1);opacity:.85}50%{transform:scale(1.08);opacity:1}}
    @media (max-width: 390px){
      .loading-skeleton{padding:18px 14px 24px}
      .splash-logo{padding:12px 16px}
      .splash-title{font-size:1.3rem;letter-spacing:.05em}
      .splash-sub{font-size:.62rem;letter-spacing:.18em}
      .splash-progress-wrap{width:min(88vw,300px)}
      .splash-log{font-size:.68rem;padding:0 8px;min-height:32px}
      .splash-percent{font-size:.78rem}
    }
    @media (max-width: 430px), (max-height: 760px){
      .loading-skeleton{padding:max(16px, env(safe-area-inset-top)) 14px max(20px, env(safe-area-inset-bottom));gap:14px}
      .splash-logo{max-width:92vw}
      .splash-title{font-size:clamp(1.18rem,7vw,1.55rem)}
      .splash-sub{font-size:.6rem;letter-spacing:.14em}
      .splash-progress-wrap{width:min(92vw,290px)}
      .splash-log{font-size:.66rem;line-height:1.35;min-height:34px}
    }
    @media (max-height: 620px){
      .loading-skeleton{gap:10px}
      .skeleton-spinner{width:52px;height:52px}
      .splash-logo{padding:10px 14px}
      .splash-progress{height:8px}
      .splash-percent{margin-top:8px}
    }

    @keyframes spin{to{transform:rotate(360deg)}}
    @keyframes shimmer{0%{background-position:200% 0}100%{background-position:-200% 0}}
    
    .game-container{
      position:fixed;
      top:0;
      left:0;
      width:100%;
      height:100%;
      background:radial-gradient(circle at 30% 20%, #1a0f2a 0%, #0a0518 100%);
      display:flex;
      flex-direction:column;
      overflow:hidden;
      opacity:0;
      transition:opacity .5s;
    }
    .game-container::before{content:"";position:absolute;inset:0;pointer-events:none;background:
      radial-gradient(circle at 50% 18%, rgba(255,215,110,.08), transparent 22%),
      radial-gradient(circle at 50% 78%, rgba(114,72,255,.10), transparent 28%),
      linear-gradient(180deg, rgba(255,255,255,.02), transparent 30%, transparent 70%, rgba(255,215,110,.02));opacity:.9;z-index:0}
    .game-container.loaded{opacity:1}
    
    /* Top Bar */
    .top-bar{
      position:fixed;
      top:0;
      left:0;
      right:0;
      background:linear-gradient(135deg, rgba(0,0,0,.85), rgba(0,0,0,.95));
      backdrop-filter:blur(20px);
      padding:12px 16px;
      display:flex;
      align-items:center;
      justify-content:space-between;
      border-bottom:2px solid rgba(255,215,110,.5);
      z-index:100;
      min-height:var(--top-bar-h);
      box-shadow:0 4px 25px rgba(0,0,0,.4);
    }
    .coin-section{display:flex;align-items:center;justify-content:flex-start;gap:8px;min-width:clamp(138px,34vw,190px);background:linear-gradient(145deg, rgba(0,0,0,.6), rgba(20,10,30,.7));padding:6px 16px 6px 14px;border-radius:50px;border:1px solid rgba(255,215,110,.5);position:relative;backdrop-filter:blur(10px)}
    .coin-icon{flex:0 0 auto;font-size:20px;color:#ffd76e;filter:drop-shadow(0 0 8px gold);animation:coinGlow 2s ease-in-out infinite}
    @keyframes coinGlow{0%,100%{filter:drop-shadow(0 0 5px gold)}50%{filter:drop-shadow(0 0 15px gold)}}
    .coin-amount{display:inline-block;width:10.5ch;max-width:10.5ch;overflow:hidden;text-overflow:clip;text-align:right;font-variant-numeric:tabular-nums;white-space:nowrap;font-size:clamp(.86rem,2.7vw,1.2rem);font-weight:400;background:linear-gradient(135deg,#fff6d0,#ffd76e);-webkit-background-clip:text;background-clip:text;color:transparent;letter-spacing:0}
    .balance-section{overflow:visible;will-change:transform,box-shadow}
    .balance-impact{
      position:absolute;
      inset:-4px;
      border-radius:999px;
      pointer-events:none;
      opacity:0;
      background:radial-gradient(circle, rgba(255,255,255,.26) 0%, rgba(82,232,138,.20) 28%, rgba(82,232,138,0) 68%);
      transform:scale(.7);
      z-index:0;
    }
    .balance-impact.ripple{
      animation:balanceRipple .72s cubic-bezier(.12,.7,.15,1);
    }
    .balance-droplet{
      position:absolute;
      top:50%;
      left:50%;
      width:12px;
      height:12px;
      border-radius:50%;
      transform:translate(-50%,-50%);
      pointer-events:none;
      background:radial-gradient(circle at 35% 30%, #ffffff 0%, #b8ffe0 35%, #3bd97b 100%);
      box-shadow:0 0 16px rgba(70,232,138,.75);
      opacity:0;
      z-index:3;
    }
    .balance-droplet.drop{
      animation:balanceDrop .58s ease-out;
    }
    .payout-fly-amount{
      position:fixed;
      z-index:1200;
      pointer-events:none;
      font:900 1.05rem/1 'Poppins',sans-serif;
      color:#fff2b3;
      text-shadow:0 0 10px rgba(255,215,110,.85), 0 0 22px rgba(255,140,45,.45);
      white-space:nowrap;
        transform:translate(-50%, -50%);
    }
    .payout-chip-ghost{
      position:fixed;
      width:24px;
      height:24px;
      border-radius:50%;
      pointer-events:none;
      z-index:1190;
      box-shadow:0 0 16px rgba(255,215,110,.35);
      overflow:visible;
      padding-top:10px;
      transform:translate(-50%, -50%);
    }
    .card.card-flipping{transform-style:preserve-3d;filter:drop-shadow(0 18px 28px rgba(0,0,0,.24)) drop-shadow(0 0 18px var(--teen-payout-glow));}
    @keyframes balanceRipple{
      0%{opacity:0;transform:scale(.7)}
      18%{opacity:.95;transform:scale(1)}
      100%{opacity:0;transform:scale(1.45)}
    }
    @keyframes balanceDrop{
      0%{opacity:0;transform:translate(-50%,-150%) scale(.2)}
      45%{opacity:1;transform:translate(-50%,-50%) scale(1)}
      100%{opacity:0;transform:translate(-50%,15%) scale(1.1)}
    }
    .balance-watermark{
      position:absolute;
      top:100%;
      left:50%;
      transform:translateX(-50%);
      margin-top:6px;
      font-size:10px;
      font-weight:400;
      color:rgba(255,215,110,.10);
      font-family:monospace;
      background:rgba(0,0,0,.5);
      padding:2px 10px;
      border-radius:20px;
      white-space:nowrap;
      backdrop-filter:blur(4px);
      pointer-events:none;
    }
    .user-section{display:flex;align-items:center;gap:8px;background:linear-gradient(145deg, rgba(0,0,0,.6), rgba(20,10,30,.7));padding:6px 18px;border-radius:50px;border:1px solid rgba(255,215,110,.4)}
    .user-icon{font-size:18px;color:#b8a9ff}
    .user-name{display:inline-block;font-size:.9rem;font-weight:600;color:#f3e2ff;max-width:108px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;transform-origin:50% 0%;font-variant-numeric:tabular-nums}
    .user-name.flip-out{animation:teenIdentityOut .26s ease forwards}
    .user-name.flip-in{animation:teenIdentityIn .34s ease forwards}
    .icon-buttons{display:flex;gap:8px}
    .icon-btn{width:40px;height:40px;border-radius:50%;background:linear-gradient(145deg, rgba(255,215,110,.2), rgba(0,0,0,.5));border:1px solid rgba(255,215,110,.5);display:grid;place-items:center;color:#ffd76e;cursor:pointer;transition:all .2s}
    .icon-btn:active{transform:scale(.92)}
    
    .game-content{
      position:fixed;
      inset:0;
      overflow:hidden;
      pointer-events:none;
    }
    .shell{
      position:relative;
      width:100%;
      height:100%;
      display:block;
      padding:0;
    }
    .top-stack{
      position:fixed;
      left:0;
      right:0;
      top:calc(var(--top-bar-h) - 2px);
      z-index:88;
      display:flex;
      flex-direction:column;
      align-items:center;
      justify-content:flex-start;
      pointer-events:none;
      padding:2px 10px 0;
      gap:6px;
    }
    .status-strip{display:flex;gap:8px;align-items:center;justify-content:center;pointer-events:none;flex-wrap:wrap}
    .status-pill{padding:6px 12px;border-radius:999px;background:linear-gradient(145deg, rgba(10,8,22,.92), rgba(32,18,58,.88));border:1px solid rgba(255,215,110,.28);backdrop-filter:blur(10px);color:#f7e7af;font:800 .64rem/1 'Poppins',sans-serif;letter-spacing:.12em;text-transform:uppercase;box-shadow:0 8px 18px rgba(0,0,0,.24);display:flex;align-items:center;gap:6px}
    .status-pill b{color:#8ef0ff;font-weight:900;margin-left:4px}
    .status-pill strong{color:#ffffff;font-weight:900;margin-left:4px}
    .status-pill i{font-size:.78rem}
    .net-pill{min-width:120px;justify-content:center;transition:border-color .22s ease, box-shadow .22s ease, color .22s ease}
    .net-pill b,.status-pill strong{display:inline-block;text-align:right;font-variant-numeric:tabular-nums}
    .net-pill b{width:48px}
    .status-pill strong{min-width:28px}
    @keyframes teenIdentityOut{0%{opacity:1;transform:translateY(0) rotateX(0deg)}100%{opacity:0;transform:translateY(10px) rotateX(-90deg)}}
    @keyframes teenIdentityIn{0%{opacity:0;transform:translateY(-10px) rotateX(90deg)}100%{opacity:1;transform:translateY(0) rotateX(0deg)}}
    .net-pill .net-icon{width:18px;height:18px;border-radius:50%;display:grid;place-items:center;background:rgba(255,255,255,.08);font-size:.6rem;box-shadow:0 0 0 1px rgba(255,255,255,.06) inset}
    .net-pill.good{border-color:rgba(70,232,138,.55);box-shadow:0 8px 18px rgba(0,0,0,.24),0 0 18px rgba(70,232,138,.16)}
    .net-pill.good .net-icon{color:#7dffba;background:rgba(70,232,138,.14)}
    .net-pill.warn{border-color:rgba(255,210,79,.62);box-shadow:0 8px 18px rgba(0,0,0,.24),0 0 18px rgba(255,210,79,.16)}
    .net-pill.warn .net-icon{color:#ffe27a;background:rgba(255,210,79,.14)}
    .net-pill.bad{border-color:rgba(255,111,127,.68);box-shadow:0 8px 18px rgba(0,0,0,.24),0 0 18px rgba(255,111,127,.18)}
    .net-pill.bad .net-icon{color:#ff8ea4;background:rgba(255,111,127,.14)}
    .bottom-stack{
      position:fixed;
      left:0;
      right:0;
      bottom:calc(var(--chips-bar-h) + 2px);
      z-index:87;
      display:flex;
      flex-direction:column;
      gap:2px;
      padding:0 10px;
      pointer-events:none;
    }
    .middle-fill{
      position:fixed;
      inset:0;
      background:transparent;
    }
    
    /* Timer with Gradient */
    .timer-wrap{display:flex;justify-content:center;margin:0 auto;pointer-events:auto;position:relative}
    .timer-wrap::after{content:'';position:absolute;inset:14px;border-radius:999px;pointer-events:none;opacity:0;transform:scale(.72);}
    .timer-wrap.round-go::after{opacity:.68;background:radial-gradient(circle, rgba(255,215,110,.11) 0%, rgba(255,215,110,.06) 30%, rgba(255,215,110,0) 62%);animation:roundGoPulse .9s ease-in-out infinite;}
    .timer-wrap.round-live::after{opacity:.72;border:1px solid rgba(255,255,255,.06);box-shadow:0 0 0 0 rgba(88,255,174,.22), 0 0 18px rgba(128,92,255,.10) inset;animation:roundLivePulse 1.3s ease-in-out infinite;}
    @keyframes roundGoPulse{0%{transform:scale(.84);filter:blur(2px)}50%{transform:scale(1);filter:blur(0)}100%{transform:scale(.84);filter:blur(2px)}}
    @keyframes roundLivePulse{0%{transform:scale(.88);box-shadow:0 0 0 0 rgba(88,255,174,.30), 0 0 20px rgba(128,92,255,.08) inset}55%{transform:scale(1.03);box-shadow:0 0 0 10px rgba(88,255,174,0), 0 0 26px rgba(255,215,110,.12) inset}100%{transform:scale(.88);box-shadow:0 0 0 0 rgba(88,255,174,0), 0 0 20px rgba(128,92,255,.08) inset}}
    .timer-orb{width:104px;height:104px;position:relative;transition:all .3s}
    .timer-bg,.timer-progress,.timer-inner{position:absolute;inset:0;border-radius:50%}
    .timer-bg{background:radial-gradient(circle at 30% 30%, rgba(255,255,255,.08), rgba(0,0,0,.46));border:1.5px solid rgba(255,255,255,.14)}
    .timer-progress{background:conic-gradient(var(--timer-color, #46e88a) calc(var(--p,1) * 360deg), rgba(255,255,255,.08) 0);mask:radial-gradient(circle, transparent 58%, #000 60%)}
    .timer-inner{inset:14px;background:radial-gradient(circle at 30% 30%, rgba(255,255,255,.18), rgba(10,5,20,.96));display:flex;align-items:center;justify-content:center;flex-direction:column}
    .timer-value{font:800 2.8rem/1 monospace;background:linear-gradient(135deg,#fff,#ffd76e);-webkit-background-clip:text;background-clip:text;color:transparent;text-shadow:none;transition:transform .22s ease,letter-spacing .22s ease,opacity .22s ease}
    .timer-value.phase-text{font-size:1.46rem;letter-spacing:.16em;font-family:'Poppins',sans-serif;text-transform:uppercase;background:linear-gradient(135deg,#fff7d6,#ffe28e,#ffb85a)}
    .timer-value.phase-soft{font-size:1.9rem;letter-spacing:.32em;font-family:'Poppins',sans-serif;background:linear-gradient(135deg,#fff,#d9c1ff,#ffd76e)}
    .timer-sub{font-size:.7rem;letter-spacing:2px;opacity:.8;color:#fff}
    .timer-orb.disabled{opacity:0.5;filter:grayscale(0.3)}
    .timer-orb.pulse-active{animation:timerPulse 1s ease-in-out infinite}
    .timer-wrap.sticky-timer{position:relative;top:auto;z-index:auto;padding:0;background:none;backdrop-filter:none}
    .timer-orb.hidden-phase{opacity:0;transform:scale(.86);pointer-events:none;filter:none !important}
    .timer-wrap.timer-hidden{display:none !important;visibility:hidden}
    .timer-orb.win-glow{animation:timerWinGlow 1.1s ease-in-out infinite;filter:drop-shadow(0 0 18px rgba(255,215,110,.85)) drop-shadow(0 0 30px rgba(255,255,255,.35))}
    @keyframes timerPulse{0%,100%{transform:scale(1)}50%{transform:scale(1.02)}}
    @keyframes timerWinGlow{0%,100%{transform:scale(1);filter:drop-shadow(0 0 12px rgba(255,215,110,.7))}50%{transform:scale(1.07);filter:drop-shadow(0 0 22px rgba(255,215,110,1)) drop-shadow(0 0 36px rgba(255,255,255,.35))}}
    
    /* Pots */
    .pots{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;width:100%;align-items:end;pointer-events:none}
    .pot{position:relative;display:flex;flex-direction:column;align-items:center;justify-content:flex-end;border-radius:28px;padding:6px 4px 0;background:transparent !important;transition:all .3s;min-height:158px}
    .chair{width:72px;margin-bottom:-16px;z-index:3;filter:drop-shadow(0 5px 10px rgba(0,0,0,.22));background:transparent;transition:filter .25s ease, transform .25s ease;transform:translateZ(0);backface-visibility:hidden;image-rendering:-webkit-optimize-contrast;object-fit:contain}
    .cards{height:102px;display:flex;align-items:flex-end;justify-content:center;position:relative;z-index:4;gap:0}
    .card{width:var(--card-w);height:var(--card-h);border-radius:13px;margin-left:-13px;position:relative;box-shadow:0 18px 32px rgba(0,0,0,.36), inset 0 1px 0 rgba(255,255,255,.08);transition:all .3s;backface-visibility:hidden;overflow:hidden}
    .card:first-child{margin-left:0}
    .pot .cards .card:nth-child(1){transform:translateX(13px);z-index:3}
    .pot .cards .card:nth-child(2){transform:translateX(0);z-index:2}
    .pot .cards .card:nth-child(3){transform:translateX(-13px);z-index:1}
    .card.back{background:radial-gradient(circle at 20% 18%, rgba(255,255,255,.18), transparent 22%),linear-gradient(160deg, #41225c 0%, #1a0f2f 42%, #0b0715 100%);border:1.8px solid rgba(255,215,110,.62)}
    .card.back::before{content:"";position:absolute;inset:5px;border-radius:9px;background:radial-gradient(circle at 50% 50%, rgba(255,215,110,.16), transparent 46%),repeating-linear-gradient(45deg, rgba(255,215,110,.24) 0 4px, rgba(109,61,20,.18) 4px 8px);border:1px solid rgba(255,228,159,.22)}
    .card.back::after{content:'♠';position:absolute;inset:0;display:grid;place-items:center;font:900 1.05rem/1 'Poppins',sans-serif;color:rgba(255,226,157,.78);text-shadow:0 0 12px rgba(255,215,110,.28)}
    .card.front{background:radial-gradient(circle at 50% 0%, rgba(255,255,255,1) 0%, rgba(255,255,255,.82) 36%, rgba(255,255,255,0) 58%),linear-gradient(180deg,#ffffff 0%,#fffefb 54%,#faf6ed 100%);border:1.8px solid rgba(224,196,126,.94);display:flex;align-items:center;justify-content:center;color:#111;box-shadow:0 16px 30px rgba(0,0,0,.30), inset 0 1px 0 rgba(255,255,255,.96), inset 0 -8px 14px rgba(190,147,56,.10);isolation:isolate}
    .card.front::before{content:'';position:absolute;inset:4px;border-radius:9px;border:1px solid rgba(141,108,54,.10);background:radial-gradient(circle at 50% 44%, rgba(255,255,255,.66), rgba(255,255,255,0) 54%),linear-gradient(180deg,rgba(255,255,255,.78),rgba(255,255,255,.10) 28%,rgba(245,239,225,.28) 76%,rgba(124,96,46,.05));pointer-events:none}
    .card.front::after{content:'';position:absolute;left:-18%;top:-18%;width:56%;height:142%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.18),transparent);transform:rotate(18deg);opacity:.18;pointer-events:none}
    .card-corner{position:absolute;display:flex;flex-direction:column;align-items:center;line-height:.88;gap:0;z-index:3}
    .card-corner.top-left{top:5px;left:6px}
    .card-corner.bottom-right{right:6px;bottom:5px;transform:rotate(180deg)}
    .rank{font-size:.88rem;font-weight:900;letter-spacing:-.01em;text-shadow:none}
    .suit{font-size:.78rem;line-height:.94;text-shadow:none}
    .rank.red,.suit.red,.center.red{color:#cb234e}
    .rank.black,.suit.black,.center.black{color:#15131c}
    .center{position:relative;font-size:1.08rem;font-weight:900;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:0;z-index:2;line-height:1;text-shadow:none}
    .center small{display:none}
    @media (max-width: 430px){:root{--card-w:55px;--card-h:88px}.cards{height:94px}.pot{min-height:150px}}
    .hand-label{position:absolute;top:auto;bottom:-10px;left:50%;transform:translateX(-50%);padding:4px 10px;border-radius:999px;background:linear-gradient(135deg, rgba(14,10,24,.98), rgba(46,22,72,.96));border:1px solid rgba(255,215,110,.78);font-size:.54rem;font-weight:900;white-space:nowrap;z-index:8;color:#fff7d2;opacity:0;backdrop-filter:blur(6px);box-shadow:0 8px 16px rgba(0,0,0,.22),0 0 14px rgba(255,215,110,.10);max-width:94%;overflow:hidden;text-overflow:ellipsis}
    .hand-label::before{content:'';position:absolute;inset:1px;border-radius:inherit;background:linear-gradient(180deg, rgba(255,255,255,.10), rgba(255,255,255,0) 46%, rgba(255,187,80,.10));pointer-events:none}
    .hand-label > *,.hand-label{isolation:isolate}
    .hand-label.badge-pair{border-color:rgba(255,126,158,.88);color:#fff3f6;box-shadow:0 10px 20px rgba(0,0,0,.28),0 0 20px rgba(255,92,132,.20)}
    .hand-label.badge-sequence,.hand-label.badge-seq{border-color:rgba(122,248,212,.86);color:#effff8;box-shadow:0 10px 20px rgba(0,0,0,.28),0 0 20px rgba(70,232,138,.20)}
    .hand-label.badge-flush{border-color:rgba(106,184,255,.88);color:#eef7ff;box-shadow:0 10px 20px rgba(0,0,0,.28),0 0 20px rgba(85,153,255,.20)}
    .hand-label.badge-trail,.hand-label.badge-pure{border-color:rgba(255,215,110,.94);color:#fff8da;box-shadow:0 10px 20px rgba(0,0,0,.28),0 0 22px rgba(255,215,110,.26)}
    .pot-title{font-size:1.25rem;font-weight:900;margin-top:4px;text-shadow:0 0 16px currentColor;letter-spacing:1px;line-height:1}
    .pot[data-board="A"] .pot-title{color:#ff5577;text-shadow:0 0 20px #ff3366}
    .pot[data-board="B"] .pot-title{color:#5599ff;text-shadow:0 0 20px #3388ff}
    .pot[data-board="C"] .pot-title{color:#55ff88;text-shadow:0 0 20px #33ff66}
    .winner-spotlight{position:absolute;inset:0;border-radius:28px;opacity:0;pointer-events:none;z-index:10;background:radial-gradient(circle, rgba(255,215,110,.3) 0%, transparent 70%)}
    
    /* Boards with 3D effect */
    .boards{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;width:100%;margin-top:0;pointer-events:auto}
    .boards.sticky-boards{position:relative;bottom:auto;z-index:auto;padding:0;background:none;backdrop-filter:none}
    .pot.win-head-glow .hand-label{opacity:1 !important;animation:cardHeadWinGlow .9s ease-in-out infinite;color:#fff6c9;box-shadow:0 0 18px rgba(255,215,110,.65), 0 0 34px rgba(255,170,50,.35),0 12px 24px rgba(0,0,0,.26)}
    .pot.win-head-glow .cards{filter:drop-shadow(0 0 16px rgba(255,215,110,.65))}
    .pot.win-head-glow .chair{filter:drop-shadow(0 0 10px rgba(255,215,110,.35)) drop-shadow(0 6px 10px rgba(0,0,0,.22));}
    @keyframes cardHeadWinGlow{0%,100%{transform:translateX(-50%) scale(1);box-shadow:0 0 10px rgba(255,215,110,.40)}50%{transform:translateX(-50%) scale(1.06);box-shadow:0 0 18px rgba(255,215,110,.85),0 0 28px rgba(255,255,255,.22)}}
    .board{backdrop-filter:blur(8px);border-radius:20px;padding:12px 6px 10px;display:flex;flex-direction:column;justify-content:space-between;align-items:center;cursor:pointer;transition:all .2s;min-height:96px;position:relative;overflow:hidden;box-shadow:0 8px 20px rgba(0,0,0,.2)}
    .board{backdrop-filter:blur(14px) saturate(130%);-webkit-backdrop-filter:blur(14px) saturate(130%);box-shadow:0 14px 28px rgba(0,0,0,.26),inset 0 1px 0 rgba(255,255,255,.14),inset 0 -12px 20px rgba(0,0,0,.12)}
    .board[data-board="A"]{background:linear-gradient(145deg, rgba(255,80,100,.3), rgba(200,40,60,.4));border:1px solid rgba(255,100,120,.6)}
    .board[data-board="B"]{background:linear-gradient(145deg, rgba(80,120,255,.3), rgba(50,80,200,.4));border:1px solid rgba(100,150,255,.6)}
    .board[data-board="C"]{background:linear-gradient(145deg, rgba(80,255,120,.3), rgba(50,200,80,.4));border:1px solid rgba(100,255,140,.6)}
    .board.touchable{transform:scale(1.02);border-width:2px;cursor:pointer;box-shadow:0 0 25px rgba(255,215,110,.3)}
    .board.touchable:active{transform:scale(.98)}
    .board.winner{animation:winnerGlow 0.6s ease-in-out infinite;box-shadow:0 0 40px currentColor}
    @keyframes winnerGlow{0%,100%{border-color:currentColor;box-shadow:0 0 25px currentColor}50%{border-color:#fff;box-shadow:0 0 50px currentColor}}
    .board.loser{opacity:.25;filter:grayscale(.7)}
    .board-amount{font-size:1.2rem;font-weight:400;background:linear-gradient(135deg,#fff6d0,#ffd76e);-webkit-background-clip:text;background-clip:text;color:transparent;line-height:1;pointer-events:none}
    .board-mini{font-size:.52rem;opacity:.52;color:#fff;letter-spacing:.8px;line-height:1;pointer-events:none}
    .won-amount{font-size:1rem;font-weight:400;color:#a7ffcb;line-height:1;pointer-events:none}
    .board-amount,
    .won-amount,
    .flying-win,
    .board-badge-plus{
      font-family:'Inter','Segoe UI',Arial,sans-serif !important;
      font-variant-numeric:tabular-nums;
      letter-spacing:0 !important;
      text-transform:none !important;
    }
    .flying-win{position:absolute;right:8px;bottom:8px;font-size:1rem;font-weight:900;color:#ffe08f;opacity:0;z-index:30}
    .board-badge-plus{position:absolute;top:6px;right:8px;padding:3px 8px;border-radius:30px;font-size:.65rem;background:rgba(255,215,110,.3);color:#ffd76e;opacity:0}
    
    /* Chips with 3D effect */
    .chips-bar{
      position:fixed;
      bottom:0;
      left:0;
      right:0;
      background:linear-gradient(180deg, rgba(0,0,0,.92), rgba(0,0,0,.98));
      backdrop-filter:blur(20px);
      border-top:1px solid rgba(255,215,110,.6);
      padding:8px 10px max(8px, env(safe-area-inset-bottom));
      z-index:100;
      min-height:var(--chips-bar-h);
      display:flex;
      align-items:center;
      justify-content:center;
      gap:8px;
    }
    .chip{width:56px;height:56px;display:grid;place-items:center;cursor:pointer;pointer-events:none;opacity:.4;filter:grayscale(.6);border:none;background:transparent;transition:transform .2s,opacity .2s,filter .2s;transform-style:preserve-3d;position:relative;isolation:isolate}
    .chip-face{width:52px;height:52px;display:block;filter:drop-shadow(0 8px 14px rgba(0,0,0,.48));transition:transform .2s,filter .2s}
    .chip-face svg{width:100%;height:100%;display:block;overflow:visible}
    .chip-label{position:relative;z-index:1;width:calc(100% - 4px);height:calc(100% - 4px);border-radius:50%;display:grid;place-items:center;font:900 clamp(.44rem,2.1vw,.72rem)/1 'Poppins',sans-serif;letter-spacing:0;color:#fff8dc;text-shadow:0 1px 2px rgba(0,0,0,.48);background:radial-gradient(circle at 32% 24%, rgba(255,255,255,.95), var(--chip-a,#ffe27a) 24%, var(--chip-b,#d28b12) 100%);border:2px solid rgba(255,240,190,.95);box-shadow:0 8px 14px rgba(0,0,0,.48), inset 0 0 0 2px rgba(255,255,255,.18)}
    .chip[data-value="1000"]{--chip-a:#5fa8ff;--chip-b:#214ed1}
    .chip[data-value="5000"]{--chip-a:#7dc6ff;--chip-b:#2b7fe4}
    .chip[data-value="10000"]{--chip-a:#6cffc6;--chip-b:#149460}
    .chip[data-value="50000"]{--chip-a:#c28cff;--chip-b:#6f34db}
    .chip[data-value="100000"]{--chip-a:#ffe27a;--chip-b:#d28b12}
    .chip.live{pointer-events:auto;opacity:1;filter:none}
    .chip.live:active{transform:translateY(-3px) scale(1.02)}
    .chip.selected{transform:translateY(-8px) scale(1.1)}
    .chip.selected .chip-face{filter:drop-shadow(0 0 20px rgba(255,215,110,.8)) drop-shadow(0 10px 16px rgba(0,0,0,.48));transform:translateY(-2px)}
    .chip.recent-hit .chip-face{filter:drop-shadow(0 0 24px rgba(255,255,255,.22)) drop-shadow(0 0 14px rgba(255,215,110,.36)) drop-shadow(0 10px 16px rgba(0,0,0,.42))}
    .chip::before{content:"";position:absolute;inset:2px;border-radius:50%;border:2px solid rgba(255,215,110,0);box-shadow:0 0 0 rgba(255,215,110,0);opacity:0;pointer-events:none;z-index:0}
    .chip::after{content:"";position:absolute;inset:7px;border-radius:50%;background:radial-gradient(circle at 35% 30%, rgba(255,255,255,.42), transparent 34%);pointer-events:none;mix-blend-mode:screen;opacity:.82}
    .chip.selected::before{opacity:1;border-color:rgba(255,230,148,.85);box-shadow:0 0 0 1px rgba(255,255,255,.28) inset,0 0 16px rgba(255,215,110,.42);animation:chipRingBlink .95s ease-in-out infinite}
    .chip.focus-chip .chip-face{filter:drop-shadow(0 0 14px rgba(255,215,110,.26)) drop-shadow(0 10px 16px rgba(0,0,0,.48))}
    @keyframes chipRingBlink{0%,100%{transform:scale(.92);opacity:.68}50%{transform:scale(1.12);opacity:1}}
    .chip-select-hud{display:none !important;position:fixed;left:14px;top:220px;transform:none;z-index:118;padding:8px 14px 8px 10px;border-radius:999px;background:linear-gradient(145deg, rgba(12,8,24,.94), rgba(49,22,72,.92));border:1px solid rgba(255,215,110,.34);box-shadow:0 14px 28px rgba(0,0,0,.34),0 0 24px rgba(255,215,110,.15);align-items:center;gap:10px;pointer-events:none;backdrop-filter:blur(14px);max-width:calc(100vw - 28px);transition:top .22s ease,left .22s ease,opacity .2s ease}
    .chip-select-hud::before{content:'';position:absolute;inset:-1px;border-radius:inherit;background:linear-gradient(135deg, rgba(255,255,255,.14), rgba(255,255,255,0) 30%, rgba(255,215,110,.12) 60%, rgba(125,210,255,.12));z-index:-1;opacity:.9}
    .chip-select-hud.fast-mode{border-color:rgba(120,210,255,.6);box-shadow:0 12px 26px rgba(0,0,0,.32),0 0 22px rgba(120,210,255,.2)}
    .chip-select-mini{width:30px;height:30px;border-radius:50%;display:grid;place-items:center;flex:0 0 auto;filter:drop-shadow(0 6px 12px rgba(0,0,0,.35))}
    .chip-select-mini svg{width:100%;height:100%;display:block}
    .chip-select-copy{display:flex;flex-direction:column;line-height:1}
    .chip-select-copy b{font-size:.62rem;letter-spacing:.22em;text-transform:uppercase;color:rgba(255,232,191,.72);font-weight:800}
    .chip-select-copy span{margin-top:4px;font-size:.92rem;font-weight:900;color:#fff2bf;text-shadow:0 0 14px rgba(255,215,110,.18)}
    .chips-bar.locked .chip,.chips-bar.locked .tool-btn{opacity:.42;filter:saturate(.72) grayscale(.22)}
    .tool-btn{width:52px;height:52px;border-radius:50%;background:linear-gradient(145deg, rgba(100,80,200,.95), rgba(60,40,140,.98));border:2px solid rgba(100,200,255,.8);color:#aaffff;cursor:pointer;display:grid;place-items:center;font-size:1.3rem}
    .fast-bid-btn{width:52px;height:52px;border-radius:18px;border:2px solid rgba(255,215,110,.35);background:linear-gradient(145deg, rgba(20,14,34,.96), rgba(44,24,72,.98));color:#ffeab0;font:900 .92rem/1 'Poppins',sans-serif;letter-spacing:.06em;display:grid;place-items:center;position:relative;box-shadow:0 10px 18px rgba(0,0,0,.28)}
    .fast-bid-btn.live{pointer-events:auto;opacity:1}
    .fast-bid-btn.active{border-color:rgba(120,210,255,.82);color:#c7f6ff;box-shadow:0 0 0 1px rgba(120,210,255,.24),0 0 24px rgba(120,210,255,.28)}
    .auto-bid-btn.active{border-color:rgba(130,255,196,.82);color:#d5ffe7;box-shadow:0 0 0 1px rgba(130,255,196,.24),0 0 24px rgba(130,255,196,.24)}
    .fast-bid-btn small,.auto-bid-btn small{display:block;font-size:.54rem;letter-spacing:.12em;opacity:.82}
    .fast-bid-btn .x2-mark,.auto-bid-btn .x2-mark{display:block;font:900 .86rem/1 'Poppins',sans-serif;letter-spacing:.04em}
    

    /* V26 Next Step: premium chips + seat identity + low-end safety */
    .chips-bar{
      background:
        linear-gradient(180deg, rgba(7,5,16,.90), rgba(8,6,18,.98)),
        radial-gradient(circle at 50% 0%, rgba(255,215,110,.12), transparent 46%);
      border-top:1px solid rgba(255,215,110,.48);
      box-shadow:0 -10px 28px rgba(0,0,0,.34), inset 0 1px 0 rgba(255,255,255,.05);
    }
    .chips-bar::before{
      content:'';
      position:absolute;
      left:10px; right:10px; top:6px; height:1px;
      background:linear-gradient(90deg, transparent, rgba(255,215,110,.36), rgba(122,210,255,.22), transparent);
      pointer-events:none;
      opacity:.9;
    }
    .chip{
      width:58px;height:58px;
      transform-origin:center bottom;
    }
    .chip-face{width:54px;height:54px}
    .chip.selected{
      transform:translateY(-9px) scale(1.12);
    }
    .chip.selected::before{
      animation:chipRingBlink .82s ease-in-out infinite;
      box-shadow:0 0 0 1px rgba(255,255,255,.30) inset,0 0 18px rgba(255,215,110,.46),0 0 28px rgba(122,210,255,.18);
    }
    .chip.live:hover .chip-face,
    .chip.live:active .chip-face{
      filter:drop-shadow(0 0 18px rgba(255,215,110,.28)) drop-shadow(0 10px 16px rgba(0,0,0,.48));
    }
    .tool-btn,.fast-bid-btn,.auto-bid-btn{
      box-shadow:0 10px 18px rgba(0,0,0,.28), inset 0 1px 0 rgba(255,255,255,.10);
    }
    .pot{overflow:visible}
    .pot::before{
      content:'';
      position:absolute;
      inset:-6px;
      border-radius:30px;
      pointer-events:none;
      opacity:.82;
      border:1px solid transparent;
      z-index:0;
    }
    .pot[data-board="A"]::before{
      border-color:rgba(255,90,120,.24);
      box-shadow:0 0 0 1px rgba(255,90,120,.10) inset,0 0 28px rgba(255,51,102,.12);
      background:radial-gradient(circle at 50% 10%, rgba(255,101,140,.08), transparent 46%);
    }
    .pot[data-board="B"]::before{
      border-color:rgba(95,160,255,.24);
      box-shadow:0 0 0 1px rgba(95,160,255,.10) inset,0 0 28px rgba(51,136,255,.12);
      background:radial-gradient(circle at 50% 10%, rgba(95,160,255,.08), transparent 46%);
    }
    .pot[data-board="C"]::before{
      border-color:rgba(95,255,160,.24);
      box-shadow:0 0 0 1px rgba(95,255,160,.10) inset,0 0 28px rgba(51,255,102,.10);
      background:radial-gradient(circle at 50% 10%, rgba(95,255,160,.08), transparent 46%);
    }
    .pot-title{
      position:relative;
      padding-inline:8px;
    }
    .pot-title::before{
      content:attr(data-seat-prefix);
      position:absolute;
      left:50%;
      bottom:100%;
      transform:translateX(-50%);
      margin-bottom:2px;
      font-size:.44rem;
      letter-spacing:.22em;
      color:rgba(255,244,216,.55);
      text-shadow:none;
    }
    .pot[data-board="A"] .chair{filter:drop-shadow(0 10px 16px rgba(255,51,102,.20)) drop-shadow(0 4px 8px rgba(0,0,0,.24))}
    .pot[data-board="B"] .chair{filter:drop-shadow(0 10px 16px rgba(51,136,255,.18)) drop-shadow(0 4px 8px rgba(0,0,0,.24))}
    .pot[data-board="C"] .chair{filter:drop-shadow(0 10px 16px rgba(51,255,102,.16)) drop-shadow(0 4px 8px rgba(0,0,0,.24))}
    body.low-end-mode *{
      scroll-behavior:auto !important;
    }
    body.low-end-mode .loading-skeleton::before,
    body.low-end-mode .winner-spotlight,
    body.low-end-mode .pot-aura,
    body.low-end-mode .timer-runes,
    body.low-end-mode .timer-spark,
    body.low-end-mode .board-energy,
    body.low-end-mode .mega-celebration{
      display:none !important;
    }
    body.low-end-mode .top-bar,
    body.low-end-mode .chips-bar,
    body.low-end-mode .toast-notification,
    body.low-end-mode .message-banner,
    body.low-end-mode .modal-card{
      backdrop-filter:none !important;
    }
    body.low-end-mode .chip-face,
    body.low-end-mode .chair,
    body.low-end-mode .cards,
    body.low-end-mode .board,
    body.low-end-mode .timer-orb{
      filter:none !important;
      box-shadow:none !important;
    }
    body.low-end-mode .chip,
    body.low-end-mode .board,
    body.low-end-mode .modal-card,
    body.low-end-mode .timer-orb,
    body.low-end-mode .pot-title,
    body.low-end-mode .hand-label{
      animation:none !important;
      transition-duration:.14s !important;
    }
    body.low-end-mode .status-pill::after{
      content:'LOW';
      margin-left:6px;
      font-size:.52rem;
      letter-spacing:.16em;
      color:rgba(255,228,170,.72);
    }
    @media (max-height: 560px){
      .chip{width:54px;height:54px}
      .chip-face{width:50px;height:50px}
      .tool-btn,.fast-bid-btn,.auto-bid-btn{width:48px;height:48px}
      .pot-title::before{font-size:.40rem}
    }

    /* Toast Notifications */
    .toast-notification{
      position:fixed;
      top:280px;
      left:50%;
      transform:translateX(-50%) translateY(20px);
      background:linear-gradient(135deg, rgba(10,6,22,.96), rgba(37,20,61,.98));
      backdrop-filter:blur(20px);
      border:1px solid rgba(255,215,110,.5);
      border-radius:28px;
      padding:11px 18px;
      color:#ffe8a7;
      font-weight:700;
      font-size:.84rem;
      z-index:150;
      opacity:0;
      transition:all .3s;
      white-space:normal;
      text-align:center;
      width:min(78vw,280px);
      box-shadow:0 14px 30px rgba(0,0,0,.34),0 0 24px rgba(255,215,110,.14);
      pointer-events:none;
    }
    .toast-notification::before{content:'';position:absolute;inset:0;border-radius:inherit;background:linear-gradient(135deg, rgba(255,255,255,.1), rgba(255,255,255,0) 35%, rgba(125,210,255,.12));pointer-events:none}
    .toast-notification.show{opacity:1;transform:translateX(-50%) translateY(0)}
    .phase-banner,.floating-banner,.toast-notification,.chip-select-hud{will-change:top,transform,opacity}
    .chip-select-hud{display:none !important;opacity:0 !important;pointer-events:none !important}
    @media (max-height: 680px){.phase-banner,.floating-banner{font-size:.68rem}.chip-select-copy span{font-size:.84rem}.toast-notification{font-size:.76rem;padding:10px 14px}}
    
    /* Crown Effect */
    .crown-effect{
      position:absolute;
      top:-25px;
      left:50%;
      transform:translateX(-50%);
      font-size:2rem;
      filter:drop-shadow(0 0 10px gold);
      opacity:0;
      z-index:20;
      pointer-events:none;
    }
    
    /* Modal Styles */
    .modal{
      position:fixed;
      inset:0;
      background:rgba(7,6,16,.62);
      backdrop-filter:none;
      display:flex;
      align-items:center;
      justify-content:center;
      opacity:0;
      visibility:hidden;
      transition:all .3s;
      z-index:200;
      cursor:pointer;
      pointer-events:none;
    }
    .modal.show{opacity:1;visibility:visible;pointer-events:auto}
    .modal-card{
      width:min(80vw,300px);
      padding:30px 24px;
      border-radius:38px;
      background:linear-gradient(145deg, rgba(30,20,44,.98), rgba(14,10,24,.98));
      border:1.6px solid rgba(255,215,110,.74);
      box-shadow:0 20px 48px rgba(0,0,0,.44), inset 0 1px 0 rgba(255,255,255,.12), 0 0 28px rgba(255,215,110,.10);
      text-align:center;
      transform:translateY(30px) scale(.85);
      transition:all .3s cubic-bezier(0.34, 1.2, 0.64, 1);
      cursor:default;
      box-shadow:0 30px 50px rgba(0,0,0,.5), 0 0 40px rgba(255,215,110,.2);
    }
    .modal.show .modal-card{transform:translateY(0) scale(1)}
    .modal-card h2{margin:0 0 10px;font-size:1.72rem;font-weight:900;letter-spacing:.02em;background:linear-gradient(135deg, #fffdf6, #ffd76e 58%, #ffb34b);-webkit-background-clip:text;background-clip:text;color:transparent;text-shadow:0 0 18px rgba(255,215,110,.12)}
    .modal-card p{margin:0;font-size:.92rem;color:#f1e8d2;line-height:1.45}
    .modal-card .popup-note{margin-top:12px;padding:10px 12px;border-radius:18px;background:linear-gradient(145deg, rgba(255,255,255,.06), rgba(255,255,255,.03));border:1px solid rgba(255,255,255,.08);font-size:.72rem;letter-spacing:.06em;text-transform:uppercase;color:rgba(255,241,207,.78)}
    .modal-card .popup-icon{width:54px;height:54px;margin:0 auto 14px;border-radius:16px;display:grid;place-items:center;font-size:1.5rem;background:linear-gradient(145deg, rgba(255,255,255,.15), rgba(255,255,255,.04));border:1px solid rgba(255,255,255,.14);box-shadow:inset 0 1px 0 rgba(255,255,255,.18),0 10px 22px rgba(0,0,0,.22)}
    .start-pop .modal-card{background:linear-gradient(145deg, rgba(18,62,40,.98), rgba(10,20,20,.98));border-color:rgba(82,232,138,.72)}
    .start-pop .popup-icon{color:#8affbf;box-shadow:0 0 28px rgba(82,232,138,.18), inset 0 1px 0 rgba(255,255,255,.14)}
    .stop-pop .modal-card{background:linear-gradient(145deg, rgba(67,37,12,.98), rgba(24,14,10,.98));border-color:rgba(255,176,78,.76)}
    .stop-pop .popup-icon{color:#ffc76e;box-shadow:0 0 28px rgba(255,176,78,.18), inset 0 1px 0 rgba(255,255,255,.14)}
    .winner-pop .modal-card{background:linear-gradient(145deg, rgba(64,34,14,.98), rgba(31,15,43,.98));border-color:rgba(255,215,110,.94);box-shadow:0 0 50px rgba(255,215,110,.32)}
    .winner-pop .popup-icon{color:#ffe08c;box-shadow:0 0 32px rgba(255,215,110,.22), inset 0 1px 0 rgba(255,255,255,.16)}
    .loser-pop .modal-card,.loss-pop .modal-card{background:linear-gradient(145deg, rgba(52,17,28,.98), rgba(22,10,18,.98));border-color:rgba(255,110,146,.56)}
    .loser-pop .popup-icon,.loss-pop .popup-icon{color:#ff94ae;box-shadow:0 0 28px rgba(255,110,146,.18), inset 0 1px 0 rgba(255,255,255,.14)}
    .nobid-pop .modal-card{background:linear-gradient(145deg, rgba(42,28,58,.96), rgba(15,11,26,.98));border-color:rgba(157,117,255,.54)}
    .nobid-pop .popup-icon{color:#c8adff;box-shadow:0 0 26px rgba(157,117,255,.18), inset 0 1px 0 rgba(255,255,255,.14)}
    .go-pop .modal-card{background:linear-gradient(145deg, rgba(255,215,110,.14), rgba(170,88,255,.15));border-color:#ffd76e}
    .go-pop .popup-icon{color:#ffd76e}
    .go-pop .modal-card h2{font-size:2.4rem}
    .modal-card{position:relative;overflow:hidden}
    .modal-card::before{content:"";position:absolute;inset:0;border-radius:inherit;background:linear-gradient(180deg, rgba(255,255,255,.12), transparent 34%, transparent 70%, rgba(255,215,110,.08));pointer-events:none}
    .modal-card::after{content:"";position:absolute;left:14%;right:14%;top:-14px;height:28px;border-radius:999px;background:linear-gradient(90deg, rgba(255,255,255,0), rgba(255,255,255,.32), rgba(255,255,255,0));pointer-events:none;opacity:.88}
    .modal.show .modal-card{box-shadow:0 22px 50px rgba(0,0,0,.55),0 0 34px rgba(255,215,110,.18)}
    .winner-pop .modal-card{box-shadow:0 22px 50px rgba(0,0,0,.55),0 0 50px rgba(255,215,110,.34),0 0 90px rgba(255,140,40,.18)}
    .winner-pop .modal-card h2{letter-spacing:1px}
    .modal-card .popup-kicker{font-size:.62rem;letter-spacing:.28em;text-transform:uppercase;color:rgba(255,235,185,.7);margin-bottom:10px}
    .modal-card .popup-accent{width:68px;height:6px;border-radius:999px;margin:0 auto 14px;background:linear-gradient(90deg,#8759ff,#ffd76e,#ffb653);box-shadow:0 0 16px rgba(255,215,110,.24)}
    .winner-pop .modal-card{background:linear-gradient(145deg, rgba(61,31,13,.96), rgba(31,16,40,.98))}
    .start-pop .modal-card{background:linear-gradient(145deg, rgba(14,57,34,.96), rgba(16,23,39,.96))}
    .stop-pop .modal-card{background:linear-gradient(145deg, rgba(64,35,16,.96), rgba(31,17,12,.98))}
    .loss-pop .modal-card{background:linear-gradient(145deg, rgba(42,16,26,.96), rgba(19,11,20,.98));border-color:rgba(255,110,146,.5)}
    .stop-pop .modal-card h2,.start-pop .modal-card h2,.go-pop .modal-card h2{text-shadow:0 0 18px rgba(255,255,255,.12)}
    .mega-celebration{display:none !important;position:fixed;inset:0;align-items:center;justify-content:center;background:radial-gradient(circle at 50% 42%, rgba(255,235,170,.14), rgba(0,0,0,.78) 56%);backdrop-filter:none;opacity:0;visibility:hidden;z-index:260;pointer-events:none}
    .mega-celebration.show{opacity:1;visibility:visible}
    .mega-core{position:relative;width:min(86vw,320px);padding:26px 22px;border-radius:38px;background:linear-gradient(145deg, rgba(42,26,18,.94), rgba(20,16,28,.97));border:1px solid rgba(255,222,140,.62);text-align:center;box-shadow:0 0 24px rgba(255,215,110,.12),0 24px 52px rgba(0,0,0,.55)}
    .mega-core h3{font-size:1.8rem;margin:0 0 8px;background:linear-gradient(135deg,#fff7d2,#ffd76e,#ffb14a);-webkit-background-clip:text;background-clip:text;color:transparent}
    .mega-core p{margin:0;color:#f7eac7;font-size:.9rem}
    
    .audio-popup{position:fixed;bottom:50%;left:50%;transform:translate(-50%, 50%) scale(.9);background:linear-gradient(145deg, #2a1a3a, #1a0a2a);border:2px solid rgba(255,215,110,.6);border-radius:32px;padding:24px;z-index:300;opacity:0;visibility:hidden;transition:all .3s;min-width:260px}
    .audio-popup.show{opacity:1;visibility:visible;transform:translate(-50%, 50%) scale(1)}
    .audio-popup-overlay{position:fixed;inset:0;background:rgba(0,0,0,.6);backdrop-filter:none;z-index:299;opacity:0;visibility:hidden}
    .audio-popup-overlay.show{opacity:1;visibility:visible}
    .audio-popup-overlay,
    .audio-popup{pointer-events:none}
    .audio-popup-overlay.show,
    .audio-popup.show{pointer-events:auto}
    .audio-popup{
      width:min(92vw,360px);
      min-width:0;
      padding:0;
      border:1px solid rgba(255,225,150,.56);
      border-radius:24px;
      background:
        linear-gradient(160deg,rgba(255,255,255,.12),rgba(255,255,255,0) 38%),
        radial-gradient(circle at 18% 0%,rgba(255,215,110,.22),transparent 34%),
        linear-gradient(145deg,rgba(20,14,34,.96),rgba(7,6,16,.98));
      box-shadow:0 26px 70px rgba(0,0,0,.58),0 0 34px rgba(255,215,110,.18),inset 0 1px 0 rgba(255,255,255,.14);
      overflow:hidden;
      backdrop-filter:blur(18px) saturate(130%);
      -webkit-backdrop-filter:blur(18px) saturate(130%);
    }
    .audio-popup::before{
      content:'';
      position:absolute;
      inset:0;
      pointer-events:none;
      background:linear-gradient(90deg,transparent,rgba(255,255,255,.12),transparent);
      transform:translateX(-120%) skewX(-18deg);
    }
    .audio-popup.show::before{animation:settingsSheen 1.1s ease-out .12s}
    @keyframes settingsSheen{to{transform:translateX(120%) skewX(-18deg)}}
    .audio-popup-shell{position:relative;padding:18px;display:flex;flex-direction:column;gap:14px}
    .audio-popup-header{display:flex;align-items:center;gap:12px}
    .audio-popup-icon{
      width:44px;
      height:44px;
      border-radius:16px;
      display:grid;
      place-items:center;
      color:#2a1704;
      background:linear-gradient(145deg,#fff4bd,#ffc750 55%,#b86a18);
      box-shadow:0 12px 22px rgba(0,0,0,.34),0 0 18px rgba(255,215,110,.24);
      flex:0 0 auto;
    }
    .audio-popup h3{margin:0;color:#fff4c6;font:900 1.05rem/1.05 'Poppins',sans-serif;letter-spacing:.04em;text-transform:uppercase}
    .audio-popup p{margin:4px 0 0;color:rgba(255,255,255,.58);font:700 .66rem/1 'Poppins',sans-serif;letter-spacing:.12em;text-transform:uppercase}
    .audio-controls{display:flex;flex-direction:column;gap:9px}
    .audio-popup .toggle{
      width:100%;
      min-height:58px;
      border:1px solid rgba(255,255,255,.12);
      border-radius:18px;
      background:linear-gradient(145deg,rgba(255,255,255,.08),rgba(255,255,255,.03));
      color:#fff;
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:14px;
      padding:10px 12px;
      cursor:pointer;
      text-align:left;
      transition:transform .16s ease,border-color .16s ease,box-shadow .16s ease,background .16s ease;
    }
    .audio-popup .toggle:active{transform:scale(.98)}
    .audio-popup .toggle.on{
      border-color:rgba(125,255,185,.44);
      background:linear-gradient(145deg,rgba(76,255,158,.14),rgba(255,255,255,.04));
      box-shadow:0 0 22px rgba(76,255,158,.10),inset 0 1px 0 rgba(255,255,255,.10);
    }
    .toggle-copy{display:grid;grid-template-columns:22px 1fr;grid-template-rows:auto auto;column-gap:9px;align-items:center;min-width:0}
    .toggle-copy i{grid-row:1/3;color:#ffd76e;font-size:.98rem;text-align:center}
    .toggle-copy strong{font:900 .82rem/1 'Poppins',sans-serif;color:#fff8dc;letter-spacing:.03em}
    .toggle-copy small{font:700 .58rem/1.1 'Poppins',sans-serif;color:rgba(255,255,255,.50);letter-spacing:.08em;text-transform:uppercase}
    .toggle-switch{
      width:46px;
      height:26px;
      border-radius:999px;
      background:rgba(255,255,255,.12);
      border:1px solid rgba(255,255,255,.12);
      padding:3px;
      flex:0 0 auto;
      transition:background .16s ease,border-color .16s ease;
    }
    .toggle-switch span{
      display:block;
      width:18px;
      height:18px;
      border-radius:50%;
      background:linear-gradient(145deg,#ffffff,#b8c0d5);
      box-shadow:0 4px 10px rgba(0,0,0,.32);
      transition:transform .18s ease,background .18s ease;
    }
    .toggle.on .toggle-switch{background:rgba(76,255,158,.28);border-color:rgba(125,255,185,.42)}
    .toggle.on .toggle-switch span{transform:translateX(20px);background:linear-gradient(145deg,#ffffff,#7dffb9)}
    .close-audio-btn{
      height:42px;
      border:1px solid rgba(255,215,110,.36);
      border-radius:999px;
      background:linear-gradient(145deg,rgba(255,215,110,.18),rgba(255,255,255,.05));
      color:#fff2bd;
      font:900 .72rem/1 'Poppins',sans-serif;
      letter-spacing:.12em;
      text-transform:uppercase;
      display:flex;
      align-items:center;
      justify-content:center;
      gap:8px;
      cursor:pointer;
    }
    .audio-popup-overlay.show{background:rgba(0,0,0,.58);backdrop-filter:blur(7px);-webkit-backdrop-filter:blur(7px)}
    .close-modal-btn{width:100%;padding:10px;margin-top:12px;background:linear-gradient(135deg, rgba(255,215,110,.2), rgba(0,0,0,.5));border:1px solid rgba(255,215,110,.5);border-radius:40px;color:#ffd76e;cursor:pointer}
    .utility-list{max-height:40vh;overflow-y:auto;margin-bottom:12px}
    .utility-item{display:flex;justify-content:space-between;padding:10px 14px;background:rgba(255,255,255,.08);border-radius:24px;margin-bottom:8px;color:#fff}
    .teen-active-user-grid{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:6px}
    .teen-active-user-card{display:grid;gap:5px;justify-items:center;align-content:start;min-width:0;padding:8px 4px;border-radius:12px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.10);text-align:center;color:#fff}
    .teen-active-user-avatar{width:38px;height:38px;border-radius:13px;overflow:hidden;display:grid;place-items:center;background:radial-gradient(circle at 35% 25%,#fff7d1,#ffbd3d 56%,#8f4700 100%);color:#401700;font-size:15px;font-weight:1000;box-shadow:0 8px 14px rgba(0,0,0,.28)}
    .teen-active-user-avatar img{width:100%;height:100%;display:block;object-fit:cover}
    .teen-active-user-card strong{max-width:100%;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:9px;line-height:1.15}
    .teen-active-user-card span{font-size:8px;line-height:1.15;color:rgba(255,255,255,.66);white-space:nowrap}
    .history-table-wrap{border:1px solid rgba(255,215,110,.18);border-radius:22px;overflow:hidden;background:rgba(6,10,18,.58)}
    .history-table{width:100%;border-collapse:collapse;color:#fff;font-size:.78rem}
    .history-table th,.history-table td{padding:10px 12px;text-align:left;vertical-align:top}
    .history-table th{position:sticky;top:0;background:rgba(17,20,31,.96);font-size:.67rem;letter-spacing:.12em;text-transform:uppercase;color:rgba(255,215,110,.86);z-index:1}
    .history-table tbody tr:nth-child(odd){background:rgba(255,255,255,.04)}
    .history-table tbody tr:nth-child(even){background:rgba(255,255,255,.07)}
    .history-table-empty{padding:14px;border-radius:22px;background:rgba(255,255,255,.08);color:#fff;text-align:center}
    .history-trace-cell{font-size:.68rem;line-height:1.35;word-break:break-word;color:rgba(255,255,255,.86)}
    .history-status{display:inline-flex;align-items:center;justify-content:center;padding:4px 8px;border-radius:999px;font-size:.68rem;font-weight:800;letter-spacing:.08em;text-transform:uppercase;white-space:nowrap}
    .history-status.win{background:rgba(70,232,138,.12);color:#6bf2a3;border:1px solid rgba(70,232,138,.2)}
    .history-status.loss{background:rgba(255,110,140,.12);color:#ff98ac;border:1px solid rgba(255,110,140,.18)}
    .history-status.pending{background:rgba(255,215,110,.12);color:#ffd76e;border:1px solid rgba(255,215,110,.18)}
    .history-status.punishment{background:rgba(255,173,92,.14);color:#ffc98f;border:1px solid rgba(255,173,92,.22)}
    
    canvas#fx{position:fixed;inset:0;pointer-events:none;z-index:25}
    .message-banner{position:fixed;left:50%;top:50%;transform:translate(-50%,-50%) scale(.94);display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:16px;background:linear-gradient(135deg, rgba(18,20,30,.96), rgba(30,24,42,.96));border:1px solid rgba(255,215,110,.30);backdrop-filter:blur(4px);font-weight:800;font-size:.82rem;letter-spacing:.01em;color:#fff;opacity:0;pointer-events:none;z-index:145;min-width:min(68vw,250px);max-width:min(78vw,300px);text-align:left;box-shadow:0 12px 28px rgba(0,0,0,.34), 0 0 12px rgba(255,215,110,.08)}
    .message-banner::before{content:'';position:absolute;inset:0;border-radius:inherit;background:linear-gradient(180deg, rgba(255,255,255,.08), rgba(255,255,255,0) 42%, rgba(125,210,255,.06));pointer-events:none}
    .message-banner-icon{position:relative;z-index:1;flex:0 0 34px;width:34px;height:34px;border-radius:50%;display:grid;place-items:center;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);font-size:1rem;box-shadow:inset 0 1px 0 rgba(255,255,255,.08)}
    .message-banner-copy{position:relative;z-index:1;display:flex;flex-direction:column;gap:2px;min-width:0}
    .message-banner-title{font-size:.67rem;letter-spacing:.14em;opacity:.68;text-transform:uppercase;white-space:nowrap}
    .message-banner-text{font-size:.9rem;line-height:1.15;white-space:normal;word-break:break-word}
    .toast-notification{display:none !important;opacity:0 !important;pointer-events:none !important}
    .message-banner.show{opacity:1;transform:translate(-50%,-50%) scale(1)}
    .message-banner.good{border-color:rgba(70,232,138,.52);box-shadow:0 14px 38px rgba(0,0,0,.38), 0 0 24px rgba(70,232,138,.18)}
    .message-banner.warn{border-color:rgba(255,215,110,.5);box-shadow:0 14px 38px rgba(0,0,0,.38), 0 0 24px rgba(255,215,110,.16)}
    .message-banner.error{border-color:rgba(255,110,140,.54);box-shadow:0 14px 38px rgba(0,0,0,.38), 0 0 24px rgba(255,110,140,.18)}
    .message-banner.good .message-banner-icon{background:rgba(70,232,138,.12);border-color:rgba(70,232,138,.28)}
    .message-banner.warn .message-banner-icon{background:rgba(255,215,110,.12);border-color:rgba(255,215,110,.24)}
    .message-banner.error .message-banner-icon{background:rgba(255,110,140,.12);border-color:rgba(255,110,140,.26)}
    .notice-blocker{position:fixed;inset:0;z-index:144;display:none;pointer-events:none;background:transparent}
    .notice-blocker.show{display:block;pointer-events:auto}

    .floating-banner{position:fixed;left:50%;bottom:115px;transform:translateX(-50%);padding:8px 18px;border-radius:40px;background:rgba(0,0,0,.8);border:1px solid rgba(255,215,110,.5);font-size:.8rem;font-weight:700;color:#fee4a0;opacity:0;visibility:hidden;z-index:32;pointer-events:none}
    .sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden}
    

    .game-container.phase-betting .timer-orb{filter:drop-shadow(0 0 14px rgba(70,232,138,.22))}
    .game-container.phase-stopbet .timer-orb{filter:drop-shadow(0 0 14px rgba(255,120,80,.28))}
    .game-container.phase-reveal .top-bar{border-bottom-color:rgba(130,170,255,.55)}
    .game-container.phase-winner .boards{filter:drop-shadow(0 0 16px rgba(255,215,110,.18))}
    .game-container.phase-reset .pots,.game-container.phase-reset .boards{transition:filter .2s ease, opacity .2s ease}
    .board::before{content:"";position:absolute;inset:0;border-radius:inherit;background:linear-gradient(180deg, rgba(255,255,255,.10), transparent 34%, transparent 72%, rgba(255,255,255,.04));pointer-events:none;opacity:.85}
    .board.selected-target{box-shadow:0 0 0 1px rgba(255,255,255,.22), 0 0 22px rgba(255,215,110,.22), 0 10px 24px rgba(0,0,0,.24)}
    .chip.selected .chip-face{transform:translateY(-2px)}
    .pots{position:relative}
    .pots::after{content:"";position:absolute;left:6%;right:6%;bottom:8px;height:14px;border-radius:999px;background:radial-gradient(circle, rgba(255,215,110,.12), transparent 70%);filter:blur(8px);pointer-events:none;opacity:.8}


    /* World-class phase system */
    .game-container.phase-betting::before{opacity:1;background:
      radial-gradient(circle at 50% 18%, rgba(70,232,138,.10), transparent 20%),
      radial-gradient(circle at 50% 80%, rgba(114,72,255,.10), transparent 30%),
      linear-gradient(180deg, rgba(255,255,255,.02), transparent 30%, transparent 70%, rgba(70,232,138,.03));}
    .game-container.phase-stopbet::before{opacity:1;background:
      radial-gradient(circle at 50% 18%, rgba(255,162,86,.12), transparent 20%),
      radial-gradient(circle at 50% 80%, rgba(114,72,255,.08), transparent 30%),
      linear-gradient(180deg, rgba(255,170,60,.03), transparent 35%, transparent 72%, rgba(255,120,80,.04));}
    .game-container.phase-reveal::before{opacity:1;background:
      radial-gradient(circle at 50% 18%, rgba(112,180,255,.13), transparent 22%),
      radial-gradient(circle at 50% 76%, rgba(255,215,110,.08), transparent 28%),
      linear-gradient(180deg, rgba(120,180,255,.04), transparent 35%, transparent 72%, rgba(255,255,255,.03));}
    .game-container.phase-winner::before{opacity:1;background:
      radial-gradient(circle at 50% 18%, rgba(255,215,110,.16), transparent 22%),
      radial-gradient(circle at 50% 76%, rgba(255,120,80,.08), transparent 30%),
      linear-gradient(180deg, rgba(255,215,110,.05), transparent 35%, transparent 72%, rgba(255,255,255,.04));}
    .game-container.phase-winner .top-bar{border-bottom-color:rgba(255,215,110,.9); box-shadow:0 8px 32px rgba(255,185,60,.22)}
    .game-container.phase-winner .chips-bar{border-top-color:rgba(255,215,110,.9); box-shadow:0 -8px 28px rgba(255,185,60,.18)}
    .game-container.phase-reveal .timer-orb{filter:drop-shadow(0 0 12px rgba(120,180,255,.35)) drop-shadow(0 0 24px rgba(255,255,255,.15))}
    .game-container.phase-stopbet .timer-orb{filter:drop-shadow(0 0 14px rgba(255,130,80,.28))}
    .game-container.phase-betting .board.touchable{box-shadow:0 0 18px rgba(255,215,110,.18), 0 10px 24px rgba(0,0,0,.22)}
    .game-container.phase-betting .chip.live .chip-face{filter:drop-shadow(0 0 0 rgba(0,0,0,0)) drop-shadow(0 8px 14px rgba(0,0,0,.45))}
    .game-container.phase-betting .chip.selected .chip-face{filter:drop-shadow(0 0 22px rgba(255,215,110,.75)) drop-shadow(0 10px 18px rgba(0,0,0,.45))}

    /* Card reveal cinematic */
    .cards.reveal-active .card{transform-origin:50% 100%;}
    .card.reveal-pop{animation:cardRevealPop .42s cubic-bezier(.2,.8,.2,1)}
    .card.shine-sweep::after{content:"";position:absolute;top:-20%;bottom:-20%;width:42%;left:-60%;background:linear-gradient(90deg, transparent, rgba(255,255,255,.35), transparent);transform:skewX(-18deg);animation:cardShine .48s ease-out forwards;pointer-events:none}
    @keyframes cardRevealPop{0%{transform:translateY(12px) scale(.88)}55%{transform:translateY(-8px) scale(1.05)}100%{transform:translateY(0) scale(1)}}
    @keyframes cardShine{0%{left:-60%;opacity:0}20%{opacity:1}100%{left:120%;opacity:0}}
    .hand-label.reveal-label{opacity:1 !important;animation:labelPop .45s cubic-bezier(.2,.8,.2,1)}
    @keyframes labelPop{0%{transform:translateX(-50%) translateY(8px) scale(.8);opacity:0}100%{transform:translateX(-50%) translateY(0) scale(1);opacity:1}}

    /* Winner package */
    .pot.winner-pot{transform:translateY(-2px);animation:winnerPotFloat 1.5s ease-in-out infinite}
    .pot.winner-pot .pot-title{animation:winnerTitlePulse .9s ease-in-out infinite, winnerTitleSwing 1.7s ease-in-out infinite}
    .pot.winner-pot .cards{filter:drop-shadow(0 0 18px rgba(255,215,110,.55));animation:winnerCardsDance 1.45s ease-in-out infinite}
    .pot.winner-pot .chair{filter:drop-shadow(0 0 12px rgba(255,215,110,.30)) drop-shadow(0 6px 10px rgba(0,0,0,.22));animation:winnerChairDance 1.1s ease-in-out infinite}
    .pot.winner-pot .winner-spotlight{opacity:1}
    .pot.winner-pot .card.front:nth-child(1){animation:winnerCardDance 1.02s ease-in-out infinite}
    .pot.winner-pot .card.front:nth-child(2){animation:winnerCardDance 1.12s ease-in-out infinite .08s}
    .pot.winner-pot .card.front:nth-child(3){animation:winnerCardDance 1.2s ease-in-out infinite .16s}
    .board.winner-board{animation:winnerBoardPulse .55s ease-in-out infinite, winnerBoardHue 2.8s linear infinite; box-shadow:0 0 0 1px rgba(255,255,255,.25), 0 0 26px rgba(255,215,110,.45), 0 0 56px rgba(255,170,60,.28)}
    .board.winner-board .board-mini{color:#fff5c7; opacity:.95}
    .board.winner-board .board-amount,.board.winner-board .won-amount{text-shadow:0 0 18px rgba(255,215,110,.45)}
    @keyframes winnerBoardPulse{0%,100%{transform:translateY(0) scale(1)}50%{transform:translateY(-2px) scale(1.03)}}
    @keyframes winnerTitlePulse{0%,100%{transform:scale(1)}50%{transform:scale(1.08)}}
    @keyframes winnerPotFloat{0%,100%{transform:translateY(-2px)}50%{transform:translateY(-10px)}}
    @keyframes winnerTitleSwing{0%,100%{transform:translateY(0) rotate(0deg)}50%{transform:translateY(-2px) rotate(-3deg)}}
    @keyframes winnerCardsDance{0%,100%{transform:translateY(0)}50%{transform:translateY(-4px)}}
    @keyframes winnerChairDance{0%,100%{transform:translateY(0) rotate(0deg)}50%{transform:translateY(-6px) rotate(-2deg)}}
    @keyframes winnerCardDance{0%,100%{transform:translateY(0) rotate(0deg) scale(1)}50%{transform:translateY(-10px) rotate(5deg) scale(1.08)}}
    @keyframes winnerBoardHue{0%{filter:hue-rotate(0deg) saturate(1)}50%{filter:hue-rotate(22deg) saturate(1.15)}100%{filter:hue-rotate(0deg) saturate(1)}}
    .coin-rain{position:fixed; top:-30px; width:18px; height:18px; border-radius:50%; background:radial-gradient(circle at 35% 35%, #fff6c6, #ffd76e 45%, #be7c11 100%); box-shadow:0 0 14px rgba(255,215,110,.5); z-index:160; pointer-events:none}
    .bridge-win-spark{position:fixed;left:0;top:0;width:14px;height:14px;border-radius:50%;pointer-events:none;z-index:214;background:radial-gradient(circle, rgba(255,255,255,.96) 0%, var(--spark-color, #ffd76e) 45%, rgba(255,255,255,0) 72%);box-shadow:0 0 22px var(--spark-color, #ffd76e);transform:translate(-50%, -50%);animation:bridgeWinnerSparkFly var(--spark-duration, 1.4s) ease-out forwards}
    .bridge-win-crown{position:absolute;left:50%;top:-32px;transform:translateX(-50%);font-size:2rem;line-height:1;z-index:16;filter:drop-shadow(0 0 14px rgba(255,215,110,.68));animation:bridgeWinnerCrownBob 1.2s ease-in-out infinite}
    @keyframes bridgeWinnerSparkFly{0%{transform:translate(-50%, -50%) scale(.45) rotate(0deg);opacity:0}12%{opacity:1}100%{transform:translate(calc(-50% + var(--spark-dx, 0px)), calc(-50% + var(--spark-dy, -120px))) scale(var(--spark-scale, 1.2)) rotate(var(--spark-rotate, 0deg));opacity:0}}
    @keyframes bridgeWinnerCrownBob{0%,100%{transform:translateX(-50%) translateY(0)}50%{transform:translateX(-50%) translateY(-6px)}}
    .phase-banner{position:fixed; left:50%; top:calc(var(--top-bar-h) + 78px); transform:translateX(-50%); padding:6px 16px; border-radius:999px; font-size:.72rem; font-weight:900; letter-spacing:1.4px; color:#fff6cc; background:linear-gradient(135deg, rgba(8,8,12,.84), rgba(38,26,64,.92)); border:1px solid rgba(255,215,110,.32); backdrop-filter:blur(8px); z-index:95; opacity:0; visibility:hidden; pointer-events:none;max-width:min(84vw,320px);text-align:center}
    .phase-banner.show{visibility:visible;animation:phaseBannerIn .75s ease both}
    @keyframes phaseBannerIn{0%{opacity:0;transform:translateX(-50%) translateY(8px) scale(.92)}20%,80%{opacity:1;transform:translateX(-50%) translateY(0) scale(1)}100%{opacity:0;transform:translateX(-50%) translateY(-8px) scale(.98)}}


    /* ===== Magical view upgrade v7 ===== */
    .timer-orb.energy-core{
      overflow:visible;
      isolation:isolate;
    }
    .timer-orb.energy-core::before,
    .timer-orb.energy-core::after{
      content:"";
      position:absolute;
      inset:-4px;
      border-radius:50%;
      pointer-events:none;
    }
    .timer-orb.energy-core::before{
      background:conic-gradient(from 0deg, rgba(255,215,110,.0), rgba(255,215,110,.18), rgba(130,120,255,.26), rgba(255,215,110,.05), rgba(255,215,110,.0));
      filter:blur(4px);
      animation:orbRotate 7s linear infinite;
      opacity:.95;
    }
    .timer-orb.energy-core::after{
      inset:-8px;
      background:radial-gradient(circle, rgba(255,215,110,.18) 0%, rgba(255,120,80,.08) 34%, transparent 66%);
      filter:blur(8px);
      opacity:.52;
      animation:orbBreathe 2.8s ease-in-out infinite;
    }
    .timer-core,
    .timer-runes,
    .timer-spark{
      position:absolute;
      inset:0;
      border-radius:50%;
      pointer-events:none;
    }
    .timer-core{
      inset:24px;
      background:
        radial-gradient(circle at 35% 35%, rgba(255,255,255,.48), rgba(255,255,255,.08) 24%, rgba(90,40,160,.18) 40%, rgba(10,5,20,0) 58%),
        radial-gradient(circle at 50% 58%, rgba(255,215,110,.22), rgba(255,140,70,.14) 38%, transparent 70%);
      mix-blend-mode:screen;
      filter:blur(1px);
      animation:corePulse 2.2s ease-in-out infinite;
      z-index:1;
    }
    .timer-runes{
      inset:7px;
      border:1px dashed rgba(255,215,110,.24);
      opacity:.52;
      animation:orbRotateReverse 11s linear infinite;
    }
    .timer-spark{
      inset:-10px;
      background:
        radial-gradient(circle at 20% 26%, rgba(255,255,255,.95) 0 1px, transparent 3px),
        radial-gradient(circle at 78% 22%, rgba(255,215,110,.95) 0 1.5px, transparent 4px),
        radial-gradient(circle at 16% 74%, rgba(180,150,255,.88) 0 1px, transparent 3px),
        radial-gradient(circle at 76% 78%, rgba(255,255,255,.9) 0 1px, transparent 3px);
      opacity:.8;
      animation:sparkOrbit 3.6s linear infinite;
    }
    .timer-orb .timer-inner{overflow:hidden}
    .timer-orb .timer-inner::before{
      content:"";
      position:absolute;
      inset:0;
      border-radius:50%;
      background:radial-gradient(circle at 28% 24%, rgba(255,255,255,.18), transparent 36%), linear-gradient(180deg, rgba(255,255,255,.08), rgba(255,255,255,0));
      pointer-events:none;
      z-index:0;
    }
    .timer-value,.timer-sub{position:relative;z-index:2}
    .board-energy{
      position:absolute;
      inset:-12px;
      border-radius:26px;
      opacity:0;
      background:
        radial-gradient(circle at 50% 50%, rgba(255,255,255,.12), transparent 42%),
        linear-gradient(135deg, rgba(255,215,110,.0), rgba(255,215,110,.16), rgba(120,150,255,.0));
      filter:blur(10px);
      pointer-events:none;
      transform:scale(.88);
    }
    .board.magic-hit .board-energy{animation:boardEnergyWave .7s ease-out forwards}
    .board.magic-hit{animation:boardTapKick .32s ease-out}
    .board.magic-hit .board-amount{animation:boardTextFlash .55s ease-out}
    .board.touchable .board-energy{opacity:.38}
    .board.winner-board .board-energy{
      opacity:.95;
      background:
        radial-gradient(circle at 50% 50%, rgba(255,245,200,.24), transparent 40%),
        conic-gradient(from 0deg, rgba(255,215,110,.08), rgba(255,255,255,.2), rgba(255,160,60,.12), rgba(255,215,110,.08));
      animation:winnerEnergyRotate 2.2s linear infinite, winnerEnergyFlicker .95s ease-in-out infinite;
    }
    .pot-aura{
      position:absolute;
      left:50%;
      top:34px;
      width:126px;
      height:126px;
      transform:translateX(-50%) scale(.82);
      border-radius:50%;
      background:
        radial-gradient(circle, rgba(255,235,170,.26) 0%, rgba(255,170,80,.12) 28%, rgba(130,110,255,.08) 48%, transparent 72%);
      filter:blur(10px);
      opacity:0;
      pointer-events:none;
      z-index:1;
    }
    .pot.winner-pot .pot-aura{
      animation:divineAura 1.25s ease-in-out infinite;
      opacity:1;
    }
    .pot.winner-pot .winner-spotlight{
      background:
        radial-gradient(circle, rgba(255,235,170,.36) 0%, rgba(255,150,70,.14) 42%, transparent 74%);
      filter:blur(3px);
    }
    .pot.winner-pot .winner-spotlight::after{content:"";position:absolute;inset:4px;border-radius:inherit;background:conic-gradient(from 0deg, rgba(255,255,255,0), rgba(255,255,255,.24), rgba(255,215,110,.10), rgba(255,255,255,0));mix-blend-mode:screen;animation:winnerSpotlightSweep 1.4s linear infinite}
    .divine-ring{
      position:fixed;
      width:26px;
      height:26px;
      border-radius:50%;
      border:2px solid rgba(255,240,190,.85);
      box-shadow:0 0 20px rgba(255,215,110,.5);
      pointer-events:none;
      z-index:165;
      opacity:0;
    }
    .board.selected-target{
      box-shadow:0 0 0 1px rgba(255,255,255,.22), 0 0 24px rgba(255,215,110,.26), 0 10px 24px rgba(0,0,0,.24), inset 0 0 18px rgba(255,255,255,.06);
    }
    .game-container.phase-betting .timer-orb.energy-core{filter:drop-shadow(0 0 18px rgba(70,232,138,.20)) drop-shadow(0 0 34px rgba(145,100,255,.12))}
    .game-container.phase-stopbet .timer-orb.energy-core{filter:drop-shadow(0 0 18px rgba(255,128,80,.28))}
    .game-container.phase-reveal .timer-orb.energy-core{filter:drop-shadow(0 0 18px rgba(110,185,255,.30)) drop-shadow(0 0 34px rgba(255,255,255,.08))}
    .game-container.phase-winner .timer-orb.energy-core{filter:drop-shadow(0 0 20px rgba(255,215,110,.62)) drop-shadow(0 0 36px rgba(255,255,255,.12))}
    .game-container.phase-betting .timer-runes{border-color:rgba(70,232,138,.32)}
    .game-container.phase-stopbet .timer-runes{border-color:rgba(255,128,80,.34)}
    .game-container.phase-reveal .timer-runes{border-color:rgba(110,185,255,.36)}
    .game-container.phase-winner .timer-runes{border-color:rgba(255,235,170,.40)}
    .phase-plan-note{display:none}
    @keyframes orbRotate{to{transform:rotate(360deg)}}
    @keyframes orbRotateReverse{to{transform:rotate(-360deg)}}
    @keyframes orbBreathe{0%,100%{transform:scale(.96);opacity:.52}50%{transform:scale(1.08);opacity:.92}}
    @keyframes corePulse{0%,100%{transform:scale(.96);opacity:.72}50%{transform:scale(1.08);opacity:1}}
    @keyframes sparkOrbit{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}
    @keyframes boardEnergyWave{0%{opacity:0;transform:scale(.82)}40%{opacity:1}100%{opacity:0;transform:scale(1.18)}}
    @keyframes boardTapKick{0%{transform:translateY(0) scale(1)}40%{transform:translateY(-3px) scale(1.03)}100%{transform:translateY(0) scale(1)}}
    @keyframes boardTextFlash{0%{filter:brightness(1)}50%{filter:brightness(1.5)}100%{filter:brightness(1)}}
    @keyframes winnerEnergyRotate{to{transform:rotate(360deg)}}
    @keyframes winnerEnergyFlicker{0%,100%{opacity:.68}50%{opacity:1}}
    @keyframes divineAura{0%,100%{transform:translateX(-50%) scale(.84);opacity:.74}50%{transform:translateX(-50%) scale(1.04);opacity:1}}
    @keyframes winnerSpotlightSweep{to{transform:rotate(360deg)}}



    @media (max-height: 450px){
      .top-bar{padding:5px 8px;min-height:52px}
      .coin-section,.user-section{padding:3px 7px}
      .coin-amount{font-size:.88rem;width:9.8ch;max-width:9.8ch}
      .user-name{font-size:.7rem;max-width:56px}
      .icon-btn{width:30px;height:30px}
      .top-stack{top:46px;padding-top:0;gap:2px}
      .status-strip{gap:5px}
      .status-pill{padding:4px 8px;font-size:.53rem;letter-spacing:.08em}
      .timer-orb{width:72px;height:72px;min-width:72px;min-height:72px}
      .timer-wrap::after{inset:12px}
      .timer-inner{inset:12px}
      .timer-value{font-size:1.45rem}
      .timer-sub{font-size:.45rem;letter-spacing:1px}
      .phase-banner{top:112px;font-size:.6rem;padding:5px 12px}
      .bottom-stack{bottom:54px;gap:0}
      .pots,.boards{gap:5px}
      .pot{min-height:92px;padding-top:4px}
      .chair{width:50px;margin-bottom:-11px}
      .cards{height:50px;min-height:50px}
      .card{width:34px;height:48px;min-width:34px;min-height:48px;margin-left:-10px;border-radius:8px}
      .card-corner.top-left{top:3px;left:4px}
      .card-corner.top-right{top:3px;right:4px}
      .card-corner.bottom-right{right:4px;bottom:3px}
      .rank{font-size:.62rem}
      .suit{font-size:.64rem}
      .center{font-size:.92rem}
      .center small{font-size:.38rem}
      .hand-label{bottom:-8px;font-size:.44rem;padding:2px 6px}
      .pot-title{font-size:.82rem;margin-top:1px}
      .board{min-height:70px;padding:6px 4px;border-radius:14px}
      .board-amount{font-size:.84rem}
      .won-amount{font-size:.72rem}
      .board-mini{font-size:.4rem}
      .chips-bar{padding:5px 8px max(5px, env(safe-area-inset-bottom));gap:5px;min-height:54px}
      .chip,.tool-btn{width:34px;height:34px;flex-basis:34px}
      .chip-face{width:32px;height:32px}
      .tool-btn{font-size:.72rem}
      .splash-logo{padding:9px 12px}
      .splash-title{font-size:1.08rem}
      .splash-sub{font-size:.52rem;letter-spacing:.12em}
      .splash-progress-wrap{width:min(92vw,260px)}
      .splash-log{font-size:.6rem;min-height:26px}
    }

    @media (max-width:480px){
      .top-bar{padding:8px 12px}
      .coin-section,.user-section{padding:4px 12px}
      .coin-amount{font-size:1rem;width:10.2ch;max-width:10.2ch}
      .timer-orb{width:120px;height:120px}
      .timer-value{font-size:2.3rem}
      .chair{width:75px;margin-bottom:-26px}
      .cards{height:82px}
      .card{width:52px;height:78px;margin-left:-16px}
      .pot-title{font-size:1.5rem}
      .board-amount{font-size:1.4rem}
      .chip{width:48px;height:48px}
      .chip-face{width:44px;height:44px}
      .modal-card{padding:24px 18px}
      .modal-card h2{font-size:1.5rem}
    }

    /* ===== Mobile-only responsive overrides ===== */
    html,body{
      width:100%;
      max-width:100%;
      overflow:hidden;
      touch-action:manipulation;
    }
    body{
      display:flex;
      justify-content:center;
      align-items:stretch;
      background:#05020d;
    }
    .game-container{
      width:100%;
      max-width:480px;
      left:50%;
      transform:translateX(-50%);
      right:auto;
      min-height:100dvh;
      height:100dvh;
      box-shadow:0 0 0 1px rgba(255,255,255,.04), 0 0 40px rgba(0,0,0,.45);
    }
    .top-bar,
    .chips-bar{
      width:100%;
      max-width:480px;
      left:50%;
      right:auto;
      transform:translateX(-50%);
    }
    .game-content{
      height:100%;
      padding-top:0;
      padding-bottom:0;
      overflow:hidden;
      overscroll-behavior:contain;
    }
    .shell{
      padding:0;
      gap:0;
      height:100%;
    }
    .top-bar{
      padding:8px 10px;
      gap:6px;
    }
    .coin-section,
    .user-section{
      min-width:0;
      padding:5px 10px;
      gap:6px;
    }
    .coin-amount{
      font-size:1rem;
      line-height:1;
    }
    .balance-watermark{
      font-size:.48rem;
      margin-top:4px;
      padding:1px 8px;
    }
    .user-name{
      max-width:82px;
      font-size:.76rem;
    }
    .icon-buttons{
      gap:6px;
      flex-shrink:0;
    }
    .icon-btn{
      width:34px;
      height:34px;
      font-size:.9rem;
      flex:0 0 34px;
    }
    .timer-wrap{
      margin:0;
      filter:drop-shadow(0 8px 18px rgba(0,0,0,.28));
    }
    .timer-wrap.sticky-timer{top:auto;padding:0;}
    .boards.sticky-boards{bottom:auto;padding:0;}
    .timer-orb{
      width:min(27vw,110px);
      height:min(27vw,110px);
      min-width:76px;
      min-height:70px;
    }
    .timer-inner{
      inset:10px;
    }
    .timer-value{
      font-size:clamp(1.7rem, 7vw, 2.4rem);
    }
    .timer-sub{
      font-size:.6rem;
      letter-spacing:1.5px;
    }
    .pots,
    .boards{
      gap:6px;
    }
    .pot{
      padding:4px 4px 2px;
      border-radius:20px;
      min-width:0;
    }
    .chair{
      width:min(20vw,76px);
      min-width:50px;
      margin-bottom:-16px;
    }
    .cards{
      height:min(20vw,76px);
      min-height:54px;
    }
    .card{
      width:min(16.5vw,62px);
      height:min(24.2vw,90px);
      min-width:42px;
      min-height:62px;
      border-radius:10px;
      margin-left:-14px;
    }
    .pot .cards .card:nth-child(1){transform:translateX(10px);z-index:3}
    .pot .cards .card:nth-child(2){transform:translateX(0);z-index:2}
    .pot .cards .card:nth-child(3){transform:translateX(-10px);z-index:1}
    .rank{font-size:.74rem}
    .suit{font-size:.94rem}
    .center{font-size:.62rem}
    .hand-label{
      top:-22px;
      font-size:.56rem;
      padding:4px 9px;
      max-width:94%;
      overflow:hidden;
      text-overflow:ellipsis;
    }
    .pot-title{
      margin-top:8px;
      font-size:clamp(1.05rem, 7vw, 1.6rem);
      letter-spacing:1px;
      line-height:1;
    }
    .board{
      min-height:70px;
      padding:7px 5px 6px;
      border-radius:18px;
    }
    .board-amount{
      font-size:clamp(1rem, 5.5vw, 1.35rem);
      line-height:1.05;
      text-align:center;
      word-break:break-word;
    }
    .won-amount{
      font-size:clamp(.92rem, 5vw, 1.2rem);
      line-height:1.05;
      text-align:center;
      word-break:break-word;
    }
    .board-mini{
      font-size:.54rem;
      letter-spacing:.8px;
      text-align:center;
    }
    .chips-bar{
      gap:6px;
      padding:6px 8px max(6px, env(safe-area-inset-bottom));
      justify-content:space-between;
    }
    .chip{
      width:42px;
      height:42px;
      flex:0 0 42px;
    }
    .chip img{
      width:40px;
      height:40px;
    }
    .tool-btn{
      width:42px;
      height:42px;
      flex:0 0 42px;
      font-size:1rem;
    }
    .toast-notification{
      bottom:72px;
      max-width:92%;
      padding:9px 16px;
      font-size:.75rem;
      white-space:normal;
      text-align:center;
      border-radius:20px;
    }
    .floating-banner{
      bottom:68px;
      font-size:.7rem;
      max-width:92%;
      text-align:center;
    }
    .message-banner{
      width:min(92vw, 360px);
      text-align:center;
      font-size:.82rem;
      padding:12px 16px;
    }
    .modal-card{
      width:min(86vw, 320px);
      border-radius:32px;
      padding:22px 16px;
    }
    .utility-list{
      max-height:34vh;
    }

    @media (max-width:390px){
      .top-bar{padding:7px 8px}
      .coin-section,.user-section{padding:4px 8px}
      .coin-icon,.user-icon{font-size:15px}
      .coin-amount{font-size:.9rem;width:9.7ch;max-width:9.7ch}
      .user-name{max-width:52px;font-size:.7rem}
      .icon-btn{width:30px;height:30px;flex-basis:30px}
      .game-content{padding-top:0;padding-bottom:0}
      .timer-wrap.sticky-timer{top:auto}
      .boards.sticky-boards{bottom:auto}
      .shell{padding:0;gap:0}
      .pots,.boards{gap:6px}
      .board{min-height:84px;padding:8px 5px 7px}
      .chip,.tool-btn{width:38px;height:38px;flex-basis:38px}
      .chip-face{width:36px;height:36px}
      .tool-btn{font-size:.9rem}
    }

    @media (max-height:700px){
      .game-content{padding-top:0;padding-bottom:0}
      .timer-wrap.sticky-timer{top:auto}
      .boards.sticky-boards{bottom:auto}
      .shell{gap:0}
      .timer-orb{width:94px;height:94px;min-width:94px;min-height:94px}
      .timer-inner{inset:8px}
      :root{--card-w:53px;--card-h:86px}
      .pot{padding-top:6px}
      .chair{width:58px;margin-bottom:-12px}
      .cards{height:72px;min-height:72px}
      .card{width:46px;height:68px;min-width:46px;min-height:68px}
      .rank{font-size:.62rem}
      .suit{font-size:.82rem}
      .center{font-size:.56rem}
      .pot-title{font-size:1.05rem;margin-top:6px}
      .board{min-height:64px;padding:6px 5px}
      .board-amount{font-size:.95rem}
      .won-amount{font-size:.86rem}
      .board-mini{font-size:.48rem}
      .chip,.tool-btn{width:36px;height:36px;flex-basis:36px}
      .chip-face{width:34px;height:34px}
    }

    @media (max-height:540px){
      .top-bar{padding:6px 8px}
      .coin-section,.user-section{padding:3px 7px}
      .balance-watermark{display:none}
      .game-content{padding-top:56px;padding-bottom:52px}
      .timer-wrap.sticky-timer{top:56px}
      .boards.sticky-boards{bottom:46px}
      .timer-orb{width:78px;height:78px;min-width:78px;min-height:78px}
      :root{--card-w:46px;--card-h:77px}
      .timer-value{font-size:1.45rem}
      .timer-sub{font-size:.5rem}
      .chair{width:46px;margin-bottom:-10px}
      .cards{height:54px;min-height:54px}
      .card{width:35px;height:51px;min-width:35px;min-height:51px;margin-left:-10px;border-radius:8px}
      .pot .cards .card:nth-child(1){transform:translateX(7px)}
      .pot .cards .card:nth-child(3){transform:translateX(-7px)}
      .rank{top:3px;left:4px;font-size:.46rem}
      .suit{right:4px;bottom:2px;font-size:.62rem}
      .center{font-size:.46rem}
      .hand-label{bottom:-9px;font-size:.46rem;padding:3px 7px}
      .pot-title{font-size:.9rem}
      .board{min-height:54px;padding:5px 4px;border-radius:14px}
      .board-amount{font-size:.78rem}
      .won-amount{font-size:.72rem}
      .board-mini{font-size:.42rem}
      .chip,.tool-btn{width:32px;height:32px;flex-basis:32px}
      .chip-face{width:30px;height:30px}
      .tool-btn{font-size:.74rem}
      .toast-notification{top:210px;bottom:auto}
      .floating-banner{bottom:52px}
    }

    @media (min-width:481px){
      .game-container,
      .top-bar,
      .chips-bar{
        max-width:430px;
      }
    }

  

    /* locked mobile layout override */
    .board-top,.board-bottom{display:flex;flex-direction:column;align-items:center;gap:2px}
    .board-payout{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;z-index:1;padding:0;border:none;border-radius:0;background:none;color:rgba(255,226,139,.10);font-family:'Orbitron','Poppins',sans-serif;font-size:clamp(1.12rem,5vw,1.72rem);font-weight:900;letter-spacing:.08em;line-height:1;text-transform:uppercase;text-shadow:none;pointer-events:none;user-select:none;white-space:nowrap}
    body[class*="gf-popup-popup_"] .modal-card,
    body[class*="gf-popup-popup_"] .audio-popup,
    body[class*="gf-popup-popup_"] .phase-popup{border-color:var(--teen-glass-border);box-shadow:0 24px 80px rgba(0,0,0,.48),0 0 30px var(--teen-payout-glow)}
    body.gf-popup-popup_01{
      --teen-popup-surface:linear-gradient(180deg, rgba(3,42,26,.96) 0%, rgba(8,76,48,.94) 52%, rgba(7,30,21,.97) 100%);
      --teen-popup-title:#ffe9a3;
      --teen-popup-copy:#f8f4db;
      --teen-popup-copy-soft:rgba(241,247,225,.82);
      --teen-popup-note-bg:rgba(7,47,34,.68);
      --teen-popup-note-border:rgba(255,220,126,.34);
      --teen-popup-note-text:#fff0b7;
      --teen-popup-accent:linear-gradient(90deg, #ffdb73, #17bf73, #fff0b2);
      --teen-popup-icon-bg:radial-gradient(circle at 30% 25%, rgba(255,249,221,.22), rgba(255,255,255,0) 58%), linear-gradient(145deg, rgba(13,71,43,.94), rgba(3,31,20,.98));
      --teen-popup-icon-border:rgba(255,221,125,.54);
      --teen-popup-icon-color:#ffe291;
      --teen-popup-shell-shadow:0 36px 90px rgba(0,0,0,.58), 0 0 34px rgba(21,146,90,.26), inset 0 0 0 1px rgba(255,219,118,.14);
      --teen-popup-toggle-off:rgba(9,53,33,.88);
      --teen-popup-toggle-on:linear-gradient(135deg, #1cc97d, #0b7c4b);
      --teen-popup-toggle-border:rgba(255,221,125,.42);
    }
    body.gf-popup-popup_02{
      --teen-popup-surface:linear-gradient(180deg, rgba(74,8,18,.96) 0%, rgba(132,20,29,.94) 52%, rgba(48,6,13,.97) 100%);
      --teen-popup-title:#ffe2a0;
      --teen-popup-copy:#fff0de;
      --teen-popup-copy-soft:rgba(255,238,218,.82);
      --teen-popup-note-bg:rgba(88,10,19,.68);
      --teen-popup-note-border:rgba(255,210,112,.34);
      --teen-popup-note-text:#ffe8ba;
      --teen-popup-accent:linear-gradient(90deg, #ffd469, #d93a46, #ffe9a3);
      --teen-popup-icon-bg:radial-gradient(circle at 30% 25%, rgba(255,241,221,.24), rgba(255,255,255,0) 58%), linear-gradient(145deg, rgba(114,14,27,.94), rgba(54,4,15,.98));
      --teen-popup-icon-border:rgba(255,208,112,.54);
      --teen-popup-icon-color:#ffd985;
      --teen-popup-shell-shadow:0 36px 90px rgba(0,0,0,.58), 0 0 34px rgba(204,44,61,.26), inset 0 0 0 1px rgba(255,216,120,.12);
      --teen-popup-toggle-off:rgba(83,8,17,.88);
      --teen-popup-toggle-on:linear-gradient(135deg, #e24958, #a01024);
      --teen-popup-toggle-border:rgba(255,210,112,.40);
    }
    body.gf-popup-popup_01 .modal-card::before,
    body.gf-popup-popup_01 .modal-card::after,
    body.gf-popup-popup_01 .audio-popup::before,
    body.gf-popup-popup_01 .utility-modal .modal-card::before,
    body.gf-popup-popup_01 .utility-modal .modal-card::after,
    body.gf-popup-popup_02 .modal-card::before,
    body.gf-popup-popup_02 .modal-card::after,
    body.gf-popup-popup_02 .audio-popup::before,
    body.gf-popup-popup_02 .utility-modal .modal-card::before,
    body.gf-popup-popup_02 .utility-modal .modal-card::after{display:block !important}
    body.gf-popup-popup_03 .modal-card,body.gf-popup-popup_03 .audio-popup{background:linear-gradient(145deg,rgba(10,30,48,.94),rgba(3,8,18,.96))}
    body.gf-popup-popup_04 .modal-card,body.gf-popup-popup_04 .audio-popup{background:linear-gradient(145deg,rgba(48,9,32,.94),rgba(8,4,14,.96))}
    body.gf-popup-popup_05 .modal-card,body.gf-popup-popup_05 .audio-popup{filter:saturate(1.2)}
    body.teen-system-classic_glass.teen-patti-premium-popup{
      --teen-popup-shell-shadow:0 34px 94px rgba(0,0,0,.64), 0 0 34px rgba(68,172,120,.18), inset 0 0 0 1px rgba(255,226,154,.18);
      --teen-popup-overlay:radial-gradient(circle at 50% 36%, rgba(80,208,138,.18), transparent 38%), linear-gradient(180deg, rgba(4,9,8,.34), rgba(2,5,9,.86));
    }
    body.teen-system-classic_glass.teen-patti-premium-popup .modal-card,
    body.teen-system-classic_glass.teen-patti-premium-popup .audio-popup,
    body.teen-system-classic_glass.teen-patti-premium-popup .utility-modal .modal-card{
      border:0 !important;
      background-color:transparent !important;
      background-image:var(--teen-popup-frame) !important;
      background-position:center center !important;
      background-repeat:no-repeat !important;
      background-size:100% 100% !important;
    }
    body.teen-system-classic_glass.teen-patti-premium-popup .modal-card::before{
      content:none !important;
      display:none !important;
      inset:auto !important;
      border-radius:0 !important;
      background:none !important;
    }
    body.teen-system-classic_glass.teen-patti-premium-popup .audio-popup{
      --teen-audio-window-top:clamp(82px, 24%, 96px);
      --teen-audio-window-side:clamp(16px, 5.8%, 28px);
      --teen-audio-window-bottom:clamp(38px, 12%, 52px);
      width:min(96vw, 432px) !important;
      max-width:432px !important;
      aspect-ratio:1.16 !important;
      min-height:0 !important;
      height:auto !important;
      max-height:min(88dvh, 372px) !important;
      border:0 !important;
      border-radius:0 !important;
      background-color:transparent !important;
      background-image:none !important;
      background-position:center center !important;
      background-repeat:no-repeat !important;
      background-size:100% 100% !important;
      box-shadow:0 28px 78px rgba(0,0,0,.58), 0 0 28px rgba(64,176,126,.18) !important;
      overflow:visible !important;
      backdrop-filter:none !important;
      -webkit-backdrop-filter:none !important;
    }
    body.teen-system-classic_glass.teen-patti-premium-popup .audio-popup::before{
      content:'' !important;
      display:block !important;
      position:absolute !important;
      inset:0 !important;
      transform:none !important;
      border:0 !important;
      background:var(--teen-popup-frame) center center / 100% 100% no-repeat !important;
      box-shadow:none !important;
      z-index:4 !important;
      pointer-events:none !important;
    }
    body.teen-system-classic_glass.teen-patti-premium-popup .audio-popup.show::before{
      animation:none !important;
      transform:none !important;
    }
    body.teen-system-classic_glass.teen-patti-premium-popup .audio-popup::after{
      content:none !important;
      display:none !important;
    }
    body.teen-system-classic_glass.teen-patti-premium-popup .audio-popup-shell{
      position:absolute !important;
      inset:calc(var(--teen-audio-window-top) + 2px) calc(var(--teen-audio-window-side) + 6px) calc(var(--teen-audio-window-bottom) + 12px) calc(var(--teen-audio-window-side) + 6px) !important;
      margin:0 !important;
      padding:10px 10px 18px !important;
      border-radius:0 !important;
      background:transparent !important;
      box-shadow:none !important;
      display:flex !important;
      flex-direction:column !important;
      gap:8px !important;
      justify-content:flex-start !important;
      z-index:2 !important;
    }
    body.teen-system-classic_glass.teen-patti-premium-popup .audio-popup-header{
      flex-direction:column !important;
      align-items:center !important;
      gap:8px !important;
      text-align:center !important;
    }
    body.teen-system-classic_glass.teen-patti-premium-popup .audio-popup-icon{
      width:38px !important;
      height:38px !important;
      border-radius:13px !important;
      box-shadow:0 10px 18px rgba(0,0,0,.28), 0 0 16px rgba(255,215,110,.22) !important;
    }
    body.teen-system-classic_glass.teen-patti-premium-popup .audio-popup h3{font-size:clamp(.94rem, 3vw, 1.18rem) !important;letter-spacing:.12em !important}
    body.teen-system-classic_glass.teen-patti-premium-popup .audio-popup p{margin-top:1px !important;font-size:.54rem !important;letter-spacing:.22em !important}
    body.teen-system-classic_glass.teen-patti-premium-popup .audio-controls{gap:8px !important}
    body.teen-system-classic_glass.teen-patti-premium-popup .audio-popup .toggle{
      min-height:42px !important;
      padding:7px 10px !important;
      border-radius:14px !important;
      border-color:rgba(255,236,176,.20) !important;
      background:linear-gradient(145deg, rgba(9,18,28,.28), rgba(255,255,255,.02)) !important;
      box-shadow:inset 0 1px 0 rgba(255,255,255,.04) !important;
    }
    body.teen-system-classic_glass.teen-patti-premium-popup .audio-popup .toggle.on{
      border-color:rgba(130,255,193,.24) !important;
      background:linear-gradient(145deg, rgba(24,72,50,.24), rgba(255,255,255,.03)) !important;
      box-shadow:inset 0 1px 0 rgba(255,255,255,.05), 0 0 0 1px rgba(90,226,158,.05) !important;
    }
    body.teen-system-classic_glass.teen-patti-premium-popup .toggle-copy{grid-template-columns:20px 1fr !important;column-gap:8px !important}
    body.teen-system-classic_glass.teen-patti-premium-popup .toggle-copy i{font-size:.88rem !important}
    body.teen-system-classic_glass.teen-patti-premium-popup .toggle-copy strong{font-size:.74rem !important}
    body.teen-system-classic_glass.teen-patti-premium-popup .toggle-copy small{font-size:.5rem !important;letter-spacing:.08em !important}
    body.teen-system-classic_glass.teen-patti-premium-popup .toggle-switch{width:40px !important;height:22px !important}
    body.teen-system-classic_glass.teen-patti-premium-popup .toggle.on .toggle-switch span{transform:translateX(18px) !important}
    body.teen-system-classic_glass.teen-patti-premium-popup .close-audio-btn{
      position:absolute !important;
      top:calc(-1 * var(--teen-audio-window-top) + 8px) !important;
      right:calc(-1 * var(--teen-audio-window-side) + 2px) !important;
      width:58px !important;
      height:58px !important;
      min-width:0 !important;
      margin:0 !important;
      padding:0 !important;
      border:0 !important;
      border-radius:999px !important;
      background:transparent !important;
      box-shadow:none !important;
      color:transparent !important;
      font-size:0 !important;
      z-index:3 !important;
    }
    body.teen-system-classic_glass.teen-patti-premium-popup .close-audio-btn i,
    body.teen-system-classic_glass.teen-patti-premium-popup .close-audio-btn span{display:none !important}
    body.teen-system-classic_glass.teen-patti-premium-popup .popup-powered{
      margin-top:auto !important;
      padding-top:4px !important;
      font-size:7px !important;
      opacity:.05 !important;
      line-height:1.05 !important;
      letter-spacing:.12em !important;
      color:rgba(255,241,188,.92) !important;
      text-shadow:0 1px 5px rgba(0,0,0,.42) !important;
    }
    body.teen-system-classic_glass.teen-patti-premium-popup .utility-modal .modal-card::before{
      content:none !important;
      display:none !important;
      inset:auto !important;
      border-radius:0 !important;
      background:none !important;
    }
    body.teen-patti-premium-popup .modal{
      background:var(--teen-popup-overlay);
      backdrop-filter:blur(10px) saturate(118%);
      -webkit-backdrop-filter:blur(10px) saturate(118%);
    }
    body.teen-patti-premium-popup .modal-card{
      width:min(92vw, var(--teen-popup-modal-width)) !important;
      min-height:var(--teen-popup-modal-min-height) !important;
      padding:calc(var(--teen-popup-modal-pad-top) + 24px) 30px calc(var(--teen-popup-modal-pad-bottom) - 2px) !important;
      border:0 !important;
      border-radius:34px !important;
      background-color:transparent !important;
      background-image:var(--teen-popup-frame) !important;
      background-position:center center !important;
      background-repeat:no-repeat !important;
      background-size:100% 100% !important;
      box-shadow:var(--teen-popup-shell-shadow) !important;
      overflow:visible;
      isolation:isolate;
      position:relative;
      display:flex;
      flex-direction:column;
      justify-content:flex-start;
      text-align:center;
      backdrop-filter:none;
      -webkit-backdrop-filter:none;
    }
    body.teen-patti-premium-popup .modal-card::before{
      content:none !important;
      display:none !important;
    }
    body.teen-patti-premium-popup .modal-card::after{
      content:'' !important;
      display:block !important;
      position:absolute;
      inset:0;
      z-index:4;
      background:var(--teen-popup-frame) center center / 100% 100% no-repeat !important;
      pointer-events:none;
    }
    body.teen-patti-premium-popup .modal:not(.utility-modal) .modal-card{
      --teen-modal-window-top:clamp(102px, 28%, 124px);
      --teen-modal-window-side:clamp(16px, 5.2%, 26px);
      --teen-modal-window-bottom:clamp(36px, 11%, 50px);
    }
    body.teen-patti-premium-popup .modal:not(.utility-modal) .modal-card::before{
      content:'' !important;
      display:block !important;
      position:absolute;
      z-index:1;
      inset:calc(var(--teen-modal-window-top) + 2px) calc(var(--teen-modal-window-side) + 5px) calc(var(--teen-modal-window-bottom) + 10px) calc(var(--teen-modal-window-side) + 5px);
      border-radius:30px 30px 24px 24px;
      background:
        radial-gradient(circle at 50% 0%, rgba(255,255,255,.14), transparent 30%),
        linear-gradient(180deg, rgba(255,255,255,.10), rgba(255,255,255,0) 18%, rgba(255,255,255,.03) 72%, rgba(0,0,0,.08) 100%),
        var(--teen-popup-surface);
      border:1px solid rgba(255,240,208,.10);
      box-shadow:inset 0 1px 0 rgba(255,255,255,.16), 0 16px 28px rgba(0,0,0,.24);
      pointer-events:none;
    }
    body.teen-patti-premium-popup .modal:not(.utility-modal) .modal-card::after{
      content:'' !important;
      display:block !important;
      position:absolute;
      z-index:1;
      inset:calc(var(--teen-modal-window-top) - 7px) calc(var(--teen-modal-window-side) + 22px) auto;
      height:68px;
      border-radius:24px 24px 18px 18px;
      background:
        radial-gradient(circle at 50% 0%, rgba(255,255,255,.20), transparent 64%),
        linear-gradient(180deg, rgba(255,255,255,.12), rgba(255,255,255,0));
      opacity:.74;
      pointer-events:none;
    }
    body.teen-patti-premium-popup .modal-card > *{
      position:relative;
      z-index:2;
    }
    body.teen-patti-premium-popup .modal-card h2{
      margin:0 0 10px;
      font-family:var(--teen-popup-title-font);
      font-size:clamp(2rem, 6.2vw, 3rem);
      font-weight:800;
      line-height:.92;
      letter-spacing:.12em;
      text-indent:.12em;
      text-transform:uppercase;
      color:var(--teen-popup-title);
      background:none;
      -webkit-background-clip:border-box;
      background-clip:border-box;
      text-shadow:0 3px 18px rgba(0,0,0,.42), 0 0 24px rgba(255,223,145,.20);
    }
    body.teen-patti-premium-popup .modal-card p{
      margin:0 auto;
      max-width:248px;
      font-family:var(--teen-popup-copy-font);
      font-size:.76rem;
      font-weight:700;
      line-height:1.55;
      letter-spacing:.16em;
      text-transform:uppercase;
      color:var(--teen-popup-copy);
    }
    body.teen-patti-premium-popup .modal-card .popup-kicker{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      margin:0 auto 14px;
      min-width:168px;
      padding:9px 22px 10px;
      border-radius:999px;
      background:linear-gradient(180deg, rgba(255,255,255,.11), rgba(255,255,255,0) 34%), linear-gradient(145deg, rgba(10,58,42,.94), rgba(4,27,19,.94));
      border:1px solid rgba(255,229,162,.30);
      box-shadow:0 14px 24px rgba(0,0,0,.22), inset 0 1px 0 rgba(255,255,255,.14);
      font-family:var(--teen-popup-kicker-font);
      font-size:.68rem;
      font-weight:700;
      letter-spacing:.26em;
      text-transform:uppercase;
      color:rgba(255,241,205,.90);
    }
    body.teen-patti-premium-popup .modal-card .popup-accent{
      width:116px;
      height:8px;
      margin:0 auto 18px;
      border-radius:999px;
      background:var(--teen-popup-accent);
      box-shadow:0 0 18px rgba(255,215,110,.28);
    }
    body.teen-patti-premium-popup .modal-card .popup-icon{
      width:62px;
      height:62px;
      margin:0 auto 18px;
      border-radius:20px;
      display:grid;
      place-items:center;
      font-size:1.62rem;
      background:var(--teen-popup-icon-bg);
      border:1px solid var(--teen-popup-icon-border);
      color:var(--teen-popup-icon-color);
      box-shadow:inset 0 1px 0 rgba(255,255,255,.16),0 14px 26px rgba(0,0,0,.28),0 0 20px rgba(255,215,110,.18);
    }
    body.teen-patti-premium-popup .modal-card .popup-icon i{
      line-height:1;
      filter:drop-shadow(0 2px 6px rgba(0,0,0,.24));
    }
    body.teen-patti-premium-popup .modal-card .popup-note{
      margin-top:18px;
      padding:13px 18px;
      border-radius:999px;
      background:linear-gradient(180deg, rgba(255,255,255,.10), rgba(255,255,255,0) 44%), var(--teen-popup-note-bg);
      border:1px solid var(--teen-popup-note-border);
      color:var(--teen-popup-note-text);
      font-family:var(--teen-popup-copy-font);
      font-size:.72rem;
      font-weight:700;
      letter-spacing:.12em;
      text-transform:uppercase;
      box-shadow:0 16px 24px rgba(0,0,0,.18), inset 0 1px 0 rgba(255,255,255,.10);
    }
    body.teen-patti-premium-popup .popup-powered{
      margin-top:auto;
      padding-top:6px;
      font-family:var(--teen-popup-kicker-font);
      font-size:7px;
      opacity:.05;
      line-height:1.05;
      font-weight:700;
      letter-spacing:.12em;
      text-transform:uppercase;
      color:rgba(255,241,205,.92);
      text-align:center;
    }
    body.teen-patti-premium-popup .start-pop{--teen-phase-popup-color:#9dffca;--teen-phase-popup-glow:rgba(82,232,138,.28);--teen-phase-popup-accent:linear-gradient(90deg, #67f5b2, #fff0b8, #2fd58d)}
    body.teen-patti-premium-popup .stop-pop{--teen-phase-popup-color:#ffd387;--teen-phase-popup-glow:rgba(255,176,78,.28);--teen-phase-popup-accent:linear-gradient(90deg, #ffd46e, #ff9d49, #fff0bd)}
    body.teen-patti-premium-popup .winner-pop{--teen-phase-popup-color:#ffe9a0;--teen-phase-popup-glow:rgba(255,215,110,.34);--teen-phase-popup-accent:linear-gradient(90deg, #fff0b7, #ffd36e, #ffb55d)}
    body.teen-patti-premium-popup .loser-pop,
    body.teen-patti-premium-popup .loss-pop{--teen-phase-popup-color:#ffadb7;--teen-phase-popup-glow:rgba(255,110,146,.28);--teen-phase-popup-accent:linear-gradient(90deg, #ffb1be, #ff706a, #ffd2a9)}
    body.teen-patti-premium-popup .nobid-pop{--teen-phase-popup-color:#d6b7ff;--teen-phase-popup-glow:rgba(157,117,255,.28);--teen-phase-popup-accent:linear-gradient(90deg, #d6b7ff, #8d67ff, #ffd9a8)}
    body.teen-patti-premium-popup .go-pop{--teen-phase-popup-color:#8fd6ff;--teen-phase-popup-glow:rgba(111,214,255,.28);--teen-phase-popup-accent:linear-gradient(90deg, #8fd6ff, #ffd36f, #7ef0ff)}
    body.teen-patti-premium-popup .start-pop .popup-icon,
    body.teen-patti-premium-popup .stop-pop .popup-icon,
    body.teen-patti-premium-popup .winner-pop .popup-icon,
    body.teen-patti-premium-popup .loser-pop .popup-icon,
    body.teen-patti-premium-popup .loss-pop .popup-icon,
    body.teen-patti-premium-popup .nobid-pop .popup-icon,
    body.teen-patti-premium-popup .go-pop .popup-icon{
      color:var(--teen-phase-popup-color);
      box-shadow:inset 0 1px 0 rgba(255,255,255,.16),0 14px 26px rgba(0,0,0,.28),0 0 24px var(--teen-phase-popup-glow);
    }
    body.teen-patti-premium-popup .start-pop .popup-accent,
    body.teen-patti-premium-popup .stop-pop .popup-accent,
    body.teen-patti-premium-popup .winner-pop .popup-accent,
    body.teen-patti-premium-popup .loser-pop .popup-accent,
    body.teen-patti-premium-popup .loss-pop .popup-accent,
    body.teen-patti-premium-popup .nobid-pop .popup-accent,
    body.teen-patti-premium-popup .go-pop .popup-accent{
      background:var(--teen-phase-popup-accent);
      box-shadow:0 0 20px var(--teen-phase-popup-glow);
    }
    body.teen-patti-premium-popup .start-pop .modal-card::before,
    body.teen-patti-premium-popup .stop-pop .modal-card::before,
    body.teen-patti-premium-popup .winner-pop .modal-card::before,
    body.teen-patti-premium-popup .loser-pop .modal-card::before,
    body.teen-patti-premium-popup .loss-pop .modal-card::before,
    body.teen-patti-premium-popup .nobid-pop .modal-card::before,
    body.teen-patti-premium-popup .go-pop .modal-card::before{
      box-shadow:inset 0 1px 0 rgba(255,255,255,.18), 0 18px 30px rgba(0,0,0,.26), 0 0 24px var(--teen-phase-popup-glow);
    }
    body.teen-patti-premium-popup .start-pop .modal-card h2,
    body.teen-patti-premium-popup .stop-pop .modal-card h2,
    body.teen-patti-premium-popup .winner-pop .modal-card h2,
    body.teen-patti-premium-popup .loser-pop .modal-card h2,
    body.teen-patti-premium-popup .loss-pop .modal-card h2,
    body.teen-patti-premium-popup .nobid-pop .modal-card h2,
    body.teen-patti-premium-popup .go-pop .modal-card h2{
      color:var(--teen-phase-popup-color);
      text-shadow:0 4px 18px rgba(0,0,0,.44), 0 0 26px var(--teen-phase-popup-glow);
    }
    body.teen-patti-premium-popup .winner-pop .modal-card h2{
      letter-spacing:.08em;
    }
    body.teen-patti-premium-popup .audio-popup{
      --teen-audio-window-top:clamp(82px, 24%, 96px);
      --teen-audio-window-side:clamp(16px, 5.8%, 28px);
      --teen-audio-window-bottom:clamp(38px, 12%, 52px);
      width:min(96vw, var(--teen-popup-audio-width));
      max-width:var(--teen-popup-audio-width);
      min-height:0;
      height:auto;
      aspect-ratio:1.16;
      max-height:min(88dvh, 372px);
      top:50%;
      bottom:auto;
      transform:translate(-50%, -50%) scale(.96);
      padding:0;
      border:0;
      border-radius:34px;
      background-color:transparent !important;
      background-image:var(--teen-popup-frame) !important;
      background-position:center center !important;
      background-repeat:no-repeat !important;
      background-size:100% 100% !important;
      box-shadow:var(--teen-popup-shell-shadow);
      overflow:visible;
      position:relative;
      backdrop-filter:none;
      -webkit-backdrop-filter:none;
    }
    body.teen-patti-premium-popup .audio-popup::before{
      content:'' !important;
      display:block !important;
      position:absolute;
      inset:0;
      z-index:4;
      background:var(--teen-popup-frame) center center / 100% 100% no-repeat !important;
      pointer-events:none;
    }
    body.teen-patti-premium-popup .audio-popup-shell{
      position:absolute;
      z-index:2;
      inset:calc(var(--teen-audio-window-top) + 2px) calc(var(--teen-audio-window-side) + 6px) calc(var(--teen-audio-window-bottom) + 12px) calc(var(--teen-audio-window-side) + 6px);
      margin:0;
      padding:10px 10px 18px;
      border-radius:0;
      background:transparent !important;
      box-shadow:none !important;
      display:flex;
      flex-direction:column;
      justify-content:flex-start;
      gap:8px;
    }
    body.teen-patti-premium-popup .close-audio-btn,
    body.teen-patti-premium-popup .popup-powered,
    body.teen-system-classic_glass.teen-patti-premium-popup .close-audio-btn,
    body.teen-system-classic_glass.teen-patti-premium-popup .popup-powered{
      position:relative;
      z-index:5 !important;
    }
    body.teen-patti-premium-popup .audio-popup.show{
      transform:translate(-50%, -50%) scale(1);
    }
    body.teen-patti-premium-popup .audio-popup-header{
      flex-direction:column;
      align-items:center;
      gap:8px;
      text-align:center;
    }
    body.teen-patti-premium-popup .audio-popup h3{
      margin:0;
      font-family:var(--teen-popup-title-font);
      font-size:clamp(.94rem, 3vw, 1.18rem);
      line-height:1.05;
      letter-spacing:.12em;
      text-transform:uppercase;
      color:var(--teen-popup-title);
      text-shadow:0 2px 12px rgba(0,0,0,.35);
    }
    body.teen-patti-premium-popup .audio-popup p{
      margin:1px 0 0;
      font-family:var(--teen-popup-copy-font);
      color:var(--teen-popup-copy-soft);
      font-size:.54rem;
      letter-spacing:.22em;
      text-transform:uppercase;
    }
    body.teen-patti-premium-popup .audio-popup-icon{
      width:38px;
      height:38px;
      border-radius:13px;
      background:var(--teen-popup-icon-bg);
      border-color:var(--teen-popup-icon-border);
      color:var(--teen-popup-icon-color);
      box-shadow:inset 0 1px 0 rgba(255,255,255,.16),0 12px 24px rgba(0,0,0,.26),0 0 22px rgba(255,215,110,.16);
    }
    body.teen-patti-premium-popup .audio-popup .toggle{
      background:var(--teen-popup-toggle-off);
      border-color:var(--teen-popup-toggle-border);
      color:var(--teen-popup-copy);
      box-shadow:inset 0 1px 0 rgba(255,255,255,.08);
    }
    body.teen-patti-premium-popup .audio-popup .toggle.on{
      background:var(--teen-popup-toggle-on);
      border-color:transparent;
      color:#fff7d2;
      box-shadow:0 12px 22px rgba(0,0,0,.22),0 0 20px rgba(255,215,110,.20);
    }
    body.teen-patti-premium-popup .toggle-copy strong,
    body.teen-patti-premium-popup .toggle-copy small{
      font-family:var(--teen-popup-copy-font);
    }
    body.teen-patti-premium-popup .close-modal-btn{
      background:var(--teen-popup-close-bg);
      border:1px solid var(--teen-popup-close-border);
      color:var(--teen-popup-close-text);
      font-family:var(--teen-popup-kicker-font);
      font-size:.76rem;
      font-weight:700;
      letter-spacing:.14em;
      text-transform:uppercase;
      box-shadow:0 14px 24px rgba(0,0,0,.22), inset 0 1px 0 rgba(255,255,255,.10);
    }
    body.teen-patti-premium-popup .close-audio-btn{
      position:absolute;
      top:calc(-1 * var(--teen-audio-window-top) + 8px);
      right:calc(-1 * var(--teen-audio-window-side) + 2px);
      width:58px;
      height:58px;
      min-width:0;
      margin:0;
      padding:0;
      border:0;
      border-radius:999px;
      background:transparent !important;
      box-shadow:none !important;
      color:transparent !important;
      font-size:0 !important;
      line-height:0 !important;
      z-index:3;
      cursor:pointer;
    }
    body.teen-patti-premium-popup .close-audio-btn i,
    body.teen-patti-premium-popup .close-audio-btn span{
      display:none !important;
    }
    body.teen-patti-premium-popup .utility-modal{
      background:var(--teen-popup-overlay) !important;
      backdrop-filter:blur(11px) saturate(120%) !important;
      -webkit-backdrop-filter:blur(11px) saturate(120%) !important;
    }
    body.teen-patti-premium-popup .utility-modal .modal-card{
      width:min(96vw, var(--teen-popup-utility-width)) !important;
      max-width:var(--teen-popup-utility-width) !important;
      min-height:var(--teen-popup-utility-min-height) !important;
      max-height:min(88dvh, 760px) !important;
      padding:calc(var(--teen-popup-utility-pad-top) + 18px) 26px calc(var(--teen-popup-utility-pad-bottom) - 6px) !important;
      background-color:transparent !important;
      background-image:var(--teen-popup-frame) !important;
      background-position:center center !important;
      background-repeat:no-repeat !important;
      background-size:100% 100% !important;
      text-align:left !important;
      gap:14px !important;
      justify-content:flex-start !important;
      overflow:visible !important;
    }
    body.teen-patti-premium-popup .utility-modal .modal-card::before{
      content:none !important;
      display:none !important;
    }
    body.teen-patti-premium-popup .utility-modal .modal-card::after{
      content:none !important;
      display:none !important;
    }
    body.teen-patti-premium-popup .utility-modal .modal-card h3{
      margin:0 !important;
      text-align:center !important;
      font-family:var(--teen-popup-title-font) !important;
      font-size:clamp(1.14rem, 3vw, 1.68rem) !important;
      letter-spacing:.08em !important;
      text-transform:uppercase !important;
      color:var(--teen-popup-title) !important;
      text-shadow:0 2px 12px rgba(0,0,0,.35);
    }
    body.teen-patti-premium-popup .utility-modal .utility-list{
      padding-right:6px !important;
    }
    body.teen-patti-premium-popup .utility-modal .close-modal-btn{
      position:absolute !important;
      top:40px !important;
      right:16px !important;
      width:64px !important;
      height:64px !important;
      min-width:0 !important;
      margin:0 !important;
      padding:0 !important;
      border:0 !important;
      border-radius:999px !important;
      background:transparent !important;
      box-shadow:none !important;
      color:transparent !important;
      font-size:0 !important;
      line-height:0 !important;
      z-index:4 !important;
      cursor:pointer !important;
    }
    body.teen-patti-premium-popup .utility-modal .utility-item,
    body.teen-patti-premium-popup .utility-modal .history-table-wrap,
    body.teen-patti-premium-popup .utility-modal .history-table-empty{
      background:var(--teen-popup-note-bg) !important;
      border:1px solid var(--teen-popup-note-border) !important;
      box-shadow:inset 0 1px 0 rgba(255,255,255,.06);
    }
    body.teen-patti-premium-popup .utility-modal .utility-item strong,
    body.teen-patti-premium-popup .utility-modal .history-table,
    body.teen-patti-premium-popup .utility-modal .history-trace-cell{
      font-family:var(--teen-popup-copy-font) !important;
      color:var(--teen-popup-copy) !important;
    }
    body.teen-patti-premium-popup .utility-modal .utility-item span,
    body.teen-patti-premium-popup .utility-modal .history-table-empty{
      color:var(--teen-popup-copy-soft) !important;
      font-family:var(--teen-popup-copy-font) !important;
    }
    body.teen-patti-premium-popup .utility-modal .history-table th{
      background:rgba(9,12,22,.88) !important;
      color:var(--teen-popup-title) !important;
      font-family:var(--teen-popup-kicker-font) !important;
    }
    body.teen-patti-premium-popup .utility-modal .history-status.win{
      background:rgba(82,232,138,.14);
      color:#8dffc0;
      border-color:rgba(82,232,138,.24);
    }
    body.teen-patti-premium-popup .utility-modal .history-status.loss{
      background:rgba(255,110,146,.14);
      color:#ffb8c6;
      border-color:rgba(255,110,146,.24);
    }
    body.teen-patti-premium-popup .utility-modal .history-status.pending{
      background:rgba(255,215,110,.16);
      color:#ffe7a1;
      border-color:rgba(255,215,110,.22);
    }
    body.teen-patti-premium-popup .utility-modal .history-status.punishment{
      background:rgba(121,214,255,.14);
      color:#c6edff;
      border-color:rgba(121,214,255,.24);
    }
    @media (max-width: 480px){
      body.teen-patti-premium-popup .modal-card{
        width:min(94vw, 340px) !important;
        min-height:286px !important;
        padding:118px 22px 58px !important;
      }
      body.teen-patti-premium-popup .modal:not(.utility-modal) .modal-card{
        --teen-modal-window-top:88px !important;
        --teen-modal-window-side:12px !important;
        --teen-modal-window-bottom:14px !important;
      }
      body.teen-patti-premium-popup .modal:not(.utility-modal) .modal-card::before{
        inset:calc(var(--teen-modal-window-top) + 2px) calc(var(--teen-modal-window-side) + 4px) calc(var(--teen-modal-window-bottom) + 6px) calc(var(--teen-modal-window-side) + 4px) !important;
        border-radius:24px 24px 18px 18px !important;
      }
      body.teen-patti-premium-popup .modal:not(.utility-modal) .modal-card::after{
        inset:calc(var(--teen-modal-window-top) - 8px) calc(var(--teen-modal-window-side) + 18px) auto !important;
        height:56px !important;
      }
      body.teen-patti-premium-popup .audio-popup{
        width:min(95vw, 352px);
        min-height:304px;
      }
      body.teen-patti-premium-popup .audio-popup::before{
        inset:94px 14px 18px;
      }
      body.teen-patti-premium-popup .audio-popup-shell{
        margin:94px 14px 18px;
        padding:20px 14px 14px;
      }
      body.teen-patti-premium-popup .utility-modal .modal-card{
        width:min(96vw, 366px) !important;
        padding:124px 20px 64px !important;
      }
      body.teen-patti-premium-popup .utility-modal .modal-card::before{
        inset:90px 16px 18px;
      }
      body.teen-patti-premium-popup .utility-modal .modal-card::after{
        inset:38px 26px auto;
        height:88px;
      }
    }
    @media (max-width: 390px){
      body.teen-patti-premium-popup .modal-card h2{
        font-size:1.72rem;
      }
      body.teen-patti-premium-popup .modal-card p{
        font-size:.8rem;
      }
      body.teen-patti-premium-popup .modal-card .popup-note{
        font-size:.66rem;
        padding:10px 12px;
      }
      body.teen-patti-premium-popup .audio-popup-shell{
        margin:90px 10px 12px;
        padding:18px 12px 14px;
      }
      body.teen-patti-premium-popup .audio-popup h3,
      body.teen-patti-premium-popup .utility-modal .modal-card h3{
        font-size:1.05rem !important;
      }
    }
    @media (max-height: 450px){
      body.teen-patti-premium-popup .modal-card{
        width:min(86vw, 294px) !important;
        min-height:224px !important;
        padding:80px 14px 28px !important;
      }
      body.teen-patti-premium-popup .modal:not(.utility-modal) .modal-card{
        --teen-modal-window-top:62px !important;
        --teen-modal-window-side:9px !important;
        --teen-modal-window-bottom:8px !important;
      }
      body.teen-patti-premium-popup .modal:not(.utility-modal) .modal-card::before{
        inset:calc(var(--teen-modal-window-top) + 2px) calc(var(--teen-modal-window-side) + 4px) calc(var(--teen-modal-window-bottom) + 6px) calc(var(--teen-modal-window-side) + 4px) !important;
        border-radius:18px 18px 14px 14px !important;
      }
      body.teen-patti-premium-popup .modal:not(.utility-modal) .modal-card::after{
        inset:calc(var(--teen-modal-window-top) - 5px) calc(var(--teen-modal-window-side) + 16px) auto !important;
        height:42px !important;
        border-radius:18px 18px 12px 12px !important;
      }
      body.teen-patti-premium-popup .modal-card h2{
        margin:0 0 5px !important;
        font-size:clamp(1.42rem, 5.8vw, 1.96rem) !important;
        letter-spacing:.08em !important;
        text-indent:.08em !important;
      }
      body.teen-patti-premium-popup .modal-card p{
        max-width:196px !important;
        font-size:.61rem !important;
        line-height:1.28 !important;
        letter-spacing:.1em !important;
      }
      body.teen-patti-premium-popup .modal-card .popup-kicker{
        min-width:118px !important;
        margin:0 auto 8px !important;
        padding:5px 12px 6px !important;
        font-size:.5rem !important;
        letter-spacing:.16em !important;
      }
      body.teen-patti-premium-popup .modal-card .popup-accent{
        width:80px !important;
        height:4px !important;
        margin:0 auto 10px !important;
      }
      body.teen-patti-premium-popup .modal-card .popup-icon{
        width:42px !important;
        height:42px !important;
        margin:0 auto 10px !important;
        font-size:1.08rem !important;
      }
      body.teen-patti-premium-popup .modal-card .popup-note{
        margin-top:8px !important;
        padding:7px 9px !important;
        font-size:.54rem !important;
        line-height:1.22 !important;
        letter-spacing:.06em !important;
      }
      body.teen-patti-premium-popup .popup-powered{
        position:absolute !important;
        left:50% !important;
        bottom:12px !important;
        transform:translateX(-50%) !important;
        margin:0 !important;
        width:max-content !important;
        max-width:72% !important;
        padding-top:3px !important;
        font-size:7px !important;
        opacity:.05 !important;
        letter-spacing:.1em !important;
        white-space:nowrap !important;
        z-index:3 !important;
        pointer-events:none !important;
      }
      body.teen-patti-premium-popup .audio-popup{
        --teen-audio-window-top:58px !important;
        --teen-audio-window-side:9px !important;
        --teen-audio-window-bottom:12px !important;
        width:min(86vw, 306px) !important;
        min-height:0 !important;
        height:auto !important;
        max-height:min(82dvh, 258px) !important;
      }
      body.teen-patti-premium-popup .audio-popup-shell{
        inset:calc(var(--teen-audio-window-top) + 2px) calc(var(--teen-audio-window-side) + 4px) calc(var(--teen-audio-window-bottom) + 6px) calc(var(--teen-audio-window-side) + 4px) !important;
        margin:0 !important;
        padding:6px 6px 12px !important;
        gap:4px !important;
      }
      body.teen-patti-premium-popup .audio-popup-header{
        gap:4px !important;
      }
      body.teen-patti-premium-popup .audio-popup-icon{
        width:28px !important;
        height:28px !important;
        border-radius:9px !important;
        font-size:.8rem !important;
      }
      body.teen-patti-premium-popup .audio-popup h3{
        font-size:.8rem !important;
        letter-spacing:.06em !important;
      }
      body.teen-patti-premium-popup .audio-popup p{
        margin-top:1px !important;
        font-size:.42rem !important;
        letter-spacing:.12em !important;
      }
      body.teen-patti-premium-popup .audio-popup .toggle{
        min-height:26px !important;
        padding:4px 7px !important;
        border-radius:11px !important;
      }
      body.teen-patti-premium-popup .toggle-copy{
        grid-template-columns:16px 1fr !important;
        column-gap:5px !important;
      }
      body.teen-patti-premium-popup .toggle-copy i{
        font-size:.72rem !important;
      }
      body.teen-patti-premium-popup .toggle-copy strong{
        font-size:.52rem !important;
      }
      body.teen-patti-premium-popup .toggle-copy small{
        display:none !important;
      }
      body.teen-patti-premium-popup .toggle-switch{
        width:26px !important;
        height:15px !important;
        padding:2px !important;
      }
      body.teen-patti-premium-popup .toggle-switch span{
        width:9px !important;
        height:9px !important;
      }
      body.teen-patti-premium-popup .toggle.on .toggle-switch span{
        transform:translateX(11px) !important;
      }
      body.teen-patti-premium-popup .close-audio-btn{
        top:-2px !important;
        right:-2px !important;
        width:48px !important;
        height:48px !important;
      }
      body.teen-patti-premium-popup .audio-popup .popup-powered,
      body.teen-patti-premium-popup .utility-modal .popup-powered{
        position:relative !important;
        left:auto !important;
        bottom:auto !important;
        transform:none !important;
        width:100% !important;
        max-width:100% !important;
        margin-top:auto !important;
        padding-top:4px !important;
        white-space:normal !important;
        text-align:center !important;
      }
      body.teen-patti-premium-popup .utility-modal .modal-card{
        width:min(86vw, 306px) !important;
        min-height:238px !important;
        max-height:min(82dvh, 286px) !important;
        padding:86px 12px 24px !important;
      }
      body.teen-patti-premium-popup .utility-modal .modal-card h3{
        font-size:.88rem !important;
        letter-spacing:.06em !important;
      }
      body.teen-patti-premium-popup .utility-modal .utility-list{
        max-height:108px !important;
        padding-right:2px !important;
      }
      body.teen-patti-premium-popup .utility-modal .utility-item,
      body.teen-patti-premium-popup .utility-modal .history-table-wrap,
      body.teen-patti-premium-popup .utility-modal .history-table-empty{
        border-radius:14px !important;
      }
      body.teen-patti-premium-popup .utility-modal .history-table{
        font-size:10px !important;
      }
      body.teen-patti-premium-popup .utility-modal .history-table th,
      body.teen-patti-premium-popup .utility-modal .history-table td{
        padding:6px 5px !important;
      }
      body.teen-patti-premium-popup .utility-modal .close-modal-btn{
        top:32px !important;
        right:10px !important;
        width:56px !important;
        height:56px !important;
      }
      body.teen-system-classic_glass.teen-patti-premium-popup .audio-popup{
        --teen-audio-window-top:64px;
        --teen-audio-window-side:10px;
        --teen-audio-window-bottom:16px;
        width:min(90vw, 320px) !important;
        max-height:min(84dvh, 272px) !important;
      }
      body.teen-system-classic_glass.teen-patti-premium-popup .audio-popup-shell{
        inset:calc(var(--teen-audio-window-top) + 2px) calc(var(--teen-audio-window-side) + 4px) calc(var(--teen-audio-window-bottom) + 6px) calc(var(--teen-audio-window-side) + 4px) !important;
        padding:7px 7px 4px !important;
        gap:4px !important;
      }
      body.teen-system-classic_glass.teen-patti-premium-popup .audio-popup-icon{
        width:30px !important;
        height:30px !important;
      }
      body.teen-system-classic_glass.teen-patti-premium-popup .audio-popup h3{
        font-size:.82rem !important;
      }
      body.teen-system-classic_glass.teen-patti-premium-popup .audio-popup p{
        font-size:.44rem !important;
      }
      body.teen-system-classic_glass.teen-patti-premium-popup .audio-popup .toggle{
        min-height:27px !important;
        padding:4px 7px !important;
      }
      body.teen-system-classic_glass.teen-patti-premium-popup .toggle-copy strong{
        font-size:.54rem !important;
      }
      body.teen-system-classic_glass.teen-patti-premium-popup .toggle-copy small{
        display:none !important;
      }
      body.teen-system-classic_glass.teen-patti-premium-popup .close-audio-btn{
        top:-4px !important;
        right:-2px !important;
        width:52px !important;
        height:52px !important;
      }
      body.teen-system-classic_glass.teen-patti-premium-popup .popup-powered{
        padding-top:2px !important;
        bottom:8px !important;
      }
    }
    .icon-btn,.tool-btn{flex:0 0 auto}
    .chips-bar .chip,.chips-bar .tool-btn{pointer-events:auto}
    .toast-notification{top:280px;bottom:auto}
    .floating-banner{bottom:84px}
    @media (max-height: 740px){
      .top-stack{top:62px}
      .timer-orb{width:98px;height:98px}
      .timer-value{font-size:2.15rem}
      .bottom-stack{bottom:68px;gap:2px}
      .pot{min-height:126px}
      .chair{width:64px;margin-bottom:-13px}
      .cards{height:72px}
      .card{width:48px;height:68px}
      .board{min-height:86px;padding:9px 5px 7px}
    }
    @media (max-height: 620px){
      .top-bar{padding:6px 8px}
      .top-stack{top:50px}
      .timer-orb{width:84px;height:84px}
      .timer-value{font-size:1.8rem}
      .timer-sub{font-size:.55rem;letter-spacing:1.2px}
      .bottom-stack{bottom:58px;gap:0}
      .pots,.boards{gap:6px}
      .pot{min-height:106px}
      .chair{width:54px;margin-bottom:-12px}
      .cards{height:60px}
      .card{width:40px;height:57px;border-radius:8px;margin-left:-11px}
      .hand-label{bottom:-8px;font-size:.48rem;padding:3px 8px}
      .pot-title{font-size:1rem;margin-top:2px}
      .board{min-height:74px;padding:7px 4px}
      .board-amount{font-size:.95rem}
      .won-amount{font-size:.82rem}
      .chips-bar{padding:6px 8px max(6px, env(safe-area-inset-bottom));gap:6px}
      .chip{width:42px;height:42px}
      .chip-face{width:40px;height:40px}
      .tool-btn{width:40px;height:40px;font-size:1rem}
    }



    @media (max-height: 450px){
      .top-bar{padding:5px 8px;min-height:52px}
      .coin-section,.user-section{padding:3px 7px}
      .coin-amount{font-size:.88rem;width:9.8ch;max-width:9.8ch}
      .user-name{font-size:.7rem;max-width:56px}
      .icon-btn{width:30px;height:30px}
      .top-stack{top:46px;padding-top:0;gap:2px}
      .status-strip{gap:5px}
      .status-pill{padding:4px 8px;font-size:.53rem;letter-spacing:.08em}
      .timer-orb{width:72px;height:72px;min-width:72px;min-height:72px}
      .timer-wrap::after{inset:12px}
      .timer-inner{inset:12px}
      .timer-value{font-size:1.45rem}
      .timer-sub{font-size:.45rem;letter-spacing:1px}
      .phase-banner{top:112px;font-size:.6rem;padding:5px 12px}
      .bottom-stack{bottom:54px;gap:0}
      .pots,.boards{gap:5px}
      .pot{min-height:92px;padding-top:4px}
      .chair{width:50px;margin-bottom:-11px}
      .cards{height:50px;min-height:50px}
      .card{width:38px;height:53px;min-width:38px;min-height:53px;margin-left:-10px;border-radius:8px}
      .card-corner.top-left{top:3px;left:4px}
      .card-corner.bottom-right{right:4px;bottom:3px}
      .rank{font-size:.56rem}
      .suit{font-size:.58rem}
      .center{font-size:.42rem}
      .center small{font-size:.32rem}
      .hand-label{bottom:-8px;font-size:.44rem;padding:2px 6px}
      .pot-title{font-size:.82rem;margin-top:1px}
      .board{min-height:70px;padding:6px 4px;border-radius:14px}
      .board-amount{font-size:.84rem}
      .won-amount{font-size:.72rem}
      .board-mini{font-size:.4rem}
      .chips-bar{padding:5px 8px max(5px, env(safe-area-inset-bottom));gap:5px;min-height:54px}
      .chip,.tool-btn{width:34px;height:34px;flex-basis:34px}
      .chip-face{width:32px;height:32px}
      .tool-btn{font-size:.72rem}
      .splash-logo{padding:9px 12px}
      .splash-title{font-size:1.08rem}
      .splash-sub{font-size:.52rem;letter-spacing:.12em}
      .splash-progress-wrap{width:min(92vw,260px)}
      .splash-log{font-size:.6rem;min-height:26px}
    }

    @media (max-width:480px){
      .loading-skeleton{padding:20px 16px}
      .splash-logo{padding:12px 16px;max-width:92vw}
      .splash-title{font-size:clamp(1.35rem,8.2vw,2rem)}
      .splash-sub{font-size:.62rem;letter-spacing:.22em}
      .skeleton-spinner{width:56px;height:56px}
      .splash-progress-wrap{width:min(88vw,320px)}
      .splash-log{font-size:.68rem;line-height:1.35;max-width:90vw}
      .status-strip{gap:6px}
      .status-pill{padding:6px 10px;font-size:.6rem}
      .chip-select-hud{max-width:min(72vw,240px)}
      .toast-notification{width:min(70vw,230px);font-size:.76rem}
    }

  

    /* V28 Next Step: popup emotion + timer luxury + chip psychology + deep audit */
    .timer-wrap::before{
      content:'';
      position:absolute;
      inset:-10px;
      border-radius:999px;
      pointer-events:none;
      opacity:0;
      background:radial-gradient(circle, rgba(255,215,110,.09) 0%, rgba(127,92,255,.06) 34%, transparent 68%);
      filter:blur(10px);
      transition:opacity .22s ease;
    }
    .timer-wrap.round-go::before,
    .timer-wrap.round-live::before{opacity:.9}
    .timer-wrap.round-go::after{
      background:radial-gradient(circle, rgba(255,215,110,.14) 0%, rgba(255,215,110,.08) 28%, rgba(255,215,110,0) 64%);
      animation:roundGoPulse .78s ease-in-out infinite;
    }
    .timer-wrap.round-live::after{
      border:1px solid rgba(255,255,255,.05);
      box-shadow:0 0 0 0 rgba(88,255,174,.18), 0 0 22px rgba(127,92,255,.10) inset;
      animation:roundLivePulse 1.08s ease-in-out infinite;
    }
    .timer-orb{
      width:108px;height:108px;
      filter:drop-shadow(0 10px 20px rgba(0,0,0,.34));
    }
    .timer-bg{
      background:
        radial-gradient(circle at 30% 28%, rgba(255,255,255,.10), rgba(0,0,0,.52)),
        linear-gradient(145deg, rgba(28,18,46,.96), rgba(10,5,20,.98));
      border:1.5px solid rgba(255,235,177,.16);
      box-shadow:inset 0 1px 0 rgba(255,255,255,.06), inset 0 -12px 22px rgba(0,0,0,.18);
    }
    .timer-progress{
      background:conic-gradient(var(--timer-color, #46e88a) calc(var(--p,1) * 360deg), rgba(255,255,255,.06) 0);
      mask:radial-gradient(circle, transparent 56%, #000 58%);
      filter:drop-shadow(0 0 10px color-mix(in srgb, var(--timer-color, #46e88a) 38%, transparent));
    }
    .timer-inner{
      inset:16px;
      background:
        radial-gradient(circle at 35% 30%, rgba(255,255,255,.16), rgba(11,6,22,.98)),
        linear-gradient(180deg, rgba(16,10,32,.98), rgba(7,4,14,.98));
      border:1px solid rgba(255,255,255,.05);
      box-shadow:inset 0 1px 0 rgba(255,255,255,.08), 0 0 0 1px rgba(255,215,110,.05);
    }
    .timer-inner::before{
      content:'';
      position:absolute;
      inset:8px;
      border-radius:50%;
      pointer-events:none;
      background:radial-gradient(circle at 50% 10%, rgba(255,255,255,.09), transparent 38%);
      mix-blend-mode:screen;
      opacity:.75;
    }
    .timer-value{font-size:2.7rem;letter-spacing:-.03em}
    .timer-value.phase-text{font-size:1.3rem;letter-spacing:.19em}
    .chips-bar{
      gap:10px;
      padding:9px 10px max(8px, env(safe-area-inset-bottom));
      background:
        linear-gradient(180deg, rgba(8,6,18,.92), rgba(6,4,14,.98)),
        radial-gradient(circle at 50% 0%, rgba(255,215,110,.13), transparent 44%);
      box-shadow:0 -16px 36px rgba(0,0,0,.36), inset 0 1px 0 rgba(255,255,255,.05);
    }
    .chip{
      width:60px;height:60px;
      transition:transform .18s ease, opacity .18s ease, filter .18s ease;
    }
    .chip-face{width:56px;height:56px;filter:drop-shadow(0 9px 14px rgba(0,0,0,.46))}
    .chip.live{opacity:1}
    .chip.live:active{transform:translateY(-4px) scale(1.035)}
    .chip.selected{transform:translateY(-5px) scale(1.08)}
    .chip.selected .chip-face{
      filter:drop-shadow(0 0 20px rgba(255,215,110,.44)) drop-shadow(0 0 12px rgba(120,210,255,.16)) drop-shadow(0 10px 16px rgba(0,0,0,.5));
      transform:translateY(-2px);
    }
    .chip.recent-hit::after{opacity:1;animation:chipRecentGlow 1.1s ease-in-out 1}
    @keyframes chipRecentGlow{0%{transform:scale(.9);opacity:0}40%{transform:scale(1.08);opacity:1}100%{transform:scale(1);opacity:.82}}
    .fast-bid-btn,.auto-bid-btn,.tool-btn{
      box-shadow:0 12px 20px rgba(0,0,0,.28), inset 0 1px 0 rgba(255,255,255,.10);
      transition:transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    }
    .fast-bid-btn:active,.auto-bid-btn:active,.tool-btn:active{transform:translateY(1px) scale(.98)}
    .fast-bid-btn.active .x2-mark{color:#c9f6ff;text-shadow:0 0 14px rgba(120,210,255,.32)}
    .auto-bid-btn.active .x2-mark{color:#d8ffe8;text-shadow:0 0 14px rgba(130,255,196,.26)}
    .modal{
      background:radial-gradient(circle at 50% 30%, rgba(8,6,18,.22), rgba(0,0,0,.62));
      backdrop-filter:none;
    }
    .modal-card{
      position:relative;
      overflow:hidden;
      width:min(82vw,336px);
      padding:20px 18px 16px;
      border-radius:28px;
      border:1px solid rgba(255,255,255,.12);
      box-shadow:0 24px 54px rgba(0,0,0,.42), 0 0 0 1px rgba(255,255,255,.03) inset;
      background:
        linear-gradient(165deg, rgba(32,18,52,.96), rgba(10,6,20,.98));
    }
    .modal-card::before{
      content:'';
      position:absolute;
      inset:0;
      background:linear-gradient(140deg, rgba(255,255,255,.14), rgba(255,255,255,0) 28%, rgba(255,215,110,.08) 62%, rgba(120,210,255,.08));
      pointer-events:none;
      opacity:.9;
    }
    .modal-card > *{position:relative;z-index:1}
    .popup-kicker{
      display:inline-flex;
      align-items:center;
      gap:8px;
      padding:6px 10px;
      border-radius:999px;
      background:rgba(255,255,255,.06);
      border:1px solid rgba(255,255,255,.08);
      font:800 .60rem/1 'Poppins',sans-serif;
      letter-spacing:.18em;
      text-transform:uppercase;
      color:rgba(255,241,207,.82);
      margin-bottom:12px;
    }
    .popup-accent{
      height:4px;
      width:72px;
      margin:0 auto 14px;
      border-radius:999px;
      background:linear-gradient(90deg, rgba(255,255,255,0), rgba(255,215,110,.95), rgba(255,255,255,0));
      box-shadow:0 0 18px rgba(255,215,110,.26);
    }
    .modal-card h2{font:900 1.55rem/1.05 'Poppins',sans-serif;letter-spacing:.05em;margin-bottom:8px}
    .modal-card p{font:700 .88rem/1.5 'Inter',sans-serif;color:rgba(255,245,225,.84)}
    .popup-note{margin-top:12px;padding:11px 12px;border-radius:18px;background:linear-gradient(145deg, rgba(255,255,255,.06), rgba(255,255,255,.03));border:1px solid rgba(255,255,255,.08);font-size:.69rem;letter-spacing:.11em;text-transform:uppercase;color:rgba(255,241,207,.76)}
    .modal-card .popup-icon{
      width:58px;height:58px;margin:0 auto 14px;border-radius:18px;
      background:linear-gradient(145deg, rgba(255,255,255,.15), rgba(255,255,255,.04));
      box-shadow:inset 0 1px 0 rgba(255,255,255,.18),0 14px 28px rgba(0,0,0,.24);
    }
    .start-pop .modal-card{background:linear-gradient(160deg, rgba(14,66,42,.98), rgba(9,18,18,.98));border-color:rgba(82,232,138,.64)}
    .stop-pop .modal-card{background:linear-gradient(160deg, rgba(76,42,12,.98), rgba(20,12,8,.98));border-color:rgba(255,176,78,.72)}
    .winner-pop .modal-card{background:linear-gradient(160deg, rgba(58,34,12,.98), rgba(27,13,32,.98));border-color:rgba(255,215,110,.92);box-shadow:0 24px 56px rgba(0,0,0,.46),0 0 34px rgba(255,215,110,.20)}
    .loser-pop .modal-card,.loss-pop .modal-card{background:linear-gradient(160deg, rgba(54,18,28,.98), rgba(19,9,15,.98));border-color:rgba(255,110,146,.54)}
    .nobid-pop .modal-card{background:linear-gradient(160deg, rgba(44,28,58,.98), rgba(12,10,21,.98));border-color:rgba(157,117,255,.52)}
    .modal.show .modal-card{animation:popupPulseIn .34s cubic-bezier(.2,.85,.25,1.15)}
    @keyframes popupPulseIn{0%{transform:translateY(30px) scale(.84);opacity:0}70%{transform:translateY(-2px) scale(1.02);opacity:1}100%{transform:translateY(0) scale(1)}}
    .message-banner{
      width:min(82vw,320px);
      padding:12px 14px;
      border-radius:24px;
      background:linear-gradient(160deg, rgba(12,9,24,.95), rgba(22,14,38,.98));
      box-shadow:0 16px 42px rgba(0,0,0,.40), 0 0 0 1px rgba(255,255,255,.04) inset;
    }
    .message-banner::before{opacity:.68}
    .message-banner-title{font-size:.63rem;letter-spacing:.20em}
    .message-banner-text{font-size:.82rem;line-height:1.36}
    @media (max-height: 560px){
      .timer-orb{width:92px;height:92px}
      .timer-inner{inset:14px}
      .timer-value{font-size:2.32rem}
      .timer-value.phase-text{font-size:1.12rem}
      .modal-card{width:min(84vw,310px);padding:18px 16px 14px}
      .chip{width:54px;height:54px}
      .chip-face{width:50px;height:50px}
    }



    /* v29 responsive rescue overrides */
    :root{
      --mobile-side-pad:max(8px, env(safe-area-inset-left));
      --mobile-right-pad:max(8px, env(safe-area-inset-right));
    }
    body{
      max-width:480px;
      margin:0 auto;
      position:relative;
    }
    body.teenpatti-king{
      background:radial-gradient(circle at 18% 18%, #241036 0%, #12061f 46%, #05020d 100%);
    }
    body.teenpatti-king .game-container{
      background:radial-gradient(circle at 22% 16%, #2b1340 0%, #140720 34%, #06010d 100%);
    }
    body.teenpatti-king .game-container::before{
      opacity:1;
      background:
        radial-gradient(circle at 14% 16%, rgba(255,215,110,.16), transparent 24%),
        radial-gradient(circle at 84% 20%, rgba(142,105,255,.18), transparent 30%),
        radial-gradient(circle at 48% 76%, rgba(88,214,255,.12), transparent 28%);
    }
    body.teenpatti-king .top-bar{
      background:linear-gradient(135deg, rgba(12,7,25,.92), rgba(35,13,57,.96));
      border-bottom-color:rgba(255,215,110,.58);
      box-shadow:0 10px 34px rgba(0,0,0,.38), 0 0 0 1px rgba(255,255,255,.04) inset;
    }
    body.teenpatti-king .coin-section,
    body.teenpatti-king .user-section{
      background:linear-gradient(145deg, rgba(12,8,27,.78), rgba(35,14,59,.82));
      border-color:rgba(255,215,110,.56);
      box-shadow:0 0 18px rgba(255,215,110,.08);
    }
    body.teenpatti-king .status-pill,
    body.teenpatti-king .phase-banner,
    body.teenpatti-king .floating-banner{
      background:linear-gradient(145deg, rgba(13,9,30,.95), rgba(42,19,66,.92));
      border-color:rgba(255,215,110,.36);
    }
    body.teenpatti-king .timer-orb{
      filter:drop-shadow(0 0 28px rgba(255,215,110,.12)) drop-shadow(0 18px 28px rgba(0,0,0,.34));
      width:112px;
      height:112px;
      border-radius:50%;
      background:
        conic-gradient(from 12deg, rgba(255,232,159,.96), rgba(140,82,22,.9), rgba(255,245,186,.98), rgba(105,55,14,.88), rgba(255,232,159,.96));
      padding:5px;
    }
    body.teenpatti-king .timer-orb::before{
      content:'';
      position:absolute;
      inset:-7px;
      border-radius:50%;
      background:
        radial-gradient(circle at 50% 0%, rgba(255,248,210,.42), transparent 14%),
        conic-gradient(from 0deg, transparent 0 11deg, rgba(255,215,110,.62) 12deg 15deg, transparent 16deg 44deg, rgba(154,100,255,.22) 45deg 48deg, transparent 49deg 90deg);
      filter:drop-shadow(0 0 12px rgba(255,215,110,.24));
      animation:kingClockCrown 8s linear infinite;
      pointer-events:none;
      z-index:-1;
    }
    body.teenpatti-king .timer-orb::after{
      content:'';
      position:absolute;
      left:50%;
      top:-13px;
      width:38px;
      height:20px;
      transform:translateX(-50%);
      background:linear-gradient(135deg,#fff6bf,#d49525 64%,#7a3f11);
      clip-path:polygon(0 100%,16% 38%,31% 100%,50% 8%,69% 100%,84% 38%,100% 100%);
      filter:drop-shadow(0 4px 8px rgba(0,0,0,.42)) drop-shadow(0 0 10px rgba(255,215,110,.28));
      pointer-events:none;
    }
    body.teenpatti-king .timer-bg{
      inset:5px;
      background:
        radial-gradient(circle at 32% 24%, rgba(255,255,255,.16), transparent 25%),
        linear-gradient(145deg, rgba(74,28,46,.94), rgba(16,7,24,.98));
      border:1px solid rgba(255,232,162,.62);
      box-shadow:inset 0 0 0 3px rgba(42,18,36,.62), inset 0 0 22px rgba(255,215,110,.10);
    }
    body.teenpatti-king .timer-inner{
      inset:20px;
      background:
        radial-gradient(circle at 36% 24%, rgba(255,255,255,.28), transparent 25%),
        radial-gradient(circle at 50% 58%, rgba(255,215,110,.16), transparent 48%),
        linear-gradient(160deg, rgba(34,11,36,.98), rgba(9,4,18,.98));
      border:1px solid rgba(255,226,146,.32);
      box-shadow:inset 0 0 18px rgba(0,0,0,.34),0 0 18px rgba(255,215,110,.12);
    }
    body.teenpatti-king .timer-progress{
      inset:7px;
      background:conic-gradient(var(--timer-color, #ffd76e) calc(var(--p,1) * 360deg), rgba(255,255,255,.06) 0);
      mask:radial-gradient(circle, transparent 56%, #000 58%);
    }
    body.teenpatti-king .timer-value{
      font-family:'Cinzel','Poppins',serif;
      font-weight:900;
      background:linear-gradient(180deg,#fff7d0 0%,#ffd76e 45%,#aa641b 100%);
      -webkit-background-clip:text;
      background-clip:text;
      filter:drop-shadow(0 2px 0 rgba(58,24,6,.65)) drop-shadow(0 0 10px rgba(255,215,110,.18));
    }
    body.teenpatti-king .timer-sub{
      color:#ffe9a7;
      letter-spacing:.18em;
    }
    @keyframes kingClockCrown{to{transform:rotate(360deg)}}
    body.teenpatti-king .card.back{
      background:
        radial-gradient(circle at 50% 18%, rgba(255,246,206,.30), transparent 18%),
        linear-gradient(150deg, #65182d 0%, #2d0b2c 44%, #080414 100%);
      border-color:rgba(255,224,142,.88);
      box-shadow:0 18px 30px rgba(0,0,0,.38), inset 0 0 0 1px rgba(255,255,255,.10), inset 0 0 18px rgba(255,215,110,.12);
    }
    body.teenpatti-king .card.back::before{
      inset:5px;
      background:
        radial-gradient(circle at 50% 50%, rgba(255,215,110,.20), transparent 42%),
        linear-gradient(45deg, transparent 42%, rgba(255,226,145,.22) 43% 48%, transparent 49% 56%, rgba(255,226,145,.16) 57% 62%, transparent 63%),
        repeating-linear-gradient(135deg, rgba(255,215,110,.20) 0 3px, rgba(84,25,52,.26) 3px 7px);
      border-color:rgba(255,237,181,.38);
      box-shadow:inset 0 0 0 1px rgba(80,32,10,.36);
    }
    body.teenpatti-king .card.back::after{
      content:'K';
      font:900 1.08rem/1 'Cinzel','Poppins',serif;
      color:rgba(255,236,166,.92);
      text-shadow:0 1px 0 rgba(70,28,4,.72),0 0 14px rgba(255,215,110,.38);
    }
    body.teenpatti-king .board{
      box-shadow:0 12px 28px rgba(0,0,0,.24);
    }
    body.teenpatti-king .board[data-board="C"]{
      background:linear-gradient(145deg, rgba(180,108,255,.32), rgba(92,48,178,.44));
      border-color:rgba(216,171,255,.62);
    }
    body.teenpatti-king .pot[data-board="C"] .pot-title{
      color:#d897ff;
      text-shadow:0 0 20px #bf63ff;
    }
    body.teenpatti-king .pot[data-board="A"] .chair.chair-royal{
      filter:saturate(1.12) brightness(1.05) drop-shadow(0 10px 18px rgba(255,138,138,.20)) drop-shadow(0 0 18px rgba(255,215,110,.16));
    }
    body.teenpatti-king .pot[data-board="B"] .chair.chair-royal{
      filter:saturate(1.12) brightness(1.08) drop-shadow(0 10px 18px rgba(104,174,255,.22)) drop-shadow(0 0 18px rgba(255,215,110,.16));
    }
    body.teenpatti-king .pot[data-board="C"] .chair.chair-royal{
      filter:hue-rotate(180deg) saturate(1.2) brightness(1.06) drop-shadow(0 10px 18px rgba(192,108,255,.26)) drop-shadow(0 0 18px rgba(255,215,110,.18));
    }
    body.teenpatti-king .splash-logo{
      border-color:rgba(255,215,110,.56);
      background:linear-gradient(145deg, rgba(40,14,54,.84), rgba(10,6,18,.95));
      box-shadow:0 20px 44px rgba(0,0,0,.42),0 0 34px rgba(255,215,110,.18);
    }
    body.teenpatti-king .splash-title{
      letter-spacing:.12em;
      background:linear-gradient(135deg,#fff8de,#ffd76e 46%,#ffb24d 82%);
      -webkit-background-clip:text;
      background-clip:text;
    }
    body.teenpatti-king .splash-sub{
      color:rgba(255,237,199,.82);
    }
    body.teenpatti-king .winner-pop .modal-card{
      box-shadow:0 24px 56px rgba(0,0,0,.46),0 0 40px rgba(255,215,110,.24);
    }
    body.teenpatti-king .mega-core{
      background:linear-gradient(145deg, rgba(56,28,20,.95), rgba(22,11,34,.98));
      border-color:rgba(255,215,110,.74);
    }
    body.teenpatti-king .chips-bar{
      background:
        linear-gradient(180deg, rgba(30,10,28,.92), rgba(9,4,14,.98)),
        radial-gradient(circle at 50% 0%, rgba(255,215,110,.18), transparent 48%);
      border-top-color:rgba(255,224,142,.70);
      box-shadow:0 -12px 30px rgba(0,0,0,.42), inset 0 1px 0 rgba(255,246,206,.13);
    }
    body.teenpatti-king .chip-face{
      filter:drop-shadow(0 9px 16px rgba(0,0,0,.50)) drop-shadow(0 0 8px rgba(255,215,110,.10));
    }
    body.teenpatti-king .chip.selected .chip-face{
      filter:drop-shadow(0 0 20px rgba(255,224,142,.82)) drop-shadow(0 12px 18px rgba(0,0,0,.48));
    }
    body.teenpatti-sultan{font-family:'El Messiri', 'Inter', system-ui, sans-serif;background:radial-gradient(circle at 18% 18%, #3a1e0d 0%, #170c05 44%, #060302 100%)}
    body.teenpatti-sultan .game-container{background:radial-gradient(circle at 24% 18%, #4d2912 0%, #1e1007 36%, #060302 100%)}
    body.teenpatti-sultan .game-container::before{opacity:1;background:radial-gradient(circle at 16% 14%, rgba(255,221,158,.18), transparent 22%),radial-gradient(circle at 82% 18%, rgba(78,192,214,.15), transparent 28%),radial-gradient(circle at 48% 78%, rgba(255,190,104,.12), transparent 30%)}
    body.teenpatti-sultan .top-bar{background:linear-gradient(135deg, rgba(34,18,9,.94), rgba(72,37,13,.96));border-bottom-color:rgba(255,221,158,.56)}
    body.teenpatti-sultan .coin-section,body.teenpatti-sultan .user-section,body.teenpatti-sultan .status-pill,body.teenpatti-sultan .phase-banner,body.teenpatti-sultan .floating-banner,body.teenpatti-sultan .chips-bar,body.teenpatti-sultan .modal-card{background:linear-gradient(145deg, rgba(42,24,10,.86), rgba(16,9,4,.94));border-color:rgba(255,221,158,.34)}
    body.teenpatti-sultan .timer-bg{background:radial-gradient(circle at 30% 30%, rgba(255,248,224,.16), rgba(31,16,7,.78));border-color:rgba(255,221,158,.34)}
    body.teenpatti-sultan .timer-inner{background:radial-gradient(circle at 32% 30%, rgba(255,245,214,.26), rgba(20,11,5,.96))}
    body.teenpatti-sultan .board{box-shadow:0 14px 30px rgba(0,0,0,.28), 0 0 22px rgba(255,198,112,.06)}
    body.teenpatti-sultan .chair{filter:sepia(.34) hue-rotate(-16deg) saturate(1.2) brightness(1.05) drop-shadow(0 8px 14px rgba(255,197,112,.18))}
    body.teenpatti-sultan .card.back{background:radial-gradient(circle at 22% 18%, rgba(255,245,214,.18), transparent 22%),linear-gradient(160deg, #6f4a1d 0%, #2d1708 42%, #100803 100%);border-color:rgba(255,221,158,.72)}
    body.teenpatti-sultan .card.back::before{background:radial-gradient(circle at 50% 50%, rgba(255,221,158,.18), transparent 46%),repeating-linear-gradient(45deg, rgba(255,221,158,.22) 0 3px, rgba(66,122,133,.18) 3px 6px);border-color:rgba(255,233,190,.22)}
    body.teenpatti-sultan .card.back::after{content:'S';font:900 1rem/1 'El Messiri',sans-serif;color:rgba(255,236,190,.82)}

    body.teenpatti-warfront{font-family:'Rajdhani', 'Inter', system-ui, sans-serif;background:radial-gradient(circle at 18% 18%, #2a2d31 0%, #121418 44%, #050608 100%)}
    body.teenpatti-warfront .game-container{background:radial-gradient(circle at 24% 18%, #33373d 0%, #14171c 36%, #060709 100%)}
    body.teenpatti-warfront .game-container::before{opacity:1;background:radial-gradient(circle at 16% 14%, rgba(255,129,84,.16), transparent 22%),radial-gradient(circle at 82% 18%, rgba(170,181,192,.12), transparent 28%),radial-gradient(circle at 48% 78%, rgba(255,107,61,.10), transparent 30%)}
    body.teenpatti-warfront .top-bar{background:linear-gradient(135deg, rgba(31,34,38,.96), rgba(68,42,33,.96));border-bottom-color:rgba(255,137,94,.5)}
    body.teenpatti-warfront .coin-section,body.teenpatti-warfront .user-section,body.teenpatti-warfront .status-pill,body.teenpatti-warfront .phase-banner,body.teenpatti-warfront .floating-banner,body.teenpatti-warfront .chips-bar,body.teenpatti-warfront .modal-card{background:linear-gradient(145deg, rgba(38,42,46,.9), rgba(15,16,19,.96));border-color:rgba(255,137,94,.3)}
    body.teenpatti-warfront .timer-orb,body.teenpatti-warfront .timer-bg,body.teenpatti-warfront .timer-inner{clip-path:polygon(18% 0, 82% 0, 100% 18%, 100% 82%, 82% 100%, 18% 100%, 0 82%, 0 18%)}
    body.teenpatti-warfront .timer-bg{background:radial-gradient(circle at 30% 30%, rgba(255,255,255,.12), rgba(28,24,22,.9));border-color:rgba(255,137,94,.34)}
    body.teenpatti-warfront .timer-inner{background:radial-gradient(circle at 32% 30%, rgba(255,219,205,.18), rgba(22,19,18,.98))}
    body.teenpatti-warfront .board{border-radius:18px;box-shadow:0 12px 28px rgba(0,0,0,.34)}
    body.teenpatti-warfront .chair{filter:grayscale(.34) sepia(.28) hue-rotate(-10deg) saturate(1.05) brightness(.98) drop-shadow(0 8px 14px rgba(255,120,80,.12))}
    body.teenpatti-warfront .card.back{background:radial-gradient(circle at 22% 18%, rgba(255,255,255,.1), transparent 22%),linear-gradient(160deg, #52565d 0%, #23262c 42%, #0d0f12 100%);border-color:rgba(255,146,92,.68)}
    body.teenpatti-warfront .card.back::before{background:radial-gradient(circle at 50% 50%, rgba(255,146,92,.14), transparent 46%),repeating-linear-gradient(135deg, rgba(124,128,135,.22) 0 5px, rgba(58,63,69,.18) 5px 10px);border-color:rgba(255,213,194,.16)}
    body.teenpatti-warfront .card.back::after{content:'W';font:900 1rem/1 'Rajdhani',sans-serif;letter-spacing:.12em;color:rgba(255,221,205,.82)}

    body.teenpatti-neon{font-family:'Orbitron', 'Inter', system-ui, sans-serif;background:radial-gradient(circle at 18% 18%, #180b3a 0%, #090d1d 44%, #03050a 100%)}
    body.teenpatti-neon .game-container{background:radial-gradient(circle at 24% 18%, #1d0f48 0%, #0a1226 36%, #03050a 100%)}
    body.teenpatti-neon .game-container::before{opacity:1;background:radial-gradient(circle at 14% 14%, rgba(255,84,180,.18), transparent 22%),radial-gradient(circle at 84% 16%, rgba(72,225,255,.18), transparent 28%),radial-gradient(circle at 48% 78%, rgba(160,120,255,.14), transparent 30%)}
    body.teenpatti-neon .top-bar{background:linear-gradient(135deg, rgba(9,10,28,.96), rgba(30,10,58,.96));border-bottom-color:rgba(72,225,255,.54)}
    body.teenpatti-neon .coin-section,body.teenpatti-neon .user-section,body.teenpatti-neon .status-pill,body.teenpatti-neon .phase-banner,body.teenpatti-neon .floating-banner,body.teenpatti-neon .chips-bar,body.teenpatti-neon .modal-card{background:linear-gradient(145deg, rgba(14,16,42,.9), rgba(8,7,20,.96));border-color:rgba(72,225,255,.28);box-shadow:0 0 16px rgba(72,225,255,.08)}
    body.teenpatti-neon .timer-orb,body.teenpatti-neon .timer-bg,body.teenpatti-neon .timer-inner{clip-path:polygon(25% 6%, 75% 6%, 100% 50%, 75% 94%, 25% 94%, 0 50%)}
    body.teenpatti-neon .timer-bg{background:radial-gradient(circle at 30% 30%, rgba(255,255,255,.14), rgba(12,10,42,.84));border-color:rgba(72,225,255,.34)}
    body.teenpatti-neon .timer-inner{background:radial-gradient(circle at 32% 30%, rgba(255,130,218,.2), rgba(6,10,28,.98))}
    body.teenpatti-neon .board{box-shadow:0 0 18px rgba(72,225,255,.12), 0 16px 28px rgba(0,0,0,.3)}
    body.teenpatti-neon .chair{filter:hue-rotate(118deg) saturate(1.38) brightness(1.06) drop-shadow(0 8px 14px rgba(72,225,255,.18))}
    body.teenpatti-neon .card.back{background:radial-gradient(circle at 22% 18%, rgba(255,255,255,.12), transparent 22%),linear-gradient(160deg, #2a1470 0%, #10154b 42%, #040817 100%);border-color:rgba(72,225,255,.72)}
    body.teenpatti-neon .card.back::before{background:radial-gradient(circle at 50% 50%, rgba(255,84,180,.16), transparent 46%),repeating-linear-gradient(90deg, rgba(72,225,255,.18) 0 2px, rgba(255,84,180,.14) 2px 4px);border-color:rgba(186,244,255,.2)}
    body.teenpatti-neon .card.back::after{content:'N';font:900 1rem/1 'Orbitron',sans-serif;color:rgba(224,252,255,.88);text-shadow:0 0 10px rgba(72,225,255,.34)}

    body.teenpatti-shogun{font-family:'Teko', 'Poppins', sans-serif;background:radial-gradient(circle at 18% 18%, #3a1111 0%, #170707 44%, #050202 100%)}
    body.teenpatti-shogun .game-container{background:radial-gradient(circle at 24% 18%, #4a1717 0%, #1a0a0a 36%, #050202 100%)}
    body.teenpatti-shogun .game-container::before{opacity:1;background:radial-gradient(circle at 16% 14%, rgba(255,208,118,.16), transparent 22%),radial-gradient(circle at 82% 18%, rgba(180,42,42,.16), transparent 28%),radial-gradient(circle at 48% 78%, rgba(255,230,164,.10), transparent 30%)}
    body.teenpatti-shogun .top-bar{background:linear-gradient(135deg, rgba(28,7,7,.96), rgba(70,14,14,.96));border-bottom-color:rgba(255,208,118,.54)}
    body.teenpatti-shogun .coin-section,body.teenpatti-shogun .user-section,body.teenpatti-shogun .status-pill,body.teenpatti-shogun .phase-banner,body.teenpatti-shogun .floating-banner,body.teenpatti-shogun .chips-bar,body.teenpatti-shogun .modal-card{background:linear-gradient(145deg, rgba(38,9,9,.9), rgba(15,5,5,.96));border-color:rgba(255,208,118,.28)}
    body.teenpatti-shogun .timer-orb,body.teenpatti-shogun .timer-bg,body.teenpatti-shogun .timer-inner{clip-path:polygon(50% 0, 94% 26%, 82% 100%, 18% 100%, 6% 26%)}
    body.teenpatti-shogun .timer-bg{background:radial-gradient(circle at 30% 30%, rgba(255,255,255,.12), rgba(40,11,11,.86));border-color:rgba(255,208,118,.34)}
    body.teenpatti-shogun .timer-inner{background:radial-gradient(circle at 32% 30%, rgba(255,223,168,.18), rgba(25,8,8,.98))}
    body.teenpatti-shogun .board{box-shadow:0 14px 30px rgba(0,0,0,.32), 0 0 20px rgba(255,208,118,.06)}
    body.teenpatti-shogun .chair{filter:sepia(.24) hue-rotate(-18deg) saturate(1.2) brightness(.98) drop-shadow(0 8px 14px rgba(255,208,118,.16))}
    body.teenpatti-shogun .card.back{background:radial-gradient(circle at 22% 18%, rgba(255,255,255,.1), transparent 22%),linear-gradient(160deg, #7a1f1f 0%, #2d0d0d 42%, #120404 100%);border-color:rgba(255,208,118,.72)}
    body.teenpatti-shogun .card.back::before{background:radial-gradient(circle at 50% 50%, rgba(255,208,118,.14), transparent 46%),repeating-linear-gradient(90deg, rgba(255,208,118,.18) 0 3px, rgba(126,31,31,.16) 3px 7px);border-color:rgba(255,228,181,.18)}
    body.teenpatti-shogun .card.back::after{content:'SG';font:900 .92rem/1 'Teko',sans-serif;letter-spacing:.12em;color:rgba(255,234,196,.86)}

    body.teenpatti-glacier{font-family:'Inter', system-ui, sans-serif;background:radial-gradient(circle at 18% 18%, #123148 0%, #081623 44%, #02070b 100%)}
    body.teenpatti-glacier .game-container{background:radial-gradient(circle at 24% 18%, #173a55 0%, #091a28 36%, #02070b 100%)}
    body.teenpatti-glacier .game-container::before{opacity:1;background:radial-gradient(circle at 14% 14%, rgba(186,236,255,.18), transparent 22%),radial-gradient(circle at 84% 18%, rgba(117,185,255,.16), transparent 28%),radial-gradient(circle at 48% 78%, rgba(230,246,255,.12), transparent 30%)}
    body.teenpatti-glacier .top-bar{background:linear-gradient(135deg, rgba(8,26,40,.96), rgba(18,54,74,.96));border-bottom-color:rgba(186,236,255,.54)}
    body.teenpatti-glacier .coin-section,body.teenpatti-glacier .user-section,body.teenpatti-glacier .status-pill,body.teenpatti-glacier .phase-banner,body.teenpatti-glacier .floating-banner,body.teenpatti-glacier .chips-bar,body.teenpatti-glacier .modal-card{background:linear-gradient(145deg, rgba(12,32,48,.88), rgba(6,14,21,.96));border-color:rgba(186,236,255,.28)}
    body.teenpatti-glacier .timer-orb,body.teenpatti-glacier .timer-bg,body.teenpatti-glacier .timer-inner{clip-path:polygon(50% 0, 84% 14%, 100% 50%, 84% 86%, 50% 100%, 16% 86%, 0 50%, 16% 14%)}
    body.teenpatti-glacier .timer-bg{background:radial-gradient(circle at 30% 30%, rgba(255,255,255,.2), rgba(10,24,36,.84));border-color:rgba(186,236,255,.34)}
    body.teenpatti-glacier .timer-inner{background:radial-gradient(circle at 32% 30%, rgba(230,246,255,.22), rgba(8,20,31,.98))}
    body.teenpatti-glacier .board{box-shadow:0 14px 30px rgba(0,0,0,.24), 0 0 18px rgba(186,236,255,.08)}
    body.teenpatti-glacier .chair{filter:hue-rotate(148deg) saturate(.9) brightness(1.08) drop-shadow(0 8px 14px rgba(186,236,255,.16))}
    body.teenpatti-glacier .card.back{background:radial-gradient(circle at 22% 18%, rgba(255,255,255,.16), transparent 22%),linear-gradient(160deg, #3c6f8f 0%, #18344a 42%, #08131c 100%);border-color:rgba(186,236,255,.72)}
    body.teenpatti-glacier .card.back::before{background:radial-gradient(circle at 50% 50%, rgba(210,242,255,.16), transparent 46%),repeating-linear-gradient(135deg, rgba(210,242,255,.18) 0 3px, rgba(92,153,191,.14) 3px 7px);border-color:rgba(233,248,255,.2)}
    body.teenpatti-glacier .card.back::after{content:'G';font:900 1rem/1 'Inter',sans-serif;color:rgba(240,251,255,.88);text-shadow:0 0 12px rgba(186,236,255,.26)}

    .game-container{
      width:100%;
      max-width:480px;
      margin:0 auto;
      min-height:100dvh;
      overflow:visible;
      padding-top:10px;
    }
    .top-bar{
      padding-left:10px;
      padding-right:10px;
    }
    .top-bar .title-wrap{min-width:0;flex:1}
    .top-bar .balance-wrap,.balance-section{min-width:110px;max-width:138px}
    .top-stack,.bottom-stack,.chips-bar,.top-bar,.modal-card,.status-strip,.phase-banner,.message-banner{
      max-width:480px;
      margin-left:auto;
      margin-right:auto;
    }
    .top-stack{
      padding-left:10px;
      padding-right:10px;
      gap:5px;
    }
    .status-strip{gap:6px}
    .status-pill{
      padding:5px 9px;
      font-size:.58rem;
      letter-spacing:.1em;
      max-width:calc(100vw - 24px);
    }
    .net-pill{min-width:98px}
    .timer-wrap{width:100%;display:flex;justify-content:center}
    .timer-orb{
      width:clamp(68px, 20vw, 88px);
      height:clamp(68px, 20vw, 88px);
    }
    .timer-value{font-size:clamp(1.8rem, 7vw, 2.5rem)}
    .timer-value.phase-text{font-size:clamp(.95rem, 3.8vw, 1.2rem)}
    .timer-sub{font-size:.56rem;letter-spacing:.14em}
    .game-content,.shell{width:100%;max-width:480px;margin:0 auto}
    .bottom-stack{
      width:100%;
      padding-left:10px;
      padding-right:10px;
      gap:3px;
    }
    .pots,.boards{gap:6px}
    .pot{
      min-height:150px;
      padding:4px 3px 0;
    }
    .chair{width:clamp(50px, 18vw, 72px);margin-bottom:-12px}
    .cards{height:clamp(72px, 22vw, 92px)}
    .card{
      width:var(--card-w);
      height:var(--card-h);
      margin-left:-10px;
    }
    .pot .cards .card:nth-child(1){transform:translateX(10px);z-index:3}
    .pot .cards .card:nth-child(2){transform:translateX(0);z-index:2}
    .pot .cards .card:nth-child(3){transform:translateX(-10px);z-index:1}
    .hand-label{max-width:92%;font-size:.56rem;padding:3px 8px}
    .pot-title{font-size:.9rem}
    .board{
      min-height:88px;
      padding:10px 5px 9px;
      border-radius:18px;
    }
    .board-amount{font-size:clamp(.92rem, 4vw, 1.12rem)}
    .won-amount{font-size:clamp(.8rem, 3.6vw, .96rem)}
    .board-mini{font-size:.48rem;letter-spacing:.06em}
    .chips-bar{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:4px;
      padding:6px 8px max(8px, env(safe-area-inset-bottom));
      overflow:visible;
      padding-top:10px;
    }
    .chip,.fast-bid-btn,.auto-bid-btn,.tool-btn{
      flex:0 0 auto;
    }
    .chip{width:46px;height:46px}
    .chip-face{width:42px;height:42px}
    .chip.selected{transform:translateY(-3px) scale(1.04)}
    .fast-bid-btn,.auto-bid-btn,.tool-btn{width:42px;height:42px;border-radius:14px}
    .fast-bid-btn small,.auto-bid-btn small{font-size:.44rem;letter-spacing:.08em}
    .fast-bid-btn .x2-mark,.auto-bid-btn .x2-mark{font-size:.68rem}
    .floating-banner,.phase-banner,.toast-notification,.message-banner{
      max-width:min(88vw, 320px);
      text-align:center;
    }
    .modal-card{width:min(90vw, 336px)}

    @media (max-width: 430px){
      :root{
        --top-bar-h:56px;
        --card-w:46px;
        --card-h:76px;
        --chips-bar-h:56px;
      }
      .top-bar{min-height:56px}
      .top-stack{top:54px;padding-left:8px;padding-right:8px;gap:4px}
      .status-pill{padding:4px 8px;font-size:.54rem}
      .bottom-stack{padding-left:8px;padding-right:8px}
      .pot{min-height:142px}
      .board{min-height:84px}
      .chips-bar{padding:6px 6px max(8px, env(safe-area-inset-bottom));gap:3px}
      .chip{width:42px;height:42px}
      .chip-face{width:38px;height:38px}
      .fast-bid-btn,.auto-bid-btn,.tool-btn{width:40px;height:40px}
      .balance-wrap,.balance-section{min-width:98px;max-width:124px}
    }

    @media (max-width: 375px){
      :root{
        --card-w:42px;
        --card-h:70px;
      }
      .top-bar{padding-left:8px;padding-right:8px}
      .status-pill{font-size:.5rem;padding:4px 7px}
      .net-pill{min-width:88px}
      .pot{min-height:132px}
      .chair{width:48px;margin-bottom:-10px}
      .cards{height:66px}
      .hand-label{font-size:.5rem;padding:3px 6px}
      .board{min-height:78px;padding:9px 4px 8px}
      .board-amount{font-size:.82rem}
      .won-amount{font-size:.74rem}
      .chip{width:38px;height:38px}
      .chip-face{width:34px;height:34px}
      .fast-bid-btn,.auto-bid-btn,.tool-btn{width:36px;height:36px;border-radius:12px}
      .fast-bid-btn .x2-mark,.auto-bid-btn .x2-mark{font-size:.58rem}
      .fast-bid-btn small,.auto-bid-btn small{font-size:.38rem}
    }

    @media (max-height: 700px){
      .top-stack{gap:4px}
      .pot{min-height:138px}
      .chair{width:56px;margin-bottom:-11px}
      .cards{height:70px}
      .board{min-height:80px}
    }

    @media (max-height: 560px){
      :root{
        --top-bar-h:54px;
        --chips-bar-h:54px;
        --card-w:40px;
        --card-h:66px;
      }
      .top-bar{min-height:54px}
      .top-stack{top:52px;gap:3px;padding-left:8px;padding-right:8px}
      .status-pill{padding:3px 7px;font-size:.48rem;border-radius:999px}
      .timer-orb{width:64px;height:64px}
      .timer-value{font-size:1.55rem}
      .timer-value.phase-text{font-size:.9rem}
      .pot{min-height:118px;padding-top:2px}
      .chair{width:44px;margin-bottom:-9px}
      .cards{height:62px}
      .hand-label{font-size:.46rem;padding:2px 6px}
      .pot-title{font-size:.8rem}
      .board{min-height:72px;padding:8px 4px 7px;border-radius:16px}
      .board-amount{font-size:.76rem}
      .won-amount{font-size:.68rem}
      .chips-bar{padding:5px 6px max(6px, env(safe-area-inset-bottom));gap:2px}
      .chip{width:34px;height:34px}
      .chip-face{width:30px;height:30px}
      .fast-bid-btn,.auto-bid-btn,.tool-btn{width:34px;height:34px;border-radius:10px}
      .fast-bid-btn .x2-mark,.auto-bid-btn .x2-mark{font-size:.52rem}
      .fast-bid-btn small,.auto-bid-btn small{display:none}
      .modal-card{width:min(92vw, 300px)}
    }

    @media (max-height: 450px){
      .top-stack{top:50px;gap:2px}
      .status-strip{gap:4px}
      .timer-orb{width:58px;height:58px}
      .pot{min-height:108px}
      .board{min-height:68px}
      .chips-bar{padding:4px 5px max(5px, env(safe-area-inset-bottom));}
    }

</style>

<style id="v31-verified-fix">
  /* Verified hard-fix layer */
  .chips-bar{overflow:visible !important;padding-top:10px !important;}
  .chips-bar .chip{margin-top:0 !important;}
  .chip.selected{transform:translateY(-4px) scale(1.06) !important;}
  .chip.selected .chip-face{transform:none !important;}
  .hand-group,.cards,.pot-cards{overflow:visible !important;}
  .hand-label{bottom:-14px !important; top:auto !important; left:50% !important; transform:translateX(-50%) !important; z-index:12 !important; max-width:78% !important; font-size:.52rem !important; padding:3px 9px !important;}
  .message-banner{max-width:min(82vw,290px) !important; padding:10px 12px !important; min-height:auto !important; backdrop-filter:blur(4px) !important; box-shadow:0 10px 24px rgba(0,0,0,.24) !important;}
  .message-banner .message-banner-title{font-size:.6rem !important; letter-spacing:.08em !important;}
  .message-banner .message-banner-text{font-size:.74rem !important; line-height:1.15 !important;}
  #noticeBlocker{pointer-events:none !important;}
  .message-banner.show ~ #noticeBlocker, #noticeBlocker.show{pointer-events:auto !important;}
  @media (max-height:560px){
    .hand-label{bottom:-12px !important;font-size:.48rem !important;padding:3px 8px !important;max-width:72% !important;}
    .chips-bar{padding-top:8px !important;}
    .chip.selected{transform:translateY(-3px) scale(1.04) !important;}
    .message-banner{max-width:min(78vw,260px) !important;padding:8px 10px !important;}
  }
  @media (max-height:450px){
    .hand-label{bottom:-10px !important;font-size:.46rem !important;max-width:68% !important;}
    .chips-bar{padding-top:7px !important;}
    .message-banner{max-width:min(74vw,235px) !important;padding:7px 9px !important;}
  }
</style>

<style id="teen-royal-play-polish">
  :root{
    --teen-clock-size:clamp(108px,30vw,136px);
    --teen-chip-size:clamp(34px,10.8vw,48px);
    --teen-tool-size:clamp(31px,9.6vw,42px);
  }
  .gf-teen-clock{
    padding:2px 12px 5px;
    border-radius:999px;
    background:
      linear-gradient(180deg,rgba(255,244,199,.08),rgba(255,255,255,0) 42%),
      linear-gradient(145deg,rgba(18,19,31,.92),rgba(7,8,15,.82));
    border:1px solid rgba(255,215,110,.24);
    box-shadow:0 12px 28px rgba(0,0,0,.30),0 0 18px rgba(255,215,110,.10),inset 0 1px 0 rgba(255,255,255,.10);
    isolation:isolate;
  }
  .gf-teen-clock::before{
    content:"COUNTDOWN";
    position:absolute;
    left:50%;
    top:-8px;
    transform:translateX(-50%);
    padding:2px 9px;
    border-radius:999px;
    background:linear-gradient(180deg,#fff3bd,#d79b2a);
    color:#271505;
    font:900 .44rem/1 'Poppins',sans-serif;
    letter-spacing:.10em;
    box-shadow:0 8px 18px rgba(0,0,0,.26);
    z-index:9;
  }
  .gf-teen-clock .gf-premium-clock{
    --gf-size:clamp(82px,23vw,108px);
    --gf-text-size:clamp(2rem,6.8vw,2.75rem);
    --gf-label-size:.54rem;
    --gf-a:var(--teen-timer-ring);
    --gf-b:#fff1b6;
    --gf-c:#ffd76e;
    --gf-scene:
      radial-gradient(circle at 34% 22%,rgba(255,255,255,.20),transparent 30%),
      radial-gradient(circle at 50% 58%,rgba(255,215,110,.28),rgba(37,16,58,.96) 56%,rgba(7,5,16,.98));
    filter:drop-shadow(0 18px 30px rgba(0,0,0,.40)) drop-shadow(0 0 22px var(--teen-timer-glow));
  }
  .gf-teen-clock .gf-premium-number{
    letter-spacing:0;
    font-family:'Orbitron','Poppins',sans-serif;
  }
  .gf-teen-clock .gf-premium-number.phase-soft,
  .gf-teen-clock .gf-premium-number.phase-text{
    letter-spacing:.10em;
    max-width:82%;
    text-align:center;
  }
  .gf-teen-clock .gf-premium-sub{
    top:74%;
    color:#fff3c7;
    text-shadow:0 0 12px rgba(255,215,110,.42);
  }
  .game-container.phase-betting .gf-teen-clock::before{content:"BET OPEN";}
  .game-container.phase-stopbet .gf-teen-clock::before{content:"BET CLOSED";}
  .game-container.phase-reveal .gf-teen-clock::before{content:"REVEAL";}
  .game-container.phase-winner .gf-teen-clock::before{content:"RESULT";}

  .gf-teen-clock{
    padding:0;
    width:auto;
    border:0;
    background:transparent;
    box-shadow:none;
    filter:none;
  }
  .gf-teen-clock::before{
    display:none;
  }
  .gf-teen-clock .gf-premium-clock{
    --gf-size:clamp(74px,20vw,96px);
    --gf-width:var(--gf-size);
    --gf-height:var(--gf-size);
    --gf-text-size:clamp(1.9rem,6.3vw,2.5rem);
    --gf-label-size:.54rem;
    border-radius:50% !important;
    clip-path:none !important;
    background:
      linear-gradient(145deg, rgba(255,255,255,.12), rgba(255,255,255,.02)),
      radial-gradient(circle at 50% 60%, rgba(13,18,35,.98), rgba(6,8,16,.98));
    border:1px solid rgba(255,255,255,.16);
    box-shadow:0 12px 26px rgba(0,0,0,.36),0 0 22px var(--teen-timer-glow),inset 0 1px 0 rgba(255,255,255,.16);
    filter:none;
    overflow:hidden;
  }
  .gf-teen-clock .gf-premium-scene,
  .gf-teen-clock .gf-premium-rim,
  .gf-teen-clock .gf-premium-badge,
  .gf-teen-clock .gf-premium-dot,
  .gf-teen-clock .gf-premium-shard,
  .gf-teen-clock .gf-premium-overlay,
  .gf-teen-clock .gf-premium-hand,
  .gf-teen-clock .gf-premium-pivot{
    display:none !important;
  }
  .gf-teen-clock .gf-premium-progress{
    inset:5px;
    border-radius:50% !important;
    background:conic-gradient(var(--timer-color, var(--teen-timer-ring)) calc(var(--p,1) * 360deg), rgba(255,255,255,.10) 0);
    -webkit-mask:radial-gradient(circle, transparent 59%, #000 61%);
    mask:radial-gradient(circle, transparent 59%, #000 61%);
    box-shadow:0 0 18px var(--teen-timer-glow);
  }
  .gf-teen-clock .gf-premium-core{
    inset:12px;
    border-radius:50% !important;
    background:
      radial-gradient(circle at 34% 22%, rgba(255,255,255,.24), transparent 28%),
      linear-gradient(145deg, rgba(31,38,72,.96), rgba(8,11,23,.99));
    border:1px solid rgba(255,255,255,.14);
    box-shadow:inset 0 0 24px rgba(0,0,0,.52),0 0 18px rgba(255,255,255,.06);
  }
  .gf-teen-clock .gf-premium-number{
    top:48%;
    font-family:'Inter','Poppins',system-ui,sans-serif;
    font-weight:1000;
    letter-spacing:0;
    color:#ffffff;
    text-shadow:0 2px 0 rgba(0,0,0,.42),0 0 14px var(--timer-color, var(--teen-timer-ring));
  }
  .gf-teen-clock .gf-premium-number::before{
    color:var(--timer-color, var(--teen-timer-ring));
    opacity:.28;
    filter:blur(8px);
  }
  .gf-teen-clock .gf-premium-number.phase-soft,
  .gf-teen-clock .gf-premium-number.phase-text{
    font-size:calc(var(--gf-text-size) * .44);
    letter-spacing:.08em;
    max-width:76%;
  }
  .gf-teen-clock .gf-premium-sub{
    top:70%;
    font-family:'Inter','Poppins',system-ui,sans-serif;
    font-size:var(--gf-label-size);
    font-weight:900;
    letter-spacing:.16em;
    color:rgba(255,255,255,.76);
    text-shadow:none;
  }
  .gf-teen-clock.round-live .gf-premium-clock{
    box-shadow:0 12px 26px rgba(0,0,0,.36),0 0 18px var(--teen-timer-glow),inset 0 1px 0 rgba(255,255,255,.16);
  }
  .gf-teen-clock.round-go .gf-premium-clock,
  .gf-teen-clock .gf-premium-clock.win-glow{
    animation:simpleTeenClockGlow 1.1s ease-in-out infinite;
  }
  @keyframes simpleTeenClockGlow{
    0%,100%{transform:scale(1);box-shadow:0 12px 26px rgba(0,0,0,.36),0 0 18px var(--teen-timer-glow)}
    50%{transform:scale(1.035);box-shadow:0 12px 26px rgba(0,0,0,.36),0 0 28px var(--timer-color, var(--teen-timer-ring))}
  }

  .top-bar{
    position:fixed !important;
    top:0 !important;
    left:0 !important;
    right:0 !important;
    z-index:140 !important;
  }
  .top-stack{
    top:calc(var(--top-bar-h) + env(safe-area-inset-top) + 14px) !important;
    z-index:141 !important;
    padding-top:0 !important;
  }
  .status-strip{
    display:flex !important;
    max-width:calc(100vw - 12px);
  }
  @media (max-width:480px){
    .top-stack{
      top:calc(var(--top-bar-h) + env(safe-area-inset-top) + 10px) !important;
    }
    .status-pill{
      padding:4px 7px !important;
      font-size:.5rem !important;
      letter-spacing:.06em !important;
    }
  }
  @media (max-height:450px){
    .top-stack{
      top:calc(var(--top-bar-h) + env(safe-area-inset-top) + 8px) !important;
    }
  }

  .chips-bar{
    min-height:calc(var(--chips-bar-h) + env(safe-area-inset-bottom)) !important;
    max-height:none !important;
    transform:none !important;
    padding:7px max(5px,env(safe-area-inset-right)) max(7px,env(safe-area-inset-bottom)) max(5px,env(safe-area-inset-left)) !important;
    gap:clamp(2px,.8vw,5px) !important;
    overflow:visible !important;
  }
  .top-bar{transform:none !important;left:0 !important;right:0 !important}
  .chips-bar .chip{
    width:var(--teen-chip-size) !important;
    height:var(--teen-chip-size) !important;
    flex:0 1 var(--teen-chip-size) !important;
    min-width:31px !important;
  }
  .chips-bar .chip-face{
    width:calc(var(--teen-chip-size) - 4px) !important;
    height:calc(var(--teen-chip-size) - 4px) !important;
  }
  .chips-bar .tool-btn,
  .chips-bar .fast-bid-btn,
  .chips-bar .auto-bid-btn{
    width:var(--teen-tool-size) !important;
    height:var(--teen-tool-size) !important;
    flex:0 1 var(--teen-tool-size) !important;
    min-width:29px !important;
  }
  .fast-bid-btn small,.auto-bid-btn small{font-size:.38rem;letter-spacing:.05em}
  .fast-bid-btn .x2-mark,.auto-bid-btn .x2-mark{font-size:.58rem}
  .chip.selected{transform:translateY(-5px) scale(1.05) !important}

  .pot{isolation:isolate}
  .pot::before{
    content:"";
    position:absolute;
    left:4px;
    right:4px;
    bottom:0;
    height:48%;
    border-radius:18px;
    background:linear-gradient(180deg,rgba(255,215,110,.10),rgba(0,0,0,.20));
    border:1px solid rgba(255,215,110,.12);
    pointer-events:none;
    z-index:0;
  }
  .chair{
    width:clamp(54px,18vw,78px) !important;
    margin-bottom:clamp(-18px,-3vw,-10px) !important;
    filter:drop-shadow(0 10px 15px rgba(0,0,0,.34)) !important;
  }
  .pot.winner-pot .chair{
    animation:proChairWin 1.25s ease-in-out infinite;
    filter:drop-shadow(0 0 18px rgba(255,215,110,.42)) drop-shadow(0 10px 15px rgba(0,0,0,.34)) !important;
  }
  @keyframes proChairWin{0%,100%{transform:translateY(0)}50%{transform:translateY(-5px)}}

  .card.back{
    background:
      radial-gradient(circle at 50% 50%,rgba(255,230,142,.16),transparent 35%),
      repeating-linear-gradient(45deg,rgba(255,215,110,.32) 0 3px,rgba(21,31,55,.1) 3px 7px),
      linear-gradient(145deg,#12213a,#050a17) !important;
    border:2px solid rgba(255,215,110,.76) !important;
    box-shadow:0 10px 22px rgba(0,0,0,.42),inset 0 0 0 4px rgba(255,255,255,.04),inset 0 0 18px rgba(255,215,110,.12) !important;
  }
  .card.back::before{
    inset:8px !important;
    border-radius:7px !important;
    background:
      linear-gradient(135deg,transparent 0 42%,rgba(255,215,110,.7) 42% 48%,transparent 48% 52%,rgba(255,215,110,.7) 52% 58%,transparent 58%),
      radial-gradient(circle at 50% 50%,rgba(30,116,255,.70) 0 18%,rgba(255,215,110,.54) 19% 24%,transparent 25%) !important;
    border:1px solid rgba(255,236,175,.46);
  }
  .teen-title-logo{
    flex:1 1 auto;
    min-width:0;
    display:flex;
    align-items:center;
    justify-content:center;
    pointer-events:none;
  }
  .teen-title-logo img{
    display:block;
    width:min(30vw,150px);
    height:clamp(28px,6.2vw,40px);
    object-fit:contain;
    filter:drop-shadow(0 0 12px rgba(255,215,110,.38)) drop-shadow(0 8px 14px rgba(0,0,0,.44));
  }
  .chair.chair-custom-art{
    width:clamp(98px,26vw,128px) !important;
    max-height:clamp(120px,28vw,158px);
    margin-bottom:clamp(-54px,-8vw,-36px) !important;
    object-fit:contain;
    object-position:center bottom;
    z-index:2;
    filter:drop-shadow(0 12px 18px rgba(0,0,0,.38)) drop-shadow(0 0 12px rgba(255,215,110,.12)) !important;
  }
  .pot[data-board="A"] .chair.chair-custom-art{transform:translateY(7px) rotate(-1deg) scale(.98)}
  .pot[data-board="B"] .chair.chair-custom-art{transform:translateY(5px) scale(1.02)}
  .pot[data-board="C"] .chair.chair-custom-art{transform:translateY(7px) rotate(1deg) scale(.98)}
  .pot.winner-pot .chair.chair-custom-art{
    filter:drop-shadow(0 0 18px rgba(255,215,110,.46)) drop-shadow(0 12px 18px rgba(0,0,0,.38)) !important;
  }
  @media (max-width:430px){
    .chair.chair-custom-art{
      width:clamp(90px,25vw,112px) !important;
      max-height:clamp(108px,27vw,138px);
      margin-bottom:clamp(-48px,-7vw,-32px) !important;
    }
  }
  .card.back{
    background:url('{{ asset($currentTeenPattiAssets['card_back'] ?? $teenPattiCustomAssets['teen_patti']['card_back']) }}') center/cover no-repeat !important;
    border:1px solid rgba(255,218,104,.82) !important;
    box-shadow:0 10px 22px rgba(0,0,0,.44), 0 0 12px rgba(255,215,110,.16) !important;
  }
  .card.back::before,
  .card.back::after{
    display:none !important;
    content:none !important;
  }
  .bridge-win-crown{
    top:-52px;
    width:clamp(118px,30vw,210px);
    height:clamp(58px,14vw,104px);
    font-size:0;
    background:url('{{ asset($currentTeenPattiAssets['winner_banner'] ?? $teenPattiCustomAssets['teen_patti']['winner_banner']) }}') center/contain no-repeat;
    filter:drop-shadow(0 0 16px rgba(255,215,110,.72)) drop-shadow(0 10px 20px rgba(0,0,0,.42));
  }
  @media (max-height:520px){
    .teen-title-logo img{height:30px;width:min(28vw,120px)}
    .bridge-win-crown{top:-42px;width:132px;height:68px}
  }

  .net-pill{
    min-width:auto !important;
    gap:5px !important;
    padding-inline:9px !important;
  }
  .net-pill .net-icon{
    width:8px;
    height:8px;
    border-radius:999px;
    background:#ffce5c;
    box-shadow:0 0 12px rgba(255,206,92,.72);
    flex:0 0 8px;
  }
  .net-pill.good .net-icon{background:#41f59b;box-shadow:0 0 12px rgba(65,245,155,.72)}
  .net-pill.warn .net-icon{background:#ffce5c;box-shadow:0 0 12px rgba(255,206,92,.72)}
  .net-pill.bad .net-icon{background:#ff6060;box-shadow:0 0 12px rgba(255,96,96,.72)}
  .net-pill .net-icon i{display:none}
  .net-pill b{
    font:800 .64rem/1 'Orbitron','Poppins',sans-serif;
    letter-spacing:0;
    color:#fff4c7;
  }

  .card.front{
    color:#17120a !important;
    font-family:Georgia,'Times New Roman','Poppins',serif !important;
    text-shadow:none !important;
    background:linear-gradient(180deg,#ffffff,#fffefb 56%,#faf6ed) !important;
    border:1.8px solid rgba(224,196,126,.90) !important;
    box-shadow:0 12px 22px rgba(0,0,0,.34),inset 0 0 0 2px rgba(255,255,255,.54),inset 0 -8px 14px rgba(185,128,28,.10) !important;
  }
  .card.front .card-corner{
    z-index:3;
    padding:0 !important;
    border-radius:0 !important;
    background:transparent !important;
    box-shadow:none !important;
  }
  .card.front .rank,
  .card.front .suit,
  .card.front .center{
    opacity:1 !important;
    visibility:visible !important;
    font-weight:900 !important;
  }
  .card.front .rank{font-size:clamp(.56rem,2.8vw,.82rem) !important}
  .card.front .suit{font-size:clamp(.5rem,2.5vw,.78rem) !important}
  .card.front .center{
    z-index:2;
    font-size:clamp(.68rem,3vw,1.08rem) !important;
    line-height:1 !important;
    filter:none !important;
  }
  .card.front .center small{
    display:none !important;
  }
  .card.front .rank.red,
  .card.front .suit.red,
  .card.front .center.red{color:#c9183f !important}
  .card.front .rank.black,
  .card.front .suit.black,
  .card.front .center.black{color:#10131a !important}

  .board{
    background:linear-gradient(180deg,rgba(18,20,31,.88),rgba(10,12,22,.92)) !important;
    border-color:rgba(255,215,110,.22) !important;
    box-shadow:inset 0 1px 0 rgba(255,255,255,.08),0 8px 18px rgba(0,0,0,.22);
  }
  .board::after{
    content:"";
    position:absolute;
    inset:1px;
    border-radius:inherit;
    border:1px solid rgba(255,238,177,.08);
    pointer-events:none;
  }
  .board-mini{
    opacity:.9 !important;
    color:#d9c27a !important;
    font-weight:900;
  }
  .board-amount{
    font-family:'Orbitron','Poppins',sans-serif;
    color:#fff4c7 !important;
    background:none !important;
    -webkit-text-fill-color:currentColor;
    text-shadow:0 0 14px rgba(255,215,110,.26);
  }
  .won-amount{
    color:#8fffc1 !important;
    text-shadow:0 0 14px rgba(80,255,155,.24);
  }

  .pot.winner-pot .cards .card.front{
    filter:drop-shadow(0 18px 24px rgba(0,0,0,.38)) drop-shadow(0 0 18px rgba(255,215,110,.48));
  }
  .pot.winner-pot .cards .card.front:nth-child(1){animation:royalWinnerCardA 1.05s ease-in-out infinite}
  .pot.winner-pot .cards .card.front:nth-child(2){animation:royalWinnerCardB 1.12s ease-in-out infinite .07s}
  .pot.winner-pot .cards .card.front:nth-child(3){animation:royalWinnerCardC 1.18s ease-in-out infinite .14s}
  @keyframes royalWinnerCardA{0%,100%{transform:translateX(12px) translateY(0) rotate(-2deg) scale(1)}50%{transform:translateX(7px) translateY(-18px) rotate(-9deg) scale(1.12)}}
  @keyframes royalWinnerCardB{0%,100%{transform:translateX(0) translateY(0) rotate(0deg) scale(1)}50%{transform:translateX(0) translateY(-22px) rotate(1deg) scale(1.15)}}
  @keyframes royalWinnerCardC{0%,100%{transform:translateX(-12px) translateY(0) rotate(2deg) scale(1)}50%{transform:translateX(-7px) translateY(-18px) rotate(9deg) scale(1.12)}}
  .game-container.phase-reveal .pot .cards .card.front,
  .game-container.phase-winner .pot .cards .card.front{
    animation-play-state:running;
  }
  @media (max-width:375px){
    :root{--teen-chip-size:34px;--teen-tool-size:30px}
    .chips-bar{gap:2px !important;padding-left:4px !important;padding-right:4px !important}
    .fast-bid-btn small,.auto-bid-btn small{display:none}
  }
  @media (max-width:430px){
    .chair{width:clamp(48px,17vw,66px) !important;margin-bottom:-12px !important}
    .pot::before{height:42%;border-radius:14px}
  }
  @media (max-height:560px){
    :root{--teen-clock-size:72px;--teen-chip-size:31px;--teen-tool-size:29px}
    .gf-teen-clock{padding:1px 10px 3px}
    .gf-teen-clock::before{display:none}
    .gf-teen-clock .gf-premium-sub{display:none}
    .chair{width:46px !important;margin-bottom:-10px !important}
  }
</style>

<style id="teen-variant-system-layer">
  body,
  .game-container{
    background-image:var(--teen-table-haze);
  }
  .top-bar,
  .coin-section,
  .user-section,
  .status-pill,
  .phase-banner,
  .floating-banner,
  .chips-bar,
  .modal-card,
  .utility-item,
  .icon-btn,
  .tool-btn,
  .fast-bid-btn,
  .auto-bid-btn,
  .board,
  .hand-label,
  .pot-title{
    position:relative;
    overflow:hidden;
    backdrop-filter:blur(18px) saturate(155%);
    -webkit-backdrop-filter:blur(18px) saturate(155%);
    box-shadow:0 18px 42px rgba(0,0,0,.28), 0 0 28px var(--teen-glass-glow), inset 0 1px 0 rgba(255,255,255,.12);
    border-color:var(--teen-glass-border) !important;
  }
  .top-bar::after,
  .coin-section::after,
  .user-section::after,
  .status-pill::after,
  .phase-banner::after,
  .floating-banner::after,
  .chips-bar::after,
  .modal-card::after,
  .board::after,
  .hand-label::after,
  .pot-title::after{
    content:'';
    position:absolute;
    inset:1px;
    border-radius:inherit;
    pointer-events:none;
    background:linear-gradient(180deg, var(--teen-glass-highlight), transparent 56%);
    opacity:.8;
  }
  .coin-section,
  .user-section,
  .status-pill,
  .phase-banner,
  .floating-banner,
  .chips-bar,
  .modal-card,
  .pot-title,
  .hand-label{
    background-image:var(--teen-glass-fill) !important;
  }
  .game-container::after{
    content:'';
    position:absolute;
    inset:0;
    pointer-events:none;
    background:var(--teen-table-haze);
    opacity:.72;
    mix-blend-mode:screen;
  }
  .board{
    box-shadow:0 18px 36px rgba(0,0,0,.28), 0 0 26px var(--teen-board-glow), inset 0 1px 0 rgba(255,255,255,.10);
  }
  .payout-chip-ghost,
  .payout-fly-amount{
    filter:drop-shadow(0 0 14px var(--teen-payout-glow));
  }
  .timer-orb{
    --timer-color:var(--teen-timer-ring, #46e88a);
    --timer-angle:-90deg;
  }
  .timer-progress{
    box-shadow:0 0 18px var(--teen-timer-glow);
  }
  .timer-hand{
    position:absolute;
    left:50%;
    top:50%;
    width:3px;
    height:34%;
    border-radius:999px;
    pointer-events:none;
    transform-origin:50% calc(100% - 2px);
    transform:translate(-50%, -100%) rotate(var(--timer-angle));
    background:linear-gradient(180deg, rgba(255,255,255,.98), var(--teen-countdown-hand));
    box-shadow:0 0 16px var(--teen-timer-glow);
    z-index:3;
  }
  .timer-pivot{
    position:absolute;
    left:50%;
    top:50%;
    width:12px;
    height:12px;
    border-radius:50%;
    transform:translate(-50%, -50%);
    background:radial-gradient(circle, rgba(255,255,255,.98) 0%, var(--teen-countdown-hand) 55%, rgba(0,0,0,.08) 100%);
    box-shadow:0 0 14px var(--teen-timer-glow);
    z-index:4;
  }
  .coin-sand{
    position:fixed;
    left:0;
    top:0;
    width:10px;
    height:10px;
    border-radius:50%;
    pointer-events:none;
    z-index:1210;
    background:radial-gradient(circle at 35% 35%, rgba(255,255,255,.98) 0%, var(--teen-coin-sand-color) 48%, rgba(255,255,255,0) 76%);
    box-shadow:0 0 18px var(--teen-coin-sand-soft);
    transform:translate(-50%, -50%);
  }
</style>

<style id="all-game-mobile-fit-layer">
  html,body,.game-container{width:100vw;height:100dvh;max-width:100vw;max-height:100dvh;overflow:hidden}
  .game-content,.shell,.top-stack,.bottom-stack,.chips-bar{max-width:none;width:100vw}
  .chips-bar{
    position:fixed !important;
    left:0 !important;
    right:0 !important;
    bottom:0 !important;
    width:100vw !important;
    min-height:calc(var(--chips-bar-h) + env(safe-area-inset-bottom)) !important;
    max-height:calc(var(--chips-bar-h) + env(safe-area-inset-bottom)) !important;
    padding:6px max(6px,env(safe-area-inset-right)) max(6px,env(safe-area-inset-bottom)) max(6px,env(safe-area-inset-left)) !important;
    display:flex !important;
    flex-wrap:nowrap !important;
    align-items:center !important;
    justify-content:space-evenly !important;
    gap:clamp(2px,1vw,6px) !important;
    overflow:hidden !important;
    z-index:140 !important;
    border-radius:0 !important;
  }
  .bottom-stack{bottom:calc(var(--chips-bar-h) + env(safe-area-inset-bottom)) !important}
  @media (min-height:700px){
    .bottom-stack{bottom:calc(var(--chips-bar-h) + env(safe-area-inset-bottom) + clamp(150px,24vh,220px)) !important}
  }
  .chip,.fast-bid-btn,.auto-bid-btn,.tool-btn{flex:0 1 auto;min-width:0}
  @media (max-width:480px){
    .game-content,.shell,.top-stack,.bottom-stack,.chips-bar{width:100vw;max-width:100vw}
    .top-stack,.bottom-stack{padding-left:6px;padding-right:6px}
  }
  @media (max-height:450px){
    :root{--top-bar-h:40px;--chips-bar-h:46px;--card-w:32px;--card-h:48px}
    .top-bar{min-height:40px;padding:4px 8px}
    .coin-section{min-width:92px;padding:4px 8px}.coin-amount{font-size:.74rem}
    .icon-btn{width:30px;height:30px}.user-section{display:none}
    .top-stack{top:38px;gap:2px;padding-top:0}
    .status-strip{gap:4px}.status-pill{padding:3px 6px;font-size:.44rem}
    .timer-orb,.gf-premium-clock{width:52px !important;height:52px !important;min-width:52px !important;min-height:52px !important}
    .timer-value{font-size:1.16rem}.timer-sub{display:none}
    .bottom-stack{bottom:calc(var(--chips-bar-h) + env(safe-area-inset-bottom) + 8px) !important;gap:4px;padding-left:8px !important;padding-right:8px !important}
    .pots,.boards{gap:4px}.pot{min-height:82px;padding:2px 2px 0}.chair{display:none}
    .cards{height:46px;min-height:46px}.hand-label{display:none !important}.pot-title{font-size:.66rem;padding:2px 6px}
    .board{min-height:54px;padding:5px 4px;border-radius:12px}.board-amount{font-size:.68rem}.won-amount{font-size:.62rem}.board-mini{font-size:.38rem}
    .chips-bar .chip,.chips-bar .tool-btn,.fast-bid-btn,.auto-bid-btn{width:30px;height:30px;flex-basis:30px;border-radius:9px}
    .chip-face{width:28px;height:28px}.fast-bid-btn small,.auto-bid-btn small{display:none}
  }
  @media (max-height:325px){
    :root{--top-bar-h:36px;--chips-bar-h:40px;--card-w:22px;--card-h:34px}
    .top-bar{min-height:36px;padding:3px 6px}.coin-section{min-width:80px}.coin-icon{font-size:14px}
    .icon-buttons{gap:4px}.icon-btn{width:26px;height:26px;font-size:.72rem}
    .top-stack{top:34px}.status-strip{display:none}
    .timer-orb,.gf-premium-clock{width:42px !important;height:42px !important;min-width:42px !important;min-height:42px !important}
    .bottom-stack{bottom:calc(var(--chips-bar-h) + env(safe-area-inset-bottom)) !important}
    .pot{min-height:48px}.cards{height:32px;min-height:32px}.pot-title{font-size:.5rem}
    .board{min-height:36px;padding:3px 2px}.board-amount,.won-amount{font-size:.5rem}.board-mini{display:none}
    .chips-bar .chip,.chips-bar .tool-btn,.fast-bid-btn,.auto-bid-btn{width:25px;height:25px;flex-basis:25px}
    .chip-face{width:23px;height:23px}
  }
</style>
<style id="teen-modern-board-chip-refresh">
  .boards.sticky-boards{
    gap:clamp(5px,1.4vw,12px) !important;
    padding:0 clamp(3px,1vw,8px) !important;
    align-items:start !important;
  }
  .board{
    --board-accent:#ffd76e;
    --board-accent-soft:rgba(255,215,110,.18);
    --board-rim:rgba(255,215,110,.58);
    min-height:clamp(72px,11.6vh,98px) !important;
    padding:clamp(7px,1.2vh,11px) clamp(5px,1.2vw,10px) clamp(6px,1.1vh,10px) !important;
    border:1px solid var(--board-rim) !important;
    border-radius:18px !important;
    background:
      linear-gradient(180deg, rgba(255,255,255,.13), rgba(255,255,255,0) 38%),
      radial-gradient(circle at 50% -28%, var(--board-accent-soft), transparent 60%),
      linear-gradient(145deg, rgba(20,17,28,.94), rgba(5,9,18,.97)) !important;
    box-shadow:
      0 12px 26px rgba(0,0,0,.36),
      0 0 22px var(--board-accent-soft),
      inset 0 1px 0 rgba(255,255,255,.16),
      inset 0 -16px 22px rgba(0,0,0,.18) !important;
    isolation:isolate;
    transform:translateZ(0);
    align-self:start !important;
    justify-content:center !important;
    align-items:stretch !important;
    gap:6px !important;
  }
  .board[data-board="A"]{--board-accent:#ff5475;--board-accent-soft:rgba(255,84,117,.24);--board-rim:rgba(255,116,139,.70)}
  .board[data-board="B"]{--board-accent:#4fa2ff;--board-accent-soft:rgba(79,162,255,.25);--board-rim:rgba(105,183,255,.70)}
  .board[data-board="C"]{--board-accent:#42dd82;--board-accent-soft:rgba(66,221,130,.24);--board-rim:rgba(98,239,156,.70)}
  .board::before{
    content:"";
    position:absolute;
    inset:1px;
    border-radius:inherit;
    pointer-events:none;
    z-index:0;
    background:
      linear-gradient(135deg, rgba(255,255,255,.18), transparent 28%, rgba(255,215,110,.10) 64%, transparent),
      linear-gradient(180deg, rgba(255,255,255,.08), transparent 55%);
    opacity:.9;
  }
  .board::after{
    content:"" !important;
    position:absolute !important;
    left:-42% !important;
    top:-115% !important;
    width:52% !important;
    height:250% !important;
    inset:auto !important;
    border-radius:999px !important;
    pointer-events:none !important;
    z-index:1 !important;
    background:linear-gradient(90deg, transparent, rgba(255,255,255,.16), transparent) !important;
    opacity:.34 !important;
    transform:rotate(23deg) !important;
  }
  .board-top,
  .board-bottom,
  .flying-win,
  .board-badge-plus{
    position:relative;
    z-index:2;
  }
  .board-payout{
    z-index:1;
  }
  .flying-win{
    position:absolute !important;
    right:8px !important;
    bottom:8px !important;
    z-index:4 !important;
  }
  .board-badge-plus{
    position:absolute !important;
    top:7px !important;
    right:8px !important;
    z-index:4 !important;
  }
  .board-top,
  .board-bottom{
    width:100%;
    min-height:32px;
    display:flex !important;
    flex-direction:row !important;
    align-items:center !important;
    justify-content:space-between !important;
    gap:7px !important;
    padding:5px 8px !important;
    border:1px solid rgba(255,255,255,.10);
    border-radius:11px;
    background:
      linear-gradient(180deg, rgba(255,255,255,.07), rgba(255,255,255,0)),
      rgba(0,0,0,.22);
    box-shadow:inset 0 1px 0 rgba(255,255,255,.08);
  }
  .board-bottom{
    border-color:rgba(128,255,184,.14);
    background:
      linear-gradient(180deg, rgba(128,255,184,.08), rgba(128,255,184,0)),
      rgba(0,0,0,.18);
  }
  .board-amount{
    order:2;
    min-width:0;
    font-size:clamp(.74rem,2vw,1rem) !important;
    color:#fff0b6 !important;
    background:linear-gradient(180deg,#fffdf0,#ffd76e 62%,#ffad3b) !important;
    -webkit-background-clip:text !important;
    background-clip:text !important;
    text-shadow:0 0 14px rgba(255,215,110,.22) !important;
    text-align:right !important;
    line-height:1 !important;
  }
  .board-mini{
    order:1;
    flex:0 0 auto;
    color:rgba(255,255,255,.66) !important;
    opacity:1 !important;
    letter-spacing:0 !important;
    font-weight:800 !important;
    text-transform:none !important;
    font-size:clamp(.48rem,1.25vw,.62rem) !important;
    line-height:1 !important;
  }
  .won-amount{
    order:2;
    min-width:0;
    font-size:clamp(.72rem,1.9vw,.96rem) !important;
    color:#b9ffd4 !important;
    text-shadow:0 0 15px rgba(70,255,150,.28) !important;
    text-align:right !important;
    line-height:1 !important;
  }
  .board-payout{
    position:absolute !important;
    inset:0 !important;
    top:0 !important;
    left:0 !important;
    right:0 !important;
    bottom:0 !important;
    display:flex !important;
    align-items:center !important;
    justify-content:center !important;
    align-self:auto !important;
    padding:0 !important;
    border:none !important;
    background:none !important;
    box-shadow:none !important;
    color:rgba(255,243,191,.10) !important;
    font-family:'Orbitron','Poppins',sans-serif !important;
    font-size:clamp(1.12rem,5vw,1.65rem) !important;
    font-weight:900 !important;
    letter-spacing:.08em !important;
    line-height:1 !important;
    text-transform:uppercase !important;
    text-shadow:none !important;
    white-space:nowrap !important;
    pointer-events:none !important;
  }
  .board.touchable{
    transform:translateY(-2px) scale(1.01) !important;
    border-width:1px !important;
    box-shadow:
      0 16px 30px rgba(0,0,0,.38),
      0 0 0 1px rgba(255,245,190,.18),
      0 0 28px var(--board-accent-soft),
      inset 0 1px 0 rgba(255,255,255,.18) !important;
  }
  .board.touchable:active{transform:translateY(1px) scale(.985) !important}
  .board.winner{
    border-color:#fff1a8 !important;
    box-shadow:
      0 0 0 1px rgba(255,255,255,.22),
      0 0 34px var(--board-accent-soft),
      0 0 46px rgba(255,215,110,.28),
      0 16px 32px rgba(0,0,0,.42) !important;
  }
  .board.loser{opacity:.45 !important;filter:saturate(.55) grayscale(.45) !important}

  .chips-bar{
    --tray-gold:rgba(255,215,110,.62);
    background:
      linear-gradient(180deg, rgba(255,255,255,.08), rgba(255,255,255,0) 32%),
      radial-gradient(circle at 50% 0%, rgba(255,215,110,.16), transparent 56%),
      linear-gradient(180deg, rgba(16,13,24,.96), rgba(2,5,12,.98)) !important;
    border-top:1px solid var(--tray-gold) !important;
    box-shadow:
      0 -16px 36px rgba(0,0,0,.46),
      0 -1px 0 rgba(255,255,255,.10),
      inset 0 1px 0 rgba(255,255,255,.14) !important;
  }
  .chips-bar::before{
    content:"" !important;
    position:absolute !important;
    left:8px !important;
    right:8px !important;
    top:3px !important;
    height:1px !important;
    border-radius:999px !important;
    pointer-events:none !important;
    background:linear-gradient(90deg, transparent, rgba(255,244,190,.66), transparent) !important;
    opacity:.84 !important;
  }
  .chips-bar::after{
    content:"" !important;
    position:absolute !important;
    inset:1px 0 auto 0 !important;
    height:24px !important;
    border-radius:0 !important;
    pointer-events:none !important;
    background:linear-gradient(180deg, rgba(255,255,255,.08), transparent) !important;
    opacity:.7 !important;
  }
  .chips-bar .chip{
    border-radius:50% !important;
    opacity:.52 !important;
    filter:saturate(.72) grayscale(.28) drop-shadow(0 8px 12px rgba(0,0,0,.34)) !important;
  }
  .chips-bar .chip.live{
    opacity:1 !important;
    filter:saturate(1.08) drop-shadow(0 9px 13px rgba(0,0,0,.38)) !important;
  }
  .chips-bar .chip.live[aria-pressed="false"]{
    transform:translateY(5px) scale(.96) !important;
    opacity:.9 !important;
  }
  .chips-bar .chip::before{
    inset:1px !important;
    border:1px solid rgba(255,232,155,0) !important;
  }
  .chips-bar .chip::after{
    inset:6px !important;
    background:radial-gradient(circle at 32% 26%, rgba(255,255,255,.45), transparent 31%) !important;
    opacity:.72 !important;
  }
  .chips-bar .chip.selected,
  .chips-bar .chip.live[aria-pressed="true"]{
    transform:translateY(-6px) scale(1.08) !important;
    opacity:1 !important;
    filter:saturate(1.18) drop-shadow(0 0 14px rgba(255,215,110,.42)) drop-shadow(0 12px 16px rgba(0,0,0,.42)) !important;
  }
  .chips-bar .chip.selected .chip-face,
  .chips-bar .chip.live[aria-pressed="true"] .chip-face{
    transform:translateY(-2px) !important;
    filter:drop-shadow(0 0 20px rgba(255,215,110,.8)) drop-shadow(0 10px 16px rgba(0,0,0,.48)) !important;
  }
  .chips-bar .chip.selected::before,
  .chips-bar .chip.live[aria-pressed="true"]::before{
    border-color:rgba(255,239,170,.9) !important;
    box-shadow:0 0 0 1px rgba(255,255,255,.22) inset,0 0 18px rgba(255,215,110,.5) !important;
  }
  .chips-bar .chip.live:active{transform:translateY(-2px) scale(.98) !important}
  .hand-label{
    display:none !important;
    visibility:hidden !important;
    opacity:0 !important;
    pointer-events:none !important;
  }
  .chips-bar .tool-btn,
  .chips-bar .fast-bid-btn{
    border:1px solid rgba(255,215,110,.42) !important;
    background:
      linear-gradient(180deg, rgba(255,255,255,.14), rgba(255,255,255,0) 44%),
      linear-gradient(145deg, rgba(24,21,34,.96), rgba(7,10,20,.98)) !important;
    color:#fff0b2 !important;
    box-shadow:0 9px 16px rgba(0,0,0,.36), inset 0 1px 0 rgba(255,255,255,.16) !important;
  }
  .chips-bar .fast-bid-btn.active{
    border-color:rgba(111,217,255,.82) !important;
    color:#d9f8ff !important;
    box-shadow:0 0 0 1px rgba(111,217,255,.20),0 0 18px rgba(111,217,255,.24),0 9px 16px rgba(0,0,0,.36) !important;
  }
  @media (max-height:450px){
    .board{min-height:54px !important;padding:5px 4px !important;border-radius:12px !important}
    .board-payout{font-size:clamp(.92rem,4.4vw,1.14rem) !important;letter-spacing:.06em !important}
    .chips-bar::before{left:5px !important;right:5px !important}
    .chips-bar .chip.selected{transform:translateY(-3px) scale(1.05) !important}
  }
  @media (max-height:325px){
    .board{min-height:36px !important;padding:3px 2px !important;border-radius:10px !important}
  }
</style>
@include('game_final.partials.mobile_fit_styles')
<style id="teen-patti-mobile-fit-postfix">
  body.teen-patti-premium-popup .game-container .hand-label.reveal-label{
    display:block !important;
    visibility:visible !important;
    opacity:1 !important;
    pointer-events:none !important;
    position:absolute !important;
    top:67% !important;
    bottom:auto !important;
    left:50% !important;
    transform:translate(-50%, -50%) !important;
    z-index:26 !important;
    max-width:82% !important;
    text-align:center !important;
    animation:teenSetNameMiddlePop .45s cubic-bezier(.2,.8,.2,1) !important;
  }

  @keyframes teenSetNameMiddlePop{
    0%{opacity:0;filter:brightness(.9) saturate(.9)}
    55%{opacity:1;filter:brightness(1.18) saturate(1.18)}
    100%{opacity:1;filter:brightness(1) saturate(1)}
  }

  body.teen-patti-premium-popup .game-container .boards.sticky-boards{
    gap:6px !important;
    padding:0 4px !important;
    align-items:stretch !important;
  }
  body.teen-patti-premium-popup .game-container .board{
    --board-seat-bg:rgba(255,215,110,.92);
    --board-seat-ink:#181015;
    --board-rim-strong:rgba(255,215,110,.46);
    min-height:86px !important;
    padding:10px 9px 9px !important;
    border:1px solid var(--board-rim-strong) !important;
    border-radius:12px !important;
    overflow:hidden !important;
    display:flex !important;
    flex-direction:column !important;
    justify-content:flex-end !important;
    align-items:stretch !important;
    gap:5px !important;
    background:
      linear-gradient(180deg, rgba(255,255,255,.10), rgba(255,255,255,0) 36%),
      radial-gradient(circle at 10% 0%, var(--board-accent-soft), transparent 46%),
      linear-gradient(155deg, rgba(13,17,24,.96), rgba(4,8,14,.98)) !important;
    box-shadow:
      0 10px 22px rgba(0,0,0,.36),
      0 0 0 1px rgba(255,255,255,.06) inset,
      0 0 16px var(--board-accent-soft),
      inset 0 1px 0 rgba(255,255,255,.12),
      inset 0 -16px 20px rgba(0,0,0,.18) !important;
  }
  body.teen-patti-premium-popup .game-container .board[data-board="A"]{--board-seat-bg:#ff6c87;--board-seat-ink:#22070f;--board-rim-strong:rgba(255,116,139,.58)}
  body.teen-patti-premium-popup .game-container .board[data-board="B"]{--board-seat-bg:#65b1ff;--board-seat-ink:#061322;--board-rim-strong:rgba(105,183,255,.58)}
  body.teen-patti-premium-popup .game-container .board[data-board="C"]{--board-seat-bg:#58ea94;--board-seat-ink:#05200e;--board-rim-strong:rgba(98,239,156,.58)}
  body.teen-patti-premium-popup .game-container .board::before{
    content:attr(data-board) !important;
    position:absolute !important;
    inset:auto !important;
    left:7px !important;
    top:6px !important;
    width:19px !important;
    min-width:19px !important;
    height:19px !important;
    display:grid !important;
    place-items:center !important;
    z-index:4 !important;
    border-radius:50% !important;
    border:1px solid rgba(255,255,255,.28) !important;
    background:linear-gradient(180deg, rgba(255,255,255,.32), transparent 50%), var(--board-seat-bg) !important;
    color:var(--board-seat-ink) !important;
    font-family:'Orbitron','Poppins',sans-serif !important;
    font-size:.62rem !important;
    font-weight:900 !important;
    letter-spacing:0 !important;
    line-height:1 !important;
    text-shadow:none !important;
    box-shadow:0 5px 10px rgba(0,0,0,.28), inset 0 1px 0 rgba(255,255,255,.36) !important;
  }
  body.teen-patti-premium-popup .game-container .board::after{
    content:"" !important;
    position:absolute !important;
    inset:0 auto 0 0 !important;
    width:3px !important;
    height:auto !important;
    z-index:3 !important;
    border-radius:12px 0 0 12px !important;
    background:linear-gradient(180deg, transparent, var(--board-seat-bg) 18%, var(--board-seat-bg) 82%, transparent) !important;
    opacity:.78 !important;
    transform:none !important;
    pointer-events:none !important;
  }
  body.teen-patti-premium-popup .game-container .board-payout{
    position:absolute !important;
    inset:6px 7px auto auto !important;
    width:auto !important;
    height:18px !important;
    min-width:28px !important;
    padding:0 6px !important;
    display:flex !important;
    align-items:center !important;
    justify-content:center !important;
    z-index:4 !important;
    border:1px solid rgba(255,255,255,.13) !important;
    border-radius:999px !important;
    background:rgba(0,0,0,.22) !important;
    color:rgba(255,244,194,.80) !important;
    font-size:.56rem !important;
    font-weight:900 !important;
    letter-spacing:0 !important;
    line-height:1 !important;
    text-shadow:0 0 10px rgba(255,215,110,.24) !important;
    pointer-events:none !important;
  }
  body.teen-patti-premium-popup .game-container .board-top,
  body.teen-patti-premium-popup .game-container .board-bottom{
    min-height:24px !important;
    width:100% !important;
    padding:0 !important;
    border:none !important;
    border-radius:0 !important;
    background:transparent !important;
    box-shadow:none !important;
    display:flex !important;
    flex-direction:row !important;
    align-items:center !important;
    justify-content:space-between !important;
    gap:6px !important;
    position:relative !important;
    z-index:3 !important;
  }
  body.teen-patti-premium-popup .game-container .board-top{
    margin-top:18px !important;
    padding-bottom:3px !important;
    border-bottom:1px solid rgba(255,255,255,.10) !important;
  }
  body.teen-patti-premium-popup .game-container .board-bottom{
    padding-top:1px !important;
  }
  body.teen-patti-premium-popup .game-container .board-mini{
    order:1 !important;
    flex:0 0 auto !important;
    color:rgba(255,255,255,.72) !important;
    opacity:1 !important;
    font-size:.52rem !important;
    font-weight:800 !important;
    letter-spacing:0 !important;
    line-height:1 !important;
    text-transform:uppercase !important;
  }
  body.teen-patti-premium-popup .game-container .board-amount,
  body.teen-patti-premium-popup .game-container .won-amount{
    order:2 !important;
    min-width:0 !important;
    max-width:70% !important;
    overflow:hidden !important;
    text-overflow:ellipsis !important;
    white-space:nowrap !important;
    text-align:right !important;
    letter-spacing:0 !important;
    line-height:1 !important;
  }
  body.teen-patti-premium-popup .game-container .board-amount{
    font-size:.98rem !important;
    color:#ffe99f !important;
    background:linear-gradient(180deg,#fff9df,#ffd76e 66%,#ffac3d) !important;
    -webkit-background-clip:text !important;
    background-clip:text !important;
    text-shadow:0 0 12px rgba(255,215,110,.26) !important;
  }
  body.teen-patti-premium-popup .game-container .won-amount{
    font-size:.88rem !important;
    color:#aaffcf !important;
    text-shadow:0 0 12px rgba(88,234,148,.26) !important;
  }
  body.teen-patti-premium-popup .game-container .board.touchable,
  body.teen-patti-premium-popup .game-container .board.live,
  body.teen-patti-premium-popup .game-container .board.selected-target{
    transform:translateY(-2px) !important;
    border-color:rgba(255,244,190,.72) !important;
    box-shadow:
      0 16px 30px rgba(0,0,0,.42),
      0 0 0 1px rgba(255,255,255,.12) inset,
      0 0 28px var(--board-accent-soft),
      inset 0 1px 0 rgba(255,255,255,.2) !important;
  }
  body.teen-patti-premium-popup .game-container .board.winner,
  body.teen-patti-premium-popup .game-container .board.winner-board{
    border-color:#fff1a8 !important;
    filter:saturate(1.18) !important;
    box-shadow:
      0 0 0 1px rgba(255,255,255,.18) inset,
      0 0 34px var(--board-accent-soft),
      0 0 46px rgba(255,215,110,.26),
      0 16px 32px rgba(0,0,0,.42) !important;
  }
  body.teen-patti-premium-popup .game-container .board.loser{
    opacity:.56 !important;
    filter:saturate(.66) grayscale(.34) !important;
  }
  body.teen-patti-premium-popup .winner-hand-preview[hidden]{
    display:none !important;
  }
  body.teen-patti-premium-popup .winner-hand-preview{
    width:min(230px, 100%) !important;
    margin:10px auto 0 !important;
    padding:8px 10px 9px !important;
    border:1px solid rgba(255,215,110,.28) !important;
    border-radius:16px !important;
    background:
      linear-gradient(180deg, rgba(255,255,255,.08), rgba(255,255,255,0) 40%),
      rgba(0,0,0,.18) !important;
    box-shadow:inset 0 1px 0 rgba(255,255,255,.10), 0 10px 18px rgba(0,0,0,.18) !important;
  }
  body.teen-patti-premium-popup .winner-hand-preview.winner-hand-pop{
    animation:winnerHandPreviewPop .34s cubic-bezier(.2,.85,.25,1.1);
  }
  @keyframes winnerHandPreviewPop{
    0%{opacity:0;transform:translateY(6px) scale(.96)}
    100%{opacity:1;transform:translateY(0) scale(1)}
  }
  body.teen-patti-premium-popup .winner-hand-meta{
    display:flex !important;
    align-items:center !important;
    justify-content:center !important;
    gap:7px !important;
    margin-bottom:7px !important;
    font-family:var(--teen-popup-copy-font) !important;
    line-height:1 !important;
    text-transform:uppercase !important;
  }
  body.teen-patti-premium-popup .winner-hand-meta span{
    padding:4px 7px !important;
    border-radius:999px !important;
    background:rgba(255,215,110,.15) !important;
    border:1px solid rgba(255,215,110,.26) !important;
    color:#ffe7a1 !important;
    font-size:.52rem !important;
    font-weight:900 !important;
    letter-spacing:.08em !important;
  }
  body.teen-patti-premium-popup .winner-hand-meta strong{
    min-width:0 !important;
    overflow:hidden !important;
    text-overflow:ellipsis !important;
    white-space:nowrap !important;
    color:rgba(255,245,224,.82) !important;
    font-size:.56rem !important;
    font-weight:900 !important;
    letter-spacing:.08em !important;
  }
  body.teen-patti-premium-popup .winner-hand-cards{
    display:flex !important;
    align-items:center !important;
    justify-content:center !important;
    gap:5px !important;
    min-height:54px !important;
  }
  body.teen-patti-premium-popup .winner-hand-cards .winner-popup-card.card{
    width:38px !important;
    height:54px !important;
    min-width:38px !important;
    min-height:54px !important;
    margin:0 !important;
    transform:none !important;
    position:relative !important;
    border-radius:8px !important;
    box-shadow:0 8px 14px rgba(0,0,0,.34), inset 0 1px 0 rgba(255,255,255,.42) !important;
    transition:none !important;
  }
  body.teen-patti-premium-popup .winner-hand-cards .winner-popup-card.card:nth-child(n){
    transform:none !important;
  }
  body.teen-patti-premium-popup .winner-hand-cards .winner-popup-card .card-corner.top-left{
    top:3px !important;
    left:4px !important;
  }
  body.teen-patti-premium-popup .winner-hand-cards .winner-popup-card .card-corner.bottom-right{
    right:4px !important;
    bottom:3px !important;
  }
  body.teen-patti-premium-popup .winner-hand-cards .winner-popup-card .rank{
    font-size:.58rem !important;
  }
  body.teen-patti-premium-popup .winner-hand-cards .winner-popup-card .suit{
    font-size:.52rem !important;
  }
  body.teen-patti-premium-popup .winner-hand-cards .winner-popup-card .center{
    font-size:.86rem !important;
  }

  @media (max-height:450px){
    :root{--top-bar-h:42px;--chips-bar-h:46px;--teen-clock-size:94px;--teen-chip-size:40px;--teen-tool-size:28px}
    body.teen-patti-premium-popup .game-container .top-bar{min-height:42px !important;padding:3px 8px !important}
    body.teen-patti-premium-popup .game-container .coin-section{min-width:98px !important;min-height:32px !important;padding:4px 9px !important}
    body.teen-patti-premium-popup .game-container .coin-amount{font-size:.76rem !important}
    body.teen-patti-premium-popup .game-container .icon-btn{width:31px !important;height:31px !important;font-size:.78rem !important}
    body.teen-patti-premium-popup .game-container .top-stack{top:40px !important;gap:2px !important}
    body.teen-patti-premium-popup .game-container .status-strip{gap:5px !important}
    body.teen-patti-premium-popup .game-container .status-pill{padding:4px 7px !important;font-size:.52rem !important;letter-spacing:.04em !important;min-height:20px !important}
    body.teen-patti-premium-popup .game-container .status-pill i{font-size:.62rem !important}
    body.teen-patti-premium-popup .game-container #roundCount{font-size:.58rem !important;line-height:1 !important}
    body.teen-patti-premium-popup .game-container #netPill{min-width:88px !important}
    body.teen-patti-premium-popup .game-container #netStat{font-size:.68rem !important;line-height:1 !important}
    body.teen-patti-premium-popup .game-container #netIcon{font-size:.58rem !important}
    body.teen-patti-premium-popup .game-container .timer-orb,
    body.teen-patti-premium-popup .game-container .gf-premium-clock{width:94px !important;height:94px !important;min-width:94px !important;min-height:94px !important}
    body.teen-patti-premium-popup .game-container .gf-teen-clock .gf-premium-clock{--gf-size:94px !important;--gf-text-size:2.9rem !important;--gf-label-size:.58rem !important}
    body.teen-patti-premium-popup .game-container .timer-value{font-size:2rem !important;letter-spacing:-.02em !important}
    body.teen-patti-premium-popup .game-container .bottom-stack{bottom:calc(var(--chips-bar-h,46px) + env(safe-area-inset-bottom) + 12px) !important;gap:5px !important}
    body.teen-patti-premium-popup .game-container .pots,
    body.teen-patti-premium-popup .game-container .boards{gap:4px !important}
    body.teen-patti-premium-popup .game-container .pots{position:relative !important;z-index:4 !important}
    body.teen-patti-premium-popup .game-container .boards.sticky-boards{position:relative !important;top:auto !important;bottom:auto !important;transform:none !important;z-index:2 !important}
    body.teen-patti-premium-popup .game-container .pot{min-height:98px !important;padding:0 2px 0 !important;overflow:visible !important;z-index:4 !important}
    body.teen-patti-premium-popup .game-container .chair{display:block !important;width:40px !important;margin-bottom:-6px !important;z-index:3 !important}
    body.teen-patti-premium-popup .game-container .chair.chair-custom-art{width:72px !important;max-height:92px !important;margin-bottom:-20px !important;z-index:3 !important}
    body.teen-patti-premium-popup .game-container .cards{height:48px !important;min-height:48px !important;margin-bottom:8px !important;position:relative !important;z-index:5 !important}
    body.teen-patti-premium-popup .game-container .hand-label.reveal-label{position:absolute !important;top:67% !important;bottom:auto !important;font-size:.46rem !important;max-width:74% !important}
    body.teen-patti-premium-popup .game-container .pot-title{font-size:.66rem !important;padding:2px 6px !important}
    body.teen-patti-premium-popup .game-container .board{min-height:64px !important;padding:5px 6px 5px !important;border-radius:10px !important;position:relative !important;z-index:1 !important;gap:2px !important}
    body.teen-patti-premium-popup .game-container .board::before{inset:auto !important;left:5px !important;top:4px !important;width:16px !important;min-width:16px !important;height:16px !important;border-radius:50% !important;font-size:.48rem !important}
    body.teen-patti-premium-popup .game-container .board::after{inset:0 auto 0 0 !important;width:2px !important;height:auto !important;border-radius:10px 0 0 10px !important}
    body.teen-patti-premium-popup .game-container .board-top,
    body.teen-patti-premium-popup .game-container .board-bottom{
      min-height:16px !important;
      padding:0 !important;
      border:none !important;
      border-radius:0 !important;
      background:transparent !important;
      box-shadow:none !important;
      gap:5px !important;
    }
    body.teen-patti-premium-popup .game-container .board-top{margin-top:13px !important;padding-bottom:2px !important;border-bottom:1px solid rgba(255,255,255,.10) !important}
    body.teen-patti-premium-popup .game-container .board-bottom{padding-top:0 !important}
    body.teen-patti-premium-popup .game-container .board-amount{font-size:.74rem !important}
    body.teen-patti-premium-popup .game-container .won-amount{font-size:.66rem !important}
    body.teen-patti-premium-popup .game-container .board-mini{font-size:.42rem !important}
    body.teen-patti-premium-popup .game-container .board-payout{display:flex !important;position:absolute !important;inset:4px 5px auto auto !important;width:auto !important;height:14px !important;min-width:22px !important;padding:0 4px !important;align-items:center !important;justify-content:center !important;font-size:.44rem !important;letter-spacing:0 !important;color:rgba(255,243,191,.88) !important;background:rgba(0,0,0,.28) !important;border-radius:999px !important}
    body.teen-patti-premium-popup .game-container .chips-bar{min-height:calc(var(--chips-bar-h) + env(safe-area-inset-bottom)) !important;max-height:calc(var(--chips-bar-h) + env(safe-area-inset-bottom)) !important;padding:2px 0 max(1px,env(safe-area-inset-bottom)) !important;gap:4px !important;justify-content:center !important;overflow:visible !important;position:fixed !important;left:0 !important;right:0 !important;bottom:0 !important;top:auto !important}
    body.teen-patti-premium-popup .game-container .chips-bar .chip{width:40px !important;height:40px !important;flex:0 0 40px !important;z-index:1 !important}
    body.teen-patti-premium-popup .game-container .chips-bar .chip + .chip{margin-left:0 !important}
    body.teen-patti-premium-popup .game-container .chips-bar .chip-face{width:36px !important;height:36px !important;filter:drop-shadow(0 8px 14px rgba(0,0,0,.42)) !important}
    body.teen-patti-premium-popup .game-container .chips-bar .chip-label{display:grid !important;font-size:7.4px !important;line-height:1 !important;letter-spacing:-.02em !important}
    body.teen-patti-premium-popup .game-container .chips-bar .tool-btn,
    body.teen-patti-premium-popup .game-container .fast-bid-btn,
    body.teen-patti-premium-popup .game-container .auto-bid-btn{width:28px !important;height:28px !important;flex-basis:28px !important;font-size:.72rem !important;border-radius:9px !important;position:relative !important;right:auto !important;top:auto !important;transform:none !important}
    body.teen-patti-premium-popup .game-container .chips-bar .chip.live[aria-pressed="false"]{transform:translateY(2px) scale(.97) !important;opacity:.92 !important;z-index:1 !important}
    body.teen-patti-premium-popup .game-container .chips-bar .chip.selected,
    body.teen-patti-premium-popup .game-container .chips-bar .chip.live[aria-pressed="true"]{transform:translateY(-2px) scale(1.05) !important;z-index:12 !important}
    body.teen-patti-premium-popup .game-container .chips-bar.locked .chip{opacity:.64 !important;filter:saturate(.88) grayscale(.12) drop-shadow(0 8px 12px rgba(0,0,0,.30)) !important}
    body.teen-patti-premium-popup .game-container .chips-bar.locked .tool-btn,
    body.teen-patti-premium-popup .game-container .chips-bar.locked .fast-bid-btn,
    body.teen-patti-premium-popup .game-container .chips-bar.locked .auto-bid-btn{opacity:.56 !important;filter:saturate(.88) grayscale(.08) !important}
    body.teenpatti-king.teen-patti-premium-popup .game-container .chips-bar .chip-face-king svg text{font-size:24px !important;letter-spacing:.08px !important;paint-order:stroke fill;stroke:rgba(54,16,8,.76);stroke-width:2.2px}
    body.teen-patti-premium-popup .start-pop .modal-card,
    body.teen-patti-premium-popup .stop-pop .modal-card,
    body.teen-patti-premium-popup .winner-pop .modal-card,
    body.teen-patti-premium-popup .loser-pop .modal-card,
    body.teen-patti-premium-popup .nobid-pop .modal-card,
    body.teen-patti-premium-popup .go-pop .modal-card{width:256px !important;min-height:240px !important;padding:66px 14px 12px !important}
    body.teen-patti-premium-popup .start-pop .modal-card h2,
    body.teen-patti-premium-popup .stop-pop .modal-card h2,
    body.teen-patti-premium-popup .winner-pop .modal-card h2,
    body.teen-patti-premium-popup .loser-pop .modal-card h2,
    body.teen-patti-premium-popup .nobid-pop .modal-card h2,
    body.teen-patti-premium-popup .go-pop .modal-card h2{font-size:1.62rem !important;margin-bottom:6px !important}
    body.teen-patti-premium-popup .start-pop .modal-card p,
    body.teen-patti-premium-popup .stop-pop .modal-card p,
    body.teen-patti-premium-popup .winner-pop .modal-card p,
    body.teen-patti-premium-popup .loser-pop .modal-card p,
    body.teen-patti-premium-popup .nobid-pop .modal-card p,
    body.teen-patti-premium-popup .go-pop .modal-card p{font-size:.76rem !important;line-height:1.35 !important}
    body.teen-patti-premium-popup .start-pop .modal-card .popup-kicker,
    body.teen-patti-premium-popup .stop-pop .modal-card .popup-kicker,
    body.teen-patti-premium-popup .winner-pop .modal-card .popup-kicker,
    body.teen-patti-premium-popup .loser-pop .modal-card .popup-kicker,
      body.teen-patti-premium-popup .nobid-pop .modal-card .popup-kicker,
      body.teen-patti-premium-popup .go-pop .modal-card .popup-kicker{font-size:.56rem !important;margin-bottom:8px !important}
    body.teen-patti-premium-popup .winner-pop .modal-card{
      min-height:262px !important;
      padding:62px 14px 18px !important;
    }
    body.teen-patti-premium-popup .winner-pop .modal-card .popup-icon{
      display:none !important;
    }
    body.teen-patti-premium-popup .winner-pop .modal-card .popup-note{
      display:none !important;
    }
    body.teen-patti-premium-popup .winner-hand-preview{
      width:min(198px, 100%) !important;
      margin-top:6px !important;
      padding:6px 8px 7px !important;
      border-radius:13px !important;
    }
    body.teen-patti-premium-popup .winner-hand-meta{
      gap:5px !important;
      margin-bottom:5px !important;
    }
    body.teen-patti-premium-popup .winner-hand-meta span{
      padding:3px 6px !important;
      font-size:.44rem !important;
    }
    body.teen-patti-premium-popup .winner-hand-meta strong{
      font-size:.47rem !important;
      letter-spacing:.06em !important;
    }
    body.teen-patti-premium-popup .winner-hand-cards{
      gap:4px !important;
      min-height:44px !important;
    }
    body.teen-patti-premium-popup .winner-hand-cards .winner-popup-card.card{
      width:31px !important;
      height:44px !important;
      min-width:31px !important;
      min-height:44px !important;
      border-radius:7px !important;
    }
    body.teen-patti-premium-popup .winner-hand-cards .winner-popup-card .card-corner.top-left{top:2px !important;left:3px !important}
    body.teen-patti-premium-popup .winner-hand-cards .winner-popup-card .card-corner.bottom-right{right:3px !important;bottom:2px !important}
    body.teen-patti-premium-popup .winner-hand-cards .winner-popup-card .rank{font-size:.48rem !important}
    body.teen-patti-premium-popup .winner-hand-cards .winner-popup-card .suit{font-size:.43rem !important}
    body.teen-patti-premium-popup .winner-hand-cards .winner-popup-card .center{font-size:.72rem !important}
  }
  body.teen-patti-premium-popup.teen-patti-premium-popup{
    --teen-popup-frame:none !important;
  }
  body.teen-patti-premium-popup.teen-patti-premium-popup .modal-card,
  body.teen-patti-premium-popup.teen-patti-premium-popup .audio-popup,
  body.teen-patti-premium-popup.teen-patti-premium-popup .utility-modal .modal-card{
    background:
      radial-gradient(circle at 50% 0%, rgba(255,255,255,.13), transparent 34%),
      linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,0) 40%),
      var(--teen-popup-surface) !important;
    background-image:
      radial-gradient(circle at 50% 0%, rgba(255,255,255,.13), transparent 34%),
      linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,0) 40%),
      var(--teen-popup-surface) !important;
    border:1px solid var(--teen-popup-note-border) !important;
    border-radius:26px !important;
    box-shadow:0 28px 78px rgba(0,0,0,.56),0 0 26px var(--teen-phase-popup-glow, rgba(255,215,110,.18)) !important;
    overflow:hidden !important;
  }
  body.teen-patti-premium-popup.teen-patti-premium-popup .modal:not(.utility-modal) .modal-card{
    width:min(90vw, 360px) !important;
    min-height:0 !important;
    padding:30px 26px 22px !important;
  }
  body.teen-patti-premium-popup.teen-patti-premium-popup .audio-popup{
    position:fixed !important;
    left:50% !important;
    top:50% !important;
    bottom:auto !important;
    width:min(92vw, 360px) !important;
    max-width:360px !important;
    min-height:0 !important;
    max-height:min(86dvh, 360px) !important;
    aspect-ratio:auto !important;
    padding:22px !important;
    transform:translate(-50%, -50%) scale(.96) !important;
  }
  body.teen-patti-premium-popup.teen-patti-premium-popup .audio-popup.show{
    transform:translate(-50%, -50%) scale(1) !important;
  }
  body.teen-patti-premium-popup.teen-patti-premium-popup .audio-popup-shell{
    position:relative !important;
    inset:auto !important;
    margin:0 !important;
    padding:0 !important;
  }
  body.teen-patti-premium-popup.teen-patti-premium-popup .utility-modal .modal-card{
    min-height:0 !important;
    padding:22px !important;
  }
  body.teen-patti-premium-popup.teen-patti-premium-popup .modal:not(.utility-modal) .modal-card::before,
  body.teen-patti-premium-popup.teen-patti-premium-popup .modal:not(.utility-modal) .modal-card::after,
  body.teen-patti-premium-popup.teen-patti-premium-popup .modal-card::before,
  body.teen-patti-premium-popup.teen-patti-premium-popup .modal-card::after,
  body.teen-patti-premium-popup.teen-patti-premium-popup .audio-popup::before,
  body.teen-patti-premium-popup.teen-patti-premium-popup .audio-popup::after,
  body.teen-patti-premium-popup.teen-patti-premium-popup .utility-modal .modal-card::before,
  body.teen-patti-premium-popup.teen-patti-premium-popup .utility-modal .modal-card::after{
    content:none !important;
    display:none !important;
    background:none !important;
    border:0 !important;
    box-shadow:none !important;
  }
  body.teen-patti-premium-popup.teen-patti-premium-popup .modal-card > *,
  body.teen-patti-premium-popup.teen-patti-premium-popup .audio-popup-shell > *{
    position:relative !important;
    z-index:2 !important;
  }
  @media (max-height: 450px){
    body.teen-patti-premium-popup.teen-patti-premium-popup .modal:not(.utility-modal) .modal-card{
      width:min(86vw, 294px) !important;
      padding:18px 14px 14px !important;
    }
    body.teen-patti-premium-popup.teen-patti-premium-popup .audio-popup,
    body.teen-patti-premium-popup.teen-patti-premium-popup .utility-modal .modal-card{
      padding:16px !important;
    }
  }
  @media (max-height: 450px){
    body.teen-patti-premium-popup.teen-patti-premium-popup .winner-pop .modal-card{
      min-height:262px !important;
      padding:62px 14px 18px !important;
    }
    body.teen-patti-premium-popup.teen-patti-premium-popup .winner-pop .popup-icon,
    body.teen-patti-premium-popup.teen-patti-premium-popup .winner-pop .popup-note{
      display:none !important;
    }
    body.teen-patti-premium-popup.teen-patti-premium-popup .winner-pop .popup-powered{
      bottom:8px !important;
    }
  }
</style>
</head>
<body class="{{ trim($appVariantClass . ' ' . $variantSystemClass . ' teen-patti-premium-popup teen-patti-blade-' . ($variantFx['blade_id'] ?? 'shared-index') . ' gf-popup-' . ($gameTheme['popup_theme'] ?? 'popup_01') . ' gf-item-' . ($gameTheme['item_theme'] ?? 'default')) }}" style="{{ $variantInlineStyle }}">
<div class="loading-skeleton" id="loadingSkeleton">
  <div class="splash-logo">
    <div class="splash-title">{{ $currentGameName }}</div>
    <div class="splash-sub">{{ $splashSubtitle }}</div>
  </div>
  <div class="skeleton-spinner"></div>
  <div class="splash-progress-wrap">
    <div class="splash-progress"><div class="splash-progress-bar" id="splashProgressBar"></div></div>
    <div class="splash-percent" id="splashPercent">0%</div>
  </div>
  <div class="splash-log" id="splashLog">{{ $splashLoadingText }}</div>
  <div class="skeleton-text"></div>
</div>

<div class="game-container {{ trim($appVariantClass . ' ' . $variantSystemClass) }}" id="gameContainer">
  <div class="top-bar">
    <div class="coin-section" id="balanceSection">
      <i class="fas fa-coins coin-icon"></i>
      <span class="coin-amount" id="balanceText">--</span>
      <div class="balance-watermark" id="userIdWatermark">{{ preg_replace('/\D+/', '', (string) ($displayUserId ?? '0000')) ?: ($displayUserId ?? '0000') }}</div>
      <div class="balance-impact" id="balanceImpact"></div>
      <div class="balance-droplet" id="balanceDroplet"></div>
    </div>
    @if(!empty($currentTeenPattiAssets))
      <div class="user-section teen-title-logo" aria-label="{{ $currentGameName }}">
        <img src="{{ asset($currentTeenPattiAssets['logo']) }}" alt="{{ $currentGameName }}">
        <span class="sr-only" id="username">{{ $displayUserName ?? 'Player' }}</span>
      </div>
    @else
      <div class="user-section"><i class="fas fa-user-circle user-icon"></i><span class="user-name" id="username">{{ $displayUserName ?? 'Player' }}</span></div>
    @endif
    <div class="icon-buttons">
      <button class="icon-btn" id="btnUsers" type="button" aria-label="Users"><i class="fas fa-users"></i></button>
      <button class="icon-btn" id="btnSettings" type="button" onclick="return window.openTeenPattiSettings ? window.openTeenPattiSettings(event) : false" aria-label="Settings"><i class="fas fa-cog"></i></button>
      <button class="icon-btn" id="btnHistory" type="button" aria-label="History"><i class="fas fa-chart-line"></i></button>
    </div>
  </div>
  
  <canvas id="fx"></canvas>
  <div class="game-content">
    <div class="shell">
      <div class="top-stack" id="topStack">
        <div class="status-strip"><div class="status-pill"><i class="fas fa-layer-group"></i> Round <strong id="roundCount">-</strong></div><div class="status-pill net-pill warn" id="netPill" aria-label="Network latency"><span class="net-icon" id="netIcon"><i class="fas fa-signal"></i></span><b id="netStat">--</b></div></div>
        @include('game_final.partials.premium_clock', [
          'theme' => $teenPattiVariant['timer_theme'] ?? 'casino',
          'hostId' => 'timerWrap',
          'hostClass' => 'gf-teen-clock',
          'rootId' => 'timerOrb',
          'rootClass' => 'disabled',
          'valueId' => 'timerValue',
          'subId' => 'timerSub',
          'subText' => 'SYNC',
          'handId' => 'timerHand',
        ])
      </div>
      <div class="middle-fill"></div>
      <div class="bottom-stack" id="bottomStack">
        <div class="pots">
            <div class="pot" data-board="A"><div class="pot-aura"></div><div class="winner-spotlight"></div><img class="chair {{ $seatChairs['A']['class'] }}" src="{{ asset($seatChairs['A']['asset']) }}" alt="{{ $seatTitles['A'] }}"><div class="cards" id="stackA"><div class="card back"></div><div class="card back"></div><div class="card back"></div></div><div class="hand-label" id="labelA">{{ $seatTitles['A'] }}</div><div class="pot-title" data-seat-prefix="{{ $seatPrefix }}">{{ $seatTitles['A'] }}</div></div>
            <div class="pot" data-board="B"><div class="pot-aura"></div><div class="winner-spotlight"></div><img class="chair {{ $seatChairs['B']['class'] }}" src="{{ asset($seatChairs['B']['asset']) }}" alt="{{ $seatTitles['B'] }}"><div class="cards" id="stackB"><div class="card back"></div><div class="card back"></div><div class="card back"></div></div><div class="hand-label" id="labelB">{{ $seatTitles['B'] }}</div><div class="pot-title" data-seat-prefix="{{ $seatPrefix }}">{{ $seatTitles['B'] }}</div></div>
            <div class="pot" data-board="C"><div class="pot-aura"></div><div class="winner-spotlight"></div><img class="chair {{ $seatChairs['C']['class'] }}" src="{{ asset($seatChairs['C']['asset']) }}" alt="{{ $seatTitles['C'] }}"><div class="cards" id="stackC"><div class="card back"></div><div class="card back"></div><div class="card back"></div></div><div class="hand-label" id="labelC">{{ $seatTitles['C'] }}</div><div class="pot-title" data-seat-prefix="{{ $seatPrefix }}">{{ $seatTitles['C'] }}</div></div>
        </div>
        <div class="boards sticky-boards">
          <div class="board" id="boardA" data-board="A"><div class="board-energy"></div><div class="board-payout" id="payoutA">x{{ $formatTeenPattiMultiplier($boardPayoutMultipliers['A']) }}</div><div class="board-top"><div class="board-amount" id="totalA">0</div><div class="board-mini">Total</div></div><div class="board-bottom"><div class="won-amount" id="wonA">0</div><div class="board-mini">You</div></div><div class="flying-win" id="flyA">+0</div><div class="board-badge-plus" id="plusA">+1000</div></div>
          <div class="board" id="boardB" data-board="B"><div class="board-energy"></div><div class="board-payout" id="payoutB">x{{ $formatTeenPattiMultiplier($boardPayoutMultipliers['B']) }}</div><div class="board-top"><div class="board-amount" id="totalB">0</div><div class="board-mini">Total</div></div><div class="board-bottom"><div class="won-amount" id="wonB">0</div><div class="board-mini">You</div></div><div class="flying-win" id="flyB">+0</div><div class="board-badge-plus" id="plusB">+1000</div></div>
          <div class="board" id="boardC" data-board="C"><div class="board-energy"></div><div class="board-payout" id="payoutC">x{{ $formatTeenPattiMultiplier($boardPayoutMultipliers['C']) }}</div><div class="board-top"><div class="board-amount" id="totalC">0</div><div class="board-mini">Total</div></div><div class="board-bottom"><div class="won-amount" id="wonC">0</div><div class="board-mini">You</div></div><div class="flying-win" id="flyC">+0</div><div class="board-badge-plus" id="plusC">+1000</div></div>
        </div>
      </div>
    </div>
  </div>

  <div class="chips-bar" id="chipsBar">
    <button class="chip" data-value="1000" aria-label="1000 chip"><span class="chip-label">1K</span></button>
    <button class="chip" data-value="5000" aria-label="5000 chip"><span class="chip-label">5K</span></button>
    <button class="chip" data-value="10000" aria-label="10000 chip"><span class="chip-label">10K</span></button>
    <button class="chip" data-value="50000" aria-label="50000 chip"><span class="chip-label">50K</span></button>
    <button class="chip" data-value="100000" aria-label="100000 chip"><span class="chip-label">100K</span></button>
    <button class="tool-btn" id="btnRecent" type="button" aria-label="Trend" title="Trend"><i class="fas fa-trophy"></i></button>
  </div>
  <div class="chip-select-hud" id="chipSelectHud" aria-hidden="true"><div class="chip-select-mini" id="chipSelectMini"></div><div class="chip-select-copy"><b>Active Chip</b><span id="chipSelectValue">1000</span></div></div>

  <div class="audio-popup-overlay" id="audioPopupOverlay"></div>
  <div class="audio-popup" id="audioPopup" role="dialog" aria-modal="true" aria-labelledby="audioPopupTitle">
    <div class="audio-popup-shell">
      <div class="audio-popup-header">
        <div class="audio-popup-icon"><i class="fas fa-sliders-h"></i></div>
        <div>
          <h3 id="audioPopupTitle">Game Settings</h3>
          <p>Audio control</p>
        </div>
      </div>
      <div class="audio-controls">
        <button type="button" class="toggle on" data-audio="music" aria-pressed="true">
          <span class="toggle-copy"><i class="fas fa-music"></i><strong>Music</strong><small>Background track</small></span>
          <span class="toggle-switch"><span></span></span>
        </button>
        <button type="button" class="toggle on" data-audio="sound" aria-pressed="true">
          <span class="toggle-copy"><i class="fas fa-volume-up"></i><strong>Sound</strong><small>Chips and cards</small></span>
          <span class="toggle-switch"><span></span></span>
        </button>
        <button type="button" class="toggle on" data-audio="voice" aria-pressed="true">
          <span class="toggle-copy"><i class="fas fa-microphone-alt"></i><strong>Voice</strong><small>Round announce</small></span>
          <span class="toggle-switch"><span></span></span>
        </button>
      </div>
      <button type="button" class="close-audio-btn" id="closeAudioPopup"><i class="fas fa-times"></i><span>Close</span></button>
      <div class="popup-powered">Powerd by JAMBOai</div>
    </div>
  </div>

  <script>
  (function(){
    var popup = document.getElementById('audioPopup');
    var overlay = document.getElementById('audioPopupOverlay');
    var openBtn = document.getElementById('btnSettings');
    var closeBtn = document.getElementById('closeAudioPopup');

    window.openTeenPattiSettings = function(event){
      if(event && typeof event.preventDefault === 'function') event.preventDefault();
      if(event && typeof event.stopPropagation === 'function') event.stopPropagation();
      if(popup) {
        popup.classList.add('show');
        popup.setAttribute('aria-hidden', 'false');
      }
      if(overlay) overlay.classList.add('show');
      return false;
    };

    window.closeTeenPattiSettings = function(){
      if(popup) {
        popup.classList.remove('show');
        popup.setAttribute('aria-hidden', 'true');
      }
      if(overlay) overlay.classList.remove('show');
    };

    if(openBtn) openBtn.addEventListener('click', window.openTeenPattiSettings, true);
    if(closeBtn) closeBtn.addEventListener('click', window.closeTeenPattiSettings);
    if(overlay) overlay.addEventListener('click', window.closeTeenPattiSettings);
  })();
  </script>

  <div class="modal start-pop" id="modalStart">
    <div class="modal-card">
      <div class="popup-kicker">Phase Start</div>
      <div class="popup-accent"></div>
      <div class="popup-icon"><i class="fas fa-dice"></i></div>
      <h2>START BET</h2>
      <p>Place your bets now</p>
      <div class="popup-note">Tap any board to lock your move</div>
      <div class="popup-powered">Powerd by JAMBOai</div>
    </div>
  </div>
  <div class="modal stop-pop" id="modalStop">
    <div class="modal-card">
      <div class="popup-kicker">Bet Lock</div>
      <div class="popup-accent"></div>
      <div class="popup-icon"><i class="fas fa-hourglass-half"></i></div>
      <h2>STOP BET</h2>
      <p>No more bets</p>
      <div class="popup-note">Board is locked and waiting for reveal</div>
      <div class="popup-powered">Powerd by JAMBOai</div>
    </div>
  </div>
  <div class="modal winner-pop" id="modalWin">
    <div class="modal-card">
      <div class="popup-kicker">Winner Result</div>
      <div class="popup-accent"></div>
      <div class="popup-icon"><i class="fas fa-crown"></i></div>
      <h2>YOU WIN</h2>
      <p id="winText">Great!</p>
      <div class="winner-hand-preview" id="winnerHandPreview" hidden aria-live="polite" aria-label="Winning cards">
        <div class="winner-hand-meta">
          <span id="winnerHandBoard">Winner</span>
          <strong id="winnerHandLabel">Winning cards</strong>
        </div>
        <div class="winner-hand-cards" id="winnerHandCards" aria-hidden="true">
          <div class="card winner-popup-card back"></div>
          <div class="card winner-popup-card back"></div>
          <div class="card winner-popup-card back"></div>
        </div>
      </div>
      <div class="popup-note">Payout is transferring to balance</div>
      <div class="popup-powered">Powerd by JAMBOai</div>
    </div>
  </div>
  <script>
  (function(){
    const preview = document.getElementById('winnerHandPreview');
    const boardNode = document.getElementById('winnerHandBoard');
    const labelNode = document.getElementById('winnerHandLabel');
    const cardsNode = document.getElementById('winnerHandCards');
    const slots = cardsNode ? Array.from(cardsNode.querySelectorAll('.winner-popup-card')) : [];

    function escapeHtml(value){
      return String(value == null ? '' : value).replace(/[&<>"']/g, function(mark){
        return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[mark] || mark;
      });
    }

    function suitMeta(rawSuit, fallbackColor){
      const key = String(rawSuit || '').trim().toUpperCase();
      if(key === 'H' || key === 'HEART' || key === 'HEARTS' || key.indexOf('HEART') >= 0 || key.indexOf('&HEART') >= 0) return {symbol:'&hearts;', color:'red'};
      if(key === 'D' || key === 'DIAMOND' || key === 'DIAMONDS' || key.indexOf('DIAM') >= 0 || key.indexOf('&DIAM') >= 0) return {symbol:'&diams;', color:'red'};
      if(key === 'C' || key === 'CLUB' || key === 'CLUBS' || key.indexOf('CLUB') >= 0 || key.indexOf('&CLUB') >= 0) return {symbol:'&clubs;', color:'black'};
      if(key === 'S' || key === 'SPADE' || key === 'SPADES' || key.indexOf('SPADE') >= 0 || key.indexOf('&SPADE') >= 0) return {symbol:'&spades;', color:'black'};
      return {symbol:escapeHtml(rawSuit || 'S'), color:String(fallbackColor || '').toLowerCase() === 'red' ? 'red' : 'black'};
    }

    function parseWinnerCard(input){
      if(Array.isArray(input)){
        const meta = suitMeta(input[1], input[2]);
        return {rank:escapeHtml(input[0] || ''), suit:meta.symbol, color:meta.color};
      }
      const raw = String(input || '').trim();
      if(raw.length < 2) return null;
      const meta = suitMeta(raw.slice(-1));
      return {rank:escapeHtml(raw.slice(0, -1)), suit:meta.symbol, color:meta.color};
    }

    function faceMarkup(card){
      const tone = card.color === 'red' ? 'red' : 'black';
      return '<div class="card-corner top-left '+tone+'"><span class="rank '+tone+'">'+card.rank+'</span><span class="suit '+tone+'">'+card.suit+'</span></div>'
        + '<div class="center '+tone+'">'+card.suit+'</div>'
        + '<div class="card-corner bottom-right '+tone+'"><span class="rank '+tone+'">'+card.rank+'</span><span class="suit '+tone+'">'+card.suit+'</span></div>';
    }

    function setBack(slot){
      if(!slot) return;
      slot.classList.remove('front');
      slot.classList.add('back');
      slot.innerHTML = '';
      slot.style.removeProperty('z-index');
    }

    function renderSlot(slot, token, index){
      const parsed = parseWinnerCard(token);
      if(!slot || !parsed){
        setBack(slot);
        return;
      }
      slot.classList.remove('back');
      slot.classList.add('front');
      slot.innerHTML = faceMarkup(parsed);
      slot.style.zIndex = String(10 + index);
    }

    window.clearTeenPattiWinnerPopupCards = function(){
      if(preview) preview.hidden = true;
      slots.forEach(setBack);
      if(boardNode) boardNode.textContent = 'Winner';
      if(labelNode) labelNode.textContent = 'Winning cards';
    };

    window.renderTeenPattiWinnerPopupCards = function(boardKey, hand){
      const cards = Array.isArray(hand && hand.cards) ? hand.cards : (Array.isArray(hand) ? hand : []);
      if(!preview || !cards.length){
        window.clearTeenPattiWinnerPopupCards();
        return false;
      }
      const key = String(boardKey || '').toUpperCase();
      if(boardNode) boardNode.textContent = key ? `Winner ${key}` : 'Winner';
      if(labelNode) labelNode.textContent = String((hand && hand.label) || 'Winning cards');
      slots.forEach(function(slot, index){ renderSlot(slot, cards[index], index); });
      preview.hidden = false;
      preview.classList.remove('winner-hand-pop');
      void preview.offsetWidth;
      preview.classList.add('winner-hand-pop');
      return true;
    };
    document.documentElement.dataset.teenWinnerPopupCards = 'ready';
  })();
  </script>
  <div class="modal loser-pop" id="modalLoss">
    <div class="modal-card">
      <div class="popup-kicker">Round Result</div>
      <div class="popup-accent"></div>
      <div class="popup-icon"><i class="fas fa-heart-crack"></i></div>
      <h2>YOU LOSE</h2>
      <p>Try again</p>
      <div class="popup-note">Next round can turn the table</div>
      <div class="popup-powered">Powerd by JAMBOai</div>
    </div>
  </div>
  <div class="modal nobid-pop" id="modalNoBid">
    <div class="modal-card">
      <div class="popup-kicker">No Action</div>
      <div class="popup-accent"></div>
      <div class="popup-icon"><i class="fas fa-coins"></i></div>
      <h2>NO BET</h2>
      <p>Place a bet</p>
      <div class="popup-note">Select a chip and tap a board</div>
      <div class="popup-powered">Powerd by JAMBOai</div>
    </div>
  </div>
  <div class="modal go-pop" id="modalGo" style="display:none!important;">
    <div class="modal-card">
      <div class="popup-kicker">Next Round</div>
      <div class="popup-accent"></div>
      <div class="popup-icon"><i class="fas fa-bolt"></i></div>
      <h2>GO!</h2>
      <p>Fresh round is charging now</p>
      <div class="popup-note">Get ready for the next move</div>
      <div class="popup-powered">Powerd by JAMBOai</div>
    </div>
  </div>
  
  <div class="modal utility-modal" id="modalUsers">
    <div class="modal-card">
      <h3>Users</h3>
      <div class="utility-list" id="modalUsersList">
        <div class="teen-active-user-grid">
          <div class="teen-active-user-card">
            <div class="teen-active-user-avatar">{{ strtoupper(substr($displayUserName ?? 'Player', 0, 1)) ?: 'P' }}</div>
            <strong>{{ $displayUserName ?? 'Player' }}</strong>
            <span>YOU</span>
          </div>
        </div>
      </div>
      <button class="close-modal-btn">Close</button>
      <div class="popup-powered">Powerd by JAMBOai</div>
    </div>
  </div>
  <div class="modal utility-modal" id="modalHistory">
    <div class="modal-card">
      <h3>My History</h3>
      <div class="utility-list" id="modalHistoryList">
        <div class="history-table-empty">Loading your last 15 bets...</div>
      </div>
      <button class="close-modal-btn">Close</button>
      <div class="popup-powered">Powerd by JAMBOai</div>
    </div>
  </div>
  <div class="modal utility-modal" id="modalRecent">
    <div class="modal-card">
      <h3>Trend</h3>
      <div class="utility-list" id="modalRecentList">
        <div class="history-table-empty">Syncing winning boards...</div>
      </div>
      <button class="close-modal-btn">Close</button>
      <div class="popup-powered">Powerd by JAMBOai</div>
    </div>
  </div>
  
  <div class="message-banner" id="messageBanner"></div>
<style id="teen-patti-utility-popup-stability">
  .utility-modal{
    z-index:320 !important;
    padding:clamp(10px,3vw,18px) !important;
    align-items:center !important;
    justify-content:center !important;
    background:rgba(5,9,20,.72) !important;
    backdrop-filter:blur(8px) saturate(120%) !important;
    -webkit-backdrop-filter:blur(8px) saturate(120%) !important;
  }
  .utility-modal.show{
    opacity:1 !important;
    visibility:visible !important;
    pointer-events:auto !important;
  }
  .utility-modal .modal-card{
    width:min(94vw,420px) !important;
    max-width:420px !important;
    max-height:min(84dvh,720px) !important;
    padding:18px 16px 16px !important;
    border-radius:24px !important;
    display:flex !important;
    flex-direction:column !important;
    gap:12px !important;
    overflow:hidden !important;
  }
  .utility-modal .modal-card h3{
    margin:0 !important;
    font-size:14px !important;
    letter-spacing:.14em !important;
    text-transform:uppercase !important;
    color:#fff2bd !important;
  }
  .utility-modal .utility-list{
    flex:1 1 auto !important;
    min-height:0 !important;
    max-height:none !important;
    overflow-x:hidden !important;
    overflow-y:auto !important;
    margin:0 !important;
    padding-right:4px !important;
  }
  .utility-modal .utility-item{
    display:grid !important;
    grid-template-columns:minmax(0,1fr) auto !important;
    gap:8px !important;
    align-items:center !important;
    border-radius:18px !important;
    padding:10px 12px !important;
  }
  .utility-modal .teen-active-user-grid{
    grid-template-columns:repeat(6,minmax(0,1fr)) !important;
    gap:6px !important;
  }
  .utility-modal .teen-active-user-card{
    display:grid !important;
    grid-template-columns:1fr !important;
    margin:0 !important;
    border-radius:12px !important;
    padding:8px 4px !important;
  }
  .utility-modal .history-table-wrap{
    border-radius:18px !important;
    overflow-x:hidden !important;
    overflow-y:auto !important;
  }
  .utility-modal .history-table{
    min-width:100% !important;
    width:100% !important;
    max-width:100% !important;
    table-layout:fixed !important;
    font-size:12px !important;
  }
  .utility-modal .history-table th,
  .utility-modal .history-table td{
    padding:9px 8px !important;
    white-space:normal !important;
    overflow-wrap:anywhere !important;
    word-break:break-word !important;
  }
  .utility-modal .history-table-empty{
    border-radius:18px !important;
  }
  .utility-modal .teen-trend-roadmap{
    position:relative !important;
    width:100% !important;
    min-width:0 !important;
    aspect-ratio:auto !important;
    min-height:250px !important;
    max-height:288px !important;
    display:grid !important;
    grid-template-columns:minmax(0,1fr) !important;
    grid-template-rows:22px minmax(0,1fr) !important;
    border-radius:10px !important;
    overflow:hidden !important;
    background:
      linear-gradient(180deg, rgba(255,235,142,.15) 1px, transparent 1px),
      radial-gradient(circle at 52% 38%, rgba(255,215,110,.13), transparent 30%),
      linear-gradient(145deg, #0e6a43 0%, #095233 48%, #07391f 100%) !important;
    background-size:100% 10%, auto, auto !important;
    border:2px solid rgba(255,212,79,.7) !important;
    box-shadow:inset 0 0 0 1px rgba(255,255,255,.08), inset 0 0 28px rgba(0,0,0,.34), 0 12px 24px rgba(0,0,0,.28) !important;
  }
  .utility-modal .teen-trend-roadmap::before{
    content:"" !important;
    position:absolute !important;
    inset:28px 6px 6px 6px !important;
    border-radius:7px !important;
    border:1px solid rgba(255,255,255,.08) !important;
    box-shadow:inset 0 0 24px rgba(255,255,255,.04) !important;
    pointer-events:none !important;
  }
  .utility-modal .teen-trend-grid{
    position:relative !important;
    display:grid !important;
    grid-template-columns:repeat(3,minmax(0,1fr)) !important;
    grid-template-rows:18px repeat(10,minmax(0,1fr)) !important;
    min-width:0 !important;
    padding:4px 7px 7px !important;
    overflow:hidden !important;
  }
  .utility-modal .teen-trend-board-label{
    position:relative !important;
    z-index:1 !important;
    display:flex !important;
    align-items:center !important;
    justify-content:center !important;
    min-width:0 !important;
    padding:0 4px !important;
    color:#ffe884 !important;
    font-size:8px !important;
    font-weight:1000 !important;
    line-height:1 !important;
    text-transform:uppercase !important;
    white-space:nowrap !important;
    overflow:hidden !important;
    text-overflow:ellipsis !important;
    text-shadow:0 1px 2px rgba(0,0,0,.55) !important;
    border-bottom:1px solid rgba(255,221,101,.38) !important;
    background:linear-gradient(180deg, rgba(255,215,110,.12), rgba(0,0,0,0)) !important;
  }
  .utility-modal .teen-trend-board-label:not(:last-child){
    border-right:1px solid rgba(255,221,101,.24) !important;
  }
  .utility-modal .teen-trend-cell{
    position:relative !important;
    min-width:0 !important;
    display:flex !important;
    align-items:center !important;
    justify-content:center !important;
    overflow:visible !important;
    border-bottom:1px solid rgba(255,221,101,.18) !important;
    border-right:1px solid rgba(255,221,101,.18) !important;
  }
  .utility-modal .teen-trend-cell:nth-child(3n){
    border-right:0 !important;
  }
  .utility-modal .teen-trend-cell::after{
    content:none !important;
  }
  .utility-modal .teen-trend-token{
    position:relative !important;
    width:24px !important;
    height:24px !important;
    display:grid !important;
    place-items:center !important;
    border-radius:9px !important;
    background:transparent !important;
    border:0 !important;
    color:#ffe76a !important;
    font-size:10px !important;
    line-height:1 !important;
    box-shadow:none !important;
    transform:translateY(0) !important;
    overflow:visible !important;
  }
  .utility-modal .teen-trend-token::before{
    content:"" !important;
    position:absolute !important;
    left:50% !important;
    bottom:-1px !important;
    width:20px !important;
    height:6px !important;
    border-radius:50% !important;
    background:radial-gradient(ellipse at center, rgba(0,0,0,.42), rgba(0,0,0,0) 70%) !important;
    box-shadow:none !important;
    transform:translateX(-50%) !important;
  }
  .utility-modal .teen-trend-token.is-latest{
    width:25px !important;
    height:25px !important;
    background:transparent !important;
    box-shadow:none !important;
    transform:translateY(-1px) scale(1.06) !important;
  }
  .utility-modal .teen-trend-token img{
    position:absolute !important;
    z-index:1 !important;
    left:50% !important;
    bottom:1px !important;
    width:24px !important;
    height:24px !important;
    object-fit:contain !important;
    transform:translateX(-50%) !important;
    filter:drop-shadow(0 4px 5px rgba(0,0,0,.54)) !important;
    pointer-events:none !important;
  }
  .utility-modal .teen-trend-token.is-latest img{
    filter:drop-shadow(0 0 7px rgba(255,225,78,.86)) drop-shadow(0 4px 6px rgba(0,0,0,.58)) !important;
  }
  .utility-modal .teen-trend-token span{
    position:absolute !important;
    z-index:2 !important;
    right:-8px !important;
    bottom:0 !important;
    min-width:12px !important;
    height:12px !important;
    display:grid !important;
    place-items:center !important;
    border-radius:999px !important;
    background:linear-gradient(180deg, rgba(255,226,94,.98), rgba(174,94,12,.98)) !important;
    border:1px solid rgba(255,249,203,.65) !important;
    font-weight:1000 !important;
    font-size:7px !important;
    color:#241000 !important;
    text-shadow:none !important;
    box-shadow:0 2px 4px rgba(0,0,0,.4) !important;
  }
  .utility-modal .teen-trend-cell.board-b .teen-trend-token span{
    background:linear-gradient(180deg, #e7f6ff, #2d89d7) !important;
    color:#061f39 !important;
  }
  .utility-modal .teen-trend-cell.board-c .teen-trend-token span{
    background:linear-gradient(180deg, #dcfff0, #17ad63) !important;
    color:#052a17 !important;
  }
  .utility-modal .teen-trend-side{
    display:flex !important;
    flex-direction:row !important;
    align-items:center !important;
    justify-content:space-between !important;
    gap:8px !important;
    min-width:0 !important;
    padding:3px 8px !important;
    border-bottom:1px solid rgba(255,221,101,.48) !important;
    background:linear-gradient(90deg, rgba(10,79,45,.84), rgba(5,44,25,.92)) !important;
    color:#ffe884 !important;
    font-weight:1000 !important;
    letter-spacing:.12em !important;
    writing-mode:horizontal-tb !important;
    text-orientation:mixed !important;
    font-size:10px !important;
    text-shadow:0 1px 2px rgba(0,0,0,.55) !important;
  }
  .utility-modal .teen-trend-side small{
    font-size:8px !important;
    letter-spacing:.08em !important;
    color:rgba(255,248,189,.82) !important;
    white-space:nowrap !important;
    overflow:hidden !important;
    text-overflow:ellipsis !important;
  }
  .utility-modal .teen-trend-legend{
    display:grid !important;
    grid-template-columns:repeat(3,minmax(0,1fr)) !important;
    gap:6px !important;
    margin-top:8px !important;
  }
  .utility-modal .teen-trend-legend span{
    min-width:0 !important;
    border-radius:999px !important;
    padding:4px 6px !important;
    background:rgba(255,255,255,.07) !important;
    border:1px solid rgba(255,215,110,.16) !important;
    color:rgba(255,245,204,.86) !important;
    font-size:9px !important;
    font-weight:900 !important;
    text-align:center !important;
    white-space:nowrap !important;
    overflow:hidden !important;
    text-overflow:ellipsis !important;
  }
  body.teen-patti-premium-popup #modalRecent.utility-modal .modal-card{
    width:min(94vw,360px) !important;
    max-width:360px !important;
    min-height:0 !important;
    max-height:min(86dvh,340px) !important;
    padding:16px 12px 14px !important;
    gap:8px !important;
    overflow:hidden !important;
    background-color:transparent !important;
    background-image:linear-gradient(145deg, rgba(14,86,53,.96), rgba(6,38,25,.98)) !important;
    border:1px solid rgba(255,215,110,.42) !important;
    box-shadow:0 20px 44px rgba(0,0,0,.54), inset 0 1px 0 rgba(255,255,255,.1) !important;
  }
  body.teen-patti-premium-popup #modalRecent.utility-modal.show{
    opacity:1 !important;
    visibility:visible !important;
    pointer-events:auto !important;
  }
  body.teen-patti-premium-popup #modalRecent.utility-modal .modal-card h3{
    font-size:13px !important;
    letter-spacing:.08em !important;
  }
  body.teen-patti-premium-popup #modalRecent.utility-modal .utility-list{
    flex:0 0 auto !important;
    max-height:none !important;
    overflow:hidden !important;
    padding-right:0 !important;
  }
  body.teen-patti-premium-popup #modalRecent.utility-modal .teen-trend-roadmap{
    min-height:250px !important;
    max-height:288px !important;
  }
  body.teen-patti-premium-popup #modalRecent.utility-modal .teen-trend-legend{
    display:none !important;
  }
  body.teen-patti-premium-popup #modalRecent.utility-modal .popup-powered{
    margin-top:0 !important;
    padding-top:0 !important;
    font-size:7px !important;
    opacity:.05 !important;
  }
  .utility-modal .close-modal-btn{
    margin-top:0 !important;
    flex:0 0 auto !important;
  }
  .game-container .top-bar{
    z-index:240 !important;
  }
  @media (max-width: 430px){
    .utility-modal{
      padding:10px !important;
    }
    .utility-modal .modal-card{
      width:min(96vw,380px) !important;
      padding:16px 14px 14px !important;
      border-radius:20px !important;
    }
    .utility-modal .history-table th,
    .utility-modal .history-table td{
      padding:8px 7px !important;
      font-size:11px !important;
    }
    .utility-modal .teen-trend-roadmap{
      min-height:236px !important;
      grid-template-columns:minmax(0,1fr) !important;
      grid-template-rows:20px minmax(0,1fr) !important;
    }
    .utility-modal .teen-trend-grid{
      grid-template-rows:17px repeat(10,minmax(0,1fr)) !important;
      padding:3px 6px 6px !important;
    }
    .utility-modal .teen-trend-board-label{
      font-size:7px !important;
      padding:0 3px !important;
    }
    .utility-modal .teen-trend-token{
      width:22px !important;
      height:22px !important;
      font-size:9px !important;
    }
    .utility-modal .teen-trend-token.is-latest{
      width:23px !important;
      height:23px !important;
    }
    .utility-modal .teen-trend-token img{
      width:22px !important;
      height:22px !important;
    }
    .utility-modal .teen-trend-side{
      font-size:9px !important;
      padding:3px 7px !important;
    }
    body.teen-patti-premium-popup #modalRecent.utility-modal .modal-card{
      width:min(94vw,340px) !important;
      max-height:min(92dvh,414px) !important;
      padding:14px 10px 12px !important;
      gap:6px !important;
    }
    body.teen-patti-premium-popup #modalRecent.utility-modal .modal-card h3{
      font-size:12px !important;
    }
    body.teen-patti-premium-popup #modalRecent.utility-modal .teen-trend-roadmap{
      min-height:236px !important;
      max-height:266px !important;
    }
    body.teen-patti-premium-popup #modalRecent.utility-modal .teen-trend-legend{
      display:none !important;
    }
    body.teen-patti-premium-popup #modalRecent.utility-modal .teen-trend-legend span{
      padding:3px 4px !important;
      font-size:8px !important;
    }
  }
  @media (max-height: 700px){
    .utility-modal .modal-card{
      max-height:88dvh !important;
    }
  }
  .game-container{
    --teen-live-bottom-gap:92px;
  }
  .game-content{
    padding-top:calc(var(--top-bar-h) + 8px) !important;
    padding-bottom:calc(var(--chips-bar-h) + env(safe-area-inset-bottom) + 10px) !important;
  }
  .shell{
    padding:0 !important;
    gap:0 !important;
  }
  .top-stack{
    top:calc(var(--top-bar-h) + 4px) !important;
    gap:4px !important;
    padding-top:0 !important;
  }
  .bottom-stack{
    bottom:calc(var(--chips-bar-h) + env(safe-area-inset-bottom) + var(--teen-live-bottom-gap)) !important;
    gap:6px !important;
    padding-left:10px !important;
    padding-right:10px !important;
  }
  .timer-orb,
  .gf-premium-clock{
    width:96px !important;
    height:96px !important;
    min-width:96px !important;
    min-height:96px !important;
  }
  .timer-value{
    font-size:2.36rem !important;
  }
  .pots{
    gap:6px !important;
  }
  .pot{
    min-height:136px !important;
    padding-top:0 !important;
  }
  .chair{
    width:62px !important;
    margin-bottom:-12px !important;
  }
  .cards{
    height:82px !important;
  }
  .boards.sticky-boards{
    gap:6px !important;
    padding-left:2px !important;
    padding-right:2px !important;
  }
  .board{
    min-height:84px !important;
  }
  .chips-bar{
    padding-top:6px !important;
  }
  @media (min-height: 700px){
    .bottom-stack{
      bottom:calc(var(--chips-bar-h) + env(safe-area-inset-bottom) + 92px) !important;
    }
  }
  @media (max-width: 430px){
    .game-container{
      --teen-live-bottom-gap:78px;
    }
    .top-stack{
      top:calc(var(--top-bar-h) + 2px) !important;
      gap:3px !important;
    }
    .timer-orb,
    .gf-premium-clock{
      width:88px !important;
      height:88px !important;
      min-width:88px !important;
      min-height:88px !important;
    }
    .timer-value{
      font-size:2.08rem !important;
    }
    .pot{
      min-height:126px !important;
    }
    .chair{
      width:56px !important;
      margin-bottom:-10px !important;
    }
    .cards{
      height:76px !important;
    }
    .board{
      min-height:78px !important;
    }
  }
  @media (max-height: 760px){
    .game-container{
      --teen-live-bottom-gap:56px;
    }
  }
  @media (max-height: 640px){
    .game-container{
      --teen-live-bottom-gap:30px;
    }
  }
</style>
  <div class="floating-banner" id="floatingBanner">SELECT CHIP</div>
  <div class="phase-banner" id="phaseBanner"></div>
  <div class="toast-notification" id="toastNotification"></div>
  <div class="mega-celebration" id="megaCelebration"><div class="mega-core"><h3>MEGA WIN</h3><p id="megaText">Magical victory burst</p></div></div>
  <div class="sr-only" aria-live="polite" id="liveRegion"></div>
</div>

<script>
(()=>{
  const currentGameCode=@json($currentGameCode);
  const teenPattiFx=@json($variantFx);
  const teenPattiChipTheme=@json($teenPattiVariant['chip_theme']);
  const boardDisplayNames=@json($seatTitles);
  const boardPayoutMultipliers=@json($boardPayoutMultipliers);
  const teenTrendChairAssets=@json($seatChairAssetUrls);
  const currentPrefsStorageKey=currentGameCode==='teen_patti' ? 'tp_prefs' : `tp_prefs_${currentGameCode}`;
  const hasLiveSession=@json((bool) ($sessionToken ?? null));
  const allowStandalonePreview=false;
  const useStandalonePreview=false;
  const REQUIRED_CHIPS=[1000,5000,10000,50000,100000];
  const DEFAULT_CHIP=1000;
  function chipFallbackLabel(value){
    return value>=100000?'100K':value>=50000?'50K':value>=10000?'10K':value>=5000?'5K':value>=1000?'1K':String(value);
  }
  function normalizeTeenPattiChipBar(){
    const chipsBar=document.getElementById('chipsBar');
    if(!chipsBar)return;
    const anchor=chipsBar.querySelector('#btnRecent')||null;
    chipsBar.querySelectorAll('.chip').forEach(node=>node.remove());
    REQUIRED_CHIPS.forEach(value=>{
      const chipBtn=document.createElement('button');
      chipBtn.type='button';
      chipBtn.className=value===DEFAULT_CHIP?'chip selected':'chip';
      chipBtn.dataset.value=String(value);
      chipBtn.setAttribute('aria-label',`${value} chip`);
      chipBtn.setAttribute('aria-pressed',value===DEFAULT_CHIP?'true':'false');
      chipBtn.innerHTML=`<span class="chip-label">${chipFallbackLabel(value)}</span>`;
      if(anchor)chipsBar.insertBefore(chipBtn,anchor);
      else chipsBar.appendChild(chipBtn);
    });
  }
  function normalizeTeenPattiBoardPlus(){
    ['A','B','C'].forEach(board=>{
      const plus=document.getElementById(`plus${board}`);
      if(plus)plus.textContent=`+${DEFAULT_CHIP}`;
    });
  }
  normalizeTeenPattiChipBar();
  normalizeTeenPattiBoardPlus();
  const PREVIEW_CONFIG={manualWinner:null,cards:{A:[],B:[],C:[]},labels:{}};
  const state={phase:'boot',timeLeft:30,displayTime:30,selectedChip:DEFAULT_CHIP,balance:useStandalonePreview?1500000:0,totals:{A:0,B:0,C:0},myBets:{A:0,B:0,C:0},winner:null,timers:new Set(),interval:null,audioUnlocked:false,prefs:{music:true,sound:true,voice:true},musicEngine:null,tickTimer:null,busyNoBid:false,popupQueue:Promise.resolve(),isGameActive:true,bettingEnabled:false,lastChipValue:DEFAULT_CHIP,splashDone:false,round:useStandalonePreview?1:0,networkMs:0,networkQuality:'warn',fastBidMode:false,lastBoardTapAt:0,lastBetBoard:null,networkProbeBusy:false,noticeBusy:false,entryHandled:false,offline:false,roundToken:0,phaseLock:false,modalShowing:false};
  const trackedTeenRoomMedia = new Set();
  const trackedTeenRoomAudioContexts = new Set();
  let teenAudioTrackingInstalled = false;
  const teenAudioPatterns=Object.freeze({
    teen_patti:{name:'Classic table',wave:'triangle',gain:.018,stepMs:360,notes:[261.63,329.63,392,329.63,293.66,349.23,440,349.23],bass:[130.81,146.83,164.81,146.83],accent:1046.5},
    teen_patti_king:{name:'Royal table',wave:'triangle',gain:.017,stepMs:390,notes:[293.66,369.99,440,554.37,493.88,440,369.99,329.63],bass:[146.83,185,220,196],accent:987.77},
    teen_patti_sultan:{name:'Desert table',wave:'sine',gain:.018,stepMs:410,notes:[246.94,311.13,369.99,415.3,369.99,311.13,277.18,246.94],bass:[123.47,155.56,184.99,155.56],accent:932.33},
    teen_patti_warfront:{name:'Warfront table',wave:'sawtooth',gain:.013,stepMs:320,notes:[196,246.94,293.66,392,349.23,293.66,246.94,220],bass:[98,123.47,146.83,110],accent:783.99},
    teen_patti_neon:{name:'Neon table',wave:'square',gain:.012,stepMs:300,notes:[329.63,493.88,659.25,739.99,659.25,554.37,493.88,415.3],bass:[164.81,246.94,207.65,246.94],accent:1318.51},
    teen_patti_shogun:{name:'Shogun table',wave:'triangle',gain:.016,stepMs:430,notes:[220,261.63,329.63,392,329.63,261.63,246.94,220],bass:[110,130.81,164.81,130.81],accent:880},
    teen_patti_glacier:{name:'Glacier table',wave:'sine',gain:.015,stepMs:440,notes:[392,523.25,659.25,783.99,698.46,659.25,523.25,440],bass:[196,261.63,220,261.63],accent:1567.98}
  });
  const teenAudioPattern=teenAudioPatterns[currentGameCode]||teenAudioPatterns.teen_patti;
  window.TEEN_PATTI_TREND_CHAIRS=teenTrendChairAssets;
  document.documentElement.dataset.teenAudioPattern=currentGameCode;
  document.documentElement.dataset.teenAudioPatternName=teenAudioPattern.name;
  document.documentElement.dataset.teenAudioHooks='ready';
  document.documentElement.dataset.teenTrendChairs='ready';
  const els={loadingSkeleton:document.getElementById('loadingSkeleton'),topStack:document.getElementById('topStack'),bottomStack:document.getElementById('bottomStack'),roundCount:document.getElementById('roundCount'),netStat:document.getElementById('netStat'),netPill:document.getElementById('netPill'),netIcon:document.getElementById('netIcon'),splashProgressBar:document.getElementById('splashProgressBar'),splashPercent:document.getElementById('splashPercent'),splashLog:document.getElementById('splashLog'),game:document.getElementById('gameContainer'),balanceText:document.getElementById('balanceText'),timerWrap:document.getElementById('timerWrap'),balanceSection:document.getElementById('balanceSection'),balanceImpact:document.getElementById('balanceImpact'),balanceDroplet:document.getElementById('balanceDroplet'),username:document.getElementById('username'),timerOrb:document.getElementById('timerOrb'),timerValue:document.getElementById('timerValue'),timerSub:document.getElementById('timerSub'),stacks:{A:document.getElementById('stackA'),B:document.getElementById('stackB'),C:document.getElementById('stackC')},labels:{A:document.getElementById('labelA'),B:document.getElementById('labelB'),C:document.getElementById('labelC')},potWrappers:{A:document.querySelector('.pot[data-board="A"]'),B:document.querySelector('.pot[data-board="B"]'),C:document.querySelector('.pot[data-board="C"]')},boards:{A:document.getElementById('boardA'),B:document.getElementById('boardB'),C:document.getElementById('boardC')},total:{A:document.getElementById('totalA'),B:document.getElementById('totalB'),C:document.getElementById('totalC')},won:{A:document.getElementById('wonA'),B:document.getElementById('wonB'),C:document.getElementById('wonC')},fly:{A:document.getElementById('flyA'),B:document.getElementById('flyB'),C:document.getElementById('flyC')},plus:{A:document.getElementById('plusA'),B:document.getElementById('plusB'),C:document.getElementById('plusC')},chips:Array.from(document.querySelectorAll('.chip')),chipsBar:document.getElementById('chipsBar'),chipSelectHud:document.getElementById('chipSelectHud'),chipSelectMini:document.getElementById('chipSelectMini'),chipSelectValue:document.getElementById('chipSelectValue'),btnSettings:document.getElementById('btnSettings'),btnUsers:document.getElementById('btnUsers'),btnHistory:document.getElementById('btnHistory'),btnRecent:document.getElementById('btnRecent'),modals:{start:document.getElementById('modalStart'),stop:document.getElementById('modalStop'),win:document.getElementById('modalWin'),loss:document.getElementById('modalLoss'),nobid:document.getElementById('modalNoBid'),go:document.getElementById('modalGo'),users:document.getElementById('modalUsers'),history:document.getElementById('modalHistory'),recent:document.getElementById('modalRecent')},messageBanner:document.getElementById('messageBanner'),floatingBanner:document.getElementById('floatingBanner'),phaseBanner:document.getElementById('phaseBanner'),toast:document.getElementById('toastNotification'),winText:document.getElementById('winText'),megaCelebration:document.getElementById('megaCelebration'),megaText:document.getElementById('megaText'),fx:document.getElementById('fx'),liveRegion:document.getElementById('liveRegion'),audioPopup:document.getElementById('audioPopup'),audioPopupOverlay:document.getElementById('audioPopupOverlay'),audioToggles:Array.from(document.querySelectorAll('#audioPopup .toggle'))};
  const identityFrames=[@json($displayUserName ?? 'Player'), @json(isset($displayUserId) && $displayUserId ? ('ID ' . $displayUserId) : null)].filter(Boolean);
  let identityIndex=0;
  let identityTimer=null;
  function setIdentityFrame(nextIndex, immediate=false){
    if(!els.username || !identityFrames.length) return;
    const normalizedIndex=nextIndex % identityFrames.length;
    const nextValue=identityFrames[normalizedIndex];
    if(immediate || identityFrames.length===1){
      els.username.textContent=nextValue;
      identityIndex=normalizedIndex;
      return;
    }
    els.username.classList.remove('flip-in');
    els.username.classList.add('flip-out');
    setTimeout(()=>{
      els.username.textContent=nextValue;
      els.username.classList.remove('flip-out');
      els.username.classList.add('flip-in');
      setTimeout(()=>els.username && els.username.classList.remove('flip-in'),340);
    },160);
    identityIndex=normalizedIndex;
  }
  function startIdentityFlip(){
    if(identityTimer) clearInterval(identityTimer);
    setIdentityFrame(0,true);
    if(identityFrames.length<2) return;
    identityTimer=setInterval(()=>setIdentityFrame(identityIndex+1,false),2400);
  }
  if(!document.getElementById('noticeBlocker')){ const nb=document.createElement('div'); nb.id='noticeBlocker'; nb.className='notice-blocker'; document.body.appendChild(nb); }
  els.noticeBlocker=document.getElementById('noticeBlocker');
  const ctx2d=els.fx?.getContext('2d');const particles=[];let particleRafId=null;let prefersReducedMotion=window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const LOCAL_TEEN_BET_SECONDS = @json((int) config('bd_game_final.games.' . $currentGameCode . '.bet_duration_sec', 20));
  const LOCAL_TEEN_BET_MS = LOCAL_TEEN_BET_SECONDS * 1000;
  startIdentityFlip();

  function isSuppressedTeenNetworkNotice(message){
    const normalized = String(message || '').trim().toUpperCase();
    return normalized === 'NETWORK CONNECTION LOST'
      || normalized === 'NETWORK RECONNECTED'
      || normalized === 'NETWORK RECONNECTING...'
      || normalized === 'RECONNECTED. ROUND SYNCED.';
  }
  
  
// Notice System (replaces toast)
function showNotice(msg,type='warn',ms=3000){
  if(isSuppressedTeenNetworkNotice(msg)){
    hideNotice();
    return Promise.resolve();
  }
  if(!els.messageBanner)return Promise.resolve();
  const now=Date.now();
  if(showNotice._activeMsg===msg && now < (showNotice._cooldownUntil||0)) return showNotice._queue || Promise.resolve();
  showNotice._activeMsg = msg;
  const typeMap={good:'good',win:'good',bet:'good',info:'warn',warn:'warn',error:'error'};
  const kind=typeMap[type]||'warn';
  const meta={good:{icon:'✓',title:'NOTICE'},warn:{icon:'⚠',title:'NOTICE'},error:{icon:'⛔',title:'ALERT'}}[kind];
  const run=()=>new Promise(resolve=>{
    clearTimeout(showNotice._t);
    els.messageBanner.innerHTML=`<div class="message-banner-icon" aria-hidden="true">${meta.icon}</div><div class="message-banner-copy"><div class="message-banner-title">${meta.title}</div><div class="message-banner-text">${msg}</div></div>`;
    els.messageBanner.classList.remove('good','warn','error','show');
    els.messageBanner.classList.add(kind);
    if(els.noticeBlocker) els.noticeBlocker.classList.add('show');
    positionFloatingUI();
    requestAnimationFrame(()=>els.messageBanner.classList.add('show'));
    showNotice._t=setTimeout(()=>{
      els.messageBanner.classList.remove('show');
      if(els.noticeBlocker) els.noticeBlocker.classList.remove('show');
      showNotice._cooldownUntil=Date.now()+500;
      setTimeout(resolve,500);
    },ms);
  });
  showNotice._queue=(showNotice._queue||Promise.resolve()).then(run);
  return showNotice._queue;
}
function showToast(msg,type='info',ms=2400){ return showNotice(msg,type,ms); }
function hideNotice(){ if(!els.messageBanner) return; clearTimeout(showNotice._t); els.messageBanner.classList.remove('show','notice-error','notice-warn','notice-info','notice-win','good','warn','error'); if(els.noticeBlocker) els.noticeBlocker.classList.remove('show'); }

  
  // Number Roll Animation
  async function animateNumber(element, start, end, duration=800){
    if(!element)return;
    let startNum=start,endNum=end;
    let range=endNum-startNum;
    let startTime=null;
    return new Promise(resolve=>{
      function step(timestamp){
        if(!startTime)startTime=timestamp;
        let progress=Math.min(1,(timestamp-startTime)/duration);
        let current=Math.floor(startNum+range*progress);
        element.textContent=formatIndianNumber(current);
        if(progress<1)requestAnimationFrame(step);
        else{element.textContent=formatIndianNumber(endNum);resolve();}
      }
      requestAnimationFrame(step);
    });
  }
  
  // Haptic Feedback
  function haptic(){
    if('vibrate' in navigator && !prefersReducedMotion){
      navigator.vibrate(20);
    }
  }
  
  // Confetti Effect
  function confettiEffect(){
    for(let i=0;i<80;i++){
      let x=innerWidth/2+ (Math.random()-0.5)*200;
      let y=innerHeight/2-100;
      let vx=(Math.random()-0.5)*3;
      let vy=Math.random()*5+2;
      particles.push({x,y,vx,vy,life:60,max:60,color:`hsl(${Math.random()*60+30},100%,60%)`,size:4+Math.random()*6,type:'confetti'});
    }
  }
  
  // Crown Effect
  function addCrown(winner){
    let pot=els.potWrappers[winner];
    if(!pot)return;
    let crown=document.createElement('div');
    crown.className='crown-effect';
    crown.innerHTML='👑';
    crown.style.position='absolute';
    crown.style.top='-30px';
    crown.style.left='50%';
    crown.style.transform='translateX(-50%) scale(0)';
    crown.style.fontSize='2.5rem';
    crown.style.zIndex='50';
    crown.style.filter='drop-shadow(0 0 15px gold)';
    pot.style.position='relative';
    pot.appendChild(crown);
    gsap.to(crown,{scale:1.2,duration:.3,onComplete:()=>gsap.to(crown,{scale:1,duration:.2})});
    setTimeout(()=>crown.remove(),2500);
  }
  function bridgeFxBudget(key,fallback){const api=window.BDGameFinal;const budget=api&&typeof api.fxBudget==='function'?api.fxBudget():null;if(budget&&Number(budget[key])>0)return Number(budget[key]);const compact=document.body.classList.contains('low-end-mode')||window.innerHeight<=520||window.innerWidth<=430||(window.matchMedia&&window.matchMedia('(prefers-reduced-motion: reduce)').matches);if(!compact)return fallback;const localBudget={betCoins:2,betSparks:2,winCoins:4,winParticles:6};return localBudget[key]||Math.min(fallback,6);}
  function bridgeFxAllowed(cost){const api=window.BDGameFinal;if(document.hidden)return false;return !api||typeof api.canPlayFx!=='function'||api.canPlayFx(cost);}
  function bridgeFxNode(node,ttl){const api=window.BDGameFinal;if(api&&typeof api.registerFxNode==='function')api.registerFxNode(node,ttl);return node;}
  function coinRain(count=16){
    count=Math.min(count,bridgeFxBudget('winCoins',count));
    if(!bridgeFxAllowed(count))return;
    for(let i=0;i<count;i++){
      let coin=bridgeFxNode(document.createElement('div'),2800);
      coin.className='coin-rain';
      coin.style.left=(8+Math.random()*84)+'vw';
      coin.style.opacity=String(.75+Math.random()*.25);
      document.body.appendChild(coin);
      if(shouldAnimate()){
        gsap.fromTo(coin,{y:-20, rotate:0, scale:.8+Math.random()*.4},{y:innerHeight+50, x:(Math.random()-.5)*60, rotate:360+Math.random()*540, duration:1.6+Math.random()*.9, ease:'power1.in', onComplete:()=>coin.remove()});
      }else{setTimeout(()=>coin.remove(),800);}
    }
  }
  
  function formatIndianNumber(n){try{let s=Math.floor(n).toString(),l=s.slice(-3),o=s.slice(0,-3);if(o!=='')l=','+l;return o.replace(/\B(?=(\d{2})+(?!\d))/g,",")+l;}catch(e){return n.toString();}}
  function announce(msg){if(els.liveRegion){els.liveRegion.textContent=msg;setTimeout(()=>{if(els.liveRegion)els.liveRegion.textContent='';},4000);}}
  function shouldAnimate(){return!prefersReducedMotion;}
  function boardDisplayName(boardKey){return boardDisplayNames[boardKey] || boardKey;}
  
  function updateSplash(pct,label){
    if(els.splashProgressBar)els.splashProgressBar.style.width=`${Math.max(0,Math.min(100,pct))}%`;
    if(els.splashPercent)els.splashPercent.textContent=`${Math.round(pct)}%`;
    if(label&&els.splashLog)els.splashLog.textContent=label;
  }
  async function runSplashSequence(){
    const steps=[
      [4,'Boot sequence starting...'],
      [11,'Loading card textures...'],
      [19,'Loading glossy chip set...'],
      [29,@json('Linking ' . $seatSummary . ' modules...')],
      [41,'Building board collision map...'],
      [53,'Charging magical timer core...'],
      [64,'Binding touch controls...'],
      [74,'Preparing popup engine...'],
      [84,'Syncing payout animation path...'],
      [93,'Finalizing winner celebration...'],
      [100,'Table ready · entering game']
    ];
    const totalDuration=2450;
    const perStep=Math.floor(totalDuration/steps.length);
    for(let i=0;i<steps.length;i++){
      const [pct,label]=steps[i];
      updateSplash(pct,label);
      await wait(i===steps.length-1 ? 220 : perStep);
    }
    await wait(120);
    state.splashDone=true;
    if(els.loadingSkeleton){els.loadingSkeleton.style.opacity='0';els.loadingSkeleton.style.visibility='hidden';}
    if(els.game)els.game.classList.add('loaded');
  }
  function preventSelectionBugs(){
    const stop=e=>{ const t=e.target; if(t && (t.closest('input,textarea,[contenteditable="true"]'))) return; e.preventDefault(); };
    document.addEventListener('selectstart',stop,{passive:false});
    document.addEventListener('dragstart',stop,{passive:false});
    document.addEventListener('contextmenu',e=>{const t=e.target; if(t && t.closest('input,textarea,[contenteditable="true"]')) return; e.preventDefault();},{passive:false});
    document.addEventListener('keydown',e=>{
      const key=String(e.key||'').toLowerCase();
      const blocked=(e.ctrlKey&&['u','s','p'].includes(key)) || (e.ctrlKey&&e.shiftKey&&['i','j','c'].includes(key)) || key==='f12';
      if(blocked){e.preventDefault();e.stopPropagation();}
    },{capture:true});
    document.querySelectorAll('.board,.pot,.chips-bar,.top-bar,.modal-card,.board-amount,.board-mini,.won-amount,.pot-title,.hand-label').forEach(el=>{
      el.setAttribute('unselectable','on');
      el.style.webkitUserSelect='none';
      el.style.userSelect='none';
      el.style.webkitTouchCallout='none';
    });
  }

  function schedule(fn,ms){let id=setTimeout(()=>{state.timers.delete(id);try{fn();}catch(e){console.error(e);}},ms);state.timers.add(id);return id;}
  function clearTimers(){state.timers.forEach(clearTimeout);state.timers.clear();if(state.interval){clearInterval(state.interval);state.interval=null;}if(state.tickTimer){clearInterval(state.tickTimer);state.tickTimer=null;}if(particleRafId){cancelAnimationFrame(particleRafId);particleRafId=null;}particles.length=0;}
  function number(n){return formatIndianNumber(Math.max(0,Math.floor(n)));}
  function balanceNumber(n){return String(Math.max(0,Math.floor(Number(n)||0)));}
  function chipPalette(v){
    const palettes={
      classic:{1000:['#5fa8ff','#214ed1'],5000:['#7dc6ff','#2b7fe4'],10000:['#6cffc6','#149460'],50000:['#c28cff','#6f34db'],default:['#ffe27a','#d28b12']},
      king:{1000:['#8cc6ff','#3359da'],5000:['#9bc9ff','#4a70e6'],10000:['#9effd1','#1d9a66'],50000:['#e0b2ff','#7c3ff0'],default:['#fff0a0','#d59a24']},
      sultan:{1000:['#a7efff','#2f9fbc'],5000:['#b8f4ff','#3caecb'],10000:['#baf4d7','#2e9b72'],50000:['#f0d4a2','#b87631'],default:['#fff0c2','#d9a445']},
      warfront:{1000:['#d4dee6','#6d7987'],5000:['#d7e2eb','#738293'],10000:['#dce8dd','#69786a'],50000:['#b9c6d8','#4a5567'],default:['#f2dbc0','#956844']},
      neon:{1000:['#6de8ff','#1a88ff'],5000:['#86e9ff','#2f9dff'],10000:['#76ffd7','#09c58a'],50000:['#f0a4ff','#7e3dff'],default:['#fff0ab','#f0b53c']},
      shogun:{1000:['#eadfc9','#8f7651'],5000:['#eee4cf','#9a8260'],10000:['#b7e0c3','#4a8b67'],50000:['#e9c17d','#9b5f16'],default:['#ffecb4','#c98c28']},
      glacier:{1000:['#b7dbff','#4d7fd0'],5000:['#c7e3ff','#5f91dc'],10000:['#d9fff4','#49bda5'],50000:['#eff7ff','#8ea8d2'],default:['#f3fbff','#9fc6de']}
    };
    const themePalette=palettes[teenPattiChipTheme]||palettes.classic;
    return themePalette[v]||themePalette.default;
  }
  function chipLabel(v){return v>=100000?'100K':v>=50000?'50K':v>=10000?'10K':v>=5000?'5K':v>=1000?'1K':String(v);}
  function chipSVG(v){
    let [a,b]=chipPalette(v);let label=chipLabel(v);const chipId=`tp-${teenPattiChipTheme}-${v}`;
    if(teenPattiChipTheme==='king') return `<span class="chip-face chip-face-king"><svg viewBox="0 0 100 100" aria-hidden="true"><defs><radialGradient id="g${chipId}" cx="34%" cy="24%"><stop offset="0%" stop-color="#fff8d6"/><stop offset="20%" stop-color="${a}"/><stop offset="68%" stop-color="${b}"/><stop offset="100%" stop-color="#2a0d24"/></radialGradient><linearGradient id="kg${chipId}" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#fff6be"/><stop offset="48%" stop-color="#d39222"/><stop offset="100%" stop-color="#7a3d0d"/></linearGradient></defs><circle cx="50" cy="50" r="47" fill="url(#kg${chipId})" stroke="rgba(255,244,200,.96)" stroke-width="3"/><circle cx="50" cy="50" r="40" fill="url(#g${chipId})" stroke="rgba(95,34,16,.52)" stroke-width="2"/><path d="M22 50h10M68 50h10M50 22v10M50 68v10" stroke="rgba(255,238,178,.86)" stroke-width="6" stroke-linecap="round"/><path d="M33 37 41 28 50 37 59 28 67 37 62 45H38Z" fill="rgba(255,232,140,.92)" stroke="rgba(86,35,5,.42)" stroke-width="1.5"/><circle cx="50" cy="55" r="20" fill="rgba(25,6,22,.36)" stroke="rgba(255,238,178,.45)" stroke-width="2"/><text x="50" y="62" text-anchor="middle" font-size="18" font-weight="900" fill="#fff4c8" style="letter-spacing:.4px">${label}</text><path d="M25 28c14-10 35-11 50 0" fill="none" stroke="rgba(255,255,255,.42)" stroke-width="5" stroke-linecap="round" opacity=".55"/></svg></span>`;
    if(teenPattiChipTheme==='sultan') return `<span class="chip-face"><svg viewBox="0 0 100 100" aria-hidden="true"><defs><linearGradient id="g${chipId}" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#fff7e2"/><stop offset="22%" stop-color="${a}"/><stop offset="100%" stop-color="${b}"/></linearGradient></defs><path d="M50 5 74 13 89 34 83 60 50 95 17 60 11 34 26 13Z" fill="url(#g${chipId})" stroke="rgba(255,236,191,.92)" stroke-width="3"/><path d="M50 17 66 23 76 36 71 54 50 77 29 54 24 36 34 23Z" fill="rgba(255,255,255,.12)" stroke="rgba(255,244,220,.45)" stroke-width="2"/><text x="50" y="56" text-anchor="middle" font-size="18" font-weight="900" fill="#fff7db">${label}</text></svg></span>`;
    if(teenPattiChipTheme==='warfront') return `<span class="chip-face"><svg viewBox="0 0 100 100" aria-hidden="true"><defs><linearGradient id="g${chipId}" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#f5f5f5"/><stop offset="28%" stop-color="${a}"/><stop offset="100%" stop-color="${b}"/></linearGradient></defs><path d="M25 6h50l19 19v50L75 94H25L6 75V25Z" fill="url(#g${chipId})" stroke="rgba(255,223,205,.78)" stroke-width="3"/><path d="M31 18h38l13 13v38L69 82H31L18 69V31Z" fill="rgba(255,255,255,.08)" stroke="rgba(255,255,255,.28)" stroke-width="2"/><path d="M24 50h52" stroke="rgba(255,255,255,.35)" stroke-width="3" stroke-dasharray="5 5"/><text x="50" y="57" text-anchor="middle" font-size="18" font-weight="900" fill="#fff7ef">${label}</text></svg></span>`;
    if(teenPattiChipTheme==='neon') return `<span class="chip-face"><svg viewBox="0 0 100 100" aria-hidden="true"><defs><radialGradient id="g${chipId}" cx="34%" cy="28%"><stop offset="0%" stop-color="#ffffff" stop-opacity=".96"/><stop offset="22%" stop-color="${a}"/><stop offset="100%" stop-color="${b}"/></radialGradient></defs><path d="M26 10h48l20 40-20 40H26L6 50Z" fill="url(#g${chipId})" stroke="rgba(186,244,255,.86)" stroke-width="3"/><path d="M30 22h40l12 28-12 28H30L18 50Z" fill="rgba(255,255,255,.06)" stroke="rgba(255,255,255,.36)" stroke-width="2"/><circle cx="50" cy="50" r="16" fill="rgba(5,16,48,.24)" stroke="rgba(255,255,255,.34)" stroke-width="2"/><text x="50" y="56" text-anchor="middle" font-size="18" font-weight="900" fill="#f7fcff">${label}</text></svg></span>`;
    if(teenPattiChipTheme==='shogun') return `<span class="chip-face"><svg viewBox="0 0 100 100" aria-hidden="true"><defs><radialGradient id="g${chipId}" cx="34%" cy="28%"><stop offset="0%" stop-color="#fff7e8" stop-opacity=".96"/><stop offset="22%" stop-color="${a}"/><stop offset="100%" stop-color="${b}"/></radialGradient></defs><circle cx="50" cy="50" r="45" fill="url(#g${chipId})" stroke="rgba(255,225,176,.9)" stroke-width="3"/><circle cx="50" cy="50" r="31" fill="rgba(0,0,0,.18)" stroke="rgba(255,255,255,.26)" stroke-width="2" stroke-dasharray="5 6"/><path d="M50 28 61 39 50 50 39 39Z" fill="rgba(255,255,255,.16)"/><path d="M50 50 61 61 50 72 39 61Z" fill="rgba(0,0,0,.14)"/><text x="50" y="57" text-anchor="middle" font-size="18" font-weight="900" fill="#fff6e8">${label}</text></svg></span>`;
    if(teenPattiChipTheme==='glacier') return `<span class="chip-face"><svg viewBox="0 0 100 100" aria-hidden="true"><defs><linearGradient id="g${chipId}" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#ffffff"/><stop offset="24%" stop-color="${a}"/><stop offset="100%" stop-color="${b}"/></linearGradient></defs><path d="M50 7 77 18 92 50 77 82 50 93 23 82 8 50 23 18Z" fill="url(#g${chipId})" stroke="rgba(233,248,255,.9)" stroke-width="3"/><path d="M50 21 66 27 79 50 66 73 50 79 34 73 21 50 34 27Z" fill="rgba(255,255,255,.1)" stroke="rgba(255,255,255,.36)" stroke-width="2"/><text x="50" y="56" text-anchor="middle" font-size="18" font-weight="900" fill="#f6fdff">${label}</text></svg></span>`;
    return `<span class="chip-face"><svg viewBox="0 0 100 100" aria-hidden="true"><defs><radialGradient id="g${chipId}" cx="32%" cy="28%"><stop offset="0%" stop-color="#ffffff" stop-opacity=".95"/><stop offset="18%" stop-color="${a}" stop-opacity=".95"/><stop offset="100%" stop-color="${b}"/></radialGradient><linearGradient id="rg${chipId}" x1="0" x2="1"><stop offset="0%" stop-color="rgba(255,255,255,.9)"/><stop offset="100%" stop-color="rgba(255,255,255,.15)"/></linearGradient></defs><circle cx="50" cy="50" r="46" fill="url(#g${chipId})" stroke="rgba(255,240,190,.95)" stroke-width="3"/><circle cx="50" cy="50" r="35" fill="rgba(255,255,255,.08)" stroke="rgba(255,255,255,.55)" stroke-width="2" stroke-dasharray="4 6"/><circle cx="50" cy="50" r="23" fill="rgba(0,0,0,.18)" stroke="rgba(255,255,255,.35)" stroke-width="2"/><text x="50" y="56" text-anchor="middle" font-size="20" font-weight="900" fill="#fff8dc" style="letter-spacing:.5px">${label}</text><ellipse cx="40" cy="28" rx="24" ry="12" fill="url(#rg${chipId})" opacity=".48"/></svg></span>`;
  }
  function installGlossyChips(){els.chips.forEach(c=>{let v=Number(c.dataset.value);c.innerHTML=chipSVG(v);});}

  function classifyHandLabel(label){
    const k=String(label||'').trim().toUpperCase();
    if(k.includes('PAIR')) return 'badge-pair';
    if(k.includes('SEQUENCE')||k.includes('SEQ')) return 'badge-sequence';
    if(k.includes('FLUSH')||k.includes('COLOR')) return 'badge-flush';
    if(k.includes('TRAIL')||k.includes('PURE')) return 'badge-trail';
    return '';
  }
  function updateChipHud(){
    if(els.chipSelectHud) els.chipSelectHud.classList.remove('show');
    if(els.chipSelectMini) els.chipSelectMini.textContent=chipLabel(state.selectedChip);
    if(els.chipSelectValue) els.chipSelectValue.textContent=number(state.selectedChip);
    return [];
  }

  function positionFloatingUI(){
    try{
      const viewportW = window.innerWidth || document.documentElement.clientWidth || 390;
      const viewportH = window.innerHeight || document.documentElement.clientHeight || 700;
      const topRect = els.topStack ? els.topStack.getBoundingClientRect() : {bottom:96,height:96};
      const bottomRect = els.bottomStack ? els.bottomStack.getBoundingClientRect() : {top:viewportH-230,height:230};
      const safeTop = Math.max(10, Math.ceil(topRect.bottom) + 8);
      const safeBottomY = Math.min(viewportH - 10, Math.floor(bottomRect.top) - 8);
      const freeTop = safeTop;
      const freeBottom = Math.max(safeTop + 92, safeBottomY);
      const freeHeight = Math.max(96, freeBottom - freeTop);
      const compact = freeHeight < 168;
      const sidePad = Math.max(12, Math.round(viewportW * 0.04));
      const topGap = compact ? 6 : 10;
      const stackGap = compact ? 8 : 12;
      const bannerH = els.floatingBanner ? Math.max(32, els.floatingBanner.offsetHeight || 32) : 32;
      const phaseH = els.phaseBanner ? Math.max(30, els.phaseBanner.offsetHeight || 30) : 30;
      const hudH = els.chipSelectHud ? Math.max(50, els.chipSelectHud.offsetHeight || 50) : 50;
      const toastH = 0;
      const noticeH = els.messageBanner ? Math.max(48, els.messageBanner.offsetHeight || 48) : 48;
      const phaseTop = freeTop + topGap;
      const floatingTop = phaseTop + phaseH + 6;
      const noticeTop = Math.round(Math.min(freeBottom - noticeH - stackGap, freeTop + freeHeight * (compact ? .18 : .16)));
      let toastTop = Math.max(freeTop + 10, freeBottom - (compact ? 6 : 10));
      let hudTop = Math.min(Math.round(freeTop + freeHeight * (compact ? 0.34 : 0.28)), freeBottom - hudH - stackGap);
      const minHudTop = floatingTop + bannerH + stackGap;
      if(hudTop < minHudTop) hudTop = minHudTop;
      if(hudTop + hudH + stackGap > freeBottom){
        hudTop = Math.max(freeTop + Math.round((freeHeight - hudH - stackGap) * 0.42), minHudTop);
      }
      if(els.phaseBanner){
        els.phaseBanner.style.top = phaseTop + 'px';
        els.phaseBanner.style.bottom = 'auto';
        els.phaseBanner.style.left = '50%';
        els.phaseBanner.style.transform = 'translateX(-50%)';
        els.phaseBanner.style.maxWidth = 'min(84vw, 320px)';
      }
      if(els.floatingBanner){
        els.floatingBanner.style.top = floatingTop + 'px';
        els.floatingBanner.style.bottom = 'auto';
        els.floatingBanner.style.left = '50%';
        els.floatingBanner.style.transform = 'translateX(-50%)';
        els.floatingBanner.style.maxWidth = 'min(84vw, 320px)';
      }

      if(els.messageBanner){
        if(freeBottom - freeTop < 56){ hideNotice(); }
        els.messageBanner.style.top = noticeTop + 'px';
        els.messageBanner.style.left = '50%';
        els.messageBanner.style.bottom = 'auto';
      }
    }catch(err){
      console.warn('positionFloatingUI fallback used', err);
    }
  }

  async function safeBoot(){
    try{
      await boot();
    }catch(err){
      console.error('Boot failed:', err);
      updateSplash(100,'Recovered from startup issue · entering game');
      state.splashDone = true;
      if(els.loadingSkeleton){els.loadingSkeleton.style.opacity='0';els.loadingSkeleton.style.visibility='hidden';}
      if(els.game)els.game.classList.add('loaded');
      if(useStandalonePreview && !(window.BDGameFinal && window.BD_GAME_BOOTSTRAP && window.BD_GAME_BOOTSTRAP.gameCode === currentGameCode)){
        try{startBettingSequence();}catch(e){console.error('Recovery start failed:', e);}
      }
    }
  }
  function networkQuality(ms){
    if(!ms||!isFinite(ms))return 'warn';
    if(ms<=120)return 'good';
    if(ms<=260)return 'warn';
    return 'bad';
  }
  function updateStatusStrip(){
    if(els.roundCount)els.roundCount.textContent=state.round>0?String(state.round):'-';
    if(els.netStat)els.netStat.textContent=state.networkMs?`${state.networkMs}ms`:'--';
    state.networkQuality=networkQuality(state.networkMs);
    if(els.netPill){
      els.netPill.classList.remove('good','warn','bad');
      els.netPill.classList.add(state.networkQuality);
    }
    if(els.netIcon){
      const icon=state.networkQuality==='good'?'fa-wifi':state.networkQuality==='bad'?'fa-triangle-exclamation':'fa-signal';
      els.netIcon.innerHTML=`<i class="fas ${icon}"></i>`;
    }
  }
  async function refreshNetwork(){
    if(state.networkProbeBusy)return;
    if(typeof navigator.onLine==='boolean' && !navigator.onLine){ state.offline=true; state.networkMs=999; updateStatusStrip(); return; }
    state.networkProbeBusy=true;
    try{
      let ms=0;
      const conn=navigator.connection||navigator.mozConnection||navigator.webkitConnection;
      if(conn && typeof conn.rtt==='number' && conn.rtt>0) ms=conn.rtt;
      if((location.protocol==='http:'||location.protocol==='https:')){
        const url=(location.pathname||'/') + (location.search?location.search+'&':'?') + '_tp_ping=' + Date.now();
        const start=performance.now();
        try{
          await fetch(url,{method:'GET',cache:'no-store',credentials:'same-origin'});
          const delta=Math.round(performance.now()-start);
          if(delta>0 && delta<5000) ms = ms ? Math.round((ms+delta)/2) : delta;
        }catch(err){}
      }
      state.networkMs=Math.max(12, Math.min(999, Math.round(ms || state.networkMs || 180)));
    } finally {
      state.networkProbeBusy=false;
      updateStatusStrip();
    }
  }
  function pulseChipHud(){ return; }
  function updateBottomChipState(isLive){
    if(els.chipsBar)els.chipsBar.classList.toggle('locked',!isLive);
    els.chips.forEach(c=>{
      const selected=Number(c.dataset.value)===state.selectedChip;
      c.classList.toggle('recent-hit', isLive && Number(c.dataset.value)===state.lastChipValue);
      c.classList.toggle('focus-chip', selected && isLive);
      c.setAttribute('aria-pressed', selected ? 'true' : 'false');
    });
  }
  function getTimerDisplayState(){
    if(state.phase==='go')return {text:'GO',variant:'text',progress:.94,hidden:false};
    if(state.phase==='betting'){
      const shown=Math.max(2,Math.floor(state.displayTime ?? state.timeLeft));
      return {text:String(shown),variant:'num',progress:Math.max(0,Math.min(1,shown/LOCAL_TEEN_BET_SECONDS)),hidden:false};
    }
    return {text:'',variant:'soft',progress:0,hidden:true};
  }
  function setDisplayTime(v){state.displayTime=Math.max(0,Math.floor(v));renderTimer();}
  function resetTotalsZero(){state.totals={A:0,B:0,C:0};state.myBets={A:0,B:0,C:0};['A','B','C'].forEach(k=>{if(els.total[k])els.total[k].textContent='0';if(els.won[k])els.won[k].textContent='0';});}
  function pressIcon(btn){if(btn&&shouldAnimate())gsap.fromTo(btn,{scale:1},{scale:.92,duration:.08,yoyo:!0,repeat:1});}
  
  function showAudioPopup(){
    els.audioPopup?.classList.add('show');
    els.audioPopupOverlay?.classList.add('show');
    els.audioPopup?.setAttribute('aria-hidden','false');
    applyAudioPrefsUI();
  }
  function hideAudioPopup(){
    els.audioPopup?.classList.remove('show');
    els.audioPopupOverlay?.classList.remove('show');
    els.audioPopup?.setAttribute('aria-hidden','true');
  }
  function flashBalanceEffect(type){
    if(!els.balanceSection)return;
    let color=type==='win'?'#46e88a':type==='loss'?'#ff6f7f':'#aaa';
    let shake=type==='win'?4:3;
    if(shouldAnimate()){
      gsap.killTweensOf(els.balanceSection);
      gsap.fromTo(els.balanceSection,{x:0, boxShadow:`0 0 0px ${color}`},{x:type==='win'?shake:-shake,duration:.06,repeat:7,yoyo:!0,boxShadow:`0 0 26px ${color}`,borderColor:color,onComplete:()=>gsap.set(els.balanceSection,{clearProps:'x,boxShadow,borderColor'})});
    }
  }
  function closeModal(modal){if(!modal)return;let card=modal.querySelector('.modal-card');const hide=()=>{modal.classList.remove('show');modal.style.removeProperty('opacity');modal.style.removeProperty('visibility');modal.style.removeProperty('pointer-events');};if(shouldAnimate()&&card){gsap.to(card,{y:20,scale:.9,opacity:0,duration:.25,onComplete:()=>{hide();gsap.set(card,{clearProps:'all'});}});}else{hide();}}

  function triggerBalanceWaterDrop(){
    if(els.balanceImpact){
      els.balanceImpact.classList.remove('ripple');
      void els.balanceImpact.offsetWidth;
      els.balanceImpact.classList.add('ripple');
    }
    if(els.balanceDroplet){
      els.balanceDroplet.classList.remove('drop');
      void els.balanceDroplet.offsetWidth;
      els.balanceDroplet.classList.add('drop');
    }
  }
  function createFlyingChip(value, startRect){
    let chip=document.createElement('div');
    chip.className='payout-chip-ghost';
    chip.innerHTML=chipSVG(value);
    chip.style.left=(startRect.left + startRect.width/2 - 12)+'px';
    chip.style.top=(startRect.top + startRect.height/2 - 12)+'px';
    document.body.appendChild(chip);
    return chip;
  }
  function isPassivePhaseModal(modal){return !!(modal&&(modal.classList.contains('start-pop')||modal.classList.contains('stop-pop')||modal.classList.contains('winner-pop')||modal.classList.contains('loss-pop')||modal.classList.contains('loser-pop')||modal.id==='modalNoBid'));}
  function openModal(modal){if(!modal)return;modal.classList.add('show');modal.style.setProperty('opacity','1','important');modal.style.setProperty('visibility','visible','important');modal.style.setProperty('pointer-events',isPassivePhaseModal(modal)?'none':'auto','important');let card=modal.querySelector('.modal-card');if(card&&isPassivePhaseModal(modal))card.style.setProperty('pointer-events','none','important');if(shouldAnimate()&&card){gsap.fromTo(card,{y:34,scale:.82,opacity:0,rotateX:10},{y:0,scale:1,opacity:1,rotateX:0,duration:.34,ease:"back.out(1.1)"});gsap.fromTo(card.querySelector('.popup-icon')||card,{scale:.86,opacity:.55},{scale:1,opacity:1,duration:.28,delay:.04,ease:"power2.out"});}const burstCount=document.body.classList.contains('low-end-mode')?12:18;particleBurst(innerWidth/2,innerHeight*.45,burstCount,'#ffd76e','spark');}
  function showUtilityModal(id){let m=els.modals[id];if(m)openModal(m);}
  function queueModal(type,ms){let m=els.modals[type];if(!m)return Promise.resolve();const now=Date.now();if(state.lastModalType===type && now-(state.lastModalAt||0)<260)return state.popupQueue||Promise.resolve();state.lastModalType=type;state.lastModalAt=now;state.popupQueue=state.popupQueue.then(()=>new Promise(r=>{state.modalShowing=true;openModal(m);schedule(()=>{closeModal(m);state.modalShowing=false;r();},ms);}));return state.popupQueue;}
  function showMegaCelebration(){return Promise.resolve();}
  function showMessage(text,ms){return new Promise(r=>{if(!els.messageBanner){r();return;}els.messageBanner.textContent=text;if(shouldAnimate()){gsap.fromTo(els.messageBanner,{opacity:0,scale:.9,y:10},{opacity:1,scale:1,y:0,duration:.25,onComplete:()=>schedule(()=>gsap.to(els.messageBanner,{opacity:0,scale:.95,y:-8,duration:.25,onComplete:r}),ms)});}else{schedule(r,ms);}});}
  function flashBanner(t){
    if(!els.floatingBanner) return;
    els.floatingBanner.textContent=t;
    positionFloatingUI();
    els.floatingBanner.style.visibility='visible';
    if(shouldAnimate()){
      gsap.killTweensOf(els.floatingBanner);
      gsap.fromTo(els.floatingBanner,{opacity:0,y:12},{opacity:1,y:0,duration:.2,onComplete:()=>gsap.to(els.floatingBanner,{opacity:0,y:-8,duration:.3,delay:.7,onComplete:()=>{ if(els.floatingBanner) els.floatingBanner.style.visibility='hidden'; }})});
    }else{
      els.floatingBanner.style.opacity='0';
      els.floatingBanner.style.visibility='hidden';
    }
  }
  function renderBalance(){if(els.balanceText){const txt=balanceNumber(state.balance);els.balanceText.textContent=txt;els.balanceText.title=txt;}}
  function renderTotals(){['A','B','C'].forEach(k=>{if(els.total[k])els.total[k].textContent=number(state.totals[k]);});}
  function renderTimer(){
    const ui=getTimerDisplayState();
    if(els.timerValue){
      els.timerValue.textContent=ui.text;
      els.timerValue.dataset.value=ui.text;
      els.timerValue.classList.remove('phase-text','phase-soft');
      if(ui.variant==='text')els.timerValue.classList.add('phase-text');
      if(ui.variant==='soft')els.timerValue.classList.add('phase-soft');
    }
    let p=Math.max(0,Math.min(1,ui.progress));
    if(els.timerOrb){
      els.timerOrb.style.setProperty('--p',p);
      els.timerOrb.style.setProperty('--timer-angle', `${(-90 + ((1 - p) * 360)).toFixed(2)}deg`);
      els.timerOrb.classList.toggle('hidden-phase', !!ui.hidden);
    }
    if(els.timerWrap){
      els.timerWrap.classList.toggle('timer-hidden', !!ui.hidden);
      els.timerWrap.classList.toggle('round-go', state.phase==='go' && !ui.hidden);
      els.timerWrap.classList.toggle('round-live', state.phase==='betting' && !ui.hidden);
    }
    let shown=Math.max(0,Math.floor(state.displayTime ?? state.timeLeft));
    let color=state.phase==='betting'?(shown>13?'#46e88a':shown>6?'#ffd24f':'#ff6f7f'):'#c4a5ff';
    if(state.phase==='go') color='#ffd76e';
    if(els.timerOrb)els.timerOrb.style.setProperty('--timer-color',color);
  }
  function showPhaseBanner(text){
    if(!els.phaseBanner) return;
    if(phaseBannerHideTimer){
      window.clearTimeout(phaseBannerHideTimer);
      phaseBannerHideTimer = null;
    }
    els.phaseBanner.textContent=text;
    positionFloatingUI();
    els.phaseBanner.style.visibility='visible';
    els.phaseBanner.classList.remove('show');
    void els.phaseBanner.offsetWidth;
    els.phaseBanner.classList.add('show');
    phaseBannerHideTimer = window.setTimeout(() => {
      if(els.phaseBanner){
        els.phaseBanner.classList.remove('show');
        els.phaseBanner.style.visibility='hidden';
      }
      phaseBannerHideTimer = null;
    }, 820);
  }

  function boardCenterRect(boardKey){
    let el=els.boards[boardKey];
    if(!el)return null;
    let r=el.getBoundingClientRect();
    return {x:r.left+r.width/2,y:r.top+r.height/2,rect:r};
  }

  function triggerBoardMagic(boardKey){
    let el=els.boards[boardKey];
    let info=boardCenterRect(boardKey);
    if(!el||!info)return;
    el.classList.remove('magic-hit');
    void el.offsetWidth;
    el.classList.add('magic-hit');
    particleBurst(info.x,info.y,18,'#ffd76e','spark');
    particleBurst(info.x,info.y,8,'#b995ff','spark');
    let ring=document.createElement('div');
    ring.className='divine-ring';
    ring.style.left=(info.x-13)+'px';
    ring.style.top=(info.y-13)+'px';
    document.body.appendChild(ring);
    if(shouldAnimate()){
      gsap.fromTo(ring,{opacity:.95,scale:.4},{opacity:0,scale:4.4,duration:.7,ease:'power2.out',onComplete:()=>ring.remove()});
      gsap.fromTo(el,{rotateZ:0},{rotateZ:0,duration:.01,onComplete:()=>gsap.to(el,{yoyo:true,repeat:1,scale:1.03,duration:.12})});
    }else{
      setTimeout(()=>ring.remove(),700);
    }
    setTimeout(()=>el.classList.remove('magic-hit'),720);
  }

  async function boardWinnerDivineBurst(boardKey){
    let pot=els.potWrappers[boardKey];
    let board=els.boards[boardKey];
    let info=boardCenterRect(boardKey);
    if(!pot||!board||!info)return;
    for(let i=0;i<4;i++){
      setTimeout(()=>{
        particleBurst(info.x,info.y,24,'#ffd76e','spark');
        particleBurst(info.x,info.y-18,12,'#ffffff','spark');
      },i*140);
    }
    particleRing(boardKey);
    if(shouldAnimate()){
      gsap.fromTo(pot.querySelector('.pot-aura'),{scale:.78,opacity:.2},{scale:1.12,opacity:1,duration:.55,yoyo:true,repeat:1,ease:'sine.inOut'});
      gsap.fromTo(board.querySelector('.board-energy'),{opacity:.2,scale:.7,rotation:0},{opacity:1,scale:1.18,rotation:180,duration:.9,ease:'power2.out'});
    }
  }

  function setPhase(phase){const previousPhase=state.phase;state.phase=phase; if(els.game){els.game.classList.remove('phase-boot','phase-go','phase-betting','phase-stopbet','phase-reveal','phase-winner','phase-reset'); els.game.classList.add(`phase-${phase}`);} if(els.timerSub){els.timerSub.textContent=phase==='betting'?'BET':phase==='go'?'READY':'';} if(phase!=='betting'){state.displayTime=0;} if(phase!=='stopbet'&&phase!=='reveal'&&phase!=='winner'){ hideNotice(); } if(previousPhase!==phase)playTeenPhaseFx(phase);syncTeenMusicForPhase(phase); renderTimer(); }
  function enableBetting(on){els.chips.forEach(c=>c.classList.toggle('live',on));Object.values(els.boards).forEach(b=>{if(b)b.classList.toggle('touchable',on);});updateBottomChipState(on);if(on)selectChip(state.selectedChip,false);}
  function selectChip(v,pulse=true){state.selectedChip=v;state.lastChipValue=v;els.chips.forEach(c=>c.classList.toggle('selected',Number(c.dataset.value)===v));updateBottomChipState(state.bettingEnabled && state.phase==='betting');updateChipHud();if(pulse)pulseChipHud();}
  function animateChipFlight(boardKey,value){let chip=els.chips.find(c=>Number(c.dataset.value)===value);let board=els.boards[boardKey];if(!chip||!board||!shouldAnimate()||!bridgeFxAllowed(2))return;let from=chip.getBoundingClientRect(),to=board.getBoundingClientRect();let ghost=bridgeFxNode(document.createElement('div'),800);ghost.className='chip';ghost.style.position='fixed';ghost.style.left=from.left+'px';ghost.style.top=from.top+'px';ghost.style.width=from.width+'px';ghost.style.height=from.height+'px';ghost.style.zIndex='240';ghost.style.pointerEvents='none';ghost.innerHTML=chip.innerHTML;document.body.appendChild(ghost);particleBurst(from.left+from.width/2,from.top+from.height/2,10,'#ffd76e','spark');gsap.fromTo(ghost,{x:0,y:0,scale:1,rotate:0,opacity:1},{x:(to.left+to.width/2)-(from.left+from.width/2),y:(to.top+to.height/2)-(from.top+from.height/2),scale:.62,rotate:280,duration:.48,ease:'power2.inOut',onComplete:()=>ghost.remove()});}
  function placeBet(b){
    if(!state.bettingEnabled||(state.phase!=='betting')){
      if(state.phase==='stopbet'||state.phase==='reveal'||state.phase==='winner'){
        showNotice('STOP BET · WAIT FOR NEXT BID','warn',1400);
      }
      return;
    }
    const now=Date.now();
    if(state.modalShowing || (els.noticeBlocker && els.noticeBlocker.classList.contains('show'))) return;
    if(now-state.lastBoardTapAt<150)return;
    state.lastBoardTapAt=now;
    const multiplier=state.fastBidMode?2:1;
    if(state.balance<state.selectedChip){if(!state.busyNoBid){state.busyNoBid=true;queueModal('nobid',1600).finally(()=>{state.busyNoBid=false;});showNotice('INSUFFICIENT BALANCE','error',3000);}return;}
    const actualMulti=Math.min(multiplier, Math.max(1, Math.floor(state.balance/state.selectedChip)));
    const actualCost=state.selectedChip*actualMulti;
    state.lastBetBoard=b;
    for(let i=0;i<actualMulti;i++){
      schedule(()=>animateChipFlight(b,state.selectedChip), i*70);
    }
    state.balance-=actualCost;state.totals[b]+=actualCost;state.myBets[b]+=actualCost;
    if(els.balanceText){const txt=balanceNumber(state.balance);els.balanceText.textContent=txt;els.balanceText.title=txt;}
    renderTotals();haptic();updateBottomChipState(state.bettingEnabled);pulseChipHud();
    let be=els.boards[b];if(be){be.classList.add('live','selected-target');schedule(()=>be.classList.remove('live','selected-target'),450);if(shouldAnimate())gsap.fromTo(be,{scale:.98},{scale:1,duration:.18});}
    let pe=els.plus[b];if(pe){pe.textContent=`+${number(actualCost)}`;if(shouldAnimate()){gsap.killTweensOf(pe);gsap.fromTo(pe,{opacity:0,y:8,scale:.86},{opacity:1,y:0,scale:1,duration:.18,onComplete:()=>gsap.to(pe,{opacity:0,y:-10,duration:.28,delay:.55})});}}
    flashBanner(`${actualMulti>1?'FAST ':''}BET ${b} +${number(actualCost)}`);playTeenFx('coinServe');announce(`Bet ${number(actualCost)} on ${b}`);
    if(be){let r=be.getBoundingClientRect();particleBurst(r.left+r.width/2,r.top+20,12,'#ffd76e','spark');}
  }
  
  async function revealStack(b,cards,lt){let s=els.stacks[b];if(!s)return;let ce=Array.from(s.children);s.classList.add('reveal-active');for(let i=0;i<ce.length&&i<cards.length;i++){let cardEl=ce[i];await flipCard(cardEl,cards[i]);cardEl.classList.add('reveal-pop','shine-sweep');schedule(()=>cardEl.classList.remove('reveal-pop','shine-sweep'),520);await wait(120);}let l=els.labels[b];if(l){l.textContent=lt; l.classList.remove('badge-pair','badge-sequence','badge-flush','badge-trail'); const badgeClass=classifyHandLabel(lt); if(badgeClass)l.classList.add(badgeClass); l.classList.add('reveal-label');if(shouldAnimate())gsap.fromTo(l,{opacity:0,y:8,scale:.82},{opacity:1,y:0,scale:1,duration:.38,ease:'back.out(1.2)'});}s.classList.remove('reveal-active');}
  function flipCard(el,cd){playTeenFx('cardFlip');return new Promise(r=>{if(!shouldAnimate()){renderFront(el,cd);r();return;}const flipLift=Number(teenPattiFx.flip_lift||16);const flipTilt=Number(teenPattiFx.flip_tilt||12);const flipInDuration=Number(teenPattiFx.flip_in_duration||.22);const flipOutDuration=Number(teenPattiFx.flip_out_duration||.4);el.classList.add('card-flipping');gsap.timeline({onComplete:()=>{el.classList.remove('card-flipping');r();}}).to(el,{rotateY:92,rotate:flipTilt*.35,y:-flipLift,scale:.95,duration:flipInDuration,ease:'power2.in'}).add(()=>renderFront(el,cd)).fromTo(el,{rotateY:-96,rotate:-flipTilt,y:-(flipLift+2),scale:.92},{rotateY:0,rotate:0,y:0,scale:1,duration:flipOutDuration,ease:'back.out(1.18)',clearProps:'transform'});});}
  function normalizeSuitSymbol(rawSuit){
    const key=String(rawSuit||'').trim().toUpperCase();
    if(key==='S'||key==='SPADE'||key==='SPADES'||key==='♠') return {symbol:'♠',red:false};
    if(key==='H'||key==='HEART'||key==='HEARTS'||key==='♥') return {symbol:'♥',red:true};
    if(key==='D'||key==='DIAMOND'||key==='DIAMONDS'||key==='♦') return {symbol:'♦',red:true};
    if(key==='C'||key==='CLUB'||key==='CLUBS'||key==='♣') return {symbol:'♣',red:false};
    return {symbol:String(rawSuit||''),red:false};
  }
  function renderFront(el,[r,s,c]){const suitMeta=normalizeSuitSymbol(s);const parsed=[r,suitMeta.symbol,(suitMeta.red||(c==='red'))?'red':'black'];renderTeenFront(el,parsed);}
  async function foldBackAll(){for(let b of['A','B','C']){let s=els.stacks[b];if(!s)continue;let cards=Array.from(s.children).reverse();for(let c of cards){if(!c)continue;if(!shouldAnimate()){c.classList.remove('front');c.classList.add('back');c.innerHTML='';continue;}await new Promise(r=>{gsap.to(c,{rotateY:90,duration:.2,onComplete:()=>{c.classList.remove('front');c.classList.add('back');c.innerHTML='';gsap.fromTo(c,{rotateY:-90},{rotateY:0,duration:.22,onComplete:r});}});});await wait(60);}let l=els.labels[b];if(l){l.classList.remove('reveal-label','badge-pair','badge-sequence','badge-flush','badge-trail'); if(shouldAnimate())gsap.to(l,{opacity:0,y:6,duration:.2}); else l.style.opacity='0';}}}
  function parseLiveCardToken(token){const raw=String(token||'').trim();if(raw.length<2)return null;const suit=raw.slice(-1);const rank=raw.slice(0,-1);const meta=normalizeSuitSymbol(suit);return [rank,meta.symbol,meta.red?'red':'black'];}
  function resolveBoardMultiplier(payload,key){const board=(payload&&payload.boards||[]).find(item=>item&&String(item.frontend_key||item.canonical_key).toUpperCase()===key);const fromPayload=Number(board&&board.multiplier||0);return fromPayload>0?fromPayload:Number(boardPayoutMultipliers[key]||3);}
  function formatFallbackYouValue(payload,key){const myTotal=Number(payload&&payload.my_bet_totals&&payload.my_bet_totals[key]||0);const winner=payload&&(payload.winner_board||(payload.result&&payload.result.winner_board));if((payload.phase==='revealed'||payload.phase==='settled')&&winner===key&&myTotal>0){const multiplier=resolveBoardMultiplier(payload,key);return `${number(myTotal)} x${number(multiplier)} = ${number(myTotal*multiplier)}`;}return number(myTotal);}
  function paintLiveFallbackResult(payload){if(window.BDGameFinal&&window.BD_GAME_BOOTSTRAP&&window.BD_GAME_BOOTSTRAP.gameCode===currentGameCode)return;const result=payload&&payload.result;const cards=result&&result.cards;const winner=payload&&(payload.winner_board||(result&&result.winner_board));if(!cards||!winner)return;const resultKey=`${payload.round_no||'na'}:${winner}`;if(state.liveFallbackResultKey===resultKey&&document.querySelector('.card.front'))return;state.liveFallbackResultKey=resultKey;['A','B','C'].forEach(key=>{const hand=cards[key];const stack=els.stacks[key];if(stack&&hand&&Array.isArray(hand.cards)){Array.from(stack.children).slice(0,3).forEach((cardEl,index)=>{const parsed=parseLiveCardToken(hand.cards[index]);if(parsed){renderFront(cardEl,parsed);cardEl.classList.add('reveal-pop','shine-sweep');schedule(()=>cardEl.classList.remove('reveal-pop','shine-sweep'),520);}});}const label=els.labels[key];if(label&&hand){label.textContent=hand.label||key;label.classList.remove('badge-pair','badge-sequence','badge-flush','badge-trail');const badgeClass=classifyHandLabel(hand.label||'');if(badgeClass)label.classList.add(badgeClass);label.classList.add('reveal-label');label.style.opacity='1';}if(els.potWrappers[key])els.potWrappers[key].classList.toggle('winner-pot',key===winner);if(els.boards[key])els.boards[key].classList.toggle('winner-board',key===winner);});addCrown(winner);if(els.phaseBanner){els.phaseBanner.textContent=`WINNER ${winner}`;els.phaseBanner.classList.add('show');}}
  function startLiveSessionFallback(){if(state.liveFallbackStarted)return;state.liveFallbackStarted=true;const poll=async()=>{const boot=window.BD_GAME_BOOTSTRAP;if(!boot||!boot.endpoints||!boot.endpoints.state){schedule(poll,500);return;}const started=performance.now();try{const url=new URL(boot.endpoints.state,location.href);const response=await fetch(url.toString(),{headers:boot.sessionToken?{'X-Game-Session':boot.sessionToken}:{}});const payload=await response.json();state.networkMs=Math.max(1,Math.round(performance.now()-started));updateStatusStrip();if(payload&&payload.st){state.round=Number(String(payload.round_no||'').match(/(\d{1,3})$/)?.[1]||state.round||0);if(els.roundCount)els.roundCount.textContent=String(state.round||'-');if(els.balanceText&&payload.balance!=null){const txt=balanceNumber(payload.balance);els.balanceText.textContent=txt;els.balanceText.title=txt;}if(payload.phase==='betting'){setPhase('betting');updateBottomChipState(true);state.liveFallbackResultKey='';}else if(payload.phase==='locked'){setPhase('stopbet');updateBottomChipState(false);}else if(payload.phase==='revealed'||payload.phase==='settled'){setPhase('winner');updateBottomChipState(false);paintLiveFallbackResult(payload);}['A','B','C'].forEach(key=>{if(els.total[key]&&payload.board_totals)els.total[key].textContent=number(payload.board_totals[key]||0);if(els.won[key]&&payload.my_bet_totals)els.won[key].textContent=formatFallbackYouValue(payload,key);});}}catch(e){state.networkQuality='bad';updateStatusStrip();}schedule(poll,1200);};schedule(poll,80);}
  function wait(ms){return new Promise(r=>schedule(r,ms));}
  function startParticleLoop(){if(!particleRafId&&ctx2d)particleRafId=requestAnimationFrame(animateParticles);}
  function pushParticle(p){particles.push(p);startParticleLoop();}
  function particleBurst(x,y,c,color,type){if(!x||!y||isNaN(x)||isNaN(y)||prefersReducedMotion)return;c=Math.min(c,bridgeFxBudget('winParticles',c));if(!bridgeFxAllowed(c))return;for(let i=0;i<c;i++){let a=Math.random()*Math.PI*2;let sp=(type==='smoke'?.5:1.5)+Math.random()*1.8;pushParticle({x,y,vx:Math.cos(a)*sp,vy:Math.sin(a)*sp-(type==='smoke'?1.2:0),life:32+Math.random()*24,max:56,color,size:type==='smoke'?7+Math.random()*6:2.2+Math.random()*3,type});}}
  function animateParticles(){particleRafId=null;if(!ctx2d)return;if(!particles.length||document.hidden){ctx2d.clearRect(0,0,els.fx.width,els.fx.height);return;}ctx2d.clearRect(0,0,els.fx.width,els.fx.height);for(let i=particles.length-1;i>=0;i--){let p=particles[i];if(!p){particles.splice(i,1);continue;}p.x+=p.vx;p.y+=p.vy;p.life-=1;if(p.type==='smoke'){p.vx*=.98;p.vy*=.98;}else if(p.type==='confetti'){p.vy+=0.2;}else{p.vx*=.985;p.vy*=.985;}let a=Math.max(0,p.life/p.max);if(a<=0||p.x<-100||p.x>innerWidth+100||p.y<-100||p.y>innerHeight+100){particles.splice(i,1);continue;}ctx2d.globalAlpha=a;ctx2d.fillStyle=p.color;ctx2d.beginPath();ctx2d.arc(p.x,p.y,p.size,0,Math.PI*2);ctx2d.fill();}ctx2d.globalAlpha=1;if(particles.length)particleRafId=requestAnimationFrame(animateParticles);}
  function particleRing(b){let el=els.potWrappers[b];if(!el)return;let r=el.getBoundingClientRect();let cx=r.left+r.width/2,cy=r.top+55;let total=Math.min(40,bridgeFxBudget('winParticles',40));if(!bridgeFxAllowed(total))return;for(let i=0;i<total;i++){let a=Math.PI*2*i/total;pushParticle({x:cx+Math.cos(a)*55,y:cy+Math.sin(a)*55,vx:Math.cos(a)*.3,vy:Math.sin(a)*.3,life:45,max:45,color:b==='A'?'#ff5577':b==='B'?'#5599ff':'#55ff88',size:3.5,type:'spark'});}}
  
  async function winnerChairAndCardEffect(winner){
    let winnerPot=els.potWrappers[winner];
    if(!winnerPot)return;
    let spotlight=winnerPot.querySelector('.winner-spotlight');
    addCrown(winner);
    boardWinnerDivineBurst(winner);
    coinRain(18);
    winnerPot.classList.add('win-head-glow','winner-pot');
    if(els.boards[winner]) els.boards[winner].classList.add('winner-board');
    if(els.timerOrb) els.timerOrb.classList.add('win-glow');
    if(spotlight&&shouldAnimate()){
      gsap.to(spotlight,{opacity:1,scale:1.18,duration:.55,repeat:2,yoyo:!0});
      gsap.fromTo(winnerPot.querySelector('.pot-title'),{y:0},{y:-4,duration:.45,repeat:3,yoyo:!0});
      gsap.fromTo(winnerPot.querySelector('.chair'),{y:0},{y:-3,duration:.35,repeat:5,yoyo:!0,ease:"sine.inOut"});
      gsap.to(winnerPot.querySelectorAll('.card'),{scale:1.09,y:-8,duration:.45,stagger:.08,transformOrigin:'50% 100%'});
      gsap.fromTo(els.boards[winner],{y:0,scale:1},{y:-2,scale:1.03,duration:.38,repeat:5,yoyo:!0});
    }
    await wait(2000);
    if(spotlight&&shouldAnimate()){
      gsap.to(spotlight,{opacity:0,scale:1,duration:.4});
      gsap.to(winnerPot.querySelector('.pot-title'),{y:0,duration:.25});
      gsap.to(winnerPot.querySelector('.chair'),{y:0,duration:.25});
      gsap.to(winnerPot.querySelectorAll('.card'),{scale:1,y:0,duration:.35});
    }
    winnerPot.classList.remove('win-head-glow','winner-pot');
    if(els.boards[winner]) els.boards[winner].classList.remove('winner-board');
    if(els.timerOrb) els.timerOrb.classList.remove('win-glow');
  }
  
  async function animatePayout(winner,winAmount){
    let winEl=els.won[winner];
    if(!winEl)return;
    winEl.textContent=number(winAmount);
    let startBalance=state.balance;
    if(shouldAnimate()){
      await gsap.to(winEl,{scale:1.2,duration:.2,yoyo:!0,repeat:1});
      let x3Span=document.createElement('span');
      x3Span.textContent=' ×'+number(resolveBoardMultiplier(null,winner));
      x3Span.style.position='absolute';
      x3Span.style.left='50%';
      x3Span.style.top='50%';
      x3Span.style.transform='translate(-50%,-50%)';
      x3Span.style.fontSize='1.8rem';
      x3Span.style.fontWeight='bold';
      x3Span.style.color='#ffd76e';
      x3Span.style.textShadow='0 0 10px gold';
      x3Span.style.zIndex='100';
      winEl.style.position='relative';
      winEl.appendChild(x3Span);
      await gsap.fromTo(x3Span,{opacity:0,scale:.5},{opacity:1,scale:1.2,duration:.2,onComplete:()=>gsap.to(x3Span,{opacity:0,duration:.2,delay:.18,onComplete:()=>x3Span.remove()})});
      await wait(260);
      let from=winEl.getBoundingClientRect();
      let to=els.balanceSection?.getBoundingClientRect();
      if(to&&shouldAnimate()){
        const startX=from.left+from.width/2;
        const startY=from.top+from.height/2;
        const endX=to.left+to.width/2;
        const endY=to.top+to.height/2;
        let amountGhost=document.createElement('div');
        amountGhost.className='payout-fly-amount';
        amountGhost.textContent='+'+number(winAmount);
        amountGhost.style.left=(startX-16)+'px';
        amountGhost.style.top=(startY-10)+'px';
        document.body.appendChild(amountGhost);

        let chips=[
          createFlyingChip(500,from),
          createFlyingChip(1000,from),
          createFlyingChip(10000,from),
          createFlyingChip(50000,from)
        ];
        let rippleTriggered=false;
        const triggerImpact=()=>{
          if(rippleTriggered)return;
          rippleTriggered=true;
          state.balance += winAmount;
          animateNumber(els.balanceText,startBalance,state.balance,620);
          flashBalanceEffect('win');
          triggerBalanceWaterDrop();
          particleBurst(endX,endY,32,'#46e88a','spark');
        };

        gsap.to(amountGhost,{
          duration:1.05,
          x:endX-startX,
          y:endY-startY,
          scale:.72,
          ease:'power2.inOut',
          onStart:()=>gsap.to(amountGhost,{duration:.4, y:'-=28', ease:'power1.out'}),
          onComplete:()=>{amountGhost.remove();triggerImpact();}
        });

        chips.forEach((chip,idx)=>{
          const spread=(idx-1.5)*18;
          gsap.to(chip,{
            duration:.92 + idx*0.07,
            x:(endX-startX)+spread,
            y:(endY-startY)-10+idx*3,
            scale:.5,
            rotation:220+idx*90,
            ease:'power2.inOut',
            onStart:()=>gsap.to(chip,{duration:.32,y:'-=38', ease:'power1.out'}),
            onComplete:()=>{chip.remove(); if(idx===chips.length-1) triggerImpact();}
          });
        });

        await wait(1180);
      }else{
        state.balance+=winAmount;
        animateNumber(els.balanceText,startBalance,state.balance,500);
        flashBalanceEffect('win');
        triggerBalanceWaterDrop();
        confettiEffect();
      }
      confettiEffect();
      gsap.to(winEl,{scale:1,duration:.2});
    }else{
      state.balance+=winAmount;
      renderBalance();
    }
  }

  
function beginRoundTransition(){
  state.roundToken += 1;
  state.phaseLock = false;
  return state.roundToken;
}
function isStaleRound(token){
  return token !== state.roundToken;
}
function lockPhase(token){
  if(isStaleRound(token) || state.phaseLock) return false;
  state.phaseLock = true;
  return true;
}
function unlockPhase(token){
  if(!isStaleRound(token)) state.phaseLock = false;
}

async function startBettingSequence(opts={}){
  const token = beginRoundTransition();
  const cfg={showStartModal:true,showGoLead:true,initialTime:LOCAL_TEEN_BET_SECONDS,...opts};
  state.bettingEnabled=false;
  enableBetting(false);
  if(cfg.showStartModal) await queueModal('start',2400);
  if(isStaleRound(token)) return;
  if(cfg.showGoLead){
    setPhase('go');
    if(els.timerOrb){els.timerOrb.classList.remove('disabled');els.timerOrb.classList.add('pulse-active');}
    renderTimer();
    await wait(820);
    if(isStaleRound(token)) return;
  }
  state.bettingEnabled=true;
  setPhase('betting');
  showPhaseBanner('BETTING OPEN');
  state.timeLeft=Math.max(2, Math.floor(cfg.initialTime||LOCAL_TEEN_BET_SECONDS));
  setDisplayTime(state.timeLeft);
  positionFloatingUI();
  if(els.timerOrb){els.timerOrb.classList.remove('disabled');els.timerOrb.classList.add('pulse-active');}
  enableBetting(true);
  if(state.interval)clearInterval(state.interval);
  state.interval=setInterval(()=>{
    if(!state.bettingEnabled || isStaleRound(token)) return;
    state.timeLeft=Math.max(0,state.timeLeft-1);
    if(state.timeLeft<=1){
      if(state.interval)clearInterval(state.interval);
      state.interval=null;
      stopBetPhase(token);
      return;
    }
    setDisplayTime(state.timeLeft);
  },1000);
  announce(`Betting started. ${state.timeLeft} seconds`);
}

  
  async function stopBetPhase(token=state.roundToken){
    if(!lockPhase(token)) return;
    setPhase('stopbet');
    showPhaseBanner('STOP BET');
    state.bettingEnabled=false;
    enableBetting(false);
    if(els.timerOrb){els.timerOrb.classList.remove('pulse-active');els.timerOrb.classList.add('disabled');}
    setDisplayTime(0);
    await queueModal('stop',2600);
    if(isStaleRound(token)) return;
    await wait(620);
    unlockPhase(token);
    await suspensePhase(token);
  }
  
  async function suspensePhase(token=state.roundToken){
    if(!lockPhase(token)) return;
    setPhase('reveal');
    showPhaseBanner('CARD REVEAL');
    flashBanner('✨');
    showNotice('RESULT CALCULATING','warn',1600);
    await wait(860);
    if(isStaleRound(token)) return;
    unlockPhase(token);
    await revealAndWinnerPhase(token);
  }
  
  async function revealAndWinnerPhase(token=state.roundToken){
    if(!lockPhase(token)) return;
    await revealStack('A',PREVIEW_CONFIG.cards.A,PREVIEW_CONFIG.labels.A);
    if(isStaleRound(token)) return;
    await wait(160);
    await revealStack('B',PREVIEW_CONFIG.cards.B,PREVIEW_CONFIG.labels.B);
    if(isStaleRound(token)) return;
    await wait(160);
    await revealStack('C',PREVIEW_CONFIG.cards.C,PREVIEW_CONFIG.labels.C);
    if(isStaleRound(token)) return;
    state.winner=PREVIEW_CONFIG.manualWinner!=='random'?PREVIEW_CONFIG.manualWinner:['A','B','C'][Math.floor(Math.random()*3)];
    setPhase('winner');
    showPhaseBanner(`WINNER ${state.winner}`);
    Object.entries(els.boards).forEach(([k,el])=>{if(el)el.classList.add(k===state.winner?'winner':'loser');});
    announce(`${state.winner} wins!`);
    await winnerChairAndCardEffect(state.winner);
    if(isStaleRound(token)) return;
    let totalBet=Object.values(state.myBets).reduce((a,b)=>a+b,0);
    let winAmt=state.myBets[state.winner]*3;
    if(totalBet<=0){playTeenFx('noBet');window.clearTeenPattiWinnerPopupCards?.();flashBalanceEffect('nobid');await queueModal('nobid',2600);showToast('No bet placed this round','error');}
    else if(winAmt>0){playTeenFx('win');window.renderTeenPattiWinnerPopupCards?.(state.winner,{cards:PREVIEW_CONFIG.cards[state.winner]||[],label:PREVIEW_CONFIG.labels[state.winner]||''});if(els.winText)els.winText.textContent=`${state.winner} WIN · +${number(winAmt)} PAYOUT`;await queueModal('win',2100);await showMegaCelebration(`Winner ${state.winner} · +${number(winAmt)}`,1500);await animatePayout(state.winner,winAmt);showToast(`You won ${number(winAmt)}!`, 'win');}
    else{playTeenFx('loss');window.clearTeenPattiWinnerPopupCards?.();await queueModal('loss',2400);showToast('Better luck next time!','error');}
    if(isStaleRound(token)) return;
    await wait(760);
    Object.entries(els.boards).forEach(([k,el])=>{if(el)el.classList.remove('winner','loser');});
    unlockPhase(token);
    await nextRoundPrep(token);
  }
  
  async function nextRoundPrep(token=state.roundToken){
    if(isStaleRound(token)) return;
    setPhase('reset');
    state.round+=1;
    updateStatusStrip();
    showPhaseBanner(`ROUND ${state.round}`);
    await foldBackAll();
    clearTimers();
    resetTotalsZero();
    state.timeLeft=LOCAL_TEEN_BET_SECONDS;
    setDisplayTime(LOCAL_TEEN_BET_SECONDS);
    renderBalance();
    renderTotals();
    if(els.timerOrb){els.timerOrb.classList.add('disabled');els.timerOrb.classList.remove('pulse-active');gsap.set(els.timerOrb,{opacity:0.5});}
    await wait(360);
    if(isStaleRound(token)) return;
    await goPhase(token);
  }
  
  async function goPhase(token=state.roundToken){
    if(isStaleRound(token)) return;
    let goModal=els.modals.go;
    state.modalShowing=true;
    if(goModal){
      goModal.classList.add('show');
      let card=goModal.querySelector('.modal-card');
      if(shouldAnimate()&&card){
        gsap.fromTo(card,{scale:.88,opacity:0,y:20},{scale:1,opacity:1,y:0,duration:.22,ease:"back.out(1.5)"});
        await wait(700);
        gsap.to(card,{scale:.96,opacity:0,y:-10,duration:.18,onComplete:()=>goModal.classList.remove('show')});
      }else{await wait(920);goModal.classList.remove('show');}
    }else{await wait(920);}
    state.modalShowing=false;
    await wait(120);
    if(isStaleRound(token)) return;
    startBettingSequence();
  }
  
  function resetCards(){Object.entries(els.stacks).forEach(([k,s])=>{if(!s)return;Array.from(s.children).forEach(c=>{if(c){c.classList.remove('front');c.classList.add('back');c.innerHTML='';}});});}

const PREVIEW_CYCLE={go:1200,betting:LOCAL_TEEN_BET_MS,stopbet:3000,reveal:2200,winner:5200,reset:1400};
function detectPreviewEntryState(){
  const total=Object.values(PREVIEW_CYCLE).reduce((a,b)=>a+b,0);
  let t=Date.now()%total;
  const phases=[['go',PREVIEW_CYCLE.go],['betting',PREVIEW_CYCLE.betting],['stopbet',PREVIEW_CYCLE.stopbet],['reveal',PREVIEW_CYCLE.reveal],['winner',PREVIEW_CYCLE.winner],['reset',PREVIEW_CYCLE.reset]];
  for(const [phase,dur] of phases){
    if(t<dur) return {phase,remainingMs:Math.max(200,dur-t)};
    t-=dur;
  }
  return {phase:'betting',remainingMs:LOCAL_TEEN_BET_MS};
}
async function enterPreviewWatchMode(joinPhase){
  state.entryHandled=true;
  state.bettingEnabled=false;
  enableBetting(false);
  if(els.timerOrb){els.timerOrb.classList.remove('pulse-active');els.timerOrb.classList.add('disabled');}
  await showNotice('WAIT FOR NEXT BID', 'warn', 3000);
  if(joinPhase==='reveal'){
    setPhase('reveal');
    showPhaseBanner('CARD REVEAL');
    await wait(300);
    await revealAndWinnerPhase();
    return;
  }
  if(joinPhase==='winner'){
    await revealStack('A',PREVIEW_CONFIG.cards.A,PREVIEW_CONFIG.labels.A);
    await wait(120);
    await revealStack('B',PREVIEW_CONFIG.cards.B,PREVIEW_CONFIG.labels.B);
    await wait(120);
    await revealStack('C',PREVIEW_CONFIG.cards.C,PREVIEW_CONFIG.labels.C);
    await wait(200);
    await revealAndWinnerPhase();
    return;
  }
  setPhase('stopbet');
  showPhaseBanner('STOP BET');
  await queueModal('stop',1800);
  await suspensePhase();
}
async function startFromPreviewEntryState(){
  const preview=detectPreviewEntryState();
  if(preview.phase==='betting'){
    return startBettingSequence({showStartModal:false,showGoLead:false,initialTime:Math.max(2, Math.ceil(preview.remainingMs/1000))});
  }
  if(preview.phase==='go'){
    await wait(Math.min(700, preview.remainingMs));
    return startBettingSequence({showStartModal:false,showGoLead:true,initialTime:LOCAL_TEEN_BET_SECONDS});
  }
  if(preview.phase==='reset'){
    return goPhase();
  }
  return enterPreviewWatchMode(preview.phase);
}
function installConnectionGuards(){
  const offlineHandler=()=>{
    state.offline=true;
    state.networkMs=999;
    updateStatusStrip();
    stopAmbient();
    playTeenFx('network');
    showNotice('NETWORK CONNECTION LOST','error',3000);
  };
  const onlineHandler=()=>{
    const wasOffline=state.offline;
    state.offline=false;
    refreshNetwork();
    syncTeenMusicForPhase();
    if(wasOffline) showNotice('NETWORK RECONNECTED','good',1800);
  };
  window.addEventListener('offline', offlineHandler);
  window.addEventListener('online', onlineHandler);
  if(typeof navigator.onLine==='boolean' && !navigator.onLine) offlineHandler();
}



  function detectLowEndMode(){
    const dm = navigator.deviceMemory || 0;
    const hc = navigator.hardwareConcurrency || 0;
    const smallHeight = (window.innerHeight || 0) <= 520;
    return prefersReducedMotion || dm > 0 && dm <= 4 || hc > 0 && hc <= 4 || smallHeight;
  }
  function applyDeviceProfile(){
    const low = detectLowEndMode();
    document.body.classList.toggle('low-end-mode', !!low);
    state.lowEndMode = !!low;
  }
  function applySeatIdentity(){
    Object.entries(els.pots || {}).forEach(([key,pot])=>{
      if(!pot) return;
      pot.setAttribute('data-seat-theme', key);
      pot.setAttribute('data-seat-name', boardDisplayName(key));
      const title = pot.querySelector('.pot-title');
      if(title){
        title.textContent = boardDisplayName(key);
        title.setAttribute('aria-label', `${boardDisplayName(key)} seat`);
      }
      const label = els.labels[key];
      if(label){
        label.textContent = boardDisplayName(key);
      }
    });
  }

async function boot(){const useAuthoritativeBridge=hasLiveSession||!!(window.BDGameFinal && window.BD_GAME_BOOTSTRAP && window.BD_GAME_BOOTSTRAP.gameCode===currentGameCode);const usePreviewFallback=useStandalonePreview&&!useAuthoritativeBridge;applyDeviceProfile();installGlossyChips();applySeatIdentity();updateChipHud();updateBottomChipState(false);preventSelectionBugs();resetTotalsZero();resetCards();setPhase('boot');setDisplayTime(0);updateStatusStrip();positionFloatingUI();installConnectionGuards();if(usePreviewFallback){schedule(function netLoop(){refreshNetwork();schedule(netLoop,4200);},900);}Object.values(els.labels).forEach(l=>{if(l){l.style.opacity='0';}});await Promise.race([runSplashSequence(), wait(3600)]);
  state.splashDone=true;
  if(els.loadingSkeleton){els.loadingSkeleton.style.opacity='0';els.loadingSkeleton.style.visibility='hidden';}
  if(els.game)els.game.classList.add('loaded');positionFloatingUI();if(useAuthoritativeBridge){announce('Game sync ready');return;}showNotice('LIVE SESSION REQUIRED','warn',2600);announce('Live session required');}

  
  function ensureTeenAudioEngine(){
    installTeenAudioTracking();
    const AC=window.AudioContext||window.webkitAudioContext;
    if(!state.musicEngine&&AC){
      state.musicEngine=new AC();
      trackedTeenRoomAudioContexts.add(state.musicEngine);
    }
    return state.musicEngine;
  }
  function tone(f=440,d=.12,t='sine',v=.03,delayMs=0){
    if(!state.audioUnlocked||!state.prefs.sound)return;
    const ctx=ensureTeenAudioEngine();
    if(!ctx)return;
    if(ctx.state==='suspended')ctx.resume().catch(e=>{});
    const start=ctx.currentTime+(Math.max(0,Number(delayMs)||0)/1000);
    const duration=Math.max(.025,Number(d)||.12);
    let osc;
    let gain;
    try{
      osc=ctx.createOscillator();
      gain=ctx.createGain();
      osc.type=t;
      osc.frequency.setValueAtTime(Math.max(40,Number(f)||440),start);
      gain.gain.setValueAtTime(.0001,start);
      gain.gain.exponentialRampToValueAtTime(Math.max(.002,Number(v)||.03),start+.012);
      gain.gain.exponentialRampToValueAtTime(.0001,start+duration);
      osc.connect(gain).connect(ctx.destination);
      osc.start(start);
      osc.stop(start+duration+.03);
    }catch(e){
      try{if(osc)osc.disconnect();if(gain)gain.disconnect();}catch(ignore){}
    }
  }
  function playTeenFx(name){
    if(!state.audioUnlocked||!state.prefs.sound)return;
    const base=Number(teenAudioPattern.accent||1046.5);
    const fxMap={
      tap:[[base*.84,.045,'triangle',.026,0],[base*1.18,.055,'sine',.02,38]],
      coinServe:[[523.25,.055,'square',.025,0],[659.25,.06,'triangle',.03,48],[987.77,.075,'sine',.024,105]],
      betStart:[[392,.08,'triangle',.026,0],[523.25,.1,'triangle',.03,72],[783.99,.12,'sine',.026,158]],
      betStop:[[349.23,.08,'sawtooth',.022,0],[261.63,.13,'triangle',.024,88]],
      cardFlip:[[base*.5,.045,'triangle',.02,0],[base*.75,.055,'triangle',.018,44]],
      cardFloat:[[base*.62,.09,'sine',.018,0],[base*.93,.13,'triangle',.021,95]],
      win:[[659.25,.08,'triangle',.026,0],[987.77,.1,'triangle',.03,92],[1318.51,.16,'sine',.026,190]],
      loss:[[220,.12,'sine',.022,0],[174.61,.16,'triangle',.018,110]],
      noBet:[[196,.08,'square',.018,0],[146.83,.12,'sine',.017,80]],
      network:[[164.81,.08,'sawtooth',.018,0],[123.47,.14,'triangle',.016,95]]
    };
    const sequence=fxMap[name]||fxMap.tap;
    const now=performance.now();
    state.lastTeenFxAt=state.lastTeenFxAt||{};
    const minimumGap=name==='cardFlip'?55:(name==='tap'?45:120);
    if(state.lastTeenFxAt[name]&&now-state.lastTeenFxAt[name]<minimumGap)return;
    state.lastTeenFxAt[name]=now;
    sequence.forEach(item=>tone(item[0],item[1],item[2],item[3],item[4]));
  }
  function playCoinSoft(){playTeenFx('tap');}
  function playTeenPhaseFx(phase){
    if(phase==='betting')playTeenFx('betStart');
    else if(phase==='locked'||phase==='stopbet')playTeenFx('betStop');
  }
  function maybeStartTick(){}
  function stopTick(){}
  function voice(text){if(!state.audioUnlocked||!state.prefs.voice||!('speechSynthesis'in window))return;if(speechSynthesis.speaking||speechSynthesis.pending)speechSynthesis.cancel();let u=new SpeechSynthesisUtterance(text);u.rate=1;u.pitch=1;u.volume=.7;speechSynthesis.speak(u);}
  function rememberTeenMediaNode(node){if(node&&(node.tagName==='AUDIO'||node.tagName==='VIDEO'))trackedTeenRoomMedia.add(node);return node;}
  function rememberTeenRoomMedia(){document.querySelectorAll('audio,video').forEach(rememberTeenMediaNode);}
  function wrapTeenAudioContextCtor(key){const OriginalCtor=window[key];if(typeof OriginalCtor!=='function'||OriginalCtor.__teenPattiAudioWrapped)return;const WrappedCtor=new Proxy(OriginalCtor,{construct(target,args,newTarget){const ctx=Reflect.construct(target,args,newTarget);trackedTeenRoomAudioContexts.add(ctx);return ctx;}});Object.defineProperty(WrappedCtor,'__teenPattiAudioWrapped',{value:true,configurable:true});window[key]=WrappedCtor;}
  function installTeenAudioTracking(){if(teenAudioTrackingInstalled)return;teenAudioTrackingInstalled=true;rememberTeenRoomMedia();if(window.Document&&Document.prototype&&!Document.prototype.__teenPattiCreateElementWrapped){const nativeCreateElement=Document.prototype.createElement;Object.defineProperty(Document.prototype,'__teenPattiCreateElementWrapped',{value:true,configurable:true});Document.prototype.createElement=function(tagName,options){const node=nativeCreateElement.call(this,tagName,options);if(typeof tagName==='string'&&/^(audio|video)$/i.test(tagName))rememberTeenMediaNode(node);return node;};}if(window.HTMLMediaElement&&HTMLMediaElement.prototype&&!HTMLMediaElement.prototype.__teenPattiPlayWrapped){const nativePlay=HTMLMediaElement.prototype.play;Object.defineProperty(HTMLMediaElement.prototype,'__teenPattiPlayWrapped',{value:true,configurable:true});HTMLMediaElement.prototype.play=function(...args){rememberTeenMediaNode(this);return nativePlay.apply(this,args);};}wrapTeenAudioContextCtor('AudioContext');wrapTeenAudioContextCtor('webkitAudioContext');}
  function stopTeenAudioHandle(target,permanent,seen){if(!target)return;const valueType=typeof target;if(valueType!=='object'&&valueType!=='function')return;if(seen.has(target))return;seen.add(target);if(target instanceof HTMLMediaElement){rememberTeenMediaNode(target);try{target.pause();}catch(e){}if(permanent){try{target.currentTime=0;}catch(e){}try{target.srcObject=null;}catch(e){}}return;}if(Array.isArray(target)||target instanceof Set){target.forEach(item=>stopTeenAudioHandle(item,permanent,seen));return;}if(target instanceof Map){target.forEach(item=>stopTeenAudioHandle(item,permanent,seen));return;}if(typeof target.pause==='function'){try{target.pause();}catch(e){}}if(typeof target.stop==='function'){try{target.stop();}catch(e){}}if(typeof target.suspend==='function'){try{target.suspend();}catch(e){}}if(typeof target.disconnect==='function'){try{target.disconnect();}catch(e){}}if(permanent&&typeof target.close==='function'){try{target.close();}catch(e){}}}
  function silenceTeenRoomAudio(permanent){const seen=new WeakSet();rememberTeenRoomMedia();trackedTeenRoomMedia.forEach(media=>stopTeenAudioHandle(media,permanent,seen));trackedTeenRoomAudioContexts.forEach(ctx=>stopTeenAudioHandle(ctx,permanent,seen));stopAmbient();if('speechSynthesis'in window){try{window.speechSynthesis.cancel();}catch(e){}}[state.musicEngine,state.musicMaster,window.Howler,window.musicEngine,window.audioCtx,window.musicCtx,window.backgroundMusic,window.roomMusic,window.roomAudio].forEach(target=>stopTeenAudioHandle(target,permanent,seen));if(window.Howler&&typeof window.Howler.stop==='function'){try{window.Howler.stop();}catch(e){}}if(permanent){state.musicEngine=null;state.musicMaster=null;trackedTeenRoomAudioContexts.clear();}}
  window.silenceTeenRoomAudio = silenceTeenRoomAudio;
  function unlockAudio(){if(state.audioUnlocked)return;state.audioUnlocked=true;ensureTeenAudioEngine();if(state.musicEngine&&state.musicEngine.state==='suspended')state.musicEngine.resume().catch(e=>{});syncTeenMusicForPhase();}
  function isTeenRoomActive(){
    return state.isGameActive!==false&&(hasLiveSession||useStandalonePreview||!!(window.BDGameFinal&&window.BD_GAME_BOOTSTRAP&&window.BD_GAME_BOOTSTRAP.gameCode===currentGameCode));
  }
  function shouldPlayTeenMusic(phase=state.phase){
    const normalizedPhase=String(phase||state.phase||'');
    return normalizedPhase==='betting'
      && state.audioUnlocked
      && state.prefs.music
      && !!state.musicEngine
      && isTeenRoomActive()
      && !state.offline
      && state.networkQuality!=='bad'
      && !document.hidden
      && (typeof navigator.onLine!=='boolean'||navigator.onLine);
  }
  function startAmbient(phase=state.phase){
    if(phase)state.phase=phase;
    if(!state.audioUnlocked||!state.prefs.music)return;
    const ctx=ensureTeenAudioEngine();
    if(!ctx)return;
    if(ctx.state==='suspended')ctx.resume().catch(e=>{});
    if(!shouldPlayTeenMusic(phase)){stopAmbient();return;}
    if(state.musicLoopStarted)return;
    state.musicLoopStarted=true;
    const master=ctx.createGain();
    master.gain.value=Number(teenAudioPattern.gain||.016);
    master.connect(ctx.destination);
    state.musicMaster=master;
    let nt=ctx.currentTime+.05;
    const notes=teenAudioPattern.notes||teenAudioPatterns.teen_patti.notes;
    const bass=teenAudioPattern.bass||teenAudioPatterns.teen_patti.bass;
    const step=Math.max(.24,Number(teenAudioPattern.stepMs||360)/1000);
    function scheduleMusicNote(freq,type,start,duration,volume){
      let osc;
      let gain;
      try{
        osc=ctx.createOscillator();
        gain=ctx.createGain();
        osc.type=type;
        osc.frequency.setValueAtTime(freq,start);
        gain.gain.setValueAtTime(.0001,start);
        gain.gain.exponentialRampToValueAtTime(volume,start+.035);
        gain.gain.exponentialRampToValueAtTime(.0001,start+duration);
        osc.connect(gain).connect(master);
        osc.start(start);
        osc.stop(start+duration+.04);
      }catch(e){
        try{if(osc)osc.disconnect();if(gain)gain.disconnect();}catch(ignore){}
      }
    }
    function loop(){
      if(!shouldPlayTeenMusic()){stopAmbient();return;}
      const wave=teenAudioPattern.wave||'triangle';
      const maxNotes=document.body.classList.contains('low-end-mode')?Math.min(6,notes.length):notes.length;
      for(let i=0;i<maxNotes;i++){
        const start=nt+(i*step);
        scheduleMusicNote(notes[i%notes.length],wave,start,Math.min(step*.88,.34),.018);
        if(i%2===0)scheduleMusicNote(bass[(i/2)%bass.length],i%4===0?'sine':'triangle',start+.02,Math.min(step*1.7,.64),.01);
      }
      nt+=maxNotes*step;
      state.ambientTimer=setTimeout(loop,Math.max(900,Math.round(maxNotes*step*1000)-180));
    }
    loop();
  }
  function stopAmbient(){document.documentElement.dataset.teenAudioMusicState='stopped';state.musicLoopStarted=false;if(state.ambientTimer)clearTimeout(state.ambientTimer);state.ambientTimer=null;if(state.musicMaster)try{state.musicMaster.disconnect();}catch(e){}state.musicMaster=null;}
  function syncTeenMusicForPhase(phase=state.phase){
    if(phase)state.phase=phase;
    if(shouldPlayTeenMusic(phase)){
      document.documentElement.dataset.teenAudioMusicState='playing';
      startAmbient(phase);
    }else{
      document.documentElement.dataset.teenAudioMusicState='stopped';
      stopAmbient();
    }
  }
  function setTeenPattiAudioNetworkStatus(status){
    if(status){
      state.networkQuality=status;
      state.offline=status==='bad';
      document.documentElement.dataset.teenAudioNetwork=status;
    }
    if(status==='bad')stopAmbient();
    else syncTeenMusicForPhase();
  }
  window.playTeenPattiFx=playTeenFx;
  window.playTeenPattiPhaseFx=playTeenPhaseFx;
  window.syncTeenPattiRoomMusic=syncTeenMusicForPhase;
  window.stopTeenPattiRoomMusic=stopAmbient;
  window.setTeenPattiAudioNetworkStatus=setTeenPattiAudioNetworkStatus;
  window.unlockTeenPattiAudio=unlockAudio;
  function applyAudioPrefsUI(){els.audioToggles.forEach(t=>{let on=state.prefs[t.dataset.audio];t.classList.toggle('on',on);t.setAttribute('aria-pressed',on?'true':'false');});}
  function loadPrefs(){try{let p=JSON.parse(localStorage.getItem(currentPrefsStorageKey)||'{}');return{music:p.music!==!1,sound:p.sound!==!1,voice:p.voice!==!1};}catch(e){return{music:!0,sound:!0,voice:!0};}}
  function savePrefs(){localStorage.setItem(currentPrefsStorageKey,JSON.stringify(state.prefs));}
  function resizeCanvas(){if(!els.fx||!ctx2d)return;els.fx.width=innerWidth*devicePixelRatio;els.fx.height=innerHeight*devicePixelRatio;els.fx.style.width=innerWidth+'px';els.fx.style.height=innerHeight+'px';ctx2d.setTransform(devicePixelRatio,0,0,devicePixelRatio,0,0);}
  

  function handleViewportRefresh(){
    applyDeviceProfile();
    const vw = window.innerWidth || document.documentElement.clientWidth || 390;
    const vh = window.innerHeight || document.documentElement.clientHeight || 700;
    const root = document.documentElement;
    root.style.setProperty('--app-vh', vh + 'px');
    root.style.setProperty('--card-w', (vh <= 560 ? (vw <= 375 ? 44 : 46) : vw <= 375 ? 46 : vw <= 430 ? 51 : 58) + 'px');
    root.style.setProperty('--card-h', (vh <= 560 ? (vw <= 375 ? 72 : 75) : vw <= 375 ? 77 : vw <= 430 ? 84 : 92) + 'px');
    resizeCanvas();
    positionFloatingUI();
  }

  function requestHistoryRefresh(force){
    if(typeof window.refreshHistoryTables === 'function'){
      window.refreshHistoryTables(!!force);
    }
  }

  function bindTeenAudioControls(){
    if(!window.__teenPattiAudioUnlockBound){
      window.__teenPattiAudioUnlockBound=true;
      document.addEventListener('pointerdown',unlockAudio,{once:!1,passive:!0});
    }
    els.audioToggles.forEach(t=>{
      if(t.__teenPattiAudioToggleBound)return;
      t.__teenPattiAudioToggleBound=true;
      t.addEventListener('click',(event)=>{
        event.preventDefault();
        let type=t.dataset.audio;
        if(!type)return;
        state.prefs[type]=!state.prefs[type];
        savePrefs();
        applyAudioPrefsUI();
        if(type==='music'){
          if(state.prefs.music)syncTeenMusicForPhase();
          else stopAmbient();
        }
        playCoinSoft();
      });
    });
  }

  function bindUI(){
    els.chips.forEach(c=>c.addEventListener('click',e=>{e.stopPropagation();if(!c.classList.contains('live'))return;selectChip(Number(c.dataset.value));flashBanner(`CHIP ${number(Number(c.dataset.value))}`);playCoinSoft();haptic();if(shouldAnimate())gsap.fromTo(c,{y:4,scale:.94},{y:-4,scale:1.06,duration:.22});}));
    Object.entries(els.boards).forEach(([k,el])=>{if(el)el.addEventListener('click',()=>{
      const bettingOpen = state.bettingEnabled && state.phase==='betting';
      if(!bettingOpen){
        if(state.phase==='stopbet' || state.phase==='reveal' || state.phase==='winner'){
          showNotice('STOP BET · WAIT FOR NEXT BID','warn',1400);
        }
        return;
      }
      triggerBoardMagic(k);placeBet(k);haptic();
    });});
    els.btnSettings?.addEventListener('click',()=>{showAudioPopup();pressIcon(els.btnSettings);});
    els.btnUsers?.addEventListener('click',()=>{requestHistoryRefresh(true);showUtilityModal('users');pressIcon(els.btnUsers);});
    els.btnHistory?.addEventListener('click',()=>{requestHistoryRefresh(true);showUtilityModal('history');pressIcon(els.btnHistory);});
    els.btnRecent?.addEventListener('click',()=>{requestHistoryRefresh(true);showUtilityModal('recent');pressIcon(els.btnRecent);});
    document.getElementById('closeAudioPopup')?.addEventListener('click',()=>{hideAudioPopup();});
    els.audioPopupOverlay?.addEventListener('click',()=>{hideAudioPopup();});
    document.querySelectorAll('.close-modal-btn').forEach(btn=>{btn.addEventListener('click',(e)=>{e.stopPropagation();let m=btn.closest('.modal');if(m)closeModal(m);});});
    Object.values(els.modals).forEach(m=>{if(m){m.addEventListener('click',(e)=>{if(e.target===m)closeModal(m);});}});
    bindTeenAudioControls();
    els.noticeBlocker?.addEventListener('pointerdown',(e)=>{e.preventDefault();e.stopPropagation();},{passive:false});
    els.noticeBlocker?.addEventListener('click',(e)=>{e.preventDefault();e.stopPropagation();},{passive:false});
  }
  
  state.prefs=loadPrefs();
  applyAudioPrefsUI();
  bindTeenAudioControls();
  handleViewportRefresh();
  window.addEventListener('resize',handleViewportRefresh,{passive:true});
  window.addEventListener('orientationchange',()=>setTimeout(handleViewportRefresh,120),{passive:true});
  const legacyPreviewRuntimeAllowed = !hasLiveSession;
  if(legacyPreviewRuntimeAllowed){
    bindUI();
    safeBoot();
    animateParticles();
  }
})();
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
  userName: @json($displayUserName ?? 'Player'),
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
<script async src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script src="{{ asset('game_final_assets/game_final_bridge.js') }}"></script>
<script>
(function(){
  const currentGameCode = @json($currentGameCode);
  const teenPattiFx = @json($variantFx);
  if(!window.BDGameFinal || !window.BD_GAME_BOOTSTRAP || window.BD_GAME_BOOTSTRAP.gameCode !== currentGameCode) return;

  const api = window.BDGameFinal;
  const boardKeys = ['A','B','C'];
  const boardDisplayNames = @json($seatTitles);
  const boardPayoutMultipliers = @json($boardPayoutMultipliers);
  const teenTrendChairAssets = window.TEEN_PATTI_TREND_CHAIRS || @json($seatChairAssetUrls);
  window.TEEN_PATTI_TREND_CHAIRS = teenTrendChairAssets;
  const boards = {
    A: document.getElementById('boardA'),
    B: document.getElementById('boardB'),
    C: document.getElementById('boardC')
  };
  const totals = {
    A: document.getElementById('totalA'),
    B: document.getElementById('totalB'),
    C: document.getElementById('totalC')
  };
  const wins = {
    A: document.getElementById('wonA'),
    B: document.getElementById('wonB'),
    C: document.getElementById('wonC')
  };
  const potWrappers = {
    A: document.querySelector('.pot[data-board="A"]'),
    B: document.querySelector('.pot[data-board="B"]'),
    C: document.querySelector('.pot[data-board="C"]')
  };
  const stacks = {
    A: document.getElementById('stackA'),
    B: document.getElementById('stackB'),
    C: document.getElementById('stackC')
  };
  const balanceText = document.getElementById('balanceText');
  const balanceSection = document.getElementById('balanceSection');
  const roundCount = document.getElementById('roundCount');
  const netStat = document.getElementById('netStat');
  const netPill = document.getElementById('netPill');
  const timerValue = document.getElementById('timerValue');
  const timerSub = document.getElementById('timerSub');
  const timerOrb = document.getElementById('timerOrb');
  const timerHand = document.getElementById('timerHand');
  const gameContainer = document.getElementById('gameContainer');
  const loadingSkeleton = document.getElementById('loadingSkeleton');
  const timerWrap = document.querySelector('.timer-wrap');
  const phaseBanner = document.getElementById('phaseBanner');
  const toast = document.getElementById('toastNotification');
  const floatingBanner = document.getElementById('floatingBanner');
  const messageBanner = document.getElementById('messageBanner');
  const megaCelebration = document.getElementById('megaCelebration');
  const megaText = document.getElementById('megaText');
  const chipsBar = document.getElementById('chipsBar');
  const chipNodes = Array.from(document.querySelectorAll('.chip'));
  const modalStart = document.getElementById('modalStart');
  const modalStop = document.getElementById('modalStop');
  const modalWin = document.getElementById('modalWin');
  const modalLoss = document.getElementById('modalLoss');
  const modalNoBid = document.getElementById('modalNoBid');
  const modalUsers = document.getElementById('modalUsers');
  const modalHistory = document.getElementById('modalHistory');
  const modalRecent = document.getElementById('modalRecent');
  const modalUsersList = document.getElementById('modalUsersList');
  const modalHistoryList = document.getElementById('modalHistoryList');
  const modalRecentList = document.getElementById('modalRecentList');
  const btnUsers = document.getElementById('btnUsers');
  const btnHistory = document.getElementById('btnHistory');
  const btnRecent = document.getElementById('btnRecent');
  const winText = document.getElementById('winText');
  @php
    $teenTimingConfig = (array) config('bd_game_final.games.' . $currentGameCode, []);
    $teenStartPopupMs = (float) ($teenTimingConfig['start_bet_popup_sec'] ?? 3) * 1000;
    $teenStopPopupMs = (float) ($teenTimingConfig['stop_bet_popup_sec'] ?? 3) * 1000;
    $teenWinnerPopupMs = (float) ($teenTimingConfig['winner_popup_sec'] ?? 1) * 1000;
    $teenPayoutMs = (float) ($teenTimingConfig['settle_duration_sec'] ?? 2.5) * 1000;
    $teenBettingMs = (float) ($teenTimingConfig['bet_duration_sec'] ?? 20) * 1000;
    $teenLockedMs = (float) ($teenTimingConfig['stop_duration_sec'] ?? 4.5) * 1000;
    $teenRevealedMs = (
      (float) ($teenTimingConfig['reveal_duration_sec'] ?? 6) +
      (float) ($teenTimingConfig['reveal_wait_sec'] ?? 2) +
      (float) ($teenTimingConfig['winner_popup_sec'] ?? 1) +
      (float) ($teenTimingConfig['winner_wait_sec'] ?? 0.5)
    ) * 1000;
    $teenSettledMs = (
      (float) ($teenTimingConfig['settle_duration_sec'] ?? 2.5) +
      (float) ($teenTimingConfig['settle_wait_sec'] ?? 1)
    ) * 1000;
  @endphp
  const TEEN_SEQUENCE = Object.freeze({
    startPopupMs: @json($teenStartPopupMs),
    stopPopupMs: @json($teenStopPopupMs),
    stopToRevealDelayMs: 0,
    revealFlipMs: 4200,
    boardRevealMs: 1100,
    boardHoldMs: 300,
    handLabelMs: 200,
    preWinEffectHoldMs: 1200,
    winEffectMs: 2000,
    cardDanceExtraMs: 1000,
    winnerBannerMs: 700,
    postWinnerBannerHoldMs: 1500,
    revealHoldMs: 0,
    resultPopupMs: @json($teenWinnerPopupMs),
    payoutLeadMs: 0,
    payoutMs: @json($teenPayoutMs),
    roundGapMs: 0,
  });
  const TEEN_PHASE_MS = Object.freeze({
    betting: @json($teenBettingMs),
    locked: @json($teenLockedMs),
    revealed: @json($teenRevealedMs),
    settled: @json($teenSettledMs),
  });
  let authoritativeRoundNo = null;
  let lastResultKey = '';
  let lastRenderedHandsKey = '';
  let activeAuthoritativeRevealKey = '';
  let stagedRevealCompleteKey = '';
  let stagedRevealCompleteAtMs = 0;
  let lastPreviewRevealKey = '';
  let lastPopupKey = '';
  let lastStartPopupKey = '';
  let lastStopPopupKey = '';
  let lastStopPopupShownAtMs = 0;
  let lastRevealStageKey = '';
  let lastSettlementStageKey = '';
  let lastAnimatedPayoutKey = '';
  let activePayoutAnimationKey = '';
  let previewFlipQueue = Promise.resolve();
  let previewFlipScopeKey = '';
  let lastStatePayload = null;
  let lastStateReceivedAt = 0;
  let lastPhaseKey = '';
  let lastMissingResultKey = '';
  let serverClockOffsetSec = 0;
  let serverClockKey = '';
  let lastServerSyncStamp = '';
  let lastNetworkMs = 0;
  let pollTimer = null;
  let heartbeatTimer = null;
  let mirrorTimer = null;
  let timerRafId = null;
  let phaseModalTimer = null;
  let phaseBannerHideTimer = null;
  let revealStageTimer = null;
  let faceupCardZCounter = 10;
  let settlementStageTimer = null;
  let resultPopupTimer = null;
  let resultPopupShownAtMs = 0;
  let bridgeToastTimer = null;
  let megaCelebrationTimer = null;
  let refreshInFlight = false;
  let reconnectPending = false;
  let disposed = false;
  let requestCounter = 0;
  let displayedBalanceValue = null;
  let lastTimerChromePhase = '';
  let lastTimerDisplayKey = '';
  let authoritativeLoaded = false;
  const realtimeFallbackMs = Math.max(1500, Number((window.BD_GAME_BOOTSTRAP.realtime && window.BD_GAME_BOOTSTRAP.realtime.pollFallbackMs) || 1500));
  const controllerWatchdogMs = Math.max(3000, realtimeFallbackMs * 2);

  function markAuthoritativeLoaded(){
    if(authoritativeLoaded) return;
    authoritativeLoaded = true;
    if(loadingSkeleton){
      loadingSkeleton.style.opacity = '0';
      loadingSkeleton.style.visibility = 'hidden';
    }
    if(gameContainer) gameContainer.classList.add('loaded');
  }
  let lastWinnerCelebrationKey = '';
  let historySyncInFlight = false;
  let boardHistoryRows = [];
  let userHistoryRows = [];
  let activePlayerRows = [];
  let lastHistorySyncRound = '';
  let activeRevealPipelineKey = '';
  let activeRevealPipeline = null;
  let lastWinnerCelebrationStartedAtMs = 0;
  const pendingBoards = new Map();
  function markPendingBoard(boardKey, delta){
    const nextCount = Math.max(0, (pendingBoards.get(boardKey) || 0) + delta);
    if(nextCount > 0) pendingBoards.set(boardKey, nextCount);
    else pendingBoards.delete(boardKey);
  }
  const roomBoardCount = Math.max(1, Number(window.BD_GAME_BOOTSTRAP.rules && window.BD_GAME_BOOTSTRAP.rules.boardCount || boardKeys.length || 1));

  function boardDisplayName(boardKey){
    return boardDisplayNames[boardKey] || boardKey;
  }

  function maxDistinctBoards(payload){
    const fromPayload = Number(payload && payload.rules && payload.rules.max_distinct_boards_per_user || 0);
    const fromBootstrap = Number(window.BD_GAME_BOOTSTRAP.rules && window.BD_GAME_BOOTSTRAP.rules.maxDistinctBoards || 0);
    return Math.max(1, Math.min(roomBoardCount, fromPayload || fromBootstrap || roomBoardCount));
  }

  function currentDistinctBoardCount(payload){
    return boardKeys.filter((key) => Number(payload && payload.my_bet_totals && payload.my_bet_totals[key] || 0) > 0).length;
  }

  function canUseBoard(payload, boardKey){
    const currentTotal = Number(payload && payload.my_bet_totals && payload.my_bet_totals[boardKey] || 0);
    return currentTotal > 0 || currentDistinctBoardCount(payload) < maxDistinctBoards(payload);
  }

  function payloadBalanceValue(payload){
    const raw = payload && payload.balance !== undefined ? payload.balance : 0;
    const value = typeof raw === 'string' ? Number(raw.replace(/,/g, '')) : Number(raw || 0);
    return Number.isFinite(value) ? value : 0;
  }

  function hasBalanceForBet(payload, amount){
    const betAmount = Math.max(0, Number(amount || 0));
    return payloadBalanceValue(payload) >= betAmount && betAmount > 0;
  }

  function insufficientBalanceMessage(payload, amount){
    const balance = payloadBalanceValue(payload);
    if(balance > 0) return `Insufficient balance. Need ${number(amount)}.`;
    return 'Insufficient balance.';
  }

  function optimisticBetPayload(payload, boardKey, amount, balanceValue = null){
    if(!payload || !boardKey || !Number.isFinite(Number(amount))) return null;
    const next = Object.assign({}, payload);
    next.board_totals = Object.assign({}, payload.board_totals || {});
    next.my_bet_totals = Object.assign({}, payload.my_bet_totals || {});
    const betAmount = Number(amount || 0);
    next.board_totals[boardKey] = Number(next.board_totals[boardKey] || 0) + betAmount;
    next.my_bet_totals[boardKey] = Number(next.my_bet_totals[boardKey] || 0) + betAmount;
    next.my_total_bet_amount = Number(payload.my_total_bet_amount || 0) + betAmount;
    next.balance = balanceValue === null ? Math.max(0, Number(payload.balance || 0) - betAmount) : Number(balanceValue || 0);
    return next;
  }

  function boardLimitMessage(payload){
    const limit = maxDistinctBoards(payload);
    return `This room allows ${limit} distinct ${limit === 1 ? 'board' : 'boards'} per round.`;
  }

  function serverNow(){
    return (Date.now() / 1000) + serverClockOffsetSec;
  }

  function teenTimings(payload){
    const durations = payload && payload.phase_durations ? payload.phase_durations : {};
    return {
      startPopupMs: Math.max(0, Math.round(Number(durations.start_popup || (TEEN_SEQUENCE.startPopupMs / 1000)) * 1000)),
      stopPopupMs: Math.max(0, Math.round(Number(durations.stop_popup || (TEEN_SEQUENCE.stopPopupMs / 1000)) * 1000)),
      revealMainMs: Math.max(0, Math.round(Number(durations.reveal_main || 6) * 1000)),
      revealWaitMs: Math.max(0, Math.round(Number(durations.reveal_wait || 2) * 1000)),
      winnerPopupMs: Math.max(0, Math.round(Number(durations.winner_popup || 1) * 1000)),
      winnerWaitMs: Math.max(0, Math.round(Number(durations.winner_wait || 0.5) * 1000)),
      payoutMs: Math.max(0, Math.round(Number(durations.payout || (TEEN_SEQUENCE.payoutMs / 1000)) * 1000)),
      settleWaitMs: Math.max(0, Math.round(Number(durations.settle_wait || 1) * 1000)),
    };
  }

  function markerAt(payload, key){
    const value = Number(payload && payload[key] || 0);
    return Number.isFinite(value) && value > 0 ? value : null;
  }

  function revealDoneAt(payload){
    const direct = markerAt(payload, 'reveal_done_at');
    if(direct) return direct;
    const start = markerAt(payload, 'reveal_at');
    return start ? start + (teenTimings(payload).revealMainMs / 1000) : null;
  }

  function winnerPopupAt(payload){
    const direct = markerAt(payload, 'winner_popup_at');
    if(direct) return direct;
    const revealDone = revealDoneAt(payload);
    return revealDone ? revealDone + (teenTimings(payload).revealWaitMs / 1000) : null;
  }

  function bettingOpensAt(payload){
    return markerAt(payload, 'bet_countdown_start_at');
  }

  function isBettingOpen(payload){
    if(!payload || payload.phase !== 'betting') return false;
    const opensAt = bettingOpensAt(payload);
    const closesAt = markerAt(payload, 'bet_close_at');
    const now = serverNow();
    if(opensAt && now < opensAt) return false;
    if(closesAt && now >= closesAt) return false;
    return true;
  }

  async function waitForServerMarker(payload, resolveAt, pipelineKey = ''){
    const targetAt = typeof resolveAt === 'function' ? resolveAt(payload) : markerAt(payload, resolveAt);
    if(!targetAt) return;
    let remainingMs = Math.max(0, Math.round((targetAt - serverNow()) * 1000));
    while(remainingMs > 20){
      if(pipelineKey && activeRevealPipelineKey !== pipelineKey) return;
      await waitMs(Math.min(remainingMs, 140));
      remainingMs = Math.max(0, Math.round((targetAt - serverNow()) * 1000));
    }
  }

  function phaseStartedAt(payload, phase){
    if(!payload) return null;
    if(phase === 'betting') return payload.bet_countdown_start_at || payload.start_at || null;
    if(phase === 'locked') return payload.bet_close_at || null;
    if(phase === 'revealed') return payload.reveal_at || null;
    if(phase === 'settled') return payload.settle_at || null;
    return null;
  }

  function phaseElapsedMs(payload, phase){
    const startedAt = phaseStartedAt(payload, phase);
    if(!startedAt) return 0;
    return Math.max(0, Math.round((serverNow() - startedAt) * 1000));
  }

  function waitMs(durationMs){
    return new Promise((resolve) => window.setTimeout(resolve, Math.max(0, Number(durationMs) || 0)));
  }

  async function holdMinimumDuration(startedAt, durationMs){
    const elapsed = performance.now() - startedAt;
    const remaining = Math.max(0, Number(durationMs || 0) - elapsed);
    if(remaining > 0) await waitMs(remaining);
  }

  function getTimerNodes(){
    return {
      wrap: timerWrap || document.getElementById('timerWrap') || document.querySelector('.timer-wrap'),
      value: timerValue || document.getElementById('timerValue'),
      sub: timerSub || document.getElementById('timerSub'),
      orb: timerOrb || document.getElementById('timerOrb'),
      hand: timerHand || document.getElementById('timerHand'),
    };
  }

  function setTimerVisual(progress, color){
    const timerNodes = getTimerNodes();
    const clamped = Math.max(0, Math.min(1, Number.isFinite(progress) ? progress : 0));
    const resolvedColor = color || 'var(--teen-timer-ring)';
    if(timerNodes.orb){
      timerNodes.orb.style.setProperty('--p', clamped.toFixed(4));
      timerNodes.orb.style.setProperty('--timer-angle', `${(-90 + ((1 - clamped) * 360)).toFixed(2)}deg`);
      timerNodes.orb.style.setProperty('--timer-color', resolvedColor);
    }
    if(timerNodes.hand){
      timerNodes.hand.style.background = `linear-gradient(180deg, rgba(255,255,255,.98), ${resolvedColor})`;
      timerNodes.hand.style.boxShadow = `0 0 16px ${resolvedColor}`;
    }
  }

  function timerPhaseState(payload){
    if(!payload) return null;
    const phase = payload.phase || 'betting';
    const startAt = phaseStartedAt(payload, phase);
    const endAt = phase === 'betting'
      ? Number(payload.bet_close_at || 0)
      : phase === 'locked'
        ? Number(payload.reveal_at || 0)
        : phase === 'revealed'
          ? Number(payload.settle_at || 0)
          : Number(payload.next_round_at || 0);
    const configuredPhaseMs = Math.max(250, Number(TEEN_PHASE_MS[phase] || 0));
    let totalMs = startAt && endAt
      ? Math.max(250, Math.round((endAt - startAt) * 1000))
      : configuredPhaseMs;
    if(phase === 'betting' && configuredPhaseMs > 0) {
      totalMs = Math.min(totalMs, configuredPhaseMs);
    }
    const nowSec = serverNow();
    const waitingForCountdown = phase === 'betting' && !!startAt && nowSec < startAt;
    let remainingMs = waitingForCountdown
      ? 0
      : (endAt ? Math.max(0, Math.round((endAt - nowSec) * 1000)) : 0);
    if(phase === 'betting' && !waitingForCountdown && totalMs > 0) {
      remainingMs = Math.min(remainingMs, totalMs);
    }
    const progress = totalMs > 0 ? remainingMs / totalMs : 0;
    let color = 'var(--teen-timer-ring)';
    if(phase === 'betting') {
      color = remainingMs > (totalMs * 0.5)
        ? 'var(--teen-timer-ring)'
        : remainingMs > (totalMs * 0.25)
          ? '#ffd76e'
          : '#ff6f7f';
    } else if(phase === 'locked') {
      color = '#ff8b5e';
    } else if(phase === 'revealed') {
      color = '#6eb9ff';
    } else if(phase === 'settled') {
      color = '#ffd76e';
    }
    let text = 'GO';
    if(remainingMs > 0) {
      const displaySeconds = Math.max(1, Math.ceil(remainingMs / 1000));
      const maxDisplaySeconds = totalMs > 0 ? Math.max(1, Math.ceil(totalMs / 1000)) : displaySeconds;
      text = String(phase === 'betting' && !waitingForCountdown ? Math.min(displaySeconds, maxDisplaySeconds) : displaySeconds);
    } else if(phase === 'betting') {
      text = 'STOP';
    } else if(phase === 'locked') {
      text = 'FLIP';
    } else if(phase === 'revealed' || phase === 'settled') {
      text = 'END';
    }
    const sub = phase === 'betting'
      ? (remainingMs > 0 ? 'BET' : 'WAIT')
      : phase === 'locked'
        ? 'FLIP'
        : phase === 'revealed'
          ? 'RESULT'
          : phase === 'settled'
            ? 'PAYOUT'
            : 'READY';
    return {
      phase,
      totalMs,
      remainingMs,
      progress: Math.max(0, Math.min(1, progress)),
      color,
      text,
      sub,
      waitingForCountdown,
    };
  }

  function bettingWindowRemainingMs(payload){
    if(!payload || payload.phase !== 'betting') return 0;
    const timing = timerPhaseState(payload);
    return timing ? Number(timing.remainingMs || 0) : 0;
  }

  function stateNeedsBetRefresh(payload){
    if(!payload || payload.phase !== 'betting') return true;
    const ageMs = Date.now() - lastStateReceivedAt;
    const remainingMs = bettingWindowRemainingMs(payload);
    if(remainingMs <= 0) return true;
    return ageMs > 4500 && remainingMs > 1800;
  }

  async function getFreshBetState(){
    refreshInFlight = true;
    const startedAt = performance.now();
    try {
      const payload = await api.get(window.BD_GAME_BOOTSTRAP.endpoints.state, {});
      lastNetworkMs = Math.max(1, Math.round(performance.now() - startedAt));
      setNetwork(lastNetworkMs < 400 ? 'good' : 'warn', `${lastNetworkMs}ms`);
      if(payload && payload.st && shouldApplyPayload(payload)){
        applyState(payload);
        return payload;
      }
      return payload || null;
    } catch (error) {
      setNetwork('bad', lastNetworkMs ? `${lastNetworkMs}ms` : '--');
      return null;
    } finally {
      refreshInFlight = false;
    }
  }

  function isPassiveAuthoritativeModal(modal){
    return !!(modal && (
      modal.classList.contains('start-pop')
      || modal.classList.contains('stop-pop')
      || modal.classList.contains('winner-pop')
      || modal.classList.contains('loss-pop')
      || modal.classList.contains('loser-pop')
      || modal.id === 'modalNoBid'
    ));
  }

  function hidePhaseModals(){
    [modalStart, modalStop].forEach((modal) => {
      if(!modal) return;
      modal.classList.remove('show');
      modal.style.removeProperty('opacity');
      modal.style.removeProperty('visibility');
      modal.style.removeProperty('pointer-events');
      const card = modal.querySelector('.modal-card');
      if(card) card.style.removeProperty('pointer-events');
    });
    if(phaseModalTimer){
      window.clearTimeout(phaseModalTimer);
      phaseModalTimer = null;
    }
  }

  function showPhaseModal(modal, durationMs){
    if(!modal) return;
    hidePhaseModals();
    modal.classList.add('show');
    modal.style.setProperty('opacity','1','important');
    modal.style.setProperty('visibility','visible','important');
    modal.style.setProperty('pointer-events',isPassiveAuthoritativeModal(modal) ? 'none' : 'auto','important');
    const card = modal.querySelector('.modal-card');
    if(card && isPassiveAuthoritativeModal(modal)) card.style.setProperty('pointer-events','none','important');
    phaseModalTimer = window.setTimeout(function(){
      modal.classList.remove('show');
      modal.style.removeProperty('opacity');
      modal.style.removeProperty('visibility');
      modal.style.removeProperty('pointer-events');
      if(card) card.style.removeProperty('pointer-events');
      phaseModalTimer = null;
    }, durationMs);
  }

  function clearRevealStageTimer(){
    if(revealStageTimer){
      window.clearTimeout(revealStageTimer);
      revealStageTimer = null;
    }
  }

  function clearSettlementStageTimer(){
    if(settlementStageTimer){
      window.clearTimeout(settlementStageTimer);
      settlementStageTimer = null;
    }
  }

  function winnerEffectsReady(payload){
    if(!payload) return false;
    const winner = payload.winner_board || (payload.result && payload.result.winner_board) || 'na';
    const resultKey = `${payload.round_no}:${winner}`;
    return lastResultKey === resultKey
      && resultPopupShown(payload);
  }

  function winnerVisualsStarted(payload){
    if(!payload) return false;
    const winner = payload.winner_board || (payload.result && payload.result.winner_board) || 'na';
    return lastResultKey === `${payload.round_no}:${winner}`;
  }

  function resultPopupKey(payload){
    const winner = payload && (payload.winner_board || (payload.result && payload.result.winner_board));
    if(!payload || !winner) return '';
    return `${payload.round_no || 'na'}:${winner}`;
  }

  function resultPopupShown(payload){
    const key = resultPopupKey(payload);
    return !!key && lastPopupKey === key;
  }

  function roundOrderValue(roundNo){
    const match = String(roundNo || '').match(/(\d+)$/);
    return match ? Number(match[1]) : 0;
  }

  function phaseOrderValue(phase){
    if(phase === 'betting') return 1;
    if(phase === 'locked') return 2;
    if(phase === 'revealed') return 3;
    if(phase === 'settled') return 4;
    return 0;
  }

  function shouldApplyPayload(payload){
    if(!payload || !payload.round_no) return true;
    if(!authoritativeRoundNo) return true;
    const incomingRound = roundOrderValue(payload.round_no);
    const currentRound = roundOrderValue(authoritativeRoundNo);
    if(incomingRound < currentRound) return false;
    if(incomingRound > currentRound) return true;
    return phaseOrderValue(payload.phase) >= phaseOrderValue(lastStatePayload && lastStatePayload.phase);
  }

  function warnMissingResult(payload, source){
    if(!payload || !(payload.phase === 'locked' || payload.phase === 'revealed' || payload.phase === 'settled')) return;
    const key = `${payload.round_no || 'na'}:${payload.phase || 'na'}:${source}`;
    if(lastMissingResultKey === key) return;
    lastMissingResultKey = key;
    console.warn('Teen Patti result payload missing cards for active reveal state.', {
      round_no: payload.round_no || null,
      phase: payload.phase || null,
      source: source
    });
  }

  function number(n){
    return Number(n || 0).toLocaleString('en-US');
  }

  function balanceNumber(n){
    return String(Math.max(0, Math.floor(Number(n) || 0)));
  }

  function activeChipValue(){
    const chip = document.querySelector('.chip.selected') || document.querySelector('.chip[data-value="1000"]') || document.querySelector('.chip[data-value]');
    return Number(chip && chip.dataset ? chip.dataset.value : 1000) || 1000;
  }

  function setActiveChip(chip){
    if(!chip || !chip.dataset) return;
    chipNodes.forEach((node) => {
      const active = node === chip;
      node.classList.toggle('selected', active);
      node.classList.toggle('focus-chip', active && node.classList.contains('live'));
      node.setAttribute('aria-pressed', active ? 'true' : 'false');
    });
  }

  function ensureActiveChip(){
    const selected = chipNodes.find((node) => node.classList.contains('selected'));
    setActiveChip(selected || chipNodes.find((node) => Number(node.dataset && node.dataset.value) === 1000) || chipNodes[0]);
  }

  function setNetwork(status, text){
    if(netStat && netStat.textContent !== text) netStat.textContent = text;
    if(netPill){
      if(netPill.classList.contains(status) && (!netStat || netStat.textContent === text)) return;
      netPill.classList.remove('good','warn','bad');
      netPill.classList.add(status);
    }
    if(typeof window.setTeenPattiAudioNetworkStatus === 'function') window.setTeenPattiAudioNetworkStatus(status);
  }

  function classifyHandLabelOverlay(label){
    const key = String(label || '').trim().toUpperCase();
    if(key.includes('PAIR')) return 'badge-pair';
    if(key.includes('SEQUENCE') || key.includes('SEQ')) return 'badge-sequence';
    if(key.includes('FLUSH') || key.includes('COLOR')) return 'badge-flush';
    if(key.includes('TRAIL') || key.includes('PURE')) return 'badge-trail';
    return '';
  }

  function normalizeSuitSymbol(rawSuit){
    const suit = String(rawSuit || '').trim().toUpperCase();
    if(suit === 'H' || suit === 'HEART' || suit === 'HEARTS' || suit === '♥') return { symbol: '♥', red: true };
    if(suit === 'D' || suit === 'DIAMOND' || suit === 'DIAMONDS' || suit === '♦') return { symbol: '♦', red: true };
    if(suit === 'C' || suit === 'CLUB' || suit === 'CLUBS' || suit === '♣') return { symbol: '♣', red: false };
    return { symbol: '♠', red: false };
  }

  function parseTeenCard(token){
    if(!token || typeof token !== 'string' || token.length < 2) return null;
    const suitMeta = normalizeSuitSymbol(token.slice(-1));
    const suit = suitMeta.symbol;
    const rank = token.slice(0, -1);
    const color = suitMeta.red ? 'red' : 'black';
    return [rank, suit, color];
  }

  function teenFaceMarkup(parsed){
    if(!parsed) return '';
    const rank = parsed[0];
    const suit = parsed[1];
    const cssTone = parsed[2] === 'red' ? 'red' : 'black';
    return `<div class="card-corner top-left ${cssTone}"><span class="rank ${cssTone}">${rank}</span><span class="suit ${cssTone}">${suit}</span></div><div class="center ${cssTone}">${suit}</div><div class="card-corner bottom-right ${cssTone}"><span class="rank ${cssTone}">${rank}</span><span class="suit ${cssTone}">${suit}</span></div>`;
  }

  function promoteFaceupCard(cardEl){
    if(!cardEl) return;
    faceupCardZCounter += 1;
    cardEl.style.zIndex = String(faceupCardZCounter);
    cardEl.style.opacity = '1';
    cardEl.style.visibility = 'visible';
  }

  function renderTeenFront(cardEl, parsed){
    if(!cardEl || !parsed) return;
    cardEl.classList.remove('back');
    cardEl.classList.add('front');
    cardEl.innerHTML = teenFaceMarkup(parsed);
    promoteFaceupCard(cardEl);
  }

  function foldAuthoritativeHands(){
    faceupCardZCounter = 10;
    boardKeys.forEach((key) => {
      const stack = document.getElementById(`stack${key}`);
      if(stack){
        Array.from(stack.children).forEach((cardEl) => {
          setTeenBack(cardEl);
        });
      }
      const label = document.getElementById(`label${key}`);
      if(label){
        label.textContent = key;
        label.classList.remove('badge-pair','badge-sequence','badge-flush','badge-trail','reveal-label');
        label.style.opacity = '0';
      }
    });
  }

  function hasVisibleFrontHands(){
    return boardKeys.some((key) => {
      const stack = document.getElementById(`stack${key}`);
      return stack && stack.querySelector('.card.front');
    });
  }

  function resetPreviewFlipQueue(scopeKey){
    previewFlipScopeKey = scopeKey || '';
    previewFlipQueue = Promise.resolve();
  }

  function setTeenBack(cardEl){
    if(!cardEl) return;
    cardEl.classList.remove('front','reveal-pop','shine-sweep');
    cardEl.classList.add('back');
    cardEl.innerHTML = '';
    cardEl.style.removeProperty('z-index');
    cardEl.style.removeProperty('opacity');
    cardEl.style.removeProperty('visibility');
    if(cardEl.dataset) cardEl.dataset.cardToken = '';
  }

  function quadraticPoint(startX, startY, controlX, controlY, endX, endY, progress){
    const inverse = 1 - progress;
    return {
      x: (inverse * inverse * startX) + (2 * inverse * progress * controlX) + (progress * progress * endX),
      y: (inverse * inverse * startY) + (2 * inverse * progress * controlY) + (progress * progress * endY),
    };
  }

  function easeInOutQuad(progress){
    return progress < 0.5 ? 2 * progress * progress : 1 - (Math.pow(-2 * progress + 2, 2) / 2);
  }

  function animateArcNode(node, options){
    if(!node) return Promise.resolve();
    const startX = Number(options.startX || 0);
    const startY = Number(options.startY || 0);
    const endX = Number(options.endX || 0);
    const endY = Number(options.endY || 0);
    const durationMs = Math.max(240, Number(options.durationMs || 760));
    const arcHeight = Math.max(20, Number(options.arcHeight || teenPattiFx.chip_arc_height || 116));
    const controlX = startX + ((endX - startX) * (options.controlBias == null ? 0.5 : Number(options.controlBias))) + Number(options.controlOffsetX || 0);
    const controlY = Math.min(startY, endY) - arcHeight + Number(options.controlOffsetY || 0);
    const scaleFrom = options.scaleFrom == null ? 1 : Number(options.scaleFrom);
    const scaleTo = options.scaleTo == null ? 0.7 : Number(options.scaleTo);
    const rotateFrom = options.rotateFrom == null ? 0 : Number(options.rotateFrom);
    const rotateTo = options.rotateTo == null ? 180 : Number(options.rotateTo);
    const opacityFrom = options.opacityFrom == null ? 1 : Number(options.opacityFrom);
    const opacityTo = options.opacityTo == null ? 0.92 : Number(options.opacityTo);
    const startedAt = performance.now();

    node.style.left = `${startX}px`;
    node.style.top = `${startY}px`;
    node.style.opacity = `${opacityFrom}`;
    node.style.transform = `translate(-50%, -50%) scale(${scaleFrom}) rotate(${rotateFrom}deg)`;

    return new Promise((resolve) => {
      function step(now){
        const rawProgress = Math.min(1, (now - startedAt) / durationMs);
        const eased = easeInOutQuad(rawProgress);
        const point = quadraticPoint(startX, startY, controlX, controlY, endX, endY, rawProgress);
        const scale = scaleFrom + ((scaleTo - scaleFrom) * eased);
        const rotate = rotateFrom + ((rotateTo - rotateFrom) * eased);
        const opacity = opacityFrom + ((opacityTo - opacityFrom) * rawProgress);
        node.style.left = `${point.x}px`;
        node.style.top = `${point.y}px`;
        node.style.opacity = `${opacity}`;
        node.style.transform = `translate(-50%, -50%) scale(${scale}) rotate(${rotate}deg)`;
        if(rawProgress < 1 && !disposed){
          window.requestAnimationFrame(step);
          return;
        }
        if(options.removeOnComplete !== false) node.remove();
        if(typeof options.onComplete === 'function') options.onComplete();
        resolve();
      }
      window.requestAnimationFrame(step);
    });
  }

  function authoritativeFxBudget(key, fallback){
    const budget = api && typeof api.fxBudget === 'function' ? api.fxBudget() : null;
    if(budget && Number(budget[key]) > 0) return Number(budget[key]);
    const compact = document.body.classList.contains('low-end-mode') || window.innerHeight <= 520 || window.innerWidth <= 430 || (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);
    if(!compact) return fallback;
    const localBudget = { betCoins:2, betSparks:2, winCoins:4, winParticles:6 };
    return localBudget[key] || Math.min(fallback, 6);
  }
  function authoritativeFxAllowed(cost){
    if(document.hidden) return false;
    return !api || typeof api.canPlayFx !== 'function' || api.canPlayFx(cost);
  }
  function authoritativeFxNode(node, ttl){
    if(api && typeof api.registerFxNode === 'function') api.registerFxNode(node, ttl);
    return node;
  }

  function spawnCoinSandBurst(originX, originY, count = 14, scatter = 42){
    const total = Math.min(document.body.classList.contains('low-end-mode') ? 10 : count, authoritativeFxBudget('winParticles', count));
    if(!authoritativeFxAllowed(total)) return;
    for(let index = 0; index < total; index += 1){
      const dust = authoritativeFxNode(document.createElement('span'), 780);
      dust.className = 'coin-sand';
      document.body.appendChild(dust);
      animateArcNode(dust, {
        startX: originX + ((Math.random() - 0.5) * 8),
        startY: originY + ((Math.random() - 0.5) * 8),
        endX: originX + ((Math.random() - 0.5) * scatter * 2),
        endY: originY - (Math.random() * scatter * 1.2),
        arcHeight: Math.max(18, scatter * (0.52 + (Math.random() * 0.34))),
        durationMs: 360 + Math.round(Math.random() * 260),
        scaleFrom: 0.22,
        scaleTo: 0.92 + (Math.random() * 0.48),
        rotateTo: (Math.random() - 0.5) * 220,
        opacityTo: 0,
      });
    }
  }

  function runTeenCardFlip(cardEl, renderCallback){
    if(typeof window.playTeenPattiFx === 'function') window.playTeenPattiFx('cardFlip');
    if(!cardEl){
      renderCallback();
      return Promise.resolve();
    }
    if(!window.gsap){
      renderCallback();
      return Promise.resolve();
    }
    const flipLift = Number(teenPattiFx.flip_lift || 16);
    const flipTilt = Number(teenPattiFx.flip_tilt || 12);
    const flipInDuration = Math.min(0.14, Number(teenPattiFx.flip_in_duration || 0.22));
    const flipOutDuration = Math.min(0.24, Number(teenPattiFx.flip_out_duration || 0.40));
    cardEl.classList.add('card-flipping');
    return new Promise((resolve) => {
      let rendered = false;
      let completed = false;
      const renderOnce = function(){
        if(rendered) return;
        rendered = true;
        renderCallback();
      };
      const completeOnce = function(){
        if(completed) return;
        completed = true;
        renderOnce();
        if(window.gsap) window.gsap.killTweensOf(cardEl);
        cardEl.style.transform = '';
        cardEl.style.opacity = '';
        cardEl.classList.remove('card-flipping');
        resolve();
      };
      window.setTimeout(renderOnce, Math.max(80, Math.round(flipInDuration * 1000)));
      window.setTimeout(completeOnce, Math.max(260, Math.round((flipInDuration + flipOutDuration) * 1000) + 120));
      window.gsap.timeline({
        onComplete: completeOnce
      }).to(cardEl, {
        rotateY: 92,
        rotate: flipTilt * 0.35,
        y: -flipLift,
        scale: 0.95,
        duration: flipInDuration,
        ease: 'power2.in'
      }).add(renderOnce).fromTo(cardEl, {
        rotateY: -96,
        rotate: -flipTilt,
        y: -(flipLift + 2),
        scale: 0.92
      }, {
        rotateY: 0,
        rotate: 0,
        y: 0,
        scale: 1,
        duration: flipOutDuration,
        ease: 'back.out(1.18)',
        clearProps: 'transform'
      });
    });
  }

  function queuePreviewFlip(cardEl, parsed, token, scopeKey){
    previewFlipQueue = previewFlipQueue.then(() => {
      if(previewFlipScopeKey !== scopeKey || !cardEl || (cardEl.dataset && cardEl.dataset.cardToken === token)) return;
      if(!window.gsap){
        renderTeenFront(cardEl, parsed);
        if(cardEl.dataset) cardEl.dataset.cardToken = token;
        return;
      }
      return runTeenCardFlip(cardEl, function(){
        if(previewFlipScopeKey !== scopeKey || !cardEl) return;
        renderTeenFront(cardEl, parsed);
        if(cardEl.dataset) cardEl.dataset.cardToken = token;
      }).then(function(){
        if(previewFlipScopeKey === scopeKey && cardEl) {
          cardEl.classList.add('reveal-pop','shine-sweep');
          window.setTimeout(function(){
            cardEl.classList.remove('reveal-pop','shine-sweep');
          }, 520);
        }
      });
    }).catch(function(){ return; });

    return previewFlipQueue;
  }

  function flipAuthoritativeCard(cardEl, token){
    const parsed = parseTeenCard(token);
    if(!cardEl || !parsed){
      setTeenBack(cardEl);
      return Promise.resolve();
    }
    if(cardEl.classList.contains('front') && cardEl.dataset && cardEl.dataset.cardToken === token) {
      return Promise.resolve();
    }
    if(!window.gsap){
      renderTeenFront(cardEl, parsed);
      if(cardEl.dataset) cardEl.dataset.cardToken = token;
      return Promise.resolve();
    }
    return runTeenCardFlip(cardEl, function(){
      renderTeenFront(cardEl, parsed);
      if(cardEl.dataset) cardEl.dataset.cardToken = token;
    }).then(function(){
      cardEl.classList.add('reveal-pop','shine-sweep');
      window.setTimeout(function(){
        cardEl.classList.remove('reveal-pop','shine-sweep');
      }, 480);
    });
  }

  async function animateAuthoritativeStack(boardKey, hand, delayMs){
    if(delayMs > 0){
      await new Promise((resolve) => window.setTimeout(resolve, delayMs));
    }
    const startedAt = performance.now();
    const stack = document.getElementById(`stack${boardKey}`);
    if(!stack || !(hand && Array.isArray(hand.cards))) return;
    const cardEls = Array.from(stack.children).slice(0, 3);
    for(let index = 0; index < cardEls.length && index < hand.cards.length; index += 1){
      await flipAuthoritativeCard(cardEls[index], hand.cards[index]);
      if(index < Math.min(cardEls.length, hand.cards.length) - 1){
        await new Promise((resolve) => window.setTimeout(resolve, 45));
      }
    }
    await holdMinimumDuration(startedAt, TEEN_SEQUENCE.boardRevealMs);
  }

  function applyAuthoritativeHandLabel(boardKey, hand, animate = true){
    const label = document.getElementById(`label${boardKey}`);
    if(label && hand && hand.label){
      label.textContent = hand.label;
      label.classList.remove('badge-pair','badge-sequence','badge-flush','badge-trail','badge-pure');
      const badgeClass = classifyHandLabelOverlay(hand.label);
      if(badgeClass) label.classList.add(badgeClass);
      label.classList.add('reveal-label');
      label.style.opacity = '1';
      if(animate && window.gsap){
        window.gsap.fromTo(label,{opacity:0,y:8,scale:0.82},{opacity:1,y:0,scale:1,duration:TEEN_SEQUENCE.handLabelMs / 1000,ease:'back.out(1.2)',clearProps:'transform,opacity'});
      }
    }
  }

  async function revealAuthoritativeHandLabels(cardsByBoard, resultKey){
    const startedAt = performance.now();
    boardKeys.forEach((key) => {
      if(activeAuthoritativeRevealKey !== resultKey) return;
      const label = document.getElementById(`label${key}`);
      if(label && label.classList.contains('reveal-label')) return;
      applyAuthoritativeHandLabel(key, cardsByBoard && cardsByBoard[key], true);
    });
    await holdMinimumDuration(startedAt, TEEN_SEQUENCE.handLabelMs);
  }

  async function animateAuthoritativeHandsSequential(cardsByBoard, resultKey){
    const revealOrder = ['A','B','C'].filter((key) => boardKeys.includes(key));
    for(let orderIndex = 0; orderIndex < revealOrder.length; orderIndex += 1){
      const key = revealOrder[orderIndex];
      if(activeAuthoritativeRevealKey !== resultKey) break;
      boardKeys.forEach((boardKey) => {
        const stack = document.getElementById(`stack${boardKey}`);
        if(stack) stack.classList.toggle('reveal-active', boardKey === key);
      });
      await animateAuthoritativeStack(key, cardsByBoard[key], 0);
      if(activeAuthoritativeRevealKey !== resultKey) break;
      applyAuthoritativeHandLabel(key, cardsByBoard && cardsByBoard[key], true);
      await waitMs(TEEN_SEQUENCE.boardHoldMs);
    }

    boardKeys.forEach((key) => {
      const stack = document.getElementById(`stack${key}`);
      if(stack) stack.classList.remove('reveal-active');
    });

    if(activeAuthoritativeRevealKey === resultKey) {
      await revealAuthoritativeHandLabels(cardsByBoard, resultKey);
      activeAuthoritativeRevealKey = '';
      stagedRevealCompleteKey = resultKey;
      stagedRevealCompleteAtMs = Date.now();
    }
  }

  function allAuthoritativeCardsOpen(payload){
    const cardsByBoard = payload && payload.result && payload.result.cards;
    if(!cardsByBoard) return false;
    return boardKeys.every((key) => {
      const hand = cardsByBoard[key];
      const stack = document.getElementById(`stack${key}`);
      if(!stack || !(hand && Array.isArray(hand.cards))) return false;
      const cardEls = Array.from(stack.children).slice(0, 3);
      return hand.cards.slice(0, 3).every((token, index) => {
        const cardEl = cardEls[index];
        return cardEl && cardEl.classList.contains('front') && (!cardEl.dataset || cardEl.dataset.cardToken === token);
      });
    });
  }

  function previewRevealCount(payload){
    return 0;
  }

  function renderCardsByCount(cardsByBoard, revealCount, options){
    const settings = options || {};
    const animateNew = !!settings.animateNew;
    const scopeKey = settings.scopeKey || '';
    let remaining = Math.max(0, Number(revealCount) || 0);
    boardKeys.forEach((key) => {
      const hand = cardsByBoard && cardsByBoard[key];
      const stack = document.getElementById(`stack${key}`);
      if(!stack || !(hand && Array.isArray(hand.cards))) return;
      const cardEls = Array.from(stack.children).slice(0, 3);
      hand.cards.slice(0, 3).forEach((token, index) => {
        const cardEl = cardEls[index];
        if(!cardEl) return;
        const parsed = parseTeenCard(token);
        const shouldReveal = remaining > 0;
        if(shouldReveal) remaining -= 1;
        if(!shouldReveal || !parsed){
          setTeenBack(cardEl);
          return;
        }
        if(cardEl.classList.contains('front') && cardEl.dataset && cardEl.dataset.cardToken === token) return;
        if(animateNew){
          queuePreviewFlip(cardEl, parsed, token, scopeKey);
          return;
        }
        renderTeenFront(cardEl, parsed);
        if(cardEl.dataset) cardEl.dataset.cardToken = token;
        cardEl.classList.remove('reveal-pop','shine-sweep');
      });
    });
  }

  function renderAuthoritativePreview(payload){
    const cardsByBoard = payload && payload.result && payload.result.cards;
    const revealCount = previewRevealCount(payload);
    if(!cardsByBoard || revealCount <= 0) {
      if(revealCount > 0) warnMissingResult(payload, 'preview');
      lastPreviewRevealKey = '';
      resetPreviewFlipQueue('');
      return false;
    }
    const previewKey = `${payload.round_no || 'na'}:${revealCount}`;
    if(previewKey === lastPreviewRevealKey) return true;
    if(!lastPreviewRevealKey || !String(lastPreviewRevealKey).startsWith(`${payload.round_no || 'na'}:`)) {
      resetPreviewFlipQueue(payload.round_no || 'na');
    }
    lastPreviewRevealKey = previewKey;
    renderCardsByCount(cardsByBoard, revealCount, { animateNew: true, scopeKey: payload.round_no || 'na' });
    return true;
  }

  function revealAuthoritativeHands(payload, options){
    const settings = options || {};
    const cardsByBoard = payload && payload.result && payload.result.cards;
    if(!cardsByBoard) {
      warnMissingResult(payload, 'final');
      return Promise.resolve(false);
    }
    const winner = payload.winner_board || (payload.result && payload.result.winner_board) || 'na';
    const resultKey = `${payload.round_no}:${winner}`;
    const frontsAlreadyVisible = boardKeys.some((key) => {
      const stack = document.getElementById(`stack${key}`);
      return stack && stack.querySelector('.card.front');
    });
    if(resultKey === activeAuthoritativeRevealKey || (resultKey === lastRenderedHandsKey && frontsAlreadyVisible)) return activeRevealPipeline || Promise.resolve(true);
    lastRenderedHandsKey = resultKey;
    lastPreviewRevealKey = '';
    resetPreviewFlipQueue(resultKey);

    if(settings.animated){
      foldAuthoritativeHands();
      activeAuthoritativeRevealKey = resultKey;
      stagedRevealCompleteKey = '';
      stagedRevealCompleteAtMs = 0;
      const revealPromise = animateAuthoritativeHandsSequential(cardsByBoard, resultKey).catch(function(){
        if(activeAuthoritativeRevealKey === resultKey) activeAuthoritativeRevealKey = '';
        return false;
      });
      return revealPromise;
    }

    if(stagedRevealCompleteKey !== resultKey && !settings.force) {
      return revealAuthoritativeHands(payload, { animated: true });
    }

    renderCardsByCount(cardsByBoard, boardKeys.length * 3);

    boardKeys.forEach((key) => {
      const hand = cardsByBoard[key];
      const stack = document.getElementById(`stack${key}`);
      if(stack && hand && Array.isArray(hand.cards)){
        const frontNodes = Array.from(stack.querySelectorAll('.card.front'));
        frontNodes.forEach((cardEl, index) => {
          if(!window.gsap) {
            window.setTimeout(function(){
              cardEl.classList.remove('reveal-pop','shine-sweep');
            }, 420 + (index * 50));
            return;
          }
          window.gsap.fromTo(cardEl, {
            y: -8,
            scale: 0.92,
            opacity: 0.92
          }, {
            y: 0,
            scale: 1,
            opacity: 1,
            duration: 0.24,
            delay: index * 0.05,
            ease: 'back.out(1.1)',
            clearProps: 'transform,opacity',
            onComplete: function(){
              cardEl.classList.remove('reveal-pop','shine-sweep');
            }
          });
        });
      }

      const label = document.getElementById(`label${key}`);
      if(label && hand && hand.label){
        applyAuthoritativeHandLabel(key, hand, false);
      }
    });
    return Promise.resolve(true);
  }

  function setPhase(phase, payload){
    if(!gameContainer) return;
    gameContainer.classList.remove('phase-boot','phase-go','phase-betting','phase-stopbet','phase-reveal','phase-winner','phase-reset');
    const winner = payload && (payload.winner_board || (payload.result && payload.result.winner_board));
    if(phase === 'betting') gameContainer.classList.add('phase-betting');
    else if(phase === 'locked') gameContainer.classList.add('phase-stopbet');
    else if(phase === 'revealed' || phase === 'settled') gameContainer.classList.add(winner ? 'phase-winner' : 'phase-reveal');
    else gameContainer.classList.add('phase-go');
    setControlsLive(phase === 'betting' && isBettingOpen(payload), payload);
  }

  function reviveAnimatedNode(node){
    if(!node) return;
    node.style.removeProperty('opacity');
    node.style.removeProperty('visibility');
    node.style.removeProperty('transform');
  }

  function setControlsLive(isLive, payload = lastStatePayload){
    if(chipsBar) chipsBar.classList.toggle('locked', !isLive);
    chipNodes.forEach((chip) => {
      chip.classList.toggle('live', isLive);
      chip.classList.toggle('focus-chip', isLive && chip.classList.contains('selected'));
      chip.setAttribute('aria-pressed', chip.classList.contains('selected') ? 'true' : 'false');
    });
    Object.entries(boards).forEach(([key, boardNode]) => {
      if(!boardNode) return;
      const blockedByBalance = isLive && payload && !hasBalanceForBet(payload, activeChipValue());
      const blockedByLimit = isLive && payload && !canUseBoard(payload, key);
      boardNode.classList.toggle('touchable', isLive && !blockedByBalance && !blockedByLimit);
    });
  }

  function animatePhaseBanner(text){
    if(!phaseBanner) return;
    if(phaseBannerHideTimer){
      window.clearTimeout(phaseBannerHideTimer);
      phaseBannerHideTimer = null;
    }
    reviveAnimatedNode(phaseBanner);
    phaseBanner.textContent = text;
    phaseBanner.style.visibility = 'visible';
    phaseBanner.classList.remove('show');
    void phaseBanner.offsetWidth;
    phaseBanner.classList.add('show');
    phaseBannerHideTimer = window.setTimeout(() => {
      phaseBanner.classList.remove('show');
      phaseBanner.style.visibility = 'hidden';
      phaseBannerHideTimer = null;
    }, 820);
  }

  function hidePhaseBanner(){
    if(!phaseBanner) return;
    if(phaseBannerHideTimer){
      window.clearTimeout(phaseBannerHideTimer);
      phaseBannerHideTimer = null;
    }
    phaseBanner.classList.remove('show');
    phaseBanner.style.visibility = 'hidden';
  }

  function winnerPalette(boardKey){
    if(boardKey === 'A') return ['#ff7ba5', '#ffe08b', '#ffd9ef'];
    if(boardKey === 'B') return ['#74d7ff', '#b9b3ff', '#fff1c3'];
    return ['#7bffb1', '#ffe38f', '#6af6dc'];
  }

  function clearWinnerCelebration(resetKey = true){
    if(megaCelebrationTimer){
      window.clearTimeout(megaCelebrationTimer);
      megaCelebrationTimer = null;
    }
    if(megaCelebration) megaCelebration.classList.remove('show');
    document.querySelectorAll('.bridge-win-spark,.bridge-win-crown').forEach((node) => node.remove());
    Object.entries(potWrappers).forEach(([key, potNode]) => {
      if(!potNode) return;
      potNode.classList.remove('winner-pot');
      if(window.gsap){
        const titleNode = potNode.querySelector('.pot-title');
        const chairNode = potNode.querySelector('.chair');
        const cardNodes = stacks[key] ? Array.from(stacks[key].querySelectorAll('.card.front')) : [];
        if(titleNode) {
          window.gsap.killTweensOf(titleNode);
          window.gsap.set(titleNode, { clearProps: 'transform' });
        }
        if(chairNode) {
          window.gsap.killTweensOf(chairNode);
          window.gsap.set(chairNode, { clearProps: 'transform' });
        }
        if(cardNodes.length) {
          window.gsap.killTweensOf(cardNodes);
          window.gsap.set(cardNodes, { clearProps: 'transform' });
        }
      }
    });
    Object.values(boards).forEach((boardNode) => {
      if(!boardNode) return;
      boardNode.classList.remove('winner-board');
      if(window.gsap){
        window.gsap.killTweensOf(boardNode);
        window.gsap.set(boardNode, { clearProps: 'transform' });
      }
    });
    if(timerOrb) timerOrb.classList.remove('win-glow');
    if(resetKey) {
      lastWinnerCelebrationKey = '';
      lastWinnerCelebrationStartedAtMs = 0;
    }
  }

  function showBridgeMegaCelebration(){
    return;
  }

  function spawnWinnerSpark(originX, originY, color){
    if(!authoritativeFxAllowed(1)) return;
    const spark = authoritativeFxNode(document.createElement('span'), 1800);
    spark.className = 'bridge-win-spark';
    spark.style.left = `${originX}px`;
    spark.style.top = `${originY}px`;
    spark.style.setProperty('--spark-color', color);
    spark.style.setProperty('--spark-dx', `${Math.round((Math.random() - 0.5) * 170)}px`);
    spark.style.setProperty('--spark-dy', `${Math.round(-90 - (Math.random() * 120))}px`);
    spark.style.setProperty('--spark-scale', `${(0.8 + (Math.random() * 0.8)).toFixed(2)}`);
    spark.style.setProperty('--spark-rotate', `${Math.round((Math.random() - 0.5) * 320)}deg`);
    spark.style.setProperty('--spark-duration', `${(1 + (Math.random() * 0.7)).toFixed(2)}s`);
    spark.style.width = `${10 + Math.round(Math.random() * 10)}px`;
    spark.style.height = spark.style.width;
    spark.addEventListener('animationend', () => spark.remove(), { once: true });
    document.body.appendChild(spark);
  }

  function launchWinnerSparkBurst(boardKey){
    const boardNode = boards[boardKey];
    const potNode = potWrappers[boardKey];
    if(!boardNode && !potNode) return;
    const palette = winnerPalette(boardKey);
    const boardRect = boardNode ? boardNode.getBoundingClientRect() : null;
    const potRect = potNode ? potNode.getBoundingClientRect() : null;
    const anchorX = boardRect ? boardRect.left + (boardRect.width / 2) : potRect.left + (potRect.width / 2);
    const anchorY = boardRect ? boardRect.top + (boardRect.height / 2) : potRect.top + (potRect.height / 2);
    const sparkleCount = Math.min(document.body.classList.contains('low-end-mode') ? 10 : 18, authoritativeFxBudget('winParticles', 18));
    if(!authoritativeFxAllowed(sparkleCount)) return;
    for(let index = 0; index < sparkleCount; index += 1){
      const x = anchorX + ((Math.random() - 0.5) * 70);
      const y = anchorY + ((Math.random() - 0.5) * 34);
      spawnWinnerSpark(x, y, palette[index % palette.length]);
    }
  }

  function addWinnerCrown(boardKey){
    const potNode = potWrappers[boardKey];
    if(!potNode || potNode.querySelector('.bridge-win-crown')) return;
    if(!authoritativeFxAllowed(1)) return;
    const crown = authoritativeFxNode(document.createElement('div'), 3200);
    crown.className = 'bridge-win-crown';
    crown.textContent = '👑';
    potNode.appendChild(crown);
  }

  function runAuthoritativeWinnerCelebration(payload){
    const winner = payload && (payload.winner_board || (payload.result && payload.result.winner_board));
    if(!winner) return;
    const celebrationKey = `${payload.round_no || 'na'}:${winner}`;
    if(celebrationKey === lastWinnerCelebrationKey) return;

    clearWinnerCelebration(false);
    lastWinnerCelebrationKey = celebrationKey;
    lastWinnerCelebrationStartedAtMs = Date.now();
    if(typeof window.playTeenPattiFx === 'function') window.playTeenPattiFx('cardFloat');
    const timings = teenTimings(payload);
    const celebrationWindowMs = Math.max(1200, timings.winnerPopupMs + timings.winnerWaitMs + timings.payoutMs + timings.settleWaitMs);

    const potNode = potWrappers[winner];
    const boardNode = boards[winner];
    const stackNode = stacks[winner];

    if(potNode) potNode.classList.add('winner-pot');
    if(boardNode) boardNode.classList.add('winner-board');
    if(timerOrb) timerOrb.classList.add('win-glow');
    addWinnerCrown(winner);
    launchWinnerSparkBurst(winner);
    showBridgeMegaCelebration(`Winner ${boardDisplayName(winner)} lights the table`, timings.winnerPopupMs);
    megaCelebrationTimer = window.setTimeout(function(){
      clearWinnerCelebration(false);
      megaCelebrationTimer = null;
    }, celebrationWindowMs);

    if(!window.gsap) return;

    const titleNode = potNode ? potNode.querySelector('.pot-title') : null;
    const chairNode = potNode ? potNode.querySelector('.chair') : null;
    const cardNodes = stackNode ? Array.from(stackNode.querySelectorAll('.card.front')) : [];

    if(titleNode){
      window.gsap.fromTo(titleNode, { y: 0, rotate: 0 }, { y: -5, rotate: -3, duration: 0.42, repeat: 5, yoyo: true, ease: 'sine.inOut' });
    }
    if(chairNode){
      window.gsap.fromTo(chairNode, { y: 0, rotate: 0 }, { y: -6, rotate: winner === 'A' ? -3 : winner === 'C' ? 3 : 0, duration: 0.38, repeat: 6, yoyo: true, ease: 'sine.inOut' });
    }
    if(boardNode){
      window.gsap.fromTo(boardNode, { y: 0, scale: 1, rotate: 0 }, { y: -4, scale: 1.04, rotate: winner === 'A' ? -1.4 : winner === 'C' ? 1.4 : 0, duration: 0.4, repeat: 6, yoyo: true, ease: 'sine.inOut' });
    }
    if(cardNodes.length){
      const cardDanceBudgetMs = Math.max(520, Math.min(celebrationWindowMs, Number(TEEN_SEQUENCE.cardDanceExtraMs || 0) + timings.winnerPopupMs));
      const cardDanceExtraRepeats = Math.max(0, Math.floor(cardDanceBudgetMs / 520) - 1);
      cardNodes.forEach((cardNode, index) => {
        const baseX = index === 0 ? 12 : (index === 2 ? -12 : 0);
        const floatX = index === 0 ? 7 : (index === 2 ? -7 : 0);
        const baseRotate = index === 0 ? -2 : (index === 2 ? 2 : 0);
        const floatRotate = index === 0 ? -9 : (index === 2 ? 9 : 1);
        window.gsap.fromTo(cardNode, { x: baseX, y: 0, rotate: baseRotate, scale: 1 }, { x: floatX, y: -18 - (index * 2), rotate: floatRotate, scale: 1.12, duration: 0.52, delay: index * 0.06, repeat: 8 + cardDanceExtraRepeats, yoyo: true, ease: 'sine.inOut' });
      });
    }
  }

  function syncTimerChrome(phase){
    const nextPhase = phase || 'boot';
    if(lastTimerChromePhase === nextPhase) return;
    lastTimerChromePhase = nextPhase;
    const timerNodes = getTimerNodes();
    if(timerNodes.wrap) {
      timerNodes.wrap.classList.remove('timer-hidden','round-go','round-live');
    }
    if(timerNodes.orb) {
      timerNodes.orb.classList.remove('disabled','hidden-phase','win-glow','pulse-active');
      timerNodes.orb.style.removeProperty('opacity');
    }
    if(timerNodes.value) timerNodes.value.classList.remove('phase-text','phase-soft');

    if(phase === 'betting') {
      if(timerNodes.wrap) timerNodes.wrap.classList.add('round-live');
      if(timerNodes.orb) timerNodes.orb.classList.add('pulse-active');
      return;
    }
    if(phase === 'locked') {
      if(timerNodes.wrap) timerNodes.wrap.classList.add('round-live');
      return;
    }
    if(phase === 'revealed' || phase === 'settled') {
      if(timerNodes.wrap) timerNodes.wrap.classList.add('round-go');
      if(timerNodes.orb) timerNodes.orb.classList.add('win-glow');
      return;
    }
    if(timerNodes.wrap) timerNodes.wrap.classList.add('round-go');
  }

  function animateAcceptedBet(boardKey, amount){
    if(typeof window.playTeenPattiFx === 'function') window.playTeenPattiFx('coinServe');
    const boardNode = boards[boardKey];
    const plusNode = document.getElementById(`plus${boardKey}`);
    const chipNode = document.querySelector('.chip.selected') || chipNodes[0];

    if(boardNode){
      const boardRect = boardNode.getBoundingClientRect();
      if(chipNode){
        const chipRect = chipNode.getBoundingClientRect();
        const chipGhost = createAuthoritativeFlyingChip(chipRect);
        if(chipGhost){
          spawnCoinSandBurst(chipRect.left + (chipRect.width / 2), chipRect.top + (chipRect.height / 2), 10, 26);
          animateArcNode(chipGhost, {
            startX: chipRect.left + (chipRect.width / 2),
            startY: chipRect.top + (chipRect.height / 2),
            endX: boardRect.left + (boardRect.width / 2),
            endY: boardRect.top + (boardRect.height / 2),
            arcHeight: Number(teenPattiFx.chip_arc_height || 116),
            durationMs: 520,
            scaleTo: 0.56,
            rotateTo: 280,
            opacityTo: 0.96,
          });
        }
      }
      spawnCoinSandBurst(boardRect.left + (boardRect.width / 2), boardRect.top + (boardRect.height / 2), 12, 32);
      boardNode.classList.add('selected-target');
      if(window.gsap){
        window.gsap.fromTo(boardNode,{scale:0.98},{scale:1,duration:0.18,clearProps:'transform'});
      }
      window.setTimeout(() => boardNode.classList.remove('selected-target'), 420);
    }

    if(plusNode){
      plusNode.textContent = `+${number(amount)}`;
      if(window.gsap){
        window.gsap.killTweensOf(plusNode);
        window.gsap.fromTo(plusNode,{opacity:0,y:8,scale:0.86},{opacity:1,y:0,scale:1,duration:0.18,onComplete:()=>window.gsap.to(plusNode,{opacity:0,y:-10,duration:0.28,delay:0.55})});
      }
    }

    if(floatingBanner){
      reviveAnimatedNode(floatingBanner);
      floatingBanner.textContent = `BET ${boardDisplayName(boardKey)} +${number(amount)}`;
      floatingBanner.style.visibility = 'visible';
      if(window.gsap){
        window.gsap.killTweensOf(floatingBanner);
        window.gsap.fromTo(floatingBanner,{opacity:0,y:12},{opacity:1,y:0,duration:0.2,onComplete:()=>window.gsap.to(floatingBanner,{opacity:0,y:-8,duration:0.3,delay:0.7,onComplete:()=>{ floatingBanner.style.visibility='hidden'; }})});
      }else{
        floatingBanner.style.opacity = '0';
        floatingBanner.style.visibility = 'hidden';
      }
    }
  }

  function payoutAnimationKey(payload, winner, winAmount){
    return `${payload && payload.round_no ? payload.round_no : 'na'}:${winner || 'na'}`;
  }

  function resolveDisplayedWinAmount(payload, winner){
    const winnerKey = winner || (payload && (payload.winner_board || (payload.result && payload.result.winner_board))) || '';
    const actualWinAmount = Number(payload && payload.my_total_win_amount || 0);
    if(actualWinAmount > 0) return actualWinAmount;
    const winnerBet = Number(payload && payload.my_bet_totals && payload.my_bet_totals[winnerKey] || 0);
    return winnerBet > 0 ? winnerBet * resolveWinnerMultiplier(payload, winnerKey) : 0;
  }

  function resolveWinnerMultiplier(payload, winnerKey){
    const fromResult = Number(payload && payload.result && payload.result.multiplier || 0);
    if(fromResult > 0) return fromResult;
    const board = (payload && payload.boards || []).find(item => item && String(item.frontend_key || item.canonical_key).toUpperCase() === String(winnerKey || '').toUpperCase());
    const fromPayload = Number(board && board.multiplier || 0);
    if(fromPayload > 0) return fromPayload;
    return Number(boardPayoutMultipliers[winnerKey] || 3);
  }

  function setDisplayedBalance(value){
    displayedBalanceValue = Number(value || 0);
    if(!balanceText) return;
    const text = balanceNumber(displayedBalanceValue);
    balanceText.textContent = text;
    balanceText.title = text;
  }

  function animateDisplayedBalance(startValue, endValue, duration = 620){
    const from = Number(startValue || 0);
    const to = Number(endValue || 0);
    if(!balanceText || from === to){
      setDisplayedBalance(to);
      return Promise.resolve();
    }
    const startedAt = performance.now();
    return new Promise((resolve) => {
      function tick(now){
        const progress = Math.min(1, (now - startedAt) / duration);
        const current = Math.round(from + ((to - from) * progress));
        setDisplayedBalance(current);
        if(progress < 1){
          window.requestAnimationFrame(tick);
          return;
        }
        setDisplayedBalance(to);
        resolve();
      }
      window.requestAnimationFrame(tick);
    });
  }

  function createAuthoritativeFlyingChip(startRect){
    const sourceChip = document.querySelector('.chip.selected') || chipNodes.find((node) => node && node.innerHTML) || chipNodes[0];
    if(!startRect || !sourceChip) return null;
    if(!authoritativeFxAllowed(1)) return null;
    const chip = authoritativeFxNode(document.createElement('div'), 1600);
    chip.className = 'payout-chip-ghost';
    chip.innerHTML = sourceChip.innerHTML;
    chip.style.left = `${startRect.left + (startRect.width / 2)}px`;
    chip.style.top = `${startRect.top + (startRect.height / 2)}px`;
    document.body.appendChild(chip);
    return chip;
  }

  function triggerAuthoritativeBalanceImpact(){
    if(!balanceSection) return;
    const rect = balanceSection.getBoundingClientRect();
    spawnCoinSandBurst(rect.left + (rect.width / 2), rect.top + (rect.height / 2), 18, 48);
    balanceSection.animate([
      { transform: 'translateX(0px)', boxShadow: '0 0 0 rgba(70,232,138,0)' },
      { transform: 'translateX(3px)', boxShadow: '0 0 26px rgba(70,232,138,.48)' },
      { transform: 'translateX(-2px)', boxShadow: '0 0 18px rgba(70,232,138,.26)' },
      { transform: 'translateX(0px)', boxShadow: '0 0 0 rgba(70,232,138,0)' }
    ], {
      duration: 520,
      easing: 'cubic-bezier(.2,.9,.2,1)'
    });
  }

  function syncBalanceDisplay(payload){
    const finalBalance = Number(payload && payload.balance || 0);
    const winner = payload && (payload.winner_board || (payload.result && payload.result.winner_board));
    const winAmount = Number(payload && payload.my_total_win_amount || 0);
    const isResultPhase = !!(payload && (payload.phase === 'revealed' || payload.phase === 'settled'));
    const payoutKey = payoutAnimationKey(payload, winner, winAmount);

    if(activePayoutAnimationKey && payoutKey === activePayoutAnimationKey){
      return;
    }

    if(isResultPhase && winAmount > 0 && payoutKey !== lastAnimatedPayoutKey){
      setDisplayedBalance(Math.max(0, finalBalance - winAmount));
      return;
    }

    setDisplayedBalance(finalBalance);
  }

  function runAuthoritativePayoutAnimation(payload){
    const winner = payload && (payload.winner_board || (payload.result && payload.result.winner_board));
    const winAmount = resolveDisplayedWinAmount(payload, winner);
    const finalBalance = Number(payload && payload.balance || 0);
    const payoutKey = payoutAnimationKey(payload, winner, winAmount);
    const payoutDurationMs = teenTimings(payload).payoutMs;
    const balanceDurationMs = Math.min(620, Math.max(360, payoutDurationMs - 1200));
    const flightDurationSec = Math.max(0.92, (Math.max(0, payoutDurationMs - balanceDurationMs) / 1000));
    const chipBaseDurationSec = Math.max(0.74, flightDurationSec - 0.24);

    if(!winner || winAmount <= 0 || payoutKey === lastAnimatedPayoutKey || payoutKey === activePayoutAnimationKey){
      setDisplayedBalance(finalBalance);
      return;
    }

    activePayoutAnimationKey = payoutKey;

    const startBalance = displayedBalanceValue != null
      ? Number(displayedBalanceValue)
      : Math.max(0, finalBalance - winAmount);

    const winEl = wins[winner];
    const from = winEl ? winEl.getBoundingClientRect() : null;
    const to = balanceSection ? balanceSection.getBoundingClientRect() : null;

    const completePayout = () => {
      lastAnimatedPayoutKey = payoutKey;
      activePayoutAnimationKey = '';
    };

    if(!window.gsap || !winEl || !from || !to || !to.width || !to.height){
      animateDisplayedBalance(startBalance, finalBalance, Math.max(520, payoutDurationMs)).then(() => {
        triggerAuthoritativeBalanceImpact();
        completePayout();
      });
      return;
    }

    winEl.textContent = number(winAmount);
    const startX = from.left + (from.width / 2);
    const startY = from.top + (from.height / 2);
    const endX = to.left + (to.width / 2);
    const endY = to.top + (to.height / 2);

    const chipCount = Math.min(Math.max(2, Number(teenPattiFx.payout_chip_count || 5)), authoritativeFxBudget('winCoins', 5));
    if(!authoritativeFxAllowed(1 + chipCount)){
      animateDisplayedBalance(startBalance, finalBalance, 620).then(() => {
        triggerAuthoritativeBalanceImpact();
        completePayout();
      });
      return;
    }

    const amountGhost = authoritativeFxNode(document.createElement('div'), 1600);
    amountGhost.className = 'payout-fly-amount';
    amountGhost.textContent = `+${number(winAmount)}`;
    amountGhost.style.left = `${startX}px`;
    amountGhost.style.top = `${startY}px`;
    document.body.appendChild(amountGhost);

    const chips = Array.from({ length: chipCount })
      .map(() => createAuthoritativeFlyingChip(from))
      .filter(Boolean);

    let impactTriggered = false;
    const triggerImpact = () => {
      if(impactTriggered) return;
      impactTriggered = true;
      animateDisplayedBalance(startBalance, finalBalance, 620).then(() => {
        triggerAuthoritativeBalanceImpact();
        completePayout();
      });
    };

    spawnCoinSandBurst(startX, startY, 14, 44);

    animateArcNode(amountGhost, {
      startX,
      startY,
      endX,
      endY,
      arcHeight: Number(teenPattiFx.payout_arc_height || 156),
      durationMs: Math.max(820, Math.round(flightDurationSec * 1000)),
      scaleTo: 0.72,
      rotateTo: 6,
      opacityTo: 0.96,
      onComplete: triggerImpact,
    });

    chips.forEach((chip, idx) => {
      const spread = (idx - 1.5) * 18;
      animateArcNode(chip, {
        startX,
        startY,
        endX: endX + spread,
        endY: endY - 10 + (idx * 3),
        arcHeight: Number(teenPattiFx.payout_arc_height || 156) + 8 + (idx * 7),
        durationMs: Math.max(720, Math.round((chipBaseDurationSec + (idx * 0.08)) * 1000)),
        scaleTo: 0.5,
        rotateTo: 220 + (idx * 90),
        opacityTo: 0.94,
        onComplete: () => {
          if(idx === chips.length - 1) triggerImpact();
        },
      });
    });

    if(!chips.length){
      window.setTimeout(triggerImpact, Math.max(960, Math.round(flightDurationSec * 1000)));
    }
  }

  function scheduleStartPopup(payload){
    const popupKey = `${payload && payload.round_no ? payload.round_no : 'na'}:betting`;
    if(popupKey === lastStartPopupKey) return;
    lastStartPopupKey = popupKey;
    showPhaseModal(modalStart, teenTimings(payload).startPopupMs);
  }

  function scheduleStopPopup(payload){
    const popupKey = `${payload && payload.round_no ? payload.round_no : 'na'}:locked`;
    if(popupKey === lastStopPopupKey) return;
    lastStopPopupKey = popupKey;
    lastStopPopupShownAtMs = Date.now();
    showPhaseModal(modalStop, teenTimings(payload).stopPopupMs);
  }

  function startStrictRevealPipeline(payload){
    const winner = payload && (payload.winner_board || (payload.result && payload.result.winner_board));
    const cardsByBoard = payload && payload.result && payload.result.cards;
    if(!payload || !winner || !cardsByBoard) {
      warnMissingResult(payload, 'strict');
      return Promise.resolve(false);
    }
    const pipelineKey = `${payload.round_no || 'na'}:${winner}`;
    if(activeRevealPipelineKey === pipelineKey && activeRevealPipeline) return activeRevealPipeline;
    if(resultPopupShown(payload)) return Promise.resolve(true);

    activeRevealPipelineKey = pipelineKey;
    clearRevealStageTimer();

    activeRevealPipeline = (async function(){
      try {
        await revealAuthoritativeHands(payload, { animated: true });
        if(activeRevealPipelineKey !== pipelineKey) return false;
        await waitForServerMarker(payload, winnerPopupAt, pipelineKey);
        if(activeRevealPipelineKey !== pipelineKey) return false;
        renderResult(payload);
        if(activeRevealPipelineKey !== pipelineKey) return false;
        showAuthoritativeResultPopup(payload);
        hidePhaseBanner();
        return true;
      } finally {
        if(activeRevealPipelineKey === pipelineKey) {
          activeRevealPipelineKey = '';
          activeRevealPipeline = null;
        }
      }
    })();

    return activeRevealPipeline;
  }

  function scheduleRevealStage(payload){
    const winner = payload && (payload.winner_board || (payload.result && payload.result.winner_board));
    if(!winner) return;
    if(resultPopupShown(payload)) return;
    const revealStageKey = `${payload.round_no || 'na'}:${winner}`;
    if(revealStageKey === lastRevealStageKey) return;
    lastRevealStageKey = revealStageKey;
    clearRevealStageTimer();

    const revealElapsedMs = phaseElapsedMs(payload, 'revealed');
    const fallbackDelayMs = Math.max(0, TEEN_SEQUENCE.stopToRevealDelayMs - revealElapsedMs);
    const stopPopupGateMs = lastStopPopupShownAtMs
      ? Math.max(0, (lastStopPopupShownAtMs + teenTimings(payload).stopPopupMs + TEEN_SEQUENCE.stopToRevealDelayMs) - Date.now())
      : 0;
    const revealDelayMs = Math.max(fallbackDelayMs, stopPopupGateMs);

    if(revealDelayMs <= 0) {
      startStrictRevealPipeline(payload);
      return;
    }

    revealStageTimer = window.setTimeout(function(){
      revealStageTimer = null;
      startStrictRevealPipeline(payload);
    }, revealDelayMs);
  }

  function scheduleSettlementStage(payload){
    const winner = payload && (payload.winner_board || (payload.result && payload.result.winner_board));
    const winAmount = resolveDisplayedWinAmount(payload, winner);
    const payoutKey = payoutAnimationKey(payload, winner, winAmount);
    if(!winner || winAmount <= 0) return;

    if(!resultPopupShown(payload)) {
      if(payoutKey === lastSettlementStageKey) return;
      lastSettlementStageKey = payoutKey;
      clearSettlementStageTimer();
      settlementStageTimer = window.setTimeout(function(){
        lastSettlementStageKey = '';
        scheduleSettlementStage(payload);
        settlementStageTimer = null;
      }, 250);
      return;
    }
    if(payoutKey === lastSettlementStageKey) return;
    lastSettlementStageKey = payoutKey;
    clearSettlementStageTimer();
    settlementStageTimer = window.setTimeout(function(){
      runAuthoritativePayoutAnimation(payload);
      settlementStageTimer = null;
    }, 0);
  }

  function setTimer(payload){
    const timerNodes = getTimerNodes();
    if(!timerNodes.value) return;
    syncTimerChrome(payload.phase);
    const clockKey = `${payload.round_no || 'na'}:${payload.phase || 'na'}`;
    const serverSyncStamp = `${clockKey}:${Number(payload.server_time || 0)}:${lastStateReceivedAt}`;
    if(typeof payload.server_time === 'number' && lastServerSyncStamp !== serverSyncStamp){
      const networkBiasSec = Math.max(0, Number(lastNetworkMs || 0)) / 2000;
      const nextOffset = payload.server_time - ((Date.now() / 1000) - networkBiasSec);
      serverClockOffsetSec = lastServerSyncStamp ? ((serverClockOffsetSec * 3) + nextOffset) / 4 : nextOffset;
      serverClockKey = clockKey;
      lastServerSyncStamp = serverSyncStamp;
    }
    const timing = timerPhaseState(payload);
    if(!timing){
      const emptyKey = 'notiming|GO|READY|1|0|soft';
      if(lastTimerDisplayKey !== emptyKey){
        if(timerNodes.wrap) timerNodes.wrap.classList.add('timer-hidden');
        timerNodes.value.textContent = 'GO';
        timerNodes.value.dataset.value = 'GO';
        timerNodes.value.classList.remove('phase-text','phase-soft');
        timerNodes.value.classList.add('phase-soft');
        if(timerNodes.sub) timerNodes.sub.textContent = 'READY';
        if(timerNodes.orb) timerNodes.orb.classList.remove('pulse-active');
        lastTimerDisplayKey = emptyKey;
      }
      setTimerVisual(1, 'var(--teen-timer-ring)');
      return;
    }
    const shouldHide = !(timing.phase === 'betting' && timing.remainingMs > 0 && !timing.waitingForCountdown);
    const shouldPulse = timing.phase === 'betting' && timing.remainingMs > 0 && !timing.waitingForCountdown;
    const shouldSoft = !/^\d+$/.test(timing.text);
    const displayKey = `${timing.phase}|${timing.text}|${timing.sub}|${shouldHide ? 1 : 0}|${shouldPulse ? 1 : 0}|${shouldSoft ? 'soft' : 'plain'}`;
    if(lastTimerDisplayKey !== displayKey){
      if(timerNodes.wrap) {
        timerNodes.wrap.classList.toggle('timer-hidden', shouldHide);
      }
      timerNodes.value.textContent = timing.text;
      timerNodes.value.dataset.value = timing.text;
      timerNodes.value.classList.remove('phase-text','phase-soft');
      if(shouldSoft) timerNodes.value.classList.add('phase-soft');
      if(timerNodes.sub) timerNodes.sub.textContent = timing.sub;
      if(timerNodes.orb) timerNodes.orb.classList.toggle('pulse-active', shouldPulse);
      lastTimerDisplayKey = displayKey;
    }
    setTimerVisual(timing.progress, timing.color);
  }

  function renderResult(payload){
    const winner = payload && (payload.winner_board || (payload.result && payload.result.winner_board));
    if(!winner) return;
    const resultKey = `${payload.round_no}:${winner}`;
    if(resultKey === lastResultKey) return;
    lastResultKey = resultKey;
    boardKeys.forEach((key) => {
      if(boards[key]) boards[key].classList.toggle('winner', key === winner);
    });
    runAuthoritativeWinnerCelebration(payload);
    animatePhaseBanner(`WINNER ${boardDisplayName(winner)}`);
  }

  function hideResultPopups(){
    [modalWin, modalLoss, modalNoBid].forEach((modal) => {
      if(!modal) return;
      modal.classList.remove('show');
      modal.style.removeProperty('opacity');
      modal.style.removeProperty('visibility');
      modal.style.removeProperty('pointer-events');
      const card = modal.querySelector('.modal-card');
      if(card) card.style.removeProperty('opacity');
    });
    window.clearTeenPattiWinnerPopupCards?.();
    if(resultPopupTimer) {
      window.clearTimeout(resultPopupTimer);
      resultPopupTimer = null;
    }
    resultPopupShownAtMs = 0;
  }

  function hasActiveResultPopup(){
    return !!((modalWin && modalWin.classList.contains('show'))
      || (modalLoss && modalLoss.classList.contains('show'))
      || (modalNoBid && modalNoBid.classList.contains('show')));
  }

  function showAuthoritativeResultPopup(payload){
    const winner = payload && (payload.winner_board || (payload.result && payload.result.winner_board));
    if(!winner) return;
    const popupKey = resultPopupKey(payload);
    if(popupKey === lastPopupKey) return;
    const timings = teenTimings(payload);

    const totalBet = Number(payload.my_total_bet_amount || 0);
    const winnerBet = Number(payload.my_bet_totals && payload.my_bet_totals[winner] || 0);
    const winAmount = resolveDisplayedWinAmount(payload, winner);
    const modal = totalBet <= 0 ? modalNoBid : (winnerBet > 0 ? modalWin : modalLoss);
    if(!modal) return;

    hideResultPopups();
    lastPopupKey = popupKey;
    resultPopupShownAtMs = Date.now();
    if(modal === modalWin) {
      if(typeof window.playTeenPattiFx === 'function') window.playTeenPattiFx('win');
      window.renderTeenPattiWinnerPopupCards?.(winner, payload && payload.result && payload.result.cards && payload.result.cards[winner]);
    } else {
      if(typeof window.playTeenPattiFx === 'function') window.playTeenPattiFx(modal === modalNoBid ? 'noBet' : 'loss');
      window.clearTeenPattiWinnerPopupCards?.();
    }
    if(modal === modalWin && winText) {
      winText.textContent = `${winner} WIN · +${number(winAmount)} PAYOUT`;
    }
    modal.classList.add('show');
    modal.style.setProperty('opacity','1','important');
    modal.style.setProperty('visibility','visible','important');
    modal.style.setProperty('pointer-events',isPassiveAuthoritativeModal(modal) ? 'none' : 'auto','important');
    const card = modal.querySelector('.modal-card');
    if(card && isPassiveAuthoritativeModal(modal)) card.style.setProperty('pointer-events','none','important');
    resultPopupTimer = window.setTimeout(function(){
      if(modal) {
        modal.classList.remove('show');
        modal.style.removeProperty('opacity');
        modal.style.removeProperty('visibility');
        modal.style.removeProperty('pointer-events');
        if(card) card.style.removeProperty('pointer-events');
      }
      resultPopupTimer = null;
    }, timings.winnerPopupMs);
  }

  function clearLegacyOverlays(){
    activeRevealPipelineKey = '';
    activeRevealPipeline = null;
    hidePhaseModals();
    hideResultPopups();
    lastPopupKey = '';
    clearWinnerCelebration();
    clearRevealStageTimer();
    clearSettlementStageTimer();
    document.querySelectorAll('.modal').forEach((node) => node.classList.remove('show'));
    [messageBanner, floatingBanner, megaCelebration, toast].forEach((node) => {
      if (!node) return;
      node.classList.remove('show');
      reviveAnimatedNode(node);
    });
  }

  function syncVisibleState(payload){
    if(!payload) return;
    const roundChanged = authoritativeRoundNo && payload.round_no && authoritativeRoundNo !== payload.round_no;
    const previewActive = renderAuthoritativePreview(payload);
    lastStatePayload = payload;
    lastStateReceivedAt = Date.now();
    authoritativeRoundNo = payload.round_no || authoritativeRoundNo;
    if(payload.phase !== 'revealed' && payload.phase !== 'settled' && !previewActive && hasVisibleFrontHands() && !hasActiveResultPopup()) {
      lastRenderedHandsKey = '';
      lastPreviewRevealKey = '';
      resetPreviewFlipQueue('');
      foldAuthoritativeHands();
    }
    if(roundChanged && payload.phase === 'betting') {
      hideResultPopups();
      clearWinnerCelebration();
      lastPopupKey = '';
      lastResultKey = '';
      lastRenderedHandsKey = '';
      lastPreviewRevealKey = '';
      lastRevealStageKey = '';
      lastSettlementStageKey = '';
      resetPreviewFlipQueue('');
      foldAuthoritativeHands();
    }
    syncBalanceDisplay(payload);
    if(roundCount) {
      roundCount.textContent = formatRoundLabel(authoritativeRoundNo);
    }
    const currentWinner = payload.winner_board || (payload.result && payload.result.winner_board);
    const winnerStateVisible = winnerEffectsReady(payload);
    const winnerVisualsVisible = winnerVisualsStarted(payload) || winnerStateVisible;
    boardKeys.forEach((key) => {
      const boardTotal = Number(payload.board_totals && payload.board_totals[key] || 0);
      const myTotal = Number(payload.my_bet_totals && payload.my_bet_totals[key] || 0);
      if(totals[key]) totals[key].textContent = number(boardTotal);
      if(wins[key]) {
        const isWinner = currentWinner === key;
        if(winnerStateVisible && isWinner && myTotal > 0){
          const multiplier = resolveWinnerMultiplier(payload, key);
          const winAmount = resolveDisplayedWinAmount(payload, key);
          wins[key].textContent = `${number(myTotal)} x${number(multiplier)} = ${number(winAmount)}`;
        } else {
          wins[key].textContent = number(myTotal);
        }
      }
      if(boards[key]) {
        const isWinner = currentWinner === key;
        const bettingOpen = isBettingOpen(payload);
        const blockedByLimit = bettingOpen && !canUseBoard(payload, key);
        const blockedByBalance = bettingOpen && !hasBalanceForBet(payload, activeChipValue());
        const blocked = blockedByLimit || blockedByBalance;
        boards[key].classList.toggle('winner', !!winnerVisualsVisible && !!isWinner);
        boards[key].classList.toggle('loser', !!winnerVisualsVisible && !isWinner && !!currentWinner);
        boards[key].classList.toggle('touchable', bettingOpen && !blocked);
        boards[key].style.opacity = blocked ? '0.66' : '';
        boards[key].style.filter = blocked ? 'grayscale(.22)' : '';
        boards[key].style.cursor = blocked ? 'not-allowed' : '';
        boards[key].setAttribute('aria-disabled', blocked ? 'true' : 'false');
      }
    });
    if(winnerStateVisible && allAuthoritativeCardsOpen(payload)) {
      revealAuthoritativeHands(payload);
    }
  }
  function formatRoundLabel(roundNo){
    if(!roundNo) return '-';
    const parts = String(roundNo).split('_');
    const value = parts.length ? parts[parts.length - 1] : '-';
    if(/^\d{7,}$/.test(value)) {
      return value.slice(-3).replace(/^0+/, '') || '0';
    }
    return value || '-';
  }

  function escapeHtml(value){
    return String(value == null ? '' : value)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#39;');
  }

  function historyRoundLabel(value){
    if(value && typeof value === 'object'){
      value = value.round_short || value.trace_short || value.round_no || value.round_id || value.trace_id || '-';
    }
    const raw = String(value || '-');
    const parts = raw.split('_');
    const tail = parts.length ? parts[parts.length - 1] : raw;
    if(/^\d{7,}$/.test(tail)) return tail.slice(-6);
    return raw.length > 10 ? raw.slice(-10) : raw;
  }

  function historyOutcomeBadge(item){
    const outcome = String(item && (item.user_outcome || item.status) || 'no_bid').toLowerCase();
    const statusClass = outcome === 'won' ? 'win' : (outcome === 'lost' ? 'loss' : 'pending');
    const label = outcome === 'won'
      ? `WIN +${number(item && (item.user_win_amount || item.win_amount) || 0)}`
      : (outcome === 'lost' ? 'LOSS' : 'NO BET');
    return `<span class="history-status ${statusClass}">${escapeHtml(label)}</span>`;
  }

  function renderBoardHistoryTable(items){
    if(!items.length){
      return '<div class="history-table-empty">Waiting for live rounds</div>';
    }
    return `
      <div class="history-table-wrap">
        <table class="history-table">
          <thead>
            <tr>
              <th>Round</th>
              <th>Winner</th>
              <th>You</th>
            </tr>
          </thead>
          <tbody>
            ${items.map((item) => {
              const winnerKey = String(item && item.winner_board_key || '').toUpperCase();
              const winnerName = boardDisplayName(winnerKey || '-');
              return `
                <tr>
                  <td class="history-trace-cell">${escapeHtml(historyRoundLabel(item))}</td>
                  <td>${escapeHtml(winnerName)}</td>
                  <td>${historyOutcomeBadge(item)}</td>
                </tr>
              `;
            }).join('')}
          </tbody>
        </table>
      </div>
    `;
  }

  function renderUserHistoryTable(items){
    if(!items.length){
      return '<div class="history-table-empty">Place a bet to build your history</div>';
    }
    return `
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
            ${items.map((item) => {
              const boardKey = String(item && (item.board_key || item.frontend_board_key) || '').toUpperCase();
              const boardName = boardDisplayName(boardKey || '-');
              const status = String(item && item.status || 'pending').toLowerCase();
              const statusClass = status === 'won' ? 'win' : (status === 'lost' ? 'loss' : (status === 'punishment' ? 'punishment' : 'pending'));
              const resultText = status === 'won'
                ? `WIN +${number(item && item.win_amount || 0)}`
                : (status === 'lost' ? `LOSS -${number(item && item.amount || 0)}` : (status === 'punishment' ? `PUNISH -${number(Math.abs(Number(item && (item.result_amount || item.amount) || 0)))}` : 'PENDING'));
              return `
                <tr>
                  <td class="history-trace-cell">${escapeHtml(historyRoundLabel(item && (item.trace_short || item.trace_id) || '-'))}</td>
                  <td class="history-trace-cell">${escapeHtml(historyRoundLabel(item))}</td>
                  <td>${escapeHtml(boardName)}</td>
                  <td>${escapeHtml(number(item && item.amount || 0))}</td>
                  <td><span class="history-status ${statusClass}">${escapeHtml(resultText)}</span></td>
                </tr>
              `;
            }).join('')}
          </tbody>
        </table>
      </div>
    `;
  }

  function renderTrendHistoryTable(items){
    const rows = Array.isArray(items) ? items.slice(0, 10) : [];
    if(!rows.length){
      return '<div class="history-table-empty">Waiting for the last 10 winning boards</div>';
    }
    const boardKeys = ['A', 'B', 'C'];
    const timeline = rows.map((item, index) => {
      const winnerKey = String(item && (item.winner_board_key || item.winner_board || item.board_key || item.frontend_board_key) || '').toUpperCase();
      return {
        item,
        index,
        winnerKey: boardKeys.includes(winnerKey) ? winnerKey : '',
        round: historyRoundLabel(item),
      };
    });
    const headerCells = boardKeys.map((boardKey, boardIndex) => `
      <div class="teen-trend-board-label board-${escapeHtml(boardKey.toLowerCase())}" style="grid-column:${boardIndex + 1};grid-row:1;" title="${escapeHtml(boardDisplayName(boardKey))}">
        ${escapeHtml(boardDisplayName(boardKey))}
      </div>
    `).join('');
    const cells = Array.from({ length: 10 }, (_, rowIndex) => {
      const entry = timeline[rowIndex];
      return boardKeys.map((boardKey, boardIndex) => {
        const isWinner = !!(entry && entry.winnerKey === boardKey);
        const title = entry ? `${boardDisplayName(boardKey)} - ${entry.round}` : boardDisplayName(boardKey);
        const latestClass = isWinner && entry.index === 0 ? ' is-latest' : '';
        const chairSrc = teenTrendChairAssets[boardKey] || '';
        const chairMarkup = isWinner && chairSrc ? `<img src="${escapeHtml(chairSrc)}" alt="" loading="lazy" aria-hidden="true">` : '';
        const tokenMarkup = isWinner ? `<div class="teen-trend-token${latestClass}" title="${escapeHtml(title)}" aria-label="${escapeHtml(title)}">${chairMarkup}<span>${escapeHtml(boardKey)}</span></div>` : '';
        const tokenClass = isWinner ? ` has-token board-${escapeHtml(boardKey.toLowerCase())}` : '';
        return `
          <div class="teen-trend-cell${tokenClass}" style="grid-column:${boardIndex + 1};grid-row:${rowIndex + 2};">
            ${tokenMarkup}
          </div>
        `;
      }).join('');
    }).join('');
    const latestRound = rows[0] ? historyRoundLabel(rows[0]) : '--';
    return `
      <div class="teen-trend-roadmap teen-trend-vertical" role="img" aria-label="Last 10 winning boards top to bottom roadmap">
        <div class="teen-trend-side"><span>LAST 10</span><small>${escapeHtml(latestRound)}</small></div>
        <div class="teen-trend-grid">${headerCells}${cells}</div>
      </div>
      <div class="teen-trend-legend">
        ${boardKeys.map((boardKey) => `<span>${escapeHtml(boardDisplayName(boardKey))}</span>`).join('')}
      </div>
    `;
  }

  function renderActiveUsersList(){
    const rows = Array.isArray(activePlayerRows) ? activePlayerRows : [];
    if(!rows.length){
      return '<div class="history-table-empty">No active players yet</div>';
    }
    return `<div class="teen-active-user-grid">${rows.map((player, index) => {
      const rawName = String(player && (player.name || player.username || player.display_name || player.user_name) || `Player ${index + 1}`);
      const image = String(player && (player.image || player.avatar || player.profile_image || player.photo || player.user_image) || '');
      const initial = String(player && player.initial || rawName.charAt(0) || 'P').slice(0, 2).toUpperCase();
      const avatar = image ? `<img src="${escapeHtml(image)}" alt="${escapeHtml(rawName)}">` : escapeHtml(initial);
      const label = player && player.is_me ? 'YOU' : `Win ${number(player && player.game_win_amount || 0)}`;
      return `<div class="teen-active-user-card"><div class="teen-active-user-avatar">${avatar}</div><strong>${escapeHtml(rawName)}</strong><span>${escapeHtml(label)}</span></div>`;
    }).join('')}</div>`;
  }

  function renderUtilityLists(){
    if(modalUsersList){
      modalUsersList.innerHTML = renderActiveUsersList();
    }
    if(modalHistoryList){
      modalHistoryList.innerHTML = renderUserHistoryTable(userHistoryRows);
    }
    if(modalRecentList){
      modalRecentList.innerHTML = renderTrendHistoryTable(boardHistoryRows);
    }
  }

  async function refreshHistoryTables(force = false){
    if(disposed || !window.BDGameFinal || !window.BD_GAME_BOOTSTRAP || historySyncInFlight){
      return;
    }
    if(!force && !window.BD_GAME_BOOTSTRAP.endpoints){
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
      if(!boardHistoryRows.length && !userHistoryRows.length){
        boardHistoryRows = [];
        userHistoryRows = [];
      }
    } finally {
      historySyncInFlight = false;
      renderUtilityLists();
    }
  }

  window.refreshHistoryTables = refreshHistoryTables;

  let lastUtilityPressKey = '';
  let lastUtilityPressAt = 0;
  function isDuplicateUtilityPress(key, eventType){
    const now = Date.now();
    if(eventType === 'click' && lastUtilityPressKey === key && now - lastUtilityPressAt < 420) return true;
    lastUtilityPressKey = key;
    lastUtilityPressAt = now;
    return false;
  }

  function closeUtilityModal(modal){
    if(!modal) return;
    modal.classList.remove('show');
    modal.style.removeProperty('opacity');
    modal.style.removeProperty('visibility');
    modal.style.removeProperty('pointer-events');
  }

  function openUtilityModal(modal, forceRefresh = true){
    if(!modal) return;
    renderUtilityLists();
    modal.classList.add('show');
    modal.style.setProperty('opacity','1','important');
    modal.style.setProperty('visibility','visible','important');
    modal.style.setProperty('pointer-events','auto','important');
    if(forceRefresh) refreshHistoryTables(true);
  }

  function handleUtilityButton(event, key, modal){
    event.preventDefault();
    event.stopPropagation();
    if(typeof event.stopImmediatePropagation === 'function') event.stopImmediatePropagation();
    if(isDuplicateUtilityPress(key, event.type)) return;
    openUtilityModal(modal, true);
  }

  function bindUtilityMenus(){
    [
      [btnUsers, 'users', modalUsers],
      [btnHistory, 'history', modalHistory],
      [btnRecent, 'recent', modalRecent],
    ].forEach(([button, key, modal]) => {
      if(!button || button.dataset.teenUtilityBound === '1') return;
      button.dataset.teenUtilityBound = '1';
      button.addEventListener('pointerup', (event) => handleUtilityButton(event, key, modal), true);
      button.addEventListener('click', (event) => handleUtilityButton(event, key, modal), true);
    });
    [modalUsers, modalHistory, modalRecent].forEach((modal) => {
      if(!modal || modal.dataset.teenUtilityCloseBound === '1') return;
      modal.dataset.teenUtilityCloseBound = '1';
      modal.querySelectorAll('.close-modal-btn').forEach((button) => {
        button.addEventListener('click', (event) => {
          event.preventDefault();
          event.stopPropagation();
          closeUtilityModal(modal);
        });
      });
      modal.addEventListener('click', (event) => {
        if(event.target === modal) closeUtilityModal(modal);
      });
    });
  }

  function applyState(payload){
    markAuthoritativeLoaded();
    syncVisibleState(payload);
    activePlayerRows = Array.isArray(payload && payload.active_players) ? payload.active_players : activePlayerRows;
    renderUtilityLists();
    setTimer(payload);
    setPhase(payload.phase, payload);
    if(payload.phase === 'settled'){
      const historyRound = String(payload.round_no || '');
      if(historyRound && historyRound !== lastHistorySyncRound){
        lastHistorySyncRound = historyRound;
        refreshHistoryTables();
      }
    } else if(payload.phase === 'betting') {
      lastHistorySyncRound = '';
    }
    const phaseKey = `${payload.round_no || 'na'}:${payload.phase || 'na'}`;
    const phaseChanged = phaseKey !== lastPhaseKey;
    lastPhaseKey = phaseKey;
    if(typeof window.syncTeenPattiRoomMusic === 'function') window.syncTeenPattiRoomMusic(payload.phase);
    if(phaseChanged && typeof window.playTeenPattiPhaseFx === 'function') window.playTeenPattiPhaseFx(payload.phase);
    if(phaseChanged && payload.phase !== 'revealed' && payload.phase !== 'settled') {
      clearLegacyOverlays();
    }
    if(phaseChanged) {
      const winner = payload && (payload.winner_board || (payload.result && payload.result.winner_board));
      const bannerText = payload.phase === 'betting'
        ? `BET ${currentDistinctBoardCount(payload)}/${maxDistinctBoards(payload)} BOARDS`
        : payload.phase === 'locked'
          ? 'STOP BET'
          : payload.phase === 'revealed'
            ? 'CARD REVEAL'
            : payload.phase === 'settled'
              ? (winner ? 'PAYOUT' : 'RESULT')
            : 'READY';
      animatePhaseBanner(bannerText);
    }
    if(payload.phase === 'betting' && phaseChanged) {
      scheduleStartPopup(payload);
    } else if(payload.phase === 'locked' && phaseChanged) {
      scheduleStopPopup(payload);
    }
    if(payload.phase === 'revealed') {
      scheduleRevealStage(payload);
    } else if(payload.phase === 'settled') {
      if(winnerEffectsReady(payload)) {
        renderResult(payload);
      } else {
        scheduleRevealStage(payload);
      }
      scheduleSettlementStage(payload);
    } else if(phaseBanner && !phaseBanner.textContent) {
      phaseBanner.textContent = payload.phase === 'betting' ? 'BETTING OPEN' : payload.phase === 'locked' ? 'STOP BET' : 'READY';
    }
  }

  function isSuppressedTeenNetworkNotice(message){
    const normalized = String(message || '').trim().toUpperCase();
    return normalized === 'NETWORK CONNECTION LOST'
      || normalized === 'NETWORK RECONNECTED'
      || normalized === 'NETWORK RECONNECTING...'
      || normalized === 'RECONNECTED. ROUND SYNCED.';
  }

  function showToast(message, type = 'warn'){
    if(isSuppressedTeenNetworkNotice(message)){
      if(messageBanner) messageBanner.classList.remove('show');
      return;
    }
    if(messageBanner){
      const kind = type === 'good' || type === 'win' ? 'good' : type === 'error' ? 'error' : 'warn';
      const meta = kind === 'good'
        ? { icon: '✓', title: 'NOTICE' }
        : kind === 'error'
          ? { icon: '⛔', title: 'ALERT' }
          : { icon: '⚠', title: 'NOTICE' };
      reviveAnimatedNode(messageBanner);
      messageBanner.innerHTML = `<div class="message-banner-icon" aria-hidden="true">${meta.icon}</div><div class="message-banner-copy"><div class="message-banner-title">${meta.title}</div><div class="message-banner-text">${message}</div></div>`;
      messageBanner.classList.remove('good','warn','error','show');
      void messageBanner.offsetWidth;
      messageBanner.classList.add(kind, 'show');
      if(bridgeToastTimer) window.clearTimeout(bridgeToastTimer);
      bridgeToastTimer = window.setTimeout(() => messageBanner.classList.remove('show'), 1400);
      return;
    }
    if(!toast) return;
    reviveAnimatedNode(toast);
    toast.textContent = message;
    toast.classList.add('show');
    window.setTimeout(() => toast.classList.remove('show'), 900);
  }

  function mapBetError(message){
    const map = {
      invalid_session: 'Session expired. Rejoin the room.',
      bet_closed: 'Bet closed. Wait for next round.',
      insufficient_balance: 'Insufficient balance',
      duplicate_request: 'Duplicate bet ignored',
      max_distinct_board_limit: 'All boards already used',
      max_pot_reached: 'Max pot reached',
      bet_amount_out_of_range: 'Bet amount out of range',
      invalid_board: 'Invalid board',
      http_429: 'Too many taps. Wait a moment.',
      request_failed: 'Network issue. Try again.',
      timeout: 'Network timeout. Try again.'
    };
    return map[message] || 'Bet failed. Try again.';
  }

  async function refreshState(){
    if(disposed || refreshInFlight) return;
    refreshInFlight = true;
    const startedAt = performance.now();
    try {
      const payload = await api.get(window.BD_GAME_BOOTSTRAP.endpoints.state, {});
      lastNetworkMs = Math.max(1, Math.round(performance.now() - startedAt));
      const networkText = `${lastNetworkMs}ms`;
      setNetwork(lastNetworkMs < 400 ? 'good' : 'warn', networkText);
      if(payload && payload.st && shouldApplyPayload(payload)){
        if(reconnectPending) {
          reconnectPending = false;
          showToast('Reconnected. Round synced.');
        }
        applyState(payload);
        return payload;
      } else {
        setNetwork('bad', networkText);
        return payload || null;
      }
    } catch (error) {
      setNetwork('bad', lastNetworkMs ? `${lastNetworkMs}ms` : '--');
      return null;
    } finally {
      refreshInFlight = false;
    }
  }

  async function submitBet(boardKey){
    if(disposed) return;
    try {
      let betState = lastStatePayload;
      if(!authoritativeRoundNo || stateNeedsBetRefresh(betState)) {
        showToast('Syncing round...');
        betState = await getFreshBetState();
      }
      if(!betState || !betState.round_no) {
        showToast('Round sync failed. Try again.');
        return;
      }
      if(betState.phase !== 'betting' || bettingWindowRemainingMs(betState) <= 0) {
        showToast('Wait for next bid window.');
        return;
      }
      const boardConfig = Array.isArray(betState.boards) ? betState.boards.find((entry) => String(entry.canonical_key || entry.frontend_key) === String(boardKey)) : null;
      if(boardConfig && Object.prototype.hasOwnProperty.call(boardConfig, 'is_active') && !Number(boardConfig.is_active)) {
        showToast('Board unavailable.');
        return;
      }
      if(!canUseBoard(betState, boardKey)) {
        showToast(boardLimitMessage(betState));
        return;
      }
      const amount = activeChipValue();
      if(!hasBalanceForBet(betState, amount)) {
        showToast(insufficientBalanceMessage(betState, amount), 'error');
        refreshState();
        return;
      }
      markPendingBoard(boardKey, 1);
      animateAcceptedBet(boardKey, amount);
      const optimisticPayload = optimisticBetPayload(betState, boardKey, amount);
      if(optimisticPayload) applyState(optimisticPayload);
      const response = await api.post(window.BD_GAME_BOOTSTRAP.endpoints.bet, {
        round_no: betState.round_no,
        board_key: boardKey,
        amount: amount,
        request_uid: `teen-patti-${Date.now()}-${++requestCounter}-${boardKey}`
      });
      if(response && response.st){
        if(response.balance !== undefined && lastStatePayload){
          const balancePayload = Object.assign({}, lastStatePayload, { balance: Number(response.balance || 0) });
          syncVisibleState(balancePayload);
        }
        window.setTimeout(() => {
          refreshState();
          refreshHistoryTables(true);
        }, 60);
        return;
      }
      refreshState();
      showToast(mapBetError(response && (response.msg || response.error)));
    } finally {
      markPendingBoard(boardKey, -1);
      if(lastStatePayload) syncVisibleState(lastStatePayload);
    }
  }

  let lastBoardPressKey = '';
  let lastBoardPressAt = 0;
  function isSyntheticBoardClick(boardKey, eventType){
    const now = Date.now();
    if(eventType === 'click' && lastBoardPressKey === boardKey && now - lastBoardPressAt < 350) return true;
    lastBoardPressKey = boardKey;
    lastBoardPressAt = now;
    return false;
  }

  function handleBoardClick(event){
    if(disposed) return;
    const board = event.target.closest('.board[data-board]');
    if(!board) return;
    if(event.type === 'pointerup' && event.pointerType === 'mouse' && event.button !== 0) return;
    if(isSyntheticBoardClick(board.dataset.board, event.type)){
      event.preventDefault();
      return;
    }
    event.preventDefault();
    event.stopPropagation();
    if(typeof event.stopImmediatePropagation === 'function') event.stopImmediatePropagation();
    submitBet(board.dataset.board);
  }

  ensureActiveChip();
  bindUtilityMenus();
  chipNodes.forEach((chip) => {
    chip.addEventListener('click', function(event){
      event.preventDefault();
      event.stopPropagation();
      if(typeof event.stopImmediatePropagation === 'function') event.stopImmediatePropagation();
      if(!chip.classList.contains('live')) return;
      setActiveChip(chip);
      if(lastStatePayload) syncVisibleState(lastStatePayload);
      if(typeof window.playTeenPattiFx === 'function') window.playTeenPattiFx('tap');
    });
  });

  document.addEventListener('pointerup', handleBoardClick, true);
  document.addEventListener('click', handleBoardClick, true);

  api.onState(function(payload){
    if(disposed || !(payload && payload.st) || !shouldApplyPayload(payload)) return;
    applyState(payload);
  });

  if(typeof api.onConnection === 'function') {
    api.onConnection(function(detail){
      if(disposed || !detail) return;
      if(detail.status === 'error') {
        reconnectPending = true;
        setNetwork('bad', lastNetworkMs ? `${lastNetworkMs}ms` : '--');
        if(typeof window.stopTeenPattiRoomMusic === 'function') window.stopTeenPattiRoomMusic();
        if(typeof window.playTeenPattiFx === 'function') window.playTeenPattiFx('network');
        showToast('Network reconnecting...');
      }
      if(detail.status === 'ok' && reconnectPending) {
        if(typeof window.setTeenPattiAudioNetworkStatus === 'function') window.setTeenPattiAudioNetworkStatus('warn');
        refreshState();
      }
      if(detail.status === 'expired') {
        setNetwork('bad', 'expired');
        if(typeof window.stopTeenPattiRoomMusic === 'function') window.stopTeenPattiRoomMusic();
        showToast('Session expired. Rejoin room.');
      }
    });
  }

  function disposeAuthoritativeTeenPatti(){
    if(disposed) return;
    disposed = true;
    if(typeof window.silenceTeenRoomAudio === 'function') window.silenceTeenRoomAudio(true);
    clearWinnerCelebration();
    hideResultPopups();
    if(typeof api.stopHeartbeat === 'function') api.stopHeartbeat();
    if(pollTimer) clearInterval(pollTimer);
    if(heartbeatTimer) clearInterval(heartbeatTimer);
    if(mirrorTimer) clearInterval(mirrorTimer);
    if(timerRafId) cancelAnimationFrame(timerRafId);
    pollTimer = null;
    heartbeatTimer = null;
    mirrorTimer = null;
    timerRafId = null;
    document.removeEventListener('pointerup', handleBoardClick, true);
    document.removeEventListener('click', handleBoardClick, true);
  }

  document.addEventListener('visibilitychange', function(){
    if(document.hidden){
      if(typeof window.silenceTeenRoomAudio === 'function') window.silenceTeenRoomAudio(false);
      return;
    }
    if(!disposed && typeof window.syncTeenPattiRoomMusic === 'function') window.syncTeenPattiRoomMusic(lastStatePayload && lastStatePayload.phase);
  });
  window.addEventListener('pagehide', disposeAuthoritativeTeenPatti, { once: true });
  window.addEventListener('beforeunload', disposeAuthoritativeTeenPatti, { once: true });

  if(pollTimer) clearInterval(pollTimer);
  pollTimer = setInterval(function(){
    if(disposed || refreshInFlight || document.hidden) return;
    const silenceMs = Date.now() - lastStateReceivedAt;
    if(!lastStatePayload || reconnectPending || silenceMs >= controllerWatchdogMs){
      refreshState();
    }
  }, controllerWatchdogMs);
  if(heartbeatTimer) clearInterval(heartbeatTimer);
  if(typeof api.startHeartbeat === 'function'){
    api.startHeartbeat(15000, function(){ return lastNetworkMs || 0; });
    heartbeatTimer = null;
  } else {
    heartbeatTimer = setInterval(function(){
      if(typeof api.heartbeat === 'function') api.heartbeat(lastNetworkMs || 0);
      else api.post(window.BD_GAME_BOOTSTRAP.endpoints.heartbeat, { network_ms: lastNetworkMs || 0 });
    }, 15000);
  }
  if(mirrorTimer) clearInterval(mirrorTimer);
  mirrorTimer = null;
  if(timerRafId) cancelAnimationFrame(timerRafId);
  (function tickAuthoritativeTimer(){
    if(disposed) return;
    if(lastStatePayload) setTimer(lastStatePayload);
    timerRafId = window.requestAnimationFrame(tickAuthoritativeTimer);
  })();
  renderUtilityLists();
  refreshHistoryTables(true);
  refreshState();
})();
</script>
<script>
(function(){
  const popup = document.getElementById('audioPopup');
  const overlay = document.getElementById('audioPopupOverlay');
  const openBtn = document.getElementById('btnSettings');
  const closeBtn = document.getElementById('closeAudioPopup');
  const toggles = Array.from(document.querySelectorAll('#audioPopup [data-audio]'));
  const gameCode = (window.BD_GAME_BOOTSTRAP && window.BD_GAME_BOOTSTRAP.gameCode) || 'teen_patti';
  const storageKey = gameCode === 'teen_patti' ? 'tp_prefs' : `tp_prefs_${gameCode}`;

  function readPrefs(){
    try {
      const saved = JSON.parse(window.localStorage.getItem(storageKey) || '{}');
      return { music: saved.music !== false, sound: saved.sound !== false, voice: saved.voice !== false };
    } catch (error) {
      return { music: true, sound: true, voice: true };
    }
  }

  function writePrefs(prefs){
    window.localStorage.setItem(storageKey, JSON.stringify(prefs));
  }

  function sync(){
    const prefs = readPrefs();
    toggles.forEach((toggle) => {
      const key = toggle.dataset.audio;
      const on = prefs[key] !== false;
      toggle.classList.toggle('on', on);
      toggle.setAttribute('aria-pressed', on ? 'true' : 'false');
    });
  }

  function show(){
    sync();
    popup?.classList.add('show');
    overlay?.classList.add('show');
    popup?.setAttribute('aria-hidden', 'false');
  }

  function hide(){
    popup?.classList.remove('show');
    overlay?.classList.remove('show');
    popup?.setAttribute('aria-hidden', 'true');
  }

  window.openTeenPattiSettings = function(event){
    if(event) {
      event.preventDefault();
      event.stopPropagation();
    }
    show();
    return false;
  };
  window.closeTeenPattiSettings = hide;

  openBtn?.addEventListener('click', window.openTeenPattiSettings, true);
  openBtn?.addEventListener('pointerup', window.openTeenPattiSettings, true);
  closeBtn?.addEventListener('click', hide);
  overlay?.addEventListener('click', hide);
  document.addEventListener('keydown', function(event){
    if(event.key === 'Escape' && popup?.classList.contains('show')) hide();
  });
  sync();
  popup?.setAttribute('aria-hidden', 'true');
})();
</script>

</body>
</html>

