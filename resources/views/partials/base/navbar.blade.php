<nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="light">
    <div class="container-fluid">

        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('media/images/root.gif') }}" alt="RootShop" width="64" height="64" class="d-inline-block">
            <h1 class="brand-text d-inline-block mb-0">ROOTSHOP</h1>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Início</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('orders.index') }}">Pedidos</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('products.index') }}">Produtos</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('clients.index') }}">Clientes</a>
                </li>
            </ul>

            <div class="d-flex" role="search">

                <div class="d-flex align-items-center">
                    <div class="user-hello me-2">
                        <i class="bi bi-person-circle"></i> Bem vindo, {{ Auth::user()->name }}.
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="d-flex">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit"><i class="bi bi-box-arrow-right"></i> Sair</button>
                </form>

            </div>

        </div>
    </div>
</nav>
