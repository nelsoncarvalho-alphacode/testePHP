<?php
// View de cadastro de produto - formulário para administradores
require_once __DIR__ . '/../../bootstrap.php';

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container-fluid px-3 py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Cadastrar Produto</h4>
                    </div>
                    <div class="card-body">
                        <a href="/produtos" class="btn btn-secondary btn-sm mb-3">Voltar para Produtos</a>
                        <form id="productForm" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome do Produto</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Descrição</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="value" class="form-label">Valor (R$)</label>
                                <input type="number" class="form-control" id="value" name="value" min="0" step="0.01" placeholder="0,00" required>
                            </div>
                            <div class="mb-3">
                                <label for="productImage" class="form-label">Imagem do Produto (opcional)</label>
                                <input type="file" class="form-control" id="productImage" name="productImage" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-success">Cadastrar</button>
                        </form>
                        <div id="result" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Redireciona cliente comum para lista de produtos
        fetch('/api/session')
            .then(response => response.json())
            .then(data => {
                if (!data.is_admin) {
                    window.location.href = '/produtos';
                }
            });
        document.getElementById('productForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('name', document.getElementById('name').value);
            formData.append('description', document.getElementById('description').value);
            formData.append('value', document.getElementById('value').value.replace(',', '.'));
            
            const imageInput = document.getElementById('productImage');
            if (imageInput.files[0]) {
                formData.append('productImage', imageInput.files[0]);
            }
            
            fetch('/api/products', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    const resultDiv = document.getElementById('result');
                    if (data.error) {
                        resultDiv.innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
                    } else {
                        resultDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                        setTimeout(() => {
                            window.location.href = '/produtos';
                        }, 1000);
                    }
                })
                .catch((error) => {
                    document.getElementById('result').innerHTML = `<div class="alert alert-danger">Erro ao cadastrar produto.</div>`;
                });
        });
    </script>
</body>

</html>