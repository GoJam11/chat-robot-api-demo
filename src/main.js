import Vue from 'vue'
import App from './App.vue'
import './plugins/element.js'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueResource from 'vue-resource'
Vue.use(VueAxios, axios, VueResource)
import VueJsonp from 'vue-jsonp'
Vue.use(VueJsonp)

Vue.config.productionTip = false


new Vue({
    render: h => h(App),
}).$mount('#app')