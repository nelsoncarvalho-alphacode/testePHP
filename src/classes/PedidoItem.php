<?php
    class PedidoItem {
        private $conn;

        public function __construct(PDO $pdo) {
            $this->conn = $pdo;
        }

        public function create($pedido_id, $produto_id, $quantidade, $valor_unitario) {
            $sql = "INSERT INTO Pedido_Item (pedido_id, produto_id, quantidade, valor_unitario) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$pedido_id, $produto_id, $quantidade, $valor_unitario]);
        }

        public function index($pedido_id) {
            $stmt = $this->conn->prepare("SELECT * FROM Pedido_Item WHERE pedido_id = ?");
            $stmt->execute([$pedido_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function read($id) {
            $stmt = $this->conn->prepare("SELECT * FROM Pedido_Item WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function update($id, $pedido_id, $produto_id, $quantidade, $valor_unitario) {
            $sql = "UPDATE Pedido_Item SET pedido_id = ?, produto_id = ?, quantidade = ?, valor_unitario = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$pedido_id, $produto_id, $quantidade, $valor_unitario, $id]);
        }

        public function delete($id) {
            $stmt = $this->conn->prepare("DELETE FROM Pedido_Item WHERE id = ?");
            return $stmt->execute([$id]);
        }
    }