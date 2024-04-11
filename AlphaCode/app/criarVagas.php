<?php
// Conexão com o banco de dados
require_once 'conexao.php';

// Recebe dados do formulário
$titulo = $_POST['titulo'];
$tipo = $_POST['tipo'];
$status = isset($_POST['status']) ? 'ativo' : 'inativo'; // Verifica se o checkbox está marcado

// Insere nova vaga no banco de dados
$query = "INSERT INTO vagas (titulo, tipo, status) VALUES (:titulo, :tipo, :status)";
$stmt = $pdo->prepare($query);
$stmt->execute(['titulo' => $titulo, 'tipo' => $tipo, 'status' => $status]);

// Mensagem de confirmação
$message = "Vaga salva com sucesso!";

// Exibir a mensagem de confirmação
echo "<script>alert('$message');</script>";

// Redireciona para a página de listagem de vagas
header('Location: ../public/listarVagas.php');
exit();
?>
