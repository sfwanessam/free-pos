<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { POSInputError, POSTextarea, POSHintedCheckbox, POSAlerts, POSToast, POSBreadcrumbItem, POSTextInput, POSSelectInput, POSInputLabel, POSFileInput, POSButton, POSIcon } from '@/Components';



const form = useForm({
    type: 'individual',
    name: null,
    email: null,
    mobile_number: null,
    phone_number: null,
    phone_number: null,
    fax_number: null,
    address: null,
    note: null,
    sales_person_name: null,
    sales_person_email: null,
    sales_person_mobile_number: null,
    sales_person_note: null,
    purchase_person_name: null,
    purchase_person_email: null,
    purchase_person_mobile_number: null,
    purchase_person_note: null,
    default_on_sales: 0,
    default_on_purchases: 0,
});


const change = (e) => {
    form.image = e.target.files[0];
};

const submit = () => {
    form.post(route('contacts.store'));

};
</script>

<template>

    <Head :title="$t('contacts.new_contact')" />

    <AuthenticatedLayout>

        <div
            class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
            <div class="w-full mb-1">
                <div class="mb-4">
                    <nav class="flex mb-5" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                            <POSBreadcrumbItem :isHome="true" :url="route('dashboard')"
                                :label="$t('dashboard.title')" />
                            <POSBreadcrumbItem :url="route('contacts.index')" :label="$t('contacts.title')" />
                            <POSBreadcrumbItem :label="$t('contacts.new_contact')" />
                        </ol>
                    </nav>
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">{{
                        $t('contacts.new_contact') }}</h1>
                </div>


                <div class="w-full">
                    <POSAlerts />
                </div>




                <div class="grid grid-cols-2">
                    <form @submit.prevent="submit">
                        <div class="space-y-4">
                            <div class="pt-1">
                                <POSInputLabel forName="name" :value="$t('contacts.name')" />
                                <POSTextInput v-model="form.name" name="name"
                                    :placeholder="$t('contacts.contact_name_placeholder')" />
                                <POSInputError class="mt-1" :message="form.errors.name" />
                            </div>

                            <div class="pt-1">
                                <POSInputLabel forName="type" :value="$t('contacts.type')" />
                                <POSSelectInput v-model="form.type" name="type">
                                    <option value="individual" selected>{{ $t('contacts.individual') }}</option>
                                    <option value="company">{{ $t('contacts.company') }}</option>
                                </POSSelectInput>
                                <POSInputError class="mt-1" :message="form.errors.type" />
                            </div>

                            <div class="pt-1 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <POSInputLabel forName="email" :value="$t('contacts.email')" />
                                    <POSTextInput v-model="form.email" name="email" />
                                    <POSInputError class="mt-1" :message="form.errors.email" />
                                </div>

                                <div>
                                    <POSInputLabel forName="mobile_number" :value="$t('contacts.mobile_number')" />
                                    <POSTextInput v-model="form.mobile_number" name="mobile_number" />
                                    <POSInputError class="mt-1" :message="form.errors.mobile_number" />
                                </div>
                            </div>

                            <div class="pt-1 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <POSInputLabel forName="phone_number" :value="$t('contacts.phone_number')" />
                                    <POSTextInput v-model="form.phone_number" name="phone_number" />
                                    <POSInputError class="mt-1" :message="form.errors.phone_number" />
                                </div>

                                <div>
                                    <POSInputLabel forName="fax_number" :value="$t('contacts.fax_number')" />
                                    <POSTextInput v-model="form.fax_number" name="fax_number" />
                                    <POSInputError class="mt-1" :message="form.errors.fax_number" />
                                </div>
                            </div>

                            <div class="pt-1">
                                <POSInputLabel forName="address" :value="$t('contacts.address')" />
                                <POSTextInput v-model="form.address" name="address" />
                                <POSInputError class="mt-1" :message="form.errors.address" />
                            </div>

                            <div class="pt-1">
                                <POSInputLabel forName="note" :value="$t('contacts.note')" />
                                <POSTextarea v-model="form.note" name="note"
                                    :placeholder="$t('contacts.note_placeholder')" />
                                <POSInputError class=" mt-1" :message="form.errors.note" />
                            </div>



                            <div id="accordion-flush" data-accordion="collapse"
                                data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white"
                                data-inactive-classes="text-gray-500 dark:text-gray-400">
                                <h2 id="accordion-flush-heading-1">
                                    <button type="button"
                                        class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3"
                                        data-accordion-target="#accordion-flush-body-1" aria-expanded="false"
                                        aria-controls="accordion-flush-body-1">
                                        <span>{{ $t('contacts.sales_person_info') }}</span>
                                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M9 5 5 1 1 5" />
                                        </svg>
                                    </button>
                                </h2>
                                <div id="accordion-flush-body-1" class="hidden space-y-4"
                                    aria-labelledby="accordion-flush-heading-1">
                                    <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                                        <div class="pt-1">
                                            <POSInputLabel forName="sales_person_name"
                                                :value="$t('contacts.sales_person_name')" />
                                            <POSTextInput v-model="form.sales_person_name" name="sales_person_name" />
                                            <POSInputError class="mt-1" :message="form.errors.sales_person_name" />
                                        </div>

                                        <div class="pt-3 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <POSInputLabel forName="sales_person_email"
                                                    :value="$t('contacts.sales_person_email')" />
                                                <POSTextInput v-model="form.sales_person_email"
                                                    name="sales_person_email" />
                                                <POSInputError class="mt-1" :message="form.errors.sales_person_email" />
                                            </div>

                                            <div>
                                                <POSInputLabel forName="sales_person_mobile_number"
                                                    :value="$t('contacts.sales_person_mobile_number')" />
                                                <POSTextInput v-model="form.sales_person_mobile_number"
                                                    name="sales_person_mobile_number" />
                                                <POSInputError class="mt-1"
                                                    :message="form.errors.sales_person_mobile_number" />
                                            </div>
                                        </div>

                                        <div class="pt-3">
                                            <POSInputLabel forName="sales_person_note"
                                                :value="$t('contacts.sales_person_note')" />
                                            <POSTextarea v-model="form.sales_person_note" name="sales_person_note" />
                                            <POSInputError class=" mt-1" :message="form.errors.sales_person_note" />
                                        </div>
                                    </div>
                                </div>
                                <h2 id="accordion-flush-heading-1">
                                    <button type="button"
                                        class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3"
                                        data-accordion-target="#accordion-flush-body-2" aria-expanded="false"
                                        aria-controls="accordion-flush-body-2">
                                        <span>{{ $t('contacts.purchase_person_info') }}</span>
                                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M9 5 5 1 1 5" />
                                        </svg>
                                    </button>
                                </h2>
                                <div id="accordion-flush-body-2" class="hidden"
                                    aria-labelledby="accordion-flush-heading-1">
                                    <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                                        <div class="pt-1">
                                            <POSInputLabel forName="purchase_person_name"
                                                :value="$t('contacts.purchase_person_name')" />
                                            <POSTextInput v-model="form.purchase_person_name"
                                                name="purchase_person_name" />
                                            <POSInputError class="mt-1" :message="form.errors.purchase_person_name" />
                                        </div>

                                        <div class="pt-3 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <POSInputLabel forName="purchase_person_email"
                                                    :value="$t('contacts.purchase_person_email')" />
                                                <POSTextInput v-model="form.purchase_person_email"
                                                    name="purchase_person_email" />
                                                <POSInputError class="mt-1"
                                                    :message="form.errors.purchase_person_email" />
                                            </div>

                                            <div>
                                                <POSInputLabel forName="purchase_person_mobile_number"
                                                    :value="$t('contacts.purchase_person_mobile_number')" />
                                                <POSTextInput v-model="form.purchase_person_mobile_number"
                                                    name="purchase_person_mobile_number" />
                                                <POSInputError class="mt-1"
                                                    :message="form.errors.purchase_person_mobile_number" />
                                            </div>
                                        </div>

                                        <div class="pt-3">
                                            <POSInputLabel forName="purchase_person_note"
                                                :value="$t('contacts.purchase_person_note')" />
                                            <POSTextarea v-model="form.purchase_person_note"
                                                name="purchase_person_note" />
                                            <POSInputError class=" mt-1" :message="form.errors.purchase_person_note" />
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="py-1 px-2 border border-gray-300  bg-gray-50 rounded">
                                <POSHintedCheckbox v-model="form.default_on_sales" name="default_on_sales"
                                    :label="$t('contacts.default_on_sales')"
                                    :hint="$t('contacts.default_on_sales_hint')" />
                            </div>

                            <div class="mt-2 py-1 px-2 border border-gray-300  bg-gray-50 rounded">
                                <POSHintedCheckbox v-model="form.default_on_purchases" name="default_on_purchases"
                                    :label="$t('contacts.default_on_purchases')"
                                    :hint="$t('contacts.default_on_purchases_hint')" />
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