@extends('layouts.app')

@section('title','Login')
@section('page-title','Acessar conta')
@section('page-subtitle','Entre para gerenciar Vagas e Candidatos')

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

        <form method="POST" action="{{ route('login') }}" novalidate>
          @csrf

          {{-- E-mail --}}
          <div class="mb-3">
            <label class="form-label">E-mail *</label>
            <input type="email" name="email" class="form-control" required
                   value="{{ old('email') }}" placeholder="voce@exemplo.com" autofocus>
          </div>

          {{-- Senha --}}
          <div class="mb-3">
            <label class="form-label">Senha *</label>
            <div class="input-group">
              <input type="password" name="password" id="password" class="form-control" required autocomplete="current-password">
              <button class="btn btn-outline-secondary" type="button" id="togglePass">
                <i class="bi bi-eye"></i>
              </button>
            </div>
          </div>

          {{-- Lembrar-me --}}

          <div class="d-flex align-items-center gap-2">
            <button class="btn btn-primary">
              <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
            </button>
            <a href="{{ route('register') }}" class="btn btn-outline-secondary">
              Criar conta
            </a>
          </div>

          <div class="mt-3">
            <a href="{{ route('password.request') }}" class="small">Esqueci minha senha</a>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/loginSenha.js') }}"></script>
@endpush
