<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex">
                        <button-new-item title="Novo Cliente" data-bs-toggle="modal"
                            data-bs-target="#modalClientSave">
                        </button-new-item>
                        <div class="col-md-4"></div>
                        <input-search-component>
                            <template v-slot:input>
                                <input @input="handleSearch()" type="text" class="form-control" id="searchId"
                                    placeholder="Buscar..." v-model="searchObj.name">

                            </template>
                        </input-search-component>
                    </div>

                    <div class="card-body">
                        <table-clients-component
                            title="Lista de Clientes"
                            :show="{visible: true, dataToggle: 'modal', dataTarget: '#modalClientShow'}"
                            :update="{visible: true, dataToggle: 'modal', dataTarget: '#modalClientUpdate'}"
                            :deleted="{visible: true, dataToggle: 'modal', dataTarget: '#modalClientDelete'}"
                            :table-titles="['ID', 'Nome', 'Email', 'CPF', 'Ações']"
                            :clients-array="clientsArray">
                        </table-clients-component>
                    </div>

                    <div class="card-footer">
                        <paginate-component>
                            <li v-for="(link, index) in paginateData.links" :key="index"
                                :class="link.active ? 'page-item active' : 'page-item'" @click="paginatedLink(link)">
                                <a class="page-link" v-html="link.label"></a>
                            </li>
                        </paginate-component>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal New Client -->
        <generic-modal-component id="modalClientSave" title="Adicionar Cliente">
            <template v-slot:alerts>
                <alert-component type="success" v-if="statusTransaction == 'success'" :msg="statusMessage"></alert-component>
                <alert-component type="danger" v-if="statusTransaction == 'error'" :msg="statusMessage"></alert-component>
            </template>
            <template v-slot:content>
                <input-container-component title="Nome do Cliente">
                    <div>
                        <span v-if="validationName"><small class="text-danger">{{ validationName[0] }}</small></span>
                        <input type="text" v-model="clientName" placeholder="Digite o nome do cliente" class="form-control">
                    </div>
                </input-container-component>
                <input-container-component title="Email do Cliente">
                    <input type="email" v-model="clientEmail" placeholder="Digite o email do cliente" class="form-control">
                </input-container-component>
                <input-container-component title="CPF">
                    <div>
                        <span v-if="validationCpf"><small class="text-danger">{{ validationCpf[0] }}</small></span>
                        <input type="text" v-model="clientCpf" placeholder="Digite o CPF do cliente" class="form-control">
                    </div>
                </input-container-component>
            </template>

            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" :disabled="isSaving" @click="handleSaveNewItem()"
                    class="btn btn-primary">Salvar</button>
            </template>
        </generic-modal-component>


        <!-- Modal Show Client -->
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


        <!-- Modal Delete Client -->
        <generic-modal-component id="modalClientDelete" title="Tem certeza que deseja deletar?">
            <template v-slot:content>
                Essa operação não poderá ser desfeita.
            </template>

            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" @click="confirmDelete(store.item.id)">Deletar</button>
            </template>
        </generic-modal-component>



        <!-- Modal Update Client -->
        <generic-modal-component id="modalClientUpdate" title="Editar Cliente">
            <template v-slot:alerts>
                <alert-component type="success" v-if="statusTransaction == 'success'" :msg="statusMessage"></alert-component>
                <alert-component type="danger" v-if="statusTransaction == 'error'" :msg="statusMessage"></alert-component>
            </template>
            <template v-slot:content>
                <input-container-component title="Nome do Cliente">
                    <div>
                        <span v-if="validationName"><small class="text-danger">{{ validationName[0] }}</small></span>
                        <input type="text" v-model="store.item.name" placeholder="Digite o nome do cliente" class="form-control">
                    </div>
                </input-container-component>
                <input-container-component title="Email do Cliente">
                    <input type="email" v-model="store.item.email" placeholder="Digite o email do cliente" class="form-control">
                </input-container-component>
                <input-container-component title="CPF">
                    <div>
                        <span v-if="validationCpf"><small class="text-danger">{{ validationCpf[0] }}</small></span>
                        <input type="text" v-model="store.item.cpf" placeholder="Digite o CPF do cliente" class="form-control">
                    </div>
                </input-container-component>
            </template>

            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" :disabled="isEditing" @click="handleUpdateItem()"
                    class="btn btn-primary">Editar</button>
            </template>
        </generic-modal-component>


    </div>
</template>

<script setup>
import axios from 'axios';
import { ref, onMounted, computed, watchEffect } from 'vue'
import { useStore } from '@/stores/useStore'

const store = useStore()

const clientName = ref("");
const clientEmail = ref("");
const clientCpf = ref("");

const teste = ref("")

const searchObj = ref({
    id: '',
    name: ''
})

const clearForm = () => {
    clientName.value = '';
    clientEmail.value = '';
    clientCpf.value = '';
}

const urlPaginate = ref("");
const urlFilter = ref("");

const statusTransaction = ref("");
const statusMessage = ref("");
const validationName = ref("");
const validationCpf = ref("");
const clientsArray = ref([]);

const urlBase = ref('http://localhost:8000/api/v1/clients')

const getConfigHeaders = computed(() => {
    let tokenCookie = document.cookie.split(';')
    let tokenJWT = tokenCookie[0].split('=');
    const config = {
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + tokenJWT[1]
        }
    }
    return config
})

const handleSearch = () => {
    let filter = '';

    for (let index in searchObj.value) {
        const value = searchObj.value[index];

        if (value) {
            if (filter != '') {
                filter += ';'
            }
            filter += index + ':like:' + '%' + value + '%'
        }

    }
    if (filter) {
        urlPaginate.value = 'page=1'
        urlFilter.value = '&search=' + filter
    } else {
        urlFilter.value = ''
    }
    refreshList()
}

const paginatedLink = (link) => {
    if (link.url) {
        urlPaginate.value = link.url.split('?')[1]
    }
    refreshList()
}

const config = ref(getConfigHeaders.value.headers)

const isSaving = ref(false)
const handleSaveNewItem = async () => {
    isSaving.value = true;

    const clientData = {
        name: clientName.value,
        email: clientEmail.value,
        cpf: clientCpf.value
    }

    try {
        const response = await axios.post(urlBase.value, clientData, { headers: config.value });
        statusTransaction.value = 'success';
        statusMessage.value = response.data.message;
        clearForm()
    } catch (e) {
        statusTransaction.value = 'error'
        statusMessage.value = 'Erro ao tentar cadastrar o cliente'
        if (e.response.data.errors) {
            validationName.value = e.response.data.errors['name']
            validationCpf.value = e.response.data.errors['cpf'];
        }
    }

    isSaving.value = false;
    refreshList()
}

const isEditing = ref(false);
const handleUpdateItem = async () => {
    const data = {
        name: store.item.name,
        email: store.item.email,
        cpf: store.item.cpf
    }

    const response = await axios.put(urlBase.value+'/'+store.item.id, data, {headers: config.value})
    console.log(response.data)

    refreshList()

}

const confirmDelete = async (entity) => {
    let formData = new FormData()
    formData.append('_method', 'delete')

    const response = await axios.post(urlBase.value+'/'+entity, formData, { headers: config.value })
    console.log(response.data)
    refreshList()
}



const paginateData = ref([])
const refreshList = async () => {
    let url = `${urlBase.value}?${urlPaginate.value}${urlFilter.value}`
    try {
        const response = await axios.get(url, { headers: config.value })
        clientsArray.value = response.data.data
        paginateData.value = response.data
    } catch (e) {
        console.log(e)
    }
}

onMounted(() => {
    refreshList()
})


</script>
