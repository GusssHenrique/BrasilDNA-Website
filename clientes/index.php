<?php
session_start();
require_once __DIR__ . '/../includes/conexao.php';

if (empty($_SESSION['admin_id'])) {
    header('Location: ../admin/login.php');
    exit;
}

if ($_SESSION['admin_tipo'] === 'super_admin'
    && !empty($_GET['excluir'])
    && ctype_digit($_GET['excluir'])
) {
    $del = (int) $_GET['excluir'];
    try {
        $stmt = $pdo->prepare('SELECT logo FROM clientes WHERE id = :id');
        $stmt->execute([':id' => $del]);
        $row = $stmt->fetch();
        if ($row && $row['logo']) {
            $path = __DIR__ . '/../' . $row['logo'];
            if (file_exists($path)) unlink($path);
        }
        $pdo->prepare('DELETE FROM clientes WHERE id = :id')->execute([':id' => $del]);
    } catch (\PDOException $e) {}
    header('Location: index.php');
    exit;
}

$clientes = [];
try {
    $clientes = $pdo->query('SELECT * FROM clientes ORDER BY criado_em DESC')->fetchAll();
} catch (\PDOException $e) {
    $clientes = [];
}

$pageTitle   = 'Clientes';
$paginaAtiva = 'clientes';

if ($_SESSION['admin_tipo'] === 'super_admin') {
    $adminBase = '../super-admin/';
    require_once __DIR__ . '/../super-admin/includes/sidebar.php';
} else {
    $adminBase = '../admin/';
    require_once __DIR__ . '/../admin/includes/sidebar.php';
}
?>

<div class="adm-page-head">
  <h1 class="adm-page-title">Clientes</h1>
  <a href="form.php" class="btn btn-primary">
    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
      <path d="M12 4v16m8-8H4"/>
    </svg>
    Novo Cliente
  </a>
</div>

<?php if (count($clientes) === 0): ?>
  <div class="adm-card adm-empty">
    <p>Nenhum cliente cadastrado ainda.</p>
    <a href="form.php" class="btn btn-primary">Criar primeiro cliente</a>
  </div>
<?php else: ?>
  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead>
        <tr>
          <th>Logo</th>
          <th>Título</th>
          <th>Redes Sociais</th>
          <th>Data</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($clientes as $c): ?>
          <tr>
            <td>
              <?php if ($c['logo']): ?>
                <img src="<?= htmlspecialchars('../' . $c['logo'], ENT_QUOTES, 'UTF-8') ?>"
                     alt="Logo" style="height:40px;width:auto;object-fit:contain;border-radius:4px;">
              <?php else: ?>
                <span class="adm-table__meta">—</span>
              <?php endif; ?>
            </td>
            <td>
              <div class="adm-table__title"><?= htmlspecialchars($c['titulo']) ?></div>
            </td>
            <td>
              <div style="display:flex;gap:6px;flex-wrap:wrap;">
                <?php if ($c['facebook']): ?>
                  <a href="<?= htmlspecialchars($c['facebook'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="adm-table__meta" title="Facebook">FB</a>
                <?php endif; ?>
                <?php if ($c['instagram']): ?>
                  <a href="<?= htmlspecialchars($c['instagram'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="adm-table__meta" title="Instagram">IG</a>
                <?php endif; ?>
                <?php if ($c['linkedin']): ?>
                  <a href="<?= htmlspecialchars($c['linkedin'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="adm-table__meta" title="LinkedIn">LI</a>
                <?php endif; ?>
                <?php if ($c['site']): ?>
                  <a href="<?= htmlspecialchars($c['site'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="adm-table__meta" title="Site">Site</a>
                <?php endif; ?>
                <?php if ($c['youtube']): ?>
                  <a href="<?= htmlspecialchars($c['youtube'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="adm-table__meta" title="YouTube">YT</a>
                <?php endif; ?>
                <?php if (!$c['facebook'] && !$c['instagram'] && !$c['linkedin'] && !$c['site'] && !$c['youtube']): ?>
                  <span class="adm-table__meta">—</span>
                <?php endif; ?>
              </div>
            </td>
            <td>
              <span class="adm-table__meta">
                <?= date('d/m/Y', strtotime($c['criado_em'])) ?>
              </span>
            </td>
            <td>
              <div class="adm-table__actions">
                <a href="form.php?id=<?= (int) $c['id'] ?>" class="a-edit">Editar</a>
                <?php if ($_SESSION['admin_tipo'] === 'super_admin'): ?>
                  <a href="index.php?excluir=<?= (int) $c['id'] ?>" class="a-del"
                     onclick="return confirm('Excluir este cliente?')">Excluir</a>
                <?php endif; ?>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<?php
if ($_SESSION['admin_tipo'] === 'super_admin') {
    require_once __DIR__ . '/../super-admin/includes/layout-footer.php';
} else {
    require_once __DIR__ . '/../admin/includes/layout-footer.php';
}
?>
