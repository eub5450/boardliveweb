<?php

$allowAll = (bool) env('CORS_ALLOW_ALL', false);

$allowedOrigins = array_values(array_filter(array_map('trim', explode(',', (string) env('CORS_ALLOWED_ORIGINS', 'http://localhost,http://127.0.0.1,http://localhost:8000,http://127.0.0.1:8000')))));
$allowedMethods = array_values(array_filter(array_map('trim', explode(',', (string) env('CORS_ALLOWED_METHODS', 'GET,POST,OPTIONS')))));
$allowedHeaders = array_values(array_filter(array_map('trim', explode(',', (string) env('CORS_ALLOWED_HEADERS', 'Accept,Content-Type,Origin,X-Requested-With,X-Api-Token,X-Game-Session,X-Request-Id,Idempotency-Key,Authorization')))));

if ($allowAll) {
    $allowedOrigins = ['*'];
    $allowedMethods = ['*'];
    $allowedHeaders = ['*'];
}

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'game/api/*'],
    'allowed_methods' => $allowedMethods,
    'allowed_origins' => $allowedOrigins,
    'allowed_origins_patterns' => [],
    'allowed_headers' => $allowedHeaders,
    'exposed_headers' => [],
    'max_age' => (int) env('CORS_MAX_AGE', 0),
    'supports_credentials' => (bool) env('CORS_SUPPORTS_CREDENTIALS', false),
];
