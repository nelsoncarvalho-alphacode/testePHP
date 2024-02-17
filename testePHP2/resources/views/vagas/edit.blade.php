@extends('layout.main')

@section('title', 'Editar Vaga')

@section('content')
<div class="container">
    <h1>Editar Vaga</h1>
    <form method="POST" action="{{ route('vagas.update', $vaga->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="titulo">Título da Vaga:</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $vaga->titulo }}" required>
        </div>
        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="5" required>{{ $vaga->descricao }}</textarea>
        </div>
        <div class="form-group">
            <label for="tipo">Tipo de Vaga:</label>
            <select class="form-control" id="tipo" name="tipo" required>
                <option value="CLT" {{ $vaga->tipo == 'CLT' ? 'selected' : '' }}>CLT</option>
                <option value="Pessoa Jurídica" {{ $vaga->tipo == 'Pessoa Jurídica' ? 'selected' : '' }}>Pessoa Jurídica
                </option>
                <option value="Freelancer" {{ $vaga->tipo == 'Freelancer' ? 'selected' : '' }}>Freelancer</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
@endsection