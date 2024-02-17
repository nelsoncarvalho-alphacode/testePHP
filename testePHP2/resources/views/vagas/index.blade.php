@extends('layout.main')

@section('title', 'Listagem de Vagas')

@section('content')
<div class="container">
    <h1>Listagem de Vagas</h1>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->has('nome'))
    <div class="alert alert-danger">
        {{ $errors->first('nome') }}
    </div>
    @endif

    <form action="{{ route('vagas.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Filtrar por título" name="filtro_titulo"
                value="{{ request('filtro_titulo') }}">
            <select name="itens_por_pagina" id="itens_por_pagina" class="form-control" onchange="this.form.submit()">
                <option value="10" {{ request('itens_por_pagina') == 10 ? 'selected' : '' }}>10 por página</option>
                <option value="20" {{ request('itens_por_pagina') == 20 ? 'selected' : '' }}>20 por página</option>
                <option value="30" {{ request('itens_por_pagina') == 30 ? 'selected' : '' }}>30 por página</option>
            </select>
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
    </form>

    <a href="{{ route('vagas.create') }}" class="btn btn-primary mb-3">Criar Nova Vaga</a>
    <form id="delete-form" action="{{ route('vagas.deletar_em_massa') }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn mb-3 btn-danger"
            onclick="return confirm('Tem certeza que deseja excluir esta vaga?')">Excluir Vagas Selecionadar </button>
        <table class="table">
            <thead>
                <tr>
                    <th><a
                            href="{{ route('vagas.index', ['ordenar_por' => 'titulo', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">Título</a>
                    </th>
                    <th><a
                            href="{{ route('vagas.index', ['ordenar_por' => 'tipo', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">Tipo</a>
                    </th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vagas as $vaga)
                <tr>
                    <td class="titulo-vaga" style="cursor: pointer;">{{ $vaga->titulo }}</td>
                    <td>{{ $vaga->tipo }}</td>
                    <td>
                        <input type="checkbox" name="vagas_ids[]" value="{{ $vaga->id }}">
                        @if (!$vaga->pausada)
                        <a href="{{ route('vagas.edit', $vaga->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        <form action="{{ route('vagas.destroy', $vaga->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Tem certeza que deseja excluir esta vaga?')">Excluir</button>
                        </form>
                        <form action="{{ route('vagas.pausar', $vaga->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-warning">Pausar</button>
                        </form>
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                            data-target="#inscreverModal{{ $vaga->id }}">
                            Inscrever-se
                        </button>
                        <div class="modal fade" id="inscreverModal{{ $vaga->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="inscreverModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="inscreverModalLabel">Inscrever-se na vaga
                                            "{{ $vaga->titulo }}"</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('candidatos.inscrever', ['vagaId' => $vaga->id]) }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="vaga_id" value="{{ $vaga->id }}">
                                            <div class="form-group">
                                                <label for="nome">Nome</label>
                                                <input type="text"
                                                    class="form-control @error('nome') is-invalid @enderror" id="nome"
                                                    name="nome" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="telefone">Telefone</label>
                                                <input type="text"
                                                    class="form-control @error('telefone') is-invalid @enderror"
                                                    id="telefone" name="telefone" required>
                                                @error('telefone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                                    name="email" required>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <button type="submit" class="btn btn-primary">Confirmar inscrição</button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endif
                    </td>
                </tr>
                <tr class="descricao-vaga" style="display: none;">
                    <td colspan="3">{{ $vaga->descricao }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </form>

    <div class="pagination">
        <ul>
            @if($vagas->previousPageUrl())
            <li><a href="{{ $vagas->previousPageUrl() }}">Anterior</a></li>
            @endif
            @if($vagas->nextPageUrl())
            <li><a href="{{ $vagas->nextPageUrl() }}">Próxima</a></li>
            @endif
        </ul>
    </div>

</div>
@endsection