<script setup>
import { ref } from 'vue';

const fileInput = ref(null);

defineProps({
    name: {
        type: String,
    }
});

const emit = defineEmits(['change']);

function onFileChange(event) {
    const files = event.target.files;
    emit('change', files); // Emit the files to the parent component
}

// Optional function to clear the file input
function clearFile() {
    fileInput.value.value = '';
}
</script>

<template>
    <input
        type="file"
        :name="name"
        ref="fileInput"
        @input="onFileChange"
        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
    />
</template>
