<?php if ($portalPage === 'dashboard'):
    $mobileMenuId = 'portal-dashboard-mobile-nav';
    $mobileMenuBreakpoint = 'lg';
    $mobileMenuLinks = [
        ['label' => 'Dashboard', 'href' => '#', 'current' => true],
        ['label' => 'Packages', 'href' => '#'],
        ['label' => 'Subscriptions', 'href' => '#'],
        ['label' => 'Hotspots', 'href' => '#'],
        ['label' => 'Helpdesk', 'href' => '#'],
    ];
?>
<header class="page-header portal-header">
<div class="header-inner">
<!-- Left: Logo & Collegiate Brand Mark -->
<div class="portal-brand">
<a href="#">
<div>
<span class="material-symbols-outlined">wifi</span>
</div>
<div>
<span>UIISP Portal</span>
<span>University of Ibadan ITeMS</span>
</div>
</a>
<!-- Desktop Navigation Items -->
<nav class="desktop-nav">
<a href="#">Dashboard</a>
<a href="#">Packages</a>
<a href="#">Subscriptions</a>
<a href="#">Hotspots</a>
<a href="#">Helpdesk</a>
</nav>
<?php include __DIR__ . '/mobile-menu.php'; ?>
</div>
<!-- Right: Trailing Actions, Notifications, & Profile Anchor -->
<div class="header-actions">
<button aria-label="Notifications" type="button">
<span class="material-symbols-outlined">notifications</span>
<span></span>
</button>
<button aria-label="Help" type="button">
<span class="material-symbols-outlined">help</span>
</button>
<div></div>
<!-- Authenticated Profile Anchor -->
<div>
<div>
<span class="material-symbols-outlined">account_circle</span>
</div>
<div>
<span>Engr. Damilola Adeleke</span>
<span>STF/2019/4821</span>
</div>
</div>
</div>
</div>
</header>
<?php else:
    $mobileMenuId = 'portal-checkout-mobile-nav';
    $mobileMenuBreakpoint = 'md';
    $mobileMenuLinks = [
        ['label' => 'Packages', 'href' => '#', 'current' => true],
        ['label' => 'Dashboard', 'href' => '#'],
        ['label' => 'Subscriptions', 'href' => '#'],
        ['label' => 'Hotspots', 'href' => '#'],
        ['label' => 'Helpdesk', 'href' => '#'],
    ];
?>
<header class="page-header portal-header">
<div class="header-inner">
<!-- Brand & Product -->
<div class="portal-brand">
<a href="#">
<div>
<span class="material-symbols-outlined" data-icon="wifi_protected_setup">wifi_protected_setup</span>
</div>
<div>
<span>UIISP Portal</span>
<span>ITeMS Campus Network</span>
</div>
</a>
</div>
<!-- Navigation Links -->
<nav class="desktop-nav">
<a href="#">Packages</a>
<a href="#">Dashboard</a>
<a href="#">Subscriptions</a>
<a href="#">Hotspots</a>
<a href="#">Helpdesk</a>
</nav>
<?php include __DIR__ . '/mobile-menu.php'; ?>
<!-- Trailing Cluster -->
<div class="header-actions">
<button title="Notifications" type="button">
<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
</button>
<button title="Help &amp; Support" type="button">
<span class="material-symbols-outlined" data-icon="help">help</span>
</button>
<div></div>
<div>
<img alt="University Staff/Student Avatar" data-alt="Official portrait photograph of a university staff member wearing professional business attire against an institutional academic library background. High contrast, clean corporate lighting, deep navy and warm ambient tones." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAFZqZ0S5bubjiPz13C7-ShB1ouF_9cfdhlY5S8IJA-NVQRbWEyTEs39YOMqBXxR6dY6HlS6ihZCSZ8p8Epd944tQ87dgtTIIaP0-yvI___HO7ZjNxAdNLMc9j-ZQnox3LAnhVj4Bl74r3BDW2s33PJKpiRgAQoF2ueerxr_ffC-ndITD2gzew42omfCXiviOXGZCwGIRXCVJE2VjBro_cY_Y5LY_gDJF6TtYoWMYgpr8m3xDdvG24UFw">
<div>
<span>Dr. A. O. Adeleke</span>
<span>Staff ID: UI/ST/8492</span>
</div>
</div>
</div>
</div>
</header>
<?php endif; ?>
