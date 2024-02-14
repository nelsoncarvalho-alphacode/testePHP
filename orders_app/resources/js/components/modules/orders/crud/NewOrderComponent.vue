<template>
    <generic-modal-component id="modalOrderSave" title="Adicionar Pedido">
        <template v-slot:alerts>
            <alert-component type="success" v-if="statusTransactionNew == 'success'"
                :msg="statusMessageNew"></alert-component>
            <alert-component type="danger" v-if="statusTransactionNew == 'error'"
                :msg="statusMessageNew"></alert-component>
        </template>
        <template v-slot:content>
            <input-container-component title="Cliente *">
                <div >
                    <span v-if="validationClient"><small class="text-danger">{{ validationClient[0] }}</small></span>
                    <select
                        v-model="clientSelected"
                        class="form-select"
                        aria-label="Default select example"
                    >
                        <option selected disabled value="">Selecione o cliente</option>
                        <option v-for="(client, index) in allClients" :key="index" :value="client.id">{{ client.name }}</option>
                    </select>
                </div>
            </input-container-component>
            <input-container-component title="Produto *">
                <div>
                    <span v-if="validationProduct"><small class="text-danger">{{ validationProduct[0] }}</small></span>
                    <select
                        v-model="productSelected"
                        class="form-select"
                        aria-label="Default select example"
                    >
                        <option selected disabled value="">Selecione o produto</option>
                        <option v-for="(product, index) in allProducts" :key="index" :value="product.id">{{ product.name }}</option>
                    </select>
                </div>
            </input-container-component>
            <input-container-component title="Status *">
                <div>
                    <span v-if="validationStatus"><small class="text-danger">{{ validationStatus[0] }}</small></span>
                    <select
                        v-model="orderStatus"
                        class="form-select"
                        aria-label="Default select example"
                    >
                        <option selected disabled value="">Selecione o status</option>
                        <option v-for="status in statusArray" :value="status">{{ status }}</option>
                    </select>
                </div>
            </input-container-component>
            <input-container-component title="Promoção (%)">
                <div>
                    <input type="number" v-model="orderPromotion" placeholder="Porcentagem da promoção" class="form-control">
                </div>
            </input-container-component>
            <input-container-component title="Quantidade *">
                <div>
                    <span v-if="validationQuantity"><small class="text-danger">{{ validationQuantity[0] }}</small></span>
                    <input type="number" v-model="orderQuantity" placeholder="Digite a quantidade" class="form-control">
                </div>
            </input-container-component>
        </template>

        <template v-slot:footer>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            <button type="button" :disabled="isSaving" @click="handleSaveNewItem()" class="btn btn-primary">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                    v-if="loaderSave"></span>
                <span v-else>Salvar</span>
            </button>
        </template>
    </generic-modal-component>
</template>

<script setup>
import { onMounted, ref, computed } from 'vue';
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

const emit = defineEmits(['save', 'eventB'])

const clientSelected = ref("");
const productSelected = ref("");
const orderStatus = ref("");
const orderPromotion = ref(null)
const orderQuantity = ref("");

const validationClient = ref("");
const validationProduct = ref("");
const validationStatus = ref("");
const validationQuantity = ref("");

const statusArray = [
    'Em Aberto',
    'Cancelado',
    'Pago'
]

const clearForm = () => {
    clientSelected.value = '';
    productSelected.value = '';
    orderStatus.value = '';
    orderPromotion.value = '';
    orderQuantity.value = '';
}

const statusTransactionNew = ref("")
const statusMessageNew = ref("");
const isSaving = ref(false)
const loaderSave = ref(false)
const handleSaveNewItem = async () => {
    loaderSave.value = true
    isSaving.value = true;

    const ordersData = {
        client_id: clientSelected.value,
        product_id: productSelected.value,
        status: orderStatus.value,
        quantity: orderQuantity.value,
        promotion: orderPromotion.value
    }

    try {
        const response = await axios.post(props.urlBase, ordersData, { headers: props.config });
        statusTransactionNew.value = 'success';
        statusMessageNew.value = response.data.message;
        validationClient.value = ''
        validationProduct.value = ''
        validationStatus.value = ''
        validationQuantity.value = ''
        loaderSave.value = false
        clearForm()
        emit('save')
    } catch (e) {
        console.log(e)
        statusTransactionNew.value = 'error'
        statusMessageNew.value = 'Erro ao tentar cadastrar o cliente'
        if (e.response.data.errors) {
            validationClient.value = e.response.data.errors['client_id']
            validationProduct.value = e.response.data.errors['product_id'];
            validationStatus.value = e.response.data.errors['status'];
            validationQuantity.value = e.response.data.errors['quantity'];
        }
        loaderSave.value = false
    }

    isSaving.value = false;

}

const allClients = ref([]);
const allProducts = ref([]);
onMounted(async () => {
    const clientsResponse = await axios.get('http://localhost:8000/api/v1/all-clients', { headers: props.config });
    allClients.value = clientsResponse.data

    const productsResponse = await axios.get('http://localhost:8000/api/v1/all-products', { headers: props.config });
    allProducts.value = productsResponse.data
})
</script>
