
/*
 |--------------------------------------------------------------------------
 | Laravel Spark Bootstrap
 |--------------------------------------------------------------------------
 |
 | First, we will load all of the "core" dependencies for Spark which are
 | libraries such as Vue and jQuery. This also loads the Spark helpers
 | for things such as HTTP calls, forms, and form validation errors.
 |
 | Next, we'll create the root Vue application for Spark. This will start
 | the entire application and attach it to the DOM. Of course, you may
 | customize this script as you desire and load your own components.
 |
 */

require('spark-bootstrap');

require('./components/bootstrap');

import VueI18n from 'vue-i18n';//needed for calendar locale

import Sortable from 'vue-sortable';

Vue.use(Sortable);

Vue.use(VueI18n);

Vue.use(require('vue-moment'));
 
import {messages} from 'vue-bootstrap4-calendar'; // you can include your own translation here if you want!

import BootstrapVue from 'bootstrap-vue';

Vue.use(BootstrapVue);

import 'bootstrap-vue/dist/bootstrap-vue.css';
 
window.i18n = new VueI18n({
    locale: 'en',
    messages
});

var app = new Vue({
    mixins: [require('spark')],
    i18n
});
