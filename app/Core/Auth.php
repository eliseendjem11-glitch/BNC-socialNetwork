<?php

declare(strict_types=1);

namespace App\Core;

use App\Models\User;

final class Auth
{
    public static function user(): ?array
    {
        $id = Session::get('user_id');
        if (!$id) {
            return null;
        }

        return (new User())->findById((int) $id);
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function requireRole(array $roles): void
    {
        $user = self::user();
        if (!$user || !in_array($user['role'], $roles, true)) {
            http_response_code(403);
            exit('Access denied');
        }
    }
}
