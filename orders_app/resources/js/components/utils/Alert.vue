<template>
    <div v-if="visible" :class="[style, 'fade show']" role="alert">
        {{ msg }}
    </div>
</template>

<script setup>
import { ref, computed, defineProps, onMounted } from 'vue';

const props = defineProps({
    type: {
        type: String
    },
    msg: {
        type: String
    }
});
const style = computed(() => 'alert alert-' + props.type)

const visible = ref(true)
onMounted(() => {
  const timeoutDuration = 5000;

  setTimeout(() => {
    visible.value = false;
  }, timeoutDuration);
});
</script>
