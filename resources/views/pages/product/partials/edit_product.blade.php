<div class="modal fade" id="editProductModal" tabindex="-1"
     aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="productModalLabel">Editar Produto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProduct" method="POST" action="{{route('update_product')}}" >
                    @method('PUT')
                    <div class="row">
                        <input type="hidden" name="id" id="id" value="">
                        <div class="col-12 ">
                            <x-input name="name" id="name" label="Nome" required="true"
                                     type="text" value=""/>
                        </div>
                        <div class="col-12 pt-2">
                            <x-input name="barCode" id="barCode" label="Codigo de Barras" required="true"
                                     type="text" value=""/>
                        </div>
                        <div class="col-6 pt-2">
                            <x-input name="value" id="value" label="Preço" required="true"
                                     type="decimal" value=""/>
                        </div>
                        <div class="col-6 pt-2">
                            <x-input name="amount" id="amount" label="Estoque" required="true"
                                     type="decimal" value=""/>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" form="editProduct" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        let id = $('#id');
        let name = $('#name');
        let barCode = $('#barCode');
        let amount = $('#amount');
        let value = $('#value');

        $("button[id^='product']").click(function () {
            let getEvent = $(this);
            id.val(getEvent.data('id'));
            name.val(getEvent.data('name'));
            barCode.val(getEvent.data('bar_code'));
            amount.val(getEvent.data('amount'));
            value.val(getEvent.data('value'));
        });
    });
</script>
