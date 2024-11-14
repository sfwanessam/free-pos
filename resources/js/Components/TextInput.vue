<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    required: true,
});

const props = defineProps({
    placeholder: {
        type: String
    },
    roundedClass: {
        type: String,
        default: 'rounded-lg',
        validator: (value) => ['rounded-sm', 'rounded-md', 'rounded-lg'].includes(value),
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
    <input
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
        v-model="model" :placeholder="placeholder" ref="input" />
</template>
