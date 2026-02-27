<?php

declare(strict_types=1);

namespace App\Core;

final class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        session_name((string) Config::get('session.name'));
        session_set_cookie_params([
            'lifetime' => (int) Config::get('session.lifetime'),
            'path' => '/',
            'secure' => (bool) Config::get('session.secure'),
            'httponly' => (bool) Config::get('session.http_only'),
            'samesite' => (string) Config::get('session.same_site'),
        ]);

        session_start();
    }

    public static function regenerate(): void
    {
        session_regenerate_id(true);
    }

    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }
}
