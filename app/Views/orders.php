<?php
// View de gerenciamento de pedidos - listagem com filtros e controle de status
require_once __DIR__ . '/../../bootstrap.php';

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Lista de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sortable-header {
            cursor: pointer;
            user-select: none;
            position: relative;
        }
        .sortable-header:hover {
            background-color: rgba(255,255,255,0.1);
        }
    </style>
</head>

<body class="bg-light">
    <div class="container-fluid px-3 px-md-5 mt-3 mt-md-5">
        <div class="d-flex justify-content-end mb-3">
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-xl-11">
            <div class="col-12 col-xl-11">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Pedidos</h4>
                            <div id="headerButtons"></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-2 mb-3">
                            <div class="col-12 col-md-6 col-lg-7">
                                <input type="text" id="searchInput" class="form-control" placeholder="Buscar pedido...">
                            </div>
                            <div class="col-6 col-md-3 col-lg-2">
                                <select id="itemsPerPage" class="form-select">
                                    <option value="10">10 por página</option>
                                    <option value="20" selected>20 por página</option>
                                    <option value="50">50 por página</option>
                                    <option value="100">100 por página</option>
                                </select>
                            </div>
                            <div class="col-6 col-md-3" id="deleteButtonContainer" style="display: none;">
                                <button id="deleteSelectedBtn" class="btn btn-danger w-100" onclick="deleteSelected()" disabled>
                                    <i class="fas fa-trash d-none d-sm-inline"></i>
                                    <span class="d-none d-sm-inline">Excluir selecionados</span>
                                    <span class="d-sm-none">Del</span>
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 50px;" id="selectAllHeader">
                                            <input type="checkbox" id="selectAll" onchange="toggleSelectAll()" style="display: none;">
                                        </th>
                                        <th class="sortable-header" onclick="sortTable('id')" style="min-width: 60px;">
                                            ID <i id="sort-id" class="fas fa-sort text-muted"></i>
                                        </th>
                                        <th id="userColumnHeader" class="sortable-header d-none d-md-table-cell" style="display:none; min-width: 120px;" onclick="sortTable('user_name')">
                                            Usuário <i id="sort-user_name" class="fas fa-sort text-muted"></i>
                                        </th>
                                        <th class="sortable-header d-none d-lg-table-cell" onclick="sortTable('products')" style="min-width: 150px;">
                                            Produtos <i id="sort-products" class="fas fa-sort text-muted"></i>
                                        </th>
                                        <th class="sortable-header" onclick="sortTable('value')" style="min-width: 100px;">
                                            Total <i id="sort-value" class="fas fa-sort text-muted"></i>
                                        </th>
                                        <th class="sortable-header d-none d-md-table-cell" onclick="sortTable('status')" style="min-width: 100px;">
                                            Status <i id="sort-status" class="fas fa-sort text-muted"></i>
                                        </th>
                                        <th class="sortable-header d-none d-lg-table-cell" onclick="sortTable('barcode')" style="min-width: 150px;">
                                            Código <i id="sort-barcode" class="fas fa-sort text-muted"></i>
                                        </th>
                                        <th style="min-width: 150px;">Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="ordersTable"></tbody>
                            </table>
                        </div>
                        <nav>
                            <ul class="pagination justify-content-center" id="pagination"></ul>
                        </nav>
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
                html += '<a href="/admin" class="btn btn-dark btn-sm me-2">Voltar para Painel Admin</a>';
                // Mostrar controles de exclusão para admins
                document.getElementById('deleteButtonContainer').style.display = 'block';
                document.getElementById('selectAll').style.display = 'inline';
                // Mostrar coluna de usuário para admins
                document.getElementById('userColumnHeader').style.display = '';
                // Ajustar layout das colunas - com botão de exclusão
                document.querySelector('#searchInput').parentElement.className = 'col-12 col-md-6 col-lg-7';
                document.querySelector('#itemsPerPage').parentElement.className = 'col-6 col-md-3 col-lg-2';
            } else {
                html += '<a href="/produtos" class="btn btn-warning btn-sm me-2">Voltar para Produtos</a>';
                // Esconder controles de exclusão para usuários comuns
                document.getElementById('deleteButtonContainer').style.display = 'none';
                document.getElementById('selectAll').style.display = 'none';
                // Esconder coluna de usuário para usuários comuns
                document.getElementById('userColumnHeader').style.display = 'none';
                // Ajustar layout das colunas - sem botão de exclusão
                document.querySelector('#searchInput').parentElement.className = 'col-12 col-md-8';
                document.querySelector('#itemsPerPage').parentElement.className = 'col-12 col-md-4';
            }
            html += '<a href="#" onclick="logout()" class="btn btn-outline-light btn-sm">Logout</a>';
            headerDiv.innerHTML = html;
        }
        let userId = null;
        let isAdmin = false;
        // Busca dados do usuário logado
        fetch('/api/session')
            .then(response => response.json())
            .then(data => {
                isAdmin = !!data.is_admin;
                userId = data.user_id;
                renderHeaderButtons();
                fetchOrders();
            })
            .catch(() => {
                renderHeaderButtons();
                fetchOrders();
            });

        // Variáveis globais para paginação e filtragem
        let allOrders = [];
        let filteredOrders = [];
        let currentPage = 1;
        let itemsPerPage = 20;
        
        // Variáveis para ordenação
        let currentSort = {
            field: null,
            direction: 'asc'
        };

        function renderOrders() {
            const tbody = document.getElementById('ordersTable');
            tbody.innerHTML = '';
            const startIdx = (currentPage - 1) * itemsPerPage;
            const endIdx = startIdx + itemsPerPage;
            const pageOrders = filteredOrders.slice(startIdx, endIdx);
            if (pageOrders.length > 0) {
                pageOrders.forEach(order => {
                    const produtos = Array.isArray(order.products) && order.products.length > 0 ?
                        order.products.map(p => `${p.name} (${p.qty || 1})`).join(', ') :
                        '-';
                    tbody.innerHTML += `<tr>
                        <td><input type="checkbox" class="order-checkbox" value="${order.id}" onchange="updateDeleteButton()" style="${isAdmin ? '' : 'display: none;'}"></td>
                        <td>${order.id}</td>
                        <td class="d-none d-md-table-cell" style="${isAdmin ? '' : 'display:none;'}">
                            ${isAdmin 
                                ? (order.user_name 
                                    ? `<a href="/usuario/${order.user_id}" class="text-decoration-none">
                                         <i class="fas fa-user me-1"></i>${order.user_name}
                                       </a>` 
                                    : '-') 
                                : ''}
                        </td>
                        <td class="d-none d-lg-table-cell">${produtos}</td>
                        <td>R$ ${Number(order.value).toFixed(2)}</td>
                        <td class="d-none d-md-table-cell">
                            ${isAdmin
                                ? `<select class='form-select form-select-sm w-auto d-inline' onchange='changeStatus(${order.id}, this.value)'>
                                    <option value="Pendente" ${order.status === 'Pendente' ? 'selected' : ''}>Pendente</option>
                                    <option value="Processando" ${order.status === 'Processando' ? 'selected' : ''}>Processando</option>
                                    <option value="Enviado" ${order.status === 'Enviado' ? 'selected' : ''}>Enviado</option>
                                    <option value="Entregue" ${order.status === 'Entregue' ? 'selected' : ''}>Entregue</option>
                                    <option value="Cancelado" ${order.status === 'Cancelado' ? 'selected' : ''}>Cancelado</option>
                                </select>`
                                : order.status}
                        </td>
                        <td class="d-none d-lg-table-cell">${order.barcode}</td>
                        <td>
                            <div class="d-flex gap-1 flex-wrap justify-content-center">
                                ${isAdmin 
                                    ? `<button class='btn btn-danger btn-sm' onclick='deleteOrder(${order.id})'>
                                        <i class="fas fa-trash d-md-none"></i>
                                        <span class="d-none d-md-inline">Excluir</span>
                                       </button>` 
                                    : (!['Cancelado', 'Entregue'].includes(order.status) ? `<button class='btn btn-danger btn-sm' onclick='cancelOrder(${order.id})'>
                                        <i class="fas fa-times d-md-none"></i>
                                        <span class="d-none d-md-inline">Cancelar</span>
                                       </button>` : `<span class="badge bg-secondary">Finalizado</span>`)}
                            </div>
                        </td>
                    </tr>`;
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="8" class="text-center">Nenhum pedido encontrado.</td></tr>';
            }
            renderPagination();
        }

        function renderPagination() {
            const totalPages = Math.ceil(filteredOrders.length / itemsPerPage);
            const pagination = document.getElementById('pagination');
            pagination.innerHTML = '';
            if (totalPages <= 1) return;
            for (let i = 1; i <= totalPages; i++) {
                pagination.innerHTML += `<li class="page-item${i === currentPage ? ' active' : ''}"><a class="page-link" href="#" onclick="goToPage(${i});return false;">${i}</a></li>`;
            }
        }

        window.goToPage = function(page) {
            currentPage = page;
            renderOrders();
        }

        function filterOrders() {
            const search = document.getElementById('searchInput').value.trim().toLowerCase();
            if (!search) {
                filteredOrders = allOrders.slice();
            } else {
                filteredOrders = allOrders.filter(order => {
                    return Object.values(order).some(val => String(val).toLowerCase().includes(search));
                });
            }
            currentPage = 1;
            renderOrders();
        }

        function fetchOrders() {
            fetch('/api/order')
                .then(response => response.json())
                .then(orders => {
                    allOrders = Array.isArray(orders) ? orders : [];
                    // Filtra pedidos do usuário logado
                    allOrders = isAdmin ? allOrders : allOrders.filter(order => order.user_id == userId);
                    // Exibe coluna Usuário apenas para admin
                    document.getElementById('userColumnHeader').style.display = isAdmin ? '' : 'none';
                    filterOrders();
                })
                .catch(() => {
                    document.getElementById('result').innerHTML = `<div class="alert alert-danger">Erro ao listar pedidos.</div>`;
                });
        }

        document.getElementById('searchInput').addEventListener('input', filterOrders);

        // Inicializa a lista ao carregar
        fetchOrders();

        function changeStatus(id, status) {
            fetch(`/api/order/${id}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        status
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro na resposta do servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        alert(data.message || 'Status atualizado com sucesso!');
                        fetchOrders();
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao atualizar status.');
                });
        }

        function deleteOrder(id) {
            if (confirm('Tem certeza que deseja excluir este pedido?')) {
                fetch(`/api/order/${id}`, {
                        method: 'DELETE'
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message || 'Pedido excluído!');
                        fetchOrders();
                    })
                    .catch(() => {
                        alert('Erro ao excluir pedido.');
                    });
            }
        }

        function cancelOrder(id) {
            if (confirm('Tem certeza que deseja cancelar este pedido?')) {
                fetch(`/api/order/${id}/cancel`, {
                        method: 'POST'
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erro na resposta do servidor');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.error) {
                            alert(data.error);
                        } else {
                            alert(data.message || 'Pedido cancelado com sucesso!');
                            fetchOrders();
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        alert('Erro ao cancelar pedido.');
                    });
            }
        }

        function logout() {
            fetch('/api/logout')
                .then(() => {
                    window.location.href = '/login';
                });
        }

        function sortTable(field) {
            // Alterna a direção se o mesmo campo for clicado
            if (currentSort.field === field) {
                currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
            } else {
                currentSort.field = field;
                currentSort.direction = 'asc';
            }
            
            // Remove todos os ícones de ordenação
            document.querySelectorAll('[id^="sort-"]').forEach(icon => {
                icon.className = 'fas fa-sort text-muted';
            });
            
            // Adiciona o ícone correto para o campo atual
            const icon = document.getElementById(`sort-${field}`);
            if (icon) {
                icon.className = `fas fa-sort-${currentSort.direction === 'asc' ? 'up' : 'down'} text-primary`;
            }
            
            // Ordena os pedidos
            filteredOrders.sort((a, b) => {
                let aVal = a[field];
                let bVal = b[field];
                
                // Conversão para números se for id ou value
                if (field === 'id' || field === 'value') {
                    aVal = parseFloat(aVal) || 0;
                    bVal = parseFloat(bVal) || 0;
                } else if (field === 'products') {
                    // Para produtos, ordenar pelo nome do primeiro produto ou número de produtos
                    aVal = Array.isArray(a.products) && a.products.length > 0 
                        ? a.products[0].name || '' 
                        : '';
                    bVal = Array.isArray(b.products) && b.products.length > 0 
                        ? b.products[0].name || '' 
                        : '';
                    aVal = String(aVal).toLowerCase();
                    bVal = String(bVal).toLowerCase();
                } else {
                    // Conversão para string para campos de texto
                    aVal = String(aVal || '').toLowerCase();
                    bVal = String(bVal || '').toLowerCase();
                }
                
                if (currentSort.direction === 'asc') {
                    return aVal > bVal ? 1 : aVal < bVal ? -1 : 0;
                } else {
                    return aVal < bVal ? 1 : aVal > bVal ? -1 : 0;
                }
            });
            
            currentPage = 1; // Volta para a primeira página
            renderOrders();
        }

        // Funções para seleção em massa
        function toggleSelectAll() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.order-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
            updateDeleteButton();
        }

        function updateDeleteButton() {
            const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
            const deleteBtn = document.getElementById('deleteSelectedBtn');
            deleteBtn.disabled = checkedBoxes.length === 0;
            
            // Atualizar o checkbox "selecionar todos"
            const allCheckboxes = document.querySelectorAll('.order-checkbox');
            const selectAll = document.getElementById('selectAll');
            selectAll.checked = allCheckboxes.length > 0 && checkedBoxes.length === allCheckboxes.length;
            selectAll.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < allCheckboxes.length;
        }

        function deleteSelected() {
            const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
            const ids = Array.from(checkedBoxes).map(cb => cb.value);
            
            if (ids.length === 0) return;
            
            if (confirm(`Tem certeza que deseja excluir ${ids.length} pedido(s) selecionado(s)?`)) {
                Promise.all(ids.map(id => 
                    fetch(`/api/order/${id}`, { method: 'DELETE' })
                        .then(response => response.json())
                ))
                .then(() => {
                    alert('Pedidos excluídos com sucesso!');
                    fetchOrders();
                })
                .catch(() => {
                    alert('Erro ao excluir alguns pedidos.');
                    fetchOrders();
                });
            }
        }

        // Função para alterar itens por página
        function changeItemsPerPage() {
            itemsPerPage = parseInt(document.getElementById('itemsPerPage').value);
            currentPage = 1;
            renderOrders();
        }

        fetchOrders();
        document.getElementById('itemsPerPage').addEventListener('change', changeItemsPerPage);
    </script>
</body>

</html>