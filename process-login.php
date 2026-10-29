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
$redirect = trim($_POST['redirect'] ?? $_GET['redirect'] ?? '');

$redirectParam = !empty($redirect) ? '&redirect=' . urlencode($redirect) : '';

if (empty($matric) || empty($password)) {
    $_SESSION['errors'] = ['general' => 'Please provide both Matric / Staff ID (or email) and password.'];
    $_SESSION['old_login_id'] = $matric;
    header('Location: customer-registration-login.php?tab=login' . $redirectParam);
    exit;
}

try {
    $customerModel = new Customer();
    $user = $customerModel->authenticate($matric, $password);

    if ($user) {
        // Clear any old auth errors
        unset($_SESSION['errors'], $_SESSION['old_login_id']);

        $_SESSION['user_id']  = $user['id'];
        $_SESSION['matric']   = $user['matric'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['email']    = $user['email'];
        $_SESSION['phone']    = $user['phone'] ?? '';

        // Safe redirect handling
        if (!empty($redirect) && !preg_match('#^https?://#i', $redirect)) {
            header('Location: ' . $redirect);
            exit;
        }

        header('Location: subscriber-dashboard.php');
        exit;
    } else {
        $_SESSION['errors'] = ['general' => 'Invalid credentials. Please verify your ID/email and password.'];
        $_SESSION['old_login_id'] = $matric;
        header('Location: customer-registration-login.php?tab=login' . $redirectParam);
        exit;
    }
} catch (Throwable $e) {
    $_SESSION['errors'] = ['general' => 'Authentication service temporarily unavailable. Please try again later.'];
    $_SESSION['old_login_id'] = $matric;
    header('Location: customer-registration-login.php?tab=login' . $redirectParam);
    exit;
}
