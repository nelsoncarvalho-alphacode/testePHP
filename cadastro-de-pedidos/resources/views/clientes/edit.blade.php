@extends('layouts.app')

@section('title','Editar Cliente')

@section('content')
<h1>Editar Cliente</h1>
<form method="POST" action="{{ route('clientes.update', $cliente) }}">
  @method('PUT')
  @include('clientes._form')
</form>
@endsection
