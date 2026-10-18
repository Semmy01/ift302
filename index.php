<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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
<div>
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
<a href="customer-registration-login.php?tab=login">Login</a>
<a href="customer-registration-login.php?tab=register">Register</a>
</div>
<?php
$mobileMenuId = 'catalogue-mobile-nav';
$mobileMenuBreakpoint = 'md';
$mobileMenuLinks = [
    ['label' => 'Packages', 'href' => '#packages'],
    ['label' => 'How It Works', 'href' => '#how-it-works'],
    ['label' => 'Login', 'href' => 'customer-registration-login.php?tab=login'],
    ['label' => 'Register', 'href' => 'customer-registration-login.php?tab=register'],
];
?>
<?php include __DIR__ . '/partials/mobile-menu.php'; ?>
<a href="#packages">
        Get Started
      </a>
</div>
</div>
</header>
<!-- Simple Hero Banner -->
<section class="hero">
<div class="section-inner">
<div class="hero-copy">
<span></span>
      Official Campus Wi-Fi Network
    </div>
<h1>
      Fast Campus Internet for Students &amp; Staff
    </h1>
<p>
      High-speed, reliable Wi-Fi across all hostels, faculties, and lecture halls. Connect seamlessly with your university ID.
    </p>
<div>
<a href="#packages">
        View Packages
      </a>
<a href="customer-registration-login.php?tab=login">
        Login to Renew
      </a>
</div>
</div>
</section>
<!-- Internet Packages Section -->
<section class="content-section packages-section" id="packages">
<div class="section-inner">
<div class="section-heading">
<h2>Choose Your Plan</h2>
<p>Simple 30-day internet subscriptions tailored for your study and research needs.</p>
</div>
<!-- 3 Cards Side-by-Side -->
<div class="plan-grid">
<!-- Basic Plan -->
<div class="plan-card">
<div>
<div>
<span>Tier 01</span>
<h3>Basic</h3>
</div>
<div>
<div>
<span>₦5,000</span>
<span>/ 30 Days</span>
</div>
</div>
<ul>
<li>
<span class="material-symbols-outlined">check_circle</span>
<span>Speed: <strong>Up to 10 Mbps</strong></span>
</li>
<li>
<span class="material-symbols-outlined">check_circle</span>
<span><strong>2 Devices</strong> connected simultaneously</span>
</li>
<li>
<span class="material-symbols-outlined">check_circle</span>
<span>Hostels &amp; Faculty coverage</span>
</li>
</ul>
</div>
<a href="subscription-payment.php?package=basic" style="text-decoration:none;"><button type="button">Select Package</button></a>
</div>
<!-- Standard Plan (Recommended) -->
<div class="plan-card plan-card-featured">
<div>
          Recommended
        </div>
<div>
<div>
<span>Tier 02</span>
<h3>Standard</h3>
</div>
<div>
<div>
<span>₦10,000</span>
<span>/ 30 Days</span>
</div>
</div>
<ul>
<li>
<span class="material-symbols-outlined">check_circle</span>
<span>Speed: <strong>Up to 35 Mbps</strong></span>
</li>
<li>
<span class="material-symbols-outlined">check_circle</span>
<span><strong>4 Devices</strong> connected simultaneously</span>
</li>
<li>
<span class="material-symbols-outlined">check_circle</span>
<span>High priority streaming &amp; calls</span>
</li>
</ul>
</div>
<a href="subscription-payment.php?package=standard" style="text-decoration:none;"><button type="button">Select Package</button></a>
</div>
<!-- Premium Plan -->
<div class="plan-card">
<div>
<div>
<span>Tier 03</span>
<h3>Premium</h3>
</div>
<div>
<div>
<span>₦20,000</span>
<span>/ 30 Days</span>
</div>
</div>
<ul>
<li>
<span class="material-symbols-outlined">check_circle</span>
<span>Speed: <strong>Up to 100 Mbps</strong></span>
</li>
<li>
<span class="material-symbols-outlined">check_circle</span>
<span><strong>8 Devices</strong> connected simultaneously</span>
</li>
<li>
<span class="material-symbols-outlined">check_circle</span>
<span>Research servers &amp; priority speed</span>
</li>
</ul>
</div>
<a href="subscription-payment.php?package=premium" style="text-decoration:none;"><button type="button">Select Package</button></a>
</div>
</div>
</div>
</section>
<!-- Brief 3-Step Guide -->
<section class="content-section how-section" id="how-it-works">
<div class="section-inner">
<div class="section-heading">
<h2>How It Works</h2>
<p>Get connected to campus internet in three simple steps.</p>
</div>
<div class="steps-grid">
<!-- Step 1 -->
<div class="step-card">
<div>
          1
        </div>
<h3>1. Register or Login</h3>
<p>
          Sign in using your student Matriculation number or University staff ID.
        </p>
</div>
<!-- Step 2 -->
<div class="step-card">
<div>
          2
        </div>
<h3>2. Choose Package &amp; Pay</h3>
<p>
          Select a 30-day plan that suits your study load and pay securely online.
        </p>
</div>
<!-- Step 3 -->
<div class="step-card">
<div>
          3
        </div>
<h3>3. Instant Wi-Fi Activation</h3>
<p>
          Connect immediately to 'UI-Secure-WiFi' across campus with your credentials.
        </p>
</div>
</div>
</div>
</section>
<!-- Minimal Footer -->
<footer class="page-footer catalogue-footer">
<div class="footer-inner">
<div class="footer-brand">
<span>UIISP Portal</span>
<p>© 2025 University of Ibadan ITeMS. All rights reserved.</p>
</div>
<div>
<a href="customer-registration-login.php?tab=login">Student Login</a>
<a href="customer-registration-login.php?tab=register">Register</a>
<a href="#help">ITeMS Helpdesk</a>
</div>
</div>
</footer>
<?php include __DIR__ . '/partials/mobile-menu-script.php'; ?>
</body></html>
