@extends('layouts.app')
@section('title', 'Detalhes do Pedido')
@section('content')
<h1>Pedido #{{ $pedido->id }}</h1>
<ul class="list-group mb-3">
    <li class="list-group-item"><strong>Cliente:</strong> {{ $pedido->cliente->NomeCliente }}</li>
    <li class="list-group-item"><strong>Data:</strong> {{ $pedido->data_pedido->format('d/m/Y H:i') }}</li>
    <li class="list-group-item"><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $pedido->status)) }}</li>
    <li class="list-group-item"><strong>Total:</strong> R$ {{ number_format($pedido->total, 2, ',', '.') }}</li>
</ul>
<a href="{{ route('pedidos.edit', $pedido) }}" class="btn btn-warning">Editar</a>
<a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Voltar</a>
@endsection