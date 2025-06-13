
@csrf
<div class="mb-3">
    <label for="cliente_id" class="form-label">Cliente</label>
    <select name="cliente_id" class="form-select" required>
        <option value="">Selecione...</option>
        @foreach($clientes as $cliente)
            <option value="{{ $cliente->id }}" {{ (old('cliente_id', $pedido->cliente_id ?? '') == $cliente->id) ? 'selected' : '' }}>
                {{ $cliente->nome }}
            </option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label for="data_pedido" class="form-label">Data do Pedido</label>
    <input type="datetime-local" name="data_pedido" value="{{ old('data_pedido', isset($pedido) ? $pedido->data_pedido->format('Y-m-d\TH:i') : '') }}" class="form-control" required>
</div>
<div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select name="status" class="form-select" required>
        @foreach(['Em Aberto', 'Pago', 'Cancelado'] as $status)
            <option value="{{ $status }}" {{ (old('status', $pedido->status ?? '') == $status) ? 'selected' : '' }}>{{ $status }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label for="total" class="form-label">Total</label>
    <input type="number" step="0.01" name="total" value="{{ old('total', $pedido->total ?? '') }}" class="form-control">
</div>