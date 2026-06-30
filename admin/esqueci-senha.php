<?php
require_once __DIR__ . '/../includes/conexao.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../vendor/phpmailer/src/Exception.php';
require_once __DIR__ . '/../vendor/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../vendor/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (estaLogado()) {
    header('Location: index.php');
    exit;
}

$mensagem = '';
$tipo     = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validarCSRF($_POST['csrf_token'] ?? '')) {
        die('Requisição inválida.');
    }

    $email = trim($_POST['email'] ?? '');

    if ($email === '') {
        $mensagem = 'Informe seu email.';
        $tipo     = 'err';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM admins WHERE email = :email');
        $stmt->execute([':email' => $email]);
        $admin = $stmt->fetch();

        if ($admin) {
            $token   = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $pdo->prepare('UPDATE admins SET reset_token = :token, reset_token_expires_at = :exp WHERE id = :id')
                ->execute([':token' => $token, ':exp' => $expires, ':id' => $admin['id']]);

            $baseUrl  = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
            $resetUrl = $baseUrl . '/admin/reset-senha.php?token=' . $token;

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'mail.brasildna.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'contact@brasildna.com';
                $mail->Password   = 'BrasilDNA@2025';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;
                $mail->CharSet    = 'UTF-8';

                $mail->setFrom('contact@brasildna.com', 'Brasil DNA');
                $mail->addAddress($email);
                $mail->Subject = 'Recuperação de senha — Brasil DNA Admin';
                $mail->isHTML(true);
                $mail->Body = "
                    <p>Olá,</p>
                    <p>Clique no link abaixo para redefinir sua senha. O link expira em <strong>1 hora</strong>.</p>
                    <p><a href=\"{$resetUrl}\">{$resetUrl}</a></p>
                    <p>Se você não solicitou a recuperação, ignore este email.</p>
                ";
                $mail->AltBody = "Acesse o link para redefinir sua senha: {$resetUrl}\nExpira em 1 hora.";
                $mail->send();
            } catch (Exception $e) {
                // Falha silenciosa — não revela erro ao usuário
            }
        }

        $mensagem = 'Se esse email estiver cadastrado, você receberá as instruções em breve.';
        $tipo     = 'ok';
    }
}

$csrf = gerarCSRF();
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
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
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
