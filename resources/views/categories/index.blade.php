@extends('layouts.app')

@section('content')
@if (session('success'))
    <div class="alert alert-success" id="success-alert">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger" id="error-alert">
        {{ session('error') }}
    </div>
@endif
<h1>Categorias</h1>
<div class="row mt-4">
    <div class="col-md-8">
        <h3>Categorias</h3>
        @foreach ($categories as $categorie)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $categorie->name }}</h5>
                    <p class="card-text">{{ $categorie->description }}</p>
                    <form action="{{ route('categories.destroy', $categorie->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Deletar</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Adicionar Categoria</h3>
                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome:</label>
                        <span class="text-danger">*</span>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrição:</label>
                        <textarea class="form-control" id="description" name="description" cols="30" rows="10"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Adicionar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    window.setTimeout(function() {
        var successAlert = document.getElementById('success-alert');
        if (successAlert) {
            successAlert.style.display = 'none';
        }
    }, 3000); // 3 segundos

    window.setTimeout(function() {
        var errorAlert = document.getElementById('error-alert');
        if (errorAlert) {
            errorAlert.style.display = 'none';
        }
    }, 3000); // 3 segundos
</script>
@endsection