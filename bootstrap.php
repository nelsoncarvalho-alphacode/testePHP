<?php

// Constantes de conexão com o banco de dados
define('HOST', 'localhost');
define('DB_NAME', 'ordersapp');
define('USERNAME', 'root');
define('PASSWORD', '');

// Constantes de diretórios
define('DS', DIRECTORY_SEPARATOR);
define('DIR_APP', __DIR__ . DS . 'app');

// Inclui o autoload para carregar as classes automaticamente
if (file_exists(__DIR__ . '/autoload.php')) {
    include __DIR__ . '/autoload.php';
} else {
    // Se não encontrar o autoload, exibe erro e encerra
    echo 'Erro ao incluir bootstrap';
    exit;
}
