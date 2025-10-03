@extends('layouts.app')

@section('title', 'Editar Vaga')
@section('page-title', 'Editar Vaga')
@section('page-subtitle', 'Altere os dados da vaga selecionada')

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

                {{-- Formulário de edição --}}
                <form method="POST" action="{{ route('vagas.update', $vaga) }}">
                    @csrf
                    @method('PUT')

                    {{-- Título --}}
                    <div class="mb-3">
                        <label class="form-label">Título *</label>
                        <x-ui.input name="titulo" value="{{ old('titulo', $vaga->titulo) }}" required />
                    </div>

                    {{-- Descrição --}}
                    <div class="mb-3">
                        <label class="form-label">Descrição *</label>
                        <textarea name="descricao" class="form-control" rows="4" required>{{ old('descricao', $vaga->descricao) }}</textarea>
                    </div>

                    {{-- Tipo --}}
                    <div class="mb-3">
                        <label class="form-label">Tipo *</label>
                        <select name="tipo" class="form-select" required>
                            <option value="">Selecione</option>
                            <option value="CLT" {{ old('tipo', $vaga->tipo) == 'CLT' ? 'selected' : '' }}>CLT</option>
                            <option value="PJ" {{ old('tipo', $vaga->tipo) == 'PJ' ? 'selected' : '' }}>PJ</option>
                            <option value="Freelancer" {{ old('tipo', $vaga->tipo) == 'Freelancer' ? 'selected' : '' }}>Freelancer</option>
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label">Status *</label>
                        <select name="status" class="form-select" required>
                            <option value="ativa" {{ old('status', $vaga->status) == 'ativa' ? 'selected' : '' }}>Ativa</option>
                            <option value="pausada" {{ old('status', $vaga->status) == 'pausada' ? 'selected' : '' }}>Pausada</option>
                        </select>
                    </div>

                    {{-- Salário --}}
                    <div class="mb-3">
                        <label class="form-label">Salário</label>
                        <x-ui.input type="number" step="0.01" name="salario" value="{{ old('salario', $vaga->salario) }}" />
                    </div>

                    {{-- Botões --}}
                    <div class="d-flex justify-content-between">
                        <x-ui.button href="{{ route('vagas.index') }}" color="outline-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </x-ui.button>

                        <x-ui.button type="submit" color="success">
                            <i class="bi bi-check-circle"></i> Salvar Alterações
                        </x-ui.button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
