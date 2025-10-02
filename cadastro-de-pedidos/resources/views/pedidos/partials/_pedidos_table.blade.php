<table class="table table-striped">
    <thead>
        <tr>
            <th><a href="{{ route('pedidos.index', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">#</a></th>
            <th>Cliente</th>
            <th>Data</th>
            <th>Status</th>
            <th>Itens</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pedidos as $pedido)
            <tr>
                <td>{{ $pedido->id }}</td>
                <td>{{ $pedido->cliente->nome }}</td>
                <td>{{ \Carbon\Carbon::parse($pedido->data_pedido)->format('d/m/Y H:i') }}</td>
                <td>
                    @if($pedido->status === 'em_aberto')
                        <span class="badge bg-warning text-dark">Em Aberto</span>
                    @elseif($pedido->status === 'pago')
                        <span class="badge bg-success">Pago</span>
                    @else
                        <span class="badge bg-danger">Cancelado</span>
                    @endif
                </td>
                <td>{{ $pedido->itens_count }}</td>
                <td>
                    <a href="{{ route('pedidos.show', $pedido) }}" class="btn btn-sm btn-info">Visualizar</a>
                    <a href="{{ route('pedidos.edit', $pedido) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('pedidos.destroy', $pedido) }}" method="POST" class="d-inline" onsubmit="return confirm('Deseja excluir este pedido?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Excluir</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center">Nenhum pedido encontrado.</td></tr>
        @endforelse
    </tbody>
</table>