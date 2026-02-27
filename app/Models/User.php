<?php

declare(strict_types=1);

namespace App\Models;

final class User extends BaseModel
{
    public function create(array $data): int
    {
        $sql = 'INSERT INTO users (email, password_hash, role, email_verification_token, created_at, updated_at) VALUES (:email, :password_hash, :role, :token, NOW(), NOW())';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':email' => $data['email'],
            ':password_hash' => $data['password_hash'],
            ':role' => $data['role'] ?? 'user',
            ':token' => $data['token'],
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function verifyEmail(string $token): bool
    {
        $stmt = $this->db->prepare('UPDATE users SET email_verified_at = NOW(), email_verification_token = NULL WHERE email_verification_token = :token');
        $stmt->execute([':token' => $token]);
        return $stmt->rowCount() > 0;
    }
}
