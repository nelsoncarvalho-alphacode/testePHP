<?php
// View de cadastro de usuário por administrador - formulário com opção admin
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Criar Usuário (Admin)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container-fluid px-3 py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Cadastro de Usuário (Admin)</h4>
                    </div>
                    <div class="card-body">
                        <a href="/clientes" class="btn btn-secondary btn-sm mb-3">Voltar para Usuários</a>
                        <form id="userFormAdmin">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="cpf" class="form-label">CPF:</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" placeholder="000.000.000-00">
                            </div>
                            <div class="mb-3">
                                <label for="endereco" class="form-label">Endereço:</label>
                                <textarea class="form-control" id="endereco" name="endereco" rows="3" placeholder="Rua, número, bairro, cidade"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Senha:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_admin" name="is_admin">
                                    <label class="form-check-label" for="is_admin">Administrador</label>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3 mt-2">
                                <button type="submit" class="btn btn-success">Criar Usuário</button>
                            </div>
                        </form>
                        <div id="result" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('userFormAdmin').addEventListener('submit', function(e) {
            e.preventDefault();
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const cpf = document.getElementById('cpf').value;
            const endereco = document.getElementById('endereco').value;
            const password = document.getElementById('password').value;
            const is_admin = document.getElementById('is_admin').checked ? 1 : 0;
            fetch('/api/users', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        name,
                        email,
                        cpf,
                        endereco,
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
                            window.location.href = '/clientes';
                        }, 1500);
                    }
                });
        });
    </script>
</body>

</html>