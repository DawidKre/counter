import babelPolyfill from 'babel-polyfill'
import VueAxios from 'vue-axios'
import axios from 'axios'
import Vue from "vue";
import './plugins/vuetify'
import App from "./App.vue";
import router from "./router";
import VueHtml2Canvas from 'vue-html2canvas'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import 'vuetify/src/stylus/app.styl'
import 'vuetify/dist/vuetify.min.css'

Vue.config.productionTip = false;

Vue.use(VueAxios, axios, VueHtml2Canvas);
axios.defaults.baseURL =  '/api/';

Vue.use(Vuetify,{
  theme: {
    primary: '#a300ee',
      secondary: '#424242',
      accent: '#82B1FF',
      error: '#FF5252',
      info: '#2196F3',
      success: '#4CAF50',
      warning: '#FFC107'
  },
  customProperties: true,
    iconfont: 'md',
});


new Vue({
  router,
  render: h => h(App)
}).$mount("#app");
