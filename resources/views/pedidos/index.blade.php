
@extends('layouts.app')
@section('title', 'Lista de Produtos')
@section('content')
<div class="d-flex justify-content-between mb-3 align-items-center">
    <h1>Produtos</h1>
    <a href="{{ route('produtos.create') }}" class="btn btn-primary">Novo Produto</a>
</div>
@include('layouts.search', [
    "select_name" => "status", 
    "select_value_label" => [
        "Em Aberto" => "Em Aberto",
        "Pago" => "Pago",
        "Cancelado" => "Cancelado"
    ]
])
<table class="table table-dark table-striped">
    <thead>
        <tr>
            <th>@sortablelink('id', 'Número')</th>
            <th>@sortablelink('data_pedido', 'Data')</th>
            <th>Cliente</th>
            <th>@sortablelink('status', 'Status')</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pedidos as $pedido)
        <tr>
            <td>{{ $pedido->id }}</td>
            <td>{{ $pedido->data_pedido->format('d/m/Y H:i') }}</td>
            <td>
                <a href="{{ route('clientes.show', $pedido->cliente_id) }}">
                    {{ $pedido->cliente->nome }}
                </a>
            </td>
            <td>{{ $pedido->status }}</td>
            <td>
                <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Confirmar exclusão?')">Excluir</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
    
<div class="pagination-wrapper">
    {{  $pedidos->withQueryString()->links('pagination::bootstrap-5') }}
</div>

@endsection