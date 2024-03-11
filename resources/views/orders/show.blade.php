@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Detalhes do Pedido</h2>
                <div class="mb-3">
                    <p class="card-text"><strong>Número do Pedido:</strong> {{ $purchaseOrder->order_number }}</p>
                </div>
                <div class="mb-3">
                    <p class="card-text"><strong>Cliente:</strong> {{ $purchaseOrder->client->name }} <a href="{{ route('clients.show', ['cliente' => $purchaseOrder->client->id]) }}">ver perfil</a></p>
                </div>
                <div class="mb-3">
                    <p class="card-text"><strong>Status:</strong> {{ $purchaseOrder->status }}</p>
                </div>
                <div class="mb-3">
                    <p class="card-text"><strong>Total:</strong> R$ {{ $purchaseOrder->total }}</p>
                </div>
                <div class="mb-3">
                    <p class="card-text"><strong>Data do Pedido:</strong> {{ date('d/m/Y', strtotime($purchaseOrder->order_date)) }}</p>
                </div>
                <div class="mb-3">
                    <p class="card-text"><strong>Produtos:</strong></p>
                    <ul class="list-group">
                        @foreach ($purchaseOrder->items as $item)
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
                <div class="text-center">
                    <a href="{{ route('purchase_orders.index') }}" class="btn btn-primary">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection