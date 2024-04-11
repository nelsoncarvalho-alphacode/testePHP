<?php
// Conexão com o banco de dados
require_once 'conexao.php';

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se os dados foram recebidos
    if (isset($_POST['nome'], $_POST['email'], $_POST['telefone'])) {
        // Recebe dados do formulário
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];

        // Insere novo candidato no banco de dados
        $query = "INSERT INTO candidatos (nome, email, telefone) VALUES (:nome, :email, :telefone)";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['nome' => $nome, 'email' => $email, 'telefone' => $telefone]);

        // Mensagem de confirmação
        $message = "Candidato criado com sucesso!";
    } else {
        // Mensagem de erro se dados não foram recebidos
        $message = "Erro ao cadastrar candidato. Por favor, preencha todos os campos.";
    }
} else {
    // Mensagem de erro se o método da requisição não for POST
    $message = "Erro: método de requisição inválido.";
}

// Exibir a mensagem de confirmação ou erro
echo "<script>alert('$message'); window.location.replace('../public/inscricao.html');</script>";
exit();
?>
