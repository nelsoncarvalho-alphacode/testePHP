<?php

use Controllers\UserController;
use Controllers\ProductController;
use Repository\UserRepository;

if ($routes[1] === 'clientes') {

    if ($method === 'GET') {
        require __DIR__ . '/../Views/listUsers.php';
        exit;
    }
}

if ($routes[1] === 'cadastro') {

    if ($method === 'GET') {
        require __DIR__ . '/../Views/registerUser.php';
        exit;
    }
}

if ($routes[1] === 'admin-cadastro') {

    if ($method === 'GET') {
        require __DIR__ . '/../Views/registerUserAdmin.php';
        exit;
    }
}

if ($routes[1] === 'editar-informacoes') {

    if ($method === 'GET') {
        require __DIR__ . '/../Views/editUser.php';
        exit;
    }
}

if ($routes[1] === 'produtos') {

    if ($method === 'GET') {
        require __DIR__ . '/../Views/listProducts.php';
        exit;
    }
}

if ($routes[1] === 'cadastro-produto') {

    if ($method === 'GET') {
        require __DIR__ . '/../Views/registerProduct.php';
        exit;
    }
}

if ($routes[1] === 'editar-produto') {

    if ($method === 'GET') {
        require __DIR__ . '/../Views/editProduct.php';
        exit;
    }
}

if ($routes[1] === 'login') {

    if ($method === 'GET') {
        require __DIR__ . '/../Views/login.php';
        exit;
    }
}

if ($routes[1] === 'carrinho') {

    if ($method === 'GET') {
        require __DIR__ . '/../Views/cart.php';
        exit;
    }
}

if ($routes[1] === 'pedidos') {

    if ($method === 'GET') {
        require __DIR__ . '/../Views/orders.php';
        exit;
    }
}

if ($routes[1] === 'admin') {

    if ($method === 'GET') {
        require __DIR__ . '/../Views/adminPanel.php';
        exit;
    }
}