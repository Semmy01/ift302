<?php var_dump($_SERVER['REQUEST_METHOD']) ?>



<?php
require_once __DIR__ . '/partials/dbconn.php';

$dbconn = getDbConnection();


$pageTitle = 'UIISP Customer Authentication - University of Ibadan';
$htmlClass = '';
?>
<?php include __DIR__ . '/partials/head.php'; ?>

<body class="auth-page">
  <!-- Top Minimalist App Bar (Shared Components standard: UIISP Portal docked) -->
  <header class="page-header">
    <div class="header-inner">
      <!-- Brand Logo / Identity -->
      <div>
        <div>
          <span class="material-symbols-outlined">wifi</span>
        </div>
        <div>
          <span>UIISP Portal</span>
          <span>University of Ibadan ISP</span>
        </div>
      </div>
      <!-- Quick Action / Status indicator -->
      <div>
        <?php
        $mobileMenuId = 'auth-mobile-nav';
        $mobileMenuBreakpoint = 'md';
        $mobileMenuLinks = [
          ['label' => 'Student / Staff Login', 'href' => '#tab-login', 'tab' => 'login'],
          ['label' => 'New Account Registration', 'href' => '#tab-register', 'tab' => 'register'],
          ['label' => 'ITeMS Support', 'href' => '#helpdesk'],
        ];
        ?>
        <?php include __DIR__ . '/partials/mobile-menu.php'; ?>
        <div class="gateway-status">
          <span></span>
          <span>Campus Gateway Online</span>
        </div>
        <a href="#helpdesk">
          <span class="material-symbols-outlined">help</span>
          <span>ITeMS Support</span>
        </a>
      </div>
    </div>
  </header>
  <!-- Main Canvas -->
  <main class="auth-main">
    <div class="auth-shell">
      <!-- Institutional Trust Notice / Network Identifier -->
      <div>
        <div>
          <span class="material-symbols-outlined">verified_user</span>
          <span>Single Sign-On connected to University of Ibadan portal</span>
        </div>
      </div>
      <!-- Auth Container Card -->
      <div class="auth-card">
        <!-- Toggle Tabs -->
        <div class="auth-tabs" role="tablist">
          <button aria-selected="true" id="tab-login" class="auth-tab is-active" onclick="switchTab('login')"
            role="tab">
            Student / Staff Login
          </button>
          <button aria-selected="false" id="tab-register" class="auth-tab" onclick="switchTab('register')" role="tab">
            New Account Registration
          </button>
        </div>
        <!-- Forms Container -->
        <div>
          <!-- LOGIN FORM -->
          <form id="form-login" class="auth-form" method="POST" action="" onsubmit="event.preventDefault();">
            <div>
              <label for="login-id">
                Matric / Staff ID or University Email
              </label>
              <div>
                <input id="login-id" placeholder="e.g. 219084 or staff@ui.edu.ng" required="" type="text">
                <span class="material-symbols-outlined">badge</span>
              </div>
            </div>
            <div>
              <div>
                <label for="login-password">Password</label>
                <a href="#reset">Forgot password?</a>
              </div>
              <div>
                <input id="login-password" placeholder="••••••••••••" required="" type="password">
                <button onclick="togglePasswordVisibility('login-password', this)" type="button">
                  <span class="material-symbols-outlined">visibility</span>
                </button>
              </div>
            </div>
            <div>
              <label>
                <input checked="" type="checkbox">
                <span>Remember my device on campus</span>
              </label>
            </div>
            <div>
              <button id="login-submit-btn" type="submit"
                onclick="const btn = this; const defaultState = btn.querySelector('.btn-default-state'); const loadingState = btn.querySelector('.btn-loading-state'); btn.disabled = true; defaultState.classList.add('is-hidden'); loadingState.classList.remove('is-hidden'); loadingState.classList.add('is-visible-flex'); setTimeout(() =&gt; { btn.disabled = false; defaultState.classList.remove('is-hidden'); loadingState.classList.add('is-hidden'); loadingState.classList.remove('is-visible-flex'); }, 2500);">
                <span class="btn-default-state">
                  <span>Sign In &amp; Access Internet</span>
                  <span class="material-symbols-outlined">arrow_forward</span>
                </span>
                <span class="btn-loading-state">
                  <svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                  </svg>
                  <span>Signing In &amp; Verifying ID...</span>
                </span>
              </button>
            </div>
            <div>
              <span>Need help logging in?</span>
              <a href="#helpdesk">Contact ITeMS Helpdesk</a>
            </div>
          </form>
          <!-- REGISTRATION FORM (Hidden by default) -->
          <form id="form-register" class="auth-form is-hidden" method="POST">
            <div>
              <label for="reg-name">Full Name</label>
              <input id="reg-name" placeholder="Surname First, Other Names" required="" type="text">
            </div>
            <div>
              <div>
                <label for="reg-id">Matric / Staff Number</label>
                <input id="reg-id" placeholder="e.g. 219084 / STF-4412" required="" type="text">
              </div>
              <div>
                <label for="reg-phone">Phone Number</label>
                <input id="reg-phone" placeholder="080XXXXXXXX" required="" type="tel">
              </div>
            </div>
            <div>
              <label for="reg-email">University Email Address</label>
              <input id="reg-email" placeholder="name@stu.ui.edu.ng or name@ui.edu.ng" required="" type="email">
              <span>Official institutional domains only (@ui.edu.ng / @stu.ui.edu.ng)</span>
            </div>
            <div>
              <div>
                <label for="reg-password">Password</label>
                <input id="reg-password" placeholder="Min. 8 characters" required="" type="password">
              </div>
              <div>
                <label for="reg-confirm-password">Confirm Password</label>
                <input id="reg-confirm-password" placeholder="Repeat password" required="" type="password">
              </div>
            </div>
            <div>
              <label>
                <input required="" type="checkbox">
                <span>
                  I agree to the <a href="#aup">Acceptable Use Policy</a> and campus IT regulations.
                </span>
              </label>
            </div>
            <div>
              <button type="submit">
                <span>Register &amp; Choose Package</span>
                <span class="material-symbols-outlined">inventory_2</span>
              </button>
            </div>
          </form>
        </div>
      </div>
      <!-- Quick Tips Box -->
      <div>
        <span class="material-symbols-outlined">speed</span>
        <p>
          Already have an active bundle? Log in to monitor real-time data bandwidth and hotspot telemetry.
        </p>
      </div>
    </div>
  </main>
  <!-- Institutional Footer (Using Shared Components Specs) -->
  <footer class="page-footer institutional-footer">
    <div class="footer-inner">
      <div>
        <p>UIISP Portal</p>
        <p>
          © 2025 University of Ibadan Internet Service Provider (UIISP). Information Technology &amp; Media Services
          (ITeMS). All Rights Reserved.
        </p>
      </div>
      <div>
        <a href="#aup">Acceptable Use Policy</a>
        <a href="#sla">Service Level Agreement</a>
        <a href="#helpdesk">IT Helpdesk Support</a>
        <a href="#map">Campus Wi-Fi Map</a>
      </div>
    </div>
  </footer>
  <!-- Simple Vanilla Tab Switching & UI Microinteractions -->
  <script>
    function switchTab(target) {
      const isLogin = target === 'login';
      const loginTab = document.getElementById('tab-login');
      const registerTab = document.getElementById('tab-register');
      loginTab.classList.toggle('is-active', isLogin);
      registerTab.classList.toggle('is-active', !isLogin);
      loginTab.setAttribute('aria-selected', String(isLogin));
      registerTab.setAttribute('aria-selected', String(!isLogin));
      document.getElementById('form-login').classList.toggle('is-hidden', !isLogin);
      document.getElementById('form-register').classList.toggle('is-hidden', isLogin);
    }

    function togglePasswordVisibility(fieldId, btnElement) {
      const field = document.getElementById(fieldId);
      const icon = btnElement.querySelector('.material-symbols-outlined');
      if (field.type === 'password') {
        field.type = 'text';
        icon.textContent = 'visibility_off';
      } else {
        field.type = 'password';
        icon.textContent = 'visibility';
      }
    }
  </script>


  <?php include __DIR__ . '/partials/mobile-menu-script.php'; ?>
</body>

</html>