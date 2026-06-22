<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function estaLogado(): bool
{
    return isset($_SESSION['admin_id']) && ($_SESSION['admin_tipo'] ?? '') === 'super_admin';
}

function exigirLogin(): void
{
    if (!estaLogado()) {
        header('Location: login.php');
        exit;
    }
}
