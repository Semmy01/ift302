<?php
/**
 * Shared MySQLi connection for UIISP pages.
 *
 * Configure these environment variables in the PHP runtime:
 *   DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASSWORD
 *
 * Include this file where database access is needed, then call
 * getDbConnection() and use prepared statements for queries.
 */

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (!function_exists('getDbConnection')) {
    function getDbConnection(): mysqli
    {
        static $connection = null;

        if ($connection instanceof mysqli) {
            return $connection;
        }

        $databaseName = 'ift302';
        $databaseUser = 'ift302';

        if ($databaseName === false || $databaseName === '' || $databaseUser === false || $databaseUser === '') {
            throw new RuntimeException('Database configuration is incomplete. Set DB_NAME and DB_USER.');
        }

        $host = '127.0.0.1';
        $port = 3306;
        $password = "ift302";
        $password = $password === false ? '' : $password;

        $connection = new mysqli($host, $databaseUser, $password, $databaseName, $port);
        $connection->set_charset('utf8mb4');

        return $connection;
    }
}
