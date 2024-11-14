<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { POSInputError, POSAlerts, POSToast, POSBreadcrumbItem, POSTextInput, POSSelectInput, POSInputLabel, POSFileInput, POSButton, POSIcon } from '@/Components';
import { trans } from 'laravel-vue-i18n';

const props = defineProps({
    category: {
        type: Object
    }
});




const form = useForm({
    id: props.category.data.id,
    name: props.category.data.name,
    image: null,
    active: props.category.data.active,
    _method: 'put'
});





const change = (e) => {
    form.image = e.target.files[0];
    console.log(form)
};

const submit = () => {
    form.post(route('catalog.categories.update', form.id));

};
</script>

<template>

    <Head :title="$t('categories.edit_category')" />

    <AuthenticatedLayout>

        <div
            class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
            <div class="w-full mb-1">
                <div class="mb-4">
                    <nav class="flex mb-5" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                            <POSBreadcrumbItem :isHome="true" :url="route('dashboard')"
                                :label="$t('dashboard.title')" />
                            <POSBreadcrumbItem :url="route('catalog.categories.index')"
                                :label="$t('categories.title')" />
                            <POSBreadcrumbItem :label="$t('categories.edit_category')" />
                        </ol>
                    </nav>
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">{{
                        $t('categories.edit_category') }}</h1>
                </div>


                <div class="w-full">
                    <POSAlerts />
                </div>

                <div class="pb-3" v-if="form.active == 0">
                    <POSToast type="warning" :text="$t('categories.disactive_warning')" />
                </div>



                <div class="grid grid-cols-2">
                    <form @submit.prevent="submit">
                        <div class="space-y-4">
                            <div class="pt-1">
                                <POSInputLabel forName="name" :value="$t('categories.category_name')" />
                                <POSTextInput v-model="form.name" name="name"
                                    :placeholder="$t('categories.category_name_placeholder')" />
                                <POSInputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <div class="pt-1">
                                <POSInputLabel forName="image" :value="$t('categories.image')" />
                                <POSFileInput name="image" @input="change" />
                                <div class="mt-1 text-sm text-gray-500 dark:text-gray-300">{{ $t('categories.image_hint')
                                    }}</div>
                                <POSInputError class="mt-2" :message="form.errors.image" />
                            </div>



                            <div class="pt-1">
                                <POSInputLabel forName="active" :value="$t('categories.active_status')" />
                                <POSSelectInput v-model="form.active">
                                    <option value="1">{{ trans('categories.active') }}</option>
                                    <option value="0">{{ trans('categories.disactive') }}</option>
                                </POSSelectInput>
                            </div>

                            <div class="pt-1">
                                <POSButton type="submit" skin="color" :text="$t('btns.save')">
                                    <POSIcon name="CheckIcon" class="size-6 me-1" />
                                </POSButton>

                                <Link :href="route('catalog.categories.index')"
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