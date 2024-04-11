# Teste de PHP 2

Este documento contém as instruções e informações necessárias para executar o teste PHP 2 do testePHP.

## Pré-requisitos

Certifique-se de ter o Docker instalado em sua máquina. Você pode baixá-lo em [https://www.docker.com/get-started](https://www.docker.com/get-started).


## Clonando o Repositório

Para começar, clone o repositório do testePHP:

git clone https://github.com/lauradamascenno/testePHP.git

e navegue até o diretório do projeto:

cd teste-php-2


## Configurando o Ambiente

Inicie os contêineres Docker para o ambiente de desenvolvimento:

docker-compose up -d

e acesse o ambiente PHP:

docker-compose exec php bash


## Conexão com o Banco de Dados

Para se conectar ao banco de dados MySQL usando Docker, siga os passos abaixo:

1. Iniciar os contêineres Docker
Certifique-se de que os contêineres do MySQL e PHP/Apache estão em execução. Se ainda não estiverem, você pode iniciar os contêineres usando os seguintes comandos:

# Iniciar o contêiner MySQL
docker run -d --name alphacode-mysql-1 -p 3306:3306 -e MYSQL_ROOT_PASSWORD=TestPassword -e MYSQL_DATABASE=bdVagas mysql:5.7

# Iniciar o contêiner PHP/Apache
docker run -d --name alphacode-php-1 -p 8000:80 --link alphacode-mysql-1:mysql -v \\wsl.localhost\Ubuntu\home\lauradamascenno\testePHP\AlphaCode:/var/www/html php:7.4-apache

Essas são as credenciais:

Host: alphacode-mysql-1
Porta: 3306
Usuário: root
Senha: TestPassword
Banco de Dados: bdVagas


## Estrutura e Execução dos Scripts

1. Acesse o ambiente PHP:
docker-compose exec php bash

2. Navegue até o diretório src/:
cd /var/www/html/src

3. Execute o script desejado:
php index.html
Para assegurar a eficiência da aplicação, colocarei todos os scripts abaixo.


Alphacode/
├── app/
│   ├── conexao.php
│   ├── criarCandidatos.php
│   ├── criarVagas.php
│   ├── editarCandidatos.php
│   ├── editarVaga.php
│   ├── excluirCandidatos.php
│   ├── excluirVaga.php
│   ├── inscricao.php
│   ├── listarCandidatos.php
│   ├── listarVagas.php
│   └── pagVagas.php
├── database/
│   └── createDatabase.sql
├── public/
│   ├── candidatos.html
│   ├── criarCandidatos.html
│   ├── criarVagas.html
│   ├── editarCandidatos.html
│   ├── editarCandidatos.js
│   ├── editarVaga.html
│   ├── editarVaga.js
│   ├── excluirCandidatos.html
│   ├── excluirCandidatos.js
│   ├── excluirVaga.html
│   ├── excluirVaga.js
│   ├── index.js
│   ├── inscricao.html
│   ├── inscricao.js
│   ├── listarCandidatos.html
│   ├── listarCandidatos.js
│   ├── listarVagas.html
│   ├── listarVagas.js
│   ├── styles.css
│   ├── userADM.html
│   ├── userCandidato.html
│   └── vagas.html
├── docker-composer.yml
├── Dockerfile
└── index.html (página inicial do projeto)

# conexao.php
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

# criarCandidatos.php
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

# criarVagas.php
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

# editarCandidatos.php
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

# editarVaga.php
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

# excluirCandidatos.php
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

# excluirVaga.php
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

# incricao.php
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

# listarCandidatos.php
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

# listarVagas.php
<?php
// Conexão com o banco de dados
require_once 'conexao.php';

// Definir a quantidade de itens por página
$itens_por_pagina = 20;

// Determinar a página atual
$pagina_atual = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($pagina_atual - 1) * $itens_por_pagina;

// Consulta para listar as vagas com filtro e ordenação
$query = "SELECT * FROM vagas";

// Aplicar filtro de pesquisa, se houver
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $query .= " WHERE titulo LIKE '%$search%'";
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
$vagas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retornar os dados em formato JSON
header('Content-Type: application/json');
echo json_encode($vagas);
?>

# pagVagas.php
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

# createDatabase.sql
CREATE DATABASE bdVagas;
USE bdVagas;

CREATE TABLE vagas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    tipo VARCHAR(20) NOT NULL,
    status ENUM('ativo', 'pausado') DEFAULT 'ativo'
);

