<?php
// Dados de conexão com o banco de dados
$host = 'alphacode-mysql-1'; 
$dbname = 'bdVagas';
$username = 'root';
$password = 'TestPassword';

// Conexão com o banco de dados usando PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>