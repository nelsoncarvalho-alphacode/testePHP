<div class="modal fade" id="editClientModal" tabindex="-1"
     aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Cliente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editClient" method="POST" action="{{route('update_client')}}">
                        @method('PUT')
                    <div class="row">
                        <input type="hidden" name="id" id="id" value="">
                        <div class="col-12 ">
                            <x-input name="name" id="name" label="Nome" required="true"
                                     type="text" value=""/>
                        </div>
                        <div class="col-12 pt-2">
                            <x-input name="cpf" id="cpf" label="CPF" required="true"
                                     type="text" value=""/>
                        </div>
                        <div class="col-12 pt-2">
                            <x-input name="email" id="email" label="E-mail" required="true"
                                     type="text" value=""/>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" form="editClient" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        let id = $('#id');
        let name = $('#name');
        let email = $('#email');
        let cpf = $('#cpf');

        $("button[id^='client']").click(function () {
            let getEvent = $(this);
            id.val(getEvent.data('id'));
            name.val(getEvent.data('name'));
            email.val(getEvent.data('email'));
            cpf.val(getEvent.data('cpf'));
        });
    });
</script>
