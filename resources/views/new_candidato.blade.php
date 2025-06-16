@extends('layouts.main_layout')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-8">
                <div class="card p-5">

                    {{-- logo ou título --}}
                    <div class="text-center p-3">
                        <h1>Cadastre-se em Vagas</h1>
                    </div>

                    {{-- form --}}
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-12">
                            <form action="/newCandidatoSubmit" method="post" novalidate>
                                @csrf
                                <!-- nome -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Username</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                        placeholder="Digite seu nome completo" required>
                                    {{-- exibe erro --}}
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- email -->
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="email" class="form-control" name="username"
                                        value="{{ old('username') }}" placeholder="Digite seu e-mail" required>
                                    {{-- exibe erro --}}
                                    @error('username')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                {{-- senha --}}
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password"
                                        value="{{ old('password') }}" placeholder="Senha mín. 6 caracteres" required>
                                    {{-- exibe erro --}}
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Confirmar senha</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        placeholder="Confirme sua senha" required>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-success w-100">Enviar</button>
                                </div>
                            </form>

                            {{-- login inválido --}}
                            @if (session('loginError'))
                                <div class="alert alert-danger text-center">
                                    {{ session('loginError') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- copyright -->
                    <div class="text-center text-secondary mt-3">
                        <small>&copy; <?= date('Y') ?> Vagas</small>
                    </div>

                    {{-- erros --}}
                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul class="m-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
