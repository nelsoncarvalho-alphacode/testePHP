<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Pedidos</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Produtos</th>
                                    <th>Total (R$)</th>
                                    <th>Status</th>
                                    <th>Código de Barras</th>
                                </tr>
                            </thead>
                            <tbody id="ordersTable"></tbody>
                        </table>
                        <div id="result" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function listOrders() {
            fetch('http://orders-app.test/app/api/order')
                .then(response => response.json())
                .then(orders => {
                    const tbody = document.getElementById('ordersTable');
                    tbody.innerHTML = '';
                    if (Array.isArray(orders) && orders.length > 0) {
                        orders.forEach(order => {
                            tbody.innerHTML += `<tr>
                                <td>${order.id}</td>
                                <td>-</td>
                                <td>R$ ${Number(order.value).toFixed(2)}</td>
                                <td>${order.status}</td>
                                <td>${order.barcode}</td>
                            </tr>`;
                        });
                    } else {
                        tbody.innerHTML = '<tr><td colspan="5">Nenhum pedido encontrado.</td></tr>';
                    }
                })
                .catch(() => {
                    document.getElementById('result').innerHTML = `<div class="alert alert-danger">Erro ao listar pedidos.</div>`;
                });
        }
        listOrders();
    </script>
</body>
</html>
