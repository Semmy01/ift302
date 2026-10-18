<?php

require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/Model.php';
require_once __DIR__ . '/app/Controllers/AuthController.php';

$authController = new AuthController();
$authController->index();
