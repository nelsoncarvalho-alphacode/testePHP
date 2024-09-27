@extends('layout.base')

@section('content')
    <div class="container">
        <h1>Detalhes do Pedido</h1>

        <table class="table table-striped table-hover">
            <tbody>
            <tr>
                <td><strong>Pedido {{ $order->order_number }} - 
                @if ($order->order_status == 'Open')
                    ABERTO
                @elseif ($order->order_status == 'Paid')
                    PAGO
                @else
                    CANCELADO
                @endif
                </strong></td>
            </tr>
            <tr>
                <td><strong>Nome do Cliente:</strong> {{ $order->client->client_name }}</td>
            </tr>
            <tr>
                <td><strong>Total Bruto:</strong> R${{ $order->total_amount }}</td>
            </tr>
            <tr>
                <td><strong>Desconto:</strong> R${{ $order->discount }}</td>
            </tr>
            <tr>
                <td><strong>Total:</strong> R${{ $order->total_amount - $order->discount }}</td>
            </tr>
            </tbody>
        </table>
        
        <h3>Produtos do Pedido</h3>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">Nome do Produto</th>
                    <th scope="col">Código de Barras</th>
                    <th scope="col">Preço</th>
                    <th scope="col">Quantidade</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderProducts as $orderProduct)
                    <tr>
                        <td>{{ $orderProduct->product_name }}</td>
                        <td>{{ $orderProduct->barcode }}</td>
                        <td>R${{ $orderProduct->unit_price }}</td>
                        <td>{{ $orderProduct->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Retornar</a>
    </div>
@endsection
