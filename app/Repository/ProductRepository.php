<?php

// Repository responsável por operações de banco de dados para produtos
namespace Repository;

use DB\DBConnection;

class ProductRepository
{
    private $conn;

    // Inicializa conexão com banco de dados
    public function __construct()
    {
        $this->conn = (new DBConnection())->connect();
    }

    // Lista todos os produtos
    public function list()
    {
        $stmt = $this->conn->query("SELECT * FROM products");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Busca produto por ID
    public function find($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Cria novo produto
    public function create(array $data)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO products (name, img, value, description) VALUES (?, ?, ?, ?)");
            $result = $stmt->execute([$data['name'], $data['img'], $data['value'], $data['description']]);
            return $result ? $this->conn->lastInsertId() : false;
        } catch (\PDOException $e) {
            return false;
        }
    }

    // Atualiza dados do produto
    public function update($id, array $data)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE products SET name = ?, description = ?, value = ?, img = ? WHERE id = ?");
            return $stmt->execute([$data['name'], $data['description'], $data['value'], $data['img'], $id]);
        } catch (\PDOException $e) {
            return false;
        }
    }

    // Remove produto do banco de dados
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
