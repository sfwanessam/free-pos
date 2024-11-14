<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { router as Router } from '@inertiajs/vue3';
import { POSInputError, POSPagination, POSHintedCheckbox, POSAlerts, POSToast, POSBreadcrumbItem, POSTextInput, POSSelectInput, POSInputLabel, POSFileInput, POSButton, POSIcon } from '@/Components';
import VueLoaderImage from 'vue3-loader-image';
import 'vue3-loader-image/dist/style.css';
import Swal from 'sweetalert2';
import { trans } from 'laravel-vue-i18n';


const props = defineProps({
    products: {
        type: Object,
    },
    search: {
        type: String
    }
});


const form = useForm({
    search: props.search
});




const search = () => {
    Router.get(route('catalog.products.index'), (form.search.length > 0 ? { search: form.search } : {}), { replace: true, preserveState: true })
};


const deleteProduct = (productId) => {
    trans('products.delete_alert_title')
    Swal.fire({
        title:
            trans('products.delete_alert_title'),
        text: trans('products.delete_alert_desc'),
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#5B21B6",
        cancelButtonColor: "#d33",
        confirmButtonText: trans('btns.confirm')
    }).then((result) => {
        if (result.isConfirmed) {
            Router.delete(route('catalog.products.destroy', productId));
        }
    });
};

const clearSearch = () => {
    form.search = '';
    search();
};



</script>

<template>

    <Head title="Dashboard" />

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
                            <POSBreadcrumbItem :label="$t('products.title')" />
                        </ol>
                    </nav>
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
                        {{ $t('products.products_list') }}
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
                                :placeholder="$t('products.search_for_products')" required />
                            <button type="button" @click="search"
                                class="text-white absolute end-2.5 bottom-2.5 bg-violet-800 hover:bg-violet-800 focus:ring-4 focus:outline-none focus:ring-violet-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-violet-600 dark:hover:bg-violet-700 dark:focus:ring-violet-800">
                                {{ $t('btns.search') }}
                            </button>
                        </div>
                        <!-- End : Search Input Group -->

                        <!-- Start : Search Results Hint -->
                        <div class="pt-2 flex" v-if="props.search != null">
                            {{ $t('products.search_results_for') }} : {{ props.search }}
                            <Link type="button" @click="clearSearch"
                                class="ms-5 flex font-medium text-pink-600 dark:text-pink-500 hover:underline">
                            {{ $t('btns.reset') }}
                            </Link>
                        </div>
                        <!-- End : Search Results Hint -->

                    </div>


                    <!-- Start : Add New Category Link -->
                    <Link :href="route('catalog.products.create')"
                        class="text-white bg-violet-800 hover:bg-violet-700	 focus:ring-4 focus:ring-violet-300  font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-violet-600 dark:hover:bg-violet-800 focus:outline-none dark:focus:ring-violet-800">
                    <POSIcon name="PlusIcon" />
                    {{ $t('products.new_product') }}
                    </Link>
                    <!-- End : Add New Category Link -->
                </div>

                <!-- Start : Session Alerts Area -->
                <div class="mt-3">
                    <POSAlerts />
                </div>
                <!-- End : Session Alerts Area -->
            </div>
        </div>
        <div class="flex flex-col bg-white">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600"
                            v-if="products.data.length > 0">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        {{ $t('products.product') }}
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                        {{ $t('products.category') }}
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                        {{ $t('products.active_status') }}
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                        {{ $t('products.stock') }}
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                        {{ $t('products.sale_price') }}
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                        {{ $t('products.last_purchase_price') }}
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">

                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700"
                                    v-for="(product, index) in products.data" :key="product.id">
                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        <div class="text-base font-semibold text-gray-900 dark:text-white">
                                            <div class="relative flex w-full p-0">
                                                <VueLoaderImage :src="product.image_path" width="40px" height="40px"
                                                    class="" :class="{ 'grayscale': (product.active == 0) }">
                                                </VueLoaderImage>
                                                <div class='flex flex-col justify-between flex-grow gap03 px-2'>
                                                    <span
                                                        class="text-md mb-0 font-semibold text-gray-900 hover:text-black  sm:text-md">
                                                        {{ product.name }}
                                                    </span>
                                                    <span class="text-sm leading-normal text-gray-400 sm:block">
                                                        {{ (product.is_a_service == 1 ? $t('products.service_product') :
                                                            $t('products.stocked_product'))
                                                        }}

                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                    <td
                                        class="p-4 text-base text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ product.category_name }}</td>
                                    <td
                                        class="max-w-sm text-center p-4 overflow-hidden text-base font-normal text-gray-500 truncate xl:max-w-xs dark:text-gray-400">
                                        {{ (product.active == 1 ? $t('products.active') : $t('products.disactive')) }}
                                    </td>
                                    <td
                                        class="p-4 text-base text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ product.stock_quantity + ' ' + product.unit }}</td>
                                    <td
                                        class="p-4 text-base text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ product.price }}</td>
                                    <td
                                        class="p-4 text-base text-center justify-center flex items-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ product.last_purchase_price }}
                                        <img v-if="product.last_purchase_price == null" src="/assets/images/monitor.svg"
                                            height="10px" />
                                    </td>

                                    <td class="p-4 space-x-2 whitespace-nowrap">
                                        <Link :href="route('catalog.products.edit', product.id)"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center  rounded-lg text-gray-900 bg-white hover:bg-gray-100 border border-gray-200">
                                        <POSIcon name="PencilSquareIcon" />
                                        </Link>
                                        <POSButton type="button" @click="deleteProduct(product.id)">
                                            <POSIcon name="TrashIcon" />
                                        </POSButton>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Start : Empty Data -->
            <div v-if="products.data.length == 0" class="flex justify-center flex-col items-center">
                <img src="/assets/images/no-data.svg" class="h-80" alt="">
                <h5 class="text-gray-400">{{ $t('products.no_products') }}</h5>
            </div>
            <!-- End : Empty Data -->

            <!-- Start : Pagination -->
            <div class="mx-2 my-3">
                <POSPagination :pagination="products" />
            </div>
            <!-- End : Pagination -->
        </div>






    </AuthenticatedLayout>
</template>
