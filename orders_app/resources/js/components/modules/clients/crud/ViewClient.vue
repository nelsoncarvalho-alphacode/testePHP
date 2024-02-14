<template>
    <generic-modal-component id="modalClientShow" title="Visualizar Cliente">
        <template v-slot:content>
            <input-container-component title="Nome do Cliente">
                <div>
                    <input disabled type="text" :value="store.item.name" placeholder="Digite o nome do cliente" class="form-control">
                </div>
            </input-container-component>
            <input-container-component title="Email do Cliente">
                <div>
                    <input disabled type="text" :value="store.item.email" placeholder="Digite o nome do cliente" class="form-control">
                </div>
            </input-container-component>
            <input-container-component title="CPF">
                <div>
                    <input disabled type="text" :value="store.item.cpf" placeholder="Digite o nome do cliente" class="form-control">
                </div>
            </input-container-component>
        </template>

        <template v-slot:footer>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        </template>
    </generic-modal-component>
</template>

<script setup>
defineProps({
    store: {
        type: Object
    }
})
</script>
