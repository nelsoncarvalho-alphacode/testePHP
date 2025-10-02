<?php

namespace Controllers;

use Repository\UserRepository;

class AuthController {
    public static function login() {

        ob_clean();

        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        if(empty($email) || empty($password)) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'E-mail e senha são obrigatórios']);
            die();
        }

        $repo = new UserRepository;

        $user = $repo->findByEmail($data['email']);

        if(!$user || !password_verify($password, $user['password'])) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Credenciais inválidas']);
            die();
        }

        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['is_admin'] = $user['is_admin'];
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Login realizado com sucesso', 'is_admin' => $user['is_admin']]);
        die();
    }

    public static function logout() {
        session_start();
        session_destroy();
        header('Location: app/login');
        exit;
    }
}