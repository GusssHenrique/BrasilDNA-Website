<?php
require_once __DIR__ . '/../admin/includes/conexao.php';
require_once __DIR__ . '/includes/auth-parceiro.php';

$status = 'pendente';
if (estaLogadoParceiro()) {
    $stmt = $pdo->prepare('SELECT status FROM parceiros WHERE id = :id');
    $stmt->execute([':id' => $_SESSION['parceiro_id']]);
    $row = $stmt->fetch();
    if ($row) {
        $status = $row['status'];
        if ($status === 'aprovado') {
            header('Location: dashboard.php');
            exit;
        }
    }
}

$rejeitado = ($status === 'rejeitado');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro em Análise — Brasil DNA</title>
  <link rel="stylesheet" href="assets/parceiro.css">
</head>
<body>
<div class="par-auth">
  <div class="par-auth__card" style="text-align:center;">

    <div class="par-auth__icon <?= $rejeitado ? 'par-auth__icon-err' : '' ?>">
      <?php if ($rejeitado): ?>
        <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path d="M6 18L18 6M6 6l12 12"/>
        </svg>
      <?php else: ?>
        <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path d="M5 13l4 4L19 7"/>
        </svg>
      <?php endif; ?>
    </div>

    <h1 class="par-auth__title" style="text-align:center;">
      <?= $rejeitado ? 'Cadastro não aprovado' : 'Cadastro recebido!' ?>
    </h1>

    <p style="font-size:14px;color:var(--p-text-sec);line-height:1.6;margin-bottom:28px;">
      <?php if ($rejeitado): ?>
        Seu cadastro não foi aprovado pelo time Brasil DNA. Entre em contato conosco para mais informações.
      <?php else: ?>
        Sua conta está em análise. Você receberá uma resposta assim que for aprovada pelo time Brasil DNA.
      <?php endif; ?>
    </p>

    <a href="../index.php" class="par-btn par-btn-ghost par-btn-full">
      ← Voltar para o site
    </a>

    <?php if (estaLogadoParceiro()): ?>
      <div class="par-auth__footer" style="margin-top:16px;">
        <a href="logout.php">Sair da conta</a>
      </div>
    <?php endif; ?>

  </div>
</div>
</body>
</html>
