<?php

use Controllers\OrderController;
use Controllers\UserController;
use Controllers\ProductController;
use Repository\UserRepository;
use Controllers\AuthController;

if ($routes[2] === 'users') {
    if ($method === 'GET') {
        UserController::list();
        exit;
    }

    if ($method === 'PUT' && !empty($routes[3])) {
        UserController::update($routes[3]);
        exit;
    }

    if ($method === 'POST') {
        UserController::create();
        exit;
    }

    if ($method === 'DELETE' && !empty($routes[3])) {
        UserController::delete($routes[3]);
        exit;
    }
}

if ($routes[2] === 'products') {
    if ($method === 'GET') {
        ProductController::list();
        exit;
    }

    if ($method === 'POST' && !empty($routes[3])) {
        ProductController::update($routes[3]);
        exit;
    }

    if ($method === 'POST') {
        ProductController::create();
        exit;
    }

    if ($method === 'DELETE' && !empty($routes[3])) {
        ProductController::delete($routes[3]);
        exit;
    }
}

if ($routes[2] === 'login') {

    if ($method === 'POST') {
        AuthController::login();
        exit;
    }
}

if ($routes[2] === 'logout') {

    if ($method === 'GET') {
        AuthController::logout();
        exit;
    }
}

if ($routes[2] === 'order') {

    if ($method === 'GET') {
        OrderController::list();
        exit;
    }
    if ($method === 'POST') {
        OrderController::store();
        exit;
    }
    if ($method === 'DELETE' && !empty($routes[3])) {
        OrderController::delete($routes[3]);
        exit;
    }
}

if ($routes[2] === 'session') {
    ob_clean();
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