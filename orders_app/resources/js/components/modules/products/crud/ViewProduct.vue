<template>
    <generic-modal-component id="modalProductShow" title="Visualizar Produto">
        <template v-slot:content>
            <input-container-component title="Nome do Produto">
                <div>
                    <input disabled type="text" :value="store.item.name" placeholder="Digite o nome do produto"
                        class="form-control">
                </div>
            </input-container-component>
            <input-container-component title="Valor (R$)">
                <div>
                    <input disabled type="text" :value="store.item.price" placeholder="Digite o valor"
                        class="form-control">
                </div>
            </input-container-component>
            <input-container-component title="Código de Barras">
                <div>
                    <input disabled type="text" :value="store.item.barcode" placeholder="Digite o código"
                        class="form-control">
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
