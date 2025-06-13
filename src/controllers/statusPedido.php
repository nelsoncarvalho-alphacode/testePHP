<?php
    require '../classes/Database.php';
    require '../classes/Pedido.php';

    $id     = $_POST['id'];
    $status = addslashes($_POST['status']);

    $db = new Database();
    $conn = $db->getConnection();

    $pedido = new Pedido($conn);
    $pedido->setId($id);
    $pedido->read();
    $pedido->setStatus($status);
    $pedido->update();

    echo json_encode(['message' => 'Atualizado status com sucesso', 'status' => '200']);