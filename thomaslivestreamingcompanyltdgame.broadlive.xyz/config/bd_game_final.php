<?php

$teenPattiBoards = [
    ['frontend_key' => 'A', 'canonical_key' => 'A', 'aliases' => ['board_a'], 'multiplier' => 3, 'display_name' => 'A'],
    ['frontend_key' => 'B', 'canonical_key' => 'B', 'aliases' => ['board_b'], 'multiplier' => 3, 'display_name' => 'B'],
    ['frontend_key' => 'C', 'canonical_key' => 'C', 'aliases' => ['board_c'], 'multiplier' => 3, 'display_name' => 'C'],
];

$lucky77Boards = [
    ['frontend_key' => 'melon', 'canonical_key' => 'melon', 'aliases' => ['left'], 'multiplier' => 2, 'display_name' => 'Melon'],
    ['frontend_key' => 'slot', 'canonical_key' => 'slot', 'aliases' => ['center', '77'], 'multiplier' => 7, 'display_name' => '77'],
    ['frontend_key' => 'plum', 'canonical_key' => 'plum', 'aliases' => ['right'], 'multiplier' => 2, 'display_name' => 'Plum'],
];

$lucky88Boards = [
    ['frontend_key' => 'melon', 'canonical_key' => 'melon', 'aliases' => ['left'], 'multiplier' => 2, 'display_name' => 'Melon'],
    ['frontend_key' => 'slot', 'canonical_key' => 'slot', 'aliases' => ['center', '77', '88'], 'multiplier' => 7, 'display_name' => '88'],
    ['frontend_key' => 'plum', 'canonical_key' => 'plum', 'aliases' => ['right'], 'multiplier' => 2, 'display_name' => 'Plum'],
];

$fruitSlotBoards = [
    ['frontend_key' => 'apple', 'canonical_key' => 'apple', 'aliases' => [], 'multiplier' => 5, 'display_name' => 'Apple'],
    ['frontend_key' => 'watermelon', 'canonical_key' => 'watermelon', 'aliases' => [], 'multiplier' => 45, 'display_name' => 'Watermelon'],
    ['frontend_key' => 'cherry', 'canonical_key' => 'cherry', 'aliases' => [], 'multiplier' => 25, 'display_name' => 'Cherry'],
    ['frontend_key' => 'banana', 'canonical_key' => 'banana', 'aliases' => [], 'multiplier' => 5, 'display_name' => 'Banana'],
    ['frontend_key' => 'grapes', 'canonical_key' => 'grapes', 'aliases' => [], 'multiplier' => 15, 'display_name' => 'Grapes'],
    ['frontend_key' => 'orange', 'canonical_key' => 'orange', 'aliases' => [], 'multiplier' => 5, 'display_name' => 'Orange'],
    ['frontend_key' => 'mango', 'canonical_key' => 'mango', 'aliases' => [], 'multiplier' => 5, 'display_name' => 'Mango'],
    ['frontend_key' => 'pineapple', 'canonical_key' => 'pineapple', 'aliases' => [], 'multiplier' => 10, 'display_name' => 'Pineapple'],
];

$fruitsLoopBoards = [
    ['frontend_key' => 'apple', 'canonical_key' => 'apple', 'aliases' => ['left', 'red'], 'multiplier' => 3, 'display_name' => 'Apple'],
    ['frontend_key' => 'orange', 'canonical_key' => 'orange', 'aliases' => ['center', 'gold'], 'multiplier' => 3, 'display_name' => 'Orange'],
    ['frontend_key' => 'grapes', 'canonical_key' => 'grapes', 'aliases' => ['right', 'purple'], 'multiplier' => 3, 'display_name' => 'Grapes'],
];

$fruitsLoopCherryBoards = [
    ['frontend_key' => 'cherry', 'canonical_key' => 'cherry', 'aliases' => ['left', 'red'], 'multiplier' => 3, 'display_name' => 'Cherry'],
    ['frontend_key' => 'pineapple', 'canonical_key' => 'pineapple', 'aliases' => ['center', 'gold', 'yellow'], 'multiplier' => 3, 'display_name' => 'Pineapple'],
    ['frontend_key' => 'grapes', 'canonical_key' => 'grapes', 'aliases' => ['right', 'purple', 'green'], 'multiplier' => 3, 'display_name' => 'Grapes'],
];

