<?php

namespace Controllers;

use Repository\ProductRepository;

class ProductController
{

    // Método para listar usuários
    public static function list()
    {
        $repo = new ProductRepository();
        $products = $repo->list();
        foreach ($products as &$product) {
            if (!empty($product['img'])) {
                $product['img'] = base64_encode($product['img']);
            }
        }
        header('Content-Type: application/json');
        echo json_encode($products);
    }


    // Método para encontrar produto por ID
    public static function find($id)
    {
        $repo = new ProductRepository();
        $user = $repo->find($id);
        header('Content-Type: application/json');

        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Usuário não encontrado']);
        }
    }

    // Método para criar novo produto
    public static function create()
    {
        try {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $value = $_POST['value'] ?? '';
            $img = (isset($_FILES['productImage']) && !empty($_FILES['productImage']['tmp_name'])) ? file_get_contents($_FILES['productImage']['tmp_name']) : null;

            if (empty($name)) {
                http_response_code(400);
                header('Content-Type: application/json');
                echo json_encode(['error' => "Nome é obrigatório"]);
                return;
            }
            if ($value === '') {
                http_response_code(400);
                header('Content-Type: application/json');
                echo json_encode(['error' => "Valor é obrigatório"]);
                return;
            }

            $repo = new ProductRepository();
            $id = $repo->create(['name' => $name, 'img' => $img, 'value' => $value, 'description' => $description]);

            header('Content-Type: application/json');
            if ($id) {
                echo json_encode(['message' => 'Produto criado com sucesso!', 'id' => $id]);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Erro ao criar produto']);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Erro interno do servidor']);
        }
    }

    // Método para atualizar informações do produto
    public static function update($id)
    {
        try {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $value = $_POST['value'] ?? '';
            
            // Busca o produto atual para manter a imagem se não foi enviada nova
            $repo = new ProductRepository();
            $produtoAtual = $repo->find($id);
            
            if (!$produtoAtual) {
                http_response_code(404);
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Produto não encontrado']);
                return;
            }
            
            // Se foi enviada nova imagem, usa ela; senão mantém a atual
            $img = (isset($_FILES['productImage']) && !empty($_FILES['productImage']['tmp_name'])) 
                ? file_get_contents($_FILES['productImage']['tmp_name']) 
                : $produtoAtual['img'];
            
            if (empty($name)) {
                http_response_code(400);
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Nome é obrigatório']);
                return;
            }
            
            if ($value === '') {
                http_response_code(400);
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Valor é obrigatório']);
                return;
            }
            
            $success = $repo->update($id, ['name' => $name, 'description' => $description, 'img' => $img, 'value' => $value]);
            
            header('Content-Type: application/json');
            if ($success) {
                echo json_encode(['message' => "Produto atualizado com sucesso"]);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Erro ao atualizar produto']);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Erro interno do servidor']);
        }
    }

    // Método para remover produto
    public static function delete($id)
    {
        $repo = new ProductRepository;
        $success = $repo->delete($id);
        header('Content-Type: application/json');

        if ($success) {
            echo json_encode(['message' => "Produto $id deletado com sucesso"]);
        } else {
            http_response_code(404);
            echo json_encode(['message' => "Produto não encontrado"]);
        }
    }
}
