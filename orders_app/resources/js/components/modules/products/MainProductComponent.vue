<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex">
                        <div class="col-4">
                            <button-new-item title="Novo" data-bs-toggle="modal" data-bs-target="#modalClientSave">
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
                        <table-products-component title="Lista de Produtos"
                            v-else
                            :show="{ visible: true, dataToggle: 'modal', dataTarget: '#modalProductShow' }"
                            :update="{ visible: true, dataToggle: 'modal', dataTarget: '#modalProductUpdate' }"
                            :deleted="{ visible: true, dataToggle: 'modal', dataTarget: '#modalProductDelete' }"
                            :table-titles="['Nome', 'Valor', 'Código de Barras', 'Ações']"
                            :products-array="productsArray">
                        </table-products-component>
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

        <!-- Modal New Product -->
        <NewProduct
            :url-base="urlBase"
            :config="config"
            @save="refreshList"
        ></NewProduct>

        <!-- Modal Edit Product -->
        <EditProduct
            :url-base="urlBase"
            :config="config"
            :store="store"
            @update="refreshList"
        ></EditProduct>


        <!-- Modal Show Product -->
        <ViewProduct
            :store="store"
        ></ViewProduct>


        <!-- Modal Delete Product -->
        <DeleteProduct
            :url-base="urlBase"
            :config="config"
            :store="store"
            @delete="refreshList"
        ></DeleteProduct>

    </div>
</template>

<script setup>
import axios from 'axios';
import { ref, onMounted, computed } from 'vue'
import { useStore } from '@/stores/useStore'
import NewProduct from './crud/NewProduct.vue'
import ViewProduct from './crud/ViewProduct.vue'
import EditProduct from './crud/EditProduct.vue';
import DeleteProduct from './crud/DeleteProduct.vue';

const store = useStore()

const selectedFilter = ref("")

const urlPaginate = ref("");
const urlFilter = ref("");
const productsArray = ref([]);

const urlBase = ref('http://localhost:8001/api/v1/products')

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
    price: 'Valor',
    barcode: 'Código'
}

const handleSearch = () => {
    if(searchQuery.value != ''){
        urlPaginate.value = 'page=1'
        if(selectedFilter.value == 'price' || selectedFilter.value == 'barcode'){
            urlFilter.value = '&search='+selectedFilter.value+':like:'+Number(searchQuery.value)+'%'
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
const refreshList = async () => {
    loader.value = true
    let url = `${urlBase.value}?${urlPaginate.value}${urlFilter.value}`
    try {
        const response = await axios.get(url, { headers: config.value })
        productsArray.value = response.data.data
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
