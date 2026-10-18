<?php

require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../Models/Customer.php';

class AuthController extends Controller
{
    private Customer $customerModel;

    public function __construct()
    {
        $this->customerModel = new Customer();
    }

    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $errors  = $_SESSION['errors'] ?? [];
        $success = $_SESSION['success'] ?? '';
        $old     = $_SESSION['old'] ?? [];
        unset($_SESSION['errors'], $_SESSION['success'], $_SESSION['old']);

        $tab = $_GET['tab'] ?? (!empty($errors) ? 'register' : 'login');

        $this->view('auth/login-register', [
            'pageTitle' => 'UIISP Customer Authentication - University of Ibadan',
            'activeTab' => $tab,
            'errors'    => $errors,
            'success'   => $success,
            'old'       => $old,
        ]);
    }

    public function login(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?url=auth&tab=login');
        }

        $matric = trim($_POST['matric'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($matric) || empty($password)) {
            $_SESSION['errors'] = ['general' => 'Please provide both ID and password.'];
            $this->redirect('index.php?url=auth&tab=login');
        }

        try {
            $user = $this->customerModel->authenticate($matric, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['matric']  = $user['matric'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['email']    = $user['email'];

                $this->redirect('index.php?url=dashboard');
            } else {
                $_SESSION['errors'] = ['general' => 'Invalid Matric / Staff ID or password.'];
                $this->redirect('index.php?url=auth&tab=login');
            }
        } catch (Exception $e) {
            $_SESSION['errors'] = ['general' => 'Authentication failed. Please try again later.'];
            $this->redirect('index.php?url=auth&tab=login');
        }
    }

    public function register(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?url=auth&tab=register');
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
            $this->redirect('index.php?url=auth&tab=register');
        }

        try {
            $this->customerModel->register($_POST);
            $_SESSION['success'] = 'Registration successful! Please sign in.';
            $this->redirect('index.php?url=auth&tab=login');
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
            $this->redirect('index.php?url=auth&tab=register');
        }
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        session_destroy();
        $this->redirect('index.php?url=auth&tab=login');
    }
}