$threeBoardDefaults = [
    'bet_duration_sec' => 20,
    'start_bet_popup_sec' => 3,
    'start_bet_wait_sec' => 1.5,
    'stop_bet_popup_sec' => 3,
    'stop_bet_wait_sec' => 1.5,
    'stop_duration_sec' => 4.5,
    'reveal_duration_sec' => 6,
    'reveal_wait_sec' => 2,
    'winner_popup_sec' => 1,
    'winner_wait_sec' => 0.5,
    'settle_duration_sec' => 2.5,
    'settle_wait_sec' => 1,
    'max_distinct_boards_per_user' => 3,
];

$fruitSlotDefaults = [
    'bet_duration_sec' => 30,
    'start_bet_popup_sec' => 3,
    'start_bet_wait_sec' => 1.5,
    'stop_bet_popup_sec' => 3,
    'stop_bet_wait_sec' => 1.5,
    'stop_duration_sec' => 4.5,
    'reveal_duration_sec' => 6,
    'reveal_wait_sec' => 2,
    'winner_popup_sec' => 1,
    'winner_wait_sec' => 0.5,
    'settle_duration_sec' => 2.5,
    'settle_wait_sec' => 1,
    'max_distinct_boards_per_user' => 8,
];

$games = [];

foreach ([
    'teen_patti' => 'Teen Patti',
    'teen_patti_king' => 'TeenPatti King',
    'teen_patti_sultan' => 'TeenPatti Sultan',
    'teen_patti_warfront' => 'TeenPatti Warfront',
    'teen_patti_neon' => 'TeenPatti Neon Blitz',
    'teen_patti_shogun' => 'TeenPatti Shogun',
    'teen_patti_glacier' => 'TeenPatti Glacier',
] as $gameCode => $name) {
    $games[$gameCode] = array_merge(['name' => $name], $threeBoardDefaults, ['boards' => $teenPattiBoards]);
}

foreach ([
    'lucky77' => 'Lucky 77',
    'lucky77_max' => 'BD Lucky 77 Max',
    'lucky7_pro' => 'Lucky 7 Pro',
    'lucky77_mirage' => 'Lucky 77 Mirage',
    'lucky77_ironfront' => 'Lucky 77 Iron Front',
    'lucky77_lotus' => 'Lucky 77 Lotus',
    'lucky77_nebula' => 'Lucky 77 Nebula',
    'lucky77_carnival' => 'Lucky 77 Carnival',
] as $gameCode => $name) {
    $games[$gameCode] = array_merge(['name' => $name], $threeBoardDefaults, ['boards' => $lucky77Boards]);
}

$games['lucky88_master'] = array_merge(['name' => 'Lucky 88 Master'], $threeBoardDefaults, ['boards' => $lucky88Boards]);

foreach ([
    'fruit_slot' => 'Fruit Slot',
    'fruit_slot_oasis' => 'Fruit Slot Oasis',
    'fruit_slot_arsenal' => 'Fruit Slot Arsenal',
    'fruit_slot_arcade' => 'Fruit Slot Neon Arcade',
    'fruit_slot_lotus' => 'Fruit Slot Lotus Garden',
    'fruit_slot_glacier' => 'Fruit Slot Glacier Spin',
] as $gameCode => $name) {
    $games[$gameCode] = array_merge(['name' => $name], $fruitSlotDefaults, ['boards' => $fruitSlotBoards]);
}

$games['greedy'] = array_merge(['name' => 'Greedy'], $fruitSlotDefaults, ['boards' => $fruitSlotBoards]);

$games['fruits_loop'] = array_merge(['name' => 'Fruits Loop'], $threeBoardDefaults, [
    'bet_duration_sec' => 20,
    'max_distinct_boards_per_user' => 2,
    'boards' => $fruitsLoopBoards,
    'wheel_order' => ['apple', 'orange', 'grapes', 'apple', 'orange', 'grapes'],
    'ui_variant' => 'classic',
]);

$games['fruits_loop_ruby'] = array_merge(['name' => 'Fruits Loop Ruby'], $threeBoardDefaults, [
    'bet_duration_sec' => 20,
    'max_distinct_boards_per_user' => 2,
    'boards' => $fruitsLoopCherryBoards,
    'wheel_order' => ['pineapple', 'cherry', 'grapes', 'pineapple', 'cherry', 'grapes'],
    'ui_variant' => 'ruby',
]);

$games['fruits_loop_emerald'] = array_merge(['name' => 'Fruits Loop Emerald'], $threeBoardDefaults, [
    'bet_duration_sec' => 20,
    'max_distinct_boards_per_user' => 2,
    'boards' => $fruitsLoopCherryBoards,
    'wheel_order' => ['cherry', 'pineapple', 'grapes', 'cherry', 'pineapple', 'grapes'],
    'ui_variant' => 'emerald',
]);

