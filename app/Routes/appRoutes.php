<?php

// Rota raiz - redireciona para login
if (empty($routes[0]) || $routes[0] === '') {
    if ($method === 'GET') {
        require __DIR__ . '/../Views/login.php';
        exit;
    }
}

// Rota para servir imagens da pasta uploads
if ($routes[0] === 'storage' && $routes[1] === 'uploads') {
    if ($method === 'GET' && isset($routes[2])) {
        $filename = $routes[2];
        $filepath = __DIR__ . '/../../storage/uploads/' . $filename;
        
        if (file_exists($filepath)) {
            $fileInfo = pathinfo($filepath);
            $extension = strtolower($fileInfo['extension']);
            
            // Define o content-type baseado na extensão
            $contentTypes = [
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'webp' => 'image/webp'
            ];
            
            $contentType = $contentTypes[$extension] ?? 'application/octet-stream';
            
            header('Content-Type: ' . $contentType);
            header('Content-Length: ' . filesize($filepath));
            readfile($filepath);
            exit;
        } else {
            http_response_code(404);
            echo 'Imagem não encontrada';
            exit;
        }
    }
}

// Rota para listagem de clientes
if ($routes[0] === 'clientes') {
    if ($method === 'GET') {
        require __DIR__ . '/../Views/listUsers.php';
        exit;
    }
}

// Rota para cadastro de usuário comum
if ($routes[0] === 'cadastro') {
    if ($method === 'GET') {
        require __DIR__ . '/../Views/registerUser.php';
        exit;
    }
}

// Rota para cadastro por administrador
if ($routes[0] === 'admin-cadastro') {
    if ($method === 'GET') {
        require __DIR__ . '/../Views/registerUserAdmin.php';
        exit;
    }
}

// Rota para edição de usuário por admin
if ($routes[0] === 'editar-informacoes') {
    if ($method === 'GET') {
        require __DIR__ . '/../Views/editUser.php';
        exit;
    }
}

// Rota para edição de perfil do usuário
if ($routes[0] === 'perfil') {
    if ($method === 'GET') {
        require __DIR__ . '/../Views/editProfile.php';
        exit;
    }
}

if ($routes[0] === 'meu-perfil') {

    if ($method === 'GET') {
        require __DIR__ . '/../Views/userProfile.php';
        exit;
    }
}

if ($routes[0] === 'produtos') {

    if ($method === 'GET') {
        require __DIR__ . '/../Views/listProducts.php';
        exit;
    }
}

if ($routes[0] === 'cadastro-produto') {

    if ($method === 'GET') {
        require __DIR__ . '/../Views/registerProduct.php';
        exit;
    }
}

if ($routes[0] === 'editar-produto') {

    if ($method === 'GET') {
        require __DIR__ . '/../Views/editProduct.php';
        exit;
    }
}

if ($routes[0] === 'login') {

    if ($method === 'GET') {
        require __DIR__ . '/../Views/login.php';
        exit;
    }
}

if ($routes[0] === 'carrinho') {

    if ($method === 'GET') {
        require __DIR__ . '/../Views/cart.php';
        exit;
    }
}

if ($routes[0] === 'pedidos') {

    if ($method === 'GET') {
        require __DIR__ . '/../Views/orders.php';
        exit;
    }
}

if ($routes[0] === 'admin') {

    if ($method === 'GET') {
        require __DIR__ . '/../Views/adminPanel.php';
        exit;
    }
}

if ($routes[0] === 'usuario' && !empty($routes[1])) {

    if ($method === 'GET') {
        require __DIR__ . '/../Views/userDetails.php';
        exit;
    }
}
