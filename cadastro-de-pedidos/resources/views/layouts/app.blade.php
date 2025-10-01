<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Cadastro de Pedidos')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  .navbar .nav-link.active {
    color: #ffffff !important;
    font-weight: bold;
  }
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link {{ request()->is('/') || request()->is('clientes*') ? 'active' : '' }}" 
             href="{{ route('clientes.index') }}">
            Clientes
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('produtos*') ? 'active' : '' }}" 
             href="{{ route('produtos.index') }}">
            Produtos
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('pedidos*') ? 'active' : '' }}" 
             href="{{ route('pedidos.index') }}">
            Pedidos
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
