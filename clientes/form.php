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
    $video_tipo = trim($_POST['video_tipo'] ?? 'iframe');
    $facebook  = trim($_POST['facebook']   ?? '');
    $instagram = trim($_POST['instagram']  ?? '');
    $linkedin  = trim($_POST['linkedin']   ?? '');
    $site      = trim($_POST['site']       ?? '');
    $youtube   = trim($_POST['youtube']    ?? '');
    $link_guia = trim($_POST['link_guia']  ?? '');
    $logo      = $cliente['logo']  ?? null;
    $video     = $cliente['video'] ?? null;

    if ($video_tipo === 'upload') {
        $iframe = '';
    } elseif ($video_tipo === 'iframe') {
        $video = null;
    }

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

    if (empty($erro) && !empty($_FILES['video_file']['tmp_name'])) {
        $allowedVid = ['mp4', 'webm', 'ogg', 'mov'];
        $extV = strtolower(pathinfo($_FILES['video_file']['name'], PATHINFO_EXTENSION));
        if (!in_array($extV, $allowedVid)) {
            $erro = 'Vídeo: formato inválido. Use MP4, WebM, OGG ou MOV.';
        } elseif ($_FILES['video_file']['size'] > 200 * 1024 * 1024) {
            $erro = 'Vídeo muito grande. Máximo 200 MB.';
        } else {
            $vfilename = uniqid('video_') . '.' . $extV;
            $uploadDir = __DIR__ . '/../uploads/';
            if (move_uploaded_file($_FILES['video_file']['tmp_name'], $uploadDir . $vfilename)) {
                if ($video && file_exists(__DIR__ . '/../' . $video)) {
                    @unlink(__DIR__ . '/../' . $video);
                }
                $video = 'uploads/' . $vfilename;
            } else {
                $erro = 'Falha ao salvar o vídeo.';
            }
        }
    }

    if (empty($erro)) {
        try {
            if ($id !== null) {
                $stmt = $pdo->prepare(
                    'UPDATE clientes SET titulo=:titulo, logo=:logo, descricao=:descricao,
                     iframe=:iframe, video=:video, facebook=:facebook, instagram=:instagram,
                     linkedin=:linkedin, site=:site, youtube=:youtube, link_guia=:link_guia
                     WHERE id=:id'
                );
                $stmt->execute([
                    ':titulo' => $titulo, ':logo' => $logo, ':descricao' => $descricao,
                    ':iframe' => $iframe, ':video' => $video,
                    ':facebook' => $facebook, ':instagram' => $instagram,
                    ':linkedin' => $linkedin, ':site' => $site, ':youtube' => $youtube,
                    ':link_guia' => $link_guia, ':id' => $id,
                ]);
            } else {
                $stmt = $pdo->prepare(
                    'INSERT INTO clientes (titulo, logo, descricao, iframe, video, facebook, instagram,
                     linkedin, site, youtube, link_guia)
                     VALUES (:titulo, :logo, :descricao, :iframe, :video, :facebook, :instagram,
                     :linkedin, :site, :youtube, :link_guia)'
                );
                $stmt->execute([
                    ':titulo' => $titulo, ':logo' => $logo, ':descricao' => $descricao,
                    ':iframe' => $iframe, ':video' => $video,
                    ':facebook' => $facebook, ':instagram' => $instagram,
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
$vVideo     = $cliente['video']    ?? '';
$showUpload = !empty($vVideo) && empty($vIframe);

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

      <!-- Vídeo de fundo: toggle iframe / upload -->
      <div class="adm-form__group">
        <label class="adm-form__label">Vídeo de fundo do card</label>

        <input type="hidden" name="video_tipo" id="video-tipo" value="<?= $showUpload ? 'upload' : 'iframe' ?>">
        <div class="vid-toggle" id="vidToggle">
          <button type="button" class="vid-toggle__btn<?= !$showUpload ? ' is-active' : '' ?>" data-target="vid-iframe-panel" data-tipo="iframe">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M15 10l4.553-2.07A1 1 0 0121 8.82v6.36a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>
            Iframe / Link
          </button>
          <button type="button" class="vid-toggle__btn<?= $showUpload ? ' is-active' : '' ?>" data-target="vid-upload-panel" data-tipo="upload">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
            Upload de Vídeo
          </button>
        </div>

        <!-- Painel: Iframe -->
        <div id="vid-iframe-panel" class="vid-panel" style="display:<?= !$showUpload ? 'block' : 'none' ?>">
          <textarea class="adm-form__input" id="iframe" name="iframe"
                    rows="4" placeholder='<iframe src="https://www.youtube.com/embed/..." ...></iframe>'><?= htmlspecialchars($vIframe) ?></textarea>
          <p style="font-size:.75rem;color:var(--text-sec);margin-top:6px;">Cole o código &lt;iframe&gt; do YouTube, Vimeo ou qualquer embed.</p>
        </div>

        <!-- Painel: Upload de vídeo -->
        <div id="vid-upload-panel" class="vid-panel" style="display:<?= $showUpload ? 'block' : 'none' ?>">
          <?php if ($vVideo): ?>
            <video id="video-preview" src="<?= htmlspecialchars('../' . $vVideo, ENT_QUOTES, 'UTF-8') ?>"
                   muted playsinline controls
                   style="width:100%;max-height:140px;border-radius:8px;margin-bottom:10px;background:#000;object-fit:contain;"></video>
          <?php else: ?>
            <video id="video-preview" src="" muted playsinline controls
                   style="display:none;width:100%;max-height:140px;border-radius:8px;margin-bottom:10px;background:#000;object-fit:contain;"></video>
          <?php endif; ?>
          <label class="post-img-upload" for="video-upload" style="padding:20px 16px;">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
              <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
            <span id="video-label">Enviar vídeo</span>
          </label>
          <input type="file" id="video-upload" name="video_file" accept="video/mp4,video/webm,video/ogg,video/quicktime" style="display:none;">
          <p style="font-size:.75rem;color:var(--text-sec);margin-top:6px;">MP4, WebM, OGG ou MOV. Máximo 200 MB.</p>
        </div>
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

<style>
.vid-toggle {
  display: inline-flex;
  border: 1px solid var(--border);
  border-radius: 8px;
  overflow: hidden;
  margin-bottom: 12px;
}
.vid-toggle__btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 16px;
  background: transparent;
  border: none;
  font-size: 13px;
  font-weight: 500;
  color: var(--text-sec);
  cursor: pointer;
  transition: background .15s, color .15s;
}
.vid-toggle__btn:first-child { border-right: 1px solid var(--border); }
.vid-toggle__btn.is-active   { background: var(--action); color: #fff; }
.vid-panel { padding-top: 4px; }
</style>

<script>
(function () {
  /* logo preview */
  var logoInput   = document.getElementById('logo-upload');
  var logoPreview = document.getElementById('logo-preview');
  var logoLabel   = document.getElementById('logo-label');
  logoInput.addEventListener('change', function () {
    var file = this.files[0];
    if (!file) return;
    var reader = new FileReader();
    reader.onload = function (e) {
      logoPreview.src = e.target.result;
      logoPreview.style.display = 'block';
      logoLabel.textContent = file.name;
    };
    reader.readAsDataURL(file);
  });

  /* video toggle */
  var tipoInput = document.getElementById('video-tipo');
  document.querySelectorAll('.vid-toggle__btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      document.querySelectorAll('.vid-toggle__btn').forEach(function (b) { b.classList.remove('is-active'); });
      this.classList.add('is-active');
      document.querySelectorAll('.vid-panel').forEach(function (p) { p.style.display = 'none'; });
      document.getElementById(this.dataset.target).style.display = 'block';
      tipoInput.value = this.dataset.tipo;
    });
  });

  /* video file preview */
  var vidInput   = document.getElementById('video-upload');
  var vidPreview = document.getElementById('video-preview');
  var vidLabel   = document.getElementById('video-label');
  vidInput.addEventListener('change', function () {
    var file = this.files[0];
    if (!file) return;
    vidPreview.src = URL.createObjectURL(file);
    vidPreview.style.display = 'block';
    vidLabel.textContent = file.name;
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
