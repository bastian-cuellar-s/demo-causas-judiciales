/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


//Vue
import VueProgressBar from 'vue-progressbar'
import Vuex from 'vuex';
import StoreData from './store/store.js';

window.Vue = require('vue').default;

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
  });

Vue.use(Vuex);
const store = new Vuex.Store(StoreData);

/**
 * Routes imports and assigning
 */
 import VueRouter from 'vue-router';
 Vue.use(VueRouter);
 import {routes} from './routes.js';

 const router = new VueRouter({
    mode: 'history',
    routes
});


//Moment
import moment from 'moment';
window.moment = moment;

//vForm
import { Form, HasError, AlertError } from 'vform';
window.Form = Form;

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

//Gate
import Gate from "./Gate";
Vue.prototype.$gate = new Gate(window.user);

//Sweet alerts
import Swal from 'sweetalert2';

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })
window.Swal = Swal;
window.Toast = Toast;
window.Fire =  new Vue();

//Formateo de Rut
import { rutInputDirective } from 'vue-dni';

Vue.directive('rut', rutInputDirective);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 
// Components
Vue.component('pagination', require('laravel-vue-pagination'));

Vue.component('dashboard', require('./components/Dashboard.vue'));

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.component(
    'not-found',
    require('./components/NotFound.vue').default
);

import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';

Vue.component('VueCtkDateTimePicker', VueCtkDateTimePicker);

import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';

Vue.component('v-select', vSelect);


// Filter Section

Vue.filter('formatDate', function(value) {
    if (value) {
      return moment(String(value)).format('DD/MM/YYYY')
    }
  });

Vue.filter('yesno', value => (value ? '<i class="fas fa-check green"></i>' : '<i class="fas fa-times red"></i>'));

Vue.filter('upText', function(text){
    if(text){
    return text.charAt(0).toUpperCase() + text.slice(1)
    }
});

Vue.filter('truncate', function (text, length, suffix){
    if(text){
        return text.substring(0, length) + suffix;
    }
});
// end Filter

const app = new Vue({
    el: '#app',
    router,
    store,
});
