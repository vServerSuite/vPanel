/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');

import Vuetify from 'vuetify';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import * as Sentry from '@sentry/browser';
import {
    Vue as VueIntegration
} from '@sentry/integrations';

Vue.use(Vuetify);
Vue.use(Toast, {
    position: 'bottom-right',
    newestOnTop: true,
    transition: 'Vue-Toastification__bounce',
    transitionDuration: 750,
    draggable: true,
    draggablePercent: 0.6,
    pauseOnHover: true
});
Sentry.init({
    dsn: process.env.MIX_SENTRY_VUE_DSN,
    integrations: [new VueIntegration({
        Vue,
        attachProps: true
    })],
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify({
        theme: {
            themes: {
                light: {
                    primary: '#3f51b5',
                    secondary: '#e91e63',
                    accent: '#00bcd4',
                    error: '#f44336',
                    warning: '#ff9800',
                    info: '#607d8b',
                    success: '#8bc34a'
                }
            }
        }
    })
});
