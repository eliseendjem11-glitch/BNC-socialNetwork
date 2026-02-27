<?php

declare(strict_types=1);

namespace App\Models;

final class Connection extends BaseModel
{
    public function suggestions(int $userId): array
    {
        $sql = 'SELECT u.id, u.email, p.slug, p.headline
                FROM users u
                JOIN profiles p ON p.user_id = u.id
                WHERE u.id != :user_id
                AND u.id NOT IN (
                    SELECT connected_user_id FROM connections WHERE user_id = :user_id
                    UNION
                    SELECT user_id FROM connections WHERE connected_user_id = :user_id
                )
                LIMIT 10';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll();
    }
}
