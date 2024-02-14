<template>
    <generic-modal-component id="modalOrderUpdate" title="Editar Pedido">
        <template v-slot:alerts>
            <alert-component type="success" v-if="statusTransactionEdit == 'success'"
                :msg="statusMessageEdit"></alert-component>
            <alert-component type="danger" v-if="statusTransactionEdit == 'error'"
                :msg="statusMessageEdit"></alert-component>
        </template>
        <template v-slot:content>
            <input-container-component title="Cliente *">
                <div>
                    <span v-if="validationClient"><small class="text-danger">{{ validationClient[0] }}</small></span>
                    <select v-model="store.item.client_id" class="form-select" aria-label="Default select example">
                        <option selected disabled value="">Selecione o cliente</option>
                        <option v-for="(client, index) in allClients" :key="index" :value="client.id">{{ client.name }}
                        </option>
                    </select>
                </div>
            </input-container-component>
            <input-container-component title="Produto *">
                <div>
                    <span v-if="validationProduct"><small class="text-danger">{{ validationProduct[0] }}</small></span>
                    <select v-model="store.item.product_id" class="form-select" aria-label="Default select example">
                        <option selected disabled value="">Selecione o produto</option>
                        <option v-for="(product, index) in allProducts" :key="index" :value="product.id">{{ product.name }}
                        </option>
                    </select>
                </div>
            </input-container-component>
            <input-container-component title="Status *">
                <div>
                    <span v-if="validationStatus"><small class="text-danger">{{ validationStatus[0] }}</small></span>
                    <select v-model="store.item.status" class="form-select" aria-label="Default select example">
                        <option selected disabled value="">Selecione o produto</option>
                        <option v-for="status in statusArray" :value="status">{{ status }}</option>
                    </select>
                </div>
            </input-container-component>
            <input-container-component title="Promoção (%)">
                <div>
                    <input type="text" v-model="store.item.promotion" placeholder="Digite o código" class="form-control">
                </div>
            </input-container-component>
            <input-container-component title="Quantidade *">
                <div>
                    <span v-if="validationQuantity"><small class="text-danger">{{ validationQuantity[0] }}</small></span>
                    <input type="text" v-model="store.item.quantity" placeholder="Digite a quantidade" class="form-control">
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
import { defineEmits, ref, onMounted } from 'vue';

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

const validationClient = ref("");
const validationProduct = ref("");
const validationStatus = ref("");
const validationQuantity = ref("");

const statusArray = [
    'Em Aberto',
    'Cancelado',
    'Pago'
]

const statusTransactionEdit = ref("")
const statusMessageEdit = ref("");
const isEditing = ref(false);
const loaderUpdate = ref(false)
const handleUpdateItem = async () => {
    loaderUpdate.value = true
    isEditing.value = true;
    const data = {
        client_id: props.store.item.client_id,
        product_id: props.store.item.product_id,
        status: props.store.item.status,
        promotion: props.store.item.promotion,
        quantity: props.store.item.quantity
    }

    try {
        const response = await axios.put(props.urlBase + '/' + props.store.item.id, data, { headers: props.config })
        statusTransactionEdit.value = 'success';
        statusMessageEdit.value = response.data.message;
        validationClient.value = ''
        validationProduct.value = ''
        validationStatus.value = ''
        validationQuantity.value = ''
        loaderUpdate.value = false
        emit('update')
    } catch (e) {
        console.log(e)
        statusTransactionEdit.value = 'error'
        statusMessageEdit.value = 'Erro ao tentar atualizar o cliente'
        loaderUpdate.value = false
        if (e.response.data.errors) {
            validationClient.value = e.response.data.errors['client_id']
            validationProduct.value = e.response.data.errors['product_id'];
            validationStatus.value = e.response.data.errors['status'];
            validationQuantity.value = e.response.data.errors['quantity'];
        }
    }
    isEditing.value = false
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






