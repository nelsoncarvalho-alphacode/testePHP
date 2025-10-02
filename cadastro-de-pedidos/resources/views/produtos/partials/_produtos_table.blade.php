<table class="table table-bordered">
    <thead>
        <tr>
            <th><a
                    href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">ID</a>
            </th>
            <th><a
                    href="{{ request()->fullUrlWithQuery(['sort' => 'codigo_barras', 'direction' => request('sort') === 'codigo_barras' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">Código</a>
            </th>
            <th><a
                    href="{{ request()->fullUrlWithQuery(['sort' => 'nome', 'direction' => request('sort') === 'nome' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">Nome</a>
            </th>
            <th><a
                    href="{{ request()->fullUrlWithQuery(['sort' => 'valor_unitario', 'direction' => request('sort') === 'valor_unitario' && request('direction') === 'asc' ? 'desc' : 'asc']) }}">Valor</a>
            </th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse($produtos as $produto)
            <tr>
                <td>{{ $produto->id }}</td>
                <td>{{ $produto->codigo_barras }}</td>
                <td>{{ $produto->nome }}</td>
                <td>R$ {{ number_format($produto->valor_unitario, 2, ',', '.') }}</td>
                <td style="white-space:nowrap;">
                    <a href="{{ route('produtos.edit', $produto) }}" class="btn btn-sm btn-warning">Editar</a>

                    <form action="{{ route('produtos.destroy', $produto) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Deseja realmente apagar?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Excluir</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Nenhum produto encontrado.</td>
            </tr>
        @endforelse
    </tbody>
</table>
