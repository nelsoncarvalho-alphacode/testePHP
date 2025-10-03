<?php
// View de autenticação do sistema - formulário de login
require_once __DIR__ . '/../../bootstrap.php';

use Controllers\AuthController;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container-fluid px-3 py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Login</h4>
                    </div>
                    <div class="card-body">
                        <form id="loginForm">
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-success">Entrar</button>
                            <a href="/cadastro" class="btn btn-link">Não tem conta? Cadastre-se</a>
                        </form>
                        <div id="result" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Se já estiver logado, redireciona imediatamente
        fetch('/api/session')
            .then(response => response.json())
            .then(data => {
                if (data && data.user_id) {
                    if (data.is_admin) {
                        window.location.href = '/admin';
                    } else {
                        window.location.href = '/produtos';
                    }
                }
            });
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            fetch('/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
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
                        resultDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                        setTimeout(() => {
                            if (data.is_admin) {
                                window.location.href = '/admin';
                            } else {
                                window.location.href = '/produtos';
                            }
                        }, 1000);
                    }
                })
                .catch(() => {
                    document.getElementById('result').innerHTML = `<div class="alert alert-danger">Erro ao fazer login.</div>`;
                });
        });
    </script>
</body>

</html>