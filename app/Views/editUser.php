<?php
require_once __DIR__ . '/../bootstrap.php';
use Repository\UserRepository;

$routes = Util\RoutesUtil::getRoutes();
$id = isset($routes[2]) ? $routes[2] : null;

$user = null;
if ($id) {
    $repo = new UserRepository();
    $user = $repo->find($id); // Certifique-se que find retorna um usuário pelo ID

    var_dump($user);
}

// var_dump($user);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Editar Usuário</h4>
                    </div>
                    <div class="card-body">
                        <form id="userForm">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome:</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required>
                                <label for="name" class="form-label">E-mail:</label>
                                <input type="text" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
                                <label for="name" class="form-label">Senha:</label>
                                <input type="text" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-success">Criar Usuário</button>
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
            const password = document.getElementById('password').value;
            const userId = <?php echo json_encode($id); ?>;
            const url = userId ? `http://orders-app.test/app/api/users/${userId}` : 'http://orders-app.test/app/api/users';
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    name,
                    email,
                    password
                })
            })
            .then(response => response.json())
            .then(data => {
                const resultDiv = document.getElementById('result');
                if (data.error) {
                    resultDiv.innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
                } else {
                    resultDiv.innerHTML = `<div class="alert alert-success">${data.message} (ID: ${data.id})</div>`;
                    document.getElementById('userForm').reset();
                }
            })
            .catch(() => {
                document.getElementById('result').innerHTML = `<div class="alert alert-danger">Erro ao criar usuário.</div>`;
            });
        });
    </script>
</body>

</html>