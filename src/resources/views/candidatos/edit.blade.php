@extends('layouts.app')

@section('title', 'Editar Candidato')
@section('page-title', 'Editar Candidato')
@section('page-subtitle', 'Atualize os dados do candidato')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
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

                {{-- Formulário --}}
                <form method="POST" action="{{ route('candidatos.update', $candidato->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- Nome --}}
                    <div class="mb-3">
                        <label class="form-label">Nome *</label>
                        <x-ui.input name="nome" value="{{ old('nome', $candidato->nome) }}" required />
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label">E-mail *</label>
                        <x-ui.input type="email" name="email" value="{{ old('email', $candidato->email) }}" required />
                    </div>

                    {{-- Telefone --}}
                    <div class="mb-3">
                        <label class="form-label">Telefone</label>
                        <x-ui.input name="telefone" value="{{ old('telefone', $candidato->telefone) }}" />
                    </div>

                    {{-- Currículo --}}
                    <div class="mb-3">
                        <label class="form-label">Currículo</label>
                        <textarea name="curriculo" rows="3" class="form-control"
                                  placeholder="Link ou resumo do currículo">{{ old('curriculo', $candidato->curriculo) }}</textarea>
                    </div>

                    {{-- Vagas associadas (somente ativas) --}}
                    <div class="mb-3">
                        <label class="form-label">Vagas disponíveis</label>

                        @if($vagas->count())
                            <div class="d-flex flex-wrap gap-3">
                                @foreach($vagas as $vaga)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                               name="vagas[]" value="{{ $vaga->id }}"
                                               {{ in_array($vaga->id, old('vagas', $candidato->vagas->pluck('id')->toArray())) ? 'checked' : '' }}>
                                        <label class="form-check-label">
                                            {{ $vaga->titulo }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">Nenhuma vaga ativa no momento.</p>
                        @endif
                    </div>

                    {{-- Botões --}}
                    <div class="d-flex align-items-center gap-2">
                        <x-ui.button type="submit" color="primary">
                            <i class="bi bi-save me-1"></i> Salvar Alterações
                        </x-ui.button>

                        <x-ui.button href="{{ route('candidatos.index') }}" color="outline-secondary">
                            Cancelar
                        </x-ui.button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
