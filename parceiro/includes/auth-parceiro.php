<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function estaLogadoParceiro(): bool
{
    return isset($_SESSION['parceiro_id']);
}

function exigirLoginParceiro(): void
{
    if (!estaLogadoParceiro()) {
        header('Location: login.php');
        exit;
    }
}

function parceiroPrecisaAprovacao($pdo): void
{
    $stmt = $pdo->prepare('SELECT status FROM parceiros WHERE id = :id');
    $stmt->execute([':id' => $_SESSION['parceiro_id']]);
    $row = $stmt->fetch();
    if (!$row || $row['status'] !== 'aprovado') {
        header('Location: aguardando.php');
        exit;
    }
}
