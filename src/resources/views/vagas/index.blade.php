@extends('layouts.app')

@section('title', 'Vagas')
@section('page-title', 'Gerenciar Vagas')
@section('page-subtitle', 'Aqui você pode cadastrar e gerenciar vagas')

@section('toolbar')
    {{-- Botão de cadastrar vaga --}}
    <x-ui.button href="{{ route('vagas.create') }}" color="primary">
        <i class="bi bi-plus-circle"></i> Nova Vaga
    </x-ui.button>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Tipo</th>
                    <th>Status</th>
                    <th>Salário</th>
                    <th>Criada em</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vagas as $vaga)
                    <tr>
                        <td>{{ $vaga->titulo }}</td>
                        <td>{{ $vaga->tipo }}</td>
                        <td>
                            <span class="badge {{ $vaga->status == 'ativa' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($vaga->status) }}
                            </span>
                        </td>
                        <td>
                            @if($vaga->salario)
                                R$ {{ number_format($vaga->salario, 2, ',', '.') }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ $vaga->created_at->format('d/m/Y') }}</td>
                        <td class="text-end">
                            <x-ui.button href="{{ route('vagas.edit', $vaga) }}" color="outline-primary">
                                <i class="bi bi-pencil"></i>
                            </x-ui.button>

                            <form method="POST" action="{{ route('vagas.destroy', $vaga) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <x-ui.button type="submit" color="outline-danger"
                                             onclick="return confirm('Tem certeza que deseja excluir esta vaga?')">
                                    <i class="bi bi-trash"></i>
                                </x-ui.button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Nenhuma vaga encontrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center mt-3">
            {{ $vagas->links() }}
        </div>
    </div>
</div>
@endsection
