<?php
require_once __DIR__ . '/../admin/includes/conexao.php';
require_once __DIR__ . '/includes/auth-parceiro.php';

exigirLoginParceiro();
parceiroPrecisaAprovacao($pdo);

$pid  = (int) $_SESSION['parceiro_id'];
$id   = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int) $_GET['id'] : null;
$banner = null;
$erro   = '';

if ($id !== null) {
    $stmt = $pdo->prepare('SELECT * FROM banners WHERE id = :id AND parceiro_id = :pid');
    $stmt->execute([':id' => $id, ':pid' => $pid]);
    $banner = $stmt->fetch();
    if (!$banner) { header('Location: meus-banners.php'); exit; }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome     = trim($_POST['nome_parceiro'] ?? '');
    $titulo   = trim($_POST['titulo']        ?? '');
    $subtexto = trim($_POST['subtexto']      ?? '');
    $botao    = trim($_POST['botao_texto']   ?? 'Saiba mais');
    $link     = trim($_POST['link_url']      ?? '');
    $logo     = $banner['logo_url']   ?? null;
    $imagem   = $banner['imagem_url'] ?? null;

    $uploadDir = __DIR__ . '/../uploads/';
    $allowed   = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!empty($_FILES['logo_file']['tmp_name'])) {
        $ext = strtolower(pathinfo($_FILES['logo_file']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            $erro = 'Logo: formato inválido. Use JPG, PNG ou WebP.';
        } elseif ($_FILES['logo_file']['size'] > 2 * 1024 * 1024) {
            $erro = 'Logo muito grande. Máximo 2 MB.';
        } else {
            $filename = uniqid('logo_') . '.' . $ext;
            if (move_uploaded_file($_FILES['logo_file']['tmp_name'], $uploadDir . $filename)) {
                $logo = 'uploads/' . $filename;
            } else {
                $erro = 'Falha ao salvar o logo.';
            }
        }
    }

    if (empty($erro) && !empty($_FILES['bg_file']['tmp_name'])) {
        $ext = strtolower(pathinfo($_FILES['bg_file']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            $erro = 'Background: formato inválido. Use JPG, PNG ou WebP.';
        } elseif ($_FILES['bg_file']['size'] > 5 * 1024 * 1024) {
            $erro = 'Imagem de fundo muito grande. Máximo 5 MB.';
        } else {
            $filename = uniqid('bg_') . '.' . $ext;
            if (move_uploaded_file($_FILES['bg_file']['tmp_name'], $uploadDir . $filename)) {
                $imagem = 'uploads/' . $filename;
            } else {
                $erro = 'Falha ao salvar a imagem de fundo.';
            }
        }
    }

    if ($nome === '') {
        $erro = 'O nome do banner é obrigatório.';
    }

    if (empty($erro)) {
        try {
            if ($id !== null) {
                $stmt = $pdo->prepare(
                    'UPDATE banners SET nome_parceiro=:nome, logo_url=:logo, imagem_url=:imagem,
                     titulo=:titulo, subtexto=:subtexto, botao_texto=:botao, link_url=:link
                     WHERE id=:id AND parceiro_id=:pid'
                );
                $stmt->execute([
                    ':nome' => $nome, ':logo' => $logo, ':imagem' => $imagem,
                    ':titulo' => $titulo, ':subtexto' => $subtexto,
                    ':botao' => $botao, ':link' => $link,
                    ':id' => $id, ':pid' => $pid,
                ]);
            } else {
                $stmt = $pdo->prepare(
                    'INSERT INTO banners (nome_parceiro, logo_url, imagem_url, titulo, subtexto,
                     botao_texto, link_url, ativo, parceiro_id)
                     VALUES (:nome, :logo, :imagem, :titulo, :subtexto, :botao, :link, 0, :pid)'
                );
                $stmt->execute([
                    ':nome' => $nome, ':logo' => $logo, ':imagem' => $imagem,
                    ':titulo' => $titulo, ':subtexto' => $subtexto,
                    ':botao' => $botao, ':link' => $link, ':pid' => $pid,
                ]);
            }
        } catch (\PDOException $e) {
            $erro = 'Erro ao salvar: ' . $e->getMessage();
        }
        if (empty($erro)) {
            header('Location: meus-banners.php');
            exit;
        }
    }
}

$vNome     = $_POST['nome_parceiro'] ?? ($banner['nome_parceiro'] ?? '');
$vTitulo   = $_POST['titulo']        ?? ($banner['titulo']        ?? '');
$vSubtexto = $_POST['subtexto']      ?? ($banner['subtexto']      ?? '');
$vBotao    = $_POST['botao_texto']   ?? ($banner['botao_texto']   ?? 'Saiba mais');
$vLink     = $_POST['link_url']      ?? ($banner['link_url']      ?? '');
$vLogo     = $banner['logo_url']     ?? '';
$vImagem   = $banner['imagem_url']   ?? '';

