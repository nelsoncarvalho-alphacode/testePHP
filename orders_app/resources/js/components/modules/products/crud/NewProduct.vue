<template>
    <generic-modal-component id="modalClientSave" title="Adicionar Produtos">
        <template v-slot:alerts>
            <alert-component type="success" v-if="statusTransactionNew == 'success'"
                :msg="statusMessageNew"></alert-component>
            <alert-component type="danger" v-if="statusTransactionNew == 'error'"
                :msg="statusMessageNew"></alert-component>
        </template>
        <template v-slot:content>
            <input-container-component title="Nome do Produto">
                <div>
                    <input type="text" v-model="productName" placeholder="Digite o nome do produto"
                        class="form-control">
                </div>
            </input-container-component>
            <input-container-component title="Valor (R$) *">
                <div>
                    <span v-if="validationPrice"><small class="text-danger">{{ validationPrice[0] }}</small></span>
                    <input type="number" v-model="productPrice" placeholder="Digite o valor" class="form-control">
                </div>
            </input-container-component>
            <input-container-component title="Código de Barras *">
                <div>
                    <span v-if="validationBarcode"><small class="text-danger">{{ validationBarcode[0] }}</small></span>
                    <input type="text" v-model="productBarcode" placeholder="Digite o código" class="form-control">
                </div>
            </input-container-component>
        </template>

        <template v-slot:footer>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            <button type="button" :disabled="isSaving" @click="handleSaveNewItem()" class="btn btn-primary">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" v-if="loaderSave"></span>
                <span v-else>Salvar</span>
            </button>
        </template>
    </generic-modal-component>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { defineEmits } from 'vue';

const props = defineProps({
    urlBase: {
       type: String
    },
    config: {
        type: Object
    }
})

const emit = defineEmits(['save'])

const productName = ref("");
const productPrice = ref("");
const productBarcode = ref("");

const clearForm = () => {
    productName.value = '';
    productPrice.value = '';
    productBarcode.value = '';
}

const validationBarcode = ref("");
const validationPrice = ref("");

const statusTransactionNew = ref("")
const statusMessageNew = ref("");
const isSaving = ref(false)
const loaderSave = ref(false)
const handleSaveNewItem = async () => {
    loaderSave.value = true
    isSaving.value = true;

    const productData = {
        name: productName.value,
        price: productPrice.value,
        barcode: productBarcode.value
    }

    try {
        const response = await axios.post(props.urlBase, productData, { headers: props.config });
        statusTransactionNew.value = 'success';
        statusMessageNew.value = response.data.message;
        validationBarcode.value = ''
        validationPrice.value = ''
        loaderSave.value = false
        clearForm()
        emit('save')
    } catch (e) {
        console.log(e)
        statusTransactionNew.value = 'error'
        statusMessageNew.value = 'Erro ao tentar cadastrar o cliente'
        if (e.response.data.errors) {
            validationBarcode.value = e.response.data.errors['barcode']
            validationPrice.value = e.response.data.errors['price'];
        }
        loaderSave.value = false
    }

    isSaving.value = false;

}
</script>
