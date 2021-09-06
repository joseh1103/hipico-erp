import Vue from 'vue'
import router from './router/index'
import App from './components/App'
import store from './store/index'
import './plugins'

//SELECT AUTO COMPLETE
import vSelect from 'vue-select'
Vue.component('v-select', vSelect)
import 'vue-select/dist/vue-select.css';
import 'vue-toastr-2/dist/vue-toastr-2.min.css'
import VueToastr2 from 'vue-toastr-2'
Vue.use(VueToastr2)

import { ToggleButton } from 'vue-js-toggle-button'
Vue.component('ToggleButton', ToggleButton);

import datePicker from 'vue-bootstrap-datetimepicker';
import 'bootstrap/dist/css/bootstrap.css';
import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
Vue.use(datePicker);

import tinymce from 'vue-tinymce-editor'
Vue.component('tinymce', tinymce)

import VueYouTubeEmbed from 'vue-youtube-embed'
Vue.use(VueYouTubeEmbed)
// if you don't want install the component globally
Vue.use(VueYouTubeEmbed, { global: true })

// VeeValidate
import es from 'vee-validate/dist/locale/es'
import VeeValidate, { Validator } from "vee-validate";
Vue.use(VeeValidate)
Validator.localize('es', es);

new Vue({
  el: '#app',
  store,
  router,
  ...App
})