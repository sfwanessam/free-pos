<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    required: true,
});

const props = defineProps({
    placeholder: {
        type: Number
    },
    bordered: {
        type: Boolean,
        default: true
    },
    bg: {
        type: Boolean,
        default: true
    }
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input :class="{ 'border-transparent focus:border-transparent focus:ring-0': (!bordered), 'bg-transparent': (!bg) }"
        class="border border-gray-300 text-center dark:border-gray-600 focus:border-primary-600 focus:ring-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 text-gray-900 text-sm rounded-lg   block w-full p-2.5 dark:bg-gray-700  dark:placeholder-gray-400 dark:text-white "
        v-model="model" type="number" :placeholder="placeholder" ref="input" />
</template>
