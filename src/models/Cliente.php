<?php
class Cliente {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Listar clientes (filtros, ordenação e paginação)
     */
    public function listar($filtros = [], $ordem = 'nome', $direcao = 'ASC', $limite = 20, $offset = 0) {
        $sql = "SELECT * FROM clientes WHERE 1=1";
        $params = [];

        // Filtros dinâmicos
        if (!empty($filtros['nome'])) {
            $sql .= " AND nome LIKE ?";
            $params[] = "%{$filtros['nome']}%";
        }
        if (!empty($filtros['cpf'])) {
            $sql .= " AND cpf LIKE ?";
            $params[] = "%{$filtros['cpf']}%";
        }
        if (!empty($filtros['email'])) {
            $sql .= " AND email LIKE ?";
            $params[] = "%{$filtros['email']}%";
        }

        // Ordenação
        $colunasPermitidas = ['id', 'nome', 'cpf', 'email', 'telefone', 'created_at'];
        $ordem = in_array($ordem, $colunasPermitidas) ? $ordem : 'nome';
        $direcao = in_array(strtoupper($direcao), ['ASC', 'DESC']) ? strtoupper($direcao) : 'ASC';
        $sql .= " ORDER BY {$ordem} {$direcao}";

        $limite = (int)$limite;
        $offset = (int)$offset;
        $sql .= " LIMIT {$limite} OFFSET {$offset}";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Contar total de clientes (com filtros)
     */
    public function contar($filtros = []) {
        $sql = "SELECT COUNT(*) FROM clientes WHERE 1=1";
        $params = [];

        if (!empty($filtros['nome'])) {
            $sql .= " AND nome LIKE ?";
            $params[] = "%{$filtros['nome']}%";
        }
        if (!empty($filtros['cpf'])) {
            $sql .= " AND cpf LIKE ?";
            $params[] = "%{$filtros['cpf']}%";
        }
        if (!empty($filtros['email'])) {
            $sql .= " AND email LIKE ?";
            $params[] = "%{$filtros['email']}%";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    /**
     * Buscar cliente (por ID)
     */
    public function buscarPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM clientes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Buscar cliente (por CPF)
     */
    public function buscarPorCpf($cpf) {
        $stmt = $this->pdo->prepare("SELECT * FROM clientes WHERE cpf = ?");
        $stmt->execute([$cpf]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Criar novo cliente
     */
    public function criar($dados) {
        $stmt = $this->pdo->prepare("
            INSERT INTO clientes (nome, cpf, email, telefone, endereco) 
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $dados['nome'],
            $dados['cpf'],
            $dados['email'],
            $dados['telefone'],
            $dados['endereco']
        ]);
    }

    /**
     * Atualizar cliente (existente)
     */
    public function atualizar($id, $dados) {
        $stmt = $this->pdo->prepare("
            UPDATE clientes 
            SET nome = ?, cpf = ?, email = ?, telefone = ?, endereco = ? 
            WHERE id = ?
        ");
        return $stmt->execute([
            $dados['nome'],
            $dados['cpf'],
            $dados['email'],
            $dados['telefone'],
            $dados['endereco'],
            $id
        ]);
    }

    /**
     * Deletar cliente
     */
    public function deletar($id) {
        $stmt = $this->pdo->prepare("DELETE FROM clientes WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Deletar múltiplos clientes
     */
    public function deletarMultiplos($ids) {
        if (empty($ids)) {
            return false;
        }
        
        $placeholders = str_repeat('?,', count($ids) - 1) . '?';
        $stmt = $this->pdo->prepare("DELETE FROM clientes WHERE id IN ($placeholders)");
        return $stmt->execute($ids);
    }

    /**
     * Buscar todos os clientes (sem paginação)
     */
    public function buscarTodos() {
        $stmt = $this->pdo->query("SELECT * FROM clientes ORDER BY nome");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}