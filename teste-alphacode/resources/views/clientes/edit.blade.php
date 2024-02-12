@extends('layouts.main')

@section('title', 'Produtos')

@section('content')

<div>
  <div class="my-5">
    <h3>
      Editar Cliente
    </h3>
  </div>
  <form action="{{route('cliente.update', $client->id)}}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
      <label for="nome" class="form-label" >Nome</label>
      <input type="text" class="form-control" id="nome" name="nome" value="{{$client->nome}}" required>
    </div>
    <div class="mb-3">
      <label for="cpf" class="form-label" >CPF</label>
      <input type="text" class="form-control" id="cpf" name="cpf" value="{{$client->cpf}}" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label" >Email</label>
      <input type="text" class="form-control" id="email" name="email" value="{{$client->email}}" required>
    </div>
    <div class="text-center">
      <button type="submit" class="btn btn-primary w-25 mt-3">Salvar</button>
    </div>
  </form>
</div>

@endsection