CREATE TABLE candidatos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telefone VARCHAR(20)    
);

CREATE TABLE inscricoes (
    candidato_id INT,
    vaga_id INT,
    FOREIGN KEY (candidato_id) REFERENCES candidatos(id),
    FOREIGN KEY (vaga_id) REFERENCES vagas(id),
    PRIMARY KEY (candidato_id, vaga_id)
);

# candidatos.html
<!--  
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Candidatos</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="page-title">
        <h1>Candidatos</h1>
    </div>
    <ul>
        <li><a href="listarCandidatos.html">Listar Candidatos</a></li>
    </ul>
    <ul>
        <li><a href="criarCandidatos.html">Criar Candidato</a></li>
    </ul>
    <ul>
        <li><a href="editarCandidatos.html">Editar Candidato</a></li>
    </ul>
    <ul>
        <li><a href="excluirCandidatos.html">Excluir Candidato</a></li>
    </ul>

</body>

</html>
-->

# criarCandidatos.html
<!-- 
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar Candidato</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="page-title">
        <h1>Cadastrar Candidato</h1>
    </div>

    <form action="../app/criarCandidatos.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone"><br>

        <input type="submit" value="Cadastrar">
    </form>
</body>

</html>
-->

# criarVagas.html
<!-- 
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Criar Vaga</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="page-title">
        <h1>Criar Vaga</h1>
    </div>

    <form action="../app/CriarVagas.php" method="POST">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required><br>

        <label for="tipo">Tipo:</label>
        <select id="tipo" name="tipo">
            <option value="CLT">CLT</option>
            <option value="Pessoa Jurídica">Pessoa Jurídica</option>
            <option value="Freelancer">Freelancer</option>
        </select><br>

        <label>Status:</label><br>
        <input type="checkbox" id="status" name="status" value="ativo" checked> Ativo<br>

        <input type="submit" value="Criar Vaga">
    </form>
</body>

</html>
-->

# editarVagas.html
<!-- 
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Editar Candidatos</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="page-title">
        <h1>Editar Candidatos</h1>
    </div>

    <!-- Campo de pesquisa e ordenação -->
    <!-- <form id="searchForm"> 
        <label for="search">Pesquisar:</label>
        <input type="text" id="search" name="search">
        <label for="order_by">Ordenar por:</label>
        <select id="order_by" name="order_by">
            <option value="id">ID</option>
            <option value="nome">Nome</option>
            <option value="email">Email</option>
            <option value="telefone">Telefone</option>
        </select>
        <input type="submit" value="Filtrar">
    </form>

    <!-- Tabela de Candidatos -->
    <table id="candidatosTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody id="candidatosBody"></tbody>
    </table>

    <!-- Paginação -->
    <div class="pagination" id="pagination"></div>

    <!-- Formulário de Edição de Candidato -->
    <h2>Editar Candidato</h2>
    <form id="formEditarCandidato">
        <input type="hidden" id="edit_id" name="id">
        <label for="edit_nome">Nome:</label>
        <input type="text" id="edit_nome" name="nome" required><br>
        <label for="edit_email">Email:</label>
        <input type="email" id="edit_email" name="email" required><br>
        <label for="edit_telefone">Telefone:</label>
        <input type="text" id="edit_telefone" name="telefone" required><br>
        <input type="submit" value="Salvar">
    </form>

    <script src="editarCandidatos.js"></script>
<!-- </body>
 
</html>
-->

