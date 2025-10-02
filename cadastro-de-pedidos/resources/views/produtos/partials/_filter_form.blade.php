    <form method="GET" class="mb-3" action="{{ route('produtos.index') }}">
        <div class="row g-2">
            <div class="col-md-3">
                <input type="text" name="nome" class="form-control" placeholder="Nome" value="{{ request('nome') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="codigo_barras" class="form-control" placeholder="Código de Barras"
                    value="{{ request('codigo_barras') }}">
            </div>
            <div class="col-md-2">
                <input type="number" step="0.01" name="valor_unitario" class="form-control" placeholder="Valor"
                    value="{{ request('valor_unitario') }}">
            </div>
            <div class="col-md-2">
                <select name="sort" class="form-select">
                    <option value="">Ordenar por...</option>
                    <option value="id" {{ request('sort') == 'id' ? 'selected' : '' }}>ID</option>
                    <option value="codigo_barras" {{ request('sort') == 'codigo_barras' ? 'selected' : '' }}>Código
                    </option>
                    <option value="nome" {{ request('sort') == 'nome' ? 'selected' : '' }}>Nome</option>
                    <option value="valor_unitario" {{ request('sort') == 'valor_unitario' ? 'selected' : '' }}>Valor
                    </option>
                </select>
            </div>
            <div class="col-md-1">
                <select name="direction" class="form-select">
                    <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>ASC</option>
                    <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>DESC</option>
                </select>
            </div>
            <div class="col-md-1 d-grid">
                <button class="btn btn-secondary">Filtrar</button>
            </div>
        </div>
    </form>
