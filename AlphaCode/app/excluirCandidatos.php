<?php
// Conexão com o banco de dados
require_once 'conexao.php';

// Verificar se o ID do candidato foi fornecido
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para excluir o candidato
    $query = "DELETE FROM candidatos WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);

    // Retornar mensagem de sucesso
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Candidato excluído com sucesso!']);
} else {
    // Retornar mensagem de erro se o ID não foi fornecido
    header('Content-Type: application/json');
    echo json_encode(['error' => 'ID do candidato não especificado']);
}
?>
