@extends('layouts.app')

@section('title','Clientes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1>Clientes</h1>
  <a href="{{ route('clientes.create') }}" class="btn btn-primary">Novo Cliente</a>
</div>

@include('clientes.partials._filter_form')

@include('clientes.partials._clientes_table')

<div class="d-flex justify-content-between align-items-center">
  <div>Mostrando {{ $clientes->count() }} de {{ $clientes->total() }} registros</div>
  <div>{{ $clientes->withQueryString()->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
