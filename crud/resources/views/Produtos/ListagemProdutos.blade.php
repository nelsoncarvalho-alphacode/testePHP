@extends('layout')

@section('conteudo')
    <h1>Listagem de Produtos</h1>
    <!-- Tabela para exibir os produtos -->
    <table class="produtos-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Código de Barras</th>
            <th>Quantidade</th>
            <th>Valor Unitário</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($produtos as $produto)
            <tr>
                <td>{{ $produto->id }}</td>
                <td>{{ $produto->nome }}</td>
                <td>{{ $produto->codigo_barras }}</td>
                <td>{{ $produto->quantidade }}</td>
                <td>{{ $produto->valor_unitario }}</td>
                <td>
                    <!-- Ícones para editar e excluir -->
                    <a href=""><ion-icon name="create-outline"></ion-icon></a>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @auth
        <div class="botao_cadastrar">
            <a href="produtosCadastro" class="btn-cadastrar">Cadastrar Produto</a>
        </div>
    @endauth
@endsection

@push('styles')
    <style>
        /* Estilos dos botões... */
        .botao_cadastrar a {
            text-decoration: none;
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            border: 1px solid transparent;
            border-radius: 5px;
            color: #fff;
            transition: all 0.3s ease;
        }

        .botao_cadastrar {
            background-color: #1E90FF; /* Azul */
        }

        .botao_cadastrar a:hover {
            opacity: 0.8;
        }

        .produtos-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .produtos-table th,
        .produtos-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .produtos-table th {
            background-color: #f2f2f2;
        }

        .produtos-table td a {
            margin-right: 5px;
            text-decoration: none;
            color: #333;
        }

        .produtos-table td a:hover {
            color: #1E90FF;
        }
    </style>
@endpush
