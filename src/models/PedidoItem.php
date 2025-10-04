<?php
/**
 * Classe PedidoItem
 */
class PedidoItem {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function criar($pedido_id, $produto_id, $quantidade, $valor_unitario) {
        $subtotal = $quantidade * $valor_unitario;
        
        $stmt = $this->pdo->prepare("
            INSERT INTO pedido_itens (pedido_id, produto_id, quantidade, valor_unitario, subtotal) 
            VALUES (?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $pedido_id,
            $produto_id,
            $quantidade,
            $valor_unitario,
            $subtotal
        ]);
    }

    public function buscarPorPedido($pedido_id) {
        $stmt = $this->pdo->prepare("
            SELECT pi.*, p.nome as produto_nome, p.cod_barras, p.preco as preco_atual
            FROM pedido_itens pi
            INNER JOIN produtos p ON pi.produto_id = p.id
            WHERE pi.pedido_id = ?
            ORDER BY pi.id
        ");
        $stmt->execute([$pedido_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorProduto($produto_id) {
        $stmt = $this->pdo->prepare("
            SELECT pi.*, ped.numero_pedido, ped.data_pedido, ped.status,
                   c.nome as cliente_nome
            FROM pedido_itens pi
            INNER JOIN pedidos ped ON pi.pedido_id = ped.id
            INNER JOIN clientes c ON ped.cliente_id = c.id
            WHERE pi.produto_id = ?
            ORDER BY ped.data_pedido DESC
        ");
        $stmt->execute([$produto_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function atualizar($id, $quantidade, $valor_unitario) {
        $subtotal = $quantidade * $valor_unitario;
        
        $stmt = $this->pdo->prepare("
            UPDATE pedido_itens 
            SET quantidade = ?, valor_unitario = ?, subtotal = ? 
            WHERE id = ?
        ");
        
        return $stmt->execute([
            $quantidade,
            $valor_unitario,
            $subtotal,
            $id
        ]);
    }

    public function deletar($id) {
        $stmt = $this->pdo->prepare("DELETE FROM pedido_itens WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function deletarPorPedido($pedido_id) {
        $stmt = $this->pdo->prepare("DELETE FROM pedido_itens WHERE pedido_id = ?");
        return $stmt->execute([$pedido_id]);
    }

    public function calcularSubtotalPedido($pedido_id) {
        $stmt = $this->pdo->prepare("
            SELECT SUM(subtotal) as total 
            FROM pedido_itens 
            WHERE pedido_id = ?
        ");
        $stmt->execute([$pedido_id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] ?? 0;
    }

    public function contarItensPedido($pedido_id) {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) as total 
            FROM pedido_itens 
            WHERE pedido_id = ?
        ");
        $stmt->execute([$pedido_id]);
        return $stmt->fetchColumn();
    }

    public function verificarProdutoEmPedido($produto_id) {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) 
            FROM pedido_itens 
            WHERE produto_id = ?
        ");
        $stmt->execute([$produto_id]);
        return $stmt->fetchColumn() > 0;
    }

    public function obterMaisVendidos($limite = 10) {
        $stmt = $this->pdo->prepare("
            SELECT 
                p.id,
                p.nome,
                p.preco,
                SUM(pi.quantidade) as total_vendido,
                COUNT(DISTINCT pi.pedido_id) as numero_pedidos,
                SUM(pi.subtotal) as receita_total
            FROM pedido_itens pi
            INNER JOIN produtos p ON pi.produto_id = p.id
            INNER JOIN pedidos ped ON pi.pedido_id = ped.id
            WHERE ped.status = 'Pago'
            GROUP BY p.id, p.nome, p.preco
            ORDER BY total_vendido DESC
            LIMIT ?
        ");
        $stmt->execute([$limite]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obterUltimasVendas($produto_id, $limite = 5) {
        $stmt = $this->pdo->prepare("
            SELECT 
                pi.*,
                ped.numero_pedido,
                ped.data_pedido,
                ped.status,
                c.nome as cliente_nome
            FROM pedido_itens pi
            INNER JOIN pedidos ped ON pi.pedido_id = ped.id
            INNER JOIN clientes c ON ped.cliente_id = c.id
            WHERE pi.produto_id = ?
            ORDER BY ped.data_pedido DESC
            LIMIT ?
        ");
        $stmt->execute([$produto_id, $limite]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id) {
        $stmt = $this->pdo->prepare("
            SELECT pi.*, p.nome as produto_nome, p.cod_barras
            FROM pedido_itens pi
            INNER JOIN produtos p ON pi.produto_id = p.id
            WHERE pi.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}