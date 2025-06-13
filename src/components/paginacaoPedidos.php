<?php
    require_once '../classes/Database.php';
    require_once '../classes/Pedido.php';

    $database = new Database();
    $conn = $database->getConnection();

    $pedido = new Pedido($conn);

    $busca  = $_GET['busca'] ?? '';
    $data   = $_GET['data'] ?? '';
    $status = $_GET['status'] ?? '';
    $pagina = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
    $limite = isset($_GET['limite']) ? max(1, (int)$_GET['limite']) : 20;

    $total = $pedido->contarTotal($busca, $status, $data);
    $totalPaginas = ceil($total / $limite);

    for ($i = 1; $i <= $totalPaginas; $i++) {
        $active = $i == $pagina ? 'btn-primary' : 'btn-outline-primary';
        echo "<button class='btn btn-sm {$active}' onclick='listPedidos({$i})'>{$i}</button> ";
    }