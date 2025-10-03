<?php
// Configurações e inicialização do sistema

// Definir constantes apenas se não estiverem definidas
if (!defined('HOST')) {
    // Detectar se está rodando no Docker
    $isDocker = isset($_ENV['DB_HOST']) || getenv('DB_HOST') !== false;
    
    if ($isDocker) {
        // Configurações para Docker
        define('HOST', $_ENV['DB_HOST'] ?? 'db');
        define('DB_NAME', $_ENV['DB_NAME'] ?? 'ordersapp');
        define('USERNAME', $_ENV['DB_USER'] ?? 'root');
        define('PASSWORD', $_ENV['DB_PASSWORD'] ?? 'rootpassword');
    } else {
        // Configurações para desenvolvimento local (Laragon)
        define('HOST', 'localhost');
        define('DB_NAME', 'ordersapp');
        define('USERNAME', 'root');
        define('PASSWORD', '');
    }
}

// Definir outras constantes apenas se não existirem
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('DIR_APP')) {
    define('DIR_APP', __DIR__ . DS . 'app' . DS);
}

// Carregamento automático de classes apenas se a função não existir
if (!function_exists('autoload')) {
    require_once __DIR__ . DS . 'autoload.php';
}