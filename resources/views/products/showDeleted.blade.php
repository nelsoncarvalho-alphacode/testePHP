@extends('layouts.app')

@section('content')
@if (session('success'))
    <div class="alert alert-success" id="success-alert">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger" id="error-alert">
        {{ session('error') }}
    </div>
@endif
<h1>Lista de Produtos</h1>
<div class="d-flex justify-content-between align-items-center mb-3">
    <a class="btn btn-secondary mb-3" href="{{ route('products.index') }}">Voltar</a>
    <div class="col-md-3">
        <div class="card-body">
            <div class="form-group">
                <label for="categorieSelect">Selecione uma categoria:</label>
                <select class="form-control" id="categorieSelect" name="categorie_id" onchange="filterProducts(this.value)">
                    @foreach ($categories as $categorie)
                        <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <form action="{{ route('products.index') }}" method="GET">
            <div class="input-group">
                <select name="per_page" class="form-control w-auto" onchange="this.form.submit()">
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>
        </form>
    </div>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>
                <a href="{{ route('products.show_deleted', ['sort' => 'id', 'direction' => ($direction === 'asc') ? 'desc' : 'asc']) }}" class="link-unstyled text-dark">
                    @if ($sort === 'id')
                        @if ($direction === 'asc')
                            <i class="fas fa-sort-up"></i>
                        @else
                            <i class="fas fa-sort-down"></i>
                        @endif
                    @endif
                # </a>
            </th>
            <th>
                <a href="{{ route('products.show_deleted', ['sort' => 'nome', 'direction' => ($direction === 'asc') ? 'desc' : 'asc']) }}" class="link-unstyled text-dark">
                    @if ($sort === 'nome')
                        @if ($direction === 'asc')
                            <i class="fas fa-sort-up"></i>
                        @else
                            <i class="fas fa-sort-down"></i>
                        @endif
                    @endif
                Nome </a>
            </th>
            <th>
                Descrição
            </th>
            <th>
                <a href="{{ route('products.show_deleted', ['sort' => 'quantidade', 'direction' => ($direction === 'asc') ? 'desc' : 'asc']) }}" class="link-unstyled text-dark">
                    @if ($sort === 'quantidade')
                        @if ($direction === 'asc')
                            <i class="fas fa-sort-up"></i>
                        @else
                            <i class="fas fa-sort-down"></i>
                        @endif
                    @endif
                Quantidade </a>
            </th>
            <th>
                Valor
            </th>
            <th>
                <a href="{{ route('products.show_deleted', ['sort' => 'status', 'direction' => ($direction === 'asc') ? 'desc' : 'asc']) }}" class="link-unstyled text-dark">
                    @if ($sort === 'status')
                        @if ($direction === 'asc')
                            <i class="fas fa-sort-up"></i>
                        @else
                            <i class="fas fa-sort-down"></i>
                        @endif
                    @endif
                Status </a>
            </th>
            <th>
                Ações
            </th>
        </tr>
    </thead>
    <tbody id="productList">
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ $product->price }}</td>
                @if ($product->status === 1)
                    <td>Ativo</td>
                @else
                    <td>Inativo <i class="bi bi-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Sem estoque no momento"></i></td>
                @endif
                <td>
                    <a class="btn btn-primary btn-sm" href="{{ route('products.edit', ['produto' => $product->id]) }}">Editar</a>
                    <form action="{{ route('products.restore', ['produto' => $product->id]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success btn-sm">Restaurar</button>
                    </form>
                    <form action="{{ route('products.destroy', ['produto' => $product->id]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@if ($products->links() && $products->lastPage() > 1)
    <nav class="mt-4">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($products->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">@lang('pagination.previous')</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
                </li>
            @endif

            {{-- Current Page --}}
            <li class="page-item active" aria-current="page">
                <span class="page-link">{{ $products->currentPage() }}</span>
            </li>
            {{-- Total Pages --}}
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link">of {{ $products->lastPage() }}</span>
            </li>

            {{-- Next Page Link --}}
            @if ($products->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">@lang('pagination.next')</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
@endsection

@section('script')
<script>
    // Função para renderizar um produto como um card HTML
    function renderProduct(product) {
        return `
            <tr>
                <td>${product.id}</td>
                <td>${product.name}</td>
                <td>${product.description}</td>
                <td>${product.quantity}</td>
                <td>${product.price}</td>
                ${product.status === 1 ? '<td>Ativo</td>' : '<td>Inativo <i class="bi bi-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Sem estoque no momento"></i></td>'}
                <td>
                    <a class="btn btn-primary btn-sm" href="/produto/${product.id}/editar">Editar</a>
                    <form action="/produto/${product.id}/restaurar" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success btn-sm">Restaurar</button>
                    </form>
                    <form action="/produto/${product.id}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </td>
            </tr>
        `;
    }

    // Função para filtrar produtos com base na categoria
    function filterProducts(categorieId) {
        // Seleciona o contêiner de produtos
        const productsContainer = document.getElementById('productList');
        // Limpa o conteúdo existente antes de renderizar os novos produtos
        productsContainer.innerHTML = '';

        // Faz uma solicitação AJAX para obter produtos da categoria especificada
        $.ajax({
            url: "/produto/filtro/" + categorieId,
            method: 'GET',
            dataType: "json",
            data: { 
                categorieId: categorieId,
                page: 'product.show_deleted' 
            },
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
</script>
@endsection