<?php
$currentUser = [
    'fullname' => $_SESSION['fullname'] ?? 'Subscriber',
    'matric'   => $_SESSION['matric'] ?? 'UI-USER',
];

if (($portalPage ?? '') === 'dashboard'):
    $mobileMenuId = 'portal-dashboard-mobile-nav';
    $mobileMenuBreakpoint = 'lg';
    $mobileMenuLinks = [
        ['label' => 'Dashboard Overview', 'href' => 'subscriber-dashboard.php', 'current' => true],
        ['label' => 'Renew / Pay Subscription', 'href' => 'subscription-payment.php'],
        ['label' => 'Explore 30-Day Packages', 'href' => 'index.php#packages'],
        ['label' => 'Account & Security', 'href' => 'subscriber-dashboard.php#account'],
        ['label' => 'Sign Out (' . $currentUser['matric'] . ')', 'href' => 'logout.php'],
    ];
?>
<header class="page-header portal-header">
  <div class="header-inner">
    <!-- Left: Logo & Collegiate Brand Mark -->
    <div class="portal-brand">
      <a href="index.php" style="text-decoration:none; color:inherit; display:flex; align-items:center; gap:0.6rem;">
        <div style="width:2.25rem; height:2.25rem; background:#0b2545; color:#fff; border-radius:0.4rem; display:grid; place-items:center;">
          <span class="material-symbols-outlined">wifi</span>
        </div>
        <div>
          <span style="font-weight:700; color:#0b2545; display:block; line-height:1.2;">UIISP Portal</span>
          <span style="display:block; font-size:0.75rem; color:#64748b;">University of Ibadan ISP</span>
        </div>
      </a>
      <!-- Desktop Navigation Items -->
      <nav class="desktop-nav">
        <a href="subscriber-dashboard.php" class="is-active">Dashboard</a>
        <a href="subscription-payment.php">Renew / Pay</a>
        <a href="index.php#packages">Packages</a>
        <a href="subscriber-dashboard.php#account">Account</a>
      </nav>
      <?php include __DIR__ . '/mobile-menu.php'; ?>
    </div>
    <!-- Right: Quick Status & Profile Info -->
    <div class="portal-profile">
      <a href="logout.php" title="Sign Out" class="btn-portal-icon" style="color:#ba1a1a; text-decoration:none;">
        <span class="material-symbols-outlined">logout</span>
      </a>
      <div class="profile-separator"></div>
      <!-- Authenticated Profile Anchor linking to Account settings -->
      <a href="subscriber-dashboard.php#account" class="profile-badge" title="Manage Account & Security" style="text-decoration:none; color:inherit; cursor:pointer;">
        <div class="profile-avatar">
          <span class="material-symbols-outlined">account_circle</span>
        </div>
        <div class="profile-details">
          <span class="profile-name"><?= htmlspecialchars($currentUser['fullname']) ?></span>
          <span class="profile-id">ID: <?= htmlspecialchars($currentUser['matric']) ?></span>
        </div>
      </a>
    </div>
  </div>
</header>
<?php
elseif (($portalPage ?? '') === 'checkout'):
    $mobileMenuId = 'portal-checkout-mobile-nav';
    $mobileMenuBreakpoint = 'md';
    $mobileMenuLinks = [
        ['label' => 'Back to Dashboard', 'href' => 'subscriber-dashboard.php'],
        ['label' => 'All Packages', 'href' => 'index.php#packages'],
        ['label' => 'Sign Out', 'href' => 'logout.php'],
    ];
?>
<header class="page-header portal-header">
  <div class="header-inner">
    <!-- Brand & Product -->
    <div class="portal-brand">
      <a href="index.php" style="text-decoration:none; color:inherit; display:flex; align-items:center; gap:0.6rem;">
        <div style="width:2.25rem; height:2.25rem; background:#0b2545; color:#fff; border-radius:0.4rem; display:grid; place-items:center;">
          <span class="material-symbols-outlined">wifi_protected_setup</span>
        </div>
        <div>
          <span style="font-weight:700; color:#0b2545; display:block; line-height:1.2;">UIISP Gateway</span>
          <span style="display:block; font-size:0.75rem; color:#64748b;">University of Ibadan ISP</span>
        </div>
      </a>
      <!-- Navigation Links -->
      <nav class="desktop-nav">
        <a href="subscriber-dashboard.php">Dashboard</a>
        <a href="subscription-payment.php" class="is-active">Checkout</a>
        <a href="index.php#packages">Packages</a>
      </nav>
      <?php include __DIR__ . '/mobile-menu.php'; ?>
    </div>
    <!-- Trailing Cluster -->
    <div class="portal-profile">
      <a href="logout.php" title="Sign Out" class="btn-portal-icon" style="color:#ba1a1a; text-decoration:none;">
        <span class="material-symbols-outlined">logout</span>
      </a>
      <div class="profile-separator"></div>
      <a href="subscriber-dashboard.php#account" class="profile-badge" style="text-decoration:none; color:inherit;">
        <div class="profile-avatar">
          <span class="material-symbols-outlined">account_circle</span>
        </div>
        <div class="profile-details">
          <span class="profile-name"><?= htmlspecialchars($currentUser['fullname']) ?></span>
          <span class="profile-id">ID: <?= htmlspecialchars($currentUser['matric']) ?></span>
        </div>
      </a>
    </div>
  </div>
</header>
<?php endif; ?>
