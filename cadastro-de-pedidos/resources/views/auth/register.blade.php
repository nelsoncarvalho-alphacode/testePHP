@extends('layouts.app')

@section('title', 'Registrar')

@section('content')
<div class="row justify-content-center mt-5">
  <div class="col-md-4">
    <h2>Registrar</h2>
    <form method="POST" action="{{ route('register') }}">
      @csrf
      <div class="mb-3">
        <label>Nome</label>
        <input type="text" name="name" class="form-control" required>
        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
      </div>
      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
      </div>
      <div class="mb-3">
        <label>Senha</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Confirmar Senha</label>
        <input type="password" name="password_confirmation" class="form-control" required>
        @error('password') <div class="text-danger">{{ $message }}</div> @enderror
      </div>
      <button type="submit" class="btn btn-success w-100">Registrar</button>
    </form>

    <div class="mt-3 text-center">
      <p>
        Já tem uma conta? 
        <a href="{{ route('login') }}">Login</a>
      </p>
    </div>

</div>
@endsection
