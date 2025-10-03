@extends('layouts.app')

@section('title', 'Detalhes da Inscrição')
@section('page-title', 'Detalhes da Inscrição')
@section('page-subtitle', 'ID #' . $inscricao->id)

@section('toolbar')
    <a href="{{ route('inscricoes.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
    <a href="{{ route('inscricoes.edit', $inscricao) }}" class="btn btn-primary">
        <i class="bi bi-pencil"></i> Editar
    </a>
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-body">
        <h5 class="fw-bold">Inscrição #{{ $inscricao->id }}</h5>
        <p><strong>Data da inscrição:</strong>
           {{ $inscricao->data_inscricao ? \Carbon\Carbon::parse($inscricao->data_inscricao)->format('d/m/Y H:i') : '-' }}
        </p>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header"><h6 class="mb-0">Candidato</h6></div>
            <div class="card-body">
                <p><strong>Nome:</strong> {{ $inscricao->candidato->nome }}</p>
                <p><strong>Email:</strong> {{ $inscricao->candidato->email }}</p>
                <p><strong>Telefone:</strong> {{ $inscricao->candidato->telefone ?? '—' }}</p>
                <p><strong>Currículo:</strong>
                    @if($inscricao->candidato->curriculo)
                        <a href="{{ $inscricao->candidato->curriculo }}" target="_blank">Ver currículo</a>
                    @else
                        <span class="text-muted">Não informado</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-6 mt-3 mt-md-0">
        <div class="card h-100">
            <div class="card-header"><h6 class="mb-0">Vaga</h6></div>
            <div class="card-body">
                <p><strong>Título:</strong> {{ $inscricao->vaga->titulo }}</p>
                <p><strong>Tipo:</strong> {{ $inscricao->vaga->tipo }}</p>
                <p><strong>Status:</strong>
                    <span class="badge {{ $inscricao->vaga->status === 'ativa' ? 'bg-success' : 'bg-secondary' }}">
                        {{ ucfirst($inscricao->vaga->status) }}
                    </span>
                </p>
                <p><strong>Salário:</strong>
                    @if($inscricao->vaga->salario)
                        R$ {{ number_format($inscricao->vaga->salario, 2, ',', '.') }}
                    @else
                        <span class="text-muted">Não informado</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
