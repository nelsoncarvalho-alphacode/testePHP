<?php

// Controller responsável por gerenciar operações de usuários
namespace Controllers;

use Repository\UserRepository;

class UserController
{

    // Lista todos os usuários cadastrados
    public static function list()
    {
        $repo = new UserRepository();
        $users = $repo->list();
        header('Content-Type: application/json');
        echo json_encode($users);
    }


    // Busca usuário específico por ID
    public static function find($id)
    {
        $repo = new UserRepository();
        $user = $repo->find($id);
        header('Content-Type: application/json');

        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Usuário não encontrado']);
        }
    }

    // Cria novo usuário com validação de dados obrigatórios
    public static function create()
    {
        // Limpa buffer de saída apenas se houver um ativo
        if (ob_get_level()) {
            ob_clean();
        }
        
        // Captura dados do JSON
        $data = json_decode((file_get_contents(('php://input'))), true);

        // Validação de campo obrigatório
        if (!isset($data['name']) || empty($data['name'])) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['error' => "Nome é obrigatório"]);
            return;
        }

        // Cria usuário no banco de dados
        $repo = new UserRepository();
        $result = $repo->create($data);

        header('Content-Type: application/json');

        // Trata retorno baseado no resultado
        if (is_array($result) && isset($result['error'])) {
            http_response_code(400);
            echo json_encode(['error' => $result['error']]);
        } else if ($result) {
            echo json_encode(['message' => 'Usuário criado com sucesso!', 'id' => $result]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erro ao criar usuário.']);
        }
    }

    // Atualiza dados de usuário existente
    public static function update($id)
    {
        // Captura dados do JSON
        $data = json_decode((file_get_contents(('php://input'))), true);
        
        // Atualiza usuário no banco de dados
        $repo = new UserRepository();
        $result = $repo->update($id, $data);
        header('Content-Type: application/json');

        // Trata retorno baseado no resultado
        if (is_array($result) && isset($result['error'])) {
            http_response_code(400);
            echo json_encode(['error' => $result['error']]);
        } else if ($result) {
            echo json_encode(['message' => "Usuário com ID $id atualizado com sucesso"]);
        } else {
            http_response_code(404);
            echo json_encode(['message' => "Algo deu errado, verifique as informações"]);
        }
    }

    // Remove usuário do banco de dados
    public static function delete($id)
    {
        $repo = new UserRepository;
        $success = $repo->delete($id);
        header('Content-Type: application/json');

        if ($success) {
            echo json_encode(['message' => "Usuário com ID $id deletado com sucesso"]);
        } else {
            http_response_code(404);
            echo json_encode(['message' => "Usuário não encontrado"]);
        }
    }
}
