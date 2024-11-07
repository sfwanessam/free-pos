<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    pagination: Object
})
</script>

<template>
    <nav>
        <ul class="flex items-center -space-x-px h-8 text-sm" v-if="pagination.data.length > 0">
            <li v-for="link in pagination.meta.links" :key="link.label">
                <Link preserve-scroll :href="link.url ?? ''" v-html="link.label"
                    class="flex items-center justify-center text-gray-400 px-3 h-8 leading-tight  bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                    :class="{ 'text-violet-800': link.active, 'text-gray-300': !link.url }" />
            </li>
        </ul>
    </nav>
</template>