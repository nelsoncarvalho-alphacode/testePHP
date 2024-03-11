@extends('layouts.app')

@section('content')
@if ($product)
    <h1>Editar Produto</h1>
    <form method="POST" action="{{ route('products.update', ['produto' => $product->id]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">Nome:</label>
                <span class="text-danger">*</span>
                <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
            </div>

            <div class="mb-3">
                <!-- Mostrar imagem existente, se houver -->
                @if ($product->image_path)
                    <div id="imagePreviewContainer">
                        <img id="previewImage" src="{{ asset('storage/images/products/' . $product->image_path) }}" alt="Product Image" style="max-width: 300px; max-height: 200px;">
                        <button type="button" class="btn btn-sm btn-danger" id="removeImageButton">Remover Imagem</button>
                    </div>
                @endif
                <!-- Campo para adicionar uma nova imagem -->
                <label for="image" class="form-label">Imagem<span class="text-danger">*</span>:</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Descrição:</label>
                <textarea class="form-control" id="description" name="description">{{ $product->description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantidade:</label>
                <span class="text-danger">*</span>
                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $product->quantity }}" required>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Preço:</label>
                <span class="text-danger">*</span>
                <input type="text" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
            </div>

            <div class="mb-3">
                <label for="barcode" class="form-label">Código de Barras:</label>
                <span class="text-danger">*</span>
                <input type="text" class="form-control" id="barcode" name="barcode" value="{{ $product->barcode }}" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status:</label>
                <span class="text-danger">*</span>
                <select class="form-select" id="status" name="status" required>
                    @if ($product->status === 1)
                        <option value="1" selected>Ativo</option>
                        <option value="0">Inativo</option>
                    @else
                        <option value="1">Ativo</option>
                        <option value="0" selected>Inativo</option>
                    @endif
                </select>
            </div>

            <div class="mb-3">
                <label for="categorie_id" class="form-label">Categoria:</label>
                <span class="text-danger">*</span>
                <select class="form-select" name="categorie_id" id="categorie_id" required>
                    @foreach ($categories as $categorie)
                        <option value="{{$categorie->id}}" @if ($categorie->id === $product->categorie_id) selected @endif>{{$categorie->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Salvar Alterações</button>
        <a class="btn btn-danger" href="{{ route('products.index') }}">Cancelar</a>
    </form>
@else
    <h1>Produto nao encontrado.</h1>
@endif
@endsection

@section('script')
<script>
    document.getElementById('removeImageButton').addEventListener('click', function() {
        document.getElementById("previewImage").src = "";
        document.getElementById("image").value = "";
    });

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