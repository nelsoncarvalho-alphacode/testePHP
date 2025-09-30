@extends('layouts.app')

@section('title', 'Editar Pedido')

@section('content')
<h1>Editar Pedido</h1>

<form method="POST" action="{{ route('pedidos.update', $pedido) }}">
    @csrf
    @method('PUT')
    @include('pedidos.form', ['pedido' => $pedido])
</form>
@endsection
