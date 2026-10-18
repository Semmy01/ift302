<?php

require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../Models/Subscription.php';

class PaymentController extends Controller
{
    private Subscription $subscriptionModel;

    public function __construct()
    {
        $this->subscriptionModel = new Subscription();
    }

    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $selectedPackage = $_GET['package'] ?? 'standard';
        $packages = [
            'basic' => ['name' => 'Basic Package — ₦5,000 / 30 Days', 'price' => '₦5,000'],
            'standard' => ['name' => 'Standard Package — ₦10,000 / 30 Days', 'price' => '₦10,000'],
            'premium' => ['name' => 'Premium Ultra — ₦18,000 / 30 Days', 'price' => '₦18,000'],
        ];

        $current = $packages[$selectedPackage] ?? $packages['standard'];

        $this->view('payment/checkout', [
            'pageTitle' => 'Subscription Checkout & Instant Payment Gateway | UIISP Portal',
            'package' => $current['name'],
            'price' => $current['price'],
        ]);
    }

    public function process(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Mock payment processing
        $_SESSION['success'] = 'Payment successful! Wi-Fi subscription activated.';
        $this->redirect('index.php?url=dashboard');
    }
}
