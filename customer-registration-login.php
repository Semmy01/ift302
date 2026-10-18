<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = 'UIISP Customer Authentication - University of Ibadan';
$htmlClass = '';

$errors  = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? '';
$old     = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['success'], $_SESSION['old']);

$activeTab = $_GET['tab'] ?? (!empty($errors) ? 'register' : 'login');
?>
<?php include __DIR__ . '/partials/head.php'; ?>

<body class="auth-page">
  <!-- Top Minimalist App Bar (Shared Components standard: UIISP Portal docked) -->
  <header class="page-header">
    <div class="header-inner">
      <!-- Brand Logo / Identity -->
      <a href="index.php" style="text-decoration:none; color:inherit; display:flex; align-items:center; gap:0.5rem;">
        <div>
          <span class="material-symbols-outlined">wifi</span>
        </div>
        <div>
          <span style="font-weight:700;">UIISP Portal</span>
          <span style="display:block; font-size:0.75rem; color:#64748b;">University of Ibadan ISP</span>
        </div>
      </a>
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
          <button aria-selected="<?= $activeTab === 'login' ? 'true' : 'false' ?>" id="tab-login" class="auth-tab <?= $activeTab === 'login' ? 'is-active' : '' ?>" onclick="switchTab('login')"
            role="tab">
            Student / Staff Login
          </button>
          <button aria-selected="<?= $activeTab === 'register' ? 'true' : 'false' ?>" id="tab-register" class="auth-tab <?= $activeTab === 'register' ? 'is-active' : '' ?>" onclick="switchTab('register')" role="tab">
            New Account Registration
          </button>
        </div>
        <!-- Forms Container -->
        <div>
          <!-- LOGIN FORM -->
          <form id="form-login" class="auth-form <?= $activeTab === 'login' ? '' : 'is-hidden' ?>" method="POST" action="process-login.php">
            <?php if (!empty($success)): ?>
              <div style="background-color: #d1fae5; color: #065f46; padding: 0.75rem 1rem; border-radius: 0.375rem; margin-bottom: 1rem; font-size: 0.875rem;">
                <?= htmlspecialchars($success) ?>
              </div>
            <?php endif; ?>
            <?php if (!empty($errors) && $activeTab === 'login'): ?>
              <div style="background-color: #fee2e2; color: #991b1b; padding: 0.75rem 1rem; border-radius: 0.375rem; margin-bottom: 1rem; font-size: 0.875rem;">
                <ul style="margin: 0; padding-left: 1.25rem;">
                  <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endif; ?>
            <div>
              <label for="login-id">
                Matric / Staff ID 
              </label>
              <div>
                <input id="login-id" placeholder="e.g. 219084 or staff@ui.edu.ng" required="" type="text" name="matric">
                <span class="material-symbols-outlined">badge</span>
              </div>
            </div>
            <div>
              <div>
                <label for="login-password">Password</label>
                <a href="#reset">Forgot password?</a>
              </div>
              <div>
                <input id="login-password" placeholder="••••••••••••" required="" type="password" name="password">
                <button onclick="togglePasswordVisibility('login-password', this)" type="button">
                  <span class="material-symbols-outlined">visibility</span>
                </button>
              </div>
            </div>
            <div>
              <label>
                <input checked="" type="checkbox" name="remember">
                <span>Keep me signed in on this workstation</span>
              </label>
            </div>
            <button type="submit">
              <span>Sign In to UIISP</span>
              <span class="material-symbols-outlined">login</span>
            </button>
          </form>
          <!-- REGISTRATION FORM -->
          <form id="form-register" class="auth-form <?= $activeTab === 'register' ? '' : 'is-hidden' ?>" method="POST" action="process-register.php">
            <?php if (!empty($errors) && $activeTab === 'register'): ?>
              <div style="background-color: #fee2e2; color: #991b1b; padding: 0.75rem 1rem; border-radius: 0.375rem; margin-bottom: 1rem; font-size: 0.875rem;">
                <ul style="margin: 0; padding-left: 1.25rem;">
                  <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endif; ?>
            <div>
              <label for="reg-fullname">Full Name</label>
              <div>
                <input id="reg-fullname" placeholder="e.g. Adewale Babatunde Adeleke" required="" type="text" name="fullname" value="<?= htmlspecialchars($old['fullname'] ?? '') ?>">
                <span class="material-symbols-outlined">person</span>
              </div>
            </div>
            <div>
              <div>
                <label for="reg-matric">Matric / Staff ID</label>
                <div>
                  <input id="reg-matric" placeholder="e.g. 219084 or UI/STF/842" required="" type="text" name="matric" value="<?= htmlspecialchars($old['matric'] ?? '') ?>">
                  <span class="material-symbols-outlined">badge</span>
                </div>
              </div>
              <div>
                <label for="reg-phone">Phone Number</label>
                <div>
                  <input id="reg-phone" placeholder="08012345678" required="" type="tel" name="phone" value="<?= htmlspecialchars($old['phone'] ?? '') ?>">
                  <span class="material-symbols-outlined">call</span>
                </div>
              </div>
            </div>
            <div>
              <label for="reg-email">University / Personal Email</label>
              <div>
                <input id="reg-email" placeholder="a.adeleke@ui.edu.ng or personal@gmail.com" required="" type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>">
                <span class="material-symbols-outlined">mail</span>
              </div>
            </div>
            <div>
              <div>
                <label for="reg-password">Create Password</label>
                <div>
                  <input id="reg-password" placeholder="Min. 8 characters" required="" type="password" name="password">
                  <button onclick="togglePasswordVisibility('reg-password', this)" type="button">
                    <span class="material-symbols-outlined">visibility</span>
                  </button>
                </div>
              </div>
              <div>
                <label for="reg-confirm">Confirm Password</label>
                <div>
                  <input id="reg-confirm" placeholder="Re-enter password" required="" type="password" name="confirm_password">
                  <button onclick="togglePasswordVisibility('reg-confirm', this)" type="button">
                    <span class="material-symbols-outlined">visibility</span>
                  </button>
                </div>
              </div>
            </div>
            <div>
              <label>
                <input required="" type="checkbox" name="terms">
                <span>I accept the University of Ibadan Network Acceptable Use Policy &amp; Terms of Service.</span>
              </label>
            </div>
            <button type="submit">
              <span>Create Account</span>
              <span class="material-symbols-outlined">how_to_reg</span>
            </button>
          </form>
        </div>
        <!-- Card Footer -->
        <div class="auth-card-footer">
          <div>
            <p>
              Experiencing issues logging in?
              <a href="#it-support">Contact Campus ITeMS Desk</a>
            </p>
          </div>
          <div>
            <span></span>
            <span>256-Bit SSL Encrypted Campus Connection</span>
          </div>
        </div>
      </div>
      <!-- Footer Note -->
      <footer class="auth-footer">
        <p>© 2025 University of Ibadan Information Technology &amp; Media Services (ITeMS). All rights reserved.</p>
      </footer>
    </div>
  </main>
  <!-- Interactive Tab & Visibility JS -->
  <script>
    function switchTab(tab) {
      const tabLogin = document.getElementById('tab-login');
      const tabRegister = document.getElementById('tab-register');
      const formLogin = document.getElementById('form-login');
      const formRegister = document.getElementById('form-register');

      if (tab === 'login') {
        tabLogin.classList.add('is-active');
        tabLogin.setAttribute('aria-selected', 'true');
        tabRegister.classList.remove('is-active');
        tabRegister.setAttribute('aria-selected', 'false');

        formLogin.classList.remove('is-hidden');
        formRegister.classList.add('is-hidden');
      } else {
        tabRegister.classList.add('is-active');
        tabRegister.setAttribute('aria-selected', 'true');
        tabLogin.classList.remove('is-active');
        tabLogin.setAttribute('aria-selected', 'false');

        formRegister.classList.remove('is-hidden');
        formLogin.classList.add('is-hidden');
      }
    }

    function togglePasswordVisibility(inputId, button) {
      const input = document.getElementById(inputId);
      const icon = button.querySelector('.material-symbols-outlined');
      if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = 'visibility_off';
      } else {
        input.type = 'password';
        icon.textContent = 'visibility';
      }
    }
  </script>
  <?php include __DIR__ . '/partials/mobile-menu-script.php'; ?>
</body>

</html>
