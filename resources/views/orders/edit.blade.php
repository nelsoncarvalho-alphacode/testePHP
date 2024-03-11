@extends('layouts.app')

@section('content')
<!-- Exibir mensagens de sucesso ou erro -->
<div class="alert alert-danger text-center" id="alert" style="position: fixed; z-index: 2; width: 80%; left: 10%;" hidden></div>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <h1 class="text-center mb-4">Editar Pedido</h1>
        <form action="{{ route('purchase_orders.update', ['pedido' => $purchaseOrder->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="client_name" class="form-label">Cliente:</label>
                <span class="text-danger">*</span>
                <input type="text" class="form-control" id="client_name" name="client_name" onkeyup="searchClients()" value="{{ $purchaseOrder->client->name }}">
                <input type="text" class="form-control" id="client_id" name="client_id" hidden value="{{ $purchaseOrder->client_id }}">
                <div id="client_list" class="dropdown-menu" aria-labelledby="client_name"></div>
            </div>
            
            <div class="mb-3">
                <label for="category" class="form-label">Filtrar Categoria</label>
                <select class="form-select" id="category" name="category" onchange="filterProducts(this.value)">
                    @foreach ($categories as $categorie)
                        <option value="{{ $categorie->id }}" {{ $purchaseOrder->category_id == $categorie->id ? 'selected' : '' }}>{{ $categorie->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-4" id="products">
                @foreach ($products as $product)
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column">
                                @if ($product->image_path)
                                    <div class="mb-3 mx-auto">
                                        <img class="img-fluid" style="max-height: 200px"src="{{ asset('storage/images/products/' . $product->image_path) }}" alt="Imagem do Produto">
                                    </div>
                                @else
                                    <div class="mb-3 mx-auto">
                                        <img class="img-fluid" style="max-height: 200px" src="{{ asset('storage/images/default/produto-sem-imagem.png') }}" alt="Imagem do Produto">
                                    </div>
                                @endif
                                <h5 class="card-title" id="product_{{$product->id}}">{{ $product->name }}</h5>
                                <p class="card-text">Quantidade: {{ $product->quantity }} disponível</p>
                                <div class="input-group mb-3">
                                    <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity('quantity_{{$product->id}}')">-</button>
                                    <input type="number" class="form-control" id="quantity_{{$product->id}}" name="products[{{$product->id}}][quantity]" value="1" min="1" max="{{$product->quantity}}" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity('quantity_{{$product->id}}')">+</button>
                                </div>
                                <p class="card-text">Preço: R$ <span id="price_{{$product->id}}">{{ $product->price }}</span></p>
                                <div class="description-wrapper mb-3">
                                    <p class="card-text">{{ $product->description }}</p>
                                </div>
                                <div class="mt-auto mx-auto">
                                    <button type="button" class="btn btn-primary" onclick="addProduct('{{$product->id}}', {{ $product->quantity }})">Adicionar ao Carrinho</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <input type="hidden" id="product_list_data" name="product_list_data" value="{{$purchaseOrderItems}}" required>
            <div class="mt-5 mb-3" id="product_add_group">
                <h4 class="mb-4">Produtos Adicionados:</h4>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3" id="product_list">
                    {{-- @foreach ($purchaseOrderItems as $item)
                        <li class="list-group-item">
                            <div class="col-lg-11 mb-4" id="product_card_{{$item->id}}">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->product_name }}</h5>
                                        <p class="card-text">Quantidade: {{ $item->quantity }}</p>
                                        <p class="card-text">Preço: R$ {{ $item->unit_price }}</p>
                                        <p class="card-text">Total: R$ {{ $item->quantity * $item->unit_price }}</p>
                                    </div>
                                    <div class="card-footer">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeFromCart({{ $loop->index }})">Remover</button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach --}}
                </div>
            </div>                        

            <div class="mb-3">
                <label for="total" class="form-label">Valor Total:</label>
                <span class="text-danger">*</span>
                <div class="input-group">
                    <input type="text" class="form-control" id="total" name="total" readonly required value="R$ {{ $purchaseOrder->total }}">
                    <span class="input-group-text" id="discount-text" style="{{ $purchaseOrder->payment_method == 'pix' ? '' : 'display: none;' }}">(5% de desconto para Pix)</span>
                </div>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status:</label>
                <span class="text-danger">*</span>
                <select class="form-select" id="status" name="status" required>
                    <option value="Em Aberto" {{ $purchaseOrder->status == 'Em Aberto' ? 'selected' : '' }}>Em Aberto</option>
                    <option value="Pago" {{ $purchaseOrder->status == 'Pago' ? 'selected' : '' }}>Pago</option>
                    <option value="Cancelado" {{ $purchaseOrder->status == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="order_date" class="form-label">Data do Pedido:</label>
                <span class="text-danger">*</span>
                <input type="date" class="form-control" id="order_date" name="order_date" required value="{{ $purchaseOrder->order_date }}">
            </div>

            <div class="mb-3">
                <label for="payment_method" class="form-label">Forma de Pagamento:</label>
                <span class="text-danger">*</span>
                <select class="form-select" id="payment_method" name="payment_method" onchange="paymentMethod(this.value)" required>
                    <option value="credito" {{ $purchaseOrder->payment_method == 'credito' ? 'selected' : '' }}>Cartão de Crédito</option>
                    <option value="debito" {{ $purchaseOrder->payment_method == 'debito' ? 'selected' : '' }}>Cartão de Débito</option>
                    <option value="pix" {{ $purchaseOrder->payment_method == 'pix' ? 'selected' : '' }}>Pix <span>(5% de desconto)</span></option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Atualizar Pedido</button>
            <a class="btn btn-secondary" href="{{ route('purchase_orders.index') }}">Voltar</a>
        </form>
    </div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Função para pesquisar clientes
function searchClients() {
    let name = document.getElementById('client_name').value;

    // Verificar se o comprimento do nome é suficiente para iniciar a pesquisa
    if (name.length > 2) {
        $.ajax({
            url: "/cliente/search/"+name,
            method: 'GET',
            dataType: "json",
            data: {name: name},
            success: function (data) {
                // Verificar se foram encontrados clientes correspondentes
                if (data.length > 0) {
                    $('#client_list').empty().fadeIn();
                    // Exibir os resultados da pesquisa
                    data.forEach(function(client) {
                        $('#client_list').append(`<p onClick="selectClient(${client.id}, '${client.name}')">${client.id} - ${client.name}</p>`);
                    });
                } else {
                    // Ocultar a lista de clientes se nenhum resultado for encontrado
                    $('#client_list').fadeOut().empty();
                }
            }
        });
    } else {
        // Ocultar a lista de clientes se o comprimento do nome for insuficiente
        $('#client_list').fadeOut().empty();
    }
}

// Função para selecionar um cliente
function selectClient(id, name) {
    document.getElementById('client_name').value = name;
    document.getElementById('client_id').value = id;
    $('#client_list').fadeOut().empty();
}

// Função para aumentar a quantidade
function increaseQuantity(inputId) {
    let input = document.getElementById(inputId);
    input.stepUp();
}

// Função para diminuir a quantidade
function decreaseQuantity(inputId) {
    let input = document.getElementById(inputId);
    input.stepDown();
}

// Função para renderizar um produto como um card HTML
function renderProduct(product) {
    let productImage = '';
    if (product.image_path) {
        productImage = `
            <div class="mb-3 mx-auto">
                <img class="img-fluid" style="max-height: 200px" src="/storage/images/products/${product.image_path}" alt="Imagem do Produto">
            </div>
        `;
    } else {
        productImage = `
            <div class="mb-3 mx-auto">
                <img class="img-fluid" style="max-height: 200px" src="/storage/images/default/produto-sem-imagem.png" alt="Imagem do Produto">
            </div>
        `;
    }
    return `
        <div class="col">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    ${productImage}
                    <h5 class="card-title" id="product_${product.id}">${product.name}</h5>
                    <p class="card-text">Quantidade: ${product.quantity} disponível</p>
                    <div class="input-group mb-3">
                        <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity('quantity_${product.id}')">-</button>
                        <input type="number" class="form-control" id="quantity_${product.id}" name="products[${product.id}][quantity]" value="1" min="1" max="${product.quantity}" readonly>
                        <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity('quantity_${product.id}')">+</button>
                    </div>
                    <p class="card-text">Preço: R$ <span id="price_${product.id}">${product.price}</span></p>
                    <div class="description-wrapper mb-3">
                        <p class="card-text">${product.description || ''}</p>
                    </div>
                    <div class="mt-auto mx-auto">
                        <button type="button" class="btn btn-primary" onclick="addProduct('${product.id}', '${product.quantity}')">Adicionar ao Carrinho</button>
                    </div>
                </div>
            </div>
        </div>
    `;
}

// Função para filtrar produtos com base na categoria
function filterProducts(categorieId) {
    // Seleciona o contêiner de produtos
    const productsContainer = document.getElementById('products');
    // Limpa o conteúdo existente antes de renderizar os novos produtos
    productsContainer.innerHTML = '';

    // Faz uma solicitação AJAX para obter produtos da categoria especificada
    $.ajax({
        url: "/produto/filtro/" + categorieId,
        method: 'GET',
        dataType: "json",
        data: { categorieId: categorieId },
        // Se a solicitação for bem-sucedida, renderiza os produtos na tela
        success: function (data) {
            data.forEach(function (product) {
                productsContainer.innerHTML += renderProduct(product);
            });
        },
        // Se houver um erro na solicitação, exibe uma mensagem de erro no console
        error: function (xhr, status, error) {
            console.error('Erro na solicitação de produtos:', error);
        }
    });
}

// Array para armazenar os produtos no carrinho
var PRODUCT_CAR = [];

// Função para adicionar um produto ao carrinho
function addProduct(productId, maxQuantity = null, itemName = false, itemQuantity = false, itemPrice = false, orderId = false) {
    // Obter informações do produto selecionado
    let productName = (itemName) ? itemName : document.getElementById('product_' + productId).textContent;
    let quantity = (itemQuantity) ? itemQuantity : parseInt(document.getElementById('quantity_' + productId).value);
    let price = (itemPrice) ? itemPrice : parseFloat(document.getElementById('price_' + productId).textContent);

    // Objeto para representar o item a ser adicionado ao carrinho
    let item = {};

    // Verificar se o produto já está no carrinho
    let exists = PRODUCT_CAR.find(item => item.id == productId);

    // Se o produto já estiver no carrinho, atualizar a quantidade
    if (exists) {
        // Encontrar o índice do produto existente no carrinho
        let index = PRODUCT_CAR.findIndex(item => item.id == productId);
        let currentItem = PRODUCT_CAR[index];

        console.log(maxQuantity);
        if (maxQuantity !== null) {
            // Verificar se a quantidade atual + a quantidade a ser adicionada ultrapassa o limite máximo
            if ((currentItem.quantity + quantity) > maxQuantity) {
                currentItem.quantity = maxQuantity;
            } else {
                currentItem.quantity += quantity;
            }
        } else {
            currentItem.quantity = quantity;
        }

        currentItem.priceOrder = currentItem.quantity * price;
    }
    // Se o produto não estiver no carrinho, adicionar ao carrinho
    else {
        item.id = productId;
        item.orderId = orderId;
        item.name = productName;
        item.quantity = quantity;
        item.price = price;
        item.priceOrder = quantity * price;
        PRODUCT_CAR.push(item);
    }

    updateCartList(); // Atualizar a lista de produtos no carrinho
}

insertProducts(); // Inserir produtos no carrinho ao carregar a página
// Funcao para inserir os produtos no carrinho
function insertProducts() {
    let product_list_data = document.getElementById('product_list_data').value;
    let product_list = JSON.parse(product_list_data);

    product_list.forEach(function(item) {
        addProduct(item.product_id, null, item.product_name, item.quantity, item.unit_price, item.id);
    });
}

// Função para atualizar a lista de produtos no carrinho
function updateCartList() {
    let totalValue = 0; // Inicializar o valor total

    // Converter o carrinho em uma string JSON e atualizar o campo oculto no formulário
    let productListData = JSON.stringify(PRODUCT_CAR);
    document.getElementById("product_list_data").value = productListData;

    // Selecionar o elemento HTML que contém a lista de produtos no carrinho
    let productList = document.getElementById('product_list');
    productList.innerHTML = ''; // Limpar a lista antes de atualizá-la

    // Loop através de cada item no carrinho
    PRODUCT_CAR.forEach(function(item, index) {
        // Criar um elemento HTML para representar o item
        let listItem = document.createElement('li');
        listItem.classList.add('list-group-item');

        // HTML do card do produto
        listItem.innerHTML = `
            <div class="col-lg-11 mb-4" id="product_card_${item.id}">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">${item.name}</h5>
                        <p class="card-text">Quantidade: ${item.quantity}</p>
                        <p class="card-text">Preço: R$ ${item.price}</p>
                        <p class="card-text">Total: R$ ${item.priceOrder}</p>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeFromCart(${index})">Remover</button>
                    </div>
                </div>
            </div>
        `;

        // Adicionar o elemento à lista de produtos no carrinho
        productList.appendChild(listItem);

        // Atualizar o valor total
        totalValue += item.priceOrder;
    });

    // Habilitar ou desabilitar o campo de pagamento com base no valor total
    $("#payment_method").prop('disabled', totalValue <= 0);

    // Atualizar o valor total no formulário
    document.getElementById('total').value = parseFloat(totalValue).toFixed(2);
}

// Função para remover um item do carrinho
function removeFromCart(index) {
    PRODUCT_CAR.splice(index, 1); // Remove o item do array PRODUCT_CAR
    updateCartList(); // Atualiza a lista de produtos no carrinho após a remoção
}

function paymentMethod(paymentMethod) {
    let totalInput = document.getElementById('total');
    let discountText = document.getElementById('discount-text');

    // Obter o valor atual do campo de entrada
    let totalValue = parseFloat(totalInput.value);

    // Aplicar desconto, 5% de desconto se a forma de pagamento for Pix
    let discountedTotal = (paymentMethod === 'pix') ? totalValue * (1 - 0.05) : totalValue;

    // Arredondar para 2 casas decimais e atualizar o valor do campo de entrada
    totalInput.value = discountedTotal.toFixed(2);

    // Mostrar ou ocultar o texto do desconto com base na forma de pagamento selecionada
    if (paymentMethod === 'pix') {
        discountText.style.display = 'inline-block';
    } else {
        discountText.style.display = 'none';
    }
}

function messageAlert (mensagem) {
    let alert = document.getElementById('alert');
    alert.hidden = false;
    alert.textContent = mensagem;
    
    $('#alert').fadeIn('slow');
    setTimeout(function() {
        $('#alert').fadeOut('slow');
    }, 3500); // 3.5 segundos
}

// Criar validacao para o formulario antes de enviar
document.querySelector('form').addEventListener('submit', function(e) {
    let clientName = document.getElementById('client_name').value;
    let clientId = document.getElementById('client_id').value;

    if (PRODUCT_CAR.length == 0) {
        e.preventDefault();
        messageAlert('Adicione produtos ao carrinho para finalizar o pedido.');
    } else if (clientName == '' || clientId == '') {
        e.preventDefault();
        messageAlert('Selecione um cliente para finalizar o pedido.');
    }
});
</script>
@endsection