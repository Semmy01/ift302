<?php
require_once __DIR__ . '/partials/dbconn.php';
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
<div>
<a href="#">Dashboard</a>
<span class="material-symbols-outlined" data-icon="chevron_right">chevron_right</span>
<a href="#">Packages</a>
<span class="material-symbols-outlined" data-icon="chevron_right">chevron_right</span>
<span>Checkout</span>
</div>
<!-- 3-Step Checkout Flow -->
<div>
<div>
<!-- Step 1 -->
<div>
<span>
<span class="material-symbols-outlined" data-icon="check">check</span>
</span>
<div>
<span>Step 1</span>
<span>Select Plan</span>
</div>
</div>
<!-- Step 2 (Active) -->
<div>
<span>
              2
            </span>
<div>
<span>Step 2 (Active)</span>
<span>Review &amp; Payment Method</span>
</div>
</div>
<!-- Step 3 -->
<div>
<span>
              3
            </span>
<div>
<span>Step 3</span>
<span>Instant Activation</span>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- Main Content Canvas: 2-Column Interface -->
<main class="checkout-main">
<div class="checkout-intro">
<h1>Complete Subscription Checkout</h1>
<p>Review your plan, choose your payment method, and complete payment for instant Wi-Fi activation.</p>
</div>
<div class="checkout-layout">
<!-- Left Column: Simplified Payment Flow (7 cols) -->
<section class="checkout-column">
<!-- Selected Package Summary -->
<div>
<div>
<div>
<div>
<span class="material-symbols-outlined" data-icon="wifi">wifi</span>
</div>
<div>
<span>Selected Package</span>
<h2>Standard Package — ₦10,000 / 30 Days</h2>
</div>
</div>
<a href="#">
              Change Plan
              <span class="material-symbols-outlined" data-icon="open_in_new">open_in_new</span>
</a>
</div>
</div>
<!-- Duration Selection -->
<div>
<h3>Duration Selection</h3>
<label>
<div>
<input checked="" name="duration" type="radio" value="1month">
<div>
<span>1 Month (30 Days)</span>
<span>Full campus Wi-Fi &amp; high-speed fiber access</span>
</div>
</div>
<span>₦10,000</span>
</label>
</div>
<!-- Payment Method -->
<div>
<h3>Payment Method</h3>
<div>
<!-- Option 1: Paystack -->
<label>
<div>
<input checked="" name="payment_method" type="radio" value="paystack">
<div>
<span>Debit Card / Bank Transfer (Paystack)</span>
<span>Mastercard, VISA, Verve, USSD, or direct bank transfer</span>
</div>
</div>
<span class="material-symbols-outlined" data-icon="credit_card">credit_card</span>
</label>
<!-- Option 2: Remita -->
<label>
<div>
<input name="payment_method" type="radio" value="remita">
<div>
<span>Remita (RRR)</span>
<span>Official University e-Collection retrieval reference</span>
</div>
</div>
<span class="material-symbols-outlined" data-icon="account_balance">account_balance</span>
</label>
</div>
</div>
<!-- Customer Details Summary -->
<div>
<h3>Customer Details</h3>
<div>
<div>
<span>Subscriber Name</span>
<span>Dr. Adeleke Olumide Babatunde</span>
</div>
<div>
<span>Staff / Student ID</span>
<span>UI/ST/8492</span>
</div>
</div>
</div>
</section>
<!-- Right Column: Clean Order Summary (5 cols) -->
<aside class="order-summary">
<div>
<div>
<h3>Order Summary</h3>
</div>
<!-- Line items -->
<div>
<div>
<span>Package</span>
<span>₦10,000</span>
</div>
<div>
<span>Duration</span>
<span>30 Days</span>
</div>
</div>
<!-- Total -->
<div>
<span>Total</span>
<span>₦10,000</span>
</div>
<!-- Primary Action CTA -->
<div>
<button id="pay-btn" onclick="this.disabled=true; this.classList.add('is-disabled'); document.getElementById('pay-btn-normal').classList.add('is-hidden'); document.getElementById('pay-btn-loading').classList.remove('is-hidden'); document.getElementById('pay-btn-loading').classList.add('is-visible-flex');" type="button"><span id="pay-btn-normal"><span class="material-symbols-outlined" data-icon="lock">lock</span><span>Pay ₦10,000 &amp; Activate Subscription</span></span><span id="pay-btn-loading" class="is-hidden"><svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg><span>Processing Payment &amp; Activating RADIUS...</span></span></button>
<p>
<span class="material-symbols-outlined" data-icon="bolt">bolt</span>
<span>Instant RADIUS Wi-Fi activation upon successful payment.</span>
</p>
</div>
</div>
</aside>
</div>
</main>
<!-- Footer (Shared Component) -->
<?php include __DIR__ . '/partials/portal-footer.php'; ?>


<?php include __DIR__ . '/partials/mobile-menu-script.php'; ?>
</body></html>