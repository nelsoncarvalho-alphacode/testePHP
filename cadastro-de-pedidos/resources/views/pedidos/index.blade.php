@extends('layouts.app')

@section('title', 'Pedidos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Pedidos</h1>
    <a href="{{ route('pedidos.create') }}" class="btn btn-primary">Novo Pedido</a>
</div>

@include('pedidos.partials._filter_form')

@include('pedidos.partials._pedidos_table')

<div class="d-flex justify-content-between align-items-center">
  <div>Mostrando {{ $pedidos->count() }} de {{ $pedidos->total() }} registros</div>
  <div>{{ $pedidos->withQueryString()->links('pagination::bootstrap-5') }}</div>
</div>

@endsection
