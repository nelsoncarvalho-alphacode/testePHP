<?php
// Conexão com o banco de dados
require_once 'conexao.php';

// Contar o número total de vagas
$query_count = "SELECT COUNT(*) AS total FROM vagas";
$stmt_count = $pdo->query($query_count);
$total_vagas = $stmt_count->fetch(PDO::FETCH_ASSOC)['total'];

// Calcular o número total de páginas
$total_paginas = ceil($total_vagas / $itens_por_pagina);

// Exibir links para páginas
for ($i = 1; $i <= $total_paginas; $i++) {
    echo "<a href='listarVagas.php?page=$i'>$i</a>";
}
?>
