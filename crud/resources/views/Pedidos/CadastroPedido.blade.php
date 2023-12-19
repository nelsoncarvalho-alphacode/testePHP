{{--@extends('layout')--}}

{{--@section('conteudo')--}}
{{--    <h1>Faça seu pedido</h1>--}}
{{--    <form method="POST" action="" class="form">--}}
{{--        @csrf--}}
{{--        <div class="form-group">--}}
{{--            <label for="produtos">Produtos:</label><select name="produtos" id="produtos">--}}
{{--                @foreach ($produtos as $produto)--}}
{{--                    <option value="{{ $produto->id }}">{{ $produto->nome }}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}
{{--        <div class="form-group">--}}
{{--            <label for="quantidade">Quantidade:</label>--}}
{{--            <input type="number" name="quantidade" id="quantidade" min="1" required class="form-control">--}}
{{--        </div>--}}

{{--        <div class="form-group">--}}
{{--            <label for="valor_unitario">Valor Unitário:</label>--}}
{{--            <input type="text" name="valor_unitario" id="valor_unitario" readonly class="form-control">--}}
{{--        </div>--}}

{{--        <button type="submit" class="btn btn-primary">Salvar Pedido</button>--}}
{{--    </form>--}}
{{--@endsection--}}

{{--@push('scripts')--}}
{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', () => {--}}
{{--            const produtosSelect = document.getElementById('produtos');--}}

{{--            produtosSelect.addEventListener('change', () => {--}}
{{--                console.log("aqi");--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endpush--}}

{{--@push('styles')--}}
{{--    <style>--}}
{{--        #produtos {--}}
{{--            width: 42%;--}}
{{--            padding: 10px;--}}
{{--            border: 1px solid #dfe1e5; /* Cor cinza do Google */--}}
{{--            border-radius: 5px;--}}
{{--            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;--}}
{{--        }--}}

{{--        .form-group {--}}
{{--            margin-bottom: 20px;--}}
{{--        }--}}

{{--        label {--}}
{{--            display: block;--}}
{{--            margin-bottom: 5px;--}}
{{--            color: #5f6368; /* Cor cinza do Google */--}}
{{--        }--}}

{{--        input[type="text"],--}}
{{--        input[type="number"] {--}}
{{--            width: 40%;--}}
{{--            padding: 10px;--}}
{{--            border: 1px solid #dfe1e5; /* Cor cinza do Google */--}}
{{--            border-radius: 5px;--}}
{{--            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;--}}
{{--        }--}}

{{--        input[type="text"]:focus,--}}
{{--        input[type="number"]:focus {--}}
{{--            outline: none;--}}
{{--            border-color: #1a73e8; /* Cor azul do Google no foco */--}}
{{--            box-shadow: 0 0 0 4px rgba(26, 115, 232, 0.15); /* Efeito de foco */--}}
{{--        }--}}

{{--        button {--}}
{{--            padding: 12px 24px;--}}
{{--            background-color: #1a73e8; /* Cor azul do Google */--}}
{{--            color: white;--}}
{{--            border: none;--}}
{{--            border-radius: 5px;--}}
{{--            cursor: pointer;--}}
{{--            transition: background-color 0.3s ease-in-out;--}}
{{--        }--}}

{{--        button:hover {--}}
{{--            background-color: #0f62fe; /* Cor azul mais escura no hover */--}}
{{--        }--}}
{{--    </style>--}}
{{--@endpush--}}
