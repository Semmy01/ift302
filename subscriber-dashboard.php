<?php

require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/Model.php';
require_once __DIR__ . '/app/Controllers/DashboardController.php';

$dashboardController = new DashboardController();
$dashboardController->index();
