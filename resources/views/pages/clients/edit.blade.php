@extends('layout.base')

@section('content')
    @include('components.alerts')

    <h1>Editar Cliente</h1>
    <form action="{{ route('clients.update', $client->id) }}" method="POST" id="cpfForm">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="client_name" class="form-label">Nome</label>
            <input type="text" name="client_name" class="form-control" id="client_name" placeholder="Ex.: Camila Afonso" value="{{ $client->client_name }}"
                required>
        </div>
        <div class="mb-3">
            <label for="cpf" class="form-label">CPF Válido</label>
            <input type="text" name="cpf" class="form-control" id="cpf" placeholder="Ex.: 000.111.222-33" value="{{ $client->cpf }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Ex.: exemplo@exemplo.com" value="{{ $client->email }}">
        </div>
        <button type="submit" class="btn btn-warning">Atualizar</button>
    </form>
@endsection

@section('extraJs')
    <script src="{{ asset('js/validateCPF.js') }}"></script>
@endsection
