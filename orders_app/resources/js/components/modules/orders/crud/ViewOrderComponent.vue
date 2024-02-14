<template>
    <generic-modal-component id="modalOrderShow" title="Detalhes do Pedido">
        <template v-slot:content>
            <input-container-component title="Cliente">
                <div>
                    <input disabled type="text" :value="store.item.client?.name" placeholder="Digite o nome do produto"
                        class="form-control">
                </div>
            </input-container-component>
            <input-container-component title="Produto">
                <div>
                    <input disabled type="text" :value="store.item.product?.name" placeholder="Digite o valor"
                        class="form-control">
                </div>
            </input-container-component>
            <input-container-component title="Status">
                <div>
                    <input disabled type="text" :value="store.item.status" placeholder="Digite o código"
                        class="form-control">
                </div>
            </input-container-component>
            <input-container-component title="Promoção (%)">
                <div>
                    <input disabled type="text" :value="store.item.promotion" placeholder="Digite o código"
                        class="form-control">
                </div>
            </input-container-component>
            <input-container-component title="Quantidade">
                <div>
                    <input disabled type="text" :value="store.item.quantity" placeholder="Digite o código"
                        class="form-control">
                </div>
            </input-container-component>
        </template>

        <template v-slot:footer>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        </template>
    </generic-modal-component>
</template>

<script setup>
import { useStore } from '@/stores/useStore'

const store = useStore()
</script>
