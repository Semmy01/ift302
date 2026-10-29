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
            $host     = getenv('DB_HOST') ?: '127.0.0.1';
            $user     = getenv('DB_USER') ?: 'ift302';
            $password = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : 'ift302';
            $database = getenv('DB_NAME') ?: 'ift302';
            $port     = (int)(getenv('DB_PORT') ?: 3306);

            try {
                self::$connection = new mysqli($host, $user, $password, $database, $port);
                self::$connection->set_charset('utf8mb4');
            } catch (mysqli_sql_exception $e) {
                // If connecting with configured user fails and is not root, attempt fallback with default XAMPP root user
                if ($user !== 'root') {
                    try {
                        self::$connection = new mysqli($host, 'root', '', $database, $port);
                        self::$connection->set_charset('utf8mb4');
                        return self::$connection;
                    } catch (mysqli_sql_exception) {
                        // Suppress fallback error and throw original connection error
                    }
                }
                throw new RuntimeException("Database connection error: " . $e->getMessage(), (int)$e->getCode(), $e);
            }
        }

        return self::$connection;
    }
}
