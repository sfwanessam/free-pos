<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { POSAlerts, POSPagination, POSBreadcrumbItem, POSIcon, POSButton, POSInputError } from '@/Components';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Log in d" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            Sign in to platform
        </h2>

        <form class="mt-8 space-y-6" @submit.prevent="submit">
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                    email</label>

                <input type="email" name="email" id="email" required autofocus autocomplete="username"
                    v-model="form.email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="name@company.com">


                <POSInputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                    password</label>
                <input type="password" name="password" id="password" v-model="form.password" required
                    autocomplete="current-password" placeholder="••••••••"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">


                <POSInputError class="mt-2" :message="form.errors.password" />
            </div>


            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="remember" aria-describedby="remember" name="remember" v-model="form.remember"
                        type="checkbox"
                        class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                </div>
                <div class="ml-3 text-sm">
                    <label for="remember" class="font-medium text-gray-900 dark:text-white">Remember me</label>
                </div>
                <Link v-if="canResetPassword" :href="route('password.request')"
                    class="ml-auto text-sm text-purple-700 hover:underline dark:text-primary-500">
                Forgot your password?
                </Link>

            </div>
            <button type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                class="w-full px-5 py-3 text-base font-medium text-center text-white bg-purple-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300  dark:bg-primary-600 dark:hover:bg-violet-800 dark:focus:ring-primary-800">Login
                to your account</button>
            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Not registered? <a class="text-primary-700 hover:underline dark:text-primary-500"
                    :href="route('register')">Create account</a>
            </div>

        </form>
    </GuestLayout>
</template>
