<?php
require_once __DIR__ . '/../../bootstrap.php';

use Controllers\ProductController;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Lista de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Produtos</h4>
                        <div id="headerButtons"></div>
                    </div>
                    <div class="card-body">
                        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Buscar produto...">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Valor</th>
                                    <th>Imagem</th>
                                    <th style="width: 270px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody id="productTable"></tbody>
                        </table>
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
            }
            if (!isAdmin) {
                html += '<a href="/carrinho" class="btn btn-info btn-sm me-2">Ir para o Carrinho</a>';
                html += '<a href="/perfil" class="btn btn-secondary btn-sm me-2">Editar Perfil</a>';
                html += '<a href="/meu-perfil" class="btn btn-outline-secondary btn-sm me-2">Ver Perfil</a>';
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
        let allProducts = [];
        let filteredProducts = [];
        let currentPage = 1;
        const itemsPerPage = 20;

        function renderProducts() {
            const tbody = document.getElementById('productTable');
            tbody.innerHTML = '';
            const startIdx = (currentPage - 1) * itemsPerPage;
            const endIdx = startIdx + itemsPerPage;
            const pageProducts = filteredProducts.slice(startIdx, endIdx);
            if (pageProducts.length > 0) {
                pageProducts.forEach(product => {
                    let imgTag = product.img ? `<img src="data:image/jpeg;base64,${product.img}" width="60">` : 'Sem imagem';
                    let desc = product.description || '';
                    if (desc.length > 50) {
                        desc = desc.substring(0, 47) + '...';
                    }
                    tbody.innerHTML += `<tr>
                        <td>${product.id}</td>
                        <td>${product.name}</td>
                        <td>${desc}</td>
                        <td>${product.value ? 'R$ ' + Number(product.value).toFixed(2) : '-'}</td>
                        <td>${imgTag}</td>
                        <td class="d-flex gap-2 justify-content-center">
                            ${isAdmin ? `<button class='btn btn-warning btn-sm flex-fill' style='min-width: 80px;' onclick='editProduct(${product.id})'>Editar</button>
                            <button class='btn btn-danger btn-sm flex-fill' style='min-width: 80px;' onclick='deleteProduct(${product.id})'>Excluir</button>` : `<button class='btn btn-success btn-sm flex-fill' style='min-width: 80px;' onclick='addToCart(${product.id})'>Carrinho</button>`}
                        </td>
                    </tr>`;
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="6">Nenhum produto encontrado.</td></tr>';
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

        listProducts();
    </script>
</body>

</html>