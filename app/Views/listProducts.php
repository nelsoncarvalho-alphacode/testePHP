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
                        <a href="/app/cadastro-produto" class="btn btn-success btn-sm">Cadastrar Produto</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Imagem</th>
                                    <th style="width: 160px;">Ações</th>
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
        function listProducts() {
            fetch('http://orders-app.test/app/products')
            .then(response => response.json())
            .then(products => {
                const tbody = document.getElementById('productTable');
                tbody.innerHTML = '';
                if (Array.isArray(products) && products.length > 0) {
                    products.forEach(product => {
                        let imgTag = product.img ? `<img src="data:image/jpeg;base64,${product.img}" width="60">` : 'Sem imagem';
                        tbody.innerHTML += `<tr>
                            <td>${product.id}</td>
                            <td>${product.name}</td>
                            <td>${product.description || ''}</td>
                            <td>${imgTag}</td>
                            <td>
                                <button class="btn btn-warning btn-sm me-2" onclick="editProduct(${product.id})">Editar</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteProduct(${product.id})">Excluir</button>
                            </td>
                        </tr>`;
                    });
                } else {
                    tbody.innerHTML = '<tr><td colspan="5">Nenhum produto encontrado.</td></tr>';
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
                fetch(`/app/produtos/${id}`, { method: 'DELETE' })
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

        listProducts();
    </script>
</body>
</html>