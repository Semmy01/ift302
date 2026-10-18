<?php

require_once __DIR__ . '/../../core/Model.php';

class Customer extends Model
{
    private ?int $id = null;
    private ?string $fullname = null;
    private ?string $matric = null;
    private ?string $phone = null;
    private ?string $email = null;

    public function __construct(array $data = [])
    {
        parent::__construct();
        if (!empty($data)) {
            $this->id = isset($data['id']) ? (int)$data['id'] : null;
            $this->fullname = $data['fullname'] ?? null;
            $this->matric = $data['matric'] ?? null;
            $this->phone = $data['phone'] ?? null;
            $this->email = $data['email'] ?? null;
        }
    }

    public function findByMatric(string $matric): ?array
    {
        $db = $this->getDb();
        $stmt = $db->prepare("SELECT * FROM user WHERE matric = ? LIMIT 1");
        $stmt->bind_param("s", $matric);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ?: null;
    }

    public function findByEmail(string $email): ?array
    {
        $db = $this->getDb();
        $stmt = $db->prepare("SELECT * FROM user WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ?: null;
    }

    public function findById(int $id): ?array
    {
        $db = $this->getDb();
        $stmt = $db->prepare("SELECT * FROM user WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ?: null;
    }

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

    public function authenticate(string $matric, string $password): ?array
    {
        $user = $this->findByMatric($matric);
        if (!$user) {
            // Also allow logging in with email
            $user = $this->findByEmail($matric);
        }

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return null;
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getFullname(): ?string { return $this->fullname; }
    public function getMatric(): ?string { return $this->matric; }
    public function getPhone(): ?string { return $this->phone; }
    public function getEmail(): ?string { return $this->email; }
}
