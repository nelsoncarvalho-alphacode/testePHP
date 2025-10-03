@extends('layouts.app')

@section('title', 'Inscrições')
@section('page-title', 'Gerenciar Inscrições')
@section('page-subtitle', 'Lista de candidatos vinculados às vagas')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title mb-0">Inscrições</h5>
            <x-ui.button href="{{ route('inscricoes.create') }}" color="success">
                <i class="bi bi-plus-lg"></i> Nova Inscrição
            </x-ui.button>
        </div>

        {{-- Mensagens de sucesso/erro --}}
        @if(session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
            </div>
        @endif

        {{-- Tabela --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Candidato</th>
                        <th>Vaga</th>
                        <th>Data da Inscrição</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inscricoes as $inscricao)
                        <tr>
                            <td>{{ $inscricao->id }}</td>
                            <td>{{ $inscricao->candidato->nome }}</td>
                            <td>{{ $inscricao->vaga->titulo }}</td>
                            <td>{{ $inscricao->data_inscricao }}</td>
                            <td class="text-end">
                                <x-ui.button href="{{ route('inscricoes.show', $inscricao) }}" color="outline-secondary">
                                    <i class="bi bi-eye"></i> Detalhes
                                </x-ui.button>

                                <x-ui.button href="{{ route('inscricoes.edit', $inscricao->id) }}" color="outline-primary">
                                    <i class="bi bi-pencil"></i> Editar
                                </x-ui.button>

                                <form action="{{ route('inscricoes.destroy', $inscricao->id) }}" method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Tem certeza que deseja excluir esta inscrição?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-ui.button type="submit" color="outline-danger">
                                        <i class="bi bi-trash"></i> Excluir
                                    </x-ui.button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Nenhuma inscrição encontrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginação --}}
        <div class="mt-3">
            {{ $inscricoes->links() }}
        </div>
    </div>
</div>
@endsection
