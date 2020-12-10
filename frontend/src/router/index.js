import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

const home = {template:"<div>Home</div>"}
export default new Router({
    routes:[{
        path: '/admin',
        //children: [{
        name: "admin",
        component: home //() => import('@/pages/Admin')
        //}]
    }]
})