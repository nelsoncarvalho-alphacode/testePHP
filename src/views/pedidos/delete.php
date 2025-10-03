<?php
session_start();
require_once '../../config/db.php';
require_once '../../models/Pedido.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

$pedidoModel = new Pedido($pdo);
$id = $_GET['id'] ?? null;

if (!$id) {
    $_SESSION['erro'] = 'Pedido não encontrado';
    header('Location: ../../index.php');
    exit;
}

try {
    $pedidoModel->deletar($id);
    $_SESSION['sucesso'] = 'Pedido excluído com sucesso!';
} catch (Exception $e) {
    $_SESSION['erro'] = 'Erro ao excluir pedido: ' . $e->getMessage();
}

header('Location: ../../index.php');
exit;