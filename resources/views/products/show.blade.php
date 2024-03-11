@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Detalhes do Produto</h2>
                @if ($product->image_path)
                    <div class="mb-3 mx-auto">
                        <img class="img-fluid" style="max-height: 200px" src="{{ asset('storage/images/products/' . $product->image_path) }}" alt="Imagem do Produto">
                    </div>
                @else
                    <div class="mb-3 mx-auto">
                        <img class="img-fluid" style="max-height: 200px" src="{{ asset('storage/images/default/produto-sem-imagem.png') }}" alt="Imagem do Produto">
                    </div>
                @endif
                <div class="mb-3">
                    <p class="card-text"><strong>Nome:</strong> {{ $product->name }}</p>
                </div>
                <div class="mb-3">
                    <p class="card-text"><strong>Quantidade:</strong> {{ $product->quantity }}</p>
                </div>
                <div class="mb-3">
                    <p class="card-text"><strong>Descrição:</strong> {{ $product->description }}</p>
                </div>
                <div class="mb-3">
                    <p class="card-text"><strong>Categoria:</strong> {{ $product->categorie->name }}</p>
                </div>
                <div class="mb-3">
                    <p class="card-text"><strong>Preço:</strong> R$ {{ $product->price }}</p>
                </div>
                <div class="mb-3">
                    <p class="card-text"><strong>Status:</strong> {{ ($product->status === 1) ? 'Ativo' : 'Inativo' }}</p>
                </div>
                <div class="mb-3">
                    <p class="card-text"><strong>Código de Barra:</strong> {{ $product->barcode }}</p>
                </div>
                <div class="text-center">
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection