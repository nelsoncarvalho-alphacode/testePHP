<?php
// View de listagem de produtos - catálogo com carrinho de compras e gerenciamento
require_once __DIR__ . '/../../bootstrap.php';

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Lista de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container-fluid px-3 px-md-5 mt-3 mt-md-5">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Produtos</h4>
                        <div id="headerButtons"></div>
                    </div>
                    <div class="card-body">
                        <div class="row g-2 mb-3">
                            <div class="col-12 col-md-6 col-lg-7">
                                <input type="text" id="searchInput" class="form-control" placeholder="Buscar produto...">
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
                                        <th style="cursor: pointer; min-width: 60px;" onclick="sortTable('id')">
                                            ID <i id="sort-id" class="fas fa-sort text-muted"></i>
                                        </th>
                                        <th style="cursor: pointer; min-width: 120px;" onclick="sortTable('name')">
                                            Nome <i id="sort-name" class="fas fa-sort text-muted"></i>
                                        </th>
                                        <th style="cursor: pointer; min-width: 150px;" onclick="sortTable('description')" class="d-none d-lg-table-cell">
                                            Descrição <i id="sort-description" class="fas fa-sort text-muted"></i>
                                        </th>
                                        <th style="cursor: pointer; min-width: 100px;" onclick="sortTable('value')">
                                            Valor <i id="sort-value" class="fas fa-sort text-muted"></i>
                                        </th>
                                        <th style="min-width: 80px;" class="d-none d-md-table-cell">Imagem</th>
                                        <th style="min-width: 150px;">Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="productTable"></tbody>
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
        let isAdmin = false;
        let allProducts = [];
        let filteredProducts = [];
        let currentSort = { field: 'id', direction: 'asc' };
        
        // Busca se o usuário é admin
        fetch('/api/session')
            .then(response => response.json())
            .then(data => {
                isAdmin = !!data.is_admin;
                renderHeaderButtons();
                listProducts();
            })
            .catch(() => {
                renderHeaderButtons();
                listProducts();
            });

        function renderHeaderButtons() {
            const headerDiv = document.getElementById('headerButtons');
            let html = '';
            if (isAdmin) {
                html += '<a href="/cadastro-produto" class="btn btn-success btn-sm me-2">Cadastrar Produto</a>';
                html += '<a href="/admin" class="btn btn-dark btn-sm me-2">Voltar para Painel Admin</a>';
                // Mostrar controles de exclusão para admins
                document.getElementById('deleteButtonContainer').style.display = 'block';
                document.getElementById('selectAll').style.display = 'inline';
                // Ajustar layout das colunas - com botão de exclusão
                document.querySelector('#searchInput').parentElement.className = 'col-12 col-md-6 col-lg-7';
                document.querySelector('#itemsPerPage').parentElement.className = 'col-6 col-md-3 col-lg-2';
            } else {
                // Esconder controles de exclusão para usuários comuns
                document.getElementById('deleteButtonContainer').style.display = 'none';
                document.getElementById('selectAll').style.display = 'none';
                // Ajustar layout das colunas - sem botão de exclusão
                document.querySelector('#searchInput').parentElement.className = 'col-12 col-md-8';
                document.querySelector('#itemsPerPage').parentElement.className = 'col-12 col-md-4';
            }
            if (!isAdmin) {
                html += '<a href="/carrinho" class="btn btn-info btn-sm me-2">Ir para o Carrinho</a>';
                html += '<a href="/perfil" class="btn btn-secondary btn-sm me-2">Editar Perfil</a>';
                html += '<a href="/meu-perfil" class="btn btn-primary btn-sm me-2">Ver Perfil</a>';
            }
            if (!isAdmin) {
                html += '<a href="/pedidos" class="btn btn-warning btn-sm me-2">Ir para os Pedidos</a>';
            }
            html += '<a href="#" onclick="logout()" class="btn btn-outline-light btn-sm">Logout</a>';
            headerDiv.innerHTML = html;
        }

        function logout() {
            fetch('/api/logout')
                .then(() => {
                    window.location.href = '/login';
                });
        }
        
        let currentPage = 1;
        let itemsPerPage = 20;

        function renderProducts() {
            const tbody = document.getElementById('productTable');
            tbody.innerHTML = '';
            const startIdx = (currentPage - 1) * itemsPerPage;
            const endIdx = startIdx + itemsPerPage;
            const pageProducts = filteredProducts.slice(startIdx, endIdx);
            if (pageProducts.length > 0) {
                pageProducts.forEach(product => {
                    let imgTag = product.image_file ? `<img src="/storage/uploads/${product.image_file}" width="60" class="border rounded">` : '<span class="text-muted small">Sem imagem</span>';
                    let desc = product.description || '';
                    if (desc.length > 50) {
                        desc = desc.substring(0, 47) + '...';
                    }
                    tbody.innerHTML += `<tr>
                        <td><input type="checkbox" class="product-checkbox" value="${product.id}" onchange="updateDeleteButton()" style="${isAdmin ? '' : 'display: none;'}"></td>
                        <td>${product.id}</td>
                        <td>${product.name}</td>
                        <td class="d-none d-lg-table-cell">${desc}</td>
                        <td>${product.value ? 'R$ ' + Number(product.value).toFixed(2) : '-'}</td>
                        <td class="d-none d-md-table-cell">${imgTag}</td>
                        <td>
                            <div class="d-flex gap-1 flex-wrap justify-content-center">
                                ${isAdmin ? `<button class='btn btn-warning btn-sm' onclick='editProduct(${product.id})'>
                                    <i class="fas fa-edit d-md-none"></i>
                                    <span class="d-none d-md-inline">Editar</span>
                                </button>
                                <button class='btn btn-danger btn-sm' onclick='deleteProduct(${product.id})'>
                                    <i class="fas fa-trash d-md-none"></i>
                                    <span class="d-none d-md-inline">Excluir</span>
                                </button>` : `<button class='btn btn-success btn-sm' onclick='addToCart(${product.id})'>
                                    <i class="fas fa-cart-plus d-md-none"></i>
                                    <span class="d-none d-md-inline">Carrinho</span>
                                </button>`}
                            </div>
                        </td>
                    </tr>`;
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="7" class="text-center">Nenhum produto encontrado.</td></tr>';
            }
            renderPagination();
        }

        function renderPagination() {
            const totalPages = Math.ceil(filteredProducts.length / itemsPerPage);
            const pagination = document.getElementById('pagination');
            pagination.innerHTML = '';
            if (totalPages <= 1) return;
            for (let i = 1; i <= totalPages; i++) {
                pagination.innerHTML += `<li class="page-item${i === currentPage ? ' active' : ''}"><a class="page-link" href="#" onclick="goToPage(${i});return false;">${i}</a></li>`;
            }
        }

        window.goToPage = function(page) {
            currentPage = page;
            renderProducts();
        }

        function filterProducts() {
            const search = document.getElementById('searchInput').value.trim().toLowerCase();
            if (!search) {
                filteredProducts = allProducts.slice();
            } else {
                filteredProducts = allProducts.filter(product => {
                    return Object.values(product).some(val => String(val).toLowerCase().includes(search));
                });
            }
            currentPage = 1;
            renderProducts();
        }

        function listProducts() {
            fetch('/api/products')
                .then(response => response.json())
                .then(products => {
                    window.products = products; // Armazena globalmente
                    allProducts = Array.isArray(products) ? products : [];
                    filterProducts();
                })
                .catch(() => {
                    document.getElementById('result').innerHTML = `<div class="alert alert-danger">Erro ao listar produtos.</div>`;
                });
        }

        document.getElementById('searchInput').addEventListener('input', filterProducts);

        function editProduct(id) {
            window.location.href = `/editar-produto/${id}`;
        }

        function deleteProduct(id) {
            if (confirm('Tem certeza que deseja excluir o produto?')) {
                fetch(`/api/products/${id}`, {
                        method: 'DELETE'
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message || data.error);
                        listProducts();
                    })
                    .catch(() => {
                        alert('Erro ao excluir produto.');
                    });
            }
        }

        function addToCart(product) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            // Busca o produto pelo id
            const productObj = (window.products || []).find(p => p.id === product);
            if (!productObj) {
                alert('Produto não encontrado!');
                return;
            }
            if (!cart.some(item => item.id === productObj.id)) {
                cart.push(productObj);
                localStorage.setItem('cart', JSON.stringify(cart));
                alert('Produto adicionado ao carrinho!');
            } else {
                alert('Produto já está no carrinho!');
            }
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
            
            // Ordena os produtos
            filteredProducts.sort((a, b) => {
                let aVal = a[field];
                let bVal = b[field];
                
                // Conversão para números se for valor ou id
                if (field === 'value' || field === 'id') {
                    aVal = parseFloat(aVal) || 0;
                    bVal = parseFloat(bVal) || 0;
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
            renderProducts();
            renderPagination();
        }

        // Funções para seleção em massa
        function toggleSelectAll() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.product-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
            updateDeleteButton();
        }

        function updateDeleteButton() {
            const checkedBoxes = document.querySelectorAll('.product-checkbox:checked');
            const deleteBtn = document.getElementById('deleteSelectedBtn');
            
            console.log('Checkboxes marcados:', checkedBoxes.length);
            
            deleteBtn.disabled = checkedBoxes.length === 0;
            
            // Atualizar o checkbox "selecionar todos"
            const allCheckboxes = document.querySelectorAll('.product-checkbox');
            const selectAll = document.getElementById('selectAll');
            selectAll.checked = allCheckboxes.length > 0 && checkedBoxes.length === allCheckboxes.length;
            selectAll.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < allCheckboxes.length;
        }

        function deleteSelected() {
            const checkedBoxes = document.querySelectorAll('.product-checkbox:checked');
            const ids = Array.from(checkedBoxes).map(cb => cb.value);
            
            console.log('IDs selecionados para deleção:', ids);
            
            if (ids.length === 0) return;
            
            if (confirm(`Tem certeza que deseja excluir ${ids.length} produto(s) selecionado(s)?`)) {
                Promise.all(ids.map(id => 
                    fetch(`/api/products/${id}`, { method: 'DELETE' })
                        .then(response => {
                            console.log(`Resposta para produto ${id}:`, response.status);
                            return response.json();
                        })
                        .then(data => {
                            console.log(`Dados retornados para produto ${id}:`, data);
                            return data;
                        })
                ))
                .then((results) => {
                    console.log('Todos os resultados:', results);
                    alert('Produtos excluídos com sucesso!');
                    listProducts();
                })
                .catch((error) => {
                    console.error('Erro na deleção em massa:', error);
                    alert('Erro ao excluir alguns produtos.');
                    listProducts();
                });
            }
        }

        // Função para alterar itens por página
        function changeItemsPerPage() {
            itemsPerPage = parseInt(document.getElementById('itemsPerPage').value);
            currentPage = 1;
            renderProducts();
        }

        listProducts();
        document.getElementById('itemsPerPage').addEventListener('change', changeItemsPerPage);
    </script>
</body>

</html>