<?php

namespace Repository;

use DB\DBConnection;
use Controllers\UserController;

class UserRepository {
    private $conn;

    public function __construct()
    {
        $this->conn = (new DBConnection())->connect();
    }

    public function list() {
        $stmt = $this->conn->query("SELECT * FROM users");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find() {
        $stmt = $this->conn->query("SELECT * FROM users");
        return $stmt->fetchAll((\PDO::FETCH_ASSOC));
    }

    public function create(array $data) {
        $stmt = $this->conn->prepare("INSERT INTO users (name) VALUES (?)");
        $stmt->execute([$data['name']]);
        return $this->conn->lastInsertId();
    }

    public function update($id, array $data) {
        $stmt = $this->conn->prepare("UPDATE users SET name = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
}