# editarCandidatos.js
document.addEventListener('DOMContentLoaded', function () {
    // Função para buscar e exibir os candidatos
    function listarCandidatos() {
        var searchInput = document.getElementById('search').value;
        var orderByInput = document.getElementById('order_by').value;

        // Fazer requisição AJAX para buscar os candidatos com parâmetros de filtragem
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../app/listarCandidatos.php?search=' + searchInput + '&order_by=' + orderByInput, true);
        xhr.onload = function () {
            if (xhr.status == 200) {
                var candidatosData = JSON.parse(xhr.responseText);

                // Limpar a tabela
                var tableBody = document.getElementById('candidatosBody');
                tableBody.innerHTML = '';

                // Preencher a tabela com os dados dos candidatos e botão de edição
                candidatosData.forEach(function (candidato) {
                    var row = document.createElement('tr');
                    row.innerHTML = '<td>' + candidato.id + '</td>' +
                        '<td>' + candidato.nome + '</td>' +
                        '<td>' + candidato.email + '</td>' +
                        '<td>' + candidato.telefone + '</td>' +
                        '<td><button onclick="preencherCamposEdicao(' + candidato.id + ', \'' + candidato.nome + '\', \'' + candidato.email + '\', \'' + candidato.telefone + '\')">Editar</button></td>';
                    tableBody.appendChild(row);
                });
            } else {
                console.error('Erro na requisição AJAX');
            }
        };
        xhr.send();
    }

    // Evento de envio do formulário de edição
    document.getElementById('formEditarCandidato').addEventListener('submit', function (event) {
        event.preventDefault(); // Evitar o comportamento padrão de envio do formulário
        var formData = new FormData(this);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../app/editarCandidatos.php', true);
        xhr.onload = function () {
            if (xhr.status == 200) {
                alert('Candidato editado com sucesso!');
                listarCandidatos(); // Atualizar a lista após a edição
            } else {
                console.error('Erro na requisição AJAX');
            }
        };
        xhr.send(formData);
    });

    // Chamar a função para listar os candidatos ao carregar a página
    listarCandidatos();
});

// Função para preencher os campos de edição com os dados do candidato selecionado
function preencherCamposEdicao(id, nome, email, telefone) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_nome').value = nome;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_telefone').value = telefone;
}

# editarVaga.html
<!--
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Editar Candidatos</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="page-title">
        <h1>Editar Candidatos</h1>
    </div>

    <!-- Campo de pesquisa e ordenação -->
    <form id="searchForm">
        <label for="search">Pesquisar:</label>
        <input type="text" id="search" name="search">
        <label for="order_by">Ordenar por:</label>
        <select id="order_by" name="order_by">
            <option value="id">ID</option>
            <option value="nome">Nome</option>
            <option value="email">Email</option>
            <option value="telefone">Telefone</option>
        </select>
        <input type="submit" value="Filtrar">
    </form>

    <!-- Tabela de Candidatos -->
    <table id="candidatosTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody id="candidatosBody"></tbody>
    </table>

    <!-- Paginação -->
    <div class="pagination" id="pagination"></div>

    <!-- Formulário de Edição de Candidato -->
    <h2>Editar Candidato</h2>
    <form id="formEditarCandidato">
        <input type="hidden" id="edit_id" name="id">
        <label for="edit_nome">Nome:</label>
        <input type="text" id="edit_nome" name="nome" required><br>
        <label for="edit_email">Email:</label>
        <input type="email" id="edit_email" name="email" required><br>
        <label for="edit_telefone">Telefone:</label>
        <input type="text" id="edit_telefone" name="telefone" required><br>
        <input type="submit" value="Salvar">
    </form>

    <script src="editarCandidatos.js"></script>
<!--</body>

</html>-->

