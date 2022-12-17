require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Northlink Scraper';

import easySpinner from 'vue-easy-spinner';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(easySpinner, {prefix: 'easy'})
            .mixin({ methods: { route } })
            .mixin({
                components: {
                    InertiaProgress,
                }
            })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
