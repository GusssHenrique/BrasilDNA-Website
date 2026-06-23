<?php
session_start();
require_once __DIR__ . '/../includes/conexao.php';

if (empty($_SESSION['admin_id'])) {
    header('Location: ../admin/login.php');
    exit;
}

$id      = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int) $_GET['id'] : null;
$cliente = null;
$erro    = '';

if ($id !== null) {
    $stmt    = $pdo->prepare('SELECT * FROM clientes WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $cliente = $stmt->fetch();
    if (!$cliente) { header('Location: index.php'); exit; }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo    = trim($_POST['titulo']     ?? '');
    $descricao = trim($_POST['descricao']  ?? '');
    $iframe    = trim($_POST['iframe']     ?? '');
    $facebook  = trim($_POST['facebook']   ?? '');
    $instagram = trim($_POST['instagram']  ?? '');
    $linkedin  = trim($_POST['linkedin']   ?? '');
    $site      = trim($_POST['site']       ?? '');
    $youtube   = trim($_POST['youtube']    ?? '');
    $link_guia = trim($_POST['link_guia']  ?? '');
    $logo      = $cliente['logo'] ?? null;

    if ($titulo === '') {
        $erro = 'O título do cliente é obrigatório.';
    }

    if (empty($erro) && !empty($_FILES['logo_file']['tmp_name'])) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext     = strtolower(pathinfo($_FILES['logo_file']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            $erro = 'Logo: formato inválido. Use JPG, PNG ou WebP.';
        } elseif ($_FILES['logo_file']['size'] > 2 * 1024 * 1024) {
            $erro = 'Logo muito grande. Máximo 2 MB.';
        } else {
            $filename  = uniqid('cliente_') . '.' . $ext;
            $uploadDir = __DIR__ . '/../uploads/';
            if (move_uploaded_file($_FILES['logo_file']['tmp_name'], $uploadDir . $filename)) {
                $logo = 'uploads/' . $filename;
            } else {
                $erro = 'Falha ao salvar o logo.';
            }
        }
    }

    if (empty($erro)) {
        try {
            if ($id !== null) {
                $stmt = $pdo->prepare(
                    'UPDATE clientes SET titulo=:titulo, logo=:logo, descricao=:descricao,
                     iframe=:iframe, facebook=:facebook, instagram=:instagram,
                     linkedin=:linkedin, site=:site, youtube=:youtube, link_guia=:link_guia
                     WHERE id=:id'
                );
                $stmt->execute([
                    ':titulo' => $titulo, ':logo' => $logo, ':descricao' => $descricao,
                    ':iframe' => $iframe, ':facebook' => $facebook, ':instagram' => $instagram,
                    ':linkedin' => $linkedin, ':site' => $site, ':youtube' => $youtube,
                    ':link_guia' => $link_guia, ':id' => $id,
                ]);
            } else {
                $stmt = $pdo->prepare(
                    'INSERT INTO clientes (titulo, logo, descricao, iframe, facebook, instagram,
                     linkedin, site, youtube, link_guia)
                     VALUES (:titulo, :logo, :descricao, :iframe, :facebook, :instagram,
                     :linkedin, :site, :youtube, :link_guia)'
                );
                $stmt->execute([
                    ':titulo' => $titulo, ':logo' => $logo, ':descricao' => $descricao,
                    ':iframe' => $iframe, ':facebook' => $facebook, ':instagram' => $instagram,
                    ':linkedin' => $linkedin, ':site' => $site, ':youtube' => $youtube,
                    ':link_guia' => $link_guia,
                ]);
            }
        } catch (\PDOException $e) {
            $erro = 'Erro ao salvar: ' . $e->getMessage();
        }
        if (empty($erro)) {
            header('Location: index.php');
            exit;
        }
    }
}

$vTitulo    = $_POST['titulo']     ?? ($cliente['titulo']     ?? '');
$vDescricao = $_POST['descricao']  ?? ($cliente['descricao']  ?? '');
$vIframe    = $_POST['iframe']     ?? ($cliente['iframe']     ?? '');
$vFacebook  = $_POST['facebook']   ?? ($cliente['facebook']   ?? '');
$vInstagram = $_POST['instagram']  ?? ($cliente['instagram']  ?? '');
$vLinkedin  = $_POST['linkedin']   ?? ($cliente['linkedin']   ?? '');
$vSite      = $_POST['site']       ?? ($cliente['site']       ?? '');
$vYoutube   = $_POST['youtube']    ?? ($cliente['youtube']    ?? '');
$vLinkGuia  = $_POST['link_guia']  ?? ($cliente['link_guia']  ?? '');
$vLogo      = $cliente['logo']     ?? '';

$pageTitle   = $id !== null ? 'Editar Cliente' : 'Novo Cliente';
$paginaAtiva = 'clientes';

if ($_SESSION['admin_tipo'] === 'super_admin') {
    $adminBase = '../super-admin/';
    require_once __DIR__ . '/../super-admin/includes/sidebar.php';
} else {
    $adminBase = '../admin/';
    require_once __DIR__ . '/../admin/includes/sidebar.php';
}
?>

<a href="index.php" class="post-back-link">
  <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    <path d="M19 12H5M5 12l7-7M5 12l7 7"/>
  </svg>
  Voltar para Clientes
</a>

<div class="adm-page-head">
  <h1 class="adm-page-title"><?= htmlspecialchars($pageTitle) ?></h1>
</div>

