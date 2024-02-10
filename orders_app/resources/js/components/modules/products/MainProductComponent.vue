<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex">
                        <button-new-item title="Novo Produto" data-bs-toggle="modal" data-bs-target="#modalClientSave">
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
                        <table-products-component title="Lista de Produtos"
                            v-else
                            :show="{ visible: true, dataToggle: 'modal', dataTarget: '#modalProductShow' }"
                            :update="{ visible: true, dataToggle: 'modal', dataTarget: '#modalProductUpdate' }"
                            :deleted="{ visible: true, dataToggle: 'modal', dataTarget: '#modalProductDelete' }"
                            :table-titles="['ID', 'Nome', 'Valor', 'Código de Barras', 'Ações']"
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

const searchObj = ref({
    id: '',
    name: ''
})

const urlPaginate = ref("");
const urlFilter = ref("");
const productsArray = ref([]);

const urlBase = ref('http://localhost:8000/api/v1/products')

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
