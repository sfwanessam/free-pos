<script setup>
import { defineProps, defineEmits } from 'vue';
const props = defineProps({
    type: {
        type: String,
        default: 'button',
        validator: (value) => ['button', 'submit'].includes(value),
    },
    text: {
        type: String,
        required: true,
    },
    skin: {
        type: String,
        default: 'white',
        validator: (value) => ['white', 'color'].includes(value),
    },
    disabled: {
        type: Boolean,
        default: false,       // Enable button by default
        validator: (value) => [true, false].includes(value),
    }
});

// Emit click events to the parent component
const emit = defineEmits(['click']);

</script>

<template>
    
<button :type="type"
        :disabled="disabled"
        @click="$emit('click')" :class="{ 'text-gray-900 bg-white hover:bg-gray-100 border border-gray-200': (skin == 'white') , 'bg-violet-800 hover:bg-violet-800 text-white focus:ring-violet-300 dark:bg-violet-600 dark:hover:bg-violet-800 dark:focus:ring-violet-800': (skin == 'color')  }" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center  rounded-lg  focus:ring-4 ">
    <slot></slot>
    {{ text }}
</button>

</template>