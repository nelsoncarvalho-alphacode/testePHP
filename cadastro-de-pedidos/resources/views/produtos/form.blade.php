@csrf

<div class="mb-3">
    <label for="nome" class="form-label">Nome</label>
    <input type="text" name="nome" id="nome" class="form-control"
           value="{{ old('nome', $produto->nome ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="codigo_barras" class="form-label">Código</label>
    <input type="text" name="codigo_barras" id="codigo_barras" class="form-control"
           value="{{ old('codigo_barras', $produto->codigo_barras ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="valor_unitario" class="form-label">Preço</label>
    <input type="number" name="valor_unitario" id="valor_unitario" class="form-control" step="0.01"
           value="{{ old('valor_unitario', $produto->valor_unitario ?? '') }}" required>
</div>
