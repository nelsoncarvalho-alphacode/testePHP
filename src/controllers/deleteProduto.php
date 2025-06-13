<?php
    require '../classes/Database.php';
    require '../classes/Produto.php';

    $db = new Database();
    $conn = $db->getConnection();
    
    $id = $_POST['id'];
    $produto = new Produto($conn);
    if(!empty($id)){
        $produto->setId($id);
        $produto->delete();
        exit();
    } else{
        echo json_encode(['message' => 'Produto não encontrado!', 'status' => '500']);
        exit();
    }