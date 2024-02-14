<template>
    <generic-modal-component id="modalClientUpdate" title="Editar Cliente">
        <template v-slot:alerts>
            <alert-component type="success" v-if="statusTransactionEdit == 'success'" :msg="statusMessageEdit"></alert-component>
            <alert-component type="danger" v-if="statusTransactionEdit == 'error'" :msg="statusMessageEdit"></alert-component>
        </template>
        <template v-slot:content>
            <input-container-component title="Nome do Cliente *">
                <div>
                    <span v-if="validationName"><small class="text-danger">{{ validationName[0] }}</small></span>
                    <input type="text" v-model="store.item.name" placeholder="Digite o nome do cliente" class="form-control">
                </div>
            </input-container-component>
            <input-container-component title="Email do Cliente">
                <input type="email" v-model="store.item.email" placeholder="Digite o email do cliente" class="form-control">
            </input-container-component>
            <input-container-component title="CPF *">
                <div>
                    <span v-if="validationCpf"><small class="text-danger">{{ validationCpf[0] }}</small></span>
                    <input type="text" v-model="store.item.cpf" placeholder="Digite o CPF do cliente" class="form-control">
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

const validationName = ref("");
const validationCpf = ref("");

const statusTransactionEdit = ref("")
const statusMessageEdit = ref("");
const isEditing = ref(false);
const loaderUpdate = ref(false)
const handleUpdateItem = async () => {
    loaderUpdate.value = true
   isEditing.value = true;
    const data = {
        name: props.store.item.name,
        email: props.store.item.email,
        cpf: props.store.item.cpf
    }

    try {
        const response = await axios.put(props.urlBase+'/'+props.store.item.id, data, {headers: props.config})
        statusTransactionEdit.value = 'success';
        statusMessageEdit.value = response.data.message;
        validationName.value = ''
        validationCpf.value = ''
        loaderUpdate.value = false
        emit('update')
    } catch(e) {
        console.log(e)
        statusTransactionEdit.value = 'error'
        statusMessageEdit.value = 'Erro ao tentar atualizar o cliente'
        loaderUpdate.value = false
        if (e.response.data.errors) {
            validationName.value = e.response.data.errors['name']
            validationCpf.value = e.response.data.errors['cpf'];
        }
    }

    isEditing.value = false
}
</script>
