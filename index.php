<?php
require_once __DIR__ . '/partials/dbconn.php';
$pageTitle = 'UIISP - University of Ibadan Internet Service Provider';
$htmlClass = '';
?>
<?php include __DIR__ . '/partials/head.php'; ?>
<body class="catalogue-page">
<!-- Minimal Navigation -->
<header class="page-header">
<div class="header-inner">
<!-- Brand -->
<a class="brand" href="#">
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
<a href="#login">Login</a>
<a href="#register">Register</a>
</div>
<?php
$mobileMenuId = 'catalogue-mobile-nav';
$mobileMenuBreakpoint = 'md';
$mobileMenuLinks = [
    ['label' => 'Packages', 'href' => '#packages'],
    ['label' => 'How It Works', 'href' => '#how-it-works'],
    ['label' => 'Login', 'href' => '#login'],
    ['label' => 'Register', 'href' => '#register'],
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
<a href="#login">
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
<button type="button" onclick="if(!this.dataset.loading){this.dataset.loading='true';this.disabled=true;this.innerHTML='&lt;svg class=\'loading-spinner-svg\' xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\'&gt;&lt;circle class=\'is-faded\' cx=\'12\' cy=\'12\' r=\'10\' stroke=\'currentColor\' stroke-width=\'4\'&gt;&lt;/circle&gt;&lt;path class=\'is-faded\' fill=\'currentColor\' d=\'M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z\'&gt;&lt;/path&gt;&lt;/svg&gt;Loading Checkout...';setTimeout(()=&gt;{window.location.hash='subscribe';},800);}">Select Package</button>
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
<button type="button" onclick="if(!this.dataset.loading){this.dataset.loading='true';this.disabled=true;this.innerHTML='&lt;svg class=\'loading-spinner-svg\' xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\'&gt;&lt;circle class=\'is-faded\' cx=\'12\' cy=\'12\' r=\'10\' stroke=\'currentColor\' stroke-width=\'4\'&gt;&lt;/circle&gt;&lt;path class=\'is-faded\' fill=\'currentColor\' d=\'M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z\'&gt;&lt;/path&gt;&lt;/svg&gt;Loading Checkout...';setTimeout(()=&gt;{window.location.hash='subscribe';},800);}">Select Package</button>
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
<button type="button" onclick="if(!this.dataset.loading){this.dataset.loading='true';this.disabled=true;this.innerHTML='&lt;svg class=\'loading-spinner-svg\' xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\'&gt;&lt;circle class=\'is-faded\' cx=\'12\' cy=\'12\' r=\'10\' stroke=\'currentColor\' stroke-width=\'4\'&gt;&lt;/circle&gt;&lt;path class=\'is-faded\' fill=\'currentColor\' d=\'M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z\'&gt;&lt;/path&gt;&lt;/svg&gt;Loading Checkout...';setTimeout(()=&gt;{window.location.hash='subscribe';},800);}">Select Package</button>
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
<a href="#packages">Packages</a>
<a href="#login">Login</a>
<a href="#register">Register</a>
<a href="mailto:helpdesk@items.ui.edu.ng">IT Helpdesk</a>
</div>
</div>
</footer>


<?php include __DIR__ . '/partials/mobile-menu-script.php'; ?>
</body></html>