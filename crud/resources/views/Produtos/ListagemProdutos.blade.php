@extends('layout')

@section('conteudo')
    <div class="content-fluid">
        <div class="row">
            @if(session('success'))
                <p class="msg"> {{ session('success') }}</p>
            @endif
        </div>
    </div>
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
                    @auth
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('comprar.show', $produto->id) }}" class="btn btn-success"><i class="fas fa-trash-alt"></i> Comprar</a>
                            <a href="{{ route('produtos.edit', $produto->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Editar</a>
                            <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este produto?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i> Excluir Produto
                                </button>
                            </form>
                        </div>
                    @endauth
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>
    @auth
        <div class="d-flex justify-content-start pt-5">
            <a href="/produtosCadastro" class="btn btn-sm btn-primary">Cadastrar Produto</a>
        </div>
    @endauth

    <div class="d-flex justify-content-center pt-5">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item {{ $produtos->previousPageUrl() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $produtos->previousPageUrl() }}">Anterior</a>
                </li>
                <!-- Loop para exibir os números das páginas -->
                @for ($i = 1; $i <= $produtos->lastPage(); $i++)
                    <li class="page-item {{ $produtos->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $produtos->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                <li class="page-item {{ $produtos->nextPageUrl() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $produtos->nextPageUrl() }}">Próxima</a>
                </li>
            </ul>
        </nav>
    </div>

@endsection

@push('styles')
    <style>
        .botao_cadastrar a {
            text-decoration: none;
            display: inline-block;
            padding: 8px 12px;
            margin: 5px;
            border: 1px solid transparent;
            border-radius: 5px;
            color: #fff;
            transition: all 0.3s ease;
            vertical-align: middle;
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
            vertical-align: middle;
        }

        .produtos-table th {
            background-color: #f2f2f2;
        }

        .produtos-table td a {
            text-decoration: none;
            color: #333;
        }

        .produtos-table td a:hover {
            color: #1E90FF;
        }
    </style>
@endpush

