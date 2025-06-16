@extends('layouts.main_layout')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-8">
                <div class="card p-5">

                    {{-- logo ou título --}}
                    <div class="text-center p-3">
                        <h1>Vagas</h1>
                    </div>

                    {{-- form --}}
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-12">
                            <form action="/loginSubmit" method="post" novalidate>
                                @csrf
                                <!-- email -->
                                <div class="mb-3">
                                    <label for="text_username" class="form-label">Username</label>
                                    <input type="email" class="form-control" name="text_username"
                                        value="{{ old('text_username') }}" required>
                                    {{-- exibe erro --}}
                                    @error('text_username')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- senha --}}
                                <div class="mb-3">
                                    <label for="text_password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="text_password"
                                        value="{{ old('text_password') }}" required>
                                    {{-- exibe erro --}}
                                    @error('text_password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="candidato_empresa"
                                            id="candidatoInput" value="candidato" checked>
                                        <label class="form-check-label" for="candidatoInput">
                                            Candidato
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="candidato_empresa"
                                            id="empresaInput" value="empresa">
                                        <label class="form-check-label" for="empresaInput">
                                            Empresa
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <button type="submit" class="btn btn-primary w-100">Login</button>
                                </div>
                                <div class="mb-3">
                                    <a href="{{ route('newCandidato') }}" class="btn btn-secondary w-100">Cadastre-se</a>
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
