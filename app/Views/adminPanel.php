<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0">O que deseja fazer?</h4>
                    </div>
                    <div class="card-body d-flex flex-column gap-3">
                        <a href="/app/clientes" class="btn btn-outline-primary btn-lg">Listar clientes</a>
                        <a href="/app/produtos" class="btn btn-outline-success btn-lg">Listar produtos</a>
                        <a href="/app/pedidos" class="btn btn-outline-warning btn-lg">Listar pedidos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