# editarVaga.js
document.addEventListener('DOMContentLoaded', function () {
    // Função para buscar e exibir as vagas
    function listarVagas() {
        var searchInput = document.getElementById('search').value;
        var orderByInput = document.getElementById('order_by').value;

        // Fazer requisição AJAX para buscar as vagas com parâmetros de filtragem
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../app/listarVagas.php?search=' + searchInput + '&order_by=' + orderByInput, true);
        xhr.onload = function () {
            if (xhr.status == 200) {
                var vagasData = JSON.parse(xhr.responseText);

                // Limpar a tabela
                var tableBody = document.getElementById('vagasBody');
                tableBody.innerHTML = '';

                // Preencher a tabela com os dados das vagas e botão de edição
                vagasData.forEach(function (vaga) {
                    var row = document.createElement('tr');
                    row.innerHTML = '<td>' + vaga.id + '</td>' +
                        '<td>' + vaga.titulo + '</td>' +
                        '<td>' + vaga.tipo + '</td>' +
                        '<td>' + vaga.status + '</td>' +
                        '<td><button onclick="preencherCamposEdicao(' + vaga.id + ', \'' + vaga.titulo + '\', \'' + vaga.tipo + '\', \'' + vaga.status + '\')">Editar</button></td>';
                    tableBody.appendChild(row);
                });
            } else {
                console.error('Erro na requisição AJAX');
            }
        };
        xhr.send();
    }

    // Evento de envio do formulário de edição
    document.getElementById('formEditarVaga').addEventListener('submit', function (event) {
        event.preventDefault(); // Evitar o comportamento padrão de envio do formulário
        var formData = new FormData(this);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../app/editarVaga.php', true);
        xhr.onload = function () {
            if (xhr.status == 200) {
                alert('Vaga editada com sucesso!');
                listarVagas(); // Atualizar a lista após a edição
            } else {
                console.error('Erro na requisição AJAX');
            }
        };
        xhr.send(formData);
    });

    // Chamar a função para listar as vagas ao carregar a página
    listarVagas();
});

// Função para preencher os campos de edição com os dados da vaga selecionada
function preencherCamposEdicao(id, titulo, tipo, status) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_titulo').value = titulo;
    document.getElementById('edit_tipo').value = tipo;
    document.getElementById('edit_status').value = status;
}

# excluirCandidatos.html
<!-- 
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Excluir Candidato</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="page-title">
        <h1>Excluir Candidato</h1>
    </div>

    <!-- Campo de pesquisa e ordenação -->
    <form id="searchForm">
        <label for="search">Pesquisar:</label>
        <input type="text" id="search" name="search">
        <label for="order_by">Ordenar por:</label>
        <select id="order_by" name="order_by">
            <option value="id">ID</option>
            <option value="nome">Nome</option>
            <option value="email">Email</option>
            <option value="telefone">Telefone</option>
        </select>
        <input type="submit" value="Filtrar">
    </form>

    <!-- Tabela de Candidatos -->
    <table id="candidatosTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody id="candidatosBody"></tbody>
    </table>

    <!-- Paginação -->
    <div class="pagination" id="pagination"></div>

    <script src="excluirCandidatos.js"></script>
<!--</body>

</html>
-->

# excluirCandidatos.js
// Função para buscar e exibir os candidatos
function listarCandidatos() {
    var searchInput = document.getElementById('search').value;
    var orderByInput = document.getElementById('order_by').value;

    // Fazer requisição AJAX para buscar os candidatos com parâmetros de filtragem
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../app/listarCandidatos.php?search=' + searchInput + '&order_by=' + orderByInput, true);
    xhr.onload = function () {
        if (xhr.status == 200) {
            var candidatosData = JSON.parse(xhr.responseText);

            // Limpar a tabela
            var tableBody = document.getElementById('candidatosBody');
            tableBody.innerHTML = '';

            // Preencher a tabela com os dados dos candidatos e botões de exclusão
            candidatosData.forEach(function (candidato) {
                var row = document.createElement('tr');
                row.innerHTML = '<td>' + candidato.id + '</td>' +
                    '<td>' + candidato.nome + '</td>' +
                    '<td>' + candidato.email + '</td>' +
                    '<td>' + candidato.telefone + '</td>' +
                    '<td><button onclick="excluirCandidato(' + candidato.id + ')">Excluir</button></td>';
                tableBody.appendChild(row);
            });
        } else {
            console.error('Erro na requisição AJAX');
        }
    };
    xhr.send();
}

