/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.EventBus = new Vue();

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('conekta-card-payment', require('./components/ConektaCardPayment.vue').default);
Vue.component('conekta-oxxo-payment', require('./components/ConektaOxxoPayment.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        paymentMethod : "conekta-card-payment",
    	order : {
    		id : "MXN371599664762" ,
    		subject : "Realización de un evento de subasta" ,
    		total : "15" ,
    		meta: {
				asset : "Corre" ,
				date_award : "2020-09-06" ,
				time_award : "24:00:00" ,
				timezone : "America/Merida" ,
				number : "9999999999" ,
    		}
    	}
    },
    methods: {
        pay() {
            if(this.paymentMethod == 'conekta-card-payment'){
                EventBus.$emit('conektaCardPayment');
            }
            else if(this.paymentMethod == 'conekta-oxxo-payment'){
                EventBus.$emit('conektaOxxoPayment');
            }
        }
    }
});
