<?php
require_once __DIR__ . '/config.php';

$host    = getenv('DB_HOST') ?: '127.0.0.1';
$porta   = getenv('DB_PORT') ?: '3306';
$banco   = getenv('DB_NAME') ?: 'brasildna';
$usuario = getenv('DB_USER') ?: 'root';
$senha   = getenv('DB_PASS') ?: '';

try {
    $pdo = new PDO(
        "mysql:host={$host};port={$porta};dbname={$banco};charset=utf8mb4",
        $usuario,
        $senha,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $erro) {
    die('Erro ao conectar com o banco de dados: ' . $erro->getMessage());
}