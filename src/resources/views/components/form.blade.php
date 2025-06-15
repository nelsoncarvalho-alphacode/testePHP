<!-- Modal -->
<div class="modal fade" id="form-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="form-title"></h1>
        <button id="modal-close-btn" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="items-form">
        <div class="modal-body">
            <div>
                @if($endpoint === "clients")
                    <div class="input-group mb-2"><x-input :id="'name'" :placeholder="''" :type="'text'" :label="'Nome'" /></div>
                    <div class="input-group mb-2"><x-input :id="'surname'" :placeholder="''" :type="'text'" :label="'Sobrenome'" /></div>
                    <div class="input-group mb-2"><x-input :id="'email'" :placeholder="''" :type="'text'" :label="'E-mail'" /></div>
                    <div class="input-group mb-2"><x-input :id="'cpf'" :placeholder="'Apenas números'" :type="'text'" :label="'CPF'" /></div>
                @elseif($endpoint === "products")
                    <div class="input-group mb-2"><x-input :id="'name'" :placeholder="''" :type="'text'" :label="'Nome'" /></div>
                    <div class="input-group mb-2"><x-input :id="'price'" :placeholder="'ex: 99,99'" :type="'text'" :label="'Preço'" /></div>
                    <div class="input-group mb-2"><x-input :id="'barcode'" :placeholder="'Apenas números'" :type="'text'" :label="'Código de barras'" /></div>
                @elseif($endpoint === "orders")
                    <div class="input-group mb-2"><x-select :id="'client_id'" :placeholder="''" :options="[]" :label="'Cliente'" /></div>
                    <div class="input-group mb-2"><x-select :id="'product_id'" :placeholder="''" :options="[]" :label="'Produto'" /></div>
                    <div class="input-group mb-2"><x-input :id="'quantity'" :placeholder="''" :type="'number'" :label="'Quantidade'" /></div>
                    <div class="input-group mb-2"><x-select :id="'status'" :placeholder="''" :options="[
                            ['pending', 'Em aberto'],
                            ['canceled', 'Cancelado'],
                            ['payed', 'Pago']
                    ]" :label="'Status'" /></div>
                    <div class="input-group mb-2"><x-input :id="'order_date'" :placeholder="''" :type="'date'" :label="'Data'" /></div>
                    <div class="input-group mb-2"><x-input :id="'discount'" :placeholder="'Apenas números (ex: 30)'" :type="'text'" :label="'Desconto (%)'" /></div>
                @endif
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Confirmar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<button id="items-form-trigger" type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#form-modal">Adicionar novo
    @if($endpoint === 'clients'){{"cliente"}}
    @elseif($endpoint === 'products'){{"produto"}}
    @elseif($endpoint === 'orders'){{"pedido"}}
    @endif
</button>

