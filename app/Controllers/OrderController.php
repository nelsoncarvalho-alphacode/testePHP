<?php

// Controller responsável por gerenciar pedidos e seus status
namespace Controllers;

use Repository\OrderRepository;
use Repository\ProductRepository;

class OrderController
{
    // Cancela pedido - apenas para usuários comuns
    public static function cancelOrder($id)
    {
        session_start();
        $isAdmin = $_SESSION['is_admin'] ?? 0;
        $userId = $_SESSION['user_id'] ?? null;
        
        // Verifica se é usuário comum
        if ($isAdmin) {
            http_response_code(403);
            echo json_encode(['error' => 'Apenas usuários comuns podem cancelar por aqui']);
            return;
        }
        
        // Atualiza status para cancelado
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
    // Atualiza status do pedido - apenas para administradores
    public static function updateStatus($id)
    {
        session_start();
        $isAdmin = $_SESSION['is_admin'] ?? 0;
        
        // Verifica permissão de administrador
        if (!$isAdmin) {
            http_response_code(403);
            echo json_encode(['error' => 'Acesso negado']);
            return;
        }
        
        // Captura novo status
        $data = json_decode(file_get_contents('php://input'), true);
        $status = $data['status'] ?? null;
        error_log('Status recebido: ' . print_r($status, true));
        
        if (!$status) {
            http_response_code(400);
            echo json_encode(['error' => 'Status não informado']);
            return;
        }
        
        // Atualiza status no banco
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
    // Cria novo pedido com base no carrinho de compras
    public static function store()
    {
        session_start();
        $userId = $_SESSION['user_id'] ?? null;

        // Recebe produtos do carrinho via JSON
        $data = json_decode(file_get_contents('php://input'), true);
        $products = $data['products'] ?? [];

        // Valida se carrinho não está vazio
        if (empty($products)) {
            http_response_code(400);
            echo json_encode(['error' => 'Carrinho vazio']);
            return;
        }

        // Calcula valor total do pedido
        $total = array_reduce($products, function ($sum, $item) {
            $quantity = intval($item['qty'] ?? 1);
            $value = floatval($item['value'] ?? 0);
            return $sum + ($value * $quantity);
        }, 0);

        // Gera dados iniciais do pedido
        $status = 'Pendente';
        $barcode = uniqid('ORDER-');

        // Salva pedido e itens no banco de dados
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

    // Lista pedidos baseado no tipo de usuário (admin vê todos, comum vê apenas seus)
    public static function list()
    {
        session_start();
        $userId = $_SESSION['user_id'] ?? null;
        $isAdmin = $_SESSION['is_admin'] ?? 0;
        
        $repo = new OrderRepository;
        if ($isAdmin) {
            $orders = $repo->listOrders(); // Admin vê todos os pedidos
        } else {
            $orders = $repo->listOrdersByUser($userId); // Usuário vê apenas seus pedidos
        }
        
        header('Content-Type: application/json');
        echo json_encode($orders);
    }

    // Remove pedido do banco de dados
    public static function delete($id)
    {
        $repo = new OrderRepository;
        $success = $repo->deleteOrder($id);
        header('Content-Type: application/json');

        if ($success) {
            echo json_encode(['message' => "Pedido $id deletado com sucesso"]);
        } else {
            http_response_code(404);
            echo json_encode(['message' => "Pedido não encontrado"]);
        }
    }
}
