<template>
    <div class="col-6 col-md-4">
        <div style="margin-top: 8px;">
            <button class="btn btn-success btn-md">{{ title }}</button>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';

defineProps({
    title: {
        type: String
    }
})
</script>
