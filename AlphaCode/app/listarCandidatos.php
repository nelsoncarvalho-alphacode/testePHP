<?php
// Conexão com o banco de dados
require_once 'conexao.php';

// Definir a quantidade de itens por página
$itens_por_pagina = 20;

// Determinar a página atual
$pagina_atual = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($pagina_atual - 1) * $itens_por_pagina;

// Consulta para listar os candidatos com filtro e ordenação
$query = "SELECT * FROM candidatos";

// Aplicar filtro de pesquisa, se houver
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $query .= " WHERE nome LIKE '%$search%' OR email LIKE '%$search%' OR telefone LIKE '%$search%'";
}

// Aplicar ordenação, se especificado
if (isset($_GET['order_by'])) {
    $order_by = $_GET['order_by'];
    $query .= " ORDER BY $order_by";
}

// Aplicar paginação
$query .= " LIMIT $itens_por_pagina OFFSET $offset";

// Executar consulta
$stmt = $pdo->query($query);
$candidatos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retornar os dados em formato JSON
header('Content-Type: application/json');
echo json_encode($candidatos);
?>
