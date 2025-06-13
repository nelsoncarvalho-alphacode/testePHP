<?php
    require_once '../classes/Database.php';
    require_once '../classes/Produto.php';

    $database = new Database();
    $conn = $database->getConnection();

    $produto = new Produto($conn);

    $busca = $_GET['busca'] ?? '';
    $pagina = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
    $limite = isset($_GET['limite']) ? max(1, (int)$_GET['limite']) : 20;

    $total = $produto->contarTotal($busca);
    $totalPaginas = ceil($total / $limite);

    for ($i = 1; $i <= $totalPaginas; $i++) {
        $active = $i == $pagina ? 'btn-primary' : 'btn-outline-primary';
        echo "<button class='btn btn-sm {$active}' onclick='listProdutos({$i})'>{$i}</button> ";
    }