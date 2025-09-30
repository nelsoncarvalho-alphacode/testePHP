<div class="mb-3">
    <label class="form-label">Cliente</label>
    <select name="cliente_id" class="form-select" required>
        <option value="">-- Selecione --</option>
        @foreach ($clientes as $cliente)
            <option value="{{ $cliente->id }}"
                {{ old('cliente_id', $pedido->cliente_id ?? '') == $cliente->id ? 'selected' : '' }}>
                {{ $cliente->nome }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Data do Pedido</label>
    <input type="datetime-local" name="data_pedido" class="form-control"
        value="{{ old('data_pedido', isset($pedido) ? \Carbon\Carbon::parse($pedido->data_pedido)->format('Y-m-d\TH:i') : '') }}"
        required>
</div>

<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select" required>
        <option value="em_aberto" {{ old('status', $pedido->status ?? '') === 'em_aberto' ? 'selected' : '' }}>Em Aberto
        </option>
        <option value="pago" {{ old('status', $pedido->status ?? '') === 'pago' ? 'selected' : '' }}>Pago</option>
        <option value="cancelado" {{ old('status', $pedido->status ?? '') === 'cancelado' ? 'selected' : '' }}>Cancelado
        </option>
    </select>
</div>

<hr>

@include('pedidos.partials._itens_table')

<div>
    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Cancelar</a>
</div>

<script>
    window.produtosOptions = `
        @foreach ($produtos as $produto)
            <option value="{{ $produto->id }}" data-preco="{{ $produto->valor_unitario }}">
                {{ $produto->nome ?? 'Sem nome' }}
            </option>
        @endforeach
    `;
</script>

<script type="module" src="{{ asset('js/modules/pedidos.js') }}"></script>
