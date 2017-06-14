
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Form from './utilities/Form';
import Result from './store/modules/Result';

window.Form = Form;


Vue.component('example', require('./components/Example.vue'));
Vue.component('tabs', require('./components/Tabs.vue'));
Vue.component('result', require('./components/Result.vue'));
Vue.component('tab', require('./components/Tab.vue'));
Vue.component('search', require('./components/Search.vue'));
Vue.component('alert', require('./components/Alert.vue'));





const store = new Vuex.Store({
    modules: {
        a: Result,
    },
    state: {
        count: 0
    },
    mutations: {
        increment (state) {
            state.count++
        }
    }
})

const app = new Vue({
    el: '#app',
    store,
    methods:{
        /*search_result(result){
            tabs.result = result;
        }//*/
    }
});

var $dropdown = $('.is-dropdown');

$dropdown.click(function() {
         $(this).parent('.dropdown, .dropup').toggleClass('is-active');
});