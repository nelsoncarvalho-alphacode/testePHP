@extends('layouts.app')

@section('content')
    <h1>Novo Pedido</h1>
    
    <form action="{{ route('pedidos.store') }}" method="POST" id="pedido-form">
        @csrf
        
        <div class="row">
            <label for="cliente_id">Cliente:</label>
            <div class="col">
                <select class="form-select" name="cliente_id" required>
                    <option value="">Selecione um cliente</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row pedido-produto-section">
            <div class="col pedido-produto-section-title">Produtos</div>
            <button type="button" id='add-produto' class="col add-produto btn btn-secondary">Adicionar Produto</button>
        </div>
        <div id="produtos-container">
            <div class="produto-item row">
                <label for="produtos_0">Produto:</label>
                <div class="col">
                    <select class="form-select produto-select" id="produtos_0" name="produtos[0][id]" required>
                    <option value="">Selecione um produto</option>
                        @foreach($produtos as $produto)
                            <option value="{{ $produto->id }}" data-preco="{{ $produto->valor_unitario }}">
                                {{ $produto->nome }} - R$ {{ number_format($produto->valor_unitario, 2, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <input type="number" name="produtos[0][quantidade]" class="form-control"  min="1" value="1" required>
                </div>
                <div class="col">
                    <button type="button" class="rmv-produto btn btn-danger remover-produto">Remover</button>
                </div>
            </div>
        </div>
        
        
        <div class="produto-total-display">
            <h4>Total: <span id="total">R$ 0,00</span></h4>
        </div>
        <div class="d-flex justify-content-between mt-20">
            <button type="submit" class="btn btn-light">Salvar Pedido</button>
            <a href="{{ route('pedidos.index') }}" class="btn btn-light">Voltar</a>
        </div>
    </form>
    
    @push('script')
        <script>  
            document.addEventListener('DOMContentLoaded', function() {
                const container = document.getElementById('produtos-container');
                let counter = 1;

                container.addEventListener('click', function(e) {
                    if(e.target.classList.contains('rmv-produto') && container.children.length > 2) {
                        e.target.parentElement.parentElement.remove();
                        calcularTotal();
                    }
                });

                document.getElementById('add-produto').addEventListener('click', function(){
                        const newItem = document.createElement('div');
                        newItem.className = 'produto-item row';
                        newItem.innerHTML = `
                            <label for="produtos_${counter}">Produto:</label>
                            <div class="col">
                                <select class="form-select produto-select" id="produtos_${counter}" name="produtos[${counter}][id]" required>
                                <option value="">Selecione um produto</option>
                                    @foreach($produtos as $produto)
                                        <option value="{{ $produto->id }}" data-preco="{{ $produto->valor_unitario }}">
                                            {{ $produto->nome }} - R$ {{ number_format($produto->valor_unitario, 2, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <input type="number" name="produtos[${counter}][quantidade]" class="form-control"  min="1" value="1" required>
                            </div>
                            <div class="col">
                                <button type="button" class="rmv-produto btn btn-danger remover-produto">Remover</button>
                            </div>
                        `;
                        
                        container.appendChild(newItem);
                        counter++;
                })
                
                container.addEventListener('change', function(e) {
                    if (e.target.classList.contains('produto-select') || 
                        (e.target.type === 'number' && e.target.name.includes('quantidade'))) {
                        calcularTotal();
                    }
                });
                
                function calcularTotal() {
                    let total = 0;
                    
                    document.querySelectorAll('.produto-item').forEach(item => {
                        
                        const select = item.querySelector('.produto-select');
                        const quantidade = item.querySelector('input[type=number]').value;
                        
                        if (select && select.value) {
                            const preco = parseFloat(select.selectedOptions[0].dataset.preco);
                            total += preco * quantidade;
                        }
                    });
                    
                    document.getElementById('total').textContent = 
                        'R$ ' + total.toFixed(2).replace('.', ',');
                }
            });
        </script>
    @endpush
@endsection