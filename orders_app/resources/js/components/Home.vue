<template>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Bem vindo ao Order App!</div>

                <div class="card-body">
                    <div class="card bg-warning">
                        <div class="card-body">
                            <div class="d-flex" style="display: flex; justify-content: space-between; align-items: center; padding: 10px;">
                                <h2>Clientes</h2>
                                <div class="d-flex justify-content-center" v-if="loader">
                                    <div class="spinner-border" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                                <span v-else style="font-size: 30px;">{{ allClients ? allClients.length : 0 }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-info mt-3">
                        <div class="card-body">
                            <div class="d-flex" style="display: flex; justify-content: space-between; align-items: center; padding: 10px;">
                                <h2>Produtos</h2>
                                <div class="d-flex justify-content-center" v-if="loader">
                                    <div class="spinner-border" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                                <span v-else style="font-size: 30px;">{{ allProducts ? allProducts.length : 0 }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-secondary mt-3">
                        <div class="card-body">
                            <div class="d-flex" style="display: flex; justify-content: space-between; align-items: center; padding: 10px;">
                                <h2>Pedidos</h2>
                                <div class="d-flex justify-content-center" v-if="loader">
                                    <div class="spinner-border" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                                <span v-else style="font-size: 30px;">{{ allOrders ? allOrders.length : 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script setup>
import { onMounted, computed, ref } from 'vue';

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

const loader = ref(false);
const allOrders = ref([])
const allClients = ref([]);
const allProducts = ref([]);
onMounted(async () => {
    loader.value = true

    try {
        const clientsResponse = await axios.get('http://localhost:8000/api/v1/all-clients', { headers: config.value });
        allClients.value = clientsResponse.data

        const productsResponse = await axios.get('http://localhost:8000/api/v1/all-products', { headers: config.value });
        allProducts.value = productsResponse.data

        const ordersResponse = await axios.get('http://localhost:8000/api/v1/all-orders', { headers: config.value });
        allOrders.value = ordersResponse.data
        loader.value = false
    } catch(e) {
        console.log(e)
        loader.value = false
    }
})
</script>
