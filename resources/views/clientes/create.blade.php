
@extends('layouts.app')
@section('title', 'Novo Cliente')
@section('content')
<h1>Novo Cliente</h1>
<form action="{{ route('clientes.store') }}" method="POST">
    @include('clientes.form')
    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection