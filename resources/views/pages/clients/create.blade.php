@extends('layout.base')

@section('content')
    <h1>Adicionar Cliente</h1>

    @include('components.alerts')

    <form action="{{ route('clients.store') }}" method="POST" id="cpfForm">
        @csrf
        <div class="mb-3">
            <label for="client_name" class="form-label">Nome</label>
            <input type="text" name="client_name" class="form-control" id="client_name" placeholder="Ex.: Camila Afonso" required>
        </div>
        <div class="mb-3">
            <label for="cpf" class="form-label">CPF Válido</label>
            <input type="text" name="cpf" class="form-control" id="cpf" placeholder="Ex.: 000.111.222-33" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Ex.: exemplo@exemplo.com" id="email">
        </div>
        <button type="submit" class="btn btn-primary">Confirmar</button>
    </form>
@endsection

@section('extraJs')
    <script src="{{ asset('js/validateCPF.js') }}"></script>
@endsection
