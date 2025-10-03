<?php

// Arquivo principal da aplicação - gerencia roteamento e entrada
use Util\RoutesUtil;
use Validator\RequestValidator;
use Controllers\UserController;
use Controllers\ProductController;
use Repository\UserRepository;

// Inclui configurações e autoload
include __DIR__ . '/../bootstrap.php';

// Inicializa sistema de rotas
try {
    $RequestValidator = new RequestValidator(RoutesUtil::getRoutes());
} catch (Exception $exception) {
    echo $exception->getMessage();
}

// Captura rotas e método HTTP
$routes = RoutesUtil::getRoutes();
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// Garante array de rotas com 4 elementos para funcionamento da API
if (count($routes) < 4) {
    $routes = array_pad($routes, 4, '');
}

// Direcionamento para rotas de API ou aplicação web
if ($routes[0] === 'api') {
    require __DIR__ . '/../app/Routes/apiRoutes.php';
} else {
    require __DIR__ . '/../app/Routes/appRoutes.php';
}

// Retorna erro 404 para rotas não encontradas
http_response_code(404);
echo json_encode(['error' => 'Rota não encontrada']);
