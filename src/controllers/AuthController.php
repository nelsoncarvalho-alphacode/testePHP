<?php
/**
 * AuthController
 * Controller responsável pela autenticação de usuários
 */
class AuthController {
    private $pdo;
    private $usuarioModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        require_once __DIR__ . '/../models/Usuario.php';
        $this->usuarioModel = new Usuario($pdo);
    }

    /**
     * Login
     */
    public function login($email, $senha) {

        if (empty($email) || empty($senha)) {
            return [
                'sucesso' => false,
                'mensagem' => 'Preencha todos os campos.'
            ];
        }

        // Buscar usuário
        $usuario = $this->usuarioModel->buscarPorEmail($email);

        if (!$usuario) {
            return [
                'sucesso' => false,
                'mensagem' => 'Email ou senha inválidos.'
            ];
        }

        // Validar senha
        if (!$this->usuarioModel->validarSenha($senha, $usuario['senha'])) {
            return [
                'sucesso' => false,
                'mensagem' => 'Email ou senha inválidos.'
            ];
        }

        // Criar sessão
        $this->criarSessao($usuario);

        return [
            'sucesso' => true,
            'mensagem' => 'Login realizado com sucesso!',
            'usuario' => $usuario
        ];
    }

    /**
     * Register
     */
    public function registrar($nome, $email, $senha, $confirmar_senha) {

        $erros = [];

        if (empty($nome)) {
            $erros[] = 'Nome é obrigatório.';
        }

        if (empty($email)) {
            $erros[] = 'Email é obrigatório.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erros[] = 'Email inválido.';
        }

        if (empty($senha)) {
            $erros[] = 'Senha é obrigatória.';
        } elseif (strlen($senha) < 6) {
            $erros[] = 'A senha deve ter pelo menos 6 caracteres.';
        }

        if ($senha !== $confirmar_senha) {
            $erros[] = 'As senhas não coincidem.';
        }

        // Verificar se o email já existe
        if (empty($erros)) {
            $usuarioExistente = $this->usuarioModel->buscarPorEmail($email);
            if ($usuarioExistente) {
                $erros[] = 'Este email já está cadastrado.';
            }
        }

        // Se houver erros, retornar
        if (!empty($erros)) {
            return [
                'sucesso' => false,
                'mensagem' => implode('<br>', $erros),
                'erros' => $erros
            ];
        }

        // Criar usuário
        try {
            $criado = $this->usuarioModel->criar($nome, $email, $senha);
            
            if ($criado) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Cadastro realizado com sucesso!'
                ];
            } else {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Erro ao criar usuário. Tente novamente.'
                ];
            }
        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao criar usuário: ' . $e->getMessage()
            ];
        }
    }

    /**
     * User session
     */
    private function criarSessao($usuario) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_email'] = $usuario['email'];
        $_SESSION['logado'] = true;
    }

    /**
     * Verifica se usuário está logado
     */
    public static function verificarLogin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION['usuario_id']) && isset($_SESSION['logado']);
    }

    /**
     * User session
     */
    public static function obterUsuarioSessao() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (self::verificarLogin()) {
            return [
                'id' => $_SESSION['usuario_id'],
                'nome' => $_SESSION['usuario_nome'],
                'email' => $_SESSION['usuario_email']
            ];
        }

        return null;
    }

    /**
     * Logout
     */
    public static function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];

        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }

        session_destroy();

        return [
            'sucesso' => true,
            'mensagem' => 'Logout realizado com sucesso!'
        ];
    }

    /**
     * Redirect se não estiver logado
     */
    public static function requerLogin($redirecionar = '../views/login.php') {
        if (!self::verificarLogin()) {
            header('Location: ' . $redirecionar);
            exit;
        }
    }

    /**
     * Redirect se estiver logado
     */
    public static function requerDeslogado($redirecionar = '../index.php') {
        if (self::verificarLogin()) {
            header('Location: ' . $redirecionar);
            exit;
        }
    }

    /**
     * Alterar senha
     */
    public function alterarSenha($usuario_id, $senha_atual, $nova_senha, $confirmar_nova_senha) {

        $erros = [];

        if (empty($senha_atual)) {
            $erros[] = 'Senha atual é obrigatória.';
        }

        if (empty($nova_senha)) {
            $erros[] = 'Nova senha é obrigatória.';
        } elseif (strlen($nova_senha) < 6) {
            $erros[] = 'A nova senha deve ter pelo menos 6 caracteres.';
        }

        if ($nova_senha !== $confirmar_nova_senha) {
            $erros[] = 'As senhas não coincidem.';
        }

        if (!empty($erros)) {
            return [
                'sucesso' => false,
                'mensagem' => implode('<br>', $erros),
                'erros' => $erros
            ];
        }

        // Buscar usuário
        $usuario = $this->usuarioModel->buscarPorId($usuario_id);

        if (!$usuario) {
            return [
                'sucesso' => false,
                'mensagem' => 'Usuário não encontrado.'
            ];
        }

        // Validar senha atual
        if (!$this->usuarioModel->validarSenha($senha_atual, $usuario['senha'])) {
            return [
                'sucesso' => false,
                'mensagem' => 'Senha atual incorreta.'
            ];
        }

        // Atualizar senha
        try {
            $atualizado = $this->usuarioModel->atualizar($usuario_id, [
                'nome' => $usuario['nome'],
                'email' => $usuario['email'],
                'senha' => $nova_senha
            ]);

            if ($atualizado) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Senha alterada com sucesso!'
                ];
            } else {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Erro ao alterar senha.'
                ];
            }
        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao alterar senha: ' . $e->getMessage()
            ];
        }
    }
}