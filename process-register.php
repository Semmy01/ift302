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

$fullname        = trim($_POST['fullname'] ?? '');
$matric          = strtoupper(trim($_POST['matric'] ?? ''));
$phone           = trim($_POST['phone'] ?? '');
$email           = strtolower(trim($_POST['email'] ?? ''));
$password        = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';
$terms           = $_POST['terms'] ?? '';
$redirect        = trim($_POST['redirect'] ?? $_GET['redirect'] ?? '');

$redirectParam   = !empty($redirect) ? '&redirect=' . urlencode($redirect) : '';

$err = [];

if (empty($fullname) || strlen($fullname) < 3) {
    $err['fullname'] = 'Full name must be at least 3 characters.';
}

if (empty($matric) || strlen($matric) < 4) {
    $err['matric'] = 'Matriculation or Staff ID is required (min 4 characters).';
}

if (empty($phone)) {
    $err['phone'] = 'Active phone number is required.';
} elseif (!preg_match('/^[0-9+() -]{10,18}$/', $phone)) {
    $err['phone'] = 'Please enter a valid phone number (e.g. 08012345678).';
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $err['email'] = 'A valid university or personal email address is required.';
}

if (strlen($password) < 8) {
    $err['password'] = 'Password must be at least 8 characters long.';
} elseif (!preg_match("/[a-z]/i", $password)) {
    $err['password'] = 'Password must contain at least one letter.';
} elseif (!preg_match("/[0-9]/", $password)) {
    $err['password'] = 'Password must contain at least one number.';
} elseif ($password !== $confirmPassword) {
    $err['confirm_password'] = 'Passwords do not match.';
}

if (empty($terms)) {
    $err['terms'] = 'You must accept the Campus Network Acceptable Use Policy.';
}

if (!empty($err)) {
    $_SESSION['errors'] = $err;
    $_SESSION['old'] = [
        'fullname' => $fullname,
        'matric'   => $matric,
        'phone'    => $phone,
        'email'    => $email,
    ];
    header('Location: customer-registration-login.php?tab=register' . $redirectParam);
    exit;
}

try {
    $customerModel = new Customer();

    // Check if matric or email already exists
    if ($customerModel->findByMatric($matric)) {
        $_SESSION['errors'] = ['matric' => 'This Matriculation / Staff ID is already registered.'];
        $_SESSION['old'] = ['fullname' => $fullname, 'matric' => $matric, 'phone' => $phone, 'email' => $email];
        header('Location: customer-registration-login.php?tab=register' . $redirectParam);
        exit;
    }

    if ($customerModel->findByEmail($email)) {
        $_SESSION['errors'] = ['email' => 'This email address is already registered.'];
        $_SESSION['old'] = ['fullname' => $fullname, 'matric' => $matric, 'phone' => $phone, 'email' => $email];
        header('Location: customer-registration-login.php?tab=register' . $redirectParam);
        exit;
    }

    $customerModel->register([
        'fullname' => $fullname,
        'matric'   => $matric,
        'phone'    => $phone,
        'email'    => $email,
        'password' => $password,
    ]);

    // Automatically authenticate the newly registered user for a smooth onboarding experience
    $user = $customerModel->authenticate($matric, $password);
    if ($user) {
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['matric']   = $user['matric'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['email']    = $user['email'];
        $_SESSION['phone']    = $user['phone'] ?? '';
        $_SESSION['success']  = 'Welcome to UIISP! Your account has been created successfully. Choose a package to activate Wi-Fi access.';

        if (!empty($redirect) && !preg_match('#^https?://#i', $redirect)) {
            header('Location: ' . $redirect);
            exit;
        }

        header('Location: subscriber-dashboard.php');
        exit;
    }

    $_SESSION['success'] = 'Account registered successfully! Please sign in with your credentials.';
    header('Location: customer-registration-login.php?tab=login' . $redirectParam);
    exit;
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1062) {
        $_SESSION['errors'] = ['general' => 'This email or matric number is already registered.'];
    } else {
        $_SESSION['errors'] = ['general' => 'Registration database error: ' . $e->getMessage()];
    }
    $_SESSION['old'] = ['fullname' => $fullname, 'matric' => $matric, 'phone' => $phone, 'email' => $email];
    header('Location: customer-registration-login.php?tab=register' . $redirectParam);
    exit;
} catch (Throwable $e) {
    $_SESSION['errors'] = ['general' => 'Registration error. Please try again later.'];
    $_SESSION['old'] = ['fullname' => $fullname, 'matric' => $matric, 'phone' => $phone, 'email' => $email];
    header('Location: customer-registration-login.php?tab=register' . $redirectParam);
    exit;
}