$pageTitle = $id !== null ? 'Editar Banner' : 'Novo Banner';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle) ?> — Brasil DNA</title>
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
      <div class="par-sidebar__user-name"><?= htmlspecialchars($_SESSION['parceiro_nome'] ?? '') ?></div>
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

    <a href="meus-banners.php" class="par-back-link">
      <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path d="M19 12H5M5 12l7-7M5 12l7 7"/>
      </svg>
      Voltar para Meus Banners
    </a>

    <div class="par-page-head">
      <h1 class="par-page-title"><?= htmlspecialchars($pageTitle) ?></h1>
    </div>

    <?php if ($erro): ?>
      <div class="par-alert par-alert-err"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <div class="par-form-layout">

        <!-- Coluna principal -->
        <div class="par-main-card">

          <div class="par-form__group">
            <label class="par-form__label" for="nome_parceiro">
              Nome do banner <span style="color:var(--p-red)">*</span>
            </label>
            <input class="par-form__input" type="text" id="nome_parceiro" name="nome_parceiro"
                   placeholder="Ex: Promoção de Verão"
                   value="<?= htmlspecialchars($vNome) ?>" required>
          </div>

          <div class="par-form__group">
            <label class="par-form__label" for="titulo">
              Título principal
              <span style="font-weight:400;font-size:13px;color:var(--p-text-sec)">(headline do banner)</span>
            </label>
            <input class="par-form__input" type="text" id="titulo" name="titulo"
                   placeholder="Ex: Aproveite o verão na Bahia"
                   value="<?= htmlspecialchars($vTitulo) ?>">
          </div>

          <div class="par-form__group">
            <label class="par-form__label" for="subtexto">Tagline</label>
            <input class="par-form__input" type="text" id="subtexto" name="subtexto"
                   placeholder="Ex: Pacotes especiais com tudo incluso"
                   value="<?= htmlspecialchars($vSubtexto) ?>">
          </div>

          <div class="par-form__group">
            <label class="par-form__label" for="botao_texto">Texto do botão</label>
            <input class="par-form__input" type="text" id="botao_texto" name="botao_texto"
                   placeholder="Ex: Saiba mais"
                   value="<?= htmlspecialchars($vBotao) ?>">
          </div>

          <div class="par-form__group">
            <label class="par-form__label" for="link_url">URL de destino</label>
            <input class="par-form__input" type="url" id="link_url" name="link_url"
                   placeholder="https://seusite.com.br"
                   value="<?= htmlspecialchars($vLink) ?>">
          </div>

        </div>

        <!-- Painel lateral -->
        <div class="par-side-card">

          <div class="par-side-section">
            <div class="par-side-label">Logo da empresa</div>
            <?php if ($vLogo): ?>
              <img id="logo-preview"
                   src="<?= htmlspecialchars('../' . $vLogo, ENT_QUOTES, 'UTF-8') ?>"
                   alt="Logo atual"
                   style="width:100%;border-radius:8px;object-fit:contain;max-height:80px;background:#012a15;padding:8px;margin-bottom:4px;">
            <?php else: ?>
              <img id="logo-preview" src="" alt=""
                   style="display:none;width:100%;border-radius:8px;object-fit:contain;max-height:80px;background:#012a15;padding:8px;margin-bottom:4px;">
            <?php endif; ?>
            <label class="par-img-upload" for="logo-upload">
              <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
              </svg>
              <span id="logo-label">Enviar logo</span>
            </label>
            <input type="file" id="logo-upload" name="logo_file" accept="image/*" style="display:none;">
            <small style="color:var(--p-text-sec);font-size:11px;">JPG, PNG, WebP. Máx 2 MB.</small>
            <small style="color:var(--p-text-sec);font-size:11px;margin-top:4px;display:block;">
              Tamanho ideal: <strong>400 × 120 px</strong>. Use fundo transparente (PNG ou WebP) para melhor resultado.
            </small>
          </div>

          <div class="par-side-section">
            <div class="par-side-label">Imagem de fundo</div>
            <?php if ($vImagem): ?>
              <img id="bg-preview"
                   src="<?= htmlspecialchars('../' . $vImagem, ENT_QUOTES, 'UTF-8') ?>"
                   alt="Fundo atual"
                   style="width:100%;border-radius:8px;object-fit:cover;max-height:100px;margin-bottom:4px;">
            <?php else: ?>
              <img id="bg-preview" src="" alt=""
                   style="display:none;width:100%;border-radius:8px;object-fit:cover;max-height:100px;margin-bottom:4px;">
            <?php endif; ?>
            <label class="par-img-upload" for="bg-upload">
              <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
              </svg>
              <span id="bg-label">Enviar imagem de fundo</span>
            </label>
            <input type="file" id="bg-upload" name="bg_file" accept="image/*" style="display:none;">
            <small style="color:var(--p-text-sec);font-size:11px;">JPG, PNG, WebP. Máx 5 MB.</small>
            <small style="color:var(--p-text-sec);font-size:11px;margin-top:4px;display:block;">
              Tamanho ideal: <strong>1440 × 300 px</strong> (paisagem). Imagens muito estreitas ou verticais podem cortar.
            </small>
          </div>

          <div class="par-side-actions">
            <button type="submit" class="par-btn par-btn-primary par-btn-full">Salvar Banner</button>
            <a href="meus-banners.php" class="par-btn par-btn-ghost par-btn-full">Cancelar</a>
          </div>

        </div>
      </div>
    </form>

  </div>
</div>

<script>
function bindUploadPreview(inputId, previewId, labelId) {
  document.getElementById(inputId).addEventListener('change', function() {
    var file = this.files[0];
    if (!file) return;
    var preview = document.getElementById(previewId);
    var label   = document.getElementById(labelId);
    var reader  = new FileReader();
    reader.onload = function(e) {
      preview.src = e.target.result;
      preview.style.display = 'block';
      label.textContent = file.name;
    };
    reader.readAsDataURL(file);
  });
}
bindUploadPreview('logo-upload', 'logo-preview', 'logo-label');
bindUploadPreview('bg-upload',   'bg-preview',   'bg-label');
</script>
</body>
</html>
