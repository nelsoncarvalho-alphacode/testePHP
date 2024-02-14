<template>
    <generic-modal-component id="modalProductDelete" title="Tem certeza que deseja deletar?">
        <template v-slot:content>
            Essa operação não poderá ser desfeita.
        </template>

        <template v-slot:footer>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" @click="confirmDelete(store.item.id)">Excluir</button>
        </template>
    </generic-modal-component>
</template>

<script setup>
import { defineEmits } from 'vue';

const emit = defineEmits('delete')

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

const confirmDelete = async (entity) => {
    let formData = new FormData()
    formData.append('_method', 'delete')

    const response = await axios.post(props.urlBase + '/' + entity, formData, { headers: props.config })
    emit('delete')
}
</script>
