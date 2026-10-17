<?php
$mobileMenuId = $mobileMenuId ?? 'mobile-navigation';
$mobileMenuBreakpoint = $mobileMenuBreakpoint ?? 'md';
$mobileMenuLinks = $mobileMenuLinks ?? [];
?>
<button class="mobile-menu-toggle mobile-menu-toggle--<?= htmlspecialchars($mobileMenuBreakpoint, ENT_QUOTES, 'UTF-8') ?>" type="button" aria-label="Open navigation menu" aria-expanded="false" aria-controls="<?= htmlspecialchars($mobileMenuId, ENT_QUOTES, 'UTF-8') ?>">
  <span class="material-symbols-outlined" aria-hidden="true">menu</span>
</button>
<nav class="mobile-menu-panel mobile-menu-panel--<?= htmlspecialchars($mobileMenuBreakpoint, ENT_QUOTES, 'UTF-8') ?>" id="<?= htmlspecialchars($mobileMenuId, ENT_QUOTES, 'UTF-8') ?>" aria-label="Mobile navigation" hidden>
  <?php foreach ($mobileMenuLinks as $link): ?>
    <a class="mobile-menu-link<?= !empty($link['current']) ? ' is-current' : '' ?>" href="<?= htmlspecialchars($link['href'], ENT_QUOTES, 'UTF-8') ?>"<?= isset($link['tab']) ? ' data-mobile-tab="' . htmlspecialchars($link['tab'], ENT_QUOTES, 'UTF-8') . '"' : '' ?><?= !empty($link['current']) ? ' aria-current="page"' : '' ?>><?= htmlspecialchars($link['label'], ENT_QUOTES, 'UTF-8') ?></a>
  <?php endforeach; ?>
</nav>
