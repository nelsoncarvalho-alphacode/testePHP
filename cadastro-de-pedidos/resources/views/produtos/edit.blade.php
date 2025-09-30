@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Editar Produto</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('produtos.update', $produto) }}" method="POST">
        @csrf
        @method('PUT')
        @include('produtos.form')
        <button type="submit" class="btn btn-primary">Atualizar</button>
        <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
