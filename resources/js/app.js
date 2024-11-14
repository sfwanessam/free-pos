import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { initFlowbite } from 'flowbite';
import { router } from '@inertiajs/vue3'
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import { i18nVue } from 'laravel-vue-i18n'; 
import vSelect from 'vue-select';
import {POSIcon } from '@/Components';


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';





createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name => {
        let parts = name.split('::')
        let type = false
        if (parts.length > 1) {
            type = parts[0]
        }
        if (type) {
            let nameVue = parts[1].split('.')[0];
            return resolvePageComponent(`../../Modules/${parts[0]}/resources/assets/js/Pages/${nameVue}.vue`, import.meta.glob([
                `../../Modules/**/resources/assets/js/Pages/**/*.vue`,
            ]));
        }else {
            return resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob([
                './Pages/**/*.vue',
            ]));
        }
    }),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(VueSweetalert2)
            .use(i18nVue, { 
        resolve: async lang => {
            const langs = import.meta.glob('../lang/*.json');
            return await langs[`../lang/${lang}.json`]();
        }
    })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
}).then(() => {
    // on first load
    initFlowbite();
});


router.on('success', (event) => {
  initFlowbite()
})
