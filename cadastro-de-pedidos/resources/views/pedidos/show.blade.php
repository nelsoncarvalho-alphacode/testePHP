@extends('layouts.app')

@section('title', 'Detalhes do Pedido')

@section('content')
    <h1>Pedido #{{ $pedido->id }}</h1>
    <p><strong>Cliente:</strong> {{ $pedido->cliente->nome }}</p>
    <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($pedido->data_pedido)->format('d/m/Y H:i') }}</p>
    <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $pedido->status)) }}</p>

    <h3>Itens</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Qtd</th>
                <th>Valor Unitário</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedido->itens as $item)
                <tr>
                    <td>{{ $item->produto->nome }}</td>
                    <td>{{ $item->quantidade }}</td>
                    <td>R$ {{ number_format($item->valor_unitario, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($item->quantidade * $item->valor_unitario, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Voltar</a>
@endsection
