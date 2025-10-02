<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Criar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Cadastro de Usuário</h4>
                    </div>
                    <div class="card-body">
                        <form id="userForm">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <label for="email" class="form-label">E-mail:</label>
                                <input type="text" class="form-control" id="email" name="email" required>
                                <label for="password" class="form-label">Senha:</label>
                                <input type="text" class="form-control" id="password" name="password" required>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="is_admin" name="is_admin">
                                    <label class="form-check-label" for="is_admin">Administrador</label>
                                </div>
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
            const is_admin = document.getElementById('is_admin').checked ? 1 : 0;
            fetch('http://orders-app.test/app/api/users', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    name,
                    email,
                    password,
                    is_admin
                })
            })
            .then(response => response.json())
            .then(data => {
                const resultDiv = document.getElementById('result');
                if (data.error) {
                    resultDiv.innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
                } else {
                    resultDiv.innerHTML = `<div class="alert alert-success">${data.message} (ID: ${data.id})</div>`;
                    setTimeout(() => {
                        window.location.href = '/app/clientes';
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