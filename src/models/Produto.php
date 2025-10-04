<?php
class Produto {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Listar produtos (filtros, ordenação e paginação)
     */
    public function listar($filtros = [], $ordem = 'nome', $direcao = 'ASC', $limite = 20, $offset = 0) {
        $sql = "SELECT * FROM produtos WHERE 1=1";
        $params = [];

        // Filtros dinâmicos
        if (!empty($filtros['nome'])) {
            $sql .= " AND nome LIKE ?";
            $params[] = "%{$filtros['nome']}%";
        }
        if (!empty($filtros['cod_barras'])) {
            $sql .= " AND cod_barras LIKE ?";
            $params[] = "%{$filtros['cod_barras']}%";
        }
        if (isset($filtros['preco_min']) && $filtros['preco_min'] !== '') {
            $sql .= " AND preco >= ?";
            $params[] = $filtros['preco_min'];
        }
        if (isset($filtros['preco_max']) && $filtros['preco_max'] !== '') {
            $sql .= " AND preco <= ?";
            $params[] = $filtros['preco_max'];
        }

        // Ordenação
        $colunasPermitidas = ['id', 'nome', 'cod_barras', 'preco', 'estoque', 'created_at'];
        $ordem = in_array($ordem, $colunasPermitidas) ? $ordem : 'nome';
        $direcao = in_array(strtoupper($direcao), ['ASC', 'DESC']) ? strtoupper($direcao) : 'ASC';
        $sql .= " ORDER BY {$ordem} {$direcao}";

        // Paginação
        $limite = (int)$limite;
        $offset = (int)$offset;
        $sql .= " LIMIT {$limite} OFFSET {$offset}";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Contar total de produtos (com filtros)
     */
    public function contar($filtros = []) {
        $sql = "SELECT COUNT(*) FROM produtos WHERE 1=1";
        $params = [];

        if (!empty($filtros['nome'])) {
            $sql .= " AND nome LIKE ?";
            $params[] = "%{$filtros['nome']}%";
        }
        if (!empty($filtros['cod_barras'])) {
            $sql .= " AND cod_barras LIKE ?";
            $params[] = "%{$filtros['cod_barras']}%";
        }
        if (isset($filtros['preco_min']) && $filtros['preco_min'] !== '') {
            $sql .= " AND preco >= ?";
            $params[] = $filtros['preco_min'];
        }
        if (isset($filtros['preco_max']) && $filtros['preco_max'] !== '') {
            $sql .= " AND preco <= ?";
            $params[] = $filtros['preco_max'];
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    /**
     * Buscar produto (por ID)
     */
    public function buscarPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM produtos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Buscar produto (por código de barras)
     */
    public function buscarPorCodigoBarras($cod_barras) {
        $stmt = $this->pdo->prepare("SELECT * FROM produtos WHERE cod_barras = ?");
        $stmt->execute([$cod_barras]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Criar novo produto
     */
    public function criar($dados) {
        $stmt = $this->pdo->prepare("
            INSERT INTO produtos (nome, cod_barras, preco, estoque, descricao) 
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $dados['nome'],
            $dados['cod_barras'],
            $dados['preco'],
            $dados['estoque'],
            $dados['descricao']
        ]);
    }

    /**
     * Atualizar produto existente
     */
    public function atualizar($id, $dados) {
        $stmt = $this->pdo->prepare("
            UPDATE produtos 
            SET nome = ?, cod_barras = ?, preco = ?, estoque = ?, descricao = ? 
            WHERE id = ?
        ");
        return $stmt->execute([
            $dados['nome'],
            $dados['cod_barras'],
            $dados['preco'],
            $dados['estoque'],
            $dados['descricao'],
            $id
        ]);
    }

    /**
     * Deletar produto
     */
    public function deletar($id) {
        $stmt = $this->pdo->prepare("DELETE FROM produtos WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Deletar múltiplos produtos
     */
    public function deletarMultiplos($ids) {
        if (empty($ids)) {
            return false;
        }
        
        $placeholders = str_repeat('?,', count($ids) - 1) . '?';
        $stmt = $this->pdo->prepare("DELETE FROM produtos WHERE id IN ($placeholders)");
        return $stmt->execute($ids);
    }

    /**
     * Buscar todos os produtos (sem paginação)
     */
    public function buscarTodos() {
        $stmt = $this->pdo->query("SELECT * FROM produtos ORDER BY nome");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Atualizar estoque do produto
     */
    public function atualizarEstoque($id, $quantidade) {
        $stmt = $this->pdo->prepare("UPDATE produtos SET estoque = estoque + ? WHERE id = ?");
        return $stmt->execute([$quantidade, $id]);
    }

    /**
     * Verificar se há estoque suficiente
     */
    public function verificarEstoque($id, $quantidade) {
        $produto = $this->buscarPorId($id);
        if (!$produto) {
            return false;
        }
        return $produto['estoque'] >= $quantidade;
    }
}