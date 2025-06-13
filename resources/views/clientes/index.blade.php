
@extends('layouts.app')
@section('title', 'Lista de Clientes')
@section('content')
<div class="d-flex justify-content-between mb-3 align-items-center">
    <h1>Clientes</h1>
    <a href="{{ route('clientes.create') }}" class="btn btn-primary">Novo Cliente</a>
</div>
@include('layouts.search')
<table class="table table-dark table-striped">
    <thead>
        <tr>
            <th><a href="?sort=NomeCliente&direction={{ request('direction')=='asc'?'desc':'asc' }}">Nome</a></th>
            <th><a href="?sort=CPF&direction={{ request('direction')=='asc'?'desc':'asc' }}">CPF</a></th>
            <th><a href="?sort=Email&direction={{ request('direction')=='asc'?'desc':'asc' }}">Email</a></th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($clientes as $cliente)
        <tr>
            <td><a href="{{ route('clientes.show', $cliente) }}">{{ $cliente->nome }}</a></td>
            <td>{{ $cliente->cpf }}</td>
            <td>{{ $cliente->email }}</td>
            <td>
                <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Confirmar exclusão?')">Excluir</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="pagination-wrapper">
    {{  $clientes->withQueryString()->links('pagination::bootstrap-5') }}
</div>
@endsection