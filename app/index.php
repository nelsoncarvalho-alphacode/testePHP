<?php

use Util\RoutesUtil;
use Validator\RequestValidator;
use Controllers\UserController;

include 'bootstrap.php';

try {
    $RequestValidator = new RequestValidator(RoutesUtil::getRoutes());
} catch (Exception $exception) {
    echo $exception->getMessage();
}

$routes = RoutesUtil::getRoutes();
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';


if ($routes[0] === 'usuarios') {
    if ($method === 'GET') {
        UserController::show();
        exit;
    }

    if ($method === 'POST') {
        UserController::create();
        exit;
    }
    
    if ($method === 'PUT' && !empty($routes[1])) {
        UserController::update($routes[1]);
        exit;
    }

    if($method === "DELETE" && !empty($routes[1])) {
        UserController::delete($routes[1]);
        exit;
    }


// Configura erro 404
http_response_code(404);
echo json_encode(['error' => 'Rota não encontrada']);

}
