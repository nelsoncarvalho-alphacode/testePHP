
@extends('layouts.app')
@section('title', 'Editar Pedido')
@section('content')
<h1>Editar Pedido</h1>
<form action="{{ route('pedidos.update', $pedido) }}" method="POST">
    @method('PUT')
    @include('pedidos.form')
    <button type="submit" class="btn btn-success">Atualizar</button>
    <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection