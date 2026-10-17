<?php
require_once __DIR__ . '/partials/dbconn.php';
$pageTitle = 'UIISP Portal - Subscriber Customer Dashboard';
$htmlClass = '';
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
<h2>Standard Plan - 30 Days</h2>
<span>
<span></span>
            Active
          </span>
</div>
<div>
<span class="material-symbols-outlined">schedule</span>
<span>Expires in <strong>18 days</strong> — March 28, 2025</span>
</div>
</div>
<div>
<button type="button" onclick="const self = this; if (self.dataset.loading === 'true') return; self.dataset.loading = 'true'; self.innerHTML = '&lt;span class=\'material-symbols-outlined is-spinning\'&gt;progress_activity&lt;/span&gt; Renewing...'; setTimeout(() =&gt; { self.innerHTML = '&lt;span class=\'material-symbols-outlined\'&gt;check&lt;/span&gt; Renewed'; setTimeout(() =&gt; { self.innerHTML = '&lt;span class=\'material-symbols-outlined\'&gt;autorenew&lt;/span&gt; Renew Subscription'; self.dataset.loading = 'false'; }, 2000); }, 1500);"><span class="material-symbols-outlined">autorenew</span> Renew Subscription</button>
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
<span><strong>3 of 4</strong> devices connected</span>
</div>
</div>
<div>
<!-- Username Field -->
<div>
<label>Wi-Fi Username</label>
<div>
<span class="material-symbols-outlined">person</span>
<input readonly="" type="text" value="ui-id/dam.adeleke">
<button onclick="navigator.clipboard.writeText('ui-id/dam.adeleke')" title="Copy Username" type="button">
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
<input id="wifi-pass" readonly="" type="password" value="TechFaculty#2025!">
<button aria-label="Toggle password visibility" onclick="const p = document.getElementById('wifi-pass'); const ic = document.getElementById('pass-toggle-icon'); if (p.type === 'password') { p.type = 'text'; ic.textContent = 'visibility_off'; } else { p.type = 'password'; ic.textContent = 'visibility'; }" type="button">
<span class="material-symbols-outlined" id="pass-toggle-icon">visibility</span>
</button>
<button onclick="navigator.clipboard.writeText('TechFaculty#2025!')" title="Copy Password" type="button">
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
<button type="button" onclick="const icon = this.querySelector('.material-symbols-outlined'); const subtitle = this.querySelector('[data-action-note]'); if (this.dataset.loading === 'true') return; this.dataset.loading = 'true'; icon.classList.add('is-spinning'); icon.textContent = 'progress_activity'; subtitle.textContent = 'Processing renewal...'; setTimeout(() =&gt; { icon.classList.remove('is-spinning'); icon.textContent = 'autorenew'; subtitle.textContent = 'Extend current plan'; this.dataset.loading = 'false'; }, 1500);"><div><div><span class="material-symbols-outlined">autorenew</span></div><div><span>Renew Plan</span><span data-action-note>Extend current plan</span></div></div><span class="material-symbols-outlined">arrow_forward</span></button>
<a href="#">
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
<div><div><div><div><span class="material-symbols-outlined">check_circle</span></div><div><div><span>Standard Plan - 30 Days</span><span>Successful</span></div><span>February 26, 2025</span></div></div><div><span>₦10,000</span><button type="button" onclick="const btn = this; if (btn.dataset.loading === 'true') return; btn.dataset.loading = 'true'; btn.innerHTML = '&lt;span class=\'material-symbols-outlined is-spinning\'&gt;progress_activity&lt;/span&gt;&lt;span&gt;Preparing...&lt;/span&gt;'; setTimeout(() =&gt; { btn.innerHTML = '&lt;span class=\'material-symbols-outlined\'&gt;receipt&lt;/span&gt;&lt;span&gt;Receipt&lt;/span&gt;'; btn.dataset.loading = 'false'; }, 1200);"><span class="material-symbols-outlined">receipt</span><span>Receipt</span></button></div></div><div><div><div><span class="material-symbols-outlined">check_circle</span></div><div><div><span>Standard Plan - 30 Days</span><span>Successful</span></div><span>January 27, 2025</span></div></div><div><span>₦10,000</span><button type="button" onclick="const btn = this; if (btn.dataset.loading === 'true') return; btn.dataset.loading = 'true'; btn.innerHTML = '&lt;span class=\'material-symbols-outlined is-spinning\'&gt;progress_activity&lt;/span&gt;&lt;span&gt;Preparing...&lt;/span&gt;'; setTimeout(() =&gt; { btn.innerHTML = '&lt;span class=\'material-symbols-outlined\'&gt;receipt&lt;/span&gt;&lt;span&gt;Receipt&lt;/span&gt;'; btn.dataset.loading = 'false'; }, 1200);"><span class="material-symbols-outlined">receipt</span><span>Receipt</span></button></div></div><div><div><div><span class="material-symbols-outlined">check_circle</span></div><div><div><span>Standard Plan - 30 Days</span><span>Successful</span></div><span>December 28, 2024</span></div></div><div><span>₦10,000</span><button type="button" onclick="const btn = this; if (btn.dataset.loading === 'true') return; btn.dataset.loading = 'true'; btn.innerHTML = '&lt;span class=\'material-symbols-outlined is-spinning\'&gt;progress_activity&lt;/span&gt;&lt;span&gt;Preparing...&lt;/span&gt;'; setTimeout(() =&gt; { btn.innerHTML = '&lt;span class=\'material-symbols-outlined\'&gt;receipt&lt;/span&gt;&lt;span&gt;Receipt&lt;/span&gt;'; btn.dataset.loading = 'false'; }, 1200);"><span class="material-symbols-outlined">receipt</span><span>Receipt</span></button></div></div></div>
</section>
</main>
<!-- Footer (Shared Component) -->
<?php include __DIR__ . '/partials/portal-footer.php'; ?>


<?php include __DIR__ . '/partials/mobile-menu-script.php'; ?>
</body></html>