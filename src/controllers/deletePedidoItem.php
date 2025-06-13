<?php
    require '../classes/Database.php';
    require '../classes/PedidoItem.php';

    $db = new Database();
    $conn = $db->getConnection();
    
    $id = $_POST['id'];
    $pedido_item = new PedidoItem($conn);
    $retornoItem = $pedido_item->delete($id);
        

    if($retornoItem){
        echo json_encode(['message' => 'Item removido do pedido!', 'status' => '200']);
        exit();
    } else{
        echo json_encode(['message' => 'Item não encontrado!', 'status' => '500']);
        exit();
    }