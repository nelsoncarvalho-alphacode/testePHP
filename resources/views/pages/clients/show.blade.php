@extends('layout.base')

@section('content')
<div class="container">
    <h1>Detalhes do Cliente</h1>
    <div class="card">
        <div class="card-header">
            {{ $client->client_name }}
        </div>
        <div class="card-body">
            <p><strong>CPF:</strong> {{ $client->cpf }}</p>
            <p><strong>Email:</strong> {{ $client->email }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('clients.index') }}" class="btn btn-secondary">Retornar</a>
        </div>
    </div>
</div>
@endsection
