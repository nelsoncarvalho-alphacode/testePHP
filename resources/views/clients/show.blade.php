@extends('layouts.app')

@section('content')
<h1 class="mb-4">Dados do Cliente</h1>
<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Informações Pessoais</h5>
                <p class="card-text">Nome: {{ $client->name }}</p>
                <p class="card-text">Email: {{ $client->email }}</p>
                <p class="card-text">CPF: {{ $client->cpf }}</p>
                <p class="card-text">Celular: {{ $client->celphone }}</p>
                <p class="card-text">Data de Nascimento: {{ $client->date_of_birth }}</p>
            </div>
            <div class="card-footer">
                <a href="{{ route('clients.edit', ['cliente' => $client->id]) }}" class="btn btn-primary">Editar</a>
                <a href="{{ route('clients.index') }}" class="btn btn-secondary">Voltar</a>
                <form action="{{ route('clients.soft_deleted', ['cliente' => $client->id]) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Deletar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Coluna do endereço -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Endereço</h5>
                <p class="card-text">CEP: {{ $client->cep }}</p>
                <p class="card-text">Endereço: {{ $client->address . ($client->address_number ? ', ' . $client->address_number : '') . ($client->complement ? ' - Complemento: ' . $client->complement : '') }}</p>
                <p class="card-text">Bairro: {{ $client->neighborhood }}</p>
                <p class="card-text">Cidade: {{ $client->city }}</p>
                <p class="card-text">Estado: {{ $client->state }}</p>
            </div>
        </div>
    </div>

    <h2 class="mt-4">Pedidos:</h2>
    <div class="row">
        @if ($hasOrders)
            @foreach ($client->orders as $order)
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Pedido - <small><a href="{{ route('purchase_orders.show', ['pedido' => $order->id]) }}" class="text-decoration-none">Ver pedido</a></small></h5>
                            <p class="card-text">Número do Pedido: {{ $order->order_number }}</p>
                            <p class="card-text">Status: {{ $order->status }}</p>
                            <p class="card-text">Total: R$ {{ $order->total }}</p>
                            <p class="card-text">Data do Pedido: {{ date('d/m/Y', strtotime($order->order_date)) }}</p>
                            <p class="card-text">Produtos:</p>
                            <ul class="list-group">
                                @foreach ($order->items as $item)
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Produto: {{ $item->product_name }}</span>
                                            <span>Descrição: {{ $item->product ? $item->product->description : 'Descrição indisponível' }}</span>
                                            <span>{{ $item->quantity }} x R$ {{ $item->unit_price }} = R$ {{ $item->quantity * $item->unit_price }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p>Sem pedidos ate o momento.</p>
        @endif
    </div>
</div>
@endsection