<?php

namespace Repository;

use DB\DBConnection;
use Controllers\ProductController;

class ProductRepository
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new DBConnection())->connect();
    }

    public function list()
    {
        $stmt = $this->conn->query("SELECT * FROM products");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create(array $data)
    {
        $stmt = $this->conn->prepare("INSERT INTO products (name, img, description) VALUES (?, ?, ?)");
        $stmt->execute([$data['name'], $data['img'], $data['description']]);
        return $this->conn->lastInsertId();
    }

    public function update($id, array $data)
    {
        $stmt = $this->conn->prepare("UPDATE products SET name = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $id]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
