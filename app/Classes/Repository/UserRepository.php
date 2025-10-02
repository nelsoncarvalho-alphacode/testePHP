<?php

namespace Repository;

use DB\DBConnection;
use Controllers\UserController;

class UserRepository
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new DBConnection())->connect();
    }

    public function list()
    {
        $stmt = $this->conn->query("SELECT * FROM users");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create(array $data)
    {
        try {
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $isAdmin = isset($data['is_admin']) ? (int)$data['is_admin'] : 0;
            $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, is_admin) VALUES (?, ?, ?, ?)");
            $stmt->execute([$data['name'], $data['email'], $hashedPassword, $isAdmin]);
            return $this->conn->lastInsertId();
        } catch (\PDOException $e) {
            // Não envia nada aqui, apenas retorna false
            return false;
        }
    }

    public function update($id, array $data)
    {
        $stmt = $this->conn->prepare("UPDATE users SET name = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $id]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function findByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
