@extends('layout')

@section('conteudo')
    <div>
        <h1>Editar quantidade do Pedido</h1>
        <!-- Outras informações do produto -->

        <h2>Seleção de Compra</h2>
        <form action="{{ route('pedidos.update', $pedido->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label for="quantidade">Quantidade:</label>
            <input type="number" id="quantidade" name="quantidade" min="1" value="1" required>
            <button type="submit" class="btn btn-primary">Atualizar Quantidade</button>
        </form>
    </div>
@endsection
