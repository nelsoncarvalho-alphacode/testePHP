<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Carrinho de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Carrinho de Compras</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Descrição</th>
                                    <th>Valor (R$)</th>
                                    <th>Remover</th>
                                </tr>
                            </thead>
                            <tbody id="cartTable"></tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            <h5>Total: <span id="cartTotal">R$ 0,00</span></h5>
                        </div>
                        <div id="result" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Carrinho no localStorage
        function getCart() {
            return JSON.parse(localStorage.getItem('cart')) || [];
        }
        function setCart(cart) {
            localStorage.setItem('cart', JSON.stringify(cart));
        }
        function removeFromCart(id) {
            let cart = getCart();
            cart = cart.filter(item => item.id !== id);
            setCart(cart);
            renderCart();
        }
        function renderCart() {
            const cart = getCart();
            const tbody = document.getElementById('cartTable');
            const totalSpan = document.getElementById('cartTotal');
            tbody.innerHTML = '';
            let total = 0;
            if (cart.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4">Nenhum produto no carrinho.</td></tr>';
            } else {
                cart.forEach(item => {
                    total += parseFloat(item.value);
                    tbody.innerHTML += `<tr>
                        <td>${item.name}</td>
                        <td>${item.description || ''}</td>
                        <td>R$ ${Number(item.value).toFixed(2)}</td>
                        <td><button class="btn btn-danger btn-sm" onclick="removeFromCart(${item.id})">Remover</button></td>
                    </tr>`;
                });
            }
            totalSpan.textContent = 'R$ ' + total.toFixed(2);
        }
        renderCart();
    </script>
</body>
</html>