// Função para confirmar a exclusão do candidato
function excluirCandidato(id) {
    var confirmacao = confirm('Tem certeza que deseja excluir o candidato com ID ' + id + '?');
    if (confirmacao) {
        // Fazer requisição AJAX para excluir o candidato
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../app/excluirCandidatos.php?id=' + id, true); // Corrigido para excluirCandidato.php
        xhr.onload = function () {
            if (xhr.status == 200) {
                alert('Candidato excluído com sucesso!');
                listarCandidatos(); // Atualizar a lista após a exclusão
            } else {
                console.error('Erro na requisição AJAX');
            }
        };
        xhr.send();
    }
}

// Evento de envio do formulário
document.getElementById('searchForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Evitar o comportamento padrão de envio do formulário
    listarCandidatos(); // Chamar a função para buscar e exibir os candidatos
});

// Carregar os candidatos ao carregar a página
window.onload = listarCandidatos;

# excluirVaga.html
<!--<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Excluir Vaga</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="page-title">
        <h1>Excluir Vaga</h1>
    </div>

    <!-- Campo de pesquisa e ordenação -->
    <form id="searchForm">
        <label for="search">Pesquisar:</label>
        <input type="text" id="search" name="search">
        <label for="order_by">Ordenar por:</label>
        <select id="order_by" name="order_by">
            <option value="id">ID</option>
            <option value="titulo">Título</option>
            <option value="tipo">Tipo</option>
            <option value="status">Status</option>
        </select>
        <input type="submit" value="Filtrar">
    </form>

    <!-- Tabela de Vagas -->
    <table id="vagasTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Tipo</th>
                <th>Status</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody id="vagasBody"></tbody>
    </table>

    <!-- Paginação -->
    <div class="pagination" id="pagination"></div>

    <script src="excluirVaga.js"></script>
<!--</body>

</html>-->

# excluirVaga.js
// Função para buscar e exibir as vagas
function listarVagas() {
    var searchInput = document.getElementById('search').value;
    var orderByInput = document.getElementById('order_by').value;

    // Fazer requisição AJAX para buscar as vagas com parâmetros de filtragem
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../app/listarVagas.php?search=' + searchInput + '&order_by=' + orderByInput, true);
    xhr.onload = function () {
        if (xhr.status == 200) {
            var vagasData = JSON.parse(xhr.responseText);

            // Limpar a tabela
            var tableBody = document.getElementById('vagasBody');
            tableBody.innerHTML = '';

            // Preencher a tabela com os dados das vagas e botões de exclusão
            vagasData.forEach(function (vaga) {
                var row = document.createElement('tr');
                row.innerHTML = '<td>' + vaga.id + '</td>' +
                    '<td>' + vaga.titulo + '</td>' +
                    '<td>' + vaga.tipo + '</td>' +
                    '<td>' + vaga.status + '</td>' +
                    '<td><button onclick="excluirVaga(' + vaga.id + ')">Excluir</button></td>';
                tableBody.appendChild(row);
            });
        } else {
            console.error('Erro na requisição AJAX');
        }
    };
    xhr.send();
}

// Função para confirmar a exclusão da vaga
function excluirVaga(id) {
    var confirmacao = confirm('Tem certeza que deseja excluir a vaga com ID ' + id + '?');
    if (confirmacao) {
        // Fazer requisição AJAX para excluir a vaga
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../app/excluirVaga.php?id=' + id, true);
        xhr.onload = function () {
            if (xhr.status == 200) {
                alert('Vaga excluída com sucesso!');
                listarVagas(); // Atualizar a lista após a exclusão
            } else {
                console.error('Erro na requisição AJAX');
            }
        };
        xhr.send();
    }
}

