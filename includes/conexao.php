<?php
require_once __DIR__ . '/config.php';

$host = '127.0.0.1';
$porta = '3306';
$banco = 'brasildna';
$usuario = 'root';
$senha = '';

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