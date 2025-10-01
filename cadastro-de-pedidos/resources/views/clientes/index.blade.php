@extends('layouts.app')

@section('title','Clientes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1>Clientes</h1>
  <a href="{{ route('clientes.create') }}" class="btn btn-primary">Novo Cliente</a>
</div>

<!-- Filtros -->
<form class="mb-3" method="GET" action="{{ route('clientes.index') }}">
  <div class="row g-2">
    <div class="col-md-3">
      <input type="text" name="nome" class="form-control" placeholder="Nome" value="{{ request('nome') }}">
    </div>
    <div class="col-md-2">
      <input type="text" name="cpf" class="form-control" placeholder="CPF" value="{{ request('cpf') }}">
    </div>
    <div class="col-md-3">
      <input type="text" name="email" class="form-control" placeholder="Email" value="{{ request('email') }}">
    </div>
    <div class="col-md-2">
      <select name="sort" class="form-select">
        <option value="">Ordenar por...</option>
        <option value="id" {{ request('sort')=='id' ? 'selected' : '' }}>ID</option>
        <option value="nome" {{ request('sort')=='nome' ? 'selected' : '' }}>Nome</option>
        <option value="cpf" {{ request('sort')=='cpf' ? 'selected' : '' }}>CPF</option>
        <option value="email" {{ request('sort')=='email' ? 'selected' : '' }}>Email</option>
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

<div class="d-flex justify-content-between align-items-center">
  <div>Mostrando {{ $clientes->count() }} de {{ $clientes->total() }} registros</div>
  <div>{{ $clientes->withQueryString()->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
