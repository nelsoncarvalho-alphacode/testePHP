<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-end mb-3">
            <!-- Removido botão de logout fora do card -->
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Pedidos</h4>
                            <div>
                                <a href="/app/produtos" class="btn btn-warning btn-sm me-2">Voltar para Produtos</a>
                                <a href="#" onclick="logout()" class="btn btn-outline-light btn-sm">Logout</a>
                            </div>
                        </div>
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
                                    <th>Ações</th>
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
        let userId = null;
        let isAdmin = false;
        // Busca dados do usuário logado
        fetch('http://orders-app.test/app/api/session')
            .then(response => response.json())
            .then(data => {
                isAdmin = !!data.is_admin;
                userId = data.user_id;
                listOrders();
            })
            .catch(() => {
                listOrders();
            });

        function listOrders() {
            fetch('http://orders-app.test/app/api/order')
                .then(response => response.json())
                .then(orders => {
                    const tbody = document.getElementById('ordersTable');
                    tbody.innerHTML = '';
                    if (Array.isArray(orders) && orders.length > 0) {
                        // Filtra pedidos do usuário logado
                        const filteredOrders = isAdmin ? orders : orders.filter(order => order.user_id == userId);
                        if (filteredOrders.length > 0) {
                            filteredOrders.forEach(order => {
                                const produtos = Array.isArray(order.products) && order.products.length > 0
                                    ? order.products.map(p => p.name).join(', ')
                                    : '-';
                                tbody.innerHTML += `<tr>
                                    <td>${order.id}</td>
                                    <td>${produtos}</td>
                                    <td>R$ ${Number(order.value).toFixed(2)}</td>
                                    <td>${order.status}</td>
                                    <td>${order.barcode}</td>
                                    <td>${isAdmin ? `<button class='btn btn-danger btn-sm' onclick='deleteOrder(${order.id})'>Excluir</button>` : ''}</td>
                                </tr>`;
                            });
                        } else {
                            tbody.innerHTML = '<tr><td colspan="5">Nenhum pedido encontrado.</td></tr>';
                        }
                    } else {
                        tbody.innerHTML = '<tr><td colspan="5">Nenhum pedido encontrado.</td></tr>';
                    }
                })
                .catch(() => {
                    document.getElementById('result').innerHTML = `<div class="alert alert-danger">Erro ao listar pedidos.</div>`;
                });
        }
        function deleteOrder(id) {
            if (confirm('Tem certeza que deseja excluir este pedido?')) {
                fetch(`http://orders-app.test/app/api/order/${id}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message || 'Pedido excluído!');
                    listOrders();
                })
                .catch(() => {
                    alert('Erro ao excluir pedido.');
                });
            }
        }
        listOrders();
    </script>
</body>
</html>
