@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center mt-5">
  <div class="col-md-4">
    <h2>Login</h2>
    <form class="mt-4" method="POST" action="{{ route('login') }}">
      @csrf
      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
      </div>
      <div class="mb-3">
        <label>Senha</label>
        <input type="password" name="password" class="form-control" required>
        @error('password') <div class="text-danger">{{ $message }}</div> @enderror
      </div>
      <button type="submit" class="btn btn-primary w-100">Entrar</button>
    </form>

    <div class="mt-3 text-center">
      <p>
        Não tem uma conta? 
        <a href="{{ route('register') }}">Cadastre-se</a>
      </p>
    </div>

  </div>
</div>
@endsection
