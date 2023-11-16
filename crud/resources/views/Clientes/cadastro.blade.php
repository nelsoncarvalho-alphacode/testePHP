@extends('layout')

@section('conteudo')
    <h1>Cadastro de Cliente</h1>
    <form action="{{ route('salvarCliente') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
        </div>
        <div class="form-group">
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" required>
        </div>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
        </div>
        <button type="submit">Cadastrar</button>
    </form>
@endsection

@push('styles')
    <style>
        /* Estilos CSS para o formulário com descrições acima e à esquerda */
        form {
            width: 50%;
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #5f6368; /* Cor cinza do Google */
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #dfe1e5; /* Cor cinza do Google */
            border-radius: 5px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #1a73e8; /* Cor azul do Google no foco */
            box-shadow: 0 0 0 4px rgba(26, 115, 232, 0.15); /* Efeito de foco */
        }

        button {
            padding: 12px 24px;
            background-color: #1a73e8; /* Cor azul do Google */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        button:hover {
            background-color: #0f62fe; /* Cor azul mais escura no hover */
        }
    </style>
@endpush
