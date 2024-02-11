<template>
    <span class="badge bg-secondary mb-4" style="font-size: 15px;">
        {{ title }}
    </span>
    <div class="table-responsive" v-if="!clientsArray.length == 0">
        <table class="table table-hover">
            <thead>
                <tr >
                    <th v-for="title in tableTitles">{{title}}</th>
                </tr>
            </thead>
            <tbody >
                <tr v-for="client in clientsArray" style="justify-content: center; align-items: center;">
                    <td>{{ client.name }}</td>
                    <td>{{ client.email }}</td>
                    <td>{{ client.cpf }}</td>

                    <td class="d-flex">
                        <button v-if="show.visible" class="btn btn-primary btn-sm" style="margin-right: 5px;" :data-bs-toggle="show.dataToggle" :data-bs-target="show.dataTarget" @click="setStore(client)">Visualizar</button>
                        <button v-if="update.visible" class="btn btn-warning btn-sm" style="margin-right: 5px;" :data-bs-toggle="update.dataToggle" :data-bs-target="update.dataTarget" @click="setStore(client)">Editar</button>
                        <button v-if="deleted.visible" class="btn btn-danger btn-sm" :data-bs-toggle="deleted.dataToggle" :data-bs-target="deleted.dataTarget" @click="setStore(client)">Excluir</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';
import { useStore } from '@/stores/useStore'

const store = useStore()

const setStore = (entity) => {
    store.item = {...entity}
}

const props = defineProps({
    title: {
        type: String
    },
    clientsArray: {
        type: Array
    },
    tableTitles: {
        type: Array
    },
    show: {
        type: Object
    },
    update: {
        type: Object
    },
    deleted: {
        type: Object
    }

})

</script>
