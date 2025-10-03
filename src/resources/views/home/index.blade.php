@extends('layouts.app')

@section('title', 'Início')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Resumo geral do sistema')
@section('content')
<div class="row g-3 mb-4">
    <!-- Estatísticas -->
    <div class="col-md-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="bi bi-briefcase-fill fs-3 text-primary"></i>
                <h6 class="mt-2">Vagas</h6>
                <h4 class="fw-bold">{{ $totalVagas }}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="bi bi-people-fill fs-3 text-success"></i>
                <h6 class="mt-2">Candidatos</h6>
                <h4 class="fw-bold">{{ $totalCandidatos }}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="bi bi-pencil-square fs-3 text-warning"></i>
                <h6 class="mt-2">Inscrições</h6>
                <h4 class="fw-bold">{{ $totalInscricoes }}</h4>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="bi bi-hdd-network fs-3 text-success"></i>
                <h6 class="mt-2">Status do sistema</h6>
                <span class="badge bg-success">Online</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Boas-vindas -->
    <div class="col-12 col-lg-6">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Bem-vindo!</h5>
                <p class="card-text">
                    Utilize o menu superior ou os atalhos ao lado para acessar rapidamente
                    <strong>Vagas</strong>, <strong>Candidatos</strong> e <strong>Inscrições</strong>.
                </p>
            </div>
        </div>
    </div>

    <!-- Atalhos rápidos -->
    <div class="col-12 col-lg-6">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Atalhos rápidos</h5>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('vagas.index') }}" class="btn btn-primary">
                        <i class="bi bi-briefcase"></i> Vagas
                    </a>
                    <a href="{{ route('candidatos.index') }}" class="btn btn-secondary">
                        <i class="bi bi-people"></i> Candidatos
                    </a>
                    <a href="{{ route('inscricoes.index') }}" class="btn btn-success">
                        <i class="bi bi-pencil-square"></i> Inscrições
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Últimas atividades -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Últimas atividades</h5>

                <ul class="list-unstyled">
                    {{-- Última vaga --}}
                    @foreach($ultimasVagas as $vaga)
                    <li class="d-flex mb-3">
                        <div class="me-3">
                            <span class="badge rounded-pill bg-primary p-3">
                                <i class="bi bi-briefcase"></i>
                            </span>
                        </div>
                        <div>
                            <div class="fw-semibold">Nova vaga criada</div>
                            <small class="text-muted">
                                {{ $vaga->titulo }} • {{ $vaga->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </li>
                    @endforeach

                    {{-- Último candidato --}}
                    @foreach($ultimosCandidatos as $candidato)
                    <li class="d-flex mb-3">
                        <div class="me-3">
                            <span class="badge rounded-pill bg-success p-3">
                                <i class="bi bi-person-plus"></i>
                            </span>
                        </div>
                        <div>
                            <div class="fw-semibold">Novo candidato cadastrado</div>
                            <small class="text-muted">
                                {{ $candidato->nome }} • {{ $candidato->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </li>
                    @endforeach

                    {{-- Última inscrição --}}
                    @if($ultimaInscricao)
                        <li class="d-flex mb-3">
                            <div class="me-3">
                                <span class="badge rounded-pill bg-warning p-3">
                                    <i class="bi bi-pencil-square"></i>
                                </span>
                            </div>
                            <div>
                                <div class="fw-semibold">Inscrição realizada</div>
                                <small class="text-muted">
                                    {{ $ultimaInscricao->candidato->nome ?? 'Candidato desconhecido' }}
                                    se inscreveu para
                                    {{ $ultimaInscricao->vaga->titulo ?? 'Vaga desconhecida' }}
                                    • {{ \Carbon\Carbon::parse($ultimaInscricao->data_inscricao)->diffForHumans() }}
                                </small>
                            </div>
                        </li>
                        @endif

                    {{-- Último login --}}
                    <li class="d-flex">
                        <div class="me-3">
                            <span class="badge rounded-pill bg-secondary p-3">
                                <i class="bi bi-clock-history"></i>
                            </span>
                        </div>
                        <div>
                            <div class="fw-semibold">Último login</div>
                            <small class="text-muted">Você acessou em {{ now()->format('d/m/Y H:i') }}</small>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
