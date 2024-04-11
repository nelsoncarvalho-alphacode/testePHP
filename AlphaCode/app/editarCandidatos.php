<?php
// Conexão com o banco de dados
require_once 'conexao.php';

// Verificar se os dados do formulário foram recebidos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar os dados do formulário
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    // Consulta para atualizar o candidato no banco de dados
    $query = "UPDATE candidatos SET nome = :nome, email = :email, telefone = :telefone WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['nome' => $nome, 'email' => $email, 'telefone' => $telefone, 'id' => $id]);

    // Retornar mensagem de sucesso
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Candidato editado com sucesso!']);
} else {
    // Retornar mensagem de erro se os dados do formulário não foram recebidos
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Dados do formulário não recebidos']);
}
?>
