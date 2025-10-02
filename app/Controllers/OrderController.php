<?php

namespace Controllers;

use Repository\OrderRepository;
use Repository\ProductRepository;

class OrderController
{
    public static function cancelOrder($id)
    {
        session_start();
        $isAdmin = $_SESSION['is_admin'] ?? 0;
        $userId = $_SESSION['user_id'] ?? null;
        if ($isAdmin) {
            http_response_code(403);
            echo json_encode(['error' => 'Apenas usuários comuns podem cancelar por aqui']);
            return;
        }
        $repo = new OrderRepository;
        $success = $repo->updateStatus($id, 'cancelado');
        header('Content-Type: application/json');
        if ($success) {
            echo json_encode(['message' => 'Pedido cancelado com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erro ao cancelar pedido']);
        }
    }
    public static function updateStatus($id)
    {
        session_start();
        $isAdmin = $_SESSION['is_admin'] ?? 0;
        if (!$isAdmin) {
            http_response_code(403);
            echo json_encode(['error' => 'Acesso negado']);
            return;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        $status = $data['status'] ?? null;
        error_log('Status recebido: ' . print_r($status, true));
        if (!$status) {
            http_response_code(400);
            echo json_encode(['error' => 'Status não informado']);
            return;
        }
        $repo = new OrderRepository;
        $success = $repo->updateStatus($id, $status);
        header('Content-Type: application/json');
        if ($success) {
            echo json_encode(['message' => 'Status atualizado com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erro ao atualizar status']);
        }
    }
    public static function store()
    {

        session_start();

        $userId = $_SESSION['user_id'] ?? null;

        // Recebe o produto do carrinho via JSON
        $data = json_decode(file_get_contents('php://input'), true);
        $products = $data['products'] ?? [];

        // Caso o array esteja vazio, retorna o erro
        if (empty($products)) {
            http_response_code(400);
            echo json_encode(['error' => 'Carrinho vazio']);
            return;
        }

        // Calcula o total
        $total = array_reduce($products, function ($sum, $item) {
            $quantity = intval($item['qty'] ?? 1);
            $value = floatval($item['value'] ?? 0);
            return $sum + ($value * $quantity);
        }, 0);

        // Gera status inicial e código de barras
        $status = 'Pendente';
        $barcode = uniqid('ORDER-');

        // Salva pedidos e itens
        $repo = new OrderRepository;
        $orderId = $repo->createOrder([
            'total' => $total,
            'status' => $status,
            'barcode' => $barcode,
            'user_id' => $userId
        ], $products);

        header('Content-Type: application/json');

        echo json_encode(['message' => 'Pedido criado com sucesso', 'order_id' => $orderId]);
    }

    public static function list()
    {
        session_start();
        $userId = $_SESSION['user_id'] ?? null;
        $isAdmin = $_SESSION['is_admin'] ?? 0;
        $repo = new OrderRepository;
        if ($isAdmin) {
            $orders = $repo->listOrders();
        } else {
            $orders = $repo->listOrdersByUser($userId);
        }
        header('Content-Type: application/json');
        echo json_encode($orders);
    }

    public static function delete($id)
    {
        $repo = new OrderRepository;
        $success = $repo->deleteOrder($id);
        header('Content-Type: application/json');

        if ($success) {
            echo json_encode(['message' => "Produto $id deletado com successo"]);
        } else {
            http_response_code(404);
            echo json_encode(['message' => "Produto não encontrado"]);
        }
    }
}
