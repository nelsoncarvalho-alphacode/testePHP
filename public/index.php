<?php

use Util\RoutesUtil;
use Validator\RequestValidator;
use Controllers\UserController;
use Controllers\ProductController;
use Repository\UserRepository;

include __DIR__ . '/../bootstrap.php';

// echo DIR_APP;

try {
    $RequestValidator = new RequestValidator(RoutesUtil::getRoutes());
} catch (Exception $exception) {
    echo $exception->getMessage();
}

$routes = RoutesUtil::getRoutes();
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// Garante que sempre temos pelo menos 4 elementos no array de rotas para API funcionar
if (count($routes) < 4) {
    $routes = array_pad($routes, 4, '');
}

if ($routes[0] === 'api') {
    require __DIR__ . '/../app/Routes/apiRoutes.php';
} else {
    require __DIR__ . '/../app/Routes/appRoutes.php';
}

// Configura erro 404
http_response_code(404);
echo json_encode(['error' => 'Rota não encontrada']);
