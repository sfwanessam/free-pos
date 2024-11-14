<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    required: true,
});

const props = defineProps({
    placeholder: {
        type: String
    },
    rows: {
        type: Number,
        default: 2
    },
});

const textarea = ref(null);

onMounted(() => {
    if (textarea.value.hasAttribute('autofocus')) {
        textarea.value.focus();
    }
});

defineExpose({ focus: () => textarea.value.focus() });
</script>

<template>
    <textarea :rows="rows"
        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        v-model="model" :placeholder="placeholder" ref="textarea"></textarea>
</template>
