@extends('layouts.app')

@section('title', 'Nova Inscrição')
@section('page-title', 'Cadastrar Inscrição')
@section('page-subtitle', 'Selecione um candidato já existente e vincule a uma vaga')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-3">Nova Inscrição</h5>

        {{-- Exibe erros de validação --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle"></i> Corrija os erros abaixo:
                <ul class="mt-2 mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('inscricoes.store') }}" method="POST">
            @csrf

            {{-- Selecionar candidato --}}
            <div class="mb-3">
                <label for="candidato_id" class="form-label">Candidato <span class="text-danger">*</span></label>
                <select name="candidato_id" id="candidato_id"
                        class="form-select @error('candidato_id') is-invalid @enderror">
                    <option value="">-- Selecione um candidato --</option>
                    @foreach($candidatos as $candidato)
                        <option value="{{ $candidato->id }}" {{ old('candidato_id') == $candidato->id ? 'selected' : '' }}>
                            {{ $candidato->nome }} ({{ $candidato->email }})
                        </option>
                    @endforeach
                </select>
                @error('candidato_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Selecionar vaga --}}
            <div class="mb-3">
                <label for="vaga_id" class="form-label">Vaga <span class="text-danger">*</span></label>
                <select name="vaga_id" id="vaga_id"
                        class="form-select @error('vaga_id') is-invalid @enderror" required>
                    <option value="">-- Selecione uma vaga --</option>
                    @foreach($vagas as $vaga)
                        <option value="{{ $vaga->id }}" {{ old('vaga_id') == $vaga->id ? 'selected' : '' }}>
                            {{ $vaga->titulo }} - {{ $vaga->tipo }}
                        </option>
                    @endforeach
                </select>
                @error('vaga_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Botões --}}
            <div class="d-flex justify-content-between">
                <x-ui.button href="{{ route('inscricoes.index') }}" color="outline-secondary">
                    <i class="bi bi-arrow-left"></i> Voltar
                </x-ui.button>

                <x-ui.button type="submit" color="success">
                    <i class="bi bi-check-lg"></i> Salvar
                </x-ui.button>
            </div>
        </form>
    </div>
</div>
@endsection