return [
    'route_prefix' => 'game',
    'api_prefix' => 'game/api',

    'require_entry_token' => true,
    'allow_auth_fallback_entry' => false,
    'allow_url_entry_tokens' => env('BD_GAME_FINAL_ALLOW_URL_ENTRY_TOKENS', false),
    'allow_api_token_issue_entry' => true,
    'allow_direct_api_token_entry' => false,
    'allow_user_id_issue_token' => false,
    'allow_app_access_entry' => false,
    'auto_start_to_play_enabled' => true,

    'game_policy_mode' => env('BD_GAME_FINAL_POLICY_MODE', 'fair_publish'),
    'enable_standalone_preview' => false,

    'admin_security' => [
        'secret' => env('BD_GAME_FINAL_ADMIN_SECURITY_SECRET', ''),
        'secret_hash' => env('BD_GAME_FINAL_ADMIN_SECURITY_SECRET_HASH', ''),
        'session_ttl_seconds' => (int) env('BD_GAME_FINAL_ADMIN_SECURITY_SESSION_TTL', 1800),
        'max_attempts' => (int) env('BD_GAME_FINAL_ADMIN_SECURITY_MAX_ATTEMPTS', 5),
        'lockout_seconds' => (int) env('BD_GAME_FINAL_ADMIN_SECURITY_LOCKOUT_SECONDS', 900),
    ],

    'entry_token_ttl_seconds' => (int) env('BD_GAME_FINAL_ENTRY_TOKEN_TTL_SECONDS', 90),
    'session_ttl_seconds' => (int) env('BD_GAME_FINAL_SESSION_TTL_SECONDS', 18000),

    'wallet_model' => \App\Models\User::class,
    'wallet_column' => 'balance',
    'api_token_column' => 'api_token',
    'shared_game_balance' => true,

    'cache' => [
        'enabled' => env('BD_GAME_FINAL_CACHE_ENABLED', true),
        'store' => env('BD_GAME_FINAL_CACHE_STORE', env('CACHE_DRIVER', 'file')),
        'prefix' => env('BD_GAME_FINAL_CACHE_PREFIX', 'bdgf:v7:'),
        'public_state_ttl_seconds' => (int) env('BD_GAME_FINAL_CACHE_TTL_SECONDS', 2),
    ],

    'security' => [
        'client_cookie_name' => env('BD_GAME_FINAL_CLIENT_COOKIE_NAME', 'bdgf_client'),
        'client_cookie_ttl_minutes' => (int) env('BD_GAME_FINAL_CLIENT_COOKIE_TTL_MINUTES', 43200),
        'single_active_entry_token_per_user' => env('BD_GAME_FINAL_SINGLE_ACTIVE_ENTRY_TOKEN_PER_USER', true),
        'single_active_session_per_user' => env('BD_GAME_FINAL_SINGLE_ACTIVE_SESSION_PER_USER', true),
        'inactive_penalty_enabled' => env('BD_GAME_FINAL_INACTIVE_PENALTY_ENABLED', true),
        'inactive_penalty_threshold_seconds' => (int) env('BD_GAME_FINAL_INACTIVE_PENALTY_THRESHOLD_SECONDS', 25),
        'client_security_hooks' => env('BD_GAME_FINAL_CLIENT_SECURITY_HOOKS', true),
        'watermark_enabled' => env('BD_GAME_FINAL_WATERMARK_ENABLED', true),
        'watermark_text_prefix' => env('BD_GAME_FINAL_WATERMARK_TEXT_PREFIX', 'ID'),
        'request_timeout_ms' => (int) env('BD_GAME_FINAL_REQUEST_TIMEOUT_MS', 10000),
        'rate_limits' => [
            'admin_auth_per_minute' => (int) env('BD_GAME_FINAL_RATE_ADMIN_AUTH_PER_MINUTE', 12),
            'lobby_per_minute' => (int) env('BD_GAME_FINAL_RATE_LOBBY_PER_MINUTE', 90),
            'entry_view_per_minute' => (int) env('BD_GAME_FINAL_RATE_ENTRY_VIEW_PER_MINUTE', 120),
            'start_per_minute' => (int) env('BD_GAME_FINAL_RATE_START_PER_MINUTE', 60),
            'auth_per_minute' => (int) env('BD_GAME_FINAL_RATE_AUTH_PER_MINUTE', 30),
            'state_per_minute' => (int) env('BD_GAME_FINAL_RATE_STATE_PER_MINUTE', 240),
            'bet_per_minute' => (int) env('BD_GAME_FINAL_RATE_BET_PER_MINUTE', 120),
            'heartbeat_per_minute' => (int) env('BD_GAME_FINAL_RATE_HEARTBEAT_PER_MINUTE', 240),
            'history_per_minute' => (int) env('BD_GAME_FINAL_RATE_HISTORY_PER_MINUTE', 120),
            'security_report_per_minute' => (int) env('BD_GAME_FINAL_RATE_SECURITY_REPORT_PER_MINUTE', 30),
        ],
    ],

    'realtime' => [
        'mode' => env('BD_GAME_FINAL_REALTIME_MODE', env('BD_GAME_FINAL_REALTIME_ENABLED', false) ? 'pusher' : 'polling'),
        'enabled' => env('BD_GAME_FINAL_REALTIME_ENABLED', false),
        'channel_prefix' => 'bdgamefinal.',
        'broadcast_event' => 'bd.game.state',
        'broadcast_now' => true,
        'poll_fallback_ms' => (int) env('BD_GAME_FINAL_POLL_FALLBACK_MS', 1500),
        'config_version' => 1,
        'config_updated_at' => null,
        'pusher' => [
            'key_env' => 'PUSHER_APP_KEY',
            'cluster_env' => 'PUSHER_APP_CLUSTER',
            'wsHost_env' => 'PUSHER_HOST',
            'wsPort_env' => 'PUSHER_PORT',
            'wssPort_env' => 'PUSHER_PORT',
            'forceTLS' => env('BD_GAME_FINAL_PUSHER_FORCE_TLS', env('PUSHER_SCHEME', 'https') === 'https'),
            'encrypted' => env('BD_GAME_FINAL_PUSHER_ENCRYPTED', env('PUSHER_SCHEME', 'https') === 'https'),
            'enabledTransports' => array_values(array_filter(array_map('trim', explode(',', (string) env('BD_GAME_FINAL_PUSHER_TRANSPORTS', 'ws,wss'))))),
        ],
        'websocket' => [
            'enabled' => (bool) env('BD_GAME_FINAL_WEBSOCKET_ENABLED', true),
            'url_env' => 'BD_GAME_FINAL_WEBSOCKET_URL',
            'url' => env('BD_GAME_FINAL_WEBSOCKET_URL', ''),
            'event' => env('BD_GAME_FINAL_WEBSOCKET_EVENT', 'bd.game.state'),
            'protocols' => array_values(array_filter(array_map('trim', explode(',', (string) env('BD_GAME_FINAL_WEBSOCKET_PROTOCOLS', ''))))),
        ],
    ],

    'jobs' => [
        'dispatch_via_queue' => env('BD_GAME_FINAL_DISPATCH_VIA_QUEUE', false),
        'queue' => env('BD_GAME_FINAL_QUEUE', 'default'),
        'watch_sleep_seconds' => (int) env('BD_GAME_FINAL_WATCH_SLEEP_SECONDS', 1),
    ],

    'cron' => [
        'enabled' => env('BD_GAME_FINAL_CRON_ENABLED', true),
    ],

    'maintenance' => [
        'allowed_user_ids' => json_decode((string) env('BD_GAME_FINAL_MAINTENANCE_ALLOWED_USER_IDS', '{}'), true) ?: [],
    ],

    'tables' => [
        'games' => 'bd_game_final_games',
        'boards' => 'bd_game_final_boards',
        'settings' => 'bd_game_final_settings',
        'rounds' => 'bd_game_final_rounds',
        'bets' => 'bd_game_final_bets',
        'bet_summaries' => 'bd_game_final_bet_summaries',
        'settlements' => 'bd_game_final_settlements',
        'settlement_items' => 'bd_game_final_settlement_items',
        'tokens' => 'bd_game_final_tokens',
        'heartbeats' => 'bd_game_final_heartbeats',
        'wallet_journals' => 'bd_game_final_wallet_journals',
        'audit_logs' => 'bd_game_final_audit_logs',
    ],

    'user_rules' => [
        'block_if_lock_brd_entry' => true,
        'block_if_banned' => true,
        'block_if_device_banned' => true,
        'require_active_status' => false,
        'active_status_values' => [1, '1', 'active'],
    ],

    'games' => $games,
];

