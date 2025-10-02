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
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $value = $_POST['value'] ?? '';
        $img = (isset($_FILES['productImage']) && !empty($_FILES['productImage']['tmp_name'])) ? file_get_contents($_FILES['productImage']['tmp_name']) : null;

        if (empty($name)) {
            http_response_code(400);
            echo json_encode(['error' => "Nome é obrigatório"]);
            return;
        }
        if ($value === '') {
            http_response_code(400);
            echo json_encode(['error' => "Valor é obrigatório"]);
            return;
        }

        $repo = new ProductRepository();
        $id = $repo->create(['name' => $name, 'img' => $img, 'value' => $value, 'description' => $description]);

        header('Content-Type: application/json');
        echo json_encode(['message' => 'Produto criado com sucesso!', 'id' => $id]);
    }

    // Método para atualizar informações do produto
    public static function update($id)
    {
        // Suporte a PUT multipart/form-data
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            // Parse multipart/form-data manualmente
            // Usar php://input para pegar o corpo cru
            $rawData = file_get_contents('php://input');
            // Usar uma biblioteca para parsear multipart, ou aceitar apenas JSON para PUT
            // Aqui, exemplo para JSON:
            $data = json_decode($rawData, true);
            // Se vier como FormData, não há suporte nativo, então recomendável usar POST para arquivos
            // Para PUT, só atualize campos textuais
            $name = $data['name'] ?? '';
            $description = $data['description'] ?? '';
            $img = null; // Não há suporte para arquivos via PUT nativo
            $repo = new ProductRepository();
            $success = $repo->update($id, ['name' => $name, 'description' => $description, 'img' => $img]);
            header('Content-Type: application/json');
            if ($success) {
                echo json_encode(['message' => "Produto com ID $id atualizado com sucesso"]);
            } else {
                http_response_code(404);
                echo json_encode(['message' => "Algo deu errado, verifique as informações"]);
            }
        } else {
            // Fallback para POST (com arquivos)
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $img = (isset($_FILES['productImage']) && !empty($_FILES['productImage']['tmp_name'])) ? file_get_contents($_FILES['productImage']['tmp_name']) : null;
            $repo = new ProductRepository();
            // Se não enviou imagem, busca a atual
            if ($img === null) {
                $produtoAtual = $repo->find($id);
                $img = $produtoAtual['img'] ?? null;
            }
            $success = $repo->update($id, ['name' => $name, 'description' => $description, 'img' => $img]);
            header('Content-Type: application/json');
            if ($success) {
                echo json_encode(['message' => "Produto $id atualizado com sucesso"]);
            } else {
                http_response_code(404);
                echo json_encode(['message' => "Algo deu errado, verifique as informações"]);
            }
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
