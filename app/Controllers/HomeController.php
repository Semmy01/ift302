<?php

require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../Models/Subscription.php';

class HomeController extends Controller
{
    private Subscription $subscriptionModel;

    public function __construct()
    {
        $this->subscriptionModel = new Subscription();
    }

    public function index(): void
    {
        $packages = $this->subscriptionModel->getPackages();

        $this->view('home/index', [
            'pageTitle' => 'UIISP - University of Ibadan Internet Service Provider',
            'packages' => $packages,
        ]);
    }
}
