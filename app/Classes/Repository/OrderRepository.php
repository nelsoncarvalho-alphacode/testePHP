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

        return $orderId;
    }

    public function listOrders() {
        $stmt = $this->conn->query('SELECT * FROM orders');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
