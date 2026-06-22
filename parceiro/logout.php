<?php
require_once __DIR__ . '/includes/auth-parceiro.php';

unset($_SESSION['parceiro_id'], $_SESSION['parceiro_nome'], $_SESSION['parceiro_email']);
if (empty($_SESSION)) {
    session_destroy();
}
header('Location: login.php');
exit;

