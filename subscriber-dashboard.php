<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure user is authenticated
if (empty($_SESSION['matric'])) {
    $_SESSION['errors'] = ['general' => 'Please sign in to access your subscriber dashboard.'];
    header('Location: customer-registration-login.php?tab=login');
    exit;
}

require_once __DIR__ . '/Model/Customer.php';
require_once __DIR__ . '/Model/Subscription.php';

$matric = $_SESSION['matric'];
$customerModel = new Customer();
$userProfile = $customerModel->findByMatric($matric);

$fullname = $userProfile['fullname'] ?? $_SESSION['fullname'] ?? 'Subscriber';
$email    = $userProfile['email'] ?? $_SESSION['email'] ?? '';
$phone    = $userProfile['phone'] ?? $_SESSION['phone'] ?? '';

$subscriptionModel = new Subscription();
$subscription = $subscriptionModel->getActiveSubscription($matric);
$history = $subscriptionModel->getRecentPayments($matric, 10);

$pageTitle = 'UIISP Portal - Subscriber Customer Dashboard';
$htmlClass = '';

$successMessage = $_SESSION['success'] ?? '';
$errorMessage   = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);
?>
<?php include __DIR__ . '/partials/head.php'; ?>

<body class="dashboard-page">
  <!-- TopNavBar (Shared Component) -->
  <?php $portalPage = 'dashboard'; include __DIR__ . '/partials/portal-header.php'; ?>

  <!-- Global Content Container -->
  <main class="dashboard-main">
    <!-- Page Header / Intro Banner -->
    <div class="dashboard-intro">
      <div>
        <h1>Welcome, <?= htmlspecialchars($fullname) ?></h1>
        <p>
          Campus Network Unit • University of Ibadan Wi-Fi Access &amp; Self-Service Console
        </p>
      </div>
      <div>
        <?php if ($subscription['is_active']): ?>
          <div class="radius-status radius-status--online">
            <span class="material-symbols-outlined">verified_user</span>
            <span>UI-RADIUS ONLINE • AUTHENTICATED</span>
          </div>
        <?php else: ?>
          <div class="radius-status radius-status--offline">
            <span class="material-symbols-outlined">warning</span>
            <span>UI-RADIUS SUSPENDED • RENEWAL REQUIRED</span>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Flash Alerts -->
    <?php if (!empty($successMessage)): ?>
      <div class="alert alert--success">
        <span class="material-symbols-outlined">check_circle</span>
        <div><?= htmlspecialchars($successMessage) ?></div>
      </div>
    <?php endif; ?>
    <?php if (!empty($errorMessage)): ?>
      <div class="alert alert--error">
        <span class="material-symbols-outlined">error</span>
        <div><?= htmlspecialchars($errorMessage) ?></div>
      </div>
    <?php endif; ?>

    <!-- 1. Current Active Subscription Card -->
    <section class="dashboard-card plan-summary-card">
      <div class="plan-summary-header">
        <div class="plan-summary-info">
          <div class="plan-title-row">
            <h2><?= htmlspecialchars($subscription['plan_name']) ?></h2>
            <span class="status-badge <?= htmlspecialchars($subscription['status_class']) ?>">
              <span class="status-dot"></span>
              <?= htmlspecialchars($subscription['status']) ?>
            </span>
          </div>
          <div class="plan-expiry-row">
            <span class="material-symbols-outlined">schedule</span>
            <?php if ($subscription['is_active']): ?>
              <span>Expires in <strong><?= htmlspecialchars((string) $subscription['days_remaining']) ?> days</strong> — Valid until <?= htmlspecialchars($subscription['expiry_date']) ?></span>
            <?php else: ?>
              <span style="color:#dc2626; font-weight:600;">No active plan running. Please select a plan to activate your Wi-Fi connection.</span>
            <?php endif; ?>
          </div>
        </div>
        <div class="plan-summary-action">
          <a href="subscription-payment.php" class="btn btn-primary">
            <span class="material-symbols-outlined"><?= $subscription['is_active'] ? 'autorenew' : 'bolt' ?></span>
            <span><?= $subscription['is_active'] ? 'Renew / Extend Plan' : 'Activate Wi-Fi Plan' ?></span>
          </a>
        </div>
      </div>

      <!-- Telemetry Quota Bar (Design Spec compliant) -->
      <?php if ($subscription['is_active']): ?>
        <div class="quota-telemetry">
          <div class="quota-header">
            <div>
              <span class="quota-label">30-Day High-Speed Bandwidth Quota</span>
              <span class="quota-tier"><?= htmlspecialchars($subscription['speed']) ?></span>
            </div>
            <div class="quota-numbers">
              <strong><?= htmlspecialchars((string) $subscription['data_used_gb']) ?> GB</strong>
              <span>of <?= htmlspecialchars((string) $subscription['data_total_gb']) ?> GB used (<?= htmlspecialchars((string) $subscription['usage_percent']) ?>%)</span>
            </div>
          </div>
          <div class="quota-progress-track">
            <div class="quota-progress-fill <?= $subscription['usage_percent'] > 85 ? 'is-warning' : '' ?>" style="width: <?= min(100, max(5, $subscription['usage_percent'])) ?>%;"></div>
          </div>
        </div>
      <?php else: ?>
        <div style="margin-top:1.25rem; padding-top:1.25rem; border-top:1px solid #fecaca; background:#fff5f5; padding:1rem; border-radius:0.375rem; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem;">
          <div style="display:flex; align-items:center; gap:0.75rem;">
            <span class="material-symbols-outlined" style="color:#dc2626; font-size:1.75rem;">wifi_off</span>
            <div>
              <strong style="color:#991b1b; display:block;">Campus Wi-Fi Offline</strong>
              <span style="font-size:0.85rem; color:#7f1d1d;">Your credentials will remain inactive on campus hotspots until a 30-day package is purchased.</span>
            </div>
          </div>
          <a href="subscription-payment.php" class="btn btn-primary" style="background:#dc2626; border-color:#dc2626;">Choose Plan Now</a>
        </div>
      <?php endif; ?>
    </section>

    <!-- 2. Connection & Wi-Fi Access Credentials Card -->
    <section class="dashboard-card credentials-card">
      <div class="credentials-card-header">
        <div>
          <h2>Connection &amp; Wi-Fi Credentials</h2>
          <p>Authenticate on <strong>UI-Staff-Secure</strong>, <strong>UI-Student-WiFi</strong>, and <strong>eduroam</strong> campus networks</p>
        </div>
        <div class="device-pill">
          <span class="material-symbols-outlined">devices</span>
          <?php if ($subscription['is_active']): ?>
            <span><strong><?= htmlspecialchars((string) $subscription['connected_devices']) ?> of <?= htmlspecialchars((string) $subscription['max_devices']) ?></strong> devices connected</span>
          <?php else: ?>
            <span style="color:#991b1b;">0 Allowed (Inactive)</span>
          <?php endif; ?>
        </div>
      </div>
      <div class="credentials-grid">
        <!-- Username Field -->
        <div class="credential-field">
          <label>Campus RADIUS Username</label>
          <div class="credential-input-wrapper">
            <span class="material-symbols-outlined input-icon">person</span>
            <input readonly="" type="text" value="<?= htmlspecialchars($subscription['wifi_username']) ?>" id="wifi-user">
            <button onclick="copyToClipboard('wifi-user', this)" class="btn-copy" title="Copy Username" type="button">
              <span class="material-symbols-outlined">content_copy</span>
              <span>Copy</span>
            </button>
          </div>
        </div>
        <!-- Password Field (Masked with Show/Hide) -->
        <div class="credential-field">
          <label>WPA3-Enterprise Wi-Fi Password</label>
          <div class="credential-input-wrapper">
            <span class="material-symbols-outlined input-icon">lock</span>
            <input id="wifi-pass" readonly="" type="password" value="<?= htmlspecialchars($subscription['wifi_password']) ?>">
            <button aria-label="Toggle password visibility" class="btn-toggle-vis" onclick="togglePass('wifi-pass', 'pass-toggle-icon')" type="button">
              <span class="material-symbols-outlined" id="pass-toggle-icon">visibility</span>
            </button>
            <button onclick="copyToClipboard('wifi-pass', this)" class="btn-copy" title="Copy Password" type="button">
              <span class="material-symbols-outlined">content_copy</span>
              <span>Copy</span>
            </button>
          </div>
        </div>
      </div>
      <div class="credentials-footer-note">
        <span class="material-symbols-outlined">info</span>
        <span>Use these 802.1X credentials on your smartphone, laptop, or tablet. Your password synchronizes automatically upon plan renewal.</span>
      </div>
    </section>

    <!-- 3. Fast Actions Bar -->
    <section class="action-section">
      <h3>Quick Self-Service Shortcuts</h3>
      <div class="action-grid">
        <a href="subscription-payment.php" class="action-card">
          <div class="action-card-left">
            <div class="action-icon-badge action-icon--navy">
              <span class="material-symbols-outlined">autorenew</span>
            </div>
            <div>
              <span class="action-title">Renew Subscription</span>
              <span class="action-subtitle">Instant Paystack / Remita gateway</span>
            </div>
          </div>
          <span class="material-symbols-outlined action-arrow">arrow_forward</span>
        </a>
        <a href="index.php#packages" class="action-card">
          <div class="action-card-left">
            <div class="action-icon-badge action-icon--ochre">
              <span class="material-symbols-outlined">swap_horiz</span>
            </div>
            <div>
              <span class="action-title">Change Package Tier</span>
              <span class="action-subtitle">Switch to Basic, Standard or Premium</span>
            </div>
          </div>
          <span class="material-symbols-outlined action-arrow">arrow_forward</span>
        </a>
        <a href="#history" class="action-card">
          <div class="action-card-left">
            <div class="action-icon-badge action-icon--slate">
              <span class="material-symbols-outlined">receipt_long</span>
            </div>
            <div>
              <span class="action-title">Payment History</span>
              <span class="action-subtitle">View past invoices and receipts</span>
            </div>
          </div>
          <span class="material-symbols-outlined action-arrow">arrow_forward</span>
        </a>
        <a href="#account" class="action-card">
          <div class="action-card-left">
            <div class="action-icon-badge action-icon--navy">
              <span class="material-symbols-outlined">manage_accounts</span>
            </div>
            <div>
              <span class="action-title">Account &amp; Security</span>
              <span class="action-subtitle">Update contact &amp; change password</span>
            </div>
          </div>
          <span class="material-symbols-outlined action-arrow">arrow_forward</span>
        </a>
      </div>
    </section>

    <!-- 4. Recent Payment / Subscription History Snippet -->
    <section class="dashboard-card" id="history">
      <div class="history-card-header">
        <div>
          <h2>Payment &amp; Renewal History</h2>
          <p>Official university transaction receipts and network activation audit trail</p>
        </div>
        <span class="history-count-badge"><?= count($history) ?> Recorded Transactions</span>
      </div>
      <div class="history-list">
        <?php if (empty($history)): ?>
          <div class="empty-state">
            <span class="material-symbols-outlined">history_toggle_off</span>
            <p>No subscription payment records found yet.</p>
            <a href="subscription-payment.php" class="btn btn-primary">Purchase Your First Package</a>
          </div>
        <?php else: ?>
          <?php foreach ($history as $item): ?>
            <div class="history-item">
              <div class="history-item-left">
                <div class="history-check-icon">
                  <span class="material-symbols-outlined">check</span>
                </div>
                <div>
                  <strong class="history-plan-name"><?= htmlspecialchars($item['plan']) ?></strong>
                  <div class="history-date">
                    <span class="material-symbols-outlined" style="font-size:0.9rem;">calendar_today</span>
                    <?= htmlspecialchars(date('M j, Y • h:i A', strtotime($item['date']))) ?>
                  </div>
                </div>
              </div>
              <div class="history-item-right">
                <span class="history-amount">₦<?= number_format((float) $item['amount']) ?></span>
                <span class="status-badge status-badge--active">
                  <span class="status-dot"></span>
                  Paid &amp; Active
                </span>
                <button class="btn-receipt" onclick="viewReceipt('<?= htmlspecialchars($item['plan']) ?>', '<?= number_format((float)$item['amount']) ?>', '<?= htmlspecialchars(date('M j, Y h:i A', strtotime($item['date']))) ?>', '<?= htmlspecialchars($matric) ?>', '<?= htmlspecialchars($fullname) ?>', 'REC-<?= str_pad((string)$item['id'], 6, '0', STR_PAD_LEFT) ?>')" type="button" title="View Official Receipt">
                  <span class="material-symbols-outlined">receipt</span>
                  <span>Receipt</span>
                </button>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </section>

    <!-- 5. Account Settings & Password Security Section -->
    <section class="dashboard-card" id="account" style="margin-top:2rem;">
      <div class="history-card-header">
        <div>
          <h2>Account Profile &amp; Security</h2>
          <p>Manage your subscriber contact information and portal password</p>
        </div>
        <span class="status-badge" style="background:#eff4ff; color:#0b2545;">SSO Active</span>
      </div>

      <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:2rem; margin-top:1rem;">
        <!-- Left: Profile Details -->
        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:0.5rem; padding:1.25rem;">
          <h3 style="margin-top:0; color:#0b2545; font-size:1.1rem; display:flex; align-items:center; gap:0.5rem;">
            <span class="material-symbols-outlined" style="color:#0b2545;">badge</span>
            <span>Subscriber Profile Details</span>
          </h3>

          <form method="POST" action="process-profile.php">
            <input type="hidden" name="action" value="update_contact">

            <div style="margin-bottom:1rem;">
              <label style="display:block; font-size:0.8rem; font-weight:600; color:#64748b; margin-bottom:0.25rem; text-transform:uppercase;">Full Name</label>
              <input type="text" value="<?= htmlspecialchars($fullname) ?>" readonly style="width:100%; padding:0.6rem; border:1px solid #cbd5e1; border-radius:0.25rem; background:#eff4ff; font-weight:600; color:#0b2545;">
              <span style="font-size:0.75rem; color:#64748b; margin-top:0.2rem; display:block;">Registry authenticated record</span>
            </div>

            <div style="margin-bottom:1rem;">
              <label style="display:block; font-size:0.8rem; font-weight:600; color:#64748b; margin-bottom:0.25rem; text-transform:uppercase;">Matriculation / Staff ID</label>
              <input type="text" value="<?= htmlspecialchars($matric) ?>" readonly style="width:100%; padding:0.6rem; border:1px solid #cbd5e1; border-radius:0.25rem; background:#eff4ff; font-weight:600; color:#0b2545; font-family:monospace;">
            </div>

            <div style="margin-bottom:1rem;">
              <label style="display:block; font-size:0.8rem; font-weight:600; color:#64748b; margin-bottom:0.25rem; text-transform:uppercase;">Email Address</label>
              <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required style="width:100%; padding:0.6rem; border:1px solid #cbd5e1; border-radius:0.25rem; background:#fff; color:#0b2545;">
            </div>

            <div style="margin-bottom:1.25rem;">
              <label style="display:block; font-size:0.8rem; font-weight:600; color:#64748b; margin-bottom:0.25rem; text-transform:uppercase;">Phone Number</label>
              <input type="tel" name="phone" value="<?= htmlspecialchars($phone) ?>" required style="width:100%; padding:0.6rem; border:1px solid #cbd5e1; border-radius:0.25rem; background:#fff; color:#0b2545;">
            </div>

            <button type="submit" class="btn btn-secondary" style="width:100%;">
              <span class="material-symbols-outlined">save</span>
              <span>Save Contact Changes</span>
            </button>
          </form>
        </div>

        <!-- Right: Change Password -->
        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:0.5rem; padding:1.25rem;">
          <h3 style="margin-top:0; color:#0b2545; font-size:1.1rem; display:flex; align-items:center; gap:0.5rem;">
            <span class="material-symbols-outlined" style="color:#0b2545;">lock_reset</span>
            <span>Change Portal Password</span>
          </h3>

          <form method="POST" action="process-profile.php">
            <input type="hidden" name="action" value="change_password">

            <div style="margin-bottom:1rem;">
              <label style="display:block; font-size:0.8rem; font-weight:600; color:#64748b; margin-bottom:0.25rem; text-transform:uppercase;">Current Password</label>
              <input type="password" name="current_password" required placeholder="••••••••••••" style="width:100%; padding:0.6rem; border:1px solid #cbd5e1; border-radius:0.25rem; background:#fff; color:#0b2545;">
            </div>

            <div style="margin-bottom:1rem;">
              <label style="display:block; font-size:0.8rem; font-weight:600; color:#64748b; margin-bottom:0.25rem; text-transform:uppercase;">New Password</label>
              <input type="password" name="new_password" required placeholder="Min. 8 chars (letters &amp; numbers)" style="width:100%; padding:0.6rem; border:1px solid #cbd5e1; border-radius:0.25rem; background:#fff; color:#0b2545;">
            </div>

            <div style="margin-bottom:1.25rem;">
              <label style="display:block; font-size:0.8rem; font-weight:600; color:#64748b; margin-bottom:0.25rem; text-transform:uppercase;">Confirm New Password</label>
              <input type="password" name="confirm_password" required placeholder="Re-type new password" style="width:100%; padding:0.6rem; border:1px solid #cbd5e1; border-radius:0.25rem; background:#fff; color:#0b2545;">
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;">
              <span class="material-symbols-outlined">security</span>
              <span>Update Portal Password</span>
            </button>
          </form>
        </div>
      </div>
    </section>
  </main>

  <!-- Interactive Receipt Modal (Hidden by default) -->
  <div id="receipt-modal" class="modal-backdrop is-hidden" style="display:none;" hidden>
    <div class="modal-dialog">
      <div class="receipt-header">
        <div style="display:flex; align-items:center; gap:0.5rem;">
          <div style="background:#0b2545; color:#fff; width:2rem; height:2rem; border-radius:0.35rem; display:grid; place-items:center;">
            <span class="material-symbols-outlined" style="font-size:1.25rem;">wifi</span>
          </div>
          <div>
            <h3 style="margin:0; font-size:1.05rem; color:#0b2545;">UIISP Electronic Receipt</h3>
            <span style="font-size:0.75rem; color:#64748b;">University of Ibadan ITeMS</span>
          </div>
        </div>
        <button onclick="closeReceiptModal()" class="btn-close" type="button" aria-label="Close Receipt">
          <span class="material-symbols-outlined">close</span>
        </button>
      </div>
      <div class="receipt-body">
        <div class="receipt-row">
          <span>Receipt Number</span>
          <strong id="receipt-no">REC-000001</strong>
        </div>
        <div class="receipt-row">
          <span>Subscriber Name</span>
          <span id="receipt-subscriber">Babatunde Adeleke</span>
        </div>
        <div class="receipt-row">
          <span>Matric / Staff ID</span>
          <span id="receipt-matric">219084</span>
        </div>
        <div class="receipt-row">
          <span>Package Subscribed</span>
          <strong id="receipt-plan">Standard Package — 30 Days</strong>
        </div>
        <div class="receipt-row">
          <span>Transaction Date</span>
          <span id="receipt-date">Oct 29, 2026</span>
        </div>
        <div class="receipt-row">
          <span>Payment Status</span>
          <span style="color:#059669; font-weight:700;">CONFIRMED &amp; RADIUS ACTIVATED</span>
        </div>
        <div class="receipt-divider"></div>
        <div class="receipt-total-row">
          <span>Total Amount Paid</span>
          <strong id="receipt-amount">₦10,000</strong>
        </div>
      </div>
      <div class="receipt-actions">
        <button onclick="window.print()" class="btn btn-secondary" type="button">
          <span class="material-symbols-outlined">print</span>
          <span>Print Receipt</span>
        </button>
        <button onclick="closeReceiptModal()" class="btn btn-primary" type="button">Close</button>
      </div>
    </div>
  </div>

  <!-- Interactive Scripts -->
  <script>
    function togglePass(inputId, iconId) {
      const p = document.getElementById(inputId);
      const ic = document.getElementById(iconId);
      if (p.type === 'password') {
        p.type = 'text';
        ic.textContent = 'visibility_off';
      } else {
        p.type = 'password';
        ic.textContent = 'visibility';
      }
    }

    function copyToClipboard(inputId, button) {
      const input = document.getElementById(inputId);
      if (!input) return;
      const text = input.value;
      const showCopied = () => {
        const originalHtml = button.innerHTML;
        button.innerHTML = '<span class="material-symbols-outlined" style="color:#059669; font-size:1.1rem;">check</span><span style="color:#059669; font-weight:700;">Copied!</span>';
        setTimeout(() => {
          button.innerHTML = originalHtml;
        }, 2000);
      };

      if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(showCopied).catch(() => {
          input.select();
          document.execCommand('copy');
          showCopied();
        });
      } else {
        input.select();
        document.execCommand('copy');
        showCopied();
      }
    }

    function viewReceipt(plan, amount, date, matric, name, recNo) {
      document.getElementById('receipt-no').textContent = recNo;
      document.getElementById('receipt-plan').textContent = plan;
      document.getElementById('receipt-amount').textContent = '₦' + amount;
      document.getElementById('receipt-date').textContent = date;
      document.getElementById('receipt-matric').textContent = matric;
      document.getElementById('receipt-subscriber').textContent = name;
      
      const modal = document.getElementById('receipt-modal');
      modal.hidden = false;
      modal.style.display = 'grid';
      modal.classList.remove('is-hidden');
    }

    function closeReceiptModal() {
      const modal = document.getElementById('receipt-modal');
      modal.hidden = true;
      modal.style.display = 'none';
      modal.classList.add('is-hidden');
    }

    // Close receipt modal when clicking outside the dialog card
    document.getElementById('receipt-modal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeReceiptModal();
      }
    });

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeReceiptModal();
      }
    });
  </script>

  <!-- Footer (Shared Component) -->
  <?php include __DIR__ . '/partials/portal-footer.php'; ?>
  <?php include __DIR__ . '/partials/mobile-menu-script.php'; ?>
</body>
</html>
