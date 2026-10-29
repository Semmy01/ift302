<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = !empty($_SESSION['matric']);
$currentUserMatric = $_SESSION['matric'] ?? '';
$currentUserFullname = $_SESSION['fullname'] ?? '';

$pageTitle = 'UIISP - University of Ibadan Internet Service Provider';
$htmlClass = '';
?>
<?php include __DIR__ . '/partials/head.php'; ?>

<body class="catalogue-page">
  <!-- Minimal Navigation -->
  <header class="page-header">
    <div class="header-inner">
      <!-- Brand -->
      <a class="brand" href="index.php">
        <div style="width:2.25rem; height:2.25rem; background:#0b2545; color:#fff; border-radius:0.4rem; display:grid; place-items:center;">
          <span class="material-symbols-outlined">wifi</span>
        </div>
        <div>
          <span>UIISP</span>
          <span>University of Ibadan</span>
        </div>
      </a>

      <!-- Nav Links & Actions -->
      <div class="catalogue-nav">
        <div class="catalogue-links">
          <a href="#packages">Packages</a>
          <a href="#how-it-works">How It Works</a>
          <?php if ($isLoggedIn): ?>
            <a href="subscriber-dashboard.php" style="font-weight:700; color:#0b2545;">Dashboard</a>
            <a href="subscription-payment.php">Subscriptions</a>
            <a href="logout.php" style="color:#ba1a1a;">Logout</a>
          <?php else: ?>
            <a href="customer-registration-login.php?tab=login">Login</a>
            <a href="customer-registration-login.php?tab=register">Register</a>
          <?php endif; ?>
        </div>

        <?php
        $mobileMenuId = 'catalogue-mobile-nav';
        $mobileMenuBreakpoint = 'md';
        $mobileMenuLinks = [
            ['label' => 'Packages', 'href' => '#packages'],
            ['label' => 'How It Works', 'href' => '#how-it-works'],
        ];
        if ($isLoggedIn) {
            $mobileMenuLinks[] = ['label' => 'Dashboard (' . $currentUserMatric . ')', 'href' => 'subscriber-dashboard.php', 'current' => true];
            $mobileMenuLinks[] = ['label' => 'Subscribe / Renew', 'href' => 'subscription-payment.php'];
            $mobileMenuLinks[] = ['label' => 'Logout', 'href' => 'logout.php'];
        } else {
            $mobileMenuLinks[] = ['label' => 'Student / Staff Login', 'href' => 'customer-registration-login.php?tab=login'];
            $mobileMenuLinks[] = ['label' => 'Create New Account', 'href' => 'customer-registration-login.php?tab=register'];
        }
        ?>
        <?php include __DIR__ . '/partials/mobile-menu.php'; ?>

        <?php if ($isLoggedIn): ?>
          <a href="subscriber-dashboard.php" class="btn btn-primary" style="text-decoration:none; display:inline-flex; align-items:center; gap:0.4rem;">
            <span class="material-symbols-outlined" style="font-size:1.1rem;">dashboard</span>
            <span>My Dashboard</span>
          </a>
        <?php else: ?>
          <a href="#packages" class="btn btn-primary" style="text-decoration:none;">
            Get Started
          </a>
        <?php endif; ?>
      </div>
    </div>
  </header>

  <!-- Hero Banner -->
  <section class="hero">
    <div class="section-inner">
      <div class="hero-copy">
        <span class="status-dot"></span>
        Official Campus Wi-Fi Network &amp; RADIUS Gateway
      </div>
      <h1>
        High-Speed Campus Internet for Students &amp; Staff
      </h1>
      <p>
        Reliable, high-bandwidth Wi-Fi access across all University of Ibadan faculties, lecture halls, and residential halls. Instant 802.1X activation with your matriculation or staff credentials.
      </p>
      <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap; margin-top:2rem;">
        <a href="#packages" class="btn btn-primary" style="text-decoration:none; padding:0.85rem 1.75rem; font-size:1rem;">
          View 30-Day Packages
        </a>
        <?php if ($isLoggedIn): ?>
          <a href="subscriber-dashboard.php" class="btn btn-secondary" style="text-decoration:none; padding:0.85rem 1.75rem; font-size:1rem;">
            Open Subscriber Dashboard
          </a>
        <?php else: ?>
          <a href="customer-registration-login.php?tab=login" class="btn btn-secondary" style="text-decoration:none; padding:0.85rem 1.75rem; font-size:1rem;">
            Sign In to Renew
          </a>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Internet Packages Section -->
  <section class="content-section packages-section" id="packages">
    <div class="section-inner">
      <div class="section-heading">
        <h2>Choose Your Campus Wi-Fi Plan</h2>
        <p>Simple 30-day internet subscriptions tailored for your study, research, and streaming needs.</p>
      </div>

      <!-- 3 Cards Side-by-Side -->
      <div class="plan-grid">
        <!-- Basic Plan -->
        <div class="plan-card">
          <div>
            <div style="display:flex; justify-content:space-between; align-items:center;">
              <span style="font-size:0.75rem; font-weight:700; text-transform:uppercase; color:#64748b; letter-spacing:0.05em;">Tier 01</span>
              <span class="status-badge" style="background:#f1f5f9; color:#475569; font-size:0.75rem;">Budget Friendly</span>
            </div>
            <h3 style="margin-top:0.5rem; font-size:1.5rem; color:#0b2545;">Basic</h3>
            <div style="margin:1rem 0;">
              <span style="font-size:2rem; font-weight:800; color:#0b2545;">₦5,000</span>
              <span style="color:#64748b; font-size:0.9rem;">/ 30 Days</span>
            </div>
            <ul>
              <li>
                <span class="material-symbols-outlined">check_circle</span>
                <span>Speed: <strong>Up to 10 Mbps</strong></span>
              </li>
              <li>
                <span class="material-symbols-outlined">check_circle</span>
                <span><strong>2 Devices</strong> simultaneously connected</span>
              </li>
              <li>
                <span class="material-symbols-outlined">check_circle</span>
                <span>Full hostel &amp; faculty hall coverage</span>
              </li>
              <li>
                <span class="material-symbols-outlined">check_circle</span>
                <span>50 GB high-speed fair usage quota</span>
              </li>
            </ul>
          </div>
          <a href="subscription-payment.php?package=basic" class="btn btn-secondary" style="width:100%; margin-top:1.5rem; text-decoration:none;">
            Select Basic Plan
          </a>
        </div>

        <!-- Standard Plan (Recommended) -->
        <div class="plan-card plan-card-featured">
          <div class="featured-ribbon">
            Recommended Choice
          </div>
          <div>
            <div style="display:flex; justify-content:space-between; align-items:center;">
              <span style="font-size:0.75rem; font-weight:700; text-transform:uppercase; color:#d97706; letter-spacing:0.05em;">Tier 02</span>
              <span class="status-badge" style="background:#fef3c7; color:#92400e; font-size:0.75rem; font-weight:700;">Most Popular</span>
            </div>
            <h3 style="margin-top:0.5rem; font-size:1.5rem; color:#0b2545;">Standard</h3>
            <div style="margin:1rem 0;">
              <span style="font-size:2rem; font-weight:800; color:#0b2545;">₦10,000</span>
              <span style="color:#64748b; font-size:0.9rem;">/ 30 Days</span>
            </div>
            <ul>
              <li>
                <span class="material-symbols-outlined" style="color:#d97706;">check_circle</span>
                <span>Speed: <strong>Up to 35 Mbps</strong></span>
              </li>
              <li>
                <span class="material-symbols-outlined" style="color:#d97706;">check_circle</span>
                <span><strong>4 Devices</strong> simultaneously connected</span>
              </li>
              <li>
                <span class="material-symbols-outlined" style="color:#d97706;">check_circle</span>
                <span>High-priority HD streaming &amp; Zoom calls</span>
              </li>
              <li>
                <span class="material-symbols-outlined" style="color:#d97706;">check_circle</span>
                <span>150 GB high-speed fair usage quota</span>
              </li>
            </ul>
          </div>
          <a href="subscription-payment.php?package=standard" class="btn btn-primary" style="width:100%; margin-top:1.5rem; text-decoration:none;">
            Select Standard Plan
          </a>
        </div>

        <!-- Premium Plan -->
        <div class="plan-card">
          <div>
            <div style="display:flex; justify-content:space-between; align-items:center;">
              <span style="font-size:0.75rem; font-weight:700; text-transform:uppercase; color:#64748b; letter-spacing:0.05em;">Tier 03</span>
              <span class="status-badge" style="background:#e0e7ff; color:#3730a3; font-size:0.75rem;">Faculty &amp; Research</span>
            </div>
            <h3 style="margin-top:0.5rem; font-size:1.5rem; color:#0b2545;">Premium</h3>
            <div style="margin:1rem 0;">
              <span style="font-size:2rem; font-weight:800; color:#0b2545;">₦20,000</span>
              <span style="color:#64748b; font-size:0.9rem;">/ 30 Days</span>
            </div>
            <ul>
              <li>
                <span class="material-symbols-outlined">check_circle</span>
                <span>Speed: <strong>Up to 100 Mbps Ultra Fast</strong></span>
              </li>
              <li>
                <span class="material-symbols-outlined">check_circle</span>
                <span><strong>8 Devices</strong> simultaneously connected</span>
              </li>
              <li>
                <span class="material-symbols-outlined">check_circle</span>
                <span>Dedicated research &amp; server bandwidth priority</span>
              </li>
              <li>
                <span class="material-symbols-outlined">check_circle</span>
                <span>500 GB massive bandwidth pool</span>
              </li>
            </ul>
          </div>
          <a href="subscription-payment.php?package=premium" class="btn btn-secondary" style="width:100%; margin-top:1.5rem; text-decoration:none;">
            Select Premium Plan
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Brief 3-Step Guide -->
  <section class="content-section how-section" id="how-it-works">
    <div class="section-inner">
      <div class="section-heading">
        <h2>How It Works</h2>
        <p>Get securely connected to university internet in three seamless steps.</p>
      </div>
      <div class="steps-grid">
        <!-- Step 1 -->
        <div class="step-card">
          <div class="step-number-badge">1</div>
          <h3>1. Sign In or Register</h3>
          <p>
            Authenticate using your University matriculation number or staff identity record with single sign-on security.
          </p>
        </div>
        <!-- Step 2 -->
        <div class="step-card">
          <div class="step-number-badge">2</div>
          <h3>2. Select Plan &amp; Pay</h3>
          <p>
            Choose a 30-day package that fits your academic workload and checkout instantly via Paystack or Remita (RRR).
          </p>
        </div>
        <!-- Step 3 -->
        <div class="step-card">
          <div class="step-number-badge">3</div>
          <h3>3. Instant Wi-Fi Activation</h3>
          <p>
            Authenticate seamlessly across all campus hotspots on 'UI-Staff-Secure', 'UI-Student-WiFi', or 'eduroam'.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Minimal Footer -->
  <footer class="page-footer catalogue-footer">
    <div class="footer-inner">
      <div class="footer-brand">
        <span style="font-weight:700; color:#0b2545;">UIISP Portal</span>
        <p>© 2026 University of Ibadan Information Technology &amp; Media Services (ITeMS). All rights reserved.</p>
      </div>
      <div style="display:flex; gap:1.25rem; font-size:0.875rem;">
        <?php if ($isLoggedIn): ?>
          <a href="subscriber-dashboard.php" style="color:#0b2545; font-weight:600;">Dashboard</a>
          <a href="subscription-payment.php" style="color:#0b2545;">Subscriptions</a>
          <a href="logout.php" style="color:#ba1a1a;">Logout</a>
        <?php else: ?>
          <a href="customer-registration-login.php?tab=login" style="color:#0b2545; font-weight:600;">Student Login</a>
          <a href="customer-registration-login.php?tab=register" style="color:#0b2545;">Register</a>
        <?php endif; ?>
        <a href="mailto:items-support@ui.edu.ng" style="color:#64748b;">ITeMS Helpdesk</a>
      </div>
    </div>
  </footer>

  <?php include __DIR__ . '/partials/mobile-menu-script.php'; ?>
</body>
</html>
