<?php
require_once __DIR__ . '/../admin/includes/conexao.php';
require_once __DIR__ . '/includes/auth-parceiro.php';

exigirLoginParceiro();
parceiroPrecisaAprovacao($pdo);

$pid = (int) $_SESSION['parceiro_id'];
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    $bid  = isset($_POST['banner_id']) && ctype_digit($_POST['banner_id']) ? (int) $_POST['banner_id'] : 0;

    if ($bid > 0) {
        if ($acao === 'ativar') {
            $pdo->prepare('UPDATE banners SET ativo = 0 WHERE parceiro_id = :pid')
                ->execute([':pid' => $pid]);
            $pdo->prepare('UPDATE banners SET ativo = 1 WHERE id = :id AND parceiro_id = :pid')
                ->execute([':id' => $bid, ':pid' => $pid]);
            $msg = 'Banner ativado com sucesso.';
        } elseif ($acao === 'excluir') {
            $pdo->prepare('DELETE FROM banners WHERE id = :id AND parceiro_id = :pid')
                ->execute([':id' => $bid, ':pid' => $pid]);
            $msg = 'Banner excluído.';
        }
    }
}

$stmt = $pdo->prepare(
    'SELECT * FROM banners WHERE parceiro_id = :pid ORDER BY ativo DESC, criado_em DESC'
);
$stmt->execute([':pid' => $pid]);
$banners = $stmt->fetchAll();

$nomeEmpresa = htmlspecialchars($_SESSION['parceiro_nome'] ?? '');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meus Banners — Brasil DNA</title>
  <link rel="stylesheet" href="assets/parceiro.css">
</head>
<body>
<div class="par-shell">

  <!-- Sidebar -->
  <aside class="par-sidebar">
    <div class="par-sidebar__logo">
      <div class="par-sidebar__brand">Brasil DNA</div>
      <div class="par-sidebar__tag">Painel do Parceiro</div>
    </div>

    <div class="par-sidebar__user">
      <div class="par-sidebar__user-name"><?= $nomeEmpresa ?></div>
      <div class="par-sidebar__user-email"><?= htmlspecialchars($_SESSION['parceiro_email'] ?? '') ?></div>
    </div>

    <nav class="par-sidebar__nav">
      <a href="dashboard.php" class="par-sidebar__link">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
          <rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/>
        </svg>
        Meu Painel
      </a>
      <a href="meus-banners.php" class="par-sidebar__link is-active">
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

  <div class="par-main">

    <?php if ($msg): ?>
      <div class="par-alert par-alert-ok"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <div class="par-page-head">
      <div>
        <a href="dashboard.php" class="par-back-link">← Voltar para Meu Painel</a>
        <h1 class="par-page-title">Meus Banners</h1>
      </div>
      <a href="banner-form.php" class="par-btn par-btn-primary">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path d="M12 4v16m8-8H4"/>
        </svg>
        Novo Banner
      </a>
    </div>

    <?php if (empty($banners)): ?>
      <div class="par-empty">
        <p>Você ainda não tem banners cadastrados.</p>
        <a href="banner-form.php" class="par-btn par-btn-primary">Criar primeiro banner</a>
      </div>
    <?php else: ?>
      <div class="par-banner-grid">
        <?php foreach ($banners as $b): ?>
          <?php
            $bid   = (int) $b['id'];
            $ativo = (bool) $b['ativo'];
            $nome  = htmlspecialchars($b['nome_parceiro']);
            $logo  = $b['logo_url']    ? htmlspecialchars('../' . $b['logo_url'],    ENT_QUOTES, 'UTF-8') : '';
            $bg    = $b['imagem_url']  ? htmlspecialchars('../' . $b['imagem_url'],  ENT_QUOTES, 'UTF-8') : '';
            $thumb = $logo ?: $bg;
          ?>
          <div class="par-banner-card">
            <?php if ($thumb): ?>
              <img class="par-banner-card__thumb" src="<?= $thumb ?>" alt="<?= $nome ?>">
            <?php else: ?>
              <div class="par-banner-card__thumb-ph">Sem imagem</div>
            <?php endif; ?>

            <div class="par-banner-card__body">
              <div class="par-banner-card__row">
                <span class="par-banner-card__name"><?= $nome ?></span>
                <span class="par-badge <?= $ativo ? 'par-badge-ativo' : 'par-badge-inativo' ?>">
                  <?= $ativo ? 'Ativo' : 'Inativo' ?>
                </span>
              </div>

              <div class="par-banner-card__actions">
                <?php if ($ativo): ?>
                  <button class="par-btn par-btn-outline par-btn-full" disabled
                          style="opacity:.6;cursor:default;">Banner em uso</button>
                <?php else: ?>
                  <form method="POST" style="width:100%;">
                    <input type="hidden" name="acao"      value="ativar">
                    <input type="hidden" name="banner_id" value="<?= $bid ?>">
                    <button type="submit" class="par-btn par-btn-ghost par-btn-full">
                      Ativar este banner
                    </button>
                  </form>
                <?php endif; ?>

                <div class="par-banner-card__row2">
                  <a href="banner-form.php?id=<?= $bid ?>" class="par-btn par-btn-outline par-btn-sm"
                     style="flex:1;justify-content:center;">Editar</a>

                  <form method="POST" onsubmit="return confirm('Excluir este banner?')">
                    <input type="hidden" name="acao"      value="excluir">
                    <input type="hidden" name="banner_id" value="<?= $bid ?>">
                    <button type="submit" class="par-btn par-btn-sm"
                            style="background:#fdecea;color:var(--p-red);border:1px solid #f5c6cb;">
                      Excluir
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>
</div>
</body>
</html>
