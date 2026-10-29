<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect already authenticated users straight to the dashboard
if (!empty($_SESSION['matric'])) {
    header('Location: subscriber-dashboard.php');
    exit;
}

$pageTitle = 'UIISP Portal Authentication - University of Ibadan';
$htmlClass = '';

$errors  = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? '';
$old     = $_SESSION['old'] ?? [];
$oldLoginId = $_SESSION['old_login_id'] ?? '';
unset($_SESSION['errors'], $_SESSION['success'], $_SESSION['old'], $_SESSION['old_login_id']);

$redirect = trim($_GET['redirect'] ?? '');
$activeTab = $_GET['tab'] ?? (!empty($errors) && !isset($errors['general']) ? 'register' : 'login');
?>
<?php include __DIR__ . '/partials/head.php'; ?>

<body class="auth-page">
  <!-- Top Minimalist App Bar -->
  <header class="page-header">
    <div class="header-inner">
      <!-- Brand Logo / Identity -->
      <a href="index.php" style="text-decoration:none; color:inherit; display:flex; align-items:center; gap:0.6rem;">
        <div style="width:2.25rem; height:2.25rem; background:#0b2545; color:#fff; border-radius:0.4rem; display:grid; place-items:center;">
          <span class="material-symbols-outlined" style="font-size:1.4rem;">wifi</span>
        </div>
        <div>
          <span style="font-weight:700; color:#0b2545; display:block; line-height:1.2;">UIISP Portal</span>
          <span style="display:block; font-size:0.75rem; color:#64748b;">University of Ibadan ISP</span>
        </div>
      </a>
      <!-- Quick Action / Status indicator -->
      <div style="display:flex; align-items:center; gap:1rem;">
        <?php
        $mobileMenuId = 'auth-mobile-nav';
        $mobileMenuBreakpoint = 'md';
        $mobileMenuLinks = [
          ['label' => 'Student / Staff Login', 'href' => '#tab-login', 'tab' => 'login'],
          ['label' => 'New Account Registration', 'href' => '#tab-register', 'tab' => 'register'],
          ['label' => 'Return to Home', 'href' => 'index.php'],
          ['label' => 'ITeMS Support', 'href' => 'https://items.ui.edu.ng'],
        ];
        ?>
        <?php include __DIR__ . '/partials/mobile-menu.php'; ?>
        <div class="gateway-status">
          <span></span>
          <span>Campus Gateway Online</span>
        </div>
        <a href="index.php" style="display:inline-flex; align-items:center; gap:0.35rem; color:#475569; text-decoration:none; font-size:0.875rem; font-weight:500;">
          <span class="material-symbols-outlined" style="font-size:1.1rem;">arrow_back</span>
          <span>Back to Home</span>
        </a>
      </div>
    </div>
  </header>

  <!-- Main Canvas -->
  <main class="auth-main">
    <div class="auth-shell">
      <!-- Institutional Trust Notice / Network Identifier -->
      <div style="text-align:center; margin-bottom:1.25rem; display:flex; align-items:center; justify-content:center; gap:0.5rem; color:#059669; font-size:0.85rem; font-weight:600;">
        <span class="material-symbols-outlined" style="font-size:1.15rem;">verified_user</span>
        <span>Single Sign-On connected to University of Ibadan RADIUS Directory</span>
      </div>

      <!-- Auth Container Card -->
      <div class="auth-card">
        <!-- Toggle Tabs -->
        <div class="auth-tabs" role="tablist">
          <button aria-selected="<?= $activeTab === 'login' ? 'true' : 'false' ?>" id="tab-login" class="auth-tab <?= $activeTab === 'login' ? 'is-active' : '' ?>" onclick="switchTab('login')" role="tab" type="button">
            Student / Staff Login
          </button>
          <button aria-selected="<?= $activeTab === 'register' ? 'true' : 'false' ?>" id="tab-register" class="auth-tab <?= $activeTab === 'register' ? 'is-active' : '' ?>" onclick="switchTab('register')" role="tab" type="button">
            New Account Registration
          </button>
        </div>

        <!-- Forms Container -->
        <div>
          <!-- LOGIN FORM -->
          <form id="form-login" class="auth-form <?= $activeTab === 'login' ? '' : 'is-hidden' ?>" method="POST" action="process-login.php">
            <?php if (!empty($redirect)): ?>
              <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">
            <?php endif; ?>

            <?php if (!empty($success)): ?>
              <div style="background-color: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; padding: 0.75rem 1rem; border-radius: 0.375rem; margin-bottom: 1rem; font-size: 0.875rem; display:flex; align-items:center; gap:0.5rem;">
                <span class="material-symbols-outlined" style="font-size:1.2rem;">check_circle</span>
                <span><?= htmlspecialchars($success) ?></span>
              </div>
            <?php endif; ?>

            <?php if (!empty($errors) && $activeTab === 'login'): ?>
              <div style="background-color: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 0.75rem 1rem; border-radius: 0.375rem; margin-bottom: 1rem; font-size: 0.875rem;">
                <ul style="margin: 0; padding-left: 1.25rem;">
                  <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endif; ?>

            <div>
              <label for="login-id">
                Matric / Staff ID or Email
              </label>
              <div>
                <input id="login-id" placeholder="e.g. 219084 or b.adeleke@ui.edu.ng" required="" type="text" name="matric" value="<?= htmlspecialchars($oldLoginId) ?>">
                <span class="material-symbols-outlined">badge</span>
              </div>
            </div>

            <div>
              <div>
                <label for="login-password">Password</label>
                <a href="#it-support" onclick="alert('For password reset assistance, please contact the ITeMS helpdesk with your student ID at items-support@ui.edu.ng'); return false;" style="font-size:0.8rem; color:#0b2545;">Forgot password?</a>
              </div>
              <div>
                <input id="login-password" placeholder="••••••••••••" required="" type="password" name="password">
                <button onclick="togglePasswordVisibility('login-password', this)" type="button">
                  <span class="material-symbols-outlined">visibility</span>
                </button>
              </div>
            </div>

            <div>
              <label style="display:flex; align-items:center; gap:0.5rem; font-size:0.85rem; color:#475569; cursor:pointer;">
                <input checked="" type="checkbox" name="remember">
                <span>Keep me signed in on this workstation</span>
              </label>
            </div>

            <button type="submit" style="width:100%; display:flex; align-items:center; justify-content:center; gap:0.5rem;">
              <span>Sign In to UIISP</span>
              <span class="material-symbols-outlined">login</span>
            </button>
          </form>

          <!-- REGISTRATION FORM -->
          <form id="form-register" class="auth-form <?= $activeTab === 'register' ? '' : 'is-hidden' ?>" method="POST" action="process-register.php">
            <?php if (!empty($redirect)): ?>
              <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">
            <?php endif; ?>

            <?php if (!empty($errors) && $activeTab === 'register'): ?>
              <div style="background-color: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 0.75rem 1rem; border-radius: 0.375rem; margin-bottom: 1rem; font-size: 0.875rem;">
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
                <input id="reg-fullname" placeholder="e.g. Babatunde Adeleke" required="" type="text" name="fullname" value="<?= htmlspecialchars($old['fullname'] ?? '') ?>">
                <span class="material-symbols-outlined">person</span>
              </div>
            </div>

            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:1rem;">
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
                <input id="reg-email" placeholder="b.adeleke@ui.edu.ng or user@gmail.com" required="" type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>">
                <span class="material-symbols-outlined">mail</span>
              </div>
            </div>

            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:1rem;">
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
              <label style="display:flex; align-items:flex-start; gap:0.5rem; font-size:0.85rem; color:#475569; cursor:pointer;">
                <input required="" type="checkbox" name="terms" style="margin-top:0.2rem;">
                <span>I accept the University of Ibadan Network Acceptable Use Policy &amp; Terms of Service.</span>
              </label>
            </div>

            <button type="submit" style="width:100%; display:flex; align-items:center; justify-content:center; gap:0.5rem;">
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
              <a href="mailto:items-support@ui.edu.ng">Contact Campus ITeMS Desk</a>
            </p>
          </div>
          <div style="display:flex; align-items:center; gap:0.4rem; font-size:0.75rem; color:#64748b;">
            <span class="material-symbols-outlined" style="font-size:1rem; color:#059669;">lock</span>
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
