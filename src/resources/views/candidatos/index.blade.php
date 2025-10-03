@extends('layouts.app')

@section('title', 'Candidatos')
@section('page-title', 'Gerenciar Candidatos')
@section('page-subtitle', 'Aqui você pode cadastrar e gerenciar candidatos')

@section('toolbar')
    {{-- Botão de cadastrar candidato --}}
    <x-ui.button href="{{ route('candidatos.create') }}" color="primary">
        <i class="bi bi-plus-circle"></i> Novo Candidato
    </x-ui.button>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Vagas inscritas</th>
                    <th>Criado em</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($candidatos as $candidato)
                    <tr>
                        <td>{{ $candidato->nome }}</td>
                        <td>{{ $candidato->email }}</td>
                        <td>{{ $candidato->telefone ?? '—' }}</td>
                        <td>
                            @if($candidato->vagas->count())
                                @foreach($candidato->vagas as $vaga)
                                    <span class="badge bg-secondary">{{ $vaga->titulo }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">Nenhuma vaga</span>
                            @endif
                        </td>
                        <td>{{ $candidato->created_at->format('d/m/Y') }}</td>
                        <td class="text-end">
                            <x-ui.button href="{{ route('candidatos.show', $candidato) }}" color="outline-secondary">
                                <i class="bi bi-eye"></i>
                            </x-ui.button>

                            <x-ui.button href="{{ route('candidatos.edit', $candidato) }}" color="outline-primary">
                                <i class="bi bi-pencil"></i>
                            </x-ui.button>

                            <form method="POST" action="{{ route('candidatos.destroy', $candidato) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <x-ui.button type="submit" color="outline-danger"
                                             onclick="return confirm('Tem certeza que deseja excluir este candidato?')">
                                    <i class="bi bi-trash"></i>
                                </x-ui.button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Nenhum candidato encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Paginação simples centralizada --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $candidatos->links() }}
        </div>
    </div>
</div>
@endsection
