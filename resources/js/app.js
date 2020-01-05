
require('./bootstrap');

window.Vue = require('vue');
import { Form, HasError, AlertError } from 'vform'
import VueProgressBar from 'vue-progressbar'
import swal from 'sweetalert2'
import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';
import $ from 'jquery';

import moment from 'moment-timezone'

moment.tz.setDefault('Asia/Manila')

Vue.prototype.$moment = moment

window.$ = window.jQuery = $;

import 'jquery-ui/ui/widgets/datepicker.js';

$('.datepicker').datepicker();

window.swal = swal;

const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  onOpen: (toast) => {
    toast.addEventListener('mouseenter', swal.stopTimer)
    toast.addEventListener('mouseleave', swal.resumeTimer)
  }
})



window.toast = toast;

Vue.use(VueProgressBar, {
    color: '#bffaf3',
    failedColor: '#874b4b',
    thickness: '5px',
    transition: {
      speed: '0.2s',
      opacity: '0.6s',
      termination: 300
    }
})

window.Form = Form;

Vue.filter('myDate', function(created){
  return moment(created).format('YYYY-MM-DD hh:mm a');
})

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.component('VueCtkDateTimePicker', VueCtkDateTimePicker);

Vue.component('new-arrivals', require('./components/NewArrivals.vue').default);

Vue.component('add-new-button', require('./components/addNewButton.vue').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);


const app = new Vue({
    el: '#app',
});
