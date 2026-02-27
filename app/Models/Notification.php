<?php

declare(strict_types=1);

namespace App\Models;

final class Notification extends BaseModel
{
    public function unreadByUser(int $userId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM notifications WHERE user_id = :user_id AND read_at IS NULL ORDER BY created_at DESC LIMIT 20');
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll();
    }
}
