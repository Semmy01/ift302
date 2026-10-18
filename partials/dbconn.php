<?php
/**
 * UIISP Database Connection Include
 */
require_once __DIR__ . '/../Model/Database.php';

if (!function_exists('getDbConnection')) {
    function getDbConnection(): mysqli
    {
        return Database::getConnection();
    }
}
