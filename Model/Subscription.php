<?php
require_once __DIR__ . '/Database.php';

class Subscription
{

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
