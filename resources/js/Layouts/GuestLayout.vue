<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="bg-gray-50 dark:bg-gray-900">
<div class="flex flex-col items-center justify-center px-6 pt-8 mx-auto md:h-screen pt:mt-0 dark:bg-gray-900">
        <div>
            <Link href="/">
                <ApplicationLogo class="w-30 h-20 fill-current text-gray-500" />
            </Link>
        </div>

        <div
            class="w-full max-w-md p-6 space-y-8 sm:p-5 bg-white rounded-lg shadow dark:bg-gray-800"
        >
            <slot />
        </div>
    </div>
    </div>
    
</template>
