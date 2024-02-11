<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex">
                        <div class="col-4">
                            <button-new-item title="Novo" data-bs-toggle="modal" data-bs-target="#modalOrderSave">
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
                                    <input :disabled="selectedFilter == ''" @input="handleSearch()" type="text" class="form-control" id="searchId"
                                        placeholder="Buscar..." v-model="searchQuery">
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
                        <table-orders-component title="Lista de Pedidos" v-else
                            :show="{ visible: true, dataToggle: 'modal', dataTarget: '#modalOrderShow' }"
                            :update="{ visible: true, dataToggle: 'modal', dataTarget: '#modalOrderUpdate' }"
                            :deleted="{ visible: true, dataToggle: 'modal', dataTarget: '#modalOrderDelete' }"
                            :table-titles="['N°', 'Cliente', 'Produto', 'Status', 'Promoção(%)', 'Quantidade', 'Ações']"
                            :orders-array="ordersArray">
                        </table-orders-component>
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

        <!-- Modal New Order -->
        <NewOrderComponent
            :url-base="urlBase"
            :config="config"
            @save="refreshList"
        ></NewOrderComponent>

        <!-- Modal Update Order -->
        <EditOrderComponent
            :url-base="urlBase"
            :config="config"
            :store="store"
            @update="refreshList"
        ></EditOrderComponent>

        <!-- Modal Show Order -->
        <ViewOrderComponent
            :store="store"
        ></ViewOrderComponent>

        <!-- Modal Delete Order -->
        <DeleteOrder
            :url-base="urlBase"
            :config="config"
            :store="store"
            @delete="refreshList"
        ></DeleteOrder>

    </div>
</template>

<script setup>
import axios from 'axios';
import { ref, onMounted, computed } from 'vue'
import { useStore } from '@/stores/useStore'
import NewOrderComponent from './crud/NewOrderComponent.vue';
import EditOrderComponent from './crud/EditOrderComponent.vue';
import ViewOrderComponent from './crud/ViewOrderComponent.vue';
import DeleteOrder from './crud/DeleteOrder.vue';

const store = useStore()

const selectedFilter = ref("")

const urlPaginate = ref("");
const urlFilter = ref("");
const ordersArray = ref([]);

const urlBase = ref('http://localhost:8000/api/v1/orders')

let searchQuery = ref("")

let itemsSearchObj = {
    id: 'Número',
    status: 'Status',
    quantity: 'Quantidade'
}

const handleSearch = () => {
    if(searchQuery.value != ''){
        urlPaginate.value = 'page=1'
        if(selectedFilter.value == 'id' || selectedFilter.value == 'quantity'){
            urlFilter.value = '&search='+selectedFilter.value+':like:'+'%'+Number(searchQuery.value)+'%'
        } else {
            urlFilter.value = '&search='+selectedFilter.value+':like:'+'%'+searchQuery.value+'%'
            console.log(urlFilter.value)
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

const config = ref(getConfigHeaders.value.headers)

// const confirmDelete = async (entity) => {
//     let formData = new FormData()
//     formData.append('_method', 'delete')

//     const response = await axios.post(urlBase.value + '/' + entity, formData, { headers: config.value })
//     refreshList()
// }

const loader = ref(false)
const paginateData = ref([])
const refreshList = async () => {
    loader.value = true
    let url = `${urlBase.value}?${urlPaginate.value}${urlFilter.value}`
    try {
        const response = await axios.get(url, { headers: config.value })
        ordersArray.value = response.data.data
        paginateData.value = response.data
        loader.value = false
    } catch (e) {
        console.log(e)
    }
}

onMounted(async () => {
    refreshList()
})

</script>
