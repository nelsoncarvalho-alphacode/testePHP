@extends('layout')

@section('conteudo')
    <div class="content-fluid">
        <div class="row">
            @if(session('success'))
                <p class="msg"> {{ session('success') }}</p>
            @endif
        </div>
    </div>
    <h1>Listagem de Pedidos</h1>
    <table class="table table-bordered pedidos-table">
        <thead>
        <tr>
            <th>ID do Pedido</th>
            <th>
                <a href="{{ route('pedidos', ['order' => 'desc']) }}">▼</a>
                Data do pedido
                <a href="{{ route('pedidos', ['order' => 'asc']) }}">▲</a>
            </th>
            <th>ID do Cliente</th>
            <th>Status do Pedido</th>
            <th>Quantidade</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($pedidos as $pedido)
            <tr>
                <td>{{ $pedido->id }}</td>
                <td>{{ $pedido->data_do_pedido }}</td>
                <td>{{ $pedido->cliente_id }}</td>
                <td>{{ $pedido->status }}</td>
                <td>{{ $pedido->quantidade }}</td>
                @auth
                    @if($pedido->status !== 'Pago' && $pedido->status !== 'Cancelado')
                        <td>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('pedidos.pagar', $pedido->id) }}" class="btn btn-success"><i class="fas fa-edit"></i> Pagar</a>
                                <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Editar</a>
                                <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este pedido?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash-alt"></i> Excluir Pedido
                                    </button>
                                </form>
                            </div>
                        </td>
                    @endif
                @endauth
                    @if($pedido->status == 'Pago')
                    <td>
                        <div style="text-align: center">
                        <a href="{{ route('pedidos.cancelar', $pedido->id) }}" class="btn btn-danger"><i class="fas fa-edit"></i> Cancelar</a>
                        </div>
                    </td>
                    @endif

            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center pt-5">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item {{ $pedidos->previousPageUrl() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $pedidos->previousPageUrl() }}">Anterior</a>
                </li>
                <!-- Loop para exibir os números das páginas -->
                @for ($i = 1; $i <= $pedidos->lastPage(); $i++)
                    <li class="page-item {{ $pedidos->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $pedidos->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                <li class="page-item {{ $pedidos->nextPageUrl() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $pedidos->nextPageUrl() }}">Próxima</a>
                </li>
            </ul>
        </nav>
    </div>
@endsection

@push('styles')
    <style>
        .pedidos-table {
            width: 100%;
            margin-top: 20px;
        }
    </style>
@endpush
