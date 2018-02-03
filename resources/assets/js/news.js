require('./bootstrap');

window.Vue = require('vue');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Vue from 'vue'
import App from './components/wx/news.vue'
// import ElementUI from 'element-ui'
// import 'element-ui/lib/theme-default/index.css'
// Vue.use(ElementUI)
// import {filters} from './filter'
// Object.keys(filters).forEach(key => {
//     Vue.filter(key, filters[key])
// })

const app = new Vue({
    el: '#app',
    render: h=>h(App)
});