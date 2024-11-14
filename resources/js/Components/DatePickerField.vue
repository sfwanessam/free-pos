<script setup>
import { ref, onMounted, defineProps, defineEmits, defineExpose } from 'vue';
import { POSIcon } from '@/Components';

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    placeholder: {
        type: String,
        default: 'Select date'
    },
    format: {
        type: String,
        default: 'mm-dd-yyyy'
    },
    datepickerId: {
        type: String,
        default: 'default-datepicker'
    },
});

const emit = defineEmits(['update:modelValue']);

const localDate = ref(props.modelValue);
const input = ref(null);

onMounted(() => {
    // Autofocus logic can be added here if needed
    if (input.value?.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({
    focus: () => input.value.focus()
});

const handleInputChange = (value) => {
    // Emit the updated date value back to the parent component
    emit('update:modelValue', value);
};
</script>

<template>
    <div class="relative max-w-sm">
        <!-- Icon part -->
        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
            <POSIcon name="CalendarDaysIcon" class="w-4 h-6 text-gray-500 dark:text-gray-400" />
        </div>

        <!-- Date input field -->
        <input datepicker :id="props.datepickerId" type="text" v-model="localDate" :datepicker-format="props.format"
            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            :placeholder="props.placeholder" ref="input" @input="handleInputChange(localDate)" />
    </div>
</template>
