<?php
session_start();
require_once '../../config/db.php';
require_once '../../models/Cliente.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

$clienteModel = new Cliente($pdo);
$id = $_GET['id'] ?? null;

if (!$id) {
    $_SESSION['erro'] = 'Cliente não encontrado';
    header('Location: ../../index.php');
    exit;
}

try {
    $clienteModel->deletar($id);
    $_SESSION['sucesso'] = 'Cliente excluído com sucesso!';
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'foreign key constraint') !== false || strpos($e->getMessage(), 'Cannot delete') !== false) {
        $_SESSION['erro'] = 'Não é possível excluir este cliente pois possui pedidos vinculados';
    } else {
        $_SESSION['erro'] = 'Erro ao excluir cliente: ' . $e->getMessage();
    }
}

header('Location: ../../index.php');
exit;