<?php if ($erro): ?>
  <div class="adm-alert adm-alert-err" style="margin-bottom:20px;"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

  <div class="post-form-layout">

    <!-- Coluna principal -->
    <div class="post-main-card">

      <div class="adm-form__group">
        <label class="adm-form__label" for="titulo">
          Título (Cliente) <span style="color:var(--action)">*</span>
        </label>
        <input class="adm-form__input" type="text" id="titulo" name="titulo"
               placeholder="Ex: Compass Brazil"
               value="<?= htmlspecialchars($vTitulo) ?>" required>
      </div>

      <div class="adm-form__group">
        <label class="adm-form__label" for="descricao">Descrição</label>
        <textarea class="adm-form__input" id="descricao" name="descricao"
                  rows="5" placeholder="Descreva o cliente..."><?= htmlspecialchars($vDescricao) ?></textarea>
      </div>

      <div class="adm-form__group">
        <label class="adm-form__label" for="iframe">
          Iframe
          <span class="post-label-hint">(HTML para incorporar vídeo — ex: &lt;iframe src="..."&gt;&lt;/iframe&gt;)</span>
        </label>
        <textarea class="adm-form__input" id="iframe" name="iframe"
                  rows="4" placeholder='&lt;iframe src="https://..." ...&gt;&lt;/iframe&gt;'><?= htmlspecialchars($vIframe) ?></textarea>
      </div>

    </div>

    <!-- Painel lateral -->
    <div class="post-side-card">

      <!-- Logo -->
      <div class="post-side-section">
        <div class="post-side-label">Logo do cliente</div>
        <?php if ($vLogo): ?>
          <img id="logo-preview" src="<?= htmlspecialchars('../' . $vLogo, ENT_QUOTES, 'UTF-8') ?>"
               alt="Logo atual" style="width:100%;border-radius:8px;margin-bottom:10px;object-fit:contain;max-height:80px;background:#012a15;padding:8px;">
        <?php else: ?>
          <img id="logo-preview" src="" alt="" style="display:none;width:100%;border-radius:8px;margin-bottom:10px;object-fit:contain;max-height:80px;background:#012a15;padding:8px;">
        <?php endif; ?>
        <label class="post-img-upload" for="logo-upload">
          <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
          </svg>
          <span id="logo-label">Enviar logo</span>
        </label>
        <input type="file" id="logo-upload" name="logo_file" accept="image/*" style="display:none;">
        <p style="font-size:.75rem;color:var(--text-sec);margin-top:6px;">JPG, PNG ou WebP. Máximo 2 MB.</p>
      </div>

      <!-- Link Guia -->
      <div class="post-side-section">
        <label class="post-side-label" for="link_guia">Link Guia (BM)</label>
        <input class="adm-form__input" type="url" id="link_guia" name="link_guia"
               placeholder="https://..."
               value="<?= htmlspecialchars($vLinkGuia) ?>">
      </div>

      <!-- Redes Sociais -->
      <div class="post-side-section">
        <div class="post-side-label">Redes Sociais</div>

        <div class="adm-form__group" style="margin-bottom:10px;">
          <label class="adm-form__label" for="facebook" style="font-size:.8rem;">Facebook</label>
          <input class="adm-form__input" type="url" id="facebook" name="facebook"
                 placeholder="https://facebook.com/..."
                 value="<?= htmlspecialchars($vFacebook) ?>">
        </div>

        <div class="adm-form__group" style="margin-bottom:10px;">
          <label class="adm-form__label" for="instagram" style="font-size:.8rem;">Instagram</label>
          <input class="adm-form__input" type="url" id="instagram" name="instagram"
                 placeholder="https://instagram.com/..."
                 value="<?= htmlspecialchars($vInstagram) ?>">
        </div>

        <div class="adm-form__group" style="margin-bottom:10px;">
          <label class="adm-form__label" for="linkedin" style="font-size:.8rem;">LinkedIn</label>
          <input class="adm-form__input" type="url" id="linkedin" name="linkedin"
                 placeholder="https://linkedin.com/..."
                 value="<?= htmlspecialchars($vLinkedin) ?>">
        </div>

        <div class="adm-form__group" style="margin-bottom:10px;">
          <label class="adm-form__label" for="site" style="font-size:.8rem;">Site</label>
          <input class="adm-form__input" type="url" id="site" name="site"
                 placeholder="https://..."
                 value="<?= htmlspecialchars($vSite) ?>">
        </div>

        <div class="adm-form__group" style="margin-bottom:0;">
          <label class="adm-form__label" for="youtube" style="font-size:.8rem;">YouTube</label>
          <input class="adm-form__input" type="url" id="youtube" name="youtube"
                 placeholder="https://youtube.com/..."
                 value="<?= htmlspecialchars($vYoutube) ?>">
        </div>
      </div>

      <div class="post-side-actions">
        <button type="submit" class="btn btn-primary btn-full">Salvar Cliente</button>
        <a href="index.php" class="btn btn-ghost btn-full">Cancelar</a>
      </div>

    </div>
  </div>
</form>

<script>
(function () {
  var input   = document.getElementById('logo-upload');
  var preview = document.getElementById('logo-preview');
  var label   = document.getElementById('logo-label');
  input.addEventListener('change', function () {
    var file = this.files[0];
    if (!file) return;
    var reader = new FileReader();
    reader.onload = function (e) {
      preview.src = e.target.result;
      preview.style.display = 'block';
      label.textContent = file.name;
    };
    reader.readAsDataURL(file);
  });
}());
</script>

<?php
if ($_SESSION['admin_tipo'] === 'super_admin') {
    require_once __DIR__ . '/../super-admin/includes/layout-footer.php';
} else {
    require_once __DIR__ . '/../admin/includes/layout-footer.php';
}
?>
