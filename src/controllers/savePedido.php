<?php
    require '../classes/Database.php';
    require '../classes/Pedido.php';
    require '../classes/PedidoItem.php';

    $id           = $_POST['id'];
    $itens_pedido = json_decode($_POST['itens_pedido'], true);
    $total_pedido = floatval(str_replace(',', '.', $_POST['total_pedido']));;
    $cliente      = $_POST['cliente'];
    $data         = addslashes($_POST['data']);
    $status       = addslashes($_POST['status']);

    $db = new Database();
    $conn = $db->getConnection();

    $pedido = new Pedido($conn);
    $pedido->setClienteId($cliente);
    $pedido->setDtPedido($data);
    $pedido->setStatus($status);
    $pedido->setValorPedido($total_pedido);

    if(!empty($id)){
        $pedido->setId($id);
        $retornopedido = $pedido->update();
    } else{
        $retornopedido = $pedido->create();
    }

    if(!$retornopedido){
        echo json_encode(['message' => 'Erro ao salvar o pedido!', 'status' => '500']);
        exit();
    }

    $pedido_id = $pedido->getId();

    foreach($itens_pedido as $item){
        $pedido_item = new PedidoItem($conn);
        $retornoItem = $pedido_item->create($pedido->getId(), $item['id'], $item['quantidade'], floatval(str_replace(',', '.', $item['valor_unitario'])));
        
        if(!$retornoItem){
            $pedido->delete();
            echo json_encode(['message' => 'Erro ao salvar o item do pedido!', 'status' => '500']);
            exit();
        }
    }

    echo json_encode(['message' => 'Pedido salvo com sucesso!', 'status' => '200']);