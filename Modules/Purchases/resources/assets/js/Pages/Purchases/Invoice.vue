<script setup>
import InvoiceLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { POSInputError, POSCounterInput, POSAlerts, POSToast, POSBreadcrumbItem, POSDatePickerField, POSTextInput, POSNumberInput, POSSelectInput, POSInputLabel, POSFileInput, POSButton, POSIcon } from '@/Components';
import vSelect from "vue-select";
import { reactive, onMounted, watch, watchEffect, computed } from "vue";
import Decimal from 'decimal.js';

import 'vue-select/dist/vue-select.css';


const props = defineProps({
    contacts: {
        type: Object,
    },
    products: {
        type: Object,
    },
    invoice: {
        type: Object,
    }
});

const form = useForm({
    id: props.invoice?.id ?? 0,
    invoice_number: props.invoice?.invoice_number ?? null,
    contact_id: props.invoice?.contact_id ?? null,
    sub_total: props.invoice?.sub_total ?? new Decimal(0).toFixed(2),
    tax: props.invoice?.tax ?? new Decimal(0).toFixed(2),
    discount: props.invoice?.discount ?? new Decimal(0).toFixed(2),
    grand_total: props.invoice?.grand_total ?? new Decimal(0).toFixed(2),
    status: props.invoice?.status ?? 'new',
    payment_type: props.invoice?.payment_type ?? 'cash',
    invoice_date: props.invoice?.invoice_date ?? '',
    items: props.invoice?.items ?? []
});

// تحويل `products` إلى مصفوفة باستخدام `computed`

const state = reactive({
    contactOptions: props.contacts.data,
    productsOptions: props.products.data,
    rowIsRendered: false,
    selectedProduct: ""
});








const submit = () => {
    form.post(route('purchases.invoices.store'));
};

const onContactSearch = (search, loading) => {
    if (search.length) {
        loading(true);
        contactSearch(loading, search);
    }
}

const contactSearch = async (loading, search) => {
    await axios.get(route('api.purchases.contact_search'), { params: { name: search } })
        .then(function (response) {
            state.contactOptions = response.data.data;
            loading(false);
        })
        .catch(function (error) {
            console.log(error)
        });
};


const onProductSearch = (search, loading) => {
    if (search.length) {
        loading(true);
        productSearch(loading, search);
    }
}

const productSearch = async (loading, search) => {
    await axios.get(route('api.purchases.product_search'), { params: { name: search } })
        .then(function (response) {
            state.productsOptions = response.data.data;
            loading(false);
        })
        .catch(function (error) {
            console.log(error)
        });
};


const createNewContact = (search, searching, loading) => {
    loading = true;
}







const updateItemProduct = (item, product) => {
    state.selectedProduct = "";
    let zero = new Decimal(0).toFixed(2);

    const existsItem = form.items.find(item => item.product_id === product.id);

    if (!existsItem) {
        // Add new item to items array
        form.items.push({ id: 0, product_id: product.id, product: { id: product.id, name: product.name }, quantity: 1, price: zero, sub_total: zero, tax_amount: zero, total: zero });
    } else {
        // Optional: alert or handle case where item already exists
        existsItem.quantity += 1;
    }
}

const removeItem = (index) => {
    form.items.splice(index, 1);
};



const calcItemsAmount = () => {
    console.log('on calcItemsAmount');
    let invoice_sub_total = new Decimal(0);
    let invoice_tax = new Decimal(0);
    let invoice_discount = new Decimal(0);
    let invoice_grand_total = new Decimal(0);

    form.items.forEach((item) => {
        // تحويل القيم إلى Decimal لضمان الدقة
        const quantity = new Decimal(item.quantity);
        const price = new Decimal(item.price);

        // حساب المجموع الفرعي
        const sub_total = quantity.mul(price);
        // حساب مبلغ الضريبة بنسبة 15%
        const tax_amount = sub_total.mul(0.15);
        // حساب الإجمالي بجمع المجموع الفرعي ومبلغ الضريبة
        const total = sub_total.plus(tax_amount);

        // تعيين القيم المحسوبة إلى الكائن item مع تحديد دقتين عشريتين
        item.sub_total = sub_total.toFixed(2);
        item.tax_amount = tax_amount.toFixed(2);
        item.total = total.toFixed(2);

        // تحديث إجماليات الفاتورة
        invoice_sub_total = invoice_sub_total.plus(sub_total);
        invoice_tax = invoice_tax.plus(tax_amount);
        invoice_grand_total = invoice_grand_total.plus(total);
    });

    // تعيين القيم المحسوبة للفاتورة ككل
    form.sub_total = invoice_sub_total.toFixed(2);
    form.tax = invoice_tax.toFixed(2);
    form.grand_total = invoice_grand_total.toFixed(2);
};




