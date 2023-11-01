<div class="modal fade" id="editOrderModal" tabindex="-1"
     aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="orderModalLabel">Editar Pedido</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editOrder" method="POST" action="{{route('update_purchase')}}">
                    @method('PUT')
                    <div class="row">
                        <input type="hidden" name="id" id="idOrder" value="">
                        <div class="col-6">
                            <x-select id="id_products" name="id_product" required class="orm-label"
                                      :is-multi-select="false" :disabled="false" :dataset="$products"
                                      :selected="[]" label="Produto" min="1">
                            </x-select>
                        </div>
                        <div class="col-6">
                            <x-select id="id_clients" name="id_client" required class="form-control"
                                      :is-multi-select="false" :disabled="false" :dataset="$clients"
                                      :selected="[]" label="Cliente">
                            </x-select>
                        </div>
                        <div class="col-6">
                            <x-input id="percentage_descounts"
                                     name="percentage_descount" value="" required
                                     type="number" label="Desconto %"></x-input>
                        </div>
                        <div class="col-6">
                            <x-input id="amount_buys"
                                     name="amount_Buy" value="" required
                                     type="number" label="Quantidade"></x-input>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" form="editOrder" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        let id = $('#idOrder');
        let id_client = $('#id_clients');
        let id_product = $('#id_products');
        let amount_buy = $('#amount_buys');
        let percentage_descount = $('#percentage_descounts');

        $("button[id^='order']").click(function () {
            console.log('oi');
            let getEvent = $(this);
            id.val(getEvent.data('id'));
            id_client.val(getEvent.data('id_client'));
            id_product.val(getEvent.data('id_product'));
            amount_buy.val(getEvent.data('amount_buy'));
            percentage_descount.val(getEvent.data('percentage_descount'));
        });
    });
</script>
