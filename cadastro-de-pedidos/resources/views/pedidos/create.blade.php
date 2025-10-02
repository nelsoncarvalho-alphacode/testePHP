@extends('layouts.app')

@section('title', 'Novo Pedido')

@section('content')
<h1>Novo Pedido</h1>

<form method="POST" action="{{ route('pedidos.store') }}">
    @csrf
    @include('pedidos.form')
</form>
@endsection
