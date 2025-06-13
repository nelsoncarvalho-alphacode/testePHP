<?php
    require '../classes/Database.php';
    require '../classes/Produto.php';

    $id             = $_POST['id'];
    $nome           = $_POST['nome'];
    $valor_unitario = $_POST['valor_unitario'];

    $valor_unitario = str_replace(',', '.', $valor_unitario);
    $db = new Database();
    $conn = $db->getConnection();

    $produto = new Produto($conn);
    if(empty($id)){
        $produto->setNome($nome);
        $produto->setValorUnitario($valor_unitario);
        $produto->create();
        exit();
    }
    $produto->setId($id);
    $produto->setNome($nome);
    $produto->setValorUnitario($valor_unitario);
    $produto->update();