<?php
// View do carrinho de compras - gestão de itens e finalização de pedidos
require_once __DIR__ . '/../../bootstrap.php';

use Controllers\OrderController;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Carrinho de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div id="cartContainer"></div>
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
                tbody.innerHTML = '<tr><td colspan="5">Nenhum produto no carrinho.</td></tr>';
            } else {
                cart.forEach(item => {
                    let desc = item.description || '';
                    if (desc.length > 50) {
                        desc = desc.substring(0, 47) + '...';
                    }
                    let qty = item.qty || 1;
                    total += parseFloat(item.value) * qty;
                    tbody.innerHTML += `<tr>
                        <td>${item.name}</td>
                        <td>${desc}</td>
                        <td>R$ ${Number(item.value).toFixed(2)}</td>
                        <td><input type="number" min="1" value="${qty}" style="width:70px" onchange="updateQty(${item.id}, this.value)"></td>
                        <td><button class="btn btn-danger btn-sm" onclick="removeFromCart(${item.id})">Remover</button></td>
                    </tr>`;
                });
            }
            totalSpan.textContent = 'R$ ' + total.toFixed(2);
        }

        function updateQty(id, value) {
            let cart = getCart();
            value = Math.max(1, parseInt(value) || 1);
            cart = cart.map(item => item.id === id ? {
                ...item,
                qty: value
            } : item);
            setCart(cart);
            renderCart();
        }

        // Exibe carrinho apenas para usuário comum
        fetch('/api/session')
            .then(response => response.json())
            .then(data => {
                if (!data.is_admin) {
                    document.getElementById('cartContainer').innerHTML = `
                        <div class="container-fluid px-3 py-5">
                            <div class="row justify-content-center">
                                <div class="col-12 col-xl-10">
                                    <div class="card shadow">
                                        <div class="card-header bg-primary text-white">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h4 class="mb-0">Carrinho de Compras</h4>
                                                <a id="backToProductsBtn" href="/produtos" class="btn btn-warning btn-sm me-2">Voltar para Produtos</a>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Produto</th>
                                                    <th>Descrição</th>
                                                    <th>Valor (R$)</th>
                                                    <th>Quantidade</th>
                                                    <th>Remover</th>
                                                </tr>
                                            </thead>
                                            <tbody id="cartTable"></tbody>
                                        </table>
                                        </div>
                                        <div class="d-flex flex-column align-items-end" style="margin-right: 16px;">
                                            <h5 class="mb-2">Total: <span id="cartTotal">R$ 0,00</span></h5>
                                            <button class="btn btn-success" onclick="storeCart()">Comprar</button>
                                        </div>
                                        <div id="result" class="mt-3"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    renderCart();
                } else {
                    document.getElementById('cartContainer').innerHTML = `<div class='container-fluid px-3 py-5'><div class='alert alert-danger'>Acesso restrito: apenas usuários comuns podem visualizar o carrinho.</div></div>`;
                }
            });

        function storeCart() {
            const cart = getCart();
            fetch('/api/order', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        products: cart
                    })
                })
                .then(response => response.json())
                .then(data => {
                    localStorage.removeItem('cart');
                    window.location.href = '/pedidos';
                })
        }
    </script>
</body>

</html>