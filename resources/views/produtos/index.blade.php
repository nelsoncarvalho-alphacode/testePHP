
@extends('layouts.app')
@section('title', 'Lista de Produtos')
@section('content')
<div class="d-flex justify-content-between mb-3 align-items-center">
    <h1>Produtos</h1>
    <a href="{{ route('produtos.create') }}" class="btn btn-primary">Novo Produto</a>
</div>
@include('layouts.search')

<table class="table table-dark table-striped">
    <thead>
        <tr>
            @php
                $columns = ['id' => 'ID', 'cod_barras' => 'Código de Barras', 'nome' => 'Nome', 'valor_unitario' => 'Valor Unitário', 'created_at' => 'Criado em', 'updated_at' => 'Atualizado em'];
            @endphp
            @foreach ($columns as $field => $label)
                <th>
                    <a href="?sort={{ $field }}&direction={{ request('direction') === 'asc' && request('sort') === $field ? 'desc' : 'asc' }}{{ request('search') ? '&search=' . request('search') : '' }}">
                        {{ $label }}
                        @if(request('sort') === $field)
                            @if(request('direction') === 'asc') &uarr; @else &darr; @endif
                        @endif
                    </a>
                </th>
            @endforeach
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse($produtos as $produto)
            <tr>
                <td>{{ $produto->id }}</td>
                <td>{{ $produto->cod_barras }}</td>
                <td><a href="{{ route('produtos.show', $produto) }}">{{ $produto->nome }}</a></td>
                <td>R$ {{ number_format($produto->valor_unitario, 2, ',', '.') }}</td>
                <td>{{ $produto->created_at->format('d/m/Y') }}</td>
                <td>{{ $produto->updated_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('produtos.edit', $produto) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('produtos.destroy', $produto) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmar deleção?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Excluir</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center">Nenhum produto encontrado.</td></tr>
        @endforelse
    </tbody>
</table>

<div class="pagination-wrapper">
    {{  $produtos->withQueryString()->links('pagination::bootstrap-5') }}
</div>
    
@endsection