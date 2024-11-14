<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { POSInputError, POSHintedCheckbox, POSAlerts, POSToast, POSBreadcrumbItem, POSTextInput, POSSelectInput, POSInputLabel, POSFileInput, POSButton, POSIcon } from '@/Components';


const props = defineProps({
    categories: {
        type: Object,
    }
});

const form = useForm({
    name: null,
    category_id: '',
    image: null,
    is_a_service: 0,
    active: 1,
    price: 0.00,
    unit: null,
    barcode: null,
});


const change = (e) => {
    form.image = e.target.files[0];
};

const submit = () => {
    form.post(route('catalog.products.store'));

};
</script>

<template>

    <Head :title="$t('products.new_product')" />

    <AuthenticatedLayout>

        <div
            class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
            <div class="w-full mb-1">
                <div class="mb-4">
                    <nav class="flex mb-5" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                            <POSBreadcrumbItem :isHome="true" :url="route('dashboard')"
                                :label="$t('dashboard.title')" />
                            <POSBreadcrumbItem :url="route('catalog.products.index')" :label="$t('products.title')" />
                            <POSBreadcrumbItem :label="$t('products.new_product')" />
                        </ol>
                    </nav>
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">{{
                        $t('products.new_product') }}</h1>
                </div>


                <div class="w-full">
                    <POSAlerts />
                </div>

                <div class="pb-3" v-if="form.active == 0">
                    <POSToast type="warning" :text="$t('products.disactive_warning')" />
                </div>



                <div class="grid grid-cols-2">
                    <form @submit.prevent="submit">
                        <div class="space-y-4">
                            <div class="pt-1">
                                <POSInputLabel forName="name" :value="$t('products.product_name')" />
                                <POSTextInput v-model="form.name" name="name"
                                    :placeholder="$t('products.product_name_placeholder')" />
                                <POSInputError class="mt-1" :message="form.errors.name" />
                            </div>

                            <div class="pt-1 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <POSInputLabel forName="category" :value="$t('products.category')" />
                                    <POSSelectInput v-model="form.category_id" name="category_id">
                                        <option value="" selected>{{ $t('products.select_category') }}</option>
                                        <option :value="category.id" :key="category.id"
                                            v-for="(category, index) in categories">{{ category.name }}</option>
                                    </POSSelectInput>
                                    <POSInputError class="mt-1" :message="form.errors.category_id" />
                                </div>

                                <div>
                                    <POSInputLabel forName="unit" :value="$t('products.unit')" />
                                    <POSTextInput v-model="form.unit" name="unit"
                                        :placeholder="$t('products.product_unit_placeholder')" />
                                    <POSInputError class="mt-1" :message="form.errors.unit" />
                                </div>
                            </div>

                            <div class="pt-1">
                                <POSInputLabel forName="image" :value="$t('products.image')" />
                                <POSFileInput name="image" @input="change" />
                                <div class="mt-1 text-sm text-gray-500 dark:text-gray-300">{{ $t('products.image_hint')
                                    }}</div>
                                <POSInputError class="mt-1" :message="form.errors.image" />
                            </div>


                            <div class="pt-1">
                                <POSInputLabel forName="barcode" :value="$t('products.barcode')" />
                                <POSTextInput v-model="form.barcode" name="barcode"
                                    :placeholder="$t('products.product_barcode_placeholder')" />
                                <POSInputError class="mt-1" :message="form.errors.barcode" />
                            </div>

                            <div class="pt-1">
                                <POSHintedCheckbox v-model="form.is_a_service" name="is_a_service"
                                    :label="$t('products.product_is_a_service')"
                                    :hint="$t('products.product_is_a_service_hint')" />
                            </div>

                            <div class="pt-1 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <POSInputLabel forName="price" :value="$t('products.sale_price')" />
                                    <POSTextInput v-model="form.price" name="price" />
                                    <POSInputError class="mt-1" :message="form.errors.price" />
                                </div>
                                <div>
                                    <POSInputLabel forName="active" :value="$t('products.active_status')" />
                                    <POSSelectInput v-model="form.active">
                                        <option value="1">{{ $t('products.active') }}</option>
                                        <option value="0">{{ $t('products.disactive') }}</option>
                                    </POSSelectInput>
                                </div>
                            </div>


                            <div class="pt-1">
                                <POSButton type="submit" skin="color" :text="$t('btns.save')">
                                    <POSIcon name="CheckIcon" class="size-6 me-1" />
                                </POSButton>

                                <Link :href="route('catalog.products.index')"
                                    class="inline-flex ms-2 items-center px-3 py-2 text-sm font-medium text-center text-gray rounded-lg bg-white border border-gray-300 focus:ring-4 ">
                                <POSIcon name="XMarkIcon" class="size-6 me-1" />
                                {{ $t('btns.cancel') }}
                                </Link>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>