<?php

// Controller responsável por gerenciar operações de produtos
namespace Controllers;

use Repository\ProductRepository;

class ProductController
{

    // Lista todos os produtos com imagens convertidas para base64
    public static function list()
    {
        $repo = new ProductRepository();
        $products = $repo->list();
        // Converte imagens para base64 para exibição no frontend
        foreach ($products as &$product) {
            if (!empty($product['img'])) {
                $product['img'] = base64_encode($product['img']);
            }
        }
        header('Content-Type: application/json');
        echo json_encode($products);
    }


    // Busca produto específico por ID
    public static function find($id)
    {
        $repo = new ProductRepository();
        $user = $repo->find($id);
        header('Content-Type: application/json');

        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Produto não encontrado']);
        }
    }

    // Cria novo produto com validação de dados obrigatórios
    public static function create()
    {
        // Limpa todos os buffers de saída
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        // Inicia novo buffer
        ob_start();
        
        try {
            // Captura dados do formulário
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $value = $_POST['value'] ?? '';
            
            // Processa upload de imagem
            $imageFileName = null;
            
            if (isset($_FILES['productImage']) && !empty($_FILES['productImage']['tmp_name'])) {
                // Verifica se houve erro no upload
                if ($_FILES['productImage']['error'] !== UPLOAD_ERR_OK) {
                    ob_end_clean();
                    http_response_code(400);
                    header('Content-Type: application/json');
                    echo json_encode(['error' => 'Erro no upload: código ' . $_FILES['productImage']['error']]);
                    return;
                }
                
                // Valida se o arquivo é uma imagem
                $imageInfo = getimagesize($_FILES['productImage']['tmp_name']);
                if ($imageInfo === false) {
                    ob_end_clean();
                    http_response_code(400);
                    header('Content-Type: application/json');
                    echo json_encode(['error' => 'Arquivo enviado não é uma imagem válida']);
                    return;
                }
                
                // Gera nome único para o arquivo
                $fileExtension = pathinfo($_FILES['productImage']['name'], PATHINFO_EXTENSION);
                $imageFileName = uniqid('product_') . '.' . $fileExtension;
                
                // Define diretório de upload
                $uploadDir = '/var/www/html/storage/uploads/';
                if (!is_dir($uploadDir)) {
                    if (!mkdir($uploadDir, 0777, true)) {
                        ob_end_clean();
                        http_response_code(500);
                        header('Content-Type: application/json');
                        echo json_encode(['error' => 'Erro ao criar diretório de upload']);
                        return;
                    }
                }
                
                // Verifica se diretório é gravável
                if (!is_writable($uploadDir)) {
                    ob_end_clean();
                    http_response_code(500);
                    header('Content-Type: application/json');
                    echo json_encode(['error' => 'Diretório de upload não é gravável']);
                    return;
                }
                
                // Salva arquivo
                $uploadPath = $uploadDir . $imageFileName;
                $fileContent = file_get_contents($_FILES['productImage']['tmp_name']);
                
                if ($fileContent === false) {
                    ob_end_clean();
                    http_response_code(500);
                    header('Content-Type: application/json');
                    echo json_encode(['error' => 'Erro ao ler arquivo temporário']);
                    return;
                }
                
                if (!file_put_contents($uploadPath, $fileContent)) {
                    // Fallback: move_uploaded_file
                    if (!move_uploaded_file($_FILES['productImage']['tmp_name'], $uploadPath)) {
                        $lastError = error_get_last();
                        ob_end_clean();
                        http_response_code(500);
                        header('Content-Type: application/json');
                        echo json_encode(['error' => 'Erro ao salvar arquivo de imagem: ' . ($lastError['message'] ?? 'Erro desconhecido')]);
                        return;
                    }
                }
                
                if (file_exists($uploadPath)) {
                    chmod($uploadPath, 0644);
                } else {
                    ob_end_clean();
                    http_response_code(500);
                    header('Content-Type: application/json');
                    echo json_encode(['error' => 'Arquivo não foi salvo corretamente']);
                    return;
                }
            }

            // Validação de campos obrigatórios
            if (empty($name)) {
                ob_end_clean();
                http_response_code(400);
                header('Content-Type: application/json');
                echo json_encode(['error' => "Nome é obrigatório"]);
                return;
            }
            if ($value === '') {
                ob_end_clean();
                http_response_code(400);
                header('Content-Type: application/json');
                echo json_encode(['error' => "Valor é obrigatório"]);
                return;
            }

            // Salva produto no banco de dados
            $repo = new ProductRepository();
            $id = $repo->create(['name' => $name, 'image_file' => $imageFileName, 'value' => $value, 'description' => $description]);

            // Limpa buffer antes de enviar resposta
            ob_end_clean();
            header('Content-Type: application/json');
            if ($id) {
                echo json_encode(['message' => 'Produto criado com sucesso!', 'id' => $id]);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Erro ao criar produto']);
            }
        } catch (\Exception $e) {
            ob_end_clean();
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Erro interno do servidor: ' . $e->getMessage()]);
        }
    }

    // Atualiza produto existente preservando imagem anterior se não enviada nova
    public static function update($id)
    {
        try {
            // Captura dados do formulário
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

            // Gerencia upload de imagem - mantém anterior se não enviada nova
            $img = (isset($_FILES['productImage']) && !empty($_FILES['productImage']['tmp_name']))
                ? file_get_contents($_FILES['productImage']['tmp_name'])
                : $produtoAtual['img'];

            // Validação de campos obrigatórios
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

            // Atualiza produto no banco de dados
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

    // Remove produto do banco de dados
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
