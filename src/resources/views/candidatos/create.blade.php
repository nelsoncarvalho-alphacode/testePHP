@extends('layouts.app')

@section('title', 'Novo Candidato')
@section('page-title', 'Cadastrar Candidato')
@section('page-subtitle', 'Preencha os dados para adicionar um novo candidato')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-body p-4">
                {{-- Erros de validação --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Corrija os erros abaixo:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Formulário do Candidato --}}
                <form method="POST" action="{{ route('candidatos.store') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Nome --}}
                    <div class="mb-3">
                        <label class="form-label">Nome *</label>
                        <x-ui.input name="nome" value="{{ old('nome') }}" required />
                    </div>

                    {{-- E-mail --}}
                    <div class="mb-3">
                        <label class="form-label">E-mail *</label>
                        <x-ui.input type="email" name="email" value="{{ old('email') }}" required />
                    </div>

                    {{-- Telefone --}}
                    <div class="mb-3">
                        <label class="form-label">Telefone</label>
                        <x-ui.input name="telefone" value="{{ old('telefone') }}" />
                    </div>

                    {{-- Currículo --}}
                    <div class="mb-3">
                        <label class="form-label">Currículo (PDF)</label>
                        <x-ui.input type="text" name="curriculo" accept="application/pdf" />
                    </div>

                    {{-- Vagas inscritas --}}
                    <div class="mb-3">
                        <label class="form-label">Inscrição em Vagas</label>
                        @if($vagas->count())
                            <div class="d-flex flex-wrap gap-3">
                                @foreach($vagas as $vaga)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                               name="vagas[]" value="{{ $vaga->id }}"
                                               {{ in_array($vaga->id, old('vagas', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label">
                                            {{ $vaga->titulo }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">Nenhuma vaga disponível no momento.</p>
                        @endif
                    </div>

                    {{-- Botões --}}
                    <div class="d-flex justify-content-between">
                        <x-ui.button href="{{ route('candidatos.index') }}" color="outline-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </x-ui.button>

                        <x-ui.button type="submit" color="success">
                            <i class="bi bi-check-circle"></i> Salvar Candidato
                        </x-ui.button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
