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