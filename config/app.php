<?php

use App\Core\Env;

return [
    'app' => [
        'name' => Env::get('APP_NAME', 'BNC Social Network'),
        'env' => Env::get('APP_ENV', 'production'),
        'debug' => Env::bool('APP_DEBUG', false),
        'url' => Env::get('APP_URL', 'http://localhost:8000'),
        'key' => Env::get('APP_KEY', ''),
    ],
    'db' => [
        'host' => Env::get('DB_HOST', '127.0.0.1'),
        'port' => Env::get('DB_PORT', '3306'),
        'name' => Env::get('DB_NAME', ''),
        'user' => Env::get('DB_USER', ''),
        'pass' => Env::get('DB_PASS', ''),
    ],
    'session' => [
        'name' => Env::get('SESSION_NAME', 'bnc_session'),
        'lifetime' => (int) Env::get('SESSION_LIFETIME', 7200),
        'secure' => Env::bool('SESSION_SECURE', false),
        'http_only' => Env::bool('SESSION_HTTP_ONLY', true),
        'same_site' => Env::get('SESSION_SAME_SITE', 'Lax'),
    ],
];
