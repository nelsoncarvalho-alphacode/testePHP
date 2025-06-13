<?php
    require '../classes/Database.php';
    require '../classes/Produto.php';

    $termo = $_GET['termo'] ?? '';
    $db = new Database();
    $conn = $db->getConnection();
    $produto = new Produto($conn);

    $resultado = $produto->buscarPorNome($termo);
    echo json_encode($resultado);
