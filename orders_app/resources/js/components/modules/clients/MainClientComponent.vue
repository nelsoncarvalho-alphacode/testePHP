<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex">
                        <div class="col-4">
                            <button-new-item title="Novo" data-bs-toggle="modal"
                                data-bs-target="#modalClientSave">
                            </button-new-item>
                        </div>
                        <div class="col-4 d-flex" style="margin-left: 10px;">
                            <div class="mt-2 col-12 float-right">
                                <select
                                    class="form-select"
                                    v-model="selectedFilter"
                                >
                                    <option selected disabled value="">Filtrar por</option>
                                    <option v-for="(item, index) in itemsSearchObj" :key="index" :value="index">{{ item }}</option>
                                </select>
                            </div>
                        </div>
                        <div style="margin-left: 8px;">
                            <input-search-component>
                                <template v-slot:input>
                                    <input
                                        @input="handleSearch()"
                                        :disabled="selectedFilter == ''"
                                        type="text"
                                        class="form-control"
                                        id="searchId"
                                        placeholder="Buscar..."
                                        v-model="searchQuery">

                                </template>
                            </input-search-component>
                        </div>

                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-center" v-if="loader">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <table-clients-component
                            v-else
                            title="Lista de Clientes"
                            :show="{visible: true, dataToggle: 'modal', dataTarget: '#modalClientShow'}"
                            :update="{visible: true, dataToggle: 'modal', dataTarget: '#modalClientUpdate'}"
                            :deleted="{visible: true, dataToggle: 'modal', dataTarget: '#modalClientDelete'}"
                            :table-titles="['Nome', 'Email', 'CPF', 'Ações']"
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
        <NewClient
            :url-base="urlBase"
            :config="config"
            @save="refreshList"
        ></NewClient>

        <!-- Modal Edit Client -->
        <EditClient
            :url-base="urlBase"
            :config="config"
            :store="store"
            @update="refreshList"
        ></EditClient>

        <!-- Modal Show Client -->
        <ViewClient
            :store="store"
        ></ViewClient>


        <!-- Modal Delete Client -->
        <DeleteClient
            :url-base="urlBase"
            :config="config"
            :store="store"
            @delete="refreshList"
        ></DeleteClient>

    </div>
</template>

<script setup>
import axios from 'axios';
import { ref, onMounted, computed } from 'vue'
import { useStore } from '@/stores/useStore'
import NewClient from './crud/NewClient.vue';
import EditClient from './crud/EditClient.vue'
import ViewClient from './crud/ViewClient.vue'
import DeleteClient from './crud/DeleteClient.vue'

const store = useStore()

const selectedFilter = ref("")

const urlPaginate = ref("");
const urlFilter = ref("");
const clientsArray = ref([]);

const urlBase = ref('http://localhost:8001/api/v1/clients')

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

let searchQuery = ref("")

let itemsSearchObj = {
    name: 'Nome',
    email: 'Email',
    cpf: 'CPF'
}
const handleSearch = () => {

    if(searchQuery.value != ''){
        urlPaginate.value = 'page=1'
        if(selectedFilter.value == 'cpf'){
            urlFilter.value = '&search='+selectedFilter.value+':like:'+'%'+Number(searchQuery.value)+'%'
        } else {
            urlFilter.value = '&search='+selectedFilter.value+':like:'+'%'+searchQuery.value+'%'
        }
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

const loader = ref(false)
const paginateData = ref([])
const refreshList = async (query = '') => {
    loader.value = true
    let url = `${urlBase.value}?${urlPaginate.value}${urlFilter.value}`
    try {
        const response = await axios.get(url, { headers: config.value })
        clientsArray.value = response.data.data
        paginateData.value = response.data
        loader.value = false
    } catch (e) {
        console.log(e)
    }
}

onMounted(() => {
    refreshList()
})

</script>
