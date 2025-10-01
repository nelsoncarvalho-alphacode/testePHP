<?php

use Controllers\UserController;
use Controllers\ProductController;
use Repository\UserRepository;

if ($routes[2] === 'users') {
    if ($method === 'GET') {
        UserController::list();
        exit;
    }

    if ($method === 'POST') {
        UserController::create();
        exit;
    }

    if ($method === 'PUT' && !empty($routes[2])) {
        UserController::update($routes[1]);
        exit;
    }

    if ($method === 'DELETE' && !empty($routes[2])) {
        UserController::delete($routes[2]);
        exit;
    }
}

if ($routes[2] === 'products') {
    if ($method === 'GET') {
        ProductController::list();
        exit;
    }

    if ($method === 'POST' && !empty($routes[2])) {
        ProductController::update($routes[2]);
        exit;
    }

    if ($method === 'POST') {
        ProductController::create();
        exit;
    }

    if ($method === 'DELETE' && !empty($routes[2])) {
        ProductController::delete($routes[2]);
        exit;
    }
}