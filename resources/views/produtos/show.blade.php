@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Detalhes do Produto</h1>
    <table class="table table-dark table-striped">
        <tr><th>ID</th><td>{{ $produto->id }}</td></tr>
        <tr><th>Código de Barras</th><td>{{ $produto->cod_barras }}</td></tr>
        <tr><th>Nome</th><td>{{ $produto->nome }}</td></tr>
        <tr><th>Valor Unitário</th><td>{{ number_format($produto->valor_unitario, 2, ',', '.') }}</td></tr>
        <tr><th>Criado em</th><td>{{ $produto->created_at->format('d/m/Y H:i') }}</td></tr>
        <tr><th>Atualizado em</th><td>{{ $produto->updated_at->format('d/m/Y H:i') }}</td></tr>
    </table>
    <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Voltar</a>
</div>
@endsection
