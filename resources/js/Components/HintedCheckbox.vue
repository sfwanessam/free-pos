<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    label: {
        type: String,
        default: '' // Optional label for the checkbox
    },
    hint: {
        type: String,
        default: '' // Optional hint text below the label
    },
    modelValue: {
        type: [Boolean, Number],
        required: true // Bind to v-model
    }
});

const emit = defineEmits(['update:modelValue']);
</script>

<template>
    <div class="flex">
        <div class="flex items-center h-5">
            <input type="checkbox" :id="label ? 'checkbox-' + label.replace(/\s+/g, '-').toLowerCase() : 'checkbox'"
                :aria-describedby="hint ? 'hint-text' : ''" :checked="modelValue === 1"
                @change="$emit('update:modelValue', $event.target.checked ? 1 : 0)"
                class="w-4 h-4 text-violet-600 bg-gray-100 border-gray-300 rounded focus:ring-violet-500 dark:focus:ring-violet-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
        </div>
        <div class="ms-2 text-sm">
            <label v-if="label" :for="label ? 'checkbox-' + label.replace(/\s+/g, '-').toLowerCase() : 'checkbox'"
                class="font-medium text-gray-900 dark:text-gray-300">{{ label }}</label>
            <p v-if="hint" id="hint-text" class="text-xs font-normal text-gray-500 dark:text-gray-300">{{ hint }}</p>
        </div>
    </div>
</template>
