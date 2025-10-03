<?php
// View de edição de usuário - formulário para administradores
require_once __DIR__ . '/../../bootstrap.php';

use Repository\UserRepository;

// Captura ID do usuário da URL
$routes = Util\RoutesUtil::getRoutes();
$id = isset($routes[1]) ? $routes[1] : null;

// Busca dados do usuário para edição
$user = null;
if ($id) {
    $repo = new UserRepository();
    $user = $repo->find($id);
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container-fluid px-3 py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Editar Usuário</h4>
                    </div>
                    <div class="card-body">
                        <a href="/clientes" class="btn btn-secondary btn-sm mb-3">Voltar para Usuários</a>
                        <form id="userForm">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome:</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail:</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="cpf" class="form-label">CPF:</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" value="<?php echo htmlspecialchars($user['cpf'] ?? ''); ?>" placeholder="000.000.000-00">
                            </div>
                            <div class="mb-3">
                                <label for="endereco" class="form-label">Endereço:</label>
                                <textarea class="form-control" id="endereco" name="endereco" rows="3" placeholder="Rua, número, bairro, cidade"><?php echo htmlspecialchars($user['endereco'] ?? ''); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Nova Senha (deixe em branco para manter a atual):</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Digite apenas se quiser alterar">
                            </div>
                            <button type="submit" class="btn btn-success">Editar Usuário</button>
                        </form>
                        <div id="result" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('userForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const cpf = document.getElementById('cpf').value;
            const endereco = document.getElementById('endereco').value;
            const password = document.getElementById('password').value;
            const userId = <?php echo json_encode($id); ?>;
            
            const updateData = {
                name,
                email,
                cpf,
                endereco
            };
            
            // Só inclui password se foi preenchido
            if (password.trim() !== '') {
                updateData.password = password;
            }
            
            fetch(`/api/users/${userId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(updateData)
                })
                .then(response => response.json())
                .then(data => {
                    const resultDiv = document.getElementById('result');
                    if (data.error) {
                        resultDiv.innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
                    } else {
                        resultDiv.innerHTML = `<div class="alert alert-success">${data.message} (ID: ${data.id})</div>`;
                        setTimeout(() => {
                            window.location.href = '/clientes';
                        }, 1000);
                    }
                })
                .catch(() => {
                    document.getElementById('result').innerHTML = `<div class="alert alert-danger">Erro ao criar usuário.</div>`;
                });
        });
    </script>
</body>

</html>