<?php

declare(strict_types=1);

namespace App\Models;

final class Post extends BaseModel
{
    public function create(int $userId, string $content, ?string $imagePath, string $visibility): void
    {
        $stmt = $this->db->prepare('INSERT INTO posts (user_id, content, image_path, visibility, created_at, updated_at) VALUES (:user_id,:content,:image_path,:visibility,NOW(),NOW())');
        $stmt->execute([
            ':user_id' => $userId,
            ':content' => $content,
            ':image_path' => $imagePath,
            ':visibility' => $visibility,
        ]);
    }

    public function feed(int $userId, int $limit = 20, int $offset = 0): array
    {
        $sql = 'SELECT p.*, pr.slug, pr.headline, u.email,
                (SELECT COUNT(*) FROM likes l WHERE l.post_id = p.id) as like_count,
                (SELECT COUNT(*) FROM comments c WHERE c.post_id = p.id) as comment_count
                FROM posts p
                INNER JOIN users u ON u.id = p.user_id
                INNER JOIN profiles pr ON pr.user_id = u.id
                WHERE p.visibility = "public" OR p.user_id = :user_id
                ORDER BY p.created_at DESC
                LIMIT :limit OFFSET :offset';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
