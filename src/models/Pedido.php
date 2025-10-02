<?php
class Pedido {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Listar pedidos (filtros, ordenação e paginação)
     */
    public function listar($filtros = [], $ordem = 'data_pedido', $direcao = 'DESC', $limite = 20, $offset = 0) {
        $sql = "SELECT p.*, c.nome as cliente_nome, c.cpf as cliente_cpf 
                FROM pedidos p 
                INNER JOIN clientes c ON p.cliente_id = c.id 
                WHERE 1=1";
        $params = [];

        // Filtros dinâmicos
        if (!empty($filtros['numero_pedido'])) {
            $sql .= " AND p.numero_pedido LIKE ?";
            $params[] = "%{$filtros['numero_pedido']}%";
        }
        if (!empty($filtros['cliente_nome'])) {
            $sql .= " AND c.nome LIKE ?";
            $params[] = "%{$filtros['cliente_nome']}%";
        }
        if (!empty($filtros['status'])) {
            $sql .= " AND p.status = ?";
            $params[] = $filtros['status'];
        }
        if (!empty($filtros['data_inicio'])) {
            $sql .= " AND p.data_pedido >= ?";
            $params[] = $filtros['data_inicio'];
        }
        if (!empty($filtros['data_fim'])) {
            $sql .= " AND p.data_pedido <= ?";
            $params[] = $filtros['data_fim'] . ' 23:59:59';
        }

        // Ordenação
        $colunasPermitidas = ['id', 'numero_pedido', 'cliente_nome', 'data_pedido', 'status', 'valor_total'];
        $ordem = in_array($ordem, $colunasPermitidas) ? $ordem : 'data_pedido';
        $direcao = in_array(strtoupper($direcao), ['ASC', 'DESC']) ? strtoupper($direcao) : 'DESC';
        
        if ($ordem === 'cliente_nome') {
            $sql .= " ORDER BY c.nome {$direcao}";
        } else {
            $sql .= " ORDER BY p.{$ordem} {$direcao}";
        }

        // Paginação
        $limite = (int)$limite;
        $offset = (int)$offset;
        $sql .= " LIMIT {$limite} OFFSET {$offset}";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Contar total de pedidos (com filtros)
     */
    public function contar($filtros = []) {
        $sql = "SELECT COUNT(*) FROM pedidos p 
                INNER JOIN clientes c ON p.cliente_id = c.id 
                WHERE 1=1";
        $params = [];

        if (!empty($filtros['numero_pedido'])) {
            $sql .= " AND p.numero_pedido LIKE ?";
            $params[] = "%{$filtros['numero_pedido']}%";
        }
        if (!empty($filtros['cliente_nome'])) {
            $sql .= " AND c.nome LIKE ?";
            $params[] = "%{$filtros['cliente_nome']}%";
        }
        if (!empty($filtros['status'])) {
            $sql .= " AND p.status = ?";
            $params[] = $filtros['status'];
        }
        if (!empty($filtros['data_inicio'])) {
            $sql .= " AND p.data_pedido >= ?";
            $params[] = $filtros['data_inicio'];
        }
        if (!empty($filtros['data_fim'])) {
            $sql .= " AND p.data_pedido <= ?";
            $params[] = $filtros['data_fim'] . ' 23:59:59';
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    /**
     * Buscar pedido (por ID)
     */
    public function buscarPorId($id) {
        $stmt = $this->pdo->prepare("
            SELECT p.*, c.nome as cliente_nome, c.cpf as cliente_cpf, c.email as cliente_email 
            FROM pedidos p 
            INNER JOIN clientes c ON p.cliente_id = c.id 
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Buscar itens de um pedido
     */
    public function buscarItensPedido($pedido_id) {
        $stmt = $this->pdo->prepare("
            SELECT pi.*, pr.nome as produto_nome, pr.cod_barras 
            FROM pedido_itens pi 
            INNER JOIN produtos pr ON pi.produto_id = pr.id 
            WHERE pi.pedido_id = ?
            ORDER BY pi.id
        ");
        $stmt->execute([$pedido_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Gerar número sequencial de pedido
     */
    public function gerarNumeroPedido() {
        $ano = date('Y');
        $stmt = $this->pdo->prepare("
            SELECT numero_pedido FROM pedidos 
            WHERE numero_pedido LIKE ? 
            ORDER BY id DESC LIMIT 1
        ");
        $stmt->execute(["PED-{$ano}-%"]);
        $ultimo = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($ultimo) {
            $numero = intval(substr($ultimo['numero_pedido'], -3)) + 1;
        } else {
            $numero = 1;
        }
        
        return sprintf("PED-%d-%03d", $ano, $numero);
    }

    /**
     * Criar novo pedido com itens (transaction)
     */
    public function criar($dados) {
        try {
            $this->pdo->beginTransaction();

            // Inserir pedido
            $stmt = $this->pdo->prepare("
                INSERT INTO pedidos (numero_pedido, cliente_id, data_pedido, status, desconto, valor_total, observacoes) 
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $dados['numero_pedido'],
                $dados['cliente_id'],
                $dados['data_pedido'],
                $dados['status'],
                $dados['desconto'],
                $dados['valor_total'],
                $dados['observacoes']
            ]);

            $pedido_id = $this->pdo->lastInsertId();

            // Inserir itens
            if (!empty($dados['itens'])) {
                $stmt = $this->pdo->prepare("
                    INSERT INTO pedido_itens (pedido_id, produto_id, quantidade, valor_unitario, subtotal) 
                    VALUES (?, ?, ?, ?, ?)
                ");
                
                foreach ($dados['itens'] as $item) {
                    $stmt->execute([
                        $pedido_id,
                        $item['produto_id'],
                        $item['quantidade'],
                        $item['valor_unitario'],
                        $item['subtotal']
                    ]);
                }
            }

            $this->pdo->commit();
            return $pedido_id;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    /**
     * Atualizar pedido existente com itens (transaction)
     */
    public function atualizar($id, $dados) {
        try {
            $this->pdo->beginTransaction();

            // Atualizar pedido
            $stmt = $this->pdo->prepare("
                UPDATE pedidos 
                SET cliente_id = ?, data_pedido = ?, status = ?, desconto = ?, valor_total = ?, observacoes = ? 
                WHERE id = ?
            ");
            $stmt->execute([
                $dados['cliente_id'],
                $dados['data_pedido'],
                $dados['status'],
                $dados['desconto'],
                $dados['valor_total'],
                $dados['observacoes'],
                $id
            ]);

            // Deletar itens antigos
            $stmt = $this->pdo->prepare("DELETE FROM pedido_itens WHERE pedido_id = ?");
            $stmt->execute([$id]);

            // Inserir novos itens
            if (!empty($dados['itens'])) {
                $stmt = $this->pdo->prepare("
                    INSERT INTO pedido_itens (pedido_id, produto_id, quantidade, valor_unitario, subtotal) 
                    VALUES (?, ?, ?, ?, ?)
                ");
                
                foreach ($dados['itens'] as $item) {
                    $stmt->execute([
                        $id,
                        $item['produto_id'],
                        $item['quantidade'],
                        $item['valor_unitario'],
                        $item['subtotal']
                    ]);
                }
            }

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    /**
     * Deletar pedido (itens são deletados por CASCADE)
     */
    public function deletar($id) {
        $stmt = $this->pdo->prepare("DELETE FROM pedidos WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Deletar múltiplos pedidos
     */
    public function deletarMultiplos($ids) {
        if (empty($ids)) {
            return false;
        }
        
        $placeholders = str_repeat('?,', count($ids) - 1) . '?';
        $stmt = $this->pdo->prepare("DELETE FROM pedidos WHERE id IN ($placeholders)");
        return $stmt->execute($ids);
    }

    /**
     * Buscar pedidos de um cliente específico
     */
    public function buscarPorCliente($cliente_id, $limite = 10) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM pedidos 
            WHERE cliente_id = ? 
            ORDER BY data_pedido DESC 
            LIMIT ?
        ");
        $stmt->execute([$cliente_id, $limite]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Buscar pedidos por status
     */
    public function buscarPorStatus($status) {
        $stmt = $this->pdo->prepare("
            SELECT p.*, c.nome as cliente_nome 
            FROM pedidos p 
            INNER JOIN clientes c ON p.cliente_id = c.id 
            WHERE p.status = ? 
            ORDER BY p.data_pedido DESC
        ");
        $stmt->execute([$status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Calcular total de vendas por status
     */
    public function calcularTotalVendas($status = 'Pago') {
        $stmt = $this->pdo->prepare("
            SELECT SUM(valor_total) as total 
            FROM pedidos 
            WHERE status = ?
        ");
        $stmt->execute([$status]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] ?? 0;
    }
}