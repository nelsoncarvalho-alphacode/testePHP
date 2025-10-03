@extends('layouts.app')

@section('title','Criar conta')
@section('page-title','Criar conta')
@section('page-subtitle','Acesse o sistema e gerencie Vagas e Candidatos')

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

        <form method="POST" action="{{ route('register') }}" novalidate>
          @csrf

          <div class="mb-3">
            <label class="form-label">Nome completo *</label>
            <input type="text" name="name" class="form-control" required
                   value="{{ old('name') }}" placeholder="Ex.: Allan Souki" autofocus>
          </div>

          <div class="mb-3">
            <label class="form-label">E-mail *</label>
            <input type="email" name="email" class="form-control" required
                   value="{{ old('email') }}" placeholder="voce@exemplo.com">
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Senha *</label>
              <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" required minlength="8" autocomplete="new-password">
                <button class="btn btn-outline-secondary" type="button" id="togglePass">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
              <div class="form-text" id="pwdHelp">
                Use ao menos 8 caracteres. Força: <span id="pwdStrength">—</span>
              </div>
            </div>

            <div class="col-md-6">
              <label class="form-label">Confirmar senha *</label>
              <div class="input-group">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required autocomplete="new-password">
                <button class="btn btn-outline-secondary" type="button" id="togglePass2">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
            </div>
          </div>

          <div class="form-check my-3">
            <input class="form-check-input" type="checkbox" value="1" id="terms" required>
            <label class="form-check-label" for="terms">
              Li e aceito os <a href="#" target="_blank">Termos de Uso</a>.
            </label>
          </div>

          <div class="d-flex align-items-center gap-2">
            <button class="btn btn-primary">
              <i class="bi bi-person-plus me-1"></i> Criar conta
            </button>
            <a href="" class="btn btn-outline-secondary">Já tenho conta</a>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/register.js') }}"></script>
@endpush
