/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from "vue"
import {BootstrapVue, IconsPlugin} from "bootstrap-vue";

/* Ovo zakomentarisati da bi se koristila tema  */
// import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

window.Vue = require('vue');
window.Event = new Vue();

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('session-editor', require('./components/SessionEditor').default);
Vue.component('program-list', require('./components/ProgramList').default);
Vue.component('mentor-data', require('./components/MentorData').default);
Vue.component('program-sessions', require('./components/ProgramSessions').default);
Vue.component('tile-item', require('./components/TileItem').default);
Vue.component('session-editor-table', require('./components/SessionEditorTable').default);
Vue.component('event-generator', require('./components/EventGenerator').default);
Vue.component('mentor-sessions', require('./components/MentorSessions').default);
Vue.component('round-item', require('./components/RoundItem').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    mounted() {

    }
});
