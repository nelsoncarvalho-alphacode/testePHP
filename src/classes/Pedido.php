<?php
    class Pedido {
        private $conn;
        private $id; 
        private $cliente_id; 
        private $dt_pedido; 
        private $status;
        private $valor_pedido; 

        public function __construct(PDO $pdo) {
            $this->conn = $pdo;
        }

        public function create() {
            $sql = "INSERT INTO Pedido (cliente_id, dt_pedido, status, valor_pedido) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $return = $stmt->execute([$this->cliente_id, $this->dt_pedido, $this->status, $this->valor_pedido]);
            if (!$return) {
                $errorInfo = $stmt->errorInfo();
            }

            if($return){
                $this->id = $this->conn->lastInsertId();
                return true;
            }

            return false;
        }

        public function index($busca = '', $pagina = 1, $limite = 20, $status = '', $data = '', $ordenarPor = 'dt_pedido', $direcao = 'ASC') {
            $offset = ($pagina - 1) * $limite;

            $colunasOrdenaveis = ['dt_pedido', 'nome'];
            $ordenarPor = in_array($ordenarPor, $colunasOrdenaveis) ? $ordenarPor : 'dt_pedido';
            $direcao = strtoupper($direcao) === 'DESC' ? 'DESC' : 'ASC';

            $sql = "
                SELECT 
                    Pedido.id AS id,
                    Pedido.dt_pedido,
                    Pedido.status,
                    Pedido.valor_pedido,
                    Cliente.nome AS nome
                FROM Pedido AS Pedido
                LEFT JOIN Cliente AS Cliente ON Pedido.cliente_id = Cliente.id
                WHERE (
                    Cliente.nome LIKE :busca
                    OR Pedido.valor_pedido LIKE :busca
                    )
            ";

            if (!empty($status)) {
                $sql .= " AND Pedido.status = :status";
            }
            if (!empty($data)) {
                $sql .= " AND Pedido.dt_pedido = :data";
            }

            $sql .= "
                ORDER BY FIELD(Pedido.status, 'Em Aberto', 'Pago', 'Cancelado'), $ordenarPor $direcao
                LIMIT :limite OFFSET :offset
            ";

            $stmt = $this->conn->prepare($sql);

            $termoBusca = '%' . $busca . '%';
            $stmt->bindParam(':busca', $termoBusca, PDO::PARAM_STR);
            if (!empty($status)) {
                $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            }
            if (!empty($data)) {
                $stmt->bindParam(':data', $data, PDO::PARAM_STR);
            }
            $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function contarTotal($busca = '', $status = '', $data = '') {
            $sql = "
                SELECT COUNT(*) as total 
                FROM Pedido
                LEFT JOIN Cliente ON Pedido.cliente_id = Cliente.id
                WHERE (
                    Cliente.nome LIKE :busca
                    OR Pedido.dt_pedido LIKE :busca
                    OR Pedido.valor_pedido LIKE :busca
                    OR Pedido.status LIKE :busca
                )
            ";

            if (!empty($status)) {
                $sql .= " AND Pedido.status = :status";
            }
            if (!empty($data)) {
                $sql .= " AND Pedido.dt_pedido = :data";
            }

            $stmt = $this->conn->prepare($sql);

            $termoBusca = '%' . $busca . '%';
            $stmt->bindParam(':busca', $termoBusca, PDO::PARAM_STR);

            if (!empty($status)) {
                $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            }
            if (!empty($data)) {
                $stmt->bindParam(':data', $data, PDO::PARAM_STR);
            }

            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        }

        public function read() {
            if(!empty($this->id)) {
                $sql = "SELECT * FROM Pedido WHERE id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$this->id]);
                $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

                $this->id           = $pedido['id']; 
                $this->cliente_id   = $pedido['cliente_id']; 
                $this->dt_pedido    = $pedido['dt_pedido'];
                $this->status       = $pedido['status'];
                $this->valor_pedido = $pedido['valor_pedido'];
            } else {
                $this->id           = "";
                $this->cliente_id   = "";
                $this->dt_pedido    = "";
                $this->status       = "";
                $this->valor_pedido = "";
            }
        }

        public function update() {
            $sql = "UPDATE Pedido SET cliente_id = ?, dt_pedido = ?, status = ?, valor_pedido = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $return = $stmt->execute([$this->cliente_id, $this->dt_pedido, $this->status, $this->valor_pedido, $this->id]);
            if (!$return) {
                $errorInfo = $stmt->errorInfo();
            }

            if($return){
                $this->id = $this->conn->lastInsertId();
                return true;
            }

            return false;
        }

        public function delete() {
            $stmt = $this->conn->prepare("DELETE FROM Pedido WHERE id = ?");
            $return = $stmt->execute([$this->id]);
            if($return){
                echo json_encode(['message' => 'Pedido excluido com sucesso!', 'status' => '200']);
                exit();
            }
            echo json_encode(['message' => 'Erro ao excluir o pedido!', 'status' => '500']);
            exit();
        }

        public function getId() {
            return $this->id;
        }
        public function setId($id) {
            $this->id = $id;
        }
        public function getClienteId() {
            return $this->cliente_id;
        }
        public function setClienteId($cliente_id) {
            $this->cliente_id = $cliente_id;
        }
        public function getDtPedido() {
            return $this->dt_pedido;
        }
        public function setDtPedido($dt_pedido) {
            $this->dt_pedido = $dt_pedido;
        }
        public function getStatus() {
            return $this->status;
        }
        public function setStatus($status) {
            $this->status = $status;
        }
        public function getValorPedido() {
            return $this->valor_pedido;
        }
        public function setValorPedido($valor_pedido) {
            $this->valor_pedido = $valor_pedido;
        }
    }