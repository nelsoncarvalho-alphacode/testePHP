@extends('layout')

@section('conteudo')
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
<div>
    <h1>Detalhes do Pedido</h1>
    <p>Nome: {{ $produto->nome }}</p>
    <h2>Seleção de Compra</h2>

    <form action="{{ route('comprar.confirm', $produto->id) }}" method="POST">
        @csrf
        <label for="quantidade">Quantidade:</label>
        <input type="number" id="quantidade" name="quantidade" min="1" value="1" required>
        <button type="submit" class="btn btn-primary">Confirmar Compra</button>
    </form>
</div>
@endsection
