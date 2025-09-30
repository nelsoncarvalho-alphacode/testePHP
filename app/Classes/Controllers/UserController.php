<?php

namespace Controllers;

use Repository\UserRepository;

class UserController
{
    
    // Método para listar usuários
    public static function list()
    {
        $repo = new UserRepository();
        $users = $repo->list();
        header('Content-Type: application/json');
        echo json_encode($users);
        echo 'Método chamado';
    }
    

    // Método para encontrar usuário por ID
    public static function find($id) {
        $repo = new UserRepository();
        $user = $repo->find($id);
        header('Content-Type: application/json');

        if($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Usuário não encontrado']);
        }

    }
    
    // Método para criar novo usuário
    public static function create() {

        $data = json_decode((file_get_contents(('php://input'))), true);

        if(!isset($data['name']) || empty($data['name'])) {
            http_response_code(400);
            echo json_encode(['error' => "Nome é obrigatório"]);
            return;
        }

        $repo = new UserRepository();
        $id = $repo->create($data);

        header('Content-Type: application/json');

        echo json_encode(['message' => 'Usuário criado com sucesso!', 'id' => $id]);
    }

    // Método para atualizar informações do usuário
    public static function update($id) {
        $data = json_decode((file_get_contents(('php://input'))), true);
        $repo = new UserRepository();
        $success = $repo->update($id, $data);
        header('Content-Type: application/json');

        if($success) {
            echo json_encode(['message' => "Usuário com ID $id atualizado com sucesso"]);
        } else {
            http_response_code(404);
            echo json_encode(['message' => "Algo deu errado, verifique as informações"]);
        }
    }

    // Método para remover usuário
    public static function delete($id) {
        $repo = new UserRepository;
        $success = $repo->delete($id);
        header('Content-Type: application/json');

        if($success) {
            echo json_encode(['message' => "Usuário com ID $id deletado com sucesso"]);
        } else {
            http_response_code(404);
            echo json_encode(['message' => "Usuário não encontrado"]);
        }
    }
}