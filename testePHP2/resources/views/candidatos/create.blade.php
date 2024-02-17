@extends('layout.main')

@section('title', 'Cadastrar Novo Candidato')

@section('content')
<div class="container">
    <h1>Cadastrar Novo Candidato</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('candidatos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome') }}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
        </div>
        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('telefone') }}">
        </div>
        <div class="mb-3">
            <label for="qtdExp" class="form-label">Quantidade de Experiência</label>
            <input type="number" class="form-control" id="qtdExp" name="qtdExp" value="{{ old('qtdExp') }}">
        </div>
        <div class="mb-3">
            <label for="linguagens" class="form-label">Linguagens de Programação</label>
            <input type="text" class="form-control" id="linguagens" name="linguagens" value="{{ old('linguagens') }}">
        </div>
        <div class="mb-3">
            <label for="formacao" class="form-label">Formação</label>
            <select class="form-select" id="formacao" name="formacao">
                <option value="Ensino Médio Completo"
                    {{ old('formacao') == 'Ensino Médio Completo' ? 'selected' : '' }}>Ensino Médio Completo</option>
                <option value="Ensino Superior Em Andamento"
                    {{ old('formacao') == 'Ensino Superior Em Andamento' ? 'selected' : '' }}>Ensino Superior Em
                    Andamento</option>
                <option value="Ensino Superior Completo"
                    {{ old('formacao') == 'Ensino Superior Completo' ? 'selected' : '' }}>Ensino Superior Completo
                </option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
</div>
@endsection