watch(
    () => form.items,
    (newValue, oldValue) => {
        calcItemsAmount();
    },
    { deep: true }
)





</script>

<template>

    <Head :title="$t('purchases.invoice')" />

    <InvoiceLayout>

        <div
            class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
            <div class="w-full mb-1">
                <div class="mb-4">
                    <nav class="flex mb-5" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                            <POSBreadcrumbItem :isHome="true" :url="route('dashboard')"
                                :label="$t('dashboard.title')" />
                            <POSBreadcrumbItem :url="route('purchases.invoices.index')"
                                :label="$t('purchases.title')" />
                            <POSBreadcrumbItem :label="$t('purchases.invoice')" />
                        </ol>
                    </nav>

                    <div class="grid grid-cols-2">
                        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">{{
                            $t('purchases.invoice') }} {{ invoice?.id > 0 ? invoice.invoice_number : 'New' }}</h1>

                        <div class="text-end">
                            <!-- Start : Add New Category Link -->
                            <POSButton @click="submit" type="button" skin="color" :text="$t('btns.save')">
                                <POSIcon name="CheckIcon" class="size-6 me-1" />
                            </POSButton>

                            <Link :href="route('purchases.invoices.index')"
                                class="inline-flex ms-2 items-center px-3 py-2 text-sm font-medium text-center text-gray rounded-lg bg-white border border-gray-300 focus:ring-4 ">
                            <POSIcon name="XMarkIcon" class="size-6 me-1" />
                            {{ $t('btns.cancel') }}
                            </Link>
                            <!-- End : Add New Category Link -->
                        </div>
                    </div>
                </div>


                <div class="w-full">
                    <POSAlerts />
                </div>



                <div class="pb-3" v-if="form.active == 0">
                    <POSToast type="warning" :text="$t('products.disactive_warning')" />
                </div>



                <div class="grid grid-cols-12 gap-4">
                    <form @submit.prevent="submit" class="col-span-12">
                        <div class="space-y-4  w-full">
                            <div class="pb-3">
                                <div class="bg-gray-50 px-2 py-4 border border-gray-200 shadow-md sm:rounded-lg">
                                    <div class="grid grid-cols-12 gap-4">
                                        <div class="col-span-5">
                                            <POSInputLabel forName="contact_id" :value="$t('purchases.supplier')" />
                                            <vSelect :options="state.contactOptions" label="name"
                                                v-model="form.contact_id" :reduce="contact => contact.id"
                                                @search="onContactSearch" :placeholder="$t('purchases.select_supplier')"
                                                class="style-chooser style-chooser-product">
                                                <template #no-options="{ search, searching, loading }">
                                                    <a target="_blank" v-if="search.length == 0"
                                                        :href="route('contacts.create')">{{
                                                            $t('invoice.add_new_contact')
                                                        }}</a>
                                                    <button v-if="search.length > 0" type="button"
                                                        @click="createNewContact(search, searching, loading)"> {{
                                                            $t('invoice.add_new_contact') }} {{
                                                            search }}
                                                    </button>
                                                </template>
                                            </vSelect>
                                            <POSInputError class="mt-1" :message="form.errors.contact_id" />
                                        </div>

                                        <div class="col-span-3">
                                            <POSInputLabel forName="note" :value="$t('invoice.payment.type')" />
                                            <POSSelectInput class="bg-white" v-model="form.payment_type">
                                                <option value="cash">{{ $t('invoice.payment.cash') }}</option>
                                                <option value="card">{{ $t('invoice.payment.card') }}</option>
                                            </POSSelectInput>
                                            <POSInputError class="mt-1" :message="form.errors.note" />
                                        </div>
                                        <div class="col-span-4">
                                            <POSInputLabel forName="invoice_date" :value="$t('invoice.invoice_date')" />


                                            <POSDatePickerField datepickerId="invoice-date" />

                                            <POSInputError class="mt-1" :message="form.errors.note" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pb-3">
                                <div class="grid grid-cols-12 gap-4">
                                    <div class="col-span-5">
                                        <POSInputLabel forName="name" :value="$t('invoice.product_name_barcode')" />
                                        <vSelect :options="state.productsOptions" label="name" @search="onProductSearch"
                                            @option:selected="(product) => updateItemProduct(item, product)"
                                            v-model="state.selectedProduct" :reduce="product => product.id"
                                            :selectable="(product) => !form.items.find(item => item.product_id === product.id)"
                                            :placeholder="$t('invoice.select_product')" class="style-chooser">
                                            <template #no-options="{ search, searching, loading }">
                                                <a target="_blank" v-if="search.length > 0"
                                                    :href="route('catalog.products.create')">{{
                                                        $t('invoice.add_new_product') + ' : ' + search
                                                    }}</a>
                                                <h6 v-if="search.length == 0" class="text-red-700">{{
                                                    $t('invoice.there_is_no_products') }}</h6>
                                            </template>
                                        </vSelect>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">{{
                                            $t('invoice.enter_product_name_or_barcode_to_add') }}</p>
                                        <POSInputError class="mt-1" :message="form.errors.contact_id" />
                                    </div>
                                </div>
                            </div>
                            <div class=" shadow-md sm:rounded-lg">
                                <table
                                    class="w-full  text-sm text-left rtl:text-right border border-gray-200 text-gray-500 dark:text-gray-400">
                                    <thead class="bg-gray-100 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col"
                                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                                {{ $t('invoice.product') }}</th>
                                            <th scope="col"
                                                class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                                {{ $t('invoice.qty') }}</th>
                                            <th scope="col"
                                                class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                                {{ $t('invoice.unit_price') }}</th>
                                            <th scope="col"
                                                class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                                {{ $t('invoice.subtotal') }}</th>
                                            <th scope="col"
                                                class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                                {{ $t('invoice.tax_amount') }}</th>

                                            <th scope="col"
                                                class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                                {{ $t('invoice.total') }}</th>
                                            <th scope="col"
                                                class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody
                                        class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                        <tr v-for="(item, index) in form.items"
                                            class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td width="30%"
                                                :class="{ 'bg-red-100': (form.errors['items.' + index + '.product_id'] != null) }"
                                                class="px-4 py-2 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">


                                                {{ item.product?.name }}



                                            </td>
                                            <td :class="{ 'bg-red-100': (form.errors['items.' + index + '.quantity'] != null) }"
                                                class="px-4 text-sm font-normal  justify-center  text-center text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                <POSCounterInput :disabled="(item.product_id == 0)"
                                                    v-model="item.quantity" :min="1" :max="999" />
                                            </td>
                                            <td width="100px"
                                                :class="{ 'bg-red-100': (form.errors['items.' + index + '.price'] != null) }"
                                                class="px-0 text-sm font-normal text-center text-gray-500 justify-center whitespace-nowrap dark:text-gray-400">
                                                <POSNumberInput :disabled="(item.product_id == 0)" v-model="item.price"
                                                    :bordered="false" :bg="false" />
                                            </td>

                                            <td
                                                class="px-4 text-sm font-normal text-center text-gray-500 justify-center whitespace-nowrap dark:text-gray-400">
                                                {{ item.sub_total }}</td>
                                            <td
                                                class="px-4 text-sm font-normal text-center text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{ item.tax_amount }}</td>
                                            <td
                                                class="px-4 text-sm font-normal text-center text-gray-500 justify-center whitespace-nowrap dark:text-gray-400">
                                                {{ item.total }}</td>
                                            <td
                                                class="px-4 text-sm font-normal text-center text-gray-500 justify-center whitespace-nowrap dark:text-gray-400">
                                                <POSButton type="button" class="border-0" @click="removeItem(index)">
                                                    <POSIcon name="TrashIcon" />
                                                </POSButton>
                                            </td>
                                        </tr>





                                    </tbody>

                                </table>

                                <div class="py-2 px-4 grid grid-cols-4">
                                    <div class="text-center  py-3">
                                        <h5 class="text-gray-400">{{ $t('invoice.sub_total') }}</h5>
                                        <h2 class="text-2xl font-bold text-gray-600">{{ form.sub_total }}</h2>
                                    </div>

                                    <div class="text-center border border-s-1 border-e-1 border-t-0 border-b-0  py-3">
                                        <h5 class="text-gray-400">{{ $t('invoice.discount') }}</h5>
                                        <h2 class="text-2xl font-bold text-gray-600">{{ form.discount }}</h2>
                                    </div>

                                    <div class="text-center border border-e-1 border-s-0 border-t-0 border-b-0 py-3">
                                        <h5 class="text-gray-400">{{ $t('invoice.tax') }}</h5>
                                        <h2 class="text-2xl font-bold text-gray-600">{{ form.tax }}</h2>
                                    </div>

                                    <div class="text-center  py-3">
                                        <h5 class="text-gray-400">{{ $t('invoice.grand_total') }}</h5>
                                        <h2 class="text-2xl font-bold text-gray-600">{{ form.grand_total }}</h2>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </InvoiceLayout>
</template>




<style>
.style-chooser .vs__search::placeholder,
.style-chooser .vs__dropdown-toggle,
.style-chooser .vs__dropdown-menu {
    background: #f9fafb;
    color: #394066;
    text-transform: lowercase;
    font-variant: small-caps;
    padding: 2px 5px 9px 5px;
    background: #f9fafb;
    border-radius: 0.375rem;
}


.style-chooser-product .vs__search::placeholder,
.style-chooser-product .vs__dropdown-toggle,
.style-chooser-product .vs__dropdown-menu {
    background: #fff;
}

.style-chooser .vs__clear,
.style-chooser .vs__open-indicator {
    fill: #394066;
}
</style>