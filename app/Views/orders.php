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
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Pedidos</h4>
                            <div id="headerButtons"></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th id="userColumnHeader" style="display:none;">Usuário</th>
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
        function renderHeaderButtons() {
            const headerDiv = document.getElementById('headerButtons');
            let html = '';
            if (isAdmin) {
                html += '<a href="/app/admin" class="btn btn-dark btn-sm me-2">Voltar para Painel Admin</a>';
            } else {
                html += '<a href="/app/produtos" class="btn btn-warning btn-sm me-2">Voltar para Produtos</a>';
            }
            html += '<a href="#" onclick="logout()" class="btn btn-outline-light btn-sm">Logout</a>';
            headerDiv.innerHTML = html;
        }
        let userId = null;
        let isAdmin = false;
        // Busca dados do usuário logado
        fetch('http://orders-app.test/app/api/session')
            .then(response => response.json())
            .then(data => {
                isAdmin = !!data.is_admin;
                userId = data.user_id;
                renderHeaderButtons();
                listOrders();
            })
            .catch(() => {
                renderHeaderButtons();
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
                        // Exibe coluna Usuário apenas para admin
                        document.getElementById('userColumnHeader').style.display = isAdmin ? '' : 'none';
                        if (filteredOrders.length > 0) {
                            filteredOrders.forEach(order => {
                                const produtos = Array.isArray(order.products) && order.products.length > 0
                                    ? order.products.map(p => `${p.name} (${p.qty || 1})`).join(', ')
                                    : '-';
                                tbody.innerHTML += `<tr>
                                    <td>${order.id}</td>
                                    <td style="${isAdmin ? '' : 'display:none;'}">${isAdmin ? (order.user_name || '-') : ''}</td>
                                    <td>${produtos}</td>
                                    <td>R$ ${Number(order.value).toFixed(2)}</td>
                                    <td>
                                        ${isAdmin
                                            ? `<select class='form-select form-select-sm w-auto d-inline' onchange='changeStatus(${order.id}, this.value)'>
                                                <option value="pendente" ${order.status === 'pendente' ? 'selected' : ''}>Pendente</option>
                                                <option value="pago" ${order.status === 'pago' ? 'selected' : ''}>Pago</option>
                                                <option value="enviado" ${order.status === 'enviado' ? 'selected' : ''}>Enviado</option>
                                                <option value="cancelado" ${order.status === 'cancelado' ? 'selected' : ''}>Cancelado</option>
                                            </select>`
                                            : order.status}
                                    </td>
                                    <td>${order.barcode}</td>
                                    <td>
                                        ${isAdmin 
                                            ? `<button class='btn btn-danger btn-sm' onclick='deleteOrder(${order.id})'>Excluir</button>` 
                                            : (order.status !== 'cancelado' ? `<button class='btn btn-danger btn-sm' onclick='cancelOrder(${order.id})'>Cancelar</button>` : '')}
                                    </td>
                                </tr>`;
                            });
                        }
                    }
                })
                .catch(() => {
                    document.getElementById('result').innerHTML = `<div class="alert alert-danger">Erro ao listar pedidos.</div>`;
                });
        }

    function changeStatus(id, status) {
        fetch(`http://orders-app.test/app/api/order/${id}/status`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ status })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message || 'Status atualizado!');
            listOrders();
        })
        .catch(() => {
            alert('Erro ao atualizar status.');
        });
}
// ...existing code...
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

        function cancelOrder(id) {
            if (confirm('Tem certeza que deseja cancelar este pedido?')) {
                fetch(`http://orders-app.test/app/api/order/${id}/cancel`, {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message || 'Pedido cancelado!');
                    listOrders();
                })
                .catch(() => {
                    alert('Erro ao cancelar pedido.');
                });
            }
        }

                function logout() {
            fetch('/app/api/logout')
                .then(() => {
                    window.location.href = '/app/login';
                });
            }


        listOrders();
    </script>
</body>
</html>
