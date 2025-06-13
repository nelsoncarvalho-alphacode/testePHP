<?php
    class Cliente {
        private $conn;
        private $id;
        private $nome;
        private $cpf;
        private $email;

        public function __construct(PDO $pdo) {
            $this->conn = $pdo;
        }

        public function create() {
            $sql = "INSERT INTO Cliente (nome, cpf, email) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $return = $stmt->execute([$this->nome, $this->cpf, $this->email]);

            if($return){
                echo json_encode(['message' => 'Cliente criado com sucesso!', 'status' => '200']);
                exit();
            }

            echo json_encode(['message' => 'Erro ao criar cliente!', 'status' => '500']);
            exit();
        }
        public function index($busca = '', $pagina = 1, $limite = 20, $ordenarPor = 'nome', $direcao = 'ASC') {
            $offset = ($pagina - 1) * $limite;

            $colunasOrdenaveis = ['nome', 'cpf', 'email'];
            $ordenarPor = in_array($ordenarPor, $colunasOrdenaveis) ? $ordenarPor : 'nome';
            $direcao = strtoupper($direcao) === 'DESC' ? 'DESC' : 'ASC';

            $sql = "SELECT * FROM Cliente 
                    WHERE (
                        nome LIKE :busca 
                        OR cpf LIKE :busca 
                        OR email LIKE :busca
                    ) 
                    ORDER BY $ordenarPor $direcao
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
            $sql = "SELECT COUNT(*) as total FROM Cliente 
                    WHERE (
                        nome LIKE :busca 
                        OR cpf LIKE :busca 
                        OR email LIKE :busca
                    )";
            $stmt = $this->conn->prepare($sql);
            $termoBusca = '%' . $busca . '%';
            $stmt->bindParam(':busca', $termoBusca, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        }

        public function read() {
            if(!empty($this->id)){
                $stmt = $this->conn->prepare("SELECT * FROM Cliente WHERE id = ?");
                $stmt->execute([$this->id]);
                $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
    
                $this->id    = $cliente['id'];
                $this->nome  = $cliente['nome'];
                $this->cpf   = $cliente['cpf'];
                $this->email = $cliente['email'];
            } else{
                $this->id    = "";
                $this->nome  = "";
                $this->cpf   = "";
                $this->email = "";
            }
        }

        public function update() {
            $sql = "UPDATE Cliente SET nome = ?, cpf = ?, email = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $return = $stmt->execute([$this->nome, $this->cpf, $this->email, $this->id]);
            if($return){
                echo json_encode(['message' => 'Cliente atualizado com sucesso!', 'status' => '200']);
                exit();
            }
            echo json_encode(['message' => 'Erro ao atualizar cliente!', 'status' => '500']);
            exit();
        }

        public function delete() {
            $sql = "DELETE FROM Cliente WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $return = $stmt->execute([$this->id]);
            if($return){
                echo json_encode(['message' => 'Cliente excluido com sucesso!', 'status' => '200']);
                exit();
            }
            echo json_encode(['message' => 'Erro ao excluir cliente!', 'status' => '500']);
            exit();
        }

        public function getId(){
            return $this->id;
        }

        public function setId($id){
            $this->id = $id;
        }

        public function getNome(){
            return $this->nome;
        }

        public function setNome($nome){
            $this->nome = $nome;
        }

        public function getCpf(){
            return $this->cpf;
        }

        public function setCpf($cpf){
            $this->cpf = $cpf;
        }

        public function getEmail(){
            return $this->email;
        }

        public function setEmail($email){
            $this->email = $email;
        }
    }