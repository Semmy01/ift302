<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/Model/Subscription.php';

$pageTitle = 'UIISP Portal - Subscriber Customer Dashboard';
$htmlClass = '';

$subscription = [
    'plan_name'         => 'Standard Plan - 30 Days',
    'status'            => 'Active',
    'days_remaining'    => 18,
    'expiry_date'       => 'March 28, 2025',
    'connected_devices' => 3,
    'max_devices'       => 4,
    'wifi_username'     => 'ui-id/' . ($_SESSION['matric'] ?? 'dam.adeleke'),
    'wifi_password'     => 'TechFaculty#2025!',
];

// Recent payment history for the logged-in user only (from MySQL)
$history = [];
if (!empty($_SESSION['matric'])) {
    try {
        $history = (new Subscription())->getRecentPayments($_SESSION['matric']);
    } catch (Throwable $e) {
        $history = [];
    }
}

?>
<?php include __DIR__ . '/partials/head.php'; ?>
<body class="dashboard-page">
<!-- TopNavBar (Shared Component) -->
<?php $portalPage = 'dashboard'; include __DIR__ . '/partials/portal-header.php'; ?>
<!-- Global Content Container -->
<main class="dashboard-main">
<!-- Page Header -->
<div class="dashboard-intro">
<div>
<h1>Subscriber Dashboard</h1>
<p>
          Campus Network Unit • University of Ibadan Wi-Fi Access
        </p>
</div>
<div>
<span class="material-symbols-outlined">verified_user</span>
<span>UI-RADIUS VALIDATED</span>
</div>
</div>
<!-- 1. Current Active Subscription Card -->
<section class="dashboard-card">
<div>
<div>
<div>
<h2><?= htmlspecialchars($subscription['plan_name']) ?></h2>
<span>
<span></span>
            <?= htmlspecialchars($subscription['status']) ?>
          </span>
</div>
<div>
<span class="material-symbols-outlined">schedule</span>
<span>Expires in <strong><?= htmlspecialchars((string)$subscription['days_remaining']) ?> days</strong> — <?= htmlspecialchars($subscription['expiry_date']) ?></span>
</div>
</div>
<div>
<a href="subscription-payment.php" style="text-decoration:none;">
<button type="button"><span class="material-symbols-outlined">autorenew</span> Renew Subscription</button>
</a>
</div>
</div>
</section>
<!-- 2. Connection & Wi-Fi Access Credentials Card -->
<section class="dashboard-card credentials-card">
<div>
<div>
<h2>Connection &amp; Wi-Fi Credentials</h2>
<p>Authenticate on <strong>UI-Staff-Secure</strong> and <strong>eduroam</strong> campus networks</p>
</div>
<div>
<span class="material-symbols-outlined">devices</span>
<span><strong><?= htmlspecialchars((string)$subscription['connected_devices']) ?> of <?= htmlspecialchars((string)$subscription['max_devices']) ?></strong> devices connected</span>
</div>
</div>
<div>
<!-- Username Field -->
<div>
<label>Wi-Fi Username</label>
<div>
<span class="material-symbols-outlined">person</span>
<input readonly="" type="text" value="<?= htmlspecialchars($subscription['wifi_username']) ?>">
<button onclick="navigator.clipboard.writeText('<?= htmlspecialchars($subscription['wifi_username']) ?>')" title="Copy Username" type="button">
<span class="material-symbols-outlined">content_copy</span>
<span>Copy</span>
</button>
</div>
</div>
<!-- Password Field (Masked with Show/Hide) -->
<div>
<label>Wi-Fi Password</label>
<div>
<span class="material-symbols-outlined">lock</span>
<input id="wifi-pass" readonly="" type="password" value="<?= htmlspecialchars($subscription['wifi_password']) ?>">
<button aria-label="Toggle password visibility" onclick="const p = document.getElementById('wifi-pass'); const ic = document.getElementById('pass-toggle-icon'); if (p.type === 'password') { p.type = 'text'; ic.textContent = 'visibility_off'; } else { p.type = 'password'; ic.textContent = 'visibility'; }" type="button">
<span class="material-symbols-outlined" id="pass-toggle-icon">visibility</span>
</button>
<button onclick="navigator.clipboard.writeText('<?= htmlspecialchars($subscription['wifi_password']) ?>')" title="Copy Password" type="button">
<span class="material-symbols-outlined">content_copy</span>
<span>Copy</span>
</button>
</div>
</div>
</div>
</section>
<!-- 3. Fast Actions Bar -->
<section class="action-section">
<h3>Fast Actions</h3>
<div>
<a href="subscription-payment.php" style="text-decoration:none;">
<button type="button"><div><div><span class="material-symbols-outlined">autorenew</span></div><div><span>Renew Plan</span><span data-action-note>Extend current plan</span></div></div><span class="material-symbols-outlined">arrow_forward</span></button>
</a>
<a href="index.php#packages">
<div>
<div>
<span class="material-symbols-outlined">swap_horiz</span>
</div>
<div>
<span>Change Package</span>
<span>Switch bandwidth tier</span>
</div>
</div>
<span class="material-symbols-outlined">arrow_forward</span>
</a>
<a href="#history">
<div>
<div>
<span class="material-symbols-outlined">receipt_long</span>
</div>
<div>
<span>View Payment History</span>
<span>Invoices &amp; receipts</span>
</div>
</div>
<span class="material-symbols-outlined">arrow_forward</span>
</a>
</div>
</section>
<!-- 4. Recent Payment / Subscription History Snippet -->
<section class="dashboard-card" id="history">
<div>
<div>
<h2>Recent Payment History</h2>
<p>Past renewal transactions and downloadable official receipts</p>
</div>
<a href="#">View Full History</a>
</div>
<div>
<?php if (empty($history)): ?>
<p style="padding: 0.75rem 0; color:#6b7280;">No payment history found.</p>
<?php else: ?>
<?php foreach ($history as $item): ?>
<div style="display:flex; justify-content:space-between; align-items:center; padding: 0.75rem 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
  <div>
    <strong><?= htmlspecialchars($item['plan']) ?></strong>
    <div style="font-size:0.85rem; color:#6b7280;"><?= htmlspecialchars(date('M j, Y • h:i A', strtotime($item['date']))) ?></div>
  </div>
  <div>
    <span style="font-weight:600;">₦<?= number_format((float)$item['amount'], 2) ?></span>
    <span style="background:#d1fae5; color:#065f46; font-size:0.75rem; padding:0.2rem 0.5rem; border-radius:9999px; margin-left:0.5rem;">Paid</span>
  </div>
</div>
<?php endforeach; ?>
<?php endif; ?>
</div>
</section>
</main>
<!-- Footer (Shared Component) -->
<?php include __DIR__ . '/partials/portal-footer.php'; ?>
<?php include __DIR__ . '/partials/mobile-menu-script.php'; ?>
</body></html>
