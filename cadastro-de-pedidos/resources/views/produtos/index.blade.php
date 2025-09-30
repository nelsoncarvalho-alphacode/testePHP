@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1>Produtos</h1>
      <a href="{{ route('produtos.create') }}" class="btn btn-primary">Novo Produto</a>
    </div>

    <form method="GET" class="mb-3" action="{{ route('produtos.index') }}">
      <div class="row g-2">
        <div class="col-md-3">
          <input type="text" name="nome" class="form-control" placeholder="Nome" value="{{ request('nome') }}">
        </div>
        <div class="col-md-3">
          <input type="text" name="codigo_barras" class="form-control" placeholder="Código de Barras" value="{{ request('codigo_barras') }}">
        </div>
        <div class="col-md-2">
          <input type="number" step="0.01" name="valor_unitario" class="form-control" placeholder="Valor" value="{{ request('valor_unitario') }}">
        </div>
        <div class="col-md-2">
          <select name="sort" class="form-select">
            <option value="">Ordenar por...</option>
            <option value="id" {{ request('sort')=='id' ? 'selected' : '' }}>ID</option>
            <option value="codigo_barras" {{ request('sort')=='codigo_barras' ? 'selected' : '' }}>Código</option>
            <option value="nome" {{ request('sort')=='nome' ? 'selected' : '' }}>Nome</option>
            <option value="valor_unitario" {{ request('sort')=='valor_unitario' ? 'selected' : '' }}>Valor</option>
          </select>
        </div>
        <div class="col-md-1">
            <select name="direction" class="form-select">
                <option value="asc" {{ request('direction')=='asc' ? 'selected' : '' }}>ASC</option>
                <option value="desc" {{ request('direction')=='desc' ? 'selected' : '' }}>DESC</option>
            </select>
        </div>
        <div class="col-md-1 d-grid">
          <button class="btn btn-secondary">Filtrar</button>
        </div>
      </div>
    </form>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th><a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'direction' => (request('sort')==='id' && request('direction')==='asc') ? 'desc' : 'asc']) }}">ID</a></th>
          <th><a href="{{ request()->fullUrlWithQuery(['sort' => 'codigo_barras', 'direction' => (request('sort')==='codigo_barras' && request('direction')==='asc') ? 'desc' : 'asc']) }}">Código</a></th>
          <th><a href="{{ request()->fullUrlWithQuery(['sort' => 'nome', 'direction' => (request('sort')==='nome' && request('direction')==='asc') ? 'desc' : 'asc']) }}">Nome</a></th>
          <th><a href="{{ request()->fullUrlWithQuery(['sort' => 'valor_unitario', 'direction' => (request('sort')==='valor_unitario' && request('direction')==='asc') ? 'desc' : 'asc']) }}">Valor</a></th>
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

              <form action="{{ route('produtos.destroy', $produto) }}" method="POST" class="d-inline" onsubmit="return confirm('Deseja realmente apagar?');">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger">Excluir</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5">Nenhum produto encontrado.</td></tr>
        @endforelse
      </tbody>
    </table>

    <div class="d-flex justify-content-between align-items-center">
      <div>Mostrando {{ $produtos->count() }} de {{ $produtos->total() }} registros</div>
      <div>{{ $produtos->withQueryString()->links('pagination::bootstrap-5') }}</div>
    </div>
</div>
@endsection
