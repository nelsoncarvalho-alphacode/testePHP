<?php
    require '../classes/Database.php';
    require '../classes/Cliente.php';

    $db = new Database();
    $conn = $db->getConnection();
    
    $id = $_POST['id'];
    $cliente = new Cliente($conn);
    if(!empty($id)){
        $cliente->setId($id);
        $cliente->delete();
        exit();
    } else{
        echo json_encode(['message' => 'Cliente não encontrado!', 'status' => 500]);
        exit();
    }