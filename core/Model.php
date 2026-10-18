<?php

require_once __DIR__ . '/../config/Database.php';

abstract class Model
{
    protected ?mysqli $db = null;

    public function __construct()
    {
        try {
            $this->db = Database::getConnection();
        } catch (Throwable $e) {
            $this->db = null;
        }
    }

    protected function getDb(): mysqli
    {
        if ($this->db instanceof mysqli) {
            return $this->db;
        }
        $this->db = Database::getConnection();
        return $this->db;
    }
}
