@extends('layout.base')

@section('content')
<div class="container">
    <h1>Novo Produto</h1>
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="barcode" class="form-label">Código de Barras</label>
            <input type="text" name="barcode" class="form-control" id="barcode" required>
        </div>
        <div class="mb-3">
            <label for="product_name" class="form-label">Nome do Produto</label>
            <input type="text" name="product_name" class="form-control" id="product_name">
        </div>
        <div class="mb-3">
            <label for="unit_price" class="form-label">Preço</label>
            <input type="number" step="0.01" name="unit_price" class="form-control" id="unit_price" required>
        </div>
        <button type="submit" class="btn btn-primary">Confirmar</button>
    </form>
</div>
@endsection
