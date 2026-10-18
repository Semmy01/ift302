<?php
$currentUser = [
    'fullname' => $_SESSION['fullname'] ?? 'Engr. Damilola Adeleke',
    'matric'   => $_SESSION['matric'] ?? 'STF/2019/4821',
];

if ($portalPage === 'dashboard'):
    $mobileMenuId = 'portal-dashboard-mobile-nav';
    $mobileMenuBreakpoint = 'lg';
    $mobileMenuLinks = [
        ['label' => 'Dashboard', 'href' => 'subscriber-dashboard.php', 'current' => true],
        ['label' => 'Packages', 'href' => 'index.php#packages'],
        ['label' => 'Subscriptions', 'href' => 'subscription-payment.php'],
        ['label' => 'Logout', 'href' => 'logout.php'],
    ];
?>
<header class="page-header portal-header">
<div class="header-inner">
<!-- Left: Logo & Collegiate Brand Mark -->
<div class="portal-brand">
<a href="index.php">
<div>
<span class="material-symbols-outlined">wifi</span>
</div>
<div>
<span>UIISP Portal</span>
<span>University of Ibadan ISP</span>
</div>
</a>
<!-- Desktop Navigation Items -->
<nav class="desktop-nav">
<a href="subscriber-dashboard.php">Dashboard</a>
<a href="index.php#packages">Packages</a>
<a href="subscription-payment.php">Subscriptions</a>
<a href="logout.php">Logout</a>
</nav>
<?php include __DIR__ . '/mobile-menu.php'; ?>
</div>
<!-- Right: Quick Status & Profile Info -->
<div class="portal-profile">
<button aria-label="Notifications" type="button">
<span class="material-symbols-outlined">notifications</span>
<span></span>
</button>
<a href="logout.php" title="Logout" style="color:inherit; text-decoration:none;">
<button aria-label="Logout" type="button">
<span class="material-symbols-outlined">logout</span>
</button>
</a>
<div></div>
<!-- Authenticated Profile Anchor -->
<div>
<div>
<span class="material-symbols-outlined">account_circle</span>
</div>
<div>
<span><?= htmlspecialchars($currentUser['fullname']) ?></span>
<span><?= htmlspecialchars($currentUser['matric']) ?></span>
</div>
</div>
</div>
</div>
</header>
<?php
elseif ($portalPage === 'checkout'):
    $mobileMenuId = 'portal-checkout-mobile-nav';
    $mobileMenuBreakpoint = 'md';
    $mobileMenuLinks = [
        ['label' => 'Packages', 'href' => 'index.php#packages', 'current' => true],
        ['label' => 'Dashboard', 'href' => 'subscriber-dashboard.php'],
        ['label' => 'Logout', 'href' => 'logout.php'],
    ];
?>
<header class="page-header portal-header">
<div class="header-inner">
<!-- Brand & Product -->
<div class="portal-brand">
<a href="index.php">
<div>
<span class="material-symbols-outlined" data-icon="wifi_protected_setup">wifi_protected_setup</span>
</div>
<div>
<span>UIISP Gateway</span>
<span>University of Ibadan ISP</span>
</div>
</a>
</div>
<!-- Navigation Links -->
<nav class="desktop-nav">
<a href="index.php#packages">Packages</a>
<a href="subscriber-dashboard.php">Dashboard</a>
<a href="logout.php">Logout</a>
</nav>
<?php include __DIR__ . '/mobile-menu.php'; ?>
<!-- Trailing Cluster -->
<div class="portal-profile">
<button title="Notifications" type="button">
<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
</button>
<a href="logout.php" title="Logout" style="color:inherit; text-decoration:none;">
<button title="Logout" type="button">
<span class="material-symbols-outlined" data-icon="logout">logout</span>
</button>
</a>
<div></div>
<div>
<div>
<span class="material-symbols-outlined">account_circle</span>
</div>
<div>
<span><?= htmlspecialchars($currentUser['fullname']) ?></span>
<span>Staff ID: <?= htmlspecialchars($currentUser['matric']) ?></span>
</div>
</div>
</div>
</div>
</header>
<?php endif; ?>
