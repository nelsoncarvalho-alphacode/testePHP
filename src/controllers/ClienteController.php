<?php
/**
 * ClienteController
 * Controller responsável pelo CRUD dos clientes
 */
class ClienteController {
    private $pdo;
    private $clienteModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        require_once __DIR__ . '/../models/Cliente.php';
        $this->clienteModel = new Cliente($pdo);
    }

    /**
     * Listar clientes (filtros e paginação)
     */
    public function listar($filtros = [], $ordem = 'nome', $direcao = 'ASC', $porPagina = 20, $pagina = 1) {
        $offset = ($pagina - 1) * $porPagina;
        
        $clientes = $this->clienteModel->listar($filtros, $ordem, $direcao, $porPagina, $offset);
        $total = $this->clienteModel->contar($filtros);
        $totalPaginas = ceil($total / $porPagina);

        return [
            'sucesso' => true,
            'clientes' => $clientes,
            'total' => $total,
            'pagina' => $pagina,
            'totalPaginas' => $totalPaginas,
            'porPagina' => $porPagina
        ];
    }

    /**
     * Buscar cliente por ID
     */
    public function buscarPorId($id) {
        if (empty($id)) {
            return [
                'sucesso' => false,
                'mensagem' => 'ID não informado.'
            ];
        }

        $cliente = $this->clienteModel->buscarPorId($id);

        if (!$cliente) {
            return [
                'sucesso' => false,
                'mensagem' => 'Cliente não encontrado.'
            ];
        }

        return [
            'sucesso' => true,
            'cliente' => $cliente
        ];
    }

    /**
     * Criar novo cliente
     */
    public function criar($dados) {

        $validacao = $this->validarDados($dados);
        
        if (!$validacao['sucesso']) {
            return $validacao;
        }

        $dados['cpf'] = preg_replace('/[^0-9]/', '', $dados['cpf']);

        $clienteExistente = $this->clienteModel->buscarPorCpf($dados['cpf']);
        if ($clienteExistente) {
            return [
                'sucesso' => false,
                'mensagem' => 'CPF já cadastrado.'
            ];
        }

        // Criar cliente
        try {
            $criado = $this->clienteModel->criar($dados);

            if ($criado) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Cliente criado com sucesso!'
                ];
            } else {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Erro ao criar cliente.'
                ];
            }
        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao criar cliente: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Atualizar cliente existente
     */
    public function atualizar($id, $dados) {

        $cliente = $this->clienteModel->buscarPorId($id);
        if (!$cliente) {
            return [
                'sucesso' => false,
                'mensagem' => 'Cliente não encontrado.'
            ];
        }

        $validacao = $this->validarDados($dados, $id);
        
        if (!$validacao['sucesso']) {
            return $validacao;
        }

        $dados['cpf'] = preg_replace('/[^0-9]/', '', $dados['cpf']);

        $clienteExistente = $this->clienteModel->buscarPorCpf($dados['cpf']);
        if ($clienteExistente && $clienteExistente['id'] != $id) {
            return [
                'sucesso' => false,
                'mensagem' => 'CPF já cadastrado para outro cliente.'
            ];
        }

        // Atualizar cliente
        try {
            $atualizado = $this->clienteModel->atualizar($id, $dados);

            if ($atualizado) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Cliente atualizado com sucesso!'
                ];
            } else {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Erro ao atualizar cliente.'
                ];
            }
        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao atualizar cliente: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Deletar cliente
     */
    public function deletar($id) {
        if (empty($id)) {
            return [
                'sucesso' => false,
                'mensagem' => 'ID não informado.'
            ];
        }

        // Verificar se cliente existe
        $cliente = $this->clienteModel->buscarPorId($id);
        if (!$cliente) {
            return [
                'sucesso' => false,
                'mensagem' => 'Cliente não encontrado.'
            ];
        }

        // Deletar cliente
        try {
            $deletado = $this->clienteModel->deletar($id);

            if ($deletado) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Cliente excluído com sucesso!'
                ];
            } else {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Erro ao excluir cliente.'
                ];
            }
        } catch (Exception $e) {

            if (strpos($e->getMessage(), 'foreign key constraint') !== false || 
                strpos($e->getMessage(), 'Cannot delete') !== false) {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Não é possível excluir este cliente pois possui pedidos vinculados.'
                ];
            }

            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao excluir cliente: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Deletar vários clientes
     */
    public function deletarMultiplos($ids) {
        if (empty($ids) || !is_array($ids)) {
            return [
                'sucesso' => false,
                'mensagem' => 'Nenhum cliente selecionado.'
            ];
        }

        try {
            $deletado = $this->clienteModel->deletarMultiplos($ids);

            if ($deletado) {
                $quantidade = count($ids);
                return [
                    'sucesso' => true,
                    'mensagem' => "{$quantidade} cliente(s) excluído(s) com sucesso!"
                ];
            } else {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Erro ao excluir clientes.'
                ];
            }
        } catch (Exception $e) {

            if (strpos($e->getMessage(), 'foreign key constraint') !== false || 
                strpos($e->getMessage(), 'Cannot delete') !== false) {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Não foi possível excluir alguns clientes pois possuem pedidos vinculados.'
                ];
            }

            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao excluir clientes: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Validar dados (cliente)
     */
    private function validarDados($dados, $id = null) {
        $erros = [];

        // Validar nome
        if (empty($dados['nome'])) {
            $erros[] = 'Nome é obrigatório.';
        } elseif (strlen($dados['nome']) < 3) {
            $erros[] = 'Nome deve ter pelo menos 3 caracteres.';
        }

        // Validar CPF
        if (empty($dados['cpf'])) {
            $erros[] = 'CPF é obrigatório.';
        } else {
            $cpf = preg_replace('/[^0-9]/', '', $dados['cpf']);
            if (strlen($cpf) != 11) {
                $erros[] = 'CPF inválido.';
            } elseif (!$this->validarCPF($cpf)) {
                $erros[] = 'CPF inválido.';
            }
        }

        // Validar email
        if (!empty($dados['email']) && !filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
            $erros[] = 'Email inválido.';
        }

        // Validar telefone
        if (!empty($dados['telefone'])) {
            $telefone = preg_replace('/[^0-9]/', '', $dados['telefone']);
            if (strlen($telefone) < 10 || strlen($telefone) > 11) {
                $erros[] = 'Telefone inválido.';
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
     * Validar CPF
     */
    private function validarCPF($cpf) {

        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpf) != 11) {
            return false;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    /**
     * Buscar todos os clientes (uso em selects)
     */
    public function buscarTodos() {
        $clientes = $this->clienteModel->buscarTodos();
        
        return [
            'sucesso' => true,
            'clientes' => $clientes
        ];
    }

    /**
     * Formatar CPF para exibição
     */
    public static function formatarCPF($cpf) {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        if (strlen($cpf) == 11) {
            return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
        }
        return $cpf;
    }

    /**
     * Formatar telefone para exibição
     */
    public static function formatarTelefone($telefone) {
        $telefone = preg_replace('/[^0-9]/', '', $telefone);
        if (strlen($telefone) == 11) {
            return '(' . substr($telefone, 0, 2) . ') ' . substr($telefone, 2, 5) . '-' . substr($telefone, 7, 4);
        } elseif (strlen($telefone) == 10) {
            return '(' . substr($telefone, 0, 2) . ') ' . substr($telefone, 2, 4) . '-' . substr($telefone, 6, 4);
        }
        return $telefone;
    }
}