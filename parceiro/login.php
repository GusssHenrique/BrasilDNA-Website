<?php
require_once __DIR__ . '/../includes/conexao.php';
require_once __DIR__ . '/includes/auth-parceiro.php';

if (estaLogadoParceiro()) {
    header('Location: dashboard.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha']      ?? '';

    if ($email === '' || $senha === '') {
        $erro = 'Preencha e-mail e senha.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM parceiros WHERE email = :email');
        $stmt->execute([':email' => $email]);
        $parceiro = $stmt->fetch();

        if (!$parceiro || !password_verify($senha, $parceiro['senha'])) {
            $erro = 'E-mail ou senha incorretos.';
        } else {
            $_SESSION['parceiro_id']    = (int) $parceiro['id'];
            $_SESSION['parceiro_nome']  = $parceiro['nome_empresa'];
            $_SESSION['parceiro_email'] = $parceiro['email'];

            if ($parceiro['status'] !== 'aprovado') {
                header('Location: aguardando.php');
            } else {
                header('Location: dashboard.php');
            }
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Entrar — Painel Parceiro Brasil DNA</title>
  <link rel="stylesheet" href="assets/parceiro.css">
</head>
<body>
<div class="par-auth">
  <div class="par-auth__card">
    <div class="par-auth__brand"><?php include __DIR__ . '/../includes/brasildna-logo.php'; ?></div>
    <div class="par-auth__sub">Painel do Parceiro</div>

    <hr class="par-auth__divider">

    <h1 class="par-auth__title">Entrar</h1>

    <?php if ($erro): ?>
      <div class="par-alert par-alert-err"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form method="POST" class="par-form">
      <div class="par-form__group">
        <label class="par-form__label" for="email">E-mail</label>
        <input class="par-form__input" type="email" id="email" name="email"
               placeholder="contato@suaempresa.com"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required autofocus>
      </div>

      <div class="par-form__group">
        <label class="par-form__label" for="senha">Senha</label>
        <input class="par-form__input" type="password" id="senha" name="senha"
               placeholder="••••••••" required>
      </div>

      <button type="submit" class="par-btn par-btn-primary par-btn-full" style="margin-top:4px;">
        Entrar
      </button>
    </form>

    <div class="par-auth__footer">
      Não tem conta? <a href="cadastro.php">Cadastre-se</a>
    </div>
  </div>
</div>
</body>
</html>

