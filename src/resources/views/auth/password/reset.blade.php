@extends('layouts.app')

@section('title','Definir nova senha')
@section('page-title','Redefinir senha')
@section('page-subtitle','Digite sua nova senha para acessar o sistema')

@section('content')
<div class="row justify-content-center">
  <div class="col-12 col-md-8 col-lg-6">
    <div class="card shadow-sm border-0 rounded-4">
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

        <form method="POST" action="{{ route('password.update') }}" novalidate>
          @csrf
          {{-- Token obrigatório --}}
         <input type="hidden" name="token" value="{{ $token }}">

          {{-- E-mail --}}
          <div class="mb-3">
            <label class="form-label fw-bold">E-mail</label>
            <input type="email" name="email" class="form-control form-control-lg" required
                   value="{{ old('email', $email ?? '') }}" placeholder="voce@exemplo.com" autofocus>
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">Nova senha</label>
              <div class="input-group">
                <input type="password" name="password" id="password" class="form-control form-control-lg" required minlength="8" autocomplete="new-password">
                <button class="btn btn-outline-secondary" type="button" id="togglePass">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
              <div class="form-text">Mínimo 8 caracteres</div>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Confirmar senha</label>
              <div class="input-group">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg" required autocomplete="new-password">
                <button class="btn btn-outline-secondary" type="button" id="togglePass2">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
            </div>
          </div>

          <div class="d-grid gap-2 mt-4">
            <button class="btn btn-primary btn-lg">
              <i class="bi bi-key me-1"></i> Atualizar senha
            </button>
            <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg">
              <i class="bi bi-box-arrow-in-left me-1"></i> Voltar ao login
            </a>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')

<script src="{{ asset('js/resetSenha.js') }}"></script>
@endpush
