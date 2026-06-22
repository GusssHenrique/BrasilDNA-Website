<?php
/**
 * Funções de autenticação.
 *
 * Este arquivo cuida de duas coisas:
 *  1. Iniciar a sessão (memória entre páginas)
 *  2. Oferecer uma função pronta para proteger páginas que só
 *     o admin logado pode ver.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function estaLogado(): bool
{
    return isset($_SESSION['admin_id']) && ($_SESSION['admin_tipo'] ?? '') === 'admin';
}

function exigirLogin(): void
{
    if (!estaLogado()) {
        header('Location: login.php');
        exit;
    }
}