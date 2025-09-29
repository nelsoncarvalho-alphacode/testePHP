@extends('layouts.app')

@section('title','Novo Cliente')

@section('content')
<h1>Novo Cliente</h1>
<form method="POST" action="{{ route('clientes.store') }}">
  @include('clientes._form')
</form>
@endsection
