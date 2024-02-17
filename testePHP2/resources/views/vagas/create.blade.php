@extends('layout.main')

@section('title', 'Criar Nova Vaga')

@section('content')
<div class="container">
    <h1>Criar Nova Vaga</h1>
    <form method="POST" action="{{ route('vagas.store') }}">
        @csrf
        <div class="form-group">
            <label for="titulo">Título da Vaga:</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required>
        </div>
        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="tipo">Tipo de Vaga:</label>
            <select class="form-control" id="tipo" name="tipo" required>
                <option value="CLT">CLT</option>
                <option value="Pessoa Jurídica">Pessoa Jurídica</option>
                <option value="Freelancer">Freelancer</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
@endsection