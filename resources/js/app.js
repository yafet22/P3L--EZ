import Vue from 'vue'
import App from './views/App'
import VueRouter from 'vue-router'
import { routes } from './routes/customer'
import Vuetify from 'vuetify'

Vue.use(VueRouter);
Vue.use(Vuetify);

const router = new VueRouter({
  mode:'history',
  routes,
});

Vue.router = router

new Vue({
  el: '#app',
  router,
  render: h => h(App),
})
.$mount('#app');