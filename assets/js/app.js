import Vue from 'vue'
import App from './components/App.vue'
import VueHtml2Canvas from 'vue-html2canvas';
import babelPolyfill from 'babel-polyfill'
import axios from 'axios'
import VueAxios from 'vue-axios'

Vue.use(VueAxios, axios)
Vue.use(VueHtml2Canvas);

new Vue({
  el: '#app',
  components: {App}
});