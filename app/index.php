<?php

use Util\RoutesUtil;
use Validator\RequestValidator;
use Controllers\UserController;
use Controllers\ProductController;
use Repository\UserRepository;

include 'bootstrap.php';

// echo DIR_APP;

try {
    $RequestValidator = new RequestValidator(RoutesUtil::getRoutes());
} catch (Exception $exception) {
    echo $exception->getMessage();
}

$routes = RoutesUtil::getRoutes();
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($routes[1] === 'api') {
    require __DIR__ . '\Routes\apiRoutes.php';
} else {
    require __DIR__ . '\Routes\appRoutes.php';
}

// Configura erro 404
http_response_code(404);
echo json_encode(['error' => 'Rota não encontrada']);
