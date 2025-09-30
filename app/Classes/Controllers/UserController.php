<?php

namespace Controllers;

class UserController
{
    
    // Método para listar usuários
    public static function show()
    {
        $usuarios = [
            ['id' => 1, 'nome' => 'João'],
            ['id' => 2, 'nome' => 'Maria'],
            ['id' => 3, 'nome' => 'Pedro']
        ];

        header('Content-Type: application/json');
        echo json_encode($usuarios);
    }

    
    // Método para criar novo usuário
    public static function create() {

        $data = json_decode((file_get_contents(('php://input'))), true);

        echo json_encode(['message' => 'Usuário criado com sucesso!', 'data' => $data]);
    }

    // Método para atualizar informações do usuário
    public static function update($id) {
        echo json_encode(['message' => "Usuário com ID $id atualizado com sucesso!"]);
    }

    // Método para remover usuário
    public static function delete($id) {
        echo json_encode(['message' => "Usuário com ID $id deletado com sucesso!"]);
    }
}


