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
                        <div id="result" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let isAdmin = false;
        // Busca se o usuário é admin
        fetch('/app/api/session')
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
                html += '<a href="/app/cadastro-produto" class="btn btn-success btn-sm me-2">Cadastrar Produto</a>';
                html += '<a href="/app/admin" class="btn btn-dark btn-sm me-2">Voltar para Painel Admin</a>';
            }
            html += '<a href="/app/carrinho" class="btn btn-info btn-sm me-2">Ir para o Carrinho</a>';
            html += '<a href="/app/pedidos" class="btn btn-warning btn-sm me-2">Ir para os Pedidos</a>';
            html += '<a href="#" onclick="logout()" class="btn btn-outline-light btn-sm">Logout</a>';
            headerDiv.innerHTML = html;
        }

        function logout() {
            fetch('/app/api/logout')
                .then(() => {
                    window.location.href = '/app/login';
                });
        }
        function listProducts() {
            fetch('http://orders-app.test/app/api/products')
                .then(response => response.json())
                .then(products => {
                    const tbody = document.getElementById('productTable');
                    tbody.innerHTML = '';
                    if (Array.isArray(products) && products.length > 0) {
                        products.forEach(product => {
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
                                <button class='btn btn-danger btn-sm flex-fill' style='min-width: 80px;' onclick='deleteProduct(${product.id})'>Excluir</button>` : ''}
                                <button class='btn btn-success btn-sm flex-fill' style='min-width: 80px;' onclick='addToCart({id: ${product.id}, name: "${product.name}", description: "${product.description}", value: "${product.value}"})'>Carrinho</button>
                            </td>
                        </tr>`;
                        });
                    }
                })
                .catch(() => {
                    document.getElementById('result').innerHTML = `<div class="alert alert-danger">Erro ao listar produtos.</div>`;
                });
        }

        function editProduct(id) {
            window.location.href = `/app/editar-produto/${id}`;
        }

        function deleteProduct(id) {
            if (confirm('Tem certeza que deseja excluir o produto?')) {
                fetch(`http://orders-app.test/app/api/products/${id}`, {
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

            if (!cart.some(item => item.id === product.id)) {
                cart.push(product);
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