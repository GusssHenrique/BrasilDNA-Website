<?php
require_once __DIR__ . '/includes/conexao.php';
require_once __DIR__ . '/includes/auth.php';

if (estaLogado()) {
    header('Location: index.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($email === '' || $senha === '') {
        $erro = 'Preencha email e senha.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM admins WHERE email = :email');
        $stmt->execute([':email' => $email]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($senha, $admin['senha'])) {
            $_SESSION['admin_id']    = $admin['id'];
            $_SESSION['admin_nome']  = $admin['nome'];
            $_SESSION['admin_email'] = $admin['email'];
            header('Location: index.php');
            exit;
        } else {
            $erro = 'Email ou senha incorretos. Tente novamente.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Entrar — Brasil DNA Admin</title>
  <link rel="stylesheet" href="assets/admin.css">
</head>
<body>

<div class="adm-auth">
  <div class="adm-auth__card">

    <div class="adm-auth__logo"><?php include __DIR__ . '/../includes/brasildna-logo.php'; ?></div>
    <div class="adm-auth__sub">Painel Administrativo</div>

    <h1 class="adm-auth__title">Entrar</h1>

    <?php if ($erro): ?>
      <div class="adm-alert adm-alert-err" style="margin-bottom:20px;">
        <?= htmlspecialchars($erro) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="login.php" class="adm-form">
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

      <div class="adm-form__group">
        <label class="adm-form__label" for="senha">Senha</label>
        <input
          class="adm-form__input"
          type="password"
          id="senha"
          name="senha"
          placeholder="••••••••"
          required
          autocomplete="current-password"
        >
      </div>

      <button type="submit" class="btn btn-primary" style="margin-top:4px;">Entrar</button>
    </form>

    <div class="adm-auth__footer">
      <a href="esqueci-senha.php">Esqueci minha senha</a>
    </div>

  </div>
</div>

</body>
</html>
