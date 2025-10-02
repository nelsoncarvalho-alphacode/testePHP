<?php

namespace Controllers;

use Repository\OrderRepository;
use Repository\ProductRepository;

class OrderController {
    public static function store() {

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
        $total = array_reduce($products, function($sum, $item) {
            return $sum + floatval($item['value']);
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

    public static function list() {
        $repo = new OrderRepository;
        $orders = $repo->listOrders();
        header('Content-Type: application/json');
        echo json_encode($orders);
    }

    public static function delete($id) {
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