<nav>
    <div class="m-2 mb-5 row">
        <button class="btn col" id="clients-btn" onclick="window.location='{{ route("view.clients") }}'" {{$current == 'clients' ? 'disabled' : ''}}>Clientes</button>
        <button class="btn col" id="products-btn" onclick="window.location='{{ route("view.products") }}'" {{$current == 'products' ? 'disabled' : ''}}>Produtos</button>
        <button class="btn col" id="orders-btn" onclick="window.location='{{ route("view.orders") }}'" {{$current == 'orders' ? 'disabled' : ''}}>Pedidos</button>
    </div>
</nav>
