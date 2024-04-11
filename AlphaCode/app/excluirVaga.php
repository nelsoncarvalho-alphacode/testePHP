<?php
// Conexão com o banco de dados
require_once 'conexao.php';

// Verificar se o ID da vaga foi fornecido
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para excluir a vaga
    $query = "DELETE FROM vagas WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);

    // Retornar mensagem de sucesso
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Vaga excluída com sucesso!']);
} else {
    // Retornar mensagem de erro se o ID não foi fornecido
    header('Content-Type: application/json');
    echo json_encode(['error' => 'ID da vaga não especificado']);
}
?>