// Evento de envio do formulário
document.getElementById('searchForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Evitar o comportamento padrão de envio do formulário
    listarVagas(); // Chamar a função para buscar e exibir as vagas
});

// Carregar as vagas ao carregar a página
window.onload = listarVagas;

# inscricao.html
<!-- 
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Inscrição em Vagas</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="page-title">
        <h1>Inscrição em Vagas</h1>
    </div>

    <!-- Formulário de Inscrição -->
    <form id="formInscricao">
        <label for="email">Seu Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="vaga_id">Selecione a Vaga:</label>
        <select id="vaga_id" name="vaga_id" required>
            <!-- As opções de vaga serão preenchidas dinamicamente via JavaScript -->
        </select><br>

        <input type="submit" value="Inscrever-se">
    </form>

    <script src="inscricao.js"></script>
<!--</body>

</html>
-->

# inscricao.js
document.addEventListener('DOMContentLoaded', function () {
    // Carregar as vagas disponíveis ao carregar a página
    carregarVagas();

    // Evento de envio do formulário de inscrição
    document.getElementById('formInscricao').addEventListener('submit', function (event) {
        event.preventDefault(); // Evitar o comportamento padrão de envio do formulário
        var formData = new FormData(this);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../app/inscricao.php', true);
        xhr.onload = function () {
            if (xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.error) {
                    alert(response.error);
                } else {
                    alert(response.message);
                    // Limpar o formulário após a inscrição
                    document.getElementById('email').value = '';
                    document.getElementById('vaga_id').selectedIndex = 0;
                    // Atualizar a lista de vagas após a inscrição
                    carregarVagas();
                }
            } else {
                console.error('Erro na requisição AJAX');
            }
        };
        xhr.send(formData);
    });
});

// Função para carregar as vagas disponíveis no menu de seleção
function carregarVagas() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../app/listarVagas.php', true);
    xhr.onload = function () {
        if (xhr.status == 200) {
            var vagasData = JSON.parse(xhr.responseText);

            // Limpar as opções existentes no menu de seleção
            var selectVaga = document.getElementById('vaga_id');
            selectVaga.innerHTML = '';

            // Adicionar uma opção padrão
            var optionDefault = document.createElement('option');
            optionDefault.value = '';
            optionDefault.text = 'Selecione uma vaga';
            selectVaga.appendChild(optionDefault);

            // Preencher o menu de seleção com as vagas disponíveis
            vagasData.forEach(function (vaga) {
                var option = document.createElement('option');
                option.value = vaga.id;
                option.text = vaga.titulo;
                selectVaga.appendChild(option);
            });
        } else {
            console.error('Erro na requisição AJAX');
        }
    };
    xhr.send();
}

# listarCandidatos.html
<!-- 
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Listagem de Candidatos</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="page-title">
        <h1>Listagem de Candidatos</h1>
    </div>

    <!-- Campo de pesquisa e ordenação -->
    <form id="searchForm">
        <label for="search">Pesquisar:</label>
        <input type="text" id="search" name="search">
        <label for="order_by">Ordenar por:</label>
        <select id="order_by" name="order_by">
            <option value="id">ID</option>
            <option value="nome">Nome</option>
            <option value="email">Email</option>
            <option value="telefone">Telefone</option>
        </select>
        <input type="submit" value="Filtrar">
    </form>

    <!-- Tabela de Candidatos -->
    <table id="candidatosTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
            </tr>
        </thead>
        <tbody id="candidatosBody">
            <!-- Aqui serão adicionadas as linhas da tabela via JavaScript -->
        </tbody>
    </table>

    <!-- Paginação -->
    <div class="pagination" id="pagination"></div>

    <script src="listarCandidatos.js"></script>
<!-- </body>

</html>
-->

