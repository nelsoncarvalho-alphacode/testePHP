<template>
    <generic-modal-component id="modalProductUpdate" title="Editar Produto">
        <template v-slot:alerts>
            <alert-component type="success" v-if="statusTransactionEdit == 'success'"
                :msg="statusMessageEdit"></alert-component>
            <alert-component type="danger" v-if="statusTransactionEdit == 'error'"
                :msg="statusMessageEdit"></alert-component>
        </template>
        <template v-slot:content>
            <input-container-component title="Nome do Produto">
                <div>
                    <input type="text" v-model="store.item.name" placeholder="Digite o nome do produto"
                        class="form-control">
                </div>
            </input-container-component>
            <input-container-component title="Valor (R$)">
                <div>
                    <span v-if="validationPrice"><small class="text-danger">{{ validationPrice[0] }}</small></span>
                    <input type="number" v-model="store.item.price" placeholder="Digite o valor" class="form-control">
                </div>
            </input-container-component>
            <input-container-component title="Código de Barras">
                <div>
                    <span v-if="validationBarcode"><small class="text-danger">{{ validationBarcode[0] }}</small></span>
                    <input type="text" v-model="store.item.barcode" placeholder="Digite o código" class="form-control">
                </div>
            </input-container-component>
        </template>

        <template v-slot:footer>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            <button type="button" :disabled="isEditing" @click="handleUpdateItem()" class="btn btn-primary">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" v-if="loaderUpdate"></span>
                <span v-else>Editar</span>
            </button>
        </template>
    </generic-modal-component>
</template>

<script setup>
import axios from 'axios'
import { defineEmits, ref } from 'vue';

const props = defineProps({
    urlBase: {
        type: String
    },
    config: {
        type: Object
    },
    store: {
        type: Object
    }
})

const emit = defineEmits(['update', 'second'])

const validationBarcode = ref("");
const validationPrice = ref("");

const statusTransactionEdit = ref("")
const statusMessageEdit = ref("");
const isEditing = ref(false);
const loaderUpdate = ref(false)
const handleUpdateItem = async () => {
    loaderUpdate.value = true
    isEditing.value = true;
    const data = {
        name: props.store.item.name,
        price: props.store.item.price,
        barcode: props.store.item.barcode
    }

    try {
        const response = await axios.put(props.urlBase + '/' + props.store.item.id, data, { headers: props.config })
        statusTransactionEdit.value = 'success';
        statusMessageEdit.value = response.data.message;
        validationBarcode.value = ''
        validationPrice.value = ''
        loaderUpdate.value = false
        emit("update")
    } catch (e) {
        console.log(e)
        statusTransactionEdit.value = 'error'
        statusMessageEdit.value = 'Erro ao tentar atualizar o cliente'
        loaderUpdate.value = false
        if (e.response.data.errors) {
            validationBarcode.value = e.response.data.errors['barcode']
            validationPrice.value = e.response.data.errors['price'];
        }
    }

    isEditing.value = false
}
</script>
