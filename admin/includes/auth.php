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

/**
 * Verifica se existe um admin logado na sessão atual.
 */
function estaLogado(): bool
{
    return isset($_SESSION['admin_id']);
}

// proteger a pagina atual
function exigirLogin(): void
{
    if (!estaLogado()) {
        header('Location: login.php');
        exit;
    }
}