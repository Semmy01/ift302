<?php
/**
 * Shared MySQLi connection for UIISP pages.
 *
 * Bridges legacy calls to the new config/Database.php singleton.
 */

require_once __DIR__ . '/../config/Database.php';

if (!function_exists('getDbConnection')) {
    function getDbConnection(): mysqli
    {
        return Database::getConnection();
    }
}
