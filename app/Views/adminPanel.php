<?php
// View do painel administrativo - dashboard principal para administradores
require_once __DIR__ . '/../../bootstrap.php';

use Controllers\UserController;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Painel do Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <script>
        fetch('/api/session')
            .then(response => response.json())
            .then(data => {
                if (!data || !data.is_admin) {
                    window.location.href = '/produtos';
                }
            });
    </script>
    <div class="container-fluid px-3 py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0">O que deseja fazer?</h4>
                    </div>
                    <div class="card-body d-flex flex-column gap-3">
                        <a href="/clientes" class="btn btn-outline-primary btn-lg">Listar clientes</a>
                        <a href="/produtos" class="btn btn-outline-success btn-lg">Listar produtos</a>
                        <a href="/pedidos" class="btn btn-outline-warning btn-lg">Listar pedidos</a>
                        <a href="#" onclick="logout()" class="btn btn-outline-danger btn-lg">Fazer logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function logout() {
            fetch('/api/logout')
                .then(() => {
                    window.location.href = '/login';
                });
        }
    </script>
</body>

</html>