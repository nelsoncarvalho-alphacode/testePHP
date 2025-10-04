<?php
session_start();
require_once '../../config/db.php';
require_once '../../models/Produto.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

$produtoModel = new Produto($pdo);
$id = $_GET['id'] ?? null;

if (!$id) {
    $_SESSION['erro'] = 'Produto não encontrado';
    header('Location: ../../index.php');
    exit;
}

try {
    $produtoModel->deletar($id);
    $_SESSION['sucesso'] = 'Produto excluído com sucesso!';
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'foreign key constraint') !== false || strpos($e->getMessage(), 'Cannot delete') !== false) {
        $_SESSION['erro'] = 'Não é possível excluir este produto pois está vinculado a pedidos';
    } else {
        $_SESSION['erro'] = 'Erro ao excluir produto: ' . $e->getMessage();
    }
}

header('Location: ../../index.php');
exit;