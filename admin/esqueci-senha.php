<?php
require_once __DIR__ . '/../includes/conexao.php';
require_once __DIR__ . '/includes/auth.php';

if (estaLogado()) {
    header('Location: index.php');
    exit;
}

$mensagem = '';
$tipo     = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if ($email === '') {
        $mensagem = 'Informe seu email.';
        $tipo     = 'err';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM admins WHERE email = :email');
        $stmt->execute([':email' => $email]);
        $admin = $stmt->fetch();

        // Não revelamos se o email existe ou não (segurança)
        $mensagem = 'Se esse email estiver cadastrado, você receberá as instruções em breve.';
        $tipo     = 'ok';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Esqueci minha senha — Brasil DNA Admin</title>
  <link rel="stylesheet" href="assets/admin.css">
</head>
<body>

<div class="adm-auth">
  <div class="adm-auth__card">

    <div class="adm-auth__logo"><?php include __DIR__ . '/../includes/brasildna-logo.php'; ?></div>
    <div class="adm-auth__sub">Painel Administrativo</div>

    <h1 class="adm-auth__title">Recuperar senha</h1>

    <?php if ($mensagem): ?>
      <div class="adm-alert adm-alert-<?= $tipo ?>" style="margin-bottom:20px;">
        <?= htmlspecialchars($mensagem) ?>
      </div>
    <?php endif; ?>

    <?php if ($tipo !== 'ok'): ?>
      <form method="POST" class="adm-form">
        <div class="adm-form__group">
          <label class="adm-form__label" for="email">Email</label>
          <input
            class="adm-form__input"
            type="email"
            id="email"
            name="email"
            placeholder="seu@email.com"
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
            required
            autocomplete="email"
          >
        </div>

        <button type="submit" class="btn btn-primary" style="margin-top:4px;">Enviar instruções</button>
      </form>
    <?php endif; ?>

    <div class="adm-auth__footer">
      <a href="login.php">Voltar para o login</a>
    </div>

  </div>
</div>

</body>
</html>

