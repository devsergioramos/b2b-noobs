import Vue from 'vue'
import Router from 'vue-router'
import Admin from '@/template/Admin'
import Site from '@/template/Site'
//import site from '@/views/Site'
import dashboard from '@/views/Dashboard'

Vue.use(Router)

export default new Router({
  mode: 'history',
    routes: [
      {
        path: '/',
        component: Site
      },
      {
        path: '/admin',
        component: Admin,
        children:[
          {
            path: '/admin/dashboard',
            component: dashboard
          }
        ]
      }
    ]
  })