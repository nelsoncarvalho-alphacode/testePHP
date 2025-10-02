<?php
/**
 * ProdutoController
 * Controller responsável pelo CRUD dos produtos
 */
class ProdutoController {
    private $pdo;
    private $produtoModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        require_once __DIR__ . '/../models/Produto.php';
        $this->produtoModel = new Produto($pdo);
    }

    /**
     * Listar produtos (filtros e paginação)
     */
    public function listar($filtros = [], $ordem = 'nome', $direcao = 'ASC', $porPagina = 20, $pagina = 1) {
        $offset = ($pagina - 1) * $porPagina;
        
        $produtos = $this->produtoModel->listar($filtros, $ordem, $direcao, $porPagina, $offset);
        $total = $this->produtoModel->contar($filtros);
        $totalPaginas = ceil($total / $porPagina);

        return [
            'sucesso' => true,
            'produtos' => $produtos,
            'total' => $total,
            'pagina' => $pagina,
            'totalPaginas' => $totalPaginas,
            'porPagina' => $porPagina
        ];
    }

    /**
     * Buscar produto (por ID)
     */
    public function buscarPorId($id) {
        if (empty($id)) {
            return [
                'sucesso' => false,
                'mensagem' => 'ID não informado.'
            ];
        }

        $produto = $this->produtoModel->buscarPorId($id);

        if (!$produto) {
            return [
                'sucesso' => false,
                'mensagem' => 'Produto não encontrado.'
            ];
        }

        return [
            'sucesso' => true,
            'produto' => $produto
        ];
    }

    /**
     * Criar novo produto
     */
    public function criar($dados) {

        $validacao = $this->validarDados($dados);
        
        if (!$validacao['sucesso']) {
            return $validacao;
        }

        if (!empty($dados['cod_barras'])) {
            $produtoExistente = $this->produtoModel->buscarPorCodigoBarras($dados['cod_barras']);
            if ($produtoExistente) {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Código de barras já cadastrado.'
                ];
            }
        }

        // Criar produto
        try {
            $criado = $this->produtoModel->criar($dados);

            if ($criado) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Produto criado com sucesso!'
                ];
            } else {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Erro ao criar produto.'
                ];
            }
        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao criar produto: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Atualizar produto existente
     */
    public function atualizar($id, $dados) {

        $produto = $this->produtoModel->buscarPorId($id);
        if (!$produto) {
            return [
                'sucesso' => false,
                'mensagem' => 'Produto não encontrado.'
            ];
        }

        $validacao = $this->validarDados($dados, $id);
        
        if (!$validacao['sucesso']) {
            return $validacao;
        }

        // Verificar se código de barras já existe em outro produto
        if (!empty($dados['cod_barras'])) {
            $produtoExistente = $this->produtoModel->buscarPorCodigoBarras($dados['cod_barras']);
            if ($produtoExistente && $produtoExistente['id'] != $id) {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Código de barras já cadastrado para outro produto.'
                ];
            }
        }

        // Atualizar produto
        try {
            $atualizado = $this->produtoModel->atualizar($id, $dados);

            if ($atualizado) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Produto atualizado com sucesso!'
                ];
            } else {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Erro ao atualizar produto.'
                ];
            }
        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao atualizar produto: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Deletar produto
     */
    public function deletar($id) {
        if (empty($id)) {
            return [
                'sucesso' => false,
                'mensagem' => 'ID não informado.'
            ];
        }

        // Verificar se produto existe
        $produto = $this->produtoModel->buscarPorId($id);
        if (!$produto) {
            return [
                'sucesso' => false,
                'mensagem' => 'Produto não encontrado.'
            ];
        }

        // Deletar produto
        try {
            $deletado = $this->produtoModel->deletar($id);

            if ($deletado) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Produto excluído com sucesso!'
                ];
            } else {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Erro ao excluir produto.'
                ];
            }
        } catch (Exception $e) {

            if (strpos($e->getMessage(), 'foreign key constraint') !== false || 
                strpos($e->getMessage(), 'Cannot delete') !== false) {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Não é possível excluir este produto pois está vinculado a pedidos.'
                ];
            }

            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao excluir produto: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Deletar (múltiplos produtos)
     */
    public function deletarMultiplos($ids) {
        if (empty($ids) || !is_array($ids)) {
            return [
                'sucesso' => false,
                'mensagem' => 'Nenhum produto selecionado.'
            ];
        }

        try {
            $deletado = $this->produtoModel->deletarMultiplos($ids);

            if ($deletado) {
                $quantidade = count($ids);
                return [
                    'sucesso' => true,
                    'mensagem' => "{$quantidade} produto(s) excluído(s) com sucesso!"
                ];
            } else {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Erro ao excluir produtos.'
                ];
            }
        } catch (Exception $e) {

            if (strpos($e->getMessage(), 'foreign key constraint') !== false || 
                strpos($e->getMessage(), 'Cannot delete') !== false) {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Não foi possível excluir alguns produtos pois estão vinculados a pedidos.'
                ];
            }

            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao excluir produtos: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Atualizar estoque de um produto
     */
    public function atualizarEstoque($id, $quantidade) {
        if (empty($id)) {
            return [
                'sucesso' => false,
                'mensagem' => 'ID não informado.'
            ];
        }

        $produto = $this->produtoModel->buscarPorId($id);
        if (!$produto) {
            return [
                'sucesso' => false,
                'mensagem' => 'Produto não encontrado.'
            ];
        }

        $estoqueAtual = $produto['estoque'];
        $novoEstoque = $estoqueAtual + $quantidade;

        if ($novoEstoque < 0) {
            return [
                'sucesso' => false,
                'mensagem' => 'Quantidade insuficiente em estoque.'
            ];
        }

        try {
            $atualizado = $this->produtoModel->atualizarEstoque($id, $quantidade);

            if ($atualizado) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Estoque atualizado com sucesso!',
                    'estoque_anterior' => $estoqueAtual,
                    'estoque_novo' => $novoEstoque
                ];
            } else {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Erro ao atualizar estoque.'
                ];
            }
        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao atualizar estoque: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Verificar disponibilidade de estoque
     */
    public function verificarEstoque($id, $quantidade) {
        $produto = $this->produtoModel->buscarPorId($id);

        if (!$produto) {
            return [
                'sucesso' => false,
                'disponivel' => false,
                'mensagem' => 'Produto não encontrado.'
            ];
        }

        $disponivel = $this->produtoModel->verificarEstoque($id, $quantidade);

        return [
            'sucesso' => true,
            'disponivel' => $disponivel,
            'estoque_atual' => $produto['estoque'],
            'quantidade_solicitada' => $quantidade,
            'mensagem' => $disponivel ? 'Estoque disponível.' : 'Estoque insuficiente.'
        ];
    }

    /**
     * Validar dados do produto
     */
    private function validarDados($dados, $id = null) {
        $erros = [];

        // Validar nome
        if (empty($dados['nome'])) {
            $erros[] = 'Nome é obrigatório.';
        } elseif (strlen($dados['nome']) < 3) {
            $erros[] = 'Nome deve ter pelo menos 3 caracteres.';
        }

        // Validar preço
        if (!isset($dados['preco']) || $dados['preco'] === '') {
            $erros[] = 'Preço é obrigatório.';
        } elseif (!is_numeric($dados['preco']) || $dados['preco'] <= 0) {
            $erros[] = 'Preço deve ser maior que zero.';
        }

        // Validar estoque
        if (!isset($dados['estoque'])) {
            $dados['estoque'] = 0;
        } elseif (!is_numeric($dados['estoque']) || $dados['estoque'] < 0) {
            $erros[] = 'Estoque deve ser um número maior ou igual a zero.';
        }

        // Validar código de barras
        if (!empty($dados['cod_barras'])) {
            $codBarras = preg_replace('/[^0-9]/', '', $dados['cod_barras']);
            if (strlen($codBarras) < 8) {
                $erros[] = 'Código de barras deve ter pelo menos 8 dígitos.';
            }
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
     * Buscar todos os produtos (para uso em selects)
     */
    public function buscarTodos() {
        $produtos = $this->produtoModel->buscarTodos();
        
        return [
            'sucesso' => true,
            'produtos' => $produtos
        ];
    }

    /**
     * Formatar preço para exibição
     */
    public static function formatarPreco($preco) {
        return 'R$ ' . number_format($preco, 2, ',', '.');
    }

    /**
     * Obter status do estoque
     */
    public static function getStatusEstoque($quantidade) {
        if ($quantidade <= 0) {
            return [
                'classe' => 'danger',
                'texto' => 'Esgotado',
                'icone' => 'x-circle'
            ];
        } elseif ($quantidade <= 10) {
            return [
                'classe' => 'warning',
                'texto' => 'Baixo',
                'icone' => 'exclamation-triangle'
            ];
        } else {
            return [
                'classe' => 'success',
                'texto' => 'Disponível',
                'icone' => 'check-circle'
            ];
        }
    }

    /**
     * Calcular margem de lucro
     */
    public static function calcularMargem($precoCusto, $precoVenda) {
        if ($precoCusto <= 0 || $precoVenda <= 0) {
            return 0;
        }

        $margem = (($precoVenda - $precoCusto) / $precoCusto) * 100;
        return round($margem, 2);
    }
}