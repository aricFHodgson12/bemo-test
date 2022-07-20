require('./bootstrap');
import Vue from 'vue';
window.Vue = require('vue');
  
import App from './components/App.vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import VModal from 'vue-js-modal'
import axios from 'axios';
import {routes} from './routes';
  

Vue.use(VModal)
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
  
const router = new VueRouter({
    mode: 'history',
    routes: routes
});
  
const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
});