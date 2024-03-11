@extends('layouts.app')

@section('content')
@if (session('success'))
    <div class="alert alert-success" id="success-alert">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger" id="error-alert">
        {{ session('error') }}
    </div>
@endif
    <h1>Lista de Pedidos</h1>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a class="btn btn-secondary mb-3" href="{{ route('purchase_orders.index') }}">Voltar</a>
        <div class="col-md-2">
            <form action="{{ route('purchase_orders.index') }}" method="GET">
                <div class="input-group">
                    <select name="per_page" class="form-control w-auto" onchange="this.form.submit()">
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
            </form>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>
                    <a href="{{ route('purchase_orders.show_deleted', ['sort' => 'id', 'direction' => ($direction === 'asc') ? 'desc' : 'asc']) }}" class="link-unstyled text-dark">
                        @if ($sort === 'id')
                            @if ($direction === 'asc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort-down"></i>
                            @endif
                        @endif
                    # </a>
                </th>
                <th>
                    <a href="{{ route('purchase_orders.show_deleted', ['sort' => 'cliente', 'direction' => ($direction === 'asc') ? 'desc' : 'asc']) }}" class="link-unstyled text-dark">
                        @if ($sort === 'cliente')
                            @if ($direction === 'asc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort-down"></i>
                            @endif
                        @endif
                    Cliente </a>
                </th>
                <th>
                    <a href="{{ route('purchase_orders.show_deleted', ['sort' => 'status', 'direction' => ($direction === 'asc') ? 'desc' : 'asc']) }}" class="link-unstyled text-dark">
                        @if ($sort === 'status')
                            @if ($direction === 'asc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort-down"></i>
                            @endif
                        @endif
                    Status </a>
                </th>
                <th>
                    Total
                </th>
                <th>
                    <a href="{{ route('purchase_orders.show_deleted', ['sort' => 'date', 'direction' => ($direction === 'asc') ? 'desc' : 'asc']) }}" class="link-unstyled text-dark">
                        @if ($sort === 'date')
                            @if ($direction === 'asc')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort-down"></i>
                            @endif
                        @endif
                    Data do Pedido </a>
                </th>
                <th>
                    Numero do Pedido
                </th>
                <th>
                    Ações
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->client->name }}</td>
                    <td>{{ $order->status }}</td>
                    <td>R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                    <td>{{ date('d/m/Y', strtotime($order->order_date)) }}</td>
                    <td>{{ $order->order_number }}</td>
                    <td>
                        <a href="{{ route('purchase_orders.edit', ['pedido' => $order->id]) }}" class="btn btn-sm btn-primary">Editar</a>
                        <form action="{{ route('purchase_orders.restore', ['pedido' => $order->id]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success btn-sm">Restaurar</button>
                        </form>
                        <form action="{{ route('purchase_orders.destroy', ['pedido' => $order->id]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if ($orders->links() && $orders->lastPage() > 1)
        <nav class="mt-4">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($orders->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.previous')</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $orders->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
                    </li>
                @endif

                {{-- Current Page --}}
                <li class="page-item active" aria-current="page">
                    <span class="page-link">{{ $orders->currentPage() }}</span>
                </li>
                {{-- Total Pages --}}
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">of {{ $orders->lastPage() }}</span>
                </li>

                {{-- Next Page Link --}}
                @if ($orders->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $orders->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.next')</span>
                    </li>
                @endif
            </ul>
        </nav>
    @endif
@endsection

@section('script')
<script>
    window.setTimeout(function() {
        var successAlert = document.getElementById('success-alert');
        if (successAlert) {
            successAlert.style.display = 'none';
        }
    }, 3000); // 3 segundos

    window.setTimeout(function() {
        var errorAlert = document.getElementById('error-alert');
        if (errorAlert) {
            errorAlert.style.display = 'none';
        }
    }, 3000); // 3 segundos
</script>
<script>
    function sortTable(column, direction) {
        $.ajax({
            url: '{{ route('purchase_orders.show_deleted') }}',
            type: 'GET',
            data: {
                sort: column,
                direction: direction
            },
            success: function(response) {
                // Limpa a tabela
                $('#table-body').empty();

                // Adiciona as novas linhas à tabela
                $.each(response.data, function(i, item) {
                    $('#table-body').append('<tr>' +
                                                '<td>' + item.id + '</td>' +
                                                '<td>' + item.cliente + '</td>' +
                                                '<td>' + item.status + '</td>' +
                                                '<td>R$ ' + item.total.toFixed(2).replace('.', ',') + '</td>' +
                                                '<td>' + formatDate(item.date) + '</td>' +
                                                '<td>' + item.numero_do_pedido + '</td>' +
                                                '<td>' +
                                                    '<a href="' + route('purchase_orders.edit', ['pedido' => $order->id]) + '" class="btn btn-sm btn-primary">Editar</a>' +
                                                    '<form action="' + route('purchase_orders.restore', ['pedido' => $order->id]) + '" method="POST" style="display: inline;">' +
                                                        '@method('PUT')' +
                                                        '<button type="submit" class="btn btn-success btn-sm">Restaurar</button>' +
                                                    '</form>' +
                                                    '<form action="' + route('purchase_orders.destroy', ['pedido' => $order->id]) + '" method="POST" style="display: inline;">' +
                                                        '@csrf' +
                                                        '@method('DELETE')' +
                                                        '<button type="submit" class="btn btn-sm btn-danger">Excluir</button>' +
                                                    '</form>' +
                                                '</td>' +
                                            '</tr>');
                });
            },
            error: function(xhr, status, error) {
                // Lida com erros de requisição
            }
        });
    }

    function formatDate(date) {
        var d = new Date(date);
        var day = d.getDate();
        var month = d.getMonth() + 1;
        var year = d.getFullYear();
        return (day < 10 ? '0' + day : day) + '/' + (month < 10 ? '0' + month : month) + '/' + year;
    }
</script>
@endsection