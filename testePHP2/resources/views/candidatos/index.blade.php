@extends('layout.main')

@section('title', 'Lista de Candidatos')

@section('content')
<div class="container">
    <h1>Lista de Candidatos</h1>

    <a href="{{ route('candidatos.create') }}" class="btn btn-primary mb-3">Cadastrar Novo Candidato</a>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('candidatos.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Filtrar por nome" name="filtro_nome" value="{{ request('filtro_nome') }}">
            <select name="itens_por_pagina" id="itens_por_pagina" class="form-control" onchange="this.form.submit()">
                <option value="10" {{ request('itens_por_pagina') == 10 ? 'selected' : '' }}>10 por página</option>
                <option value="20" {{ request('itens_por_pagina') == 20 ? 'selected' : '' }}>20 por página</option>
            </select>
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
    </form>

    <form id="delete-form" action="{{ route('candidatos.deletar_em_massa') }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger mb-3" onclick="return confirm('Tem certeza que deseja excluir os candidatos selecionados?')">Excluir Candidatos
            Selecionados</button>
        <table class="table">
            <thead>
                <tr>
                    <th><a href="{{ route('candidatos.index', ['ordenar_por' => 'nome', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">Nome</a>
                    </th>
                    <th><a href="{{ route('candidatos.index', ['ordenar_por' => 'email', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">Email</a>
                    </th>
                    <th><a href="{{ route('candidatos.index', ['ordenar_por' => 'telefone', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">Telefone</a>
                    </th>
                    <th>N° Candidaturas</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($candidatos as $candidato)
                <tr>
                    <td class="nome-candidato" style="cursor: pointer;">{{ $candidato->nome }}</td>
                    <td>{{ $candidato->email }}</td>
                    <td>{{ $candidato->telefone }}</td>
                    <td>{{ $candidato->vagas_count }}</td>
                    <td>
                        <input type="checkbox" name="candidatos_ids[]" value="{{ $candidato->id }}">
                        <a href="{{ route('candidatos.edit', $candidato->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        <form action="{{ route('candidatos.destroy', $candidato->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este candidato?')">Excluir</button>
                        </form>
                    </td>
                </tr>
                <tr class="info-candidato" style="display: none;">
                    <td colspan="4">
                        <p>Anos de Experiência: {{ $candidato->qtdExp }}</p>
                        <p>Linguagens: {{ $candidato->linguagens }}</p>
                        <p>Formação: {{ $candidato->formacao }}</p>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </form>

    <div class="pagination">
        <ul>
            @if($candidatos->previousPageUrl())
            <li><a href="{{ $candidatos->previousPageUrl() }}">Anterior</a></li>
            @endif
            @if($candidatos->nextPageUrl())
            <li><a href="{{ $candidatos->nextPageUrl() }}">Próxima</a></li>
            @endif
        </ul>
    </div>

</div>
@endsection