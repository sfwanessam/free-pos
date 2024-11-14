import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import i18n from 'laravel-vue-i18n/vite';

export default defineConfig({
    server:{
        hmr:'localhost'
    },
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/**/*.vue',
                'resources/**/**/*.vue',
                './Modules/**/resources/assets/js/**/*.vue',
                './Modules/**/resources/assets/js/**/**/*.vue',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        i18n() 
    ],
});
