<?php

use Controllers\UserController;
use Controllers\ProductController;
use Repository\UserRepository;

// Rota raiz - redireciona para login
if (empty($routes[0]) || $routes[0] === '') {
    if ($method === 'GET') {
        require __DIR__ . '/../Views/login.php';
        exit;
    }
}

if ($routes[0] === 'clientes') {

    if ($method === 'GET') {
        require __DIR__ . '/../Views/listUsers.php';
        exit;
    }
}

if ($routes[0] === 'cadastro') {

    if ($method === 'GET') {
        require __DIR__ . '/../Views/registerUser.php';
        exit;
    }
}

if ($routes[0] === 'admin-cadastro') {

    if ($method === 'GET') {
        require __DIR__ . '/../Views/registerUserAdmin.php';
        exit;
    }
}

if ($routes[0] === 'editar-informacoes') {

    if ($method === 'GET') {
        require __DIR__ . '/../Views/editUser.php';
        exit;
    }
}

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
