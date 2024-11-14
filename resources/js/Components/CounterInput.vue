<template>
    <div class="relative flex items-center">
        <!-- Decrement Button -->
        <button type="button" @click="decrement" :disabled="value <= min || disabled"
            class="flex-shrink-0 bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-5 w-5 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
            <svg class="w-2.5 h-2.5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 18 2">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 1h16" />
            </svg>
        </button>

        <!-- Counter Input -->
        <input type="text" :value="value" @input="onInput" :disabled="disabled"
            class="flex-shrink-0  text-gray-900 dark:text-white border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[4.0rem] text-center"
            required />

        <!-- Increment Button -->
        <button type="button" @click="increment" :disabled="value >= max || disabled"
            class="flex-shrink-0 bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-5 w-5 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
            <svg class="w-2.5 h-2.5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 1v16M1 9h16" />
            </svg>
        </button>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'

// Define props
const props = defineProps({
    modelValue: {
        type: Number,
        default: 12,
    },
    min: {
        type: Number,
        default: 0,
    },
    max: {
        type: Number,
        default: 100,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
})

// Define emits for two-way binding
const emit = defineEmits(['update:modelValue'])

// Computed value for the current counter
const value = computed(() => props.modelValue)

// Increment and decrement methods
const increment = () => {
    if (value.value < props.max) {
        emit('update:modelValue', value.value + 1)
    }
}

const decrement = () => {
    if (value.value > props.min) {
        emit('update:modelValue', value.value - 1)
    }
}

// Handle direct input changes
const onInput = (event) => {
    const newValue = parseInt(event.target.value, 10)
    if (!isNaN(newValue) && newValue <= props.max && newValue >= props.min) {
        emit('update:modelValue', newValue)
    }
}
</script>
