<?php
/**
 * Database Connection Class (OOP Singleton)
 * Beginner-friendly database wrapper using MySQLi.
 */
class Database
{
    private static ?mysqli $connection = null;

    public static function getConnection(): mysqli
    {
        if (self::$connection === null) {
            $host     = '127.0.0.1';
            $user     = 'ift302';
            $password = 'ift302';
            $database = 'ift302';
            $port     = 3306;

            try {
                self::$connection = new mysqli($host, $user, $password, $database, $port);
                self::$connection->set_charset('utf8mb4');
            } catch (mysqli_sql_exception $e) {
                throw new RuntimeException("Database connection error: " . $e->getMessage(), (int)$e->getCode(), $e);
            }
        }

        return self::$connection;
    }
}
