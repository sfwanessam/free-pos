<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { initFlowbite } from 'flowbite';

onMounted(() => {
initFlowbite();
});

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        
    </AuthenticatedLayout>
</template>
