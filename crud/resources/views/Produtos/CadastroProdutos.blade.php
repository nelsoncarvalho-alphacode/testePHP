@extends('layout')

@section('conteudo')
    <h1>Cadastro de Produto</h1>
    <form action="{{ route('produtosSalvo') }}" method="POST" class="form_cadastro_produto">
        @csrf
        <div class="form-group">
            <label for="codigo_barras">Código de Barras:</label>
            <input type="number" id="codigo_barras" name="codigo_barras" required>
        </div>
        <div class="form-group">
            <label for="nome">Nome do Produto:</label>
            <input type="text" id="nome" name="nome" required>
        </div>
        <div class="form-group">
            <label for="quantidade">Quantidade:</label>
            <input type="number" id="quantidade" name="quantidade" required>
        </div>
        <div class="form-group">
            <label for="valor_unitario">Valor Unitário:</label>
            <input type="text" id="valor_unitario" name="valor_unitario" required>
        </div>
        <button type="submit">Cadastrar Produto</button>
    </form>
@endsection

@push('styles')
    <style>
        /* Estilos CSS para o formulário de cadastro de produtos */
        .form_cadastro_produto {
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
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #dfe1e5; /* Cor cinza do Google */
            border-radius: 5px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
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
