@php
    $itens = old(
        'itens',
        isset($pedido)
            ? $pedido->itens->toArray() : [['produto_id' => '', 'quantidade' => 1, 'valor_unitario' => '']],
        );
@endphp

<h4>Itens do Pedido</h4>
<table class="table" id="itensTable">
    <thead>
        <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Valor Unitário</th>
            <th>Valor Total</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($itens as $i => $item)
            <tr>
                <td>
                    <select name="itens[{{ $i }}][produto_id]" class="form-select" required>
                        <option value="">-- Selecione --</option>
                        @foreach ($produtos as $produto)
                            <option value="{{ $produto->id }}" data-preco="{{ $produto->valor_unitario }}"
                                {{ $item['produto_id'] == $produto->id ? 'selected' : '' }}>
                                {{ $produto->nome ?? 'Sem nome' }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="itens[{{ $i }}][quantidade]" class="form-control"
                        min="1" value="{{ $item['quantidade'] }}">
                </td>
                <td>
                    <input type="text" name="itens[{{ $i }}][valor_unitario]"
                        class="form-control valor-unitario"
                        value="{{ number_format((float) $item['valor_unitario'], 2, ',', '.') }}">

                </td>
                <td>
                    <input type="text" 
                        class="form-control valor-total" 
                        value="{{ isset($item['quantidade'], $item['valor_unitario']) 
                            ? number_format($item['quantidade'] * (float) $item['valor_unitario'], 2, ',', '.') 
                            : '' }}" 
                        readonly>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-item">X</button>
                </td>
            </tr>
        @endforeach

    </tbody>
</table>

<button type="button" class="btn btn-secondary mb-3" id="addItem">+ Adicionar Item</button>


