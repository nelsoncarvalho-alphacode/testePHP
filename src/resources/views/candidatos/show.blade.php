@extends('layouts.app')

@section('title', 'Detalhes do Candidato')
@section('page-title', 'Detalhes do Candidato')
@section('page-subtitle', $candidato->nome)

@section('toolbar')
    <a href="{{ route('candidatos.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
    <a href="{{ route('candidatos.edit', $candidato) }}" class="btn btn-primary">
        <i class="bi bi-pencil"></i> Editar
    </a>
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-body">
        <h5 class="fw-bold">{{ $candidato->nome }}</h5>
        <p><strong>Email:</strong> {{ $candidato->email }}</p>
        <p><strong>Telefone:</strong> {{ $candidato->telefone ?? '—' }}</p>
        <p><strong>Criado em:</strong> {{ $candidato->created_at->format('d/m/Y H:i') }}</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Vagas inscritas</h5>
    </div>
    <div class="card-body">
        @if($candidato->vagas->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Tipo</th>
                            <th>Status</th>
                            <th>Data da Inscrição</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($candidato->vagas as $vaga)
                            <tr>
                                <td>{{ $vaga->id }}</td>
                                <td>{{ $vaga->titulo }}</td>
                                <td>{{ $vaga->tipo }}</td>
                                <td>
                                    <span class="badge {{ $vaga->status == 'ativa' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($vaga->status) }}
                                    </span>
                                </td>
                                <td>
                                    {{ $vaga->pivot->data_inscricao
                                        ? \Carbon\Carbon::parse($vaga->pivot->data_inscricao)->format('d/m/Y')
                                        : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted">Este candidato ainda não se inscreveu em nenhuma vaga.</p>
        @endif
    </div>
</div>
@endsection
