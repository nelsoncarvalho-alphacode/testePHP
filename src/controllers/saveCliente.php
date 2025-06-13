<?php
    require '../classes/Database.php';
    require '../classes/Cliente.php';

    $id    = $_POST['id'];
    $nome  = $_POST['nome'];
    $cpf   = $_POST['cpf'];
    $email = $_POST['email'];

    $db = new Database();
    $conn = $db->getConnection();

    $cliente = new Cliente($conn);
    if(empty($id)){
        $cliente->setNome($nome);
        $cliente->setCpf($cpf);
        $cliente->setEmail($email);
        $cliente->create();
        exit();
    }
    $cliente->setId($id);
    $cliente->setNome($nome);
    $cliente->setCpf($cpf);
    $cliente->setEmail($email);
    $cliente->update();