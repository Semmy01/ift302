<?php
/**
 * Subscription Model (OOP)
 * Handles payment recording, subscription history, and active plan calculation.
 */
require_once __DIR__ . '/Database.php';

class Subscription
{
    private function getDb(): mysqli
    {
        return Database::getConnection();
    }

    /**
     * Record a new subscription payment/purchase in the subscription_history table.
     */
    public function recordPayment(string $matric, string $plan, int $amount, ?string $date = null): bool
    {
        $db = $this->getDb();
        if ($date !== null) {
            $stmt = $db->prepare(
                "INSERT INTO subscription_history (user_id, plan, amount, `date`)
                 VALUES (?, ?, ?, ?)"
            );
            $stmt->bind_param("ssis", $matric, $plan, $amount, $date);
        } else {
            $stmt = $db->prepare(
                "INSERT INTO subscription_history (user_id, plan, amount, `date`)
                 VALUES (?, ?, ?, NOW())"
            );
            $stmt->bind_param("ssi", $matric, $plan, $amount);
        }
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    /**
     * Alias for recording a subscription purchase.
     */
    public function recordSubscription(string $matric, string $plan, int $amount): bool
    {
        return $this->recordPayment($matric, $plan, $amount);
    }

    /**
     * Fetch recent payment history for a subscriber.
     */
    public function getRecentPayments(string $matric, int $limit = 5): array
    {
        $db = $this->getDb();
        $stmt = $db->prepare(
            "SELECT id, plan, amount, `date`
             FROM subscription_history
             WHERE user_id = ?
             ORDER BY `date` DESC, id DESC
             LIMIT ?"
        );
        $stmt->bind_param("si", $matric, $limit);
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rows;
    }

    /**
     * Fetch all payment records for a subscriber.
     */
    public function getAllPayments(string $matric): array
    {
        $db = $this->getDb();
        $stmt = $db->prepare(
            "SELECT id, plan, amount, `date`
             FROM subscription_history
             WHERE user_id = ?
             ORDER BY `date` DESC, id DESC"
        );
        $stmt->bind_param("s", $matric);
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rows;
    }

    /**
     * Fetch the most recent payment record for a subscriber.
     */
    public function getLatestPayment(string $matric): ?array
    {
        $db = $this->getDb();
        $stmt = $db->prepare(
            "SELECT id, plan, amount, `date`
             FROM subscription_history
             WHERE user_id = ?
             ORDER BY `date` DESC, id DESC
             LIMIT 1"
        );
        $stmt->bind_param("s", $matric);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row ?: null;
    }

    /**
     * Dynamically compute active subscription status, expiry, device count, and network credentials.
     */
    public function getActiveSubscription(string $matric): array
    {
        $latest = $this->getLatestPayment($matric);

        if (!$latest) {
            return [
                'is_active'         => false,
                'status'            => 'No Active Plan',
                'status_class'      => 'status-badge--expired',
                'plan_name'         => 'No Active Subscription',
                'tier'              => 'None',
                'amount'            => 0,
                'days_remaining'    => 0,
                'start_date'        => 'N/A',
                'expiry_date'       => 'Not Subscribed',
                'connected_devices' => 0,
                'max_devices'       => 0,
                'speed'             => '0 Mbps',
                'wifi_username'     => 'ui-id/' . $matric,
                'wifi_password'     => 'WiFi#' . strtoupper(substr(md5($matric), 0, 6)),
                'data_total_gb'     => 0,
                'data_used_gb'      => 0,
                'usage_percent'     => 0,
            ];
        }

        $startDate = strtotime($latest['date']);
        $expiryDate = $startDate + (30 * 86400); // 30-day validity
        $secondsRemaining = $expiryDate - time();

        $planStr = strtolower($latest['plan']);
        if (str_contains($planStr, 'premium')) {
            $maxDevices  = 8;
            $speed       = 'Up to 100 Mbps';
            $dataTotal   = 500;
            $tierName    = 'Premium';
        } elseif (str_contains($planStr, 'basic')) {
            $maxDevices  = 2;
            $speed       = 'Up to 10 Mbps';
            $dataTotal   = 50;
            $tierName    = 'Basic';
        } else {
            $maxDevices  = 4;
            $speed       = 'Up to 35 Mbps';
            $dataTotal   = 150;
            $tierName    = 'Standard';
        }

        if ($secondsRemaining > 0) {
            $daysRemaining = (int)ceil($secondsRemaining / 86400);
            $isActive = true;
            if ($daysRemaining <= 3) {
                $status = 'Expiring Soon';
                $statusClass = 'status-badge--warning';
            } else {
                $status = 'Active';
                $statusClass = 'status-badge--active';
            }
            $daysElapsed = max(0, 30 - $daysRemaining);
            $connectedDevices = min($maxDevices, max(1, (int)round($maxDevices * 0.65)));
            $dataUsed = round(($daysElapsed / 30) * $dataTotal * 0.72 + 2.5, 1);
            $dataUsed = min($dataTotal, $dataUsed);
        } else {
            $daysRemaining = 0;
            $isActive = false;
            $status = 'Expired';
            $statusClass = 'status-badge--expired';
            $connectedDevices = 0;
            $dataUsed = $dataTotal;
        }

        $usagePercent = $dataTotal > 0 ? min(100, (int)round(($dataUsed / $dataTotal) * 100)) : 0;

        return [
            'is_active'         => $isActive,
            'status'            => $status,
            'status_class'      => $statusClass,
            'plan_name'         => $latest['plan'] . ' — 30 Days',
            'raw_plan'          => $latest['plan'],
            'tier'              => $tierName,
            'amount'            => (int)$latest['amount'],
            'days_remaining'    => $daysRemaining,
            'start_date'        => date('F j, Y', $startDate),
            'expiry_date'       => date('F j, Y', $expiryDate),
            'connected_devices' => $connectedDevices,
            'max_devices'       => $maxDevices,
            'speed'             => $speed,
            'wifi_username'     => 'ui-id/' . $matric,
            'wifi_password'     => 'UI@WiFi#' . strtoupper(substr(md5($matric . 'uiisp_salt'), 0, 5)) . '!',
            'data_total_gb'     => $dataTotal,
            'data_used_gb'      => $dataUsed,
            'usage_percent'     => $usagePercent,
        ];
    }
}
