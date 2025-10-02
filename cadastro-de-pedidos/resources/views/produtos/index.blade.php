@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1>Produtos</h1>
      <a href="{{ route('produtos.create') }}" class="btn btn-primary">Novo Produto</a>
    </div>

    @include('produtos.partials._filter_form')

    @include('produtos.partials._produtos_table')

    <div class="d-flex justify-content-between align-items-center">
      <div>Mostrando {{ $produtos->count() }} de {{ $produtos->total() }} registros</div>
      <div>{{ $produtos->withQueryString()->links('pagination::bootstrap-5') }}</div>
    </div>
</div>
@endsection
