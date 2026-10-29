<?php
/**
 * Profile & Password Update Handler
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['matric'])) {
    header('Location: customer-registration-login.php?tab=login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: subscriber-dashboard.php');
    exit;
}

require_once __DIR__ . '/Model/Customer.php';

$matric = $_SESSION['matric'];
$action = $_POST['action'] ?? '';
$customerModel = new Customer();

if ($action === 'change_password') {
    $currentPass = $_POST['current_password'] ?? '';
    $newPass     = $_POST['new_password'] ?? '';
    $confirmPass = $_POST['confirm_password'] ?? '';

    if (empty($currentPass) || empty($newPass)) {
        $_SESSION['error'] = 'Please enter both current and new passwords.';
        header('Location: subscriber-dashboard.php#account');
        exit;
    }

    if (strlen($newPass) < 8 || !preg_match("/[a-z]/i", $newPass) || !preg_match("/[0-9]/", $newPass)) {
        $_SESSION['error'] = 'New password must be at least 8 characters and include both letters and numbers.';
        header('Location: subscriber-dashboard.php#account');
        exit;
    }

    if ($newPass !== $confirmPass) {
        $_SESSION['error'] = 'New password and confirmation do not match.';
        header('Location: subscriber-dashboard.php#account');
        exit;
    }

    $updated = $customerModel->changePassword($matric, $currentPass, $newPass);
    if ($updated) {
        $_SESSION['success'] = 'Password changed successfully! Your WPA3 credentials remain synchronized.';
    } else {
        $_SESSION['error'] = 'Current password entered was incorrect.';
    }

    header('Location: subscriber-dashboard.php#account');
    exit;
}

if ($action === 'update_contact') {
    $phone = trim($_POST['phone'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));

    if (empty($phone) || !preg_match('/^[0-9+() -]{10,18}$/', $phone)) {
        $_SESSION['error'] = 'Please enter a valid phone number (10-18 digits).';
        header('Location: subscriber-dashboard.php#account');
        exit;
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Please provide a valid email address.';
        header('Location: subscriber-dashboard.php#account');
        exit;
    }

    // Check if another account is already using this email
    $existing = $customerModel->findByEmail($email);
    if ($existing && $existing['matric'] !== $matric) {
        $_SESSION['error'] = 'That email address is already in use by another subscriber account.';
        header('Location: subscriber-dashboard.php#account');
        exit;
    }

    $saved = $customerModel->updateContact($matric, $phone, $email);
    if ($saved) {
        $_SESSION['email'] = $email;
        $_SESSION['phone'] = $phone;
        $_SESSION['success'] = 'Contact information updated successfully.';
    } else {
        $_SESSION['error'] = 'Failed to update contact info. Please try again.';
    }

    header('Location: subscriber-dashboard.php#account');
    exit;
}

header('Location: subscriber-dashboard.php');
exit;
