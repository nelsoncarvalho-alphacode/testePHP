<?php

// Definição de rotas da API para operações CRUD via JSON
use Controllers\OrderController;
use Controllers\UserController;
use Controllers\ProductController;
use Controllers\AuthController;

// Rotas para usuários (/api/users)
if ($routes[1] === 'users') {
    if ($method === 'GET') {
        UserController::list();
        exit;
    }

    if ($method === 'PUT' && !empty($routes[2])) {
        UserController::update($routes[2]);
        exit;
    }

    if ($method === 'POST') {
        UserController::create();
        exit;
    }

    if ($method === 'DELETE' && !empty($routes[2])) {
        UserController::delete($routes[2]);
        exit;
    }
}

// Rotas para produtos (/api/products)
if ($routes[1] === 'products') {
    if ($method === 'GET') {
        ProductController::list();
        exit;
    }

    if ($method === 'POST' && empty($routes[2])) {
        ProductController::create();
        exit;
    }

    if ($method === 'POST' && !empty($routes[2])) {
        ProductController::update($routes[2]);
        exit;
    }

    if ($method === 'DELETE' && !empty($routes[2])) {
        ProductController::delete($routes[2]);
        exit;
    }
}

if ($routes[1] === 'login') {

    if ($method === 'POST') {
        AuthController::login();
        exit;
    }
}

if ($routes[1] === 'logout') {

    if ($method === 'GET') {
        AuthController::logout();
        exit;
    }
}

if ($routes[1] === 'order' && !empty($routes[2]) && isset($routes[3]) && $routes[3] === 'status' && $method === 'PUT') {
    OrderController::updateStatus($routes[2]);
    exit;
}


if ($routes[1] === 'order' && !empty($routes[2]) && isset($routes[3]) && $routes[3] === 'cancel' && $method === 'POST') {
    OrderController::cancelOrder($routes[2]);
    exit;
}
if ($routes[1] === 'order') {

    if ($method === 'GET') {
        OrderController::list();
        exit;
    }
    if ($method === 'POST') {
        OrderController::store();
        exit;
    }
    if ($method === 'DELETE' && !empty($routes[2])) {
        OrderController::delete($routes[2]);
        exit;
    }
}

if ($routes[1] === 'session') {
    // Limpa buffer de saída apenas se houver um ativo
    if (ob_get_level()) {
        ob_clean();
    }
    session_start();
    $is_admin = $_SESSION['is_admin'] ?? 0;
    $user_id = $_SESSION['user_id'] ?? null;
    $user_name = $_SESSION['user_name'] ?? null;
    header('Content-Type: application/json');
    echo json_encode([
        'is_admin' => $is_admin,
        'user_id' => $user_id,
        'user_name' => $user_name
    ]);
    die();
}

if ($routes[1] === 'order' && !empty($routes[2]) && isset($routes[3]) && $routes[3] === 'status' && $method === 'PUT') {
    OrderController::updateStatus($routes[2]);
    exit;
}
