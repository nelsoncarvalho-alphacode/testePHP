@extends('layout.base')

@section('content')
    <div class="container">
        <h1>Bem vindo ao ROOTSHOP</h1>

        <hr>

        <p>Faça a gestão de pedidos, cadastre novos produtos e clientes pelos menus abaixo:</p>

        <ul class="list-group">
            <li class="list-group-item text-center">
                <a href="{{ route('orders.index') }}" class="btn btn-primary btn-block">Gestão de Pedidos</a>
            </li>
            <li class="list-group-item text-center">
                <a href="{{ route('products.index') }}" class="btn btn-info btn-block">Cadastro de Produtos</a>
            </li>
            <li class="list-group-item text-center">
                <a href="{{ route('clients.index') }}" class="btn btn-success btn-block">Cadastro de Clientes</a>
            </li>
        </ul>
    </div>
@endsection
