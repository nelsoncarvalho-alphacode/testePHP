@extends('layouts.app')

@section('title','Detalhes do Cliente')

@section('content')
<h1>Cliente: {{ $cliente->nome }}</h1>

<ul class="list-group mb-3">
  <li class="list-group-item"><strong>ID:</strong> {{ $cliente->id }}</li>
  <li class="list-group-item"><strong>Nome:</strong> {{ $cliente->nome }}</li>
  <li class="list-group-item"><strong>CPF:</strong> {{ $cliente->cpf }}</li>
  <li class="list-group-item"><strong>Email:</strong> {{ $cliente->email }}</li>
  <li class="list-group-item"><strong>Criado em:</strong> {{ $cliente->created_at }}</li>
</ul>

<a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning">Editar</a>
<a href="{{ route('clientes.index') }}" class="btn btn-secondary">Voltar</a>
@endsection
