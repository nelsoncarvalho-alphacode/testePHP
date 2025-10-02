<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th><a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'direction' => (request('sort')==='id' && request('direction')==='asc') ? 'desc' : 'asc']) }}">ID</a></th>
      <th><a href="{{ request()->fullUrlWithQuery(['sort' => 'nome', 'direction' => (request('sort')==='nome' && request('direction')==='asc') ? 'desc' : 'asc']) }}">Nome</a></th>
      <th><a href="{{ request()->fullUrlWithQuery(['sort' => 'cpf', 'direction' => (request('sort')==='cpf' && request('direction')==='asc') ? 'desc' : 'asc']) }}">CPF</a></th>
      <th><a href="{{ request()->fullUrlWithQuery(['sort' => 'email', 'direction' => (request('sort')==='email' && request('direction')==='asc') ? 'desc' : 'asc']) }}">Email</a></th>
      <th>Ações</th>
    </tr>
  </thead>
  <tbody>
    @forelse($clientes as $cliente)
      <tr>
        <td>{{ $cliente->id }}</td>
        <td>{{ $cliente->nome }}</td>
        <td>{{ $cliente->cpf }}</td>
        <td>{{ $cliente->email }}</td>
        <td style="white-space: nowrap;">
          <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-sm btn-info">Visualizar</a>
          <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-warning">Editar</a>

          <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="d-inline" onsubmit="return confirm('Deseja realmente apagar?');">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger">Excluir</button>
          </form>
        </td>
      </tr>
    @empty
      <tr><td colspan="5">Nenhum cliente encontrado.</td></tr>
    @endforelse
  </tbody>
</table>