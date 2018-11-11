/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import VueRouter from 'vue-router'
import router from './router'
import VeeValidate from 'vee-validate'
require('./bootstrap');

window.Vue = require('vue');
Vue.use(VueRouter)
var VeeConfig = {
    strict: false
}
Vue.use(VeeValidate, VeeConfig);

import AppHeader from './admin/components/layouts/partials/header';
import AppFooter from './admin/components/layouts/partials/footer';
import AppSidebar from './admin/components/layouts/partials/sidebar';
Vue.component('app-header', AppHeader);
Vue.component('app-footer', AppFooter);
Vue.component('app-sidebar', AppSidebar);


import ErrorHepler from './helpers/errors';
window.ErrorHelper = ErrorHepler;
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const files = require.context('./', true, /\.vue$/i)

// files.keys().map(key => {
//     return Vue.component(_.last(key.split('/')).split('.')[0], files(key))
// })

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router: router
});
