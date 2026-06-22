<?php
require_once __DIR__ . '/../includes/conexao.php';
require_once __DIR__ . '/includes/auth-parceiro.php';

exigirLoginParceiro();
parceiroPrecisaAprovacao($pdo);

$pid = (int) $_SESSION['parceiro_id'];

$stmt = $pdo->prepare(
    'SELECT COALESCE(SUM(visualizacoes),0) AS total_vis,
            COALESCE(SUM(cliques),0)       AS total_cliques,
            COUNT(*)                        AS total_banners,
            COALESCE(SUM(ativo),0)          AS banners_ativos
     FROM banners WHERE parceiro_id = :pid'
);
$stmt->execute([':pid' => $pid]);
$metricas = $stmt->fetch();

$totalVis     = (int) $metricas['total_vis'];
$totalCliques = (int) $metricas['total_cliques'];
$totalBanners = (int) $metricas['total_banners'];
$ctr          = $totalVis > 0 ? round(($totalCliques / $totalVis) * 100, 1) : 0;

$stmt = $pdo->prepare('SELECT * FROM banners WHERE parceiro_id = :pid AND ativo = 1 LIMIT 1');
$stmt->execute([':pid' => $pid]);
$bannerAtivo = $stmt->fetch();

$nomeEmpresa = htmlspecialchars($_SESSION['parceiro_nome'] ?? '');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meu Painel — Brasil DNA</title>
  <link rel="stylesheet" href="assets/parceiro.css">
</head>
<body>
<div class="par-shell">

  <!-- Sidebar -->
  <aside class="par-sidebar">
    <div class="par-sidebar__logo">
      <?php include __DIR__ . '/../includes/brasildna-logo.php'; ?>
      <div class="par-sidebar__tag">Painel do Parceiro</div>
    </div>

    <div class="par-sidebar__user">
      <div class="par-sidebar__user-name"><?= $nomeEmpresa ?></div>
      <div class="par-sidebar__user-email"><?= htmlspecialchars($_SESSION['parceiro_email'] ?? '') ?></div>
    </div>

    <nav class="par-sidebar__nav">
      <a href="dashboard.php" class="par-sidebar__link is-active">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
          <rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/>
        </svg>
        Meu Painel
      </a>
      <a href="meus-banners.php" class="par-sidebar__link">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <rect x="2" y="7" width="20" height="10" rx="2"/>
          <path d="M6 11h4M6 13h2"/>
        </svg>
        Meus Banners
      </a>
    </nav>

    <div class="par-sidebar__bottom">
      <a href="logout.php" class="par-sidebar__sair">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
        </svg>
        Sair
      </a>
    </div>
  </aside>

  <!-- Conteúdo principal -->
  <div class="par-main">

    <div class="par-page-head">
      <h1 class="par-page-title">Meu Painel</h1>
      <a href="../index.php" target="_blank" class="par-btn par-btn-outline par-btn-sm">
        Ver site
        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3"/>
        </svg>
      </a>
    </div>

    <!-- Métricas -->
    <div class="par-metrics">
      <div class="par-metric-card">
        <div class="par-metric-card__label">Visualizações (total)</div>
        <div class="par-metric-card__value"><?= number_format($totalVis, 0, ',', '.') ?></div>
        <div class="par-metric-card__sub">nos seus banners</div>
      </div>
      <div class="par-metric-card">
        <div class="par-metric-card__label">Cliques (total)</div>
        <div class="par-metric-card__value"><?= number_format($totalCliques, 0, ',', '.') ?></div>
        <div class="par-metric-card__sub">nos seus banners</div>
      </div>
      <div class="par-metric-card">
        <div class="par-metric-card__label">Taxa de cliques (CTR)</div>
        <div class="par-metric-card__value"><?= $ctr ?>%</div>
        <div class="par-metric-card__sub"><?= $totalBanners ?> banner(s) cadastrado(s)</div>
      </div>
    </div>

    <!-- Banner ativo -->
    <div class="par-card">
      <div class="par-card__title">Banner ativo</div>
      <?php if ($bannerAtivo): ?>
        <div class="par-active-banner">
          <?php if (!empty($bannerAtivo['logo_url'])): ?>
            <img class="par-active-banner__thumb"
                 src="<?= htmlspecialchars('../' . $bannerAtivo['logo_url'], ENT_QUOTES, 'UTF-8') ?>"
                 alt="<?= htmlspecialchars($bannerAtivo['nome_parceiro']) ?>">
          <?php elseif (!empty($bannerAtivo['imagem_url'])): ?>
            <img class="par-active-banner__thumb"
                 src="<?= htmlspecialchars('../' . $bannerAtivo['imagem_url'], ENT_QUOTES, 'UTF-8') ?>"
                 alt="<?= htmlspecialchars($bannerAtivo['nome_parceiro']) ?>">
          <?php else: ?>
            <div class="par-active-banner__thumb-ph">Sem imagem</div>
          <?php endif; ?>
          <div class="par-active-banner__info">
            <div class="par-active-banner__name"><?= htmlspecialchars($bannerAtivo['nome_parceiro']) ?></div>
            <?php if (!empty($bannerAtivo['titulo'])): ?>
              <p style="font-size:14px;color:var(--p-text-sec);margin-bottom:12px;">
                <?= htmlspecialchars($bannerAtivo['titulo']) ?>
              </p>
            <?php endif; ?>
            <a href="meus-banners.php" class="par-btn par-btn-ghost par-btn-sm">Gerenciar banners</a>
          </div>
        </div>
      <?php else: ?>
        <div style="display:flex;align-items:center;gap:20px;">
          <p class="par-active-banner__none">Nenhum banner ativo no momento.</p>
          <a href="meus-banners.php" class="par-btn par-btn-primary par-btn-sm">
            <?= $totalBanners > 0 ? 'Ativar um banner' : 'Criar banner' ?>
          </a>
        </div>
      <?php endif; ?>
    </div>

  </div>
</div>
</body>
</html>

