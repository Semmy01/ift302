<?php
/**
 * Direct Login Handler
 * Uses Customer Model (OOP)
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/Model/Customer.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: customer-registration-login.php?tab=login');
    exit;
}

$matric   = trim($_POST['matric'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($matric) || empty($password)) {
    $_SESSION['errors'] = ['general' => 'Please provide both Matric / Staff ID and password.'];
    header('Location: customer-registration-login.php?tab=login');
    exit;
}

try {
    $customerModel = new Customer();
    $user = $customerModel->authenticate($matric, $password);

    if ($user) {
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['matric']   = $user['matric'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['email']    = $user['email'];

        header('Location: subscriber-dashboard.php');
        exit;
    } else {
        $_SESSION['errors'] = ['general' => 'Invalid Matric / Staff ID or password.'];
        header('Location: customer-registration-login.php?tab=login');
        exit;
    }
} catch (Exception $e) {
    $_SESSION['errors'] = ['general' => 'Authentication failed. Please try again later.'];
    header('Location: customer-registration-login.php?tab=login');
    exit;
}
