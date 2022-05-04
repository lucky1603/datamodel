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
import VueApexCharts from "vue-apexcharts";

Vue.use(VueApexCharts);

window.Vue = require('vue').default;
window.Dispecer = new Vue();

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

window.$ = require('jquery');

// import ApexCharts from "apexcharts";

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('apexchart', VueApexCharts);
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
Vue.component('program-data', require('./components/ProgramData').default);
Vue.component('profile-item', require('./components/ProfileItem').default);
Vue.component('profile-explorer', require('./components/ProfileExplorer').default);
Vue.component('profile-form', require('./components/ProfileForm').default);
Vue.component('ntp-widget', require('./components/NtpWidget').default);
Vue.component('ntp-piechart', require('./components/NtpPieChart').default);
Vue.component('show-company-types', require('./components/ShowCompanyTypes').default);
Vue.component('find-criteria', require('./components/FindCriteria').default);
Vue.component('mentor-item', require('./components/MentorItem').default);
Vue.component('mentor-explorer', require('./components/MentorExplorer').default);
Vue.component('event-item', require('./components/EventItem').default);
Vue.component('event-explorer', require('./components/EventExplorer').default);
Vue.component('event-modifier', require('./components/EventModifier').default);
Vue.component('item-selector', require('./components/ItemSelector').default);
Vue.component('companies-selector', require('./components/CompaniesSelector').default);
Vue.component('application-statuses', require('./components/ShowCompanyApplicationStatuses').default);
Vue.component('bulk-mail', require('./components/BulkEmail').default);
Vue.component('report-editor', require('./components/ReportEditor').default);
Vue.component('report-explorer', require('./components/ReportExplorer').default);
Vue.component('report-item', require('./components/ReportItem').default);
Vue.component('file-group-editor', require('./components/FileGroupEditor').default);
Vue.component('file-item', require('./components/FileItem').default);
Vue.component('file-group-viewer', require('./components/FileGroupViewer').default);
Vue.component('session-item', require('./components/SessionItem').default);
Vue.component('mentor-reports-explorer', require('./components/MentorReportsExplorer').default);
Vue.component('mentor-report-item', require('./components/MentorReportItem').default);
Vue.component('mentor-report-editor', require('./components/MentorReportEditor').default);
Vue.component('event-form', require('./components/EventForm').default);
Vue.component('program-statistics-form', require('./components/ProgramStatisticsForm').default);
Vue.component('countries-selector', require('./components/CountriesSelector').default);
Vue.component('profile-explorer-table-view', require('./components/ProfileExplorerTableView').default);
Vue.component('profile-data', require('./components/ProfileData').default);
Vue.component('profile-statistics', require('./components/ProfileStatistics').default);
Vue.component('program-explorer-table-view', require('./components/ProgramExplorerTableView').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    methods: {
        profileClick(id) {
            window.location = '/profiles/' + id;
        }
    },
    mounted() {
        Dispecer.$on('profile-clicked', this.profileClick);
    }
});


