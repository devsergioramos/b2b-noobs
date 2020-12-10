import Vue from 'vue'
import router from './router'
import App from './App'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import Vuelidate from "vuelidate"

// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(Vuelidate)
//Vue.use(router)

Vue.config.productionTip = false

/*const constRoutes = new Router({
  routes:[{
    path: '/',
    component: () => import('@/App')
  },{
      path: '/admin',
      component: () => import('@/pages/Admin')
    }]
})*/

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')
