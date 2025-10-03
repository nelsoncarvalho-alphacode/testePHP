@extends('layouts.app')

@section('title','Redefinir senha')
@section('page-title','Esqueci minha senha')
@section('page-subtitle','Informe seu e-mail para receber o link de redefinição')

@section('content')
<div class="row justify-content-center">
  <div class="col-12 col-md-8 col-lg-6">
    <div class="card shadow-sm border-0 rounded-4">
      <div class="card-body p-4">

        {{-- Mensagem de status --}}
        @if (session('status'))
          <div class="alert alert-success">
            {{ session('status') }}
          </div>
        @endif

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

        <form method="POST" action="{{route('password.email')}}" novalidate>
          @csrf

          {{-- E-mail --}}
          <div class="mb-3">
            <label class="form-label fw-bold">E-mail cadastrado</label>
            <input type="email" name="email" class="form-control form-control-lg" required
                   value="{{ old('email') }}" placeholder="voce@exemplo.com" autofocus>
          </div>

          <div class="d-grid gap-2">
            <button class="btn btn-primary btn-lg">
              <i class="bi bi-envelope-at me-1"></i> Enviar link de redefinição
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
