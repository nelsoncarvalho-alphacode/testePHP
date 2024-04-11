<?php
// Conexão com o banco de dados
require_once 'conexao.php';

// Verificar se os dados do formulário foram recebidos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar os dados do formulário
    $email = $_POST['email'];
    $vaga_id = $_POST['vaga_id'];

    // Verificar se o email já está cadastrado
    $queryVerificaEmail = "SELECT * FROM candidatos WHERE email = :email";
    $stmtVerificaEmail = $pdo->prepare($queryVerificaEmail);
    $stmtVerificaEmail->execute(['email' => $email]);
    $candidato = $stmtVerificaEmail->fetch(PDO::FETCH_ASSOC);

    if ($candidato) {
        // Candidato já existe, inscrever na vaga
        $candidato_id = $candidato['id'];

        // Verificar se o candidato já está inscrito na vaga
        $queryVerificaInscricao = "SELECT * FROM inscricoes WHERE candidato_id = :candidato_id AND vaga_id = :vaga_id";
        $stmtVerificaInscricao = $pdo->prepare($queryVerificaInscricao);
        $stmtVerificaInscricao->execute(['candidato_id' => $candidato_id, 'vaga_id' => $vaga_id]);
        $inscricaoExistente = $stmtVerificaInscricao->fetch(PDO::FETCH_ASSOC);

        if ($inscricaoExistente) {
            // Retornar mensagem de erro se o candidato já está inscrito na vaga
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Candidato já inscrito nesta vaga']);
        } else {
            // Inscrever o candidato na vaga
            $queryInscrever = "INSERT INTO inscricoes (candidato_id, vaga_id) VALUES (:candidato_id, :vaga_id)";
            $stmtInscrever = $pdo->prepare($queryInscrever);
            $stmtInscrever->execute(['candidato_id' => $candidato_id, 'vaga_id' => $vaga_id]);

            // Retornar mensagem de sucesso
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Inscrição realizada com sucesso']);
        }
    } else {
        // Candidato não existe, retornar mensagem de erro
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Email não cadastrado, favor cadastrar o candidato primeiro']);
    }
} else {
    // Retornar mensagem de erro se os dados do formulário não foram recebidos
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Dados do formulário não recebidos']);
}
?>