# listarCandidatos.js
document.addEventListener('DOMContentLoaded', function () {
    // Função para buscar e exibir os candidatos
    function listarCandidatos() {
        var searchInput = document.getElementById('search').value;
        var orderByInput = document.getElementById('order_by').value;

        // Fazer requisição AJAX para buscar os candidatos com parâmetros de filtragem
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../app/listarCandidatos.php?search=' + searchInput + '&order_by=' + orderByInput, true);
        xhr.onload = function () {
            if (xhr.status == 200) {
                var candidatosData = JSON.parse(xhr.responseText);

                // Limpar a tabela
                var tableBody = document.getElementById('candidatosBody');
                tableBody.innerHTML = '';

                // Preencher a tabela com os dados dos candidatos
                candidatosData.forEach(function (candidato) {
                    var row = document.createElement('tr');
                    row.innerHTML = '<td>' + candidato.id + '</td>' +
                        '<td>' + candidato.nome + '</td>' +
                        '<td>' + candidato.email + '</td>' +
                        '<td>' + candidato.telefone + '</td>';
                    tableBody.appendChild(row);
                });
            } else {
                console.error('Erro na requisição AJAX');
            }
        };
        xhr.send();
    }

    // Evento de envio do formulário
    document.getElementById('searchForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Evitar o comportamento padrão de envio do formulário
        listarCandidatos(); // Chamar a função para buscar e exibir os candidatos
    });

    // Carregar os candidatos ao carregar a página
    window.onload = listarCandidatos;
});

# listarVagas.html
<!-- 
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Listagem de Vagas</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="page-title">
        <h1>Listagem de Vagas</h1>
    </div>

    <!-- Campo de pesquisa e ordenação -->
    <form id="searchForm">
        <label for="search">Pesquisar:</label>
        <input type="text" id="search" name="search">
        <label for="order_by">Ordenar por:</label>
        <select id="order_by" name="order_by">
            <option value="id">ID</option>
            <option value="titulo">Título</option>
            <option value="tipo">Tipo</option>
            <option value="status">Status</option>
        </select>
        <input type="submit" value="Filtrar">
    </form>

    <!-- Tabela de Vagas -->
    <table id="vagasTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Tipo</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="vagasBody">
            <!-- Aqui serão adicionadas as linhas da tabela via JavaScript -->
        </tbody>
    </table>

    <!-- Paginação -->
    <div class="pagination" id="pagination"></div>

    <!-- Script JavaScript -->
    <script src="listarVagas.js"></script>
<!-- </body>

</html>
-->

# listarVagas.js
// Função para buscar e exibir as vagas
function listarVagas() {
    var searchInput = document.getElementById('search').value;
    var orderByInput = document.getElementById('order_by').value;

    // Fazer requisição AJAX para buscar as vagas com parâmetros de filtragem
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../app/listarVagas.php?search=' + searchInput + '&order_by=' + orderByInput, true);
    xhr.onload = function () {
        if (xhr.status == 200) {
            var vagasData = JSON.parse(xhr.responseText);

            // Limpar a tabela
            var tableBody = document.getElementById('vagasBody');
            tableBody.innerHTML = '';

            // Preencher a tabela com os dados das vagas
            vagasData.forEach(function (vaga) {
                var row = document.createElement('tr');
                row.innerHTML = '<td>' + vaga.id + '</td>' +
                    '<td>' + vaga.titulo + '</td>' +
                    '<td>' + vaga.tipo + '</td>' +
                    '<td>' + vaga.status + '</td>';
                tableBody.appendChild(row);
            });
        } else {
            console.error('Erro na requisição AJAX');
        }
    };
    xhr.send();
}

// Evento de envio do formulário
document.getElementById('searchForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Evitar o comportamento padrão de envio do formulário
    listarVagas(); // Chamar a função para buscar e exibir as vagas
});

// Carregar as vagas ao carregar a página
window.onload = listarVagas;

# styles.css
body {
    font-family: 'Century Gothic', Arial, sans-serif;
    background-color: #f0f0f0;
    color: #333;
    margin: 0;
    padding: 0;
}

