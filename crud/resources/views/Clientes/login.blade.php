@extends('layout')

@section('conteudo')
    <h1>Login</h1>
    <!-- Formulário de Login -->
    <form action="" method="POST">
        @csrf
        <div>
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" required>
        </div>
        <button type="submit">Entrar</button>
    </form>
@endsection

@push('styles')
<style>
    /* Estilos do formulário... */
    form {
        width: 50%;
        margin: 20px auto;
    }

    div {
        margin-bottom: 10px;
    }

    label {
        display: block;
        font-weight: bold;
    }

    input[type="text"] {
        width: calc(100% - 10px);
        padding: 5px;
        border-radius: 3px;
        border: 1px solid #ccc;
    }

    button {
        padding: 10px 20px;
        background-color: #1E90FF; /* Azul */
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        opacity: 0.8;
    }
</style>
@endpush
