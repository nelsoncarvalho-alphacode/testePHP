<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Aplicação CRUD</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: yellow; /* Faixa amarela */
            padding: 15px;
            display: flex;
            justify-content: flex-end;
            gap: 10px; /* Espaçamento entre os links */
        }
        .navbar a {
            color: black;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .navbar a:hover {
            background-color: #FFD700; /* Tonalidade amarela */
            border-color: black;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            text-align: center;
            padding-top: 100px;
        }
        .msg {
            background-color: #D4EDDA;
            color: #155724;
            border: 1px solid #C3E6CB;
            width: 100%;
            margin-bottom: 0;
            text-align: center;
            padding: 10px;
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="navbar">
    <a href="/">Home</a>
    <a href="{{ route('produtos') }}">Produtos</a>
    @auth
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                {{ __('Logout') }}
            </a>
        </form>
        <a href="{{ route('pedidos') }}">Pedidos</a>
    @endauth
</div>
<main>
    <div class="container">
        <div>
            @if(session('msg'))
                <p class="msg"> {{ session('msg') }}</p>
            @endif
            @yield('conteudo')
        </div>
    </div>
</main>
<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
