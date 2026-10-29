<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pkg = $_GET['package'] ?? $_POST['package'] ?? 'standard';

// Ensure user is logged in before allowing checkout
if (empty($_SESSION['matric'])) {
    $_SESSION['errors'] = ['general' => 'Please sign in or create an account to complete your subscription purchase.'];
    $returnUrl = 'subscription-payment.php?package=' . urlencode($pkg);
    header('Location: customer-registration-login.php?tab=login&redirect=' . urlencode($returnUrl));
    exit;
}

require_once __DIR__ . '/Model/Subscription.php';
require_once __DIR__ . '/Model/Customer.php';

$matric = $_SESSION['matric'];
$customerModel = new Customer();
$user = $customerModel->findByMatric($matric);

$subscriberName = $user['fullname'] ?? $_SESSION['fullname'] ?? 'Subscriber';
$subscriberId   = $matric;
$subscriberEmail= $user['email'] ?? $_SESSION['email'] ?? '';

$packages = [
    'basic' => [
        'key'         => 'basic',
        'plan'        => 'Basic Package',
        'name'        => 'Basic Package — ₦5,000 / 30 Days',
        'price'       => '₦5,000',
        'amount'      => 5000,
        'speed'       => 'Up to 10 Mbps',
        'devices'     => 2,
        'description' => 'Ideal for general browsing, course portal, and hostel study.',
    ],
    'standard' => [
        'key'         => 'standard',
        'plan'        => 'Standard Package',
        'name'        => 'Standard Package — ₦10,000 / 30 Days',
        'price'       => '₦10,000',
        'amount'      => 10000,
        'speed'       => 'Up to 35 Mbps',
        'devices'     => 4,
        'description' => 'Fast speed for video streaming, research, and multi-device connection.',
    ],
    'premium' => [
        'key'         => 'premium',
        'plan'        => 'Premium Package',
        'name'        => 'Premium Package — ₦20,000 / 30 Days',
        'price'       => '₦20,000',
        'amount'      => 20000,
        'speed'       => 'Up to 100 Mbps',
        'devices'     => 8,
        'description' => 'Ultra high-speed priority connection for faculty, labs, and heavy workloads.',
    ],
];

// Handle payment form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedKey = $_POST['package'] ?? $pkg;
    $selectedPkg = $packages[$selectedKey] ?? $packages['standard'];
    $planName    = $selectedPkg['plan'];
    $amount      = (int) $selectedPkg['amount'];

    try {
        $subscriptionModel = new Subscription();
        $saved = $subscriptionModel->recordPayment($matric, $planName, $amount);

        if ($saved) {
            $_SESSION['success'] = "Payment successful! Your {$planName} (₦" . number_format($amount) . ") has been activated and RADIUS access is now online.";
            header('Location: subscriber-dashboard.php');
            exit;
        } else {
            $_SESSION['error'] = 'Failed to record subscription payment. Please try again.';
            header('Location: subscription-payment.php?package=' . urlencode($selectedKey));
            exit;
        }
    } catch (Throwable $e) {
        $_SESSION['error'] = 'Error processing subscription: ' . $e->getMessage();
        header('Location: subscription-payment.php?package=' . urlencode($selectedKey));
        exit;
    }
}

$selected = $packages[$pkg] ?? $packages['standard'];
$package  = $selected['name'];
$price    = $selected['price'];

$pageTitle = 'Subscription Checkout & Instant Payment Gateway | UIISP Portal';
$htmlClass = '';
?>
<?php include __DIR__ . '/partials/head.php'; ?>

