<?php

// Controller responsável por autenticação e gerenciamento de sessões
namespace Controllers;

use Repository\UserRepository;

class AuthController
{
    // Autentica usuário e inicia sessão
    public static function login()
    {
        // Limpa buffer de saída apenas se houver um ativo
        if (ob_get_level()) {
            ob_clean();
        }

        // Captura dados de login do JSON
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        // Validação de campos obrigatórios
        if (empty($email) || empty($password)) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'E-mail e senha são obrigatórios']);
            die();
        }

        // Busca usuário por email e verifica credenciais
        $repo = new UserRepository;
        $user = $repo->findByEmail($data['email']);

        if (!$user || !password_verify($password, $user['password'])) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Credenciais inválidas']);
            die();
        }

        // Inicia sessão com dados do usuário
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['is_admin'] = $user['is_admin'];
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Login realizado com sucesso', 'is_admin' => $user['is_admin']]);
        die();
    }

    // Encerra sessão do usuário e redireciona para login
    public static function logout()
    {
        session_start();
        session_destroy();
        header('Location: app/login');
        exit;
    }
}
