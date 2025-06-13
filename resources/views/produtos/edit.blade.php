
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Produto</h1>
    <form action="{{ route('produtos.update', $produto) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="cod_barras" class="form-label">Código de Barras</label>
            <input type="text" name="cod_barras" id="cod_barras" class="form-control" value="{{ old('cod_barras', $produto->cod_barras) }}" required maxlength="20">
        </div>
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome', $produto->nome) }}" required maxlength="100">
        </div>
        <div class="mb-3">
            <label for="valor_unitario" class="form-label">Valor Unitário</label>
            <input type="number" name="valor_unitario" id="valor_unitario" class="form-control" value="{{ old('valor_unitario', $produto->valor_unitario) }}" step="0.01" min="0" required>
        </div>
        <button type="submit" class="btn btn-primary">Atualizar</button>
        <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

