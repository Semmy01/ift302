<?php
/**
 * Customer Model (OOP)
 * Handles customer registration, lookup, and password authentication.
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
     * Authenticate customer by Matric/Staff ID and password.
     */
    public function authenticate(string $matric, string $password): ?array
    {
        $user = $this->findByMatric($matric);

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
        return $result ?: null;
    }

    /**
     * Find a single user by email address.
     */
    public function findByEmail(string $email): ?array
    {
        $db = $this->getDb();
        $stmt = $db->prepare("SELECT * FROM user WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
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
        return $result ?: null;
    }

    /**
     * Register a new user into the database.
     */
    public function register(array $data): bool
    {
        $db = $this->getDb();
        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $db->prepare(
            "INSERT INTO user (matric, fullname, phone, email, password) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("sssss", $data['matric'], $data['fullname'], $data['phone'], $data['email'], $passwordHash);
        return $stmt->execute();
    }
}
