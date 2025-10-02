<?php
/**
 * PedidoController
 * Controller responsável pelo CRUD dos pedidos
 */
class PedidoController {
    private $pdo;
    private $pedidoModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        require_once __DIR__ . '/../models/Pedido.php';
        $this->pedidoModel = new Pedido($pdo);
    }

    /**
     * Listar pedidos (filtros e paginação)
     */
    public function listar($filtros = [], $ordem = 'data_pedido', $direcao = 'DESC', $porPagina = 20, $pagina = 1) {
        $offset = ($pagina - 1) * $porPagina;
        
        $pedidos = $this->pedidoModel->listar($filtros, $ordem, $direcao, $porPagina, $offset);
        $total = $this->pedidoModel->contar($filtros);
        $totalPaginas = ceil($total / $porPagina);

        return [
            'sucesso' => true,
            'pedidos' => $pedidos,
            'total' => $total,
            'pagina' => $pagina,
            'totalPaginas' => $totalPaginas,
            'porPagina' => $porPagina
        ];
    }

    /**
     * Buscar pedido (por ID com itens)
     */
    public function buscarPorId($id) {
        if (empty($id)) {
            return [
                'sucesso' => false,
                'mensagem' => 'ID não informado.'
            ];
        }

        $pedido = $this->pedidoModel->buscarPorId($id);

        if (!$pedido) {
            return [
                'sucesso' => false,
                'mensagem' => 'Pedido não encontrado.'
            ];
        }

        // Buscar itens do pedido
        $itens = $this->pedidoModel->buscarItensPedido($id);

        return [
            'sucesso' => true,
            'pedido' => $pedido,
            'itens' => $itens
        ];
    }

    /**
     * Criar novo pedido (com itens)
     */
    public function criar($dados) {

        $validacao = $this->validarDados($dados);
        
        if (!$validacao['sucesso']) {
            return $validacao;
        }

        if (empty($dados['numero_pedido'])) {
            $dados['numero_pedido'] = $this->pedidoModel->gerarNumeroPedido();
        }

        $processamento = $this->processarItens($dados['itens']);
        
        if (!$processamento['sucesso']) {
            return $processamento;
        }

        $dados['itens'] = $processamento['itens'];
        $subtotal = $processamento['subtotal'];

        // Calcular valor total
        $desconto = isset($dados['desconto']) ? floatval($dados['desconto']) : 0;
        $dados['valor_total'] = $subtotal - $desconto;

        // Validar valor total
        if ($dados['valor_total'] < 0) {
            return [
                'sucesso' => false,
                'mensagem' => 'O desconto não pode ser maior que o valor total.'
            ];
        }

        // Criar pedido
        try {
            $pedido_id = $this->pedidoModel->criar($dados);

            if ($pedido_id) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Pedido criado com sucesso!',
                    'pedido_id' => $pedido_id,
                    'numero_pedido' => $dados['numero_pedido']
                ];
            } else {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Erro ao criar pedido.'
                ];
            }
        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao criar pedido: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Atualizar pedido (existente com itens)
     */
    public function atualizar($id, $dados) {

        $pedido = $this->pedidoModel->buscarPorId($id);
        if (!$pedido) {
            return [
                'sucesso' => false,
                'mensagem' => 'Pedido não encontrado.'
            ];
        }

        $validacao = $this->validarDados($dados);
        
        if (!$validacao['sucesso']) {
            return $validacao;
        }

        $processamento = $this->processarItens($dados['itens']);
        
        if (!$processamento['sucesso']) {
            return $processamento;
        }

        $dados['itens'] = $processamento['itens'];
        $subtotal = $processamento['subtotal'];

        // Calcular valor total
        $desconto = isset($dados['desconto']) ? floatval($dados['desconto']) : 0;
        $dados['valor_total'] = $subtotal - $desconto;

        // Validar valor total
        if ($dados['valor_total'] < 0) {
            return [
                'sucesso' => false,
                'mensagem' => 'O desconto não pode ser maior que o valor total.'
            ];
        }

        // Atualizar pedido
        try {
            $atualizado = $this->pedidoModel->atualizar($id, $dados);

            if ($atualizado) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Pedido atualizado com sucesso!'
                ];
            } else {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Erro ao atualizar pedido.'
                ];
            }
        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao atualizar pedido: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Deletar pedido
     */
    public function deletar($id) {
        if (empty($id)) {
            return [
                'sucesso' => false,
                'mensagem' => 'ID não informado.'
            ];
        }

        $pedido = $this->pedidoModel->buscarPorId($id);
        if (!$pedido) {
            return [
                'sucesso' => false,
                'mensagem' => 'Pedido não encontrado.'
            ];
        }

        // Deletar pedido (itens serão deletados por CASCADE)
        try {
            $deletado = $this->pedidoModel->deletar($id);

            if ($deletado) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Pedido excluído com sucesso!'
                ];
            } else {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Erro ao excluir pedido.'
                ];
            }
        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao excluir pedido: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Deletar (múltiplos pedidos)
     */
    public function deletarMultiplos($ids) {
        if (empty($ids) || !is_array($ids)) {
            return [
                'sucesso' => false,
                'mensagem' => 'Nenhum pedido selecionado.'
            ];
        }

        try {
            $deletado = $this->pedidoModel->deletarMultiplos($ids);

            if ($deletado) {
                $quantidade = count($ids);
                return [
                    'sucesso' => true,
                    'mensagem' => "{$quantidade} pedido(s) excluído(s) com sucesso!"
                ];
            } else {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Erro ao excluir pedidos.'
                ];
            }
        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao excluir pedidos: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Atualizar status do pedido
     */
    public function atualizarStatus($id, $novoStatus) {
        $statusPermitidos = ['Em Aberto', 'Pago', 'Cancelado'];
        
        if (!in_array($novoStatus, $statusPermitidos)) {
            return [
                'sucesso' => false,
                'mensagem' => 'Status inválido.'
            ];
        }

        // Buscar pedido atual
        $pedido = $this->pedidoModel->buscarPorId($id);
        if (!$pedido) {
            return [
                'sucesso' => false,
                'mensagem' => 'Pedido não encontrado.'
            ];
        }

        // Buscar itens
        $itens = $this->pedidoModel->buscarItensPedido($id);

        $dados = [
            'cliente_id' => $pedido['cliente_id'],
            'data_pedido' => $pedido['data_pedido'],
            'status' => $novoStatus,
            'desconto' => $pedido['desconto'],
            'valor_total' => $pedido['valor_total'],
            'observacoes' => $pedido['observacoes'],
            'itens' => array_map(function($item) {
                return [
                    'produto_id' => $item['produto_id'],
                    'quantidade' => $item['quantidade'],
                    'valor_unitario' => $item['valor_unitario'],
                    'subtotal' => $item['subtotal']
                ];
            }, $itens)
        ];

        try {
            $atualizado = $this->pedidoModel->atualizar($id, $dados);

            if ($atualizado) {
                return [
                    'sucesso' => true,
                    'mensagem' => "Status alterado para '{$novoStatus}' com sucesso!"
                ];
            } else {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Erro ao atualizar status.'
                ];
            }
        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao atualizar status: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Validar dados do pedido
     */
    private function validarDados($dados) {
        $erros = [];

        // Validar cliente
        if (empty($dados['cliente_id'])) {
            $erros[] = 'Cliente é obrigatório.';
        }

        // Validar data
        if (empty($dados['data_pedido'])) {
            $dados['data_pedido'] = date('Y-m-d H:i:s');
        }

        // Validar status
        $statusPermitidos = ['Em Aberto', 'Pago', 'Cancelado'];
        if (empty($dados['status'])) {
            $dados['status'] = 'Em Aberto';
        } elseif (!in_array($dados['status'], $statusPermitidos)) {
            $erros[] = 'Status inválido.';
        }

        // Validar itens
        if (empty($dados['itens']) || !is_array($dados['itens'])) {
            $erros[] = 'Adicione pelo menos um item ao pedido.';
        }

        // Validar desconto
        if (!isset($dados['desconto'])) {
            $dados['desconto'] = 0;
        } elseif (!is_numeric($dados['desconto']) || $dados['desconto'] < 0) {
            $erros[] = 'Desconto deve ser um valor maior ou igual a zero.';
        }

        if (!empty($erros)) {
            return [
                'sucesso' => false,
                'mensagem' => implode('<br>', $erros),
                'erros' => $erros
            ];
        }

        return ['sucesso' => true];
    }

    /**
     * Processar e validar itens do pedido
     */
    private function processarItens($itens) {
        if (empty($itens) || !is_array($itens)) {
            return [
                'sucesso' => false,
                'mensagem' => 'Nenhum item informado.'
            ];
        }

        $itensProcessados = [];
        $subtotal = 0;

        foreach ($itens as $item) {

            if (empty($item['produto_id']) || empty($item['quantidade']) || !isset($item['valor_unitario'])) {
                continue;
            }

            $quantidade = intval($item['quantidade']);
            $valorUnitario = floatval($item['valor_unitario']);

            if ($quantidade <= 0 || $valorUnitario < 0) {
                continue;
            }

            $itemSubtotal = $quantidade * $valorUnitario;

            $itensProcessados[] = [
                'produto_id' => intval($item['produto_id']),
                'quantidade' => $quantidade,
                'valor_unitario' => $valorUnitario,
                'subtotal' => $itemSubtotal
            ];

            $subtotal += $itemSubtotal;
        }

        if (empty($itensProcessados)) {
            return [
                'sucesso' => false,
                'mensagem' => 'Nenhum item válido encontrado.'
            ];
        }

        return [
            'sucesso' => true,
            'itens' => $itensProcessados,
            'subtotal' => $subtotal
        ];
    }

    /**
     * Buscar pedidos (de um cliente)
     */
    public function buscarPorCliente($cliente_id, $limite = 10) {
        $pedidos = $this->pedidoModel->buscarPorCliente($cliente_id, $limite);
        
        return [
            'sucesso' => true,
            'pedidos' => $pedidos
        ];
    }

    /**
     * Buscar pedidos (por status)
     */
    public function buscarPorStatus($status) {
        $statusPermitidos = ['Em Aberto', 'Pago', 'Cancelado'];
        
        if (!in_array($status, $statusPermitidos)) {
            return [
                'sucesso' => false,
                'mensagem' => 'Status inválido.'
            ];
        }

        $pedidos = $this->pedidoModel->buscarPorStatus($status);
        
        return [
            'sucesso' => true,
            'pedidos' => $pedidos
        ];
    }

    /**
     * Calcular estatísticas de pedidos
     */
    public function calcularEstatisticas() {
        try {
            $totalVendas = $this->pedidoModel->calcularTotalVendas('Pago');
            
            $emAberto = $this->pedidoModel->contar(['status' => 'Em Aberto']);
            $pagos = $this->pedidoModel->contar(['status' => 'Pago']);
            $cancelados = $this->pedidoModel->contar(['status' => 'Cancelado']);
            
            return [
                'sucesso' => true,
                'estatisticas' => [
                    'total_vendas' => $totalVendas,
                    'pedidos_em_aberto' => $emAberto,
                    'pedidos_pagos' => $pagos,
                    'pedidos_cancelados' => $cancelados,
                    'total_pedidos' => $emAberto + $pagos + $cancelados
                ]
            ];
        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao calcular estatísticas: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Obter classe CSS (badge de status)
     */
    public static function getClasseStatus($status) {
        $classes = [
            'Em Aberto' => 'bg-warning text-dark',
            'Pago' => 'bg-success',
            'Cancelado' => 'bg-danger'
        ];

        return $classes[$status] ?? 'bg-secondary';
    }

    /**
     * Formatar número do pedido
     */
    public static function formatarNumeroPedido($numero) {
        return strtoupper($numero);
    }

    /**
     * Calcular ticket médio
     */
    public static function calcularTicketMedio($valorTotal, $quantidadeItens) {
        if ($quantidadeItens <= 0) {
            return 0;
        }

        return $valorTotal / $quantidadeItens;
    }
}