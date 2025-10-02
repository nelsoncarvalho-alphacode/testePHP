<form method="GET" class="row g-3 mb-3">
    <div class="col-md-3">
        <select name="cliente_id" class="form-select">
            <option value="">-- Cliente --</option>
            @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}" {{ request('cliente_id') == $cliente->id ? 'selected' : '' }}>
                    {{ $cliente->nome }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">-- Status --</option>
            <option value="em_aberto" {{ request('status')=='em_aberto' ? 'selected' : '' }}>Em Aberto</option>
            <option value="pago" {{ request('status')=='pago' ? 'selected' : '' }}>Pago</option>
            <option value="cancelado" {{ request('status')=='cancelado' ? 'selected' : '' }}>Cancelado</option>
        </select>
    </div>
    <div class="col-md-3">
        <input type="date" name="data_pedido" value="{{ request('data_pedido') }}" class="form-control">
    </div>
    <div class="col-md-3">
        <button type="submit" class="btn btn-secondary w-100">Filtrar</button>
    </div>
</form>