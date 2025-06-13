<?php
    class Produto {
        private $conn;
        private $id;
        private $nome;
        private $valor_unitario;

        public function __construct(PDO $pdo) {
            $this->conn = $pdo;
        }

        public function create() {
            $sql = "INSERT INTO Produto (nome, valor_unitario) VALUES (?, ?)";
            $stmt = $this->conn->prepare($sql);
            $return = $stmt->execute([$this->nome, $this->valor_unitario]);

            if($return){
                echo json_encode(['message' => 'Produto criado com sucesso!', 'status' => '200']);
                exit();
            }

            echo json_encode(['message' => 'Erro ao criar o produto!', 'status' => '500']);
            exit();
        }

        public function index($busca = '', $pagina = 1, $limite = 20, $ordernarPor = 'nome', $direcao = 'ASC') {
            $offset = ($pagina - 1) * $limite;
            $sql = "SELECT * FROM Produto
                    WHERE nome LIKE :busca 
                    OR valor_unitario LIKE :busca 
                    ORDER BY $ordernarPor $direcao
                    LIMIT :limite OFFSET :offset";

            $stmt = $this->conn->prepare($sql);
            $termoBusca = '%' . $busca . '%';
            $stmt->bindParam(':busca', $termoBusca, PDO::PARAM_STR);
            $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function contarTotal($busca = '') {
            $sql = "SELECT COUNT(*) as total FROM Produto 
                    WHERE nome LIKE :busca 
                    OR valor_unitario LIKE :busca";
            $stmt = $this->conn->prepare($sql);
            $termoBusca = '%' . $busca . '%';
            $stmt->bindParam(':busca', $termoBusca, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        }

        public function buscarPorNome($termo) {
            $stmt = $this->conn->prepare("SELECT id, nome FROM Produto WHERE nome LIKE :termo LIMIT 10");
            $stmt->bindValue(':termo', '%' . $termo . '%');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function read() {
            if(!empty($this->id)){
                $stmt = $this->conn->prepare("SELECT * FROM Produto WHERE id = ?");
                $stmt->execute([$this->id]);
                $produto = $stmt->fetch(PDO::FETCH_ASSOC);
    
                $this->id               = $produto['id'];
                $this->nome             = $produto['nome'];
                $this->valor_unitario   = number_format($produto['valor_unitario'], 2, ',', '');
            } else{
                $this->id               = "";
                $this->nome             = "";
                $this->valor_unitario   = "";
            }
        }

        public function update() {
            $sql = "UPDATE Produto SET nome = ?, valor_unitario = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $return = $stmt->execute([$this->nome, $this->valor_unitario, $this->id]);
            if($return){
                echo json_encode(['message' => 'Produto atualizado com sucesso!', 'status' => '200']);
                exit();
            }
            echo json_encode(['message' => 'Erro ao atualizar o produto!', 'status' => '500']);
            exit();
        }

        public function delete() {
            $stmt = $this->conn->prepare("DELETE FROM Produto WHERE id = ?");
            $return = $stmt->execute([$this->id]);
            if($return){
                echo json_encode(['message' => 'Produto excluido com sucesso!', 'status' => '200']);
                exit();
            }
            echo json_encode(['message' => 'Erro ao excluir o produto!', 'status' => '500']);
            exit();
        }

        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function getNome() {
            return $this->nome;
        }

        public function setNome($nome) {
            $this->nome = $nome;
        }

        public function getValorUnitario() {
            return $this->valor_unitario;
        }

        public function setValorUnitario($valor_unitario) {
            $this->valor_unitario = $valor_unitario;
        }
    }