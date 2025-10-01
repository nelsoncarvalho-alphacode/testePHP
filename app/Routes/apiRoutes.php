<?php

use Controllers\UserController;
use Controllers\ProductController;
use Repository\UserRepository;

if ($routes[2] === 'users') {
    if ($method === 'GET') {
        UserController::list();
        exit;
    }

    if ($method === 'POST' && !empty($routes[3])) {
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