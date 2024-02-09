<template>
    <div class="form-group mb-2">
        <label for="" class="form-label">{{ title }}</label>
        <slot></slot>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    title: {
        type: String
    }
})
</script>
