/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import App from './components/App.vue';

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);


const app = new Vue({
    el: '#root',
    components:{
        App
    }
});
