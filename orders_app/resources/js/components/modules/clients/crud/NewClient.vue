<template>
    <generic-modal-component id="modalClientSave" title="Adicionar Cliente">
        <template v-slot:alerts>
            <alert-component type="success" v-if="statusTransactionNew == 'success'" :msg="statusMessageNew"></alert-component>
            <alert-component type="danger" v-if="statusTransactionNew == 'error'" :msg="statusMessageNew"></alert-component>
        </template>
        <template v-slot:content>
            <input-container-component title="Nome do Cliente *">
                <div>
                    <span v-if="validationName"><small class="text-danger">{{ validationName[0] }}</small></span>
                    <input type="text" v-model="clientName" placeholder="Digite o nome do cliente" class="form-control">
                </div>
            </input-container-component>
            <input-container-component title="Email do Cliente">
                <input type="email" v-model="clientEmail" placeholder="Digite o email do cliente" class="form-control">
            </input-container-component>
            <input-container-component title="CPF *">
                <div>
                    <span v-if="validationCpf"><small class="text-danger">{{ validationCpf[0] }}</small></span>
                    <input type="text" v-model="clientCpf" placeholder="Digite o CPF do cliente" class="form-control">
                </div>
            </input-container-component>
        </template>

        <template v-slot:footer>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            <button type="button" :disabled="isSaving" @click="handleSaveNewItem()" class="btn btn-primary" style="align-items: center;">

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

const clientName = ref("");
const clientEmail = ref("");
const clientCpf = ref("");

const clearForm = () => {
    clientName.value = '';
    clientEmail.value = '';
    clientCpf.value = '';
}

const validationName = ref("");
const validationCpf = ref("");

const statusTransactionNew = ref("")
const statusMessageNew = ref("");
const isSaving = ref(false)
const loaderSave = ref(false)
const handleSaveNewItem = async () => {
    loaderSave.value = true
    isSaving.value = true;

    const clientData = {
        name: clientName.value,
        email: clientEmail.value,
        cpf: clientCpf.value
    }

    try {
        const response = await axios.post(props.urlBase, clientData, { headers: props.config });
        statusTransactionNew.value = 'success';
        statusMessageNew.value = response.data.message;
        validationName.value = ''
        validationCpf.value = ''
        loaderSave.value = false
        clearForm()
        emit('save')
    } catch (e) {
        statusTransactionNew.value = 'error'
        statusMessageNew.value = 'Erro ao tentar cadastrar o cliente'
        if (e.response.data.errors) {
            validationName.value = e.response.data.errors['name']
            validationCpf.value = e.response.data.errors['cpf'];
        }
        loaderSave.value = false
    }

    isSaving.value = false;

}
</script>
