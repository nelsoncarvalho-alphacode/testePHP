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

const searchObj = ref({
    name: ''
})

const urlPaginate = ref("");
const urlFilter = ref("");
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

const loader = ref(false)
const paginateData = ref([])
const refreshList = async () => {
    loader.value = true
    let url = `${urlBase.value}?${urlPaginate.value}${urlFilter.value}`
    try {
        const response = await axios.get(url, { headers: config.value })
        clientsArray.value = response.data.data
        console.log(clientsArray.value)
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
