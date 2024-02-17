@extends('layout.main')

@section('title', 'Editar Candidato')

@section('content')
<div class="container">
    <h1>Editar Candidato</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('candidatos.update', $candidato->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" value="{{ $candidato->nome }}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $candidato->email }}">
        </div>
        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="text" class="form-control" id="telefone" name="telefone" value="{{ $candidato->telefone }}">
        </div>
        <div class="mb-3">
            <label for="qtdExp" class="form-label">Quantidade de Experiência</label>
            <input type="number" class="form-control" id="qtdExp" name="qtdExp" value="{{ $candidato->qtdExp }}">
        </div>
        <div class="mb-3">
            <label for="linguagens" class="form-label">Linguagens de Programação</label>
            <input type="text" class="form-control" id="linguagens" name="linguagens"
                value="{{ $candidato->linguagens }}">
        </div>
        <div class="mb-3">
            <label for="formacao" class="form-label">Formação</label>
            <select class="form-select" id="formacao" name="formacao">
                <option value="Ensino Médio Completo"
                    {{ $candidato->formacao == 'Ensino Médio Completo' ? 'selected' : '' }}>Ensino Médio Completo
                </option>
                <option value="Ensino Superior Em Andamento"
                    {{ $candidato->formacao == 'Ensino Superior Em Andamento' ? 'selected' : '' }}>Ensino Superior Em
                    Andamento</option>
                <option value="Ensino Superior Completo"
                    {{ $candidato->formacao == 'Ensino Superior Completo' ? 'selected' : '' }}>Ensino Superior Completo
                </option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>
@endsection