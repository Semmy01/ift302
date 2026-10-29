<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clear all authentication session variables
$_SESSION = [];
$_SESSION['success'] = 'You have been successfully signed out of the UIISP portal.';

header('Location: customer-registration-login.php?tab=login');
exit;
