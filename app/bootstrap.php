<?php


    // Configurações de exibição de erros

    // ini_set(varname: 'display_errors', newvalue: 1);
    // ini_set(varname: 'display_startup_errors', newvalue: 1);
    // error_reporting(level: E_ERROR);

    // Constantes de conexão com o banco de dados
    define('HOST', 'localhost');
    define('DB_NAME', 'ordersapp');
    define('USERNAME', 'root');
    define('PASSWORD', '');

    // Constantes de diretórios
    define('DS', DIRECTORY_SEPARATOR);
    define('DIR_APP', '\\laragon\\www\\orders-app\\app');

    // Inclui o autoload para carregar as classes automaticamente
    if (file_exists(filename: 'autoload.php')) {
        include 'autoload.php';
    } else {
        // Se não encontrar o autoload, exibe erro e encerra
        echo 'Erro ao incluir bootstrap';
        exit;
    }