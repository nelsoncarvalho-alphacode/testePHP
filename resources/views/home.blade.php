@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Top 3 Clientes com mais pedidos</h5>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    @if ($topClientsByOrders->isEmpty())
                        <div class="col-md-12">
                            <div class="alert alert-warning" role="alert">
                                Não há clientes com pedidos.
                            </div>
                        </div>
                    @else
                        @php $rank = 1; @endphp
                        @foreach ($topClientsByOrders as $client)
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0">Posição {{ $rank }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $client->name }}</h5>
                                        <p class="card-text">Total de Pedidos: {{ $client->orders_count }}</p>
                                    </div>
                                </div>
                            </div>
                            @php $rank++; @endphp
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>    

    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Top 3 Clientes com total mais alto</h5>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    @if ($topClientsBySpending->isEmpty())
                        <div class="col-md-12">
                            <div class="alert alert-warning" role="alert">
                                Não há clientes com pedidos.
                            </div>
                        </div>
                    @else
                        @php $rank = 1; @endphp
                        @foreach ($topClientsBySpending as $client)
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0">Posição {{ $rank }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $client->name }}</h5>
                                        <p class="card-text">Total Gasto: R$ {{ $client->orders_sum_total }}</p>
                                    </div>
                                </div>
                            </div>
                            @php $rank++; @endphp
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>    

    
    <div class="col-md-12 mb-4">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Filtrar por Categoria</h5>
            </div>
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
        
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="row">
                    <div class="col">
                        <h5 class="mb-0">Produtos</h5>
                    </div>
                    <div class="col-md-2">
                        <form action="{{ route('home') }}" method="GET">
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
            </div>
            <div class="card-body">
                <div class="row row-cols-1 row-cols-md-3 g-4" id="productList">
                    @if ($products->isEmpty())
                        <div class="col-md-12">
                            <div class="alert alert-warning" role="alert">
                                Não há produtos cadastrados.
                            </div>
                        </div>
                    @else
                        @foreach ($products as $product)
                            <div class="col mb-3">
                                <div class="card h-100">
                                    <div class="card-body d-flex flex-column">
                                        @if ($product->image_path)
                                            <div class="mb-3 mx-auto">
                                                <img class="img-fluid" style="max-height: 200px" src="{{ asset('storage/images/products/' . $product->image_path) }}" alt="Imagem do Produto">
                                            </div>
                                        @else
                                            <div class="mb-3 mx-auto">
                                                <img class="img-fluid" style="max-height: 200px" src="{{ asset('storage/images/default/produto-sem-imagem.png') }}" alt="Imagem do Produto">
                                            </div>
                                        @endif
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text">Preço: ${{ $product->price }}</p>
                                        <div class="description-wrapper mb-3">
                                            <p class="card-text">{{ $product->description }}</p>
                                        </div>
                                        <div class="mt-auto mx-auto">
                                            <a href="{{ route('products.show', ['produto' => $product->id]) }}" class="btn btn-primary">Ver Detalhes</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        
        @if ($products->isNotEmpty() && $products->lastPage() > 1 && $products->links())
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
    </div>
</div>
@endsection

@section('script')
<script>
    // Função para renderizar um produto como um card HTML
    function renderProduct(product) {
        let productImage = '';
        if (product.image_path) {
            productImage = `
                <div class="mb-3 mx-auto">
                    <img class="img-fluid" style="max-height: 200px" src="/storage/images/products/${product.image_path}" alt="Imagem do Produto">
                </div>
            `;
        } else {
            productImage = `
                <div class="mb-3 mx-auto">
                    <img class="img-fluid" style="max-height: 200px" src="/storage/images/default/produto-sem-imagem.png" alt="Imagem do Produto">
                </div>
            `;
        }
        return `
            <div class="col mb-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        ${productImage}
                        <h5 class="card-title">${product.name}</h5>
                        <p class="card-text">Preço: $${product.price}</p>
                        <div class="description-wrapper mb-3">
                            <p class="card-text">${product.description ?? ''}</p>
                        </div>
                        <div class="mt-auto mx-auto">
                            <a href="/produto/${product.id}" class="btn btn-primary">Ver Detalhes</a>
                        </div>
                    </div>
                </div>
            </div>
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
            data: { categorieId: categorieId },
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