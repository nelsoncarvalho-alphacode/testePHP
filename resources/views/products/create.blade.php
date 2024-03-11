@extends('layouts.app')

@section('content')
<h1>Adicionar Produto</h1>
<form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label">Nome<span class="text-danger">*</span>:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required> 
        </div>

        <div class="mb-3">
            <div id="imagePreviewContainer" style="display: none;">
                <img id="previewImage" src="#" alt="Preview" style="max-width: 300px; max-height: 200px;">
            </div>
            <label for="image" class="form-label">Imagem<span class="text-danger">*</span>:</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantidade<span class="text-danger">*</span>:</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descrição:</label>
            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Preço<span class="text-danger">*</span>:</label>
            <input type="text" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
        </div>

        <div class="mb-3">
            <label for="barcode" class="form-label">Código de Barras<span class="text-danger">*</span>:</label>
            <input type="text" class="form-control" id="barcode" name="barcode" value="{{ old('barcode') }}" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status<span class="text-danger">*</span>:</label>
            <select class="form-select" id="status" name="status" required>
                <option value="1">Ativo</option>
                <option value="0">Inativo</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="categorie_id" class="form-label">Categoria<span class="text-danger">*</span>:</label>
            <select class="form-select" name="categorie_id" id="categorie_id" required>
                <option value="" selected disabled>Selecione uma opção</option>
                @foreach ($categories as $categorie)
                    <option value="{{$categorie->id}}">{{$categorie->name}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <button type="submit" class="btn btn-success">Adicionar Produto</button>
    <a class="btn btn-secondary" href="{{ route('products.index') }}">Voltar</a>
</form>
@endsection

@section('script')
<script>
    // Função para pré-visualizar a imagem selecionada
    function previewImage(event) {
        // Seleciona o elemento de imagem de pré-visualização
        var imgElement = document.getElementById('previewImage');
        var previewContainer = document.getElementById('imagePreviewContainer');

        // Verifica se um arquivo foi selecionado
        if (event.target.files.length > 0) {
            // Obtém o arquivo selecionado pelo usuário
            var file = event.target.files[0];

            // Cria um objeto URL para o arquivo
            var imgUrl = URL.createObjectURL(file);

            // Define o URL da imagem de pré-visualização
            imgElement.src = imgUrl;

            // Exibe a imagem de pré-visualização
            previewContainer.style.display = 'block';
        } else {
            // Se nenhum arquivo foi selecionado, oculta a imagem de pré-visualização
            previewContainer.style.display = 'none';
        }
    }

    // Adiciona um ouvinte de evento para o campo de upload de imagem
    document.getElementById('image').addEventListener('change', previewImage);
</script>
@endsection