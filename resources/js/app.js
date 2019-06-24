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
import moment from 'moment';
import VueProgressBar from 'vue-progressbar';
import Swal from 'sweetalert2';
import vSelect from 'vue-select';
import Gate from "./Gate";
import VeeValidate from 'vee-validate';

Vue.use(VeeValidate);

Vue.prototype.$gate = new Gate(window.roles, window.permissions, window.stores);
Vue.prototype.$user = document.querySelector("meta[name='user']").getAttribute('content');


Vue.use(VueRouter)
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

window.Form = Form;

let routes = [
  { path: '/dashboard', component: require('./components/Dashboard.vue').default, meta: { title: 'ড্যাশবোর্ড'} },

  { path: '/profile', component: require('./components/User/Profile.vue').default, meta: { title: 'প্রোফাইল'} },

  { path: '/users', component: require('./components/Admin/Users.vue').default, meta: { title: 'ব্যবহারকারী তালিকা'}},
  { path: '/roles', component: require('./components/Admin/Roles.vue').default, meta: { title: 'ব্যবহারকারী ধরন'} },
  { path: '/stores', component: require('./components/Admin/Stores.vue').default, meta: { title: 'দোকানের তালিকা'} },

  { path: '/store/:token/:code', component: require('./components/Store/Store.vue').default, meta: { title: 'দোকান'}, name: 'singleStore'},
  { path: '*', component: require('./components/404.vue').default, meta: { title: '404'} },
]

const router = new VueRouter({
  mode: 'history',
  routes // short for `routes: routes`
})


router.beforeEach((to, from, next) => {
  document.title = to.meta.title;
  next();
});


Vue.filter('date', function(date) {
	return moment(date).format('MMMM D, YYYY');
})

Vue.filter('activation_status', function(activation_status) {
	if(activation_status == 0) {
		return 'প্রক্রিয়াধীন';
	} else {
		return 'অনুমোদিত';
	}
})

Vue.filter('payment_status', function(payment_status) {
	if(payment_status == 0) {
		return 'অপরিশোধিত';
	} else {
		return 'পরিশোধিত';
	}
})

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

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('v-select', vSelect);
Vue.component('forbidden-403', require('./components/403.vue').default);


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
      profileNavImageLink: '/images/profile.png',
    },
    methods: {
      searchIt: _.debounce(() => {
        Fire.$emit('searching');
      }, 1000),
      changeStoreName() {
        Fire.$emit('changingstorename');
      },
      toggleTreeMenu() {
      	
      },
      getUserProfilePhotoOnNav() {
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

    created() {
    	this.getUserProfilePhotoOnNav();

      Fire.$on('updateuserdpinnav', () => {
        this.getUserProfilePhotoOnNav();
      });

      
    }
});
