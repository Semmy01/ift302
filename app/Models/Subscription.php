<?php

require_once __DIR__ . '/../../core/Model.php';

class Subscription extends Model
{
    public function getPackages(): array
    {
        return [
            [
                'id' => 'basic',
                'name' => 'Basic',
                'tier' => 'Tier 01',
                'price' => 5000,
                'period' => '30 Days',
                'speed' => 'Up to 10 Mbps',
                'devices' => '2 Devices',
                'coverage' => 'Hostels & Faculty coverage',
                'featured' => false,
            ],
            [
                'id' => 'standard',
                'name' => 'Standard',
                'tier' => 'Tier 02',
                'price' => 10000,
                'period' => '30 Days',
                'speed' => 'Up to 25 Mbps',
                'devices' => '4 Devices',
                'coverage' => 'Hostels, Faculty & Library coverage',
                'featured' => true,
            ],
            [
                'id' => 'premium',
                'name' => 'Premium Ultra',
                'tier' => 'Tier 03',
                'price' => 18000,
                'period' => '30 Days',
                'speed' => 'Up to 50 Mbps',
                'devices' => '6 Devices',
                'coverage' => 'Full Campus Priority & Off-Peak Booster',
                'featured' => false,
            ],
        ];
    }

    public function getActiveSubscription(int|string $userId): array
    {
        // Default subscriber info
        return [
            'plan_name' => 'Standard Plan - 30 Days',
            'status' => 'Active',
            'days_remaining' => 18,
            'expiry_date' => 'March 28, 2025',
            'connected_devices' => 3,
            'max_devices' => 4,
            'wifi_username' => 'ui-id/dam.adeleke',
            'wifi_password' => 'TechFaculty#2025!',
        ];
    }

    public function getPaymentHistory(int|string $userId): array
    {
        return [
            [
                'date' => 'Feb 26, 2025',
                'reference' => 'UIISP-TXN-9028114',
                'package' => 'Standard Plan (30 Days)',
                'amount' => '₦10,000',
                'status' => 'Paid',
            ],
            [
                'date' => 'Jan 27, 2025',
                'reference' => 'UIISP-TXN-8841029',
                'package' => 'Standard Plan (30 Days)',
                'amount' => '₦10,000',
                'status' => 'Paid',
            ],
            [
                'date' => 'Dec 28, 2024',
                'reference' => 'UIISP-TXN-7612984',
                'package' => 'Basic Plan (30 Days)',
                'amount' => '₦5,000',
                'status' => 'Paid',
            ],
        ];
    }
}