<body class="checkout-page">
  <!-- TopNavBar (Shared Component) -->
  <?php $portalPage = 'checkout'; include __DIR__ . '/partials/portal-header.php'; ?>

  <!-- Step Bar & Breadcrumb Sub-bar -->
  <section class="checkout-progress">
    <div class="progress-inner">
      <!-- Breadcrumb -->
      <div style="display:flex; align-items:center; gap:0.5rem; font-size:0.85rem; color:#64748b; margin-bottom:0.75rem;">
        <a href="subscriber-dashboard.php" style="color:#0b2545; text-decoration:none; font-weight:600;">Dashboard</a>
        <span class="material-symbols-outlined" style="font-size:1rem;">chevron_right</span>
        <a href="index.php#packages" style="color:#0b2545; text-decoration:none;">Packages</a>
        <span class="material-symbols-outlined" style="font-size:1rem;">chevron_right</span>
        <span style="color:#64748b;">Checkout</span>
      </div>
      <!-- 3-Step Checkout Flow -->
      <div class="step-progress-row">
        <!-- Step 1 -->
        <div class="step-progress-item step--done">
          <span class="step-circle"><span class="material-symbols-outlined">check</span></span>
          <div class="step-labels">
            <span class="step-number">Step 1</span>
            <span class="step-name">Plan Selection</span>
          </div>
        </div>
        <!-- Step 2 (Active) -->
        <div class="step-progress-item step--active">
          <span class="step-circle">2</span>
          <div class="step-labels">
            <span class="step-number">Step 2 (Active)</span>
            <span class="step-name">Payment Method</span>
          </div>
        </div>
        <!-- Step 3 -->
        <div class="step-progress-item">
          <span class="step-circle">3</span>
          <div class="step-labels">
            <span class="step-number">Step 3</span>
            <span class="step-name">Instant Activation</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Main Content Canvas: 2-Column Interface -->
  <main class="checkout-main">
    <div class="checkout-intro">
      <h1>Complete Subscription Checkout</h1>
      <p>Review your bandwidth tier, select your payment channel, and activate immediate campus Wi-Fi access.</p>
    </div>

    <?php if (!empty($_SESSION['error'])): ?>
      <div class="alert alert--error" style="margin-bottom:1.5rem;">
        <span class="material-symbols-outlined">error</span>
        <div><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
      </div>
    <?php endif; ?>

    <form method="POST" action="subscription-payment.php" class="checkout-layout" id="checkout-form">
      <input type="hidden" name="package" id="selected-package-input" value="<?= htmlspecialchars($selected['key']) ?>">

      <!-- Left Column: Simplified Payment Flow -->
      <section class="checkout-column">
        <!-- Selected Package Summary Card -->
        <div class="checkout-card">
          <div class="selected-pkg-row">
            <div style="display:flex; align-items:center; gap:0.75rem;">
              <div class="pkg-icon-box">
                <span class="material-symbols-outlined">wifi</span>
              </div>
              <div>
                <span style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.05em; color:#64748b; font-weight:700;">Selected Package</span>
                <h2 style="margin:0; font-size:1.25rem; color:#0b2545;" id="selected-plan-title"><?= htmlspecialchars($selected['plan']) ?></h2>
                <span style="font-size:0.85rem; color:#475569;" id="selected-plan-speed"><?= htmlspecialchars($selected['speed']) ?> • <?= htmlspecialchars((string)$selected['devices']) ?> Devices</span>
              </div>
            </div>
            <div class="pkg-selector-buttons">
              <?php foreach ($packages as $p): ?>
                <button type="button" class="btn-tier-select <?= $p['key'] === $selected['key'] ? 'is-selected' : '' ?>" onclick="selectTier(this, '<?= $p['key'] ?>', '<?= htmlspecialchars($p['plan']) ?>', '<?= htmlspecialchars($p['price']) ?>', '<?= htmlspecialchars($p['speed']) ?>', '<?= $p['devices'] ?>')">
                  <?= htmlspecialchars($p['plan']) ?> (<?= htmlspecialchars($p['price']) ?>)
                </button>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <!-- Duration Selection Card -->
        <div class="checkout-card">
          <h3 class="checkout-card-title">Duration Selection</h3>
          <label class="duration-option">
            <div style="display:flex; align-items:center; gap:0.75rem;">
              <input checked="" name="duration" type="radio" value="30days">
              <div>
                <span style="font-weight:700; color:#0b2545; display:block;">1 Month (30 Days) Full Access</span>
                <span style="font-size:0.85rem; color:#64748b;">Valid across all hostels, faculties, and official libraries</span>
              </div>
            </div>
            <span class="duration-price" id="duration-price-display"><?= htmlspecialchars($selected['price']) ?></span>
          </label>
        </div>

        <!-- Payment Method Card -->
        <div class="checkout-card">
          <h3 class="checkout-card-title">Select Secure Payment Channel</h3>
          <div class="payment-methods-grid">
            <!-- Option 1: Paystack -->
            <label class="payment-method-card is-active-method" id="pm-paystack">
              <div style="display:flex; align-items:center; gap:0.75rem;">
                <input checked="" name="payment_method" type="radio" value="paystack" onchange="updatePaymentMethod(this)">
                <div>
                  <span style="font-weight:700; color:#0b2545; display:block;">Debit Card / Bank Transfer (Paystack)</span>
                  <span style="font-size:0.85rem; color:#64748b;">Instant activation with Mastercard, VISA, Verve or USSD</span>
                </div>
              </div>
              <span class="material-symbols-outlined" style="color:#059669; font-size:1.75rem;">credit_card</span>
            </label>

            <!-- Option 2: Remita -->
            <label class="payment-method-card" id="pm-remita">
              <div style="display:flex; align-items:center; gap:0.75rem;">
                <input name="payment_method" type="radio" value="remita" onchange="updatePaymentMethod(this)">
                <div>
                  <span style="font-weight:700; color:#0b2545; display:block;">Remita e-Collection (RRR)</span>
                  <span style="font-size:0.85rem; color:#64748b;">Official University of Ibadan Treasury Reference</span>
                </div>
              </div>
              <span class="material-symbols-outlined" style="color:#d97706; font-size:1.75rem;">account_balance</span>
            </label>
          </div>
        </div>

        <!-- Customer Details Summary -->
        <div class="checkout-card">
          <h3 class="checkout-card-title">Subscriber Information</h3>
          <div class="subscriber-info-grid">
            <div class="info-cell">
              <span class="info-label">Subscriber Name</span>
              <span class="info-val"><?= htmlspecialchars($subscriberName) ?></span>
            </div>
            <div class="info-cell">
              <span class="info-label">Staff / Matriculation ID</span>
              <span class="info-val"><?= htmlspecialchars($subscriberId) ?></span>
            </div>
            <div class="info-cell">
              <span class="info-label">Email Address</span>
              <span class="info-val"><?= htmlspecialchars($subscriberEmail) ?></span>
            </div>
            <div class="info-cell">
              <span class="info-label">RADIUS Server Gateway</span>
              <span class="info-val" style="color:#059669; font-weight:600;">radius.ui.edu.ng (Port 1812)</span>
            </div>
          </div>
        </div>
      </section>

      <!-- Right Column: Order Summary -->
      <aside class="order-summary">
        <div class="order-summary-box">
          <h3 class="order-summary-title">Order Summary</h3>

          <!-- Line items -->
          <div class="order-line-items">
            <div class="order-line">
              <span id="summary-pkg-label"><?= htmlspecialchars($selected['plan']) ?></span>
              <span id="summary-pkg-price"><?= htmlspecialchars($selected['price']) ?></span>
            </div>
            <div class="order-line">
              <span>Duration</span>
              <span>30 Days</span>
            </div>
            <div class="order-line">
              <span>Network Activation Fee</span>
              <span style="color:#059669; font-weight:600;">FREE (₦0.00)</span>
            </div>
          </div>

          <div class="order-divider"></div>

          <!-- Total -->
          <div class="order-total-row">
            <span>Total Payable</span>
            <strong id="summary-total"><?= htmlspecialchars($selected['price']) ?></strong>
          </div>

          <!-- Primary Action CTA -->
          <div style="margin-top:1.5rem;">
            <button id="pay-btn" type="submit" class="btn btn-checkout">
              <span class="material-symbols-outlined">lock</span>
              <span id="pay-btn-text">Pay <?= htmlspecialchars($selected['price']) ?> &amp; Activate Wi-Fi</span>
            </button>
            <div class="checkout-guarantee">
              <span class="material-symbols-outlined">bolt</span>
              <span>Instant RADIUS authentication upon successful payment.</span>
            </div>
          </div>
        </div>
      </aside>
    </form>
  </main>

  <script>
    function selectTier(btn, key, plan, price, speed, devices) {
      document.getElementById('selected-package-input').value = key;
      document.getElementById('selected-plan-title').textContent = plan;
      document.getElementById('selected-plan-speed').textContent = speed + ' • ' + devices + ' Devices';
      document.getElementById('duration-price-display').textContent = price;
      document.getElementById('summary-pkg-label').textContent = plan;
      document.getElementById('summary-pkg-price').textContent = price;
      document.getElementById('summary-total').textContent = price;
      document.getElementById('pay-btn-text').textContent = 'Pay ' + price + ' & Activate Wi-Fi';

      document.querySelectorAll('.btn-tier-select').forEach(b => b.classList.remove('is-selected'));
      if (btn) btn.classList.add('is-selected');
    }

    function updatePaymentMethod(radio) {
      document.querySelectorAll('.payment-method-card').forEach(c => c.classList.remove('is-active-method'));
      radio.closest('.payment-method-card').classList.add('is-active-method');
    }

    document.getElementById('checkout-form').addEventListener('submit', function() {
      const btn = document.getElementById('pay-btn');
      btn.disabled = true;
      btn.innerHTML = '<span class="material-symbols-outlined" style="animation:spin 1s linear infinite;">sync</span><span>Processing RADIUS Payment...</span>';
    });
  </script>

  <!-- Footer (Shared Component) -->
  <?php include __DIR__ . '/partials/portal-footer.php'; ?>
  <?php include __DIR__ . '/partials/mobile-menu-script.php'; ?>
</body>
</html>
