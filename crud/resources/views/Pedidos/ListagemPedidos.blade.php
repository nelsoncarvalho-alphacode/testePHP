@extends('layout')

@section('conteudo')
    <h1>Listagem de Pedidos</h1>
    <!-- Tabela para exibir os pedidos -->
    <table class="pedidos-table">
        <thead>
        <tr>
            <th>ID do Pedido</th>
            <th>Número do Pedido</th>
            <th>Data do Pedido</th>
            <th>ID do Cliente</th>
            <th>Status do Pedido</th>
            <th>ID do Produto</th>
            <th>Quantidade</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($pedidos as $pedido)
            <tr>
                <td>{{ $pedido->id }}</td>
                <td>{{ $pedido->numero_do_pedido }}</td>
                <td>{{ $pedido->data_do_pedido }}</td>
                <td>{{ $pedido->cliente_id }}</td>
                <td>{{ $pedido->status }}</td>
                <td>{{ $pedido->produto_id }}</td>
                <td>{{ $pedido->quantidade }}</td>
                <td>
                    <!-- Botões para editar e excluir -->
                    <a href="{{ route('pedido.editar', $pedido->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Editar</a>
                    <a href="{{ route('pedido.excluir', $pedido->id) }}" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Excluir</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @auth

    @endauth
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos CSS para a tabela de pedidos */
        .pedidos-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .botao_cadastrar_pedido a {
            text-decoration: none;
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            border: 1px solid transparent;
            border-radius: 5px;
            color: #fff;
            transition: all 0.3s ease;
        }

        .botao_cadastrar_pedido {
            background-color: #1E90FF; /* Azul */
        }

        .botao_cadastrar_pedido a:hover {
            opacity: 0.8;
        }

        .pedidos-table th,
        .pedidos-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .pedidos-table th {
            background-color: #f2f2f2;
        }

        .pedidos-table td a {
            margin-right: 5px;
            text-decoration: none;
            color: #333;
        }

        .pedidos-table td a:hover {
            color: #1E90FF;
        }
    </style>
@endpush
