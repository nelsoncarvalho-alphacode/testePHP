
@extends('layouts.app')
@section('title', 'Editar Cliente')
@section('content')
<h1>Editar Cliente</h1>
<form action="{{ route('clientes.update', $cliente) }}" method="POST">
    @method('PUT')
    @include('clientes.form')
    <button type="submit" class="btn btn-success">Atualizar</button>
    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection