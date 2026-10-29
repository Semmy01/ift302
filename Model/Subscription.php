<?php
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
    public function recordPayment(string $matric, string $plan, int $amount): bool
    {
        $db = $this->getDb();
        $stmt = $db->prepare(
            "INSERT INTO subscription_history (user_id, plan, amount, `date`)
             VALUES (?, ?, ?, NOW())"
        );
        $stmt->bind_param("ssi", $matric, $plan, $amount);
        return $stmt->execute();
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
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
