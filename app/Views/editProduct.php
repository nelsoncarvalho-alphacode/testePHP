<?php
require_once __DIR__ . '/../bootstrap.php';
use Repository\ProductRepository;

$routes = Util\RoutesUtil::getRoutes();
$id = isset($routes[2]) ? $routes[2] : null;

$product = null;
if ($id) {
    $repo = new ProductRepository();
    $product = $repo->find($id); // Certifique-se que find retorna um usuário pelo ID

    // var_dump($product);
}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Editar Produto</h2>
    <form id="editProductForm" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="productName" class="form-label">Nome do Produto</label>
            <input type="text" class="form-control" id="productName" name="name" value="<?php echo htmlspecialchars($product['name'] ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label for="productDescription" class="form-label">Descrição</label>
            <textarea class="form-control" id="productDescription" name="description" required><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="productValue" class="form-label">Valor (R$)</label>
            <input type="number" class="form-control" id="productValue" name="value" min="0" step="0.01" value="<?php echo htmlspecialchars($product['value'] ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label for="productImage" class="form-label">Imagem do Produto</label>
            <input type="file" class="form-control" id="productImage" name="productImage">
            <img id="previewImg" src="" alt="Preview" class="mt-2" style="max-width: 200px; display:none;">
        </div>
        <button type="submit" class="btn btn-primary">Atualizar Produto</button>
    </form>
    <div id="result" class="mt-3"></div>
</div>
<script>

// Preview da imagem
document.getElementById('productImage').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(evt) {
            document.getElementById('previewImg').src = evt.target.result;
            document.getElementById('previewImg').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

// Enviar atualização via POST
const productId = <?php echo json_encode($id); ?>;
const form = document.getElementById('editProductForm');
if (form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
    fetch(`http://orders-app.test/app/api/products/${productId}`, {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(data => {
            document.getElementById('result').innerHTML = `<pre>${data}</pre>`;
        });
    });
} else {
    alert('Formulário não encontrado!');
}
</script>
</body>
</html>