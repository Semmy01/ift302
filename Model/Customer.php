<?php
/**
 * Customer Model (OOP)
 * Handles customer registration, lookup, authentication, and profile updates.
 */
require_once __DIR__ . '/Database.php';

class Customer
{
    private ?mysqli $db = null;

    public function __construct()
    {
        try {
            $this->db = Database::getConnection();
        } catch (Throwable $e) {
            $this->db = null;
        }
    }

    private function getDb(): mysqli
    {
        if ($this->db instanceof mysqli) {
            return $this->db;
        }
        $this->db = Database::getConnection();
        return $this->db;
    }

    /**
     * Authenticate customer by Matric/Staff ID OR Email and password.
     */
    public function authenticate(string $identifier, string $password): ?array
    {
        $identifier = trim($identifier);
        if (empty($identifier) || empty($password)) {
            return null;
        }

        // Try lookup by Matric / Staff ID first
        $user = $this->findByMatric($identifier);

        // If not found, attempt lookup by Email
        if (!$user) {
            $user = $this->findByEmail($identifier);
        }

        if (!$user) {
            return null;
        }

        if (password_verify($password, $user['password'])) {
            return $user;
        }

        return null;
    }

    /**
     * Find a single user by matric / staff ID.
     */
    public function findByMatric(string $matric): ?array
    {
        $db = $this->getDb();
        $stmt = $db->prepare("SELECT * FROM user WHERE matric = ? LIMIT 1");
        $stmt->bind_param("s", $matric);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result ?: null;
    }

    /**
     * Find a single user by email address.
     */
    public function findByEmail(string $email): ?array
    {
        $db = $this->getDb();
        $email = strtolower(trim($email));
        $stmt = $db->prepare("SELECT * FROM user WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result ?: null;
    }

    /**
     * Find a single user by primary ID.
     */
    public function findById(int $id): ?array
    {
        $db = $this->getDb();
        $stmt = $db->prepare("SELECT * FROM user WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result ?: null;
    }

    /**
     * Register a new user into the database.
     */
    public function register(array $data): bool
    {
        $db = $this->getDb();
        $matric   = strtoupper(trim($data['matric'] ?? ''));
        $fullname = trim($data['fullname'] ?? '');
        $phone    = trim($data['phone'] ?? '');
        $email    = strtolower(trim($data['email'] ?? ''));
        $password = $data['password'] ?? '';

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare(
            "INSERT INTO user (matric, fullname, phone, email, password) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("sssss", $matric, $fullname, $phone, $email, $passwordHash);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Update customer contact info (phone & email).
     */
    public function updateContact(string $matric, string $phone, string $email): bool
    {
        $db = $this->getDb();
        $phone = trim($phone);
        $email = strtolower(trim($email));
        $stmt = $db->prepare("UPDATE user SET phone = ?, email = ? WHERE matric = ?");
        $stmt->bind_param("sss", $phone, $email, $matric);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Update customer password after verifying old password.
     */
    public function changePassword(string $matric, string $oldPassword, string $newPassword): bool
    {
        $user = $this->findByMatric($matric);
        if (!$user || !password_verify($oldPassword, $user['password'])) {
            return false;
        }

        $db = $this->getDb();
        $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $db->prepare("UPDATE user SET password = ? WHERE matric = ?");
        $stmt->bind_param("ss", $newHash, $matric);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
}
