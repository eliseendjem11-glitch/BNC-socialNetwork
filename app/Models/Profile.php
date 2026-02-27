<?php

declare(strict_types=1);

namespace App\Models;

final class Profile extends BaseModel
{
    public function createDefault(int $userId, string $slug): void
    {
        $stmt = $this->db->prepare('INSERT INTO profiles (user_id, slug, headline, bio, privacy_level, created_at, updated_at) VALUES (:user_id, :slug, "", "", "public", NOW(), NOW())');
        $stmt->execute([':user_id' => $userId, ':slug' => $slug]);
    }

    public function findByUserId(int $userId): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM profiles WHERE user_id = :user_id LIMIT 1');
        $stmt->execute([':user_id' => $userId]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function update(int $userId, array $data): bool
    {
        $stmt = $this->db->prepare('UPDATE profiles SET headline=:headline, bio=:bio, location=:location, website=:website, updated_at=NOW() WHERE user_id=:user_id');
        return $stmt->execute([
            ':headline' => $data['headline'],
            ':bio' => $data['bio'],
            ':location' => $data['location'],
            ':website' => $data['website'],
            ':user_id' => $userId,
        ]);
    }
}
