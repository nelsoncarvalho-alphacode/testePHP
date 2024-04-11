<?php
// Conexão com o banco de dados
require_once 'conexao.php';

// Verificar se os dados do formulário foram recebidos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar os dados do formulário
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $tipo = $_POST['tipo'];
    $status = $_POST['status'];

    // Consulta para atualizar a vaga no banco de dados
    $query = "UPDATE vagas SET titulo = :titulo, tipo = :tipo, status = :status WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['titulo' => $titulo, 'tipo' => $tipo, 'status' => $status, 'id' => $id]);

    // Retornar mensagem de sucesso
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Vaga editada com sucesso!']);
} else {
    // Retornar mensagem de erro se os dados do formulário não foram recebidos
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Dados do formulário não recebidos']);
}
?>
