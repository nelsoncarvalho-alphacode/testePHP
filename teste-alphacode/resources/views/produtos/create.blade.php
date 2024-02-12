@extends('layouts.main')

@section('title', 'Produtos')

@section('content')
  <div>
    <div class="my-5">
      <h3>
        Criar novo produto
      </h3>
    </div>
    <form action="/store-produto" method="POST">
      @csrf
      <div class="mb-3">
        <label for="product-name" class="form-label">Nome</label>
        <input type="text" class="form-control" id="product-name" name="nome" required>
      </div>
      <div class="mb-3">
        <label for="product-code" class="form-label">Código</label>
        <input type="text" class="form-control" id="product-code" name="cod_barras" required>
      </div>
      <div class="mb-3">
        <label for="product-price" class="form-label">Valor</label>
        <input type="text" class="form-control" id="product-price" name="valor" required>
      </div>
      <div class="mb-3">
        <label for="product-quantity" class="form-label">Quantidade em Estoque</label>
        <input type="text" class="form-control" id="product-quantity" name="qtd_prod" required>
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-primary w-25 mt-3">Salvar</button>
      </div>
    </form>
  </div>
@endsection