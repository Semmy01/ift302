<?php

require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../Models/Subscription.php';
require_once __DIR__ . '/../Models/Customer.php';

class DashboardController extends Controller
{
    private Subscription $subscriptionModel;
    private Customer $customerModel;

    public function __construct()
    {
        $this->subscriptionModel = new Subscription();
        $this->customerModel = new Customer();
    }

    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user_id'] ?? 1;
        $subscription = $this->subscriptionModel->getActiveSubscription($userId);
        $history = $this->subscriptionModel->getPaymentHistory($userId);

        $this->view('dashboard/index', [
            'pageTitle' => 'UIISP Portal - Subscriber Customer Dashboard',
            'subscription' => $subscription,
            'history' => $history,
            'user' => [
                'id' => $_SESSION['user_id'] ?? null,
                'matric' => $_SESSION['matric'] ?? null,
                'fullname' => $_SESSION['fullname'] ?? 'Engr. Damilola Adeleke',
            ],
        ]);
    }
}
