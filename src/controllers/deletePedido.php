<?php
    require '../classes/Database.php';
    require '../classes/Pedido.php';

    $db = new Database();
    $conn = $db->getConnection();
    
    $id = $_POST['id'];
    $pedido = new Pedido($conn);
    if(!empty($id)){
        $pedido->setId($id);
        $pedido->delete();
        exit();
    } else{
        echo json_encode(['message' => 'Produto não encontrado!', 'status' => '500']);
        exit();
    }