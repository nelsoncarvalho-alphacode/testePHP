<template>
    <div class="col-12">
        <div style="margin-top: 8px;">
            <button class="btn btn-success btn-md col-12 col-md-8">{{ title }}</button>
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
