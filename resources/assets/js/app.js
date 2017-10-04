
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./bootstrap-notify/bootstrap-notify.min.js');
require('./Animate/animate.css');


window.Vue = require('vue');
 Vue.use(VueResource);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 // var bus = new Vue()
 //
 // Vue.component('bell',{
 //   mounted(){
 //     bus.$on('cantNotificaciones', function (cant) {
 //       cantidad = cant
 //    })},
 //    data(){
 //      return{
 //           cantidad: 0,
 //      }
 //    },
 //    template: '<span class="badge bg-green" >{{cantidad}}</span>',
 //  });
 //
 //
 // const bell = new Vue({
 //     el: '#bell',
 // });


Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app',
});