.page-title {
    background-color: #005c8b; /* Cor de fundo para o título da página */
    color: #fff; /* Cor do texto do título da página */
    padding: 10px 0; /* Espaçamento interno no título da página */
    text-align: center; /* Centralizar o texto */
    margin-bottom: 20px; /* Adicionar margem abaixo do título */
}

h1 {
    margin: 0;
}

ul {
    list-style-type: none;
    padding: 0;
    text-align: center; /* Centralizar os links */
}

ul li {
    display: inline-block;
    margin-right: 20px;
}

a {
    text-decoration: none;
    color: #333;
    padding: 5px 10px; /* Adicionar um espaçamento interno aos links */
    border: 1px solid #333; /* Adicionar uma borda aos links para destacá-los */
    border-radius: 4px; /* Adicionar cantos arredondados aos links */
    transition: background-color 0.3s ease; /* Adicionar transição suave de cor de fundo */
}

a:hover {
    background-color: #005c8b; /* Alterar a cor de fundo ao passar o mouse */
    color: #fff; /* Alterar a cor do texto ao passar o mouse */
}

/* Estilo específico para a página inicial */
body.index {
    background-color: #fff;
}

/* Estilo específico para a página de usuário ADM */
body.userADM {
    background-color: #fff;
}

/* Estilo específico para a página de usuário Candidato */
body.userCandidato {
    background-color: #fff;
}

# userADM.html
<!-- 
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>ADM</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="page-title">
        <h1>ADM</h1>
    </div>
    <ul>
        <li><a href="vagas.html">Vagas</a></li>
        <li><a href="candidatos.html">Candidatos</a></li>
    </ul>
</body>

</html>
-->

# userCandidato.html
<!-- 
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Candidatos</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="page-title">
        <h1>Candidato Space</h1>
    </div>
    <ul>
        <li><a href="listarVagas.html">Consultar Vagas</a></li>
        <li><a href="criarCandidatos.html">Cadastre-se</a></li>
        <li><a href="inscricao.html">Inscreva-se</a></li>
    </ul>
</body>

</html>
-->

# vagas.html
<!-- 
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Vagas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Vagas</h1>
    <ul>
        <li><a href="listarVagas.html">Listar Vagas</a></li>
    </ul>
    <ul>
        <li><a href="criarVagas.html">Criar Vagas</a></li>
    </ul>
    <ul>
        <li><a href="editarVaga.html">Editar Vagas</a></li>
    </ul>
    <ul>
        <li><a href="excluirVaga.html">Excluir Vagas</a></li>
    </ul>
    
</body>
</html>
-->

# docker-composer.yml
version: '3'
services:
  mysql:
    image: mysql:5.7
    restart: always
    ports:
      - 3306:3306
    environment:
      MYSQL_ROOT_PASSWORD: TestPassword
      MYSQL_DATABASE: bdVagas
      MYSQL_USER: lauradamascenno
      MYSQL_PASSWORD: UserTestPassword
    volumes:
      - ./docker/mysql:/docker-entrypoint-initdb.d

  php:
    image: php:7.4-apache
    restart: always
    ports:
      - 8000:80
    volumes:
      - ./php:/var/www/html
    depends_on:
      - mysql

# Dockerfile
FROM php:7.4-apache

RUN docker-php-ext-install pdo_mysql mysqli

COPY . /var/www/html/

EXPOSE 80

# index.html
<!-- 
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="public/styles.css">
</head>

<body>
    <div class="page-title">
        <h1>Página Inicial</h1>
    </div>
    <ul>
        <li><a href="public/userCandidato.html">Sou candidato</a></li>
        <li><a href="public/userADM.html">Sou ADM</a></li>
    </ul>
</body>

</html>
-->



## Finalização
Ao concluir as modificações e testes, utilize os comandos git para enviar as alterações ao repositório remoto:
git add .
git commit -m "Adicionar novos recursos"
git push origin LauraDamasceno
Isso conclui as instruções para configurar, executar e enviar as modificações no projeto.
