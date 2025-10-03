@extends('layouts.app')

@section('title', 'Nova Vaga')
@section('page-title', 'Cadastrar Vaga')
@section('page-subtitle', 'Preencha os campos abaixo para criar uma nova vaga')

@section('toolbar')
    <x-ui.button href="{{ route('vagas.index') }}" color="outline-secondary">
        <i class="bi bi-arrow-left"></i> Voltar
    </x-ui.button>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-body p-4">

                {{-- Exibe erros de validação --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Corrija os erros abaixo:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('vagas.store') }}">
                    @csrf

                    {{-- Título --}}
                    <div class="mb-3">
                        <label class="form-label">Título *</label>
                        <x-ui.input name="titulo" value="{{ old('titulo') }}" placeholder="Ex: Desenvolvedor PHP" />
                    </div>

                    {{-- Descrição --}}
                    <div class="mb-3">
                        <label class="form-label">Descrição *</label>
                        <textarea name="descricao" class="form-control" rows="4" required
                                  placeholder="Descreva as responsabilidades da vaga">{{ old('descricao') }}</textarea>
                    </div>

                    {{-- Tipo --}}
                    <div class="mb-3">
                        <label class="form-label">Tipo *</label>
                        <select name="tipo" class="form-select" required>
                            <option value="">Selecione</option>
                            <option value="CLT" {{ old('tipo') == 'CLT' ? 'selected' : '' }}>CLT</option>
                            <option value="PJ" {{ old('tipo') == 'PJ' ? 'selected' : '' }}>PJ</option>
                            <option value="Freelancer" {{ old('tipo') == 'Freelancer' ? 'selected' : '' }}>Freelancer</option>
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="ativa" {{ old('status') == 'ativa' ? 'selected' : '' }}>Ativa</option>
                            <option value="pausada" {{ old('status') == 'pausada' ? 'selected' : '' }}>Pausada</option>
                        </select>
                    </div>

                    {{-- Salário --}}
                    <div class="mb-3">
                        <label class="form-label">Salário (opcional)</label>
                        <x-ui.input type="number" step="0.01" name="salario" value="{{ old('salario') }}" placeholder="Ex: 3500.00" />
                    </div>

                    {{-- Botões --}}
                    <div class="d-flex gap-2">
                        <x-ui.button type="submit" color="primary">
                            <i class="bi bi-check-circle"></i> Salvar
                        </x-ui.button>

                        <x-ui.button href="{{ route('vagas.index') }}" color="outline-secondary">
                            Cancelar
                        </x-ui.button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
