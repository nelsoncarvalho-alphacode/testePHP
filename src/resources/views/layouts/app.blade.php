<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Teste AlphaCode - CRUD Pedidos</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js'])
    @if(auth()->check())
        @vite(['resources/js/tables.js'])
    @endif
</head>
<body>
    <div id="app">
        @yield('content')
        @if(auth()->check())
            <main>
                <div class="mx-5 my-2 overflow-hidden">
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-outline-danger mb-2" id="remove-selected-btn" disabled>Remover selecionados</button>
                        <div class="mb-2 d-flex align-items-center justify-content-end gap-2 ml-auto">
                            <label for="limit-switch">Itens por página:</label>
                            <select class="form-select form-select-sm" id="limit-switch" style="width: 70px">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20" selected>20</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                    </div>
                    <x-table/>
                </div>
            </main>
        @endif
    </div>
</body>
</html>
