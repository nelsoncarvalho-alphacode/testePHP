<?php

namespace Repository;

use DB\DBConnection;

class OrderRepository
{

    private $conn;

    public function __construct()
    {
        $this->conn = (new DBConnection())->connect();
    }

    public function createOrder($orderData, $products)
    {
        $stmt = $this->conn->prepare("INSERT INTO orders (barcode, value, status, user_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $orderData['barcode'],
            $orderData['total'],
            $orderData['status'],
            $orderData['user_id']
        ]);

        $orderId = $this->conn->lastInsertId();

        // Salva os produtos do pedido na tabela order_items
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

    public function listOrders() {
        $stmt = $this->conn->query('SELECT * FROM orders');
        $orders = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($orders as &$order) {
            $itemStmt = $this->conn->prepare('SELECT name, value, qty FROM order_items WHERE order_id = ?');
            $itemStmt->execute([$order['id']]);
            $order['products'] = $itemStmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $orders;
    }

    public function listOrdersByUser($userId) {
        $stmt = $this->conn->prepare('SELECT * FROM orders WHERE user_id = ?');
        $stmt->execute([$userId]);
        $orders = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($orders as &$order) {
            $itemStmt = $this->conn->prepare('SELECT name, value, qty FROM order_items WHERE order_id = ?');
            $itemStmt->execute([$order['id']]);
            $order['products'] = $itemStmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $orders;
    }

    public function deleteOrder($id) {
        // Remove os itens do pedido
        $itemStmt = $this->conn->prepare("DELETE FROM order_items WHERE order_id = ?");
        $itemStmt->execute([$id]);
        // Remove o pedido
        $orderStmt = $this->conn->prepare("DELETE FROM orders WHERE id = ?");
        return $orderStmt->execute([$id]);
    }
}
