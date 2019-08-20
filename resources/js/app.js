/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// my code started
// my code started
import VueRouter from 'vue-router';
import { Form, HasError, AlertError } from 'vform';
import VueProgressBar from 'vue-progressbar';
import Swal from 'sweetalert2';
import vSelect from 'vue-select';
import Gate from "./Gate";
import VeeValidate from 'vee-validate';
import VTooltip from 'v-tooltip';
import {filters} from './filters'
import {routes} from './routes'
import "chart.js"
import "hchs-vue-charts"
import FullCalendar from 'vue-full-calendar'

Vue.use(FullCalendar);
Vue.use(window.VueCharts);
Vue.use(VeeValidate);
Vue.use(VTooltip);

Vue.prototype.$gate = new Gate(window.roles, window.permissions, window.stores);
Vue.prototype.$user = document.querySelector("meta[name='user']").getAttribute('content');

Vue.use(VueRouter)
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

window.Form = Form;

const router = new VueRouter({
  mode: 'history',
  routes // short for `routes: routes`
})

router.beforeEach((to, from, next) => {
  document.title = to.meta.title;
  next();
});


Vue.use(VueProgressBar, {
  color: 'rgb(0, 190, 225)',
  failedColor: 'red',
  height: '2px'
})

window.swal = Swal;
const Toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});
window.toast = Toast;

window.Fire = new Vue();


Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('v-select', vSelect);
Vue.component('forbidden-403', require('./components/403.vue').default);

Vue.component('public-main', require('./components/Public/PublicMaster.vue').default);
Vue.component('admin-main', require('./components/Auth/AdminMaster.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app',
    router,
    data: {
      search: '',
      menuselected: undefined,
      profileNavImageLink: '/images/profile.png'
    },
    methods: {
      searchIt: _.debounce(() => {
        Fire.$emit('searching');
        // console.log('fired');
      }, 1000),
      changeStoreName() {
        Fire.$emit('changingstorename');
      },
      toggleTreeMenu() {
      	
      },
      getUserProfilePhotoOnNav() {
        if(this.$user) {
          var user_parsed = JSON.parse(this.$user);
          var user_id = user_parsed.id;
          axios.get('/api/user/'+user_id).then(
            ({ data }) => 
            (
              this.profileNavImageLink = '/images/users/'+data.image,
              $('#profileNavName').text(data.name )
            ));
        }
      },
    },

    created() {
    	this.getUserProfilePhotoOnNav();

      Fire.$on('updateuserdpinnav', () => {
        this.getUserProfilePhotoOnNav();
      });
    }
});
