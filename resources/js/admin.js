import Vue from 'vue'
import Admin from './views/Admin'
import VueRouter from 'vue-router'
import Vuelidate from 'vuelidate'
import { routes } from './routes/admin'
import auth from './service/Auth'
import Vuetify from 'vuetify'
import store from './store'

import ErrorAlert from './components/Alert/ErrorAlert'
import SuccessAlert from './components/Alert/SuccessAlert'
import PageWrapper from './components/PageWrapper/PageWrapper'
import Card from './components/Card/Card'
import UtilityCard from './components/Card/UtilityCard'
import CardSearchBar from './components/Card/CardSearchBar'

Vue.use(VueRouter);
Vue.use(Vuelidate);
Vue.use(Vuetify);
Vue.component('ErrorAlert',ErrorAlert)
Vue.component('SuccessAlert',SuccessAlert)
Vue.component('PageWrapper',PageWrapper)
Vue.component('UtilityCard',UtilityCard)
Vue.component('Card',Card)
Vue.component('CardSearchBar',CardSearchBar)

const router = new VueRouter({
  mode:'history',
  routes,
});

Vue.router = router

new Vue({
  el: '#app',
  router,
  store,
  render: h => h(Admin),

  created() {
    try {
      auth.refresh()
    } catch (err) {
      // Do nothing :))
    }
  }
})
.$mount('#app');