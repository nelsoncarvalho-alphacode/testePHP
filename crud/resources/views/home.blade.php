@extends('layout')

@section('conteudo')
    <h1>Bem-vindo à Minha Aplicação CRUD</h1>
    <p>Gerencie seus dados de forma eficiente!</p>
    <!-- Botões para Cadastro e Login -->
    @guest
        <div class="options">
            <a href="{{ route('register') }}" class="btn-cadastro">Cadastro</a>
            <a href="{{ route('login') }}" class="btn-login">Login</a>
        </div>
    @endguest
@endsection

@push('styles')
<style>
    /* Estilos dos botões... */
    .options a {
        text-decoration: none;
        display: inline-block;
        padding: 10px 20px;
        margin: 10px;
        border: 1px solid transparent;
        border-radius: 5px;
        color: #fff;
        transition: all 0.3s ease;
    }

    .btn-cadastro {
        background-color: #FFA500; /* Laranja */
    }

    .btn-login {
        background-color: #1E90FF; /* Azul */
    }

    .options a:hover {
        opacity: 0.8;
    }
</style>
@endpush
