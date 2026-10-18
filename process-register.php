<?php
/**
 * Direct Register Handler
 * Uses Customer Model (OOP)
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/Model/Customer.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: customer-registration-login.php?tab=register');
    exit;
}

$err = [];

if (empty($_POST['fullname'])) {
    $err['fullname'] = 'Full name is required';
}

if (empty($_POST['matric'])) {
    $err['matric'] = 'Matric / Staff number is required';
}

if (empty($_POST['phone'])) {
    $err['phone'] = 'Phone number is required';
}

if (!filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL)) {
    $err['email'] = 'Valid email is required';
}

if (strlen($_POST['password'] ?? '') < 8) {
    $err['password'] = 'Password must be at least 8 characters';
} elseif (!preg_match("/[a-z]/i", $_POST['password'])) {
    $err['password'] = 'Password must contain at least one letter';
} elseif (!preg_match("/[0-9]/", $_POST['password'])) {
    $err['password'] = 'Password must contain at least one number';
} elseif (($_POST['password'] ?? '') !== ($_POST['confirm_password'] ?? '')) {
    $err['confirm_password'] = 'Passwords must match';
}

if (!empty($err)) {
    $_SESSION['errors'] = $err;
    $_SESSION['old'] = [
        'fullname' => $_POST['fullname'] ?? '',
        'matric'   => $_POST['matric'] ?? '',
        'phone'    => $_POST['phone'] ?? '',
        'email'    => $_POST['email'] ?? '',
    ];
    header('Location: customer-registration-login.php?tab=register');
    exit;
}

try {
    $customerModel = new Customer();
    $customerModel->register($_POST);

    $_SESSION['success'] = 'Registration successful! Please sign in.';
    header('Location: customer-registration-login.php?tab=login');
    exit;
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1062) {
        $_SESSION['errors'] = ['general' => 'This email or matric number is already registered.'];
    } else {
        $_SESSION['errors'] = ['general' => 'Registration failed. Please try again later.'];
    }
    $_SESSION['old'] = [
        'fullname' => $_POST['fullname'] ?? '',
        'matric'   => $_POST['matric'] ?? '',
        'phone'    => $_POST['phone'] ?? '',
        'email'    => $_POST['email'] ?? '',
    ];
    header('Location: customer-registration-login.php?tab=register');
    exit;
} catch (Exception $e) {
    $_SESSION['errors'] = ['general' => 'Registration failed. Please try again later.'];
    $_SESSION['old'] = [
        'fullname' => $_POST['fullname'] ?? '',
        'matric'   => $_POST['matric'] ?? '',
        'phone'    => $_POST['phone'] ?? '',
        'email'    => $_POST['email'] ?? '',
    ];
    header('Location: customer-registration-login.php?tab=register');
    exit;
}
