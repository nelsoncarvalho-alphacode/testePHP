@extends('layouts.main_layout')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col">
                @include('top_bar')

                {{-- label e cancelar --}}
                <div class="row">
                    <div class="col">
                        <p class="display-6 mb-0">EDITAR CANDIDATO</p>
                    </div>
                    <div class="col text-end">
                        <a href="{{ route('home') }}" class="btn btn-outline-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-x-lg" viewBox="0 0 16 16">
                                <path
                                    d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- form -->
                <form action="{{ route('editCandidatoSubmit') }}" method="post" novalidate>
                    @csrf
                    <input type="hidden" name="candidato_id" value="{{ Crypt::encrypt($candidato->id) }}">
                    <div class="row mt-3">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Nome</label>
                                <input type="text" class="form-control" name="name"
                                    value="{{ old('name', $candidato->name) }}" placeholder="Digite seu nome completo"
                                    required>
                                {{-- mostrar erro --}}
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="email" class="form-control" name="username"
                                    value="{{ old('username', $candidato->username) }}" placeholder="Digite seu e-mail"
                                    required>
                                {{-- mostrar erro --}}
                                @error('username')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Senha</label>
                                <input type="password" class="form-control" name="password"
                                    placeholder="Senha mín. 6 caractres" required>
                                {{-- mostrar erro --}}
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirmar senha</label>
                                <input type="password" class="form-control" name="password_confirmation"
                                    placeholder="Confirme sua senha" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-auto text-start">
                            <a href="{{ route('deleteCandidato', ['id' => Crypt::encrypt($candidato['id'])]) }}" class="btn btn-danger mx-1 d-flex align-items-center">
                                {{-- link para excluir conta --}}
                                <span class="me-1">Excluir conta</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                </svg>
                            </a>
                        </div>
                        <div class="col text-end">
                            <a href="{{ route('home') }}" class="btn btn-primary px-5"><i
                                    class="fa-solid fa-ban me-2"></i>Cancelar</a>
                            <button type="submit" class="btn btn-secondary px-5"><i
                                    class="fa-regular fa-circle-check me-2"></i>Atualizar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
