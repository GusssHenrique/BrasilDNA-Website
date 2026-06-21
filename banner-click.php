<?php
require_once __DIR__ . '/admin/includes/conexao.php';

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id === 0) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT link_url FROM banners WHERE id = :id AND ativo = 1');
$stmt->execute([':id' => $id]);
$banner = $stmt->fetch();

if (!$banner || empty($banner['link_url'])) {
    header('Location: index.php');
    exit;
}

$pdo->prepare('UPDATE banners SET cliques = cliques + 1 WHERE id = :id')
    ->execute([':id' => $id]);

header('Location: ' . $banner['link_url']);
exit;
