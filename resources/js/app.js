import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp, Link, Head } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import Layout from './Layouts/Dashboard/MainLayout.vue';
import LayoutLogin from './Layouts/Dashboard/MainLayoutLogin.vue';
import { translations } from './Mixins/base';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    resolve: name => {
      const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
      let page = pages[`./Pages/${name}.vue`]
      if(page == pages[`./Pages/Auth/Login.vue`]){
        page.default.layout ??= LayoutLogin
        return page
      }
      else{
        page.default.layout ??= Layout
        return page
      }
    },
      setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .component("Link", Link)
            .mixin(translations)
            .mount(el);
        },
        progress: {
            color: '#4B5563',
        },
  })
