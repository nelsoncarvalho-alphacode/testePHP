<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Cadastrar Produto</h4>
                    </div>
                    <div class="card-body">
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
                                <label for="productImage" class="form-label">Imagem do Produto</label>
                                <input type="file" class="form-control" id="productImage" name="productImage" accept="image/*" required>
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
        fetch('/app/api/session')
            .then(response => response.json())
            .then(data => {
                if (!data.is_admin) {
                    window.location.href = '/app/produtos';
                }
            });
        document.getElementById('productForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData();
            formData.append('name', document.getElementById('name').value);
            formData.append('description', document.getElementById('description').value);
            formData.append('value', document.getElementById('value').value.replace(',', '.'));
            formData.append('productImage', document.getElementById('productImage').files[0]);
            fetch('http://orders-app.test/app/api/products', {
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
                    document.getElementById('productForm').reset();
                }
            })
            .catch(() => {
                document.getElementById('result').innerHTML = `<div class="alert alert-danger">Erro ao cadastrar produto.</div>`;
            });
        });
    </script>
</body>
</html>