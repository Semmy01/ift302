<?php

class Database
{
    private static ?mysqli $connection = null;

    public static function getConnection(): mysqli
    {
        if (self::$connection instanceof mysqli) {
            return self::$connection;
        }

        $host = getenv('DB_HOST') ?: '127.0.0.1';
        $port = (int)(getenv('DB_PORT') ?: 3306);
        $databaseName = getenv('DB_NAME') ?: 'ift302';
        $databaseUser = getenv('DB_USER') ?: 'ift302';
        $password = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : 'ift302';

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            self::$connection = new mysqli($host, $databaseUser, $password, $databaseName, $port);
            self::$connection->set_charset('utf8mb4');
        } catch (mysqli_sql_exception $e) {
            throw new RuntimeException("Database connection error: " . $e->getMessage(), (int)$e->getCode(), $e);
        }

        return self::$connection;
    }
}
