
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
Vue.component('result-profile', require('./components/ResultProfile.vue'));
Vue.component('tab', require('./components/Tab.vue'));
Vue.component('search', require('./components/Search.vue'));
Vue.component('alert', require('./components/Alert.vue'));
Vue.component('images', require('./components/Image.vue'));
Vue.component('lang', require('./components/Lang.vue'));
Vue.component('tabs-central', require('./components/TabsCentral.vue'));
Vue.component('tab-central', require('./components/TabCentral.vue'));
Vue.component('toggle', require('./components/Toggle.vue'));
Vue.component('form-profile', require('./components/CreateProfil.vue'));
Vue.component('search-profile', require('./components/SearchProfil.vue'));
Vue.component('tab-profile', require('./components/TabProfil.vue'));
Vue.component('profile', require('./components/Profile.vue'));





const store = new Vuex.Store({
    modules: {
        a: Result,
    },
    state: {

    },
    mutations: {

    },

})

const app = new Vue({
    el: '#app',
    store,
    methods:
        {
            rechercher()
            {
                this.$store.commit('setrecherche',true),
                    this.$store.commit('setprofil',false),
                    this.$store.commit('setrechercherprofil',false)
            },

            profil()
            {
               if(this.$store.state.a.activateprofil)
               {
                   this.$store.commit('setrecherche',false),
                       this.$store.commit('setprofil',true),
                       this.$store.commit('setrechercherprofil',false)
               }
            },

            rechercherprofil()
            {
                if(this.$store.state.a.activaterecherche)
                {
                    this.$store.commit('setrecherche',false),
                        this.$store.commit('setprofil',false),
                        this.$store.commit('setrechercherprofil',true)
                }

            },
        }
});

var $dropdown = $('.is-dropdown');

$dropdown.click(function() {
         $(this).parent('.dropdown, .dropup').toggleClass('is-active');
});