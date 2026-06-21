<?php
require_once __DIR__ . '/../admin/includes/conexao.php';
require_once __DIR__ . '/includes/auth-parceiro.php';

if (estaLogadoParceiro()) {
    header('Location: dashboard.php');
    exit;
}

$erro  = '';
$sucesso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome   = trim($_POST['nome_empresa'] ?? '');
    $email  = trim($_POST['email']        ?? '');
    $senha  = $_POST['senha']             ?? '';
    $conf   = $_POST['confirmar_senha']   ?? '';

    if ($nome === '' || $email === '' || $senha === '') {
        $erro = 'Preencha todos os campos obrigatórios.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'E-mail inválido.';
    } elseif (strlen($senha) < 8) {
        $erro = 'A senha deve ter no mínimo 8 caracteres.';
    } elseif ($senha !== $conf) {
        $erro = 'As senhas não coincidem.';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM parceiros WHERE email = :email');
        $stmt->execute([':email' => $email]);
        if ($stmt->fetch()) {
            $erro = 'Este e-mail já está cadastrado.';
        } else {
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare(
                'INSERT INTO parceiros (nome_empresa, email, senha) VALUES (:nome, :email, :senha)'
            );
            $stmt->execute([':nome' => $nome, ':email' => $email, ':senha' => $hash]);
            $_SESSION['parceiro_id']    = (int) $pdo->lastInsertId();
            $_SESSION['parceiro_nome']  = $nome;
            $_SESSION['parceiro_email'] = $email;
            header('Location: aguardando.php');
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
  <title>Cadastrar Parceiro — Brasil DNA</title>
  <link rel="stylesheet" href="assets/parceiro.css">
</head>
<body>
<div class="par-auth">
  <div class="par-auth__card">
    <div class="par-auth__brand">Brasil DNA</div>
    <div class="par-auth__sub">Painel do Parceiro</div>

    <hr class="par-auth__divider">

    <h1 class="par-auth__title">Cadastrar Parceiro</h1>
    <p class="par-auth__desc">Crie sua conta para anunciar no Brasil DNA</p>

    <?php if ($erro): ?>
      <div class="par-alert par-alert-err"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form method="POST" class="par-form">
      <div class="par-form__group">
        <label class="par-form__label" for="nome_empresa">Nome da empresa <span style="color:var(--p-red)">*</span></label>
        <input class="par-form__input" type="text" id="nome_empresa" name="nome_empresa"
               placeholder="Ex: Hotel Fazenda Bahia"
               value="<?= htmlspecialchars($_POST['nome_empresa'] ?? '') ?>" required>
      </div>

      <div class="par-form__group">
        <label class="par-form__label" for="email">E-mail <span style="color:var(--p-red)">*</span></label>
        <input class="par-form__input" type="email" id="email" name="email"
               placeholder="contato@suaempresa.com"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
      </div>

      <div class="par-form__group">
        <label class="par-form__label" for="senha">Senha <span style="color:var(--p-red)">*</span></label>
        <input class="par-form__input" type="password" id="senha" name="senha"
               placeholder="Mínimo 8 caracteres" required>
      </div>

      <div class="par-form__group">
        <label class="par-form__label" for="confirmar_senha">Confirmar senha <span style="color:var(--p-red)">*</span></label>
        <input class="par-form__input" type="password" id="confirmar_senha" name="confirmar_senha"
               placeholder="Repita a senha" required>
      </div>

      <button type="submit" class="par-btn par-btn-primary par-btn-full" style="margin-top:4px;">
        Criar conta
      </button>
    </form>

    <div class="par-auth__footer">
      Já tem conta? <a href="login.php">Entrar</a>
    </div>
  </div>
</div>
</body>
</html>
