<?php
$paginaAtiva = $paginaAtiva ?? '';
$userName    = $_SESSION['admin_nome']  ?? 'Admin';
$userEmail   = $_SESSION['admin_email'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle ?? 'Admin') ?> — Brasil DNA</title>
  <link rel="stylesheet" href="assets/admin.css">
</head>
<body>
<div class="adm-shell">

  <!-- Sidebar -->
  <aside class="adm-sidebar">
    <div class="adm-sidebar__logo">
      <div class="adm-sidebar__logo-name">Brasil DNA</div>
      <div class="adm-sidebar__logo-tag">Painel administrativo</div>
    </div>

    <div class="adm-sidebar__user">
      <div class="adm-sidebar__user-name"><?= htmlspecialchars($userName) ?></div>
      <?php if ($userEmail): ?>
        <div class="adm-sidebar__user-email"><?= htmlspecialchars($userEmail) ?></div>
      <?php endif; ?>
    </div>

    <nav class="adm-sidebar__nav">
      <div class="adm-sidebar__label">Conteúdo</div>

      <a href="index.php" class="adm-sidebar__link <?= $paginaAtiva === 'posts' ? 'is-active' : '' ?>">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Posts
      </a>

      <a href="#" class="adm-sidebar__link <?= $paginaAtiva === 'destinos' ? 'is-active' : '' ?>">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
          <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        Destinos
      </a>

      <a href="#" class="adm-sidebar__link <?= $paginaAtiva === 'parceiros' ? 'is-active' : '' ?>">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        Parceiros
      </a>
    </nav>

    <div class="adm-sidebar__bottom">
      <a href="logout.php" class="adm-sidebar__sair">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
        </svg>
        Sair
      </a>
    </div>
  </aside>

  <!-- Área principal -->
  <div class="adm-main">
    <!-- Conteúdo da página -->
    <main class="adm-content">
