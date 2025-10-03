@extends('layouts.app')
@section('title', 'Detalhes da Vaga')
@section('page-title', 'Detalhes da Vaga')
@section('toolbar')

    <a href="{{ route('vagas.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
    <a href="{{ route('vagas.edit', $vaga) }}" class="btn btn-primary">
        <i class="bi bi-pencil"></i> Editar Vaga
    </a>
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-body">
        <h4 class="fw-bold">{{ $vaga->titulo }}</h4>
        <p class="mb-1"><strong>Tipo:</strong> {{ $vaga->tipo }}</p>
        <p class="mb-1">
            <strong>Status:</strong>
            <span class="badge {{ $vaga->status === 'ativa' ? 'bg-success' : 'bg-secondary' }}">
                {{ ucfirst($vaga->status) }}
            </span>
        </p>
        <p class="mb-1"><strong>Salário:</strong>
            @if($vaga->salario)
                R$ {{ number_format($vaga->salario, 2, ',', '.') }}
            @else
                <span class="text-muted">Não informado</span>
            @endif
        </p>
        <p class="mb-0"><strong>Descrição:</strong> {{ $vaga->descricao }}</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Candidatos inscritos nesta vaga</h5>
    </div>
    <div class="card-body">
        @if($vaga->candidatos->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Data da Inscrição</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vaga->candidatos as $candidato)
                            <tr>
                                <td>{{ $candidato->id }}</td>
                                <td>{{ $candidato->nome }}</td>
                                <td>{{ $candidato->email }}</td>
                                <td>{{ $candidato->telefone ?? '—' }}</td>
                                <td>
                                    {{ $candidato->pivot->data_inscricao
                                ? \Carbon\Carbon::parse($candidato->pivot->data_inscricao)->format('d/m/Y')
                                : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted">Nenhum candidato inscrito nesta vaga.</p>
        @endif
    </div>
</div>
@endsection
