<?php

// Repository responsável por operações de banco de dados para pedidos
namespace Repository;

use DB\DBConnection;

class OrderRepository
{
    private $conn;

    // Inicializa conexão com banco de dados
    public function __construct()
    {
        $this->conn = (new DBConnection())->connect();
    }

    // Atualiza status de um pedido
    public function updateStatus($orderId, $status)
    {
        $stmt = $this->conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $orderId]);
    }

    // Cria novo pedido com seus itens
    public function createOrder($orderData, $products)
    {
        // Cria o pedido principal
        $stmt = $this->conn->prepare("INSERT INTO orders (barcode, value, status, user_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $orderData['barcode'],
            $orderData['total'],
            $orderData['status'],
            $orderData['user_id']
        ]);

        $orderId = $this->conn->lastInsertId();

        // Salva os itens do pedido na tabela order_items
        foreach ($products as $product) {
            $qty = isset($product['qty']) ? $product['qty'] : 1;
            $itemStmt = $this->conn->prepare("INSERT INTO order_items (order_id, product_id, name, value, qty) VALUES (?, ?, ?, ?, ?)");
            $itemStmt->execute([
                $orderId,
                $product['id'],
                $product['name'],
                $product['value'],
                $qty
            ]);
        }

        return $orderId;
    }

    // Lista todos os pedidos com informações do usuário e produtos
    public function listOrders()
    {
        $stmt = $this->conn->query('SELECT o.*, u.name as user_name FROM orders o LEFT JOIN users u ON o.user_id = u.id');
        $orders = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Adiciona produtos de cada pedido
        foreach ($orders as &$order) {
            $itemStmt = $this->conn->prepare('SELECT name, value, qty FROM order_items WHERE order_id = ?');
            $itemStmt->execute([$order['id']]);
            $order['products'] = $itemStmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $orders;
    }

    // Lista pedidos de um usuário específico
    public function listOrdersByUser($userId)
    {
        $stmt = $this->conn->prepare('SELECT * FROM orders WHERE user_id = ?');
        $stmt->execute([$userId]);
        $orders = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Adiciona produtos de cada pedido
        foreach ($orders as &$order) {
            $itemStmt = $this->conn->prepare('SELECT name, value, qty FROM order_items WHERE order_id = ?');
            $itemStmt->execute([$order['id']]);
            $order['products'] = $itemStmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $orders;
    }

    // Remove pedido e seus itens do banco
    public function deleteOrder($id)
    {
        // Remove os itens do pedido primeiro (chave estrangeira)
        $itemStmt = $this->conn->prepare("DELETE FROM order_items WHERE order_id = ?");
        $itemStmt->execute([$id]);
        
        // Remove o pedido
        $orderStmt = $this->conn->prepare("DELETE FROM orders WHERE id = ?");
        return $orderStmt->execute([$id]);
    }
}
