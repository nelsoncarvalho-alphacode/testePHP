@extends('layout.base')

@section('content')
<div class="container">
    <h1>Detalhes do Produto</h1>
    <div class="card">
        <div class="card-header">
            {{ $product->product_name ?? 'No name' }}
        </div>
        <div class="card-body">
            <p><strong>Código de Barras:</strong> {{ $product->barcode }}</p>
            <p><strong>Nome do Produto:</strong> {{ $product->product_name ?? 'No name' }}</p>
            <p><strong>Preço:</strong> R$ {{ $product->unit_price }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Retornar</a>
        </div>
    </div>
</div>
@endsection
