
<?php
require_once __DIR__ . '/../includes/conexao.php';
require_once __DIR__ . '/includes/auth.php';

exigirLogin();


$filtroParceiro = null;
$nomeFiltro     = '';
if (!empty($_GET['parceiro']) && ctype_digit($_GET['parceiro'])) {
    $filtroParceiro = (int) $_GET['parceiro'];
    $stmtNome = $pdo->prepare('SELECT nome_empresa FROM parceiros WHERE id = :id');
    $stmtNome->execute([':id' => $filtroParceiro]);
    $rowNome  = $stmtNome->fetch();
    $nomeFiltro = $rowNome ? $rowNome['nome_empresa'] : '';
    $stmt = $pdo->prepare('SELECT * FROM banners WHERE parceiro_id = :pid ORDER BY ordem ASC, criado_em DESC');
    $stmt->execute([':pid' => $filtroParceiro]);
} else {
    $stmt = $pdo->query('SELECT * FROM banners ORDER BY ordem ASC, criado_em DESC');
}
$banners = $stmt->fetchAll();

$pageTitle   = 'Banners de Parceiros';
$paginaAtiva = 'banners';
require_once __DIR__ . '/includes/sidebar.php';
?>

<div class="adm-page-head">
  <div>
    <?php if ($filtroParceiro): ?>
      <a href="banners.php" class="post-back-link" style="margin-bottom:6px;">← Todos os banners</a>
    <?php endif; ?>
    <h1 class="adm-page-title">
      Banners<?= $nomeFiltro ? ' — ' . htmlspecialchars($nomeFiltro) : ' de Parceiros' ?>
    </h1>
  </div>
  <a href="banner-form.php" class="btn btn-primary">
    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
      <path d="M12 4v16m8-8H4"/>
    </svg>
    Novo Banner
  </a>
</div>

<?php if (count($banners) === 0): ?>
  <div class="adm-card adm-empty">
    <p>Nenhum banner cadastrado ainda.</p>
    <a href="banner-form.php" class="btn btn-primary">Criar primeiro banner</a>
  </div>
<?php else: ?>
  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead>
        <tr>
          <th>Parceiro</th>
          <th class="col-hide-mob">Título</th>
          <th>Status</th>
          <th class="col-hide-mob">Ordem</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($banners as $b): ?>
          <tr>
            <td>
              <div class="adm-table__title"><?= htmlspecialchars($b['nome_parceiro']) ?></div>
            </td>
            <td class="col-hide-mob"><?= htmlspecialchars($b['titulo'] ?? '—') ?></td>
            <td>
              <span class="badge <?= $b['ativo'] ? 'badge-pub' : 'badge-draft' ?>">
                <?= $b['ativo'] ? 'Ativo' : 'Inativo' ?>
              </span>
            </td>
            <td class="col-hide-mob"><span class="adm-table__meta"><?= (int) $b['ordem'] ?></span></td>
            <td>
              <div class="adm-table__actions">
                <a href="banner-form.php?id=<?= (int) $b['id'] ?>" class="a-edit">Editar</a>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/layout-footer.php'; ?>

