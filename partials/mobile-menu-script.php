<script>
(() => {
  document.querySelectorAll('.mobile-menu-panel').forEach((menu) => {
    const toggle = document.querySelector(`[aria-controls="${menu.id}"]`);
    if (!toggle) return;

    const icon = toggle.querySelector('.material-symbols-outlined');
    const closeMenu = () => {
      menu.hidden = true;
      toggle.setAttribute('aria-expanded', 'false');
      toggle.setAttribute('aria-label', 'Open navigation menu');
      if (icon) icon.textContent = 'menu';
    };

    toggle.addEventListener('click', () => {
      const willOpen = menu.hidden;
      menu.hidden = !willOpen;
      toggle.setAttribute('aria-expanded', String(willOpen));
      toggle.setAttribute('aria-label', willOpen ? 'Close navigation menu' : 'Open navigation menu');
      if (icon) icon.textContent = willOpen ? 'close' : 'menu';
    });
    menu.addEventListener('click', (event) => {
      const link = event.target.closest('a');
      if (!link) return;
      if (link.dataset.mobileTab && typeof window.switchTab === 'function') {
        event.preventDefault();
        window.switchTab(link.dataset.mobileTab);
      }
      closeMenu();
    });
    document.addEventListener('click', (event) => {
      if (!menu.contains(event.target) && !toggle.contains(event.target)) closeMenu();
    });
    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') {
        closeMenu();
        toggle.focus();
      }
    });
    window.addEventListener('resize', () => {
      const breakpoint = toggle.classList.contains('mobile-menu-toggle--lg') ? 1024 : 768;
      if (window.innerWidth >= breakpoint) closeMenu();
    });
  });
})();
</script>
