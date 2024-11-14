<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { router as Router } from '@inertiajs/vue3';
import { POSInputError, POSPagination, POSHintedCheckbox, POSAlerts, POSToast, POSBreadcrumbItem, POSTextInput, POSSelectInput, POSInputLabel, POSFileInput, POSButton, POSIcon } from '@/Components';
import { trans } from 'laravel-vue-i18n';
import VueLoaderImage from 'vue3-loader-image';
import 'vue3-loader-image/dist/style.css';

const props = defineProps({
    contacts: {
        type: Object,
    },
    search: {
        type: String
    }
});




const deleteContact = (contactId) => {
    trans('contacts.delete_alert_title')
    Swal.fire({
        title:
            trans('contacts.delete_alert_title'),
        text: trans('contacts.delete_alert_desc'),
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#5B21B6",
        cancelButtonColor: "#d33",
        confirmButtonText: trans('btns.confirm')
    }).then((result) => {
        if (result.isConfirmed) {
            Router.delete(route('contacts.destroy', contactId));
        }
    });
};


const form = useForm({
    search: props.search
});




const search = () => {
    Router.get(route('contacts.index'), (form.search.length > 0 ? { search: form.search } : {}), { replace: true, preserveState: true })
};

const clearSearch = () => {
    form.search = '';
    search();
};



</script>

<template>

    <Head :title="trans('contacts.title')" />

    <AuthenticatedLayout>
        <div
            class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
            <div class="w-full mb-1">


                <!-- Start : Page Breadcrumb -->
                <div class="mb-4">
                    <nav class="flex mb-5" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                            <POSBreadcrumbItem :isHome="true" :url="route('dashboard')"
                                :label="$t('dashboard.title')" />
                            <POSBreadcrumbItem :label="$t('contacts.title')" />
                        </ol>
                    </nav>
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
                        {{ trans('contacts.contacts_list') }}
                    </h1>
                </div>
                <!-- End : Page Breadcrumb -->

                <div
                    class="grid grid-cols-2 gap-2 items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                    <div class="min-w-80">
                        <!-- Start : Search Input Group -->
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <POSIcon name="MagnifyingGlassIcon" colorClass="text-gray-500 dark:text-gray-400" />
                            </div>
                            <input type="search" id="default-search" v-model="form.search"
                                class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-violet-500 focus:border-violet-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-violet-500 dark:focus:border-violet-500"
                                :placeholder="$t('contacts.search_for_contacts')" required />
                            <button as="button" type="button" @click="search"
                                class="text-white absolute end-2.5 bottom-2.5 bg-violet-800 hover:bg-violet-800 focus:ring-4 focus:outline-none focus:ring-violet-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-violet-600 dark:hover:bg-violet-700 dark:focus:ring-violet-800">
                                {{ trans('btns.search') }}
                            </button>
                        </div>
                        <!-- End : Search Input Group -->

                        <!-- Start : Search Results Hint -->
                        <div class="pt-2 flex" v-if="props.search != null">
                            {{ trans('contacts.search_results_for') }} : {{ props.search }}
                            <Link type="button" @click="clearSearch"
                                class="ms-5 flex font-medium text-pink-600 dark:text-pink-500 hover:underline">
                            {{ trans('btns.reset') }}
                            </Link>
                        </div>
                        <!-- End : Search Results Hint -->

                    </div>


                    <!-- Start : Add New Category Link -->
                    <Link :href="route('contacts.create')"
                        class="text-white bg-violet-800 hover:bg-violet-700	 focus:ring-4 focus:ring-violet-300  font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-violet-600 dark:hover:bg-violet-800 focus:outline-none dark:focus:ring-violet-800">
                    <POSIcon name="PlusIcon" />
                    {{ trans('contacts.new_contact') }}
                    </Link>
                    <!-- End : Add New contact Link -->
                </div>

                <!-- Start : Session Alerts Area -->
                <div class="mt-3">
                    <POSAlerts />
                </div>
                <!-- End : Session Alerts Area -->


                <!-- Start : Category Card -->
                <div class="mt-4">
                    <div class="container mx-auto">
                        <div v-if="contacts.data.length > 0" class="grid grid-cols-3  sm:grid-cols-3 gap-4">
                            <div v-for="(contact, index) in contacts.data" :key="contact.id"
                                class="rounded-md border border-gray-200 bg-white p-2.5 hover:border-gray-400 sm:rounded-lg sm:p-5">
                                <div class="relative flex w-full">
                                    <VueLoaderImage src="/assets/images/contact.svg" width="45px" height="45px"
                                        class="size-10" :class="{ 'grayscale': (contact.active == 0) }">
                                    </VueLoaderImage>
                                    <div class='flex flex-col justify-between flex-grow gap03 px-2'>
                                        <span
                                            class="text-md mb-0 font-semibold text-gray-900 hover:text-black  sm:text-xl">
                                            {{ contact.name }}
                                        </span>

                                        <div class="grid grid-cols-2">
                                            <span class="text-sm leading-normal text-gray-400 sm:block">
                                                {{ trans('contacts.sales_times') }} : {{ contact.sales_count }}
                                            </span>
                                            <span class="text-sm leading-normal text-gray-400 sm:block">
                                                {{ trans('contacts.purchases_times') }} : {{ contact.purchases_count }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-md  mt-3" role="group">
                                    <Link :href="route('contacts.edit', contact.id)"
                                        class="text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 me-2 mb-2">
                                    <POSIcon name="PencilSquareIcon" />
                                    {{ trans('btns.edit') }}
                                    </Link>
                                    <POSButton type="button" @click="deleteContact(contact.id)"
                                        :text="trans('btns.delete')">
                                        <POSIcon name="TrashIcon" />
                                    </POSButton>
                                </div>
                            </div>
                        </div>
                        <!-- End : Category Card -->

                        <!-- Start : Empty Data -->
                        <div v-if="contacts.data.length == 0" class="flex justify-center flex-col items-center">
                            <img src="/assets/images/no-data.svg" class="h-80" alt="">
                            <h5 class="text-gray-400">{{ trans('contacts.no_contacts') }}</h5>
                        </div>
                        <!-- End : Empty Data -->

                        <!-- Start : Pagination -->
                        <div class="mt-5" v-if="contacts.data.length > 0">
                            <!-- <POSPagination :pagination="contacts" /> -->
                        </div>
                        <!-- End : Pagination -->
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
