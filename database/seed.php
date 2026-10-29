<?php
/**
 * UIISP Database Seeder
 * Clears database tables and populates with realistic mock test data.
 * Run via CLI: php database/seed.php
 */

require_once __DIR__ . '/../Model/Database.php';

try {
    $db = Database::getConnection();

    echo "Resetting tables...\n";
    $db->query("SET FOREIGN_KEY_CHECKS = 0;");
    $db->query("TRUNCATE TABLE subscription_history;");
    $db->query("TRUNCATE TABLE user;");
    $db->query("SET FOREIGN_KEY_CHECKS = 1;");

    echo "Inserting mock users...\n";
    $passwordHash = password_hash('Password123', PASSWORD_DEFAULT);

    $userStmt = $db->prepare(
        "INSERT INTO user (matric, fullname, phone, email, password, created_at)
         VALUES (?, ?, ?, ?, ?, ?)"
    );

    $users = [
        [
            'matric'     => '219084',
            'fullname'   => 'Babatunde Adeleke',
            'phone'      => '08031234567',
            'email'      => 'b.adeleke@ui.edu.ng',
            'password'   => $passwordHash,
            'created_at' => date('Y-m-d H:i:s', strtotime('-40 days')),
        ],
        [
            'matric'     => 'UI/STF/4821',
            'fullname'   => 'Dr. Folashade Alabi',
            'phone'      => '08059876543',
            'email'      => 'f.alabi@ui.edu.ng',
            'password'   => $passwordHash,
            'created_at' => date('Y-m-d H:i:s', strtotime('-75 days')),
        ],
        [
            'matric'     => '224105',
            'fullname'   => 'Chioma Okonkwo',
            'phone'      => '08123456789',
            'email'      => 'c.okonkwo@ui.edu.ng',
            'password'   => $passwordHash,
            'created_at' => date('Y-m-d H:i:s', strtotime('-50 days')),
        ],
        [
            'matric'     => '238912',
            'fullname'   => 'Ibrahim Danjuma',
            'phone'      => '07011223344',
            'email'      => 'i.danjuma@ui.edu.ng',
            'password'   => $passwordHash,
            'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
        ],
    ];

    foreach ($users as $u) {
        $userStmt->bind_param('ssssss', $u['matric'], $u['fullname'], $u['phone'], $u['email'], $u['password'], $u['created_at']);
        $userStmt->execute();
    }
    $userStmt->close();

    echo "Inserting mock subscription payments...\n";
    $subStmt = $db->prepare(
        "INSERT INTO subscription_history (user_id, plan, amount, `date`)
         VALUES (?, ?, ?, ?)"
    );

    $subscriptions = [
        // Babatunde Adeleke (Standard Plan - Active: 22 days remaining)
        [
            'user_id' => '219084',
            'plan'    => 'Standard Package',
            'amount'  => 10000,
            'date'    => date('Y-m-d H:i:s', strtotime('-8 days')),
        ],
        [
            'user_id' => '219084',
            'plan'    => 'Standard Package',
            'amount'  => 10000,
            'date'    => date('Y-m-d H:i:s', strtotime('-38 days')),
        ],

        // Dr. Folashade Alabi (Premium Plan - Active: 14 days remaining)
        [
            'user_id' => 'UI/STF/4821',
            'plan'    => 'Premium Package',
            'amount'  => 20000,
            'date'    => date('Y-m-d H:i:s', strtotime('-16 days')),
        ],
        [
            'user_id' => 'UI/STF/4821',
            'plan'    => 'Premium Package',
            'amount'  => 20000,
            'date'    => date('Y-m-d H:i:s', strtotime('-46 days')),
        ],
        [
            'user_id' => 'UI/STF/4821',
            'plan'    => 'Standard Package',
            'amount'  => 10000,
            'date'    => date('Y-m-d H:i:s', strtotime('-76 days')),
        ],

        // Chioma Okonkwo (Basic Plan - Expired: paid 35 days ago)
        [
            'user_id' => '224105',
            'plan'    => 'Basic Package',
            'amount'  => 5000,
            'date'    => date('Y-m-d H:i:s', strtotime('-35 days')),
        ],
    ];

    foreach ($subscriptions as $s) {
        $subStmt->bind_param('ssis', $s['user_id'], $s['plan'], $s['amount'], $s['date']);
        $subStmt->execute();
    }
    $subStmt->close();

    echo "Database seeded successfully!\n";
    echo "----------------------------------------\n";
    echo "Available Mock Accounts (Password: Password123):\n";
    echo "1. Student (Active Standard Plan): 219084 or b.adeleke@ui.edu.ng\n";
    echo "2. Staff (Active Premium Plan): UI/STF/4821 or f.alabi@ui.edu.ng\n";
    echo "3. Student (Expired Basic Plan): 224105 or c.okonkwo@ui.edu.ng\n";
    echo "4. Student (New / No Subscription): 238912 or i.danjuma@ui.edu.ng\n";
    echo "----------------------------------------\n";
} catch (Throwable $e) {
    echo "Error seeding database: " . $e->getMessage() . "\n";
    exit(1);
}
