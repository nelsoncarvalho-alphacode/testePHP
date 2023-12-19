@extends('layout')

@section('conteudo')
    <h1>Editar Produto</h1>
    <form action="{{ route('produtos.update', $produto->id) }}" method="POST" class="form_editar_produto">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="codigo_barras" class="form-label">Código de Barras:</label>
            <input type="number" class="form-control" id="codigo_barras" name="codigo_barras" value="{{ $produto->codigo_barras }}" required>
        </div>
        <div class="mb-3">
            <label for="nome" class="form-label">Nome do Produto:</label>
            <input type="text" class="form-control" id="nome" name="nome" value="{{ $produto->nome }}" required>
        </div>
        <div class="mb-3">
            <label for="quantidade" class="form-label">Quantidade:</label>
            <input type="number" class="form-control" id="quantidade" name="quantidade" value="{{ $produto->quantidade }}" required>
        </div>
        <div class="mb-3">
            <label for="valor_unitario" class="form-label">Valor Unitário:</label>
            <input type="text" class="form-control" id="valor_unitario" name="valor_unitario" value="{{ $produto->valor_unitario }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Atualizar Produto</button>
    </form>
@endsection

@push('styles')

    <style>
        .form_editar_produto {
            width: 50%;
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }
    </style>
@endpush

