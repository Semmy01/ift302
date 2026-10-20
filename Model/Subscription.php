<?php
/**
 * Subscription Model (OOP)
 * Reads payment records from the subscription_history table.
 *
 * NOTE: if the shared Subscription.php from GitHub already exists,
 * copy only the getRecentPayments() method into it.
 */
require_once __DIR__ . '/Database.php';

class Subscription
{
    /**
     * Get a user's most recent successful payments, newest first.
     * Only rows whose user_id matches the given matric are returned.
     */
    public function getRecentPayments(string $matric, int $limit = 5): array
    {
        $db = Database::getConnection();
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
